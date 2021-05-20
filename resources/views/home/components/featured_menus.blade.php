<section class="popular-foods padding-tb">
    <div class="container">
        <div class="section-header">
            <h3>Népszerű menük</h3>
            <p>Ismerd meg kínálatunkat, és kövesd nyomon az új ételek hadait velünk.</p>
        </div>
        <div class="section-wrapper">
            <div class="row">
                @foreach ($menus as $menu)
                    <div class="col-lg-6 col-12">
                        @include('shared.menus.card', ['menu' => $menu])
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>