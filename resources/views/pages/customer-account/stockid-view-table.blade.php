@php
    $count = 1;
@endphp
@extends('template')
@section('content')
    <section class="stockid-filter-table">
        <x-breadcrumbs :page="'Filter'" :subpage="'Search By Stock'" />
        <x-customer-options />
        <div class="container">
            <table cellspacing="0">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Image</th>
                        <th>Stock Id</th>
                        <th>Vehicle Name</th>
                        <th>Customer Email</th>
                        <th>Fob</th>
                        <th>status</th>
                        <th>agent</th>
                        <th>Payment Done In Yen</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @if ($count < 10)
                            <td>0{{ $count++ }}.</td>
                        @else
                            <td>{{ $count++ }}.</td>
                        @endif
                        <td><img src="{{ env('VEHICLE_IMG_API') . $record['thumbnail'] }}" alt=""
                                class="vehicle-image"></td>
                        <td>{{ $record['stock_id'] }}</td>
                        <td>{{ $record['make'] . ' ' . $record['model'] . ' ' . $record['year'] }}</td>
                        <td>
                            <form action="/search/email" method="POST">
                                @csrf
                                <input type="hidden" name="searchByEmail" value="{{ $record['customer_email'] }}">
                                <button>{{ $record['customer_email'] }}</button>
                            </form>
                        </td>
                        <td>{{ $record['fob'] }}</td>
                        <td><button disabled>{{ $record['status'] }}</button></td>
                        <td><a href="/agent-customers-account/{{ $record['agent'] }}"><button
                                    class="agent-btn">{{ $record['agent'] }}</button></a></td>
                        <td>{{ $record['in_yen'] == 0 ? 'None' : $record['in_yen'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
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
                // Optional: Add caption if available
                captionText.textContent = image.alt;
            });
        });

        const span = document.getElementsByClassName('close')[0];
        span.onclick = function() {
            modal.style.display = 'none';
        }
    </script>
@endsection
