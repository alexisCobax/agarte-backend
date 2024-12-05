-- MySQL dump 10.13  Distrib 8.0.36, for Linux (x86_64)
--
-- Host: localhost    Database: agarte
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
-- Table structure for table `accesos`
--

DROP TABLE IF EXISTS `accesos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accesos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rol` int DEFAULT NULL,
  `seccion` varchar(45) DEFAULT NULL,
  `tipo_permiso` int DEFAULT NULL COMMENT '0: sin permiso, 1:lectura, 2:lectura-escritura',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accesos`
--

LOCK TABLES `accesos` WRITE;
/*!40000 ALTER TABLE `accesos` DISABLE KEYS */;
INSERT INTO `accesos` VALUES (1,1,'1',NULL),(2,1,'2',NULL),(3,1,'3',NULL);
/*!40000 ALTER TABLE `accesos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `domicilio` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_localidad` int NOT NULL,
  `email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_tipo_documento` int NOT NULL,
  `documento` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_condicion_iva` int NOT NULL,
  `fecha_alta` date NOT NULL,
  `creado_por` int NOT NULL,
  `modificado_por` int NOT NULL,
  `fecha_baja` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empleados`
--

DROP TABLE IF EXISTS `empleados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empleados` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_sucursal` int NOT NULL,
  `id_usuario` int NOT NULL,
  `suspendido` bit(1) NOT NULL,
  `fecha_alta` date NOT NULL,
  `creado_por` int NOT NULL,
  `modificado_por` int NOT NULL,
  `fecha_baja` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleados`
--

LOCK TABLES `empleados` WRITE;
/*!40000 ALTER TABLE `empleados` DISABLE KEYS */;
/*!40000 ALTER TABLE `empleados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estados_orden_trabajo`
--

DROP TABLE IF EXISTS `estados_orden_trabajo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estados_orden_trabajo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estados_orden_trabajo`
--

LOCK TABLES `estados_orden_trabajo` WRITE;
/*!40000 ALTER TABLE `estados_orden_trabajo` DISABLE KEYS */;
/*!40000 ALTER TABLE `estados_orden_trabajo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orden_de_trabajo`
--

DROP TABLE IF EXISTS `orden_de_trabajo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orden_de_trabajo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_sucursal` int NOT NULL,
  `facha` date NOT NULL,
  `id_cliente` int NOT NULL,
  `id_estado` int NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `id_vendedor` int NOT NULL,
  `id_tipo_enmarcacion` int NOT NULL,
  `id_tipo_viidrio` int NOT NULL,
  `comentarios` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_estipulada` date NOT NULL,
  `seña` decimal(10,2) NOT NULL,
  `fecha_entrega` date NOT NULL,
  `creado_por` int NOT NULL,
  `modificado_por` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orden_de_trabajo`
--

LOCK TABLES `orden_de_trabajo` WRITE;
/*!40000 ALTER TABLE `orden_de_trabajo` DISABLE KEYS */;
/*!40000 ALTER TABLE `orden_de_trabajo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orden_de_trabajo_detalles`
--

DROP TABLE IF EXISTS `orden_de_trabajo_detalles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orden_de_trabajo_detalles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_orden_de_trabajo` int NOT NULL,
  `id_producto` int NOT NULL,
  `cantidad` int NOT NULL,
  `posicion` int NOT NULL,
  `comentarios` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orden_de_trabajo_detalles`
--

LOCK TABLES `orden_de_trabajo_detalles` WRITE;
/*!40000 ALTER TABLE `orden_de_trabajo_detalles` DISABLE KEYS */;
/*!40000 ALTER TABLE `orden_de_trabajo_detalles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `presupuestos`
--

DROP TABLE IF EXISTS `presupuestos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `presupuestos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_sucursal` int NOT NULL,
  `facha` date NOT NULL,
  `id_cliente` int NOT NULL,
  `id_estado` int NOT NULL,
  `total` decimal(10,0) NOT NULL,
  `id_vendedor` int NOT NULL,
  `id_tipo_enmarcacion` int NOT NULL,
  `id_tipo_viidrio` int NOT NULL,
  `comentarios` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `creado_por` int NOT NULL,
  `modificado_por` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `presupuestos`
--

LOCK TABLES `presupuestos` WRITE;
/*!40000 ALTER TABLE `presupuestos` DISABLE KEYS */;
/*!40000 ALTER TABLE `presupuestos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `presupuestos_detalle`
--

DROP TABLE IF EXISTS `presupuestos_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `presupuestos_detalle` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_presupuesto` int NOT NULL,
  `id_producto` int NOT NULL,
  `cantidad` int NOT NULL,
  `posicion` int NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `observaciones` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `presupuestos_detalle`
--

LOCK TABLES `presupuestos_detalle` WRITE;
/*!40000 ALTER TABLE `presupuestos_detalle` DISABLE KEYS */;
/*!40000 ALTER TABLE `presupuestos_detalle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` int NOT NULL,
  `suspendido` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recibos`
--

DROP TABLE IF EXISTS `recibos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recibos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int NOT NULL,
  `fecha` date NOT NULL,
  `total` int NOT NULL,
  `id_orden_de_trabajo` int NOT NULL,
  `id_forma_de_pago` int NOT NULL,
  `suspendido` tinyint(1) NOT NULL,
  `cargado_por` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recibos`
--

LOCK TABLES `recibos` WRITE;
/*!40000 ALTER TABLE `recibos` DISABLE KEYS */;
/*!40000 ALTER TABLE `recibos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','1'),(2,'vendedor','1');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `secciones`
--

DROP TABLE IF EXISTS `secciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `secciones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `tag` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `estado` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `secciones`
--

LOCK TABLES `secciones` WRITE;
/*!40000 ALTER TABLE `secciones` DISABLE KEYS */;
INSERT INTO `secciones` VALUES (1,'pagina_home','Inicio',1),(2,'pagina_sucursales','Sucursales',1),(3,'pagina_sucursalesABM',NULL,1);
/*!40000 ALTER TABLE `secciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sucursales`
--

DROP TABLE IF EXISTS `sucursales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sucursales` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `domicilio` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suspendido` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sucursales`
--

LOCK TABLES `sucursales` WRITE;
/*!40000 ALTER TABLE `sucursales` DISABLE KEYS */;
INSERT INTO `sucursales` VALUES (1,'sucursal 1',NULL,'calle 1','11111111111',0),(2,'sucursal 2','','calle 456','7890123',0),(3,'sucursal 5','','calle 4','55555',0),(4,'sucursal 5','','calle 5','55555',0),(5,'sucursal 5','','calle 5','55555',0),(6,'sucursal 5','','calle 5','55555',0),(7,'sucursal 5','','calle 5','55555',0),(8,'sucursal 5','','calle 5','55555',0),(9,'sucursal 5','','calle 5','55555',0),(10,'sucursal 5','','calle 5','555553',0),(11,'sucursal 5','','calle 5','55555',0),(16,'sucursal 12 ',NULL,'calle 12','1212133322',0),(18,'sucursal 5','','calle 5','55555',0),(19,'sucursal 5','','calle 5','55555',0),(20,'sucursal 5','','calle 5','55555',0),(21,'asd',NULL,'sad','123',0),(22,'sucursal 5','sda','calle 5','232',0),(23,'asd',NULL,'sad','1232132',0),(24,'sucursal 5','sda','calle 5','232',0),(25,'sucursal 5','sda','calle 5','232',0),(26,'sucursal 5','','calle 222','44444444',0),(27,'sucursal 4','','calle 111','44444444',0),(28,'asads',NULL,'asdsad','123213',0),(29,'ssssssssss',NULL,'dddddd','111',0);
/*!40000 ALTER TABLE `sucursales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `clave` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rol` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (12,'admin@admin.com','$2y$10$yajzocTOWqX/HtOj4uU29uBugWf3BG98.rnwN4QanBnNOnXZ0iZG6','1','eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ5b3VyLWFwcCIsImlhdCI6MTczMTc1NjY5NCwiZXhwIjoxNzMxNzYwMjk0LCJzdWIiOjEyfQ.J6wVR8VyoVY2GKL45eo4qLrwJb1sF4ohhtbd2m74DsM'),(13,'cliente@cliente.com','$2y$10$5IKfqGG.lqh7AQcnIBTfvuWNlZd1JEALA16DRuSjle.cHyXd2f2cO','2','eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ5b3VyLWFwcCIsImlhdCI6MTczMTQyNTMwOSwiZXhwIjoxNzMxNDI4OTA5LCJzdWIiOjEzfQ.TAlGnGdsk1gsqd4qmbrLZG-aguoidqLdeF9A7uiZaMo');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-19 15:49:04
