@php
    $count = 1;
@endphp

@extends('template')
@section('content')
    <section class="main-customer-accounts">
        <x-breadcrumbs :page="'Sales'" :subpage="'Customer Accounts'" :subpage="$agent" />
        <x-customer-options />
        @if (session('success'))
            <div class="alert" style="margin: 20px 0">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        <div class="container">
            <table cellspacing="0">
                <thead>
                    <tr>
                        <th class="sno">S.No</th>
                        <th class="cname">Customer Name</th>
                        <th class="ccompany">Customer Company</th>
                        <th class="buying">Buying</th>
                        <th class="deposit">Deposit</th>
                        <th class="remaining">Remaining</th>
                        @if (Auth::user()->user != 'agent')
                            <th class="agent">Agent</th>
                        @endif
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customerAccounts as $accounts)
                        <tr>
                            @if ($count < 10)
                                <td>0{{ $count++ }}.</td>
                            @else
                                <td>{{ $count++ }}.</td>
                            @endif
                            <td>{{ $accounts['customer_name'] }}</td>
                            <td>{{ $accounts['customer_company'] }}</td>
                            <td>{{ $accounts['buying'] ? $accounts['currency'] . number_format($accounts['buying']) : '' }}
                            </td>
                            <td>{{ $accounts['deposit'] ? $accounts['currency'] . number_format($accounts['deposit']) : '' }}
                            </td>
                            <td>{{ $accounts['buying'] ? $accounts['currency'] . number_format($accounts['buying'] - $accounts['deposit']) : '' }}
                            </td>
                            @if (Auth::user()->user != 'agent')
                                <td>
                                    {{ $accounts['agent'] }}
                                </td>
                            @endif
                            <td class="actions">
                                <a href="/customer-account/{{ $accounts['customer_id'] }}">
                                    <button>View Account</button>
                                </a>
                                @if (Auth::user()->role == 'admin')
                                    <a href="/customer-account/destroy/{{ $accounts['customer_id'] }}">
                                        <button class="danger">Delete</button>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
