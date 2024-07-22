@extends('template')
@section('content')
    <x-breadcrumbs :page="'Sales'" :subpage="'Customer Accounts'" :category="'Add Customer'" />
    <div class="container">
        <h2>Add Customer Accounts:</h2>
        <form action="add-customer/post" method="post">
            @csrf
            <div class="item">
                <label for="cid">Customer Id:</label>
                <input type="text" id="cid" name="cid" value="{{ $id }}" readonly>
            </div>
            <div class="item">
                <label for="cname">Customer Name:</label>
                <input type="text" id="cname" name="cname" required>
            </div>
            <div class="item">
                <label for="ccompany">Customer Company:</label>
                <input type="text" id="ccompany" name="ccompany" required>
            </div>
            <div class="item">
                <label for="cphone">Phone No:</label>
                <input type="text" name="cphone" id="cphone" required>
            </div>
            <div class="item">
                <label for="cemail">Email:</label>
                <input type="email" name="cemail" id="cemail"
                    onblur="checkEmailAvailability($('#cemail', '/vehicle/find-stock-id').val())">
                <p id="email-availability-message"></p>
            </div>
            <div class="item">
                <label for="cmanager">Manager:</label>
                <input type="text" name="cmanager" id="cmanager" value="ABC" readonly>
            </div>
            <div class="item">
                <label for="ccurrency">Currency:</label>
                <select name="ccurrency" id="ccurrency" required>
                    <option value="" disabled selected>Currency</option>
                    <option value="$">$</option>
                    <option value="€">€</option>
                </select>
            </div>
            <div class="item">
                <label for="cdescription">Description:</label>
                <textarea name="cdescription" id="cdescription" cols="30" rows="2"></textarea>
            </div>
            <button>Add</button>
        </form>
    </div>
@endsection
