<?php
$host2 = '192.250.239.56';
$db2   = 'flyzeotravel_ota52';
$user2 = 'flyzeotravel_otauser';
$pass2 = 'vXJnWjGDk09GjTju';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host2;dbname=$db2;charset=$charset";

try {
    $pdo = new PDO($dsn, $user2, $pass2);
    echo "✅ Connected successfully! Internal DB";
    echo "</br><a href='/test-ex.php' >Test External</a>";
    echo "</br><a href='/' >Finish Test</a>";
} catch (\PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage();
}

?>