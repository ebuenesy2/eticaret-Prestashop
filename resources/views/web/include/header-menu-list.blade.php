<div class="container">
    <div class="header-left">
        <a href="/" class="logo"><img src="{{asset('/assets')}}/web/images/logo.png" alt="Yıldırımdev Logo" width="105" height="25"></a>
        <nav class="main-nav">
            <ul class="menu sf-arrows">
                <li class="megamenu-container {{Route::current()->getName() == 'web.index' ? 'active' : 'passive'}}"><a href="/@lang('admin.lang')" class="{{Route::current()->getName() == 'web.index' ? 'active' : 'passive'}}">@lang('admin.home')</a></li>
                <li class="megamenu-container {{Route::current()->getName() == 'web.product.category' ? 'active' : 'passive'}}"><a href="/@lang('admin.lang')/product/category" class="{{Route::current()->getName() == 'web.product.category' ? 'active' : 'passive'}}">Tüm Kategoriler</a></li>
                <li class="megamenu-container {{Route::current()->getName() == 'web.product.all' ? 'active' : 'passive'}}"><a href="/@lang('admin.lang')/product/list" class="{{Route::current()->getName() == 'web.product.all' ? 'active' : 'passive'}}">Tüm Ürünler</a></li>
                <li class="megamenu-container {{Route::current()->getName() == 'web.product.new' ? 'active' : 'passive'}}"><a href="/@lang('admin.lang')/product/list/new" class="{{Route::current()->getName() == 'web.product.new' ? 'active' : 'passive'}}">Yeni Ürünler</a></li>
                <li class="megamenu-container {{Route::current()->getName() == 'web.product.bestseller' ? 'active' : 'passive'}}"><a href="/@lang('admin.lang')/product/list/bestseller" class="{{Route::current()->getName() == 'web.product.bestseller' ? 'active' : 'passive'}}">Çok Satanlar</a></li>
                <li class="megamenu-container {{Route::current()->getName() == 'web.product.editor.suggestion' ? 'active' : 'passive'}}"><a href="/@lang('admin.lang')/product/list/editor/suggestion" class="{{Route::current()->getName() == 'web.product.editor.suggestion' ? 'active' : 'passive'}}">@lang('admin.editorSuggestion')</a></li>
                
                <li class="d-none megamenu-container {{Route::current()->getName() == 'web.blog' ? 'active' : 'passive'}}"><a href="/@lang('admin.lang')/blog" class="{{Route::current()->getName() == 'web.blog' ? 'active' : 'passive'}}">Blog</a></li>
              
            </ul>
        </nav>
    </div>
</div>