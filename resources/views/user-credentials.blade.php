@extends('template')
@section('content')
    <x-breadcrumbs :page="'User'" :subpage="$name" :category="'Credentials'" />
    @dd($managers)
    <div class="container">
        <h2>Update User:</h2>
        <form action="{{ route('users.update') }}" method="post">
            @csrf
            <input type="text" id="id" name="id" value="{{ $user['id'] }}" hidden>
            <div class="item">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required value="{{ $user['name'] }}">
            </div>
            <div class="item">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
            </div>
            @if (Auth::user()->role == 'admin' || (Auth::user()->role == 'operational manager' && $user['role'] == 'agent'))
                <div class="item">
                    <label for="account">Manager:</label>
                    <select name="managerName" id="managerName">
                        @foreach ($managers as $manager)
                            <option value="{{ $manager['name'] }}">{{ $manager['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <button>Update</button>
        </form>
    </div>
@endsection
