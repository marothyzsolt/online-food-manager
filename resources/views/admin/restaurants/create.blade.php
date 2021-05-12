@extends('layouts.app')

@section('main')
    <section class="about home-4 padding-tb restaurant-section">
        <div class="container">
            <div class="section-header">
                <h3>Étterem létrehozása</h3>
            </div>

            <div class="section-wrapper">
                <div class="form-errors">
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                </div>

                <form class="d-flex flex-wrap justify-content-between" method="post" action="/admin/restaurants/" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <fieldset>
                        <h5>Alapadatok</h5>
                    </fieldset>
                    <div class="form-row">
                        <label for="">Étterem neve</label>
                        <input type="text" name="name" value="{{old('name')}}" maxlength="32">
                    </div>
                    <div class="form-row">
                        <label for="">Stílus</label>
                        <input type="text" name="style" value="{{old('style')}}" placeholder="pl. Magyaros">
                    </div>
                    <div class="form-row">
                        <label for="">Leírás</label>
                        <textarea rows="8" name="description">{{old('description')}}</textarea>
                    </div>

                    <fieldset>
                        <h5>Étterem Kép</h5>
                    </fieldset>
                    <div class="form-row">
                        <label for="">Kép</label>
                        <input type="file" name="media">
                    </div>

                    <fieldset>
                        <h5>Elérhetőségek</h5>
                    </fieldset>
                    <div class="form-row">
                        <label for="">Cím</label>
                        <input type="text" name="address" value="{{old('address')}}">
                    </div>
                    <div class="form-row">
                        <label for="">Telefonszám</label>
                        <input type="text" name="phone" value="{{old('phone')}}">
                    </div>
                    <div class="form-row">
                        <label for="">E-mail</label>
                        <input type="text" name="email" value="{{old('email')}}">
                    </div>

                    <fieldset>
                        <h5>Nyitvatartás</h5>
                        <p>24 órás formátumba megadva, percadatok nélkül. Pl. 8 - 16</p>
                    </fieldset>
                    @foreach(\App\Models\OpeningHour::DAYS as $dayId => $day)
                        <div class="form-row">
                            <label for="">{{$day}}</label>
                            <input type="text" name="days[{{$dayId}}][from]" value="{{old('days.'.$dayId.'.from')}}" placeholder="pl. 8">
                            <span style="margin: 15px 10px"> - </span>
                            <input type="text" name="days[{{$dayId}}][to]" value="{{old('days.'.$dayId.'.to')}}" placeholder="pl. 16">
                        </div>
                    @endforeach

                    <button type="submit" class="food-btn style-2"><span>Mentés</span></button>
                </form>
            </div>
        </div>
    </section>
@endsection