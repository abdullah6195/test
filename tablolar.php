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
    if (isset($_POST['onayla'])) {
        $onaylananlar = implode(', ', $_POST['onayla']);
        $aktar = $db->query("INSERT INTO tablo_in SELECT * FROM tablo_out WHERE id IN ({$onaylananlar});");
        if ($aktar->rowCount()) {
            $db->query("DELETE FROM tablo_out WHERE id IN ({$onaylananlar})");
            header("Refresh: 0");
        }
    }
}
$onKayitlar = $db->query("SELECT * FROM tablo_out");
$onaylananTablo = $db->query("SELECT * FROM tablo_in");
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
<?php if ($onKayitlar->rowCount()) { ?>
    <h2>Onay Bekleyenler Tablosu</h2>
    <form method="post" action="">
        <table border="1">
            <thead>
            <tr>
                <th>#</th>
                <th>Ad</th>
                <th>Soyad</th>
                <th>Kayıt Tarihi</th>
                <th>Şifre</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $data = $onKayitlar->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $value) { ?>
                <tr>
                    <td>
                        <input type="checkbox" name="onayla[]" value="<?= $value['id'] ?>">
                    </td>
                    <td><?= $value['name'] ?></td>
                    <td><?= $value['surname'] ?></td>
                    <td><?= $value['date'] ?></td>
                    <td><?= $value['password'] ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <br>
        <input value="Onayla" type="submit">
    </form>
<?php }
if ($onaylananTablo->rowCount()) { ?>
    <br><br><br>
    <h2>Onaylananlar Tablosu</h2>
    <form method="post" action="">
        <table border="1">
            <thead>
            <tr>
                <th>Ad</th>
                <th>Soyad</th>
                <th>Kayıt Tarihi</th>
                <th>Şifre</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $data = $onaylananTablo->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $value) { ?>
                <tr>
                    <td><?= $value['name'] ?></td>
                    <td><?= $value['surname'] ?></td>
                    <td><?= $value['date'] ?></td>
                    <td><?= $value['password'] ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </form>
<?php } ?>
<br><br>
<a href="kaydet.php">Kayıt sayfası</a>
</body>
</html>
