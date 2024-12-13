<?php

namespace App\Http\Controllers;

use App\Models\CustomerAccounts;
use App\Models\CustomerPayments;
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

        // Check if stock ID is available
        $availableStock = DB::table('stocks')
            ->where('stock_id', $stockId)
            ->whereNotIn('status', ['reserved', 'not_available'])
            ->exists();

        // Get stock info
        $stockInfo = Stocks::where('stock_id', $stockId)->first(['make', 'model', 'year', 'chassis']);

        // Prepare message and HTML
        $msg = $availableStock ? '' : 'Stock ID is not present or reserved';
        if ($msg == '') {
            $vehicle_name = $stockInfo['make'] . ' ' . $stockInfo['model'] . ' ' . $stockInfo['year'];
            $html = "
                <p id='stockid-find-message' class='error-text' hx-swap-oob='true'>$msg</p>
                <input type='text' name='vehicle' id='vehicle' value='$vehicle_name' hx-swap-oob='true'>
                <input type='text' name='chassis' id='chassis' value='{$stockInfo['chassis']}' hx-swap-oob='true'>
            ";
        } else {
            $html = "
                <p id='stockid-find-message' class='error-text' hx-swap-oob='true'>$msg</p>
            ";
        }

        // Return HTML response
        return response()->make($html, 200, [
            'Content-Type' => 'text/html',
        ]);
    }


    public function search(Request $request)
    {
        $request->validate([
            'searchByEmail' => 'required|string|max:150'
        ]);

        $search = trim($request->input('searchByEmail'));

        if (Auth::user()->role == 'admin') {
            // Admin can view all customer accounts, filtered by email if provided
            $customerAccounts = CustomerAccounts::where('customer_email', 'LIKE', "%$search%")
                ->orderBy('id', 'DESC')->paginate(6);
        } elseif (Auth::user()->role == 'operational manager') {
            // Operational manager can view accounts of agents they manage and their own, filtered by email
            $user_account = Auth::user()->name;
            $users = User::where('name', '!=', $user_account)->pluck('name');
            $agents = $users->push($user_account);
            $customerAccounts = CustomerAccounts::whereIn('agent', $agents)
                ->where('customer_email', 'LIKE', "%$search%")
                ->orderBy('id', 'DESC')->paginate(6);
        } elseif (Auth::user()->role == 'manager') {
            // Manager can view accounts of agents they manage and their own, filtered by email
            $user_account = Auth::user()->name;
            $users = User::where('manager', $user_account)->pluck('name');
            $agents = $users->push($user_account);
            $customerAccounts = CustomerAccounts::whereIn('agent', $agents)
                ->where('customer_email', 'LIKE', "%$search%")
                ->orderBy('id', 'DESC')->paginate(6);
        } else {
            // Other roles (e.g., general user) can only view their own accounts, filtered by email
            $customerAccounts = CustomerAccounts::where('agent', Auth::user()->name)
                ->where('customer_email', 'LIKE', "%$search%")
                ->orderBy('id', 'DESC')->paginate(6);
        }

        // Calculate sums for 'buying' and 'deposit' directly from the paginated collection
        $buying = $customerAccounts->sum('buying');
        $deposit = $customerAccounts->sum('deposit');

        return view('pages.customer-account.index', [
            "title" => 'Customer Account',
            "stylesheet" => "customer-account.css",
            "customerAccounts" => $customerAccounts,
            "buying" => $buying,
            "deposit" => $deposit,
        ]);
    }

    public function searchByCompany(Request $request)
    {
        $request->validate([
            'searchByCompany' => 'required|string|max:150'
        ]);

        $search = trim($request->input('searchByCompany'));

        if (Auth::user()->role == 'admin') {
            $customerAccounts = CustomerAccounts::where('customer_company', 'LIKE', "%$search%")
                ->orderBy('id', 'DESC')->paginate(6);
        } elseif (Auth::user()->role == 'operational manager') {
            $user_account = Auth::user()->name;
            $users = User::where('name', '!=', $user_account)->pluck('name');
            $agents = $users->push($user_account);
            $customerAccounts = CustomerAccounts::whereIn('agent', $agents)
                ->where('customer_company', 'LIKE', "%$search%")
                ->orderBy('id', 'DESC')->paginate(6);
        } elseif (Auth::user()->role == 'manager') {
            $user_account = Auth::user()->name;
            $users = User::where('manager', $user_account)->pluck('name');
            $agents = $users->push($user_account);
            $customerAccounts = CustomerAccounts::whereIn('agent', $agents)
                ->where('customer_company', 'LIKE', "%$search%")
                ->orderBy('id', 'DESC')->paginate(6);
        } else {
            $customerAccounts = CustomerAccounts::where('agent', Auth::user()->name)
                ->where('customer_company', 'LIKE', "%$search%")
                ->orderBy('id', 'DESC')->paginate(6);
        }

        // Calculate sums for 'buying' and 'deposit' directly from the paginated collection
        $buying = $customerAccounts->sum('buying');
        $deposit = $customerAccounts->sum('deposit');

        return view('pages.customer-account.index', [
            "title" => 'Customer Account',
            "stylesheet" => "customer-account.css",
            "customerAccounts" => $customerAccounts,
            "buying" => $buying,
            "deposit" => $deposit,
        ]);
    }

    public function searchByStockId(Request $request)
    {
        $request->validate([
            'searchByStockId' => 'required|string|max:255'
        ]);

        $record = Stocks::where('stock_id', $request->input('searchByStockId'))
            ->select('thumbnail', 'stock_id', 'customer_email', 'make', 'model', 'year', 'fob', 'status')
            ->first()
            ->toArray();

        if ($record['status'] == 'reserved') {
            $agent = CustomerAccounts::where('customer_email', $record['customer_email'])->select('agent')->first()->toArray();
            $payment = CustomerPayments::where('stock_id', $record['stock_id'])->sum('in_yen');
            $record = array_merge($record, $agent, ['in_yen' => $payment]);
        } else {
            $agent = ["agent" => ''];
            $payment = ["in_yen" => 0];
            $record = array_merge($record, $agent, $payment);
        }

        return view('pages.customer-account.stockid-view-table', [
            'record' => $record,
            'title' => 'Filter By Stock Id | Shinkyowa International',
            'stylesheet' => 'stock-id-filter-page.css'
        ]);
    }
}
