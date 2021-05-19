@extends('layouts.app')

@section('main')
    <section class="popular-foods padding-tb" style="background-color: #fafeff;">
        <div class="container">
            <div class="section-header">
                <h3>Keresés</h3>
            </div>

            <form class="d-flex flex-wrap justify-content-between" method="get" action="/search" enctype="multipart/form-data">
                <div class="form-row">
                    <select class="form-select block mt-1 w-full" name="restaurant" id="type" style="padding: 20px">
                        <option selected>Étterem (nem kötelező)</option>
                        @foreach (\App\Models\Restaurant::all() as $restaurant)
                            <option {{ $restaurantId == $restaurant->id ? "selected" : "" }} value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-row">
                    <input type="text" name="search" maxlength="32" value="{{ $searchString }}" placeholder="Keresendő szöveg">
                </div>
                <div class="form-row">
                    <button class="food-btn style-2 w-100">
                        Keresés
                    </button>
                </div>
            </form>
            @if (count($results) > 0)
            <div class="section-wrapper">
                <div class="shop-cart padding-tb">
                    <div class="container">
                        <div class="section-wrapper">
                            <div class="cart-top">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>Termék</th>
                                        <th>Étterem</th>
                                        <th>Ár</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($results as $item)
                                        <tr>
                                            <td class="product-item">
                                                <div class="p-thumb">
                                                    <a href="/restaurants/"><img src="{{ $item->mainImage()->link }}" alt="product"></a>
                                                </div>
                                                <div class="p-content">
                                                    <a href="/restaurants/">{{ $item->name }}</a>
                                                </div>
                                            </td>
                                            <td><a href="{{ $item->restaurant->link }}">{{ $item->restaurant->name }}</a></td>
                                            <td style="width: 200px">{{ $item->mainPrice->price }} HUF</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>

@endsection