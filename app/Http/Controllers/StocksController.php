<?php

namespace App\Http\Controllers;

use App\Models\Stocks;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StocksController extends Controller
{
    public function generate_skid()
    {
        $lastStock = Stocks::latest('id')->first();

        if ($lastStock) {
            $lastSkid = (int) str_replace('SKI-', '', $lastStock->stock_id);
            $newSkid = $lastSkid + 1;
        } else {
            $newSkid = 1;
        }

        return 'SKI-' . $newSkid;
    }

    public function index()
    {
        $stocks = Stocks::paginate(8)->onEachSide(1);

        if ($stocks->isEmpty()) {
            return view('pages.stocks.index', [
                "title" => "Shinkyowa International | Vehicle Stock",
                "stylesheet" => "stocks.css",
                "data" => [],
            ]);
        }
        return view('pages.stocks.index', [
            "title" => "Shinkyowa International | Vehicle Stock",
            "stylesheet" => "stocks.css",
            "data" => $stocks,
        ]);
    }

    public function render_form()
    {
        $id = $this->generate_skid();

        return view('pages.stocks.stock-form', [
            "title" => "Shinkyowa International | Add Vehicle Stock",
            "stylesheet" => "stock-form.css",
            "formTitle" => "Add Vehicle Info",
            "category" => "Add Vehicle",
            "id" => $id,
            "actionUrl" => "/stocks/add/store"
        ]);
    }

    public function store(Request $request)
    {
        try {
            $requestData = $request->all();

            $checkboxes = array_filter($requestData, function ($value, $key) {
                return $value === "on";
            }, ARRAY_FILTER_USE_BOTH);

            $checkboxNames = array_keys($checkboxes);

            $request->validate([
                'stock_id' => 'required|string|unique:stocks,stock_id',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'make' => 'required|string',
                'model' => 'required|string',
                'year' => 'required|string',
                'chassis' => 'nullable|string',
                'body_type' => 'nullable|string',
                'fuel' => 'nullable|string',
                'mileage' => 'nullable|string|min:0',
                'transmission' => 'nullable|string',
                'doors' => 'nullable',
                'country' => 'nullable|string',
                'fob' => 'nullable|string|min:0',
                'category' => 'nullable|string',
                'status' => 'nullable|string',
                'currency' => 'nullable|string',
            ]);

            DB::beginTransaction();

            $thumbnailPath = $this->uploadFile($request, 'thumbnail', 'public');
            $imagePaths = $this->uploadMultipleFiles($request, 'images', 'public');

            Stocks::create([
                'stock_id' => $request->input('stock_id'),
                'thumbnail' => $thumbnailPath,
                'stock_images' => $imagePaths,
                'make' => $request->input('make'),
                'model' => $request->input('model'),
                'year' => $request->input('year'),
                'chassis' => $request->input('chassis'),
                'body_type' => $request->input('body_type'),
                'fuel' => $request->input('fuel'),
                'mileage' => $request->input('mileage'),
                'transmission' => $request->input('transmission'),
                'doors' => $request->input('doors'),
                'country' => $request->input('country'),
                'fob' => $request->input('fob'),
                'category' => $request->input('category'),
                'status' => $request->input('status'),
                'currency' => $request->input('currency'),
                'features' => $checkboxNames,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Stock added successfully!');
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error creating stock: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to add stock. Please try again.');
        }
    }

    public function show(string $id)
    {
        $data = Stocks::findOrFail($id);
        return view('pages.stocks.stock-form', [
            "title" => "Shinkyowa International | Update Vehicle Stock",
            "data" => $data,
            "id" => $data["stock_id"],
            "stylesheet" => "stock-form.css",
            "actionUrl" => "/stocks/edit/$id/update",
            "formTitle" => "Update Vehicle Info",
            "category" => "Update Vehicle"
        ]);
    }

    private function uploadFile(Request $request, string $fieldName, string $disk): ?string
    {
        if ($request->hasFile($fieldName)) {
            $file = $request->file($fieldName);
            $tempName = $file->getClientOriginalName();
            $file->storeAs($disk, $tempName);
            return $tempName;
        }

        return null;
    }

    /**
     * Handle multiple file uploads.
     */
    private function uploadMultipleFiles(Request $request, string $fieldName, string $disk): array
    {
        $paths = [];

        if ($request->hasFile($fieldName)) {
            foreach ($request->file($fieldName) as $file) {
                $tempName = $file->getClientOriginalName();
                $paths[] = $tempName;
                $file->storeAs($disk, $tempName);
            }
        }

        return $paths;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|string',
            'chassis' => 'required|string|max:255',
            'body_type' => 'required|string',
            'fuel' => 'required|string',
            'mileage' => 'required|string',
            'transmission' => 'required|string',
            'doors' => 'required|string',
            'country' => 'required|string',
            'fob' => 'required|string',
            'category' => 'required|string',
            'status' => 'required|string|max:255',
            'currency' => 'required|string',
            'features' => 'nullable|string',
        ]);

        $stock = Stocks::findOrFail($id);

        $stock->make = $request->make;
        $stock->model = $request->model;
        $stock->year = $request->year;
        $stock->chassis = $request->chassis;
        $stock->body_type = $request->body_type;
        $stock->fuel = $request->fuel;
        $stock->mileage = $request->mileage;
        $stock->transmission = $request->transmission;
        $stock->doors = $request->doors;
        $stock->country = $request->country;
        $stock->fob = $request->fob;
        $stock->category = $request->category;
        $stock->status = $request->status;
        $stock->currency = $request->currency;
        $stock->features = $request->features;

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $stock->thumbnail = $thumbnailPath;
        }

        if ($request->hasFile('images')) {
            $imagesPaths = [];
            foreach ($request->file('images') as $image) {
                $imagesPaths[] = $image->store('images', 'public');
            }
            $stock->images = json_encode($imagesPaths);
        }

        $stock->save();

        return redirect()->back()->with('success', 'Stock updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
