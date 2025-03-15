/***
 * Sabit List
 * Veri Ekleme
 * Veri Güncelleme
 * Veri Sil
 * Çoklu İşlemler
*/

console.log("institutional.js");

//! Dil Alıyor
var yildirimdevMultiLangJson = JSON.parse(localStorage.getItem('yildirimdevMultiLang')); //! Çoklu Dil

//! Çoklu Dil Fonksiyon
function yildirimdevMultiLangJsonReturn () {
    if(yildirimdevMultiLangJson == null) { var yildirimdevMultiLangJson = JSON.parse(localStorage.getItem('yildirimdevMultiLang')); }
    return yildirimdevMultiLangJson;
}  //! Çoklu Dil Fonksiyon Son

//! Tanım
var listUrl = "/admin/institutional"; //! List Adresi

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

//! ************ Güncelle  *******************

//! Güncelle 
document.querySelectorAll('#edit_institutional').forEach(function (i) {
    i.addEventListener('click', function (event) {
          
        var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
        //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);

        //! Loading - Veri Yükleniyor
        $('#loaderEdit').show(); //! Laoding Göster
        $('#edit_institutional').attr('disabled','disabled'); //! Button Gizleme
        document.getElementById("edit_institutional").style.cursor = "wait"; //! Cursor - Dönen

        //! Loading - Veri Yüklendi
        function loadingYuklendi(){
            $('#loaderEdit').hide(); //! Laoding Gizle
            $('#edit_institutional').removeAttr('disabled'); //! //! Button Göster
            document.getElementById("edit_institutional").style.cursor = "pointer"; //! Cursor - Ok
        }
        //! Loading - Veri Yüklendi Son

        //! Veriler
        var dataLang = event.target.lang; //! Dil
        var dataInstitutional = event.target.attributes["data_institutional"].textContent; //! Kurumsal
        var dataEdit = ""; //! Veri

        if(dataLang == "tr") { var dataEdit = CKEDITOR.instances["editor1"].getData() }
        else if(dataLang == "en") { var dataEdit = CKEDITOR.instances["editor2"].getData() }
        else if(dataLang == "de") { var dataEdit = CKEDITOR.instances["editor3"].getData() }

        if(dataEdit == '') { 

            Swal.fire({
                position: "center",
                icon: "error",
                title: "Yazılmadı",
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
                    institutional:dataInstitutional,
                    img_url:$('#fileUploadImage').attr('src'),
                    data: dataEdit,
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
      
   
    });
});
//! Güncelle  Son

//! ************ Güncelle Son  ***************


//! ************ Güncelle - Resim  *******************

//! Güncelle 
document.querySelectorAll('#edit_institutional_img').forEach(function (i) {
    i.addEventListener('click', function (event) {
          
        var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
        //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);

        var dataInstitutional = event.target.attributes["data_institutional"].textContent; //! Kurumsal

        //! Loading - Veri Yükleniyor
        $('#loaderEdit_img').show(); //! Laoding Göster
        $('#edit_institutional_img').attr('disabled','disabled'); //! Button Gizleme
        document.getElementById("edit_institutional_img").style.cursor = "wait"; //! Cursor - Dönen

        //! Loading - Veri Yüklendi
        function loadingYuklendi(){
            $('#loaderEdit_img').hide(); //! Laoding Gizle
            $('#edit_institutional_img').removeAttr('disabled'); //! //! Button Göster
            document.getElementById("edit_institutional_img").style.cursor = "pointer"; //! Cursor - Ok
        }
        //! Loading - Veri Yüklendi Son
        
        //! Ajax  Post
        $.ajax({
            url: listUrl + "/edit/img/post",
            type: "post",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                siteLang: yildirimdevMultiLangJsonReturnR.lang,
                institutional:dataInstitutional,
                img_url:$('#fileUploadImage').attr('src'),
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
});
//! Güncelle  Son

//! ************ Güncelle - Resim  Son  ***************
