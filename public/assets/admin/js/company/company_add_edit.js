/***
 * Sabit List
 * Veri Ekleme
 * Veri Güncelleme
 * Clone
*/

console.log("company_add_edit.js");

//! Dil Alıyor
var yildirimdevMultiLangJson = JSON.parse(localStorage.getItem('yildirimdevMultiLang')); //! Çoklu Dil

//! Çoklu Dil Fonksiyon
function yildirimdevMultiLangJsonReturn () {
    if(yildirimdevMultiLangJson == null) { var yildirimdevMultiLangJson = JSON.parse(localStorage.getItem('yildirimdevMultiLang')); }
    return yildirimdevMultiLangJson;
}  //! Çoklu Dil Fonksiyon Son

//! Tanım
var listUrl = "/admin/company"; //! Adres 

//! Yüklenince Kapanıyor
$(document).ready(function () { $('#loader').hide(); });

//! ************ Ekleme  ***************
//! Ekleme
$("#new_add").click(function (e) {
    e.preventDefault();

    var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
    //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);

    //! Loading - Veri Yükleniyor
    $('#loader').show(); //! Laoding Göster
    $('body input,textarea,select').attr('disabled','disabled'); //! İnputları Gizleme
    $('body button').attr('disabled','disabled'); //! Buttonları Gizleme
    $('#new_add').attr('disabled','disabled'); //! Button Gizleme
    document.getElementById("new_add").style.cursor = "wait"; //! Cursor - Dönen

    //! Loading - Veri Yüklendi
    function loadingYuklendi(){
        $('#loader').hide(); //! Laoding Gizle
        $('body input,textarea,select').removeAttr('disabled'); //! İnputları Aç
        $('body button').removeAttr('disabled'); //! Buttonları Aç
        $('#new_add').removeAttr('disabled'); //! //! Button Göster
        document.getElementById("new_add").style.cursor = "pointer"; //! Cursor - Ok
    }
    //! Loading - Veri Yüklendi Son
    
    //! Veriler
    var companyNameAdd = $('#companyNameAdd').val();
    if(companyNameAdd == '') { 
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Firma Adı Yazılmadı",
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

                category:Number($('#companyCategoryAdd').val()),
                company_name: $('#companyNameAdd').val(),
                description: $('#descriptionAdd').val(),

                authorized_person: $('#authorizedPersonAdd').val(),
                authorized_person_role: $('#authorizedPersonRoleAdd').val(),
                authorized_person_tel: $('#authorizedPhoneAdd').val(),
                authorized_person_mail: $('#authorizedPersonMailAdd').val(),

                web_address1: $('#webAddressAdd').val(),
                web_address2: $('#webAddressTwoAdd').val(),

                tel1: $('#phoneAdd').val(),
                tel2: $('#phoneTwoAdd').val(),
                email: $('#emailAdd').val(),
                email2: $('#emailTwoAdd').val(),

                country: $('#countryAdd').val(),
                city: $('#cityAdd').val(),
                district: $('#districtAdd').val(),
                neighborhood: $('#neighborhoodAdd').val(),
                address: $('#addressAdd').val(),
            
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
//! ************ Ekleme Son  ***************

//! ************ Güncelle  ***************
//! Güncelle
$("#edit_item").click(function (e) {
    e.preventDefault();

    var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
    //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);

    var data_id = $('#dataValueInfo').attr('data_id'); //! Id
    console.log("data_id:", data_id);

    //! Loading - Veri Yükleniyor
    $('#loader').show(); //! Laoding Göster
    $('body input,textarea,select').attr('disabled','disabled'); //! İnputları Gizleme
    $('body button').attr('disabled','disabled'); //! Buttonları Gizleme
    $('#edit_item').attr('disabled','disabled'); //! Button Gizleme
    document.getElementById("edit_item").style.cursor = "wait"; //! Cursor - Dönen

    //! Loading - Veri Yüklendi
    function loadingYuklendi(){
        $('#loader').hide(); //! Laoding Gizle
        $('body input,textarea,select').removeAttr('disabled'); //! İnputları Aç
        $('body button').removeAttr('disabled'); //! Buttonları Aç
        $('#edit_item').removeAttr('disabled'); //! //! Button Göster
        document.getElementById("edit_item").style.cursor = "pointer"; //! Cursor - Ok
    }
    //! Loading - Veri Yüklendi Son
    
    //! Veriler
    var companyNameAdd = $('#companyNameEdit').val();
    if(companyNameAdd == '') { 
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Firma Adı Yazılmadı",
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
            
            category:Number($('#companyCategoryEdit').val()),
            company_name: $('#companyNameEdit').val(),
            description: $('#descriptionEdit').val(),

            authorized_person: $('#authorizedPersonEdit').val(),
            authorized_person_role: $('#authorizedPersonRoleEdit').val(),
            authorized_person_tel: $('#authorizedPhoneEdit').val(),
            authorized_person_mail: $('#authorizedPersonMailEdit').val(),

            web_address1: $('#webAddressEdit').val(),
            web_address2: $('#webAddressTwoEdit').val(),

            tel1: $('#phoneEdit').val(),
            tel2: $('#phoneTwoEdit').val(),
            email: $('#emailEdit').val(),
            email2: $('#emailTwoEdit').val(),

            country: $('#countryEdit').val(),
            city: $('#cityEdit').val(),
            district: $('#districtEdit').val(),
            neighborhood: $('#neighborhoodEdit').val(),
            address: $('#addressEdit').val(),

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
//! ************ Güncelle Son *************

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
                        window.location.href = "/"+yildirimdevMultiLangJson.lang+listUrl;
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
                            window.location.href = "/"+yildirimdevMultiLangJson.lang+listUrl+"/edit/"+response.addNewId;
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

//! ************ Tuş Algılama ***************
$("html").keydown(function(event) {
    //console.log("event:",event);
    var data_action = $('#dataValueInfo').attr('data_action'); //! add - edit
    if (event.keyCode == 46 && data_action == 'edit') {
        var data_id = $('#dataValueId').attr('data_id');
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
    else if (event.keyCode == 13 && eventTarget_focusControl == "add" && focusControl_Active == "true") { $('#new_add').focus(); } //! Ekle
    else if (event.keyCode == 13 && eventTarget_focusControl == "edit" && focusControl_Active == "true") { $('#edit_item').focus(); } //! Güncelle
    
});
//! ************ Enter Focus Son ***************