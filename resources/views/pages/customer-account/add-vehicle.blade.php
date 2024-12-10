@extends('template')
@section('content')
    <x-breadcrumbs :page="'Sale'" :subpage="'Customer Accounts'" :category="'Add Customer Vehicle'" />
    <div class="container">
        <h2>Add Customer Vehicle:</h2>
        @if (session('success'))
            <div x-data='{show: true}'>
                <div class="alert" x-show='show' x-init='setTimeout(() => show = false, 3000)'>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif
        <form action="{{ $actionUrl }}" method="POST">
            @csrf
            <div class="item">
                <label for="stockId">Stock Id:</label>
                <input type="text" name="stockId" id="stockId" onblur="findStockId($('#stockId').val())"
                    value="{{ isset($vehicle) ? $vehicle->stock_id : '' }}">
                <p id="stockid-find-message"></p>
            </div>
            <div class="item">
                <label for="vehicle">Vehicle:</label>
                <input type="text" name="vehicle" id="vehicle" value="{{ isset($vehicle) ? $vehicle->vehicle : '' }}">
            </div>
            <div class="item">
                <label for="chassis">Chassis:</label>
                <input type="text" name="chassis" id="chassis" value="{{ isset($vehicle) ? $vehicle->chassis : '' }}">
            </div>
            <div class="item amount">
                <label for="amount">Amount:</label>
                <select name="fob-cnf" id="fob-cnf">
                    @isset($vehicle->status)
                        <option selected value="{{ isset($vehicle) ? $vehicle->fob_or_cnf : '' }}">
                            {{ $vehicle->fob_or_cnf }}</option>
                    @endisset
                    <option value="FOB">FOB</option>
                    <option value="CNF">CNF</option>
                </select>
                <input type="text" name="amount" id="amount" value="{{ isset($vehicle) ? $vehicle->amount : '' }}">
            </div>
            <div class="item">
                <label for="cemail">Customer Email:</label>
                @isset($email)
                    <input type="text" name="cemail" id="cemail" onblur="findEmail($('#cemail').val())" required
                        value="{{ $email }}" readonly>
                @endisset
                @if (!isset($email))
                    <input type="text" name="cemail" id="cemail" onblur="findEmail($('#cemail').val())" required
                        value="{{ isset($vehicle->customer_email) ? $vehicle->customer_email : '' }}">
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
                        <option disabled selected>Select Status</option>
                    @endif
                    <option value="reserved">Reserved</option>
                </select>
            </div>
            <button>Add</button>
        </form>
    </div>
@endsection
