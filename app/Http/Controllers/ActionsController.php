<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActionsController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if (Auth::attempt($request->only(['email', 'password']))) {
            $user = Auth::user();

            if ($user->wrongCounter === 3) {
                Auth::logout();

                return redirect()
                    ->route('login')
                    ->withErrors(['email' => 'Your account is locked due to too many failed login attempts.']);
            }

            if ($user->need_to_change_password) {
                return redirect()
                    ->route('login.change-password')
                    ->with('status', 'You need to change your password.');
            }

            return redirect()->route('dashboard');
        }

        if ($user = User::firstWhere('email', $request->input('email'))) {
            if ($user -> wrongCounter != 3) {
                $user->wrongCounter++;
                $user->save();
            }

            if ($user->wrongCounter === 3) {
                return redirect()
                    ->route('login')
                    ->withErrors(['email' => 'Your account is locked due to too many failed login attempts.']);
            }
        }


        return redirect()
            ->route('login')
            ->withErrors(['email' => 'The provided credentials do not match our records.'])
            ->withInput($request->only('email'));
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string|min:6|current_password',
            'new_password' => 'required|string|min:6|confirmed:new_password_repeat',
        ]);

        $user = Auth::user();
        $user->password = $request->input('new_password');
        $user->need_to_change_password = false;
        $user->save();

        return redirect()
            ->route('dashboard')
            ->with('status', 'Your password has been changed successfully.');
    }

    public function editUser(User $user, Request $request)
    {
        $request -> validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$user->id}",
            'password' => 'nullable|string|min:6',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->filled('password')) {
            $user->password = $request->input('password');
        }
        $user->save();

        return redirect()
            ->route('dashboard')
            ->with('status', 'User details have been updated successfully.');
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->save();

        return redirect()
            ->route('dashboard')
            ->with('status', 'User has been created successfully.');
    }

    public function deleteUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()
                ->route('dashboard')
                ->withErrors(['user' => 'You cannot delete your own account.']);
        }

        $user->delete();

        return redirect()
            ->route('dashboard')
            ->with('status', 'User has been deleted successfully.');
    }

    public function unlockUser(User $user)
    {
        if ($user -> wrong_counter !== 3) {
            $user -> wrong_counter = 3;
            $user -> save();

            return redirect()
                ->route('dashboard')
                ->with('status', 'User account has been locked successfully.');
        }

        $user -> wrong_counter = 0;
        $user -> save();

        return redirect()
            ->route('dashboard')
            ->with('status', 'User account has been unlocked successfully.');
    }
}
