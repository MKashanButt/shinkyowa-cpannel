@extends('template')
@section('content')
    <section class="recently-added-tts">
        <x-breadcrumbs :page="'Sale'" :subpage="'Recently Added TT'" />
        <div class="container">
            <table cellspacing="0">
                <thead>
                    <tr>
                        <th class="sno">S.No</th>
                        <th class="cemail">Customer Email</th>
                        <th class="cpaymentusd">Payment In USD</th>
                        <th class="cpaymentyen">Payment In Yen</th>
                        <th class="date">Payment Date</th>
                        <th class="upload">Uploaded Date</th>
                        <th class="description">Description</th>
                        <th class="agent">Agent</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($records as $key => $record)
                        <tr>
                            <td>{{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $record['customer_email'] }}</td>
                            <td>{{ '$' . number_format($record['in_usd']) }}</td>
                            <td>{{ '¥' . number_format($record['in_yen']) }}</td>
                            <td>{{ $record['payment_date'] }}</td>
                            <td>{{ $record['created_at'] }}</td>
                            <td>{{ $record['description'] }}</td>
                            <td>
                                <a href="/agent-customers-account/{{ $record['agent'] }}">
                                    <button class="agent-btn">{{ strtoupper($record['agent']) }}</button>
                                </a>
                            </td>
                            <td class="actions">
                                <div class="stage">
                                    @if (Auth::user()->role == 'admin')
                                        <a href="/recently-added-tt/proceed-payments/{{ $record['id'] }}">
                                            <button class="proceed-btn">Proceed</button>
                                        </a>
                                        <a href="/recently-added-tt/edit/{{ $record['id'] }}">
                                            <button class="primary">Edit</button>
                                        </a>
                                        <a href="/recently-added-tt/destroy/{{ $record['id'] }}">
                                            <button class="danger">Delete</button>
                                        </a>
                                    @endif
                                    <a href="{{ asset('storage/' . $record['tt_copy']) }}" target="__blank">
                                        <button class="proceed-btn">View TT</button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
