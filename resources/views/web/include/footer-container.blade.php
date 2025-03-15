<div class="container">
    <div class="row">
        <div class="col-sm-6 col-lg-3">
            <div class="widget widget-about">
                <img src="{{asset('/assets')}}/web/images/logo.png" class="footer-logo" alt="Footer Logo" width="105" height="25">
                
                <div class="social-icons">
                    @if($DB_HomeSettings->facebook_Url !="" )<a href="{{ $DB_HomeSettings->facebook_Url }}" class="social-icon" target="_blank" title="Facebook"><i class="fa fa-facebook-f"></i></a>@endif
                    @if($DB_HomeSettings->twitter_Url !="" )<a href="{{ $DB_HomeSettings->twitter_Url }}" class="social-icon" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a>@endif
                    @if($DB_HomeSettings->instagram_Url !="" )<a href="{{ $DB_HomeSettings->instagram_Url }}" class="social-icon" target="_blank" title="Instagram"><i class="fa fa-instagram"></i></a>@endif
                    @if($DB_HomeSettings->linkedln_Url !="" )<a href="{{ $DB_HomeSettings->linkedln_Url }}" class="social-icon" target="_blank" title="Linkedln"><i class="fa fa-linkedin"></i></a>@endif
                    @if($DB_HomeSettings->youtube_Url !="" )<a href="{{ $DB_HomeSettings->youtube_Url }}" class="social-icon" target="_blank" title="Youtube"><i class="fa fa-youtube"></i></a>@endif
                </div><!-- End .soial-icons -->
            </div><!-- End .widget about-widget -->
        </div><!-- End .col-sm-6 col-lg-3 -->

        <div class="col-sm-6 col-lg-3">
            <div class="widget">
                <h4 class="widget-title">Sıkca Kullanılan Sayfalar</h4><!-- End .widget-title -->

                <ul class="widget-list">
                    <li><a href="/@lang('admin.lang')/faq">Sıkça Sorulan Sorular</a></li>
                    <li><a href="/@lang('admin.lang')/blog">Blog</a></li>
                </ul><!-- End .widget-list -->

            </div><!-- End .widget -->
        </div><!-- End .col-sm-6 col-lg-3 -->

        <div class="col-sm-6 col-lg-3">
            <div class="widget">
                <h4 class="widget-title">@lang('admin.institutional')</h4><!-- End .widget-title -->

                <ul class="widget-list">
                    <li><a href="/@lang('admin.lang')/about">Hakkımızda</a></li>
                    <li><a href="/@lang('admin.lang')/contact">İletişim</a></li>
                </ul><!-- End .widget-list -->

            </div><!-- End .widget -->
        </div><!-- End .col-sm-6 col-lg-3 -->

        <div class="col-sm-6 col-lg-3">
            <div class="widget">
                <h4 class="widget-title">Linkler</h4><!-- End .widget-title -->

                <ul class="widget-list">
                    <li><a href="/@lang('admin.lang')/user/login">Giriş Yap</a></li>
                    <li><a href="/@lang('admin.lang')/error404">Hata 404</a></li>
                    <li><a href="/@lang('admin.lang')/coming-soon">Yakında</a></li>
                    <li><a href="/@lang('admin.lang')/user/checkout">Checkout</a></li>
                    <li><a href="/@lang('admin.lang')/blog-single">Blog Detay</a></li>
                </ul><!-- End .widget-list -->
                
            </div><!-- End .widget -->
        </div><!-- End .col-sm-6 col-lg-3 -->
    </div><!-- End .row -->
</div><!-- End .container -->