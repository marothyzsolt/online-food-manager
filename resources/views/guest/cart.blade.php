@extends('layouts.app')

@section('main')
    <section class="about home-4 padding-tb restaurant-section">
        <div class="container">
            <div class="section-header">
                <h3>Kosár</h3>
            </div>

            <div class="shop-cart">
                <div class="container">
                    <div class="section-wrapper">
                        <div class="cart-top">
                            <table>
                                <thead>
                                <tr>
                                    <th>Termék</th>
                                    <th>Ár</th>
                                    <th>Törlés</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cart->items as $item)
                                    <tr>
                                        <td class="product-item">
                                            <div class="p-thumb">
                                                <a href="#"><img src="{{ $item->item->mainImage()->link }}" alt=""></a>
                                            </div>
                                            <div class="p-content">
                                                <a href="#">{{ $item->item->name }}</a>
                                            </div>
                                        </td>
                                        <td>{{$item->total}} {{$item->currency}}</td>
                                        <td>
                                            <form id="delete-form-{{ $item->id }}" action="/cart/{{$item->id}}"
                                                  method="POST" style="display: none;">
                                                @csrf
                                                @method('delete')
                                            </form>
                                            <a data-toggle="tooltip" data-placement="top" title="Törlés"
                                               class="action-icon"
                                               href="/cart/{{$item->id}}"
                                               onclick="event.preventDefault();
                                                       document.getElementById('delete-form-{{ $item->id }}').submit();">
                                                <i class="icofont-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="cart-bottom">
                            <div class="shiping-box">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <form class="calculate-shiping" method="post" action="/cart">
                                            @csrf
                                            <h4>Szállítási cím</h4>
                                            <div>
                                                <div class="form-row">
                                                    <label for="">Teljes név</label>
                                                    <input type="text" name="name" required maxlength="32" value="{{old('name', $currentUser?->name)}}" @if ($currentUser !== null) disabled @endif>
                                                </div>
                                                <div class="form-row">
                                                    <label for="">Irányítószám</label>
                                                    <input type="text" name="zip" required maxlength="4" value="{{old('zip', $currentUser?->zip)}}" @if ($currentUser !== null) disabled @endif>
                                                </div>
                                                <div class="form-row">
                                                    <label for="">Város</label>
                                                    <input type="text" name="city" required maxlength="32" value="{{old('city', $currentUser?->city)}}" @if ($currentUser !== null) disabled @endif>
                                                </div>
                                                <div class="form-row">
                                                    <label for="">Telefonszám</label>
                                                    <input type="text" name="phone" required maxlength="32" value="{{old('phone', $currentUser?->phone)}}" @if ($currentUser !== null) disabled @endif>
                                                </div>
                                                <div class="form-row">
                                                    <label for="">Email</label>
                                                    <input type="text" name="email" required maxlength="32" value="{{old('email', $currentUser?->email)}}" @if ($currentUser !== null) disabled @endif>
                                                </div>
                                                <div class="form-row">
                                                    <label for="">Megjegyzés</label>
                                                    <input type="text" name="comment">
                                                </div>
                                            </div>
                                            <div>
                                                <button type="submit" class="food-btn"><span>Megrendelem</span></button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="cart-overview">
                                            <h4>Végösszeg</h4>
                                            <ul>
                                                <li>
                                                    <span class="pull-left">Kiszállítási idő</span>
                                                    <p class="pull-right">{{ $cart->shipping_time }} perc</p>
                                                </li>
                                                <li>
                                                    <span class="pull-left">Végösszeg</span>
                                                    <p class="pull-right">{{ $cart->total }} Ft</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection