<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $user ? 'Edit user' : 'Create user' }}</title>
</head>
<body>
    <h1>{{ $user ? 'Edit user' : 'Create user' }}</h1>
    <form action="{{ $user ? route('user.update', $user->id) : route('user.save') }}" method="POST">
        @csrf
        @if($user)
            @method('PUT')
        @endif

        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required>
        </div>

        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
        </div>

        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" {{ $user ? '' : 'required' }}>
        </div>

        <button type="submit">{{ $user ? 'Update User' : 'Create User' }}</button>
        <a href="{{ route('dashboard') }}">Cancel</a>
    </form>
    @if($errors->any())
        <div>
            <h2>Errors:</h2>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</body>
</html>
