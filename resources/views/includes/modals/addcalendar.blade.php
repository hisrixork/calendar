<!-- Full Height Modal Right -->
<div class="modal fade right" id="addCalendarModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-full-height modal-right col-sm-6 px-0" role="document" style="width: inherit;">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form">
                    <form action="{{ route('wcalendar.store') }}" method="POST" id="addCalendarForm">

                        <div class="row">
                            <div class="form-group col-12">
                                <label for="category">Catégorie</label>
                                <select name="category" id="category" class="form-control rounded-0">
                                    <option value="-1">Aucun</option>
                                    @if(isset($categories))
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ strtoupper($category->name) }}
                                                | {{ ucfirst($category->label) }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="row">

                            <div class="form-group col-12 col-md-6">
                                <label for="start">Début</label>
                                <input type="date" name="start" id="start" class="form-control rounded-0">
                            </div>

                            <div class="form-group col-12 col-md-6">
                                <label for="stop">Fin</label>
                                <input type="date" name="stop" id="stop" class="form-control rounded-0">
                            </div>

                        </div>

                    </form>
                </div>

                <div class="row" id="halfRow">

                    <div class="form-group col-12">
                        <input type="checkbox" class="form-check-inline" id="half">
                        <label class="form-check-label" for="half">Demie-journée</label>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <div class="row w-100 m-0">
                    <div class="col-12 col-md-6 my-1">
                        <button type="button" class="btn btn-block bg-color-3" data-dismiss="modal">Annuler</button>
                    </div>
                    <div class="col-12 col-md-6 my-1">
                        <button type="submit" class="btn btn-block bg-color-4" id="addCalendarBtn">Enregister</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

