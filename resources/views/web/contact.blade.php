<!DOCTYPE html>
<html lang="@lang('admin.lang')" >
<head>
    
    <title> @lang('admin.contact') | {{ $DB_HomeSettings->title }} </title>
    
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
                        <li class="breadcrumb-item active" aria-current="page"> @lang('admin.contact')</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->
            <div class="container">
	        	<div class="page-header page-header-big text-center" style="background-image: url('{{asset('/assets')}}/web/images/contact-header-bg.jpg')">
        			<h1 class="page-title text-white">@lang('admin.contact')</h1>
	        	</div><!-- End .page-header -->
            </div><!-- End .container -->

            <div class="page-content pb-0">
                <div class="container">
                	<div class="row">
                		<div class="col-lg-6 mb-2 mb-lg-0">
                			<h2 class="title mb-1">İletişim Bilgilerimiz</h2>
							<div class="row">
                				<div class="col-sm-7">
                					<div class="contact-info">

                						<ul class="contact-list">
                							<li>
                								<i class="fa fa-map-marker"></i>
	                							{!! $DB_HomeSettings->address !!}
	                						</li>
                							<li>
                								<i class="fa fa-envelope"></i>
                								<a href="{{asset('/assets')}}/web/mailto:#">{{ $DB_HomeSettings->email }}</a>
                							</li>
                						</ul><!-- End .contact-list -->
                					</div><!-- End .contact-info -->
                				</div><!-- End .col-sm-7 -->
								<div class="col-sm-5">
                					<div class="contact-info">

                						<ul class="contact-list">
                							
                							<li>
                								<i class="fa fa-phone"></i>
                								<a href="tel:{{ $DB_HomeSettings->phone }}">{{ $DB_HomeSettings->phone }}	</a>
                							</li>
                							
                						</ul><!-- End .contact-list -->
                					</div><!-- End .contact-info -->
                				</div><!-- End .col-sm-7 -->
                			</div><!-- End .row -->
                		</div><!-- End .col-lg-6 -->
                		<div class="col-lg-6">
                			<h2 class="title mb-1">@lang('admin.contactMessage')</h2><!-- End .title mb-2 -->
                			
							<form action="#" class="contact-form mb-3">
                				<div class="row">
                					<div class="col-sm-3">
                                        <label for="nameAdd" class="sr-only">@lang('admin.name')</label>
                						<input type="text" class="form-control" id="nameAdd" placeholder="@lang('admin.name') *" required>
                					</div><!-- End .col-sm-6 -->

									<div class="col-sm-3">
                                        <label for="surnameAdd" class="sr-only">@lang('admin.surname')</label>
                						<input type="text" class="form-control" id="surnameAdd" placeholder="@lang('admin.surname') *" required>
                					</div><!-- End .col-sm-6 -->

                					<div class="col-sm-6">
                                        <label for="emailAdd" class="sr-only">@lang('admin.email')</label>
                						<input type="email" class="form-control" id="emailAdd" placeholder="@lang('admin.email') *" required>
                					</div><!-- End .col-sm-6 -->
                				</div><!-- End .row -->

                				<div class="row">
                					<div class="col-sm-6">
                                        <label for="phoneAdd" class="sr-only">@lang('admin.phone')</label>
                						<input type="tel" class="form-control" id="phoneAdd" placeholder="@lang('admin.phone')">
                					</div><!-- End .col-sm-6 -->

                					<div class="col-sm-6">
                                        <label for="subjectAdd" class="sr-only">@lang('admin.subject')</label>
                						<input type="text" class="form-control" id="subjectAdd" placeholder="@lang('admin.subject')">
                					</div><!-- End .col-sm-6 -->
                				</div><!-- End .row -->

                                <label for="messageAdd" class="sr-only">@lang('admin.message')</label>
                				<textarea class="form-control" cols="30" rows="4" id="messageAdd" required></textarea>

                				<button class="btn btn-outline-primary-2 btn-minwidth-sm" id="contact_message_new">
                					<span>@lang('admin.send')</span>
            						<i class="fa fa-long-arrow-right"></i>
                				</button>
                			</form><!-- End .contact-form -->
                		</div><!-- End .col-lg-6 -->
                	</div><!-- End .row -->

                
                </div><!-- End .container -->
            	<div id="map">
					<iframe src="{{ $DB_HomeSettings->web_address_map }}" width="100%" style="border:0;height: inherit;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
				</div><!-- End #map -->
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
    <script src="{{asset('/assets/web')}}/js/contact/contact_message.js"></script>

</body>

</html>