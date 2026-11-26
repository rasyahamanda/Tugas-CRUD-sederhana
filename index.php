<?php
require 'koneksi.php';

// READ: produk + kategori (INNER JOIN)
$produk = $koneksi->query("
    SELECT p.id_produk, p.nama_produk, k.nama_kategori, p.harga, p.stok
    FROM produk p
    INNER JOIN kategori k ON p.id_kategori = k.id_kategori
    ORDER BY p.id_produk
");

// LEFT JOIN: semua kategori beserta jumlah produknya (termasuk yang 0)
$rekap = $koneksi->query("
    SELECT k.nama_kategori, COUNT(p.id_produk) AS jumlah_produk
    FROM kategori k
    LEFT JOIN produk p ON k.id_kategori = p.id_kategori
    GROUP BY k.id_kategori, k.nama_kategori
    ORDER BY k.id_kategori
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Produk</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f4f6f9; }
        h2 { color: #2c3e50; }
        table { border-collapse: collapse; width: 100%; background: #fff; margin-bottom: 30px; }
        th, td { border: 1px solid #ddd; padding: 8px 12px; text-align: left; }
        th { background: #2c3e50; color: #fff; }
        tr:nth-child(even) { background: #f9f9f9; }
        .btn { padding: 5px 10px; text-decoration: none; color: #fff; border-radius: 4px; font-size: 13px; }
        .tambah { background: #27ae60; display: inline-block; margin-bottom: 12px; padding: 8px 14px; }
        .edit { background: #f39c12; }
        .hapus { background: #c0392b; }
    </style>
</head>
<body>
    <h2>Data Produk</h2>
    <a href="tambah.php" class="btn tambah">+ Tambah Produk</a>

    <table>
        <tr>
            <th>No</th><th>Nama Produk</th><th>Kategori</th>
            <th>Harga</th><th>Stok</th><th>Aksi</th>
        </tr>
        <?php $no = 1; while ($row = $produk->fetch_assoc()): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['nama_produk']) ?></td>
            <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
            <td>Rp <?= number_format($row['harga'], 2, ',', '.') ?></td>
            <td><?= $row['stok'] ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id_produk'] ?>" class="btn edit">Edit</a>
                <a href="hapus.php?id=<?= $row['id_produk'] ?>" class="btn hapus"
                   onclick="return confirm('Yakin hapus produk ini?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h2>Jumlah Produk per Kategori</h2>
    <table>
        <tr><th>Kategori</th><th>Jumlah Produk</th></tr>
        <?php while ($r = $rekap->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($r['nama_kategori']) ?></td>
            <td><?= $r['jumlah_produk'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
