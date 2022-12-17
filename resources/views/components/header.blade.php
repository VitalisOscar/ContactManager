<header class="navbar navbar-light bg-white">

    <div class="container-fluid">

        <a href="{{ route('app.contacts.all') }}" class="navbar-brand">
            <img src="{{ asset('img/logo.png') }}" class="logo" alt="Logo" />
            <span>Contact</span>
            <span>Book</span>
        </a>

        <a href="{{ route('account.logout') }}">Log Out</a>

    </div>

</header>