$(function () {

    //alert("FileUpload çalışıyor");
    console.log(" api fileupload çalışıyor");

    //! FileUpload
    $("#fileUploadClick").click(function (e) {
        e.preventDefault();
        alert("fileUploadClick");

        //! Dosya Yükleme
        const fileInput = document.querySelector("#fileInput"); //! Input
        const fileInputFiles = fileInput.files; //! Yüklenen Dosya
        console.log("fileInputFiles:",fileInputFiles);
        console.log("fileInputFiles length:",fileInputFiles.length);

        if(fileInputFiles.length == 0) { alert("Dosya Seçilmedi"); }
        else { 

            alert("Dosya Seçildi");

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
                            
                            // $(".progress-bar").width(percentComplete + '%');
                            // $(".progress-bar").html(percentComplete+'%');
                        }
                    }, false);
                    return xhr;
                },
                url: "/api/file/upload/view/post",
                method: "post",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: formData,
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function () {
                    console.log("Dosya yükleme başladı");
                    
                    // $(".progress-bar").width('0%');
                    // $('#uploadStatus').html('<img src="../upload/images/loader.gif" style="width: 200px;" />');
                },
                error: function (error) {
                    alert("başarısız");
                    console.log("Hata oluştu error:", error);
                    
                    //$('#uploadStatus').html('<p style="color:#EA4335;">File upload failed, please try again.</p>');
                },
                success: function (resp) {
                    alert("Başarılı");
                    console.log("file resp:", resp);
                    
                    //! upload Durum
                    //$('#uploadStatus').css('display','none');
                }
            }); //! Ajax

        }

    });
    //! FileUpload Son

});