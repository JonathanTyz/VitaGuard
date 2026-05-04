<h1>VitaGuard</h1>

@if(auth()->check())
    <a href="{{ route('home') }}">Home</a>
@else
    <a href="{{ route('login') }}">Login</a>
@endif