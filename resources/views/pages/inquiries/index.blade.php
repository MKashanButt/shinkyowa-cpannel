@php
    $sno = ($data->currentPage() - 1) * $data->perPage();
@endphp

@extends('template')
@section('content')
    <section class="inquiries">
        <x-breadcrumbs :page="'Inquiries'" />
        @if (session('success'))
            <div class="alert" style="margin: 20px 0">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        <div class="container">
            <table cellspacing="0">
                <thead>
                    <tr>
                        <th class="sno">S.No</th>
                        <th class="stock_id">Stock Id</th>
                        <th class="destination">Destination</th>
                        <th class="full_name">Full Name</th>
                        <th class="email">Email</th>
                        <th class="phone">Phone No</th>
                        <th class="country">Country</th>
                        <th class="comment">Status</th>
                        <th class="actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $item)
                        <tr>
                            <td>{{ str_pad($sno + $key + 1, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $item['stock_id'] }}</td>
                            <td>{{ $item['destination'] }}</td>
                            <td>{{ $item['full_name'] }}</td>
                            <td>{{ $item['email_address'] }}</td>
                            <td>{{ $item['phone'] }}</td>
                            <td>{{ $item['country'] }}</td>
                            <td>{{ $item['comment'] }}</td>
                            <td class="actions">
                                <div class="stage">
                                    <a href="inquiries/destroy/{{ $item['id'] }}">
                                        <button class="danger">Delete</button>
                                    </a>
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
