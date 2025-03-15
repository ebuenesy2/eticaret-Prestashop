$(function () {

    //alert("import_list.js");
    console.log("import_list.js");

    var siteLang = $('html').attr('lang').trim(); //! Site Dili
    var yildirimdevMultiLangJson = JSON.parse(localStorage.getItem('yildirimdevMultiLang')); //! Çoklu Dil

    //! Modal Import
    $("#importModalButton").click(function(e) {
        var filePathUrl = $('#filePathUrl').html();
        if(filePathUrl==""){
            $('#new_import').attr('disabled','disabled'); //! Button Gizleme
            document.getElementById("new_import").style.cursor = "wait"; //! Cursor - Dönen
        }
        else {
            document.getElementById("new_import").style.cursor = "pointer"; //! Cursor - Ok
            $('#new_import').removeAttr('disabled'); //! Buttonları Aç
        }
    });
     //! Modal Import Son

    //! FileUpload
    $("#fileUploadClick").click(function (e) {
        e.preventDefault();
        //alert("fileUpload Import");

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
            url: "/import/file/upload/control",
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

                //! Loading Durum
                $('#LoadingFileUpload').toggle();
                $('#uploadStatus').hide();

                //! Upload Url
                $('#fileExt').html("");
                $('#filePathUrl').html("");
            },
            error: function (error) {
                alert("başarısız");
                console.log("Hata oluştu error:", error);

                //! Loading Durum
                $('#LoadingFileUpload').hide();
                $('#uploadStatus').html('<p style="color:#EA4335;">File upload failed, please try again.</p>');

                //! Upload Url
                $('#fileExt').html("");
                $('#filePathUrl').html("");

            },
           success: function (resp) {
               //alert("Başarılı");
               console.log("file resp:", resp);

                //! ProgressBar
                $("#progressBarFileUpload").width('100%');

                //! Loading Durum
                $('#LoadingFileUpload').hide();
                $('#uploadStatus').hide();

                //! Upload Url
                $('#fileExt').html(resp.file_ext);
                $('#filePathUrl').html(resp.file_url);

                //! Dosya Türü
                //console.log("file_ext:",resp.file_ext);

                //! Css
                let nodeDisplay = document.querySelectorAll("[id=import_choose]");
                for (let i = 0; i < nodeDisplay.length; i++) {  
                    nodeDisplay[i].style.border=''; 
                    nodeDisplay[i].style.padding = '0px';
                };


                //! Seçim Radio
                $("input[name='importRadio'][value='"+resp.file_ext+"']").prop('checked', true);
                
                //! Seçim Css
                document.querySelector("[id='import_choose'][data_import='"+resp.file_ext+"']").style.border='1px solid red';
                document.querySelector("[id='import_choose'][data_import='"+resp.file_ext+"']").style.padding = '3px';

                //! Button
                document.getElementById("new_import").style.cursor = "pointer"; //! Cursor - Ok
                $('#new_import').removeAttr('disabled'); //! Buttonları Aç

            }
        }); //! Ajax

    });
    //! FileUpload Son

    //! Reset - İmport
    function resetImport(){

        //! Sıfırla
        $('#fileExt').html("");
        $('#filePathUrl').html("");

        $("input[name='importRadio'][value='import_choose']").prop('checked', true); //! Check 
        $("#progressBarFileUpload").css('display','none'); //! ProgresBar Gizle
        $("#fileInput").val(""); //! File Upload Sıfırla

        //! Button
        $('#new_import').attr('disabled','disabled'); //! Button Gizleme
        document.getElementById("new_import").style.cursor = "wait"; //! Cursor - Dönen

        $("#progressImport").css('display','none'); //! ProgresBar Gizle
            
    }

    $("#reset_import").click(function (e) { e.preventDefault();  resetImport(); });
    //! Reset - İmport - Son

    //! Import
    $("#new_import").click(function (e) {
        e.preventDefault();
        //alert("new_import");

        //! Tanım
        var fileExt = $('#fileExt').html();
        var filePathUrl = $('#filePathUrl').html();

        //! Button
        $('#new_import').attr('disabled','disabled'); //! Button Gizleme
        document.getElementById("new_import").style.cursor = "wait"; //! Cursor - Dönen

        if(filePathUrl == "") { 
            
            Swal.fire({
                position: "center",
                icon: "error",
                title: yildirimdevMultiLangJson.fileNotFound.trim(),
                showConfirmButton: false,
                timer: 2000,
            });
            console.log("error:", error);

            //! Button
            document.getElementById("new_import").style.cursor = "pointer"; //! Cursor - Ok
            $('#new_import').removeAttr('disabled'); //! Buttonları Aç

        }
        else {

            //! Ajax  Post
            $.ajax({
                url: "/admin/fixed_list/import",
                method: "post",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {
                    siteLang: $('html').attr('lang').trim(),
                    file_ext: fileExt,
                    file_url: filePathUrl
                },
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();
                    
                    //alert("xhr");
                    //console.log("xhr:",xhr);

                    //! Loading Durum
                    $('#LoadingImport').css('display','flex');
                    $('#LoadingImportStatus').hide();
                        
                    xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        
                        console.log("progress:",percentComplete + '%');

                        $("#progressImport").width(percentComplete + '%');
                        $("#progressImport").html(percentComplete+'%');
                    }
                    }, false);

                    return xhr;
                },
                beforeSend: function () { $("#progressImport").width('0%'); },
                success: function (response) {
                    // alert("başarılı");
                    console.log("response:", response);
                    // console.log("status:", response.status);

                    if (response.status == "success") {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: yildirimdevMultiLangJson.transactionSuccessful.trim(),
                            showConfirmButton: false,
                            timer: 2000,
                        });

                        //! Loading Durum
                        $('#LoadingImport').css('display','none');

                        //! Sayfa Yenileme
                        window.location.reload();
                        
                    } else {
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            title: yildirimdevMultiLangJson.transactionFailed.trim(),
                            showConfirmButton: false,
                            timer: 2000,
                        });

                        //! Loading Durum
                        $('#LoadingImport').css('display','none');
                        $('#LoadingImportStatus').html('<p style="color:#EA4335;"> Hata oluştu</p>');
                    }
                },
                error: function (error) {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: yildirimdevMultiLangJson.transactionFailed.trim(),
                        showConfirmButton: false,
                        timer: 2000,
                    });
                    console.log("error:", error);
                },
                complete: function() { console.log("İmport Bitti"); }
            }); //! Ajax Post Son

        }

    });
    //! Import Son

});