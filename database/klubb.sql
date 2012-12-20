SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `klubb` DEFAULT CHARACTER SET utf8 ;
USE `klubb` ;

-- -----------------------------------------------------
-- Table `klubb`.`users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `klubb`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `email` VARCHAR(65) NOT NULL ,
  `password` VARCHAR(40) NOT NULL ,
  `phone` VARCHAR(12) NULL ,
  `key` VARCHAR(32) NOT NULL COMMENT 'The encryption key, encrypted using the users password.' ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `klubb`.`types`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `klubb`.`types` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `desc` VARCHAR(65) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `klubb`.`member_data`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `klubb`.`member_data` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `klubb`.`members`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `klubb`.`members` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `type` INT NULL ,
  `firstname` VARCHAR(45) NOT NULL ,
  `lastname` VARCHAR(45) NOT NULL ,
  `ssid` VARCHAR(12) NOT NULL ,
  `phone` VARCHAR(12) NOT NULL ,
  `address` VARCHAR(45) NULL ,
  `zip` VARCHAR(10) NULL ,
  `city` VARCHAR(45) NULL ,
  `data` INT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `type`
    FOREIGN KEY (`type` )
    REFERENCES `klubb`.`types` (`id` )
    ON DELETE SET NULL
    ON UPDATE NO ACTION,
  CONSTRAINT `data`
    FOREIGN KEY (`data` )
    REFERENCES `klubb`.`member_data` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `type` ON `klubb`.`members` (`type` ASC) ;

CREATE INDEX `data` ON `klubb`.`members` (`data` ASC) ;


-- -----------------------------------------------------
-- Table `klubb`.`roles`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `klubb`.`roles` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `klubb`.`rights`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `klubb`.`rights` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `role` INT NOT NULL ,
  `add_members` TINYINT(1) NOT NULL DEFAULT 0 ,
  `add_users` TINYINT(1) NOT NULL DEFAULT 0 ,
  `use_system` TINYINT(1) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `role`
    FOREIGN KEY (`role` )
    REFERENCES `klubb`.`roles` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `role` ON `klubb`.`rights` (`role` ASC) ;


-- -----------------------------------------------------
-- Table `klubb`.`user_role`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `klubb`.`user_role` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user` INT NOT NULL ,
  `role` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `user`
    FOREIGN KEY (`user` )
    REFERENCES `klubb`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `role`
    FOREIGN KEY (`role` )
    REFERENCES `klubb`.`roles` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `user` ON `klubb`.`user_role` (`user` ASC) ;

CREATE INDEX `role` ON `klubb`.`user_role` (`role` ASC) ;


-- -----------------------------------------------------
-- Table `klubb`.`system`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `klubb`.`system` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `key` VARCHAR(45) NOT NULL ,
  `value` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

CREATE UNIQUE INDEX `key_UNIQUE` ON `klubb`.`system` (`key` ASC) ;


-- -----------------------------------------------------
-- Table `klubb`.`log`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `klubb`.`log` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user` INT NOT NULL ,
  `action` VARCHAR(45) NOT NULL ,
  `path` VARCHAR(100) NOT NULL ,
  `time` TIMESTAMP NOT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `user`
    FOREIGN KEY (`user` )
    REFERENCES `klubb`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `user` ON `klubb`.`log` (`user` ASC) ;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `klubb`.`system`
-- -----------------------------------------------------
START TRANSACTION;
USE `klubb`;
INSERT INTO `klubb`.`system` (`id`, `key`, `value`) VALUES (NULL, 'language', 'swedish');

COMMIT;
