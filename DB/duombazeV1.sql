-- MySQL dump 10.13  Distrib 5.5.37, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: cooktimesaver
-- ------------------------------------------------------
-- Server version	5.5.37-0ubuntu0.14.04.1

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
-- Table structure for table `ingredients`
--

DROP TABLE IF EXISTS `ingredients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ingredients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ingredient` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingredients`
--

LOCK TABLES `ingredients` WRITE;
/*!40000 ALTER TABLE `ingredients` DISABLE KEYS */;
INSERT INTO `ingredients` VALUES (1,'Bulvės'),(2,'Mocarelos sūris'),(3,'Kietasis sūris'),(4,'Itališkų žolelių mišinys'),(5,'Džiovintas raudonėlis'),(6,'Baklažanas'),(7,'Cukinija'),(8,'Pievagrybiai'),(9,'Svogūnas'),(10,'Sviestas'),(11,'Liesa griedinė'),(12,'Cukrus'),(13,'Vanilinio cukraus milteliai'),(14,'Šviežio imbiero šaknis'),(15,'Miltai'),(16,'Kiaušiniai'),(17,'Brandintos jautienos nugarinė'),(18,'Mėgstamas aliejus');
/*!40000 ALTER TABLE `ingredients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipe_ingredients_needed`
--

DROP TABLE IF EXISTS `recipe_ingredients_needed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recipe_ingredients_needed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recipe_id` int(11) NOT NULL,
  `ingredients_id` int(11) NOT NULL,
  `amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4429DC9F59D8A214` (`recipe_id`),
  KEY `IDX_4429DC9F3EC4DCE` (`ingredients_id`),
  CONSTRAINT `FK_4429DC9F3EC4DCE` FOREIGN KEY (`ingredients_id`) REFERENCES `ingredients` (`id`),
  CONSTRAINT `FK_4429DC9F59D8A214` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipe_ingredients_needed`
--

LOCK TABLES `recipe_ingredients_needed` WRITE;
/*!40000 ALTER TABLE `recipe_ingredients_needed` DISABLE KEYS */;
INSERT INTO `recipe_ingredients_needed` VALUES (1,1,1,'2 vnt'),(2,1,2,'500 g'),(3,1,3,'100 g'),(4,1,4,'0.5 šaukštelio'),(5,1,5,'1.5 šaukštelio'),(6,1,6,'1 vnt'),(7,1,7,'1 vnt'),(8,1,8,'250 g'),(9,1,9,'1 vnt'),(10,2,10,'200 g'),(11,2,11,'150 g'),(12,2,12,'370 g'),(13,2,13,'40 g'),(14,2,14,'4 cm'),(15,2,15,'450 g'),(16,2,16,'6 vnt'),(17,3,17,'1 kg'),(18,3,18,'2 šaukštų'),(19,3,10,'50 g');
/*!40000 ALTER TABLE `recipe_ingredients_needed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipe_step_relationships`
--

DROP TABLE IF EXISTS `recipe_step_relationships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recipe_step_relationships` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recipe_step_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_74779AB13F5610DC` (`recipe_step_id`),
  CONSTRAINT `FK_74779AB13F5610DC` FOREIGN KEY (`recipe_step_id`) REFERENCES `recipe_steps` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipe_step_relationships`
--

LOCK TABLES `recipe_step_relationships` WRITE;
/*!40000 ALTER TABLE `recipe_step_relationships` DISABLE KEYS */;
INSERT INTO `recipe_step_relationships` VALUES (1,5,NULL),(2,4,5),(3,3,4),(4,2,3),(5,1,2);
/*!40000 ALTER TABLE `recipe_step_relationships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipe_steps`
--

DROP TABLE IF EXISTS `recipe_steps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recipe_steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recipe_id` int(11) NOT NULL,
  `total_time` bigint(20) NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total_time_count` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2231DE6D59D8A214` (`recipe_id`),
  CONSTRAINT `FK_2231DE6D59D8A214` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipe_steps`
--

LOCK TABLES `recipe_steps` WRITE;
/*!40000 ALTER TABLE `recipe_steps` DISABLE KEYS */;
INSERT INTO `recipe_steps` VALUES (1,1,789,'Uzvirti Vandeni','http://lorempixel.com/250/250/food/',9,1),(2,1,644,'Su8berti viska i verdanti vandeni','http://lorempixel.com/250/250/food/',9,0),(3,1,722,'Supjaustyti darzoves','http://lorempixel.com/250/250/food/',9,1),(4,1,145,'Suberti likusias supjaustytas darzoves','http://lorempixel.com/250/250/food/',9,1),(5,1,588,'Paskanauti','http://lorempixel.com/250/250/food/',9,1);
/*!40000 ALTER TABLE `recipe_steps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipes`
--

DROP TABLE IF EXISTS `recipes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recipes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipes`
--

LOCK TABLES `recipes` WRITE;
/*!40000 ALTER TABLE `recipes` DISABLE KEYS */;
INSERT INTO `recipes` VALUES (1,'Daržovių sluoksniuotinis','http://lorempixel.com/200/165/food/','Baklažanas, konservuoti pomidorai patiekalui suteikia nekasdieniško skonio, todėl šis daržovių apkepas drąsiai gali būti šventinio stalio dalimi. ypač turėtų nudžiugti vegetarai. Galite valgyti ir su šviežiomis salotomis. Tikras daržovių mėgėjų rojus.',24),(2,'Velykinis keksas','http://lorempixel.com/200/165/food/','Praėjusių metų Velykoms aš siūliau kepti Velykų pynę, o šiais -  kepinį žavų savo geltonumu, gerą, patikrintą, dosnų ir didelį keksą. Tokiai tešlai galime rasti įvairiausių būsenų ir formų, viskas priklauso nuo to kokiame inde pasirinksime jį kepti: galime daryti keksiukus, galime kepti pailgoje formoje, galime išlieti visai ploną ir susukti vyniotinį ir net mažus sausainėlius galima kepti. Ir aišku, galima iškepti toki uch keksą.',49),(3,'Jautienos didkepsnis','http://lorempixel.com/200/165/food/','Taigi kokios yra to stebuklingo jautienos didkepsnio stebuklingos kepimo taisyklės? Atsiminkite tik vieną taisyklę – mažiau yra daugiau. Mažiau kepimo laiko, labai labai karšta keptuvė, šiek tiek laiko mėsai pailsėti šiltoje orkaitėje ar tiesiog ant stalo, plačiai atidaryti virtuvės langai ir jokių ten marinavimų, tik geriausios kokybės druska ir pipirai.',9);
/*!40000 ALTER TABLE `recipes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `step_relationships`
--

DROP TABLE IF EXISTS `step_relationships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `step_relationships` (
  `recipestep_id` int(11) NOT NULL,
  `steprelationship_id` int(11) NOT NULL,
  PRIMARY KEY (`recipestep_id`,`steprelationship_id`),
  KEY `IDX_A51EB4A879FE73E` (`recipestep_id`),
  KEY `IDX_A51EB4A860EF70AA` (`steprelationship_id`),
  CONSTRAINT `FK_A51EB4A860EF70AA` FOREIGN KEY (`steprelationship_id`) REFERENCES `recipe_step_relationships` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_A51EB4A879FE73E` FOREIGN KEY (`recipestep_id`) REFERENCES `recipe_steps` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `step_relationships`
--

LOCK TABLES `step_relationships` WRITE;
/*!40000 ALTER TABLE `step_relationships` DISABLE KEYS */;
/*!40000 ALTER TABLE `step_relationships` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-04-24 17:55:25
