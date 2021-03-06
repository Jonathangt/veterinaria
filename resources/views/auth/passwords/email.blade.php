@extends('layouts.app_ingreso')

@section('content')

<div class="container-fluid">
    <div>
        <div >
            <br>
        </div>
    </div>
</div>



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="text-center"><br>
                    <label>
                    <a href="{{ url('/') }}">
                    <h5> <i>Veterinaria Dobaltoff</i></h5>
                    </a>
                    </label>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                           <!-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>-->

                            <div class="col-md-8 offset-md-2">
                                <input id="email" maxlength="30" placeholder="Correo de inicio de sesión" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                        <div  class="col-md-8 offset-md-2">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
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
