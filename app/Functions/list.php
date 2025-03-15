<?php
    
    //! List Fonksiyon
    function List_Function($dbName, $infoData = [], $groupData = [], $selectData = [], $selectDataRaw = [], $joinData = [], $searchDataList = [], $whereDataList = []){

        //! Tanım
        $parameter_all = request()->all(); //! Tüm Params Veriler
        $data_keys = array_keys($parameter_all); //! Tüm Params Keys
        $data_all= []; //! Tüm Arama
        $data_all_in= []; //! Tüm Arama
        $dataTime_all= []; //! Tüm Zaman Eklenecek
        $newUrl=[]; //! Yeni Url
        $data_count = count(request()->all()); //! Params Sayısı
        $isGroup = true;  //! Grup İzin Var mı

        //! Bilgiler
        $newUrl["page"] = (int)$infoData[0]["page"]-1; //! Sayfa Numarası
        $newUrl["rowcount"] = $infoData[0]["rowcount"]; //! Sayfada Gösterecek Veri Sayısı
        $newUrl["order"] = $infoData[0]["order"];  //! Sıralama [asc = Küçükten -> Büyüğe] [ desc = Büyükten -> Küçüğe ]
        $orderBy = $infoData[0]["orderBy"];  //! Sıralanacak Sutun

        //! Params Verilerini Okuma
        for ($i=0; $i < count(request()->all()) ; $i++) { 

            //! Tanım
            $newParams= null;
            $isCheck = false; //! Ekleme İzin
            $isAddTime = false; //! Zaman Ekleme İzin
            $data_search_key = []; //! Arama Data
            $data_key_item = $data_keys[$i]; //! Anahtar Kelime * [test.isActive]
            $data_item = $parameter_all[$data_key_item]; //! Arama Sonuc  * [1]
            $data_item_object = "="; //! [=]

            //! Sayfalandırmak için yeni url oluşturuyor
            if($data_key_item == "page") { $isCheck = false; $page = $data_item-1; if($page <= 0) { $page = 0; } $newUrl["page"] = $page;  }
            else if($data_key_item == "rowcount") { $isCheck = false;  $newUrl["rowcount"] = $data_item; } 
            else if($data_key_item == "order") { $isCheck = false;  $newUrl["order"] = $data_item; }
            else if($data_key_item == "dashboardview") { $isCheck = false;  $newUrl["dashboardview"] = $data_item; }
            else { $isCheck = true; $newUrl[$data_key_item] = $data_item; }
            //! Sayfalandırmak için yeni url oluşturuyor SON

            //! Params Kontrol
            if($data_item == "all") { $isCheck = false;} //! Tümü Gösterme
            if($data_key_item == "nogroup") { $isCheck = false; $isGroup = $data_item == "false" ? false : true;  } //! Gruplandırma

            //! searchDataList
            if($isCheck) {
                for ($y=0; $y < count($searchDataList); $y++) {  
                    if( $data_key_item == $searchDataList[$y]["params"] ) { 

                        $data_key_item = $searchDataList[$y]["table"].".".$searchDataList[$y]["where"]; //! [test.id]
                        $data_item_object=$searchDataList[$y]["data_item_object"]; //! [=]

                        if($searchDataList[$y]["data_key_type"] == "int") { $data_item = (int)$data_item; }
                        else if($searchDataList[$y]["data_key_type"] == "date") {  $isCheck = false; $isAddTime = true;}

                        if($searchDataList[$y]["data_item_object"] == "likeStart") { $data_item =$data_item."%";  $data_item_object="like"; } //! Like
                        else if($searchDataList[$y]["data_item_object"] == "likeEnd") { $data_item ="%".$data_item; $data_item_object="like"; } //! Like
                        else if($searchDataList[$y]["data_item_object"] == "likeBoth") { $data_item ="%".$data_item."%"; $data_item_object="like"; } //! Like
                        
                        break;
                    }  
                } 
            } 
            //! searchDataList Son
            
            //! Ekleme Yapıyor
            array_push($data_search_key,$data_key_item); //! id
            array_push($data_search_key,$data_item_object); //! =
            array_push($data_search_key,$data_item); //1 

            //! Arama Yapılacak Verileri Ekleme
            if($isCheck) { $data_all[] = $data_search_key; } //! Where Ekleme
            if($isAddTime) { $dataTime_all[] = $data_search_key; } //! Where Zaman Ekleme
        }
        //! Params Verilerini Okuma Son
        
        //echo "<pre>"; print_r($dataTime_all); die();
        //echo "<pre>"; print_r($data_all); die();

        //! Where
        for ($k=0; $k < count($whereDataList); $k++) { 

            //! Tanım
            $data_search_key = []; //! Arama Data
            $data_key_item = $whereDataList[$k]["table"].".".$whereDataList[$k]["where"]; //! [ test.created_at ]
            $data_item_object = $whereDataList[$k]["data_item_object"]; //! [=]
            $data_item_value = $whereDataList[$k]["value"]; //! [56]
            //echo "<pre>"; print_r($whereDataList); die();

            //! Json Filter
            $results = [];
            
            //! Veri Varmı Kontrol Ediyor ve Ekliyor
            foreach ($data_all as $item) {  
                if ($item[0] == $data_key_item && $item[1] == $data_item_object ) { $results[] = $item; }
            }

            //! Ekleme Yapıyor
            if(count($results) == 0 && $data_item_object != "multi" ) {
                array_push($data_search_key,$data_key_item); //! [ test.created_at ]
                array_push($data_search_key,$data_item_value); //1

                //! Arama Yapılacak Verileri Ekliyor
                $data_all[] = $data_search_key;
            }
            //! Ekleme Yapıyor Son

            //! Json Filter
            $results_IN = [];

            //! IN - Veri Varmı Kontrol Ediyor ve Ekliyor
            foreach ($data_all_in as $item) {  
                if ($item[0] == $data_key_item && $item[1] == $data_item_object ) { $results_IN[] = $item; }
            }

            //! IN - Ekleme Yapıyor
            if(count($results) == 0 && $data_item_object == "multi" ) {

                $ids = explode(",", $data_item_value);

                array_push($data_search_key,$data_key_item); //! [ test.created_at ]
                array_push($data_search_key,$ids); //! Array

                //! Arama Yapılacak Verileri Ekliyor
                $data_all_in[] = $data_search_key;
            }
            //! IN - Ekleme Yapıyor Son
        }
        //echo "<pre>"; print_r($data_all_in); die();
        //echo "<pre>"; print_r($data_all); die();
        //! Where Son

        //! Select
        $selectDb = array();
        for ($i=0; $i < count($selectData) ; $i++) { 
            $selectValue = $selectData[$i]["table"].".".$selectData[$i]["parametre"]; //! [logs.*]
            if($selectData[$i]["parametre"] != "*" && $selectData[$i]["name"] != null ) { $selectValue = $selectValue." as ".$selectData[$i]["name"]; } //! [users.name as userName]
            $selectDb[] = $selectValue; ; //! Veri Ekleme
        }

        for ($i=0; $i < count($selectDataRaw) ; $i++) {  $selectDb[] = $selectDataRaw[$i];  } //! Select Raw Ekle
        //echo "<pre>"; print_r($selectDb); die();
        //! Select Son

        //! Veri Tabanı Kullanımı
        $db= DB::table($dbName);

        //! Group
        if( (count($groupData) > 0) && $isGroup ) { for ($i=0; $i < count($groupData); $i++) {  $db->groupBy($groupData[$i]); } }

        //! Join
        for ($i=0; $i <count($joinData) ; $i++) {
           $db = $db->leftJoin($joinData[$i]["table"],$joinData[$i]["table"].".".$joinData[$i]["value"],'=',$joinData[$i]["refTable"].'.'.$joinData[$i]["refValue"]);
        }
        //! Join Son

        //! Where
        if(count($selectDb) > 0) { $db = $db->select(DB::raw(join(',',$selectDb))); } //! Select
        $db = $db->where($data_all); //! Arama

        //! Where - Çoklu
        for ($i=0; $i <count($data_all_in) ; $i++) {  $db = $db->whereIn($data_all_in[$i][0], $data_all_in[$i][1]); }
        
        //die();
        
        //! Where - Tarih
        for ($i=0; $i <count($dataTime_all) ; $i++) { $db = $db->whereDate($dataTime_all[$i][0],$dataTime_all[$i][1],$dataTime_all[$i][2]);  }
        
        $dbTop = $db->get()->count(); //! Tüm Veri Sayısı
        //echo $db->toSql(); die();
        //echo "<pre>"; print_r($db->get()); die();

        //echo "<pre>"; print_r($dbTop); die();

        //! Veriler
        $dbFind= []; //! Sql
        $page = $newUrl["page"];
        $rowcount = $newUrl["rowcount"];
        $order = $newUrl["order"];
        if($rowcount == "all") { $db = $db->orderBy($orderBy,$order); $rowcount = $dbTop;}
        else { $db = $db->skip($rowcount*$page)->take($rowcount)->orderBy($orderBy,$order); }

        //! Sayfa Sayısı Hesaplama
        $dbFind = $db->get();
        $dbSize = count($dbFind); //! Sayfaki Veri Sayısı
        $pageNow = $dbSize > 0 ? $page+1 : 0 ; //! Bulunduğu Sayfa
        $pageTop = 0; //! Toplam Sayfa
        if($dbTop > 0) { $pageTop = ceil($dbTop / $rowcount); } //! Toplam Sayfa
        //! Sayfa Sayısı Hesaplama Son

        //echo "<pre>";  print_r($dbFind); die();

        //! List Object Key
        $tableColumns = count($dbFind) > 0 ? array_keys(json_decode(json_encode($dbFind[0]), true)) : [];
        //echo "<pre>";  print_r($tableColumns); die();
        //! List Object Key Son
        
        //! Yeni Url Birleştirme
        function newUrlJoin($newUrl) {
            $data_keys = array_keys($newUrl); 
            $JoinNewUrl = array();

            for ($i=0; $i < count($data_keys); $i++) { 
                $data_keys_item = $data_keys[$i]; 
                $JoinNewUrl[] = $data_keys_item."=".$newUrl[$data_keys_item]; 
            }
            return "?".join("&",$JoinNewUrl);
        }
        //echo newUrlJoin($newUrl);  die();
        //! Yeni Url Birleştirme Son

        //! Pagination Fonksiyon Kullanımı
        $pagination = paginate(["current" => $pageNow, "max" => $pageTop]);
        //echo "<pre>";  print_r($pagination); die();

        if( $pagination["prev"]["page"] ) { $newUrl["page"] = $pagination["prev"]["page"]; $pagination["prev"]["url"] =newUrlJoin($newUrl); }
        if( $pagination["next"]["page"] ) { $newUrl["page"] = $pagination["next"]["page"]; $pagination["next"]["url"] =newUrlJoin($newUrl); }
        
        for ($i=0; $i <count($pagination["items"]) ; $i++) { $newUrl["page"] = $pagination["items"][$i]["page"]; $pagination["items"][$i]["url"] = newUrlJoin($newUrl); }
        
        //echo "<pre>";  print_r($pagination); die();
        //echo "<pre>";  print_r($pagination["items"]); die();
        //! Pagination Fonksiyon Kullanımı Son

    
        //! Return
        $DB["page"]=$page; //! Sayfa Numarası
        $DB["rowcount"]=$rowcount == $dbTop ? "all" : $rowcount; //! Sayfada Gösterecek Veri Sayısı
        $DB["orderBy"]=$orderBy; //! Sıralanacak Sutun
        $DB["order"]=$order; //! Sıralama [asc = Küçükten -> Büyüğe] [ desc = Büyükten -> Küçüğe ]
        $DB["where"]=$data_all; //! Where
        $DB["sql"]=$db->toSql(); //! Sql

        $DB["dbTop"] =  $dbTop; //! Tüm Veri Sayısı
        $DB["dbSize"] =  $dbSize; //! Sayfaki Veri Sayısı
        $DB["dbFind"] =  $dbFind; //! Tüm Veriler
        $DB["tableColumns"] =  $tableColumns; //! Veri Table y
        $DB["pagination"] =  $pagination; //! Pagination
       
        //echo "<pre>"; print_r($DB); die(); //! Return
        return $DB;

    } //! List Fonksiyon Son
    
    //! Pagination Fonksiyon
    function paginate(array $params) { 
        extract($params);
        if (!isset($current) || !isset($max)) return null;
    
        $prev = (int)$current <= 1 ? null : $current - 1; //! Öncesi
        $next = (int)$current === (int)$max ? null : $current + 1; //! Sonrası
        $items = [array("title" => 1,"page"=>1,"url" => 1)]; //! Veriler

        if ($current == 0 && $max == 0){
            return [
                "current" => $current,
                "max" => $max,
                "prev" => ["page"=>$prev,"url" => $prev],
                "next" => ["page"=>$next,"url" => $next],
                "items" => [],
            ];
        }
    
        if ($current == 1 && $max == 1){
            return [
                "current" => $current,
                "max" => $max,
                "prev" => ["page"=>$prev,"url" => $prev],
                "next" => ["page"=>$next,"url" => $next],
                "items" => $items,
            ];
        }
        if ($current > 4) { array_push($items, array("title" => "…","page"=>2,"url" => 2)); }
    
        $r = 2;
        $r1 = $current - $r;
        $r2 = $current + $r;
    
        for ($i = $r1 > 2 ? $r1 : 2; $i <= min($max, $r2); $i++) array_push($items, array("title" => $i,"page"=>$i,"url" => $i ));
    
        if ($r2 + 1 < $max) array_push($items, array("title" => "…","page"=>$max-1,"url" => $max-1));
        if ($r2 < $max) array_push($items, array("title" => $max,"page"=>$max,"url" => $max ));
    
        return [
            "current" => $current,
            "max" => $max,
            "prev" => ["page"=>$prev,"url" => $prev],
            "next" => ["page"=>$next,"url" => $next],
            "items" => $items,
        ];
    } //! Pagination Fonksiyon Son