$(function () {

    //alert("FileUpload çalışıyor");
    console.log("fileupload Multi çalışıyor");    
                    
   //! Dosya Yükleme Main Product
   $("#uploadForm_Multi").on('submit', function (e) {
        e.preventDefault();

        //alert("tiklama uploadForm_Multi");
        
        //! Form Data verileri
        var formData = new FormData(this);

        $.ajax({
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        console.log("Dosya Yükleme Durumu: %", percentComplete);

                        $("#progressBarMulti").width(percentComplete + '%');
                        $("#progressBarMulti").html(percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            url: "/file/upload/multi/control",
            method: "post",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                console.log("Çoklu Dosya yükleme başladı");

                //! ProgressBar
                $("#progressBarFileUpload").width('0%');
                
                //! Upload Durum
                $('#LoadingFileUpload').toggle();
                $('#uploadStatus').hide();

                //! Upload Url
                $('#filePathUrl').html("");
            },
            error: function (error) {
                //alert("başarısız");
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

                //alert("sonuc");
                console.log("resp:", resp);
                
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
     
    });  //! Dosya Yükleme Main Product Son

    
   
});