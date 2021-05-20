@extends('layouts.app')

@section('main')
    <section class="popular-foods padding-tb" style="background-color: #fafeff;">
        <div class="container">
            <div class="section-header">
                <h3>{{$restaurant->name}} étterem étlapjai</h3>
            </div>
            <div class="section-wrapper">
                    <div class="shop-cart padding-tb">
                        <div class="container">
                            <div class="section-wrapper">
                                <a class="back" href="/admin/restaurants">< Vissza</a>
                                <div class="cart-top">
                                    <table>
                                        <thead>
                                        <tr>
                                            <th>Étlap név</th>
                                            <th>Leírás</th>
                                            <th>Ételek</th>
                                            <th>Szerkesztés</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($menus as $menu)
                                            <tr>
                                                <td class="product-item">
                                                    <div class="p-thumb">
                                                        <a href="/restaurants/{{$restaurant->slug}}/menus/{{$menu->id}}"><img src="{{$menu->media->link}}" alt="product"></a>
                                                    </div>
                                                    <div class="p-content">
                                                        <a href="/restaurants/{{$restaurant->slug}}/menus/{{$menu->id}}">{{$menu->name}}</a>
                                                    </div>
                                                </td>
                                                <td>{{$menu->description}}</td>
                                                <td>
                                                    {{$menu->items->count()}} db
                                                </td>
                                                <td>
                                                    <a href="/admin/restaurants/{{$restaurant->slug}}/menus/{{$menu->id}}/items" class="action-icon" data-toggle="tooltip" data-placement="top" title="Étlap elemei">
                                                        <i class="icofont-navigation-menu"></i>
                                                    </a>
                                                    <a href="/admin/restaurants/{{$restaurant->slug}}/menus/{{$menu->id}}/edit" class="action-icon" data-toggle="tooltip" data-placement="top" title="Szerkesztés">
                                                        <i class="icofont-edit"></i>
                                                    </a>
                                                    <form id="delete-form-{{ $menu->id }}" action="/admin/restaurants/{{$restaurant->slug}}/menus/{{$menu->id}}"
                                                          method="POST" style="display: none;">
                                                        @csrf
                                                        @method('delete')
                                                    </form>
                                                    <a data-toggle="tooltip" data-placement="top" title="Törlés"
                                                            class="action-icon"
                                                       href="/admin/restaurants/{{$restaurant->slug}}/menus/{{$menu->id}}"
                                                       onclick="event.preventDefault();
                                                               document.getElementById('delete-form-{{ $menu->id }}').submit();">
                                                        <i class="icofont-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach

                                        <tr>
                                            <td class="product-item" colspan="4" style="text-align: center">
                                                <button class="btn btn-info btn-block" data-toggle="modal" data-target="#createMenuModal">
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

    @include('admin.restaurants.menus.create')
@endsection