CREATE DATABASE eraport;
USE eraport;

CREATE TABLE `guru` (
  `nip` INT(11) NOT NULL,
  `nama_guru` VARCHAR(50) NOT NULL,
  `jenis_kelamin` ENUM('Laki-laki','Perempuan') NOT NULL,
  `alamat` TEXT NOT NULL,
  `email` VARCHAR(30) NOT NULL,
  `no_telp` INT(14) NOT NULL,
  `agama` ENUM('Islam','Kristen','Katolik','Hindu','Budha', 'Konghuchu') NOT NULL,
  `status` VARCHAR(20) NOT NULL,
  `tanggal_lahir` DATE NOT NULL,
  `password` TEXT NOT NULL,
  PRIMARY KEY(nip)
);

CREATE TABLE `kelas` (
  `id_kelas` INT(11) NOT NULL,
  `nama_kelas` VARCHAR(30) NOT NULL,
  `nip` INT(11) NOT NULL,
  PRIMARY KEY(id_kelas),
  FOREIGN KEY(nip) REFERENCES guru(nip)
); 
CREATE TABLE `orang_tua` (
  `id_ortu` INT(11) NOT NULL,
  `nama` VARCHAR(50) NOT NULL,
  `alamat` TEXT NOT NULL,
  `no_tlp` INT(14) NOT NULL,
  `pekerjaan` VARCHAR(30) NOT NULL,
  `status` TEXT NOT NULL,
  `agama` ENUM('islam','kristen','katolik','hindu','budha') NOT NULL,
  `password` VARCHAR(20) NOT NULL,
  PRIMARY KEY(id_ortu)
);

CREATE TABLE `siswa` (
  `nis` INT(11) NOT NULL,
  `nama_siswa` VARCHAR(50) NOT NULL,
  `jenis_kelamin` ENUM('Laki-laki','Perempuan') NOT NULL,
  `alamat` TEXT NOT NULL,
  `email` VARCHAR(50) NOT NULL,
  `tanggal_lahir` DATE NOT NULL,
  `agama` ENUM('Islam','Kristen','Katolik','Hindu','Budha', 'Konghuchu') NOT NULL,
  `no_telp` INT(14) NOT NULL,
  `id_kelas` INT(11) NOT NULL,
  `password` VARCHAR(20) NOT NULL,
  PRIMARY KEY(nis),
  FOREIGN KEY (id_kelas) REFERENCES kelas(id_kelas)
);



CREATE TABLE `mata_pelajaran` (
  `id_mapel` INT(11) NOT NULL,
  `nip` INT(11) NOT NULL,
  `nama_mapel` VARCHAR(20) NOT NULL,
  `keterangan` TEXT NOT NULL,
  PRIMARY KEY (id_mapel),
  FOREIGN KEY (nip) REFERENCES guru(nip) 
);

CREATE TABLE nilai(
id_nilai INT AUTO_INCREMENT,
nis INT(11) NOT NULL,
id_mapel INT(11) NOT NULL,
cp1 INT,
cp2 INT,
uts INT,
cp3 INT,
cp4 INT,
nilai_akhir VARCHAR(1),
keterangan TEXT,
PRIMARY KEY (id_nilai),
FOREIGN KEY (id_mapel) REFERENCES mata_pelajaran(id_mapel),
FOREIGN KEY (nis) REFERENCES siswa(nis),
);

CREATE TABLE IF NOT EXISTS chats (
id INT NOT NULL AUTO_INCREMENT,
murid_id INT NOT NULL,
guru_id INT NOT NULL,
timestamps TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
message VARCHAR(255) NOT NULL,
is_read BOOL,
is_from_murid BOOL,
PRIMARY KEY (id),
FOREIGN KEY (guru_id) REFERENCES guru(nip),
FOREIGN KEY (murid_id) REFERENCES siswa(nis)
);

# Belum tau ini gimana
CREATE TABLE `rapot` (
  `id_rapot` INT(11) NOT NULL,
  `tanggal` DATE NOT NULL,
  `nik` INT(11) NOT NULL,
  `nip` INT(11) NOT NULL,
  `nilai_rapor` INT(10) NOT NULL,
  `nilai_huruf` VARCHAR(10) NOT NULL,
  `nilai_angka` INT(10) NOT NULL,
  `nilai_rata-rata` INT(10) NOT NULL,
  `mata_pelajaran` VARCHAR(50) NOT NULL,
  `rapor_semester` INT(10) NOT NULL,
  `keterangan` TEXT NOT NULL
)
