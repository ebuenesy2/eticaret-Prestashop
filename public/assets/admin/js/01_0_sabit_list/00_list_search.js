/***
 * Sabit List
 * List Arama
 * Sayfa Yönlendirme
*/

console.log("00_list_search.js");

//! Tanım
var searchJsonData = []; //! Aranan Veriler

//! Başlangıç
function Info() {
    
    //! Eklenecek Veriler
    var newData = [
        {  searchName : 'page', text : 1 },
        {  searchName : 'rowcount', text : $('#listInfoData').attr('rowCountData') },
        {  searchName : 'order', text : $('#listInfoData').attr('orderData') },
        //{  searchName : 'dashboardview', text : $('#listInfoData').attr('dashboardView') }
    ]; //! Eklenecek Veriler Son

    //console.log("newData:",newData);
    searchJsonData = newData; //! Başlangıçtaki Eşitliyor

} //! Başlangıç Son

Info(); //! Fonksiyon Çalıştırma

//! Params dan Json Oluşturma
function paramsJson() {

    //! Params Verileri Parçalıyor
    var searchParams = window.location.search; //! Params Url
    var searchParamsSplit = searchParams.split('?'); //! Params Ayırma
    var searchParamsArray = []; //! Params Veriler

    //! Params Verileri Alıyor
    searchParamsArray = searchParamsSplit.length >= 2 ? searchParamsSplit[1].split('&') : [];

    //! Paramsdan Json Versi İçine Kayıt Yapma
    searchParamsArray.map(function(data) {
        
        //! Tanım
        var postData = { "searchName":data.split('=')[0], "text":data.split('=')[1] }; //! Eklenecek Veri
        var searchJsonDataIndex = searchJsonData.find(u=> u.searchName == data.split('=')[0]); //! Arama Yapıyor
        searchJsonDataIndex ? searchJsonDataIndex['text'] = data.split('=')[1] : searchJsonData.push(postData); //! Ekleme ve Güncelleme

    }); //! Paramsdan Json Versi İçine Kayıt Yapma Son

    console.log("searchJsonData:",searchJsonData);

}; //! Params dan Json Oluşturma Son

paramsJson(); //! Fonksiyon Çalıştırma

//! ************ Json Verisine Göre Html Kontrol  ***************

//! Json Html Kontrol
function JsonHtml_Controller () {

    //! Json Verilerini Alıyor
    searchJsonData.map(function(data){
       if(data.searchName != 'page' && data.searchName != 'nogroup' && data.searchName != 'dashboardview' ) {  document.querySelector('[id=searchTable][searchName='+data.searchName+']').value = data.text; }
    }); //! Json Verilerini Alıyor Son

} //! //! Json Html Kontrol Son

//! Fonksiyon Kullanımı
JsonHtml_Controller();

//! ************ Json Verisine Göre Html Kontrol Son  ***************

//! ************ Arama  ***************

//! Arama
document.querySelectorAll("#searchTable").forEach((searchTable) => {
    //searchTable.addEventListener("keyup", e => { searchFunction(e); }), //! Yazılınca
    searchTable.addEventListener("change", e =>{ searchFunction(e); }) //! Değişince
}) 

$("#searchTable").keydown(function(event) { if (event.keyCode == 13) { searchFunction(); } }); //! Enter
//! Arama Son

//! Arama Button
document.querySelectorAll('#searchTableButton').forEach(function (i) {
    i.addEventListener('click', function (e) {
        // document.querySelector('.msg').innerHTML = i.id;

        searchFunction(e);
   
    });
});
//! Arama Button Son

//! Arama Fonksiyon
function searchFunction (e) {

    //! Tanım
    var searchName = e.target.getAttribute("searchName"); //! id
    var searchNameVal = e.target.value;  //! 1
    var searchJsonItem = { searchName: searchName, text:searchNameVal}; //! Aranacak Veri Item
    var searchJsonFindItem = searchJsonData.findIndex(s => s.searchName == searchName); //! Json İçinde Arama

    //! Kontrol
    if(searchJsonFindItem == -1 ) { searchJsonData.push(searchJsonItem); } //! Yoksa Ekliyor
    else if(searchJsonFindItem != -1 ) {  searchJsonData[searchJsonFindItem].text = searchNameVal; } //! Varsa Güncelliyor
    if (searchNameVal == '') {  searchJsonData.splice(searchJsonFindItem, 1); } //! Arama Boş ise Kaldır

    //! Sayfa
    var searchJsonFindItemPage = searchJsonData.findIndex(s => s.searchName == "page"); //! Json İçinde Arama
    if(searchJsonFindItemPage != -1 ) { searchJsonData[searchJsonFindItemPage].text = 1;  } //! Sayfa güncelleme

    //! Table Arama Kontrol
    searchTableControl();

} //! Arama Fonksiyon Son

//! Arama Tablo Kontrol
function searchTableControl(){

    //! Tanım
    var searchParamsList =[];  //! Params Veriler
    var newParams = ""; //! Params Verisi

    //! Json -> Params
    searchJsonData.map(function(data){  searchParamsList.push(data.searchName+"="+data.text);  }); //! ['Id=4', 'CreatedDate=2023-04-18', 'Status=1']
    var newParams = "?"+searchParamsList.join('&');  //! ?Id=4&CreatedDate=2023-04-18&Status=1
    var searchUrl = location.origin + location.pathname + newParams; //! Site Adresi?params

    //! Sayfa Yönlendirme
    location.href = searchUrl;

    //! Sil
    console.log("newParams:",newParams);
    console.log("searchUrl:",searchUrl);

} //! Arama Tablo Kontrol Son

//! ************ Arama Son ***************

    
//! ************ Filtreleme Temizleme  ***************
//! Filtreleme Temizleme 
$("#filter_delete_all").click(function (e) {
    e.preventDefault();

    searchJsonData = []; //! Filtreleme Temizle
    JsonHtml_Controller();

    searchTableControl();

}); //! Filtreleme Temizleme  Son
//! ************ Filtreleme Temizleme  Son  ***************