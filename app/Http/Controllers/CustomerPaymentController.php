<?php

namespace App\Http\Controllers;

use App\Models\CustomerAccounts;
use App\Models\CustomerPayments;
use App\Models\CustomerVehicles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerPaymentController extends Controller
{
    public function render_form($email =  null)
    {
        return view('pages.customer-account.add-payments', [
            "title" => "Customer Payments",
            "stylesheet" => "customer-payments.css",
            "actionUrl" => "/add-customer-payment",
            "email" => $email
        ]);
    }

    public function store(Request $request)
    {
        $stockId = $request->input('stockId'); // Use consistently

        $customerVehicle = CustomerVehicles::where('stock_id', $stockId)->first();

        // ✅ Clean and convert amounts properly
        $USD_FILTERED_AMOUNT = (float) str_replace(',', '', ltrim($request->input('in_usd'), "$"));
        $YEN_FILTERED_AMOUNT = (float) str_replace(',', '', ltrim($request->input('in_yen'), "$"));
        $EXCHANGE_RATE_FILTERED_AMOUNT = (float) str_replace(',', '', ltrim($request->input('exchange_rate'), "$"));

        // ✅ Create the CustomerPayments record
        $customer_payment = new CustomerPayments;
        $customer_payment->stock_id = $stockId;
        $customer_payment->description = $request->input('description');
        $customer_payment->customer_email = $request->input('customer_email');
        $customer_payment->payment_date = $request->input('paymentDate');
        $customer_payment->in_usd = $USD_FILTERED_AMOUNT;
        $customer_payment->in_yen = $YEN_FILTERED_AMOUNT;
        $customer_payment->exchange_rate = $EXCHANGE_RATE_FILTERED_AMOUNT;
        $customer_payment->payment_recieved_date = $request->input('paymentReceivedDate');
        $customer_payment->save();

        // ✅ Fetch previous payment properly
        $previousPayment = (float) CustomerVehicles::where('stock_id', $stockId)->value('payment');

        // ✅ Update payment properly
        CustomerVehicles::where('stock_id', $stockId)->update([
            "payment" => $previousPayment + $USD_FILTERED_AMOUNT,
        ]);

        return redirect()->back()->with('success', 'Customer Payment Added');
    }


    public function find($id)
    {
        $payment = CustomerPayments::findOrFail($id);
        return view("pages.customer-account.add-payments", [
            "title" => "Edit Client Payment",
            "stylesheet" => "customer-payments.css",
            "payment" => $payment,
            "actionUrl" => "/customer-payment/update",
        ]);
    }

    public function update(Request $request)
    {
        $PREVIOUS_DEPOSIT = CustomerAccounts::where('customer_email', $request->input('cemail'))->pluck('deposit');
        $USD_FILTERED_AMMOUNT = ltrim($request->input('in_usd'), "$");
        $USD_FILTERED_AMMOUNT = str_replace(',', '', $USD_FILTERED_AMMOUNT);

        $YEN_FILTERED_AMMOUNT = ltrim($request->input('in_yen'), "$");
        $YEN_FILTERED_AMMOUNT = str_replace(',', '', $YEN_FILTERED_AMMOUNT);

        $customerPayments = new CustomerPayments();

        $customerPayments->where('stock_id', $request->input('stockId'))->update([
            "stock_id" => $request->input('stockId'),
            "description" => $request->input('description'),
            "customer_email" => $request->input('cemail'),
            "payment_date" => $request->input('paymentDate'),
            "in_usd" => $USD_FILTERED_AMMOUNT,
            "in_yen" => $YEN_FILTERED_AMMOUNT,
            "payment_recieved_date" => $request->input('paymentReceivedDate'),
        ]);

        $customerAccount = CustomerAccounts::where('customer_email', $request->input('cemail'))->first();
        $customerDeposit = $customerAccount->deposit;

        if ($PREVIOUS_DEPOSIT[0] < ($customerDeposit + $USD_FILTERED_AMMOUNT)) {
            $customerAccount->update([
                'deposit' => $customerDeposit + ($USD_FILTERED_AMMOUNT - $PREVIOUS_DEPOSIT[0])
            ]);
        } elseif ($PREVIOUS_DEPOSIT[0] > ($customerDeposit + $USD_FILTERED_AMMOUNT)) {
            $customerAccount->update([
                'deposit' => $customerDeposit - ($PREVIOUS_DEPOSIT[0] - $USD_FILTERED_AMMOUNT)
            ]);
        }

        return redirect()->back()->with('success', 'Vehicle Uploaded');
    }

    public function destroy($stockid, $email, $payment)
    {
        DB::transaction(function () use ($stockid, $email, $payment) {
            $vehicle = CustomerVehicles::where('stock_id', $stockid)->first();
            if ($vehicle) {
                $updatedPayment = max(0, $vehicle->payment - $payment); // Ensure payment does not go below zero
                $vehicle->update(['payment' => $updatedPayment]);
                $vehicle->save();
            }
            $account = CustomerAccounts::where('customer_email', $email)->first();

            if ($account) {
                $updatedOverallPayment = max(0, $account->deposit - $payment); // Ensure deposit does not go below zero
                $account->update(['deposit' => $updatedOverallPayment]);
                $account->save();
            }

            CustomerPayments::where('stock_id', $stockid)->delete();
        });

        return redirect()->back()->with('success', 'Payment Deleted');
    }
}
