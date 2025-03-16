# Prestashop - Ürün ve Kategori Listeleme

## Proje Hakkında
Bu proje, ürün ve kategori yönetimini kolaylaştıran, kullanıcı dostu bir arayüz ve güçlü özelliklere sahip bir listeleme ve alışveriş uygulamasıdır. Kullanıcıların ürün ve kategori bilgilerini görüntüleyebilmesini, seçilen kategorilere göre filtreleme yapabilmesini ve kullanıcı sepetini PDF olarak dışa aktarabilmesini sağlar.

---

## Version Bilgisi
**Sürüm:** V1.0.0  
**Geliştirici:** *Ebu Enes Yıldırım*

---

## Çalıştırma
Projenizi başlatmak için aşağıdaki komutu çalıştırın:
```bash
php artisan serve
```

Proje, varsayılan olarak şu adreste çalışır:  
[http://localhost:8000/](http://localhost:8000/)

---

## Özellikler
Aşağıdaki özellikler bu proje için tamamlanmıştır:

### Genel Özellikler
- **SEO Uyumlu Tasarım:**
  - Başlık ve altlık (header/footer) yapıları.
  - Dinamik ve çok katmanlı menü (multiMenu) sistemi.
- **Çoklu Dil Desteği:**
  - Türkçe ve İngilizce içerik sunar.

### Tamamlanmış İşlevler
1. **Ürün Listeleme:**
   - Tüm ürünlerin listelendiği dinamik bir arayüz.
   - Ürün detayları: *ID, Ad, Fiyat, Görsel, Miktar*.

2. **Kategori Listesi:**
   - Tüm kategoriler ve alt kategoriler hiyerarşik bir yapıda gösterilir.

3. **Seçilen Kategorilere Göre Ürün Listeleme:**
   - Kullanıcı tarafından seçilen bir kategoriye ait ürünler filtrelenir ve listelenir.

4. **Kullanıcı Sepeti:**
   - Kullanıcı, sepete ürün ekleyebilir, ürünleri güncelleyebilir ve kaldırabilir.
   - Toplam miktar ve fiyat anlık olarak hesaplanır.

5. **PDF Oluşturma:**
   - Sepetteki ürünlerin bir PDF belgesi halinde dışa aktarılması.
   - PDF görünümü:
     - Ürün bilgileri (ID, Ad, Fiyat, Miktar, Toplam).
     - Toplam sepet değeri.

---

## Teknolojiler ve Kütüphaneler
- **Laravel Framework**: Projenin ana altyapısı.
- **Dompdf**: Sepeti PDF formatında oluşturma.
- **AJAX**: Sayfa yenilemeden hızlı veri alışverişi için kullanılmıştır.
- **SweetAlert & ToastrAlert**: Etkileşimli ve görsel bildirimler.
- **Bootstrap**: Responsive tasarım ve kolay arayüz geliştirme.

---

## TODO - Tamamlanmış Görevler
- [x] **Ürün Listeleme**
- [x] **Kategori Listesi**
- [x] **Seçilen Kategorilere Göre Ürün Listeleme**
- [x] **Kullanıcı Sepeti Yönetimi**
- [x] **Sepeti PDF Olarak Dışa Aktarma**

---

## Katkıda Bulunmak
Projeye katkıda bulunmak isterseniz, lütfen bir *pull request* gönderin veya benimle iletişime geçin:  
**Ebu Enes Yıldırım**

## 👨‍💻 Geliştirici Hakkında
**Ebu Enes Yıldırım**  
_Tutkulu bir geliştirici olarak, kullanıcı dostu ve performans odaklı projeler yaratmaya odaklanıyorum. Bu proje, Prestashop ile modern bir ürün listeleme deneyimi sunmak için tasarlandı._

LinkedIn: [linkedin.com/in/ebuenesyildirim](#)  
GitHub: [github.com/ebuenesy2](#)
