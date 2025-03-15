<!DOCTYPE html>

<!-- Head -->
<title> @lang('admin.logList') | {{ config('admin.Admin_Title') }} </title>
@include('admin.include.head')

<!-- Tanım -->
<?php $homeUrl = '/admin'; ?>
<?php $listTitle = __('admin.logList'); ?>
<?php $listUrl = "/admin/setting/menu";  ?>

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

                          <div id='loader' style="display: flex;width: 20px;"><img src="/upload/images/loader.gif" alt=""></div>

                        </div>                          

                        <!------  Tablo Üst - Arama ----->
                        <div class="row-fluid" style="margin-top:10px;display: flex;gap: 5px;flex-wrap: wrap;" >

                            <!-- Arama Id -->
                            <div style="display: flex;flex-direction: column;width: max-content;gap: 3px;">
                                <p>Id</p>
                                <input type="text" class="" style="margin-top: -10px;" placeholder="id"  id="searchTable" searchName="Id" >
                            </div>

                            <!-- Arama Kullanıcı -->
                            <div style="display: flex;flex-direction: column;width: max-content;gap: 3px;">
                                <p>Kullanıcı</p>
                                <input type="text" class="" style="margin-top: -10px;" placeholder="CreatedById" id="searchTable" searchName="CreatedById" >
                            </div>

                            <!-- Arama Takvim-->
                            <div style="display: flex;flex-direction: column;width: max-content;gap: 3px;">
                                <p>Takvim</p>
                                <input type="date" class="" style="margin-top: -10px; cursor: pointer;"  id="searchTable" searchName="CreatedDate" >
                            </div>

                            <!-- Arama Takvim Arası -->
                            <div style="display: flex;flex-direction: column;width: max-content;gap: 3px;">
                                <p>Takvim Az</p>
                                <input type="date" class="" style="margin-top: -10px; cursor: pointer;"  id="searchTable" searchName="CreatedDateBottom" >
                            </div>

                            <div style="display: flex;flex-direction: column;width: max-content;gap: 3px;">
                                <p>Takvim Fazla</p>
                                <input type="date" class="" style="margin-top: -10px; cursor: pointer;"  id="searchTable" searchName="CreatedDateTop" >
                            </div>
                            <!-- Arama Takvim Arası Son -->

                            <!-- Arama Servis Veri Tabanı -->
                            <div style="display: flex;flex-direction: column;width: max-content;gap: 3px;">
                                <p>Servis Veri Tabanı</p>
                                <input type="text" class="" style="margin-top: -10px;" placeholder="ServiceDbStart"  id="searchTable" searchName="ServiceDbStart" >
                            </div>
                            <!-- Arama Servis Veri Tabanı Son -->

                            <!-- Arama Servis Kodu -->
                            <div style="display: flex;flex-direction: column;width: max-content;gap: 3px;">
                                <p>Servis Kodu</p>
                                <select class="" style="margin-top: -10px; cursor: pointer;" id="searchTable" searchName="LogServiceCode" >
                                    <option value="" selected>Tümü</option>
                                    <option value="list">list</option>
                                    <option value="add">add</option>
                                    <option value="delete">delete</option>
                                    <option value="edit">edit</option>
                                    <option value="view">view</option>
                                    <option value="login">login</option>
                                    <option value="logout">logout</option>
                                </select>
                            </div>
                            <!-- Arama Servis Kodu Son -->

                            <!-- Arama Durum -->
                            <div style="display: flex;flex-direction: column;width: max-content;gap: 3px;">
                                <p>Log Durum</p>
                                <select class="" style="margin-top: -10px; cursor: pointer;" id="searchTable" searchName="LogStatus" >
                                    <option value="" selected>Tümü</option>
                                    <option value="success">success</option>
                                    <option value="info">info</option>
                                    <option value="error">error</option>
                                </select>
                            </div>
                            <!-- Arama Durum Son -->
                          
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

                                <th class="table_title" exportName="id" >ID</th>
                                <th class="table_title" exportName="id" >CreatedAt</th>
                                <th class="table_title" exportName="id" >Created_byId</th>
                                <th class="table_title" exportName="id" >Service Adı</th>
                                <th class="table_title" exportName="id" >Veri Tabanı</th>
                                <th class="table_title" exportName="id" >Veri Tabanı Id</th>
                                <th class="table_title" exportName="id" >ServiceCode</th>
                                <th class="table_title" exportName="id" >Status</th>
                                <th class="table_title" exportName="id" >Decription</th>
                                
                                <th class="table_title" exportName="id" >@lang('admin.actions')</th>

                              </thead>
                            <tbody role="alert" aria-live="polite" aria-relevant="all">
                            
                              @for ($i = 0; $i < count($dbFind); $i++)
                              <tr>

                                  <!---- Seç --->
                                  <td data-cell="Seç"  class="c-table__cell"><input type="checkbox" id="checkItem" data_check_id="{{$dbFind[$i]->id}}" > </td>

                                  <td data-cell="ID" >{{$dbFind[$i]->id}}</td>
                                  <td data-cell="CreatedAt">{{$dbFind[$i]->created_at}}</td>
                                  <td data-cell="Created_byId">{{$dbFind[$i]->created_byId}}</td>
                                  <td data-cell="Service Adı">{{$dbFind[$i]->serviceName}}</td>
                                  <td data-cell="Veri Tabanı">{{$dbFind[$i]->serviceDb}}</td>
                                  <td data-cell="Veri Tabanı Id">{{$dbFind[$i]->serviceDb_Id}}</td>
                                  <td data-cell="ServiceCode">{{$dbFind[$i]->serviceCode}}</td>
                                  <td data-cell="Status">{{$dbFind[$i]->status}}</td>
                                  <td data-cell="Decription">{{$dbFind[$i]->decription}}</td>
                                 
                                  <td data-cell="@lang('admin.actions')" >
                                    <button class="btn btn-success" title="clone" id="cloneItem" data_id="{{$dbFind[$i]->id}}" ><i data_id="{{$dbFind[$i]->id}}" class=" icon-copy"></i></button>
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

  <footer>
    <!-- Footer -->
    @include('admin.include.footer')

    <!------- JS --->
    <script src="{{asset('/assets/admin')}}/js/01_0_sabit_list/00_list_search.js"></script>
    <script src="{{asset('/assets/admin')}}/js/settings/setting_logList.js"></script>
        
    <!-- Yıldırımdev Table JS -->
    <script src="{{asset('/assets/admin/yildirimdev')}}/js/yildirimdev_table.js"></script>

  </footer>

</body>
<!-- END BODY -->
</html>