-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 03, 2026 at 06:37 AM
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
(5, 'Institut Pemerintahan Dalam Negeri (IPDN)', '2026-09-03 01:14:01');

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
(7, 'Fajar Ramadhan, S.Kom', NULL, NULL, NULL, NULL, '2026-09-03 01:11:55', '2026-09-03 01:11:55'),
(8, 'Dewi Lestari, S.E', NULL, NULL, NULL, NULL, '2026-09-03 01:11:55', '2026-09-03 01:11:55');

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
(1, 'Ujian Dinas Tingkat I & II BKN', 3, 1, 1, 1, 100, '2026-06-03', '2026-06-04', 'Belum Konfirmasi', 'https://drive.google.com/sampleA', '2026-09-01 00:17:35', '2026-09-03 01:17:32'),
(2, 'Bimtek Penilaian Kinerja ASN Pemprov', 2, 2, 2, 2, 120, '2026-06-04', '2026-06-05', 'Belum Konfirmasi', 'https://drive.google.com/sampleB', '2026-09-01 00:17:35', '2026-09-03 01:17:32'),
(3, 'Simulasi CAT Mandiri BKN', 3, 3, 3, 3, 80, '2026-06-05', '2026-06-05', 'Belum Konfirmasi', 'https://drive.google.com/sampleC', '2026-09-01 00:17:35', '2026-09-03 01:17:32'),
(4, 'Fasilitasi CAT Seleksi PPPK Tahap 1', 3, 4, 4, 4, 90, '2026-06-10', '2026-06-10', 'Belum Konfirmasi', 'https://drive.google.com/sampleD', '2026-09-01 00:17:35', '2026-09-03 01:17:32'),
(5, 'Asesmen Pemetaan Potensi Pegawai Daerah', 1, 2, 2, 4, 110, '2026-06-10', '2026-06-12', 'Selesai', NULL, '2026-09-03 01:17:32', '2026-09-03 01:17:32'),
(6, 'Seleksi CAT Mahasiswa Poltekip/Poltekim', 2, 1, 4, 6, 320, '2026-06-12', '2026-06-13', 'Selesai', 'sk_poltekip.pdf', '2026-09-03 01:17:32', '2026-09-03 01:17:32'),
(7, 'Uji Kompetensi Jabatan Fungsional Kepegawaian', 4, 3, 1, 5, 90, '2026-06-16', '2026-06-18', 'Terkonfirmasi', 'edaran_ujikom.pdf', '2026-09-03 01:17:32', '2026-09-03 01:17:32'),
(8, 'Seleksi CASN Instansi Daerah Kalsel', 3, 4, 2, 2, 500, '2026-06-17', '2026-06-19', 'Terkonfirmasi', NULL, '2026-09-03 01:17:32', '2026-09-03 01:17:32'),
(9, 'Workshop Implementasi SIASN Layanan Mutasi', 1, 2, 1, 4, 60, '2026-06-23', '2026-06-23', 'Belum Konfirmasi', NULL, '2026-09-03 01:17:32', '2026-09-03 01:17:32'),
(10, 'Fasilitasi Ujian CAT Ikatan Dinas IPDN 2026', 2, 1, 5, 1, 600, '2026-06-24', '2026-06-26', 'Terkonfirmasi', 'panduan_cat_ipdn.pdf', '2026-09-03 01:17:32', '2026-09-03 01:17:32'),
(11, 'Rakor Pengawasan dan Pengendalian ASN Regional VIII', 4, 2, 1, 3, 75, '2026-06-25', '2026-06-27', 'Belum Konfirmasi', NULL, '2026-09-03 01:17:32', '2026-09-03 01:17:32'),
(21, 'Ujian Penyesuaian Ijazah ASN Kanreg VIII', 1, 1, 1, 1, 110, '2026-09-01', '2026-09-03', 'Selesai', 'lampiran_upkp.pdf', '2026-09-03 02:09:23', '2026-09-03 02:09:23'),
(22, 'Bimtek Tata Kelola Manajemen Talenta ASN', 1, 2, 2, 2, 75, '2026-09-02', '2026-09-04', 'Terkonfirmasi', 'sk_talenta.pdf', '2026-09-03 02:09:23', '2026-09-03 02:09:23'),
(23, 'Simulasi CAT Mandiri BKN Sesi September', 2, 1, 1, 3, 180, '2026-09-03', '2026-09-03', 'Terkonfirmasi', NULL, '2026-09-03 02:09:23', '2026-09-03 02:09:23'),
(24, 'Fasilitasi CAT Seleksi Kompetensi Dasar CPNS Kalsel', 3, 1, 2, 1, 450, '2026-09-05', '2026-09-08', 'Terkonfirmasi', 'edaran_skd_cpns.pdf', '2026-09-03 02:09:23', '2026-09-03 02:09:23'),
(25, 'Uji Kompetensi Kenaikan Pangkat Pilihan', 1, 3, 3, 4, 90, '2026-09-09', '2026-09-10', 'Terkonfirmasi', 'daftar_peserta.pdf', '2026-09-03 02:09:23', '2026-09-03 02:09:23'),
(26, 'Seleksi CAT Tenaga Teknis Non-ASN BLUD', 4, 1, 3, 5, 230, '2026-09-12', '2026-09-13', 'Terkonfirmasi', NULL, '2026-09-03 02:09:23', '2026-09-03 02:09:23'),
(27, 'Sosialisasi Disiplin Pegawai Sesuai PP 94/2021', 1, 2, 1, 2, 60, '2026-09-16', '2026-09-16', 'Belum Konfirmasi', NULL, '2026-09-03 02:09:23', '2026-09-03 02:09:23'),
(28, 'Fasilitasi Ujian CAT Kedinasan Kemenkumham Kalsel', 2, 4, 4, 6, 320, '2026-09-18', '2026-09-20', 'Terkonfirmasi', 'surat_tugas.pdf', '2026-09-03 02:09:23', '2026-09-03 02:09:23'),
(29, 'Asesmen Profil Kompetensi Pejabat Pengawas', 1, 2, 2, 4, 80, '2026-09-23', '2026-09-25', 'Belum Konfirmasi', NULL, '2026-09-03 02:09:23', '2026-09-03 02:09:23'),
(30, 'Rapat Evaluasi Pengadaan ASN Se-Kalimantan', 4, 2, 1, 3, 100, '2026-09-28', '2026-09-30', 'Belum Konfirmasi', NULL, '2026-09-03 02:09:23', '2026-09-03 02:09:23');

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
(26, 5, 26, 'Koordinator teknis ujian CAT Non-ASN', '2026-09-12', '2026-09-03 02:09:23');

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
(4, 'Lab CAT BKD Provinsi Kalsel', 'JL. Kertanegara 4', '2026-09-01 00:17:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','pegawai','pimpinan') NOT NULL DEFAULT 'pegawai',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin_bkn', '$2y$12$zCZH0F4liwVRzeRZk3cQzO35OyHn5d3vpuRhfDIIgbJCP2EwarBE6', 'admin', NULL, '2026-09-01 17:37:19', '2026-09-03 01:14:01'),
(2, 'budi_santoso', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'pegawai', NULL, '2026-09-03 01:14:01', '2026-09-03 01:14:01'),
(3, 'siti_rahma', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'pegawai', NULL, '2026-09-03 01:14:01', '2026-09-03 01:14:01'),
(4, 'kakanreg_viii', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'pimpinan', NULL, '2026-09-03 01:14:01', '2026-09-03 01:14:01');

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
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `instansi`
--
ALTER TABLE `instansi`
  MODIFY `id_instansi` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jenis_keg`
--
ALTER TABLE `jenis_keg`
  MODIFY `id_jeniskeg` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id_keg` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `rekam_kj`
--
ALTER TABLE `rekam_kj`
  MODIFY `id_kj` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `titik_lokasi`
--
ALTER TABLE `titik_lokasi`
  MODIFY `id_tklokasi` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- Constraints for table `rekam_kj`
--
ALTER TABLE `rekam_kj`
  ADD CONSTRAINT `fk_rekam_karyawan` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rekam_kegiatan` FOREIGN KEY (`id_keg`) REFERENCES `kegiatan` (`id_keg`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
