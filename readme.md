# GÖREV

FTP’de bir klasöre bir sistem tarafından otomatik olarak Excel dosyası olarak atılan kategori ağacının veritabanına aktarılarak sistem yöneticisine bildirim gönderilmesi. Bu işlem verilecek bir hook URL’ine herhangi bir GET isteği geldiğinde tetiklenecek ve kuyruğa gönderilerek arka planda işlenecektir

# Beklenenler

-   Symfony yada Laravel framework kullanmanız
-   DB modelini oluşturmanız
-   Kategori ağacının model yapısı olarak  “nested tree model” kullanmanız
-   İşlemi kuyruk yapısıyla arkaplanda yapmanız
-   OOP ve SOLID prensiplerine uymanız
-   PSR-2 standartlarına uymanız
-   İhtiyaç duyabileceğiniz kütüphaneleri bularak bu kütüphanelerle çalışmanız
-   İşlem tamamlandığı zaman buradayim@90pixel.com adresine yapılan işlemin sonucunun mail olarak gönderilmesi

## Bonus

-   Projeyi Dockerize etmeniz
-   Unit Test ve Integration Test yazmanız bonus olarak yansıyacaktır.

-   Bildirim gönderme, mail gönderme, veritabanına yazma, kuyruğa atma vs gibi işlemleri de test etmeniz beklenmektedir.

-   Database seeding, Model Factory yazmak
-   Kod standartlaştırma araçlarının kullanımı
# BİLGİLER
- DİL: PHP
- FRAMEWORK: LARAVEL
- DATABASE: MYSQL
- 3RD LİBRARY:
	- [LARAVEL EXCEL](https://github.com/Maatwebsite/Laravel-Excel)
	- [KALNOY/NESTEDSET](https://packagist.org/packages/kalnoy/nestedset)

# KURULUM
-  git clone https://github.com/Sami-donmez/90-pixel-backend-gorevi
- Boş bir veritabanı tablosu oluştur
- env.example dosyasından env dosyası hazılayın
- Veritabanı bilgilerini env dosyasına girin
- composer install komutunu çalıştırın
- php artisan migrate komutunu çalıştırın
- php artisan serve komutunu çalıştırın

# Görevi tetikleme

/api/category-kontrol adresine giriniz.

