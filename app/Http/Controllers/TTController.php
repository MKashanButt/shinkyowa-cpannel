<?php

namespace App\Http\Controllers;

use App\Models\TTUploaded;
use Exception;
use Illuminate\Cache\RedisTaggedCache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\returnSelf;

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
            "actionUrl" => '/add-customer-payment',
        ]);
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
            'stock_id' => 'required|string',
            'customer_email' => 'required|email|max:120',
            'payment_date' => 'required|date',
            'in_usd' => 'required|numeric|max:999999.99',
            'in_yen' => 'required|numeric|max:999999999.99',
            'description' => 'required|string|max:500',
            'tt_copy' => 'required|file|mimes:pdf,png,jpg,jpeg',
            'remittance_name' => 'required|string|max:20'
        ]);

        $model = new TTUploaded();
        $model->stock_id = $request->input('stock_id');
        $model->remittance_name = $request->input('remittance_name');
        $model->customer_email = $request->input('customer_email');
        $model->in_usd = $request->input('in_usd');
        $model->in_yen = $request->input('in_yen');
        $model->payment_date = $request->input('payment_date');
        $model->description = $request->input('description');
        $model->agent = Auth::user()->name;

        // Save uploaded file
        $file = $request->file('tt_copy');
        $filename = $file->getClientOriginalName();
        $file->storeAs('public/', $filename);
        $model->tt_copy = $filename;

        $model->save();

        return redirect()->back()->with('success', 'TT successfully uploaded.');
    }
}
