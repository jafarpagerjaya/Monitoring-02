DROP DATABASE IF EXISTS fiestaparfum_kp;
CREATE DATABASE fiestaparfum_kp;
USE fiestaparfum_kp;

-- MySQL dump 10.13  Distrib 5.6.21, for Win32 (x86)
--
-- Host: localhost    Database: fiestaparfum_kp
-- ------------------------------------------------------
-- Server version	5.6.21

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `level_akses`
--

DROP TABLE IF EXISTS `level_akses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `level_akses` (
  `kode_la` char(5) NOT NULL,
  `nama_la` varchar(15) NOT NULL,
  PRIMARY KEY (`kode_la`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `level_akses`
--

LOCK TABLES `level_akses` WRITE;
/*!40000 ALTER TABLE `level_akses` DISABLE KEYS */;
INSERT INTO `level_akses` VALUES ('ADM','Admin'),('MGR','Manajer'),('PRD','Produksi'),('SUP','Suplaier');
/*!40000 ALTER TABLE `level_akses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `petugas`
--

DROP TABLE IF EXISTS `petugas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `petugas` (
  `nip` varchar(10) NOT NULL,
  `nama_depan` varchar(10) NOT NULL,
  `nama_belakang` varchar(30) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL,
  `kontak` varchar(12) NOT NULL,
  `kode_aktivasi` varchar(255) DEFAULT NULL,
  `aktif` char(1) NOT NULL DEFAULT '0',
  `online` char(1) NOT NULL DEFAULT '0',
  `terupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `kode_la` char(5) DEFAULT NULL,
  PRIMARY KEY (`nip`),
  KEY `fk_kode_la_odn` (`kode_la`),
  CONSTRAINT `fk_kode_la_odn` FOREIGN KEY (`kode_la`) REFERENCES `level_akses` (`kode_la`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `petugas`
--

LOCK TABLES `petugas` WRITE;
/*!40000 ALTER TABLE `petugas` DISABLE KEYS */;
INSERT INTO `petugas` VALUES ('0000000001','Akbar','Faisal','pfiestaparfum@gmail.com','1','081XXXXXXXX1',NULL,'1','0','2017-02-22 06:27:00','PRD'),('0000000002','Andrew','Lowa','mfiestaparfum@gmail.com','1','081XXXXXXXX2',NULL,'1','1','2017-02-24 06:25:53','MGR'),('0000000003','Jafar','Pager','jafarpager@gmail.com','1','081XXXXXXXX3',NULL,'1','1','2017-03-16 01:41:28','ADM'),('0000000004','Ken','Kinanti','ken@gmail.com','','080000000004',NULL,'0','0','2017-02-23 09:23:57','SUP');
/*!40000 ALTER TABLE `petugas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bahan_mentah`
--

DROP TABLE IF EXISTS `bahan_mentah`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bahan_mentah` (
  `kode_bahan` char(5) NOT NULL,
  `nama_bahan` varchar(20) NOT NULL,
  `harga_pl` mediumint(8) NOT NULL,
  `stok` smallint(4) DEFAULT '0',
  `stok_aman` smallint(2) DEFAULT '0',
  `terupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`kode_bahan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bahan_mentah`
--

LOCK TABLES `bahan_mentah` WRITE;
/*!40000 ALTER TABLE `bahan_mentah` DISABLE KEYS */;
INSERT INTO `bahan_mentah` VALUES ('AK100','Alkohol',15000,40,20,'2017-03-16 01:39:33'),('ET100','Ethanol',14500,55,8,'2017-03-16 01:40:04'),('GT001','Green Tea',300000,6,2,'2017-03-16 01:40:26');
/*!40000 ALTER TABLE `bahan_mentah` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = cp850 */ ;
/*!50003 SET character_set_results = cp850 */ ;
/*!50003 SET collation_connection  = cp850_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER trig_fix_stok
BEFORE INSERT ON bahan_mentah
FOR EACH ROW
BEGIN
	IF NEW.stok < 0 THEN
		SET NEW.stok = 0;
	END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `transaksi_bahan`
--

DROP TABLE IF EXISTS `transaksi_bahan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaksi_bahan` (
  `id_transaksi` int(5) NOT NULL AUTO_INCREMENT,
  `kode_bahan` char(5) DEFAULT NULL,
  `id_laporan` int(4) unsigned zerofill DEFAULT NULL,
  `jenis_transaksi` enum('M','K') NOT NULL,
  `jumlah` smallint(3) NOT NULL,
  `sisa` smallint(2) NOT NULL DEFAULT '0',
  `tgl_transaksi` date NOT NULL,
  PRIMARY KEY (`id_transaksi`),
  KEY `fk_tb_kode_bahan_odn` (`kode_bahan`),
  KEY `fk_tb_id_laporan_odn` (`id_laporan`),
  CONSTRAINT `fk_tb_id_laporan_odn` FOREIGN KEY (`id_laporan`) REFERENCES `laporan` (`id_laporan`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_tb_kode_bahan_odn` FOREIGN KEY (`kode_bahan`) REFERENCES `bahan_mentah` (`kode_bahan`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaksi_bahan`
--

LOCK TABLES `transaksi_bahan` WRITE;
/*!40000 ALTER TABLE `transaksi_bahan` DISABLE KEYS */;
INSERT INTO `transaksi_bahan` VALUES (1,'AK100',NULL,'M',270,270,'2015-12-01'),(2,'AK100',NULL,'K',230,40,'2015-12-29'),(3,'AK100',NULL,'M',300,340,'2016-01-01'),(4,'AK100',NULL,'K',280,60,'2016-01-28'),(5,'AK100',NULL,'M',280,340,'2016-02-01'),(6,'AK100',NULL,'K',300,40,'2016-02-28'),(7,'AK100',NULL,'M',300,340,'2016-03-01'),(8,'AK100',NULL,'K',290,50,'2016-03-28'),(9,'AK100',NULL,'M',290,340,'2016-04-01'),(10,'AK100',NULL,'K',330,10,'2016-04-28'),(11,'AK100',NULL,'M',330,340,'2016-05-01'),(12,'AK100',NULL,'K',280,60,'2016-05-28'),(13,'AK100',NULL,'M',250,310,'2016-06-01'),(14,'AK100',NULL,'K',280,30,'2016-06-28'),(15,'AK100',NULL,'M',300,330,'2016-07-01'),(16,'AK100',NULL,'K',290,40,'2016-07-28'),(17,'ET100',NULL,'M',200,200,'2015-12-01'),(18,'ET100',NULL,'K',170,30,'2015-12-29'),(19,'ET100',NULL,'M',190,220,'2016-01-01'),(20,'ET100',NULL,'K',170,50,'2016-01-28'),(21,'ET100',NULL,'M',170,220,'2016-02-01'),(22,'ET100',NULL,'K',185,25,'2016-02-28'),(23,'ET100',NULL,'M',180,205,'2016-03-01'),(24,'ET100',NULL,'K',195,10,'2016-03-28'),(25,'ET100',NULL,'M',290,300,'2016-04-01'),(26,'ET100',NULL,'K',280,20,'2016-04-28'),(27,'ET100',NULL,'M',330,350,'2016-05-01'),(28,'ET100',NULL,'K',310,40,'2016-05-28'),(29,'ET100',NULL,'M',220,260,'2016-06-01'),(30,'ET100',NULL,'K',230,30,'2016-06-28'),(31,'ET100',NULL,'M',220,250,'2016-07-01'),(32,'ET100',NULL,'K',235,25,'2016-07-28'),(33,'GT001',NULL,'M',20,20,'2015-12-01'),(34,'GT001',NULL,'K',15,5,'2015-12-29'),(35,'GT001',NULL,'M',17,22,'2016-01-01'),(36,'GT001',NULL,'K',18,4,'2016-01-28'),(37,'GT001',NULL,'M',18,22,'2016-02-01'),(38,'GT001',NULL,'K',20,2,'2016-02-28'),(39,'GT001',NULL,'M',22,24,'2016-03-01'),(40,'GT001',NULL,'K',18,6,'2016-03-28'),(41,'GT001',NULL,'M',19,25,'2016-04-01'),(42,'GT001',NULL,'K',22,3,'2016-04-28'),(43,'GT001',NULL,'M',23,26,'2016-05-01'),(44,'GT001',NULL,'K',24,2,'2016-05-28'),(45,'GT001',NULL,'M',20,22,'2016-06-01'),(46,'GT001',NULL,'K',20,2,'2016-06-28'),(47,'GT001',NULL,'M',24,26,'2016-07-01'),(48,'GT001',NULL,'K',22,4,'2016-07-28'),(49,'AK100',NULL,'M',290,330,'2016-08-01'),(50,'AK100',NULL,'K',290,40,'2016-08-28'),(51,'AK100',NULL,'M',280,320,'2016-09-01'),(52,'AK100',NULL,'K',300,20,'2016-09-28'),(53,'AK100',0004,'M',320,340,'2016-10-01'),(54,'AK100',0004,'K',295,45,'2016-10-28'),(55,'AK100',0003,'M',300,345,'2016-11-01'),(56,'AK100',0003,'K',285,60,'2016-11-28'),(57,'AK100',0002,'M',280,340,'2016-12-01'),(58,'AK100',0002,'K',310,30,'2016-12-28'),(59,'AK100',0001,'M',320,350,'2017-01-01'),(60,'AK100',0001,'K',320,30,'2017-01-28'),(61,'ET100',NULL,'M',210,235,'2016-08-01'),(62,'ET100',NULL,'K',230,5,'2016-08-28'),(63,'ET100',NULL,'M',240,245,'2016-09-01'),(64,'ET100',NULL,'K',230,15,'2016-09-28'),(65,'ET100',0004,'M',240,255,'2016-10-01'),(66,'ET100',0004,'K',225,30,'2016-10-28'),(67,'ET100',0003,'M',220,250,'2016-11-01'),(68,'ET100',0003,'K',230,20,'2016-11-28'),(69,'ET100',0002,'M',230,250,'2016-12-01'),(70,'ET100',0002,'K',235,15,'2016-12-28'),(71,'ET100',0001,'M',250,265,'2017-01-01'),(72,'ET100',0001,'K',240,25,'2017-01-28'),(73,'GT001',NULL,'M',24,28,'2016-08-01'),(74,'GT001',NULL,'K',22,6,'2016-08-28'),(75,'GT001',NULL,'M',20,26,'2016-09-01'),(76,'GT001',NULL,'K',21,5,'2016-09-28'),(77,'GT001',0004,'M',20,25,'2016-10-01'),(78,'GT001',0004,'K',20,5,'2016-10-28'),(79,'GT001',0003,'M',20,25,'2016-11-01'),(80,'GT001',0003,'K',22,3,'2016-11-28'),(81,'GT001',0002,'M',23,26,'2016-12-01'),(82,'GT001',0002,'K',23,3,'2016-12-28'),(83,'GT001',0001,'M',25,28,'2017-01-01'),(84,'GT001',0001,'K',24,4,'2017-01-28'),(85,'AK100',NULL,'M',309,339,'2017-02-01'),(86,'AK100',NULL,'K',299,40,'2017-02-28'),(87,'ET100',NULL,'M',233,258,'2017-02-01'),(88,'ET100',NULL,'K',203,55,'2017-02-28'),(89,'GT001',NULL,'M',22,26,'2017-02-01'),(90,'GT001',NULL,'K',20,6,'2017-02-28');
/*!40000 ALTER TABLE `transaksi_bahan` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = cp850 */ ;
/*!50003 SET character_set_results = cp850 */ ;
/*!50003 SET collation_connection  = cp850_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER trig_fix_jumlah
BEFORE INSERT ON transaksi_bahan
FOR EACH ROW
BEGIN
	IF NEW.jumlah < 0 THEN
		SET NEW.jumlah = 1;
	END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = cp850 */ ;
/*!50003 SET character_set_results = cp850 */ ;
/*!50003 SET collation_connection  = cp850_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER trig_transaksi_bahan
AFTER INSERT ON transaksi_bahan
FOR EACH ROW
BEGIN
	IF UPPER(NEW.jenis_transaksi) = 'M' THEN
		UPDATE bahan_mentah
		SET stok = stok + NEW.jumlah
		WHERE kode_bahan = NEW.kode_bahan;
	ELSE 
		UPDATE bahan_mentah
		SET stok = stok - NEW.jumlah
		WHERE kode_bahan = NEW.kode_bahan;
	END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `peramalan`
--

DROP TABLE IF EXISTS `peramalan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peramalan` (
  `id_peramalan` int(4) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `tgl_peramalan` date DEFAULT NULL,
  `status_pengadaan` enum('S','B') NOT NULL DEFAULT 'B',
  `terupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_peramalan`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peramalan`
--

LOCK TABLES `peramalan` WRITE;
/*!40000 ALTER TABLE `peramalan` DISABLE KEYS */;
INSERT INTO `peramalan` VALUES (0001,'2017-02-22','S','2017-02-22 05:47:17');
/*!40000 ALTER TABLE `peramalan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detil_peramalan`
--

DROP TABLE IF EXISTS `detil_peramalan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detil_peramalan` (
  `kode_bahan` char(5) DEFAULT NULL,
  `id_peramalan` int(4) unsigned zerofill DEFAULT NULL,
  `jumlah` smallint(3) NOT NULL,
  KEY `fk_dr_kode_bahan_odc` (`kode_bahan`),
  KEY `fk_dr_id_peramalan_odc` (`id_peramalan`),
  CONSTRAINT `fk_dr_id_peramalan_odc` FOREIGN KEY (`id_peramalan`) REFERENCES `peramalan` (`id_peramalan`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_dr_kode_bahan_odc` FOREIGN KEY (`kode_bahan`) REFERENCES `bahan_mentah` (`kode_bahan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detil_peramalan`
--

LOCK TABLES `detil_peramalan` WRITE;
/*!40000 ALTER TABLE `detil_peramalan` DISABLE KEYS */;
INSERT INTO `detil_peramalan` VALUES ('AK100',0001,319),('ET100',0001,240),('GT001',0001,24);
/*!40000 ALTER TABLE `detil_peramalan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `laporan`
--

DROP TABLE IF EXISTS `laporan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `laporan` (
  `id_laporan` int(4) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `tgl_laporan` date DEFAULT NULL,
  `periode` char(10) DEFAULT NULL,
  `status_pengesahan` enum('S','B') NOT NULL DEFAULT 'B',
  `terupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_laporan`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laporan`
--

LOCK TABLES `laporan` WRITE;
/*!40000 ALTER TABLE `laporan` DISABLE KEYS */;
INSERT INTO `laporan` VALUES (0001,'2017-02-22','Jan 2017','S','2017-02-22 06:00:21'),(0002,'2017-02-22','Dec 2016','S','2017-02-22 06:01:18'),(0003,'2017-02-22','Nov 2016','S','2017-02-22 06:02:39'),(0004,'2017-02-22','Oct 2016','B','2017-02-22 06:03:04');
/*!40000 ALTER TABLE `laporan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'fiestaparfum_kp'
--
/*!50003 DROP PROCEDURE IF EXISTS `ambilKelasKeluar` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = cp850 */ ;
/*!50003 SET character_set_results = cp850 */ ;
/*!50003 SET collation_connection  = cp850_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ambilKelasKeluar`(IN ikode_bahan CHAR(5), OUT opesan VARCHAR(65))
BEGIN
DECLARE pc_kode_bahan TINYINT(1);
DECLARE pt_count TINYINT(2);
DECLARE pt_avg TINYINT(2);
DECLARE pt_2x_avg TINYINT(2);
SELECT COUNT(*) INTO pc_kode_bahan FROM bahan_mentah WHERE kode_bahan = UPPER(ikode_bahan);
IF NULLIF(ikode_bahan,'') IS NULL THEN
   SET opesan = 'Kode bahan tidak boleh kosong';
ELSE
  IF (pc_kode_bahan!=1) THEN
    SET opesan = CONCAT_WS(' ','Kode bahan',ikode_bahan,'tidak dapat ditemukan');
  ELSE
    SELECT COUNT(*), round(format(COUNT(*)/3,0)), round(format(COUNT(*)/3,0))*2 INTO pt_count, pt_avg, pt_2x_avg FROM bahan_mentah;
    SELECT CASE 
             WHEN AVG(a.jumlah) > (SELECT AVG(jumlah)
         			   FROM transaksi_bahan
             			   WHERE jenis_transaksi = 'K'
             			   GROUP BY kode_bahan
             			   LIMIT pt_avg,pt_avg) THEN 'H'
             WHEN AVG(a.jumlah) < (SELECT AVG(jumlah)
                                   FROM transaksi_bahan
                                   WHERE jenis_transaksi = 'K'
                                   GROUP BY kode_bahan
                                   LIMIT 0,pt_avg)
              AND AVG(a.jumlah) > (SELECT AVG(jumlah)
                                   FROM transaksi_bahan
                                   WHERE jenis_transaksi = 'K'
                                   GROUP BY kode_bahan
                                   LIMIT pt_2x_avg,pt_avg) THEN 'M'
             ELSE 'L' 
           END status_keluar
    FROM (SELECT kode_bahan, jumlah
          FROM transaksi_bahan
          WHERE kode_bahan = ikode_bahan AND jenis_transaksi = 'K') a
    GROUP BY a.kode_bahan;
  END IF;
END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `laporan_transaksi_bulanan` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = cp850 */ ;
/*!50003 SET character_set_results = cp850 */ ;
/*!50003 SET collation_connection  = cp850_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `laporan_transaksi_bulanan`(IN ibln CHAR(8), OUT opesan VARCHAR(62))
BEGIN
DECLARE pc_bln TINYINT(1);
DECLARE pt_id_laporan MEDIUMINT(4);
IF NULLIF(ibln,'') IS NULL THEN
  SET opesan = 'Periode laporan tidak boleh kosong';
ELSE
  SELECT COUNT(DISTINCT(date_format(tgl_transaksi,'%m/%Y'))) INTO pc_bln FROM transaksi_bahan WHERE date_format(tgl_transaksi,'%b %Y') = ibln AND id_laporan IS NULL;
  IF (pc_bln=0) THEN
    SET opesan = CONCAT_WS(' ','Transaksi periode',UPPER(ibln),'tidak ditemukan');
  ELSE
    START TRANSACTION;
      INSERT INTO laporan(tgl_laporan,periode) VALUES(NOW(),ibln);
      SELECT COUNT(*) INTO pt_id_laporan FROM laporan;
      UPDATE transaksi_bahan
      SET id_laporan = pt_id_laporan
      WHERE date_format(tgl_transaksi,'%b %Y') = ibln;
    COMMIT;
    SET opesan = CONCAT_WS(' ','Laporan transaksi bahan periode',UPPER(ibln),'telah berhasil dibuat');
  END IF;
END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `login` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = cp850 */ ;
/*!50003 SET character_set_results = cp850 */ ;
/*!50003 SET collation_connection  = cp850_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `login`(IN pemail VARCHAR(30), IN ppassword VARCHAR(30), OUT pnip VARCHAR(10), OUT pkode_la VARCHAR(5), OUT pprivilege VARCHAR(5), OUT ppesan VARCHAR(99))
BEGIN
  DECLARE pcpetugas INT(1);
  DECLARE ptnama_depan VARCHAR(10);
  DECLARE ptaktif CHAR(1);
    SELECT COUNT(*) INTO pcpetugas FROM petugas WHERE (email = pemail) AND (password = ppassword);
    IF (pcpetugas=1) THEN
      SELECT nip, nama_depan, kode_la, aktif INTO pnip, ptnama_depan, pkode_la, ptaktif
      FROM petugas 
      WHERE (LOWER(email) = LOWER(pemail)) AND (password = ppassword);
      IF (ptaktif = '1') THEN
	SET pprivilege = 'TRUE';
        SET ppesan = CONCAT_WS(' ','Hi,',ptnama_depan,'selamat datang');
        IF (pprivilege = 'TRUE') THEN
          UPDATE petugas
          SET online = '1'
          WHERE nip = pnip;
        END IF;
      ELSE
	IF (ptaktif = '0') THEN
          SET ppesan = 'Akun anda belum diaktivasi, mohon aktivasi terlebih dahulu';
	ELSE
	  SET ppesan = 'Akun anda belum untuk sementara tidak dapat digunakan, silahkan hubungi staff admin terlebih dahulu';
	END IF;
      END IF;
    ELSE
      SET pprivilege = 'FALSE';
      SET ppesan = 'Maaf email & password Anda salah.';
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `pendaftaran_akun` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = cp850 */ ;
/*!50003 SET character_set_results = cp850 */ ;
/*!50003 SET collation_connection  = cp850_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `pendaftaran_akun`(IN pnip VARCHAR(10), IN pemail VARCHAR(30), IN ppassword VARCHAR(30), IN pretypepassword VARCHAR(30), OUT pkode_aktivasi VARCHAR(255), OUT ppesan VARCHAR(120))
BEGIN
  DECLARE pcc INT(1);
  DECLARE ptpassword VARCHAR(30);
  SELECT COUNT(*), password INTO pcc, ptpassword FROM petugas WHERE (nip = pnip) AND (LOWER(email) = LOWER(pemail)) AND (kode_aktivasi IS NULL);
  IF (pcc=0) THEN
    SET ppesan = 'Data petugas tidak terdaftar';
  ELSE
    IF (pcc=1 AND ptpassword!='') THEN
      SET ppesan = CONCAT_WS(' ','Data akun dengan NIP',pnip,'sudah terdaftar');
    ELSE
      IF NULLIF(ppassword,'') IS NULL THEN
        SET ppesan = 'Password harus diisi';
      ELSE
        IF (ppassword != pretypepassword) THEN
          SET ppesan = 'Password & Retype Password belum cocok';
        ELSE
          UPDATE petugas
          SET password = TRIM(ppassword), kode_aktivasi = TRIM(CONCAT(REVERSE(pnip),ppassword,pnip))
          WHERE nip = pnip;
          SET pkode_aktivasi = TRIM(CONCAT(REVERSE(pnip),ppassword,pnip));
          SET ppesan = 'Akun anda berhasil dibuat. Link aktivasi akun telah dikirim ke email anda, lanjutkan aktivasi agar akun dapat digunakan';
        END IF;
      END IF;
    END IF;
  END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `peramalan` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = cp850 */ ;
/*!50003 SET character_set_results = cp850 */ ;
/*!50003 SET collation_connection  = cp850_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `peramalan`(IN ikode_bahan CHAR(5),IN ijumlah SMALLINT(3), IN isafty_stok SMALLINT(2), OUT opesan VARCHAR(65))
BEGIN
  DECLARE pc_kode_bahan INT(1);
  DECLARE pc_status_pengadaan INT(1);
  DECLARE pt_id_peramalan INT(4);
  SELECT COUNT(*) INTO pc_kode_bahan FROM bahan_mentah WHERE kode_bahan = ikode_bahan;
  IF (pc_kode_bahan!=1) THEN
    SET opesan = CONCAT_WS(' ','Kode bahan',ikode_bahan,'tidak dapat ditemukan');
  ELSE
    IF NULLIF(ijumlah,'') IS NULL THEN
      SET opesan = 'Jumlah peramalan tidak boleh kosong';
    ELSE
      IF NULLIF(isafty_stok,'') IS NULL THEN
        SET opesan = 'Jumlah safty stok tidak boleh kosong';
      ELSE
    	SELECT COUNT(dp.kode_bahan) INTO pc_kode_bahan FROM peramalan pr LEFT JOIN detil_peramalan dp ON(pr.id_peramalan = dp.id_peramalan) WHERE dp.kode_bahan = ikode_bahan AND pr.status_pengadaan = 'B';
	IF (pc_kode_bahan=1) THEN
	  SET opesan = CONCAT_WS(' ','Kode bahan',ikode_bahan,'sudah diramalkan dan belum dilakukan pengadaan');
        ELSE
	  SELECT COUNT(id_peramalan), id_peramalan INTO pc_status_pengadaan, pt_id_peramalan FROM peramalan WHERE status_pengadaan = 'B';
    	  IF (pc_status_pengadaan=1) THEN
    	    START TRANSACTION;
    	    INSERT INTO detil_peramalan(kode_bahan,id_peramalan,jumlah) VALUES(ikode_bahan,pt_id_peramalan,ijumlah);
    	    UPDATE bahan_mentah SET stok_aman = isafty_stok WHERE kode_bahan = ikode_bahan;
    	    COMMIT;
    	  ELSE
    	    START TRANSACTION;
    	    INSERT INTO peramalan(tgl_peramalan) VALUES(now());
    	    SELECT id_peramalan INTO pt_id_peramalan FROM peramalan WHERE status_pengadaan = 'B';
    	    INSERT INTO detil_peramalan(kode_bahan,id_peramalan,jumlah) VALUES(ikode_bahan,pt_id_peramalan,ijumlah);
    	    UPDATE bahan_mentah SET stok_aman = isafty_stok WHERE kode_bahan = ikode_bahan;
    	    COMMIT;
	  END IF;
    	  SET opesan = CONCAT_WS(' ','Kode bahan',ikode_bahan,'berhasil diramalkan sebanyak',ijumlah);
        END IF;
      END IF;
    END IF;
  END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `transaksi_keluar` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = cp850 */ ;
/*!50003 SET character_set_results = cp850 */ ;
/*!50003 SET collation_connection  = cp850_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `transaksi_keluar`(IN ikode_bahan VARCHAR(5),IN ijumlah INT(6),OUT opesan VARCHAR(50))
BEGIN
DECLARE pc_kode_bahan INT(1);
DECLARE pt_stok INT(3);
DECLARE pt_sisa INT(3);
	IF ijumlah < 0 THEN
		SET opesan = 'Jumlah harus lebih dari 0.';
	ELSE
		IF NULLIF(ikode_bahan, '') IS NULL THEN
      			SET opesan = 'Kode tidak boleh kosong.';
    		ELSE
		SELECT COUNT(kode_bahan) INTO pc_kode_bahan
		FROM bahan_mentah 
		WHERE kode_bahan = ikode_bahan;
			IF (pc_kode_bahan=0) THEN
				SET opesan = CONCAT_WS(' ','Kode bahan',ikode_bahan,'tidak ditemukan');
			ELSE
			SELECT stok INTO pt_stok
			FROM bahan_mentah 
			WHERE kode_bahan = ikode_bahan;
				IF (pt_stok < ijumlah) THEN
      	   	 			SET opesan = CONCAT_WS(' ','Jumlah stok',ikode_bahan,'tidak cukup');
	    		    	ELSE
					SELECT stok INTO pt_sisa FROM bahan_mentah WHERE kode_bahan = ikode_bahan;  
					INSERT INTO transaksi_bahan(kode_bahan,jenis_transaksi,jumlah,sisa,tgl_transaksi) 
					VALUES(ikode_bahan,'K',ijumlah,pt_sisa-ijumlah,now());
					SET opesan = CONCAT_WS(' ','Transaksi keluar',ikode_bahan,'berhasil');
				END IF;
			END IF;
		END IF;
	END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `transaksi_master` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = cp850 */ ;
/*!50003 SET character_set_results = cp850 */ ;
/*!50003 SET collation_connection  = cp850_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `transaksi_master`(IN ikode_bahan VARCHAR(5),IN ijumlah SMALLINT(5),IN ijenis_transaksi CHAR(1), IN itgl_transaksi VARCHAR(11), IN iperiode VARCHAR(8), OUT opesan VARCHAR(100))
BEGIN
DECLARE pc_kode_bahan TINYINT(1);
DECLARE pc_tgl_transaksi TINYINT(1);
DECLARE pt_stok SMALLINT(3);
DECLARE pt_jenis_transaksi VARCHAR(6);
  IF NULLIF(ikode_bahan, '') IS NULL THEN
	SET opesan = 'Kode bahan tidak boleh kosong';
  ELSE
  	SELECT COUNT(*) INTO pc_kode_bahan FROM bahan_mentah WHERE kode_bahan = ikode_bahan;
  	IF (pc_kode_bahan=0) THEN
  	  SET opesan = CONCAT_WS(' ','Kode bahan',ikode_bahan,'tidak ditemukan');
  	ELSE
  	  IF NULLIF(ijumlah, '') IS NULL THEN
	    SET opesan = 'Jumlah transaksi boleh kosong';
	  ELSE
	    IF ijumlah < 0 THEN
		  SET opesan = 'Jumlah transaksi harus lebih dari 0';
	    ELSE
	      IF NULLIF(TRIM(ijenis_transaksi), '') IS NULL THEN
	  	    SET opesan = 'Jenis transaksi tidak boleh kosong';
		  ELSE
		    IF (UPPER(ijenis_transaksi)) NOT IN ('M','K') THEN
		      SET opesan = 'Jenis transaksi harus Masuk atau Keluar';
		    ELSE
		      IF NULLIF(itgl_transaksi, '') IS NULL THEN
			    SET opesan = 'Tanggal transaksi boleh kosong';
			  ELSE
		        IF NULLIF(iperiode, '') IS NULL THEN
			      SET opesan = 'Periode transaksi boleh kosong';
			  	ELSE
				  SET lc_time_names = 'en_US';
			  	  SELECT COUNT(tgl_transaksi), CASE UPPER(jenis_transaksi) WHEN 'M' THEN 'masuk' ELSE 'keluar' END jenis_transaksi INTO pc_tgl_transaksi, pt_jenis_transaksi FROM transaksi_bahan WHERE DATE_FORMAT(tgl_transaksi,'%m-%Y') = DATE_FORMAT(STR_TO_DATE(iperiode,'%b-%Y'),'%m-%Y') AND jenis_transaksi = ijenis_transaksi AND kode_bahan = ikode_bahan;
			  	  IF (pc_tgl_transaksi=1) THEN
			  	    SET opesan = CONCAT_WS(' ','Transaksi',pt_jenis_transaksi,'kode bahan',ikode_bahan,'periode',iperiode,'sudah ada');
			  	  ELSE
			  	    SELECT stok INTO pt_stok FROM bahan_mentah WHERE kode_bahan = ikode_bahan;
			  	    IF (UPPER(ijenis_transaksi)='M') THEN
			  	      INSERT INTO transaksi_bahan(kode_bahan,jumlah,jenis_transaksi,tgl_transaksi,sisa) VALUES(ikode_bahan,ijumlah,UPPER(ijenis_transaksi),STR_TO_DATE(itgl_transaksi,'%d-%b-%Y'), pt_stok+ijumlah);
			  	      SET opesan = CONCAT_WS(' ','Transaksi masuk kode bahan',ikode_bahan,'periode',iperiode,'berhasil disimpan');
			  	    ELSE
			  	      IF (ijumlah > pt_stok) THEN
			  	        SET opesan = CONCAT_WS(' ','Jumlah stok',ikode_bahan,'tidak mencukupi');
			  	      ELSE
			  	  	    INSERT INTO transaksi_bahan(kode_bahan,jumlah,jenis_transaksi,tgl_transaksi,sisa) VALUES(ikode_bahan,ijumlah,UPPER(ijenis_transaksi),STR_TO_DATE(itgl_transaksi,'%d-%b-%Y'), pt_stok-ijumlah);
			  	  	    SET opesan = CONCAT_WS(' ','Transaksi keluar kode bahan',ikode_bahan,'periode',iperiode,'berhasil disimpan');
			  	  	  END IF;
			  	    END IF;
			  	  END IF;
			  	END IF;
			  END IF;
		    END IF;
		  END IF;
		END IF;
	  END IF;
	END IF;
  END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `transaksi_master2` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `transaksi_master2`(IN ikode_bahan VARCHAR(5),IN ijumlahm SMALLINT(5),IN ijumlahk SMALLINT(5),IN iperiode VARCHAR(8),OUT opesan VARCHAR(100))
BEGIN
DECLARE pc_kode_bahan TINYINT(1);
DECLARE pc_tgl_transaksi TINYINT(1);
DECLARE pt_stok SMALLINT(3);
DECLARE pt_jenis_transaksi VARCHAR(6);
DECLARE ijenis_transaksi VARCHAR(6);
  IF NULLIF(ikode_bahan, '') IS NULL THEN
	SET opesan = 'Kode bahan tidak boleh kosong';
  ELSE
  	SELECT COUNT(*) INTO pc_kode_bahan FROM bahan_mentah WHERE kode_bahan = ikode_bahan;
  	IF (pc_kode_bahan=0) THEN
  	  SET opesan = CONCAT_WS(' ','Kode bahan',ikode_bahan,'tidak ditemukan');
  	ELSE
  	  IF NULLIF(ijumlahm, '') IS NULL THEN
	    SET opesan = 'Jumlah transaksi masuk boleh kosong';
	  ELSE
	    IF ijumlahm < 0 THEN
		  SET opesan = 'Jumlah transaksi masuk harus lebih dari 0';
	    ELSE
	      IF NULLIF(ijumlahk, '') IS NULL THEN
	    	SET opesan = 'Jumlah transaksi keluar tidak boleh kosong';
	      ELSE
	        IF ijumlahk < 0 THEN
		  	  SET opesan = 'Jumlah transaksi keluar harus lebih dari 0';
		  	ELSE
		      
		        IF NULLIF(iperiode, '') IS NULL THEN
			      SET opesan = 'Periode transaksi tidak boleh kosong';
			  	ELSE
				SET lc_time_names = 'en_US';
				  IF ijumlahm IS NOT NULL THEN
				    SET ijenis_transaksi = 'M';
				    SELECT COUNT(tgl_transaksi), CASE UPPER(jenis_transaksi) WHEN 'M' THEN 'masuk' ELSE 'keluar' END jenis_transaksi INTO pc_tgl_transaksi, pt_jenis_transaksi FROM transaksi_bahan WHERE DATE_FORMAT(tgl_transaksi,'%m-%Y') = DATE_FORMAT(STR_TO_DATE(iperiode,'%b-%Y'),'%m-%Y') AND jenis_transaksi = ijenis_transaksi AND kode_bahan = ikode_bahan;
			  	    IF (pc_tgl_transaksi=1) THEN
			  	      SET opesan = CONCAT_WS(' ','Transaksi',pt_jenis_transaksi,'kode bahan',ikode_bahan,'periode',iperiode,'sudah ada');
			  	    ELSE
			  	      START TRANSACTION;
			  	      SAVEPOINT A;
			  	        SELECT stok INTO pt_stok FROM bahan_mentah WHERE kode_bahan = ikode_bahan;
			  	        INSERT INTO transaksi_bahan(kode_bahan,jumlah,jenis_transaksi,tgl_transaksi,sisa) VALUES(ikode_bahan,ijumlahm,UPPER(ijenis_transaksi),STR_TO_DATE(CONCAT('01-',iperiode),'%d-%b-%Y'), pt_stok+ijumlahm);
			  	      	SET opesan = CONCAT_WS(' ','Transaksi masuk kode bahan',ikode_bahan,'periode',iperiode,'berhasil disimpan');
			  	      	IF ijumlahk IS NOT NULL THEN
			  	      	  SET ijenis_transaksi = 'K';
			  	      	  SELECT COUNT(tgl_transaksi), CASE UPPER(jenis_transaksi) WHEN 'M' THEN 'masuk' ELSE 'keluar' END jenis_transaksi INTO pc_tgl_transaksi, pt_jenis_transaksi FROM transaksi_bahan WHERE DATE_FORMAT(tgl_transaksi,'%m-%Y') = DATE_FORMAT(STR_TO_DATE(iperiode,'%b-%Y'),'%m-%Y') AND jenis_transaksi = ijenis_transaksi AND kode_bahan = ikode_bahan;
					  	  IF (pc_tgl_transaksi=1) THEN
					  	    ROLLBACK TO SAVEPOINT A;
					  	    SET opesan = CONCAT_WS(' ','Transaksi',pt_jenis_transaksi,'kode bahan',ikode_bahan,'periode',iperiode,'sudah ada');
					  	  ELSE
			  	      	    SELECT stok INTO pt_stok FROM bahan_mentah WHERE kode_bahan = ikode_bahan;
			  	      	    IF (ijumlahk > pt_stok) THEN
			  	              SET opesan = CONCAT_WS(' ','Jumlah stok',ikode_bahan,'tidak mencukupi');
			  	            ELSE
			  	      	      INSERT INTO transaksi_bahan(kode_bahan,jumlah,jenis_transaksi,tgl_transaksi,sisa) VALUES(ikode_bahan,ijumlahk,UPPER(ijenis_transaksi),STR_TO_DATE(CONCAT('28-',iperiode),'%d-%b-%Y'), pt_stok-ijumlahk);
			  	      	      COMMIT;
			  	  	    	  SET opesan = CONCAT_WS(' ','Transaksi kode bahan',ikode_bahan,'periode',iperiode,'berhasil disimpan');
			  	      	    END IF;
			  	      	  END IF;
			  	      	ELSE
			  	      	  ROLLBACK TO SAVEPOINT A;
			  	      	  SET opesan = CONCAT_WS(' ','Terjadi kesalahan jenis transaksi keluar kosong jadi kena rollback to savepoint A.');
			  	      	END IF;
			  	    END IF;
				  ELSE
				  	SET opesan = CONCAT_WS(' ','Terjadi kesalahan jenis transaksi masuk kosong.');
				  END IF;
			  	END IF;
			  
			END IF;
		  END IF;
		END IF;
	  END IF;
	END IF;
  END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `transaksi_masuk` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = cp850 */ ;
/*!50003 SET character_set_results = cp850 */ ;
/*!50003 SET collation_connection  = cp850_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `transaksi_masuk`(IN ikode_bahan VARCHAR(5),IN ijumlah INT(6),OUT opesan VARCHAR(50))
BEGIN
DECLARE pc_kode_bahan INT(1);
DECLARE pt_sisa INT(3);
	IF ijumlah < 0 THEN
		SET opesan = 'Jumlah harus lebih dari 0.';
	ELSE
		IF NULLIF(ikode_bahan, '') IS NULL THEN
      			SET opesan = 'Kode tidak boleh kosong.';
    		ELSE
		SELECT COUNT(kode_bahan) INTO pc_kode_bahan
		FROM bahan_mentah 
		WHERE kode_bahan = ikode_bahan;
			IF (pc_kode_bahan=0) THEN
				SET opesan = CONCAT_WS(' ','Kode bahan',ikode_bahan,'tidak ditemukan');
			ELSE
				SELECT stok INTO pt_sisa FROM bahan_mentah WHERE kode_bahan = ikode_bahan;  
				INSERT INTO transaksi_bahan(kode_bahan,jenis_transaksi,jumlah,sisa,tgl_transaksi) 
				VALUES(ikode_bahan,'M',ijumlah,pt_sisa+ijumlah,now());
				SET opesan = CONCAT_WS(' ','Transaksi masuk',ikode_bahan,'berhasil');
			END IF;
		END IF;
	END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-16  8:52:15
