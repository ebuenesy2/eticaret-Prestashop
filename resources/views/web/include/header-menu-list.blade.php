<div class="container">
    <div class="header-left">
        <a href="/" class="logo"><img src="{{asset('/assets')}}/web/images/logo.png" alt="Yıldırımdev Logo" width="105" height="25"></a>
        <nav class="main-nav">
            <ul class="menu sf-arrows">
                <li class="megamenu-container {{Route::current()->getName() == 'web.product.category' ? 'active' : 'passive'}}"><a href="/@lang('admin.lang')/product/category" class="{{Route::current()->getName() == 'web.product.category' ? 'active' : 'passive'}}">Tüm Kategoriler</a></li>
                <li class="megamenu-container {{Route::current()->getName() == 'web.product.all' ? 'active' : 'passive'}}"><a href="/@lang('admin.lang')/product/list" class="{{Route::current()->getName() == 'web.product.all' ? 'active' : 'passive'}}">Tüm Ürünler</a></li>
            </ul>
        </nav>
    </div>
</div>