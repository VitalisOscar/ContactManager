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

            </div>
            {{-- End contact list --}}

            {{-- New contact --}}
            <div class="col-lg-4 d-none">
                <form action="" class="new-contact-form">

                    <div class="form-content">
                        
                        <div class="d-flex align-items-center mb-4">
                            <h4 class="mb-0">Create Contact</h4>

                            <span class="close ml-auto">
                                <i class="fa fa-times"></i>
                            </span>
                        </div>

                        {{-- Inputs --}}
                        <div>

                            {{-- Name --}}
                            <div class="form-group mb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-fw fa-user"></i>
                                        </span>
                                    </div>

                                    <input class="form-control" placeholder="Contact Name" type="text" name="name" value="{{ old('name') }}" required />
                                </div>

                                @error('name')
                                <div class="small text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="form-group mb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-fw fa-envelope"></i>
                                        </span>
                                    </div>

                                    <input class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="Email"/>
                                </div>

                                @error('email')
                                <div class="small text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            

                        </div>
                        {{-- End Inputs --}}

                    </div>

                </form>
            </div>
            {{-- End new contact --}}
        </div>

    
    </div>

</section>

@endsection

<div class="d-none">
@foreach ($contacts as $contact)
    <div>
        <a href="{{ route('app.contacts.single', $contact) }}">
            <img src="{{ $contact->photo }}" alt="{{ $contact->full_name }}" width="50">
            {{ $contact->full_name }}<br>
            {{ $contact->phone }}<br>
        </a>

        <form action="{{ route('app.contacts.delete', $contact) }}" method="post" enctype="multipart/form-data">
            @method('DELETE')
            @csrf
            <input type="submit" value="Delete Contact">
        </form>
    </div>
@endforeach

@dump($errors->all())

New<br>
<form action="{{ route('app.contacts.create') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="text" name="full_name" value="{{ old('full_name') }}" placeholder="Name">
    <input type="text" name="email" value="{{ old('email') }}" placeholder="Email">

    <br>
    Phone Numbers
    <div>
        <input type="text" name="phone_numbers[0][number]" value="{{ old('phone_numbers')[0]['number'] ?? '' }}" placeholder="Phone Number">
        <select name="phone_numbers[0][label]">
            <option value="">Type</option>
            @foreach($labels as $label)
                <option value="{{ $label }}">{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <input type="text" name="phone_numbers[1][number]" value="{{ old('phone_numbers')[1]['number'] ?? '' }}" placeholder="Phone Number">
        <select name="phone_numbers[1][label]">
            <option value="">Type</option>
            @foreach($labels as $label)
                <option value="{{ $label }}">{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <input type="file" name="photo">

    <input type="submit" value="Create">
</form>

</div>
