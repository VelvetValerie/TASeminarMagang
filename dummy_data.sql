-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 06, 2026 at 06:50 AM
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
(1, 'Pengembangan Karier (UDIN/UPKP)', '2026-09-01 00:17:35'),
(2, 'SKD CPNS', '2026-09-01 00:17:35'),
(3, 'SKB CPNS', '2026-09-01 00:17:35'),
(4, 'PPPK', '2026-09-01 00:17:35'),
(5, 'SKD Sekolah Kedinasan', '2026-10-05 05:54:18'),
(6, 'Seleksi Lanjutan Sekolah Kedinasan', '2026-10-05 05:54:18'),
(7, 'Seleksi Selain ASN (BLUD, perangkat desa, dll)', '2026-10-05 05:54:18'),
(8, 'Seleksi Lainnya (uji kompetensi, beasiswa, dll)', '2026-10-05 05:54:18'),
(9, 'Sertifikasi CAT', '2026-10-05 05:54:18'),
(10, 'Simulasi CAT', '2026-10-05 05:54:18'),
(11, 'KDKMP dan KNMP', '2026-10-05 05:54:18');

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
(1, 'Ujian Dinas Tingkat I ASN Kalsel', 1, 1, 2, 1, 120, '2026-06-02', '2026-06-03', 'Selesai', 'https://drive.google.com/sample_juni_1', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(2, 'Ujian Penyesuaian Kenaikan Pangkat (UPKP) BKN', 1, 2, 1, 3, 85, '2026-06-04', '2026-06-04', 'Selesai', 'https://drive.google.com/sample_juni_2', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(3, 'Simulasi CAT Mandiri Persiapan SKD', 10, 1, 1, 11, 300, '2026-06-05', '2026-06-06', 'Selesai', 'https://drive.google.com/sample_juni_3', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(4, 'Fasilitasi CAT PPPK Tenaga Guru Pemko Banjarbaru', 4, 3, 16, 4, 250, '2026-06-08', '2026-06-10', 'Selesai', 'https://drive.google.com/sample_juni_4', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(5, 'Asesmen Pemetaan Profil KDKMP dan KNMP', 11, 2, 1, 10, 60, '2026-06-11', '2026-06-11', 'Selesai', 'https://drive.google.com/sample_juni_5', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(6, 'Seleksi CAT Mahasiswa IPDN (SKD Sekolah Kedinasan)', 5, 1, 5, 2, 400, '2026-06-12', '2026-06-14', 'Selesai', 'https://drive.google.com/sample_juni_6', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(7, 'Uji Kompetensi Jabatan Fungsional Kepegawaian', 8, 2, 1, 5, 90, '2026-06-15', '2026-06-16', 'Selesai', 'https://drive.google.com/sample_juni_7', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(8, 'Seleksi Lanjutan Sekolah Kedinasan Poltekip/Poltekim', 6, 4, 4, 6, 180, '2026-06-17', '2026-06-18', 'Selesai', 'https://drive.google.com/sample_juni_8', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(9, 'Fasilitasi CAT Non-ASN BLUD RSUD Ulin', 7, 1, 2, 5, 220, '2026-06-19', '2026-06-20', 'Selesai', 'https://drive.google.com/sample_juni_9', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(10, 'Sertifikasi CAT Petugas Fasilitator Regional', 9, 2, 1, 1, 45, '2026-06-22', '2026-06-22', 'Selesai', 'https://drive.google.com/sample_juni_10', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(11, 'Simulasi CAT Terpadu CASN Kabupaten Banjar', 10, 3, 6, 3, 350, '2026-06-23', '2026-06-24', 'Selesai', 'https://drive.google.com/sample_juni_11', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(12, 'Seleksi PPPK Tenaga Kesehatan Tanah Laut', 4, 1, 7, 2, 190, '2026-06-25', '2026-06-26', 'Selesai', 'https://drive.google.com/sample_juni_12', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(13, 'Ujian SKD CPNS Kemenkumham Kalsel', 2, 4, 4, 6, 500, '2026-06-27', '2026-06-29', 'Selesai', 'https://drive.google.com/sample_juni_13', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(14, 'Seleksi Beasiswa S2 Layanan Kepegawaian', 8, 2, 1, 12, 40, '2026-06-30', '2026-06-30', 'Selesai', 'https://drive.google.com/sample_juni_14', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(15, 'Seleksi Perangkat Desa Kabupaten Barito Kuala', 7, 3, 8, 4, 130, '2026-06-30', '2026-06-30', 'Selesai', 'https://drive.google.com/sample_juni_15', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(16, 'Ujian Dinas Elektronik (e-UDIN) Pemko Banjarmasin', 1, 1, 3, 1, 110, '2026-07-02', '2026-07-03', 'Selesai', 'https://drive.google.com/sample_juli_16', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(17, 'Seleksi SKD CPNS Instansi Daerah Tapin', 2, 1, 9, 2, 420, '2026-07-05', '2026-07-07', 'Selesai', 'https://drive.google.com/sample_juli_17', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(18, 'Seleksi SKB CPNS Jalur Wawancara & CAT Pemprov Kalsel', 3, 2, 2, 4, 150, '2026-07-08', '2026-07-09', 'Selesai', 'https://drive.google.com/sample_juli_18', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(19, 'Fasilitasi Seleksi PPPK Teknis Barito Kuala', 4, 3, 8, 3, 210, '2026-07-10', '2026-07-11', 'Selesai', 'https://drive.google.com/sample_juli_19', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(20, 'Ujian SKD Sekolah Kedinasan STIN & STIS', 5, 1, 1, 1, 310, '2026-07-13', '2026-07-15', 'Selesai', 'https://drive.google.com/sample_juli_20', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(21, 'Seleksi Lanjutan Psikotes Sekolah Kedinasan IPDN', 6, 2, 5, 10, 140, '2026-07-16', '2026-07-17', 'Selesai', 'https://drive.google.com/sample_juli_21', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(22, 'Seleksi Tenaga Kontrak BLUD RSUD Ansari Saleh', 7, 4, 2, 5, 175, '2026-07-18', '2026-07-19', 'Selesai', 'https://drive.google.com/sample_juli_22', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(23, 'Uji Kompetensi Kenaikan Pangkat Pilihan', 8, 1, 1, 12, 95, '2026-07-21', '2026-07-21', 'Selesai', 'https://drive.google.com/sample_juli_23', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(24, 'Sertifikasi Keahlian Pengelola CAT BKN', 9, 1, 1, 11, 35, '2026-07-22', '2026-07-22', 'Selesai', 'https://drive.google.com/sample_juli_24', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(25, 'Simulasi CAT Online Bagi Pelajar SMA/SMK Banjarbaru', 10, 3, 16, 3, 450, '2026-07-23', '2026-07-24', 'Selesai', 'https://drive.google.com/sample_juli_25', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(26, 'Sosialisasi Program KDKMP dan KNMP Regional VIII', 11, 2, 1, 4, 80, '2026-07-25', '2026-07-25', 'Selesai', 'https://drive.google.com/sample_juli_26', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(27, 'Ujian UPKP Pegawai Kanreg VIII BKN', 1, 1, 1, 1, 60, '2026-07-27', '2026-07-27', 'Selesai', 'https://drive.google.com/sample_juli_27', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(28, 'Fasilitasi SKD CPNS Kabupaten Hulu Sungai Selatan', 2, 1, 10, 2, 380, '2026-07-28', '2026-07-30', 'Selesai', 'https://drive.google.com/sample_juli_28', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(29, 'Seleksi SKB Praktik Kerja PPPK Jabatan Komputer', 3, 2, 1, 6, 75, '2026-07-31', '2026-07-31', 'Selesai', 'https://drive.google.com/sample_juli_29', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(30, 'Seleksi Tenaga Pendamping Desa Hulu Sungai Tengah', 7, 3, 11, 5, 160, '2026-07-31', '2026-07-31', 'Selesai', 'https://drive.google.com/sample_juli_30', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(31, 'Ujian Dinas Tingkat II Pemkab Tanah Bumbu', 1, 1, 14, 1, 95, '2026-08-03', '2026-08-04', 'Selesai', 'https://drive.google.com/sample_agustus_31', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(32, 'Pelaksanaan SKD CPNS Provinsi Kalimantan Tengah', 2, 5, 17, 9, 600, '2026-08-05', '2026-08-08', 'Selesai', 'https://drive.google.com/sample_agustus_32', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(33, 'Seleksi SKB CPNS Pemkot Palangkaraya', 3, 5, 18, 9, 180, '2026-08-10', '2026-08-11', 'Selesai', 'https://drive.google.com/sample_agustus_33', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(34, 'Fasilitasi PPPK Guru Tahap II Pemkab Kotabaru', 4, 1, 15, 2, 290, '2026-08-12', '2026-08-14', 'Selesai', 'https://drive.google.com/sample_agustus_34', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(35, 'Seleksi SKD Sekolah Kedinasan Poltekip Kalteng', 5, 5, 4, 9, 230, '2026-08-15', '2026-08-16', 'Selesai', 'https://drive.google.com/sample_agustus_35', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(36, 'Seleksi Lanjutan Tes Kesehatan Sekolah Kedinasan', 6, 2, 5, 10, 110, '2026-08-18', '2026-08-19', 'Selesai', 'https://drive.google.com/sample_agustus_36', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(37, 'Seleksi Pegawai Non-ASN Badan Keuangan Daerah', 7, 1, 2, 5, 140, '2026-08-20', '2026-08-20', 'Selesai', 'https://drive.google.com/sample_agustus_37', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(38, 'Uji Kompetensi Asesor Kepegawaian Kalsel', 8, 2, 1, 10, 50, '2026-08-21', '2026-08-22', 'Selesai', 'https://drive.google.com/sample_agustus_38', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(39, 'Sertifikasi Operator Komputer UPT CAT BKN', 9, 1, 1, 11, 30, '2026-08-24', '2026-08-24', 'Selesai', 'https://drive.google.com/sample_agustus_39', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(40, 'Simulasi CAT Mandiri HUT Kemerdekaan RI', 10, 1, 1, 3, 500, '2026-08-25', '2026-08-26', 'Selesai', 'https://drive.google.com/sample_agustus_40', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(41, 'Evaluasi Capaian KDKMP dan KNMP Triwulan II', 11, 2, 1, 4, 70, '2026-08-27', '2026-08-27', 'Selesai', 'https://drive.google.com/sample_agustus_41', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(42, 'Ujian UPKP Penyesuaian S1/S2 Pegawai Daerah', 1, 3, 6, 1, 80, '2026-08-28', '2026-08-28', 'Selesai', 'https://drive.google.com/sample_agustus_42', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(43, 'Pelaksanaan SKD CPNS Kota Samarinda', 2, 6, 33, 1, 520, '2026-08-28', '2026-08-30', 'Selesai', 'https://drive.google.com/sample_agustus_43', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(44, 'Seleksi PPPK Tenaga Teknis Kabupaten Tabalong', 4, 1, 13, 2, 210, '2026-08-31', '2026-08-31', 'Selesai', 'https://drive.google.com/sample_agustus_44', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(45, 'Seleksi Pamong Desa Kabupaten Sukamara', 7, 5, 27, 9, 90, '2026-08-31', '2026-08-31', 'Selesai', 'https://drive.google.com/sample_agustus_45', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(46, 'Ujian Dinas Tingkat I & II Kanreg VIII BKN', 1, 1, 1, 1, 110, '2026-09-01', '2026-09-02', 'Selesai', 'https://drive.google.com/sample_sept_46', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(47, 'Seleksi SKD CPNS Provinsi Kalimantan Timur', 2, 6, 32, 1, 700, '2026-09-03', '2026-09-06', 'Selesai', 'https://drive.google.com/sample_sept_47', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(48, 'Seleksi SKB CPNS Formasi Analis Hukum', 3, 2, 1, 4, 120, '2026-09-07', '2026-09-08', 'Selesai', 'https://drive.google.com/sample_sept_48', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(49, 'Fasilitasi CAT PPPK Jabatan Fungsional Balikpapan', 4, 6, 34, 12, 310, '2026-09-09', '2026-09-11', 'Selesai', 'https://drive.google.com/sample_sept_49', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(50, 'Seleksi SKD Sekolah Kedinasan IPDN Kalbar-Kalsel', 5, 1, 5, 2, 450, '2026-09-12', '2026-09-14', 'Selesai', 'https://drive.google.com/sample_sept_50', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(51, 'Seleksi Lanjutan Kesamaptaan Sekolah Kedinasan', 6, 3, 4, 6, 160, '2026-09-15', '2026-09-16', 'Selesai', 'https://drive.google.com/sample_sept_51', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(52, 'Seleksi Tenaga Pendukung Non-ASN BKN', 7, 1, 1, 5, 130, '2026-09-17', '2026-09-17', 'Selesai', 'https://drive.google.com/sample_sept_52', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(53, 'Asesmen Talent Pool Pejabat Administrator', 8, 2, 2, 10, 85, '2026-09-18', '2026-09-19', 'Selesai', 'https://drive.google.com/sample_sept_53', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(54, 'Sertifikasi Asesor Pemetaan Profil Kompetensi', 9, 2, 1, 10, 40, '2026-09-21', '2026-09-21', 'Selesai', 'https://drive.google.com/sample_sept_54', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(55, 'Simulasi CAT Sesi September Masif Regional VIII', 10, 1, 1, 3, 600, '2026-09-22', '2026-09-24', 'Selesai', 'https://drive.google.com/sample_sept_55', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(56, 'Lokakarya Penerapan KDKMP dan KNMP', 11, 2, 46, 12, 95, '2026-09-25', '2026-09-25', 'Selesai', 'https://drive.google.com/sample_sept_56', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(57, 'Ujian Penyesuaian Ijazah ASN Barito Timur', 1, 5, 22, 9, 70, '2026-09-26', '2026-09-26', 'Selesai', 'https://drive.google.com/sample_sept_57', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(58, 'Pelaksanaan SKD CPNS Kota Banjarbaru', 2, 1, 16, 2, 380, '2026-09-28', '2026-09-29', 'Selesai', 'https://drive.google.com/sample_sept_58', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(59, 'Fasilitasi PPPK Kesehatan Kabupaten Pulang Pisau', 4, 5, 31, 9, 170, '2026-09-30', '2026-09-30', 'Selesai', 'https://drive.google.com/sample_sept_59', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(60, 'Seleksi Tenaga Teknis BLUD RSUD Pemkab Banjar', 7, 3, 6, 5, 200, '2026-09-30', '2026-09-30', 'Selesai', 'https://drive.google.com/sample_sept_60', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(61, 'Ujian Dinas Tingkat I & II Pemko Banjarbaru', 1, 1, 16, 1, 105, '2026-10-01', '2026-10-02', 'Selesai', 'https://drive.google.com/sample_okt_61', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(62, 'Pelaksanaan SKD CPNS Kabupaten Banjar', 2, 3, 6, 2, 510, '2026-10-03', '2026-10-05', 'Selesai', 'https://drive.google.com/sample_okt_62', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(63, 'Seleksi SKB CPNS Berbasis CAT Kanreg VIII', 3, 1, 1, 4, 190, '2026-10-06', '2026-10-07', 'Selesai', 'https://drive.google.com/sample_okt_63', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(64, 'Fasilitasi PPPK Jabatan Fungsional Guru Kalsel', 4, 1, 2, 3, 420, '2026-10-08', '2026-10-10', 'Selesai', 'https://drive.google.com/sample_okt_64', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(65, 'Seleksi SKD Sekolah Kedinasan Poltekip Kalsel', 5, 1, 4, 6, 280, '2026-10-12', '2026-10-13', 'Selesai', 'https://drive.google.com/sample_okt_65', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(66, 'Seleksi Lanjutan Pantukhir Sekolah Kedinasan', 6, 2, 5, 10, 90, '2026-10-14', '2026-10-14', 'Selesai', 'https://drive.google.com/sample_okt_66', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(67, 'Seleksi Non-ASN Tenaga Administrasi BKD Kalsel', 7, 4, 2, 5, 160, '2026-10-15', '2026-10-16', 'Selesai', 'https://drive.google.com/sample_okt_67', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(68, 'Uji Kompetensi Mutasi Jalur Pegawai Daerah', 8, 2, 1, 12, 75, '2026-10-17', '2026-10-17', 'Selesai', 'https://drive.google.com/sample_okt_68', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(69, 'Sertifikasi CAT Tim Pengawas Ujian Regional', 9, 1, 1, 11, 50, '2026-10-19', '2026-10-19', 'Selesai', 'https://drive.google.com/sample_okt_69', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(70, 'Simulasi CAT Pemetaan Kompetensi Sekolah Kedinasan', 10, 1, 1, 3, 380, '2026-10-20', '2026-10-21', 'Selesai', 'https://drive.google.com/sample_okt_70', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(71, 'Bimtek KDKMP dan KNMP Tahap Akhir', 11, 2, 1, 4, 85, '2026-10-22', '2026-10-23', 'Terkonfirmasi', 'https://drive.google.com/sample_okt_71', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(72, 'Ujian UPKP Penyesuaian Ijazah Pemkab Tanah Laut', 1, 1, 7, 1, 95, '2026-10-24', '2026-10-25', 'Terkonfirmasi', 'https://drive.google.com/sample_okt_72', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(73, 'Seleksi SKD CPNS Kabupaten Barito Utara', 2, 5, 21, 9, 340, '2026-10-26', '2026-10-28', 'Terkonfirmasi', 'https://drive.google.com/sample_okt_73', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(74, 'Seleksi SKB CPNS Wawancara Pemkot Balikpapan', 3, 6, 34, 12, 130, '2026-10-29', '2026-10-30', 'Terkonfirmasi', 'https://drive.google.com/sample_okt_74', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(75, 'Seleksi Tenaga Pengatur Lalu Lintas Jalan (Non-ASN)', 7, 3, 16, 5, 110, '2026-10-31', '2026-10-31', 'Terkonfirmasi', 'https://drive.google.com/sample_okt_75', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(76, 'Ujian Dinas Tingkat I & II Pemkab Tapin', 1, 1, 9, 1, 90, '2026-11-02', '2026-11-03', 'Selesai', 'https://drive.google.com/sample_nov_76', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(77, 'Seleksi SKD CPNS Kabupaten Kotabaru', 2, 1, 15, 2, 480, '2026-11-04', '2026-11-06', 'Selesai', 'https://drive.google.com/sample_nov_77', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(78, 'Seleksi SKB CPNS Jabatan Fungsional Kesehatan', 3, 2, 2, 4, 160, '2026-11-07', '2026-11-08', 'Selesai', 'https://drive.google.com/sample_nov_78', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(79, 'Fasilitasi PPPK Tenaga Teknis Pemkot Samarinda', 4, 6, 33, 12, 330, '2026-11-09', '2026-11-11', 'Selesai', 'https://drive.google.com/sample_nov_79', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(80, 'Simulasi CAT Mandiri Persiapan Seleksi CASN 2027', 10, 1, 1, 3, 550, '2026-11-12', '2026-11-13', 'Selesai', 'https://drive.google.com/sample_nov_80', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(81, 'Seleksi SKD Sekolah Kedinasan Kementerian UPT Tarakan', 5, 5, 43, 9, 210, '2026-11-14', '2026-11-15', 'Terkonfirmasi', 'https://drive.google.com/sample_nov_81', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(82, 'Seleksi Lanjutan Wawancara Sekolah Kedinasan', 6, 2, 5, 10, 80, '2026-11-16', '2026-11-16', 'Terkonfirmasi', 'https://drive.google.com/sample_nov_82', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(83, 'Seleksi Non-ASN Tenaga Kebersihan Lingkungan Hidup', 7, 3, 3, 5, 140, '2026-11-17', '2026-11-17', 'Terkonfirmasi', 'https://drive.google.com/sample_nov_83', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(84, 'Uji Kompetensi Kenaikan Pangkat Pilihan Periode November', 8, 1, 1, 12, 110, '2026-11-18', '2026-11-19', 'Terkonfirmasi', 'https://drive.google.com/sample_nov_84', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(85, 'Sertifikasi Asesor Kompetensi Pegawai BKN', 9, 2, 1, 10, 30, '2026-11-20', '2026-11-20', 'Terkonfirmasi', 'https://drive.google.com/sample_nov_85', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(86, 'Monev Penerapan KDKMP dan KNMP', 11, 2, 1, 4, 65, '2026-11-21', '2026-11-21', 'Terkonfirmasi', 'https://drive.google.com/sample_nov_86', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(87, 'Ujian UPKP Penyesuaian Ijazah Pemkab Murung Raya', 1, 5, 30, 9, 50, '2026-11-23', '2026-11-23', 'Terkonfirmasi', 'https://drive.google.com/sample_nov_87', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(88, 'Pelaksanaan SKD CPNS Kabupaten Berau', 2, 6, 39, 12, 390, '2026-11-24', '2026-11-26', 'Terkonfirmasi', 'https://drive.google.com/sample_nov_88', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(89, 'Fasilitasi PPPK Tenaga Teknis Hulu Sungai Tengah', 4, 1, 11, 3, 200, '2026-11-27', '2026-11-28', 'Terkonfirmasi', 'https://drive.google.com/sample_nov_89', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(90, 'Seleksi Pegawai BLUD Puskesmas Se-Banjarbaru', 7, 3, 16, 5, 180, '2026-11-30', '2026-11-30', 'Terkonfirmasi', 'https://drive.google.com/sample_nov_90', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(91, 'Ujian Dinas Tingkat I & II Akhir Tahun Kanreg VIII', 1, 1, 1, 1, 130, '2026-12-01', '2026-12-02', 'Terkonfirmasi', 'https://drive.google.com/sample_des_91', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(92, 'Pelaksanaan SKD CPNS Kabupaten Penajam Paser Utara', 2, 6, 40, 12, 420, '2026-12-03', '2026-12-05', 'Terkonfirmasi', 'https://drive.google.com/sample_des_92', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(93, 'Seleksi SKB CPNS Pemeta Kepegawaian', 3, 2, 1, 4, 110, '2026-12-07', '2026-12-08', 'Terkonfirmasi', 'https://drive.google.com/sample_des_93', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(94, 'Fasilitasi PPPK Tahap Akhir Pemprov Kalsel', 4, 1, 2, 3, 500, '2026-12-09', '2026-12-11', 'Terkonfirmasi', 'https://drive.google.com/sample_des_94', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(95, 'Simulasi CAT Massal Persiapan Sekolah Kedinasan 2027', 10, 1, 1, 11, 600, '2026-12-12', '2026-12-14', 'Terkonfirmasi', 'https://drive.google.com/sample_des_95', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(96, 'Asesmen Profil Kompetensi Pejabat Pratama Kalsel', 8, 2, 2, 10, 45, '2026-12-15', '2026-12-16', 'Terkonfirmasi', 'https://drive.google.com/sample_des_96', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(97, 'Seleksi SKD Sekolah Kedinasan Jalur Khusus', 5, 1, 5, 2, 200, '2026-12-17', '2026-12-18', 'Belum Konfirmasi', 'https://drive.google.com/sample_des_97', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(98, 'Seleksi Lanjutan Wawancara Pemetaan Karier', 6, 2, 1, 10, 70, '2026-12-19', '2026-12-19', 'Belum Konfirmasi', 'https://drive.google.com/sample_des_98', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(99, 'Seleksi Non-ASN Tenaga Pengawas Lapangan', 7, 4, 2, 5, 120, '2026-12-21', '2026-12-21', 'Belum Konfirmasi', 'https://drive.google.com/sample_des_99', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(100, 'Sertifikasi Tim Layanan SIASN Regional', 9, 2, 1, 12, 40, '2026-12-22', '2026-12-22', 'Belum Konfirmasi', 'https://drive.google.com/sample_des_100', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(101, 'Rapat Koordinasi Evaluasi KDKMP dan KNMP 2026', 11, 2, 46, 4, 100, '2026-12-23', '2026-12-23', 'Belum Konfirmasi', 'https://drive.google.com/sample_des_101', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(102, 'Ujian UPKP Penyesuaian S1/S2 Pegawai Pemko Banjarbaru', 1, 3, 16, 1, 85, '2026-12-24', '2026-12-24', 'Belum Konfirmasi', 'https://drive.google.com/sample_des_102', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(103, 'Pelaksanaan SKD CPNS Kabupaten Mahakam Ulu', 2, 6, 41, 12, 280, '2026-12-28', '2026-12-29', 'Belum Konfirmasi', 'https://drive.google.com/sample_des_103', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(104, 'Seleksi PPPK Tenaga Teknis Kabupaten Katingan', 4, 5, 25, 9, 150, '2026-12-30', '2026-12-30', 'Belum Konfirmasi', 'https://drive.google.com/sample_des_104', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(105, 'Seleksi Pegawai Non-ASN Pengelola Sistem SIASN', 7, 1, 1, 6, 90, '2026-12-30', '2026-12-30', 'Belum Konfirmasi', 'https://drive.google.com/sample_des_105', '2026-10-05 05:58:48', '2026-10-05 05:58:48'),
(106, 'Uji Kompetensi Manajerial Pegawai Pemko Banjarmasin', 8, 1, 3, 1, 80, '2026-06-04', '2026-06-05', 'Selesai', 'https://drive.google.com/sample_juni_106', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(107, 'Fasilitasi CAT PPPK Tenaga Teknis Kabupaten Banjar', 4, 3, 6, 2, 210, '2026-06-07', '2026-06-08', 'Selesai', 'https://drive.google.com/sample_juni_107', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(108, 'Sosialisasi Sistem Informasi SIASN Kanreg VIII', 11, 2, 1, 3, 95, '2026-06-09', '2026-06-09', 'Selesai', 'https://drive.google.com/sample_juni_108', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(109, 'Simulasi CAT Mandiri SMA/SMK Banjarmasin', 10, 1, 3, 11, 320, '2026-06-13', '2026-06-14', 'Selesai', 'https://drive.google.com/sample_juni_109', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(110, 'Seleksi Non-ASN Pegawai RSUD Ansari Saleh', 7, 4, 2, 5, 150, '2026-06-15', '2026-06-16', 'Selesai', 'https://drive.google.com/sample_juni_110', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(111, 'Asesmen Profil Pegawai Dinas Pendidikan Kalsel', 8, 2, 2, 10, 65, '2026-06-18', '2026-06-18', 'Selesai', 'https://drive.google.com/sample_juni_111', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(112, 'Sertifikasi CAT Petugas Pengawas Ujian Sub-Regional', 9, 1, 1, 12, 40, '2026-06-21', '2026-06-21', 'Selesai', 'https://drive.google.com/sample_juni_112', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(113, 'Ujian Penyesuaian Ijazah ASN Kabupaten Tapin', 1, 1, 9, 4, 85, '2026-06-23', '2026-06-24', 'Selesai', 'https://drive.google.com/sample_juni_113', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(114, 'Seleksi SKD Sekolah Kedinasan STTD / STIP', 5, 1, 5, 6, 280, '2026-06-26', '2026-06-27', 'Selesai', 'https://drive.google.com/sample_juni_114', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(115, 'Evaluasi Kinerja Fasilitator CAT Triwulan I', 11, 2, 1, 1, 50, '2026-06-29', '2026-06-29', 'Selesai', 'https://drive.google.com/sample_juni_115', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(116, 'Ujian Dinas Tingkat II ASN Pemkab Tanah Laut', 1, 1, 7, 1, 100, '2026-07-04', '2026-07-05', 'Selesai', 'https://drive.google.com/sample_juli_116', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(117, 'Seleksi SKD CPNS Kabupaten Barito Kuala', 2, 3, 8, 2, 450, '2026-07-06', '2026-07-08', 'Selesai', 'https://drive.google.com/sample_juli_117', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(118, 'Fasilitasi PPPK Kesehatan Pemko Banjarbaru', 4, 1, 16, 4, 180, '2026-07-10', '2026-07-11', 'Selesai', 'https://drive.google.com/sample_juli_118', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(119, 'Simulasi CAT Mandiri Persiapan Sekolah Kedinasan', 10, 1, 1, 3, 400, '2026-07-12', '2026-07-13', 'Selesai', 'https://drive.google.com/sample_juli_119', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(120, 'Seleksi Pamong Desa Kabupaten Tanah Bumbu', 7, 1, 14, 5, 120, '2026-07-15', '2026-07-15', 'Selesai', 'https://drive.google.com/sample_juli_120', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(121, 'Uji Kompetensi Mutasi ASN Antar-Instansi Kalsel', 8, 2, 2, 12, 70, '2026-07-18', '2026-07-18', 'Selesai', 'https://drive.google.com/sample_juli_121', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(122, 'Seleksi Lanjutan Tes Psikotes Kedinasan STIN', 6, 2, 1, 10, 95, '2026-07-20', '2026-07-21', 'Selesai', 'https://drive.google.com/sample_juli_122', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(123, 'Sertifikasi Operator Server CAT Regional VIII', 9, 1, 1, 11, 30, '2026-07-23', '2026-07-23', 'Selesai', 'https://drive.google.com/sample_juli_23', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(124, 'Lokakarya Implementasi KDKMP Pemkab Kotabaru', 11, 2, 15, 4, 75, '2026-07-26', '2026-07-26', 'Selesai', 'https://drive.google.com/sample_juli_124', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(125, 'Ujian UPKP Penyesuaian S1/S2 BKN Regional', 1, 1, 1, 3, 55, '2026-07-29', '2026-07-29', 'Selesai', 'https://drive.google.com/sample_juli_125', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(126, 'Ujian Dinas Tingkat I & II Pemkab Tabalong', 1, 1, 13, 1, 110, '2026-08-02', '2026-08-03', 'Selesai', 'https://drive.google.com/sample_agust_126', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(127, 'Pelaksanaan SKD CPNS Kabupaten Hulu Sungai Tengah', 2, 1, 11, 2, 420, '2026-08-06', '2026-08-08', 'Selesai', 'https://drive.google.com/sample_agust_127', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(128, 'Seleksi SKB CPNS Psikotes & Wawancara Pemkalteng', 3, 5, 17, 9, 160, '2026-08-10', '2026-08-11', 'Selesai', 'https://drive.google.com/sample_agust_128', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(129, 'Fasilitasi PPPK Tenaga Guru Pemkab Hulu Sungai Utara', 4, 1, 12, 3, 230, '2026-08-13', '2026-08-14', 'Selesai', 'https://drive.google.com/sample_agust_129', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(130, 'Seleksi SKD Sekolah Kedinasan Poltekip/Poltekim Kalsel', 5, 4, 4, 6, 260, '2026-08-16', '2026-08-17', 'Selesai', 'https://drive.google.com/sample_agust_130', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(131, 'Seleksi Non-ASN Petugas Kebersihan & Keamanan BKN', 7, 1, 1, 5, 80, '2026-08-19', '2026-08-19', 'Selesai', 'https://drive.google.com/sample_agust_131', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(132, 'Uji Kompetensi Asesor Pemetaan Profil Kalimantan', 8, 2, 1, 10, 45, '2026-08-22', '2026-08-22', 'Selesai', 'https://drive.google.com/sample_agust_132', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(133, 'Sertifikasi Keahlian Pengelola Komputer CAT', 9, 1, 1, 11, 35, '2026-08-24', '2026-08-24', 'Selesai', 'https://drive.google.com/sample_agust_133', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(134, 'Simulasi CAT Massal Sambut Hari Kemerdekaan', 10, 3, 16, 4, 520, '2026-08-26', '2026-08-27', 'Selesai', 'https://drive.google.com/sample_agust_134', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(135, 'Bimtek Penerapan KNMP Aparatur Daerah', 11, 2, 2, 12, 90, '2026-08-29', '2026-08-30', 'Selesai', 'https://drive.google.com/sample_agust_135', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(136, 'Ujian e-UDIN Elektronik Pegawai Pemprov Kalsel', 1, 1, 2, 1, 140, '2026-09-02', '2026-09-03', 'Selesai', 'https://drive.google.com/sample_sept_136', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(137, 'Pelaksanaan SKD CPNS Kabupaten Paser', 2, 6, 36, 12, 380, '2026-09-05', '2026-09-07', 'Selesai', 'https://drive.google.com/sample_sept_137', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(138, 'Seleksi SKB CPNS Praktik Kerja Jabatan Komputer', 3, 2, 1, 6, 110, '2026-09-09', '2026-09-10', 'Selesai', 'https://drive.google.com/sample_sept_138', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(139, 'CAT PPPK Tenaga Teknis Pemkot Balikpapan', 4, 6, 34, 1, 300, '2026-09-12', '2026-09-14', 'Selesai', 'https://drive.google.com/sample_sept_139', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(140, 'Seleksi Lanjutan Kesamaptaan Kedinasan IPDN', 6, 3, 5, 2, 170, '2026-09-16', '2026-09-17', 'Selesai', 'https://drive.google.com/sample_sept_140', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(141, 'Fasilitasi CAT Non-ASN BLUD RSUD Pemkab Banjar', 7, 3, 6, 5, 190, '2026-09-18', '2026-09-19', 'Selesai', 'https://drive.google.com/sample_sept_141', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(142, 'Asesmen Talent Pool Pejabat Pengawas Regional', 8, 2, 1, 10, 80, '2026-09-21', '2026-09-22', 'Selesai', 'https://drive.google.com/sample_sept_142', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(143, 'Sertifikasi CAT Tim Fasilitator UPT Palangkaraya', 9, 5, 17, 9, 40, '2026-09-24', '2026-09-24', 'Selesai', 'https://drive.google.com/sample_sept_143', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(144, 'Simulasi CAT Persiapan Seleksi CASN Pemkab Tapin', 10, 1, 9, 3, 360, '2026-09-26', '2026-09-27', 'Selesai', 'https://drive.google.com/sample_sept_144', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(145, 'Monev Capaian KDKMP dan KNMP Triwulan III', 11, 2, 1, 4, 60, '2026-09-29', '2026-09-29', 'Selesai', 'https://drive.google.com/sample_sept_145', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(146, 'Ujian Dinas Tingkat I Pemkot Palangkaraya', 1, 5, 18, 9, 90, '2026-10-01', '2026-10-02', 'Selesai', 'https://drive.google.com/sample_okt_146', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(147, 'Pelaksanaan SKD CPNS Kabupaten Kutai Kartanegara', 2, 6, 35, 12, 550, '2026-10-03', '2026-10-05', 'Selesai', 'https://drive.google.com/sample_okt_147', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(148, 'Seleksi SKB CPNS CAT Jabatan Keuangan Kalsel', 3, 1, 2, 4, 130, '2026-10-07', '2026-10-08', 'Selesai', 'https://drive.google.com/sample_okt_148', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(149, 'Fasilitasi PPPK Guru Kabupaten Tanah Laut', 4, 1, 7, 2, 310, '2026-10-10', '2026-10-12', 'Selesai', 'https://drive.google.com/sample_okt_149', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(150, 'Seleksi SKD Sekolah Kedinasan STIS Regional', 5, 1, 1, 1, 240, '2026-10-13', '2026-10-14', 'Selesai', 'https://drive.google.com/sample_okt_150', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(151, 'Seleksi Tenaga Pendukung SIASN Kanreg VIII', 7, 2, 1, 5, 100, '2026-10-16', '2026-10-16', 'Selesai', 'https://drive.google.com/sample_okt_151', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(152, 'Uji Kompetensi Kenaikan Pangkat Utama Kalsel', 8, 2, 2, 10, 65, '2026-10-18', '2026-10-18', 'Selesai', 'https://drive.google.com/sample_okt_152', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(153, 'Sertifikasi Asesor Pemetaan Profil ASN Kalteng', 9, 5, 17, 9, 35, '2026-10-20', '2026-10-20', 'Selesai', 'https://drive.google.com/sample_okt_153', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(154, 'Simulasi CAT Terpadu Mahasiswa & Umum Banjarbaru', 10, 3, 16, 3, 480, '2026-10-22', '2026-10-23', 'Selesai', 'https://drive.google.com/sample_okt_154', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(155, 'Ujian UPKP Penyesuaian Ijazah Barito Utara', 1, 5, 21, 9, 70, '2026-10-25', '2026-10-25', 'Selesai', 'https://drive.google.com/sample_okt_155', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(156, 'Ujian Dinas Tingkat II Pemkab Barito Selatan', 1, 5, 20, 9, 85, '2026-11-01', '2026-11-02', 'Selesai', 'https://drive.google.com/sample_nov_156', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(157, 'Pelaksanaan SKD CPNS Kabupaten Nunukan', 2, 5, 45, 12, 340, '2026-11-03', '2026-11-05', 'Selesai', 'https://drive.google.com/sample_nov_157', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(158, 'Seleksi SKB CPNS Wawancara Pemkot Banjarmasin', 3, 1, 3, 4, 120, '2026-11-06', '2026-11-07', 'Selesai', 'https://drive.google.com/sample_nov_158', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(159, 'Fasilitasi PPPK Tenaga Teknis Kabupaten Kapuas', 4, 5, 19, 9, 290, '2026-11-09', '2026-11-11', 'Selesai', 'https://drive.google.com/sample_nov_159', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(160, 'Simulasi CAT Persiapan Seleksi CASN 2027 Kaltim', 10, 6, 32, 1, 500, '2026-11-12', '2026-11-13', 'Selesai', 'https://drive.google.com/sample_nov_160', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(161, 'Seleksi Lanjutan Pantukhir Kedinasan STTD', 6, 2, 5, 10, 75, '2026-11-15', '2026-11-15', 'Terkonfirmasi', 'https://drive.google.com/sample_nov_161', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(162, 'Seleksi Non-ASN Pengelola Data SIASN Daerah', 7, 1, 1, 5, 110, '2026-11-17', '2026-11-17', 'Terkonfirmasi', 'https://drive.google.com/sample_nov_162', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(163, 'Uji Kompetensi Mutasi Jabatan Fungsional BKN', 8, 2, 1, 12, 80, '2026-11-19', '2026-11-20', 'Terkonfirmasi', 'https://drive.google.com/sample_nov_163', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(164, 'Sertifikasi Operator Server CAT Kalimantan Utara', 9, 5, 42, 9, 30, '2026-11-22', '2026-11-22', 'Terkonfirmasi', 'https://drive.google.com/sample_nov_164', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(165, 'Rapat Evaluasi KDKMP Triwulan Akhir 2026', 11, 2, 1, 4, 90, '2026-11-25', '2026-11-25', 'Terkonfirmasi', 'https://drive.google.com/sample_nov_165', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(166, 'Ujian e-UDIN Akhir Tahun ASN Kanreg VIII BKN', 1, 1, 1, 1, 120, '2026-12-01', '2026-12-02', 'Selesai', 'https://drive.google.com/sample_des_166', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(167, 'Pelaksanaan SKD CPNS Kabupaten Kutai Timur', 2, 6, 37, 12, 410, '2026-12-03', '2026-12-05', 'Selesai', 'https://drive.google.com/sample_des_167', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(168, 'Seleksi SKB CPNS CAT Jabatan Analis Kepegawaian', 3, 2, 1, 4, 150, '2026-12-07', '2026-12-08', 'Selesai', 'https://drive.google.com/sample_des_168', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(169, 'Fasilitasi PPPK Tahap Akhir Pemko Banjarbaru', 4, 3, 16, 2, 380, '2026-12-09', '2026-12-11', 'Selesai', 'https://drive.google.com/sample_des_169', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(170, 'Simulasi CAT Akhir Tahun Bagi Masyarakat Umum', 10, 1, 1, 11, 650, '2026-12-12', '2026-12-14', 'Selesai', 'https://drive.google.com/sample_des_170', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(171, 'Asesmen Profil Kompetensi Pejabat Administrator Kaltim', 8, 6, 32, 10, 50, '2026-12-16', '2026-12-17', 'Terkonfirmasi', 'https://drive.google.com/sample_des_171', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(172, 'Seleksi Lanjutan Wawancara Pemetaan Karier Regional', 6, 2, 1, 3, 65, '2026-12-19', '2026-12-19', 'Terkonfirmasi', 'https://drive.google.com/sample_des_172', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(173, 'Seleksi Non-ASN Tenaga IT Helpdesk SIASN', 7, 1, 1, 6, 85, '2026-12-21', '2026-12-21', 'Terkonfirmasi', 'https://drive.google.com/sample_des_173', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(174, 'Sertifikasi Tim Pengawas Ujian CAT 2027', 9, 2, 1, 12, 45, '2026-12-23', '2026-12-23', 'Terkonfirmasi', 'https://drive.google.com/sample_des_174', '2026-10-06 03:20:33', '2026-10-06 03:20:33'),
(175, 'Ujian UPKP Penyesuaian Ijazah Pemkab Banjar', 1, 3, 6, 1, 90, '2026-12-27', '2026-12-28', 'Terkonfirmasi', 'https://drive.google.com/sample_des_175', '2026-10-06 03:20:33', '2026-10-06 03:20:33');

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
(1, 1, 115, 5, 480.00, 310.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_001/view', 'Ujian Dinas Tingkat I berjalan lancar tanpa kendala teknis.', '2026-06-03 09:00:00', '2026-10-05 06:06:24'),
(2, 2, 80, 5, 475.50, 305.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_002/view', 'UPKP BKN terlaksana dengan baik, seluruh berkas tervalidasi.', '2026-06-04 09:00:00', '2026-10-05 06:06:24'),
(3, 3, 290, 10, 492.50, 270.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_003/view', 'Simulasi CAT Mandiri diminati peserta, infrastruktur berfungsi baik.', '2026-06-06 09:00:00', '2026-10-05 06:06:24'),
(4, 4, 240, 10, 485.00, 290.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_004/view', 'Fasilitasi PPPK Guru Pemko Banjarbaru selesai tepat waktu.', '2026-06-10 09:00:00', '2026-10-05 06:06:24'),
(5, 5, 58, 2, 92.00, 75.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_005/view', 'Asesmen KDKMP dan KNMP berjalan tertib.', '2026-06-11 09:00:00', '2026-10-05 06:06:24'),
(6, 6, 388, 12, 495.00, 305.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_006/view', 'Seleksi SKD Kedinasan IPDN berjalan ketat dan aman.', '2026-06-14 09:00:00', '2026-10-05 06:06:24'),
(7, 7, 85, 5, 468.00, 312.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_007/view', 'Uji Kompetensi Jabatan Fungsional terlaksana sesuai prosedur.', '2026-06-16 09:00:00', '2026-10-05 06:06:24'),
(8, 8, 175, 5, 482.00, 298.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_008/view', 'Seleksi Lanjutan Kedinasan Poltekip aman dan kondusif.', '2026-06-18 09:00:00', '2026-10-05 06:06:24'),
(9, 9, 210, 10, 460.50, 280.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_009/view', 'CAT Non-ASN BLUD RSUD Ulin berjalan lancar.', '2026-06-20 09:00:00', '2026-10-05 06:06:24'),
(10, 10, 45, 0, 95.00, 80.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_010/view', 'Sertifikasi CAT Petugas Fasilitator lulus 100%.', '2026-06-22 09:00:00', '2026-10-05 06:06:24'),
(11, 11, 340, 10, 489.00, 275.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_011/view', 'Simulasi CAT Terpadu Banjar selesai dalam 3 sesi.', '2026-06-24 09:00:00', '2026-10-05 06:06:24'),
(12, 12, 182, 8, 478.00, 290.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_012/view', 'Seleksi PPPK Nakes Tanah Laut terlaksana sesuai jadwal.', '2026-06-26 09:00:00', '2026-10-05 06:06:24'),
(13, 13, 485, 15, 496.00, 282.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_013/view', 'SKD CPNS Kemenkumham Kalsel berjalan kondusif.', '2026-06-29 09:00:00', '2026-10-05 06:06:24'),
(14, 14, 40, 0, 90.00, 78.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_014/view', 'Seleksi Beasiswa S2 Layanan Kepegawaian selesai lancar.', '2026-06-30 09:00:00', '2026-10-05 06:06:24'),
(15, 15, 125, 5, 455.00, 300.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_015/view', 'Seleksi Perangkat Desa Barito Kuala terlaksana tertib.', '2026-06-30 09:00:00', '2026-10-05 06:06:24'),
(16, 16, 108, 2, 475.00, 295.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_016/view', 'Ujian e-UDIN Banjarmasin sukses dilaksanakan.', '2026-07-03 09:00:00', '2026-10-05 06:06:24'),
(17, 17, 410, 10, 488.00, 280.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_017/view', 'SKD CPNS Tapin berjalan lancar selama 3 hari.', '2026-07-07 09:00:00', '2026-10-05 06:06:24'),
(18, 18, 146, 4, 490.00, 310.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_018/view', 'SKB CPNS Pemprov Kalsel terlaksana tepat waktu.', '2026-07-09 09:00:00', '2026-10-05 06:06:24'),
(19, 19, 202, 8, 472.00, 288.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_019/view', 'Seleksi PPPK Teknis Barito Kuala berjalan lancar.', '2026-07-11 09:00:00', '2026-10-05 06:06:24'),
(20, 20, 301, 9, 494.00, 302.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_020/view', 'SKD Sekolah Kedinasan STIN & STIS kondusif.', '2026-07-15 09:00:00', '2026-10-05 06:06:24'),
(21, 21, 138, 2, 88.00, 72.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_021/view', 'Psikotes Kedinasan IPDN terlaksana tertib.', '2026-07-17 09:00:00', '2026-10-05 06:06:24'),
(22, 22, 170, 5, 462.00, 290.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_022/view', 'Seleksi BLUD RSUD Ansari Saleh lancar.', '2026-07-19 09:00:00', '2026-10-05 06:06:24'),
(23, 23, 92, 3, 479.00, 308.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_023/view', 'Uji Kompetensi Kenaikan Pangkat selesai aman.', '2026-07-21 09:00:00', '2026-10-05 06:06:24'),
(24, 24, 35, 0, 96.00, 82.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_024/view', 'Sertifikasi Keahlian Pengelola CAT BKN sukses.', '2026-07-22 09:00:00', '2026-10-05 06:06:24'),
(25, 25, 435, 15, 482.00, 260.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_025/view', 'Simulasi CAT Pelajar Banjarbaru ramai dan lancar.', '2026-07-24 09:00:00', '2026-10-05 06:06:24'),
(26, 26, 78, 2, 91.00, 76.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_026/view', 'Sosialisasi KDKMP dan KNMP berjalan baik.', '2026-07-25 09:00:00', '2026-10-05 06:06:24'),
(27, 27, 58, 2, 471.00, 302.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_027/view', 'UPKP Kanreg VIII BKN selesai 1 hari.', '2026-07-27 09:00:00', '2026-10-05 06:06:24'),
(28, 28, 372, 8, 487.00, 283.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_028/view', 'SKD CPNS Hulu Sungai Selatan lancar.', '2026-07-30 09:00:00', '2026-10-05 06:06:24'),
(29, 29, 73, 2, 94.00, 80.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_029/view', 'SKB Praktik Komputer PPPK sukses.', '2026-07-31 09:00:00', '2026-10-05 06:06:24'),
(30, 30, 155, 5, 458.00, 292.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_030/view', 'Seleksi Pendamping Desa HST terlaksana.', '2026-07-31 09:00:00', '2026-10-05 06:06:24'),
(31, 31, 92, 3, 465.00, 300.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_031/view', 'Ujian Dinas Tanah Bumbu berlangsung tertib.', '2026-08-04 09:00:00', '2026-10-05 06:06:24'),
(32, 32, 580, 20, 490.00, 285.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_032/view', 'Pelaksanaan SKD CPNS Kalteng sukses terfasilitasi.', '2026-08-08 09:00:00', '2026-10-05 06:06:24'),
(33, 33, 175, 5, 488.00, 305.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_033/view', 'SKB CPNS Palangkaraya selesai aman.', '2026-08-11 09:00:00', '2026-10-05 06:06:24'),
(34, 34, 282, 8, 476.00, 290.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_034/view', 'PPPK Guru Kotabaru terlaksana lancar.', '2026-08-14 09:00:00', '2026-10-05 06:06:24'),
(35, 35, 225, 5, 491.00, 298.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_035/view', 'SKD Poltekip Kalteng aman.', '2026-08-16 09:00:00', '2026-10-05 06:06:24'),
(36, 36, 108, 2, 89.00, 74.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_036/view', 'Tes Kesehatan Kedinasan terlaksana tertib.', '2026-08-19 09:00:00', '2026-10-05 06:06:24'),
(37, 37, 136, 4, 460.00, 285.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_037/view', 'Seleksi Non-ASN Keuangan Kalsel lancar.', '2026-08-20 09:00:00', '2026-10-05 06:06:24'),
(38, 38, 49, 1, 93.00, 81.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_038/view', 'Uji Kompetensi Asesor sukses.', '2026-08-22 09:00:00', '2026-10-05 06:06:24'),
(39, 39, 30, 0, 97.00, 85.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_039/view', 'Sertifikasi Operator Komputer CAT lulus semua.', '2026-08-24 09:00:00', '2026-10-05 06:06:24'),
(40, 40, 485, 15, 488.00, 270.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_040/view', 'Simulasi CAT HUT RI ramai lancar.', '2026-08-26 09:00:00', '2026-10-05 06:06:24'),
(41, 41, 68, 2, 90.00, 78.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_041/view', 'Evaluasi KDKMP & KNMP selesai.', '2026-08-27 09:00:00', '2026-10-05 06:06:24'),
(42, 42, 78, 2, 472.00, 301.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_042/view', 'UPKP Pegawai Daerah terlaksana.', '2026-08-28 09:00:00', '2026-10-05 06:06:24'),
(43, 43, 508, 12, 495.00, 288.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_043/view', 'SKD CPNS Samarinda kondusif.', '2026-08-30 09:00:00', '2026-10-05 06:06:24'),
(44, 44, 204, 6, 474.00, 292.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_044/view', 'PPPK Teknis Tabalong lancar.', '2026-08-31 09:00:00', '2026-10-05 06:06:24'),
(45, 45, 87, 3, 452.00, 290.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_045/view', 'Seleksi Pamong Desa Sukamara selesai.', '2026-08-31 09:00:00', '2026-10-05 06:06:24'),
(46, 46, 105, 5, 482.00, 312.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_046/view', 'Ujian Dinas Kanreg VIII berjalan kondusif.', '2026-09-02 09:00:00', '2026-10-05 06:06:24'),
(47, 47, 680, 20, 498.00, 290.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_047/view', 'SKD CPNS Kaltim terlaksana dengan kehadiran tinggi.', '2026-09-06 09:00:00', '2026-10-05 06:06:24'),
(48, 48, 116, 4, 489.00, 305.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_048/view', 'SKB CPNS Analis Hukum lancar.', '2026-09-08 09:00:00', '2026-10-05 06:06:24'),
(49, 49, 302, 8, 477.00, 289.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_049/view', 'CAT PPPK Balikpapan sukses.', '2026-09-11 09:00:00', '2026-10-05 06:06:24'),
(50, 50, 438, 12, 493.00, 300.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_050/view', 'SKD Kedinasan IPDN Kalbar-Kalsel aman.', '2026-09-14 09:00:00', '2026-10-05 06:06:24'),
(51, 51, 156, 4, 88.00, 75.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_051/view', 'Kesamaptaan Kedinasan tertib.', '2026-09-16 09:00:00', '2026-10-05 06:06:24'),
(52, 52, 126, 4, 462.00, 280.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_052/view', 'Seleksi Non-ASN BKN selesai.', '2026-09-17 09:00:00', '2026-10-05 06:06:24'),
(53, 53, 83, 2, 92.00, 80.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_053/view', 'Asesmen Talent Pool Administrator lancar.', '2026-09-19 09:00:00', '2026-10-05 06:06:24'),
(54, 54, 40, 0, 96.00, 84.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_054/view', 'Sertifikasi Asesor Pemetaan lulus.', '2026-09-21 09:00:00', '2026-10-05 06:06:24'),
(55, 55, 582, 18, 489.00, 275.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_055/view', 'Simulasi CAT September Masif sukses.', '2026-09-24 09:00:00', '2026-10-05 06:06:24'),
(56, 56, 92, 3, 91.00, 79.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_056/view', 'Lokakarya KDKMP dan KNMP berjalan lancar.', '2026-09-25 09:00:00', '2026-10-05 06:06:24'),
(57, 57, 68, 2, 470.00, 305.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_057/view', 'UPKP Barito Timur terlaksana.', '2026-09-26 09:00:00', '2026-10-05 06:06:24'),
(58, 58, 370, 10, 488.00, 282.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_058/view', 'SKD CPNS Banjarbaru selesai aman.', '2026-09-29 09:00:00', '2026-10-05 06:06:24'),
(59, 59, 164, 6, 471.00, 290.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_059/view', 'PPPK Kesehatan Pulang Pisau lancar.', '2026-09-30 09:00:00', '2026-10-05 06:06:24'),
(60, 60, 195, 5, 465.00, 285.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_060/view', 'BLUD RSUD Banjar selesai.', '2026-09-30 09:00:00', '2026-10-05 06:06:24'),
(61, 61, 100, 5, 478.00, 305.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_061/view', 'Ujian Dinas Banjarbaru terlaksana tepat waktu.', '2026-10-02 09:00:00', '2026-10-05 06:06:24'),
(62, 62, 495, 15, 491.00, 280.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_062/view', 'SKD CPNS Banjar selesai tanpa gangguan server.', '2026-10-05 09:00:00', '2026-10-05 06:06:24'),
(63, 63, 185, 5, 487.00, 302.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_063/view', 'SKB CPNS CAT Kanreg VIII berjalan tertib.', '2026-10-07 09:00:00', '2026-10-05 06:06:24'),
(64, 64, 410, 10, 480.00, 288.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_064/view', 'Fasilitasi PPPK Guru Kalsel lancar.', '2026-10-10 09:00:00', '2026-10-05 06:06:24'),
(65, 65, 272, 8, 493.00, 299.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_065/view', 'SKD Poltekip Kalsel selesai kondusif.', '2026-10-13 09:00:00', '2026-10-05 06:06:24'),
(66, 66, 88, 2, 90.00, 78.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_066/view', 'Pantukhir Kedinasan selesai.', '2026-10-14 09:00:00', '2026-10-05 06:06:24'),
(67, 67, 155, 5, 461.00, 284.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_067/view', 'Seleksi Non-ASN BKD Kalsel terlaksana.', '2026-10-16 09:00:00', '2026-10-05 06:06:24'),
(68, 68, 73, 2, 475.00, 300.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_068/view', 'Uji Kompetensi Mutasi selesai aman.', '2026-10-17 09:00:00', '2026-10-05 06:06:24'),
(69, 69, 50, 0, 95.00, 83.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_069/view', 'Sertifikasi Tim Pengawas Ujian sukses.', '2026-10-19 09:00:00', '2026-10-05 06:06:24'),
(70, 70, 370, 10, 485.00, 276.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_070/view', 'Simulasi CAT Kedinasan ramai lancar.', '2026-10-21 09:00:00', '2026-10-05 06:06:24'),
(71, 76, 88, 2, 470.00, 310.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_076/view', 'Ujian Dinas Tapin berjalan lancar.', '2026-11-03 09:00:00', '2026-10-05 06:06:24'),
(72, 77, 468, 12, 489.00, 281.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_077/view', 'SKD CPNS Kotabaru selesai tepat waktu.', '2026-11-06 09:00:00', '2026-10-05 06:06:24'),
(73, 78, 156, 4, 486.00, 301.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_078/view', 'SKB CPNS Nakes terlaksana baik.', '2026-11-08 09:00:00', '2026-10-05 06:06:24'),
(74, 79, 322, 8, 478.00, 290.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_079/view', 'PPPK Teknis Samarinda sukses.', '2026-11-11 09:00:00', '2026-10-05 06:06:24'),
(75, 80, 538, 12, 492.00, 275.00, 'https://drive.google.com/file/d/1BKN_LAPORAN_KEG_080/view', 'Simulasi CAT 2027 terlaksana meriah.', '2026-11-13 09:00:00', '2026-10-05 06:06:24'),
(76, 106, 78, 2, 91.50, 72.00, 'https://drive.google.com/file/d/1BKN_LAP_106/view', 'Uji Kompetensi berjalan lancar dan tertib.', '2026-06-05 09:00:00', '2026-10-06 03:20:33'),
(77, 107, 202, 8, 482.00, 290.00, 'https://drive.google.com/file/d/1BKN_LAP_107/view', 'Fasilitasi PPPK Teknis Banjar tepat waktu.', '2026-06-08 09:00:00', '2026-10-06 03:20:33'),
(78, 108, 92, 3, 90.00, 75.00, 'https://drive.google.com/file/d/1BKN_LAP_108/view', 'Sosialisasi SIASN dihadiri antusias peserta.', '2026-06-09 09:00:00', '2026-10-06 03:20:33'),
(79, 109, 310, 10, 488.00, 275.00, 'https://drive.google.com/file/d/1BKN_LAP_109/view', 'Simulasi CAT Banjarmasin berlangsung kondusif.', '2026-06-14 09:00:00', '2026-10-06 03:20:33'),
(80, 110, 145, 5, 460.00, 280.00, 'https://drive.google.com/file/d/1BKN_LAP_110/view', 'Seleksi Non-ASN RSUD Ansari Saleh tertib.', '2026-06-16 09:00:00', '2026-10-06 03:20:33'),
(81, 111, 62, 3, 94.00, 80.00, 'https://drive.google.com/file/d/1BKN_LAP_111/view', 'Asesmen Profil Pegawai terlaksana dengan baik.', '2026-06-18 09:00:00', '2026-10-06 03:20:33'),
(82, 112, 40, 0, 96.00, 82.00, 'https://drive.google.com/file/d/1BKN_LAP_112/view', 'Sertifikasi CAT Pengawas lulus 100%.', '2026-06-21 09:00:00', '2026-10-06 03:20:33'),
(83, 113, 82, 3, 470.00, 305.00, 'https://drive.google.com/file/d/1BKN_LAP_113/view', 'Ujian Penyesuaian Ijazah Tapin lancar.', '2026-06-24 09:00:00', '2026-10-06 03:20:33'),
(84, 114, 272, 8, 492.00, 298.00, 'https://drive.google.com/file/d/1BKN_LAP_114/view', 'SKD Kedinasan STTD selesai tepat waktu.', '2026-06-27 09:00:00', '2026-10-06 03:20:33'),
(85, 115, 48, 2, 88.00, 76.00, 'https://drive.google.com/file/d/1BKN_LAP_115/view', 'Evaluasi Kinerja Fasilitator selesai aman.', '2026-06-29 09:00:00', '2026-10-06 03:20:33'),
(86, 116, 96, 4, 475.00, 310.00, 'https://drive.google.com/file/d/1BKN_LAP_116/view', 'Ujian Dinas Tanah Laut tertib.', '2026-07-05 09:00:00', '2026-10-06 03:20:33'),
(87, 117, 438, 12, 489.00, 282.00, 'https://drive.google.com/file/d/1BKN_LAP_117/view', 'SKD CPNS Barito Kuala lancar.', '2026-07-08 09:00:00', '2026-10-06 03:20:33'),
(88, 118, 175, 5, 480.00, 295.00, 'https://drive.google.com/file/d/1BKN_LAP_118/view', 'PPPK Nakes Banjarbaru aman.', '2026-07-11 09:00:00', '2026-10-06 03:20:33'),
(89, 119, 390, 10, 495.00, 270.00, 'https://drive.google.com/file/d/1BKN_LAP_119/view', 'Simulasi CAT Sekolah Kedinasan ramai.', '2026-07-13 09:00:00', '2026-10-06 03:20:33'),
(90, 120, 115, 5, 458.00, 288.00, 'https://drive.google.com/file/d/1BKN_LAP_120/view', 'Seleksi Pamong Desa Tanah Bumbu selesai.', '2026-07-15 09:00:00', '2026-10-06 03:20:33'),
(91, 121, 68, 2, 92.00, 78.00, 'https://drive.google.com/file/d/1BKN_LAP_121/view', 'Uji Kompetensi Mutasi terlaksana.', '2026-07-18 09:00:00', '2026-10-06 03:20:33'),
(92, 122, 92, 3, 89.00, 74.00, 'https://drive.google.com/file/d/1BKN_LAP_122/view', 'Psikotes Kedinasan STIN lancar.', '2026-07-21 09:00:00', '2026-10-06 03:20:33'),
(93, 123, 30, 0, 98.00, 85.00, 'https://drive.google.com/file/d/1BKN_LAP_123/view', 'Sertifikasi Operator Server lulus semua.', '2026-07-23 09:00:00', '2026-10-06 03:20:33'),
(94, 124, 72, 3, 90.00, 77.00, 'https://drive.google.com/file/d/1BKN_LAP_124/view', 'Lokakarya KDKMP Kotabaru tertib.', '2026-07-26 09:00:00', '2026-10-06 03:20:33'),
(95, 125, 53, 2, 468.00, 300.00, 'https://drive.google.com/file/d/1BKN_LAP_125/view', 'UPKP BKN Regional selesai aman.', '2026-07-29 09:00:00', '2026-10-06 03:20:33'),
(96, 126, 106, 4, 472.00, 308.00, 'https://drive.google.com/file/d/1BKN_LAP_126/view', 'Ujian Dinas Tabalong kondusif.', '2026-08-03 09:00:00', '2026-10-06 03:20:33'),
(97, 127, 408, 12, 491.00, 280.00, 'https://drive.google.com/file/d/1BKN_LAP_127/view', 'SKD CPNS HST terlaksana lancar.', '2026-08-08 09:00:00', '2026-10-06 03:20:33'),
(98, 128, 155, 5, 486.00, 302.00, 'https://drive.google.com/file/d/1BKN_LAP_128/view', 'SKB CPNS Pemkalteng aman.', '2026-08-11 09:00:00', '2026-10-06 03:20:33'),
(99, 129, 222, 8, 476.00, 288.00, 'https://drive.google.com/file/d/1BKN_LAP_129/view', 'PPPK Guru HSU sukses.', '2026-08-14 09:00:00', '2026-10-06 03:20:33'),
(100, 130, 252, 8, 490.00, 296.00, 'https://drive.google.com/file/d/1BKN_LAP_130/view', 'SKD Kedinasan Poltekip Kalsel selesai.', '2026-08-17 09:00:00', '2026-10-06 03:20:33'),
(101, 131, 78, 2, 450.00, 282.00, 'https://drive.google.com/file/d/1BKN_LAP_131/view', 'Seleksi Non-ASN BKN tertib.', '2026-08-19 09:00:00', '2026-10-06 03:20:33'),
(102, 132, 44, 1, 95.00, 81.00, 'https://drive.google.com/file/d/1BKN_LAP_132/view', 'Uji Kompetensi Asesor sukses.', '2026-08-22 09:00:00', '2026-10-06 03:20:33'),
(103, 133, 35, 0, 97.00, 84.00, 'https://drive.google.com/file/d/1BKN_LAP_133/view', 'Sertifikasi Pengelola Komputer lulus 100%.', '2026-08-24 09:00:00', '2026-10-06 03:20:33'),
(104, 134, 505, 15, 489.00, 272.00, 'https://drive.google.com/file/d/1BKN_LAP_134/view', 'Simulasi CAT Kemerdekaan meriah.', '2026-08-27 09:00:00', '2026-10-06 03:20:33'),
(105, 135, 87, 3, 91.00, 79.00, 'https://drive.google.com/file/d/1BKN_LAP_135/view', 'Bimtek KNMP terlaksana.', '2026-08-30 09:00:00', '2026-10-06 03:20:33'),
(106, 136, 135, 5, 482.00, 315.00, 'https://drive.google.com/file/d/1BKN_LAP_136/view', 'Ujian e-UDIN Pemprov Kalsel kondusif.', '2026-09-03 09:00:00', '2026-10-06 03:20:33'),
(107, 137, 368, 12, 493.00, 285.00, 'https://drive.google.com/file/d/1BKN_LAP_137/view', 'SKD CPNS Paser tepat waktu.', '2026-09-07 09:00:00', '2026-10-06 03:20:33'),
(108, 138, 106, 4, 488.00, 305.00, 'https://drive.google.com/file/d/1BKN_LAP_138/view', 'SKB CPNS Komputer lancar.', '2026-09-10 09:00:00', '2026-10-06 03:20:33'),
(109, 139, 291, 9, 479.00, 288.00, 'https://drive.google.com/file/d/1BKN_LAP_139/view', 'PPPK Teknis Balikpapan sukses.', '2026-09-14 09:00:00', '2026-10-06 03:20:33'),
(110, 140, 165, 5, 88.00, 75.00, 'https://drive.google.com/file/d/1BKN_LAP_140/view', 'Kesamaptaan IPDN aman.', '2026-09-17 09:00:00', '2026-10-06 03:20:33'),
(111, 141, 182, 8, 465.00, 280.00, 'https://drive.google.com/file/d/1BKN_LAP_141/view', 'CAT BLUD RSUD Banjar selesai.', '2026-09-19 09:00:00', '2026-10-06 03:20:33'),
(112, 142, 78, 2, 93.00, 80.00, 'https://drive.google.com/file/d/1BKN_LAP_142/view', 'Asesmen Talent Pool Pengawas lancar.', '2026-09-22 09:00:00', '2026-10-06 03:20:33'),
(113, 143, 40, 0, 96.00, 82.00, 'https://drive.google.com/file/d/1BKN_LAP_143/view', 'Sertifikasi CAT UPT Palangkaraya lulus.', '2026-09-24 09:00:00', '2026-10-06 03:20:33'),
(114, 144, 350, 10, 485.00, 276.00, 'https://drive.google.com/file/d/1BKN_LAP_144/view', 'Simulasi CAT Tapin lancar.', '2026-09-27 09:00:00', '2026-10-06 03:20:33'),
(115, 145, 58, 2, 90.00, 78.00, 'https://drive.google.com/file/d/1BKN_LAP_145/view', 'Monev KDKMP Triwulan III selesai.', '2026-09-29 09:00:00', '2026-10-06 03:20:33'),
(116, 146, 86, 4, 474.00, 308.00, 'https://drive.google.com/file/d/1BKN_LAP_146/view', 'Ujian Dinas Palangkaraya lancar.', '2026-10-02 09:00:00', '2026-10-06 03:20:33'),
(117, 147, 535, 15, 496.00, 282.00, 'https://drive.google.com/file/d/1BKN_LAP_147/view', 'SKD CPNS Kukar terlaksana baik.', '2026-10-05 09:00:00', '2026-10-06 03:20:33'),
(118, 148, 126, 4, 485.00, 300.00, 'https://drive.google.com/file/d/1BKN_LAP_148/view', 'SKB CPNS Keuangan aman.', '2026-10-08 09:00:00', '2026-10-06 03:20:33'),
(119, 149, 301, 9, 478.00, 286.00, 'https://drive.google.com/file/d/1BKN_LAP_149/view', 'PPPK Guru Tanah Laut sukses.', '2026-10-12 09:00:00', '2026-10-06 03:20:33'),
(120, 150, 232, 8, 491.00, 295.00, 'https://drive.google.com/file/d/1BKN_LAP_150/view', 'SKD Kedinasan STIS tepat waktu.', '2026-10-14 09:00:00', '2026-10-06 03:20:33'),
(121, 151, 96, 4, 460.00, 282.00, 'https://drive.google.com/file/d/1BKN_LAP_151/view', 'Seleksi Tenaga SIASN tertib.', '2026-10-16 09:00:00', '2026-10-06 03:20:33'),
(122, 152, 63, 2, 95.00, 82.00, 'https://drive.google.com/file/d/1BKN_LAP_152/view', 'Uji Kompetensi Kenaikan Pangkat selesai.', '2026-10-18 09:00:00', '2026-10-06 03:20:33'),
(123, 153, 35, 0, 97.00, 84.00, 'https://drive.google.com/file/d/1BKN_LAP_153/view', 'Sertifikasi Asesor Kalteng lulus 100%.', '2026-10-20 09:00:00', '2026-10-06 03:20:33'),
(124, 154, 468, 12, 488.00, 270.00, 'https://drive.google.com/file/d/1BKN_LAP_154/view', 'Simulasi CAT Banjarbaru ramai.', '2026-10-23 09:00:00', '2026-10-06 03:20:33'),
(125, 155, 68, 2, 471.00, 302.00, 'https://drive.google.com/file/d/1BKN_LAP_155/view', 'UPKP Barito Utara terlaksana.', '2026-10-25 09:00:00', '2026-10-06 03:20:33'),
(126, 156, 82, 3, 469.00, 305.00, 'https://drive.google.com/file/d/1BKN_LAP_156/view', 'Ujian Dinas Barito Selatan tertib.', '2026-11-02 09:00:00', '2026-10-06 03:20:33'),
(127, 157, 330, 10, 488.00, 280.00, 'https://drive.google.com/file/d/1BKN_LAP_157/view', 'SKD CPNS Nunukan lancar.', '2026-11-05 09:00:00', '2026-10-06 03:20:33'),
(128, 158, 116, 4, 485.00, 300.00, 'https://drive.google.com/file/d/1BKN_LAP_158/view', 'SKB CPNS Banjarmasin aman.', '2026-11-07 09:00:00', '2026-10-06 03:20:33'),
(129, 159, 282, 8, 476.00, 288.00, 'https://drive.google.com/file/d/1BKN_LAP_159/view', 'PPPK Teknis Kapuas sukses.', '2026-11-11 09:00:00', '2026-10-06 03:20:33'),
(130, 160, 488, 12, 492.00, 275.00, 'https://drive.google.com/file/d/1BKN_LAP_160/view', 'Simulasi CAT Kaltim meriah.', '2026-11-13 09:00:00', '2026-10-06 03:20:33'),
(131, 166, 115, 5, 480.00, 310.00, 'https://drive.google.com/file/d/1BKN_LAP_166/view', 'Ujian e-UDIN Akhir Tahun kondusif.', '2026-12-02 09:00:00', '2026-10-06 03:20:33'),
(132, 167, 398, 12, 490.00, 282.00, 'https://drive.google.com/file/d/1BKN_LAP_167/view', 'SKD CPNS Kutim terlaksana baik.', '2026-12-05 09:00:00', '2026-10-06 03:20:33'),
(133, 168, 145, 5, 487.00, 302.00, 'https://drive.google.com/file/d/1BKN_LAP_168/view', 'SKB CPNS Analis Kepegawaian lancar.', '2026-12-08 09:00:00', '2026-10-06 03:20:33'),
(134, 169, 368, 12, 480.00, 286.00, 'https://drive.google.com/file/d/1BKN_LAP_169/view', 'PPPK Akhir Tahun Banjarbaru sukses.', '2026-12-11 09:00:00', '2026-10-06 03:20:33'),
(135, 170, 632, 18, 495.00, 270.00, 'https://drive.google.com/file/d/1BKN_LAP_170/view', 'Simulasi CAT Akhir Tahun ramai lancar.', '2026-12-14 09:00:00', '2026-10-06 03:20:33');

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
(1, 1, 1, 'Penanggung jawab ruang CAT Ujian Dinas Kalsel', '2026-06-02', '2026-10-05 06:06:24'),
(2, 3, 2, 'Pengawas dan verifikator UPKP BKN', '2026-06-04', '2026-10-05 06:06:24'),
(3, 11, 3, 'Petugas teknis server Simulasi CAT Mandiri', '2026-06-05', '2026-10-05 06:06:24'),
(4, 4, 4, 'Koordinator CAT PPPK Guru Banjarbaru', '2026-06-08', '2026-10-05 06:06:24'),
(5, 10, 5, 'Tim Asesor KDKMP dan KNMP', '2026-06-11', '2026-10-05 06:06:24'),
(6, 2, 6, 'Koordinator pengawas SKD Kedinasan IPDN', '2026-06-12', '2026-10-05 06:06:24'),
(7, 5, 7, 'Tim verifikator Uji Kompetensi Kepegawaian', '2026-06-15', '2026-10-05 06:06:24'),
(8, 6, 8, 'Penanggung jawab teknis Kedinasan Poltekip', '2026-06-17', '2026-10-05 06:06:24'),
(9, 5, 9, 'Koordinator CAT BLUD RSUD Ulin', '2026-06-19', '2026-10-05 06:06:24'),
(10, 1, 10, 'Instruktur Sertifikasi CAT Petugas Regional', '2026-06-22', '2026-10-05 06:06:24'),
(11, 3, 11, 'Pengawas Simulasi CAT Terpadu Banjar', '2026-06-23', '2026-10-05 06:06:24'),
(12, 2, 12, 'Koordinator lapangan PPPK Nakes Tanah Laut', '2026-06-25', '2026-10-05 06:06:24'),
(13, 6, 13, 'Penanggung jawab teknis SKD CPNS Kemenkumham', '2026-06-27', '2026-10-05 06:06:24'),
(14, 12, 14, 'Tim verifikator Beasiswa S2 Layanan Kepegawaian', '2026-06-30', '2026-10-05 06:06:24'),
(15, 4, 15, 'Pengawas Seleksi Perangkat Desa Barito Kuala', '2026-06-30', '2026-10-05 06:06:24'),
(16, 1, 16, 'Penanggung jawab ujian e-UDIN Banjarmasin', '2026-07-02', '2026-10-05 06:06:24'),
(17, 2, 17, 'Koordinator tim fasilitasi SKD CPNS Tapin', '2026-07-05', '2026-10-05 06:06:24'),
(18, 4, 18, 'Pengawas SKB CPNS Pemprov Kalsel', '2026-07-08', '2026-10-05 06:06:24'),
(19, 3, 19, 'Koordinator PPPK Teknis Barito Kuala', '2026-07-10', '2026-10-05 06:06:24'),
(20, 1, 20, 'Penanggung jawab SKD Kedinasan STIN & STIS', '2026-07-13', '2026-10-05 06:06:24'),
(21, 10, 21, 'Asesor Psikotes Kedinasan IPDN', '2026-07-16', '2026-10-05 06:06:24'),
(22, 5, 22, 'Koordinator lapangan BLUD RSUD Ansari Saleh', '2026-07-18', '2026-10-05 06:06:24'),
(23, 12, 23, 'Tim penguji Uji Kompetensi Kenaikan Pangkat', '2026-07-21', '2026-10-05 06:06:24'),
(24, 11, 24, 'Instruktur Sertifikasi Pengelola CAT BKN', '2026-07-22', '2026-10-05 06:06:24'),
(25, 3, 25, 'Pengawas Simulasi CAT Pelajar Banjarbaru', '2026-07-23', '2026-10-05 06:06:24'),
(26, 4, 26, 'Narasumber Sosialisasi KDKMP dan KNMP', '2026-07-25', '2026-10-05 06:06:24'),
(27, 1, 27, 'Penanggung jawab UPKP Kanreg VIII', '2026-07-27', '2026-10-05 06:06:24'),
(28, 2, 28, 'Koordinator SKD CPNS Hulu Sungai Selatan', '2026-07-28', '2026-10-05 06:06:24'),
(29, 6, 29, 'Pengawas Praktik Komputer PPPK', '2026-07-31', '2026-10-05 06:06:24'),
(30, 5, 30, 'Tim penguji Pendamping Desa HST', '2026-07-31', '2026-10-05 06:06:24'),
(31, 1, 31, 'Penanggung jawab Ujian Dinas Tanah Bumbu', '2026-08-03', '2026-10-05 06:06:24'),
(32, 9, 32, 'Koordinator pengawas SKD CPNS Kalteng', '2026-08-05', '2026-10-05 06:06:24'),
(33, 9, 33, 'Pengawas SKB CPNS Palangkaraya', '2026-08-10', '2026-10-05 06:06:24'),
(34, 2, 34, 'Koordinator PPPK Guru Kotabaru', '2026-08-12', '2026-10-05 06:06:24'),
(35, 9, 35, 'Penanggung jawab SKD Poltekip Kalteng', '2026-08-15', '2026-10-05 06:06:24'),
(36, 10, 36, 'Tim Asesor Tes Kesehatan Kedinasan', '2026-08-18', '2026-10-05 06:06:24'),
(37, 5, 37, 'Pengawas Seleksi Non-ASN Keuangan Kalsel', '2026-08-20', '2026-10-05 06:06:24'),
(38, 10, 38, 'Tim penguji Uji Kompetensi Asesor', '2026-08-21', '2026-10-05 06:06:24'),
(39, 11, 39, 'Instruktur Sertifikasi Operator CAT', '2026-08-24', '2026-10-05 06:06:24'),
(40, 3, 40, 'Pengawas Simulasi CAT HUT RI', '2026-08-25', '2026-10-05 06:06:24'),
(41, 4, 41, 'Narasumber Evaluasi KDKMP & KNMP', '2026-08-27', '2026-10-05 06:06:24'),
(42, 1, 42, 'Penanggung jawab UPKP Pegawai Daerah', '2026-08-28', '2026-10-05 06:06:24'),
(43, 1, 43, 'Koordinator SKD CPNS Samarinda', '2026-08-28', '2026-10-05 06:06:24'),
(44, 2, 44, 'Pengawas PPPK Teknis Tabalong', '2026-08-31', '2026-10-05 06:06:24'),
(45, 9, 45, 'Tim penguji Pamong Desa Sukamara', '2026-08-31', '2026-10-05 06:06:24'),
(46, 1, 46, 'Koordinator Ujian Dinas Kanreg VIII', '2026-09-01', '2026-10-05 06:06:24'),
(47, 1, 47, 'Penanggung jawab SKD CPNS Kaltim', '2026-09-03', '2026-10-05 06:06:24'),
(48, 4, 48, 'Pengawas SKB CPNS Analis Hukum', '2026-09-07', '2026-10-05 06:06:24'),
(49, 12, 49, 'Koordinator CAT PPPK Balikpapan', '2026-09-09', '2026-10-05 06:06:24'),
(50, 2, 50, 'Penanggung jawab SKD Kedinasan IPDN', '2026-09-12', '2026-10-05 06:06:24'),
(51, 6, 51, 'Tim penguji Kesamaptaan Kedinasan', '2026-09-15', '2026-10-05 06:06:24'),
(52, 5, 52, 'Pengawas Seleksi Non-ASN BKN', '2026-09-17', '2026-10-05 06:06:24'),
(53, 10, 53, 'Asesor Talent Pool Pejabat Administrator', '2026-09-18', '2026-10-05 06:06:24'),
(54, 10, 54, 'Instruktur Sertifikasi Asesor Pemetaan', '2026-09-21', '2026-10-05 06:06:24'),
(55, 3, 55, 'Pengawas Simulasi CAT September Masif', '2026-09-22', '2026-10-05 06:06:24'),
(56, 12, 56, 'Narasumber Lokakarya KDKMP dan KNMP', '2026-09-25', '2026-10-05 06:06:24'),
(57, 9, 57, 'Tim penguji UPKP Barito Timur', '2026-09-26', '2026-10-05 06:06:24'),
(58, 2, 58, 'Koordinator SKD CPNS Banjarbaru', '2026-09-28', '2026-10-05 06:06:24'),
(59, 9, 59, 'Pengawas PPPK Kesehatan Pulang Pisau', '2026-09-30', '2026-10-05 06:06:24'),
(60, 5, 60, 'Tim penguji BLUD RSUD Banjar', '2026-09-30', '2026-10-05 06:06:24'),
(61, 1, 61, 'Koordinator Ujian Dinas Banjarbaru', '2026-10-01', '2026-10-05 06:06:24'),
(62, 2, 62, 'Penanggung jawab SKD CPNS Banjar', '2026-10-03', '2026-10-05 06:06:24'),
(63, 4, 63, 'Pengawas SKB CPNS Kanreg VIII', '2026-10-06', '2026-10-05 06:06:24'),
(64, 3, 64, 'Koordinator PPPK Guru Kalsel', '2026-10-08', '2026-10-05 06:06:24'),
(65, 6, 65, 'Penanggung jawab SKD Poltekip Kalsel', '2026-10-12', '2026-10-05 06:06:24'),
(66, 10, 66, 'Tim Asesor Pantukhir Kedinasan', '2026-10-14', '2026-10-05 06:06:24'),
(67, 5, 67, 'Pengawas Seleksi Non-ASN BKD Kalsel', '2026-10-15', '2026-10-05 06:06:24'),
(68, 12, 68, 'Tim penguji Uji Kompetensi Mutasi', '2026-10-17', '2026-10-05 06:06:24'),
(69, 11, 69, 'Instruktur Sertifikasi Tim Pengawas', '2026-10-19', '2026-10-05 06:06:24'),
(70, 3, 70, 'Pengawas Simulasi CAT Kedinasan', '2026-10-20', '2026-10-05 06:06:24'),
(71, 1, 76, 'Koordinator Ujian Dinas Tapin', '2026-11-02', '2026-10-05 06:06:24'),
(72, 2, 77, 'Penanggung jawab SKD CPNS Kotabaru', '2026-11-04', '2026-10-05 06:06:24'),
(73, 4, 78, 'Pengawas SKB CPNS Nakes', '2026-11-07', '2026-10-05 06:06:24'),
(74, 12, 79, 'Koordinator PPPK Teknis Samarinda', '2026-11-09', '2026-10-05 06:06:24'),
(75, 3, 80, 'Pengawas Simulasi CAT 2027', '2026-11-12', '2026-10-05 06:06:24'),
(76, 1, 106, 'Penanggung jawab Uji Kompetensi Pemko Banjarmasin', '2026-06-04', '2026-10-06 03:20:33'),
(77, 2, 107, 'Koordinator CAT PPPK Teknis Banjar', '2026-06-07', '2026-10-06 03:20:33'),
(78, 3, 108, 'Narasumber Sosialisasi SIASN Kanreg VIII', '2026-06-09', '2026-10-06 03:20:33'),
(79, 11, 109, 'Petugas teknis Simulasi CAT Banjarmasin', '2026-06-13', '2026-10-06 03:20:33'),
(80, 5, 110, 'Pengawas Seleksi Non-ASN RSUD Ansari Saleh', '2026-06-15', '2026-10-06 03:20:33'),
(81, 10, 111, 'Tim Asesor Pemetaan Profil Pegawai', '2026-06-18', '2026-10-06 03:20:33'),
(82, 12, 112, 'Instruktur Sertifikasi Pengawas Sub-Regional', '2026-06-21', '2026-10-06 03:20:33'),
(83, 4, 113, 'Penanggung jawab UPKP Kabupaten Tapin', '2026-06-23', '2026-10-06 03:20:33'),
(84, 6, 114, 'Koordinator teknis SKD Kedinasan STTD', '2026-06-26', '2026-10-06 03:20:33'),
(85, 1, 115, 'Tim evaluasi Fasilitator CAT', '2026-06-29', '2026-10-06 03:20:33'),
(86, 1, 116, 'Koordinator Ujian Dinas Tanah Laut', '2026-07-04', '2026-10-06 03:20:33'),
(87, 2, 117, 'Penanggung jawab SKD CPNS Barito Kuala', '2026-07-06', '2026-10-06 03:20:33'),
(88, 4, 118, 'Pengawas PPPK Nakes Banjarbaru', '2026-07-10', '2026-10-06 03:20:33'),
(89, 3, 119, 'Koordinator Simulasi CAT Sekolah Kedinasan', '2026-07-12', '2026-10-06 03:20:33'),
(90, 5, 120, 'Tim penguji Pamong Desa Tanah Bumbu', '2026-07-15', '2026-10-06 03:20:33'),
(91, 12, 121, 'Verifikator berkas Uji Kompetensi Mutasi', '2026-07-18', '2026-10-06 03:20:33'),
(92, 10, 122, 'Asesor Psikotes Kedinasan STIN', '2026-07-20', '2026-10-06 03:20:33'),
(93, 11, 123, 'Instruktur Sertifikasi Operator Server', '2026-07-23', '2026-10-06 03:20:33'),
(94, 4, 124, 'Narasumber Lokakarya KDKMP Kotabaru', '2026-07-26', '2026-10-06 03:20:33'),
(95, 3, 125, 'Pengawas UPKP BKN Regional', '2026-07-29', '2026-10-06 03:20:33'),
(96, 1, 126, 'Koordinator Ujian Dinas Tabalong', '2026-08-02', '2026-10-06 03:20:33'),
(97, 2, 127, 'Penanggung jawab SKD CPNS HST', '2026-08-06', '2026-10-06 03:20:33'),
(98, 9, 128, 'Pengawas SKB CPNS Pemkalteng', '2026-08-10', '2026-10-06 03:20:33'),
(99, 3, 129, 'Koordinator PPPK Guru HSU', '2026-08-13', '2026-10-06 03:20:33'),
(100, 6, 130, 'Penanggung jawab SKD Kedinasan Poltekip', '2026-08-16', '2026-10-06 03:20:33'),
(101, 5, 131, 'Pengawas Seleksi Non-ASN BKN', '2026-08-19', '2026-10-06 03:20:33'),
(102, 10, 132, 'Tim penguji Uji Kompetensi Asesor', '2026-08-22', '2026-10-06 03:20:33'),
(103, 11, 133, 'Instruktur Sertifikasi Pengelola Komputer', '2026-08-24', '2026-10-06 03:20:33'),
(104, 4, 134, 'Koordinator Simulasi CAT Kemerdekaan', '2026-08-26', '2026-10-06 03:20:33'),
(105, 12, 135, 'Narasumber Bimtek KNMP', '2026-08-29', '2026-10-06 03:20:33'),
(106, 1, 136, 'Koordinator Ujian e-UDIN Pemprov Kalsel', '2026-09-02', '2026-10-06 03:20:33'),
(107, 12, 137, 'Penanggung jawab SKD CPNS Paser', '2026-09-05', '2026-10-06 03:20:33'),
(108, 6, 138, 'Pengawas SKB CPNS Komputer', '2026-09-09', '2026-10-06 03:20:33'),
(109, 1, 139, 'Koordinator PPPK Teknis Balikpapan', '2026-09-12', '2026-10-06 03:20:33'),
(110, 2, 140, 'Tim penguji Kesamaptaan IPDN', '2026-09-16', '2026-10-06 03:20:33'),
(111, 5, 141, 'Pengawas CAT BLUD RSUD Banjar', '2026-09-18', '2026-10-06 03:20:33'),
(112, 10, 142, 'Asesor Talent Pool Pejabat Pengawas', '2026-09-21', '2026-10-06 03:20:33'),
(113, 9, 143, 'Instruktur Sertifikasi UPT Palangkaraya', '2026-09-24', '2026-10-06 03:20:33'),
(114, 3, 144, 'Pengawas Simulasi CAT Tapin', '2026-09-26', '2026-10-06 03:20:33'),
(115, 4, 145, 'Tim Monev KDKMP Triwulan III', '2026-09-29', '2026-10-06 03:20:33'),
(116, 9, 146, 'Koordinator Ujian Dinas Palangkaraya', '2026-10-01', '2026-10-06 03:20:33'),
(117, 12, 147, 'Penanggung jawab SKD CPNS Kukar', '2026-10-03', '2026-10-06 03:20:33'),
(118, 4, 148, 'Pengawas SKB CPNS Keuangan', '2026-10-07', '2026-10-06 03:20:33'),
(119, 2, 149, 'Koordinator PPPK Guru Tanah Laut', '2026-10-10', '2026-10-06 03:20:33'),
(120, 1, 150, 'Penanggung jawab SKD Kedinasan STIS', '2026-10-13', '2026-10-06 03:20:33'),
(121, 5, 151, 'Pengawas Seleksi Tenaga SIASN', '2026-10-16', '2026-10-06 03:20:33'),
(122, 10, 152, 'Tim Asesor Uji Kompetensi Kenaikan Pangkat', '2026-10-18', '2026-10-06 03:20:33'),
(123, 9, 153, 'Instruktur Sertifikasi Asesor Kalteng', '2026-10-20', '2026-10-06 03:20:33'),
(124, 3, 154, 'Pengawas Simulasi CAT Banjarbaru', '2026-10-22', '2026-10-06 03:20:33'),
(125, 9, 155, 'Tim penguji UPKP Barito Utara', '2026-10-25', '2026-10-06 03:20:33'),
(126, 9, 156, 'Koordinator Ujian Dinas Barito Selatan', '2026-11-01', '2026-10-06 03:20:33'),
(127, 12, 157, 'Penanggung jawab SKD CPNS Nunukan', '2026-11-03', '2026-10-06 03:20:33'),
(128, 4, 158, 'Pengawas SKB CPNS Banjarmasin', '2026-11-06', '2026-10-06 03:20:33'),
(129, 9, 159, 'Koordinator PPPK Teknis Kapuas', '2026-11-09', '2026-10-06 03:20:33'),
(130, 1, 160, 'Pengawas Simulasi CAT Kaltim', '2026-11-12', '2026-10-06 03:20:33'),
(131, 1, 166, 'Koordinator Ujian e-UDIN BKN', '2026-12-01', '2026-10-06 03:20:33'),
(132, 12, 167, 'Penanggung jawab SKD CPNS Kutim', '2026-12-03', '2026-10-06 03:20:33'),
(133, 4, 168, 'Pengawas SKB CPNS Analis Kepegawaian', '2026-12-07', '2026-10-06 03:20:33'),
(134, 2, 169, 'Koordinator PPPK Banjarbaru', '2026-12-09', '2026-10-06 03:20:33'),
(135, 11, 170, 'Petugas teknis Simulasi CAT Akhir Tahun', '2026-12-12', '2026-10-06 03:20:33');

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
(4, 'pimpinan_bkn', '198507082010041003', 'pimpinan01@bkn.go.id', '$2y$12$8QEpJWSFi5KwPdHEMFGiauiWo/ZdNGr3Uo/WBHbdHesRbYNWK3mFS', 'pimpinan', NULL, NULL, '2026-09-03 01:14:01', '2026-10-04 20:35:33'),
(5, 'ahmad_dani', '199301152019031001', 'ahmad.dani@bkn.go.id', '$2y$12$okaDUSmKUh0zptVVzXkiXOGAkoeHKRMR26y.ks307F6OQu9ZQBnV.', 'pegawai', 3, NULL, '2026-09-22 02:41:28', '2026-09-21 18:42:22'),
(6, 'hendra_pratama', '198804202012011002', 'hendra.pratama@bkn.go.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'pegawai', 4, NULL, '2026-09-22 02:41:28', '2026-09-22 02:41:28'),
(7, 'nur_hidayah', '199408122020012003', 'nur.hidayah@bkn.go.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'pegawai', 5, NULL, '2026-09-22 02:41:28', '2026-09-22 02:41:28'),
(8, 'fajar_ramadhan', '199602282021021001', 'fajar.ramadhan@bkn.go.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'pegawai', 6, NULL, '2026-09-22 02:41:28', '2026-09-22 02:41:28'),
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
  MODIFY `id_jeniskeg` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id_keg` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT for table `laporan_kegiatan`
--
ALTER TABLE `laporan_kegiatan`
  MODIFY `id_laporan` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `rekam_kj`
--
ALTER TABLE `rekam_kj`
  MODIFY `id_kj` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

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
