<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ViewsController extends Controller
{
    public function index()
    {
        return view('index', [
            'users' => User::all(),
        ]);
    }

    public function login()
    {
        return view('login');
    }

    public function changePassword()
    {
        return view('change_password');
    }

    public function editUser(?User $user = null)
    {
        return view('user_form', [
            'user' => $user,
        ]);
    }
}
