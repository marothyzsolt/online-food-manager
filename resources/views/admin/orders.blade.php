@extends('layouts.app')

@section('main')
    <section class="popular-foods padding-tb" style="background-color: #fafeff;">
        <div class="container">
            <div class="section-header">
                <h3>Megrendelések</h3>
            </div>

            <form class="d-flex flex-wrap justify-content-between" method="get" action="/admin/orders" enctype="multipart/form-data">
                <div class="form-row">
                    <input type="date" name="from" maxlength="16" value="{{ $fromString }}" placeholder="-tól">
                    <input type="date" name="to" maxlength="16" value="{{ $toString }}" placeholder="-ig">
                    <button class="food-btn style-2 w-100">
                        Keresés
                    </button>
                </div>
                </div>
            </form>

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
                                        <th>Státusz</th>
                                        <th>Leadva</th>
                                        <th>Átadásig</th>
                                        <th></th>
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
                                                        {{ $order->status }}
                                                    @else
                                                        {{ $order->status }} (
                                                        {{ $order->courier->namer }}
                                                        [{{ $user->comission > 0 ? $order->total / $user->comission / 100 : 0 }} HUF])
                                                    @endif
                                                @endif
                                            </td>
                                            <td>{{ $order->created_at }}</td>
                                            <td>
                                                @if($order->status === 'delivered')
                                                    Rendelés teljesítve
                                                @else
                                                    még {{ $order->arrivedAtText }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($order->courier_status === \App\Models\Order::COURIER_DECLINED)
                                                    <a data-toggle="tooltip" data-placement="top" title="Új státusz: Újraütemezés"
                                                       class="action-icon"
                                                       href="/admin/orders/{{$order->id}}/status/refresh">
                                                        <i class="icofont-refresh"></i>
                                                    </a>
                                                @endif

                                                @if($order->status === 'ordered')
                                                    <a data-toggle="tooltip" data-placement="top" title="Új státusz: Elkészítés alatt"
                                                       class="action-icon"
                                                       href="/admin/orders/{{$order->id}}/status/making">
                                                        <i class="icofont-check"></i>
                                                    </a>
                                                @elseif($order->status === 'making')
                                                    <a data-toggle="tooltip" data-placement="top" title="Új státusz: Az étel elkészült"
                                                       class="action-icon"
                                                       href="/admin/orders/{{$order->id}}/status/finished">
                                                        <i class="icofont-referee"></i>
                                                    </a>
                                                @elseif($order->status === 'delivered')
                                                    Rendelés teljesítve
                                                @elseif($order->status === 'delivering')
                                                    Futárnak átadva ({{ $order->courier?->name }})
                                                @else
                                                    @if($order->type === \App\Models\Order::TYPE_DELIVERY)
                                                        Futárra vár...
                                                    @else
                                                        <a data-toggle="tooltip" data-placement="top" title="Új státusz: Rendelés teljesítve"
                                                           class="action-icon"
                                                           href="/admin/orders/{{$order->id}}/status/delivered">
                                                            <i class="icofont-airplane"></i>
                                                        </a>
                                                    @endif
                                                @endif
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