<!DOCTYPE html>
<html lang="@lang('admin.lang')" >
<head>
    
    <title> @lang('admin.myAccount') | {{ $DB_HomeSettings->title }} </title>
    
    <!------- Head --->
    @include('web.include.head')
    
</head>

<body>
    <div class="page-wrapper" id="userInfo" userId="{{$DB_ProfileInfo->id}}" >
                                       
        <!------- Header --->
        @include('web.include.header')

        <main class="main">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">@lang('admin.myAccount')</h1>
					<p>{{$DB_ProfileInfo->email}}</p>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/@lang('admin.lang')">@lang('admin.home')</a></li>
                        <li class="breadcrumb-item"><a href="#">@lang('admin.myAccount')</a></li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
            	<div class="dashboard">
	                <div class="container">
	                	<div class="row">
	                		<aside class="col-md-4 col-lg-3">
	                			<ul class="nav nav-dashboard flex-column mb-3 mb-md-0" role="tablist">
								    <li class="nav-item">
								        <a class="nav-link active" id="tab-orderlist-link" data-toggle="tab" href="#tab-orderlist" role="tab" aria-controls="tab-orderlist" aria-selected="true">@lang('admin.myOrderList')</a>
								    </li>
								    <li class="nav-item">
								        <a class="nav-link" id="tab-address-link" data-toggle="tab" href="#tab-address" role="tab" aria-controls="tab-address" aria-selected="false">@lang('admin.myAddressInformation')</a>
								    </li>
									<li class="nav-item">
								        <a class="nav-link" id="tab-resetMyPassword-link" data-toggle="tab" href="#tab-resetMyPassword" role="tab" aria-controls="tab-resetMyPassword" aria-selected="false">@lang('admin.resetMyPassword')</a> 
								    </li>
								    <li class="nav-item">
								        <a class="nav-link" id="tab-account-link" data-toggle="tab" href="#tab-account" role="tab" aria-controls="tab-account" aria-selected="false">@lang('admin.userInfo')</a>
								    </li>
								    <li class="nav-item">
								        <a class="nav-link" href="/@lang('admin.lang')/user/login">@lang('admin.logout')</a>
								    </li>
								</ul>
	                		</aside><!-- End .col-lg-3 -->

	                		<div class="col-md-8 col-lg-9">
	                			<div class="tab-content">
								    <div class="tab-pane fade show active" id="tab-orderlist" role="tabpanel" aria-labelledby="tab-orderlist-link">
								    	<p>Hello <span class="font-weight-normal text-dark">User</span> (not <span class="font-weight-normal text-dark">User</span>? <a href="#">Log out</a>) 
								    	<br>
								    	From your account dashboard you can view your <a href="#tab-orders" class="tab-trigger-link link-underline">recent orders</a>, manage your <a href="#tab-address" class="tab-trigger-link">shipping and billing addresses</a>, and <a href="#tab-account" class="tab-trigger-link">edit your password and account details</a>.</p>
								    </div><!-- .End .tab-pane -->

									<div class="tab-pane fade" id="tab-address" role="tabpanel" aria-labelledby="tab-address-link">
								    	<p>The following addresses will be used on the checkout page by default.</p>

								    	<div class="row">
								    		<div class="col-lg-6">
								    			<div class="card card-dashboard">
								    				<div class="card-body">
								    					<h3 class="card-title">Billing Address</h3><!-- End .card-title -->

														<p>User Name<br>
														User Company<br>
														John str<br>
														New York, NY 10001<br>
														1-234-987-6543<br>
														yourmail@mail.com<br>
														<a href="#">Edit <i class="fa fa-edit"></i></a></p>
								    				</div><!-- End .card-body -->
								    			</div><!-- End .card-dashboard -->
								    		</div><!-- End .col-lg-6 -->

								    		<div class="col-lg-6">
								    			<div class="card card-dashboard">
								    				<div class="card-body">
								    					<h3 class="card-title">Shipping Address</h3><!-- End .card-title -->

														<p>You have not set up this type of address yet.<br>
														<a href="#">Edit <i class="fa fa-edit"></i></a></p>
								    				</div><!-- End .card-body -->
								    			</div><!-- End .card-dashboard -->
								    		</div><!-- End .col-lg-6 -->
								    	</div><!-- End .row -->
								    </div><!-- .End .tab-pane -->

								    <div class="tab-pane fade" id="tab-resetMyPassword" role="tabpanel" aria-labelledby="tab-resetMyPassword-link">
								     	<div>
										    <div>
												<label for="oldPassword">@lang('admin.enterUrPassword')</label>
												<input type="password" class="form-control" name="oldPassword" id="oldPassword" placeholder="@lang('admin.enterUrPassword')" value="" >
											</div>

		            						<div>
												<label for="newPassword">@lang('admin.newPassword')</label>
												<input type="password" class="form-control" name="newPassword" id="newPassword" placeholder="@lang('admin.newPassword')" value="" >
											</div>

											<div>
												<label for="repeatPassword">@lang('admin.repeatPassword')</label>
												<input type="password" class="form-control" name="repeatPassword" id="repeatPassword" placeholder="@lang('admin.repeatPassword')" value="" >
											</div>

											<!-- Kaydet -->
											<button type="button" id="profilePasswordSave" style="cursor: pointer;" class="btn btn-outline-primary-2"  >@lang('admin.save')</button>
			                			</div>
								    </div><!-- .End .tab-pane -->

								    <div class="tab-pane fade" id="tab-account" role="tabpanel" aria-labelledby="tab-account-link">
								    	<div>
			                				<div class="row">
			                					<div class="col-sm-6">
													<label for="name">@lang('admin.name')</label>
													<input type="text" class="form-control" name="name" id="name" placeholder="@lang('admin.name')" value="{{$DB_ProfileInfo->name}}" >
			                					</div><!-- End .col-sm-6 -->

			                					<div class="col-sm-6">
													<label for="surname">@lang('admin.surname')</label>
			                						<input type="text" class="form-control" name="surname" id="surname" placeholder="@lang('admin.surname')" value="{{$DB_ProfileInfo->surname}}" >
			                					</div><!-- End .col-sm-6 -->
			                				</div><!-- End .row -->

		            						<div>
												<label for="phone">@lang('admin.phone')</label>
												<input type="text" class="form-control" name="phone" id="phone" placeholder="@lang('admin.phone')" value="{{$DB_ProfileInfo->phone}}" >
											</div>

											<!-- Kaydet -->
											<button type="button" id="profileEdit" style="cursor: pointer;" class="btn btn-outline-primary-2"  >@lang('admin.save')</button>
			                			</div>
								    </div><!-- .End .tab-pane -->
								</div>
	                		</div><!-- End .col-lg-9 -->
	                	</div><!-- End .row -->
	                </div><!-- End .container -->
                </div><!-- End .dashboard -->
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
	<script src="{{asset('/assets/web')}}/js/user/user.js"></script>

</body>

</html>