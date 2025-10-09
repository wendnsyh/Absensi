-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2025 at 10:12 AM
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
(951, 1, 'Wendy', '12345', '2025-12-01', 0, 1, 1, 1, 1, 1, 11, 0, 0, 0, 0),
(952, 2, 'Najdah', '54321', '2025-12-01', 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0),
(953, 3, 'Lorenza', '121212', '2025-12-01', 0, 1, 2, 3, 2, 4, 6, 10, 1, 3, 3),
(954, 0, 'NAMA', 'NIP', '2025-12-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(955, 1, 'Wendy', '12345', '2025-12-01', 0, 1, 1, 1, 1, 1, 11, 0, 0, 0, 0),
(956, 2, 'Najdah', '54321', '2025-12-01', 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0),
(957, 3, 'Lorenza', '121212', '2025-12-01', 0, 1, 2, 3, 2, 4, 6, 10, 1, 3, 3),
(958, 0, 'NAMA', 'ID PEGAWAI', '2025-09-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(959, 1, 'Abdul Mait, S.E', 'DS043', '2025-09-01', 0, 0, 0, 0, 0, 0, 11, 0, 0, 0, 0),
(960, 2, 'Ade Irmayanti', 'DS041', '2025-09-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(961, 3, 'Adi Mulyanto, SE', 'DS010', '2025-09-01', 0, 0, 0, 0, 0, 0, 6, 10, 1, 3, 3),
(962, 4, 'Agus Nurcahyo, S.Kom', 'DS098', '2025-09-01', 0, 0, 0, 0, 0, 0, 16, 4, 0, 1, 1),
(963, 5, 'Ahmad Kandiaz, S.H', 'DS002', '2025-09-01', 0, 0, 0, 0, 0, 0, 5, 0, 0, 7, 7),
(964, 6, 'Ahmad Rinduwan', 'DS063', '2025-09-01', 0, 0, 0, 0, 0, 0, 2, 8, 5, 4, 4),
(965, 7, 'Ahmad Sopian, S.E', 'DS058', '2025-09-01', 0, 0, 0, 0, 0, 0, 0, 2, 1, 6, 6),
(966, 8, 'Alinah', 'DS083', '2025-09-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 23, 23),
(967, 9, 'Andriani Prayuda, S.M', 'DS069', '2025-09-01', 0, 0, 0, 0, 0, 4, 8, 5, 0, 4, 4),
(968, 10, 'Anggriyani Daulay, S.Kom', 'DS017', '2025-09-01', 0, 0, 0, 0, 3, 0, 5, 3, 0, 1, 1),
(969, 11, 'Annisa Ameliasyari', 'DS060', '2025-09-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(970, 12, 'Ari Ardiansah', 'DS009', '2025-09-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(971, 13, 'Ari Widiastuti, A.Md', 'DS020', '2025-09-01', 0, 0, 3, 0, 0, 0, 6, 0, 0, 2, 2),
(972, 14, 'Azis Fadhillah, S.H', 'DS031', '2025-09-01', 0, 2, 0, 0, 3, 0, 0, 0, 2, 2, 2),
(973, 15, 'Burhanudin Jaelani Ibnu Ruslan', 'DS070', '2025-09-01', 0, 0, 0, 0, 4, 0, 3, 0, 0, 1, 1),
(974, 16, 'Darmendra Febrianto, S.E', 'DS054', '2025-09-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1),
(975, 17, 'Desy Wijiyanti, S.Kom.', 'DS071', '2025-09-01', 0, 0, 0, 0, 0, 0, 3, 2, 1, 3, 3),
(976, 18, 'Dwi Fajar', 'DS078', '2025-09-01', 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 1),
(977, 19, 'Dwi Wahyuningsih', 'DS086', '2025-09-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(978, 20, 'Eroh Rohayati, S.Kom', 'DS042', '2025-09-01', 0, 0, 0, 0, 0, 0, 4, 0, 0, 1, 1),
(979, 21, 'Erry Eka Pratama', 'DS006', '2025-09-01', 0, 0, 2, 0, 0, 0, 6, 1, 0, 6, 6),
(980, 22, 'Fahmi Angga Yudha, A.Md', 'DS066', '2025-09-01', 0, 0, 1, 0, 0, 0, 0, 0, 0, 4, 4),
(981, 23, 'Hasan Basri,S.AP', 'DS053', '2025-09-01', 0, 0, 0, 1, 0, 0, 0, 0, 0, 5, 5),
(982, 24, 'Hindawan Yuniar, S.I.Kom', 'DS056', '2025-09-01', 0, 2, 2, 0, 0, 0, 4, 7, 1, 2, 2),
(983, 25, 'Iis Afriyanti, A.Md', 'DS022', '2025-09-01', 0, 0, 1, 0, 0, 0, 9, 2, 0, 8, 8),
(984, 26, 'Ikhwan Adi Putra', 'DS061', '2025-09-01', 0, 0, 0, 8, 0, 0, 2, 3, 4, 6, 6),
(985, 27, 'Ilham Nurudin', 'DS081', '2025-09-01', 0, 0, 0, 5, 0, 0, 0, 0, 0, 12, 12),
(986, 28, 'Irmawati, S.M.', 'DS037', '2025-09-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 3),
(987, 29, 'Isgiantoro', 'DS085', '2025-09-01', 0, 0, 0, 0, 4, 0, 2, 10, 1, 0, 0),
(988, 30, 'Istiqomah Aisyiyah, S.Sos', 'DS021', '2025-09-01', 0, 0, 0, 0, 0, 0, 10, 5, 1, 3, 3),
(989, 31, 'Istiyar Iman Aldriansyah, S.Kom', 'DS062', '2025-09-01', 0, 0, 0, 4, 0, 0, 1, 6, 5, 7, 7),
(990, 32, 'Laras Tyas Ayu Pramudya, S.KM', 'DS064', '2025-09-01', 0, 0, 0, 9, 0, 0, 0, 0, 3, 8, 8),
(991, 33, 'Leo Wahyudi, S.H', 'DS013', '2025-09-01', 0, 0, 0, 0, 0, 0, 15, 3, 0, 1, 1),
(992, 34, 'Lilis Suryani, S.E', 'DS065', '2025-09-01', 0, 0, 0, 0, 13, 0, 0, 0, 0, 1, 1),
(993, 35, 'Linda Amalia,S.Psi', 'DS059', '2025-09-01', 0, 0, 0, 0, 8, 0, 1, 2, 0, 6, 6),
(994, 36, 'Mariyah, S.E', 'DS039', '2025-09-01', 0, 1, 0, 0, 0, 0, 10, 4, 0, 0, 0),
(995, 37, 'Mawaddah Khalisah, S.E.', 'DS004', '2025-09-01', 0, 0, 0, 0, 1, 4, 7, 6, 0, 3, 3),
(996, 38, 'Methatia Cahya, S.H', 'DS015', '2025-09-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 3),
(997, 39, 'Muhamad Rizki', 'DS067', '2025-09-01', 0, 0, 0, 0, 10, 0, 2, 5, 0, 5, 5),
(998, 40, 'Nadya Ayu Permatasari, S.Sos', 'DS016', '2025-09-01', 0, 0, 2, 0, 0, 0, 3, 9, 1, 1, 1),
(999, 41, 'Nia Lestari, A.Md', 'DS007', '2025-09-01', 0, 0, 0, 1, 0, 0, 9, 2, 1, 1, 1),
(1000, 42, 'Nico Reynold Adiputro', 'DS012', '2025-09-01', 0, 0, 0, 1, 0, 0, 2, 14, 3, 3, 3),
(1001, 43, 'Niko Septian Hadi, S.Kom', 'DS040', '2025-09-01', 0, 0, 0, 0, 0, 0, 13, 0, 0, 0, 0),
(1002, 44, 'Novanta Nur Syabana', 'DS052', '2025-09-01', 0, 0, 0, 4, 0, 0, 1, 4, 10, 1, 1),
(1003, 45, 'Nurlaela, S.E', 'DS003', '2025-09-01', 0, 0, 1, 1, 0, 0, 6, 1, 0, 6, 6),
(1004, 46, 'Nurlia Oktaviani, S.M', 'DS057', '2025-09-01', 0, 0, 0, 3, 0, 0, 6, 4, 0, 3, 3),
(1005, 47, 'Pebri Perdana, S.AP', 'DS038', '2025-09-01', 0, 0, 0, 0, 0, 0, 6, 6, 1, 0, 0),
(1006, 48, 'R. Adhi Ilham Prayoga', 'DS045', '2025-09-01', 0, 0, 0, 5, 0, 0, 2, 3, 6, 5, 5),
(1007, 49, 'Rojali', 'DS079', '2025-09-01', 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(1008, 50, 'Santoso Setya Supriyanto, SP', 'DS072', '2025-09-01', 0, 0, 0, 0, 0, 0, 1, 2, 0, 19, 19),
(1009, 51, 'Sapto Wibowo, S.Sos', 'DS011', '2025-09-01', 0, 0, 0, 3, 0, 0, 0, 16, 4, 1, 1),
(1010, 52, 'Septilia Dindasari, S.M.', 'DS005', '2025-09-01', 0, 0, 0, 0, 3, 0, 11, 0, 0, 1, 1),
(1011, 53, 'Sugiatmi', 'DS084', '2025-09-01', 0, 0, 0, 1, 0, 0, 0, 0, 0, 22, 22),
(1012, 54, 'Tita Syafira Maulida', 'DS036', '2025-09-01', 0, 0, 0, 0, 0, 0, 1, 0, 0, 6, 6),
(1013, 55, 'Zalsabila Zanyca, S.M', 'DS019', '2025-09-01', 0, 4, 0, 0, 2, 6, 5, 1, 3, 0, 0),
(1014, 56, 'Anpal Iskalpa PutraA', 'DS030', '2025-09-01', 0, 0, 0, 0, 0, 0, 2, 5, 7, 5, 5),
(1015, 57, 'Hupron, S.Sos', 'DS027', '2025-09-01', 0, 0, 0, 0, 4, 0, 3, 1, 0, 2, 2),
(1016, 58, 'M. Edi Sudrajat', 'DS029', '2025-09-01', 0, 0, 0, 2, 0, 0, 7, 3, 1, 5, 5),
(1017, 59, 'Novel Noberi, S.Kom', 'DS033', '2025-09-01', 0, 0, 0, 2, 0, 0, 1, 3, 0, 6, 6),
(1018, 60, 'Nur. Anugrah Sanusi', 'DS026', '2025-09-01', 0, 0, 0, 4, 0, 0, 4, 3, 5, 4, 4),
(1019, 61, 'R.Pryeska Nusantara.KH, S.Pd', 'DS032', '2025-09-01', 0, 0, 0, 0, 0, 0, 1, 2, 0, 3, 3),
(1020, 62, 'Rahmat Perrianto, ST', 'DS023', '2025-09-01', 0, 0, 0, 2, 0, 0, 0, 1, 0, 16, 16),
(1021, 63, 'Saipulah, SH', 'DS024', '2025-09-01', 0, 0, 0, 2, 6, 0, 1, 3, 0, 8, 8),
(1022, 64, 'Solahudin', 'DS028', '2025-09-01', 0, 0, 0, 1, 0, 0, 4, 4, 2, 2, 2),
(1023, 65, 'Tubagus Iqbal Tawakal', 'DS025', '2025-09-01', 0, 0, 0, 0, 0, 0, 9, 1, 0, 2, 2),
(1024, 66, 'Siti Nurhasanah', 'DS088', '2025-09-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(1025, 67, 'Ade Pandawa', 'DS051', '2025-09-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(1026, 68, 'Herlila Dwi Wahyuni, Amd.Keb', 'DS048', '2025-09-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(1027, 69, 'Ika Mediyanti, S.ST', 'DS046', '2025-09-01', 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(1028, 70, 'Korri Annisa, A.Md,Keb', 'DS049', '2025-09-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(1029, 71, 'NS. Nouva Prana Putra, S.Kep', 'DS050', '2025-09-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(1030, 72, 'Ahmad Tantowi', 'DS075', '2025-09-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(1031, 73, 'Iwan Sutisna', 'DS076', '2025-09-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(1032, 74, 'Suharlan', 'DS074', '2025-09-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(1033, 75, 'Suhendi', 'DS077', '2025-09-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(1034, 76, 'Aditya Firmansyah', 'DS08', '2025-09-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(1035, 77, 'Bebo Karsono', 'DS0', '2025-09-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(1036, 78, 'Dananjaya Satria Kusuma Atmaja', 'DS094', '2025-09-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(1037, 79, 'Dian Iskandar', 'DS099', '2025-09-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(1038, 80, 'Dzulfahmi', 'DS097', '2025-09-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(1039, 81, 'Ninik Samini', 'DS092', '2025-09-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(1040, 82, 'Roni Parulian S.', 'DS093', '2025-09-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(1041, 83, 'Wahyuni', 'DS090', '2025-09-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `absensi_harian`
--

CREATE TABLE `absensi_harian` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nip` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_in` time DEFAULT NULL,
  `jam_out` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(6, 'user', 'user@gmail.com', 'default.jpg', '$2y$10$vZAvNMhdNBJ/WXz47FTUa.stGqRLEfxApXmufTJpMJzmOT8JHIm7.', 2, 1, 1751622872),
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
(2, 'User'),
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
(1, 1, 'Dashboard', 'dashboard', 'fas fa-fw fa-home', 1),
(3, 2, 'My Profile', 'user', 'fas fa-fw fa-user-tie', 1),
(5, 5, 'Menu Management', 'menu', 'fas fa-fw fa-folder', 1),
(7, 5, 'Submenu Management', 'menu/submenu', 'fas fa-fw fa-folder-open', 1),
(14, 1, 'Role', 'admin/role', 'fas fa-fw fa-wrench', 1),
(15, 9, 'Pegawai', 'pegawai', 'fas fa-fw fa-user-tie', 1),
(17, 12, 'Absensi Bulanan', 'absensi', 'fas fa-user-check', 1),
(19, 1, 'Manajemen User', 'admin/manage_user', 'fas fa-fw fa-users', 1),
(20, 10, 'Laporan Rekap', 'absensi/laporan_rekap', 'flaticon-users', 1),
(21, 12, 'Absensi Harian', 'absensi/absen_harian', 'fi fi-rr-attendance-check', 1);

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
-- Indexes for table `absensi_harian`
--
ALTER TABLE `absensi_harian`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1042;

--
-- AUTO_INCREMENT for table `absensi_harian`
--
ALTER TABLE `absensi_harian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
