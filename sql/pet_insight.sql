-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: pet_insight
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cliente` (
  `id_cliente` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL,
  `email` varchar(90) NOT NULL,
  `datNasc` date NOT NULL,
  `telefone` varchar(11) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (1,'leh','leh@gmail.com','2019-01-01','11111111111',NULL),(2,'le','le@gmail.com','2019-01-01','12344444444',NULL),(3,'leh1','ledelde@gmail.com','2019-01-01','11111111111',NULL);
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `endereco`
--

DROP TABLE IF EXISTS `endereco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `endereco` (
  `id_endereco` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int NOT NULL,
  `id_funcionario` int DEFAULT NULL,
  `cep` varchar(9) NOT NULL,
  `rua` varchar(60) NOT NULL,
  `bairro` varchar(60) NOT NULL,
  `cidade` varchar(20) NOT NULL,
  `complemento` varchar(60) DEFAULT NULL,
  `numero` int DEFAULT NULL,
  PRIMARY KEY (`id_endereco`),
  KEY `fk_endereco_01` (`id_cliente`),
  CONSTRAINT `endereco_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  CONSTRAINT `fk_endereco_01` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `endereco`
--

LOCK TABLES `endereco` WRITE;
/*!40000 ALTER TABLE `endereco` DISABLE KEYS */;
/*!40000 ALTER TABLE `endereco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formapagamento`
--

DROP TABLE IF EXISTS `formapagamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `formapagamento` (
  `id_formaPagamento` int NOT NULL AUTO_INCREMENT,
  `id_pedido` int NOT NULL,
  `tipo` enum('Pix','Cartão de crédito','Boleto bancário') NOT NULL,
  PRIMARY KEY (`id_formaPagamento`),
  KEY `fk_formaPagamento_01` (`id_pedido`),
  CONSTRAINT `fk_formaPagamento_01` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`) ON DELETE CASCADE,
  CONSTRAINT `formapagamento_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formapagamento`
--

LOCK TABLES `formapagamento` WRITE;
/*!40000 ALTER TABLE `formapagamento` DISABLE KEYS */;
/*!40000 ALTER TABLE `formapagamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `funcionario`
--

DROP TABLE IF EXISTS `funcionario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `funcionario` (
  `id_funcionario` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) DEFAULT NULL,
  `email` varchar(90) NOT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `datNasc` date NOT NULL,
  `telefone` varchar(11) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_funcionario`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `email_unico` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `funcionario`
--

LOCK TABLES `funcionario` WRITE;
/*!40000 ALTER TABLE `funcionario` DISABLE KEYS */;
INSERT INTO `funcionario` VALUES (1,'Admin','admin@petinsight.com','admin','1997-09-23','11999999999',NULL);
/*!40000 ALTER TABLE `funcionario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imagem_produto`
--

DROP TABLE IF EXISTS `imagem_produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imagem_produto` (
  `id_imagens` int NOT NULL AUTO_INCREMENT,
  `id_produto` int DEFAULT NULL,
  `nome_imagem` text NOT NULL,
  PRIMARY KEY (`id_imagens`),
  KEY `id_produto` (`id_produto`),
  CONSTRAINT `imagem_produto_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagem_produto`
--

LOCK TABLES `imagem_produto` WRITE;
/*!40000 ALTER TABLE `imagem_produto` DISABLE KEYS */;
INSERT INTO `imagem_produto` VALUES (1,1,'uploads/imgProdutos/1/682e6ea6a22db.jpg'),(2,2,'uploads/imgProdutos/2/682e6efd6ed4b.jpg'),(3,3,'uploads/imgProdutos/3/682e6f36eba69.jpg'),(4,4,'uploads/imgProdutos/4/682e6fa046e9b.jpg'),(14,8,'uploads/imgProdutos/8/682e73ddb75fd.png'),(15,8,'uploads/imgProdutos/8/682e73ddb8b37.png'),(16,8,'uploads/imgProdutos/8/682e73ddb9aa5.png'),(17,9,'uploads/imgProdutos/9/682e7476b99a0.png'),(18,9,'uploads/imgProdutos/9/682e7476babd0.png'),(19,9,'uploads/imgProdutos/9/682e7476bbc4c.png'),(20,10,'uploads/imgProdutos/10/682e754f5073d.jpg'),(21,10,'uploads/imgProdutos/10/682e754f517d4.jpg'),(22,10,'uploads/imgProdutos/10/682e754f533b4.jpg'),(23,11,'uploads/imgProdutos/11/682e75bbf1b64.jpg'),(24,12,'uploads/imgProdutos/12/682e761345f44.png'),(25,12,'uploads/imgProdutos/12/682e761346d76.png'),(26,12,'uploads/imgProdutos/12/682e76134889d.png'),(27,13,'uploads/imgProdutos/13/682e76b3393b3.png'),(28,14,'uploads/imgProdutos/14/682e77057be50.jpeg'),(29,14,'uploads/imgProdutos/14/682e77057df51.jpeg'),(30,14,'uploads/imgProdutos/14/682e77057f9c6.jpeg'),(31,15,'uploads/imgProdutos/15/682e78077d0c7.png'),(32,15,'uploads/imgProdutos/15/682e78077f054.png'),(33,15,'uploads/imgProdutos/15/682e780780c49.png'),(34,16,'uploads/imgProdutos/16/682e7871106f2.png'),(35,16,'uploads/imgProdutos/16/682e787112fb1.png'),(36,16,'uploads/imgProdutos/16/682e78711440a.png'),(37,17,'uploads/imgProdutos/17/682e78c2cb72e.jpeg'),(38,18,'uploads/imgProdutos/18/682e7906c8add.png'),(39,18,'uploads/imgProdutos/18/682e7906ca683.png'),(40,18,'uploads/imgProdutos/18/682e7906cccee.png'),(41,19,'uploads/imgProdutos/19/682e793f47ec1.png'),(42,19,'uploads/imgProdutos/19/682e793f49b15.png'),(43,19,'uploads/imgProdutos/19/682e793f4bfdd.png'),(44,20,'uploads/imgProdutos/20/682f42114e3d9.jpeg'),(45,20,'uploads/imgProdutos/20/682f42114f00f.jpeg'),(46,20,'uploads/imgProdutos/20/682f421150f62.jpeg'),(47,21,'uploads/imgProdutos/21/682f427871112.jpeg'),(48,21,'uploads/imgProdutos/21/682f427872156.jpeg'),(49,21,'uploads/imgProdutos/21/682f427872af5.jpeg'),(50,22,'uploads/imgProdutos/22/682f437157c13.png'),(51,22,'uploads/imgProdutos/22/682f437158836.png'),(52,22,'uploads/imgProdutos/22/682f43715953e.png'),(53,23,'uploads/imgProdutos/23/682f43e958b94.png'),(54,23,'uploads/imgProdutos/23/682f43e95a5c1.png'),(55,23,'uploads/imgProdutos/23/682f43e95af57.png'),(56,24,'uploads/imgProdutos/24/682f4540d0e44.png'),(57,24,'uploads/imgProdutos/24/682f4540d1b78.png'),(58,24,'uploads/imgProdutos/24/682f4540d3259.png'),(59,25,'uploads/imgProdutos/25/682f464d617a9.jpeg'),(60,25,'uploads/imgProdutos/25/682f464d62471.jpeg'),(61,25,'uploads/imgProdutos/25/682f464d6323a.jpeg'),(62,26,'uploads/imgProdutos/26/682f46c530c07.jpg'),(63,26,'uploads/imgProdutos/26/682f46c531cce.jpg'),(64,26,'uploads/imgProdutos/26/682f46c5325cf.jpg'),(65,27,'uploads/imgProdutos/27/682f471ac8038.png'),(66,27,'uploads/imgProdutos/27/682f471ac97f5.png'),(67,27,'uploads/imgProdutos/27/682f471aca9dc.png'),(68,28,'uploads/imgProdutos/28/682f580e4ef37.jpg'),(69,28,'uploads/imgProdutos/28/682f580e508b5.jpg'),(70,29,'uploads/imgProdutos/29/682f588f09054.png'),(71,30,'uploads/imgProdutos/30/682f58dc4c6ba.jpg'),(72,30,'uploads/imgProdutos/30/682f58dc4e64e.jpg'),(73,31,'uploads/imgProdutos/31/682f5948c2a45.jpg'),(74,31,'uploads/imgProdutos/31/682f5948c3cec.jpg'),(75,32,'uploads/imgProdutos/32/682f59e99b302.jpg'),(76,33,'uploads/imgProdutos/33/682f5a311ede9.jpg'),(77,33,'uploads/imgProdutos/33/682f5a312095e.jpg'),(78,34,'uploads/imgProdutos/34/682f5a854c893.jpg'),(79,34,'uploads/imgProdutos/34/682f5a854dd9a.jpg'),(80,35,'uploads/imgProdutos/35/682f5ba185bc7.jpg'),(81,35,'uploads/imgProdutos/35/682f5ba186c7d.jpg'),(82,36,'uploads/imgProdutos/36/682f5bd7b3bea.jpg'),(83,36,'uploads/imgProdutos/36/682f5bd7b4e3c.jpg'),(84,37,'uploads/imgProdutos/37/682f5cc002267.jpg'),(85,37,'uploads/imgProdutos/37/682f5cc003eb6.jpg'),(86,38,'uploads/imgProdutos/38/682f5dfbaa2d0.jpg'),(87,38,'uploads/imgProdutos/38/682f5dfbab329.jpg'),(88,39,'uploads/imgProdutos/39/682f5e53d6454.jpg'),(89,39,'uploads/imgProdutos/39/682f5e53d7bd7.jpg'),(90,40,'uploads/imgProdutos/40/682f5eb890aa5.jpg'),(91,41,'uploads/imgProdutos/41/682f5ee67a48e.jpg'),(92,42,'uploads/imgProdutos/42/682f5f417caf7.jpg'),(93,43,'uploads/imgProdutos/43/682f5f978b35f.jpg'),(94,44,'uploads/imgProdutos/44/682f617901327.png'),(95,45,'uploads/imgProdutos/45/682f623694170.png'),(96,46,'uploads/imgProdutos/46/682f6369b879e.jpg'),(97,47,'uploads/imgProdutos/47/682f6534783d8.jpg'),(98,48,'uploads/imgProdutos/48/682f6697a1c0a.jpeg'),(99,48,'uploads/imgProdutos/48/682f6697a2cbb.jpeg'),(100,48,'uploads/imgProdutos/48/682f6697a4178.jpeg'),(101,49,'uploads/imgProdutos/49/682f672e15e05.png'),(102,49,'uploads/imgProdutos/49/682f672e5a25b.png'),(103,49,'uploads/imgProdutos/49/682f672e8d0ed.png'),(104,50,'uploads/imgProdutos/50/682f6940e17e5.png'),(105,51,'uploads/imgProdutos/51/682f6b9621a26.jpg'),(106,51,'uploads/imgProdutos/51/682f6b9623352.jpg'),(107,51,'uploads/imgProdutos/51/682f6b96240d8.jpg'),(108,52,'uploads/imgProdutos/52/682f6c9e7236a.jpg'),(109,53,'uploads/imgProdutos/53/682f6d660c073.jpg');
/*!40000 ALTER TABLE `imagem_produto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itempedido`
--

DROP TABLE IF EXISTS `itempedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `itempedido` (
  `id_itemPedido` int NOT NULL AUTO_INCREMENT,
  `id_pedido` int NOT NULL,
  `id_produto` int NOT NULL,
  `quantidade` int NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_itemPedido`),
  KEY `fk_itemPedido_01` (`id_pedido`),
  KEY `fk_itemPedido_02` (`id_produto`),
  CONSTRAINT `fk_itemPedido_01` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`) ON DELETE CASCADE,
  CONSTRAINT `fk_itemPedido_02` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`) ON DELETE CASCADE,
  CONSTRAINT `itempedido_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`),
  CONSTRAINT `itempedido_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itempedido`
--

LOCK TABLES `itempedido` WRITE;
/*!40000 ALTER TABLE `itempedido` DISABLE KEYS */;
/*!40000 ALTER TABLE `itempedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido`
--

DROP TABLE IF EXISTS `pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedido` (
  `id_pedido` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int NOT NULL,
  `id_produto` int NOT NULL,
  `data_pedido` datetime NOT NULL,
  `total` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id_pedido`),
  KEY `fk_pedido_01` (`id_cliente`),
  KEY `fk_pedido_02` (`id_produto`),
  CONSTRAINT `fk_pedido_01` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE,
  CONSTRAINT `fk_pedido_02` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`) ON DELETE CASCADE,
  CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido`
--

LOCK TABLES `pedido` WRITE;
/*!40000 ALTER TABLE `pedido` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produto`
--

DROP TABLE IF EXISTS `produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produto` (
  `id_produto` int NOT NULL AUTO_INCREMENT,
  `nome_produto` varchar(100) NOT NULL,
  `tipo` enum('Rações','Aperitivos','Higiene','Brinquedos','Coleiras') NOT NULL,
  `descricaoMenor` varchar(200) NOT NULL,
  `descricaoMaior` varchar(500) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `quantidade` int NOT NULL,
  `marca` varchar(30) NOT NULL,
  PRIMARY KEY (`id_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produto`
--

LOCK TABLES `produto` WRITE;
/*!40000 ALTER TABLE `produto` DISABLE KEYS */;
INSERT INTO `produto` VALUES (1,'Shampoo Beeps Filhotes para Cães e Gatos 500ml','Higiene','Indicado para cães e gatos com idade superior a 4 semanas.','Produto concentrado, promove limpeza da pele e pelagem de forma eficaz e fácil enxague. Contém proteína do leite e isento de sal.',32.79,23,'Beeps'),(2,'Condicionador Beeps Hidratante para Cães e Gatos 480ml','Higiene','Indicado para cães e gatos com idade superior a 4 semanas.','Produto concentrado, condiciona e hidrata a pelagem e fácil enxague. Contém manteiga de karité e isento de sal.',33.59,45,'Beeps'),(3,'Colônia Beeps Blueberry para Cães e Gatos 60ml','Higiene','Indicado para cães e gatos.','Reduz os odores naturais sem prejudicar a pele do pet.',22.39,48,'Beeps'),(4,'Tapete Higiênico Beeps Puppy Pads para Cães 30 Unidades','Higiene','Indicado para cães.','Possui 5 camadas de proteção, tecnologia SAP ultra-absorvente, reduz odores, maior área de absorção, ranhuras para melhor despersão da urina e adesivo de alta fixação. Medida: Comprimento: 55,8cm / Largura: 55,8cm. Embalagem com 30 unidades.',64.90,52,'Beeps'),(8,'Porta Saquinhos Higiênicos','Higiene','Porta saquinhos higiênicos que já vem com refil com 15.','Possui clipe e corda com fecho, duas maneiras de prender na guia. Já vem com um refil de 15 saquinhos para coletar as necessidades do seu cachorro.',54.90,43,'Zee.Dog'),(9,'Refil de saquinhos higiênicos comportável Zee.dog','Higiene','O refil Zee.Dog de saquinhos higiênicos compostáveis possui 4 rolos com 15 saquinhos.','São compostáveis, ou seja, em seu processo de decomposição viram resíduo orgânico, sem deixar rastros de plástico no meio ambiente. E são à prova de vazamentos.',54.90,43,'Zee.Dog'),(10,'Tapete Higiênico Zee.Pad para Cães com 30 Unidades Branco Zee.Dog','Higiene','Indicado para cães.','Possui 6 camadas de proteção, absorve tudo ultra-rápido, possui atrativo canino natural, neutraliza odores, anti-bacteriano e com camada anti-rasgo.',117.99,39,'Zee.Dog'),(11,'Banho a Seco Beeps para Cães e Gatos 200ml','Higiene','Indicado para cães e gatos com idade superior de 4 semanas.','Neutraliza odores desagradáveis, facilita a escovação, auxilia na remoção de nós, proporciona brilho e maciez da pelagem.',38.69,100,'Beeps'),(12,'Brinquedo para Cachorros Alien Flex Bubu','Brinquedos','Ideal para cachorros de todo tipo de porte.','Pelúcia macia e resistente para cachorros de mordida leve, faz barulho ao apertar para satisfazer o instinto caçador do seu cachorro, diferentes texturas para manter o seu cachorro entretido.',99.00,88,'Zee.Dog'),(13,'Brinquedo para Cachorros Monsterz Blu','Brinquedos','Ideal para cachorros de porte médio a grande de mordida leve.','Pelúcia feita com costura reforçada, faz barulho ao apertar e diverte seu  pet.',99.00,99,'Zee.Dog'),(14,'Brinquedo para Cachorros Vynil Frisbee','Brinquedos','Indicado para cachorros de portes médio e grande de todas as idades.','É feito de borracha natural atóxica e macia, que não machuca durante a brincadeira. Por ser azul, é muito fácil de ser encontrado e o seu design foi pensado para facilitar na hora de lançar e pegar do chão.',99.00,57,'Zee.Dog'),(15,'Brinquedo de Nylon para Cachorros Tripod','Brinquedos','Indicado para cachorros de porte grande.','Feito 100% de nylon, com cheiro de bacon, perfeito para cães que gostam de roer, possui formato com fácil pega e superfície texturizada.',159.00,87,'Zee.Dog'),(16,'Brinquedo Zee.Dog Mr. X para Cães','Brinquedos','Indicado para cães de porte pequeno e médio, ideal para cães que gostam de roer.','Brinquedo de pelúcia com um esqueleto de borracha natural dentro, a pelúcia exterior possui reforço de trama mesh, esqueleto interno feito de borracha natural atóxica.',129.00,45,'Zee.Dog'),(17,'Pizza de Catnip Cansei de Ser Gato','Brinquedos','Indicado para gatos.','O produto é atóxico e 100% natural. Possui 2g de Catnip para acalmar gatos agitados e estimular gatos quietos.',44.99,38,'Cansei de ser gato'),(18,'Brinquedos para cachorro Rob The Microbe','Brinquedos','Indicado para cachorros de todo tipo de porte.','O produto é feito de borracha atóxica e possui textura diferenciada, ajuda a massagear a gengiva e contribui para a manutenção da saúde bucal. Possui cavidade para rechear com petiscos e por isso é ideal também para treinamento/recompensa e controle da ansiedade.',69.00,67,'Zee.Dog'),(19,'Brinquedo para Cachorros Alien Flex Ghim','Brinquedos','Indicado para cachorros de porte pequeno e médio.','Pelúcia macia e resistente para cachorros de mordida leve. Faz barulho ao apertar para satisfazer o instinto caçador do seu cachorro e diferentes texturas para manter o seu cachorro entretido.',99.00,240,'Zee.Dog'),(20,'Coleira para cachorros Glitch Error 500','Coleiras','Indicado para cães de porte pequeno.','Regulável, para melhor ajuste, fecho com\r\nsistema de segurança de 4 pontos, logo emborrachada da Zee.Dog, feita em material atóxico, textura macia e sedosa para dar mais conforto nos passeios, com caveira de borracha customizada da coleção Glitch.',79.00,55,'Zee.Dog'),(21,'Coleira Zee.Cat Marvel Pantera Negra para Gatos','Coleiras','Indicado para gatos, tamanho único com\r\nregulagem ajustável.','A coleira para gatos Pantera Negra da\r\nZee.Cat tem fecho breakway, que abre sozinho caso o gato se enrosque, além de ser totalmente regulável. É feito de poliséster, logo emborrachada da Zee.Cat, feita em material atóxico.',69.00,34,'Zee.Dog'),(22,'Coleira para Cachorros Neoprol Coral','Coleiras','Indicado para cães.','A coleira possui uma nova tecnologia com\r\nultra proteção externa de borracha de PVC chamada NeoPro, resistente à água e à ação do tempo, evitando que a coleira fique suja, molhada ou arranhada. Além de ser muito mais fácil de limpar, também possui fecho com sistema de segurança de quatro pontos e regulagem para ajustar bem no pescoço do seu cachorro.',79.00,56,'Zee.Dog'),(23,'Coleira para Cachorros Lola','Coleiras','Indicado para cães.','Segurança e resistência, feito de poliéster, mesmo material dos cintos de segurança, possui borracha de caveira da Zee.Dog, feita de material atóxico, textura macia\r\ne sedosa para maior conforto, fecho seguro com sistema de segurança de 4 pontos e regulável para melhor ajuste no\r\npescoço do seu cachorro.',79.00,33,'Zee.Dog'),(24,'Coleira Zee.Cat Skull 2.0 para Gatos','Coleiras','Indicado para gatos.','Tamanho único com regulagem ajustável, fecho que abre sozinho caso o gato se enrosque, super poliéster estampado com\r\ntecnologia heat-transfer teteron e feita em material atóxico.',59.00,32,'Zee.Dog'),(25,'Coleira para Cachorro Brain','Coleiras','Indicado para cachorros.','Regulável, para melhor ajuste no pescoço do seu\r\ncachorro. Fecho com sistema de segurança de 4 pontos, feita em material atóxico e textura macia e sedosa para maior conforto.',79.00,23,'Zee.Dog'),(26,'Coleira para Cachorro Jacquard Aura','Coleiras','Indicado para cachorros.','Regulável, para melhor ajuste no pescoço do seu\r\ncachorro. Fecho com sistema de segurança de 4 pontos, feita em material atóxico e textura macia e sedosa para maior conforto.',79.00,12,'Zee.Dog'),(27,'Coleira Zee.Cat Neopro Preto para Gatos','Coleiras','Indicado para gatos.','Possui tecnologia NeoPro, com ultra proteção resistente\r\nà água e à ação do tempo, muito fácil de limpar. Regulável, para melhor ajuste no pescoço do seu cachorro. Fecho com sistema de segurança de 4 pontos, feita em material atóxico e textura macia e sedosa para maior conforto.',69.00,78,'Zee.Dog'),(28,'Ração Whiskas para Gatos Adultos Sabor Frango','Rações','Indicado para gatos adultos.','Indicado para gatos partir de 1 ano de idade, sem corantes presentes, prebióticos que contribuem para a digestão saudável, múltiplas fibras para promover a saúde gastrointestinal, controle de minerais para manter\r\no trato urinário saudável, vitaminas e antioxidante que ajudam no sistema\r\nimunológico e ômega 6 e zinco para manter a pele e pelo saudáveis.',20.99,433,'Whiskas'),(29,'Ração Whiskas para Gatos Adultos Mix de Carnes','Rações','Indicado para gatos adultos.','Indicado para gatos partir de 1 ano de idade, sem corantes presentes, prebióticos que contribuem para a digestão saudável, múltiplas fibras para promover a saúde gastrointestinal, controle de minerais para manter\r\no trato urinário saudável, vitaminas e antioxidante que ajudam no sistema imunológico e ômega 6 e zinco para manter a pele e pelo saudáveis.',20.99,200,'Whiskas'),(30,'Ração Whiskas para Gatos Castrados Sabor Peixe','Rações','Indicado para gatos adultos castrados.','Ajuda a manter o peso ideal de gatos castrados. Sem\r\ncorantes presentes, prebióticos que contribuem para a digestão saudável, múltiplas fibras naturais que ajudam a eliminação de bolas de pelo e controle de minerais para manter o trato urinário saudável.',20.99,134,'Whiskas'),(31,'Ração Whiskas para Gatos Castrados Sabor Carne','Rações','Indicado para gatos adultos castrados.','Ajuda a manter o peso ideal de gatos castrados. Sem\r\ncorantes presentes, prebióticos que contribuem para a digestão saudável, múltiplas fibras naturais que ajudam a eliminação de bolas de pelo e controle de minerais para manter o trato urinário saudável.',20.99,430,'Whiskas'),(32,'Ração Golden Fórmula para Cães Filhotes Sabor Carne e Arroz','Rações','Indicado para cães filhotes.','Auxilia na saúde oral, redução da formação do tártaro e odor das fezes. Intestino saudável, combinação de nutrientes de alta digestibilidade e fibras naturais, crescimento saudável, deito com DHA e proteína de qualidade elevada.',58.89,344,'Golden'),(33,'Petisco Special Dog Snacks para Cães Sabor Frango','Aperitivos','Indicado para cachorros','Elaborado com carne de frango e matérias-primas\r\nselecionadas, sabor irresistível de frango e não contém corantes artificais.         Baixo teor de calorias e alta palatabilidade;',3.99,231,'Special Dog'),(34,'Petisco Whiskas Temptations Anti Bola de Pelo para Gatos Adultos','Aperitivos','Indicado para gatos adultos','Possui fibras que auxiliam na eliminação de bolas de pelo;',11.49,168,'Whiskas'),(35,'Sachê Whiskas para Gatos Adultos Sabor Frango ao Molho 85g','Rações','Ração úmida, indicado para gatos.','Refeição completa e balanceada, com ingredientes naturais de qualidade, vitaminas e minerais. Sem conservantes, corantes artificiais e aromatizantes artificiais. Ajuda a manter a saúde do trato urinário.',3.39,287,'Whiskas'),(36,'Sachê Whiskas para Gatos Adultos Sabor Carne ao Molho 85g','Rações','Ração úmida, indicado para gatos.','Refeição completa e balanceada, com ingredientes naturais\r\nde qualidade, vitaminas e minerais. Sem conservantes, corantes artificiais e aromatizantes artificiais. Ajuda a manter a saúde do trato urinário.',3.39,333,'Whiskas'),(37,'Ração Úmida Royal Canin Pedaços ao Molho Sahê para Gatos Adultos Castrados','Rações','Indicado para gatos castrados.','Ajuda a manter o peso ideal dos gatos castrados e previne\r\nproblemas no trato urinário.',9.90,25,'Royal Canin'),(38,'Ração Úmida GranPlus Gourmet Sachê para Cães Adultos Sabor Carne 100g','Rações','Indicado para cachorros adultos.','Alimento úmido 100% completo e balanceado, feito com\r\ndeliciosos pedacinhos cozidos ao vapor, não possui transgênicos, conservantes, aromas e corantes artificiais. Contribui para a saúde do pelo: com ômega 6, zinco e vitamina A;',3.19,234,'GranPlus'),(39,'Ração Úmida GranPlus Gourmet Sachê para Cães Adultos Sabor Frango 100g','Rações','Indicado para cachorros adultos.','Alimento úmido 100% completo e balanceado, feito com\r\ndeliciosos pedacinhos cozidos ao vapor, não possui transgênicos, conservantes, aromas e corantes artificiais. Contribui para a saúde do pelo: com ômega 6, zinco e vitamina A;',3.19,233,'GranPlus'),(40,'Alimento Nutrópica Coelho Adulto 1.2kg','Rações','Indicado para coelhos adultos','Alimento completo e balanceado, livre de transgênicos,\r\nproporciona mais saúde a logenvidade aos petse contém alfafa e vários tipos de grãos integrais como aveia, ervilha, linhaça e trigo;',89.99,48,'Nutrópica'),(41,'Alimento Nutrópica Hamster 300g','Rações','Indicado para Hamster.','Formulada com alfafa e vários tipos de grãos integrais como\r\naveia, trigo, linhaça e ervilha, proporciona equilíbrio dos ácidos graxos Ômega 3 e Ômega 6 e contribui para saúde e beleza da pele e da pelagem do seu pet;',32.99,32,'Nutrópica'),(42,'Alimento Nutrópica Porquinho da Índia 500g','Rações','Indicado para Porquinho da Índia.','Alimento extrusado completo, cientificamente formulado e especialmente desenvolvido, contém uma combinação exclusiva das mais nobres e saborosas matérias-primas. Preparada sob rigoroso controle de qualidade e com as melhores técnicas em produção de alimentos;',43.99,125,'Nutrópica'),(43,'Petisco Aves da Mata Biscotto Rodente Para Roedores 20g','Aperitivos','Indicado para roedores.','Biscoito saboroso e crocante, biscotto rodent tem vários\r\nformatos (maçã, morango, caju, milho, uva, cenoura, pêssego e folhinha) no tamanho ideal para que você possa adestrar, interagir, distrair e se divertir com a seu pet;',13.99,43,'Aves da Mata'),(44,'Cookie Premier para Cães Adultos 250g','Aperitivos','Indicado para cães adultos.','Sem transgênicos, corantes e aromatizantes artificiais;\r\nIngredientes naturais que cuida da saúde intestinal dos cães. Enriquecido com zinco e biotina. Auxilia na diminuição da formação de tártaro e colabora para deixar a pele e pelagem mais bonitas e saudáveis.\r\nEasy open - Embalagem com sistema abre e fecha.',18.90,112,'Premier'),(45,'Cookie Premier Cães Adultos Porte Pequeno Frutas Vermelhas e Aveia 250g','Aperitivos','Indicado para cachorros adultos de pequeno porte.','Auxilia na saúde oral, pele e pelagem e saúde intestinal. possui aveia e MOS. Sem ingredientes transgênicos, sem corantes e aromatizantes artificiais.',18.90,22,'Premier'),(46,'Ração Golden Formula Cães Adultos Frango e Arroz 3kg','Rações','Indicado para cães adultos','Pele nutrida e pelagem sedosa, intestino saudável e redução do odor das fezes. Sem corantes e aromatizantes artificiais e\r\nauxilia a redução da formação do tártaro.',58.90,211,'Golden'),(47,'Ração Golden Duii Cães Adultos Porte Pequeno Salmão e Cordeiro 3kg','Rações','Indicado para cães de pequeno porte.','Possui 2 sabores salmão e cordeiro indicada para cães adultos de pequeno porte. Ração premium especial, com sabores embalados individualmente que não causa complicações digestivas. - Não é necessário adaptação entre os sabores, atende de forma saudável aos paladares mais exigentes. Auxilia na saúde oral, pois evita o aparecimento de tártaros e mantém o intestino regular e saudável. Ajuda a reduzir o odor e o volume das fezes, além de manter uma pelagem mais bonita e saudável.',74.90,56,'Golden'),(48,'Guia com Amortecedor para Cachorros Brain','Coleiras','A guia com sua mola amortecedora absorve o impacto da puxada, aliviando a tensão no seu pulso e ombro.','Segurança e resistência: feito de poliéster, mesmo material dos cintos de segurança. Borracha de caveira da Zee.Dog, feita de material atóxico. Textura macia e sedosa para maior conforto. Segurança e resistência: feito de poliéster, mesmo material dos cintos de segurança.\r\nBorracha de caveira da Zee.Dog, feita de material atóxico.\r\nTextura macia e sedosa para maior conforto. Super gancho de liga de zinco.',199.00,12,'Zee.Dog'),(49,'Guia com Amortecedor 2.0 para Cachorros Gotham','Coleiras','A guia possui mola amortecedora que absorve o impacto da puxada, aliviando a tensão no seu pulso e ombro.','Com mola amortecedora que absorve o impacto por você. Segurança e resistência: feito de poliéster, mesmo material dos cintos de segurança. Super gancho de liga de zinco com trava de enroscar. Alça revista de neoprene para maior conforto;',189.00,14,'Zee.Dog'),(50,'Kit Cata Caca Kroco Azul','Higiene','Facilite a rotina de passeios, garanta o Kit Kroco Cata Caca, com um porta-saquinhos e mais 2 rolos de saquinhos para o refil.','Porta-saquinhos e refis na cor azul. Fácil transporte: pendure na guia ou na sua bolsa para não esquecer durante os passeios. Feito com material biodegradável. Fácil e prático: no uso e na troca do refil.  Ajuda na conservação de um ambiente limpo.  Contém 2 rolos com 20 saquinhos em cada.',14.32,100,'Kroco Cata Caca'),(51,'Areia Higiênica Pipicat Classic para Gatos 4kg','Higiene','Indicado para gatos.','Controle de odores superior com pipicat odor block. Forma torrões mais firmes. Fácil de limpar. Grãos finos; E não possui fragrância;',14.99,342,'Pipicat'),(52,'Brinquedo Torre Bolinhas Azul Oikos','Brinquedos','Indicado para gatos.','Proporciona diversão ao seu gato. Base de cor vibrante. Possui três bolinhas na parte interna do brinquedo que estimulam o instinto de caça promovendo exercícios para seu gato.',107.99,50,'Oikos'),(53,'Arranhador de Rampa Furacão Pet para gatos','Brinquedos','Indicado para gatos.','Previne o estrago de móveis e utensílios de sua casa. Exercita a musculatura, a percepção visual e tática do gato.',59.92,133,'Furação Pet');
/*!40000 ALTER TABLE `produto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `senha`
--

DROP TABLE IF EXISTS `senha`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `senha` (
  `id_senha` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int NOT NULL,
  `senha` varchar(255) NOT NULL,
  PRIMARY KEY (`id_senha`),
  KEY `fk_senha_01` (`id_cliente`),
  CONSTRAINT `fk_senha_01` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE,
  CONSTRAINT `senha_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `senha`
--

LOCK TABLES `senha` WRITE;
/*!40000 ALTER TABLE `senha` DISABLE KEYS */;
INSERT INTO `senha` VALUES (1,1,'$2y$10$Mz5vM7UAJqySm7/ojP2Sq.ObK6EPX4xufBQwAzWJWVUNd5pZ4HgQy'),(2,2,'$2y$10$DTMjNjgKxwuwCoTcQTRjO.Rl9QoNy.o471K6d2.6Q9Xle5UcHgOI.'),(3,3,'$2y$10$AyDkk41FO9d0Y0IeJmZ45.EMIpoeg.zaH7AKD924XsUqg5qJO/oIW');
/*!40000 ALTER TABLE `senha` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-26 15:32:49
