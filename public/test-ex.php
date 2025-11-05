<?php

$host = 'sql12.freesqldatabase.com';
$db   = 'sql12806226';
$user = 'sql12806226';
$pass = 'dpcXuLC1X3';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
    echo "✅ Connected successfully! External DB";
    echo "</br><a href='/test-in.php' >Test Internal</a>";
    echo "</br><a href='/' >Finish Test</a>";
} catch (\PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage();
}

?>