<!DOCTYPE html>
<html lang="@lang('admin.lang')" >
<head>
    
    <title> @lang('admin.login') | {{ $DB_HomeSettings->title }} </title>
    
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
                        <li class="breadcrumb-item active" aria-current="page">@lang('admin.login')</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17" style="background-image: url('{{asset('/assets')}}/web/images/backgrounds/login-bg.jpg')">
            	<div class="container">
            		<div class="form-box">
            			<div class="form-tab">
	            			<ul class="nav nav-pills nav-fill" role="tablist">
							    <li class="nav-item">
							        <a class="nav-link active" id="signin-tab-2" data-toggle="tab" href="#signin-2" role="tab" aria-controls="signin-2" aria-selected="false">@lang('admin.login')</a>
							    </li>
							    <li class="nav-item">
							        <a class="nav-link" id="register-tab-2" data-toggle="tab" href="#register-2" role="tab" aria-controls="register-2" aria-selected="true">@lang('admin.register')</a>
							    </li>
							</ul>
							<div class="tab-content">
								<!------- Giriş ----------->
							    <div class="tab-pane fade show active" id="signin-2" role="tabpanel" aria-labelledby="signin-tab-2">
							    	<div>
							    		<div class="form-group">
							    			<label for="email">@lang('admin.email')</label>
							    			<input type="email" class="form-control" id="email" name="email" placeholder="E-Mail Adresiniz" required>
							    		</div><!-- End .form-group -->

							    		<div class="form-group">
							    			<label for="password">@lang('admin.password')</label>
							    			<input type="password" class="form-control" id="password" name="password" required>
							    		</div><!-- End .form-group -->

							    		<div class="form-footer">
							    			<button id="login" class="btn btn-outline-primary-2">
			                					<span>@lang('admin.login')</span>
			            						<i class="fa fa-long-arrow-right"></i>
			                				</button>

											<a href="#" class="forgot-link">@lang('admin.forgotMyPassword')</a>
							    		</div><!-- End .form-footer -->
							    	</div>
							    </div>
								<!------- Giriş Son ----------->

								<!------- Kayıt ----------->
							    <div class="tab-pane fade" id="register-2" role="tabpanel" aria-labelledby="register-tab-2">
									<div id='loader' style="display: none;width: 20px;margin-bottom: 15px;"><img src="/upload/images/loader.gif" alt=""></div>
							    	<form action="#">
							    		<div class="form-group">
							    			<label for="name">@lang('admin.name')</label>
							    			<input type="text" class="form-control" id="name" name="name" required>
							    		</div><!-- End .form-group -->

										<div class="form-group">
							    			<label for="surname">@lang('admin.surname')</label>
							    			<input type="text" class="form-control" id="surname" name="surname" required>
							    		</div><!-- End .form-group -->

										<div class="form-group">
							    			<label for="phone">@lang('admin.phone')</label>
							    			<input type="text" class="form-control" id="phone" name="phone" required>
							    		</div><!-- End .form-group -->

										<div class="form-group">
							    			<label for="emailRegister">@lang('admin.email')</label>
							    			<input type="email" class="form-control" id="emailRegister" name="emailRegister" required>
							    		</div><!-- End .form-group -->

							    		<div class="form-group">
							    			<label for="passwordRegister">@lang('admin.password')</label>
							    			<input type="password" class="form-control" id="passwordRegister" name="passwordRegister" required>
							    		</div><!-- End .form-group -->

										<div class="form-group">
							    			<label for="confirmPasswordRegister">@lang('admin.repeatPassword')</label>
							    			<input type="password" class="form-control" id="confirmPasswordRegister" name="confirmPasswordRegister" required>
							    		</div><!-- End .form-group -->

							    		<div class="form-footer">
							    			<button id="register" style="cursor: pointer;"  class="btn btn-outline-primary-2">
			                					<span>@lang('admin.register')</span>
			            						<i class="fa fa-long-arrow-right"></i>
			                				</button>
							    		</div><!-- End .form-footer -->
							    	</form>
							    </div><!-- .End .tab-pane -->
								<!------- Kayıt Son ----------->

								
							</div><!-- End .tab-content -->
						</div><!-- End .form-tab -->
            		</div><!-- End .form-box -->
            	</div><!-- End .container -->
            </div><!-- End .login-page section-bg -->
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
	<script src="{{asset('/assets/web')}}/js/user/user.js"></script>

</body>

</html>