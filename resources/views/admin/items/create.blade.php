<div class="modal fade" id="createItemModal" tabindex="-1" aria-hidden="true">
    <form class="d-flex flex-wrap justify-content-between" method="post" action="/admin/restaurants/{{ $restaurant->slug }}/items" enctype="multipart/form-data">
        @csrf
        <div class="modal-dialog modal-lg" style="width: 750px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Étel hozzáadása a(z) '{{ $restaurant->name }}' étteremhez</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('admin.items.form')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Bezárás</button>
                    <button type="submit" class="btn btn-info">Hozzárendelés</button>
                </div>
            </div>
        </div>
    </form>
</div>