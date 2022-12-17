<header class="navbar navbar-default bg-white navbar-expand-md">

    <div class="container-fluid">

        <a href="{{ route('app.contacts.all') }}" class="navbar-brand">
            <img src="{{ asset('img/logo.png') }}" class="logo" alt="Logo" />
            <span>Contact</span>
            <span>Book</span>
        </a>

        <button class="btn ml-auto d-md-none navbar-toggle" data-toggle="collapse" data-target="#menu">
            <i class="fa fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse mx-auto" id="menu">

            <ul class="nav navbar-nav mx-md-auto">
                <li class="nav-item mt-3 mb-2 mt-md-0 mb-md-0">
                    <a href="{{ route('app.contacts.all') }}" class="nav-link">My Contacts</a>
                </li>

                <li class="nav-item mb-2 mb-md-0">
                    <a href="{{ route('app.contacts.create') }}" class="nav-link">New Contact</a>
                </li>
            </ul>

            <a href="{{ route('account.logout') }}" class="btn btn-main ml-auto mb-3 mb-md-0">Log Out</a>
        </div>

    </div>

</header>