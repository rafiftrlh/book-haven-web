@extends('layouts.main_register')
@section('main_register')
    {{-- content --}}
    <main class="main-content  mt-0">
        <section class="min-vh-100 mb-8">
            <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
                style="background-image: url('../assets/img/curved-images/curved14.jpg');">
                <span class="mask bg-gradient-dark opacity-6"></span>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 text-center mx-auto">
                            <h1 class="text-white mb-2 mt-5">Welcome!</h1>
                            <p class="text-lead text-white">Use these awesome forms to login or create new account in your
                                project for free.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row mt-lg-n10 mt-md-n11 mt-n10">
                    <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                        <div class="card z-index-0">
                            <div class="card-header text-center pt-4">
                                <h5>Register</h5>
                            </div>
                            <div class="card-body">
                                <form role="form text-left" action="{{ route('proses_register') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <input required type="text" class="form-control" name="username"
                                            placeholder="Username" aria-label="Username" value="{{ old('username') }}"
                                            id="username" aria-describedby="email-addon">
                                        @if ($errors->has('username'))
                                            <span class="error"> * {{ $errors->first('username') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <input required type="text" class="form-control" name="full_name"
                                            placeholder="Full name" aria-label="Full name" value="{{ old('full_name') }}"
                                            aria-describedby="email-addon">
                                        @if ($errors->has('full_name'))
                                            <span class="error"> * {{ $errors->first('full_name') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <input required type="email" class="form-control" name="email"
                                            placeholder="Email" aria-label="Email" value="{{ old('email') }}"
                                            aria-describedby="email-addon">
                                        @if ($errors->has('email'))
                                            <span class="error"> * {{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                    {{-- <div class="mb-3">
                                        <input required type="tel" class="form-control" name="tlp" placeholder="Telephone"
                                            aria-label="Telephone" aria-describedby="email-addon">
                                    </div> --}}
                                    <div class="mb-3">
                                        <input required type="password" class="form-control" name="password"
                                            placeholder="Password" aria-label="Password" value="{{ old('password') }}"
                                            aria-describedby="password-addon">
                                        @if ($errors->has('password'))
                                            <span class="error"> * {{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-check form-check-info text-left">
                                        <input required class="form-check-input" type="checkbox" value=""
                                            id="flexCheckDefault" checked>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            I agree the <a href="javascript:;" class="text-dark font-weight-bolder">Terms
                                                and Conditions</a>
                                        </label>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Sign
                                            up</button>
                                    </div>
                                    <p class="text-sm mt-3 mb-0">Already have an account? <a href="{{ route('login') }}"
                                            class="text-dark font-weight-bolder">Log in</a></p>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
