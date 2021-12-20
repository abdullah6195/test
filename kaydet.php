<?php

try {
    $db = new PDO("mysql:host=localhost; dbname=test",'root','');
    $db->exec("SET NAMES utf8mb4; SET CHARSET utf8mb4");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Bağlanamadı'. $e->getMessage();
    $db = null;
}

if ($_POST) {
    $p = $_POST;
    $query = $db->prepare("INSERT INTO tablo_out (name, surname, password) VALUES (?, ?, ?)");
    $query->execute([
        $p['name'], $p['surname'], $p['password']
    ]);
    header("Location: kaydet.php");
}
?>
<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<form action="" method="post">
    <label for="name">
        Ad
        <input type="text" id="name" name="name">
    </label>
    <br><br>
    <label for="surname">
        Soyad
        <input type="text" id="surname" name="surname">
    </label>
    <br><br>
    <label for="password">
        Şifre
        <input type="password" id="password" name="password">
    </label>
    <br><br>
    <input type="submit">
</form>
<br><br>
<a href="tablolar.php">Tablolar sayfası</a>
</body>
</html>
