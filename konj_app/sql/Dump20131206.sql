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
-- Table structure for table `club`
--

DROP TABLE IF EXISTS `club`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club` (
  `clu_id` int(11) NOT NULL AUTO_INCREMENT,
  `tow_id` int(11) DEFAULT NULL,
  `cou_id` int(11) DEFAULT NULL,
  `sta_id` int(11) DEFAULT NULL,
  `clu_nam` varchar(80) NOT NULL,
  `clu_nams` varchar(20) DEFAULT NULL,
  `clu_adr` varchar(80) DEFAULT NULL,
  `clu_tow` varchar(45) DEFAULT NULL,
  `clu_cou` varchar(45) DEFAULT NULL,
  `clu_sta` varchar(45) DEFAULT NULL,
  `clu_email` varchar(80) DEFAULT NULL,
  `clu_web` varchar(30) DEFAULT NULL,
  `clu_tel` varchar(30) CHARACTER SET latin2 COLLATE latin2_croatian_ci DEFAULT NULL,
  `clu_tel2` varchar(30) CHARACTER SET latin2 COLLATE latin2_croatian_ci DEFAULT NULL,
  `clu_fax` varchar(30) CHARACTER SET latin2 COLLATE latin2_croatian_ci DEFAULT NULL,
  `clu_mob` varchar(20) CHARACTER SET latin2 COLLATE latin2_croatian_ci DEFAULT NULL,
  `clu_mob2` varchar(20) CHARACTER SET latin2 COLLATE latin2_croatian_ci DEFAULT NULL,
  `clu_acc` varchar(30) CHARACTER SET latin2 COLLATE latin2_croatian_ci DEFAULT NULL,
  `clu_acc2` varchar(30) CHARACTER SET latin2 COLLATE latin2_croatian_ci DEFAULT NULL,
  `activity` varchar(1) CHARACTER SET latin2 COLLATE latin2_croatian_ci DEFAULT NULL,
  `date` varchar(8) CHARACTER SET latin2 COLLATE latin2_croatian_ci DEFAULT NULL,
  PRIMARY KEY (`clu_id`),
  KEY `tow_id_idx` (`tow_id`),
  CONSTRAINT `tow_id` FOREIGN KEY (`tow_id`) REFERENCES `town` (`tow_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
-- Table structure for table `league`
--

DROP TABLE IF EXISTS `league`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `league` (
  `lea_id` int(11) NOT NULL AUTO_INCREMENT,
  `leagr_id` int(11) DEFAULT NULL,
  `sco_id` int(11) DEFAULT NULL,
  `org_id` int(11) NOT NULL,
  `lea_nam` varchar(80) CHARACTER SET utf8 NOT NULL,
  `lea_nams` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `lea_fr_dat` varchar(8) COLLATE latin2_croatian_ci DEFAULT NULL,
  `lea_to_dat` varchar(8) COLLATE latin2_croatian_ci DEFAULT NULL,
  `lea_day` int(11) DEFAULT NULL,
  `lea_day_sco` int(11) DEFAULT NULL,
  `lea_desc` varchar(300) CHARACTER SET utf8 DEFAULT NULL,
  `lea_rul` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `lea_leagr_sn` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL COMMENT 'league uses start numbers from league group',
  `activity` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `date` varchar(8) COLLATE latin2_croatian_ci DEFAULT NULL,
  `lea_ent_fee` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`lea_id`),
  KEY `sco_id_idx` (`sco_id`),
  CONSTRAINT `sco_id` FOREIGN KEY (`sco_id`) REFERENCES `scoring` (`sco_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `league_group`
--

DROP TABLE IF EXISTS `league_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `league_group` (
  `leagr_id` int(11) NOT NULL AUTO_INCREMENT,
  `sco_id` int(11) DEFAULT NULL,
  `org_id` int(11) DEFAULT NULL,
  `leagr_nam` varchar(80) COLLATE latin2_croatian_ci NOT NULL,
  `leagr_nams` varchar(20) COLLATE latin2_croatian_ci DEFAULT NULL,
  `leagr_rul` varchar(500) COLLATE latin2_croatian_ci DEFAULT NULL,
  PRIMARY KEY (`leagr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `person`
--

DROP TABLE IF EXISTS `person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `person` (
  `per_id` int(11) NOT NULL AUTO_INCREMENT,
  `clu_id` int(11) DEFAULT NULL,
  `tow_id` int(11) DEFAULT NULL,
  `sta_id` int(11) DEFAULT NULL,
  `per_nam` varchar(80) CHARACTER SET utf8 NOT NULL,
  `per_sur` varchar(80) CHARACTER SET utf8 NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `rac_lea_add` varchar(45) COLLATE latin2_croatian_ci DEFAULT NULL COMMENT 'If race in several leagues, then write 3;4;12 as league id\\\\\\\\\\\\\\''s',
  `rac_leagr_add` varchar(45) COLLATE latin2_croatian_ci DEFAULT NULL,
  `rac_typ_add` varchar(45) COLLATE latin2_croatian_ci DEFAULT NULL COMMENT 'If race in several types, then write 3;4;12 as race type id\\\\\\''s',
  `rac_nam` varchar(80) CHARACTER SET utf8 NOT NULL COMMENT 'full name',
  `rac_nams` varchar(20) CHARACTER SET utf8 DEFAULT NULL COMMENT 'short name',
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
  `rac_ent_fee_val` varchar(45) COLLATE latin2_croatian_ci DEFAULT NULL COMMENT 'If race entry fee in several currencies, then write \\\\\\\\\\\\\\"fee,currency_id\\\\\\\\\\\\\\" as \\\\\\\\\\\\\\"100#2;120#4;200#5\\\\\\\\\\\\\\"',
  `rac_shirt` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `rac_water` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `rac_drink` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `rac_eat` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `rac_rs` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL COMMENT 'rescue service',
  `rac_fraid` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL COMMENT 'first aid',
  `rac_reg_fr_dat` datetime DEFAULT NULL,
  `rac_reg_to_dat` datetime DEFAULT NULL,
  `rac_desc` varchar(300) CHARACTER SET utf8 DEFAULT NULL,
  `rac_calc` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL COMMENT 'Calculation is made',
  `rac_rul` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `rac_man_eq` varchar(200) CHARACTER SET utf8 DEFAULT NULL COMMENT 'mandatory equipment, for example \\\\\\\\\\\\\\"compass; 1l water; buff\\\\\\\\\\\\\\"',
  `rac_chk` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL COMMENT 'if race includes checkpoints',
  `rac_lea_rou` int(11) DEFAULT NULL COMMENT 'if race in league then round in league (1,2,3,...)',
  `rac_meal` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `activity` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `date` varchar(8) COLLATE latin2_croatian_ci NOT NULL,
  PRIMARY KEY (`rac_id`),
  KEY `rac_typ_id_idx` (`rac_typ_id`),
  CONSTRAINT `rac_typ_id` FOREIGN KEY (`rac_typ_id`) REFERENCES `race_type` (`rac_typ_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `race_rec`
--

DROP TABLE IF EXISTS `race_rec`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `race_rec` (
  `rac_rec_id` int(11) NOT NULL AUTO_INCREMENT,
  `rac_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start` datetime DEFAULT NULL,
  `start_sec` int(11) DEFAULT NULL,
  `stop` datetime DEFAULT NULL,
  `stop_sec` int(11) DEFAULT NULL,
  `activity` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`rac_rec_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `rac_reg_nam` varchar(40) CHARACTER SET utf8 NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `res_typ_id` int(11) DEFAULT NULL,
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
-- Table structure for table `race_result_typ`
--

DROP TABLE IF EXISTS `race_result_typ`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `race_result_typ` (
  `res_typ_id` int(11) NOT NULL AUTO_INCREMENT,
  `res_typ_nam` varchar(45) NOT NULL,
  `res_typ_nams` varchar(20) NOT NULL,
  `res_typ_desc` varchar(100) DEFAULT NULL,
  `activity` varchar(1) DEFAULT NULL,
  `date` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`res_typ_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(16) COLLATE latin2_croatian_ci NOT NULL,
  `pass` varchar(16) COLLATE latin2_croatian_ci NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `activity` varchar(1) COLLATE latin2_croatian_ci DEFAULT NULL,
  `date` varchar(8) COLLATE latin2_croatian_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `role_user_id_idx` (`role_id`),
  CONSTRAINT `role_user_id` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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

-- Dump completed on 2013-12-06 23:31:12
