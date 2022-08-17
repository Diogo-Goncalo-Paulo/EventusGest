-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 15-Fev-2021 às 18:52
-- Versão do servidor: 5.7.32
-- versão do PHP: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `eventusgest`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `accesspoints`
--

DROP TABLE IF EXISTS `accesspoints`;
CREATE TABLE IF NOT EXISTS `accesspoints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deletedAt` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `accesspoints`
--

INSERT INTO `accesspoints` (`id`, `name`, `createdAt`, `updatedAt`, `deletedAt`) VALUES
(4, 'Ponto de Acesso 1', '2020-12-23 20:46:37', '2020-12-23 20:46:37', NULL),
(5, 'Ponto 2', '2021-01-01 23:27:47', '2021-01-01 23:27:47', '2021-01-02 00:25:19'),
(6, 'Entrada Norte', '2021-01-02 19:24:43', '2021-01-02 19:24:43', NULL),
(7, 'Porta do Backstage', '2021-01-02 19:26:13', '2021-01-02 19:26:13', NULL),
(8, 'Ponto de Acesso 2', '2021-01-02 19:26:33', '2021-01-02 19:26:33', NULL),
(9, 'Entrada Restauração', '2021-01-02 19:28:08', '2021-01-02 19:28:08', NULL),
(10, 'Ponto de Acesso 1', '2021-01-11 00:25:21', '2021-01-11 00:25:21', NULL),
(11, 'Ponto de Acesso 1', '2021-01-14 23:25:36', '2021-01-14 23:25:36', NULL),
(12, 'Ponto de Acesso 1', '2021-01-25 17:59:58', '2021-01-25 17:59:58', NULL),
(13, 'Ponto de Acesso 1', '2021-02-06 17:02:44', '2021-02-06 17:02:44', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `areas`
--

DROP TABLE IF EXISTS `areas`;
CREATE TABLE IF NOT EXISTS `areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `idEvent` int(11) NOT NULL,
  `resetTime` time DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deletedAt` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fkIdx_158` (`idEvent`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `areas`
--

INSERT INTO `areas` (`id`, `name`, `idEvent`, `resetTime`, `createdAt`, `updatedAt`, `deletedAt`) VALUES
(6, 'Rua', 4, '00:00:00', '2020-12-23 20:46:37', '2020-12-23 20:46:37', NULL),
(7, 'Recinto', 4, NULL, '2020-12-23 20:46:37', '2020-12-23 20:46:37', NULL),
(8, 'Rua', 5, NULL, '2021-01-02 19:24:43', '2021-01-02 19:24:43', NULL),
(9, 'Recinto', 5, NULL, '2021-01-02 19:24:43', '2021-01-02 19:24:43', NULL),
(10, 'Backstage', 5, NULL, '2021-01-02 19:25:58', '2021-01-02 19:25:58', NULL),
(11, 'Restauração', 5, NULL, '2021-01-02 19:27:41', '2021-01-02 19:27:41', NULL),
(12, 'Rua', 6, NULL, '2021-01-11 00:25:21', '2021-01-11 00:25:21', NULL),
(13, 'Recinto', 6, NULL, '2021-01-11 00:25:21', '2021-01-11 00:25:21', NULL),
(14, 'Rua', 7, NULL, '2021-01-14 23:25:36', '2021-01-14 23:25:36', NULL),
(15, 'Recinto', 7, NULL, '2021-01-14 23:25:36', '2021-01-14 23:25:36', NULL),
(16, 'Rua', 8, NULL, '2021-01-25 17:59:58', '2021-01-25 17:59:58', NULL),
(17, 'Recinto', 8, NULL, '2021-01-25 17:59:58', '2021-01-25 17:59:58', NULL),
(18, 'Rua', 9, NULL, '2021-02-06 17:02:44', '2021-02-06 17:02:44', NULL),
(19, 'Recinto', 9, NULL, '2021-02-06 17:02:44', '2021-02-06 17:02:44', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `areasaccesspoints`
--

DROP TABLE IF EXISTS `areasaccesspoints`;
CREATE TABLE IF NOT EXISTS `areasaccesspoints` (
  `idArea` int(11) NOT NULL,
  `idAccessPoint` int(11) NOT NULL,
  PRIMARY KEY (`idArea`,`idAccessPoint`),
  KEY `fk_idArea_Area_PontoAcesso` (`idArea`),
  KEY `fk_idPontoAcesso_Area_PontoAcesso` (`idAccessPoint`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `areasaccesspoints`
--

INSERT INTO `areasaccesspoints` (`idArea`, `idAccessPoint`) VALUES
(6, 4),
(6, 5),
(7, 4),
(7, 5),
(8, 6),
(8, 8),
(9, 6),
(9, 7),
(9, 8),
(9, 9),
(10, 7),
(11, 9),
(12, 10),
(13, 10),
(14, 11),
(15, 11),
(16, 12),
(17, 12),
(18, 13),
(19, 13);

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `idx-auth_assignment-user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', 1606230745),
('admin', '5', 1612631089),
('admin', '6', 1609619017),
('porteiro', '4', 1609614609),
('porteiro', '7', 1610308166);

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, NULL, NULL, NULL, 1606157941, 1606157941),
('blockCredential', 2, 'Block or unblock a credential a credential', NULL, NULL, 1606591529, 1606591529),
('createAccessPoint', 2, 'create a Access Point for a event', NULL, NULL, 1606245075, 1606245075),
('createArea', 2, 'Create a area for a event', NULL, NULL, 1606157941, 1606157941),
('createCarrier', 2, 'Create a carrier', NULL, NULL, 1606157941, 1606157941),
('createCarrierType', 2, 'create a carrier type', NULL, NULL, 1606157941, 1606157941),
('createCredential', 2, 'create a credential', NULL, NULL, 1606157941, 1606157941),
('createEntity', 2, 'create a entity', NULL, NULL, 1606157941, 1606157941),
('createEntityType', 2, 'create a entity type', NULL, NULL, 1606157941, 1606157941),
('createEvent', 2, 'create a event', NULL, NULL, 1606157941, 1606157941),
('createImpossibleMovement', 2, 'Create an impossible movement', NULL, NULL, 1610295209, 1610295209),
('createMovement', 2, 'Create a movement for a credential', NULL, NULL, 1606157941, 1606157941),
('createUsers', 2, 'create a user', NULL, NULL, 1606157941, 1606157941),
('deleteAccessPoint', 2, 'delete a Access Point for a event', NULL, NULL, 1606245075, 1606245075),
('deleteArea', 2, 'delete a area for a event', NULL, NULL, 1606157941, 1606157941),
('deleteCarrier', 2, 'Delete a carrier', NULL, NULL, 1606157941, 1606157941),
('deleteCarrierType', 2, 'delete a carrier type', NULL, NULL, 1606157941, 1606157941),
('deleteCredential', 2, 'delete a credential', NULL, NULL, 1606157941, 1606157941),
('deleteEntity', 2, 'delete a entity', NULL, NULL, 1606157941, 1606157941),
('deleteEntityType', 2, 'delete a entity type', NULL, NULL, 1606157941, 1606157941),
('deleteEvent', 2, 'delete a event', NULL, NULL, 1606157941, 1606157941),
('deleteMovement', 2, 'delete a movement for a credential', NULL, NULL, 1606157941, 1606157941),
('deleteUsers', 2, 'delete a user', NULL, NULL, 1606157941, 1606157941),
('flagCredential', 2, 'Flag a credential', NULL, NULL, 1606591529, 1606591529),
('porteiro', 1, NULL, NULL, NULL, 1606157941, 1606157941),
('updateAccessPoint', 2, 'update a Access Point for a event', NULL, NULL, 1606245075, 1606245075),
('updateArea', 2, 'update a area for a event', NULL, NULL, 1606157941, 1606157941),
('updateCarrier', 2, 'update a carrier', NULL, NULL, 1606157941, 1606157941),
('updateCarrierType', 2, 'update a carrier type', NULL, NULL, 1606157941, 1606157941),
('updateCredential', 2, 'update a credential', NULL, NULL, 1606157941, 1606157941),
('updateEntity', 2, 'update a entity', NULL, NULL, 1606157941, 1606157941),
('updateEntityType', 2, 'update a entity type', NULL, NULL, 1606157941, 1606157941),
('updateEvent', 2, 'update a event', NULL, NULL, 1606157941, 1606157941),
('updateMovement', 2, 'update a movement for a credential', NULL, NULL, 1606157941, 1606157941),
('updateUsers', 2, 'update a user', NULL, NULL, 1606157941, 1606157941),
('viewAccessPoint', 2, 'view a Access Point for a event', NULL, NULL, 1606245075, 1606245075),
('viewArea', 2, 'view a area for a event', NULL, NULL, 1606157941, 1606157941),
('viewCarrier', 2, 'view a carrier', NULL, NULL, 1606157941, 1606157941),
('viewCarrierType', 2, 'view a carrier type', NULL, NULL, 1606157941, 1606157941),
('viewCredential', 2, 'view a credential', NULL, NULL, 1606157941, 1606157941),
('viewEntity', 2, 'view a entity', NULL, NULL, 1606157941, 1606157941),
('viewEntityType', 2, 'view a entity type', NULL, NULL, 1606157941, 1606157941),
('viewEvent', 2, 'view a event', NULL, NULL, 1606157941, 1606157941),
('viewMovement', 2, 'view a movement for a credential', NULL, NULL, 1606157941, 1606157941),
('viewUsers', 2, 'view a user', NULL, NULL, 1606157941, 1606157941);

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', 'blockCredential'),
('admin', 'createAccessPoint'),
('admin', 'createArea'),
('admin', 'createCarrier'),
('admin', 'createCarrierType'),
('admin', 'createCredential'),
('admin', 'createEntity'),
('admin', 'createEntityType'),
('admin', 'createEvent'),
('admin', 'createImpossibleMovement'),
('porteiro', 'createMovement'),
('admin', 'createUsers'),
('admin', 'deleteAccessPoint'),
('admin', 'deleteArea'),
('admin', 'deleteCarrier'),
('admin', 'deleteCarrierType'),
('admin', 'deleteCredential'),
('admin', 'deleteEntity'),
('admin', 'deleteEntityType'),
('admin', 'deleteEvent'),
('porteiro', 'deleteMovement'),
('admin', 'deleteUsers'),
('porteiro', 'flagCredential'),
('admin', 'porteiro'),
('admin', 'updateAccessPoint'),
('admin', 'updateArea'),
('admin', 'updateCarrier'),
('admin', 'updateCarrierType'),
('admin', 'updateCredential'),
('admin', 'updateEntity'),
('admin', 'updateEntityType'),
('admin', 'updateEvent'),
('porteiro', 'updateMovement'),
('admin', 'updateUsers'),
('admin', 'viewAccessPoint'),
('admin', 'viewArea'),
('porteiro', 'viewCarrier'),
('admin', 'viewCarrierType'),
('porteiro', 'viewCredential'),
('admin', 'viewEntity'),
('admin', 'viewEntityType'),
('admin', 'viewEvent'),
('porteiro', 'viewMovement'),
('admin', 'viewUsers');

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `carriers`
--

DROP TABLE IF EXISTS `carriers`;
CREATE TABLE IF NOT EXISTS `carriers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `info` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `idCredential` int(11) NOT NULL,
  `idCarrierType` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deletedAt` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idCredencial_Carregador` (`idCredential`),
  KEY `fk_idTipoCarregador_Carregador` (`idCarrierType`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `carriers`
--

INSERT INTO `carriers` (`id`, `name`, `info`, `photo`, `idCredential`, `idCarrierType`, `createdAt`, `updatedAt`, `deletedAt`) VALUES
(4, 'Cremilde Costa', '', '2CCl3T-N.png', 31, 6, '2021-01-02 20:13:38', '2021-01-06 14:54:42', '2021-01-11 20:06:10'),
(5, 'Carro Da Cremilde', 'IX-32-25', '6DXuxwLy.png', 32, 7, '2021-01-02 20:14:05', '2021-01-06 14:55:02', '2021-01-11 20:06:05'),
(6, 'João Silva', 'Empregado', '_kC7BfgV.png', 35, 6, '2021-01-02 20:14:24', '2021-02-14 20:34:11', NULL),
(7, 'Manel', 'Cozinheiro', NULL, 20, 6, '2021-01-02 20:15:52', '2021-01-02 20:15:52', NULL),
(8, 'Zé', 'Trabalhador', '9p5sLnA2.png', 47, 6, '2021-01-11 00:21:07', '2021-01-11 00:21:07', NULL),
(9, 'Zé', '', 'm2S9DQIp.png', 54, 6, '2021-01-25 17:57:02', '2021-01-25 17:57:02', NULL),
(10, 'João Almeida', 'Dono', NULL, 52, 6, '2021-02-14 20:32:43', '2021-02-14 20:32:43', '2021-02-14 20:32:56'),
(11, 'Joana Antunes', '', NULL, 59, 6, '2021-02-14 20:34:45', '2021-02-14 20:34:45', NULL),
(12, 'Mitsubishi L200', '55-RG-55', '0tVVcAi8.jpg', 44, 7, '2021-02-14 20:36:37', '2021-02-14 20:36:37', NULL),
(13, 'Teste', '', NULL, 35, 6, '2021-02-14 20:37:13', '2021-02-14 20:37:13', '2021-02-14 20:37:43'),
(14, 'Patricia Gaspar', '', NULL, 60, 6, '2021-02-14 20:38:22', '2021-02-14 20:38:22', NULL),
(15, 'Rita Jorge', '', NULL, 45, 6, '2021-02-14 20:38:41', '2021-02-14 20:38:41', NULL),
(16, 'Opel Corsa', '65-KK-32', NULL, 53, 7, '2021-02-14 20:39:13', '2021-02-14 20:39:13', NULL),
(17, 'André Brites', '', '3CC6aAZd.jpg', 78, 6, '2021-02-14 20:42:48', '2021-02-14 20:47:05', NULL),
(18, 'Diogo Pereira', '', NULL, 71, 8, '2021-02-14 20:43:12', '2021-02-14 20:43:12', NULL),
(19, 'Gonçalo Rodrigues', '', '6NHEvZc4.png', 68, 9, '2021-02-14 20:43:58', '2021-02-14 20:45:13', NULL),
(20, 'Luís Penetra', '', NULL, 69, 6, '2021-02-14 20:52:00', '2021-02-14 20:52:00', NULL),
(21, 'Monica Luz', '', NULL, 76, 6, '2021-02-14 20:52:19', '2021-02-14 20:52:19', NULL),
(22, 'Joaquim Inicio', '', NULL, 64, 6, '2021-02-14 20:52:37', '2021-02-14 20:52:37', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `carrierstypes`
--

DROP TABLE IF EXISTS `carrierstypes`;
CREATE TABLE IF NOT EXISTS `carrierstypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `idEvent` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deletedAt` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fkIdx_155` (`idEvent`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `carrierstypes`
--

INSERT INTO `carrierstypes` (`id`, `name`, `idEvent`, `createdAt`, `updatedAt`, `deletedAt`) VALUES
(5, 'Gamer', 4, '2020-12-30 17:00:43', '2020-12-30 17:00:43', NULL),
(6, 'Individual', 5, '2021-01-02 19:25:05', '2021-01-02 19:25:05', NULL),
(7, 'Viatura', 5, '2021-01-02 19:25:12', '2021-01-02 19:25:12', NULL),
(8, 'Gamer', 5, '2021-01-11 00:28:21', '2021-01-11 00:28:21', NULL),
(9, '234', 5, '2021-01-25 18:07:29', '2021-01-25 18:07:29', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `credentials`
--

DROP TABLE IF EXISTS `credentials`;
CREATE TABLE IF NOT EXISTS `credentials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ucid` varchar(8) NOT NULL,
  `idEntity` int(11) NOT NULL,
  `idCurrentArea` int(11) DEFAULT NULL,
  `idEvent` int(11) NOT NULL,
  `flagged` int(11) NOT NULL DEFAULT '0',
  `blocked` tinyint(1) DEFAULT NULL,
  `createdAt` timestamp NOT NULL,
  `updatedAt` timestamp NOT NULL,
  `deletedAt` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idArea_Credencial` (`idCurrentArea`),
  KEY `fk_idEntidade_Credencial` (`idEntity`),
  KEY `fkIdx_149` (`idEvent`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `credentials`
--

INSERT INTO `credentials` (`id`, `ucid`, `idEntity`, `idCurrentArea`, `idEvent`, `flagged`, `blocked`, `createdAt`, `updatedAt`, `deletedAt`) VALUES
(11, '6qzbU9KR', 5, 7, 4, 9, 0, '2020-12-28 17:12:18', '2021-01-18 00:27:41', NULL),
(12, 'zlmMFuBR', 5, NULL, 4, 0, 0, '2020-12-28 17:12:20', '2020-12-28 17:12:20', NULL),
(13, 'zav3RxeY', 5, NULL, 4, 0, 0, '2020-12-28 17:12:20', '2020-12-28 17:12:20', NULL),
(14, 'Oz0fLLfJ', 5, NULL, 4, 0, 0, '2020-12-28 17:12:23', '2020-12-28 17:12:23', NULL),
(15, 'H41mpne4', 5, NULL, 4, 0, 0, '2020-12-28 17:12:31', '2020-12-28 17:12:31', NULL),
(16, '-o0gQ1PN', 5, NULL, 4, 0, 0, '2020-12-28 17:12:32', '2020-12-28 17:12:32', NULL),
(17, '8eBmxv0i', 5, NULL, 4, 0, 0, '2020-12-28 17:12:33', '2020-12-28 17:12:33', NULL),
(18, 'y-12Ddft', 5, NULL, 4, 0, 0, '2020-12-28 17:12:34', '2020-12-28 17:12:34', NULL),
(19, 'TgK-mSt5', 5, NULL, 4, 40, 0, '2020-12-28 17:12:36', '2021-01-01 20:39:26', NULL),
(20, 'Orav5eot', 7, 9, 5, 13, 1, '2021-01-02 20:12:01', '2021-01-25 18:04:09', NULL),
(21, 'y-Gk8DVu', 6, 11, 5, 0, 1, '2021-01-02 20:12:02', '2021-01-10 20:28:39', '2021-02-14 20:28:16'),
(22, '1fQm-PP5', 6, 9, 5, 8, 0, '2021-01-02 20:12:03', '2021-01-18 22:56:26', NULL),
(23, 'PPF7dm9_', 6, NULL, 5, 0, 0, '2021-01-02 20:12:05', '2021-01-02 20:12:05', '2021-01-11 14:57:25'),
(24, 'ICnZMCjC', 6, 8, 5, 0, 0, '2021-01-02 20:12:06', '2021-01-02 20:12:06', '2021-01-25 18:03:41'),
(25, 'yhXWcpBc', 6, NULL, 5, 0, 0, '2021-01-02 20:12:07', '2021-01-02 20:12:07', '2021-01-11 14:57:26'),
(26, 'NEyroD4U', 6, NULL, 5, 0, 0, '2021-01-02 20:12:09', '2021-01-02 20:12:09', '2021-01-11 14:57:28'),
(27, '4GEFQu2t', 6, NULL, 5, 0, 0, '2021-01-02 20:12:13', '2021-01-02 20:12:13', '2021-01-11 14:57:18'),
(28, 'M2YbhU_7', 8, NULL, 5, 0, 0, '2021-01-02 20:13:08', '2021-01-02 20:13:08', '2021-01-11 14:57:20'),
(29, 'xmtJxNya', 8, NULL, 5, 0, 0, '2021-01-02 20:13:08', '2021-01-02 20:13:08', '2021-01-11 14:57:21'),
(30, '7_skiHss', 8, NULL, 5, 0, 0, '2021-01-02 20:13:10', '2021-01-02 20:13:10', '2021-01-11 14:57:23'),
(31, 'XjYLGGnE', 9, NULL, 5, 0, 0, '2021-01-02 20:13:21', '2021-01-02 20:13:21', '2021-01-11 14:58:12'),
(32, 'g3sdIjyE', 9, NULL, 5, 0, 0, '2021-01-02 20:13:22', '2021-01-02 20:13:22', '2021-01-11 20:06:05'),
(33, 'O6DBAsvx', 9, NULL, 5, 0, 0, '2021-01-02 20:13:23', '2021-01-02 20:13:23', '2021-02-14 20:34:26'),
(34, 'O8Puallv', 9, NULL, 5, 0, 0, '2021-01-02 20:13:24', '2021-01-02 20:13:24', '2021-01-11 14:57:30'),
(35, 'DLTETRfO', 9, 8, 5, 49, 0, '2021-01-02 20:13:25', '2021-02-15 18:35:04', NULL),
(36, 'GEuc7vuU', 12, NULL, 5, 0, 0, '2021-01-02 20:21:14', '2021-01-02 20:21:14', '2021-01-11 14:57:17'),
(37, 'ncgZ3CMj', 12, NULL, 5, 0, 0, '2021-01-02 20:21:15', '2021-01-02 20:21:15', '2021-01-11 14:57:32'),
(38, 'Wk9O0pko', 12, NULL, 5, 0, 0, '2021-01-02 20:21:15', '2021-01-02 20:21:15', '2021-01-11 14:57:34'),
(39, 'EkNdXiP4', 12, NULL, 5, 0, 0, '2021-01-02 20:21:16', '2021-01-02 20:21:16', '2021-01-11 14:57:36'),
(40, 'XQrvZA0h', 12, NULL, 5, 0, 0, '2021-01-02 20:21:17', '2021-01-02 20:21:17', '2021-01-11 14:57:37'),
(41, 'BlCDtUjy', 12, NULL, 5, 0, 0, '2021-01-02 20:21:19', '2021-01-02 20:21:19', '2021-01-11 14:57:38'),
(42, 'sO2c8CFL', 12, 9, 5, 3, 0, '2021-01-10 16:18:29', '2021-02-15 18:35:15', NULL),
(43, 'yiCMQZ7K', 12, NULL, 5, 0, 0, '2021-01-10 16:19:09', '2021-01-10 16:19:09', '2021-01-11 14:57:40'),
(44, 'F-zgd13b', 12, 8, 5, 0, 0, '2021-01-10 16:36:58', '2021-01-10 16:36:58', NULL),
(45, 'X8C2iWBb', 12, 9, 5, 0, 0, '2021-01-10 19:26:55', '2021-01-10 19:26:55', NULL),
(46, '-9IciVS0', 12, 11, 5, 1, 0, '2021-01-11 00:04:58', '2021-01-11 00:13:14', '2021-01-25 18:03:47'),
(47, 'LkAbDxuJ', 13, 9, 5, 1, 1, '2021-01-11 00:18:38', '2021-01-18 00:23:48', NULL),
(48, 'mm6ltS8d', 6, 8, 5, 0, 0, '2021-01-11 16:35:53', '2021-01-11 16:35:53', '2021-01-25 18:03:53'),
(49, '3yvebHuJ', 6, 8, 5, 0, 0, '2021-01-11 16:35:53', '2021-01-11 16:35:53', NULL),
(50, 'x2onoV5Y', 6, 8, 5, 0, 0, '2021-01-11 16:35:53', '2021-01-11 16:35:53', '2021-02-14 20:28:57'),
(51, 'f52MMQ9Y', 6, 8, 5, 0, 0, '2021-01-11 16:35:53', '2021-01-11 16:35:53', '2021-02-14 20:32:13'),
(52, 'DfEF21kc', 6, 8, 5, 0, 0, '2021-01-11 16:35:53', '2021-01-11 16:35:53', '2021-02-14 20:32:56'),
(53, 'b8B7hdV7', 6, 8, 5, 0, 0, '2021-01-11 16:35:53', '2021-01-11 16:35:53', NULL),
(54, 'fYJl0xSn', 6, 8, 5, 1, 0, '2021-01-11 16:35:54', '2021-02-14 20:49:00', NULL),
(55, 'wW2uT-zl', 6, 8, 5, 0, 0, '2021-01-11 16:35:54', '2021-01-11 16:35:54', NULL),
(56, 'A8TmCGaG', 6, 8, 5, 0, 0, '2021-01-11 16:35:54', '2021-01-11 16:35:54', NULL),
(57, 'F6NrnT3c', 6, 8, 5, 2, 0, '2021-01-11 16:35:54', '2021-02-14 20:49:28', NULL),
(58, 'KU_kjTmL', 6, 8, 5, 0, 0, '2021-01-11 16:35:54', '2021-01-11 16:35:54', '2021-02-14 20:49:46'),
(59, '2OfsXOMj', 6, 8, 5, 0, 0, '2021-01-11 16:35:54', '2021-01-11 16:35:54', NULL),
(60, '-UOeesec', 6, 8, 5, 0, 0, '2021-01-11 16:35:54', '2021-01-11 16:35:54', NULL),
(61, 'nrNzYYks', 6, 8, 5, 1, 0, '2021-01-11 16:35:54', '2021-02-14 20:48:51', NULL),
(62, 'aUP0fVmA', 6, 8, 5, 0, 0, '2021-01-11 16:35:54', '2021-01-11 16:35:54', NULL),
(63, '2OOeT4FG', 6, 8, 5, 1, 1, '2021-01-11 16:35:54', '2021-02-14 20:49:23', NULL),
(64, 'U2RrWpg3', 6, 8, 5, 0, 0, '2021-01-11 16:35:54', '2021-01-11 16:35:54', NULL),
(65, 'dIC6LNEQ', 6, 8, 5, 1, 0, '2021-01-11 16:35:54', '2021-02-14 20:49:10', NULL),
(66, 'x52nSX69', 6, 8, 5, 0, 0, '2021-01-11 16:35:54', '2021-01-11 16:35:54', NULL),
(67, 'yKdJwVaI', 6, 8, 5, 0, 0, '2021-01-11 16:35:54', '2021-01-11 16:35:54', NULL),
(68, 'fr31CDw6', 14, 9, 5, 0, 0, '2021-01-11 16:36:46', '2021-02-14 20:51:37', NULL),
(69, 'aAS3aT2D', 6, 8, 5, 1, 0, '2021-01-11 16:36:46', '2021-02-14 20:49:03', NULL),
(70, 'tx7tJZmo', 6, 8, 5, 0, 0, '2021-01-11 16:36:46', '2021-01-11 16:36:46', NULL),
(71, 'KykqWBh8', 14, 8, 5, 0, 0, '2021-01-11 16:36:46', '2021-02-14 20:51:24', NULL),
(72, '0VAOhs3x', 6, 8, 5, 2, 0, '2021-01-11 16:36:46', '2021-02-14 20:49:07', NULL),
(73, '61NHqAgz', 6, 8, 5, 0, 0, '2021-01-11 16:36:46', '2021-01-11 16:36:46', '2021-01-11 16:36:56'),
(74, '7Jop6S07', 6, 8, 5, 0, 0, '2021-01-25 17:55:30', '2021-01-25 17:55:30', '2021-01-25 17:55:37'),
(75, 'brfxe43P', 6, 8, 5, 0, 1, '2021-01-25 17:57:35', '2021-02-14 20:52:58', NULL),
(76, 'qn2YEXSi', 14, 8, 5, 0, 0, '2021-01-25 18:05:15', '2021-01-25 18:05:15', NULL),
(77, 'hCpenTXw', 14, 8, 5, 0, 0, '2021-01-25 18:05:19', '2021-01-25 18:05:19', NULL),
(78, 'WygX-yTf', 14, 8, 5, 0, 0, '2021-01-25 18:05:19', '2021-01-25 18:05:19', NULL),
(79, 'x2_eZ0BF', 14, 8, 5, 0, 0, '2021-01-25 18:05:19', '2021-01-25 18:05:19', NULL),
(80, 'F8iQq_Mj', 14, 8, 5, 1, 0, '2021-01-25 18:05:19', '2021-02-14 20:49:32', NULL),
(81, 'Y5itGEys', 14, 8, 5, 0, 0, '2021-01-25 18:05:19', '2021-01-25 18:05:19', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `entities`
--

DROP TABLE IF EXISTS `entities`;
CREATE TABLE IF NOT EXISTS `entities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ueid` varchar(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `idEntityType` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deletedAt` timestamp NULL DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idTipoEntidade_Entidade` (`idEntityType`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `entities`
--

INSERT INTO `entities` (`id`, `ueid`, `name`, `idEntityType`, `createdAt`, `updatedAt`, `deletedAt`, `weight`, `email`) VALUES
(5, 'yiDdMKSB', 'Gonçalo Rodrigues Gaspar', 5, '2020-12-28 17:12:08', '2020-12-28 17:12:08', NULL, 4, 'goncalorg@outlook.pt'),
(6, '3YyLa2Vt', 'Restaurante Bons', 9, '2021-01-02 19:32:37', '2021-01-25 17:55:19', NULL, 1, 'email@gmail.pt'),
(7, 'TRFOsV08', 'Banda de Musica Pimba', 7, '2021-01-02 20:05:48', '2021-01-02 20:05:48', NULL, 1, 'pimba@mail.pt'),
(8, 'tojts_WD', 'Bar de Bebidas', 8, '2021-01-02 20:06:27', '2021-01-02 20:06:27', NULL, 2, 'bebidas@bar.pt'),
(9, 'aR1_pMaf', 'Loja da Cremilde', 6, '2021-01-02 20:07:01', '2021-01-02 20:07:01', NULL, 1, 'cremilde@loja.pr'),
(10, 'gtyUZ0mL', 'Tratores do João', 6, '2021-01-02 20:07:27', '2021-01-02 20:07:27', NULL, 2, 'geral@tratores.com'),
(11, 'n82K8k0G', 'Tony Carreira', 7, '2021-01-02 20:08:01', '2021-01-02 20:08:01', NULL, 1, 'tony@musica.pt'),
(12, 'djDxpLXb', 'Organização', 10, '2021-01-02 20:08:32', '2021-01-02 20:08:32', NULL, 1, 'eventusgest@gmail.com'),
(13, 'VyWbYWHL', 'Teste 1', 10, '2021-01-11 00:18:06', '2021-01-11 00:23:27', NULL, 1, 'eu.crafty13@gmail.com'),
(14, '0hZNKuK9', 'Sacog LDA', 6, '2021-01-25 18:04:52', '2021-02-14 20:47:38', NULL, 2, 'mail@asfdsdf.dsgf');

-- --------------------------------------------------------

--
-- Estrutura da tabela `entitytypeareas`
--

DROP TABLE IF EXISTS `entitytypeareas`;
CREATE TABLE IF NOT EXISTS `entitytypeareas` (
  `idEntityType` int(11) NOT NULL,
  `idArea` int(11) NOT NULL,
  PRIMARY KEY (`idEntityType`,`idArea`),
  KEY `fk_idArea_TipoEntidade_Area` (`idArea`),
  KEY `fk_idTipoEntidade_TipoEntidade_Area` (`idEntityType`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `entitytypeareas`
--

INSERT INTO `entitytypeareas` (`idEntityType`, `idArea`) VALUES
(5, 6),
(5, 7),
(6, 8),
(7, 8),
(8, 8),
(9, 8),
(10, 8),
(12, 8),
(6, 9),
(7, 9),
(8, 9),
(9, 9),
(10, 9),
(11, 9),
(12, 9),
(7, 10),
(10, 10),
(8, 11),
(9, 11),
(10, 11);

-- --------------------------------------------------------

--
-- Estrutura da tabela `entitytypes`
--

DROP TABLE IF EXISTS `entitytypes`;
CREATE TABLE IF NOT EXISTS `entitytypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `qtCredentials` int(11) NOT NULL,
  `idEvent` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deletedAt` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fkIdx_152` (`idEvent`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `entitytypes`
--

INSERT INTO `entitytypes` (`id`, `name`, `qtCredentials`, `idEvent`, `createdAt`, `updatedAt`, `deletedAt`) VALUES
(5, 'test', 5, 4, '2020-12-28 17:12:00', '2020-12-28 17:12:00', NULL),
(6, 'Expositor', 5, 5, '2021-01-02 19:25:39', '2021-01-02 19:25:39', NULL),
(7, 'Artista', 10, 5, '2021-01-02 19:27:25', '2021-01-02 19:27:25', NULL),
(8, 'Bar', 15, 5, '2021-01-02 19:28:55', '2021-01-02 19:28:55', NULL),
(9, 'Restaurante', 30, 5, '2021-01-02 19:29:09', '2021-01-02 19:29:09', NULL),
(10, 'Staff', 100, 5, '2021-01-02 19:29:48', '2021-01-02 19:29:48', NULL),
(11, 'Teste', 3, 5, '2021-01-11 00:30:07', '2021-01-11 00:30:07', NULL),
(12, 'terse', 14, 5, '2021-01-25 18:06:19', '2021-01-25 18:06:19', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `startDate` datetime NOT NULL,
  `endDate` datetime NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deletedAt` timestamp NULL DEFAULT NULL,
  `default_area` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-event-default_area` (`default_area`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `events`
--

INSERT INTO `events` (`id`, `name`, `startDate`, `endDate`, `createdAt`, `updateAt`, `deletedAt`, `default_area`) VALUES
(4, 'Evento Teste 2021', '2021-01-01 20:46:10', '2021-01-03 20:46:10', '2020-12-23 20:46:37', '2020-12-23 20:46:37', NULL, 6),
(5, 'Festival de Musica', '2020-10-31 00:00:00', '2021-11-02 00:00:00', '2021-01-02 19:24:43', '2021-01-02 19:24:43', NULL, 8),
(6, 'teste', '2021-01-11 00:25:03', '2021-01-12 00:25:03', '2021-01-11 00:25:21', '2021-01-11 00:25:21', NULL, 12),
(7, 'Festival de Musica 2', '2021-01-12 23:25:26', '2021-01-12 23:25:26', '2021-01-14 23:25:36', '2021-01-14 23:25:36', NULL, 14),
(8, 'Teste 112', '2021-01-25 17:59:41', '2021-01-29 17:59:41', '2021-01-25 17:59:58', '2021-01-25 17:59:58', NULL, 16),
(9, 'Teste perms', '2021-02-24 17:02:01', '2021-02-27 17:02:01', '2021-02-06 17:02:44', '2021-02-06 17:02:44', NULL, 18);

-- --------------------------------------------------------

--
-- Estrutura da tabela `eventsusers`
--

DROP TABLE IF EXISTS `eventsusers`;
CREATE TABLE IF NOT EXISTS `eventsusers` (
  `idEvent` int(11) NOT NULL,
  `idUsers` int(11) NOT NULL,
  PRIMARY KEY (`idEvent`,`idUsers`),
  KEY `fkIdx_127` (`idEvent`),
  KEY `fkIdx_143` (`idUsers`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `eventsusers`
--

INSERT INTO `eventsusers` (`idEvent`, `idUsers`) VALUES
(4, 4),
(4, 5),
(4, 6),
(5, 5),
(5, 6),
(6, 4),
(6, 6),
(7, 5),
(7, 6),
(8, 5),
(8, 6),
(9, 4),
(9, 5),
(9, 7);

-- --------------------------------------------------------

--
-- Estrutura da tabela `imoveis`
--

DROP TABLE IF EXISTS `imoveis`;
CREATE TABLE IF NOT EXISTS `imoveis` (
  `metrosQuadrados` int(11) NOT NULL,
  `morada` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `imoveis`
--

INSERT INTO `imoveis` (`metrosQuadrados`, `morada`) VALUES
(25, 'Rua daqui'),
(36, 'Rua dali');

-- --------------------------------------------------------

--
-- Estrutura da tabela `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1605543788),
('m140506_102106_rbac_init', 1605543791),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1605543791),
('m180523_151638_rbac_updates_indexes_without_prefix', 1605543791),
('m200409_110543_rbac_update_mssql_trigger', 1605543791),
('m130524_201442_init', 1606157941),
('m190124_110200_add_verification_token_column_to_user_table', 1606157941),
('m201111_164337_init_rbac', 1606157941),
('m201124_150951_add_user', 1606245075),
('m201124_163037_init_rbac', 1606245075),
('m201125_164042_change_columns_names', 1606415652),
('m201128_191656_rbac_credentials_permitions', 1606591529),
('m201214_154714_add_field_event', 1608148525),
('m201215_163043_add_weight_to_table_entity', 1608148525),
('m201216_151002_add_column_email_to_table_entities', 1608148525),
('m210101_235104_eventuser_primary_keys', 1610295209),
('m210110_155607_change_rbac', 1610295209);

-- --------------------------------------------------------

--
-- Estrutura da tabela `movements`
--

DROP TABLE IF EXISTS `movements`;
CREATE TABLE IF NOT EXISTS `movements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idCredential` int(11) NOT NULL,
  `idAccessPoint` int(11) NOT NULL,
  `idAreaFrom` int(11) NOT NULL,
  `idAreaTo` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idCredencial_Movimento` (`idCredential`),
  KEY `fk_idPontoAcesso_Movimento` (`idAccessPoint`),
  KEY `fkIdx_195` (`idAreaFrom`),
  KEY `fkIdx_198` (`idAreaTo`),
  KEY `fkIdx_201` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `movements`
--

INSERT INTO `movements` (`id`, `time`, `idCredential`, `idAccessPoint`, `idAreaFrom`, `idAreaTo`, `idUser`) VALUES
(52, '2021-01-02 20:22:38', 20, 6, 8, 9, 6),
(53, '2021-01-02 20:22:47', 21, 6, 8, 9, 6),
(54, '2021-01-02 20:22:56', 22, 6, 8, 9, 6),
(55, '2021-01-02 20:23:04', 20, 6, 9, 8, 6),
(56, '2021-01-02 20:24:04', 21, 9, 9, 11, 6),
(57, '2021-01-09 19:47:36', 35, 6, 8, 9, 5),
(58, '2021-01-10 15:39:13', 35, 6, 9, 8, 5),
(59, '2021-01-10 20:23:12', 35, 6, 9, 8, 5),
(60, '2021-01-10 20:25:17', 35, 6, 8, 9, 5),
(61, '2021-01-10 20:27:36', 35, 6, 9, 8, 5),
(62, '2021-01-10 22:11:26', 35, 6, 8, 9, 5),
(63, '2021-01-10 22:11:43', 35, 6, 9, 8, 5),
(64, '2021-01-10 22:18:14', 35, 6, 8, 9, 5),
(65, '2021-01-11 00:07:42', 46, 6, 8, 9, 5),
(66, '2021-01-11 00:10:32', 46, 9, 9, 11, 5),
(68, '2021-01-11 14:40:14', 35, 6, 9, 8, 5),
(70, '2021-01-11 15:18:06', 35, 9, 8, 11, 5),
(77, '2021-01-18 22:47:58', 35, 9, 11, 8, 5),
(78, '2021-01-18 22:54:20', 42, 6, 8, 9, 5),
(79, '2021-01-18 22:55:25', 35, 6, 8, 9, 5),
(80, '2021-01-18 23:27:55', 35, 6, 9, 8, 5),
(81, '2021-01-18 23:30:00', 35, 6, 8, 9, 5),
(82, '2021-02-14 20:59:55', 68, 6, 8, 9, 5),
(83, '2021-02-14 21:00:07', 68, 6, 9, 8, 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `displayName` varchar(255) DEFAULT NULL,
  `contact` int(11) DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `idAccessPoint` int(11) DEFAULT NULL,
  `currentEvent` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`),
  KEY `fkIdx_110` (`idAccessPoint`),
  KEY `fkIdx_123` (`currentEvent`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `displayName`, `contact`, `email`, `status`, `created_at`, `updated_at`, `verification_token`, `idAccessPoint`, `currentEvent`) VALUES
(4, 'Paulo', '2HtLh7Wf3QWq4u2xYc7Qwz0Kzzpo8tS8', '$2y$13$IRCsBT0AiJhlGkkz1QA3g.IMbQvWVoDpJ8db7YOXmAPvM7yxn032e', NULL, 'Paulo Costa', NULL, 'paulo@sapo.pt', 0, 1606157993, 1611597568, 'aPcHsHRJ_td_yPiwxdCeM1dQPm2CDMvt_1606157993', NULL, 4),
(5, 'gocaspro13', 'ligb6J2fkIIvFV1375VKtHFtOBFbTAqV', '$2y$13$5dtBfv9kywTHSutR1oWSvOM.EFG00MmZolgiVlLlylugWuOJnQH9u', NULL, 'Gonçalo Gaspar', 912345678, 'goncalo@mail.pt', 10, 1606174238, 1613413231, 'a2Xl3TCzx2S0nhRvDMTAb2vGDze6q-Iw_1606174238', 6, 5),
(6, 'admin', 'zUEZ7wXr4WPuSe707hhCKZo2z-Etl5av', '$2y$13$GU3M0fRAY0SoNhWXp9kok.JSgD8EiwARoy.s.YHsABzcgjsRsllsW', NULL, 'Administrador', NULL, 'admin@admin.com', 10, 1606230744, 1611598170, 'nOZ6B9wHjX78tqOAPYW14msLVxLOgcDp_1606230744', 9, 5),
(7, 'teste', '5YWCqUOinLW1zFMQXb5esXRX0YWkcQHW', '$2y$13$eIfdCEyAEw.WnsxPeKxXkeqSXYisYCDL/oxA3.ExTFohJQ.96Wg5O', NULL, 'Teste1', NULL, 'teste@teste.teste', 10, 1609254977, 1611598222, 'wExrlqfA5rh-JJz6VXml7u4szG1v55Ii_1609254977', 9, 5);

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `areas`
--
ALTER TABLE `areas`
  ADD CONSTRAINT `FK_158` FOREIGN KEY (`idEvent`) REFERENCES `events` (`id`);

--
-- Limitadores para a tabela `areasaccesspoints`
--
ALTER TABLE `areasaccesspoints`
  ADD CONSTRAINT `fk_idArea_Area_PontoAcesso` FOREIGN KEY (`idArea`) REFERENCES `areas` (`id`),
  ADD CONSTRAINT `fk_idPontoAcesso_Area_PontoAcesso` FOREIGN KEY (`idAccessPoint`) REFERENCES `accesspoints` (`id`);

--
-- Limitadores para a tabela `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limitadores para a tabela `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `carriers`
--
ALTER TABLE `carriers`
  ADD CONSTRAINT `fk_idCredencial_Carregador` FOREIGN KEY (`idCredential`) REFERENCES `credentials` (`id`),
  ADD CONSTRAINT `fk_idTipoCarregador_Carregador` FOREIGN KEY (`idCarrierType`) REFERENCES `carrierstypes` (`id`);

--
-- Limitadores para a tabela `carrierstypes`
--
ALTER TABLE `carrierstypes`
  ADD CONSTRAINT `FK_155` FOREIGN KEY (`idEvent`) REFERENCES `events` (`id`);

--
-- Limitadores para a tabela `credentials`
--
ALTER TABLE `credentials`
  ADD CONSTRAINT `FK_149` FOREIGN KEY (`idEvent`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `fk_idArea_Credencial` FOREIGN KEY (`idCurrentArea`) REFERENCES `areas` (`id`),
  ADD CONSTRAINT `fk_idEntidade_Credencial` FOREIGN KEY (`idEntity`) REFERENCES `entities` (`id`);

--
-- Limitadores para a tabela `entities`
--
ALTER TABLE `entities`
  ADD CONSTRAINT `fk_idTipoEntidade_Entidade` FOREIGN KEY (`idEntityType`) REFERENCES `entitytypes` (`id`);

--
-- Limitadores para a tabela `entitytypeareas`
--
ALTER TABLE `entitytypeareas`
  ADD CONSTRAINT `fk_idArea_TipoEntidade_Area` FOREIGN KEY (`idArea`) REFERENCES `areas` (`id`),
  ADD CONSTRAINT `fk_idTipoEntidade_TipoEntidade_Area` FOREIGN KEY (`idEntityType`) REFERENCES `entitytypes` (`id`);

--
-- Limitadores para a tabela `entitytypes`
--
ALTER TABLE `entitytypes`
  ADD CONSTRAINT `FK_152` FOREIGN KEY (`idEvent`) REFERENCES `events` (`id`);

--
-- Limitadores para a tabela `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `fk-event-default_area` FOREIGN KEY (`default_area`) REFERENCES `areas` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `eventsusers`
--
ALTER TABLE `eventsusers`
  ADD CONSTRAINT `FK_127` FOREIGN KEY (`idEvent`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `FK_143` FOREIGN KEY (`idUsers`) REFERENCES `user` (`id`);

--
-- Limitadores para a tabela `movements`
--
ALTER TABLE `movements`
  ADD CONSTRAINT `FK_195` FOREIGN KEY (`idAreaFrom`) REFERENCES `areas` (`id`),
  ADD CONSTRAINT `FK_198` FOREIGN KEY (`idAreaTo`) REFERENCES `areas` (`id`),
  ADD CONSTRAINT `FK_201` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `fk_idCredencial_Movimento` FOREIGN KEY (`idCredential`) REFERENCES `credentials` (`id`),
  ADD CONSTRAINT `fk_idPontoAcesso_Movimento` FOREIGN KEY (`idAccessPoint`) REFERENCES `accesspoints` (`id`);

--
-- Limitadores para a tabela `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_110` FOREIGN KEY (`idAccessPoint`) REFERENCES `accesspoints` (`id`),
  ADD CONSTRAINT `FK_123` FOREIGN KEY (`currentEvent`) REFERENCES `events` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
