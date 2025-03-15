<!------- Export --->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"
    integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" 
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!------  Çıkacak Yazı   -->   
<div id="divToExport"  style="display:block;"  exportName="<?=time()?>" >

  <!---- Css  -->
  <style type="text/css" media="print">
   @page {
       size: auto; 
       /* margin: 5mm; */
       margin-top: 5mm;
   }
  </style> 
  <!---- Css Son  -->

  <h1> Artificial Intelligence </h1>
  <h2>Overview</h2>
  <p>
      Artificial Intelligence(AI) is an emerging technology
      demonstrating machine intelligence. The sub studies like <u><i>Neural
              Networks</i>, <i>Robatics</i> or <i>Machine Learning</i></u> are
      the parts of AI. This technology is expected to be a prime part
      of the real world in all levels.
  </p>

  <p id="exportView"  exportViewDisplay="true" >Export - Göster</p>
  <p id="exportView"  exportViewDisplay="false" >Export - Gizle</p>

</div>
<!------  Çıkacak Yazı  End  -->

<!------  Iframe -->
<iframe id="iFramePdf" src="" style="display:none;"></iframe>

<!------  İşlemler  -->
<div style="display:flex; gap:10px;" >
  <button id="exportExportReturn" style="display:block;" >Geri Dön</button>
  <button id="exportExport" style="display:block;" >Yazdır</button>
  <button id="exportExportWindow" style="display:block;" >Yazdır Ekran</button>
</div>

<!--------- Jquery  Ajax -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>  

<!------- Export Js --->
<script src="{{asset('/assets/admin')}}/js/03_export/1_0_export_pdf.js"></script>