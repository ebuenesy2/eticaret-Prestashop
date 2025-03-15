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
var listUrl_wish = "/user/wishlist"; //! List Adresi


//! ************ İstek Listesine Ürün Ekle ***************
//! İstek Listesine Ürün Ekle
document.querySelectorAll("#userWishAdd").forEach((Item) => {
    Item.addEventListener("click", e => {

        var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
        //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);
        
        //! Kullanıcı
        var userid = document.cookie.split(';').find((row) => row.startsWith('web_userId='))?.split('=')[1];
        var userid = userid ? userid : document.cookie.split(';').find((row) => row.startsWith(' web_userId='))?.split('=')[1];
        //console.log("userid:",userid);    

        //! Ürün
        var data_productid = e.target.getAttribute("data_productid"); //! Urun
        //console.log("data_productid:", data_productid);

        var data_product_quantity = e.target.getAttribute("data_product_quantity"); //! Urun Sayısı
        //console.log("data_product_quantity:", data_product_quantity);
        //! Ürün Son

        if(userid == '' || !userid ) { 

            Swal.fire({
                position: "center",
                icon: "error",
                title: "Kullanici Giriş Yapınız",
                showConfirmButton: false,
                timer: 2000,
            });

        }
        else if(data_productid == '') { 

            Swal.fire({
                position: "center",
                icon: "error",
                title: "Ürün Seçilmedi",
                showConfirmButton: false,
                timer: 2000,
            });
        }
        else {

            //! Ajax  Post
            $.ajax({
                url: listUrl_wish + "/add/post",
                type: "post",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {
                    siteLang: yildirimdevMultiLangJsonReturnR.lang,
                    user_id: userid,
                    product_uid: data_productid,
                    product_quantity: data_product_quantity,
                    created_byId: document.cookie.split(';').find((row) => row.startsWith(' web_userId='))?.split('=')[1]
                },
                beforeSend: function() { console.log("İstek Listesine Ekle -  Başlangıc"); },
                success: function (response) {
                    // alert("başarılı");
                    // console.log("response:", response);
                    // console.log("status:", response.status);

                    if (response.status == "success") {
                        // Swal.fire({
                        //     position: "center",
                        //     icon: "success",
                        //     title: yildirimdevMultiLangJsonReturnR.transactionSuccessful,
                        //     showConfirmButton: false,
                        //     timer: 2000,
                        // });

                        //! Buton Güncelleme
                        document.querySelectorAll('[id="userWishAdd"][data_productid="'+data_productid+'"]').forEach(function(el) { el.style.display="none" }) 
                        document.querySelectorAll('[id="userWishAdd_None"][data_productid="'+data_productid+'"]').forEach(function(el) { el.style.display="flex" })

                        //! İstek Listesi  Sayısı
                        var wishlist_count = $('.wishlist-count').html(); //! Sayısını Alıyor
                        var wishlist_count = Number(wishlist_count) + 1; //! Sayısını Artılıyor
                        $('.wishlist-count').html(wishlist_count); //! Sayısını Gösteriyor

                        //! Sayfa Yenileme
                        //window.location.reload();
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

    })
}) //! İstek Listesine Ürün Ekle Son
//! ************ İstek Listesine Ürün Ekle Son  ***************

//! ************ İstek Listesinden Ürün Silme ***************
//! İstek Listesinden Ürün Silme
document.querySelectorAll("#userWishDelete").forEach((Item) => {
    Item.addEventListener("click", e => {
       
        var data_id = e.target.getAttribute("data_id"); //! Target - id
        console.log("data_id:", data_id);

        var data_productstitle = e.target.getAttribute("data_productstitle"); //! Target 
        //console.log("data_productstitle:", data_productstitle);

        var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
        //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);
      
        //! Alert
        Swal.fire({
            title: yildirimdevMultiLangJsonReturnR.deleteWarning + " " +yildirimdevMultiLangJsonReturnR.areYouSure+" #"+data_id + "[ " + data_productstitle +"]",
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
                    url: listUrl_wish + "/delete/post",
                    type: "post",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: {
                        siteLang: yildirimdevMultiLangJsonReturnR.lang,
                        id:Number(data_id),
                        //created_byId: document.cookie.split(';').find((row) => row.startsWith(' yildirimdev_userID='))?.split('=')[1],
                    },              
                    beforeSend: function() { console.log("İstek Listesinden Sil -  Başlangıc"); },
                    success: function (response) {
                        //alert("başarılı");
                        // console.log("response:", response);
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
}) //! İstek Listesinden Ürün Silme Son
//! ************ İstek Listesinden Ürün Silme Son  ***************
