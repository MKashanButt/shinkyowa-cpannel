<aside>
    <img src="/images/logo.png" alt="">
    <nav>
        <ul>
            <a href="/">
                <li>Dashboard</li>
            </a>
            {{-- <a href="/customer-account">
                <li>Company Accounts</li>
            </a> --}}
            <a href="/customer-account">
                <li>Customer Accounts</li>
            </a>
            @if (Auth::user()->role != 'agent')
                <a href="/users">
                    <li>Users</li>
                </a>
            @endif
        </ul>
    </nav>
</aside>
