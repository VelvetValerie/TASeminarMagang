-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 30, 2026 at 01:05 AM
-- Server version: 8.0.40
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dummy_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `instansi`
--

CREATE TABLE `instansi` (
  `id_instansi` int UNSIGNED NOT NULL,
  `nm_instansi` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `instansi`
--

INSERT INTO `instansi` (`id_instansi`, `nm_instansi`, `created_at`) VALUES
(1, 'BKN Kantor Regional VIII Banjarmasin', '2026-09-01 00:17:35'),
(2, 'Pemerintah Provinsi Kalimantan Selatan', '2026-09-01 00:17:35'),
(3, 'Pemerintah Kota Banjarmasin', '2026-09-01 00:17:35'),
(4, 'Kementerian Hukum dan HAM Kalsel', '2026-09-01 00:17:35'),
(5, 'Institut Pemerintahan Dalam Negeri (IPDN)', '2026-09-03 01:14:01'),
(6, 'Pemerintah Kabupaten Banjar', '2026-09-08 00:17:35'),
(7, 'Pemerintah Kabupaten Tanah Laut', '2026-09-08 00:17:35'),
(8, 'Pemerintah Kabupaten Barito Kuala', '2026-09-08 00:17:35'),
(9, 'Pemerintah Kabupaten Tapin', '2026-09-08 00:17:35'),
(10, 'Pemerintah Kabupaten Hulu Sungai Selatan', '2026-09-08 00:17:35'),
(11, 'Pemerintah Kabupaten Hulu Sungai Tengah', '2026-09-08 00:17:35'),
(12, 'Pemerintah Kabupaten Hulu Sungai Utara', '2026-09-08 00:17:35'),
(13, 'Pemerintah Kabupaten Tabalong', '2026-09-08 00:17:35'),
(14, 'Pemerintah Kabupaten Tanah Bumbu', '2026-09-08 00:17:35'),
(15, 'Pemerintah Kabupaten Kotabaru', '2026-09-08 00:17:35'),
(16, 'Pemerintah Kota Banjarbaru', '2026-09-08 00:17:35'),
(17, 'Pemerintah Provinsi Kalimantan Tengah', '2026-09-08 00:17:35'),
(18, 'Pemerintah Kota Palangkaraya', '2026-09-08 00:17:35'),
(19, 'Pemerintah Kabupaten Kapuas', '2026-09-08 00:17:35'),
(20, 'Pemerintah Kabupaten Barito Selatan', '2026-09-08 00:17:35'),
(21, 'Pemerintah Kabupaten Barito Utara', '2026-09-08 00:17:35'),
(22, 'Pemerintah Kabupaten Barito Timur', '2026-09-08 00:17:35'),
(23, 'Pemerintah Kabupaten Kotawaringin Timur', '2026-09-08 00:17:35'),
(24, 'Pemerintah Kabupaten Kotawaringin Barat', '2026-09-08 00:17:35'),
(25, 'Pemerintah Kabupaten Katingan', '2026-09-08 00:17:35'),
(26, 'Pemerintah Kabupaten Seruyan', '2026-09-08 00:17:35'),
(27, 'Pemerintah Kabupaten Sukamara', '2026-09-08 00:17:35'),
(28, 'Pemerintah Kabupaten Lamandau', '2026-09-08 00:17:35'),
(29, 'Pemerintah Kabupaten Gunung Mas', '2026-09-08 00:17:35'),
(30, 'Pemerintah Kabupaten Murung Raya', '2026-09-08 00:17:35'),
(31, 'Pemerintah Kabupaten Pulang Pisau', '2026-09-08 00:17:35'),
(32, 'Pemerintah Provinsi Kalimantan Timur', '2026-09-08 00:17:35'),
(33, 'Pemerintah Kota Samarinda', '2026-09-08 00:17:35'),
(34, 'Pemerintah Kota Balikpapan', '2026-09-08 00:17:35'),
(35, 'Pemerintah Kabupaten Kutai Kartanegara', '2026-09-08 00:17:35'),
(36, 'Pemerintah Kabupaten Paser', '2026-09-08 00:17:35'),
(37, 'Pemerintah Kabupaten Kutai Timur', '2026-09-08 00:17:35'),
(38, 'Pemerintah Kabupaten Kutai Barat', '2026-09-08 00:17:35'),
(39, 'Pemerintah Kabupaten Berau', '2026-09-08 00:17:35'),
(40, 'Pemerintah Kabupaten Penajam Paser Utara', '2026-09-08 00:17:35'),
(41, 'Pemerintah Kabupaten Mahakam Ulu', '2026-09-08 00:17:35'),
(42, 'Pemerintah Provinsi Kalimantan Utara', '2026-09-08 00:17:35'),
(43, 'Pemerintah Kota Tarakan', '2026-09-08 00:17:35'),
(44, 'Pemerintah Kabupaten Bulungan', '2026-09-08 00:17:35'),
(45, 'Pemerintah Kabupaten Nunukan', '2026-09-08 00:17:35'),
(46, 'Kementerian Pendayagunaan Aparatur Negara dan RB', '2026-09-08 00:17:35');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_keg`
--

CREATE TABLE `jenis_keg` (
  `id_jeniskeg` int UNSIGNED NOT NULL,
  `nama_jeniskeg` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jenis_keg`
--

INSERT INTO `jenis_keg` (`id_jeniskeg`, `nama_jeniskeg`, `created_at`) VALUES
(1, 'Pengembangan Karir', '2026-09-01 00:17:35'),
(2, 'Tes CAT', '2026-09-01 00:17:35'),
(3, 'Tes CASN', '2026-09-01 00:17:35'),
(4, 'Tes Non-ASN', '2026-09-01 00:17:35');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int UNSIGNED NOT NULL,
  `nama_karyawan` varchar(100) NOT NULL,
  `catatan_kj` text,
  `perjalanan` varchar(100) DEFAULT NULL,
  `lama_jalan` varchar(50) DEFAULT NULL,
  `tempat_jalan` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `nama_karyawan`, `catatan_kj`, `perjalanan`, `lama_jalan`, `tempat_jalan`, `created_at`, `updated_at`) VALUES
(1, 'Budi Santoso, S.Kom', 'Fasilitator Utama CAT', NULL, NULL, NULL, '2026-09-01 00:17:35', '2026-09-03 01:14:01'),
(2, 'Siti Rahma, M.M', 'Pengawas Ujian Kedinasan', NULL, NULL, NULL, '2026-09-01 00:17:35', '2026-09-03 01:14:01'),
(3, 'Ahmad Dani, S.Sos', 'Koordinator Verifikasi Berkas', NULL, NULL, NULL, '2026-09-01 00:17:35', '2026-09-03 01:14:01'),
(4, 'Drs. Hendra Pratama', 'Petugas Teknis Jaringan', NULL, NULL, NULL, '2026-09-01 00:17:35', '2026-09-03 01:14:01'),
(5, 'Nur Hidayah, M.Si', NULL, NULL, NULL, NULL, '2026-09-03 01:11:55', '2026-09-03 01:14:01'),
(6, 'Fajar Ramadhan, S.Kom', NULL, NULL, NULL, NULL, '2026-09-03 01:11:55', '2026-09-03 01:14:01'),
(8, 'Dewi Lestari, S.E', NULL, NULL, NULL, NULL, '2026-09-03 01:11:55', '2026-09-03 01:11:55'),
(9, 'Rahmat Hidayat, S.STP', 'Pengawas Ujian Kedinasan Regional', NULL, NULL, NULL, '2026-09-09 00:23:54', '2026-09-09 00:23:54'),
(10, 'Rina Aprilia, S.Psi', 'Asesor Pemetaan Profil Kompetensi', NULL, NULL, NULL, '2026-09-09 00:23:54', '2026-09-09 00:23:54'),
(11, 'Eko Prasetyo, S.T', 'Petugas Laboratorium & Infrastruktur CAT', NULL, NULL, NULL, '2026-09-09 00:23:54', '2026-09-09 00:23:54'),
(12, 'Maya Kartika, S.E', 'Verifikator Berkas & Layanan Mutasi SIASN', NULL, NULL, NULL, '2026-09-09 00:23:54', '2026-09-09 00:23:54');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id_keg` int UNSIGNED NOT NULL,
  `nama_keg` varchar(150) NOT NULL,
  `id_jeniskeg` int UNSIGNED NOT NULL,
  `id_tklokasi` int UNSIGNED NOT NULL,
  `id_instansi` int UNSIGNED NOT NULL,
  `id_karyawan_koor` int UNSIGNED NOT NULL,
  `jmlh_peserta` int UNSIGNED NOT NULL DEFAULT '0',
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `status` enum('Belum Konfirmasi','Terkonfirmasi','Selesai','Dibatalkan') NOT NULL DEFAULT 'Belum Konfirmasi',
  `lampiran` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kegiatan`
--

INSERT INTO `kegiatan` (`id_keg`, `nama_keg`, `id_jeniskeg`, `id_tklokasi`, `id_instansi`, `id_karyawan_koor`, `jmlh_peserta`, `tanggal_mulai`, `tanggal_selesai`, `status`, `lampiran`, `created_at`, `updated_at`) VALUES
(1, 'Ujian Dinas Tingkat I & II BKN', 3, 1, 1, 1, 100, '2026-06-03', '2026-06-04', 'Selesai', 'https://drive.google.com/sampleA', '2026-09-01 00:17:35', '2026-09-29 00:18:04'),
(2, 'Bimtek Penilaian Kinerja ASN Pemprov', 2, 2, 2, 2, 120, '2026-06-04', '2026-06-05', 'Selesai', 'https://drive.google.com/sampleB', '2026-09-01 00:17:35', '2026-09-29 00:18:04'),
(3, 'Simulasi CAT Mandiri BKN', 3, 3, 3, 3, 80, '2026-06-05', '2026-06-05', 'Selesai', 'https://drive.google.com/sampleC', '2026-09-01 00:17:35', '2026-09-29 00:18:04'),
(4, 'Fasilitasi CAT Seleksi PPPK Tahap 1', 3, 4, 4, 4, 90, '2026-06-10', '2026-06-10', 'Selesai', 'https://drive.google.com/sampleD', '2026-09-01 00:17:35', '2026-09-29 00:18:04'),
(5, 'Asesmen Pemetaan Potensi Pegawai Daerah', 1, 2, 2, 4, 110, '2026-06-10', '2026-06-12', 'Selesai', 'https://drive.google.com/file/d/1BKN_2026_KEG_005_ST/view', '2026-09-03 01:17:32', '2026-09-29 01:39:35'),
(6, 'Seleksi CAT Mahasiswa Poltekip/Poltekim', 2, 1, 4, 6, 320, '2026-06-12', '2026-06-13', 'Selesai', 'sk_poltekip.pdf', '2026-09-03 01:17:32', '2026-09-29 00:18:04'),
(7, 'Uji Kompetensi Jabatan Fungsional Kepegawaian', 4, 3, 1, 5, 90, '2026-06-16', '2026-06-18', 'Selesai', 'edaran_ujikom.pdf', '2026-09-03 01:17:32', '2026-09-29 00:18:04'),
(8, 'Seleksi CASN Instansi Daerah Kalsel', 3, 4, 2, 2, 500, '2026-06-17', '2026-06-19', 'Selesai', 'https://drive.google.com/file/d/1BKN_2026_KEG_008_ST/view', '2026-09-03 01:17:32', '2026-09-29 01:39:35'),
(9, 'Workshop Implementasi SIASN Layanan Mutasi', 1, 2, 1, 4, 60, '2026-06-23', '2026-06-23', 'Selesai', 'https://drive.google.com/file/d/1BKN_2026_KEG_009_ST/view', '2026-09-03 01:17:32', '2026-09-29 01:39:35'),
(10, 'Fasilitasi Ujian CAT Ikatan Dinas IPDN 2026', 2, 1, 5, 1, 600, '2026-06-24', '2026-06-26', 'Selesai', 'panduan_cat_ipdn.pdf', '2026-09-03 01:17:32', '2026-09-29 00:18:04'),
(11, 'Rakor Pengawasan dan Pengendalian ASN Regional VIII', 4, 2, 1, 3, 75, '2026-06-25', '2026-06-27', 'Selesai', 'https://drive.google.com/file/d/1BKN_2026_KEG_011_ST/view', '2026-09-03 01:17:32', '2026-09-29 01:39:35'),
(21, 'Ujian Penyesuaian Ijazah ASN Kanreg VIII', 1, 1, 1, 1, 110, '2026-09-01', '2026-09-03', 'Selesai', 'lampiran_upkp.pdf', '2026-09-03 02:09:23', '2026-09-29 00:18:04'),
(22, 'Bimtek Tata Kelola Manajemen Talenta ASN', 1, 2, 2, 2, 75, '2026-09-02', '2026-09-04', 'Selesai', 'sk_talenta.pdf', '2026-09-03 02:09:23', '2026-09-29 00:18:04'),
(23, 'Simulasi CAT Mandiri BKN Sesi September', 2, 1, 1, 3, 180, '2026-09-03', '2026-09-03', 'Selesai', 'https://drive.google.com/file/d/1BKN_2026_KEG_023_ST/view', '2026-09-03 02:09:23', '2026-09-29 01:39:35'),
(24, 'Fasilitasi CAT Seleksi Kompetensi Dasar CPNS Kalsel', 3, 1, 2, 1, 450, '2026-09-05', '2026-09-08', 'Selesai', 'edaran_skd_cpns.pdf', '2026-09-03 02:09:23', '2026-09-29 00:18:04'),
(25, 'Uji Kompetensi Kenaikan Pangkat Pilihan', 1, 3, 3, 4, 90, '2026-09-09', '2026-09-10', 'Selesai', 'daftar_peserta.pdf', '2026-09-03 02:09:23', '2026-09-29 00:18:04'),
(26, 'Seleksi CAT Tenaga Teknis Non-ASN BLUD', 4, 1, 3, 5, 230, '2026-09-12', '2026-09-13', 'Selesai', 'https://drive.google.com/file/d/1BKN_2026_KEG_026_ST/view', '2026-09-03 02:09:23', '2026-09-29 01:39:35'),
(27, 'Sosialisasi Disiplin Pegawai Sesuai PP 94/2021', 1, 2, 1, 2, 60, '2026-09-16', '2026-09-16', 'Selesai', 'https://drive.google.com/file/d/1BKN_2026_KEG_027_ST/view', '2026-09-03 02:09:23', '2026-09-29 01:39:35'),
(28, 'Fasilitasi Ujian CAT Kedinasan Kemenkumham Kalsel', 2, 4, 4, 6, 320, '2026-09-18', '2026-09-20', 'Selesai', 'surat_tugas.pdf', '2026-09-03 02:09:23', '2026-09-29 00:18:04'),
(29, 'Asesmen Profil Kompetensi Pejabat Pengawas', 1, 2, 2, 4, 80, '2026-09-23', '2026-09-25', 'Selesai', 'https://drive.google.com/file/d/1BKN_2026_KEG_029_ST/view', '2026-09-03 02:09:23', '2026-09-29 01:39:35'),
(30, 'Rapat Evaluasi Pengadaan ASN Se-Kalimantan', 4, 2, 1, 3, 100, '2026-09-28', '2026-09-30', 'Terkonfirmasi', 'https://drive.google.com/file/d/1BKN_2026_KEG_030_ST/view', '2026-09-03 02:09:23', '2026-09-28 23:02:49'),
(31, 'Uji Kompetensi Jabatan Fungsional BKN', 1, 1, 1, 1, 180, '2026-10-02', '2026-10-04', 'Terkonfirmasi', 'ujikom_2026.pdf', '2026-09-08 00:17:35', '2026-09-29 00:18:04'),
(32, 'Seleksi CAT Tenaga Kesehatan Pemkab Banjar', 2, 3, 6, 2, 450, '2026-10-10', '2026-10-12', 'Terkonfirmasi', 'nakes_banjar.pdf', '2026-09-08 00:17:35', '2026-09-29 00:18:04'),
(33, 'Workshop Digitalisasi Layanan Kepegawaian', 1, 2, 2, 3, 80, '2026-10-15', '2026-10-15', 'Belum Konfirmasi', 'https://drive.google.com/file/d/1BKN_2026_KEG_033_ST/view', '2026-09-08 00:17:35', '2026-09-29 01:39:35'),
(34, 'Bimtek Sasaran Kinerja Pegawai (SKP) Kalteng', 1, 5, 17, 4, 200, '2026-10-20', '2026-10-22', 'Terkonfirmasi', 'https://drive.google.com/file/d/1BKN_2026_KEG_034_ST/view', '2026-09-08 00:17:35', '2026-09-29 01:39:35'),
(35, 'Ujian Dinas Tingkat I & II Pemkot Balikpapan', 3, 6, 34, 1, 120, '2026-10-25', '2026-10-26', 'Belum Konfirmasi', 'https://drive.google.com/file/d/1BKN_2026_KEG_035_ST/view', '2026-09-08 00:17:35', '2026-09-29 01:39:35'),
(36, 'Simulasi CAT Mandiri CASN Kabupaten Banjar', 3, 3, 6, 3, 250, '2026-11-05', '2026-11-06', 'Belum Konfirmasi', 'https://drive.google.com/file/d/1BKN_2026_KEG_036_ST/view', '2026-09-09 00:25:47', '2026-09-29 01:39:35'),
(37, 'Fasilitasi Seleksi PPPK Tenaga Guru Kalsel', 3, 4, 2, 1, 520, '2026-11-10', '2026-11-13', 'Terkonfirmasi', 'edaran_pppk_guru.pdf', '2026-09-09 00:25:47', '2026-09-29 00:18:04'),
(38, 'Asesmen Manajerial Pejabat Administrator Pemkab Tanah Laut', 1, 2, 7, 10, 45, '2026-11-15', '2026-11-16', 'Terkonfirmasi', 'https://drive.google.com/file/d/1BKN_2026_KEG_038_ST/view', '2026-09-09 00:25:47', '2026-09-29 01:39:35'),
(39, 'Uji Kompetensi Jabatan Fungsional Keperawatan BLUD', 4, 1, 3, 5, 130, '2026-11-18', '2026-11-19', 'Belum Konfirmasi', 'https://drive.google.com/file/d/1BKN_2026_KEG_039_ST/view', '2026-09-09 00:25:47', '2026-09-29 01:39:35'),
(40, 'Fasilitasi Ujian CAT Kedinasan Kaltara', 2, 5, 42, 9, 310, '2026-11-22', '2026-11-24', 'Terkonfirmasi', 'surat_tugas_kaltara.pdf', '2026-09-09 00:25:47', '2026-09-29 00:18:04'),
(41, 'Bimtek Integrasi SIASN dan Layanan Pensiun Otomatis', 1, 2, 1, 12, 95, '2026-11-26', '2026-11-27', 'Belum Konfirmasi', 'https://drive.google.com/file/d/1BKN_2026_KEG_041_ST/view', '2026-09-09 00:25:47', '2026-09-29 01:39:35'),
(42, 'Seleksi CAT Tenaga Teknis Pendamping Desa Pemkab Tapin', 4, 1, 9, 6, 175, '2026-12-01', '2026-12-02', 'Belum Konfirmasi', 'https://drive.google.com/file/d/1BKN_2026_KEG_042_ST/view', '2026-09-09 00:25:47', '2026-09-29 01:39:35'),
(43, 'Asesmen Pemetaan Talent Pool ASN Pemkot Samarinda', 1, 6, 33, 10, 85, '2026-12-05', '2026-12-07', 'Terkonfirmasi', 'sk_talent_pool.pdf', '2026-09-09 00:25:47', '2026-09-29 00:18:04'),
(44, 'Ujian Dinas Tingkat I & II Pemkab Hulu Sungai Selatan', 1, 1, 10, 2, 110, '2026-12-10', '2026-12-11', 'Belum Konfirmasi', 'https://drive.google.com/file/d/1BKN_2026_KEG_044_ST/view', '2026-09-09 00:25:47', '2026-09-29 01:39:35'),
(45, 'Rakor Evaluasi Kinerja Kepegawaian Se-Kalimantan Selatan', 1, 2, 1, 4, 150, '2026-12-15', '2026-12-16', 'Selesai', 'notulensi_rakor.pdf', '2026-09-09 00:25:47', '2026-09-29 00:18:04'),
(46, 'Simulasi CAT Mandiri Sekolah Kedinasan 2027', 2, 1, 1, 11, 400, '2027-01-10', '2027-01-12', 'Belum Konfirmasi', 'https://drive.google.com/file/d/1BKN_2026_KEG_046_ST/view', '2026-09-09 00:25:47', '2026-09-29 01:39:35'),
(47, 'Seleksi CASN Instansi Daerah Kalimantan Timur', 3, 6, 32, 1, 650, '2027-01-18', '2027-01-22', 'Belum Konfirmasi', 'https://drive.google.com/file/d/1BKN_2026_KEG_047_ST/view', '2026-09-09 00:25:47', '2026-09-29 01:39:35'),
(48, 'Fasilitasi Ujian Penyesuaian Ijazah Pemkab Kotabaru', 1, 3, 15, 3, 90, '2027-01-25', '2027-01-26', 'Belum Konfirmasi', 'https://drive.google.com/file/d/1BKN_2026_KEG_048_ST/view', '2026-09-09 00:25:47', '2026-09-29 01:39:35'),
(49, 'Sosialisasi Sistem Manajemen Kinerja Sesuai PermepanRB', 1, 2, 46, 12, 120, '2027-02-02', '2027-02-02', 'Belum Konfirmasi', 'https://drive.google.com/file/d/1BKN_2026_KEG_049_ST/view', '2026-09-09 00:25:47', '2026-09-29 01:39:35'),
(50, 'Uji Kompetensi Kenaikan Pangkat Pilihan Periode April 2027', 1, 1, 1, 5, 210, '2027-02-10', '2027-02-12', 'Belum Konfirmasi', 'https://drive.google.com/file/d/1BKN_2026_KEG_050_ST/view', '2026-09-09 00:25:47', '2026-09-29 01:39:35'),
(51, 'Pelaksanaan Seleksi Kompetensi Dasar (SKD) CASN 2026', 1, 1, 1, 1, 250, '2026-09-22', '2026-09-22', 'Selesai', 'https://drive.google.com/file/d/1BKN_2026_KEG_051_ST/view', '2026-09-22 01:28:32', '2026-09-29 01:39:35'),
(52, 'Rapat Koordinasi Evaluasi Kepegawaian Se-Kalimantan', 2, 2, 2, 2, 80, '2026-09-22', '2026-09-23', 'Selesai', 'https://drive.google.com/file/d/1BKN_2026_KEG_052_ST/view', '2026-09-22 01:28:32', '2026-09-29 01:39:35'),
(53, 'Bimbingan Teknis Fasilitasi SIASN Instansi Daerah', 3, 3, 3, 3, 120, '2026-09-22', '2026-09-22', 'Selesai', 'https://drive.google.com/file/d/1BKN_2026_KEG_053_ST/view', '2026-09-22 01:28:32', '2026-09-29 01:39:35'),
(54, 'Ujian Dinas Elektronik (e-UDIN) Tingkat I & II', 1, 1, 4, 1, 150, '2026-09-25', '2026-09-25', 'Selesai', 'https://drive.google.com/file/d/1BKN_2026_KEG_054_ST/view', '2026-09-22 01:28:32', '2026-09-29 01:39:35'),
(55, 'Sosialisasi Penerapan Sistem Merit dan Manajemen ASN', 3, 2, 5, 2, 200, '2026-09-27', '2026-09-28', 'Selesai', 'https://drive.google.com/file/d/1BKN_2026_KEG_055_ST/view', '2026-09-22 01:28:32', '2026-09-29 01:39:35'),
(56, 'Asesmen Penilaian Potensi dan Kompetensi Pegawai', 2, 3, 1, 3, 60, '2026-09-30', '2026-09-30', 'Terkonfirmasi', 'https://drive.google.com/file/d/1BKN_2026_KEG_056_ST/view', '2026-09-22 01:28:32', '2026-09-29 01:39:35'),
(57, 'Pelatihan Teknis Tata Cara Usul Pensiun Pegawai', 3, 1, 2, 4, 90, '2026-10-04', '2026-10-05', 'Belum Konfirmasi', 'https://drive.google.com/file/d/1BKN_2026_KEG_057_ST/view', '2026-09-22 01:28:32', '2026-09-29 01:39:35'),
(58, 'Workshop Digitalisasi Dokumen Arsip Kepegawaian', 3, 2, 3, 4, 110, '2026-09-12', '2026-09-12', 'Selesai', 'https://drive.google.com/file/d/1BKN_2026_KEG_058_ST/view', '2026-09-22 01:28:32', '2026-09-29 01:39:35'),
(59, 'Seleksi Pasca Sanggah PPPK Tenaga Kesehatan', 1, 1, 5, 1, 300, '2026-09-02', '2026-09-04', 'Selesai', 'https://drive.google.com/file/d/1BKN_2026_KEG_059_ST/view', '2026-09-22 01:28:32', '2026-09-29 01:39:35'),
(60, 'Rapat Konsolidasi Program Kerja Triwulan III', 2, 3, 1, 2, 45, '2026-08-23', '2026-08-23', 'Dibatalkan', 'https://drive.google.com/file/d/1BKN_2026_KEG_060_ST/view', '2026-09-22 01:28:32', '2026-09-29 01:39:35');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_kegiatan`
--

CREATE TABLE `laporan_kegiatan` (
  `id_laporan` int UNSIGNED NOT NULL,
  `id_keg` int UNSIGNED NOT NULL,
  `peserta_hadir` int UNSIGNED NOT NULL DEFAULT '0',
  `peserta_tidak_hadir` int UNSIGNED NOT NULL DEFAULT '0',
  `nilai_tertinggi` decimal(5,2) DEFAULT NULL,
  `nilai_terendah` decimal(5,2) DEFAULT NULL,
  `lampiran_laporan` varchar(255) DEFAULT NULL,
  `catatan_evaluasi` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `laporan_kegiatan`
--

INSERT INTO `laporan_kegiatan` (`id_laporan`, `id_keg`, `peserta_hadir`, `peserta_tidak_hadir`, `nilai_tertinggi`, `nilai_terendah`, `lampiran_laporan`, `catatan_evaluasi`, `created_at`, `updated_at`) VALUES
(1, 1, 95, 5, 485.50, 310.00, 'https://drive.google.com/laporan_udin_2026.pdf', 'Pelaksanaan e-UDIN berjalan lancar tanpa kendala server.', '2026-09-29 00:13:39', '2026-09-29 00:13:39'),
(2, 2, 118, 2, 92.50, 70.00, 'https://drive.google.com/laporan_bimtek_kinerja.pdf', 'Seluruh peserta menyerahkan hasil penilaian tepat waktu.', '2026-09-29 00:13:39', '2026-09-29 00:13:39'),
(3, 51, 242, 8, 490.00, 285.50, 'https://bkn.go.id/lampiran/laporan-skd-casn-2026.pdf', 'SKD CASN selesai tepat waktu dalam 4 sesi.', '2026-09-29 00:13:39', '2026-09-29 00:13:39'),
(4, 27, 50, 10, 450.25, 180.00, 'https://drive.google.com/SoDisPegawai', 'Perlunya tambahan arahan dalam kegiatan', '2026-09-28 16:50:54', '2026-09-28 16:50:54'),
(5, 3, 70, 10, 455.10, 256.90, 'https://drive.google.com/file/d/1BKN_2026_LAPORAN_KEG_003/view', 'Pelaksanaan Simulasi CAT Mandiri BKN berjalan dengan lancar dan tertib. Seluruh sarana infrastruktur CAT/sistem berfungsi optimal.', '2026-09-29 01:40:52', '2026-09-29 01:40:52'),
(6, 4, 80, 10, 456.80, 259.20, 'https://drive.google.com/file/d/1BKN_2026_LAPORAN_KEG_004/view', 'Pelaksanaan Fasilitasi CAT Seleksi PPPK Tahap 1 berjalan dengan lancar dan tertib. Seluruh sarana infrastruktur CAT/sistem berfungsi optimal.', '2026-09-29 01:40:52', '2026-09-29 01:40:52'),
(7, 5, 99, 11, 458.50, 261.50, 'https://drive.google.com/file/d/1BKN_2026_LAPORAN_KEG_005/view', 'Pelaksanaan Asesmen Pemetaan Potensi Pegawai Daerah berjalan dengan lancar dan tertib. Seluruh sarana infrastruktur CAT/sistem berfungsi optimal.', '2026-09-29 01:40:52', '2026-09-29 01:40:52'),
(8, 6, 291, 29, 460.20, 263.80, 'https://drive.google.com/file/d/1BKN_2026_LAPORAN_KEG_006/view', 'Pelaksanaan Seleksi CAT Mahasiswa Poltekip/Poltekim berjalan dengan lancar dan tertib. Seluruh sarana infrastruktur CAT/sistem berfungsi optimal.', '2026-09-29 01:40:52', '2026-09-29 01:40:52'),
(9, 7, 83, 7, 461.90, 266.10, 'https://drive.google.com/file/d/1BKN_2026_LAPORAN_KEG_007/view', 'Pelaksanaan Uji Kompetensi Jabatan Fungsional Kepegawaian berjalan dengan lancar dan tertib. Seluruh sarana infrastruktur CAT/sistem berfungsi optimal.', '2026-09-29 01:40:52', '2026-09-29 01:40:52'),
(10, 8, 465, 35, 463.60, 268.40, 'https://drive.google.com/file/d/1BKN_2026_LAPORAN_KEG_008/view', 'Pelaksanaan Seleksi CASN Instansi Daerah Kalsel berjalan dengan lancar dan tertib. Seluruh sarana infrastruktur CAT/sistem berfungsi optimal.', '2026-09-29 01:40:52', '2026-09-29 01:40:52'),
(11, 9, 56, 4, 465.30, 270.70, 'https://drive.google.com/file/d/1BKN_2026_LAPORAN_KEG_009/view', 'Pelaksanaan Workshop Implementasi SIASN Layanan Mutasi berjalan dengan lancar dan tertib. Seluruh sarana infrastruktur CAT/sistem berfungsi optimal.', '2026-09-29 01:40:52', '2026-09-29 01:40:52'),
(12, 10, 570, 30, 467.00, 273.00, 'https://drive.google.com/file/d/1BKN_2026_LAPORAN_KEG_010/view', 'Pelaksanaan Fasilitasi Ujian CAT Ikatan Dinas IPDN 2026 berjalan dengan lancar dan tertib. Seluruh sarana infrastruktur CAT/sistem berfungsi optimal.', '2026-09-29 01:40:52', '2026-09-29 01:40:52'),
(13, 11, 72, 3, 468.70, 275.30, 'https://drive.google.com/file/d/1BKN_2026_LAPORAN_KEG_011/view', 'Pelaksanaan Rakor Pengawasan dan Pengendalian ASN Regional VIII berjalan dengan lancar dan tertib. Seluruh sarana infrastruktur CAT/sistem berfungsi optimal.', '2026-09-29 01:40:52', '2026-09-29 01:40:52'),
(14, 21, 101, 9, 485.70, 298.30, 'https://drive.google.com/file/d/1BKN_2026_LAPORAN_KEG_021/view', 'Pelaksanaan Ujian Penyesuaian Ijazah ASN Kanreg VIII berjalan dengan lancar dan tertib. Seluruh sarana infrastruktur CAT/sistem berfungsi optimal.', '2026-09-29 01:40:52', '2026-09-29 01:40:52'),
(15, 22, 70, 5, 487.40, 300.60, 'https://drive.google.com/file/d/1BKN_2026_LAPORAN_KEG_022/view', 'Pelaksanaan Bimtek Tata Kelola Manajemen Talenta ASN berjalan dengan lancar dan tertib. Seluruh sarana infrastruktur CAT/sistem berfungsi optimal.', '2026-09-29 01:40:52', '2026-09-29 01:40:52'),
(16, 23, 169, 11, 489.10, 302.90, 'https://drive.google.com/file/d/1BKN_2026_LAPORAN_KEG_023/view', 'Pelaksanaan Simulasi CAT Mandiri BKN Sesi September berjalan dengan lancar dan tertib. Seluruh sarana infrastruktur CAT/sistem berfungsi optimal.', '2026-09-29 01:40:52', '2026-09-29 01:40:52'),
(17, 24, 428, 22, 490.80, 305.20, 'https://drive.google.com/file/d/1BKN_2026_LAPORAN_KEG_024/view', 'Pelaksanaan Fasilitasi CAT Seleksi Kompetensi Dasar CPNS Kalsel berjalan dengan lancar dan tertib. Seluruh sarana infrastruktur CAT/sistem berfungsi optimal.', '2026-09-29 01:40:52', '2026-09-29 01:40:52'),
(18, 25, 86, 4, 492.50, 307.50, 'https://drive.google.com/file/d/1BKN_2026_LAPORAN_KEG_025/view', 'Pelaksanaan Uji Kompetensi Kenaikan Pangkat Pilihan berjalan dengan lancar dan tertib. Seluruh sarana infrastruktur CAT/sistem berfungsi optimal.', '2026-09-29 01:40:52', '2026-09-29 01:40:52'),
(19, 26, 223, 7, 494.20, 309.80, 'https://drive.google.com/file/d/1BKN_2026_LAPORAN_KEG_026/view', 'Pelaksanaan Seleksi CAT Tenaga Teknis Non-ASN BLUD berjalan dengan lancar dan tertib. Seluruh sarana infrastruktur CAT/sistem berfungsi optimal.', '2026-09-29 01:40:52', '2026-09-29 01:40:52'),
(20, 28, 272, 48, 452.60, 314.40, 'https://drive.google.com/file/d/1BKN_2026_LAPORAN_KEG_028/view', 'Pelaksanaan Fasilitasi Ujian CAT Kedinasan Kemenkumham Kalsel berjalan dengan lancar dan tertib. Seluruh sarana infrastruktur CAT/sistem berfungsi optimal.', '2026-09-29 01:40:52', '2026-09-29 01:40:52'),
(21, 29, 69, 11, 454.30, 316.70, 'https://drive.google.com/file/d/1BKN_2026_LAPORAN_KEG_029/view', 'Pelaksanaan Asesmen Profil Kompetensi Pejabat Pengawas berjalan dengan lancar dan tertib. Seluruh sarana infrastruktur CAT/sistem berfungsi optimal.', '2026-09-29 01:40:52', '2026-09-29 01:40:52'),
(22, 45, 132, 18, 481.50, 283.50, 'https://drive.google.com/file/d/1BKN_2026_LAPORAN_KEG_045/view', 'Pelaksanaan Rakor Evaluasi Kinerja Kepegawaian Se-Kalimantan Selatan berjalan dengan lancar dan tertib. Seluruh sarana infrastruktur CAT/sistem berfungsi optimal.', '2026-09-29 01:40:52', '2026-09-29 01:40:52'),
(23, 52, 76, 4, 493.40, 299.60, 'https://drive.google.com/file/d/1BKN_2026_LAPORAN_KEG_052/view', 'Pelaksanaan Rapat Koordinasi Evaluasi Kepegawaian Se-Kalimantan berjalan dengan lancar dan tertib. Seluruh sarana infrastruktur CAT/sistem berfungsi optimal.', '2026-09-29 01:40:52', '2026-09-29 01:40:52'),
(24, 53, 115, 5, 450.10, 301.90, 'https://drive.google.com/file/d/1BKN_2026_LAPORAN_KEG_053/view', 'Pelaksanaan Bimbingan Teknis Fasilitasi SIASN Instansi Daerah berjalan dengan lancar dan tertib. Seluruh sarana infrastruktur CAT/sistem berfungsi optimal.', '2026-09-29 01:40:52', '2026-09-29 01:40:52'),
(25, 54, 146, 4, 451.80, 304.20, 'https://drive.google.com/file/d/1BKN_2026_LAPORAN_KEG_054/view', 'Pelaksanaan Ujian Dinas Elektronik (e-UDIN) Tingkat I & II berjalan dengan lancar dan tertib. Seluruh sarana infrastruktur CAT/sistem berfungsi optimal.', '2026-09-29 01:40:52', '2026-09-29 01:40:52'),
(26, 55, 196, 4, 453.50, 306.50, 'https://drive.google.com/file/d/1BKN_2026_LAPORAN_KEG_055/view', 'Pelaksanaan Sosialisasi Penerapan Sistem Merit dan Manajemen ASN berjalan dengan lancar dan tertib. Seluruh sarana infrastruktur CAT/sistem berfungsi optimal.', '2026-09-29 01:40:52', '2026-09-29 01:40:52'),
(27, 58, 96, 14, 458.60, 313.40, 'https://drive.google.com/file/d/1BKN_2026_LAPORAN_KEG_058/view', 'Pelaksanaan Workshop Digitalisasi Dokumen Arsip Kepegawaian berjalan dengan lancar dan tertib. Seluruh sarana infrastruktur CAT/sistem berfungsi optimal.', '2026-09-29 01:40:52', '2026-09-29 01:40:52'),
(28, 59, 264, 36, 460.30, 315.70, 'https://drive.google.com/file/d/1BKN_2026_LAPORAN_KEG_059/view', 'Pelaksanaan Seleksi Pasca Sanggah PPPK Tenaga Kesehatan berjalan dengan lancar dan tertib. Seluruh sarana infrastruktur CAT/sistem berfungsi optimal.', '2026-09-29 01:40:52', '2026-09-29 01:40:52');

-- --------------------------------------------------------

--
-- Table structure for table `rekam_kj`
--

CREATE TABLE `rekam_kj` (
  `id_kj` int UNSIGNED NOT NULL,
  `id_karyawan` int UNSIGNED NOT NULL,
  `id_keg` int UNSIGNED NOT NULL,
  `ket_rekam` varchar(255) DEFAULT NULL,
  `tgl_rekam` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rekam_kj`
--

INSERT INTO `rekam_kj` (`id_kj`, `id_karyawan`, `id_keg`, `ket_rekam`, `tgl_rekam`, `created_at`) VALUES
(1, 1, 1, 'Bertindak sebagai penanggung jawab ruang ujian CAT', '2026-06-03', '2026-09-01 00:17:35'),
(2, 1, 2, 'Pemateri dan fasilitator teknis penilaian kinerja', '2026-06-04', '2026-09-01 00:17:35'),
(3, 2, 2, 'Operator sistem dan pengawas live score', '2026-06-04', '2026-09-01 00:17:35'),
(4, 3, 3, 'Koordinator teknis CAT PPPK hari ke-1 s.d ke-4', '2026-06-05', '2026-09-01 00:17:35'),
(5, 4, 4, 'Asesor pendamping pemetaan kompetensi pegawai', '2026-06-10', '2026-09-01 00:17:35'),
(6, 6, 6, 'Penanggung jawab infrastruktur jaringan & server CAT', '2026-06-12', '2026-09-03 01:17:32'),
(7, 5, 7, 'Tim verifikator kelengkapan berkas uji kompetensi', '2026-06-16', '2026-09-03 01:17:32'),
(8, 2, 8, 'Koordinator lapangan verifikasi administrasi CASN', '2026-06-17', '2026-09-03 01:17:32'),
(9, 4, 9, 'Narasumber bimbingan teknis alur layanan SIASN', '2026-06-23', '2026-09-03 01:17:32'),
(10, 1, 10, 'Koordinator utama pelaksanaan seleksi CAT IPDN', '2026-06-24', '2026-09-03 01:17:32'),
(11, 3, 11, 'Notulis dan tim administrasi rakor pengawasan', '2026-06-25', '2026-09-03 01:17:32'),
(21, 1, 21, 'Koordinator teknis CAT ujian penyesuaian ijazah', '2026-09-01', '2026-09-03 02:09:23'),
(22, 2, 22, 'Narasumber bimbingan teknis manajemen talenta', '2026-09-02', '2026-09-03 02:09:23'),
(23, 3, 23, 'Pengawas dan admin ruang CAT simulasi mandiri', '2026-09-03', '2026-09-03 02:09:23'),
(24, 1, 24, 'Koordinator utama tim fasilitasi CAT SKD CPNS', '2026-09-05', '2026-09-03 02:09:23'),
(25, 4, 25, 'Penguji verifikasi berkas uji kompetensi pilihan', '2026-09-09', '2026-09-03 02:09:23'),
(26, 5, 26, 'Koordinator teknis ujian CAT Non-ASN', '2026-09-12', '2026-09-03 02:09:23'),
(27, 1, 31, 'Penanggung jawab utama ruang CAT ujikom BKN', '2026-10-02', '2026-09-09 00:25:47'),
(28, 2, 32, 'Pengawas dan verifikator kehadiran CAT Nakes Banjar', '2026-10-10', '2026-09-09 00:25:47'),
(29, 3, 33, 'Fasilitator ruang diskusi workshop digitalisasi SIASN', '2026-10-15', '2026-09-09 00:25:47'),
(30, 4, 34, 'Pemateri teknis penyusunan SKP Kalteng', '2026-10-20', '2026-09-09 00:25:47'),
(31, 1, 37, 'Koordinator teknis lapangan seleksi PPPK Guru', '2026-11-10', '2026-09-09 00:25:47'),
(32, 10, 38, 'Tim asesor pemetaan profil kompetensi ASN', '2026-11-15', '2026-09-09 00:25:47'),
(33, 9, 40, 'Koordinator tim pengawas kedinasan UPT Tarakan', '2026-11-22', '2026-09-09 00:25:47'),
(34, 11, 46, 'Petugas pemeliharaan server & jaringan CAT mandiri', '2027-01-10', '2026-09-09 00:25:47'),
(35, 12, 49, 'Narasumber sosialisasi manajemen kinerja KemenPANRB', '2027-02-02', '2026-09-09 00:25:47');

-- --------------------------------------------------------

--
-- Table structure for table `titik_lokasi`
--

CREATE TABLE `titik_lokasi` (
  `id_tklokasi` int UNSIGNED NOT NULL,
  `nm_lokasi` varchar(100) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `titik_lokasi`
--

INSERT INTO `titik_lokasi` (`id_tklokasi`, `nm_lokasi`, `alamat`, `created_at`) VALUES
(1, 'Gedung CAT Utama Kanreg VIII', 'JL. Bhayangkara 1', '2026-09-01 00:17:35'),
(2, 'Aula Rapat Lantai 2 BKN', 'JL. Bhayangkara 2', '2026-09-01 00:17:35'),
(3, 'Auditorium Idaman Banjarbaru', 'JL. Flamboyan 3', '2026-09-01 00:17:35'),
(4, 'Lab CAT BKD Provinsi Kalsel', 'JL. Kertanegara 4', '2026-09-01 00:17:35'),
(5, 'BKN Station Mandiri Palangkaraya', 'JL. RTA Milono Km 3.5', '2026-09-08 00:17:35'),
(6, 'UPT BKN Balikpapan', 'JL. Jendral Sudirman 12', '2026-09-08 00:17:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `nip` varchar(18) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','pegawai','pimpinan') NOT NULL DEFAULT 'pegawai',
  `id_karyawan` int UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `nip`, `email`, `password`, `role`, `id_karyawan`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin_bkn', '199001012015011001', 'rafifadillah420@gmail.com', '$2y$12$hhOuPFTQOxM7Jdp8qXnJLuwkpEndJXb8ARMGXhTFAtO.LrTOFQaU.', 'admin', NULL, NULL, '2026-09-01 17:37:19', '2026-09-24 07:10:58'),
(2, 'budi_santoso', '199203042018021002', 'budi.santoso@bkn.go.id', '$2y$12$hKicAGqcuggCLStODtdohOVWnbCHXv.wv1hRtfoedAvzbWFRhsLlG', 'pegawai', 1, NULL, '2026-09-03 01:14:01', '2026-09-23 23:12:41'),
(3, 'siti_rahma', '199505062020032001', 'siti.rahma@bkn.go.id', '$2y$12$azWdf4/Q8jWKkWVkEEWQp.Ic1W5D2tkOnuHsUMRYDwVzSC/oa9Bza', 'pegawai', 2, NULL, '2026-09-03 01:14:01', '2026-09-22 00:48:29'),
(4, 'kakanreg_viii', '198507082010041003', 'kakanreg@bkn.go.id', '$2y$12$8QEpJWSFi5KwPdHEMFGiauiWo/ZdNGr3Uo/WBHbdHesRbYNWK3mFS', 'pimpinan', NULL, NULL, '2026-09-03 01:14:01', '2026-09-15 00:24:56'),
(5, 'ahmad_dani', '199301152019031001', 'ahmad.dani@bkn.go.id', '$2y$12$okaDUSmKUh0zptVVzXkiXOGAkoeHKRMR26y.ks307F6OQu9ZQBnV.', 'pegawai', 3, NULL, '2026-09-22 02:41:28', '2026-09-21 18:42:22'),
(6, 'hendra_pratama', '198804202012011002', 'hendra.pratama@bkn.go.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'pegawai', 4, NULL, '2026-09-22 02:41:28', '2026-09-22 02:41:28'),
(7, 'nur_hidayah', '199408122020012003', 'nur.hidayah@bkn.go.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'pegawai', 5, NULL, '2026-09-22 02:41:28', '2026-09-22 02:41:28'),
(8, 'fajar_ramadhan', '199602282021021001', 'fajar.ramadhan@bkn.go.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'pegawai', 6, NULL, '2026-09-22 02:41:28', '2026-09-22 02:41:28'),
(9, 'dewi_lestari', '199111052016042002', 'dewi.lestari@bkn.go.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'pegawai', 8, NULL, '2026-09-22 02:41:28', '2026-09-22 02:41:28'),
(10, 'rahmat_hidayat', '199009142014021003', 'rahmat.hidayat@bkn.go.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'pegawai', 9, NULL, '2026-09-22 02:41:28', '2026-09-22 02:41:28'),
(11, 'rina_aprilia', '199504182020022001', 'rina.aprilia@bkn.go.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'pegawai', 10, NULL, '2026-09-22 02:41:28', '2026-09-22 02:41:28'),
(12, 'eko_prasetyo', '199207222018011004', 'eko.prasetyo@bkn.go.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'pegawai', 11, NULL, '2026-09-22 02:41:28', '2026-09-22 02:41:28'),
(13, 'maya_kartika', '199310102019022002', 'maya.kartika@bkn.go.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'pegawai', 12, NULL, '2026-09-22 02:41:28', '2026-09-22 02:41:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `instansi`
--
ALTER TABLE `instansi`
  ADD PRIMARY KEY (`id_instansi`);

--
-- Indexes for table `jenis_keg`
--
ALTER TABLE `jenis_keg`
  ADD PRIMARY KEY (`id_jeniskeg`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id_keg`),
  ADD KEY `fk_kegiatan_jenis` (`id_jeniskeg`),
  ADD KEY `fk_kegiatan_lokasi` (`id_tklokasi`),
  ADD KEY `fk_kegiatan_instansi` (`id_instansi`),
  ADD KEY `fk_kegiatan_koordinator` (`id_karyawan_koor`);

--
-- Indexes for table `laporan_kegiatan`
--
ALTER TABLE `laporan_kegiatan`
  ADD PRIMARY KEY (`id_laporan`),
  ADD UNIQUE KEY `uk_laporan_kegiatan` (`id_keg`);

--
-- Indexes for table `rekam_kj`
--
ALTER TABLE `rekam_kj`
  ADD PRIMARY KEY (`id_kj`),
  ADD KEY `fk_rekam_karyawan` (`id_karyawan`),
  ADD KEY `fk_rekam_kegiatan` (`id_keg`);

--
-- Indexes for table `titik_lokasi`
--
ALTER TABLE `titik_lokasi`
  ADD PRIMARY KEY (`id_tklokasi`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_users_karyawan` (`id_karyawan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `instansi`
--
ALTER TABLE `instansi`
  MODIFY `id_instansi` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `jenis_keg`
--
ALTER TABLE `jenis_keg`
  MODIFY `id_jeniskeg` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id_keg` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `laporan_kegiatan`
--
ALTER TABLE `laporan_kegiatan`
  MODIFY `id_laporan` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `rekam_kj`
--
ALTER TABLE `rekam_kj`
  MODIFY `id_kj` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `titik_lokasi`
--
ALTER TABLE `titik_lokasi`
  MODIFY `id_tklokasi` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD CONSTRAINT `fk_kegiatan_instansi` FOREIGN KEY (`id_instansi`) REFERENCES `instansi` (`id_instansi`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_kegiatan_jenis` FOREIGN KEY (`id_jeniskeg`) REFERENCES `jenis_keg` (`id_jeniskeg`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_kegiatan_koordinator` FOREIGN KEY (`id_karyawan_koor`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_kegiatan_lokasi` FOREIGN KEY (`id_tklokasi`) REFERENCES `titik_lokasi` (`id_tklokasi`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `laporan_kegiatan`
--
ALTER TABLE `laporan_kegiatan`
  ADD CONSTRAINT `fk_laporan_kegiatan` FOREIGN KEY (`id_keg`) REFERENCES `kegiatan` (`id_keg`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rekam_kj`
--
ALTER TABLE `rekam_kj`
  ADD CONSTRAINT `fk_rekam_karyawan` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rekam_kegiatan` FOREIGN KEY (`id_keg`) REFERENCES `kegiatan` (`id_keg`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_karyawan` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
