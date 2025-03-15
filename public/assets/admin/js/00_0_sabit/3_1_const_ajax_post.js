$(function () {

    alert("ajax - post js Kullanımı");
    console.log("ajax - post js çalışıyor");

    var siteLang = $('html').attr('lang').trim(); //! Site Dili
    var yildirimdevMultiLangJson = JSON.parse(localStorage.getItem('yildirimdevMultiLang')); //! Çoklu Dil

    //console.log("dil:",siteLang); //! Site Dili
    //console.log("yildirimdevMultiLangJson:",yildirimdevMultiLangJson); //! Çoklu Dil
    //console.log("yildirimdevMultiLangJson - TransactionSuccessful:",yildirimdevMultiLangJson.transactionSuccessful.trim()); //! Çoklu Dil - TransactionSuccessful
                   
    //! Ajax  Post
    $.ajax({
        url: "/ajax/example/post",
        method: "post",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            siteLang: $('html').attr('lang').trim(),
            name: "enes",
            surname:"yildirim"
        },
        xhr: function () {
            var xhr = new window.XMLHttpRequest();
            
            alert("xhr");
            console.log("xhr:",xhr);
            
            // xhr.upload.addEventListener("progress", function (evt) {
            //   if (evt.lengthComputable) {
            //     var percentComplete = ((evt.loaded / evt.total) * 100);
                
            //       console.log("progress:",percentComplete + '%');

            //   }
            // }, false);

            return xhr;
        },
        beforeSend: function() {
        
            alert("Başlangıc");
            console.log("Başlangıc");

        },
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

                //! Sayfa Yenileme
                //window.location.reload();
            } else {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: yildirimdevMultiLangJson.transactionFailed.trim(),
                    showConfirmButton: false,
                    timer: 2000,
                });
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
        complete: function() {

            alert("Bitti");
            console.log("Bitti");

        }
    }); //! Ajax Post Son

});
