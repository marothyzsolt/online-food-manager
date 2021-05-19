@extends('layouts.app')

@section('main')
    <section class="popular-foods padding-tb" style="background-color: #fafeff;">
        <div class="container">
            <div class="section-header">
                <h3>Saját étteremek</h3>
            </div>
            <div class="section-wrapper">
                @foreach($restaurants as $restaurant)
                    <div class="row mb-3">
                        <section class="blog-section pt-4 bg-body pb-0">
                            <div class="container">
                                <div class="section-wrapper">
                                    <div class="row">
                                        <div class="col-lg-6 col-12 blog-left">
                                            <div class="post-item">
                                                <div class="post-inner">
                                                    <div class="post-thumb">
                                                        <a href="/restaurants/{{$restaurant->slug}}">
                                                            <img src="{{$restaurant->media->link}}" alt="restaurant-img">
                                                        </a>
                                                    </div>
                                                    <div class="post-content">
                                                        <div class="meta-tag">
                                                            <div class="categori">
                                                                <span>{{$restaurant->style}}</span>
                                                            </div>
                                                        </div>
                                                        <h5><a href="/restaurants/{{$restaurant->slug}}">{{$restaurant->name}}</a></h5>
                                                        <div class="meta-post">
                                                            <ul>
                                                                <li>
                                                                    <i class="icofont-clock-time"></i>
                                                                    <span class="date">Átlagos kiszállítási idő: {{$restaurant->deliveryTime}} perc</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <p>{{$restaurant->description}}</p>
                                                        <a href="/admin/restaurants/{{$restaurant->slug}}/edit" class="food-btn style-2"><span>Szerkesztés</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="post-item col-md-12">
                                                <div class="post-inner">
                                                    <div class="post-content">
                                                        <h5>Menük</h5>
                                                        <p>{{$restaurant->menus()->count()}} db aktív étlap</p>
                                                        <ul>
                                                            @foreach($restaurant->menus as $menu)
                                                                <li><a href="/restaurants/{{$restaurant->slug}}/menus/{{$menu->id}}">{{$menu->name}} ({{$menu->items()->count()}} db elem)</a></li>
                                                            @endforeach
                                                        </ul>
                                                        <a href="/admin/restaurants/{{$restaurant->slug}}/menus" class="food-btn style-2"><span>Áttekintés és szerkesztés</span></a>
                                                        <a href="/admin/restaurants/{{$restaurant->slug}}/items" class="food-btn style-2"><span>Ételek</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection