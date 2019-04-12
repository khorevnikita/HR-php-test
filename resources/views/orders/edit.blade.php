@extends("layouts.app")
@section("content")
    <h3>Order №{{$order->id}}</h3>
    <div class="row">
        <div class="col-sm-6">
            <form action="{{url("/orders/$order->id")}}" method="post">
                {{csrf_field()}}
                {{method_field("PUT")}}
                <div class="form-group">
                    <label for="email">Client e-mail</label>
                    <input id="email" class="form-control" type="email" name="client_email"
                           value="{{old("client_email")?:$order->client_email}}">
                </div>
                <div class="form-group">
                    <label for="partner">Partner</label>
                    <select id="partner" class="form-control" name="partner_id">
                        @foreach($partners as $partner)
                            <option value="{{$partner->id}}"
                                    @if(old("partner_id")?(old("partner_id")==$partner->id):$partner->id == $order->partner->id) selected @endif>
                                {{$partner->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <ol>
                        @foreach($order->products as $product)
                            <li>
                                <strong>{{$product->name}}</strong>:
                                {{$product->pivot->quantity}} x ${{$product->pivot->price}}
                            </li>
                        @endforeach
                    </ol>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" class="form-control" name="status">
                        @foreach($statuses as $code=>$name)
                            <option value="{{$code}}"
                                    @if($code==$order->status) selected @endif>
                                {{$name}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <p>Price: ${{$order->price}}</p>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>

@endsection