<?php

namespace App\Http\Controllers;

use App\Models\CustomerAccounts;
use App\Models\Stocks;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function checkEmailAvailability(Request $request)
    {
        $email = $request->input('customer_email');
        $exists = CustomerAccounts::where('customer_email', $email)->exists() ? $msg = '' : $msg = 'Email does not Exist';
        $class = $exists ? 'success-text' : 'error-text';

        if ($email) {
            $record = CustomerAccounts::where('customer_email', 'LIKE', '%' . $email . '%')
                ->select('customer_name', 'customer_company', 'customer_phone', 'customer_whatsapp', 'address')
                ->first();
            $customer_name = $record->customer_name;
            $customer_company = $record->customer_company;
            $customer_phone = $record->customer_phone;
            $customer_whatsapp = $record->customer_whatsapp;
            $address = $record->address;
        } else {
            $customer_name = '';
            $customer_company = '';
            $customer_phone = '';
            $customer_whatsapp = '';
            $address = '';
        }

        $html = "
        <p id='email-find-message' class='error-text' hx-swap-oob='true'>$msg</p>
        <input type='text' value='$customer_name' id='customer_name' hx-swap-oob='true' disabled>
        <input type='text' value='$customer_company' id='company_name' hx-swap-oob='true' disabled>
        <input type='text' value='$customer_phone' id='phone_no' hx-swap-oob='true' disabled>
        <input type='text' value='$customer_whatsapp' id='whatsapp_no' hx-swap-oob='true' disabled>
        <input type='text' value='$address' id='address' hx-swap-oob='true' disabled>
        ";

        return response()->make($html, 200, [
            'Content-Type' => 'text/html',
        ]);
    }

    public function findEmail(Request $request)
    {
        $email = $request->input('email');
        $exists = CustomerAccounts::where('customer_email', $email)->exists();

        return response()->json([
            'available' => $exists
        ]);
    }

    public function findStockId(Request $request)
    {
        $stockId = $request->input('stockId');

        $availableStock = DB::table('stocks')->where('stock_id', $stockId)
            ->whereNotIn('status', ['reserved', 'not_available'])
            ->exists();

        $stockInfo = Stocks::where('stock_id', $stockId)->first(['make', 'model', 'year', 'chassis']);
        $msg = $availableStock ? '' : 'Stock Id is not present or reserved';
        $html = "
                <p id='stockid-find-message' class='error-text' hx-swap-oob='true'>$msg</p>
                ";

        if (!$availableStock) {
            return response()->make($html, 200, [
                'Content-Type' => 'text/html',
            ]);
        }
    }

    public function search(Request $request)
    {
        $request->validate([
            'search' => 'required|string|max:150'
        ]);

        $search = trim($request->input('search'));

        if (Auth::user()->role == 'admin') {
            $customerAccounts = CustomerAccounts::where('customer_email', '=', $search)->orderBy('id', 'DESC')->get()->toArray();
        } else if (Auth::user()->role == 'operational manager') {
            $user_account = Auth::user()->name;
            $users = User::where('name', '!=', $user_account, 'AND', 'customer_email', '=', $search)->orderBy('id', 'DESC')->get();
            $customerAccounts = array();
            foreach ($users as $user) {
                $customerAccounts = array_merge($customerAccounts, CustomerAccounts::where('agent', $user->name)->get()->toArray());
            }
            $customerAccounts = array_merge($customerAccounts, CustomerAccounts::where('agent', $user_account)->get()->toArray());
        } else if (Auth::user()->role == 'manager') {
            $user_account = Auth::user()->name;
            $users = User::where('manager', $user_account)->get();
            $customerAccounts = array();
            foreach ($users as $user) {
                $customerAccounts = array_merge($customerAccounts, CustomerAccounts::where('agent', $user->name, 'AND', 'customer_email', '=', $search)->get()->toArray());
            }
            $customerAccounts = array_merge($customerAccounts, CustomerAccounts::where('agent', $user_account, 'AND', 'customer_email', '=', $search)->get()->toArray());
        } else {
            $customerAccounts = CustomerAccounts::where('agent', Auth::user()->name, 'AND', 'customer_email', '=', $search)->orderBy('id', 'DESC')->get()->toArray();
        }

        $customerAccountIds = array_column($customerAccounts, 'id');
        // Sum up payments related to the filtered customer accounts
        $buying = CustomerAccounts::whereIn('id', $customerAccountIds)->sum('buying');
        $deposit = CustomerAccounts::whereIn('id', $customerAccountIds)->sum('deposit');

        return view('pages.customer-account.index', [
            "title" => 'Customer Account',
            "stylesheet" => "customer-account.css",
            "customerAccounts" => $customerAccounts,
            "buying" => $buying,
            "deposit" => $deposit,
        ]);
    }
}
