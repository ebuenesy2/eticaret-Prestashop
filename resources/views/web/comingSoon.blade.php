<!DOCTYPE html>
<html lang="en">


<!-- Yıldırımdev/html/Yıldırımdev/coming-soon.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 10 Nov 2022 14:19:13 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Yıldırımdev - Bootstrap eCommerce Template</title>
    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Yıldırımdev - Bootstrap eCommerce Template">
    <meta name="author" content="p-themes">
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('/assets')}}/web/images/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('/assets')}}/web/images/icons/favfa fa-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('/assets')}}/web/images/icons/favfa fa-16x16.png">
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
    <link rel="stylesheet" href="{{asset('/assets')}}/web/css/plugins/jquery.countdown.css">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{asset('/assets')}}/web/css/style.css">
</head>

<body>
    <div class="soon">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-lg-8">
                    <div class="soon-content text-center">
                        <div class="soon-content-wrapper">
                            <img src="{{asset('/assets')}}/web/images/logo-icon.png" alt="Logo" class="soon-logo mx-auto" style="width: 30%;max-width: 244px;" >
                            <h1 class="soon-title">Coming Soon</h1><!-- End .soon-title -->
                            <div class="coming-countdown countdown-separator"></div><!-- End .coming-countdown -->
                            <hr class="mt-2 mb-3 mt-md-3">
                            <p>We are currently working on an awesome new site. Stay tuned for more information.
                                Subscribe to our newsletter to stay updated on our progress.</p>
                            <form action="#">
                                <div class="input-group mb-5">
                                    <input type="email" class="form-control bg-transparent" placeholder="Enter your Email Address" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-primary-2" type="submit">
                                            <span>SUBSCRIBE</span>
                                            <i class="fa fa-long-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <div class="social-icons justify-content-center mb-0">
                                <a href="#" class="social-icon" target="_blank" title="Facebook"><i class="fa fa-facebook-f"></i></a>
                                <a href="#" class="social-icon" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a>
                                <a href="#" class="social-icon" target="_blank" title="Instagram"><i class="fa fa-instagram"></i></a>
                                <a href="#" class="social-icon" target="_blank" title="Youtube"><i class="fa fa-youtube"></i></a>
                                <a href="#" class="social-icon" target="_blank" title="Pinterest"><i class="fa fa-pinterest"></i></a>
                            </div><!-- End .soial-icons -->
                        </div><!-- End .soon-content-wrapper -->
                    </div><!-- End .soon-content -->
                </div><!-- End .col-md-9 col-lg-8 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
        <div class="soon-bg bg-image" style="background-image: url({{asset('/assets')}}/web/images/backgrounds/soon-bg.jpg)"></div>
        <!-- End .soon-bg bg-image -->
    </div><!-- End .soon -->
    <!-- Plugins JS File -->
    <script src="{{asset('/assets')}}/web/js/jquery.min.js"></script>
    <script src="{{asset('/assets')}}/web/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('/assets')}}/web/js/jquery.plugin.min.js"></script>
    <script src="{{asset('/assets')}}/web/js/jquery.countdown.min.js"></script>
    <!-- Main JS File -->
    <script src="{{asset('/assets')}}/web/js/main.js"></script>
    <script>
    $(function() {
        "use strict";
        if ($.fn.countdown) {
            $('.coming-countdown').countdown({
                until: new Date(2021, 7, 20), // 7th month = August / Months 0 - 11 (January  - December)
                format: 'DHMS',
                padZeroes: true
            });

            // Pause
            // $('.coming-countdown').countdown('pause');
        }
    });
    </script>
</body>


<!-- Yıldırımdev/html/Yıldırımdev/coming-soon.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 10 Nov 2022 14:19:13 GMT -->
</html>