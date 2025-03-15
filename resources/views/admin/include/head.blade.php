<html lang="@lang('admin.lang')" >
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="{{ config('admin.Admin_Meta_Title') }}">
    <meta name="author" content="{{ config('admin.Admin_Meta_Author') }}">
    <meta name="description" content="{{ config('admin.Admin_Meta_Description') }}">
    <meta name="keywords" content="{{ config('admin.Admin_Keywords') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('/assets')}}/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('/assets')}}/img/favicon/favicon-16x16.png">

    <!----- Thema ------> 
    <link href="{{asset('/assets/adminTheme')}}/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{asset('/assets/adminTheme')}}/assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
    <link href="{{asset('/assets/adminTheme')}}/assets/bootstrap/css/bootstrap-fileupload.css" rel="stylesheet" />
    <link href="{{asset('/assets/adminTheme')}}/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="{{asset('/assets/adminTheme')}}/css/style.css" rel="stylesheet" />
    <link href="{{asset('/assets/adminTheme')}}/css/style-responsive.css" rel="stylesheet" />
    <link href="{{asset('/assets/adminTheme')}}/css/style-default.css" rel="stylesheet" id="style_color" />

    <!--- Alert toastr css -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

    <!-- Sweet Alert css-->
    <link href="{{asset('/assets/js')}}/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    
    <!--------- Font - ıCON  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
</head>