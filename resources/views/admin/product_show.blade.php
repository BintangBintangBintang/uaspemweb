@extends('layouts.admin')

@section('content')
    <!-- main-content-wrap -->
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Product Details</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Product Details</div>
                    </li>
                </ul>
            </div>

            <!-- product-details -->
            <div class="wg-box">
                <div class="cols gap20">
                    <!-- Product Image -->
                    <div class="product-image">
                        <img src="{{ asset('uploads/products/' . $product->image) }}" alt="{{ $product->name }}" class="w-full effect8">
                    </div>

                    <!-- Product Info -->
                    <div class="product-info">
                        <h3 class="mb-10">{{ $product->name }}</h3>
                        <p class="text-tiny tf-color-1 mb-10">SKU: {{ $product->SKU }}</p>
                        <p class="text-tiny tf-color-1 mb-10">Stock: {{ $product->stock_status === 'instock' ? 'In Stock' : 'Out of Stock' }}</p>
                        <p class="text-tiny tf-color-1 mb-10">Quantity: {{ $product->quantity }}</p>
                        <p class="text-tiny tf-color-1 mb-10">Regular Price: ${{ number_format($product->regular_price, 2) }}</p>
                        <p class="text-tiny tf-color-1 mb-10">Sale Price: ${{ number_format($product->sale_price, 2) }}</p>
                        <p class="text-tiny tf-color-1 mb-10">Featured: {{ $product->featured ? 'Yes' : 'No' }}</p>
                    </div>
                </div>

                <!-- Description -->
                <div class="product-description mt-20">
                    <h4 class="mb-10">Short Description</h4>
                    <p class="text-tiny">{{ $product->short_description }}</p>

                    <h4 class="mt-20 mb-10">Description</h4>
                    <p class="text-tiny">{{ $product->description }}</p>
                </div>

                <!-- Gallery -->
                @if($product->gallery && count($product->gallery) > 0)
                    <div class="product-gallery mt-20">
                        <h4 class="mb-10">Gallery</h4>
                        <div class="cols gap10">
                            @foreach ($product->gallery as $galleryImage)
                                <div class="item">
                                    <img src="{{ asset('uploads/products/thumbnails/' . $galleryImage) }}" alt="Gallery Image" class="w-full effect8">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            <!-- /product-details -->
        </div>
        <!-- /main-content-wrap -->
    </div>
    <!-- /main-content-wrap -->
@endsection
