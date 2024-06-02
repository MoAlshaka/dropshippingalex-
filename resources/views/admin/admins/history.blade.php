<!-- users/history.blade.php -->

@extends('layouts.master')

@section('content')
    <h4>Login/Logout History for {{ $user->name }}</h4>

    <ul>
        @foreach($loginHistory as $login)
            <li>
                @if ($login->activity_type === 'login')
                    User logged in at {{ $login->logged_in_at }} from {{ $login->device_name }} (IP: {{ $login->logged_in_ip }})
                @elseif ($login->activity_type === 'logout')
                    User logged out at {{ $login->logged_in_at }} from {{ $login->device_name }} (IP: {{ $login->logged_in_ip }})
                @endif
            </li>
        @endforeach
    </ul>
@endsection
