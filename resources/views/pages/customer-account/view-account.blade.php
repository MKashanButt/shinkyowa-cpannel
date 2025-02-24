@php
    $paymentCount = 1;
    $vehicleCount = 1;
@endphp
@extends('template')
@section('content')
    <section class="single-customer-account">
        @if (Auth::user()->role != 'customer')
            <x-breadcrumbs :page="'Sale'" :subpage="'Customer Accounts'" :category="$customerAccount->customer_name" />
            <x-customer-options :customeremail="$customerAccount->customer_email" />
        @endif
        <div class="tab" x-data='{open: false}' x-cloak>
            <button @click='open=!open' x-bind:class="open ? 'active-customer-tab' : ''">Customer Info
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
                <p><span>City:</span> {{ $customerAccount->city }}</p>
                <p><span>Country:</span> {{ $customerAccount->country }}</p>
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
        <div class="tab ledger" x-data='{open: false}' x-cloak>
            <button @click='open=!open' x-bind:class="open ? 'active-customer-tab' : ''">Account Ledger
                <p>
                    <a href="/export-pdf/{{ $customerAccount->customer_id }}">
                        Download Pdf
                    </a>
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div class="info" id="customer-vehicle-tab" x-show='open' @click.outside='open= false'>
                <table class="customer-vehicle" cellspacing="0">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Stock Id</th>
                            <th>Vehicle</th>
                            <th>Chassis</th>
                            <th>CNF</th>
                            <th>Amount</th>
                            <th>Remaining</th>
                            <th>Status</th>
                            <th>Actions</th>
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
                                <td class="actions">
                                    <div class="stage">
                                        <a href="/customer-account/images/{{ $customerVehicle->stock_id }}"><button
                                                class="image-btn">View
                                                Images</button></a>
                                        <a href="/customer-account/docs/{{ $customerVehicle->stock_id }}"><button
                                                class="docs-btn">View
                                                Docs</button></a>
                                        @if (Auth::user()->role == 'admin')
                                            <a href="/customer-vehicle/destroy/{{ $customerVehicle->id }}"><button
                                                    class="danger">Delete</button></a>
                                        @endif
                                        @if (Auth::user()->role != 'agent')
                                            <a href="/customer-vehicle/edit/{{ $customerVehicle->stock_id }}"><button
                                                    class="primary">Edit</button></a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Total</td>
                            <td>
                                {{ '$' . number_format($cnf) }}
                            </td>
                            <td>
                                {{ '$' . number_format($payment) }}
                            </td>
                            <td>
                                {{ '$' . number_format($cnf - $payment) }}
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="tab" x-data='{open: false}' x-cloak>
            <button @click='open=!open' x-bind:class="open ? 'active-customer-tab' : ''">Customer Vehicles
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div class="info" id="customer-vehicle-tab" x-show='open' @click.outside='open= false'>
                <table class="customer-vehicle" cellspacing="0">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Stock Id</th>
                            <th>Vehicle</th>
                            <th>Chassis</th>
                            <th>CNF</th>
                            <th>Amount</th>
                            <th>Remaining</th>
                            <th>Status</th>
                            <th>Actions</th>
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
                                <td class="actions">
                                    <div class="stage">
                                        <a href="/customer-account/images/{{ $customerVehicle->stock_id }}"><button
                                                class="image-btn">View
                                                Images</button></a>
                                        <a href="/customer-account/docs/{{ $customerVehicle->stock_id }}"><button
                                                class="docs-btn">View
                                                Docs</button></a>
                                        @if (Auth::user()->role == 'admin')
                                            <a href="/customer-vehicle/destroy/{{ $customerVehicle->id }}"><button
                                                    class="danger">Delete</button></a>
                                        @endif
                                        @if (Auth::user()->role != 'agent')
                                            <a href="/customer-vehicle/edit/{{ $customerVehicle->stock_id }}"><button
                                                    class="primary">Edit</button></a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Total</td>
                            <td>
                                {{ '$' . number_format($cnf) }}
                            </td>
                            <td>
                                {{ '$' . number_format($payment) }}
                            </td>
                            <td>
                                {{ '$' . number_format($cnf - $payment) }}
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="tab" x-data="{ open: false }" x-cloak>
            <button @click='open=!open' x-bind:class="open ? 'active-customer-tab' : ''">Customer Payments
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d=" m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div class="info" id="customer-payments-tab" x-show="open" @click.outside='open= false'>
                <table class="customer-payments" cellspacing="0">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Stock Id</th>
                            <th>Description</th>
                            <th>Customer Email</th>
                            <th>Payment Date</th>
                            <th>Payment In Yen</th>
                            <th>Recieved Date</th>
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
                                <td>{{ '¥' . number_format((int) $customerPayment->in_yen) }}</td>
                                <td>{{ $customerPayment->payment_recieved_date }}</td>
                                <td class="actions">
                                    <div class="stage">
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
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <td></td>
                            <td></td>
                            <td>
                            </td>
                            <td>
                            </td>
                            <td>
                                Total
                            </td>
                            <td>
                                {{ '¥' . number_format($totalCustomerPayments) }}
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>
@endsection
