<!DOCTYPE html>
<html lang="@lang('admin.lang')" >
<head>
    
    <title> @lang('admin.productCategory') | {{ $DB_HomeSettings->title }} </title>
    
    <!------- Head --->
    @include('web.include.head')
    
</head>

<body>
    <div class="page-wrapper">
                 
        <!------- Header --->
        @include('web.include.header')

                   
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