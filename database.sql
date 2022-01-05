/*
SQLyog Ultimate v12.5.1 (32 bit)
MySQL - 10.5.13-MariaDB-cll-lve : Database - u551918833_eraport
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`u551918833_eraport` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `u551918833_eraport`;

/*Table structure for table `admin` */

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `nama_admin` varchar(255) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `admin` */

insert  into `admin`(`id_admin`,`nama_admin`,`email`,`password`) values 
(2,'Adji','adji@eraports.com','123'),
(3,'Boni','boni@eraports.com','123'),
(4,'Adi','adi@eraports.com','123'),
(5,'Rizky','rizky@eraports.com','123'),
(6,'Rio','rio@eraports.com','123');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `chats` */

insert  into `chats`(`id_chat`,`murid_id`,`guru_id`,`timestamps`,`message`,`is_read`,`is_from_murid`) values 
(1,'51904100001','48295013901','2022-01-03 21:48:14','halo pak',0,1),
(2,'51904100001','48295013901','2022-01-03 21:49:39','halo juga nak',0,0),
(3,'51904100001','48295013901','2022-01-04 12:07:38','mau protes nilai pak',0,1),
(4,'51904100001','48295013901','2022-01-05 06:30:43','oke',0,0),
(5,'51904100001','48295013901','2022-01-05 06:36:42','nilai kamu kenapa nak?',0,0),
(6,'51904100001','48295013901','2022-01-05 06:37:15','oke',0,0);

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
('48295013902','Dimas','Laki-laki','Kalimantan Utara','dimzul@example.com','08134792835','Hindu','Pegawai Negeri Sipil','1990-09-05','$2y$10$d0yyaYNwdPcnJxIgilv8buEL2UPaUEnp7RmqrjCFUSG94mQBR8E1O'),
('48295013903','Rafif','Laki-laki','Surabaya','rafif@example.com','08182748151257','Islam','Pegawai Negeri Sipil','1990-02-18','$2y$10$rfvVQt24AgANr0ARzfoNI.hfSDPO5xcgObE3imR.WR6YtMX7TzZma'),
('48295013904','Yebin','Perempuan','Semarang','yebin@example.com','0888467896','Katolik','Pegawai Negeri Sipil','1990-02-18','$2y$10$rfvVQt24AgANr0ARzfoNI.hfSDPO5xcgObE3imR.WR6YtMX7TzZma'),
('48295013905','Radi','Laki-laki','Jakarta','radi@example.com','0812938192','Islam','Pegawai Negeri Sipil','1990-09-18','$2y$10$vBYTq.EVBdoI2Kt5RmdObucoDQwoxy/vdgNHZ.vn6LdfxEV2iHUNK'),
('48295013906','Fathur','Laki-laki','Temanggung','fathur@example.com','0812734281','Islam','Guru Tidak Tetap','1990-09-18','$2y$10$POPy10FRfar/pF9sFlwsY.o0yjiNJ17NOQAGRNWl0SwILwvqcYLn.'),
('48295013907','Echidna','Perempuan','Jl. Bahagia','echidna@gmail.com','08565472856','Hindu','Pegawai Negeri Sipil','1984-06-05','$2y$10$gyp/L5DbHixMd8f45ieZjeVDtZsNZpdvRJoFKjD8ckR20wtULW5eG'),
('48295013908','kuswantoro','Laki-laki','sambung macan','Kuswan@example','082276812909','Islam','Pegawai Negeri Sipil','1980-06-10','$2y$10$VkCiXmE/oVjX3PgJ6yTqqeFpB8plDnbr3tS.8G2TW5g4wLNyC4S6a'),
('48295013909','Rozaliya','Laki-laki','Surakarta','rozy@gmail.com','0856886546','Islam','Pegawai Negeri Sipil','2022-01-20','$2y$10$bT7PZcsuOSOUDnoZpsUDru0E9fuptBjrGjStKmpFWHt6b4J1QITNq'),
('48295013910','Beni Rohmat','Laki-laki','Magelang','beny_r@gmail.com','08587765435','Islam','Pegawai Negeri Sipil','1987-10-20','$2y$10$M5uq5YkIbB0OMcd8eWP7b.dUe/mVVgySYCCbnyfUGs.R/5B.aOOqW'),
('48295013911','Kurniawati','Perempuan','Sambung macan','kurnia@example.com','082276812910','Islam','Pegawai Negeri Sipil','1890-08-21','$2y$10$ze3k18mhem/HdIxqDtFBaOkdJngfa2.RZ4vOUgMnsoE.gh9gzVtNq'),
('48295013912','Khusnul Khotimah','Perempuan','Kebumen','khusnul@example.com','082276812912','Islam','Pegawai Negeri Sipil','1889-02-05','$2y$10$VfuJZbOfF1/FgcvzH4ShCOub0BAi3t5g5AOVH.42Y7rHr6R/4Yg66'),
('48295013913','Rihannah','Perempuan','Kebumen','rihannah@gmail.com','0858754357','Islam','Pegawai Negeri Sipil','1989-12-28','$2y$10$Ti2jsnk2KhlmFLKlIJSMiu/cMG9s2t1r80GFCj3J492Zyrz9bn9T6'),
('48295013914','Yustira Rahmat','Laki-laki','Yogyakarta','yustira_r@gmail.com','0858765464','Islam','Pegawai Negeri Sipil','1986-05-13','$2y$10$nlHRW2KGwBQJcemkCT8YteL6H6P1bedySOk5CjSQAypcqHG5SQQCi'),
('48295013915','Dimas Edi Jatmiko','Laki-laki','Wates','jatmiko@example.com','082276802913','Islam','Pegawai Negeri Sipil','1891-02-12','$2y$10$utB7XddOZPoxYps2/VTEUu4kfJWo30jJfHm82Z.Ar2c6cpG9O1bkC'),
('48295013916','Ria Suci','Perempuan','Mantingan','Ria@example.com','082276802914','Islam','Pegawai Negeri Sipil','1980-10-13','$2y$10$nUKpmxBglNtAsJ2nsY1mYOPve.9dVuRguzzXifNG2vbYwAozyxy0a'),
('48295013917','Krizgianto','Laki-laki','Yogyakarta','krizgy@gmail.com','0858787546','Katolik','Pegawai Negeri Sipil','1988-12-02','$2y$10$8ELFWkwuqKXxlv.VlXE6huXaSFRvpmEJSF4gdrY195.Ale4jrjYTm'),
('48295013918','Luluk','Perempuan','Mantingan','luluk@example.com','082276802921','Islam','Pegawai Negeri Sipil','1988-11-29','$2y$10$ehkbVo62T7dVwprnya0OsOm7YNVLSOqaqLq0wqXxF24HIPSDUU9q6'),
('48295013919','Andhika','Laki-laki','Bali','andhika@example.com','08172846712','Buddha','Pegawai Negeri Sipil','1990-09-18','$2y$10$0w3qNsR.QUl1kY7.RWa/4e2VPecCgDjBH0QMO.HsvoK5f4wNmxgy2'),
('4829501753','Papipapipa','Laki-laki','Test test','pipa@bocor.com','832164651','Konghuchu','Guru Tetap Yayasan','1997-06-12','$2y$10$fe7at9z0Osge5O/THR525e2SgUAseZ.3QVFF9.MGzit1s3L5gtHK2');

/*Table structure for table `kelas` */

DROP TABLE IF EXISTS `kelas`;

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(30) NOT NULL,
  `nip` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id_kelas`),
  KEY `kelas_ibfk_1` (`nip`),
  CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`nip`) REFERENCES `guru` (`nip`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

/*Data for the table `kelas` */

insert  into `kelas`(`id_kelas`,`nama_kelas`,`nip`) values 
(1,'X IPA A','48295013901'),
(8,'X IPS A','48295013902'),
(9,'X IPA B','48295013903'),
(11,'X IPS B','48295013904');

/*Table structure for table `mata_pelajaran` */

DROP TABLE IF EXISTS `mata_pelajaran`;

CREATE TABLE `mata_pelajaran` (
  `id_mapel` int(11) NOT NULL AUTO_INCREMENT,
  `nama_mapel` varchar(50) NOT NULL,
  `nip` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id_mapel`),
  KEY `mata_pelajaran_ibfk_1` (`nip`),
  CONSTRAINT `mata_pelajaran_ibfk_1` FOREIGN KEY (`nip`) REFERENCES `guru` (`nip`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

/*Data for the table `mata_pelajaran` */

insert  into `mata_pelajaran`(`id_mapel`,`nama_mapel`,`nip`) values 
(7,'Matematika','48295013901'),
(8,'Biologi','48295013902'),
(9,'Sejarah','48295013901'),
(11,'Kimia','48295013903'),
(12,'Bahasa Indonesia','48295013902'),
(13,'Bahasa Inggris','48295013911'),
(14,'Pendidikan Kewarganegaraan','48295013910'),
(16,'Seni Budaya','48295013916');

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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;

/*Data for the table `nilai` */

insert  into `nilai`(`id_nilai`,`nis`,`id_mapel`,`id_raport`,`semester`,`cp1`,`cp2`,`cp3`,`cp4`,`uts`,`uas`,`nilai_akhir`) values 
(2,'51904100001',7,4,1,70,70,70,75,80,70,'B'),
(3,'51904100003',7,5,1,90,80,70,60,50,40,'C'),
(6,'51904100004',7,6,1,80,90,80,70,80,90,'B'),
(8,'51904100005',7,7,1,80,80,80,80,80,80,'B'),
(9,'51904100005',9,7,1,80,80,80,80,80,80,'B'),
(11,'48295013904',7,8,1,89,97,68,79,90,100,'B'),
(13,'48295013905',7,9,1,80,97,68,57,87,59,'B'),
(15,'48295013906',7,10,1,80,97,68,57,98,79,'B'),
(17,'48295013907',7,11,1,80,97,68,89,90,79,'B'),
(19,'48295013909',7,12,1,80,79,86,58,90,80,'B'),
(21,'48295013910',7,13,1,90,89,87,98,70,90,'B'),
(23,'48295013912',7,14,1,90,89,98,70,90,85,'B'),
(25,'48295013908',9,15,1,90,89,75,85,95,80,'B'),
(26,'48295013922',7,16,1,90,80,85,89,75,90,'B'),
(28,'48295013911',7,17,1,80,97,68,80,79,80,'B'),
(29,'48295013912',9,14,1,80,79,80,90,79,80,'B'),
(30,'48295013905',9,9,1,80,79,68,89,90,80,'B');

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

/*Data for the table `raport` */

insert  into `raport`(`id_raport`,`tanggal`,`nis`,`nip`,`tahun_ajaran`,`rapor_semester`) values 
(4,'2022-01-03','51904100001','48295013901',20202021,1),
(5,'2022-01-04','51904100003','48295013901',20202021,1),
(6,'2022-01-04','51904100004','48295013901',20202021,1),
(7,'2022-01-04','51904100005','48295013901',20202021,1),
(8,'2022-01-05','48295013904','48295013901',20202021,1),
(9,'2022-01-05','48295013905','48295013901',20202021,1),
(10,'2022-01-05','48295013906','48295013901',20202021,1),
(11,'2022-01-05','48295013907','48295013901',20202021,1),
(12,'2022-01-05','48295013909','48295013901',20202021,1),
(13,'2022-01-05','48295013910','48295013901',20202021,1),
(14,'2022-01-05','48295013912','48295013901',20202021,1),
(15,'2022-01-05','48295013908','48295013901',20202021,1),
(16,'2022-01-05','48295013922','48295013901',20202021,1),
(17,'2022-01-05','48295013911','48295013901',20202021,1);

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
('48295013904','Aufa Nicolas Nurullah','Perempuan','Bantul','Aufa@gmail.com','088895013904','Konghuchu',1,'2001-12-08','$2y$10$9vsWOK2e/2iVtdDKjcNOTu5Pv6YuurDCWCPXVXJURxiISyEQ/3d0m'),
('48295013905','Edwin Arjanggi','Laki-laki','Bantul','Edwin@gmail.com','088895013905','Katolik',1,'2001-12-08','$2y$10$pTKr2qtTPVJWv5lWbgqfW.76Gn8aalf1rbxoN2FYRa4BK0Znzk2OW'),
('48295013906','Fandy Atsila','Laki-laki','\"Sleman\"','Fandy@gmail.com','088895013906','Katolik',1,'2001-08-08','$2y$10$HiM4mgg7tRFv6XhA6y7xYOeqqxOvcUP7WFi5Mf3a8ogtcfaj8baXC'),
('48295013907','Hafizh Josh','Laki-laki','Wonosari','Hafizh@gmail.com','088895013907','Buddha',1,'2001-11-08','$2y$10$ZqNAIh00dhOEhv/1.YTSruQMHp87l223kc/kcq9nNlF7dgewr7h3a'),
('48295013908','Farqy W','Perempuan','\"Sleman\"','Farqy@gmail.com','088895013908','Kristen',1,'2001-08-08','$2y$10$.IxNZzPSIAtLgiR0Rs8k.ugFnSUabO7HOGXp9.SZXQ6h1ebfsx2.6'),
('48295013909','Tubagus Permatasari','Laki-laki','\"Sleman\"','Tubagus@gmail.com','088895013909','Katolik',1,'2001-12-08','$2y$10$nZ/FH4sMHvDCOx1x9fwXme0dYTAHbd3Cc3bH8Vhbm807XJh268qM.'),
('48295013910','Andrilla Hadyan','Perempuan','Bantul','Andrilla@gmail.com','088895013910','Katolik',1,'2001-03-08','$2y$10$5yaZVl0a1J.wr.39OSP/EeVO8U3KyXeXfDHh6gesCJrlOI/SSJ3sa'),
('48295013911','Fajri Dewanti','Laki-laki','Bantul','Fajri@gmail.com','088895013911','Kristen',1,'2001-03-08','$2y$10$uOqHQRD8POoNoIvgymktne1OxkTfBX0uHYGxa.UE0bg6VkeDoMBYW'),
('48295013912','Permana Aldian','Perempuan','Wonosari','Permana@gmail.com','088895013912','Katolik',1,'2001-07-08','$2y$10$zUg8rucP6zp5u2qyI.ufa.8rCglEfzW0uGP6eBsfyMARv5UU4TCBy'),
('48295013913','Yudha Amanda','Perempuan','Bantul','Yudha@gmail.com','088895013913','Konghuchu',1,'2001-01-08','$2y$10$WoxgimkZ7v7hjx7oWKJVjune3.ZVjjYiHYs.sNjOo7Nk3Bg.Ay9cG'),
('48295013914','Gilang Kartika','Laki-laki','Wates','Gilang@gmail.com','088895013914','Buddha',1,'2001-12-08','$2y$10$t96PT63iXUw/1C0fXLpac.v6URv1mIvjaB8IVdfS2FU7ir9tnTO3q'),
('48295013915','Ogie Sunday','Laki-laki','\"Sleman\"','Ogie@gmail.com','088895013915','Konghuchu',1,'2001-04-08','$2y$10$oSjrJBQTJdGPu.CeWXAtjej6BeaJPd8Z4drSOEiRtRF0Acq64fqsu'),
('48295013916','Aditya Indriastari','Perempuan','\"Sleman\"','Aditya@gmail.com','088895013916','Konghuchu',1,'2001-02-08','$2y$10$L3DNFZ7fwjWQNq1Jgi5Hje/xNS9QWZmWPfIYdIKZ9I73MNhWs/avC'),
('48295013917','Allen Soleha','Perempuan','Bantul','Allen@gmail.com','088895013917','Katolik',1,'2001-11-08','$2y$10$qduTBzLIQRiLxzg4RGA2Zuvp5hMU5DOeCNvSTpVvT06sJH8jsNr12'),
('48295013918','Rio Erdyaning','Perempuan','\"Sleman\"','Rio@gmail.com','088895013918','Islam',1,'2001-11-08','$2y$10$uJBNldPub60d2HZAPmBAr.PuDYzlGgDCyariND/FCS33i9T9RsFAC'),
('48295013919','Mubarak Puspa','Laki-laki','Wates','Mubarak@gmail.com','088895013919','Kristen',1,'2001-07-08','$2y$10$0OSfJmHuq3J1QS6Am37k/eNZQPsCsfkcDMFzIQBCqk1S7epOJV8HG'),
('48295013920','Khaznan Nurfitria','Perempuan','Wates','Khaznan@gmail.com','088895013920','Hindu',1,'2001-01-08','$2y$10$4FZND5sH2NghN5haodMbd.Pk3VDbtVdfS7nBmzCUy3doXKgBiqEv.'),
('48295013921','Daniel Amalia','Laki-laki','\"Sleman\"','Daniel@gmail.com','088895013921','Buddha',1,'2001-07-08','$2y$10$KwbuT0vwdbMbuzYwl1MrbOBwT.RqsAL3BmA6O4RK/qfGtL9V3cpYu'),
('48295013922','Sugraha Al-fathan','Laki-laki','Wates','Sugraha@gmail.com','088895013922','Hindu',1,'2001-11-08','$2y$10$UuWCkV1bdhBpn4sKWc2cOeQc5g43NtvOX8/mCV/Pdi0rfCha2SMly'),
('48295013923','Sofyan Mairessi','Perempuan','Wates','Sofyan@gmail.com','088895013923','Konghuchu',1,'2001-02-08','$2y$10$0IvnJxNnjvtrn74vl53NEOa4wpmKcwN7xTR90SDvSoKNHXJPSDxzm'),
('48295013924','Aggil Haris Husnah','Laki-laki','Wates','Aggil@gmail.com','088895013924','Buddha',1,'2001-04-08','$2y$10$XCGh2pt6DkS97Xrtr3Ixx..qE0NvDnYAf5/HULsdpfxP1BFGpYZ2.'),
('48295013925','Arrivaldi Fauzunuria','Perempuan','Wonosari','Arrivaldi@gmail.com','088895013925','Hindu',1,'2001-12-08','$2y$10$WHqVA8AZrRpbZpF9.re9.eUqepHzJ3p6vSJjDWDL0KrWcu2eFuRWO'),
('48295013926','Agus Rutwan Tio','Perempuan','Wonosari','Agus@gmail.com','088895013926','Konghuchu',1,'2001-09-08','$2y$10$SLahjBMKwORlz4DZX91Nx.s5bJsURYVXSJw31PPzgokOeXiwF2jEW'),
('48295013927','Chaerul Hilmawan','Laki-laki','Bantul','Chaerul@gmail.com','088895013927','Buddha',1,'2001-07-08','$2y$10$3uJAlN16qOH2J3/0cT./1.gn7OTUXE4OkRicjZzyRviX3YpZVoVCi'),
('48295013928','Alrendy Rafles','Laki-laki','Wonosari','Alrendy@gmail.com','088895013928','Hindu',1,'2001-08-08','$2y$10$64ptjN68ZrqQ3q4xJ7AUfOvtZFLPtY2X8k8SZG1DvSFhyk9dkK/NW'),
('48295013929','Julian Lomo','Laki-laki','Wonosari','Julian@gmail.com','088895013929','Kristen',8,'2001-09-08','$2y$10$NFnrYs5S.OFy0uJlXqDCOOw8orhOndtKUHKLWciGDWPMFNulucaP2'),
('48295013930','Fatahillah Sjukri','Perempuan','Wates','Fatahillah@gmail.com','088895013930','Kristen',8,'2001-02-08','$2y$10$7N7cvZg9wIrro4JqMOYWM.WqcbovYSmNdALN5o9BTYAoQb9Q5DIHq'),
('48295013931','Ilyas Afini','Perempuan','Wates','Ilyas@gmail.com','088895013931','Katolik',8,'2001-04-08','$2y$10$yaPppFMUTJtGUvGX/AZ1SeTCkSt.EOoPjq1guv/ub8F3aucBRQBe2'),
('48295013932','Sigit Siliwangi','Laki-laki','Wates','Sigit@gmail.com','088895013932','Hindu',8,'2001-05-08','$2y$10$T2hhBYqwvmkE1x6bp6g/2esIwqudaG1i1ZaQfZxdXkjMLGGzs6bhe'),
('48295013933','Bayu Mulyana','Laki-laki','\"Sleman\"','Bayu@gmail.com','088895013933','Buddha',8,'2001-05-08','$2y$10$ow/IbdYLu.Gt8e73KAEKE.XK3xFQNhbv2EtzColyWDhNC6E.a99Sq'),
('48295013934','Wildan Nustantomo','Laki-laki','Wates','Wildan@gmail.com','088895013934','Buddha',8,'2001-10-08','$2y$10$5Yg53X8W8QMRIzuZegiYFOGHVJzpYu87DExYIMnsLFFU/6etvC81K'),
('48295013935','Joseph Caroline','Laki-laki','Wonosari','Joseph@gmail.com','088895013935','Konghuchu',8,'2001-07-08','$2y$10$IO5Fi5tRPN5odIv7N58xouRyG7Cwm69rS5pLJiRZaXpQi2PLym7.e'),
('48295013936','Sujendro Hernando','Perempuan','Wonosari','Sujendro@gmail.com','088895013936','Kristen',8,'2001-05-08','$2y$10$ozZkhM2M3OmHefPochL.cOJH1.uf/CFKWkVnl2JJZ2CeAHoDlwFny'),
('48295013937','Andrie Hastari','Perempuan','Wates','Andrie@gmail.com','088895013937','Konghuchu',8,'2001-07-08','$2y$10$VSHMuGrOcvWCsZThp5YtaO4Sw/rfkRWbypepHMrARPYY8ks4pEqTi'),
('48295013938','Andhika Alfin Rizkyananta','Laki-laki','Wonosari','Andhika@gmail.com','088895013938','Islam',8,'2001-02-08','$2y$10$ZQ7/hCJltB3D6tR98Cuyy.r4j2pO4i7HyTpIgqtUObVatR.J4JrXO'),
('48295013939','Vito Larascaesara','Perempuan','Wates','Vito@gmail.com','088895013939','Islam',8,'2001-06-08','$2y$10$yJlmg02AKROxNJj9I4QDyeaVdBpwJYAAIymqzkHEi0v1Av3j3vVMq'),
('48295013940','Deristya Zahra','Perempuan','Wates','Deristya@gmail.com','088895013940','Konghuchu',8,'2001-07-08','$2y$10$3W6OsaDI6aVK1PNka9R9reDW17Jo6xS1zV9WAj.XhYsV5Je0qOrKO'),
('48295013941','Ismail Pradipta','Perempuan','Wonosari','Ismail@gmail.com','088895013941','Kristen',8,'2001-04-08','$2y$10$TcmA6wrp3xEv0JBmDhiDROGaG8P1LY8dj4kZ9Jw9cSYj5fUL9d8nq'),
('48295013942','Arrivalda Hardianti','Laki-laki','\"Sleman\"','Arrivalda@gmail.com','088895013942','Katolik',8,'2001-12-08','$2y$10$asLEUQNiYJ1Jb5HDEQPl..HndRrKjw.7ibWBeE/Ir.VQWvLDakj/i'),
('48295013943','Faishal Zonanda','Laki-laki','Bantul','Faishal@gmail.com','088895013943','Islam',8,'2001-08-08','$2y$10$vmeHtfpyQUC7FK/YEcjZoeEbC.UDO3TcverTwffVTJAhtpwJo5Y9u'),
('48295013944','Adam Sumlang','Perempuan','Bantul','Adam@gmail.com','088895013944','Hindu',8,'2001-01-08','$2y$10$vyI8IuvAFO7EemWKWEvY.ez4gyCCThtdzMl1taWijKcg6zI1Kk2Oe'),
('48295013945','Fitra Aulia','Laki-laki','\"Sleman\"','Fitra@gmail.com','088895013945','Katolik',8,'2001-12-08','$2y$10$pm4PPZZdlqpGxFEB.XzDPOfzOUrNNHm2h269qe7RAaUwKTU5BnuVu'),
('48295013946','Dhanu Febrianto','Perempuan','\"Sleman\"','Dhanu@gmail.com','088895013946','Katolik',8,'2001-07-08','$2y$10$vRghS42mqV.r9yjXd8cxBO7rIOGq3W3pkVCb5NXHD6uj6HGhQ8htS'),
('48295013947','Arthur Nizliandry','Laki-laki','Bantul','Arthur@gmail.com','088895013947','Kristen',8,'2001-04-08','$2y$10$KbT9SGSh5FyVj/adE4mauO.VY1HbdUeLDb8IPw2YAhYY3.tH.JEcm'),
('48295013948','Syahid Gayatri','Laki-laki','Wonosari','Syahid@gmail.com','088895013948','Katolik',8,'2001-01-08','$2y$10$VWE7SSlFbeAXXMlIYfWMkOFejK/MAUx6GyKWlGBEO6XZXn/ws1sxK'),
('48295013949','Dikposa Wardani','Perempuan','Bantul','Dikposa@gmail.com','088895013949','Buddha',8,'2001-01-08','$2y$10$ZKLM9.VxqfFGHnLuAqPe.OkfG/xfK.9n/AowUHURJY/uAjzo79lBu'),
('48295013950','Adhim Narimanda','Perempuan','Bantul','Adhim@gmail.com','088895013950','Islam',8,'2001-10-08','$2y$10$NEE9i.2h1XEUVyYwjHjnre33yksnGrx9kBB6CLPT3AFG7lPgoEWWa'),
('48295013951','Mohamad Fahmi Antoni','Perempuan','Wates','Mohamad@gmail.com','088895013951','Islam',8,'2001-07-08','$2y$10$poZA0A5QQlIQnqBPFHXPPuJ8bJzJXpwem4GLFjAxRVYhema9ia.aK'),
('48295013952','Humam Avicenna Wiguna','Perempuan','\"Sleman\"','Humam@gmail.com','088895013952','Islam',8,'2001-02-08','$2y$10$ksTPFY6f69bg13B7HaERYe4/Z4BT8nTXgDLUC6uMdWvOMgNP48GKG'),
('48295013953','Thomas Fajria','Perempuan','\"Sleman\"','Thomas@gmail.com','088895013953','Islam',8,'2001-02-08','$2y$10$jR.kQA/ht2pLQZgYUcEHdO9zcMMC5lmAvR8gOe.0mTv4/P6rWyugW'),
('48295013954','Rusdi Restiandari','Laki-laki','Wates','Rusdi@gmail.com','088895013954','Islam',9,'2001-08-08','$2y$10$61Kqti.GUIkFTDxuw3.eMuaIgdL4UKbARzrP8PO2VvYZGegaa4Ipe'),
('48295013955','Yuda Aldo Yuniara','Laki-laki','Bantul','Yuda@gmail.com','088895013955','Buddha',9,'2001-01-08','$2y$10$CC26K0nlvhR1pLBRuGYM1OSThqyg9jHby41TIjrYYHH7HC8KImrc2'),
('48295013956','Mohamad Siahainenia','Perempuan','Wates','Mohamad@gmail.com','088895013956','Islam',9,'2001-07-08','$2y$10$2jHg5uHvJwV7Kk3U9SM1xehbELvd1ea.jiYPnmgxk4DhWpreKJDS2'),
('48295013957','Asyrafi Soleha','Perempuan','Bantul','Asyrafi@gmail.com','088895013957','Konghuchu',9,'2001-01-08','$2y$10$Rt43znSHWsucOmWjuM0XBu3encG4rN8jmqfnwBbDOgQyTzMEM4xF.'),
('48295013958','Marvel P','Perempuan','Bantul','Marvel@gmail.com','088895013958','Islam',9,'2001-05-08','$2y$10$tt2dxvphJl.7dL4ADTsg/ej59tlmgiGFYglxWSYIcXNkkHeubzLaO'),
('48295013959','Joseph Deristya Karina','Laki-laki','\"Sleman\"','Joseph@gmail.com','088895013959','Konghuchu',9,'2001-12-08','$2y$10$WrW1egdeitDzOVv.GjxzHukAs0f7WsCqhq9HM9vPAOj7nbmVaxrlK'),
('48295013960','Hafizh Yahya','Perempuan','Wates','Hafizh@gmail.com','088895013960','Kristen',9,'2001-02-08','$2y$10$fhXznNJDMhyaPXVAv8Cqme1cEAHIKAS/co1Y88v5zttJhyPtNhwBq'),
('48295013961','Arfan Ridho','Laki-laki','Wates','Arfan@gmail.com','088895013961','Islam',9,'2001-06-08','$2y$10$SguRGiiJ6.5/yzhRISDFt.ebxgk7YvXz5E2bX9r64P9Wl7yeIjYQK'),
('48295013962','Mustofa Kinandatsani','Perempuan','Wonosari','Mustofa@gmail.com','088895013962','Hindu',9,'2001-01-08','$2y$10$2UCVfsiFYUy5B.f9H7e.P.BakBTqyNH8Xo/pC9gYG5zdR72hFH1lG'),
('48295013963','Sofyan Noviana','Perempuan','Wonosari','Sofyan@gmail.com','088895013963','Katolik',9,'2001-06-08','$2y$10$usfLfGJVQP84lzchUyx8IuSBayz0Ha8i5tGpMduryLzCqCmCKEbxW'),
('48295013964','Aulia Wicaksono','Laki-laki','Wonosari','Aulia@gmail.com','088895013964','Buddha',9,'2001-06-08','$2y$10$fgVU0YzaZodjzT6rACGtzeugRqeR3/pU1ZmSptKJtgUq38lI5OV8a'),
('48295013965','Fahlian I Amaliya','Perempuan','Bantul','Fahlian@gmail.com','088895013965','Katolik',9,'2001-02-08','$2y$10$vwHIur2J4dZMrlrJHMJtuuPuvqyUN2xLmAr2Cw4FOQ2WE0/MnjJsS'),
('48295013966','Farqy Ogie Apriliani','Perempuan','Wates','Farqy@gmail.com','088895013966','Islam',9,'2001-06-08','$2y$10$2EMmS9HQUxXrBciksmjMe.XbCa7svPfSsH4KhWgODExTnmAivymIm'),
('48295013967','Sebastian Hotasi','Perempuan','\"Sleman\"','Sebastian@gmail.com','088895013967','Islam',9,'2001-03-08','$2y$10$xZu4RminIu/xzbXL1bgtY.1//Y0v9XY8Nwgyr2RFmuE3gFfOZRRFy'),
('48295013968','Kenneth Farida','Perempuan','Wonosari','Kenneth@gmail.com','088895013968','Konghuchu',9,'2001-12-08','$2y$10$7MLnM4DIpBnETBLyGZGX0eINsQm1fgnNX80jXspp7oagcrSL4rfDG'),
('48295013969','Ressy Ramadhany','Laki-laki','Wonosari','Ressy@gmail.com','088895013969','Kristen',9,'2001-02-08','$2y$10$eCFo6iOJKfuvizTD/ZDqRukRvsRwCvJHph4f.xvbkzCgsUDDVBSdS'),
('48295013970','Dwiki Saputra','Perempuan','Wonosari','Dwiki@gmail.com','088895013970','Hindu',9,'2001-04-08','$2y$10$cK96XjEgQ4MPdkGSkYxUoO/ok5YraxB6pK9wa5GWoWvWFuURK8V5u'),
('48295013971','Firas Shalimah','Perempuan','Wates','Firas@gmail.com','088895013971','Katolik',9,'2001-02-08','$2y$10$xnuvZsRVGUMTq7xEqO6oV.L4bA8KWcJryJqNpnwK/TO49Oa/G7ROK'),
('48295013972','Cardito Fathir','Perempuan','Bantul','Cardito@gmail.com','088895013972','Buddha',9,'2001-01-08','$2y$10$zHCf..Pl.k8unucPFarkEOlHXFJThV.lwVqnIdv3zk/CDARQISVNu'),
('48295013973','Emir Sumandi Larassati','Perempuan','Bantul','Emir@gmail.com','088895013973','Islam',9,'2001-07-08','$2y$10$UzXe/D8tal7e2V7NQHfR5ui/SqdKbK9Mg5gcWwny3lignIieePNeC'),
('48295013974','Yoedhistiera Abrianto','Perempuan','Wonosari','Yoedhistiera@gmail.com','088895013974','Katolik',9,'2001-05-08','$2y$10$JNB/H2y2jBYyvdTJtYbnm.Hb.Nn74y1wpZzbEOnkJ3.aLAXldnveK'),
('48295013975','Naufal Isnaini','Laki-laki','Wonosari','Naufal@gmail.com','088895013975','Buddha',9,'2001-04-08','$2y$10$15iklxL3aitbvB7H9Jc8Xe/.zUWsvd.9g8PZ.6eH28J.ezxi1xAQ6'),
('48295013976','Surya Hidayat','Laki-laki','\"Sleman\"','Surya@gmail.com','088895013976','Islam',9,'2001-06-08','$2y$10$Q9aGVtqlA3X/VCdUCM9Qtek2DXUvOMMhYUS6VjQtDbILbGwWtECM.'),
('48295013977','Mark Reynaldi Purba','Perempuan','\"Sleman\"','Mark@gmail.com','088895013977','Hindu',9,'2001-09-08','$2y$10$gpuXGbGsmh9bt6TuuDRkH.rMmofjGQo9OyU8EB5qKQn.Lo6JLEJTS'),
('48295013978','Alditio Andjani','Laki-laki','\"Sleman\"','Alditio@gmail.com','088895013978','Islam',9,'2001-01-08','$2y$10$fY5fqe4haQdcKjzVcr12mOUC7xnU4x//bXzv1XhQPAzdZ1ZDWnDte'),
('48295013979','Rinno Arisa','Laki-laki','Wonosari','Rinno@gmail.com','088895013979','Buddha',11,'2001-04-08','$2y$10$Y24ULsKo5UiMHdu.v.qaqed.4YSLaZRiaDPEL4TMzhsW8/eZv3v6q'),
('48295013980','Julian Mufti','Laki-laki','Bantul','Julian@gmail.com','088895013980','Konghuchu',11,'2001-12-08','$2y$10$XLkGtP8ak2hGQjjNDyenMO4JS5ohZvpTDriC9qTjoTt.ghJfTseXq'),
('48295013981','Mohammad Hasudungan','Perempuan','Wonosari','Mohammad@gmail.com','088895013981','Islam',11,'2001-12-08','$2y$10$eh9iKScF6.DRN1ecG9IE1eLMpjZcque7mryfspWH/qbJsjpWQ20sK'),
('48295013982','Ario Azhari','Perempuan','Bantul','Ario@gmail.com','088895013982','Hindu',11,'2001-03-08','$2y$10$pzjxxXDmtbzfCizYr7pMW./NebS8AB70deZ30FFNAIZ8FrMm4Hfvy'),
('48295013983','Avicenna Larasati','Perempuan','Wates','Avicenna@gmail.com','088895013983','Buddha',11,'2001-09-08','$2y$10$TmtwpLyOFMO1NQZ1r8Y4febmFbT5vDpg5Y34fZrkS87k6lJKmdOr6'),
('48295013984','Mario Viena','Perempuan','Wates','Mario@gmail.com','088895013984','Kristen',11,'2001-03-08','$2y$10$sZcqIseo9.juVeMR6xWv6OFpDI6EKT9nXiWZ0ZGxrx/yRNaD1P9s.'),
('48295013985','Rifqi Setyawati','Perempuan','Wonosari','Rifqi@gmail.com','088895013985','Katolik',11,'2001-06-08','$2y$10$TEBzg2JOeFN.mdniyzWku.z/0g4nIINpOD8H.cMH44wwVicKFg.5S'),
('48295013986','Abdul Franclin','Perempuan','Bantul','Abdul@gmail.com','088895013986','Kristen',11,'2001-12-08','$2y$10$Z1hg9Md/KHA5dVeMx2anquc/.dPH4Bb3uzCwKrKqxoP1chiaTEFqO'),
('48295013987','Ramanta Adi Islami','Laki-laki','Bantul','Ramanta@gmail.com','088895013987','Hindu',11,'2001-06-08','$2y$10$EuRsmmKdaSjWF/uQg/ewiObqd/krRhUE.6Zrke1laP/0MQOGXG.nO'),
('48295013988','Ficky Khansa','Laki-laki','Bantul','Ficky@gmail.com','088895013988','Katolik',11,'2001-10-08','$2y$10$m/x5/U3/FUiio5pM.7YZHu9CRDFNiYuUsvjCEla1pXcauEq/N4H1q'),
('48295013989','Doni Hermawaty','Perempuan','\"Sleman\"','Doni@gmail.com','088895013989','Buddha',11,'2001-05-08','$2y$10$MMtrTfr0IG4l25.t7o6IqODiHf8NFNAE.RtDQ.cRXSqJOOB3D7wuK'),
('48295013990','Beckley Tobing','Laki-laki','Wonosari','Beckley@gmail.com','088895013990','Buddha',11,'2001-09-08','$2y$10$WbV6IEw3hw15PLc7bhctU.aOMV/ZpdqSVwovFYb7sdN0u3aWklxUe'),
('48295013991','Gilang Imran','Laki-laki','\"Sleman\"','Gilang@gmail.com','088895013991','Konghuchu',11,'2001-01-08','$2y$10$q3W.Hum9qh8mxiqMWT8Dcuf7lw406TUuYv.VUBlRvXdqj2zppAhPa'),
('48295013992','Romario Ari Yasin','Laki-laki','Wates','Romario@gmail.com','088895013992','Hindu',11,'2001-04-08','$2y$10$BAfH0Dwk1NQsTOQG/wJe8u6UsaWzBgpJ45uULx96U0vtTRiN2HgQu'),
('48295013993','Reynaldi Hamdi','Laki-laki','\"Sleman\"','Reynaldi@gmail.com','088895013993','Buddha',11,'2001-06-08','$2y$10$.XyypSDE17tw2ylDzc94peF2HuuKk6hYdVs60r3DzHkgQiwQ.3PIe'),
('48295013994','Rinaldy Ardina','Laki-laki','Bantul','Rinaldy@gmail.com','088895013994','Buddha',11,'2001-01-08','$2y$10$bDfWR2puRkxgtuRSKjE1ieakjbEswnUYt2AymaTFTRZBfjadi979C'),
('48295013995','Ferhat Oktaviaman','Perempuan','Bantul','Ferhat@gmail.com','088895013995','Kristen',11,'2001-11-08','$2y$10$ZJmFI.13uiU3N6JVvY3fQOclmTIqfXqMnhXZQk65fczjL.4F.JePS'),
('48295013996','Nicolas Aruti','Laki-laki','Wonosari','Nicolas@gmail.com','088895013996','Buddha',11,'2001-07-08','$2y$10$hs/G9H0D64z8TiTAoOu9c.LPIUbpTqfElgFwVBFIzmmjsEJ.reKTq'),
('48295013997','Banni Ramadhan','Perempuan','\"Sleman\"','Banni@gmail.com','088895013997','Kristen',11,'2001-07-08','$2y$10$kzCF1FYwaADbk9JTUcjjBOPoa//TwjGc/jXDiaeVkdO.wF4VYTSjG'),
('48295013998','Devito Tenriajeng','Perempuan','\"Sleman\"','Devito@gmail.com','088895013998','Islam',11,'2001-02-08','$2y$10$U7jgruLgz55MnLt5O6mnnuRPSyY5gRcQ3iTMOQip93d8MQUFmyyfm'),
('48295013999','Aufa Amar Cahyadi','Laki-laki','Wonosari','Aufa@gmail.com','088895013999','Hindu',11,'2001-02-08','$2y$10$QCL8taLRCozzTagieYw5Pu9/UOKSdmMQ0xOf1vTVseNzBoSBDzgn6'),
('48295014000','Finaldi Wardhani','Perempuan','Bantul','Finaldi@gmail.com','088895014000','Buddha',11,'2001-06-08','$2y$10$Nt8qDgt12vONKcr6rNzEpOA1Ko5B3ZCEXOGNsNlv0e7kRZ2G2riGS'),
('48295014001','Khaznan Widyawati','Perempuan','Bantul','Khaznan@gmail.com','088895014001','Islam',11,'2001-02-08','$2y$10$xv8KOCnIhHSD9iZdg12cgeIur5fnHyEOTNK3bhT5.177rDNjmWFIO'),
('48295014002','Dhika Saura','Laki-laki','Wonosari','Dhika@gmail.com','088895014002','Buddha',11,'2001-04-08','$2y$10$ThGfOuK2WxXRRH31g4ydnuGDx1mc0QjH4C7LXUnMcjAqmSLpLyTJK'),
('48295014003','Muhamad Mirza','Laki-laki','Wonosari','Muhamad@gmail.com','088895014003','Islam',11,'2001-09-08','$2y$10$17ChNfNFB2yJOfFFm4sQveDJ3XHd3SwbR0djFSQEHx4F.fZsh4T3m'),
('51904100001','Agus','Laki-laki','Wonogiri','aguskoen@example.com','08123456789','Kristen',1,'2021-12-26','$2y$10$AdCdBks.gd8kHSjtMAhHiOvlyJgixL9Aksar1Bnp6OFse5qW303aS'),
('51904100002','Wansyah','Laki-laki','Sulawesi Selatan','wanca@example.com','08123791259812','Islam',8,'2000-09-18','$2y$10$yB.TuGgbUMjLSW56Km9gguSbqHES4uQtb4.SIeqHSt7yLublgS0gq'),
('51904100003','Radi','Laki-laki','Jakarta','radi@example.com','081273491876','Islam',1,'1999-08-19','$2y$10$G6fyocq7VenvHEUFLSoVbupp5XK/DV5ygcskRBjang6mk/reF5xI.'),
('51904100004','Putra','Laki-laki','Surabaya','putra@example.com','082192871928','Kristen',1,'1999-09-18','$2y$10$2yvnmXsL8WcpOvizxXi3PeZXTB8Aloe4oJXnc78yMlqGZnc7Lek6m'),
('51904100005','Farhan Aji','Laki-laki','Jombang','farhan@example.com','081273827563','Buddha',1,'1999-03-15','$2y$10$/eq.JMVp/rl5tOqVrBVLS.9izdSL0ZOZKAGXcVoZenDzks63JYbvS'),
('51904100006','Riyan','Laki-laki','Purworejo','riyan@example.com','082283713934','Islam',1,'1999-02-01','$2y$10$z6eVQm49ohYXiNCXia0tturiAWZflGTMSagubsV6QG7spN/uLU7cS'),
('51904100007','Reva','Perempuan','Purworejo','reva@example.com','082282157984','Kristen',9,'2001-07-30','$2y$10$g6fPoGF.5LYPl.Fj2nm1BeOMWpuRtGCBi/BYFSF3UzGMKeiwxgNdK'),
('51904100008','Raihan','Laki-laki','Temanggung','raihan@example.com','081285478217','Islam',1,'1999-01-18','$2y$10$AwXlbg4.Dhzu.REjdULKveXww6XGYHdZyvV9BDsd/UddzpTKW5E7i'),
('51904100045','Muhammad krisna','Laki-laki','Sleman','krisna@example.com','082276802920','Islam',9,'2000-09-29','$2y$10$P249j42XpPh4F79GILeO3u03ALIbNHChRB7OErgQLdI6dv8NwjN2u'),
('51904100046','Ananda Wuchi','Perempuan','Mantingan','nanda@example.com','082276802919','Islam',11,'1999-06-12','$2y$10$CabrGIG.ahS2ZsB4FwwsPeSykgiDMwTkkbgwhqA/sQiIZInBG6fd.'),
('51904100047','Oktaviani','Perempuan','Klaten','okta@example.com','082276802916','Islam',11,'2001-08-27','$2y$10$k6hfYKZKKJQaqOr8h48rR.SNWfsIPLrVPwQ.0NFgdPuUnK4WXV3.G'),
('51904100048','Komarudin','Laki-laki','Bantul','komar@example.com','082276802918','Islam',11,'2001-01-09','$2y$10$oJCTe/fB2nk7L1hXWpVIx.jYs3m0o.RBHiMJrFLqRUx4ePmHd0.tK'),
('51904100049','Solihin','Laki-laki','Yogyakarta','solihin@example.com','082276802917','Islam',11,'1989-04-23','$2y$10$g7lFhLFUe5wHBfG7ynjLTOxIiZP5FrxT8uiYdQjCYHi0gdvpqnla2'),
('51904100050','Amelia Risti','Perempuan','Purworejo','Amelia@example.com','082276802915','Islam',11,'1988-06-16','$2y$10$GwwCgpwe/WIMR5lTTrbNu.0jz5bcaM3TEEQxxKzQyo4IIIh2v.HDO');

/* Function  structure for function  `hitung_nilai_akhir` */

/*!50003 DROP FUNCTION IF EXISTS `hitung_nilai_akhir` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`u551918833_hostinger`@`%` FUNCTION `hitung_nilai_akhir`(cp1 INT, cp2 INT, cp3 INT, cp4 INT, uts INT, uas INT) RETURNS char(1) CHARSET utf8mb4
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

/* Procedure structure for procedure `buat_raport` */

/*!50003 DROP PROCEDURE IF EXISTS  `buat_raport` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`u551918833_hostinger`@`%` PROCEDURE `buat_raport`(
in nis_siswa varchar(11),
in nip_walikelas varchar(11),
in thnajaran int(11),
in raporsmt int(11)
)
BEGIN
    INSERT INTO raport (tanggal, nis, nip, tahun_ajaran, rapor_semester) 
    VALUES (CURRENT_DATE(), nis_siswa, nip_walikelas, thnajaran, raporsmt);
    SELECT LAST_INSERT_ID() AS InsertId;
END */$$
DELIMITER ;

/* Procedure structure for procedure `get_list_chat_siswa` */

/*!50003 DROP PROCEDURE IF EXISTS  `get_list_chat_siswa` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`u551918833_hostinger`@`%` PROCEDURE `get_list_chat_siswa`(IN nip VARCHAR(11))
BEGIN 
	SELECT murid_id,nama_siswa,guru_id,nama_kelas FROM chats INNER JOIN siswa ON siswa.nis = chats.murid_id INNER JOIN kelas ON siswa.id_kelas = kelas.id_kelas WHERE guru_id = 48295013901 GROUP BY murid_id;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `send_message_to_siswa` */

/*!50003 DROP PROCEDURE IF EXISTS  `send_message_to_siswa` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`u551918833_hostinger`@`%` PROCEDURE `send_message_to_siswa`(IN id_murid VARCHAR(11), IN id_guru VARCHAR(11), IN msg VARCHAR(255))
BEGIN 
        INSERT INTO chats VALUES(NULL, id_murid, id_guru, NOW(), msg, FALSE, FALSE); 
    END */$$
DELIMITER ;

/* Procedure structure for procedure `send_message_to_wali_kelas` */

/*!50003 DROP PROCEDURE IF EXISTS  `send_message_to_wali_kelas` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`u551918833_hostinger`@`%` PROCEDURE `send_message_to_wali_kelas`(IN id_murid VARCHAR(11), IN id_guru VARCHAR(11), IN msg VARCHAR(255))
BEGIN 
        INSERT INTO chats VALUES(NULL, id_murid, id_guru, NOW(), msg, FALSE, TRUE); 
    END */$$
DELIMITER ;

/* Procedure structure for procedure `tambah_data_guru` */

/*!50003 DROP PROCEDURE IF EXISTS  `tambah_data_guru` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`u551918833_hostinger`@`%` PROCEDURE `tambah_data_guru`(
in nipguru varchar(11),
in namaguru varchar(50),
in jenkelguru enum('Laki-laki','Perempuan'),
in alamatguru text,
in emailguru varchar(30),
in notelpguru varchar(14),
in agamaguru enum('Buddha','Hindu','Islam','Katolik','Konghuchu','Kristen'),
in statusguru varchar(20),
in tgllahirguru date,
in passwordguru varchar(255)
)
BEGIN
    INSERT INTO guru(nip, nama_guru, jenis_kelamin, alamat, email, no_telp, agama, status, tanggal_lahir, password)
        VALUES (nipguru,namaguru,jenkelguru,alamatguru,emailguru,notelpguru,agamaguru,statusguru,tgllahirguru,passwordguru);
END */$$
DELIMITER ;

/* Procedure structure for procedure `tambah_data_siswa` */

/*!50003 DROP PROCEDURE IF EXISTS  `tambah_data_siswa` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`u551918833_hostinger`@`%` PROCEDURE `tambah_data_siswa`(
in nissiswa varchar(11),
in namasiswa varchar(50),
in jenkelsiswa enum('Laki-laki','Perempuan'),
in alamatsiswa text,
in emailsiswa varchar(30),
in notelpsiswa varchar(14),
in agamasiswa enum('Buddha','Hindu','Islam','Katolik','Konghuchu','Kristen'),
in kelassiswa int(11),
in tgllahirsiswa date,
in passwordsiswa varchar(255)
)
BEGIN
    INSERT INTO siswa(nis, nama_siswa, jenis_kelamin, alamat, email, no_telp, agama, id_kelas, tanggal_lahir, password)
        VALUES (nissiswa, namasiswa, jenkelsiswa, alamatsiswa, emailsiswa, notelpsiswa, agamasiswa, kelassiswa, tgllahirsiswa, passwordsiswa);
END */$$
DELIMITER ;

/* Procedure structure for procedure `tambah_kelas` */

/*!50003 DROP PROCEDURE IF EXISTS  `tambah_kelas` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`u551918833_hostinger`@`%` PROCEDURE `tambah_kelas`(
in nipwali varchar(11),
in namakelas varchar(30)
)
BEGIN
    INSERT INTO kelas(nip, nama_kelas) VALUES (nipwali, namakelas);
END */$$
DELIMITER ;

/* Procedure structure for procedure `tambah_mapel` */

/*!50003 DROP PROCEDURE IF EXISTS  `tambah_mapel` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`u551918833_hostinger`@`%` PROCEDURE `tambah_mapel`(
in nipwali varchar(11),
in namamapel varchar(50)
)
BEGIN
    INSERT INTO mata_pelajaran(nip, nama_mapel) VALUES (nipwali, namamapel);
END */$$
DELIMITER ;

/* Procedure structure for procedure `tambah_nilai` */

/*!50003 DROP PROCEDURE IF EXISTS  `tambah_nilai` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`u551918833_hostinger`@`%` PROCEDURE `tambah_nilai`(
in nis_siswa varchar(11),
in id_mapel int(11),
in id_raport INT(11),
in smt INT(11),
in cp1 INT(11),
in cp2 INT(11),
in cp3 INT(11),
in cp4 INT(11),
in uts INT(11),
in uas INT(11)
)
BEGIN
    INSERT INTO nilai(nis, id_mapel, id_raport, semester, cp1, cp2, cp3, cp4, uts, uas, nilai_akhir) 
    VALUES (nis_siswa, id_mapel, id_raport, smt, cp1, cp2, cp3, cp4, uts, uas, hitung_nilai_akhir(cp1, cp2, cp3, cp4, uts, uas));
END */$$
DELIMITER ;

/* Procedure structure for procedure `ubah_data_guru` */

/*!50003 DROP PROCEDURE IF EXISTS  `ubah_data_guru` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`u551918833_hostinger`@`%` PROCEDURE `ubah_data_guru`(
in nipguru varchar(11),
in namaguru varchar(50),
in jenkelguru enum('Laki-laki','Perempuan'),
in alamatguru text,
in emailguru varchar(30),
in notelpguru varchar(14),
in agamaguru enum('Buddha','Hindu','Islam','Katolik','Konghuchu','Kristen'),
in statusguru varchar(20),
in tgllahirguru date,
in passwordguru varchar(255)
)
BEGIN
    UPDATE guru SET nip=nipguru, nama_guru=namaguru, jenis_kelamin=jenkelguru, alamat=alamatguru, email=emailguru, no_telp=notelpguru, agama=agamaguru, status=statusguru, tanggal_lahir=tgllahirguru, password=passwordguru WHERE nip=nipguru;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ubah_data_siswa` */

/*!50003 DROP PROCEDURE IF EXISTS  `ubah_data_siswa` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`u551918833_hostinger`@`%` PROCEDURE `ubah_data_siswa`(
in nissiswa varchar(11),
in namasiswa varchar(50),
in jenkelsiswa enum('Laki-laki','Perempuan'),
in alamatsiswa text,
in emailsiswa varchar(30),
in notelpsiswa varchar(14),
in agamasiswa enum('Buddha','Hindu','Islam','Katolik','Konghuchu','Kristen'),
in kelassiswa int(11),
in tgllahirsiswa date,
in passwordsiswa varchar(255)
)
BEGIN
    UPDATE siswa SET nis=nissiswa, nama_siswa=namasiswa, jenis_kelamin=jenkelsiswa, alamat=alamatsiswa, email=emailsiswa, no_telp=notelpsiswa, agama=agamasiswa, id_kelas=kelassiswa, tanggal_lahir=tgllahirsiswa, password=passwordsiswa WHERE nis=nissiswa;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ubah_kelas` */

/*!50003 DROP PROCEDURE IF EXISTS  `ubah_kelas` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`u551918833_hostinger`@`%` PROCEDURE `ubah_kelas`(
in idkelas int(11),
in nipwali varchar(11),
in namakelas varchar(30)
)
BEGIN
    UPDATE kelas SET nip=nipwali, nama_kelas=namakelas WHERE id_kelas=idkelas;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ubah_mapel` */

/*!50003 DROP PROCEDURE IF EXISTS  `ubah_mapel` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`u551918833_hostinger`@`%` PROCEDURE `ubah_mapel`(
in idmapel int(11),
in nipwali varchar(11),
in namamapel varchar(50)
)
BEGIN
    UPDATE mata_pelajaran SET nip=nipwali, nama_mapel=namamapel WHERE id_mapel=idmapel;
END */$$
DELIMITER ;

/* Procedure structure for procedure `ubah_nilai` */

/*!50003 DROP PROCEDURE IF EXISTS  `ubah_nilai` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`u551918833_hostinger`@`%` PROCEDURE `ubah_nilai`(
in nis_siswa varchar(11),
in id_mapel int(11),
in smt INT(11),
in cp1 INT(11),
in cp2 INT(11),
in cp3 INT(11),
in cp4 INT(11),
in uts INT(11),
in uas INT(11)
)
BEGIN
    UPDATE nilai SET cp1 = cp1, cp2 = cp2, cp3 = cp3, cp4 = cp4, uts = uts, uas = uas, nilai_akhir = hitung_nilai_akhir(cp1, cp2, cp3, cp4, uts, uas) WHERE nis = nis_siswa AND id_mapel = id_mapel AND semester = smt;
END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
