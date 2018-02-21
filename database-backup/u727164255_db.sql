-- MySQL Script generated by MySQL Workbench
-- Tue Oct 31 09:51:05 2017
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema u727164255_db
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `u727164255_db` ;

-- -----------------------------------------------------
-- Schema u727164255_db
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `u727164255_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `u727164255_db` ;

-- -----------------------------------------------------
-- Table `u727164255_db`.`address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `u727164255_db`.`address` ;

CREATE TABLE IF NOT EXISTS `u727164255_db`.`address` (
  `id_address` INT NOT NULL AUTO_INCREMENT,
  `cep` VARCHAR(9) NOT NULL,
  `number` VARCHAR(45) NOT NULL,
  `public_place` VARCHAR(50) NOT NULL,
  `complement` VARCHAR(50) NULL,
  `neighborhood` VARCHAR(50) NOT NULL,
  `city` VARCHAR(50) NOT NULL,
  `state` VARCHAR(50) NOT NULL,
  `state_uf` VARCHAR(2) NOT NULL,
  `country` VARCHAR(50) NOT NULL DEFAULT 'Brasil',
  PRIMARY KEY (`id_address`),
  UNIQUE INDEX `id_address_UNIQUE` (`id_address` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `u727164255_db`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `u727164255_db`.`user` ;

CREATE TABLE IF NOT EXISTS `u727164255_db`.`user` (
  `id_user` INT NOT NULL AUTO_INCREMENT,
  `cpf` VARCHAR(14) NOT NULL,
  `first_name` VARCHAR(50) NOT NULL,
  `last_name` VARCHAR(50) NOT NULL,
  `birth_date` DATETIME NOT NULL,
  `address` INT NOT NULL,
  INDEX `adress_idx` (`address` ASC),
  PRIMARY KEY (`id_user`),
  UNIQUE INDEX `id_user_UNIQUE` (`id_user` ASC),
  CONSTRAINT `adress`
    FOREIGN KEY (`address`)
    REFERENCES `u727164255_db`.`address` (`id_address`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `u727164255_db`.`profile`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `u727164255_db`.`profile` ;

CREATE TABLE IF NOT EXISTS `u727164255_db`.`profile` (
  `email` VARCHAR(50) NOT NULL,
  `password` VARCHAR(32) NOT NULL,
  `user` INT NOT NULL,
  `create_time` DATETIME NOT NULL,
  PRIMARY KEY (`email`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  INDEX `user_idx` (`user` ASC),
  CONSTRAINT `user`
    FOREIGN KEY (`user`)
    REFERENCES `u727164255_db`.`user` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `u727164255_db`.`category`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `u727164255_db`.`category` ;

CREATE TABLE IF NOT EXISTS `u727164255_db`.`category` (
  `id_category` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id_category`),
  UNIQUE INDEX `id_category_UNIQUE` (`id_category` ASC));


-- -----------------------------------------------------
-- Table `u727164255_db`.`product`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `u727164255_db`.`product` ;

CREATE TABLE IF NOT EXISTS `u727164255_db`.`product` (
  `barcode` VARCHAR(20) NOT NULL,
  `name` VARCHAR(70) NOT NULL,
  `category` INT NOT NULL,
  PRIMARY KEY (`barcode`),
  UNIQUE INDEX `barcode_UNIQUE` (`barcode` ASC),
  INDEX `category_idx` (`category` ASC),
  CONSTRAINT `category`
    FOREIGN KEY (`category`)
    REFERENCES `u727164255_db`.`category` (`id_category`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `u727164255_db`.`change_history`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `u727164255_db`.`change_history` ;

CREATE TABLE IF NOT EXISTS `u727164255_db`.`change_history` (
  `id_change_history` INT NOT NULL AUTO_INCREMENT,
  `date` DATE NOT NULL,
  `description` VARCHAR(500) NOT NULL,
  `quantity` INT NOT NULL,
  PRIMARY KEY (`id_change_history`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `u727164255_db`.`rel_change_history`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `u727164255_db`.`rel_change_history` ;

CREATE TABLE IF NOT EXISTS `u727164255_db`.`rel_change_history` (
  `product_barcode` VARCHAR(20) NOT NULL,
  `change_history_id` INT NOT NULL,
  `profile_email` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`product_barcode`, `change_history_id`, `profile_email`),
  INDEX `fk_product_has_change_history_change_history1_idx` (`change_history_id` ASC),
  INDEX `fk_product_has_change_history_product1_idx` (`product_barcode` ASC),
  INDEX `fk_rel_change_history_profile_email_idx` (`profile_email` ASC),
  CONSTRAINT `fk_rel_change_history_product_barcode`
    FOREIGN KEY (`product_barcode`)
    REFERENCES `u727164255_db`.`product` (`barcode`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_rel_change_history_change_history_id`
    FOREIGN KEY (`change_history_id`)
    REFERENCES `u727164255_db`.`change_history` (`id_change_history`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_rel_change_history_profile_email`
    FOREIGN KEY (`profile_email`)
    REFERENCES `u727164255_db`.`profile` (`email`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `u727164255_db`.`rel_product`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `u727164255_db`.`rel_product` ;

CREATE TABLE IF NOT EXISTS `u727164255_db`.`rel_product` (
  `profile_email` VARCHAR(50) NOT NULL,
  `product_barcode` VARCHAR(20) NOT NULL,
  `quantity` INT NOT NULL,
  `description` VARCHAR(500) NOT NULL,
  PRIMARY KEY (`profile_email`, `product_barcode`),
  INDEX `fk_profile_has_product_product1_idx` (`product_barcode` ASC),
  INDEX `fk_profile_has_product_profile1_idx` (`profile_email` ASC),
  CONSTRAINT `fk_profile_has_product_profile1`
    FOREIGN KEY (`profile_email`)
    REFERENCES `u727164255_db`.`profile` (`email`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_profile_has_product_product1`
    FOREIGN KEY (`product_barcode`)
    REFERENCES `u727164255_db`.`product` (`barcode`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `u727164255_db` ;

-- -----------------------------------------------------
-- Placeholder table for view `u727164255_db`.`Products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `u727164255_db`.`Products` (`barcode` INT, `name` INT, `category_id` INT, `category_name` INT);

-- -----------------------------------------------------
-- Placeholder table for view `u727164255_db`.`Categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `u727164255_db`.`Categories` (`id_category` INT, `name` INT);

-- -----------------------------------------------------
-- View `u727164255_db`.`Products`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `u727164255_db`.`Products` ;
DROP TABLE IF EXISTS `u727164255_db`.`Products`;
USE `u727164255_db`;
CREATE OR REPLACE VIEW `Products` AS
	SELECT P.barcode, P.name, C.id_category as `category_id`, C.name as `category_name`
	FROM  product P
	INNER JOIN category C
	ON C.id_category = P.category;

-- -----------------------------------------------------
-- View `u727164255_db`.`Categories`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `u727164255_db`.`Categories` ;
DROP TABLE IF EXISTS `u727164255_db`.`Categories`;
USE `u727164255_db`;
CREATE  OR REPLACE VIEW `Categories` as
SELECT * FROM category;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `u727164255_db`.`address`
-- -----------------------------------------------------
START TRANSACTION;
USE `u727164255_db`;
INSERT INTO `u727164255_db`.`address` (`id_address`, `cep`, `number`, `public_place`, `complement`, `neighborhood`, `city`, `state`, `state_uf`, `country`) VALUES (1, '50110-605', 'Casa 31', 'Rua Silves', NULL, 'Santo Amaro', 'Recife', 'Pernambuco', 'PE', 'Brasil');
INSERT INTO `u727164255_db`.`address` (`id_address`, `cep`, `number`, `public_place`, `complement`, `neighborhood`, `city`, `state`, `state_uf`, `country`) VALUES (2, '15804-409', 'Apartamento 29', 'Rua Condesa', NULL, 'Residencial Acapulco', 'Catanduva', 'São Paulo', 'SP', 'Brasil');
INSERT INTO `u727164255_db`.`address` (`id_address`, `cep`, `number`, `public_place`, `complement`, `neighborhood`, `city`, `state`, `state_uf`, `country`) VALUES (3, '27275-720', 'Lote 21', 'Servidão G', NULL, 'Jardim Cidade do Aço', 'Volta Redonda', 'Rio de Janeiro', 'RJ', 'Brasil');

COMMIT;


-- -----------------------------------------------------
-- Data for table `u727164255_db`.`user`
-- -----------------------------------------------------
START TRANSACTION;
USE `u727164255_db`;
INSERT INTO `u727164255_db`.`user` (`id_user`, `cpf`, `first_name`, `last_name`, `birth_date`, `address`) VALUES (1, '163.340.734-94', 'Francisco', 'Matheus de Paula', '2011-12-31', 1);
INSERT INTO `u727164255_db`.`user` (`id_user`, `cpf`, `first_name`, `last_name`, `birth_date`, `address`) VALUES (2, '552.783.603-05', 'Diego', 'Augusto Barros', '2011-12-31', 2);
INSERT INTO `u727164255_db`.`user` (`id_user`, `cpf`, `first_name`, `last_name`, `birth_date`, `address`) VALUES (3, '357.910.080-74', 'Thiago', 'Renato Carvalho', '2011-12-31', 3);

COMMIT;


-- -----------------------------------------------------
-- Data for table `u727164255_db`.`profile`
-- -----------------------------------------------------
START TRANSACTION;
USE `u727164255_db`;
INSERT INTO `u727164255_db`.`profile` (`email`, `password`, `user`, `create_time`) VALUES ('chico@hotmail.com', '698dc19d489c4e4db73e28a713eab07b', 1, '2017-08-29 13:08:15');
INSERT INTO `u727164255_db`.`profile` (`email`, `password`, `user`, `create_time`) VALUES ('diego.kkk@gmail.com', '698dc19d489c4e4db73e28a713eab07b', 2, '2017-08-29 15:41:29');
INSERT INTO `u727164255_db`.`profile` (`email`, `password`, `user`, `create_time`) VALUES ('thigho.topzera@yahoo.com.br', '698dc19d489c4e4db73e28a713eab07b', 3, '2017-08-29 19:23:33');

COMMIT;


-- -----------------------------------------------------
-- Data for table `u727164255_db`.`category`
-- -----------------------------------------------------
START TRANSACTION;
USE `u727164255_db`;
INSERT INTO `u727164255_db`.`category` (`id_category`, `name`) VALUES (1, 'Alimento');
INSERT INTO `u727164255_db`.`category` (`id_category`, `name`) VALUES (2, 'Bebida');
INSERT INTO `u727164255_db`.`category` (`id_category`, `name`) VALUES (3, 'Brinquedo');
INSERT INTO `u727164255_db`.`category` (`id_category`, `name`) VALUES (4, 'Roupa');
INSERT INTO `u727164255_db`.`category` (`id_category`, `name`) VALUES (DEFAULT, 'Remédio');

COMMIT;


-- -----------------------------------------------------
-- Data for table `u727164255_db`.`product`
-- -----------------------------------------------------
START TRANSACTION;
USE `u727164255_db`;
INSERT INTO `u727164255_db`.`product` (`barcode`, `name`, `category`) VALUES ('123456789012', 'Doritos', 1);
INSERT INTO `u727164255_db`.`product` (`barcode`, `name`, `category`) VALUES ('123456789013', 'Fandangos Presunto', 1);
INSERT INTO `u727164255_db`.`product` (`barcode`, `name`, `category`) VALUES ('555444332221', 'Coca-Cola', 2);
INSERT INTO `u727164255_db`.`product` (`barcode`, `name`, `category`) VALUES ('568754456745', 'Hand Spinner', 3);

COMMIT;


-- -----------------------------------------------------
-- Data for table `u727164255_db`.`change_history`
-- -----------------------------------------------------
START TRANSACTION;
USE `u727164255_db`;
INSERT INTO `u727164255_db`.`change_history` (`id_change_history`, `date`, `description`, `quantity`) VALUES (1, '2017-08-29 15:29:01', 'Adicionou o produto', 10);
INSERT INTO `u727164255_db`.`change_history` (`id_change_history`, `date`, `description`, `quantity`) VALUES (2, '2017-08-29 15:32:16', 'Adicionou o produto', 7);
INSERT INTO `u727164255_db`.`change_history` (`id_change_history`, `date`, `description`, `quantity`) VALUES (3, '2017-08-29 15:49:35', 'Adicionou o produto', 17);
INSERT INTO `u727164255_db`.`change_history` (`id_change_history`, `date`, `description`, `quantity`) VALUES (4, '2017-10-18 18:19:43', 'Adicionou o produto', 5);
INSERT INTO `u727164255_db`.`change_history` (`id_change_history`, `date`, `description`, `quantity`) VALUES (5, '2017-10-18 21:03:21', 'Adicionou o produto', 8);
INSERT INTO `u727164255_db`.`change_history` (`id_change_history`, `date`, `description`, `quantity`) VALUES (6, '2017-10-18 21:07:53', 'Consumiu', 7);

COMMIT;


-- -----------------------------------------------------
-- Data for table `u727164255_db`.`rel_change_history`
-- -----------------------------------------------------
START TRANSACTION;
USE `u727164255_db`;
INSERT INTO `u727164255_db`.`rel_change_history` (`product_barcode`, `change_history_id`, `profile_email`) VALUES ('123456789012', 1, 'chico@hotmail.com');
INSERT INTO `u727164255_db`.`rel_change_history` (`product_barcode`, `change_history_id`, `profile_email`) VALUES ('555444332221', 2, 'diego.kkk@gmail.com');
INSERT INTO `u727164255_db`.`rel_change_history` (`product_barcode`, `change_history_id`, `profile_email`) VALUES ('568754456745', 3, 'thigho.topzera@yahoo.com.br');
INSERT INTO `u727164255_db`.`rel_change_history` (`product_barcode`, `change_history_id`, `profile_email`) VALUES ('123456789013', 4, 'chico@hotmail.com');
INSERT INTO `u727164255_db`.`rel_change_history` (`product_barcode`, `change_history_id`, `profile_email`) VALUES ('555444332221', 5, 'chico@hotmail.com');
INSERT INTO `u727164255_db`.`rel_change_history` (`product_barcode`, `change_history_id`, `profile_email`) VALUES ('555444332221', 6, 'chico@hotmail.com');

COMMIT;


-- -----------------------------------------------------
-- Data for table `u727164255_db`.`rel_product`
-- -----------------------------------------------------
START TRANSACTION;
USE `u727164255_db`;
INSERT INTO `u727164255_db`.`rel_product` (`profile_email`, `product_barcode`, `quantity`, `description`) VALUES ('chico@hotmail.com', '123456789012', 10, 'Salgadinho de Tortilla');
INSERT INTO `u727164255_db`.`rel_product` (`profile_email`, `product_barcode`, `quantity`, `description`) VALUES ('diego.kkk@gmail.com', '555444332221', 7, 'Refrigerante de Cola');
INSERT INTO `u727164255_db`.`rel_product` (`profile_email`, `product_barcode`, `quantity`, `description`) VALUES ('thigho.topzera@yahoo.com.br', '568754456745', 17, 'Brinquedo Inútil');
INSERT INTO `u727164255_db`.`rel_product` (`profile_email`, `product_barcode`, `quantity`, `description`) VALUES ('chico@hotmail.com', '123456789013', 5, 'Salgadinho de Presunto');
INSERT INTO `u727164255_db`.`rel_product` (`profile_email`, `product_barcode`, `quantity`, `description`) VALUES ('chico@hotmail.com', '555444332221', 7, 'Refrigerante de Cola');

COMMIT;

USE `u727164255_db`;

DELIMITER $$

USE `u727164255_db`$$
DROP TRIGGER IF EXISTS `u727164255_db`.`profile_BEFORE_INSERT` $$
USE `u727164255_db`$$
CREATE DEFINER = CURRENT_USER TRIGGER `u727164255_db`.`profile_BEFORE_INSERT` BEFORE INSERT ON `profile` FOR EACH ROW
BEGIN
set new.create_time=curdate();
set new.password = md5(new.password);
END$$


USE `u727164255_db`$$
DROP TRIGGER IF EXISTS `u727164255_db`.`profile_BEFORE_UPDATE` $$
USE `u727164255_db`$$
CREATE DEFINER = CURRENT_USER TRIGGER `u727164255_db`.`profile_BEFORE_UPDATE` BEFORE UPDATE ON `profile` FOR EACH ROW
BEGIN
set new.password = md5(new.password);
END
$$


USE `u727164255_db`$$
DROP TRIGGER IF EXISTS `u727164255_db`.`change_history_BEFORE_INSERT` $$
USE `u727164255_db`$$
CREATE DEFINER = CURRENT_USER TRIGGER `u727164255_db`.`change_history_BEFORE_INSERT` BEFORE INSERT ON `change_history` FOR EACH ROW
BEGIN
set new.date=now();
END$$


DELIMITER ;
