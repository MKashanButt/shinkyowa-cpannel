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
}
