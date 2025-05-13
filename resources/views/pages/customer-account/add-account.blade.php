@extends('template')
@section('content')
    @if
        <p>{{ $error }}</p>
    @endif
    <div class="container">
        <x-breadcrumbs :page="'Sale'" :subpage="'Customer Accounts'" :category="'Add Customer'" />
        <h2>Add Customer Account</h2>
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
                <input type="email" name="cemail" id="cemail" name="customer_email" id="cemail"
                    hx-trigger='keyup, blur' hx-post='/check-email-availability' hx-target='this'
                    value="{{ isset($customerAccount) ? $customerAccount->customer_email : '' }}">
                <p id="email-availability-message"></p>
            </div>
            @if (!isset($customerAccount))
                <div class="item">
                    <label for="cpassword">Password:</label>
                    <input type="password" name="cpassword" id="cpassword" name="customer_password" id="cpassword">
                </div>
            @endif
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
                <textarea name="cdescription" id="cdescription" cols="30" rows="4">{{ isset($customerAccount) ? $customerAccount->description : '' }}</textarea>
            </div>
            <div class="item" style="align-items:baseline;">
                <label for="caddress">Address:</label>
                <textarea name="caddress" id="caddress" cols="30" rows="4">{{ isset($customerAccount) ? $customerAccount->address : '' }}</textarea>
            </div>
            <div class="item" style="align-items:baseline;">
                <label for="ccity">City:</label>
                <input type="text" name="ccity" id="ccity"
                    value="{{ isset($customerAccount) ? $customerAccount->city : '' }}"">
            </div>
            <div class="item" style="align-items:baseline;">
                <label for="ccountry">Country:</label>
                <input type="text" name="ccountry" id="ccountry"
                    value="{{ isset($customerAccount) ? $customerAccount->country : '' }}"">
            </div>
            <div class="item">
                <label for="cdescription">Agent:</label>
                @if (Auth::user()->role == 'admin')
                    <select name="agent" id="agent">
                        @if (isset($customerAccount))
                            <option value="{{ $customerAccount->agent }}" selected>{{ $customerAccount->agent }}
                            </option>
                            @foreach ($agents as $agent)
                                @if ($customerAccount->agent != $agent->name)
                                    <option value="{{ $agent->name }}">{{ $agent->name }}</option>
                                @endif
                            @endforeach
                        @else
                            <option value="" selected disabled>Select Agent</option>
                            @foreach ($agents as $agent)
                                <option value="{{ $agent->name }}">{{ $agent->name }}</option>
                            @endforeach
                        @endif
                    </select>
                @else
                    <input type="text" name="agent" id="agent"
                        value="{{ isset($customerAccount) ? $customerAccount->agent : Auth::user()->name }}"" readonly>
                @endif
            </div>
            <button>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add
            </button>
        </form>
    </div>
@endsection
