<section class="popular-foods padding-tb" style="background-color: #fafeff;">
    <div class="container">
        <div class="section-header">
            <h3>Népszerű ételek</h3>
            <p>Rendelj azonnal ebédet rajtunk keresztül. Kedvenc ételeink...</p>
        </div>
        <div class="section-wrapper">
            <div class="row">
                @foreach($items as $item)
                    <div class="col-xl-4 col-md-6 col-12">
                        @include('shared.items.card', ['item' => $item])
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>