<?php



//! Seo Oluşturma
function SEOLink($data){
    $metin_aranan = array("ş", "Ş", "ı", "ü", "Ü", "ö", "Ö", "ç", "Ç", "ş", "Ş", "ı", "ğ", "Ğ", "İ", "ö", "Ö", "Ç", "ç", "ü", "Ü");
    $metin_yerine_gelecek = array("s", "S", "i", "u", "U", "o", "O", "c", "C", "s", "S", "i", "g", "G", "I", "o", "O", "C", "c", "u", "U");
    $data = str_replace($metin_aranan, $metin_yerine_gelecek, $data);
    $data = preg_replace("@[^a-z0-9\-_şıüğçİŞĞÜÇ]+@i", "-", $data);
    $data = strtolower($data);
    $data = preg_replace('/&.+?;/', '', $data);
    $data = preg_replace('|-+|', '-', $data);
    $data = preg_replace('/#/', '', $data);
    $data = str_replace('.', '', $data);
    $data = trim($data, '-');
    return $data;
}
//! Seo Oluşturma Son


?>