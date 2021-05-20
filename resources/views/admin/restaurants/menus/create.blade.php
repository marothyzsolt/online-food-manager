<div class="modal fade" id="createMenuModal" tabindex="-1" aria-hidden="true">
        <form class="d-flex flex-wrap justify-content-between" method="post" action="/admin/restaurants/{{$restaurant->slug}}/menus" enctype="multipart/form-data">
        <div class="modal-dialog modal-lg" style="width: 750px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Étlap létrehozása</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    @method('post')
                    <fieldset>
                        <h5>Alapadatok</h5>
                    </fieldset>
                    <div class="form-row">
                        <label for="">Étlap neve</label>
                        <input type="text" name="name" required maxlength="32">
                    </div>
                    <div class="form-row">
                        <label for="">Leírás</label>
                        <textarea rows="8" required name="description"></textarea>
                    </div>

                    <fieldset>
                        <h5>Étlap Kép</h5>
                    </fieldset>
                    <div class="form-row">
                        <label for="">Kép</label>
                        <input type="file" name="media">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Bezárás</button>
                    <button type="submit" class="btn btn-info">Mentés</button>
                </div>
            </div>
        </div>
    </form>
</div>