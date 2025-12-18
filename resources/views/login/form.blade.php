<!doctype html>
<html>
<head><meta charset="utf-8"><title>Auth</title></head>
<body>
<h1>Login / Register</h1>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf
    <label>Login</label><br>
    <input name="login" value="{{ old('login') }}" required><br><br>

    <label>Phone</label><br>
    <input name="phone" value="{{ old('phone') }}" required><br><br>

    <button type="submit">Login / Register</button>
</form>
</body>
</html>
