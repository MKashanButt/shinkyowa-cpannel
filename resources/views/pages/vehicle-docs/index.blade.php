@extends('template')
@section('content')
    <x-breadcrumbs :page="'Sale'" :subpage="'Documents'" />
    @if (Auth::user()->role == 'operational manager' || Auth::user()->role == 'admin')
        <div class="header">
            <a href="/customer-account/docs/{{ $stockid }}/add"><button class="primary">Add Doc</button></a>
        </div>
    @endif
    <div class="docContent">
        {{-- @dd($documents) --}}
        @isset($documents->japanese_export)
            <x-pdf-element :stockid="$stockid" :doc="$documents->japanese_export" :filetitle="'Japanese Export'" />
        @endisset
        @isset($documents->english_export)
            <x-pdf-element :stockid="$stockid" :doc="$documents->english_export" :filetitle="'English Export'" />
        @endisset
        @isset($documents->final_invoice)
            <x-pdf-element :stockid="$stockid" :doc="$documents->final_invoice" :filetitle="'Final Invoice'" />
        @endisset
        @isset($documents->inspection_certificate)
            <x-pdf-element :stockid="$stockid" :doc="$documents->inspection_certificate" :filetitle="'Inspection Certificate'" />
        @endisset
        @isset($documents->bl_copy)
            <x-pdf-element :stockid="$stockid" :doc="$documents->bl_copy" :filetitle="'BL Copy'" />
        @endisset
    </div>
    <section class="modal">
        <div class="container">
            <span class="close">&times;</span>
            <img class="modal-content" id="modal-image">
        </div>
    </section>

    <script>
        const modal = document.querySelector('.modal');
        const modalImage = document.getElementById('modal-image');
        const captionText = document.querySelector('.caption');

        const images = document.querySelectorAll('.vehicle-image');

        images.forEach(image => {
            image.addEventListener('click', () => {
                modal.style.display = 'block';
                modal.style.display = 'flex';
                modalImage.src = image.src;
                captionText.textContent = image.alt;
            });
        });

        const span = document.getElementsByClassName('close')[0];
        span.onclick = function() {
            modal.style.display = 'none';
        }
    </script>
@endsection
