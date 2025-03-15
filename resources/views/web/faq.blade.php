<!DOCTYPE html>
<html lang="@lang('admin.lang')" >
<head>
    
    <title> @lang('admin.frequentlyAskedQuestions') | {{ $DB_HomeSettings->title }} </title>
    
    <!------- Head --->
    @include('web.include.head')
    
</head>

<body>
    <div class="page-wrapper">
                     
        <!------- Header --->
        @include('web.include.header')

        <main class="main">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">@lang('admin.frequentlyAskedQuestions')</h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/@lang('admin.lang')">@lang('admin.home')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('admin.frequentlyAskedQuestions')</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
                <div class="container">
                	
					@for ($i = 0; $i < count($DB_faq_categories); $i++)
				    <h2 class="title text-center mb-3">{{$DB_faq_categories[$i]->title}}</h2><!-- End .title -->
        			<div class="accordion accordion-rounded" id="accordion-1">
					    
					    @for ($j = 0; $j < count($DB_Faqs); $j++)
						@if($DB_Faqs[$j]->category == $DB_faq_categories[$i]->uid )
					    <div class="card card-box card-sm bg-light">
					        <div class="card-header" id="heading-1">
					            <h2 class="card-title">
					                <a role="button" data-toggle="collapse" href="#collapse-{{$DB_Faqs[$j]->id}}" aria-expanded="true" aria-controls="collapse-1">
									   {{$DB_Faqs[$j]->question}}
					                </a>
					            </h2>
					        </div><!-- End .card-header -->
					        <div id="collapse-{{$DB_Faqs[$j]->id}}" class="collapse" aria-labelledby="heading-1" data-parent="#accordion-1">
					            <div class="card-body"> {!! $DB_Faqs[$j]->answer !!} </div><!-- End .card-body -->
					        </div><!-- End .collapse -->
					    </div><!-- End .card -->
						@endif
						@endfor
						
					</div><!-- End .accordion -->
					@endfor

                </div><!-- End .container -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->

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