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

/*Table structure for table `admin` */

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `id_admin` VARCHAR(11) NOT NULL,
  `nama_admin` VARCHAR(255) NOT NULL,
  `email` VARCHAR(30) NOT NULL,
  `password` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4;

/*Data for the table `admin` */

/*Table structure for table `chats` */

DROP TABLE IF EXISTS `chats`;

CREATE TABLE `chats` (
  `id_chat` INT(11) NOT NULL AUTO_INCREMENT,
  `murid_id` VARCHAR(11) NOT NULL,
  `guru_id` VARCHAR(11) NOT NULL,
  `timestamps` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `message` VARCHAR(255) NOT NULL,
  `is_read` TINYINT(1) DEFAULT NULL,
  `is_from_murid` TINYINT(1) DEFAULT NULL,
  PRIMARY KEY (`id_chat`),
  KEY `chats_ibfk_1` (`guru_id`),
  KEY `chats_ibfk_2` (`murid_id`),
  CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `chats_ibfk_2` FOREIGN KEY (`murid_id`) REFERENCES `siswa` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4;

/*Data for the table `chats` */

/*Table structure for table `guru` */

DROP TABLE IF EXISTS `guru`;

CREATE TABLE `guru` (
  `nip` VARCHAR(11) NOT NULL,
  `nama_guru` VARCHAR(50) NOT NULL,
  `jenis_kelamin` ENUM('Laki-laki','Perempuan') NOT NULL,
  `alamat` TEXT NOT NULL,
  `email` VARCHAR(30) NOT NULL,
  `no_telp` VARCHAR(14) NOT NULL,
  `agama` ENUM('Islam','Kristen','Katolik','Hindu','Budha','Konghuchu') NOT NULL,
  `status` VARCHAR(20) NOT NULL,
  `tanggal_lahir` DATE NOT NULL,
  `password` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`nip`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4;

/*Data for the table `guru` */

INSERT  INTO `guru`(`nip`,`nama_guru`,`jenis_kelamin`,`alamat`,`email`,`no_telp`,`agama`,`status`,`tanggal_lahir`,`password`) VALUES 
('20000000001','Budi','Laki-laki','Wonogiri','budi@example.com','08123456789','Islam','Honorer','2021-12-26','123');

/*Table structure for table `kelas` */

DROP TABLE IF EXISTS `kelas`;

CREATE TABLE `kelas` (
  `id_kelas` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_kelas` VARCHAR(30) NOT NULL,
  `nip` VARCHAR(11) NOT NULL,
  PRIMARY KEY (`id_kelas`),
  KEY `kelas_ibfk_1` (`nip`),
  CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`nip`) REFERENCES `guru` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `kelas` */

INSERT  INTO `kelas`(`id_kelas`,`nama_kelas`,`nip`) VALUES 
(1,'X IPA A','20000000001');

/*Table structure for table `mata_pelajaran` */

DROP TABLE IF EXISTS `mata_pelajaran`;

CREATE TABLE `mata_pelajaran` (
  `id_mapel` INT(11) NOT NULL AUTO_INCREMENT,
  `nip` VARCHAR(11) NOT NULL,
  `nama_mapel` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id_mapel`),
  KEY `mata_pelajaran_ibfk_1` (`nip`),
  CONSTRAINT `mata_pelajaran_ibfk_1` FOREIGN KEY (`nip`) REFERENCES `guru` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `mata_pelajaran` */

INSERT  INTO `mata_pelajaran`(`id_mapel`,`nip`,`nama_mapel`) VALUES 
(1,'20000000001','Sosiologi');

/*Table structure for table `nilai` */

DROP TABLE IF EXISTS `nilai`;

CREATE TABLE `nilai` (
  `id_nilai` INT(11) NOT NULL AUTO_INCREMENT,
  `nis` VARCHAR(11) NOT NULL,
  `id_mapel` INT(11) NOT NULL,
  `id_raport` INT(11) NOT NULL,
  `semester` INT(11) NOT NULL,
  `cp1` INT(11) DEFAULT NULL,
  `cp2` INT(11) DEFAULT NULL,
  `cp3` INT(11) DEFAULT NULL,
  `cp4` INT(11) DEFAULT NULL,
  `uts` INT(11) DEFAULT NULL,
  `uas` INT(11) DEFAULT NULL,
  `nilai_akhir` VARCHAR(1) DEFAULT NULL,
  `keterangan` TEXT DEFAULT NULL,
  PRIMARY KEY (`id_nilai`),
  KEY `id_raport` (`id_raport`),
  KEY `nilai_ibfk_2` (`nis`),
  KEY `nilai_ibfk_1` (`id_mapel`),
  CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`id_mapel`) REFERENCES `mata_pelajaran` (`id_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nilai_ibfk_2` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nilai_ibfk_3` FOREIGN KEY (`id_raport`) REFERENCES `raport` (`id_raport`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `nilai` */

INSERT  INTO `nilai`(`id_nilai`,`nis`,`id_mapel`,`id_raport`,`semester`,`cp1`,`cp2`,`cp3`,`cp4`,`uts`,`uas`,`nilai_akhir`,`keterangan`) VALUES 
(1,'51904100001',1,3,1,90,80,70,85,90,NULL,'A','Sangat memuaskan');

/*Table structure for table `raport` */

DROP TABLE IF EXISTS `raport`;

CREATE TABLE `raport` (
  `id_raport` INT(11) NOT NULL AUTO_INCREMENT,
  `tanggal` DATE NOT NULL,
  `nis` VARCHAR(11) NOT NULL,
  `nip` VARCHAR(11) NOT NULL,
  `tahun_ajaran` INT(11) NOT NULL,
  `rapor_semester` INT(11) NOT NULL,
  `nilai_avg` DOUBLE DEFAULT NULL,
  `nilai_huruf` VARCHAR(10) DEFAULT NULL,
  `keterangan` TEXT DEFAULT NULL,
  PRIMARY KEY (`id_raport`),
  KEY `raport_ibfk_2` (`nip`),
  KEY `raport_ibfk_1` (`nis`),
  CONSTRAINT `raport_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `raport_ibfk_2` FOREIGN KEY (`nip`) REFERENCES `guru` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `raport` */

INSERT  INTO `raport`(`id_raport`,`tanggal`,`nis`,`nip`,`tahun_ajaran`,`rapor_semester`,`nilai_avg`,`nilai_huruf`,`keterangan`) VALUES 
(3,'2021-12-26','51904100001','20000000001',0,1,90.5,'A','Sangat memuaskan');

/*Table structure for table `siswa` */

DROP TABLE IF EXISTS `siswa`;

CREATE TABLE `siswa` (
  `nis` VARCHAR(11) NOT NULL,
  `nama_siswa` VARCHAR(50) NOT NULL,
  `jenis_kelamin` ENUM('Laki-laki','Perempuan') NOT NULL,
  `alamat` TEXT NOT NULL,
  `email` VARCHAR(50) NOT NULL,
  `no_telp` VARCHAR(14) NOT NULL,
  `agama` ENUM('Islam','Kristen','Katolik','Hindu','Budha','Konghuchu') NOT NULL,
  `id_kelas` INT(11) NOT NULL,
  `tanggal_lahir` DATE NOT NULL,
  `password` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`nis`),
  KEY `siswa_ibfk_1` (`id_kelas`),
  CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4;

/*Data for the table `siswa` */

INSERT  INTO `siswa`(`nis`,`nama_siswa`,`jenis_kelamin`,`alamat`,`email`,`no_telp`,`agama`,`id_kelas`,`tanggal_lahir`,`password`) VALUES 
('51904100001','John Doe','Laki-laki','Wonogiri','johndoe@example.com','08123456789','Kristen',1,'2021-12-26','123');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;




SELECT * FROM raport WHERE nis = '51904100001';

SELECT * FROM raport 
INNER JOIN nilai ON raport.id_raport = nilai.id_raport 
INNER JOIN mata_pelajaran ON nilai.id_mapel = mata_pelajaran.id_mapel
WHERE raport.nis = '51904100001' AND tahun_ajaran = '20192020' AND rapor_semester = 1;
SELECT * FROM guru WHERE nip = 20000000001

# lihat daftar kelas yang diampu oleh guru
SELECT * FROM kelas;
SELECT COUNT(*) AS total_records FROM siswa WHERE id_kelas = 1

SELECT COUNT(*) AS total_siswa FROM siswa WHERE id_kelas = 1;

# nilai siswa
SELECT * FROM nilai INNER JOIN mata_pelajaran ON nilai.id_mapel = mata_pelajaran.id_mapel
INNER JOIN 