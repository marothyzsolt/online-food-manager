@extends('layouts.app')

@section('main')
    <section class="popular-foods padding-tb" style="background-color: #fafeff;">
        <div class="container">
            <div class="section-header">
                <h3>{{$user->name}} futár megrendelései</h3>
                <p>Egyenleg: {{ $stat['balance'] }} Ft</p>
                <p>Teljesített megrendelés: {{ $stat['finished_orders'] }} db</p>
                <p>Jutalék: {{ $stat['commission'] }}%</p>
            </div>
            <div class="section-wrapper">
                <div class="shop-cart padding-tb">
                    <div class="container">
                        <div class="section-wrapper">
                            <div class="cart-top">
                                <h5 class="p-3">Elfogadásra váró rendelések</h5>
                                <table>
                                    <thead>
                                    <tr>
                                        <th>Megendelő neve</th>
                                        <th>Étterem</th>
                                        <th>Cím</th>
                                        <th>Telefonszám</th>
                                        <th>Összeg</th>
                                        <th>Jutalék</th>
                                        <th>Leadva</th>
                                        <th>Átadásig</th>
                                        <th>Műveletek</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($pendingOrders as $order)
                                        <tr>
                                            <td>{{ $order->name }}</td>
                                            <td>{{ $order->restaurant->name }}</td>
                                            <td>{{ $order->zip }} {{ $order->city }}, {{ $order->address }}</td>
                                            <td>{{ $order->phone }}</td>
                                            <td>{{ $order->total }} HUF</td>
                                            <td>{{ $user->comission > 0 ? $order->total / $user->comission / 100 : 0 }} HUF</td>
                                            <td>{{ $order->created_at }}</td>
                                            <td>még {{ $order->arrivedAtText }}</td>
                                            <td>
                                                <a data-toggle="tooltip" data-placement="top" title="Elutasítás"
                                                   class="action-icon icofont-lg"
                                                   href="/courier/orders/{{ $order->id }}/decline">
                                                    <i class="icofont-error"></i>
                                                </a>
                                                <a data-toggle="tooltip" data-placement="top" title="Elfogadás"
                                                   class="action-icon icofont-lg"
                                                   href="/courier/orders/{{ $order->id }}/accept">
                                                    <i class="icofont-check"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>


                            <div class="cart-top">
                                <h5 class="p-3">Folyamatban lévő megrendelések</h5>
                                <table>
                                    <thead>
                                    <tr>
                                        <th>Megendelő neve</th>
                                        <th>Étterem</th>
                                        <th>Cím</th>
                                        <th>Telefonszám</th>
                                        <th>Összeg</th>
                                        <th>Jutalék</th>
                                        <th>Műveletek</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($acceptedOrders as $order)
                                        <tr>
                                            <td>{{ $order->name }}</td>
                                            <td>{{ $order->restaurant->name }}</td>
                                            <td>{{ $order->zip }} {{ $order->city }}, {{ $order->address }}</td>
                                            <td>{{ $order->phone }}</td>
                                            <td>{{ $order->total }} HUF</td>
                                            <td>{{ $user->comission > 0 ? $order->total / $user->comission / 100 : 0 }} HUF</td>
                                            <td>
                                                <a data-toggle="tooltip" data-placement="top" title="Befejezve / Átadva"
                                                   class="action-icon icofont-lg"
                                                   href="/courier/orders/{{ $order->id }}/finished">
                                                    <i class="icofont-check"></i>
                                                </a>
                                            </td>
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