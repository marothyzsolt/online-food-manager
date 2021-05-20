@extends('layouts.app')

@section('main')
    <section class="about home-4 padding-tb restaurant-section">
        <div class="container">
            <a class="back" href="/admin/restaurants">< Vissza</a>
            <div class="section-header">
                <h3>Étlap szerkesztése</h3>
            </div>

            <div class="section-wrapper">
                <div class="form-errors">
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                </div>

                <form class="d-flex flex-wrap justify-content-between" method="post" action="/admin/restaurants/{{$restaurant->slug}}/menus/{{$menu->id}}" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <fieldset>
                        <h5>Alapadatok</h5>
                    </fieldset>
                    <div class="form-row">
                        <label for="">Étlap neve</label>
                        <input type="text" name="name" required maxlength="32" value="{{old('name', $menu->name)}}">
                    </div>
                    <div class="form-row">
                        <label for="">Leírás</label>
                        <textarea rows="8" required name="description">{{old('name', $menu->description)}}</textarea>
                    </div>

                    <fieldset>
                        <h5>Étlaphoz tartozó kép</h5>
                    </fieldset>
                    <div class="form-row">
                        <label for="">Kép</label>
                        <input type="file" name="media">
                    </div>

                    <button type="submit" class="food-btn style-2"><span>Mentés</span></button>
                </form>
            </div>
        </div>
    </section>
@endsection