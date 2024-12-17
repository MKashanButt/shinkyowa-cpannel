<?php

namespace App\Http\Controllers;

use App\Models\CustomerVehicles;
use App\Models\Docs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleDocsController extends Controller
{
    public function index()
    {
        // Fetch all customer vehicles and docs
        $vehicles = CustomerVehicles::all()->toArray();
        $docs = Docs::all()->toArray();

        // Prepare a map for docs keyed by stock_id for quick lookup
        $docsByStockId = [];
        foreach ($docs as $doc) {
            $docsByStockId[$doc['stock_id']] = $doc; // Group docs by stock_id
        }

        // Merge doc data with vehicle data and check for completeness
        $result = [];
        foreach ($vehicles as $vehicle) {
            $stockId = $vehicle['stock_id'];
            $vehicleDocs = $docsByStockId[$stockId] ?? []; // Get docs for the current vehicle

            // Check if all required docs are present
            $requiredDocs = ['english_export', 'japanese_export']; // The required document columns
            $allDocsPresent = true;

            foreach ($requiredDocs as $docColumn) {
                // Check if the doc exists and is not null or empty
                if (empty($vehicleDocs[$docColumn])) {
                    $allDocsPresent = false;
                    break;
                }
            }

            $vehicle['docs'] = $vehicleDocs; // Attach the documents
            $vehicle['is_complete'] = $allDocsPresent; // True if all required docs are present

            $result[] = $vehicle;
        }

        // Filter the data if needed (e.g., by specific stock_id)
        $filteredStockId = request('stock_id'); // Example: filter by stock_id from query parameter
        if ($filteredStockId) {
            $result = array_filter($result, function ($vehicle) use ($filteredStockId) {
                return $vehicle['stock_id'] == $filteredStockId;
            });
        }

        // Return the result as a JSON response or pass to a view
        return view('pages.vehicle-docs.docs-table', [
            'records' => $result,
            'stylesheet' => 'docs-table.css',
            'title' => 'Documents | All Vehicle Documents'
        ]);
    }

    public function not_uploaded()
    {
        $vehicles = CustomerVehicles::all()->toArray();
        $docs = Docs::all()->toArray();

        // Prepare a map for docs keyed by stock_id for quick lookup
        $docsByStockId = [];
        foreach ($docs as $doc) {
            $docsByStockId[$doc['stock_id']] = $doc; // Group docs by stock_id
        }

        // Merge doc data with vehicle data and check for completeness
        $result = [];
        foreach ($vehicles as $vehicle) {
            $stockId = $vehicle['stock_id'];
            $vehicleDocs = $docsByStockId[$stockId] ?? []; // Get docs for the current vehicle

            // Check if all required docs are present
            $requiredDocs = ['english_export', 'japanese_export']; // The required document columns
            $allDocsPresent = true;

            foreach ($requiredDocs as $docColumn) {
                // Check if the doc exists and is not null or empty
                if (empty($vehicleDocs[$docColumn])) {
                    $allDocsPresent = false;
                    break;
                }
            }

            $vehicle['docs'] = $vehicleDocs; // Attach the documents
            $vehicle['is_complete'] = $allDocsPresent; // True if all required docs are present
            if (!$allDocsPresent) {
                $result[] = $vehicle;
            }
        }

        // Filter the data if needed (e.g., by specific stock_id)
        $filteredStockId = request('stock_id'); // Example: filter by stock_id from query parameter
        if ($filteredStockId) {
            $result = array_filter($result, function ($vehicle) use ($filteredStockId) {
                return $vehicle['stock_id'] == $filteredStockId;
            });
        }

        // Return the result as a JSON response or pass to a view
        return view('pages.vehicle-docs.docs-table', [
            'records' => $result,
            'stylesheet' => 'docs-table.css',
            'title' => 'Documents | All Vehicle Documents'
        ]);
    }

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
            'documents' => $present ? $present : (object) [
                'japanese_export' => false,
                'english_export' => false,
                'final_invoice' => false,
                'inspection_certificate' => false,
                'bl_copy' => false
            ],
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
