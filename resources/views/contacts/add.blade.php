@extends('app')

@section('title', 'Create Contact')

@section('content')

{{-- Header --}}
@include('components.header')

<div class="breadcrumb">
    <a href="{{ route('app.contacts.all') }}" class="breadcrumb-item">
        Contacts
    </a>

    <a class="breadcrumb-item active">
        Add New
    </a>
</div>

<section class="py-4 py-md-5">
    <div class="container-fluid">

        <div class="row">

            <div class="col-lg-3">
                @include('components.sidenav')
            </div>

            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto">

                {{-- form --}}
                <form method="post" action="{{ route('app.contacts.create') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4 text-center">
                        <h4 class="mb-0">Create Contact</h4>
                    </div>

                    <div class="mb-4 border rounded p-3">

                        {{-- Inputs --}}

                        {{-- Contact Photo --}}
                        <div class="form-group mb-4 new-contact-photo">
                            <img onclick="document.querySelector('#photo').click()" src="{{ asset('img/default-photo.png') }}" alt="Pic" id="photo-preview" class="mx-auto mb-3">

                            <label>Contact Photo</label>
                            <input type="file" class="form-control-file" name="photo" id="photo" accept="image/*" />
                        </div>

                        {{-- Name --}}
                        <div class="form-group mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-fw fa-user"></i>
                                    </span>
                                </div>

                                <input class="form-control" placeholder="Contact Name" type="text" name="full_name" value="{{ old('full_name') }}" required />
                            </div>

                            @error('full_name')
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

                                <input class="form-control" type="email" name="email" placeholder="Add Email" value="{{ old('email') }}" />
                            </div>

                            <span class="small">Optional</span>

                            @error('email')
                            <div class="small text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Phone Numbers --}}
                        <div id="phone_numbers">

                            {{-- In case there were phone numbers submitted before, e.g if the form has errors and redirected back --}}
                            {{-- We add all of them on the form --}}
                            <?php $i = 0; ?>

                            @foreach (old('phone_numbers') ?? [] as $phone_number)
                            <div class="form-group mb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-fw fa-phone"></i>
                                        </span>
                                    </div>

                                    <input class="form-control" type="tel" name="phone_numbers[{{ $i }}][number]" placeholder="Phone Number" value="{{ $phone_number['number'] ?? '' }}" />

                                    <select class="form-control" name="phone_numbers[{{ $i }}][label]">
                                        <option value="">Type</option>
                                        @foreach($labels as $label)
                                            <option value="{{ $label }}" @if(($phone_number['label'] ?? '') == $label){{ __("selected='selected'") }}@endif >{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <?php $i++; ?>
                            @endforeach

                        </div>

                        {{-- Add phone button --}}
                        {{-- When clicked, we should add new phone number entry fields to the form --}}
                        <button type="button" class="add-phone btn btn-link mb-3" onclick="addPhoneNumber('', '')">
                            Add Phone Number
                        </button>

                        {{-- Stay on page after create --}}
                        <div class="form-group mb-4">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="stay_on_page" name="stay_on_page" />
                                <label class="custom-control-label" style="font-weight: 400" for="stay_on_page">Stay on page after adding contact</label>
                            </div>
                        </div>

                        {{-- End inputs --}}

                        <div class="mb-3">
                            <button class="btn btn-main btn-block shadow-none">Save Contact</button>
                        </div>

                    </div>

                    <div class="text-center">
                        <span>Back to <a href="{{ route('app.contacts.all') }}">all contacts</a></span>
                    </div>

                </form>
                {{-- End form --}}

            </div>

        </div>
    </div>
</section>

@endsection

{{-- index takes the value of $i in case we have already added some numbers on the form already --}}
@section('scripts')

<script>
    // Will track the number of added phone numbers
    var index = {{ $i }}

    var labels = []

</script>

{{-- Add to the js labels array --}}
@foreach($labels as $label)
<script>
    labels.push('{{ $label }}')
</script>
@endforeach

<script>

// Function adds a phone number entry fields to the form
function addPhoneNumber(phone, type){

    var labelOptions = labels.map(function(label){
        return "<option value='" + label + "'>" + label + "</option>"
    })

    var newElement = document.createElement("div");
    newElement.innerHTML = `
        <div class="form-group mb-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-fw fa-phone"></i>
                    </span>
                </div>

                <input class="form-control" type="tel" name="phone_numbers[${index}][number]" placeholder="Phone Number" value="${phone}" />

                <select class="form-control" name="phone_numbers[${index}][label]">
                    <option value="">Type</option>
                    ${labelOptions}
                </select>
            </div>

        </div>
    `

    // Add to existing phone numbers
    document.querySelector('#phone_numbers').append(newElement)

    // Increment number of phone numbers
    index++;
}

</script>


{{-- In case there were no phone numbers submitted before, e.g if the form has errors and redirected back --}}
@if(!old('phone_numbers'))
{{-- we add one blank field to the form --}}

<script>
    addPhoneNumber("", "")
</script>

@endif

@endsection
