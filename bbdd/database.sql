-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para appdielmo
CREATE DATABASE IF NOT EXISTS `appdielmo` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `appdielmo`;

-- Volcando estructura para tabla appdielmo.acabado
CREATE TABLE IF NOT EXISTS `acabado` (
  `id_acabado` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) NOT NULL,
  `id_serie` int NOT NULL,
  `imagen` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id_acabado`),
  KEY `id_serie` (`id_serie`),
  CONSTRAINT `id_serie` FOREIGN KEY (`id_serie`) REFERENCES `serie` (`id_serie`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla appdielmo.acabado: ~0 rows (aproximadamente)
INSERT INTO `acabado` (`id_acabado`, `nombre`, `id_serie`, `imagen`) VALUES
	(1, 'BLANCO POLAR', 1, NULL);

-- Volcando estructura para tabla appdielmo.articulos
CREATE TABLE IF NOT EXISTS `articulos` (
  `id_articulo` int NOT NULL AUTO_INCREMENT,
  `funcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(10,2) NOT NULL DEFAULT '0.00',
  `referencia` varchar(50) NOT NULL,
  `id_serie` int NOT NULL,
  PRIMARY KEY (`id_articulo`) USING BTREE,
  KEY `FK_articulos_serie` (`id_serie`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla appdielmo.articulos: ~0 rows (aproximadamente)
INSERT INTO `articulos` (`id_articulo`, `funcion`, `descripcion`, `precio`, `referencia`, `id_serie`) VALUES
	(1, 'Interruptor', 'Interruptor Unipolar 16A', 6.33, '18505', 1);

-- Volcando estructura para tabla appdielmo.articulos_presupuesto
CREATE TABLE IF NOT EXISTS `articulos_presupuesto` (
  `id_articulo_presupuesto` int NOT NULL AUTO_INCREMENT,
  `id_presupuesto` int NOT NULL,
  `id_articulo` int NOT NULL,
  `cantidad` int NOT NULL,
  `precio_unidad` decimal(20,6) NOT NULL,
  `precio_total` decimal(20,6) NOT NULL,
  `descuento` decimal(20,6) NOT NULL,
  PRIMARY KEY (`id_articulo_presupuesto`),
  KEY `FK__presupuestos` (`id_presupuesto`),
  KEY `FK__articulos_presupuestos` (`id_articulo`),
  CONSTRAINT `FK__articulos_presupuestos` FOREIGN KEY (`id_articulo`) REFERENCES `articulos` (`id_articulo`),
  CONSTRAINT `FK__presupuestos` FOREIGN KEY (`id_presupuesto`) REFERENCES `presupuestos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla appdielmo.articulos_presupuesto: ~0 rows (aproximadamente)

-- Volcando estructura para tabla appdielmo.articulo_relacionado
CREATE TABLE IF NOT EXISTS `articulo_relacionado` (
  `id_relacion` int NOT NULL AUTO_INCREMENT,
  `id_articulo` int NOT NULL,
  `descripcion` varchar(250) NOT NULL,
  `precio` decimal(20,6) NOT NULL DEFAULT '0.000000',
  `id_acabado` int NOT NULL,
  PRIMARY KEY (`id_relacion`),
  KEY `FK__articulos` (`id_articulo`),
  KEY `FK_articulo_relacionado_acabado` (`id_acabado`),
  CONSTRAINT `FK__articulos` FOREIGN KEY (`id_articulo`) REFERENCES `articulos` (`id_articulo`),
  CONSTRAINT `FK_articulo_relacionado_acabado` FOREIGN KEY (`id_acabado`) REFERENCES `acabado` (`id_acabado`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla appdielmo.articulo_relacionado: ~0 rows (aproximadamente)
INSERT INTO `articulo_relacionado` (`id_relacion`, `id_articulo`, `descripcion`, `precio`, `id_acabado`) VALUES
	(1, 1, 'IRIS, Tecla Interr./Conm./Cruzamiento', 3.930000, 1);

-- Volcando estructura para tabla appdielmo.fabricantes
CREATE TABLE IF NOT EXISTS `fabricantes` (
  `id_fabricante` int NOT NULL AUTO_INCREMENT,
  `nombre_fabricante` varchar(150) NOT NULL,
  PRIMARY KEY (`id_fabricante`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla appdielmo.fabricantes: ~0 rows (aproximadamente)
INSERT INTO `fabricantes` (`id_fabricante`, `nombre_fabricante`) VALUES
	(1, 'BJC');

-- Volcando estructura para tabla appdielmo.presupuestos
CREATE TABLE IF NOT EXISTS `presupuestos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `empresa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `npresupuesto` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `realizado` varchar(150) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `nombre_cliente` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `poblacion` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefono` int DEFAULT NULL,
  `proyecto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla appdielmo.presupuestos: ~0 rows (aproximadamente)

-- Volcando estructura para tabla appdielmo.serie
CREATE TABLE IF NOT EXISTS `serie` (
  `id_serie` int NOT NULL AUTO_INCREMENT,
  `nombre_serie` varchar(250) NOT NULL,
  `id_fabricante` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_serie`),
  KEY `id_fabricante` (`id_fabricante`),
  CONSTRAINT `id_fabricante` FOREIGN KEY (`id_fabricante`) REFERENCES `fabricantes` (`id_fabricante`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla appdielmo.serie: ~0 rows (aproximadamente)
INSERT INTO `serie` (`id_serie`, `nombre_serie`, `id_fabricante`) VALUES
	(1, 'IRIS', 1),
	(2, 'IRIS ESTANCA', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
