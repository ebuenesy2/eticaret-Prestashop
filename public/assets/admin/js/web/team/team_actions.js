/***
 * Sabit List
 * Veri Ekleme
 * Veri Güncelleme
 * Veri Sil
 * Çoklu İşlemler
*/

console.log("team_actions.js");

//! Dil Alıyor
var yildirimdevMultiLangJson = JSON.parse(localStorage.getItem('yildirimdevMultiLang')); //! Çoklu Dil

//! Çoklu Dil Fonksiyon
function yildirimdevMultiLangJsonReturn () {
    if(yildirimdevMultiLangJson == null) { var yildirimdevMultiLangJson = JSON.parse(localStorage.getItem('yildirimdevMultiLang')); }
    return yildirimdevMultiLangJson;
}  //! Çoklu Dil Fonksiyon Son

//! Tanım
var listUrl = "/admin/team"; //! List Adresi

//! Yüklenince Kapanıyor
$(document).ready(function () { $('#loader').hide(); });

//! ************  Resmi Güncelle  ***************
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
//! ************  Resmi Güncelle Son ***************

//! ************ Ekleme  ***************
//! Ekleme
document.querySelectorAll('#new_add').forEach(function (i) {
    i.addEventListener('click', function (event) {

        var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
        //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);
    
        //! Loading - Veri Yüklendi
        function loadingYuklendi(){
            $('[id="loaderAdd"]').hide(); //! Laoding Gizle
            $('[id="new_add"]').removeAttr('disabled'); //! //! Button Göster
            $('[id="new_add"]').css('cursor','pointer'); //! Cursor - Ok
        }
        //! Loading - Veri Yüklendi Son
    
        //! Veriler
        var nameAdd = $('input[id="nameAdd"]').val(); 
        var surnameAdd = $('input[id="surnameAdd"]').val(); 
       
        if(nameAdd == '') { 
    
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Ad Yazılmadı",
                showConfirmButton: false,
                timer: 2000,
            });
    
            loadingYuklendi(); //! Fonksiyon Çalıştır
        }
        else if(surnameAdd == '') { 
    
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Soyad Yazılmadı",
                showConfirmButton: false,
                timer: 2000,
            });
    
            loadingYuklendi(); //! Fonksiyon Çalıştır
        }
        else {
    
            //! Ajax  Post
            $.ajax({
                url: listUrl + "/add/post",
                type: "post",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {
                    siteLang: yildirimdevMultiLangJsonReturnR.lang,
                    imgUrl:$('#fileUploadImage').attr('src'),
                    name:$('#nameAdd').val(),
                    surname:$('#surnameAdd').val(),
                    role:$('#roleAdd').val(),
                    phone:$('#phoneAdd').val(),
                    phone2:$('#phone2Add').val(),
                    facebook_url:$('#facebookUrlAdd').val(),
                    twitter_url:$('#twitterUrlAdd').val(),
                    instagram_url:$('#instagramUrlAdd').val(),
                    linkedin_url:$('#linkedinUrlAdd').val(),
                    web_url:$('#webUrlAdd').val(),
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
});
//! Ekleme Son
//! ************ Ekleme Son  ***************

//! ************ Güncelle  *******************
//! Güncelle
document.querySelectorAll('#edit_item').forEach(function (i) {
    i.addEventListener('click', function (event) {

        var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
        //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);

        var data_id = $('#dataValueInfo').attr('data_id'); //! id
        //console.log("data_id:", data_id);
    
        //! Loading - Veri Yüklendi
        function loadingYuklendi(){
            $('[id="loaderEdit"]').hide(); //! Laoding Gizle
            $('[id="edit_item"]').removeAttr('disabled'); //! //! Button Göster
            $('[id="edit_item"]').css('cursor','pointer'); //! Cursor - Ok
        }
        //! Loading - Veri Yüklendi Son

        //! Veriler
        var nameEdit = $('input[id="nameEdit"]').val(); 
        var surnameEdit = $('input[id="surnameEdit"]').val(); 
    
        if(nameEdit == '') { 
    
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Ad Yazılmadı",
                showConfirmButton: false,
                timer: 2000,
            });
    
            loadingYuklendi(); //! Fonksiyon Çalıştır
        }
        else if(surnameEdit == '') { 
    
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Soyad Yazılmadı",
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
                    id:data_id,
                    imgUrl:$('#fileUploadImage').attr('src'),
                    name:$('#nameEdit').val(),
                    surname:$('#surnameEdit').val(),
                    role:$('#roleEdit').val(),
                    phone:$('#phoneEdit').val(),
                    phone2:$('#phone2Edit').val(),
                    facebook_url:$('#facebookUrlEdit').val(),
                    twitter_url:$('#twitterUrlEdit').val(),
                    instagram_url:$('#instagramUrlEdit').val(),
                    linkedin_url:$('#linkedinUrlEdit').val(),
                    web_url:$('#webUrlEdit').val(),
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
function deleteItem(data_id) {
    var yildirimdevMultiLangJson = yildirimdevMultiLangJsonReturn();
    //console.log("lang:",yildirimdevMultiLangJson.lang);
      
    //! Alert
    Swal.fire({
        title: yildirimdevMultiLangJson.areYouSure+" #"+data_id,
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
                    id:Number(data_id),
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
        
                        //! Sayfa Gitme
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

        var data_id = e.target.getAttribute("data_id"); //! id
        //console.log("data_id:", data_id);

        deleteItem(data_id); //! sil
    
    })
}) //! Silme Son
//! ************ Silme Son  ***************


//! ************ Clone ***************
//! Clone
document.querySelectorAll("#cloneItem").forEach((Item) => {  
    Item.addEventListener("click", e => {  

        var yildirimdevMultiLangJson = yildirimdevMultiLangJsonReturn();
        //console.log("lang:",yildirimdevMultiLangJson.lang);

        var data_id = e.target.getAttribute("data_id"); //! id
        //console.log("data_id:", data_id);

        //! Alert
        Swal.fire({
            title: yildirimdevMultiLangJson.createClone+" #"+data_id,
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
                        id:Number(data_id),
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

