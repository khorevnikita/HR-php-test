<div>
    <p>
        <strong>Заказ №{{$order->id}} завершен.</strong>
    </p>
    <ol>
        @foreach($order->products as $product)
            <li>
                <strong>{{$product->name}}</strong>:
                {{$product->pivot->quantity}} x ${{$product->pivot->price}}
            </li>
        @endforeach
    </ol>
    <h4>Price: ${{$order->price}}</h4>
</div>