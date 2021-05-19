@extends('layouts.app')

@section('stylesheet')
    <style>
        .page-header {
            background: url({{ $restaurant->media->link }}) no-repeat;
        }
    </style>
@endsection

@section('main')
    <section class="page-header style-2">
        <div class="container">
            <div class="page-title text-center">
                <h3>{{ $item->name }}</h3>
                <ul class="breadcrumb">
                    <li><a href="/restaurants/{{ $restaurant->slug }}">Étterem: {{ $restaurant->name }}</a></li>
                    <li>
                        <a href="/restaurants/{{ $restaurant->slug }}/menus/{{ $menu->id }}">Étlap: {{ $menu->name }}</a>
                    </li>
                    <li>{{ $item->name }}</li>
                </ul>
            </div>
        </div>
    </section>


    <div class="shop-page single padding-tb pb-0">
        <div class="container">
            <div class="section-wrapper">
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-12">
                        <article>
                            <div class="shop-single">
                                <div class="row justify-content-center">
                                    <div class="col-md-6 col-12">
                                        <div class="swiper-container gallery-top">
                                            <div class="swiper-wrapper">
                                                @foreach($item->images as $image)
                                                    <div class="swiper-slide">
                                                        <div class="shop-item">
                                                            <div class="shop-thumb">
                                                                <img src="{{ $image->link }}" alt="{{ $image->id }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="swiper-container gallery-thumbs">
                                            <div class="swiper-wrapper">
                                                @foreach($item->images as $image)
                                                    <div class="swiper-slide">
                                                        <div class="shop-item">
                                                            <div class="shop-thumb">
                                                                <img src="{{ $image->link }}" alt="{{ $image->id }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="shop-single-content">
                                            <div class="title">
                                                <h5><a href="#">{{ $item->name }}</a></h5>
                                                <div class="p-food-group">
                                                    <span>Stílus: {{ $restaurant->style }}</span>
                                                </div>
                                            </div>
                                            <div class="desc">
                                                <p>{{ $item->description }}</p>
                                                <div class="quyality">
                                                    <p><span>SKU</span> : {{ $item->sku }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-xl-4 col-md-5 col-12">
                        <aside>
                            <div class="popular-chef-widget">
                                <div class="food-quyality">
                                    <div class="section-header">
                                        <p>Elkészítési idő: <span>{{ $item->make_time }} perc</span></p>
                                    </div>
                                    <div class="section-wrapper">
                                        @if($item->discounted)
                                            <h3 style="text-decoration: overline">{{ $item->mainPrice->price }} {{ $item->mainPrice->currency->symbol }}</h3>
                                            <h5>{{ $item->endPrice() }} {{ $item->mainPrice->currency->symbol }}</h5>
                                        @else
                                            <h5>{{ $item->endPrice() }} {{ $item->mainPrice->currency->symbol }}</h5>
                                        @endif
                                        <p>Mennyiség</p>
                                        <label>
                                            <input type="number" placeholder="1" value="1" disabled>
                                        </label>
                                        @if ($item->isAvailable())
                                            @if ($restaurant->isClosed())
                                                <h6>Az étterem jelenleg zárva van...</h6>
                                            @else
                                                @if ($cart->service->inCart($item->id))
                                                    <button class="food-btn style-2" disabled>
                                                        <i>Kosárban</i>
                                                    </button>
                                                @else
                                                    <a class="food-btn style-2" href="/cart/add/{{ $item->id }}">
                                                        <span>Kosárba ></span>
                                                    </a>
                                                @endif
                                            @endif
                                        @else
                                            <h6>Ez a termék jelenleg nem elérhető</h6>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="review single padding-tb">
        <div class="container">
            <div class="section-wrapper">
                <div class="related">
                    <ul class="tab-bar">
                        <li class="tablinks" id="defaultOpen" onclick="openCity(event, 'one')">
                            <span>Leírás</span>
                        </li>
                        <li class="tablinks" onclick="openCity(event, 'two')">
                            <span>Allergének</span>
                        </li>
                    </ul>

                    <div id="one" class="tabcontent">
                        <div class="Description">
                            <h5>Leírás</h5>
                            <p>{{ $item->description }}</p>
                        </div>
                    </div>

                    <div id="two" class="tabcontent">
                        <div class="spe-shop">
                            <div class="tec-spe">
                                <ul>
                                    @foreach($allergenList as $allergen)
                                        <li>
                                            <div class="left">{{ $allergen->name }}</div>
                                            <div class="right">
                                                @if ($item->isAllergenable($allergen))
                                                    <i class="icofont-check color-green icofont-lg"></i>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/assets/js/tab.js"></script>
@endsection