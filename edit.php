<?php
require 'koneksi.php';

$id = (int) ($_GET['id'] ?? $_POST['id_produk'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_kategori = (int) $_POST['id_kategori'];
    $nama_produk = trim($_POST['nama_produk']);
    $harga       = (float) $_POST['harga'];
    $stok        = (int) $_POST['stok'];

    // UPDATE dengan WHERE agar hanya satu baris yang berubah
    $stmt = $koneksi->prepare(
        "UPDATE produk SET id_kategori = ?, nama_produk = ?, harga = ?, stok = ? WHERE id_produk = ?"
    );
    $stmt->bind_param("isdii", $id_kategori, $nama_produk, $harga, $stok, $id);
    $stmt->execute();

    header("Location: index.php");
    exit;
}

$stmt = $koneksi->prepare("SELECT * FROM produk WHERE id_produk = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    die("Data produk tidak ditemukan. <a href='index.php'>Kembali</a>");
}

$kategori = $koneksi->query("SELECT * FROM kategori ORDER BY nama_kategori");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Produk</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f4f6f9; }
        form { background: #fff; padding: 20px; max-width: 420px; border-radius: 6px; }
        label { display: block; margin-top: 12px; font-weight: bold; }
        input, select { width: 100%; padding: 8px; margin-top: 4px; box-sizing: border-box; }
        button { margin-top: 16px; padding: 8px 16px; background: #f39c12; color: #fff; border: 0; border-radius: 4px; cursor: pointer; }
        a { margin-left: 10px; }
    </style>
</head>
<body>
    <h2>Edit Produk</h2>
    <form method="post">
        <input type="hidden" name="id_produk" value="<?= $data['id_produk'] ?>">

        <label>Kategori</label>
        <select name="id_kategori" required>
            <?php while ($k = $kategori->fetch_assoc()): ?>
                <option value="<?= $k['id_kategori'] ?>"
                    <?= $k['id_kategori'] == $data['id_kategori'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($k['nama_kategori']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Nama Produk</label>
        <input type="text" name="nama_produk" maxlength="120"
               value="<?= htmlspecialchars($data['nama_produk']) ?>" required>

        <label>Harga</label>
        <input type="number" name="harga" step="0.01" min="0" value="<?= $data['harga'] ?>" required>

        <label>Stok</label>
        <input type="number" name="stok" min="0" value="<?= $data['stok'] ?>" required>

        <button type="submit">Update</button>
        <a href="index.php">Batal</a>
    </form>
</body>
</html>
