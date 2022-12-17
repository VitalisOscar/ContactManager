@extends('app')

@section('title', 'Create an account')

@section('content')

<section class="py-4 py-md-5">
    <div class="container">

        <div class="row">

            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto">

                {{-- Signup form --}}
                <form method="post" action="{{ route('account.register') }}">
                    @csrf

                    <div class="border rounded mb-3">

                        <div class="px-4 pt-5 pb-1 top text-center">
                            <a class="logo d-block mb-4">
                                <img class="logo" src="{{ asset('img/logo.png') }}" />
                            </a>

                            <h4 class="mb-0">Create account</h4>
                        </div>

                        {{-- Inputs --}}
                        <div class="px-3 px-sm-4 py-4">

                            {{-- Name --}}
                            <div class="form-group mb-3">
                                <label>Your Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-fw fa-user"></i>
                                        </span>
                                    </div>

                                    <input class="form-control" placeholder="Full Name" type="text" name="name" value="{{ old('name') }}" required />
                                </div>

                                @error('name')
                                <div class="small text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="form-group mb-3">
                                <label>Email Address</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-fw fa-envelope"></i>
                                        </span>
                                    </div>

                                    <input class="form-control" type="email" name="email" value="{{ old('email') }}" required />
                                </div>

                                @error('email')
                                <div class="small text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="form-group mb-4">
                                <label>Set a password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-fw fa-lock"></i>
                                        </span>
                                    </div>

                                    <input class="form-control" type="password" name="password" value="{{ old('password') }}" required />

                                    <div class="input-group-append pass-toggle" onclick="togglePasswordVisibility()">
                                        <span class="input-group-text" id="passwordToggleText">
                                            Show
                                        </span>
                                    </div>
                                </div>

                                @error('password')
                                <div class="small text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- End inputs --}}


                            <div class="mb-3">
                                <button class="btn btn-main btn-block shadow-none">Submit</button>
                            </div>

                            <div>
                                By signing up, you agree to our
                                &nbsp;<a href="#">Terms of Service</a>&nbsp;
                                and <a href="#">Privacy Policy</a>
                            </div>

                        </div>

                    </div>


                    <div class="text-center">
                        <span>Already Registered? <a href="{{ route('account.login') }}">Log In</a></span>
                    </div>

                </form>
                {{-- End signup form --}}

            </div>

        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    function togglePasswordVisibility(){
        var password = document.querySelector('[name=password]');
        var triggerElement = document.querySelector('#passwordToggleText')

        if(password.type == 'password'){
            password.type = 'text'
            triggerElement.innerText = 'Hide'
        }else{
            password.type = 'password'
            triggerElement.innerText = 'Show'
        }
    }
</script>
@endsection
