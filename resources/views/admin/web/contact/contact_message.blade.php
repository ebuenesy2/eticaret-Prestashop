<!DOCTYPE html>

<!-- Head -->
<title> @lang('admin.contactMessage') | {{ config('admin.Admin_Title') }} </title>
@include('admin.include.head')

<!-- Tanım -->
<?php $homeUrl = '/admin'; ?>
<?php $listTitle = __('admin.contactMessage'); ?>
<?php $listUrl = "/admin/contact/message";  ?>

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
                            <p>ID</p>
                            <input type="number" placeholder="id" class="" id="searchTable" searchName="Id" style="width: 120px;" >
                          </div>
                          <!------ Arama ID Son----->
                          
                        </div>
                        <!------  Tablo Üst -Arama Son ----->

                        <!------ Tablo Ayarları -->
                        <div id="choosedPanel" class="row-fluid"  style="margin-top:10px;display: none;gap: 5px;flex-wrap: wrap;" >
                        
                          <!-- Tablo İşlemi -->
                          <select  style="cursor: pointer;width: max-content;" id="tableSettings" >
                            <option value="delete" selected>@lang('admin.delete')</option>
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

                                <th class="table_title" exportName="id" >ID</th>
                                <th class="table_title" exportName="id" >@lang('admin.name')</th>
                                <th class="table_title" exportName="id" >@lang('admin.surname')</th>
                                <th class="table_title" exportName="id" >@lang('admin.email')</th>
                                <th class="table_title" exportName="id" >@lang('admin.phone')</th>
                                <th class="table_title" exportName="id" >@lang('admin.subject')</th>
                                <th class="table_title" exportName="id" >@lang('admin.message')</th>
                                <th class="table_title" exportName="id" >@lang('admin.actions')</th>

                              </thead>
                            <tbody role="alert" aria-live="polite" aria-relevant="all">
                            
                              @for ($i = 0; $i < count($dbFind); $i++)
                              <tr>

                                  <!---- Seç --->
                                  <td data-cell="Seç"  class="c-table__cell"><input type="checkbox" id="checkItem" data_check_id="{{$dbFind[$i]->id}}" > </td>

                                  <td data-cell="ID" >{{$dbFind[$i]->id}}</td>
                                  <td data-cell="@lang('admin.name')" >{{$dbFind[$i]->name}}</td>
                                  <td data-cell="@lang('admin.surname')" >{{$dbFind[$i]->surname}}</td>
                                  <td data-cell="@lang('admin.email')" >{{$dbFind[$i]->email}}</td>
                                  <td data-cell="@lang('admin.phone')" >{{$dbFind[$i]->phone}}</td>
                                  <td data-cell="@lang('admin.subject')" >{{$dbFind[$i]->subject}}</td>
                                  <td data-cell="@lang('admin.message')" >{{$dbFind[$i]->message}}</td>

                                  <td data-cell="@lang('admin.actions')" >
                                    <button class="btn btn-success" title="clone" id="cloneItem" data_id="{{$dbFind[$i]->id}}" ><i data_id="{{$dbFind[$i]->id}}" class=" icon-copy"></i></button>
                                    <button class="btn btn-primary" title="modal edit"  id="editItem" href="#editModal" data-toggle="modal" data_id="{{$dbFind[$i]->id}}" ><i data_id="{{$dbFind[$i]->id}}" class="fa fa-pencil"></i></button>
                                    <button class="btn btn-danger" id="deleteItem" data_id="{{$dbFind[$i]->id}}"><i data_id="{{$dbFind[$i]->id}}" class="fa fa-trash "></i></button>
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
                <label class="control-label">@lang('admin.name')</label>
                <div class="controls controls-row">
                    <input type="text" class="input-block-level" name="nameAdd" id="nameAdd" placeholder="@lang('admin.name')" value="" focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="1" >
                </div>
              </div>
          </div>
          <div class="span6">
              <div class="control-group">
                <label class="control-label">@lang('admin.surname')</label>
                <div class="controls controls-row">
                    <input type="text" class="input-block-level" name="surnameAdd" id="surnameAdd" placeholder="@lang('admin.surname')" value="" focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="2" >
                </div>
              </div>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span12">
              <div class="control-group">
                <label class="control-label">@lang('admin.email')</label>
                <div class="controls controls-row">
                    <input type="email" class="input-block-level" name="emailAdd" id="emailAdd" placeholder="@lang('admin.email')" value="" focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="3" >
                </div>
              </div>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span12">
              <div class="control-group">
                <label class="control-label">@lang('admin.phone')</label>
                <div class="controls controls-row">
                    <input type="email" class="input-block-level" name="phoneAdd" id="phoneAdd" placeholder="@lang('admin.phone')" value="" focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="3" >
                </div>
              </div>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span12">
              <div class="control-group">
                <label class="control-label">@lang('admin.subject')</label>
                <div class="controls controls-row">
                    <input type="text" class="input-block-level" name="subjectAdd" id="subjectAdd" placeholder="@lang('admin.subject')" value="" focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="4" >
                </div>
              </div>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span12">
              <div class="control-group">
                <label class="control-label">@lang('admin.message')</label>
                <div class="controls controls-row">
                    <textarea class="span12" id="messageAdd" name="messageAdd" rows="5" cols="80" focusType ="true" focusControl="add" focusControl_Active="true" focusOrder="5"></textarea>
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
                <label class="control-label">@lang('admin.name')</label>
                <div class="controls controls-row">
                    <input type="text" class="input-block-level" name="nameEdit" id="nameEdit" placeholder="@lang('admin.name')" value="" focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="1" >
                </div>
              </div>
          </div>
          <div class="span6">
              <div class="control-group">
                <label class="control-label">@lang('admin.surname')</label>
                <div class="controls controls-row">
                    <input type="text" class="input-block-level" name="surnameEdit" id="surnameEdit" placeholder="@lang('admin.surname')" value="" focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="2" >
                </div>
              </div>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span12">
              <div class="control-group">
                <label class="control-label">@lang('admin.email')</label>
                <div class="controls controls-row">
                    <input type="text" class="input-block-level" name="emailEdit" id="emailEdit" placeholder="@lang('admin.email')" value="" focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="3" >
                </div>
              </div>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span12">
              <div class="control-group">
                <label class="control-label">@lang('admin.phone')</label>
                <div class="controls controls-row">
                    <input type="email" class="input-block-level" name="phoneEdit" id="phoneEdit" placeholder="@lang('admin.phone')" value="" focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="3" >
                </div>
              </div>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span12">
              <div class="control-group">
                <label class="control-label">@lang('admin.subject')</label>
                <div class="controls controls-row">
                    <input type="text" class="input-block-level" name="subjectEdit" id="subjectEdit" placeholder="@lang('admin.subject')" value="" focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="4" >
                </div>
              </div>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span12">
              <div class="control-group">
                <label class="control-label">@lang('admin.message')</label>
                <div class="controls controls-row">
                    <textarea class="span12" id="messageEdit" name="messageEdit" rows="5" cols="80" focusType ="true" focusControl="edit" focusControl_Active="true" focusOrder="5" ></textarea>
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
    <script src="{{asset('/assets/admin')}}/js/web/contact/contact_message.js"></script>
        
    <!-- Yıldırımdev Table JS -->
    <script src="{{asset('/assets/admin/yildirimdev')}}/js/yildirimdev_table.js"></script>

  </footer>

</body>
<!-- END BODY -->
</html>
