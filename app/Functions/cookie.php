<?php

    //! Çerez Veriler
    function CookieList(){

        $CookieDataList = array(); 
        $CookieDataList["yildirimdev_userCheck"] = 0; //! Kullanıcı Login Durumu [ 1 - 0 ]
        $CookieDataList["yildirimdev_userID"] = 0; //! Kullanıcı Id [ sayı ]
        $CookieDataList["yildirimdev_email"] = ""; //! Kullanıcı Email
        
        $CookieDataList["yildirimdev_name"] = "";  //! Kullanıcı Adı
        $CookieDataList["yildirimdev_surname"] = ""; //! Kullanıcı Soyadı
        $CookieDataList["yildirimdev_img_url"] = ""; //! Kullanıcı Resmi

        $CookieDataList["yildirimdev_departmanID"] = ""; //! Departman
        $CookieDataList["yildirimdev_roleID"] = ""; //! Görev

        //! Return
        return $CookieDataList;

    } //! Çerez Veriler Son

    //! Çerez Kontrol
    function cookieControl() {
        
        //! Tanım
        $isCookie = true; //? Çerez Var Mı
        $CookieDataList =CookieList(); //? Çerez Verileri 
     
        //! Cookie List Key
        $data_keys = array_keys($CookieDataList);
        //echo "<pre>"; print_r($data_keys);  die();

        for ($i=0; $i <count($data_keys) ; $i++) { 
           $cookieDataKeys = $data_keys[$i]; //! Anahtar Kelime
           if(isset($_COOKIE[$cookieDataKeys]))  { $CookieDataList[$cookieDataKeys] = $_COOKIE[$cookieDataKeys]; }  //! Çerez Varsa
           else { $isCookie = false; $CookieDataList[$cookieDataKeys] = null;   } //! Çerez Yoksa
        }
        //! Cookie List Key Son

        //! Return
        $DB["isCookie"] =  $isCookie;
        $DB["CookieDataList"] =  $CookieDataList;

        return $DB; 

    }  //! Çerez Kontrol Son

    //! Çerez Ekle ve Güncelle
    function cookieEdit($CookieData) {

        //! Cookie List Key
        $data_keys = array_keys($CookieData);
        //echo "<pre>"; print_r($data_keys);  die();

        for ($i=0; $i <count($data_keys) ; $i++) { 
            $cookieDataKeys = $data_keys[$i]; //! Anahtar Kelime
            $CookieDataValue = $CookieData[$cookieDataKeys]; //! Cookie Değeri
            setcookie($cookieDataKeys,$CookieDataValue ,time()+86400,'/'); //! Ekleme ve Güncelleme
        }
        //! Cookie List Key Son

        //! Return
        $DB["isCheck"] =  true;
        $DB["CookieData"] =  $CookieData;

        return $DB;          
       
    }  //! Çerez Kontrol Son

    //! Çerez Verileri Sil
    function cookieClear() {

        //! Tanım
        $isCookie = true; //? Çerez Var Mı
        $CookieDataList =CookieList(); //? Çerez Verileri 
     
        //! Cookie List Key
        $data_keys = array_keys($CookieDataList);
        //echo "<pre>"; print_r($data_keys);  die();

        for ($i=0; $i <count($data_keys) ; $i++) { 
           $cookieDataKeys = $data_keys[$i]; //! Anahtar Kelime
           try { setcookie($cookieDataKeys,"" ,time() - 86400,'/'); } catch (\Throwable $th) { } //throw $th;
        }
        //! Cookie List Key Son

       //! Return
       $DB["isCheck"] =  true;
       return $DB;          
    }
    //! Çerez Verileri Sil Son

