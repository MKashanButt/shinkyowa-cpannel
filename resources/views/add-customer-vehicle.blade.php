@extends('template')
@section('content')
    <x-breadcrumbs :page="'Sales'" :subpage="'Customer Accounts'" :category="'Add Customer Vehicle'" />
    <div class="container">
        <h2>Add Customer Vehicle:</h2>
        @if (session('success'))
            <div class="alert" onshow="timeout($('#stockId').val())">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        <form action="/add-customer-vehicle/post" method="POST">
            @csrf
            <div class="item">
                <label for="stockId">Stock Id:</label>
                <input type="text" name="stockId" id="stockId" onblur="findStockId($('#stockId').val())">
                <p id="stockid-find-message"></p>
            </div>
            <div class="item">
                <label for="vehicle">Vehicle:</label>
                <input type="text" name="vehicle" id="vehicle">
            </div>
            <div class="item">
                <label for="chassis">Chassis:</label>
                <input type="text" name="chassis" id="chassis">
            </div>
            <div class="item amount">
                <label for="amount">Amount:</label>
                <select name="fob-cnf" id="fob-cnf">
                    <option value="FOB">FOB</option>
                    <option value="CNF">CNF</option>
                </select>
                <input type="text" name="amount" id="amount">
            </div>
            <div class="item">
                <label for="cemail">Customer Email:</label>
                <input type="text" name="cemail" id="cemail" onblur="findEmail($('#cemail').val())">
                <p id="email-find-message"></p>
            </div>
            <div class="item">
                <label for="status">Status:</label>
                <select name="status" id="status">
                    <option disabled selected>Select Status</option>
                    <option value="reserved">Reserved</option>
                </select>
            </div>
            <button>Add</button>
        </form>
    </div>
@endsection
