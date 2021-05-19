@extends('layouts.app')

@section('main')
    <section class="about home-4 padding-tb restaurant-section">
        <div class="container">
            <a class="back" href="/admin/restaurants/{{ $restaurant->slug }}/items">< Vissza</a>
            <div class="section-header">
                <h3>Étel szerkesztése</h3>
            </div>

            <div class="section-wrapper">
                <form class="d-flex flex-wrap justify-content-between" method="post" action="/admin/restaurants/{{$restaurant->slug}}/items/{{$item->id}}" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    @include('admin.items.form')

                    <button type="submit" class="food-btn style-2"><span>Mentés</span></button>
                </form>
            </div>
        </div>
    </section>
@endsection