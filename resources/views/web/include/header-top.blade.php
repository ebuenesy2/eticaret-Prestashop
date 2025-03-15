<div class="container">
    <div class="header-left">
        <div class="header-dropdown">
            <a>TL</a>
            <div class="header-menu">
                <ul>
                    <li><a href="/@lang('admin.lang')">TL</a></li>
                </ul>
            </div>
        </div>
        <div class="header-dropdown">
            <a>@lang('admin.langTitle')</a>
            <div class="header-menu">
                <ul>
                    <li><a href="/tr">Türkçe</a></li>
                    <li><a href="/en">English</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="header-right">
        <ul class="top-menu">
            <li>
                <a class="link">Links</a>
                <ul>
                    <li><a href="tel:{{ $DB_HomeSettings->phone }}" class="ff"><i class="fa fa-phone"></i>Ara: {{ $DB_HomeSettings->phone }}</a></li>
                    <li><a href="#">Sipariş Takip</a></li>
                    <li><a href="/@lang('admin.lang')/contact">İletişim</a></li>
                    
                    <!-- Kullanıcı -->
                    @if(isset($_COOKIE["web_userId"])) 
                    <li><a href="/@lang('admin.lang')/user/profile"><i class="fa fa-user"></i>Profil Sayfası </a></li>
                    <li><a href="/@lang('admin.lang')/user/logout"><i class="fa fa-user"></i>Çıkış </a></li>

                    <li>
                        <a href="/@lang('admin.lang')/user/wishlist" class="wishlist-link">
                            <div class="icon position-relative">
                                <i class="fas fa-heart" style="font-size: 15px;" ></i>
                                <span class="wishlist-count">{{$DB_web_user_wish_count}}</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown cart-dropdown">
                            <a class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                <div class="icon position-relative">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span class="cart-count">{{$productsCount}}</span>
                                </div>
                                <span class="cart-txt font-weight-normal" style="font-size: 15px;" >{{$productsAllTotalPrice}} {{$productsCurrency}}</span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-cart-products">

                                    @for ($i = 0; $i < count($DB_web_user_cart); $i++)
                                    <div class="product mb-0 rounded-0 w-100">
                                        <div class="product-cart-details">
                                            <h4 class="product-title overflow-hidden letter-spacing-normal">
                                                <a href="/@lang('admin.lang')/product/view/{{$DB_web_user_cart[$i]->productsUid}}-{{$DB_web_user_cart[$i]->productsSeo_url}}">{{$DB_web_user_cart[$i]->productsTitle}}</a>
                                            </h4>

                                            <span class="cart-product-info">
                                                <span class="cart-product-qty">{{$DB_web_user_cart[$i]->product_quantity}}</span>
                                                x {{$DB_web_user_cart[$i]->productsPrice}} {{$DB_web_user_cart[$i]->productsCurrency}}
                                            </span>
                                        </div><!-- End .product-cart-details -->

                                        <figure class="product-image-container">
                                            <a href="/@lang('admin.lang')/product/view/{{$DB_web_user_cart[$i]->productsUid}}-{{$DB_web_user_cart[$i]->productsSeo_url}}" class="product-image">
                                                <img src="{{$DB_web_user_cart[$i]->productsImg}}" alt="product mb-0 rounded-0 w-100">
                                            </a>
                                        </figure>
                                        <a class="btn-remove" title="Remove Product" id="userCartDelete" data_id="{{$DB_web_user_cart[$i]->id}}" data_productstitle="{{$DB_web_user_cart[$i]->productsTitle}}" ><i data_id="{{$DB_web_user_cart[$i]->id}}" data_productstitle="{{$DB_web_user_cart[$i]->productsTitle}}" class="fa fa-close" style="color: red; cursor:pointer;" ></i></a>
                                    </div><!-- End .product -->
                                    @endfor

                                </div><!-- End .cart-product -->

                                <div class="dropdown-cart-total">
                                    <span>Total</span>

                                    <span class="cart-total-price">{{$productsAllTotalPrice}} {{$productsCurrency}}</span>
                                </div><!-- End .dropdown-cart-total -->

                                <div class="dropdown-cart-action">
                                    <a href="/@lang('admin.lang')/user/cart" class="btn btn-primary">@lang('admin.myCart')</a>
                                    <a href="{{asset('/assets')}}/web/checkout.html" class="btn btn-outline-primary-2"><span>Checkout</span><i class="fa fa-long-arrow-right"></i></a>
                                </div><!-- End .dropdown-cart-total -->
                            </div><!-- End .dropdown-menu -->
                        </div><!-- End .cart-dropdown -->
                    </li>

                    @else
                    <li><a href="/@lang('admin.lang')/user/login"><i class="fa fa-user"></i>Giriş / Kayıt Sayfası </a></li>
                    @endif
                    <!-- Kullanıcı Son -->
                    
                  
                </ul>
            </li>
        </ul>
    </div>
</div>