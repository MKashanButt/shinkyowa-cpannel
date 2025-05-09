<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UrgentPaymentController extends Controller
{
    public function index(){
        $shipment = Shipment::all();
        $vehicles = CustomerVehicles::where('amount', '>', 'payment')
            ->get();
        return view('urgent-payment', compact('payments'));
    }
}
