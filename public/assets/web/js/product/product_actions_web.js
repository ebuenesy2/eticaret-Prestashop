/**
 * Veri ekle
 * Veri sil
 * Veri güncelle
 */


//alert("product_actions_web");
console.log("web - Ürün İşlemleri");

//! Dil Alıyor
var yildirimdevMultiLangJson = JSON.parse(localStorage.getItem('yildirimdevMultiLang')); //! Çoklu Dil

//! Çoklu Dil Fonksiyon
function yildirimdevMultiLangJsonReturn () {
    if(yildirimdevMultiLangJson == null) { var yildirimdevMultiLangJson = JSON.parse(localStorage.getItem('yildirimdevMultiLang')); }
    return yildirimdevMultiLangJson;
}  //! Çoklu Dil Fonksiyon Son

//! ************ Resim  ***************
//! Resim Değişiklik Olduğunda
document.querySelectorAll('#product_gallery').forEach(function (i) {
    i.addEventListener('click', function (event) {
        //alert("değiştirme");

        //! Attr - Diğer Veri Alma
        var data_src =  event.target.src;
        //console.log("data_src:", data_src);
     
        $('#product_big').attr('src',data_src);
   
    });
});  //! Resim Değişiklik Olduğunda Son

//! ************ Resim Son  ***************


//! ************ Filtreleme  ***************
//! Arama
$("#search_button").click(function (e) {
    e.preventDefault();

    var search_value = $('#search_value').val();
    //console.log("search_value:",search_value);

    //! Sayfa yönlendirme
    if(search_value != "") { window.location.href = "?search="+search_value; }

}); //! Arama Son

//! Filtreleme
$("#filtereleControl").click(function (e) {
    e.preventDefault();

    //! Seçilen Kategoriler
    var selectedCategory = new Array();
    $('input[type=checkbox][name="product_categories"]:checked').each(function () {
      var data_check_id = $(this).val();
      selectedCategory.push(data_check_id); //! Seçilenleri array içine ekliyor
    });
    
    //console.log("selectedCategory:", selectedCategory);
    //console.log("selectedCategory sayısı:",selectedCategory.length);
    //! Seçilen Kategoriler Son

    var data_url = $('#filtereleControl').attr('data_url'); //! Url
    if(selectedCategory.length > 0) { var data_url = data_url+"&categories="+selectedCategory.join('_'); } 
    //console.log("data_url:",data_url);

    window.location.href = data_url; //! Sayfa yönlendirme

}); //! Filtreleme Son
//! ************ Filtreleme Son ***************