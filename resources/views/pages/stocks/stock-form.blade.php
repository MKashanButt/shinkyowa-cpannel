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
                <input type="file" id="thumbnail" name="thumbnail" required>
            </div>
            <div class="item">
                <label for="images">Images:</label>
                <input type="file" id="images" name="images[]" multiple required>
            </div>
            <div class="item">
                <label for="make">Make:</label>
                <select name="make" id="make" required>
                    @if (isset($data))
                        <option value="{{ $data['make'] }}" selected>{{ $data['make'] }}</option>
                    @else
                        <option value="" disabled selected>Select Body Type</option>
                    @endif
                    <option value="alfa romeo">Alfa Romeo</option>
                    <option value="toyota">Toyota</option>
                    <option value="nissan">Nissan</option>
                    <option value="mazda">Mazda</option>
                    <option value="mitsubishi">Mitsubishi</option>
                    <option value="honda">Honda</option>
                    <option value="suzuki">Suzuki</option>
                    <option value="subaru">Subaru</option>
                    <option value="isuzu">Isuzu</option>
                    <option value="daihatsu">Daihatsu</option>
                    <option value="mitsuoka">Mitsuoka</option>
                    <option value="lexus">Lexus</option>
                    <option value="bmw">BMW</option>
                    <option value="mercedes">Mercedes</option>
                    <option value="audi">Audi</option>
                    <option value="hino">Hino</option>
                    <option value="volkswagen">Volkswagen</option>
                </select>
            </div>
            <div class="item">
                <label for="model">Model:</label>
                <input type="text" id="model" name="model" value="{{ isset($data) ? $data['model'] : '' }}"
                    required>
            </div>
            <div class="item">
                <label for="year">Year:</label>
                <input type="text" id="year" name="year" value="{{ isset($data) ? $data['year'] : '' }}"
                    required>
            </div>
            <div class="item">
                <label for="chassis">Chassis:</label>
                <input type="text" id="chassis" name="chassis" value="{{ isset($data) ? $data['chassis'] : '' }}"
                    required>
            </div>
            <div class="item">
                <label for="body_type">Body Type:</label>
                <select name="body_type" id="body_type" required>
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
                <select name="fuel" id="fuel" required>
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
                <input type="text" id="mileage" name="mileage" value="{{ isset($data) ? $data['mileage'] : '' }}"
                    required>
            </div>
            <div class="item">
                <label for="transmission">Transmission:</label>
                <select name="transmission" id="transmission" required>
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
                <input type="text" id="doors" name="doors" value="{{ isset($data) ? $data['doors'] : '' }}"
                    required>
            </div>
            <div class="item">
                <label for="country">Country:</label>
                <select name="country" id="country" required>
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
                <input type="text" id="fob" name="fob" value="{{ isset($data) ? $data['fob'] : '' }}"
                    required>
            </div>
            <div class="item">
                <label for="category">Category:</label>
                <select name="category" id="category" required>
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
                <select name="status" id="status" required>
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
                <select name="currency" id="currency" required>
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
                <div class="stage">
                    <div class="field">
                        <input type="checkbox" name="cd_player" id="cd_player">
                        <label for="cd_player">CD Player</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="sun_roof" id="sun_roof">
                        <label for="sun_roof">Sun Roof</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="leather_seat" id="leather_seat">
                        <label for="leather_seat">Leather Seat</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="alloy_wheels" id="alloy_wheels">
                        <label for="alloy_wheels">Alloy Wheels</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="power_steering" id="power_steering">
                        <label for="power_steering">Power Steering</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="power_window" id="power_window">
                        <label for="power_window">Power Window</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="a_c" id="a_c">
                        <label for="a_c">A/C</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="abs" id="abs">
                        <label for="abs">ABS</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="airbag" id="airbag">
                        <label for="airbag">Airbag</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="radio" id="radio">
                        <label for="radio">Radio</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="cd_changer" id="cd_changer">
                        <label for="cd_changer">CD Changer</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="dvd" id="dvd">
                        <label for="dvd">DVD</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="tv" id="tv">
                        <label for="tv">TV</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="power_seat" id="power_seat">
                        <label for="power_seat">Power Seat</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="back_tire" id="back_tire">
                        <label for="back_tire">Back Tire</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="grill_guard" id="grill_guard">
                        <label for="grill_guard">Grill Guard</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="rear_spoiler" id="rear_spoiler">
                        <label for="rear_spoiler">Rear Spoiler</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="central_locking" id="central_locking">
                        <label for="central_locking">Central Locking</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="jack" id="jack">
                        <label for="jack">Jack</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="spare_tire" id="spare_tire">
                        <label for="spare_tire">Spare Tire</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="wheel_spanner" id="wheel_spanner">
                        <label for="wheel_spanner">Wheel Spanner</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="fog_lights" id="fog_lights">
                        <label for="fog_lights">Fog Lights</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="back_camera" id="back_camera">
                        <label for="back_camera">Back Camera</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="push_start" id="push_start">
                        <label for="push_start">Push Start</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="keyless_entry" id="keyless_entry">
                        <label for="keyless_entry">Keyless Entry</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="esc" id="esc">
                        <label for="esc">ESC</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="360_degree_camera" id="360_degree_camera">
                        <label for="360_degree_camera">360 Degree Camera</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="body_kit" id="body_kit">
                        <label for="body_kit">Body Kit</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="side_airbag" id="side_airbag">
                        <label for="side_airbag">Side Airbag</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="power_mirror" id="power_mirror">
                        <label for="power_mirror">Power Mirror</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="side_skirts" id="side_skirts">
                        <label for="side_skirts">Side Skirts</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="front_lip_spoiler" id="front_lip_spoiler">
                        <label for="front_lip_spoiler">Front Lip Spoiler</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="navigation" id="navigation">
                        <label for="navigation">Navigation</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="turbo" id="turbo">
                        <label for="turbo">Turbo</label>
                    </div>
                    <div class="field">
                        <input type="checkbox" name="power_slide_door" id="power_slide_door">
                        <label for="power_slide_door">Power Slide Door</label>
                    </div>
                </div>
            </div>
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
