@extends("layouts.app")
@section("content")
    <h3>Products</h3>

    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>
                    ID
                </th>
                <th>
                    Name
                </th>
                <th>
                    Vendor
                </th>
                <th>
                    Price
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>
                        {{$product->id}}
                    </td>
                    <td>
                        {{$product->name}}
                    </td>
                    <td>
                        {{$product->vendor?$product->vendor->name:"-"}}
                    </td>
                    <td>
                        <div class="js-product-price" data-product="{{$product->id}}">
                            <button class="btn btn-link">${{$product->price}}</button>
                        </div>
                        <div class="input-group hidden" id="price-input-{{$product->id}}">
                            <span class="input-group-addon">$</span>
                            <input id="price-{{$product->id}}" type="text" class="form-control"
                                   value="{{$product->price}}">
                            <span class="input-group-btn">
                                <button class="btn btn-default js-save-price" type="button"
                                        data-product="{{$product->id}}">
                                    Save
                                </button>
                            </span>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="text-center">
            {{$products->links()}}
        </div>
    </div>
    @push("scripts")
        <script>
            function toggleVisibility(el) {
                el.toggleClass("hidden");
                $("#price-input-" + el.data("product")).toggleClass("hidden");
            }

            $('.js-product-price').click(function () {
                toggleVisibility($(this));
            });

            $('.js-save-price').click(function () {
                let price = $(this).parents(".input-group").find("input").val();
                let id = $(this).data("product");
                if (price < 1) {
                    return false;
                }
                $.ajax({
                    url: '/products/' + id,
                    type: "PUT",
                    data: {price: price, _token: '{{csrf_token()}}'},
                    success: function (r) {
                        if (r.status == 1) {
                            let el = $("[data-product='" + id + "']");
                            el.find("button").text("$" + price);
                            toggleVisibility(el);
                        }
                    }
                });
            })
        </script>
    @endpush
@endsection