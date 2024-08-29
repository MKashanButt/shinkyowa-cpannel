@extends('template')
@section('content')
    <x-breadcrumbs :page="'Sales'" :subpage="'Documents'" />
    @if (Auth::user()->role == 'operational manager' || Auth::user()->role == 'admin')
        <div class="header">
            <a href="/customer-account/docs/{{ $stockid }}/add"><button class="primary">Add Doc</button></a>
        </div>
    @endif
    <div class="imageContent">
        @foreach ($documents as $docs)
            <img src="{{ env('VEHICLE_IMG_API') . trim($image, '[]"\/') }}" alt="" class="vehicle-image">
        @endforeach
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
