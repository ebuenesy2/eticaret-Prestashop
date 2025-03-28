<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB; //Veri Tabanı İşlemleri


use Illuminate\Support\Facades\Http;
use SimpleXMLElement;

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
            
            //echo "Dil:"; echo $site_lang;  echo "<br/>";
            echo "test";
            
            
        } catch (\Throwable $th) {  throw $th; }

    } //! Test Son
     
    //! Test View
    public function TestView($site_lang="tr",Request $request)
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>"; die();

        try {  

           
            $url_main = "https://marwella1.eldenpazar.com/api/"; //! Site Url
            $url_main_format = "?output_format=JSON"; //! İstenilen Format

            $url = $url_main."categories".$url_main_format;
            $username = "VIMPBUIW3AW519AMKSIY6SRRZUG7YG4E";  // Prestashop API Key

            $response = Http::withBasicAuth($username, '')->accept('application/xml')->get($url);

            //! Json
            if ($response->successful()) {

                $return_categories = json_decode($response->body());
                //echo "<pre>"; print_r($return_categories); die();
                
                $categories = [];
                foreach ($return_categories->categories as $category) {
                    $categories[] = $category->id;
                }

                //echo "<pre>"; print_r($categories); die();

                $perPage = 10; // Her sayfada 10 kategori
                $currentPage = (int) $request->query('page', 1);
                $offset = ($currentPage - 1) * $perPage;
                $pagedCategories = array_slice($categories, $offset, $perPage);
                //echo "<pre>"; print_r($pagedCategories); die();


                   // Kategori adlarını al
                $categoryData = [];
                foreach ($pagedCategories as $categoryId) {
                    $detailUrl = "https://marwella1.eldenpazar.com/api/categories/{$categoryId}";
                    $detailResponse = Http::withBasicAuth($username, '')->accept('application/xml')->get($detailUrl);

                    if ($detailResponse->successful()) {
                        $detailXml = simplexml_load_string($detailResponse->body());
                        $categoryName = (string) $detailXml->category->name->language;

                        $categoryData[] = ['id' => $categoryId, 'name' => $categoryName];
                    }
                }

                //echo "<pre>"; print_r($categoryData); die();
      
                
                // Toplam sayfa sayısını hesapla
                $totalCategories = count($categories);
                $totalPages = ceil($totalCategories / $perPage);

                return view('web/test', compact('categoryData', 'currentPage', 'totalPages'));
            } else {
                return response()->json(['error' => 'Kategoriler alınamadı!'], $response->status());
            }
            //! Json Son
            

            // //! Xml
            // if ($response->successful()) {
            //     // XML verisini ayrıştır
            //     $xml = simplexml_load_string($response->body());

            //     // Kategori ID’lerini al
            //     $categories = [];
            //     foreach ($xml->categories->category as $category) {
            //         $categories[] = (string) $category['id'];
            //     }

            //     // Sayfalama için parametreler
            //     $perPage = 10; // Her sayfada 10 kategori
            //     $currentPage = (int) $request->query('page', 1);
            //     $offset = ($currentPage - 1) * $perPage;
            //     $pagedCategories = array_slice($categories, $offset, $perPage);

            //     // Kategori adlarını al
            //     $categoryData = [];
            //     foreach ($pagedCategories as $categoryId) {
            //         $detailUrl = "https://marwella1.eldenpazar.com/api/categories/{$categoryId}";
            //         $detailResponse = Http::withBasicAuth($username, '')->accept('application/xml')->get($detailUrl);

            //         if ($detailResponse->successful()) {
            //             $detailXml = simplexml_load_string($detailResponse->body());
            //             $categoryName = (string) $detailXml->category->name->language;

            //             $categoryData[] = ['id' => $categoryId, 'name' => $categoryName];
            //         }
            //     }

            //     // Toplam sayfa sayısını hesapla
            //     $totalCategories = count($categories);
            //     $totalPages = ceil($totalCategories / $perPage);

            //     return view('web/test', compact('categoryData', 'currentPage', 'totalPages'));
            // } else {
            //     return response()->json(['error' => 'Kategoriler alınamadı!'], $response->status());
            // }
            //  //! Xml Son
            
        } 
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
            else {  return redirect('/'.__('admin.lang').'/'.'product/list/'); } //! Web
        
        } catch (\Throwable $th) {  throw $th; }

    } //! Index Son
    
    //************* Web - Ürün ***************** */

    //! Ürün Kategorisi
    public function ProductCategoryList($site_lang="tr",Request $request)
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

                //! Curl - Kategori
                $url = "https://marwella1.eldenpazar.com/api/categories";
                $username = "VIMPBUIW3AW519AMKSIY6SRRZUG7YG4E";  // Prestashop API Key

                $response = Http::withBasicAuth($username, '')->accept('application/xml')->get($url);

                if ($response->successful()) {
                    // XML verisini ayrıştır
                    $xml = simplexml_load_string($response->body());

                    // Kategori ID’lerini al
                    $categories = [];
                    foreach ($xml->categories->category as $category) {
                        $categories[] = (string) $category['id'];
                    }

                    // Sayfalama için parametreler
                    $perPage = 24; // Her sayfada 10 kategori
                    $currentPage = (int) $request->query('pageCategory', 1); // Mevcut sayfa (default: 1)
                    $offset = ($currentPage - 1) * $perPage; // Sayfa kaydırması
                    $pagedCategories = array_slice($categories, $offset, $perPage); // Sayfalanmış kategoriler

                    // Kategori adı ve resim URL'lerini al
                    $categoryData = [];
                    foreach ($pagedCategories as $categoryId) {
                        $detailUrl = "https://marwella1.eldenpazar.com/api/categories/{$categoryId}";
                        $detailResponse = Http::withBasicAuth($username, '')->accept('application/xml')->get($detailUrl);

                        if ($detailResponse->successful()) {
                            $detailXml = simplexml_load_string($detailResponse->body());
                            $categoryName = (string) $detailXml->category->name->language;

                            // Kategori resim URL'sini oluştur
                            $imageUrl = "https://marwella1.eldenpazar.com/api/images/categories/{$categoryId}?ws_key={$username}";

                            $categoryData[] = [
                                'id' => $categoryId,
                                'name' => $categoryName,
                                'image' => $imageUrl
                            ];
                        }
                    }

                    // Toplam sayfa sayısını hesapla
                    $totalCategories = count($categories);
                    $totalPages = ceil($totalCategories / $perPage); // Toplam sayfa sayısı

                    //! Return
                    $DB["categoryData"] =  $categoryData; //! Kategoriler
                    $DB["currentPageCategory"] =  $currentPage; //! Şimdi Sayfa
                    $DB["totalPagesCategory"] =  $totalPages; //! Tüm Sayfalar

                    //echo "<pre>"; print_r($categoryData); die();

                } else {
                    return response()->json(['error' => 'Kategoriler alınamadı!'], $response->status());
                }
                
                return view('web/product/category',$DB);

            } //! Web
        
        } catch (\Throwable $th) {  throw $th; }

    } //! Ürün Kategorisi Son

    //! Ürün Listesi - Tüm Ürünler
    public function ProductListAll($site_lang="tr",Request $request)
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
                $DB["DB_Products_Title"] =  __('admin.allProduct'); //! Sayfa Adı
                //! Site Bilgileri Son
                
                //! Web UserId
                $web_userId = 0;
                if(isset($_COOKIE["web_userId"])) { $web_userId = (int)$_COOKIE["web_userId"]; }
                //echo "web_userId:"; echo $web_userId; die();

                               
                //! Curl - Kategori
                $url_main = "https://marwella1.eldenpazar.com/api/"; //! Site Url
                $url_main_format = "?output_format=JSON"; //! İstenilen Format
    
                $url = $url_main."categories".$url_main_format;
                $username = "VIMPBUIW3AW519AMKSIY6SRRZUG7YG4E";  // Prestashop API Key
    
                $response = Http::withBasicAuth($username, '')->accept('application/xml')->get($url);
    
                if ($response->successful()) {
                   
                    $return_categories = json_decode($response->body());
                    //echo "<pre>"; print_r($return_categories); die();
                    
                    $categories = [];
                    foreach ($return_categories->categories as $category) {
                        $categories[] = $category->id;
                    }
                
    
                    // Sayfalama için parametreler
                    $perPage = 24; // Her sayfada 10 kategori
                    $currentPage = (int) $request->query('pageCategory', 1);
                    $offset = ($currentPage - 1) * $perPage;
                    $pagedCategories = array_slice($categories, $offset, $perPage);
    
                    // Kategori adlarını al
                    $categoryData = [];
                    foreach ($pagedCategories as $categoryId) {
                        $detailUrl = "https://marwella1.eldenpazar.com/api/categories/{$categoryId}";
                        $detailResponse = Http::withBasicAuth($username, '')->accept('application/xml')->get($detailUrl);
    
                        if ($detailResponse->successful()) {
                            $detailXml = simplexml_load_string($detailResponse->body());
                            $categoryName = (string) $detailXml->category->name->language;
    
                            $categoryData[] = ['id' => $categoryId, 'name' => $categoryName];
                        }
                    }
    
                    // Toplam sayfa sayısını hesapla
                    $totalCategories = count($categories);
                    $totalPages = ceil($totalCategories / $perPage);
                    //echo "<pre>"; print_r($totalPages); die();

                    //! Return
                    $DB["categoryData"] =  $categoryData; //! Kategoriler
                    $DB["currentPageCategory"] =  $currentPage; //! Şimdi Sayfa
                    $DB["totalPagesCategory"] =  $totalPages; //! Tüm Sayfalar Sayısı
                    
                } else {
                    return response()->json(['error' => 'Kategoriler alınamadı!'], $response->status());
                }

                // Seçilen Kategori ID
                $categoryId = $request->query('category', 1);  // URL parametresi olarak gelen kategori id

                if ($categoryId) {
                    // Kategoriye ait ürünleri çek
                    $url = "https://marwella1.eldenpazar.com/api/products?category={$categoryId}";
                } else {
                    // Kategori seçilmemişse tüm ürünleri çek
                    $url = "https://marwella1.eldenpazar.com/api/products";
                }

                $username = "VIMPBUIW3AW519AMKSIY6SRRZUG7YG4E";  // Prestashop API Key

                //! Verileri döndürüyor
                $response = Http::withBasicAuth($username, '')->accept('application/xml')->get($url);
        
                if ($response->successful()) {
                    // XML verisini ayrıştır
                    $xml = simplexml_load_string($response->body());
        
                    // Tüm ürün ID'lerini al
                    $products = [];
                    foreach ($xml->products->product as $product) {
                        $products[] = (string) $product['id'];
                    }
        
                    // Sayfalama için parametreler
                    $perPage = 20; // Her sayfada 10 ürün
                    $currentPage = (int) $request->query('page', 1);
                    $offset = ($currentPage - 1) * $perPage;
                    $pagedProducts = array_slice($products, $offset, $perPage);
        
                    // Ürün adlarını ve resimlerini çek
                    $productData = [];
                    foreach ($pagedProducts as $productId) {
                        $detailUrl = "https://marwella1.eldenpazar.com/api/products/{$productId}";
                        $detailResponse = Http::withBasicAuth($username, '')->accept('application/xml')->get($detailUrl);
        
                        if ($detailResponse->successful()) {
                            $detailXml = simplexml_load_string($detailResponse->body());
                            $productName = (string) $detailXml->product->name->language;
                            $imageId = (string) $detailXml->product->id_default_image;
                            $price = (string) $detailXml->product->price; // Fiyat bilgisini al
                            $formattedPrice = number_format((float)$price, 2, '.', ''); // Fiyat bilgisini Anlamlı Sayı

                            // Kategori bilgisini almak için kategori detayını sorgula
                            $categoryUrl = "https://marwella1.eldenpazar.com/api/categories/{$categoryId}";
                            $categoryResponse = Http::withBasicAuth($username, '')->accept('application/xml')->get($categoryUrl);


                            // Kategori detaylarını aldıysak
                            $categoryName = "";
                            if ($categoryResponse->successful()) {
                                $categoryXml = simplexml_load_string($categoryResponse->body());
                                $categoryName = (string) $categoryXml->category->name->language;  // Kategori adını al
                            }
                        
                            // Resim kontrolü: Eğer resim yoksa, ürünü ekleme
                            if ($imageId) {
                                $imageUrl = "https://marwella1.eldenpazar.com/api/images/products/{$productId}/{$imageId}";
                                $productData[] = [
                                    'id' => $productId,
                                    'name' => $productName,
                                    'image' => $imageUrl,
                                    'category' => $categoryName,
                                    'price' => $formattedPrice 
                                ];
                            }
        
                        
                        }
                    }
        
                    // Sayfa sayısını hesapla
                    $totalProducts = count($products);
                    $totalPages = ceil($totalProducts / $perPage);

                    //echo "<pre>"; print_r($productData); die();

                    //! Return
                    $DB["productData"] =  $productData; //! Ürün Listesi
                    $DB["totalProducts"] =  count($products); //! Toplam Ürün Sayısı
                    $DB["currentPageProduct"] =  $currentPage; //! Şimdi Sayfa
                    $DB["totalPagesProduct"] =  $totalPages; //! Tüm Sayfalar
                    $DB["categoryId"] =  $categoryId; //! Seçilen Kategori
                    
                } else {
                    return response()->json(['error' => 'Ürünler alınamadı!'], $response->status());
                }
                

                return view('web/product/productList',$DB);
            } //! Web
        
        } catch (\Throwable $th) {  throw $th; }

    } //! Ürün Listesi - Tüm Ürünler Son
    
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
                                           

                //! Return
                $DB["productsCount"] =  10;
                $DB["productsCurrency"] =  "TL";
                $DB["productsAllTotalPrice"] =  0;
                //! Kullanıcı Sepet Listesi -  Son
             

                return view('web/user/cart',$DB);
            } //! Web
        
        } catch (\Throwable $th) {  throw $th; }

    } //! Kullanıcı Sepet Son
    
    //! Kullanıcı Sepet - Local
    public function UserCartLocal(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veriler
            $cartItems = $request->input('cart'); // verisini al
            $productData = []; //! Urun Listesi
            
            //! Urun Listesi
            for ($i=0; $i <count($cartItems); $i++) { 

                $productId = (int)$cartItems[$i];

                // Prestashop API URL ve API anahtarını tanımla
                $url = "https://marwella1.eldenpazar.com/api/products/{$productId}";
                $username = "VIMPBUIW3AW519AMKSIY6SRRZUG7YG4E";  // Prestashop API Key

                // API isteği gönder, XML formatında cevap bekliyoruz
                $response = Http::withBasicAuth($username, '')->accept('application/xml')->get($url);

                if ($response->successful()) {
                    // XML verisini ayrıştır
                    $xml = simplexml_load_string($response->body());
                    $productName = (string) $xml->product->name->language;
                    $imageId = (string) $xml->product->id_default_image;
                    $price = (string) $xml->product->price;
                    $formattedPrice = number_format((float)$price, 2, '.', '');

                    // Resim URL'si
                    $imageUrl = $imageId ? "https://marwella1.eldenpazar.com/api/images/products/{$productId}/{$imageId}" : null;

                    // Ürün detaylarını döndür
                    $productData[] = [
                        'id' => $productId,
                        'name' => $productName,
                        'price' => $formattedPrice,
                        'image' => $imageUrl,
                        'quantity' => 1,
                    ];

                
                } else {
                    return response()->json(['error' => 'Ürün bilgisi alınamadı!'], $response->status());
                } 
            }  

            // Başarılı yanıt dön
            return response()->json(['message' => 'Sepet başarıyla gönderdi', 'data' => $productData]); 
             
        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );

            return response()->json($response);
        }

    } //! Kullanıcı Sepet - Local Son

       
   
}
