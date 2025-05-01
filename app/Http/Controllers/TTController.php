<?php

namespace App\Http\Controllers;

use App\Models\CustomerPayments;
use App\Models\CustomerVehicles;
use App\Models\TTUploaded;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class TTController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $records = TTUploaded::where('viewed', false)->get();
        } else {
            $records = TTUploaded::where('viewed', false)
                ->where('agent', Auth::user()->name)
                ->get();
        }

        return view('pages.recently-added-tts.index', [
            'title' => 'Pending TT | Shinkyowa International',
            'records' => $records,
            'stylesheet' => 'recently-added-tts.css',
        ]);
    }

    public function recently_added()
    {
        TTUploaded::where('viewed', false)->update([
            'viewed' => true
        ]);

        $records = TTUploaded::orderBy('id', 'desc')->get()->toArray();
        return view('pages.recently-added-tts.index', [
            'title' => 'Recently Added TTs | Shinkyowa International',
            'records' => $records,
            'stylesheet' => 'recently-added-tts.css'
        ]);
    }

    public function proceed_form(int $id)
    {
        $record = TTUploaded::findOrFail($id);
        $record->paymentReceivedDate = '';

        return view('pages.customer-account.add-payments', [
            'title' => 'Proceding Payment | Shinkyowa International',
            'payment' => $record,
            'stylesheet' => 'customer-payments.css',
            "actionUrl" => '/recently-added-tt/proceed-payments/',
        ]);
    }

    public function proceed_store(Request $request)
    {
        dd($request);
        $customerVehicle = CustomerVehicles::where('stock_id', $request->input('stockId'))->first();

        if (!$customerVehicle) {
            return redirect()->back()->with("progress", "Please Add Vehicle First");
        }

        $USD_FILTERED_AMMOUNT = ltrim($request->input('in_usd'), "$");
        $USD_FILTERED_AMMOUNT = str_replace(',', '', $USD_FILTERED_AMMOUNT);

        $YEN_FILTERED_AMMOUNT = ltrim($request->input('in_yen'), "$");
        $YEN_FILTERED_AMMOUNT = str_replace(',', '', $YEN_FILTERED_AMMOUNT);

        $EXCHANGE_RATE_FILTERED_AMMOUNT = ltrim($request->input('exchange_rate'), "$");
        $EXCHANGE_RATE_FILTERED_AMMOUNT = str_replace(',', '', $EXCHANGE_RATE_FILTERED_AMMOUNT);

        $customer_payment = new CustomerPayments;
        $customer_payment->stock_id = $request->input('stockId');
        $customer_payment->description = $request->input('description');
        $customer_payment->customer_email = $request->input('customer_email');
        $customer_payment->payment_date = $request->input('paymentDate');
        $customer_payment->in_usd = $USD_FILTERED_AMMOUNT;
        $customer_payment->in_yen = $YEN_FILTERED_AMMOUNT;
        $customer_payment->exchange_rate = $EXCHANGE_RATE_FILTERED_AMMOUNT;
        $customer_payment->payment_recieved_date = $request->input('paymentReceivedDate');

        $customer_payment->save();

        TTUploaded::findOrFail($request->input('id'))->delete();

        return redirect()->route("recently-added-tts")->with('success', 'Customer Payment Added');
    }

    public function store_form()
    {
        return view('pages.recently-added-tts.upload-tt', [
            'stylesheet' => 'customer-payments.css',
            'title' => 'Upload TT | Shinkyowa International',
            'actionUrl' => '/tt/add-tt/store',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'stock_id' => 'string',
            'customer_email' => 'required|email|max:120',
            'payment_date' => 'required|date',
            'in_usd' => 'required|string|max:999999.99',
            'in_yen' => 'required|string|max:999999999.99',
            'description' => 'required|string|max:500',
            'tt_copy' => 'required|file|mimes:pdf,png,jpg,jpeg',
            'remittance_name' => 'required|string|max:20'
        ]);

        $model = new TTUploaded();
        $model->stock_id = $request->input('stock_id');
        $model->remittance_name = $request->input('remittance_name');
        $model->customer_email = $request->input('customer_email');
        $model->in_usd = str_replace(',', '', $request->input('in_usd'));
        $model->in_yen = str_replace(',', '', $request->input('in_yen'));
        $model->payment_date = $request->input('payment_date');
        $model->description = $request->input('description');
        $model->agent = Auth::user()->name;

        // Save uploaded file
        $file = $request->file('tt_copy');
        $filename = $file->getClientOriginalName();
        $file->storeAs('public/', $filename);
        $model->tt_copy = $filename;

        if ($model->save()) {
            return redirect()->back()->with('success', 'TT successfully uploaded.');
        } else {
            return redirect()->back()->with('error', 'Error Uploading TT.');
        }
    }

    public function destroy(TTUploaded $tt): RedirectResponse
    {
        $tt->delete();
        return back()->with('toastr', [
            'type' => 'success',
            'message' => 'TT Deleted'
        ]);
    }
}
