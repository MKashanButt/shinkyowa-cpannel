<div class="customer-options">
    <div class="search">
        <h3>Customer Account Options</h3>
        <div class="stage">
            <form action="/search/email" method="POST">
                @csrf
                <input type="search" name="searchByEmail" id="searchByEmail" placeholder="Search By Customer Email"
                    value="{{ Request::get('searchByEmail') ? Request::get('searchByEmail') : '' }}">
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
            <form action="/search/company" method="POST">
                @csrf
                <input type="search" name="searchByCompany" id="searchByCompany"
                    placeholder="Search By Customer Company"
                    value="{{ Request::get('searchByCompany') ? Request::get('searchByCompany') : '' }}">
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
    </div>
    <div class="customer-btns">
        <a href="/add-customer-account">
            <button>Add Customer Account</button>
        </a>
        @if (Auth::user()->role == 'admin')
            <a href="/add-customer-payment/{{ isset($customeremail) ? $customeremail : '' }}">
                <button>Add
                    Customer Payment</button>
            </a>
        @endif
        <a href="/add-customer-vehicle/{{ isset($customeremail) ? $customeremail : '' }}">
            <button>Add Customer Vehicle</button>
        </a>
    </div>
</div>
