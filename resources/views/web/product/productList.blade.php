<!DOCTYPE html>
<html lang="@lang('admin.lang')" >
<head>
    
    <title> {{$DB_Products_Title}} | {{ $DB_HomeSettings->title }} </title>
    
    <!------- Head --->
    @include('web.include.head')
    
</head>

<body>
    <div class="page-wrapper">
                 
        <!------- Header --->
        @include('web.include.header')

        <main class="main">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">{{$DB_Products_Title}}</span></h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/@lang('admin.lang')">@lang('admin.home')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$DB_Products_Title}}</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
                <div class="container">
                	<div class="row">
                		<div class="col-lg-9">
                			<div class="toolbox">
                				<div class="toolbox-left">
                					<div class="toolbox-info">
                						Gösterilen <span>{{$DB_Products_Count}}/{{$DB_Count}}</span> Ürün
                					</div><!-- End .toolbox-info -->
                				</div><!-- End .toolbox-left -->

                				<div class="toolbox-right">
                					<div class="toolbox-sort">
                						<label for="sortby">Sıralama:</label>
                						<div class="select-custom">

                                            <!-- Sıralama -->
											<select name="sortby" id="sortby" class="form-control" onchange="javascript:orderByData(this)" style="cursor: pointer;">
												<option value="?page=1&rowcount={{$rowcount}}&orderBy=products.uid&order=desc&categories={{$categories}}" {{$orderBy == 'products.uid' && $order == 'desc' ? 'selected' : ''}} >En Yeniler</option>
												<option value="?page=1&rowcount={{$rowcount}}&orderBy=products.uid&order=asc&categories={{$categories}}" {{$orderBy == 'products.uid' && $order == 'asc' ? 'selected' : ''}}>En Eskiler</option>
												<option value="?page=1&rowcount={{$rowcount}}&orderBy=products.sale_price&order=asc&categories={{$categories}}" {{$orderBy == 'products.sale_price' && $order == 'asc' ? 'selected' : ''}} >Artan Fiyat</option>
												<option value="?page=1&rowcount={{$rowcount}}&orderBy=products.sale_price&order=desc&categories={{$categories}}" {{$orderBy == 'products.sale_price' && $order == 'desc' ? 'selected' : ''}} >Azalan Fiyat</option>
											</select>
                                            
                                            <script type="text/javascript">
                                                function orderByData(elm) { window.location = elm.value; }
                                            </script>
                                            <!-- Sıralama Son -->
                                            
										</div>
                					</div><!-- End .toolbox-sort -->
                				</div><!-- End .toolbox-right -->
                			</div><!-- End .toolbox -->

                            <div class="products mb-3">
                                <div class="row justify-content-center">
                                     
                                    <!--- Ürünler -->
                                    @for ($i = 0; $i < count($DB_Products); $i++)
                                    <div class="col-6 col-md-4 col-lg-4 col-xl-3">
                                        <div class="product product-7 text-center">
                                            <figure class="product-media">
                                                <a href="/@lang('admin.lang')/product/view/{{$DB_Products[$i]->uid}}-{{$DB_Products[$i]->seo_url}}">
                                                    <img src="{{$DB_Products[$i]->img_url}}" style="width: 100%;height: 250px;object-fit: contain;" >
                                                </a>

                                                <div class="product-action" style="display: flex;flex-direction: column;" >

                                                    <!--- Sepet Ekleme Durumu -->
													<a id="userCartAdd_None" data_productid="{{$DB_Products[$i]->uid}}" style="margin-top: 5px; display:{{$DB_Products[$i]->web_user_cart_control == 1  ? 'flex': 'none'}}; background-color: green;padding: 18px; font-size:15px;"  class="btn btn-product font-weight-normal text-uppercase text-truncate text-white btn-success"> <i class="fas fa-check" style="font-size: 15px;" ></i> Sepete Eklendi </a>
													<a id="userCartAdd" data_productid="{{$DB_Products[$i]->uid}}" data_product_quantity="1" style="cursor: pointer; padding: 15px;margin-top: 5px; display:{{$DB_Products[$i]->web_user_cart_control == 0  ? 'flex': 'none'}};" class="btn btn-product font-weight-normal text-uppercase text-truncate btn-cart btn-outline-primary-2">Sepete Ekle</a>
																									
													<!--- İstek Listesine Ekleme Durumu -->
													<a id="userWishAdd_None" data_productid="{{$DB_Products[$i]->uid}}" style="color: green; display:{{$DB_Products[$i]->web_user_wish_control == 1  ? 'flex': 'none'}}; gap: 5px;align-items: center; " class="wishlist-link-product px-3 ml-0 font-weight-normal mt-1"><i class="fa fa-heart" style="font-size: 15px; color: green; " ></i><span>İstek Listesine Eklendi</span></a>
													<a id="userWishAdd" data_productid="{{$DB_Products[$i]->uid}}" data_product_quantity="1"  style="cursor: pointer;gap: 5px;align-items: center;display:{{$DB_Products[$i]->web_user_wish_control == 0  ? 'flex': 'none'}};" class="wishlist-link-product px-3 ml-0 font-weight-normal mt-1"><i data_productid="{{$DB_Products[$i]->uid}}" data_product_quantity="1" class="fa fa-heart-o"></i><span data_productid="{{$DB_Products[$i]->uid}}" data_product_quantity="1" >İstek Listesine Ekle</span></a>
												
												</div><!-- End .product-action -->
                                            </figure><!-- End .product-media -->

                                            <div class="product-body">
                                                <div class="product-cat">
													<a href="/@lang('admin.lang')/product/category/{{$DB_Products[$i]->product_categories_uid}}-{{$DB_Products[$i]->product_categories_seo_url}}">{{$DB_Products[$i]->product_categories_title}}</a>
                                                </div><!-- End .product-cat -->
                                                <h3 class="product-title"><a href="/@lang('admin.lang')/product/view/{{$DB_Products[$i]->uid}}-{{$DB_Products[$i]->seo_url}}">{{$DB_Products[$i]->title}}</a></h3><!-- End .product-title -->
                                                <div style="display: flex;justify-content: center;" >
                                                    @if($DB_Products[$i]->discounted_price_percent !="0")
                                                    <h4 class="new-price" style="color: green;font-size: 20px;font-weight: bold;" >{{$DB_Products[$i]->discounted_price}} {{$DB_Products[$i]->currency}}</h4>
                                                    <h4 class="old-price" style="font-size: 15px;font-weight: bold;" >{{$DB_Products[$i]->sale_price}} {{$DB_Products[$i]->currency}}</h4>
                                                    @else<h4 class="new-price" style="color: green;font-size: 20px;font-weight: bold;" >{{$DB_Products[$i]->sale_price}} {{$DB_Products[$i]->currency}}</h4>
                                                    @endif
                                                </div><!-- End .product-price -->
                                              

                                             
                                            </div><!-- End .product-body -->
                                        </div><!-- End .product -->
                                    </div>
                                    @endfor
                                    <!--- Ürünler Son -->

                                </div><!-- End .row -->
                            </div><!-- End .products -->

                            <!------  Pagination  -->
                			<nav aria-label="Page navigation" style="{{$pageTop > 0 ? '' : 'display:none;'}}" >
							    <ul class="pagination justify-content-center" >
                                    
							        <li class="page-item" style="{{$pageTop > 1 && $pageNow != 1 ? '' : 'display:none;'}}">
							            <a class="page-link page-link-prev" href="?page={{$pageNow-1}}&rowcount={{$rowcount}}&orderBy={{$orderBy}}&order={{$order}}&categories={{$categories}}" aria-label="Öncesi" tabindex="-1" aria-disabled="true">
							                <span aria-hidden="true"><i class="fa fa-long-arrow-left"></i></span>Öncesi
							            </a>
							        </li>
                                    
                                    @for ($i = 1; $i < $pageTop+1; $i++)
							        <li class="page-item {{$i==$pageNow ? 'active': ''}} "><a class="page-link" href="?page={{$i}}&rowcount={{$rowcount}}&orderBy={{$orderBy}}&order={{$order}}&categories={{$categories}}">{{$i}}</a></li>
                                    @endfor
							       
							        <li class="page-item"  style="{{$pageTop > 1 && $pageTop != $pageNow ? '' : 'display:none;'}}" >
							            <a class="page-link page-link-next" href="?page={{$pageNow+1}}&rowcount={{$rowcount}}&orderBy={{$orderBy}}&order={{$order}}&categories={{$categories}}" aria-label="Sonrası">
							                Sonrası <span aria-hidden="true"><i class="fa fa-long-arrow-right"></i></span>
							            </a>
							        </li>

							    </ul>
							</nav>
                            <!------  Pagination Son -->


                		</div><!-- End .col-lg-9 -->
                		<aside class="col-lg-3 order-lg-first">
                			<div class="sidebar sidebar-shop">

							    <div>
									<strong>Arama</strong>
									<ul>
										<input type="text" id="search_value" value="{{request('search')}}" style="border: 1px solid #DDD;">
										<button id="search_button" style="width: 40px;box-sizing: border-box;background-color: green;color: #FFF;cursor: pointer;" >Ara</button>
									</ul>
								</div>

								<hr>

                				<div class="widget widget-collapsible">
    								<h3 style="font-size: 28px;font-weight: 100;border-bottom: 1px solid;">
									   @lang('admin.category')
									</h3><!-- End .widget-title -->

									<div class="collapse show" id="widget-1">
										<div class="widget-body">
											<div class="filter-items filter-items-count">

												@for ($i = 0; $i < count($DB_product_categories); $i++)
												<div class="filter-item">
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" name="product_categories" id="{{$DB_product_categories[$i]->uid}}" value="{{$DB_product_categories[$i]->uid}}"  {{ in_array($DB_product_categories[$i]->uid, $dizi_categories) ? 'checked' : '' }} >
														<label class="custom-control-label" for="{{$DB_product_categories[$i]->uid}}">{{$DB_product_categories[$i]->title}}</label>
													</div><!-- End .custom-checkbox -->
												</div><!-- End .filter-item -->
												@endfor

											</div><!-- End .filter-items -->
											
											<hr>
											<button type="button" id="filtereleControl" data_url="?page=1&rowcount={{$rowcount}}&orderBy={{$orderBy}}&order={{$order}}" style="width: 100%;background-color: green;color: white;" >Ara</button>

										</div><!-- End .widget-body -->
									</div><!-- End .collapse -->
        						</div><!-- End .widget -->
        					
                			</div><!-- End .sidebar sidebar-shop -->
                		</aside><!-- End .col-lg-3 -->
                	</div><!-- End .row -->
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