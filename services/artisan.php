<?php


require_once __DIR__ . '/app/Console/SetupDatabaseCommand.php';




// Komut satırı argümanlarını al
$args = $argv;

// İlk argüman komut dosyasının adı olduğu için kaldırılır
array_shift($args);

// Komut olarak verilen argümanları al
$command = array_shift($args);

// Komutu işle
switch ($command) {
    case 'setup:database':
        App\Console\SetupDatabaseCommand::handle();
        break;
    default:
        echo "Invalid command\n";
        break;
}