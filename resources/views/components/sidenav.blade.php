<?php

$user = auth()->user();

$current_route = \Illuminate\Support\Facades\Route::current();

?>

<div class="px-4 sidenav d-none d-lg-block">

    <div class="d-flex align-items-start mb-4">

        <img src="{{ asset('img/user-avatar.png') }}" alt="User" class="user-avatar">

        <div class="ml-3">
            <h6 class="user-name mb-1">{{ $user->name }}</h6>

            <div class="mb-2">
                {{ $user->email }}
            </div>

            <a href="{{ route('account.logout') }}" class="btn btn-danger btn-sm">Log Out</a>
        </div>

    </div>



    <div class="list-group">

        <a class="list-group-item @if($current_route->getName() == 'app.contacts.all') active @endif " href="{{ route('app.contacts.all') }}">
            <i class="fa fa-fw fa-users mr-3"></i>
            <span>My Contacts</span>
        </a>

        <a class="list-group-item @if($current_route->getName() == 'app.contacts.create') active @endif " href="{{ route('app.contacts.create') }}">
            <i class="fa fa-fw fa-user-plus mr-3"></i>
            <span>Create Contact</span>
        </a>

    </div>

</div>