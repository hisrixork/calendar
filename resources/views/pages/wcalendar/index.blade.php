@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-12 p-0">
            <div class="ring-left"></div>
            <div class="ring-right"></div>
            <div class="calendar-header bg-color-4 row text-white">
                <div class="col-12 col-m6 mx-auto d-flex justify-content-center align-items-center flex-column">
                    <div class="w-100">
                        @if(($navi = $data['navi']) !== null)
                            <div class="row w-100 mx-auto">
                                <div class="col-3 text-left">
                                    <a href="{{ $navi['prev'] }}" class="text-white"><i
                                                class="fa fa-chevron-left fa-2x"></i></a>
                                </div>
                                <div class="col-6 text-center text-uppercase">
                                    {{ $navi['date'] }}
                                </div>
                                <div class="col-3 text-right">
                                    <a href="{{ $navi['next'] }}" class="text-white"><i
                                                class="fa fa-chevron-right fa-2x"></i></a>
                                </div>
                            </div>
                            <div class="row w-100 mx-auto">
                                <div class="col-12 text-center">
                                    <a href="{{ $navi['today'] }}" class="text-white">
                                        <i class="far fa-bullseye"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            <div class="col-12 clock-container d-none justify-content-center align-items-center">
                <div class="clock">
                    @if(isset($data['hours']))
                        @foreach($data['hours'] as $hour)
                            <div class="hour hour-{{$hour}}"></div>
                        @endforeach
                    @endif
                    <div class="center-empty m-auto bg-white rounded-circle"></div>
                    <div class="center m-auto bg-dark rounded-circle"></div>
                    <div class="hours m-auto bg-dark"></div>
                    <div class="minutes m-auto bg-dark"></div>
                    <div class="seconds m-auto bg-dark"></div>
                    <div class="date bg-dark text-white z-depth-1 my-auto ml-auto text-center fa-xs d-flex justify-content-center align-items-center rounded">{{ $data['date']->day ?? 0 }}</div>
                </div>
            </div>

            <a href="{{ route('wcalendar.destroy.invalid') }}" id="destroyInvalid"></a>

            <div class="row">

                <div class="col-12">
                    {!! $data['calendar'] !!}
                </div>

            </div>

            <div class="row" id="legend">
                @foreach($data['counts'] as $label => $count)
                    <div class="col-4 col-md-2 text-center">
                        <div class="type d-block m-auto rounded-circle text-white {{ strtoupper($label) }}">
                            <span class="d-flex justify-content-center align-items-center">{{ strtoupper($label) }}</span>
                        </div>
                        <i>{{ $count }}</i>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    @include('includes.modals.addcalendar', [
    'categories' => $data['categories']
    ])

    @include('includes.modals.pickdate', [
    'days' => $data['days'],
    'months' => $data['months'],
    'years' => $data['years'],
    ])


    <div class="export bg-success rounded-circle d-flex justify-content-center align-items-center z-depth-1-half cursor-pointer"
         data-url="{{ route('export.route') }}">
        <i class="far fa-file-excel text-white"></i>
    </div>

    <div class="pick-date bg-info rounded-circle d-flex justify-content-center align-items-center z-depth-1-half cursor-pointer"
         data-url="{{ route('export.route') }}">
        <i class="far fa-calendar-alt text-white"></i>
    </div>

@endsection

@section('javascript')
    <script>

        /* Fonction qui sert à afficher l'écran d'horloge */
        $(function () {

            let inactive, interval = 600000

            inactive = setTimeout(function () {
                $('.clock-container').removeClass('d-none').addClass('d-flex')
            }, interval)

            $('.clock-container').click(function () {
                clearTimeout(inactive)
                $('.clock-container').addClass('d-none').removeClass('d-flex')
                inactive = setTimeout(function () {
                    $('.clock-container').removeClass('d-none').addClass('d-flex')
                }, interval)
            })

            $(document).click(function () {
                clearTimeout(inactive)
                $('.clock-container').addClass('d-none').removeClass('d-flex')
                inactive = setTimeout(function () {
                    $('.clock-container').removeClass('d-none').addClass('d-flex')
                }, interval)
            })
        })

        /* Fonction qui sert à effectuer la rotation des aiguilles */

        $(function () {
            jQuery.fn.rotate = function (degrees) {
                $(this).css({
                    '-webkit-transform': 'rotate(' + degrees + 'deg)',
                    '-moz-transform': 'rotate(' + degrees + 'deg)',
                    '-ms-transform': 'rotate(' + degrees + 'deg)',
                    'transform': 'rotate(' + degrees + 'deg)'
                });
                return $(this);
            }

            let time, date, h, m, s, e = 360

            time = setInterval(function () {
                date = moment().locale('fr')
                h = date.hours()
                m = date.minutes()
                s = date.seconds()
                $('.clock .hours').rotate((e * h) / 12)
                $('.clock .minutes').rotate((e * m) / 60)
                $('.clock .seconds').rotate((e * s) / 60)
            }, 1000)
        })

        $(function () {
            $('a#startDay').click(function (e) {
                e.preventDefault()

                let that = $(this), url = that.attr('href')

                axios.post(url).then((r) => {
                    console.log(r)
                })

            })

            $('a#stopDay').click(function (e) {
                e.preventDefault()

                let that = $(this), url = that.attr('href')

                axios.put(url).then((r) => {
                    console.log(r)
                })

            })
        })

        $(function () {
            $('#calendar .box-content li').click(function () {

                let that = $(this), id = (that.attr('id') || 'li-').split('li-')[1] || null,
                    modal = $('#addCalendarModal'), cat = that.attr('data-cat')

                axios.get('/category/' + (cat || -1)).then(r => {
                    modal.find('select#category').val(r.data.id || -1)
                    modal.find('input#start').val(id)
                    modal.find('input#stop').val(id)
                    modal.modal('show')
                }, () => {
                    modal.find('input#start').val(id)
                    modal.find('input#stop').val(id)
                    modal.modal('show')
                })

            })

        })

    </script>

    <script>

        $('input#start, input#stop').on('input', function () {
            let start = $('input#start').val(), stop = $('input#stop').val()
            if (start === stop)
                $('#halfRow').removeClass('d-none')
            else
                $('#halfRow').addClass('d-none')
        })

        $(function () {
            $('#addCalendarBtn').click(function (e) {

                $("#form-load").toggleClass("d-flex d-none")

                e.preventDefault()

                let data = {}, url = $('#addCalendarForm').attr('action'), dataSend

                data.category = $('select#category').val()
                data.start = $('input#start').val()
                data.stop = $('input#stop').val()
                data.half = $('input#half').is(':checked')

                dataSend = btoa(JSON.stringify(data))

                axios.post(url, {data: dataSend}).then((r) => {
                    let delUrl = $('a#destroyInvalid').attr('href')
                    axios.delete(delUrl).then(() => {
                        location.reload()
                    }, () => {
                        location.reload()
                    })
                })
            })

            $('#pickDateBtn').click(function (e) {

                $("#form-load").toggleClass("d-flex d-none")

                e.preventDefault()

                let data = {}, url = $('#pickDateBtn').attr('data-url')

                data.day = $('select#day').val()
                data.month = $('select#month').val()
                data.year = $('select#year').val()

                location.href = `${url}/${data.month}/${data.year}`

            })

            $('.export').click(function () {

                $("#form-load").toggleClass("d-flex d-none")

                let year = getUrlParameter('year') || moment().year(), url = $(this).attr('data-url')

                axios.get(url + '/' + year).then((r) => {
                    $("#form-load").toggleClass("d-flex d-none")

                    open(url + '/' + year, '_blank')

                    swal({
                        title: 'Succès',
                        text: 'L\'export est réussi',
                        type: 'success',
                        showCancelButton: false,
                        confirmButtonClass: 'bg-success',
                        confirmButtonText: '@lang('Ok')',
                    })

                })
            })

            $('.pick-date').click(function () {

                let that = $(this), id = (that.attr('id') || 'li-').split('li-')[1] || null,
                    modal = $('#pickDateModal'), cat = that.attr('data-cat')

                axios.get('/category/' + (cat || -1)).then(r => {
                    modal.find('select#category').val(r.data.id || -1)
                    modal.find('input#start').val(id)
                    modal.find('input#stop').val(id)
                    modal.modal('show')
                }, () => {
                    modal.find('input#start').val(id)
                    modal.find('input#stop').val(id)
                    modal.modal('show')
                })

            })
        })
    </script>

@endsection

@section('stylesheet')

@endsection