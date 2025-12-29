-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 29 Des 2025 pada 05.37
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pengunjung`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `monthly_visits`
--

CREATE TABLE `monthly_visits` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `x_period` int(11) NOT NULL,
  `y_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `monthly_visits`
--

INSERT INTO `monthly_visits` (`id`, `year`, `month`, `x_period`, `y_total`) VALUES
(1, 2025, 1, 1, 44),
(2, 2025, 2, 2, 46),
(3, 2025, 3, 3, 38),
(4, 2025, 4, 4, 58),
(5, 2025, 5, 5, 39),
(6, 2025, 6, 6, 35),
(7, 2025, 7, 7, 37),
(8, 2025, 8, 8, 34),
(9, 2025, 9, 9, 45),
(10, 2025, 10, 10, 41),
(11, 2025, 11, 11, 44),
(12, 2025, 12, 12, 40);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_anggota`
--

CREATE TABLE `tbl_anggota` (
  `id_anggota` int(11) NOT NULL,
  `kode_anggota` varchar(20) NOT NULL,
  `nama_anggota` varchar(100) NOT NULL,
  `institusi` varchar(100) NOT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_anggota`
--

INSERT INTO `tbl_anggota` (`id_anggota`, `kode_anggota`, `nama_anggota`, `institusi`, `no_telp`, `alamat`, `created_at`) VALUES
(1, '123456', 'Bahlil Etanol', 'Mentri SDA', '087870812345', 'JL. TES', '2025-12-27 07:30:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_hak_akses`
--

CREATE TABLE `tbl_hak_akses` (
  `id` int(11) NOT NULL,
  `id_user_level` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tbl_hak_akses`
--

INSERT INTO `tbl_hak_akses` (`id`, `id_user_level`, `id_menu`) VALUES
(15, 1, 1),
(19, 1, 3),
(24, 1, 9),
(30, 3, 34),
(31, 3, 32),
(32, 3, 31),
(33, 3, 29),
(34, 3, 28),
(35, 3, 27),
(36, 4, 14),
(37, 4, 22),
(38, 4, 23),
(39, 4, 24),
(40, 4, 25),
(41, 4, 26),
(42, 1, 2),
(43, 1, 6),
(44, 1, 7),
(45, 1, 8),
(46, 1, 13),
(47, 1, 14),
(48, 1, 15),
(49, 1, 16),
(50, 1, 17),
(51, 1, 18),
(52, 1, 20),
(53, 1, 23),
(55, 1, 24),
(56, 1, 29),
(57, 1, 33),
(58, 1, 34),
(59, 1, 37),
(60, 1, 38),
(61, 1, 39),
(62, 1, 36),
(63, 1, 19),
(64, 4, 21),
(65, 4, 41),
(66, 2, 7),
(67, 2, 17),
(68, 2, 6),
(69, 2, 8),
(70, 1, 42),
(71, 1, 40),
(72, 1, 43),
(73, 1, 44),
(74, 1, 45),
(77, 1, 46),
(78, 1, 30),
(79, 1, 47),
(80, 1, 48),
(81, 1, 49),
(82, 1, 50),
(83, 1, 51),
(84, 4, 49),
(85, 4, 30),
(86, 4, 51),
(87, 4, 50),
(88, 3, 51),
(89, 3, 50),
(90, 3, 48),
(96, 5, 42),
(97, 5, 43),
(98, 5, 44),
(99, 5, 47),
(101, 5, 33),
(102, 5, 30),
(103, 3, 30),
(104, 1, 52),
(105, 1, 53),
(106, 1, 54),
(107, 1, 55),
(108, 1, 56),
(109, 1, 57),
(110, 1, 58),
(111, 1, 59),
(112, 1, 60),
(113, 4, 59),
(114, 1, 61),
(115, 3, 52),
(116, 3, 53),
(117, 1, 62),
(118, 4, 62),
(119, 4, 2),
(120, 1, 63),
(121, 3, 63),
(122, 3, 62),
(123, 3, 61),
(124, 4, 63),
(125, 1, 64),
(126, 1, 65),
(127, 1, 66),
(128, 1, 67),
(129, 1, 68),
(130, 1, 69),
(131, 1, 70),
(132, 1, 71),
(133, 1, 72),
(134, 1, 73),
(135, 1, 74),
(136, 1, 75),
(137, 1, 76),
(138, 1, 77);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_menu`
--

CREATE TABLE `tbl_menu` (
  `id_menu` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `url` varchar(30) NOT NULL,
  `icon` varchar(30) NOT NULL,
  `is_main_menu` int(11) NOT NULL,
  `is_aktif` enum('y','n') NOT NULL COMMENT 'y=yes,n=no'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tbl_menu`
--

INSERT INTO `tbl_menu` (`id_menu`, `title`, `url`, `icon`, `is_main_menu`, `is_aktif`) VALUES
(1, 'KELOLA MENU', 'kelolamenu', 'fa fa-server', 52, 'y'),
(2, 'KELOLA PENGGUNA', 'user', 'fa fa-user-o', 52, 'y'),
(3, 'level PENGGUNA', 'userlevel', 'fa fa-users', 52, 'y'),
(30, 'Home', 'welcome', 'fa fa-home', 0, 'y'),
(33, 'Form APK', 'profile/update/1', 'fa fa-id-card-o', 52, 'y'),
(52, 'HAK AKSES', '#', 'fa fa-server', 0, 'y'),
(64, 'Anggota', 'Anggota', 'fa fa-home', 67, 'y'),
(65, 'pengunjung', 'master_pengunjung', 'fa fa-home', 67, 'y'),
(66, 'Data Ruangan', 'ruangan', 'fa fa-home', 67, 'y'),
(67, 'MASTER DATA', '#', 'fa fa-server', 0, 'y'),
(68, 'preprocess', 'Preprocess', 'fa fa-hospital-o', 0, 'y'),
(69, 'Prediction', 'prediction', 'fa fa-server', 74, 'y'),
(70, 'Testing', 'testing', 'fa fa-home', 74, 'y'),
(74, 'PREDIKSI', '#', 'fa fa-file-word-o', 0, 'y'),
(75, 'perhitungan Predik', 'perhitungan', 'fa fa-file-code-o', 0, 'y'),
(76, 'Laporan', 'laporan', 'fa fa-print', 0, 'y'),
(77, 'about as', 'profile', 'fa fa-modx', 0, 'y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_profil_apps`
--

CREATE TABLE `tbl_profil_apps` (
  `id` int(11) NOT NULL,
  `nama_apps` varchar(50) NOT NULL,
  `judul` text NOT NULL,
  `logo` text NOT NULL,
  `info_aplikasi` text DEFAULT NULL,
  `tujuan_sistem` text DEFAULT NULL,
  `metode` text DEFAULT NULL,
  `pengembang` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tbl_profil_apps`
--

INSERT INTO `tbl_profil_apps` (`id`, `nama_apps`, `judul`, `logo`, `info_aplikasi`, `tujuan_sistem`, `metode`, `pengembang`) VALUES
(1, 'SIMPERPUS', 'REGRESI LINIER APPS', 'logo_1766791384.jpeg', 'Membantu perpustakaan memprediksi jumlah pengunjung bulanan sebagai bahan perencanaan layanan.', 'Membantu perpustakaan memprediksi jumlah pengunjung bulanan sebagai bahan perencanaan layanan.', 'Regresi linier sederhana (Y = a + bX) menggunakan data kunjungan bulanan.', 'UNPAM / John Wick');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_ruangan`
--

CREATE TABLE `tbl_ruangan` (
  `id_ruangan` int(11) NOT NULL,
  `nama_ruangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_ruangan`
--

INSERT INTO `tbl_ruangan` (`id_ruangan`, `nama_ruangan`) VALUES
(1, 'Ruang Baca Umum'),
(2, 'Ruang Koleksi Referensi'),
(3, 'Layanan Sirkulasi'),
(4, 'Ruang Multimedia'),
(5, 'Layanan Anak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_setting`
--

CREATE TABLE `tbl_setting` (
  `id_setting` int(11) NOT NULL,
  `nama_setting` varchar(50) NOT NULL,
  `value` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tbl_setting`
--

INSERT INTO `tbl_setting` (`id_setting`, `nama_setting`, `value`) VALUES
(1, 'Tampil Menu', 'ya');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_users` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `images` text NOT NULL,
  `id_user_level` int(11) NOT NULL,
  `is_aktif` enum('y','n') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tbl_user`
--

INSERT INTO `tbl_user` (`id_users`, `full_name`, `email`, `password`, `images`, `id_user_level`, `is_aktif`, `created_at`, `updated_at`) VALUES
(1, 'john doe', 'superadm@gmail.com', '1512931f59379a157089477e4d7e449a', '1765783840_foto-pria.jpg', 1, 'y', '2025-12-27 05:48:46', '2025-12-27 05:48:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_user_level`
--

CREATE TABLE `tbl_user_level` (
  `id_user_level` int(11) NOT NULL,
  `nama_level` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tbl_user_level`
--

INSERT INTO `tbl_user_level` (`id_user_level`, `nama_level`) VALUES
(1, 'SUPERADMIN'),
(3, 'Staff Perpus'),
(4, 'Pengunjung');

-- --------------------------------------------------------

--
-- Struktur dari tabel `visits`
--

CREATE TABLE `visits` (
  `id` bigint(20) NOT NULL,
  `member_id` varchar(30) DEFAULT NULL,
  `visitor_name` varchar(120) NOT NULL,
  `membership_type` varchar(50) DEFAULT NULL,
  `institution` varchar(150) DEFAULT NULL,
  `room_name` varchar(80) DEFAULT NULL,
  `visit_date` date NOT NULL,
  `visit_time` time DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `visits`
--

INSERT INTO `visits` (`id`, `member_id`, `visitor_name`, `membership_type`, `institution`, `room_name`, `visit_date`, `visit_time`, `created_at`, `updated_at`) VALUES
(1, '', 'deden', 'Umum', 'UNPAM', 'Ruang Baca Umum', '2025-12-28', '23:31:44', '2025-12-28 23:31:44', NULL),
(2, '', 'Eko Prasetyo', 'Non-Anggota', 'ITB', 'Layanan Anak', '2025-10-05', '10:30:00', '2025-10-05 10:30:00', NULL),
(3, '', 'Budi Santoso', 'Non-Anggota', 'Universitas Indonesia', 'Ruang Koleksi Referensi', '2025-12-15', '12:46:00', '2025-12-15 12:46:00', NULL),
(4, '', 'Rina Marlina', 'Non-Anggota', 'Perpustakaan Daerah', 'Layanan Anak', '2025-06-01', '10:06:00', '2025-06-01 10:06:00', NULL),
(5, '', 'Rina Marlina', 'Non-Anggota', 'UGM', 'Ruang Baca Umum', '2025-04-06', '13:50:00', '2025-04-06 13:50:00', NULL),
(6, '', 'Rina Marlina', 'Non-Anggota', 'SMA Negeri 1', 'Ruang Baca Umum', '2025-02-06', '16:13:00', '2025-02-06 16:13:00', NULL),
(7, '', 'Eko Prasetyo', 'Non-Anggota', 'Umum', 'Ruang Baca Umum', '2025-04-05', '15:52:00', '2025-04-05 15:52:00', NULL),
(8, '98356', 'Budi Santoso', 'Anggota', 'Dinas Pendidikan', 'Layanan Sirkulasi', '2025-09-04', '15:07:00', '2025-09-04 15:07:00', NULL),
(9, '84865', 'Budi Santoso', 'Anggota', 'SMA Negeri 1', 'Ruang Baca Umum', '2025-07-08', '16:55:00', '2025-07-08 16:55:00', NULL),
(10, '', 'Maya Putri', 'Non-Anggota', 'Umum', 'Ruang Koleksi Referensi', '2025-01-11', '11:24:00', '2025-01-11 11:24:00', NULL),
(11, '', 'Rudi Hartono', 'Non-Anggota', 'Umum', 'Layanan Anak', '2025-05-25', '08:23:00', '2025-05-25 08:23:00', NULL),
(12, '', 'Rudi Hartono', 'Non-Anggota', 'Dinas Pendidikan', 'Ruang Baca Umum', '2025-07-07', '09:31:00', '2025-07-07 09:31:00', NULL),
(13, '19291', 'Nurul Hidayah', 'Anggota', 'Universitas Indonesia', 'Ruang Baca Umum', '2025-06-05', '15:58:00', '2025-06-05 15:58:00', NULL),
(14, '22295', 'Budi Santoso', 'Anggota', 'Umum', 'Ruang Koleksi Referensi', '2025-07-06', '16:50:00', '2025-07-06 16:50:00', NULL),
(15, '', 'Agus Setiawan', 'Non-Anggota', 'ITB', 'Layanan Sirkulasi', '2025-12-21', '13:22:00', '2025-12-21 13:22:00', NULL),
(16, '38996', 'Dewi Lestari', 'Anggota', 'Universitas Indonesia', 'Layanan Anak', '2025-07-22', '08:44:00', '2025-07-22 08:44:00', NULL),
(17, '35443', 'Eko Prasetyo', 'Anggota', 'Dinas Pendidikan', 'Ruang Baca Umum', '2025-05-14', '13:50:00', '2025-05-14 13:50:00', NULL),
(18, '75951', 'Agus Setiawan', 'Anggota', 'SMA Negeri 1', 'Ruang Koleksi Referensi', '2025-01-26', '11:52:00', '2025-01-26 11:52:00', NULL),
(19, '', 'Joko Susilo', 'Non-Anggota', 'Dinas Pendidikan', 'Ruang Baca Umum', '2025-10-02', '14:45:00', '2025-10-02 14:45:00', NULL),
(20, '', 'Agus Setiawan', 'Non-Anggota', 'Perpustakaan Daerah', 'Ruang Baca Umum', '2025-12-21', '10:21:00', '2025-12-21 10:21:00', NULL),
(21, '61318', 'Agus Setiawan', 'Anggota', 'Umum', 'Ruang Koleksi Referensi', '2025-09-04', '13:14:00', '2025-09-04 13:14:00', NULL),
(22, '', 'Joko Susilo', 'Non-Anggota', 'Universitas Indonesia', 'Layanan Sirkulasi', '2025-02-10', '12:22:00', '2025-02-10 12:22:00', NULL),
(23, '', 'Siti Aminah', 'Non-Anggota', 'Universitas Indonesia', 'Ruang Multimedia', '2025-06-04', '11:09:00', '2025-06-04 11:09:00', NULL),
(24, '', 'Nurul Hidayah', 'Non-Anggota', 'Universitas Indonesia', 'Layanan Anak', '2025-09-15', '10:57:00', '2025-09-15 10:57:00', NULL),
(25, '', 'Rudi Hartono', 'Non-Anggota', 'Universitas Indonesia', 'Layanan Sirkulasi', '2025-01-10', '08:36:00', '2025-01-10 08:36:00', NULL),
(26, '', 'Agus Setiawan', 'Non-Anggota', 'Umum', 'Ruang Multimedia', '2025-11-21', '09:05:00', '2025-11-21 09:05:00', NULL),
(27, '24224', 'Joko Susilo', 'Anggota', 'ITB', 'Ruang Baca Umum', '2025-02-05', '16:55:00', '2025-02-05 16:55:00', NULL),
(28, '', 'Rina Marlina', 'Non-Anggota', 'UGM', 'Ruang Koleksi Referensi', '2025-04-02', '15:34:00', '2025-04-02 15:34:00', NULL),
(29, '', 'Siti Aminah', 'Non-Anggota', 'UGM', 'Layanan Sirkulasi', '2025-10-03', '13:40:00', '2025-10-03 13:40:00', NULL),
(30, '', 'Siti Aminah', 'Non-Anggota', 'Dinas Pendidikan', 'Layanan Anak', '2025-12-25', '12:13:00', '2025-12-25 12:13:00', NULL),
(31, '19775', 'Budi Santoso', 'Anggota', 'Dinas Pendidikan', 'Ruang Baca Umum', '2025-02-15', '11:10:00', '2025-02-15 11:10:00', NULL),
(32, '85544', 'Rina Marlina', 'Anggota', 'Perpustakaan Daerah', 'Ruang Multimedia', '2025-06-01', '15:58:00', '2025-06-01 15:58:00', NULL),
(33, '27040', 'Rudi Hartono', 'Anggota', 'Dinas Pendidikan', 'Ruang Baca Umum', '2025-01-02', '16:28:00', '2025-01-02 16:28:00', NULL),
(34, '13286', 'Rina Marlina', 'Anggota', 'Dinas Pendidikan', 'Ruang Multimedia', '2025-11-02', '16:44:00', '2025-11-02 16:44:00', NULL),
(35, '', 'Agus Setiawan', 'Non-Anggota', 'UGM', 'Ruang Multimedia', '2025-02-13', '11:43:00', '2025-02-13 11:43:00', NULL),
(36, '', 'Agus Setiawan', 'Non-Anggota', 'ITB', 'Layanan Sirkulasi', '2025-09-25', '15:42:00', '2025-09-25 15:42:00', NULL),
(37, '', 'Budi Santoso', 'Non-Anggota', 'Dinas Pendidikan', 'Layanan Sirkulasi', '2025-05-17', '12:45:00', '2025-05-17 12:45:00', NULL),
(38, '', 'Budi Santoso', 'Non-Anggota', 'Umum', 'Layanan Sirkulasi', '2025-03-05', '15:40:00', '2025-03-05 15:40:00', NULL),
(39, '', 'Eko Prasetyo', 'Non-Anggota', 'Universitas Indonesia', 'Ruang Baca Umum', '2025-06-24', '13:52:00', '2025-06-24 13:52:00', NULL),
(40, '', 'Budi Santoso', 'Non-Anggota', 'Umum', 'Ruang Multimedia', '2025-12-07', '10:59:00', '2025-12-07 10:59:00', NULL),
(41, '36439', 'Rina Marlina', 'Anggota', 'ITB', 'Layanan Anak', '2025-10-20', '13:19:00', '2025-10-20 13:19:00', NULL),
(42, '', 'Budi Santoso', 'Non-Anggota', 'SMA Negeri 1', 'Ruang Koleksi Referensi', '2025-10-26', '13:24:00', '2025-10-26 13:24:00', NULL),
(43, '', 'Budi Santoso', 'Non-Anggota', 'SMA Negeri 1', 'Layanan Anak', '2025-10-15', '09:57:00', '2025-10-15 09:57:00', NULL),
(44, '17950', 'Eko Prasetyo', 'Anggota', 'ITB', 'Layanan Sirkulasi', '2025-10-12', '13:00:00', '2025-10-12 13:00:00', NULL),
(45, '', 'Maya Putri', 'Non-Anggota', 'Universitas Indonesia', 'Ruang Multimedia', '2025-07-16', '13:51:00', '2025-07-16 13:51:00', NULL),
(46, '89491', 'Dewi Lestari', 'Anggota', 'ITB', 'Ruang Baca Umum', '2025-07-02', '10:14:00', '2025-07-02 10:14:00', NULL),
(47, '', 'Eko Prasetyo', 'Non-Anggota', 'Universitas Indonesia', 'Layanan Sirkulasi', '2025-01-26', '13:27:00', '2025-01-26 13:27:00', NULL),
(48, '', 'Eko Prasetyo', 'Non-Anggota', 'UGM', 'Ruang Koleksi Referensi', '2025-03-10', '08:20:00', '2025-03-10 08:20:00', NULL),
(49, '', 'Siti Aminah', 'Non-Anggota', 'Perpustakaan Daerah', 'Layanan Sirkulasi', '2025-02-22', '13:14:00', '2025-02-22 13:14:00', NULL),
(50, '', 'Budi Santoso', 'Non-Anggota', 'ITB', 'Ruang Baca Umum', '2025-08-18', '09:30:00', '2025-08-18 09:30:00', NULL),
(51, '', 'Eko Prasetyo', 'Non-Anggota', 'ITB', 'Ruang Multimedia', '2025-04-18', '16:16:00', '2025-04-18 16:16:00', NULL),
(52, '', 'Siti Aminah', 'Non-Anggota', 'UGM', 'Ruang Koleksi Referensi', '2025-11-04', '13:45:00', '2025-11-04 13:45:00', NULL),
(53, '', 'Eko Prasetyo', 'Non-Anggota', 'SMA Negeri 1', 'Layanan Anak', '2025-05-02', '09:40:00', '2025-05-02 09:40:00', NULL),
(54, '', 'Nurul Hidayah', 'Non-Anggota', 'UGM', 'Layanan Sirkulasi', '2025-01-15', '11:02:00', '2025-01-15 11:02:00', NULL),
(55, '', 'Joko Susilo', 'Non-Anggota', 'SMA Negeri 1', 'Ruang Koleksi Referensi', '2025-01-13', '10:14:00', '2025-01-13 10:14:00', NULL),
(56, '', 'Agus Setiawan', 'Non-Anggota', 'Dinas Pendidikan', 'Ruang Multimedia', '2025-04-10', '12:01:00', '2025-04-10 12:01:00', NULL),
(57, '', 'Rina Marlina', 'Non-Anggota', 'Universitas Indonesia', 'Layanan Sirkulasi', '2025-02-26', '13:17:00', '2025-02-26 13:17:00', NULL),
(58, '', 'Rudi Hartono', 'Non-Anggota', 'Universitas Indonesia', 'Layanan Anak', '2025-02-16', '08:46:00', '2025-02-16 08:46:00', NULL),
(59, '21496', 'Rudi Hartono', 'Anggota', 'Perpustakaan Daerah', 'Ruang Baca Umum', '2025-11-07', '12:54:00', '2025-11-07 12:54:00', NULL),
(60, '', 'Dewi Lestari', 'Non-Anggota', 'Perpustakaan Daerah', 'Ruang Baca Umum', '2025-03-03', '09:33:00', '2025-03-03 09:33:00', NULL),
(61, '', 'Budi Santoso', 'Non-Anggota', 'Perpustakaan Daerah', 'Ruang Koleksi Referensi', '2025-06-21', '10:20:00', '2025-06-21 10:20:00', NULL),
(62, '', 'Agus Setiawan', 'Non-Anggota', 'Dinas Pendidikan', 'Ruang Multimedia', '2025-01-09', '14:38:00', '2025-01-09 14:38:00', NULL),
(63, '93553', 'Budi Santoso', 'Anggota', 'SMA Negeri 1', 'Layanan Sirkulasi', '2025-11-03', '09:05:00', '2025-11-03 09:05:00', NULL),
(64, '63025', 'Maya Putri', 'Anggota', 'Umum', 'Ruang Multimedia', '2025-02-24', '12:20:00', '2025-02-24 12:20:00', NULL),
(65, '', 'Siti Aminah', 'Non-Anggota', 'ITB', 'Ruang Koleksi Referensi', '2025-10-13', '09:07:00', '2025-10-13 09:07:00', NULL),
(66, '', 'Joko Susilo', 'Non-Anggota', 'ITB', 'Ruang Koleksi Referensi', '2025-08-16', '10:26:00', '2025-08-16 10:26:00', NULL),
(67, '94635', 'Agus Setiawan', 'Anggota', 'Umum', 'Ruang Koleksi Referensi', '2025-01-11', '16:17:00', '2025-01-11 16:17:00', NULL),
(68, '39605', 'Eko Prasetyo', 'Anggota', 'SMA Negeri 1', 'Layanan Sirkulasi', '2025-02-17', '14:54:00', '2025-02-17 14:54:00', NULL),
(69, '', 'Nurul Hidayah', 'Non-Anggota', 'SMA Negeri 1', 'Ruang Baca Umum', '2025-04-12', '12:18:00', '2025-04-12 12:18:00', NULL),
(70, '', 'Rudi Hartono', 'Non-Anggota', 'Perpustakaan Daerah', 'Ruang Multimedia', '2025-05-01', '13:46:00', '2025-05-01 13:46:00', NULL),
(71, '', 'Nurul Hidayah', 'Non-Anggota', 'SMA Negeri 1', 'Layanan Sirkulasi', '2025-01-02', '13:09:00', '2025-01-02 13:09:00', NULL),
(72, '', 'Rudi Hartono', 'Non-Anggota', 'UGM', 'Layanan Anak', '2025-02-26', '11:34:00', '2025-02-26 11:34:00', NULL),
(73, '98039', 'Joko Susilo', 'Anggota', 'SMA Negeri 1', 'Ruang Baca Umum', '2025-05-24', '13:25:00', '2025-05-24 13:25:00', NULL),
(74, '51231', 'Agus Setiawan', 'Anggota', 'Perpustakaan Daerah', 'Layanan Anak', '2025-02-03', '12:59:00', '2025-02-03 12:59:00', NULL),
(75, '', 'Siti Aminah', 'Non-Anggota', 'Universitas Indonesia', 'Layanan Sirkulasi', '2025-03-13', '11:50:00', '2025-03-13 11:50:00', NULL),
(76, '73668', 'Maya Putri', 'Anggota', 'Universitas Indonesia', 'Ruang Baca Umum', '2025-06-17', '15:11:00', '2025-06-17 15:11:00', NULL),
(77, '', 'Budi Santoso', 'Non-Anggota', 'Dinas Pendidikan', 'Layanan Anak', '2025-01-06', '09:43:00', '2025-01-06 09:43:00', NULL),
(78, '26945', 'Agus Setiawan', 'Anggota', 'Umum', 'Layanan Anak', '2025-01-08', '08:14:00', '2025-01-08 08:14:00', NULL),
(79, '', 'Dewi Lestari', 'Non-Anggota', 'Universitas Indonesia', 'Layanan Anak', '2025-05-09', '13:31:00', '2025-05-09 13:31:00', NULL),
(80, '', 'Rudi Hartono', 'Non-Anggota', 'SMA Negeri 1', 'Ruang Multimedia', '2025-04-07', '09:15:00', '2025-04-07 09:15:00', NULL),
(81, '59309', 'Budi Santoso', 'Anggota', 'SMA Negeri 1', 'Ruang Multimedia', '2025-12-09', '08:39:00', '2025-12-09 08:39:00', NULL),
(82, '', 'Budi Santoso', 'Non-Anggota', 'Dinas Pendidikan', 'Ruang Multimedia', '2025-08-15', '14:56:00', '2025-08-15 14:56:00', NULL),
(83, '', 'Nurul Hidayah', 'Non-Anggota', 'Perpustakaan Daerah', 'Layanan Sirkulasi', '2025-08-11', '15:24:00', '2025-08-11 15:24:00', NULL),
(84, '', 'Nurul Hidayah', 'Non-Anggota', 'Universitas Indonesia', 'Ruang Koleksi Referensi', '2025-09-13', '12:41:00', '2025-09-13 12:41:00', NULL),
(85, '61839', 'Siti Aminah', 'Anggota', 'SMA Negeri 1', 'Ruang Multimedia', '2025-05-25', '13:59:00', '2025-05-25 13:59:00', NULL),
(86, '', 'Agus Setiawan', 'Non-Anggota', 'UGM', 'Ruang Multimedia', '2025-07-27', '13:14:00', '2025-07-27 13:14:00', NULL),
(87, '', 'Nurul Hidayah', 'Non-Anggota', 'Universitas Indonesia', 'Ruang Baca Umum', '2025-11-09', '11:29:00', '2025-11-09 11:29:00', NULL),
(88, '31811', 'Maya Putri', 'Anggota', 'Umum', 'Ruang Multimedia', '2025-02-15', '09:04:00', '2025-02-15 09:04:00', NULL),
(89, '', 'Rina Marlina', 'Non-Anggota', 'Dinas Pendidikan', 'Layanan Anak', '2025-10-19', '12:39:00', '2025-10-19 12:39:00', NULL),
(90, '', 'Dewi Lestari', 'Non-Anggota', 'Universitas Indonesia', 'Ruang Multimedia', '2025-07-04', '16:35:00', '2025-07-04 16:35:00', NULL),
(91, '', 'Agus Setiawan', 'Non-Anggota', 'ITB', 'Ruang Baca Umum', '2025-05-07', '11:08:00', '2025-05-07 11:08:00', NULL),
(92, '97433', 'Siti Aminah', 'Anggota', 'UGM', 'Ruang Multimedia', '2025-02-24', '13:39:00', '2025-02-24 13:39:00', NULL),
(93, '', 'Rudi Hartono', 'Non-Anggota', 'Dinas Pendidikan', 'Layanan Sirkulasi', '2025-02-01', '16:54:00', '2025-02-01 16:54:00', NULL),
(94, '', 'Maya Putri', 'Non-Anggota', 'SMA Negeri 1', 'Ruang Multimedia', '2025-11-25', '12:01:00', '2025-11-25 12:01:00', NULL),
(95, '', 'Agus Setiawan', 'Non-Anggota', 'SMA Negeri 1', 'Layanan Sirkulasi', '2025-05-23', '11:34:00', '2025-05-23 11:34:00', NULL),
(96, '58083', 'Rudi Hartono', 'Anggota', 'SMA Negeri 1', 'Ruang Multimedia', '2025-09-01', '12:33:00', '2025-09-01 12:33:00', NULL),
(97, '25562', 'Siti Aminah', 'Anggota', 'Umum', 'Ruang Baca Umum', '2025-06-17', '14:30:00', '2025-06-17 14:30:00', NULL),
(98, '', 'Budi Santoso', 'Non-Anggota', 'SMA Negeri 1', 'Ruang Koleksi Referensi', '2025-04-12', '08:54:00', '2025-04-12 08:54:00', NULL),
(99, '', 'Nurul Hidayah', 'Non-Anggota', 'Dinas Pendidikan', 'Ruang Multimedia', '2025-02-24', '14:01:00', '2025-02-24 14:01:00', NULL),
(100, '42943', 'Nurul Hidayah', 'Anggota', 'Dinas Pendidikan', 'Layanan Anak', '2025-09-21', '15:05:00', '2025-09-21 15:05:00', NULL),
(101, '', 'Nurul Hidayah', 'Non-Anggota', 'SMA Negeri 1', 'Ruang Baca Umum', '2025-09-03', '11:16:00', '2025-09-03 11:16:00', NULL),
(102, '69621', 'Agus Setiawan', 'Anggota', 'Dinas Pendidikan', 'Ruang Baca Umum', '2025-06-13', '14:55:00', '2025-06-13 14:55:00', NULL),
(103, '', 'Eko Prasetyo', 'Non-Anggota', 'ITB', 'Ruang Baca Umum', '2025-04-19', '12:55:00', '2025-04-19 12:55:00', NULL),
(104, '', 'Rina Marlina', 'Non-Anggota', 'ITB', 'Ruang Multimedia', '2025-10-15', '11:55:00', '2025-10-15 11:55:00', NULL),
(105, '64976', 'Budi Santoso', 'Anggota', 'Universitas Indonesia', 'Layanan Anak', '2025-09-08', '15:27:00', '2025-09-08 15:27:00', NULL),
(106, '', 'Budi Santoso', 'Non-Anggota', 'Universitas Indonesia', 'Ruang Koleksi Referensi', '2025-06-27', '12:51:00', '2025-06-27 12:51:00', NULL),
(107, '44915', 'Joko Susilo', 'Anggota', 'ITB', 'Ruang Multimedia', '2025-09-19', '10:40:00', '2025-09-19 10:40:00', NULL),
(108, '', 'Nurul Hidayah', 'Non-Anggota', 'Umum', 'Layanan Anak', '2025-01-26', '08:09:00', '2025-01-26 08:09:00', NULL),
(109, '', 'Rudi Hartono', 'Non-Anggota', 'Universitas Indonesia', 'Layanan Sirkulasi', '2025-09-13', '10:30:00', '2025-09-13 10:30:00', NULL),
(110, '', 'Budi Santoso', 'Non-Anggota', 'ITB', 'Layanan Anak', '2025-09-05', '13:54:00', '2025-09-05 13:54:00', NULL),
(111, '57897', 'Joko Susilo', 'Anggota', 'Umum', 'Ruang Baca Umum', '2025-06-16', '14:00:00', '2025-06-16 14:00:00', NULL),
(112, '', 'Dewi Lestari', 'Non-Anggota', 'Dinas Pendidikan', 'Ruang Baca Umum', '2025-06-09', '10:23:00', '2025-06-09 10:23:00', NULL),
(113, '', 'Dewi Lestari', 'Non-Anggota', 'Dinas Pendidikan', 'Ruang Baca Umum', '2025-09-23', '13:10:00', '2025-09-23 13:10:00', NULL),
(114, '55305', 'Agus Setiawan', 'Anggota', 'Umum', 'Ruang Baca Umum', '2025-09-11', '09:42:00', '2025-09-11 09:42:00', NULL),
(115, '', 'Agus Setiawan', 'Non-Anggota', 'Perpustakaan Daerah', 'Ruang Multimedia', '2025-03-07', '14:27:00', '2025-03-07 14:27:00', NULL),
(116, '28785', 'Agus Setiawan', 'Anggota', 'UGM', 'Ruang Baca Umum', '2025-02-28', '09:06:00', '2025-02-28 09:06:00', NULL),
(117, '', 'Joko Susilo', 'Non-Anggota', 'Umum', 'Ruang Koleksi Referensi', '2025-02-09', '16:11:00', '2025-02-09 16:11:00', NULL),
(118, '63833', 'Nurul Hidayah', 'Anggota', 'SMA Negeri 1', 'Layanan Sirkulasi', '2025-06-17', '08:33:00', '2025-06-17 08:33:00', NULL),
(119, '48837', 'Agus Setiawan', 'Anggota', 'UGM', 'Ruang Koleksi Referensi', '2025-03-28', '12:55:00', '2025-03-28 12:55:00', NULL),
(120, '74302', 'Siti Aminah', 'Anggota', 'Dinas Pendidikan', 'Ruang Multimedia', '2025-12-24', '15:05:00', '2025-12-24 15:05:00', NULL),
(121, '', 'Rudi Hartono', 'Non-Anggota', 'Perpustakaan Daerah', 'Ruang Koleksi Referensi', '2025-11-23', '11:49:00', '2025-11-23 11:49:00', NULL),
(122, '', 'Maya Putri', 'Non-Anggota', 'Umum', 'Ruang Koleksi Referensi', '2025-06-23', '09:06:00', '2025-06-23 09:06:00', NULL),
(123, '', 'Rina Marlina', 'Non-Anggota', 'Umum', 'Ruang Multimedia', '2025-09-10', '15:07:00', '2025-09-10 15:07:00', NULL),
(124, '', 'Maya Putri', 'Non-Anggota', 'SMA Negeri 1', 'Layanan Sirkulasi', '2025-12-28', '09:32:00', '2025-12-28 09:32:00', NULL),
(125, '', 'Eko Prasetyo', 'Non-Anggota', 'Universitas Indonesia', 'Layanan Anak', '2025-08-22', '08:32:00', '2025-08-22 08:32:00', NULL),
(126, '', 'Rudi Hartono', 'Non-Anggota', 'Perpustakaan Daerah', 'Ruang Multimedia', '2025-11-10', '14:28:00', '2025-11-10 14:28:00', NULL),
(127, '78824', 'Rudi Hartono', 'Anggota', 'SMA Negeri 1', 'Ruang Koleksi Referensi', '2025-11-14', '12:51:00', '2025-11-14 12:51:00', NULL),
(128, '', 'Rudi Hartono', 'Non-Anggota', 'Universitas Indonesia', 'Ruang Koleksi Referensi', '2025-02-22', '14:04:00', '2025-02-22 14:04:00', NULL),
(129, '', 'Nurul Hidayah', 'Non-Anggota', 'SMA Negeri 1', 'Ruang Baca Umum', '2025-05-06', '11:17:00', '2025-05-06 11:17:00', NULL),
(130, '', 'Rudi Hartono', 'Non-Anggota', 'Umum', 'Ruang Baca Umum', '2025-03-15', '14:34:00', '2025-03-15 14:34:00', NULL),
(131, '70091', 'Dewi Lestari', 'Anggota', 'Perpustakaan Daerah', 'Ruang Baca Umum', '2025-01-25', '11:45:00', '2025-01-25 11:45:00', NULL),
(132, '', 'Maya Putri', 'Non-Anggota', 'Universitas Indonesia', 'Ruang Baca Umum', '2025-04-15', '15:36:00', '2025-04-15 15:36:00', NULL),
(133, '', 'Eko Prasetyo', 'Non-Anggota', 'UGM', 'Layanan Sirkulasi', '2025-08-02', '13:15:00', '2025-08-02 13:15:00', NULL),
(134, '53096', 'Budi Santoso', 'Anggota', 'SMA Negeri 1', 'Layanan Anak', '2025-04-23', '08:46:00', '2025-04-23 08:46:00', NULL),
(135, '', 'Nurul Hidayah', 'Non-Anggota', 'Dinas Pendidikan', 'Layanan Anak', '2025-10-02', '08:12:00', '2025-10-02 08:12:00', NULL),
(136, '', 'Dewi Lestari', 'Non-Anggota', 'Umum', 'Ruang Multimedia', '2025-02-20', '13:09:00', '2025-02-20 13:09:00', NULL),
(137, '', 'Rudi Hartono', 'Non-Anggota', 'UGM', 'Ruang Multimedia', '2025-10-22', '12:02:00', '2025-10-22 12:02:00', NULL),
(138, '', 'Rudi Hartono', 'Non-Anggota', 'UGM', 'Layanan Sirkulasi', '2025-11-03', '10:24:00', '2025-11-03 10:24:00', NULL),
(139, '16418', 'Rina Marlina', 'Anggota', 'Perpustakaan Daerah', 'Ruang Baca Umum', '2025-11-07', '14:22:00', '2025-11-07 14:22:00', NULL),
(140, '54631', 'Agus Setiawan', 'Anggota', 'Perpustakaan Daerah', 'Ruang Multimedia', '2025-06-28', '08:08:00', '2025-06-28 08:08:00', NULL),
(141, '', 'Budi Santoso', 'Non-Anggota', 'Dinas Pendidikan', 'Layanan Sirkulasi', '2025-08-26', '13:20:00', '2025-08-26 13:20:00', NULL),
(142, '79221', 'Budi Santoso', 'Anggota', 'UGM', 'Ruang Multimedia', '2025-02-04', '14:49:00', '2025-02-04 14:49:00', NULL),
(143, '', 'Nurul Hidayah', 'Non-Anggota', 'Dinas Pendidikan', 'Ruang Koleksi Referensi', '2025-03-24', '09:29:00', '2025-03-24 09:29:00', NULL),
(144, '', 'Rina Marlina', 'Non-Anggota', 'SMA Negeri 1', 'Ruang Baca Umum', '2025-10-28', '16:02:00', '2025-10-28 16:02:00', NULL),
(145, '55021', 'Joko Susilo', 'Anggota', 'ITB', 'Ruang Koleksi Referensi', '2025-02-23', '11:19:00', '2025-02-23 11:19:00', NULL),
(146, '', 'Rina Marlina', 'Non-Anggota', 'Dinas Pendidikan', 'Layanan Sirkulasi', '2025-02-26', '10:57:00', '2025-02-26 10:57:00', NULL),
(147, '', 'Maya Putri', 'Non-Anggota', 'Dinas Pendidikan', 'Layanan Sirkulasi', '2025-11-14', '10:41:00', '2025-11-14 10:41:00', NULL),
(148, '', 'Dewi Lestari', 'Non-Anggota', 'ITB', 'Ruang Koleksi Referensi', '2025-11-24', '13:07:00', '2025-11-24 13:07:00', NULL),
(149, '', 'Rina Marlina', 'Non-Anggota', 'UGM', 'Layanan Anak', '2025-09-24', '15:41:00', '2025-09-24 15:41:00', NULL),
(150, '78736', 'Budi Santoso', 'Anggota', 'Dinas Pendidikan', 'Layanan Anak', '2025-08-20', '14:13:00', '2025-08-20 14:13:00', NULL),
(151, '', 'Siti Aminah', 'Non-Anggota', 'Umum', 'Layanan Sirkulasi', '2025-04-25', '13:32:00', '2025-04-25 13:32:00', NULL),
(152, '19532', 'Nurul Hidayah', 'Anggota', 'SMA Negeri 1', 'Ruang Baca Umum', '2025-04-20', '15:11:00', '2025-04-20 15:11:00', NULL),
(153, '', 'Rudi Hartono', 'Non-Anggota', 'Dinas Pendidikan', 'Layanan Sirkulasi', '2025-07-03', '16:12:00', '2025-07-03 16:12:00', NULL),
(154, '', 'Eko Prasetyo', 'Non-Anggota', 'Dinas Pendidikan', 'Ruang Koleksi Referensi', '2025-09-25', '15:06:00', '2025-09-25 15:06:00', NULL),
(155, '', 'Rina Marlina', 'Non-Anggota', 'UGM', 'Ruang Koleksi Referensi', '2025-02-28', '13:17:00', '2025-02-28 13:17:00', NULL),
(156, '32150', 'Nurul Hidayah', 'Anggota', 'UGM', 'Ruang Multimedia', '2025-10-23', '10:19:00', '2025-10-23 10:19:00', NULL),
(157, '', 'Eko Prasetyo', 'Non-Anggota', 'Universitas Indonesia', 'Layanan Sirkulasi', '2025-04-01', '09:30:00', '2025-04-01 09:30:00', NULL),
(158, '', 'Siti Aminah', 'Non-Anggota', 'Umum', 'Ruang Multimedia', '2025-12-03', '12:33:00', '2025-12-03 12:33:00', NULL),
(159, '69097', 'Dewi Lestari', 'Anggota', 'ITB', 'Ruang Multimedia', '2025-04-27', '14:57:00', '2025-04-27 14:57:00', NULL),
(160, '', 'Eko Prasetyo', 'Non-Anggota', 'Universitas Indonesia', 'Layanan Anak', '2025-10-23', '16:05:00', '2025-10-23 16:05:00', NULL),
(161, '63628', 'Joko Susilo', 'Anggota', 'Umum', 'Ruang Baca Umum', '2025-08-19', '13:18:00', '2025-08-19 13:18:00', NULL),
(162, '', 'Joko Susilo', 'Non-Anggota', 'UGM', 'Layanan Sirkulasi', '2025-04-18', '08:09:00', '2025-04-18 08:09:00', NULL),
(163, '36769', 'Joko Susilo', 'Anggota', 'UGM', 'Ruang Multimedia', '2025-06-28', '16:56:00', '2025-06-28 16:56:00', NULL),
(164, '', 'Joko Susilo', 'Non-Anggota', 'Dinas Pendidikan', 'Layanan Sirkulasi', '2025-04-25', '12:14:00', '2025-04-25 12:14:00', NULL),
(165, '', 'Rudi Hartono', 'Non-Anggota', 'Dinas Pendidikan', 'Layanan Sirkulasi', '2025-11-12', '12:45:00', '2025-11-12 12:45:00', NULL),
(166, '', 'Rudi Hartono', 'Non-Anggota', 'Dinas Pendidikan', 'Ruang Koleksi Referensi', '2025-07-04', '10:55:00', '2025-07-04 10:55:00', NULL),
(167, '', 'Eko Prasetyo', 'Non-Anggota', 'Perpustakaan Daerah', 'Layanan Anak', '2025-08-04', '10:35:00', '2025-08-04 10:35:00', NULL),
(168, '', 'Rina Marlina', 'Non-Anggota', 'Perpustakaan Daerah', 'Layanan Anak', '2025-06-04', '10:03:00', '2025-06-04 10:03:00', NULL),
(169, '', 'Rina Marlina', 'Non-Anggota', 'Umum', 'Ruang Multimedia', '2025-06-11', '12:06:00', '2025-06-11 12:06:00', NULL),
(170, '28255', 'Dewi Lestari', 'Anggota', 'ITB', 'Ruang Koleksi Referensi', '2025-02-09', '13:03:00', '2025-02-09 13:03:00', NULL),
(171, '', 'Siti Aminah', 'Non-Anggota', 'Umum', 'Layanan Sirkulasi', '2025-06-02', '13:10:00', '2025-06-02 13:10:00', NULL),
(172, '46263', 'Joko Susilo', 'Anggota', 'UGM', 'Ruang Multimedia', '2025-04-10', '10:37:00', '2025-04-10 10:37:00', NULL),
(173, '', 'Rudi Hartono', 'Non-Anggota', 'Dinas Pendidikan', 'Ruang Koleksi Referensi', '2025-04-28', '09:41:00', '2025-04-28 09:41:00', NULL),
(174, '', 'Maya Putri', 'Non-Anggota', 'SMA Negeri 1', 'Ruang Multimedia', '2025-12-12', '11:20:00', '2025-12-12 11:20:00', NULL),
(175, '', 'Budi Santoso', 'Non-Anggota', 'ITB', 'Ruang Koleksi Referensi', '2025-06-08', '10:46:00', '2025-06-08 10:46:00', NULL),
(176, '', 'Agus Setiawan', 'Non-Anggota', 'UGM', 'Ruang Koleksi Referensi', '2025-04-26', '14:48:00', '2025-04-26 14:48:00', NULL),
(177, '46192', 'Budi Santoso', 'Anggota', 'Universitas Indonesia', 'Layanan Sirkulasi', '2025-10-11', '16:20:00', '2025-10-11 16:20:00', NULL),
(178, '', 'Rudi Hartono', 'Non-Anggota', 'SMA Negeri 1', 'Ruang Baca Umum', '2025-07-23', '15:15:00', '2025-07-23 15:15:00', NULL),
(179, '37007', 'Dewi Lestari', 'Anggota', 'ITB', 'Layanan Anak', '2025-03-12', '15:46:00', '2025-03-12 15:46:00', NULL),
(180, '', 'Rudi Hartono', 'Non-Anggota', 'Umum', 'Ruang Baca Umum', '2025-09-14', '14:31:00', '2025-09-14 14:31:00', NULL),
(181, '37502', 'Maya Putri', 'Anggota', 'ITB', 'Layanan Sirkulasi', '2025-06-25', '14:38:00', '2025-06-25 14:38:00', NULL),
(182, '31745', 'Joko Susilo', 'Anggota', 'Perpustakaan Daerah', 'Ruang Koleksi Referensi', '2025-11-18', '14:50:00', '2025-11-18 14:50:00', NULL),
(183, '42645', 'Dewi Lestari', 'Anggota', 'ITB', 'Ruang Multimedia', '2025-09-28', '08:52:00', '2025-09-28 08:52:00', NULL),
(184, '78780', 'Eko Prasetyo', 'Anggota', 'Universitas Indonesia', 'Ruang Baca Umum', '2025-07-16', '14:00:00', '2025-07-16 14:00:00', NULL),
(185, '', 'Joko Susilo', 'Non-Anggota', 'ITB', 'Ruang Baca Umum', '2025-12-25', '16:21:00', '2025-12-25 16:21:00', NULL),
(186, '', 'Eko Prasetyo', 'Non-Anggota', 'ITB', 'Ruang Koleksi Referensi', '2025-01-14', '14:50:00', '2025-01-14 14:50:00', NULL),
(187, '', 'Agus Setiawan', 'Non-Anggota', 'UGM', 'Ruang Baca Umum', '2025-07-13', '11:09:00', '2025-07-13 11:09:00', NULL),
(188, '88821', 'Rudi Hartono', 'Anggota', 'Umum', 'Layanan Anak', '2025-07-07', '13:03:00', '2025-07-07 13:03:00', NULL),
(189, '', 'Joko Susilo', 'Non-Anggota', 'Dinas Pendidikan', 'Ruang Koleksi Referensi', '2025-12-05', '10:17:00', '2025-12-05 10:17:00', NULL),
(190, '48345', 'Siti Aminah', 'Anggota', 'ITB', 'Ruang Multimedia', '2025-10-22', '16:43:00', '2025-10-22 16:43:00', NULL),
(191, '', 'Rina Marlina', 'Non-Anggota', 'Perpustakaan Daerah', 'Layanan Sirkulasi', '2025-08-07', '12:21:00', '2025-08-07 12:21:00', NULL),
(192, '', 'Joko Susilo', 'Non-Anggota', 'ITB', 'Ruang Multimedia', '2025-04-28', '09:45:00', '2025-04-28 09:45:00', NULL),
(193, '22667', 'Agus Setiawan', 'Anggota', 'Perpustakaan Daerah', 'Ruang Baca Umum', '2025-04-10', '09:46:00', '2025-04-10 09:46:00', NULL),
(194, '13521', 'Rudi Hartono', 'Anggota', 'Universitas Indonesia', 'Ruang Baca Umum', '2025-01-27', '15:40:00', '2025-01-27 15:40:00', NULL),
(195, '89445', 'Budi Santoso', 'Anggota', 'Dinas Pendidikan', 'Ruang Multimedia', '2025-07-06', '15:47:00', '2025-07-06 15:47:00', NULL),
(196, '', 'Rina Marlina', 'Non-Anggota', 'Perpustakaan Daerah', 'Ruang Baca Umum', '2025-10-02', '15:49:00', '2025-10-02 15:49:00', NULL),
(197, '', 'Rudi Hartono', 'Non-Anggota', 'Umum', 'Layanan Anak', '2025-08-06', '09:02:00', '2025-08-06 09:02:00', NULL),
(198, '57946', 'Eko Prasetyo', 'Anggota', 'SMA Negeri 1', 'Ruang Multimedia', '2025-01-28', '10:55:00', '2025-01-28 10:55:00', NULL),
(199, '35215', 'Eko Prasetyo', 'Anggota', 'Universitas Indonesia', 'Ruang Koleksi Referensi', '2025-06-14', '13:23:00', '2025-06-14 13:23:00', NULL),
(200, '43960', 'Rina Marlina', 'Anggota', 'SMA Negeri 1', 'Ruang Multimedia', '2025-02-02', '09:34:00', '2025-02-02 09:34:00', NULL),
(201, '', 'Siti Aminah', 'Non-Anggota', 'Dinas Pendidikan', 'Ruang Baca Umum', '2025-02-07', '15:37:00', '2025-02-07 15:37:00', NULL),
(202, '76689', 'Rudi Hartono', 'Anggota', 'Dinas Pendidikan', 'Ruang Koleksi Referensi', '2025-04-07', '13:05:00', '2025-04-07 13:05:00', NULL),
(203, '15227', 'Dewi Lestari', 'Anggota', 'Universitas Indonesia', 'Layanan Sirkulasi', '2025-08-16', '14:17:00', '2025-08-16 14:17:00', NULL),
(204, '', 'Siti Aminah', 'Non-Anggota', 'Universitas Indonesia', 'Ruang Koleksi Referensi', '2025-03-09', '08:49:00', '2025-03-09 08:49:00', NULL),
(205, '', 'Dewi Lestari', 'Non-Anggota', 'UGM', 'Ruang Koleksi Referensi', '2025-08-23', '15:50:00', '2025-08-23 15:50:00', NULL),
(206, '78684', 'Budi Santoso', 'Anggota', 'Umum', 'Layanan Sirkulasi', '2025-11-22', '15:59:00', '2025-11-22 15:59:00', NULL),
(207, '', 'Agus Setiawan', 'Non-Anggota', 'Dinas Pendidikan', 'Layanan Sirkulasi', '2025-08-20', '09:14:00', '2025-08-20 09:14:00', NULL),
(208, '', 'Budi Santoso', 'Non-Anggota', 'SMA Negeri 1', 'Layanan Sirkulasi', '2025-04-16', '16:23:00', '2025-04-16 16:23:00', NULL),
(209, '61615', 'Agus Setiawan', 'Anggota', 'SMA Negeri 1', 'Ruang Koleksi Referensi', '2025-12-03', '10:41:00', '2025-12-03 10:41:00', NULL),
(210, '96905', 'Agus Setiawan', 'Anggota', 'ITB', 'Ruang Baca Umum', '2025-03-18', '11:10:00', '2025-03-18 11:10:00', NULL),
(211, '88933', 'Dewi Lestari', 'Anggota', 'Perpustakaan Daerah', 'Layanan Sirkulasi', '2025-10-11', '10:46:00', '2025-10-11 10:46:00', NULL),
(212, '12885', 'Maya Putri', 'Anggota', 'UGM', 'Ruang Baca Umum', '2025-04-01', '16:29:00', '2025-04-01 16:29:00', NULL),
(213, '60978', 'Maya Putri', 'Anggota', 'SMA Negeri 1', 'Ruang Koleksi Referensi', '2025-07-24', '15:01:00', '2025-07-24 15:01:00', NULL),
(214, '26248', 'Dewi Lestari', 'Anggota', 'Umum', 'Ruang Baca Umum', '2025-07-23', '09:00:00', '2025-07-23 09:00:00', NULL),
(215, '83462', 'Eko Prasetyo', 'Anggota', 'UGM', 'Ruang Multimedia', '2025-12-04', '15:22:00', '2025-12-04 15:22:00', NULL),
(216, '', 'Budi Santoso', 'Non-Anggota', 'SMA Negeri 1', 'Layanan Anak', '2025-01-03', '15:08:00', '2025-01-03 15:08:00', NULL),
(217, '', 'Agus Setiawan', 'Non-Anggota', 'Universitas Indonesia', 'Ruang Baca Umum', '2025-12-24', '08:28:00', '2025-12-24 08:28:00', NULL),
(218, '86575', 'Nurul Hidayah', 'Anggota', 'SMA Negeri 1', 'Layanan Sirkulasi', '2025-12-20', '11:01:00', '2025-12-20 11:01:00', NULL),
(219, '', 'Maya Putri', 'Non-Anggota', 'Perpustakaan Daerah', 'Ruang Baca Umum', '2025-12-28', '13:56:00', '2025-12-28 13:56:00', NULL),
(220, '', 'Eko Prasetyo', 'Non-Anggota', 'UGM', 'Layanan Sirkulasi', '2025-06-05', '12:17:00', '2025-06-05 12:17:00', NULL),
(221, '', 'Maya Putri', 'Non-Anggota', 'Universitas Indonesia', 'Layanan Sirkulasi', '2025-03-27', '14:21:00', '2025-03-27 14:21:00', NULL),
(222, '', 'Rudi Hartono', 'Non-Anggota', 'SMA Negeri 1', 'Ruang Koleksi Referensi', '2025-04-11', '12:21:00', '2025-04-11 12:21:00', NULL),
(223, '92277', 'Eko Prasetyo', 'Anggota', 'Universitas Indonesia', 'Layanan Anak', '2025-11-15', '16:23:00', '2025-11-15 16:23:00', NULL),
(224, '', 'Siti Aminah', 'Non-Anggota', 'Perpustakaan Daerah', 'Layanan Sirkulasi', '2025-05-27', '15:23:00', '2025-05-27 15:23:00', NULL),
(225, '', 'Nurul Hidayah', 'Non-Anggota', 'ITB', 'Ruang Multimedia', '2025-04-23', '10:24:00', '2025-04-23 10:24:00', NULL),
(226, '', 'Agus Setiawan', 'Non-Anggota', 'SMA Negeri 1', 'Ruang Baca Umum', '2025-01-11', '13:42:00', '2025-01-11 13:42:00', NULL),
(227, '', 'Rudi Hartono', 'Non-Anggota', 'SMA Negeri 1', 'Ruang Baca Umum', '2025-05-24', '10:29:00', '2025-05-24 10:29:00', NULL),
(228, '60224', 'Dewi Lestari', 'Anggota', 'Dinas Pendidikan', 'Layanan Sirkulasi', '2025-06-14', '13:16:00', '2025-06-14 13:16:00', NULL),
(229, '', 'Dewi Lestari', 'Non-Anggota', 'Umum', 'Layanan Sirkulasi', '2025-07-02', '12:53:00', '2025-07-02 12:53:00', NULL),
(230, '25253', 'Eko Prasetyo', 'Anggota', 'UGM', 'Ruang Multimedia', '2025-01-16', '11:31:00', '2025-01-16 11:31:00', NULL),
(231, '', 'Budi Santoso', 'Non-Anggota', 'Universitas Indonesia', 'Ruang Baca Umum', '2025-11-09', '13:19:00', '2025-11-09 13:19:00', NULL),
(232, '39607', 'Nurul Hidayah', 'Anggota', 'Universitas Indonesia', 'Ruang Baca Umum', '2025-05-10', '14:19:00', '2025-05-10 14:19:00', NULL),
(233, '45445', 'Rudi Hartono', 'Anggota', 'Dinas Pendidikan', 'Ruang Koleksi Referensi', '2025-10-06', '13:13:00', '2025-10-06 13:13:00', NULL),
(234, '', 'Maya Putri', 'Non-Anggota', 'UGM', 'Layanan Anak', '2025-04-10', '13:09:00', '2025-04-10 13:09:00', NULL),
(235, '66175', 'Siti Aminah', 'Anggota', 'UGM', 'Ruang Koleksi Referensi', '2025-07-02', '16:03:00', '2025-07-02 16:03:00', NULL),
(236, '', 'Joko Susilo', 'Non-Anggota', 'Dinas Pendidikan', 'Layanan Sirkulasi', '2025-10-22', '13:53:00', '2025-10-22 13:53:00', NULL),
(237, '', 'Nurul Hidayah', 'Non-Anggota', 'UGM', 'Ruang Koleksi Referensi', '2025-05-23', '08:24:00', '2025-05-23 08:24:00', NULL),
(238, '', 'Nurul Hidayah', 'Non-Anggota', 'Umum', 'Ruang Koleksi Referensi', '2025-11-03', '14:16:00', '2025-11-03 14:16:00', NULL),
(239, '62813', 'Rina Marlina', 'Anggota', 'Universitas Indonesia', 'Ruang Koleksi Referensi', '2025-09-09', '10:11:00', '2025-09-09 10:11:00', NULL),
(240, '', 'Dewi Lestari', 'Non-Anggota', 'UGM', 'Ruang Koleksi Referensi', '2025-05-08', '16:30:00', '2025-05-08 16:30:00', NULL),
(241, '', 'Budi Santoso', 'Non-Anggota', 'Umum', 'Layanan Anak', '2025-01-01', '12:52:00', '2025-01-01 12:52:00', NULL),
(242, '', 'Agus Setiawan', 'Non-Anggota', 'ITB', 'Ruang Koleksi Referensi', '2025-01-25', '16:19:00', '2025-01-25 16:19:00', NULL),
(243, '', 'Dewi Lestari', 'Non-Anggota', 'ITB', 'Ruang Koleksi Referensi', '2025-09-21', '16:35:00', '2025-09-21 16:35:00', NULL),
(244, '', 'Nurul Hidayah', 'Non-Anggota', 'UGM', 'Ruang Multimedia', '2025-05-04', '16:47:00', '2025-05-04 16:47:00', NULL),
(245, '', 'Agus Setiawan', 'Non-Anggota', 'Umum', 'Ruang Koleksi Referensi', '2025-03-24', '15:35:00', '2025-03-24 15:35:00', NULL),
(246, '', 'Maya Putri', 'Non-Anggota', 'Perpustakaan Daerah', 'Ruang Multimedia', '2025-04-13', '16:32:00', '2025-04-13 16:32:00', NULL),
(247, '73646', 'Agus Setiawan', 'Anggota', 'ITB', 'Ruang Multimedia', '2025-11-09', '10:49:00', '2025-11-09 10:49:00', NULL),
(248, '', 'Eko Prasetyo', 'Non-Anggota', 'Dinas Pendidikan', 'Ruang Baca Umum', '2025-09-25', '11:56:00', '2025-09-25 11:56:00', NULL),
(249, '', 'Nurul Hidayah', 'Non-Anggota', 'Dinas Pendidikan', 'Ruang Baca Umum', '2025-10-02', '12:47:00', '2025-10-02 12:47:00', NULL),
(250, '', 'Joko Susilo', 'Non-Anggota', 'SMA Negeri 1', 'Ruang Baca Umum', '2025-01-23', '14:01:00', '2025-01-23 14:01:00', NULL),
(251, '', 'Rudi Hartono', 'Non-Anggota', 'Perpustakaan Daerah', 'Ruang Baca Umum', '2025-07-09', '11:06:00', '2025-07-09 11:06:00', NULL),
(252, '', 'Siti Aminah', 'Non-Anggota', 'UGM', 'Layanan Sirkulasi', '2025-09-18', '15:26:00', '2025-09-18 15:26:00', NULL),
(253, '50293', 'Maya Putri', 'Anggota', 'Umum', 'Layanan Sirkulasi', '2025-02-03', '08:32:00', '2025-02-03 08:32:00', NULL),
(254, '', 'Maya Putri', 'Non-Anggota', 'ITB', 'Layanan Sirkulasi', '2025-09-12', '16:03:00', '2025-09-12 16:03:00', NULL),
(255, '', 'Maya Putri', 'Non-Anggota', 'SMA Negeri 1', 'Ruang Koleksi Referensi', '2025-01-14', '09:47:00', '2025-01-14 09:47:00', NULL),
(256, '', 'Joko Susilo', 'Non-Anggota', 'ITB', 'Layanan Sirkulasi', '2025-07-23', '12:57:00', '2025-07-23 12:57:00', NULL),
(257, '37127', 'Budi Santoso', 'Anggota', 'Umum', 'Layanan Sirkulasi', '2025-02-28', '08:09:00', '2025-02-28 08:09:00', NULL),
(258, '', 'Siti Aminah', 'Non-Anggota', 'SMA Negeri 1', 'Ruang Baca Umum', '2025-11-07', '15:14:00', '2025-11-07 15:14:00', NULL),
(259, '', 'Nurul Hidayah', 'Non-Anggota', 'Umum', 'Ruang Multimedia', '2025-03-22', '10:52:00', '2025-03-22 10:52:00', NULL),
(260, '16619', 'Rudi Hartono', 'Anggota', 'UGM', 'Ruang Koleksi Referensi', '2025-09-28', '10:03:00', '2025-09-28 10:03:00', NULL),
(261, '', 'Agus Setiawan', 'Non-Anggota', 'Umum', 'Layanan Anak', '2025-07-16', '13:00:00', '2025-07-16 13:00:00', NULL),
(262, '', 'Nurul Hidayah', 'Non-Anggota', 'ITB', 'Layanan Sirkulasi', '2025-04-21', '14:12:00', '2025-04-21 14:12:00', NULL),
(263, '10926', 'Maya Putri', 'Anggota', 'UGM', 'Layanan Anak', '2025-05-18', '14:05:00', '2025-05-18 14:05:00', NULL),
(264, '', 'Maya Putri', 'Non-Anggota', 'Dinas Pendidikan', 'Ruang Baca Umum', '2025-06-24', '14:59:00', '2025-06-24 14:59:00', NULL),
(265, '', 'Maya Putri', 'Non-Anggota', 'Perpustakaan Daerah', 'Ruang Koleksi Referensi', '2025-11-12', '14:40:00', '2025-11-12 14:40:00', NULL),
(266, '', 'Joko Susilo', 'Non-Anggota', 'Perpustakaan Daerah', 'Ruang Koleksi Referensi', '2025-05-04', '09:34:00', '2025-05-04 09:34:00', NULL),
(267, '89013', 'Maya Putri', 'Anggota', 'UGM', 'Layanan Anak', '2025-08-13', '09:49:00', '2025-08-13 09:49:00', NULL),
(268, '64360', 'Joko Susilo', 'Anggota', 'Perpustakaan Daerah', 'Layanan Anak', '2025-01-10', '13:59:00', '2025-01-10 13:59:00', NULL),
(269, '', 'Maya Putri', 'Non-Anggota', 'ITB', 'Ruang Koleksi Referensi', '2025-09-19', '13:42:00', '2025-09-19 13:42:00', NULL),
(270, '81228', 'Joko Susilo', 'Anggota', 'Perpustakaan Daerah', 'Ruang Koleksi Referensi', '2025-10-20', '08:20:00', '2025-10-20 08:20:00', NULL),
(271, '', 'Dewi Lestari', 'Non-Anggota', 'Perpustakaan Daerah', 'Ruang Koleksi Referensi', '2025-10-05', '14:41:00', '2025-10-05 14:41:00', NULL),
(272, '85779', 'Dewi Lestari', 'Anggota', 'Perpustakaan Daerah', 'Ruang Multimedia', '2025-11-13', '11:33:00', '2025-11-13 11:33:00', NULL),
(273, '', 'Siti Aminah', 'Non-Anggota', 'Umum', 'Layanan Sirkulasi', '2025-04-23', '15:05:00', '2025-04-23 15:05:00', NULL),
(274, '', 'Siti Aminah', 'Non-Anggota', 'UGM', 'Ruang Koleksi Referensi', '2025-03-01', '14:51:00', '2025-03-01 14:51:00', NULL),
(275, '94587', 'Maya Putri', 'Anggota', 'ITB', 'Ruang Multimedia', '2025-01-22', '13:46:00', '2025-01-22 13:46:00', NULL),
(276, '81805', 'Rudi Hartono', 'Anggota', 'Dinas Pendidikan', 'Layanan Sirkulasi', '2025-04-05', '16:19:00', '2025-04-05 16:19:00', NULL),
(277, '', 'Rina Marlina', 'Non-Anggota', 'UGM', 'Ruang Koleksi Referensi', '2025-03-19', '14:41:00', '2025-03-19 14:41:00', NULL),
(278, '', 'Agus Setiawan', 'Non-Anggota', 'Perpustakaan Daerah', 'Ruang Koleksi Referensi', '2025-08-17', '13:41:00', '2025-08-17 13:41:00', NULL),
(279, '', 'Nurul Hidayah', 'Non-Anggota', 'SMA Negeri 1', 'Layanan Anak', '2025-04-16', '16:51:00', '2025-04-16 16:51:00', NULL),
(280, '', 'Siti Aminah', 'Non-Anggota', 'UGM', 'Layanan Sirkulasi', '2025-03-21', '09:57:00', '2025-03-21 09:57:00', NULL),
(281, '88787', 'Dewi Lestari', 'Anggota', 'SMA Negeri 1', 'Ruang Koleksi Referensi', '2025-12-21', '11:31:00', '2025-12-21 11:31:00', NULL),
(282, '', 'Eko Prasetyo', 'Non-Anggota', 'UGM', 'Ruang Koleksi Referensi', '2025-06-07', '12:15:00', '2025-06-07 12:15:00', NULL),
(283, '', 'Agus Setiawan', 'Non-Anggota', 'SMA Negeri 1', 'Ruang Koleksi Referensi', '2025-04-12', '09:52:00', '2025-04-12 09:52:00', NULL),
(284, '14746', 'Maya Putri', 'Anggota', 'Perpustakaan Daerah', 'Layanan Anak', '2025-11-06', '15:56:00', '2025-11-06 15:56:00', NULL),
(285, '', 'Dewi Lestari', 'Non-Anggota', 'Umum', 'Ruang Baca Umum', '2025-10-17', '14:58:00', '2025-10-17 14:58:00', NULL),
(286, '', 'Rudi Hartono', 'Non-Anggota', 'Umum', 'Ruang Baca Umum', '2025-07-16', '10:31:00', '2025-07-16 10:31:00', NULL),
(287, '59668', 'Rudi Hartono', 'Anggota', 'Dinas Pendidikan', 'Ruang Koleksi Referensi', '2025-12-01', '16:45:00', '2025-12-01 16:45:00', NULL),
(288, '', 'Nurul Hidayah', 'Non-Anggota', 'ITB', 'Ruang Baca Umum', '2025-02-01', '15:43:00', '2025-02-01 15:43:00', NULL),
(289, '', 'Maya Putri', 'Non-Anggota', 'ITB', 'Layanan Sirkulasi', '2025-01-27', '14:04:00', '2025-01-27 14:04:00', NULL),
(290, '12590', 'Rudi Hartono', 'Anggota', 'Perpustakaan Daerah', 'Layanan Anak', '2025-02-18', '10:51:00', '2025-02-18 10:51:00', NULL),
(291, '', 'Siti Aminah', 'Non-Anggota', 'Universitas Indonesia', 'Ruang Koleksi Referensi', '2025-09-19', '13:08:00', '2025-09-19 13:08:00', NULL),
(292, '62764', 'Maya Putri', 'Anggota', 'SMA Negeri 1', 'Ruang Multimedia', '2025-08-13', '08:16:00', '2025-08-13 08:16:00', NULL),
(293, '', 'Eko Prasetyo', 'Non-Anggota', 'Universitas Indonesia', 'Ruang Koleksi Referensi', '2025-07-10', '15:19:00', '2025-07-10 15:19:00', NULL),
(294, '', 'Budi Santoso', 'Non-Anggota', 'Perpustakaan Daerah', 'Ruang Koleksi Referensi', '2025-11-02', '13:33:00', '2025-11-02 13:33:00', NULL),
(295, '', 'Eko Prasetyo', 'Non-Anggota', 'Universitas Indonesia', 'Layanan Anak', '2025-01-12', '09:53:00', '2025-01-12 09:53:00', NULL),
(296, '46442', 'Maya Putri', 'Anggota', 'UGM', 'Ruang Baca Umum', '2025-01-03', '14:36:00', '2025-01-03 14:36:00', NULL),
(297, '', 'Nurul Hidayah', 'Non-Anggota', 'Perpustakaan Daerah', 'Ruang Multimedia', '2025-03-26', '14:35:00', '2025-03-26 14:35:00', NULL),
(298, '74346', 'Agus Setiawan', 'Anggota', 'UGM', 'Ruang Koleksi Referensi', '2025-10-05', '10:01:00', '2025-10-05 10:01:00', NULL),
(299, '82256', 'Nurul Hidayah', 'Anggota', 'Umum', 'Layanan Anak', '2025-02-21', '13:22:00', '2025-02-21 13:22:00', NULL),
(300, '', 'Budi Santoso', 'Non-Anggota', 'ITB', 'Layanan Anak', '2025-08-15', '08:00:00', '2025-08-15 08:00:00', NULL),
(301, '67388', 'Joko Susilo', 'Anggota', 'SMA Negeri 1', 'Layanan Sirkulasi', '2025-05-27', '12:58:00', '2025-05-27 12:58:00', NULL),
(302, '28966', 'Rudi Hartono', 'Anggota', 'Umum', 'Layanan Anak', '2025-06-20', '14:14:00', '2025-06-20 14:14:00', NULL),
(303, '', 'Rudi Hartono', 'Non-Anggota', 'UGM', 'Layanan Anak', '2025-04-01', '15:01:00', '2025-04-01 15:01:00', NULL),
(304, '', 'Rina Marlina', 'Non-Anggota', 'Perpustakaan Daerah', 'Layanan Anak', '2025-06-02', '16:44:00', '2025-06-02 16:44:00', NULL),
(305, '92434', 'Rudi Hartono', 'Anggota', 'UGM', 'Ruang Multimedia', '2025-06-12', '14:54:00', '2025-06-12 14:54:00', NULL),
(306, '', 'Siti Aminah', 'Non-Anggota', 'Umum', 'Ruang Koleksi Referensi', '2025-01-12', '14:26:00', '2025-01-12 14:26:00', NULL),
(307, '89937', 'Nurul Hidayah', 'Anggota', 'Perpustakaan Daerah', 'Ruang Baca Umum', '2025-05-14', '13:46:00', '2025-05-14 13:46:00', NULL),
(308, '56963', 'Nurul Hidayah', 'Anggota', 'Universitas Indonesia', 'Ruang Baca Umum', '2025-02-17', '16:50:00', '2025-02-17 16:50:00', NULL),
(309, '81718', 'Agus Setiawan', 'Anggota', 'UGM', 'Ruang Baca Umum', '2025-10-23', '12:57:00', '2025-10-23 12:57:00', NULL),
(310, '57823', 'Agus Setiawan', 'Anggota', 'SMA Negeri 1', 'Ruang Koleksi Referensi', '2025-07-28', '16:29:00', '2025-07-28 16:29:00', NULL),
(311, '17287', 'Maya Putri', 'Anggota', 'Dinas Pendidikan', 'Ruang Multimedia', '2025-04-17', '09:26:00', '2025-04-17 09:26:00', NULL),
(312, '30594', 'Rina Marlina', 'Anggota', 'ITB', 'Layanan Sirkulasi', '2025-12-17', '15:04:00', '2025-12-17 15:04:00', NULL),
(313, '', 'Eko Prasetyo', 'Non-Anggota', 'Perpustakaan Daerah', 'Ruang Baca Umum', '2025-08-18', '16:48:00', '2025-08-18 16:48:00', NULL),
(314, '', 'Nurul Hidayah', 'Non-Anggota', 'Perpustakaan Daerah', 'Layanan Anak', '2025-04-04', '13:15:00', '2025-04-04 13:15:00', NULL),
(315, '99989', 'Rina Marlina', 'Anggota', 'Umum', 'Ruang Multimedia', '2025-02-08', '14:51:00', '2025-02-08 14:51:00', NULL),
(316, '', 'Eko Prasetyo', 'Non-Anggota', 'ITB', 'Layanan Anak', '2025-04-17', '14:48:00', '2025-04-17 14:48:00', NULL),
(317, '', 'Rina Marlina', 'Non-Anggota', 'UGM', 'Layanan Sirkulasi', '2025-08-28', '16:26:00', '2025-08-28 16:26:00', NULL),
(318, '', 'Agus Setiawan', 'Non-Anggota', 'Dinas Pendidikan', 'Layanan Anak', '2025-09-03', '15:12:00', '2025-09-03 15:12:00', NULL),
(319, '', 'Maya Putri', 'Non-Anggota', 'UGM', 'Ruang Multimedia', '2025-01-14', '12:40:00', '2025-01-14 12:40:00', NULL),
(320, '', 'Nurul Hidayah', 'Non-Anggota', 'Universitas Indonesia', 'Ruang Baca Umum', '2025-07-10', '10:00:00', '2025-07-10 10:00:00', NULL),
(321, '97517', 'Nurul Hidayah', 'Anggota', 'Umum', 'Ruang Baca Umum', '2025-10-22', '14:25:00', '2025-10-22 14:25:00', NULL),
(322, '67641', 'Eko Prasetyo', 'Anggota', 'Dinas Pendidikan', 'Ruang Baca Umum', '2025-12-07', '15:25:00', '2025-12-07 15:25:00', NULL),
(323, '', 'Nurul Hidayah', 'Non-Anggota', 'UGM', 'Layanan Anak', '2025-09-01', '14:17:00', '2025-09-01 14:17:00', NULL),
(324, '15522', 'Dewi Lestari', 'Anggota', 'Dinas Pendidikan', 'Layanan Anak', '2025-06-07', '12:02:00', '2025-06-07 12:02:00', NULL),
(325, '', 'Agus Setiawan', 'Non-Anggota', 'UGM', 'Ruang Baca Umum', '2025-07-03', '16:04:00', '2025-07-03 16:04:00', NULL),
(326, '13461', 'Joko Susilo', 'Anggota', 'Universitas Indonesia', 'Layanan Anak', '2025-12-10', '14:07:00', '2025-12-10 14:07:00', NULL),
(327, '', 'Rudi Hartono', 'Non-Anggota', 'SMA Negeri 1', 'Layanan Sirkulasi', '2025-08-28', '15:20:00', '2025-08-28 15:20:00', NULL),
(328, '', 'Rina Marlina', 'Non-Anggota', 'Universitas Indonesia', 'Ruang Baca Umum', '2025-03-22', '13:37:00', '2025-03-22 13:37:00', NULL),
(329, '68666', 'Eko Prasetyo', 'Anggota', 'ITB', 'Ruang Koleksi Referensi', '2025-11-20', '10:56:00', '2025-11-20 10:56:00', NULL),
(330, '35519', 'Maya Putri', 'Anggota', 'Perpustakaan Daerah', 'Layanan Sirkulasi', '2025-04-18', '15:57:00', '2025-04-18 15:57:00', NULL),
(331, '', 'Dewi Lestari', 'Non-Anggota', 'ITB', 'Layanan Anak', '2025-05-06', '15:53:00', '2025-05-06 15:53:00', NULL),
(332, '98010', 'Eko Prasetyo', 'Anggota', 'ITB', 'Ruang Multimedia', '2025-07-12', '09:06:00', '2025-07-12 09:06:00', NULL),
(333, '', 'Joko Susilo', 'Non-Anggota', 'Universitas Indonesia', 'Ruang Baca Umum', '2025-02-14', '16:50:00', '2025-02-14 16:50:00', NULL),
(334, '', 'Joko Susilo', 'Non-Anggota', 'Universitas Indonesia', 'Ruang Multimedia', '2025-09-06', '13:01:00', '2025-09-06 13:01:00', NULL),
(335, '', 'Agus Setiawan', 'Non-Anggota', 'Perpustakaan Daerah', 'Ruang Multimedia', '2025-09-20', '08:27:00', '2025-09-20 08:27:00', NULL),
(336, '81174', 'Rudi Hartono', 'Anggota', 'Dinas Pendidikan', 'Ruang Baca Umum', '2025-03-27', '08:54:00', '2025-03-27 08:54:00', NULL),
(337, '34917', 'Budi Santoso', 'Anggota', 'UGM', 'Ruang Koleksi Referensi', '2025-05-10', '10:27:00', '2025-05-10 10:27:00', NULL),
(338, '', 'Rudi Hartono', 'Non-Anggota', 'Perpustakaan Daerah', 'Ruang Koleksi Referensi', '2025-01-21', '11:16:00', '2025-01-21 11:16:00', NULL),
(339, '14877', 'Budi Santoso', 'Anggota', 'Umum', 'Ruang Multimedia', '2025-11-13', '10:19:00', '2025-11-13 10:19:00', NULL),
(340, '71906', 'Maya Putri', 'Anggota', 'Perpustakaan Daerah', 'Layanan Sirkulasi', '2025-12-06', '13:32:00', '2025-12-06 13:32:00', NULL),
(341, '10116', 'Eko Prasetyo', 'Anggota', 'Perpustakaan Daerah', 'Ruang Baca Umum', '2025-05-16', '10:40:00', '2025-05-16 10:40:00', NULL),
(342, '18693', 'Joko Susilo', 'Anggota', 'Perpustakaan Daerah', 'Layanan Sirkulasi', '2025-06-09', '10:41:00', '2025-06-09 10:41:00', NULL),
(343, '71014', 'Rina Marlina', 'Anggota', 'ITB', 'Layanan Anak', '2025-04-08', '14:26:00', '2025-04-08 14:26:00', NULL),
(344, '75894', 'Budi Santoso', 'Anggota', 'ITB', 'Layanan Anak', '2025-01-12', '12:04:00', '2025-01-12 12:04:00', NULL),
(345, '63612', 'Nurul Hidayah', 'Anggota', 'Umum', 'Layanan Sirkulasi', '2025-04-07', '08:52:00', '2025-04-07 08:52:00', NULL),
(346, '', 'Siti Aminah', 'Non-Anggota', 'UGM', 'Ruang Multimedia', '2025-08-09', '14:36:00', '2025-08-09 14:36:00', NULL),
(347, '60612', 'Rina Marlina', 'Anggota', 'Umum', 'Layanan Anak', '2025-12-26', '13:23:00', '2025-12-26 13:23:00', NULL),
(348, '', 'Budi Santoso', 'Non-Anggota', 'Umum', 'Ruang Baca Umum', '2025-12-08', '13:01:00', '2025-12-08 13:01:00', NULL),
(349, '', 'Budi Santoso', 'Non-Anggota', 'Universitas Indonesia', 'Ruang Koleksi Referensi', '2025-12-20', '12:22:00', '2025-12-20 12:22:00', NULL),
(350, '78389', 'Maya Putri', 'Anggota', 'ITB', 'Ruang Baca Umum', '2025-01-27', '09:12:00', '2025-01-27 09:12:00', NULL),
(351, '', 'Rudi Hartono', 'Non-Anggota', 'Perpustakaan Daerah', 'Ruang Koleksi Referensi', '2025-11-09', '11:54:00', '2025-11-09 11:54:00', NULL),
(352, '62092', 'Dewi Lestari', 'Anggota', 'UGM', 'Layanan Anak', '2025-03-04', '09:29:00', '2025-03-04 09:29:00', NULL),
(353, '33653', 'Maya Putri', 'Anggota', 'Dinas Pendidikan', 'Ruang Multimedia', '2025-10-28', '11:37:00', '2025-10-28 11:37:00', NULL),
(354, '', 'Nurul Hidayah', 'Non-Anggota', 'SMA Negeri 1', 'Ruang Koleksi Referensi', '2025-12-20', '09:33:00', '2025-12-20 09:33:00', NULL),
(355, '', 'Siti Aminah', 'Non-Anggota', 'Perpustakaan Daerah', 'Layanan Anak', '2025-04-15', '16:36:00', '2025-04-15 16:36:00', NULL),
(356, '', 'Agus Setiawan', 'Non-Anggota', 'ITB', 'Layanan Sirkulasi', '2025-01-28', '13:09:00', '2025-01-28 13:09:00', NULL),
(357, '', 'Dewi Lestari', 'Non-Anggota', 'UGM', 'Layanan Anak', '2025-12-17', '10:21:00', '2025-12-17 10:21:00', NULL),
(358, '24640', 'Maya Putri', 'Anggota', 'ITB', 'Ruang Koleksi Referensi', '2025-05-05', '10:30:00', '2025-05-05 10:30:00', NULL),
(359, '68057', 'Joko Susilo', 'Anggota', 'Umum', 'Ruang Koleksi Referensi', '2025-04-24', '13:14:00', '2025-04-24 13:14:00', NULL),
(360, '85601', 'Maya Putri', 'Anggota', 'Universitas Indonesia', 'Layanan Anak', '2025-10-01', '16:34:00', '2025-10-01 16:34:00', NULL),
(361, '', 'Siti Aminah', 'Non-Anggota', 'Dinas Pendidikan', 'Ruang Koleksi Referensi', '2025-01-06', '13:07:00', '2025-01-06 13:07:00', NULL),
(362, '22368', 'Maya Putri', 'Anggota', 'SMA Negeri 1', 'Layanan Anak', '2025-02-09', '14:49:00', '2025-02-09 14:49:00', NULL),
(363, '36153', 'Nurul Hidayah', 'Anggota', 'SMA Negeri 1', 'Ruang Koleksi Referensi', '2025-04-12', '15:35:00', '2025-04-12 15:35:00', NULL),
(364, '', 'Joko Susilo', 'Non-Anggota', 'Umum', 'Layanan Sirkulasi', '2025-07-02', '09:13:00', '2025-07-02 09:13:00', NULL),
(365, '', 'Siti Aminah', 'Non-Anggota', 'Dinas Pendidikan', 'Layanan Anak', '2025-07-07', '10:59:00', '2025-07-07 10:59:00', NULL),
(366, '65406', 'Rina Marlina', 'Anggota', 'Dinas Pendidikan', 'Layanan Sirkulasi', '2025-10-21', '13:34:00', '2025-10-21 13:34:00', NULL),
(367, '26034', 'Agus Setiawan', 'Anggota', 'SMA Negeri 1', 'Ruang Baca Umum', '2025-01-14', '08:24:00', '2025-01-14 08:24:00', NULL),
(368, '84826', 'Eko Prasetyo', 'Anggota', 'SMA Negeri 1', 'Ruang Multimedia', '2025-02-15', '15:37:00', '2025-02-15 15:37:00', NULL),
(369, '', 'Rina Marlina', 'Non-Anggota', 'Dinas Pendidikan', 'Ruang Multimedia', '2025-09-24', '11:35:00', '2025-09-24 11:35:00', NULL),
(370, '', 'Maya Putri', 'Non-Anggota', 'Perpustakaan Daerah', 'Layanan Sirkulasi', '2025-04-19', '12:01:00', '2025-04-19 12:01:00', NULL),
(371, '', 'Siti Aminah', 'Non-Anggota', 'SMA Negeri 1', 'Layanan Sirkulasi', '2025-03-26', '10:16:00', '2025-03-26 10:16:00', NULL),
(372, '48525', 'Siti Aminah', 'Anggota', 'ITB', 'Layanan Sirkulasi', '2025-10-26', '16:19:00', '2025-10-26 16:19:00', NULL),
(373, '', 'Nurul Hidayah', 'Non-Anggota', 'Universitas Indonesia', 'Ruang Koleksi Referensi', '2025-03-01', '08:27:00', '2025-03-01 08:27:00', NULL),
(374, '', 'Agus Setiawan', 'Non-Anggota', 'ITB', 'Ruang Koleksi Referensi', '2025-12-16', '16:44:00', '2025-12-16 16:44:00', NULL),
(375, '27805', 'Siti Aminah', 'Anggota', 'Dinas Pendidikan', 'Ruang Multimedia', '2025-05-11', '15:59:00', '2025-05-11 15:59:00', NULL),
(376, '', 'Rudi Hartono', 'Non-Anggota', 'ITB', 'Layanan Sirkulasi', '2025-04-24', '16:49:00', '2025-04-24 16:49:00', NULL),
(377, '96654', 'Budi Santoso', 'Anggota', 'UGM', 'Ruang Baca Umum', '2025-05-24', '11:16:00', '2025-05-24 11:16:00', NULL),
(378, '', 'Nurul Hidayah', 'Non-Anggota', 'Perpustakaan Daerah', 'Ruang Koleksi Referensi', '2025-10-25', '14:52:00', '2025-10-25 14:52:00', NULL),
(379, '', 'Dewi Lestari', 'Non-Anggota', 'SMA Negeri 1', 'Layanan Anak', '2025-05-09', '11:43:00', '2025-05-09 11:43:00', NULL),
(380, '29035', 'Rudi Hartono', 'Anggota', 'Universitas Indonesia', 'Ruang Baca Umum', '2025-10-01', '12:20:00', '2025-10-01 12:20:00', NULL);
INSERT INTO `visits` (`id`, `member_id`, `visitor_name`, `membership_type`, `institution`, `room_name`, `visit_date`, `visit_time`, `created_at`, `updated_at`) VALUES
(381, '', 'Siti Aminah', 'Non-Anggota', 'Perpustakaan Daerah', 'Layanan Anak', '2025-04-09', '14:01:00', '2025-04-09 14:01:00', NULL),
(382, '', 'Rina Marlina', 'Non-Anggota', 'UGM', 'Layanan Sirkulasi', '2025-09-22', '16:53:00', '2025-09-22 16:53:00', NULL),
(383, '', 'Rina Marlina', 'Non-Anggota', 'SMA Negeri 1', 'Ruang Baca Umum', '2025-04-28', '15:53:00', '2025-04-28 15:53:00', NULL),
(384, '16231', 'Agus Setiawan', 'Anggota', 'Umum', 'Layanan Anak', '2025-03-15', '10:42:00', '2025-03-15 10:42:00', NULL),
(385, '98730', 'Siti Aminah', 'Anggota', 'SMA Negeri 1', 'Layanan Anak', '2025-05-26', '11:48:00', '2025-05-26 11:48:00', NULL),
(386, '', 'Budi Santoso', 'Non-Anggota', 'Perpustakaan Daerah', 'Layanan Anak', '2025-04-17', '12:23:00', '2025-04-17 12:23:00', NULL),
(387, '', 'Rina Marlina', 'Non-Anggota', 'Universitas Indonesia', 'Layanan Anak', '2025-06-26', '16:44:00', '2025-06-26 16:44:00', NULL),
(388, '', 'Siti Aminah', 'Non-Anggota', 'Universitas Indonesia', 'Layanan Sirkulasi', '2025-03-19', '10:47:00', '2025-03-19 10:47:00', NULL),
(389, '', 'Nurul Hidayah', 'Non-Anggota', 'Universitas Indonesia', 'Ruang Koleksi Referensi', '2025-12-14', '16:11:00', '2025-12-14 16:11:00', NULL),
(390, '', 'Dewi Lestari', 'Non-Anggota', 'UGM', 'Ruang Koleksi Referensi', '2025-01-06', '08:50:00', '2025-01-06 08:50:00', NULL),
(391, '', 'Dewi Lestari', 'Non-Anggota', 'Perpustakaan Daerah', 'Ruang Multimedia', '2025-05-14', '13:13:00', '2025-05-14 13:13:00', NULL),
(392, '', 'Siti Aminah', 'Non-Anggota', 'UGM', 'Ruang Koleksi Referensi', '2025-01-09', '13:59:00', '2025-01-09 13:59:00', NULL),
(393, '', 'Siti Aminah', 'Non-Anggota', 'SMA Negeri 1', 'Ruang Koleksi Referensi', '2025-04-13', '15:17:00', '2025-04-13 15:17:00', NULL),
(394, '', 'Maya Putri', 'Non-Anggota', 'UGM', 'Layanan Anak', '2025-11-26', '10:34:00', '2025-11-26 10:34:00', NULL),
(395, '', 'Eko Prasetyo', 'Non-Anggota', 'ITB', 'Layanan Sirkulasi', '2025-06-12', '14:52:00', '2025-06-12 14:52:00', NULL),
(396, '', 'Maya Putri', 'Non-Anggota', 'Dinas Pendidikan', 'Layanan Sirkulasi', '2025-09-05', '15:14:00', '2025-09-05 15:14:00', NULL),
(397, '', 'Joko Susilo', 'Non-Anggota', 'UGM', 'Layanan Anak', '2025-02-25', '14:53:00', '2025-02-25 14:53:00', NULL),
(398, '86469', 'Joko Susilo', 'Anggota', 'Umum', 'Ruang Koleksi Referensi', '2025-07-28', '10:05:00', '2025-07-28 10:05:00', NULL),
(399, '', 'Joko Susilo', 'Non-Anggota', 'ITB', 'Layanan Sirkulasi', '2025-05-22', '15:58:00', '2025-05-22 15:58:00', NULL),
(400, '', 'Rina Marlina', 'Non-Anggota', 'SMA Negeri 1', 'Ruang Multimedia', '2025-08-03', '14:25:00', '2025-08-03 14:25:00', NULL),
(401, '', 'Agus Setiawan', 'Non-Anggota', 'Umum', 'Layanan Sirkulasi', '2025-04-19', '15:04:00', '2025-04-19 15:04:00', NULL),
(402, '', 'Eko Prasetyo', 'Non-Anggota', 'Umum', 'Ruang Multimedia', '2025-09-20', '11:27:00', '2025-09-20 11:27:00', NULL),
(403, '24207', 'Budi Santoso', 'Anggota', 'ITB', 'Layanan Anak', '2025-08-22', '11:28:00', '2025-08-22 11:28:00', NULL),
(404, '', 'Rina Marlina', 'Non-Anggota', 'Umum', 'Ruang Baca Umum', '2025-11-04', '08:39:00', '2025-11-04 08:39:00', NULL),
(405, '52513', 'Rina Marlina', 'Anggota', 'ITB', 'Layanan Sirkulasi', '2025-09-12', '08:44:00', '2025-09-12 08:44:00', NULL),
(406, '99646', 'Nurul Hidayah', 'Anggota', 'ITB', 'Ruang Multimedia', '2025-05-25', '14:21:00', '2025-05-25 14:21:00', NULL),
(407, '36189', 'Rina Marlina', 'Anggota', 'Dinas Pendidikan', 'Ruang Koleksi Referensi', '2025-10-04', '09:05:00', '2025-10-04 09:05:00', NULL),
(408, '', 'Eko Prasetyo', 'Non-Anggota', 'ITB', 'Ruang Multimedia', '2025-11-03', '09:04:00', '2025-11-03 09:04:00', NULL),
(409, '', 'Joko Susilo', 'Non-Anggota', 'Perpustakaan Daerah', 'Ruang Koleksi Referensi', '2025-10-03', '08:36:00', '2025-10-03 08:36:00', NULL),
(410, '43924', 'Nurul Hidayah', 'Anggota', 'Umum', 'Ruang Baca Umum', '2025-09-03', '16:41:00', '2025-09-03 16:41:00', NULL),
(411, '', 'Rudi Hartono', 'Non-Anggota', 'Perpustakaan Daerah', 'Layanan Sirkulasi', '2025-05-09', '16:45:00', '2025-05-09 16:45:00', NULL),
(412, '', 'Maya Putri', 'Non-Anggota', 'Umum', 'Layanan Sirkulasi', '2025-01-27', '09:14:00', '2025-01-27 09:14:00', NULL),
(413, '', 'Joko Susilo', 'Non-Anggota', 'UGM', 'Layanan Sirkulasi', '2025-05-09', '12:09:00', '2025-05-09 12:09:00', NULL),
(414, '', 'Rina Marlina', 'Non-Anggota', 'Umum', 'Ruang Koleksi Referensi', '2025-05-03', '11:20:00', '2025-05-03 11:20:00', NULL),
(415, '', 'Agus Setiawan', 'Non-Anggota', 'Perpustakaan Daerah', 'Layanan Sirkulasi', '2025-11-28', '12:31:00', '2025-11-28 12:31:00', NULL),
(416, '61672', 'Maya Putri', 'Anggota', 'ITB', 'Ruang Koleksi Referensi', '2025-04-27', '10:02:00', '2025-04-27 10:02:00', NULL),
(417, '', 'Nurul Hidayah', 'Non-Anggota', 'Umum', 'Layanan Sirkulasi', '2025-12-11', '08:34:00', '2025-12-11 08:34:00', NULL),
(418, '', 'Eko Prasetyo', 'Non-Anggota', 'Perpustakaan Daerah', 'Layanan Anak', '2025-03-27', '16:15:00', '2025-03-27 16:15:00', NULL),
(419, '39066', 'Rudi Hartono', 'Anggota', 'UGM', 'Layanan Anak', '2025-11-25', '16:37:00', '2025-11-25 16:37:00', NULL),
(420, '73123', 'Eko Prasetyo', 'Anggota', 'ITB', 'Layanan Sirkulasi', '2025-07-25', '16:59:00', '2025-07-25 16:59:00', NULL),
(421, '87182', 'Joko Susilo', 'Anggota', 'Umum', 'Layanan Sirkulasi', '2025-09-22', '15:15:00', '2025-09-22 15:15:00', NULL),
(422, '', 'Dewi Lestari', 'Non-Anggota', 'SMA Negeri 1', 'Layanan Sirkulasi', '2025-03-26', '09:25:00', '2025-03-26 09:25:00', NULL),
(423, '', 'Siti Aminah', 'Non-Anggota', 'ITB', 'Layanan Anak', '2025-10-26', '16:47:00', '2025-10-26 16:47:00', NULL),
(424, '', 'Rudi Hartono', 'Non-Anggota', 'Perpustakaan Daerah', 'Ruang Multimedia', '2025-12-14', '08:31:00', '2025-12-14 08:31:00', NULL),
(425, '90344', 'Joko Susilo', 'Anggota', 'Dinas Pendidikan', 'Ruang Koleksi Referensi', '2025-02-25', '10:49:00', '2025-02-25 10:49:00', NULL),
(426, '', 'Agus Setiawan', 'Non-Anggota', 'ITB', 'Ruang Baca Umum', '2025-03-10', '09:57:00', '2025-03-10 09:57:00', NULL),
(427, '82964', 'Agus Setiawan', 'Anggota', 'Perpustakaan Daerah', 'Layanan Sirkulasi', '2025-02-03', '13:31:00', '2025-02-03 13:31:00', NULL),
(428, '', 'Rina Marlina', 'Non-Anggota', 'Perpustakaan Daerah', 'Layanan Sirkulasi', '2025-08-16', '13:49:00', '2025-08-16 13:49:00', NULL),
(429, '69555', 'Joko Susilo', 'Anggota', 'Dinas Pendidikan', 'Ruang Baca Umum', '2025-08-21', '09:55:00', '2025-08-21 09:55:00', NULL),
(430, '', 'Maya Putri', 'Non-Anggota', 'UGM', 'Ruang Baca Umum', '2025-11-12', '08:11:00', '2025-11-12 08:11:00', NULL),
(431, '17332', 'Eko Prasetyo', 'Anggota', 'Perpustakaan Daerah', 'Ruang Baca Umum', '2025-12-13', '11:58:00', '2025-12-13 11:58:00', NULL),
(432, '', 'Dewi Lestari', 'Non-Anggota', 'UGM', 'Layanan Sirkulasi', '2025-12-06', '16:50:00', '2025-12-06 16:50:00', NULL),
(433, '', 'Rudi Hartono', 'Non-Anggota', 'Universitas Indonesia', 'Layanan Sirkulasi', '2025-12-14', '08:19:00', '2025-12-14 08:19:00', NULL),
(434, '', 'Agus Setiawan', 'Non-Anggota', 'UGM', 'Ruang Baca Umum', '2025-09-20', '13:32:00', '2025-09-20 13:32:00', NULL),
(435, '', 'Joko Susilo', 'Non-Anggota', 'Perpustakaan Daerah', 'Ruang Multimedia', '2025-09-23', '12:02:00', '2025-09-23 12:02:00', NULL),
(436, '', 'Dewi Lestari', 'Non-Anggota', 'Dinas Pendidikan', 'Ruang Multimedia', '2025-03-16', '11:00:00', '2025-03-16 11:00:00', NULL),
(437, '', 'Rudi Hartono', 'Non-Anggota', 'Umum', 'Ruang Baca Umum', '2025-09-02', '10:12:00', '2025-09-02 10:12:00', NULL),
(438, '', 'Rina Marlina', 'Non-Anggota', 'ITB', 'Ruang Koleksi Referensi', '2025-02-10', '14:45:00', '2025-02-10 14:45:00', NULL),
(439, '24066', 'Dewi Lestari', 'Anggota', 'UGM', 'Ruang Multimedia', '2025-01-19', '13:30:00', '2025-01-19 13:30:00', NULL),
(440, '', 'Maya Putri', 'Non-Anggota', 'SMA Negeri 1', 'Layanan Anak', '2025-11-18', '09:03:00', '2025-11-18 09:03:00', NULL),
(441, '99482', 'Siti Aminah', 'Anggota', 'SMA Negeri 1', 'Ruang Koleksi Referensi', '2025-04-24', '14:51:00', '2025-04-24 14:51:00', NULL),
(442, '', 'Eko Prasetyo', 'Non-Anggota', 'ITB', 'Ruang Koleksi Referensi', '2025-11-09', '08:00:00', '2025-11-09 08:00:00', NULL),
(443, '14756', 'Agus Setiawan', 'Anggota', 'ITB', 'Ruang Koleksi Referensi', '2025-05-01', '08:42:00', '2025-05-01 08:42:00', NULL),
(444, '', 'Nurul Hidayah', 'Non-Anggota', 'Perpustakaan Daerah', 'Ruang Baca Umum', '2025-07-10', '13:40:00', '2025-07-10 13:40:00', NULL),
(445, '', 'Maya Putri', 'Non-Anggota', 'Perpustakaan Daerah', 'Ruang Multimedia', '2025-10-07', '08:36:00', '2025-10-07 08:36:00', NULL),
(446, '', 'Maya Putri', 'Non-Anggota', 'SMA Negeri 1', 'Ruang Baca Umum', '2025-03-23', '12:46:00', '2025-03-23 12:46:00', NULL),
(447, '', 'Joko Susilo', 'Non-Anggota', 'ITB', 'Layanan Sirkulasi', '2025-08-27', '13:25:00', '2025-08-27 13:25:00', NULL),
(448, '39114', 'Rudi Hartono', 'Anggota', 'Dinas Pendidikan', 'Layanan Sirkulasi', '2025-11-10', '16:58:00', '2025-11-10 16:58:00', NULL),
(449, '', 'Rudi Hartono', 'Non-Anggota', 'Universitas Indonesia', 'Ruang Multimedia', '2025-03-10', '11:30:00', '2025-03-10 11:30:00', NULL),
(450, '81038', 'Dewi Lestari', 'Anggota', 'Universitas Indonesia', 'Ruang Multimedia', '2025-07-28', '13:53:00', '2025-07-28 13:53:00', NULL),
(451, '', 'Agus Setiawan', 'Non-Anggota', 'SMA Negeri 1', 'Layanan Anak', '2025-06-10', '09:27:00', '2025-06-10 09:27:00', NULL),
(452, '', 'Rina Marlina', 'Non-Anggota', 'UGM', 'Ruang Baca Umum', '2025-02-16', '13:39:00', '2025-02-16 13:39:00', NULL),
(453, '', 'Maya Putri', 'Non-Anggota', 'UGM', 'Ruang Baca Umum', '2025-03-20', '15:59:00', '2025-03-20 15:59:00', NULL),
(454, '', 'Budi Santoso', 'Non-Anggota', 'Perpustakaan Daerah', 'Layanan Anak', '2025-11-25', '15:10:00', '2025-11-25 15:10:00', NULL),
(455, '', 'Agus Setiawan', 'Non-Anggota', 'SMA Negeri 1', 'Layanan Sirkulasi', '2025-08-03', '16:40:00', '2025-08-03 16:40:00', NULL),
(456, '94663', 'Joko Susilo', 'Anggota', 'UGM', 'Ruang Baca Umum', '2025-02-24', '16:41:00', '2025-02-24 16:41:00', NULL),
(457, '', 'Maya Putri', 'Non-Anggota', 'SMA Negeri 1', 'Ruang Multimedia', '2025-01-06', '12:42:00', '2025-01-06 12:42:00', NULL),
(458, '', 'Agus Setiawan', 'Non-Anggota', 'Umum', 'Layanan Anak', '2025-12-13', '16:30:00', '2025-12-13 16:30:00', NULL),
(459, '63365', 'Rina Marlina', 'Anggota', 'ITB', 'Ruang Koleksi Referensi', '2025-11-27', '13:10:00', '2025-11-27 13:10:00', NULL),
(460, '', 'Rudi Hartono', 'Non-Anggota', 'Dinas Pendidikan', 'Ruang Koleksi Referensi', '2025-02-16', '09:16:00', '2025-02-16 09:16:00', NULL),
(461, '95084', 'Budi Santoso', 'Anggota', 'Dinas Pendidikan', 'Layanan Anak', '2025-07-23', '12:39:00', '2025-07-23 12:39:00', NULL),
(462, '97105', 'Agus Setiawan', 'Anggota', 'Umum', 'Layanan Sirkulasi', '2025-08-18', '13:56:00', '2025-08-18 13:56:00', NULL),
(463, '', 'Budi Santoso', 'Non-Anggota', 'UGM', 'Layanan Anak', '2025-09-06', '14:12:00', '2025-09-06 14:12:00', NULL),
(464, '', 'Budi Santoso', 'Non-Anggota', 'ITB', 'Ruang Koleksi Referensi', '2025-01-28', '15:34:00', '2025-01-28 15:34:00', NULL),
(465, '', 'Maya Putri', 'Non-Anggota', 'UGM', 'Ruang Koleksi Referensi', '2025-04-08', '13:06:00', '2025-04-08 13:06:00', NULL),
(466, '19521', 'Rina Marlina', 'Anggota', 'UGM', 'Ruang Koleksi Referensi', '2025-03-10', '16:20:00', '2025-03-10 16:20:00', NULL),
(467, '59038', 'Budi Santoso', 'Anggota', 'Dinas Pendidikan', 'Ruang Koleksi Referensi', '2025-08-13', '12:54:00', '2025-08-13 12:54:00', NULL),
(468, '', 'Rudi Hartono', 'Non-Anggota', 'Umum', 'Ruang Multimedia', '2025-11-27', '15:51:00', '2025-11-27 15:51:00', NULL),
(469, '', 'Siti Aminah', 'Non-Anggota', 'UGM', 'Layanan Sirkulasi', '2025-01-26', '14:59:00', '2025-01-26 14:59:00', NULL),
(470, '', 'Siti Aminah', 'Non-Anggota', 'SMA Negeri 1', 'Ruang Baca Umum', '2025-09-04', '09:34:00', '2025-09-04 09:34:00', NULL),
(471, '60394', 'Siti Aminah', 'Anggota', 'Perpustakaan Daerah', 'Ruang Baca Umum', '2025-11-13', '13:34:00', '2025-11-13 13:34:00', NULL),
(472, '34873', 'Eko Prasetyo', 'Anggota', 'Umum', 'Ruang Multimedia', '2025-05-22', '14:56:00', '2025-05-22 14:56:00', NULL),
(473, '32345', 'Joko Susilo', 'Anggota', 'ITB', 'Ruang Multimedia', '2025-10-12', '12:47:00', '2025-10-12 12:47:00', NULL),
(474, '', 'Agus Setiawan', 'Non-Anggota', 'Universitas Indonesia', 'Ruang Koleksi Referensi', '2025-12-10', '08:21:00', '2025-12-10 08:21:00', NULL),
(475, '', 'Rudi Hartono', 'Non-Anggota', 'Universitas Indonesia', 'Ruang Multimedia', '2025-04-28', '15:39:00', '2025-04-28 15:39:00', NULL),
(476, '', 'Agus Setiawan', 'Non-Anggota', 'ITB', 'Ruang Multimedia', '2025-02-04', '12:11:00', '2025-02-04 12:11:00', NULL),
(477, '', 'Budi Santoso', 'Non-Anggota', 'Umum', 'Layanan Sirkulasi', '2025-03-04', '15:51:00', '2025-03-04 15:51:00', NULL),
(478, '', 'Rina Marlina', 'Non-Anggota', 'Dinas Pendidikan', 'Layanan Sirkulasi', '2025-04-04', '08:42:00', '2025-04-04 08:42:00', NULL),
(479, '', 'Rina Marlina', 'Non-Anggota', 'UGM', 'Layanan Sirkulasi', '2025-10-04', '08:06:00', '2025-10-04 08:06:00', NULL),
(480, '', 'Budi Santoso', 'Non-Anggota', 'UGM', 'Ruang Koleksi Referensi', '2025-02-15', '10:19:00', '2025-02-15 10:19:00', NULL),
(481, '', 'Rudi Hartono', 'Non-Anggota', 'UGM', 'Layanan Anak', '2025-03-22', '14:20:00', '2025-03-22 14:20:00', NULL),
(482, '', 'Dewi Lestari', 'Non-Anggota', 'Dinas Pendidikan', 'Layanan Sirkulasi', '2025-09-06', '09:06:00', '2025-09-06 09:06:00', NULL),
(483, '21868', 'Eko Prasetyo', 'Anggota', 'Universitas Indonesia', 'Ruang Baca Umum', '2025-07-03', '12:13:00', '2025-07-03 12:13:00', NULL),
(484, '', 'Rina Marlina', 'Non-Anggota', 'Umum', 'Ruang Multimedia', '2025-10-25', '13:05:00', '2025-10-25 13:05:00', NULL),
(485, '', 'Budi Santoso', 'Non-Anggota', 'UGM', 'Ruang Koleksi Referensi', '2025-05-23', '08:55:00', '2025-05-23 08:55:00', NULL),
(486, '', 'Maya Putri', 'Non-Anggota', 'ITB', 'Layanan Sirkulasi', '2025-08-06', '13:15:00', '2025-08-06 13:15:00', NULL),
(487, '14939', 'Maya Putri', 'Anggota', 'Universitas Indonesia', 'Layanan Anak', '2025-07-20', '11:53:00', '2025-07-20 11:53:00', NULL),
(488, '', 'Agus Setiawan', 'Non-Anggota', 'UGM', 'Layanan Sirkulasi', '2025-06-11', '12:56:00', '2025-06-11 12:56:00', NULL),
(489, '60890', 'Siti Aminah', 'Anggota', 'Universitas Indonesia', 'Ruang Baca Umum', '2025-05-20', '16:01:00', '2025-05-20 16:01:00', NULL),
(490, '63979', 'Maya Putri', 'Anggota', 'ITB', 'Ruang Baca Umum', '2025-03-08', '10:06:00', '2025-03-08 10:06:00', NULL),
(491, '36362', 'Joko Susilo', 'Anggota', 'Dinas Pendidikan', 'Ruang Koleksi Referensi', '2025-03-01', '14:50:00', '2025-03-01 14:50:00', NULL),
(492, '96734', 'Maya Putri', 'Anggota', 'ITB', 'Layanan Anak', '2025-08-05', '12:48:00', '2025-08-05 12:48:00', NULL),
(493, '', 'Agus Setiawan', 'Non-Anggota', 'ITB', 'Ruang Koleksi Referensi', '2025-04-17', '11:37:00', '2025-04-17 11:37:00', NULL),
(494, '40294', 'Agus Setiawan', 'Anggota', 'SMA Negeri 1', 'Layanan Anak', '2025-12-12', '12:14:00', '2025-12-12 12:14:00', NULL),
(495, '', 'Siti Aminah', 'Non-Anggota', 'Perpustakaan Daerah', 'Ruang Koleksi Referensi', '2025-11-27', '12:59:00', '2025-11-27 12:59:00', NULL),
(496, '66055', 'Agus Setiawan', 'Anggota', 'Universitas Indonesia', 'Ruang Multimedia', '2025-08-28', '12:06:00', '2025-08-28 12:06:00', NULL),
(497, '73432', 'Joko Susilo', 'Anggota', 'ITB', 'Layanan Anak', '2025-11-09', '15:06:00', '2025-11-09 15:06:00', NULL),
(498, '16368', 'Dewi Lestari', 'Anggota', 'Universitas Indonesia', 'Ruang Baca Umum', '2025-09-25', '12:44:00', '2025-09-25 12:44:00', NULL),
(499, '', 'Rina Marlina', 'Non-Anggota', 'Universitas Indonesia', 'Layanan Sirkulasi', '2025-03-18', '09:41:00', '2025-03-18 09:41:00', NULL),
(500, '', 'Eko Prasetyo', 'Non-Anggota', 'Dinas Pendidikan', 'Ruang Koleksi Referensi', '2025-12-19', '14:20:00', '2025-12-19 14:20:00', NULL),
(501, '', 'Joko Susilo', 'Non-Anggota', 'Universitas Indonesia', 'Ruang Multimedia', '2025-04-08', '13:21:00', '2025-04-08 13:21:00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `monthly_visits`
--
ALTER TABLE `monthly_visits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_year_month` (`year`,`month`);

--
-- Indeks untuk tabel `tbl_anggota`
--
ALTER TABLE `tbl_anggota`
  ADD PRIMARY KEY (`id_anggota`),
  ADD UNIQUE KEY `kode_anggota` (`kode_anggota`);

--
-- Indeks untuk tabel `tbl_hak_akses`
--
ALTER TABLE `tbl_hak_akses`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_menu`
--
ALTER TABLE `tbl_menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indeks untuk tabel `tbl_profil_apps`
--
ALTER TABLE `tbl_profil_apps`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_ruangan`
--
ALTER TABLE `tbl_ruangan`
  ADD PRIMARY KEY (`id_ruangan`);

--
-- Indeks untuk tabel `tbl_setting`
--
ALTER TABLE `tbl_setting`
  ADD PRIMARY KEY (`id_setting`);

--
-- Indeks untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_users`);

--
-- Indeks untuk tabel `tbl_user_level`
--
ALTER TABLE `tbl_user_level`
  ADD PRIMARY KEY (`id_user_level`);

--
-- Indeks untuk tabel `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_visit_date` (`visit_date`),
  ADD KEY `idx_member_id` (`member_id`),
  ADD KEY `idx_room_name` (`room_name`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `monthly_visits`
--
ALTER TABLE `monthly_visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `tbl_anggota`
--
ALTER TABLE `tbl_anggota`
  MODIFY `id_anggota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbl_hak_akses`
--
ALTER TABLE `tbl_hak_akses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT untuk tabel `tbl_menu`
--
ALTER TABLE `tbl_menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT untuk tabel `tbl_ruangan`
--
ALTER TABLE `tbl_ruangan`
  MODIFY `id_ruangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tbl_setting`
--
ALTER TABLE `tbl_setting`
  MODIFY `id_setting` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `tbl_user_level`
--
ALTER TABLE `tbl_user_level`
  MODIFY `id_user_level` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `visits`
--
ALTER TABLE `visits`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=502;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
