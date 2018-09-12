@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-center align-items-center position-fixed error h-100 w-100 flex-column">

        <div class="row">
            <img src="{{ asset('img/logo.png') }}" alt="">
        </div>
        <div class="row text-black-50">
            <h4>Une erreur inconnue est survenue, merci de bien vouloir réessayer plus tard</h4>
        </div>

    </div>

@endsection

@section('stylesheet')


    <style>

        .error {

        }

    </style>

@endsection