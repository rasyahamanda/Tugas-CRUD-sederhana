<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_kategori = (int) $_POST['id_kategori'];
    $nama_produk = trim($_POST['nama_produk']);
    $harga       = (float) $_POST['harga'];
    $stok        = (int) $_POST['stok'];

    // CREATE (prepared statement)
    $stmt = $koneksi->prepare(
        "INSERT INTO produk (id_kategori, nama_produk, harga, stok) VALUES (?, ?, ?, ?)"
    );
    $stmt->bind_param("isdi", $id_kategori, $nama_produk, $harga, $stok);
    $stmt->execute();

    header("Location: index.php");
    exit;
}

$kategori = $koneksi->query("SELECT * FROM kategori ORDER BY nama_kategori");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Produk</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f4f6f9; }
        form { background: #fff; padding: 20px; max-width: 420px; border-radius: 6px; }
        label { display: block; margin-top: 12px; font-weight: bold; }
        input, select { width: 100%; padding: 8px; margin-top: 4px; box-sizing: border-box; }
        button { margin-top: 16px; padding: 8px 16px; background: #27ae60; color: #fff; border: 0; border-radius: 4px; cursor: pointer; }
        a { margin-left: 10px; }
    </style>
</head>
<body>
    <h2>Tambah Produk</h2>
    <form method="post">
        <label>Kategori</label>
        <select name="id_kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <?php while ($k = $kategori->fetch_assoc()): ?>
                <option value="<?= $k['id_kategori'] ?>"><?= htmlspecialchars($k['nama_kategori']) ?></option>
            <?php endwhile; ?>
        </select>

        <label>Nama Produk</label>
        <input type="text" name="nama_produk" maxlength="120" required>

        <label>Harga</label>
        <input type="number" name="harga" step="0.01" min="0" required>

        <label>Stok</label>
        <input type="number" name="stok" min="0" value="0" required>

        <button type="submit">Simpan</button>
        <a href="index.php">Batal</a>
    </form>
</body>
</html>
