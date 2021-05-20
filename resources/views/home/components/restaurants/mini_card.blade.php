<div class="swiper-slide">
    <div class="food-item">
        <div class="food-thumb">
            <a href="/restaurants/{{ $restaurant->slug }}"><img src="{{$restaurant->media->link}}" alt="restaurant"></a>
        </div>
        <div class="food-content">
            <a href="/restaurants/{{ $restaurant->slug }}">{{ $restaurant->name }}</a>
        </div>
    </div>
</div>