@extends('layouts.app')

@section('main')
    <section class="about home-4 padding-tb restaurant-section">
        <div class="container">
            <div class="section-header">
                <h3>Profil szerkesztése</h3>
            </div>

            <div class="section-wrapper">
                <div class="form-errors">
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                </div>

                <form class="d-flex flex-wrap justify-content-between" method="post" action="/profile" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <fieldset>
                        <h5>Alapadatok</h5>
                    </fieldset>
                    <div class="form-row">
                        <label for="">Név</label>
                        <input type="text" name="name" required maxlength="32" value="{{old('name', $user->name)}}">
                    </div>
                    <div class="form-row">
                        <label for="">E-mail cím</label>
                        <input type="text" name="email" required maxlength="32" value="{{old('email', $user->email)}}">
                    </div>
                    <div class="form-row">
                        <label for="">Telefonszám</label>
                        <input type="text" name="phone" required maxlength="32" value="{{old('phone', $user->phone)}}">
                    </div>

                    <fieldset>
                        <h5>Cím</h5>
                    </fieldset>
                    <div class="form-row">
                        <label for="">Irányítószám</label>
                        <input type="text" name="zip" required maxlength="32" value="{{old('zip', $user->zip)}}">
                    </div>
                    <div class="form-row">
                        <label for="">Város</label>
                        <input type="text" name="city" required maxlength="32" value="{{old('city', $user->city)}}">
                    </div>
                    <div class="form-row">
                        <label for="">Cím</label>
                        <input type="text" name="address" required maxlength="32" value="{{old('address', $user->address)}}">
                    </div>

                    <fieldset>
                        <h5>Ekkor vagyok elérhető...</h5>
                    </fieldset>
                    @foreach(\App\Models\CourierActivity::DAYS as $dayId => $day)
                        <div class="form-row">
                            <label for="">{{$day}}</label>
                            <input type="text" name="days[{{$dayId}}][from]" value="{{old('days.'.$dayId.'.from', $user->activityList[$dayId]?->from)}}" placeholder="pl. 8">
                            <span style="margin: 15px 10px"> - </span>
                            <input type="text" name="days[{{$dayId}}][to]" value="{{old('days.'.$dayId.'.to', $user->activityList[$dayId]?->to)}}" placeholder="pl. 16">
                        </div>
                    @endforeach

                    <button type="submit" class="food-btn style-2"><span>Mentés</span></button>
                </form>
            </div>
        </div>
    </section>
@endsection