@extends('template')
@section('content')
    <x-breadcrumbs :page="'Sales'" :subpage="'Customer Accounts'" :category="'Add Customer Payments'" />
    <div class="container">
        <h2>Add Customer Payments:</h2>
        @if (session('success'))
            <div class="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        <form action="/add-customer-payment" method="POST">
            @csrf
            <div class="item">
                <label for="stockId">Stock Id:</label>
                <input type="text" name="stockId" id="stockId" required>
                <p id="stockid-find-message"></p>
            </div>
            <div class="item">
                <label for="vehicle">Vehicle:</label>
                <input type="text" name="vehicle" id="vehicle" required>
            </div>
            <div class="item">
                <label for="cemail">Customer Email:</label>
                <input type="text" name="cemail" id="cemail" onblur="findEmail($('#cemail').val())" required>
                <p id="email-find-message"></p>
            </div>
            <div class="item">
                <label for="paymentDate">Payment Date:</label>
                <input type="date" name="paymentDate" id="paymentDate" required>
            </div>
            <div class="item">
                <label for="payment">Payment:</label>
                <input type="text" name="payment" id="payment" required>
            </div>
            <div class="item">
                <label for="paymentReceivedDate">Received Date:</label>
                <input type="date" name="paymentReceivedDate" id="paymentReceivedDate" required>
            </div>
            <button>Submit</button>
        </form>
    </div>
@endsection
