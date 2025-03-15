//! ************ Keywork   ***************
$(document).ready(function () {

    // Yazı yazma
    var text_max = 150; //! En fazla Uzunluk
    // $('[id="maxSonuc"][lang="'+dataLang+'"]').html('Max: ' + text_max + ' karakter:!'); // Uzunluk Gösteriyor

    //! Yazarken
    document.querySelectorAll('#tagInput').forEach(function (i) {
        i.addEventListener('keyup', function (e) {

            var dataLang = e.target.lang; //! Dil
            var tagsVal = e.target.getAttribute("data_value"); //! Veri Okuyor
            var tagsValLength  = e.target.value.length; //! Etiket Uzunluk
            var tagsValDataLength = tagsVal.length; //! Etiket Uzunluk
            
            var text_max_now = text_max - tagsValDataLength - tagsValLength; //! Yazılacak Uzunluk

            if (text_max_now < 0) {
                alert("yok");
                
                $('[id="maxSonuc"][lang="'+dataLang+'"]').html('Max: ' + text_max_now + ' karakter:! Fazla Etiket Yazıldı'); //! Uzunluk Gösteriyor
                $('[id="maxSonuc"][lang="'+dataLang+'"]').css('color', 'red'); //! Kırmızı
                $('[id="tagInput"][lang="'+dataLang+'"]').css('color', 'red'); //! Kırmızı
                $('[id="tagInput"][lang="'+dataLang+'"]').css('border', '1px solid red'); //! Kırmızı
            }
            else if (text_max_now >= 0) {
                $('[id="maxSonuc"][lang="'+dataLang+'"]').html('Max: ' + text_max_now + ' karakter:!'); //! Uzunluk Gösteriyor
                
                $('[id="maxSonuc"][lang="'+dataLang+'"]').css('color', 'black'); //! Siyah
                $('[id="tagInput"][lang="'+dataLang+'"]').css('color', 'black'); //! Siyah
                $('[id="tagInput"][lang="'+dataLang+'"]').css('border', 'none'); //! Border Gizle
                
                if (e.key == ",") {
                    var tagValNew = $(this).val().split(',')[0]; //! Yeni Veri
                
                    if (tagValNew != "") {
                   
                        var tagsValArray = tagsVal.split(','); //! Array
                        var tagsValNewControl = tagsValArray.indexOf(tagValNew); //! Etiket Kontrol Ediyor 
                    
                        if (tagsValNewControl == -1) {
                            //alert("Etiket Ekleniyor");
                        
                            tagsValArray.push(tagValNew); //! Array Ekleme
                            tagsValArray = tagsValArray.filter(u => u != null && u !== ''); //! Eğer boş olmayanları seç
                
                            var tagsValString = tagsValArray.join(','); //! Verileri String Yapıyor
                            $('[id="tagInput"][lang="'+dataLang+'"]').attr('data_value', tagsValString); //! İtemsleri Ayarlıyor
                        
                            tagsSplit(dataLang); //! Fonksiyon Çağırma
                            $('[id="tagInput"][lang="'+dataLang+'"]').val(''); //! Input Temizliyor
                        
                        }
                        else if (tagsValNewControl != -1) {
                            alert("Bu Etiket Bulunuyor");
                            $('#tagitem' + (tagsValNewControl + 1)).css('background-color', 'red');
                        
                            var tagInputSplit = $('[id="tagInput"][lang="'+dataLang+'"]').val().split(',')[0];
                            $('[id="tagInput"][lang="'+dataLang+'"]').val(tagInputSplit);
                        }
                  
                    }
                }
            }
            
                    
        });
    }); //! Yazarken Son

    //! Etiketleri Listeliyor
    function tagsSplit(dataLang) { 
        
        var tagsVal = $('[id="tagInput"][lang="'+dataLang+'"]').attr('data_value'); //! Veri Okuyor
        var tagsValArray = tagsVal.split(','); //! Array
        var tagsValDataLength = tagsVal.length; //! Uzunluk
        
        //! Css 
         if (tagsValDataLength == 0) {
            $('[class="tagItems"][lang="'+dataLang+'"]').css('gap', '0px');
            $('[id="tagItems"][lang="'+dataLang+'"]').css('margin-top', '0px');
            $('[id="tagItems"][lang="'+dataLang+'"]').css('margin-bottom', '0px');
        }
        if (tagsValDataLength != 0) {
            $('[class="tagItems"][lang="'+dataLang+'"]').css('gap', '10px');
            $('[id="tagItems"][lang="'+dataLang+'"]').css('margin-top', '5px');
            $('[id="tagItems"][lang="'+dataLang+'"]').css('margin-bottom', '5px');
        }
        //! Css Son
        
        var text_max_now =  text_max - tagsValDataLength; //! Yazılacak Uzunluk
        $('[class="maxSonuc"][lang="'+dataLang+'"]').html('Max: ' + text_max_now + ' karakter:!'); //! Uzunluk Gösteriyor
        

        //! Etiketleri Listeliyor
        $('[id="tagItems"][lang="'+dataLang+'"]').html(''); //! Veri SİL
        
        var tagsDataHtml ="";
        for (var index = 0; index < tagsValArray.length; index++) {
            const element = tagsValArray[index];
           
            //! Ekleme
            var addHtml_Id=index+1;
            var addHtml ='';
            
            //! Eklenecek
            addHtml += '<div class="tagitem" id="tagitem'+addHtml_Id+'">';
            addHtml += '<p>'+element+'</p>';
            addHtml += '<div id="tagItemCancel" >';
            addHtml += '<i id="tagItemCancelIcon" data_id="'+addHtml_Id+'" lang="'+dataLang+'" style="font-size: 20px;" class="fa fa-times" aria-hidden="true"></i>';
            addHtml += '</div>';
            addHtml += '</div>';
            //! Eklenecek Son
         
            if (element != "") {
                tagsDataHtml += addHtml;   //! Ekleme yapar
                //! Ekleme Son
            }
            
        }

        $('[id="tagItems"][lang="'+dataLang+'"]').html(tagsDataHtml);  //! Etiketleri Gösteriyor
        //! Etiketleri Listeliyor Son
        
        
    } //! Etiketler Son

    //! Başlangıc
    tagsSplit("tr"); //! Fonksiyon Çağırıyor
    tagsSplit("en"); //! Fonksiyon Çağırıyor
    tagsSplit("de"); //! Fonksiyon Çağırıyor
        
    //! İtem Silme
    document.addEventListener('click', (e) => {
        var dataLang = e.target.lang; //! Dil
        var eventTarget_attr = e.target.getAttribute("data_id"); //! Target attr
        var eventTagId = e.target.id;  //! Target Id  

        if (eventTagId == "tagItemCancelIcon") {
            var tagsVal = $('[id="tagInput"][lang="'+dataLang+'"]').attr('data_value'); //! Veri Okuyor
            var tagsValArray = tagsVal.split(','); //! Array
            delete tagsValArray[eventTarget_attr - 1]; //! Veri Sil
           
            tagsVal = tagsValArray.filter(u => u != null); //! Yeni Array
           
            var tagsValString = tagsVal.join(','); //! Verileri String Yapıyor
            $('[id="tagInput"][lang="'+dataLang+'"]').attr('data_value', tagsValString); //! İtemsleri Ayarlıyor
           
            $('#tagitem' + eventTarget_attr).remove(); //! items Sildi
            
            tagsSplit(dataLang); //! Fonksiyon Çağırıyor
        }
       
    }); //! İtem Silme Son
       
    //! TagCopy
    document.querySelectorAll('#tagCopy').forEach(function (i) {
        i.addEventListener('click', function (e) {
           
            var dataLang = e.target.lang; //! Dil
            var tagsVal = $('[id="tagInput"][lang="'+dataLang+'"]').attr('data_value'); //! Veri Okuyor
            navigator.clipboard.writeText(tagsVal); //! Kopyala
            
            alert("kopyalandı");
        });
    }); //! TagCopy Son
           
    //! TagCancel
    document.querySelectorAll('#tagCancel').forEach(function (i) {
        i.addEventListener('click', function (e) {
           
            var dataLang = e.target.lang; //! Dil
            $('[id="tagInput"][lang="'+dataLang+'"]').attr('data_value', ''); //! Veri Temizliyor
            $('[id="tagInput"][lang="'+dataLang+'"]').val(''); //! Veri Temizliyor
            
            tagsSplit(dataLang); //! Fonksiyon Çağırıyor

        });
    }); //! TagCancel Son

});
//! ************ Keywork Son ***************
