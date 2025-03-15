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
                						Gösterilen <span>{{ count($productData) }}/{{ $totalProducts }}</span> Ürün
                					</div><!-- End .toolbox-info -->
                				</div><!-- End .toolbox-left -->
                				
                			</div><!-- End .toolbox -->

                            <div class="products mb-3">
                                <div class="row justify-content-center">
                                     
                                    <!--- Ürünler -->
                                    @foreach ($productData as $product)
                                    <div class="col-6 col-md-4 col-lg-4 col-xl-3">
                                        <div class="product product-7 text-center">
                                            <figure class="product-media">
                                                <a href="/@lang('admin.lang')/product/view/{{ htmlspecialchars($product['id']) }}">
                                                    <img src="{{ htmlspecialchars($product['image']) }}" style="width: 100%;height: 250px;object-fit: contain;" >
                                                </a>
                                            </figure><!-- End .product-media -->
											<div class="product-body">
                                                <div class="product-cat">
													<a href="/@lang('admin.lang')/product/category/1">{{ htmlspecialchars($product['category']) }}</a>
                                                </div><!-- End .product-cat -->
                                                <h3 class="product-title"><a href="/@lang('admin.lang')/product/view/1">{{ htmlspecialchars($product['name']) }}</a></h3><!-- End .product-title -->
                                                <div style="display: flex;justify-content: center;" >
                                                    <h4 class="new-price" style="color: green;font-size: 20px;font-weight: bold;" >{{ htmlspecialchars($product['price']) }} TL</h4>
                                                </div><!-- End .product-price -->
                                            </div><!-- End .product-body -->
                                        </div><!-- End .product -->
                                    </div>
                                    @endforeach
                                    <!--- Ürünler Son -->

                                </div><!-- End .row -->
                            </div><!-- End .products -->

						<!-- Pagination -->
						<nav aria-label="Page navigation" style="{{$totalProducts > 0 ? '' : 'display:none;'}}">
							<ul class="pagination justify-content-center">
								
								<!-- Önceki sayfa butonu -->
								<li class="page-item" style="{{$currentPageProduct > 1 ? '' : 'display:none;'}}">
									<a class="page-link page-link-prev" href="?page={{$currentPageProduct-1}}" aria-label="Öncesi" tabindex="-1" aria-disabled="true">
										<span aria-hidden="true"><i class="fa fa-long-arrow-left"></i></span>Öncesi
									</a>
								</li>

								<!-- Dinamik sayfa numaraları -->
								@php
									$totalPages = $totalPagesProduct; // Toplam sayfa sayısını controller'dan alıyoruz
									$startPage = max(1, $currentPageProduct - 4); // Başlangıç sayfası
									$endPage = min($totalPages, $currentPageProduct + 4); // Bitiş sayfası
								@endphp

								@for ($i = $startPage; $i <= $endPage; $i++)
									<li class="page-item {{$i == $currentPageProduct ? 'active' : ''}}">
										<a class="page-link" href="?page={{$i}}">{{$i}}</a>
									</li>
								@endfor

								<!-- Sonraki sayfa butonu -->
								<li class="page-item" style="{{$currentPageProduct < $totalPages ? '' : 'display:none;'}}">
									<a class="page-link page-link-next" href="?page={{$currentPageProduct+1}}" aria-label="Sonrası">
										Sonrası <span aria-hidden="true"><i class="fa fa-long-arrow-right"></i></span>
									</a>
								</li>

							</ul>
						</nav>
						<!-- Pagination Son -->




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
												<ul>
													@foreach ($categoryData as $category)
													<div class="filter-item">
														<div class="custom-control custom-checkbox">
															<li><a href="?category={{ $category['id'] }}&pageCategory={{$currentPageCategory}}">{{ htmlspecialchars($category['name']) }}</a></li>
														</div><!-- End .custom-checkbox -->
													</div><!-- End .filter-item -->
													@endforeach
												</ul>
											</div><!-- End .filter-items -->
											
										
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