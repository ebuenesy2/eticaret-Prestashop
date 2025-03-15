<!DOCTYPE html>

<!-- Head -->
<title> @lang('admin.test') - @lang('admin.edit') #{{ $DB_Find->id }} | {{ config('admin.Admin_Title') }} </title>
@include('admin.include.head')

<!-- Tanım -->
<?php $homeUrl = '/admin'; ?>
<?php $listTitle = __('admin.testList'); ?>
<?php $listUrl = "/admin/fixed_list";  ?>

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
                            <a href="/@lang('admin.lang'){{$listUrl}}/search/{{$DB_Find->id}}" title="sayfa arama" ><button class="btn btn-warning" ><i class="fa fa-search"></i></button></a>
                        </li>
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
                <div class="span6">
                    <!-- BEGIN BLANK PAGE PORTLET-->
                    <div class="widget red">
                        <div class="widget-title">
                            <h4><i class="fa fa-edit"></i> Blank Page </h4>
                        <span class="tools">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-remove"></a>
                        </span>
                        </div>
                        <div class="widget-body">
                            <h1> Sabit </h1>

                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.name')</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="nameEdit" id="nameEdit" placeholder="@lang('admin.name')" value="{{ $DB_Find->name }}" focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="1" >
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.surname')</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="surnameEdit" id="surnameEdit" placeholder="@lang('admin.surname')" value="{{ $DB_Find->surname }}" focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="2" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.email')</label>
                                        <div class="controls controls-row">
                                            <input type="email" class="input-block-level" name="emailEdit" id="emailEdit" placeholder="@lang('admin.email')" value="{{ $DB_Find->email }}" focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="3" >
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.value')</label>
                                        <div class="controls controls-row">
                                            <input type="number" class="input-block-level" name="valueEdit" id="valueEdit" placeholder="@lang('admin.value')" value="{{ $DB_Find->value }}" focusType ="true" focusControl="edit" focusControl_Active="true" focusOrder="4" >
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div  class="row-fluid" >
                               <button class="btn btn-success" id="edit_item" >@lang('admin.edit')</button>
                            </div>

                        </div>
                           
                    </div>
                    <!-- END BLANK PAGE PORTLET-->
                </div>
                <div class="span6">
                    <!-- BEGIN BLANK PAGE PORTLET-->
                    <div class="widget red">
                        <div class="widget-title">
                            <h4><i class="fa fa-edit"></i> Blank Page </h4>
                        <span class="tools">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-remove"></a>
                        </span>
                        </div>
                        <div class="widget-body">
                            <h1> Sabit </h1>
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

    <!------ JS --->
    <script src="{{asset('/assets/admin')}}/js/01_0_sabit_list/02_actions_add_edit.js"></script>
    
</body>
<!-- END BODY -->
</html>