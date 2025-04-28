<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Stocks;
use Illuminate\Http\Request;
use Illuminate\View\View as View;

class ShipmentController extends Controller
{
    public function index(): View
    {
        $data = Shipment::orderBy('id', 'DESC')
            ->paginate(10);
        $title = "Shipments";
        $stylesheet = "users.css";
        return view('pages.shipment.index', compact('data', 'title', 'stylesheet'));
    }

    public function create(): View
    {
        $title = "Add Shipment";
        $stylesheet = "users.css";
        return view('pages.shipment.create', compact('title', 'stylesheet'));
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'stock_id' => 'required',
            'eta' => 'required',
            'etd' => 'required',
        ]);

        Shipment::create($data);

        return redirect()->route('shipment.index')->with('success', 'Shipment created successfully.');
    }

    public function edit($id): View
    {
        $data = Shipment::findOrFail($id);
        $title = "Edit Shipment";
        $stylesheet = "users.css";
        return view('pages.shipment.edit', compact('data', 'title', 'stylesheet'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'stock_id' => 'required',
            'eta' => 'required',
            'etd' => 'required',
        ]);

        Shipment::findOrFail($id)->update($data);

        return redirect()->route('shipment.index')->with('success', 'Shipment updated successfully.');
    }

    public function destroy($data)
    {
        $shipment = Shipment::findOrFail($data);
        $shipment->delete();

        return redirect()->route('shipment.index')->with('success', 'Shipment deleted successfully.');
    }
}
