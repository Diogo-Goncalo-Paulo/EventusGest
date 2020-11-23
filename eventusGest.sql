SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS eventusgest;
USE eventusgest;

CREATE TABLE `eventusgest`.`events`
(
 `id`        int NOT NULL AUTO_INCREMENT ,
 `name`      varchar(255) NOT NULL ,
 `startDate` datetime NOT NULL ,
 `endDate`   datetime NOT NULL ,
 `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `updateAt`  timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `deletedAt` timestamp NULL ,

PRIMARY KEY (`id`)
)ENGINE=INNODB;

CREATE TABLE `eventusgest`.`entityTypes`
(
 `id`            int NOT NULL AUTO_INCREMENT ,
 `nome`          varchar(255) NOT NULL ,
 `qtCredenciais` int NOT NULL ,
 `idEvent`       int NOT NULL ,
 `createdAt`     timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `updatedAt`     timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `deletedAt`     timestamp NULL ,

PRIMARY KEY (`id`),
KEY `fkIdx_152` (`idEvent`),
CONSTRAINT `FK_152` FOREIGN KEY `fkIdx_152` (`idEvent`) REFERENCES `eventusgest`.`events` (`id`)
) ENGINE=INNODB;

CREATE TABLE `eventusgest`.`entities`
(
 `id`             int NOT NULL AUTO_INCREMENT ,
 `ueid`           varchar(8) NOT NULL ,
 `nome`           varchar(255) NOT NULL ,
 `idTipoEntidade` int NOT NULL ,
 `createdAt`      timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `updatedAt`      timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `deletedAt`      timestamp NULL ,

PRIMARY KEY (`id`),
KEY `fk_idTipoEntidade_Entidade` (`idTipoEntidade`),
CONSTRAINT `fk_idTipoEntidade_Entidade` FOREIGN KEY `fk_idTipoEntidade_Entidade` (`idTipoEntidade`) REFERENCES `eventusgest`.`entityTypes` (`id`)
) ENGINE=INNODB;

CREATE TABLE `eventusgest`.`areas`
(
 `id`        int NOT NULL AUTO_INCREMENT ,
 `nome`      varchar(255) NOT NULL ,
 `idEvent`   int NOT NULL ,
 `resetTime` time NULL ,
 `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `deletedAt` timestamp NULL ,

PRIMARY KEY (`id`),
KEY `fkIdx_158` (`idEvent`),
CONSTRAINT `FK_158` FOREIGN KEY `fkIdx_158` (`idEvent`) REFERENCES `eventusgest`.`events` (`id`)
) ENGINE=INNODB;

CREATE TABLE `eventusgest`.`accessPoints`
(
 `id`        int NOT NULL AUTO_INCREMENT ,
 `nome`      varchar(255) NOT NULL ,
 `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `deletedAt` timestamp NULL ,

PRIMARY KEY (`id`)
) ENGINE=INNODB;

CREATE TABLE `eventusgest`.`credentials`
(
 `id`            int NOT NULL AUTO_INCREMENT ,
 `ucid`          varchar(8) NOT NULL UNIQUE ,
 `idEntity`      int NOT NULL ,
 `idCurrentArea` int NULL ,
 `idEvent`       int NOT NULL ,
 `flagged`       int NOT NULL DEFAULT 0 ,
 `blocked`       boolean NOT NULL DEFAULT FALSE ,
 `createdAt`     timestamp NOT NULL ,
 `updatedAt`     timestamp NOT NULL ,
 `deletedAt`     timestamp NULL ,

PRIMARY KEY (`id`),
KEY `fk_idArea_Credencial` (`idCurrentArea`),
CONSTRAINT `fk_idArea_Credencial` FOREIGN KEY `fk_idArea_Credencial` (`idCurrentArea`) REFERENCES `eventusgest`.`areas` (`id`),
KEY `fk_idEntidade_Credencial` (`idEntity`),
CONSTRAINT `fk_idEntidade_Credencial` FOREIGN KEY `fk_idEntidade_Credencial` (`idEntity`) REFERENCES `eventusgest`.`entities` (`id`),
KEY `fkIdx_149` (`idEvent`),
CONSTRAINT `FK_149` FOREIGN KEY `fkIdx_149` (`idEvent`) REFERENCES `eventusgest`.`events` (`id`)
) ENGINE=INNODB;

CREATE TABLE `eventusgest`.`AreasAccessPoints`
(
 `idArea`        int NOT NULL ,
 `idPontoAcesso` int NOT NULL ,

PRIMARY KEY (`idArea`, `idPontoAcesso`),
KEY `fk_idArea_Area_PontoAcesso` (`idArea`),
CONSTRAINT `fk_idArea_Area_PontoAcesso` FOREIGN KEY `fk_idArea_Area_PontoAcesso` (`idArea`) REFERENCES `eventusgest`.`areas` (`id`),
KEY `fk_idPontoAcesso_Area_PontoAcesso` (`idPontoAcesso`),
CONSTRAINT `fk_idPontoAcesso_Area_PontoAcesso` FOREIGN KEY `fk_idPontoAcesso_Area_PontoAcesso` (`idPontoAcesso`) REFERENCES `eventusgest`.`accessPoints` (`id`)
) ENGINE=INNODB;


CREATE TABLE `eventusgest`.`carriersTypes`
(
 `id`        int NOT NULL AUTO_INCREMENT ,
 `nome`      varchar(255) NOT NULL ,
 `idEvent`   int NOT NULL ,
 `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `deletedAt` timestamp NULL ,

PRIMARY KEY (`id`),
KEY `fkIdx_155` (`idEvent`),
CONSTRAINT `FK_155` FOREIGN KEY `fkIdx_155` (`idEvent`) REFERENCES `eventusgest`.`events` (`id`)
) ENGINE=INNODB;

CREATE TABLE `eventusgest`.`carriers`
(
 `id`            int NOT NULL AUTO_INCREMENT ,
 `name`          varchar(255) NOT NULL ,
 `info`          varchar(255) NULL ,
 `photo`         varchar(255) NULL ,
 `idCredential`  int NOT NULL ,
 `idCarrierType` int NOT NULL ,
 `createdAt`     timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `updatedAt`     timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `deletedAt`     timestamp NULL ,

PRIMARY KEY (`id`),
KEY `fk_idCredencial_Carregador` (`idCredential`),
CONSTRAINT `fk_idCredencial_Carregador` FOREIGN KEY `fk_idCredencial_Carregador` (`idCredential`) REFERENCES `eventusgest`.`credentials` (`id`),
KEY `fk_idTipoCarregador_Carregador` (`idCarrierType`),
CONSTRAINT `fk_idTipoCarregador_Carregador` FOREIGN KEY `fk_idTipoCarregador_Carregador` (`idCarrierType`) REFERENCES `eventusgest`.`carriersTypes` (`id`)
) ENGINE=INNODB;

CREATE TABLE `eventusgest`.`user`
(
 `id`            int NOT NULL AUTO_INCREMENT ,
 `username`      varchar(255)  COLLATE utf8_unicode_ci NOT NULL,
 `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
 `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
 `displayName`   varchar(255) NULL ,
 `contact`      int NULL ,
 `email`         varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 `status` smallint(6) NOT NULL DEFAULT '10',
 `created_at` int(11) NOT NULL,
 `updated_at` int(11) NOT NULL,
 `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
 `idAccessPoint` int NULL ,
 `currentEvent`  int NULL ,

PRIMARY KEY (`id`),
UNIQUE KEY `username` (`username`),
UNIQUE KEY `email` (`email`),
UNIQUE KEY `password_reset_token` (`password_reset_token`),
KEY `fkIdx_110` (`idAccessPoint`),
CONSTRAINT `FK_110` FOREIGN KEY `fkIdx_110` (`idAccessPoint`) REFERENCES `eventusgest`.`accessPoints` (`id`),
KEY `fkIdx_123` (`currentEvent`),
CONSTRAINT `FK_123` FOREIGN KEY `fkIdx_123` (`currentEvent`) REFERENCES `eventusgest`.`events` (`id`)
) ENGINE=INNODB;

CREATE TABLE `eventusgest`.`eventsUsers`
(
 `idEvent` int NOT NULL ,
 `idUsers` int NOT NULL ,

KEY `fkIdx_127` (`idEvent`),
CONSTRAINT `FK_127` FOREIGN KEY `fkIdx_127` (`idEvent`) REFERENCES `eventusgest`.`events` (`id`),
KEY `fkIdx_143` (`idUsers`),
CONSTRAINT `FK_143` FOREIGN KEY `fkIdx_143` (`idUsers`) REFERENCES `eventusgest`.`user` (`id`)
)ENGINE=INNODB;

CREATE TABLE `eventusgest`.`movements`
(
 `id`            int NOT NULL AUTO_INCREMENT ,
 `time`          timestamp NOT NULL DEFAULT now() ,
 `idCredencial`  int NOT NULL ,
 `idAccessPoint` int NOT NULL ,
 `idAreaFrom`    int NOT NULL ,
 `idAreaTo`      int NOT NULL ,
 `idUser`        int NOT NULL ,

PRIMARY KEY (`id`),
KEY `fk_idCredencial_Movimento` (`idCredencial`),
CONSTRAINT `fk_idCredencial_Movimento` FOREIGN KEY `fk_idCredencial_Movimento` (`idCredencial`) REFERENCES `eventusgest`.`credentials` (`id`),
KEY `fk_idPontoAcesso_Movimento` (`idAccessPoint`),
CONSTRAINT `fk_idPontoAcesso_Movimento` FOREIGN KEY `fk_idPontoAcesso_Movimento` (`idAccessPoint`) REFERENCES `eventusgest`.`accessPoints` (`id`),
KEY `fkIdx_195` (`idAreaFrom`),
CONSTRAINT `FK_195` FOREIGN KEY `fkIdx_195` (`idAreaFrom`) REFERENCES `eventusgest`.`areas` (`id`),
KEY `fkIdx_198` (`idAreaTo`),
CONSTRAINT `FK_198` FOREIGN KEY `fkIdx_198` (`idAreaTo`) REFERENCES `eventusgest`.`areas` (`id`),
KEY `fkIdx_201` (`idUser`),
CONSTRAINT `FK_201` FOREIGN KEY `fkIdx_201` (`idUser`) REFERENCES `eventusgest`.`user` (`id`)
) ENGINE=INNODB;


CREATE TABLE `eventusgest`.`entityTypeAreas`
(
 `idEntityType` int NOT NULL ,
 `idArea`         int NOT NULL ,

PRIMARY KEY (`idEntityType`, `idArea`),
KEY `fk_idArea_TipoEntidade_Area` (`idArea`),
CONSTRAINT `fk_idArea_TipoEntidade_Area` FOREIGN KEY `fk_idArea_TipoEntidade_Area` (`idArea`) REFERENCES `eventusgest`.`areas` (`id`),
KEY `fk_idTipoEntidade_TipoEntidade_Area` (`idEntityType`),
CONSTRAINT `fk_idTipoEntidade_TipoEntidade_Area` FOREIGN KEY `fk_idTipoEntidade_TipoEntidade_Area` (`idEntityType`) REFERENCES `eventusgest`.`entityTypes` (`id`)
) ENGINE=INNODB;

COMMIT;