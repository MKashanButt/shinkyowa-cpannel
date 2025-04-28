@extends('template')
@section('content')
    <x-breadcrumbs :page="'Sale'" :subpage="'Documents'" :category="'Add Document'" />
    <section class="doc-add-form">
        @if (session('success'))
            <div class="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        <form action="{{ route('shipment.store') }}" method="POST">
            @csrf
            <div class="field">
                <label for="stockid">Stock Id</label>
                <input type="text" name="stock_id" id="stock_id">
            </div>
            <div class="field">
                <label for="vessel_name">Vessel Name</label>
                <input type="text" name="vessel_name" id="vessel_name">
            </div>
            <div class="field">
                <label for="eta">Eta</label>
                <input type="date" name="eta" id="eta">
            </div>
            <div class="field">
                <label for="etd">Etd</label>
                <input type="date" name="etd" id="etd">
            </div>
            <button class="primary">Add</button>
        </form>
    </section>
@endsection
