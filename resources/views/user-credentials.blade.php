@extends('template')
@section('content')
    <x-breadcrumbs :page="'User'" :subpage="$name" :category="'Credentials'" />
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
            @if (Auth::user()->role == 'admin')
                <div class="item">
                    <label for="account">Manager:</label>
                    <select name="manager" id="manager" onchange="optToggle()">
                        <option value={{ Auth::user()->role == 'manager' ? false : true }} selected>
                            {{ Auth::user()->role == 'manager' ? 'False' : 'True' }}</option>
                        <option value=true>True</option>
                        <option value=false>False</option>
                    </select>
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
