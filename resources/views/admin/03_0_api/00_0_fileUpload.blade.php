<meta name="csrf-token" content="{{ csrf_token() }}" />
 
<h1> Api -  Tek Dosya Yükleme</h1>
<br><br>  

<!-- Dosya Yükleme Kutusu ----->
<div style="width: 450px;border: 2px solid;padding: 10px;">

    <!-- Dosya Yükleme ----->
    <form method="POST" id="uploadForm" enctype="multipart/form-data">
        <div style="display: flex;flex-direction: column; gap: 15px;">

            <!-- Dosya Yükleme Bilgileri ----->
            <input type="hidden" name="fileDbSave" id="fileDbSave" value="true" >
            <input type="hidden" name="fileWhere" id="fileWhere" value="Sabit" >

            <!---  Loading --->
            <div id="LoadingFileUpload" style="display:none;" ><span class="d-flex align-items-center">
                <span class="spinner-border flex-shrink-0" role="status"></span>
                <span class="flex-grow-1 ms-2">@lang('admin.loading') </span>
            </span> </div>
            <div id="uploadStatus"></div>
            <!--- End Loading --->

            <input type="file" name="file" id="fileInput" style="display: flex; color: steelblue; margin-left: 10px; ">
            <div style="display: flex; gap: 10px; margin-bottom: -25px;" ><p>@lang('admin.fileUrl'):</p><p id="filePathUrl"></p></div>
            <button type="button" id="fileUploadClick" class="btn btn-success" style="cursor:pointer; background-image: linear-gradient(#04519b, #033c73 60%, #02325f);color: #ffffff;border-bottom: 1px solid #022241;padding: 12px;width: 300px;border-radius: 6px;display: flex; gap:10px; justify-content: center;align-items: center;">
                <i class="ri-folder-upload-line" style="margin-top: -8px;  margin-bottom: -8px; font-size: 24px;"></i> 
                <p style=" color: blanchedalmond; font-size: 14px; font-weight: bold; " > @lang('admin.fileUpload') </p>
            </button>
            
            <!-- ProgressBar ---->
            <div class="progress" style="margin-top: 20px;">
                <div class="progress-bar" id="progressBarFileUpload" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;background-color: teal;color: rgb(255, 255, 255);border-radius: 6px;display: flex;justify-content: center;"></div>
            </div>
            <!-- ProgressBar Son ---->
            
        </div>
    </form>
    <!-- Dosya Yükleme Son ---->

</div>
<!-- Dosya Yükleme Kutusu Son ----->


<!--------- Jquery  Ajax -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>  

<!------- Dosya Yükleme JS --->
<script src="{{asset('/assets/admin')}}/js/02_0_api/00_0_fileUpload.js"></script>