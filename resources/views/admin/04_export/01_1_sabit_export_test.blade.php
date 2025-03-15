
<title>Test</title>

<!------- Export --->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"
    integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" 
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!------  Çıkacak Yazı   -->   
<div id="divToExport"  style="display:block;"  exportName="test_<?=time()?>" >

  <!---- Css  -->
  <style type="text/css" media="print">
   @page 
   {
       size: auto; 
       /* margin: 5mm; */
       margin-top: 5mm;
   }
  </style> 
  <!---- Css Son  -->

  <html>

    <head>
        <meta content="text/html; charset=UTF-8" http-equiv="content-type">
        <style type="text/css">
            ol {
                margin: 0;
                padding: 0
            }

            table td,
            table th {
                padding: 0
            }

            .c1 {
                border-right-style: solid;
                padding: 5pt 5pt 5pt 5pt;
                border-bottom-color: #000000;
                border-top-width: 1pt;
                border-right-width: 1pt;
                border-left-color: #000000;
                vertical-align: top;
                border-right-color: #000000;
                border-left-width: 1pt;
                border-top-style: solid;
                border-left-style: solid;
                border-bottom-width: 1pt;
                width: 128.8pt;
                border-top-color: #000000;
                border-bottom-style: solid
            }

            .c14 {
                border-right-style: solid;
                padding: 5pt 5pt 5pt 5pt;
                border-bottom-color: #000000;
                border-top-width: 1pt;
                border-right-width: 1pt;
                border-left-color: #000000;
                vertical-align: top;
                border-right-color: #000000;
                border-left-width: 1pt;
                border-top-style: solid;
                border-left-style: solid;
                border-bottom-width: 1pt;
                width: 525pt;
                border-top-color: #000000;
                border-bottom-style: solid
            }

            .c3 {
                border-right-style: solid;
                padding: 5pt 5pt 5pt 5pt;
                border-bottom-color: #000000;
                border-top-width: 1pt;
                border-right-width: 1pt;
                border-left-color: #000000;
                vertical-align: top;
                border-right-color: #000000;
                border-left-width: 1pt;
                border-top-style: solid;
                border-left-style: solid;
                border-bottom-width: 1pt;
                width: 103pt;
                border-top-color: #000000;
                border-bottom-style: solid
            }

            .c27 {
                border-right-style: solid;
                padding: 5pt 5pt 5pt 5pt;
                border-bottom-color: #000000;
                border-top-width: 1pt;
                border-right-width: 1pt;
                border-left-color: #000000;
                vertical-align: top;
                border-right-color: #000000;
                border-left-width: 1pt;
                border-top-style: solid;
                border-left-style: solid;
                border-bottom-width: 1pt;
                width: 528.8pt;
                border-top-color: #000000;
                border-bottom-style: solid
            }

            .c0 {
                color: #000000;
                font-weight: 400;
                text-decoration: none;
                vertical-align: baseline;
                font-size: 11pt;
                font-family: "Arial";
                font-style: normal
            }

            .c11 {
                color: #000000;
                font-weight: 400;
                text-decoration: none;
                vertical-align: baseline;
                font-size: 10pt;
                font-family: "Arial";
                font-style: normal
            }

            .c16 {
                color: #ffffff;
                font-weight: 400;
                text-decoration: none;
                vertical-align: baseline;
                font-size: 11pt;
                font-family: "Arial";
                font-style: normal
            }

            .c13 {
                padding-top: 0pt;
                padding-bottom: 0pt;
                line-height: 1.1500000000000001;
                orphans: 2;
                widows: 2;
                text-align: left
            }

            .c2 {
                padding-top: 0pt;
                padding-bottom: 0pt;
                line-height: 1.0;
                text-align: center
            }

            .c15 {
                border-spacing: 0;
                border-collapse: collapse;
                margin-right: auto
            }

            .c5 {
                padding-top: 0pt;
                padding-bottom: 0pt;
                line-height: 1.0;
                text-align: left
            }

            .c26 {
                background-color: #ffffff;
                max-width: 488pt;
                padding: 21.3pt 72pt 34.6pt 35.4pt
            }

            .c19 {
                height: 20.7pt
            }

            .c7 {
                background-color: #ff9900
            }

            .c23 {
                background-color: #f6b26b
            }

            .c4 {
                height: 11pt
            }

            .c21 {
                background-color: #d9d9d9
            }

            .c12 {
                height: 11.1pt
            }

            .c10 {
                background-color: #6aa84f
            }

            .c20 {
                height: 23.9pt
            }

            .c22 {
                background-color: #ff0000
            }

            .c24 {
                background-color: #4a86e8
            }

            .c6 {
                background-color: #8e7cc3
            }

            .c8 {
                height: 18pt
            }

            .c18 {
                height: 0pt
            }

            .c25 {
                background-color: #76a5af
            }

            .c17 {
                height: 97.7pt
            }

            .c9 {
                height: 21.6pt
            }

            .title {
                padding-top: 0pt;
                color: #000000;
                font-size: 26pt;
                padding-bottom: 3pt;
                font-family: "Arial";
                line-height: 1.1500000000000001;
                page-break-after: avoid;
                orphans: 2;
                widows: 2;
                text-align: left
            }

            .subtitle {
                padding-top: 0pt;
                color: #666666;
                font-size: 15pt;
                padding-bottom: 16pt;
                font-family: "Arial";
                line-height: 1.1500000000000001;
                page-break-after: avoid;
                orphans: 2;
                widows: 2;
                text-align: left
            }

            li {
                color: #000000;
                font-size: 11pt;
                font-family: "Arial"
            }

            p {
                margin: 0;
                color: #000000;
                font-size: 11pt;
                font-family: "Arial"
            }

            h1 {
                padding-top: 20pt;
                color: #000000;
                font-size: 20pt;
                padding-bottom: 6pt;
                font-family: "Arial";
                line-height: 1.1500000000000001;
                page-break-after: avoid;
                orphans: 2;
                widows: 2;
                text-align: left
            }

            h2 {
                padding-top: 18pt;
                color: #000000;
                font-size: 16pt;
                padding-bottom: 6pt;
                font-family: "Arial";
                line-height: 1.1500000000000001;
                page-break-after: avoid;
                orphans: 2;
                widows: 2;
                text-align: left
            }

            h3 {
                padding-top: 16pt;
                color: #434343;
                font-size: 14pt;
                padding-bottom: 4pt;
                font-family: "Arial";
                line-height: 1.1500000000000001;
                page-break-after: avoid;
                orphans: 2;
                widows: 2;
                text-align: left
            }

            h4 {
                padding-top: 14pt;
                color: #666666;
                font-size: 12pt;
                padding-bottom: 4pt;
                font-family: "Arial";
                line-height: 1.1500000000000001;
                page-break-after: avoid;
                orphans: 2;
                widows: 2;
                text-align: left
            }

            h5 {
                padding-top: 12pt;
                color: #666666;
                font-size: 11pt;
                padding-bottom: 4pt;
                font-family: "Arial";
                line-height: 1.1500000000000001;
                page-break-after: avoid;
                orphans: 2;
                widows: 2;
                text-align: left
            }

            h6 {
                padding-top: 12pt;
                color: #666666;
                font-size: 11pt;
                padding-bottom: 4pt;
                font-family: "Arial";
                line-height: 1.1500000000000001;
                page-break-after: avoid;
                font-style: italic;
                orphans: 2;
                widows: 2;
                text-align: left
            }
        </style>
    </head>

    <body class="c26 doc-content">
        <p class="c13 c4"><span class="c0"></span></p><a id="t.b2d53afde025a1d63c3bebea3e3c8c057212b099"></a><a
            id="t.0"></a>
        <table class="c15">
            <tr class="c9">
                <td class="c27" colspan="1" rowspan="1">
                    <p class="c2"><span class="c0">Ayl&#305;k Maliye &nbsp;Plan ( 02 &nbsp;- &nbsp;&#350;ubat &nbsp;- 2023)</span></p>
                </td>
            </tr>
        </table>
        <p class="c13 c4"><span class="c0"></span></p><a id="t.80500309ea57af56080b64a8912ae0bc73dbf0fc"></a><a
            id="t.1"></a>
        <table class="c15">
            <tr class="c20">
                <td class="c14 c21" colspan="1" rowspan="1">
                    <p class="c2"><span class="c0">Gelir - Gider Tablosu</span></p>
                </td>
            </tr>
            <tr class="c18">
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c5"><span class="c0">&nbsp; &nbsp;</span></p><a
                        id="t.f7bd4ec0c825f60124fd780b318421578b012c13"></a><a id="t.2"></a>
                    <table class="c15">
                        <tr class="c18">
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">&nbsp;Tan&#305;m</span></p>
                            </td>
                            <td class="c1 c10" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">Gelir</span></p>
                            </td>
                            <td class="c1 c22" colspan="1" rowspan="1">
                                <p class="c2"><span class="c16">Gider</span></p>
                            </td>
                            <td class="c1 c7" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">Sonu&ccedil;</span></p>
                            </td>
                        </tr>
                        <tr class="c12">
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">Maa&#351;</span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                        </tr>
                        <tr class="c12">
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">Ek &Uuml;cret</span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                        </tr>
                        <tr class="c12">
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">Kesinti</span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                        </tr>
                        <tr class="c12">
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">Kira</span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                        </tr>
                        <tr class="c12">
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">Fatura</span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                        </tr>
                        <tr class="c12">
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">Yol Masraf&#305;</span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                        </tr>
                        <tr class="c12">
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">Yat&#305;r&#305;m</span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                        </tr>
                        <tr class="c12">
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">Hesap</span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                        </tr>
                        <tr class="c12">
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">Keyfi Gider </span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                        </tr>
                        <tr class="c12">
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">Har&ccedil;l&#305;k</span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                        </tr>
                        <tr class="c12">
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">Sosyal Medya</span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                        </tr>
                        <tr class="c12" id="exportView"  exportViewDisplay="false" >
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">Gizle</span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                        </tr>
                        <tr class="c12" id="exportView"  exportViewDisplay="false" >
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">Gizle 1</span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0">gizle</span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0">gizle</span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0">gizle</span></p>
                            </td>
                        </tr>
                        <tr class="c12" id="exportView"  exportViewDisplay="true" style="display:none;"  >
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">Göster</span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0">göster</span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0">göster</span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0">göster</span></p>
                            </td>
                        </tr>
                        <tr class="c18">
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">Toplam</span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">xx</span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">xx</span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">xx</span></p>
                            </td>
                        </tr>
                    </table>
                    <p class="c5 c4"><span class="c0"></span></p>
                    <p class="c5 c4"><span class="c0"></span></p><a id="t.ec63886662b3775074ab6c7f6cb6ae14ba5bd08f"></a><a
                        id="t.3"></a>
                    <table class="c15">
                        <tr class="c18">
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">&nbsp;Yat&#305;r&#305;m</span></p>
                            </td>
                            <td class="c1 c10" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">Miktar</span></p>
                            </td>
                            <td class="c1 c6" colspan="1" rowspan="1">
                                <p class="c2"><span class="c16">Birim Fiyat</span></p>
                            </td>
                            <td class="c1 c7" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">Sonu&ccedil;</span></p>
                            </td>
                        </tr>
                        <tr class="c8">
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">TL</span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                        </tr>
                        <tr class="c19">
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">Euro</span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                        </tr>
                        <tr class="c12">
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">Dolar</span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                        </tr>
                        <tr class="c12">
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">Paribu</span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                        </tr>
                        <tr class="c12">
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">Paribu</span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                        </tr>
                        <tr class="c12">
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">Toplam</span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">xx</span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">xx</span></p>
                            </td>
                            <td class="c1" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">xx</span></p>
                            </td>
                        </tr>
                    </table>
                    <p class="c5 c4"><span class="c0"></span></p>
                    <p class="c5 c4"><span class="c0"></span></p><a id="t.845649178444e8a42fc2c479c71eb5598e5b5648"></a><a
                        id="t.4"></a>
                    <table class="c15">
                        <tr class="c18">
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">&nbsp;Hesap</span></p>
                            </td>
                            <td class="c3 c10" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">Miktar</span></p>
                            </td>
                            <td class="c3 c6" colspan="1" rowspan="1">
                                <p class="c2"><span class="c16">Oran</span></p>
                            </td>
                            <td class="c3 c25" colspan="1" rowspan="1">
                                <p class="c2"><span class="c16">Banka</span></p>
                            </td>
                            <td class="c3 c7" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">Yat&#305;ran Tarih</span></p>
                            </td>
                        </tr>
                        <tr class="c12">
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">Vadeli Hesap</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                        </tr>
                    </table>
                    <p class="c5 c4"><span class="c0"></span></p>
                    <p class="c5 c4"><span class="c0"></span></p><a id="t.2a4c162965e0d8f0e66abba82d69190471d567a2"></a><a
                        id="t.5"></a>
                    <table class="c15">
                        <tr class="c18">
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">&nbsp;Keyfi Gider</span></p>
                            </td>
                            <td class="c3 c10" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">Miktar</span></p>
                            </td>
                            <td class="c3 c6" colspan="1" rowspan="1">
                                <p class="c2"><span class="c16">Birim Fiyat</span></p>
                            </td>
                            <td class="c3 c25" colspan="1" rowspan="1">
                                <p class="c2"><span class="c16">Toplam Fiyat</span></p>
                            </td>
                            <td class="c3 c7" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">Yat&#305;ran &nbsp;D&ouml;viz</span></p>
                            </td>
                        </tr>
                        <tr class="c12">
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">Sigara</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                        </tr>
                        <tr class="c12">
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">Udemy</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">-</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                        </tr>
                        <tr class="c12">
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">Udemy</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">-</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                        </tr>
                        <tr class="c12">
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">Udemy</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">-</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                        </tr>
                        <tr class="c12">
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">Udemy</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">-</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                        </tr>
                        <tr class="c12">
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">Udemy</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">-</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                        </tr>
                        <tr class="c12">
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">Udemy</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">-</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2 c4"><span class="c0"></span></p>
                            </td>
                        </tr>
                    </table>
                    <p class="c5 c4"><span class="c0"></span></p>
                </td>
            </tr>
        </table>
        <p class="c4 c13"><span class="c0"></span></p>
        <p class="c13 c4"><span class="c0"></span></p><a id="t.5d847bb365600946631e6647d65cee155ccd1bf6"></a><a
            id="t.6"></a>
        <table class="c15">
            <tr class="c20">
                <td class="c14 c21" colspan="1" rowspan="1">
                    <p class="c2"><span class="c0">Paribu Hesap</span></p>
                </td>
            </tr>
            <tr class="c17">
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c5"><span class="c0">&nbsp; &nbsp;</span></p><a
                        id="t.5cbc81bc145cde208ce955befb0465d185b82e1b"></a><a id="t.7"></a>
                    <table class="c15">
                        <tr class="c18">
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">&nbsp;Tan&#305;m</span></p>
                            </td>
                            <td class="c3 c23" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">Tarih</span></p>
                            </td>
                            <td class="c3 c10" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">Birim Fiyat</span></p>
                            </td>
                            <td class="c3 c24" colspan="1" rowspan="1">
                                <p class="c2"><span class="c16">Birim Miktar</span></p>
                            </td>
                            <td class="c3 c7" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">Sonu&ccedil;</span></p>
                            </td>
                        </tr>
                        <tr class="c12">
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">TL</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">18.03.2023</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">139,62</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">1</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">139,62</span></p>
                            </td>
                        </tr>
                        <tr class="c12">
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">APE-TL</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">18.03.2023</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">12,7</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">85</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">1079,5</span></p>
                            </td>
                        </tr>
                        <tr class="c12">
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">XRP-TL</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">18.03.2023</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">26,5</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">7,395</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">195,9675</span></p>
                            </td>
                        </tr>
                        <tr class="c12">
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">FTM-TL</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">18.03.2023</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">0</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">0</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">0</span></p>
                            </td>
                        </tr>
                        <tr class="c12">
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c5"><span class="c11">TOPLAM</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">18.03.2023</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">x</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">x</span></p>
                            </td>
                            <td class="c3" colspan="1" rowspan="1">
                                <p class="c2"><span class="c0">1.415,09</span></p>
                            </td>
                        </tr>
                    </table>
                    <p class="c5 c4"><span class="c0"></span></p>
                    <p class="c5 c4"><span class="c0"></span></p>
                </td>
            </tr>
        </table>
        <p class="c13 c4"><span class="c0"></span></p>
        <p class="c13 c4"><span class="c0"></span></p>
    </body>

  </html>

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
<script src="{{asset('/assets/admin')}}/js/03_export/1_1_export_pdf_test.js"></script>