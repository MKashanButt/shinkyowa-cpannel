@extends('template')
@section('content')
    <x-breadcrumbs :page="'Sales'" :subpage="'Customer Accounts'" :category="'Add Customer'" />
    <div class="container">
        <h2>Add Customer Accounts:</h2>
        <form action="{{ $actionUrl }}" method="post">
            @csrf
            <div class="item">
                <label for="cid">Customer Id:</label>
                <input type="text" id="cid" name="cid" value="{{ $id }}" readonly>
            </div>
            <div class="item">
                <label for="cname">Customer Name:</label>
                <input type="text" id="cname" name="cname" required
                    value="{{ isset($customerAccount) ? $customerAccount->customer_name : '' }}">
            </div>
            <div class="item">
                <label for="ccompany">Customer Company:</label>
                <input type="text" id="ccompany" name="ccompany" required
                    value="{{ isset($customerAccount) ? $customerAccount->customer_company : '' }}">
            </div>
            <div class="item">
                <label for="cphone">Phone No:</label>
                <input type="text" name="cphone" id="cphone" required
                    value="{{ isset($customerAccount) ? $customerAccount->customer_phone : '' }}">
            </div>
            <div class="item">
                <label for="cwhatsapp">Whatsapp No:</label>
                <input type="text" name="cwhatsapp" id="cwhatsapp" required
                    value="{{ isset($customerAccount) ? $customerAccount->customer_whatsapp : '' }}">
            </div>
            <div class="item">
                <label for="cemail">Email:</label>
                <input type="email" name="cemail" id="cemail" onblur="checkEmailAvailability($('#cemail').val())"
                    value="{{ isset($customerAccount) ? $customerAccount->customer_email : '' }}">
                <p id="email-availability-message"></p>
            </div>
            <div class="item">
                <label for="cmanager">Manager:</label>
                <input type="text" name="cmanager" id="cmanager" value="{{ Auth::user()->manager }}" readonly
                    value="{{ isset($customerAccount) ? $customerAccount->agent_manager : '' }}">
            </div>
            <div class="item">
                <label for="ccurrency">Currency:</label>
                <select name="ccurrency" id="ccurrency" required>
                    @isset($customerAccount)
                        @if ($customerAccount->currency)
                            <option value="{{ isset($customerAccount) ? $customerAccount->currency : '' }}" selected>
                                {{ isset($customerAccount) ? $customerAccount->currency : '' }}
                            </option>
                        @else
                            <option value="" disabled selected>Currency</option>
                        @endif
                    @endisset
                    <option value="$">$</option>
                    <option value="€">€</option>
                    <option value="¥">¥</option>
                </select>
            </div>
            <div class="item" style="align-items:baseline;">
                <label for="cdescription">Description:</label>
                <textarea name="cdescription" id="cdescription" cols="30" rows="2">{{ isset($customerAccount) ? $customerAccount->description : '' }}</textarea>
            </div>
            <div class="item" style="align-items:baseline;">
                <label for="clocation">Location:</label>
                <textarea name="clocation" id="clocation" cols="30" rows="2">{{ isset($customerAccount) ? $customerAccount->location : '' }}</textarea>
            </div>
            <div class="item">
                <label for="cdescription">Agent:</label>
                <input type="text" name="agent" id="agent" value="{{ Auth::user()->name }}" readonly>
            </div>
            <button>Add</button>
        </form>
    </div>
@endsection
