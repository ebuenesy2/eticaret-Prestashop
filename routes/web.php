<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin; //! Admin Control
use App\Http\Controllers\Web; //! Web Control

//************* Web Test  ***************** */

//! Web Test
Route::get('/{lang}/test', [Web::class,'Test']) -> name("web.test"); //! Web Test
Route::get('/{lang}/test/view', [Web::class,'TestView']) -> name("web.test.view"); //! Web Test View

Route::get('/{lang}/fixed', [Web::class,'Fixed']) -> name("web.fixed.page");  //! Web Sabit

//************* Web  ***************** */

//! Web - Anasayfa
Route::get('/', [Web::class,'Index']) -> name("web.index"); //! Web Anasayfa
Route::get('/{lang}', [Web::class,'Index']) -> name("web.index"); //! Web Anasayfa

//************* Web - Ürün ***************** */

Route::get('/{lang}/product/category', [Web::class,'ProductCategoryList']) -> name("web.product.category"); //! Web - Ürün Kategoriler
Route::get('/{lang}/product/category/{uid}', [Web::class,'ProductCategoryView']) -> name("web.product.category.view"); //! Web - Ürün Kategorilerdeki Ürünler

Route::get('/{lang}/product/list', [Web::class,'ProductListAll']) -> name("web.product.all"); //! Web - Ürün Listesi - Tüm Ürünler
Route::get('/{lang}/product/list/new', [Web::class,'ProductListNew']) -> name("web.product.new"); //! Web - Ürün Listesi - Yeni Ürünler
Route::get('/{lang}/product/list/bestseller', [Web::class,'ProductListBestseller']) -> name("web.product.bestseller"); //! Web - Ürün Listesi - Çok Satanlar
Route::get('/{lang}/product/list/editor/suggestion', [Web::class,'ProductListEditorSuggestion']) -> name("web.product.editor.suggestion"); //! Web - Ürün Listesi - Editör Önerisi

Route::get('/{lang}/product/view/{uid}', [Web::class,'ProductView']) -> name("web.product.view"); //! Web - Ürün Listesi

//************* Web - Blog ***************** */

Route::get('/{lang}/blog', [Web::class,'Blog']) -> name("web.blog"); //! Web - Blog
Route::get('/{lang}/blog-single', [Web::class,'BlogSingle']) -> name("web.single"); //! Web - Blog Single


//************* Web - Sayfalar ***************** */

Route::get('/{lang}/faq', [Web::class,'Faq']) -> name("web.faq"); //! Web - Faq

Route::get('/{lang}/contact', [Web::class,'Contact']) -> name("web.contact"); //! Web - İletişim
Route::post('/contact/message/add/post', [Web::class,'ContactMessage']) -> name("web.contact.message.add.post"); //! Web - İletişim Mesaj Yaz - Post

Route::get('/{lang}/about', [Web::class,'About']) -> name("web.about"); //! Web - Hakkımızda

Route::get('/{lang}/error404', [Web::class,'Error404']) -> name("web.error.404"); //! Web - Hata 404
Route::get('/{lang}/coming-soon', [Web::class,'ComingSoon']) -> name("web.coming-soon"); //! Web - Yakında

//************* Web - Kullanıcı ***************** */

//! Giriş
Route::get('/{lang}/user/login', [Web::class,'UserLogin']) -> name("web.user.login"); //! Web - Kullanıcı - Giriş
Route::post('/user/login/post', [Web::class,'UserLoginPost']) -> name("web.user.login.post"); //! Web Kullanıcı Giriş - Post
Route::get('/{lang}/user/logout', [Web::class,'UserLogout']) -> name("web.user.logout"); //! Web - Kullanıcı - Çıkış
Route::post('/user/register/post', [Web::class,'UserRegisterPost']) -> name("web.register.post"); //! Web Kullanıcı Kayıt - Post - Router

//! Profil
Route::get('/{lang}/user/profile', [Web::class,'UserProfile']) -> name("web.user.profile"); //! Web - Kullanıcı - Profil
Route::post('/user/profile/edit', [Web::class,'UserProfileEdit']) -> name("web.user.profile.edit"); //! Web - Kullanıcı - Profil - Güncelleme
Route::post('/user/settings/password/edit', [Web::class,'UserSettingsPasswordEdit']) -> name("web.user.settings.password.edit"); //! Web - Kullanıcı - Şifre - Güncelleme

//! İstek Listesi
Route::get('/{lang}/user/wishlist', [Web::class,'UserWishlist']) -> name("web.wishlist"); //! Web - Kullanıcı - İstek Listesi
Route::post('/user/wishlist/add/post', [Web::class,'UserWishAddPost']) -> name("web.user.wishlist.add.post"); //! Web Kullanıcı İstek Listesi Ekle - Post
Route::post('/user/wishlist/delete/post', [Web::class,'UserWishDeletePost']) -> name("web.user.wishlist.delete.post"); //! Web Kullanıcı İstek Listesi Sil- Post
Route::get('/{lang}/user/wishlist/all/delete', [Web::class,'UserWishAllDelete']) -> name("web.user.wishlist.all.delete"); //! Web Kullanıcı İstek Listesi - Tümü Sil
Route::get('/{lang}/user/wishlist/all/cart/add', [Web::class,'UserWishAllCartAdd']) -> name("web.user.wishlist.all.cart.add"); //! Web Kullanıcı İstek Listesi - Tümü Sepette Ekle

//! Sepet 
Route::get('/{lang}/user/cart', [Web::class,'UserCart']) -> name("web.cart"); //! Web - Kullanıcı Sepet
Route::post('/user/cart/add/post', [Web::class,'UserCartAddPost']) -> name("web.user.cart.add.post"); //! Web Kullanıcı Sepet Ekle - Post
Route::post('/user/cart/delete/post', [Web::class,'UserCartDeletePost']) -> name("web.user.cart.delete.post"); //! Web Kullanıcı Sepet Sil- Post
Route::get('/{lang}/user/cart/delete/all', [Web::class,'UserCartDeleteAll']) -> name("web.user.cart.delete.all"); //! Web Kullanıcı Sepet Tümü Sil
Route::post('/user/cart/edit/post', [Web::class,'UserCartEditPost']) -> name("web.user.cart.edit.post"); //! Web Kullanıcı Sepet Güncelleme- Post

//! Sipariş
Route::post('/user/order/add/post', [Web::class,'UserOrderAddPost']) -> name("web.user.order.add.post"); //! Web Kullanıcı Sipariş Ekle - Post

Route::get('/{lang}/user/checkout', [Web::class,'UserCheckout']) -> name("web.user.checkout"); //! Web - Kullanıcı - Checkout


//************* Admin Test  ***************** */

//! Test
Route::get('/{lang}/admin/test', [Admin::class,'Test']) -> name("admin.test"); //! Admin Test
Route::get('/{lang}/admin/test/1', [Admin::class,'TestFirst']) -> name("admin.test.first"); //! Admin Test 1

Route::get('/{lang}/admin/test/view', [Admin::class,'TestView']) -> name("admin.test.view"); //! Admin Test View

//************* Admin  ***************** */

//! Anasayfa
Route::get('/{lang}/admin', [Admin::class,'Index']) -> name("admin.index"); //! Admin - Anasayfa

//************* Admin İşlemleri  ***************** */

//! Giriş
Route::get('/{lang}/admin/login', [Admin::class,'Login']) -> name("admin.login"); //! Admin Giriş
Route::post('/admin/login/control', [Admin::class,'LoginControl']) -> name("admin.login.control"); //! Admin Giriş Kontrol

//! Kaydol
Route::get('/{lang}/admin/register', [Admin::class,'Register']) -> name("admin.register"); //! Admin Kayıt
Route::post('/admin/register/control', [Admin::class,'RegisterControl']) -> name("admin.register.control"); //! Admin Kayıt Kontrol

//! Şifremi Unuttum
Route::get('/{lang}/admin/forgot/password', [Admin::class,'ForgotPassword']) -> name("admin.forgot.password"); //! Admin Şifremi Unuttum
Route::post('/admin/forgot/password/control', [Admin::class,'ForgotPasswordControl']) -> name("admin.forgot.password.control"); //! Admin Şifremi Unuttum Kontrol

//! Şifremi Yenile
Route::get('/{lang}/admin/reset/password', [Admin::class,'ResetPassword']) -> name("admin.reset.password"); //! Admin Şifremi Yenile
Route::post('/admin/reset/password/control', [Admin::class,'ResetPasswordControl']) -> name("admin.reset.password.control"); //! Admin Şifremi Yenile Kontrol

//! Admin List
Route::get('/{lang}/admin/list', [Admin::class,'AdminList']) -> name("admin.list");  //! Tüm Veriler
Route::get('/{lang}/admin/info/{id}', [Admin::class,'AdminInfoView']) -> name("admin.info");  //! Veri Arama - Sayfası
Route::post('/admin/search/post', [Admin::class,'AdminSearchPost']) -> name("admin.search.post"); //! Veri Arama - Post
Route::post('/admin/add/post', [Admin::class,'AdminAddPost']) -> name("admin.add.post"); //! Veri Ekleme - Post
Route::post('/admin/delete/post', [Admin::class,'AdminDeletePost']) -> name("admin.delete.post"); //! Veri Silme
Route::post('/admin/delete/post/multi', [Admin::class,'AdminDeletePostMulti']) -> name("admin.delete.post.multi"); //! Veri Çoklu Silme - Post
Route::post('/admin/edit/post', [Admin::class,'AdminEditPost']) -> name("admin.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/edit/password', [Admin::class,'AdminEditPassword']) -> name("admin.edit.password"); //! Veri Güncelle - Password
Route::post('/admin/edit/email', [Admin::class,'AdminEditEmail']) -> name("admin.edit.email"); //! Veri Güncelle - Email
Route::post('/admin/edit/imgUrl', [Admin::class,'AdminEditImgUrl']) -> name("admin.edit.imgUrl"); //! Veri Güncelle - ImgUrl
Route::post('/admin/edit/active', [Admin::class,'AdminEditActive']) -> name("admin.edit.active"); //! Veri Durum Güncelle - Post
Route::post('/admin/edit/multi/active', [Admin::class,'AdminEditMultiActive']) -> name("admin.edit.multi.active"); //! Çoklu Veri Durum Güncelle - Post

/************* Admin - Ayarlar - LocalStorage ***************** */

Route::post('/setting/local/storage/read', [Admin::class,'settingLocalStorage']) -> name("setting.local.storage.read"); //! LocalStorage içinde Verileri alıyor

//************* Admin - Ayarlar - Menu  ***************** */

//! Ayarlar - Menu
Route::get('/{lang}/admin/setting/menu', [Admin::class,'SettingMenu']) -> name("settings.menu");  //! Tüm Veriler
Route::post('/admin/setting/menu/search/post', [Admin::class,'SettingMenuSearchPost']) -> name("settings.menu.search.post"); //! Veri Arama - Post
Route::post('/admin/setting/menu/add/post', [Admin::class,'SettingMenuAddPost']) -> name("settings.menu.add.post"); //! Veri Ekleme - Post
Route::post('/admin/setting/menu/delete/post', [Admin::class,'SettingMenuDeletePost']) -> name("settings.menu.delete.post"); //! Veri Silme
Route::post('/admin/setting/menu/delete/post/multi', [Admin::class,'SettingMenuDeletePostMulti']) -> name("settings.menu.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::post('/admin/setting/menu/edit/post', [Admin::class,'SettingMenuEditPost']) -> name("settings.menu.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/setting/menu/edit/active', [Admin::class,'SettingMenuEditActive']) -> name("settings.menu.edit.active"); //! Veri Durum Güncelle - Post
Route::post('/admin/setting/menu/edit/multi/active', [Admin::class,'SettingMenuEditMultiActive']) -> name("settings.menu.edit.multi.active"); //! Çoklu Veri Durum Güncelle - Post
Route::post('/admin/setting/menu/order/post', [Admin::class,'SettingMenuOrderPost']) -> name("settings.menu.order.post"); //! Veri Sıralama - Post
Route::post('/admin/setting/menu/clone', [Admin::class,'SettingMenuClonePost']) -> name("settings.menu.clone.post"); //! Veri Clone - Post
Route::post('/admin/setting/menu/clone/multi', [Admin::class,'SettingMenuClonePostMulti']) -> name("settings.menu.clone.post.multi"); //! Çoklu Veri Clone - Post

//*************  Ayarlar - Log  ***************** */

//! Ayarlar - Log
Route::get('/{lang}/admin/setting/log', [Admin::class,'SettingLog']) -> name("settings.log");  //! Tüm Veriler
Route::get('/{lang}/admin/setting/log/search/{id}', [Admin::class,'SettingLogSearchView']) -> name("settings.log.search.view");  //! Veri Arama - Sayfası
Route::post('/admin/setting/log/search/post', [Admin::class,'SettingLogSearchPost']) -> name("settings.log.search.post"); //! Veri Arama - Post
Route::get('/{lang}/admin/setting/log/add', [Admin::class,'SettingLogAddView']) -> name("settings.log.add");  //! Veri Ekleme - Sayfası
Route::post('/admin/setting/log/delete/post', [Admin::class,'SettingLogDeletePost']) -> name("settings.log.delete.post"); //! Veri Silme
Route::post('/admin/setting/log/delete/post/multi', [Admin::class,'SettingLogDeletePostMulti']) -> name("settings.log.delete.post.multi"); //! Veri Çoklu Silme - Post
Route::post('/admin/setting/log/clone', [Admin::class,'SettingLogClonePost']) -> name("settings.log.clone.post"); //! Veri Clone - Post
Route::post('/admin/setting/log/clone/multi', [Admin::class,'SettingLogClonePostMulti']) -> name("settings.log.clone.post.multi"); //! Çoklu Veri Clone - Post

//************* Admin - Ayarlar - Role  ***************** */

//! Ayarlar - Role
Route::get('/{lang}/admin/setting/role', [Admin::class,'SettingRole']) -> name("settings.role");  //! Tüm Veriler
Route::post('/admin/setting/role/search/post', [Admin::class,'SettingRoleSearchPost']) -> name("settings.role.search.post"); //! Veri Arama - Post
Route::post('/admin/setting/role/add/post', [Admin::class,'SettingRoleAddPost']) -> name("settings.role.add.post"); //! Veri Ekleme - Post
Route::post('/admin/setting/role/delete/post', [Admin::class,'SettingRoleDeletePost']) -> name("settings.role.delete.post"); //! Veri Silme
Route::post('/admin/setting/role/delete/post/multi', [Admin::class,'SettingRoleDeletePostMulti']) -> name("settings.role.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::post('/admin/setting/role/edit/post', [Admin::class,'SettingRoleEditPost']) -> name("settings.role.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/setting/role/clone', [Admin::class,'SettingRoleClonePost']) -> name("settings.role.clone.post"); //! Veri Clone - Post
Route::post('/admin/setting/role/clone/multi', [Admin::class,'SettingRoleClonePostMulti']) -> name("settings.role.clone.post.multi"); //! Çoklu Veri Clone - Post

//************* Admin - Ayarlar - Departman  ***************** */

//! Ayarlar - Departman
Route::get('/{lang}/admin/setting/department', [Admin::class,'SettingDepartment']) -> name("settings.department");  //! Tüm Veriler
Route::post('/admin/setting/department/search/post', [Admin::class,'SettingDepartmentSearchPost']) -> name("settings.department.search.post"); //! Veri Arama - Post
Route::post('/admin/setting/department/add/post', [Admin::class,'SettingDepartmentAddPost']) -> name("settings.department.add.post"); //! Veri Ekleme - Post
Route::post('/admin/setting/department/delete/post', [Admin::class,'SettingDepartmentDeletePost']) -> name("settings.department.delete.post"); //! Veri Silme
Route::post('/admin/setting/department/delete/post/multi', [Admin::class,'SettingDepartmentDeletePostMulti']) -> name("settings.department.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::post('/admin/setting/department/edit/post', [Admin::class,'SettingDepartmentEditPost']) -> name("settings.department.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/setting/department/clone', [Admin::class,'SettingDepartmentClonePost']) -> name("settings.department.clone.post"); //! Veri Clone - Post
Route::post('/admin/setting/department/clone/multi', [Admin::class,'SettingDepartmentClonePostMulti']) -> name("settings.department.clone.post.multi"); //! Çoklu Veri Clone - Post

//************* Admin - Web  ***************** */

//! Web Ayarları
Route::get('/{lang}/admin/web/settings', [Admin::class,'WebSetting']) -> name("admin.web.settings");  //! Web Ayarları
Route::post('/admin/web/settings/post', [Admin::class,'WebSettingPost']) -> name("admin.web.settings.post");  //! Web Ayarları Post
Route::post('/admin/web/settings/social/media/post', [Admin::class,'WebSocailMediaSettingPost']) -> name("admin.web.settings.social.media.post");  //! Web - Sosyal Medya Post
Route::post('/admin/web/settings/seo/post', [Admin::class,'WebSeoSettingPost']) -> name("admin.web.settings.seo.post");  //! Web - Seo Post

//! Kurumsal Sayfalar
Route::get('/{lang}/admin/institutional/about', [Admin::class,'InstitutionalControl']) -> name("admin.web.institutional.about");  //!  Kurumsal - Hakkımızda
Route::get('/{lang}/admin/institutional/cookiePolicy', [Admin::class,'InstitutionalControl']) -> name("admin.web.institutional.cookiePolicy");  //!  Kurumsal - Çerez Politikası
Route::get('/{lang}/admin/institutional/termsOfUse', [Admin::class,'InstitutionalControl']) -> name("admin.web.institutional.termsOfUse");  //!  Kurumsal - Kullanım Koşulları
Route::get('/{lang}/admin/institutional/termsOfConditions', [Admin::class,'InstitutionalControl']) -> name("admin.web.institutional.termsOfConditions");  //!  Kurumsal - Kullanım Şartları
Route::get('/{lang}/admin/institutional/privacyPolicy', [Admin::class,'InstitutionalControl']) -> name("admin.web.institutional.privacyPolicy");  //!  Kurumsal - Gizlilik Politikası
Route::get('/{lang}/admin/institutional/personalDataProtectionLaw', [Admin::class,'InstitutionalControl']) -> name("admin.web.institutional.personalDataProtectionLaw");  //!  Kurumsal - Kişisel Verilerin Korunma Kanunu
Route::post('/admin/institutional/edit/post', [Admin::class,'InstitutionalEdit']) -> name("admin.web.institutional.edit");  //!  Kurumsal - Güncelleme
Route::post('/admin/institutional/edit/img/post', [Admin::class,'InstitutionalEditImage']) -> name("admin.web.institutional.edit.img");  //!  Kurumsal - Güncelleme Resim

//! Kurumsal - Referanslar
Route::get('/{lang}/admin/institutional/references', [Admin::class,'InstitutionalReferences']) -> name("admin.web.institutional.references.list");  //! Tüm Veriler
Route::post('/admin/institutional/references/search/post', [Admin::class,'InstitutionalReferencesSearchPost']) -> name("admin.web.institutional.references.search.post"); //! Veri Arama - Post
Route::post('/admin/institutional/references/add/post', [Admin::class,'InstitutionalReferencesAddPost']) -> name("admin.web.institutional.references.add.post"); //! Veri Ekleme - Post
Route::post('/admin/institutional/references/delete/post', [Admin::class,'InstitutionalReferencesDeletePost']) -> name("admin.web.institutional.references.delete.post"); //! Veri Silme
Route::post('/admin/institutional/references/delete/post/multi', [Admin::class,'InstitutionalReferencesDeletePostMulti']) -> name("admin.web.institutional.references.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::post('/admin/institutional/references/edit/post', [Admin::class,'InstitutionalReferencesEditPost']) -> name("admin.web.institutional.references.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/institutional/references/edit/active', [Admin::class,'InstitutionalReferencesEditActive']) -> name("admin.web.institutional.references.edit.active"); //! Veri Durum Güncelle - Post
Route::post('/admin/institutional/references/edit/multi/active', [Admin::class,'InstitutionalReferencesEditMultiActive']) -> name("admin.web.institutional.references.detail.edit.multi.active"); //! Çoklu Veri Durum Güncelle - Post
Route::post('/admin/institutional/references/clone', [Admin::class,'InstitutionalReferencesClonePost']) -> name("admin.web.institutional.references.clone.post"); //! Veri Clone - Post
Route::post('/admin/institutional/references/clone/multi', [Admin::class,'InstitutionalReferencesClonePostMulti']) -> name("admin.web.institutional.references.clone.post.multi"); //! Çoklu Veri Clone - Post


//************* Admin - Web - Faq - Sıkça Sorulan Sorular ***************** */

//! Faq - Sıkça Sorulan Sorular - Kategori
Route::get('/{lang}/admin/faq/category', [Admin::class,'FaqCategory']) -> name("admin.web.faq.category.list");  //! Tüm Veriler
Route::post('/admin/faq/category/search/post', [Admin::class,'FaqCategorySearchPost']) -> name("admin.web.faq.category.search.post"); //! Veri Arama - Post
Route::post('/admin/faq/category/add/post', [Admin::class,'FaqCategoryAddPost']) -> name("admin.web.faq.category.add.post"); //! Veri Ekleme - Post
Route::post('/admin/faq/category/delete/post', [Admin::class,'FaqCategoryDeletePost']) -> name("admin.web.faq.category.delete.post"); //! Veri Silme
Route::post('/admin/faq/category/delete/post/multi', [Admin::class,'FaqCategoryDeletePostMulti']) -> name("admin.web.faq.category.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::post('/admin/faq/category/edit/post', [Admin::class,'FaqCategoryEditPost']) -> name("admin.web.faq.category.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/faq/category/edit/active', [Admin::class,'FaqCategoryEditActive']) -> name("admin.web.faq.category.edit.active"); //! Veri Durum Güncelle - Post
Route::post('/admin/faq/category/edit/multi/active', [Admin::class,'FaqCategoryEditMultiActive']) -> name("admin.web.faq.category.detail.edit.multi.active"); //! Çoklu Veri Durum Güncelle - Post
Route::post('/admin/faq/category/clone', [Admin::class,'FaqCategoryClonePost']) -> name("admin.web.faq.category.clone.post"); //! Veri Clone - Post
Route::post('/admin/faq/category/clone/multi', [Admin::class,'FaqCategoryClonePostMulti']) -> name("admin.web.faq.category.clone.post.multi"); //! Çoklu Veri Clone - Post

//! Faq - Sıkça Sorulan Sorular
Route::get('/{lang}/admin/faq/list', [Admin::class,'FaqList']) -> name("admin.web.faq.list");  //! Tüm Veriler
Route::post('/admin/faq/search/post', [Admin::class,'FaqSearchPost']) -> name("admin.web.faq.search.post"); //! Veri Arama - Post
Route::get('/{lang}/admin/faq/add', [Admin::class,'FaqAddView']) -> name("admin.web.faq.add");  //! Veri Ekleme - Sayfası
Route::post('/admin/faq/add/post', [Admin::class,'FaqAddPost']) -> name("admin.web.faq.add.post"); //! Veri Ekleme - Post
Route::post('/admin/faq/delete/post', [Admin::class,'FaqDeletePost']) -> name("admin.web.faq.delete.post"); //! Veri Silme
Route::post('/admin/faq/delete/post/multi', [Admin::class,'FaqDeletePostMulti']) -> name("admin.web.faq.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::get('/{lang}/admin/faq/edit/{id}', [Admin::class,'FaqEdit']) -> name("admin.web.faq.edit.view");  //! Veri Güncelle - Sayfa
Route::post('/admin/faq/edit/post', [Admin::class,'FaqEditPost']) -> name("admin.web.faq.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/faq/edit/info/post', [Admin::class,'FaqEditInfoPost']) -> name("admin.web.faq.edit.info.post"); //! Veri Bilgileri Güncelle - Post
Route::post('/admin/faq/edit/active', [Admin::class,'FaqEditActive']) -> name("admin.web.faq.edit.active"); //! Veri Durum Güncelle - Post
Route::post('/admin/faq/edit/multi/active', [Admin::class,'FaqEditMultiActive']) -> name("admin.web.faq.detail.edit.multi.active"); //! Çoklu Veri Durum Güncelle - Post
Route::post('/admin/faq/clone', [Admin::class,'FaqClonePost']) -> name("admin.web.faq.clone.post"); //! Veri Clone - Post
Route::post('/admin/faq/clone/multi', [Admin::class,'FaqClonePostMulti']) -> name("admin.web.faq.clone.post.multi"); //! Çoklu Veri Clone - Post

//! İletişim - Mesaj Gönderme
Route::get('/{lang}/admin/contact/message', [Admin::class,'ContactMessage']) -> name("admin.web.contact.message");  //! Tüm Veriler
Route::post('/admin/contact/message/search/post', [Admin::class,'ContactMessageSearchPost']) -> name("admin.web.contact.message.search.post"); //! Veri Arama - Post
Route::post('/admin/contact/message/add/post', [Admin::class,'ContactMessageAddPost']) -> name("admin.web.contact.message.add.post"); //! Veri Ekleme - Post
Route::post('/admin/contact/message/delete/post', [Admin::class,'ContactMessageDeletePost']) -> name("admin.web.contact.message.delete.post"); //! Veri Silme
Route::post('/admin/contact/message/delete/post/multi', [Admin::class,'ContactMessageDeletePostMulti']) -> name("admin.web.contact.message.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::post('/admin/contact/message/edit/post', [Admin::class,'ContactMessageEditPost']) -> name("admin.web.contact.message.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/contact/message/clone', [Admin::class,'ContactMessageClonePost']) -> name("admin.web.contact.message.clone.post"); //! Veri Clone - Post
Route::post('/admin/contact/message/clone/multi', [Admin::class,'ContactMessageClonePostMulti']) -> name("admin.web.contact.message.clone.post.multi"); //! Çoklu Veri Clone - Post

//! Abone Ol
Route::get('/{lang}/admin/subscribe', [Admin::class,'Subscribe']) -> name("admin.web.subscribe");  //! Tüm Veriler
Route::post('/admin/subscribe/search/post', [Admin::class,'SubscribeSearchPost']) -> name("admin.web.subscribe.search.post"); //! Veri Arama - Post
Route::post('/admin/subscribe/add/post', [Admin::class,'SubscribeAddPost']) -> name("admin.web.subscribe.add.post"); //! Veri Ekleme - Post
Route::post('/admin/subscribe/delete/post', [Admin::class,'SubscribeDeletePost']) -> name("admin.web.subscribe.delete.post"); //! Veri Silme
Route::post('/admin/subscribe/delete/post/multi', [Admin::class,'SubscribeDeletePostMulti']) -> name("admin.web.subscribe.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::post('/admin/subscribe/edit/post', [Admin::class,'SubscribeEditPost']) -> name("admin.web.subscribe.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/subscribe/edit/active', [Admin::class,'SubscribeEditActive']) -> name("admin.web.subscribe.edit.active"); //! Veri Durum Güncelle - Post
Route::post('/admin/subscribe/edit/multi/active', [Admin::class,'SubscribeEditMultiActive']) -> name("admin.web.subscribe.edit.multi.active"); //! Çoklu Veri Durum Güncelle - Post
Route::post('/admin/subscribe/clone', [Admin::class,'SubscribeClonePost']) -> name("admin.web.subscribe.clone.post"); //! Veri Clone - Post
Route::post('/admin/subscribe/clone/multi', [Admin::class,'SubscribeClonePostMulti']) -> name("admin.web.subscribe.clone.post.multi"); //! Çoklu Veri Clone - Post

//! Slider
Route::get('/{lang}/admin/slider/list', [Admin::class,'SliderList']) -> name("admin.web.slider.list");  //! Tüm Veriler
Route::post('/admin/slider/search/post', [Admin::class,'SliderSearchPost']) -> name("admin.web.slider.search.post"); //! Veri Arama - Post
Route::get('/{lang}/admin/slider/add', [Admin::class,'SliderAddView']) -> name("admin.web.slider.add");  //! Veri Ekleme - Sayfası
Route::post('/admin/slider/add/post', [Admin::class,'SliderAddPost']) -> name("admin.web.slider.add.post"); //! Veri Ekleme - Post
Route::post('/admin/slider/delete/post', [Admin::class,'SliderDeletePost']) -> name("admin.web.slider.delete.post"); //! Veri Silme
Route::post('/admin/slider/delete/post/multi', [Admin::class,'SliderDeletePostMulti']) -> name("admin.web.slider.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::get('/{lang}/admin/slider/edit/{id}', [Admin::class,'SliderEdit']) -> name("admin.web.slider.edit.view");  //! Veri Güncelle - Sayfa
Route::post('/admin/slider/edit/post', [Admin::class,'SliderEditPost']) -> name("admin.web.slider.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/slider/edit/img/post', [Admin::class,'SliderEditImagePost']) -> name("admin.web.slider.edit.img.post"); //! Veri Resim Güncelle - Post
Route::post('/admin/slider/edit/active', [Admin::class,'SliderEditActive']) -> name("admin.web.slider.edit.active"); //! Veri Durum Güncelle - Post
Route::post('/admin/slider/edit/multi/active', [Admin::class,'SliderEditMultiActive']) -> name("admin.web.slider.detail.edit.multi.active"); //! Çoklu Veri Durum Güncelle - Post
Route::post('/admin/slider/clone', [Admin::class,'SliderClonePost']) -> name("admin.web.slider.clone.post"); //! Veri Clone - Post
Route::post('/admin/slider/clone/multi', [Admin::class,'SliderClonePostMulti']) -> name("admin.web.slider.clone.post.multi"); //! Çoklu Veri Clone - Post

//************* Admin - Web User List  ***************** */

//! Admin - Web User List 
Route::get('/{lang}/admin/web/user/list', [Admin::class,'AdminWebUserList']) -> name("admin.web.user.list");  //! Tüm Veriler
Route::get('/{lang}/admin/web/user/info/{id}', [Admin::class,'AdminWebUserInfoView']) -> name("admin.web.user.info");  //! Veri Arama - Sayfası
Route::post('/admin/web/user/search/post', [Admin::class,'AdminWebUserSearchPost']) -> name("admin.web.user.search.post"); //! Veri Arama - Post
Route::post('/admin/web/user/add/post', [Admin::class,'AdminWebUserAddPost']) -> name("admin.web.user.add.post"); //! Veri Ekleme - Post
Route::post('/admin/web/user/delete/post', [Admin::class,'AdminWebUserDeletePost']) -> name("admin.web.user.delete.post"); //! Veri Silme
Route::post('/admin/web/user/delete/post/multi', [Admin::class,'AdminWebUserDeletePostMulti']) -> name("admin.web.user.delete.post.multi"); //! Veri Çoklu Silme - Post
Route::post('/admin/web/user/edit/post', [Admin::class,'AdminWebUserEditPost']) -> name("admin.web.user.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/web/user/edit/password', [Admin::class,'AdminWebUserEditPassword']) -> name("admin.web.user.edit.password"); //! Veri Güncelle - Password
Route::post('/admin/web/user/edit/email', [Admin::class,'AdminWebUserEditEmail']) -> name("admin.web.user.edit.email"); //! Veri Güncelle - Email
Route::post('/admin/web/user/edit/imgUrl', [Admin::class,'AdminWebUserEditImgUrl']) -> name("admin.web.user.edit.imgUrl"); //! Veri Güncelle - ImgUrl
Route::post('/admin/web/user/edit/active', [Admin::class,'AdminWebUserEditActive']) -> name("admin.web.user.edit.active"); //! Veri Durum Güncelle - Post
Route::post('/admin/web/user/edit/multi/active', [Admin::class,'AdminWebUserEditMultiActive']) -> name("admin.web.user.edit.multi.active"); //! Çoklu Veri Durum Güncelle - Post

//************* Admin - Kullanıcı Ürün İşlemleri ***************** */

//! Admin - Web User - Sepet
Route::get('/{lang}/admin/web/user/cart', [Admin::class,'AdminWebUserCartList']) -> name("admin.web.user.cart.list");  //! Tüm Veriler
Route::post('/admin/web/user/cart/search/post', [Admin::class,'AdminWebUserCartSearchPost']) -> name("admin.web.user.cart.search.post"); //! Veri Arama - Post
Route::post('/admin/web/user/cart/add/post', [Admin::class,'AdminWebUserCartAddPost']) -> name("admin.web.user.cart.add.post"); //! Veri Ekleme - Post
Route::post('/admin/web/user/cart/delete/post', [Admin::class,'AdminWebUserCartDeletePost']) -> name("admin.web.user.cart.delete.post"); //! Veri Silme
Route::post('/admin/web/user/cart/delete/post/multi', [Admin::class,'AdminWebUserCartDeletePostMulti']) -> name("admin.web.user.cart.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::post('/admin/web/user/cart/edit/post', [Admin::class,'AdminWebUserCartEditPost']) -> name("admin.web.user.cart.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/web/user/cart/clone', [Admin::class,'AdminWebUserCartClonePost']) -> name("admin.web.user.cart.clone.post"); //! Veri Clone - Post
Route::post('/admin/web/user/cart/clone/multi', [Admin::class,'AdminWebUserCartClonePostMulti']) -> name("admin.web.user.cart.clone.post.multi"); //! Çoklu Veri Clone - Post

//! Admin - Web User  - İstek Listesi
Route::get('/{lang}/admin/web/user/wish', [Admin::class,'AdminWebUserWishList']) -> name("admin.web.user.wish.list");  //! Tüm Veriler
Route::post('/admin/web/user/wish/search/post', [Admin::class,'AdminWebUserWishSearchPost']) -> name("admin.web.user.wish.search.post"); //! Veri Arama - Post
Route::post('/admin/web/user/wish/add/post', [Admin::class,'AdminWebUserWishAddPost']) -> name("admin.web.user.wish.add.post"); //! Veri Ekleme - Post
Route::post('/admin/web/user/wish/delete/post', [Admin::class,'AdminWebUserWishDeletePost']) -> name("admin.web.user.wish.delete.post"); //! Veri Silme
Route::post('/admin/web/user/wish/delete/post/multi', [Admin::class,'AdminWebUserWishDeletePostMulti']) -> name("admin.web.user.wish.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::post('/admin/web/user/wish/edit/post', [Admin::class,'AdminWebUserWishEditPost']) -> name("admin.web.user.wish.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/web/user/wish/clone', [Admin::class,'AdminWebUserWishClonePost']) -> name("admin.web.user.wish.clone.post"); //! Veri Clone - Post
Route::post('/admin/web/user/wish/clone/multi', [Admin::class,'AdminWebUserWishClonePostMulti']) -> name("admin.web.user.wish.clone.post.multi"); //! Çoklu Veri Clone - Post

//! Admin - Web User  - Sipariş Listesi
Route::get('/{lang}/admin/web/user/order', [Admin::class,'AdminWebUserOrderList']) -> name("admin.web.user.order.list");  //! Tüm Veriler
Route::post('/admin/web/user/order/search/post', [Admin::class,'AdminWebUserOrderSearchPost']) -> name("admin.web.user.order.search.post"); //! Veri Arama - Post
Route::post('/admin/web/user/order/add/post', [Admin::class,'AdminWebUserOrderAddPost']) -> name("admin.web.user.order.add.post"); //! Veri Ekleme - Post
Route::post('/admin/web/user/order/delete/post', [Admin::class,'AdminWebUserOrderDeletePost']) -> name("admin.web.user.order.delete.post"); //! Veri Silme
Route::post('/admin/web/user/order/delete/post/multi', [Admin::class,'AdminWebUserOrderDeletePostMulti']) -> name("admin.web.user.order.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::post('/admin/web/user/order/edit/post', [Admin::class,'AdminWebUserOrderEditPost']) -> name("admin.web.user.order.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/web/user/order/clone', [Admin::class,'AdminWebUserOrderClonePost']) -> name("admin.web.user.order.clone.post"); //! Veri Clone - Post
Route::post('/admin/web/user/order/clone/multi', [Admin::class,'AdminWebUserOrderClonePostMulti']) -> name("admin.web.user.order.clone.post.multi"); //! Çoklu Veri Clone - Post


//! Admin - Web User  - Sipariş Ürünler Listesi
Route::get('/{lang}/admin/web/user/order/product', [Admin::class,'AdminWebUserOrderProductList']) -> name("admin.web.user.order.product.list");  //! Tüm Veriler
Route::post('/admin/web/user/order/product/search/post', [Admin::class,'AdminWebUserOrderProductSearchPost']) -> name("admin.web.user.order.product.search.post"); //! Veri Arama - Post
Route::post('/admin/web/user/order/product/add/post', [Admin::class,'AdminWebUserOrderProductAddPost']) -> name("admin.web.user.order.product.add.post"); //! Veri Ekleme - Post
Route::post('/admin/web/user/order/product/delete/post', [Admin::class,'AdminWebUserOrderProductDeletePost']) -> name("admin.web.user.order.product.delete.post"); //! Veri Silme
Route::post('/admin/web/user/order/product/delete/post/multi', [Admin::class,'AdminWebUserOrderProductDeletePostMulti']) -> name("admin.web.user.order.product.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::post('/admin/web/user/order/product/edit/post', [Admin::class,'AdminWebUserOrderProductEditPost']) -> name("admin.web.user.order.product.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/web/user/order/product/clone', [Admin::class,'AdminWebUserOrderProductClonePost']) -> name("admin.web.user.order.product.clone.post"); //! Veri Clone - Post
Route::post('/admin/web/user/order/product/clone/multi', [Admin::class,'AdminWebUserOrderProductClonePostMulti']) -> name("admin.web.user.order.product.clone.post.multi"); //! Çoklu Veri Clone - Post


//************* Admin - Web - Blog ***************** */

//! Blog - Kategori
Route::get('/{lang}/admin/blog/category', [Admin::class,'BlogCategory']) -> name("admin.web.blog.category.list");  //! Tüm Veriler
Route::post('/admin/blog/category/search/post', [Admin::class,'BlogCategorySearchPost']) -> name("admin.web.blog.category.search.post"); //! Veri Arama - Post
Route::post('/admin/blog/category/add/post', [Admin::class,'BlogCategoryAddPost']) -> name("admin.web.blog.category.add.post"); //! Veri Ekleme - Post
Route::post('/admin/blog/category/delete/post', [Admin::class,'BlogCategoryDeletePost']) -> name("admin.web.blog.category.delete.post"); //! Veri Silme
Route::post('/admin/blog/category/delete/post/multi', [Admin::class,'BlogCategoryDeletePostMulti']) -> name("admin.web.blog.category.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::post('/admin/blog/category/edit/post', [Admin::class,'BlogCategoryEditPost']) -> name("admin.web.blog.category.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/blog/category/edit/active', [Admin::class,'BlogCategoryEditActive']) -> name("admin.web.blog.category.edit.active"); //! Veri Durum Güncelle - Post
Route::post('/admin/blog/category/edit/multi/active', [Admin::class,'BlogCategoryEditMultiActive']) -> name("admin.web.blog.category.detail.edit.multi.active"); //! Çoklu Veri Durum Güncelle - Post
Route::post('/admin/blog/category/clone', [Admin::class,'BlogCategoryClonePost']) -> name("admin.web.blog.category.clone.post"); //! Veri Clone - Post
Route::post('/admin/blog/category/clone/multi', [Admin::class,'BlogCategoryClonePostMulti']) -> name("admin.web.blog.category.clone.post.multi"); //! Çoklu Veri Clone - Post

//! Blog
Route::get('/{lang}/admin/blog/list', [Admin::class,'BlogList']) -> name("admin.web.blog.list");  //! Tüm Veriler
Route::post('/admin/blog/search/post', [Admin::class,'BlogSearchPost']) -> name("admin.web.blog.search.post"); //! Veri Arama - Post
Route::get('/{lang}/admin/blog/add', [Admin::class,'BlogAddView']) -> name("admin.web.blog.add");  //! Veri Ekleme - Sayfası
Route::post('/admin/blog/add/post', [Admin::class,'BlogAddPost']) -> name("admin.web.blog.add.post"); //! Veri Ekleme - Post
Route::post('/admin/blog/delete/post', [Admin::class,'BlogDeletePost']) -> name("admin.web.blog.delete.post"); //! Veri Silme
Route::post('/admin/blog/delete/post/multi', [Admin::class,'BlogDeletePostMulti']) -> name("admin.web.blog.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::get('/{lang}/admin/blog/edit/{id}', [Admin::class,'BlogEdit']) -> name("admin.web.blog.edit.view");  //! Veri Güncelle - Sayfa
Route::post('/admin/blog/edit/post', [Admin::class,'BlogEditPost']) -> name("admin.web.blog.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/blog/edit/info/post', [Admin::class,'BlogEditInfoPost']) -> name("admin.web.blog.edit.info.post"); //! Veri Bilgileri Güncelle - Post
Route::post('/admin/blog/edit/active', [Admin::class,'BlogEditActive']) -> name("admin.web.blog.edit.active"); //! Veri Durum Güncelle - Post
Route::post('/admin/blog/edit/multi/active', [Admin::class,'BlogEditMultiActive']) -> name("admin.web.blog.detail.edit.multi.active"); //! Çoklu Veri Durum Güncelle - Post
Route::post('/admin/blog/clone', [Admin::class,'BlogClonePost']) -> name("admin.web.blog.clone.post"); //! Veri Clone - Post
Route::post('/admin/blog/clone/multi', [Admin::class,'BlogClonePostMulti']) -> name("admin.web.blog.clone.post.multi"); //! Çoklu Veri Clone - Post

//! Blog - Yorum
Route::get('/{lang}/admin/blog/comment', [Admin::class,'BlogComment']) -> name("admin.web.blog.comment.list");  //! Tüm Veriler
Route::post('/admin/blog/comment/search/post', [Admin::class,'BlogCommentSearchPost']) -> name("admin.web.blog.comment.search.post"); //! Veri Arama - Post
Route::post('/admin/blog/comment/add/post', [Admin::class,'BlogCommentAddPost']) -> name("admin.web.blog.comment.add.post"); //! Veri Ekleme - Post
Route::post('/admin/blog/comment/delete/post', [Admin::class,'BlogCommentDeletePost']) -> name("admin.web.blog.comment.delete.post"); //! Veri Silme
Route::post('/admin/blog/comment/delete/post/multi', [Admin::class,'BlogCommentDeletePostMulti']) -> name("admin.web.blog.comment.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::post('/admin/blog/comment/edit/post', [Admin::class,'BlogCommentEditPost']) -> name("admin.web.blog.comment.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/blog/comment/edit/active', [Admin::class,'BlogCommentEditActive']) -> name("admin.web.blog.comment.edit.active"); //! Veri Durum Güncelle - Post
Route::post('/admin/blog/comment/edit/multi/active', [Admin::class,'BlogCommentEditMultiActive']) -> name("admin.web.blog.comment.edit.multi.active"); //! Çoklu Veri Durum Güncelle - Post
Route::post('/admin/blog/comment/clone', [Admin::class,'BlogCommentClonePost']) -> name("admin.web.blog.comment.clone.post"); //! Veri Clone - Post
Route::post('/admin/blog/comment/clone/multi', [Admin::class,'BlogCommentClonePostMulti']) -> name("admin.web.blog.comment.clone.post.multi"); //! Çoklu Veri Clone - Post

//************* Admin - Web - Product ***************** */

//! Product - Kategori
Route::get('/{lang}/admin/product/category', [Admin::class,'ProductCategory']) -> name("admin.web.product.category.list");  //! Tüm Veriler
Route::post('/admin/product/category/search/post', [Admin::class,'ProductCategorySearchPost']) -> name("admin.web.product.category.search.post"); //! Veri Arama - Post
Route::post('/admin/product/category/add/post', [Admin::class,'ProductCategoryAddPost']) -> name("admin.web.product.category.add.post"); //! Veri Ekleme - Post
Route::post('/admin/product/category/delete/post', [Admin::class,'ProductCategoryDeletePost']) -> name("admin.web.product.category.delete.post"); //! Veri Silme
Route::post('/admin/product/category/delete/post/multi', [Admin::class,'ProductCategoryDeletePostMulti']) -> name("admin.web.product.category.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::post('/admin/product/category/edit/post', [Admin::class,'ProductCategoryEditPost']) -> name("admin.web.product.category.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/product/category/edit/active', [Admin::class,'ProductCategoryEditActive']) -> name("admin.web.product.category.edit.active"); //! Veri Durum Güncelle - Post
Route::post('/admin/product/category/edit/multi/active', [Admin::class,'ProductCategoryEditMultiActive']) -> name("admin.web.product.category.detail.edit.multi.active"); //! Çoklu Veri Durum Güncelle - Post
Route::post('/admin/product/category/clone', [Admin::class,'ProductCategoryClonePost']) -> name("admin.web.product.category.clone.post"); //! Veri Clone - Post
Route::post('/admin/product/category/clone/multi', [Admin::class,'ProductCategoryClonePostMulti']) -> name("admin.web.product.category.clone.post.multi"); //! Çoklu Veri Clone - Post

//! Product
Route::get('/{lang}/admin/product/list', [Admin::class,'ProductList']) -> name("admin.web.product.list");  //! Tüm Veriler
Route::post('/admin/product/search/post', [Admin::class,'ProductSearchPost']) -> name("admin.web.product.search.post"); //! Veri Arama - Post
Route::get('/{lang}/admin/product/add', [Admin::class,'ProductAddView']) -> name("admin.web.product.add");  //! Veri Ekleme - Sayfası
Route::post('/admin/product/add/post', [Admin::class,'ProductAddPost']) -> name("admin.web.product.add.post"); //! Veri Ekleme - Post
Route::post('/admin/product/delete/post', [Admin::class,'ProductDeletePost']) -> name("admin.web.product.delete.post"); //! Veri Silme
Route::post('/admin/product/delete/post/multi', [Admin::class,'ProductDeletePostMulti']) -> name("admin.web.product.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::get('/{lang}/admin/product/edit/{id}', [Admin::class,'ProductEdit']) -> name("admin.web.product.edit.view");  //! Veri Güncelle - Sayfa
Route::post('/admin/product/edit/post', [Admin::class,'ProductEditPost']) -> name("admin.web.product.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/product/edit/info/post', [Admin::class,'ProductEditInfoPost']) -> name("admin.web.product.edit.info.post"); //! Veri Bilgileri Güncelle - Post
Route::post('/admin/product/edit/active', [Admin::class,'ProductEditActive']) -> name("admin.web.product.edit.active"); //! Veri Durum Güncelle - Post
Route::post('/admin/product/edit/multi/active', [Admin::class,'ProductEditMultiActive']) -> name("admin.web.product.detail.edit.multi.active"); //! Çoklu Veri Durum Güncelle - Post
Route::post('/admin/product/clone', [Admin::class,'ProductClonePost']) -> name("admin.web.product.clone.post"); //! Veri Clone - Post
Route::post('/admin/product/clone/multi', [Admin::class,'ProductClonePostMulti']) -> name("admin.web.product.clone.post.multi"); //! Çoklu Veri Clone - Post

//! Product - Yorum
Route::get('/{lang}/admin/product/comment', [Admin::class,'ProductComment']) -> name("admin.web.product.comment.list");  //! Tüm Veriler
Route::post('/admin/product/comment/search/post', [Admin::class,'ProductCommentSearchPost']) -> name("admin.web.product.comment.search.post"); //! Veri Arama - Post
Route::post('/admin/product/comment/add/post', [Admin::class,'ProductCommentAddPost']) -> name("admin.web.product.comment.add.post"); //! Veri Ekleme - Post
Route::post('/admin/product/comment/delete/post', [Admin::class,'ProductCommentDeletePost']) -> name("admin.web.product.comment.delete.post"); //! Veri Silme
Route::post('/admin/product/comment/delete/post/multi', [Admin::class,'ProductCommentDeletePostMulti']) -> name("admin.web.product.comment.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::post('/admin/product/comment/edit/post', [Admin::class,'ProductCommentEditPost']) -> name("admin.web.product.comment.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/product/comment/edit/active', [Admin::class,'ProductCommentEditActive']) -> name("admin.web.product.comment.edit.active"); //! Veri Durum Güncelle - Post
Route::post('/admin/product/comment/edit/multi/active', [Admin::class,'ProductCommentEditMultiActive']) -> name("admin.web.product.comment.detail.edit.multi.active"); //! Çoklu Veri Durum Güncelle - Post
Route::post('/admin/product/comment/clone', [Admin::class,'ProductCommentClonePost']) -> name("admin.web.product.comment.clone.post"); //! Veri Clone - Post
Route::post('/admin/product/comment/clone/multi', [Admin::class,'ProductCommentClonePostMulti']) -> name("admin.web.product.comment.clone.post.multi"); //! Çoklu Veri Clone - Post

//************* Finans  ***************** */


//! Finans - İşletme Hesap
Route::get('/{lang}/admin/business/account', [Admin::class,'BusinessAccount']) -> name("admin.web.business.account.list");  //! Tüm Veriler
Route::post('/admin/business/account/search/post', [Admin::class,'BusinessAccountSearchPost']) -> name("admin.web.business.account.list.search.post"); //! Veri Arama - Post
Route::post('/admin/business/account/add/post', [Admin::class,'BusinessAccountAddPost']) -> name("admin.web.business.account.list.add.post"); //! Veri Ekleme - Post
Route::post('/admin/business/account/delete/post', [Admin::class,'BusinessAccountDeletePost']) -> name("admin.web.business.account.list.delete.post"); //! Veri Silme
Route::post('/admin/business/account/delete/post/multi', [Admin::class,'BusinessAccountDeletePostMulti']) -> name("admin.web.business.account.list.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::post('/admin/business/account/edit/post', [Admin::class,'BusinessAccountEditPost']) -> name("admin.web.business.account.list.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/business/account/clone', [Admin::class,'BusinessAccountClonePost']) -> name("admin.web.business.account.list.clone.post"); //! Veri Clone - Post
Route::post('/admin/business/account/clone/multi', [Admin::class,'BusinessAccountClonePostMulti']) -> name("admin.web.business.account.list.clone.post.multi"); //! Çoklu Veri Clone - Post

//! Cari Hesap
Route::get('/{lang}/admin/current/account', [Admin::class,'CurrentAccount']) -> name("admin.web.current.account.list");  //! Tüm Veriler
Route::post('/admin/current/account/search/post', [Admin::class,'CurrentAccountSearchPost']) -> name("admin.web.current.account.search.post"); //! Veri Arama - Post
Route::post('/admin/current/account/add/post', [Admin::class,'CurrentAccountAddPost']) -> name("admin.web.current.account.add.post"); //! Veri Ekleme - Post
Route::post('/admin/current/account/delete/post', [Admin::class,'CurrentAccountDeletePost']) -> name("admin.web.current.account.delete.post"); //! Veri Silme
Route::post('/admin/current/account/delete/post/multi', [Admin::class,'CurrentAccountDeletePostMulti']) -> name("admin.web.current.account.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::post('/admin/current/account/edit/post', [Admin::class,'CurrentAccountEditPost']) -> name("admin.web.current.account.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/current/account/clone', [Admin::class,'CurrentAccountClonePost']) -> name("admin.web.current.account.clone.post"); //! Veri Clone - Post
Route::post('/admin/current/account/clone/multi', [Admin::class,'CurrentAccountClonePostMulti']) -> name("admin.web.current.account.clone.post.multi"); //! Çoklu Veri Clone - Post

//! Finans - Cari Hesap - Extra
Route::get('/{lang}/admin/current/account/{id}', [Admin::class,'CurrentAccountFind']) -> name("admin.web.current.account.find");  //! Veri Arama - Sayfa

//! Finans - Kasa Hesap
Route::get('/{lang}/admin/safe/account', [Admin::class,'SafeAccount']) -> name("admin.web.safe.account.list");  //! Tüm Veriler
Route::post('/admin/safe/account/search/post', [Admin::class,'SafeAccountSearchPost']) -> name("admin.web.safe.account.list.search.post"); //! Veri Arama - Post
Route::post('/admin/safe/account/add/post', [Admin::class,'SafeAccountAddPost']) -> name("admin.web.safe.account.list.add.post"); //! Veri Ekleme - Post
Route::post('/admin/safe/account/delete/post', [Admin::class,'SafeAccountDeletePost']) -> name("admin.web.safe.account.list.delete.post"); //! Veri Silme
Route::post('/admin/safe/account/delete/post/multi', [Admin::class,'SafeAccountDeletePostMulti']) -> name("admin.web.safe.account.list.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::post('/admin/safe/account/edit/post', [Admin::class,'SafeAccountEditPost']) -> name("admin.web.safe.account.list.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/safe/account/edit/file/post', [Admin::class,'SafeAccountEditFilePost']) -> name("admin.web.safe.account.list.edit.file.post"); //! Veri Güncelle - Post
Route::post('/admin/safe/account/edit/active', [Admin::class,'SafeAccountEditActive']) -> name("admin.web.safe.account.edit.active"); //! Veri Durum Güncelle - Post
Route::post('/admin/safe/account/edit/multi/active', [Admin::class,'SafeAccountEditMultiActive']) -> name("admin.web.safe.account.edit.multi.active"); //! Çoklu Veri Durum Güncelle - Post
Route::post('/admin/safe/account/clone', [Admin::class,'SafeAccountClonePost']) -> name("admin.web.safe.account.list.clone.post"); //! Veri Clone - Post
Route::post('/admin/safe/account/clone/multi', [Admin::class,'SafeAccountClonePostMulti']) -> name("admin.web.safe.account.list.clone.post.multi"); //! Çoklu Veri Clone - Post

//! Finans - Kasa Hesap - Tür
Route::get('/{lang}/admin/safe/account/income', [Admin::class,'SafeAccountIncome']) -> name("admin.web.safe.account.list.income");  //! Finans - Kasa Hesap - Gelir
Route::get('/{lang}/admin/safe/account/expense', [Admin::class,'SafeAccountExpense']) -> name("admin.web.safe.account.list.expense");  //! Finans - Kasa Hesap - Gider


//! Satış - Yapılan Satışlar
Route::get('/{lang}/admin/order', [Admin::class,'OrderList']) -> name("admin.web.order.list");  //! Tüm Veriler
Route::post('/admin/order/search/post', [Admin::class,'OrderSearchPost']) -> name("admin.web.order.search.post"); //! Veri Arama - Post
Route::post('/admin/order/add/post', [Admin::class,'OrderAddPost']) -> name("admin.web.order.add.post"); //! Veri Ekleme - Post
Route::post('/admin/order/delete/post', [Admin::class,'OrderDeletePost']) -> name("admin.web.order.delete.post"); //! Veri Silme
Route::post('/admin/order/delete/post/multi', [Admin::class,'OrderDeletePostMulti']) -> name("admin.web.order.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::post('/admin/order/edit/post', [Admin::class,'OrderEditPost']) -> name("admin.web.order.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/order/edit/active', [Admin::class,'OrderEditActive']) -> name("admin.web.order.edit.active"); //! Veri Durum Güncelle - Post
Route::post('/admin/order/edit/multi/active', [Admin::class,'OrderEditMultiActive']) -> name("admin.web.order.edit.multi.active"); //! Çoklu Veri Durum Güncelle - Post
Route::post('/admin/order/clone', [Admin::class,'OrderClonePost']) -> name("admin.web.order.clone.post"); //! Veri Clone - Post
Route::post('/admin/order/clone/multi', [Admin::class,'OrderClonePostMulti']) -> name("admin.web.order.clone.post.multi"); //! Çoklu Veri Clone - Post

//! Satış - Yapılan Satışlar - Detay
Route::get('/{lang}/admin/order/{id}/detail', [Admin::class,'OrderDetailList']) -> name("admin.web.order.detail.list");  //! Tüm Veriler
Route::post('/admin/order/detail/search/post', [Admin::class,'OrderDetailSearchPost']) -> name("admin.web.order.detail.search.post"); //! Veri Arama - Post
Route::post('/admin/order/detail/add/post', [Admin::class,'OrderDetailAddPost']) -> name("admin.web.order.detail.add.post"); //! Veri Ekleme - Post
Route::post('/admin/order/detail/delete/post', [Admin::class,'OrderDetailDeletePost']) -> name("admin.web.order.detail.delete.post"); //! Veri Silme
Route::post('/admin/order/detail/delete/post/multi', [Admin::class,'OrderDetailDeletePostMulti']) -> name("admin.web.order.detail.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::post('/admin/order/detail/edit/post', [Admin::class,'OrderDetailEditPost']) -> name("admin.web.order.detail.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/order/detail/edit/active', [Admin::class,'OrderDetailEditActive']) -> name("admin.web.order.detail.edit.active"); //! Veri Durum Güncelle - Post
Route::post('/admin/order/detail/edit/multi/active', [Admin::class,'OrderDetailEditMultiActive']) -> name("admin.web.order.detail.edit.multi.active"); //! Çoklu Veri Durum Güncelle - Post
Route::post('/admin/order/detail/clone', [Admin::class,'OrderDetailClonePost']) -> name("admin.web.order.detail.clone.post"); //! Veri Clone - Post
Route::post('/admin/order/detail/clone/multi', [Admin::class,'OrderDetailClonePostMulti']) -> name("admin.web.order.detail.clone.post.multi"); //! Çoklu Veri Clone - Post

//************* Firma ***************** */


//! Firma - Kategori
Route::get('/{lang}/admin/company/category', [Admin::class,'CompanyCategory']) -> name("admin.web.company.category.list");  //! Tüm Veriler
Route::post('/admin/company/category/search/post', [Admin::class,'CompanyCategorySearchPost']) -> name("admin.web.company.category.search.post"); //! Veri Arama - Post
Route::post('/admin/company/category/add/post', [Admin::class,'CompanyCategoryAddPost']) -> name("admin.web.company.category.add.post"); //! Veri Ekleme - Post
Route::post('/admin/company/category/delete/post', [Admin::class,'CompanyCategoryDeletePost']) -> name("admin.web.company.category.delete.post"); //! Veri Silme
Route::post('/admin/company/category/delete/post/multi', [Admin::class,'CompanyCategoryDeletePostMulti']) -> name("admin.web.company.category.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::post('/admin/company/category/edit/post', [Admin::class,'CompanyCategoryEditPost']) -> name("admin.web.company.category.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/company/category/edit/active', [Admin::class,'CompanyCategoryEditActive']) -> name("admin.web.company.category.edit.active"); //! Veri Durum Güncelle - Post
Route::post('/admin/company/category/edit/multi/active', [Admin::class,'CompanyCategoryEditMultiActive']) -> name("admin.web.company.category.detail.edit.multi.active"); //! Çoklu Veri Durum Güncelle - Post
Route::post('/admin/company/category/clone', [Admin::class,'CompanyCategoryClonePost']) -> name("admin.web.company.category.clone.post"); //! Veri Clone - Post
Route::post('/admin/company/category/clone/multi', [Admin::class,'CompanyCategoryClonePostMulti']) -> name("admin.web.company.category.clone.post.multi"); //! Çoklu Veri Clone - Post

//! Firma
Route::get('/{lang}/admin/company', [Admin::class,'CompanyList']) -> name("admin.company.list");  //! Tüm Veriler
Route::post('/admin/company/search/post', [Admin::class,'CompanySearchPost']) -> name("admin.company.search.post"); //! Veri Arama - Post
Route::get('/{lang}/admin/company/add', [Admin::class,'CompanyAddView']) -> name("admin.company.add");  //! Veri Ekleme - Sayfası
Route::post('/admin/company/add/post', [Admin::class,'CompanyAddPost']) -> name("admin.company.add.post"); //! Veri Ekleme - Post
Route::post('/admin/company/delete/post', [Admin::class,'CompanyDeletePost']) -> name("admin.company.delete.post"); //! Veri Silme - Post
Route::post('/admin/company/delete/post/multi', [Admin::class,'CompanyDeletePostMulti']) -> name("admin.company.delete.post.multi"); //! Veri Çoklu Silme - Post
Route::get('/{lang}/admin/company/edit/{id}', [Admin::class,'CompanyEdit']) -> name("admin.company.edit.view");  //! Veri Güncelle - Sayfa
Route::post('/admin/company/edit/post', [Admin::class,'CompanyEditPost']) -> name("admin.company.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/company/edit/active', [Admin::class,'CompanyEditActive']) -> name("admin.company.edit.active"); //! Veri Durum Güncelle - Post
Route::post('/admin/company/edit/multi/active', [Admin::class,'CompanyEditMultiActive']) -> name("admin.company.edit.multi.active"); //! Çoklu Veri Durum Güncelle - Post
Route::post('/admin/company/clone', [Admin::class,'CompanyEditClonePost']) -> name("admin.company.clone.post"); //! Veri Clone - Post
Route::post('/admin/company/clone/multi', [Admin::class,'CompanyEditClonePostMulti']) -> name("admin.company.clone.post.multi"); //! Çoklu Veri Clone - Post

//************* Toplantılar ***************** */


//! Toplantılar
Route::get('/{lang}/admin/meetings', [Admin::class,'Meetings']) -> name("admin.meetings");  //! Tüm Veriler
Route::post('/admin/meetings/search/post', [Admin::class,'MeetingsSearchPost']) -> name("admin.meetings.search.post"); //! Veri Arama - Post
Route::post('/admin/meetings/add/post', [Admin::class,'MeetingsAddPost']) -> name("admin.meetings.add.post"); //! Veri Ekleme - Post
Route::post('/admin/meetings/delete/post', [Admin::class,'MeetingsDeletePost']) -> name("admin.meetings.delete.post"); //! Veri Silme
Route::post('/admin/meetings/delete/post/multi', [Admin::class,'MeetingsDeletePostMulti']) -> name("admin.meetings.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::post('/admin/meetings/edit/post', [Admin::class,'MeetingsEditPost']) -> name("admin.meetings.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/meetings/edit/active', [Admin::class,'MeetingsEditActive']) -> name("admin.meetings.edit.active"); //! Veri Durum Güncelle - Post
Route::post('/admin/meetings/edit/multi/active', [Admin::class,'MeetingsEditMultiActive']) -> name("admin.meetings.edit.multi.active"); //! Çoklu Veri Durum Güncelle - Post
Route::post('/admin/meetings/clone', [Admin::class,'MeetingsClonePost']) -> name("admin.meetings.clone.post"); //! Veri Clone - Post
Route::post('/admin/meetings/clone/multi', [Admin::class,'MeetingsClonePostMulti']) -> name("admin.meetings.clone.post.multi"); //! Çoklu Veri Clone - Post

//************* Admin - Web - Hizmetler ***************** */

//! Hizmetler - Kategori
Route::get('/{lang}/admin/service/category', [Admin::class,'ServiceCategory']) -> name("admin.web.service.category.list");  //! Tüm Veriler
Route::post('/admin/service/category/search/post', [Admin::class,'ServiceCategorySearchPost']) -> name("admin.web.service.category.search.post"); //! Veri Arama - Post
Route::post('/admin/service/category/add/post', [Admin::class,'ServiceCategoryAddPost']) -> name("admin.web.service.category.add.post"); //! Veri Ekleme - Post
Route::post('/admin/service/category/delete/post', [Admin::class,'ServiceCategoryDeletePost']) -> name("admin.web.service.category.delete.post"); //! Veri Silme
Route::post('/admin/service/category/delete/post/multi', [Admin::class,'ServiceCategoryDeletePostMulti']) -> name("admin.web.service.category.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::post('/admin/service/category/edit/post', [Admin::class,'ServiceCategoryEditPost']) -> name("admin.web.service.category.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/service/category/edit/active', [Admin::class,'ServiceCategoryEditActive']) -> name("admin.web.service.category.edit.active"); //! Veri Durum Güncelle - Post
Route::post('/admin/service/category/edit/multi/active', [Admin::class,'ServiceCategoryEditMultiActive']) -> name("admin.web.service.category.detail.edit.multi.active"); //! Çoklu Veri Durum Güncelle - Post
Route::post('/admin/service/category/clone', [Admin::class,'ServiceCategoryClonePost']) -> name("admin.web.service.category.clone.post"); //! Veri Clone - Post
Route::post('/admin/service/category/clone/multi', [Admin::class,'ServiceCategoryClonePostMulti']) -> name("admin.web.service.category.clone.post.multi"); //! Çoklu Veri Clone - Post

//! Hizmetler
Route::get('/{lang}/admin/service/list', [Admin::class,'ServiceList']) -> name("admin.web.service.list");  //! Tüm Veriler
Route::post('/admin/service/search/post', [Admin::class,'ServiceSearchPost']) -> name("admin.web.service.search.post"); //! Veri Arama - Post
Route::get('/{lang}/admin/service/add', [Admin::class,'ServiceAddView']) -> name("admin.web.service.add");  //! Veri Ekleme - Sayfası
Route::post('/admin/service/add/post', [Admin::class,'ServiceAddPost']) -> name("admin.web.service.add.post"); //! Veri Ekleme - Post
Route::post('/admin/service/delete/post', [Admin::class,'ServiceDeletePost']) -> name("admin.web.service.delete.post"); //! Veri Silme
Route::post('/admin/service/delete/post/multi', [Admin::class,'ServiceDeletePostMulti']) -> name("admin.web.service.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::get('/{lang}/admin/service/edit/{id}', [Admin::class,'ServiceEdit']) -> name("admin.web.service.edit.view");  //! Veri Güncelle - Sayfa
Route::post('/admin/service/edit/post', [Admin::class,'ServiceEditPost']) -> name("admin.web.service.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/service/edit/info/post', [Admin::class,'ServiceEditInfoPost']) -> name("admin.web.service.edit.info.post"); //! Veri Bilgileri Güncelle - Post
Route::post('/admin/service/edit/active', [Admin::class,'ServiceEditActive']) -> name("admin.web.service.edit.active"); //! Veri Durum Güncelle - Post
Route::post('/admin/service/edit/multi/active', [Admin::class,'ServiceEditMultiActive']) -> name("admin.web.service.detail.edit.multi.active"); //! Çoklu Veri Durum Güncelle - Post
Route::post('/admin/service/clone', [Admin::class,'ServiceClonePost']) -> name("admin.web.service.clone.post"); //! Veri Clone - Post
Route::post('/admin/service/clone/multi', [Admin::class,'ServiceClonePostMulti']) -> name("admin.web.service.clone.post.multi"); //! Çoklu Veri Clone - Post

//************* Web - Yorumlar  ***************** */

//! Web Yorumlar
Route::get('/{lang}/admin/comment/list', [Admin::class,'CommentList']) -> name("admin.web.comment.list");  //! Tüm Veriler
Route::post('/admin/comment/search/post', [Admin::class,'CommentSearchPost']) -> name("admin.web.comment.search.post"); //! Veri Arama - Post
Route::get('/{lang}/admin/comment/add', [Admin::class,'CommentAddView']) -> name("admin.web.comment.add");  //! Veri Ekleme - Sayfası
Route::post('/admin/comment/add/post', [Admin::class,'CommentAddPost']) -> name("admin.web.comment.add.post"); //! Veri Ekleme - Post
Route::post('/admin/comment/delete/post', [Admin::class,'CommentDeletePost']) -> name("admin.web.comment.delete.post"); //! Veri Silme
Route::post('/admin/comment/delete/post/multi', [Admin::class,'CommentDeletePostMulti']) -> name("admin.web.comment.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::get('/{lang}/admin/comment/edit/{id}', [Admin::class,'CommentEdit']) -> name("admin.web.comment.edit.view");  //! Veri Güncelle - Sayfa
Route::post('/admin/comment/edit/post', [Admin::class,'CommentEditPost']) -> name("admin.web.comment.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/comment/edit/img/post', [Admin::class,'CommentEditImagePost']) -> name("admin.web.comment.edit.img.post"); //! Veri Resim Güncelle - Post
Route::post('/admin/comment/edit/active', [Admin::class,'CommentEditActive']) -> name("admin.web.comment.edit.active"); //! Veri Durum Güncelle - Post
Route::post('/admin/comment/edit/multi/active', [Admin::class,'CommentEditMultiActive']) -> name("admin.web.comment.detail.edit.multi.active"); //! Çoklu Veri Durum Güncelle - Post
Route::post('/admin/comment/clone', [Admin::class,'CommentClonePost']) -> name("admin.web.comment.clone.post"); //! Veri Clone - Post
Route::post('/admin/comment/clone/multi', [Admin::class,'CommentClonePostMulti']) -> name("admin.web.comment.clone.post.multi"); //! Çoklu Veri Clone - Post

//************* Web - Ekibimiz  ***************** */

//! Web Ekibimiz
Route::get('/{lang}/admin/team/list', [Admin::class,'TeamList']) -> name("admin.web.team.list");  //! Tüm Veriler
Route::post('/admin/team/search/post', [Admin::class,'TeamSearchPost']) -> name("admin.web.team.search.post"); //! Veri Arama - Post
Route::get('/{lang}/admin/team/add', [Admin::class,'TeamAddView']) -> name("admin.web.team.add");  //! Veri Ekleme - Sayfası
Route::post('/admin/team/add/post', [Admin::class,'TeamAddPost']) -> name("admin.web.team.add.post"); //! Veri Ekleme - Post
Route::post('/admin/team/delete/post', [Admin::class,'TeamDeletePost']) -> name("admin.web.team.delete.post"); //! Veri Silme
Route::post('/admin/team/delete/post/multi', [Admin::class,'TeamDeletePostMulti']) -> name("admin.web.team.delete.post.multi"); //! Çoklu Veri Silme - Post
Route::get('/{lang}/admin/team/edit/{id}', [Admin::class,'TeamEdit']) -> name("admin.web.team.edit.view");  //! Veri Güncelle - Sayfa
Route::post('/admin/team/edit/post', [Admin::class,'TeamEditPost']) -> name("admin.web.team.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/team/edit/active', [Admin::class,'TeamEditActive']) -> name("admin.web.team.edit.active"); //! Veri Durum Güncelle - Post
Route::post('/admin/team/edit/multi/active', [Admin::class,'TeamEditMultiActive']) -> name("admin.web.team.detail.edit.multi.active"); //! Çoklu Veri Durum Güncelle - Post
Route::post('/admin/team/clone', [Admin::class,'TeamClonePost']) -> name("admin.web.team.clone.post"); //! Veri Clone - Post
Route::post('/admin/team/clone/multi', [Admin::class,'TeamClonePostMulti']) -> name("admin.web.team.clone.post.multi"); //! Çoklu Veri Clone - Post


//************* Admin Sabit  ***************** */

//! Sabit
Route::get('/{lang}/admin/fixed', [Admin::class,'Fixed']) -> name("admin.fixed.page");  //! Sabit 

//! Form
Route::get('/{lang}/admin/fixed/form', [Admin::class,'FixedForm']) -> name("admin.fixed.form");  //! Form
Route::post('/admin/fixed/form/control', [Admin::class,'FixedFormControl']) -> name("admin.fixed.form.control");  //! Form Kontrol

//************* Admin - Sabit List ***************** */

//! Sabit List
Route::get('/{lang}/admin/fixed_list/list', [Admin::class,'FixedList']) -> name("admin.fixed.list");  //! Tüm Veriler
Route::get('/{lang}/admin/fixed_list/search/{id}', [Admin::class,'FixedSearchView']) -> name("admin.fixed.search.view");  //! Veri Arama - Sayfası
Route::post('/admin/fixed_list/search/post', [Admin::class,'FixedSearchPost']) -> name("admin.fixed.search.post"); //! Veri Arama - Post
Route::get('/{lang}/admin/fixed_list/add', [Admin::class,'FixedAddView']) -> name("admin.fixed.add");  //! Veri Ekleme - Sayfası
Route::post('/admin/fixed_list/add/post', [Admin::class,'FixedAddPost']) -> name("admin.fixed.add.post"); //! Veri Ekleme - Post
Route::post('/admin/fixed_list/delete/post', [Admin::class,'FixedDeletePost']) -> name("admin.fixed.delete.post"); //! Veri Silme - Post
Route::post('/admin/fixed_list/delete/post/multi', [Admin::class,'FixedDeletePostMulti']) -> name("admin.fixed.delete.post.multi"); //! Veri Çoklu Silme - Post
Route::get('/{lang}/admin/fixed_list/edit/{id}', [Admin::class,'FixedEdit']) -> name("admin.fixed.edit.view");  //! Veri Güncelle - Sayfa
Route::post('/admin/fixed_list/edit/post', [Admin::class,'FixedEditPost']) -> name("admin.fixed.edit.post"); //! Veri Güncelle - Post
Route::post('/admin/fixed_list/edit/active', [Admin::class,'FixedEditActive']) -> name("admin.fixed.edit.active"); //! Veri Durum Güncelle - Post
Route::post('/admin/fixed_list/edit/multi/active', [Admin::class,'FixedEditMultiActive']) -> name("admin.fixed.edit.multi.active"); //! Çoklu Veri Durum Güncelle - Post
Route::post('/admin/fixed_list/clone', [Admin::class,'FixedEditClonePost']) -> name("admin.fixed.clone.post"); //! Veri Clone - Post
Route::post('/admin/fixed_list/clone/multi', [Admin::class,'FixedEditClonePostMulti']) -> name("admin.fixed.clone.post.multi"); //! Çoklu Veri Clone - Post
Route::post('/admin/fixed_list/import', [Admin::class,'FixedEditImport']) -> name("admin.fixed.import"); //! Import


//************* Dosya Yükleme ***************** */

//! Dosya Yükleme
Route::get('/{lang}/file/upload', [Admin::class,'fileUpload']) -> name("fixed.file.upload"); //! Dosya Yükleme
Route::post('/file/upload/control', [Admin::class,'fileUploadControl']) -> name("file.upload.control"); //! Dosya Yükleme  Kontrol

//! Çoklu Dosya Yükleme
Route::get('/{lang}/file/upload/multi', [Admin::class,'fileUploadMulti']) -> name("fixed.file.upload.multi"); //! Çoklu Dosya Yükleme
Route::post('/file/upload/multi/control', [Admin::class,'fileUploadMultiControl']) -> name("file.upload.multi.control"); //! Çoklu Dosya Yükleme  Kontrol

//************* Ajax ***************** */

//! Ajax
Route::get('/ajax/example/get', [Admin::class,'ajaxFunctionExampleGet']) -> name("ajax.get");
Route::post('/ajax/example/post', [Admin::class,'ajaxFunctionExamplePost']) -> name("ajax.post");

//************* Api ***************** */

//! Api
Route::get('/{lang}/api/get', [Admin::class,'apiGet']) -> name("api.get");
Route::get('/{lang}/api/post', [Admin::class,'apiPost']) -> name("api.post");

//! Api - File Upload
Route::get('/{lang}/api/file/upload/view', [Admin::class,'apiFileUpload']) -> name("api.file.upload");
Route::post('/api/file/upload/view/post', [Admin::class,'apiFileUploadControl']) -> name("api.file.upload.post");

//************* Export ve Import ***************** */

//! Export - Pdf
Route::get('/{lang}/admin/export/pdf', [Admin::class,'exportPdf']) -> name("admin.export.pdf"); //! Export Pdf
Route::get('/{lang}/admin/export/pdf/test', [Admin::class,'exportPdfTest']) -> name("admin.export.pdf.test"); //! Export Pdf - Test

Route::get('/{lang}/admin/export/pdf/list', [Admin::class,'exportPdfList']) -> name("admin.export.pdf.list"); //! Export Pdf - List
Route::get('/{lang}/admin/export/pdf/list/safe', [Admin::class,'exportPdfListSafe']) -> name("admin.export.pdf.list.safe"); //! Export Pdf - Kasa Listesi

//! Import
Route::post('/import/file/upload/control', [Admin::class,'importFileUploadControl']) -> name("import.file.upload.control"); //! Import - File Upload

//************* Hata Sayfaları ***************** */

//! Hata Sayfaları
Route::get('/{lang}/error/account/block', [Admin::class,'errorAccountBlock']) -> name("error.errorAccountBlock"); //! Hesap Kapalı
Route::get('/{lang}/error/500', [Admin::class,'error500']) -> name("error.error500"); //! 500 Hatası

//************* Sayfa Bulunamadı ***************** */
Route::fallback( function() {  return view('error404'); });  //! 404 - Sayfa Bulunamadı