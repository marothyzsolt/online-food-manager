@extends('layouts.app')

@section('main')
    <section class="popular-foods padding-tb" style="background-color: #fafeff;">
        <div class="container">
            <div class="section-header">
                <h3>{{$restaurant->name}} étterem ételei</h3>
            </div>
            <div class="section-wrapper">
                <div class="shop-cart">
                    <div class="container">
                        <div class="section-wrapper">
                            <a class="back" href="/admin/restaurants">< Vissza</a>
                            <div class="cart-top">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>Étel neve</th>
                                        <th>Leírás</th>
                                        <th>Allergének</th>
                                        <th>Ár</th>
                                        <th>Szerkesztés</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($items as $item)
                                        <tr>
                                            <td class="product-item">
                                                <div class="p-thumb">
                                                    @if ($item->images()->count() > 0)
                                                        <a href="/admin/restaurants/{{$restaurant->slug}}/items/{{$item->id}}/edit"><img src="{{ $item->images[0]->link }}" alt="product"></a>
                                                    @else
                                                        <a href="/admin/restaurants/{{$restaurant->slug}}/items/{{$item->id}}/edit"><img src="/assets/404.png" alt="product"></a>
                                                    @endif
                                                </div>
                                                <div class="p-content">
                                                    <a href="/admin/restaurants/{{$restaurant->slug}}/items/{{$item->id}}/edit">{{$item->name}}</a>
                                                </div>
                                            </td>
                                            <td>{{$item->description}}</td>
                                            <td>
                                                {{$item->allergens()->count()}} db
                                            </td>
                                            <td>
                                                @if ($item->discounted)
                                                    <span class="discounted">
                                                        {{ $item->mainPrice->price }} {{ $item->mainPrice->currency->code }}
                                                    </span>
                                                    <span>
                                                        {{ $item->mainPrice->discountedPrice }} {{ $item->mainPrice->currency->code }}
                                                    </span>
                                                @else
                                                    <span>
                                                        {{ $item->mainPrice->price }} {{ $item->mainPrice->currency->code }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="/admin/restaurants/{{$restaurant->slug}}/items/{{$item->id}}/edit" class="action-icon" data-toggle="tooltip" data-placement="top" title="Szerkesztés">
                                                    <i class="icofont-edit"></i>
                                                </a>
                                                <form id="delete-form-{{ $item->id }}" action="/admin/restaurants/{{$restaurant->slug}}/items/{{$item->id}}"
                                                      method="POST" style="display: none;">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                                <a data-toggle="tooltip" data-placement="top" title="Törlés"
                                                   class="action-icon"
                                                   href="/admin/restaurants/{{$restaurant->slug}}/items/{{$item->id}}"
                                                   onclick="event.preventDefault();
                                                           document.getElementById('delete-form-{{ $item->id }}').submit();">
                                                    <i class="icofont-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    <tr>
                                        <td class="product-item" colspan="4" style="text-align: center">
                                            <button class="btn btn-info btn-block" data-toggle="modal" data-target="#createItemModal">
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

    @include('admin.items.create', ['item' => new \App\Models\Item()])
@endsection