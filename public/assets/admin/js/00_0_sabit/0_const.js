alert("admin sabit");
console.log("web - js çalışıyor");

//! Dil Alıyor
var yildirimdevMultiLangJson = JSON.parse(localStorage.getItem('yildirimdevMultiLang')); //! Çoklu Dil

//! Çoklu Dil Fonksiyon
function yildirimdevMultiLangJsonReturn () {
    if(yildirimdevMultiLangJson == null) { var yildirimdevMultiLangJson = JSON.parse(localStorage.getItem('yildirimdevMultiLang')); }
    return yildirimdevMultiLangJson;
}  //! Çoklu Dil Fonksiyon Son

//! ************ Test Lang  ***************
$("#langClick").click(function (e) {
    e.preventDefault();

    alert("langClick Tıklandı");

    var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
    console.log("yildirimdevMultiLangJsonReturnR:",yildirimdevMultiLangJsonReturnR);
    
    console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);

    //! Alert
    //toastr.success("Başarılı"); //! Başarılı

    //! Swal
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'İşleminiz Başarılı',
        showConfirmButton: false,
        timer: 2000
    })

}); 
//! ************ Test Lang Son  ***************


// //! ************ Ekleme  ***************
// //! Ekleme
// $("#new_add").click(function (e) {
//     e.preventDefault();

//     alert("new_add");

// }); //! Ekleme Son
// //! ************ Ekleme Son  ***************