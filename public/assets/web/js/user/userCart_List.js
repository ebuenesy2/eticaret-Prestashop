

//! ************ Sepete Ürün Fiyat Güncelleme ***************
//! Değişiklik Olduğunda
document.querySelectorAll('#cart-product-quantity').forEach((Item) => {
  Item.addEventListener("change", e => {

      //! Sepet Ürün Id
      var data_id = e.target.getAttribute("data_id"); 
      //console.log("data_id:", data_id);
  
      //! Sepet Ürün Fiyatı
      var data_productsPrice = e.target.getAttribute("data_productsPrice"); 
      //console.log("data_productsPrice:", data_productsPrice);

      //! Sepet Ürün Fiyat Birimi
      var data_productsCurrency = e.target.getAttribute("data_productsCurrency");  //! TL
      //console.log("data_productsCurrency:", data_productsCurrency);

      //! Sayısı
      var data_count = e.target.value;  //! Sayısı
      //console.log("data_count:", data_count);

      //! Toplam Fiyat
      var data_sum_price = Number(data_productsPrice)* data_count;
      data_sum_price = data_sum_price.toFixed(2);
      //console.log("data_sum_price:", data_sum_price);

      //! Sonuç
      document.querySelector('[class="total-col"][data_id="'+data_id+'"]').innerHTML = data_sum_price+" "+data_productsCurrency;  //! Toplam Urun Güncelle
      document.querySelector('[class="total-col"][data_id="'+data_id+'"]').setAttribute("data_productstotalprice",data_sum_price); //! Toplam Güncelle

      //! Toplam Fiyat Hesaplama
      var totalProductPrice = 0;
      document.querySelectorAll('[class="total-col"]').forEach((Item) => {
          var data_sum_price = Item.getAttribute("data_productstotalprice");
          totalProductPrice = totalProductPrice + Number(data_sum_price);
      });

      //! Gösterme
      $("#productTotalPrice").html(totalProductPrice+" " +data_productsCurrency); //! Sepet Fiyat
      $('#productTotalPrice').attr('productsAllTotalPrice',totalProductPrice);  //! Sepet Fiyat

      discountedPercentFun(); //! Toplam Sepet Fiyat * indirimli fiyat
     
  })
}); //! Değişiklik Olduğunda Son
//! ************ Sepete Ürün Fiyat Güncelleme Son ***************


//! ************ İskonto Hesaplama ***********************
document.querySelector('#discountedPercent').addEventListener('keyup', e => { discountedPercentFun(); }); 
document.querySelector('#discountedPrice').addEventListener('keyup', e => { discountedPriceFun(); }); 

//! Hesaplama
function discountedPercentFun(){

  var data_products_currency = $("#cart_info").attr('data_products_currency'); //! Para Birimi

  var productsAllTotalPrice = $('#productTotalPrice').attr('productsAllTotalPrice'); //! Sepet Fiyat
  productsAllTotalPrice = Number(productsAllTotalPrice.replace(',','.')).toFixed(3); //! Sayı Dönüştür
  
  var discountedPercent = $('#discountedPercent').val(); //! Yüzdelik
  discountedPercent = Number(discountedPercent.replace(',','.')).toFixed(2); //! Sayı Dönüştür

  var productsDiscountedPrice = (Number(productsAllTotalPrice)*discountedPercent)/100; //! İndirim Fiyat
  productsDiscountedPrice = Number(productsDiscountedPrice).toFixed(2); //! Sayı Dönüştür
  
  var productsDiscountedPriceResult = productsAllTotalPrice - productsDiscountedPrice; //! İndirimli Fiyat
  productsDiscountedPriceResult = Number(productsDiscountedPriceResult).toFixed(2); //! Sayı Dönüştür

  //! Sonuc
  $("#discountedPrice").val(productsDiscountedPrice); //! İndirim Fiyat
  $("#productDiscountPrice").html(productsDiscountedPrice+" "+data_products_currency); //! İndirimli Fiyat
  $("#productResultPrice").html(productsDiscountedPriceResult+" " +data_products_currency); //! Son Fiyat

}
//! Hesaplama

//! Hesaplama
function discountedPriceFun(){

    var data_products_currency = $("#cart_info").attr('data_products_currency'); //! Para Birimi
  
    var productsAllTotalPrice = $('#productTotalPrice').attr('productsAllTotalPrice'); //! Sepet Fiyat
    productsAllTotalPrice = Number(productsAllTotalPrice.replace(',','.')).toFixed(2); //! Sayı Dönüştür
  
    var discountedPrice = $('#discountedPrice').val(); //! Yüzdelik
    discountedPrice = Number(discountedPrice.replace(',','.')).toFixed(2); //! Sayı Dönüştür
   
    var discountedPercent = (discountedPrice*100)/productsAllTotalPrice; //! İndirim Yüzdelik
    discountedPercent = Number(discountedPercent).toFixed(2); //! Sayı Dönüştür

    var productsDiscountedPriceResult = productsAllTotalPrice - discountedPrice; //! İndirimli Fiyat
    productsDiscountedPriceResult = Number(productsDiscountedPriceResult).toFixed(2); //! Sayı Dönüştür
   
    //! Sonuc
    $("#discountedPercent").val(discountedPercent); //! İndirim Yüzdelik
    $("#productDiscountPrice").html(discountedPrice+" "+data_products_currency); //! İndirimli Fiyat
    $("#productResultPrice").html(productsDiscountedPriceResult); //! Son Fiyat
  
}
//! Hesaplama
//! ************ İskonto Hesaplama Son ***********************


//! ************ Sepete Ürün Silme ***************
//! Sepete Ürün Silme
document.querySelectorAll("#userCartDelete").forEach((Item) => {
  Item.addEventListener("click", e => {
     
      var data_id = e.target.getAttribute("data_id"); //! Target ATTR
      //console.log("data_id:", data_id);

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
                  url: listUrl_Cart + "/delete/post",
                  type: "post",
                  headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                  data: {
                      siteLang: yildirimdevMultiLangJsonReturnR.lang,
                      id:Number(data_id),
                      //created_byId: document.cookie.split(';').find((row) => row.startsWith(' yildirimdev_userID='))?.split('=')[1],
                  },              
                  beforeSend: function() { console.log("Sepet Listesinden Sil -  Başlangıc"); },
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
}) //! Sepete Ürün Silme Son
//! ************ Sepete Ürün Silme Son  ***************

//! ************ Sepet Güncelleme  ***************
//! Sepet Güncelleme
$("#cartUpdate").click(function (e) {
  e.preventDefault();

  var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
  //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);

  //! Güncellecek Veriler
  var cart_edit_list = [];

  document.querySelectorAll('[id="cart-product-quantity"]').forEach((Item) => {
      var data_id = Item.getAttribute("data_id");
      //console.log("data_id:",data_id);

      var data_product_quantity = Item.getAttribute("data_product_quantity");
      //console.log("data_product_quantity:",data_product_quantity);

      var data_value = Item.value;
      //console.log("data_value:",data_value);

      //! Veriler
      if( data_product_quantity != data_value) {
          var data_edit = {id:data_id, product_quantity:data_value};
          cart_edit_list.push(data_edit);
      }

  });

  if(cart_edit_list.length > 0 ) {
  
      //! Ajax  Post
      $.ajax({
          url: listUrl_Cart + "/edit/post",
          type: "post",
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          data: {
              siteLang: yildirimdevMultiLangJsonReturnR.lang,
              user_id: document.cookie.split(';').find((row) => row.startsWith('web_userId='))?.split('=')[1],
              cart_list: JSON.stringify(cart_edit_list),

              updated_byId: document.cookie.split(';').find((row) => row.startsWith('web_userId='))?.split('=')[1]
          },
          beforeSend: function() { console.log("Başlangıc"); },
          success: function (response) {
              // alert("başarılı");
              console.log("response:", response);

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
          complete: function() {  }
      }); //! Ajax Post Son
  
  }

}); //! Sepet Güncelleme Son
//! ************ Sepet Güncelleme Son ***************

//! ************ Sipariş Oluşturma  ***************
//! Sipariş Oluşturma
$("#orderCreate").click(function (e) {
  e.preventDefault();

  var yildirimdevMultiLangJsonReturnR = yildirimdevMultiLangJsonReturn();
  //console.log("lang:",yildirimdevMultiLangJsonReturnR.lang);

  var data_time = $('#cart_info').attr('data_time');
  //console.log("data_time:",data_time);

  var orderName = $('#orderName').val();
  //console.log("orderName:",orderName);

  if(orderName == "") {

      Swal.fire({
          position: "center",
          icon: "error",
          title: "Sipariş Adı Yazılmadı",
          showConfirmButton: false,
          timer: 2000,
      });

  }
  else {
     
      //! Eklenecek Veriler
      var cart_list = [];

      document.querySelectorAll('[id="cart-product-quantity"]').forEach((Item) => {
          var data_id = Item.getAttribute("data_id");
          //console.log("data_id:",data_id);

          var data_productsUid = Item.getAttribute("data_productsUid");
          //console.log("data_productsUid:",data_productsUid);

          var data_value = Item.value;
          //console.log("data_value:",data_value);

          //! Veriler
          var data_add = {id:data_id, product_uid:data_productsUid, product_quantity:data_value};
          cart_list.push(data_add);

      });

      if(cart_list.length > 0 ) {
      
          //! Ajax  Post
          $.ajax({
              url:  "/user/order/add/post",
              type: "post",
              headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
              data: {
                  siteLang: yildirimdevMultiLangJsonReturnR.lang,
                  uid:data_time,
                  title:orderName,
                  user_id: document.cookie.split(';').find((row) => row.startsWith('web_userId='))?.split('=')[1] ? document.cookie.split(';').find((row) => row.startsWith('web_userId='))?.split('=')[1] : document.cookie.split(';').find((row) => row.startsWith(' web_userId='))?.split('=')[1],
                  cart_list: JSON.stringify(cart_list),

                  updated_byId: document.cookie.split(';').find((row) => row.startsWith('web_userId='))?.split('=')[1] ? document.cookie.split(';').find((row) => row.startsWith('web_userId='))?.split('=')[1] : document.cookie.split(';').find((row) => row.startsWith(' web_userId='))?.split('=')[1]
              },
              beforeSend: function() { console.log("Başlangıc"); },
              success: function (response) {
                  // alert("başarılı");
                  //console.log("response:", response);

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
              complete: function() {  }
          }); //! Ajax Post Son
      
      }
      
  }



}); //! Sipariş Oluşturma Son
//! ************ Sipariş Oluşturma Son ***************