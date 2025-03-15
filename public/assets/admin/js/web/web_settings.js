//alert("web_settings.js");
console.log("web_settings.js çalışıyor");

//! Dil Alıyor
var yildirimdevMultiLangJson = JSON.parse(localStorage.getItem('yildirimdevMultiLang')); //! Çoklu Dil

//! Çoklu Dil Fonksiyon
function yildirimdevMultiLangJsonReturn () {
    if(yildirimdevMultiLangJson == null) { var yildirimdevMultiLangJson = JSON.parse(localStorage.getItem('yildirimdevMultiLang')); }
    return yildirimdevMultiLangJson;
}  //! Çoklu Dil Fonksiyon Son

//! Tanım
var listUrl = "/admin/web/settings"; //! Adres 

//! Yüklenince Kapanıyor
$(document).ready(function () { $('#loader').hide(); });

//! ************ Web Ayarları  ***************
$("#web_Save").click(function (e) {
    e.preventDefault();

    var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
    //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);

    //! Loading - Veri Yükleniyor
    $('#loader').show(); //! Laoding Göster
    $('body input,textarea,select').attr('disabled','disabled'); //! İnputları Gizleme
    $('body button').attr('disabled','disabled'); //! Buttonları Gizleme
    $('#web_Save').attr('disabled','disabled'); //! Button Gizleme
    document.getElementById("web_Save").style.cursor = "wait"; //! Cursor - Dönen

    //! Loading - Veri Yüklendi
    function loadingYuklendi(){
        $('#loader').hide(); //! Laoding Gizle
        $('body input,textarea,select').removeAttr('disabled'); //! İnputları Aç
        $('body button').removeAttr('disabled'); //! Buttonları Aç
        $('#web_Save').removeAttr('disabled'); //! //! Button Göster
        document.getElementById("web_Save").style.cursor = "pointer"; //! Cursor - Ok
    }
    //! Loading - Veri Yüklendi Son
    
    //! Veriler
    var web_title = $('#web_title').val();
    var web_site_url = $('#web_site_url').val();

    if(web_title == '') { 
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Title Yazılmadı",
            showConfirmButton: false,
            timer: 2000,
        });

        loadingYuklendi(); //! Fonksiyon Çalıştır

    }
    else if(web_site_url == '') { 
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Site Url Yazılmadı",
            showConfirmButton: false,
            timer: 2000,
        });

        loadingYuklendi(); //! Fonksiyon Çalıştır

    }
    else { 

        //! Ajax  Post
        $.ajax({
            url: listUrl + "/post",
            type: "post",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                siteLang: yildirimdevMultiLangJsonReturnR.lang,

                id:$('#web_setting_info').attr('data_id'),
                title: $('#web_title').val(),
                siteUrl: $('#web_site_url').val(),
            
                created_byId: document.cookie.split(';').find((row) => row.startsWith(' yildirimdev_userID='))?.split('=')[1]
            },
            beforeSend: function() { console.log("Başlangıc"); },
            success: function (response) {
                //alert("başarılı");
                console.log("response:", response);
                // console.log("status:", response.status);

                if (response.status == "success") {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: yildirimdevMultiLangJsonReturnR.transactionSuccessful,
                        showConfirmButton: false,
                        timer: 2000,
                    });

                    //! Sayfa Yenileme
                    window.location.reload();
                } else {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: yildirimdevMultiLangJsonReturnR.transactionFailed,
                        showConfirmButton: false,
                        timer: 2000,
                    });
                }
            },
            error: function (error) {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: yildirimdevMultiLangJsonReturnR.transactionFailed,
                    showConfirmButton: false,
                    timer: 2000,
                });
                console.log("error:", error);
            },
            complete: function() { loadingYuklendi();  }
        }); //! Ajax Post Son

    }

}); 
//! ************ Web Ayarları Son  ***************


//! ************ Web - Sosyal Medya Ayarları  ***************
$("#socialMedia_Save").click(function (e) {
    e.preventDefault();

    var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
    //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);

    //! Loading - Veri Yükleniyor
    $('#loader').show(); //! Laoding Göster
    $('body input,textarea,select').attr('disabled','disabled'); //! İnputları Gizleme
    $('body button').attr('disabled','disabled'); //! Buttonları Gizleme
    $('#web_Save').attr('disabled','disabled'); //! Button Gizleme
    document.getElementById("web_Save").style.cursor = "wait"; //! Cursor - Dönen

    //! Loading - Veri Yüklendi
    function loadingYuklendi(){
        $('#loader').hide(); //! Laoding Gizle
        $('body input,textarea,select').removeAttr('disabled'); //! İnputları Aç
        $('body button').removeAttr('disabled'); //! Buttonları Aç
        $('#web_Save').removeAttr('disabled'); //! //! Button Göster
        document.getElementById("web_Save").style.cursor = "pointer"; //! Cursor - Ok
    }
    //! Loading - Veri Yüklendi Son
    
    //! Veriler
    var web_email = $('#web_email').val();
    var web_phone = $('#web_phone').val();

    if(web_email == '') { 
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Email Yazılmadı",
            showConfirmButton: false,
            timer: 2000,
        });

        loadingYuklendi(); //! Fonksiyon Çalıştır

    }
    else if(web_phone == '') { 
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Telefon Yazılmadı",
            showConfirmButton: false,
            timer: 2000,
        });

        loadingYuklendi(); //! Fonksiyon Çalıştır

    }
    else { 

        //! Ajax  Post
        $.ajax({
            url: listUrl + "/social/media/post",
            type: "post",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                siteLang: yildirimdevMultiLangJsonReturnR.lang,

                id:$('#web_setting_info').attr('data_id'),
                email: $('#web_email').val(),
                phone: $('#web_phone').val(),
                phone2: $('#web_phone2').val(),
                whatsapp: $('#web_whatsapp').val(),
                address: document.getElementById('web_address').value,
                web_address_map: document.getElementById('web_address_map').value,

                facebook_Url: $('#web_facebook').val(),
                twitter_Url: $('#web_twitter').val(),
                instagram_Url: $('#web_instagram').val(),
                linkedln_Url: $('#web_linkedln').val(),
                youtube_Url: $('#web_youtube').val(),
            
                created_byId: document.cookie.split(';').find((row) => row.startsWith(' yildirimdev_userID='))?.split('=')[1]
            },
            beforeSend: function() { console.log("Başlangıc"); },
            success: function (response) {
                //alert("başarılı");
                console.log("response:", response);
                // console.log("status:", response.status);

                if (response.status == "success") {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: yildirimdevMultiLangJsonReturnR.transactionSuccessful,
                        showConfirmButton: false,
                        timer: 2000,
                    });

                    //! Sayfa Yenileme
                    window.location.reload();
                } else {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: yildirimdevMultiLangJsonReturnR.transactionFailed,
                        showConfirmButton: false,
                        timer: 2000,
                    });
                }
            },
            error: function (error) {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: yildirimdevMultiLangJsonReturnR.transactionFailed,
                    showConfirmButton: false,
                    timer: 2000,
                });
                console.log("error:", error);
            },
            complete: function() { loadingYuklendi();  }
        }); //! Ajax Post Son

    }

}); 
//! ************ Web - Sosyal Medya Ayarları Son  ***************


//! ************ Web - Seo Ayarları  ***************
$("#seo_Save").click(function (e) {
    e.preventDefault();

    var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
    //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);

    //! Loading - Veri Yükleniyor
    $('#loader').show(); //! Laoding Göster
    $('body input,textarea,select').attr('disabled','disabled'); //! İnputları Gizleme
    $('body button').attr('disabled','disabled'); //! Buttonları Gizleme
    $('#web_Save').attr('disabled','disabled'); //! Button Gizleme
    document.getElementById("web_Save").style.cursor = "wait"; //! Cursor - Dönen

    //! Loading - Veri Yüklendi
    function loadingYuklendi(){
        $('#loader').hide(); //! Laoding Gizle
        $('body input,textarea,select').removeAttr('disabled'); //! İnputları Aç
        $('body button').removeAttr('disabled'); //! Buttonları Aç
        $('#web_Save').removeAttr('disabled'); //! //! Button Göster
        document.getElementById("web_Save").style.cursor = "pointer"; //! Cursor - Ok
    }
    //! Loading - Veri Yüklendi Son
    
    //! Veriler
    var seo_description = document.getElementById('seo_description').value;

    if(seo_description == '') { 
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Açıklama Yazılmadı",
            showConfirmButton: false,
            timer: 2000,
        });

        loadingYuklendi(); //! Fonksiyon Çalıştır

    }
    else { 

        //! Ajax  Post
        $.ajax({
            url: listUrl + "/seo/post",
            type: "post",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                siteLang: yildirimdevMultiLangJsonReturnR.lang,

                id:$('#web_setting_info').attr('data_id'),
                seo_description: document.getElementById('seo_description').value,
                seo_keywords: $('#tagInput').attr('data_value'),
            
                created_byId: document.cookie.split(';').find((row) => row.startsWith(' yildirimdev_userID='))?.split('=')[1]
            },
            beforeSend: function() { console.log("Başlangıc"); },
            success: function (response) {
                //alert("başarılı");
                console.log("response:", response);
                // console.log("status:", response.status);

                if (response.status == "success") {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: yildirimdevMultiLangJsonReturnR.transactionSuccessful,
                        showConfirmButton: false,
                        timer: 2000,
                    });

                    //! Sayfa Yenileme
                    window.location.reload();
                } else {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: yildirimdevMultiLangJsonReturnR.transactionFailed,
                        showConfirmButton: false,
                        timer: 2000,
                    });
                }
            },
            error: function (error) {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: yildirimdevMultiLangJsonReturnR.transactionFailed,
                    showConfirmButton: false,
                    timer: 2000,
                });
                console.log("error:", error);
            },
            complete: function() { loadingYuklendi();  }
        }); //! Ajax Post Son

    }

}); 
//! ************ Web - Seo Ayarları Son  ***************


//! ************ Keywork   ***************
$(document).ready(function () {
    
    // Yazı yazma
    var text_max = 150; //! En fazla Uzunluk
    // $('#maxSonuc').html('Max: ' + text_max + ' karakter:!'); // Uzunluk Gösteriyor

    $('#tagInput').keyup(function (e) {
        //console.log("yazıyor...");
        
        var tagsVal = $('#tagInput').attr('data_value'); //! Veri Okuyor
        var tagsValLength = $('#tagInput').val().length; //! Etiket Uzunluk
        var tagsValDataLength = tagsVal.length; //! Etiket Uzunluk
        
        var text_max_now = text_max - tagsValDataLength - tagsValLength; //! Yazılacak Uzunluk
        
        if (text_max_now < 0) {
            alert("yok");
            
            $('#maxSonuc').html('Max: ' + text_max_now + ' karakter:! Fazla Etiket Yazıldı'); //! Uzunluk Gösteriyor
            $('#maxSonuc').css('color', 'red'); //! Kırmızı
            $('#tagInput').css('color', 'red'); //! Kırmızı
            $('#tagInput').css('border', '1px solid red'); //! Kırmızı
        }
        else if (text_max_now >= 0) {
            $('#maxSonuc').html('Max: ' + text_max_now + ' karakter:!'); //! Uzunluk Gösteriyor
            
            $('#maxSonuc').css('color', 'black'); //! Siyah
            $('#tagInput').css('color', 'black'); //! Siyah
            $('#tagInput').css('border', 'none'); //! Border Gizle
            
            if (e.originalEvent.key == ",") {
                var tagValNew = $(this).val().split(',')[0]; //! Yeni Veri
            
                if (tagValNew != "") {
                    //console.log("tagValNew:", tagValNew); //! Yeni Veri Göster
               
                    var tagsValArray = tagsVal.split(','); //! Array
                    var tagsValNewControl = tagsValArray.indexOf(tagValNew); //! Etiket Kontrol Ediyor     
               
                
                    if (tagsValNewControl == -1) {
                        //alert("Etiket Ekleniyor");
                    
                        tagsValArray.push(tagValNew); //! Array Ekleme
                        tagsValArray = tagsValArray.filter(u => u != null && u !== ''); //! Eğer boş olmayanları seç
            
                        var tagsValString = tagsValArray.join(','); //! Verileri String Yapıyor
                        $('#tagInput').attr('data_value', tagsValString); //! İtemsleri Ayarlıyor
                    
                        tagsSplit(); //! Fonksiyon Çağırma
                        $('#tagInput').val(''); //! Input Temizliyor
                    
                    }
                    else if (tagsValNewControl != -1) {
                        alert("Bu Etiket Bulunuyor");
                        $('#tagitem' + (tagsValNewControl + 1)).css('background-color', 'red');
                    
                        var tagInputSplit = $('#tagInput').val().split(',')[0];
                        $('#tagInput').val(tagInputSplit);
                    }
              
                }
            }
        }

    });
    // Yazı yazma Son
    
    
    //! Etiketleri Listeliyor
    function tagsSplit() {
        
        var tagsVal = $('#tagInput').attr('data_value'); //! Veri Okuyor
        var tagsValArray = tagsVal.split(','); //! Array
        var tagsValDataLength = tagsVal.length; //! Uzunluk
        
        //! Css 
         if (tagsValDataLength == 0) {
            $('.tagLeft').css('gap', '0px');
            $('#tagItems').css('margin-top', '0px');
            $('#tagItems').css('margin-bottom', '0px');
        }
        if (tagsValDataLength != 0) {
            $('.tagLeft').css('gap', '10px');
            $('#tagItems').css('margin-top', '5px');
            $('#tagItems').css('margin-bottom', '5px');
        }
        //! Css Son
        
        var text_max_now =  text_max - tagsValDataLength; //! Yazılacak Uzunluk
        $('#maxSonuc').html('Max: ' + text_max_now + ' karakter:!'); //! Uzunluk Gösteriyor
        
        document.querySelector('#tagItems').innerHTML = ""; //! Veri SİL
        
        for (var index = 0; index < tagsValArray.length; index++) {
            const element = tagsValArray[index];
           
            //! Ekleme
            var addHtml_Id=index+1;
            var addHtml ='';
            
            //! Eklenecek
            addHtml += '<div class="tagitem" id="tagitem'+addHtml_Id+'">';
            addHtml += '<p>'+element+'</p>';
            addHtml += '<div id="tagItemCancel" >';
            addHtml += '<i id="tagItemCancelIcon" data_id="'+addHtml_Id+'" style="font-size: 20px;" class="fa fa-times" aria-hidden="true"></i>';
            addHtml += '</div>';
            addHtml += '</div>';
            //! Eklenecek Son
         
            if (element != "") {
                document.querySelector('#tagItems').innerHTML += addHtml;   //! Ekleme yapar
                //! Ekleme Son
            }
            
        }
        
        
    } //! Etiketler Son
    
    tagsSplit(); //! Fonksiyon Çağırıyor
    
    
    //! İtem Silme
    document.addEventListener('click', (e) => {
        var eventTarget_attr = e.target.getAttribute("data_id"); //! Target attr
        var eventTagId = e.target.id;  //! Target Id      
        
        // console.log("eventTagId:", eventTagId);
        // console.log("eventTarget_attr:", eventTarget_attr);

        if (eventTagId == "tagItemCancelIcon") {
            var tagsVal = $('#tagInput').attr('data_value'); //! Veri Okuyor
            var tagsValArray = tagsVal.split(','); //! Array
            delete tagsValArray[eventTarget_attr - 1]; //! Veri Sil
           
            tagsVal = tagsValArray.filter(u => u != null); //! Yeni Array
           
            var tagsValString = tagsVal.join(','); //! Verileri String Yapıyor
            $('#tagInput').attr('data_value', tagsValString); //! İtemsleri Ayarlıyor
           
            $('#tagitem' + eventTarget_attr).remove(); //! items Sildi
            
            tagsSplit(); //! Fonksiyon Çağırıyor
        }
       
    }); //! İtem Silme Son
       
    //! tagCopy
    $("#tagCopy").click(function () {
        var tagsVal = $('#tagInput').attr('data_value'); //! Veri Okuyor
        navigator.clipboard.writeText(tagsVal); //! Kopyala
        
        alert("kopyalandı");
    }); //! tagCopy Son
    
    //! tagCancel
    $("#tagCancel").click(function () {
        $('#tagInput').attr('data_value', ''); //! Veri Temizliyor
        $('#tagInput').val(''); //! Veri Temizliyor
        tagsSplit(); //! Fonksiyon Çağırıyor
        
    }); //! tagCancel Son     

});
//! ************ Keywork Son ***************
