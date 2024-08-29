@php
    $title = 'Customer Account | Adding Documents';
    $stylesheet = 'single-customer-account.css';
@endphp

@extends('template')
@section('content')
    <x-breadcrumbs :page="'Sales'" :subpage="'Documents'" :category="'Add Document'" />
    <section>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="field">
                <label for="stockid">Stock Id</label>
                <input type="text" name="stockid" id="stockid" value="{{ $id }}">
            </div>
            <div class="field">
                <label for="docs">Upload Docs</label>
                <input type="file" name="docs" id="docs" multiple>
            </div>
        </form>
    </section>
@endsection
