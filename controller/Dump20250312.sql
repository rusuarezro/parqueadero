-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: dbjrparking
-- ------------------------------------------------------
-- Server version	8.0.40

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `factura`
--

DROP TABLE IF EXISTS `factura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `factura` (
  `id_factura` int unsigned NOT NULL AUTO_INCREMENT,
  `idparqueadero` int unsigned NOT NULL,
  `id_historialpuesto` bigint unsigned NOT NULL,
  `observaciones` varchar(200) NOT NULL,
  `tiempo` int NOT NULL,
  `valor_neto` double(8,2) NOT NULL,
  `VALOR_PAGAR` double(8,2) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_factura`),
  KEY `tbparqueaderos3_fkey` (`idparqueadero`),
  KEY `historial_puesto_fkey` (`id_historialpuesto`),
  CONSTRAINT `historial_puesto_fkey` FOREIGN KEY (`id_historialpuesto`) REFERENCES `historial_puesto` (`idpuesto`),
  CONSTRAINT `tbparqueaderos3_fkey` FOREIGN KEY (`idparqueadero`) REFERENCES `tbparqueaderos` (`ID_PARQUEADERO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura`
--

LOCK TABLES `factura` WRITE;
/*!40000 ALTER TABLE `factura` DISABLE KEYS */;
/*!40000 ALTER TABLE `factura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historial`
--

DROP TABLE IF EXISTS `historial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historial` (
  `idhistorico` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tabla` varchar(100) DEFAULT NULL,
  `datos` text,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_usuario` int DEFAULT NULL,
  PRIMARY KEY (`idhistorico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial`
--

LOCK TABLES `historial` WRITE;
/*!40000 ALTER TABLE `historial` DISABLE KEYS */;
/*!40000 ALTER TABLE `historial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historial_puesto`
--

DROP TABLE IF EXISTS `historial_puesto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historial_puesto` (
  `idpuesto` bigint unsigned NOT NULL AUTO_INCREMENT,
  `idusuario` bigint unsigned NOT NULL,
  `idvehiculo` bigint unsigned NOT NULL,
  `ESTADO_FK` int unsigned NOT NULL DEFAULT '4',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idpuesto`),
  KEY `tbestado2_fkey` (`ESTADO_FK`),
  KEY `tbusuarios2_fkey` (`idusuario`),
  KEY `vehiculo_fkey` (`idvehiculo`),
  CONSTRAINT `tbestado2_fkey` FOREIGN KEY (`ESTADO_FK`) REFERENCES `tbestado` (`ID_ESTADO`),
  CONSTRAINT `tbusuarios2_fkey` FOREIGN KEY (`idusuario`) REFERENCES `tbusuarios` (`ID_USUARIO`),
  CONSTRAINT `vehiculo_fkey` FOREIGN KEY (`idvehiculo`) REFERENCES `vehiculo` (`id_vehiculo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial_puesto`
--

LOCK TABLES `historial_puesto` WRITE;
/*!40000 ALTER TABLE `historial_puesto` DISABLE KEYS */;
INSERT INTO `historial_puesto` VALUES (1,90,2,3,'2025-02-08 00:53:06','2025-02-13 00:29:35'),(4,90,1,3,'2025-02-13 08:07:15','2025-02-13 08:07:15');
/*!40000 ALTER TABLE `historial_puesto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tarifa`
--

DROP TABLE IF EXISTS `tarifa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tarifa` (
  `id_tarifa` int unsigned NOT NULL AUTO_INCREMENT,
  `tipoVehiculo` int unsigned DEFAULT NULL,
  `precio` int NOT NULL,
  `idestado` int unsigned DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_tarifa`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tarifa`
--

LOCK TABLES `tarifa` WRITE;
/*!40000 ALTER TABLE `tarifa` DISABLE KEYS */;
INSERT INTO `tarifa` VALUES (1,1,3000,1,'2025-02-13 00:29:35','2025-02-18 03:31:45'),(2,2,1500,1,'2025-02-18 00:17:04','2025-02-18 00:17:04'),(3,3,1000,1,'2025-02-20 05:57:04','2025-02-20 05:57:04');
/*!40000 ALTER TABLE `tarifa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbdescuentos`
--

DROP TABLE IF EXISTS `tbdescuentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbdescuentos` (
  `ID_DESCUENTO` int unsigned NOT NULL AUTO_INCREMENT,
  `NOMBRE_DES` varchar(50) NOT NULL,
  `FRACCION_MINIMA` int NOT NULL DEFAULT '1',
  `REGLA` int NOT NULL,
  `ESTADO_FK` int unsigned NOT NULL,
  PRIMARY KEY (`ID_DESCUENTO`),
  KEY `tbDescuentos_fkey` (`ESTADO_FK`),
  CONSTRAINT `tbDescuentos_fkey` FOREIGN KEY (`ESTADO_FK`) REFERENCES `tbestado` (`ID_ESTADO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbdescuentos`
--

LOCK TABLES `tbdescuentos` WRITE;
/*!40000 ALTER TABLE `tbdescuentos` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbdescuentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbestado`
--

DROP TABLE IF EXISTS `tbestado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbestado` (
  `ID_ESTADO` int unsigned NOT NULL AUTO_INCREMENT,
  `DESCRIPCION_EST` varchar(30) NOT NULL,
  PRIMARY KEY (`ID_ESTADO`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbestado`
--

LOCK TABLES `tbestado` WRITE;
/*!40000 ALTER TABLE `tbestado` DISABLE KEYS */;
INSERT INTO `tbestado` VALUES (1,'ACTIVO'),(2,'INACTIVO'),(3,'DISPONIBLE'),(4,'OCUPADO'),(5,'FINALIZADO');
/*!40000 ALTER TABLE `tbestado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbparqueaderos`
--

DROP TABLE IF EXISTS `tbparqueaderos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbparqueaderos` (
  `ID_PARQUEADERO` int unsigned NOT NULL AUTO_INCREMENT,
  `nit` varchar(13) NOT NULL,
  `NOMBRE` varchar(50) NOT NULL,
  `DIRECCION` varchar(80) NOT NULL,
  `ESTADO_FK` int NOT NULL DEFAULT '1',
  `phone` varchar(11) NOT NULL,
  PRIMARY KEY (`ID_PARQUEADERO`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbparqueaderos`
--

LOCK TABLES `tbparqueaderos` WRITE;
/*!40000 ALTER TABLE `tbparqueaderos` DISABLE KEYS */;
INSERT INTO `tbparqueaderos` VALUES (1,'900055094-1','Aquiles Colmbia SAS','Bogota-Chapinero',1,'3125891781');
/*!40000 ALTER TABLE `tbparqueaderos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbperfiles`
--

DROP TABLE IF EXISTS `tbperfiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbperfiles` (
  `ID_PERFIL` int unsigned NOT NULL AUTO_INCREMENT,
  `NOMBRE_PER` varchar(20) NOT NULL,
  PRIMARY KEY (`ID_PERFIL`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbperfiles`
--

LOCK TABLES `tbperfiles` WRITE;
/*!40000 ALTER TABLE `tbperfiles` DISABLE KEYS */;
INSERT INTO `tbperfiles` VALUES (1,'ADMINISTRADOR'),(2,'EMPLEADO'),(3,'CLIENTE');
/*!40000 ALTER TABLE `tbperfiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbusuarios`
--

DROP TABLE IF EXISTS `tbusuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbusuarios` (
  `ID_USUARIO` bigint unsigned NOT NULL AUTO_INCREMENT,
  `IDENTIFICACION` varchar(15) NOT NULL,
  `NOMBRES` varchar(100) NOT NULL,
  `APELLIDOS` varchar(100) NOT NULL,
  `CELULAR` varchar(10) NOT NULL,
  `EMAIL` varchar(80) NOT NULL,
  `CONTRASENA` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `PERFIL_FK` int unsigned NOT NULL,
  `ESTADO_FK` int unsigned NOT NULL,
  PRIMARY KEY (`ID_USUARIO`),
  UNIQUE KEY `IDENTIFICACION` (`IDENTIFICACION`),
  KEY `tbestado_fkey` (`ESTADO_FK`),
  KEY `tbperfiles_fkey` (`PERFIL_FK`),
  CONSTRAINT `tbestado_fkey` FOREIGN KEY (`ESTADO_FK`) REFERENCES `tbestado` (`ID_ESTADO`),
  CONSTRAINT `tbperfiles_fkey` FOREIGN KEY (`PERFIL_FK`) REFERENCES `tbperfiles` (`ID_PERFIL`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbusuarios`
--

LOCK TABLES `tbusuarios` WRITE;
/*!40000 ALTER TABLE `tbusuarios` DISABLE KEYS */;
INSERT INTO `tbusuarios` VALUES (2,'254700079-2','Pier','Dodswell','8086159351','pdodswell0@state.tx.us','qK8&.wW)3o*>EKLSD\"@7\'KsQ4','2024-06-02 05:00:00','2025-01-06 20:47:28',3,1),(3,'567768278-0','Casar','Heinssen','8318573141','cheinssen1@whitehouse.gov','jM2=&fd2kRzt0SL*t_ch&B','2024-02-21 05:00:00','2025-01-06 20:47:28',3,1),(4,'404586264-1','Amelina','Litton','3513867894','alitton2@eventbrite.com','rH0(Pj$UGYfgNp#=AV\'#aC=uz,Y','2024-04-05 05:00:00','2025-01-06 20:47:28',3,1),(5,'427459547-1','Quinn','Nelm','2401085812','qnelm3@tripod.com','nH1\"ll6Az&d0AOvqvU0f=NDA5@F{F/1@W','2024-04-09 05:00:00','2025-01-06 20:47:28',3,1),(6,'284891355-X','Bernarr','Beedle','5714274385','bbeedle4@deviantart.com','pD0*Z37gfe\'%,L2v\"\"','2024-07-05 05:00:00','2025-01-06 20:47:28',3,1),(7,'528306155-8','Neile','Russen','1198784235','nrussen5@woothemes.com','xP8\'aOYkR#>_<Q4k/6n\"WFb0','2024-07-13 05:00:00','2024-05-21 05:00:00',3,1),(8,'946356861-1','Doll','Hug','9409630275','dhug6@ft.com','bR6?h3WQ&WrPe)rZyJ`&11<(KV','2024-11-04 05:00:00','2025-01-06 20:44:35',3,1),(9,'086708906-7','Jordanna','Breakey','8408702672','jbreakey7@scientificamerican.com','yQ7!y~)U7mVR)}h_%TMG|','2024-10-15 05:00:00','2025-01-06 20:44:35',3,1),(10,'059240435-8','Emmott','Croucher','8098945365','ecroucherb@dagondesign.com','oZ6|T\'wFlA`t5l,eYTbM02f?/Ge|kZ=8R<gl','2024-09-10 05:00:00','2025-01-06 20:47:28',3,1),(11,'574108523-7','Rafaello','Halloran','3508220551','rhalloranc@wp.com','lC0.~4@HadvVn|qt_h|','2024-03-15 05:00:00','2024-06-20 05:00:00',3,1),(12,'630640377-9','Towny','Birdall','2918289586','tbirdalld@irs.gov','yY5.|\'curne0%acACNE','2024-05-11 05:00:00','2025-01-06 20:47:28',3,1),(13,'548549871-X','Dorene','Eley','8304651736','deleye@newsvine.com','hV92602~t)xjJKdTj}I%3i29GVZSii\"','2024-02-11 05:00:00','2025-01-06 20:47:28',3,1),(14,'910981100-1','Marilee','Manchester','1582827982','mmanchesterf@nationalgeographic.com','qC2`HNJCpcj=,,PJ_nw!,m$K','2024-10-29 05:00:00','2025-01-06 20:44:35',3,1),(15,'555598874-5','Jae','Lamey','3027015595','jlameyg@gmpg.org','mE3.B,P$D(t7mpqp$xzR','2024-08-28 05:00:00','2024-05-05 05:00:00',3,1),(16,'612831312-4','Ginevra','O\'Logan','1945183187','gologanh@msu.edu','jV4|asG+R%~UU@E1KGUGkCZRL%','2024-03-08 05:00:00','2025-01-06 20:47:28',3,1),(17,'141129457-2','Kennan','Cuthill','3431306368','kcuthillk@studiopress.com','pB6$LMFy1wm=y@CI6V(OZ)Vb@\'+Tn','2024-06-21 05:00:00','2025-01-06 20:47:28',3,1),(18,'198502687-2','Orazio','Beausang','1312033312','obeausangl@marketwatch.com','qI3~IuamAy0~cOyRJX}9s@bEdQ\"o{c(','2024-03-09 05:00:00','2024-11-12 05:00:00',3,1),(19,'446492839-0','Neddy','Dunbavin','4294215077','ndunbavinm@usgs.gov','eQ1>gz+eZau,RV|bK_,|\'9gc5qiWW2i+k2','2024-05-03 05:00:00','2025-01-06 20:47:28',3,1),(20,'396437218-8','Clo','Templeman','2449966430','ctemplemann@apple.com','iY3\'5\"M/9rfl}fhvO\"&1A<GUjJ#awW0~7T','2024-02-01 05:00:00','2025-01-06 20:47:28',3,1),(21,'379221376-1','Salomo','Jarmaine','9217748418','sjarmaineo@skyrock.com','tP7#Qgu6Z281xhIE(Se}M','2024-01-30 05:00:00','2025-01-06 20:44:35',3,1),(22,'382761185-7','Henrieta','Gerraty','5412205973','hgerratyp@skype.com','nO5&z}!YkcXA,NrW8VL,gx#Dhyv~D','2024-07-12 05:00:00','2025-01-06 20:44:35',3,1),(23,'560247274-6','Viola','Yerill','2827299843','vyerillq@narod.ru','vP5|Hd+(fhZ*=.)Izmr3','2024-05-25 05:00:00','2025-01-06 20:44:35',3,1),(24,'369700744-0','Elsie','Yegorchenkov','1899087683','eyegorchenkovr@theguardian.com','tN5}L#|5hWEZRR0ap,c2VhrF_.O`<xQPZxW','2024-12-26 05:00:00','2025-01-06 20:44:35',3,1),(25,'411237148-9','Thane','Grigoliis','1342170338','tgrigoliiss@ft.com','tK7|#4D.EQI(jWS<,Bz\'XDbRX_foP','2024-09-03 05:00:00','2025-01-06 20:47:28',3,1),(26,'660515910-1','Caterina','Goodlake','1171947681','cgoodlaket@ehow.com','pM8+mY*g#+WE$I_mIPu{','2024-04-13 05:00:00','2025-01-06 20:47:28',3,1),(27,'531876750-8','Bernie','Battie','5437747070','bbattieu@elegantthemes.com','tF5<u~1*q56D1&0nsw7Y!C(Gp7uv|c1~','2024-11-09 05:00:00','2024-11-04 05:00:00',3,1),(28,'182895340-7','Jervis','Stenson','5821962868','jstensonv@utexas.edu','cB6,1~!XQO97F8FQ6E5HGPm|9HOy?<&CP','2024-07-21 05:00:00','2024-08-09 05:00:00',3,1),(29,'252717544-9','Nicolette','Slowan','3686450917','nslowanw@yellowbook.com','pO7\"@@y3fBP,z%zIK@+x!fX(V','2024-03-16 05:00:00','2024-12-30 05:00:00',3,1),(30,'341179198-5','Stanislas','Andrioni','4094668996','sandrionix@tumblr.com','hH5#Idf8b</$@asAt7vq','2024-09-05 05:00:00','2024-08-18 05:00:00',3,1),(31,'802310465-9','Ash','Fellini','3503992627','afelliniy@feedburner.com','uW3=}l4Y\'Zjmx7e(IB7C!D','2024-05-23 05:00:00','2025-01-06 20:47:28',3,1),(32,'872090754-0','Ella','McMackin','8008196305','emcmackinz@rakuten.co.jp','kI2|mK_~9lQ&{p`hHjMXIvSX$Vt','2024-12-05 05:00:00','2025-01-06 20:47:28',3,1),(33,'572978759-6','Phip','MacParlan','1667064803','pmacparlan10@indiegogo.com','kI1}tX70jA1T<<ygV`W','2024-01-17 05:00:00','2025-01-06 20:47:28',3,1),(34,'993489251-0','Rasla','Papa','8699099575','rpapa11@ucoz.com','cZ7_u~+ldM8v(UPV*_kgQ}6UtZ<X`3jP','2024-09-14 05:00:00','2025-01-06 20:47:28',3,1),(35,'048772615-4','Osmond','Westlake','7113160767','owestlake12@drupal.org','cH1%QfJ}sK~7/1xC2m','2024-01-28 05:00:00','2024-05-21 05:00:00',3,1),(36,'195420183-4','Hercules','Orchart','9309845954','horchart13@xrea.com','gK7\"CXgHzjD@%iRQFx`Y','2024-10-15 05:00:00','2025-01-06 20:47:28',3,1),(37,'753070990-9','Tedman','Pickerin','2463926427','tpickerin17@amazon.co.uk','oN7<!oANJFR/P|&WXP9_xf)pL7!vv*BbJ','2024-06-01 05:00:00','2025-01-06 20:47:28',3,1),(38,'617308888-6','Elysee','Braikenridge','8578509890','ebraikenridge18@homestead.com','vH3*pI(yL%~J{=>_1oamV!)|','2024-05-23 05:00:00','2025-01-06 20:44:35',3,1),(39,'272462751-2','Lizette','Grogan','1011805282','lgrogan19@berkeley.edu','zO1\"T/Lm\"z2>kmv(+','2024-06-14 05:00:00','2025-01-06 20:47:28',3,1),(40,'019594414-3','Farlie','Bear','2305513011','fbear1a@example.com','xE2<BhjQDyPB6.oF`QS24)<I%OW}J+','2024-05-12 05:00:00','2025-01-06 20:47:28',3,1),(41,'859089577-7','Katherina','McCabe','9133178358','kmccabe1b@toplist.cz','hX0<&UdChWc)#1MFqLgZPRHvhGM}w','2024-10-18 05:00:00','2024-05-12 05:00:00',3,1),(42,'517571228-4','Doralia','Pluthero','4905829299','dpluthero1c@state.gov','kX7.!(LGouXs#jMK60kTx','2024-06-12 05:00:00','2025-01-06 20:47:28',3,1),(43,'836419444-5','Heinrick','Denkel','9463538868','hdenkel1d@whitehouse.gov','uI4>.b4@Ia_)+3Z3,h1Q#hU.)DZw+=WD}Mn_','2024-11-11 05:00:00','2025-01-06 20:44:35',3,1),(44,'187888336-4','Mitchell','Brazenor','5304971118','mbrazenor1e@timesonline.co.uk','dX5~lpj@qa\'\"FpDV8PyBw`uyyap@.I`_','2024-07-15 05:00:00','2025-01-06 20:47:28',3,1),(45,'121929827-1','Dorris','Lampart','1797102456','dlampart1f@boston.com','wR6Ymzr1K6CK/omWD1=d2NWokbf&C</','2024-07-12 05:00:00','2024-04-26 05:00:00',3,1),(46,'298091066-X','Kristofer','Dansey','1689470045','kdansey1g@vk.com','dW3\"8*>sjp8kH_sdS=IprTB<%O9L?ILo7C\"','2024-08-06 05:00:00','2024-06-13 05:00:00',3,1),(47,'641726616-8','Theadora','Thorington','3171005471','tthorington1h@goo.ne.jp','dY3\'6_#A~)#E_\'G1J%&L&TnhQlH','2024-05-02 05:00:00','2024-07-27 05:00:00',3,1),(48,'316278101-9','Dulce','Abela','8686356128','dabela1i@spiegel.de','vR0+a~qa7T4>pnxqjU/{aE|m!tCCe0*p_','2024-04-29 05:00:00','2025-01-06 20:47:28',3,1),(49,'223611302-1','Dylan','Di Biasi','3561929646','ddibiasi1j@yellowpages.com','xX4|iJ#5Q/O/>OL`zTv','2024-04-17 05:00:00','2025-01-06 20:44:35',3,1),(50,'168460915-1','Lonnie','McVeigh','8106128713','lmcveigh1k@jugem.jp','gK2#3GER6ys|2>T%aYceH.','2024-07-12 05:00:00','2024-11-14 05:00:00',3,1),(51,'326133678-1','Ddene','Carpe','7243472071','dcarpe1l@upenn.edu','dZ6%|?sX3~$gbSTsB}m.bj','2024-07-17 05:00:00','2025-01-06 20:47:28',3,1),(52,'674372412-2','Sebastien','Axel','1977041131','saxel1m@amazonaws.com','mT9\"~,F&o}4Kn!bHXFv/SE','2024-06-02 05:00:00','2025-01-06 20:47:28',3,1),(53,'806943151-2','Dale','Ennew','5212086560','dennew1n@360.cn','gE6)uFG==%zFd|HY|}Q2#xsq2cXp','2024-08-21 05:00:00','2024-03-09 05:00:00',3,1),(54,'382522047-8','Clayborn','Cullagh','6272678611','ccullagh1o@lycos.com','gE3#3Nhg6otq1qmx$pLxR$45I','2024-11-10 05:00:00','2025-01-06 20:44:35',3,1),(55,'507331464-6','Karolina','Gyves','8089715578','kgyves1p@reuters.com','aA7%K>I~.<DP!zch\Z8s{_Twy5.QkO%','2024-09-06 05:00:00','2025-01-06 20:47:28',3,1),(56,'108732092-5','Abby','Neath','8789794343','aneath1q@meetup.com','lF6.yUoJ).H0AP#c#MRz','2024-09-04 05:00:00','2025-01-06 20:47:28',3,1),(57,'318848466-6','Jeremias','Choat','5028814666','jchoat1r@opensource.org','nM5(w35US`feJZzH_8b/UKN//i1Gr(','2024-07-07 05:00:00','2024-05-19 05:00:00',3,1),(58,'311271156-4','Fiann','Illsley','5965228332','fillsley1s@irs.gov','qG5}%$DHZS+9RQ*raSh2Bxwn+G3+0spB','2024-06-01 05:00:00','2025-01-06 20:44:35',3,1),(59,'915356915-6','Gavra','Sherwell','3083044334','gsherwell1t@imageshack.us','oC8<s`*bNj8`uT?5+c6M00NC4~{lhQQosU','2024-07-20 05:00:00','2025-01-06 20:44:35',3,1),(60,'150045416-8','Barth','Tonge','3208218058','btonge1u@shutterfly.com','fS4>@ET/<61>Q&YA2&8zg/{po&_dUo','2024-01-19 05:00:00','2024-11-19 05:00:00',3,1),(61,'248588198-7','Tansy','Dickenson','7434788297','tdickenson1v@blogtalkradio.com','aJ9>{+#3Q3~aJcoV?/H,K/Yn','2024-02-04 05:00:00','2025-01-06 20:47:28',3,1),(62,'036431951-8','Bryon','Steenson','1932335324','bsteenson1w@scientificamerican.com','gO964P{aR1*pwOn=Q`lMZE','2024-08-15 05:00:00','2025-01-06 20:47:28',3,1),(63,'506013448-2','Cheston','Saffe','3689221998','csaffe1x@homestead.com','yG1<f5ueHiQejO7~hn<ML0wUK%D<vT%}.C','2024-02-13 05:00:00','2025-01-06 20:44:35',3,1),(64,'627130290-4','Elka','Siley','9223751564','esiley1y@pagesperso-orange.fr','eU9_B~/\'hw<>B0.}vVe$+=%$#uZ','2024-08-20 05:00:00','2025-01-06 20:47:28',3,1),(65,'904909037-0','Brandi','Augar','9658171032','baugar1z@parallels.com','xU3A&LRZBAwT)1cI8yRL6~0r7BXX','2024-11-05 05:00:00','2025-01-06 20:44:35',3,1),(66,'471826595-9','Lurleen','Pobjoy','8059673447','lpobjoy20@ehow.com','aA7@vfnwo?}Snkb38b0(H(8KJ&6SSKIGN|','2024-06-14 05:00:00','2025-01-06 20:47:28',3,1),(67,'091178759-3','Tailor','Sargeant','4642571721','tsargeant21@domainmarket.com','sP7)l)jW{\"l9pv5NopUh','2024-09-13 05:00:00','2025-01-06 20:44:35',3,1),(68,'248256437-9','Penelopa','Eckels','7603457422','peckels22@cbsnews.com','cQ5}JoL3c$)Jh2p+0EkyG}aG%\"=D\'3/+','2024-10-28 05:00:00','2025-01-06 20:47:28',3,1),(69,'057682717-7','Philippe','Papierz','3614019101','ppapierz23@cafepress.com','pB2(i0!\"oeJjD@E(gk','2024-08-01 05:00:00','2025-01-06 20:44:35',3,1),(70,'985563294-X','Augusto','Thomke','4716079682','athomke24@51.la','mA8+o`NsJ0~@))T1Jc1kpz<Lk8\"','2024-01-07 05:00:00','2025-01-06 20:47:28',3,1),(71,'428512910-8','Colleen','Cran','4519109648','ccran25@ca.gov','nX1~hMh5tMnNScjsK4Wvxc8%!0`<(p','2024-11-26 05:00:00','2025-01-06 20:44:35',3,1),(72,'273684454-8','Linnell','Carl','5217229891','lcarl26@amazon.co.uk','gN9e7)WN)uM}z~K,DVC<5@)(','2024-10-15 05:00:00','2025-01-06 20:44:35',3,1),(73,'434359372-X','Dorolisa','Burkinshaw','9011765739','dburkinshaw2b@usgs.gov','oH4*q%X|a(<5|cqD)ekc1woH(0a','2024-07-19 05:00:00','2025-01-06 20:47:28',3,1),(74,'187601880-1','Aloisia','Drable','6848768102','adrable2c@google.cn','bQ6>HqWpPEb2C7@pi*8j|/Z\"mVw9@','2024-01-23 05:00:00','2025-01-06 20:47:28',3,1),(75,'980056778-X','Cos','Hagland','8535903126','chagland2d@sphinn.com','dN1\"H1NH@>EsrXQ\'6hi{r~<La=','2024-07-15 05:00:00','2025-01-06 20:47:28',3,1),(76,'352377261-3','Annabel','Rose','8915612314','arose2e@abc.net.au','eW6@HCvU66(Uq+(v#TovnAx','2024-09-28 05:00:00','2025-01-06 20:44:35',3,1),(77,'783848375-1','Anthia','Oxshott','1488623357','aoxshott2f@nationalgeographic.com','tS4\'9r>@q=pZd(tj4?upJsT2$D.H(tKojof<','2024-07-03 05:00:00','2025-01-06 20:47:28',3,1),(78,'654177158-8','Lilian','Caudelier','4458667966','lcaudelier2g@multiply.com','aH5?~/eNJ*B_oUiV&%&\'7_4=tKZ9|8','2024-07-12 05:00:00','2025-01-06 20:44:35',3,1),(79,'786362276-X','Ardine','Newbatt','4812345563','anewbatt2h@elpais.com','wC1Im_7fxO<Ucy,RgFEr_nQ+KphJm','2024-05-25 05:00:00','2025-01-06 20:47:28',3,1),(80,'963756338-5','Hurley','McNiff','1377077032','hmcniff2i@reddit.com','lX8=Zp$5gc$qurW|MPFSdS+DFi$zP&>','2024-03-24 05:00:00','2024-12-22 05:00:00',3,1),(81,'666486451-7','Karen','Collidge','7221421278','kcollidge2j@odnoklassniki.ru','pF9(xhm<DXs>OKrcN~mV7s%zcwA6','2024-03-23 05:00:00','2025-01-06 20:47:28',3,1),(82,'180521576-0','Osbourn','Neary','7945935719','oneary2k@google.de','kL8&k*9QC$z@)t,9`8Mr*YxBC3','2024-09-20 05:00:00','2025-01-06 20:47:28',3,1),(83,'008444241-7','Aura','Steinhammer','6826738784','asteinhammer2l@mozilla.com','eI0?GW|H6$\"MDPLTAnp3MHX0LA\'(PmluP/','2024-10-23 05:00:00','2025-01-06 20:47:28',3,1),(85,'248732122-9','Artie','Harries','5942841879','aharries2n@uol.com.br','oU2~qIg7!|v|+n|1\'s%','2024-04-08 05:00:00','2024-04-12 05:00:00',3,1),(86,'596789937-5','Rodrique','Fidal','6677131361','rfidal2o@shutterfly.com','pass1234','2024-04-09 05:00:00','2025-01-23 06:17:33',3,1),(87,'347836927-4','Efrem','McLenaghan','3915290360','emclenaghan2p@flavors.me','pJ2&05VbuNRAA_pf!0W','2024-09-28 05:00:00','2025-01-06 20:47:28',3,1),(88,'405119226-1','Nessy','Jakubovits','6275322429','njakubovits2q@msn.com','dW7//N)8=f)1bo+(O#NAv,Gcg%RQ<kQlT','2024-07-05 05:00:00','2025-01-06 20:47:28',3,1),(89,'435378940-6','Langsdon','Carvil','5908590793','lcarvil2r@thetimes.co.uk','kM3#v(G{8LO8\"}=#!\">a','2024-12-30 05:00:00','2025-01-06 20:47:28',3,1),(90,'354426','Nisbeth Maria','Suarez Mata','555555555','nisbethsuarez@gmail.com','exito.2015','2025-01-19 07:47:48','2025-01-23 06:07:11',1,1),(92,'35555555','Nisbeth','Mata','444444444','nisbethjob@gmail.com','exito2030','2025-01-19 08:30:07','2025-01-19 08:30:07',3,1),(94,'1034310428','Ruben','Suarez','5555555555','ruben@gmail.com','pass1234','2025-01-23 06:39:22','2025-01-23 06:39:22',1,1),(96,'2222222222','Maya','Suarez','88888888','maya@gmail.com','pass1234','2025-01-23 06:42:55','2025-01-23 06:42:55',1,1),(97,'252525','Romeo','Nata','777777777','romeo@gmail.com','pass1234','2025-01-23 06:45:35','2025-01-23 06:45:35',1,1),(100,'24242424','Kiaro','Mata','56565656','kiaro@gmai.com','pas1234','2025-01-23 07:16:02','2025-01-23 07:16:02',3,1),(101,'355135','Leonardo Augusto','Suarez Mata ','3186554203','leonardo@gmail.com','Leo1234','2025-03-05 05:50:53','2025-03-05 05:50:53',3,1);
/*!40000 ALTER TABLE `tbusuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipovehiculo`
--

DROP TABLE IF EXISTS `tipovehiculo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipovehiculo` (
  `id_tipo` int unsigned NOT NULL AUTO_INCREMENT,
  `vehiculo` varchar(20) NOT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipovehiculo`
--

LOCK TABLES `tipovehiculo` WRITE;
/*!40000 ALTER TABLE `tipovehiculo` DISABLE KEYS */;
INSERT INTO `tipovehiculo` VALUES (1,'Carro'),(2,'Moto'),(3,'Bicicleta');
/*!40000 ALTER TABLE `tipovehiculo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehiculo`
--

DROP TABLE IF EXISTS `vehiculo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehiculo` (
  `id_vehiculo` bigint unsigned NOT NULL AUTO_INCREMENT,
  `placa` varchar(12) NOT NULL,
  `marca` varchar(20) NOT NULL,
  `modelo` varchar(20) NOT NULL,
  `color` varchar(20) NOT NULL,
  `idusuario` bigint unsigned NOT NULL,
  `id_tipovehiculo` int unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_vehiculo`),
  UNIQUE KEY `placa` (`placa`),
  KEY `tbusuarios_fkey` (`idusuario`),
  KEY `tbtipovehiculo_fkey` (`id_tipovehiculo`),
  CONSTRAINT `tbtipovehiculo_fkey` FOREIGN KEY (`id_tipovehiculo`) REFERENCES `tipovehiculo` (`id_tipo`),
  CONSTRAINT `tbusuarios_fkey` FOREIGN KEY (`idusuario`) REFERENCES `tbusuarios` (`ID_USUARIO`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehiculo`
--

LOCK TABLES `vehiculo` WRITE;
/*!40000 ALTER TABLE `vehiculo` DISABLE KEYS */;
INSERT INTO `vehiculo` VALUES (1,'XXX1974','FORD','Nueva Bronco','negra',90,1,'2025-01-26 07:36:06','2025-02-03 20:22:12'),(2,'xx2222','Zuzuqui','Vespa','negra',90,2,'2025-01-31 06:52:16','2025-01-31 06:52:16');
/*!40000 ALTER TABLE `vehiculo` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-12 21:21:47
