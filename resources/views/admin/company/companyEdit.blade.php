<!DOCTYPE html>

<!-- Head -->
<title> @lang('admin.company') - @lang('admin.edit') #{{ $DB_Find->id }} | {{ config('admin.Admin_Title') }} </title>
@include('admin.include.head')

<!-- Tanım -->
<?php $homeUrl = '/admin'; ?>
<?php $listTitle = __('admin.company'); ?>
<?php $listUrl = "/admin/company";  ?>

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
                            <a href="/@lang('admin.lang'){{$listUrl}}">{{$listTitle}}</a>
                            <span class="divider">/</span>
                        </li>
                        <li class="active"> {{$listTitle}} - @lang('admin.edit') </li>
                    </ul>
                    <!-- END PAGE TITLE & BREADCRUMB-->

                    <!-- İşlemler -->
                    <ul class="breadcrumb">
                        <li>
                            <button class="btn btn-warning" id="edit_item" ><i class="fa fa-save "></i></button>
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
                                            <select class="span12" style="cursor: pointer;" id="companyCategoryEdit"   >
                                                @for ($i = 0; $i < count($DB_Find_company_categories); $i++)
                                                 <option value="{{$DB_Find_company_categories[$i]->id}}" {{ $DB_Find->category == $DB_Find_company_categories[$i]->id ? 'selected' : ''}} >{{$DB_Find_company_categories[$i]->title}}</option>
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
                                            <input type="text" class="input-block-level" name="companyNameEdit" id="companyNameEdit" placeholder="@lang('admin.companyName')" value="{{ $DB_Find->company_name }}" focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="1" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.description')</label>
                                        <div class="controls controls-row">
                                            <textarea class="span12" name="descriptionEdit" id="descriptionEdit"  rows="3" cols="80" focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="2">{{ $DB_Find->description }}</textarea>
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
                                            <input type="text" class="input-block-level" name="authorizedPersonEdit" id="authorizedPersonEdit" placeholder="@lang('admin.authorizedPerson')" value="{{ $DB_Find->authorized_person }}"  focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="3" >
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.authorizedPersonRole')</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="authorizedPersonRoleEdit" id="authorizedPersonRoleEdit" placeholder="@lang('admin.authorizedPersonRole')" value="{{ $DB_Find->authorized_person_role }}"  focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="4" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.authorizedPhone')</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="authorizedPhoneEdit" id="authorizedPhoneEdit" placeholder="@lang('admin.authorizedPhone')" value="{{ $DB_Find->authorized_person_tel }}"  focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="5" >
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.authorizedPersonMail')</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="authorizedPersonMailEdit" id="authorizedPersonMailEdit" placeholder="@lang('admin.authorizedPersonMail')" value="{{ $DB_Find->authorized_person_mail }}"  focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="6" >
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
                                            <input type="text" class="input-block-level" name="webAddressEdit" id="webAddressEdit" placeholder="Web @lang('admin.address')" value="{{ $DB_Find->web_address1 }}"  focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="7" >
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">Web @lang('admin.address') 2</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="webAddressTwoEdit" id="webAddressTwoEdit" placeholder="Web @lang('admin.address')" value="{{ $DB_Find->web_address2 }}"  focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="8" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.phone')</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="phoneEdit" id="phoneEdit" placeholder="@lang('admin.phone')" value="{{ $DB_Find->tel1 }}"  focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="9" >
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.phone') 2</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="phoneTwoEdit" id="phoneTwoEdit" placeholder="@lang('admin.phone')" value="{{ $DB_Find->tel2 }}"  focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="10" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.email')</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="emailEdit" id="emailEdit" placeholder="@lang('admin.email')" value="{{ $DB_Find->email }}"  focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="11" >
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.email') 2</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="emailTwoEdit" id="emailTwoEdit" placeholder="@lang('admin.email')" value="{{ $DB_Find->email2 }}"  focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="12" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.country')</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="countryEdit" id="countryEdit" placeholder="@lang('admin.country')" value="{{ $DB_Find->country }}"  focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="13" >
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.city')</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="cityEdit" id="cityEdit" placeholder="@lang('admin.city')" value="{{ $DB_Find->city }}"  focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="14" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.district')</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="districtEdit" id="districtEdit" placeholder="@lang('admin.district')" value="{{ $DB_Find->district }}"  focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="15" >
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.neighborhood')</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" name="neighborhoodEdit" id="neighborhoodEdit" placeholder="@lang('admin.neighborhood')" value="{{ $DB_Find->neighborhood }}"  focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="16" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="control-group">
                                        <label class="control-label">@lang('admin.address')</label>
                                        <div class="controls controls-row">
                                            <textarea class="span12" name="addressEdit" id="addressEdit"  rows="5" cols="80" focusType ="true" focusControl="edit" focusControl_Active="true" focusOrder="17">{{ $DB_Find->address }}</textarea>
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

    <!------ JS --->
    <script src="{{asset('/assets/admin')}}/js/company/company_add_edit.js"></script>
    
</body>
<!-- END BODY -->
</html>