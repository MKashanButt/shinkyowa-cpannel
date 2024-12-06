@extends('template')
@section('content')
    <x-breadcrumbs :page="'Sales'" :subpage="'Upload TT'" />
    <div class="container">
        <h2>Upload TT:</h2>
        @if (session('success'))
            <div x-data='{show: true}'>
                <div class="alert" x-show='show' x-init='setTimeout(() => show = false, 3000)'>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif
        <section class="payment_info">
            <div class="consignee_info">
                <div class="item">
                    <p><b>Customer Name:</b> <span id="customer_name"></span></p>
                </div>
                <div class="item">
                    <p><b>Company Name:</b><span id="company_name"></span></p>
                </div>
                <div class="item">
                    <p><b>Phone No:</b> <span id="phone_no"></span></p>
                    <p><b>Whatsapp No:</b><span id="whatsapp_no"></span></p>
                </div>
                <div class="item">
                    <p><b>Address:</b> <span id="address"></span></p>
                </div>
            </div>
            <form action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="item">
                    <label for="stock_id">Stock Id:</label>
                    <input type="text" name="stock_id" id="stock_id" hx-trigger="blur" hx-post="/find-stock-id"
                        hx-target="this" required value="{{ isset($record->stock_id) ? $record->stock_id : '' }}">
                    <p id="stockid-find-message" class="error-text"></p>
                </div>
                <div class="item">
                    <label for="cemail">Customer Email:</label>
                    @isset($email)
                        <input type="text" name="customer_email" id="cemail" hx-trigger='blur'
                            hx-post='/check-email-availability' hx-target='this'required
                            value="{{ isset($email) ? $email : '' }}">
                    @endisset
                    <input type="text" name="customer_email" id="cemail" hx-trigger="blur"
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
            </form>
        </section>
    </div>
@endsection
