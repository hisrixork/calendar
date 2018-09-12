@extends('layouts.auth')



@section('form')

    <form method="POST" action="{{ route('password.request') }}" aria-label="{{ __('Réinitialisation mot de passe') }}">

        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <!--Header-->
        <div class="form-header warm-flame-gradient rounded">
            <h3 class="my-3 text-center font-weight-light">Réinitialisation mot de passe</h3>
        </div>

        <hr class="my-5">

        <div class="form-group row mb-3">
            <label for="email" class="grey-text font-weight-light">Adresse mail</label>
            <input id="email" type="email"
                   class="form-control rounded-0{{ $errors->has('email') ? ' is-invalid' : '' }}"
                   name="email" value="{{ old('email') }}" required autofocus>

            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                {{ $errors->first('email') }}
            </span>
            @endif
        </div>

        <div class="form-group row mb-3">
            <label for="password" class="grey-text font-weight-light">Mot de passe</label>
            <input id="password" type="password"
                   class="form-control rounded-0{{ $errors->has('password') ? ' is-invalid' : '' }}"
                   name="password" required>

            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    {{ $errors->first('password') }}
                </span>
            @endif
        </div>

        <div class="form-group row mb-3">
            <label for="password-confirm" class="grey-text font-weight-light">Confirmation mot de passe</label>

            <input id="password-confirm" type="password"
                   class="form-control rounded-0{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                   name="password_confirmation" required>

            @if ($errors->has('password_confirmation'))
                <span class="invalid-feedback" role="alert">
                    {{ $errors->first('password_confirmation') }}
                </span>
            @endif
        </div>

        <div class="text-center mb-3">
            <button class="btn btn-deep-orange waves-effect waves-light" type="submit">Réinitialiser</button>
        </div>


    </form>

@endsection
