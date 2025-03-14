<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index()
    {
        return view('pages.inquiries.index', [
            "stylesheet" => "inquiries.css",
            "title" => "Customer Inquiries | Shinkyowa International",
            "data" => Inquiry::orderBy('id', 'DESC')
                ->paginate(6)
        ]);
    }

    public function destroy($id)
    {
        Inquiry::destroy($id);

        return redirect()->back()->with('success', 'Inquiry Deleted');
    }
}
