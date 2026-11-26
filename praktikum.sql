-- DDL Pembuatan Tabel
CREATE DATABASE IF NOT EXISTS web1_pertemuan09
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE web1_pertemuan09;

CREATE TABLE kategori (
    id_kategori INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(80) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE produk (
    id_produk INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_kategori INT UNSIGNED NOT NULL,
    nama_produk VARCHAR(120) NOT NULL,
    harga DECIMAL(12,2) NOT NULL,
    stok INT UNSIGNED NOT NULL DEFAULT 0,
    CONSTRAINT fk_produk_kategori
    FOREIGN KEY (id_kategori) REFERENCES kategori (id_kategori)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Data Awal (CREATE)
INSERT INTO kategori (id_kategori, nama_kategori) VALUES
(1, 'Alat Tulis'),
(2, 'Aksesori Komputer'),
(3, 'Perlengkapan Kelas');

INSERT INTO produk (id_produk, id_kategori, nama_produk, harga, stok) VALUES
(1, 1, 'Buku Catatan', 12000.00, 20),
(2, 1, 'Pulpen Gel', 6500.00, 35),
(3, 2, 'Mouse USB', 85000.00, 8),
(4, 2, 'Flashdisk 32 GB', 78000.00, 12),
(5, 3, 'Spidol Papan', 15000.00, 10);

-- Query CRUD (UPDATE & DELETE yang sudah dicoba)
UPDATE produk SET harga = 7000.00, stok = 30 WHERE id_produk = 2;
DELETE FROM produk WHERE id_produk = 5;
