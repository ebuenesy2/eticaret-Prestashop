/***
 * Sabit List
 * Veri Ekleme
 * Veri Güncelleme
 * Veri Sil
 * Çoklu İşlemler
*/

console.log("faq.js");

//! Dil Alıyor
var yildirimdevMultiLangJson = JSON.parse(localStorage.getItem('yildirimdevMultiLang')); //! Çoklu Dil

//! Çoklu Dil Fonksiyon
function yildirimdevMultiLangJsonReturn () {
    if(yildirimdevMultiLangJson == null) { var yildirimdevMultiLangJson = JSON.parse(localStorage.getItem('yildirimdevMultiLang')); }
    return yildirimdevMultiLangJson;
}  //! Çoklu Dil Fonksiyon Son

//! Tanım
var listUrl = "/admin/faq"; //! List Adresi

//! Yüklenince Kapanıyor
$(document).ready(function () { $('#loader').hide(); });

//! ************ Ekleme  ***************

//! Ekleme
document.querySelectorAll('#new_add').forEach(function (i) {
    i.addEventListener('click', function (event) {

        var dataLang = event.target.lang; //! Dil
        var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
        //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);
    
        //! Loading - Veri Yükleniyor
        $('[id="loaderAdd"][lang="'+dataLang+'"]').show(); //! Laoding Göster
        $('[id="new_add"][lang="'+dataLang+'"]').attr('disabled','disabled'); //! Button Gizleme
        $('[id="new_add"][lang="'+dataLang+'"]').css('cursor','wait'); //! Cursor - Dönen
    
        //! Loading - Veri Yüklendi
        function loadingYuklendi(){
            $('[id="loaderAdd"][lang="'+dataLang+'"]').hide(); //! Laoding Gizle
            $('[id="new_add"][lang="'+dataLang+'"]').removeAttr('disabled'); //! //! Button Göster
            $('[id="new_add"][lang="'+dataLang+'"]').css('cursor','pointer'); //! Cursor - Ok
        }
        //! Loading - Veri Yüklendi Son
    
        //! Veriler
        var questionAdd = $('input[id="questionAdd"][lang="'+dataLang+'"]').val(); //! Soru
        var dataAdd = ""; //! Veri

        if(dataLang == "tr") { var dataAdd = CKEDITOR.instances["editor1"].getData() }
        else if(dataLang == "en") { var dataAdd = CKEDITOR.instances["editor2"].getData() }
        else if(dataLang == "de") { var dataAdd = CKEDITOR.instances["editor3"].getData() }

        if(questionAdd == '') { 
    
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Soru Yazılmadı",
                showConfirmButton: false,
                timer: 2000,
            });
    
            loadingYuklendi(); //! Fonksiyon Çalıştır
        }
        else if(dataAdd == '') { 
    
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Cevap Yazılmadı",
                showConfirmButton: false,
                timer: 2000,
            });
    
            loadingYuklendi(); //! Fonksiyon Çalıştır
        }
        else {

            var data_uid = $('#dataValueInfo').attr('data_uid');
    
            //! Ajax  Post
            $.ajax({
                url: listUrl + "/add/post",
                type: "post",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {
                    siteLang: yildirimdevMultiLangJsonReturnR.lang,
                    lang:dataLang,
                    uid:data_uid,
                    category:Number($('#faqCategoryAdd').val()),
                    question:questionAdd,
                    answer: dataAdd,
                    created_byId: document.cookie.split(';').find((row) => row.startsWith(' yildirimdev_userID='))?.split('=')[1]
                },
                beforeSend: function() { console.log("Başlangıc"); },
                success: function (response) {
                    // alert("başarılı");
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
                        //window.location.reload();

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
});
//! Ekleme Son

//! ************ Ekleme Son  ***************

//! ************ Güncelle - Bilgiler *******************
//! Güncelle
document.querySelectorAll('#edit_item_info').forEach(function (i) {
    i.addEventListener('click', function (event) {

        var dataLang = event.target.lang; //! Dil
        var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
        //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);

        var data_uid = $('#dataValueInfo').attr('data_uid'); //! id
        //console.log("data_id:", data_id);

        //! Loading - Veri Yükleniyor
        $('[id="loaderEditImage"][lang="'+dataLang+'"]').show(); //! Laoding Göster
        $('[id="edit_item_img"][lang="'+dataLang+'"]').attr('disabled','disabled'); //! Button Gizleme
        $('[id="edit_item_img"][lang="'+dataLang+'"]').css('cursor','wait'); //! Cursor - Dönen
    
        //! Loading - Veri Yüklendi
        function loadingYuklendi(){
            $('[id="loaderEditImage"][lang="'+dataLang+'"]').hide(); //! Laoding Gizle
            $('[id="edit_item_img"][lang="'+dataLang+'"]').removeAttr('disabled'); //! //! Button Göster
            $('[id="edit_item_img"][lang="'+dataLang+'"]').css('cursor','pointer'); //! Cursor - Ok
        }
        //! Loading - Veri Yüklendi Son

        //! Ajax  Post
        $.ajax({
            url: listUrl + "/edit/info/post",
            type: "post",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                siteLang: yildirimdevMultiLangJsonReturnR.lang,
                lang:dataLang,
                uid:data_uid,
                category:Number($('#faqCategoryEdit').val()),
                updated_byId: document.cookie.split(';').find((row) => row.startsWith(' yildirimdev_userID='))?.split('=')[1]
            },
            beforeSend: function() { console.log("Başlangıc"); },
            success: function (response) {
                // alert("başarılı");
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
                    //window.location.reload();
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
      
    });
}); //! Güncelle Son
//! ************ Güncelle - Bilgiler Son  ***************

//! ************ Güncelle  *******************

//! Güncelle
document.querySelectorAll('#edit_item').forEach(function (i) {
    i.addEventListener('click', function (event) {

        var dataLang = event.target.lang; //! Dil
        var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
        //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);

        var data_uid = $('#dataValueInfo').attr('data_uid'); //! id
        //console.log("data_id:", data_id);

        //! Loading - Veri Yükleniyor
        $('[id="loaderEdit"][lang="'+dataLang+'"]').show(); //! Laoding Göster
        $('[id="edit_item"][lang="'+dataLang+'"]').attr('disabled','disabled'); //! Button Gizleme
        $('[id="edit_item"][lang="'+dataLang+'"]').css('cursor','wait'); //! Cursor - Dönen
    
        //! Loading - Veri Yüklendi
        function loadingYuklendi(){
            $('[id="loaderEdit"][lang="'+dataLang+'"]').hide(); //! Laoding Gizle
            $('[id="edit_item"][lang="'+dataLang+'"]').removeAttr('disabled'); //! //! Button Göster
            $('[id="edit_item"][lang="'+dataLang+'"]').css('cursor','pointer'); //! Cursor - Ok
        }
        //! Loading - Veri Yüklendi Son

        //! Veriler
        var questionEdit = $('input[id="questionEdit"][lang="'+dataLang+'"]').val(); //! Soru
        var answerEdit = ""; //! Veri

        if(dataLang == "tr") { var answerEdit = CKEDITOR.instances["editor1"].getData() }
        else if(dataLang == "en") { var answerEdit = CKEDITOR.instances["editor2"].getData() }
        else if(dataLang == "de") { var answerEdit = CKEDITOR.instances["editor3"].getData() }

        if(questionEdit == '') { 

            Swal.fire({
                position: "center",
                icon: "error",
                title: "Soru Yazılmadı",
                showConfirmButton: false,
                timer: 2000,
            });

            loadingYuklendi(); //! Fonksiyon Çalıştır
        }
        else if(answerEdit == '') { 

            Swal.fire({
                position: "center",
                icon: "error",
                title: "Cevap Yazılmadı",
                showConfirmButton: false,
                timer: 2000,
            });

            loadingYuklendi(); //! Fonksiyon Çalıştır
        }
        else {

            //! Ajax  Post
            $.ajax({
                url: listUrl + "/edit/post",
                type: "post",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {
                    siteLang: yildirimdevMultiLangJsonReturnR.lang,
                    lang:dataLang,
                    uid:data_uid,
                    category:Number($('#faqCategoryEdit').val()),
                    question: questionEdit,
                    answer:answerEdit,
                    updated_byId: document.cookie.split(';').find((row) => row.startsWith(' yildirimdev_userID='))?.split('=')[1]
                },
                beforeSend: function() { console.log("Başlangıc"); },
                success: function (response) {
                    // alert("başarılı");
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
                        //window.location.reload();
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
}); //! Güncelle Son

//! ************ Güncelle Son  ***************


//! ************ Silme ***************

//! Silme Fonksiyon
function deleteItem(data_uid) {
    var yildirimdevMultiLangJson = yildirimdevMultiLangJsonReturn();
    //console.log("lang:",yildirimdevMultiLangJson.lang);
      
    //! Alert
    Swal.fire({
        title: yildirimdevMultiLangJson.areYouSure+" #"+data_uid,
        //text:  yildirimdevMultiLangJson.DeleteWarning,
        icon: 'error',
        showCancelButton: true,
        cancelButtonColor: '#d33',
        cancelButtonText: yildirimdevMultiLangJson.no,
        confirmButtonColor: '#3085d6',
        confirmButtonText: yildirimdevMultiLangJson.yes,
    }).then((result) => {
        if (result.isConfirmed) {
            //alert("oldu");

            //! Ajax  Post
            $.ajax({
                url: listUrl + "/delete/post",
                type: "post",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {
                    siteLang: yildirimdevMultiLangJson.lang,
                    uid:Number(data_uid),
                    //created_byId: document.cookie.split(';').find((row) => row.startsWith(' yildirimdev_userID='))?.split('=')[1],
                },              
                beforeSend: function() { console.log("Başlangıc"); },
                success: function (response) {
                    //alert("başarılı");
                    console.log("response:", response);
                    //console.log("status:", response.status);

                    if (response.status == "success") {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: yildirimdevMultiLangJson.transactionSuccessful,
                            showConfirmButton: false,
                            timer: 2000,
                        });
        
                        //! Sayfa Yenileme
                        window.location.href = "/"+yildirimdevMultiLangJson.lang+listUrl+"/list";
                    } else {
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            title: yildirimdevMultiLangJson.transactionFailed,
                            showConfirmButton: false,
                            timer: 2000,
                        });
                    }
                },
                error: function (error) {
                    Swal.fire({
                            position: "center",
                            icon: "error",
                            title: yildirimdevMultiLangJson.transactionFailed,
                            showConfirmButton: false,
                            timer: 2000,
                        });
                    console.log("error:", error);
                },
                complete: function() {  console.log("Search Ajax Bitti"); }
            }); //! Ajax Post Son

        }
    });
    //! Alert Son
}
//! Silme Fonksiyon Son

//! Silme
document.querySelectorAll("#deleteItem").forEach((Item) => {  
    Item.addEventListener("click", e => {  

        var data_uid = e.target.getAttribute("data_uid"); //! id
        //console.log("data_uid:", data_uid);

        deleteItem(data_uid); //! sil
    
    })
}) //! Silme Son
//! ************ Silme Son  ***************


//! ************ Clone ***************
//! Clone
document.querySelectorAll("#cloneItem").forEach((Item) => {  
    Item.addEventListener("click", e => {  

        var yildirimdevMultiLangJson = yildirimdevMultiLangJsonReturn();
        //console.log("lang:",yildirimdevMultiLangJson.lang);

        var data_uid = e.target.getAttribute("data_uid"); //! id
        //console.log("data_uid:", data_uid);

        //! Alert
        Swal.fire({
            title: yildirimdevMultiLangJson.createClone+" #"+data_uid,
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            cancelButtonText: yildirimdevMultiLangJson.no,
            confirmButtonColor: '#3085d6',
            confirmButtonText: yildirimdevMultiLangJson.yes,
        }).then((result) => {
            if (result.isConfirmed) {
                //alert("oldu");

                //! Ajax  Post
                $.ajax({
                    url: listUrl + "/clone",
                    type: "post",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: {
                        siteLang: yildirimdevMultiLangJson.lang,
                        uid:Number(data_uid),
                        created_byId: document.cookie.split(';').find((row) => row.startsWith(' yildirimdev_userID='))?.split('=')[1]
                    },              
                    beforeSend: function() { console.log("Başlangıc"); },
                    success: function (response) {
                        // alert("başarılı");
                        console.log("response:", response);
                        // console.log("status:", response.status);

                        if (response.status == "success") {
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: yildirimdevMultiLangJson.transactionSuccessful,
                                showConfirmButton: false,
                                timer: 2000,
                            });
        
                            //! Sayfa Yenileme
                            window.location.href = "/"+yildirimdevMultiLangJson.lang+listUrl+"/edit/"+response.addNewId;
                        } else {
                            Swal.fire({
                                position: "center",
                                icon: "error",
                                title: yildirimdevMultiLangJson.transactionFailed,
                                showConfirmButton: false,
                                timer: 2000,
                            });
                        }
                    },
                    error: function (error) { console.log("search error:", error); },
                    complete: function() {  console.log("Search Ajax Bitti"); }
                }); //! Ajax Post Son

            }
        });
        //! Alert Son
    
    })
}) //! Clone Son
//! ************ Clone Son  ***************

//! ************ Tuş Algılama ***************
$("html").keydown(function(event) {
    //console.log("event:",event);
    var data_action = $('#dataValueInfo').attr('data_action'); //! add - edit
    if (event.keyCode == 46 && data_action == 'edit') {
        var data_id = $('#dataValueId').attr('data_id');
        deleteItem(data_id); //! sil
    }
});
//! ************ Tuş Algılama Son ***************


//! ************ Enter Focus *******************
$('input[focustype="true"]').keydown(function(event) {
    //console.log("event:",event);

    //! Veri - Sayısı
    var eventTarget_FocusOrder = event.target.getAttribute("focusOrder"); //! Sırası [1 - 2]
    //console.log("eventTarget_FocusOrder:",eventTarget_FocusOrder);

    //! Veri - Control
    var eventTarget_focusControl = event.target.getAttribute("focusControl"); //! Control [add - edit]
    //console.log("eventTarget_focusControl:",eventTarget_focusControl); 

    //! Veri - Control Active
    var focusControl_Active = event.target.getAttribute("focusControl_Active"); //! Control [true - false]
    //console.log("focusControl_Active:",focusControl_Active);     

    //! Enter
    if (event.keyCode == 13 && focusControl_Active == "false") { $('[focustype="true"][focusControl="'+eventTarget_focusControl+'"][focusorder="'+(Number(eventTarget_FocusOrder)+1)+'"]').focus(); } //! Geç
    else if (event.keyCode == 13 && eventTarget_focusControl == "add" && focusControl_Active == "true") { $('#new_add').focus(); } //! Ekle
    else if (event.keyCode == 13 && eventTarget_focusControl == "edit" && focusControl_Active == "true") { $('#edit_item').focus(); } //! Güncelle
    
});
//! ************ Enter Focus Son ***************
