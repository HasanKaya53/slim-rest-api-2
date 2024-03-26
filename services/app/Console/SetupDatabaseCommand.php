<?php

namespace App\Console;


use PDO;


class SetupDatabaseCommand
{
    public static function handle()
    {

        echo "Veritabanı oluşturulmaya başlanıyor...\n";

        // Kullanıcıdan gerekli bilgileri al
        $host = readline('Veritabanı Hostu (varsayılan: localhost): ') ?: 'localhost';
        $database = readline('Veritabanı Adı (varsayılan: transition): ') ?: 'transition';
        $username = readline('Veritabanı Kullanıcı Adı (varsayılan: root): ') ?: 'root';
        $password = readline('Veritabanı Kullanıcı Şifre: (varsayılan: boş): ') ?: '';
        $port = readline('Veritabanı Portu (varsayılan: 3306): ') ?: '3306';

        try {
            // MySQL'e bağlan
            $pdo = new PDO("mysql:host=$host;port=$port", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Veritabanını oluştur
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$database`");

            //table create...
            $pdo->exec("CREATE TABLE IF NOT EXISTS `$database`.`users` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `username` VARCHAR(255) NOT NULL,
                `password` VARCHAR(255) NOT NULL,
    `is_read` boolean default 0,
    `is_write` boolean default 1,
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    
                PRIMARY KEY (`id`)
            )");



            $ana_dizin = realpath(__DIR__ . "/../");
            require_once $ana_dizin.'/Libraries/PasswordClass.php';



            //insert user ..


            $stmt = $pdo->prepare("INSERT INTO `$database`.`users` (`username`, `password`) VALUES (:username, :password)");
            $stmt->execute(['username' => 'services_user', 'password' => \App\Libraries\PasswordClass::hash('123456')]);

            $stmt = $pdo->prepare("INSERT INTO `$database`.`users` (`username`, `password`) VALUES (:username, :password)");
            $stmt->execute(['username' => 'admin', 'password' => \App\Libraries\PasswordClass::hash('123456')]);

            echo "Veritabanı '$database' başarıyla oluşturuldu.\n";




        } catch(PDOException $e) {
            echo "Veritabanı oluşturma başarısız: " . $e->getMessage() . "\n";
            exit(1);
        }

        // Settings.php dosyasını oluştur
        $settings = "<?php\n\n";
        $settings .= "return [\n";
        $settings .= "    'settings' => [\n";
        $settings .= "        'db' => [\n";
        $settings .= "            'host' => '$host',\n";
        $settings .= "            'database' => '$database',\n";
        $settings .= "            'username' => '$username',\n";
        $settings .= "            'password' => '$password',\n";
        $settings .= "            'port' => '$port'\n";
        $settings .= "        ]\n";
        $settings .= "    ]\n";
        $settings .= "];\n";

        file_put_contents('./src/settings.php', $settings);

        echo "Veritabanı Ayarları Kaydedildi. (/src/settings.php).\n";
        echo "Veritabanı kurulumu tamamlandı.\n";
    }
}