<!-- Full Height Modal Right -->
<div class="modal fade left" id="pickDateModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-full-height modal-left col-sm-3 px-0" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Aller à ...</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form">

                    <div class="row">
                        <div class="form-group col-12 px-0">
                            <div class="row w-100">
                                <div class="col-5 col-md-3 d-flex justify-content-center align-items-center">
                                    <label for="day">Jour</label>
                                </div>
                                <div class="col-7 col-md-9">
                                    <select name="day" id="day" class="form-control rounded-0">
                                        @if(isset($days))
                                            @foreach($days as $day)
                                                <option value="{{ $day }}" {{ (\Carbon\Carbon::now())->day === $day ? 'selected' : ''}}>{{ $day }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-12 px-0">
                            <div class="row w-100">
                                <div class="col-5 col-md-3 d-flex justify-content-center align-items-center">
                                    <label for="month">Mois</label>
                                </div>
                                <div class="col-7 col-md-9">
                                    <select name="month" id="month" class="form-control rounded-0">
                                        @if(isset($months))
                                            @foreach($months as $month)
                                                <option value="{{ $month }}" {{ (\Carbon\Carbon::now())->month === $month ? 'selected' : ''}}>{{ $month }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-12 px-0">
                            <div class="row w-100">
                                <div class="col-5 col-md-3 d-flex justify-content-center align-items-center">
                                    <label for="year">Année</label>
                                </div>
                                <div class="col-7 col-md-9">
                                    <select name="year" id="year" class="form-control rounded-0">
                                        @if(isset($years))
                                            @foreach($years as $year)
                                                <option value="{{ $year }}" {{ (\Carbon\Carbon::now())->year === $year ? 'selected' : ''}}>{{ $year }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <div class="row w-100 m-0">
                    <div class="col-12 col-md-6 my-1">
                        <button type="button" class="btn btn-block bg-color-3" data-dismiss="modal">Annuler</button>
                    </div>
                    <div class="col-12 col-md-6 my-1">
                        <button type="submit" class="btn btn-block bg-info" id="pickDateBtn" data-url="{{ route('wcalendar.index') }}">Y aller</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

