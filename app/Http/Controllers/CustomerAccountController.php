<?php

namespace App\Http\Controllers;

use App\Models\CustomerAccounts;
use App\Models\CustomerPayments;
use App\Models\CustomerVehicles;
use App\Models\Stocks;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        return view('index', [
            "title" => 'Dashboard',
        ]);
    }

    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $customerAccounts = CustomerAccounts::orderBy('id', 'DESC')->get()->toArray();
        } else if (Auth::user()->role == 'manager') {
            $user_account = Auth::user()->name;
            $users = User::where('manager', $user_account)->get();
            $customerAccounts = array();
            foreach ($users as $user) {
                $customerAccounts = array_merge($customerAccounts, CustomerAccounts::where('agent', $user->name)->get()->toArray());
            }
        } else {
            $customerAccounts = CustomerAccounts::where('agent', Auth::user()->name)->orderBy('id', 'DESC')->get()->toArray();
        }
        $buying = CustomerPayments::sum('payment');
        return view('customer-account', [
            "title" => 'Customer Account',
            "stylesheet" => "customer-account.css",
            "customerAccounts" => $customerAccounts,
            "buying" => $buying
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
        $customerAccount->location = $request->input('clocation');
        $customerAccount->agent = $request->input('agent');

        $customerAccount->save();
        return redirect('/customer-account');
    }

    public function render_add_customer_form()
    {
        $id = $this->generateId();
        return view('add-customer-account', [
            "title" => "Add Customer Customer",
            "stylesheet" => "add-customer.css",
            "id" => $id,
        ]);
    }

    public function find($id)
    {
        $customerAccount = CustomerAccounts::where('customer_id', $id)->first();
        $customerPayments = CustomerPayments::where('customer_email', $customerAccount->customer_email)->orderBy('id', 'DESC')->get();
        $customerVehicles = CustomerVehicles::where('customer_email', $customerAccount->customer_email)->orderBy('id', 'DESC')->get();

        $images = Stocks::where('customer_email', $customerAccount->customer_email)->orderBy('id', 'DESC')->get();

        return view('view-customer-account', [
            "title" => "Customer Account",
            "stylesheet" => "single-customer-account.css",
            "customerAccount" => $customerAccount,
            "customerPayments" => $customerPayments,
            "customerVehicles" => $customerVehicles,
            "images" => $images
        ]);
    }

    public function findImages($stockid)
    {
        $stock = Stocks::where('stock_id', $stockid)->pluck('stock_images');

        return view('vehicle-images', [
            "title" => $stockid . " | Vehicle Images",
            "images" => explode(',', $stock[0]),
            "stylesheet" => 'single-customer-account.css',
        ]);
    }

    public function fetch_customer_vehicle($stockid)
    {
        $vehicle = CustomerVehicles::where('stock_id', $stockid)->first();
        return view('add-customer-vehicle', [
            "title" => "Customer Vehicle Edit",
            "stylesheet" => "add-customer-vehicle.css",
            "vehicle" => $vehicle
        ]);
    }

    public function edit_customer_vehicle(Request $request)
    {

        $PREVIOUS_PAYMENT = CustomerVehicles::where('stock_id', $request->input('stockId'))->pluck('payment');

        $FILTERED_AMMOUNT = ltrim($request->input('amount'), "$");
        $FILTERED_AMMOUNT = str_replace(',', '', $FILTERED_AMMOUNT) - $PREVIOUS_PAYMENT;

        $customerVehicles = new CustomerVehicles;
        $customerVehicles->stock_id = $request->input('stockId');
        $customerVehicles->vehicle = $request->input('vehicle');
        $customerVehicles->chassis = $request->input('chassis');
        $customerVehicles->fob_or_cnf = $request->input('fob-cnf');
        $customerVehicles->amount = $FILTERED_AMMOUNT;
        $customerVehicles->customer_email = $request->input('cemail');
        $customerVehicles->status = $request->input('status');

        $customerVehicles->save();

        $customerAccount = CustomerAccounts::where('customer_email', $request->input('cemail'))->first();
        $customerBuying = $customerAccount->buying;
        if ($customerAccount) {
            $customerAccount->buying = $customerBuying + $FILTERED_AMMOUNT;
            $customerAccount->save();
        }

        return redirect()->back()->with('success', 'Vehicle Uploaded');
    }

    public function render_customer_payment_form()
    {
        return view('add-customer-payments', [
            "title" => "Customer Payments",
            "stylesheet" => "customer-payments.css"
        ]);
    }

    public function add_customer_payment(Request $request)
    {
        $FILTERED_AMMOUNT = ltrim($request->input('payment'), "$");
        $FILTERED_AMMOUNT = str_replace(',', '', $FILTERED_AMMOUNT);

        $customer_payment = new CustomerPayments;
        $customer_payment->stock_id = $request->input('stockId');
        $customer_payment->description = $request->input('description');
        $customer_payment->customer_email = $request->input('cemail');
        $customer_payment->payment_date = $request->input('paymentDate');
        $customer_payment->payment = $FILTERED_AMMOUNT;
        $customer_payment->payment_recieved_date = $request->input('paymentReceivedDate');

        $customer_payment->save();

        $customerData = CustomerAccounts::where('customer_email', $request->input('cemail'))->first();

        CustomerAccounts::where('customer_email', $request->input('cemail'))->update([
            "deposit" =>  $customerData->deposit + $FILTERED_AMMOUNT,
        ]);

        $customerPayment = CustomerVehicles::where('stock_id', $request->input('stockId'))->first();

        CustomerVehicles::where('stock_id', $request->input('stockId'))->update([
            "payment" => $customerPayment->payment + $FILTERED_AMMOUNT
        ]);

        return redirect()->back()->with('success', 'Customer Payment Added');
    }

    public function fetch_customer_payment($id)
    {
        $payment = CustomerPayments::findOrFail($id);
        return view('add-customer-payment', [
            "title" => "Edit Client Payment",
            "stylesheet" => "customer-payments",
            "payment" => $payment
        ]);
    }

    public function render_customer_vehicle_form()
    {
        return view('add-customer-vehicle', [
            "title" => "Add Customer Vehicle",
            "stylesheet" => "add-customer-vehicle.css"
        ]);
    }

    public function add_customer_vehicle(Request $request)
    {
        $FILTERED_AMMOUNT = ltrim($request->input('amount'), "$");
        $FILTERED_AMMOUNT = str_replace(',', '', $FILTERED_AMMOUNT);

        $customerVehicles = new CustomerVehicles;
        $customerVehicles->stock_id = $request->input('stockId');
        $customerVehicles->vehicle = $request->input('vehicle');
        $customerVehicles->chassis = $request->input('chassis');
        $customerVehicles->fob_or_cnf = $request->input('fob-cnf');
        $customerVehicles->amount = $FILTERED_AMMOUNT;
        $customerVehicles->customer_email = $request->input('cemail');
        $customerVehicles->status = $request->input('status');

        $customerVehicles->save();

        $stocks = Stocks::where('stock_id', $request->input('stockId'))->first();
        if ($stocks) {
            $stocks->status = 'reserved';
            $stocks->customer_email = $request->input('cemail');
            $stocks->save();
        }

        $customerAccount = CustomerAccounts::where('customer_email', $request->input('cemail'))->first();
        $customerBuying = $customerAccount->buying;
        if ($customerAccount) {
            $customerAccount->buying = $customerBuying + $FILTERED_AMMOUNT;
            $customerAccount->save();
        }

        return redirect()->back()->with('success', 'Vehicle Uploaded');
    }

    public function agent_customers_account(string $name)
    {
        $agent_customers_account = CustomerAccounts::where('agent', $name)
            ->orderBy('id', 'DESC')
            ->get()
            ->toArray();

        return view('agent-customers-account', [
            'title' => $name . ' | Customer Account',
            'stylesheet' => 'customer-account.css',
            'customerAccounts' => $agent_customers_account,
            'agent' => $name
        ]);
    }

    public function render_users()
    {
        if (Auth::user()->role == 'admin') {
            $users = User::where('role', '=', 'manager')
                ->where('name', '!=', Auth::user()->name)
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $users = User::where('manager', '=', Auth::user()->name)
                ->orderBy('id', 'DESC')
                ->get();
        }

        return view('users', [
            "title" => "User Accounts",
            "stylesheet" => "users.css",
            "users" => $users
        ]);
    }

    public function team_members($manager)
    {
        $users = User::where('manager', $manager)
            ->orderBy('id', 'DESC')
            ->get();

        return view('users', [
            "title" => "User Accounts",
            "stylesheet" => "users.css",
            "users" => $users
        ]);
    }

    public function user_credentials($id)
    {
        $user = User::where('id', $id)
            ->orderBy('id', 'desc')
            ->first();

        $managers = User::where('role', 'manager')
            ->get();

        return view('user-credentials', [
            "title" => "User Accounts",
            "stylesheet" => "users.css",
            "user" => $user,
            "managers" => $managers,
            "stylesheet" => "user-credentials.css",
            "name" => $user["name"]
        ]);
    }

    public function update_user_credentials(Request $request)
    {
        $id = $request->input('id');
        $user = User::findOrFail($id);
        $name = $request->input('name');
        $manager = $request->input('manager');
        $managerName = $request->input('managerName');
        $password = $request->input('password');

        if ($name) {
            $user->update([
                'name' => $name,
            ]);
        }

        if ($password) {
            $user->update([
                'password' => Hash::make($password)
            ]);
        }

        if (!$manager) {
            $user->update([
                'role' => 'manager'
            ]);
        } else {
            $user->update([
                'role' => 'agent'
            ]);
        }

        if ($managerName) {
            $user->update([
                'manager' => $managerName
            ]);
        }

        $user->save();

        return redirect('users');
    }

    public function destroy($id)
    {
        $email = CustomerAccounts::where('customer_id', $id)->pluck('customer_email');
        CustomerAccounts::where('customer_id', $id)->delete();
        CustomerPayments::where('customer_email', $email)->delete();
        CustomerVehicles::where('customer_email', $email)->delete();

        return redirect()->back()->with('success', 'Account Deleted');
    }

    public function destroy_user($id)
    {
        User::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Account Deleted');
    }

    public function destroy_customer_vehicle($id)
    {
        $stockid = CustomerVehicles::where('id', $id)->pluck('stock_id');
        $email = CustomerVehicles::where('id', $id)->pluck('customer_email');

        CustomerVehicles::where('id', $id)->delete();

        $removalbuying = CustomerPayments::where('stock_id', $stockid)->pluck('payment');
        $sumOfRemovalBuying = $removalbuying->sum();
        $previousbuying = CustomerAccounts::where('customer_email', $email)->pluck('buying');
        $sumOfPreviousBuying = $previousbuying->sum();

        $buying = $sumOfPreviousBuying - $sumOfRemovalBuying;

        CustomerPayments::where('stock_id', $stockid)->update([
            'stock_id' => 'not allocated'
        ]);

        Stocks::where('stock_id', $stockid)->update([
            'status' => 'available'
        ]);

        CustomerAccounts::where('customer_email', $email)->update([
            "buying" => $buying
        ]);

        return redirect()->back();
    }

    public function destroy_customer_payment($id)
    {
        CustomerPayments::findOrFail($id)->delete();
        return redirect()->back();
    }

    // AJAX APIS
    public function checkEmailAvailability(Request $request)
    {
        $email = $request->input('email');
        $exists = CustomerAccounts::where('customer_email', $email)->exists();

        return response()->json([
            'available' => !$exists
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

        return response()->json([
            'available' => $availableStock
        ]);
    }
}
