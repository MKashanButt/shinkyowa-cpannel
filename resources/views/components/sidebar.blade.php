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
            @if (Auth::user()->role == 'admin')
                <a href="/recently-added-tts">
                    <li class="{{ Auth::user()->hasUnviewedTTs() ? 'tt-added' : '' }}">Recently Added TT's
                        @if (Auth::user()->hasUnviewedTTs())
                            <span class="alert">{{ Auth::user()->unviewedTTCount() }}</span>
                        @endif
                    </li>
                </a>
            @endif
            {{-- @if (Auth::user()->role == 'agent' || Auth::user()->role == 'manager') --}}
            <div x-data='{open: false}' x-cloak>
                <li @click='open=!open' @click.outside='open=false'>TTs</li>
                <div class="sub-menu" x-show="open" x-transition>
                    <ul>
                        <a href="/tt/pending-tts">
                            <li>Pending TT's</li>
                        </a>
                        <a href="/tt/add-tt">
                            <li>Add New TT</li>
                        </a>
                    </ul>
                </div>
            </div>
            {{-- @endif --}}
            @if (Auth::user()->role != 'agent')
                <a href="/users">
                    <li>Users</li>
                </a>
            @endif
        </ul>
    </nav>
</aside>
