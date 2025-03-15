<!DOCTYPE html>
<html lang="@lang('admin.lang')" >
<head>
    
    <title> @lang('admin.product') - {{$seoTitle}}  | {{ $DB_HomeSettings->title }} </title>
    
    <!------- Head --->
    @include('web.include.head')
    
</head>

<body>
    <div class="page-wrapper">
                       
        <!------- Header --->
        @include('web.include.header')

        <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                <div class="container d-flex align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/@lang('admin.lang')">@lang('admin.home')</a></li>
                        <li class="breadcrumb-item"><a href="/@lang('admin.lang')/product/category/{{$DB_Find->product_categories_uid}}-{{$DB_Find->seo_url}}">{{$DB_Find->product_categories_title}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$seoTitle}}</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
                <div class="container">
                    <div class="product-details-top">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="product-gallery product-gallery-vertical">
                                    <div class="row">
                                        <figure class="product-main-image">
                                            <img id="product_big" src="{{$DB_Find->img_url}}" alt="product image">
                                        </figure><!-- End .product-main-image -->

                                        <div id="product-zoom-gallery" class="product-image-gallery">
                                            
                                            <a class="product-gallery-item" style="cursor: pointer;" >
                                                <img src="{{$DB_Find->img_url}}" id="product_gallery" alt="product cross">
                                            </a>
                                           
                                        </div><!-- End .product-image-gallery -->
                                    </div><!-- End .row -->
                                </div><!-- End .product-gallery -->
                            </div><!-- End .col-md-6 -->

                            <div class="col-md-6">
                                <div class="product-details">
                                    <h1 class="product-title">{{$DB_Find->title}}</h1><!-- End .product-title -->

                                    <div class="product-price font-weight-bold align-items-center d-flex mb-0">
                                        @if($DB_Find->discounted_price_percent !="0")
                                        <h4 class="new-price font-weight-bold mb-0" style="color: green;" >{{$DB_Find->discounted_price}} {{$DB_Find->currency}}</h4>
                                        <h4 class="old-price font-weight-normal mb-0">{{$DB_Find->sale_price}} {{$DB_Find->currency}}</h4>
                                        @else<h4 class="new-price font-weight-bold mb-0" style="color: green;" >{{$DB_Find->sale_price}} {{$DB_Find->currency}}</h4>
                                        @endif
                                    </div>

                                    <div class="product-content">{!!$DB_Find->description!!}</div><!-- End .product-content -->
                                    
                                  

                                    <div class="product-details-action" style="display: flex;gap: 9px;" >
                                        <input type="number" id="product_quantity" class="form-control col-3 d-flex justify-content-center" value="1" min="1" max="10" step="1" data-decimals="0" style="margin: auto;background-color: white;border: 1px solid black;" >
                                       
                                       <!--- Sepet Ekleme Durumu -->
										<a id="userCartAdd_None" data_productid="{{$DB_Find->uid}}"  class="btn btn-product font-weight-normal text-uppercase text-truncate text-white btn-success" style="margin-top: 5px; display:{{$DB_Find->web_user_cart_control == 1  ? 'flex': 'none'}}; background-color: green;padding: 18px; font-size:15px;height: 15px;" > <i class="fas fa-check" style="font-size: 15px;" ></i> Sepete Eklendi </a>
										<a id="userCartAdd" data_productid="{{$DB_Find->uid}}" data_product_quantity="1" style="cursor: pointer; padding: 15px;margin-top: 5px; display:{{$DB_Find->web_user_cart_control == 0  ? 'flex': 'none'}}; height: 15px; " class="btn btn-product font-weight-normal text-uppercase text-truncate btn-cart btn-outline-primary-2">Sepete Ekle</a>
																																							
                                        <!--- İstek Listesine Ekleme Durumu -->
                                        <a id="userWishAdd_None" data_productid="{{$DB_Find->uid}}" style="color: green; display:{{$DB_Find->web_user_wish_control == 1  ? 'flex': 'none'}}; gap: 5px;align-items: center; " class="wishlist-link-product px-3 ml-0 font-weight-normal mt-1"><i class="fa fa-heart" style="font-size: 15px; color: green; " ></i><span>İstek Listesine Eklendi</span></a>
                                        <a id="userWishAdd" data_productid="{{$DB_Find->uid}}" data_product_quantity="1"  style="cursor: pointer;gap: 5px;align-items: center;display:{{$DB_Find->web_user_wish_control == 0  ? 'flex': 'none'}};" class="wishlist-link-product px-3 ml-0 font-weight-normal mt-1"><i data_productid="{{$DB_Find->uid}}" data_product_quantity="1" class="fa fa-heart-o"></i><span data_productid="{{$DB_Find->uid}}" data_product_quantity="1" >İstek Listesine Ekle</span></a>
                                        
                                    </div><!-- End .product-details-action -->

                                    <div class="wishlist-share">
                                        <div class="social-icons social-icons-sm mb-2">
                                            <label class="social-label">@lang('admin.share')</label>
                                            <a href="https://www.facebook.com/sharer.php?u={{ $DB_HomeSettings->siteUrl }}/@lang('admin.lang')/product/view/{{$DB_Find->uid}}-{{$DB_Find->seo_url}}" class="social-icon" title="Facebook" target="_blank"><i class="fa fa-facebook-f"></i></a>
                                            <a href="https://twitter.com/share?url={{ $DB_HomeSettings->siteUrl }}/@lang('admin.lang')/product/view/{{$DB_Find->uid}}-{{$DB_Find->seo_url}}" class="social-icon" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a>
                                            <a href="{{ $DB_HomeSettings->siteUrl }}/@lang('admin.lang')/product/view/{{$DB_Find->uid}}-{{$DB_Find->seo_url}}" class="social-icon" title="Whatsapp" target="_blank"><i class="fa fa-whatsapp"></i></a>
                                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $DB_HomeSettings->siteUrl }}/@lang('admin.lang')/product/view/{{$DB_Find->uid}}-{{$DB_Find->seo_url}}" class="social-icon" title="Linkedin" target="_blank"><i class="fa fa-linkedin"></i></a>
                                        </div><!-- End .soial-icons -->
                                    </div><!-- End .wishlist-share -->

                                   
                                </div><!-- End .product-details -->
                            </div><!-- End .col-md-6 -->
                        </div><!-- End .row -->
                    </div><!-- End .product-details-top -->
                    
                   

                    <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                        data-owl-options='{
                            "nav": false, 
                            "dots": true,
                            "margin": 20,
                            "loop": false,
                            "responsive": {
                                "0": {
                                    "items":1
                                },
                                "480": {
                                    "items":2
                                },
                                "768": {
                                    "items":3
                                },
                                "992": {
                                    "items":4
                                },
                                "1200": {
                                    "items":4,
                                    "nav": true,
                                    "dots": false
                                }
                            }
                        }'>
                        <div class="product product-7 text-center">
                            <figure class="product-media">
                                <span class="product-label label-new">New</span>
                                <a href="product.html">
                                    <img src="{{asset('/assets')}}/web/images/products/product-4.jpg" alt="Product image" class="product-image">
                                </a>

                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
                                    <a href="popup/quickView.html" class="btn-product-icon btn-quickview" title="Quick view"><span>Quick view</span></a>
                                    <a href="#" class="btn-product-icon btn-compare" title="Compare"><span>Compare</span></a>
                                </div><!-- End .product-action-vertical -->

                                <div class="product-action">
                                    <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                                </div><!-- End .product-action -->
                            </figure><!-- End .product-media -->

                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="#">Women</a>
                                </div><!-- End .product-cat -->
                                <h3 class="product-title"><a href="product.html">Brown paperbag waist <br>pencil skirt</a></h3><!-- End .product-title -->
                                <div class="product-price">
                                    $60.00
                                </div><!-- End .product-price -->
                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 20%;"></div><!-- End .ratings-val -->
                                    </div><!-- End .ratings -->
                                    <span class="ratings-text">( 2 Reviews )</span>
                                </div><!-- End .rating-container -->

                                <div class="product-nav product-nav-thumbs">
                                    <a href="#" class="active">
                                        <img src="{{asset('/assets')}}/web/images/products/product-4-thumb.jpg" alt="product desc">
                                    </a>
                                    <a href="#">
                                        <img src="{{asset('/assets')}}/web/images/products/product-4-2-thumb.jpg" alt="product desc">
                                    </a>

                                    <a href="#">
                                        <img src="{{asset('/assets')}}/web/images/products/product-4-3-thumb.jpg" alt="product desc">
                                    </a>
                                </div><!-- End .product-nav -->
                            </div><!-- End .product-body -->
                        </div><!-- End .product -->

                        <div class="product product-7 text-center">
                            <figure class="product-media">
                                <span class="product-label label-out">Out of Stock</span>
                                <a href="product.html">
                                    <img src="{{asset('/assets')}}/web/images/products/product-6.jpg" alt="Product image" class="product-image">
                                </a>

                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
                                    <a href="popup/quickView.html" class="btn-product-icon btn-quickview" title="Quick view"><span>Quick view</span></a>
                                    <a href="#" class="btn-product-icon btn-compare" title="Compare"><span>Compare</span></a>
                                </div><!-- End .product-action-vertical -->

                                <div class="product-action">
                                    <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                                </div><!-- End .product-action -->
                            </figure><!-- End .product-media -->

                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="#">Jackets</a>
                                </div><!-- End .product-cat -->
                                <h3 class="product-title"><a href="product.html">Khaki utility boiler jumpsuit</a></h3><!-- End .product-title -->
                                <div class="product-price">
                                    <span class="out-price">$120.00</span>
                                </div><!-- End .product-price -->
                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 80%;"></div><!-- End .ratings-val -->
                                    </div><!-- End .ratings -->
                                    <span class="ratings-text">( 6 Reviews )</span>
                                </div><!-- End .rating-container -->
                            </div><!-- End .product-body -->
                        </div><!-- End .product -->

                        <div class="product product-7 text-center">
                            <figure class="product-media">
                                <span class="product-label label-top">Top</span>
                                <a href="product.html">
                                    <img src="{{asset('/assets')}}/web/images/products/product-11.jpg" alt="Product image" class="product-image">
                                </a>

                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
                                    <a href="popup/quickView.html" class="btn-product-icon btn-quickview" title="Quick view"><span>Quick view</span></a>
                                    <a href="#" class="btn-product-icon btn-compare" title="Compare"><span>Compare</span></a>
                                </div><!-- End .product-action-vertical -->

                                <div class="product-action">
                                    <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                                </div><!-- End .product-action -->
                            </figure><!-- End .product-media -->

                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="#">Shoes</a>
                                </div><!-- End .product-cat -->
                                <h3 class="product-title"><a href="product.html">Light brown studded Wide fit wedges</a></h3><!-- End .product-title -->
                                <div class="product-price">
                                    $110.00
                                </div><!-- End .product-price -->
                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 80%;"></div><!-- End .ratings-val -->
                                    </div><!-- End .ratings -->
                                    <span class="ratings-text">( 1 Reviews )</span>
                                </div><!-- End .rating-container -->

                                <div class="product-nav product-nav-thumbs">
                                    <a href="#" class="active">
                                        <img src="{{asset('/assets')}}/web/images/products/product-11-thumb.jpg" alt="product desc">
                                    </a>
                                    <a href="#">
                                        <img src="{{asset('/assets')}}/web/images/products/product-11-2-thumb.jpg" alt="product desc">
                                    </a>

                                    <a href="#">
                                        <img src="{{asset('/assets')}}/web/images/products/product-11-3-thumb.jpg" alt="product desc">
                                    </a>
                                </div><!-- End .product-nav -->
                            </div><!-- End .product-body -->
                        </div><!-- End .product -->

                        <div class="product product-7 text-center">
                            <figure class="product-media">
                                <a href="product.html">
                                    <img src="{{asset('/assets')}}/web/images/products/product-10.jpg" alt="Product image" class="product-image">
                                </a>

                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
                                    <a href="popup/quickView.html" class="btn-product-icon btn-quickview" title="Quick view"><span>Quick view</span></a>
                                    <a href="#" class="btn-product-icon btn-compare" title="Compare"><span>Compare</span></a>
                                </div><!-- End .product-action-vertical -->

                                <div class="product-action">
                                    <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                                </div><!-- End .product-action -->
                            </figure><!-- End .product-media -->

                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="#">Jumpers</a>
                                </div><!-- End .product-cat -->
                                <h3 class="product-title"><a href="product.html">Yellow button front tea top</a></h3><!-- End .product-title -->
                                <div class="product-price">
                                    $56.00
                                </div><!-- End .product-price -->
                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 0%;"></div><!-- End .ratings-val -->
                                    </div><!-- End .ratings -->
                                    <span class="ratings-text">( 0 Reviews )</span>
                                </div><!-- End .rating-container -->
                            </div><!-- End .product-body -->
                        </div><!-- End .product -->

                        <div class="product product-7 text-center">
                            <figure class="product-media">
                                <a href="product.html">
                                    <img src="{{asset('/assets')}}/web/images/products/product-7.jpg" alt="Product image" class="product-image">
                                </a>

                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
                                    <a href="popup/quickView.html" class="btn-product-icon btn-quickview" title="Quick view"><span>Quick view</span></a>
                                    <a href="#" class="btn-product-icon btn-compare" title="Compare"><span>Compare</span></a>
                                </div><!-- End .product-action-vertical -->

                                <div class="product-action">
                                    <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                                </div><!-- End .product-action -->
                            </figure><!-- End .product-media -->

                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="#">Jeans</a>
                                </div><!-- End .product-cat -->
                                <h3 class="product-title"><a href="product.html">Blue utility pinafore denim dress</a></h3><!-- End .product-title -->
                                <div class="product-price">
                                    $76.00
                                </div><!-- End .product-price -->
                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 20%;"></div><!-- End .ratings-val -->
                                    </div><!-- End .ratings -->
                                    <span class="ratings-text">( 2 Reviews )</span>
                                </div><!-- End .rating-container -->
                            </div><!-- End .product-body -->
                        </div><!-- End .product -->
                    </div><!-- End .owl-carousel -->

                </div><!-- End .container -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->

        <footer class="footer">
        	<div class="footer-middle">
	                         
                <!------- Footer - Container --->
                @include('web.include.footer-container')

	        </div><!-- End .footer-middle -->

	        <div class="footer-bottom">
	        	<div class="container">
	        		                                    
                    <!------- Footer - Copyright --->
                    @include('web.include.footer-copyright')
                    
	        	</div><!-- End .container -->
	        </div><!-- End .footer-bottom -->
        </footer><!-- End .footer -->
    </div><!-- End .page-wrapper -->

    <!------- Footer - Bottom --->
    @include('web.include.footer-bottom')
    
    <!------- JS --->
    <script src="{{asset('/assets/web')}}/js/product/product_actions_web.js"></script>

</body>

</html>