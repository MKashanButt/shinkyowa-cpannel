<?php

namespace App\Http\Controllers;

use App\Models\CustomerAccounts;
use App\Models\CustomerPayments;
use App\Models\CustomerVehicles;
use App\Models\Docs;
use App\Models\Shipment;
use App\Models\Stocks;
use App\Models\TextPassword;
use App\Models\TTUploaded;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Exists;
use Illuminate\View\View;
use App\Http\Requests\StoreCustomerAccountRequest;
use Exception;

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
        $data = [];

        if (Auth::user()->role == 'admin') {
            $stockCount = Stocks::count();
            $userCount = User::count();
            $recentTT = TTUploaded::orderBy('id', 'desc')->first();

            $ttCopy = $recentTT ? $recentTT->tt_copy : null;

            $data = [
                "stockCount" => $stockCount,
                "userCount" => $userCount,
                "recentTT" => $ttCopy
            ];

            $dealers = CustomerAccounts::orderBy('id', 'DESC')
                ->limit(6)
                ->get();

            $buying = $dealers->sum('buying');
            $deposit = $dealers->sum('deposit');

            $vehicles = CustomerVehicles::orderBy('id', 'DESC')
                ->limit(6)
                ->get();

            $cnf = $vehicles->sum('amount');
            $payment = $vehicles->sum('payment');

            $newVehicles = [];

            foreach ($dealers as $dealer) {
                foreach ($vehicles as $vehicle) {
                    if ($dealer->customer_email == $vehicle->customer_email) {
                        $newVehicles[] = array_merge($vehicle->toArray(), ["currency" => $dealer->currency]);
                    }
                }
            }
        }
        if (Auth::user()->role == 'agent') {
            $totalStock = Stocks::count();
            $totalDealers = CustomerAccounts::where('agent', Auth::user()->name)->count();
            $customerEmails = CustomerAccounts::where('agent', Auth::user()->name)->pluck('customer_email');
            $totalCarsSold = CustomerVehicles::whereIn('customer_email', $customerEmails)
                ->whereRaw('amount - payment <= 0')
                ->count();
            $lastTTCopyUploaded = TTUploaded::where('agent', Auth::user()->name)
                ->orderBy('id', 'DESC')
                ->first(['tt_copy']);
            $lastCustomerAdded = CustomerAccounts::where('agent', Auth::user()->name)
                ->orderBy('id', 'DESC')
                ->first(['customer_name']);

            $data = [
                "totalStock" => $totalStock,
                "totalDealers" => $totalDealers,
                "totalCarsSold" => $totalCarsSold,
                "lastTTCopyUploaded" => $lastTTCopyUploaded ? $lastTTCopyUploaded->tt_copy : null,
                "lastCustomerAdded" => $lastCustomerAdded ? $lastCustomerAdded->customer_name : 0,
            ];

            $dealers = CustomerAccounts::where('agent', Auth::user()->name)
                ->orderBy('id', 'DESC')
                ->limit(6)
                ->get();
            $buying = $dealers->sum('buying');
            $deposit = $dealers->sum('deposit');
            $customers = CustomerAccounts::where('agent', Auth::user()->name)->pluck('customer_email');
            $vehicles = CustomerVehicles::whereIn('customer_email', $customers)
                ->orderBy('id', 'DESC')
                ->limit(6)
                ->get();
            $cnf = $vehicles->sum('amount');
            $payment = $vehicles->sum('payment');

            $newVehicles = [];

            foreach ($dealers as $dealer) {
                foreach ($vehicles as $vehicle) {
                    if ($dealer->customer_email == $vehicle->customer_email) {
                        $newVehicles[] = array_merge($vehicle->toArray(), ["currency" => $dealer->currency]);
                    }
                }
            }
        }
        if (Auth::user()->role == 'manager') {
            $totalStock = Stocks::count();

            $teamMembers = User::where('manager', Auth::user()->name)
                ->orWhere('name', Auth::user()->name)
                ->pluck('name');

            $totalDealers = CustomerAccounts::whereIn('agent', $teamMembers)
                ->count();

            $customerEmails = CustomerAccounts::whereIn('agent', $teamMembers)
                ->pluck('customer_email');

            $totalCarsSold = CustomerVehicles::whereIn('customer_email', $customerEmails)
                ->whereRaw('amount - payment <= 0')
                ->count();

            $lastTTCopyUploaded = TTUploaded::whereIn('agent', $teamMembers)
                ->orderBy('id', 'DESC')
                ->value('tt_copy');

            $lastCustomerAdded = CustomerAccounts::whereIn('agent', $teamMembers)
                ->orderBy('id', 'DESC')
                ->value('customer_name');


            $data = [
                "totalStock" => $totalStock,
                "totalDealers" => $totalDealers,
                "totalCarsSold" => $totalCarsSold,
                "lastTTCopyUploaded" => $lastTTCopyUploaded ? $lastTTCopyUploaded : null,
                "lastCustomerAdded" => $lastCustomerAdded ? $lastCustomerAdded : 0,
            ];

            $dealers = CustomerAccounts::whereIn('agent', $teamMembers)
                ->orderBy('id', 'DESC')
                ->limit(6)
                ->get();
            $buying = $dealers->sum('buying');
            $deposit = $dealers->sum('deposit');
            $customers = CustomerAccounts::whereIn('agent', $teamMembers)->pluck('customer_email');
            $vehicles = CustomerVehicles::whereIn('customer_email', $customers)
                ->orderBy('id', 'DESC')
                ->limit(6)
                ->get();
            $cnf = $vehicles->sum('amount');
            $payment = $vehicles->sum('payment');

            $newVehicles = [];

            foreach ($dealers as $dealer) {
                foreach ($vehicles as $vehicle) {
                    if ($dealer->customer_email == $vehicle->customer_email) {
                        $newVehicles[] = array_merge($vehicle->toArray(), ["currency" => $dealer->currency]);
                    }
                }
            }
        }

        $stocks = Stocks::orderBy('id', 'DESC')
            ->limit(6)
            ->get();

        return view('pages.index', [
            "title" => "Dashboard",
            "stylesheet" => "dashboard.css",
            "data" => $data,
            "stocks" => $stocks,
            "dealers" => $dealers,
            "buying" => $buying,
            "deposit" => $deposit,
            "newVehicles" => $newVehicles,
            "cnf" => $cnf,
            "payment" => $payment,
        ]);
    }

    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $customerAccounts = CustomerAccounts::orderBy('id', 'DESC')->paginate(6);
        } elseif (Auth::user()->role == 'operational manager') {
            $user_account = Auth::user()->name;
            $users = User::where('name', '!=', $user_account)->pluck('name');
            $agents = $users->push($user_account);
            $customerAccounts = CustomerAccounts::whereIn('agent', $agents)->orderBy('id', 'DESC')->paginate(6);
        } elseif (Auth::user()->role == 'manager') {
            $user_account = Auth::user()->name;
            $users = User::where('manager', $user_account)->pluck('name');
            $agents = $users->push($user_account);
            $customerAccounts = CustomerAccounts::whereIn('agent', $agents)->orderBy('id', 'DESC')->paginate(6);
        } else {
            $customerAccounts = CustomerAccounts::where('agent', Auth::user()->name)->orderBy('id', 'DESC')->paginate(6);
        }

        $buying = CustomerVehicles::sum('amount');
        $deposit = CustomerPayments::sum('in_usd');

        $customerStats = $customerAccounts->map(function ($customer) {
            return [
                "customer" => $customer,
                "buying" => CustomerVehicles::where('customer_email', $customer["customer_email"])->sum('amount'),
                "deposit" => CustomerPayments::where('customer_email', $customer["customer_email"])->sum('in_usd'),
            ];
        });

        return view('pages.customer-account.index', [
            "title" => 'Customer Account',
            "stylesheet" => "customer-account.css",
            "customerAccounts" => $customerAccounts,
            "customerStats" => $customerStats,
            "buying" => $buying,
            "deposit" => $deposit,
        ]);
    }

    public function store(Request $request)
    {
        try {
            CustomerAccounts::create([
                'customer_id' => $request->input('cid'),
                'customer_name' => $request->input('cname'),
                'customer_company' => $request->input('ccompany'),
                'customer_phone' => $request->input('cphone'),
                'customer_whatsapp' => $request->input('cwhatsapp'),
                'customer_email' => $request->input('cemail'),
                'agent_manager' => Auth::user()->manager,
                'currency' => $request->input('ccurrency'),
                'description' => $request->input('cdescription'),
                'address' => $request->input('caddress'),
                'city' => $request->input('ccity'),
                'country' => $request->input('ccountry'),
                'agent' => Auth::user()->role == 'admin'
                    ? $request->input('agent')
                    : Auth::user()->name,
                'manager' => Auth::user()->manager,
            ]);

            User::create(
                [
                    'name' => $request->input('cname'),
                    'email' => $request->input('cemail'),
                    'password' => bcrypt($request->input('cpassword')),
                    'role' => 'customer',
                ]
            );

            TextPassword::create(
                [
                    'email' => $request->input('cemail'),
                    'password' => $request->input('cpassword'),
                ]
            );

            return redirect('/customer-account');
        } catch (Exception $errors) {
            return redirect()
                ->back()
                ->withErrors($errors->getMessage())
                ->withInput();
        }
    }

    public function edit_account($id)
    {
        $customerAccount = CustomerAccounts::where('customer_id', $id)->first();

        $agents = User::whereIn('role', ['agent', 'manager'])
            ->get();
        return view('pages.customer-account.add-account', [
            "title" => $customerAccount["customer_name"] . ' | Customer Account',
            "stylesheet" => "add-customer.css",
            "customerAccount" => $customerAccount,
            "id" => $customerAccount->customer_id,
            "actionUrl" => "/customer-account/update",
            "agents" => $agents
        ]);
    }

    public function render_form()
    {
        $id = $this->generateId();
        $agents = User::whereIn('role', ['agent', 'manager'])
            ->get();
        return view('pages.customer-account.add-account', [
            "title" => "Add Customer Customer",
            "stylesheet" => "add-customer.css",
            "id" => $id,
            "actionUrl" => "/add-customer/post",
            "agents" => $agents
        ]);
    }

    public function update(Request $request)
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
            'city' => $request->input('ccity'),
            'country' => $request->input('ccountry'),
            'agent' => $request->input('agent')
        ]);

        return redirect()->back();
    }

    /** 
     * Retrieve Customer Account Details with related payments

     * @param string $id Customer Id (Format SKI-)
     * @return \Illuminate\View\View The view displaying the customer account
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException When Customer Account would not be found
     */

    public function find(string $id): View
    {
        $account = CustomerAccounts::where('customer_id', $id)->firstOrFail();

        $payments = CustomerPayments::where('customer_email', $account->customer_email)
            ->get();

        $vehicles = CustomerVehicles::where('customer_email', $account->customer_email)
            ->get();

        $vehicles = $vehicles->map(function ($vehicle) {
            // Check if docs exist for this vehicle
            $vehicle->docPresent = Docs::where('stock_id', $vehicle->stock_id)->exists();

            // Fetch shipment data for this vehicle (filtered by stock_id)
            $vehicle->shipment = Shipment::where('stock_id', $vehicle->stock_id)->first();

            return $vehicle;
        });

        // Optimized database queries for totals
        $total = CustomerVehicles::where('customer_email', $account->customer_email)
            ->selectRaw('COALESCE(SUM(amount),0) AS cnf, COALESCE(SUM(payment),0) AS totalPayment')
            ->first();

        $totalCustomerPayments = $payments->sum('in_yen');

        return view('pages.customer-account.view-account', [
            "title" => "Customer Account",
            "stylesheet" => "single-customer-account.css",
            "customerAccount" => $account,
            "customerPayments" => $payments,
            "customerVehicles" => $vehicles,
            "cnf" => $total->cnf,
            "payment" => $total->totalPayment,
            "totalCustomerPayments" => $totalCustomerPayments
        ]);
    }

    public function agent_customers_account(string $name)
    {
        // Get customer accounts for the agent
        $customerAccounts = CustomerAccounts::where('agent', $name)
            ->orderBy('id', 'DESC')
            ->get();

        // Calculate stats (consistent with index() approach)
        $buying = CustomerVehicles::whereIn('customer_email', $customerAccounts->pluck('customer_email'))->sum('amount');
        $deposit = CustomerPayments::whereIn('customer_email', $customerAccounts->pluck('customer_email'))->sum('in_usd');

        // Prepare customer stats if needed (like in index())
        $customerStats = $customerAccounts->map(function ($customer) {
            return [
                "customer" => $customer,
                "buying" => CustomerVehicles::where('customer_email', $customer->customer_email)->sum('amount'),
                "deposit" => CustomerPayments::where('customer_email', $customer->customer_email)->sum('in_usd'),
            ];
        });

        return view('pages.customer-account.agent-customers-account', [
            'title' => $name . ' | Customer Account',
            'stylesheet' => 'customer-account.css',
            'customerAccounts' => $customerAccounts,
            'customerStats' => $customerStats, // Added for consistency
            'agent' => $name,
            'buying' => $buying,
            'deposit' => $deposit,
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

    //     public function export_pdf($id)
    //     {
    //         $customerAccount = CustomerAccounts::where('customer_id', $id)->first();
    //         $customerPayments = CustomerPayments::where('customer_email', $customerAccount->customer_email)->orderBy('id', 'DESC')->get();
    //         $customerPaymentsArray = CustomerPayments::where('customer_email', $customerAccount->customer_email)->orderBy('id', 'DESC')->get()->toArray();
    //         $customerVehicles = CustomerVehicles::where('customer_email', $customerAccount->customer_email)->orderBy('id', 'DESC')->get();
    //         $customerVehiclesArray = CustomerVehicles::where('customer_email', $customerAccount->customer_email)->orderBy('id', 'DESC')->get()->toArray();

    //         $customerVehicleIds = array_column($customerVehiclesArray, 'id');
    //         $customerPaymentsIds = array_column($customerPaymentsArray, 'id');

    //         $cnf = CustomerVehicles::whereIn('id', $customerVehicleIds)->sum('amount');
    //         $payment = CustomerVehicles::whereIn('id', $customerVehicleIds)->sum('payment');

    //         $totalCustomerPayments = CustomerPayments::whereIn('id', $customerPaymentsIds)->sum('in_yen');

    //         $data = [
    //             "title" => "Customer Account",
    //             "stylesheet" => "single-customer-account.css",
    //             "customerAccount" => $customerAccount,
    //             "customerPayments" => $customerPayments,
    //             "customerVehicles" => $customerVehicles,
    //             "cnf" => $cnf,
    //             "payment" => $payment,
    //             "totalCustomerPayments" => $totalCustomerPayments
    //         ];

    //         $pdf = FacadePdf::loadView('pages.customer-account.account-ledger-pdf-export', $data);

    //         return $pdf->download('customer-account.pdf');

    //         // return view('pages.customer-account.account-ledger-pdf-export', [
    //         //     "title" => "Customer Account",
    //         //     "stylesheet" => "single-customer-account.css",
    //         //     "customerAccount" => $customerAccount,
    //         //     "customerPayments" => $customerPayments,
    //         //     "customerVehicles" => $customerVehicles,
    //         //     "cnf" => $cnf,
    //         //     "payment" => $payment,
    //         //     "totalCustomerPayments" => $totalCustomerPayments
    //         // ]);
    //     }
}
