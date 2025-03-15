<!DOCTYPE html>

<!-- Head -->
<title> @lang('admin.product') - @lang('admin.edit') #{{ $DB_Find_tr->uid }} | {{ config('admin.Admin_Title') }} </title>
@include('admin.include.head')

<!-- Tanım -->
<?php $homeUrl = '/admin'; ?>
<?php $listTitle = __('admin.product') ?>
<?php $listUrl = "/admin/product";  ?>

<!----- Css ------> 
<link rel="stylesheet" type="text/css" href="{{asset('/assets/admin')}}/css/taginput_multiLang.css" />

<!-- BEGIN BODY -->
<body class="fixed-top" id="dataValueInfo" data_action="edit" data_uid="{{ $DB_Find_tr->uid }}">
    
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
                <h3 class="page-title"  id="dataValueId" data_id="{{ $DB_Find_tr->uid }}"  > {{$listTitle}} - @lang('admin.edit') [ #{{ $DB_Find_tr->uid }} ] </h3>
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
                        <button class="btn btn-success" title="clone" id="cloneItem" data_uid="{{$DB_Find_tr->uid}}" ><i data_uid="{{$DB_Find_tr->uid}}" class=" icon-copy"></i></button>
                    </li>
                    <li>
                        <button class="btn btn-danger" id="deleteItem" data_uid="{{$DB_Find_tr->uid}}"><i data_uid="{{$DB_Find_tr->uid}}" class="fa fa-trash "></i></button>
                    </li>
                </ul>
                <!-- İşlemler Son -->

               </div>
            </div>
         
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
             <div class="row-fluid">
                <div class="span6" id="leftAdd">
                    <!-- BEGIN BLANK PAGE PORTLET-->
                    <div class="widget red">
                        <div class="widget-title">
                            <h4><i class="fa fa-edit"></i> @lang('admin.edit') -  @lang('admin.information')  </h4>
                            <div id='loaderEditImage'  style="display: none;width: 20px;"><img src="/upload/images/loader.gif" alt=""></div>
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
                                        <label class="control-label">@lang('admin.category')</label>
                                        <div class="controls controls-row">
                                            <select class="span12" style="cursor: pointer;" id="productCategoryEdit"   >
                                                @for ($i = 0; $i < count($DB_Find_product_categories); $i++)
                                                    @if($DB_Find_en) 
                                                    <option value="{{$DB_Find_product_categories[$i]->uid}}" {{ $DB_Find_en->category == $DB_Find_product_categories[$i]->uid ? 'selected' : ''}} >{{$DB_Find_product_categories[$i]->title}}</option>
                                                    @elseif($DB_Find_de) 
                                                    <option value="{{$DB_Find_product_categories[$i]->uid}}" {{ $DB_Find_de->category == $DB_Find_product_categories[$i]->uid ? 'selected' : ''}} >{{$DB_Find_product_categories[$i]->title}}</option>
                                                    @else
                                                    <option value="{{$DB_Find_product_categories[$i]->uid}}" {{ $DB_Find_tr->category == $DB_Find_product_categories[$i]->uid ? 'selected' : ''}} >{{$DB_Find_product_categories[$i]->title}}</option>
                                                    @endif
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.stock')</label>
                                        <div class="controls controls-row">
                                            @if($DB_Find_en) 
                                            <input type="number" class="input-block-level" name="stockEdit" id="stockEdit"  lang="en"  placeholder="0" value="{!!$DB_Find_en->stock!!}" >
                                            @elseif($DB_Find_de)
                                            <input type="number" class="input-block-level" name="stockEdit" id="stockEdit"  lang="de"  placeholder="0" value="{!!$DB_Find_de->stock!!}" >
                                            @else
                                            <input type="number" class="input-block-level" name="stockEdit" id="stockEdit"  lang="tr"  placeholder="0" value="{!!$DB_Find_tr->stock!!}" >
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.currency')</label>
                                        <div class="controls controls-row">
                                            <select class="span12" style="cursor: pointer;" id="productCurrencyEdit"   >
                                                <?php $DB_currents = ["TL","EUR","$"]; ?>
                                                @for ($i = 0; $i < count($DB_currents); $i++)
                                                    @if($DB_Find_en) 
                                                    <option value="{{$DB_currents[$i]}}" {{ $DB_Find_en->currency == $DB_currents[$i] ? 'selected' : ''}} >{{$DB_currents[$i]}}</option>
                                                    @elseif($DB_Find_de) 
                                                    <option value="{{$DB_currents[$i]}}" {{ $DB_Find_de->currency == $DB_currents[$i] ? 'selected' : ''}} >{{$DB_currents[$i]}}</option>
                                                    @else
                                                    <option value="{{$DB_currents[$i]}}" {{ $DB_Find_tr->currency == $DB_currents[$i]? 'selected' : ''}} >{{$DB_currents[$i]}}</option>
                                                    @endif
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.salePrice')</label>
                                        <div class="controls controls-row">
                                            @if($DB_Find_en) 
                                            <input type="text" class="input-block-level" name="salePrice" id="salePrice"  lang="en"  placeholder="@lang('admin.salePrice')" value="{!!$DB_Find_en->sale_price!!}" >
                                            @elseif($DB_Find_de)
                                            <input type="text" class="input-block-level" name="salePrice" id="salePrice"  lang="de"  placeholder="@lang('admin.salePrice')" value="{!!$DB_Find_de->sale_price!!}" >
                                            @else
                                            <input type="text" class="input-block-level" name="salePrice" id="salePrice"  lang="tr"  placeholder="@lang('admin.salePrice')" value="{!!$DB_Find_tr->sale_price!!}" >
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.discountedPricePercent')</label>
                                        <div class="controls controls-row">
                                            @if($DB_Find_en) 
                                            <input type="text" class="input-block-level" name="discountedPricePercent" id="discountedPricePercent"  lang="en"  placeholder="@lang('admin.discountedPricePercent')" value="{!!$DB_Find_en->discounted_price_percent!!}" >
                                            @elseif($DB_Find_de)
                                            <input type="text" class="input-block-level" name="discountedPricePercent" id="discountedPricePercent"  lang="de"  placeholder="@lang('admin.discountedPricePercent')" value="{!!$DB_Find_de->discounted_price_percent!!}" >
                                            @else
                                            <input type="text" class="input-block-level" name="discountedPricePercent" id="discountedPricePercent"  lang="tr"  placeholder="@lang('admin.discountedPricePercent')" value="{!!$DB_Find_tr->discounted_price_percent!!}" >
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.discountedPrice')</label>
                                        <div class="controls controls-row">
                                            @if($DB_Find_en) 
                                            <input type="text" class="input-block-level" name="discountedPrice" id="discountedPrice"  lang="en"  placeholder="@lang('admin.discountedPrice')" value="{!!$DB_Find_en->discounted_price!!}" >
                                            @elseif($DB_Find_de)
                                            <input type="text" class="input-block-level" name="discountedPrice" id="discountedPrice"  lang="de"  placeholder="@lang('admin.discountedPrice')" value="{!!$DB_Find_de->discounted_price!!}" >
                                            @else
                                            <input type="text" class="input-block-level" name="discountedPrice" id="discountedPrice"  lang="tr"  placeholder="@lang('admin.discountedPrice')" value="{!!$DB_Find_tr->discounted_price!!}" >
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.productFloor')</label>
                                        <div class="controls controls-row">
                                            @if($DB_Find_en) 
                                            <input type="text" class="input-block-level" name="productFloor" id="productFloor"  lang="en"  placeholder="@lang('admin.productFloor')" value="{!!$DB_Find_en->floor_place!!}" >
                                            @elseif($DB_Find_de)
                                            <input type="text" class="input-block-level" name="productFloor" id="productFloor"  lang="de"  placeholder="@lang('admin.productFloor')" value="{!!$DB_Find_de->floor_place!!}" >
                                            @else
                                            <input type="text" class="input-block-level" name="productFloor" id="productFloor"  lang="tr"  placeholder="@lang('admin.productFloor')" value="{!!$DB_Find_tr->floor_place!!}" >
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.productFloorPlace')</label>
                                        <div class="controls controls-row">
                                            @if($DB_Find_en) 
                                            <input type="text" class="input-block-level" name="productFloorPlace" id="productFloorPlace"  lang="en"  placeholder="@lang('admin.productFloorPlace')" value="{!!$DB_Find_en->place!!}" >
                                            @elseif($DB_Find_de)
                                            <input type="text" class="input-block-level" name="productFloorPlace" id="productFloorPlace"  lang="de"  placeholder="@lang('admin.productFloorPlace')" value="{!!$DB_Find_de->place!!}" >
                                            @else
                                            <input type="text" class="input-block-level" name="productFloorPlace" id="productFloorPlace"  lang="tr"  placeholder="@lang('admin.productFloorPlace')" value="{!!$DB_Find_tr->place!!}" >
                                            @endif
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
                                            @if($DB_Find_en) 
                                            <img class="img-circle img-thumbnail" src="{{$DB_Find_en->img_url}}" id="fileUploadImage" style="width: 100%;height: 200px;object-fit: contain;" >
                                            @elseif($DB_Find_de) 
                                            <img class="img-circle img-thumbnail" src="{{$DB_Find_de->img_url}}" id="fileUploadImage" style="width: 100%;height: 200px;object-fit: contain;" >
                                            @else
                                            <img class="img-circle img-thumbnail" src="{{$DB_Find_tr->img_url}}" id="fileUploadImage" style="width: 100%;height: 200px;object-fit: contain;" >
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.collection')</label>
                                        <div class="controls controls-row">
                                           
                                            <div style="display: flex;gap: 10px;" >
                                                @if($DB_Find_en) 
                                                <input type="checkbox" name="new_product" id="new_product" style="margin-top: auto;margin-bottom: auto;" {{$DB_Find_en->new_product ? 'checked' : ''}} > <label for="new_product" style="margin-top: auto;margin-bottom: auto;" >@lang('admin.newProduct')</label>
                                                @elseif($DB_Find_de) 
                                                <input type="checkbox" name="new_product" id="new_product" style="margin-top: auto;margin-bottom: auto;" {{$DB_Find_de->new_product ? 'checked' : ''}} > <label for="new_product" style="margin-top: auto;margin-bottom: auto;" >@lang('admin.newProduct')</label>
                                                @else
                                                <input type="checkbox" name="new_product" id="new_product" style="margin-top: auto;margin-bottom: auto;" {{$DB_Find_tr->new_product ? 'checked' : ''}} > <label for="new_product" style="margin-top: auto;margin-bottom: auto;" >@lang('admin.newProduct')</label>
                                                @endif
                                            </div>

                                            <div style="display: flex;gap: 10px;" >
                                                @if($DB_Find_en) 
                                                <input type="checkbox" name="bestseller" id="bestseller" style="margin-top: auto;margin-bottom: auto;" {{$DB_Find_en->bestseller ? 'checked' : ''}} > <label for="bestseller" style="margin-top: auto;margin-bottom: auto;" >@lang('admin.bestseller')</label>
                                                @elseif($DB_Find_de) 
                                                <input type="checkbox" name="bestseller" id="bestseller" style="margin-top: auto;margin-bottom: auto;" {{$DB_Find_de->bestseller ? 'checked' : ''}} > <label for="bestseller" style="margin-top: auto;margin-bottom: auto;" >@lang('admin.bestseller')</label>
                                                @else
                                                <input type="checkbox" name="bestseller" id="bestseller" style="margin-top: auto;margin-bottom: auto;" {{$DB_Find_tr->bestseller ? 'checked' : ''}} > <label for="bestseller" style="margin-top: auto;margin-bottom: auto;" >@lang('admin.bestseller')</label>
                                                @endif
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.collection')</label>
                                        <div class="controls controls-row">

                                            <div style="display: flex;gap: 10px;" >
                                                @if($DB_Find_en) 
                                                <input type="checkbox" name="editor_suggestion" id="editor_suggestion" style="margin-top: auto;margin-bottom: auto;" {{$DB_Find_en->editor_suggestion ? 'checked' : ''}} > <label for="editor_suggestion" style="margin-top: auto;margin-bottom: auto;" >@lang('admin.editorSuggestion')</label>
                                                @elseif($DB_Find_de) 
                                                <input type="checkbox" name="editor_suggestion" id="editor_suggestion" style="margin-top: auto;margin-bottom: auto;" {{$DB_Find_de->editor_suggestion ? 'checked' : ''}} > <label for="editor_suggestion" style="margin-top: auto;margin-bottom: auto;" >@lang('admin.editorSuggestion')</label>
                                                @else
                                                <input type="checkbox" name="editor_suggestion" id="editor_suggestion" style="margin-top: auto;margin-bottom: auto;" {{$DB_Find_tr->editor_suggestion ? 'checked' : ''}} > <label for="editor_suggestion" style="margin-top: auto;margin-bottom: auto;" >@lang('admin.editorSuggestion')</label>
                                                @endif
                                            </div>
                                          
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div  class="row-fluid" >
                                <button class="btn btn-info" id="edit_item_info"  style="width: 100%;" >@lang('admin.edit') -  @lang('admin.information') </button>
                            </div>
                        </div>
                           
                    </div>
                    <!-- END BLANK PAGE PORTLET-->
                </div>
                <div class="span6">
                    <!-- BEGIN BLANK PAGE PORTLET-->
                    <div class="widget red">
                        <div class="widget-title">
                            <h4><i class="fa fa-edit"></i> @lang('admin.edit') </h4>
                            <div id='loaderEdit' lang="tr" style="display: none;width: 20px;"><img src="/upload/images/loader.gif" alt=""></div>
                        <span class="tools">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-remove"></a>
                        </span>
                        </div>
                        <div class="widget-body">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.title')</label>
                                        <div class="controls controls-row">
                                            @if($DB_Find_tr) 
                                            <input type="text" class="input-block-level" name="titleEdit" id="titleEdit"  lang="tr" placeholder="@lang('admin.title')" value="{!!$DB_Find_tr->title!!}" >
                                            @else
                                            <input type="text" class="input-block-level" name="titleEdit" id="titleEdit"  lang="tr" placeholder="@lang('admin.title')" value="" >
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="control-group">
                                        <label class="control-label">Cevap</label>
                                        <div class="controls controls-row">
                                            @if($DB_Find_tr)
                                            <textarea  id="editor1" rows="10" cols="80">{!!$DB_Find_tr->description!!}</textarea>
                                            @else
                                            <textarea  id="editor1" rows="10" cols="80"></textarea>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="control-group">
                                        <label class="control-label">Seo - Keywords</label>
                                        
                                        <!--------- Tag Input  ----->
                                        <div class="tagInputBox" id="tagInputBox">
                                            <div class="tagLeft" lang="tr" >
                                                <div id="tagItems" lang="tr" ></div>
                                                @if($DB_Find_tr) 
                                                <input type="text" name="tagInput" id="tagInput"  lang="tr"  value="" data_value="{!!$DB_Find_tr->seo_keywords!!}" >
                                                @else
                                                <input type="text" name="tagInput" id="tagInput"  lang="tr"  value="" data_value=""  >
                                                @endif
                                            </div>
                                            <div class="tagRight">
                                                <div id="tagCopy" lang="tr" ><i style="font-size: 24px;" lang="tr" class="fa fa-clone" aria-hidden="true"></i></div>
                                                <div id="tagCancel" lang="tr" ><i style="font-size: 30px; color: red;" lang="tr" class="fa fa-times" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="maxSonuc" lang="tr" >Max: 56 karakter:!</div>
                                        <!--------- Tag Input Son  ----->
                                        
                                    </div>
                                </div>
                            </div>
                            <div  class="row-fluid" >
                               <button class="btn btn-success" id="edit_item" lang="tr" style="width: 100%;" >@lang('admin.edit')</button>
                            </div>

                        </div>
                           
                    </div>
                    <!-- END BLANK PAGE PORTLET-->
                </div>
             </div>
             <div class="row-fluid">
                <div class="span6" id="leftEdit">
                    <!-- BEGIN BLANK PAGE PORTLET-->
                    <div class="widget blue">
                        <div class="widget-title">
                            <h4><i class="fa fa-edit"></i> @lang('admin.edit') En </h4>
                            <div  id='loaderEdit' lang="en" style="display: none;width: 20px;"><img src="/upload/images/loader.gif" alt=""></div>
                            <span class="tools">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.title') - EN</label>
                                        <div class="controls controls-row">
                                            @if($DB_Find_en) 
                                            <input type="text" class="input-block-level" name="titleEdit" id="titleEdit"  lang="en"  placeholder="@lang('admin.title')" value="{!!$DB_Find_en->title!!}" >
                                            @else
                                            <input type="text" class="input-block-level" name="titleEdit" id="titleEdit"  lang="en"  placeholder="@lang('admin.title')" value="" >
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="control-group">
                                        <label class="control-label">Cevap - EN</label>
                                        <div class="controls controls-row">
                                            @if($DB_Find_en)
                                            <textarea  id="editor2" rows="10" cols="80">{!!$DB_Find_en->description!!}</textarea>
                                            @else
                                            <textarea  id="editor2" rows="10" cols="80"></textarea>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="control-group">
                                        <label class="control-label">Seo - Keywords</label>
                                        
                                        <!--------- Tag Input  ----->
                                        <div class="tagInputBox" id="tagInputBox">
                                            <div class="tagLeft" lang="en" >
                                                <div id="tagItems" lang="en" ></div>
                                                @if($DB_Find_en) 
                                                <input type="text" name="tagInput" id="tagInput"  lang="en"  value="" data_value="{!!$DB_Find_en->seo_keywords!!}" >
                                                @else
                                                <input type="text" name="tagInput" id="tagInput"  lang="en"  value="" data_value=""  >
                                                @endif
                                            </div>
                                            <div class="tagRight">
                                                <div id="tagCopy" lang="en" ><i style="font-size: 24px;" lang="en" class="fa fa-clone" aria-hidden="true"></i></div>
                                                <div id="tagCancel" lang="en" ><i style="font-size: 30px; color: red;" lang="en" class="fa fa-times" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="maxSonuc" lang="en" >Max: 56 karakter:!</div>
                                        <!--------- Tag Input Son  ----->
                                        
                                    </div>
                                </div>
                            </div>
                            <div  class="row-fluid" >
                               <button class="btn btn-success" id="edit_item" lang="en" style="width: 100%;" >@lang('admin.edit') En </button>
                            </div>

                        </div>
                           
                    </div>
                    <!-- END BLANK PAGE PORTLET-->
                </div>
                <div class="span6">
                    <!-- BEGIN BLANK PAGE PORTLET-->
                    <div class="widget yellow">
                        <div class="widget-title">
                            <h4><i class="fa fa-edit"></i> @lang('admin.edit') De </h4>
                            <div  id='loaderEdit' lang="de" style="display: none;width: 20px;"><img src="/upload/images/loader.gif" alt=""></div>
                        <span class="tools">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-remove"></a>
                        </span>
                        </div>
                        <div class="widget-body">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.title') De</label>
                                        <div class="controls controls-row">
                                            @if($DB_Find_de) 
                                            <input type="text" class="input-block-level" name="titleEdit" id="titleEdit" lang="de" placeholder="@lang('admin.title')" value="{!!$DB_Find_de->title!!}" >
                                            @else
                                            <input type="text" class="input-block-level" name="titleEdit" id="titleEdit" lang="de" placeholder="@lang('admin.title')" value="" >
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="control-group">
                                        <label class="control-label">Cevap De</label>
                                        <div class="controls controls-row">
                                            @if($DB_Find_de) 
                                            <textarea  id="editor3" rows="10" cols="80">{!!$DB_Find_de->description!!}</textarea>
                                            @else
                                            <textarea  id="editor3" rows="10" cols="80"></textarea>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="control-group">
                                        <label class="control-label">Seo - Keywords</label>
                                        
                                        <!--------- Tag Input  ----->
                                        <div class="tagInputBox" id="tagInputBox">
                                            <div class="tagLeft" lang="de" >
                                                <div id="tagItems" lang="de" ></div>
                                                @if($DB_Find_de) 
                                                <input type="text" name="tagInput" id="tagInput"  lang="de"  value="" data_value="{!!$DB_Find_de->seo_keywords!!}" >
                                                @else
                                                <input type="text" name="tagInput" id="tagInput"  lang="de"  value="" data_value=""  >
                                                @endif
                                            </div>
                                            <div class="tagRight">
                                                <div id="tagCopy" lang="de" ><i style="font-size: 24px;" lang="de" class="fa fa-clone" aria-hidden="true"></i></div>
                                                <div id="tagCancel" lang="de" ><i style="font-size: 30px; color: red;" lang="de" class="fa fa-times" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="maxSonuc" lang="de" >Max: 56 karakter:!</div>
                                        <!--------- Tag Input Son  ----->
                                        
                                    </div>
                                </div>
                            </div>
                            <div  class="row-fluid" >
                               <button class="btn btn-success" id="edit_item" lang="de" style="width: 100%;" >@lang('admin.edit') De</button>
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
   <script src="{{asset('/assets/admin')}}/js/web/product/productList_actions.js"></script>
   <script src="{{asset('/assets/admin')}}/js/taginput_multiLang.js"></script>

    <!----  ckeditor --->
    <script src="{{asset('/assets/admin')}}/js/ckeditor/ckeditor.js"></script>
    
    <!----  Textarea id aynı olmalı --->
    <script>CKEDITOR.replace('editor1'); </script>
    <script>CKEDITOR.replace('editor2'); </script>
    <script>CKEDITOR.replace('editor3'); </script>
    
</body>
<!-- END BODY -->
</html>