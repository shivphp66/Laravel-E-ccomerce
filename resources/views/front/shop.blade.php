
@extends("front.layouts.app")

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Shop</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-6 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 sidebar">
                    <div class="sub-title">
                        <h2>Categories</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="accordion accordion-flush" id="accordionExample">
                                @if($categories->isNotEmpty())
                                @foreach($categories as $key => $category)
                                <div class="accordion-item">
                                @if($category->sub_categories->isNotEmpty())
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne-{{$key}}" aria-expanded="false" aria-controls="collapseOne-{{$key}}">
                                            {{ $category->name }}
                                        </button>
                                    </h2>
                                     @else
                                     <a href="{{ route('front.shop',$category->slug)}}" class="nav-item nav-link {{ ($categorySelected == $category->id) ? 'text-primary' : '' }}">{{ $category->name }}</a>
                                     @endif

                                 @if($category->sub_categories->isNotEmpty())
                                    <div id="collapseOne-{{$key}}" class="accordion-collapse collapse {{ ($categorySelected == $category->id) ? 'show' : '' }}" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                        <div class="accordion-body">
                                            <div class="navbar-nav">
                                                @foreach($category->sub_categories as $subCategory)
                                                <a href="{{ route('front.shop',[$category->slug,$subCategory->slug])}}" class="nav-item nav-link {{ ($subcategorySelected == $subCategory->id) ? 'text-primary' : '' }}">{{ $subCategory->name }}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="sub-title mt-5">
                        <h2>Brand</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                        @if($brands->isNotEmpty())
                        @foreach($brands as $key => $brand)
                            <div class="form-check mb-2">
                                <input {{ in_array($brand->id, $brandArray ) ? 'checked' : '' }} class="form-check-input brand-lavel"  name="brand[]" type="checkbox" value="{{$brand->id }}" id="brand-{{$key}}">
                                <label class="form-check-label" for="brand-{{ $key }}">
                                    {{ $brand->name }}
                                </label>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="sub-title mt-5">
                        <h2>Price</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                        <input type="text" class="js-range-slider" name="my_range" value="" />
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row pb-3">
                        <div class="col-12 pb-1">
                            <div class="d-flex align-items-center justify-content-end mb-4">
                                <div class="ml-2">
                                    <select name="sort" id="sort" class="form-control">
                                        <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>Latest</option>
                                        <option value="price_desc" {{ $sort == 'price_desc' ? 'selected' : '' }}>Price High</option>
                                        <option value="price_asc" {{ $sort == 'price_asc' ? 'selected' : '' }}>Price Low</option>
                                    </select>

                                </div>
                            </div>
                        </div>

                        @if($products->isNotEmpty())
                        @foreach($products as $product)
                        @php
                            $productImge = $product->product_image->first();
                        @endphp
                        <div class="col-md-4">
                            <div class="card product-card">
                                <div class="product-image position-relative">
                                  <a href="{{ route('front.product',$product->slug) }}" class="product-img">
                                    @if(!empty($productImge->image))
                                    <img class="card-img-top" src="{{ asset('uploads/product/small/'.$productImge->image)}}" alt="">
                                    @else
                                    <img src="{{asset('admin-assets/img/default-150x150.png')}}" class="img-thumbnail" >
                                    @endif
                                    </a>
                                    <a onclick="addToWishlist({{ $product->id }});" class="whishlist" href="javascript:void(0)"><i class="far fa-heart"></i>
                                    <div class="product-action">
                                        @if ($product->	track_qty =='Yes')
                                        @if ($product->qty >0)
                                        <a href="javascript:void(0)" onclick="addToCart({{ $product->id }});" class="btn btn-dark">
                                          <i class="fa fa-shopping-cart"></i> Add To Cart
                                      </a>
                                        @else
                                        <a href="javascript:void(0)" class="btn btn-dark">
                                          <i class="fa fa-shopping-cart"></i> Out Of Stock
                                      </a>
                                        @endif
                                        @else
                                            <a href="javascript:void(0)" onclick="addToCart({{ $product->id }});" class="btn btn-dark">
                                             <i class="fa fa-shopping-cart"></i> Add To Cart
                                            </a>
                                      @endif
                                    </div>
                                </div>
                                <div class="card-body text-center mt-3">
                                    <a class="h6 link" href="product.php">{{ $product->title }}</a>
                                    <div class="price mt-2">
                                        <span class="h5"><strong>{{ $product->price }}</strong></span>
                                        <span class="h6 text-underline"><del>{{ $product->compare_price }}</del></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        <div class="col-md-12 pt-5">
                          {{ $products->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('customJs')
<script>

$(".js-range-slider").ionRangeSlider({
      type: "double",
        grid: true,
        min: 0,
        max: 50000,
        from: {{ $minPrice }},
        to: {{ $maxPrice }},
        prefix : "₹",
        skin: "round",
        max_post_fix : "+",
        onFinish : function(){
          apply_filter();
        }

    });
    let my_range = $(".js-range-slider").data("ionRangeSlider");
    $(".brand-lavel").change(function(){
        apply_filter();
    });
    $("#sort").change(function(){
        apply_filter();

    });

  function apply_filter(){
   var brands = [];
   $(".brand-lavel").each(function(){
    if($(this).is(":checked")== true){
        brands.push($(this).val());
    }
   });

   var url = '{{ url()->current() }}?';

  //price filter//
    url +='&min_price='+my_range.result.from+'&max_price='+my_range.result.to;

   //sorting filter//
     url +='&sort='+$("#sort").val();

   //brand filter//
    if(brands.length > 0){
        url += '&brand='+brands.toString();
    }

   //product filter
    var search = $("#search").val();
    if(search.length > 0){
        url += '&search='+search;
    }

   window.location.href = url;
  }

</script>

@endsection

