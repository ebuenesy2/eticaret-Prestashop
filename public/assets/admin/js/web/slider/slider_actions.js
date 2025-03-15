/***
 * Sabit List
 * Veri Ekleme
 * Veri Güncelleme
 * Veri Sil
 * Çoklu İşlemler
*/

console.log("slider_actions.js");

//! Dil Alıyor
var yildirimdevMultiLangJson = JSON.parse(localStorage.getItem('yildirimdevMultiLang')); //! Çoklu Dil

//! Çoklu Dil Fonksiyon
function yildirimdevMultiLangJsonReturn () {
    if(yildirimdevMultiLangJson == null) { var yildirimdevMultiLangJson = JSON.parse(localStorage.getItem('yildirimdevMultiLang')); }
    return yildirimdevMultiLangJson;
}  //! Çoklu Dil Fonksiyon Son

//! Tanım
var listUrl = "/admin/slider"; //! List Adresi

//! Yüklenince Kapanıyor
$(document).ready(function () { $('#loader').hide(); });

//! ************ Resmi Güncelle  ***************
//! Dosya Yükleme
$("#fileUploadClick").click(function (e) {
    e.preventDefault();
    //alert("fileUploadClick");

    var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
    //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);

    //! Dosya Yükleme
    const fileInput = document.querySelector("#fileInput");
    const fileInputFiles = fileInput.files;
    //console.log("fileInputFiles:",fileInputFiles);

    //! Yeni Form Veriler
    var formData = new FormData();
    formData.append("file", fileInputFiles[0]);
    formData.append("fileDbSave", $('#fileDbSave').val());
    formData.append("fileWhere", $('#fileWhere').val());

    $.ajax({
        xhr: function() {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                    var percentComplete = ((evt.loaded / evt.total) * 100);
                    console.log("Dosya Yükleme Durumu: %", percentComplete);

                    $("#progressBarFileUpload").width(percentComplete + '%');
                    $("#progressBarFileUpload").html(percentComplete+'%');
                    
                }
            }, false);
            return xhr;
        },
        url: "/file/upload/control",
        type: "post",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: formData,
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function () {
            console.log("Dosya yükleme başladı");

            //! ProgressBar
            $("#progressBarFileUpload").width('0%');

            //! Upload Durum
            $('#LoadingFileUpload').toggle();
            $('#uploadStatus').hide();

            //! Upload Url
            $('#filePathUrl').html("");
        },
        error: function (error) {
            alert("başarısız");
            console.log("Hata oluştu error:", error);

            //! Upload Durum
            $('#LoadingFileUpload').hide();
            $('#uploadStatus').html('<p style="color:#EA4335;">File upload failed, please try again.</p>');

            //! Upload Url
            $('#filePathUrl').html("");

            //! Alert
            Swal.fire({
                position: "center",
                icon: "error",
                title: yildirimdevMultiLangJsonReturnR.transactionFailed,
                showConfirmButton: false,
                timer: 2000,
            });  //! Alert Son

        },
        success: function (resp) {
            //alert("Başarılı");
            console.log("file resp:", resp);

            //! ProgressBar
            $("#progressBarFileUpload").width('100%');

            //! Upload Durum
            $('#LoadingFileUpload').hide();
            $('#uploadStatus').hide();

            //! Upload Url
            $('#filePathUrl').html(resp.file_url);
            $('#fileUploadImage').attr('src',"/"+resp.file_url);

        }
    }); //! Ajax

});
//! Dosya Yükleme Son
//! ************ Resmi Güncelle Son ***************

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
        var titleAdd = $('input[id="titleAdd"][lang="'+dataLang+'"]').val(); //! Başlık
        var title2Add = $('input[id="title2Add"][lang="'+dataLang+'"]').val(); //! Başlık
        var urlAdd = $('input[id="urlAdd"][lang="'+dataLang+'"]').val(); //! URL
        var dataAdd = ""; //! Veri

        if(dataLang == "tr") { var dataAdd = CKEDITOR.instances["editor1"].getData() }
        else if(dataLang == "en") { var dataAdd = CKEDITOR.instances["editor2"].getData() }
        else if(dataLang == "de") { var dataAdd = CKEDITOR.instances["editor3"].getData() }

        if(titleAdd == '') { 
    
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Başlık Yazılmadı",
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
                    imgUrl:$('#fileUploadImage').attr('src'),
                    title:titleAdd,
                    title2:title2Add,
                    url:urlAdd,
                    description: dataAdd,
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
        var titleEdit = $('input[id="titleEdit"][lang="'+dataLang+'"]').val(); //! Başlık
        var title2Edit = $('input[id="title2Edit"][lang="'+dataLang+'"]').val(); //! Başlık
        var urlEdit = $('input[id="urlEdit"][lang="'+dataLang+'"]').val(); //! URL
        var dataEdit = ""; //! Veri

        if(dataLang == "tr") { var dataEdit = CKEDITOR.instances["editor1"].getData() }
        else if(dataLang == "en") { var dataEdit = CKEDITOR.instances["editor2"].getData() }
        else if(dataLang == "de") { var dataEdit = CKEDITOR.instances["editor3"].getData() }

        if(titleEdit == '') { 
    
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Başlık Yazılmadı",
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
                    imgUrl:$('#fileUploadImage').attr('src'),
                    title:titleEdit,
                    title2:title2Edit,
                    url:urlEdit,
                    description: dataEdit,
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

//! ************ Güncelle - Resim *******************
//! Güncelle
document.querySelectorAll('#edit_item_img').forEach(function (i) {
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
            url: listUrl + "/edit/img/post",
            type: "post",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                siteLang: yildirimdevMultiLangJsonReturnR.lang,
                lang:dataLang,
                uid:data_uid,
                imgUrl:$('#fileUploadImage').attr('src'),
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
//! ************ Güncelle - Resim Son  ***************

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

