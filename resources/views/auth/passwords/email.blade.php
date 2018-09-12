@extends('layouts.auth')



@section('form')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Réinitialisation mot de passe') }}">

    @csrf

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
        <div class="text-right mb-3">
            <button class="btn btn-deep-orange waves-effect waves-light" type="submit">Envoyer le lien</button>
        </div>

        {{--<hr class="my-5">--}}

    </form>

@endsection
