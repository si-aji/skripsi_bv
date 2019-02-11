-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Feb 2019 pada 03.11
-- Versi server: 10.1.32-MariaDB
-- Versi PHP: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_bakulvisor-skripsi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_10_11_070139_add_confirmation', 1),
(4, '2018_10_26_191828_add_username_to_table_user', 1),
(5, '2018_10_27_160855_create_tbl_kategori', 1),
(6, '2018_11_01_135754_create_tbl_barang', 1),
(7, '2018_11_02_134756_create_tbl_kostumer', 1),
(8, '2018_11_02_143235_create_tbl_supplier', 1),
(9, '2018_11_04_192114_create_tbl_toko', 1),
(10, '2018_11_07_114340_create_tbl_penjualan', 1),
(11, '2018_11_07_155343_create_tbl_penjualan_item', 1),
(12, '2018_11_08_192626_create_tbl_penjualan_bayar', 1),
(13, '2018_11_14_123932_create_tbl_pembelian', 1),
(14, '2018_11_14_124109_create_tbl_pembelian_item', 1),
(15, '2018_11_14_124400_create_tbl_pembelian_bayar', 1),
(16, '2018_11_28_170744_create_tbl_paket', 1),
(17, '2018_11_28_170956_tbl_paket_item', 1),
(18, '2018_12_20_192813_create_tbl_apriori', 1),
(19, '2019_01_17_135225_create_trigger_update_harga', 1),
(20, '2019_01_17_141527_create_trigger_stok_update_penjualan', 1),
(21, '2019_01_17_150951_create_trigger_stok_pembelian', 1),
(22, '2019_01_17_151200_create_trigger_rollback_pembelian', 1),
(23, '2019_01_17_153416_create_trigger_stok_update_pembelian', 1),
(24, '2019_01_17_203414_create_trigger_stok_penjualan', 1),
(25, '2019_01_17_203550_create_trigger_rollback_penjualan', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_apriori`
--

CREATE TABLE `tbl_apriori` (
  `id` int(10) UNSIGNED NOT NULL,
  `min_support` double(8,2) NOT NULL,
  `min_confidence` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_apriori`
--

INSERT INTO `tbl_apriori` (`id`, `min_support`, `min_confidence`, `created_at`, `updated_at`) VALUES
(1, 30.00, 70.00, '2019-01-24 02:03:08', '2019-01-30 07:46:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_barang`
--

CREATE TABLE `tbl_barang` (
  `id` int(10) UNSIGNED NOT NULL,
  `kategori_id` int(10) UNSIGNED NOT NULL,
  `barang_kode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barang_nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barang_stokStatus` enum('Aktif','Tidak Aktif') COLLATE utf8mb4_unicode_ci NOT NULL,
  `barang_stok` int(11) NOT NULL,
  `barang_hBeli` int(11) NOT NULL,
  `barang_hJual` int(11) NOT NULL,
  `barang_detail` text COLLATE utf8mb4_unicode_ci,
  `barang_status` enum('Aktif','Tidak Aktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_barang`
--

INSERT INTO `tbl_barang` (`id`, `kategori_id`, `barang_kode`, `barang_nama`, `barang_stokStatus`, `barang_stok`, `barang_hBeli`, `barang_hJual`, `barang_detail`, `barang_status`, `created_at`, `updated_at`) VALUES
(8, 14, '1', 'Tearoff KYT C5 Gold', 'Tidak Aktif', 0, 0, 0, '<p>&nbsp;</p>', 'Aktif', '2018-12-08 22:24:16', '2018-12-08 22:24:28'),
(9, 7, '1', 'Box', 'Tidak Aktif', 0, 0, 0, '<p>&nbsp;</p>', 'Aktif', '2018-12-08 22:24:23', '2018-12-08 22:24:23'),
(10, 14, '2', 'Tearoff KYT C5 Clear', 'Tidak Aktif', 0, 0, 0, '<p>&nbsp;</p>', 'Aktif', '2018-12-08 22:24:42', '2018-12-08 22:24:42'),
(11, 14, '3', 'Tearoff NHK Terminator Clear', 'Tidak Aktif', 0, 0, 0, '<p>&nbsp;</p>', 'Aktif', '2018-12-08 22:24:56', '2018-12-08 22:24:56'),
(12, 13, '1', 'Talang Air', 'Tidak Aktif', 0, 0, 5000, '<p>&nbsp;</p>', 'Aktif', '2018-12-08 22:25:09', '2019-01-27 06:11:11'),
(13, 13, '2', 'Spoiler Vendetta Pista Besar Hitam', 'Tidak Aktif', 0, 0, 0, '<p>&nbsp;</p>', 'Aktif', '2018-12-08 22:25:24', '2018-12-08 22:25:24'),
(14, 12, '1', 'Flat Snail FFS1 Iridium Silver', 'Tidak Aktif', 0, 0, 0, '<p>&nbsp;</p>', 'Aktif', '2018-12-08 22:25:40', '2018-12-08 22:25:40'),
(15, 12, '2', 'Visor C5 Dark', 'Tidak Aktif', 0, 0, 0, '<p>&nbsp;</p>', 'Aktif', '2018-12-08 22:25:46', '2018-12-08 22:25:46'),
(16, 11, '1', 'Rachet C5', 'Tidak Aktif', 0, 0, 0, '<p>&nbsp;</p>', 'Aktif', '2018-12-08 22:25:53', '2018-12-08 22:25:53'),
(17, 10, '1', 'Visor Lock C5', 'Tidak Aktif', 0, 0, 0, '<p>&nbsp;</p>', 'Aktif', '2018-12-08 22:26:00', '2018-12-08 22:26:00'),
(18, 9, '1', 'Knob Besi C5', 'Tidak Aktif', 0, 0, 0, '<p>&nbsp;</p>', 'Aktif', '2018-12-08 22:26:05', '2018-12-08 22:26:05'),
(19, 9, '2', 'Knob MDS Zara', 'Tidak Aktif', 0, 0, 0, '<p>&nbsp;</p>', 'Aktif', '2018-12-08 22:26:11', '2019-01-30 07:45:15'),
(20, 8, '1', 'Tearoff Post Nylon Hitam', 'Tidak Aktif', 0, 0, 0, '<p>&nbsp;</p>', 'Aktif', '2018-12-08 22:26:30', '2018-12-08 22:26:30'),
(21, 8, '2', 'Tearoff Post Yellow Fluo', 'Tidak Aktif', 0, 0, 0, '<p>&nbsp;</p>', 'Aktif', '2018-12-08 22:26:38', '2018-12-08 22:26:38'),
(22, 8, '3', 'Tearoff Post Clear KYT', 'Tidak Aktif', 0, 0, 0, '<p>&nbsp;</p>', 'Aktif', '2018-12-08 22:26:45', '2018-12-08 22:26:45');

--
-- Trigger `tbl_barang`
--
DELIMITER $$
CREATE TRIGGER `updateHarga_barang` AFTER UPDATE ON `tbl_barang` FOR EACH ROW BEGIN
                UPDATE
                tbl_paket_item SET
                    barang_hAsli = new.barang_hJual
                WHERE
                    id = new.id;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kategori`
--

CREATE TABLE `tbl_kategori` (
  `id` int(10) UNSIGNED NOT NULL,
  `kategori_kode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_kategori`
--

INSERT INTO `tbl_kategori` (`id`, `kategori_kode`, `kategori_nama`, `created_at`, `updated_at`) VALUES
(7, 'BO', 'Bonus', '2018-12-08 22:22:35', '2018-12-08 22:22:35'),
(8, 'TOP', 'Tearoff Post', '2018-12-08 22:22:56', '2018-12-08 22:22:56'),
(9, 'KN', 'Knob', '2018-12-08 22:23:01', '2018-12-08 22:23:01'),
(10, 'VSL', 'Visor Lock', '2018-12-08 22:23:07', '2018-12-08 22:23:07'),
(11, 'RC', 'Rachet', '2018-12-08 22:23:13', '2018-12-08 22:23:13'),
(12, 'VS', 'Visor', '2018-12-08 22:23:18', '2018-12-08 22:23:18'),
(13, 'AP', 'Apparel', '2018-12-08 22:23:30', '2018-12-08 22:23:30'),
(14, 'TO', 'Tearoff', '2018-12-08 22:23:36', '2018-12-08 22:23:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kostumer`
--

CREATE TABLE `tbl_kostumer` (
  `id` int(10) UNSIGNED NOT NULL,
  `kostumer_nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kostumer_kontak` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kostumer_detail` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_kostumer`
--

INSERT INTO `tbl_kostumer` (`id`, `kostumer_nama`, `kostumer_kontak`, `kostumer_detail`, `created_at`, `updated_at`) VALUES
(1, 'Dwi Aji', 'dwi.p.aji', 'line', '2018-12-01 23:28:31', '2018-12-01 23:28:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_paket`
--

CREATE TABLE `tbl_paket` (
  `id` int(10) UNSIGNED NOT NULL,
  `paket_nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paket_harga` int(11) NOT NULL,
  `paket_status` enum('Aktif','Tidak Aktif') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_paket`
--

INSERT INTO `tbl_paket` (`id`, `paket_nama`, `paket_harga`, `paket_status`, `created_at`, `updated_at`) VALUES
(2, 'Paket C5', 475000, 'Aktif', '2018-12-02 00:59:44', '2018-12-24 23:01:00'),
(3, 'Coba', 0, 'Aktif', '2019-01-24 15:18:29', '2019-01-24 15:18:29'),
(4, 'Coba 2', 0, 'Aktif', '2019-01-24 15:19:04', '2019-01-24 15:19:04'),
(6, 'Coba 3', 5000, 'Aktif', '2019-01-27 07:05:46', '2019-01-27 07:05:46'),
(7, 'C5 - Dua Item', 0, 'Aktif', '2019-01-30 07:47:16', '2019-01-30 07:47:16'),
(8, 'Nyoba', 0, 'Aktif', '2019-01-30 08:18:24', '2019-01-30 08:18:24'),
(9, 'C5 - 2 Item', 0, 'Aktif', '2019-01-30 08:40:20', '2019-01-30 08:40:20'),
(10, 'Box - Rachet C5 - Knob MDS Zara', 0, 'Aktif', '2019-01-30 08:47:13', '2019-01-30 08:47:13'),
(11, 'AAA', 0, 'Aktif', '2019-01-30 08:51:18', '2019-01-30 08:51:18'),
(12, 'Talang Air - Visor C5 Dark', 0, 'Aktif', '2019-01-30 08:54:22', '2019-01-30 08:54:22'),
(13, 'BBB', 0, 'Aktif', '2019-01-30 08:56:02', '2019-01-30 08:56:02'),
(14, 'CCC', 0, 'Aktif', '2019-01-30 08:57:09', '2019-01-30 08:57:09'),
(15, 'DDD', 0, 'Aktif', '2019-01-30 08:57:42', '2019-01-30 08:57:42'),
(16, 'asdasd', 0, 'Aktif', '2019-01-30 09:00:55', '2019-01-30 09:00:55'),
(17, 'oioi', 0, 'Aktif', '2019-01-30 09:01:34', '2019-01-30 09:01:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_paket_item`
--

CREATE TABLE `tbl_paket_item` (
  `id` int(10) UNSIGNED NOT NULL,
  `paket_id` int(10) UNSIGNED NOT NULL,
  `barang_id` int(10) UNSIGNED NOT NULL,
  `barang_hAsli` int(11) NOT NULL,
  `barang_hJual` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_paket_item`
--

INSERT INTO `tbl_paket_item` (`id`, `paket_id`, `barang_id`, `barang_hAsli`, `barang_hJual`, `created_at`, `updated_at`) VALUES
(1, 2, 18, 0, 0, '2018-12-24 23:01:00', '2018-12-24 23:01:00'),
(2, 2, 16, 0, 0, '2018-12-24 23:01:00', '2018-12-24 23:01:00'),
(3, 2, 10, 0, 0, '2018-12-24 23:01:00', '2018-12-24 23:01:00'),
(5, 3, 16, 0, 0, '2019-01-24 15:18:29', '2019-01-24 15:18:29'),
(6, 3, 12, 0, 0, '2019-01-24 15:18:29', '2019-01-24 15:18:29'),
(7, 3, 17, 0, 0, '2019-01-24 15:18:29', '2019-01-24 15:18:29'),
(8, 4, 12, 0, 0, '2019-01-24 15:19:04', '2019-01-24 15:19:04'),
(9, 4, 16, 0, 0, '2019-01-24 15:19:04', '2019-01-24 15:19:04'),
(10, 4, 17, 0, 0, '2019-01-24 15:19:05', '2019-01-24 15:19:05'),
(11, 6, 12, 5000, 5000, '2019-01-27 07:05:46', '2019-01-27 07:05:46'),
(12, 6, 16, 0, 0, '2019-01-27 07:05:46', '2019-01-27 07:05:46'),
(13, 6, 19, 0, 0, '2019-01-27 07:05:46', '2019-01-27 07:05:46'),
(14, 7, 16, 0, 0, '2019-01-30 07:47:16', '2019-01-30 07:47:16'),
(15, 7, 15, 0, 0, '2019-01-30 07:47:16', '2019-01-30 07:47:16'),
(16, 8, 16, 0, 0, '2019-01-30 08:18:24', '2019-01-30 08:18:24'),
(17, 8, 19, 0, 0, '2019-01-30 08:18:24', '2019-01-30 08:18:24'),
(18, 8, 17, 0, 0, '2019-01-30 08:18:24', '2019-01-30 08:18:24'),
(19, 9, 16, 0, 0, '2019-01-30 08:40:20', '2019-01-30 08:40:20'),
(20, 9, 19, 0, 0, '2019-01-30 08:40:20', '2019-01-30 08:40:20'),
(21, 10, 9, 0, 0, '2019-01-30 08:47:13', '2019-01-30 08:47:13'),
(22, 10, 16, 0, 0, '2019-01-30 08:47:13', '2019-01-30 08:47:13'),
(23, 10, 19, 0, 0, '2019-01-30 08:47:13', '2019-01-30 08:47:13'),
(24, 11, 12, 5000, 5000, '2019-01-30 08:51:18', '2019-01-30 08:51:18'),
(25, 11, 16, 0, 0, '2019-01-30 08:51:18', '2019-01-30 08:51:18'),
(26, 12, 12, 5000, 5000, '2019-01-30 08:54:22', '2019-01-30 08:54:22'),
(27, 12, 15, 0, 0, '2019-01-30 08:54:22', '2019-01-30 08:54:22'),
(28, 13, 10, 0, 0, '2019-01-30 08:56:02', '2019-01-30 08:56:02'),
(29, 13, 17, 0, 0, '2019-01-30 08:56:02', '2019-01-30 08:56:02'),
(30, 14, 19, 0, 0, '2019-01-30 08:57:09', '2019-01-30 08:57:09'),
(31, 14, 22, 0, 0, '2019-01-30 08:57:09', '2019-01-30 08:57:09'),
(32, 15, 10, 0, 0, '2019-01-30 08:57:42', '2019-01-30 08:57:42'),
(33, 15, 15, 0, 0, '2019-01-30 08:57:42', '2019-01-30 08:57:42'),
(34, 16, 16, 0, 0, '2019-01-30 09:00:55', '2019-01-30 09:00:55'),
(35, 16, 19, 0, 0, '2019-01-30 09:00:55', '2019-01-30 09:00:55'),
(36, 16, 22, 0, 0, '2019-01-30 09:00:55', '2019-01-30 09:00:55'),
(37, 17, 16, 0, 0, '2019-01-30 09:01:34', '2019-01-30 09:01:34'),
(38, 17, 19, 0, 0, '2019-01-30 09:01:34', '2019-01-30 09:01:34'),
(39, 17, 15, 0, 0, '2019-01-30 09:01:34', '2019-01-30 09:01:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pembelian`
--

CREATE TABLE `tbl_pembelian` (
  `id` int(10) UNSIGNED NOT NULL,
  `supplier_id` int(10) UNSIGNED NOT NULL,
  `pembelian_invoice` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pembelian_tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pembelian_detail` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pembelian_bayar`
--

CREATE TABLE `tbl_pembelian_bayar` (
  `id` int(10) UNSIGNED NOT NULL,
  `pembelian_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `pembayaran_tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `biaya_lain` int(11) NOT NULL,
  `diskon` int(11) NOT NULL,
  `bayar` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pembelian_item`
--

CREATE TABLE `tbl_pembelian_item` (
  `id` int(10) UNSIGNED NOT NULL,
  `pembelian_id` int(10) UNSIGNED NOT NULL,
  `barang_id` int(10) UNSIGNED NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `beli_qty` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Trigger `tbl_pembelian_item`
--
DELIMITER $$
CREATE TRIGGER `rollback_pembelian` AFTER DELETE ON `tbl_pembelian_item` FOR EACH ROW BEGIN
                UPDATE
                tbl_barang SET
                    barang_stok = barang_stok - old.beli_qty
                WHERE
                    id = old.barang_id;
            END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `stokUpdate_pembelian` AFTER UPDATE ON `tbl_pembelian_item` FOR EACH ROW BEGIN
                UPDATE
                tbl_barang SET
                    barang_stok = barang_stok + (new.beli_qty - old.beli_qty),
                    barang_hBeli = new.harga_beli
                WHERE
                    id = new.barang_id;
            END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `stok_pembelian` AFTER INSERT ON `tbl_pembelian_item` FOR EACH ROW BEGIN
                UPDATE
                tbl_barang SET
                    barang_stok = barang_stok + new.beli_qty,
                    barang_hBeli = new.harga_beli
                WHERE
                    id = new.barang_id;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_penjualan`
--

CREATE TABLE `tbl_penjualan` (
  `id` int(10) UNSIGNED NOT NULL,
  `kostumer_id` int(10) UNSIGNED DEFAULT NULL,
  `toko_id` int(10) UNSIGNED NOT NULL,
  `penjualan_invoice` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penjualan_tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `penjualan_detail` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_penjualan`
--

INSERT INTO `tbl_penjualan` (`id`, `kostumer_id`, `toko_id`, `penjualan_invoice`, `penjualan_tgl`, `penjualan_detail`, `created_at`, `updated_at`) VALUES
(34, NULL, 1, 'INVC/JUAL/091218/1544333414', '2018-12-08 22:26:00', '<p>&nbsp;</p>', '2018-12-08 22:29:42', '2018-12-08 22:29:42'),
(35, NULL, 1, 'INVC/JUAL/091218/1544333503', '2018-12-08 22:29:00', '<p>&nbsp;</p>', '2018-12-08 22:30:37', '2018-12-08 22:30:37'),
(36, NULL, 1, 'INVC/JUAL/091218/1544333561', '2018-12-08 22:31:00', '<p>&nbsp;</p>', '2018-12-08 22:32:19', '2018-12-08 22:32:19'),
(37, NULL, 1, 'INVC/JUAL/091218/1544333767', '2018-12-08 22:32:00', '<p>&nbsp;</p>', '2018-12-08 22:35:19', '2018-12-08 22:35:19'),
(38, NULL, 1, 'INVC/JUAL/091218/1544333886', '2018-12-08 22:35:00', '<p>&nbsp;</p>', '2018-12-08 22:36:06', '2018-12-08 22:36:06'),
(39, NULL, 1, 'INVC/JUAL/091218/1544334002', '2018-12-08 22:36:00', '<p>&nbsp;</p>', '2018-12-08 22:37:08', '2018-12-08 22:37:08'),
(40, NULL, 1, 'INVC/JUAL/091218/1544333972', '2018-12-08 22:37:00', '<p>&nbsp;</p>', '2018-12-08 22:37:33', '2018-12-08 22:37:33'),
(41, NULL, 1, 'INVC/JUAL/091218/1544334079', '2018-12-08 22:37:00', '<p>&nbsp;</p>', '2018-12-08 22:38:13', '2018-12-08 22:38:13'),
(42, NULL, 1, 'INVC/JUAL/091218/1544333978', '2018-12-08 22:38:00', '<p>&nbsp;</p>', '2018-12-08 22:38:49', '2018-12-08 22:38:49'),
(43, NULL, 1, 'INVC/JUAL/091218/1544334116', '2018-12-08 22:38:00', '<p>&nbsp;</p>', '2018-12-08 22:39:28', '2018-12-08 22:39:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_penjualan_bayar`
--

CREATE TABLE `tbl_penjualan_bayar` (
  `id` int(10) UNSIGNED NOT NULL,
  `penjualan_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `pembayaran_tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `biaya_lain` int(11) NOT NULL,
  `bayar` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_penjualan_bayar`
--

INSERT INTO `tbl_penjualan_bayar` (`id`, `penjualan_id`, `user_id`, `pembayaran_tgl`, `biaya_lain`, `bayar`, `created_at`, `updated_at`) VALUES
(4, 34, 1, '2018-12-08 22:26:00', 0, 0, '2018-12-08 22:29:42', '2018-12-08 22:29:42'),
(5, 35, 1, '2018-12-08 22:29:00', 0, 0, '2018-12-08 22:30:37', '2018-12-08 22:30:37'),
(6, 36, 1, '2018-12-08 22:31:00', 0, 0, '2018-12-08 22:32:19', '2018-12-08 22:32:19'),
(7, 37, 1, '2018-12-08 22:32:00', 0, 0, '2018-12-08 22:35:19', '2018-12-08 22:35:19'),
(8, 38, 1, '2018-12-08 22:35:00', 0, 0, '2018-12-08 22:36:06', '2018-12-08 22:36:06'),
(9, 39, 1, '2018-12-08 22:36:00', 0, 0, '2018-12-08 22:37:08', '2018-12-08 22:37:08'),
(10, 40, 1, '2018-12-08 22:37:00', 0, 0, '2018-12-08 22:37:33', '2018-12-08 22:37:33'),
(11, 41, 1, '2018-12-08 22:37:00', 0, 0, '2018-12-08 22:38:13', '2018-12-08 22:38:13'),
(12, 42, 1, '2018-12-08 22:38:00', 0, 0, '2018-12-08 22:38:49', '2018-12-08 22:38:49'),
(13, 43, 1, '2018-12-08 22:38:00', 0, 0, '2018-12-08 22:39:28', '2018-12-08 22:39:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_penjualan_item`
--

CREATE TABLE `tbl_penjualan_item` (
  `id` int(10) UNSIGNED NOT NULL,
  `penjualan_id` int(10) UNSIGNED NOT NULL,
  `barang_id` int(10) UNSIGNED NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `jual_qty` int(11) NOT NULL,
  `diskon` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_penjualan_item`
--

INSERT INTO `tbl_penjualan_item` (`id`, `penjualan_id`, `barang_id`, `harga_beli`, `harga_jual`, `jual_qty`, `diskon`, `created_at`, `updated_at`) VALUES
(71, 34, 17, 0, 0, 1, 0, '2018-12-08 22:29:42', '2018-12-08 22:29:42'),
(72, 34, 12, 0, 0, 1, 0, '2018-12-08 22:29:42', '2018-12-08 22:29:42'),
(73, 34, 16, 0, 0, 1, 0, '2018-12-08 22:29:42', '2018-12-08 22:29:42'),
(74, 34, 15, 0, 0, 1, 0, '2018-12-08 22:29:42', '2018-12-08 22:29:42'),
(75, 34, 19, 0, 0, 1, 0, '2018-12-08 22:29:42', '2018-12-08 22:29:42'),
(76, 34, 8, 0, 0, 1, 0, '2018-12-08 22:29:42', '2018-12-08 22:29:42'),
(77, 34, 22, 0, 0, 1, 0, '2018-12-08 22:29:42', '2018-12-08 22:29:42'),
(78, 34, 9, 0, 0, 1, 0, '2018-12-08 22:29:42', '2018-12-08 22:29:42'),
(79, 35, 20, 0, 0, 1, 0, '2018-12-08 22:30:37', '2018-12-08 22:30:37'),
(80, 35, 17, 0, 0, 1, 0, '2018-12-08 22:30:37', '2018-12-08 22:30:37'),
(81, 35, 18, 0, 0, 1, 0, '2018-12-08 22:30:37', '2018-12-08 22:30:37'),
(82, 36, 16, 0, 0, 1, 0, '2018-12-08 22:32:19', '2018-12-08 22:32:19'),
(83, 36, 15, 0, 0, 1, 0, '2018-12-08 22:32:19', '2018-12-08 22:32:19'),
(84, 36, 19, 0, 0, 1, 0, '2018-12-08 22:32:19', '2018-12-08 22:32:19'),
(85, 36, 22, 0, 0, 1, 0, '2018-12-08 22:32:19', '2018-12-08 22:32:19'),
(86, 36, 10, 0, 0, 1, 0, '2018-12-08 22:32:19', '2018-12-08 22:32:19'),
(87, 36, 17, 0, 0, 1, 0, '2018-12-08 22:32:19', '2018-12-08 22:32:19'),
(88, 36, 12, 0, 0, 1, 0, '2018-12-08 22:32:19', '2018-12-08 22:32:19'),
(89, 37, 17, 0, 0, 1, 0, '2018-12-08 22:35:19', '2018-12-08 22:35:19'),
(90, 37, 21, 0, 0, 1, 0, '2018-12-08 22:35:19', '2018-12-08 22:35:19'),
(91, 37, 16, 0, 0, 1, 0, '2018-12-08 22:35:19', '2018-12-08 22:35:19'),
(92, 37, 19, 0, 0, 1, 0, '2018-12-08 22:35:19', '2018-12-08 22:35:19'),
(93, 37, 12, 0, 0, 1, 0, '2018-12-08 22:35:19', '2018-12-08 22:35:19'),
(94, 37, 9, 0, 0, 1, 0, '2018-12-08 22:35:19', '2018-12-08 22:35:19'),
(95, 37, 10, 0, 0, 1, 0, '2018-12-08 22:35:19', '2018-12-08 22:35:19'),
(96, 37, 15, 0, 0, 1, 0, '2018-12-08 22:35:19', '2018-12-08 22:35:19'),
(97, 38, 16, 0, 0, 1, 0, '2018-12-08 22:36:06', '2018-12-08 22:36:06'),
(98, 38, 14, 0, 0, 1, 0, '2018-12-08 22:36:06', '2018-12-08 22:36:06'),
(99, 38, 19, 0, 0, 1, 0, '2018-12-08 22:36:06', '2018-12-08 22:36:06'),
(100, 38, 9, 0, 0, 1, 0, '2018-12-08 22:36:06', '2018-12-08 22:36:06'),
(101, 38, 11, 0, 0, 1, 0, '2018-12-08 22:36:06', '2018-12-08 22:36:06'),
(102, 38, 20, 0, 0, 1, 0, '2018-12-08 22:36:06', '2018-12-08 22:36:06'),
(103, 39, 17, 0, 0, 1, 0, '2018-12-08 22:37:08', '2018-12-08 22:37:08'),
(104, 39, 16, 0, 0, 1, 0, '2018-12-08 22:37:08', '2018-12-08 22:37:08'),
(105, 39, 19, 0, 0, 1, 0, '2018-12-08 22:37:08', '2018-12-08 22:37:08'),
(106, 39, 12, 0, 0, 1, 0, '2018-12-08 22:37:08', '2018-12-08 22:37:08'),
(107, 39, 15, 0, 0, 1, 0, '2018-12-08 22:37:08', '2018-12-08 22:37:08'),
(108, 40, 19, 0, 0, 1, 0, '2018-12-08 22:37:33', '2018-12-08 22:37:33'),
(109, 40, 22, 0, 0, 1, 0, '2018-12-08 22:37:33', '2018-12-08 22:37:33'),
(110, 40, 12, 0, 0, 1, 0, '2018-12-08 22:37:33', '2018-12-08 22:37:33'),
(111, 41, 16, 0, 0, 1, 0, '2018-12-08 22:38:13', '2018-12-08 22:38:13'),
(112, 41, 19, 0, 0, 1, 0, '2018-12-08 22:38:13', '2018-12-08 22:38:13'),
(113, 41, 14, 0, 0, 1, 0, '2018-12-08 22:38:13', '2018-12-08 22:38:13'),
(114, 41, 11, 0, 0, 1, 0, '2018-12-08 22:38:13', '2018-12-08 22:38:13'),
(115, 41, 20, 0, 0, 1, 0, '2018-12-08 22:38:13', '2018-12-08 22:38:13'),
(116, 42, 17, 0, 0, 1, 0, '2018-12-08 22:38:49', '2018-12-08 22:38:49'),
(117, 42, 16, 0, 0, 1, 0, '2018-12-08 22:38:49', '2018-12-08 22:38:49'),
(118, 42, 19, 0, 0, 1, 0, '2018-12-08 22:38:49', '2018-12-08 22:38:49'),
(119, 42, 12, 0, 0, 1, 0, '2018-12-08 22:38:49', '2018-12-08 22:38:49'),
(120, 42, 22, 0, 0, 1, 0, '2018-12-08 22:38:49', '2018-12-08 22:38:49'),
(121, 43, 16, 0, 0, 1, 0, '2018-12-08 22:39:28', '2018-12-08 22:39:28'),
(122, 43, 13, 0, 0, 1, 0, '2018-12-08 22:39:28', '2018-12-08 22:39:28'),
(123, 43, 10, 0, 0, 1, 0, '2018-12-08 22:39:28', '2018-12-08 22:39:28'),
(124, 43, 15, 0, 0, 1, 0, '2018-12-08 22:39:28', '2018-12-08 22:39:28'),
(125, 43, 17, 0, 0, 1, 0, '2018-12-08 22:39:28', '2018-12-08 22:39:28');

--
-- Trigger `tbl_penjualan_item`
--
DELIMITER $$
CREATE TRIGGER `rollback_penjualan` AFTER DELETE ON `tbl_penjualan_item` FOR EACH ROW BEGIN
                UPDATE
                tbl_barang SET
                    barang_stok = CASE WHEN barang_stokStatus = "Aktif" THEN barang_stok + old.jual_qty WHEN barang_stokStatus = "Tidak Aktif" THEN 0 END
                WHERE
                    id = old.barang_id;
            END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `stokUpdate_penjualan` AFTER UPDATE ON `tbl_penjualan_item` FOR EACH ROW BEGIN
                UPDATE
                tbl_barang SET
                    barang_stok = CASE WHEN barang_stokStatus = "Aktif" THEN barang_stok - (new.jual_qty - old.jual_qty) WHEN barang_stokStatus = "Tidak Aktif" THEN 0 END
                WHERE
                    id = new.barang_id;
            END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `stok_penjualan` AFTER INSERT ON `tbl_penjualan_item` FOR EACH ROW BEGIN
                UPDATE
                tbl_barang SET
                    barang_stok = CASE WHEN barang_stokStatus = "Aktif" THEN barang_stok - new.jual_qty WHEN barang_stokStatus = "Tidak Aktif" THEN 0 END
                WHERE
                    id = new.barang_id;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `id` int(10) UNSIGNED NOT NULL,
  `supplier_nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_kontak` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier_detail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier_status` enum('Aktif','Tidak Aktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`id`, `supplier_nama`, `supplier_kontak`, `supplier_detail`, `supplier_status`, `created_at`, `updated_at`) VALUES
(1, 'Ibl Store', NULL, NULL, 'Aktif', '2018-12-01 23:28:36', '2018-12-01 23:28:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_toko`
--

CREATE TABLE `tbl_toko` (
  `id` int(10) UNSIGNED NOT NULL,
  `toko_tipe` enum('Online','Offline') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Offline',
  `toko_nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `toko_alamat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `toko_link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `toko_kontak` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `toko_status` enum('Aktif','Tidak Aktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_toko`
--

INSERT INTO `tbl_toko` (`id`, `toko_tipe`, `toko_nama`, `toko_alamat`, `toko_link`, `toko_kontak`, `toko_status`, `created_at`, `updated_at`) VALUES
(1, 'Offline', 'Bakulvisor', 'Gg Virgo no 123b, Jl. Nitikan Baru, Sorosutan, Umbulharjo, Kota Yogyakarta, Daerah Istimewa Yogyakarta 55162', 'https://www.google.co.id/maps/place/bakul+visor/@-7.8232092,110.3823822,15z/data=!4m2!3m1!1s0x0:0x28f4db37a577f40e?ved=2ahUKEwjZqv7M4rreAhVWT30KHXBAC2AQ_BIwEHoECAYQCA', '083113055955', 'Aktif', '2018-12-01 23:28:58', '2018-12-01 23:28:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `confirmation_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Aktif','Tidak Aktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Aktif',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `email_verified_at`, `confirmation_code`, `confirmed`, `password`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Dwi Aji', NULL, 'dwiaji', NULL, 'XpGmLbr4p097U0o67WvzFTrCqeUgcf', 1, '$2y$10$/mdqZ0bZRNfXfUgZ8dFOCOfC1KkbaTHD8FoqqpvhEgJmQ1nSUH83e', 'Aktif', 'XrHa2ZNKUGsdT6dM9hB2JiSsf83UP8KkjJUo5cfUtfKhgEwPkzuLauqqES63', '2018-12-01 22:52:10', '2018-12-01 22:52:10');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `tbl_apriori`
--
ALTER TABLE `tbl_apriori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_barang`
--
ALTER TABLE `tbl_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_barang_kategori_id_foreign` (`kategori_id`);

--
-- Indeks untuk tabel `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tbl_kategori_kategori_kode_unique` (`kategori_kode`);

--
-- Indeks untuk tabel `tbl_kostumer`
--
ALTER TABLE `tbl_kostumer`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_paket`
--
ALTER TABLE `tbl_paket`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_paket_item`
--
ALTER TABLE `tbl_paket_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_paket_item_paket_id_foreign` (`paket_id`),
  ADD KEY `tbl_paket_item_barang_id_foreign` (`barang_id`);

--
-- Indeks untuk tabel `tbl_pembelian`
--
ALTER TABLE `tbl_pembelian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_pembelian_supplier_id_foreign` (`supplier_id`);

--
-- Indeks untuk tabel `tbl_pembelian_bayar`
--
ALTER TABLE `tbl_pembelian_bayar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_pembelian_bayar_pembelian_id_foreign` (`pembelian_id`),
  ADD KEY `tbl_pembelian_bayar_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `tbl_pembelian_item`
--
ALTER TABLE `tbl_pembelian_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_pembelian_item_pembelian_id_foreign` (`pembelian_id`),
  ADD KEY `tbl_pembelian_item_barang_id_foreign` (`barang_id`);

--
-- Indeks untuk tabel `tbl_penjualan`
--
ALTER TABLE `tbl_penjualan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_penjualan_kostumer_id_foreign` (`kostumer_id`),
  ADD KEY `tbl_penjualan_toko_id_foreign` (`toko_id`);

--
-- Indeks untuk tabel `tbl_penjualan_bayar`
--
ALTER TABLE `tbl_penjualan_bayar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_penjualan_bayar_penjualan_id_foreign` (`penjualan_id`),
  ADD KEY `tbl_penjualan_bayar_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `tbl_penjualan_item`
--
ALTER TABLE `tbl_penjualan_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_penjualan_item_penjualan_id_foreign` (`penjualan_id`),
  ADD KEY `tbl_penjualan_item_barang_id_foreign` (`barang_id`);

--
-- Indeks untuk tabel `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_toko`
--
ALTER TABLE `tbl_toko`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `tbl_apriori`
--
ALTER TABLE `tbl_apriori`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbl_barang`
--
ALTER TABLE `tbl_barang`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `tbl_kostumer`
--
ALTER TABLE `tbl_kostumer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbl_paket`
--
ALTER TABLE `tbl_paket`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `tbl_paket_item`
--
ALTER TABLE `tbl_paket_item`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `tbl_pembelian`
--
ALTER TABLE `tbl_pembelian`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_pembelian_bayar`
--
ALTER TABLE `tbl_pembelian_bayar`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_pembelian_item`
--
ALTER TABLE `tbl_pembelian_item`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_penjualan`
--
ALTER TABLE `tbl_penjualan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT untuk tabel `tbl_penjualan_bayar`
--
ALTER TABLE `tbl_penjualan_bayar`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `tbl_penjualan_item`
--
ALTER TABLE `tbl_penjualan_item`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT untuk tabel `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbl_toko`
--
ALTER TABLE `tbl_toko`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tbl_barang`
--
ALTER TABLE `tbl_barang`
  ADD CONSTRAINT `tbl_barang_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `tbl_kategori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_paket_item`
--
ALTER TABLE `tbl_paket_item`
  ADD CONSTRAINT `tbl_paket_item_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `tbl_barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_paket_item_paket_id_foreign` FOREIGN KEY (`paket_id`) REFERENCES `tbl_paket` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_pembelian`
--
ALTER TABLE `tbl_pembelian`
  ADD CONSTRAINT `tbl_pembelian_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `tbl_supplier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_pembelian_bayar`
--
ALTER TABLE `tbl_pembelian_bayar`
  ADD CONSTRAINT `tbl_pembelian_bayar_pembelian_id_foreign` FOREIGN KEY (`pembelian_id`) REFERENCES `tbl_pembelian` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_pembelian_bayar_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_pembelian_item`
--
ALTER TABLE `tbl_pembelian_item`
  ADD CONSTRAINT `tbl_pembelian_item_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `tbl_barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_pembelian_item_pembelian_id_foreign` FOREIGN KEY (`pembelian_id`) REFERENCES `tbl_pembelian` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_penjualan`
--
ALTER TABLE `tbl_penjualan`
  ADD CONSTRAINT `tbl_penjualan_kostumer_id_foreign` FOREIGN KEY (`kostumer_id`) REFERENCES `tbl_kostumer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_penjualan_toko_id_foreign` FOREIGN KEY (`toko_id`) REFERENCES `tbl_toko` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_penjualan_bayar`
--
ALTER TABLE `tbl_penjualan_bayar`
  ADD CONSTRAINT `tbl_penjualan_bayar_penjualan_id_foreign` FOREIGN KEY (`penjualan_id`) REFERENCES `tbl_penjualan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_penjualan_bayar_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_penjualan_item`
--
ALTER TABLE `tbl_penjualan_item`
  ADD CONSTRAINT `tbl_penjualan_item_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `tbl_barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_penjualan_item_penjualan_id_foreign` FOREIGN KEY (`penjualan_id`) REFERENCES `tbl_penjualan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
