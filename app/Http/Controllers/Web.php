<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB; //Veri Tabanı İşlemleri

//! Zaman
use Carbon\Carbon;
Carbon::now('Europe/Istanbul');
Carbon::setLocale('tr');
date_default_timezone_set('Etc/GMT-3');
//! Zaman Son

//! Sabit Fonksiyonlar
include(app_path() . '/Functions/test.php'); //! Test

class Web extends Controller
{

    //************* Test ***************** */

    //! Test
    public function Test($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        
        try {
            
            echo "Dil:"; echo $site_lang;  echo "<br/>";
            echo "web test"; echo "<br/>"; 

            //! Zaman
            $currentTime = Carbon::now(); //! 2023-02-23 08:05:04
            echo "currentTime:"; echo $currentTime;  echo "<br/>";
            
        } catch (\Throwable $th) {  throw $th; }

    } //! Test Son
     
    //! Test View
    public function TestView($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>"; die();

        try {  return view('web/test'); } 
        catch (\Throwable $th) {  throw $th; }

    } //! Test View Son

    //************* Sabit ***************** */

    //! Sabit
    public function Fixed($site_lang="tr")
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>"; die();

        try {

            //! Sayfa Kontrol
            if($site_lang == "admin") {  return redirect('/'.__('admin.lang').'/'.'admin/');  } //! Admin
            else { 

                //! Site Bilgileri
                $DB_HomeSettings= DB::table('homesettings')->where('id','=',2)->first();
                $seo_keywords =  $DB_HomeSettings->seo_keywords;
                //echo "<pre>"; print_r($DB_HomeSettings); die();

                $DB["DB_HomeSettings"] =  $DB_HomeSettings;
                $DB["seo_keywords"] =  $seo_keywords;
                //! Site Bilgileri Son
                  
                return view('web/sabit',$DB);
            } //! Web
        
        } catch (\Throwable $th) {  throw $th; }

    } //! Sabit Son

    //************* Web ***************** */

    //! Index
    public function Index($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>"; die();

        try {

            //! Sayfa Kontrol
            if($site_lang == "admin") {  return redirect('/'.__('admin.lang').'/'.'admin/');  } //! Admin
            else { 

                //! Site Bilgileri
                $DB_HomeSettings= DB::table('homesettings')->where('id','=',2)->first();
                $seo_keywords =  $DB_HomeSettings->seo_keywords;
                //echo "<pre>"; print_r($DB_HomeSettings); die();

                $DB["DB_HomeSettings"] =  $DB_HomeSettings;
                $DB["seo_keywords"] =  $seo_keywords;
                //! Site Bilgileri Son

                //! Web UserId
                $web_userId = 0;
                if(isset($_COOKIE["web_userId"])) { $web_userId = (int)$_COOKIE["web_userId"]; }
                //echo "web_userId:"; echo $web_userId; die();
                                           
                //! Kullanıcı Sepet Listesi
                $DB_web_user_cart= DB::table('web_user_cart')
                ->join('products', 'products.uid', '=', 'web_user_cart.product_uid')
                ->join('web_users', 'web_users.id', '=', 'web_user_cart.user_id')
                ->select('web_user_cart.*', 
                          'products.title as productsTitle','products.img_url as productsImg',
                          'products.uid as productsUid','products.seo_url as productsSeo_url',
                          'products.currency as productsCurrency',
                          DB::raw('(CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END) AS productsPrice'),
                          DB::raw('((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) AS productsTotalPrice'),
                          DB::raw('SUM((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) OVER() AS productsAllTotalPrice'),
                          'web_users.name as userName',
                          'web_users.surname as userSurName'
                        )
                ->where('web_user_cart.user_id','=', $web_userId)
                ->where('web_user_cart.isActive','=',1)
                ->orderBy('web_user_cart.id','desc')
                ->get();
                //echo "<pre>"; print_r($DB_web_user_cart); die();

                //! Return
                $DB["DB_web_user_cart"] =  $DB_web_user_cart;
                $DB["productsCount"] =  $DB_web_user_cart->count();
                $DB["productsCurrency"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsCurrency : "TL";
                $DB["productsAllTotalPrice"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsAllTotalPrice : 0;
                //! Kullanıcı Sepet Listesi -  Son
                                
                //! Kullanıcı İstek Listesi - Sayısı
                $DB_web_user_wish_count = DB::table('web_user_wish')->where('web_user_wish.user_id','=', $web_userId)->count(); //! İstek Listesi - Sayısı
                //echo "DB_web_user_wish_count:"; echo $DB_web_user_wish_count; die();

                //! Return
                $DB["DB_web_user_wish_count"] =  $DB_web_user_wish_count;
                //! Kullanıcı İstek Listesi - Sayısı - Son

                //! Slider
                $DB_Slider= DB::table('sliders')->where('sliders.lang','=',__('admin.lang'))->where('isActive','=',1)->get();
                //echo "<pre>"; print_r($DB_Slider); die();

                //! Return
                $DB["DB_Slider"] =  $DB_Slider;
                //! Slider Son

                //! Ürün Kategorisi
                $DB_product_categories= DB::table('product_categories')
                ->orderBy('product_categories.id','desc')
                ->where('product_categories.lang','=',__('admin.lang'))
                ->where('product_categories.isActive','=',1)->get();
                //echo "<pre>"; print_r($DB_product_categories); die();

                //! Return
                $DB["DB_product_categories"] =  $DB_product_categories;
                //! Ürün Kategorisi Son

                //! Ürünler - Editörün Önerisi
                $DB_Products_Editor_Suggestion= DB::table('products')
                ->join('product_categories', 'product_categories.uid', '=', 'products.category')
                ->leftJoin('web_user_cart', 'web_user_cart.product_uid', '=', 'products.uid')
                ->leftJoin('web_user_wish', 'web_user_wish.product_uid', '=', 'products.uid')
                ->select(   'products.*', 
                            'product_categories.uid as product_categories_uid',
                            'product_categories.title as product_categories_title',
                            'product_categories.seo_url as product_categories_seo_url',
                            'web_user_cart.user_id as web_users_id',
                            DB::raw('(CASE web_user_cart.user_id WHEN '.$web_userId.' THEN true ELSE false END) AS web_user_cart_control'),
                            DB::raw('(CASE web_user_wish.user_id WHEN '.$web_userId.' THEN true ELSE false END) AS web_user_wish_control'),
                       )
                ->groupBy('products.uid')
                ->where('products.lang','=',__('admin.lang'))
                ->where('products.editor_suggestion','=',1)
                ->where('products.isActive','=',1)
                ->skip(0)->take(20)
                ->orderBy('products.uid','desc')
                ->get();
                //echo "<pre>"; print_r($DB_Products_Editor_Suggestion); die();

                //! Return
                $DB["DB_Products_Editor_Suggestion"] =  $DB_Products_Editor_Suggestion;
                //! Ürünler - Editörün Önerisi Son

                //! Ürünler - Çok Satanlar
                $DB_Products_bestseller= DB::table('products')
                ->join('product_categories', 'product_categories.uid', '=', 'products.category')
                ->leftJoin('web_user_cart', 'web_user_cart.product_uid', '=', 'products.uid')
                ->leftJoin('web_user_wish', 'web_user_wish.product_uid', '=', 'products.uid')
                ->select(   'products.*', 
                            'product_categories.uid as product_categories_uid',
                            'product_categories.title as product_categories_title',
                            'product_categories.seo_url as product_categories_seo_url',
                            'web_user_cart.user_id as web_users_id',
                            DB::raw('(CASE web_user_cart.user_id WHEN '.$web_userId.' THEN true ELSE false END) AS web_user_cart_control'),
                            DB::raw('(CASE web_user_wish.user_id WHEN '.$web_userId.' THEN true ELSE false END) AS web_user_wish_control'),
                       )
                ->groupBy('products.uid')
                ->where('products.lang','=',__('admin.lang'))
                ->where('products.bestseller','=',1)
                ->where('products.isActive','=',1)
                ->skip(0)->take(20)
                ->orderBy('products.uid','desc')
                ->get();
                //echo "<pre>"; print_r($DB_Products_bestseller); die();

                //! Return
                $DB["DB_Products_bestseller"] =  $DB_Products_bestseller;
                //! Ürünler - Çok Satanlar Son

                //! Ürünler - Yeni Ürünler
                $DB_Products_new= DB::table('products')
                ->join('product_categories', 'product_categories.uid', '=', 'products.category')
                ->leftJoin('web_user_cart', 'web_user_cart.product_uid', '=', 'products.uid')
                ->leftJoin('web_user_wish', 'web_user_wish.product_uid', '=', 'products.uid')
                ->select(   'products.*', 
                            'product_categories.uid as product_categories_uid',
                            'product_categories.title as product_categories_title',
                            'product_categories.seo_url as product_categories_seo_url',
                            'web_user_cart.user_id as web_users_id',
                            DB::raw('(CASE web_user_cart.user_id WHEN '.$web_userId.' THEN true ELSE false END) AS web_user_cart_control'),
                            DB::raw('(CASE web_user_wish.user_id WHEN '.$web_userId.' THEN true ELSE false END) AS web_user_wish_control'),
                       )
                ->groupBy('products.uid')
                ->where('products.lang','=',__('admin.lang'))
                ->where('products.new_product','=',1)
                ->where('products.isActive','=',1)
                ->skip(0)->take(20)
                ->orderBy('products.uid','desc')
                ->get();
                //echo "<pre>"; print_r($DB_Products_new); die();

                //! Return
                $DB["DB_Products_new"] =  $DB_Products_new;
                //! Ürünler - Yeni Ürünler Son


                return view('web/index',$DB);
            } //! Web
        
        } catch (\Throwable $th) {  throw $th; }

    } //! Index Son
    
    //************* Web - Ürün ***************** */

    //! Ürün Kategorisi
    public function ProductCategoryList($site_lang="tr")
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>"; die();

        try {

            //! Sayfa Kontrol
            if($site_lang == "admin") {  return redirect('/'.__('admin.lang').'/'.'admin/');  } //! Admin
            else { 

                //! Site Bilgileri
                $DB_HomeSettings= DB::table('homesettings')->where('id','=',2)->first();
                $seo_keywords =  $DB_HomeSettings->seo_keywords;
                //echo "<pre>"; print_r($DB_HomeSettings); die();

                $DB["DB_HomeSettings"] =  $DB_HomeSettings;
                $DB["seo_keywords"] =  $seo_keywords;
                //! Site Bilgileri Son
                
                //! Web UserId
                $web_userId = 0;
                if(isset($_COOKIE["web_userId"])) { $web_userId = (int)$_COOKIE["web_userId"]; }
                //echo "web_userId:"; echo $web_userId; die();
                                           
                //! Kullanıcı Sepet Listesi
                $DB_web_user_cart= DB::table('web_user_cart')
                ->join('products', 'products.uid', '=', 'web_user_cart.product_uid')
                ->join('web_users', 'web_users.id', '=', 'web_user_cart.user_id')
                ->select('web_user_cart.*', 
                          'products.title as productsTitle','products.img_url as productsImg',
                          'products.uid as productsUid','products.seo_url as productsSeo_url',
                          'products.currency as productsCurrency',
                          DB::raw('(CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END) AS productsPrice'),
                          DB::raw('((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) AS productsTotalPrice'),
                          DB::raw('SUM((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) OVER() AS productsAllTotalPrice'),
                          'web_users.name as userName',
                          'web_users.surname as userSurName'
                        )
                ->where('web_user_cart.user_id','=', $web_userId)
                ->where('web_user_cart.isActive','=',1)
                ->orderBy('web_user_cart.id','desc')
                ->get();
                //echo "<pre>"; print_r($DB_web_user_cart); die();

                //! Return
                $DB["DB_web_user_cart"] =  $DB_web_user_cart;
                $DB["productsCount"] =  $DB_web_user_cart->count();
                $DB["productsCurrency"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsCurrency : "TL";
                $DB["productsAllTotalPrice"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsAllTotalPrice : 0;
                //! Kullanıcı Sepet Listesi -  Son
                                
                //! Kullanıcı İstek Listesi - Sayısı
                $DB_web_user_wish_count = DB::table('web_user_wish')->where('web_user_wish.user_id','=', $web_userId)->count(); //! İstek Listesi - Sayısı
                //echo "DB_web_user_wish_count:"; echo $DB_web_user_wish_count; die();

                //! Return
                $DB["DB_web_user_wish_count"] =  $DB_web_user_wish_count;
                //! Kullanıcı İstek Listesi - Sayısı - Son
                
                //! Ürün Kategorisi
                $DB_product_categories= DB::table('product_categories')
                ->orderBy('product_categories.id','desc')
                ->where('product_categories.lang','=',__('admin.lang'))
                ->where('product_categories.isActive','=',1)->get();
                //echo "<pre>"; print_r($DB_product_categories); die();

                //! Return
                $DB["DB_product_categories"] =  $DB_product_categories;
                //! Ürün Kategorisi Son

                return view('web/product/category',$DB);
            } //! Web
        
        } catch (\Throwable $th) {  throw $th; }

    } //! Ürün Kategorisi Son

    //! Ürün Kategorisi - Ürün Listesi
    public function ProductCategoryView($site_lang="tr",$seo_url)
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>"; die();

        try {

            //! Sayfa Kontrol
            if($site_lang == "admin") {  return redirect('/'.__('admin.lang').'/'.'admin/');  } //! Admin
            else { 

                //! Site Bilgileri
                $DB_HomeSettings= DB::table('homesettings')->where('id','=',2)->first();
                $seo_keywords =  $DB_HomeSettings->seo_keywords;
                //echo "<pre>"; print_r($DB_HomeSettings); die();

                $DB["DB_HomeSettings"] =  $DB_HomeSettings;
                $DB["seo_keywords"] =  $seo_keywords;
                //! Site Bilgileri Son
                
                //! Web UserId
                $web_userId = 0;
                if(isset($_COOKIE["web_userId"])) { $web_userId = (int)$_COOKIE["web_userId"]; }
                //echo "web_userId:"; echo $web_userId; die();
                                           
                //! Kullanıcı Sepet Listesi
                $DB_web_user_cart= DB::table('web_user_cart')
                ->join('products', 'products.uid', '=', 'web_user_cart.product_uid')
                ->join('web_users', 'web_users.id', '=', 'web_user_cart.user_id')
                ->select('web_user_cart.*', 
                          'products.title as productsTitle','products.img_url as productsImg',
                          'products.uid as productsUid','products.seo_url as productsSeo_url',
                          'products.currency as productsCurrency',
                          DB::raw('(CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END) AS productsPrice'),
                          DB::raw('((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) AS productsTotalPrice'),
                          DB::raw('SUM((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) OVER() AS productsAllTotalPrice'),
                          'web_users.name as userName',
                          'web_users.surname as userSurName'
                        )
                ->where('web_user_cart.user_id','=', $web_userId)
                ->where('web_user_cart.isActive','=',1)
                ->orderBy('web_user_cart.id','desc')
                ->get();
                //echo "<pre>"; print_r($DB_web_user_cart); die();

                //! Return
                $DB["DB_web_user_cart"] =  $DB_web_user_cart;
                $DB["productsCount"] =  $DB_web_user_cart->count();
                $DB["productsCurrency"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsCurrency : "TL";
                $DB["productsAllTotalPrice"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsAllTotalPrice : 0;
                //! Kullanıcı Sepet Listesi -  Son
                                
                //! Kullanıcı İstek Listesi - Sayısı
                $DB_web_user_wish_count = DB::table('web_user_wish')->where('web_user_wish.user_id','=', $web_userId)->count(); //! İstek Listesi - Sayısı
                //echo "DB_web_user_wish_count:"; echo $DB_web_user_wish_count; die();

                //! Return
                $DB["DB_web_user_wish_count"] =  $DB_web_user_wish_count;
                //! Kullanıcı İstek Listesi - Sayısı - Son

                //! Uid
                $dizi=explode("-",$seo_url); //! Parçıyor
                $uid = $dizi[0]; //! uid
                //echo "uid:"; echo $uid; die(); //! uid

                //! Ürün Kategori Verileri
                $DB_Find= DB::table('product_categories')
                ->where('product_categories.lang','=',__('admin.lang'))
                ->where('product_categories.uid','=',$uid)
                ->first();
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB["DB_Find"] =  $DB_Find;
                $DB["seoTitle"] =  $DB_Find->seo_url;
                //! Ürün Kategori Verileri Son

                //! Params - Url Veri Alma
                // ?page=10&rowcount=10&order=desc

                $page = request('page'); //! Sayfa Numarası
                $rowcount = request('rowcount') ? request('rowcount') : 20; //! Sayfada Gösterecek Veri Sayısı
                $orderBy = request('orderBy') ? request('orderBy') : "products.uid";  //! Sıralama Türü
                $order = request('order') ? request('order') : "desc";  //! Sıralama [asc = Küçükten -> Büyüğe] [ desc = Büyükten -> Küçüğe ]
                //echo "orderBy: "; echo $orderBy; die();

                //! Sayfada veri gösterme sayısı hesaplama
                if($page) {
                    $page = $page - 1; //! Sayfa Numarası
                    if($page <= 0) { $page = 0; }
                } else { $page = 0; }

                    
                //! Ürünler Listesi Kontrol
                $DB_Products= DB::table('products')
                ->join('product_categories', 'product_categories.uid', '=', 'products.category')
                ->select('products.*', 'product_categories.title as CategoryTitle')
                ->where('products.lang','=',__('admin.lang'))
                ->where('products.category','=',$uid)
                ->where('products.isActive','=',1);

                //! Sayfa Sayısı Hesaplama
                $DB_Count = $DB_Products->count(); //! Veri Sayısı
                $pageNow = $page+1; //! Bulunduğu Sayfa
                $pageTop = ceil($DB_Count / $rowcount); //! Toplam Sayfa
                //echo "pageTop: "; echo $pageTop; die();
                
                //! Ürün Listesi
                $DB_Products_List = $DB_Products
                ->skip($page)->take($rowcount)
                ->orderBy($orderBy,$order)
                ->get();
                //echo "<pre>"; print_r($DB_Products_List); die();

                //! Return
                $DB["page"] =  $page; //! Params Sayfa Sayısı
                $DB["rowcount"] =  $rowcount; //! Params Sayfada Gösterilecek Veri Sayısı
                $DB["orderBy"] =  $orderBy; //! Params Sıralama Türü
                $DB["order"] =  $order; //! Params Sıralama
                
                $DB["pageNow"] =  $pageNow; //! Şimdiki Sayfa
                $DB["pageTop"] =  $pageTop; //! Toplam Sayfa
                $DB["DB_Count"] =  $DB_Count; //! Toplam Ürün Sayısı

                $DB["DB_Products"] =  $DB_Products_List; //! Toplam Ürün Listesi
                $DB["DB_Products_Count"] =  count($DB_Products_List); //! Gösterilen Ürün Sayısı
                //! Ürünler Listesi Kontrol - Son

                return view('web/product/category_product_list',$DB);
            } //! Web
        
        } catch (\Throwable $th) {  throw $th; }

    } //! Ürün Kategorisi -Ürün Listesi Son

    //! Ürün Listesi - Tüm Ürünler
    public function ProductListAll($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>"; die();

        try {

            //! Sayfa Kontrol
            if($site_lang == "admin") {  return redirect('/'.__('admin.lang').'/'.'admin/');  } //! Admin
            else { 

                //! Site Bilgileri
                $DB_HomeSettings= DB::table('homesettings')->where('id','=',2)->first();
                $seo_keywords =  $DB_HomeSettings->seo_keywords;
                //echo "<pre>"; print_r($DB_HomeSettings); die();

                $DB["DB_HomeSettings"] =  $DB_HomeSettings;
                $DB["seo_keywords"] =  $seo_keywords;
                //! Site Bilgileri Son
                
                //! Web UserId
                $web_userId = 0;
                if(isset($_COOKIE["web_userId"])) { $web_userId = (int)$_COOKIE["web_userId"]; }
                //echo "web_userId:"; echo $web_userId; die();
                                           
                //! Kullanıcı Sepet Listesi
                $DB_web_user_cart= DB::table('web_user_cart')
                ->join('products', 'products.uid', '=', 'web_user_cart.product_uid')
                ->join('web_users', 'web_users.id', '=', 'web_user_cart.user_id')
                ->select('web_user_cart.*', 
                          'products.title as productsTitle','products.img_url as productsImg',
                          'products.uid as productsUid','products.seo_url as productsSeo_url',
                          'products.currency as productsCurrency',
                          DB::raw('(CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END) AS productsPrice'),
                          DB::raw('((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) AS productsTotalPrice'),
                          DB::raw('SUM((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) OVER() AS productsAllTotalPrice'),
                          'web_users.name as userName',
                          'web_users.surname as userSurName'
                        )
                ->where('web_user_cart.user_id','=', $web_userId)
                ->where('web_user_cart.isActive','=',1)
                ->orderBy('web_user_cart.id','desc')
                ->get();
                //echo "<pre>"; print_r($DB_web_user_cart); die();

                //! Return
                $DB["DB_web_user_cart"] =  $DB_web_user_cart;
                $DB["productsCount"] =  $DB_web_user_cart->count();
                $DB["productsCurrency"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsCurrency : "TL";
                $DB["productsAllTotalPrice"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsAllTotalPrice : 0;
                //! Kullanıcı Sepet Listesi -  Son
                                
                //! Kullanıcı İstek Listesi - Sayısı
                $DB_web_user_wish_count = DB::table('web_user_wish')->where('web_user_wish.user_id','=', $web_userId)->count(); //! İstek Listesi - Sayısı
                //echo "DB_web_user_wish_count:"; echo $DB_web_user_wish_count; die();

                //! Return
                $DB["DB_web_user_wish_count"] =  $DB_web_user_wish_count;
                //! Kullanıcı İstek Listesi - Sayısı - Son

                //! Ürün Kategorisi
                $DB_product_categories= DB::table('product_categories')
                ->orderBy('product_categories.id','desc')
                ->where('product_categories.lang','=',__('admin.lang'))
                ->where('product_categories.isActive','=',1)->get();
                //echo "<pre>"; print_r($DB_product_categories); die();

                //! Return
                $DB["DB_product_categories"] =  $DB_product_categories;
                //! Ürün Kategorisi Son

                //! Params - Url Veri Alma
                // ?page=10&rowcount=10&order=desc

                $page = request('page'); //! Sayfa Numarası
                $rowcount = request('rowcount') ? request('rowcount') : 20; //! Sayfada Gösterecek Veri Sayısı
                $orderBy = request('orderBy') ? request('orderBy') : "products.uid";  //! Sıralama Türü
                $order = request('order') ? request('order') : "desc";  //! Sıralama [asc = Küçükten -> Büyüğe] [ desc = Büyükten -> Küçüğe ]
                //echo "order: "; echo $order; die();

                //! Kategoriler
                $categories = request('categories') ? request('categories') : "";  //! Params - Kategoriler
                $dizi_categories=explode("_",$categories);
                //echo "categories: "; echo $categories; die();
                //echo "<pre>"; print_r($dizi_categories); die();

                $DB["categories"] =  $categories;
                $DB["dizi_categories"] =  $dizi_categories;
                //! Kategoriler Son
                
                //! Sayfada veri gösterme sayısı hesaplama
                if($page) {
                    $page = $page - 1; //! Sayfa Numarası
                    if($page <= 0) { $page = 0; }
                } else { $page = 0; }

                 
                //! Ürünler Listesi Kontrol
                $DB_Products= DB::table('products')
                ->join('product_categories', 'product_categories.uid', '=', 'products.category')
                ->leftJoin('web_user_cart', 'web_user_cart.product_uid', '=', 'products.uid')
                ->leftJoin('web_user_wish', 'web_user_wish.product_uid', '=', 'products.uid')
                ->select(   'products.*', 
                            'product_categories.uid as product_categories_uid',
                            'product_categories.title as product_categories_title',
                            'product_categories.seo_url as product_categories_seo_url',
                            'web_user_cart.user_id as web_users_id',
                            DB::raw('(CASE web_user_cart.user_id WHEN '.$web_userId.' THEN true ELSE false END) AS web_user_cart_control'),
                            DB::raw('(CASE web_user_wish.user_id WHEN '.$web_userId.' THEN true ELSE false END) AS web_user_wish_control'),
                       )
                ->groupBy('products.uid')
                ->where('products.lang','=',__('admin.lang'))
                //->where('products.editor_suggestion','=',1)
                ->where('products.isActive','=',1);
                
                //! Arama
                $parameter_search = request('search');
                if($parameter_search) { $DB_Products = $DB_Products->where('products.title','like','%'.$parameter_search.'%');  }

                if( trim($categories) != "") { $DB_Products = $DB_Products->whereIn('products.category',$dizi_categories); }
                
                //! Sayfa Sayısı Hesaplama
                $DB_Count = count($DB_Products->get()); //! Veri Sayısı
                $pageNow = $page+1; //! Bulunduğu Sayfa
                $pageTop = ceil($DB_Count / $rowcount); //! Toplam Sayfa
                //echo "DB_Count: "; echo $DB_Count; die();
                //echo "pageNow: "; echo $pageNow; die();
                //echo "pageTop: "; echo $pageTop; die();
                
                //! Ürün Listesi
                $DB_Products_List = $DB_Products
                ->skip($rowcount*$page)->take($rowcount)
                ->orderBy($orderBy,$order)
                ->get();
                //echo "<pre>"; print_r($DB_Products_List); die();

                //! Return
                $DB["page"] =  $page; //! Params Sayfa Sayısı
                $DB["rowcount"] =  $rowcount; //! Params Sayfada Gösterilecek Veri Sayısı
                $DB["orderBy"] =  $orderBy; //! Params Sıralama Türü
                $DB["order"] =  $order; //! Params Sıralama
                
                $DB["pageNow"] =  $pageNow; //! Şimdiki Sayfa
                $DB["pageTop"] =  $pageTop; //! Toplam Sayfa
                $DB["DB_Count"] =  $DB_Count; //! Toplam Ürün Sayısı

                $DB["DB_Products_Title"] =  __('admin.allProduct');
                $DB["DB_Products"] =  $DB_Products_List; //! Toplam Ürün Listesi
                $DB["DB_Products_Count"] =  count($DB_Products_List); //! Gösterilen Ürün Sayısı
                //! Ürünler Listesi Kontrol - Son

                return view('web/product/productList',$DB);
            } //! Web
        
        } catch (\Throwable $th) {  throw $th; }

    } //! Ürün Listesi - Tüm Ürünler Son

    //! Ürün Listesi - Yeni Ürünler
    public function ProductListNew($site_lang="tr")
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>"; die();

        try {

            //! Sayfa Kontrol
            if($site_lang == "admin") {  return redirect('/'.__('admin.lang').'/'.'admin/');  } //! Admin
            else { 

                //! Site Bilgileri
                $DB_HomeSettings= DB::table('homesettings')->where('id','=',2)->first();
                $seo_keywords =  $DB_HomeSettings->seo_keywords;
                //echo "<pre>"; print_r($DB_HomeSettings); die();

                $DB["DB_HomeSettings"] =  $DB_HomeSettings;
                $DB["seo_keywords"] =  $seo_keywords;
                //! Site Bilgileri Son
                
                //! Web UserId
                $web_userId = 0;
                if(isset($_COOKIE["web_userId"])) { $web_userId = (int)$_COOKIE["web_userId"]; }
                //echo "web_userId:"; echo $web_userId; die();
                                            
                //! Kullanıcı Sepet Listesi
                $DB_web_user_cart= DB::table('web_user_cart')
                ->join('products', 'products.uid', '=', 'web_user_cart.product_uid')
                ->join('web_users', 'web_users.id', '=', 'web_user_cart.user_id')
                ->select('web_user_cart.*', 
                        'products.title as productsTitle','products.img_url as productsImg',
                        'products.uid as productsUid','products.seo_url as productsSeo_url',
                        'products.currency as productsCurrency',
                        DB::raw('(CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END) AS productsPrice'),
                        DB::raw('((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) AS productsTotalPrice'),
                        DB::raw('SUM((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) OVER() AS productsAllTotalPrice'),
                        'web_users.name as userName',
                        'web_users.surname as userSurName'
                        )
                ->where('web_user_cart.user_id','=', $web_userId)
                ->where('web_user_cart.isActive','=',1)
                ->orderBy('web_user_cart.id','desc')
                ->get();
                //echo "<pre>"; print_r($DB_web_user_cart); die();

                //! Return
                $DB["DB_web_user_cart"] =  $DB_web_user_cart;
                $DB["productsCount"] =  $DB_web_user_cart->count();
                $DB["productsCurrency"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsCurrency : "TL";
                $DB["productsAllTotalPrice"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsAllTotalPrice : 0;
                //! Kullanıcı Sepet Listesi -  Son
                                
                //! Kullanıcı İstek Listesi - Sayısı
                $DB_web_user_wish_count = DB::table('web_user_wish')->where('web_user_wish.user_id','=', $web_userId)->count(); //! İstek Listesi - Sayısı
                //echo "DB_web_user_wish_count:"; echo $DB_web_user_wish_count; die();

                //! Return
                $DB["DB_web_user_wish_count"] =  $DB_web_user_wish_count;
                //! Kullanıcı İstek Listesi - Sayısı - Son

                //! Ürün Kategorisi
                $DB_product_categories= DB::table('product_categories')
                ->orderBy('product_categories.id','desc')
                ->where('product_categories.lang','=',__('admin.lang'))
                ->where('product_categories.isActive','=',1)->get();
                //echo "<pre>"; print_r($DB_product_categories); die();

                //! Return
                $DB["DB_product_categories"] =  $DB_product_categories;
                //! Ürün Kategorisi Son

                //! Params - Url Veri Alma
                // ?page=10&rowcount=10&order=desc

                $page = request('page'); //! Sayfa Numarası
                $rowcount = request('rowcount') ? request('rowcount') : 20; //! Sayfada Gösterecek Veri Sayısı
                $orderBy = request('orderBy') ? request('orderBy') : "products.uid";  //! Sıralama Türü
                $order = request('order') ? request('order') : "desc";  //! Sıralama [asc = Küçükten -> Büyüğe] [ desc = Büyükten -> Küçüğe ]
                //echo "order: "; echo $order; die();

                //! Kategoriler
                $categories = request('categories') ? request('categories') : "";  //! Params - Kategoriler
                $dizi_categories=explode("_",$categories);
                //echo "categories: "; echo $categories; die();
                //echo "<pre>"; print_r($dizi_categories); die();

                $DB["categories"] =  $categories;
                $DB["dizi_categories"] =  $dizi_categories;
                //! Kategoriler Son
                
                //! Sayfada veri gösterme sayısı hesaplama
                if($page) {
                    $page = $page - 1; //! Sayfa Numarası
                    if($page <= 0) { $page = 0; }
                } else { $page = 0; }

                 
                //! Ürünler Listesi Kontrol
                $DB_Products= DB::table('products')
                ->join('product_categories', 'product_categories.uid', '=', 'products.category')
                ->leftJoin('web_user_cart', 'web_user_cart.product_uid', '=', 'products.uid')
                ->leftJoin('web_user_wish', 'web_user_wish.product_uid', '=', 'products.uid')
                ->select(   'products.*', 
                            'product_categories.uid as product_categories_uid',
                            'product_categories.title as product_categories_title',
                            'product_categories.seo_url as product_categories_seo_url',
                            'web_user_cart.user_id as web_users_id',
                            DB::raw('(CASE web_user_cart.user_id WHEN '.$web_userId.' THEN true ELSE false END) AS web_user_cart_control'),
                            DB::raw('(CASE web_user_wish.user_id WHEN '.$web_userId.' THEN true ELSE false END) AS web_user_wish_control'),
                       )
                ->groupBy('products.uid')
                ->where('products.lang','=',__('admin.lang'))
                ->where('products.new_product','=',1)
                ->where('products.isActive','=',1);
                
                //! Arama
                $parameter_search = request('search');
                if($parameter_search) { $DB_Products = $DB_Products->where('products.title','like','%'.$parameter_search.'%');  }

                if( trim($categories) != "") { $DB_Products = $DB_Products->whereIn('products.category',$dizi_categories); }
                
                //! Sayfa Sayısı Hesaplama
                $DB_Count = count($DB_Products->get()); //! Veri Sayısı
                $pageNow = $page+1; //! Bulunduğu Sayfa
                $pageTop = ceil($DB_Count / $rowcount); //! Toplam Sayfa
                //echo "DB_Count: "; echo $DB_Count; die();
                //echo "pageNow: "; echo $pageNow; die();
                //echo "pageTop: "; echo $pageTop; die();
                
                //! Ürün Listesi
                $DB_Products_List = $DB_Products
                ->skip($rowcount*$page)->take($rowcount)
                ->orderBy($orderBy,$order)
                ->get();
                //echo "<pre>"; print_r($DB_Products_List); die();

                //! Return
                $DB["page"] =  $page; //! Params Sayfa Sayısı
                $DB["rowcount"] =  $rowcount; //! Params Sayfada Gösterilecek Veri Sayısı
                $DB["orderBy"] =  $orderBy; //! Params Sıralama Türü
                $DB["order"] =  $order; //! Params Sıralama
                
                $DB["pageNow"] =  $pageNow; //! Şimdiki Sayfa
                $DB["pageTop"] =  $pageTop; //! Toplam Sayfa
                $DB["DB_Count"] =  $DB_Count; //! Toplam Ürün Sayısı

                $DB["DB_Products_Title"] =  __('admin.newProduct');
                $DB["DB_Products"] =  $DB_Products_List; //! Toplam Ürün Listesi
                $DB["DB_Products_Count"] =  count($DB_Products_List); //! Gösterilen Ürün Sayısı
                //! Ürünler Listesi Kontrol - Son

                return view('web/product/productList',$DB);
            } //! Web
        
        } catch (\Throwable $th) {  throw $th; }

    } //! Ürün Listesi - Yeni Ürünler Son
    
    //! Ürün Listesi - Çok Satan Ürünler
    public function ProductListBestseller($site_lang="tr")
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>"; die();

        try {

            //! Sayfa Kontrol
            if($site_lang == "admin") {  return redirect('/'.__('admin.lang').'/'.'admin/');  } //! Admin
            else { 

                //! Site Bilgileri
                $DB_HomeSettings= DB::table('homesettings')->where('id','=',2)->first();
                $seo_keywords =  $DB_HomeSettings->seo_keywords;
                //echo "<pre>"; print_r($DB_HomeSettings); die();

                $DB["DB_HomeSettings"] =  $DB_HomeSettings;
                $DB["seo_keywords"] =  $seo_keywords;
                //! Site Bilgileri Son
                
                //! Web UserId
                $web_userId = 0;
                if(isset($_COOKIE["web_userId"])) { $web_userId = (int)$_COOKIE["web_userId"]; }
                //echo "web_userId:"; echo $web_userId; die();
                                            
                //! Kullanıcı Sepet Listesi
                $DB_web_user_cart= DB::table('web_user_cart')
                ->join('products', 'products.uid', '=', 'web_user_cart.product_uid')
                ->join('web_users', 'web_users.id', '=', 'web_user_cart.user_id')
                ->select('web_user_cart.*', 
                        'products.title as productsTitle','products.img_url as productsImg',
                        'products.uid as productsUid','products.seo_url as productsSeo_url',
                        'products.currency as productsCurrency',
                        DB::raw('(CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END) AS productsPrice'),
                        DB::raw('((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) AS productsTotalPrice'),
                        DB::raw('SUM((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) OVER() AS productsAllTotalPrice'),
                        'web_users.name as userName',
                        'web_users.surname as userSurName'
                        )
                ->where('web_user_cart.user_id','=', $web_userId)
                ->where('web_user_cart.isActive','=',1)
                ->orderBy('web_user_cart.id','desc')
                ->get();
                //echo "<pre>"; print_r($DB_web_user_cart); die();

                //! Return
                $DB["DB_web_user_cart"] =  $DB_web_user_cart;
                $DB["productsCount"] =  $DB_web_user_cart->count();
                $DB["productsCurrency"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsCurrency : "TL";
                $DB["productsAllTotalPrice"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsAllTotalPrice : 0;
                //! Kullanıcı Sepet Listesi -  Son
                                
                //! Kullanıcı İstek Listesi - Sayısı
                $DB_web_user_wish_count = DB::table('web_user_wish')->where('web_user_wish.user_id','=', $web_userId)->count(); //! İstek Listesi - Sayısı
                //echo "DB_web_user_wish_count:"; echo $DB_web_user_wish_count; die();

                //! Return
                $DB["DB_web_user_wish_count"] =  $DB_web_user_wish_count;
                //! Kullanıcı İstek Listesi - Sayısı - Son

                //! Ürün Kategorisi
                $DB_product_categories= DB::table('product_categories')
                ->orderBy('product_categories.id','desc')
                ->where('product_categories.lang','=',__('admin.lang'))
                ->where('product_categories.isActive','=',1)->get();
                //echo "<pre>"; print_r($DB_product_categories); die();

                //! Return
                $DB["DB_product_categories"] =  $DB_product_categories;
                //! Ürün Kategorisi Son

                //! Params - Url Veri Alma
                // ?page=10&rowcount=10&order=desc

                $page = request('page'); //! Sayfa Numarası
                $rowcount = request('rowcount') ? request('rowcount') : 20; //! Sayfada Gösterecek Veri Sayısı
                $orderBy = request('orderBy') ? request('orderBy') : "products.uid";  //! Sıralama Türü
                $order = request('order') ? request('order') : "desc";  //! Sıralama [asc = Küçükten -> Büyüğe] [ desc = Büyükten -> Küçüğe ]
                //echo "order: "; echo $order; die();

                //! Kategoriler
                $categories = request('categories') ? request('categories') : "";  //! Params - Kategoriler
                $dizi_categories=explode("_",$categories);
                //echo "categories: "; echo $categories; die();
                //echo "<pre>"; print_r($dizi_categories); die();

                $DB["categories"] =  $categories;
                $DB["dizi_categories"] =  $dizi_categories;
                //! Kategoriler Son
                
                //! Sayfada veri gösterme sayısı hesaplama
                if($page) {
                    $page = $page - 1; //! Sayfa Numarası
                    if($page <= 0) { $page = 0; }
                } else { $page = 0; }
                
                                
                //! Ürünler Listesi Kontrol
                $DB_Products= DB::table('products')
                ->join('product_categories', 'product_categories.uid', '=', 'products.category')
                ->leftJoin('web_user_cart', 'web_user_cart.product_uid', '=', 'products.uid')
                ->leftJoin('web_user_wish', 'web_user_wish.product_uid', '=', 'products.uid')
                ->select(   'products.*', 
                            'product_categories.uid as product_categories_uid',
                            'product_categories.title as product_categories_title',
                            'product_categories.seo_url as product_categories_seo_url',
                            'web_user_cart.user_id as web_users_id',
                            DB::raw('(CASE web_user_cart.user_id WHEN '.$web_userId.' THEN true ELSE false END) AS web_user_cart_control'),
                            DB::raw('(CASE web_user_wish.user_id WHEN '.$web_userId.' THEN true ELSE false END) AS web_user_wish_control'),
                       )
                ->groupBy('products.uid')
                ->where('products.lang','=',__('admin.lang'))
                ->where('products.bestseller','=',1)
                ->where('products.isActive','=',1);
                
                //! Arama
                $parameter_search = request('search');
                if($parameter_search) { $DB_Products = $DB_Products->where('products.title','like','%'.$parameter_search.'%');  }

                if( trim($categories) != "") { $DB_Products = $DB_Products->whereIn('products.category',$dizi_categories); }
                
                //! Sayfa Sayısı Hesaplama
                $DB_Count = count($DB_Products->get()); //! Veri Sayısı
                $pageNow = $page+1; //! Bulunduğu Sayfa
                $pageTop = ceil($DB_Count / $rowcount); //! Toplam Sayfa
                //echo "DB_Count: "; echo $DB_Count; die();
                //echo "pageNow: "; echo $pageNow; die();
                //echo "pageTop: "; echo $pageTop; die();
                
                //! Ürün Listesi
                $DB_Products_List = $DB_Products
                ->skip($rowcount*$page)->take($rowcount)
                ->orderBy($orderBy,$order)
                ->get();
                //echo "<pre>"; print_r($DB_Products_List); die();

                //! Return
                $DB["page"] =  $page; //! Params Sayfa Sayısı
                $DB["rowcount"] =  $rowcount; //! Params Sayfada Gösterilecek Veri Sayısı
                $DB["orderBy"] =  $orderBy; //! Params Sıralama Türü
                $DB["order"] =  $order; //! Params Sıralama
                
                $DB["pageNow"] =  $pageNow; //! Şimdiki Sayfa
                $DB["pageTop"] =  $pageTop; //! Toplam Sayfa
                $DB["DB_Count"] =  $DB_Count; //! Toplam Ürün Sayısı

                $DB["DB_Products_Title"] =  __('admin.bestseller');
                $DB["DB_Products"] =  $DB_Products_List; //! Toplam Ürün Listesi
                $DB["DB_Products_Count"] =  count($DB_Products_List); //! Gösterilen Ürün Sayısı
                //! Ürünler Listesi Kontrol - Son

                return view('web/product/productList',$DB);
            } //! Web
        
        } catch (\Throwable $th) {  throw $th; }

    } //! Ürün Listesi - Çok Satan Ürünler Son
        
    //! Ürün Listesi - Editörün Önerisi
    public function ProductListEditorSuggestion($site_lang="tr")
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>"; die();

        try {

            //! Sayfa Kontrol
            if($site_lang == "admin") {  return redirect('/'.__('admin.lang').'/'.'admin/');  } //! Admin
            else { 

                //! Site Bilgileri
                $DB_HomeSettings= DB::table('homesettings')->where('id','=',2)->first();
                $seo_keywords =  $DB_HomeSettings->seo_keywords;
                //echo "<pre>"; print_r($DB_HomeSettings); die();

                $DB["DB_HomeSettings"] =  $DB_HomeSettings;
                $DB["seo_keywords"] =  $seo_keywords;
                //! Site Bilgileri Son
                
                //! Web UserId
                $web_userId = 0;
                if(isset($_COOKIE["web_userId"])) { $web_userId = (int)$_COOKIE["web_userId"]; }
                //echo "web_userId:"; echo $web_userId; die();
                                            
                //! Kullanıcı Sepet Listesi
                $DB_web_user_cart= DB::table('web_user_cart')
                ->join('products', 'products.uid', '=', 'web_user_cart.product_uid')
                ->join('web_users', 'web_users.id', '=', 'web_user_cart.user_id')
                ->select('web_user_cart.*', 
                        'products.title as productsTitle','products.img_url as productsImg',
                        'products.uid as productsUid','products.seo_url as productsSeo_url',
                        'products.currency as productsCurrency',
                        DB::raw('(CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END) AS productsPrice'),
                        DB::raw('((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) AS productsTotalPrice'),
                        DB::raw('SUM((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) OVER() AS productsAllTotalPrice'),
                        'web_users.name as userName',
                        'web_users.surname as userSurName'
                        )
                ->where('web_user_cart.user_id','=', $web_userId)
                ->where('web_user_cart.isActive','=',1)
                ->orderBy('web_user_cart.id','desc')
                ->get();
                //echo "<pre>"; print_r($DB_web_user_cart); die();

                //! Return
                $DB["DB_web_user_cart"] =  $DB_web_user_cart;
                $DB["productsCount"] =  $DB_web_user_cart->count();
                $DB["productsCurrency"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsCurrency : "TL";
                $DB["productsAllTotalPrice"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsAllTotalPrice : 0;
                //! Kullanıcı Sepet Listesi -  Son
                                
                //! Kullanıcı İstek Listesi - Sayısı
                $DB_web_user_wish_count = DB::table('web_user_wish')->where('web_user_wish.user_id','=', $web_userId)->count(); //! İstek Listesi - Sayısı
                //echo "DB_web_user_wish_count:"; echo $DB_web_user_wish_count; die();

                //! Return
                $DB["DB_web_user_wish_count"] =  $DB_web_user_wish_count;
                //! Kullanıcı İstek Listesi - Sayısı - Son

                //! Ürün Kategorisi
                $DB_product_categories= DB::table('product_categories')
                ->orderBy('product_categories.id','desc')
                ->where('product_categories.lang','=',__('admin.lang'))
                ->where('product_categories.isActive','=',1)->get();
                //echo "<pre>"; print_r($DB_product_categories); die();

                //! Return
                $DB["DB_product_categories"] =  $DB_product_categories;
                //! Ürün Kategorisi Son

                //! Params - Url Veri Alma
                // ?page=10&rowcount=10&order=desc

                $page = request('page'); //! Sayfa Numarası
                $rowcount = request('rowcount') ? request('rowcount') : 20; //! Sayfada Gösterecek Veri Sayısı
                $orderBy = request('orderBy') ? request('orderBy') : "products.uid";  //! Sıralama Türü
                $order = request('order') ? request('order') : "desc";  //! Sıralama [asc = Küçükten -> Büyüğe] [ desc = Büyükten -> Küçüğe ]
                //echo "order: "; echo $order; die();

                //! Kategoriler
                $categories = request('categories') ? request('categories') : "";  //! Params - Kategoriler
                $dizi_categories=explode("_",$categories);
                //echo "categories: "; echo $categories; die();
                //echo "<pre>"; print_r($dizi_categories); die();

                $DB["categories"] =  $categories;
                $DB["dizi_categories"] =  $dizi_categories;
                //! Kategoriler Son
                
                //! Sayfada veri gösterme sayısı hesaplama
                if($page) {
                    $page = $page - 1; //! Sayfa Numarası
                    if($page <= 0) { $page = 0; }
                } else { $page = 0; }
                                
                //! Ürünler Listesi Kontrol
                $DB_Products= DB::table('products')
                ->join('product_categories', 'product_categories.uid', '=', 'products.category')
                ->leftJoin('web_user_cart', 'web_user_cart.product_uid', '=', 'products.uid')
                ->leftJoin('web_user_wish', 'web_user_wish.product_uid', '=', 'products.uid')
                ->select(   'products.*', 
                            'product_categories.uid as product_categories_uid',
                            'product_categories.title as product_categories_title',
                            'product_categories.seo_url as product_categories_seo_url',
                            'web_user_cart.user_id as web_users_id',
                            DB::raw('(CASE web_user_cart.user_id WHEN '.$web_userId.' THEN true ELSE false END) AS web_user_cart_control'),
                            DB::raw('(CASE web_user_wish.user_id WHEN '.$web_userId.' THEN true ELSE false END) AS web_user_wish_control'),
                       )
                ->groupBy('products.uid')
                ->where('products.lang','=',__('admin.lang'))
                ->where('products.editor_suggestion','=',1)
                ->where('products.isActive','=',1);
                
                //! Arama
                $parameter_search = request('search');
                if($parameter_search) { $DB_Products = $DB_Products->where('products.title','like','%'.$parameter_search.'%');  }

                if( trim($categories) != "") { $DB_Products = $DB_Products->whereIn('products.category',$dizi_categories); }
                
                //! Sayfa Sayısı Hesaplama
                $DB_Count = count($DB_Products->get()); //! Veri Sayısı
                $pageNow = $page+1; //! Bulunduğu Sayfa
                $pageTop = ceil($DB_Count / $rowcount); //! Toplam Sayfa
                //echo "DB_Count: "; echo $DB_Count; die();
                //echo "pageNow: "; echo $pageNow; die();
                //echo "pageTop: "; echo $pageTop; die();
                
                //! Ürün Listesi
                $DB_Products_List = $DB_Products
                ->skip($rowcount*$page)->take($rowcount)
                ->orderBy($orderBy,$order)
                ->get();
                //echo "<pre>"; print_r($DB_Products_List); die();

                //! Return
                $DB["page"] =  $page; //! Params Sayfa Sayısı
                $DB["rowcount"] =  $rowcount; //! Params Sayfada Gösterilecek Veri Sayısı
                $DB["orderBy"] =  $orderBy; //! Params Sıralama Türü
                $DB["order"] =  $order; //! Params Sıralama
                
                $DB["pageNow"] =  $pageNow; //! Şimdiki Sayfa
                $DB["pageTop"] =  $pageTop; //! Toplam Sayfa
                $DB["DB_Count"] =  $DB_Count; //! Toplam Ürün Sayısı

                $DB["DB_Products_Title"] =  __('admin.editorSuggestion');
                $DB["DB_Products"] =  $DB_Products_List; //! Toplam Ürün Listesi
                $DB["DB_Products_Count"] =  count($DB_Products_List); //! Gösterilen Ürün Sayısı
                //! Ürünler Listesi Kontrol - Son

                return view('web/product/productList',$DB);
            } //! Web
        
        } catch (\Throwable $th) {  throw $th; }

    } //! Ürün Listesi - Editörün Önerisi Son
    
    //! Ürün Detay
    public function ProductView($site_lang="tr",$seo_url)
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>"; die();

        try {

            //! Sayfa Kontrol
            if($site_lang == "admin") {  return redirect('/'.__('admin.lang').'/'.'admin/');  } //! Admin
            else { 

                //! Site Bilgileri
                $DB_HomeSettings= DB::table('homesettings')->where('id','=',2)->first();
                $seo_keywords =  $DB_HomeSettings->seo_keywords;
                //echo "<pre>"; print_r($DB_HomeSettings); die();

                $DB["DB_HomeSettings"] =  $DB_HomeSettings;
                $DB["seo_keywords"] =  $seo_keywords;
                //! Site Bilgileri Son
                
                //! Web UserId
                $web_userId = 0;
                if(isset($_COOKIE["web_userId"])) { $web_userId = (int)$_COOKIE["web_userId"]; }
                //echo "web_userId:"; echo $web_userId; die();
                                           
                //! Kullanıcı Sepet Listesi
                $DB_web_user_cart= DB::table('web_user_cart')
                ->join('products', 'products.uid', '=', 'web_user_cart.product_uid')
                ->join('web_users', 'web_users.id', '=', 'web_user_cart.user_id')
                ->select('web_user_cart.*', 
                          'products.title as productsTitle','products.img_url as productsImg',
                          'products.uid as productsUid','products.seo_url as productsSeo_url',
                          'products.currency as productsCurrency',
                          DB::raw('(CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END) AS productsPrice'),
                          DB::raw('((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) AS productsTotalPrice'),
                          DB::raw('SUM((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) OVER() AS productsAllTotalPrice'),
                          'web_users.name as userName',
                          'web_users.surname as userSurName'
                        )
                ->where('web_user_cart.user_id','=', $web_userId)
                ->where('web_user_cart.isActive','=',1)
                ->orderBy('web_user_cart.id','desc')
                ->get();
                //echo "<pre>"; print_r($DB_web_user_cart); die();

                //! Return
                $DB["DB_web_user_cart"] =  $DB_web_user_cart;
                $DB["productsCount"] =  $DB_web_user_cart->count();
                $DB["productsCurrency"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsCurrency : "TL";
                $DB["productsAllTotalPrice"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsAllTotalPrice : 0;
                //! Kullanıcı Sepet Listesi -  Son
                                
                //! Kullanıcı İstek Listesi - Sayısı
                $DB_web_user_wish_count = DB::table('web_user_wish')->where('web_user_wish.user_id','=', $web_userId)->count(); //! İstek Listesi - Sayısı
                //echo "DB_web_user_wish_count:"; echo $DB_web_user_wish_count; die();

                //! Return
                $DB["DB_web_user_wish_count"] =  $DB_web_user_wish_count;
                //! Kullanıcı İstek Listesi - Sayısı - Son

                //! Ürün Verileri
               
                //! Uid
                $dizi=explode("-",$seo_url); //! Parçıyor
                $uid = $dizi[0]; //! uid
                //echo "uid:"; echo $uid; //! uid
  

                $DB_Find= DB::table('products')
                          ->join('product_categories', 'product_categories.uid', '=', 'products.category')
                          ->leftJoin('web_user_cart', 'web_user_cart.product_uid', '=', 'products.uid')
                          ->leftJoin('web_user_wish', 'web_user_wish.product_uid', '=', 'products.uid')
                          ->select('products.*',
                                   'product_categories.uid as product_categories_uid',
                                   'product_categories.title as product_categories_title',
                                   'product_categories.seo_url as product_categories_seo_url',
                                    DB::raw('(CASE web_user_cart.user_id WHEN '.$web_userId.' THEN true ELSE false END) AS web_user_cart_control'),
                                    DB::raw('(CASE web_user_wish.user_id WHEN '.$web_userId.' THEN true ELSE false END) AS web_user_wish_control'),
                                  )
                          ->where('products.lang','=',__('admin.lang'))
                          ->where('products.uid','=',$uid)
                          ->first();
                //echo "<pre>"; print_r($DB_Find); die();
            
                //! Return
                $DB["DB_Find"] =  $DB_Find;
                $DB["seoTitle"] =  $DB_Find->seo_url;
                //! Ürün Verileri Son

                return view('web/product/product_view',$DB);
            } //! Web
        
        } catch (\Throwable $th) {  throw $th; }

    } //! Ürün Detay Son

    //************* Web - Blog ***************** */

    //! Blog
    public function Blog($site_lang="tr")
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>"; die();

        try {

            //! Sayfa Kontrol
            if($site_lang == "admin") {  return redirect('/'.__('admin.lang').'/'.'admin/');  } //! Admin
            else { 

                //! Site Bilgileri
                $DB_HomeSettings= DB::table('homesettings')->where('id','=',2)->first();
                $seo_keywords =  $DB_HomeSettings->seo_keywords;
                //echo "<pre>"; print_r($DB_HomeSettings); die();

                $DB["DB_HomeSettings"] =  $DB_HomeSettings;
                $DB["seo_keywords"] =  $seo_keywords;
                //! Site Bilgileri Son
                
                //! Web UserId
                $web_userId = 0;
                if(isset($_COOKIE["web_userId"])) { $web_userId = (int)$_COOKIE["web_userId"]; }
                //echo "web_userId:"; echo $web_userId; die();
                                           
                //! Kullanıcı Sepet Listesi
                $DB_web_user_cart= DB::table('web_user_cart')
                ->join('products', 'products.uid', '=', 'web_user_cart.product_uid')
                ->join('web_users', 'web_users.id', '=', 'web_user_cart.user_id')
                ->select('web_user_cart.*', 
                          'products.title as productsTitle','products.img_url as productsImg',
                          'products.uid as productsUid','products.seo_url as productsSeo_url',
                          'products.currency as productsCurrency',
                          DB::raw('(CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END) AS productsPrice'),
                          DB::raw('((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) AS productsTotalPrice'),
                          DB::raw('SUM((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) OVER() AS productsAllTotalPrice'),
                          'web_users.name as userName',
                          'web_users.surname as userSurName'
                        )
                ->where('web_user_cart.user_id','=', $web_userId)
                ->where('web_user_cart.isActive','=',1)
                ->orderBy('web_user_cart.id','desc')
                ->get();
                //echo "<pre>"; print_r($DB_web_user_cart); die();

                //! Return
                $DB["DB_web_user_cart"] =  $DB_web_user_cart;
                $DB["productsCount"] =  $DB_web_user_cart->count();
                $DB["productsCurrency"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsCurrency : "TL";
                $DB["productsAllTotalPrice"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsAllTotalPrice : 0;
                //! Kullanıcı Sepet Listesi -  Son
                                
                //! Kullanıcı İstek Listesi - Sayısı
                $DB_web_user_wish_count = DB::table('web_user_wish')->where('web_user_wish.user_id','=', $web_userId)->count(); //! İstek Listesi - Sayısı
                //echo "DB_web_user_wish_count:"; echo $DB_web_user_wish_count; die();

                //! Return
                $DB["DB_web_user_wish_count"] =  $DB_web_user_wish_count;
                //! Kullanıcı İstek Listesi - Sayısı - Son


                return view('web/blog/blog',$DB);
            } //! Web
        
        } catch (\Throwable $th) {  throw $th; }

    } //! Blog Son
    
    //! Blog - Detay
    public function BlogSingle($site_lang="tr")
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>"; die();

        try {

            //! Sayfa Kontrol
            if($site_lang == "admin") {  return redirect('/'.__('admin.lang').'/'.'admin/');  } //! Admin
            else { 

                //! Site Bilgileri
                $DB_HomeSettings= DB::table('homesettings')->where('id','=',2)->first();
                $seo_keywords =  $DB_HomeSettings->seo_keywords;
                //echo "<pre>"; print_r($DB_HomeSettings); die();

                $DB["DB_HomeSettings"] =  $DB_HomeSettings;
                $DB["seo_keywords"] =  $seo_keywords;
                //! Site Bilgileri Son
               
                //! Web UserId
                $web_userId = 0;
                if(isset($_COOKIE["web_userId"])) { $web_userId = (int)$_COOKIE["web_userId"]; }
                //echo "web_userId:"; echo $web_userId; die();
                                           
                //! Kullanıcı Sepet Listesi
                $DB_web_user_cart= DB::table('web_user_cart')
                ->join('products', 'products.uid', '=', 'web_user_cart.product_uid')
                ->join('web_users', 'web_users.id', '=', 'web_user_cart.user_id')
                ->select('web_user_cart.*', 
                          'products.title as productsTitle','products.img_url as productsImg',
                          'products.uid as productsUid','products.seo_url as productsSeo_url',
                          'products.currency as productsCurrency',
                          DB::raw('(CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END) AS productsPrice'),
                          DB::raw('((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) AS productsTotalPrice'),
                          DB::raw('SUM((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) OVER() AS productsAllTotalPrice'),
                          'web_users.name as userName',
                          'web_users.surname as userSurName'
                        )
                ->where('web_user_cart.user_id','=', $web_userId)
                ->where('web_user_cart.isActive','=',1)
                ->orderBy('web_user_cart.id','desc')
                ->get();
                //echo "<pre>"; print_r($DB_web_user_cart); die();

                //! Return
                $DB["DB_web_user_cart"] =  $DB_web_user_cart;
                $DB["productsCount"] =  $DB_web_user_cart->count();
                $DB["productsCurrency"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsCurrency : "TL";
                $DB["productsAllTotalPrice"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsAllTotalPrice : 0;
                //! Kullanıcı Sepet Listesi -  Son
                                
                //! Kullanıcı İstek Listesi - Sayısı
                $DB_web_user_wish_count = DB::table('web_user_wish')->where('web_user_wish.user_id','=', $web_userId)->count(); //! İstek Listesi - Sayısı
                //echo "DB_web_user_wish_count:"; echo $DB_web_user_wish_count; die();

                //! Return
                $DB["DB_web_user_wish_count"] =  $DB_web_user_wish_count;
                //! Kullanıcı İstek Listesi - Sayısı - Son

                return view('web/blog/blog-single',$DB);
            } //! Web
        
        } catch (\Throwable $th) {  throw $th; }

    } //! BlogSingle Son
    
    //************* Web - Sayfalar ***************** */

    //! Faq
    public function Faq($site_lang="tr")
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>"; die();

        try {

            //! Sayfa Kontrol
            if($site_lang == "admin") {  return redirect('/'.__('admin.lang').'/'.'admin/');  } //! Admin
            else { 

                //! Site Bilgileri
                $DB_HomeSettings= DB::table('homesettings')->where('id','=',2)->first();
                $seo_keywords =  $DB_HomeSettings->seo_keywords;
                //echo "<pre>"; print_r($DB_HomeSettings); die();

                $DB["DB_HomeSettings"] =  $DB_HomeSettings;
                $DB["seo_keywords"] =  $seo_keywords;
                //! Site Bilgileri Son

                
                //! Web UserId
                $web_userId = 0;
                if(isset($_COOKIE["web_userId"])) { $web_userId = (int)$_COOKIE["web_userId"]; }
                //echo "web_userId:"; echo $web_userId; die();
                                           
                //! Kullanıcı Sepet Listesi
                $DB_web_user_cart= DB::table('web_user_cart')
                ->join('products', 'products.uid', '=', 'web_user_cart.product_uid')
                ->join('web_users', 'web_users.id', '=', 'web_user_cart.user_id')
                ->select('web_user_cart.*', 
                          'products.title as productsTitle','products.img_url as productsImg',
                          'products.uid as productsUid','products.seo_url as productsSeo_url',
                          'products.currency as productsCurrency',
                          DB::raw('(CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END) AS productsPrice'),
                          DB::raw('((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) AS productsTotalPrice'),
                          DB::raw('SUM((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) OVER() AS productsAllTotalPrice'),
                          'web_users.name as userName',
                          'web_users.surname as userSurName'
                        )
                ->where('web_user_cart.user_id','=', $web_userId)
                ->where('web_user_cart.isActive','=',1)
                ->orderBy('web_user_cart.id','desc')
                ->get();
                //echo "<pre>"; print_r($DB_web_user_cart); die();

                //! Return
                $DB["DB_web_user_cart"] =  $DB_web_user_cart;
                $DB["productsCount"] =  $DB_web_user_cart->count();
                $DB["productsCurrency"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsCurrency : "TL";
                $DB["productsAllTotalPrice"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsAllTotalPrice : 0;
                //! Kullanıcı Sepet Listesi -  Son
                                
                //! Kullanıcı İstek Listesi - Sayısı
                $DB_web_user_wish_count = DB::table('web_user_wish')->where('web_user_wish.user_id','=', $web_userId)->count(); //! İstek Listesi - Sayısı
                //echo "DB_web_user_wish_count:"; echo $DB_web_user_wish_count; die();

                //! Return
                $DB["DB_web_user_wish_count"] =  $DB_web_user_wish_count;
                //! Kullanıcı İstek Listesi - Sayısı - Son

                //! Sıksa Sorulan Sorular -  Kategorisi
                $DB_faq_categories= DB::table('faq_categories')
                ->orderBy('faq_categories.id','desc')
                ->where('faq_categories.lang','=',__('admin.lang'))
                ->where('faq_categories.isActive','=',1)->get();
                //echo "<pre>"; print_r($DB_faq_categories); die();

                //! Return
                $DB["DB_faq_categories"] =  $DB_faq_categories;
                //! Sıksa Sorulan Sorular -  Kategorisi Son

                //! Sık Sorulan Sorular
                $DB_Faqs= DB::table('faq')
                ->join('faq_categories', 'faq_categories.uid', '=', 'faq.category')
                ->select('faq.*', 'faq_categories.title as CategoryTitle')
                ->where('faq.lang','=',__('admin.lang'))
                ->where('faq.isActive','=',1)
                //->skip(0)->take(20)
                ->orderBy('faq.uid','desc')
                ->get();
                //echo "<pre>"; print_r($DB_Faqs); die();

                //! Return
                $DB["DB_Faqs"] =  $DB_Faqs;
                //! Sık Sorulan Sorular


                return view('web/faq',$DB);
            } //! Web
        
        } catch (\Throwable $th) {  throw $th; }

    } //! Faq Son

    //! İletişim
    public function Contact($site_lang="tr")
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>"; die();

        try {

            //! Sayfa Kontrol
            if($site_lang == "admin") {  return redirect('/'.__('admin.lang').'/'.'admin/');  } //! Admin
            else { 

                //! Site Bilgileri
                $DB_HomeSettings= DB::table('homesettings')->where('id','=',2)->first();
                $seo_keywords =  $DB_HomeSettings->seo_keywords;
                //echo "<pre>"; print_r($DB_HomeSettings); die();

                $DB["DB_HomeSettings"] =  $DB_HomeSettings;
                $DB["seo_keywords"] =  $seo_keywords;
                //! Site Bilgileri Son

               
                //! Web UserId
                $web_userId = 0;
                if(isset($_COOKIE["web_userId"])) { $web_userId = (int)$_COOKIE["web_userId"]; }
                //echo "web_userId:"; echo $web_userId; die();
                                           
                //! Kullanıcı Sepet Listesi
                $DB_web_user_cart= DB::table('web_user_cart')
                ->join('products', 'products.uid', '=', 'web_user_cart.product_uid')
                ->join('web_users', 'web_users.id', '=', 'web_user_cart.user_id')
                ->select('web_user_cart.*', 
                          'products.title as productsTitle','products.img_url as productsImg',
                          'products.uid as productsUid','products.seo_url as productsSeo_url',
                          'products.currency as productsCurrency',
                          DB::raw('(CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END) AS productsPrice'),
                          DB::raw('((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) AS productsTotalPrice'),
                          DB::raw('SUM((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) OVER() AS productsAllTotalPrice'),
                          'web_users.name as userName',
                          'web_users.surname as userSurName'
                        )
                ->where('web_user_cart.user_id','=', $web_userId)
                ->where('web_user_cart.isActive','=',1)
                ->orderBy('web_user_cart.id','desc')
                ->get();
                //echo "<pre>"; print_r($DB_web_user_cart); die();

                //! Return
                $DB["DB_web_user_cart"] =  $DB_web_user_cart;
                $DB["productsCount"] =  $DB_web_user_cart->count();
                $DB["productsCurrency"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsCurrency : "TL";
                $DB["productsAllTotalPrice"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsAllTotalPrice : 0;
                //! Kullanıcı Sepet Listesi -  Son
                                
                //! Kullanıcı İstek Listesi - Sayısı
                $DB_web_user_wish_count = DB::table('web_user_wish')->where('web_user_wish.user_id','=', $web_userId)->count(); //! İstek Listesi - Sayısı
                //echo "DB_web_user_wish_count:"; echo $DB_web_user_wish_count; die();

                //! Return
                $DB["DB_web_user_wish_count"] =  $DB_web_user_wish_count;
                //! Kullanıcı İstek Listesi - Sayısı - Son

                return view('web/contact',$DB);
            } //! Web
        
        } catch (\Throwable $th) {  throw $th; }

    } //! İletişim Son
    
    //! Web - İletişim Mesaj Yaz - Post
    public function ContactMessage(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Ekleme
            DB::table('contact_message')->insert([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
                'created_byId'=>$request->created_byId,
            ]); //! Veri Ekleme Son

            $response = array(
                'status' => 'success',
                'msg' => __('admin.transactionSuccessful'),
                'error' => null, 
            );

            return response()->json($response);
    
        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );
    
            return response()->json($response);
        }

    } //! Web - İletişim Mesaj Yaz - Post - Son
    
    //! About
    public function About($site_lang="tr")
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>"; die();

        try {

            //! Sayfa Kontrol
            if($site_lang == "admin") {  return redirect('/'.__('admin.lang').'/'.'admin/');  } //! Admin
            else { 

                //! Site Bilgileri
                $DB_HomeSettings= DB::table('homesettings')->where('id','=',2)->first();
                $seo_keywords =  $DB_HomeSettings->seo_keywords;
                //echo "<pre>"; print_r($DB_HomeSettings); die();

                $DB["DB_HomeSettings"] =  $DB_HomeSettings;
                $DB["seo_keywords"] =  $seo_keywords;
                //! Site Bilgileri Son
                
                //! Web UserId
                $web_userId = 0;
                if(isset($_COOKIE["web_userId"])) { $web_userId = (int)$_COOKIE["web_userId"]; }
                //echo "web_userId:"; echo $web_userId; die();
                                           
                //! Kullanıcı Sepet Listesi
                $DB_web_user_cart= DB::table('web_user_cart')
                ->join('products', 'products.uid', '=', 'web_user_cart.product_uid')
                ->join('web_users', 'web_users.id', '=', 'web_user_cart.user_id')
                ->select('web_user_cart.*', 
                          'products.title as productsTitle','products.img_url as productsImg',
                          'products.uid as productsUid','products.seo_url as productsSeo_url',
                          'products.currency as productsCurrency',
                          DB::raw('(CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END) AS productsPrice'),
                          DB::raw('((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) AS productsTotalPrice'),
                          DB::raw('SUM((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) OVER() AS productsAllTotalPrice'),
                          'web_users.name as userName',
                          'web_users.surname as userSurName'
                        )
                ->where('web_user_cart.user_id','=', $web_userId)
                ->where('web_user_cart.isActive','=',1)
                ->orderBy('web_user_cart.id','desc')
                ->get();
                //echo "<pre>"; print_r($DB_web_user_cart); die();

                //! Return
                $DB["DB_web_user_cart"] =  $DB_web_user_cart;
                $DB["productsCount"] =  $DB_web_user_cart->count();
                $DB["productsCurrency"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsCurrency : "TL";
                $DB["productsAllTotalPrice"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsAllTotalPrice : 0;
                //! Kullanıcı Sepet Listesi -  Son
                                
                //! Kullanıcı İstek Listesi - Sayısı
                $DB_web_user_wish_count = DB::table('web_user_wish')->where('web_user_wish.user_id','=', $web_userId)->count(); //! İstek Listesi - Sayısı
                //echo "DB_web_user_wish_count:"; echo $DB_web_user_wish_count; die();

                //! Return
                $DB["DB_web_user_wish_count"] =  $DB_web_user_wish_count;
                //! Kullanıcı İstek Listesi - Sayısı - Son

                //! Kurumsal
                $DB_Institutional= DB::table('institutional')->where('lang','=',__('admin.lang'))->first();
                //echo "<pre>"; print_r($DB_Institutional); die();

                //! Referanslar
                $DB_institutional_references= DB::table('institutional_references')
                ->orderBy('institutional_references.id','desc')
                 ->where('institutional_references.isActive','=',1)->get();
                //echo "<pre>"; print_r($DB_institutional_references); die();

                //! Return
                $DB["DB_institutional_references"] =  $DB_institutional_references;
                //! Referanslar Son

                //! Return
                $DB["DB_Institutional"] =  $DB_Institutional;
                //! Kurumsal Son

                return view('web/about',$DB);
            } //! Web
        
        } catch (\Throwable $th) {  throw $th; }

    } //! About Son
        
    //! Error404
    public function Error404($site_lang="tr")
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>"; die();

        try {

            //! Sayfa Kontrol
            if($site_lang == "admin") {  return redirect('/'.__('admin.lang').'/'.'admin/');  } //! Admin
            else { 

                //! Site Bilgileri
                $DB_HomeSettings= DB::table('homesettings')->where('id','=',2)->first();
                $seo_keywords =  $DB_HomeSettings->seo_keywords;
                //echo "<pre>"; print_r($DB_HomeSettings); die();

                $DB["DB_HomeSettings"] =  $DB_HomeSettings;
                $DB["seo_keywords"] =  $seo_keywords;
                //! Site Bilgileri Son

               
                //! Web UserId
                $web_userId = 0;
                if(isset($_COOKIE["web_userId"])) { $web_userId = (int)$_COOKIE["web_userId"]; }
                //echo "web_userId:"; echo $web_userId; die();
                                           
                //! Kullanıcı Sepet Listesi
                $DB_web_user_cart= DB::table('web_user_cart')
                ->join('products', 'products.uid', '=', 'web_user_cart.product_uid')
                ->join('web_users', 'web_users.id', '=', 'web_user_cart.user_id')
                ->select('web_user_cart.*', 
                          'products.title as productsTitle','products.img_url as productsImg',
                          'products.uid as productsUid','products.seo_url as productsSeo_url',
                          'products.currency as productsCurrency',
                          DB::raw('(CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END) AS productsPrice'),
                          DB::raw('((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) AS productsTotalPrice'),
                          DB::raw('SUM((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) OVER() AS productsAllTotalPrice'),
                          'web_users.name as userName',
                          'web_users.surname as userSurName'
                        )
                ->where('web_user_cart.user_id','=', $web_userId)
                ->where('web_user_cart.isActive','=',1)
                ->orderBy('web_user_cart.id','desc')
                ->get();
                //echo "<pre>"; print_r($DB_web_user_cart); die();

                //! Return
                $DB["DB_web_user_cart"] =  $DB_web_user_cart;
                $DB["productsCount"] =  $DB_web_user_cart->count();
                $DB["productsCurrency"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsCurrency : "TL";
                $DB["productsAllTotalPrice"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsAllTotalPrice : 0;
                //! Kullanıcı Sepet Listesi -  Son
                                
                //! Kullanıcı İstek Listesi - Sayısı
                $DB_web_user_wish_count = DB::table('web_user_wish')->where('web_user_wish.user_id','=', $web_userId)->count(); //! İstek Listesi - Sayısı
                //echo "DB_web_user_wish_count:"; echo $DB_web_user_wish_count; die();

                //! Return
                $DB["DB_web_user_wish_count"] =  $DB_web_user_wish_count;
                //! Kullanıcı İstek Listesi - Sayısı - Son

                return view('web/error404',$DB);
            } //! Web
        
        } catch (\Throwable $th) {  throw $th; }

    } //! Error404 Son
            
    //! ComingSoon
    public function ComingSoon($site_lang="tr")
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>"; die();

        try {

            //! Sayfa Kontrol
            if($site_lang == "admin") {  return redirect('/'.__('admin.lang').'/'.'admin/');  } //! Admin
            else { 

                //! Site Bilgileri
                $DB_HomeSettings= DB::table('homesettings')->where('id','=',2)->first();
                $seo_keywords =  $DB_HomeSettings->seo_keywords;
                //echo "<pre>"; print_r($DB_HomeSettings); die();

                $DB["DB_HomeSettings"] =  $DB_HomeSettings;
                $DB["seo_keywords"] =  $seo_keywords;
                //! Site Bilgileri Son

               
                //! Web UserId
                $web_userId = 0;
                if(isset($_COOKIE["web_userId"])) { $web_userId = (int)$_COOKIE["web_userId"]; }
                //echo "web_userId:"; echo $web_userId; die();
                                           
                //! Kullanıcı Sepet Listesi
                $DB_web_user_cart= DB::table('web_user_cart')
                ->join('products', 'products.uid', '=', 'web_user_cart.product_uid')
                ->join('web_users', 'web_users.id', '=', 'web_user_cart.user_id')
                ->select('web_user_cart.*', 
                          'products.title as productsTitle','products.img_url as productsImg',
                          'products.uid as productsUid','products.seo_url as productsSeo_url',
                          'products.currency as productsCurrency',
                          DB::raw('(CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END) AS productsPrice'),
                          DB::raw('((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) AS productsTotalPrice'),
                          DB::raw('SUM((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) OVER() AS productsAllTotalPrice'),
                          'web_users.name as userName',
                          'web_users.surname as userSurName'
                        )
                ->where('web_user_cart.user_id','=', $web_userId)
                ->where('web_user_cart.isActive','=',1)
                ->orderBy('web_user_cart.id','desc')
                ->get();
                //echo "<pre>"; print_r($DB_web_user_cart); die();

                //! Return
                $DB["DB_web_user_cart"] =  $DB_web_user_cart;
                $DB["productsCount"] =  $DB_web_user_cart->count();
                $DB["productsCurrency"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsCurrency : "TL";
                $DB["productsAllTotalPrice"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsAllTotalPrice : 0;
                //! Kullanıcı Sepet Listesi -  Son
                                
                //! Kullanıcı İstek Listesi - Sayısı
                $DB_web_user_wish_count = DB::table('web_user_wish')->where('web_user_wish.user_id','=', $web_userId)->count(); //! İstek Listesi - Sayısı
                //echo "DB_web_user_wish_count:"; echo $DB_web_user_wish_count; die();

                //! Return
                $DB["DB_web_user_wish_count"] =  $DB_web_user_wish_count;
                //! Kullanıcı İstek Listesi - Sayısı - Son

                return view('web/comingSoon',$DB);
            } //! Web
        
        } catch (\Throwable $th) {  throw $th; }

    } //! ComingSoon Son

    //************* Web - Kullanıcı ***************** */
    

    //************* Kullanıcı Giriş ***************** */

    //! Kullanıcı - Giriş
    public function UserLogin($site_lang="tr")
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>"; die();

        try {

            //! Sayfa Kontrol
            if($site_lang == "admin") {  return redirect('/'.__('admin.lang').'/'.'admin/');  } //! Admin
            else { 

                //! Site Bilgileri
                $DB_HomeSettings= DB::table('homesettings')->where('id','=',2)->first();
                $seo_keywords =  $DB_HomeSettings->seo_keywords;
                //echo "<pre>"; print_r($DB_HomeSettings); die();

                $DB["DB_HomeSettings"] =  $DB_HomeSettings;
                $DB["seo_keywords"] =  $seo_keywords;
                //! Site Bilgileri Son
                
                //! Web UserId
                $web_userId = 0;
                if(isset($_COOKIE["web_userId"])) { $web_userId = (int)$_COOKIE["web_userId"]; }
                //echo "web_userId:"; echo $web_userId; die();
                                           
                //! Kullanıcı Sepet Listesi
                $DB_web_user_cart= DB::table('web_user_cart')
                ->join('products', 'products.uid', '=', 'web_user_cart.product_uid')
                ->join('web_users', 'web_users.id', '=', 'web_user_cart.user_id')
                ->select('web_user_cart.*', 
                          'products.title as productsTitle','products.img_url as productsImg',
                          'products.uid as productsUid','products.seo_url as productsSeo_url',
                          'products.currency as productsCurrency',
                          DB::raw('(CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END) AS productsPrice'),
                          DB::raw('((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) AS productsTotalPrice'),
                          DB::raw('SUM((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) OVER() AS productsAllTotalPrice'),
                          'web_users.name as userName',
                          'web_users.surname as userSurName'
                        )
                ->where('web_user_cart.user_id','=', $web_userId)
                ->where('web_user_cart.isActive','=',1)
                ->orderBy('web_user_cart.id','desc')
                ->get();
                //echo "<pre>"; print_r($DB_web_user_cart); die();

                //! Return
                $DB["DB_web_user_cart"] =  $DB_web_user_cart;
                $DB["productsCount"] =  $DB_web_user_cart->count();
                $DB["productsCurrency"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsCurrency : "TL";
                $DB["productsAllTotalPrice"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsAllTotalPrice : 0;
                //! Kullanıcı Sepet Listesi -  Son
                                
                //! Kullanıcı İstek Listesi - Sayısı
                $DB_web_user_wish_count = DB::table('web_user_wish')->where('web_user_wish.user_id','=', $web_userId)->count(); //! İstek Listesi - Sayısı
                //echo "DB_web_user_wish_count:"; echo $DB_web_user_wish_count; die();

                //! Return
                $DB["DB_web_user_wish_count"] =  $DB_web_user_wish_count;
                //! Kullanıcı İstek Listesi - Sayısı - Son

                //! Cookie Silme
                setcookie("web_userId","", time() - 86400,'/'); //! Cookie Silme
                setcookie("web_roleId","", time() - 86400,'/'); //! Cookie Silme


                return view('web/user/login',$DB);
            } //! Web
        
        } catch (\Throwable $th) {  throw $th; }

    } //! Kullanıcı - Giriş Son

    //! Kullanıcı - Giriş Post
    public function UserLoginPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Veri Arama
            $DB_Find = DB::table('web_users')
            ->where('email',$request->email)
            ->where('password',$request->password)
            ->first(); //Tüm verileri çekiyor

            if($DB_Find) {
                
                $url = ""; //! Yönlendiren Url
                $url = "/". __('admin.lang')."/user/profile";

                // if($DB_Find->role_id == 1) { $url = "/". __('admin.lang')."/customer/profile"; }
                // if($DB_Find->role_id == 2) { $url = "/". __('admin.lang')."/company/profile"; }

                //! Return
                $response = array(
                    'status' => 'success',
                    'msg' => __('admin.transactionSuccessful'),
                    'url' =>  $url,
                    'userId' =>  $DB_Find->id,
                    'roleId' =>  $DB_Find->role_id,
                    'error' => null,  
                );

                return response()->json($response);
               
            }
            else {

                $response = array(
                    'status' => 'error',
                    'msg' => __('admin.theEmailPasswordMayBeIncorrect'),
                    'error' => $th,            
                );
        
                return response()->json($response);
                
            }
            
    
        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );
    
            return response()->json($response);
        }

    } //! Kullanıcı - Giriş Post Son

    //! Kullanıcı - Çıkış
    public function UserLogout($site_lang="tr")
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>"; die();

        try {

            //! Sayfa Kontrol
            if($site_lang == "admin") {  return redirect('/'.__('admin.lang').'/'.'admin/');  } //! Admin
            else { 

                setcookie("web_userId","", time() - 86400,'/'); //! Cookie Silme
                setcookie("web_roleId","", time() - 86400,'/'); //! Cookie Silme

                return redirect('/'.__('admin.lang').'/'.'user/login');
                
            } //! Web
        
        } catch (\Throwable $th) {  throw $th; }

    } //! Kullanıcı - Çıkış Son

    //! Kullanıcı - Kayıt Post
    public function UserRegisterPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Veri Arama
            $DB_Find = DB::table('web_users')->where('email',$request->email)->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                $response = array(
                    'status' => 'error',
                    'msg' =>  "Email Kayıtlıdır",
                    'error' => null,  
                );

                return response()->json($response);
            }
            else {

                //! Veri Ekleme
                DB::table('web_users')->insert([
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'phone' => $request->phone,
                    'role_id' => 1,
                    'img_url'=> config('admin.Default_UserImgUrl'),

                    'email' => $request->email,
                    'password' => $request->password,

                    'created_byId'=>$request->created_byId,
                ]); //! Veri Ekleme Son

                $response = array(
                    'status' => 'success',
                    'msg' => __('admin.transactionSuccessful'),
                    'error' => null, 
                );

                return response()->json($response);

            }
    
        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );
    
            return response()->json($response);
        }

    } //! Kullanıcı -  Kayıt Post Son
    
    //************* Kullanıcı Giriş Son ***************** */

        
    //************* Kullanıcı Profil ***************** */

    //! Kullanıcı - Profil
    public function UserProfile($site_lang="tr")
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>"; die();

        try {

            //! Sayfa Kontrol
            if($site_lang == "admin") {  return redirect('/'.__('admin.lang').'/'.'admin/');  } //! Admin
            else { 

                //! Site Bilgileri
                $DB_HomeSettings= DB::table('homesettings')->where('id','=',2)->first();
                $seo_keywords =  $DB_HomeSettings->seo_keywords;
                //echo "<pre>"; print_r($DB_HomeSettings); die();

                $DB["DB_HomeSettings"] =  $DB_HomeSettings;
                $DB["seo_keywords"] =  $seo_keywords;
                //! Site Bilgileri Son

                //! Çerez Bilgileri
                $web_userId = 0;
                if(isset($_COOKIE["web_userId"])) {

                    //! Profil Bilgileri
                    $web_userId = (int)$_COOKIE["web_userId"];
                    //echo "userId:"; echo $userId; die();

                    $DB_ProfileInfo = DB::table('web_users')->where('id','=',$web_userId)->first();
                    //echo "<pre>"; print_r($DB_web_users); die();

                    $DB["DB_ProfileInfo"] =  $DB_ProfileInfo;
                    //! Profil Bilgileri Son
                }
                else { return view('web/user/login',$DB); }
                                        
                //! Kullanıcı Sepet Listesi
                $DB_web_user_cart= DB::table('web_user_cart')
                ->join('products', 'products.uid', '=', 'web_user_cart.product_uid')
                ->join('web_users', 'web_users.id', '=', 'web_user_cart.user_id')
                ->select('web_user_cart.*', 
                        'products.title as productsTitle','products.img_url as productsImg',
                        'products.uid as productsUid','products.seo_url as productsSeo_url',
                        'products.currency as productsCurrency',
                        DB::raw('(CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END) AS productsPrice'),
                        DB::raw('((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) AS productsTotalPrice'),
                        DB::raw('SUM((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) OVER() AS productsAllTotalPrice'),
                        'web_users.name as userName',
                        'web_users.surname as userSurName'
                        )
                ->where('web_user_cart.user_id','=', $web_userId)
                ->where('web_user_cart.isActive','=',1)
                ->orderBy('web_user_cart.id','desc')
                ->get();
                //echo "<pre>"; print_r($DB_web_user_cart); die();

                //! Return
                $DB["DB_web_user_cart"] =  $DB_web_user_cart;
                $DB["productsCount"] =  $DB_web_user_cart->count();
                $DB["productsCurrency"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsCurrency : "TL";
                $DB["productsAllTotalPrice"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsAllTotalPrice : 0;
                //! Kullanıcı Sepet Listesi -  Son
                                
                //! Kullanıcı İstek Listesi - Sayısı
                $DB_web_user_wish_count = DB::table('web_user_wish')->where('web_user_wish.user_id','=', $web_userId)->count(); //! İstek Listesi - Sayısı
                //echo "DB_web_user_wish_count:"; echo $DB_web_user_wish_count; die();

                //! Return
                $DB["DB_web_user_wish_count"] =  $DB_web_user_wish_count;
                //! Kullanıcı İstek Listesi - Sayısı - Son

                return view('web/user/profile',$DB);

            } //! Web
        
        } catch (\Throwable $th) {  throw $th; }

    } //! Kullanıcı - Profil Son

    //! Kullanıcı - Profil - Güncelleme
    public function UserProfileEdit(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {  

            //! Veri Arama
            $DB = DB::table('web_users')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'phone' => $request->phone,
                  
                    'isUpdated'=>true,
                    'updated_at'=>Carbon::now(),
                    'updated_byId'=>$request->updated_byId,
                ]);
                
                $response = array(
                    'status' => $DB_Status ? 'success' : 'error',
                    'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
                    'error' => null,
                );

                return response()->json($response);
            }
            else {

                $response = array(
                    'status' => 'error',
                    'msg' => __('admin.dataNotFound'),
                    'error' => null,
                );

                return response()->json($response);
            }

        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );

            return response()->json($response);
        }

    } //! Kullanıcı - Profil - Güncelleme Son
    
    //! Kullanıcı - Profil - Şifre - Güncelleme
    public function UserSettingsPasswordEdit(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Veri Arama
            $DB = DB::table('web_users')->where('id',$request->id)->where('password',$request->oldPassword); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) { 

                //! Veri Güncelle
                $DB_Status = $DB->update([
                    'password' => $request->password,

                    'isUpdated'=>true,
                    'updated_at'=>Carbon::now(),
                    'updated_byId'=>$request->updated_byId,
                ]);
                
                $response = array(
                    'status' => $DB_Status ? 'success' : 'error',
                    'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
                    'error' => null,
                );

                return response()->json($response);
            }
            else {

                $response = array(
                    'status' => 'error',
                    'msg' => __('admin.dataNotFound'),
                    'error' => null,
                );

                return response()->json($response);
            }

        } catch (\Throwable $th) {
            
            $response = array(
            'status' => 'error',
            'msg' => __('admin.transactionFailed'),
            'error' => $th,            
            );

            return response()->json($response);
        }
    } //! Kullanıcı - Profil - Şifre - Güncelleme Son

    //************* Kullanıcı Profil Son ***************** */

       
    //************* Kullanıcı İstek Listesi ***************** */

    //! Kullanıcı İstek Listesi
    public function UserWishlist($site_lang="tr")
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>"; die();

        try {

            //! Sayfa Kontrol
            if($site_lang == "admin") {  return redirect('/'.__('admin.lang').'/'.'admin/');  } //! Admin
            else { 

                //! Site Bilgileri
                $DB_HomeSettings= DB::table('homesettings')->where('id','=',2)->first();
                $seo_keywords =  $DB_HomeSettings->seo_keywords;
                //echo "<pre>"; print_r($DB_HomeSettings); die();

                $DB["DB_HomeSettings"] =  $DB_HomeSettings;
                $DB["seo_keywords"] =  $seo_keywords;
                //! Site Bilgileri Son

                //! Web UserId
                $web_userId = 0;
                if(isset($_COOKIE["web_userId"])) { $web_userId = (int)$_COOKIE["web_userId"]; }
                //echo "web_userId:"; echo $web_userId; die();
                                        
                //! Kullanıcı Sepet Listesi
                $DB_web_user_cart= DB::table('web_user_cart')
                ->join('products', 'products.uid', '=', 'web_user_cart.product_uid')
                ->join('web_users', 'web_users.id', '=', 'web_user_cart.user_id')
                ->select('web_user_cart.*', 
                        'products.title as productsTitle','products.img_url as productsImg',
                        'products.uid as productsUid','products.seo_url as productsSeo_url',
                        'products.currency as productsCurrency',
                        DB::raw('(CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END) AS productsPrice'),
                        DB::raw('((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) AS productsTotalPrice'),
                        DB::raw('SUM((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) OVER() AS productsAllTotalPrice'),
                        'web_users.name as userName',
                        'web_users.surname as userSurName'
                        )
                ->where('web_user_cart.user_id','=', $web_userId)
                ->where('web_user_cart.isActive','=',1)
                ->orderBy('web_user_cart.id','desc')
                ->get();
                //echo "<pre>"; print_r($DB_web_user_cart); die();

                //! Return
                $DB["DB_web_user_cart"] =  $DB_web_user_cart;
                $DB["productsCount"] =  $DB_web_user_cart->count();
                $DB["productsCurrency"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsCurrency : "TL";
                $DB["productsAllTotalPrice"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsAllTotalPrice : 0;
                //! Kullanıcı Sepet Listesi -  Son

                //! Kullanıcı İstek Listesi - Sayısı
                $DB_web_user_wish_count = DB::table('web_user_wish')->where('web_user_wish.user_id','=', $web_userId)->count(); //! İstek Listesi - Sayısı
                //echo "DB_web_user_wish_count:"; echo $DB_web_user_wish_count; die();

                //! Return
                $DB["DB_web_user_wish_count"] =  $DB_web_user_wish_count;
                //! Kullanıcı İstek Listesi - Sayısı - Son

                //! Kullanıcı İstek Listesi
                $DB_web_user_wish= DB::table('web_user_wish')
                ->join('products', 'products.uid', '=', 'web_user_wish.product_uid')
                ->join('web_users', 'web_users.id', '=', 'web_user_wish.user_id')
                ->select('web_user_wish.*', 
                            'products.title as productsTitle','products.img_url as productsImg',
                            'products.uid as productsUid','products.seo_url as productsSeo_url',
                            'products.currency as productsCurrency',
                            'products.stock as productsStock',
                            DB::raw('(CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END) AS productsPrice'),
                            DB::raw('((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_wish.product_quantity) AS productsTotalPrice'),
                            DB::raw('SUM((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_wish.product_quantity) OVER() AS productsAllTotalPrice'),
                            'web_users.name as userName',
                            'web_users.surname as userSurName',
                        )
                ->where('web_user_wish.user_id','=', $web_userId)
                ->where('web_user_wish.isActive','=',1)
                ->orderBy('web_user_wish.id','desc')
                ->get();
                //echo "<pre>"; print_r($DB_web_user_wish); die();

                //! Return
                $DB["DB_web_user_wish"] =  $DB_web_user_wish;
                $DB["productsCount"] =  $DB_web_user_wish->count();
                $DB["productsCurrency"] =  $DB_web_user_wish->count() > 0 ? $DB_web_user_wish[0]->productsCurrency : "TL";
                $DB["productsAllTotalPrice"] =  $DB_web_user_wish->count() > 0 ? $DB_web_user_wish[0]->productsAllTotalPrice : 0;
                //! Kullanıcı İstek Listesi -  Son

                return view('web/user/wishlist',$DB);
            } //! Web
        
        } catch (\Throwable $th) {  throw $th; }

    } //! Kullanıcı İstek Listesi Son
       
    //! Kullanıcı İstek Listesi Ekle -  Post
    public function UserWishAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Ekleme
            DB::table('web_user_wish')->insert([
                'user_id' => $request->user_id,
                'product_uid' => $request->product_uid,
                'product_quantity' => $request->product_quantity,
                'created_byId'=>$request->created_byId,
            ]); //! Veri Ekleme Son

            $response = array(
                'status' => 'success',
                'msg' => __('admin.transactionSuccessful'),
                'error' => null, 
            );

            return response()->json($response);
    
        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );
    
            return response()->json($response);
        }

    } //! Kullanıcı İstek Listesi Ekle -  Post Son

    //! Kullanıcı İstek Listesi - Veri Silme Post
    public function UserWishDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'web_user_wish';
            $DB_Find = DB::table($table)->where('id',$request->id)->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Silme
                $DB_Status = DB::table($table)->where('id',$request->id)->delete();

                $response = array(
                    'status' => $DB_Status ? 'success' : 'error',
                    'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
                    'error' => null,
                );

                return response()->json($response);
            }
            else {

                $response = array(
                    'status' => 'error',
                    'msg' => __('admin.dataNotFound'),
                    'error' => null,  
                );  

                return response()->json($response);
            }

        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );

            return response()->json($response);
        }

    } //! Kullanıcı İstek Listesi - Veri Silme Post Son
        
    //! Kullanıcı İstek Listesi - Veri Tümü Sil
    public function UserWishAllDelete($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Sayfa Kontrol
            if($site_lang == "admin") {  return redirect('/'.__('admin.lang').'/'.'admin/');  } //! Admin
            else { 

                //? Cookie Varmı
                if(!isset($_COOKIE["web_userId"])) {
                    echo "Cookie Kayıtlı Değil";
                } 
                else {
                    $user_id=$_COOKIE["web_userId"];
                    //echo "UserId: ".$user_id;

                    //! Veri Silme
                    $DB_Status = DB::table("web_user_wish")->where('user_id',$user_id)->delete();

                    if($DB_Status) {  $status="success"; $message = "Silindi"; }
                    else {  $status="error"; $message = "Silinemedi"; }

                    return redirect('/'.__('admin.lang').'/user/wishlist')->with('status',$status)->with('msg',$message);
                    
                }
               
            } //! Web
        
        } catch (\Throwable $th) {  throw $th; }

    } //!  Kullanıcı İstek Listesi - Veri Tümü Sil Son

        
    //! Kullanıcı İstek Listesi - Veri Tümü Sepette Ekle
    public function UserWishAllCartAdd($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Sayfa Kontrol
            if($site_lang == "admin") {  return redirect('/'.__('admin.lang').'/'.'admin/');  } //! Admin
            else { 

                //? Cookie Varmı
                if(!isset($_COOKIE["web_userId"])) {
                    echo "Cookie Kayıtlı Değil";
                } 
                else {

                    //! Çoklu Veri Ekleme

                    $user_id=$_COOKIE["web_userId"];
                    //echo "UserId: ".$user_id;

                    //! Veriler
                    $DB_All = DB::table("web_user_wish")->where('user_id',$user_id)->get();
                    //echo "<pre>"; print_r($DB_All);
                   
                    //! Eklenecek Veriler
                    $DB_All_Add =[];
                    for ($i=0; $i < count($DB_All) ; $i++) { 
                        
                        $DB_All_Add[] = array(
                            'user_id' => $DB_All[$i]->user_id,
                            'product_uid' => $DB_All[$i]->product_uid,
                            'product_quantity' => $DB_All[$i]->product_quantity,
                            'created_byId' => $user_id,
                        );

                    }
                    //echo "<pre>"; print_r($DB_All_Add);
                    //! Eklenecek Veriler Son
                    
                    //! Veri Ekleme
                    $DbAddStatus = DB::table('web_user_cart')->insert($DB_All_Add);

                    if($DbAddStatus) { 
                    
                        //! Veri Silme
                        $DB_Status = DB::table("web_user_wish")->where('user_id',$user_id)->delete();

                        return redirect('/'.__('admin.lang').'/user/cart')->with('status','success')->with('msg','Veriler Eklendi'); 
                    }
                    else { return redirect('/'.__('admin.lang').'/user/wishlist')->with('status','error')->with('msg','Veriler Eklenemedi'); }

                 
                    //! Çoklu Veri Ekleme Son
                    
                    
                }
               
            } //! Web
        
        } catch (\Throwable $th) {  throw $th; }

    } //! Kullanıcı İstek Listesi - Veri Tümü Sepette Ekle Son

    
    //************* Kullanıcı Sepet ***************** */

    //! Kullanıcı Sepet
    public function UserCart($site_lang="tr")
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>"; die();

        try {

            //! Sayfa Kontrol
            if($site_lang == "admin") {  return redirect('/'.__('admin.lang').'/'.'admin/');  } //! Admin
            else { 

                //! Site Bilgileri
                $DB_HomeSettings= DB::table('homesettings')->where('id','=',2)->first();
                $seo_keywords =  $DB_HomeSettings->seo_keywords;
                //echo "<pre>"; print_r($DB_HomeSettings); die();

                $DB["DB_HomeSettings"] =  $DB_HomeSettings;
                $DB["seo_keywords"] =  $seo_keywords;
                //! Site Bilgileri Son
                
                //! Web UserId
                $web_userId = 0;
                if(isset($_COOKIE["web_userId"])) { $web_userId = (int)$_COOKIE["web_userId"]; }
                //echo "web_userId:"; echo $web_userId; die();
                                           
                //! Kullanıcı Sepet Listesi
                $DB_web_user_cart= DB::table('web_user_cart')
                ->join('products', 'products.uid', '=', 'web_user_cart.product_uid')
                ->join('web_users', 'web_users.id', '=', 'web_user_cart.user_id')
                ->select('web_user_cart.*', 
                          'products.title as productsTitle','products.img_url as productsImg',
                          'products.uid as productsUid','products.seo_url as productsSeo_url',
                          'products.currency as productsCurrency',
                          DB::raw('(CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END) AS productsPrice'),
                          DB::raw('((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) AS productsTotalPrice'),
                          DB::raw('SUM((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) OVER() AS productsAllTotalPrice'),
                          'web_users.name as userName',
                          'web_users.surname as userSurName'
                        )
                ->where('web_user_cart.user_id','=', $web_userId)
                ->where('web_user_cart.isActive','=',1)
                ->orderBy('web_user_cart.id','desc')
                ->get();
                //echo "<pre>"; print_r($DB_web_user_cart); die();

                //! Return
                $DB["DB_web_user_cart"] =  $DB_web_user_cart;
                $DB["productsCount"] =  $DB_web_user_cart->count();
                $DB["productsCurrency"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsCurrency : "TL";
                $DB["productsAllTotalPrice"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsAllTotalPrice : 0;
                //! Kullanıcı Sepet Listesi -  Son
                                
                //! Kullanıcı İstek Listesi - Sayısı
                $DB_web_user_wish_count = DB::table('web_user_wish')->where('web_user_wish.user_id','=', $web_userId)->count(); //! İstek Listesi - Sayısı
                //echo "DB_web_user_wish_count:"; echo $DB_web_user_wish_count; die();

                //! Return
                $DB["DB_web_user_wish_count"] =  $DB_web_user_wish_count;
                //! Kullanıcı İstek Listesi - Sayısı - Son
             

                return view('web/user/cart',$DB);
            } //! Web
        
        } catch (\Throwable $th) {  throw $th; }

    } //! Kullanıcı Sepet Son
    
    //! Kullanıcı Sepet Ekle -  Post
    public function UserCartAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Ekleme
            DB::table('web_user_cart')->insert([
                'user_id' => $request->user_id,
                'product_uid' => $request->product_uid,
                'product_quantity' => $request->product_quantity,
                'created_byId'=>$request->created_byId,
            ]); //! Veri Ekleme Son

            $response = array(
                'status' => 'success',
                'msg' => __('admin.transactionSuccessful'),
                'error' => null, 
            );

            return response()->json($response);
    
        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );
    
            return response()->json($response);
        }

    } //! Kullanıcı Sepet Ekle -  Post Son

    //! Kullanıcı Sepet - Veri Silme Post
    public function UserCartDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'web_user_cart';
            $DB_Find = DB::table($table)->where('id',$request->id)->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Silme
                $DB_Status = DB::table($table)->where('id',$request->id)->delete();

                $response = array(
                    'status' => $DB_Status ? 'success' : 'error',
                    'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
                    'error' => null,
                );

                return response()->json($response);
            }
            else {

                $response = array(
                    'status' => 'error',
                    'msg' => __('admin.dataNotFound'),
                    'error' => null,  
                );  

                return response()->json($response);
            }

        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );

            return response()->json($response);
        }

    } //! Kullanıcı Sepet - Veri Silme Post Son
    
    //! Kullanıcı Sepet - Veri Tümü Sil
    public function UserCartDeleteAll($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Sayfa Kontrol
            if($site_lang == "admin") {  return redirect('/'.__('admin.lang').'/'.'admin/');  } //! Admin
            else { 

                //? Cookie Varmı
                if(!isset($_COOKIE["web_userId"])) {
                    echo "Cookie Kayıtlı Değil";
                } 
                else {
                    $user_id=$_COOKIE["web_userId"];
                    echo "UserId: ".$user_id;

                    //! Veri Silme
                    $DB_Status = DB::table("web_user_cart")->where('user_id',$user_id)->delete();

                    if($DB_Status) {  $status="success"; $message = "Silindi"; }
                    else {  $status="error"; $message = "Silinemedi"; }

                    return redirect('/'.__('admin.lang').'/user/cart')->with('status',$status)->with('msg',$message);
                    
                }
               
            } //! Web
        
        } catch (\Throwable $th) {  throw $th; }

    } //! Kullanıcı Sepet - Veri Tümü Sil Son

    //! Kullanıcı Sepet - Veri Güncelleme Post
    public function UserCartEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Güncelleme
            $table = 'web_user_cart';
           
            $cartList = $request->cart_list;
            $cartListJson = json_decode($cartList, true);
            $cartListCount = count($cartListJson);
            
            //echo "<pre>"; print_r($cartListJson);
            //echo "sayisi:"; echo count($cartListJson);
            //echo "id:"; echo $cartListJson[0]["id"];
            
            for ($i=0; $i < $cartListCount ; $i++) { 
               
                $DB = DB::table($table)->where('id','=',$cartListJson[$i]["id"]);
                $DB_Find = $DB->first(); //Tüm verileri çekiyor
                if($DB_Find) {
    
                    //! Veri Güncelle
                    $DB_Status = $DB->update([       
                       'product_quantity' => $cartListJson[$i]["product_quantity"],
                       'isUpdated'=>true,
                       'updated_at'=>Carbon::now(),
                       'updated_byId'=>$request->updated_byId,
                   ]);
                   
                }
                
            }

            if($cartListCount > 0 ){

                $response = array(
                    'status' => 'success',
                    'msg' => __('admin.transactionSuccessful'),
                    'error' => null, 
                );
    
                return response()->json($response);

            }
            else {

                $response = array(
                    'status' => 'error',
                    'msg' => __('admin.transactionFailed'),
                    'error' => $th,            
                );
    
                return response()->json($response);

            }
             
        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );

            return response()->json($response);
        }

    } //! Kullanıcı Sepet - Veri Güncelleme Post Son

    //************* Kullanıcı Sipariş ***************** */

    //! Kullanıcı Sepet Ekle -  Post
    public function UserOrderAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veriler
            $cartList = $request->cart_list;
            $cartListJson = json_decode($cartList, true);
            $cartListCount = count($cartListJson);
            
            //echo "<pre>"; print_r($cartListJson);
            //echo "sayisi:"; echo count($cartListJson);
            //echo "id:"; echo $cartListJson[0]["id"];

            for ($i=0; $i < $cartListCount ; $i++) { 

                //! Veri Ekleme
                DB::table('web_user_order')->insert([
                    'uid' => $request->uid,
                    'title' => $request->title,
                    'user_id' => $request->user_id,
                    'product_uid' => $cartListJson[$i]["product_uid"],
                    'product_quantity' => $cartListJson[$i]["product_quantity"],
                    'created_byId'=>$request->created_byId,
                ]); //! Veri Ekleme Son
                
            }

            if($cartListCount > 0 ){

                //! Sepet Verileri Silme
                DB::table('web_user_cart')->where('user_id',$request->user_id )->delete();

                //! Return
                $response = array(
                    'status' => 'success',
                    'msg' => __('admin.transactionSuccessful'),
                    'error' => null, 
                );
    
                return response()->json($response);

            }
            else {

                $response = array(
                    'status' => 'error',
                    'msg' => __('admin.transactionFailed'),
                    'error' => $th,            
                );
    
                return response()->json($response);

            }
    
        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );
    
            return response()->json($response);
        }

    } //! Kullanıcı Sepet Ekle -  Post Son

    
    //************* Kullanıcı xx ***************** */

    //! UserCheckout
    public function UserCheckout($site_lang="tr")
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>"; die();

        try {

            //! Sayfa Kontrol
            if($site_lang == "admin") {  return redirect('/'.__('admin.lang').'/'.'admin/');  } //! Admin
            else { 

               //! Site Bilgileri
               $DB_HomeSettings= DB::table('homesettings')->where('id','=',2)->first();
               $seo_keywords =  $DB_HomeSettings->seo_keywords;
               //echo "<pre>"; print_r($DB_HomeSettings); die();

               $DB["DB_HomeSettings"] =  $DB_HomeSettings;
               $DB["seo_keywords"] =  $seo_keywords;
               //! Site Bilgileri Son

                               
                //! Web UserId
                $web_userId = 0;
                if(isset($_COOKIE["web_userId"])) { $web_userId = (int)$_COOKIE["web_userId"]; }
                //echo "web_userId:"; echo $web_userId; die();
                                           
                //! Kullanıcı Sepet Listesi
                $DB_web_user_cart= DB::table('web_user_cart')
                ->join('products', 'products.uid', '=', 'web_user_cart.product_uid')
                ->join('web_users', 'web_users.id', '=', 'web_user_cart.user_id')
                ->select('web_user_cart.*', 
                          'products.title as productsTitle','products.img_url as productsImg',
                          'products.uid as productsUid','products.seo_url as productsSeo_url',
                          'products.currency as productsCurrency',
                          DB::raw('(CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END) AS productsPrice'),
                          DB::raw('((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) AS productsTotalPrice'),
                          DB::raw('SUM((CASE WHEN products.discounted_price_percent = 0 THEN products.sale_price ELSE products.discounted_price END)*web_user_cart.product_quantity) OVER() AS productsAllTotalPrice'),
                          'web_users.name as userName',
                          'web_users.surname as userSurName'
                        )
                ->where('web_user_cart.user_id','=', $web_userId)
                ->where('web_user_cart.isActive','=',1)
                ->orderBy('web_user_cart.id','desc')
                ->get();
                //echo "<pre>"; print_r($DB_web_user_cart); die();

                //! Return
                $DB["DB_web_user_cart"] =  $DB_web_user_cart;
                $DB["productsCount"] =  $DB_web_user_cart->count();
                $DB["productsCurrency"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsCurrency : "TL";
                $DB["productsAllTotalPrice"] =  $DB_web_user_cart->count() > 0 ? $DB_web_user_cart[0]->productsAllTotalPrice : 0;
                //! Kullanıcı Sepet Listesi -  Son
                                
                //! Kullanıcı İstek Listesi - Sayısı
                $DB_web_user_wish_count = DB::table('web_user_wish')->where('web_user_wish.user_id','=', $web_userId)->count(); //! İstek Listesi - Sayısı
                //echo "DB_web_user_wish_count:"; echo $DB_web_user_wish_count; die();

                //! Return
                $DB["DB_web_user_wish_count"] =  $DB_web_user_wish_count;
                //! Kullanıcı İstek Listesi - Sayısı - Son

                return view('web/user/checkout',$DB);
            } //! Web
        
        } catch (\Throwable $th) {  throw $th; }

    } //! UserCheckout Son
    
   
}
