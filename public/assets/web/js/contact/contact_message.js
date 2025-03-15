/**
 * Veri ekle
 * Veri sil
 * Veri güncelle
 */


//alert("contact_message");
console.log("web - contact_message çalışıyor");

//! Dil Alıyor
var yildirimdevMultiLangJson = JSON.parse(localStorage.getItem('yildirimdevMultiLang')); //! Çoklu Dil

//! Çoklu Dil Fonksiyon
function yildirimdevMultiLangJsonReturn () {
    if(yildirimdevMultiLangJson == null) { var yildirimdevMultiLangJson = JSON.parse(localStorage.getItem('yildirimdevMultiLang')); }
    return yildirimdevMultiLangJson;
}  //! Çoklu Dil Fonksiyon Son

//! Tanım
var listUrl = "/contact/message"; //! List Adresi

//! ************ Yorum Yap  ***************
$("#contact_message_new").click(function (e) {
    e.preventDefault(); 
    //alert("contact_message_new");

    //! Dil
    var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
    //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);

    //! Veriler
    var nameAdd = $('#nameAdd').val();
    var messageAdd = $('#messageAdd').val();

    if(nameAdd == '') { 

        Swal.fire({
            position: "center",
            icon: "error",
            title: "Adı Yazılmadı",
            showConfirmButton: false,
            timer: 2000,
        });
    }
    else if(messageAdd == '') { 

        Swal.fire({
            position: "center",
            icon: "error",
            title: "Mesaj Yazılmadı",
            showConfirmButton: false,
            timer: 2000,
        });

    }
    else {

        //! Ajax  Post
        $.ajax({
            url: listUrl + "/add/post",
            type: "post",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                siteLang: yildirimdevMultiLangJsonReturnR.lang,
                name: $('#nameAdd').val(),
                surname: $('#surnameAdd').val(),
                email: $('#emailAdd').val(),
                phone: $('#phoneAdd').val(),
                subject: $('#subjectAdd').val(),
                message: $('#messageAdd').val(),
                created_byId: document.cookie.split(';').find((row) => row.startsWith(' web_userId='))?.split('=')[1]
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
            complete: function() {  }
        }); //! Ajax Post Son

    }
  

}); 
//! ************ Yorum Yap Son  ***************