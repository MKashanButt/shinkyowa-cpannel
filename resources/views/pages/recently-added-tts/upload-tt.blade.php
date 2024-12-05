@extends('template')
@section('content')
    <x-breadcrumbs :page="'Sales'" :subpage="'Upload TT'" />
    <div class="container">
        <h2>Upload TT:</h2>
        @if (session('success'))
            <div class="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        <form action="{{ $actionUrl }}" method="POST">
            @csrf
            <div class="item">
                <label for="stock_id">Stock Id:</label>
                <input type="text" name="stock_id" id="stock_id" required
                    value="{{ isset($record->stock_id) ? $record->stock_id : '' }}">
                <p id="stockid-find-message"></p>
            </div>
            <div class="item">
                <label for="cemail">Customer Email:</label>
                @isset($email)
                    <input type="text" name="customer_email" id="cemail" onblur="findEmail($('#cemail').val())" required
                        value="{{ isset($email) ? $email : '' }}">
                @endisset
                <input type="text" name="customer_email" id="cemail" onblur="findEmail($('#cemail').val())" required
                    value="{{ isset($record->customer_email) ? $record->customer_email : '' }}">
                <p id="email-find-message"></p>
            </div>
            <div class="item">
                <label for="payment_date">Payment Date:</label>
                <input type="date" name="payment_date" id="payment_date" required
                    value="{{ isset($payment->customer_email) ? $payment->customer_email : '' }}">
            </div>
            <div class="item">
                <label for="in_usd">Amount In Usd:</label>
                <input type="text" name="in_usd" id="in_usd" required
                    value="{{ isset($record->in_usd) ? number_format($record->in_usd) : '' }}">
            </div>
            <div class="item" style="align-self: baseline;">
                <label for="in_yen">Amount In Yen:</label>
                <input type="text" name="in_yen" id="in_yen" required
                    value="{{ isset($record->in_yen) ? number_format($record->in_yen) : '' }}">
            </div>
            <div class="item" style="align-items: baseline">
                <label for="description">Description:</label>
                <textarea type="text" name="description" id="description" required rows="5">{{ isset($record->description) ? $record->description : '' }}</textarea>
            </div>
            <button>Submit</button>
        </form>
    </div>
@endsection
