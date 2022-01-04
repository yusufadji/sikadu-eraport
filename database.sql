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
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `nama_admin` varchar(255) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `admin` */

insert  into `admin`(`id_admin`,`nama_admin`,`email`,`password`) values 
(2,'Adji','admin@frelein.my.id','123');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `chats` */

insert  into `chats`(`id_chat`,`murid_id`,`guru_id`,`timestamps`,`message`,`is_read`,`is_from_murid`) values 
(1,'51904100001','48295013901','2022-01-03 21:48:14','halo pak',0,1),
(2,'51904100001','48295013901','2022-01-03 21:49:39','halo juga nak',0,0),
(3,'51904100001','48295013901','2022-01-04 12:07:38','mau protes nilai pak',0,1);

/*Table structure for table `guru` */

DROP TABLE IF EXISTS `guru`;

CREATE TABLE `guru` (
  `nip` varchar(11) NOT NULL,
  `nama_guru` varchar(50) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(30) NOT NULL,
  `no_telp` varchar(14) NOT NULL,
  `agama` enum('Islam','Kristen','Katolik','Hindu','Buddha','Konghuchu') NOT NULL,
  `status` varchar(20) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`nip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `guru` */

insert  into `guru`(`nip`,`nama_guru`,`jenis_kelamin`,`alamat`,`email`,`no_telp`,`agama`,`status`,`tanggal_lahir`,`password`) values 
('48295013901','Steven','Laki-laki','Tulungagung','steven@example.com','08123947562','Kristen','Pegawai Negeri Sipil','1998-08-18','$2y$10$c4zaqzGFLhvzSZBuo3oKROKDuv4cVlG890yqgXaQsTlN.UuuSz.2S'),
('48295013902','Dimas Zulfikar','Laki-laki','Kalimantan Utara','dimzul@example.com','08134792835128','Islam','Pegawai Negeri Sipil','1999-09-05','$2y$10$VJ6Fu9DNV9XC6RrQmZSPt.ocCG3TozkZbDjD7QkAjq62ahe8Z6EGq'),
('48295013903','Rafif','Laki-laki','Surabaya','rafif@example.com','08182748151257','Islam','Pegawai Negeri Sipil','1990-04-16','$2y$10$qQVR3hL57CJnIVR9VeiFHetbpnLGd/XirxL1xey8KsqXtLcQc6aG2');

/*Table structure for table `kelas` */

DROP TABLE IF EXISTS `kelas`;

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(30) NOT NULL,
  `nip` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id_kelas`),
  KEY `kelas_ibfk_1` (`nip`),
  CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`nip`) REFERENCES `guru` (`nip`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Data for the table `kelas` */

insert  into `kelas`(`id_kelas`,`nama_kelas`,`nip`) values 
(1,'X IPA A','48295013901'),
(8,'X Bahasa A','48295013902');

/*Table structure for table `mata_pelajaran` */

DROP TABLE IF EXISTS `mata_pelajaran`;

CREATE TABLE `mata_pelajaran` (
  `id_mapel` int(11) NOT NULL AUTO_INCREMENT,
  `nama_mapel` varchar(20) NOT NULL,
  `nip` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id_mapel`),
  KEY `mata_pelajaran_ibfk_1` (`nip`),
  CONSTRAINT `mata_pelajaran_ibfk_1` FOREIGN KEY (`nip`) REFERENCES `guru` (`nip`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Data for the table `mata_pelajaran` */

insert  into `mata_pelajaran`(`id_mapel`,`nama_mapel`,`nip`) values 
(7,'Matematika','48295013901'),
(8,'Biologi','48295013902');

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
  `cp3` int(11) DEFAULT NULL,
  `cp4` int(11) DEFAULT NULL,
  `uts` int(11) DEFAULT NULL,
  `uas` int(11) DEFAULT NULL,
  `nilai_akhir` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id_nilai`),
  KEY `id_raport` (`id_raport`),
  KEY `nilai_ibfk_2` (`nis`),
  KEY `nilai_ibfk_1` (`id_mapel`),
  CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`id_mapel`) REFERENCES `mata_pelajaran` (`id_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nilai_ibfk_2` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nilai_ibfk_3` FOREIGN KEY (`id_raport`) REFERENCES `raport` (`id_raport`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `nilai` */

insert  into `nilai`(`id_nilai`,`nis`,`id_mapel`,`id_raport`,`semester`,`cp1`,`cp2`,`cp3`,`cp4`,`uts`,`uas`,`nilai_akhir`) values 
(2,'51904100001',7,4,1,70,70,70,75,80,70,'B'),
(3,'51904100003',7,5,1,90,80,70,60,50,40,'C');

/*Table structure for table `raport` */

DROP TABLE IF EXISTS `raport`;

CREATE TABLE `raport` (
  `id_raport` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `nis` varchar(11) NOT NULL,
  `nip` varchar(11) NOT NULL,
  `tahun_ajaran` int(11) NOT NULL,
  `rapor_semester` int(11) NOT NULL,
  PRIMARY KEY (`id_raport`),
  KEY `raport_ibfk_2` (`nip`),
  KEY `raport_ibfk_1` (`nis`),
  CONSTRAINT `raport_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `raport_ibfk_2` FOREIGN KEY (`nip`) REFERENCES `guru` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `raport` */

insert  into `raport`(`id_raport`,`tanggal`,`nis`,`nip`,`tahun_ajaran`,`rapor_semester`) values 
(4,'2022-01-03','51904100001','48295013901',20202021,1),
(5,'2022-01-04','51904100003','48295013901',20202021,1);

/*Table structure for table `siswa` */

DROP TABLE IF EXISTS `siswa`;

CREATE TABLE `siswa` (
  `nis` varchar(11) NOT NULL,
  `nama_siswa` varchar(50) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `no_telp` varchar(14) NOT NULL,
  `agama` enum('Islam','Kristen','Katolik','Hindu','Buddha','Konghuchu') NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`nis`),
  KEY `siswa_ibfk_1` (`id_kelas`),
  CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `siswa` */

insert  into `siswa`(`nis`,`nama_siswa`,`jenis_kelamin`,`alamat`,`email`,`no_telp`,`agama`,`id_kelas`,`tanggal_lahir`,`password`) values 
('51904100001','Agus','Laki-laki','Wonogiri','aguskoen@example.com','08123456789','Kristen',1,'2021-12-26','$2y$10$AdCdBks.gd8kHSjtMAhHiOvlyJgixL9Aksar1Bnp6OFse5qW303aS'),
('51904100002','Wansyah','Laki-laki','Sulawesi Selatan','wanca@example.com','08123791259812','Islam',8,'2000-09-18','$2y$10$yB.TuGgbUMjLSW56Km9gguSbqHES4uQtb4.SIeqHSt7yLublgS0gq'),
('51904100003','Radi','Laki-laki','Jakarta','radi@example.com','081273491876','Islam',1,'1999-08-19','$2y$10$G6fyocq7VenvHEUFLSoVbupp5XK/DV5ygcskRBjang6mk/reF5xI.'),
('51904100004','Putra','Laki-laki','Surabaya','putra@example.com','082192871928','Kristen',1,'1999-09-18','$2y$10$2yvnmXsL8WcpOvizxXi3PeZXTB8Aloe4oJXnc78yMlqGZnc7Lek6m'),
('51904100005','Farhan','Laki-laki','Jombang','farhan@example.com','081273827563','Islam',1,'1999-03-15','$2y$10$wIlRFzKXYVMljUGlpwCnAu.49zIANhxvfhfpP6VB.CTM.hvXpOo0K');

/* Function  structure for function  `hitung_nilai_akhir` */

/*!50003 DROP FUNCTION IF EXISTS `hitung_nilai_akhir` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `hitung_nilai_akhir`(cp1 INT, cp2 INT, cp3 INT, cp4 INT, uts INT, uas INT) RETURNS char(1) CHARSET utf8mb4
BEGIN
	DECLARE rata DOUBLE;
	DECLARE nilai_akhir CHAR(1);
	SET rata = (SELECT AVG( (COALESCE(cp1,0) + COALESCE(cp2,0) + COALESCE(cp3,0) + COALESCE(cp4,0) + COALESCE(uts,0) + COALESCE(uas,0))/6) );

	IF rata > 90 THEN
		SET nilai_akhir = "A";
	ELSEIF rata > 70 THEN
		SET nilai_akhir = "B";
	ELSEIF rata > 60 THEN
		SET nilai_akhir = "C";
	ELSEIF rata > 50 THEN 
		SET nilai_akhir = "D";
	ELSE
		SET nilai_akhir = "E";
	END IF;
	RETURN (nilai_akhir);
END */$$
DELIMITER ;

/* Procedure structure for procedure `get_list_chat_siswa` */

/*!50003 DROP PROCEDURE IF EXISTS  `get_list_chat_siswa` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `get_list_chat_siswa`(IN nip VARCHAR(11))
BEGIN 
	SELECT murid_id,nama_siswa,guru_id,nama_kelas FROM chats INNER JOIN siswa ON siswa.nis = chats.murid_id 
	INNER JOIN kelas ON siswa.id_kelas = kelas.id_kelas
	WHERE guru_id = nip GROUP BY murid_id;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `send_message_to_siswa` */

/*!50003 DROP PROCEDURE IF EXISTS  `send_message_to_siswa` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `send_message_to_siswa`(IN id_murid VARCHAR(11), IN id_guru VARCHAR(11), IN msg VARCHAR(255))
BEGIN 
        INSERT INTO chats VALUES(NULL, id_murid, id_guru, NOW(), msg, FALSE, FALSE); 
    END */$$
DELIMITER ;

/* Procedure structure for procedure `send_message_to_wali_kelas` */

/*!50003 DROP PROCEDURE IF EXISTS  `send_message_to_wali_kelas` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `send_message_to_wali_kelas`(IN id_murid VARCHAR(11), IN id_guru VARCHAR(11), IN msg VARCHAR(255))
BEGIN 
        INSERT INTO chats VALUES(NULL, id_murid, id_guru, NOW(), msg, FALSE, TRUE); 
    END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
