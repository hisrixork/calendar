@extends('layouts.auth')



@section('form')

    <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Connexion') }}" id="loginForm">

    @csrf

    <!--Header-->
        <div class="form-header warm-flame-gradient rounded">
            <h3 class="my-3 text-center font-weight-light">Connexion</h3>
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

        <div class="form-group row">
            <div class="checkbox">
                <label>
                    <input type="checkbox"
                           name="remember" {{ old('remember') ? 'checked' : '' }}>&nbsp;&nbsp;{{ __('Se souvenir de moi') }}
                </label>
            </div>
        </div>

        <div class="text-center mb-3">
            <button class="btn btn-deep-orange waves-effect waves-light" type="submit">Connexion</button>
        </div>

        <hr class="my-5">

        <div class="options font-weight-light">
            <p>Pas encore de compte ? <a href="{{ route('register') }}">Inscription</a></p>
            <p><a href="{{ route('password.request') }}">Mot de passe oublié ?</a></p>
        </div>

    </form>

@endsection

@section('javascript')

    <script type="text/javascript" rel="script">

        $('#loginForm').submit(function (e) {
            (e || window.event).preventDefault()

            $("#form-load").toggleClass("d-flex d-none")

            let email = MD5($('input#email').val()), password = MD5($('input#password').val())

            axios.post($(this).attr('action'), {email, password}).then((r) => {
                if (r.status === 200)
                    location.reload()
            }, () => {
                $("#form-load").toggleClass("d-flex d-none")
                $('input#email').addClass('is-invalid')
            })
        })

    </script>

@endsection