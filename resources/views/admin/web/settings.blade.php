<!DOCTYPE html>

<!-- Head -->
<title> @lang('admin.webSettings') | {{ config('admin.Admin_Title') }} </title>
@include('admin.include.head')

<!-- Tanım -->
<?php $homeUrl = '/admin'; ?>
<?php $listTitle = __('admin.webSettings'); ?>

<!----- Css ------> 
<link rel="stylesheet" type="text/css" href="{{asset('/assets/admin')}}/css/settings.css" />

<!-- BEGIN BODY -->
<body class="fixed-top" id="web_setting_info" data_id="{{$DB_HomeSettings->id}}">
    
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
            
            <div id='loader' style="display: flex;width: 20px;margin-bottom: 15px;"><img src="/upload/images/loader.gif" alt=""></div>

            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
             <div class="row-fluid">
                <div class="span6">
                    <!-- Web -->
                    <div class="widget red">
                        <div class="widget-title">
                            <h4><i class="fa fa-edit"></i> Web </h4>
                        <span class="tools">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-remove"></a>
                        </span>
                        </div>
                        <div class="widget-body">
                            <h1> Web </h1>

                            <!------- Form ----------->
                            <form class="c-card__body" >
                               <div class="span12">
                                    <div class="row-fluid">
                                        <div class="span6 c-field u-mb-small">
                                            <label class="c-field__label" for="web_title">Title</label> 
                                            <input class="c-input" type="text" id="web_title" name="web_title"  placeholder="yildirimdev" value="{{$DB_HomeSettings->title}}" >
                                        </div>

                                        <div class="span6 c-field u-mb-small">
                                            <label class="c-field__label" for="web_site_url">Site Url</label> 
                                            <input class="c-input" type="text" id="web_site_url" name="web_site_url" placeholder="yildirimdev.com" value="{{$DB_HomeSettings->siteUrl}}" >
                                        </div>
                                    </div>
                                </div>

                                <div class="row-fluid">
                                    <button type="button" class="btn btn-info span12" id="web_Save">Web - @lang('admin.save')</button>
                                </div>

                            </form>
                            <!------- Form Son ----------->
                            
                        </div>
                    </div>
                    <!-- Web -->
                </div>
                <div class="span6">
                    <!-- Sosyal Ağ -->
                    <div class="widget blue">
                        <div class="widget-title">
                            <h4><i class="fa fa-edit"></i> @lang('admin.socialMedia') </h4>
                        <span class="tools">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-remove"></a>
                        </span>
                        </div>
                        <div class="widget-body">
                            <h1> @lang('admin.socialMedia') </h1>

                            <!------- Form ----------->
                            <form class="c-card__body" >
                              
                              <div class="span12">
                                <div class="row-fluid">
                                    <div class="span6 c-field u-mb-small">
                                        <label class="c-field__label" for="web_email">Email</label> 
                                        <input class="span12" type="email" id="web_email" name="web_email"  placeholder="info@email.com" value="{{ $DB_HomeSettings->email }}"> 
                                    </div>

                                    <div class="span6 c-field u-mb-small">
                                        <label class="c-field__label" for="web_phone">Telefon</label> 
                                        <input class="span12" type="text" id="web_phone" name="web_phone" placeholder="" value="{{ $DB_HomeSettings->phone }}"> 
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span6 c-field u-mb-small">
                                        <label class="c-field__label" for="web_phone2">Telefon</label> 
                                        <input class="span12" type="email" id="web_phone2" name="web_phone2"  placeholder="" value="{{ $DB_HomeSettings->phone2 }}"> 
                                    </div>

                                    <div class="span6 c-field u-mb-small">
                                        <label class="c-field__label" for="web_whatsapp">Whatsapp</label> 
                                        <input class="span12" type="text" id="web_whatsapp" name="web_whatsapp" placeholder="" value="{{ $DB_HomeSettings->whatsapp }}"> 
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="control-group">
                                            <label class="control-label">Map Adres</label>
                                            <input class="span12" type="text" id="web_address_map" name="web_address_map" placeholder="" value="{{ $DB_HomeSettings->web_address_map }}"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="control-group">
                                            <label class="control-label">Adres</label>
                                            <textarea class="span12" id="web_address" rows="5" cols="80">{!! $DB_HomeSettings->address !!}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row-fluid">
                                    <div class="span6 c-field u-mb-small">
                                        <label class="c-field__label" for="web_facebook">Facebook Url</label> 
                                        <input class="span12" type="text" id="web_facebook" name="web_facebook"  placeholder="" value="{{ $DB_HomeSettings->facebook_Url }}"> 
                                    </div>

                                    <div class="span6 c-field u-mb-small">
                                        <label class="c-field__label" for="web_twitter">Twitter Url</label> 
                                        <input class="span12" type="text" id="web_twitter" name="web_twitter" placeholder="" value="{{ $DB_HomeSettings->twitter_Url }}"> 
                                    </div>
                                </div>

                                <div class="row-fluid">
                                    <div class="span6 c-field u-mb-small">
                                        <label class="c-field__label" for="web_instagram">Instagram Url</label> 
                                        <input class="span12" type="text" id="web_instagram" name="web_instagram"  placeholder="" value="{{ $DB_HomeSettings->instagram_Url }}">  
                                    </div>

                                    <div class="span6 c-field u-mb-small">
                                        <label class="c-field__label" for="web_linkedln">Linkedln Url</label> 
                                        <input class="span12" type="text" id="web_linkedln" name="web_linkedln" placeholder="" value="{{ $DB_HomeSettings->linkedln_Url }}"> 
                                    </div>
                                </div>

                                <div class="row-fluid">
                                    <div class="span12 c-field u-mb-small">
                                        <label class="c-field__label" for="web_youtube">Youtube Url</label> 
                                        <input class="span12" type="text" id="web_youtube" name="web_youtube"  placeholder="" value="{{ $DB_HomeSettings->youtube_Url }}">  
                                    </div>
                                </div>


                              </div>
                               
                              <div class="row-fluid">
                                <button type="button" class="btn btn-success span12" id="socialMedia_Save">@lang('admin.socialMedia') - @lang('admin.save')</button>
                              </div>

                            </form>
                            <!------- Form Son ----------->

                        </div>
                    </div>
                    <!-- Sosyal Ağ Son -->
                </div>
             </div>
            <div class="row-fluid">
                <div class="span6">
                    <!-- Web -->
                    <div class="widget green">
                        <div class="widget-title">
                            <h4><i class="fa fa-edit"></i> Seo </h4>
                        <span class="tools">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-remove"></a>
                        </span>
                        </div>
                        <div class="widget-body">
                            <h1> Seo </h1>

                            <!------- Form ----------->
                            <form class="c-card__body" >
                              
                              <div class="span12">
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="control-group">
                                            <label class="control-label">Seo - @lang('admin.description')</label>
                                            <textarea class="span12" id="seo_description" rows="5" cols="80">{!! $DB_HomeSettings->seo_description !!}</textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="control-group">
                                            <label class="control-label">Seo - Keywords</label>
                                            
                                            <!--------- Tag Input  ----->
                                            <div class="tagInputBox" id="tagInputBox">
                                                <div class="tagLeft">
                                                    <div id="tagItems"></div>
                                                    <input type="text" id="tagInput" value="" data_value="{!! $DB_HomeSettings->seo_keywords !!}">
                                                </div>
                                                <div class="tagRight">
                                                    <div id="tagCopy"><i style="font-size: 24px;" class="fa fa-clone" aria-hidden="true"></i></div>
                                                    <div id="tagCancel"><i style="font-size: 30px; color: red;" class="fa fa-times" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="maxSonuc">Max: 56 karakter:!</div>
                                            <!--------- Tag Input Son  ----->
                                            
                                        </div>
                                    </div>
                                </div>
                              </div>
                               
                              <div class="row-fluid">
                                <button type="button" class="btn btn-info span12" id="seo_Save">Seo - @lang('admin.save')</button>
                              </div>

                            </form>
                            <!------- Form Son ----------->
                            
                        </div>
                    </div>
                    <!-- Web -->
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
   <script src="{{asset('/assets/admin')}}/js/web/web_settings.js"></script>
    
</body>
<!-- END BODY -->
</html>