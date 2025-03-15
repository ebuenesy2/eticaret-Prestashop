<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB; //Veri Tabanı İşlemleri
use CURLFile; //! Curl 

//! Zaman
use Carbon\Carbon;
Carbon::now('Europe/Istanbul');
Carbon::setLocale('tr');
date_default_timezone_set('Etc/GMT-3');
//! Zaman Son

//! Sabit Fonksiyonlar
include(app_path() . '/Functions/cookie.php'); //! Cookie
include(app_path() . '/Functions/functions.php'); //! Fonksiyonlar
include(app_path() . '/Functions/levels.php'); //! Levels
include(app_path() . '/Functions/list.php'); //! List


class Admin extends Controller
{

   //************* Test ***************** */

   //! Test
   public function Test($site_lang="tr")
   {
       \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
       
       try {

        echo "test"; die();
            
   
       } catch (\Throwable $th) {  throw $th; }

   } //! Test Son

   //! Test 1
   public function TestFirst($site_lang="tr")
   {
       \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
       
       try {
       

         echo "test first"; die();
            
   
       } catch (\Throwable $th) {  throw $th; }

   } //! Test 1 Son

   //! Test View
   public function TestView($site_lang="tr")
   {
       \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
       //echo "Dil:"; echo $site_lang;  echo "<br/>"; die();

       try {  
       
            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Return
                $DB["CookieData"] = $CookieControl["CookieDataList"];

               //! Yetki Listesi
               $dbFindData = [];
               $dbFindData["service"] = "test"; //! Aranacak Service
               $permissionsUserFindFunction = permissionsUserFind($dbFindData); //! Fonksiyon - Tüm Veriler
               $DB["permissions"] = $permissionsUserFindFunction["dbFind_permissions"]; //! Yetki Listesi
               
               $permissions = $permissionsUserFindFunction["dbFind_permissions"]; //! Yetki Listesi
               //echo "<pre>"; print_r($permissions); die();
                
                //echo "<pre>"; print_r($DB); die();
                
                return view('admin/test',$DB); 
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
       } 
       catch (\Throwable $th) {  throw $th; }

   } //! Test View Son

   //************* Admin ***************** */

   //! Anasayfa
   public function Index($site_lang="tr")
   {
      \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
      //echo "Dil:"; echo $site_lang;  echo "<br/>"; die();

      //echo "index"; die();

      try {

        //! Tanım
        $yildirimdev_userCheck = 0; //! Kullanıcı Onay
        $CookieData = []; //! Çerez List
      
        //! Cookie Fonksiyon Kullanımı
        $CookieControl =  cookieControl(); //! Çerez Kontrol
        //echo "Cookie - Tüm Veriler"; echo "<br>";
        //echo "<pre>"; print_r($CookieControl); die();

        if($CookieControl['isCookie']) { $yildirimdev_userCheck = 1; $CookieData=$CookieControl["CookieDataList"]; } //! Çerez Var
        else { $yildirimdev_userCheck = 0; $CookieData = []; } //! Çerez Yok

        //! Cookie Fonksiyon Kullanımı Son

        //? Session Varmı
        if(session('status')=="succes") {   //echo "session var"; die();

            $yildirimdev_userCheck = 1; //! Kullanıcı Giriş Durumu
            $CookieData["yildirimdev_userCheck"] = 1; //! Kullanıcı Giriş Durumu
            $CookieData["yildirimdev_userID"] = session('yildirimdev_userID'); //! id
            $CookieData["yildirimdev_email"] = session('yildirimdev_email'); //! email

            $CookieData["yildirimdev_name"] = session('yildirimdev_name'); //! name
            $CookieData["yildirimdev_surname"] = session('yildirimdev_surname'); //! surname
            $CookieData["yildirimdev_img_url"] = session('yildirimdev_img_url'); //! imgUrl

            $CookieData["yildirimdev_departmanID"] = session('yildirimdev_departmanID'); //! departman
            $CookieData["yildirimdev_roleID"] = session('yildirimdev_roleID'); //! role

            $CookieEdit =  cookieEdit($CookieData); //! Cookie Güncelleme
            //echo "<pre>"; print_r($CookieEdit); die();

        } //? Session Varmı Son

        if($yildirimdev_userCheck == 1 ) {
            //echo "üye girişi oldu"; die();

            //! Return
            $DB["CookieData"] =  $CookieData;
            //echo "<pre>"; print_r($DB); die();

            return view('admin/index',$DB);

        }
        else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
    
      } catch (\Throwable $th) {  throw $th; }

   } //! Anasayfa Son

   //************* Admin İşlemleri ***************** */

    //! Giriş
    public function Login($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Verileri Sil
            $CookieClear =  cookieClear(); //! Cookie Fonksiyon Kullanımı
            //echo "<pre>"; print_r($CookieClear); die();
            
            //! Return
            $DB["DB_Find"] =  [];

            return view('admin/admin/adminLogin',$DB);
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Giriş Son

    //! Giriş Kontrol
    public function LoginControl(Request $request)
    {
        try {

            //Veri Okuma
            // [ Name] - değerlerine göre oku
            $token= $request->_token;
            $siteLang= $request->siteLang; //! Çoklu Dil
            \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil

            //! Gelen Bilgiler
            $email= $request->email;
            $password= $request->password;
            
            //! Tanım
            $loginCheck=0; //! Login Durumu
            $activeCheck=0; //! Aktif Durumu

            if(config('admin.Admin_Email') == $email && config('admin.Admin_Password') == $password  ) {
                
                $loginCheck =  1;
                $activeCheck = 1;
                
                $yildirimdev_userID = config('admin.Admin_ID');
                $yildirimdev_email = config('admin.Admin_Email');
                $yildirimdev_name = config('admin.Admin_UserName');
                $yildirimdev_surname = config('admin.Admin_UserSurName');
                $yildirimdev_img_url = config('admin.Admin_UserImgUrl');
                $yildirimdev_departmanID = 0;
                $yildirimdev_roleID = 0;

            }
            else {
            

                //veri tabanı işlemleri
                $DB_Where= DB::table('users')->where('email','=',$email)->where('password','=',$password)->first();
                //echo "<pre>"; print_r($DB_Where); die();

                if($DB_Where) {  
                    //echo "Kullancı Giriş Var"; die();

                    $loginCheck = 1;
                    $activeCheck = $DB_Where->isActive;
                    
                    $yildirimdev_userID = $DB_Where->id;
                    $yildirimdev_email = $DB_Where->email;
                    $yildirimdev_name = $DB_Where->name;
                    $yildirimdev_surname = $DB_Where->surname;
                    $yildirimdev_img_url = $DB_Where->img_url;
                    $yildirimdev_departmanID = $DB_Where->departman_id;
                    $yildirimdev_roleID = $DB_Where->role_id;
                }

            }
            
            //! Login Durumuna Yönlendirme
            if($loginCheck == 1) { 
                //echo "Login Oldu"; die();

                if($activeCheck == 0) { return redirect('/'.__('admin.lang').'/error/account/block'); }
                else { return redirect('/'.__('admin.lang').'/admin')->with('status',"succes")
                    ->with('yildirimdev_userID',$yildirimdev_userID)->with('yildirimdev_email',$yildirimdev_email)
                    ->with('yildirimdev_name',$yildirimdev_name)->with('yildirimdev_surname',$yildirimdev_surname)->with('yildirimdev_img_url',$yildirimdev_img_url) 
                    ->with('yildirimdev_departmanID',$yildirimdev_departmanID)->with('yildirimdev_roleID',$yildirimdev_roleID);
                }
            }
            else {  return redirect('/'.__('admin.lang').'/admin/login')->with('status',"error")->with('msg', __('admin.theEmailPasswordMayBeIncorrect')); }
            //! Login Durumuna Yönlendirme Son

        } catch (\Throwable $th) { throw $th; }

    } //! Giriş Kontrol Son

    //! Kayıt
    public function Register($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {  

            //! Cookie Verileri Sil
            $CookieClear =  cookieClear(); //! Cookie Fonksiyon Kullanımı
            //echo "<pre>"; print_r($CookieClear); die();
            
            //! Return
            $DB["DB_Find"] =  [];

            return view('admin/admin/adminRegister',$DB);
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Kayıt Son

    //! Kayıt Kontrol
    public function RegisterControl(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            if($request->rePassword != $request->password) { return redirect('/'.__('admin.lang').'/admin/register')->with('status',"error")->with('msg', __('admin.passwordsDoNotMatch')); }
            else {

                //! Veri Arama
                $DB_Find = DB::table('users')->where('email',$request->email)->first(); //Tüm verileri çekiyor

                if($DB_Find) { return redirect('/'.__('admin.lang').'/admin/register')->with('status',"error")->with('msg', __('admin.emailIsUsed')); }
                else if($request->email == config('admin.Admin_Email')) { return redirect('/'.__('admin.lang').'/admin/register')->with('status',"error")->with('msg', __('admin.emailIsProhibited')); }
                else {
                    
                    //! Veri Ekleme
                    DB::table('users')->insert([
                        'name' => $request->name,
                        'surname' => $request->surname,
                        'email' => $request->email,
                        'password' => $request->password,
                        'img_url'=> config('admin.Default_UserImgUrl'),
                        'created_byId'=>null,
                    ]); //! Veri Ekleme Son

                    return redirect('/'.__('admin.lang').'/admin/register')->with('status',"succes")->with('msg', __('admin.transactionSuccessful'));

                }
            }

        } catch (\Throwable $th) { throw $th; }

    } //! Kayıt Kontrol Son

    //! Şifremi Unuttum
    public function ForgotPassword($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 
           
            //! Return
            $DB["DB_Find"] =  [];

            return view('admin/admin/adminForgotPassword',$DB);
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Şifremi Unuttum Son

    //! Şifremi Unuttum Control
    public function ForgotPasswordControl(Request $request)
    {

        try {

            //Veri Okuma
            // [ Name] - değerlerine göre oku
            $token= $request->_token;
            $siteLang= $request->siteLang; //! Çoklu Dil
            \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil

            //! Gelen Veri
            $email= $request->email; 
            
            echo "Şifremi Unuttum"; echo "<br/>";
            echo "email: "; echo $email; echo "<br/>";

            //! Veri Arama
            $DB_Find = DB::table('users')->where('email',$request->email)->first(); //Verileri çekiyor    
           
            if($DB_Find) {
                echo "Kullanıcı Var"; echo "<br/>";
                echo "<pre>"; print_r($DB_Find); die(); 
            }
            else{  echo "Kullanıcı Yok"; die(); }

        } catch (\Throwable $th) { throw $th; }

    } //! Şifremi Unuttum Control Son

    //! Şifremi Yenile
    public function ResetPassword($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Return
            $DB["DB_Find"] =  [];

            return view('admin/admin/adminResetPassword',$DB);
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Şifremi Yenile Son

    //! Şifremi Yenile Control
    public function ResetPasswordControl(Request $request)
    {

        try {

            //Veri Okuma
            // [ Name] - değerlerine göre oku
            $token= $request->_token;
            $siteLang= $request->siteLang; //! Çoklu Dil
            \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil

            $email= $request->email;
            $password= $request->password;           

            $newPassword= $request->newPassword;
            $reNewPassword= $request->reNewPassword;

            // echo "Şifremi Yenile"; echo "<br/>";
            // echo "email: "; echo $email; echo "<br/>";
            // echo "password: "; echo $password; echo "<br/>";

            // echo "newPassword: "; echo $newPassword; echo "<br/>";
            // echo "reNewPassword: "; echo $reNewPassword; echo "<br/>";

            //echo "<br/>";

            if($newPassword == $reNewPassword) { 

                //! Veri Arama
                $DB = DB::table('users')->where('email','=',$email)->where('password','=',$password); //Veri Tabanı
                $DB_Find = $DB->first(); //Tüm verileri çekiyor                
                //echo "<pre>"; print_r($DB_Find); die();

                if($DB_Find) {  

                    //! Veri Güncelle
                    $DB_Status = $DB->update([            
                        'password'=>$request->newPassword,                       

                        'isUpdated'=>true,
                        'updated_at'=>Carbon::now(),
                        'updated_byId'=>null,
                    ]);

                    //! Veri Güncelleme Başarılı
                    if($DB_Status) { return redirect('/'.__('admin.lang').'/admin/reset/password')->with('status',"succes")->with('msg', __('admin.transactionSuccessful'));  }
                    else {  return redirect('/'.__('admin.lang').'/admin/reset/password')->with('status',"error")->with('msg', __('admin.transactionFailed'));  }
                }
                else { return redirect('/'.__('admin.lang').'/admin/reset/password')->with('status',"error")->with('msg', __('admin.userNotFound')); }
            }
            else { return redirect('/'.__('admin.lang').'/admin/reset/password')->with('status',"error")->with('msg', __('admin.passwordsDoNotMatch')); }

        } catch (\Throwable $th) { throw $th; }

    } //! Şifremi Yenile Control Son    

    //************* Admin Listesi ***************** */

    //! Admin List
    public function AdminList($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 
            
            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();
               
                //! Tanım
                $table = "users";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData
                
                $selectData = [];  //! Select
                $selectData[] = array( "table" => $table, "parametre" => "*", "name" => null, );
                $selectData[] = array( "table" => "roles", "parametre" => "title", "name" => "roleTitle", );
                $selectData[] = array( "table" => "departmanlist", "parametre" => "title", "name" => "departmanTitle", );

                $selectDataRaw = [];  //! Select - Raw

                $joinData = [];  //! Join
                $joinData[] = array( "type" => "LEFT", "table" => "roles" , "value" => "id", "refTable" => $table, "refValue" => "role_id", ); //! Join Veri Ekleme
                $joinData[] = array( "type" => "LEFT", "table" => "departmanlist" , "value" => "id", "refTable" => $table, "refValue" => "departman_id", ); //! Join Veri Ekleme
                
                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "Status", "table" => $table, "where" => "isActive", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "userId", "table" => $table, "where" => "id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "name", "table" => $table, "where" => "name", "data_item_object" => "likeBoth", "data_key_type" => "string", ); //! Başında ve Sonunda Ara
                $searchData[] = array("params" => "surname", "table" => $table, "where" => "surname", "data_item_object" => "likeBoth", "data_key_type" => "string", ); //! Başında ve Sonunda Ara
                $searchData[] = array("params" => "email", "table" => $table, "where" => "email", "data_item_object" => "likeStart", "data_key_type" => "string", ); //! Eşit
                $searchData[] = array("params" => "role", "table" => $table, "where" => "role_id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "departman", "table" => $table, "where" => "departman_id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "CreatedDate", "table" => $table, "where" => "created_at", "data_item_object" => "likeStart", "data_key_type" => "string", ); //! Başında Varsa
                $searchData[] = array("params" => "CreatedDateBottom", "table" => $table, "where" => "created_at", "data_item_object" => ">=", "data_key_type" => "date", ); //! Zaman Büyük ve Eşit
                $searchData[] = array("params" => "CreatedDateTop", "table" => $table, "where" => "created_at", "data_item_object" => "<=", "data_key_type" => "date", ); //! Zaman Küçük ve Eşit
               
                $whereData = []; //! Where
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                $DB_Find_roles = DB::table('roles')->get(); //! Role Listesi
                //echo "<pre>"; print_r($DB_Find_roles); die();

                $DB_Find_departman = DB::table('departmanlist')->get(); //! Departman Listesi
                //echo "<pre>"; print_r($DB_Find_departman); die();
                    
                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];
                $DB["DB_Find_roles"] =  $DB_Find_roles;
                $DB["DB_Find_departman"] =  $DB_Find_departman;

                //echo "<pre>"; print_r($DB); die();
                
                return view('admin/admin/adminList',$DB);
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Admin List Son

    //! Admin - Bilgi Sayfası
    public function AdminInfoView($site_lang="tr",$id)
    {

        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Arama
                $DB_Find = DB::table('users')->where('id',$id)->first(); //! Kullanıcı Bilgileri
                //echo "<pre>"; print_r($DB_Find); die();
                
                $DB_Find_roles = DB::table('roles')->get(); //! Role Listesi
                //echo "<pre>"; print_r($DB_Find_roles); die();

                $DB_Find_departman = DB::table('departmanlist')->get(); //! Departman Listesi
                //echo "<pre>"; print_r($DB_Find_departman); die();

                if($DB_Find) {  
                
                    //! Return
                    $DB["CookieData"] = $CookieControl["CookieDataList"];
                    $DB["DB_Find"] =  $DB_Find;
                    $DB["DB_Find_roles"] =  $DB_Find_roles;
                    $DB["DB_Find_departman"] =  $DB_Find_departman;

                    //echo "<pre>"; print_r($DB); die();

                    return view('admin/admin/adminInfo',$DB); 
                }
                else { return view('error404'); }                    
                
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
            
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Admin - Bilgi Sayfası Son

    //! Admin - Arama Post
    public function AdminSearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $DB_Find = DB::table('users')->where('id',$request->id)->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                $response = array(
                    'status' => 'success',
                    'msg' => __('admin.transactionSuccessful'),
                    'DB' =>  $DB_Find,
                    'error' => null
                );

                return response()->json($response);
            }

            else {

                $response = array(
                    'status' => 'error',
                    'msg' => __('admin.dataNotFound'),
                    'DB' =>  [],
                    'error' => null
                );

                return response()->json($response);
            }

        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'DB' =>  [],
                'error' => $th,            
            );

            return response()->json($response);
        }
    } //! Admin - Arama Post Son

    //! Admin - Veri Ekleme Post
    public function AdminAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        //echo "img_url:"; echo config('admin.Default_UserImgUrl'); die();
        //echo "role:"; echo $request->role; die();
        //echo "departman:"; echo $request->departman; die();

        try { 

            //! Veri Arama
            $DB_Find = DB::table('users')->where('email',$request->email)->first(); //Tüm verileri çekiyor

            // EmailIsUsed

            if($DB_Find) { $response = array( 'status' => 'error', 'msg' => __('admin.emailIsUsed'), 'error' => null, );  return response()->json($response); }
            else { 

                //! Veri Ekleme
                DB::table('users')->insert([
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'email' => $request->email,
                    'password' => $request->password,
                    'img_url'=> config('admin.Default_UserImgUrl'),
                    'role_id'=>$request->role,
                    'departman_id'=>$request->departman,
                    'isActive'=>$request->isActive,
                    'created_byId'=>$request->created_byId,
                ]); //! Veri Ekleme Son

                
                //! Return
                $response = array( 'status' => 'success', 'msg' => __('admin.transactionSuccessful'), 'error' => null, );

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

    } //! Admin - Veri Ekleme Post Son

    //! Admin - Veri Silme Post
    public function AdminDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $DB_Find = DB::table('users')->where('id',$request->id)->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Silme
                $DB_Status = DB::table('users')->where('id',$request->id)->delete();

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

    } //! Admin - Veri Silme Post Son

    //! Admin - Veri Çoklu Silme Post
    public function AdminDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Silme
            $DB_Status = DB::table('users')->whereIn('id',$request->ids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Admin - Veri Çoklu Silme Post Son

    //! Admin - Veri Güncelleme Post
    public function AdminEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {  

            //! Veri Arama
            $DB = DB::table('users')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'name'=>$request->name,
                    'surname'=>$request->surname,
                    'phone'=>$request->phone,

                    'dateofBirth'=>$request->dateofBirth,
                    'role_id'=>$request->role,
                    'departman_id'=>$request->departman,

                    'isUpdated'=>true,
                    'updated_at'=>Carbon::now(),
                    'updated_byId'=>$request->updated_byId,
                ]);

                //! Veri Güncelleme Başarılı
                if($DB_Status) { 

                    //! Cookie Fonksiyon Kullanımı
                    $CookieControl =  cookieControl(); //! Çerez Kontrol
                    //echo "<pre>"; print_r($CookieControl); die();

                    if( $CookieControl["CookieDataList"]["yildirimdev_userID"] ==  $request->id ) { 
                    
                        //! Cookie Güncelleme
                        $CookieData = array();
                        $CookieData["yildirimdev_name"] = $request->name;
                        $CookieData["yildirimdev_surname"] = $request->surname;
                        $CookieData["yildirimdev_roleID"] = $request->role;
                        $CookieData["yildirimdev_departmanID"] = $request->departman;

                        $CookieEdit =  cookieEdit($CookieData); 
                        //! Cookie Güncelleme Son
                       
                    }

                }
                //! Veri Güncelleme Başarılı Son               
                
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
    } //! Admin - Veri Güncelleme Post Son

    //! Admin - Veri Güncelleme Password
    public function AdminEditPassword(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
               

                //! Veri Arama
                $DB = DB::table('users')->where('id',$request->id)->where('password',$request->myPassword); //Veri Tabanı
                $DB_Find = $DB->first(); //Tüm verileri çekiyor
                //echo "<pre>"; print_r($DB_Find); die();

                if($DB_Find) {

                    //! Veri Güncelle
                    $DB_Status = $DB->update([            
                        'password'=>$request->password,
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
                        'msg' => __('admin.theEmailPasswordMayBeIncorrect'),
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

    } //! Admin - Veri Güncelleme Password Son
    
    //! Admin - Veri Güncelleme Email
    public function AdminEditEmail(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

                //! Veri Arama
                $DB = DB::table('users')->where('id',$request->id); //Veri Tabanı
                $DB_Find = $DB->first(); //Tüm verileri çekiyor
                //echo "<pre>"; print_r($DB_Find); die();

                if($DB_Find) {

                    //! Veri Güncelle
                    $DB_Status = $DB->update([            
                        'email'=>$request->myEmail,
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

    } //! Admin - Veri Güncelleme Email Son
   
    //! Admin - Veri Güncelleme ImgUrl
    public function AdminEditImgUrl(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $DB = DB::table('users')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();

            if($DB_Find) { 

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'img_url'=>$request->img_url,
                    'isUpdated'=>true,
                    'updated_at'=>Carbon::now(),
                    'updated_byId'=>$request->updated_byId,
                ]);

                
                //! Veri Güncelleme Başarılı
                if($DB_Status) {  

                    //! Cookie Fonksiyon Kullanımı
                    $CookieControl =  cookieControl(); //! Çerez Kontrol
                    //echo "<pre>"; print_r($CookieControl); die();

                    if( $CookieControl["CookieDataList"]["yildirimdev_userID"] ==  $request->id ) { 
                    
                        //! Cookie Güncelleme
                        $CookieData = array();
                        $CookieData["yildirimdev_img_url"] = $request->img_url;

                        $CookieEdit =  cookieEdit($CookieData); 
                        //! Cookie Güncelleme Son
                    }

                }
                //! Veri Güncelleme Başarılı Son

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

    } //! Admin - Veri Güncelleme ImgUrl Son
    
    //! Admin - Veri Durum Güncelleme Post
    public function AdminEditActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $DB = DB::table('users')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'isActive'=>$request->active == "true" ? true : false,
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

    } //! Admin - Veri Durum Güncelleme Post Son

    //! Admin - Çoklu Veri Durum Güncelle - Post
    public function AdminEditMultiActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Güncelleme
            $DB_Status = DB::table('users')->whereIn('id',$request->ids)
            ->update([  
                'isActive'=>$request->active == "true" ? true : false,
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

        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );

            return response()->json($response);
        }

    } //! Admin - Çoklu Veri Durum Güncelle - Post Son

    //************* Ayarlar - LocalStorage ***************** */

    //! Ayarlar - Local Stroge
    public function settingLocalStorage(Request $request)
    {
        
        try {

            \Illuminate\Support\Facades\App::setLocale($request->lang); //! Çoklu Dil
            //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();
            
            $transLang = app('translator')->get('admin');  //! Dil Çevirme
            $response = array( 'status' => 'success', 'searchKey' => $transLang, 'siteLang'=>$request->lang  );
            return response()->json($response);

        } catch (\Throwable $th) {
            $response = array( 'status' => 'error', 'error' => $th );
            return response()->json($response);
        }
        
    } //! Ayarlar - Local Stroge - Son
    
     //************* Ayarlar - Menu  ***************** */

    //! Ayarlar - Menu
    public function SettingMenu($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "multimenu";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."orderId", "order" => "asc" ); //! Bilgiler
                $groupData = []; //! GroupData
                $selectData = [];  //! Select
                $selectDataRaw = [];  //! Select - Raw
                $joinData = [];  //! Join

                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "Menu", "table" => $table, "where" => "parent_id", "data_item_object" => "=", "data_key_type" => "string", ); //! Eşit
                $searchData[] = array("params" => "Status", "table" => $table, "where" => "isActive", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "Slug", "table" => $table, "where" => "slug", "data_item_object" => "likeBoth", "data_key_type" => "string", ); //! Like
                $searchData[] = array("params" => "Route", "table" => $table, "where" => "route_name", "data_item_object" => "likeBoth", "data_key_type" => "string", ); //! Like
                $searchData[] = array("params" => "TR", "table" => $table, "where" => "tr", "data_item_object" => "likeBoth", "data_key_type" => "string", ); //! Like
                $searchData[] = array("params" => "EN", "table" => $table, "where" => "en", "data_item_object" => "likeBoth", "data_key_type" => "string", ); //! Like
               
                
                $whereData = []; //! Where
                //$whereData[] = array( "table" => $table, "where" => "created_byId" , "data_item_object" => "=", "value" => 26 ); //! Arama
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                $DB_MenuFind = DB::table("multimenu")->where("parent_id",0)->orderBy('tr','asc')->get(); //! Menu
                //echo "<pre>"; print_r($DB_MenuFind); die();
                    
                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];
                $DB["DB_MenuFind"] = $DB_MenuFind;

                //echo "<pre>"; print_r($DB); die();
                return view('admin/settings/setting_menuList',$DB);
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Ayarlar - Menu Son

    //! Ayarlar - Menu - Arama Post
    public function SettingMenuSearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('multimenu')->where('id',$request->id)->first(); //Tüm verileri çekiyor
   
            if($DB_Find) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
                  'error' => null,
               );
   
               return response()->json($response);
            }
   
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' => __('admin.transactionFailed'),
               'DB' =>  [],
               'error' => $th,            
            );
   
            return response()->json($response);
        }

    } //! Ayarlar - Menu - Arama Post Son

    //! Ayarlar - Menu - Veri Ekleme Post
    public function SettingMenuAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Ekleme
            $getId = DB::table('multimenu')->insertGetId([
                'slug' => $request->slug,
                'parent_id' => $request->parent_id,
                'route_name' => $request->route_name,

                'tr' => $request->tr,
                'en' => $request->en,

                'created_byId'=>$request->created_byId,
            ]); //! Veri Ekleme Son

            //! Order Id yaz
            DB::table('multimenu')->where('id',$getId)->update([ 'orderId'=>$getId ]);



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

    } //! Ayarlar - Menu - Veri Ekleme Post Son

    //! Ayarlar - Menu - Veri Silme Post
    public function SettingMenuDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'multimenu';
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

    } //! Ayarlar - Menu - Veri Silme Post Son

    //! Ayarlar - Menu - Veri Çoklu Silme Post
    public function SettingMenuDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Silme
            $DB_Status = DB::table('multimenu')->whereIn('id',$request->ids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Ayarlar - Menu - Veri Çoklu Silme Post Son

    //! Ayarlar - Menu - Veri Güncelleme Post
    public function SettingMenuEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB = DB::table('multimenu')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'slug' => $request->slug,
                    'parent_id' => $request->parent_id,
                    'route_name' => $request->route_name,

                    'tr' => $request->tr,
                    'en' => $request->en,
                    
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

    } //! Ayarlar - Menu - Veri Güncelleme Post Son

    //! Ayarlar - Veri Durum Güncelleme Post
    public function SettingMenuEditActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $DB = DB::table('multimenu')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'isActive'=>$request->active == "true" ? true : false,
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

    } //! Ayarlar - Veri Durum Güncelleme Post Son

    //! Ayarlar - Çoklu Veri Durum Güncelle - Post
    public function SettingMenuEditMultiActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Güncelleme
            $DB_Status = DB::table('multimenu')->whereIn('id',$request->ids)
            ->update([  
                'isActive'=>$request->active == "true" ? true : false,
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

        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );

            return response()->json($response);
        }

    } //! Ayarlar - Çoklu Veri Durum Güncelle - Post Son

    //! Ayarlar - Menu - Veri Sıralama Post
    public function SettingMenuOrderPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $DB = DB::table('multimenu')->whereIn('id',[$request->data_id,$request->data_otherId]); //Veri Tabanı
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();

            if($DB_Find) {
                
                //! Veri Güncelle
                $DB_Status = $DB->update(
                        ['orderId'=> DB::raw('CASE WHEN (id='.$request->data_id.') THEN ( SELECT orderId FROM multimenu WHERE id = '.$request->data_otherId.')
                            WHEN (id='.$request->data_otherId.') THEN ( SELECT orderId FROM multimenu WHERE id = '.$request->data_id.') END
                        ')]
                );


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

    } //! Ayarlar - Menu - Veri Sıralama Post Son

    //! Ayarlar - Menu  -Clone - Post
    public function SettingMenuClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'multimenu';
            $DB = DB::table($table)->where('id',$request->id); //VeriTabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) { 
            
                //! Verileri Ayarlıyor
                unset($DB_Find->id); //! Veri Silme 
                unset($DB_Find->created_at); //! Veri Silme 
                unset($DB_Find->isUpdated); //! Veri Silme 
                unset($DB_Find->updated_at); //! Veri Silme 
                unset($DB_Find->updated_byId); //! Veri Silme 
                unset($DB_Find->isActive); //! Veri Silme 
                unset($DB_Find->isDeleted); //! Veri Silme 
                unset($DB_Find->deleted_at); //! Veri Silme 
                unset($DB_Find->deleted_byId); //! Veri Silme 

                $DB_Find->created_byId = $request->created_byId; //! Veri Güncelle
            
                //! Tanım
                $newData = array(); //! Eklenecek Veri 
                $table_columns = array_keys(json_decode(json_encode($DB_Find), true));  //! Sutun Veriler
            
                //! Veriler
                for ($i=0; $i < count($table_columns); $i++) { 
                    $col=$table_columns[$i];
                    $newData[$col] = $DB->pluck($col)[0];
                }
                //! Veriler Son

                //$newData['img_url'] = config('admin.Default_UserImgUrl');
                $newData['created_byId'] = $request->created_byId;

                //! Veri Ekleme
                $addNewId = DB::table($table)->insertGetId($newData); //! Veri Ekleme Son

                $response = array(
                    'status' => 'success',
                    'msg' => __('admin.transactionSuccessful'),
                    'error' => null, 
                    'addNewId' => $addNewId,
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

    } //! Ayarlar - Menu  - Clone - Post Son

    //! Ayarlar - Menu  - Çoklu Clone - Post
    public function SettingMenuClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $table = 'multimenu';
            $DB = DB::table($table)->whereIn('id',$request->ids);
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if( count($DB_Find) > 0 ){ 

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData;
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Ayarlar - Menu  - Çoklu Clone - Post 
    
    //************* Ayarlar - Log  ***************** */

    //! Log List
    public function SettingLog($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 
            
            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "logs";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData
                $selectData = [];  //! Select
                $selectDataRaw = [];  //! Select - Raw
                $joinData = [];  //! Join
                
                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "Status", "table" => $table, "where" => "isActive", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "CreatedById", "table" => $table, "where" => "created_byId", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "CreatedDate", "table" => $table, "where" => "created_at", "data_item_object" => "likeStart", "data_key_type" => "string", ); //! Başında Varsa
                $searchData[] = array("params" => "CreatedDateBottom", "table" => $table, "where" => "created_at", "data_item_object" => ">=", "data_key_type" => "date", ); //! Zaman Büyük ve Eşit
                $searchData[] = array("params" => "CreatedDateTop", "table" => $table, "where" => "created_at", "data_item_object" => "<=", "data_key_type" => "date", ); //! Zaman Küçük ve Eşit
                $searchData[] = array("params" => "ServiceDbStart", "table" => $table, "where" => "serviceDb", "data_item_object" => "likeStart", "data_key_type" => "string", ); //! Başında Varsa
                $searchData[] = array("params" => "LogServiceCode", "table" => $table, "where" => "serviceCode", "data_item_object" => "=", "data_key_type" => "string", ); //! Eşit
                $searchData[] = array("params" => "LogStatus", "table" => $table, "where" => "status", "data_item_object" => "=", "data_key_type" => "string", ); //! Eşit
                
                $whereData = []; //! Where
                //$whereData[] = array( "table" => $table, "where" => "created_byId" , "data_item_object" => "=", "value" => 26 ); //! Arama
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();
                    
                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                
                return view('admin/settings/setting_logList',$DB);
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Log List Son

    //! Log - Arama Sayfası
    public function SettingLogSearchView($site_lang="tr",$id)
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Arama
                $DB_Find = DB::table('logs')->where('id',$id)->first(); //Tüm verileri çekiyor

                if($DB_Find) {  
                
                    //! Return
                    $DB["CookieData"] = $CookieControl["CookieDataList"];
                    $DB["DB_Find"] =  $DB_Find;

                    echo "<pre>"; print_r($DB); die();
                    //return view('admin/04_sabit_log_list/00_2_sabit_list_view',$DB); 
                }
                else { return view('error404'); }                    
                
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Log - Arama Sayfası Son

    //! Log - Arama Post
    public function SettingLogSearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $DB_Find = DB::table('logs')->where('id',$request->id)->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                $response = array(
                    'status' => 'success',
                    'msg' => __('admin.transactionSuccessful'),
                    'DB' =>  $DB_Find,
                    'error' => null,
                );

                return response()->json($response);
            }

            else {

                $response = array(
                    'status' => 'error',
                    'msg' => __('admin.dataNotFound'),
                    'DB' =>  [],
                    'error' => null, 
                );

                return response()->json($response);
            }

        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'DB' =>  [],
                'error' => $th,            
            );

            return response()->json($response);
        }
    } //! Log - Arama Post Son

    //! Log - Veri Ekleme Sayfası
    public function SettingLogAddView($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();


                //! Log Ekleme
                $LogAddData = [];
                $LogAddData["serviceName"] = "Kullanıcı"; //? Servis Adı [ Kullanıcı ]
                $LogAddData["serviceDb"] = "users"; //? Kullanılan Veri Tabanı [ users ]
                $LogAddData["serviceDb_Id"] = 1;  //? Kullanılan Veri Tabanı Id [ 16 ]
                $LogAddData["serviceCode"] = "delete"; //? Servis Kodu [ list / add / delete / edit / view ]
                $LogAddData["status"] = "success"; //? Durumlar [ success ]
                $LogAddData["decription"] = "Kullanıcı Silindi"; //? Açıklama [ decription ]
                $LogAddData["created_byId"] = $_COOKIE["yildirimdev_userID"]; //? İşlemi Yapan Kişi [ 1 ] 

                //echo "<pre>"; print_r($LogAddData); die(); 

                //! Fonksiyon Kullanımı
                $LogAddFunction = LogAdd($LogAddData); //! Fonksiyon
                echo "<pre>"; print_r($LogAddFunction); die();
                //echo "status:"; echo $LogAddData["status"]; die();
                //! Log Ekleme Son

                /**
                * [ serviceName ]  => Servis Adı [ Kullanıcı ]
                * [ serviceDb ]  => Kullanılan Veri Tabanı [ users ]
                * [ serviceDb_Id ]  => Kullanılan Veri Tabanı Id [ 16 ]
                * [ serviceCode ]  =>  Servis Kodu [ list / add / delete / edit / view ]
                * [ status ]  =>  Durumlar [ success / info / error ]
                * [ decription ]  =>  Açıklama [ Veri Eklendi ]
                * [ created_at ]  => İşlem Zamanı [ 1 ] 
                * [ created_byId ]  => İşlemi Yapan Kişi [ 1 ] 
                */
                
                //! Return
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                //return view('admin/04_sabit_log_list/00_3_sabit_list_add',$DB); 
                
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
            
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Log - Veri Ekleme Sayfası Son

    //! Log - Veri Silme Post
    public function SettingLogDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $DB_Find = DB::table('logs')->where('id',$request->id)->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Silme
                $DB_Status = DB::table('logs')->where('id',$request->id)->delete();

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

    } //! Log - Veri Silme Post Son

    //! Log - Veri Çoklu Silme Post
    public function SettingLogDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Silme
            $DB_Status = DB::table('logs')->whereIn('id',$request->ids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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
    } //! Log - Veri Çoklu Silme Post Son

    //! Log  -Clone - Post
    public function SettingLogClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'logs';
            $DB = DB::table($table)->where('id',$request->id); //VeriTabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) { 
            
                //! Verileri Ayarlıyor
                unset($DB_Find->id); //! Veri Silme 
                unset($DB_Find->created_at); //! Veri Silme 
                unset($DB_Find->isUpdated); //! Veri Silme 
                unset($DB_Find->updated_at); //! Veri Silme 
                unset($DB_Find->updated_byId); //! Veri Silme 
                unset($DB_Find->isActive); //! Veri Silme 
                unset($DB_Find->isDeleted); //! Veri Silme 
                unset($DB_Find->deleted_at); //! Veri Silme 
                unset($DB_Find->deleted_byId); //! Veri Silme 

                $DB_Find->created_byId = $request->created_byId; //! Veri Güncelle
            
                //! Tanım
                $newData = array(); //! Eklenecek Veri 
                $table_columns = array_keys(json_decode(json_encode($DB_Find), true));  //! Sutun Veriler
            
                //! Veriler
                for ($i=0; $i < count($table_columns); $i++) { 
                    $col=$table_columns[$i];
                    $newData[$col] = $DB->pluck($col)[0];
                }
                //! Veriler Son

                //$newData['img_url'] = config('admin.Default_UserImgUrl');
                $newData['created_byId'] = $request->created_byId;

                //! Veri Ekleme
                $addNewId = DB::table($table)->insertGetId($newData); //! Veri Ekleme Son

                $response = array(
                    'status' => 'success',
                    'msg' => __('admin.transactionSuccessful'),
                    'error' => null, 
                    'addNewId' => $addNewId,
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

    } //! Log  - Clone - Post Son

    //! Log  - Çoklu Clone - Post
    public function SettingLogClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $table = 'logs';
            $DB = DB::table($table)->whereIn('id',$request->ids);
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if( count($DB_Find) > 0 ){ 

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                
                    $DB_FindInsert[] = $newData;
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Log  - Çoklu Clone - Post 

    //************* Ayarlar - Role  ***************** */

    //! Ayarlar - Role
    public function SettingRole($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "roles";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData
                $selectData = [];  //! Select
                $selectDataRaw = [];  //! Select - Raw
                $joinData = [];  //! Join
                $searchData = []; //! Arama
                $whereData = []; //! Where
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                
                return view('admin/settings/setting_roleList',$DB);
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Ayarlar - Role Son

    //! Ayarlar - Role - Arama Post
    public function SettingRoleSearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('roles')->where('id',$request->id)->first(); //Tüm verileri çekiyor
   
            if($DB_Find) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
                  'error' => null, 
               );
   
               return response()->json($response);
            }
   
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' => __('admin.transactionFailed'),
               'DB' =>  [],
               'error' => $th,            
            );
   
            return response()->json($response);
        }

    } //! Ayarlar - Role - Arama Post Son

    //! Ayarlar - Role - Veri Ekleme Post
    public function SettingRoleAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Ekleme
            DB::table('roles')->insert([
                'title' => $request->title,
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

    } //! Ayarlar - Role - Veri Ekleme Post Son

    //! Ayarlar - Role - Veri Silme Post
    public function SettingRoleDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'roles';
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

    } //! Ayarlar - Role - Veri Silme Post Son

    //! Ayarlar - Role - Veri Çoklu Silme Post
    public function SettingRoleDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Silme
            $DB_Status = DB::table('roles')->whereIn('id',$request->ids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Ayarlar - Role - Veri Çoklu Silme Post Son

    //! Ayarlar - Role - Veri Güncelleme Post
    public function SettingRoleEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB = DB::table('roles')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'title' => $request->title,
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

    } //! Ayarlar - Role - Veri Güncelleme Post Son

    //! Ayarlar - Role  -Clone - Post
    public function SettingRoleClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'roles';
            $DB = DB::table($table)->where('id',$request->id); //VeriTabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) { 
            
                //! Verileri Ayarlıyor
                unset($DB_Find->id); //! Veri Silme 
                unset($DB_Find->created_at); //! Veri Silme 
                unset($DB_Find->isUpdated); //! Veri Silme 
                unset($DB_Find->updated_at); //! Veri Silme 
                unset($DB_Find->updated_byId); //! Veri Silme 
                unset($DB_Find->isActive); //! Veri Silme 
                unset($DB_Find->isDeleted); //! Veri Silme 
                unset($DB_Find->deleted_at); //! Veri Silme 
                unset($DB_Find->deleted_byId); //! Veri Silme 

                $DB_Find->created_byId = $request->created_byId; //! Veri Güncelle
            
                //! Tanım
                $newData = array(); //! Eklenecek Veri 
                $table_columns = array_keys(json_decode(json_encode($DB_Find), true));  //! Sutun Veriler
            
                //! Veriler
                for ($i=0; $i < count($table_columns); $i++) { 
                    $col=$table_columns[$i];
                    $newData[$col] = $DB->pluck($col)[0];
                }
                //! Veriler Son

                //$newData['img_url'] = config('admin.Default_UserImgUrl');
                $newData['created_byId'] = $request->created_byId;

                //! Veri Ekleme
                $addNewId = DB::table($table)->insertGetId($newData); //! Veri Ekleme Son

                $response = array(
                    'status' => 'success',
                    'msg' => __('admin.transactionSuccessful'),
                    'error' => null, 
                    'addNewId' => $addNewId,
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

    } //! Ayarlar - Role  - Clone - Post Son

    //! Ayarlar - Role  - Çoklu Clone - Post
    public function SettingRoleClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $table = 'roles';
            $DB = DB::table($table)->whereIn('id',$request->ids);
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if( count($DB_Find) > 0 ){ 

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData;
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Ayarlar - Role  - Çoklu Clone - Post Son
    
    //************* Ayarlar - Departman  ***************** */

    //! Ayarlar - Departman
    public function SettingDepartment($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {  

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "departmanlist";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData
                $selectData = [];  //! Select
                $selectDataRaw = [];  //! Select - Raw
                $joinData = [];  //! Join
                $searchData = [];   //! Arama
                $whereData = []; //! Where
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                return view('admin/settings/setting_departmentList',$DB);
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Ayarlar - Departman Son

    //! Ayarlar - Departman - Arama Post
    public function SettingDepartmentSearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('departmanlist')->where('id',$request->id)->first(); //Tüm verileri çekiyor
   
            if($DB_Find) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
                  'error' => null,
               );
   
               return response()->json($response);
            }
   
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' => __('admin.transactionFailed'),
               'DB' =>  [],
               'error' => $th,            
            );
   
            return response()->json($response);
        }

    } //! Ayarlar - Departman - Arama Post Son

    //! Ayarlar - Departman - Veri Ekleme Post
    public function SettingDepartmentAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Ekleme
            DB::table('departmanlist')->insert([
                'title' => $request->title,
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

    } //! Ayarlar - Departman - Veri Ekleme Post Son

    //! Ayarlar - Departman - Veri Silme Post
    public function SettingDepartmentDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'departmanlist';
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

    } //! Ayarlar - Departman - Veri Silme Post Son

    //! Ayarlar - Departman - Veri Çoklu Silme Post
    public function SettingDepartmentDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Silme
            $DB_Status = DB::table('departmanlist')->whereIn('id',$request->ids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Ayarlar - Departman - Veri Çoklu Silme Post Son

    //! Ayarlar - Departman - Veri Güncelleme Post
    public function SettingDepartmentEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB = DB::table('departmanlist')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'title' => $request->title,
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

    } //! Ayarlar - Departman - Veri Güncelleme Post Son 

    //! Ayarlar - Departman  -Clone - Post
    public function SettingDepartmentClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'departmanlist';
            $DB = DB::table($table)->where('id',$request->id); //VeriTabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) { 
            
                //! Verileri Ayarlıyor
                unset($DB_Find->id); //! Veri Silme 
                unset($DB_Find->created_at); //! Veri Silme 
                unset($DB_Find->isUpdated); //! Veri Silme 
                unset($DB_Find->updated_at); //! Veri Silme 
                unset($DB_Find->updated_byId); //! Veri Silme 
                unset($DB_Find->isActive); //! Veri Silme 
                unset($DB_Find->isDeleted); //! Veri Silme 
                unset($DB_Find->deleted_at); //! Veri Silme 
                unset($DB_Find->deleted_byId); //! Veri Silme 

                $DB_Find->created_byId = $request->created_byId; //! Veri Güncelle
            
                //! Tanım
                $newData = array(); //! Eklenecek Veri 
                $table_columns = array_keys(json_decode(json_encode($DB_Find), true));  //! Sutun Veriler
            
                //! Veriler
                for ($i=0; $i < count($table_columns); $i++) { 
                    $col=$table_columns[$i];
                    $newData[$col] = $DB->pluck($col)[0];
                }
                //! Veriler Son

                //$newData['img_url'] = config('admin.Default_UserImgUrl');
                $newData['created_byId'] = $request->created_byId;

                //! Veri Ekleme
                $addNewId = DB::table($table)->insertGetId($newData); //! Veri Ekleme Son

                $response = array(
                    'status' => 'success',
                    'msg' => __('admin.transactionSuccessful'),
                    'error' => null, 
                    'addNewId' => $addNewId,
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

    } //! Ayarlar - Departman  - Clone - Post Son

    //! Ayarlar - Departman  - Çoklu Clone - Post
    public function SettingDepartmentClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $DB = DB::table('departmanlist')->whereIn('id',$request->ids);
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if( count($DB_Find) > 0 ){ 

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData;
                }

                //! Veri Ekleme
                $addNewStatus = DB::table('departmanlist')->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Ayarlar - Departman  - Çoklu Clone - Post Son

    
    //************* Web ***************** */

    //! Web Ayarları
    public function WebSetting($site_lang="tr")
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 
            
            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();
                    
                //! Return
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //! Site Bilgileri
                $DB_HomeSettings= DB::table('homesettings')->where('id','=',2)->first();
                //echo "<pre>"; print_r($DB_HomeSettings); die();

                $DB["DB_HomeSettings"] =  $DB_HomeSettings;
                //! Site Bilgileri Son

                //echo "<pre>"; print_r($DB); die();
                
                return view('admin/web/settings',$DB); 
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Web Ayarları Son

    //! Web Ayarları Post
    public function WebSettingPost(Request $request)
    {

        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $DB = DB::table('homesettings')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'title'=>$request->title,
                    'siteUrl'=>$request->siteUrl,
                    
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

    } //! Web Ayarları Post Son

    //! Web - Sosyal Medya Ayarları Post
    public function WebSocailMediaSettingPost(Request $request)
    {

        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $DB = DB::table('homesettings')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {  

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'email'=>$request->email,
                    'phone'=>$request->phone,
                    'phone2'=>$request->phone2,
                    'whatsapp'=>$request->whatsapp,
                    'address'=>$request->address,
                    'web_address_map'=>$request->web_address_map,

                    'facebook_Url'=>$request->facebook_Url,
                    'twitter_Url'=>$request->twitter_Url,
                    'instagram_Url'=>$request->instagram_Url,
                    'linkedln_Url'=>$request->linkedln_Url,
                    'youtube_Url'=>$request->youtube_Url,
                    
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

    } //! Web - Sosyal Medya Ayarları Post Son

    //! Web - Seo Ayarları Post
    public function WebSeoSettingPost(Request $request)
    {

        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $DB = DB::table('homesettings')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {  

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'seo_description'=>$request->seo_description,
                    'seo_keywords'=>$request->seo_keywords,

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

    } //! Web - Seo Ayarları Post Son

    //************* Kurumsal ***************** */

    //! Kurumsal - Sayfa Control
    public function InstitutionalControl($site_lang="tr"){ 

        $routerData = \Request::route()->getName(); //! Rputer
        $routerDataExplode = explode(".", $routerData); //! Parçalıyor
        $routerDataExplodeLength = count($routerDataExplode); //! Parça Sayısı
        $name = $routerDataExplode[$routerDataExplodeLength-1]; //! Son Veri

        echo $this->Institutional($site_lang,$name);
    }//! Kurumsal - Sayfa Control Son

    //! Kurumsal - Sayfa
    public function Institutional($site_lang="tr",$name)
    {  
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();
        
        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Veri Tabanı
                $DB_tr = DB::table('institutional')->where('lang','=','tr')->first();
                $DB_en = DB::table('institutional')->where('lang','=','en')->first();
                $DB_de = DB::table('institutional')->where('lang','=','de')->first();
                
                //! Return
                $DB["CookieData"] = $CookieControl["CookieDataList"];
                $DB["institutional_name"] =  $name; //! Kurumsal
                $DB["DB_tr"] =  $DB_tr;
                $DB["DB_en"] =  $DB_en;
                $DB["DB_de"] =  $DB_de;

                $DB["institutional_title"] =  __('admin.'.$name);

                //echo "<pre>"; print_r($DB); die();

                return view('admin/web/institutional/institutionalEdit',$DB); 
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Kurumsal - Sayfa Son

    //! Kurumsal -  Veri Güncelleme Post
    public function InstitutionalEdit(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
            
            //! Veri Arama
            $DB = DB::table('institutional')->where('lang',$request->lang); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Resim
                $institutional_imgUrl = $request->institutional.'_img_url';

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    $request->institutional => $request->data,
                    $institutional_imgUrl => $request->img_url,
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

    } //! Kurumsal  Veri Güncelleme Post Son 

    //! Kurumsal -  Veri Güncelleme Post
    public function InstitutionalEditImage(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
            
            //! Veri Arama
            $DB = DB::table('institutional'); //Veri Tabanı
            $DB_Find = $DB->get(); //Tüm verileri çekiyor

            if(count($DB_Find) > 0) { 

                //! Resim
                $institutional_imgUrl = $request->institutional.'_img_url';

                //! Veri Güncelle
                $DB_Status = $DB->update([    
                    $institutional_imgUrl => $request->img_url,
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

    } //! Kurumsal  Veri Güncelleme Post Son 
    
        
    //************* Kurumsal - Refaranslar ***************** */

    //! Kurumsal - Refaranslar
    public function InstitutionalReferences($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "institutional_references";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData
                $selectData = [];  //! Select
                $selectDataRaw = [];  //! Select - Raw
                $joinData = [];  //! Join

                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "id", "table" => $table, "where" => "id", "data_item_object" => "=", "data_key_type" => "string", ); //! Eşit
                $searchData[] = array("params" => "Status", "table" => $table, "where" => "isActive", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                
                $whereData = []; //! Where
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                return view('admin/web/institutional/InstitutionalReferences',$DB); 
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Kurumsal - RefaranslarSon

    //! Kurumsal - Refaranslar - Arama Post
    public function InstitutionalReferencesSearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('institutional_references')->where('id',$request->id)->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
   
            if( count($DB_Find) > 0 ) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
                  'error' => null, 
               );
   
               return response()->json($response);
            }
   
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' => __('admin.transactionFailed'),
               'DB' =>  [],
               'error' => $th,            
            );
   
            return response()->json($response);
        }

    } //! Kurumsal - Refaranslar- Arama Post Son

    //! Kurumsal - Refaranslar- Veri Ekleme Post
    public function InstitutionalReferencesAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
 
            //! Veri Ekleme
            $DB_Status = DB::table('institutional_references')->insert([
                'img_url' => $request->img_url,
                'title' => $request->title,
                'site_url' => $request->site_url,
                'created_byId'=>$request->created_byId,
            ]); //! Veri Ekleme Son
           
            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.dataNotFound'),
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

    } //! Kurumsal - Refaranslar- Veri Ekleme Post Son

    //! Kurumsal - Refaranslar- Veri Silme Post
    public function InstitutionalReferencesDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'institutional_references';
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

    } //! Kurumsal - Refaranslar- Veri Silme Post Son

    //! Kurumsal - Refaranslar- Veri Çoklu Silme Post
    public function InstitutionalReferencesDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Silme
            $DB_Status = DB::table('institutional_references')->whereIn('id',$request->ids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Kurumsal - Refaranslar- Veri Çoklu Silme Post Son

    //! Kurumsal - Refaranslar- Veri Güncelleme Post
    public function InstitutionalReferencesEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $DB = DB::table('institutional_references')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'img_url' => $request->img_url,
                    'title' => $request->title,
                    'site_url' => $request->site_url,   
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

    } //! Kurumsal - Refaranslar- Veri Güncelleme Post Son 
            
    //! Kurumsal - Refaranslar- Veri Durum Güncelleme Post
    public function InstitutionalReferencesEditActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $DB = DB::table('institutional_references')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->get(); //Tüm verileri çekiyor

            if( count($DB_Find) > 0 ) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'isActive'=>$request->active == "true" ? true : false,
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

    } //! Kurumsal - Refaranslar- Veri Durum Güncelleme Post Son

    //! Kurumsal - Refaranslar - Çoklu Veri Durum Güncelle - Post
    public function InstitutionalReferencesEditMultiActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Güncelleme
            $DB_Status = DB::table('institutional_references')->whereIn('id',$request->ids)
            ->update([  
                'isActive'=>$request->active == "true" ? true : false,
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

        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );

            return response()->json($response);
        }

    } //! Kurumsal - Refaranslar - Çoklu Veri Durum Günceleme - Post Son

    //!  Kurumsal - Refaranslar- Clone - Post
    public function InstitutionalReferencesClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'institutional_references';
            $DB = DB::table($table)->where('id',$request->id); //VeriTabanı
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();

            if( count($DB_Find) > 0 ){  

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri
                $time = time(); //! uid

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData; //! Ekleme
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
                    'error' => null,
                    'addNewId' => $time,
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

    } //!  Kurumsal - Refaranslar- Clone - Post Son

    //!  Kurumsal - Refaranslar- Çoklu Clone - Post
    public function InstitutionalReferencesClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $table = 'institutional_references';
            $DB = DB::table($table)->whereIn('id',$request->ids);
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if( count($DB_Find) > 0 ){ 

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData;
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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
               'msg' =>  __('admin.transactionFailed'),
               'error' => $th,            
            );
    
            return response()->json($response);
        }

    } //!  Kurumsal - Refaranslar- Çoklu Clone - Post Son

    //************* Faq - Kategori  ***************** */

    //! Faq - Kategori
    public function FaqCategory($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "faq_categories";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData
                $selectData = [];  //! Select
                $selectDataRaw = [];  //! Select - Raw
                $joinData = [];  //! Join

                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "uid", "table" => $table, "where" => "uid", "data_item_object" => "=", "data_key_type" => "string", ); //! Eşit
                $searchData[] = array("params" => "Status", "table" => $table, "where" => "isActive", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                
                $whereData = []; //! Where
                $whereData[] = array( "table" => $table, "where" => "lang" , "data_item_object" => "=", "value" => __('admin.lang') ); //! Arama
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                
                return view('admin/web/faq/faq_category',$DB);
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Faq - Kategori Son

    //! Faq - Kategori- Arama Post
    public function FaqCategorySearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('faq_categories')->where('uid',$request->uid)->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
   
            if( count($DB_Find) > 0 ) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
                  'error' => null, 
               );
   
               return response()->json($response);
            }
   
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' => __('admin.transactionFailed'),
               'DB' =>  [],
               'error' => $th,            
            );
   
            return response()->json($response);
        }

    } //! Faq - Kategori - Arama Post Son

    //! Faq - Kategori - Veri Ekleme Post
    public function FaqCategoryAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            
            //! Tanım
            $tableName = 'faq_categories'; //! Tablo Adı
            $time = time(); //! uid
            $langList = ['tr','en','de']; //! Dil
            $DB_Count = 0; //! Veri Sayısı
           
            for ($i=0; $i < count($langList) ; $i++) { 
                $lang = $langList[$i];

                if($lang == "tr"){  $title = $request->title_tr; }
                if($lang == "en"){  $title = $request->title_en; }
                if($lang == "de"){  $title = $request->title_de; }

                //! Ekleme
                if($title != "") { 
                    $DB_Count++; //! Veri Sayısı Artır

                    //! Veri Ekleme - TR
                    DB::table($tableName)->insert([
                        'lang' => $lang,
                        'uid' => $time,
                        'img_url' => $request->img_url,
                        'title' => $title,
                        'seo_url' => SEOLink($title),
                        'created_byId'=>$request->created_byId,
                    ]); //! Veri Ekleme - TR Son

                }

            }
           
            $response = array(
                'status' => $DB_Count > 0 ? 'success' : 'error',
                'msg' =>  $DB_Count > 0  ? __('admin.transactionSuccessful') : __('admin.dataNotFound'),
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

    } //! Faq - Kategori - Veri Ekleme Post Son

    //! Faq - Kategori - Veri Silme Post
    public function FaqCategoryDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'faq_categories';
            $DB_Find = DB::table($table)->where('uid',$request->uid)->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Silme
                $DB_Status = DB::table($table)->where('uid',$request->uid)->delete();

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

    } //! Faq - Kategori - Veri Silme Post Son

    //! Faq - Kategori - Veri Çoklu Silme Post
    public function FaqCategoryDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Silme
            $DB_Status = DB::table('faq_categories')->whereIn('uid',$request->uids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Faq - Kategori - Veri Çoklu Silme Post Son

    //! Faq - Kategori - Veri Güncelleme Post
    public function FaqCategoryEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
            
            //! Tanım
            $table = 'faq_categories'; //! Tablo Adı
            $langList = ['tr','en','de']; //! Dil
            $DB_Count = 0; //! Veri Sayısı
            
            for ($i=0; $i < count($langList) ; $i++) { 
                $lang = $langList[$i];

                if($lang == "tr"){  $title = $request->title_tr; }
                if($lang == "en"){  $title = $request->title_en; }
                if($lang == "de"){  $title = $request->title_de; }
                
                $DB = DB::table($table)->where('lang',$lang)->where('uid',$request->uid); //Veri Tabanı
                $DB_Find = $DB->get(); //Tüm verileri çekiyor
                //echo "<pre>"; print_r($DB_Find); die();

                if( count($DB_Find) > 0 ) {  
                    $DB_Count++; //! Veri Sayısı Artır

                    //! Sil
                    if($title == "") { DB::table($table)->where('lang',$lang)->where('uid',$request->uid)->delete();  }
                    else {
                        
                        //! Veri Güncelle
                        DB::table($table)
                        ->where('lang',$lang)
                        ->where('uid',$request->uid)
                        ->update([            
                            'img_url' => $request->img_url,
                            'title' => $title,
                            'seo_url' => SEOLink($title),
                            'isUpdated'=>true,
                            'updated_at'=>Carbon::now(),
                            'updated_byId'=>$request->updated_byId,
                        ]);  //! Veri Güncelle Son

                    }
                }
                else { 
                
                    if($title != "") {

                        //! Veri Ekleme 
                        DB::table($table)->insert([
                            'lang' => $lang,
                            'uid' => $request->uid,
                            'img_url' => $request->img_url,
                            'title' => $title,
                            'seo_url' => SEOLink($title),
                            'created_byId'=>$request->created_byId,
                        ]); //! Veri Ekleme Son
                    }

                }
            }
            
            $response = array(
                'status' => $DB_Count > 0 ? 'success' : 'error',
                'msg' =>  $DB_Count > 0  ? __('admin.transactionSuccessful') : __('admin.dataNotFound'),
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

    } //! Faq - Kategori - Veri Güncelleme Post Son 
            
    //! Faq - Kategori - Veri Durum Güncelleme Post
    public function FaqCategoryEditActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $DB = DB::table('faq_categories')->where('uid',$request->uid); //Veri Tabanı
            $DB_Find = $DB->get(); //Tüm verileri çekiyor

            if( count($DB_Find) > 0 ) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'isActive'=>$request->active == "true" ? true : false,
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

    } //! Faq - Kategori - Veri Durum Güncelleme Post Son

    //! Faq - Kategori  - Çoklu Veri Durum Güncelle - Post
    public function FaqCategoryEditMultiActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Güncelleme
            $DB_Status = DB::table('faq_categories')->whereIn('uid',$request->uids)
            ->update([  
                'isActive'=>$request->active == "true" ? true : false,
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

        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );

            return response()->json($response);
        }

    } //! Faq - Kategori- Çoklu Veri Durum Günceleme - Post Son

    //!  Faq - Kategori - Clone - Post
    public function FaqCategoryClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'faq_categories';
            $DB = DB::table($table)->where('uid',$request->uid); //VeriTabanı
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();

            if( count($DB_Find) > 0 ){  

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri
                $time = time(); //! uid

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->uid); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->uid = $time; //! Veri Güncelle
                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData; //! Ekleme
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
                    'error' => null,
                    'addNewId' => $time,
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

    } //!  Faq - Kategori - Clone - Post Son

    //!  Faq - Kategori - Çoklu Clone - Post
    public function FaqCategoryClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $table = 'faq_categories';
            $dbFind_uids = $request->uids;
            $dbFind_uids_count = count($dbFind_uids);
            //echo "sayisi: "; echo $dbFind_uids_count; die();

            if( $dbFind_uids_count > 0 ){ 
                        
                //! Veri Arama
                $DB = DB::table($table)->whereIn('uid',$dbFind_uids); //VeriTabanı
                $DB_Find = $DB->get(); //Tüm verileri çekiyor
                //echo "<pre>"; print_r($DB_Find); die();

                if( count($DB_Find) > 0 ){  

                    //! Tanım
                    $DB_FindInsert = []; //! Eklenecek Veri

                    for ($j=0; $j < $dbFind_uids_count; $j++) { 
                        $time = time()+$j; //! uid

                        for ($i=0; $i < count($DB_Find); $i++) {  
                            if( $DB_Find[$i]->uid == $dbFind_uids[$j] ) {
                                //echo $DB_Find[$i]->uid; echo " ";
                            
                                //! Veri Silme
                                unset($DB_Find[$i]->id); //! Veri Silme 
                                unset($DB_Find[$i]->uid); //! Veri Silme 
                                unset($DB_Find[$i]->created_at); //! Veri Silme 
                                unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                                unset($DB_Find[$i]->updated_at); //! Veri Silme 
                                unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                                unset($DB_Find[$i]->isActive); //! Veri Silme 
                                unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                                unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                                unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                                $DB_Find[$i]->uid = $time; //! Veri Güncelle
                                $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                                //! Yeni Data
                                $newData = array(); //! Eklenecek Veri 
                                $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                                
                                //! Veriler
                                for ($k=0; $k < count($table_columns); $k++) { 
                                    $col=$table_columns[$k];
                                    $newData[$col] = $DB_Find->pluck($col)[$i];
                                }
                                //! Veriler Son
                            
                                $DB_FindInsert[] = $newData; //! Ekleme
                            }
                        }

                    }

                    //! Veri Ekleme
                    $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                    $response = array(
                        'status' => $addNewStatus ? 'success' : 'error',
                        'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

            }
            else {
    
               $response = array(
                  'status' => 'error',
                  'msg' => "uid:".__('admin.dataNotFound'),
                  'error' => null,
               );
    
               return response()->json($response);
            }
    
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' =>  __('admin.transactionFailed'),
               'error' => $th,            
            );
    
            return response()->json($response);
        }

    } //!  Faq - Kategori - Çoklu Clone - Post Son

    //************* Faq ***************** */

    //! Faq - Sıkça Sorulan Sorular
    public function FaqList($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {  

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "faq";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData
                
                $selectData = [];  //! Select
                $selectData[] = array( "table" => $table, "parametre" => "*", "name" => null, );
                $selectData[] = array( "table" => "faq_categories", "parametre" => "title", "name" => "faqCategoryTitle", );

                $selectDataRaw = [];  //! Select - Raw

                $joinData = [];  //! Join
                $joinData[] = array( "type" => "LEFT", "table" => "faq_categories" , "value" => "uid", "refTable" => $table, "refValue" => "category", ); //! Join

                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "uid", "table" => $table, "where" => "uid", "data_item_object" => "=", "data_key_type" => "string", ); //! Eşit
                $searchData[] = array("params" => "Status", "table" => $table, "where" => "isActive", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "Category", "table" => $table, "where" => "category", "data_item_object" => "=", "data_key_type" => "string", ); //! Eşit
                
                $whereData = []; //! Where
                $whereData[] = array( "table" => $table, "where" => "lang" , "data_item_object" => "=", "value" => __('admin.lang') ); //! Arama
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];
                
                //! Faq Category
                $faq_categories= DB::table('faq_categories')
                ->orderBy('faq_categories.uid','desc')
                ->where('faq_categories.lang','=',__('admin.lang'))
                ->where('faq_categories.isActive','=',1)->get();
                //echo "<pre>"; print_r($faq_categories); die();

                //! Return
                $DB["faq_categories"] =  $faq_categories;
                //! Faq Category Son

                //echo "<pre>"; print_r($DB); die();
                return view('admin/web/faq/faqList',$DB); 
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Faq - Sıkça Sorulan Sorular Son

    //! Faq - Sıkça Sorulan Sorular- Arama Post
    public function FaqSearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('faq')->where('id',$request->id)->first(); //Tüm verileri çekiyor
   
            if($DB_Find) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
                  'error' => null,
               );
   
               return response()->json($response);
            }
   
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' => __('admin.transactionFailed'),
               'DB' =>  [],
               'error' => $th,            
            );
   
            return response()->json($response);
        }

    } //! Faq - Sıkça Sorulan Sorular- Arama Post Son

    //! Faq - Sıkça Sorulan Sorular - Veri Ekleme Sayfası
    public function FaqAddView($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                                    
                //! Faq Kategori
                $DB_Find_faq_categories = DB::table('faq_categories')->get(); 
                //echo "<pre>"; print_r($DB_Find_faq_categories); die();
                $DB["DB_Find_faq_categories"] = $DB_Find_faq_categories;
                //! Faq Kategori Son
                
                //! Return
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                return view('admin/web/faq/faqAdd',$DB); 
                
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
            
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Faq - Sıkça Sorulan Sorular - Veri Ekleme Sayfası Son

    //! Faq - Sıkça Sorulan Sorular- Veri Ekleme Post
    public function FaqAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //veri tabanı işlemleri
            $table = 'faq';
            $DB = DB::table($table)->where('lang','=',$request->lang)->where('uid','=',$request->uid);
            $DB_Find = $DB->first(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if($DB_Find) {

                 //! Veri Güncelle
                 $DB_Status = $DB->update([   
                    'category' => $request->category,         
                    'question' => $request->question,
                    'answer' => $request->answer,
                    'isUpdated'=>true,
                    'updated_at'=>Carbon::now(),
                    'updated_byId'=>$request->created_byId,
                ]);
            }
            else{

                //! Veri Ekleme
                $DB_Status = DB::table($table)->insert([
                    'lang' => $request->lang,
                    'uid' => $request->uid,
                    'category' => $request->category,
                    'question' => $request->question,
                    'answer' => $request->answer,
                    'created_byId'=>$request->created_byId,
                ]); //! Veri Ekleme Son

            }

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Faq - Sıkça Sorulan Sorular- Veri Ekleme Post Son

    //! Faq - Sıkça Sorulan Sorular- Veri Silme Post
    public function FaqDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'faq';
            $DB_Find = DB::table($table)->where('uid','=',$request->uid)->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Silme
                $DB_Status = DB::table($table)->where('uid','=',$request->uid)->delete();

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

    } //! Faq - Sıkça Sorulan Sorular- Veri Silme Post Son

    //! Faq - Sıkça Sorulan Sorular- Veri Çoklu Silme Post
    public function FaqDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Silme
            $DB_Status = DB::table('faq')->whereIn('uid',$request->uids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Faq - Sıkça Sorulan Sorular- Veri Çoklu Silme Post Son

    //! Faq - Veri Güncelleme Sayfası
    public function FaqEdit($site_lang="tr",$id)
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Arama
                $table = 'faq';
                $DB_Find_tr = DB::table($table)->where('uid',$id)->where('lang','tr')->first(); //Türkçe
                $DB_Find_en = DB::table($table)->where('uid',$id)->where('lang','en')->first(); //İngilizce
                $DB_Find_de = DB::table($table)->where('uid',$id)->where('lang','de')->first(); //Almanca

                if($DB_Find_tr) {

                    //! Faq Kategori
                    $DB_Find_faq_categories = DB::table('faq_categories')->get(); 
                    //echo "<pre>"; print_r($DB_Find_faq_categories); die();
                    $DB["DB_Find_faq_categories"] = $DB_Find_faq_categories;
                    //! Faq Kategori Son
                
                    //! Return
                    $DB["CookieData"] = $CookieControl["CookieDataList"];
                    $DB["DB_Find_tr"] =  $DB_Find_tr;
                    $DB["DB_Find_en"] =  $DB_Find_en;
                    $DB["DB_Find_de"] =  $DB_Find_de;

                    //echo "<pre>"; print_r($DB_Find); die();
                    //echo "<pre>"; print_r($DB); die();

                    return view('admin/web/faq/faqEdit',$DB); 

                }
                else { return view('error404'); }
            
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
           
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Faq - Veri Güncelleme Sayfası Son

    //! Faq - Sıkça Sorulan Sorular- Veri Güncelleme Post
    public function FaqEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //veri tabanı işlemleri
            $table = 'faq';
            $DB = DB::table($table)->where('lang','=',$request->lang)->where('uid','=',$request->uid);
            $DB_Find = $DB->first(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if($DB_Find) {

                 //! Veri Güncelle
                 $DB_Status = $DB->update([        
                    'category' => $request->category,    
                    'question' => $request->question,
                    'answer' => $request->answer,
                    'isUpdated'=>true,
                    'updated_at'=>Carbon::now(),
                    'updated_byId'=>$request->updated_byId,
                ]);
            }
            else{ 

                //! Veri Ekleme
                $DB_Status = DB::table($table)->insert([
                    'lang' => $request->lang,
                    'uid' => $request->uid,
                    'category' => $request->category,
                    'question' => $request->question,
                    'answer' => $request->answer,
                    'created_byId'=>$request->updated_byId,
                ]); //! Veri Ekleme Son

            }

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Faq - Sıkça Sorulan Sorular- Veri Güncelleme Post Son

    //! Faq - Veri Bilgileri Güncelleme Post
    public function FaqEditInfoPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //veri tabanı işlemleri
            $table = 'faq';
            $DB = DB::table($table)->where('uid','=',$request->uid);
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if($DB_Find) {

                 //! Veri Güncelle
                 $DB_Status = $DB->update([
                    'category' => $request->category, 
                    'isUpdated'=>true,
                    'updated_at'=>Carbon::now(),
                    'updated_byId'=>$request->updated_byId,
                ]);
            }

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Faq - Veri Bilgileri Güncelleme Post Son
        
    //! Faq - Veri Durum Güncelleme Post
    public function FaqEditActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $DB = DB::table('faq')->where('uid',$request->uid); //Veri Tabanı
            $DB_Find = $DB->get(); //Tüm verileri çekiyor

            if( count($DB_Find) > 0 ) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'isActive'=>$request->active == "true" ? true : false,
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

    } //! Faq - Veri Durum Güncelleme Post Son
    
    //! Faq - Detay - Çoklu Veri Durum Güncelle - Post
    public function FaqEditMultiActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Güncelleme
            $DB_Status = DB::table('faq')->whereIn('uid',$request->uids)
            ->update([  
                'isActive'=>$request->active == "true" ? true : false,
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

        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );

            return response()->json($response);
        }

    } //! Faq - Detay - Çoklu Veri Durum Gün
    
    //! Faq - Sıkça Sorulan Sorular -Clone - Post
    public function FaqClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'faq';
            $DB = DB::table($table)->where('uid',$request->uid); //VeriTabanı
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();

            if( count($DB_Find) > 0 ){  

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri
                $time = time(); //! uid

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->uid); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->uid = $time; //! Veri Güncelle
                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData; //! Ekleme
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
                    'error' => null,
                    'addNewId' => $time,
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

    } //! Faq - Sıkça Sorulan Sorular - Clone - Post Son

    //! Faq - Sıkça Sorulan Sorular - Çoklu Clone - Post
    public function FaqClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $table = 'faq';
            $dbFind_uids = $request->uids;
            $dbFind_uids_count = count($dbFind_uids);
            //echo "sayisi: "; echo $dbFind_uids_count; die();

            if( $dbFind_uids_count > 0 ){ 
                        
                //! Veri Arama
                $DB = DB::table($table)->whereIn('uid',$dbFind_uids); //VeriTabanı
                $DB_Find = $DB->get(); //Tüm verileri çekiyor
                //echo "<pre>"; print_r($DB_Find); die();

                if( count($DB_Find) > 0 ){  

                    //! Tanım
                    $DB_FindInsert = []; //! Eklenecek Veri

                    for ($j=0; $j < $dbFind_uids_count; $j++) { 
                        $time = time()+$j; //! uid

                        for ($i=0; $i < count($DB_Find); $i++) {  
                            if( $DB_Find[$i]->uid == $dbFind_uids[$j] ) {
                                //echo $DB_Find[$i]->uid; echo " ";
                            
                                //! Veri Silme
                                unset($DB_Find[$i]->id); //! Veri Silme 
                                unset($DB_Find[$i]->uid); //! Veri Silme 
                                unset($DB_Find[$i]->created_at); //! Veri Silme 
                                unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                                unset($DB_Find[$i]->updated_at); //! Veri Silme 
                                unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                                unset($DB_Find[$i]->isActive); //! Veri Silme 
                                unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                                unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                                unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                                $DB_Find[$i]->uid = $time; //! Veri Güncelle
                                $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                                //! Yeni Data
                                $newData = array(); //! Eklenecek Veri 
                                $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                                
                                //! Veriler
                                for ($k=0; $k < count($table_columns); $k++) { 
                                    $col=$table_columns[$k];
                                    $newData[$col] = $DB_Find->pluck($col)[$i];
                                }
                                //! Veriler Son
                            
                                $DB_FindInsert[] = $newData; //! Ekleme
                            }
                        }

                    }

                    //! Veri Ekleme
                    $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                    $response = array(
                        'status' => $addNewStatus ? 'success' : 'error',
                        'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

            }
            else {
    
               $response = array(
                  'status' => 'error',
                  'msg' => "uid:".__('admin.dataNotFound'),
                  'error' => null,
               );
    
               return response()->json($response);
            }
    
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' =>  __('admin.transactionFailed'),
               'error' => $th,            
            );
    
            return response()->json($response);
        }

    } //! Faq - Sıkça Sorulan Sorular - Çoklu Clone - Post Son

    //************* İletişim - Mesaj  ***************** */

    //! İletişim Mesaj
    public function ContactMessage($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "contact_message";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData
                $selectData = [];  //! Select
                $selectDataRaw = [];  //! Select - Raw
                $joinData = [];  //! Join
                $searchData = []; //! Arama
                $whereData = []; //! Where
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                
                return view('admin/web/contact/contact_message',$DB);
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! İletişim Mesaj Son

    //! İletişim Mesaj - Arama Post
    public function ContactMessageSearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('contact_message')->where('id',$request->id)->first(); //Tüm verileri çekiyor
   
            if($DB_Find) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
                  'error' => null, 
               );
   
               return response()->json($response);
            }
   
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' => __('admin.transactionFailed'),
               'DB' =>  [],
               'error' => $th,            
            );
   
            return response()->json($response);
        }

    } //! İletişim Mesaj - Arama Post Son

    //! İletişim Mesaj - Veri Ekleme Post
    public function ContactMessageAddPost(Request $request)
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

    } //! İletişim Mesaj - Veri Ekleme Post Son

    //! İletişim Mesaj - Veri Silme Post
    public function ContactMessageDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'contact_message';
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

    } //! İletişim Mesaj- Veri Silme Post Son

    //! İletişim Mesaj - Veri Çoklu Silme Post
    public function ContactMessageDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Silme
            $DB_Status = DB::table('contact_message')->whereIn('id',$request->ids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! İletişim Mesaj- Veri Çoklu Silme Post Son

    //! İletişim Mesaj - Veri Güncelleme Post
    public function ContactMessageEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB = DB::table('contact_message')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'subject' => $request->subject,
                    'message' => $request->message,
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

    } //! İletişim Mesaj - Veri Güncelleme Post Son   
    
    //! İletişim Mesaj -Clone - Post
    public function ContactMessageClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'contact_message';
            $DB = DB::table($table)->where('id',$request->id); //VeriTabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) { 
            
                //! Verileri Ayarlıyor
                unset($DB_Find->id); //! Veri Silme 
                unset($DB_Find->created_at); //! Veri Silme 
                unset($DB_Find->isUpdated); //! Veri Silme 
                unset($DB_Find->updated_at); //! Veri Silme 
                unset($DB_Find->updated_byId); //! Veri Silme 
                unset($DB_Find->isActive); //! Veri Silme 
                unset($DB_Find->isDeleted); //! Veri Silme 
                unset($DB_Find->deleted_at); //! Veri Silme 
                unset($DB_Find->deleted_byId); //! Veri Silme 

                $DB_Find->created_byId = $request->created_byId; //! Veri Güncelle
            
                //! Tanım
                $newData = array(); //! Eklenecek Veri 
                $table_columns = array_keys(json_decode(json_encode($DB_Find), true));  //! Sutun Veriler
            
                //! Veriler
                for ($i=0; $i < count($table_columns); $i++) { 
                    $col=$table_columns[$i];
                    $newData[$col] = $DB->pluck($col)[0];
                }
                //! Veriler Son

                //$newData['img_url'] = config('admin.Default_UserImgUrl');
                $newData['created_byId'] = $request->created_byId;

                //! Veri Ekleme
                $addNewId = DB::table($table)->insertGetId($newData); //! Veri Ekleme Son

                $response = array(
                    'status' => 'success',
                    'msg' => __('admin.transactionSuccessful'),
                    'error' => null, 
                    'addNewId' => $addNewId,
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

    } //! İletişim Mesaj - Clone - Post Son

    //! İletişim Mesaj - Çoklu Clone - Post
    public function ContactMessageClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $table = 'contact_message';
            $DB = DB::table($table)->whereIn('id',$request->ids);
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if( count($DB_Find) > 0 ){ 

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData;
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! İletişim Mesaj - Çoklu Clone - Post Son

    
    //************* Abone Ol ***************** */

    //! Abone Ol
    public function Subscribe($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "subscribe";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData
                $selectData = [];  //! Select
                $selectDataRaw = [];  //! Select - Raw
                $joinData = [];  //! Join

                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "Status", "table" => $table, "where" => "isActive", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                
                $whereData = []; //! Where
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                
                return view('admin/web/subscribe',$DB);
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Abone Ol Son

    //! Abone Ol - Arama Post
    public function SubscribeSearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('subscribe')->where('id',$request->id)->first(); //Tüm verileri çekiyor
   
            if($DB_Find) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
                  'error' => null, 
               );
   
               return response()->json($response);
            }
   
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' => __('admin.transactionFailed'),
               'DB' =>  [],
               'error' => $th,            
            );
   
            return response()->json($response);
        }

    } //! Abone Ol- Arama Post Son

    //! Abone Ol - Veri Ekleme Post
    public function SubscribeAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Ekleme
            DB::table('subscribe')->insert([
                'email' => $request->email,
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

    } //! Abone Ol - Veri Ekleme Post Son

    //! Abone Ol - Veri Silme Post
    public function SubscribeDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'subscribe';
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

    } //! Abone Ol- Veri Silme Post Son

    //! Abone Ol - Veri Çoklu Silme Post
    public function SubscribeDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Silme
            $DB_Status = DB::table('subscribe')->whereIn('id',$request->ids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Abone Ol - Veri Çoklu Silme Post Son

    //! Abone Ol - Veri Güncelleme Post
    public function SubscribeEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB = DB::table('subscribe')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([    
                    'email' => $request->email,
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

    } //! Abone Ol - Veri Güncelleme Post Son   
        
    //! Abone Ol - Veri Durum Güncelleme Post
    public function SubscribeEditActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $DB = DB::table('subscribe')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'isActive'=>$request->active == "true" ? true : false,
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

    } //! Abone Ol - Veri Durum Güncelleme Post Son
    
    //! Abone Ol - Çoklu Veri Durum Güncelle - Post
    public function SubscribeEditMultiActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Güncelleme
            $DB_Status = DB::table('subscribe')->whereIn('id',$request->ids)
            ->update([  
                'isActive'=>$request->active == "true" ? true : false,
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

        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );

            return response()->json($response);
        }

    } //! Abone Ol - Çoklu Veri Durum Güncelle - Post Son
       
    //! Abone Ol -Clone - Post
    public function SubscribeClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'subscribe';
            $DB = DB::table($table)->where('id',$request->id); //VeriTabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) { 
            
                //! Verileri Ayarlıyor
                unset($DB_Find->id); //! Veri Silme 
                unset($DB_Find->created_at); //! Veri Silme 
                unset($DB_Find->isUpdated); //! Veri Silme 
                unset($DB_Find->updated_at); //! Veri Silme 
                unset($DB_Find->updated_byId); //! Veri Silme 
                unset($DB_Find->isActive); //! Veri Silme 
                unset($DB_Find->isDeleted); //! Veri Silme 
                unset($DB_Find->deleted_at); //! Veri Silme 
                unset($DB_Find->deleted_byId); //! Veri Silme 

                $DB_Find->created_byId = $request->created_byId; //! Veri Güncelle
            
                //! Tanım
                $newData = array(); //! Eklenecek Veri 
                $table_columns = array_keys(json_decode(json_encode($DB_Find), true));  //! Sutun Veriler
            
                //! Veriler
                for ($i=0; $i < count($table_columns); $i++) { 
                    $col=$table_columns[$i];
                    $newData[$col] = $DB->pluck($col)[0];
                }
                //! Veriler Son

                //$newData['img_url'] = config('admin.Default_UserImgUrl');
                $newData['created_byId'] = $request->created_byId;

                //! Veri Ekleme
                $addNewId = DB::table($table)->insertGetId($newData); //! Veri Ekleme Son

                $response = array(
                    'status' => 'success',
                    'msg' => __('admin.transactionSuccessful'),
                    'error' => null, 
                    'addNewId' => $addNewId,
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

    } //! Abone Ol - Clone - Post Son

    //! Abone Ol - Çoklu Clone - Post
    public function SubscribeClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $table = 'subscribe';
            $DB = DB::table($table)->whereIn('id',$request->ids);
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if( count($DB_Find) > 0 ){ 

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData;
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Abone Ol - Çoklu Clone - Post Son

    //************* Slider ***************** */

    //! Slider
    public function SliderList($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {  

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "sliders";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData
                $selectData = [];  //! Select
                $selectDataRaw = [];  //! Select - Raw
                $joinData = [];  //! Join

                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "uid", "table" => $table, "where" => "uid", "data_item_object" => "=", "data_key_type" => "string", ); //! Eşit
                $searchData[] = array("params" => "Status", "table" => $table, "where" => "isActive", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                
                $whereData = []; //! Where
                $whereData[] = array( "table" => $table, "where" => "lang" , "data_item_object" => "=", "value" => __('admin.lang') ); //! Arama
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find; 
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                return view('admin/web/slider/sliderList',$DB); 
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Slider Son

    //! Slider - Arama Post
    public function SliderSearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('sliders')->where('id',$request->id)->first(); //Tüm verileri çekiyor
   
            if($DB_Find) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
                  'error' => null,
               );
   
               return response()->json($response);
            }
   
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' => __('admin.transactionFailed'),
               'DB' =>  [],
               'error' => $th,            
            );
   
            return response()->json($response);
        }

    } //! Slider - Arama Post Son

    //! Slider - Veri Ekleme Sayfası
    public function SliderAddView($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();
                
                //! Return
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                return view('admin/web/slider/sliderAdd',$DB); 
                
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
            
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Slider - Veri Ekleme Sayfası Son

    //! Slider - Veri Ekleme Post
    public function SliderAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //veri tabanı işlemleri
            $table = 'sliders';
            $DB = DB::table($table)->where('lang','=',$request->lang)->where('uid','=',$request->uid);
            $DB_Find = $DB->first(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if($DB_Find) {

                 //! Veri Güncelle
                 $DB_Status = $DB->update([            
                    'img_url' => $request->imgUrl,
                    'title' => $request->title,
                    'title2' => $request->title2,
                    'description' => $request->description,
                    'url' => $request->url,
                    'isUpdated'=>true,
                    'updated_at'=>Carbon::now(),
                    'updated_byId'=>$request->created_byId,
                ]);
            }
            else{

                //! Veri Ekleme
                $DB_Status = DB::table($table)->insert([
                    'lang' => $request->lang,
                    'uid' => $request->uid,
                    'img_url' => $request->imgUrl,
                    'title' => $request->title,
                    'title2' => $request->title2,
                    'description' => $request->description,
                    'url' => $request->url,
                    'created_byId'=>$request->created_byId,
                ]); //! Veri Ekleme Son

            }

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Slider - Veri Ekleme Post Son
    
    //! Slider - Veri Silme Post
    public function SliderDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'sliders';
            $DB_Find = DB::table($table)->where('uid','=',$request->uid)->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Silme
                $DB_Status = DB::table($table)->where('uid','=',$request->uid)->delete();

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

    } //! Slider - Veri Silme Post Son

    //! Slider - Veri Çoklu Silme Post
    public function SliderDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Silme
            $DB_Status = DB::table('sliders')->whereIn('uid',$request->uids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Slider - Veri Çoklu Silme Post Son

    //! Slider - Veri Güncelleme Sayfası
    public function SliderEdit($site_lang="tr",$id)
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Arama
                $table = 'sliders';
                $DB_Find_tr = DB::table($table)->where('uid',$id)->where('lang','tr')->first(); //Türkçe
                $DB_Find_en = DB::table($table)->where('uid',$id)->where('lang','en')->first(); //İngilizce
                $DB_Find_de = DB::table($table)->where('uid',$id)->where('lang','de')->first(); //Almanca

                if($DB_Find_tr) {

                    //! Return
                    $DB["CookieData"] = $CookieControl["CookieDataList"];
                    $DB["DB_Find_tr"] =  $DB_Find_tr;
                    $DB["DB_Find_en"] =  $DB_Find_en;
                    $DB["DB_Find_de"] =  $DB_Find_de;
                    //echo "<pre>"; print_r($DB); die();

                    return view('admin/web/slider/sliderEdit',$DB); 

                }
                else { return view('error404'); }
            
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
           
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Slider - Veri Güncelleme Sayfası Son

    //! Slider - Veri Güncelleme Post
    public function SliderEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //veri tabanı işlemleri
            $table = 'sliders';
            $DB = DB::table($table)->where('lang','=',$request->lang)->where('uid','=',$request->uid);
            $DB_Find = $DB->first(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if($DB_Find) {

                 //! Veri Güncelle
                 $DB_Status = $DB->update([       
                    'img_url' => $request->imgUrl, 
                    'title' => $request->title,
                    'title2' => $request->title2,
                    'description' => $request->description,
                    'url' => $request->url,
                    'isUpdated'=>true,
                    'updated_at'=>Carbon::now(),
                    'updated_byId'=>$request->updated_byId,
                ]);
            }
            else{ 

                //! Veri Ekleme
                $DB_Status = DB::table($table)->insert([
                    'lang' => $request->lang,
                    'uid' => $request->uid,
                    'img_url' => $request->imgUrl,
                    'title' => $request->title,
                    'title2' => $request->title2,
                    'description' => $request->description,
                    'url' => $request->url,
                    'created_byId'=>$request->updated_byId,
                ]); //! Veri Ekleme Son

            }

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Slider - Veri Güncelleme Post Son

    //! Slider - Veri Resim Güncelleme Post
    public function SliderEditImagePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //veri tabanı işlemleri
            $table = 'sliders';
            $DB = DB::table($table)->where('uid','=',$request->uid);
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if($DB_Find) {

                 //! Veri Güncelle
                 $DB_Status = $DB->update([       
                    'img_url' => $request->imgUrl, 
                    'isUpdated'=>true,
                    'updated_at'=>Carbon::now(),
                    'updated_byId'=>$request->updated_byId,
                ]);
            }

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Slider - Veri Güncelleme Post Son
            
    //! Slider - Veri Durum Güncelleme Post
    public function SliderEditActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $DB = DB::table('sliders')->where('uid',$request->uid); //Veri Tabanı
            $DB_Find = $DB->get(); //Tüm verileri çekiyor

            if( count($DB_Find) > 0 ) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'isActive'=>$request->active == "true" ? true : false,
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

    } //! Slider - Veri Durum Güncelleme Post Son
        
    //! Slider - Detay - Çoklu Veri Durum Güncelle - Post
    public function SliderEditMultiActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Güncelleme
            $DB_Status = DB::table('sliders')->whereIn('uid',$request->uids)
            ->update([  
                'isActive'=>$request->active == "true" ? true : false,
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

        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );

            return response()->json($response);
        }

    } //! Slider - Detay - Çoklu Veri Durum Günceleme - Post Son
    
    //!  Slider - Clone - Post
    public function SliderClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'sliders';
            $DB = DB::table($table)->where('uid',$request->uid); //VeriTabanı
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();

            if( count($DB_Find) > 0 ){  

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri
                $time = time(); //! uid

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->uid); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->uid = $time; //! Veri Güncelle
                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData; //! Ekleme
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
                    'error' => null,
                    'addNewId' => $time,
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

    } //!  Slider - Clone - Post Son

    //!  Slider - Çoklu Clone - Post
    public function SliderClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $table = 'sliders';
            $dbFind_uids = $request->uids;
            $dbFind_uids_count = count($dbFind_uids);
            //echo "sayisi: "; echo $dbFind_uids_count; die();

            if( $dbFind_uids_count > 0 ){ 
                        
                //! Veri Arama
                $DB = DB::table($table)->whereIn('uid',$dbFind_uids); //VeriTabanı
                $DB_Find = $DB->get(); //Tüm verileri çekiyor
                //echo "<pre>"; print_r($DB_Find); die();

                if( count($DB_Find) > 0 ){  

                    //! Tanım
                    $DB_FindInsert = []; //! Eklenecek Veri

                    for ($j=0; $j < $dbFind_uids_count; $j++) { 
                        $time = time()+$j; //! uid

                        for ($i=0; $i < count($DB_Find); $i++) {  
                            if( $DB_Find[$i]->uid == $dbFind_uids[$j] ) {
                                //echo $DB_Find[$i]->uid; echo " ";
                            
                                //! Veri Silme
                                unset($DB_Find[$i]->id); //! Veri Silme 
                                unset($DB_Find[$i]->uid); //! Veri Silme 
                                unset($DB_Find[$i]->created_at); //! Veri Silme 
                                unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                                unset($DB_Find[$i]->updated_at); //! Veri Silme 
                                unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                                unset($DB_Find[$i]->isActive); //! Veri Silme 
                                unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                                unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                                unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                                $DB_Find[$i]->uid = $time; //! Veri Güncelle
                                $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                                //! Yeni Data
                                $newData = array(); //! Eklenecek Veri 
                                $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                                
                                //! Veriler
                                for ($k=0; $k < count($table_columns); $k++) { 
                                    $col=$table_columns[$k];
                                    $newData[$col] = $DB_Find->pluck($col)[$i];
                                }
                                //! Veriler Son
                            
                                $DB_FindInsert[] = $newData; //! Ekleme
                            }
                        }

                    }

                    //! Veri Ekleme
                    $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                    $response = array(
                        'status' => $addNewStatus ? 'success' : 'error',
                        'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

            }
            else {
    
               $response = array(
                  'status' => 'error',
                  'msg' => "uid:".__('admin.dataNotFound'),
                  'error' => null,
               );
    
               return response()->json($response);
            }
    
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' =>  __('admin.transactionFailed'),
               'error' => $th,            
            );
    
            return response()->json($response);
        }

    } //!  Slider - Çoklu Clone - Post Son
    
    //************* Admin - Web User List  ***************** */

    //! Admin - Web User List 
    public function AdminWebUserList($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 
            
            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();
               
                //! Tanım
                $table = "web_users";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData
                
                $selectData = [];  //! Select
                $selectData[] = array( "table" => $table, "parametre" => "*", "name" => null, );

                $selectDataRaw = [];  //! Select - Raw

                $joinData = [];  //! Join
                
                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "Status", "table" => $table, "where" => "isActive", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "userId", "table" => $table, "where" => "id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "name", "table" => $table, "where" => "name", "data_item_object" => "likeBoth", "data_key_type" => "string", ); //! Başında ve Sonunda Ara
                $searchData[] = array("params" => "surname", "table" => $table, "where" => "surname", "data_item_object" => "likeBoth", "data_key_type" => "string", ); //! Başında ve Sonunda Ara
                $searchData[] = array("params" => "email", "table" => $table, "where" => "email", "data_item_object" => "likeStart", "data_key_type" => "string", ); //! Eşit
                $searchData[] = array("params" => "Role", "table" => $table, "where" => "role_id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "CreatedDate", "table" => $table, "where" => "created_at", "data_item_object" => "likeStart", "data_key_type" => "string", ); //! Başında Varsa
                $searchData[] = array("params" => "CreatedDateBottom", "table" => $table, "where" => "created_at", "data_item_object" => ">=", "data_key_type" => "date", ); //! Zaman Büyük ve Eşit
                $searchData[] = array("params" => "CreatedDateTop", "table" => $table, "where" => "created_at", "data_item_object" => "<=", "data_key_type" => "date", ); //! Zaman Küçük ve Eşit
               
                $whereData = []; //! Where
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();
                    
                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];
                //echo "<pre>"; print_r($DB); die();
                
                return view('admin/web/user/userList',$DB);
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Admin - Web User List  Son

    //! Admin - Web User - Bilgi Sayfası
    public function AdminWebUserInfoView($site_lang="tr",$id)
    {

        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Arama
                $DB_Find = DB::table('web_users')->where('id',$id)->first(); //! Kullanıcı Bilgileri
                //echo "<pre>"; print_r($DB_Find); die();
                
                if($DB_Find) {  
                
                    //! Return
                    $DB["CookieData"] = $CookieControl["CookieDataList"];
                    $DB["DB_Find"] =  $DB_Find;
                    //echo "<pre>"; print_r($DB); die();

                    return view('admin/web/user/userInfo',$DB);
                }
                else { return view('error404'); }                    
                
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
            
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Admin - Web User - Bilgi Sayfası Son

    //! Admin - Web User - Arama Post
    public function AdminWebUserSearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $DB_Find = DB::table('web_users')->where('id',$request->id)->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                $response = array(
                    'status' => 'success',
                    'msg' => __('admin.transactionSuccessful'),
                    'DB' =>  $DB_Find,
                    'error' => null
                );

                return response()->json($response);
            }

            else {

                $response = array(
                    'status' => 'error',
                    'msg' => __('admin.dataNotFound'),
                    'DB' =>  [],
                    'error' => null
                );

                return response()->json($response);
            }

        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'DB' =>  [],
                'error' => $th,            
            );

            return response()->json($response);
        }
    } //! Admin - Web User - Arama Post Son

    //! Admin - Web User - Veri Ekleme Post
    public function AdminWebUserAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Veri Arama
            $table = 'web_users';
            $DB_Find = DB::table($table)->where('email',$request->email)->first(); //Tüm verileri çekiyor

            // EmailIsUsed

            if($DB_Find) { $response = array( 'status' => 'error', 'msg' => __('admin.emailIsUsed'), 'error' => null, );  return response()->json($response); }
            else { 

                //! Veri Ekleme
                DB::table($table)->insert([
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'email' => $request->email,
                    'password' => $request->password,
                    'img_url'=> config('admin.Default_UserImgUrl'),
                    'role_id'=>$request->role,
                    'isActive'=>$request->isActive,
                    'created_byId'=>$request->created_byId,
                ]); //! Veri Ekleme Son

                
                //! Return
                $response = array( 'status' => 'success', 'msg' => __('admin.transactionSuccessful'), 'error' => null, );

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

    } //! Admin - Web User - Veri Ekleme Post Son

    //! Admin - Web User - Veri Silme Post
    public function AdminWebUserDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'web_users';
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

    } //! Admin - Web User - Veri Silme Post Son

    //! Admin - Web User - Veri Çoklu Silme Post
    public function AdminWebUserDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Silme
            $DB_Status = DB::table('web_users')->whereIn('id',$request->ids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Admin - Web User - Veri Çoklu Silme Post Son

    //! Admin - Web User - Veri Güncelleme Post
    public function AdminWebUserEditPost(Request $request)
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
                    'name'=>$request->name,
                    'surname'=>$request->surname,
                    'phone'=>$request->phone,

                    'dateofBirth'=>$request->dateofBirth,
                    'role_id'=>$request->role,

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
    } //! Admin - Web User - Veri Güncelleme Post Son

    //! Admin - Web User - Veri Güncelleme Password
    public function AdminWebUserEditPassword(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
               

                //! Veri Arama
                $DB = DB::table('web_users')->where('id',$request->id)->where('password',$request->myPassword); //Veri Tabanı
                $DB_Find = $DB->first(); //Tüm verileri çekiyor
                //echo "<pre>"; print_r($DB_Find); die();

                if($DB_Find) {

                    //! Veri Güncelle
                    $DB_Status = $DB->update([            
                        'password'=>$request->password,
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
                        'msg' => __('admin.theEmailPasswordMayBeIncorrect'),
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

    } //! Admin - Web User - Veri Güncelleme Password Son
    
    //! Admin - Web User - Veri Güncelleme Email
    public function AdminWebUserEditEmail(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

                //! Veri Arama
                $DB = DB::table('web_users')->where('id',$request->id); //Veri Tabanı
                $DB_Find = $DB->first(); //Tüm verileri çekiyor
                //echo "<pre>"; print_r($DB_Find); die();

                if($DB_Find) {

                    $DBFind_Email = DB::table('web_users')->where('email',$request->myEmail)->first(); 

                    if($DBFind_Email) {
                        $response = array(
                            'status' => 'error',
                            'msg' => __('admin.emailIsUsed'),
                            'error' => null,
                        );
            
                        return response()->json($response);
                    }
                    else {
                        
                        //! Veri Güncelle
                        $DB_Status = $DB->update([            
                            'email'=>$request->myEmail,
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

    } //! Admin - Web User - Veri Güncelleme Email Son
   
    //! Admin - Web User - Veri Güncelleme ImgUrl
    public function AdminWebUserEditImgUrl(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $DB = DB::table('web_users')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();

            if($DB_Find) { 

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'img_url'=>$request->img_url,
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

    } //! Admin - Web User - Veri Güncelleme ImgUrl Son
    
    //! Admin - Web User - Veri Durum Güncelleme Post
    public function AdminWebUserEditActive(Request $request)
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
                    'isActive'=>$request->active == "true" ? true : false,
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

    } //! Admin - Web User - Veri Durum Güncelleme Post Son

    //! Admin - Web User - Çoklu Veri Durum Güncelle - Post
    public function AdminWebUserEditMultiActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Güncelleme
            $DB_Status = DB::table('web_users')->whereIn('id',$request->ids)
            ->update([  
                'isActive'=>$request->active == "true" ? true : false,
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

        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );

            return response()->json($response);
        }

    } //! Admin - Web User - Çoklu Veri Durum Güncelle - Post Son


    //************* Admin - Web User - Sepet  ***************** */

    //! Admin - Web User - Sepet
    public function AdminWebUserCartList($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "web_user_cart";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData

                $selectData = [];  //! Select
                $selectData[] = array( "table" => $table, "parametre" => "*", "name" => null, );
                $selectData[] = array( "table" => "products", "parametre" => "title", "name" => "productTitle", );
                $selectData[] = array( "table" => "products", "parametre" => "img_url", "name" => "productsImg", );
                $selectData[] = array( "table" => "web_users", "parametre" => "name", "name" => "userName", );
                $selectData[] = array( "table" => "web_users", "parametre" => "surname", "name" => "userSurName", );

                $selectDataRaw = [];  //! Select - Raw
                
                $joinData = [];  //! Join
                $joinData[] = array( "type" => "LEFT", "table" => "products" , "value" => "uid", "refTable" => $table, "refValue" => "product_uid", ); //! Join Veri Ekleme
                $joinData[] = array( "type" => "LEFT", "table" => "web_users" , "value" => "id", "refTable" => $table, "refValue" => "user_id", ); //! Join Veri Ekleme

                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "Id", "table" => $table, "where" => "id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "userId", "table" => $table, "where" => "user_id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "productId", "table" => $table, "where" => "product_uid", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "productName", "table" => 'products', "where" => "title", "data_item_object" => "likeBoth", "data_key_type" => "string", ); //! Like

                $whereData = []; //! Where
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                
                return view('admin/web/user/userCart',$DB);
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Admin - Web User - Sepet Son

    //! Admin - Web User - Sepet - Arama Post
    public function AdminWebUserCartSearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('web_user_cart')->where('id',$request->id)->first(); //Tüm verileri çekiyor
   
            if($DB_Find) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
                  'error' => null, 
               );
   
               return response()->json($response);
            }
   
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' => __('admin.transactionFailed'),
               'DB' =>  [],
               'error' => $th,            
            );
   
            return response()->json($response);
        }

    } //! Admin - Web User - Sepet - Arama Post Son

    //! Admin - Web User - Sepet - Veri Ekleme Post
    public function AdminWebUserCartAddPost(Request $request)
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

    } //! Admin - Web User - Sepet - Veri Ekleme Post Son

    //! Admin - Web User - Sepet - Veri Silme Post
    public function AdminWebUserCartDeletePost(Request $request)
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

    } //! Admin - Web User - Sepet - Veri Silme Post Son

    //! Admin - Web User - Sepet - Veri Çoklu Silme Post
    public function AdminWebUserCartDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Silme
            $DB_Status = DB::table('web_user_cart')->whereIn('id',$request->ids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Admin - Web User - Sepet - Veri Çoklu Silme Post Son

    //! Admin - Web User - Sepet - Veri Güncelleme Post
    public function AdminWebUserCartEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB = DB::table('web_user_cart')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'user_id' => $request->user_id,
                    'product_uid' => $request->product_uid,
                    'product_quantity' => $request->product_quantity,
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

    } //! Admin - Web User - Sepet - Veri Güncelleme Post Son

    //! Admin - Web User - Sepet  -Clone - Post
    public function AdminWebUserCartClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'web_user_cart';
            $DB = DB::table($table)->where('id',$request->id); //VeriTabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) { 
            
                //! Verileri Ayarlıyor
                unset($DB_Find->id); //! Veri Silme 
                unset($DB_Find->created_at); //! Veri Silme 
                unset($DB_Find->isUpdated); //! Veri Silme 
                unset($DB_Find->updated_at); //! Veri Silme 
                unset($DB_Find->updated_byId); //! Veri Silme 
                unset($DB_Find->isActive); //! Veri Silme 
                unset($DB_Find->isDeleted); //! Veri Silme 
                unset($DB_Find->deleted_at); //! Veri Silme 
                unset($DB_Find->deleted_byId); //! Veri Silme 

                $DB_Find->created_byId = $request->created_byId; //! Veri Güncelle
            
                //! Tanım
                $newData = array(); //! Eklenecek Veri 
                $table_columns = array_keys(json_decode(json_encode($DB_Find), true));  //! Sutun Veriler
            
                //! Veriler
                for ($i=0; $i < count($table_columns); $i++) { 
                    $col=$table_columns[$i];
                    $newData[$col] = $DB->pluck($col)[0];
                }
                //! Veriler Son

                //$newData['img_url'] = config('admin.Default_UserImgUrl');
                $newData['created_byId'] = $request->created_byId;

                //! Veri Ekleme
                $addNewId = DB::table($table)->insertGetId($newData); //! Veri Ekleme Son

                $response = array(
                    'status' => 'success',
                    'msg' => __('admin.transactionSuccessful'),
                    'error' => null, 
                    'addNewId' => $addNewId,
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

    } //! Admin - Web User - Sepet  - Clone - Post Son

    //! Admin - Web User - Sepet  - Çoklu Clone - Post
    public function AdminWebUserCartClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $table = 'web_user_cart';
            $DB = DB::table($table)->whereIn('id',$request->ids);
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if( count($DB_Find) > 0 ){ 

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData;
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Admin - Web User - Sepet  - Çoklu Clone - Post Son

    //************* Admin - Web User - İstek Listesi  ***************** */

    //! Admin - Web User - İstek Listesi
    public function AdminWebUserWishList($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "web_user_wish";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData

                $selectData = [];  //! Select
                $selectData[] = array( "table" => $table, "parametre" => "*", "name" => null, );
                $selectData[] = array( "table" => "products", "parametre" => "title", "name" => "productTitle", );
                $selectData[] = array( "table" => "products", "parametre" => "img_url", "name" => "productsImg", );
                $selectData[] = array( "table" => "web_users", "parametre" => "name", "name" => "userName", );
                $selectData[] = array( "table" => "web_users", "parametre" => "surname", "name" => "userSurName", );

                $selectDataRaw = [];  //! Select - Raw
                
                $joinData = [];  //! Join
                $joinData[] = array( "type" => "LEFT", "table" => "products" , "value" => "uid", "refTable" => $table, "refValue" => "product_uid", ); //! Join Veri Ekleme
                $joinData[] = array( "type" => "LEFT", "table" => "web_users" , "value" => "id", "refTable" => $table, "refValue" => "user_id", ); //! Join Veri Ekleme

                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "Id", "table" => $table, "where" => "id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "userId", "table" => $table, "where" => "user_id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "productId", "table" => $table, "where" => "product_uid", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "productName", "table" => 'products', "where" => "title", "data_item_object" => "likeBoth", "data_key_type" => "string", ); //! Like

                $whereData = []; //! Where
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                
                return view('admin/web/user/userWish',$DB);
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Admin - Web User - İstek Listesi Son

    //! Admin - Web User - İstek Listesi - Arama Post
    public function AdminWebUserWishSearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('web_user_wish')->where('id',$request->id)->first(); //Tüm verileri çekiyor
   
            if($DB_Find) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
                  'error' => null, 
               );
   
               return response()->json($response);
            }
   
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' => __('admin.transactionFailed'),
               'DB' =>  [],
               'error' => $th,            
            );
   
            return response()->json($response);
        }

    } //! Admin - Web User - İstek Listesi - Arama Post Son

    //! Admin - Web User - İstek Listesi - Veri Ekleme Post
    public function AdminWebUserWishAddPost(Request $request)
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

    } //! Admin - Web User - İstek Listesi - Veri Ekleme Post Son

    //! Admin - Web User - İstek Listesi - Veri Silme Post
    public function AdminWebUserWishDeletePost(Request $request)
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

    } //! Admin - Web User - İstek Listesi - Veri Silme Post Son

    //! Admin - Web User - İstek Listesi - Veri Çoklu Silme Post
    public function AdminWebUserWishDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Silme
            $DB_Status = DB::table('web_user_wish')->whereIn('id',$request->ids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Admin - Web User - İstek Listesi - Veri Çoklu Silme Post Son

    //! Admin - Web User - İstek Listesi - Veri Güncelleme Post
    public function AdminWebUserWishEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB = DB::table('web_user_wish')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'user_id' => $request->user_id,
                    'product_uid' => $request->product_uid,
                    'product_quantity' => $request->product_quantity,
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

    } //! Admin - Web User - İstek Listesi - Veri Güncelleme Post Son

    //! Admin - Web User - İstek Listesi  -Clone - Post
    public function AdminWebUserWishClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'web_user_wish';
            $DB = DB::table($table)->where('id',$request->id); //VeriTabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) { 
            
                //! Verileri Ayarlıyor
                unset($DB_Find->id); //! Veri Silme 
                unset($DB_Find->created_at); //! Veri Silme 
                unset($DB_Find->isUpdated); //! Veri Silme 
                unset($DB_Find->updated_at); //! Veri Silme 
                unset($DB_Find->updated_byId); //! Veri Silme 
                unset($DB_Find->isActive); //! Veri Silme 
                unset($DB_Find->isDeleted); //! Veri Silme 
                unset($DB_Find->deleted_at); //! Veri Silme 
                unset($DB_Find->deleted_byId); //! Veri Silme 

                $DB_Find->created_byId = $request->created_byId; //! Veri Güncelle
            
                //! Tanım
                $newData = array(); //! Eklenecek Veri 
                $table_columns = array_keys(json_decode(json_encode($DB_Find), true));  //! Sutun Veriler
            
                //! Veriler
                for ($i=0; $i < count($table_columns); $i++) { 
                    $col=$table_columns[$i];
                    $newData[$col] = $DB->pluck($col)[0];
                }
                //! Veriler Son

                //$newData['img_url'] = config('admin.Default_UserImgUrl');
                $newData['created_byId'] = $request->created_byId;

                //! Veri Ekleme
                $addNewId = DB::table($table)->insertGetId($newData); //! Veri Ekleme Son

                $response = array(
                    'status' => 'success',
                    'msg' => __('admin.transactionSuccessful'),
                    'error' => null, 
                    'addNewId' => $addNewId,
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

    } //! Admin - Web User - İstek Listesi  - Clone - Post Son

    //! Admin - Web User - İstek Listesi  - Çoklu Clone - Post
    public function AdminWebUserWishClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $table = 'web_user_wish';
            $DB = DB::table($table)->whereIn('id',$request->ids);
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if( count($DB_Find) > 0 ){ 

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData;
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Admin - Web User - İstek Listesi  - Çoklu Clone - Post Son

    //************* Admin - Web User - Sipariş Listesi  ***************** */

    //! Admin - Web User - Sipariş Listesi
    public function AdminWebUserOrderList($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "web_user_order";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData

                $selectData = [];  //! Select
                $selectData[] = array( "table" => $table, "parametre" => "*", "name" => null, );
                $selectData[] = array( "table" => "products", "parametre" => "title", "name" => "productTitle", );
                $selectData[] = array( "table" => "products", "parametre" => "img_url", "name" => "productsImg", );
                $selectData[] = array( "table" => "web_users", "parametre" => "name", "name" => "userName", );
                $selectData[] = array( "table" => "web_users", "parametre" => "surname", "name" => "userSurName", );

                $selectDataRaw = [];  //! Select - Raw
                
                $joinData = [];  //! Join
                $joinData[] = array( "type" => "LEFT", "table" => "products" , "value" => "uid", "refTable" => $table, "refValue" => "product_uid", ); //! Join Veri Ekleme
                $joinData[] = array( "type" => "LEFT", "table" => "web_users" , "value" => "id", "refTable" => $table, "refValue" => "user_id", ); //! Join Veri Ekleme

                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "Id", "table" => $table, "where" => "id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "userId", "table" => $table, "where" => "user_id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "orderTitle", "table" => $table, "where" => "title", "data_item_object" => "=", "data_key_type" => "string", ); //! Eşit
                $searchData[] = array("params" => "productId", "table" => $table, "where" => "product_uid", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "productName", "table" => 'products', "where" => "title", "data_item_object" => "likeBoth", "data_key_type" => "string", ); //! Like

                $whereData = []; //! Where
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                
                return view('admin/web/user/userOrder',$DB);
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Admin - Web User - Sipariş Listesi Son

    //! Admin - Web User - Sipariş Listesi - Arama Post
    public function AdminWebUserOrderSearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('web_user_order')->where('id',$request->id)->first(); //Tüm verileri çekiyor
   
            if($DB_Find) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
                  'error' => null, 
               );
   
               return response()->json($response);
            }
   
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' => __('admin.transactionFailed'),
               'DB' =>  [],
               'error' => $th,            
            );
   
            return response()->json($response);
        }

    } //! Admin - Web User - Sipariş Listesi - Arama Post Son

    //! Admin - Web User - Sipariş Listesi - Veri Ekleme Post
    public function AdminWebUserOrderAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Ekleme
            DB::table('web_user_order')->insert([
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

    } //! Admin - Web User - Sipariş Listesi - Veri Ekleme Post Son

    //! Admin - Web User - Sipariş Listesi - Veri Silme Post
    public function AdminWebUserOrderDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'web_user_order';
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

    } //! Admin - Web User - Sipariş Listesi - Veri Silme Post Son

    //! Admin - Web User - Sipariş Listesi - Veri Çoklu Silme Post
    public function AdminWebUserOrderDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Silme
            $DB_Status = DB::table('web_user_order')->whereIn('id',$request->ids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Admin - Web User - Sipariş Listesi - Veri Çoklu Silme Post Son

    //! Admin - Web User - Sipariş Listesi - Veri Güncelleme Post
    public function AdminWebUserOrderEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB = DB::table('web_user_order')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'user_id' => $request->user_id,
                    'product_uid' => $request->product_uid,
                    'product_quantity' => $request->product_quantity,
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

    } //! Admin - Web User - Sipariş Listesi - Veri Güncelleme Post Son

    //! Admin - Web User - Sipariş Listesi  -Clone - Post
    public function AdminWebUserOrderClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'web_user_order';
            $DB = DB::table($table)->where('id',$request->id); //VeriTabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) { 
            
                //! Verileri Ayarlıyor
                unset($DB_Find->id); //! Veri Silme 
                unset($DB_Find->created_at); //! Veri Silme 
                unset($DB_Find->isUpdated); //! Veri Silme 
                unset($DB_Find->updated_at); //! Veri Silme 
                unset($DB_Find->updated_byId); //! Veri Silme 
                unset($DB_Find->isActive); //! Veri Silme 
                unset($DB_Find->isDeleted); //! Veri Silme 
                unset($DB_Find->deleted_at); //! Veri Silme 
                unset($DB_Find->deleted_byId); //! Veri Silme 

                $DB_Find->created_byId = $request->created_byId; //! Veri Güncelle
            
                //! Tanım
                $newData = array(); //! Eklenecek Veri 
                $table_columns = array_keys(json_decode(json_encode($DB_Find), true));  //! Sutun Veriler
            
                //! Veriler
                for ($i=0; $i < count($table_columns); $i++) { 
                    $col=$table_columns[$i];
                    $newData[$col] = $DB->pluck($col)[0];
                }
                //! Veriler Son

                //$newData['img_url'] = config('admin.Default_UserImgUrl');
                $newData['created_byId'] = $request->created_byId;

                //! Veri Ekleme
                $addNewId = DB::table($table)->insertGetId($newData); //! Veri Ekleme Son

                $response = array(
                    'status' => 'success',
                    'msg' => __('admin.transactionSuccessful'),
                    'error' => null, 
                    'addNewId' => $addNewId,
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

    } //! Admin - Web User - Sipariş Listesi  - Clone - Post Son

    //! Admin - Web User - Sipariş Listesi  - Çoklu Clone - Post
    public function AdminWebUserOrderClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $table = 'web_user_order';
            $DB = DB::table($table)->whereIn('id',$request->ids);
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if( count($DB_Find) > 0 ){ 

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData;
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Admin - Web User - Sipariş Listesi  - Çoklu Clone - Post Son
    
    //************* Admin - Web User - Sipariş Ürün Listesi  ***************** */

    //! Admin - Web User - Sipariş Ürün Listesi
    public function AdminWebUserOrderProductList($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "web_user_order";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                
                //! Group
                $groupData = []; //! GroupData
                $groupData[]= "product_uid"; //! Ekleme

                $selectData = [];  //! Select
                $selectData[] = array( "table" => $table, "parametre" => "*", "name" => null, );
                $selectData[] = array( "table" => "products", "parametre" => "title", "name" => "productTitle", );
                $selectData[] = array( "table" => "products", "parametre" => "img_url", "name" => "productsImg", );
                $selectData[] = array( "table" => "products", "parametre" => "floor_place", "name" => "productsFloorPlace", );
                $selectData[] = array( "table" => "products", "parametre" => "place", "name" => "productPlace", );
                
                //! Select - Raw
                $selectDataRaw = []; 
                $selectDataRaw[] = "SUM(product_quantity) AS sum_product_quantity";
                
                $joinData = [];  //! Join
                $joinData[] = array( "type" => "LEFT", "table" => "products" , "value" => "uid", "refTable" => $table, "refValue" => "product_uid", ); //! Join Veri Ekleme                

                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "Id", "table" => $table, "where" => "id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "productId", "table" => $table, "where" => "product_uid", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "productName", "table" => 'products', "where" => "title", "data_item_object" => "likeBoth", "data_key_type" => "string", ); //! Like

                $whereData = []; //! Where
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                
                return view('admin/web/user/userOrderProduct',$DB);
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Admin - Web User - Sipariş Ürün Listesi Son

    //! Admin - Web User - Sipariş Ürün Listesi - Arama Post
    public function AdminWebUserOrderProductSearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('web_user_order')->where('id',$request->id)->first(); //Tüm verileri çekiyor
   
            if($DB_Find) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
                  'error' => null, 
               );
   
               return response()->json($response);
            }
   
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' => __('admin.transactionFailed'),
               'DB' =>  [],
               'error' => $th,            
            );
   
            return response()->json($response);
        }

    } //! Admin - Web User - Sipariş Ürün Listesi - Arama Post Son

    //! Admin - Web User - Sipariş Ürün Listesi - Veri Ekleme Post
    public function AdminWebUserOrderProductAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Ekleme
            DB::table('web_user_order')->insert([
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

    } //! Admin - Web User - Sipariş Ürün Listesi - Veri Ekleme Post Son

    //! Admin - Web User - Sipariş Ürün Listesi - Veri Silme Post
    public function AdminWebUserOrderProductDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'web_user_order';
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

    } //! Admin - Web User - Sipariş Ürün Listesi - Veri Silme Post Son

    //! Admin - Web User - Sipariş Ürün Listesi - Veri Çoklu Silme Post
    public function AdminWebUserOrderProductDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Silme
            $DB_Status = DB::table('web_user_order')->whereIn('id',$request->ids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Admin - Web User - Sipariş Ürün Listesi - Veri Çoklu Silme Post Son

    //! Admin - Web User - Sipariş Ürün Listesi - Veri Güncelleme Post
    public function AdminWebUserOrderProductEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB = DB::table('web_user_order')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'user_id' => $request->user_id,
                    'product_uid' => $request->product_uid,
                    'product_quantity' => $request->product_quantity,
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

    } //! Admin - Web User - Sipariş Ürün Listesi - Veri Güncelleme Post Son

    //! Admin - Web User - Sipariş Ürün Listesi  -Clone - Post
    public function AdminWebUserOrderProductClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'web_user_order';
            $DB = DB::table($table)->where('id',$request->id); //VeriTabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) { 
            
                //! Verileri Ayarlıyor
                unset($DB_Find->id); //! Veri Silme 
                unset($DB_Find->created_at); //! Veri Silme 
                unset($DB_Find->isUpdated); //! Veri Silme 
                unset($DB_Find->updated_at); //! Veri Silme 
                unset($DB_Find->updated_byId); //! Veri Silme 
                unset($DB_Find->isActive); //! Veri Silme 
                unset($DB_Find->isDeleted); //! Veri Silme 
                unset($DB_Find->deleted_at); //! Veri Silme 
                unset($DB_Find->deleted_byId); //! Veri Silme 

                $DB_Find->created_byId = $request->created_byId; //! Veri Güncelle
            
                //! Tanım
                $newData = array(); //! Eklenecek Veri 
                $table_columns = array_keys(json_decode(json_encode($DB_Find), true));  //! Sutun Veriler
            
                //! Veriler
                for ($i=0; $i < count($table_columns); $i++) { 
                    $col=$table_columns[$i];
                    $newData[$col] = $DB->pluck($col)[0];
                }
                //! Veriler Son

                //$newData['img_url'] = config('admin.Default_UserImgUrl');
                $newData['created_byId'] = $request->created_byId;

                //! Veri Ekleme
                $addNewId = DB::table($table)->insertGetId($newData); //! Veri Ekleme Son

                $response = array(
                    'status' => 'success',
                    'msg' => __('admin.transactionSuccessful'),
                    'error' => null, 
                    'addNewId' => $addNewId,
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

    } //! Admin - Web User - Sipariş Ürün Listesi  - Clone - Post Son

    //! Admin - Web User - Sipariş Ürün Listesi  - Çoklu Clone - Post
    public function AdminWebUserOrderProductClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $table = 'web_user_order';
            $DB = DB::table($table)->whereIn('id',$request->ids);
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if( count($DB_Find) > 0 ){ 

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData;
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Admin - Web User - Sipariş Ürün Listesi  - Çoklu Clone - Post Son

        
    //************* Blog - Kategori  ***************** */

    //! Blog - Kategori
    public function BlogCategory($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "blogs_categories";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData
                $selectData = [];  //! Select
                $selectDataRaw = [];  //! Select - Raw
                $joinData = [];  //! Join

                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "uid", "table" => $table, "where" => "uid", "data_item_object" => "=", "data_key_type" => "string", ); //! Eşit
                $searchData[] = array("params" => "Status", "table" => $table, "where" => "isActive", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                
                $whereData = []; //! Where
                $whereData[] = array( "table" => $table, "where" => "lang" , "data_item_object" => "=", "value" => __('admin.lang') ); //! Arama
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                
                return view('admin/web/blog/blog_category',$DB);
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Blog - Kategori Son

    //! Blog - Kategori- Arama Post
    public function BlogCategorySearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('blogs_categories')->where('uid',$request->uid)->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
   
            if( count($DB_Find) > 0 ) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
                  'error' => null, 
               );
   
               return response()->json($response);
            }
   
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' => __('admin.transactionFailed'),
               'DB' =>  [],
               'error' => $th,            
            );
   
            return response()->json($response);
        }

    } //! Blog - Kategori - Arama Post Son

    //! Blog - Kategori - Veri Ekleme Post
    public function BlogCategoryAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            
            //! Tanım
            $tableName = 'blogs_categories'; //! Tablo Adı
            $time = time(); //! uid
            $langList = ['tr','en','de']; //! Dil
            $DB_Count = 0; //! Veri Sayısı
           
            for ($i=0; $i < count($langList) ; $i++) { 
                $lang = $langList[$i];

                if($lang == "tr"){  $title = $request->title_tr; }
                if($lang == "en"){  $title = $request->title_en; }
                if($lang == "de"){  $title = $request->title_de; }

                //! Ekleme
                if($title != "") { 
                    $DB_Count++; //! Veri Sayısı Artır

                    //! Veri Ekleme - TR
                    DB::table($tableName)->insert([
                        'lang' => $lang,
                        'uid' => $time,
                        'img_url' => $request->img_url,
                        'title' => $title,
                        'seo_url' => SEOLink($title),
                        'created_byId'=>$request->created_byId,
                    ]); //! Veri Ekleme - TR Son

                }

            }
           
            $response = array(
                'status' => $DB_Count > 0 ? 'success' : 'error',
                'msg' =>  $DB_Count > 0  ? __('admin.transactionSuccessful') : __('admin.dataNotFound'),
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

    } //! Blog - Kategori - Veri Ekleme Post Son

    //! Blog - Kategori - Veri Silme Post
    public function BlogCategoryDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'blogs_categories';
            $DB_Find = DB::table($table)->where('uid',$request->uid)->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Silme
                $DB_Status = DB::table($table)->where('uid',$request->uid)->delete();

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

    } //! Blog - Kategori - Veri Silme Post Son

    //! Blog - Kategori - Veri Çoklu Silme Post
    public function BlogCategoryDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Silme
            $DB_Status = DB::table('blogs_categories')->whereIn('uid',$request->uids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Blog - Kategori - Veri Çoklu Silme Post Son

    //! Blog - Kategori - Veri Güncelleme Post
    public function BlogCategoryEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
            
            //! Tanım
            $table = 'blogs_categories'; //! Tablo Adı
            $langList = ['tr','en','de']; //! Dil
            $DB_Count = 0; //! Veri Sayısı
            
            for ($i=0; $i < count($langList) ; $i++) { 
                $lang = $langList[$i];

                if($lang == "tr"){  $title = $request->title_tr; }
                if($lang == "en"){  $title = $request->title_en; }
                if($lang == "de"){  $title = $request->title_de; }
                
                $DB = DB::table($table)->where('lang',$lang)->where('uid',$request->uid); //Veri Tabanı
                $DB_Find = $DB->get(); //Tüm verileri çekiyor
                //echo "<pre>"; print_r($DB_Find); die();

                if( count($DB_Find) > 0 ) {  
                    $DB_Count++; //! Veri Sayısı Artır

                    //! Sil
                    if($title == "") { DB::table($table)->where('lang',$lang)->where('uid',$request->uid)->delete();  }
                    else {
                        
                        //! Veri Güncelle
                        DB::table($table)
                        ->where('lang',$lang)
                        ->where('uid',$request->uid)
                        ->update([            
                            'img_url' => $request->img_url,
                            'title' => $title,
                            'seo_url' => SEOLink($title),
                            'isUpdated'=>true,
                            'updated_at'=>Carbon::now(),
                            'updated_byId'=>$request->updated_byId,
                        ]);  //! Veri Güncelle Son

                    }
                }
                else { 
                
                    if($title != "") {

                        //! Veri Ekleme 
                        DB::table($table)->insert([
                            'lang' => $lang,
                            'uid' => $request->uid,
                            'img_url' => $request->img_url,
                            'title' => $title,
                            'seo_url' => SEOLink($title),
                            'created_byId'=>$request->created_byId,
                        ]); //! Veri Ekleme Son
                    }

                }
            }
            
            $response = array(
                'status' => $DB_Count > 0 ? 'success' : 'error',
                'msg' =>  $DB_Count > 0  ? __('admin.transactionSuccessful') : __('admin.dataNotFound'),
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

    } //! Blog - Kategori - Veri Güncelleme Post Son 
            
    //! Blog - Kategori - Veri Durum Güncelleme Post
    public function BlogCategoryEditActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $DB = DB::table('blogs_categories')->where('uid',$request->uid); //Veri Tabanı
            $DB_Find = $DB->get(); //Tüm verileri çekiyor

            if( count($DB_Find) > 0 ) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'isActive'=>$request->active == "true" ? true : false,
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

    } //! Blog - Kategori - Veri Durum Güncelleme Post Son

    //! Blog - Kategori  - Çoklu Veri Durum Güncelle - Post
    public function BlogCategoryEditMultiActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Güncelleme
            $DB_Status = DB::table('blogs_categories')->whereIn('uid',$request->uids)
            ->update([  
                'isActive'=>$request->active == "true" ? true : false,
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

        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );

            return response()->json($response);
        }

    } //! Blog - Kategori- Çoklu Veri Durum Günceleme - Post Son

    //!  Blog - Kategori - Clone - Post
    public function BlogCategoryClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'blogs_categories';
            $DB = DB::table($table)->where('uid',$request->uid); //VeriTabanı
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();

            if( count($DB_Find) > 0 ){  

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri
                $time = time(); //! uid

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->uid); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->uid = $time; //! Veri Güncelle
                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData; //! Ekleme
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
                    'error' => null,
                    'addNewId' => $time,
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

    } //!  Blog - Kategori - Clone - Post Son

    //!  Blog - Kategori - Çoklu Clone - Post
    public function BlogCategoryClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $table = 'blogs_categories';
            $dbFind_uids = $request->uids;
            $dbFind_uids_count = count($dbFind_uids);
            //echo "sayisi: "; echo $dbFind_uids_count; die();

            if( $dbFind_uids_count > 0 ){ 
                        
                //! Veri Arama
                $DB = DB::table($table)->whereIn('uid',$dbFind_uids); //VeriTabanı
                $DB_Find = $DB->get(); //Tüm verileri çekiyor
                //echo "<pre>"; print_r($DB_Find); die();

                if( count($DB_Find) > 0 ){  

                    //! Tanım
                    $DB_FindInsert = []; //! Eklenecek Veri

                    for ($j=0; $j < $dbFind_uids_count; $j++) { 
                        $time = time()+$j; //! uid

                        for ($i=0; $i < count($DB_Find); $i++) {  
                            if( $DB_Find[$i]->uid == $dbFind_uids[$j] ) {
                                //echo $DB_Find[$i]->uid; echo " ";
                            
                                //! Veri Silme
                                unset($DB_Find[$i]->id); //! Veri Silme 
                                unset($DB_Find[$i]->uid); //! Veri Silme 
                                unset($DB_Find[$i]->created_at); //! Veri Silme 
                                unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                                unset($DB_Find[$i]->updated_at); //! Veri Silme 
                                unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                                unset($DB_Find[$i]->isActive); //! Veri Silme 
                                unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                                unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                                unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                                $DB_Find[$i]->uid = $time; //! Veri Güncelle
                                $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                                //! Yeni Data
                                $newData = array(); //! Eklenecek Veri 
                                $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                                
                                //! Veriler
                                for ($k=0; $k < count($table_columns); $k++) { 
                                    $col=$table_columns[$k];
                                    $newData[$col] = $DB_Find->pluck($col)[$i];
                                }
                                //! Veriler Son
                            
                                $DB_FindInsert[] = $newData; //! Ekleme
                            }
                        }

                    }

                    //! Veri Ekleme
                    $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                    $response = array(
                        'status' => $addNewStatus ? 'success' : 'error',
                        'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

            }
            else {
    
               $response = array(
                  'status' => 'error',
                  'msg' => "uid:".__('admin.dataNotFound'),
                  'error' => null,
               );
    
               return response()->json($response);
            }
    
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' =>  __('admin.transactionFailed'),
               'error' => $th,            
            );
    
            return response()->json($response);
        }

    } //!  Blog - Kategori - Çoklu Clone - Post Son
    
    //************* Blog ***************** */

    //! Blog
    public function BlogList($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {  

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "blogs";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData
               
                //! Select
                $selectData = [];
                $selectData[] = array( "table" => $table, "parametre" => "*", "name" => null, );//! Join Veri Ekleme
                $selectData[] = array( "table" => "blogs_categories", "parametre" => "title", "name" => "blogs_categories_title", );

                $selectDataRaw = [];  //! Select - Raw
                
                //! Join
                $joinData = [];
                $joinData[] = array( "type" => "LEFT", "table" => "blogs_categories" , "value" => "uid", "refTable" => $table, "refValue" => "category", ); //! Join Veri Ekleme

                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "uid", "table" => $table, "where" => "uid", "data_item_object" => "=", "data_key_type" => "string", ); //! Eşit
                $searchData[] = array("params" => "Category", "table" => $table, "where" => "category", "data_item_object" => "=", "data_key_type" => "string", ); //! Eşit
                
                $whereData = []; //! Where
                $whereData[] = array( "table" => $table, "where" => "lang" , "data_item_object" => "=", "value" => __('admin.lang') ); //! Arama
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find; 
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //! Blog Category
                $DB_blogs_categories= DB::table('blogs_categories')
                ->orderBy('blogs_categories.uid','desc')
                ->where('blogs_categories.lang','=',__('admin.lang'))
                ->where('blogs_categories.isActive','=',1)->get();
                //echo "<pre>"; print_r($DB_blogs_categories); die();

                //! Return
                $DB["DB_blogs_categories"] =  $DB_blogs_categories;
                //! Blog Category Son

                //echo "<pre>"; print_r($DB); die();
                return view('admin/web/blog/blogList',$DB); 
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Blog Son

    //! Blog- Arama Post
    public function BlogSearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('blogs')->where('id',$request->id)->first(); //Tüm verileri çekiyor
   
            if($DB_Find) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
                  'error' => null,
               );
   
               return response()->json($response);
            }
   
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' => __('admin.transactionFailed'),
               'DB' =>  [],
               'error' => $th,            
            );
   
            return response()->json($response);
        }

    } //! Blog- Arama Post Son

    //! Blog - Veri Ekleme Sayfası
    public function BlogAddView($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Blog Category
                $DB_Find_blogs_categories= DB::table('blogs_categories')->where('lang','=',__('admin.lang'))->get();
                //echo "<pre>"; print_r($DB_blogs_categories); die();
                
                //! Return
                $DB["CookieData"] = $CookieControl["CookieDataList"];
                $DB["DB_Find_blogs_categories"] = $DB_Find_blogs_categories;

                //echo "<pre>"; print_r($DB); die();
                return view('admin/web/blog/blogListAdd',$DB); 
                
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
            
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Blog - Veri Ekleme Sayfası Son

    //! Blog- Veri Ekleme Post
    public function BlogAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //veri tabanı işlemleri
            $table = 'blogs';
            $DB = DB::table($table)->where('lang','=',$request->lang)->where('uid','=',$request->uid);
            $DB_Find = $DB->first(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if($DB_Find) {

                 //! Veri Güncelle
                 $DB_Status = $DB->update([            
                    'img_url' => $request->imgUrl,
                    'category' => $request->category,
                    'title' => $request->title,
                    'seo_url' => SEOLink($request->title),
                    'description' => $request->description,
                    'seo_keywords' => $request->seo_keywords,
                    'isUpdated'=>true,
                    'updated_at'=>Carbon::now(),
                    'updated_byId'=>$request->created_byId,
                ]);
            }
            else{

                //! Veri Ekleme
                $DB_Status = DB::table($table)->insert([
                    'lang' => $request->lang,
                    'uid' => $request->uid,
                    'img_url' => $request->imgUrl,
                    'category' => $request->category,
                    'title' => $request->title,
                    'seo_url' => SEOLink($request->title),
                    'description' => $request->description,
                    'seo_keywords' => $request->seo_keywords,
                    'created_byId'=>$request->created_byId,
                ]); //! Veri Ekleme Son

            }

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Blog- Veri Ekleme Post Son
    
    //! Blog- Veri Silme Post
    public function BlogDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'blogs';
            $DB_Find = DB::table($table)->where('uid','=',$request->uid)->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Silme
                $DB_Status = DB::table($table)->where('uid','=',$request->uid)->delete();

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

    } //! Blog- Veri Silme Post Son

    //! Blog- Veri Çoklu Silme Post
    public function BlogDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Silme
            $DB_Status = DB::table('blogs')->whereIn('uid',$request->uids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Blog - Veri Çoklu Silme Post Son

    //! Blog - Veri Güncelleme Sayfası
    public function BlogEdit($site_lang="tr",$id)
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Arama
                $table = 'blogs';
                $DB_Find_tr = DB::table($table)->where('uid',$id)->where('lang','tr')->first(); //Türkçe
                $DB_Find_en = DB::table($table)->where('uid',$id)->where('lang','en')->first(); //İngilizce
                $DB_Find_de = DB::table($table)->where('uid',$id)->where('lang','de')->first(); //Almanca

                if($DB_Find_tr) {

                    //! Blog Kategori
                    $DB_Find_blogs_categories = DB::table('blogs_categories')->get(); 
                    //echo "<pre>"; print_r($DB_Find_blogs_categories); die();
                    $DB["DB_Find_blogs_categories"] = $DB_Find_blogs_categories;
                    //! Blog Kategori Son
                    
                    //! Return
                    $DB["CookieData"] = $CookieControl["CookieDataList"];
                    $DB["DB_Find_tr"] =  $DB_Find_tr;
                    $DB["DB_Find_en"] =  $DB_Find_en;
                    $DB["DB_Find_de"] =  $DB_Find_de;

                    return view('admin/web/blog/blogListEdit',$DB); 

                }
                else { return view('error404'); }
            
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
           
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Blog - Veri Güncelleme Sayfası Son

    //! Blog- Veri Güncelleme Post
    public function BlogEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //veri tabanı işlemleri
            $table = 'blogs';
            $DB = DB::table($table)->where('lang','=',$request->lang)->where('uid','=',$request->uid);
            $DB_Find = $DB->first(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if($DB_Find) {

                 //! Veri Güncelle
                 $DB_Status = $DB->update([       
                    'img_url' => $request->imgUrl, 
                    'category' => $request->category,    
                    'title' => $request->title,
                    'seo_url' => SEOLink($request->title),
                    'description' => $request->description,
                    'seo_keywords' => $request->seo_keywords,
                    'isUpdated'=>true,
                    'updated_at'=>Carbon::now(),
                    'updated_byId'=>$request->updated_byId,
                ]);
            }
            else{ 

                //! Veri Ekleme
                $DB_Status = DB::table($table)->insert([
                    'lang' => $request->lang,
                    'uid' => $request->uid,
                    'img_url' => $request->imgUrl,
                    'category' => $request->category,
                    'title' => $request->title,
                    'seo_url' => SEOLink($request->title),
                    'description' => $request->description,
                    'seo_keywords' => $request->seo_keywords,
                    'created_byId'=>$request->updated_byId,
                ]); //! Veri Ekleme Son

            }

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Blog- Veri Güncelleme Post Son

    //! Blog - Veri Bilgileri Güncelleme Post
    public function BlogEditInfoPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //veri tabanı işlemleri
            $table = 'blogs';
            $DB = DB::table($table)->where('uid','=',$request->uid);
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if($DB_Find) {

                 //! Veri Güncelle
                 $DB_Status = $DB->update([       
                    'img_url' => $request->imgUrl, 
                    'category' => $request->category, 
                    'isUpdated'=>true,
                    'updated_at'=>Carbon::now(),
                    'updated_byId'=>$request->updated_byId,
                ]);
            }

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Blog - Veri Bilgileri Güncelleme Post Son
            
    //! Blog - Veri Durum Güncelleme Post
    public function BlogEditActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $DB = DB::table('blogs')->where('uid',$request->uid); //Veri Tabanı
            $DB_Find = $DB->get(); //Tüm verileri çekiyor

            if( count($DB_Find) > 0 ) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'isActive'=>$request->active == "true" ? true : false,
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

    } //! Blog - Veri Durum Güncelleme Post Son
        
    //! Blog  - Çoklu Veri Durum Güncelle - Post
    public function BlogEditMultiActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Güncelleme
            $DB_Status = DB::table('blogs')->whereIn('uid',$request->uids)
            ->update([  
                'isActive'=>$request->active == "true" ? true : false,
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

        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );

            return response()->json($response);
        }

    } //! Blog  - Çoklu Veri Durum Günceleme - Post Son

    //!  Blog - Clone - Post
    public function BlogClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'blogs';
            $DB = DB::table($table)->where('uid',$request->uid); //VeriTabanı
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();

            if( count($DB_Find) > 0 ){  

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri
                $time = time(); //! uid

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->uid); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->uid = $time; //! Veri Güncelle
                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData; //! Ekleme
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
                    'error' => null,
                    'addNewId' => $time,
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

    } //!  Blog - Clone - Post Son

    //!  Blog - Çoklu Clone - Post
    public function BlogClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $table = 'blogs';
            $dbFind_uids = $request->uids;
            $dbFind_uids_count = count($dbFind_uids);
            //echo "sayisi: "; echo $dbFind_uids_count; die();

            if( $dbFind_uids_count > 0 ){ 
                        
                //! Veri Arama
                $DB = DB::table($table)->whereIn('uid',$dbFind_uids); //VeriTabanı
                $DB_Find = $DB->get(); //Tüm verileri çekiyor
                //echo "<pre>"; print_r($DB_Find); die();

                if( count($DB_Find) > 0 ){  

                    //! Tanım
                    $DB_FindInsert = []; //! Eklenecek Veri

                    for ($j=0; $j < $dbFind_uids_count; $j++) { 
                        $time = time()+$j; //! uid

                        for ($i=0; $i < count($DB_Find); $i++) {  
                            if( $DB_Find[$i]->uid == $dbFind_uids[$j] ) {
                                //echo $DB_Find[$i]->uid; echo " ";
                            
                                //! Veri Silme
                                unset($DB_Find[$i]->id); //! Veri Silme 
                                unset($DB_Find[$i]->uid); //! Veri Silme 
                                unset($DB_Find[$i]->created_at); //! Veri Silme 
                                unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                                unset($DB_Find[$i]->updated_at); //! Veri Silme 
                                unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                                unset($DB_Find[$i]->isActive); //! Veri Silme 
                                unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                                unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                                unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                                $DB_Find[$i]->uid = $time; //! Veri Güncelle
                                $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                                //! Yeni Data
                                $newData = array(); //! Eklenecek Veri 
                                $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                                
                                //! Veriler
                                for ($k=0; $k < count($table_columns); $k++) { 
                                    $col=$table_columns[$k];
                                    $newData[$col] = $DB_Find->pluck($col)[$i];
                                }
                                //! Veriler Son
                            
                                $DB_FindInsert[] = $newData; //! Ekleme
                            }
                        }

                    }

                    //! Veri Ekleme
                    $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                    $response = array(
                        'status' => $addNewStatus ? 'success' : 'error',
                        'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

            }
            else {
    
               $response = array(
                  'status' => 'error',
                  'msg' => "uid:".__('admin.dataNotFound'),
                  'error' => null,
               );
    
               return response()->json($response);
            }
    
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' =>  __('admin.transactionFailed'),
               'error' => $th,            
            );
    
            return response()->json($response);
        }

    } //!  Blog - Çoklu Clone - Post Son
        
    //************* Blog - Yorum  ***************** */

    //! Blog - Yorum
    public function BlogComment($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "blogs_comment";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData
                $selectData = [];  //! Select
                $selectDataRaw = [];  //! Select - Raw
                $joinData = [];  //! Join

                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "Status", "table" => $table, "where" => "isActive", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                
                $whereData = []; //! Where
                //$whereData[] = array( "table" => $table, "where" => "created_byId" , "data_item_object" => "=", "value" => 26 ); //! Arama
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                
                return view('admin/web/blog/blog_comment',$DB);
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Blog - Yorum Son

    //! Blog - Yorum- Arama Post
    public function BlogCommentSearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('blogs_comment')->where('id',$request->id)->first(); //Tüm verileri çekiyor
   
            if($DB_Find) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
                  'error' => null, 
               );
   
               return response()->json($response);
            }
   
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' => __('admin.transactionFailed'),
               'DB' =>  [],
               'error' => $th,            
            );
   
            return response()->json($response);
        }

    } //! Blog - Yorum - Arama Post Son

    //! Blog - Yorum - Veri Ekleme Post
    public function BlogCommentAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Ekleme
            DB::table('blogs_comment')->insert([
                'userid' => $request->userid,
                'lang' => $request->lang,
                'blog_uid' => $request->blog_uid,
                'comment' => $request->comment,
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

    } //! Blog - Yorum - Veri Ekleme Post Son

    //! Blog - Yorum - Veri Silme Post
    public function BlogCommentDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'blogs_comment';
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

    } //! Blog - Yorum - Veri Silme Post Son

    //! Blog - Yorum - Veri Çoklu Silme Post
    public function BlogCommentDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Silme
            $DB_Status = DB::table('blogs_comment')->whereIn('id',$request->ids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Blog - Yorum - Veri Çoklu Silme Post Son

    //! Blog - Yorum - Veri Güncelleme Post
    public function BlogCommentEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB = DB::table('blogs_comment')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'userid' => $request->userid,
                    'lang' => $request->lang,
                    'blog_uid' => $request->blog_uid,
                    'comment' => $request->comment,
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

    } //! Blog - Yorum - Veri Güncelleme Post Son
        
    //! Blog - Yorum - Veri Durum Güncelleme Post
    public function BlogCommentEditActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $DB = DB::table('blogs_comment')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'isActive'=>$request->active == "true" ? true : false,
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

    } //! Blog - Yorum - Veri Durum Güncelleme Post Son
    
    //! Blog - Yorum - Çoklu Veri Durum Güncelle - Post
    public function BlogCommentEditMultiActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Güncelleme
            $DB_Status = DB::table('blogs_comment')->whereIn('id',$request->ids)
            ->update([  
                'isActive'=>$request->active == "true" ? true : false,
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

        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );

            return response()->json($response);
        }

    } //! Blog - Yorum - Çoklu Veri Durum Güncelle - Post Son
    
    //! Blog - Yorum - Clone - Post
    public function BlogCommentClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'blogs_comment';
            $DB = DB::table($table)->where('id',$request->id); //VeriTabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) { 
            
                //! Verileri Ayarlıyor
                unset($DB_Find->id); //! Veri Silme 
                unset($DB_Find->created_at); //! Veri Silme 
                unset($DB_Find->isUpdated); //! Veri Silme 
                unset($DB_Find->updated_at); //! Veri Silme 
                unset($DB_Find->updated_byId); //! Veri Silme 
                unset($DB_Find->isActive); //! Veri Silme 
                unset($DB_Find->isDeleted); //! Veri Silme 
                unset($DB_Find->deleted_at); //! Veri Silme 
                unset($DB_Find->deleted_byId); //! Veri Silme 

                $DB_Find->created_byId = $request->created_byId; //! Veri Güncelle
            
                //! Tanım
                $newData = array(); //! Eklenecek Veri 
                $table_columns = array_keys(json_decode(json_encode($DB_Find), true));  //! Sutun Veriler
            
                //! Veriler
                for ($i=0; $i < count($table_columns); $i++) { 
                    $col=$table_columns[$i];
                    $newData[$col] = $DB->pluck($col)[0];
                }
                //! Veriler Son

                //$newData['img_url'] = config('admin.Default_UserImgUrl');
                $newData['created_byId'] = $request->created_byId;

                //! Veri Ekleme
                $addNewId = DB::table($table)->insertGetId($newData); //! Veri Ekleme Son

                $response = array(
                    'status' => 'success',
                    'msg' => __('admin.transactionSuccessful'),
                    'error' => null, 
                    'addNewId' => $addNewId,
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

    } //! Blog - Yorum - Clone - Post Son

    //! Blog - Yorum - Çoklu Clone - Post
    public function BlogCommentClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $table = 'blogs_comment';
            $DB = DB::table($table)->whereIn('id',$request->ids);
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if( count($DB_Find) > 0 ){ 

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData;
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Blog - Yorum - Çoklu Clone - Post Son
    
    //************* Product - Kategori  ***************** */

    //! Product - Kategori
    public function ProductCategory($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "product_categories";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData
                $selectData = [];  //! Select
                $selectDataRaw = [];  //! Select - Raw
                $joinData = [];  //! Join

                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "uid", "table" => $table, "where" => "uid", "data_item_object" => "=", "data_key_type" => "string", ); //! Eşit
                $searchData[] = array("params" => "Status", "table" => $table, "where" => "isActive", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                
                $whereData = []; //! Where
                $whereData[] = array( "table" => $table, "where" => "lang" , "data_item_object" => "=", "value" => __('admin.lang') ); //! Arama
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                
                return view('admin/web/product/product_category',$DB);
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Product - Kategori Son

    //! Product - Kategori- Arama Post
    public function ProductCategorySearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('product_categories')->where('uid',$request->uid)->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
   
            if( count($DB_Find) > 0 ) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
                  'error' => null, 
               );
   
               return response()->json($response);
            }
   
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' => __('admin.transactionFailed'),
               'DB' =>  [],
               'error' => $th,            
            );
   
            return response()->json($response);
        }

    } //! Product - Kategori - Arama Post Son

    //! Product - Kategori - Veri Ekleme Post
    public function ProductCategoryAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
            
            //! Tanım
            $tableName = 'product_categories'; //! Tablo Adı
            $time = time(); //! uid
            $langList = ['tr','en','de']; //! Dil
            $DB_Count = 0; //! Veri Sayısı
           
            for ($i=0; $i < count($langList) ; $i++) { 
                $lang = $langList[$i];

                if($lang == "tr"){  $title = $request->title_tr; }
                if($lang == "en"){  $title = $request->title_en; }
                if($lang == "de"){  $title = $request->title_de; }

                //! Ekleme
                if($title != "") { 
                    $DB_Count++; //! Veri Sayısı Artır

                    //! Veri Ekleme - TR
                    DB::table($tableName)->insert([
                        'lang' => $lang,
                        'uid' => $time,
                        'img_url' => $request->img_url,
                        'title' => $title,
                        'seo_url' => SEOLink($title),
                        'created_byId'=>$request->created_byId,
                    ]); //! Veri Ekleme - TR Son

                }

            }
           
            $response = array(
                'status' => $DB_Count > 0 ? 'success' : 'error',
                'msg' =>  $DB_Count > 0  ? __('admin.transactionSuccessful') : __('admin.dataNotFound'),
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

    } //! Product - Kategori - Veri Ekleme Post Son

    //! Product - Kategori - Veri Silme Post
    public function ProductCategoryDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'product_categories';
            $DB_Find = DB::table($table)->where('uid',$request->uid)->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Silme
                $DB_Status = DB::table($table)->where('uid',$request->uid)->delete();

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

    } //! Product - Kategori - Veri Silme Post Son

    //! Product - Kategori - Veri Çoklu Silme Post
    public function ProductCategoryDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Silme
            $DB_Status = DB::table('product_categories')->whereIn('uid',$request->uids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Product - Kategori - Veri Çoklu Silme Post Son

    //! Product - Kategori - Veri Güncelleme Post
    public function ProductCategoryEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
            
            //! Tanım
            $table = 'product_categories'; //! Tablo Adı
            $langList = ['tr','en','de']; //! Dil
            $DB_Count = 0; //! Veri Sayısı
            
            for ($i=0; $i < count($langList) ; $i++) { 
                $lang = $langList[$i];

                if($lang == "tr"){  $title = $request->title_tr; }
                if($lang == "en"){  $title = $request->title_en; }
                if($lang == "de"){  $title = $request->title_de; }
                
                $DB = DB::table($table)->where('lang',$lang)->where('uid',$request->uid); //Veri Tabanı
                $DB_Find = $DB->get(); //Tüm verileri çekiyor
                //echo "<pre>"; print_r($DB_Find); die();

                if( count($DB_Find) > 0 ) {  
                    $DB_Count++; //! Veri Sayısı Artır

                    //! Sil
                    if($title == "") { DB::table($table)->where('lang',$lang)->where('uid',$request->uid)->delete();  }
                    else {
                        
                        //! Veri Güncelle
                        DB::table($table)
                        ->where('lang',$lang)
                        ->where('uid',$request->uid)
                        ->update([            
                            'img_url' => $request->img_url,
                            'title' => $title,
                            'seo_url' => SEOLink($title),
                            'isUpdated'=>true,
                            'updated_at'=>Carbon::now(),
                            'updated_byId'=>$request->updated_byId,
                        ]);  //! Veri Güncelle Son

                    }
                }
                else { 
                
                    if($title != "") {

                        //! Veri Ekleme 
                        DB::table($table)->insert([
                            'lang' => $lang,
                            'uid' => $request->uid,
                            'img_url' => $request->img_url,
                            'title' => $title,
                            'seo_url' => SEOLink($title),
                            'created_byId'=>$request->created_byId,
                        ]); //! Veri Ekleme Son
                    }

                }
            }
            
            $response = array(
                'status' => $DB_Count > 0 ? 'success' : 'error',
                'msg' =>  $DB_Count > 0  ? __('admin.transactionSuccessful') : __('admin.dataNotFound'),
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

    } //! Product - Kategori - Veri Güncelleme Post Son 
            
    //! Product - Kategori  - Veri Durum Güncelleme Post
    public function ProductCategoryEditActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $DB = DB::table('product_categories')->where('uid',$request->uid); //Veri Tabanı
            $DB_Find = $DB->get(); //Tüm verileri çekiyor

            if( count($DB_Find) > 0 ) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'isActive'=>$request->active == "true" ? true : false,
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

    } //! Product - Kategori  - Veri Durum Güncelleme Post Son
        
    //! Product - Kategori   - Çoklu Veri Durum Güncelle - Post
    public function ProductCategoryEditMultiActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Güncelleme
            $DB_Status = DB::table('product_categories')->whereIn('uid',$request->uids)
            ->update([  
                'isActive'=>$request->active == "true" ? true : false,
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

        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );

            return response()->json($response);
        }

    } //! Product - Kategori   - Çoklu Veri Durum Günceleme - Post Son

    //!  Product - Kategori - Clone - Post
    public function ProductCategoryClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'product_categories';
            $DB = DB::table($table)->where('uid',$request->uid); //VeriTabanı
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();

            if( count($DB_Find) > 0 ){  

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri
                $time = time(); //! uid

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->uid); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->uid = $time; //! Veri Güncelle
                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData; //! Ekleme
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
                    'error' => null,
                    'addNewId' => $time,
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

    } //!  Product - Kategori - Clone - Post Son

    //!  Product - Kategori - Çoklu Clone - Post
    public function ProductCategoryClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $table = 'product_categories';
            $dbFind_uids = $request->uids;
            $dbFind_uids_count = count($dbFind_uids);
            //echo "sayisi: "; echo $dbFind_uids_count; die();

            if( $dbFind_uids_count > 0 ){ 
                        
                //! Veri Arama
                $DB = DB::table($table)->whereIn('uid',$dbFind_uids); //VeriTabanı
                $DB_Find = $DB->get(); //Tüm verileri çekiyor
                //echo "<pre>"; print_r($DB_Find); die();

                if( count($DB_Find) > 0 ){  

                    //! Tanım
                    $DB_FindInsert = []; //! Eklenecek Veri

                    for ($j=0; $j < $dbFind_uids_count; $j++) { 
                        $time = time()+$j; //! uid

                        for ($i=0; $i < count($DB_Find); $i++) {  
                            if( $DB_Find[$i]->uid == $dbFind_uids[$j] ) {
                                //echo $DB_Find[$i]->uid; echo " ";
                            
                                //! Veri Silme
                                unset($DB_Find[$i]->id); //! Veri Silme 
                                unset($DB_Find[$i]->uid); //! Veri Silme 
                                unset($DB_Find[$i]->created_at); //! Veri Silme 
                                unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                                unset($DB_Find[$i]->updated_at); //! Veri Silme 
                                unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                                unset($DB_Find[$i]->isActive); //! Veri Silme 
                                unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                                unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                                unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                                $DB_Find[$i]->uid = $time; //! Veri Güncelle
                                $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                                //! Yeni Data
                                $newData = array(); //! Eklenecek Veri 
                                $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                                
                                //! Veriler
                                for ($k=0; $k < count($table_columns); $k++) { 
                                    $col=$table_columns[$k];
                                    $newData[$col] = $DB_Find->pluck($col)[$i];
                                }
                                //! Veriler Son
                            
                                $DB_FindInsert[] = $newData; //! Ekleme
                            }
                        }

                    }

                    //! Veri Ekleme
                    $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                    $response = array(
                        'status' => $addNewStatus ? 'success' : 'error',
                        'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

            }
            else {
    
               $response = array(
                  'status' => 'error',
                  'msg' => "uid:".__('admin.dataNotFound'),
                  'error' => null,
               );
    
               return response()->json($response);
            }
    
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' =>  __('admin.transactionFailed'),
               'error' => $th,            
            );
    
            return response()->json($response);
        }

    } //!  Product - Kategori - Çoklu Clone - Post Son

    //************* Product ***************** */

    //! Product
    public function ProductList($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {  

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "products";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData
                
                //! Select
                $selectData = [];
                $selectData[] = array( "table" => $table, "parametre" => "*", "name" => null, );
                $selectData[] = array( "table" => "product_categories", "parametre" => "title", "name" => "productCategoryTitle", );

                $selectDataRaw = [];  //! Select - Raw

                //! Join
                $joinData = [];  //! Join
                $joinData[] = array( "type" => "LEFT", "table" => "product_categories" , "value" => "uid", "refTable" => $table, "refValue" => "category", ); //! Join Veri Ekleme

                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "uid", "table" => $table, "where" => "uid", "data_item_object" => "=", "data_key_type" => "string", ); //! Eşit
                $searchData[] = array("params" => "Status", "table" => $table, "where" => "isActive", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "Category", "table" => $table, "where" => "category", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "productName", "table" => $table, "where" => "title", "data_item_object" => "likeBoth", "data_key_type" => "string", ); //! Eşit
                $searchData[] = array("params" => "productFloor", "table" => $table, "where" => "floor_place", "data_item_object" => "=", "data_key_type" => "string", ); //! Eşit


                $whereData = []; //! Where
                $whereData[] = array( "table" => $table, "where" => "lang" , "data_item_object" => "=", "value" => __('admin.lang') ); //! Arama
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find; 
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                
                //! Blog Category
                $DB_product_categories= DB::table('product_categories')
                ->orderBy('product_categories.uid','desc')
                ->where('product_categories.lang','=',__('admin.lang'))
                ->where('product_categories.isActive','=',1)->get();
                //echo "<pre>"; print_r($DB_product_categories); die();

                //! Return
                $DB["DB_product_categories"] =  $DB_product_categories;
                //! Blog Category Son

                //echo "<pre>"; print_r($DB); die();
                return view('admin/web/product/productList',$DB); 
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Product Son

    //! Product- Arama Post
    public function ProductSearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('products')->where('id',$request->id)->first(); //Tüm verileri çekiyor
   
            if($DB_Find) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
                  'error' => null,
               );
   
               return response()->json($response);
            }
   
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' => __('admin.transactionFailed'),
               'DB' =>  [],
               'error' => $th,            
            );
   
            return response()->json($response);
        }

    } //! Product- Arama Post Son

    //! Product - Veri Ekleme Sayfası
    public function ProductAddView($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Ürün Kategori
                $DB_Find_product_categories= DB::table('product_categories')->where('lang','=',__('admin.lang'))->get();
                //echo "<pre>"; print_r($DB_Find_product_categories); die();
                
                $DB["DB_Find_product_categories"] = $DB_Find_product_categories;
                //! Ürün Kategori Son
                
                //! Return
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                return view('admin/web/product/productListAdd',$DB); 
                
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
            
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Product - Veri Ekleme Sayfası Son

    //! Product- Veri Ekleme Post
    public function ProductAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //veri tabanı işlemleri
            $table = 'products';
            $DB = DB::table($table)->where('lang','=',$request->lang)->where('uid','=',$request->uid);
            $DB_Find = $DB->first(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if($DB_Find) {

                 //! Veri Güncelle
                 $DB_Status = $DB->update([            
                    'img_url' => $request->imgUrl,
                    'category' => $request->category,
                    'title' => $request->title,
                    'seo_url' => SEOLink($request->title),
                    'description' => $request->description,
                    'seo_keywords' => $request->seo_keywords,

                    'stock' => $request->stock,
                    'currency' => $request->currency,
                    'sale_price' => $request->sale_price,                    
                    'discounted_price_percent' => $request->discounted_price_percent,
                    'discounted_price' => $request->discounted_price,

                    'floor_place' => $request->floor_place,
                    'place' => $request->place,

                    'new_product' => $request->new_product,
                    'editor_suggestion' => $request->editor_suggestion,
                    'bestseller' => $request->bestseller,

                    'isUpdated'=>true,
                    'updated_at'=>Carbon::now(),
                    'updated_byId'=>$request->created_byId,
                ]);
            }
            else{

                //! Veri Ekleme
                $DB_Status = DB::table($table)->insert([
                    'lang' => $request->lang,
                    'uid' => $request->uid,
                    'img_url' => $request->imgUrl,
                    'category' => $request->category,
                    'title' => $request->title,
                    'seo_url' => SEOLink($request->title),
                    'description' => $request->description,
                    'seo_keywords' => $request->seo_keywords,

                    'stock' => $request->stock,
                    'currency' => $request->currency,
                    'sale_price' => $request->sale_price,
                    'discounted_price_percent' => $request->discounted_price_percent,
                    'discounted_price' => $request->discounted_price,

                    'floor_place' => $request->floor_place,
                    'place' => $request->place,

                    'new_product' => $request->new_product,
                    'editor_suggestion' => $request->editor_suggestion,
                    'bestseller' => $request->bestseller,

                    'created_byId'=>$request->created_byId,
                ]); //! Veri Ekleme Son

            }

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Product- Veri Ekleme Post Son
    
    //! Product- Veri Silme Post
    public function ProductDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'products';
            $DB_Find = DB::table($table)->where('uid','=',$request->uid)->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Silme
                $DB_Status = DB::table($table)->where('uid','=',$request->uid)->delete();

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

    } //! Product- Veri Silme Post Son

    //! Product- Veri Çoklu Silme Post
    public function ProductDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Silme
            $DB_Status = DB::table('products')->whereIn('uid',$request->uids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Product - Veri Çoklu Silme Post Son

    //! Product - Veri Güncelleme Sayfası
    public function ProductEdit($site_lang="tr",$id)
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Arama
                $table = 'products';
                $DB_Find_tr = DB::table($table)->where('uid',$id)->where('lang','tr')->first(); //Türkçe
                $DB_Find_en = DB::table($table)->where('uid',$id)->where('lang','en')->first(); //İngilizce
                $DB_Find_de = DB::table($table)->where('uid',$id)->where('lang','de')->first(); //Almanca

                if($DB_Find_tr) {

                    //! Product Category
                    $DB_Find_product_categories= DB::table('product_categories')->where('lang','=',__('admin.lang'))->get();
                    //echo "<pre>"; print_r($DB_blogs_categories); die();
                
                    //! Return
                    $DB["CookieData"] = $CookieControl["CookieDataList"];
                    $DB["DB_Find_tr"] =  $DB_Find_tr;
                    $DB["DB_Find_en"] =  $DB_Find_en;
                    $DB["DB_Find_de"] =  $DB_Find_de;
                    $DB["DB_Find_product_categories"] = $DB_Find_product_categories;

                    return view('admin/web/product/productListEdit',$DB); 
                                
                }
                else { return view('error404'); }
            
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
           
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Product - Veri Güncelleme Sayfası Son

    //! Product- Veri Güncelleme Post
    public function ProductEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //veri tabanı işlemleri
            $table = 'products';
            $DB = DB::table($table)->where('lang','=',$request->lang)->where('uid','=',$request->uid);
            $DB_Find = $DB->first(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if($DB_Find) {

                 //! Veri Güncelle
                 $DB_Status = $DB->update([       
                    'img_url' => $request->imgUrl, 
                    'category' => $request->category,    
                    'title' => $request->title,
                    'seo_url' => SEOLink($request->title),
                    'description' => $request->description,
                    'seo_keywords' => $request->seo_keywords,
                    'stock' => $request->stock,
                    'currency' => $request->currency,
                    'sale_price' => $request->sale_price,
                    'discounted_price_percent' => $request->discounted_price_percent,
                    'discounted_price' => $request->discounted_price,

                    'floor_place' => $request->floor_place,
                    'place' => $request->place,

                    'new_product' => $request->new_product,
                    'editor_suggestion' => $request->editor_suggestion,
                    'bestseller' => $request->bestseller,
                    
                    'isUpdated'=>true,
                    'updated_at'=>Carbon::now(),
                    'updated_byId'=>$request->updated_byId,
                ]);
            }
            else{ 

                //! Veri Ekleme
                $DB_Status = DB::table($table)->insert([
                    'lang' => $request->lang,
                    'uid' => $request->uid,
                    'img_url' => $request->imgUrl,
                    'category' => $request->category,
                    'title' => $request->title,
                    'seo_url' => SEOLink($request->title),
                    'description' => $request->description,
                    'seo_keywords' => $request->seo_keywords,
                    'stock' => $request->stock,
                    'currency' => $request->currency,
                    'sale_price' => $request->sale_price,
                    'discounted_price_percent' => $request->discounted_price_percent,
                    'discounted_price' => $request->discounted_price,
                    'created_byId'=>$request->updated_byId,
                ]); //! Veri Ekleme Son

            }

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Product- Veri Güncelleme Post Son

    //! Product - Veri Resim Güncelleme Post
    public function ProductEditInfoPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //veri tabanı işlemleri
            $table = 'products';
            $DB = DB::table($table)->where('uid','=',$request->uid);
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if($DB_Find) {

                 //! Veri Güncelle
                 $DB_Status = $DB->update([       
                    'img_url' => $request->imgUrl, 
                    'category' => $request->category,
                    'stock' => $request->stock,
                    'currency' => $request->currency,
                    'sale_price' => $request->sale_price,
                    'discounted_price_percent' => $request->discounted_price_percent,
                    'discounted_price' => $request->discounted_price,
                    
                    'floor_place' => $request->floor_place,
                    'place' => $request->place,

                    'new_product' => $request->new_product,
                    'editor_suggestion' => $request->editor_suggestion,
                    'bestseller' => $request->bestseller,

                    'isUpdated'=>true,
                    'updated_at'=>Carbon::now(),
                    'updated_byId'=>$request->updated_byId,
                ]);
            }

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Product - Veri Güncelleme Post Son
            
    //! Product - Veri Durum Güncelleme Post
    public function ProductEditActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $DB = DB::table('products')->where('uid',$request->uid); //Veri Tabanı
            $DB_Find = $DB->get(); //Tüm verileri çekiyor

            if( count($DB_Find) > 0 ) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'isActive'=>$request->active == "true" ? true : false,
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

    } //! Product - Veri Durum Güncelleme Post Son
        
    //! Product  - Çoklu Veri Durum Güncelle - Post
    public function ProductEditMultiActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Güncelleme
            $DB_Status = DB::table('products')->whereIn('uid',$request->uids)
            ->update([  
                'isActive'=>$request->active == "true" ? true : false,
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

        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );

            return response()->json($response);
        }

    } //! Product  - Çoklu Veri Durum Günceleme - Post Son

    //!  Product - Clone - Post
    public function ProductClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'products';
            $DB = DB::table($table)->where('uid',$request->uid); //VeriTabanı
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();

            if( count($DB_Find) > 0 ){  

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri
                $time = time(); //! uid

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->uid); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->uid = $time; //! Veri Güncelle
                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData; //! Ekleme
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
                    'error' => null,
                    'addNewId' => $time,
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

    } //!  Product - Clone - Post Son

    //!  Product - Çoklu Clone - Post
    public function ProductClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $table = 'products';
            $dbFind_uids = $request->uids;
            $dbFind_uids_count = count($dbFind_uids);
            //echo "sayisi: "; echo $dbFind_uids_count; die();

            if( $dbFind_uids_count > 0 ){ 
                        
                //! Veri Arama
                $DB = DB::table($table)->whereIn('uid',$dbFind_uids); //VeriTabanı
                $DB_Find = $DB->get(); //Tüm verileri çekiyor
                //echo "<pre>"; print_r($DB_Find); die();

                if( count($DB_Find) > 0 ){  

                    //! Tanım
                    $DB_FindInsert = []; //! Eklenecek Veri

                    for ($j=0; $j < $dbFind_uids_count; $j++) { 
                        $time = time()+$j; //! uid

                        for ($i=0; $i < count($DB_Find); $i++) {  
                            if( $DB_Find[$i]->uid == $dbFind_uids[$j] ) {
                                //echo $DB_Find[$i]->uid; echo " ";
                            
                                //! Veri Silme
                                unset($DB_Find[$i]->id); //! Veri Silme 
                                unset($DB_Find[$i]->uid); //! Veri Silme 
                                unset($DB_Find[$i]->created_at); //! Veri Silme 
                                unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                                unset($DB_Find[$i]->updated_at); //! Veri Silme 
                                unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                                unset($DB_Find[$i]->isActive); //! Veri Silme 
                                unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                                unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                                unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                                $DB_Find[$i]->uid = $time; //! Veri Güncelle
                                $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                                //! Yeni Data
                                $newData = array(); //! Eklenecek Veri 
                                $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                                
                                //! Veriler
                                for ($k=0; $k < count($table_columns); $k++) { 
                                    $col=$table_columns[$k];
                                    $newData[$col] = $DB_Find->pluck($col)[$i];
                                }
                                //! Veriler Son
                            
                                $DB_FindInsert[] = $newData; //! Ekleme
                            }
                        }

                    }

                    //! Veri Ekleme
                    $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                    $response = array(
                        'status' => $addNewStatus ? 'success' : 'error',
                        'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

            }
            else {
    
               $response = array(
                  'status' => 'error',
                  'msg' => "uid:".__('admin.dataNotFound'),
                  'error' => null,
               );
    
               return response()->json($response);
            }
    
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' =>  __('admin.transactionFailed'),
               'error' => $th,            
            );
    
            return response()->json($response);
        }

    } //!  Product - Çoklu Clone - Post Son

    //************* Product - Yorum  ***************** */

    //! Product - Yorum
    public function ProductComment($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "product_comment";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData
                $selectData = [];  //! Select
                $selectDataRaw = [];  //! Select - Raw
                $joinData = [];  //! Join

                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "Status", "table" => $table, "where" => "isActive", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                
                $whereData = []; //! Where
                //$whereData[] = array( "table" => $table, "where" => "created_byId" , "data_item_object" => "=", "value" => 26 ); //! Arama
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                
                return view('admin/web/product/product_comment',$DB);
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Product - Yorum Son

    //! Product - Yorum- Arama Post
    public function ProductCommentSearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('product_comment')->where('id',$request->id)->first(); //Tüm verileri çekiyor
   
            if($DB_Find) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
                  'error' => null, 
               );
   
               return response()->json($response);
            }
   
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' => __('admin.transactionFailed'),
               'DB' =>  [],
               'error' => $th,            
            );
   
            return response()->json($response);
        }

    } //! Product - Yorum - Arama Post Son

    //! Product - Yorum - Veri Ekleme Post
    public function ProductCommentAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Ekleme
            DB::table('product_comment')->insert([
                'userid' => $request->userid,
                'lang' => $request->lang,
                'product_uid' => $request->product_uid,
                'comment' => $request->comment,
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

    } //! Product - Yorum - Veri Ekleme Post Son

    //! Product - Yorum - Veri Silme Post
    public function ProductCommentDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'product_comment';
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

    } //! Product - Yorum - Veri Silme Post Son

    //! Product - Yorum - Veri Çoklu Silme Post
    public function ProductCommentDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Silme
            $DB_Status = DB::table('product_comment')->whereIn('id',$request->ids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Product - Yorum - Veri Çoklu Silme Post Son

    //! Product - Yorum - Veri Güncelleme Post
    public function ProductCommentEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB = DB::table('product_comment')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'userid' => $request->userid,
                    'lang' => $request->lang,
                    'product_uid' => $request->product_uid,
                    'comment' => $request->comment,
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

    } //! Product - Yorum - Veri Güncelleme Post Son
        
    //! Satış - Veri Durum Güncelleme Post
    public function ProductCommentEditActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $DB = DB::table('product_comment')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'isActive'=>$request->active == "true" ? true : false,
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

    } //! Satış - Veri Durum Güncelleme Post Son
    
    //! Satış - Çoklu Veri Durum Güncelle - Post
    public function ProductCommentEditMultiActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Güncelleme
            $DB_Status = DB::table('product_comment')->whereIn('id',$request->ids)
            ->update([  
                'isActive'=>$request->active == "true" ? true : false,
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

        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );

            return response()->json($response);
        }

    } //! Satış - Çoklu Veri Durum Güncelle - Post Son
    
    //! Product - Yorum - Clone - Post
    public function ProductCommentClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'product_comment';
            $DB = DB::table($table)->where('id',$request->id); //VeriTabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) { 
            
                //! Verileri Ayarlıyor
                unset($DB_Find->id); //! Veri Silme 
                unset($DB_Find->created_at); //! Veri Silme 
                unset($DB_Find->isUpdated); //! Veri Silme 
                unset($DB_Find->updated_at); //! Veri Silme 
                unset($DB_Find->updated_byId); //! Veri Silme 
                unset($DB_Find->isActive); //! Veri Silme 
                unset($DB_Find->isDeleted); //! Veri Silme 
                unset($DB_Find->deleted_at); //! Veri Silme 
                unset($DB_Find->deleted_byId); //! Veri Silme 

                $DB_Find->created_byId = $request->created_byId; //! Veri Güncelle
            
                //! Tanım
                $newData = array(); //! Eklenecek Veri 
                $table_columns = array_keys(json_decode(json_encode($DB_Find), true));  //! Sutun Veriler
            
                //! Veriler
                for ($i=0; $i < count($table_columns); $i++) { 
                    $col=$table_columns[$i];
                    $newData[$col] = $DB->pluck($col)[0];
                }
                //! Veriler Son

                //$newData['img_url'] = config('admin.Default_UserImgUrl');
                $newData['created_byId'] = $request->created_byId;

                //! Veri Ekleme
                $addNewId = DB::table($table)->insertGetId($newData); //! Veri Ekleme Son

                $response = array(
                    'status' => 'success',
                    'msg' => __('admin.transactionSuccessful'),
                    'error' => null, 
                    'addNewId' => $addNewId,
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

    } //! Product - Yorum - Clone - Post Son

    //! Product - Yorum - Çoklu Clone - Post
    public function ProductCommentClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $table = 'product_comment';
            $DB = DB::table($table)->whereIn('id',$request->ids);
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if( count($DB_Find) > 0 ){ 

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData;
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Product - Yorum - Çoklu Clone - Post Son
    
    
    //************* Finans - İşletme Hesap  ***************** */

    //! Finans - İşletme Hesap
    public function BusinessAccount($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "finance_business_account";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData
                $selectData = [];  //! Select
                $selectDataRaw = [];  //! Select - Raw
                $joinData = [];  //! Join
                
                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "Id", "table" => $table, "where" => "id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "Title", "table" => $table, "where" => "title", "data_item_object" => "likeBoth", "data_key_type" => "string", ); //! %A%
                $searchData[] = array("params" => "Type", "table" => $table, "where" => "type_code", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                

                $whereData = []; //! Where
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                
                return view('admin/finance/business_account',$DB);
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Finans - İşletme Hesap Son

    //! Finans - İşletme Hesap - Arama Post
    public function BusinessAccountSearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('finance_business_account')->where('id',$request->id)->first(); //Tüm verileri çekiyor
   
            if($DB_Find) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
                  'error' => null, 
               );
   
               return response()->json($response);
            }
   
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' => __('admin.transactionFailed'),
               'DB' =>  [],
               'error' => $th,            
            );
   
            return response()->json($response);
        }

    } //! Finans - İşletme Hesap - Arama Post Son

    //! Finans - İşletme Hesap - Veri Ekleme Post
    public function BusinessAccountAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Ekleme
            DB::table('finance_business_account')->insert([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'type' => $request->type,
                'type_code' => $request->type_code,
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

    } //! Finans - İşletme Hesap - Veri Ekleme Post Son

    //! Finans - İşletme Hesap - Veri Silme Post
    public function BusinessAccountDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'finance_business_account';
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

    } //! Finans - İşletme Hesap - Veri Silme Post Son

    //! Finans - İşletme Hesap - Veri Çoklu Silme Post
    public function BusinessAccountDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Silme
            $DB_Status = DB::table('finance_business_account')->whereIn('id',$request->ids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Finans - İşletme Hesap - Veri Çoklu Silme Post Son

    //! Finans - İşletme Hesap - Veri Güncelleme Post
    public function BusinessAccountEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB = DB::table('finance_business_account')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'title' => $request->title,
                    'description' => $request->description,
                    'price' => $request->price,
                    'type' => $request->type,
                    'type_code' => $request->type_code,
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

    } //! Finans - İşletme Hesap - Veri Güncelleme Post Son

    //! Finans - İşletme Hesap  -Clone - Post
    public function BusinessAccountClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'finance_business_account';
            $DB = DB::table($table)->where('id',$request->id); //VeriTabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) { 
            
                //! Verileri Ayarlıyor
                unset($DB_Find->id); //! Veri Silme 
                unset($DB_Find->created_at); //! Veri Silme 
                unset($DB_Find->isUpdated); //! Veri Silme 
                unset($DB_Find->updated_at); //! Veri Silme 
                unset($DB_Find->updated_byId); //! Veri Silme 
                unset($DB_Find->isActive); //! Veri Silme 
                unset($DB_Find->isDeleted); //! Veri Silme 
                unset($DB_Find->deleted_at); //! Veri Silme 
                unset($DB_Find->deleted_byId); //! Veri Silme 

                $DB_Find->created_byId = $request->created_byId; //! Veri Güncelle
            
                //! Tanım
                $newData = array(); //! Eklenecek Veri 
                $table_columns = array_keys(json_decode(json_encode($DB_Find), true));  //! Sutun Veriler
            
                //! Veriler
                for ($i=0; $i < count($table_columns); $i++) { 
                    $col=$table_columns[$i];
                    $newData[$col] = $DB->pluck($col)[0];
                }
                //! Veriler Son

                //$newData['img_url'] = config('admin.Default_UserImgUrl');
                $newData['created_byId'] = $request->created_byId;

                //! Veri Ekleme
                $addNewId = DB::table($table)->insertGetId($newData); //! Veri Ekleme Son

                $response = array(
                    'status' => 'success',
                    'msg' => __('admin.transactionSuccessful'),
                    'error' => null, 
                    'addNewId' => $addNewId,
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

    } //! Finans - İşletme Hesap  - Clone - Post Son

    //! Finans - İşletme Hesap  - Çoklu Clone - Post
    public function BusinessAccountClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $table = 'finance_business_account';
            $DB = DB::table($table)->whereIn('id',$request->ids);
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if( count($DB_Find) > 0 ){ 

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData;
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Finans - İşletme Hesap  - Çoklu Clone - Post Son
    
    //*************  Cari Hesap  ***************** */

    //! Cari Hesap
    public function CurrentAccount($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "finance_current_account";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
              
                //! Group
                $groupData = []; //! GroupData
                $groupData[]= "finance_current_account.id"; //! Ekleme
                
                $selectData = [];  //! Select

                //! Select - Raw
                $selectDataRaw = [];
                $selectDataRaw[] = "finance_current_account.*";

                $selectDataRaw[] = "SUM(CASE WHEN finance_safe_account.type_code = 1  THEN finance_safe_account.quantity ELSE 0 END) as ToplamGelirMiktari";
                $selectDataRaw[] = "SUM(CASE WHEN finance_safe_account.type_code = 1  THEN finance_safe_account.total ELSE 0 END) as ToplamGelirTutar";

                $selectDataRaw[] = "SUM(CASE WHEN finance_safe_account.type_code = 2 OR finance_safe_account.type_code = 3 THEN finance_safe_account.quantity ELSE 0 END) as ToplamGiderMiktari";
                $selectDataRaw[] = "SUM(CASE WHEN finance_safe_account.type_code = 2 OR finance_safe_account.type_code = 3 THEN finance_safe_account.total ELSE 0 END) as ToplamGiderTutar";

                $selectDataRaw[] = "(SUM(CASE WHEN finance_safe_account.type_code = 2 OR finance_safe_account.type_code = 3  THEN finance_safe_account.quantity ELSE 0 END) - SUM(CASE WHEN finance_safe_account.type_code = 1 THEN finance_safe_account.quantity ELSE 0 END) ) as ToplamBakiyeMiktari";
                $selectDataRaw[] = "(SUM(CASE WHEN finance_safe_account.type_code = 1  THEN finance_safe_account.total ELSE 0 END) - SUM(CASE WHEN finance_safe_account.type_code = 2 OR finance_safe_account.type_code = 3 THEN finance_safe_account.total ELSE 0 END) ) as ToplamBakiyeTutar";
                
                //! Join
                $joinData = [];
                $joinData[] = array( "type" => "LEFT", "table" => "finance_safe_account" , "value" => "current_id", "refTable" => $table, "refValue" => "id", ); //! Join Veri Ekleme

                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "Date", "table" => $table, "where" => "date_time", "data_item_object" => "=", "data_key_type" => "string", ); //! Eşit
                
                $whereData = []; //! Where
                //$whereData[] = array( "table" => $table, "where" => "created_byId" , "data_item_object" => "=", "value" => 26 ); //! Arama
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                return view('admin/finance/current_account',$DB);
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Cari Hesap Son

    //! Cari Hesap Arama Post
    public function CurrentAccountSearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('finance_current_account')->where('id',$request->id)->first(); //Tüm verileri çekiyor
   
            if($DB_Find) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
                  'error' => null, 
               );
   
               return response()->json($response);
            }
   
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' => __('admin.transactionFailed'),
               'DB' =>  [],
               'error' => $th,            
            );
   
            return response()->json($response);
        }

    } //! Cari Hesap - Arama Post Son

    //! Cari Hesap - Veri Ekleme Post
    public function CurrentAccountAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Ekleme
            DB::table('finance_current_account')->insert([
                'title' => $request->title,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'iban' => $request->iban,
                'iban_name' => $request->iban_name,
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

    } //! Cari Hesap - Veri Ekleme Post Son

    //! Cari Hesap - Veri Silme Post
    public function CurrentAccountDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'finance_current_account';
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

    } //! Cari Hesap - Veri Silme Post Son

    //! Cari Hesap - Veri Çoklu Silme Post
    public function CurrentAccountDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Silme
            $DB_Status = DB::table('finance_current_account')->whereIn('id',$request->ids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Cari Hesap - Veri Çoklu Silme Post Son

    //! Cari Hesap - Veri Güncelleme Post
    public function CurrentAccountEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB = DB::table('finance_current_account')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'title' => $request->title,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'address' => $request->address,
                    'iban' => $request->iban,
                    'iban_name' => $request->iban_name,
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

    } //! Cari Hesap - Veri Güncelleme Post Son
    
    //! Cari Hesap - Clone - Post
    public function CurrentAccountClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'finance_current_account';
            $DB = DB::table($table)->where('id',$request->id); //VeriTabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) { 
            
                //! Verileri Ayarlıyor
                unset($DB_Find->id); //! Veri Silme 
                unset($DB_Find->created_at); //! Veri Silme 
                unset($DB_Find->isUpdated); //! Veri Silme 
                unset($DB_Find->updated_at); //! Veri Silme 
                unset($DB_Find->updated_byId); //! Veri Silme 
                unset($DB_Find->isActive); //! Veri Silme 
                unset($DB_Find->isDeleted); //! Veri Silme 
                unset($DB_Find->deleted_at); //! Veri Silme 
                unset($DB_Find->deleted_byId); //! Veri Silme 

                $DB_Find->created_byId = $request->created_byId; //! Veri Güncelle
            
                //! Tanım
                $newData = array(); //! Eklenecek Veri 
                $table_columns = array_keys(json_decode(json_encode($DB_Find), true));  //! Sutun Veriler
            
                //! Veriler
                for ($i=0; $i < count($table_columns); $i++) { 
                    $col=$table_columns[$i];
                    $newData[$col] = $DB->pluck($col)[0];
                }
                //! Veriler Son

                //$newData['img_url'] = config('admin.Default_UserImgUrl');
                $newData['created_byId'] = $request->created_byId;

                //! Veri Ekleme
                $addNewId = DB::table($table)->insertGetId($newData); //! Veri Ekleme Son

                $response = array(
                    'status' => 'success',
                    'msg' => __('admin.transactionSuccessful'),
                    'error' => null, 
                    'addNewId' => $addNewId,
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

    } //! Cari Hesap - Clone - Post Son

    //! Cari Hesap - Çoklu Clone - Post
    public function CurrentAccountClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $table = 'finance_current_account';
            $DB = DB::table($table)->whereIn('id',$request->ids);
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if( count($DB_Find) > 0 ){ 

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData;
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Cari Hesap - Çoklu Clone - Post Son

    //*************  Cari Hesap Extra  ***************** */
        
    //! Cari Hesap - Extra Sayfası Son
    public function CurrentAccountFind($site_lang="tr",$id)
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "finance_safe_account";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData
                
                  //! Select
                $selectData = [];
                $selectData[] = array( "table" => $table, "parametre" => "*", "name" => null, );
                $selectData[] = array( "table" => 'finance_current_account', "parametre" => "title", "name" => "finance_current_account_title", );
                
                $selectDataRaw = [];  //! Select - Raw

                $joinData = [];  //! Join
                $joinData[] = array( "type" => "LEFT", "table" => "finance_current_account" , "value" => "id", "refTable" => $table, "refValue" => "current_id", ); //! Join Veri Ekleme
                
                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "Id", "table" => $table, "where" => "id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "DateStart", "table" => $table, "where" => "date_time", "data_item_object" => ">=", "data_key_type" => "date", ); //! Zaman Büyük ve Eşit
                $searchData[] = array("params" => "DateFinish", "table" => $table, "where" => "date_time", "data_item_object" => "<=", "data_key_type" => "date", ); //! Zaman Büyük ve Eşit
                $searchData[] = array("params" => "BusinessAccount", "table" => $table, "where" => "finance_business_account_id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit   
                $searchData[] = array("params" => "Title", "table" => $table, "where" => "title", "data_item_object" => "likeBoth", "data_key_type" => "string", ); //! %A%
                $searchData[] = array("params" => "Type", "table" => $table, "where" => "type_code", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "ActiveType", "table" => $table, "where" => "action_type", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit

                $searchData[] = array("params" => "CurrentCode", "table" => $table, "where" => "current_id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "CurrentName", "table" => $table, "where" => "current_id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit

                //! Where
                $whereData = [];
                $whereData[] = array( "table" => $table, "where" => "current_id" , "data_item_object" => "=", "value" => $id );
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];
                $DB["DB_Find_Type"] = "All";
                $DB["DB_Find_Finance_Current_Account"] = $id;

                //! Dashboard Görünümü
                $parameter_dashboardview = request('dashboardview');
                if( request('dashboardview') == null ) { $parameter_dashboardview = 0; }
                else { $parameter_dashboardview = request('dashboardview'); }
                //echo "parameter_dashboardview:"; echo $parameter_dashboardview; die();
                
                $DB["dashboardview"] = $parameter_dashboardview;
                //! Dashboard Görünümü Son

                //! Cari Hesaplar
                $DB_Current_Account = DB::table('finance_current_account')->where('id',$id)->get(); //Tüm verileri çekiyor
                //echo "<pre>"; print_r($DB_Current_Account); die();
                
                $DB["DB_Find_Title"] = count($DB_Current_Account) > 0 ? "Cari Hesap Extra (#".$DB_Current_Account[0]->id.") - ".$DB_Current_Account[0]->title : "Cari Hesap Extra - Veri Bulunmadı";
                $DB["DB_Current_Account"] = $DB_Current_Account;
                //! Cari Hesaplar Son 

                //! İş Hesapları
                $DB_Business_Account = DB::table('finance_business_account')->orderBy('title','asc')->get(); //Tüm verileri çekiyor
                //echo "<pre>"; print_r($DB_Business_Account); die();
                $DB["DB_Business_Account"] = $DB_Business_Account;
                //! İş Hesapları Son 

                //! Dashboard
                $DB_Find_Dashboard= DB::table('finance_safe_account')
                ->selectRaw('
                    COUNT(finance_safe_account.id) as totalCount,
                    Format(ROUND(SUM( CASE 
                        WHEN finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPrice,
                    Format(ROUND(SUM(CASE WHEN finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePrice,
                    Format(ROUND(SUM(CASE WHEN finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePrice,

                    COUNT(CASE WHEN finance_safe_account.action_type = 1 THEN 1 END) as totalActiveCount,
                    Format(ROUND(SUM( CASE 
                        WHEN finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalActivePrice,
                        Format(ROUND(SUM(CASE WHEN finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomeActivePrice,
                    Format(ROUND(SUM(CASE WHEN finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpenseActivePrice,

                    COUNT(CASE WHEN finance_safe_account.action_type != 1 THEN 1 END) as totalPasiveCount,
                    Format(ROUND(SUM( CASE 
                        WHEN finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPasivePrice,
                        Format(ROUND(SUM(CASE WHEN finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePasivePrice,
                    Format(ROUND(SUM(CASE WHEN finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePasivePrice,

                    YEAR(NOW()) AS YEAR_NOW,

                    COUNT(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) THEN 1 END) as totalCount_Year,
                    Format(ROUND(SUM( CASE 
                        WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPrice_Year,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePrice_Year,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePrice_Year,

                    COUNT(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type = 1 THEN 1 END) as totalActiveCount_Year,
                    Format(ROUND(SUM( CASE 
                        WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalActivePrice_Year,
                        Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomeActivePrice_Year,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpenseActivePrice_Year,

                    COUNT(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type != 1 THEN 1 END) as totalPasiveCount_Year,
                    Format(ROUND(SUM( CASE 
                        WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPasivePrice_Year,
                        Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePasivePrice_Year,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePasivePrice_Year,

                    MONTH(NOW()) AS MONTH_NOW,

                    COUNT(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) THEN 1 END) as totalCount_Month,
                    Format(ROUND(SUM( CASE 
                        WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPrice_Month,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePrice_Month,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePrice_Month,

                    COUNT(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type = 1 THEN 1 END) as totalActiveCount_Month,
                    Format(ROUND(SUM( CASE 
                        WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalActivePrice_Month,
                        Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomeActivePrice_Month,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpenseActivePrice_Month,

                    COUNT(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type != 1 THEN 1 END) as totalPasiveCount_Month,
                    Format(ROUND(SUM( CASE 
                        WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPasivePrice_Month,
                        Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePasivePrice_Month,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePasivePrice_Month,

                    DATE_FORMAT(date_add(now(), INTERVAL -7 DAY),"%Y-%m-%d") AS WEEK_BEFORE_7DAY,
                    DATE_FORMAT(now(),"%Y-%m-%d") AS DAY_NOW,

                    COUNT(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) THEN 1 END) as totalCount_Week,
                    Format(ROUND(SUM( CASE 
                        WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPrice_Week,
                    Format(ROUND(SUM(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePrice_Week,
                    Format(ROUND(SUM(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePrice_Week,

                    COUNT(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type = 1 THEN 1 END) as totalActiveCount_Week,
                    Format(ROUND(SUM( CASE 
                        WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalActivePrice_Week,
                        Format(ROUND(SUM(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomeActivePrice_Week,
                    Format(ROUND(SUM(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpenseActivePrice_Week,

                    COUNT(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type != 1 THEN 1 END) as totalPasiveCount_Week,
                    Format(ROUND(SUM( CASE 
                        WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPasivePrice_Week,
                        Format(ROUND(SUM(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePasivePrice_Week,
                    Format(ROUND(SUM(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePasivePrice_Week,

                    COUNT(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) THEN 1 END) as totalCount_Today,
                    Format(ROUND(SUM( CASE 
                        WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPrice_Today,
                    Format(ROUND(SUM(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePrice_Today,
                    Format(ROUND(SUM(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePrice_Today,

                    COUNT(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type = 1 THEN 1 END) as totalActiveCount_Today,
                    Format(ROUND(SUM( CASE 
                        WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalActivePrice_Today,
                        Format(ROUND(SUM(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomeActivePrice_Today,
                    Format(ROUND(SUM(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpenseActivePrice_Today,

                    COUNT(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type != 1 THEN 1 END) as totalPasiveCount_Today,
                    Format(ROUND(SUM( CASE 
                        WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPasivePrice_Today,
                        Format(ROUND(SUM(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePasivePrice_Today,
                    Format(ROUND(SUM(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePasivePrice_Today

                ')
                ->where($DB_Find['where'])
                ->get();
                //echo "<pre>"; print_r($DB_Find_Dashboard[0]); die();

                $DB["DB_Find_Dashboard"] =  $DB_Find_Dashboard[0];
                //! Dashboard Son

                //echo "<pre>"; print_r($DB); die();
                
                return view('admin/finance/safe_account',$DB);
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Finans - İşletme Hesap - Gider Son
        
    //************* Finans - Kasa Hesap  ***************** */

    //! Finans - Kasa Hesap
    public function SafeAccount($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "finance_safe_account";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData
                
                //! Select
                $selectData = [];
                $selectData[] = array( "table" => $table, "parametre" => "*", "name" => null, );
                $selectData[] = array( "table" => 'finance_current_account', "parametre" => "title", "name" => "finance_current_account_title", );
                
                $selectDataRaw = [];  //! Select - Raw

                //! Join
                $joinData = [];
                $joinData[] = array( "type" => "LEFT", "table" => "finance_current_account" , "value" => "id", "refTable" => $table, "refValue" => "current_id", ); //! Join Veri Ekleme
                
                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "Id", "table" => $table, "where" => "id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "DateStart", "table" => $table, "where" => "date_time", "data_item_object" => ">=", "data_key_type" => "date", ); //! Zaman Büyük ve Eşit
                $searchData[] = array("params" => "DateFinish", "table" => $table, "where" => "date_time", "data_item_object" => "<=", "data_key_type" => "date", ); //! Zaman Büyük ve Eşit
                $searchData[] = array("params" => "BusinessAccount", "table" => $table, "where" => "finance_business_account_id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit   
                $searchData[] = array("params" => "Title", "table" => $table, "where" => "title", "data_item_object" => "likeBoth", "data_key_type" => "string", ); //! %A%
                $searchData[] = array("params" => "Type", "table" => $table, "where" => "type_code", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "ActiveType", "table" => $table, "where" => "action_type", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit

                $searchData[] = array("params" => "CurrentCode", "table" => $table, "where" => "current_id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "CurrentName", "table" => $table, "where" => "current_id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit

                $whereData = []; //! Where
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                $DB["DB_Find_Title"] = "Kasa - Tüm Liste";
                $DB["DB_Find_Type"] = "All";
                $DB["DB_Find_Finance_Current_Account"] = "All";

                //! Dashboard Görünümü
                $parameter_dashboardview = request('dashboardview');
                if( request('dashboardview') == null ) { $parameter_dashboardview = 1; }
                else { $parameter_dashboardview = request('dashboardview'); }
                //echo "parameter_dashboardview:"; echo $parameter_dashboardview; die();
                
                $DB["dashboardview"] = $parameter_dashboardview;
                //! Dashboard Görünümü Son

                //! Cari Hesaplar
                $DB_Current_Account = DB::table('finance_current_account')->get(); //Tüm verileri çekiyor
                //echo "<pre>"; print_r($DB_Current_Account); die();
                $DB["DB_Current_Account"] = $DB_Current_Account;
                //! Cari Hesaplar Son 

                //! İş Hesapları
                $DB_Business_Account = DB::table('finance_business_account')->orderBy('title','asc')->get(); //Tüm verileri çekiyor
                //echo "<pre>"; print_r($DB_Business_Account); die();
                $DB["DB_Business_Account"] = $DB_Business_Account;
                //! İş Hesapları Son 

                //! Dashboard
                $DB_Find_Dashboard= DB::table('finance_safe_account')
                ->selectRaw('
                    COUNT(finance_safe_account.id) as totalCount,
                    Format(ROUND(SUM( CASE 
                        WHEN finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPrice,
                    Format(ROUND(SUM(CASE WHEN finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePrice,
                    Format(ROUND(SUM(CASE WHEN finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePrice,

                    COUNT(CASE WHEN finance_safe_account.action_type = 1 THEN 1 END) as totalActiveCount,
                    Format(ROUND(SUM( CASE 
                        WHEN finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalActivePrice,
                        Format(ROUND(SUM(CASE WHEN finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomeActivePrice,
                    Format(ROUND(SUM(CASE WHEN finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpenseActivePrice,

                    COUNT(CASE WHEN finance_safe_account.action_type != 1 THEN 1 END) as totalPasiveCount,
                    Format(ROUND(SUM( CASE 
                        WHEN finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPasivePrice,
                        Format(ROUND(SUM(CASE WHEN finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePasivePrice,
                    Format(ROUND(SUM(CASE WHEN finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePasivePrice,

                    YEAR(NOW()) AS YEAR_NOW,

                    COUNT(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) THEN 1 END) as totalCount_Year,
                    Format(ROUND(SUM( CASE 
                        WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPrice_Year,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePrice_Year,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePrice_Year,

                    COUNT(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type = 1 THEN 1 END) as totalActiveCount_Year,
                    Format(ROUND(SUM( CASE 
                        WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalActivePrice_Year,
                        Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomeActivePrice_Year,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpenseActivePrice_Year,

                    COUNT(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type != 1 THEN 1 END) as totalPasiveCount_Year,
                    Format(ROUND(SUM( CASE 
                        WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPasivePrice_Year,
                        Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePasivePrice_Year,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePasivePrice_Year,

                    MONTH(NOW()) AS MONTH_NOW,

                    COUNT(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) THEN 1 END) as totalCount_Month,
                    Format(ROUND(SUM( CASE 
                        WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPrice_Month,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePrice_Month,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePrice_Month,

                    COUNT(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type = 1 THEN 1 END) as totalActiveCount_Month,
                    Format(ROUND(SUM( CASE 
                        WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalActivePrice_Month,
                        Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomeActivePrice_Month,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpenseActivePrice_Month,

                    COUNT(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type != 1 THEN 1 END) as totalPasiveCount_Month,
                    Format(ROUND(SUM( CASE 
                        WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPasivePrice_Month,
                        Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePasivePrice_Month,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePasivePrice_Month,

                    DATE_FORMAT(date_add(now(), INTERVAL -7 DAY),"%Y-%m-%d") AS WEEK_BEFORE_7DAY,
                    DATE_FORMAT(now(),"%Y-%m-%d") AS DAY_NOW,

                    COUNT(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) THEN 1 END) as totalCount_Week,
                    Format(ROUND(SUM( CASE 
                        WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPrice_Week,
                    Format(ROUND(SUM(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePrice_Week,
                    Format(ROUND(SUM(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePrice_Week,

                    COUNT(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type = 1 THEN 1 END) as totalActiveCount_Week,
                    Format(ROUND(SUM( CASE 
                        WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalActivePrice_Week,
                        Format(ROUND(SUM(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomeActivePrice_Week,
                    Format(ROUND(SUM(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpenseActivePrice_Week,

                    COUNT(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type != 1 THEN 1 END) as totalPasiveCount_Week,
                    Format(ROUND(SUM( CASE 
                        WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPasivePrice_Week,
                        Format(ROUND(SUM(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePasivePrice_Week,
                    Format(ROUND(SUM(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePasivePrice_Week,

                    COUNT(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) THEN 1 END) as totalCount_Today,
                    Format(ROUND(SUM( CASE 
                        WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPrice_Today,
                    Format(ROUND(SUM(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePrice_Today,
                    Format(ROUND(SUM(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePrice_Today,

                    COUNT(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type = 1 THEN 1 END) as totalActiveCount_Today,
                    Format(ROUND(SUM( CASE 
                        WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalActivePrice_Today,
                        Format(ROUND(SUM(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomeActivePrice_Today,
                    Format(ROUND(SUM(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpenseActivePrice_Today,

                    COUNT(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type != 1 THEN 1 END) as totalPasiveCount_Today,
                    Format(ROUND(SUM( CASE 
                        WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPasivePrice_Today,
                        Format(ROUND(SUM(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePasivePrice_Today,
                    Format(ROUND(SUM(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePasivePrice_Today

                ')
                ->where($DB_Find['where'])
                ->get();
                //echo "<pre>"; print_r($DB_Find_Dashboard[0]); die();

                $DB["DB_Find_Dashboard"] =  $DB_Find_Dashboard[0];
                //! Dashboard Son

                //echo "<pre>"; print_r($DB); die();
                
                return view('admin/finance/safe_account',$DB);
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Finans - Kasa Hesap Son

    //! Finans - Kasa Hesap - Arama Post
    public function SafeAccountSearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('finance_safe_account')->where('id',$request->id)->first(); //Tüm verileri çekiyor
   
            if($DB_Find) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
                  'error' => null, 
               );
   
               return response()->json($response);
            }
   
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' => __('admin.transactionFailed'),
               'DB' =>  [],
               'error' => $th,            
            );
   
            return response()->json($response);
        }

    } //! Finans - Kasa Hesap - Arama Post Son

    //! Finans - Kasa Hesap - Veri Ekleme Post
    public function SafeAccountAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Ekleme
            DB::table('finance_safe_account')->insert([
                'current_id' => $request->current_id,
                'date_time' => $request->date_time,
                'finance_business_account_id' => $request->finance_business_account_id,
                'title' => $request->title,
                'description' => $request->description,
                'type' => $request->type,
                'type_code' => $request->type_code,
                'action_type' => $request->action_type,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'total' => $request->total,
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

    } //! Finans - Kasa Hesap - Veri Ekleme Post Son

    //! Finans - Kasa Hesap - Veri Silme Post
    public function SafeAccountDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'finance_safe_account';
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

    } //! Finans - Kasa Hesap - Veri Silme Post Son

    //! Finans - Kasa Hesap - Veri Çoklu Silme Post
    public function SafeAccountDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Silme
            $DB_Status = DB::table('finance_safe_account')->whereIn('id',$request->ids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Finans - Kasa Hesap - Veri Çoklu Silme Post Son

    //! Finans - Kasa Hesap- Veri Güncelleme Post
    public function SafeAccountEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB = DB::table('finance_safe_account')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'current_id' => $request->current_id,
                    'date_time' => $request->date_time,
                    'finance_business_account_id' => $request->finance_business_account_id,
                    'title' => $request->title,
                    'description' => $request->description,
                    'type' => $request->type,
                    'type_code' => $request->type_code,
                    'action_type' => $request->action_type,
                    'price' => $request->price,
                    'quantity' => $request->quantity,
                    'total' => $request->total,
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

    } //! Finans - Kasa Hesap - Veri Güncelleme Post Son

    //! Finans - Kasa Hesap - Veri Dosya Güncelleme Post
    public function SafeAccountEditFilePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $DB = DB::table('finance_safe_account')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'file_name' => $request->fileUploadName,
                    'file_url' => $request->file_download_href,
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

    } //! Finans - Kasa Hesap - Veri Güncelleme Post Son

    //! Finans - Kasa Hesap - Veri Durum Güncelleme Post
    public function SafeAccountEditActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $DB = DB::table('finance_safe_account')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'action_type' => $request->action_type,
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

    } //! Finans - Kasa Hesap - Veri Durum Güncelleme Post Son

    //! Finans - Kasa Hesap - Çoklu Veri Durum Güncelle - Post
    public function SafeAccountEditMultiActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Güncelleme
            $DB_Status = DB::table('finance_safe_account')->whereIn('id',$request->ids)
            ->update([  
                'action_type' => $request->action_type,
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

        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );

            return response()->json($response);
        }

    } //! Finans - Kasa Hesap - Çoklu Veri Durum Güncelle - Post Son

    //! Finans - Kasa Hesap  -Clone - Post
    public function SafeAccountClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'finance_safe_account';
            $DB = DB::table($table)->where('id',$request->id); //VeriTabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) { 
            
                //! Verileri Ayarlıyor
                unset($DB_Find->id); //! Veri Silme 
                unset($DB_Find->created_at); //! Veri Silme 
                unset($DB_Find->isUpdated); //! Veri Silme 
                unset($DB_Find->updated_at); //! Veri Silme 
                unset($DB_Find->updated_byId); //! Veri Silme 
                unset($DB_Find->isActive); //! Veri Silme 
                unset($DB_Find->isDeleted); //! Veri Silme 
                unset($DB_Find->deleted_at); //! Veri Silme 
                unset($DB_Find->deleted_byId); //! Veri Silme 

                $DB_Find->created_byId = $request->created_byId; //! Veri Güncelle
            
                //! Tanım
                $newData = array(); //! Eklenecek Veri 
                $table_columns = array_keys(json_decode(json_encode($DB_Find), true));  //! Sutun Veriler
            
                //! Veriler
                for ($i=0; $i < count($table_columns); $i++) { 
                    $col=$table_columns[$i];
                    $newData[$col] = $DB->pluck($col)[0];
                }
                //! Veriler Son

                //$newData['img_url'] = config('admin.Default_UserImgUrl');
                $newData['created_byId'] = $request->created_byId;

                //! Veri Ekleme
                $addNewId = DB::table($table)->insertGetId($newData); //! Veri Ekleme Son

                $response = array(
                    'status' => 'success',
                    'msg' => __('admin.transactionSuccessful'),
                    'error' => null, 
                    'addNewId' => $addNewId,
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

    } //! Finans - Kasa Hesap - Clone - Post Son

    //! Finans - Kasa Hesap  - Çoklu Clone - Post
    public function SafeAccountClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $table = 'finance_safe_account';
            $DB = DB::table($table)->whereIn('id',$request->ids);
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if( count($DB_Find) > 0 ){ 

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData;
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Finans - Kasa Hesap  - Çoklu Clone - Post Son

            
    //************* Finans - Kasa Hesap - Tür  ***************** */

    //! Finans - İşletme Hesap - Gelir
    public function SafeAccountIncome($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "finance_safe_account";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData
                
                  //! Select
                $selectData = [];
                $selectData[] = array( "table" => $table, "parametre" => "*", "name" => null, );
                $selectData[] = array( "table" => 'finance_current_account', "parametre" => "title", "name" => "finance_current_account_title", );
                
                $selectDataRaw = [];  //! Select - Raw

                $joinData = [];  //! Join
                $joinData[] = array( "type" => "LEFT", "table" => "finance_current_account" , "value" => "id", "refTable" => $table, "refValue" => "current_id", ); //! Join Veri Ekleme
                
                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "Id", "table" => $table, "where" => "id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "DateStart", "table" => $table, "where" => "date_time", "data_item_object" => ">=", "data_key_type" => "date", ); //! Zaman Büyük ve Eşit
                $searchData[] = array("params" => "DateFinish", "table" => $table, "where" => "date_time", "data_item_object" => "<=", "data_key_type" => "date", ); //! Zaman Büyük ve Eşit
                $searchData[] = array("params" => "BusinessAccount", "table" => $table, "where" => "finance_business_account_id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit   
                $searchData[] = array("params" => "Title", "table" => $table, "where" => "title", "data_item_object" => "likeBoth", "data_key_type" => "string", ); //! %A%
                $searchData[] = array("params" => "Type", "table" => $table, "where" => "type_code", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "ActiveType", "table" => $table, "where" => "action_type", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit

                $searchData[] = array("params" => "CurrentCode", "table" => $table, "where" => "current_id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "CurrentName", "table" => $table, "where" => "current_id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit

                //! Where
                $whereData = [];
                $whereData[] = array( "table" => $table, "where" => "type_code" , "data_item_object" => "=", "value" => 1 );
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                $DB["DB_Find_Title"] = "Kasa - Gelir Listesi";
                $DB["DB_Find_Type"] = "Income";
                $DB["DB_Find_Finance_Current_Account"] = "All";

                //! Dashboard Görünümü
                $parameter_dashboardview = request('dashboardview');
                if( request('dashboardview') == null ) { $parameter_dashboardview = 0; }
                else { $parameter_dashboardview = request('dashboardview'); }
                //echo "parameter_dashboardview:"; echo $parameter_dashboardview; die();
                
                $DB["dashboardview"] = $parameter_dashboardview;
                //! Dashboard Görünümü Son

                //! Cari Hesaplar
                $DB_Current_Account = DB::table('finance_current_account')->get(); //Tüm verileri çekiyor
                //echo "<pre>"; print_r($DB_Current_Account); die();
                $DB["DB_Current_Account"] = $DB_Current_Account;
                //! Cari Hesaplar Son 

                //! İş Hesapları
                $DB_Business_Account = DB::table('finance_business_account')->where('type_code','1')->orderBy('title','asc')->get(); //Tüm verileri çekiyor
                //echo "<pre>"; print_r($DB_Business_Account); die();
                $DB["DB_Business_Account"] = $DB_Business_Account;
                //! İş Hesapları Son 

                //! Dashboard
                $DB_Find_Dashboard= DB::table('finance_safe_account')
                ->selectRaw('
                    COUNT(finance_safe_account.id) as totalCount,
                    Format(ROUND(SUM( CASE 
                        WHEN finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPrice,
                    Format(ROUND(SUM(CASE WHEN finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePrice,
                    Format(ROUND(SUM(CASE WHEN finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePrice,

                    COUNT(CASE WHEN finance_safe_account.action_type = 1 THEN 1 END) as totalActiveCount,
                    Format(ROUND(SUM( CASE 
                        WHEN finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalActivePrice,
                        Format(ROUND(SUM(CASE WHEN finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomeActivePrice,
                    Format(ROUND(SUM(CASE WHEN finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpenseActivePrice,

                    COUNT(CASE WHEN finance_safe_account.action_type != 1 THEN 1 END) as totalPasiveCount,
                    Format(ROUND(SUM( CASE 
                        WHEN finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPasivePrice,
                        Format(ROUND(SUM(CASE WHEN finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePasivePrice,
                    Format(ROUND(SUM(CASE WHEN finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePasivePrice,

                    YEAR(NOW()) AS YEAR_NOW,

                    COUNT(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) THEN 1 END) as totalCount_Year,
                    Format(ROUND(SUM( CASE 
                        WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPrice_Year,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePrice_Year,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePrice_Year,

                    COUNT(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type = 1 THEN 1 END) as totalActiveCount_Year,
                    Format(ROUND(SUM( CASE 
                        WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalActivePrice_Year,
                        Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomeActivePrice_Year,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpenseActivePrice_Year,

                    COUNT(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type != 1 THEN 1 END) as totalPasiveCount_Year,
                    Format(ROUND(SUM( CASE 
                        WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPasivePrice_Year,
                        Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePasivePrice_Year,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePasivePrice_Year,

                    MONTH(NOW()) AS MONTH_NOW,

                    COUNT(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) THEN 1 END) as totalCount_Month,
                    Format(ROUND(SUM( CASE 
                        WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPrice_Month,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePrice_Month,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePrice_Month,

                    COUNT(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type = 1 THEN 1 END) as totalActiveCount_Month,
                    Format(ROUND(SUM( CASE 
                        WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalActivePrice_Month,
                        Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomeActivePrice_Month,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpenseActivePrice_Month,

                    COUNT(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type != 1 THEN 1 END) as totalPasiveCount_Month,
                    Format(ROUND(SUM( CASE 
                        WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPasivePrice_Month,
                        Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePasivePrice_Month,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePasivePrice_Month,

                    DATE_FORMAT(date_add(now(), INTERVAL -7 DAY),"%Y-%m-%d") AS WEEK_BEFORE_7DAY,
                    DATE_FORMAT(now(),"%Y-%m-%d") AS DAY_NOW,

                    COUNT(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) THEN 1 END) as totalCount_Week,
                    Format(ROUND(SUM( CASE 
                        WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPrice_Week,
                    Format(ROUND(SUM(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePrice_Week,
                    Format(ROUND(SUM(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePrice_Week,

                    COUNT(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type = 1 THEN 1 END) as totalActiveCount_Week,
                    Format(ROUND(SUM( CASE 
                        WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalActivePrice_Week,
                        Format(ROUND(SUM(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomeActivePrice_Week,
                    Format(ROUND(SUM(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpenseActivePrice_Week,

                    COUNT(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type != 1 THEN 1 END) as totalPasiveCount_Week,
                    Format(ROUND(SUM( CASE 
                        WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPasivePrice_Week,
                        Format(ROUND(SUM(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePasivePrice_Week,
                    Format(ROUND(SUM(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePasivePrice_Week,

                    COUNT(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) THEN 1 END) as totalCount_Today,
                    Format(ROUND(SUM( CASE 
                        WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPrice_Today,
                    Format(ROUND(SUM(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePrice_Today,
                    Format(ROUND(SUM(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePrice_Today,

                    COUNT(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type = 1 THEN 1 END) as totalActiveCount_Today,
                    Format(ROUND(SUM( CASE 
                        WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalActivePrice_Today,
                        Format(ROUND(SUM(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomeActivePrice_Today,
                    Format(ROUND(SUM(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpenseActivePrice_Today,

                    COUNT(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type != 1 THEN 1 END) as totalPasiveCount_Today,
                    Format(ROUND(SUM( CASE 
                        WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPasivePrice_Today,
                        Format(ROUND(SUM(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePasivePrice_Today,
                    Format(ROUND(SUM(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePasivePrice_Today

                ')
                ->where($DB_Find['where'])
                ->get();
                //echo "<pre>"; print_r($DB_Find_Dashboard[0]); die();

                $DB["DB_Find_Dashboard"] =  $DB_Find_Dashboard[0];
                //! Dashboard Son

                //echo "<pre>"; print_r($DB); die();
                
                return view('admin/finance/safe_account',$DB);
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Finans - İşletme Hesap - Gelir Son
    
    //! Finans - İşletme Hesap - Gider
    public function SafeAccountExpense($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "finance_safe_account";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData
                
                  //! Select
                $selectData = [];
                $selectData[] = array( "table" => $table, "parametre" => "*", "name" => null, );
                $selectData[] = array( "table" => 'finance_current_account', "parametre" => "title", "name" => "finance_current_account_title", );
                
                $selectDataRaw = [];  //! Select - Raw

                $joinData = [];  //! Join
                $joinData[] = array( "type" => "LEFT", "table" => "finance_current_account" , "value" => "id", "refTable" => $table, "refValue" => "current_id", ); //! Join Veri Ekleme
                
                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "Id", "table" => $table, "where" => "id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "DateStart", "table" => $table, "where" => "date_time", "data_item_object" => ">=", "data_key_type" => "date", ); //! Zaman Büyük ve Eşit
                $searchData[] = array("params" => "DateFinish", "table" => $table, "where" => "date_time", "data_item_object" => "<=", "data_key_type" => "date", ); //! Zaman Büyük ve Eşit
                $searchData[] = array("params" => "BusinessAccount", "table" => $table, "where" => "finance_business_account_id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit   
                $searchData[] = array("params" => "Title", "table" => $table, "where" => "title", "data_item_object" => "likeBoth", "data_key_type" => "string", ); //! %A%
                $searchData[] = array("params" => "Type", "table" => $table, "where" => "type_code", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "ActiveType", "table" => $table, "where" => "action_type", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit

                $searchData[] = array("params" => "CurrentCode", "table" => $table, "where" => "current_id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "CurrentName", "table" => $table, "where" => "current_id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit

                //! Where
                $whereData = [];
                $whereData[] = array( "table" => $table, "where" => "type_code" , "data_item_object" => "multi", "value" => "2,3" );
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                $DB["DB_Find_Title"] = "Kasa - Gider Listesi";
                $DB["DB_Find_Type"] = "Expense";
                $DB["DB_Find_Finance_Current_Account"] = "All";

                //! Dashboard Görünümü
                $parameter_dashboardview = request('dashboardview');
                if( request('dashboardview') == null ) { $parameter_dashboardview = 0; }
                else { $parameter_dashboardview = request('dashboardview'); }
                //echo "parameter_dashboardview:"; echo $parameter_dashboardview; die();
                
                $DB["dashboardview"] = $parameter_dashboardview;
                //! Dashboard Görünümü Son

                //! Cari Hesaplar
                $DB_Current_Account = DB::table('finance_current_account')->get(); //Tüm verileri çekiyor
                //echo "<pre>"; print_r($DB_Current_Account); die();
                $DB["DB_Current_Account"] = $DB_Current_Account;
                //! Cari Hesaplar Son 

                //! İş Hesapları
                $DB_Business_Account = DB::table('finance_business_account')->where('type_code',[2,3])->orderBy('title','asc')->get(); //Tüm verileri çekiyor
                //echo "<pre>"; print_r($DB_Business_Account); die();
                $DB["DB_Business_Account"] = $DB_Business_Account;
                //! İş Hesapları Son 

                //! Dashboard
                $DB_Find_Dashboard= DB::table('finance_safe_account')
                ->selectRaw('
                    COUNT(finance_safe_account.id) as totalCount,
                    Format(ROUND(SUM( CASE 
                        WHEN finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPrice,
                    Format(ROUND(SUM(CASE WHEN finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePrice,
                    Format(ROUND(SUM(CASE WHEN finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePrice,

                    COUNT(CASE WHEN finance_safe_account.action_type = 1 THEN 1 END) as totalActiveCount,
                    Format(ROUND(SUM( CASE 
                        WHEN finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalActivePrice,
                        Format(ROUND(SUM(CASE WHEN finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomeActivePrice,
                    Format(ROUND(SUM(CASE WHEN finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpenseActivePrice,

                    COUNT(CASE WHEN finance_safe_account.action_type != 1 THEN 1 END) as totalPasiveCount,
                    Format(ROUND(SUM( CASE 
                        WHEN finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPasivePrice,
                        Format(ROUND(SUM(CASE WHEN finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePasivePrice,
                    Format(ROUND(SUM(CASE WHEN finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePasivePrice,

                    YEAR(NOW()) AS YEAR_NOW,

                    COUNT(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) THEN 1 END) as totalCount_Year,
                    Format(ROUND(SUM( CASE 
                        WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPrice_Year,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePrice_Year,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePrice_Year,

                    COUNT(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type = 1 THEN 1 END) as totalActiveCount_Year,
                    Format(ROUND(SUM( CASE 
                        WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalActivePrice_Year,
                        Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomeActivePrice_Year,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpenseActivePrice_Year,

                    COUNT(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type != 1 THEN 1 END) as totalPasiveCount_Year,
                    Format(ROUND(SUM( CASE 
                        WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPasivePrice_Year,
                        Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePasivePrice_Year,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(finance_safe_account.date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePasivePrice_Year,

                    MONTH(NOW()) AS MONTH_NOW,

                    COUNT(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) THEN 1 END) as totalCount_Month,
                    Format(ROUND(SUM( CASE 
                        WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPrice_Month,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePrice_Month,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePrice_Month,

                    COUNT(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type = 1 THEN 1 END) as totalActiveCount_Month,
                    Format(ROUND(SUM( CASE 
                        WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalActivePrice_Month,
                        Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomeActivePrice_Month,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpenseActivePrice_Month,

                    COUNT(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type != 1 THEN 1 END) as totalPasiveCount_Month,
                    Format(ROUND(SUM( CASE 
                        WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPasivePrice_Month,
                        Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePasivePrice_Month,
                    Format(ROUND(SUM(CASE WHEN (YEAR(NOW()) = YEAR(date_time) AND MONTH(NOW()) = MONTH(date_time)) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePasivePrice_Month,

                    DATE_FORMAT(date_add(now(), INTERVAL -7 DAY),"%Y-%m-%d") AS WEEK_BEFORE_7DAY,
                    DATE_FORMAT(now(),"%Y-%m-%d") AS DAY_NOW,

                    COUNT(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) THEN 1 END) as totalCount_Week,
                    Format(ROUND(SUM( CASE 
                        WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPrice_Week,
                    Format(ROUND(SUM(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePrice_Week,
                    Format(ROUND(SUM(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePrice_Week,

                    COUNT(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type = 1 THEN 1 END) as totalActiveCount_Week,
                    Format(ROUND(SUM( CASE 
                        WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalActivePrice_Week,
                        Format(ROUND(SUM(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomeActivePrice_Week,
                    Format(ROUND(SUM(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpenseActivePrice_Week,

                    COUNT(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type != 1 THEN 1 END) as totalPasiveCount_Week,
                    Format(ROUND(SUM( CASE 
                        WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPasivePrice_Week,
                        Format(ROUND(SUM(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePasivePrice_Week,
                    Format(ROUND(SUM(CASE WHEN ( date_time BETWEEN date_add(now(), INTERVAL -7 DAY) AND now() ) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePasivePrice_Week,

                    COUNT(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) THEN 1 END) as totalCount_Today,
                    Format(ROUND(SUM( CASE 
                        WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPrice_Today,
                    Format(ROUND(SUM(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePrice_Today,
                    Format(ROUND(SUM(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePrice_Today,

                    COUNT(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type = 1 THEN 1 END) as totalActiveCount_Today,
                    Format(ROUND(SUM( CASE 
                        WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalActivePrice_Today,
                        Format(ROUND(SUM(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type = 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomeActivePrice_Today,
                    Format(ROUND(SUM(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type = 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpenseActivePrice_Today,

                    COUNT(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type != 1 THEN 1 END) as totalPasiveCount_Today,
                    Format(ROUND(SUM( CASE 
                        WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) 
                        WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN  -(finance_safe_account.price * finance_safe_account.quantity) 
                        ELSE 0 END )),3,"#,##0.000") as totalPasivePrice_Today,
                        Format(ROUND(SUM(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type != 1 AND finance_safe_account.type = "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalIncomePasivePrice_Today,
                    Format(ROUND(SUM(CASE WHEN (DATE_FORMAT(now(),"%Y-%m-%d") = DATE_FORMAT(date_time,"%Y-%m-%d")) AND finance_safe_account.action_type != 1 AND finance_safe_account.type != "Gelir" THEN (finance_safe_account.price * finance_safe_account.quantity) ELSE 0 END),3),3,"#,##0.000") as totalExpensePasivePrice_Today

                ')
                ->where($DB_Find['where'])
                ->get();
                //echo "<pre>"; print_r($DB_Find_Dashboard[0]); die();

                $DB["DB_Find_Dashboard"] =  $DB_Find_Dashboard[0];
                //! Dashboard Son

                //echo "<pre>"; print_r($DB); die();
                
                return view('admin/finance/safe_account',$DB);
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Finans - İşletme Hesap - Gider Son
    
    //************* Firma - Kategori  ***************** */

    //! Firma - Kategori
    public function CompanyCategory($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "company_categories";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData
                $selectData = [];  //! Select
                $selectDataRaw = [];  //! Select - Raw
                $joinData = [];  //! Join

                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "uid", "table" => $table, "where" => "uid", "data_item_object" => "=", "data_key_type" => "string", ); //! Eşit
                $searchData[] = array("params" => "Status", "table" => $table, "where" => "isActive", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                
                $whereData = []; //! Where
                $whereData[] = array( "table" => $table, "where" => "lang" , "data_item_object" => "=", "value" => __('admin.lang') ); //! Arama
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                
                return view('admin/company/company_category',$DB);
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Firma - Kategori Son

    //! Firma - Kategori- Arama Post
    public function CompanyCategorySearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('company_categories')->where('uid',$request->uid)->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
   
            if( count($DB_Find) > 0 ) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
                  'error' => null, 
               );
   
               return response()->json($response);
            }
   
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' => __('admin.transactionFailed'),
               'DB' =>  [],
               'error' => $th,            
            );
   
            return response()->json($response);
        }

    } //! Firma - Kategori - Arama Post Son

    //! Firma - Kategori - Veri Ekleme Post
    public function CompanyCategoryAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            
            //! Tanım
            $tableName = 'company_categories'; //! Tablo Adı
            $time = time(); //! uid
            $langList = ['tr','en','de']; //! Dil
            $DB_Count = 0; //! Veri Sayısı
           
            for ($i=0; $i < count($langList) ; $i++) { 
                $lang = $langList[$i];

                if($lang == "tr"){  $title = $request->title_tr; }
                if($lang == "en"){  $title = $request->title_en; }
                if($lang == "de"){  $title = $request->title_de; }

                //! Ekleme
                if($title != "") { 
                    $DB_Count++; //! Veri Sayısı Artır

                    //! Veri Ekleme - TR
                    DB::table($tableName)->insert([
                        'lang' => $lang,
                        'uid' => $time,
                        'title' => $title,
                        'created_byId'=>$request->created_byId,
                    ]); //! Veri Ekleme - TR Son

                }

            }
           
            $response = array(
                'status' => $DB_Count > 0 ? 'success' : 'error',
                'msg' =>  $DB_Count > 0  ? __('admin.transactionSuccessful') : __('admin.dataNotFound'),
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

    } //! Firma - Kategori - Veri Ekleme Post Son

    //! Firma - Kategori - Veri Silme Post
    public function CompanyCategoryDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'company_categories';
            $DB_Find = DB::table($table)->where('uid',$request->uid)->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Silme
                $DB_Status = DB::table($table)->where('uid',$request->uid)->delete();

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

    } //! Firma - Kategori - Veri Silme Post Son

    //! Firma - Kategori - Veri Çoklu Silme Post
    public function CompanyCategoryDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Silme
            $DB_Status = DB::table('company_categories')->whereIn('uid',$request->uids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Firma - Kategori - Veri Çoklu Silme Post Son

    //! Firma - Kategori - Veri Güncelleme Post
    public function CompanyCategoryEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
            
            //! Tanım
            $table = 'company_categories'; //! Tablo Adı
            $langList = ['tr','en','de']; //! Dil
            $DB_Count = 0; //! Veri Sayısı
            
            for ($i=0; $i < count($langList) ; $i++) { 
                $lang = $langList[$i];

                if($lang == "tr"){  $title = $request->title_tr; }
                if($lang == "en"){  $title = $request->title_en; }
                if($lang == "de"){  $title = $request->title_de; }
                
                $DB = DB::table($table)->where('lang',$lang)->where('uid',$request->uid); //Veri Tabanı
                $DB_Find = $DB->get(); //Tüm verileri çekiyor
                //echo "<pre>"; print_r($DB_Find); die();

                if( count($DB_Find) > 0 ) {  
                    $DB_Count++; //! Veri Sayısı Artır

                    //! Sil
                    if($title == "") { DB::table($table)->where('lang',$lang)->where('uid',$request->uid)->delete();  }
                    else {
                        
                        //! Veri Güncelle
                        DB::table($table)
                        ->where('lang',$lang)
                        ->where('uid',$request->uid)
                        ->update([            
                            'title' => $title,
                            'isUpdated'=>true,
                            'updated_at'=>Carbon::now(),
                            'updated_byId'=>$request->updated_byId,
                        ]);  //! Veri Güncelle Son

                    }
                }
                else { 
                
                    if($title != "") {

                        //! Veri Ekleme 
                        DB::table($table)->insert([
                            'lang' => $lang,
                            'uid' => $request->uid,
                            'title' => $title,
                            'created_byId'=>$request->created_byId,
                        ]); //! Veri Ekleme Son
                    }

                }
            }
            
            $response = array(
                'status' => $DB_Count > 0 ? 'success' : 'error',
                'msg' =>  $DB_Count > 0  ? __('admin.transactionSuccessful') : __('admin.dataNotFound'),
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

    } //! Firma - Kategori - Veri Güncelleme Post Son 
            
    //! Firma - Kategori - Veri Durum Güncelleme Post
    public function CompanyCategoryEditActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $DB = DB::table('company_categories')->where('uid',$request->uid); //Veri Tabanı
            $DB_Find = $DB->get(); //Tüm verileri çekiyor

            if( count($DB_Find) > 0 ) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'isActive'=>$request->active == "true" ? true : false,
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

    } //! Firma - Kategori - Veri Durum Güncelleme Post Son

    //! Firma - Kategori  - Çoklu Veri Durum Güncelle - Post
    public function CompanyCategoryEditMultiActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Güncelleme
            $DB_Status = DB::table('company_categories')->whereIn('uid',$request->uids)
            ->update([  
                'isActive'=>$request->active == "true" ? true : false,
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

        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );

            return response()->json($response);
        }

    } //! Firma - Kategori- Çoklu Veri Durum Günceleme - Post Son

    //!  Firma - Kategori - Clone - Post
    public function CompanyCategoryClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'company_categories';
            $DB = DB::table($table)->where('uid',$request->uid); //VeriTabanı
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();

            if( count($DB_Find) > 0 ){  

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri
                $time = time(); //! uid

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->uid); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->uid = $time; //! Veri Güncelle
                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData; //! Ekleme
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
                    'error' => null,
                    'addNewId' => $time,
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

    } //!  Firma - Kategori - Clone - Post Son

    //!  Firma - Kategori - Çoklu Clone - Post
    public function CompanyCategoryClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $table = 'company_categories';
            $dbFind_uids = $request->uids;
            $dbFind_uids_count = count($dbFind_uids);
            //echo "sayisi: "; echo $dbFind_uids_count; die();

            if( $dbFind_uids_count > 0 ){ 
                        
                //! Veri Arama
                $DB = DB::table($table)->whereIn('uid',$dbFind_uids); //VeriTabanı
                $DB_Find = $DB->get(); //Tüm verileri çekiyor
                //echo "<pre>"; print_r($DB_Find); die();

                if( count($DB_Find) > 0 ){  

                    //! Tanım
                    $DB_FindInsert = []; //! Eklenecek Veri

                    for ($j=0; $j < $dbFind_uids_count; $j++) { 
                        $time = time()+$j; //! uid

                        for ($i=0; $i < count($DB_Find); $i++) {  
                            if( $DB_Find[$i]->uid == $dbFind_uids[$j] ) {
                                //echo $DB_Find[$i]->uid; echo " ";
                            
                                //! Veri Silme
                                unset($DB_Find[$i]->id); //! Veri Silme 
                                unset($DB_Find[$i]->uid); //! Veri Silme 
                                unset($DB_Find[$i]->created_at); //! Veri Silme 
                                unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                                unset($DB_Find[$i]->updated_at); //! Veri Silme 
                                unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                                unset($DB_Find[$i]->isActive); //! Veri Silme 
                                unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                                unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                                unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                                $DB_Find[$i]->uid = $time; //! Veri Güncelle
                                $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                                //! Yeni Data
                                $newData = array(); //! Eklenecek Veri 
                                $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                                
                                //! Veriler
                                for ($k=0; $k < count($table_columns); $k++) { 
                                    $col=$table_columns[$k];
                                    $newData[$col] = $DB_Find->pluck($col)[$i];
                                }
                                //! Veriler Son
                            
                                $DB_FindInsert[] = $newData; //! Ekleme
                            }
                        }

                    }

                    //! Veri Ekleme
                    $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                    $response = array(
                        'status' => $addNewStatus ? 'success' : 'error',
                        'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

            }
            else {
    
               $response = array(
                  'status' => 'error',
                  'msg' => "uid:".__('admin.dataNotFound'),
                  'error' => null,
               );
    
               return response()->json($response);
            }
    
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' =>  __('admin.transactionFailed'),
               'error' => $th,            
            );
    
            return response()->json($response);
        }

    } //!  Firma - Kategori - Çoklu Clone - Post Son
    

   //************* Firma ***************** */

    //! Firma List
    public function CompanyList($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 
            
            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "company";

                //! Bilgiler
                $infoData = [];
                $infoData[] = array( "page" => 1, "rowcount" => 15, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler

                $groupData = []; //! GroupData

                //! Select
                $selectData = [];
                $selectData[] = array( "table" => $table, "parametre" => "*", "name" => null, );
                $selectData[] = array( "table" => "company_categories", "parametre" => "title", "name" => "companyCategoryTitle", );

                $selectDataRaw = [];  //! Select - Raw

                //! Join
                $joinData = [];  //! Join
                $joinData[] = array( "type" => "LEFT", "table" => "company_categories" , "value" => "uid", "refTable" => $table, "refValue" => "category", ); //! Join Veri Ekleme

                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "Id", "table" => $table, "where" => "id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "Status", "table" => $table, "where" => "isActive", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit

                //! Where
                $whereData = [];
                //$whereData[] = array( "table" => $table, "where" => "value" , "data_item_object" => "=", "value" => 788 );
               
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();
                    
                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                return view('admin/company/companyList',$DB);
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Firma List Son

    //! Firma - Arama Post
    public function CompanySearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('company')->where('id',$request->id)->first(); //Tüm verileri çekiyor
   
            if($DB_Find) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
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

    } //! Firma - Arama Post Son

    //! Firma - Veri Ekleme Sayfası
    public function CompanyAddView($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();
                
                
                //! Firma Kategorisi
                $DB_Find_company_categories= DB::table('company_categories')->where('lang','=',__('admin.lang'))->get();
                //echo "<pre>"; print_r($DB_Find_company_categories); die();
                
                $DB["DB_Find_company_categories"] = $DB_Find_company_categories;
                //! Firma Kategorisi Son

                //! Return
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                return view('admin/company/companyAdd',$DB);
              
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
          
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Firma - Veri Ekleme Sayfası Son

    //! Firma - Veri Ekleme Post
    public function CompanyAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Ekleme
            DB::table('company')->insert([
                'category' => $request->category,
                'company_name' => $request->company_name,
                'description' => $request->description,

                'authorized_person' => $request->authorized_person,
                'authorized_person_role' => $request->authorized_person_role,
                'authorized_person_tel' => $request->authorized_person_tel,
                'authorized_person_mail' => $request->authorized_person_mail,

                'web_address1' => $request->web_address1,
                'web_address2' => $request->web_address2,

                'tel1' => $request->tel1,
                'tel2' => $request->tel2,
                'email' => $request->email,
                'email2' => $request->email2,

                'country' => $request->country,
                'city' => $request->city,
                'district' => $request->district,
                'neighborhood' => $request->neighborhood,
                'address' => $request->address,
                
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

    } //! Firma - Veri Ekleme Post Son

    //! Firma - Veri Silme Post
    public function CompanyDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'company';
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

    } //! Firma - Veri Silme Post Son

    //! Firma - Veri Çoklu Silme Post
    public function CompanyDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Silme
            $DB_Status = DB::table('company')->whereIn('id',$request->ids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Firma - Veri Çoklu Silme Post Son

    //! Firma - Veri Güncelleme Sayfası
    public function CompanyEdit($site_lang="tr",$id)
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Arama
                $DB_Find = DB::table('company')->where('id',$id)->first(); //Tüm verileri çekiyor

                if($DB_Find) {

                    //! Firma Kategorisi
                    $DB_Find_company_categories= DB::table('company_categories')->where('lang','=',__('admin.lang'))->get();
                    //echo "<pre>"; print_r($DB_Find_company_categories); die();
                    
                    //! Return
                    $DB["CookieData"] = $CookieControl["CookieDataList"];
                    $DB["DB_Find"] =  $DB_Find;
                    $DB["DB_Find_company_categories"] =  $DB_Find_company_categories;

                    //echo "<pre>"; print_r($DB); die();

                    return view('admin/company/companyEdit',$DB);
                }
                else { return view('error404'); }
            
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
           
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Firma - Veri Güncelleme Sayfası Son

    //! Firma - Veri Güncelleme Post
    public function CompanyEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB = DB::table('company')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([      
                    'category' => $request->category,      
                    'company_name' => $request->company_name,
                    'description' => $request->description,

                    'authorized_person' => $request->authorized_person,
                    'authorized_person_role' => $request->authorized_person_role,
                    'authorized_person_tel' => $request->authorized_person_tel,
                    'authorized_person_mail' => $request->authorized_person_mail,

                    'web_address1' => $request->web_address1,
                    'web_address2' => $request->web_address2,

                    'tel1' => $request->tel1,
                    'tel2' => $request->tel2,
                    'email' => $request->email,
                    'email2' => $request->email2,

                    'country' => $request->country,
                    'city' => $request->city,
                    'district' => $request->district,
                    'neighborhood' => $request->neighborhood,
                    'address' => $request->address,
                    
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

    } //! Firma - Veri Güncelleme Post Son

    //! Firma - Veri Durum Güncelleme Post
    public function CompanyEditActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $DB = DB::table('company')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'isActive'=>$request->active == "true" ? true : false,
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

    } //! Firma - Veri Durum Güncelleme Post Son

    //! Firma - Çoklu Veri Durum Güncelle - Post
    public function CompanyEditMultiActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Güncelleme
            $DB_Status = DB::table('company')->whereIn('id',$request->ids)
            ->update([  
                'isActive'=>$request->active == "true" ? true : false,
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

        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );

            return response()->json($response);
        }

    } //! Firma - Çoklu Veri Durum Güncelle - Post Son

    //! Firma -Clone - Post
    public function CompanyEditClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'company';
            $DB = DB::table($table)->where('id',$request->id); //VeriTabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) { 
            
                //! Verileri Ayarlıyor
                unset($DB_Find->id); //! Veri Silme 
                unset($DB_Find->created_at); //! Veri Silme 
                unset($DB_Find->isUpdated); //! Veri Silme 
                unset($DB_Find->updated_at); //! Veri Silme 
                unset($DB_Find->updated_byId); //! Veri Silme 
                unset($DB_Find->isActive); //! Veri Silme 
                unset($DB_Find->isDeleted); //! Veri Silme 
                unset($DB_Find->deleted_at); //! Veri Silme 
                unset($DB_Find->deleted_byId); //! Veri Silme 

                $DB_Find->created_byId = $request->created_byId; //! Veri Güncelle
            
                //! Tanım
                $newData = array(); //! Eklenecek Veri 
                $table_columns = array_keys(json_decode(json_encode($DB_Find), true));  //! Sutun Veriler
            
                //! Veriler
                for ($i=0; $i < count($table_columns); $i++) { 
                    $col=$table_columns[$i];
                    $newData[$col] = $DB->pluck($col)[0];
                }
                //! Veriler Son

                //$newData['img_url'] = config('admin.Default_UserImgUrl');
                $newData['created_byId'] = $request->created_byId;

                //! Veri Ekleme
                $addNewId = DB::table($table)->insertGetId($newData); //! Veri Ekleme Son

                $response = array(
                    'status' => 'success',
                    'msg' => __('admin.transactionSuccessful'),
                    'error' => null, 
                    'addNewId' => $addNewId,
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

    } //! Firma - Clone - Post Son

    //! Firma - Çoklu Clone - Post
    public function CompanyEditClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $table = 'company';
            $DB = DB::table($table)->whereIn('id',$request->ids);
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if( count($DB_Find) > 0 ){ 

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData;
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Firma - Çoklu Clone - Post Son

    
    //************* Toplantılar  ***************** */

    //! Toplantılar
    public function Meetings($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "meetings";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData
                $selectData = [];  //! Select
                $selectDataRaw = [];  //! Select - Raw
                $joinData = [];  //! Join

                $searchData = []; //! Arama
                $searchData[] = array("params" => "Status", "table" => $table, "where" => "isActive", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "BusinessStatus", "table" => $table, "where" => "businessStatus", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit

                $whereData = []; //! Where
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                
                return view('admin/meetings/meetings',$DB);
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Toplantılar Son

    //! Toplantılar - Arama Post
    public function MeetingsSearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('meetings')->where('id',$request->id)->first(); //Tüm verileri çekiyor
   
            if($DB_Find) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
                  'error' => null, 
               );
   
               return response()->json($response);
            }
   
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' => __('admin.transactionFailed'),
               'DB' =>  [],
               'error' => $th,            
            );
   
            return response()->json($response);
        }

    } //! Toplantılar - Arama Post Son

    //! Toplantılar - Veri Ekleme Post
    public function MeetingsAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Ekleme
            DB::table('meetings')->insert([
                'date' => $request->date,
                'time' => $request->time,
                'interviewee' => $request->interviewee,
                'isActive' => $request->isActive,
                'businessStatus' => $request->businessStatus,
                'description' => $request->description,
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

    } //! Toplantılar - Veri Ekleme Post Son

    //! Toplantılar - Veri Silme Post
    public function MeetingsDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'meetings';
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

    } //! Toplantılar- Veri Silme Post Son

    //! Toplantılar - Veri Çoklu Silme Post
    public function MeetingsDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Silme
            $DB_Status = DB::table('meetings')->whereIn('id',$request->ids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Toplantılar- Veri Çoklu Silme Post Son

    //! Toplantılar - Veri Güncelleme Post
    public function MeetingsEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB = DB::table('meetings')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'date' => $request->date,
                    'time' => $request->time,
                    'interviewee' => $request->interviewee,
                    'isActive' => $request->isActive,
                    'businessStatus' => $request->businessStatus,
                    'description' => $request->description,
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

    } //! Toplantılar - Veri Güncelleme Post Son  
    
    //! Toplantılar - Veri Durum Güncelleme Post
    public function MeetingsEditActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $DB = DB::table('meetings')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'isActive'=>$request->active == "true" ? true : false,
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

    } //! Toplantılar - Veri Durum Güncelleme Post Son

    //! Toplantılar - Çoklu Veri Durum Güncelle - Post
    public function MeetingsEditMultiActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Güncelleme
            $DB_Status = DB::table('meetings')->whereIn('id',$request->ids)
            ->update([  
                'isActive'=>$request->active == "true" ? true : false,
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

        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );

            return response()->json($response);
        }

    } //! Toplantılar - Çoklu Veri Durum Güncelle - Post Son
    
    //! Toplantılar -Clone - Post
    public function MeetingsClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'meetings';
            $DB = DB::table($table)->where('id',$request->id); //VeriTabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) { 
            
                //! Verileri Ayarlıyor
                unset($DB_Find->id); //! Veri Silme 
                unset($DB_Find->created_at); //! Veri Silme 
                unset($DB_Find->isUpdated); //! Veri Silme 
                unset($DB_Find->updated_at); //! Veri Silme 
                unset($DB_Find->updated_byId); //! Veri Silme 
                unset($DB_Find->isActive); //! Veri Silme 
                unset($DB_Find->isDeleted); //! Veri Silme 
                unset($DB_Find->deleted_at); //! Veri Silme 
                unset($DB_Find->deleted_byId); //! Veri Silme 

                $DB_Find->created_byId = $request->created_byId; //! Veri Güncelle
            
                //! Tanım
                $newData = array(); //! Eklenecek Veri 
                $table_columns = array_keys(json_decode(json_encode($DB_Find), true));  //! Sutun Veriler
            
                //! Veriler
                for ($i=0; $i < count($table_columns); $i++) { 
                    $col=$table_columns[$i];
                    $newData[$col] = $DB->pluck($col)[0];
                }
                //! Veriler Son

                //$newData['img_url'] = config('admin.Default_UserImgUrl');
                $newData['created_byId'] = $request->created_byId;

                //! Veri Ekleme
                $addNewId = DB::table($table)->insertGetId($newData); //! Veri Ekleme Son

                $response = array(
                    'status' => 'success',
                    'msg' => __('admin.transactionSuccessful'),
                    'error' => null, 
                    'addNewId' => $addNewId,
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

    } //! Toplantılar - Clone - Post Son

    //! Toplantılar - Çoklu Clone - Post
    public function MeetingsClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $table = 'meetings';
            $DB = DB::table($table)->whereIn('id',$request->ids);
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if( count($DB_Find) > 0 ){ 

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData;
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Toplantılar - Çoklu Clone - Post Son
     
    //************* Service - Kategori  ***************** */

    //! Service - Kategori
    public function ServiceCategory($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "service_categories";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData
                $selectData = [];  //! Select
                $selectDataRaw = [];  //! Select - Raw
                $joinData = [];  //! Join

                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "uid", "table" => $table, "where" => "uid", "data_item_object" => "=", "data_key_type" => "string", ); //! Eşit
                $searchData[] = array("params" => "Status", "table" => $table, "where" => "isActive", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                
                $whereData = []; //! Where
                $whereData[] = array( "table" => $table, "where" => "lang" , "data_item_object" => "=", "value" => __('admin.lang') ); //! Arama
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                
                return view('admin/web/service/service_category',$DB);
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Service - Kategori Son

    //! Service - Kategori- Arama Post
    public function ServiceCategorySearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('service_categories')->where('uid',$request->uid)->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
   
            if( count($DB_Find) > 0 ) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
                  'error' => null, 
               );
   
               return response()->json($response);
            }
   
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' => __('admin.transactionFailed'),
               'DB' =>  [],
               'error' => $th,            
            );
   
            return response()->json($response);
        }

    } //! Service - Kategori - Arama Post Son

    //! Service - Kategori - Veri Ekleme Post
    public function ServiceCategoryAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
            
            //! Tanım
            $tableName = 'service_categories'; //! Tablo Adı
            $time = time(); //! uid
            $langList = ['tr','en','de']; //! Dil
            $DB_Count = 0; //! Veri Sayısı
           
            for ($i=0; $i < count($langList) ; $i++) { 
                $lang = $langList[$i];

                if($lang == "tr"){  $title = $request->title_tr; }
                if($lang == "en"){  $title = $request->title_en; }
                if($lang == "de"){  $title = $request->title_de; }

                //! Ekleme
                if($title != "") { 
                    $DB_Count++; //! Veri Sayısı Artır

                    //! Veri Ekleme - TR
                    DB::table($tableName)->insert([
                        'lang' => $lang,
                        'uid' => $time,
                        'title' => $title,
                        'created_byId'=>$request->created_byId,
                    ]); //! Veri Ekleme - TR Son

                }

            }
           
            $response = array(
                'status' => $DB_Count > 0 ? 'success' : 'error',
                'msg' =>  $DB_Count > 0  ? __('admin.transactionSuccessful') : __('admin.dataNotFound'),
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

    } //! Service - Kategori - Veri Ekleme Post Son

    //! Service - Kategori - Veri Silme Post
    public function ServiceCategoryDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'service_categories';
            $DB_Find = DB::table($table)->where('uid',$request->uid)->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Silme
                $DB_Status = DB::table($table)->where('uid',$request->uid)->delete();

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

    } //! Service - Kategori - Veri Silme Post Son

    //! Service - Kategori - Veri Çoklu Silme Post
    public function ServiceCategoryDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Silme
            $DB_Status = DB::table('service_categories')->whereIn('uid',$request->uids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Service - Kategori - Veri Çoklu Silme Post Son

    //! Service - Kategori - Veri Güncelleme Post
    public function ServiceCategoryEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
            
            //! Tanım
            $table = 'service_categories'; //! Tablo Adı
            $langList = ['tr','en','de']; //! Dil
            $DB_Count = 0; //! Veri Sayısı
            
            for ($i=0; $i < count($langList) ; $i++) { 
                $lang = $langList[$i];

                if($lang == "tr"){  $title = $request->title_tr; }
                if($lang == "en"){  $title = $request->title_en; }
                if($lang == "de"){  $title = $request->title_de; }
                
                $DB = DB::table($table)->where('lang',$lang)->where('uid',$request->uid); //Veri Tabanı
                $DB_Find = $DB->get(); //Tüm verileri çekiyor
                //echo "<pre>"; print_r($DB_Find); die();

                if( count($DB_Find) > 0 ) {  
                    $DB_Count++; //! Veri Sayısı Artır

                    //! Sil
                    if($title == "") { DB::table($table)->where('lang',$lang)->where('uid',$request->uid)->delete();  }
                    else {
                        
                        //! Veri Güncelle
                        DB::table($table)
                        ->where('lang',$lang)
                        ->where('uid',$request->uid)
                        ->update([            
                            'title' => $title,
                            'isUpdated'=>true,
                            'updated_at'=>Carbon::now(),
                            'updated_byId'=>$request->updated_byId,
                        ]);  //! Veri Güncelle Son

                    }
                }
                else { 
                
                    if($title != "") {

                        //! Veri Ekleme 
                        DB::table($table)->insert([
                            'lang' => $lang,
                            'uid' => $request->uid,
                            'title' => $title,
                            'created_byId'=>$request->created_byId,
                        ]); //! Veri Ekleme Son
                    }

                }
            }
            
            $response = array(
                'status' => $DB_Count > 0 ? 'success' : 'error',
                'msg' =>  $DB_Count > 0  ? __('admin.transactionSuccessful') : __('admin.dataNotFound'),
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

    } //! Service - Kategori - Veri Güncelleme Post Son 
            
    //! Service - Kategori  - Veri Durum Güncelleme Post
    public function ServiceCategoryEditActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $DB = DB::table('service_categories')->where('uid',$request->uid); //Veri Tabanı
            $DB_Find = $DB->get(); //Tüm verileri çekiyor

            if( count($DB_Find) > 0 ) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'isActive'=>$request->active == "true" ? true : false,
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

    } //! Service - Kategori  - Veri Durum Güncelleme Post Son
        
    //! Service - Kategori   - Çoklu Veri Durum Güncelle - Post
    public function ServiceCategoryEditMultiActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Güncelleme
            $DB_Status = DB::table('service_categories')->whereIn('uid',$request->uids)
            ->update([  
                'isActive'=>$request->active == "true" ? true : false,
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

        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );

            return response()->json($response);
        }

    } //! Service - Kategori   - Çoklu Veri Durum Günceleme - Post Son

    //!  Service - Kategori - Clone - Post
    public function ServiceCategoryClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'service_categories';
            $DB = DB::table($table)->where('uid',$request->uid); //VeriTabanı
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();

            if( count($DB_Find) > 0 ){  

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri
                $time = time(); //! uid

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->uid); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->uid = $time; //! Veri Güncelle
                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData; //! Ekleme
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
                    'error' => null,
                    'addNewId' => $time,
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

    } //!  Service - Kategori - Clone - Post Son

    //!  Service - Kategori - Çoklu Clone - Post
    public function ServiceCategoryClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $table = 'service_categories';
            $dbFind_uids = $request->uids;
            $dbFind_uids_count = count($dbFind_uids);
            //echo "sayisi: "; echo $dbFind_uids_count; die();

            if( $dbFind_uids_count > 0 ){ 
                        
                //! Veri Arama
                $DB = DB::table($table)->whereIn('uid',$dbFind_uids); //VeriTabanı
                $DB_Find = $DB->get(); //Tüm verileri çekiyor
                //echo "<pre>"; print_r($DB_Find); die();

                if( count($DB_Find) > 0 ){  

                    //! Tanım
                    $DB_FindInsert = []; //! Eklenecek Veri

                    for ($j=0; $j < $dbFind_uids_count; $j++) { 
                        $time = time()+$j; //! uid

                        for ($i=0; $i < count($DB_Find); $i++) {  
                            if( $DB_Find[$i]->uid == $dbFind_uids[$j] ) {
                                //echo $DB_Find[$i]->uid; echo " ";
                            
                                //! Veri Silme
                                unset($DB_Find[$i]->id); //! Veri Silme 
                                unset($DB_Find[$i]->uid); //! Veri Silme 
                                unset($DB_Find[$i]->created_at); //! Veri Silme 
                                unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                                unset($DB_Find[$i]->updated_at); //! Veri Silme 
                                unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                                unset($DB_Find[$i]->isActive); //! Veri Silme 
                                unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                                unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                                unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                                $DB_Find[$i]->uid = $time; //! Veri Güncelle
                                $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                                //! Yeni Data
                                $newData = array(); //! Eklenecek Veri 
                                $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                                
                                //! Veriler
                                for ($k=0; $k < count($table_columns); $k++) { 
                                    $col=$table_columns[$k];
                                    $newData[$col] = $DB_Find->pluck($col)[$i];
                                }
                                //! Veriler Son
                            
                                $DB_FindInsert[] = $newData; //! Ekleme
                            }
                        }

                    }

                    //! Veri Ekleme
                    $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                    $response = array(
                        'status' => $addNewStatus ? 'success' : 'error',
                        'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

            }
            else {
    
               $response = array(
                  'status' => 'error',
                  'msg' => "uid:".__('admin.dataNotFound'),
                  'error' => null,
               );
    
               return response()->json($response);
            }
    
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' =>  __('admin.transactionFailed'),
               'error' => $th,            
            );
    
            return response()->json($response);
        }

    } //!  Service - Kategori - Çoklu Clone - Post Son

    //************* Service ***************** */

    //! Service
    public function ServiceList($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {  

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "services";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData
                $selectData = [];  //! Select
                $selectDataRaw = [];  //! Select - Raw
                $joinData = [];  //! Join

                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "uid", "table" => $table, "where" => "uid", "data_item_object" => "=", "data_key_type" => "string", ); //! Eşit
                $searchData[] = array("params" => "Status", "table" => $table, "where" => "isActive", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                
                $whereData = []; //! Where
                $whereData[] = array( "table" => $table, "where" => "lang" , "data_item_object" => "=", "value" => __('admin.lang') ); //! Arama
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find; 
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                return view('admin/web/service/serviceList',$DB); 
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Service Son

    //! Service- Arama Post
    public function ServiceSearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('services')->where('id',$request->id)->first(); //Tüm verileri çekiyor
   
            if($DB_Find) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
                  'error' => null,
               );
   
               return response()->json($response);
            }
   
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' => __('admin.transactionFailed'),
               'DB' =>  [],
               'error' => $th,            
            );
   
            return response()->json($response);
        }

    } //! Service- Arama Post Son

    //! Service - Veri Ekleme Sayfası
    public function ServiceAddView($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Ürün Kategori
                $DB_Find_service_categories= DB::table('service_categories')->where('lang','=',__('admin.lang'))->get();
                //echo "<pre>"; print_r($DB_Find_service_categories); die();
                
                $DB["DB_Find_service_categories"] = $DB_Find_service_categories;
                //! Ürün Kategori Son
                
                //! Return
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                return view('admin/web/service/serviceListAdd',$DB); 
                
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
            
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Service - Veri Ekleme Sayfası Son

    //! Service- Veri Ekleme Post
    public function ServiceAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //veri tabanı işlemleri
            $table = 'services';
            $DB = DB::table($table)->where('lang','=',$request->lang)->where('uid','=',$request->uid);
            $DB_Find = $DB->first(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if($DB_Find) {

                 //! Veri Güncelle
                 $DB_Status = $DB->update([            
                    'img_url' => $request->imgUrl,
                    'category' => $request->category,
                    'title' => $request->title,
                    'seo_url' => SEOLink($request->title),
                    'description' => $request->description,
                    'seo_keywords' => $request->seo_keywords,
                    'isUpdated'=>true,
                    'updated_at'=>Carbon::now(),
                    'updated_byId'=>$request->created_byId,
                ]);
            }
            else{

                //! Veri Ekleme
                $DB_Status = DB::table($table)->insert([
                    'lang' => $request->lang,
                    'uid' => $request->uid,
                    'img_url' => $request->imgUrl,
                    'category' => $request->category,
                    'title' => $request->title,
                    'seo_url' => SEOLink($request->title),
                    'description' => $request->description,
                    'seo_keywords' => $request->seo_keywords,
                    'created_byId'=>$request->created_byId,
                ]); //! Veri Ekleme Son

            }

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Service- Veri Ekleme Post Son
    
    //! Service- Veri Silme Post
    public function ServiceDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'services';
            $DB_Find = DB::table($table)->where('uid','=',$request->uid)->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Silme
                $DB_Status = DB::table($table)->where('uid','=',$request->uid)->delete();

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

    } //! Service- Veri Silme Post Son

    //! Service- Veri Çoklu Silme Post
    public function ServiceDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Silme
            $DB_Status = DB::table('services')->whereIn('uid',$request->uids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Service - Veri Çoklu Silme Post Son

    //! Service - Veri Güncelleme Sayfası
    public function ServiceEdit($site_lang="tr",$id)
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Arama
                $table = 'services';
                $DB_Find_tr = DB::table($table)->where('uid',$id)->where('lang','tr')->first(); //Türkçe
                $DB_Find_en = DB::table($table)->where('uid',$id)->where('lang','en')->first(); //İngilizce
                $DB_Find_de = DB::table($table)->where('uid',$id)->where('lang','de')->first(); //Almanca

                if($DB_Find_tr) {

                    //! Service Category
                    $DB_Find_service_categories= DB::table('service_categories')->where('lang','=',__('admin.lang'))->get();
                    //echo "<pre>"; print_r($DB_blogs_categories); die();
                
                    //! Return
                    $DB["CookieData"] = $CookieControl["CookieDataList"];
                    $DB["DB_Find_tr"] =  $DB_Find_tr;
                    $DB["DB_Find_en"] =  $DB_Find_en;
                    $DB["DB_Find_de"] =  $DB_Find_de;
                    $DB["DB_Find_service_categories"] = $DB_Find_service_categories;

                    return view('admin/web/service/serviceListEdit',$DB); 

                }
                else { return view('error404'); }
            
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
           
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Service - Veri Güncelleme Sayfası Son

    //! Service- Veri Güncelleme Post
    public function ServiceEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //veri tabanı işlemleri
            $table = 'services';
            $DB = DB::table($table)->where('lang','=',$request->lang)->where('uid','=',$request->uid);
            $DB_Find = $DB->first(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if($DB_Find) {

                 //! Veri Güncelle
                 $DB_Status = $DB->update([       
                    'img_url' => $request->imgUrl, 
                    'category' => $request->category,    
                    'title' => $request->title,
                    'seo_url' => SEOLink($request->title),
                    'description' => $request->description,
                    'seo_keywords' => $request->seo_keywords,
                    'isUpdated'=>true,
                    'updated_at'=>Carbon::now(),
                    'updated_byId'=>$request->updated_byId,
                ]);
            }
            else{ 

                //! Veri Ekleme
                $DB_Status = DB::table($table)->insert([
                    'lang' => $request->lang,
                    'uid' => $request->uid,
                    'img_url' => $request->imgUrl,
                    'category' => $request->category,
                    'title' => $request->title,
                    'seo_url' => SEOLink($request->title),
                    'description' => $request->description,
                    'seo_keywords' => $request->seo_keywords,
                    'created_byId'=>$request->updated_byId,
                ]); //! Veri Ekleme Son

            }

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Service- Veri Güncelleme Post Son

    //! Service - Veri Bilgileri Güncelleme Post
    public function ServiceEditInfoPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //veri tabanı işlemleri
            $table = 'services';
            $DB = DB::table($table)->where('uid','=',$request->uid);
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if($DB_Find) {

                 //! Veri Güncelle
                 $DB_Status = $DB->update([       
                    'img_url' => $request->imgUrl, 
                    'category' => $request->category,
                    'isUpdated'=>true,
                    'updated_at'=>Carbon::now(),
                    'updated_byId'=>$request->updated_byId,
                ]);
            }

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Service - Veri Bilgileri Güncelleme Post Son
            
    //! Service - Veri Durum Güncelleme Post
    public function ServiceEditActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $DB = DB::table('services')->where('uid',$request->uid); //Veri Tabanı
            $DB_Find = $DB->get(); //Tüm verileri çekiyor

            if( count($DB_Find) > 0 ) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'isActive'=>$request->active == "true" ? true : false,
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

    } //! Service - Veri Durum Güncelleme Post Son
        
    //! Service  - Çoklu Veri Durum Güncelle - Post
    public function ServiceEditMultiActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Güncelleme
            $DB_Status = DB::table('services')->whereIn('uid',$request->uids)
            ->update([  
                'isActive'=>$request->active == "true" ? true : false,
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

        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );

            return response()->json($response);
        }

    } //! Service  - Çoklu Veri Durum Günceleme - Post Son

    //!  Service - Clone - Post
    public function ServiceClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'services';
            $DB = DB::table($table)->where('uid',$request->uid); //VeriTabanı
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();

            if( count($DB_Find) > 0 ){  

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri
                $time = time(); //! uid

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->uid); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->uid = $time; //! Veri Güncelle
                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData; //! Ekleme
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
                    'error' => null,
                    'addNewId' => $time,
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

    } //!  Service - Clone - Post Son

    //!  Service - Çoklu Clone - Post
    public function ServiceClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $table = 'services';
            $dbFind_uids = $request->uids;
            $dbFind_uids_count = count($dbFind_uids);
            //echo "sayisi: "; echo $dbFind_uids_count; die();

            if( $dbFind_uids_count > 0 ){ 
                        
                //! Veri Arama
                $DB = DB::table($table)->whereIn('uid',$dbFind_uids); //VeriTabanı
                $DB_Find = $DB->get(); //Tüm verileri çekiyor
                //echo "<pre>"; print_r($DB_Find); die();

                if( count($DB_Find) > 0 ){  

                    //! Tanım
                    $DB_FindInsert = []; //! Eklenecek Veri

                    for ($j=0; $j < $dbFind_uids_count; $j++) { 
                        $time = time()+$j; //! uid

                        for ($i=0; $i < count($DB_Find); $i++) {  
                            if( $DB_Find[$i]->uid == $dbFind_uids[$j] ) {
                                //echo $DB_Find[$i]->uid; echo " ";
                            
                                //! Veri Silme
                                unset($DB_Find[$i]->id); //! Veri Silme 
                                unset($DB_Find[$i]->uid); //! Veri Silme 
                                unset($DB_Find[$i]->created_at); //! Veri Silme 
                                unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                                unset($DB_Find[$i]->updated_at); //! Veri Silme 
                                unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                                unset($DB_Find[$i]->isActive); //! Veri Silme 
                                unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                                unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                                unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                                $DB_Find[$i]->uid = $time; //! Veri Güncelle
                                $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                                //! Yeni Data
                                $newData = array(); //! Eklenecek Veri 
                                $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                                
                                //! Veriler
                                for ($k=0; $k < count($table_columns); $k++) { 
                                    $col=$table_columns[$k];
                                    $newData[$col] = $DB_Find->pluck($col)[$i];
                                }
                                //! Veriler Son
                            
                                $DB_FindInsert[] = $newData; //! Ekleme
                            }
                        }

                    }

                    //! Veri Ekleme
                    $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                    $response = array(
                        'status' => $addNewStatus ? 'success' : 'error',
                        'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

            }
            else {
    
               $response = array(
                  'status' => 'error',
                  'msg' => "uid:".__('admin.dataNotFound'),
                  'error' => null,
               );
    
               return response()->json($response);
            }
    
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' =>  __('admin.transactionFailed'),
               'error' => $th,            
            );
    
            return response()->json($response);
        }

    } //!  Service - Çoklu Clone - Post Son
    
    //************* Comment ***************** */

    //! Comment
    public function CommentList($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {  

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "comments";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData
                $selectData = [];  //! Select
                $selectDataRaw = [];  //! Select - Raw
                $joinData = [];  //! Join

                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "uid", "table" => $table, "where" => "uid", "data_item_object" => "=", "data_key_type" => "string", ); //! Eşit
                $searchData[] = array("params" => "Status", "table" => $table, "where" => "isActive", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                
                $whereData = []; //! Where
                $whereData[] = array( "table" => $table, "where" => "lang" , "data_item_object" => "=", "value" => __('admin.lang') ); //! Arama
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find; 
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                return view('admin/web/comment/commentList',$DB); 
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Comment Son

    //! Comment - Arama Post
    public function CommentSearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('comments')->where('id',$request->id)->first(); //Tüm verileri çekiyor
   
            if($DB_Find) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
                  'error' => null,
               );
   
               return response()->json($response);
            }
   
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' => __('admin.transactionFailed'),
               'DB' =>  [],
               'error' => $th,            
            );
   
            return response()->json($response);
        }

    } //! Comment - Arama Post Son

    //! Comment - Veri Ekleme Sayfası
    public function CommentAddView($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();
                
                //! Return
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                return view('admin/web/comment/commentAdd',$DB); 
                
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
            
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Comment - Veri Ekleme Sayfası Son

    //! Comment - Veri Ekleme Post
    public function CommentAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //veri tabanı işlemleri
            $table = 'comments';
            $DB = DB::table($table)->where('lang','=',$request->lang)->where('uid','=',$request->uid);
            $DB_Find = $DB->first(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if($DB_Find) {

                 //! Veri Güncelle
                 $DB_Status = $DB->update([            
                    'img_url' => $request->imgUrl,
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'role' => $request->role,
                    'comment' => $request->comment,
                    'isUpdated'=>true,
                    'updated_at'=>Carbon::now(),
                    'updated_byId'=>$request->created_byId,
                ]);
            }
            else{

                //! Veri Ekleme
                $DB_Status = DB::table($table)->insert([
                    'lang' => $request->lang,
                    'uid' => $request->uid,
                    'img_url' => $request->imgUrl,
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'role' => $request->role,
                    'comment' => $request->comment,
                    'created_byId'=>$request->created_byId,
                ]); //! Veri Ekleme Son

            }

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Comment - Veri Ekleme Post Son
    
    //! Comment - Veri Silme Post
    public function CommentDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'comments';
            $DB_Find = DB::table($table)->where('uid','=',$request->uid)->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Silme
                $DB_Status = DB::table($table)->where('uid','=',$request->uid)->delete();

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

    } //! Comment - Veri Silme Post Son

    //! Comment - Veri Çoklu Silme Post
    public function CommentDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Silme
            $DB_Status = DB::table('comments')->whereIn('uid',$request->uids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Comment - Veri Çoklu Silme Post Son

    //! Comment - Veri Güncelleme Sayfası
    public function CommentEdit($site_lang="tr",$id)
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Arama
                $table = 'comments';
                $DB_Find_tr = DB::table($table)->where('uid',$id)->where('lang','tr')->first(); //Türkçe
                $DB_Find_en = DB::table($table)->where('uid',$id)->where('lang','en')->first(); //İngilizce
                $DB_Find_de = DB::table($table)->where('uid',$id)->where('lang','de')->first(); //Almanca

                if($DB_Find_tr) {

                    //! Return
                    $DB["CookieData"] = $CookieControl["CookieDataList"];
                    $DB["DB_Find_tr"] =  $DB_Find_tr;
                    $DB["DB_Find_en"] =  $DB_Find_en;
                    $DB["DB_Find_de"] =  $DB_Find_de;
                    //echo "<pre>"; print_r($DB); die();

                    return view('admin/web/comment/commentEdit',$DB); 

                }
                else { return view('error404'); }
            
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
           
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Comment - Veri Güncelleme Sayfası Son

    //! Comment - Veri Güncelleme Post
    public function CommentEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //veri tabanı işlemleri
            $table = 'comments';
            $DB = DB::table($table)->where('lang','=',$request->lang)->where('uid','=',$request->uid);
            $DB_Find = $DB->first(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if($DB_Find) {

                 //! Veri Güncelle
                 $DB_Status = $DB->update([       
                    'img_url' => $request->imgUrl, 
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'role' => $request->role,
                    'comment' => $request->comment,
                    'isUpdated'=>true,
                    'updated_at'=>Carbon::now(),
                    'updated_byId'=>$request->updated_byId,
                ]);
            }
            else{ 

                //! Veri Ekleme
                $DB_Status = DB::table($table)->insert([
                    'lang' => $request->lang,
                    'uid' => $request->uid,
                    'img_url' => $request->imgUrl,
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'role' => $request->role,
                    'comment' => $request->comment,
                    'created_byId'=>$request->updated_byId,
                ]); //! Veri Ekleme Son

            }

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Comment - Veri Güncelleme Post Son

    //! Comment - Veri Resim Güncelleme Post
    public function CommentEditImagePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //veri tabanı işlemleri
            $table = 'comments';
            $DB = DB::table($table)->where('uid','=',$request->uid);
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if($DB_Find) {

                 //! Veri Güncelle
                 $DB_Status = $DB->update([       
                    'img_url' => $request->imgUrl, 
                    'isUpdated'=>true,
                    'updated_at'=>Carbon::now(),
                    'updated_byId'=>$request->updated_byId,
                ]);
            }

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Comment - Veri Güncelleme Post Son
            
    //! Comment - Veri Durum Güncelleme Post
    public function CommentEditActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $DB = DB::table('comments')->where('uid',$request->uid); //Veri Tabanı
            $DB_Find = $DB->get(); //Tüm verileri çekiyor

            if( count($DB_Find) > 0 ) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'isActive'=>$request->active == "true" ? true : false,
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

    } //! Comment - Veri Durum Güncelleme Post Son
        
    //! Comment - Detay - Çoklu Veri Durum Güncelle - Post
    public function CommentEditMultiActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Güncelleme
            $DB_Status = DB::table('comments')->whereIn('uid',$request->uids)
            ->update([  
                'isActive'=>$request->active == "true" ? true : false,
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

        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );

            return response()->json($response);
        }

    } //! Comment - Detay - Çoklu Veri Durum Günceleme - Post Son
    
    //!  Comment - Clone - Post
    public function CommentClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'comments';
            $DB = DB::table($table)->where('uid',$request->uid); //VeriTabanı
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();

            if( count($DB_Find) > 0 ){  

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri
                $time = time(); //! uid

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->uid); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->uid = $time; //! Veri Güncelle
                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData; //! Ekleme
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
                    'error' => null,
                    'addNewId' => $time,
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

    } //!  Comment - Clone - Post Son

    //!  Comment - Çoklu Clone - Post
    public function CommentClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $table = 'comments';
            $dbFind_uids = $request->uids;
            $dbFind_uids_count = count($dbFind_uids);
            //echo "sayisi: "; echo $dbFind_uids_count; die();

            if( $dbFind_uids_count > 0 ){ 
                        
                //! Veri Arama
                $DB = DB::table($table)->whereIn('uid',$dbFind_uids); //VeriTabanı
                $DB_Find = $DB->get(); //Tüm verileri çekiyor
                //echo "<pre>"; print_r($DB_Find); die();

                if( count($DB_Find) > 0 ){  

                    //! Tanım
                    $DB_FindInsert = []; //! Eklenecek Veri

                    for ($j=0; $j < $dbFind_uids_count; $j++) { 
                        $time = time()+$j; //! uid

                        for ($i=0; $i < count($DB_Find); $i++) {  
                            if( $DB_Find[$i]->uid == $dbFind_uids[$j] ) {
                                //echo $DB_Find[$i]->uid; echo " ";
                            
                                //! Veri Silme
                                unset($DB_Find[$i]->id); //! Veri Silme 
                                unset($DB_Find[$i]->uid); //! Veri Silme 
                                unset($DB_Find[$i]->created_at); //! Veri Silme 
                                unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                                unset($DB_Find[$i]->updated_at); //! Veri Silme 
                                unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                                unset($DB_Find[$i]->isActive); //! Veri Silme 
                                unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                                unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                                unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                                $DB_Find[$i]->uid = $time; //! Veri Güncelle
                                $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                                //! Yeni Data
                                $newData = array(); //! Eklenecek Veri 
                                $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                                
                                //! Veriler
                                for ($k=0; $k < count($table_columns); $k++) { 
                                    $col=$table_columns[$k];
                                    $newData[$col] = $DB_Find->pluck($col)[$i];
                                }
                                //! Veriler Son
                            
                                $DB_FindInsert[] = $newData; //! Ekleme
                            }
                        }

                    }

                    //! Veri Ekleme
                    $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                    $response = array(
                        'status' => $addNewStatus ? 'success' : 'error',
                        'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

            }
            else {
    
               $response = array(
                  'status' => 'error',
                  'msg' => "uid:".__('admin.dataNotFound'),
                  'error' => null,
               );
    
               return response()->json($response);
            }
    
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' =>  __('admin.transactionFailed'),
               'error' => $th,            
            );
    
            return response()->json($response);
        }

    } //!  Comment - Çoklu Clone - Post Son    

    //************* Team ***************** */

    //! Team
    public function TeamList($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {  

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "teams";
                $infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                $groupData = []; //! GroupData
                $selectData = [];  //! Select
                $selectDataRaw = [];  //! Select - Raw
                $joinData = [];  //! Join

                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "id", "table" => $table, "where" => "id", "data_item_object" => "=", "data_key_type" => "string", ); //! Eşit
                $searchData[] = array("params" => "Status", "table" => $table, "where" => "isActive", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                
                $whereData = []; //! Where
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();

                //! Return
                $DB = $DB_Find; 
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                return view('admin/web/team/teamList',$DB); 
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Team Son

    //! Team - Arama Post
    public function TeamSearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('teams')->where('id',$request->id)->first(); //Tüm verileri çekiyor
   
            if($DB_Find) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
                  'error' => null,
               );
   
               return response()->json($response);
            }
   
        } catch (\Throwable $th) {
            
            $response = array(
               'status' => 'error',
               'msg' => __('admin.transactionFailed'),
               'DB' =>  [],
               'error' => $th,            
            );
   
            return response()->json($response);
        }

    } //! Team - Arama Post Son

    //! Team - Veri Ekleme Sayfası
    public function TeamAddView($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();
                
                //! Return
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                return view('admin/web/team/teamAdd',$DB); 
                
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
            
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Team - Veri Ekleme Sayfası Son

    //! Team - Veri Ekleme Post
    public function TeamAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //veri tabanı işlemleri
            $table = 'teams';

            //! Veri Ekleme
            $DB_Status = DB::table($table)->insert([
                'img_url' => $request->imgUrl,
                'name' => $request->name,
                'surname' => $request->surname,
                'role' => $request->role,
                'phone' => $request->phone,
                'phone2' => $request->phone2,
                'facebook_url' => $request->facebook_url,
                'twitter_url' => $request->twitter_url,
                'instagram_url' => $request->instagram_url,
                'linkedin_url' => $request->linkedin_url,
                'web_url' => $request->web_url,
                'created_byId'=>$request->created_byId,
            ]); //! Veri Ekleme Son

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Team - Veri Ekleme Post Son
    
    //! Team - Veri Silme Post
    public function TeamDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'teams';
            $DB_Find = DB::table($table)->where('id','=',$request->id)->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Silme
                $DB_Status = DB::table($table)->where('id','=',$request->id)->delete();

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

    } //! Team - Veri Silme Post Son

    //! Team - Veri Çoklu Silme Post
    public function TeamDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Silme
            $DB_Status = DB::table('teams')->whereIn('id',$request->ids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Team - Veri Çoklu Silme Post Son

    //! Team - Veri Güncelleme Sayfası
    public function TeamEdit($site_lang="tr",$id)
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Arama
                $table = 'teams';
                $DB_Find = DB::table($table)->where('id',$id)->first(); 

                if($DB_Find) {

                    //! Return
                    $DB["CookieData"] = $CookieControl["CookieDataList"];
                    $DB["DB_Find"] =  $DB_Find;
                   
                    //echo "<pre>"; print_r($DB); die();

                    return view('admin/web/team/teamEdit',$DB); 

                }
                else { return view('error404'); }
            
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
           
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Team - Veri Güncelleme Sayfası Son

    //! Team - Veri Güncelleme Post
    public function TeamEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //veri tabanı işlemleri
            $table = 'teams';
            $DB = DB::table($table)->where('id','=',$request->id);
            $DB_Find = $DB->first(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if($DB_Find) {

                 //! Veri Güncelle
                 $DB_Status = $DB->update([       
                    'img_url' => $request->imgUrl,
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'role' => $request->role,
                    'phone' => $request->phone,
                    'phone2' => $request->phone2,
                    'facebook_url' => $request->facebook_url,
                    'twitter_url' => $request->twitter_url,
                    'instagram_url' => $request->instagram_url,
                    'linkedin_url' => $request->linkedin_url,
                    'web_url' => $request->web_url,
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

    } //! Team - Veri Güncelleme Post Son
            
    //! Team - Veri Durum Güncelleme Post
    public function TeamEditActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $DB = DB::table('teams')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->get(); //Tüm verileri çekiyor

            if( count($DB_Find) > 0 ) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'isActive'=>$request->active == "true" ? true : false,
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

    } //! Team - Veri Durum Güncelleme Post Son
        
    //! Team - Detay - Çoklu Veri Durum Güncelle - Post
    public function TeamEditMultiActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Güncelleme
            $DB_Status = DB::table('teams')->whereIn('id',$request->ids)
            ->update([  
                'isActive'=>$request->active == "true" ? true : false,
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

        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );

            return response()->json($response);
        }

    } //! Team - Detay - Çoklu Veri Durum Günceleme - Post Son
    
    //!  Team - Clone - Post
    public function TeamClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'teams';
            $DB = DB::table($table)->where('id',$request->id); //VeriTabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) { 
            
                //! Verileri Ayarlıyor
                unset($DB_Find->id); //! Veri Silme 
                unset($DB_Find->created_at); //! Veri Silme 
                unset($DB_Find->isUpdated); //! Veri Silme 
                unset($DB_Find->updated_at); //! Veri Silme 
                unset($DB_Find->updated_byId); //! Veri Silme 
                unset($DB_Find->isActive); //! Veri Silme 
                unset($DB_Find->isDeleted); //! Veri Silme 
                unset($DB_Find->deleted_at); //! Veri Silme 
                unset($DB_Find->deleted_byId); //! Veri Silme 

                $DB_Find->created_byId = $request->created_byId; //! Veri Güncelle
            
                //! Tanım
                $newData = array(); //! Eklenecek Veri 
                $table_columns = array_keys(json_decode(json_encode($DB_Find), true));  //! Sutun Veriler
            
                //! Veriler
                for ($i=0; $i < count($table_columns); $i++) { 
                    $col=$table_columns[$i];
                    $newData[$col] = $DB->pluck($col)[0];
                }
                //! Veriler Son

                //$newData['img_url'] = config('admin.Default_UserImgUrl');
                $newData['created_byId'] = $request->created_byId;

                //! Veri Ekleme
                $addNewId = DB::table($table)->insertGetId($newData); //! Veri Ekleme Son

                $response = array(
                    'status' => 'success',
                    'msg' => __('admin.transactionSuccessful'),
                    'error' => null, 
                    'addNewId' => $addNewId,
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

    } //!  Team - Clone - Post Son

    //!  Team - Çoklu Clone - Post
    public function TeamClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $table = 'teams';
            $DB = DB::table($table)->whereIn('id',$request->ids);
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if( count($DB_Find) > 0 ){ 

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData;
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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
               'msg' =>  __('admin.transactionFailed'),
               'error' => $th,            
            );
    
            return response()->json($response);
        }

    } //!  Team - Çoklu Clone - Post Son    

    //************* Sabit ***************** */

    //! Sabit 
    public function Fixed($site_lang="tr")
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 
            
            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();
                    
                //! Return
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                
                return view('admin/01_sabit/00_0_sabit',$DB); 
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Sabit  Son

   //************* Form ***************** */

    //! Form
    public function FixedForm($site_lang="tr")
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 
            
            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();
                    
                //! Return
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                
                return view('admin/01_sabit/01_0_sabit_form',$DB); 
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Form Son

    //! Form Control
    public function FixedFormControl(Request $request)
    {

        try {

            //Veri Okuma
            // [ Name] - değerlerine göre oku
            $token= $request->_token;
            $siteLang= $request->siteLang; //! Çoklu Dil
            \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil

            $postAll = $request->all(); //! Veriler
            //echo "<pre>"; print_r($postAll); die();
            //echo "siteLang:"; echo $postAll["siteLang"]; die();

            $email= $request->email;
            $password= $request->password;

            echo "Form "; echo "<br/>"; 
            echo "email: "; echo $email; echo "<br/>";
            echo "password: "; echo $password; echo "<br/>";

        } catch (\Throwable $th) { throw $th; }

    } //! Form Control Son
    
   //************* Sabit List ***************** */

    //! Sabit List
    public function FixedList($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 
            
            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Tanım
                $table = "test";

                //! Bilgiler
                $infoData = [];
                $infoData[] = array( "page" => 1, "rowcount" => 15, "orderBy" => $table."."."id", "order" => "desc" ); //! Bilgiler
                //$infoData[] = array( "page" => 1, "rowcount" => 10, "orderBy" => "test"."."."id", "order" => "desc" ); //! Bilgiler
                
                /**
                    * [page] => Sayfa
                    * [rowcount] => Sayfadaki Sayısı
                    * [orderBy] => Sıralama Veri
                    * [order] => [asc][desc]
                */

                //echo "<pre>"; print_r($infoData); die();

                //! Group
                $groupData = []; //! GroupData
                //$groupData[]= "service"; //! Ekleme
                //if(!request('authService')) { $groupData[]= "service"; } //! Params Verisine Gösterme

                //! Select
                $selectData = [];
                $selectData[] = array( "table" => $table, "parametre" => "*", "name" => null, );
                //$selectData[] = array( "table" => $table, "parametre" => "name", "name" => "TestName", );
                //$selectData[] = array( "table" => $table, "parametre" => "surname", "name" => "TestSurname", );
                //$selectData[] = array( "table" => "users", "parametre" => "name", "name" => "userName", );
                
                /**
                    *  [table] => Hangi Tablodan Alacak
                    *  [parametre] => Hangi Parametreden Alıyor
                    *  [name] => İsim Değiştirmek İçin Kullan
                */

                //echo "<pre>"; print_r($selectData); die();
                
                //! Select - Raw
                $selectDataRaw = [];
                //$selectDataRaw[] = "test.value as TestValue";
                //$selectDataRaw[] = "test.email as TestEmail";
                //$selectDataRaw[] = "(SELECT COUNT(*) FROM users) as userTotal";                

                //echo "<pre>"; print_r($selectDataRaw); die();

                //! Join
                $joinData = [];
                $joinData[] = array( "type" => "LEFT", "table" => "users" , "value" => "id", "refTable" => $table, "refValue" => "created_byId", ); //! Join Veri Ekleme
                
                /**
                    *  [type] => Join Türleri
                    *  [table] => Join Yapılacak Tablodan Alacak
                    *  [value] => Tablodan Tablo Sutunu
                    *  [refTable] => Aranacak Tablo
                    *  [refValue] => Aranacak Tablo Sutunu
                */
                
                //echo "<pre>"; print_r($joinData); die();

                //! Arama
                $searchData = [];
                $searchData[] = array("params" => "Id", "table" => $table, "where" => "id", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "Status", "table" => $table, "where" => "isActive", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "userId", "table" => $table, "where" => "created_byId", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "Value", "table" => $table, "where" => "value", "data_item_object" => "=", "data_key_type" => "int", ); //! Eşit
                $searchData[] = array("params" => "ValueBottom", "table" => $table, "where" => "value", "data_item_object" => ">=", "data_key_type" => "int", ); //! Büyük ve Eşit
                $searchData[] = array("params" => "ValueTop", "table" => $table, "where" => "value", "data_item_object" => "<=", "data_key_type" => "int", ); //! Küçük ve Eşit
                $searchData[] = array("params" => "CreatedDate", "table" => $table, "where" => "created_at", "data_item_object" => "likeStart", "data_key_type" => "string", ); //! Başında Varsa
                $searchData[] = array("params" => "CreatedDateBottom", "table" => $table, "where" => "created_at", "data_item_object" => ">=", "data_key_type" => "date", ); //! Zaman Büyük ve Eşit
                $searchData[] = array("params" => "CreatedDateTop", "table" => $table, "where" => "created_at", "data_item_object" => "<=", "data_key_type" => "date", ); //! Zaman Küçük ve Eşit
                $searchData[] = array("params" => "SurnameEnd", "table" => $table, "where" => "surname", "data_item_object" => "likeEnd", "data_key_type" => "string", ); //! Sonunda Varsa
                
                /**
                    *  [params] => Paramsdan alınan veri 
                    *  [table] => Hangi Tablodan Alacak
                    *  [where] => Aranacak Yer
                    *  [data_item_object] => Arama türü [=][<][>][>=][<=][likeStart][likeEnd][likeBoth]
                    *  [data_key_type] => Tür [int] [string]
                */
                /**
                    * [likeStart] => Başlangıçta  [ created_at LIKE "2023-12-21%"; ] 
                    * [likeEnd] => Sonuda Varsa  [ created_at LIKE "%2023-12-21"; ] 
                    * [likeBoth] => İçinde Varsa  [ created_at LIKE "%2023-12-21%"; ] 
                */
                
                //echo "<pre>"; print_r($searchData); die();

                //! Where
                $whereData = [];
                //$whereData[] = array( "table" => $table, "where" => "value" , "data_item_object" => "=", "value" => 788 );
                //$whereData[] = array( "table" => $table, "where" => "isActive" , "data_item_object" => "=", "value" => 0 );

                /**
                    *  [table] => Hangi Tablodan Alacak
                    *  [where] => Aranacak Yer
                    *  [data_item_object] => Arama türü [=][<][>][>=][<=]
                    *  [value] => Aranacak Değer
                */

                //echo "<pre>"; print_r($whereData); die();
                
                $DB_Find =  List_Function($table,$infoData, $groupData, $selectData,$selectDataRaw,$joinData,$searchData,$whereData); //! View Tablo Kullanımı
                //echo "<pre>"; print_r($DB_Find); die();
                    
                //! Return
                $DB = $DB_Find;
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                return view('admin/02_sabit_list/00_0_sabit_list',$DB);
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Sabit List Son

    //! Sabit - Arama Sayfası
    public function FixedSearchView($site_lang="tr",$id)
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Arama
                $DB_Find = DB::table('test')->where('id',$id)->first(); //Tüm verileri çekiyor

                if($DB_Find) {  
                
                    //! Return
                    $DB["CookieData"] = $CookieControl["CookieDataList"];
                    $DB["DB_Find"] =  $DB_Find;

                    //echo "<pre>"; print_r($DB); die();

                    return view('admin/02_sabit_list/00_2_sabit_list_view',$DB); 
                }
                else { return view('error404'); }                    
               
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
          
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Sabit - Arama Sayfası Son

    //! Sabit - Arama Post
    public function FixedSearchPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB_Find = DB::table('test')->where('id',$request->id)->first(); //Tüm verileri çekiyor
   
            if($DB_Find) {
   
               $response = array(
                  'status' => 'success',
                  'msg' => __('admin.transactionSuccessful'),
                  'DB' =>  $DB_Find,
                  'error' => null,
               );

               return response()->json($response);
            }
   
            else {
   
               $response = array(
                  'status' => 'error',
                  'msg' => __('admin.dataNotFound'),
                  'DB' =>  [],
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

    } //! Sabit - Arama Post Son

    //! Sabit - Veri Ekleme Sayfası
    public function FixedAddView($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();
                
                //! Return
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                return view('admin/02_sabit_list/00_3_sabit_list_add',$DB); 
              
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
          
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Sabit - Veri Ekleme Sayfası Son

    //! Sabit - Veri Ekleme Post
    public function FixedAddPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Ekleme
            DB::table('test')->insert([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'value' => $request->value,
                'img_url'=> config('admin.Default_UserImgUrl'),
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

    } //! Sabit - Veri Ekleme Post Son

    //! Sabit - Veri Silme Post
    public function FixedDeletePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'test';
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

    } //! Sabit - Veri Silme Post Son

    //! Sabit - Veri Çoklu Silme Post
    public function FixedDeletePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Silme
            $DB_Status = DB::table('test')->whereIn('id',$request->ids)->delete();

            $response = array(
                'status' => $DB_Status ? 'success' : 'error',
                'msg' =>  $DB_Status ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Sabit - Veri Çoklu Silme Post Son

    //! Sabit - Veri Güncelleme Sayfası
    public function FixedEdit($site_lang="tr",$id)
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 

            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Arama
                $DB_Find = DB::table('test')->where('id',$id)->first(); //Tüm verileri çekiyor
                
                //! Return
                $DB["CookieData"] = $CookieControl["CookieDataList"];
                $DB["DB_Find"] =  $DB_Find;

                //echo "<pre>"; print_r($DB); die();

                return view('admin/02_sabit_list/00_4_sabit_list_edit',$DB);
            
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
           
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Sabit - Veri Güncelleme Sayfası Son

    //! Sabit - Veri Güncelleme Post
    public function FixedEditPost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
         
            //! Veri Arama
            $DB = DB::table('test')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'name'=>$request->name,
                    'surname'=>$request->surname,
                    'email'=>$request->email,
                    'value'=>$request->value,
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

    } //! Sabit - Veri Güncelleme Post Son

    //! Sabit - Veri Durum Güncelleme Post
    public function FixedEditActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $DB = DB::table('test')->where('id',$request->id); //Veri Tabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) {

                //! Veri Güncelle
                $DB_Status = $DB->update([            
                    'isActive'=>$request->active == "true" ? true : false,
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

    } //! Sabit - Veri Durum Güncelleme Post Son

    //! Sabit - Çoklu Veri Durum Güncelle - Post
    public function FixedEditMultiActive(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Güncelleme
            $DB_Status = DB::table('test')->whereIn('id',$request->ids)
            ->update([  
                'isActive'=>$request->active == "true" ? true : false,
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

        } catch (\Throwable $th) {
            
            $response = array(
                'status' => 'error',
                'msg' => __('admin.transactionFailed'),
                'error' => $th,            
            );

            return response()->json($response);
        }

    } //! Sabit - Çoklu Veri Durum Güncelle - Post Son

    //! Sabit -Clone - Post
    public function FixedEditClonePost(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {
        
            //! Veri Arama
            $table = 'test';
            $DB = DB::table($table)->where('id',$request->id); //VeriTabanı
            $DB_Find = $DB->first(); //Tüm verileri çekiyor

            if($DB_Find) { 
            
                //! Verileri Ayarlıyor
                unset($DB_Find->id); //! Veri Silme 
                unset($DB_Find->created_at); //! Veri Silme 
                unset($DB_Find->isUpdated); //! Veri Silme 
                unset($DB_Find->updated_at); //! Veri Silme 
                unset($DB_Find->updated_byId); //! Veri Silme 
                unset($DB_Find->isActive); //! Veri Silme 
                unset($DB_Find->isDeleted); //! Veri Silme 
                unset($DB_Find->deleted_at); //! Veri Silme 
                unset($DB_Find->deleted_byId); //! Veri Silme 

                $DB_Find->created_byId = $request->created_byId; //! Veri Güncelle
            
                //! Tanım
                $newData = array(); //! Eklenecek Veri 
                $table_columns = array_keys(json_decode(json_encode($DB_Find), true));  //! Sutun Veriler
            
                //! Veriler
                for ($i=0; $i < count($table_columns); $i++) { 
                    $col=$table_columns[$i];
                    $newData[$col] = $DB->pluck($col)[0];
                }
                //! Veriler Son

                //$newData['img_url'] = config('admin.Default_UserImgUrl');
                $newData['created_byId'] = $request->created_byId;

                //! Veri Ekleme
                $addNewId = DB::table($table)->insertGetId($newData); //! Veri Ekleme Son

                $response = array(
                    'status' => 'success',
                    'msg' => __('admin.transactionSuccessful'),
                    'error' => null, 
                    'addNewId' => $addNewId,
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

    } //! Sabit - Clone - Post Son

    //! Sabit - Çoklu Clone - Post
    public function FixedEditClonePostMulti(Request $request)
    {
        $siteLang= $request->siteLang; //! Çoklu Dil
        \Illuminate\Support\Facades\App::setLocale($siteLang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try {

            //! Veri Arama
            $table = 'test';
            $DB = DB::table($table)->whereIn('id',$request->ids);
            $DB_Find = $DB->get(); //Tüm verileri çekiyor
            //echo "<pre>"; print_r($DB_Find); die();
            
            if( count($DB_Find) > 0 ){ 

                //! Tanım
                $DB_FindInsert = []; //! Eklenecek Veri

                for ($i=0; $i < count($DB_Find); $i++) { 

                    //! Veri Silme
                    unset($DB_Find[$i]->id); //! Veri Silme 
                    unset($DB_Find[$i]->created_at); //! Veri Silme 
                    unset($DB_Find[$i]->isUpdated); //! Veri Silme 
                    unset($DB_Find[$i]->updated_at); //! Veri Silme 
                    unset($DB_Find[$i]->updated_byId); //! Veri Silme 
                    unset($DB_Find[$i]->isActive); //! Veri Silme 
                    unset($DB_Find[$i]->isDeleted); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_at); //! Veri Silme 
                    unset($DB_Find[$i]->deleted_byId); //! Veri Silme 

                    $DB_Find[$i]->created_byId = $request->created_byId; //! Veri Güncelle

                    //! Yeni Data
                    $newData = array(); //! Eklenecek Veri 
                    $table_columns = array_keys(json_decode(json_encode($DB_Find[$i]), true));  //! Sutun Veriler
                    
                    //! Veriler
                    for ($k=0; $k < count($table_columns); $k++) { 
                        $col=$table_columns[$k];
                        $newData[$col] = $DB_Find->pluck($col)[$i];
                    }
                    //! Veriler Son
                 
                    $DB_FindInsert[] = $newData;
                }

                //! Veri Ekleme
                $addNewStatus = DB::table($table)->insert($DB_FindInsert); //! Veri Ekleme Son

                $response = array(
                    'status' => $addNewStatus ? 'success' : 'error',
                    'msg' => $addNewStatus ? __('admin.transactionSuccessful') : __('admin.transactionFailed'),
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

    } //! Sabit - Çoklu Clone - Post Son
    
    //! Sabit - Import
    public function FixedEditImport(Request $request)
    {
        
        //! Tanım
        $fileExt = $request->file_ext; //! Dosya Uzantısı [ xml]
        $fileUrl = $request->file_url; //! dosya yeri
        $errorStatus = "false"; //! Hata Kontrol
        $DB_SaveStatus = false; //! Veri Tabanına Kayıt -  Durumu 
        $DB = []; //! Veri

        try { 

            //! Json
            if($fileExt == "json") { 

              //! Dosya Kontrol ediyor 
              if(is_file($fileUrl)){ 
                $data = file_get_contents($fileUrl); //! Okuyor
                $DB = json_decode($data,true); //! Veri Json Çeviriyor 
              }
              else { $errorStatus = __('admin.fileNotFound'); }
            } 
            //! Json Son

            //! Xml
            else if($fileExt == "xml") {

                //! Dosya Kontrol ediyor 
                if(is_file($fileUrl)){ 
                  $data = file_get_contents($fileUrl); //! Okuyor
                  $xmlObject = simplexml_load_string($data); //! Xml Dosyası Okuma
                  $json = json_encode($xmlObject); 
                  $DB = json_decode($json, true); //! Dosya Array Çevirme 
                  $DB = $DB["Data"]; //! Array
                }
                else { $errorStatus = __('admin.fileNotFound'); }
  
            } 
            //! Xml Son

            $data_keys = array_keys($DB[0]);
            //echo "<pre>"; print_r($data_keys); die();


            //! Veri Tabanına Kayıt Yap
            if($errorStatus == "false"){
                
                //! Veri Tabanı işlemleri
                try {

                    for ($i=0; $i < count($DB); $i++) { 

                        //! Eklenecek Veriler
                        $insertData =['created_byId' => (int)$_COOKIE["yildirimdev_userID"]]; 

                        for ($k=0; $k < count($data_keys); $k++) { 
                            if($data_keys[$k] != "id" && $data_keys[$k] != "created_byId") {
                                $insertData[$data_keys[$k]] = $DB[$i][$data_keys[$k]];
                            }
                        }
                        //echo "<pre>"; print_r($insertData); die();

                        //! VeriTabanına Kayıt Yapıyor
                        $DB_importStatus = DB::table('test')->insert($insertData); //! VeriTabanına Kayıt Yapıyor Son
                    }

                } catch (\Throwable $th) { throw $th; }
                //! Veri Tabanı işlemleri Son

            }
            //! Veri Tabanına Kayıt Yap Son
            
            //! Return
            $response = array(
                'siteLang' => $request->siteLang,
                'status' => $errorStatus == "false" ? 'success' : 'error',
                'error' => $errorStatus == "false" ? null : $errorStatus,
                'userId' => (int)$_COOKIE["yildirimdev_userID"],
                'DB_SaveStatus' => $DB_SaveStatus,
              
                'file_ext' => $request->file_ext,
                'file_url' => $request->file_url,
                'DB' => $DB,
            );

            return response()->json($response);

        } catch (\Throwable $th) {

            $response = array( 'status' => 'error', 'error' => $errorStatus );
            return response()->json($response);
        }
        
    } //! Sabit - Import -  Son
    
    //************* Dosya Yükleme ***************** */

    //! Dosya Yükleme
    public function fileUpload($site_lang="tr")
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 
            
            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Return
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                
                return view('admin/01_sabit/03_0_sabit_fileUpload',$DB); 
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Dosya Yükleme Son

    //! Dosya Yükleme - Post
    public function fileUploadControl(Request $request)
    {
        try {

            //! Tanım
            $request->validate(['file' => 'required']);
            
            //! Dosya Boyutu
            $fileSize = $request->file('file')->getSize();  //kb - Boyutu
            $fileSize_kb = round($fileSize/1024,2);
            $fileSize_mb = round($fileSize/1024/1024,2);
            $fileSize_gb = round($fileSize/1024/1024/1024,2);

            $fileSizeTotal = 0;
            $fileSizeTotalType = 'kb';

            if($fileSize_gb >= 1) {  $fileSizeTotal = $fileSize_gb;  $fileSizeTotalType = 'gb';   }
            else if($fileSize_gb < 1) {
                if($fileSize_mb >= 1) {  $fileSizeTotal = $fileSize_mb;  $fileSizeTotalType = 'mb';   }
                else if($fileSize_mb < 1) {  $fileSizeTotal = $fileSize_kb;  $fileSizeTotalType = 'kb';   }
            }
            //! Dosya Boyutu Son

            //! Dosya Yükleme
            $fileName_Only=time();
            $fileName = $fileName_Only.'.'.$request->file->getClientOriginalExtension(); //! Dosya Adı
            $file_status= $request->file->move(public_path('upload/uploads'), $fileName); //! Dosya Yükleme Durumu

            //! Dosya Türü
            $fileExt = request()->file->getClientOriginalExtension(); //! Uzantısı
            $fileType = $_FILES['file']['type']; //! Türü
            $fileType = explode('/',$fileType)[0]; //! Türü Ayırma - > Image

            //! Tanım
            $uploadStatus = false;
            if($file_status) {  $uploadStatus = true; }

            //! Veri Tabanı Kayıt Yapma
            $fileWhere = $request->fileWhere; 
            $fileDbSaveCheck = $request->fileDbSave;
            $fileDbSaveStatus = false;

            if($fileDbSaveCheck == "true") { } //! Veri Tabanına Kayıt 
            //! Veri Tabanı Kayıt Yapma Son

            $response = array(
                'status' => $uploadStatus ? 'success' : 'error',
                'userId' => (int)$request->created_byId || 0, 
                'fileDbSaveCheck' => $fileDbSaveCheck,
                'fileDbSaveStatus' => $fileDbSaveStatus,
                'fileWhere' => $fileWhere,
                'file_upload_status'=>$uploadStatus,
                'file_path'=>url('upload/uploads/'.$fileName),
                'file_name_only'=>$fileName_Only,
                'file_name'=>$fileName,
                'file_originName_Only'=>explode('.',request()->file->getClientOriginalName())[0],
                'file_originName'=>request()->file->getClientOriginalName(),
                'file_size'=>array(
                    'sizeByte' => $fileSize,
                    'sizeTotal' => $fileSizeTotal,
                    'sizeTotalType' => $fileSizeTotalType
                ),
                'file_ext'=>$fileExt,
                'file_type'=> $fileType,
                'file_url'=>"upload/uploads/".$fileName,
                'file_url_public'=>public_path('upload\uploads')
            );

            return response()->json($response);
             
        } catch (\Throwable $th) { throw $th; }

    }  //! Dosya Yükleme - Post Son

    //! Çoklu Dosya Yükleme
    public function fileUploadMulti($site_lang="tr")
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 
            
            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();
                
                //! Return
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                return view('admin/01_sabit/04_0_sabit_fileUploadMulti',$DB); 
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Çoklu Dosya Yükleme Son

    //! Post - Çoklu File Upload
    public function fileUploadMultiControl(Request $request)
    {

        try {

            //! Tanım
            $request->validate(['files' => 'required' ]);

            $fileCount = 0; //! Sayac
            $fileControl =false; //! Dosya Durumu
            $fileData =array(); //! Dosyalar

            $fileWhere = $request->fileWhere; //!
            $fileDbSaveCheck = $request->fileDbSave;
            $fileDbSaveStatus = false;

            $fileSizeTotalGeneral = 0 ; //! Toplam Boyut
            $fileCountSuccess = 0 ; //! Başarılı Olan Sayı

            if($request->hasfile('files'))
            { 
                //! Kontrol
                $fileControl = true; //! Dosya Var

                //! Dosyaları Alıyor
                foreach($request->file('files') as $file) {

                    //! Dosya Yükleme
                    $fileName=time().'_'.$fileCount.'.'.$file->getClientOriginalExtension(); //! Dosya Adı
                    $file_status= $file->move(public_path('upload/uploads'), $fileName); //!  //! Dosya Yüklüyor

                    //! Dosya Türü
                    $fileExt = $file->getClientOriginalExtension(); //! Uzantısı
                    $fileType = $_FILES['files']['type'][$fileCount]; //! Türü
                    $fileType = explode('/',$fileType)[0]; //! Türü Ayırma - > Image

                    //! Dosya Boyutu
                    $fileSize = $_FILES['files']['size'][$fileCount];  //kb - Boyutu
                    $fileSize_kb = round($fileSize/1024,2);
                    $fileSize_mb = round($fileSize/1024/1024,2);
                    $fileSize_gb = round($fileSize/1024/1024/1024,2);

                    $fileSizeTotal = 0;
                    $fileSizeTotalType = 'kb';
    
                    if($fileSize_gb >= 1) {  $fileSizeTotal = $fileSize_gb;  $fileSizeTotalType = 'gb';   }
                    else if($fileSize_gb < 1) {
                    if($fileSize_mb >= 1) {  $fileSizeTotal = $fileSize_mb;  $fileSizeTotalType = 'mb';   }
                    else if($fileSize_mb < 1) {  $fileSizeTotal = $fileSize_kb;  $fileSizeTotalType = 'kb';   }
                    }
                    //! Dosya Boyutu Son

                    //! Sorun Yoksa
                    if($_FILES['files']['error'][$fileCount] == 0) {

                        $fileSizeTotalGeneral =  $fileSize + $fileSizeTotalGeneral ;  //! Toplam Boyut
                        $fileCountSuccess++; //! Başarılı Olan Sayı

                        //! Veri Tabanına Kayıt Yapma
                        if($fileDbSaveCheck == "true") {  }  //! Veri Tabanına Kayıt Yapma 

                    } //! Sorun Yoksa Son


                    if($file_status) {
    
                        //! Json içine kayıt yapıyor
                        $fileData[] =  array(
                            'file_upload_error'=> $_FILES['files']['error'][$fileCount],
                            'file_path'=>url('upload/uploads/'.$fileName),
                            'file_name'=>$fileName,
                            'file_originName'=>$file->getClientOriginalName(),
                            'file_size'=>array(
                                    'sizeByte' => $fileSize,
                                    'sizeTotal' => $fileSizeTotal,
                                    'sizeTotalType' => $fileSizeTotalType
                            ),
                            'file_ext'=>$fileExt,
                            'file_type'=> $fileType,
                            'file_url'=>"upload/uploads/".$fileName,
                            'file_url_public'=>public_path('upload\uploads')
                        );

                    }

                    $fileCount++; //! Sayaç Artırıyor

                }  //! Dosyaları Alıyor Son 

            }
    
            //! Return
            $response = array(
                'status' => $fileControl ? 'success' : 'error',
                'userId' =>  (int)$_COOKIE["yildirimdev_userID"],
                'fileDbSaveCheck' => $fileDbSaveCheck,
                'fileDbSaveStatus' => $fileDbSaveStatus,
                'fileWhere' => $fileWhere,
                'fileControl' =>  $fileControl,
                'files' =>  $fileData,
                'fileCount' => $fileCount,
                'file_size' => $fileSizeTotalGeneral,
                'file_url'=>"upload/uploads/",
                'file_url_public'=>public_path('upload/uploads')
            ); //! Return Son
    
            return response()->json($response);

        } catch (\Throwable $th) { throw $th; }

    }  //! Post - Çoklu File Upload Son

    //************* Ajax ***************** */

    //! Get
    public function ajaxFunctionExampleGet()
    {
        $response = array(
            'status' => 'success',
            'ajaxStatus' => 'get'
        );

        return response()->json($response); 
    } //! Get Son

    //! Ajax - Post
    public function ajaxFunctionExamplePost(Request $request)
    {
        
        try { echo "ajax post"; die();
            
            $user_name = $request->name;

            $response = array(
                'status' => 'success',
                'ajaxStatus' => 'post',
                'siteLang' => $request->siteLang,
                'user_name' => $request->name,
            );

            return response()->json($response);

        } catch (\Throwable $th) {
            
            $user_name = $request->name;

            $response = array(
                'status' => 'error',
                'ajaxStatus' => 'post',
                'error' => $th,
            );

            return response()->json($response);
        }
        
    } //! Ajax - Post Son
    
    //************* Api ***************** */
    
    //! Get Api
    public function apiGet()
    {

        //url
        //$url="http://localhost:3002/api/file/all";
        $url = config('admin.Api_Url').'/version'; //! Api Adresi 
        echo 'url:'; echo $url; echo "<br/>";

        //aç
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        // SSL important
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 0);


        //veri okunuyor
        $output = curl_exec($curl);

        //sorun varsa
        if($e=curl_error($curl)) { echo $e; }
        else
        {
            // Json verisine dönüştür
            //array oluştur
            $decoded=json_decode($output,true);
            echo "<pre>"; print_r($decoded);

            //okuma * dönüştürme işlemleri
            // $title=$decoded["Title"];
            // $table=$decoded["table"];
            // $status=$decoded["status"];
            //$created_at=$decoded["created_at"];

            //echo 'title:'; echo $title; echo "<br/>"; 
            
            //iç içe json
            //echo "<br>"; print_r($decoded["DB"]);  echo "<br>";  echo "<br>";
            //$data_sayisi=count($decoded["DB"]);
            //$data_id=$decoded["DB"][0]["id"];
            //$data_id=$decoded["DB"]["id"];

            //Ekran Çıktısı
            // echo  "Veri Çekiyor";
            // echo "<br>";
            // echo  "title: ".$title;
            // echo "<br>";
            // echo  "data - id : ".$data_id;
        }

        //kapat
        curl_close($curl);

    }   //! Get Api
       
    //! Post Api
    public function apiPost()
    {
    
        //url
        //$url="http://localhost:3002/api/file/find_post";
        $url = config('admin.Api_Url').'/token_create'; //! Api Adresi 
        echo 'url:'; echo $url; echo "<br/>"; 

        //Eklenecek Veriler
        $data_array=array
        (
            'name' => "enes",
            'surname' => "yildirim",
        );

        $data=http_build_query($data_array);
        $headers = array("Content-Type" => "application/json");

        $curl = curl_init();  //! Curl Başlatıyor
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);


        $output = curl_exec($curl); //! Veri Okunuyor
        //echo $output;  echo "<br>";   echo "<br>";   //! Curl Request

        $decoded = "";

        //sorun varsa
        if($e=curl_error($curl)) { echo $e; }
        else
        {
            // Json verisine dönüştür
            //array oluştur
            $decoded=json_decode($output,true);
            echo "<pre>"; print_r($decoded); 

            //okuma * dönüştürme işlemleri
            //$title=$decoded["token"];
            // $table=$decoded["table"];
            // $status=$decoded["status"];
            //$created_at=$decoded["created_at"];

            //echo 'title:'; echo $title; echo "<br/>"; 

            //iç içe json
            //echo "<br>"; print_r($decoded["DB"]);  echo "<br>";  echo "<br>";
            //$data_sayisi=count($decoded["DB"]);
            //$data_id=$decoded["DB"][0]["id"];
            //$data_id=$decoded["DB"]["id"];

            //Ekran Çıktısı
            // echo  "Veri Çekiyor";
            // echo "<br>";
            // echo  "title: ".$title;
            // echo "<br>";
            // echo  "data - id : ".$data_id;

        }

        //kapat
        curl_close($curl);

    }   //! Post Api   

    //! Dosya Yükleme
    public function apiFileUpload()
    {
        try { 
            
            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();

                //! Return
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                return view('admin/03_0_api/00_0_fileUpload',$DB); 
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Dosya Yükleme Son

    //! Dosya Yükleme - Kontrol
    public function apiFileUploadControl(Request $request)
    {
       
        //! Curl - File
        if($_FILES['file']) { 
           
            //! Dosya Bilgileri
            $file=$_FILES['file'];
            $fileError=$_FILES['file']['error'];

            //echo "<pre>"; print_r($file); die();
            //echo "fileError:"; echo $fileError; die();

            //url
            //$url="http://localhost:3002/api/file/all";
            $url = config('admin.Api_Url').'/file/upload'; //! Api Adresi 
            //echo 'url:'; echo $url; echo "<br/>"; die();

            //!------- Eklenecek Veriler ----------- 

            $cFile = array();
            if($fileError == 0 ) { $cFile = new CURLFile($_FILES['file']['tmp_name'],$_FILES['file']['type'],$_FILES['file']['name']); }
            //else { echo "Dosya Yok"; die(); }

            //! Gönderilen Veriler
            $data_array = $_POST; //! Verileri Gönderiyor
            unset($data_array["submit"]); //! Submit Verisini Siliyor
            
            //! Dosya Ekleme Yapıyor
            if($fileError == 0 ) { $data_array["file"] = $cFile; }

            //echo "<pre>"; print_r($data_array); die();

            //! Bearer
            $token ="yildirimdev01"; //! Token
            $authorization = "Authorization: Bearer ".$token; // Header BearerToken
            $headers = array("Content-Type" => "multipart/form-data" , $authorization );
            //!------- Eklenecek Veriler Son ------- 

            //! ----- Curl  ----------
            $curl = curl_init();  //! Curl Başlatıyor
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30); //! Timeout
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_array);

            curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($curl, CURLOPT_TIMEOUT, 900); //! Timeout
            //! ----- Curl Son  -----

            //veri okunuyor
            $output = curl_exec($curl);
            $status = 0;
            //echo "<pre>"; print_r($output); die();

            //sorun varsa
            if($e=curl_error($curl)) { echo $e; die(); }
            else
            {  
                // Json verisine dönüştür
                //array oluştur
                $decoded=json_decode($output,true);
                echo "<pre>"; print_r($decoded); die();

                //okuma * dönüştürme işlemleri
                $status=$decoded["status"];

                //$DB_id=$decoded["DB"]["id"];
                //$DB_id_cok=$decoded["file_size"][0]["id"];
            
                //Ekran Çıktısı
                // echo "Veri Çekiyor";
                // echo "<br>";
                // echo "status: ".$status; 
                
            }

            //kapat
            curl_close($curl);

            //! Return
            $response = array( 'status' => $status == 1 ? 'success' : 'error' );
                
            //echo "<pre>"; print_r($response); 
            return response()->json($response);

        }
        else { return response()->json(array( 'status' =>  'error' ));  }
        //! Curl - File Son

    } //! Dosya Yükleme - Kontrol Son

    //************* Export ***************** */

    //! Export Pdf 
    public function exportPdf($site_lang="tr")
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 
            
            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();
                    
                //! Return
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                
                return view('admin/04_export/01_0_sabit_export',$DB); 
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Export Pdf Son

    //! Export Pdf - Test
    public function exportPdfTest($site_lang="tr")
    {
        
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 
            
            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();
                    
                //! Return
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                return view('admin/04_export/01_1_sabit_export_test',$DB); 
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Export Pdf - Test Son

    //! Export Pdf - List
    public function exportPdfList($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 
            
            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();
                    
                //! Return
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                return view('admin/04_export/02_0_exportList',$DB); 
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Export Pdf - List Son
    
    //! Export Pdf - Kasa Listesi
    public function exportPdfListSafe($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Dil:"; echo $site_lang;  echo "<br/>";  die();

        try { 
            
            //! Cookie Fonksiyon Kullanımı
            $CookieControl =  cookieControl(); //! Çerez Kontrol
            //echo "<pre>"; print_r($CookieControl); die();

            if($CookieControl['isCookie']) {  
                //echo "Çerez var"; die();
                    
                //! Return
                $DB["CookieData"] = $CookieControl["CookieDataList"];

                //echo "<pre>"; print_r($DB); die();
                return view('admin/04_export/02_1_exportList_safe',$DB); 
            }
            else { return redirect('/'.__('admin.lang').'/'.'admin/login/'); }
            //! Cookie Fonksiyon Kullanımı Son
        }  
        catch (\Throwable $th) {  throw $th; }

    } //! Export Pdf - Kasa Listesi Son

    
    //************* Import ***************** */

    //! importFileUploadControl
    public function importFileUploadControl(Request $request)
    {
        try {

            //! Tanım
            $request->validate(['file' => 'required']);
            
            //! Dosya Boyutu
            $fileSize = $request->file('file')->getSize();  //kb - Boyutu
            $fileSize_kb = round($fileSize/1024,2);
            $fileSize_mb = round($fileSize/1024/1024,2);
            $fileSize_gb = round($fileSize/1024/1024/1024,2);

            $fileSizeTotal = 0;
            $fileSizeTotalType = 'kb';

            if($fileSize_gb >= 1) {  $fileSizeTotal = $fileSize_gb;  $fileSizeTotalType = 'gb';   }
            else if($fileSize_gb < 1) {
                if($fileSize_mb >= 1) {  $fileSizeTotal = $fileSize_mb;  $fileSizeTotalType = 'mb';   }
                else if($fileSize_mb < 1) {  $fileSizeTotal = $fileSize_kb;  $fileSizeTotalType = 'kb';   }
            }
            //! Dosya Boyutu Son

            //! Dosya Yükleme
            $fileName = time().'.'.$request->file->getClientOriginalExtension(); //! Dosya Adı
            $file_status= $request->file->move(public_path('upload/uploads'), $fileName); //! Dosya Yükleme Durumu

            //! Dosya Türü
            $fileExt = request()->file->getClientOriginalExtension(); //! Uzantısı
            $fileType = $_FILES['file']['type']; //! Türü
            $fileType = explode('/',$fileType)[0]; //! Türü Ayırma - > Image

            //! Tanım
            $uploadStatus = false;
            if($file_status) {  $uploadStatus = true; }

            //! Veri Tabanı Kayıt Yapma
            $fileWhere = $request->fileWhere; 
            $fileDbSaveCheck = $request->fileDbSave;
            $fileDbSaveStatus = false;

            if($fileDbSaveCheck == "true") { } //! Veri Tabanına Kayıt 
            //! Veri Tabanı Kayıt Yapma Son

            //! ************** Import *************

            $data ='';
            $fileUrl = "upload/uploads/".$fileName; //! Dosya yeri
            $DB_importStatus = false;
            $DB=[]; //! DB

            if($file_status) {

                if($fileExt == "json") {
                    if(is_file($fileUrl)){ 
                        $data = file_get_contents($fileUrl); //! Dosya Okuyor
                        $DB = json_decode($data,true); //! Veri Json Çeviriyor
                    }
                }

                elseif($fileExt == "xml") {
                    if(is_file($fileUrl)){ 
                        $data = file_get_contents($fileUrl); //! Dosya Okuyor
                        $xmlObject = simplexml_load_string($data); //! Xml Dosyası Okuma
                        $json = json_encode($xmlObject); //! Xml - > Json
                        $DB = json_decode($json, true); //! Veri Json Çeviriyor ;
                    }
                }
            }

            $response = array(
                'status' => $uploadStatus ? 'success' : 'error',
                'userId' => (int)$request->created_byId || 0, 
                'fileDbSaveCheck' => $fileDbSaveCheck,
                'fileDbSaveStatus' => $fileDbSaveStatus,
                'fileWhere' => $fileWhere,
                'file_upload_status'=>$uploadStatus,
                'file_path'=>url('upload/uploads/'.$fileName),
                'file_name'=>$fileName,
                'file_originName'=>request()->file->getClientOriginalName(),
                'file_size'=>array(
                    'sizeByte' => $fileSize,
                    'sizeTotal' => $fileSizeTotal,
                    'sizeTotalType' => $fileSizeTotalType
                ),
                'file_ext'=>$fileExt,
                'file_type'=> $fileType,
                'file_url'=>"upload/uploads/".$fileName,
                'file_url_public'=>public_path('upload\uploads'),
                'DB' => $DB
            );

            return response()->json($response);
             
        } catch (\Throwable $th) { throw $th; }

    }  //! importFileUploadControl Son

    //************* Hata Sayfaları ***************** */

    //! errorAccountBlock
    public function errorAccountBlock($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "Kullanıcı Pasif Sayfası"; die();
        return view('admin/errorAccountBlock');
    } //! errorAccountBlock Son

    //! error500
    public function error500($site_lang="tr")
    {
        \Illuminate\Support\Facades\App::setLocale($site_lang); //! Çoklu Dil
        //echo "500 Hatası Sayfası"; die();
        return view('admin/error500');
    } //! error500 Son

}