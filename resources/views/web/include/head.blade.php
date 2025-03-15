<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="title" content="{{ $DB_HomeSettings->title }}">
<meta name="author" content="{{ config('admin.Admin_Meta_Author') }}">
<meta name="description" content="{{ $DB_HomeSettings->seo_description }}">
<meta name="keywords" content="{{ $seo_keywords }}">

<!-- Favicon -->
<link rel="apple-touch-icon" sizes="180x180" href="{{asset('/assets')}}/web/images/icons/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="{{asset('/assets')}}/web/images/icons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="{{asset('/assets')}}/web/images/icons/favicon-16x16.png">
<link rel="manifest" href="{{asset('/assets')}}/web/images/icons/site.html">
<link rel="mask-icon" href="{{asset('/assets')}}/web/images/icons/safari-pinned-tab.svg" color="#666666">
<link rel="shortcut icon" href="{{asset('/assets')}}/web/images/icons/favicon.ico">
<meta name="apple-mobile-web-app-title" content="Yıldırımdev">
<meta name="application-name" content="Yıldırımdev">
<meta name="msapplication-TileColor" content="#cc9966">
<meta name="msapplication-config" content="assets/images/icons/browserconfig.xml">
<meta name="theme-color" content="#ffffff">

<!-- Plugins CSS File -->
<link rel="stylesheet" href="{{asset('/assets')}}/web/css/bootstrap.min.css">
<link rel="stylesheet" href="{{asset('/assets')}}/web/css/plugins/owl-carousel/owl.carousel.css">

<!-- Main CSS File -->
<link rel="stylesheet" href="{{asset('/assets')}}/web/css/style.css">
<link rel="stylesheet" href="{{asset('/assets')}}/web/css/plugins/owl-carousel/owl.carousel.css">
<link rel="stylesheet" href="{{asset('/assets')}}/web/css/plugins/magnific-popup/magnific-popup.css">
<link rel="stylesheet" href="{{asset('/assets')}}/web/css/plugins/nouislider/nouislider.css">

<!--------- Css  --> 
<link rel="stylesheet" type="text/css" href="{{asset('/assets/web')}}/css/yildirimdev.css" />

<!--- Alert toastr css -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

<!-- Sweet Alert css-->
<link href="{{asset('/assets/js')}}/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

<!--------- Font - ıCON  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!---- Font Awesome cdn Link  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">