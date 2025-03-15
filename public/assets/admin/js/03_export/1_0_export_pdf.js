alert("1_0_export_pdf js Kullanımı");
console.log("1_0_export_pdf js çalışıyor");

//! Pdf Çevir
async function  generatePDF() {
        
  // Choose the element id which you want to export.
  var element = document.getElementById('divToExport'); //! Veriler
  // element.style.width = '650px';
  // element.style.height = '%100';

  var exportName = $('#divToExport').attr('exportName'); //! Export Kayıt Adı
  
  var opt = {
    margin:       0.5, //! Sayfada Margin
    //filename:     'myfile.pdf', //! Dosya Adı
    filename:     exportName+'.pdf', //! Dosya Adı
    pagebreak: { avoid: ['tr', 'td'] }, //! Tabloları Düzgün Şekilde Gösteriyor
    image:        { type: 'jpeg', quality: 100 },
    html2canvas:  { scale: 2 },
    //html2canvas: { dpi: 192, width: $(window).width()}, //! Tam ekran olarak gösteriyor
    putOnlyUsedFonts:true,
    jsPDF: {  orientation: 'portrait', unit: 'in', format: 'letter',precision: 16 }
  };
    
  /*
    quality => kesinlik - bulanıklık
    unit => Ölçüm birimi [in,mm,cm]
    format => PDF türü [ letter = mektup] [ a4]
    orientation => Sayfa Yönü [landscape = yatay] [portrait = dikey]
    precision => Elemanların Konumları
  */
        
  //! Kaydetme
  html2pdf().from(element).set(opt).toPdf().get('pdf').then(function(pdf) {
    var totalPages = pdf.internal.getNumberOfPages(); //! Sayfa Sayısı
    
    //! Her Sayfada
    for (i = 1; i <= totalPages; i++) {
        pdf.setPage(i);  //! Sayfalar
        pdf.setFontSize(10); //! Yazı Boyutu
        pdf.setTextColor(100); //! Font Rengi
        //pdf.text('deneme'); //! Her Sayıda Yazı
        pdf.text( i + ' / ' + totalPages,(pdf.internal.pageSize.getWidth() / 2.3), (pdf.internal.pageSize.getHeight() - 0.3)); //! Sayfa Numarası
    } 
    //! Her Sayfada Son

    //! Ekran Ön izleme
    window.open(pdf.output('bloburl'), '_blank'); //! Ön izleme

  }).save();
  //! Kaydetme Son

  return true;
     
}  //! Pdf Çevir Son

//! Export Fonksiyon
function çalıştırma () {

  //! Export Göster
  $('#divToExport').css('display','block'); //! Göster

  //! Export Pdf Fonksiyon
  generatePDF().then(
    function(value) { console.log("başarılı value:",value); $('#divToExport').css('display','block');  setTimeout(() => {  alert("yazıldı"); }, 1000);    },
    function(error) { console.log("hata error:",error);}
  );

} //! Export Fonksiyon

//! Export Fonksiyon Kullanımı
const queryString = window.location.search; //! ?search=3
const urlParams = new URLSearchParams(queryString); //! Url Bilgiler
const getParams = urlParams.get('export'); //! 3

//console.log("getParams:",getParams);

if(getParams=="true"){ console.log(çalıştırma()); }
//else { console.log("export yok"); }
//! Export Fonksiyon Kullanımı Son


//! İşlemler
$("#exportExportReturn").click(function (e) { e.preventDefault();   window.history.back(); }); //! Geri Dön
$("#exportExport").click(function (e) { e.preventDefault();   çalıştırma(); }); //! Yazdır

//! Yazdır Ekran
$("#exportExportWindow").click(function (e) { 
  e.preventDefault();  

  //! Tanım
  var divToPrintHTML = document.getElementById('divToExport').innerHTML; //! Export Alınacak

  //! Css
  var styleCss = '<style type="text/css" media="print">';
  styleCss = styleCss+"@page {";
  styleCss = styleCss+"size: auto;";
  //styleCss = styleCss+"margin: 5mm;";
  styleCss = styleCss+"margin-top: 5mm;";
  styleCss = styleCss+"}";
  styleCss = styleCss+"</style>";

 
  //! Js
  var script = "<script>";
  script = script+"var nodeDisplay = document.querySelectorAll('[id=exportView]');";
  script = script+"for (let i = 0; i < nodeDisplay.length; i++) {";
  script = script+"var displayViewControl = nodeDisplay[i].attributes['exportViewDisplay'].value;";
  script = script+"console.log('displayViewControl',displayViewControl);";
  script = script+"nodeDisplay[i].style.display = displayViewControl == 'false' ? 'none' :'';";
  script = script+"}";
  script = script+"window.print();";
  script = script+"</script>";
  //! Js Son

  //! Pencere
  var new_window = $('#iFramePdf')[0].contentWindow.document; //! Frame
  $("body",new_window).html(""); //! Sıfırlama
  $("body",new_window).append(styleCss+ divToPrintHTML+script); //! Ekran Ekleme

  setTimeout(()=>{
    //new_window.printPreview(); //! Yazdırmadan önce gösterme
    try { new_window.print(); } catch (error) { } //! Yazdır
    new_window.close(); //! Kapat
  },200);

}); //! Yazdır Ekran Son