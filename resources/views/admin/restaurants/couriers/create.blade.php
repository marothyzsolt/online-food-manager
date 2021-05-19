<div class="modal fade" id="createCourierModal-{{ $restaurant->id }}" tabindex="-1" aria-hidden="true">
    <form class="d-flex flex-wrap justify-content-between" method="post" action="/admin/restaurants/{{ $restaurant->slug }}/couriers" enctype="multipart/form-data">
        @csrf
        <div class="modal-dialog modal-lg" style="width: 750px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Futár hozzárendelése a(z) '{{ $restaurant->name }}' étteremhez</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <fieldset>
                        <h5>Futár kiválasztása</h5>
                    </fieldset>
                    <div class="form-row w-100">
                        <select class="selectpicker" data-show-subtext="true" data-live-search="true" name="courier">
                            @foreach($couriers as $courier)
                                <option value="{{ $courier->id }}" data-tokens="{{ $courier->name }}">{{ $courier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Bezárás</button>
                    <button type="submit" class="btn btn-info">Hozzárendelés</button>
                </div>
            </div>
        </div>
    </form>
</div>