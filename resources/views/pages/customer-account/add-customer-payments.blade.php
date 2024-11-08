@extends('template')
@section('content')
    {{-- @dd($payment) --}}
    <x-breadcrumbs :page="'Sales'" :subpage="'Customer Accounts'" :category="'Add Customer Payments'" />
    <div class="container">
        <h2>Add Customer Payments:</h2>
        @if (session('success'))
            <div class="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        <form action="{{ $actionUrl }}" method="POST">
            @csrf
            <div class="item">
                <label for="stockId">Stock Id:</label>
                <input type="text" name="stockId" id="stockId" required
                    value="{{ isset($payment->stock_id) ? $payment->stock_id : '' }}">
                <p id="stockid-find-message"></p>
            </div>
            <div class="item">
                <label for="cemail">Customer Email:</label>
                <input type="text" name="cemail" id="cemail" onblur="findEmail($('#cemail').val())" required
                    value="{{ isset($payment->customer_email) ? $payment->customer_email : '' }}">
                <p id="email-find-message"></p>
            </div>
            <div class="item">
                <label for="paymentDate">Payment Date:</label>
                <input type="date" name="paymentDate" id="paymentDate" required
                    value="{{ isset($payment) ? $payment->payment_date->format('mm-dd-YYYY') : '' }}">
            </div>
            <div class="item">
                <label for="payment">Payment:</label>
                <input type="text" name="payment" id="payment" required
                    value="{{ isset($payment->payment) ? $payment->payment : '' }}">
            </div>
            <div class="item" style="align-items: baseline">
                <label for="paymentReceivedDate">Received Date:</label>
                <input type="date" name="paymentReceivedDate" id="paymentReceivedDate" required
                    value="{{ isset($payment) ? $payment->payment_recieved_date->format('mm-dd-YYYY') : '' }}">
            </div>
            <div class="item" style="align-items: baseline">
                <label for="description">Description:</label>
                <textarea type="text" name="description" id="description" required rows="5">{{ isset($payment->description) ? $payment->description : '' }} </textarea>
            </div>
            <button>Submit</button>
        </form>
    </div>
@endsection
