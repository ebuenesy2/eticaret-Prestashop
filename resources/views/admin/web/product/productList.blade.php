<!DOCTYPE html>

<!-- Head -->
<title> @lang('admin.product') | {{ config('admin.Admin_Title') }} </title>
@include('admin.include.head')

<!-- Tanım -->
<?php $homeUrl = '/admin'; ?>
<?php $listTitle = __('admin.product') ?>
<?php $listUrl = "/admin/product";  ?>

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

                          <!-- Sayfa -->
                          <a href="/@lang('admin.lang'){{$listUrl}}/add"><button class="btn btn-warning">@lang('admin.newAdd') <i class="fa fa-plus"></i></button></a>

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

                          <!------ Arama Kategori ----->
                          <div style="display: flex;flex-direction: column;" >
                            <p>Kategori</p>
                            <select class="" style="cursor: pointer; width: 120px;" id="searchTable" searchName="Category"  >
                                <option value="">@lang('admin.all')</option>
                                @for ($i = 0; $i < count($DB_product_categories); $i++)
                                <option value="{{$DB_product_categories[$i]->uid}}">{{$DB_product_categories[$i]->title}}</option>
                                @endfor

                            </select>
                          </div>
                          <!------ Arama Kategori Son----->

                          <!------ Arama Urun Adı ----->
                          <div style="display: flex;flex-direction: column;">
                            <p>@lang('admin.productName')</p>
                            <input type="text" placeholder="@lang('admin.productName')" class="" id="searchTable" searchName="productName" style="width: 120px;" >
                          </div>
                          <!------ Arama Urun Adı Son----->

                          
                          <!------ Arama Urun Kat ----->
                          <div style="display: flex;flex-direction: column;">
                            <p>@lang('admin.productFloor')</p>
                            <input type="text" placeholder="@lang('admin.productFloor')" class="" id="searchTable" searchName="productFloor" style="width: 120px;" >
                          </div>
                          <!------ Arama Urun Kat Son----->
                          
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
                                <th class="table_title" exportName="id" >@lang('admin.productName')</th>
                                <th class="table_title" exportName="id" >@lang('admin.category')</th>
                                <th class="table_title" exportName="id" >@lang('admin.category') @lang('admin.title')</th>
                                <th class="table_title" exportName="id" >@lang('admin.stock')</th>

                                <th class="table_title" exportName="id" >@lang('admin.currency')</th>
                                <th class="table_title" exportName="id" >@lang('admin.salePrice')</th>
                                <th class="table_title" exportName="id" >@lang('admin.discountedPricePercent')</th>
                                <th class="table_title" exportName="id" >@lang('admin.discountedPrice')</th>

                                <th class="table_title" exportName="id" >@lang('admin.productFloor')</th>
                                <th class="table_title" exportName="id" >@lang('admin.productFloorPlace')</th>

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
                                  <td data-cell="@lang('admin.category')" >{{$dbFind[$i]->category}}</td>
                                  <td data-cell="@lang('admin.category') @lang('admin.title')" >{{$dbFind[$i]->productCategoryTitle}}</td>
                                  <td data-cell="@lang('admin.stock')" >{{$dbFind[$i]->stock}}</td>

                                  <td data-cell="@lang('admin.currency')" >{{$dbFind[$i]->currency}}</td>
                                  <td data-cell="@lang('admin.salePrice')" >{{$dbFind[$i]->sale_price}}</td>
                                  <td data-cell="@lang('admin.discountedPricePercent')" >{{$dbFind[$i]->discounted_price_percent}}</td>
                                  <td data-cell="@lang('admin.discountedPrice')" >{{$dbFind[$i]->discounted_price}}</td>

                                  <td data-cell="@lang('admin.productFloor')" > {{$dbFind[$i]->floor_place}}</td>
                                  <td data-cell="@lang('admin.productFloorPlace')" > {{$dbFind[$i]->place}}</td>

                                  <td data-cell="@lang('admin.status')">
                                    <span style="margin: auto;" class="alert {{$dbFind[$i]->isActive ? 'alert-success' : 'alert-error' }}" data_value="{{$dbFind[$i]->isActive}}" >{{$dbFind[$i]->isActive ? __('admin.active') : __('admin.passive')  }}</span>
                                  </td>

                                  <td data-cell="@lang('admin.actions')" >
                                    <button class="btn {{$dbFind[$i]->isActive ? 'btn-success ' : 'btn-danger '}}" id="statusItem" data_uid="{{$dbFind[$i]->uid}}" data_isActive="{{$dbFind[$i]->isActive}}"  ><i data_uid="{{$dbFind[$i]->uid}}" data_isActive="{{$dbFind[$i]->isActive}}"  class="{{$dbFind[$i]->isActive ? 'icon-eye-open' : ' icon-eye-close'}}"></i></button>
                                    <button class="btn btn-success" title="clone" id="cloneItem" data_uid="{{$dbFind[$i]->uid}}" ><i data_uid="{{$dbFind[$i]->uid}}" class=" icon-copy"></i></button>
                                    <a href="/@lang('admin.lang'){{$listUrl}}/edit/{{$dbFind[$i]->uid}}" title="sayfa edit" ><button class="btn btn-warning" ><i class="fa fa-pencil"></i></button></a>
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

  <!--************* Modal Son *********--->

  <footer>
    <!-- Footer -->
    @include('admin.include.footer')

    <!------- JS --->
    <script src="{{asset('/assets/admin')}}/js/01_0_sabit_list/00_list_search.js"></script>
    <script src="{{asset('/assets/admin')}}/js/web/product/productList.js"></script>
        
    <!-- Yıldırımdev Table JS -->
    <script src="{{asset('/assets/admin/yildirimdev')}}/js/yildirimdev_table.js"></script>

  </footer>

</body>
<!-- END BODY -->
</html>