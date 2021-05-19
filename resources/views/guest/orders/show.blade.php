@extends('layouts.app')

@section('stylesheet')
    <style>
    </style>
@endsection

@section('main')
    <section class="page-header style-2 delivery-bg">
        <div class="container">
            <div class="page-title text-center">
                <h3>Megrendelés státusza</h3>
            </div>
        </div>
    </section>


    <section class="about home-4 padding-tb restaurant-section">
        <div class="container">

            <div class="section-header mb-5 pb-5">
                <h3>{{ $order->statusText }}</h3>
                @if ($order->status !== \App\Models\Order::STATUS_DELIVERED)
                    <p>
                        Még {{ $order->arrivedAtText }}...
                    </p>
                @endif
            </div>

            <div class="section-header">
                <h3>Megrendelés adatai</h3>
            </div>

            <div class="shop-cart">
                <div class="container">
                    <div class="section-wrapper">
                        <div class="cart-top">
                            <table>
                                <thead>
                                <tr>
                                    <th>Termék</th>
                                    <th>Mennyiség</th>
                                    <th>Ár</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->items as $item)
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
                                        <td>{{$item->quantity}} db</td>
                                        <td>{{$item->price}} {{$item->item->mainPrice->currency->symbol}}</td>
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
                                                <h4>Adatok</h4>
                                                Szállítás módja:
                                                @switch ($order->type)
                                                    @case (\App\Models\Order::TYPE_PERSONAL)
                                                        <b>Személyes átvétel</b>
                                                    @break

                                                    @case (\App\Models\Order::TYPE_DELIVERY)
                                                        <b>Kiszállítás a megadott címre</b>
                                                    @break
                                                @endswitch
                                            </div>

                                            <div class="mb-2">
                                                <b>{{$order->created_at}}</b>
                                            </div>
                                            <div>
                                                Név: {{ $order->name }}
                                            </div>
                                            <div>
                                                Telefonszám: {{ $order->phone }}
                                            </div>
                                            <div>
                                                Email: {{ $order->email }}
                                            </div>
                                            <div>
                                                Név: {{ $order->name }}
                                            </div>
                                            <div>
                                                Megjegyzés: {{ $order->comment }}
                                            </div>

                                            @if ($order->type === \App\Models\Order::TYPE_DELIVERY)
                                                <h4 class="mt-4">Szállítási cím</h4>
                                                <div class="mt-2">
                                                    {{ $order->name }} <br> <br>
                                                    {{ $order->zip }} {{ $order->city }} <br>
                                                    {{ $order->address }} <br>
                                                </div>
                                            @endif
                                        </form>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="cart-overview">
                                            <h4>Végösszeg</h4>
                                            <ul>
                                                <li>
                                                    <span class="pull-left">Kiszállítási idő</span>
                                                    <p class="pull-right">{{ $order->shipping_time ?? 30 }} perc</p>
                                                </li>
                                                <li>
                                                    <span class="pull-left">Végösszeg</span>
                                                    <p class="pull-right">{{ $order->total }} Ft</p>
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

@section('script')
@endsection