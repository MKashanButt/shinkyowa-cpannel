@php
    $count = 1;
@endphp

@extends('template')
@section('content')
    <section class="main-customer-accounts">
        <x-breadcrumbs :page="'Sales'" :subpage="'Customer Accounts'" />
        <x-customer-options />
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
                            <td>{{ $accounts->customer_name }}</td>
                            <td>{{ $accounts->customer_company }}</td>
                            <td>{{ $accounts->currency . number_format($accounts->buying) }}</td>
                            <td>{{ $accounts->currency . number_format($accounts->deposit) }}</td>
                            <td>{{ $accounts->currency . number_format($accounts->remaining) }}</td>
                            <td class="actions"><a href="/customer-account/{{ $accounts->customer_id }}"><button>View
                                        Account</button></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
