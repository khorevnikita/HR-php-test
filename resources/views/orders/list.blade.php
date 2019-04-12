@extends("layouts.app")
@section("content")
    <h3>Orders</h3>

    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>
                    ID
                </th>
                <th>
                    Partner
                </th>
                <th>
                    Price
                </th>
                <th>
                    Products
                </th>
                <th>
                    Status
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>
                        <a href="{{url("/orders/$order->id/edit")}}">{{$order->id}}</a>
                    </td>
                    <td>
                        {{$order->partner?$order->partner->name:"-"}}
                    </td>
                    <td>
                        ${{$order->price}}
                    </td>
                    <td>
                        <ol>
                            @foreach($order->products as $product)
                                <li>
                                    <strong>{{$product->name}}</strong>:
                                    {{$product->pivot->quantity}} x ${{$product->pivot->price}}
                                </li>
                            @endforeach
                        </ol>
                    </td>
                    <td>
                        @switch($order->status)
                            @case("10")
                            <span class="label label-success">Accepted</span>
                            @break

                            @case("20")
                            <span class="label label-default">Closed</span>
                            @break
                            @default
                            <span class="label label-warning">New</span>
                        @endswitch
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection