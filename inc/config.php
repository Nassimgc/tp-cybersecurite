<?php
// Vérifiez si le fichier .env existe
if (file_exists(__DIR__ . '/../.env')) {
    // Charger les variables d'environnement à partir du fichier .env
    $env = file_get_contents(__DIR__ . '/../.env');
    $env = explode("\n", $env);
    foreach ($env as $value) {
        if (!empty($value)) {
            $pos = strpos($value, '=');
            $key = substr($value, 0, $pos);
            $val = substr($value, $pos + 1);
            $val = trim($val); // Retirer les espaces en fin de ligne
            putenv("$key=$val");
        }
    }
}

// Configuration de la base de données
define('DB_HOST', getenv('DB_HOST'));
define('DB_NAME', getenv('DB_NAME'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASSWORD', getenv('DB_PASSWORD'));
define('DSN',"mysql:host=" . DB_HOST . ";dbname=" . DB_NAME);