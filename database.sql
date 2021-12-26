/*
SQLyog Ultimate v12.5.1 (32 bit)
MySQL - 10.4.11-MariaDB : Database - eraport
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`eraport` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `eraport`;

/*Table structure for table `chats` */

DROP TABLE IF EXISTS `chats`;

CREATE TABLE `chats` (
  `id_chat` int(11) NOT NULL AUTO_INCREMENT,
  `murid_id` varchar(11) NOT NULL,
  `guru_id` varchar(11) NOT NULL,
  `timestamps` timestamp NOT NULL DEFAULT current_timestamp(),
  `message` varchar(255) NOT NULL,
  `is_read` tinyint(1) DEFAULT NULL,
  `is_from_murid` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_chat`),
  KEY `chats_ibfk_1` (`guru_id`),
  KEY `chats_ibfk_2` (`murid_id`),
  CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `chats_ibfk_2` FOREIGN KEY (`murid_id`) REFERENCES `siswa` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `chats` */

/*Table structure for table `guru` */

DROP TABLE IF EXISTS `guru`;

CREATE TABLE `guru` (
  `nip` varchar(11) NOT NULL,
  `nama_guru` varchar(50) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(30) NOT NULL,
  `no_telp` varchar(14) NOT NULL,
  `agama` enum('Islam','Kristen','Katolik','Hindu','Budha','Konghuchu') NOT NULL,
  `status` varchar(20) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`nip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `guru` */

insert  into `guru`(`nip`,`nama_guru`,`jenis_kelamin`,`alamat`,`email`,`no_telp`,`agama`,`status`,`tanggal_lahir`,`password`) values 
('20000000001','Budi','Laki-laki','Wonogiri','budi@example.com','08123456789','Islam','Honorer','2021-12-26','123');

/*Table structure for table `kelas` */

DROP TABLE IF EXISTS `kelas`;

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(30) NOT NULL,
  `nip` varchar(11) NOT NULL,
  PRIMARY KEY (`id_kelas`),
  KEY `kelas_ibfk_1` (`nip`),
  CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`nip`) REFERENCES `guru` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `kelas` */

insert  into `kelas`(`id_kelas`,`nama_kelas`,`nip`) values 
(1,'X IPA A','20000000001');

/*Table structure for table `mata_pelajaran` */

DROP TABLE IF EXISTS `mata_pelajaran`;

CREATE TABLE `mata_pelajaran` (
  `id_mapel` int(11) NOT NULL AUTO_INCREMENT,
  `nip` varchar(11) NOT NULL,
  `nama_mapel` varchar(20) NOT NULL,
  PRIMARY KEY (`id_mapel`),
  KEY `mata_pelajaran_ibfk_1` (`nip`),
  CONSTRAINT `mata_pelajaran_ibfk_1` FOREIGN KEY (`nip`) REFERENCES `guru` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `mata_pelajaran` */

insert  into `mata_pelajaran`(`id_mapel`,`nip`,`nama_mapel`) values 
(1,'20000000001','Sosiologi');

/*Table structure for table `nilai` */

DROP TABLE IF EXISTS `nilai`;

CREATE TABLE `nilai` (
  `id_nilai` int(11) NOT NULL AUTO_INCREMENT,
  `nis` varchar(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `id_raport` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `cp1` int(11) DEFAULT NULL,
  `cp2` int(11) DEFAULT NULL,
  `uts` int(11) DEFAULT NULL,
  `cp3` int(11) DEFAULT NULL,
  `cp4` int(11) DEFAULT NULL,
  `nilai_akhir` varchar(1) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  PRIMARY KEY (`id_nilai`),
  KEY `id_raport` (`id_raport`),
  KEY `nilai_ibfk_2` (`nis`),
  KEY `nilai_ibfk_1` (`id_mapel`),
  CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`id_mapel`) REFERENCES `mata_pelajaran` (`id_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nilai_ibfk_2` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nilai_ibfk_3` FOREIGN KEY (`id_raport`) REFERENCES `raport` (`id_raport`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `nilai` */

insert  into `nilai`(`id_nilai`,`nis`,`id_mapel`,`id_raport`,`semester`,`cp1`,`cp2`,`uts`,`cp3`,`cp4`,`nilai_akhir`,`keterangan`) values 
(1,'51904100001',1,3,1,90,80,90,70,85,'A','Sangat memuaskan');

/*Table structure for table `orang_tua` */

DROP TABLE IF EXISTS `orang_tua`;

CREATE TABLE `orang_tua` (
  `id_ortu` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `no_tlp` int(14) NOT NULL,
  `pekerjaan` varchar(30) NOT NULL,
  `status` text NOT NULL,
  `agama` enum('islam','kristen','katolik','hindu','budha') NOT NULL,
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`id_ortu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `orang_tua` */

/*Table structure for table `raport` */

DROP TABLE IF EXISTS `raport`;

CREATE TABLE `raport` (
  `id_raport` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `nis` varchar(11) NOT NULL,
  `nip` varchar(11) NOT NULL,
  `nilai_huruf` varchar(10) DEFAULT NULL,
  `nilai_avg` double DEFAULT NULL,
  `rapor_semester` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  PRIMARY KEY (`id_raport`),
  KEY `raport_ibfk_2` (`nip`),
  KEY `raport_ibfk_1` (`nis`),
  CONSTRAINT `raport_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `raport_ibfk_2` FOREIGN KEY (`nip`) REFERENCES `guru` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `raport` */

insert  into `raport`(`id_raport`,`tanggal`,`nis`,`nip`,`nilai_huruf`,`nilai_avg`,`rapor_semester`,`keterangan`) values 
(3,'2021-12-26','51904100001','20000000001','A',90.5,1,'Sangat memuaskan');

/*Table structure for table `siswa` */

DROP TABLE IF EXISTS `siswa`;

CREATE TABLE `siswa` (
  `nis` varchar(11) NOT NULL,
  `nama_siswa` varchar(50) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `agama` enum('Islam','Kristen','Katolik','Hindu','Budha','Konghuchu') NOT NULL,
  `no_telp` varchar(14) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`nis`),
  KEY `siswa_ibfk_1` (`id_kelas`),
  CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `siswa` */

insert  into `siswa`(`nis`,`nama_siswa`,`jenis_kelamin`,`alamat`,`email`,`tanggal_lahir`,`agama`,`no_telp`,`id_kelas`,`password`) values 
('51904100001','John Doe','Laki-laki','Wonogiri','johndoe@example.com','2021-12-26','Kristen','08123456789',1,'123');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
