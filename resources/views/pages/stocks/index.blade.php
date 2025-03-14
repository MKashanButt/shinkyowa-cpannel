@php
    $sno = ($data->currentPage() - 1) * $data->perPage();
@endphp

@extends('template')
@section('content')
    <section class="stocks">
        <x-breadcrumbs :page="'Stocks'" :subpage="'All Stock'" />
        @if (session('success'))
            <div class="alert" style="margin: 20px 0">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if (session('error'))
            <div class="danger alert" style="margin: 20px 0">
                <p>{{ session('error') }}</p>
            </div>
        @endif
        @if (Auth::user()->role != 'agent')
            <a href="{{ route('stocks.create') }}">
                <button class="header">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                        <path
                            d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2" />
                        <circle cx="7" cy="17" r="2" />
                        <path d="M9 17h6" />
                        <circle cx="17" cy="17" r="2" />
                    </svg>
                    Add Vehicle
                </button>
            </a>
        @endif
        <div class="searchForm">
            <h1>Search Stock Id:</h1>
            <form action="/search/stockid" method="POST">
                @csrf
                <input type="search" name="search" id="search" placeholder="Search By Stock Id or Chassis..."
                    value="{{ Request::get('search') ? Request::get('search') : '' }}">
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 512 512">
                        <path d="M256 80a176 176 0 10176 176A176 176 0 00256 80z" fill="none" stroke="currentColor"
                            stroke-miterlimit="10" stroke-width="32" />
                        <path d="M232 160a72 72 0 1072 72 72 72 0 00-72-72z" fill="none" stroke="currentColor"
                            stroke-miterlimit="10" stroke-width="32" />
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10"
                            stroke-width="32" d="M283.64 283.64L336 336" />
                    </svg>
                </button>
            </form>
        </div>
        <div class="container">
            <table cellspacing="0">
                <thead>
                    <tr>
                        <th class="sno">S.No</th>
                        <th class="image">Image</th>
                        <th class="stock_id">Stock Id</th>
                        <th class="chassis">Chassis</th>
                        <th class="make_model">Make/Model</th>
                        <th class="year">Year</th>
                        <th class="body">Body</th>
                        <th class="fob">FOB</th>
                        <th class="status">Status</th>
                        <th class="actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $item)
                        <tr>
                            <td>{{ str_pad($sno + $key + 1, 2, '0', STR_PAD_LEFT) }}</td>
                            <td><img src="{{ asset('storage/' . $item['thumbnail']) }}" alt=""
                                    onerror="this.src='https://placehold.co/200x100'"></td>
                            <td>{{ $item['stock_id'] }}</td>
                            <td>{{ $item['chassis'] }}</td>
                            <td>{{ $item['make'] . '/' . $item['model'] }}</td>
                            <td>{{ $item['year'] }}</td>
                            <td>{{ $item['body_type'] }}</td>
                            <td>{{ $item['currency'] . $item['fob'] }}</td>
                            <td>
                                <button
                                    class="{{ $item['status'] == 'reserved' ? 'reserved danger' : 'primary' }}">{{ $item['status'] }}</button>
                            </td>
                            <td class="actions">
                                <div class="stage">
                                    <a href="https://shinkyowa.com/vehicle-info/{{ $item['id'] }}" target="__blank">
                                        <button class="done">View</button>
                                    </a>
                                    @if (Auth::user()->role != 'agent')
                                        <a href="{{ route('stocks.edit', $item) }}" target="_blank">
                                            <button class="primary">Edit</button>
                                        </a>
                                        <form action="{{ route('stocks.destroy', $item) }} " method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="danger">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                @if ($data != [])
                    <tfoot>
                        <tr>
                            <td colspan="10">
                                {{ $data->links('components.pagination') }}
                            </td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </section>
@endsection
