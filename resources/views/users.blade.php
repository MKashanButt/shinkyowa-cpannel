@php
    $count = 1;
@endphp

@extends('template')
@section('content')
    <section class="user-accounts">
        <x-breadcrumbs :page="'Users'" />
        @if (session('success'))
            <div class="alert" style="margin: 20px 0">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        <section class="header">
            <a href="/register"><button class="primary">Add User</button></a>
        </section>
        <div class="container">
            <table cellspacing="0">
                <thead>
                    <tr>
                        <th class="sno">S.No</th>
                        <th class="username">Username</th>
                        <th class="role">Role</th>
                        <th class="actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            @if ($count < 10)
                                <td>0{{ $count++ }}.</td>
                            @else
                                <td>{{ $count++ }}.</td>
                            @endif
                            <td>{{ ucwords($user['name']) }}</td>
                            <td>{{ ucwords($user['role']) }}</td>
                            <td class="actions">
                                <a href="/user/credentials/{{ $user['id'] }}">
                                    <button>Credentials</button>
                                </a>
                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'operational manager')
                                    <a href="/user/destroy/{{ $user['id'] }}">
                                        <button class="danger">Delete</button>
                                    </a>
                                    @if ($user['role'] == 'manager')
                                        <a href="/user/members/{{ $user['name'] }}">
                                            <button class="primary">Team Members</button>
                                        </a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
