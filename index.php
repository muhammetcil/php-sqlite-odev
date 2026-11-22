<?php
// 1. SQLite veritabanına bağlan (dosya yoksa otomatik oluşur)
$db = new PDO('sqlite:veritabani.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 2. Tablo yoksa oluştur
$db->exec("CREATE TABLE IF NOT EXISTS kitaplar (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    ad TEXT NOT NULL,
    yazar TEXT NOT NULL,
    yil INTEGER
)");

// 3. Tablo boşsa örnek veriler ekle
$sayi = $db->query("SELECT COUNT(*) FROM kitaplar")->fetchColumn();
if ($sayi == 0) {
    $db->exec("INSERT INTO kitaplar (ad, yazar, yil) VALUES
        ('Suç ve Ceza', 'Fyodor Dostoyevski', 1866),
        ('1984', 'George Orwell', 1949),
        ('Kürk Mantolu Madonna', 'Sabahattin Ali', 1943)
    ");
}

// 4. Verileri çek
$kitaplar = $db->query("SELECT * FROM kitaplar")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>PHP ve SQLite Ödevi</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        table { border-collapse: collapse; width: 60%; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h2>Kitap Listesi (SQLite)</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Kitap Adı</th>
            <th>Yazar</th>
            <th>Yıl</th>
        </tr>
        <?php foreach ($kitaplar as $kitap): ?>
        <tr>
            <td><?= htmlspecialchars($kitap['id']) ?></td>
            <td><?= htmlspecialchars($kitap['ad']) ?></td>
            <td><?= htmlspecialchars($kitap['yazar']) ?></td>
            <td><?= htmlspecialchars($kitap['yil']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>