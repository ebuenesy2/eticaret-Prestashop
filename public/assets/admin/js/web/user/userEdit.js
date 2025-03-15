/***
* Veri Ekleme
 * Veri Güncelleme
*/

//alert("userEdit.js")
console.log("userEdit.js");

//! Dil Alıyor
var yildirimdevMultiLangJson = JSON.parse(localStorage.getItem('yildirimdevMultiLang')); //! Çoklu Dil

//! Çoklu Dil Fonksiyon
function yildirimdevMultiLangJsonReturn () {
    if(yildirimdevMultiLangJson == null) { var yildirimdevMultiLangJson = JSON.parse(localStorage.getItem('yildirimdevMultiLang')); }
    return yildirimdevMultiLangJson;
}  //! Çoklu Dil Fonksiyon Son

//! Tanım
var listUrl = "/admin/web/user"; //! Adres

//! Yüklenince Kapanıyor
$(document).ready(function () { $('#loader').hide(); });

//! ************ Güncelle  ***************
//! Güncelle
$("#userEdit").click(function (e) {
    e.preventDefault();
    // alert("Kullanıcı Güncelleme");

    var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
    //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);
  
    //! Loading - Veri Yükleniyor
    $('#loader').show(); //! Laoding Göster
    $('body input,textarea,select').attr('disabled','disabled'); //! İnputları Gizleme
    $('body button').attr('disabled','disabled'); //! Buttonları Gizleme
    $('#userEdit').attr('disabled','disabled'); //! Button Gizleme
    document.getElementById("userEdit").style.cursor = "wait"; //! Cursor - Dönen

    //! Loading - Veri Yüklendi
    function loadingYuklendi(){
        $('#loader').hide(); //! Laoding Gizle
        $('body input,textarea,select').removeAttr('disabled'); //! İnputları Aç
        $('body button').removeAttr('disabled'); //! Buttonları Aç
        $('#userEdit').removeAttr('disabled'); //! //! Button Göster
        document.getElementById("userEdit").style.cursor = "pointer"; //! Cursor - Ok
    }
    //! Loading - Veri Yüklendi Son
    
    //! Veriler
    var userName = $('#userName').val();

    if(userName == '') { 
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Ad Yazılmadı",
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
                id:Number($('#userInfo').attr('userId')),

                name:$('#userName').val(),
                surname:$('#userSurname').val(),
                phone:$('#userPhone').val(),

                dateofBirth:$('#userDateofBirth').val(),
                role:$('#userRole').val(),
                
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

}); //! Güncelle Son
//! ************ Güncelle Son  ***************

//! ************ Sifre Güncelle  ***************
//! Sifre Güncelle
$("#userPasswordEdit").click(function (e) {
    e.preventDefault();
    //alert("Sifre Güncelleme");

    var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
    //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);
    
    //! Loading - Veri Yükleniyor
    $('#loader').show(); //! Laoding Göster
    $('body input,textarea,select').attr('disabled','disabled'); //! İnputları Gizleme
    $('body button').attr('disabled','disabled'); //! Buttonları Gizleme
    $('#userPasswordEdit').attr('disabled','disabled'); //! Button Gizleme
    document.getElementById("userPasswordEdit").style.cursor = "wait"; //! Cursor - Dönen

    //! Loading - Veri Yüklendi
    function loadingYuklendi(){
        $('#loader').hide(); //! Laoding Gizle
        $('body input,textarea,select').removeAttr('disabled'); //! İnputları Aç
        $('body button').removeAttr('disabled'); //! Buttonları Aç
        $('#userPasswordEdit').removeAttr('disabled'); //! //! Button Göster
        document.getElementById("userPasswordEdit").style.cursor = "pointer"; //! Cursor - Ok
    }
    //! Loading - Veri Yüklendi Son
    
    //! Veriler
    var myPassword = $('#myPassword').val();
    var newPassword = $('#newPassword').val();
    var rePassword = $('#rePassword').val();

    if(myPassword == '') { 
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Şifre Yazılmadı",
            showConfirmButton: false,
            timer: 2000,
        });

        loadingYuklendi(); //! Fonksiyon Çalıştır

    }
    else if(newPassword == '' || rePassword == '' ) { 
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Yeni Şifre Yazılmadı",
            showConfirmButton: false,
            timer: 2000,
        });

        loadingYuklendi(); //! Fonksiyon Çalıştır

    }
    else if(newPassword == rePassword) { 
         
        //! Ajax  Post
        $.ajax({
            url: listUrl + "/edit/password",
            type: "post",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                siteLang: yildirimdevMultiLangJsonReturnR.lang,
                id:Number($('#userInfo').attr('userId')),
                myPassword:$('#myPassword').val(),
                password:$('#newPassword').val(),
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
                    window.location.reload();
                } else {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: response.msg,
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
    else {

        loadingYuklendi();

        Swal.fire({
            position: "center",
            icon: "error",
            title: yildirimdevMultiLangJsonReturnR.passwordsDoNotMatch,
            showConfirmButton: false,
            timer: 2000,
        });
    }

}); //! Sifre Güncelle Son
//! ************ Sifre Güncelle Son  ***************

//! ************ Email Güncelle  ***************
//! Email Güncelle
$("#userEmailEdit").click(function (e) {
    e.preventDefault();
    //alert("Sifre Güncelleme");

    var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
    //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);
    
    //! Loading - Veri Yükleniyor
    $('#loader').show(); //! Laoding Göster
    $('body input,textarea,select').attr('disabled','disabled'); //! İnputları Gizleme
    $('body button').attr('disabled','disabled'); //! Buttonları Gizleme
    $('#userEmailEdit').attr('disabled','disabled'); //! Button Gizleme
    document.getElementById("userEmailEdit").style.cursor = "wait"; //! Cursor - Dönen

    //! Loading - Veri Yüklendi
    function loadingYuklendi(){
        $('#loader').hide(); //! Laoding Gizle
        $('body input,textarea,select').removeAttr('disabled'); //! İnputları Aç
        $('body button').removeAttr('disabled'); //! Buttonları Aç
        $('#userEmailEdit').removeAttr('disabled'); //! //! Button Göster
        document.getElementById("userEmailEdit").style.cursor = "pointer"; //! Cursor - Ok
    }
    //! Loading - Veri Yüklendi Son
    
    //! Ajax  Post
    $.ajax({
        url: listUrl + "/edit/email",
        type: "post",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            siteLang: yildirimdevMultiLangJsonReturnR.lang,
            id:Number($('#userInfo').attr('userId')),
            myEmail:$('#myEmail').val(),
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
                window.location.reload();
            } else {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: response.msg,
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

}); //! Email Güncelle Son
//! ************ Email Güncelle Son  ***************

//! ************ Profil Resmi Güncelle  ***************
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
            $('#profileImage').attr('src',"/"+resp.file_url);

        }
    }); //! Ajax



});
//! Dosya Yükleme Son

//! Profil Resmi Güncelle
$("#userImageEdit").click(function (e) {
    e.preventDefault();
    //alert("Profil Resm Güncelleme");

    var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
    //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);
        
    //! Loading - Veri Yükleniyor
    $('#loader').show(); //! Laoding Göster
    $('body input,textarea,select').attr('disabled','disabled'); //! İnputları Gizleme
    $('body button').attr('disabled','disabled'); //! Buttonları Gizleme
    $('#userImageEdit').attr('disabled','disabled'); //! Button Gizleme
    document.getElementById("userImageEdit").style.cursor = "wait"; //! Cursor - Dönen

    //! Loading - Veri Yüklendi
    function loadingYuklendi(){
        $('#loader').hide(); //! Laoding Gizle
        $('body input,textarea,select').removeAttr('disabled'); //! İnputları Aç
        $('body button').removeAttr('disabled'); //! Buttonları Aç
        $('#userImageEdit').removeAttr('disabled'); //! //! Button Göster
        document.getElementById("userImageEdit").style.cursor = "pointer"; //! Cursor - Ok
    }
    //! Loading - Veri Yüklendi Son
    
    //! Ajax  Post
    $.ajax({
        url: listUrl + "/edit/imgUrl",
        type: "post",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            siteLang: yildirimdevMultiLangJsonReturnR.lang,
            id:Number($('#userInfo').attr('userId')),
            img_url:$('#profileImage').attr('src'),
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

});
//! Profil Resmi Güncelle Son
//! ************ Profil Resmi Güncelle Son ***************


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

        var data_id = e.target.getAttribute("data_id"); //! id
        //console.log("data_id:", data_id);

        deleteItem(data_id); //! sil
    
    })
}) //! Silme Son
//! ************ Silme Son  ***************


//! ************ Tuş Algılama ***************
$("html").keydown(function(event) {
    //console.log("event:",event);
    if (event.keyCode == 46) {
        var data_id = $('#userInfo').attr('userId');
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
    else if (event.keyCode == 13 && eventTarget_focusControl == "edit_user" && focusControl_Active == "true") { $('#userEdit').focus(); } //! Kullanıcı Bilgileri Güncelle
    else if (event.keyCode == 13 && eventTarget_focusControl == "edit_pass" && focusControl_Active == "true") { $('#userPasswordEdit').focus(); } //! Şifre Güncelle
    else if (event.keyCode == 13 && eventTarget_focusControl == "edit_mail" && focusControl_Active == "true") { $('#userEmailEdit').focus(); } //! Mail Güncelle
   
    
});
//! ************ Enter Focus Son ***************