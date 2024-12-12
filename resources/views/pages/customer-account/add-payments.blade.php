@extends('template')
@section('content')
    <div class="container">
        <x-breadcrumbs :page="'Sale'" :subpage="'Customer Accounts'" :category="'Add Customer Payments'" />
        <h2>Add Customer Payment:</h2>
        @if (session('success'))
            <div class="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if (session('progress'))
            <div class="alert progress">
                <p>{{ session('progress') }}</p>
            </div>
        @endif
        <section class="payment_info">
            <div class="consignee_info">
                <h2>Consignee Info:</h2>
                <div class="item">
                    <p><label for="customer_name">Customer Name:</label> <input type="text" value="" id="customer_name"
                            disabled /></p>
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
                @csrf
                <div class="item">
                    <label for="stockId">Stock Id:</label>
                    <input type="text" name="stockId" id="stockId" required
                        value="{{ isset($payment->stock_id) ? $payment->stock_id : '' }}">
                    <p id="stockid-find-message"></p>
                </div>
                <div class="item">
                    <label for="cemail">Customer Email:</label>
                    @isset($email)
                        <input type="text" name="customer_email" id="cemail" hx-trigger='keyup, blur'
                            hx-post='/check-email-availability' hx-target='this' required
                            value="{{ isset($email) ? $email : '' }}">
                    @endisset
                    @if (!isset($email))
                        <input type="text" name="customer_email" id="cemail" hx-trigger='keyup, blur'
                            hx-post='/check-email-availability' hx-target='this' required
                            value="{{ isset($payment->customer_email) ? $payment->customer_email : '' }}">
                    @endif
                    <p id="email-find-message"></p>
                </div>
                <div class="item">
                    <label for="paymentDate">Payment Date:</label>
                    <input type="date" name="paymentDate" id="paymentDate" required
                        value={{ isset($payment->payment_date) ? $payment->payment_date : '' }}>
                </div>
                <div class="item">
                    <label for="in_usd">Amount In Usd:</label>
                    <input type="text" name="in_usd" id="in_usd" required
                        value="{{ isset($payment->in_usd) ? number_format($payment->in_usd) : '' }}">
                </div>
                <div class="item" style="align-self: baseline;">
                    <label for="in_yen">Amount In Yen:</label>
                    <input type="text" name="in_yen" id="in_yen" required
                        value="{{ isset($payment->in_yen) ? number_format($payment->in_yen) : '' }}">
                </div>
                <div class="item" style="align-items: baseline">
                    <label for="description">Description:</label>
                    <textarea type="text" name="description" id="description" required rows="5">{{ isset($payment->description) ? $payment->description : '' }} </textarea>
                </div>
                <div class="item" style="align-items: baseline">
                    <label for="paymentReceivedDate">Received Date:</label>
                    @isset($payment)
                        @if ($payment->paymentReceivedDate)
                            <input type="date" name="paymentReceivedDate" id="paymentReceivedDate" required
                                value={{ $payment->payment_received_date }}>
                        @endif
                    @endisset
                    <input type="date" name="paymentReceivedDate" id="paymentReceivedDate" required>
                </div>
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Add</button>
            </form>
        </section>
    </div>
@endsection
