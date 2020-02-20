@extends('layouts.app_ingreso')

@section('content')

<div class="container-fluid">
    <div >
        <div >
            <br>
        </div>
    </div>
</div>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="text-center"><br>
                    <label>
                        <a href="{{ url('/') }}">
                        <h5> <i>Veterinaria Dobaltoff</i></h5>
                        </a>
                    </label>
                </div>
                <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                          <!--  <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>-->

                            <div  class="col-md-8 offset-md-2">
                                <input id="email" type="email" maxlength="30" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                          <!--   <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>-->

                            <div  class="col-md-8 offset-md-2">
                                <input id="password" type="password" maxlength="20" placeholder="Contraseña" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                         <!-- <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>-->

                            <div  class="col-md-8 offset-md-2">
                                <input id="password-confirm" maxlength="20" type="password" placeholder="Confirmación contraseña" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-2">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


