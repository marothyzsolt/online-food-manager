@extends('layouts.app')

@section('main')
    <section class="about home-4 padding-tb restaurant-section">
        <div class="container">
            <div class="section-header">
                <h3>{{$restaurant->name}}</h3>
                <p class="mb-2 font-italic">Stílus: {{$restaurant->style}}</p>
            </div>

            <div class="section-wrapper">
                <div class="about-thumb">
                    <img src="{{ $restaurant->media->link }}" alt="about-4" class="restaurant-bg">
                </div>
                <div class="about-content-part">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-12">
                            <div class="ab-left-part">
                                <div class="ab-location icons">
                                    <div class="ab-loc-item">
                                        <div class="ab-loc-inner">
                                            <div class="ab-loc-thumb">
                                                <i class="icofont-location-pin"></i>
                                            </div>
                                            <div class="ab-loc-content">
                                                <h6>Cím</h6>
                                                <p>{{ $restaurant->address }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ab-loc-item">
                                        <div class="ab-loc-inner">
                                            <div class="ab-loc-thumb">
                                                <i class="icofont-phone"></i>
                                            </div>
                                            <div class="ab-loc-content">
                                                <h6>Phone</h6>
                                                <p>{{ $restaurant->phone }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ab-loc-item">
                                        <div class="ab-loc-inner">
                                            <div class="ab-loc-thumb">
                                                <i class="icofont-email"></i>
                                            </div>
                                            <div class="ab-loc-content">
                                                <h6>Email</h6>
                                                <a href="mailto: {{ $restaurant->email }}">{{ $restaurant->email }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="ab-right-part">
                                <p>{{ $restaurant->description }}</p>
                                <h4>Nyitvatartás</h4>
                                <p>
                                    @foreach($restaurant->openingHourList as $day => $openingHour)
                                        @if ($openingHour)
                                            <b>{{ \App\Models\OpeningHour::DAYS[$day] }}</b>: {{ $openingHour->from }} - {{ $openingHour->to }}
                                        @else
                                            <b>{{ \App\Models\OpeningHour::DAYS[$day] }}</b>: ZÁRVA
                                        @endif
                                        <br>
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="popular-foods padding-tb" style="background-color: #fafeff;">
        <div class="container">
            <div class="section-wrapper">
                <div class="row">
                    @foreach($restaurant->menus as $menu)
                        <div class="col-lg-12 col-12 col-md-12">
                            @include('shared.menus.card', ['menu' => $menu])
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection