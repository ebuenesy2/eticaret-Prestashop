/***
 * Sabit List
 * Veri Ekleme
 * Veri Güncelleme
 * Veri Sil
 * Çoklu İşlemler
*/

//alert("userWish.js");
console.log("userWish.js");

//! Dil Alıyor
var yildirimdevMultiLangJson = JSON.parse(localStorage.getItem('yildirimdevMultiLang')); //! Çoklu Dil

//! Çoklu Dil Fonksiyon
function yildirimdevMultiLangJsonReturn () {
    if(yildirimdevMultiLangJson == null) { var yildirimdevMultiLangJson = JSON.parse(localStorage.getItem('yildirimdevMultiLang')); }
    return yildirimdevMultiLangJson;
}  //! Çoklu Dil Fonksiyon Son

//! Tanım
var listUrl = "/admin/web/user/wish"; //! List Adresi

//! Yüklenince Kapanıyor
$(document).ready(function () { $('#loader').hide(); });


//! ************ Resim *******************
//! Resim
document.querySelectorAll("#imgItem").forEach((deleteItem) => {  
    deleteItem.addEventListener("click", e => { 
      
        var data_uid = e.target.getAttribute("data_uid"); //! id
        var data_imgUrl = e.target.getAttribute("src"); //! Resim Url
        //console.log("data_imgUrl:", data_imgUrl);
 
        //! Gösterme
        $('#imgModalValueId').html(data_uid); //! Veriyi Gösterme
        $('#imgView').attr("src",data_imgUrl); //! Veriyi Gösterme
    
    })
}) //! Resim Son
//! ************ Resim Son  ***************

//! ************ Ekleme  ***************
//! Ekleme
$("#new_add").click(function (e) {
    e.preventDefault();

    var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
    //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);

    //! Loading - Veri Yükleniyor
    $('#loaderAdd').show(); //! Laoding Göster
    $('#addModal .modal-body input,textarea,select').attr('disabled','disabled'); //! İnputları Gizleme
    $('#addModal .modal-body button').attr('disabled','disabled'); //! Buttonları Gizleme
    $('#new_add').attr('disabled','disabled'); //! Button Gizleme
    document.getElementById("new_add").style.cursor = "wait"; //! Cursor - Dönen

    //! Loading - Veri Yüklendi
    function loadingYuklendi(){
        $('#loaderAdd').hide(); //! Laoding Gizle
        $('#addModal .modal-body input,textarea,select').removeAttr('disabled'); //! İnputları Aç
        $('#addModal .modal-body button').removeAttr('disabled'); //! Buttonları Aç
        $('#new_add').removeAttr('disabled'); //! //! Button Göster
        document.getElementById("new_add").style.cursor = "pointer"; //! Cursor - Ok
    }
    //! Loading - Veri Yüklendi Son

    //! Veriler
    var userAdd = $('#userAdd').val();

    if(userAdd == '') { 

        Swal.fire({
            position: "center",
            icon: "error",
            title: "Kullanıcı Yazılmadı",
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
                user_id: $('#userAdd').val(),
                product_uid: $('#productAdd').val(),
                product_quantity: $('#quantityAdd').val(),
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

}); //! Ekleme Son

//! Reset
$("#reset_add").click(function (e) {
    e.preventDefault();

    $('#addModal input,textarea,select').val('').prop("checked", ""); //! Inputları Sıfırlıyor
 
}); //! Reset Son

//! ************ Ekleme Son  ***************

//! ************ Silme ***************
//! Silme
document.querySelectorAll("#deleteItem").forEach((Item) => {
    Item.addEventListener("click", e => {

        var data_id = e.target.getAttribute("data_id"); //! Target ATTR
        console.log("data_id:", data_id);

        var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
        //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);

        //! Alert
        Swal.fire({
            title: yildirimdevMultiLangJsonReturnR.areYouSure+" #"+data_id,
            //text:  yildirimdevMultiLangJsonReturnR.deleteWarning,
            icon: 'error',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            cancelButtonText: yildirimdevMultiLangJsonReturnR.no,
            confirmButtonColor: '#3085d6',
            confirmButtonText: yildirimdevMultiLangJsonReturnR.yes,
        }).then((result) => {
            if (result.isConfirmed) {
                //alert("oldu");

                //! Ajax  Post
                $.ajax({
                    url: listUrl + "/delete/post",
                    type: "post",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: {
                        siteLang: yildirimdevMultiLangJsonReturnR.lang,
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
                    complete: function() {  console.log("Search Ajax Bitti"); }
                }); //! Ajax Post Son

            }
        });
        //! Alert Son

    })
}) //! Silme Son
//! ************ Silme Son  ***************

//! ************ Güncelle  *******************

//! Modal Kontrol
$("#editModal").modal({ keyboard: true, backdrop: "static",  show: false, })
.on("show.bs.modal", function(event){ var data_id = $('#editModalValueId').html();  $('#topMenuEdit option[value="'+data_id+'"]').css('display','none'); }) //! Modal Açıldı
.on("hide.bs.modal", function (event) { var data_id = $('#editModalValueId').html();  $('#topMenuEdit option[value="'+data_id+'"]').css('display','block');  }); //! Modal Kapandı

//! Güncelle Verileri Gösterme
document.querySelectorAll("#editItem").forEach((Item) => {
    Item.addEventListener("click", e => {

        var data_id = e.target.getAttribute("data_id"); //! id
        console.log("data_id:", data_id);

        var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
        //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);

        //! Gösterme
        $('#editModalValueId').html(data_id); //! Veriyi Gösterme

        //! Loading - Veri Yükleniyor
        $('#loaderEdit').show(); //! Laoding Göster
        $('#editModal .modal-body input').attr('disabled','disabled'); //! Gizleme
        $('#edit_item').attr('disabled','disabled'); //! Button Gizleme
        document.getElementById("edit_item").style.cursor = "wait"; //! Cursor - Dönen

        //! Ajax  Post
        $.ajax({
            url: listUrl + "/search/post",
            type: "post",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                siteLang: yildirimdevMultiLangJsonReturnR.lang,
                id:Number(data_id)
            },
            beforeSend: function() { console.log("Başlangıc"); },
            success: function (response) {
                // alert("başarılı");
                console.log("response:", response);
                // console.log("status:", response.status);

                if(response.status == "success") {

                    //! Veriler
                    $('#userEdit').val(response.DB.user_id);
                    $('#productEdit').val(response.DB.product_uid);
                    $('#quantityEdit').val(response.DB.product_quantity);

                    //! Loading - Veri Yüklendi
                    $('#loaderEdit').hide(); //! Laoding Gizle
                    $('#editModal .modal-body input').removeAttr('disabled'); //! İnputları Aç
                    $('#edit_item').removeAttr('disabled'); //! //! Button Göster
                    document.getElementById("edit_item").style.cursor = "pointer"; //! Cursor - Ok

                }
                else { toastr.error(yildirimdevMultiLangJsonReturnR.dataNotFound); }
            },
            error: function (error) { console.log("search error:", error); },
            complete: function() {  console.log("Search Ajax Bitti"); }
        }); //! Ajax Post Son

        console.log("edit item");

    })
}) //! Güncelle Verileri Gösterme Son

//! Güncelle
$("#edit_item").click(function (e) {
    e.preventDefault();

    var data_id = $('#editModalValueId').html(); //! id
    //console.log("data_id:", data_id);

    var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
    //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);

    //! Loading - Veri Yükleniyor
    $('#loaderEdit').show(); //! Laoding Göster
    $('#editModal .modal-body input,textarea,select').attr('disabled','disabled'); //! İnputları Gizleme
    $('#editModal .modal-body button').attr('disabled','disabled'); //! Buttonları Gizleme
    $('#edit_item').attr('disabled','disabled'); //! Button Gizleme
    document.getElementById("edit_item").style.cursor = "wait"; //! Cursor - Dönen

    //! Loading - Veri Yüklendi
    function loadingYuklendi(){
        $('#loaderEdit').hide(); //! Laoding Gizle
        $('#editModal .modal-body input,textarea,select').removeAttr('disabled'); //! İnputları Aç
        $('#editModal .modal-body button').removeAttr('disabled'); //! Buttonları Aç
        $('#edit_item').removeAttr('disabled'); //! //! Button Göster
        document.getElementById("edit_item").style.cursor = "pointer"; //! Cursor - Ok
    }
    //! Loading - Veri Yüklendi Son

    //! Veriler
    var userEdit = $('#userEdit').val();

    if(userEdit == '') { 

        Swal.fire({
            position: "center",
            icon: "error",
            title: "Kullanıcı Yazılmadı",
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
                id:Number(data_id),
                user_id: $('#userEdit').val(),
                product_uid: $('#productEdit').val(),
                product_quantity: $('#quantityEdit').val(),
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

//! ************ Çoklu İşlemler ***************


//! Çoklu Sil
function multiDelete () {

    //! Alert
    Swal.fire({
        title: yildirimdevMultiLangJson.areYouSure,
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
                url: listUrl + "/delete/post/multi",
                type: "post",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {
                    siteLang: yildirimdevMultiLangJson.lang,
                    ids: $('#showAllRows').attr('data_value').split(','),
                },              
                beforeSend: function() { console.log("Başlangıc"); },
                success: function (response) {
                    //alert("başarılı");
                    //console.log("response:", response);
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
                        window.location.reload();
                        
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
//! Çoklu Sil Son

//! Çoklu İşlem 
$("#multiAction").click(function (e) { 
    e.preventDefault();

    var multiActionStatus = $('#tableSettings').val(); //! delete / edit
    //console.log("multiActionStatus:",multiActionStatus);

    var yildirimdevMultiLangJson = yildirimdevMultiLangJsonReturn();
    //console.log("lang:",yildirimdevMultiLangJson.lang);

    //! Çoklu İşlemleri
    if(multiActionStatus == "delete") { multiDelete(); }  //! Çoklu Sil
    else if(multiActionStatus == "multi_createClone") { 
        //console.log("çoklu clone"); 

        //! Ajax  Post
        $.ajax({
            url: listUrl + "/clone/multi",
            type: "post",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                siteLang: yildirimdevMultiLangJson.lang,
                ids: $('#showAllRows').attr('data_value').split(','),
                created_byId: document.cookie.split(';').find((row) => row.startsWith(' yildirimdev_userID='))?.split('=')[1]
            },              
            //beforeSend: function() { console.log("Başlangıc"); },
            success: function (response) {
                //alert("başarılı");
                //console.log("response:", response);
                //console.log("status:", response.status);

                if (response.status == "success") {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: response.msg,
                        showConfirmButton: false,
                        timer: 2000,
                    });
    
                    //! Sayfa Yenileme
                    window.location.reload();
                    
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
    //! Çoklu İşlemleri Son

}); //! Çoklu İşlem Son

//! ************ Çoklu İşlemler Son ***************

//! ************ Clone ***************
//! Clone
document.querySelectorAll("#cloneItem").forEach((Item) => {  
    Item.addEventListener("click", e => {  

        var yildirimdevMultiLangJson = yildirimdevMultiLangJsonReturn();
        //console.log("lang:",yildirimdevMultiLangJson.lang);

        var data_id = e.target.getAttribute("data_id"); //! id
        console.log("data_id:", data_id);

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
                            window.location.reload();

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


//! ************ Keypress Algılama ***************
$("html").keydown(function(event) {
    //console.log("event:",event);
   if (event.keyCode == 46) {
       var showAllRows = $('#showAllRows').attr('data_value').split(',');
       var showAllRowsControl = false;

       if(showAllRows.length > 1) { showAllRowsControl = true; }
       else if(showAllRows.length == 1 && showAllRows[0]!= '' ) { showAllRowsControl = true; }

       if(showAllRowsControl) { multiDelete(); } //! Toplu Silme
      
    }
});
//! ************ Keypress Algılama Son ***************

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