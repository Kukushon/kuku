<?php
// db_connection.php
$user = 'u68838'; 
$password = '4996942'; 
try {
    $pdo = new PDO('mysql:host=localhost;dbname=u68838', $user, $password,
        [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    error_log("Database connection error: " . $e->getMessage());
    die("Произошла ошибка подключения к базе данных");
}
?>
