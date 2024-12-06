<?php

namespace App\Http\Controllers;

use App\Models\CustomerAccounts;
use App\Models\CustomerPayments;
use App\Models\CustomerVehicles;
use App\Models\Stocks;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Exists;

class CustomerAccountController extends Controller
{
    public function generateId()
    {
        $id = CustomerAccounts::orderBy('customer_id', 'DESC')->pluck('customer_id')->first();
        $code = 'SKC';
        $seperator = '-';

        if (!$id) {
            return $code . $seperator . '1001';
        }

        $id =  str_replace('SKC-', '', $id) + 1;
        return $code . $seperator . $id;
    }

    public function dashboard()
    {
        return view('pages.index', [
            "title" => 'Dashboard',
        ]);
    }

    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $customerAccounts = CustomerAccounts::orderBy('id', 'DESC')->get()->toArray();
        } else if (Auth::user()->role == 'operational manager') {
            $user_account = Auth::user()->name;
            $users = User::where('name', '!=', $user_account)->orderBy('id', 'DESC')->get();
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
                $customerAccounts = array_merge($customerAccounts, CustomerAccounts::where('agent', $user->name)->get()->toArray());
            }
            $customerAccounts = array_merge($customerAccounts, CustomerAccounts::where('agent', $user_account)->get()->toArray());
        } else {
            $customerAccounts = CustomerAccounts::where('agent', Auth::user()->name)->orderBy('id', 'DESC')->get()->toArray();
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

    public function store(Request $request)
    {
        $customerAccount = new CustomerAccounts;
        $customerAccount->customer_id = $request->input('cid');
        $customerAccount->customer_name = $request->input('cname');
        $customerAccount->customer_company = $request->input('ccompany');
        $customerAccount->customer_phone = $request->input('cphone');
        $customerAccount->customer_whatsapp = $request->input('cwhatsapp');
        $customerAccount->customer_email = $request->input('cemail');
        $customerAccount->agent_manager = $request->input('cmanager');
        $customerAccount->currency = $request->input('ccurrency');
        $customerAccount->description = $request->input('cdescription');
        $customerAccount->address = $request->input('caddress');
        $customerAccount->agent = $request->input('agent');

        $customerAccount->save();
        return redirect('/customer-account');
    }

    public function edit_account($id)
    {
        $customerAccount = CustomerAccounts::where('customer_id', $id)->first();

        return view('pages.customer-account.add-account', [
            "title" => $customerAccount["customer_name"] . ' | Customer Account',
            "stylesheet" => "add-customer.css",
            "customerAccount" => $customerAccount,
            "id" => $customerAccount->customer_id,
            "actionUrl" => "/customer-account/update"
        ]);
    }

    public function render_form()
    {
        $id = $this->generateId();
        return view('pages.customer-account.add-account', [
            "title" => "Add Customer Customer",
            "stylesheet" => "add-customer.css",
            "id" => $id,
            "actionUrl" => "/add-customer/post"
        ]);
    }

    public function udpate(Request $request)
    {
        $customerAccount = CustomerAccounts::where('customer_id', $request->input('cid'))->first();

        $customerAccount->update([
            'customer_id' => $request->input('cid'),
            'customer_name' => $request->input('cname'),
            'customer_company' => $request->input('ccompany'),
            'customer_phone' => $request->input('cphone'),
            'customer_whatsapp' => $request->input('cwhatsapp'),
            'customer_email' => $request->input('cemail'),
            'agent_manager' => $request->input('cmanager'),
            'currency' => $request->input('ccurrency'),
            'description' => $request->input('cdescription'),
            'address' => $request->input('caddress'),
            'agent' => $request->input('agent')
        ]);

        return redirect()->back();
    }

    public function find($id)
    {
        $customerAccount = CustomerAccounts::where('customer_id', $id)->first();
        $customerPayments = CustomerPayments::where('customer_email', $customerAccount->customer_email)->orderBy('id', 'DESC')->get();
        $customerPaymentsArray = CustomerPayments::where('customer_email', $customerAccount->customer_email)->orderBy('id', 'DESC')->get()->toArray();
        $customerVehicles = CustomerVehicles::where('customer_email', $customerAccount->customer_email)->orderBy('id', 'DESC')->get();
        $customerVehiclesArray = CustomerVehicles::where('customer_email', $customerAccount->customer_email)->orderBy('id', 'DESC')->get()->toArray();

        $customerVehicleIds = array_column($customerVehiclesArray, 'id');
        $customerPaymentsIds = array_column($customerPaymentsArray, 'id');

        $cnf = CustomerVehicles::whereIn('id', $customerVehicleIds)->sum('amount');
        $payment = CustomerVehicles::whereIn('id', $customerVehicleIds)->sum('payment');

        $totalCustomerPayments = CustomerPayments::whereIn('id', $customerPaymentsIds)->sum('in_usd');

        return view('pages.customer-account.view-account', [
            "title" => "Customer Account",
            "stylesheet" => "single-customer-account.css",
            "customerAccount" => $customerAccount,
            "customerPayments" => $customerPayments,
            "customerVehicles" => $customerVehicles,
            "cnf" => $cnf,
            "payment" => $payment,
            "totalCustomerPayments" => $totalCustomerPayments
        ]);
    }

    public function agent_customers_account(string $name)
    {
        $agent_customers_account = CustomerAccounts::where('agent', $name)
            ->orderBy('id', 'DESC')
            ->get()
            ->toArray();

        return view('pages.customer-account.agent-customers-account', [
            'title' => $name . ' | Customer Account',
            'stylesheet' => 'customer-account.css',
            'customerAccounts' => $agent_customers_account,
            'agent' => $name
        ]);
    }

    public function destroy($id)
    {
        $email = CustomerAccounts::where('customer_id', $id)->pluck('customer_email');
        CustomerAccounts::where('customer_id', $id)->delete();
        CustomerPayments::where('customer_email', $email)->delete();
        CustomerVehicles::where('customer_email', $email)->delete();

        return redirect()->back()->with('success', 'Account Deleted');
    }



    // AJAX APIS
    public function checkEmailAvailability(Request $request)
    {
        $email = $request->input('customer_email');
        $exists = CustomerAccounts::where('customer_email', $email)->exists() ? $msg = '' : $msg = 'Email does not Exist';
        $class = $exists ? 'success-text' : 'error-text';

        if ($email) {
            $record = CustomerAccounts::where('customer_email', $email)
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
        $msg = $availableStock ? 'Stock Id is Present' : 'Stock Id is not present or reserved';
        $html = "
                    <p id='stockid-find-message' class='error-text' hx-swap-oob='true'>$msg</p>
                    
                ";

        if (!$availableStock) {
            return response()->make($html, 200, [
                'Content-Type' => 'text/html',
            ]);
        }
    }

    // SEARCH
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
