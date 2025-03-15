
<!-- FOOTER -->
<div id="footer">
   {{ config('admin.Year') }} &copy; {{ config('admin.Admin_Title') }} [ {{ config('admin.Version') }} ] 
</div>
<!-- END FOOTER -->

<!----- Ajax ------>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 

<!-- JAVASCRIPTS -->
<!-- Load javascripts at bottom, this will reduce page load time -->
<script src="{{asset('/assets/adminTheme')}}/js/jquery-1.8.3.min.js"></script>
<script src="{{asset('/assets/adminTheme')}}/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="{{asset('/assets/adminTheme')}}/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="{{asset('/assets/adminTheme')}}/js/jquery.scrollTo.min.js"></script>
<script type="text/javascript" src="{{asset('/assets/adminTheme')}}/assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>

<!--common script for all pages-->
<script src="{{asset('/assets/adminTheme')}}/js/common-scripts.js"></script>

<!--- Alert toastr js -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Sweet Alerts js -->
<script src="{{asset('/assets/js')}}/sweetalert2/sweetalert2.min.js"></script>

<!-- Xml JS -->
<script src="{{asset('/assets/js')}}/xml/xml2json.js"></script>

<!---- vkbeautify JS --->
<script src="{{asset('/assets/js')}}/xml/vkbeautify.js"></script>

<!------- Controller --->
<script src="{{asset('/assets/admin')}}/js/00_0_sabit/4_0_controllersToSettingLocalStorage.js"></script>