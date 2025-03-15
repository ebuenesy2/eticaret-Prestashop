<?php 

//! Üst
function levelList($dbName){

   //! Tanım
   $levels= DB::table($dbName)->get(); //! Veri Tabanı
   $buildTree = buildTree($levels,0);

   //! Return
   $DB["title"] =  $dbName; //! Veri Tabanı Adı
   $DB["tree"] =  $buildTree; //! Veriler


   return $DB;
} //! Üst Son

//! Alt 
function buildTree($elements,$parentId = 0){

   $tree = array();

   foreach($elements as $element) {
      if($element->parent_id == $parentId){

        $sub = buildTree($elements,$element->id);
        if($sub) { $element->sub = $sub; }
        else { $element->sub = array(); }

        $tree[] = $element;
      }
   }

   //! Return
   $DB =  $tree; //! Veriler
 
   return $DB;
} //! Alt Son

//! Element Html
function drawElements($items) {

    echo "<ul>";
    
       foreach ($items as $item) {
        echo "<li> id: ".$item->id." title: ".$item->title." slug: ".$item->slug." </li>";
        if(sizeof($item->sub) > 0) { drawElements($item->sub); }
       }
       
    echo "</ul>";
}  //! Element Html Son

//*****  Menulist *******/

//! MenuList
function menuList($dbName) {  

   //echo "dbName:"; echo $dbName; die();

   //! Tanım
   $db= DB::table($dbName); //! Veri Tabanı
   $levels= $db->orderby('orderId','asc')->where('isActive',1)->get(); //! Veri Tabanı
   $items = buildTree($levels,0); //! Verileri Ağaçlandırma

   $dbFind_parent = $db->where('route_name',Route::current()->getName())->first(); //! Bulunduğu sayfa Veri Tabanından Veri Alma
   $dbFind_parentId = $dbFind_parent ?  $dbFind_parent->parent_id :  null; //! Parent Id
   $dbFind_Id = $dbFind_parent ? $dbFind_parent->id : null; //! Id

   //echo "Bulunduğu Sayfa"; echo Route::current()->getName(); die();
   //echo "<pre>"; print_r($dbFind_parent); die();
   //echo "dbFind_parentId:"; echo $dbFind_parentId; die();
   
   foreach ($items as $item) { 
     
      $menuVisible= $dbFind_parentId == $item->id ? true : false; //! Görünürlük
      
      $returnHtml = $menuVisible ? '<li class="sub-menu open" >' : '<li class="sub-menu"  >'; //! sub-menu open
      
      //! Link
      if(sizeof($item->sub) > 0) { $returnHtml = $returnHtml .'<a href="javascript:;" class="">'; }
      else { $returnHtml = $returnHtml .'<a href="/'.__('admin.lang').$item->slug.'" class="">'; }

      $returnHtml = $returnHtml .'<i class="'.$item->icon.'"></i>'; //! icon
      
      //! Title
      if( __('admin.lang') == "en") { $returnHtml = $returnHtml .'<span>'.$item->en.'</span>'; }
      else if( __('admin.lang') == "de") { $returnHtml = $returnHtml .'<span>'.$item->de.'</span>'; }
      else { $returnHtml = $returnHtml .'<span>'.$item->tr.'</span>'; }

      //! Arrow
      if(sizeof($item->sub) > 0) { 
         $returnHtml = $menuVisible ? $returnHtml .'<span class="arrow open"></span>' : $returnHtml .'<span class="arrow"></span>';
      }
      $returnHtml = $returnHtml .'</a>';

      //! Alt Menu
      if(sizeof($item->sub) > 0) {$returnHtml = $returnHtml . subMenuList($item->sub,$item->route_name,$menuVisible,$dbFind_Id); }

      $returnHtml = $returnHtml . '</li>';

      //! Return
      echo $returnHtml;
   }

}  //! MenuList Son


//! Alt MenuList
function subMenuList($items,$routeName,$menuVisible,$subId) { 
   
   // $testListControl["items"] = $items;
   // $testListControl["routeName"] = $routeName;
   // $testListControl["menuVisible"] = $menuVisible;
   // $testListControl["subId"] = $subId;
   
   // echo "<pre>";  print_r($testListControl); die();
   

   $returnHtml = $menuVisible ? '<ul class="sub" style="display: block;">' : '<ul class="sub" style="display: none;">' ;
  
   foreach ($items as $item) { 
      $returnHtml_Li = $subId == $item->id ? '<li class="active">' : '<li class="">';
      $returnHtml = $returnHtml . $returnHtml_Li.'<a class="" href="/'.__('admin.lang').$item->slug.'">'; //! Link
      
      //! Title
      if( __('admin.lang') == "en") { $returnHtml = $returnHtml .$item->en; }
      else if( __('admin.lang') == "de") { $returnHtml = $returnHtml .$item->de;  }
      else { $returnHtml = $returnHtml .$item->tr;  }

      $returnHtml = $returnHtml .'</a></li>';
   }

   $returnHtml = $returnHtml . '</ul>';

   //! Return
   return $returnHtml;

}  //! Alt MenuList Son

//*****  Menulist Son *******/