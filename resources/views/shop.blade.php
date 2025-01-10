@extends('layouts.app')

@section('content')

<div class="container">
    <!-- Form Pencarian -->
    <form action="{{ route('shop.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search-keyword" class="form-control" placeholder="Search products" value="{{ request('search-keyword') }}">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    <h1>Shop</h1>
    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4">
            <div class="card mb-4">
                
                <img src="{{ url('uploads/products/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}"
                onerror="this.onerror=null; this.src='{{ url('uploads/products/') }}';">
                
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                    <p class="card-text"><strong>Price:</strong> ${{ number_format($product->regular_price, 2) }}</p>
                    <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}" class="btn btn-primary">Cek Lebih Detail</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
