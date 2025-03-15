
<!--- Alt Menu ------>
<div class="navigation">
    <ul style="position: absolute;" >
        <li class="list {{Route::current()->getName() == 'web.index' ? 'active' : 'passive'}}">
            <a href="/@lang('admin.lang')">
                <span class="icon"><i class="fas fa-home"></i></span>
                <span class="text"> @lang('admin.home')</span>
            </a>
        </li>

        <li class="list {{request()->routeIs('web.product.*') ? 'active' : 'passive'}}">
            <a href="/@lang('admin.lang')/product/list">
                <span class="icon"><i class="fas fa-cube"></i></span>
                <span class="text"> @lang('admin.product')</span>
            </a>
        </li>

        <li class="list {{request()->routeIs('web.cart') ? 'active' : 'passive'}} ">
            <a href="/@lang('admin.lang')/user/cart">
                <span class="icon"><i class="fas fa-shopping-basket"></i></span>
                <span class="text"> Sepet</span>
            </a>
        </li>

        <li class="list {{request()->routeIs('web.wishlist') ? 'active' : 'passive'}} ">
            <a href="/@lang('admin.lang')/user/wishlist">
                <span class="icon"><i class="fas fa-heart"></i></span>
                <span class="text">İstek Listesi</span>
            </a>
        </li>

        <li class="list {{request()->routeIs('web.user.*') ? 'active' : 'passive'}}">
            <a href="/@lang('admin.lang')/user/profile">
                <span class="icon"><i class="fas fa-user"></i></span>
                <span class="text">@lang('admin.user')</span>
            </a>
        </li>

        <div class="indicator"></div>

    </ul>
</div>
<!--- Alt Menu Son -->


<button id="scroll-top" title="Back to Top"><i class="fa fa-arrow-up"></i></button>

<!-- Plugins JS File -->
<script src="{{asset('/assets')}}/web/js/jquery.min.js"></script>
<script src="{{asset('/assets')}}/web/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('/assets')}}/web/js/jquery.hoverIntent.min.js"></script>
<script src="{{asset('/assets')}}/web/js/jquery.waypoints.min.js"></script>
<script src="{{asset('/assets')}}/web/js/superfish.min.js"></script>
<script src="{{asset('/assets')}}/web/js/owl.carousel.min.js"></script>
<script src="{{asset('/assets')}}/web/js/imagesloaded.pkgd.min.js"></script>
<script src="{{asset('/assets')}}/web/js/isotope.pkgd.min.js"></script>
<script src="{{asset('/assets')}}/web/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('/assets')}}/web/js/wNumb.js"></script>
<script src="{{asset('/assets')}}/web/js/bootstrap-input-spinner.js"></script>
<script src="{{asset('/assets')}}/web/js/jquery.magnific-popup.min.js"></script>

<script src="{{asset('/assets')}}/web/js/jquery.plugin.min.js"></script>
<script src="{{asset('/assets')}}/web/js/jquery.countdown.min.js"></script>


<!-- Main JS File -->
<script src="{{asset('/assets')}}/web/js/main.js"></script>

<!--------- Jquery  -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!--- Alert toastr js -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Sweet Alerts js -->
<script src="{{asset('/assets/js')}}/sweetalert2/sweetalert2.min.js"></script>

<!------- Controller --->
<script src="{{asset('/assets/admin')}}/js/00_0_sabit/4_0_controllersToSettingLocalStorage.js"></script>


<!------- Sepetim JS --->
<script src="{{asset('/assets/web')}}/js/user/userCart.js"></script>


<!------- İstek Listesi JS --->
<script src="{{asset('/assets/web')}}/js/user/userWish.js"></script>