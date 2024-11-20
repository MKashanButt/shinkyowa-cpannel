<?php

namespace App\Http\Controllers;

use App\Models\Docs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleDocsController extends Controller
{
    public function find($stockid)
    {
        $documents = Docs::where('stock_id', $stockid)->get()->pluck('documents');
        $documents = explode(',', $documents);
        return view('pages.vehicle-docs.index', [
            "title" => $stockid . " | Vehicle Documents",
            "documents" => $documents,
            "stockid" => $stockid,
            "stylesheet" => 'single-customer-account.css',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'stock_id' => 'required|string|max:10',
            'documents.*' => 'required|file|mimes:jpg,png,pdf',
        ]);

        $docs = new Docs;
        $docs->stock_id = $request->input('stock_id');
        $original_file_names = [];

        foreach ($request->file('documents') as $file) {
            $filename = $file->getClientOriginalName();
            $file->storeAs('public/', $filename);

            $original_file_names[] = $filename;
        }
        $docs->documents = implode(',', $original_file_names);
        $docs->save();

        return redirect()->back()->with('success', 'Documents Uploaded');
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
