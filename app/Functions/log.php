<?php

//! Log Tüm Veriler
function LogAll(){
    
    $dbAll= DB::table('logs')->get();
    return $dbAll;
    
}
//! Log Tüm Veriler Son


//! Log Ara - Filtreleme
function LogFind($LogFindData){

   try {
 
     //echo "<pre>"; print_r($LogFindData); die();
    
     $dbFind= DB::table('logs')->where('created_byId',$LogFindData['created_byId'])->get();

     //! Return
     $DB["title"] =  "Log Ekleme";
     $DB["status"] =  $dbFind ? "success" : "error";
     $DB["DB"] =  $dbFind;
     $DB["LogFindData"] =  $LogFindData;
 
     //echo "<pre>"; print_r($DB); die();  
     
     return $DB;
    
   } catch (\Throwable $th) { throw $th; }
    
    
}
//! Log Ara - Filtreleme Son

//! Log Ekleme
function LogAdd ($logAddData) {
     try {
        
        //! Veri Ekleme
        $dbStatus =  DB::table('logs')->insert([
            'serviceName' => $logAddData['serviceName'],
            'serviceDb' => $logAddData['serviceDb'],
            'serviceDb_Id' => $logAddData['serviceDb_Id'],
            'serviceCode' => $logAddData['serviceCode'],
            'status' => $logAddData['status'],
            'decription' => $logAddData['decription'],
            'created_byId'=> $logAddData['created_byId'],
        ]); //! Veri Ekleme Son
    
        //! Return
        $DB["title"] =  "Log Ekleme";
        $DB["status"] =  $dbStatus;
        $DB["logAddData"] =  $logAddData;

        //echo "<pre>"; print_r($DB); die();  
    
        return $DB;

    } catch (\Throwable $th) { throw $th; }
}
//! Log Ekleme Son