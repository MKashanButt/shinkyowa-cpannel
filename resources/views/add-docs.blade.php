@php
    $title = 'Customer Account | Adding Documents';
    $stylesheet = 'single-customer-account.css';
@endphp

@extends('template')
@section('content')
    <x-breadcrumbs :page="'Sales'" :subpage="'Documents'" :category="'Add Document'" />
    <section>
        <form action="/customer-account/docs/upload" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="field">
                <label for="stockid">Stock Id</label>
                <input type="text" name="stock_id" id="stockid" value="{{ $id }}">
            </div>
            <div class="field">
                <label for="documents">Upload Document</label>
                <input type="file" name="documents[]" id="documents" multiple>
            </div>
            <button class="primary">Add</button>
        </form>
    </section>
@endsection
