<!DOCTYPE html>

<!-- Head -->
<title> @lang('admin.comments') - @lang('admin.newAdd') | {{ config('admin.Admin_Title') }} </title>
@include('admin.include.head')

<!-- Tanım -->
<?php $homeUrl = '/admin'; ?>
<?php $listTitle = __('admin.comments') ?>
<?php $listUrl = "/admin/comment";  ?>

<!-- BEGIN BODY -->
<body class="fixed-top" id="dataValueInfo" data_action="add" data_uid="{{time()}}">
    
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
                <h3 class="page-title"> {{$listTitle}} - @lang('admin.add') </h3>
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
                    <li class="active"> {{$listTitle}} - @lang('admin.add') </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->

               </div>
            </div>

            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
             <div class="row-fluid">
                <div class="span6" id="leftAdd">
                    <!-- BEGIN BLANK PAGE PORTLET-->
                    <div class="widget red">
                        <div class="widget-title">
                            <h4><i class="fa fa-edit"></i> @lang('admin.image') - @lang('admin.add') </h4>
                            <div id='loaderAdd' lang="tr" style="display: none;width: 20px;"><img src="/upload/images/loader.gif" alt=""></div>
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
                                            <input type="text" class="input-block-level" name="nameAdd" id="nameAdd"  placeholder="@lang('admin.name')" value="" >
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.surname')</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="surnameAdd" id="surnameAdd"  placeholder="@lang('admin.surname')" value="" >
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
                                            <img class="img-circle img-thumbnail" src="{{config('admin.Default_ImgUrl')}}" id="fileUploadImage" style="width: 100%;height: 230px;object-fit: contain;" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END BLANK PAGE PORTLET-->
                </div>
                <div class="span6" >
                    <!-- BEGIN BLANK PAGE PORTLET-->
                    <div class="widget red">
                        <div class="widget-title">
                            <h4><i class="fa fa-edit"></i> @lang('admin.add') </h4>
                            <div id='loaderAdd' lang="tr" style="display: none;width: 20px;"><img src="/upload/images/loader.gif" alt=""></div>
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
                                            <input type="text" class="input-block-level" name="roleAdd" id="roleAdd"  lang="tr" placeholder="@lang('admin.role')" value="" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.comment')</label>
                                        <div class="controls controls-row">
                                            <textarea  id="editor1" rows="10" cols="80"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div  class="row-fluid" >
                               <button class="btn btn-success" id="new_add" lang="tr" style="width: 100%;" >@lang('admin.add')</button>
                            </div>

                        </div>
                           
                    </div>
                    <!-- END BLANK PAGE PORTLET-->
                </div>
             </div>
             <div class="row-fluid">
                <div class="span6" id="leftAdd">
                    <!-- BEGIN BLANK PAGE PORTLET-->
                    <div class="widget blue">
                        <div class="widget-title">
                            <h4><i class="fa fa-edit"></i> @lang('admin.add') En </h4>
                            <div  id='loaderAdd' lang="en" style="display: none;width: 20px;"><img src="/upload/images/loader.gif" alt=""></div>
                            <span class="tools">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.role') - EN</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="roleAdd" id="roleAdd"  lang="en"  placeholder="@lang('admin.role')" value="" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.comment') - EN</label>
                                        <div class="controls controls-row">
                                            <textarea  id="editor2" rows="10" cols="80"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div  class="row-fluid" >
                               <button class="btn btn-success" id="new_add" lang="en" style="width: 100%;" >@lang('admin.add') En </button>
                            </div>

                        </div>
                           
                    </div>
                    <!-- END BLANK PAGE PORTLET-->
                </div>
                <div class="span6">
                    <!-- BEGIN BLANK PAGE PORTLET-->
                    <div class="widget yellow">
                        <div class="widget-title">
                            <h4><i class="fa fa-edit"></i> @lang('admin.add') De </h4>
                            <div  id='loaderAdd' lang="de" style="display: none;width: 20px;"><img src="/upload/images/loader.gif" alt=""></div>
                        <span class="tools">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-remove"></a>
                        </span>
                        </div>
                        <div class="widget-body">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.role') De</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="roleAdd" id="roleAdd" lang="de" placeholder="@lang('admin.role')" value="" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.comment')  De</label>
                                        <div class="controls controls-row">
                                            <textarea  id="editor3" rows="10" cols="80"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div  class="row-fluid" >
                               <button class="btn btn-success" id="new_add" lang="de" style="width: 100%;" >@lang('admin.add') De</button>
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
   <script src="{{asset('/assets/admin')}}/js/web/comment/comment_actions.js"></script>

    <!----  ckeditor --->
    <script src="{{asset('/assets/admin')}}/js/ckeditor/ckeditor.js"></script>
    
    <!----  Textarea id aynı olmalı --->
    <script>CKEDITOR.replace('editor1'); </script>
    <script>CKEDITOR.replace('editor2'); </script>
    <script>CKEDITOR.replace('editor3'); </script>
    
</body>
<!-- END BODY -->
</html>