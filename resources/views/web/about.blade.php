<!DOCTYPE html>
<html lang="@lang('admin.lang')" >
<head>
    
    <title> @lang('admin.about') | {{ $DB_HomeSettings->title }} </title>
    
    <!------- Head --->
    @include('web.include.head')
    
</head>

<body>
    <div class="page-wrapper">
                     
        <!------- Header --->
        @include('web.include.header')

        <main class="main">
        	<div class="page-header text-center" style="background-image: url('{{asset('/assets')}}/web/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title"> @lang('admin.about') </h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/@lang('admin.lang')">@lang('admin.home')</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> @lang('admin.about')</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content pb-3">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-10 offset-lg-1">
                            <div class="about-text text-center mt-3">
                                <h2 class="title text-center mb-2">Biz Kimiz</h2><!-- End .title text-center mb-2 -->
                                <p> {!!$DB_Institutional->about!!}</p>
                                <img src="{{$DB_Institutional->about_img_url}}" alt="image" class="mx-auto mb-6" style="width: 100%;max-width: 600px;margin-top: 10px;object-fit: contain;">
                            </div><!-- End .about-text -->
                        </div><!-- End .col-lg-10 offset-1 -->
                    </div><!-- End .row -->
                   
                </div><!-- End .container -->

                <div class="mb-2"></div><!-- End .mb-2 -->

                <div class="container">
                    <div class="row">
                        <div class="col-lg-10 offset-lg-1">
                            <div class="brands-text text-center mx-auto mb-6">
                                <h2 class="title">Referanslarımız</h2><!-- End .title -->
                            </div><!-- End .brands-text -->
                            <div class="brands-display">
                                <div class="row justify-content-center">
                                    
                                    @for ($i = 0; $i < count($DB_institutional_references); $i++)
                                    <div class="col-6 col-sm-4 col-md-3">
                                        <a href="{{$DB_institutional_references[$i]->site_url}}" class="brand">
                                            <img src="{{$DB_institutional_references[$i]->img_url}}" alt="{{$DB_institutional_references[$i]->title}}" style="object-fit: cover;" >
                                        </a>
                                    </div><!-- End .col-md-3 -->
                                    @endfor

                                   
                                </div><!-- End .row -->
                            </div><!-- End .brands-display -->
                        </div><!-- End .col-lg-10 offset-lg-1 -->
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

</body>

</html>