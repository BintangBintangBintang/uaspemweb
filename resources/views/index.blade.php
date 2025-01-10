@extends('layouts.app')
@section('content')
<main>

<section class="swiper-container js-swiper-slider swiper-number-pagination slideshow" data-settings='{
    "autoplay": {
      "delay": 5000
    },
    "slidesPerView": 1,
    "effect": "fade",
    "loop": true
  }'>
  <div class="swiper-wrapper">
    @foreach($featuredProducts as $product)
      <div class="swiper-slide">
        <div class="overflow-hidden position-relative h-100">
          <div class="slideshow-character position-absolute bottom-0 pos_right-center">
          <img src="{{ url('uploads/products/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" 
          onerror="this.onerror=null; this.src='{{ url('uploads/products/') }}'"
              class="slideshow-character__img animate animate_fade animate_btt animate_delay-9 w-auto h-auto" />
            <div class="character_markup type2">
              <p
                class="text-uppercase font-sofia mark-grey-color animate animate_fade animate_btt animate_delay-10 mb-0">
                {{ $product->name }}
              </p>
            </div>
          </div>
          <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
            <h6 class="text_dash text-uppercase fs-base fw-medium animate animate_fade animate_btt animate_delay-3">
              Featured Items !!!
            </h6>
            <h2 class="h1 fw-normal mb-0 animate animate_fade animate_btt animate_delay-5">{{ $product->name }}</h2>
            <a href="{{ route('shop.index') }}"
              class="btn-link btn-link_lg default-underline fw-medium animate animate_fade animate_btt animate_delay-7">Belanja Sekarang !
              </a>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="container">
    <div
      class="slideshow-pagination slideshow-number-pagination d-flex align-items-center position-absolute bottom-0 mb-5">
    </div>
  </div>
</section>



</main>
@endsection