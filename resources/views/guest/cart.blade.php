@extends('layouts.app')

@section('main')
    @if (\Session::has('token'))
        <div class="w-100 text-center mt-5 mb-5 pt-5 pb-5" style="margin: 220px 0">
            <h4>
                Sikeres rendelés leadás!
            </h4>
            <h5>
                <a href="/orders/{{ \Session::get('token') }}">Tovább a rendelés követésére...</a>
            </h5>
        </div>
    @else
    <section class="about home-4 padding-tb restaurant-section">
        <div class="container">
            <div class="section-header">
                <h3>Kosár</h3>
            </div>

            <div class="shop-cart">
                <div class="container">
                    <div class="section-wrapper">
                        @if ($cart !== null && $cart->cart->cartItems()->count() > 0)
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
                                                    <a href="{{ $item->item->link }}"><img
                                                                src="{{ $item->item->mainImage()->link }}" alt=""></a>
                                                </div>
                                                <div class="p-content">
                                                    <a href="{{ $item->item->link }}">{{ $item->item->name }}</a>
                                                </div>
                                            </td>
                                            <td>{{$item->total}} {{$item->currency}}</td>
                                            <td>
                                                <form id="delete-form-{{ $item->id }}" action="/cart/delete/{{$item->item->id}}"
                                                      method="POST" style="display: none;">
                                                    @csrf
                                                    @method('get')
                                                </form>
                                                <a data-toggle="tooltip" data-placement="top" title="Törlés"
                                                   class="action-icon"
                                                   href="/cart/delete/{{$item->item->id}}"
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
                                            <div class="mb-3">
                                                <h4>Szállítás módja</h4>
                                                <select class="form-select block mt-1 w-full select" name="type"
                                                        id="delivery">
                                                    <option value="0">Személyes átvétel</option>
                                                    <option value="1">Kiszállítás</option>
                                                </select>
                                            </div>

                                            @csrf
                                            <h4>Szállítási cím</h4>
                                            <div>
                                                <div class="form-row" id="delivery-name">
                                                    <label for="">Teljes név</label>
                                                    <input type="text" name="name" required maxlength="32"
                                                           value="{{old('name', $currentUser?->name)}}"
                                                           @if ($currentUser !== null) disabled @endif>
                                                </div>
                                                <div class="form-row" id="delivery-zip">
                                                    <label for="">Irányítószám</label>
                                                    <input type="text" name="zip" maxlength="4"
                                                           value="{{old('zip', $currentUser?->zip)}}"
                                                           @if ($currentUser !== null) disabled @endif>
                                                </div>
                                                <div class="form-row" id="delivery-city">
                                                    <label for="">Város</label>
                                                    <input type="text" name="city" maxlength="32"
                                                           value="{{old('city', $currentUser?->city)}}"
                                                           @if ($currentUser !== null) disabled @endif>
                                                </div>
                                                <div class="form-row" id="delivery-address">
                                                    <label for="">Cím</label>
                                                    <input type="text" name="address" maxlength="32"
                                                           value="{{old('address', $currentUser?->address)}}"
                                                           @if ($currentUser !== null) disabled @endif>
                                                </div>
                                                <div class="form-row" id="delivery-phone">
                                                    <label for="">Telefonszám</label>
                                                    <input type="text" name="phone" required maxlength="32"
                                                           value="{{old('phone', $currentUser?->phone)}}">
                                                </div>
                                                <div class="form-row" id="delivery-email">
                                                    <label for="">Email</label>
                                                    <input type="text" name="email" required maxlength="32"
                                                           value="{{old('email', $currentUser?->email)}}"
                                                           @if ($currentUser !== null) disabled @endif>
                                                </div>
                                                <div class="form-row" id="delivery-comment">
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
                        @else
                            <div style="width: 100%; text-align: center">
                                <h4>A kosár jelenleg üres...</h4>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
@endsection

@section('script')
    <script>
      $(function () {
        changeDeliveryType($('#delivery option:selected')[0].value);

        $('#delivery').change((e) => {
          changeDeliveryType(e.target.value);
        });
      })

      function changeDeliveryType(deliveryType)
      {
        switch (parseInt(deliveryType)) {
          case 0: // Szeméyles átvétel
            $('#delivery-city').hide();
            $('#delivery-zip').hide();
            $('#delivery-address').hide();
            break;

          case 1: // Kiszállítás
            $('#delivery-city').show();
            $('#delivery-zip').show();
            $('#delivery-address').show();
            break;
        }
      }
    </script>
@endsection