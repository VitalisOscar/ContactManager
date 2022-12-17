@extends('app')

@section('title', 'Contact Manager')

@section('content')

{{-- Header --}}
@include('components.header')

<div class="breadcrumb">
    <a class="breadcrumb-item active">
        Contacts
    </a>
</div>

<section class="py-4 py-md-5">

    <div class="container-fluid">

        <div class="row">

            <div class="col-lg-3">
                @include('components.sidenav')
            </div>

            {{-- Contact list --}}
            <div class="col-lg-9 px-lg-4 px-xl-5">

                @if($contacts->count() > 0)

                <div class="mb-3 small">
                    {{ 'You have ' . $contacts->count(). ' contact'.($contacts->count() == 1 ? '':'s') }}
                </div>

                {{-- Labels --}}
                <div class="row">
                    <div class="col-6 col-sm-3">
                        <h6>Name</h6>
                    </div>

                    <div class="col-4 d-none d-sm-block">
                        <h6>Email</h6>
                    </div>

                    <div class="col-3 col-sm-2">
                        <h6>Phone</h5>
                    </div>
                </div>

                <hr>

                {{-- Contacts --}}
                @foreach ($contacts as $contact)
                @include('components.contact')
                @endforeach

                @else

                {{-- No contacts --}}

                <div class="text-cente col-md-10 col-lg-7">
                    <h4>No Contact</h4>

                    <p>
                        Looks like you have deleted all your contacts or have not added any.
                        Every contact you add will be shown here
                    </p>

                    <hr>

                    <div class="text-right">
                        <a href="{{ route('app.contacts.create') }}" class="btn btn-primary">Add One <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>

                @endif

            </div>
            {{-- End contact list --}}
        </div>

    
    </div>

</section>

@endsection
