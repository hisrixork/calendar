@extends('layouts.auth')



@section('form')

    <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Inscription') }}">

    @csrf

    <!--Header-->
        <div class="form-header warm-flame-gradient rounded">
            <h3 class="my-3 text-center font-weight-light">Inscription</h3>
        </div>

        <hr class="my-5">

        <div class="form-group row mb-3">
            <label for="lastname" class="grey-text font-weight-light">Nom</label>
            <input id="lastname" type="text"
                   class="form-control rounded-0{{ $errors->has('lastname') ? ' is-invalid' : '' }}"
                   name="lastname" value="{{ old('lastname') }}" required autofocus>

            @if ($errors->has('lastname'))
                <span class="invalid-feedback" role="alert">
                {{ $errors->first('lastname') }}
            </span>
            @endif
        </div>

        <div class="form-group row mb-3">
            <label for="firstname" class="grey-text font-weight-light">Prénom</label>
            <input id="firstname" type="text"
                   class="form-control rounded-0{{ $errors->has('firstname') ? ' is-invalid' : '' }}"
                   name="firstname" value="{{ old('firstname') }}" required autofocus>

            @if ($errors->has('firstname'))
                <span class="invalid-feedback" role="alert">
                {{ $errors->first('firstname') }}
            </span>
            @endif
        </div>

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
            <button class="btn btn-deep-orange waves-effect waves-light" type="submit">Inscription</button>
        </div>

        <hr class="my-5">

        <div class="options font-weight-light">
            <p>Déjà un compte ? <a href="{{ route('login') }}">Connexion</a></p>
        </div>

    </form>

@endsection
