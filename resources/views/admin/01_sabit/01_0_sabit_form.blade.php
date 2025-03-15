<!DOCTYPE html>

<!-- Head -->
<title> @lang('admin.const') | {{ config('admin.Admin_Title') }} </title>
@include('admin.include.head')

<!-- Tanım -->
<?php $homeUrl = '/admin'; ?>
<?php $listTitle = __('admin.const'); ?>


<!----- Css ------> 
<link rel="stylesheet" type="text/css" href="{{asset('/assets/web')}}/css/sabit/0_const.css" />

<!-- BEGIN BODY -->
<body class="fixed-top">
    
    <!-- Header -->
    @include('admin.include.header')

   <!-- BEGIN CONTAINER -->
   <div id="container" class="row-fluid">
      <!-- BEGIN SIDEBAR -->
      <div class="sidebar-scroll">

        <!-- Sidebar -->
        @include('admin.include.sidebar')

      </div>
      <!-- END SIDEBAR -->
      <!-- BEGIN PAGE -->
      <div id="main-content">
         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->
            <div class="row-fluid">
               <div class="span12">
                   
                  <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                   <h3 class="page-title"> {{$listTitle}} </h3>
                   <ul class="breadcrumb">
                       <li>
                          <a href="/@lang('admin.lang'){{$homeUrl}}">@lang('admin.home')</a>
                          <span class="divider">/</span>
                       </li>
                       <li class="active"> {{$listTitle}} </li>
                   </ul>
                   <!-- END PAGE TITLE & BREADCRUMB-->
               </div>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
             <div class="row-fluid">
                <div class="span6">
                    <!-- BEGIN BLANK PAGE PORTLET-->
                    <div class="widget red">
                        <div class="widget-title">
                            <h4><i class="fa fa-edit"></i> Blank Page </h4>
                        <span class="tools">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-remove"></a>
                        </span>
                        </div>
                        <div class="widget-body">
                            <h1> Form </h1>

                            <!------- Form ----------->
                            <form action="{{route('admin.fixed.form.control')}}" method="post" class="c-card__body" >
                              <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                              <input name="siteLang" type="hidden" value= "tr" />
                              <div class="c-field u-mb-small">
                                  <label class="c-field__label" for="email">Email</label> 
                                  <input class="c-input" type="email" id="email" name="email"  placeholder="info@email.com"> 
                              </div>

                              <div class="c-field u-mb-small">
                                  <label class="c-field__label" for="password">Password</label> 
                                  <input class="c-input" type="password" id="password" name="password" placeholder="***"> 
                              </div>

                              <button class="c-btn c-btn--success c-btn--fullwidth" type="submit">Tıkla</button>

                            </form>
                            <!------- Form Son ----------->
                            
                        </div>
                    </div>
                    <!-- END BLANK PAGE PORTLET-->
                </div>
                <div class="span6">
                    <!-- BEGIN BLANK PAGE PORTLET-->
                    <div class="widget red">
                        <div class="widget-title">
                            <h4><i class="fa fa-edit"></i> Blank Page </h4>
                        <span class="tools">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-remove"></a>
                        </span>
                        </div>
                        <div class="widget-body">
                            <h1> Sabit </h1>
                        </div>
                    </div>
                    <!-- END BLANK PAGE PORTLET-->
                </div>
             </div>
            <!-- END PAGE CONTENT-->
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->
   </div>
   <!-- END CONTAINER -->


   <!-- Footer -->
   @include('admin.include.footer')

   <!------- Sabit Js --->
   <script src="{{asset('/assets/admin')}}/js/00_0_sabit/0_const.js"></script>
    
</body>
<!-- END BODY -->
</html>