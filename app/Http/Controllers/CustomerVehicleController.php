<?php

namespace App\Http\Controllers;

use App\Models\CustomerAccounts;
use App\Models\CustomerPayments;
use App\Models\CustomerVehicles;
use App\Models\Stocks;
use Illuminate\Http\Request;

class CustomerVehicleController extends Controller
{
    public function images($stockid)
    {
        $stock = Stocks::where('stock_id', $stockid)->pluck('stock_images');

        return view('vehicle-images', [
            "title" => $stockid . " | Vehicle Images",
            "images" => explode(',', $stock[0]),
            "stylesheet" => 'single-customer-account.css',
        ]);
    }

    public function find($stockid)
    {
        $vehicle = CustomerVehicles::where('stock_id', $stockid)->first();
        return view('pages.customer-account.add-vehicle', [
            "title" => "Customer Vehicle Edit",
            "stylesheet" => "add-customer-vehicle.css",
            "vehicle" => $vehicle,
            "actionUrl" => "/customer-vehicle/update"
        ]);
    }

    public function update(Request $request)
    {
        $PREVIOUS_BUYING = CustomerAccounts::where('customer_email', $request->input('cemail'))->pluck('buying');
        $FILTERED_AMMOUNT = ltrim($request->input('amount'), "$");
        $FILTERED_AMMOUNT = str_replace(',', '', $FILTERED_AMMOUNT);

        $customerVehicles = new CustomerVehicles;

        $customerVehicles->where('stock_id', $request->input('stockId'))->update([
            "stock_id" => $request->input('stockId'),
            "vehicle" => $request->input('vehicle'),
            "chassis" => $request->input('chassis'),
            "fob_or_cnf" => $request->input('fob-cnf'),
            "amount" => $FILTERED_AMMOUNT,
            "customer_email" => $request->input('cemail'),
            "status" => $request->input('status'),
        ]);

        $customerAccount = CustomerAccounts::where('customer_email', $request->input('cemail'))->first();
        $customerBuying = $customerAccount->buying;

        if ($PREVIOUS_BUYING[0] < ($customerBuying + $FILTERED_AMMOUNT)) {
            $customerAccount->update([
                'buying' => $customerBuying + ($FILTERED_AMMOUNT - $PREVIOUS_BUYING[0])
            ]);
        } elseif ($PREVIOUS_BUYING[0] > ($customerBuying + $FILTERED_AMMOUNT)) {
            $customerAccount->update([
                'buying' => $customerBuying - ($PREVIOUS_BUYING[0] - $FILTERED_AMMOUNT)
            ]);
        }

        return redirect()->back()->with('success', 'Vehicle Uploaded');
    }

    public function render_form($email =  null)
    {
        return view('pages.customer-account.add-vehicle', [
            "title" => "Add Customer Vehicle",
            "stylesheet" => "add-customer-vehicle.css",
            "actionUrl" => "/add-customer-vehicle/post",
            "email" => $email,
        ]);
    }

    public function store(Request $request)
    {
        $FILTERED_AMMOUNT = ltrim($request->input('amount'), "$");
        $FILTERED_AMMOUNT = str_replace(',', '', $FILTERED_AMMOUNT);

        $customerVehicles = new CustomerVehicles();
        $customerVehicles->stock_id = $request->input('stockId');
        $customerVehicles->vehicle = $request->input('vehicle');
        $customerVehicles->chassis = $request->input('chassis');
        $customerVehicles->fob_or_cnf = $request->input('fob-cnf');
        $customerVehicles->amount = $FILTERED_AMMOUNT;
        $customerVehicles->customer_email = $request->input('customer_email');
        $customerVehicles->status = $request->input('status');

        $customerVehicles->save();

        $stocks = Stocks::where('stock_id', $request->input('stockId'))->first();
        if ($stocks) {
            $stocks->status = 'reserved';
            $stocks->customer_email = $request->input('customer_email');
            $stocks->save();
        }

        $customerAccount = CustomerAccounts::where('customer_email', $request->input('customer_email'))->first();
        $customerBuying = $customerAccount->buying;
        if ($customerAccount) {
            $customerAccount->buying = (int) $customerBuying + (int) $FILTERED_AMMOUNT;
            $customerAccount->save();
        }

        return redirect()->back()->with('success', 'Vehicle Uploaded');
    }

    public function findImages($stockid)
    {
        $stock = Stocks::where('stock_id', $stockid)->pluck('stock_images');

        return view('pages.customer-account.vehicle-images', [
            "title" => $stockid . " | Vehicle Images",
            "images" => explode(',', $stock[0]),
            "stylesheet" => 'single-customer-account.css',
        ]);
    }

    public function destroy($id)
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
}
