-- --------------------------------------------------------
-- Anfitrião:                    127.0.0.1
-- Versão do servidor:           8.0.30 - MySQL Community Server - GPL
-- SO do servidor:               Win64
-- HeidiSQL Versão:              12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- A despejar estrutura da base de dados para medstock
CREATE DATABASE IF NOT EXISTS `medstock` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `medstock`;


-- --------------------------------------------------------
-- Tabela: utilizadores
-- --------------------------------------------------------
DROP TABLE IF EXISTS `utilizadores`;
CREATE TABLE IF NOT EXISTS `utilizadores` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `perfil` enum('admin','tecnico','visualizador') NOT NULL DEFAULT 'visualizador',
  `ativo` tinyint unsigned NOT NULL DEFAULT 1,
  `ultimo_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela medstock.utilizadores: ~2 rows (aproximadamente)
INSERT INTO `utilizadores` (`id`, `nome`, `email`, `password`, `perfil`, `ativo`, `ultimo_login`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Administrador MedStock', 'admin@medstock.pt', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 1, '2026-06-20 09:00:00', '2025-01-01 00:00:00', '2026-06-20 09:00:00', NULL),
	(2, 'Técnico Biomédico', 'tecnico@medstock.pt', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'tecnico', 1, NULL, '2025-01-15 00:00:00', '2025-01-15 00:00:00', NULL);


-- --------------------------------------------------------
-- Tabela: localizacoes
-- --------------------------------------------------------
DROP TABLE IF EXISTS `localizacoes`;
CREATE TABLE IF NOT EXISTS `localizacoes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `piso` varchar(20) DEFAULT NULL,
  `ala` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela medstock.localizacoes: ~6 rows (aproximadamente)
INSERT INTO `localizacoes` (`id`, `nome`, `descricao`, `piso`, `ala`, `created_at`, `updated_at`) VALUES
	(1, 'Unidade de Cuidados Intensivos', 'UCI - Cuidados críticos e monitorização contínua', '3', 'Norte', '2025-01-01 00:00:00', '2025-01-01 00:00:00'),
	(2, 'Bloco Operatório', 'Salas de cirurgia e recobro', '2', 'Central', '2025-01-01 00:00:00', '2025-01-01 00:00:00'),
	(3, 'Urgência Geral', 'Serviço de urgência e emergência', '0', 'Sul', '2025-01-01 00:00:00', '2025-01-01 00:00:00'),
	(4, 'Medicina Interna', 'Internamento de medicina geral', '4', 'Norte', '2025-01-01 00:00:00', '2025-01-01 00:00:00'),
	(5, 'Cardiologia', 'Consultas e exames cardiológicos', '1', 'Este', '2025-01-01 00:00:00', '2025-01-01 00:00:00'),
	(6, 'Fisioterapia', 'Reabilitação física e motora', '1', 'Oeste', '2025-01-01 00:00:00', '2025-01-01 00:00:00');


-- --------------------------------------------------------
-- Tabela: fornecedores
-- --------------------------------------------------------
DROP TABLE IF EXISTS `fornecedores`;
CREATE TABLE IF NOT EXISTS `fornecedores` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `nif` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `morada` varchar(255) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `pais` varchar(100) NOT NULL DEFAULT 'Portugal',
  `website` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela medstock.fornecedores: ~5 rows (aproximadamente)
INSERT INTO `fornecedores` (`id`, `nome`, `nif`, `email`, `telefone`, `morada`, `cidade`, `pais`, `website`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Philips Healthcare', '500123456', 'info@philips.pt', '+351 210 000 100', 'Rua Quinta do Paizinho, Lote 1', 'Carnaxide', 'Portugal', 'www.philips.pt/healthcare', '2025-01-01 00:00:00', '2025-01-01 00:00:00', NULL),
	(2, 'Dräger Portugal', '500234567', 'info@draeger.pt', '+351 214 225 340', 'Av. 5 de Outubro, 206', 'Lisboa', 'Portugal', 'www.draeger.com', '2025-01-01 00:00:00', '2025-01-01 00:00:00', NULL),
	(3, 'B. Braun Portugal', '500345678', 'info@bbraun.pt', '+351 219 476 200', 'Rua Consiglieri Pedroso, 80', 'Queluz', 'Portugal', 'www.bbraun.pt', '2025-01-01 00:00:00', '2025-01-01 00:00:00', NULL),
	(4, 'Zoll Medical Iberia', '500456789', 'info@zoll.es', '+34 913 571 000', 'Calle de Orense, 62', 'Madrid', 'Espanha', 'www.zoll.com', '2025-01-01 00:00:00', '2025-01-01 00:00:00', NULL),
	(5, 'GE Healthcare Portugal', '500567890', 'gehealthcare@ge.pt', '+351 214 127 000', 'Av. General Norton de Matos, 74', 'Amadora', 'Portugal', 'www.gehealthcare.com', '2025-01-01 00:00:00', '2025-01-01 00:00:00', NULL);


-- --------------------------------------------------------
-- Tabela: equipamentos
-- --------------------------------------------------------
DROP TABLE IF EXISTS `equipamentos`;
CREATE TABLE IF NOT EXISTS `equipamentos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(20) NOT NULL,
  `designacao` varchar(150) NOT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `numero_serie` varchar(100) DEFAULT NULL,
  `categoria` enum('Monitorização','Suporte de vida','Terapia','Diagnóstico','Laboratório','Esterilização','Reabilitação') DEFAULT NULL,
  `estado` enum('Ativo','Em manutenção','Em calibração','Em quarentena','Inativo','Abatido') NOT NULL DEFAULT 'Ativo',
  `criticidade` enum('Baixa','Média','Alta','Suporte de vida') NOT NULL DEFAULT 'Média',
  `id_localizacao` int unsigned DEFAULT NULL,
  `id_fornecedor` int unsigned DEFAULT NULL,
  `data_aquisicao` date DEFAULT NULL,
  `data_fabrico` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`),
  CONSTRAINT `fk_equip_fornecedor` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id`),
  CONSTRAINT `fk_equip_localizacao` FOREIGN KEY (`id_localizacao`) REFERENCES `localizacoes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela medstock.equipamentos: ~5 rows (aproximadamente)
INSERT INTO `equipamentos` (`id`, `codigo`, `designacao`, `marca`, `modelo`, `numero_serie`, `categoria`, `estado`, `criticidade`, `id_localizacao`, `id_fornecedor`, `data_aquisicao`, `data_fabrico`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, '04.002.00', 'Monitor multiparamétrico', 'Philips', 'IntelliVue MP5', 'MP5-2022-45873', 'Monitorização', 'Ativo', 'Alta', 1, 1, '2022-03-15', '2022-01-10', '2022-03-15 00:00:00', '2026-06-20 00:00:00', NULL),
	(2, '06.001.00', 'Ventilador pulmonar', 'Dräger', 'Evita V500', 'EV500-2021-9934', 'Suporte de vida', 'Ativo', 'Suporte de vida', 1, 2, '2021-06-20', '2021-04-01', '2021-06-20 00:00:00', '2026-06-20 00:00:00', NULL),
	(3, '03.005.00', 'Bomba de infusão', 'B. Braun', 'Infusomat Space', 'INF-2020-88321', 'Terapia', 'Em manutenção', 'Média', 4, 3, '2020-09-10', '2020-07-15', '2020-09-10 00:00:00', '2026-06-08 00:00:00', NULL),
	(4, '02.003.00', 'Desfibrilhador', 'Zoll', 'R Series', 'ZR-2021-7712', 'Suporte de vida', 'Ativo', 'Suporte de vida', 3, 4, '2021-11-05', '2021-09-01', '2021-11-05 00:00:00', '2026-06-20 00:00:00', NULL),
	(5, '09.001.00', 'Ecógrafo', 'GE', 'Vivid S70', 'GE-2019-33201', 'Diagnóstico', 'Em calibração', 'Alta', 5, 5, '2019-04-22', '2019-02-10', '2019-04-22 00:00:00', '2026-06-15 00:00:00', NULL);


-- --------------------------------------------------------
-- Tabela: documentos
-- --------------------------------------------------------
DROP TABLE IF EXISTS `documentos`;
CREATE TABLE IF NOT EXISTS `documentos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_equipamento` int unsigned NOT NULL,
  `tipo` enum('Manual','Certificado de calibração','Contrato','Relatório técnico','Outro') DEFAULT NULL,
  `titulo` varchar(200) NOT NULL,
  `descricao` text DEFAULT NULL,
  `ficheiro` varchar(255) DEFAULT NULL,
  `data_documento` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_doc_equipamento` FOREIGN KEY (`id_equipamento`) REFERENCES `equipamentos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela medstock.documentos: ~3 rows (aproximadamente)
INSERT INTO `documentos` (`id`, `id_equipamento`, `tipo`, `titulo`, `descricao`, `ficheiro`, `data_documento`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, 'Manual', 'Manual de Utilizador - Philips IntelliVue MP5', 'Manual completo de operação e manutenção', 'manual_mp5_pt.pdf', '2022-01-10', '2022-03-15 00:00:00', '2022-03-15 00:00:00', NULL),
	(2, 2, 'Certificado de calibração', 'Certificado de Calibração - Evita V500', 'Calibração anual realizada por técnico certificado Dräger', 'cert_evita_2025.pdf', '2025-06-01', '2025-06-01 00:00:00', '2025-06-01 00:00:00', NULL),
	(3, 4, 'Relatório técnico', 'Relatório de Inspeção - Zoll R Series', 'Inspeção de segurança elétrica e funcional', 'relatorio_zoll_2026.pdf', '2026-01-15', '2026-01-15 00:00:00', '2026-01-15 00:00:00', NULL);


-- --------------------------------------------------------
-- Tabela: garantias
-- --------------------------------------------------------
DROP TABLE IF EXISTS `garantias`;
CREATE TABLE IF NOT EXISTS `garantias` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_equipamento` int unsigned NOT NULL,
  `id_fornecedor` int unsigned DEFAULT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `tipo` enum('Fabricante','Extensão','Contrato de manutenção') NOT NULL DEFAULT 'Fabricante',
  `descricao` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_gar_equipamento` FOREIGN KEY (`id_equipamento`) REFERENCES `equipamentos` (`id`),
  CONSTRAINT `fk_gar_fornecedor` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela medstock.garantias: ~4 rows (aproximadamente)
INSERT INTO `garantias` (`id`, `id_equipamento`, `id_fornecedor`, `data_inicio`, `data_fim`, `tipo`, `descricao`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, '2022-03-15', '2026-06-28', 'Fabricante', 'Garantia de fábrica Philips 4 anos com assistência on-site', '2022-03-15 00:00:00', '2022-03-15 00:00:00'),
	(2, 2, 2, '2021-06-20', '2026-07-05', 'Extensão', 'Extensão de garantia Dräger com SLA 24h', '2021-06-20 00:00:00', '2021-06-20 00:00:00'),
	(3, 4, 4, '2021-11-05', '2025-11-05', 'Fabricante', 'Garantia de fábrica Zoll 4 anos', '2021-11-05 00:00:00', '2021-11-05 00:00:00'),
	(4, 5, 5, '2019-04-22', '2026-07-18', 'Contrato de manutenção', 'Contrato de manutenção preventiva GE Healthcare anual', '2019-04-22 00:00:00', '2025-04-22 00:00:00');


/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
