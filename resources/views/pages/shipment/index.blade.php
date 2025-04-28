@php
    $sno = ($data->currentPage() - 1) * $data->perPage();
@endphp
@extends('template')
@section('content')
    <section class="user-accounts">
        <x-breadcrumbs :page="'Shipment'" />
        @if (session('success'))
            <div class="alert" style="margin: 20px 0">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        <section class="header">
            <a href="{{ route('shipment.create') }}">
                <div class="content">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="icon">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                        Add Vehicle Shipment
                    </span>
                </div>
            </a>
        </section>
        <div class="container">
            <table cellspacing="0">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Stock Id</th>
                        <th>ETA</th>
                        <th>ETD</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $item)
                        <tr>
                            <td>{{ str_pad($sno + $key + 1, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ ucwords($item['stock_id']) }}</td>
                            <td>{{ $item['eta'] }}</td>
                            <td>{{ $item['etd'] }}</td>
                            <td class="actions">
                                <div class="stage">
                                    @if (Auth::user()->role == 'admin')
                                        <a href="{{ route('shipment.edit', $item) }}">
                                            <button class="primary">Edit</button>
                                        </a>
                                        <form action="{{ route('shipment.destroy', $item) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="danger" type="submit">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @if ($data != [])
                <tfoot>
                    <tr>
                        <td colspan="10">
                            {{ $data->links('components.pagination') }}
                        </td>
                    </tr>
                </tfoot>
                @endif
                </tbody>
            </table>
        </div>
    </section>
@endsection
