@extends('layouts.app')

@section('content')
<style>
    .cart-totals td {
        text-align: right;
    }

    .cart-total th,
    .cart-total td {
        color: green;
        font-weight: bold;
        font-size: 21px !important;
    }
</style>
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
        <h2 class="page-title">Cart</h2>
        <div class="checkout-steps">
            <a href="javascript:void();" class="checkout-steps__item active">
                <span class="checkout-steps__item-number">01</span>
                <span class="checkout-steps__item-title">
                    <span>Shopping Bag</span>
                    <em>Manage Your Items List</em>
                </span>
            </a>
            <a href="javascript:void();" class="checkout-steps__item">
                <span class="checkout-steps__item-number">02</span>
                <span class="checkout-steps__item-title">
                    <span>Shipping and Checkout</span>
                    <em>Checkout Your Items List</em>
                </span>
            </a>
            <a href="javascript:void();" class="checkout-steps__item">
                <span class="checkout-steps__item-number">03</span>
                <span class="checkout-steps__item-title">
                    <span>Confirmation</span>
                    <em>Order Confirmation</em>
                </span>
            </a>
        </div>
        <div class="shopping-cart">
            @if($cartItems->count() > 0)
                <div class="cart-table__wrapper">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th></th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartItems as $cartItem)                                                    
                                <tr>
                                    <td>
                                        <div class="shopping-cart__product-item">
                                            <img loading="lazy"
                                                src="{{asset('uploads/products/thumbnails')}}/{{$cartItem->model->image}}"
                                                width="120" height="120" alt="" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="shopping-cart__product-item__detail">
                                            <h4>{{$cartItem->name}}</h4>

                                        </div>
                                    </td>
                                    <td>
                                        <span class="shopping-cart__product-price">${{$cartItem->price}}</span>
                                    </td>

                                    <td>
                                        <div class="qty-control position-relative">
                                            <input type="number" name="quantity" value="{{$cartItem->qty}}" min="1"
                                                class="qty-control__number text-center">
                                            <form method="POST"
                                                action="{{route('cart.reduce.qty', ['rowId' => $cartItem->rowId])}}">
                                                @csrf
                                                @method('PUT')
                                                <div class="qty-control__reduce">-</div>
                                            </form>
                                            <form method="POST"
                                                action="{{route('cart.increase.qty', ['rowId' => $cartItem->rowId])}}">
                                                @csrf
                                                @method('PUT')
                                                <div class="qty-control__increase">+</div>
                                            </form>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="shopping-cart__subtotal">${{$cartItem->subTotal()}}</span>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" class="remove-cart">
                                            <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                                <path
                                                    d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <form class="position-relative bg-body" method="POST" action="{{route('cart.empty')}}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-light" type="submit">CLEAR CART</button>
                    </form>

                </div>
                <div class="shopping-cart__totals-wrapper">
                    <div class="sticky-content">
                        <div class="shopping-cart__totals">
                            <h3>Cart Totals <td>
                                    <form method="POST" action="{{route('cart.remove', ['rowId' => $cartItem->rowId])}}">
                                        @csrf
                                        @method("DELETE")
                                        <a href="javascript:void(0)" class="remove-cart">
                                            <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                                <path
                                                    d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                            </svg>
                                        </a>
                                    </form>
                                </td>
                            </h3>
                            <table class="cart-totals">
                                <tbody>
                                    <tr>
                                        <th>Subtotal</th>
                                        <td>${{Cart::instance('cart')->subtotal()}}</td>
                                    </tr>
                                    <tr>
                                        <th>SHIPPING</th>
                                        <td class="text-right">Free</td>
                                    </tr>

                                    <tr class="cart-total">
                                        <th>Total</th>
                                        <td>${{Cart::instance('cart')->subtotal()}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mobile_fixed-btn_wrapper">
                            <div class="button-wrapper container">
                                <a href="{{route('cart.checkout')}}" class="btn btn-primary btn-checkout">PROCEED TO
                                    CHECKOUT</a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-12 text-center pt-5 pb-5">
                        <p>No item found in your cart</p>

                        <a href="{{route('shop.index')}}" class="btn btn-info">Shop Now</a>
                    </div>
                </div>
            @endif
        </div>
    </section>
</main>
@push("scripts") @endpush
@endsection