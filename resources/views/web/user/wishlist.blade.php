<!DOCTYPE html>
<html lang="@lang('admin.lang')" >
<head>
    
	<title> @lang('admin.myWishList') | {{ $DB_HomeSettings->title }} </title>
    
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
        			<h1 class="page-title">@lang('admin.myWishList')</h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/@lang('admin.lang')">@lang('admin.home')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('admin.myWishList')</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
            	<div class="container">

			    	@if(session('status') == "success")
						<div class="alert alert-success " role="alert" style="margin-bottom: 16px;"> {{session('msg')}}  </div>
					@elseif(session('status') == "error")
						<div class="alert alert-danger " role="alert" style="margin-bottom: 16px;"> {{session('msg')}}  </div>
					@endif	

					<table class="table table-wishlist table-mobile">
						<thead>
							<tr>
								<th>@lang('admin.product')</th>
								<th>@lang('admin.salePrice')</th>
								<th>@lang('admin.stockStatus')</th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
						</thead>

						<tbody>
						    
						    @for ($i = 0; $i < count($DB_web_user_wish); $i++)
							<tr>
								<td class="product-col">
									<div class="product">
										<figure class="product-media">
											<a href="/@lang('admin.lang')/product/view/{{$DB_web_user_wish[$i]->productsUid}}-{{$DB_web_user_wish[$i]->productsSeo_url}}">
												<img src="{{$DB_web_user_wish[$i]->productsImg}}" alt="Product image">
											</a>
										</figure>

										<h3 class="product-title">
											<a href="/@lang('admin.lang')/product/view/{{$DB_web_user_wish[$i]->productsUid}}-{{$DB_web_user_wish[$i]->productsSeo_url}}">{{$DB_web_user_wish[$i]->productsTitle}}</a>
										</h3><!-- End .product-title -->
									</div><!-- End .product -->
								</td>
								<td class="price-col">{{$DB_web_user_wish[$i]->productsPrice}} {{$DB_web_user_wish[$i]->productsCurrency}}</td>
								<td class="stock-col"><span class="{{$DB_web_user_wish[$i]->productsStock > 0 ? 'in-stock' : 'out-of-stock'}}">{{$DB_web_user_wish[$i]->productsStock > 0 ? "Stokta Var" : "Stok Yok"}}</span></td>
                                <td class="remove-col"><a id="userCartAdd" data_productid="{{$DB_web_user_wish[$i]->productsUid}}" data_product_quantity="1" style="cursor: pointer;height: 15px;" class="btn btn-product font-weight-normal text-uppercase text-truncate btn-cart btn-outline-primary-2 btn-outline-primary-2">Sepete Ekle</a></td>
                                <td class="remove-col"><button class="btn-remove" id="userWishDelete" data_id="{{$DB_web_user_wish[$i]->id}}" data_productstitle="{{$DB_web_user_wish[$i]->productsTitle}}" ><i data_id="{{$DB_web_user_wish[$i]->id}}" data_productstitle="{{$DB_web_user_wish[$i]->productsTitle}}" class="fa fa-close" style="color: red;" ></i></button></td>
							@endfor
							
						</tbody>
					</table><!-- End .table table-wishlist -->

					<div style="display: flex;justify-content: space-between;">

						<div>
							<a href="/@lang('admin.lang')/user/wishlist/all/delete" class="btn btn-outline-dark-2 btn-block mb-3" style="background-color: red;color: white;"><span>Listeyi Boşalt</span></a>
						</div><!-- End  coupon -->
						

						<div>
							<a href="/@lang('admin.lang')/user/wishlist/all/cart/add" class="btn btn-outline-dark-2 btn-block mb-3" style="background-color: green;color: white;"><span>Tümünü Sepete Ekle</span></a>
						</div><!-- End  coupon -->

					</div>
                     				
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

</body>

</html>