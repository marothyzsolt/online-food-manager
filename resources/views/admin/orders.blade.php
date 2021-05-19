@extends('layouts.app')

@section('main')
    <section class="popular-foods padding-tb" style="background-color: #fafeff;">
        <div class="container">
            <div class="section-header">
                <h3>Megrendelések</h3>
            </div>
            <div class="section-wrapper">
                <div class="shop-cart padding-tb">
                    <div class="container">
                        <div class="section-wrapper">
                            <div class="cart-top">
                                <h5 class="p-3">Megrendelések</h5>
                                <table>
                                    <thead>
                                    <tr>
                                        <th>Megendelő neve</th>
                                        <th>Étterem</th>
                                        <th>Cím</th>
                                        <th>Telefonszám</th>
                                        <th>Összeg</th>
                                        <th>Szállította</th>
                                        <th>Leadva</th>
                                        <th>Átadásig</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{ $order->name }}</td>
                                            <td>{{ $order->restaurant->name }}</td>
                                            <td>
                                                @if ($order->type === \App\Models\Order::TYPE_PERSONAL)
                                                    Személyes átvétel
                                                @else
                                                    {{ $order->zip }} {{ $order->city }}, {{ $order->address }}
                                                @endif
                                            </td>
                                            <td>{{ $order->phone }}</td>
                                            <td>{{ $order->total }} HUF</td>
                                            <td>
                                                @if ($order->type === \App\Models\Order::TYPE_PERSONAL)
                                                    Személyes átvétel
                                                @else
                                                    @if ($order->courier_id === null)
                                                        Feldolgozás alatt...
                                                    @else
                                                        {{ $order->courier->namer }}
                                                        [{{ $user->comission > 0 ? $order->total / $user->comission / 100 : 0 }} HUF]
                                                    @endif
                                                @endif
                                            </td>
                                            <td>{{ $order->created_at }}</td>
                                            <td>még {{ $order->arrivedAtText }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection