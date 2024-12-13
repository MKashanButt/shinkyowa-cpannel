@extends('template')
@section('content')
    <div class="container">
        <x-breadcrumbs :page="'Sale'" :subpage="'Upload TT'" />
        @if (session('success'))
            <div x-data='{show: true}'>
                <div class="alert" x-show='show' x-init='setTimeout(() => show = false, 3000)'>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif
        <section class="payment_info">
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
                            disabled /></p>
                </div>
            </div>
            <form action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data">
                <h2>Upload TT:</h2>
                @csrf
                <div class="container">
                    <div class="item">
                        <label for="stock_id">Stock Id:</label>
                        <input type="text" name="stock_id" id="stock_id" hx-trigger="blur" hx-post="/find-stock-id"
                            hx-target="this" required value="{{ isset($record->stock_id) ? $record->stock_id : '' }}">
                        <p id="stockid-find-message" class="error-text"></p>
                    </div>
                    <div class="item">
                        <label for="cemail">Customer Email:</label>
                        @isset($email)
                            <input type="text" name="customer_email" id="cemail" hx-trigger='keyup, blur'
                                hx-post='/check-email-availability' hx-target='this' required
                                value="{{ isset($email) ? $email : '' }}">
                        @endisset
                        <input type="text" name="customer_email" id="cemail" hx-trigger="keyup, blur"
                            hx-post="/check-email-availability" hx-target="this" required
                            value="{{ isset($record->customer_email) ? $record->customer_email : '' }}">
                        <p id="email-find-message" class="error-text"></p>
                    </div>
                    <div class="item" style="align-self: baseline;">
                        <label for="remittance_name">Remittance Name:</label>
                        <input type="text" name="remittance_name" id="remittance_name" required
                            value="{{ isset($payment->remittance_name) ? $payment->remittance_name : '' }}">
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
                    <div class="item" style="align-self: baseline;">
                        <label for="tt_copy">Upload TT Copy:</label>
                        <input type="file" name="tt_copy" id="tt_copy" required
                            value="{{ isset($record->tt_copy) ? $record->tt_copy : '' }}">
                    </div>
                    <button>Submit</button>
                </div>
            </form>
        </section>
    </div>
@endsection
