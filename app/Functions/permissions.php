<?php

//! Kullanım izinleri -  Tüm Veriler
function permissonAll(){

    $dbAll= DB::table('permissions')->get();
    return $dbAll;
    
}
//! Kullanım izinleri -  Tüm Veriler Son

//! Kullanım izinleri -  Veri Arama
function permissonFind($dbFindData){

    //echo "<pre>"; print_r($dbFindData); die();

    $dbAll= DB::table('permissions')->where('service',$dbFindData['service'])->get();
    return $dbAll;
    
}
//! Kullanım izinleri -  Veri Arama Son

//! Yetki Listesi
function permissionsUserList() {

    //! departman = 2
    //! role = 3
    //! user = 1

    //! Yetki Listesi
    $dbFindData = [];
    $dbFindData["departman_id"] = $_COOKIE["yildirimdev_departmanID"]; //? Departman Id [ 1 ] 
    $dbFindData["role_id"] = $_COOKIE["yildirimdev_roleID"]; //? Role Id [ 1 ]  
    //$dbFindData["user_id"] = 2; //? Kullanıcı Id [ 1 ] 
    $dbFindData["user_id"] = $_COOKIE["yildirimdev_userID"]; //? Kullanıcı Id [ 1 ] 
    //echo "<pre>"; print_r($dbFindData); die(); 

    //! Departman - Muhasebe
    $dbFind_departman= DB::table("permissions_departman")
    ->join('permissions', 'permissions.id', '=', 'permissions_departman.permission_id')
    ->select('permissions_departman.*', 'permissions.service as permissionsService','permissions.slug as permissionsSlug','permissions.title as permissionsTitle','permissions.description as permissionsDescription')
    ->where('departman_id',$dbFindData['departman_id'])
    ->where('status',1)
    ->orderBy('permission_id','asc')
    ->get(); //! Departman - Muhasebe - Son

    //! Role - Muhasebe Müdürü
    $dbFind_role= DB::table("permissions_role")
    ->join('permissions', 'permissions.id', '=', 'permissions_role.permission_id')
    ->select('permissions_role.*', 'permissions.service as permissionsService','permissions.slug as permissionsSlug','permissions.title as permissionsTitle','permissions.description as permissionsDescription')
    ->where('role_id',$dbFindData['role_id'])
    ->orderBy('permission_id','asc')
    ->get(); //! Role - Muhasebe Müdürü - Son

    //! Kullanıcı
    $dbFind_user= DB::table("permissions_users")
    ->join('permissions', 'permissions.id', '=', 'permissions_users.permission_id')
    ->select('permissions_users.*', 'permissions.service as permissionsService','permissions.slug as permissionsSlug','permissions.title as permissionsTitle','permissions.description as permissionsDescription')
    ->where('user_id',$dbFindData['user_id'])
    ->orderBy('permission_id','asc')
    ->get(); //! Kullanıcı - Son

    //! Yetkiler
    $dbFind_permissions = []; //! Yetkiler
    $removeKeys = array(); //! Silinecek Veriler

    for ($i=0; $i < count($dbFind_departman) ; $i++) {  $dbFind_permissions[] = $dbFind_departman[$i]; } //! Departman - Muhasebe

    //! Role  - Görev - Muhasebe Müdürü
    //echo "<pre>"; print_r($dbFind_role); die();
    for ($i=0; $i < count($dbFind_role) ; $i++) {  
        //echo "permission_id: "; echo $dbFind_role[$i]->permission_id; echo " Durum: "; echo $dbFind_role[$i]->status; echo " ";  echo "<br>";

        $arrayInFindexIndex  = array_search($dbFind_role[$i]->permission_id, array_column($dbFind_permissions, 'permission_id')); //! Veri Arıyor
        
        if($arrayInFindexIndex != "" && $dbFind_role[$i]->status == 0 ) { $removeKeys[] = $arrayInFindexIndex; } //! Veri Siliyor
        if($arrayInFindexIndex == "" && $dbFind_role[$i]->status == 1 ) { $dbFind_permissions[] = $dbFind_role[$i];  }
    }
    
    $dbFind_permissions = array_diff_key($dbFind_permissions, array_flip($removeKeys)); //! Verileri Kaldırıyor
    $removeKeys = array(); //! Silinecek Verileri Sıfırlıyor
    //! Role  - Görev Son

    //! Sıralama
    $key_values = array_column($dbFind_permissions, 'permission_id'); //! Sutun Verileri [permissionsId] verisine göre
    array_multisort($key_values, SORT_ASC, $dbFind_permissions); //! Sıralama Yapıyor
    //echo "<pre>"; print_r($dbFind_permissions); die();
    
    
    //! User  - Kullanıcı
    //echo "<pre>"; print_r($dbFind_user); die();
    for ($i=0; $i < count($dbFind_user) ; $i++) {  
        //echo "permission_id: "; echo $dbFind_user[$i]->permission_id; echo " Durum: "; echo $dbFind_user[$i]->status; echo " ";  echo "<br>";

        $arrayInFindexIndex  = array_search($dbFind_user[$i]->permission_id, array_column($dbFind_permissions, 'permission_id')); //! Veri Arıyor

        if($arrayInFindexIndex != "" && $dbFind_user[$i]->status == 0 ) { $removeKeys[] = $arrayInFindexIndex; } //! Veri Siliyor
        if($arrayInFindexIndex == "" && $dbFind_user[$i]->status == 1 ) { $dbFind_permissions[] = $dbFind_user[$i];  }
    }
   
    $dbFind_permissions = array_diff_key($dbFind_permissions, array_flip($removeKeys)); //! Verileri Kaldırıyor
    $removeKeys = array(); //! Silinecek Verileri Sıfırlıyor
    //! User  - Kullanıcı Son

    //! Sıralama
    $key_values = array_column($dbFind_permissions, 'permission_id'); //! Sutun Verileri [permissionsId] verisine göre
    array_multisort($key_values, SORT_ASC, $dbFind_permissions); //! Sıralama Yapıyor
    //echo "<pre>"; print_r($dbFind_permissions); die();

    //! Return
    $DB["dbFind_departman"] =  $dbFind_departman; //! Departman - Muhasebe
    $DB["dbFind_role"] =  $dbFind_role; //! Role  - Görev - Muhasebe Müdürü
    $DB["dbFind_user"] =  $dbFind_user; //! Kullanıcı

    $DB["dbFind_permissions"] =  $dbFind_permissions; //! Yetki Listesi

    return $DB;
}
//! Yetki Listesi Son

//! Yetki Listesi - Veri Arama
function permissionsUserFind($dbFindData = []) {

    //! departman = 2
    //! role = 3
    //! user = 1

    //! Yetki Listesi
    $dbFindData["departman_id"] = $_COOKIE["yildirimdev_departmanID"]; //? Departman Id [ 1 ] 
    $dbFindData["role_id"] = $_COOKIE["yildirimdev_roleID"]; //? Role Id [ 1 ]  
    //$dbFindData["user_id"] = 2; //? Kullanıcı Id [ 1 ] 
    $dbFindData["user_id"] = $_COOKIE["yildirimdev_userID"]; //? Kullanıcı Id [ 1 ] 
    //echo "<pre>"; print_r($dbFindData); die(); 

    //! Departman - Muhasebe
    $dbFind_departman= DB::table("permissions_departman")
    ->join('permissions', 'permissions.id', '=', 'permissions_departman.permission_id')
    ->select('permissions_departman.*', 'permissions.service as permissionsService','permissions.slug as permissionsSlug','permissions.title as permissionsTitle','permissions.description as permissionsDescription')
    ->where('departman_id',$dbFindData['departman_id'])
    ->where('status',1)
    ->where('permissions.service',$dbFindData['service'])
    ->orderBy('permission_id','asc')
    ->get(); //! Departman - Muhasebe - Son

    //! Role - Muhasebe Müdürü
    $dbFind_role= DB::table("permissions_role")
    ->join('permissions', 'permissions.id', '=', 'permissions_role.permission_id')
    ->select('permissions_role.*', 'permissions.service as permissionsService','permissions.slug as permissionsSlug','permissions.title as permissionsTitle','permissions.description as permissionsDescription')
    ->where('role_id',$dbFindData['role_id'])
    ->where('permissions.service',$dbFindData['service'])
    ->orderBy('permission_id','asc')
    ->get(); //! Role - Muhasebe Müdürü - Son

    //! Kullanıcı
    $dbFind_user= DB::table("permissions_users")
    ->join('permissions', 'permissions.id', '=', 'permissions_users.permission_id')
    ->select('permissions_users.*', 'permissions.service as permissionsService','permissions.slug as permissionsSlug','permissions.title as permissionsTitle','permissions.description as permissionsDescription')
    ->where('user_id',$dbFindData['user_id'])
    ->where('permissions.service',$dbFindData['service'])
    ->orderBy('permission_id','asc')
    ->get(); //! Kullanıcı - Son

    //! Yetkiler
    $dbFind_permissions = []; //! Yetkiler
    $removeKeys = array(); //! Silinecek Veriler

    for ($i=0; $i < count($dbFind_departman) ; $i++) {  $dbFind_permissions[] = $dbFind_departman[$i]; } //! Departman - Muhasebe

    //! Role  - Görev - Muhasebe Müdürü
    //echo "<pre>"; print_r($dbFind_role); die();
    for ($i=0; $i < count($dbFind_role) ; $i++) {  
        //echo "permission_id: "; echo $dbFind_role[$i]->permission_id; echo " Durum: "; echo $dbFind_role[$i]->status; echo " ";  echo "<br>";

        $arrayInFindexIndex  = array_search($dbFind_role[$i]->permission_id, array_column($dbFind_permissions, 'permission_id')); //! Veri Arıyor
        
        if($arrayInFindexIndex != "" && $dbFind_role[$i]->status == 0 ) { $removeKeys[] = $arrayInFindexIndex; } //! Veri Siliyor
        if($arrayInFindexIndex == "" && $dbFind_role[$i]->status == 1 ) { $dbFind_permissions[] = $dbFind_role[$i];  }
    }
    
    $dbFind_permissions = array_diff_key($dbFind_permissions, array_flip($removeKeys)); //! Verileri Kaldırıyor
    $removeKeys = array(); //! Silinecek Verileri Sıfırlıyor
    //! Role  - Görev Son

    //! Sıralama
    $key_values = array_column($dbFind_permissions, 'permission_id'); //! Sutun Verileri [permissionsId] verisine göre
    array_multisort($key_values, SORT_ASC, $dbFind_permissions); //! Sıralama Yapıyor
    //echo "<pre>"; print_r($dbFind_permissions); die();
    
    
    //! User  - Kullanıcı
    //echo "<pre>"; print_r($dbFind_user); die();
    for ($i=0; $i < count($dbFind_user) ; $i++) {  
        //echo "permission_id: "; echo $dbFind_user[$i]->permission_id; echo " Durum: "; echo $dbFind_user[$i]->status; echo " ";  echo "<br>";

        $arrayInFindexIndex  = array_search($dbFind_user[$i]->permission_id, array_column($dbFind_permissions, 'permission_id')); //! Veri Arıyor

        if($arrayInFindexIndex != "" && $dbFind_user[$i]->status == 0 ) { $removeKeys[] = $arrayInFindexIndex; } //! Veri Siliyor
        if($arrayInFindexIndex == "" && $dbFind_user[$i]->status == 1 ) { $dbFind_permissions[] = $dbFind_user[$i];  }
    }
   
    $dbFind_permissions = array_diff_key($dbFind_permissions, array_flip($removeKeys)); //! Verileri Kaldırıyor
    $removeKeys = array(); //! Silinecek Verileri Sıfırlıyor
    //! User  - Kullanıcı Son


    //! Sıralama
    $key_values = array_column($dbFind_permissions, 'permission_id'); //! Sutun Verileri [permissionsId] verisine göre
    array_multisort($key_values, SORT_ASC, $dbFind_permissions); //! Sıralama Yapıyor
    //echo "<pre>"; print_r($dbFind_permissions); die();

    //! Return
    $DB["dbFind_departman"] =  $dbFind_departman; //! Departman - Muhasebe
    $DB["dbFind_role"] =  $dbFind_role; //! Role  - Görev - Muhasebe Müdürü
    $DB["dbFind_user"] =  $dbFind_user; //! Kullanıcı

    $DB["dbFind_permissions"] =  $dbFind_permissions; //! Yetki Listesi

    return $DB;
}
//! Yetki Listesi  - Veri Arama Son

?>