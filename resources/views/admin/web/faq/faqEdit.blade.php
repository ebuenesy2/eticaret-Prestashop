<!DOCTYPE html>

<!-- Head -->
<title> FAQ - @lang('admin.edit') #{{ $DB_Find_tr->uid }} | {{ config('admin.Admin_Title') }} </title>
@include('admin.include.head')

<!-- Tanım -->
<?php $homeUrl = '/admin'; ?>
<?php $listTitle = 'FAQ' ?>
<?php $listUrl = "/admin/faq";  ?>

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
                                <div class="span12">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.category')</label>
                                        <div class="controls controls-row">
                                            <select class="span12" style="cursor: pointer;" id="faqCategoryEdit"   >
                                                @for ($i = 0; $i < count($DB_Find_faq_categories); $i++)
                                                    @if($DB_Find_en) 
                                                    <option value="{{$DB_Find_faq_categories[$i]->uid}}" {{ $DB_Find_en->category == $DB_Find_faq_categories[$i]->uid ? 'selected' : ''}} >{{$DB_Find_faq_categories[$i]->title}}</option>
                                                    @elseif($DB_Find_de) 
                                                    <option value="{{$DB_Find_faq_categories[$i]->uid}}" {{ $DB_Find_de->category == $DB_Find_faq_categories[$i]->uid ? 'selected' : ''}} >{{$DB_Find_faq_categories[$i]->title}}</option>
                                                    @else
                                                    <option value="{{$DB_Find_faq_categories[$i]->uid}}" {{ $DB_Find_tr->category == $DB_Find_faq_categories[$i]->uid ? 'selected' : ''}} >{{$DB_Find_faq_categories[$i]->title}}</option>
                                                    @endif
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div  class="row-fluid" >
                               <button class="btn btn-info" id="edit_item_info"  style="width: 100%;" >@lang('admin.edit') - @lang('admin.information') </button>
                            </div>
                            
                        </div>
                           
                    </div>
                    <!-- END BLANK PAGE PORTLET-->
                </div>
                <div class="span6" id="leftEdit">
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
                                        <label class="control-label">Soru</label>
                                        <div class="controls controls-row">
                                            @if($DB_Find_tr) 
                                            <input type="text" class="input-block-level" name="questionEdit" id="questionEdit"  lang="tr" placeholder="Soru" value="{!!$DB_Find_tr->question!!}" >
                                            @else
                                            <input type="text" class="input-block-level" name="questionEdit" id="questionEdit"  lang="tr" placeholder="Soru" value="" >
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
                                            <textarea  id="editor1" rows="10" cols="80">{!!$DB_Find_tr->answer!!}</textarea>
                                            @else
                                            <textarea  id="editor1" rows="10" cols="80"></textarea>
                                            @endif
                                        </div>
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
                <div class="span6">
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
                                        <label class="control-label">Soru - EN</label>
                                        <div class="controls controls-row">
                                            @if($DB_Find_en) 
                                            <input type="text" class="input-block-level" name="questionEdit" id="questionEdit"  lang="en"  placeholder="Soru" value="{!!$DB_Find_en->question!!}" >
                                            @else
                                            <input type="text" class="input-block-level" name="questionEdit" id="questionEdit"  lang="en"  placeholder="Soru" value="" >
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
                                            <textarea  id="editor2" rows="10" cols="80">{!!$DB_Find_en->answer!!}</textarea>
                                            @else
                                            <textarea  id="editor2" rows="10" cols="80"></textarea>
                                            @endif
                                        </div>
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
                <div class="span6" id="leftEdit">
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
                                        <label class="control-label">Soru De</label>
                                        <div class="controls controls-row">
                                            @if($DB_Find_de) 
                                            <input type="text" class="input-block-level" name="questionEdit" id="questionEdit" lang="de" placeholder="Soru" value="{!!$DB_Find_de->question!!}" >
                                            @else
                                            <input type="text" class="input-block-level" name="questionEdit" id="questionEdit" lang="de" placeholder="Soru" value="" >
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
                                            <textarea  id="editor3" rows="10" cols="80">{!!$DB_Find_de->answer!!}</textarea>
                                            @else
                                            <textarea  id="editor3" rows="10" cols="80"></textarea>
                                            @endif
                                        </div>
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
   <script src="{{asset('/assets/admin')}}/js/web/faq/faq_actions.js"></script>

    <!----  ckeditor --->
    <script src="{{asset('/assets/admin')}}/js/ckeditor/ckeditor.js"></script>
    
    <!----  Textarea id aynı olmalı --->
    <script>CKEDITOR.replace('editor1'); </script>
    <script>CKEDITOR.replace('editor2'); </script>
    <script>CKEDITOR.replace('editor3'); </script>
    
</body>
<!-- END BODY -->
</html>