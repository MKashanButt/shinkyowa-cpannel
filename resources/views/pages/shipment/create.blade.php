@extends('template')
@section('content')
    <div class="container">
        <x-breadcrumbs :page="'Sale'" :subpage="'Shipment'" :category="'Add Shipment'" />
        <h2>Add Shipment</h2>
        <form action="{{ route('shipment.store') }}" method="POST">
            @csrf
            <div class="item">
                <label for="stockid">Stock Id</label>
                <input type="text" name="stock_id" id="stock_id">
            </div>
            <div class="item">
                <label for="vessel_name">Vessel Name</label>
                <input type="date" name="vessel_name" id="vessel_name">
            </div>
            <div class="item">
                <label for="eta">Eta</label>
                <input type="date" name="eta" id="eta">
            </div>
            <div class="item">
                <label for="etd">Etd</label>
                <input type="text" name="etd" id="etd">
            </div>
            <button class="primary" style="top: 100px">Add</button>
        </form>
    </div>
@endsection
