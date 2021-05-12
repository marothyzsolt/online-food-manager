@extends('layouts.app')

@section('main')
    <section class="popular-foods padding-tb" style="background-color: #fafeff;">
        <div class="container">
            <div class="section-header">
                <h3>{{$menu->name}} étlap ({{$restaurant->name}} étterem)</h3>
            </div>
            <div class="section-wrapper">
                    <div class="shop-cart padding-tb">
                        <div class="container">
                            <div class="section-wrapper">
                                <div class="cart-top">
                                    <a class="back" href="/admin/restaurants/{{$restaurant->slug}}/menus">< Vissza</a>
                                    <table>
                                        <thead>
                                        <tr>
                                            <th>Étel neve</th>
                                            <th>Leírás</th>
                                            <th>Ár</th>
                                            <th>Szerkesztés</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($items as $item)
                                            <tr>
                                                <td class="product-item">
                                                    <div class="p-thumb">
                                                        <a href="#"><img src="{{$item->mainImage()->link}}" alt=""></a>
                                                    </div>
                                                    <div class="p-content">
                                                        <a href="/restaurants/{{$restaurant->slug}}/items/{{$item->id}}">{{$item->name}}</a>
                                                    </div>
                                                </td>
                                                <td>{{$item->description}}</td>
                                                <td>{{$item->mainPrice->price}} {{$item->mainPrice->currency->code}}</td>
                                                <td>
                                                    <form id="delete-form-{{ $item->id }}" action="/admin/restaurants/{{$restaurant->slug}}/menus/{{$menu->id}}/items/{{$item->id}}"
                                                          method="POST" style="display: none;">
                                                        @csrf
                                                        @method('delete')
                                                    </form>
                                                    <a data-toggle="tooltip" data-placement="top" title="Törlés"
                                                            class="action-icon"
                                                       href="/admin/restaurants/{{$restaurant->slug}}/menus/{{$menu->id}}/items/{{$item->id}}"
                                                       onclick="event.preventDefault();
                                                               document.getElementById('delete-form-{{ $item->id }}').submit();">
                                                        <i class="icofont-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach

                                        <tr>
                                            <td class="product-item" colspan="4" style="text-align: center">
                                                <button class="btn btn-info btn-block" data-toggle="modal" data-target="#createMenuItemModal">
                                                    Hozzáadás
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </section>

    @include('admin.restaurants.menus.items.create')
@endsection