/***
 * Sabit List
 * Veri Ekleme
 * Veri Güncelleme
 * Veri Sil
 * Çoklu İşlemler
*/

//alert("user.js");
console.log("user.js");

//! Dil Alıyor
var yildirimdevMultiLangJson = JSON.parse(localStorage.getItem('yildirimdevMultiLang')); //! Çoklu Dil

//! Çoklu Dil Fonksiyon
function yildirimdevMultiLangJsonReturn () {
    if(yildirimdevMultiLangJson == null) { var yildirimdevMultiLangJson = JSON.parse(localStorage.getItem('yildirimdevMultiLang')); }
    return yildirimdevMultiLangJson;
}  //! Çoklu Dil Fonksiyon Son

//! Tanım
var listUrl = "/user"; //! List Adresi

//! ************ Kayıt ***************
//! Kayıt
$("#register").click(function (e) {
    e.preventDefault();

    var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
    //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);

    //! Loading - Veri Yükleniyor
    $('#loader').show(); //! Laoding Göster
    $('input,textarea,select').attr('disabled','disabled'); //! İnputları Gizleme
    $('#register').attr('disabled','disabled'); //! Button Gizleme
    document.getElementById("register").style.cursor = "wait"; //! Cursor - Dönen

    //! Loading - Veri Yüklendi
    function loadingYuklendi(){
        $('#loader').hide(); //! Laoding Gizle
        $('input,textarea,select').removeAttr('disabled'); //! İnputları Aç
        $('#register').removeAttr('disabled'); //! //! Button Göster
        document.getElementById("register").style.cursor = "pointer"; //! Cursor - Ok
    }
    //! Loading - Veri Yüklendi Son

    //! Veriler
    var name = $('#name').val();
    var email = $('#emailRegister').val();
    var password = $('#passwordRegister').val();
    var confirmPassword = $('#confirmPasswordRegister').val();

    if(name == '') { 

        Swal.fire({
            position: "center",
            icon: "error",
            title: "Adı Yazılmadı",
            showConfirmButton: false,
            timer: 2000,
        });

        loadingYuklendi(); //! Fonksiyon Çalıştır
    }
    else if(email == '') { 

        Swal.fire({
            position: "center",
            icon: "error",
            title: "Email Yazılmadı",
            showConfirmButton: false,
            timer: 2000,
        });

        loadingYuklendi(); //! Fonksiyon Çalıştır
    }
    else  if(password == '' || confirmPassword == '') { 

        Swal.fire({
            position: "center",
            icon: "error",
            title: "Şifre Yazılmadı",
            showConfirmButton: false,
            timer: 2000,
        });

        loadingYuklendi(); //! Fonksiyon Çalıştır
    }
    else if(password != confirmPassword) { 

        Swal.fire({
            position: "center",
            icon: "error",
            title: "Şifreler Aynı Değil",
            showConfirmButton: false,
            timer: 2000,
        });

        loadingYuklendi(); //! Fonksiyon Çalıştır
    }
    else {

        //! Ajax  Post
        $.ajax({
            url: listUrl + "/register/post",
            type: "post",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                siteLang: yildirimdevMultiLangJsonReturnR.lang,
                name: $('#name').val(),
                surname: $('#surname').val(),
                phone: $('#phone').val(),
                email: $('#emailRegister').val(),
                password: $('#passwordRegister').val(),

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

                    //! Sayfa Yönlendirme
                    window.location.href = "/"+yildirimdevMultiLangJsonReturnR.lang+"/user/login"

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

}); //! Kayıt Son
//! ************ Kayıt Son  ***************


//! ************ login ***************
//! login
$("#login").click(function (e) {
    e.preventDefault();
    //alert("login");

    var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
    //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);

    //! Loading - Veri Yükleniyor
    $('#loader').show(); //! Laoding Göster
    $('input,textarea,select').attr('disabled','disabled'); //! İnputları Gizleme
    $('#login').attr('disabled','disabled'); //! Button Gizleme
    document.getElementById("login").style.cursor = "wait"; //! Cursor - Dönen

    //! Loading - Veri Yüklendi
    function loadingYuklendi(){
        $('#loader').hide(); //! Laoding Gizle
        $('input,textarea,select').removeAttr('disabled'); //! İnputları Aç
        $('#login').removeAttr('disabled'); //! //! Button Göster
        document.getElementById("login").style.cursor = "pointer"; //! Cursor - Ok
    }
    //! Loading - Veri Yüklendi Son

    //! Veriler
    var email = $('#email').val();
    var password = $('#password').val();

    if(email == '') { 

        Swal.fire({
            position: "center",
            icon: "error",
            title: "Email Yazılmadı",
            showConfirmButton: false,
            timer: 2000,
        });

        loadingYuklendi(); //! Fonksiyon Çalıştır
    }
    else if(password == '' ) { 

        Swal.fire({
            position: "center",
            icon: "error",
            title: "Şifre Yazılmadı",
            showConfirmButton: false,
            timer: 2000,
        });

        loadingYuklendi(); //! Fonksiyon Çalıştır
    }
    else {

        //! Ajax  Post
        $.ajax({
            url: listUrl + "/login/post",
            type: "post",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                siteLang: yildirimdevMultiLangJsonReturnR.lang,
                email: $('#email').val(),
                password: $('#password').val(),
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

                    //! Çerez
                    document.cookie="web_userId="+response.userId+";path=/";
                    document.cookie="web_roleId="+response.roleId+";path=/"; 

                    //! Sayfa Yönlendirme
                    window.location.href = response.url;

                } else {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: yildirimdevMultiLangJsonReturnR.theEmailPasswordMayBeIncorrect,
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

}); //! login Son
//! ************ login Son  ***************


//! ************ Profil Düzenleme ***************
$("#profileEdit").click(function (e) {
    e.preventDefault();
    //alert("Profil Düzenleme");

    var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
    //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);
    
    //! Loading - Veri Yükleniyor
    $('#loader').show(); //! Laoding Göster
    $('input,textarea,select').attr('disabled','disabled'); //! İnputları Gizleme
    $('#profileEdit').attr('disabled','disabled'); //! Button Gizleme
    document.getElementById("profileEdit").style.cursor = "wait"; //! Cursor - Dönen

    //! Loading - Veri Yüklendi
    function loadingYuklendi(){
        $('#loader').hide(); //! Laoding Gizle
        $('input,textarea,select').removeAttr('disabled'); //! İnputları Aç
        $('#profileEdit').removeAttr('disabled'); //! //! Button Göster
        document.getElementById("profileEdit").style.cursor = "pointer"; //! Cursor - Ok
    }
    //! Loading - Veri Yüklendi Son

    //! Veriler
    var name = $('#name').val();

    if(name == '') { 

        Swal.fire({
            position: "center",
            icon: "error",
            title: "Adı Yazılmadı",
            showConfirmButton: false,
            timer: 2000,
        });

        loadingYuklendi(); //! Fonksiyon Çalıştır
    }
    else {

        //! Ajax  Post
        $.ajax({
            url: listUrl + "/profile/edit",
            type: "post",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                siteLang: yildirimdevMultiLangJsonReturnR.lang,
                id: Number($('#userInfo').attr('userId')), 
                
                name: $('#name').val(),
                surname: $('#surname').val(),
                phone: $('#phone').val(),
             
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

}); 
//! ************ Profil Düzenleme Son  ***************

//! ************ Şifre Değiştirme ***************
//! Şifre Değiştirme
$("#profilePasswordSave").click(function (e) {
    e.preventDefault();
    //alert("profilePasswordSave");

    var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
    //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);

    //! Loading - Veri Yükleniyor
    $('#loader').show(); //! Laoding Göster
    $('input,textarea,select').attr('disabled','disabled'); //! İnputları Gizleme
    $('#profilePasswordSave').attr('disabled','disabled'); //! Button Gizleme
    document.getElementById("profilePasswordSave").style.cursor = "wait"; //! Cursor - Dönen

    //! Loading - Veri Yüklendi
    function loadingYuklendi(){
        $('#loader').hide(); //! Laoding Gizle
        $('input,textarea,select').removeAttr('disabled'); //! İnputları Aç
        $('#profilePasswordSave').removeAttr('disabled'); //! //! Button Göster
        document.getElementById("profilePasswordSave").style.cursor = "pointer"; //! Cursor - Ok
    }
    //! Loading - Veri Yüklendi Son

    //! Veriler
    var oldPassword = $('#oldPassword').val();
    var newPassword = $('#newPassword').val();
    var repeatPassword = $('#repeatPassword').val();

    if(oldPassword == '') { 

        Swal.fire({
            position: "center",
            icon: "error",
            title: "Eski Şifre Yazılmadı",
            showConfirmButton: false,
            timer: 2000,
        });

        loadingYuklendi(); //! Fonksiyon Çalıştır
    }
    else if(newPassword == '') { 

        Swal.fire({
            position: "center",
            icon: "error",
            title: "Yeni Şifre Yazılmadı",
            showConfirmButton: false,
            timer: 2000,
        });

        loadingYuklendi(); //! Fonksiyon Çalıştır
    }
    else if(newPassword != repeatPassword) { 

        Swal.fire({
            position: "center",
            icon: "error",
            title: "Şifre Uyuşmuyor",
            showConfirmButton: false,
            timer: 2000,
        });

        loadingYuklendi(); //! Fonksiyon Çalıştır
    }
    else {

        //! Ajax  Post
        $.ajax({
            url: listUrl + "/settings/password/edit",
            type: "post",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                siteLang: yildirimdevMultiLangJsonReturnR.lang,
                id: Number($('#userInfo').attr('userId')), 
                oldPassword: $('#oldPassword').val(),
                password: $('#newPassword').val(),
               
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

}); //! Şifre Değiştirme Son
//! ************ Şifre Değiştirme Son  ***************