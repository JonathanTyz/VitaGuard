<h1>Login</h1>

<form method="POST" action="{{route('login.process')}}">
    @csrf
    <div>
        <label>Username</label>
        <input type="text" name="username" required>
    </div>
    <div>
        <label>Password</label>
        <input type="password" name="password" required>
    </div>
    <button type="submit">Login</button>
</form>
@if ($errors->has('auth'))
    <div class="error">
        {{ $errors->first('auth') }}
    </div>
@endif