-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2025 at 08:30 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absensi`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `no` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `hadir` tinyint(1) DEFAULT 0 COMMENT '1=Hadir, 0=Tidak',
  `sakit` tinyint(1) DEFAULT 0 COMMENT '1=Sakit, 0=Tidak',
  `izin` tinyint(1) DEFAULT 0 COMMENT '1=Izin, 0=Tidak',
  `alfa` tinyint(1) DEFAULT 0 COMMENT '1=Alfa, 0=Tidak',
  `dinas_luar` tinyint(1) DEFAULT 0 COMMENT '1=Dinas Luar, 0=Tidak',
  `cuti` tinyint(1) DEFAULT 0 COMMENT '1=Cuti, 0=Tidak',
  `terlambat_kurang_30` int(11) DEFAULT 0,
  `terlambat_30_90` int(11) DEFAULT 0,
  `terlambat_lebih_90` int(11) DEFAULT 0,
  `tidak_finger_masuk` int(11) DEFAULT 0,
  `tidak_finger_pulang` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `no`, `nama`, `nip`, `tanggal`, `hadir`, `sakit`, `izin`, `alfa`, `dinas_luar`, `cuti`, `terlambat_kurang_30`, `terlambat_30_90`, `terlambat_lebih_90`, `tidak_finger_masuk`, `tidak_finger_pulang`) VALUES
(17, 0, 'NAMA', 'NIP', '1970-01-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(18, 0, 'Wendy', '12345', '1970-01-01', 0, 1, 1, 1, 1, 1, 11, 0, 0, 0, 0),
(19, 0, 'Najdah', '54321', '1970-01-01', 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0),
(20, 0, 'Lorenza', '121212', '1970-01-01', 0, 1, 2, 3, 2, 4, 6, 10, 1, 3, 0),
(21, 0, 'NAMA', 'NIP', '1970-01-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(22, 0, 'Wendy', '12345', '1970-01-01', 0, 1, 1, 1, 1, 1, 11, 0, 0, 0, 0),
(23, 0, 'Najdah', '54321', '1970-01-01', 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0),
(24, 0, 'Lorenza', '121212', '1970-01-01', 0, 1, 2, 3, 2, 4, 6, 10, 1, 3, 0),
(25, 0, 'NAMA', 'NIP', '1970-01-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(26, 0, 'Wendy', '12345', '1970-01-01', 0, 1, 1, 1, 1, 1, 11, 0, 0, 0, 0),
(27, 0, 'Najdah', '54321', '1970-01-01', 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0),
(28, 0, 'Lorenza', '121212', '1970-01-01', 0, 1, 2, 3, 2, 4, 6, 10, 1, 3, 0),
(29, 0, 'NAMA', 'NIP', '1970-01-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(30, 0, 'Wendy', '12345', '1970-01-01', 0, 1, 1, 1, 1, 1, 11, 0, 0, 0, 0),
(31, 0, 'Najdah', '54321', '1970-01-01', 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0),
(32, 0, 'Lorenza', '121212', '1970-01-01', 0, 1, 2, 3, 2, 4, 6, 10, 1, 3, 0),
(33, 0, 'NAMA', 'NIP', '1970-01-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(34, 0, 'Wendy', '12345', '1970-01-01', 0, 1, 1, 1, 1, 1, 11, 0, 0, 0, 0),
(35, 0, 'Najdah', '54321', '1970-01-01', 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0),
(36, 0, 'Lorenza', '121212', '1970-01-01', 0, 1, 2, 3, 2, 4, 6, 10, 1, 3, 0),
(37, 0, 'NAMA', 'NIP', '1970-01-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(38, 0, 'Wendy', '12345', '1970-01-01', 0, 1, 1, 1, 1, 1, 11, 0, 0, 0, 0),
(39, 0, 'Najdah', '54321', '1970-01-01', 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0),
(40, 0, 'Lorenza', '121212', '1970-01-01', 0, 1, 2, 3, 2, 4, 6, 10, 1, 3, 0),
(41, 0, 'NAMA', 'NIP', '1970-01-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(42, 0, 'Wendy', '12345', '1970-01-01', 0, 1, 1, 1, 1, 1, 11, 0, 0, 0, 0),
(43, 0, 'Najdah', '54321', '1970-01-01', 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0),
(44, 0, 'Lorenza', '121212', '1970-01-01', 0, 1, 2, 3, 2, 4, 6, 10, 1, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id` int(11) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `gaji_pokok` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rekap_absensi`
--

CREATE TABLE `rekap_absensi` (
  `id` int(11) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `bulan` int(2) NOT NULL,
  `tahun` int(4) NOT NULL,
  `hadir` int(11) DEFAULT 0,
  `sakit` int(11) DEFAULT 0,
  `izin` int(11) DEFAULT 0,
  `alfa` int(11) DEFAULT 0,
  `dinas_luar` int(11) DEFAULT 0,
  `telat_kurang_30` int(11) DEFAULT 0,
  `telat_30_90` int(11) DEFAULT 0,
  `telat_lebih_90` int(11) DEFAULT 0,
  `finger_tidak_lengkap` int(11) DEFAULT 0,
  `total_gaji` decimal(10,2) DEFAULT 0.00,
  `potongan_total` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(125) NOT NULL,
  `email` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` int(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `image`, `password`, `role_id`, `is_active`, `date_created`) VALUES
(5, 'Super Admin', 'superadmin@gmail.com', 'WhatsApp_Image_2025-09-23_at_08_13_03_fd9f64b0.jpg', '$2y$10$gOUmr/zVsc3HhaCa3Jxz1uIC5IOF6QtIEiBeAcrogU1ThW2xnzweW', 1, 1, 1751614988),
(6, 'Pria', '19220300@bsi.ac.id', 'default.jpg', '$2y$10$vZAvNMhdNBJ/WXz47FTUa.stGqRLEfxApXmufTJpMJzmOT8JHIm7.', 2, 1, 1751622872),
(9, 'Muhammad Wendy', 'wendy.diansyah94@gmail.com', 'Cr__@fahrizaimin_on_ig_(1)_jpeg.jpg', '$2y$10$5dT6zC2JoLuCS5XnUfa0nuwLTBnTsEJiLcwmG8Fy3pY3DBbzz5aoW', 2, 1, 1757383125),
(10, 'wendy12', 'wendy12@gmail.com', 'default.jpg', '$2y$10$Ecus7FPh5o9DG7DHkovI8.2I1FG42p1mpXs/XkoKXC8hAcWUNchCK', 2, 1, 1757433991);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(5, 2, 2),
(7, 1, 5),
(11, 1, 9),
(13, 1, 10),
(17, 1, 12),
(18, 2, 9),
(19, 2, 10),
(20, 2, 12);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'Admin'),
(2, 'user'),
(5, 'Menu'),
(9, 'Master Data'),
(10, 'Laporan'),
(12, 'Absensi');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Super Admin'),
(2, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 1, 'Dashboard', 'admin', 'fas fa-fw fa-home', 1),
(3, 2, 'My Profile', 'user', 'fas fa-fw fa-user', 1),
(5, 5, 'Menu Management', 'menu', 'fas fa-fw fa-folder', 1),
(7, 5, 'Submenu Management', 'menu/submenu', 'fas fa-fw fa-folder-open', 1),
(14, 1, 'Role', 'admin/role', 'fas fa-fw fa-wrench', 1),
(15, 9, 'Karyawan', 'karyawan', 'fas fa-fw fa-user-tie', 1),
(17, 12, 'Absensi Harian', 'absensi', 'fas fa-user-check', 1),
(19, 1, 'Manajemen User', 'admin/manage_user', 'fas fa-fw fa-users', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nip` (`nip`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`);

--
-- Indexes for table `rekap_absensi`
--
ALTER TABLE `rekap_absensi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip_bulan_tahun` (`nip`,`bulan`,`tahun`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rekap_absensi`
--
ALTER TABLE `rekap_absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
