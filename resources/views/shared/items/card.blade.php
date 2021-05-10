<div class="p-food-item">
    <div class="p-food-inner">
        <div class="p-food-thumb">
            <img src="{{ $item->mainImage()->link }}" alt="p-food">
            @if ($item->discounted)
                <span class="discounted">
                    {{ $item->mainPrice->price }} {{ $item->mainPrice->currency->code }}
                </span>
                <span>
                    {{ $item->mainPrice->discountedPrice }} {{ $item->mainPrice->currency->code }}
                </span>
            @else
                <span>
                    {{ $item->mainPrice->price }} {{ $item->mainPrice->currency->code }}
                </span>
            @endif
        </div>
        <div class="p-food-content">
            <h6><a href="#">{{ $item->name }}</a></h6>
            <div class="p-food-group">
                {{ $item->description }}
            </div>
            <ul class="del-time">
                <li>
                    <i class="icofont-stopwatch"></i>
                    <div class="time-tooltip">
                        <div class="time-tooltip-holder">
                            <span class="tooltip-label">Elkészítés</span>
                            <span class="tooltip-info">~{{$item->make_time}} percen belül</span>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="p-food-footer">
                <div class="left">
                    <div class="rating">
                        <i class="icofont-star"></i>
                        <i class="icofont-star"></i>
                        <i class="icofont-star"></i>
                        <i class="icofont-star"></i>
                        <i class="icofont-star"></i>
                    </div>
                </div>
                <div class="right">
                    @if($cart->service->inCart($item->id))
                        <button class="btn btn-info" disabled>
                            <i>Kosárban</i>
                        </button>
                    @else
                        <a class="btn btn-info" href="/cart/add/{{$item->id}}">
                            Kosárba >
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>