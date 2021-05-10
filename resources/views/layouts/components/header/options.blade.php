<div class="author-area">
    <div class="cart-option">
        <i class="icofont-cart-alt cart-icon"></i>
        <div class="count-item">{{$cart->count}}</div>
        <div class="cart-content">
            <div class="cart-title">
                <div class="add-item">
                    @if ($cart->count === 0)
                        A kosár üres
                    @else
                        {{$cart->count}} db termék a kosárban
                    @endif
                </div>
            </div>
            <div class="cart-scr scrollbar">
                <div class="cart-con-item">

                    @if ($cart->count === 0)
                        <h4 style="line-height: 60px">
                            A kosár jelenleg üres...
                        </h4>
                    @else

                        @foreach($cart->items as $item)
                            <div class="cart-item">
                                <div class="cart-inner">
                                    <div class="cart-top">
                                        <div class="thumb">
                                            <a href="#"><img src="{{ $item->item->mainImage()->link }}" alt=""></a>
                                        </div>
                                        <div class="content">
                                            <a href="#">{{ $item->item->name }}</a>
                                        </div>
                                        <div class="remove-btn">
                                            <a href="/cart/delete/{{$item->item->id}}"><i class="icofont-close"></i></a>
                                        </div>
                                    </div>
                                    <div class="cart-bottom">
                                        <div class="cart-plus-minus">
                                            <div class="dec qtybutton">-</div>
                                            <div class="dec qtybutton">-</div>
                                            <input class="cart-plus-minus-box" type="text" name="qtybutton" disabled value="{{$item->quantity}}">
                                            <div class="inc qtybutton">+</div>
                                            <div class="inc qtybutton">+</div>
                                        </div>
                                        <div class="total-price">{{$item->total}} {{$item->currency}}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="cart-scr-bottom">
                <ul>
                    <li>
                        <div class="title">Összesen</div>
                        <div class="price">{{$cart->total}} HUF</div>
                    </li>
                    <li>
                        <div class="title">Kiszállítás</div>
                        <div class="price">0 HUF</div>
                    </li>
                    <li>
                        <div class="title">Végösszeg</div>
                        <div class="price">{{$cart->total}} HUF</div>
                    </li>
                </ul>
                <a href="/cart" class="food-btn"><span>Tovább</span></a>
            </div>
        </div>
    </div>
    <div class="author-account">
        @auth
            <div class="author-icon">
                <i class="icofont-ui-user"></i>
            </div>
            <div class="author-select">
                <a href="/profile">
                    Fiókom
                </a>
            </div>
        @endauth


        @guest
            <a href="{{ route('login') }}" class="food-btn"><span>Bejelentkezés</span></a>
        @endguest
    </div>
</div>