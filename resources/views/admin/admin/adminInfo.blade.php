<!DOCTYPE html>

<!-- Head -->
<title> @lang('admin.adminInfo') | {{ config('admin.Admin_Title') }} </title>
@include('admin.include.head')

<!-- Tanım -->
<?php $homeUrl = '/admin'; ?>
<?php $listTitle = __('admin.adminInfo'); ?>
<?php $listUrl = "/admin";  ?>

<!----- Css ------> 
<link rel="stylesheet" type="text/css" href="{{asset('/assets/admin')}}/css/userInfo.css" />

<!-- BEGIN BODY -->
<body class="fixed-top" id="adminInfo" adminId="{{$DB_Find->id}}"  >
    
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
                    <div id='loader' style="display: flex;width: 20px;"><img src="/upload/images/loader.gif" alt=""></div>
                    <ul class="breadcrumb">
                        <li>
                            <a href="/@lang('admin.lang'){{$homeUrl}}">@lang('admin.home')</a>
                            <span class="divider">/</span>
                        </li>
                        <li>
                            <a href="/@lang('admin.lang'){{$listUrl}}/list">@lang('admin.adminList')</a>
                            <span class="divider">/</span>
                        </li>
                        <li class="active"> {{$listTitle}} </li>
                    </ul>
                    <!-- END PAGE TITLE & BREADCRUMB-->

                    <!-- İşlemler -->
                    <ul class="breadcrumb">
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
                <div class="rowUser">
                    <div class="rowUserLeft">
                        <div class="text-center card-box">
                            <div class="member-card">
                                <div class="thumb-xl member-thumb m-b-10 center-block">
                                  <img src="{{$DB_Find->img_url}}" class="img-circle img-thumbnail" alt="profile-image">
                                </div>
                                <div style="margin-bottom: 15px;" >
                                    <h4 class="m-b-5" style="color: white;" >{{$DB_Find->name}} {{$DB_Find->surname}}</h4>
                                    <span style="margin: auto;" class="alert {{$DB_Find->isActive ? 'alert-success' : 'alert-error' }}">{{$DB_Find->isActive ? __('admin.active') : __('admin.passive')  }}</span>
                                </div>
                                <div class="text-left m-t-40">
                                    <p class="text-muted font-13"><strong>Telefon :</strong><span class="m-l-15">{{$DB_Find->phone}}</span></p>
                                    <p class="text-muted font-13"><strong>Email :</strong> <span class="m-l-15"><a target="_blank" href="mailto:{{$DB_Find->email}}">[{{$DB_Find->email}}]</a></span></p>
                                    <p class="text-muted font-13"><strong>Doğum Tarihi :</strong> <span class="m-l-15">{{$DB_Find->dateofBirth}}</span></p>
                                </div>
                              
                            </div>
                        </div> 
                           
                    </div> 
                    <div class="rowUserRight">
                        <div class="">
                            <div class="">
                                <ul class="nav nav-tabs navtab-custom">
                                    <li class="active">
                                        <a href="#home" data-toggle="tab" aria-expanded="true">
                                            <span class="visible-xs"><i class="fa fa-user"></i></span>
                                            <span class="hidden-xs">@lang('admin.adminInfo')</span>
                                        </a>
                                    </li>
                                    <li class="hidden">
                                        <a href="#profile" data-toggle="tab" aria-expanded="false">
                                            <span class="visible-xs"><i class="fa fa-photo"></i></span>
                                            <span class="hidden-xs">@lang('admin.authorizationList')</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="home">
                                        <div class="span12 bio form">
                                            <h2> @lang('admin.adminInfo') </h2>
                                            
                                            <div class="row-fluid">
                                                <div class="span6">
                                                    <div class="control-group">
                                                        <label class="control-label">@lang('admin.name')</label>
                                                        <div class="controls controls-row">
                                                            <input type="text" class="input-block-level" name="userName" id="userName" placeholder="@lang('admin.name')" value="{{$DB_Find->name}}" focusType ="true" focusControl="edit_user" focusControl_Active="false" focusOrder="1" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span6">
                                                    <div class="control-group">
                                                        <label class="control-label">@lang('admin.surname')</label>
                                                        <div class="controls controls-row">
                                                            <input type="text" class="input-block-level" name="userSurname" id="userSurname" placeholder="@lang('admin.surname')" value="{{$DB_Find->surname}}" focusType ="true" focusControl="edit_user" focusControl_Active="false" focusOrder="2" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="span6">
                                                    <div class="control-group">
                                                        <label class="control-label">@lang('admin.phone')</label>
                                                        <div class="controls controls-row">
                                                            <input type="text" data-mask="(999) 999-9999" class="input-block-level" name="userPhone" id="userPhone" placeholder="Telefon Numarası" value="{{$DB_Find->phone}}" focusType ="true" focusControl="edit_user" focusControl_Active="false" focusOrder="3" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span6">
                                                    <div class="control-group">
                                                        <label class="control-label">@lang('admin.email')</label>
                                                        <div class="controls controls-row">
                                                            <input type="text" class="input-block-level" name="userEmail" id="userEmail" placeholder="@lang('admin.email')" value="{{$DB_Find->email}}" disabled >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="span6">
                                                    <div class="control-group">
                                                        <label class="control-label">@lang('admin.dateOfBirth')</label>
                                                        <div class="controls controls-row">
                                                           <input type="date" class="input-block-level" id="userDateofBirth" name="userDateofBirth" value="{{$DB_Find->dateofBirth}}" focusType ="true" focusControl="edit_user" focusControl_Active="false" focusOrder="4" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span6">
                                                    <div class="control-group">
                                                        <label class="control-label">@lang('admin.role')</label>
                                                        <div class="controls controls-row">
                                                            <select class="span12" style="cursor: pointer;" name="userRole" id="userRole" focusType ="true" focusControl="edit_user" focusControl_Active="false" focusOrder="5" >
                                                                @for ($i = 0; $i < count($DB_Find_roles); $i++)
                                                                 <option value="{{$DB_Find_roles[$i]->id}}" {{ $DB_Find->role_id == $DB_Find_roles[$i]->id ? 'selected' : ''}} >{{$DB_Find_roles[$i]->title}}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="span6">
                                                    <div class="control-group">
                                                        <label class="control-label">@lang('admin.department')</label>
                                                        <div class="controls controls-row">
                                                            <select class="span12" style="cursor: pointer;" name="userDepartman" id="userDepartman" focusType ="true" focusControl="edit_user" focusControl_Active="true" focusOrder="6" >
                                                                @for ($i = 0; $i < count($DB_Find_departman); $i++)
                                                                 <option value="{{$DB_Find_departman[$i]->id}}" {{ $DB_Find->departman_id == $DB_Find_departman[$i]->id ? 'selected' : ''}} >{{$DB_Find_departman[$i]->title}}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span6">
                                                    <div class="control-group">
                                                        <label class="control-label">@lang('admin.createdDate')</label>
                                                        <div class="controls controls-row">
                                                            <input type="text" class="input-block-level" name="" id="" placeholder="@lang('admin.createdDate')" value="2022-11-16 15:34:01" disabled >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                         
                                            <div class="form-actions">
                                                <button type="button" class="btn btn-success span12"  id="userEdit" >@lang('admin.save')</button>
                                            </div>
                                            <div class="space10"></div>

                                            <h2>@lang('admin.resetMyPassword')</h2>

                                            <div class="widget orange">
                                                <div class="widget-title">
                                                    <h4>@lang('admin.resetMyPassword')</h4>
                                                    <span class="tools">
                                                        <a class="fa fa-chevron-down" href="javascript:;"></a>
                                                    </span>
                                                </div>
                                                <div class="widget-body ">
                                                    <form class="form-horizontal" action="#">
                                                        <div class="control-group">
                                                            <label class="control-label">@lang('admin.password')</label>
                                                            <div class="controls">
                                                                <input type="password" class="span6" id="myPassword" focusType ="true" focusControl="edit_pass" focusControl_Active="false" focusOrder="1" >
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label">@lang('admin.enterUrPassword')</label>
                                                            <div class="controls">
                                                                <input type="password" class="span6 " id="newPassword" focusType ="true" focusControl="edit_pass" focusControl_Active="false" focusOrder="2"  >
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label">@lang('admin.repeatPassword')</label>
                                                            <div class="controls">
                                                                <input type="password" class="span6 " id="rePassword" focusType ="true" focusControl="edit_pass" focusControl_Active="true" focusOrder="3"  >
                                                            </div>
                                                        </div>

                                                        <div class="form-actions">
                                                          <button type="button" class="btn btn-info span12"  id="userPasswordEdit" >@lang('admin.resetMyPassword')</button>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                            
                                            <h2>@lang('admin.editEmail')</h2>

                                            <div class="widget blue">
                                                <div class="widget-title">
                                                    <h4>@lang('admin.editEmail')</h4>
                                                    <span class="tools">
                                                        <a class="fa fa-chevron-down" href="javascript:;"></a>
                                                    </span>
                                                </div>
                                                <div class="widget-body ">
                                                    <form class="form-horizontal" action="#">
                                                        <div class="control-group">
                                                            <label class="control-label">@lang('admin.email')</label>
                                                            <div class="controls">
                                                                <input type="email" class="span6" id="myEmail" focusType ="true" focusControl="edit_mail" focusControl_Active="true" focusOrder="1"  >
                                                            </div>
                                                        </div>
                                                        <div class="form-actions">
                                                          <button type="button" class="btn btn-info span12"  id="userEmailEdit" style="background:blue;" >@lang('admin.editEmail')</button>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                            
                                            <h2> Profil Resmi Güncelle </h2>
                                            <div class="widget green">
                                                <div class="widget-title">
                                                    <h4>Profil Resmi Güncelle </h4>
                                                    <span class="tools">
                                                        <a class="fa fa-chevron-down" href="javascript:;"></a>
                                                    </span>
                                                </div>
                                                <div class="widget-body form">
                                                    <div class="row-fluid">
                                                        <div class="span7">
                                                            <div class="control-group">
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
                                                        <div class="span5">
                                                            <div class="control-group">
                                                                <label class="control-label">@lang('admin.image')</label>
                                                                <div class="controls controls-row">
                                                                    <div class="fileupload-new thumbnail">
                                                                       <img class="img-circle img-thumbnail" src="{{$DB_Find->img_url}}" id="profileImage">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row-fluid" >
                                                       <button class="btn btn-inverse btn-large "  id="userImageEdit" > @lang('admin.editProfileImage') </button>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                            <div class="space20"></div>
                                            <div class="space20"></div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="profile">
                                        <div class="widget">
                                            <div class="widget-title">
                                                <h4></i> @lang('admin.authorizationList')</h4>
                                                <span class="tools"><a href="javascript:;" class="fa fa-chevron-down"></a></span>
                                            </div>
                                            <div class="widget-body">
                                                <ul>
                                                    <li>Kullanıcı Bilgileri Güncelleme</li>
                                                    <li>Kullanıcı Şifre Yenileme</li>
                                                    <li>Kullanıcı İşlem Geçmişi Görüntüleme</li>
                                                    <li>Kullanıcı Liste Ekleme</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
             </div>
            <!-- END PAGE CONTENT-->
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->
   </div>
   <!-- END CONTAINER -->

   <footer>
    <!-- Footer -->
    @include('admin.include.footer')

    <!------- JS --->
    <script src="{{asset('/assets/admin')}}/js/admin/adminEdit.js"></script>
            
    <!-- Yıldırımdev Table JS -->
    <script src="{{asset('/assets/admin/yildirimdev')}}/js/yildirimdev_table.js"></script>

  </footer>
    
</body>
<!-- END BODY -->
</html>