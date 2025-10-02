<?php
// config.php (safe for GitHub public repo)
// --------------------------------------
// Database + Site configuration + Social links
// (Telegram bot token jaisi sensitive cheez yahan NA dalen)

// ------- Database -------
$db_host = "localhost";
$db_user = "llwnglow_tushar";        
$db_pass = "tushar12@12@12";         
$db_name = "llwnglow_mydb";          

// ------- Site Info -------
$site_name = "My Premium Store";
$site_url  = "https://thesmmpanel.shop";

// ------- Social / Contact Info -------
$telegram_admin_id       = "8150875959";       // aapka telegram ID (numeric)
$telegram_admin_username = "@ofline_king";     // aapka telegram username
$whatsapp_number         = "";                 // apna whatsapp number yahan daalna
$instagram_link          = "";                 // apna instagram profile link yahan daalna

// ------- Session Options -------
$session_lifetime = 30 * 24 * 60 * 60; // 30 din (seconds)

// ------- PDO Options -------
$pdo_options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
];

// ------- DB Connect Function -------
function getPDO() {
    global $db_host, $db_name, $db_user, $db_pass, $pdo_options;
    static $pdo = null;
    if ($pdo === null) {
        $dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";
        $pdo = new PDO($dsn, $db_user, $db_pass, $pdo_options);
    }
    return $pdo;
}

// ------- Logger Helper -------
function cfg_log($msg) {
    $f = __DIR__ . '/logs/app.log';
    @mkdir(dirname($f), 0755, true);
    @file_put_contents($f, date('Y-m-d H:i:s') . " - " . $msg . PHP_EOL, FILE_APPEND);
}

// End of config.php
