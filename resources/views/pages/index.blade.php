@php
    $countStock = 1;
    $countDealer = 1;
    $countVehicle = 1;
@endphp

@extends('template')
@section('content')
    <section class="dashboard">
        <x-breadcrumbs :page="'Home'" />
        @if (Auth::user()->role == 'admin')
            <div class="counter">
                <div class="item">
                    <h1><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                            <path
                                d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2" />
                            <circle cx="7" cy="17" r="2" />
                            <path d="M9 17h6" />
                            <circle cx="17" cy="17" r="2" />
                        </svg>{{ $data['stockCount'] }}</h1>
                    <p>Total Stock Count</p>
                </div>
                <div class="item">
                    <h1><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                            <circle cx="12" cy="8" r="5" />
                            <path d="M20 21a8 8 0 0 0-16 0" />
                        </svg>{{ $data['userCount'] }}</h1>
                    <p>Total User Count</p>
                </div>
                <div class="item">
                    <a href="/">
                        <img src="{{ asset('images/pdf_icon.png') }}" alt="pdf_icon">
                    </a>
                    <p>Recently Added TT</p>
                </div>
                <div class="item">
                    <h1><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                            <circle cx="12" cy="8" r="5" />
                            <path d="M20 21a8 8 0 0 0-16 0" />
                        </svg>4</h1>
                    <p>New Customers Added</p>
                </div>
                <div class="item">
                    <h1><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                            <path
                                d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2" />
                            <circle cx="7" cy="17" r="2" />
                            <path d="M9 17h6" />
                            <circle cx="17" cy="17" r="2" />
                        </svg>15</h1>
                    <p>New Vehicles Booked</p>
                </div>
            </div>
        @endif
        @if (Auth::user()->role != 'manager')
            <div class="counter">
                <div class="item">
                    <h1><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                            <path
                                d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2" />
                            <circle cx="7" cy="17" r="2" />
                            <path d="M9 17h6" />
                            <circle cx="17" cy="17" r="2" />
                        </svg>{{ $data['totalStock'] }}</h1>
                    <p>Total Stock Count</p>
                </div>
                <div class="item">
                    <h1><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                            <path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7" />
                            <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8" />
                            <path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4" />
                            <path d="M2 7h20" />
                            <path
                                d="M22 7v3a2 2 0 0 1-2 2a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 16 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 12 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 8 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 4 12a2 2 0 0 1-2-2V7" />
                        </svg>
                        </svg>{{ $data['totalDealers'] }}</h1>
                    <p>Total Dealers</p>
                </div>
                <div class="item">
                    <h1><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                            <circle cx="8" cy="21" r="1" />
                            <circle cx="19" cy="21" r="1" />
                            <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
                        </svg>
                        </svg>{{ $data['totalCarsSold'] }}</h1>
                    <p>Total Cars Sold</p>
                </div>
                <div class="item">
                    @if ($data['lastTTCopyUploaded'])
                        <a href="/storage/{{ $data['lastTTCopyUploaded'] }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="file_icon">
                                <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                            </svg>
                        </a>
                    @else
                        <h1>0</h1>
                    @endif
                    <p>Last Uploaded TT</p>
                </div>
                <div class="item">
                    <h1 class="lastCustomerAdded"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon">
                            <circle cx="12" cy="8" r="5" />
                            <path d="M20 21a8 8 0 0 0-16 0" />
                        </svg>{{ $data['lastCustomerAdded'] ? $data['lastCustomerAdded'] : 0 }}</h1>
                    <p>Last Customer Added</p>
                </div>
            </div>
        @endif
        @if (Auth::user()->role == 'agent')
            <div class="content">
                <div class="stocks">
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
                            @foreach ($stocks as $item)
                                <tr>
                                    @if ($countStock < 10)
                                        <td>0{{ $countStock++ }}.</td>
                                    @else
                                        <td>{{ $countStock++ }}.</td>
                                    @endif
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
                                            <a href="https://shinkyowa.com/vehicle-info/{{ $item['id'] }}"
                                                target="__blank">
                                                <button class="done">View</button>
                                            </a>
                                            @if (Auth::user()->role != 'agent')
                                                <a href="/stocks/edit/{{ $item['id'] }}">
                                                    <button class="primary">Edit</button>
                                                </a>
                                                <a href="/{{ $item['id'] }}">
                                                    <button class="danger">Delete</button>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @if ($stocks != [])
                            <tfoot>
                                <tr>
                                    <td colspan="10">
                                        {{ $stocks->links('components.pagination') }}
                                    </td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
                <div class="main-customer-accounts">
                    <table cellspacing="0">
                        <thead>
                            <tr>
                                <th class="sno">S.No</th>
                                <th class="cname">Customer Name</th>
                                <th class="ccompany">Customer Company</th>
                                <th class="buying">Buying</th>
                                <th class="deposit">Deposit</th>
                                <th class="remaining">Remaining</th>
                                @if (Auth::user()->user != 'agent')
                                    <th class="agent">Agent</th>
                                @endif
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dealers as $accounts)
                                <tr>
                                    @if ($countDealer < 10)
                                        <td>0{{ $countDealer++ }}.</td>
                                    @else
                                        <td>{{ $countDealer++ }}.</td>
                                    @endif
                                    <td>{{ $accounts['customer_name'] }}</td>
                                    <td>{{ $accounts['customer_company'] }}</td>
                                    <td>{{ $accounts['buying'] ? $accounts['currency'] . number_format($accounts['buying']) : '' }}
                                    </td>
                                    <td>{{ $accounts['deposit'] ? $accounts['currency'] . number_format($accounts['deposit']) : '' }}
                                    </td>
                                    <td>{{ $accounts['buying'] ? $accounts['currency'] . number_format((int) $accounts['buying'] - (int) $accounts['deposit']) : '' }}
                                    </td>
                                    @if (Auth::user()->user != 'agent')
                                        <td>
                                            <a href="/agent-customers-account/{{ $accounts['agent'] }}">
                                                <button class="agent-btn">{{ $accounts['agent'] }}</button>
                                            </a>
                                        </td>
                                    @endif
                                    <td class="actions">
                                        <div class="stage">
                                            <a href="/customer-account/{{ $accounts['customer_id'] }}">
                                                <button class="account-btn">View Account</button>
                                            </a>
                                            @if (Auth::user()->role == 'admin')
                                                <a href="/customer-account/destroy/{{ $accounts['customer_id'] }}">
                                                    <button class="danger">Delete</button>
                                                </a>
                                            @endif
                                            @if (Auth::user()->role != 'agent')
                                                <a href="/customer-account/edit/{{ $accounts['customer_id'] }}">
                                                    <button class="primary">Edit</button>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        <tfoot>
                            <tr class="total-row">
                                <td></td>
                                <td></td>
                                <td>Total:</td>
                                <td>
                                    {{ '$' . number_format($buying) }}
                                </td>
                                <td>
                                    {{ '$' . number_format($deposit) }}
                                </td>
                                <td>
                                    {{ '$' . number_format($buying - $deposit) }}
                                </td>
                                @if (Auth::user()->user != 'agent')
                                    <td></td>
                                @endif
                                <td></td>
                            </tr>
                        </tfoot>
                        {{ $dealers->links() }}
                        </tbody>
                    </table>
                </div>
                <div id="customer-vehicle-tab">
                    <table class="customer-vehicle" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Stock Id</th>
                                <th>Vehicle</th>
                                <th>Chassis</th>
                                <th>CNF</th>
                                <th>Amount</th>
                                <th>Remaining</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($newVehicles as $customerVehicle)
                                <tr>
                                    @if ($countVehicle < 10)
                                        <td>0{{ $countVehicle++ }}.</td>
                                    @else
                                        <td>{{ $countVehicle++ }}.</td>
                                    @endif
                                    <td>{{ $customerVehicle['stock_id'] }}</td>
                                    <td>{{ $customerVehicle['vehicle'] }}</td>
                                    <td>{{ $customerVehicle['chassis'] }}</td>
                                    <td>{{ $customerVehicle['currency'] . number_format($customerVehicle['amount']) }}</td>
                                    <td>{{ $customerVehicle['payment'] ? $customerVehicle['currency'] . number_format($customerVehicle['payment']) : '' }}
                                    </td>
                                    <td>{{ $customerVehicle['currency'] . number_format($customerVehicle['amount'] - $customerVehicle['payment']) }}
                                    </td>
                                    @if (
                                        $customerVehicle['amount'] - $customerVehicle['payment'] == 0 ||
                                            $customerVehicle['amount'] - $customerVehicle['payment'] < 0)
                                        <td><button class="done">Cleared</button></td>
                                    @else
                                        <td><button class="progress">Pending</button></td>
                                    @endif
                                    <td class="actions">
                                        <div class="stage">
                                            <a href="/customer-account/images/{{ $customerVehicle['stock_id'] }}"><button
                                                    class="image-btn">View
                                                    Images</button></a>
                                            <a href="/customer-account/docs/{{ $customerVehicle['stock_id'] }}"><button
                                                    class="docs-btn">View
                                                    Docs</button></a>
                                            @if (Auth::user()->role == 'admin')
                                                <a href="/customer-vehicle/destroy/{{ $customerVehicle['id'] }}"><button
                                                        class="danger">Delete</button></a>
                                            @endif
                                            @if (Auth::user()->role != 'agent')
                                                <a href="/customer-vehicle/edit/{{ $customerVehicle['stock_id'] }}"><button
                                                        class="primary">Edit</button></a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="total-row">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Total</td>
                                <td>
                                    {{ '$' . number_format($cnf) }}
                                </td>
                                <td>
                                    {{ '$' . number_format($payment) }}
                                </td>
                                <td>
                                    {{ '$' . number_format($cnf - $payment) }}
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        @endif
    </section>
@endsection
