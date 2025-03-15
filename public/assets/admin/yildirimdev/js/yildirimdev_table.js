$(document).ready(function () {

    // alert("yildirimdev table");
    // console.log("yildirimdev table");

    //! Tümü Seçme
    $('input[type="checkbox"][id="showAllRows"]').click(function () { choosePanelView(); }); //! Tümü Seçme
    $('input[type="checkbox"][id="checkItem"]').click(function () { choosePanelView($(this).attr('data_check_id'),$(this).prop('checked')); }); //! Checkbox Tıklama
    
    //! Panel Gösterme Durum
    function choosePanelView(checkItemId = null, checkItemStatus = null ) {
        //console.log("Panel Gösterme Fonksiyon");
        
        //! Tanım
        var checkAll =  $('#showAllRows').attr('data_value'); //! Seçilenler [1,2,3]
        var checkAllData = checkAll == '' ? [] : checkAll.split(','); //! //! Seçilen veriler
        var SelectAllStatus = $("input[type=checkbox][id=showAllRows]").prop('checked'); //! Tümü Seçme Durumu [ true / false ]
    
        //! Tablo Item Check
        if(checkItemId) { $("input[type=checkbox][id=checkItem][data_check_id="+checkItemId+"]").prop('checked',checkItemStatus); }
    
        if(checkItemId) { //! Tek
    
            //console.log("tek seç");
    
            if(checkItemStatus == true) { !checkAllData.includes(checkItemId) && checkAllData.push(checkItemId);  } //! Ekleme
            if(checkItemStatus == false) {checkAllData.includes(checkItemId) && checkAllData.splice(checkAllData.indexOf(checkItemId ),1);}
        }
        else { //! Tümü Seç
    
            //console.log("tümü seç");
            
            //! Tanım
            var checkAllData = [];
    
            //! Tablodaki Tüm Verileri Seçme
            if(SelectAllStatus) { $("input[type=checkbox][id=checkItem]").prop('checked', true);    } //! Tablodaki Tüm Verileri Seçiyor
            else { $("input[type=checkbox][id=checkItem]").prop('checked', false);    } //! Tablodaki Tüm Verileri Kaldırıyor
        
            //! Tablo Verileri
            $('input[type=checkbox][id="checkItem"]:checked').each(function () { var data_check_id = $(this).attr('data_check_id');  checkAllData.push(data_check_id);  });
            
        }
    
        //! Tanım
        var tableCheckData = $("input[type=checkbox][id=checkItem]"); //! Tablo Check Verileri
        var tableCheckData_length = Number( tableCheckData.length); //! Tablodaki Veri Sayısı
        var checkAllData_length = checkAllData.length; //! Seçilen Veri Sayısı
        
        // console.log("checkAllData:",checkAllData);
        // console.log("tableCheckData_length:",tableCheckData_length);
        // console.log("checkAllData_length:",checkAllData_length);
        
        //! Tümü Seçme Checkbox Gösterme
        if(tableCheckData_length == checkAllData_length) { $("input[type=checkbox][id=showAllRows]").prop('checked',true); }
        else { $("input[type=checkbox][id=showAllRows]").prop('checked',false);  }
    
        //! Tablo Ayarları Gösterme
        checkAllData_length > 0 ? $('#choosedPanel').css('display','flex') : $('#choosedPanel').css('display','none');
    
        //! Verileri Gösterme
        $('#showAllRows').attr('data_value',checkAllData.join(',')); //! Veriler
        $('#showAllRows').attr('data_count',checkAllData_length); //! Sayısı
    
    } //! Panel Gösterme Durum Son

});