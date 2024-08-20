@php
    $paymentCount = 1;
    $vehicleCount = 1;
@endphp
@extends('template')
@section('content')
    <x-breadcrumbs :page="'Sales'" :subpage="'Customer Accounts'" :category="$customerAccount->customer_name" />
    <x-customer-options />
    <section class="single-customer-account">
        <p><span>Customer Id:</span> {{ $customerAccount->customer_id }}</p>
        <p><span>Customer Name:</span> {{ $customerAccount->customer_name }}</p>
        <p><span>Customer Company:</span> {{ $customerAccount->customer_company }}</p>
        <p><span>Customer Email:</span> {{ $customerAccount->customer_email }}</p>
        <p><span>Phone No:</span> {{ $customerAccount->customer_phone }}</p>
        <p><span>Whatsapp No:</span> {{ $customerAccount->customer_whatsapp }}</p>
        <p><span>Description:</span> {{ $customerAccount->description }}</p>
        <p><span>Location:</span> {{ $customerAccount->location }}</p>
        <p><span>Buying:</span>
            {{ $customerAccount->buying ? $customerAccount->currency . number_format($customerAccount->buying) : '' }}
        </p>
        <p><span>Deposit:</span>
            {{ $customerAccount->buying ? $customerAccount->currency . number_format(intval($customerAccount->deposit)) : '' }}
        </p>
        <p><span>Remaining:</span>
            {{ $customerAccount->buying ? $customerAccount->currency . number_format($customerAccount->buying - $customerAccount->deposit) : '' }}
        </p>
        <div class="tab">
            <button onclick="toggleTab('customer-vehicle-tab')">Customer Vehicles
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div class="info hidden" id="customer-vehicle-tab">
                <table class="customer-vehicle" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="sno">S.No</th>
                            <th class="stockId">Stock Id</th>
                            <th class="vehicle">Vehicle</th>
                            <th class="chassis">Chassis</th>
                            <th class="fob">FOB</th>
                            <th class="fob">Payment</th>
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
                                @if ($customerVehicle->amount - $customerVehicle->payment == 0)
                                    <td><button class="done">Cleared</button></td>
                                @else
                                    <td><button class="progress">Awaiting</button></td>
                                @endif
                                <td class="action-btns">
                                    <a href="/customer-account/images/{{ $customerVehicle->stock_id }}"><button>View
                                            Images</button></a>
                                    <button>View Docs</button>
                                    @if (Auth::user()->role == 'admin')
                                        <a href="/customer-vehicle/destroy/{{ $customerVehicle->id }}"><button
                                                class="danger">Delete</button></a>
                                        <a href="/customer-vehicle/edit/{{ $customerVehicle->stock_id }}"><button
                                                class="primary">Edit</button></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab">
            <button onclick="toggleTab('customer-payments-tab')">Customer Payments
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div class="info hidden" id="customer-payments-tab">
                <table class="customer-payments" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="sno">S.No</th>
                            <th class="stockId">Stock Id</th>
                            <th class="vehicle">Description</th>
                            <th class="cemail">Customer Email</th>
                            <th class="paymentDate">Payment Date</th>
                            <th class="payment">Payment</th>
                            <th class="paymentRecievedDate">Recieved Date</th>
                            <th class="action">Action</th>
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
                                <td>
                                    <a href="/customer-payment/edit/{{ $customerPayment->id }}"><button
                                            class="primary">Edit</button></a>
                                    <a href="/customer-payment/destroy/{{ $customerPayment->id }}"><button
                                            class="danger">Delete</button></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
