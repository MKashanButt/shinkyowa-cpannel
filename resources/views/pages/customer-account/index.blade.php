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
                    @foreach ($customerStats as $key => $stat)
                        <tr>
                            <td>{{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}.</td>
                            <td>{{ $stat['customer']->customer_name }}</td>
                            <td>{{ $stat['customer']->customer_company }}</td>
                            <td>{{ $buying ? $stat['customer']->currency . number_format($stat['buying']) : '' }}</td>
                            <td>{{ $deposit ? $stat['customer']->currency . number_format($stat['deposit']) : '' }}</td>
                            <td>{{ $buying ? $stat['customer']->currency . number_format($stat['buying'] - $stat['deposit']) : '' }}
                            </td>
                            @if (Auth::user()->user != 'agent')
                                <td>
                                    <a href="/agent-customers-account/{{ $stat['customer']->agent }}">
                                        <button class="agent-btn">{{ $stat['customer']->agent }}</button>
                                    </a>
                                </td>
                            @endif
                            <td class="actions">
                                <div class="stage">
                                    <a href="/customer-account/{{ $stat['customer']->customer_id }}">
                                        <button class="account-btn">View Account</button>
                                    </a>
                                    @if (Auth::user()->role == 'admin')
                                        <a href="/customer-account/destroy/{{ $stat['customer']->customer_id }}">
                                            <button class="danger"
                                                onclick="confirm('Are you sure you want to delete {{ ucwords($stat['customer']->customer_name) }} Account?')">Delete</button>
                                        </a>
                                    @endif
                                    @if (Auth::user()->role != 'agent')
                                        <a href="/customer-account/edit/{{ $stat['customer']->customer_id }}">
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
