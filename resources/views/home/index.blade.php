@extends('layouts.app')

@section('main')
    @include('home.components.featured_restaurants', ['restaurants' => $restaurants])
    @include('home.components.featured_items', ['items' => $items])
    @include('home.components.featured_menus', ['menus' => $menus])

    @if (! \Illuminate\Support\Facades\Auth::check())
        @include('home.components.feature_register')
    @endif
@endsection