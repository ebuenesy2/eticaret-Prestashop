<!DOCTYPE html>
<html lang="@lang('admin.lang')" >
<head>
    
    <title> @lang('admin.productCategory') | {{ $DB_HomeSettings->title }} </title>
    
    <!------- Head --->
    @include('web.include.head')
    
</head>

<body>
    <div class="page-wrapper">
                 
        <!------- Header --->
        @include('web.include.header')

                   
        <!--- Kategoriler -->
        <div class="container">
            <hr class="m-0">
            <div class="cat-section mt-4 mb-3">
                <div class="row">

                    @foreach ($categoryData as $category)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-8col">
                        <div class="cat bg-white pt-1 mb-2">
                            <div class="cat-image d-flex justify-content-center align-items-center">
                                <a href="/@lang('admin.lang')/product/list?category={{$category['id']}}&pageCategory={{$currentPageCategory}}"><img src="{{config('admin.Default_ImgUrl')}}" width="137" height="137"></a>
                            </div>
                            <div class="cat-content text-center">
                                <a href="/@lang('admin.lang')/product/list?category={{$category['id']}}&pageCategory={{$currentPageCategory}}" class="cat-title">{{$category['name']}}</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    																						
                    <!-- Pagination -->
                    <nav aria-label="Page navigation" style="{{$totalPagesCategory > 0 ? '' : 'display:none;'}}">
                        <ul class="pagination justify-content-center">
                            
                            <!-- Önceki sayfa butonu -->
                            <li class="page-item" style="{{$currentPageCategory > 1 ? '' : 'display:none;'}}" style="margin-right: -30px;" >
                                <a class="page-link page-link-prev" href="?pageCategory={{$currentPageCategory-1}}" aria-label="Öncesi" tabindex="-1" aria-disabled="true">
                                    <span aria-hidden="true"><i class="fa fa-long-arrow-left"></i></span>Öncesi
                                </a>
                            </li>

                            <!-- Dinamik sayfa numaraları -->
                            @php
                                $startPage = max(1, $currentPageCategory - 4); // Başlangıç sayfası
                                $endPage = min($totalPagesCategory, $currentPageCategory + 4); // Bitiş sayfası
                            @endphp

                            @for ($i = $startPage; $i <= $endPage; $i++)
                                <li class="page-item {{$i == $currentPageCategory ? 'active' : ''}}">
                                    <a class="page-link" href="?pageCategory={{$i}}" >{{$i}}</a>
                                </li>
                            @endfor

                            <!-- Sonraki sayfa butonu -->
                            <li class="page-item" style="{{$currentPageCategory < $totalPagesCategory ? '' : 'display:none;'}}" style="margin-left: -35px;" >
                                <a class="page-link page-link-next" href="?pageCategory={{$currentPageCategory+1}}" aria-label="Sonrası">
                                    Sonrası <span aria-hidden="true"><i class="fa fa-long-arrow-right"></i></span>
                                </a>
                            </li>

                        </ul>
                    </nav>
                    <!-- Pagination Son -->

                    
                </div>
            </div>
        </div>
        <!--- Kategoriler Son -->

        <footer class="footer">
        	<div class="footer-middle">
	                         
                <!------- Footer - Container --->
                @include('web.include.footer-container')

	        </div><!-- End .footer-middle -->

	        <div class="footer-bottom">
	        	<div class="container">
	        		                                    
                    <!------- Footer - Copyright --->
                    @include('web.include.footer-copyright')
                    
	        	</div><!-- End .container -->
	        </div><!-- End .footer-bottom -->
        </footer><!-- End .footer -->
    </div><!-- End .page-wrapper -->
             
    <!------- Footer - Bottom --->
    @include('web.include.footer-bottom')

</body>

</html>