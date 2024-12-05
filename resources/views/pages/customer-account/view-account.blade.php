@php
    $paymentCount = 1;
    $vehicleCount = 1;
@endphp
@extends('template')
@section('content')
    <x-breadcrumbs :page="'Sales'" :subpage="'Customer Accounts'" :category="$customerAccount->customer_name" />
    <x-customer-options :customeremail="$customerAccount->customer_email" />
    <section class="single-customer-account">
        <div class="tab" x-data='{open: false}' x-cloak>
            <button @click='open=!open'>Customer Info
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div class="info" id="customer-info-tab" x-show='open' @click.outside='open= false'>
                <p><span>Customer Id:</span> {{ $customerAccount->customer_id }}</p>
                <p><span>Customer Name:</span> {{ $customerAccount->customer_name }}</p>
                <p><span>Customer Company:</span> {{ $customerAccount->customer_company }}</p>
                <p><span>Customer Email:</span> {{ $customerAccount->customer_email }}</p>
                <p><span>Phone No:</span> {{ $customerAccount->customer_phone }}</p>
                <p><span>Whatsapp No:</span> {{ $customerAccount->customer_whatsapp }}</p>
                <p><span>Description:</span> {{ $customerAccount->description }}</p>
                <p><span>Address:</span> {{ $customerAccount->address }}</p>
                <p><span>Buying:</span>
                    {{ $customerAccount->buying ? $customerAccount->currency . number_format($customerAccount->buying) : '' }}
                </p>
                <p><span>Deposit:</span>
                    {{ $customerAccount->buying ? $customerAccount->currency . number_format(intval($customerAccount->deposit)) : '' }}
                </p>
                <p><span>Remaining:</span>
                    {{ $customerAccount->buying ? $customerAccount->currency . number_format($customerAccount->buying - intval($customerAccount->deposit)) : '' }}
                </p>
            </div>
        </div>
        <div class="tab" x-data='{open: false}' x-cloak>
            <button @click='open=!open' @click.outside='open= false'>Customer Vehicles
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div class="info" id="customer-vehicle-tab" x-show='open' @click.outside='open= false'>
                <table class="customer-vehicle" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="sno">S.No</th>
                            <th class="stockId">Stock Id</th>
                            <th class="vehicle">Vehicle</th>
                            <th class="chassis">Chassis</th>
                            <th class="fob">CNF</th>
                            <th class="fob">Amount</th>
                            <th class="fob">Remaining</th>
                            <th class="fob">Status</th>
                            <th class="actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customerVehicles as $customerVehicle)
                            <tr>
                                @if ($vehicleCount < 10)
                                    <td>0{{ $vehicleCount++ }}.</td>
                                @else
                                    <td>{{ $vehicleCount++ }}.</td>
                                @endif
                                <td>{{ $customerVehicle->stock_id }}</td>
                                <td>{{ $customerVehicle->vehicle }}</td>
                                <td>{{ $customerVehicle->chassis }}</td>
                                <td>{{ $customerAccount->currency . number_format($customerVehicle->amount) }}</td>
                                <td>{{ $customerVehicle->payment ? $customerAccount->currency . number_format($customerVehicle->payment) : '' }}
                                </td>
                                <td>{{ $customerAccount->currency . number_format($customerVehicle->amount - $customerVehicle->payment) }}
                                </td>
                                @if (
                                    $customerVehicle->amount - $customerVehicle->payment == 0 ||
                                        $customerVehicle->amount - $customerVehicle->payment < 0)
                                    <td><button class="done">Cleared</button></td>
                                @else
                                    <td><button class="progress">Pending</button></td>
                                @endif
                                <td class="action-btns">
                                    <a href="/customer-account/images/{{ $customerVehicle->stock_id }}"><button>View
                                            Images</button></a>
                                    <a href="/customer-account/docs/{{ $customerVehicle->stock_id }}"><button>View
                                            Docs</button></a>
                                    @if (Auth::user()->role == 'admin')
                                        <a href="/customer-vehicle/destroy/{{ $customerVehicle->id }}"><button
                                                class="danger">Delete</button></a>
                                    @endif
                                    @if (Auth::user()->role != 'agent')
                                        <a href="/customer-vehicle/edit/{{ $customerVehicle->stock_id }}"><button
                                                class="primary">Edit</button></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <table class="total-row" cellspacing="0">
                    <tr>
                        <td class="sno"></td>
                        <td class="stockId"></td>
                        <td class="vehicle"></td>
                        <td class="chassis">Total</td>
                        <td class="fob">
                            {{ '$' . number_format($cnf) }}
                        </td>
                        <td class="fob">
                            {{ '$' . number_format($payment) }}
                        </td>
                        <td class="fob">
                            {{ '$' . number_format($cnf - $payment) }}
                        </td>
                        <td></td>
                        <td class="action-btns"></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="tab" x-data="{ open: false }" x-cloak>
            <button @click='open=!open' @click.outside='open= false'>Customer Payments
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d=" m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div class="info" id="customer-payments-tab" x-show="open" @click.outside='open= false'>
                <table class="customer-payments" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="sno">S.No</th>
                            <th class="stockId">Stock Id</th>
                            <th class="vehicle">Description</th>
                            <th class="cemail">Customer Email</th>
                            <th class="paymentDate">Payment Date</th>
                            <th class="payment">Amount</th>
                            <th class="paymentRecievedDate">Recieved Date</th>
                            @if (Auth::user()->role != 'agent')
                                <th class="action">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customerPayments as $customerPayment)
                            <tr>
                                @if ($paymentCount < 10)
                                    <td>0{{ $paymentCount++ }}.</td>
                                @else
                                    <td>{{ $paymentCount++ }}.</td>
                                @endif
                                <td>{{ $customerPayment->stock_id }}</td>
                                <td>{{ $customerPayment->description }}</td>
                                <td>{{ $customerPayment->customer_email }}</td>
                                <td>{{ $customerPayment->payment_date }}</td>
                                <td>{{ $customerAccount->currency . $customerPayment->payment }}</td>
                                <td>{{ $customerPayment->payment_recieved_date }}</td>
                                <td class="action-btns">
                                    @if (Auth::user()->role != 'agent')
                                        <a href="/customer-payment/edit/{{ $customerPayment->id }}">
                                            <button class="primary">Edit</button>
                                        </a>
                                    @endif
                                    @if (Auth::user()->role == 'admin')
                                        <a
                                            href="/customer-payment/destroy/{{ $customerPayment->stock_id }}/{{ $customerAccount->customer_email }}/{{ $customerPayment->payment }}">
                                            <button class="danger">Delete</button>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- <x-table-total-row :buying="'$' . number_format($buying)" :deposit="'$' . number_format($deposit)" :remaining="'$' . number_format($buying - $deposit)" /> --}}
                <table class="total-row-2" cellspacing="0">
                    <tr>
                        <td class="sno"></td>
                        <td class="stockId"></td>
                        <td class="vehicle">
                        </td>
                        <td class="cemail">
                        </td>
                        <td class="paymentDate">
                            Total
                        </td>
                        <td class="payment">
                            {{ '$' . number_format($totalCustomerPayments) }}
                        </td>
                        <td class="paymentRecievedDate"></td>
                        <td class="action"></td>
                    </tr>
                </table>
            </div>
        </div>
    </section>
@endsection
