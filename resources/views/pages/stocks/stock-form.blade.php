@extends('template')
@section('content')
    <div class="container">
        <x-breadcrumbs :page="'Stocks'" :subpage="'All Stock'" :category="$category" />
        @isset($success)
            <div class="success">
                <p>{{ $success }}</p>
            </div>
        @endisset
        <h2>{{ $formTitle }}</h2>
        <form action="{{ $actionUrl }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="item">
                <label for="stock_id">Stock Id:</label>
                <input type="text" id="stock_id" name="stock_id" value="{{ isset($id) ? $id : '' }}" readonly>
            </div>
            <div class="item">
                <label for="thumbnail">Thumbnail:</label>
                <input type="file" id="thumbnail" name="thumbnail">
            </div>
            <div class="item">
                <label for="images">Images:</label>
                <input type="file" id="images" name="images[]" multiple>
            </div>
            <div class="item">
                <label for="make">Make:</label>
                <input type="text" id="make" name="make" value="{{ isset($data) ? $data['make'] : '' }}">
            </div>
            <div class="item">
                <label for="model">Model:</label>
                <input type="text" id="model" name="model" value="{{ isset($data) ? $data['model'] : '' }}">
            </div>
            <div class="item">
                <label for="year">Year:</label>
                <input type="text" id="year" name="year" value="{{ isset($data) ? $data['year'] : '' }}">
            </div>
            <div class="item">
                <label for="chassis">Chassis:</label>
                <input type="text" id="chassis" name="chassis" value="{{ isset($data) ? $data['chassis'] : '' }}">
            </div>
            <div class="item">
                <label for="body_type">Body Type:</label>
                <select name="body_type" id="body_type">
                    @if (isset($data))
                        <option value="{{ $data['body_type'] }}" selected>{{ $data['body_type'] }}</option>
                    @else
                        <option value="" disabled selected>Select Body Type</option>
                    @endif
                    <option value="hatchback">Hatchback</option>
                    <option value="sedan">Sedan</option>
                    <option value="truck">Truck</option>
                    <option value="suv">SUV</option>
                    <option value="van">Van</option>
                    <option value="pickup">Pickup</option>
                    <option value="wagon">Wagon</option>
                    <option value="buses">Buses</option>
                    <option value="mini buses">Mini Buses</option>
                </select>
            </div>
            <div class="item">
                <label for="fuel">Fuel:</label>
                <select name="fuel" id="fuel">
                    @if (isset($data))
                        <option value="{{ $data['fuel'] }}" selected>{{ $data['fuel'] }}</option>
                    @else
                        <option value="" disabled selected>Select Fuel</option>
                    @endif
                    <option value="petrol">Petrol</option>
                    <option value="diesel">Diesel</option>
                    <option value="hybrid">Hybrid</option>
                </select>
            </div>
            <div class="item">
                <label for="mileage">Mileage:</label>
                <input type="text" id="mileage" name="mileage" value="{{ isset($data) ? $data['mileage'] : '' }}">
            </div>
            <div class="item">
                <label for="transmission">Transmission:</label>
                <select name="transmission" id="transmission">
                    @if (isset($data))
                        <option value="{{ $data['transmission'] }}" selected>{{ $data['transmission'] }}</option>
                    @else
                        <option value="" disabled selected>Select Transmission</option>
                    @endif
                    <option value="manual">Manual</option>
                    <option value="automatic">Automatic</option>
                </select>
            </div>
            <div class="item">
                <label for="doors">Doors:</label>
                <input type="text" id="doors" name="doors" value="{{ isset($data) ? $data['doors'] : '' }}">
            </div>
            <div class="item">
                <label for="country">Country:</label>
                <select name="country" id="country">
                    @if (isset($data))
                        <option value="{{ $data['country'] }}" selected>{{ $data['country'] }}</option>
                    @else
                        <option value="" disabled selected>Select Country</option>
                    @endif
                    <option value="jamaica">Jamaica</option>
                    <option value="bahamas">Bahamas</option>
                    <option value="guyana">Guyana</option>
                    <option value="barbados">Barbados</option>
                    <option value="kenya">Kenya</option>
                    <option value="tanzania">Tanzania</option>
                    <option value="ireland">Ireland</option>
                    <option value="uk">UK</option>
                    <option value="pakistan">Pakistan</option>
                    <option value="mauritius">Mauritius</option>
                </select>
            </div>
            <div class="item">
                <label for="fob">Fob:</label>
                <input type="text" id="fob" name="fob" value="{{ isset($data) ? $data['fob'] : '' }}">
            </div>
            <div class="item">
                <label for="category">Category:</label>
                <select name="category" id="category">
                    @if (isset($data))
                        <option value="{{ $data['category'] }}" selected>{{ $data['category'] }}</option>
                    @else
                        <option value="" disabled selected>Select Category</option>
                    @endif
                    <option value="stock">Stock</option>
                    <option value="new arrival">New Arrival</option>
                    <option value="discounted">Discounted</option>
                    <option value="commercial">Commercial</option>
                </select>
            </div>
            <div class="item">
                <label for="status">Status:</label>
                <select name="status" id="status">
                    @if (isset($data))
                        <option value="{{ $data['status'] }}" selected>{{ $data['status'] }}</option>
                    @else
                        <option value="" disabled selected>Select Status</option>
                    @endif
                    <option value="available">Available</option>
                    <option value="reserved">Reserved</option>
                </select>
            </div>
            <div class="item" style="align-items: baseline">
                <label for="currency">Currency:</label>
                <select name="currency" id="currency">
                    @if (isset($data))
                        <option value="{{ $data['currency'] }}" selected>{{ $data['currency'] }}</option>
                    @else
                        <option value="" disabled selected>Select Currency</option>
                    @endif
                    <option value="¥">¥</option>
                    <option value="£">£</option>
                    <option value="€">€</option>
                    <option value="$">$</option>
                </select>
            </div>
            <div class="item features" style="align-items: baseline">
                <label for="features">Features:</label>
                @if (isset($data))
                    <div class="content">
                        <trix-toolbar id="my_toolbar"></trix-toolbar>
                        <trix-editor toolbar="my_toolbar" input="features">{!! $data['features'] !!}</trix-editor>
                    </div>
                @else
                    <div class="content">
                        <trix-toolbar id="my_toolbar" class="ql-toolbar"></trix-toolbar>
                        <trix-editor toolbar="my_toolbar" input="features" id="editor"></trix-editor>
                    </div>
                @endif
            </div>
            <input type="hidden" id="features" name="features" />
            <button class="primary">Add</button>
        </form>
    </div>
    @if ($actionUrl == '/stocks/add/store')
        <script>
            const thumbnailInput = document.querySelector('#thumbnail');
            const imagesInput = document.querySelector('#images');

            FilePond.create(thumbnailInput, {
                allowMultiple: false,
                server: {
                    url: '/stocks/add/store',
                    process: {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        }
                    },
                },
            });

            FilePond.create(imagesInput, {
                allowMultiple: true,
                server: {
                    url: '/stocks/add/store',
                    process: {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        }
                    },
                },
            });
        </script>
    @endif
@endsection
