<!DOCTYPE html>
<html lang="@lang('admin.lang')" >
<head>
    
    <title> Faq | {{ $DB_HomeSettings->title }} </title>
    
    <!------- Head --->
    @include('web.include.head')
    
</head>
<body>
    <div class="page-wrapper">
                      
        <!------- Header --->
        @include('web.include.header')

        <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/@lang('admin.lang')">@lang('admin.home')</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active" aria-current="page">404</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

        	<div class="error-content text-center" style="background-image: url({{asset('/assets')}}/web/images/backgrounds/error-bg.jpg)">
            	<div class="container">
            		<h1 class="error-title">Error 404</h1><!-- End .error-title -->
            		<p>We are sorry, the page you've requested is not available.</p>
            		<a href="index.html" class="btn btn-outline-primary-2 btn-minwidth-lg">
            			<span>BACK TO HOMEPAGE</span>
            			<i class="fa fa-long-arrow-right"></i>
            		</a>
            	</div><!-- End .container -->
        	</div><!-- End .error-content text-center -->
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