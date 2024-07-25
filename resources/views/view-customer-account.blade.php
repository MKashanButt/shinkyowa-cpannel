@php
    $paymentCount = 1;
    $vehicleCount = 1;
@endphp
@extends('template')
@section('content')
    <x-breadcrumbs :page="'Sales'" :subpage="'Customer Accounts'" :category="$customerAccount->customer_name" />
    <section class="single-customer-account">
        <p><span>Customer Id:</span> {{ $customerAccount->customer_id }}</p>
        <p><span>Customer Name:</span> {{ $customerAccount->customer_name }}</p>
        <p><span>Customer Company:</span> {{ $customerAccount->customer_company }}</p>
        <p><span>Customer Email:</span> {{ $customerAccount->customer_email }}</p>
        <p><span>Phone No:</span> {{ $customerAccount->customer_phone }}</p>
        <p><span>Description:</span> {{ $customerAccount->description }}</p>
        <p><span>Buying:</span> {{ $customerAccount->currency . $customerAccount->buying }}</p>
        <p><span>Deposit:</span> {{ $customerAccount->currency . $customerAccount->deposit }}</p>
        <p><span>Remaining:</span> {{ $customerAccount->currency . $customerAccount->remaining }}</p>
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
                                <td>{{ $customerAccount->currency . $customerVehicle->amount }}</td>
                                <td>{{ $customerAccount->currency . $customerVehicle->payment }}</td>
                                <td>{{ $customerAccount->currency . (string) ($customerVehicle->amount - $customerVehicle->payment) }}
                                </td>
                                @if ($customerVehicle->amount - $customerVehicle->payment == 0)
                                    <td><button class="done">Cleared</button></td>
                                @else
                                    <td><button class="progress">Awaiting</button></td>
                                @endif
                                <td><button>View Images</button></td>
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
                            <th class="vehicle">Vehicle</th>
                            <th class="cemail">Customer Email</th>
                            <th class="paymentDate">Payment Date</th>
                            <th class="payment">Payment</th>
                            <th class="paymentRecievedDate">Recieved Date</th>
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
                                <td>{{ $customerPayment->vehicle }}</td>
                                <td>{{ $customerPayment->customer_email }}</td>
                                <td>{{ $customerPayment->payment_date }}</td>
                                <td>{{ $customerAccount->currency . $customerPayment->payment }}</td>
                                <td>{{ $customerPayment->payment_recieved_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <section class="dialog">
        <div class="stage">
            <img src="" alt="">
        </div>
    </section>
@endsection
