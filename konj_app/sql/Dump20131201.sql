CREATE DATABASE  IF NOT EXISTS `konj` /*!40100 DEFAULT CHARACTER SET latin2 COLLATE latin2_croatian_ci */;
USE `konj`;
-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: localhost    Database: konj
-- ------------------------------------------------------
-- Server version	5.5.28

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
-- Table structure for table `chronometer`
--

DROP TABLE IF EXISTS `chronometer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chronometer` (
  `chr_id` int(11) NOT NULL AUTO_INCREMENT,
  `rac_id` int(11) NOT NULL,
  `rac_start_num` int(11) NOT NULL,
  `chr_start` datetime DEFAULT NULL,
  `chr_start_inc` varchar(10) COLLATE latin2_croatian_ci DEFAULT NULL,
  PRIMARY KEY (`chr_id`),
  KEY `rac_chr_id_idx` (`rac_id`),
  CONSTRAINT `rac_chr_id` FOREIGN KEY (`rac_id`) REFERENCES `race` (`rac_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chronometer`
--

LOCK TABLES `chronometer` WRITE;
/*!40000 ALTER TABLE `chronometer` DISABLE KEYS */;
/*!40000 ALTER TABLE `chronometer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club`
--

DROP TABLE IF EXISTS `club`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club` (
  `clu_id` int(11) NOT NULL,
  `tow_id` int(11) NOT NULL,
  `cou_id` int(11) DEFAULT NULL,
  `sta_id` int(11) NOT NULL,
  `clu_nam` varchar(80) COLLATE latin2_croatian_ci NOT NULL,
  `clu_nams` varchar(20) COLLATE latin2_croatian_ci DEFAULT NULL,
  `clu_adr` varchar(80) COLLATE latin2_croatian_ci DEFAULT NULL,
  `clu_tow` varchar(45) COLLATE latin2_croatian_ci DEFAULT NULL,
  `clu_cou` varchar(45) COLLATE latin2_croatian_ci DEFAULT NULL,
  `clu_sta` varchar(45) COLLATE latin2_croatian_ci DEFAULT NULL,
  `clu_email` varchar(80) COLLATE latin2_croatian_ci DEFAULT NULL,
  `clu_tel` varchar(30) COLLATE latin2_croatian_ci DEFAULT NULL,
  `clu_tel2` varchar(30) COLLATE latin2_croatian_ci DEFAULT NULL,
  `clu_fax` varchar(30) COLLATE latin2_croatian_ci DEFAULT NULL,
  `clu_mob` varchar(20) COLLATE latin2_croatian_ci DEFAULT NULL,
  `clu_mob2` varchar(20) COLLATE latin2_croatian_ci DEFAULT NULL,
  `clu_acc` varchar(30) COLLATE latin2_croatian_ci DEFAULT NULL,
  `clu_acc2` varchar(30) COLLATE latin2_croatian_ci DEFAULT NULL,
  `activity` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `date` varchar(8) COLLATE latin2_croatian_ci DEFAULT NULL,
  PRIMARY KEY (`clu_id`),
  KEY `tow_id_idx` (`tow_id`),
  CONSTRAINT `tow_id` FOREIGN KEY (`tow_id`) REFERENCES `town` (`tow_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club`
--

LOCK TABLES `club` WRITE;
/*!40000 ALTER TABLE `club` DISABLE KEYS */;
INSERT INTO `club` VALUES (1,1,1,1,'Sportsko rekreativno društvo 315 Sjeverozapad','SRD 315 Sjeverozapad','Miroslava Krleže 1/1',NULL,NULL,NULL,'http://315-sjeverozapad.hr/',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,1,1,1,'Triatlon klub 042 Varaždin','TK 042 Varaždin',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,2,2,1,'Triatlon klub Međimurje','TK Međimurje',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `club` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `county`
--

DROP TABLE IF EXISTS `county`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `county` (
  `sta_id` int(11) NOT NULL,
  `cou_id` int(11) NOT NULL,
  `cou_nam` varchar(80) COLLATE latin2_croatian_ci NOT NULL,
  `cou_res` varchar(45) COLLATE latin2_croatian_ci DEFAULT NULL,
  `cou_num` varchar(3) COLLATE latin2_croatian_ci DEFAULT NULL,
  `activity` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `date` varchar(8) COLLATE latin2_croatian_ci DEFAULT NULL,
  PRIMARY KEY (`cou_id`),
  KEY `sta_id_idx` (`sta_id`),
  CONSTRAINT `sta_id` FOREIGN KEY (`sta_id`) REFERENCES `state` (`sta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `county`
--

LOCK TABLES `county` WRITE;
/*!40000 ALTER TABLE `county` DISABLE KEYS */;
/*!40000 ALTER TABLE `county` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currency`
--

DROP TABLE IF EXISTS `currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currency` (
  `cur_id` int(11) NOT NULL,
  `cur_nam` varchar(80) COLLATE latin2_croatian_ci NOT NULL,
  `cur_nams` varchar(20) COLLATE latin2_croatian_ci DEFAULT NULL,
  `cur_cod` varchar(3) COLLATE latin2_croatian_ci DEFAULT NULL,
  `cur_rat` decimal(10,0) DEFAULT NULL,
  `activity` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `date` varchar(8) COLLATE latin2_croatian_ci DEFAULT NULL,
  PRIMARY KEY (`cur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency`
--

LOCK TABLES `currency` WRITE;
/*!40000 ALTER TABLE `currency` DISABLE KEYS */;
/*!40000 ALTER TABLE `currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `eve_id` int(11) NOT NULL,
  `eve_org` int(11) NOT NULL,
  `eve_nam` varchar(80) COLLATE latin2_croatian_ci NOT NULL,
  `eve_nams` varchar(20) COLLATE latin2_croatian_ci DEFAULT NULL,
  `eve_fr_dat` varchar(8) COLLATE latin2_croatian_ci DEFAULT NULL,
  `eve_to_dat` varchar(8) COLLATE latin2_croatian_ci DEFAULT NULL,
  `eve_start_dat` datetime DEFAULT NULL,
  `eve_limit_dat` varchar(45) COLLATE latin2_croatian_ci DEFAULT NULL,
  `eve_rac` varchar(45) COLLATE latin2_croatian_ci DEFAULT NULL COMMENT 'race id\\''s, for example “1;4;15”',
  `eve_desc` varchar(300) COLLATE latin2_croatian_ci DEFAULT NULL,
  `eve_rul` varchar(500) COLLATE latin2_croatian_ci DEFAULT NULL,
  `activity` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `date` varchar(8) COLLATE latin2_croatian_ci DEFAULT NULL,
  PRIMARY KEY (`eve_id`),
  KEY `org_eve_id_idx` (`eve_org`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `league`
--

DROP TABLE IF EXISTS `league`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `league` (
  `lea_id` int(11) NOT NULL,
  `leagr_id` int(11) DEFAULT NULL,
  `sco_id` int(11) DEFAULT NULL,
  `org_id` int(11) NOT NULL,
  `lea_nam` varchar(80) COLLATE latin2_croatian_ci NOT NULL,
  `lea_nams` varchar(20) COLLATE latin2_croatian_ci DEFAULT NULL,
  `lea_dat_fr` varchar(8) COLLATE latin2_croatian_ci DEFAULT NULL,
  `lea_dat_to` varchar(8) COLLATE latin2_croatian_ci DEFAULT NULL,
  `lea_day` int(11) DEFAULT NULL,
  `lea_day_sco` int(11) DEFAULT NULL,
  `lea_desc` varchar(300) COLLATE latin2_croatian_ci DEFAULT NULL,
  `lea_rul` varchar(500) COLLATE latin2_croatian_ci DEFAULT NULL,
  `lea_leagr_sn` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL COMMENT 'league uses start numbers from league group',
  `activity` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `date` varchar(8) COLLATE latin2_croatian_ci DEFAULT NULL,
  PRIMARY KEY (`lea_id`),
  KEY `sco_id_idx` (`sco_id`),
  CONSTRAINT `sco_id` FOREIGN KEY (`sco_id`) REFERENCES `scoring` (`sco_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `league`
--

LOCK TABLES `league` WRITE;
/*!40000 ALTER TABLE `league` DISABLE KEYS */;
INSERT INTO `league` VALUES (1,1,1,1,'1. Jesenska liga Konj Vertical','Konj Vetical 2013',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,NULL,1,1,'test','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,1,1,1,'1. Proljetna liga Konj Vertical','Konj Vetical 2014',NULL,NULL,NULL,NULL,NULL,NULL,'D',NULL,NULL);
/*!40000 ALTER TABLE `league` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `league_group`
--

DROP TABLE IF EXISTS `league_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `league_group` (
  `leagr_id` int(11) NOT NULL AUTO_INCREMENT,
  `sco_id` varchar(45) CHARACTER SET latin2 COLLATE latin2_croatian_ci DEFAULT NULL,
  `org_id` varchar(45) CHARACTER SET latin2 COLLATE latin2_croatian_ci DEFAULT NULL,
  `leagr_nam` varchar(80) CHARACTER SET latin2 COLLATE latin2_croatian_ci NOT NULL,
  `leagr_nams` varchar(20) CHARACTER SET latin2 COLLATE latin2_croatian_ci DEFAULT NULL,
  `leagr_rul` varchar(500) CHARACTER SET latin2 COLLATE latin2_croatian_ci DEFAULT NULL,
  PRIMARY KEY (`leagr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=cp1250 COLLATE=cp1250_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `league_group`
--

LOCK TABLES `league_group` WRITE;
/*!40000 ALTER TABLE `league_group` DISABLE KEYS */;
INSERT INTO `league_group` VALUES (1,'1','1','Konj Vertical','Konj Vertical',NULL),(2,NULL,'1','Transverzala Ivančica','Transverzala',NULL),(3,NULL,'1','Prazna test grupa','PTG',NULL);
/*!40000 ALTER TABLE `league_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `old_league_group_st_num`
--

DROP TABLE IF EXISTS `old_league_group_st_num`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `old_league_group_st_num` (
  `leagr_st_num` int(11) NOT NULL,
  `leagr_id` int(11) NOT NULL,
  `per_id` int(11) NOT NULL,
  PRIMARY KEY (`leagr_id`,`per_id`,`leagr_st_num`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `old_league_group_st_num`
--

LOCK TABLES `old_league_group_st_num` WRITE;
/*!40000 ALTER TABLE `old_league_group_st_num` DISABLE KEYS */;
INSERT INTO `old_league_group_st_num` VALUES (1,1,1),(2,1,2),(3,1,3),(4,1,4),(5,1,5);
/*!40000 ALTER TABLE `old_league_group_st_num` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `old_league_st_num`
--

DROP TABLE IF EXISTS `old_league_st_num`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `old_league_st_num` (
  `lea_st_num` int(11) NOT NULL,
  `lea_id` int(11) NOT NULL,
  `per_id` int(11) NOT NULL,
  `leagr_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`lea_id`,`per_id`,`lea_st_num`),
  KEY `lea_id_idx` (`lea_id`),
  KEY `per_id_idx` (`per_id`),
  CONSTRAINT `lea_id` FOREIGN KEY (`lea_id`) REFERENCES `league` (`lea_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `per_id` FOREIGN KEY (`per_id`) REFERENCES `person` (`per_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `old_league_st_num`
--

LOCK TABLES `old_league_st_num` WRITE;
/*!40000 ALTER TABLE `old_league_st_num` DISABLE KEYS */;
INSERT INTO `old_league_st_num` VALUES (1,1,1,1),(2,1,2,1),(3,1,3,1),(4,1,4,1),(5,1,5,1),(1,2,1,NULL),(1,3,1,1);
/*!40000 ALTER TABLE `old_league_st_num` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `old_race_st_num`
--

DROP TABLE IF EXISTS `old_race_st_num`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `old_race_st_num` (
  `rac_st_num` int(11) NOT NULL,
  `rac_id` int(11) NOT NULL,
  `per_id` int(11) NOT NULL,
  `rac_app` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  PRIMARY KEY (`rac_id`,`per_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `old_race_st_num`
--

LOCK TABLES `old_race_st_num` WRITE;
/*!40000 ALTER TABLE `old_race_st_num` DISABLE KEYS */;
INSERT INTO `old_race_st_num` VALUES (1,9,1,NULL),(2,9,2,NULL),(3,9,3,NULL),(1,10,1,NULL);
/*!40000 ALTER TABLE `old_race_st_num` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `person`
--

DROP TABLE IF EXISTS `person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `person` (
  `per_id` int(11) NOT NULL AUTO_INCREMENT,
  `clu_id` int(11) NOT NULL,
  `tow_id` int(11) NOT NULL,
  `sta_id` int(11) NOT NULL,
  `per_nam` varchar(80) COLLATE latin2_croatian_ci NOT NULL,
  `per_sur` varchar(80) COLLATE latin2_croatian_ci NOT NULL,
  `per_yea` varchar(4) COLLATE latin2_croatian_ci NOT NULL,
  `per_dat_b` varchar(8) COLLATE latin2_croatian_ci DEFAULT NULL,
  `per_sex` varchar(1) COLLATE latin2_croatian_ci NOT NULL,
  `per_adr` varchar(80) COLLATE latin2_croatian_ci DEFAULT NULL,
  `per_tow` varchar(80) COLLATE latin2_croatian_ci DEFAULT NULL,
  `per_cou` varchar(80) COLLATE latin2_croatian_ci DEFAULT NULL,
  `per_sta` varchar(80) COLLATE latin2_croatian_ci DEFAULT NULL,
  `per_email` varchar(50) COLLATE latin2_croatian_ci NOT NULL,
  `per_tel` varchar(20) COLLATE latin2_croatian_ci DEFAULT NULL,
  `per_mob` varchar(20) COLLATE latin2_croatian_ci NOT NULL,
  `per_shi` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `per_meal` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `activity` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `date` varchar(8) COLLATE latin2_croatian_ci DEFAULT NULL,
  PRIMARY KEY (`per_id`),
  KEY `clu_id_idx` (`clu_id`),
  CONSTRAINT `clu_id` FOREIGN KEY (`clu_id`) REFERENCES `club` (`clu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `person`
--

LOCK TABLES `person` WRITE;
/*!40000 ALTER TABLE `person` DISABLE KEYS */;
INSERT INTO `person` VALUES (1,1,1,1,'Marko','Leljak','1985','19850111','1',NULL,NULL,NULL,NULL,'mleljak@gmail.com',NULL,'0917635515',NULL,NULL,NULL,NULL),(2,1,1,1,'Vanja','Šomođi','1988','19880420','1',NULL,NULL,NULL,NULL,'mleljak@gmail.com',NULL,'0917635515',NULL,NULL,NULL,NULL),(3,1,1,1,'Mladen','Skeja','1984','19880420','1',NULL,NULL,NULL,NULL,'mleljak@gmail.com',NULL,'0917635515',NULL,NULL,NULL,NULL),(4,1,1,1,'Marjan','Lonjak','1973','19730101','1',NULL,NULL,NULL,NULL,'mleljak@gmail.com',NULL,'0917635515',NULL,NULL,NULL,NULL),(5,1,1,1,'Jelena','Sekelj','1980','19800101','0',NULL,NULL,NULL,NULL,'mleljak@gmail.com',NULL,'0917635515',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `person` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `race`
--

DROP TABLE IF EXISTS `race`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `race` (
  `rac_id` int(11) NOT NULL AUTO_INCREMENT,
  `rac_typ_id` int(11) NOT NULL,
  `lea_id` int(11) DEFAULT NULL,
  `leagr_id` int(11) DEFAULT NULL,
  `val_id` int(11) DEFAULT NULL,
  `org_id` int(11) NOT NULL,
  `st_id` int(11) NOT NULL,
  `rac_lea_add` varchar(45) COLLATE latin2_croatian_ci DEFAULT NULL COMMENT 'If race in several leagues, then write 3;4;12 as league id\\''s',
  `rac_typ_add` varchar(45) COLLATE latin2_croatian_ci DEFAULT NULL COMMENT 'If race in several types, then write 3;4;12 as race type id\\''s',
  `rac_nam` varchar(80) COLLATE latin2_croatian_ci NOT NULL COMMENT 'full name',
  `rac_nams` varchar(20) COLLATE latin2_croatian_ci DEFAULT NULL COMMENT 'short name',
  `rac_fr_dat` varchar(8) COLLATE latin2_croatian_ci NOT NULL,
  `rac_to_dat` varchar(8) COLLATE latin2_croatian_ci DEFAULT NULL,
  `rac_start_dat` datetime DEFAULT NULL COMMENT 'Exact starting time',
  `rac_limit_dat` datetime DEFAULT NULL COMMENT 'Exact limit time',
  `rac_krono` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL COMMENT 'Chronometer - Y/N or D/N',
  `rac_kmH` float NOT NULL COMMENT 'Horizontal kilometers',
  `rac_kmHD` float DEFAULT NULL COMMENT 'Horizontal downhill kilometers',
  `rac_kmV` float NOT NULL COMMENT 'Vertical Kilometers',
  `rac_kmVD` float DEFAULT NULL COMMENT 'Vertical downhil kilometers',
  `rac_ent_fee` decimal(10,0) DEFAULT NULL COMMENT 'Entry fee',
  `rac_ent_fee_val` varchar(45) COLLATE latin2_croatian_ci DEFAULT NULL COMMENT 'If race entry fee in several currencies, then write \\"fee,currency_id\\" as \\"100#2;120#4;200#5\\"',
  `rac_shirt` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `rac_water` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `rac_drink` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `rac_eat` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `rac_rs` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL COMMENT 'rescue service',
  `rac_fraid` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL COMMENT 'first aid',
  `rac_reg_fr_dat` datetime DEFAULT NULL,
  `rac_reg_to_dat` datetime DEFAULT NULL,
  `rac_desc` varchar(300) CHARACTER SET cp1250 COLLATE cp1250_croatian_ci DEFAULT NULL,
  `rac_calc` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL COMMENT 'Calculation is made',
  `rac_rul` varchar(500) COLLATE latin2_croatian_ci DEFAULT NULL,
  `rac_man_eq` varchar(200) COLLATE latin2_croatian_ci DEFAULT NULL COMMENT 'mandatory equipment, for example \\"compass; 1l water; buff\\"',
  `rac_chk` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL COMMENT 'if race includes checkpoints',
  `rac_lea_rou` int(11) DEFAULT NULL COMMENT 'if race in league then round in league (1,2,3,...)',
  `rac_meal` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `activity` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `date` varchar(8) COLLATE latin2_croatian_ci NOT NULL,
  PRIMARY KEY (`rac_id`),
  KEY `rac_typ_id_idx` (`rac_typ_id`),
  CONSTRAINT `rac_typ_id` FOREIGN KEY (`rac_typ_id`) REFERENCES `race_type` (`rac_typ_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `race`
--

LOCK TABLES `race` WRITE;
/*!40000 ALTER TABLE `race` DISABLE KEYS */;
INSERT INTO `race` VALUES (1,2,1,NULL,1,1,1,NULL,NULL,'1. Jesenska liga Konj Vertical - 1.kolo','Konj Vertical','20131006','20131006',NULL,NULL,'N',2.6,2.6,0.6,NULL,0,NULL,'N','N','N','N','N','N',NULL,NULL,'opis utrke opis utrkeopis utrkeopis utrkeopis utrkeopis utrkeopis utrkeopis utrkeopis utrkeopis utrkeopis utrkeopis utrkeopis utrkeopis utrkeopis utrkeopis utrkeopis utrkeopis utrkeopis utrkeopis utrkeopis utrkeopis utrkeopis utrkeopis utrkeopis utrkeopis utrkeopis utrke','N','trči (hoda) se bez obzira na vremenske uvjete; smiju se koristiti štapovi; boduje se 5 od 6 kola;start je na parkiralištu u Prigorcu kod table;cilj kod planinarskog doma;obavezno se mora proći preko malog i velikog konja;obavezno propuštanje bržih;',NULL,'D',1,NULL,'D','20131007'),(2,2,1,NULL,1,1,1,NULL,NULL,'1. Jesenska liga Konj Vertical - 2.kolo','Konj Vertical','20131013','20131013',NULL,NULL,'D',2.6,2.6,0.6,NULL,0,NULL,'N','N','N','N','N','N',NULL,NULL,NULL,NULL,NULL,NULL,'N',2,NULL,NULL,'20131014'),(3,2,1,NULL,1,1,1,NULL,NULL,'1. Jesenska liga Konj Vertical - 3.kolo','Konj Vertical','20131020','20131020',NULL,NULL,'N',2.6,2.6,0.6,NULL,0,NULL,'N','N','N','N','N','N',NULL,NULL,NULL,NULL,NULL,NULL,'N',3,NULL,NULL,'20131021'),(4,2,1,NULL,1,1,1,NULL,NULL,'1. Jesenska liga Konj Vertical - 4.kolo','Konj Vertical','20131027','20131027',NULL,NULL,'N',2.6,2.6,0.6,NULL,0,NULL,'N','N','N','N','N','N',NULL,NULL,NULL,NULL,NULL,NULL,'N',4,NULL,NULL,'20131028'),(5,2,1,NULL,1,1,1,NULL,NULL,'1. Jesenska liga Konj Vertical - 5.kolo','Konj Vertical','20131103','20131103',NULL,NULL,'N',2.6,2.6,0.6,NULL,0,NULL,'N','N','N','N','N','N',NULL,NULL,NULL,NULL,NULL,NULL,'N',5,NULL,NULL,'20131028'),(6,2,NULL,NULL,1,1,1,NULL,NULL,'1. Jesenska liga Konj Vertical - 6.kolo','Konj Vertical','20131110','20131110',NULL,NULL,'N',2.6,2.6,0.6,NULL,0,NULL,'N','N','N','N','N','N',NULL,NULL,NULL,NULL,NULL,NULL,NULL,6,NULL,NULL,'20131028'),(7,2,2,NULL,1,1,3,NULL,NULL,'test prvo kolo',NULL,'20131110','20131110',NULL,NULL,NULL,2.6,2.6,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'20131028'),(8,2,2,NULL,1,1,3,NULL,NULL,'test drugo kolo',NULL,'20131110','20131110',NULL,NULL,NULL,2.6,2.6,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'20131028'),(9,1,NULL,2,NULL,1,2,NULL,NULL,'Transverzala Ivančica 2013','Transverzala','20131116','20131116',NULL,NULL,NULL,40,NULL,1.5,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-11-28 00:00:00','2015-11-30 00:00:00','Golubovec –> Krušljevec\\nSTART – Golubovec (želj. stanica) 16.11. 8:05\\nKT1 – Vilinska Špica cca 7km\\nKT2 – Pasarićev dom na vrhu cca 16km\\nKT3 – Lujčekova hiža (dom) na Pokojcu cca 28km\\nKT4 – Čevo (kućica kod križa) cca 35km\\nCILJ – Krušljevec (želj. stanica) cca 40km cca 40km+1500m',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'20131028'),(10,1,NULL,NULL,NULL,1,4,NULL,NULL,'test utrka',NULL,'20131116','20131116',NULL,NULL,NULL,12,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'rrrrrrr',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'20131028'),(11,2,3,NULL,1,1,1,NULL,NULL,'1. Proljetna liga Konj Vertical - 1.kolo',NULL,'20131116','20131116',NULL,NULL,NULL,2.6,2.6,0.6,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'20131028'),(12,2,3,NULL,1,1,1,NULL,NULL,'1. Proljetna liga Konj Vertical - 2.kolo',NULL,'20131116','20131116',NULL,NULL,NULL,2.6,2.6,0.6,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,NULL,'20131028'),(13,2,3,NULL,1,1,1,NULL,NULL,'1. Proljetna liga Konj Vertical - 3.kolo',NULL,'20131116','20131116',NULL,NULL,NULL,2.6,2.6,0.6,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3,NULL,NULL,'20131028'),(14,2,3,NULL,1,1,1,NULL,NULL,'1. Proljetna liga Konj Vertical - 4.kolo',NULL,'20131116','20131116',NULL,NULL,NULL,2.6,2.6,0.6,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4,NULL,NULL,'20131028'),(15,2,3,NULL,1,1,1,NULL,NULL,'1. Proljetna liga Konj Vertical - 5.kolo',NULL,'20131116','20131116',NULL,NULL,NULL,2.6,2.6,0.6,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,5,NULL,NULL,'20131028'),(16,2,3,NULL,1,1,1,NULL,NULL,'1. Proljetna liga Konj Vertical - 6.kolo',NULL,'20131116','20131116',NULL,NULL,NULL,2.6,2.6,0.6,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,6,NULL,NULL,'20131028'),(17,1,NULL,2,NULL,1,2,NULL,NULL,'Transverzala Ivančica 2014 1','Transverzala','20131116','20131116',NULL,NULL,NULL,40,NULL,1.5,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Golubovec –> Krušljevec\\nSTART – Golubovec (želj. stanica) 16.11. 8:05\\nKT1 – Vilinska Špica cca 7km\\nKT2 – Pasarićev dom na vrhu cca 16km\\nKT3 – Lujčekova hiža (dom) na Pokojcu cca 28km\\nKT4 – Čevo (kućica kod križa) cca 35km\\nCILJ – Krušljevec (želj. stanica) cca 40km cca 40km+1500m',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'20131028'),(18,1,NULL,2,NULL,1,2,NULL,NULL,'Transverzala Ivančica 2014 2','Transverzala','20131116','20131116',NULL,NULL,NULL,40,NULL,1.5,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Golubovec –> Krušljevec\\nSTART – Golubovec (želj. stanica) 16.11. 8:05\\nKT1 – Vilinska Špica cca 7km\\nKT2 – Pasarićev dom na vrhu cca 16km\\nKT3 – Lujčekova hiža (dom) na Pokojcu cca 28km\\nKT4 – Čevo (kućica kod križa) cca 35km\\nCILJ – Krušljevec (želj. stanica) cca 40km cca 40km+1500m',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'20131028');
/*!40000 ALTER TABLE `race` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `race_registration`
--

DROP TABLE IF EXISTS `race_registration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `race_registration` (
  `rac_reg_id` int(11) NOT NULL AUTO_INCREMENT,
  `rac_id` int(11) DEFAULT NULL,
  `per_id` int(11) DEFAULT NULL,
  `rac_clu_id` int(11) DEFAULT NULL,
  `sta_id` int(11) DEFAULT NULL,
  `tow_id` int(11) DEFAULT NULL,
  `rac_reg_paid_fee` varchar(1) COLLATE latin2_croatian_ci NOT NULL,
  `rac_reg_nam` varchar(40) CHARACTER SET cp1250 COLLATE cp1250_croatian_ci NOT NULL,
  `rac_reg_sur` varchar(40) CHARACTER SET utf8 NOT NULL,
  `rac_reg_sex` varchar(1) COLLATE latin2_croatian_ci NOT NULL,
  `rac_reg_year` varchar(4) COLLATE latin2_croatian_ci DEFAULT NULL,
  `rac_reg_clu` varchar(80) COLLATE latin2_croatian_ci DEFAULT NULL,
  `rac_reg_tow` varchar(80) COLLATE latin2_croatian_ci DEFAULT NULL,
  `rac_reg_shi` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `rac_reg_meal` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `activity` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`rac_reg_id`),
  KEY `rac_reg_id_idx` (`rac_id`),
  CONSTRAINT `rac_reg_id` FOREIGN KEY (`rac_id`) REFERENCES `race` (`rac_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `race_registration`
--

LOCK TABLES `race_registration` WRITE;
/*!40000 ALTER TABLE `race_registration` DISABLE KEYS */;
INSERT INTO `race_registration` VALUES (70,9,NULL,NULL,NULL,NULL,'0','Ivan','IviniÄ‡','1','1999',NULL,NULL,NULL,NULL,NULL,NULL),(71,9,NULL,NULL,NULL,NULL,'0','Ivan','IviÄ‡','1','1999',NULL,NULL,NULL,NULL,NULL,NULL),(72,9,NULL,NULL,NULL,NULL,'0','Ivan','Ivić','1','1999',NULL,NULL,NULL,NULL,NULL,NULL),(73,9,NULL,NULL,NULL,NULL,'0','Ivan','IviĆ','1','1999',NULL,NULL,NULL,NULL,NULL,NULL),(74,9,NULL,NULL,NULL,NULL,'0','Ivan','IviÄ†','1','1999',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `race_registration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `race_result`
--

DROP TABLE IF EXISTS `race_result`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `race_result` (
  `res_id` int(11) NOT NULL AUTO_INCREMENT,
  `rac_id` int(11) NOT NULL,
  `res_check_id` int(11) DEFAULT NULL,
  `sn_id` int(11) DEFAULT NULL,
  `res_fin_time` varchar(45) COLLATE latin2_croatian_ci NOT NULL,
  `res_fin_time_sec` float DEFAULT NULL,
  `res_time` varchar(45) COLLATE latin2_croatian_ci DEFAULT NULL,
  `res_fin` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `res_pen` varchar(45) COLLATE latin2_croatian_ci DEFAULT NULL,
  `activity` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `date` varchar(8) COLLATE latin2_croatian_ci DEFAULT NULL,
  PRIMARY KEY (`res_id`),
  KEY `rac_id_idx` (`rac_id`),
  CONSTRAINT `rac_id` FOREIGN KEY (`rac_id`) REFERENCES `race` (`rac_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `race_result`
--

LOCK TABLES `race_result` WRITE;
/*!40000 ALTER TABLE `race_result` DISABLE KEYS */;
INSERT INTO `race_result` VALUES (1,1,NULL,1,'0:34:41',2081,NULL,NULL,NULL,NULL,NULL),(2,1,NULL,2,'0:33:48',2028,NULL,NULL,NULL,NULL,NULL),(3,1,NULL,3,'0:31:19',1879,NULL,NULL,NULL,NULL,NULL),(4,2,NULL,2,'0:31:22',1882,NULL,NULL,NULL,NULL,NULL),(5,2,NULL,3,'0:33:38',2018,NULL,NULL,NULL,NULL,NULL),(6,2,NULL,1,'0:34:51',2091,NULL,NULL,NULL,NULL,NULL),(7,2,NULL,4,'0:35:55',2155,NULL,NULL,NULL,NULL,NULL),(8,9,NULL,1,'4:56:00',17760,'12:58:00','',NULL,NULL,NULL),(11,9,NULL,2,'5:58:00',21480,'13:58:00',NULL,NULL,NULL,NULL),(12,9,NULL,3,'6:18:00',22680,'14:18:00',NULL,NULL,NULL,NULL),(13,1,NULL,5,'0:34:01',2041,NULL,NULL,NULL,NULL,NULL),(14,3,NULL,1,'0:33:59',2039,NULL,NULL,NULL,NULL,NULL),(15,11,NULL,1,'0:33:00',1980,NULL,NULL,NULL,NULL,NULL),(16,11,NULL,2,'0:31:00',1860,NULL,NULL,NULL,NULL,NULL),(17,11,NULL,5,'0:32:32',1952,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `race_result` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `race_type`
--

DROP TABLE IF EXISTS `race_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `race_type` (
  `rac_typ_id` int(11) NOT NULL,
  `rac_typ_nam` varchar(30) COLLATE latin2_croatian_ci NOT NULL,
  `activity` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `date` varchar(8) COLLATE latin2_croatian_ci DEFAULT NULL,
  PRIMARY KEY (`rac_typ_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `race_type`
--

LOCK TABLES `race_type` WRITE;
/*!40000 ALTER TABLE `race_type` DISABLE KEYS */;
INSERT INTO `race_type` VALUES (1,'Trka',NULL,NULL),(2,'Trka-liga',NULL,NULL),(3,'Trka-trening',NULL,NULL),(4,'Ostalo',NULL,NULL);
/*!40000 ALTER TABLE `race_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scoring`
--

DROP TABLE IF EXISTS `scoring`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scoring` (
  `sco_id` int(11) NOT NULL,
  `sco_nam` varchar(45) COLLATE latin2_croatian_ci NOT NULL,
  `sco_sys` varchar(500) COLLATE latin2_croatian_ci NOT NULL COMMENT '100,95,92,90,...',
  `sco_des` varchar(300) COLLATE latin2_croatian_ci DEFAULT NULL,
  `activity` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `date` varchar(8) COLLATE latin2_croatian_ci DEFAULT NULL,
  PRIMARY KEY (`sco_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scoring`
--

LOCK TABLES `scoring` WRITE;
/*!40000 ALTER TABLE `scoring` DISABLE KEYS */;
INSERT INTO `scoring` VALUES (1,'Sustav bodovanja','100,95,92,90,89,88,87,86,85,84,83,82,81,80,79,78,77,76,75,74,73,72,71,70,69,68,67,66,65,64,63,62,61,60,59,58,57,56,55,54,53,52,51,50,49,48,47,46,45,44,43,42,41,40,39,38,37,36,35,34,33,32,31,30,29,28,27,26,25,24,23,22,21,20,19,18,17,16,15,14,13,12,11,10,9,8,7,6,5,4,3,2,1','Sustav bodovanja123',NULL,NULL),(2,'Sustav bodovanja','100,95,92,90,...','Sustav bodovanja123',NULL,NULL);
/*!40000 ALTER TABLE `scoring` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `st_num`
--

DROP TABLE IF EXISTS `st_num`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `st_num` (
  `st_id` int(11) NOT NULL,
  `sn_id` int(11) NOT NULL,
  `sn_typ` int(11) DEFAULT NULL,
  `per_id` int(11) NOT NULL,
  `activity` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `date` varchar(8) COLLATE latin2_croatian_ci DEFAULT NULL,
  `per_id_add` varchar(45) COLLATE latin2_croatian_ci DEFAULT NULL COMMENT 'additional persons, if team race',
  `sn_nam` varchar(45) COLLATE latin2_croatian_ci DEFAULT NULL,
  `sn_nams` varchar(20) COLLATE latin2_croatian_ci DEFAULT NULL,
  PRIMARY KEY (`st_id`,`sn_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci COMMENT='start numbers';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `st_num`
--

LOCK TABLES `st_num` WRITE;
/*!40000 ALTER TABLE `st_num` DISABLE KEYS */;
INSERT INTO `st_num` VALUES (1,1,NULL,1,NULL,NULL,NULL,NULL,NULL),(1,2,NULL,2,NULL,NULL,NULL,NULL,NULL),(1,3,NULL,3,NULL,NULL,NULL,NULL,NULL),(1,4,NULL,4,NULL,NULL,NULL,NULL,NULL),(1,5,NULL,5,NULL,NULL,NULL,NULL,NULL),(2,1,NULL,1,NULL,NULL,NULL,NULL,NULL),(2,2,NULL,2,NULL,NULL,NULL,NULL,NULL),(2,3,NULL,3,NULL,NULL,NULL,NULL,NULL),(3,1,NULL,1,NULL,NULL,NULL,NULL,NULL),(3,2,NULL,2,NULL,NULL,NULL,NULL,NULL),(4,1,NULL,1,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `st_num` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `start`
--

DROP TABLE IF EXISTS `start`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `start` (
  `st_id` int(11) NOT NULL,
  `st_typ` int(11) DEFAULT NULL,
  `st_nam` varchar(45) COLLATE latin2_croatian_ci NOT NULL,
  `st_nams` varchar(20) COLLATE latin2_croatian_ci DEFAULT NULL,
  `activity` varchar(1) COLLATE latin2_croatian_ci NOT NULL,
  `date` varchar(8) COLLATE latin2_croatian_ci NOT NULL,
  PRIMARY KEY (`st_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `start`
--

LOCK TABLES `start` WRITE;
/*!40000 ALTER TABLE `start` DISABLE KEYS */;
INSERT INTO `start` VALUES (1,NULL,'Konj Vertical',NULL,'D','20131126'),(2,NULL,'Transverzala',NULL,'D','20131126'),(3,NULL,'obična liga',NULL,'D','20131126'),(4,NULL,'obična trka',NULL,'D','20131126');
/*!40000 ALTER TABLE `start` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `state`
--

DROP TABLE IF EXISTS `state`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `state` (
  `sta_id` int(11) NOT NULL,
  `cur_id` int(11) DEFAULT NULL,
  `sta_nam` varchar(80) COLLATE latin2_croatian_ci NOT NULL,
  `sta_nams` varchar(20) COLLATE latin2_croatian_ci DEFAULT NULL,
  `sta_cod1` varchar(10) COLLATE latin2_croatian_ci DEFAULT NULL,
  `sta_cod2` varchar(10) COLLATE latin2_croatian_ci DEFAULT NULL,
  `activity` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `date` varchar(8) COLLATE latin2_croatian_ci DEFAULT NULL,
  PRIMARY KEY (`sta_id`),
  KEY `cur_id_idx` (`cur_id`),
  CONSTRAINT `cur_id` FOREIGN KEY (`cur_id`) REFERENCES `currency` (`cur_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `state`
--

LOCK TABLES `state` WRITE;
/*!40000 ALTER TABLE `state` DISABLE KEYS */;
/*!40000 ALTER TABLE `state` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `table_results`
--

DROP TABLE IF EXISTS `table_results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `table_results` (
  `tab_id` int(11) NOT NULL AUTO_INCREMENT,
  `rac_id` int(11) DEFAULT NULL,
  `lea_id` int(11) DEFAULT NULL,
  `r_leagr_id` int(11) DEFAULT NULL,
  `l_leagr_id` int(11) DEFAULT NULL,
  `rac_lea_add` varchar(45) COLLATE latin2_croatian_ci DEFAULT NULL,
  `per_id` int(11) DEFAULT NULL,
  `st_id` int(11) DEFAULT NULL,
  `sn_id` int(11) DEFAULT NULL,
  `sco_id` int(11) DEFAULT NULL,
  `sco` float DEFAULT NULL,
  `res_fin_time` varchar(45) COLLATE latin2_croatian_ci DEFAULT NULL,
  `res_fin_time_sec` float DEFAULT NULL,
  `activity` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `date` varchar(8) COLLATE latin2_croatian_ci DEFAULT NULL,
  PRIMARY KEY (`tab_id`)
) ENGINE=InnoDB AUTO_INCREMENT=506 DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci COMMENT='synthetic table holding data that will be used for scoring, etc.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `table_results`
--

LOCK TABLES `table_results` WRITE;
/*!40000 ALTER TABLE `table_results` DISABLE KEYS */;
INSERT INTO `table_results` VALUES (480,9,NULL,2,NULL,NULL,1,2,1,NULL,0,'4:56:00',17760,'D','20131126'),(481,9,NULL,2,NULL,NULL,2,2,2,NULL,0,'5:58:00',21480,'D','20131126'),(482,9,NULL,2,NULL,NULL,3,2,3,NULL,0,'6:18:00',22680,'D','20131126'),(488,1,1,NULL,1,NULL,1,1,1,1,92,'0:34:41',2081,'D','20131126'),(489,1,1,NULL,1,NULL,2,1,2,1,95,'0:33:48',2028,'D','20131126'),(490,1,1,NULL,1,NULL,3,1,3,1,100,'0:31:19',1879,'D','20131126'),(491,1,1,NULL,1,NULL,5,1,5,1,100,'0:34:01',2041,'D','20131126'),(495,2,1,NULL,1,NULL,2,1,2,1,100,'0:31:22',1882,'D','20131126'),(496,2,1,NULL,1,NULL,3,1,3,1,95,'0:33:38',2018,'D','20131126'),(497,2,1,NULL,1,NULL,1,1,1,1,92,'0:34:51',2091,'D','20131126'),(498,2,1,NULL,1,NULL,4,1,4,1,90,'0:35:55',2155,'D','20131126'),(502,3,1,NULL,1,NULL,1,1,1,1,100,'0:33:59',2039,'D','20131126'),(503,11,3,NULL,1,NULL,1,1,1,1,95,'0:33:00',1980,'D','20131128'),(504,11,3,NULL,1,NULL,2,1,2,1,100,'0:31:00',1860,'D','20131128'),(505,11,3,NULL,1,NULL,5,1,5,1,100,'0:32:32',1952,'D','20131128');
/*!40000 ALTER TABLE `table_results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test`
--

DROP TABLE IF EXISTS `test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE latin2_croatian_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test`
--

LOCK TABLES `test` WRITE;
/*!40000 ALTER TABLE `test` DISABLE KEYS */;
INSERT INTO `test` VALUES (3,'3'),(23,'ff');
/*!40000 ALTER TABLE `test` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `town`
--

DROP TABLE IF EXISTS `town`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `town` (
  `sta_id` int(11) NOT NULL,
  `cou_id` int(11) DEFAULT NULL,
  `tow_id` int(11) NOT NULL,
  `tow_nam` varchar(80) COLLATE latin2_croatian_ci NOT NULL,
  `tow_nams` varchar(20) COLLATE latin2_croatian_ci DEFAULT NULL,
  `tow_post_num` varchar(20) COLLATE latin2_croatian_ci DEFAULT NULL,
  `activity` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `date` varchar(8) COLLATE latin2_croatian_ci DEFAULT NULL,
  PRIMARY KEY (`tow_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `town`
--

LOCK TABLES `town` WRITE;
/*!40000 ALTER TABLE `town` DISABLE KEYS */;
INSERT INTO `town` VALUES (1,1,1,'Varaždin',NULL,NULL,NULL,NULL),(1,2,2,'Čakovec',NULL,NULL,NULL,NULL),(1,3,3,'Zagreb',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `town` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user` varchar(16) COLLATE latin2_croatian_ci NOT NULL,
  `pass` varchar(16) COLLATE latin2_croatian_ci NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `activity` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `date` varchar(8) COLLATE latin2_croatian_ci DEFAULT NULL,
  PRIMARY KEY (`user`),
  KEY `role_user_id_idx` (`role_id`),
  CONSTRAINT `role_user_id` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('admin','admin',NULL,NULL,NULL),('marko','marko',NULL,NULL,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(45) COLLATE latin2_croatian_ci NOT NULL,
  `activity` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `date` varchar(8) COLLATE latin2_croatian_ci DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role`
--

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `xparameters`
--

DROP TABLE IF EXISTS `xparameters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xparameters` (
  `par_id` int(11) NOT NULL AUTO_INCREMENT,
  `par_nam` varchar(45) COLLATE latin2_croatian_ci NOT NULL,
  `par_val` varchar(45) COLLATE latin2_croatian_ci NOT NULL,
  `par_desc` varchar(45) COLLATE latin2_croatian_ci DEFAULT NULL,
  PRIMARY KEY (`par_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xparameters`
--

LOCK TABLES `xparameters` WRITE;
/*!40000 ALTER TABLE `xparameters` DISABLE KEYS */;
INSERT INTO `xparameters` VALUES (1,'show_races_in_league','1','show races that are in league?'),(2,'show_leagues_in_races_tab','0',NULL),(3,'show_league_groups_in_races_tab','0',NULL);
/*!40000 ALTER TABLE `xparameters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'konj'
--

--
-- Dumping routines for database 'konj'
--
/*!50003 DROP FUNCTION IF EXISTS `best_res_league` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 FUNCTION `best_res_league`(league int, sex int) RETURNS varchar(15) CHARSET latin2 COLLATE latin2_croatian_ci
BEGIN 

declare per_min_res varchar(15);
/*
select min(res_fin_time_sec) into per_min_res
	from race_result rr
	inner join league_st_num lsn on 
		rr.lea_st_num=lsn.lea_st_num
	inner join person per on lsn.per_id=per.per_id
	inner join race r on rr.rac_id=r.rac_id and lsn.lea_id=r.lea_id
	where per.per_sex=sex and lsn.lea_id=league;
*/
select min(res_fin_time) into per_min_res
	from race_result rr
	inner join race r on rr.rac_id=r.rac_id
	inner join start st on r.st_id=st.st_id
	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
	inner join person per on sn.per_id=per.per_id
	where per.per_sex=sex 
	and r.lea_id=league;

return per_min_res;

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `get_average` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 FUNCTION `get_average`(race int, sex int) RETURNS varchar(15) CHARSET latin2 COLLATE latin2_croatian_ci
BEGIN 

declare avg_sek int;

/*into per_id*/

select avg(res_fin_time_sec)
	into avg_sek
	from race_result rr
	inner join league_person_start_num lpsn on 
		rr.lea_per_start_num=lpsn.lea_per_start_num
	inner join person per on lpsn.per_id=per.per_id
	inner join race r on rr.rac_id=r.rac_id and lpsn.lea_id=r.lea_id
	where rr.rac_id=race and per.per_sex=sex;

return concat(floor(avg_sek/3600),":",
		left(concat(floor(avg_sek/60),"00"),2),":",
		left(concat(avg_sek-floor(avg_sek/60)*60,"00"),2));

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `get_best_result_id` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 FUNCTION `get_best_result_id`(race int, sex int) RETURNS int(11)
BEGIN 

declare rr_id int;

select rr.res_id
into rr_id
from race_result rr
	inner join race r on rr.rac_id=r.rac_id
	inner join start st on r.st_id=st.st_id
	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
	inner join person per on sn.per_id=per.per_id
where r.rac_id=race  and per.per_sex=sex and 
	rr.res_fin_time=(select min(rr.res_fin_time) as t 
	from race_result rr
	inner join race r on rr.rac_id=r.rac_id
	inner join start st on r.st_id=st.st_id
	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
	inner join person per on sn.per_id=per.per_id
	where rr.rac_id=race 
	and per.per_sex=sex);

return rr_id;

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `get_best_result_per_id` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 FUNCTION `get_best_result_per_id`(race int, sex int) RETURNS int(11)
BEGIN 

declare per_id int;/*
declare league int;
select lea_id into league from race where rac_id=race;

if(league is not null) then
	select per.per_id
		into per_id
		from race_result rr
		inner join league_st_num lsn on 
			rr.lea_st_num=lsn.lea_st_num
		inner join person per on lsn.per_id=per.per_id
		inner join race r on rr.rac_id=r.rac_id and lsn.lea_id=r.lea_id
		where rr.rac_id=race and per.per_sex=sex and 
			rr.res_fin_time=(select min(rr.res_fin_time) as t
			from race_result rr
			inner join league_st_num lsn on 
				rr.lea_st_num=lsn.lea_st_num
			inner join person per on lsn.per_id=per.per_id
			inner join race r on rr.rac_id=r.rac_id and lsn.lea_id=r.lea_id
			where rr.rac_id=race and per.per_sex=sex);
else
	select per.per_id
		into per_id
		from race_result rr
		inner join race_st_num rsn
			on rr.rac_st_num=rsn.rac_st_num 
			and rr.rac_id=rsn.rac_id
		inner join person per on rsn.per_id=per.per_id
		inner join race r on rr.rac_id=r.rac_id
		where rr.rac_id=race and per.per_sex=sex and 
			rr.res_fin_time=(select min(rr.res_fin_time) as t
			from race_result rr
			inner join race_st_num rsn on 
				rr.rac_st_num=rsn.rac_st_num
			inner join person per on rsn.per_id=per.per_id
			where rr.rac_id=race and per.per_sex=sex);
end if;
*/
	select distinct per.per_id
	into per_id
	from race_result rr
	inner join race r on rr.rac_id=r.rac_id
	inner join start st on r.st_id=st.st_id
	inner join st_num sn on rr.sn_id=sn.sn_id
	inner join person per on sn.per_id=per.per_id
	where rr.rac_id=race and per.per_sex=sex and 
		rr.res_fin_time=(select min(rr.res_fin_time) as t
		from race_result rr
		inner join race r on rr.rac_id=r.rac_id
		inner join start st on r.st_id=st.st_id
		inner join st_num sn on rr.sn_id=sn.sn_id
		inner join person per on sn.per_id=per.per_id
			where rr.rac_id=race and per.per_sex=sex);

return per_id;

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `get_place` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 FUNCTION `get_place`(race int, person int) RETURNS int(11)
BEGIN 

declare place int;
/*declare league int;
declare league_group_sn varchar(1);

select lea_id into league from race where rac_id=race;
select lea_leagr_sn into league_group_sn from race r
inner join league l on r.lea_id=l.lea_id
where rac_id=race;

if(league is null) then
	SELECT count(*)+1 into place
		FROM race_result rr
		where rr.rac_id=race and 
		res_fin_time<
		(
		SELECT res_fin_time
		FROM race_result rr 
		inner join race_st_num rsn 
			on rr.rac_st_num=rsn.rac_st_num and rr.rac_id=rsn.rac_id
		inner join person per on rsn.per_id=per.per_id
		where rr.rac_id=race and per.per_id=person
		);

elseif (lower(league_group_sn = 'n')) then
	SELECT count(*)+1 into place
		FROM race_result rr
		where rac_id=race and 
		res_fin_time<
		(
		SELECT res_fin_time
		FROM race_result rr 
		inner join league_st_num lsn 
			on rr.lea_st_num=lsn.lea_st_num
		inner join person per on lsn.per_id=per.per_id
		where rac_id=race and per.per_id=person 
		);
else 	
	SELECT count(*)+1 into place
		FROM race_result rr
		where rac_id=race and 
		res_fin_time<
		(
		SELECT res_fin_time
		FROM race_result rr 
		inner join league_group_st_num lgsn 
			on rr.leagr_st_num=lgsn.leagr_st_num
		inner join person per on lgsn.per_id=per.per_id
		where rac_id=race and per.per_id=person 
		);
end if;
*/
SELECT count(*)+1 into place
	FROM race_result rr
	where rr.rac_id=race and 
	res_fin_time<
	(
	SELECT res_fin_time
	FROM race_result rr 
	inner join race r on rr.rac_id=r.rac_id
	inner join start st on r.st_id=st.st_id
	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
	inner join person per on sn.per_id=per.per_id
	where rr.rac_id=race and per.per_id=person
	);
return place;

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `get_place_sex` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 FUNCTION `get_place_sex`(race int, person int, sex int) RETURNS int(11)
BEGIN 

declare place int;
/*declare league int;

select lea_id into league from race where rac_id=race;

if(league is not null) then
	SELECT count(*)+1 into place
	FROM race_result rr 
	inner join league_st_num lsn on rr.lea_st_num=lsn.lea_st_num
	inner join person per on lsn.per_id=per.per_id 
	where rac_id=race and 
	res_fin_time<
	(
	SELECT res_fin_time
	FROM race_result rr 
	left outer join league_st_num lsn 
		on rr.lea_st_num=lsn.lea_st_num
	left outer join person per on lsn.per_id=per.per_id
	where rac_id=race and per.per_id=person and lsn.lea_id=league
	)
	and per.per_sex=sex and lsn.lea_id=league;
else
	SELECT count(*)+1 into place
	FROM race_result rr
	inner join race_st_num rsn 
		on rr.rac_st_num=rsn.rac_st_num and rr.rac_id=rsn.rac_id
	inner join person per on rsn.per_id=per.per_id 
	where rr.rac_id=race and 
	res_fin_time<
	(
	SELECT res_fin_time
	FROM race_result rr 
	inner join race_st_num rsn 
		on rr.rac_st_num=rsn.rac_st_num and rr.rac_id=rsn.rac_id
	inner join person per on rsn.per_id=per.per_id
	where rr.rac_id=race and per.per_id=person
	)
	and per.per_sex=sex;
end if;
*/
	SELECT count(*)+1 into place
	FROM race_result rr
	inner join race r on rr.rac_id=r.rac_id
	inner join start st on r.st_id=st.st_id
	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
	inner join person per on sn.per_id=per.per_id
	where rr.rac_id=race and 
	res_fin_time<
	(
	SELECT res_fin_time
	FROM race_result rr 
	inner join race r on rr.rac_id=r.rac_id
	inner join start st on r.st_id=st.st_id
	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
	inner join person per on sn.per_id=per.per_id
	where rr.rac_id=race and per.per_id=person
	)
	and per.per_sex=sex;

return place;

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `get_rac_avg_res` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 FUNCTION `get_rac_avg_res`(race int, sex int) RETURNS varchar(15) CHARSET latin2 COLLATE latin2_croatian_ci
BEGIN 

declare avg_sek int;
/*declare league int;
select lea_id into league from race where rac_id=race;

if(league is not null) then
	select avg(res_fin_time_sec)
		into avg_sek
		from race_result rr
		inner join league_st_num lsn on 
			rr.lea_st_num=lsn.lea_st_num
		inner join person per on lsn.per_id=per.per_id
		inner join race r on rr.rac_id=r.rac_id and lsn.lea_id=r.lea_id
		where rr.rac_id=race and per.per_sex=sex;
else
	select avg(res_fin_time_sec)
		into avg_sek
		from race_result rr
		inner join race_st_num rsn on 
			rr.rac_st_num=rsn.rac_st_num
		inner join person per on rsn.per_id=per.per_id
		inner join race r on rr.rac_id=r.rac_id 
		where rr.rac_id=9 and per.per_sex=1;
end if;
*/
select avg(res_fin_time_sec)
	into avg_sek
	from race_result rr
	inner join race r on rr.rac_id=r.rac_id
	inner join start st on r.st_id=st.st_id
	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
	inner join person per on sn.per_id=per.per_id
	where rr.rac_id=race and per.per_sex=sex;

return concat(floor(avg_sek/3600),":",
		left(concat(floor(avg_sek/60),"00"),2),":",
		left(concat(avg_sek-floor(avg_sek/60)*60,"00"),2));

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `get_time_decimal` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 FUNCTION `get_time_decimal`(score varchar(10)) RETURNS float
BEGIN 

declare time_dec float;

select substring_index(score,':',1) + 
substring_index(substring_index(score,':',-2),':',1)/60 + 
substring_index(substring_index(score,':',-1),':',1)/3600
into time_dec;

return time_dec;

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `PB` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 FUNCTION `PB`(league int, race int, per int) RETURNS int(11)
BEGIN 

declare rac_dat varchar(8);
declare rac_per_res int;
declare per_min_res int;
/*into per_id*/

select r.date into rac_dat from race r where r.rac_id=race;

select rr.res_fin_time_sec into rac_per_res
	from race_result rr
	inner join race r on rr.rac_id=r.rac_id
	inner join start st on r.st_id=st.st_id
	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
	inner join person per on sn.per_id=per.per_id
	where per.per_id=per and rr.rac_id=race /*and r.lea_id=league*/;

select min(res_fin_time_sec) into per_min_res
	from race_result rr
	inner join race r on rr.rac_id=r.rac_id
	inner join start st on r.st_id=st.st_id
	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
	inner join person per on sn.per_id=per.per_id
	where per.per_id=per and r.rac_id<>race /*and l.lea_id=league*/
		and r.date<rac_dat;

if(per_min_res is null) then return 1;
else return (select rac_per_res<per_min_res);
end if;

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `PB_league` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 FUNCTION `PB_league`(league int, per int) RETURNS varchar(15) CHARSET latin2 COLLATE latin2_croatian_ci
BEGIN 

declare per_min_res varchar(15);

select min(res_fin_time) into per_min_res
	from race_result rr
	inner join race r on rr.rac_id=r.rac_id
	inner join start st on r.st_id=st.st_id
	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
	inner join person per on sn.per_id=per.per_id
	where per.per_id=per and r.lea_id=league;

return per_min_res;

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `PB_league_gr` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 FUNCTION `PB_league_gr`(league_gr int, per int) RETURNS varchar(15) CHARSET latin2 COLLATE latin2_croatian_ci
BEGIN 

declare per_min_res varchar(15);

select min(res_fin_time) into per_min_res
	from race_result rr
	inner join race r on rr.rac_id=r.rac_id
	inner join start st on r.st_id=st.st_id
	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
	inner join person per on sn.per_id=per.per_id
	left join league l on r.lea_id=l.lea_id
	left join league_group lg on r.leagr_id=lg.leagr_id
	where per.per_id=per and (l.leagr_id=league_gr or lg.leagr_id=league_gr);

return per_min_res;

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `get_best_result` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `get_best_result`(race int, sex int)
BEGIN

/*
declare league int;
select lea_id into league from race where rac_id=race;

if(league is not null) then
	select min(rr.res_fin_time) as t, per.per_id, concat(per_nam, ' ', per_sur) as NameSurname
	from race_result rr
	inner join league_st_num lsn on 
		rr.lea_st_num=lsn.lea_st_num
	inner join person per on lsn.per_id=per.per_id
	inner join race r on rr.rac_id=r.rac_id and lsn.lea_id=r.lea_id
	where rr.rac_id=race and per.per_sex=sex and 
		rr.res_fin_time=(select min(rr.res_fin_time) as t
		from race_result rr
		inner join league_st_num lpsn on 
			rr.lea_st_num=lpsn.lea_st_num
		inner join person per on lpsn.per_id=per.per_id
		inner join race r on rr.rac_id=r.rac_id and lpsn.lea_id=r.lea_id
		where rr.rac_id=race and per.per_sex=sex);
else
	select min(rr.res_fin_time) as t, per.per_id, concat(per_nam, ' ', per_sur) as NameSurname
	from race_result rr
	inner join race_st_num rsn on 
		rr.rac_st_num=rsn.rac_st_num
	inner join person per on rsn.per_id=per.per_id
	inner join race r on rr.rac_id=r.rac_id
	where rr.rac_id=race and per.per_sex=sex and 
		rr.res_fin_time=(select min(rr.res_fin_time) as t
		from race_result rr
		inner join race_st_num rsn on 
			rr.rac_st_num=rsn.rac_st_num
		inner join person per on rsn.per_id=per.per_id
		where rr.rac_id=race and per.per_sex=sex);
end if;
*/
	select min(rr.res_fin_time) as t, per.per_id, concat(per_nam, ' ', per_sur) as NameSurname
	from race_result rr
	inner join race r on rr.rac_id=r.rac_id
	inner join start st on r.st_id=st.st_id
	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
	inner join person per on sn.per_id=per.per_id
	where rr.rac_id=race and per.per_sex=sex and 
		rr.res_fin_time=(select min(rr.res_fin_time) as t
		from race_result rr
		inner join race r on rr.rac_id=r.rac_id
		inner join start st on r.st_id=st.st_id
		inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
		inner join person per on sn.per_id=per.per_id
		where rr.rac_id=race 
		and per.per_sex=sex);
END */;;
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

-- Dump completed on 2013-12-01 16:57:41
