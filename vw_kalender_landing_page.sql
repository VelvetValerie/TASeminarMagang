-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2026 at 03:16 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
-- Structure for view `vw_kalender_landing_page`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_kalender_landing_page`  AS SELECT DISTINCT `kg`.`id_keg` AS `ID Kegiatan`, `kg`.`nama_keg` AS `Nama Kegiatan`, `jk`.`nama_jeniskeg` AS `Jenis Kegiatan`, `tl`.`nm_lokasi` AS `Titik Lokasi`, `ins`.`nm_instansi` AS `Instansi`, `kar`.`nama_karyawan` AS `Nama Karyawan Koordinator`, `kg`.`jmlh_peserta` AS `Jumlah Peserta`, `kg`.`tanggal_mulai` AS `Tanggal Mulai`, `kg`.`tanggal_selesai` AS `Tanggal Selesai`, `kg`.`status` AS `Status` FROM ((((`kegiatan` `kg` join `jenis_keg` `jk` on(`kg`.`id_jeniskeg` = `jk`.`id_jeniskeg`)) join `instansi` `ins` on(`kg`.`id_instansi` = `ins`.`id_instansi`)) join `karyawan` `kar` on(`kg`.`id_karyawan_koor` = `kar`.`id_karyawan`)) join `titik_lokasi` `tl` on(`kg`.`id_tklokasi` = `tl`.`id_tklokasi`)) WHERE `kg`.`status` in ('Selesai','Terkonfirmasi') ;

--
-- VIEW `vw_kalender_landing_page`
-- Data: None
--

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
