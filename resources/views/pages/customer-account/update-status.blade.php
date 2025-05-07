@php
    $title = 'Update Status';
    $stylesheet = 'customer-payments.css';
@endphp

@extends('template')
@section('content')
    <div class="container">
        <x-breadcrumbs :page="'Sale'" :subpage="'Customer Accounts'" :category="'Update Status'" />
        <h2>Update Vehicle Status</h2>
        <form action="{{ route('vehicle.store-status') }}" method="post">
            @csrf
            <div class="item">
                <label for="stock_id">Stock Id:</label>
                <input type="text" id="stock_id" name="stock_id" value="{{ $stockid }}" readonly>
            </div>
            <div class="item">
                <label for="payment_status">Status:</label>
                <select name="payment_status">
                    <option value="">Select Status</option>
                    <option value="pending">Pending</option>
                    <option value="cleared">Cleared</option>
                </select>
            </div>
            <button>
                Update Status
            </button>
        </form>
    </div>
@endsection
