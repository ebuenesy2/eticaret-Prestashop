<!DOCTYPE html>

<!-- Head -->
<title> @lang('admin.test') - @lang('admin.newAdd') | {{ config('admin.Admin_Title') }} </title>
@include('admin.include.head')

<!-- Tanım -->
<?php $homeUrl = '/admin'; ?>
<?php $listTitle = __('admin.testList'); ?>
<?php $listUrl = "/admin/fixed_list";  ?>

<!-- BEGIN BODY -->
<body class="fixed-top" id="dataValueInfo" data_action="add" >
    
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

                <!-- İşlemler -->
                <ul class="breadcrumb">
                    <li>
                        <button class="btn btn-success" id="new_add" >@lang('admin.add')</button>
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
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.email')</label>
                                        <div class="controls controls-row">
                                            <input type="email" class="input-block-level" name="emailAdd" id="emailAdd" placeholder="@lang('admin.email')" value="" focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="3" >
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.value')</label>
                                        <div class="controls controls-row">
                                            <input type="number" class="input-block-level" name="valueAdd" id="valueAdd" placeholder="@lang('admin.value')" value="" focusType ="true" focusControl="add" focusControl_Active="true" focusOrder="4">
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

   <!------- Js --->
   <script src="{{asset('/assets/admin')}}/js/01_0_sabit_list/02_actions_add_edit.js"></script>
    
</body>
<!-- END BODY -->
</html>