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
        <form action="{{ route('stocks.update', $data) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="item">
                <label for="stock_id">Stock Id:</label>
                <input type="text" id="stock_id" name="stock_id" value="{{ old('stock_id', $data['stock_id']) }}" readonly>
            </div>
            <div class="item image-container">
                <div class="info">
                    <label for="thumbnail">Thumbnail:</label>
                    <input type="file" id="thumbnail" name="thumbnail">
                </div>
                <div class="images">
                    <img src="{{ 'storage/' . $data['thumbnail'] }}" alt="Thumbnail" class="vehicle-image">
                </div>
            </div>
            <div class="item image-container">
                <div class="info">
                    <label for="images">Images:</label>
                    <input type="file" id="images" name="images[]" multiple>
                </div>
                <div class="images">
                    @foreach ($data['stock_images'] as $image)
                        <img src="{{ 'storage/' . $image }}" alt="{{ $image }}" class="vehicle-image">
                    @endforeach
                </div>
            </div>
            <div class="item">
                <label for="make">Make:</label>
                <select name="make" id="make" required>
                    <option value="{{ $data['make'] }}" selected>{{ $data['make'] }}</option>
                    <option value="alfa-romeo">Alfa Romeo</option>
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
                <input type="text" id="model" name="model" required value="{{ $data['model'] }}">
            </div>
            <div class="item">
                <label for="year">Year:</label>
                <input type="text" id="year" name="year" required value="{{ $data['year'] }}">
            </div>
            <div class="item">
                <label for="chassis">Chassis:</label>
                <input type="text" id="chassis" name="chassis" required value="{{ $data['chassis'] }}">
            </div>
            <div class="item">
                <label for="body_type">Body Type:</label>
                <select name="body_type" id="body_type" required>
                    <option value="{{ $data['body_type'] }}" selected>{{ $data['body_type'] }}</option>
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
                    <option value="{{ $data['fuel'] }}" selected>{{ $data['fuel'] }}</option>
                    <option value="petrol">Petrol</option>
                    <option value="diesel">Diesel</option>
                    <option value="hybrid">Hybrid</option>
                </select>
            </div>
            <div class="item">
                <label for="mileage">Mileage:</label>
                <input type="text" id="mileage" name="mileage" required value="{{ $data['mileage'] }}">
            </div>
            <div class="item">
                <label for="transmission">Transmission:</label>
                <select name="transmission" id="transmission" required>
                    <option value="{{ $data['transmission'] }}" selected>{{ $data['transmission'] }}</option>
                    <option value="manual">Manual</option>
                    <option value="automatic">Automatic</option>
                </select>
            </div>
            <div class="item">
                <label for="doors">Doors:</label>
                <input type="text" id="doors" name="doors" required value="{{ $data['doors'] }}">
            </div>
            <div class="item">
                <label for="country">Country:</label>
                <select name="country" id="country" required>
                    <option value="{{ $data['country'] }}" selected>{{ $data['country'] }}</option>
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
                <input type="text" id="fob" name="fob" required value="{{ $data['fob'] }}">
            </div>
            <div class="item">
                <label for="category">Category:</label>
                <select name="category" id="category" required>
                    <option value="{{ $data['category'] }}" selected>{{ $data['category'] }}</option>
                    <option value="stock">Stock</option>
                    <option value="new arrival">New Arrival</option>
                    <option value="discounted">Discounted</option>
                    <option value="commercial">Commercial</option>
                </select>
            </div>
            <div class="item">
                <label for="status">Status:</label>
                <select name="status" id="status" required>
                    <option value="{{ $data['status'] }}" selected>{{ $data['status'] }}</option>
                    <option value="available">Available</option>
                    <option value="reserved">Reserved</option>
                </select>
            </div>
            <div class="item" style="align-items: baseline">
                <label for="currency">Currency:</label>
                <select name="currency" id="currency" required>
                    <option value="{{ $data['currency'] }}" selected>{{ $data['currency'] }}</option>
                    <option value="¥">¥</option>
                    <option value="£">£</option>
                    <option value="€">€</option>
                    <option value="$">$</option>
                </select>
            </div>
            <div class="item features" style="align-items: baseline">
                <label for="features">Features:</label>
                <div class="stage">
                    @foreach ($data['features'] as $features)
                        <div class="field">
                            <input type="checkbox" name="{{ $features }}" id="{{ $features }}" checked>
                            {{ strtolower(str_replace('_', ' ', $features)) }}
                        </div>
                    @endforeach
                    @foreach ($missingFeatures as $features)
                        <div class="field">
                            <input type="checkbox" name="{{ $features }}" id="{{ $features }}">
                            {{ strtolower(str_replace('_', ' ', $features)) }}
                        </div>
                    @endforeach
                </div>
            </div>
            <button class="primary">Add</button>
        </form>
    </div>
    <section class="modal">
        <div class="container">
            <div class="action">
                <form action="" method="POST" class="delete-image-form">
                    @csrf
                    @method('DELETE')
                    <button class="danger">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                            <path d="M3 6h18" />
                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                            <line x1="10" x2="10" y1="11" y2="17" />
                            <line x1="14" x2="14" y1="11" y2="17" />
                        </svg>
                    </button>
                </form>
                <button class="close">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
            <img class="modal-content" id="modal-image">
        </div>
    </section>

    <script>
        const modal = document.querySelector('.modal');
        const modalImage = document.getElementById('modal-image');
        const deleteImageForm = document.querySelector('.delete-image-form');
        const captionText = document.querySelector('.caption');

        const images = document.querySelectorAll('.vehicle-image');

        images.forEach(image => {
            image.addEventListener('click', () => {
                modal.style.display = 'block';
                modal.style.display = 'flex';
                modalImage.src = image.src;
                let src = image.src.split("/")
                deleteImageForm.action = `deleteImage/` + src[4]
            });
        });

        const span = document.getElementsByClassName('close')[0];
        span.onclick = function() {
            modal.style.display = 'none';
        }
    </script>
@endsection
