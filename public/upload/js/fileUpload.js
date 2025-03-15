$(function () {

    //alert("FileUpload çalışıyor");
    console.log("fileupload çalışıyor");

    //! FileUpload
    $("#fileUploadClick").click(function (e) {
        e.preventDefault();
        alert("fileUploadClick");

        //! Dosya Yükleme
        const fileInput = document.querySelector("#fileInput");
        const fileInputFiles = fileInput.files;
        console.log("fileInputFiles:",fileInputFiles);
     

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
            method: "post",
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


                // //! Alert
                // Swal.fire({
                //     position: "center",
                //     icon: "error",
                //     title: $('[id=lang_change][data_key=TransactionFailed]').html().trim(),
                //     showConfirmButton: false,
                //     timer: 2000,
                // });  //! Alert Son

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


                // //! Alert
                // Swal.fire({
                //     position: "center",
                //     icon: "success",
                //     title: $('[id=lang_change][data_key=TransactionSuccessful]').html().trim(),
                //     showConfirmButton: false,
                //     timer: 2000,
                // });  //! Alert Son

            }
        }); //! Ajax



    });
    //! FileUpload Son

});