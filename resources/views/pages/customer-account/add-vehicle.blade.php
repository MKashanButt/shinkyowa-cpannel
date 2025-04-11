@extends('template')
@section('content')
    <div class="container">
        <x-breadcrumbs :page="'Sale'" :subpage="'Customer Accounts'" :category="'Add Customer Vehicle'" />
        @if (session('success'))
            <div x-data='{show: true}'>
                <div class="alert done" x-show='show' x-init='setTimeout(() => show = false, 3000)'>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @elseif(session('error'))
            <div x-data='{show: true}'>
                <div class="alert danger" x-show='show' x-init='setTimeout(() => show = false, 3000)'>
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        @endif
        <section class="vehicle_info">
            <div class="consignee_info">
                <h2>Consignee Info:</h2>
                <div class="item">
                    <p><label for="customer_name">Customer Name:</label> <input type="text" value=""
                            id="customer_name" disabled /></p>
                </div>
                <div class="item">
                    <p><label for="company_name">Company Name:</label> <input type="text" value=""
                            id="company_name" disabled /></p>
                </div>
                <div class="item">
                    <p><label for="phone_no">Phone No:</label> <input type="text" value="" id="phone_no"
                            disabled />
                    </p>
                </div>
                <div class="item">
                    <p><label for="whatsapp_no">Whatsapp No:</label> <input type="text" value="" id="whatsapp_no"
                            disabled /></p>
                </div>
                <div class="item">
                    <p><label for="address">Address:</label> <input type="text" value="" id="address"
                            disabled />
                    </p>
                </div>
            </div>
            <form action="{{ $actionUrl }}" method="POST">
                <h2>Add Customer Vehicle:</h2>
                @csrf
                <div class="container">
                    <div class="item">
                        <label for="stockId">Stock Id:</label>
                        <input type="text" name="stockId" id="stockId" hx-trigger='keyup, blur'
                            hx-post='/find-stock-id' hx-target='this'
                            value="{{ isset($vehicle) ? $vehicle->stock_id : '' }}">
                        <p id="stockid-find-message"></p>
                    </div>
                    <div class="item">
                        <label for="vehicle">Vehicle:</label>
                        <input type="text" name="vehicle" id="vehicle"
                            value="{{ isset($vehicle) ? $vehicle->vehicle : '' }}" readonly>
                    </div>
                    <div class="item">
                        <label for="chassis">Chassis:</label>
                        <input type="text" name="chassis" id="chassis"
                            value="{{ isset($vehicle) ? $vehicle->chassis : '' }}" readonly>
                    </div>
                    <div class="item amount">
                        <label for="amount">Amount:</label>
                        <select name="fob_or_cnf" id="fob-cnf">
                            @isset($vehicle->status)
                                <option selected value="{{ isset($vehicle) ? $vehicle->fob_or_cnf : '' }}">
                                    {{ $vehicle->fob_or_cnf }}</option>
                            @endisset
                            <option value="FOB">FOB</option>
                            <option value="CNF">CNF</option>
                        </select>
                        <input type="text" name="amount" id="amount"
                            value="{{ isset($vehicle) ? $vehicle->amount : '' }}">
                    </div>
                    <div class="item">
                        <label for="cemail">Customer Email:</label>
                        @if (isset($email))
                            <input type="text" name="customer_email" id="cemail" hx-trigger='keyup, blur'
                                hx-post='/check-email-availability' hx-target='this' required
                                value="{{ isset($vehicle->customer_email) ? $vehicle->customer_email : '' }}">
                        @else
                            <input type="text" name="customer_email" id="cemail" hx-trigger='keyup, blur'
                                hx-post='/check-email-availability' hx-target='this' required>
                        @endif
                        <p id="email-find-message"></p>
                    </div>
                    <div class="item">
                        <label for="status">Status:</label>
                        <select name="status" id="status" required>
                            @if (isset($vehicle->status))
                                <option selected value="{{ isset($vehicle) ? $vehicle->status : '' }}">
                                    {{ ucwords($vehicle->status) }}</option>
                            @else
                                <option disabled>Select Status</option>
                            @endif
                            <option value="reserved" selected>Reserved</option>
                        </select>
                    </div>
                </div>
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Add
                </button>
            </form>
        </section>
    </div>
@endsection
