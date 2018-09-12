@extends('layouts.app')

@section('content')

    <div class="col-md-6 mx-auto d-flex justify-content-center align-items-center"
         style="max-width:500px;height: 100vh;">

        <div class="card mx-auto z-depth-0 w-100">
            <div class="card-body">

                @yield('form')

            </div>

            <!--Footer-->

        </div>
        <!-- Grid column -->

    </div>

@endsection