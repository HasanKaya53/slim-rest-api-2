
## Başlangıç

Projeyi yerel makinenizde çalıştırmak için aşağıdaki adımları izleyin.

##giriş bilgileri:

Kullanıcı: admin
Şifre: 123456

### Kurulum

1. Bu depoyu yerel makinenize klonlayın.
2. Terminali açın ve projenin klonlandığı dizine gidin.
3. Front ve Back taraf için 2 tane apache server çalıştırmanız gerekecek. Öncelikle services klasörü dışında `php -S 127.0.0.1:7000` komutunu çalıştırın (services dışarsındaki tüm php dosyalarının çalışması için).
4. `cd services` komutu ile services dizinine gidin.
5. Bağımlılıkları yüklemek için `composer install` komutunu çalıştırın.
6. `php artisan.php setup:database` komutu ile veritabanını oluşturun.
7. `php -S localhost:8888 -t public` public/index.php  komutu ile projeyi başlatın (8888 portu zorunlu, front tarafta direkt olarak burası yazılı).

### Kullanım ve url yapısı

1. jwt token almak için: `http://localhost:8888/v1/login` json parametreleri: {"username":"admin","password":"123456"}
2. tüm bilgileri listelemek için (Header kısmına bear token Eklenmeli): `http://localhost:8888/v1/services/transition/list` json parametreleri: boş
3. yeni kayıt oluşturmak için(Header kısmına bear token Eklenmeli): `http://localhost:8888/v1/services/transition/new` json parametreleri: {"plaka":"01NZ2076","tarih":"2024-03-12 23:00:01"}

