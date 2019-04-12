@extends("layouts.app")
@section("content")
    {{--@if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    @endif--}}

    <h3>Welcome</h3>
    <ul class="list-unstyled">
        <li>
            <a href="{{url("/orders")}}">Orders</a>
        </li>
        <li>
            <a href="{{url("/products")}}">Products</a>
        </li>
        <li>
            <a href="{{url("/weather")}}">Weather</a>
        </li>
    </ul>
@endsection