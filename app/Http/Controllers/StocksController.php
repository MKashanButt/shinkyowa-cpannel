<?php

namespace App\Http\Controllers;

use App\Models\Stocks;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

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
        $stocks = Stocks::orderBy('id', 'DESC')->paginate(8)->onEachSide(1);

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
                'fob' => str_replace(",", "", $request->input('fob')),
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

    public function create()
    {
        $id = $this->generate_skid();
        $title = "Shinkyowa International | Add Vehicle Stock";
        $stylesheet = "stock-form.css";
        $formTitle = "Add Vehicle Info";
        $category = "Add Vehicle";

        return view('pages.stocks.create', compact(
            "title",
            "stylesheet",
            "formTitle",
            "category",
            "id",
        ));
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

    public function edit(string $id)
    {
        $data = Stocks::findOrFail($id);
        $title = "Shinkyowa International | Add Vehicle Stock";
        $stylesheet = "stock-form.css";
        $formTitle = "Add Vehicle Info";
        $category = "Add Vehicle";

        $existingFeatures = [
            'cd_player',
            'sun_roof',
            'leather_seat',
            'alloy_wheels',
            'power_steering',
            'power_window',
            'a_c',
            'abs',
            'airbag',
            'radio',
            'cd_changer',
            'dvd',
            'tv',
            'power_seat',
            'back_tire',
            'grill_guard',
            'rear_spoiler',
            'central_locking',
            'jack',
            'spare_tire',
            'wheel_spanner',
            'fog_lights',
            'back_camera',
            'push_start',
            'keyless_entry',
            'esc',
            '360_degree_camera',
            'body_kit',
            'side_airbag',
            'power_mirror',
            'side_skirts',
            'front_lip_spoiler',
            'navigation',
            'turbo',
            'power_slide_door'
        ];

        $missingFeatures = array_diff($existingFeatures, $data["features"]);

        return view('pages.stocks.edit', compact(
            "title",
            "stylesheet",
            "formTitle",
            "category",
            "data",
            "missingFeatures"
        ));
    }

    public function update(Request $request, $id)
    {
        $requestData = $request->all();

        $checkboxes = array_filter($requestData, function ($value, $key) {
            return $value === "on";
        }, ARRAY_FILTER_USE_BOTH);

        $checkboxNames = array_keys($checkboxes);

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

        $stock->make = trim($request->make);
        $stock->model = trim($request->model);
        $stock->year = trim($request->year);
        $stock->chassis = trim($request->chassis);
        $stock->body_type = $request->body_type;
        $stock->fuel = $request->fuel;
        $stock->mileage = $request->mileage;
        $stock->transmission = $request->transmission;
        $stock->doors = $request->doors;
        $stock->country = $request->country;
        $stock->fob = str_replace(",", "", $request->input('fob'));
        $stock->category = $request->category;
        $stock->status = $request->status;
        $stock->currency = $request->currency;
        $stock->features = $checkboxNames;

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $stock->thumbnail = $thumbnailPath;
        }

        if ($request->hasFile('images')) {
            $imagesPaths = [];
            foreach ($request->file('images') as $image) {
                $imagesPaths[] = $image->store('images', 'public');
            }
            $stock->stock_images = json_encode($imagesPaths);
        }

        $stock->save();

        return redirect()->back()->with('success', 'Stock updated successfully!');
    }

    public function deleteImage(string $id, string $image_name): RedirectResponse
    {
        $stock = Stocks::findOrFail($id);
        $images = $stock->stock_images;
        $updatedImages = array_filter($images, function ($image) use ($image_name) {
            return $image !== $image_name;
        });
        $updatedImages = array_values($updatedImages);
        $stock->stock_images = $updatedImages;
        $stock->save();

        return redirect()->back()->with('success', 'Image removed successfully.');
    }

    public function destroy(string $id)
    {
        try {
            $stock = Stocks::where('stock_id', $id)->firstOrFail();

            DB::beginTransaction();

            if ($stock->thumbnail) {
                Storage::delete('public/' . $stock->thumbnail);
            }

            if (!empty($stock->stock_images)) {
                foreach ($stock->stock_images as $image) {
                    Storage::delete('public/' . $image);
                }
            }

            $stock->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Stock deleted successfully!');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Stock not found.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error deleting stock: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete stock. Please try again.');
        }
    }
}
