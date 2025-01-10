@extends('layouts.app')

@section('content')

<style>
    .cart-total th,
    .cart-total td {
        color: green;
        font-weight: bold;
        font-size: 21px !important;
    }
</style>

<main class="pt-90">
    <div class="mb-4 pb-4">
        <section class="shop-checkout container">
            <h2 class="page-title">Shipping and Checkout</h2>
            <div class="checkout-steps">
                <a href="{{route('cart.index')}}" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">01</span>
                    <span class="checkout-steps__item-title">
                        <span>Shopping Bag</span>
                        <em>Manage Your Items List</em>
                    </span>
                </a>
                <a href="{{route('cart.checkout')}}" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">02</span>
                    <span class="checkout-steps__item-title">
                        <span>Shipping and Checkout</span>
                        <em>Checkout Your Items List</em>
                    </span>
                </a>
            </div>
            <form name="checkout-form" action="{{route('cart.place.order')}}" method="POST">
                @csrf
                <div class="checkout-form">
                    <div class="billing-info__wrapper">
                        <div class="row">
                            <div class="col-6">
                                <h4>SHIPPING DETAILS</h4>
                            </div>
                        </div>
                        @if($address)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="my-account__address-list">
                                        <div class="my-account__address-item">
                                            <div class="my-account__address-item__detail">
                                                <p>{{$address->name}}</p>
                                                <p>{{$address->address}}</p>
                                                <p>{{$address->zip}}</p>

                                                <p>Phone :- {{$address->phone}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row mt-5">
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="name" value="{{old('name')}}">
                                        <label for="name">Full Name *</label>
                                        <span class="text-danger">@error('name') {{$message}} @enderror</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="phone" value="{{old('phone')}}">
                                        <label for="phone">Phone Number *</label>
                                        <span class="text-danger">@error('phone') {{$message}} @enderror</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="zip" value="{{old('zip')}}">
                                        <label for="zip">Pincode *</label>
                                        <span class="text-danger">@error('zip') {{$message}} @enderror</span>
                                    </div>
                                </div>
                               
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="address" value="{{old('address')}}">
                                        <label for="address">House no, Building Name *</label>
                                        <span class="text-danger">@error('address') {{$message}} @enderror</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="checkout__totals-wrapper">
                        <div class="sticky-content">
                            <div class="checkout__totals">
                                <h3>Your Order</h3>
                                <table class="checkout-cart-items">
                                    <thead>
                                        <tr>
                                            <th>PRODUCT</th>
                                            <th class="text-right">SUBTOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (Cart::instance('cart')->content() as $item)
                                            <tr>
                                                <td>
                                                    {{$item->name}} x {{$item->qty}}
                                                </td>
                                                <td class="text-right">
                                                    ${{$item->subtotal}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <table class="checkout-totals">
                                    <tbody>
                                        <tr>
                                            <th>SUBTOTAL</th>
                                            <td class="text-right">${{Cart::instance('cart')->subtotal()}}</td>
                                        </tr>
                                        <tr>
                                            <th>SHIPPING</th>
                                            <td class="text-right">Free</td>
                                        </tr>

                                        <tr class="cart-total">
                                            <th>TOTAL</th>
                                            <td class="text-right">${{Cart::instance('cart')->subtotal()}}</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                            <div class="form-check">
                                <input class="form-check-input form-check-input_fill" type="radio" name="mode"
                                    value="cod" checked>
                                <label class="form-check-label" for="mode_3">
                                    Cash on delivery
                                </label>
                            </div>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary">PLACE ORDER</button>
                    </div>
                </div>
    </div>
    </form>
    </section>
    </div>
</main>

@endsection