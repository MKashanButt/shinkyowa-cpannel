@php
    $count = 1;
@endphp
@extends('template')
@section('content')
    <section class="docs-table">
        <x-breadcrumbs :page="'Docs'" :subpage="'All Vehicles'" />
        <x-customer-options />
        @if (session('success'))
            <div class="alert" style="margin: 20px 0">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        <div class="container">
            <table cellspacing="0">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Stock Id</th>
                        <th>Vehicle</th>
                        <th>Chassis</th>
                        <th>Customer Email</th>
                        <th>Docs Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($records as $record)
                        <tr>
                            @if ($count < 10)
                                <td>0{{ $count++ }}.</td>
                            @else
                                <td>{{ $count++ }}.</td>
                            @endif
                            <td>{{ $record['stock_id'] }}</td>
                            <td>{{ $record['vehicle'] }}</td>
                            <td>{{ $record['chassis'] }}
                            </td>
                            <td>{{ $record['customer_email'] }}
                            </td>
                            @if ($record['is_complete'])
                                <td>
                                    <a href="/customer-account/docs/{{ $record['stock_id'] }}">
                                        <button class="primary">Complete</button>
                                    </a>
                                </td>
                            @else
                                <td>
                                    <a href="/customer-account/docs/{{ $record['stock_id'] }}/add">
                                        <button class="danger">Remaining</button>
                                    </a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection

<script>
    $('table').scrollTableBody();
</script>
