<div class="customer-options">
    <h3>Customer Account Options</h3>
    <div class="stage">
        <form action="/search" method="GET">
            <input type="search" name="search" id="search" placeholder="Search By Customer Email"
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
        <a href="/add-customer-account"><button class="customer-account">Add Customer Account</button></a>
        <a href="/add-customer-payment/{{ isset($customeremail) ? $customeremail : '' }}"><button
                class="customer-payment">Add
                Customer Payment</button></a>
        <a href="/add-customer-vehicle/{{ isset($customeremail) ? $customeremail : '' }}"><button
                class="customer-vehicle">Add Customer Vehicle</button></a>
    </div>
</div>
