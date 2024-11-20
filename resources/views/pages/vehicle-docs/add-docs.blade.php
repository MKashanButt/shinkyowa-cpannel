@php
    $title = 'Customer Account | Adding Documents';
    $stylesheet = 'single-customer-account.css';
@endphp

@extends('template')
@section('content')
    <x-breadcrumbs :page="'Sales'" :subpage="'Documents'" :category="'Add Document'" />
    <section class="doc-add-form">
        @if (session('success'))
            <div class="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        <form action="/customer-account/docs/upload" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="field">
                <label for="stockid">Stock Id</label>
                <input type="text" name="stock_id" id="stockid" value="{{ $id }}" readonly>
            </div>
            @isset($documents)
                @if (!$documents->japanese_export)
                    <div class="field">
                        <label for="japanese_export">Upload Japanese Export</label>
                        <input type="file" name="japanese_export" id="japanese_export">
                    </div>
                @endif
                @if (!$documents->english_export)
                    <div class="field">
                        <label for="english_export">Upload English Export</label>
                        <input type="file" name="english_export" id="english_export">
                    </div>
                @endif
                @if (!$documents->final_invoice)
                    <div class="field">
                        <label for="final_invoice">Upload Final Invoice</label>
                        <input type="file" name="final_invoice" id="final_invoice">
                    </div>
                @endif
                @if (!$documents->inspection_certificate)
                    <div class="field">
                        <label for="inspection_certificate">Upload Inspection Certificate</label>
                        <input type="file" name="inspection_certificate" id="inspection_certificate">
                    </div>
                @endif
                @if (!$documents->bl_copy)
                    <div class="field">
                        <label for="bl_copy">Upload BL Copy</label>
                        <input type="file" name="bl_copy" id="bl_copy">
                    </div>
                @endif
            @endisset
            <button class="primary">Add</button>
            @if (
                $documents->japanese_export &&
                    $documents->english_export &&
                    $documents->final_invoice &&
                    $documents->inspection_certificate &&
                    $documents->bl_copy)
                <button class="primary" disabled style="top: 0">All Documents have been uploaded</button>
            @endif
        </form>
    </section>
@endsection
