-- =======================================================
-- SKEMA BASIS DATA SISTEM PERENCANAAN KEGIATAN REGIONAL BKN
-- =======================================================

CREATE DATABASE IF NOT EXISTS `db_bkn_kegiatan` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE `db_bkn_kegiatan`;

-- 1. TABEL PENGGUNA (USER)
CREATE TABLE `users` (
    `id_user` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('admin', 'pegawai', 'pimpinan') NOT NULL DEFAULT 'pegawai',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. TABEL JENIS KEGIATAN
CREATE TABLE `jenis_keg` (
    `id_jeniskeg` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `nama_jeniskeg` VARCHAR(100) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 3. TABEL INSTANSI
CREATE TABLE `instansi` (
    `id_instansi` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `nm_instansi` VARCHAR(150) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 4. TABEL TITIK LOKASI
CREATE TABLE `titik_lokasi` (
    `id_tklokasi` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `nm_lokasi` VARCHAR(100) NOT NULL,
    `alamat` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 5. TABEL KARYAWAN / PEGAWAI
CREATE TABLE `karyawan` (
    `id_karyawan` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `nama_karyawan` VARCHAR(100) NOT NULL,
    `catatan_kj` TEXT NULL,
    `perjalanan` VARCHAR(100) NULL,
    `lama_jalan` VARCHAR(50) NULL,
    `tempat_jalan` VARCHAR(150) NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 6. TABEL KEGIATAN (TERPUSAT)
CREATE TABLE `kegiatan` (
    `id_keg` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `nama_keg` VARCHAR(150) NOT NULL,
    `id_jeniskeg` INT UNSIGNED NOT NULL,
    `id_tklokasi` INT UNSIGNED NOT NULL,
    `id_instansi` INT UNSIGNED NOT NULL,
    `id_karyawan_koor` INT UNSIGNED NOT NULL,
    `jmlh_peserta` INT UNSIGNED NOT NULL DEFAULT 0,
    `tanggal_mulai` DATE NOT NULL,
    `tanggal_selesai` DATE NULL,
    `status` ENUM('Belum Konfirmasi', 'Terkonfirmasi', 'Selesai', 'Dibatalkan') NOT NULL DEFAULT 'Belum Konfirmasi',
    `lampiran` VARCHAR(255) NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Relasi Kunci Tamu (Foreign Keys)
    CONSTRAINT `fk_kegiatan_jenis` FOREIGN KEY (`id_jeniskeg`) REFERENCES `jenis_keg` (`id_jeniskeg`) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT `fk_kegiatan_lokasi` FOREIGN KEY (`id_tklokasi`) REFERENCES `titik_lokasi` (`id_tklokasi`) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT `fk_kegiatan_instansi` FOREIGN KEY (`id_instansi`) REFERENCES `instansi` (`id_instansi`) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT `fk_kegiatan_koordinator` FOREIGN KEY (`id_karyawan_koor`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

-- 7. TABEL REKAM RIWAYAT KERJA KARYAWAN
CREATE TABLE `rekam_kj` (
    `id_kj` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `id_karyawan` INT UNSIGNED NOT NULL,
    `id_keg` INT UNSIGNED NOT NULL,
    `ket_rekam` VARCHAR(255) NULL,
    `tgl_rekam` DATE NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    -- Relasi Kunci Tamu (Foreign Keys)
    CONSTRAINT `fk_rekam_karyawan` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_rekam_kegiatan` FOREIGN KEY (`id_keg`) REFERENCES `kegiatan` (`id_keg`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- =======================================================
-- DUMMY DATA INISIALISASI (SESUAI DENGAN WIREFRAME APLIKASI)
-- =======================================================

-- Master Jenis Kegiatan
INSERT INTO `jenis_keg` (`id_jeniskeg`, `nama_jeniskeg`) VALUES
(1, 'Pengembangan Karir'),
(2, 'Sekolah Kedinasan'),
(3, 'Tes CASN'),
(4, 'Tes Non-ASN');

-- Master Instansi
INSERT INTO `instansi` (`id_instansi`, `nm_instansi`) VALUES
(1, 'Instansi A'),
(2, 'Instansi B'),
(3, 'Instansi C'),
(4, 'Instansi D');

-- Master Titik Lokasi
INSERT INTO `titik_lokasi` (`id_tklokasi`, `nm_lokasi`, `alamat`) VALUES
(1, 'Gedung A', 'JL. Bhayangkara 1'),
(2, 'Gedung B', 'JL. Bhayangkara 2'),
(3, 'Gedung C', 'JL. Bhayangkara 3'),
(4, 'Gedung D', 'JL. Bhayangkara 4');

-- Data Karyawan
INSERT INTO `karyawan` (`id_karyawan`, `nama_karyawan`, `catatan_kj`) VALUES
(1, 'Pegawai A', 'Fasilitator Utama CAT'),
(2, 'Pegawai B', 'Pengawas Ujian Kedinasan'),
(3, 'Pegawai C', 'Koordinator Verifikasi Berkas'),
(4, 'Pegawai D', 'Petugas Teknis Jaringan');

-- Data Kegiatan
INSERT INTO `kegiatan` (`id_keg`, `nama_keg`, `id_jeniskeg`, `id_tklokasi`, `id_instansi`, `id_karyawan_koor`, `jmlh_peserta`, `tanggal_mulai`, `tanggal_selesai`, `status`, `lampiran`) VALUES
(1, 'Kegiatan A', 3, 1, 1, 1, 100, '2026-06-03', '2026-06-04', 'Belum Konfirmasi', 'https://drive.google.com/sampleA'),
(2, 'Kegiatan B', 2, 2, 2, 2, 120, '2026-06-04', '2026-06-05', 'Belum Konfirmasi', 'https://drive.google.com/sampleB'),
(3, 'Kegiatan C', 3, 3, 3, 3, 80,  '2026-06-05', '2026-06-05', 'Belum Konfirmasi', 'https://drive.google.com/sampleC'),
(4, 'Kegiatan D', 3, 4, 4, 4, 90,  '2026-06-10', '2026-06-10', 'Belum Konfirmasi', 'https://drive.google.com/sampleD');

-- Data Rekam Riwayat Kerja Karyawan
INSERT INTO `rekam_kj` (`id_karyawan`, `id_keg`, `ket_rekam`, `tgl_rekam`) VALUES
(1, 1, 'Memfasilitasi Kegiatan A di Gedung A', '2026-06-03'),
(1, 2, 'Membantu persiapan Kegiatan B', '2026-06-04'),
(2, 2, 'Koordinator Kegiatan B', '2026-06-04'),
(3, 3, 'Koordinator Kegiatan C', '2026-06-05'),
(4, 4, 'Koordinator Kegiatan D', '2026-06-10');