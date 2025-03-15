<h1> Admin Test View </h1>



<br>
<li>Yetki Listesi - Test</li>
<li style="display: {{ in_array( 'view', array_column($permissions, 'permissionsTitle')) ? 'block': 'none' }} " >Görüntüleme</li>
<li style="display: {{ in_array( 'search_view', array_column($permissions, 'permissionsTitle')) ? 'block': 'none' }} " >Veri Sayfa Arama</li>
<li style="display: {{ in_array( 'edit', array_column($permissions, 'permissionsTitle')) ? 'block': 'none' }} " >Veri Güncelleme</li>
<li>Çoklu Veri Silme</li>
<li>Çoklu Veri Güncelleme</li>