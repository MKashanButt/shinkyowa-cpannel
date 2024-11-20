<?php

namespace App\Http\Controllers;

use App\Models\Docs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleDocsController extends Controller
{
    public function find($stockid)
    {
        $documents = Docs::where('stock_id', $stockid)->first();
        return view('pages.vehicle-docs.index', [
            "title" => $stockid . " | Vehicle Documents",
            "documents" => $documents,
            "stockid" => $stockid,
            "stylesheet" => 'single-customer-account.css',
        ]);
    }

    public function render_form($stockid)
    {
        $present = Docs::where('stock_id', $stockid)->first();
        return view('pages.vehicle-docs.add-docs', [
            'documents' => $present ? $present : false,
            'id' => $stockid,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'stock_id' => 'required|string|max:10',
            'japanese_export' => 'nullable|file|mimes:pdf',
            'english_export' => 'nullable|file|mimes:pdf',
            'final_invoice' => 'nullable|file|mimes:pdf',
            'inspection_certificate' => 'nullable|file|mimes:pdf',
            'bl_copy' => 'nullable|file|mimes:pdf',
        ]);

        // Define file fields
        $fileFields = ['japanese_export', 'english_export', 'final_invoice', 'inspection_certificate', 'bl_copy'];

        // Check if a record already exists for the given stock ID
        $recordPresent = Docs::where('stock_id', $request->input('stock_id'))->first();

        if ($recordPresent) {
            // Update only the fields for which new files are uploaded
            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $filename = $file->getClientOriginalName();
                    $file->storeAs('public/', $filename); // Store the file
                    $recordPresent->$field = $filename;   // Update file name in the database
                }
            }
            $recordPresent->save();

            return redirect()->back()->with('success', 'Documents Updated Successfully');
        }

        // If no record exists, create a new one
        $docs = new Docs();
        $docs->stock_id = $request->input('stock_id');

        // Save uploaded files
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = $file->getClientOriginalName();
                $file->storeAs('public/', $filename);
                $docs->$field = $filename;
            }
        }

        $docs->save();

        return redirect()->back()->with('success', 'Documents Uploaded Successfully');
    }




    public function delete(Request $request)
    {
        $request->validate([
            'stock_id' => 'required|string|max:10',
            'filename' => 'required|string'
        ]);

        $docs = Docs::where('stock_id', $request->input('stock_id'))->first();

        if ($docs) {
            $fileNames = explode(',', $docs->documents);

            if (in_array($request->input('filename'), $fileNames)) {
                Storage::delete('public/' . trim($request->input('filename')));

                $fileNames = array_filter($fileNames, function ($name) use ($request) {
                    return $name !== $request->input('filename');
                });

                $docs->documents = implode(',', $fileNames);
                $docs->save();

                return redirect()->back()->with('success', 'Document Deleted');
            }

            return redirect()->back()->with('error', 'File not found in records');
        }

        return redirect()->back()->with('error', 'No documents found for this stock ID');
    }
}
