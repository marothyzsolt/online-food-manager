<section class="food-category padding-tb" style="background-image: url(assets/css/bg-image/category-bg.jpg); background-size: cover;">
    <div class="container">
        <div class="food-box">
            <div class="section-header">
                <h3>Kedvenc éttermeid</h3>
                <p>Válassz kedvenc éttermeid közül, és ebédelj velünk!</p>
            </div>
            <div class="section-wrapper">
                <div class="food-slider">
                    <div class="swiper-wrapper">

                        @foreach($restaurants as $restaurant)
                            @include('home.components.restaurants.mini_card', ['restaurant' => $restaurant])
                        @endforeach

                    </div>
                </div>
                <div class="food-slider-next"><i class="icofont-double-left"></i></div>
                <div class="food-slider-prev"><i class="icofont-double-right"></i>
                </div>
            </div>
        </div>
    </div>
</section>