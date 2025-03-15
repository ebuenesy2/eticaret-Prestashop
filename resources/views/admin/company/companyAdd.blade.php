<!DOCTYPE html>

<!-- Head -->
<title> @lang('admin.company') - @lang('admin.newAdd') | {{ config('admin.Admin_Title') }} </title>
@include('admin.include.head')

<!-- Tanım -->
<?php $homeUrl = '/admin'; ?>
<?php $listTitle = __('admin.company'); ?>
<?php $listUrl = "/admin/company";  ?>

<!-- BEGIN BODY -->
<body class="fixed-top" id="dataValueInfo" data_action="add">
    
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
                        <a href="/@lang('admin.lang'){{$listUrl}}">{{$listTitle}}</a>
                        <span class="divider">/</span>
                    </li>
                    <li class="active"> {{$listTitle}} - @lang('admin.add') </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->

                <!-- İşlemler -->
                <ul class="breadcrumb">
                    <li>
                        <button class="btn btn-warning" id="new_add" ><i class="fa fa-save "></i></button>
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
                            <h4><i class="fa fa-edit"></i> @lang('admin.companyInformation') </h4>
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
                                            <select class="span12" style="cursor: pointer;" id="companyCategoryAdd"   >
                                                @for ($i = 0; $i < count($DB_Find_company_categories); $i++)
                                                <option value="{{$DB_Find_company_categories[$i]->id}}" >{{$DB_Find_company_categories[$i]->title}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.companyName')</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="companyNameAdd" id="companyNameAdd" placeholder="@lang('admin.companyName')" value="" focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="1" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.description')</label>
                                        <div class="controls controls-row">
                                            <textarea class="span12" name="descriptionAdd" id="descriptionAdd"  rows="3" cols="80" focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="2"></textarea>
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
                    <div class="widget blue">
                        <div class="widget-title">
                            <h4><i class="fa fa-edit"></i> @lang('admin.authorizedPerson') </h4>
                        <span class="tools">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-remove"></a>
                        </span>
                        </div>
                        <div class="widget-body">
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.authorizedPerson')</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="authorizedPersonAdd" id="authorizedPersonAdd" placeholder="@lang('admin.authorizedPerson')" value="" focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="3" >
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.authorizedPersonRole')</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="authorizedPersonRoleAdd" id="authorizedPersonRoleAdd" placeholder="@lang('admin.authorizedPersonRole')" value="" focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="4" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.authorizedPhone')</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="authorizedPhoneAdd" id="authorizedPhoneAdd" placeholder="@lang('admin.authorizedPhone')" value="" focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="5" >
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.authorizedPersonMail')</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="authorizedPersonMailAdd" id="authorizedPersonMailAdd" placeholder="@lang('admin.authorizedPersonMail')" value="" focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="6" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END BLANK PAGE PORTLET-->
                </div>
             </div>
             <div class="row-fluid">
                <div class="span6">
                    <!-- BEGIN BLANK PAGE PORTLET-->
                    <div class="widget green">
                        <div class="widget-title">
                            <h4><i class="fa fa-edit"></i> @lang('admin.address') </h4>
                        <span class="tools">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-remove"></a>
                        </span>
                        </div>
                        <div class="widget-body">
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">Web @lang('admin.address') 1</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="webAddressAdd" id="webAddressAdd" placeholder="Web @lang('admin.address')" value="" focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="7" >
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">Web @lang('admin.address') 2</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="webAddressTwoAdd" id="webAddressTwoAdd" placeholder="Web @lang('admin.address')" value="" focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="8" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.phone')</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="phoneAdd" id="phoneAdd" placeholder="@lang('admin.phone')" value="" focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="9" >
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.phone') 2</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="phoneTwoAdd" id="phoneTwoAdd" placeholder="@lang('admin.phone')" value="" focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="10" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.email')</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="emailAdd" id="emailAdd" placeholder="@lang('admin.email')" value="" focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="11" >
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.email') 2</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="emailTwoAdd" id="emailTwoAdd" placeholder="@lang('admin.email')" value="" focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="12" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.country')</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="countryAdd" id="countryAdd" placeholder="@lang('admin.country')" value="" focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="13" >
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.city')</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="cityAdd" id="cityAdd" placeholder="@lang('admin.city')" value="" focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="14" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.district')</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="districtAdd" id="districtAdd" placeholder="@lang('admin.district')" value="" focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="15" >
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.neighborhood')</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="neighborhoodAdd" id="neighborhoodAdd" placeholder="@lang('admin.neighborhood')" value="" focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="16" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.address')</label>
                                        <div class="controls controls-row">
                                            <textarea class="span12" name="addressAdd" id="addressAdd"  rows="5" cols="80" focusType ="true" focusControl="add" focusControl_Active="true" focusOrder="17"></textarea>
                                        </div>
                                    </div>
                                </div>
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
   <script src="{{asset('/assets/admin')}}/js/company/company_add_edit.js"></script>
    
</body>
<!-- END BODY -->
</html>