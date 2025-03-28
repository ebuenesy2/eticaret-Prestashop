<!DOCTYPE html>

<!-- Head -->
<title> @lang('admin.blogCategory') | {{ config('admin.Admin_Title') }} </title>
@include('admin.include.head')

<!-- Tanım -->
<?php $homeUrl = '/admin'; ?>
<?php $listTitle = __('admin.blogCategory') ?>
<?php $listUrl = "/admin/blog/category";  ?>

<!-- Yıldırımdev Table Css -->
<link href="{{asset('/assets/admin/yildirimdev')}}/css/yildirimdev_table.css" rel="stylesheet" type="text/css" />

<!-- BEGIN BODY -->
<body class="fixed-top" id="listInfoData" page={{$page}} rowCountData={{$rowcount}} orderData={{$order}} > 
    
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

              <!--- List -->
              <div class="widget red">
                  <div class="widget-title">
                    <h4><i class="fa fa-edit"></i> {{$listTitle}} </h4>
                    <span class="tools">
                        <a href="javascript:;" class="fa fa-chevron-down"></a>
                        <a href="javascript:;" class="fa fa-remove"></a>
                    </span>
                  </div>
                  <div class="widget-body">
                    <div>
                      <div class="clearfix">
                         
                        <div style="display:flex;gap: 5px;flex-wrap: wrap;margin-bottom: 25px;" >

                          <!-- Modal -->
                          <button class="btn btn-success" href="#addModal" role="button" data-toggle="modal" >
                            <i class="fa fa-plus icon-white"></i> @lang('admin.newAdd')  
                          </button>
                          <!-- Modal Son -->

                          <div id='loader' style="display: flex;width: 20px;"><img src="/upload/images/loader.gif" alt=""></div>

                        </div>                          

                        <!------  Tablo Üst - Arama ----->
                        <div class="row-fluid" style="margin-top:10px;display: flex;gap: 5px;flex-wrap: wrap;" >

                          <!------ Arama ID ----->
                          <div style="display: flex;flex-direction: column;">
                            <p>Uid</p>
                            <input type="number" placeholder="uid" class="" id="searchTable" searchName="uid" style="width: 120px;" >
                          </div>
                          <!------ Arama ID Son----->
                                                    
                          <!------ Arama Durum ----->
                          <div style="display: flex;flex-direction: column;" >
                            <p>@lang('admin.status')</p>
                            <select class="" style="cursor: pointer; width: 120px;" id="searchTable" searchName="Status"  >
                                <option value="">@lang('admin.all')</option>
                                <option value="1">@lang('admin.active')</option>
                                <option value="0">@lang('admin.passive')</option>
                            </select>
                          </div>
                          <!------ Arama Durum Son----->
                          
                        </div>
                        <!------  Tablo Üst -Arama Son ----->

                        <!------ Tablo Ayarları -->
                        <div id="choosedPanel" class="row-fluid"  style="margin-top:10px;display: none;gap: 5px;flex-wrap: wrap;" >
                        
                          <!-- Tablo İşlemi -->
                          <select  style="cursor: pointer;width: max-content;" id="tableSettings" >
                            <option value="delete" selected>@lang('admin.delete')</option>
                            <option value="edit_active" >@lang('admin.active')</option>
                            <option value="edit_passive" >@lang('admin.passive')</option>
                            <option value="multi_createClone" >@lang('admin.createClone')</option>
                          </select>
                          <!-- Tablo İşlemi Son -->

                          <div >
                            <button class="btn btn-success" id="multiAction" >@lang('admin.multitask')</button>
                          </div>

                        </div>
                        <!------ Tablo Ayarları Son -->
                        
                        <!------  Tablo ----->
                        <div class="table-container">
                            
                          <table>
                              <thead>
                                
                                <!---- Tümü Seç --->
                                <th data-cell="Tümü Seç" style="margin: auto;"><input type="checkbox" id="showAllRows" value="all"  data_count="0"  data_value=""  ></th>

                                <th class="table_title" exportName="id" >Uid</th>
                                <th class="table_title" exportName="id" >@lang('admin.image')</th>
                                <th class="table_title" exportName="id" >@lang('admin.title')</th>
                                <th class="table_title" exportName="id" exportName="isActive" exportType="number" >@lang('admin.status')</th>
                                <th class="table_title" exportName="id" >@lang('admin.actions')</th>

                              </thead>
                            <tbody role="alert" aria-live="polite" aria-relevant="all">
                            
                              @for ($i = 0; $i < count($dbFind); $i++)
                              <tr>

                                  <!---- Seç --->
                                  <td data-cell="Seç"  class="c-table__cell"><input type="checkbox" id="checkItem" data_check_id="{{$dbFind[$i]->uid}}" > </td>

                                  <td data-cell="Uid" >{{$dbFind[$i]->uid}}</td>
                                  <td data-cell="@lang('admin.image')" ><img id="imgItem" href="#imgModal" data-toggle="modal" data_uid="{{$dbFind[$i]->uid}}" src="{{$dbFind[$i]->img_url}}" style="margin: auto;cursor:pointer;min-width: 40px;width: 50px;max-width: 100%;"  ></td>
                                  <td data-cell="@lang('admin.title')">{{$dbFind[$i]->title}}</td>

                                  <td data-cell="@lang('admin.status')">
                                    <span style="margin: auto;" class="alert {{$dbFind[$i]->isActive ? 'alert-success' : 'alert-error' }}" data_value="{{$dbFind[$i]->isActive}}" >{{$dbFind[$i]->isActive ? __('admin.active') : __('admin.passive')  }}</span>
                                  </td>

                                  <td data-cell="@lang('admin.actions')" >
                                    <button class="btn {{$dbFind[$i]->isActive ? 'btn-success ' : 'btn-danger '}}" id="statusItem" data_uid="{{$dbFind[$i]->uid}}" data_isActive="{{$dbFind[$i]->isActive}}"  ><i data_uid="{{$dbFind[$i]->uid}}" data_isActive="{{$dbFind[$i]->isActive}}"  class="{{$dbFind[$i]->isActive ? 'icon-eye-open' : ' icon-eye-close'}}"></i></button>
                                    <button class="btn btn-success" title="clone" id="cloneItem" data_uid="{{$dbFind[$i]->uid}}" ><i data_uid="{{$dbFind[$i]->uid}}" class=" icon-copy"></i></button>
                                    <button class="btn btn-primary" title="modal edit"  id="editItem" href="#editModal" data-toggle="modal" data_uid="{{$dbFind[$i]->uid}}" ><i data_uid="{{$dbFind[$i]->uid}}" class="fa fa-pencil"></i></button>
                                    <button class="btn btn-danger" id="deleteItem" data_uid="{{$dbFind[$i]->uid}}"><i data_uid="{{$dbFind[$i]->uid}}" class="fa fa-trash "></i></button>
                                  </td>
                              </tr>
                              @endfor

                            </tbody>
                          </table>
                          
                          @if(count($dbFind) == 0 )  <p> @lang('admin.dataNotFound') </p> @endif

                        </div>
                        <!------  Tablo Son -->

                        <!------ Tablo Alt  -->
                        <div class="row-fluid" style="margin-top:10px;">

                          <!-- Sıralama -->
                          <div class="span3">
                            <select  class="" style="cursor: pointer;" id="searchTable" searchName="order">
                              <option value="desc" selected>@lang('admin.largeToSmal')  [DESC] </option>
                              <option value="asc">@lang('admin.smalToLarge') [ASC]</option>
                            </select>
                          </div>
                          <!-- Sıralama Son -->

                          <!-- Sayfa Başı -->
                          <div class="span1">
                            <select  class="" style="cursor: pointer;width: 75px;" id="searchTable" searchName="rowcount">
                              <option value="all">@lang('admin.all')</option>  
                              <option value="10" selected="selected">10</option>
                              <option value="15">15</option>
                              <option value="20">20</option>
                              <option value="25">25</option>
                              <option value="50">50</option>
                            </select>
                          </div>
                          <div class="span2">
                            <div class="dataTables_info" id="editable-sample_info"> @lang('admin.numberOfData') : {{$dbSize}} / {{$dbTop}}</div>
                          </div>
                          <!-- Sayfa Başı Son -->

                          <!------  Pagination  -->
                          <div class="span6">
                            <div class="dataTables_paginate paging_bootstrap pagination">
                              <ul>
                                <li class="prev {{$pagination['prev']['page'] ? '' : 'disabled' }}"><a href="{{$pagination['prev']['url']}}">← @lang('admin.back')</a></li>
                                @for ($i = 0; $i < count($pagination["items"]); $i++)
                                <li class="{{$pagination['current'] == $pagination['items'][$i]['page'] ? 'active' :'' }}"><a href="{{$pagination['items'][$i]['url']}}">{{$pagination["items"][$i]['title']}}</a></li>
                                @endfor
                                <li class="next {{$pagination['next']['page'] ? '' : 'disabled' }}"><a href="{{$pagination['next']['url']}}">@lang('admin.next') → </a></li>
                              </ul>
                            </div>
                          </div>
                          <!------  Pagination Son -->

                        </div>
                        <!------ Tablo Alt Son -->

                    </div>
                  </div>
              </div>
              <!--- List Son -->
              
             </div>
            <!-- END PAGE CONTENT-->
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->
   </div>
   <!-- END CONTAINER -->

  <!--************* Modal *********--->
    
  <!----  Modal IMG -->
  <div id="imgModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="imgModalLabel" aria-hidden="true">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="imgModalTitle" style="display: flex;" ><p>@lang('admin.image') #</p><p id="imgModalValueId">54</p> </h3>
      </div>
      <div class="modal-body">
        <div class="row-fluid">
          <div class="span12">
              <div class="control-group">
                 <div class="controls controls-row" style="display: flex;justify-content: center;" >
                      <img id="imgView" src="" alt="" style="width: 180px;">
                  </div>
              </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">@lang('admin.close')</button>
      </div>
  </div>
  <!----  Modal IMG Son -->

  <!----  Modal Ekleme -->
  <div id="addModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="addModalLabel">@lang('admin.newAdd')</h3>
        <div id='loaderAdd' style="display: none;width: 20px;"><img src="/upload/images/loader.gif" alt=""></div>
      </div>
      <div class="modal-body">
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
        <div class="row-fluid">
          <div class="span6">
              <div class="control-group">
                <label class="control-label">@lang('admin.title') TR</label>
                <div class="controls controls-row">
                    <input type="text" class="input-block-level" name="titleAdd_TR" id="titleAdd_TR" placeholder="@lang('admin.title')" value="" focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="1" >
                </div>
              </div>
          </div>
          <div class="span6">
              <div class="control-group">
                <label class="control-label">@lang('admin.title') EN</label>
                <div class="controls controls-row">
                    <input type="text" class="input-block-level" name="titleAdd_EN" id="titleAdd_EN" placeholder="@lang('admin.title')" value="" focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="2" >
                </div>
              </div>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span12">
              <div class="control-group">
                <label class="control-label">@lang('admin.title') DE</label>
                <div class="controls controls-row">
                    <input type="text" class="input-block-level" name="titleAdd_DE" id="titleAdd_DE" placeholder="@lang('admin.title')" value="" focusType ="true" focusControl="add" focusControl_Active="true" focusOrder="3" >
                </div>
              </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">@lang('admin.close')</button>
        <button class="btn btn-info" id="reset_add" >@lang('admin.reset')</button>
        <button class="btn btn-success" id="new_add" >@lang('admin.add')</button>
      </div>
  </div>
  <!----  Modal Ekleme Son -->

  <!----  Modal Güncelle -->
  <div id="editModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="editModalTitle" style="display: flex;" ><p>@lang('admin.edit') #</p><p id="editModalValueId">54</p> </h3>
          <div id='loaderEdit' style="display: flex;width: 20px;"><img src="/upload/images/loader.gif" alt=""></div>
      </div>
      <div class="modal-body">
        <div class="row-fluid">
            <div class="span6">
                <div class="control-group">
                    <label class="control-label">Kapak Resmi</label>
                    <div class="controls controls-row">

                        <!-- Dosya Yükleme Kutusu ----->
                        <div style="border: 2px solid;padding: 10px;">

                            <!-- Dosya Yükleme ----->
                            <form method="POST" id="uploadForm2" enctype="multipart/form-data">
                                <div style="display: flex;flex-direction: column; gap: 15px;">

                                    <!-- Dosya Yükleme Bilgileri ----->
                                    <input type="hidden" name="fileDbSaveEdit" id="fileDbSaveEdit" value="true" >
                                    <input type="hidden" name="fileWhereEdit" id="fileWhereEdit" value="Sabit" >

                                    <!---  Loading --->
                                    <div id="LoadingFileUploadEdit" style="display:none;" ><span class="d-flex align-items-center">
                                        <span class="spinner-border flex-shrink-0" role="status"></span>
                                        <span class="flex-grow-1 ms-2">@lang('admin.loading') </span>
                                    </span> </div>
                                    <div id="uploadStatusEdit"></div>
                                    <!--- End Loading --->

                                    <input type="file" name="fileEdit" id="fileInputEdit" style="display: flex; color: steelblue; margin-left: 10px; ">
                                    <div style="display: flex; gap: 10px; margin-bottom: -25px;" ><p>@lang('admin.fileUrl'):</p><p id="filePathUrlEdit"></p></div>
                                    <button type="button" id="fileUploadClickEdit" class="btn btn-success" style="cursor:pointer; background-image: linear-gradient(#04519b, #033c73 60%, #02325f);color: #ffffff;border-bottom: 1px solid #022241;padding: 12px;border-radius: 6px;display: flex; gap:10px; justify-content: center;align-items: center;">
                                        <i class="ri-folder-upload-line" style="margin-top: -8px;  margin-bottom: -8px; font-size: 24px;"></i> 
                                        <p style=" color: blanchedalmond; font-size: 14px; font-weight: bold; " > @lang('admin.fileUpload') </p>
                                    </button>
                                    
                                    <!-- ProgressBar ---->
                                    <div class="progress" style="margin-top: 14px;height: auto;">
                                        <div class="progress-bar" id="progressBarFileUploadEdit" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;background-color: teal;color: rgb(255, 255, 255);border-radius: 6px;display: flex;justify-content: center;"></div>
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
                        <img class="img-circle img-thumbnail" src="{{config('admin.Default_ImgUrl')}}" id="fileUploadImageEdit" style="width: 100%;height: 230px;object-fit: contain;" >
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
          <div class="span6">
              <div class="control-group">
                <label class="control-label">@lang('admin.title') TR</label>
                <div class="controls controls-row">
                    <input type="text" class="input-block-level" name="titleEdit_TR" id="titleEdit_TR" placeholder="@lang('admin.title')" value="" focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="1" >
                </div>
              </div>
          </div>
          <div class="span6">
              <div class="control-group">
                <label class="control-label">@lang('admin.title') EN</label>
                <div class="controls controls-row">
                    <input type="text" class="input-block-level" name="titleEdit_EN" id="titleEdit_EN" placeholder="@lang('admin.title')" value="" focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="2" >
                </div>
              </div>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span12">
              <div class="control-group">
                <label class="control-label">@lang('admin.title') DE</label>
                <div class="controls controls-row">
                    <input type="text" class="input-block-level" name="titleEdit_DE" id="titleEdit_DE" placeholder="@lang('admin.title')" value="" focusType ="true" focusControl="edit" focusControl_Active="true" focusOrder="3" >
                </div>
              </div>
          </div>
        </div>
      
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">@lang('admin.close')</button>
        <button class="btn btn-success" id="edit_item">@lang('admin.edit')</button>
      </div>
  </div>
  <!----  Modal Güncelle Son -->
  <!--************* Modal Son *********--->


  <footer>
    <!-- Footer -->
    @include('admin.include.footer')

    <!------- JS --->
    <script src="{{asset('/assets/admin')}}/js/01_0_sabit_list/00_list_search.js"></script>
    <script src="{{asset('/assets/admin')}}/js/web/blog/blog_category.js"></script>
        
    <!-- Yıldırımdev Table JS -->
    <script src="{{asset('/assets/admin/yildirimdev')}}/js/yildirimdev_table.js"></script>

  </footer>

</body>
<!-- END BODY -->
</html>
