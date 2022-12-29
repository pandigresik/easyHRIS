@extends('layouts.app_login')

@section('content')
<div class="container pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">            
            <div class="card-group">
                <div class="card p-4">
                    <div class="card-body">
                        <form method="post" action="{{ url('/login') }}">
                            @csrf                            
                            <div class="image text-center mb-2" style="background-color:#6cb2eb">
                                <img src="vendor/images/logo-big.png">
                                <p class="text-muted">Sign In to your account</p>
                            </div>
                            
                            <div class="input-group mb-3">
                                <span class="input-group-text">
                                    <i class="fa fa-user"></i>
                                </span>
                                <input type="text" class="form-control {{ $errors->has('email')?'is-invalid':'' }}" name="email" value="{{ old('email') }}"
                                       placeholder="email">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="input-group mb-4">
                                <span class="input-group-text">
                                    <i class="fa fa-lock"></i>
                                  </span>
                                <input type="password" class="form-control {{ $errors->has('password')?'is-invalid':'' }}" placeholder="Password" name="password">
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                       <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <button class="btn btn-primary px-4" type="submit">Login</button>
                                </div>
                                <div class="col-6 text-end">
                                    <a class="btn btn-link px-0" href="{{ url('/password/reset') }}">
                                        Forgot password?
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card text-white bg-primary py-5">
                    <div class="card-body text-center">
                        <div>
                            <h2>Sign up</h2>
                            <p>{{ env('GREETING_APP', 'Welcome .....')}}</p>
                                <a class="btn btn-primary active mt-3" href="{{ url('/register') }}">Register Now!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
