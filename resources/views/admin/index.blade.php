<!DOCTYPE html>

<!-- Head -->
<title> @lang('admin.home') | {{ config('admin.Admin_Title') }} </title>
@include('admin.include.head')

<!-- Tanım -->
<?php $homeUrl = '/admin'; ?>

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
                   <h3 class="page-title"> @lang('admin.home') </h3>
                   <ul class="breadcrumb">
                       <li>
                          <a href="/@lang('admin.lang'){{$homeUrl}}">@lang('admin.home')</a>
                          <span class="divider">/</span>
                       </li>
                       <li class="active"> @lang('admin.home') </li>
                   </ul>
                   <!-- END PAGE TITLE & BREADCRUMB-->
               </div>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
             <div class="row-fluid">
                 <div class="span12">
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
                                <h1> Anasayfa </h1>

                                <p> lang: @lang('admin.lang')</p>
                                <p> Api : {{ config('admin.Api_Url') }} </p> 
                                <p> Url: {{asset('/assets/admin')}}/ </p>

                                <div id="const_box"> Sabit kutu </div>

                                <h2> Session ve Çerez Bilgileri </h2>
                                <p> ID: {{$CookieData["yildirimdev_userID"]}} </p>
                                <p> Email: {{$CookieData["yildirimdev_email"]}} </p>
                                <p> Name:  {{$CookieData["yildirimdev_name"]}} </p>
                                <p> SurName: {{$CookieData["yildirimdev_surname"]}} </p>
                                <p> ImgUrl: {{$CookieData["yildirimdev_img_url"]}} </p>

                                <?php echo "Cookie - Tüm Veriler"; echo "<br>"; ?>
                                <?php echo "<pre>"; print_r($CookieData); ?>

                                
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