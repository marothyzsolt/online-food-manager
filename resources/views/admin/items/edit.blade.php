@extends('layouts.app')

@section('main')
    <section class="about home-4 padding-tb restaurant-section">
        <div class="container">
            <a class="back" href="/admin/restaurants/{{ $restaurant->slug }}/items">< Vissza</a>
            <div class="section-header">
                <h3>Étel szerkesztése</h3>
            </div>

            <div class="section-wrapper">
                <div class="form-errors">
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                </div>

                <form class="d-flex flex-wrap justify-content-between" method="post" action="/admin/restaurants/{{$restaurant->slug}}/items/{{$item->id}}" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <fieldset>
                        <h5>Alapadatok</h5>
                    </fieldset>
                    <div class="form-row">
                        <label for="">Étel neve</label>
                        <input type="text" name="name" required maxlength="32" value="{{old('name', $item->name)}}">
                    </div>
                    <div class="form-row">
                        <label for="">Leírás</label>
                        <textarea rows="8" required name="description">{{old('name', $item->description)}}</textarea>
                    </div>
                    <div class="form-row">
                        <label for="">Eredeti Ár (HUF)</label>
                        <input type="text" name="price" required value="{{old('price', $item->mainPrice->price)}}">
                    </div>
                    <div class="form-row">
                        <label for="">Kedvezmény</label>
                        <select name="discount_type" style="height: 50px">
                            <option value="0" @if (\App\Models\ItemPrice::DISCOUNT_TYPE_PRICE === old('discount_type', $item->mainPrice?->discount_type)) selected @endif>Nincs</option>
                            <option value="{{ \App\Models\ItemPrice::DISCOUNT_TYPE_PRICE }}" @if (\App\Models\ItemPrice::DISCOUNT_TYPE_PRICE === old('discount_type', $item->mainPrice?->discount_type)) selected @endif>Ár alapú</option>
                            <option value="{{ \App\Models\ItemPrice::DISCOUNT_TYPE_PERCENTAGE }}" @if (\App\Models\ItemPrice::DISCOUNT_TYPE_PERCENTAGE === old('discount_type', $item->mainPrice?->discount_type)) selected @endif>Százalék alapú</option>
                        </select>
                        <input type="number" name="discount" required value="{{old('discount', $item->mainPrice?->discount)}}">
                    </div>
                    <div class="form-row">
                        <label for="">Elkészítési idő (perc)</label>
                        <input type="number" name="make_time" required value="{{old('make_time', $item->make_time)}}">
                    </div>

                    <fieldset>
                        <h5>Ételhez tartozó képek</h5>
                    </fieldset>
                    <div class="row col-md-12 mb-5">
                        Jelenlegi képek: <b>(Törléshez kattintson a képre)</b>
                        <div class="row col-md-12">
                            @foreach ($item->images as $image)
                                <a href="/admin/restaurants/{{ $restaurant->slug }}/items/{{ $item->id }}/images/{{ $image->hash }}/delete">
                                    <img src="{{ $image->link }}" width="120" alt="">
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="">Kép hozzáadása</label>
                        <input type="file" multiple name="media[]">
                    </div>

                    <button type="submit" class="food-btn style-2"><span>Mentés</span></button>
                </form>
            </div>
        </div>
    </section>
@endsection