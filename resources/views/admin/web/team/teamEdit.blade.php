<!DOCTYPE html>

<!-- Head -->
<title> @lang('admin.ourTeam') - @lang('admin.edit') #{{ $DB_Find->id }} | {{ config('admin.Admin_Title') }} </title>
@include('admin.include.head')

<!-- Tanım -->
<?php $homeUrl = '/admin'; ?>
<?php $listTitle = __('admin.ourTeam') ?>
<?php $listUrl = "/admin/team";  ?>

<!-- BEGIN BODY -->
<body class="fixed-top" id="dataValueInfo" data_action="edit" data_id="{{ $DB_Find->id }}">
    
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
                <h3 class="page-title"  id="dataValueId" data_id="{{ $DB_Find->id }}"  > {{$listTitle}} - @lang('admin.edit') [ #{{ $DB_Find->id }} ] </h3>
                <div id='loader' style="display: flex;width: 20px;"><img src="/upload/images/loader.gif" alt=""></div>
                <ul class="breadcrumb">
                    <li>
                        <a href="/@lang('admin.lang'){{$homeUrl}}">@lang('admin.home')</a>
                        <span class="divider">/</span>
                    </li>
                    <li>
                        <a href="/@lang('admin.lang'){{$listUrl}}/list">{{$listTitle}}</a>
                        <span class="divider">/</span>
                    </li>
                    <li class="active"> {{$listTitle}} - @lang('admin.edit') </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
                                      
                <!-- İşlemler -->
                <ul class="breadcrumb">
                    <li>
                        <button class="btn btn-success" title="clone" id="cloneItem" data_id="{{$DB_Find->id}}" ><i data_id="{{$DB_Find->id}}" class=" icon-copy"></i></button>
                    </li>
                    <li>
                        <button class="btn btn-danger" id="deleteItem" data_id="{{$DB_Find->id}}"><i data_id="{{$DB_Find->id}}" class="fa fa-trash "></i></button>
                    </li>
                </ul>
                <!-- İşlemler Son -->

               </div>
            </div>
         
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
             <div class="row-fluid">
                <div class="span6" id="leftEdit">
                    <!-- BEGIN BLANK PAGE PORTLET-->
                    <div class="widget red">
                        <div class="widget-title">
                            <h4><i class="fa fa-edit"></i> @lang('admin.image') - @lang('admin.edit')  </h4>
                            <div id='loaderEdit' style="display: none;width: 20px;"><img src="/upload/images/loader.gif" alt=""></div>
                        <span class="tools">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-remove"></a>
                        </span>
                        </div>
                        <div class="widget-body">
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.name')</label>
                                        <div class="controls controls-row">
                                          <input type="text" class="input-block-level" name="nameEdit" id="nameEdit"  placeholder="@lang('admin.name')" value="{{$DB_Find->name}}" >
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.surname')</label>
                                        <div class="controls controls-row">
                                           <input type="text" class="input-block-level" name="surnameEdit" id="surnameEdit"  placeholder="@lang('admin.surname')" value="{{$DB_Find->surname}}" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">Kapak Resmi</label>
                                        <div class="controls controls-row">

                                            <!-- Dosya Yükleme Kutusu ----->
                                            <div style="border: 2px solid;padding: 10px;">

                                                <!-- Dosya Yükleme ----->
                                                <form method="POST" id="uploadForm" enctype="multipart/form-data">
                                                    <div style="display: flex;flex-direction: column; gap: 15px;">

                                                        <!-- Dosya Yükleme Bilgileri ----->
                                                        <input type="hidden" name="fileDbSave" id="fileDbSave" value="true" >
                                                        <input type="hidden" name="fileWhere" id="fileWhere" value="Sabit" >

                                                        <!---  Loading --->
                                                        <div id="LoadingFileUpload" style="display:none;" ><span class="d-flex align-items-center">
                                                            <span class="spinner-border flex-shrink-0" role="status"></span>
                                                            <span class="flex-grow-1 ms-2">@lang('admin.loading') </span>
                                                        </span> </div>
                                                        <div id="uploadStatus"></div>
                                                        <!--- End Loading --->

                                                        <input type="file" name="file" id="fileInput" style="display: flex; color: steelblue; margin-left: 10px; ">
                                                        <div style="display: flex; gap: 10px; margin-bottom: -25px;" ><p>@lang('admin.fileUrl'):</p><p id="filePathUrl"></p></div>
                                                        <button type="button" id="fileUploadClick" class="btn btn-success" style="cursor:pointer; background-image: linear-gradient(#04519b, #033c73 60%, #02325f);color: #ffffff;border-bottom: 1px solid #022241;padding: 12px;border-radius: 6px;display: flex; gap:10px; justify-content: center;align-items: center;">
                                                            <i class="ri-folder-upload-line" style="margin-top: -8px;  margin-bottom: -8px; font-size: 24px;"></i> 
                                                            <p style=" color: blanchedalmond; font-size: 14px; font-weight: bold; " > @lang('admin.fileUpload') </p>
                                                        </button>
                                                        
                                                        <!-- ProgressBar ---->
                                                        <div class="progress" style="margin-top: 14px;height: auto;">
                                                            <div class="progress-bar" id="progressBarFileUpload" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;background-color: teal;color: rgb(255, 255, 255);border-radius: 6px;display: flex;justify-content: center;"></div>
                                                        </div>
                                                        <!-- ProgressBar Son ---->
                                                        
                                                    </div>
                                                </form>
                                                <!-- Dosya Yükleme Son ---->

                                            </div>
                                            <!-- Dosya Yükleme Kutusu Son ----->

                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.image')</label>
                                        <div class="controls controls-row">
                                           <img class="img-circle img-thumbnail" src="{{$DB_Find->img_url}}" id="fileUploadImage" style="width: 100%;height: 360px;object-fit: contain;" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                           
                    </div>
                    <!-- END BLANK PAGE PORTLET-->
                </div>
                <div class="span6">
                    <!-- BEGIN BLANK PAGE PORTLET-->
                    <div class="widget green">
                        <div class="widget-title">
                            <h4><i class="fa fa-edit"></i> @lang('admin.edit') </h4>
                            <div id='loaderEdit' style="display: none;width: 20px;"><img src="/upload/images/loader.gif" alt=""></div>
                        <span class="tools">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-remove"></a>
                        </span>
                        </div>
                        <div class="widget-body">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.role')</label>
                                        <div class="controls controls-row">
                                          <input type="text" class="input-block-level" name="roleEdit" id="roleEdit"  placeholder="@lang('admin.role')" value="{{$DB_Find->role}}" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.phone')</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="phoneEdit" id="phoneEdit"  placeholder="@lang('admin.phone')" value="{{$DB_Find->phone}}" >
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.phone') 2</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="phone2Edit" id="phone2Edit"  placeholder="@lang('admin.phone') 2" value="{{$DB_Find->phone2}}" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">Facebook Url</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="facebookUrlEdit" id="facebookUrlEdit"  placeholder="Facebook Url" value="{{$DB_Find->facebook_url}}" >
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">Twitter Url</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="twitterUrlEdit" id="twitterUrlEdit"  placeholder="Twitter Url" value="{{$DB_Find->twitter_url}}" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">Instagram Url</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="instagramUrlEdit" id="instagramUrlEdit"  placeholder="Instagram Url" value="{{$DB_Find->instagram_url}}" >
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">Linkedin Url</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="linkedinUrlEdit" id="linkedinUrlEdit"  placeholder="Linkedin Url" value="{{$DB_Find->linkedin_url}}" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="control-group">
                                        <label class="control-label">Web Url</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="webUrlEdit" id="webUrlEdit"  placeholder="Web Url" value="{{$DB_Find->web_url}}" >
                                        </div>
                                    </div>
                                </div>
                            </div>                           

                            <div class="row-fluid" >
                               <button class="btn btn-success" id="edit_item" style="width: 100%;" >@lang('admin.edit')</button>
                            </div>

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

   <!------- Js --->
   <script src="{{asset('/assets/admin')}}/js/web/team/team_actions.js"></script>
    
</body>
<!-- END BODY -->
</html>