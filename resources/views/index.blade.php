<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome to the Dashboard</h1>
    <h2>List of Users</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Need to change password</th>
                <th>User is blocked</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->need_to_change_password ? 'Yes' : 'No' }}</td>
                    <td>{{ $user->wrong_counter === 3 ? 'Yes' : 'No' }}</td>
                    <td>
                        <a href="{{ route('user', $user->id) }}">Edit</a>
                        <form action="{{ route('user.delete', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                        <form action="{{ route('user.unlock', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit">{{ $user->wrong_counter === 3 ? 'Unblock' : 'Block' }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">
                    <a href="{{ route('user') }}">Create New User</a>
                </td>
            </tr>
        </tfoot>
    </table>
    @if(session('message'))
        <div>
            <strong>{{ session('message') }}</strong>
        </div>
    @endif
</body>
</html>
