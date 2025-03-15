<div class="container">
    <div class="header-left">
        <div class="header-dropdown">
            <a>TL</a>
            <div class="header-menu">
                <ul>
                    <li><a href="/@lang('admin.lang')">TL</a></li>
                </ul>
            </div>
        </div>
        <div class="header-dropdown">
            <a>@lang('admin.langTitle')</a>
            <div class="header-menu">
                <ul>
                    <li><a href="/tr">Türkçe</a></li>
                    <li><a href="/en">English</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="header-right">
        <ul class="top-menu">
            <li>
                <a class="link">Links</a>
                <ul>
                    <li><a href="tel:{{ $DB_HomeSettings->phone }}" class="ff"><i class="fa fa-phone"></i>Ara: {{ $DB_HomeSettings->phone }}</a></li>
                    <li><a href="#">Sipariş Takip</a></li>
                    <li><a href="/@lang('admin.lang')/contact">İletişim</a></li>
                    
                   
                    
                  
                </ul>
            </li>
        </ul>
    </div>
</div>