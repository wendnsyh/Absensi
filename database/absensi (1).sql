-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2025 at 12:13 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `bulan` tinyint(2) DEFAULT NULL,
  `tahun` smallint(4) DEFAULT NULL,
  `jam_in` time DEFAULT NULL,
  `jam_out` time DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  `hari` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absensi_harian`
--

INSERT INTO `absensi_harian` (`id`, `nama`, `nip`, `tanggal`, `bulan`, `tahun`, `jam_in`, `jam_out`, `keterangan`, `hari`) VALUES
(1, 'Nama', '1764760245', '1970-01-01', NULL, NULL, '00:00:00', '00:00:00', NULL, 'Thursday'),
(2, 'Wendy', '1764766901', '1970-01-01', NULL, NULL, '01:00:00', '01:00:00', NULL, 'Thursday'),
(3, 'Lorenza', '1764767117983', '1970-01-01', NULL, NULL, '01:00:00', '01:00:00', NULL, 'Thursday'),
(4, 'Arya', '1764767117539', '1970-01-01', NULL, NULL, '09:41:00', '09:41:00', NULL, 'Thursday'),
(5, 'Tita Syafira Maulida', 'DS036', '1970-01-01', NULL, NULL, '01:00:00', '01:00:00', NULL, 'Thursday'),
(6, 'amanda', '1764767117828', '1970-01-01', NULL, NULL, '01:00:00', '01:00:00', NULL, 'Thursday'),
(7, 'Ghufron', '1764767117175', '1970-01-01', NULL, NULL, '01:00:00', '01:00:00', NULL, 'Thursday'),
(8, 'Alfi', '1764767118557', '1970-01-01', NULL, NULL, '07:14:00', '07:14:00', NULL, 'Thursday'),
(9, 'Hamzami', '1764767118624', '1970-01-01', NULL, NULL, '01:00:00', '01:00:00', NULL, 'Thursday'),
(10, 'marta', '1764767118773', '1970-01-01', NULL, NULL, '16:32:00', '16:32:00', NULL, 'Thursday'),
(11, 'Wendy', '1764766901', '2025-12-01', NULL, NULL, '08:14:00', '16:35:00', 'HADIR', 'Monday'),
(12, 'Wendy', '1764766901', '2025-12-04', NULL, NULL, '07:29:00', '16:32:00', 'HADIR', 'Thursday'),
(13, 'Wendy', '1764766901', '2025-12-05', NULL, NULL, '08:14:00', '18:16:00', 'HADIR', 'Friday'),
(14, 'Wendy', '1764766901', '2025-12-06', NULL, NULL, '10:25:00', '16:18:00', 'HADIR', 'Saturday'),
(15, 'Wendy', '1764766901', '2025-12-07', NULL, NULL, '08:06:00', '16:18:00', 'HADIR', 'Sunday'),
(16, 'Wendy', '1764766901', '2025-12-08', NULL, NULL, '08:30:00', '16:53:00', 'HADIR', 'Monday'),
(17, 'Wendy', '1764766901', '2025-12-11', NULL, NULL, '07:27:00', '16:20:00', 'HADIR', 'Thursday'),
(18, 'Wendy', '1764766901', '2025-12-12', NULL, NULL, '08:26:00', '16:25:00', 'HADIR', 'Friday'),
(19, 'Wendy', '1764766901', '2025-12-13', NULL, NULL, '16:31:00', NULL, 'HADIR', 'Saturday'),
(20, 'Wendy', '1764766901', '2025-12-14', NULL, NULL, '08:41:00', '16:03:00', 'HADIR', 'Sunday'),
(21, 'Wendy', '1764766901', '2025-12-15', NULL, NULL, '08:38:00', '16:39:00', 'HADIR', 'Monday'),
(22, 'Wendy', '1764766901', '2025-12-19', NULL, NULL, '09:21:00', '16:12:00', 'HADIR', 'Friday'),
(23, 'Wendy', '1764766901', '2025-12-20', NULL, NULL, '09:11:00', '16:09:00', 'HADIR', 'Saturday'),
(24, 'Wendy', '1764766901', '2025-12-21', NULL, NULL, '08:01:00', '16:20:00', 'HADIR', 'Sunday'),
(25, 'Wendy', '1764766901', '2025-12-25', NULL, NULL, '07:46:00', '16:16:00', 'HADIR', 'Thursday'),
(26, 'Wendy', '1764766901', '2025-12-26', NULL, NULL, '07:43:00', '16:31:00', 'HADIR', 'Friday'),
(27, 'Wendy', '1764766901', '2025-12-27', NULL, NULL, '07:44:00', '16:17:00', 'HADIR', 'Saturday'),
(28, 'Wendy', '1764766901', '2025-12-28', NULL, NULL, '08:58:00', '16:08:00', 'HADIR', 'Sunday'),
(29, 'Wendy', '1764766901', '2025-12-29', NULL, NULL, '08:05:00', '16:32:00', 'HADIR', 'Monday'),
(30, 'Lorenza', '1764767117983', '2025-12-01', NULL, NULL, '09:27:00', '16:33:00', 'HADIR', 'Monday'),
(31, 'Lorenza', '1764767117983', '2025-12-04', NULL, NULL, '08:44:00', '17:40:00', 'HADIR', 'Thursday'),
(32, 'Lorenza', '1764767117983', '2025-12-06', NULL, NULL, '09:41:00', '16:55:00', 'HADIR', 'Saturday'),
(33, 'Lorenza', '1764767117983', '2025-12-07', NULL, NULL, '09:47:00', '16:17:00', 'HADIR', 'Sunday'),
(34, 'Lorenza', '1764767117983', '2025-12-08', NULL, NULL, '09:59:00', '16:27:00', 'HADIR', 'Monday'),
(35, 'Lorenza', '1764767117983', '2025-12-12', NULL, NULL, '10:20:00', '17:29:00', 'HADIR', 'Friday'),
(36, 'Lorenza', '1764767117983', '2025-12-13', NULL, NULL, '10:22:00', '17:31:00', 'HADIR', 'Saturday'),
(37, 'Lorenza', '1764767117983', '2025-12-14', NULL, NULL, '10:03:00', '16:02:00', 'HADIR', 'Sunday'),
(38, 'Lorenza', '1764767117983', '2025-12-15', NULL, NULL, '10:25:00', '16:26:00', 'HADIR', 'Monday'),
(39, 'Lorenza', '1764767117983', '2025-12-20', NULL, NULL, '10:04:00', '18:36:00', 'HADIR', 'Saturday'),
(40, 'Lorenza', '1764767117983', '2025-12-21', NULL, NULL, '10:30:00', '16:16:00', 'HADIR', 'Sunday'),
(41, 'Lorenza', '1764767117983', '2025-12-25', NULL, NULL, '08:21:00', '16:13:00', 'HADIR', 'Thursday'),
(42, 'Lorenza', '1764767117983', '2025-12-26', NULL, NULL, '08:57:00', '16:16:00', 'HADIR', 'Friday'),
(43, 'Lorenza', '1764767117983', '2025-12-27', NULL, NULL, '09:18:00', '17:46:00', 'HADIR', 'Saturday'),
(44, 'Lorenza', '1764767117983', '2025-12-28', NULL, NULL, '09:11:00', '16:07:00', 'HADIR', 'Sunday'),
(45, 'Lorenza', '1764767117983', '2025-12-29', NULL, NULL, '09:39:00', '16:26:00', 'HADIR', 'Monday'),
(46, 'Arya', '1764767117539', '2025-12-01', NULL, NULL, '09:41:00', NULL, 'HADIR', 'Monday'),
(47, 'Arya', '1764767117539', '2025-12-04', NULL, NULL, '08:34:00', '17:01:00', 'HADIR', 'Thursday'),
(48, 'Arya', '1764767117539', '2025-12-05', NULL, NULL, '08:55:00', '20:01:00', 'HADIR', 'Friday'),
(49, 'Arya', '1764767117539', '2025-12-06', NULL, NULL, '08:45:00', '15:54:00', 'HADIR', 'Saturday'),
(50, 'Arya', '1764767117539', '2025-12-08', NULL, NULL, '09:28:00', '16:54:00', 'HADIR', 'Monday'),
(51, 'Arya', '1764767117539', '2025-12-11', NULL, NULL, '08:14:00', '16:12:00', 'HADIR', 'Thursday'),
(52, 'Arya', '1764767117539', '2025-12-12', NULL, NULL, '08:02:00', '16:26:00', 'HADIR', 'Friday'),
(53, 'Arya', '1764767117539', '2025-12-13', NULL, NULL, '09:05:00', '16:17:00', 'HADIR', 'Saturday'),
(54, 'Arya', '1764767117539', '2025-12-14', NULL, NULL, '13:50:00', '17:44:00', 'HADIR', 'Sunday'),
(55, 'Arya', '1764767117539', '2025-12-15', NULL, NULL, '10:09:00', '16:38:00', 'HADIR', 'Monday'),
(56, 'Arya', '1764767117539', '2025-12-19', NULL, NULL, '16:01:00', NULL, 'HADIR', 'Friday'),
(57, 'Arya', '1764767117539', '2025-12-20', NULL, NULL, '08:59:00', '19:00:00', 'HADIR', 'Saturday'),
(58, 'Arya', '1764767117539', '2025-12-21', NULL, NULL, '09:09:00', '16:15:00', 'HADIR', 'Sunday'),
(59, 'Arya', '1764767117539', '2025-12-22', NULL, NULL, '09:13:00', NULL, 'HADIR', 'Monday'),
(60, 'Arya', '1764767117539', '2025-12-25', NULL, NULL, '08:41:00', '16:53:00', 'HADIR', 'Thursday'),
(61, 'Arya', '1764767117539', '2025-12-26', NULL, NULL, '08:17:00', '18:59:00', 'HADIR', 'Friday'),
(62, 'Arya', '1764767117539', '2025-12-27', NULL, NULL, '08:27:00', '16:28:00', 'HADIR', 'Saturday'),
(63, 'Arya', '1764767117539', '2025-12-28', NULL, NULL, '09:09:00', '16:56:00', 'HADIR', 'Sunday'),
(64, 'Arya', '1764767117539', '2025-12-29', NULL, NULL, '08:45:00', '16:40:00', 'HADIR', 'Monday'),
(65, 'Fira', '1764767117359', '2025-12-01', NULL, NULL, '07:45:00', '16:13:00', 'HADIR', 'Monday'),
(66, 'Fira', '1764767117359', '2025-12-04', NULL, NULL, '17:34:00', NULL, 'HADIR', 'Thursday'),
(67, 'Fira', '1764767117359', '2025-12-05', NULL, NULL, '07:46:00', '17:33:00', 'HADIR', 'Friday'),
(68, 'Fira', '1764767117359', '2025-12-06', NULL, NULL, '07:45:00', NULL, 'HADIR', 'Saturday'),
(69, 'Fira', '1764767117359', '2025-12-08', NULL, NULL, '07:58:00', '14:57:00', 'HADIR', 'Monday'),
(70, 'Fira', '1764767117359', '2025-12-11', NULL, NULL, '08:34:00', '16:09:00', 'HADIR', 'Thursday'),
(71, 'Fira', '1764767117359', '2025-12-12', NULL, NULL, '07:53:00', '16:14:00', 'HADIR', 'Friday'),
(72, 'Fira', '1764767117359', '2025-12-13', NULL, NULL, '08:03:00', '16:03:00', 'HADIR', 'Saturday'),
(73, 'Fira', '1764767117359', '2025-12-14', NULL, NULL, '07:54:00', '16:28:00', 'HADIR', 'Sunday'),
(74, 'Fira', '1764767117359', '2025-12-15', NULL, NULL, '08:01:00', '17:18:00', 'HADIR', 'Monday'),
(75, 'Fira', '1764767117359', '2025-12-19', NULL, NULL, '07:54:00', '16:20:00', 'HADIR', 'Friday'),
(76, 'Fira', '1764767117359', '2025-12-20', NULL, NULL, '07:33:00', NULL, 'HADIR', 'Saturday'),
(77, 'Fira', '1764767117359', '2025-12-21', NULL, NULL, '07:57:00', '16:32:00', 'HADIR', 'Sunday'),
(78, 'Fira', '1764767117359', '2025-12-25', NULL, NULL, '07:56:00', '19:18:00', 'HADIR', 'Thursday'),
(79, 'Fira', '1764767117359', '2025-12-26', NULL, NULL, '08:02:00', '17:02:00', 'HADIR', 'Friday'),
(80, 'Fira', '1764767117359', '2025-12-27', NULL, NULL, '08:14:00', '17:17:00', 'HADIR', 'Saturday'),
(81, 'Fira', '1764767117359', '2025-12-28', NULL, NULL, '07:40:00', '16:00:00', 'HADIR', 'Sunday'),
(82, 'Fira', '1764767117359', '2025-12-29', NULL, NULL, '07:40:00', NULL, 'HADIR', 'Monday'),
(83, 'amanda', '1764767117828', '2025-12-01', NULL, NULL, '07:04:00', '18:52:00', 'HADIR', 'Monday'),
(84, 'amanda', '1764767117828', '2025-12-04', NULL, NULL, '07:04:00', '16:57:00', 'HADIR', 'Thursday'),
(85, 'amanda', '1764767117828', '2025-12-05', NULL, NULL, '07:15:00', '17:32:00', 'HADIR', 'Friday'),
(86, 'amanda', '1764767117828', '2025-12-06', NULL, NULL, '07:10:00', '17:39:00', 'HADIR', 'Saturday'),
(87, 'amanda', '1764767117828', '2025-12-07', NULL, NULL, '07:15:00', '16:42:00', 'HADIR', 'Sunday'),
(88, 'amanda', '1764767117828', '2025-12-08', NULL, NULL, '07:13:00', '16:34:00', 'HADIR', 'Monday'),
(89, 'amanda', '1764767117828', '2025-12-12', NULL, NULL, '07:10:00', '16:06:00', 'HADIR', 'Friday'),
(90, 'amanda', '1764767117828', '2025-12-13', NULL, NULL, '07:07:00', '16:03:00', 'HADIR', 'Saturday'),
(91, 'amanda', '1764767117828', '2025-12-14', NULL, NULL, '07:00:00', '16:30:00', 'HADIR', 'Sunday'),
(92, 'amanda', '1764767117828', '2025-12-15', NULL, NULL, '07:04:00', '17:28:00', 'HADIR', 'Monday'),
(93, 'amanda', '1764767117828', '2025-12-19', NULL, NULL, '08:06:00', NULL, 'HADIR', 'Friday'),
(94, 'amanda', '1764767117828', '2025-12-20', NULL, NULL, '07:26:00', NULL, 'HADIR', 'Saturday'),
(95, 'amanda', '1764767117828', '2025-12-21', NULL, NULL, '07:11:00', '17:35:00', 'HADIR', 'Sunday'),
(96, 'amanda', '1764767117828', '2025-12-22', NULL, NULL, '06:56:00', NULL, 'HADIR', 'Monday'),
(97, 'amanda', '1764767117828', '2025-12-25', NULL, NULL, '07:20:00', '19:17:00', 'HADIR', 'Thursday'),
(98, 'amanda', '1764767117828', '2025-12-26', NULL, NULL, '07:05:00', '16:33:00', 'HADIR', 'Friday'),
(99, 'amanda', '1764767117828', '2025-12-27', NULL, NULL, '07:02:00', '17:12:00', 'HADIR', 'Saturday'),
(100, 'amanda', '1764767117828', '2025-12-28', NULL, NULL, '06:58:00', '16:06:00', 'HADIR', 'Sunday'),
(101, 'amanda', '1764767117828', '2025-12-29', NULL, NULL, '07:09:00', '20:01:00', 'HADIR', 'Monday'),
(102, 'Ghufron', '1764767117175', '2025-12-01', NULL, NULL, '08:48:00', '18:53:00', 'HADIR', 'Monday'),
(103, 'Ghufron', '1764767117175', '2025-12-04', NULL, NULL, '07:15:00', '17:38:00', 'HADIR', 'Thursday'),
(104, 'Ghufron', '1764767117175', '2025-12-05', NULL, NULL, '17:19:00', NULL, 'HADIR', 'Friday'),
(105, 'Ghufron', '1764767117175', '2025-12-06', NULL, NULL, '08:04:00', '17:04:00', 'HADIR', 'Saturday'),
(106, 'Ghufron', '1764767117175', '2025-12-07', NULL, NULL, '08:19:00', '16:42:00', 'HADIR', 'Sunday'),
(107, 'Ghufron', '1764767117175', '2025-12-08', NULL, NULL, '16:41:00', NULL, 'HADIR', 'Monday'),
(108, 'Ghufron', '1764767117175', '2025-12-11', NULL, NULL, '07:30:00', '20:03:00', 'HADIR', 'Thursday'),
(109, 'Ghufron', '1764767117175', '2025-12-12', NULL, NULL, '08:17:00', '16:13:00', 'HADIR', 'Friday'),
(110, 'Ghufron', '1764767117175', '2025-12-13', NULL, NULL, '07:36:00', '16:22:00', 'HADIR', 'Saturday'),
(111, 'Ghufron', '1764767117175', '2025-12-14', NULL, NULL, '08:00:00', '16:38:00', 'HADIR', 'Sunday'),
(112, 'Ghufron', '1764767117175', '2025-12-15', NULL, NULL, '09:37:00', '17:23:00', 'HADIR', 'Monday'),
(113, 'Ghufron', '1764767117175', '2025-12-19', NULL, NULL, '08:03:00', '15:23:00', 'HADIR', 'Friday'),
(114, 'Ghufron', '1764767117175', '2025-12-20', NULL, NULL, '07:37:00', '20:17:00', 'HADIR', 'Saturday'),
(115, 'Ghufron', '1764767117175', '2025-12-21', NULL, NULL, '08:36:00', '16:32:00', 'HADIR', 'Sunday'),
(116, 'Ghufron', '1764767117175', '2025-12-25', NULL, NULL, '07:20:00', '19:56:00', 'HADIR', 'Thursday'),
(117, 'Ghufron', '1764767117175', '2025-12-26', NULL, NULL, '17:23:00', NULL, 'HADIR', 'Friday'),
(118, 'Ghufron', '1764767117175', '2025-12-27', NULL, NULL, '08:17:00', '16:33:00', 'HADIR', 'Saturday'),
(119, 'Ghufron', '1764767117175', '2025-12-28', NULL, NULL, '08:10:00', NULL, 'HADIR', 'Sunday'),
(120, 'Ghufron', '1764767117175', '2025-12-29', NULL, NULL, '08:33:00', '16:25:00', 'HADIR', 'Monday'),
(121, 'Alfi', '1764767118557', '2025-12-01', NULL, NULL, '07:14:00', NULL, 'HADIR', 'Monday'),
(122, 'Alfi', '1764767118557', '2025-12-04', NULL, NULL, '07:08:00', '18:47:00', 'HADIR', 'Thursday'),
(123, 'Alfi', '1764767118557', '2025-12-05', NULL, NULL, '07:27:00', '17:49:00', 'HADIR', 'Friday'),
(124, 'Alfi', '1764767118557', '2025-12-06', NULL, NULL, '07:34:00', '17:47:00', 'HADIR', 'Saturday'),
(125, 'Alfi', '1764767118557', '2025-12-07', NULL, NULL, '07:32:00', '18:45:00', 'HADIR', 'Sunday'),
(126, 'Alfi', '1764767118557', '2025-12-08', NULL, NULL, '07:58:00', '18:50:00', 'HADIR', 'Monday'),
(127, 'Alfi', '1764767118557', '2025-12-11', NULL, NULL, '06:51:00', '17:17:00', 'HADIR', 'Thursday'),
(128, 'Alfi', '1764767118557', '2025-12-12', NULL, NULL, '06:53:00', '19:20:00', 'HADIR', 'Friday'),
(129, 'Alfi', '1764767118557', '2025-12-13', NULL, NULL, '07:37:00', '18:49:00', 'HADIR', 'Saturday'),
(130, 'Alfi', '1764767118557', '2025-12-14', NULL, NULL, '07:10:00', '19:00:00', 'HADIR', 'Sunday'),
(131, 'Alfi', '1764767118557', '2025-12-15', NULL, NULL, '07:03:00', '17:30:00', 'HADIR', 'Monday'),
(132, 'Alfi', '1764767118557', '2025-12-19', NULL, NULL, '07:40:00', '16:45:00', 'HADIR', 'Friday'),
(133, 'Alfi', '1764767118557', '2025-12-20', NULL, NULL, '07:40:00', '19:37:00', 'HADIR', 'Saturday'),
(134, 'Alfi', '1764767118557', '2025-12-21', NULL, NULL, '07:39:00', '17:12:00', 'HADIR', 'Sunday'),
(135, 'Alfi', '1764767118557', '2025-12-22', NULL, NULL, '19:49:00', NULL, 'HADIR', 'Monday'),
(136, 'Alfi', '1764767118557', '2025-12-25', NULL, NULL, '07:19:00', '18:41:00', 'HADIR', 'Thursday'),
(137, 'Alfi', '1764767118557', '2025-12-26', NULL, NULL, '07:37:00', '18:31:00', 'HADIR', 'Friday'),
(138, 'Alfi', '1764767118557', '2025-12-27', NULL, NULL, '07:25:00', '17:01:00', 'HADIR', 'Saturday'),
(139, 'Alfi', '1764767118557', '2025-12-28', NULL, NULL, '07:48:00', '17:36:00', 'HADIR', 'Sunday'),
(140, 'Alfi', '1764767118557', '2025-12-29', NULL, NULL, '07:32:00', '17:22:00', 'HADIR', 'Monday'),
(141, 'Hamzami', '1764767118624', '2025-12-01', NULL, NULL, '09:36:00', '17:07:00', 'HADIR', 'Monday'),
(142, 'Hamzami', '1764767118624', '2025-12-04', NULL, NULL, '13:06:00', '18:47:00', 'HADIR', 'Thursday'),
(143, 'Hamzami', '1764767118624', '2025-12-05', NULL, NULL, '07:52:00', '17:49:00', 'HADIR', 'Friday'),
(144, 'Hamzami', '1764767118624', '2025-12-06', NULL, NULL, '07:54:00', '17:15:00', 'HADIR', 'Saturday'),
(145, 'Hamzami', '1764767118624', '2025-12-07', NULL, NULL, '09:56:00', '18:45:00', 'HADIR', 'Sunday'),
(146, 'Hamzami', '1764767118624', '2025-12-08', NULL, NULL, '07:59:00', '18:50:00', 'HADIR', 'Monday'),
(147, 'Hamzami', '1764767118624', '2025-12-11', NULL, NULL, '07:44:00', '17:17:00', 'HADIR', 'Thursday'),
(148, 'Hamzami', '1764767118624', '2025-12-12', NULL, NULL, '07:26:00', '19:21:00', 'HADIR', 'Friday'),
(149, 'Hamzami', '1764767118624', '2025-12-13', NULL, NULL, '08:49:00', '18:49:00', 'HADIR', 'Saturday'),
(150, 'Hamzami', '1764767118624', '2025-12-14', NULL, NULL, '07:54:00', '19:00:00', 'HADIR', 'Sunday'),
(151, 'Hamzami', '1764767118624', '2025-12-15', NULL, NULL, '11:00:00', '17:30:00', 'HADIR', 'Monday'),
(152, 'Hamzami', '1764767118624', '2025-12-19', NULL, NULL, '08:41:00', '16:45:00', 'HADIR', 'Friday'),
(153, 'Hamzami', '1764767118624', '2025-12-20', NULL, NULL, '07:47:00', '19:38:00', 'HADIR', 'Saturday'),
(154, 'Hamzami', '1764767118624', '2025-12-21', NULL, NULL, '07:55:00', '17:13:00', 'HADIR', 'Sunday'),
(155, 'Hamzami', '1764767118624', '2025-12-22', NULL, NULL, '18:52:00', '18:55:00', 'HADIR', 'Monday'),
(156, 'Hamzami', '1764767118624', '2025-12-25', NULL, NULL, '07:33:00', '18:41:00', 'HADIR', 'Thursday'),
(157, 'Hamzami', '1764767118624', '2025-12-26', NULL, NULL, '07:43:00', '18:31:00', 'HADIR', 'Friday'),
(158, 'Hamzami', '1764767118624', '2025-12-27', NULL, NULL, '07:55:00', '17:00:00', 'HADIR', 'Saturday'),
(159, 'Hamzami', '1764767118624', '2025-12-28', NULL, NULL, '08:32:00', '17:36:00', 'HADIR', 'Sunday'),
(160, 'Hamzami', '1764767118624', '2025-12-29', NULL, NULL, '11:36:00', '17:22:00', 'HADIR', 'Monday'),
(161, 'marta', '1764767118773', '2025-12-01', NULL, NULL, '16:32:00', NULL, 'HADIR', 'Monday'),
(162, 'marta', '1764767118773', '2025-12-04', NULL, NULL, '07:11:00', '18:38:00', 'HADIR', 'Thursday'),
(163, 'marta', '1764767118773', '2025-12-05', NULL, NULL, '08:07:00', '17:07:00', 'HADIR', 'Friday'),
(164, 'marta', '1764767118773', '2025-12-06', NULL, NULL, '07:37:00', '16:10:00', 'HADIR', 'Saturday'),
(165, 'marta', '1764767118773', '2025-12-07', NULL, NULL, '08:15:00', '16:15:00', 'HADIR', 'Sunday'),
(166, 'marta', '1764767118773', '2025-12-08', NULL, NULL, '07:46:00', '16:46:00', 'HADIR', 'Monday'),
(167, 'marta', '1764767118773', '2025-12-11', NULL, NULL, '09:21:00', '17:10:00', 'HADIR', 'Thursday'),
(168, 'marta', '1764767118773', '2025-12-12', NULL, NULL, '07:19:00', '16:20:00', 'HADIR', 'Friday'),
(169, 'marta', '1764767118773', '2025-12-13', NULL, NULL, '07:18:00', '16:27:00', 'HADIR', 'Saturday'),
(170, 'marta', '1764767118773', '2025-12-14', NULL, NULL, '07:52:00', NULL, 'HADIR', 'Sunday'),
(171, 'marta', '1764767118773', '2025-12-15', NULL, NULL, '08:54:00', '17:03:00', 'HADIR', 'Monday'),
(172, 'marta', '1764767118773', '2025-12-19', NULL, NULL, '07:56:00', '16:47:00', 'HADIR', 'Friday'),
(173, 'marta', '1764767118773', '2025-12-20', NULL, NULL, '07:47:00', '16:54:00', 'HADIR', 'Saturday'),
(174, 'marta', '1764767118773', '2025-12-21', NULL, NULL, '07:33:00', '16:32:00', 'HADIR', 'Sunday'),
(175, 'marta', '1764767118773', '2025-12-25', NULL, NULL, '16:03:00', NULL, 'HADIR', 'Thursday'),
(176, 'marta', '1764767118773', '2025-12-26', NULL, NULL, '08:04:00', '16:13:00', 'HADIR', 'Friday'),
(177, 'marta', '1764767118773', '2025-12-27', NULL, NULL, '07:27:00', '16:11:00', 'HADIR', 'Saturday'),
(178, 'marta', '1764767118773', '2025-12-28', NULL, NULL, '08:21:00', '16:04:00', 'HADIR', 'Sunday');

-- --------------------------------------------------------

--
-- Table structure for table `bobot`
--

CREATE TABLE `bobot` (
  `id` int(11) NOT NULL,
  `hari_kerja` float DEFAULT 0.5,
  `skills` float DEFAULT 0.3,
  `attitude` float DEFAULT 0.2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bobot`
--

INSERT INTO `bobot` (`id`, `hari_kerja`, `skills`, `attitude`) VALUES
(1, 0.5, 0.4, 0.1),
(2, 40, 30, 30);

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE `divisi` (
  `id_divisi` int(11) NOT NULL,
  `nama_divisi` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `divisi`
--

INSERT INTO `divisi` (`id_divisi`, `nama_divisi`, `created_at`) VALUES
(1, 'Linjamsos', '2025-11-21 13:59:54'),
(2, 'Rehabsos', '2025-11-24 13:00:04'),
(3, 'Dayasos', '2025-11-24 13:00:11'),
(6, 'Sekretariat', '2025-11-24 13:00:32');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id_pegawai` int(11) NOT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `nama_pegawai` varchar(100) DEFAULT NULL,
  `id_divisi` int(11) DEFAULT NULL,
  `divisi` varchar(100) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `status_aktif` enum('aktif','nonaktif') DEFAULT 'aktif',
  `tanggal_dibuat` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id_pegawai`, `nip`, `nama_pegawai`, `id_divisi`, `divisi`, `jabatan`, `status_aktif`, `tanggal_dibuat`) VALUES
(1, 'DS043', 'Abdul Mait, S.E', 1, NULL, NULL, 'aktif', '2025-11-16 19:51:49'),
(2, 'DS041', 'Ade Irmayanti', 6, NULL, NULL, 'aktif', '2025-11-16 19:51:49'),
(3, 'DS010', 'Adi Mulyanto, SE', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:49'),
(4, 'DS098', 'Agus Nurcahyo, S.Kom', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:49'),
(5, 'DS002', 'Ahmad Kandiaz, S.H', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:49'),
(6, 'DS063', 'Ahmad Rinduwan', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:49'),
(7, 'DS058', 'Ahmad Sopian, S.E', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:49'),
(8, 'DS083', 'Alinah', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:49'),
(9, 'DS069', 'Andriani Prayuda, S.M', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:49'),
(10, 'DS017', 'Anggriyani Daulay, S.Kom', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:49'),
(11, 'DS060', 'Annisa Ameliasyari', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:49'),
(12, 'DS009', 'Ari Ardiansah', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:49'),
(13, 'DS020', 'Ari Widiastuti, A.Md', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:49'),
(14, 'DS031', 'Azis Fadhillah, S.H', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:49'),
(15, 'DS070', 'Burhanudin Jaelani Ibnu Ruslan', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:49'),
(16, 'DS054', 'Darmendra Febrianto, S.E', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:49'),
(17, 'DS071', 'Desy Wijiyanti, S.Kom.', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:49'),
(18, 'DS078', 'Dwi Fajar', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:49'),
(19, 'DS086', 'Dwi Wahyuningsih', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:49'),
(20, 'DS042', 'Eroh Rohayati, S.Kom', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:49'),
(21, 'DS006', 'Erry Eka Pratama', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(22, 'DS066', 'Fahmi Angga Yudha, A.Md', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(23, 'DS053', 'Hasan Basri,S.AP', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(24, 'DS056', 'Hindawan Yuniar, S.I.Kom', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(25, 'DS022', 'Iis Afriyanti, A.Md', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(26, 'DS061', 'Ikhwan Adi Putra', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(27, 'DS081', 'Ilham Nurudin', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(28, 'DS037', 'Irmawati, S.M.', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(29, 'DS085', 'Isgiantoro', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(30, 'DS021', 'Istiqomah Aisyiyah, S.Sos', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(31, 'DS062', 'Istiyar Iman Aldriansyah, S.Kom', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(32, 'DS064', 'Laras Tyas Ayu Pramudya, S.KM', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(33, 'DS013', 'Leo Wahyudi, S.H', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(34, 'DS065', 'Lilis Suryani, S.E', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(35, 'DS059', 'Linda Amalia,S.Psi', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(36, 'DS039', 'Mariyah, S.E', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(37, 'DS004', 'Mawaddah Khalisah, S.E.', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(38, 'DS015', 'Methatia Cahya, S.H', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(39, 'DS067', 'Muhamad Rizki', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(40, 'DS016', 'Nadya Ayu Permatasari, S.Sos', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(41, 'DS007', 'Nia Lestari, A.Md', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(42, 'DS012', 'Nico Reynold Adiputro', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(43, 'DS040', 'Niko Septian Hadi, S.Kom', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(44, 'DS052', 'Novanta Nur Syabana', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(45, 'DS003', 'Nurlaela, S.E', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(46, 'DS057', 'Nurlia Oktaviani, S.M', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(47, 'DS038', 'Pebri Perdana, S.AP', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(48, 'DS045', 'R. Adhi Ilham Prayoga', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(49, 'DS079', 'Rojali', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(50, 'DS072', 'Santoso Setya Supriyanto, SP', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(51, 'DS011', 'Sapto Wibowo, S.Sos', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(52, 'DS005', 'Septilia Dindasari, S.M.', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(53, 'DS084', 'Sugiatmi', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(54, 'DS036', 'Tita Syafira Maulida', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(55, 'DS019', 'Zalsabila Zanyca, S.M', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(56, 'DS030', 'Anpal Iskalpa PutraA', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(57, 'DS027', 'Hupron, S.Sos', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(58, 'DS029', 'M. Edi Sudrajat', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(59, 'DS033', 'Novel Noberi, S.Kom', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(60, 'DS026', 'Nur. Anugrah Sanusi', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(61, 'DS032', 'R.Pryeska Nusantara.KH, S.Pd', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(62, 'DS023', 'Rahmat Perrianto, ST', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(63, 'DS024', 'Saipulah, SH', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(64, 'DS028', 'Solahudin', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(65, 'DS025', 'Tubagus Iqbal Tawakal', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(66, 'DS088', 'Siti Nurhasanah', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(67, 'DS051', 'Ade Pandawa', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(68, 'DS048', 'Herlila Dwi Wahyuni, Amd.Keb', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(69, 'DS046', 'Ika Mediyanti, S.ST', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(70, 'DS049', 'Korri Annisa, A.Md,Keb', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(71, 'DS050', 'NS. Nouva Prana Putra, S.Kep', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(72, 'DS075', 'Ahmad Tantowi', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(73, 'DS076', 'Iwan Sutisna', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(74, 'DS074', 'Suharlan', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(75, 'DS077', 'Suhendi', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(76, 'DS08', 'Aditya Firmansyah', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(77, 'DS0', 'Bebo Karsono', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(78, 'DS094', 'Dananjaya Satria Kusuma Atmaja', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(79, 'DS099', 'Dian Iskandar', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(80, 'DS097', 'Dzulfahmi', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(81, 'DS092', 'Ninik Samini', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(82, 'DS093', 'Roni Parulian S.', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(83, 'DS090', 'Wahyuni', NULL, NULL, NULL, 'aktif', '2025-11-16 19:51:50'),
(84, '1764759661', 'DINAS SOSIAL', NULL, NULL, NULL, 'aktif', '2025-12-03 18:01:01'),
(85, '1764760245', 'Nama', NULL, NULL, NULL, 'aktif', '2025-12-03 18:10:45'),
(86, '1764766860', 'Najdah', NULL, NULL, NULL, 'aktif', '2025-12-03 20:01:00'),
(87, '1764766901', 'Wendy', NULL, NULL, NULL, 'aktif', '2025-12-03 20:01:41'),
(88, '1764767117983', 'Lorenza', NULL, NULL, NULL, 'aktif', '2025-12-03 20:05:17'),
(89, '1764767117539', 'Arya', NULL, NULL, NULL, 'aktif', '2025-12-03 20:05:17'),
(90, '1764767117359', 'Fira', NULL, NULL, NULL, 'aktif', '2025-12-03 20:05:17'),
(91, '1764767117828', 'amanda', NULL, NULL, NULL, 'aktif', '2025-12-03 20:05:17'),
(92, '1764767117175', 'Ghufron', NULL, NULL, NULL, 'aktif', '2025-12-03 20:05:17'),
(93, '1764767118557', 'Alfi', NULL, NULL, NULL, 'aktif', '2025-12-03 20:05:18'),
(94, '1764767118624', 'Hamzami', NULL, NULL, NULL, 'aktif', '2025-12-03 20:05:18'),
(95, '1764767118773', 'marta', NULL, NULL, NULL, 'aktif', '2025-12-03 20:05:18'),
(96, 'DINAS SOSIAL', 'Hamzami', NULL, NULL, NULL, 'aktif', '2025-12-03 20:12:12'),
(97, '1764779331', 'Alifah', NULL, NULL, NULL, 'aktif', '2025-12-03 23:28:51');

-- --------------------------------------------------------

--
-- Table structure for table `penilaian_karyawan`
--

CREATE TABLE `penilaian_karyawan` (
  `id_penilaian` int(11) NOT NULL,
  `id_pegawai` int(11) DEFAULT NULL,
  `nip` varchar(50) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `attitude` float DEFAULT 0,
  `skills` float DEFAULT 0,
  `total_nilai` float NOT NULL,
  `hari_kerja` int(11) NOT NULL,
  `tanggal_input` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `bulan` int(11) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `periode_type` enum('monthly','quarterly','semester','yearly') NOT NULL DEFAULT 'monthly',
  `periode_key` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penilaian_karyawan`
--

INSERT INTO `penilaian_karyawan` (`id_penilaian`, `id_pegawai`, `nip`, `nama`, `attitude`, `skills`, `total_nilai`, `hari_kerja`, `tanggal_input`, `bulan`, `tahun`, `created_at`, `periode_type`, `periode_key`) VALUES
(1, 1, 'DS043', NULL, 90, 90, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(2, 2, 'DS041', NULL, 0, 0, 0, 0, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(3, 67, 'DS051', NULL, 0, 0, 0, 0, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(4, 3, 'DS010', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(5, 76, 'DS08', NULL, 0, 0, 0, 0, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(6, 4, 'DS098', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(7, 5, 'DS002', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(8, 6, 'DS063', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(9, 7, 'DS058', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(10, 72, 'DS075', NULL, 0, 0, 0, 0, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(11, 8, 'DS083', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(12, 9, 'DS069', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(13, 10, 'DS017', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(14, 11, 'DS060', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(15, 56, 'DS030', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(16, 12, 'DS009', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(17, 13, 'DS020', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(18, 14, 'DS031', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(19, 77, 'DS0', NULL, 0, 0, 0, 0, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(20, 15, 'DS070', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(21, 78, 'DS094', NULL, 0, 0, 0, 0, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(22, 16, 'DS054', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(23, 17, 'DS071', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(24, 79, 'DS099', NULL, 0, 0, 0, 0, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(25, 18, 'DS078', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(26, 19, 'DS086', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(27, 80, 'DS097', NULL, 0, 0, 0, 0, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(28, 20, 'DS042', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(29, 21, 'DS006', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(30, 22, 'DS066', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(31, 23, 'DS053', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(32, 68, 'DS048', NULL, 0, 0, 0, 0, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(33, 24, 'DS056', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(34, 57, 'DS027', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(35, 25, 'DS022', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(36, 69, 'DS046', NULL, 0, 0, 0, 0, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(37, 26, 'DS061', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(38, 27, 'DS081', NULL, 0, 0, 0, 0, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(39, 28, 'DS037', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(40, 29, 'DS085', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(41, 30, 'DS021', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(42, 31, 'DS062', NULL, 0, 0, 0, 0, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(43, 73, 'DS076', NULL, 0, 0, 0, 0, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(44, 70, 'DS049', NULL, 0, 0, 0, 0, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(45, 32, 'DS064', NULL, 0, 0, 0, 0, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(46, 33, 'DS013', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(47, 34, 'DS065', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(48, 35, 'DS059', NULL, 0, 0, 0, 0, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(49, 58, 'DS029', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(50, 36, 'DS039', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(51, 37, 'DS004', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(52, 38, 'DS015', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(53, 39, 'DS067', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(54, 40, 'DS016', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(55, 41, 'DS007', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(56, 42, 'DS012', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(57, 43, 'DS040', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(58, 81, 'DS092', NULL, 0, 0, 0, 0, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(59, 44, 'DS052', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(60, 59, 'DS033', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(61, 71, 'DS050', NULL, 0, 0, 0, 0, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(62, 60, 'DS026', NULL, 0, 0, 0, 0, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(63, 45, 'DS003', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(64, 46, 'DS057', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(65, 47, 'DS038', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(66, 48, 'DS045', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(67, 61, 'DS032', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(68, 62, 'DS023', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(69, 49, 'DS079', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(70, 82, 'DS093', NULL, 0, 0, 0, 0, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(71, 63, 'DS024', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(72, 50, 'DS072', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(73, 51, 'DS011', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(74, 52, 'DS005', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(75, 66, 'DS088', NULL, 0, 0, 0, 0, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(76, 64, 'DS028', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(77, 53, 'DS084', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(78, 74, 'DS074', NULL, 0, 0, 0, 0, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(79, 75, 'DS077', NULL, 0, 0, 0, 0, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(80, 54, 'DS036', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(81, 65, 'DS025', NULL, 0, 0, 0, 1, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(82, 83, 'DS090', NULL, 0, 0, 0, 0, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(83, 55, 'DS019', NULL, 0, 0, 0, 0, '2025-12-02 13:46:38', NULL, NULL, '2025-12-02 20:46:38', 'monthly', '2025-07'),
(84, 1, 'DS043', NULL, 90, 90, 0, 22, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(85, 2, 'DS041', NULL, 0, 90, 0, 0, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(86, 67, 'DS051', NULL, 0, 0, 0, 0, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(87, 3, 'DS010', NULL, 0, 0, 0, 22, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(88, 76, 'DS08', NULL, 0, 0, 0, 0, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(89, 4, 'DS098', NULL, 0, 0, 0, 22, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(90, 5, 'DS002', NULL, 0, 0, 0, 22, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(91, 6, 'DS063', NULL, 0, 0, 0, 20, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(92, 7, 'DS058', NULL, 0, 0, 0, 22, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(93, 72, 'DS075', NULL, 0, 0, 0, 0, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(94, 8, 'DS083', NULL, 0, 0, 0, 22, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(95, 9, 'DS069', NULL, 0, 0, 0, 18, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(96, 10, 'DS017', NULL, 0, 0, 0, 19, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(97, 11, 'DS060', NULL, 0, 0, 0, 22, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(98, 56, 'DS030', NULL, 0, 0, 0, 22, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(99, 12, 'DS009', NULL, 0, 0, 0, 14, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(100, 13, 'DS020', NULL, 0, 0, 0, 19, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(101, 14, 'DS031', NULL, 0, 0, 0, 17, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(102, 77, 'DS0', NULL, 0, 0, 0, 0, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(103, 15, 'DS070', NULL, 0, 0, 0, 18, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(104, 78, 'DS094', NULL, 0, 0, 0, 0, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(105, 16, 'DS054', NULL, 0, 0, 0, 22, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(106, 17, 'DS071', NULL, 0, 0, 0, 22, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(107, 79, 'DS099', NULL, 0, 0, 0, 0, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(108, 18, 'DS078', NULL, 0, 0, 0, 21, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(109, 19, 'DS086', NULL, 0, 0, 0, 9, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(110, 80, 'DS097', NULL, 0, 0, 0, 0, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(111, 20, 'DS042', NULL, 0, 0, 0, 22, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(112, 21, 'DS006', NULL, 0, 0, 0, 20, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(113, 22, 'DS066', NULL, 0, 0, 0, 21, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(114, 23, 'DS053', NULL, 0, 0, 0, 21, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(115, 68, 'DS048', NULL, 0, 0, 0, 0, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(116, 24, 'DS056', NULL, 0, 0, 0, 18, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(117, 57, 'DS027', NULL, 0, 0, 0, 18, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(118, 25, 'DS022', NULL, 0, 0, 0, 20, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(119, 69, 'DS046', NULL, 0, 0, 0, 12, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(120, 26, 'DS061', NULL, 0, 0, 0, 14, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(121, 27, 'DS081', NULL, 0, 0, 0, 18, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(122, 28, 'DS037', NULL, 0, 0, 0, 19, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(123, 29, 'DS085', NULL, 0, 0, 0, 18, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(124, 30, 'DS021', NULL, 0, 0, 0, 22, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(125, 31, 'DS062', NULL, 0, 0, 0, 19, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(126, 73, 'DS076', NULL, 0, 0, 0, 0, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(127, 70, 'DS049', NULL, 0, 0, 0, 0, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(128, 32, 'DS064', NULL, 0, 0, 0, 11, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(129, 33, 'DS013', NULL, 0, 0, 0, 22, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(130, 34, 'DS065', NULL, 0, 0, 0, 9, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(131, 35, 'DS059', NULL, 0, 0, 0, 15, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(132, 58, 'DS029', NULL, 0, 0, 0, 20, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(133, 36, 'DS039', NULL, 0, 0, 0, 21, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(134, 37, 'DS004', NULL, 0, 0, 0, 17, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(135, 38, 'DS015', NULL, 0, 0, 0, 22, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(136, 39, 'DS067', NULL, 0, 0, 0, 12, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(137, 40, 'DS016', NULL, 0, 0, 0, 20, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(138, 41, 'DS007', NULL, 0, 0, 0, 21, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(139, 42, 'DS012', NULL, 0, 0, 0, 21, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(140, 43, 'DS040', NULL, 0, 0, 0, 22, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(141, 81, 'DS092', NULL, 0, 0, 0, 0, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(142, 44, 'DS052', NULL, 0, 0, 0, 18, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(143, 59, 'DS033', NULL, 0, 0, 0, 20, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(144, 71, 'DS050', NULL, 0, 0, 0, 0, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(145, 60, 'DS026', NULL, 0, 0, 0, 18, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(146, 45, 'DS003', NULL, 0, 0, 0, 20, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(147, 46, 'DS057', NULL, 0, 0, 0, 19, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(148, 47, 'DS038', NULL, 0, 0, 0, 20, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(149, 48, 'DS045', NULL, 0, 0, 0, 17, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(150, 61, 'DS032', NULL, 0, 0, 0, 22, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(151, 62, 'DS023', NULL, 0, 0, 0, 20, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(152, 49, 'DS079', NULL, 0, 0, 0, 24, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(153, 82, 'DS093', NULL, 0, 0, 0, 0, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(154, 63, 'DS024', NULL, 0, 0, 0, 14, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(155, 50, 'DS072', NULL, 0, 0, 0, 22, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(156, 51, 'DS011', NULL, 0, 0, 0, 19, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(157, 52, 'DS005', NULL, 0, 0, 0, 19, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(158, 66, 'DS088', NULL, 0, 0, 0, 0, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(159, 64, 'DS028', NULL, 0, 0, 0, 21, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(160, 53, 'DS084', NULL, 0, 0, 0, 21, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(161, 74, 'DS074', NULL, 0, 0, 0, 0, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(162, 75, 'DS077', NULL, 0, 0, 0, 0, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(163, 54, 'DS036', NULL, 0, 0, 0, 22, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(164, 65, 'DS025', NULL, 0, 0, 0, 22, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(165, 83, 'DS090', NULL, 0, 0, 0, 0, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1'),
(166, 55, 'DS019', NULL, 0, 0, 0, 10, '2025-12-03 09:31:44', NULL, NULL, '2025-12-03 16:31:44', 'semester', '2025-S1');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `image`, `password`, `role_id`, `is_active`, `date_created`) VALUES
(5, 'Super Admin', 'superadmin@gmail.com', 'people-holding-hands-dark-skin-tone-svgrepo-com.png', '$2y$10$gOUmr/zVsc3HhaCa3Jxz1uIC5IOF6QtIEiBeAcrogU1ThW2xnzweW', 1, 1, 1751614988),
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(20, 2, 12),
(23, 1, 13);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'Admin'),
(2, 'User'),
(5, 'Menu'),
(9, 'Master Data'),
(10, 'Laporan'),
(12, 'Absensi'),
(13, 'Saw');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(21, 12, 'Absensi Harian', 'absensi/absen_harian', 'fas fa-clipboard-list', 1),
(22, 13, 'Bobot', 'saw/bobot', 'fas fa-sliders-h nav-icon', 1),
(23, 13, 'Hasil Penilaian', 'saw', 'fas fa-chart-line nav-icon', 1),
(24, 13, 'Input Penilaian', 'saw/input_penilaian', 'fas fa-clipboard-list nav-icon', 1),
(26, 9, 'Divisi', 'divisi', 'fas fa-fw fa-home', 1);

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
-- Indexes for table `bobot`
--
ALTER TABLE `bobot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id_divisi`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_pegawai`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD KEY `fk_pegawai_divisi` (`id_divisi`);

--
-- Indexes for table `penilaian_karyawan`
--
ALTER TABLE `penilaian_karyawan`
  ADD PRIMARY KEY (`id_penilaian`),
  ADD KEY `fk_penilaian_pegawai` (`id_pegawai`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;

--
-- AUTO_INCREMENT for table `bobot`
--
ALTER TABLE `bobot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id_divisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id_pegawai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `penilaian_karyawan`
--
ALTER TABLE `penilaian_karyawan`
  MODIFY `id_penilaian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `fk_pegawai_divisi` FOREIGN KEY (`id_divisi`) REFERENCES `divisi` (`id_divisi`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `penilaian_karyawan`
--
ALTER TABLE `penilaian_karyawan`
  ADD CONSTRAINT `fk_penilaian_pegawai` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penilaian_karyawan_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
