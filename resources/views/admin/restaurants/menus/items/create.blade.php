<div class="modal fade" id="createMenuItemModal" tabindex="-1" aria-hidden="true">
    <form class="d-flex flex-wrap justify-content-between" method="post" action="/admin/restaurants/{{$restaurant->slug}}/menus/{{$menu->id}}/items" enctype="multipart/form-data">
        @csrf
        <div class="modal-dialog modal-lg" style="width: 750px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Étel hozzárendelése a(z) '{{$menu->name}}' étlaphoz</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <fieldset>
                        <h5>Étel kiválasztása</h5>
                    </fieldset>
                    <div class="form-row w-100">
                        <select class="selectpicker" data-show-subtext="true" data-live-search="true" name="item">
                            @foreach($restaurantItems as $restaurantItem)
                                <option value="{{$restaurantItem->id}}" data-tokens="{{$restaurantItem->name}}">{{$restaurantItem->name}} [{{$restaurantItem->mainPrice->price}} {{$restaurantItem->mainPrice->currency->symbol}}]</option>
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