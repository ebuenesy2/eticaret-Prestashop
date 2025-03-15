<!DOCTYPE html>
<html lang="UTF-8">

<head>

    <title> @lang('admin.home') | {{ $DB_HomeSettings->title }} </title>

    <!------- Head --->
    @include('web.include.head')

    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{asset('/assets')}}/web/css/style.css">
    <link rel="stylesheet" href="{{asset('/assets')}}/web/css/plugins/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="{{asset('/assets')}}/web/css/plugins/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="{{asset('/assets')}}/web/css/plugins/nouislider/nouislider.css">

    <script>
        WebFontConfig = {
            google: { families: [ 'Poppins:200,400,500,600,700' ] }
        };
        (function(d) {
            var wf = d.createElement('script'), s = d.scripts[0];
            wf.src = '{{asset('/assets')}}/web/js/webfont.js';
            wf.async = true;
            s.parentNode.insertBefore(wf, s);
        })(document);
    </script>
    
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{asset('/assets')}}/web/css/plugins/jquery.countdown.css">
   
    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{asset('/assets')}}/web/css/skins/skin-demo-28.css">
    <link rel="stylesheet" href="{{asset('/assets')}}/web/css/demos/demo-28.css">
    <link rel="stylesheet" href="{{asset('/assets')}}/web/css/demos/carousel-layout.css">

</head>
<body>
    <div class="page-wrapper">
        <header class="header header-28 bg-transparent">
            <div class="header-top font-weight-normal text-light">

                <!------- Header - Top --->
                @include('web.include.header-top')

            </div>
            <div class="sticky-wrapper">
                <div class="header-middle sticky-header">
                       
                    <!------- Header - Menu List --->
                    @include('web.include.header-menu-list')

                </div>
            </div>
        </header>
        <main class="main">
            <div class="page-content">
                <div class="intro-section bg-image" style="background-image: url({{asset('/assets')}}/web/images/demos/demo-28/background.jpg);">
                    <div class="container">
                        <div class="owl-carousel inner-carousel owl-simple rows cols-1" data-toggle="owl" data-owl-options='{"nav": false, "dots": true, "loop": true}'>
                            
                            @for ($i = 0; $i < count($DB_Slider); $i++)
                            <div class="intro-slide" style="background-image: url({{$DB_Slider[$i]->img_url}}); background-color: #2a323e; background-size: cover; ">
                                <div class="intro-content intro-content-left">
                                    <h6 class="font-weight-normal text-primary my-2 mt-0">{{$DB_Slider[$i]->title}}</h6>
                                    <h3 class="intro-title font-weight-bold text-white mb-0">{{$DB_Slider[$i]->title2}}</h3>
                                    <h3 class="intro-desc mb-2 font-weight-light text-secondary">{!!$DB_Slider[$i]->description!!}</h3>
                                    
                                    @if($DB_Slider[$i]->url !="" )
                                    <a href="{{$DB_Slider[$i]->url}}" class="btn btn-primary text-uppercase">{{$DB_Slider[$i]->url}}</a>
                                    @endif
                                </div>
                            </div>
                            @endfor

                        </div>
                    </div>
                </div>
                   
                <!--- Kategoriler -->
                <div class="container">
                    <hr class="m-0">
                    <div class="cat-section mt-4 mb-3">
                        <div class="row">

                            @for ($i = 0; $i < count($DB_product_categories); $i++)
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-8col">
                                <div class="cat bg-white pt-1 mb-2">
                                    <div class="cat-image d-flex justify-content-center align-items-center">
                                        <a href="/@lang('admin.lang')/product/category/{{$DB_product_categories[$i]->uid}}-{{$DB_product_categories[$i]->seo_url}}"><img src="{{$DB_product_categories[$i]->img_url}}" width="137" height="137"></a>
                                    </div>
                                    <div class="cat-content text-center">
                                        <a href="/@lang('admin.lang')/product/category/{{$DB_product_categories[$i]->uid}}-{{$DB_product_categories[$i]->seo_url}}" class="cat-title">{{$DB_product_categories[$i]->title}}</a>
                                    </div>
                                </div>
                            </div>
                            @endfor
                            
                        </div>
                    </div>
                </div>
                <!--- Kategoriler Son -->

                <hr>

                <!--- EDİTÖRÜN ÖNERİSİ -->
                <div class="flash-section bg-lighter">
                    <div class="container">
                        <div class="heading d-flex flex-column flex-md-row" style="display: flex;justify-content: space-between;" >
                            <h2 class="title align-self-center letter-spacing-normal text-center text-md-left">@lang('admin.editorSuggestion')</h2>
                            <a href="/{lang}/product/list/editor/suggestion">Tümü Göster</a>
                        </div>
                        <div class="flash-content mt-2 py-2 pb-7">
                            <div style="overflow-y: hidden;overflow-x: hidden;padding-bottom: 22px;" class="owl-carousel carousel-equal-height owl-simple rows cols-2 cols-md-3 cols-lg-4 cols-xl-6" data-toggle="owl" data-owl-options='{
                                "nav": true,
                                "dots": true,
                                "loop": false   ,
                                "margin": 0,
                                "responsive": {
                                    "0": {
                                        "items":2
                                    },
                                    "768": {
                                        "items":3
                                    },
                                    "992": {
                                        "items":4
                                    },
                                    "1200": {
                                        "items":6
                                    }
                                }
                            }'>
                                @for ($i = 0; $i < count($DB_Products_Editor_Suggestion); $i++)
                                <div class="product mb-0 rounded-0 w-100" style="border: 1px solid #ebebeb;" >
                                    <figure class="product-media bg-white " style="display: flex;justify-content: center;" >
                                        <a href="/@lang('admin.lang')/product/view/{{$DB_Products_Editor_Suggestion[$i]->uid}}-{{$DB_Products_Editor_Suggestion[$i]->seo_url}}">
                                            @if($DB_Products_Editor_Suggestion[$i]->discounted_price_percent !="0")<span class="product-label label-sale" style="margin-top: -40px;" >@lang('admin.discount'): {{$DB_Products_Editor_Suggestion[$i]->discounted_price_percent}}%</span> @endif
                                            <img src="{{$DB_Products_Editor_Suggestion[$i]->img_url}}" style="width: 170px;height: 170px;object-fit: contain;" >
                                        </a>
                                    </figure>
                                    <div class="product-body position-static bg-transparent">
                                        <div class="product-cat overflow-hidden my-2 mt-0 font-weight-normal">
                                            <a href="/@lang('admin.lang')/product/category/{{$DB_Products_Editor_Suggestion[$i]->product_categories_uid}}-{{$DB_Products_Editor_Suggestion[$i]->product_categories_seo_url}}">{{$DB_Products_Editor_Suggestion[$i]->product_categories_title}}</a>
                                        </div>
                                        <a href="/@lang('admin.lang')/product/view/{{$DB_Products_Editor_Suggestion[$i]->uid}}-{{$DB_Products_Editor_Suggestion[$i]->seo_url}}"><h3 class="product-title overflow-hidden letter-spacing-normal">{{$DB_Products_Editor_Suggestion[$i]->title}}</h3></a>
                                        <div class="product-price font-weight-bold align-items-center d-flex mb-0">
                                            @if($DB_Products_Editor_Suggestion[$i]->discounted_price_percent !="0")
                                            <h4 class="new-price font-weight-bold mb-0" style="color: green;" >{{$DB_Products_Editor_Suggestion[$i]->discounted_price}} {{$DB_Products_Editor_Suggestion[$i]->currency}}</h4>
                                            <h4 class="old-price font-weight-normal mb-0">{{$DB_Products_Editor_Suggestion[$i]->sale_price}} {{$DB_Products_Editor_Suggestion[$i]->currency}}</h4>
                                            @else<h4 class="new-price font-weight-bold mb-0" style="color: green;" >{{$DB_Products_Editor_Suggestion[$i]->sale_price}} {{$DB_Products_Editor_Suggestion[$i]->currency}}</h4>
                                            @endif
                                        </div>
                                        <div class="product-footer bg-white rounded-0 d-block position-absolute">
                                            <div class="product-action d-flex justify-content-center flex-column align-items-center position-relative">
                                                
                                                <!--- Sepet Ekleme Durumu -->
                                                <a id="userCartAdd_None" data_productid="{{$DB_Products_Editor_Suggestion[$i]->uid}}" style="display:{{$DB_Products_Editor_Suggestion[$i]->web_user_cart_control == 1  ? 'flex': 'none'}};"  class="btn btn-product font-weight-normal text-uppercase text-truncate text-white btn-success"> <i class="fas fa-check" style="font-size: 15px;" ></i> Sepete Eklendi </a>
                                                <a id="userCartAdd" data_productid="{{$DB_Products_Editor_Suggestion[$i]->uid}}" data_product_quantity="1" style="cursor: pointer; display:{{$DB_Products_Editor_Suggestion[$i]->web_user_cart_control == 0  ? 'flex': 'none'}};" class="btn btn-product font-weight-normal text-uppercase text-truncate btn-cart btn-outline-primary-2">Sepete Ekle</a>
                                                
                                                
                                                <!--- İstek Listesine Ekleme Durumu -->
                                                <a id="userWishAdd_None" data_productid="{{$DB_Products_Editor_Suggestion[$i]->uid}}" style="color: green; display:{{$DB_Products_Editor_Suggestion[$i]->web_user_wish_control == 1  ? 'flex': 'none'}}; " class="wishlist-link-product px-3 ml-0 font-weight-normal mt-1"><i class="fa fa-heart" style="font-size: 15px; color: green; " ></i><span>İstek Listesine Eklendi</span></a>
                                                <a id="userWishAdd" data_productid="{{$DB_Products_Editor_Suggestion[$i]->uid}}" data_product_quantity="1"  style="cursor: pointer; display:{{$DB_Products_Editor_Suggestion[$i]->web_user_wish_control == 0  ? 'flex': 'none'}};" class="wishlist-link-product px-3 ml-0 font-weight-normal mt-1"><i data_productid="{{$DB_Products_Editor_Suggestion[$i]->uid}}" data_product_quantity="1" class="fa fa-heart-o"></i><span data_productid="{{$DB_Products_Editor_Suggestion[$i]->uid}}" data_product_quantity="1" >İstek Listesine Ekle</span></a>
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endfor

                            </div>
                        </div>
                    </div>
                </div>
                <!--- EDİTÖRÜN ÖNERİSİ Son -->
                
                <hr>
                
                <!--- ÇOK SATANLAR -->
                <div class="flash-section bg-lighter">
                    <div class="container">
                        <div class="heading d-flex flex-column flex-md-row" style="display: flex;justify-content: space-between;" >
                            <h2 class="title align-self-center letter-spacing-normal text-center text-md-left">ÇOK SATANLAR</h2>
                            <a href="/@lang('admin.lang')/product/list/bestseller">Tümü Göster</a>
                        </div>
                        <div class="flash-content mt-2 py-2 pb-7">
                            <div style="overflow-y: hidden;overflow-x: hidden;padding-bottom: 22px;" class="owl-carousel carousel-equal-height owl-simple rows cols-2 cols-md-3 cols-lg-4 cols-xl-6" data-toggle="owl" data-owl-options='{
                                "nav": true,
                                "dots": true,
                                "loop": false   ,
                                "margin": 0,
                                "responsive": {
                                    "0": {
                                        "items":2
                                    },
                                    "768": {
                                        "items":3
                                    },
                                    "992": {
                                        "items":4
                                    },
                                    "1200": {
                                        "items":6
                                    }
                                }
                            }'>
                                @for ($i = 0; $i < count($DB_Products_bestseller); $i++)
                                <div class="product mb-0 rounded-0 w-100" style="border: 1px solid #ebebeb;" >
                                    <figure class="product-media bg-white " style="display: flex;justify-content: center;" >
                                        <a href="/@lang('admin.lang')/product/view/{{$DB_Products_bestseller[$i]->uid}}-{{$DB_Products_bestseller[$i]->seo_url}}">
                                            @if($DB_Products_bestseller[$i]->discounted_price_percent !="0")<span class="product-label label-sale" style="margin-top: -40px;" >@lang('admin.discount'): {{$DB_Products_bestseller[$i]->discounted_price_percent}}%</span> @endif
                                            <img src="{{$DB_Products_bestseller[$i]->img_url}}" style="width: 170px;height: 170px;object-fit: contain;" >
                                        </a>
                                    </figure>
                                    <div class="product-body position-static bg-transparent">
                                        <div class="product-cat overflow-hidden my-2 mt-0 font-weight-normal">
                                            <a href="/@lang('admin.lang')/product/category/{{$DB_Products_bestseller[$i]->product_categories_uid}}-{{$DB_Products_bestseller[$i]->product_categories_seo_url}}">{{$DB_Products_bestseller[$i]->product_categories_title}}</a>
                                        </div>
                                        <a href="/@lang('admin.lang')/product/view/{{$DB_Products_bestseller[$i]->uid}}-{{$DB_Products_bestseller[$i]->seo_url}}"><h3 class="product-title overflow-hidden letter-spacing-normal">{{$DB_Products_bestseller[$i]->title}}</h3></a>
                                        <div class="product-price font-weight-bold align-items-center d-flex mb-0">
                                            @if($DB_Products_bestseller[$i]->discounted_price_percent !="0")
                                            <h4 class="new-price font-weight-bold mb-0" style="color: green;" >{{$DB_Products_bestseller[$i]->discounted_price}} {{$DB_Products_bestseller[$i]->currency}}</h4>
                                            <h4 class="old-price font-weight-normal mb-0">{{$DB_Products_bestseller[$i]->sale_price}} {{$DB_Products_bestseller[$i]->currency}}</h4>
                                            @else<h4 class="new-price font-weight-bold mb-0" style="color: green;" >{{$DB_Products_bestseller[$i]->sale_price}} {{$DB_Products_bestseller[$i]->currency}}</h4>
                                            @endif
                                        </div>
                                        <div class="product-footer bg-white rounded-0 d-block position-absolute">
                                            <div class="product-action d-flex justify-content-center flex-column align-items-center position-relative">
                                                
                                                <!--- Sepet Ekleme Durumu -->
                                                <a id="userCartAdd_None" data_productid="{{$DB_Products_bestseller[$i]->uid}}" style="display:{{$DB_Products_bestseller[$i]->web_user_cart_control == 1  ? 'flex': 'none'}};"  class="btn btn-product font-weight-normal text-uppercase text-truncate text-white btn-success"> <i class="fas fa-check" style="font-size: 15px;" ></i> Sepete Eklendi </a>
                                                <a id="userCartAdd" data_productid="{{$DB_Products_bestseller[$i]->uid}}" data_product_quantity="1" style="cursor: pointer; display:{{$DB_Products_bestseller[$i]->web_user_cart_control == 0  ? 'flex': 'none'}};" class="btn btn-product font-weight-normal text-uppercase text-truncate btn-cart btn-outline-primary-2">Sepete Ekle</a>
                                                
                                                
                                                <!--- İstek Listesine Ekleme Durumu -->
                                                <a id="userWishAdd_None" data_productid="{{$DB_Products_bestseller[$i]->uid}}" style="color: green; display:{{$DB_Products_bestseller[$i]->web_user_wish_control == 1  ? 'flex': 'none'}}; " class="wishlist-link-product px-3 ml-0 font-weight-normal mt-1"><i class="fa fa-heart" style="font-size: 15px; color: green; " ></i><span>İstek Listesine Eklendi</span></a>
                                                <a id="userWishAdd" data_productid="{{$DB_Products_bestseller[$i]->uid}}" data_product_quantity="1"  style="cursor: pointer; display:{{$DB_Products_bestseller[$i]->web_user_wish_control == 0  ? 'flex': 'none'}};" class="wishlist-link-product px-3 ml-0 font-weight-normal mt-1"><i data_productid="{{$DB_Products_bestseller[$i]->uid}}" data_product_quantity="1" class="fa fa-heart-o"></i><span data_productid="{{$DB_Products_bestseller[$i]->uid}}" data_product_quantity="1" >İstek Listesine Ekle</span></a>
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endfor

                            </div>
                        </div>
                    </div>
                </div>
                <!--- ÇOK SATANLAR Son -->

                <hr>
                
                <!--- YENİ ÇIKANLAR -->
                <div class="flash-section bg-lighter">
                    <div class="container">
                        <div class="heading d-flex flex-column flex-md-row" style="display: flex;justify-content: space-between;" >
                            <h2 class="title align-self-center letter-spacing-normal text-center text-md-left">Yeni Ürünler</h2>
                            <a href="/@lang('admin.lang')/product/list/new">Tümü Göster</a>
                        </div>
                        <div class="flash-content mt-2 py-2 pb-7">
                            <div style="overflow-y: hidden;overflow-x: hidden;padding-bottom: 22px;" class="owl-carousel carousel-equal-height owl-simple rows cols-2 cols-md-3 cols-lg-4 cols-xl-6" data-toggle="owl" data-owl-options='{
                                "nav": true,
                                "dots": true,
                                "loop": false   ,
                                "margin": 0,
                                "responsive": {
                                    "0": {
                                        "items":2
                                    },
                                    "768": {
                                        "items":3
                                    },
                                    "992": {
                                        "items":4
                                    },
                                    "1200": {
                                        "items":6
                                    }
                                }
                            }'>
                                @for ($i = 0; $i < count($DB_Products_new); $i++)
                                <div class="product mb-0 rounded-0 w-100" style="border: 1px solid #ebebeb;" >
                                    <figure class="product-media bg-white " style="display: flex;justify-content: center;" >
                                        <a href="/@lang('admin.lang')/product/view/{{$DB_Products_new[$i]->uid}}-{{$DB_Products_new[$i]->seo_url}}">
                                            @if($DB_Products_new[$i]->discounted_price_percent !="0")<span class="product-label label-sale" style="margin-top: -40px;" >@lang('admin.discount'): {{$DB_Products_new[$i]->discounted_price_percent}}%</span> @endif
                                            <img src="{{$DB_Products_new[$i]->img_url}}" style="width: 170px;height: 170px;object-fit: contain;" >
                                        </a>
                                    </figure>
                                    <div class="product-body position-static bg-transparent">
                                        <div class="product-cat overflow-hidden my-2 mt-0 font-weight-normal">
                                            <a href="/@lang('admin.lang')/product/category/{{$DB_Products_new[$i]->product_categories_uid}}-{{$DB_Products_new[$i]->product_categories_seo_url}}">{{$DB_Products_new[$i]->product_categories_title}}</a>
                                        </div>
                                        <a href="/@lang('admin.lang')/product/view/{{$DB_Products_new[$i]->uid}}-{{$DB_Products_new[$i]->seo_url}}"><h3 class="product-title overflow-hidden letter-spacing-normal">{{$DB_Products_new[$i]->title}}</h3></a>
                                        <div class="product-price font-weight-bold align-items-center d-flex mb-0">
                                            @if($DB_Products_new[$i]->discounted_price_percent !="0")
                                            <h4 class="new-price font-weight-bold mb-0" style="color: green;" >{{$DB_Products_new[$i]->discounted_price}} {{$DB_Products_new[$i]->currency}}</h4>
                                            <h4 class="old-price font-weight-normal mb-0">{{$DB_Products_new[$i]->sale_price}} {{$DB_Products_new[$i]->currency}}</h4>
                                            @else<h4 class="new-price font-weight-bold mb-0" style="color: green;" >{{$DB_Products_new[$i]->sale_price}} {{$DB_Products_new[$i]->currency}}</h4>
                                            @endif
                                        </div>
                                        <div class="product-footer bg-white rounded-0 d-block position-absolute">
                                            <div class="product-action d-flex justify-content-center flex-column align-items-center position-relative">
                                                
                                                <!--- Sepet Ekleme Durumu -->
                                                <a id="userCartAdd_None" data_productid="{{$DB_Products_new[$i]->uid}}" style="display:{{$DB_Products_new[$i]->web_user_cart_control == 1  ? 'flex': 'none'}};"  class="btn btn-product font-weight-normal text-uppercase text-truncate text-white btn-success"> <i class="fas fa-check" style="font-size: 15px;" ></i> Sepete Eklendi </a>
                                                <a id="userCartAdd" data_productid="{{$DB_Products_new[$i]->uid}}" data_product_quantity="1" style="cursor: pointer; display:{{$DB_Products_new[$i]->web_user_cart_control == 0  ? 'flex': 'none'}};" class="btn btn-product font-weight-normal text-uppercase text-truncate btn-cart btn-outline-primary-2">Sepete Ekle</a>
                                                                                                
                                                <!--- İstek Listesine Ekleme Durumu -->
                                                <a id="userWishAdd_None" data_productid="{{$DB_Products_new[$i]->uid}}" style="color: green; display:{{$DB_Products_new[$i]->web_user_wish_control == 1  ? 'flex': 'none'}}; " class="wishlist-link-product px-3 ml-0 font-weight-normal mt-1"><i class="fa fa-heart" style="font-size: 15px; color: green; " ></i><span>İstek Listesine Eklendi</span></a>
                                                <a id="userWishAdd" data_productid="{{$DB_Products_new[$i]->uid}}" data_product_quantity="1"  style="cursor: pointer; display:{{$DB_Products_new[$i]->web_user_wish_control == 0  ? 'flex': 'none'}};" class="wishlist-link-product px-3 ml-0 font-weight-normal mt-1"><i data_productid="{{$DB_Products_new[$i]->uid}}" data_product_quantity="1" class="fa fa-heart-o"></i><span data_productid="{{$DB_Products_new[$i]->uid}}" data_product_quantity="1" >İstek Listesine Ekle</span></a>
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endfor

                            </div>
                        </div>
                    </div>
                </div>
                <!--- YENİ ÇIKANLAR Son -->
                
            </div>
        </main>
        <footer class="footer footer-2 font-weight-normal second-primary-color" style="background-color: #222">
            <div class="footer-middle border-0">
              	                         
                <!------- Footer - Container --->
                @include('web.include.footer-container')

            </div><!-- End .footer-middle -->

            <div class="footer-bottom font-weight-normal">
                <div class="container">
                    
                    <!------- Footer - Copyright --->
                    @include('web.include.footer-copyright')

                </div>
            </div>

        </footer><!-- End .footer -->
    </div>
              
    <!------- Footer - Bottom --->
    @include('web.include.footer-bottom')

    <script src="{{asset('/assets')}}/web/js/jquery.min.js"></script>
    <script src="{{asset('/assets')}}/web/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('/assets')}}/web/js/jquery.hoverIntent.min.js"></script>
    <script src="{{asset('/assets')}}/web/js/jquery.waypoints.min.js"></script>
    <script src="{{asset('/assets')}}/web/js/superfish.min.js"></script>
    <script src="{{asset('/assets')}}/web/js/owl.carousel.min.js"></script>
    <script src="{{asset('/assets')}}/web/js/bootstrap-input-spinner.js"></script>
    <script src="{{asset('/assets')}}/web/js/jquery.plugin.min.js"></script>
    <script src="{{asset('/assets')}}/web/js/jquery.countdown.min.js"></script>
    <script src="{{asset('/assets')}}/web/js/jquery.magnific-popup.min.js"></script>

    <script src="{{asset('/assets')}}/web/js/main.js"></script>
    <script src="{{asset('/assets')}}/web/js/demos/demo-2.js"></script>

</body>

</html>