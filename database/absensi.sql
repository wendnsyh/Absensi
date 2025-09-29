-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2025 at 10:27 AM
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
(723, 1, 'Wendy', '12345', '2025-09-01', 0, 1, 1, 1, 1, 1, 11, 0, 0, 0, 7),
(724, 2, 'Najdah', '54321', '2025-09-01', 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0),
(725, 3, 'Lorenza', '121212', '2025-09-01', 0, 1, 2, 3, 2, 4, 6, 10, 1, 0, 8),
(730, 0, 'NAMA', 'NIP', '2025-08-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(731, 1, 'Adri', '111111', '2025-08-01', 0, 1, 1, 1, 1, 1, 11, 0, 0, 0, 7),
(732, 2, 'Alfi', '54321', '2025-08-01', 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0),
(733, 3, 'Arya', '121212', '2025-08-01', 0, 1, 2, 3, 2, 4, 6, 10, 1, 0, 8),
(758, 0, 'NAMA', 'NIP', '2025-02-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(759, 1, 'Wendy', '12345', '2025-02-01', 0, 1, 1, 1, 1, 1, 11, 0, 0, 0, 0),
(760, 2, 'Najdah', '54321', '2025-02-01', 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0),
(761, 3, 'Lorenza', '121212', '2025-02-01', 0, 1, 2, 3, 2, 4, 6, 10, 1, 3, 3),
(762, 0, 'NAMA', 'NIP', '2025-02-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(763, 1, 'Adri', '111111', '2025-02-01', 0, 1, 1, 1, 1, 1, 11, 0, 0, 0, 0),
(764, 2, 'Alfi', '2222', '2025-02-01', 0, 2, 3, 4, 1, 2, 12, 3, 4, 0, 0),
(765, 3, 'Arya', '3333', '2025-02-01', 0, 1, 2, 3, 2, 4, 6, 10, 1, 3, 3),
(766, 0, 'NAMA', 'NIP', '2025-01-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(767, 1, 'Adri', '111111', '2025-01-01', 0, 1, 1, 1, 1, 1, 11, 0, 0, 0, 0),
(768, 2, 'Alfi', '2222', '2025-01-01', 0, 2, 3, 4, 1, 2, 12, 3, 4, 0, 0),
(769, 3, 'Arya', '3333', '2025-01-01', 0, 1, 2, 3, 2, 4, 6, 10, 1, 3, 3),
(770, 0, 'NAMA', 'NIP', '2025-05-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(771, 1, 'Wendy', '12345', '2025-05-01', 0, 1, 1, 1, 1, 1, 11, 0, 0, 0, 0),
(772, 2, 'Najdah', '54321', '2025-05-01', 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0),
(773, 3, 'Lorenza', '121212', '2025-05-01', 0, 1, 2, 3, 2, 4, 6, 10, 1, 3, 3),
(774, 0, 'NAMA', 'ID PEGAWAI', '2025-07-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(775, 1, 'Abdul Mait, S.E', 'DS043', '2025-07-01', 0, 0, 0, 0, 0, 0, 11, 0, 0, 0, 0),
(776, 2, 'Ade Irmayanti', 'DS041', '2025-07-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(777, 3, 'Adi Mulyanto, SE', 'DS010', '2025-07-01', 0, 0, 0, 0, 0, 0, 6, 10, 1, 3, 3),
(778, 4, 'Agus Nurcahyo, S.Kom', 'DS098', '2025-07-01', 0, 0, 0, 0, 0, 0, 16, 4, 0, 1, 1),
(779, 5, 'Ahmad Kandiaz, S.H', 'DS002', '2025-07-01', 0, 0, 0, 0, 0, 0, 5, 0, 0, 7, 7),
(780, 6, 'Ahmad Rinduwan', 'DS063', '2025-07-01', 0, 0, 0, 0, 0, 0, 2, 8, 5, 4, 4),
(781, 7, 'Ahmad Sopian, S.E', 'DS058', '2025-07-01', 0, 0, 0, 0, 0, 0, 0, 2, 1, 6, 6),
(782, 8, 'Alinah', 'DS083', '2025-07-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 23, 23),
(783, 9, 'Andriani Prayuda, S.M', 'DS069', '2025-07-01', 0, 0, 0, 0, 0, 4, 8, 5, 0, 4, 4),
(784, 10, 'Anggriyani Daulay, S.Kom', 'DS017', '2025-07-01', 0, 0, 0, 0, 3, 0, 5, 3, 0, 1, 1),
(785, 11, 'Annisa Ameliasyari', 'DS060', '2025-07-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(786, 12, 'Ari Ardiansah', 'DS009', '2025-07-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(787, 13, 'Ari Widiastuti, A.Md', 'DS020', '2025-07-01', 0, 0, 3, 0, 0, 0, 6, 0, 0, 2, 2),
(788, 14, 'Azis Fadhillah, S.H', 'DS031', '2025-07-01', 0, 2, 0, 0, 3, 0, 0, 0, 2, 2, 2),
(789, 15, 'Burhanudin Jaelani Ibnu Ruslan', 'DS070', '2025-07-01', 0, 0, 0, 0, 4, 0, 3, 0, 0, 1, 1),
(790, 16, 'Darmendra Febrianto, S.E', 'DS054', '2025-07-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1),
(791, 17, 'Desy Wijiyanti, S.Kom.', 'DS071', '2025-07-01', 0, 0, 0, 0, 0, 0, 3, 2, 1, 3, 3),
(792, 18, 'Dwi Fajar', 'DS078', '2025-07-01', 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 1),
(793, 19, 'Dwi Wahyuningsih', 'DS086', '2025-07-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(794, 20, 'Eroh Rohayati, S.Kom', 'DS042', '2025-07-01', 0, 0, 0, 0, 0, 0, 4, 0, 0, 1, 1),
(795, 21, 'Erry Eka Pratama', 'DS006', '2025-07-01', 0, 0, 2, 0, 0, 0, 6, 1, 0, 6, 6),
(796, 22, 'Fahmi Angga Yudha, A.Md', 'DS066', '2025-07-01', 0, 0, 1, 0, 0, 0, 0, 0, 0, 4, 4),
(797, 23, 'Hasan Basri,S.AP', 'DS053', '2025-07-01', 0, 0, 0, 1, 0, 0, 0, 0, 0, 5, 5),
(798, 24, 'Hindawan Yuniar, S.I.Kom', 'DS056', '2025-07-01', 0, 2, 2, 0, 0, 0, 4, 7, 1, 2, 2),
(799, 25, 'Iis Afriyanti, A.Md', 'DS022', '2025-07-01', 0, 0, 1, 0, 0, 0, 9, 2, 0, 8, 8),
(800, 26, 'Ikhwan Adi Putra', 'DS061', '2025-07-01', 0, 0, 0, 8, 0, 0, 2, 3, 4, 6, 6),
(801, 27, 'Ilham Nurudin', 'DS081', '2025-07-01', 0, 0, 0, 5, 0, 0, 0, 0, 0, 12, 12),
(802, 28, 'Irmawati, S.M.', 'DS037', '2025-07-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 3),
(803, 29, 'Isgiantoro', 'DS085', '2025-07-01', 0, 0, 0, 0, 4, 0, 2, 10, 1, 0, 0),
(804, 30, 'Istiqomah Aisyiyah, S.Sos', 'DS021', '2025-07-01', 0, 0, 0, 0, 0, 0, 10, 5, 1, 3, 3),
(805, 31, 'Istiyar Iman Aldriansyah, S.Kom', 'DS062', '2025-07-01', 0, 0, 0, 4, 0, 0, 1, 6, 5, 7, 7),
(806, 32, 'Laras Tyas Ayu Pramudya, S.KM', 'DS064', '2025-07-01', 0, 0, 0, 9, 0, 0, 0, 0, 3, 8, 8),
(807, 33, 'Leo Wahyudi, S.H', 'DS013', '2025-07-01', 0, 0, 0, 0, 0, 0, 15, 3, 0, 1, 1),
(808, 34, 'Lilis Suryani, S.E', 'DS065', '2025-07-01', 0, 0, 0, 0, 13, 0, 0, 0, 0, 1, 1),
(809, 35, 'Linda Amalia,S.Psi', 'DS059', '2025-07-01', 0, 0, 0, 0, 8, 0, 1, 2, 0, 6, 6),
(810, 36, 'Mariyah, S.E', 'DS039', '2025-07-01', 0, 1, 0, 0, 0, 0, 10, 4, 0, 0, 0),
(811, 37, 'Mawaddah Khalisah, S.E.', 'DS004', '2025-07-01', 0, 0, 0, 0, 1, 4, 7, 6, 0, 3, 3),
(812, 38, 'Methatia Cahya, S.H', 'DS015', '2025-07-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 3),
(813, 39, 'Muhamad Rizki', 'DS067', '2025-07-01', 0, 0, 0, 0, 10, 0, 2, 5, 0, 5, 5),
(814, 40, 'Nadya Ayu Permatasari, S.Sos', 'DS016', '2025-07-01', 0, 0, 2, 0, 0, 0, 3, 9, 1, 1, 1),
(815, 41, 'Nia Lestari, A.Md', 'DS007', '2025-07-01', 0, 0, 0, 1, 0, 0, 9, 2, 1, 1, 1),
(816, 42, 'Nico Reynold Adiputro', 'DS012', '2025-07-01', 0, 0, 0, 1, 0, 0, 2, 14, 3, 3, 3),
(817, 43, 'Niko Septian Hadi, S.Kom', 'DS040', '2025-07-01', 0, 0, 0, 0, 0, 0, 13, 0, 0, 0, 0),
(818, 44, 'Novanta Nur Syabana', 'DS052', '2025-07-01', 0, 0, 0, 4, 0, 0, 1, 4, 10, 1, 1),
(819, 45, 'Nurlaela, S.E', 'DS003', '2025-07-01', 0, 0, 1, 1, 0, 0, 6, 1, 0, 6, 6),
(820, 46, 'Nurlia Oktaviani, S.M', 'DS057', '2025-07-01', 0, 0, 0, 3, 0, 0, 6, 4, 0, 3, 3),
(821, 47, 'Pebri Perdana, S.AP', 'DS038', '2025-07-01', 0, 0, 0, 0, 0, 0, 6, 6, 1, 0, 0),
(822, 48, 'R. Adhi Ilham Prayoga', 'DS045', '2025-07-01', 0, 0, 0, 5, 0, 0, 2, 3, 6, 5, 5),
(823, 49, 'Rojali', 'DS079', '2025-07-01', 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(824, 50, 'Santoso Setya Supriyanto, SP', 'DS072', '2025-07-01', 0, 0, 0, 0, 0, 0, 1, 2, 0, 19, 19),
(825, 51, 'Sapto Wibowo, S.Sos', 'DS011', '2025-07-01', 0, 0, 0, 3, 0, 0, 0, 16, 4, 1, 1),
(826, 52, 'Septilia Dindasari, S.M.', 'DS005', '2025-07-01', 0, 0, 0, 0, 3, 0, 11, 0, 0, 1, 1),
(827, 53, 'Sugiatmi', 'DS084', '2025-07-01', 0, 0, 0, 1, 0, 0, 0, 0, 0, 22, 22),
(828, 54, 'Tita Syafira Maulida', 'DS036', '2025-07-01', 0, 0, 0, 0, 0, 0, 1, 0, 0, 6, 6),
(829, 55, 'Zalsabila Zanyca, S.M', 'DS019', '2025-07-01', 0, 4, 0, 0, 2, 6, 5, 1, 3, 0, 0),
(830, 56, 'Anpal Iskalpa PutraA', 'DS030', '2025-07-01', 0, 0, 0, 0, 0, 0, 2, 5, 7, 5, 5),
(831, 57, 'Hupron, S.Sos', 'DS027', '2025-07-01', 0, 0, 0, 0, 4, 0, 3, 1, 0, 2, 2),
(832, 58, 'M. Edi Sudrajat', 'DS029', '2025-07-01', 0, 0, 0, 2, 0, 0, 7, 3, 1, 5, 5),
(833, 59, 'Novel Noberi, S.Kom', 'DS033', '2025-07-01', 0, 0, 0, 2, 0, 0, 1, 3, 0, 6, 6),
(834, 60, 'Nur. Anugrah Sanusi', 'DS026', '2025-07-01', 0, 0, 0, 4, 0, 0, 4, 3, 5, 4, 4),
(835, 61, 'R.Pryeska Nusantara.KH, S.Pd', 'DS032', '2025-07-01', 0, 0, 0, 0, 0, 0, 1, 2, 0, 3, 3),
(836, 62, 'Rahmat Perrianto, ST', 'DS023', '2025-07-01', 0, 0, 0, 2, 0, 0, 0, 1, 0, 16, 16),
(837, 63, 'Saipulah, SH', 'DS024', '2025-07-01', 0, 0, 0, 2, 6, 0, 1, 3, 0, 8, 8),
(838, 64, 'Solahudin', 'DS028', '2025-07-01', 0, 0, 0, 1, 0, 0, 4, 4, 2, 2, 2),
(839, 65, 'Tubagus Iqbal Tawakal', 'DS025', '2025-07-01', 0, 0, 0, 0, 0, 0, 9, 1, 0, 2, 2),
(840, 66, 'Siti Nurhasanah', 'DS088', '2025-07-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(841, 67, 'Ade Pandawa', 'DS051', '2025-07-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(842, 68, 'Herlila Dwi Wahyuni, Amd.Keb', 'DS048', '2025-07-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(843, 69, 'Ika Mediyanti, S.ST', 'DS046', '2025-07-01', 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(844, 70, 'Korri Annisa, A.Md,Keb', 'DS049', '2025-07-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(845, 71, 'NS. Nouva Prana Putra, S.Kep', 'DS050', '2025-07-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(846, 72, 'Ahmad Tantowi', 'DS075', '2025-07-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(847, 73, 'Iwan Sutisna', 'DS076', '2025-07-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(848, 74, 'Suharlan', 'DS074', '2025-07-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(849, 75, 'Suhendi', 'DS077', '2025-07-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(850, 76, 'Aditya Firmansyah', 'DS08', '2025-07-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(851, 77, 'Bebo Karsono', 'DS0', '2025-07-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(852, 78, 'Dananjaya Satria Kusuma Atmaja', 'DS094', '2025-07-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(853, 79, 'Dian Iskandar', 'DS099', '2025-07-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(854, 80, 'Dzulfahmi', 'DS097', '2025-07-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(855, 81, 'Ninik Samini', 'DS092', '2025-07-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(856, 82, 'Roni Parulian S.', 'DS093', '2025-07-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(857, 83, 'Wahyuni', 'DS090', '2025-07-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(858, 0, 'NAMA', 'ID PEGAWAI', '2025-06-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(859, 1, 'Abdul Mait, S.E', 'DS043', '2025-06-01', 0, 0, 0, 0, 0, 0, 11, 0, 0, 0, 0),
(860, 2, 'Ade Irmayanti', 'DS041', '2025-06-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(861, 3, 'Adi Mulyanto, SE', 'DS010', '2025-06-01', 0, 0, 0, 0, 0, 0, 6, 10, 1, 3, 3),
(862, 4, 'Agus Nurcahyo, S.Kom', 'DS098', '2025-06-01', 0, 0, 0, 0, 0, 0, 16, 4, 0, 1, 1),
(863, 5, 'Ahmad Kandiaz, S.H', 'DS002', '2025-06-01', 0, 0, 0, 0, 0, 0, 5, 0, 0, 7, 7),
(864, 6, 'Ahmad Rinduwan', 'DS063', '2025-06-01', 0, 0, 0, 0, 0, 0, 2, 8, 5, 4, 4),
(865, 7, 'Ahmad Sopian, S.E', 'DS058', '2025-06-01', 0, 0, 0, 0, 0, 0, 0, 2, 1, 6, 6),
(866, 8, 'Alinah', 'DS083', '2025-06-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 23, 23),
(867, 9, 'Andriani Prayuda, S.M', 'DS069', '2025-06-01', 0, 0, 0, 0, 0, 4, 8, 5, 0, 4, 4),
(868, 10, 'Anggriyani Daulay, S.Kom', 'DS017', '2025-06-01', 0, 0, 0, 0, 3, 0, 5, 3, 0, 1, 1),
(869, 11, 'Annisa Ameliasyari', 'DS060', '2025-06-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(870, 12, 'Ari Ardiansah', 'DS009', '2025-06-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(871, 13, 'Ari Widiastuti, A.Md', 'DS020', '2025-06-01', 0, 0, 3, 0, 0, 0, 6, 0, 0, 2, 2),
(872, 14, 'Azis Fadhillah, S.H', 'DS031', '2025-06-01', 0, 2, 0, 0, 3, 0, 0, 0, 2, 2, 2),
(873, 15, 'Burhanudin Jaelani Ibnu Ruslan', 'DS070', '2025-06-01', 0, 0, 0, 0, 4, 0, 3, 0, 0, 1, 1),
(874, 16, 'Darmendra Febrianto, S.E', 'DS054', '2025-06-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1),
(875, 17, 'Desy Wijiyanti, S.Kom.', 'DS071', '2025-06-01', 0, 0, 0, 0, 0, 0, 3, 2, 1, 3, 3),
(876, 18, 'Dwi Fajar', 'DS078', '2025-06-01', 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 1),
(877, 19, 'Dwi Wahyuningsih', 'DS086', '2025-06-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(878, 20, 'Eroh Rohayati, S.Kom', 'DS042', '2025-06-01', 0, 0, 0, 0, 0, 0, 4, 0, 0, 1, 1),
(879, 21, 'Erry Eka Pratama', 'DS006', '2025-06-01', 0, 0, 2, 0, 0, 0, 6, 1, 0, 6, 6),
(880, 22, 'Fahmi Angga Yudha, A.Md', 'DS066', '2025-06-01', 0, 0, 1, 0, 0, 0, 0, 0, 0, 4, 4),
(881, 23, 'Hasan Basri,S.AP', 'DS053', '2025-06-01', 0, 0, 0, 1, 0, 0, 0, 0, 0, 5, 5),
(882, 24, 'Hindawan Yuniar, S.I.Kom', 'DS056', '2025-06-01', 0, 2, 2, 0, 0, 0, 4, 7, 1, 2, 2),
(883, 25, 'Iis Afriyanti, A.Md', 'DS022', '2025-06-01', 0, 0, 1, 0, 0, 0, 9, 2, 0, 8, 8),
(884, 26, 'Ikhwan Adi Putra', 'DS061', '2025-06-01', 0, 0, 0, 8, 0, 0, 2, 3, 4, 6, 6),
(885, 27, 'Ilham Nurudin', 'DS081', '2025-06-01', 0, 0, 0, 5, 0, 0, 0, 0, 0, 12, 12),
(886, 28, 'Irmawati, S.M.', 'DS037', '2025-06-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 3),
(887, 29, 'Isgiantoro', 'DS085', '2025-06-01', 0, 0, 0, 0, 4, 0, 2, 10, 1, 0, 0),
(888, 30, 'Istiqomah Aisyiyah, S.Sos', 'DS021', '2025-06-01', 0, 0, 0, 0, 0, 0, 10, 5, 1, 3, 3),
(889, 31, 'Istiyar Iman Aldriansyah, S.Kom', 'DS062', '2025-06-01', 0, 0, 0, 4, 0, 0, 1, 6, 5, 7, 7),
(890, 32, 'Laras Tyas Ayu Pramudya, S.KM', 'DS064', '2025-06-01', 0, 0, 0, 9, 0, 0, 0, 0, 3, 8, 8),
(891, 33, 'Leo Wahyudi, S.H', 'DS013', '2025-06-01', 0, 0, 0, 0, 0, 0, 15, 3, 0, 1, 1),
(892, 34, 'Lilis Suryani, S.E', 'DS065', '2025-06-01', 0, 0, 0, 0, 13, 0, 0, 0, 0, 1, 1),
(893, 35, 'Linda Amalia,S.Psi', 'DS059', '2025-06-01', 0, 0, 0, 0, 8, 0, 1, 2, 0, 6, 6),
(894, 36, 'Mariyah, S.E', 'DS039', '2025-06-01', 0, 1, 0, 0, 0, 0, 10, 4, 0, 0, 0),
(895, 37, 'Mawaddah Khalisah, S.E.', 'DS004', '2025-06-01', 0, 0, 0, 0, 1, 4, 7, 6, 0, 3, 3),
(896, 38, 'Methatia Cahya, S.H', 'DS015', '2025-06-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 3),
(897, 39, 'Muhamad Rizki', 'DS067', '2025-06-01', 0, 0, 0, 0, 10, 0, 2, 5, 0, 5, 5),
(898, 40, 'Nadya Ayu Permatasari, S.Sos', 'DS016', '2025-06-01', 0, 0, 2, 0, 0, 0, 3, 9, 1, 1, 1),
(899, 41, 'Nia Lestari, A.Md', 'DS007', '2025-06-01', 0, 0, 0, 1, 0, 0, 9, 2, 1, 1, 1),
(900, 42, 'Nico Reynold Adiputro', 'DS012', '2025-06-01', 0, 0, 0, 1, 0, 0, 2, 14, 3, 3, 3),
(901, 43, 'Niko Septian Hadi, S.Kom', 'DS040', '2025-06-01', 0, 0, 0, 0, 0, 0, 13, 0, 0, 0, 0),
(902, 44, 'Novanta Nur Syabana', 'DS052', '2025-06-01', 0, 0, 0, 4, 0, 0, 1, 4, 10, 1, 1),
(903, 45, 'Nurlaela, S.E', 'DS003', '2025-06-01', 0, 0, 1, 1, 0, 0, 6, 1, 0, 6, 6),
(904, 46, 'Nurlia Oktaviani, S.M', 'DS057', '2025-06-01', 0, 0, 0, 3, 0, 0, 6, 4, 0, 3, 3),
(905, 47, 'Pebri Perdana, S.AP', 'DS038', '2025-06-01', 0, 0, 0, 0, 0, 0, 6, 6, 1, 0, 0),
(906, 48, 'R. Adhi Ilham Prayoga', 'DS045', '2025-06-01', 0, 0, 0, 5, 0, 0, 2, 3, 6, 5, 5),
(907, 49, 'Rojali', 'DS079', '2025-06-01', 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(908, 50, 'Santoso Setya Supriyanto, SP', 'DS072', '2025-06-01', 0, 0, 0, 0, 0, 0, 1, 2, 0, 19, 19),
(909, 51, 'Sapto Wibowo, S.Sos', 'DS011', '2025-06-01', 0, 0, 0, 3, 0, 0, 0, 16, 4, 1, 1),
(910, 52, 'Septilia Dindasari, S.M.', 'DS005', '2025-06-01', 0, 0, 0, 0, 3, 0, 11, 0, 0, 1, 1),
(911, 53, 'Sugiatmi', 'DS084', '2025-06-01', 0, 0, 0, 1, 0, 0, 0, 0, 0, 22, 22),
(912, 54, 'Tita Syafira Maulida', 'DS036', '2025-06-01', 0, 0, 0, 0, 0, 0, 1, 0, 0, 6, 6),
(913, 55, 'Zalsabila Zanyca, S.M', 'DS019', '2025-06-01', 0, 4, 0, 0, 2, 6, 5, 1, 3, 0, 0),
(914, 56, 'Anpal Iskalpa PutraA', 'DS030', '2025-06-01', 0, 0, 0, 0, 0, 0, 2, 5, 7, 5, 5),
(915, 57, 'Hupron, S.Sos', 'DS027', '2025-06-01', 0, 0, 0, 0, 4, 0, 3, 1, 0, 2, 2),
(916, 58, 'M. Edi Sudrajat', 'DS029', '2025-06-01', 0, 0, 0, 2, 0, 0, 7, 3, 1, 5, 5),
(917, 59, 'Novel Noberi, S.Kom', 'DS033', '2025-06-01', 0, 0, 0, 2, 0, 0, 1, 3, 0, 6, 6),
(918, 60, 'Nur. Anugrah Sanusi', 'DS026', '2025-06-01', 0, 0, 0, 4, 0, 0, 4, 3, 5, 4, 4),
(919, 61, 'R.Pryeska Nusantara.KH, S.Pd', 'DS032', '2025-06-01', 0, 0, 0, 0, 0, 0, 1, 2, 0, 3, 3),
(920, 62, 'Rahmat Perrianto, ST', 'DS023', '2025-06-01', 0, 0, 0, 2, 0, 0, 0, 1, 0, 16, 16),
(921, 63, 'Saipulah, SH', 'DS024', '2025-06-01', 0, 0, 0, 2, 6, 0, 1, 3, 0, 8, 8),
(922, 64, 'Solahudin', 'DS028', '2025-06-01', 0, 0, 0, 1, 0, 0, 4, 4, 2, 2, 2),
(923, 65, 'Tubagus Iqbal Tawakal', 'DS025', '2025-06-01', 0, 0, 0, 0, 0, 0, 9, 1, 0, 2, 2),
(924, 66, 'Siti Nurhasanah', 'DS088', '2025-06-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(925, 67, 'Ade Pandawa', 'DS051', '2025-06-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(926, 68, 'Herlila Dwi Wahyuni, Amd.Keb', 'DS048', '2025-06-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(927, 69, 'Ika Mediyanti, S.ST', 'DS046', '2025-06-01', 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(928, 70, 'Korri Annisa, A.Md,Keb', 'DS049', '2025-06-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(929, 71, 'NS. Nouva Prana Putra, S.Kep', 'DS050', '2025-06-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(930, 72, 'Ahmad Tantowi', 'DS075', '2025-06-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(931, 73, 'Iwan Sutisna', 'DS076', '2025-06-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(932, 74, 'Suharlan', 'DS074', '2025-06-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(933, 75, 'Suhendi', 'DS077', '2025-06-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(934, 76, 'Aditya Firmansyah', 'DS08', '2025-06-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(935, 77, 'Bebo Karsono', 'DS0', '2025-06-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(936, 78, 'Dananjaya Satria Kusuma Atmaja', 'DS094', '2025-06-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(937, 79, 'Dian Iskandar', 'DS099', '2025-06-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(938, 80, 'Dzulfahmi', 'DS097', '2025-06-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(939, 81, 'Ninik Samini', 'DS092', '2025-06-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(940, 82, 'Roni Parulian S.', 'DS093', '2025-06-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(941, 83, 'Wahyuni', 'DS090', '2025-06-01', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

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
(5, 'Super Admin', 'superadmin@gmail.com', 'Gemini_Generated_Image_elsfu4elsfu4elsf.png', '$2y$10$gOUmr/zVsc3HhaCa3Jxz1uIC5IOF6QtIEiBeAcrogU1ThW2xnzweW', 1, 1, 1751614988),
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
(1, 1, 'Dashboard', 'dashboard', 'fas fa-fw fa-home', 1),
(3, 2, 'My Profile', 'user', 'fas fa-fw fa-user', 1),
(5, 5, 'Menu Management', 'menu', 'fas fa-fw fa-folder', 1),
(7, 5, 'Submenu Management', 'menu/submenu', 'fas fa-fw fa-folder-open', 1),
(14, 1, 'Role', 'admin/role', 'fas fa-fw fa-wrench', 1),
(15, 9, 'Pegawai', 'pegawai', 'fas fa-fw fa-user-tie', 1),
(17, 12, 'Absensi Harian', 'absensi', 'fas fa-user-check', 1),
(19, 1, 'Manajemen User', 'admin/manage_user', 'fas fa-fw fa-users', 1),
(20, 10, 'Laporan Rekap', 'absensi/laporan_rekap', 'fas fa-fw fa-user-tie', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=942;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
