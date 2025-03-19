<?php

namespace App\Http\Controllers;

use App\Models\CustomerAccounts;
use App\Models\CustomerPayments;
use App\Models\CustomerVehicles;
use App\Models\Stocks;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    /**
     * Update Customer Vehicle Details
     * 
     * @param Request $request fetching from form input
     * On return redirecting back to the form page with success message
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException When Customer Account would not be found
     */

    public function update(Request $request): RedirectResponse
    {
        try {
            // Running a DB::transaction to avoid data inconsistencies. Rolling back if any errors found
            DB::transaction(function () use ($request): void {
                $data = $request->validate([
                    "vehicle" => ["required", "string", "max:100"],
                    "chassis" => ["required", "string", "max:100"],
                    "fob_or_cnf" => ["required", "string", "in:FOB,CNF"],
                    "amount" => ["required", "string"],
                    "customer_email" => ["required", "string"],
                    "status" => ["required", "string", "in:reserved, available"],
                ]);

                $FILTERED_AMMOUNT = ltrim($request->input('amount'), "$");
                $FILTERED_AMMOUNT = str_replace(',', '', $FILTERED_AMMOUNT);

                $data["amount"] = $FILTERED_AMMOUNT;

                CustomerVehicles::where("stock_id", $request->input("stockId"))->update($data);
            });

            return redirect()->back()->with('success', 'Vehicle Uploaded');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
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
        $customerVehicles->fob_or_cnf = $request->input('fob_or_cnf');
        $customerVehicles->amount = trim($FILTERED_AMMOUNT);
        $customerVehicles->customer_email = $request->input('customer_email');
        $customerVehicles->status = $request->input('status');

        $customerVehicles->save();

        $stocks = Stocks::where('stock_id', $request->input('stockId'))->first();
        if ($stocks) {
            $stocks->status = 'reserved';
            $stocks->customer_email = $request->input('customer_email');
            $stocks->save();
        }

        return redirect()->back()->with('success', 'Vehicle Uploaded');
    }

    public function findImages($stockid)
    {
        $stock = json_decode(Stocks::where('stock_id', $stockid)->pluck('stock_images'));

        return view('pages.customer-account.vehicle-images', [
            "title" => $stockid . " | Vehicle Images",
            "images" => $stock[0],
            "stylesheet" => 'single-customer-account.css',
        ]);
    }

    public function destroy($id)
    {
        $stockid = CustomerVehicles::where('id', $id)->pluck('stock_id');

        CustomerVehicles::where('id', $id)->delete();

        CustomerPayments::where('stock_id', $stockid)->update([
            'stock_id' => 'not allocated'
        ]);

        Stocks::where('stock_id', $stockid)->update([
            'status' => 'available'
        ]);

        return redirect()->back();
    }
}
