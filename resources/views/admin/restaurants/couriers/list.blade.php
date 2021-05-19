@extends('layouts.app')

@section('main')
    <section class="popular-foods padding-tb" style="background-color: #fafeff;">
        <div class="container">
            <div class="section-header">
                <h3>Saját étteremek, és futárok</h3>
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
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="post-item col-md-12">
                                                <div class="post-inner">
                                                    <div class="post-content">
                                                        <h5>Futárok</h5>
                                                        <p>{{$restaurant->couriers()->count()}} db futár</p>
                                                        <table class="w-100 table">
                                                            <thead>
                                                            <tr>
                                                                <th>Név</th>
                                                                <th>Aktivitás</th>
                                                                <th>Törlés</th>
                                                            </tr>
                                                            </thead>
                                                                @foreach($restaurant->couriers as $courier)
                                                                    <tr>
                                                                        <td> {{ $courier->name }}</td>
                                                                        <td>
                                                                            @foreach($courier->activityList as $day => $activity)
                                                                                @if ($activity)
                                                                                    <b>{{ \App\Models\CourierActivity::DAYS[$day] }}</b>: {{ $activity->from }} - {{ $activity->to }}
                                                                                @endif
                                                                            @endforeach
                                                                        </td>
                                                                        <td>
                                                                            <form id="delete-form-{{ $courier->id }}" action="/admin/restaurants/{{ $restaurant->slug }}/couriers/{{ $courier->id }}"
                                                                                  method="POST" style="display: none;">
                                                                                @csrf
                                                                                @method('delete')
                                                                            </form>
                                                                            <a data-toggle="tooltip" data-placement="top" title="Törlés"
                                                                               class="action-icon"
                                                                               href="/admin/restaurants/{{ $restaurant->slug }}/couriers/{{$courier->id}}"
                                                                               onclick="event.preventDefault();
                                                                                       document.getElementById('delete-form-{{ $courier->id }}').submit();">
                                                                                <i class="icofont-trash"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            <tbody>
                                                            </tbody>
                                                        </table>

                                                        <button class="btn btn-info btn-block" data-toggle="modal" data-target="#createCourierModal-{{ $restaurant->id }}">
                                                            Hozzáadás
                                                        </button>

                                                        @include('admin.restaurants.couriers.create', ['$restaurant' => $restaurant])
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