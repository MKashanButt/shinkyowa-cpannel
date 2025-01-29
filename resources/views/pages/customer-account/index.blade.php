@php
    $count = 1;
@endphp

@extends('template')
@section('content')
    <section class="main-customer-accounts">
        <x-breadcrumbs :page="'Sale'" :subpage="'Customer Accounts'" />
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
                            <td>{{ $accounts['buying'] ? $accounts['currency'] . number_format((int) $accounts['buying'] - (int) $accounts['deposit']) : '' }}
                            </td>
                            @if (Auth::user()->user != 'agent')
                                <td>
                                    <a href="/agent-customers-account/{{ $accounts['agent'] }}">
                                        <button class="agent-btn">{{ $accounts['agent'] }}</button>
                                    </a>
                                </td>
                            @endif
                            <td class="actions">
                                <div class="stage">
                                    <a href="/customer-account/{{ $accounts['customer_id'] }}">
                                        <button class="account-btn">View Account</button>
                                    </a>
                                    @if (Auth::user()->role == 'admin')
                                        <a href="/customer-account/destroy/{{ $accounts['customer_id'] }}">
                                            <button class="danger">Delete</button>
                                        </a>
                                    @endif
                                    @if (Auth::user()->role != 'agent')
                                        <a href="/customer-account/edit/{{ $accounts['customer_id'] }}">
                                            <button class="primary">Edit</button>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                <tfoot>
                    <tr class="total-row">
                        <td></td>
                        <td></td>
                        <td>Total</td>
                        <td>
                            {{ '$' . number_format($buying) }}
                        </td>
                        <td>
                            {{ '$' . number_format($deposit) }}
                        </td>
                        <td>
                            {{ '$' . number_format($buying - $deposit) }}
                        </td>
                        @if (Auth::user()->user != 'agent')
                            <td></td>
                        @endif
                        <td></td>
                    </tr>
                </tfoot>
                {{ $customerAccounts->links() }}
                </tbody>
            </table>
        </div>
    </section>
@endsection

<script>
    $('table').scrollTableBody();
</script>
