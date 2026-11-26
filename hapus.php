<?php
require 'koneksi.php';

$id = (int) ($_GET['id'] ?? 0);

if ($id > 0) {
    // DELETE dengan WHERE agar hanya satu baris yang terhapus
    $stmt = $koneksi->prepare("DELETE FROM produk WHERE id_produk = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: index.php");
exit;
