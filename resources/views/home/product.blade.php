@extends('layout.home')

@section('title', 'Product')

@section('content')

<!-- Single Product -->
<section class="section-wrap pb-40 single-product">
    <div class="container-fluid semi-fluid">
        <div class="row">

            <div class="col-md-6 col-xs-12 product-slider mb-60">

                <div class="flickity flickity-slider-wrap mfp-hover" id="gallery-main">

                    <div class="gallery-cell">
                        <a href="uploads/{{$product->image}}" class="lightbox-img">
                            <img src="uploads/{{$product->image}}" alt="" />
                            <i class="ui-zoom zoom-icon"></i>
                        </a>
                    </div>
                    <div class="gallery-cell">
                        <a href="uploads/{{$product->image}}" class="lightbox-img">
                            <img src="uploads/{{$product->image}}" alt="" />
                            <i class="ui-zoom zoom-icon"></i>
                        </a>
                    </div>
                    <div class="gallery-cell">
                        <a href="uploads/{{$product->image}}" class="lightbox-img">
                            <img src="uploads/{{$product->image}}" alt="" />
                            <i class="ui-zoom zoom-icon"></i>
                        </a>
                    </div>
                    <div class="gallery-cell">
                        <a href="uploads/{{$product->image}}" class="lightbox-img">
                            <img src="uploads/{{$product->image}}" alt="" />
                            <i class="ui-zoom zoom-icon"></i>
                        </a>
                    </div>
                    <div class="gallery-cell">
                        <a href="uploads/{{$product->image}}" class="lightbox-img">
                            <img src="uploads/{{$product->image}}" alt="" />
                            <i class="ui-zoom zoom-icon"></i>
                        </a>
                    </div>
                </div> <!-- end gallery main -->

                <div class="gallery-thumbs">
                    <div class="gallery-cell">
                        <img src="/uploads/{{$product->image}}" alt="" />
                    </div>
                    <div class="gallery-cell">
                        <img src="/uploads/{{$product->image}}" alt="" />
                    </div>
                    <div class="gallery-cell">
                        <img src="/uploads/{{$product->image}}" alt="" />
                    </div>
                    <div class="gallery-cell">
                        <img src="/uploads/{{$product->image}}" alt="" />
                    </div>
                    <div class="gallery-cell">
                        <img src="/uploads/{{$product->image}}" alt="" />
                    </div>
                </div> <!-- end gallery thumbs -->

            </div> <!-- end col img slider -->

            <div class="col-md-6 col-xs-12 product-description-wrap">
                <ol class="breadcrumb">
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <li>
                        <a href="/products/{{$product->subcategory_id}}">{{$product->subcategory->nama_subcategory}}</a>
                    </li>
                    <li class="active">
                        Catalog
                    </li>
                </ol>
                <h1 class="product-title">{{$product->nama_barang}}</h1>
                <span class="price">
                    <ins>
                        <span class="amount">Rp. {{number_format($product->harga)}}</span>
                    </ins>
                </span>

                <p class="short-description">{{$product->description}}</p>

                <div class="color-swatches clearfix">
                    <span>Color:</span>
                    @php
                    $warna = explode(',', $product->warna)
                    @endphp

                    @foreach ($warna as $warna)
                    <a href="#" class="size-xs selected">{{$warna}}</a>
                    @endforeach
                </div>

                <div class="size-options clearfix">
                    <span>Size:</span>
                    @php
                        $sizes = explode(',', $product->ukuran)
                    @endphp

                    @foreach ($sizes as $size)
                    <a href="#" class="size-xs selected">{{$size}}</a>
                    @endforeach
                </div>

                <div class="product-actions">
                    <span>Qty:</span>

                    <div class="quantity buttons_added">
                        <input type="number" step="1" min="0" value="1" title="Qty" class="input-text qty text" />
                        <div class="quantity-adjust">
                            <a href="#" class="plus">
                                <i class="fa fa-angle-up"></i>
                            </a>
                            <a href="#" class="minus">
                                <i class="fa fa-angle-down"></i>
                            </a>
                        </div>
                    </div>

                    <a href="/cart" class="btn btn-dark btn-lg add-to-cart"><span>Add to Cart</span></a>

                    <a href="#" class="product-add-to-wishlist"><i class="fa fa-heart"></i></a>
                </div>


                <div class="product_meta">
                    <span class="sku">SKU: <a href="#">{{$product->sku}}</a></span>
                    <span class="brand_as">Category: <a href="#">{{$product->category->nama_kategory}}</a></span>
                    <span class="posted_in">Tags: <a href="#">{{$product->tags}}</a></span>
                </div>

                <!-- Accordion -->
                <div class="panel-group accordion mb-50" id="accordion">
                    <div class="panel">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                class="minus">Description<span>&nbsp;</span>
                            </a>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="panel-body">
                                {{$product->description}}.
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"
                                class="plus">Information<span>&nbsp;</span>
                            </a>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse">
                            <div class="panel-body">
                                <table class="table shop_attributes">
                                    <tbody>
                                        <tr>
                                            <th>Size:</th>
                                            <td>{{$product->ukuran}}</td>
                                        </tr>
                                        <tr>
                                            <th>Colors:</th>
                                            <td>{{$product->warna}}</td>
                                        </tr>
                                        <tr>
                                            <th>Fabric:</th>
                                            <td>{{$product->bahan}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="socials-share clearfix">
                    <span>Share:</span>
                    <div class="social-icons nobase">
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-google"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                    </div>
                </div>
            </div> <!-- end col product description -->
        </div> <!-- end row -->

    </div> <!-- end container -->
</section> <!-- end single product -->


<!-- Related Products -->
<section class="section-wrap pt-0 shop-items-slider">
    <div class="container">
        <div class="row heading-row">
            <div class="col-md-12 text-center">
                <h2 class="heading bottom-line">
                    Related Products
                </h2>
            </div>
        </div>

        <div class="row">

            <div id="owl-related-items" class="owl-carousel owl-theme">
                @foreach ($latestProduct as $latest)


                <div class="product">
                    <div class="product-item hover-trigger">
                        <div class="product-img">
                            <a href="/product/{{$latest->id}}">
                                <img src="/uploads/{{$latest->gambar}}" alt="">
                                <img src="/uploads/{{$latest->gambar}}" alt="" class="back-img">
                            </a>
                            <div class="product-label">
                                <span class="sale">sale</span>
                            </div>
                            <div class="hover-2">
                                <div class="product-actions">
                                    <a href="#" class="product-add-to-wishlist">
                                        <i class="fa fa-heart"></i>
                                    </a>
                                </div>
                            </div>
                            <a href="/product/{{$latest->id}}" class="product-quickview">More</a>
                        </div>
                        <div class="product-details">
                            <h3 class="product-title">
                                <a href="/product/{{$latest->id}}">{{$latest->nama_barang}}</a>
                            </h3>
                            <span class="category">
                                <a href="/products/{{$latest->subcategory_id}}">{{$latest->subcategory->nama_subcategory}}</a>
                            </span>
                        </div>
                        <span class="price">
                            <ins>
                                <span class="amount">Rp. {{number_format($latest->harga)}}</span>
                            </ins>
                        </span>
                    </div>
                </div>
                @endforeach
            </div> <!-- end slider -->

        </div>
    </div>
</section> <!-- end related products -->

@endsection
