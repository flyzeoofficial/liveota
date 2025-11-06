<?php

$host = '192.250.239.56';
$db   = 'flyzeotravel_ota52';
$user = 'flyzeotravel_otauser';
$pass = 'vXJnWjGDk09GjTju';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>DB Connection Test - Internal</title>
<style>
    body{margin:0;font-family:Arial;background:#f3f4f6;display:flex;justify-content:center;align-items:center;height:100vh;}
    .card{background:#fff;width:380px;border-radius:12px;padding:35px;text-align:center;box-shadow:0 8px 25px rgba(0,0,0,.08);}
    .spinner{width:50px;height:50px;border:6px solid #e5e7eb;border-top:6px solid #3b82f6;border-radius:50%;animation:spin 1s linear infinite;margin:20px auto;}
    @keyframes spin{to{transform:rotate(360deg)}}
    .status{font-size:20px;margin-top:10px;font-weight:600;color:#111;}
    .links a{display:block;margin-top:10px;color:#3b82f6;text-decoration:none;font-size:14px}
</style>
</head>
<body>
<div class="card">
    <div class="spinner" id="spin"></div>
    <div class="status" id="status">Connecting...</div>
    <div class="links" id="links" style="display:none;">
        <a href="/test-ex.php">Test External</a>
        <a href="/">Finish Test</a>
    </div>
</div>

<script>
    setTimeout(()=>{document.getElementById('spin').style.display='none';},500);
</script>
</body>
</html>

<?php
flush();
sleep(1);

try {
    $pdo = new PDO($dsn, $user, $pass);
    echo "<script>
    document.getElementById('status').innerHTML='✅ Connected successfully!';
    document.getElementById('links').style.display='block';
    document.getElementById('status').style.color='#16a34a';
    </script>";
} catch (PDOException $e) {
    echo "<script>
    document.getElementById('status').innerHTML='❌ Connection failed:<br>".$e->getMessage()."';
    document.getElementById('status').style.color='#dc2626';
    </script>";
}
?>
