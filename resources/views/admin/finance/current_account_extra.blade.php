<!DOCTYPE html>

<!-- Head -->
<title> @lang('admin.currentAccount') Extra (#{{$id}}) {{$title}} | {{ config('admin.Admin_Title') }} </title>
@include('admin.include.head')

<!-- Tanım -->
<?php $homeUrl = '/admin'; ?>
<?php $listTitle = 'Cari Hesap Extra #'.$id." ".$title; ?>
<?php $listUrl = "/admin/setting/menu";  ?>

<!-- Yıldırımdev Table Css -->
<link href="{{asset('/assets/admin/yildirimdev')}}/css/yildirimdev_table.css" rel="stylesheet" type="text/css" />

<!-- BEGIN BODY -->
<body class="fixed-top" id="listInfoData" page={{$page}} rowCountData={{$rowcount}} orderData={{$order}} > 
    
    <!-- Header -->
    @include('admin.include.header')

   <!-- BEGIN CONTAINER -->
   <div id="container" class="row-fluid">
      <!-- BEGIN SIDEBAR -->
      <div class="sidebar-scroll">

        <!-- Sidebar -->
        @include('admin.include.sidebar')

      </div>
      <!-- END SIDEBAR -->
      <!-- BEGIN PAGE -->
      <div id="main-content">
         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->
            <div class="row-fluid">
               <div class="span12">
                   
                  <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                   <h3 class="page-title"> {{$listTitle}} </h3>
                   <ul class="breadcrumb">
                       <li>
                          <a href="/@lang('admin.lang'){{$homeUrl}}">@lang('admin.home')</a>
                          <span class="divider">/</span>
                       </li>
                       <li>
                          <a href="/@lang('admin.lang')/admin/current/account">@lang('admin.currentAccount')</a>
                          <span class="divider">/</span>
                       </li>
                       <li class="active"> {{$listTitle}} </li>
                   </ul>
                   <!-- END PAGE TITLE & BREADCRUMB-->
               </div>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
             <div class="row-fluid">

              <!--- List -->
              <div class="widget red">
                  <div class="widget-title">
                    <h4><i class="fa fa-edit"></i> {{$listTitle}} </h4>
                    <span class="tools">
                        <a href="javascript:;" class="fa fa-chevron-down"></a>
                        <a href="javascript:;" class="fa fa-remove"></a>
                    </span>
                  </div>
                  <div class="widget-body">
                    <div>
                      <div class="clearfix">
                         
                        <div style="display:flex;gap: 5px;flex-wrap: wrap;margin-bottom: 25px;" >

                          <!-- Modal -->
                          <button class="btn btn-success" href="#addModal" role="button" data-toggle="modal" >
                            <i class="fa fa-plus icon-white"></i> @lang('admin.newAdd')  
                          </button>
                          <!-- Modal Son -->

                          <div id='loader' style="display: flex;width: 20px;"><img src="/upload/images/loader.gif" alt=""></div>

                        </div>                          

                        <!------  Tablo Üst - Arama ----->
                        <div class="row-fluid" style="margin-top:10px;display: flex;gap: 5px;flex-wrap: wrap;" >

                          <!------ Arama ID ----->
                          <div style="display: flex;flex-direction: column;">
                            <p>ID</p>
                            <input type="number" placeholder="id" class="" id="searchTable" searchName="Id" style="width: 120px;" >
                          </div>
                          <!------ Arama ID Son----->

                          <!-- Arama Takvim Arası -->
                          <div style="display: flex;flex-direction: column;" >
                            <p>Tarih Başlangıç</p>
                            <input type="date" class="" style="cursor: pointer; width: 120px; cursor: pointer;"  id="searchTable" searchName="DateStart" >
                          </div>
                          
                          <div style="display: flex;flex-direction: column;" >
                            <p>Tarih Bitiş</p>
                            <input type="date" class="" style="cursor: pointer; width: 120px; cursor: pointer;"  id="searchTable" searchName="DateFinish" >
                          </div>
                          <!-- Arama Takvim Arası Son -->
                          
                          <!------ Arama Tür ----->
                          <div style="display: flex;flex-direction: column;" >
                            <p> @lang('admin.type')</p>
                            <select class="" style="cursor: pointer; width: 120px;" id="searchTable" searchName="Type"  >
                                <option value="">@lang('admin.all')</option>
                                <option value="1" >Gelir</option>
                                <option value="2" >Gider</option>
                                <option value="3" >Hizmet</option>
                            </select>
                          </div>
                          <!------ Arama Tür Son----->

                          <!------ Arama İş Hizmet ----->
                          <div style="display: flex;flex-direction: column;" >
                            <p> İş Hizmet</p>
                            <select class="" style="cursor: pointer; width: 120px;" id="searchTable" searchName="BusinessAccount"  >
                                <option value="">@lang('admin.all')</option>
                                <option value="0" >Diğer</option>
                                @for ($i = 0; $i < count($DB_Business_Account); $i++)
                                <option value="{{$DB_Business_Account[$i]->id}}" >{{$DB_Business_Account[$i]->title}}</option>
                                @endfor
                            </select>
                          </div>
                          <!------ Arama İş Hizmet Son----->
                          
                          <!------ Arama Başlık ----->
                          <div style="display: flex;flex-direction: column;">
                            <p>İş Hizmet Başlık</p>
                            <input type="text" class="" style="width: 120px;"   id="searchTable" searchName="Title" >
                          </div>
                          <!------ Arama Başlık Son----->

                          <!------ Arama - İşlem Durumu ----->
                          <div style="display: flex;flex-direction: column;" >
                            <p> İşlem Durumu</p>
                            <select class="" style="cursor: pointer; width: 120px;" id="searchTable" searchName="ActiveType"  >
                                <option value="">@lang('admin.all')</option>
                                <option value="1" >Tamamlandı</option>
                                <option value="2" >Planlandırıldı</option>
                                <option value="3" >Tekliflendirildi</option>
                            </select>
                          </div>
                          <!------ Arama - İşlem Durumu Son ----->
                          
                        </div>
                        <!------  Tablo Üst -Arama Son ----->

                        <hr>

                        <!-- Filtreleme Temizle -->
                        <button class="btn btn-danger" id="filter_delete_all" > <i class="fa fa-trash  icon-white"></i> Filtreleme Temizle </button>
                        <!-- Filtreleme Temizle Son -->

                        <hr>
                        
                        <!------  Tablo Üst - Sonucları Gösterme - Tüm Zamanların --------->
                        <div style="display: flex;gap: 5px;flex-wrap: wrap;margin-bottom:10px;" >
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Toplam İşlem</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalCount}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Toplam Gelir</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalIncomePrice}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Toplam Gider</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalExpensePrice}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Toplam Bakiye</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalPrice}}</p>
                          </div>
                        </div>
                        <div style="display: flex;gap: 5px;flex-wrap: wrap;margin-bottom:10px;" >
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Toplam - Tamamlanan - İşlem</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalActiveCount}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Toplam - Tamamlanan - Gelir</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalIncomeActivePrice}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Toplam - Tamamlanan - Gider</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalExpenseActivePrice}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Toplam - Tamamlanan - Bakiye</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalActivePrice}}</p>
                          </div>
                        </div>
                        <div style="display: flex;gap: 5px;flex-wrap: wrap;margin-bottom:10px;" >
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Toplam - Devam Eden - İşlem</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalPasiveCount}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Toplam - Devam Eden -  Gelir</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalIncomePasivePrice}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Toplam - Devam Eden -  Gider</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalExpensePasivePrice}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Toplam - Devam Eden -  Bakiye</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalPasivePrice}}</p>
                          </div>
                        </div>
                        <!------  Tablo Üst - Sonucları Gösterme - Tüm Zamanların  Son ----->

                        <hr>

                        <!------  Tablo Üst - Sonucları Gösterme - Bu Yıl --------->
                        <div style="display: flex;gap: 5px;flex-wrap: wrap;margin-bottom:10px;" >
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Yıl</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->YEAR_NOW}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Yıl - Toplam İşlem</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalCount_Year}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Yıl - Toplam Gelir</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalIncomePrice_Year}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Yıl - Toplam Gider</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalExpensePrice_Year}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Yıl - Toplam Bakiye</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalPrice_Year}}</p>
                          </div>
                        </div>
                        <div style="display: flex;gap: 5px;flex-wrap: wrap;margin-bottom:10px;" >
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Yıl - Toplam - Tamamlanan - İşlem</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalActiveCount_Year}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Yıl - Toplam - Tamamlanan - Gelir</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalIncomeActivePrice_Year}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Yıl - Toplam - Tamamlanan - Gider</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalExpenseActivePrice_Year}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Yıl - Toplam - Tamamlanan - Bakiye</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalActivePrice_Year}}</p>
                          </div>
                        </div>
                        <div style="display: flex;gap: 5px;flex-wrap: wrap;margin-bottom:10px;" >
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Yıl - Toplam - Devam Eden - İşlem</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalPasiveCount_Year}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Yıl - Toplam - Devam Eden -  Gelir</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalIncomePasivePrice_Year}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Yıl - Toplam - Devam Eden -  Gider</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalExpensePasivePrice_Year}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Yıl - Toplam - Devam Eden -  Bakiye</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalPasivePrice_Year}}</p>
                          </div>
                        </div>
                        <!------  Tablo Üst - Sonucları Gösterme - Bu Yıl Son ----->

                        <hr>
                        
                        <!------  Tablo Üst - Sonucları Gösterme - Bu Ay --------->
                        <div style="display: flex;gap: 5px;flex-wrap: wrap;margin-bottom:10px;" >
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Ay</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->MONTH_NOW}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Ay - Toplam İşlem</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalCount_Month}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Ay - Toplam Gelir</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalIncomePrice_Month}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Ay - Toplam Gider</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalExpensePrice_Month}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Ay - Toplam Bakiye</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalPrice_Month}}</p>
                          </div>
                        </div>
                        <div style="display: flex;gap: 5px;flex-wrap: wrap;margin-bottom:10px;" >
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Ay - Toplam - Tamamlanan - İşlem</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalActiveCount_Month}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Ay - Toplam - Tamamlanan - Gelir</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalIncomeActivePrice_Month}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Ay - Toplam - Tamamlanan - Gider</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalExpenseActivePrice_Month}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Ay - Toplam - Tamamlanan - Bakiye</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalActivePrice_Month}}</p>
                          </div>
                        </div>
                        <div style="display: flex;gap: 5px;flex-wrap: wrap;margin-bottom:10px;" >
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Ay - Toplam - Devam Eden - İşlem</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalPasiveCount_Month}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Ay - Toplam - Devam Eden -  Gelir</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalIncomePasivePrice_Month}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Ay - Toplam - Devam Eden -  Gider</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalExpensePasivePrice_Month}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Ay - Toplam - Devam Eden -  Bakiye</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalPasivePrice_Month}}</p>
                          </div>
                        </div>
                        <!------  Tablo Üst - Sonucları Gösterme - Bu Ay Son ----->

                        <hr>
                                                
                        <!------  Tablo Üst - Sonucları Gösterme - Bu Hafta --------->
                        <div style="display: flex;gap: 5px;flex-wrap: wrap;margin-bottom:10px;" >
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Hafta</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->WEEK_BEFORE_7DAY}}</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->DAY_NOW}}</p>
                          </div>

                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Hafta - Toplam İşlem</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalCount_Week}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Hafta - Toplam Gelir</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalIncomePrice_Week}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Hafta - Toplam Gider</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalExpensePrice_Week}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Hafta - Toplam Bakiye</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalPrice_Week}}</p>
                          </div>
                        </div>
                        <div style="display: flex;gap: 5px;flex-wrap: wrap;margin-bottom:10px;" >
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Hafta - Toplam - Tamamlanan - İşlem</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalActiveCount_Week}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Hafta - Toplam - Tamamlanan - Gelir</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalIncomeActivePrice_Week}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Hafta - Toplam - Tamamlanan - Gider</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalExpenseActivePrice_Week}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Hafta - Toplam - Tamamlanan - Bakiye</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalActivePrice_Week}}</p>
                          </div>
                        </div>
                        <div style="display: flex;gap: 5px;flex-wrap: wrap;margin-bottom:10px;" >
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Hafta - Toplam - Devam Eden - İşlem</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalPasiveCount_Week}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Hafta - Toplam - Devam Eden -  Gelir</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalIncomePasivePrice_Week}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Hafta - Toplam - Devam Eden -  Gider</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalExpensePasivePrice_Week}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bu Hafta - Toplam - Devam Eden -  Bakiye</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalPasivePrice_Week}}</p>
                          </div>
                        </div>
                        <!------  Tablo Üst - Sonucları Gösterme - Bu Hafta Son ----->

                        <hr>
                                                
                        <!------  Tablo Üst - Sonucları Gösterme - Bugün --------->
                        <div style="display: flex;gap: 5px;flex-wrap: wrap;margin-bottom:10px;" >
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bugün</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->DAY_NOW}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bugün - Toplam İşlem</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalCount_Today}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bugün - Toplam Gelir</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalIncomePrice_Today}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bugün - Toplam Gider</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalExpensePrice_Today}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bugün - Toplam Bakiye</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalPrice_Today}}</p>
                          </div>
                        </div>
                        <div style="display: flex;gap: 5px;flex-wrap: wrap;margin-bottom:10px;" >
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bugün - Toplam - Tamamlanan - İşlem</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalActiveCount_Today}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bugün - Toplam - Tamamlanan - Gelir</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalIncomeActivePrice_Today}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bugün - Toplam - Tamamlanan - Gider</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalExpenseActivePrice_Today}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bugün - Toplam - Tamamlanan - Bakiye</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalActivePrice_Today}}</p>
                          </div>
                        </div>
                        <div style="display: flex;gap: 5px;flex-wrap: wrap;margin-bottom:10px;" >
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bugün - Toplam - Devam Eden - İşlem</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalPasiveCount_Today}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bugün - Toplam - Devam Eden -  Gelir</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalIncomePasivePrice_Today}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bugün - Toplam - Devam Eden -  Gider</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalExpensePasivePrice_Today}}</p>
                          </div>
                          <div style="display: flex;flex-direction: column;width: fit-content;padding: 10px;border: 1px solid;font-size: 12px;" >
                             <p>Bugün - Toplam - Devam Eden -  Bakiye</p>
                             <p style="margin-bottom: -9px;margin-right: auto;margin-left: auto;font-weight: bold;" >{{$DB_Find_Dashboard->totalPasivePrice_Today}}</p>
                          </div>
                        </div>
                        <!------  Tablo Üst - Sonucları Gösterme - Bugün Son ----->

                        <hr>

                        <!------ Tablo Ayarları -->
                        <div id="choosedPanel" class="row-fluid"  style="margin-top:10px;display: none;gap: 5px;flex-wrap: wrap;" >
                        
                          <!-- Tablo İşlemi -->
                          <select  style="cursor: pointer;width: max-content;" id="tableSettings" >
                            <option value="delete" selected>@lang('admin.delete')</option>
                            <option value="edit_active" >@lang('admin.active')</option>
                            <option value="edit_passive" >@lang('admin.passive')</option>
                            <option value="multi_createClone" >@lang('admin.createClone')</option>
                          </select>
                          <!-- Tablo İşlemi Son -->

                          <div >
                            <button class="btn btn-success" id="multiAction" >@lang('admin.multitask')</button>
                          </div>

                        </div>
                        <!------ Tablo Ayarları Son -->
                        
                        <!------  Tablo ----->
                        <div class="table-container">
                            
                          <table>
                              <thead>
                                
                                <!---- Tümü Seç --->
                                <th data-cell="Tümü Seç" style="margin: auto;"><input type="checkbox" id="showAllRows" value="all"  data_count="0"  data_value=""  ></th>

                                <th class="table_title" exportName="id" >ID</th>
                                <th class="table_title" exportName="id" >@lang('admin.currentAccount') Code</th>
                                <th class="table_title" exportName="id" >@lang('admin.currentAccount')</th>
                                <th class="table_title" exportName="id" >@lang('admin.date')</th>

                                <th class="table_title" exportName="id" >@lang('admin.title')</th>
                                <th class="table_title" exportName="id" >@lang('admin.description')</th>
                                <th class="table_title" exportName="id" >@lang('admin.type')</th>
                                <th class="table_title" exportName="id" >@lang('admin.price')</th>
                                <th class="table_title" exportName="id" >@lang('admin.quantity')</th>
                                <th class="table_title" exportName="id" >@lang('admin.total')</th>

                                <th class="table_title" exportName="id" >@lang('admin.status')</th>
                                <th class="table_title" exportName="id" >@lang('admin.actions')</th>

                              </thead>
                            <tbody role="alert" aria-live="polite" aria-relevant="all">
                            
                              @for ($i = 0; $i < count($dbFind); $i++)
                              <tr>

                                  <!---- Seç --->
                                  <td data-cell="Seç"  class="c-table__cell"><input type="checkbox" id="checkItem" data_check_id="{{$dbFind[$i]->id}}" > </td>

                                  <td data-cell="ID">{{$dbFind[$i]->id}}</td>
                                  <td data-cell="@lang('admin.currentAccount')">{{$dbFind[$i]->current_id}}</td>
                                  <td data-cell="@lang('admin.currentAccount')">{{$dbFind[$i]->current_id ? $dbFind[$i]->finance_current_account_title : "Kasa Hesap"}}</td>
                                  <td data-cell="@lang('admin.date')" >{{\Carbon\Carbon::parse($dbFind[$i]->date_time)->isoFormat('Do MMMM YYYY, HH:mm:ss')}}</td>
                                 
                                  <td data-cell="@lang('admin.title')">{{$dbFind[$i]->title}}</td>
                                  <td data-cell="@lang('admin.description')">{{$dbFind[$i]->description}}</td>
                                  <td data-cell="@lang('admin.type')">{{$dbFind[$i]->type}}</td>
                                  <td data-cell="@lang('admin.price')">{{$dbFind[$i]->price}}</td>
                                  <td data-cell="@lang('admin.quantity')">{{$dbFind[$i]->quantity}}</td>
                                  <td data-cell="@lang('admin.total')">{{$dbFind[$i]->total}}</td>
                                 
                                  <td data-cell="@lang('admin.status')">
                                    <span style="margin: auto;" class="alert {{$dbFind[$i]->isActive ? 'alert-success' : 'alert-error' }}" data_value="{{$dbFind[$i]->isActive}}" >{{$dbFind[$i]->isActive ? __('admin.active') : __('admin.passive')  }}</span>
                                  </td>

                                  <td data-cell="@lang('admin.actions')" >
                                    <button class="btn {{$dbFind[$i]->isActive ? 'btn-success ' : 'btn-danger '}}" id="statusItem" data_id="{{$dbFind[$i]->id}}" data_isActive="{{$dbFind[$i]->isActive}}"  ><i data_id="{{$dbFind[$i]->id}}" data_isActive="{{$dbFind[$i]->isActive}}"  class="{{$dbFind[$i]->isActive ? 'icon-eye-open' : ' icon-eye-close'}}"></i></button>
                                    <button class="btn btn-success" title="clone" id="cloneItem" data_id="{{$dbFind[$i]->id}}" ><i data_id="{{$dbFind[$i]->id}}" class=" icon-copy"></i></button>
                                    <button class="btn btn-primary" title="modal edit"  id="editItem" href="#editModal" data-toggle="modal" data_id="{{$dbFind[$i]->id}}" ><i data_id="{{$dbFind[$i]->id}}" class="fa fa-pencil"></i></button>
                                    <button class="btn btn-warning" title="modal fileupload"  id="editFileUpload" href="#editFileUploadModal" data-toggle="modal" data_id="{{$dbFind[$i]->id}}" ><i data_id="{{$dbFind[$i]->id}}" class="fa fa-file"></i></button>
                                    <button class="btn btn-danger" id="deleteItem" data_id="{{$dbFind[$i]->id}}"><i data_id="{{$dbFind[$i]->id}}" class="fa fa-trash "></i></button>
                                  </td>
                              </tr>
                              @endfor

                            </tbody>
                          </table>
                          
                          @if(count($dbFind) == 0 )  <p> @lang('admin.dataNotFound') </p> @endif

                        </div>
                        <!------  Tablo Son -->

                        <!------ Tablo Alt  -->
                        <div class="row-fluid" style="margin-top:10px;">

                          <!-- Sıralama -->
                          <div class="span3">
                            <select  class="" style="cursor: pointer;" id="searchTable" searchName="order">
                              <option value="desc" selected>@lang('admin.largeToSmal')  [DESC] </option>
                              <option value="asc">@lang('admin.smalToLarge') [ASC]</option>
                            </select>
                          </div>
                          <!-- Sıralama Son -->

                          <!-- Sayfa Başı -->
                          <div class="span1">
                            <select  class="" style="cursor: pointer;width: 75px;" id="searchTable" searchName="rowcount">
                              <option value="all">@lang('admin.all')</option>  
                              <option value="10" selected="selected">10</option>
                              <option value="15">15</option>
                              <option value="20">20</option>
                              <option value="25">25</option>
                              <option value="50">50</option>
                            </select>
                          </div>
                          <div class="span2">
                            <div class="dataTables_info" id="editable-sample_info"> @lang('admin.numberOfData') : {{$dbSize}} / {{$dbTop}}</div>
                          </div>
                          <!-- Sayfa Başı Son -->

                          <!------  Pagination  -->
                          <div class="span6">
                            <div class="dataTables_paginate paging_bootstrap pagination">
                              <ul>
                                <li class="prev {{$pagination['prev']['page'] ? '' : 'disabled' }}"><a href="{{$pagination['prev']['url']}}">← @lang('admin.back')</a></li>
                                @for ($i = 0; $i < count($pagination["items"]); $i++)
                                <li class="{{$pagination['current'] == $pagination['items'][$i]['page'] ? 'active' :'' }}"><a href="{{$pagination['items'][$i]['url']}}">{{$pagination["items"][$i]['title']}}</a></li>
                                @endfor
                                <li class="next {{$pagination['next']['page'] ? '' : 'disabled' }}"><a href="{{$pagination['next']['url']}}">@lang('admin.next') → </a></li>
                              </ul>
                            </div>
                          </div>
                          <!------  Pagination Son -->


                        </div>
                        <!------ Tablo Alt Son -->
                        
                        <p>** Hizmet = Gider olarak değerlendirecektir</p>

                    </div>
                  </div>
              </div>
              <!--- List Son -->
              
             </div>
            <!-- END PAGE CONTENT-->
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->
   </div>
   <!-- END CONTAINER -->

  <!--************* Modal *********--->
  <!----  Modal Ekleme -->
  <div id="addModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="addModalLabel">@lang('admin.newAdd')</h3>
        <div id='loaderAdd' style="display: none;width: 20px;"><img src="/upload/images/loader.gif" alt=""></div>
      </div>
      <div class="modal-body">

        <div class="row-fluid">
          <div class="span12">
              <div class="control-group">
                <label class="control-label">Cari Kart</label>
                <div class="controls controls-row">
                    <select class="" style="cursor: pointer;width: 100%;" id="currentIdAdd" focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="3" >
                        @if($id==0)  <option value="0" >( #0 ) Kasa Hesap</option> @endif
                        @for ($i = 0; $i < count($DB_Current_Account); $i++)
                        <option value="{{$DB_Current_Account[$i]->id}}" > ( #{{$DB_Current_Account[$i]->id}} )  {{$DB_Current_Account[$i]->title}}</option>
                        @endfor
                    </select>
                </div>
              </div>
          </div>
        </div>

        <div class="row-fluid">
          <div class="span12">
              <div class="control-group">
                <label class="control-label">@lang('admin.date')</label>
                <div class="controls controls-row">
                  <input type="datetime-local" class="input-block-level" name="dateAdd" id="dateAdd" placeholder="0"  focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="1" >
                </div>
              </div>
          </div>
        </div>

        <div class="row-fluid">
          <div class="span12">
              <div class="control-group">
                <label class="control-label">İş Hizmet</label>
                <div class="controls controls-row">
                    <select class="" style="cursor: pointer;width: 100%;" id="businessAdd" focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="3" >
                        <option value="">@lang('admin.choose')</option>
                        <option value="0" data_type_code="1" data_price="0" data_description="" >Diğer</option>
                        @for ($i = 0; $i < count($DB_Business_Account); $i++)
                        <option value="{{$DB_Business_Account[$i]->id}}" data_type_code="{{$DB_Business_Account[$i]->type_code}}" data_price="{{$DB_Business_Account[$i]->price}}" data_description="{{$DB_Business_Account[$i]->description}}"  >{{$DB_Business_Account[$i]->title}}</option>
                        @endfor
                    </select>
                </div>
              </div>
          </div>
        </div>

        <div class="row-fluid">
            <div class="span12">
                <div class="control-group">
                <label class="control-label">@lang('admin.description')</label>
                <div class="controls controls-row">
                  <textarea class="span12" name="descriptionAdd" id="descriptionAdd"  rows="3" cols="80" focusType ="true" focusControl="add" focusControl_Active="true" focusOrder="2"></textarea>
                </div>
                </div>
            </div>
        </div>

        <div class="row-fluid">
           <div class="span6">
              <div class="control-group">
                <label class="control-label">@lang('admin.type')</label>
                <div class="controls controls-row">
                    <select class="" style="cursor: pointer;width: 100%;" id="typeAdd" focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="3" >
                        <option value="1" >Gelir</option>
                        <option value="2" >Gider</option>
                        <option value="3" >Hizmet</option>
                    </select>
                </div>
              </div>
            </div>

            <div class="span6">
                <div class="control-group">
                    <label class="control-label">@lang('admin.price')</label>
                    <div class="controls controls-row">
                        <input type="number" class="input-block-level" name="priceAdd" id="priceAdd" placeholder="@lang('admin.price')" value="" focusType ="true" focusControl="add" focusControl_Active="true"  focusOrder="3"  >
                    </div>
                </div>
            </div>
        </div>

        <div class="row-fluid">
          <div class="span6">
              <div class="control-group">
                <label class="control-label">@lang('admin.quantity')</label>
                <div class="controls controls-row">
                  <input type="number" class="input-block-level" name="purchaseAmountAdd" id="purchaseAmountAdd" placeholder="1" value="1"  focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="5" >
                </div>
              </div>
          </div>
          <div class="span6">
              <div class="control-group">
                <label class="control-label">@lang('admin.total')</label>
                <div class="controls controls-row">
                  <input type="number" class="input-block-level" name="totalAdd" id="totalAdd" placeholder="0"  focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="6" >
                </div>
              </div>
          </div>
        </div> 
       
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">@lang('admin.close')</button>
        <button class="btn btn-info" id="reset_add" >@lang('admin.reset')</button>
        <button class="btn btn-success" id="new_add" >@lang('admin.add')</button>
      </div>
  </div>
  <!----  Modal Ekleme Son -->

  <!----  Modal Güncelle -->
  <div id="editModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="editModalTitle" style="display: flex;" ><p>@lang('admin.edit') #</p><p id="editModalValueId">54</p> </h3>
          <div id='loaderEdit' style="display: flex;width: 20px;"><img src="/upload/images/loader.gif" alt=""></div>
      </div>
      <div class="modal-body">

        <div class="row-fluid">
          <div class="span12">
              <div class="control-group">
                <label class="control-label">Cari Kart</label>
                <div class="controls controls-row">
                    <select class="" style="cursor: pointer;width: 100%;" id="currentIdEdit" focusType ="true" focusControl="add" focusControl_Active="false" focusOrder="3" >
                        @if($id==0)  <option value="0" >( #0 ) Kasa Hesap</option> @endif
                        @for ($i = 0; $i < count($DB_Current_Account); $i++)
                        <option value="{{$DB_Current_Account[$i]->id}}" > ( #{{$DB_Current_Account[$i]->id}} )  {{$DB_Current_Account[$i]->title}}</option>
                        @endfor
                    </select>
                </div>
              </div>
          </div>
        </div>

        <div class="row-fluid">
          <div class="span12">
              <div class="control-group">
                <label class="control-label">@lang('admin.date')</label>
                <div class="controls controls-row">
                  <input type="datetime-local" class="input-block-level" name="dateEdit" id="dateEdit" placeholder="0"  focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="1" >
                </div>
              </div>
          </div>
        </div>

        <div class="row-fluid">
          <div class="span12">
              <div class="control-group">
                <label class="control-label">İş Hizmet</label>
                <div class="controls controls-row">
                    <select class="" style="cursor: pointer;width: 100%;" id="businessEdit" focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="3" >
                        @for ($i = 0; $i < count($DB_Business_Account); $i++)
                        <option value="{{$DB_Business_Account[$i]->id}}" data_type_code="{{$DB_Business_Account[$i]->type_code}}" data_price="{{$DB_Business_Account[$i]->price}}" data_description="{{$DB_Business_Account[$i]->description}}"  >{{$DB_Business_Account[$i]->title}}</option>
                        @endfor
                    </select>
                </div>
              </div>
          </div>
        </div>
        
        <div class="row-fluid">
            <div class="span12">
                <div class="control-group">
                <label class="control-label">@lang('admin.description')</label>
                <div class="controls controls-row">
                  <textarea class="span12" name="descriptionEdit" id="descriptionEdit"  rows="3" cols="80" focusType ="true" focusControl="edit" focusControl_Active="true" focusOrder="2"></textarea>
                </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
           <div class="span6">
              <div class="control-group">
                <label class="control-label">@lang('admin.type')</label>
                <div class="controls controls-row">
                    <select class="" style="cursor: pointer;width: 100%;" id="typeEdit" focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="3" >
                        <option value="1" >Gelir</option>
                        <option value="2" >Gider</option>
                        <option value="3" >Hizmet</option>
                    </select>
                </div>
              </div>
            </div>

            <div class="span6">
                <div class="control-group">
                    <label class="control-label">@lang('admin.price')</label>
                    <div class="controls controls-row">
                        <input type="number" class="input-block-level" name="priceEdit" id="priceEdit" placeholder="@lang('admin.price')" value="" focusType ="true" focusControl="edit" focusControl_Active="true"  focusOrder="3"  >
                    </div>
                </div>
            </div>
        </div>

        <div class="row-fluid">
          <div class="span6">
              <div class="control-group">
                <label class="control-label">@lang('admin.quantity')</label>
                <div class="controls controls-row">
                  <input type="number" class="input-block-level" name="purchaseAmountEdit" id="purchaseAmountEdit" placeholder="1" value="1"  focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="5" >
                </div>
              </div>
          </div>
          <div class="span6">
              <div class="control-group">
                <label class="control-label">@lang('admin.total')</label>
                <div class="controls controls-row">
                  <input type="number" class="input-block-level" name="totalEdit" id="totalEdit" placeholder="0"  focusType ="true" focusControl="edit" focusControl_Active="false" focusOrder="6" >
                </div>
              </div>
          </div>
        </div> 

      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">@lang('admin.close')</button>
        <button class="btn btn-success" id="edit_item">@lang('admin.edit')</button>
      </div>
  </div>
  <!----  Modal Güncelle Son -->
        
  <!----  Modal Dosya Yükleme -->
  <div id="editFileUploadModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="editFileUploadModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="editFileUploadModalTitle" style="display: flex;" ><p> Dosya Yükleme #</p><p id="editFileUploadModalValueId">54</p> </h3>
        <div id='loaderEditFileUpload' style="display: flex;width: 20px;"><img src="/upload/images/loader.gif" alt=""></div>
      </div>
      <div class="modal-body">

        <div class="row-fluid">
          <div class="span12">
              <div class="control-group">
                  <label class="control-label">Dosya Yükle</label>
                  <div class="controls controls-row">

                      <!-- Dosya Yükleme Kutusu ----->
                      <div style="border: 2px solid;padding: 10px;">

                          <!-- Dosya Yükleme ----->
                          <form method="POST" id="uploadForm" enctype="multipart/form-data">
                              <div style="display: flex;flex-direction: column; gap: 15px;">

                                  <!-- Dosya Yükleme Bilgileri ----->
                                  <input type="hidden" name="fileDbSave" id="fileDbSave" value="true" >
                                  <input type="hidden" name="fileWhere" id="fileWhere" value="Sabit" >

                                  <!---  Loading --->
                                  <div id="LoadingFileUpload" style="display:none;" ><span class="d-flex align-items-center">
                                      <span class="spinner-border flex-shrink-0" role="status"></span>
                                      <span class="flex-grow-1 ms-2">@lang('admin.loading') </span>
                                  </span> </div>
                                  <div id="uploadStatus"></div>
                                  <!--- End Loading --->

                                  <input type="file" name="file" id="fileInput" style="display: flex; color: steelblue; margin-left: 10px; ">
                                  <div style="display: flex; gap: 10px; margin-bottom: -25px;" ><p>@lang('admin.fileUrl'):</p><p id="filePathUrl"></p></div>
                                  <button type="button" id="fileUploadClick" class="btn btn-success" style="cursor:pointer; background-image: linear-gradient(#04519b, #033c73 60%, #02325f);color: #ffffff;border-bottom: 1px solid #022241;padding: 12px;border-radius: 6px;display: flex; gap:10px; justify-content: center;align-items: center;">
                                      <i class="ri-folder-upload-line" style="margin-top: -8px;  margin-bottom: -8px; font-size: 24px;"></i> 
                                      <p style=" color: blanchedalmond; font-size: 14px; font-weight: bold; " > @lang('admin.fileUpload') </p>
                                  </button>
                                  
                                  <!-- ProgressBar ---->
                                  <div class="progress" style="margin-top: 14px;height: auto;">
                                      <div class="progress-bar" id="progressBarFileUpload" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;background-color: teal;color: rgb(255, 255, 255);border-radius: 6px;display: flex;justify-content: center;"></div>
                                  </div>
                                  <!-- ProgressBar Son ---->
                                  
                              </div>
                          </form>
                          <!-- Dosya Yükleme Son ---->

                      </div>
                      <!-- Dosya Yükleme Kutusu Son ----->

                  </div>
              </div>
          </div>
        </div>
        
        <div class="row-fluid">
          <div class="span6">
              <div class="control-group">
                <label class="control-label">Dosya Adı</label>
                <div class="controls controls-row">
                  <input type="text" class="input-block-level" name="fileUploadName" id="fileUploadName" placeholder="" value=""  focusType ="true" focusControl="file" focusControl_Active="false" focusOrder="5" >
                </div>
              </div>
          </div>
          <div class="span6">
              <div class="control-group">
                <label class="control-label">İndir</label>
                <div class="controls controls-row">
                  <a href="" id="file_download" download="">
                    <i class="fa fa-download" style="color:#1bb934; font-size: 30px;" ></i>
                  </a>
                </div>
              </div>
          </div>
        </div> 

      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">@lang('admin.close')</button>
        <button class="btn btn-info" id="reset_add" >@lang('admin.reset')</button>
        <button class="btn btn-success" id="new_save_file" >@lang('admin.save')</button>
      </div>
  </div>
  <!----  Modal Dosya Yükleme Son -->

  <!--************* Modal Son *********--->


  <footer>
    <!-- Footer -->
    @include('admin.include.footer')

    <!------- JS --->
    <script src="{{asset('/assets/admin')}}/js/01_0_sabit_list/00_list_search.js"></script>
    <script src="{{asset('/assets/admin')}}/js/finance/safe_account.js"></script>
        
    <!-- Yıldırımdev Table JS -->
    <script src="{{asset('/assets/admin/yildirimdev')}}/js/yildirimdev_table.js"></script>

  </footer>

</body>
<!-- END BODY -->
</html>
