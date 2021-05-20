@extends('layouts.app')

@section('main')
    <section class="popular-foods padding-tb" style="background-color: #fafeff;">
        <div class="container">
            <div class="section-header">
                <h3>{{$menu->name}}</h3>
                <p class="mb-2 font-italic">Étterem: <a href="/restaurants/{{$restaurant->slug}}">{{$restaurant->name}}</a></p>
                <p class="mb-2 font-italic">Stílus: {{$restaurant->style}}</p>
                <p>{{$menu->description}}</p>
            </div>
            <div class="section-wrapper">
                <div class="row">
                    @foreach($menu->items as $item)
                        @if ($item->isActive())
                            <div class="col-xl-4 col-md-6 col-12">
                                @include('shared.items.card', ['item' => $item, 'restaurant' => $restaurant])
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection