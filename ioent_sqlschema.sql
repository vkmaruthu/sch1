-- smartFactory OEE Database Design
-- Version 1.0 / Release 1.0
-- EIM Solutions
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema ioentdb_sfs
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `ioentdb_sfs` ;

-- -----------------------------------------------------
-- Schema ioentdb_sfs
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `ioentdb_sfs` DEFAULT CHARACTER SET latin1 ;
USE `ioentdb_sfs` ;

-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_alerts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_alerts` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_alerts` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `message` VARCHAR(45) NULL DEFAULT NULL,
  `color_code` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_equipment_model`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_equipment_model` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_equipment_model` (
  `id` INT(11) NOT NULL,
  `name` VARCHAR(12) NULL DEFAULT NULL,
  `num_of_di` INT(11) NULL DEFAULT NULL,
  `num_of_do` INT(11) NULL DEFAULT NULL,
  `num_of_ai` INT(11) NULL DEFAULT NULL,
  `num_of_ao` INT(11) NULL DEFAULT NULL,
  UNIQUE INDEX `name_UNIQUE` (`name` ASC),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_equipment_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_equipment_type` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_equipment_type` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `descp` VARCHAR(20) NULL DEFAULT NULL,
  `is_machine` TINYINT(4) NOT NULL DEFAULT '0',
  `is_afs_size_id` TINYINT(4) NOT NULL DEFAULT '0',
  `is_dc_po` TINYINT(4) NOT NULL DEFAULT '0',
  `is_tool` TINYINT(4) NOT NULL DEFAULT '0',
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_reason_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_reason_type` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_reason_type` (
  `id` INT(11) NOT NULL,
  `message` VARCHAR(45) NULL DEFAULT NULL,
  `color_code` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_reason_code`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_reason_code` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_reason_code` (
  `id` INT(11) NOT NULL,
  `message` VARCHAR(45) NULL DEFAULT NULL,
  `color_code` VARCHAR(45) NULL DEFAULT NULL,
  `reason_type_id` INT(11) NOT NULL,
  PRIMARY KEY (`reason_type_id`),
  INDEX `fk_sfs_reason_code_sfs_reason_type1_idx` (`reason_type_id` ASC),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  CONSTRAINT `fk_sfs_reason_code_sfs_reason_type1`
    FOREIGN KEY (`reason_type_id`)
    REFERENCES `ioentdb_sfs`.`sfs_reason_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_company`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_company` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_company` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(4) NULL DEFAULT NULL,
  `descp` VARCHAR(40) NULL DEFAULT NULL,
  `address` TEXT NULL DEFAULT NULL,
  `contact_person` VARCHAR(40) NULL DEFAULT NULL,
  `contact_number` VARCHAR(20) NULL DEFAULT NULL,
  `image_file_name` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `company` (`code` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_plant`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_plant` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_plant` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(8) NOT NULL,
  `descp` VARCHAR(30) NOT NULL,
  `address` TEXT NULL DEFAULT NULL,
  `contact_person` VARCHAR(40) NULL DEFAULT NULL,
  `contact_number` VARCHAR(20) NULL DEFAULT NULL,
  `latitude` DOUBLE NULL DEFAULT NULL,
  `longitude` DOUBLE NULL DEFAULT NULL,
  `image_file_name` TEXT NOT NULL,
  `comp_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`, `comp_id`),
  UNIQUE INDEX `comp_id` (`code` ASC),
  INDEX `fk_sfs_plant_details_sfs_comp_details1_idx` (`comp_id` ASC),
  CONSTRAINT `fk_sfs_plant_details_sfs_comp_details1`
    FOREIGN KEY (`comp_id`)
    REFERENCES `ioentdb_sfs`.`sfs_company` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_workcenter`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_workcenter` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_workcenter` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(8) NULL DEFAULT NULL,
  `descp` VARCHAR(40) NULL DEFAULT NULL,
  `contact_person` VARCHAR(40) NULL DEFAULT NULL,
  `contact_number` VARCHAR(20) NULL DEFAULT NULL,
  `image_file_name` TEXT NOT NULL,
  `plant_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`, `plant_id`),
  UNIQUE INDEX `plant_id` (`code` ASC),
  INDEX `fk_sfs_unit_details_sfs_plant_details1_idx` (`plant_id` ASC),
  CONSTRAINT `fk_sfs_unit_details_sfs_plant_details1`
    FOREIGN KEY (`plant_id`)
    REFERENCES `ioentdb_sfs`.`sfs_plant` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_equipment_protocol`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_equipment_protocol` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_equipment_protocol` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `descp` TEXT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_equipment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_equipment` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_equipment` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(45) NOT NULL,
  `descp` VARCHAR(30) NULL DEFAULT NULL,
  `wc_id` INT(11) NOT NULL,
  `mac_id` VARCHAR(20) NULL DEFAULT NULL,
  `protocol_id` INT NOT NULL,
  `order_id` INT(11) NULL DEFAULT '0',
  `line_feed_qty` INT(11) NULL DEFAULT NULL,
  `type_id` INT(11) NOT NULL,
  `model_id` INT(11) NOT NULL,
  `conn_state` INT(11) NULL DEFAULT '0',
  `reason_code_id` INT(11) NULL DEFAULT NULL,
  `reason_code_arr` VARCHAR(100) NULL DEFAULT '0',
  `is_eq_details_updated` INT(1) NULL DEFAULT '1',
  `is_prod_list_updated` INT(1) NULL DEFAULT '1',
  `is_employee_details_updated` INT(1) NULL DEFAULT '1',
  `is_company_detail_updated` INT(1) NULL DEFAULT '0',
  `is_style_image_updated` INT(1) NULL DEFAULT '1',
  `ton` INT(11) NOT NULL DEFAULT '0',
  `maint_count` INT(11) NOT NULL DEFAULT '0',
  `stroke_before_maint` INT(11) NOT NULL DEFAULT '0',
  `stroke_after_maint` INT(11) NOT NULL DEFAULT '0',
  `last_maint_timestamp` DATETIME NULL DEFAULT NULL,
  `cur_date_time` DATETIME NULL DEFAULT NULL,
  `maint_alert_sent` TINYINT(1) NOT NULL DEFAULT '0',
  `image_file_name` TEXT NULL DEFAULT NULL,
  PRIMARY KEY (`code`, `wc_id`),
  UNIQUE INDEX `eq_code_UNIQUE` (`code` ASC),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_sfs_equipment_sfs_equipment_type1_idx` (`type_id` ASC),
  INDEX `fk_sfs_equipment_sfs_reason_code1_idx` (`reason_code_id` ASC),
  INDEX `fk_sfs_equipment_sfs_workcenter1_idx` (`wc_id` ASC),
  INDEX `fk_sfs_equipment_sfs_equipment_model1_idx` (`model_id` ASC),
  INDEX `fk_sfs_equipment_sfs_equipment_protocol1_idx` (`protocol_id` ASC),
  CONSTRAINT `fk_sfs_equipment_sfs_equipment_model1`
    FOREIGN KEY (`model_id`)
    REFERENCES `ioentdb_sfs`.`sfs_equipment_model` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_equipment_sfs_equipment_type1`
    FOREIGN KEY (`type_id`)
    REFERENCES `ioentdb_sfs`.`sfs_equipment_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_equipment_sfs_reason_code1`
    FOREIGN KEY (`reason_code_id`)
    REFERENCES `ioentdb_sfs`.`sfs_reason_code` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_equipment_sfs_workcenter1`
    FOREIGN KEY (`wc_id`)
    REFERENCES `ioentdb_sfs`.`sfs_workcenter` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_equipment_sfs_equipment_protocol1`
    FOREIGN KEY (`protocol_id`)
    REFERENCES `ioentdb_sfs`.`sfs_equipment_protocol` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_status`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_status` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_status` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `message` VARCHAR(45) NULL DEFAULT NULL,
  `color_code` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_alert_log`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_alert_log` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_alert_log` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `alert_id` INT(11) NOT NULL,
  `message` TEXT NULL DEFAULT NULL,
  `tool_id` BIGINT(20) NULL DEFAULT NULL,
  `status_id` INT(11) NOT NULL,
  `created_time` VARCHAR(45) NULL DEFAULT NULL,
  `last_updated_time` VARCHAR(45) NULL DEFAULT NULL,
  `last_updated_by` VARCHAR(45) NULL DEFAULT NULL,
  `remark` TEXT NULL DEFAULT NULL,
  `eq_code` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`, `alert_id`, `status_id`, `eq_code`),
  INDEX `fk_sfs_alert_log_sfs_alerts1_idx` (`alert_id` ASC),
  INDEX `fk_sfs_alert_log_sfs_status1_idx` (`status_id` ASC),
  INDEX `fk_sfs_alert_log_sfs_equipment1_idx` (`eq_code` ASC),
  CONSTRAINT `fk_sfs_alert_log_sfs_alerts1`
    FOREIGN KEY (`alert_id`)
    REFERENCES `ioentdb_sfs`.`sfs_alerts` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_alert_log_sfs_equipment1`
    FOREIGN KEY (`eq_code`)
    REFERENCES `ioentdb_sfs`.`sfs_equipment` (`code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_alert_log_sfs_status1`
    FOREIGN KEY (`status_id`)
    REFERENCES `ioentdb_sfs`.`sfs_status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_contract_info`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_contract_info` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_contract_info` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `created_date` DATETIME NULL DEFAULT NULL,
  `start_date` DATETIME NULL DEFAULT NULL,
  `no_of_days` INT(11) NULL DEFAULT NULL,
  `is_active` TINYINT(4) NULL DEFAULT NULL,
  `message` TEXT NULL DEFAULT NULL,
  `company_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`, `company_id`),
  UNIQUE INDEX `company_id_UNIQUE` (`company_id` ASC),
  INDEX `fk_3_sfs_company1_idx` (`company_id` ASC),
  CONSTRAINT `fk_3_sfs_company1`
    FOREIGN KEY (`company_id`)
    REFERENCES `ioentdb_sfs`.`sfs_company` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_part_fg`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_part_fg` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_part_fg` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `number` VARCHAR(20) NOT NULL,
  `descp` VARCHAR(30) NOT NULL,
  `plant_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`, `plant_id`),
  INDEX `fk_sfs_part_fg_sfs_plant1_idx` (`plant_id` ASC),
  CONSTRAINT `fk_sfs_part_fg_sfs_plant1`
    FOREIGN KEY (`plant_id`)
    REFERENCES `ioentdb_sfs`.`sfs_plant` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_tool_opr_id_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_tool_opr_id_type` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_tool_opr_id_type` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(40) NULL DEFAULT NULL,
  `descp` VARCHAR(50) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_tool_opr`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_tool_opr` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_tool_opr` (
  `tag_id` VARCHAR(40) NOT NULL COMMENT 'Combination of <comapny code>:<plant code>:<tag value>',
  `number` VARCHAR(100) NULL,
  `name` VARCHAR(20) NOT NULL DEFAULT 'Undefined',
  `descp` VARCHAR(40) NOT NULL DEFAULT 'Undefined',
  `eq_code` VARCHAR(45) NULL DEFAULT NULL,
  `part_fg_id` INT(11) NOT NULL,
  `is_present` INT(1) NOT NULL DEFAULT '0',
  `is_connected` INT(1) NOT NULL DEFAULT '0',
  `is_active` BIT(1) NOT NULL DEFAULT b'1',
  `prev_distance` INT(11) NOT NULL DEFAULT '0',
  `cur_distance` INT(11) NOT NULL DEFAULT '0',
  `time_last_reboot` DOUBLE NULL DEFAULT NULL,
  `cur_date_time` DATETIME NULL DEFAULT NULL,
  `ton` INT(11) NOT NULL DEFAULT '0',
  `maint_count` INT(11) NOT NULL DEFAULT '0',
  `lifetime_count` INT(11) NOT NULL DEFAULT '0',
  `stroke_before_maint` INT(11) NOT NULL DEFAULT '0',
  `stroke_after_maint` INT(11) NOT NULL DEFAULT '0',
  `maint_alert_sent` TINYINT(1) NOT NULL DEFAULT '0',
  `last_maint_timestamp` DATETIME NULL DEFAULT NULL,
  `namespace` VARCHAR(40) NULL DEFAULT NULL,
  `instance` VARCHAR(14) NOT NULL DEFAULT '0',
  `image_file_name` TEXT NULL DEFAULT NULL,
  `bm_setup_time` INT(11) NULL DEFAULT '0' COMMENT 'benchmark setup time',
  `bm_prod_time` DOUBLE NULL DEFAULT '0' COMMENT 'benchmark production time',
  `tool_opr_type_id` INT(11) NOT NULL,
  `no_of_items_per_oper` INT NULL DEFAULT 0,
  PRIMARY KEY (`tag_id`),
  UNIQUE INDEX `id_UNIQUE` (`tag_id` ASC),
  INDEX `fk_sfs_tool_sfs_parts1_idx` (`part_fg_id` ASC),
  INDEX `fk_sfs_tool_sfs_equipment1_idx` (`eq_code` ASC),
  INDEX `fk_sfs_tool_opr_sfs_tool_opr_id_type1_idx` (`tool_opr_type_id` ASC),
  CONSTRAINT `fk_sfs_tool_sfs_equipment1`
    FOREIGN KEY (`eq_code`)
    REFERENCES `ioentdb_sfs`.`sfs_equipment` (`code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_tool_sfs_parts1`
    FOREIGN KEY (`part_fg_id`)
    REFERENCES `ioentdb_sfs`.`sfs_part_fg` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_tool_opr_sfs_tool_opr_id_type1`
    FOREIGN KEY (`tool_opr_type_id`)
    REFERENCES `ioentdb_sfs`.`sfs_tool_opr_id_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_designation`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_designation` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_designation` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `descp` VARCHAR(45) NULL DEFAULT NULL,
  `created_on` TIMESTAMP NULL DEFAULT NULL,
  UNIQUE INDEX `name_UNIQUE` (`name` ASC),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_opr_department`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_opr_department` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_opr_department` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(8) NULL DEFAULT NULL,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `descp` VARCHAR(100) NULL DEFAULT NULL,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_skill`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_skill` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_skill` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `descp` VARCHAR(100) NULL DEFAULT NULL,
  `created_on` TIMESTAMP NULL DEFAULT NULL,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_operators`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_operators` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_operators` (
  `id` VARCHAR(8) NOT NULL COMMENT 'Employee registered ID',
  `code` VARCHAR(45) NULL COMMENT 'RFID, Barcode etc',
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `type` VARCHAR(1) NULL DEFAULT NULL,
  `plant_id` INT(11) NOT NULL,
  `workcenter_id` INT(11) NOT NULL,
  `department_id` INT(11) NOT NULL,
  `contractor` VARCHAR(1) NULL DEFAULT NULL,
  `designation_id` INT(11) NOT NULL,
  `skill_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `employee_id_UNIQUE` (`id` ASC),
  INDEX `fk_sfs_operators_sfs_plant1_idx` (`plant_id` ASC),
  INDEX `fk_sfs_operators_sfs_workcenter1_idx` (`workcenter_id` ASC),
  INDEX `fk_sfs_operators_sfs_opr_department1_idx` (`department_id` ASC),
  INDEX `fk_sfs_operators_sfs_skills1_idx` (`skill_id` ASC),
  INDEX `fk_sfs_operators_sfs_designation1_idx` (`designation_id` ASC),
  UNIQUE INDEX `code_UNIQUE` (`code` ASC),
  CONSTRAINT `fk_sfs_operators_sfs_designation1`
    FOREIGN KEY (`designation_id`)
    REFERENCES `ioentdb_sfs`.`sfs_designation` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_operators_sfs_opr_department1`
    FOREIGN KEY (`department_id`)
    REFERENCES `ioentdb_sfs`.`sfs_opr_department` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_operators_sfs_plant1`
    FOREIGN KEY (`plant_id`)
    REFERENCES `ioentdb_sfs`.`sfs_plant` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_operators_sfs_skills1`
    FOREIGN KEY (`skill_id`)
    REFERENCES `ioentdb_sfs`.`sfs_skill` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_operators_sfs_workcenter1`
    FOREIGN KEY (`workcenter_id`)
    REFERENCES `ioentdb_sfs`.`sfs_workcenter` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_data_info`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_data_info` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_data_info` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `operators_id` VARCHAR(8) NOT NULL,
  `order_id` INT(11) NULL DEFAULT NULL,
  `equipment_type_id` INT(11) NOT NULL,
  `eq_code` VARCHAR(45) NOT NULL,
  `tag_id` VARCHAR(40) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `ru_id` (`order_id` ASC),
  UNIQUE INDEX `size_id_UNIQUE` (`order_id` ASC),
  INDEX `fk_sfs_data_info_sfs_equipment1_idx` (`eq_code` ASC),
  INDEX `fk_sfs_data_info_sfs_equipment_type1_idx` (`equipment_type_id` ASC),
  INDEX `fk_sfs_data_info_sfs_tool_opr1_idx` (`tag_id` ASC),
  UNIQUE INDEX `tag_id_UNIQUE` (`tag_id` ASC),
  UNIQUE INDEX `eq_code_UNIQUE` (`eq_code` ASC),
  UNIQUE INDEX `equipment_type_id_UNIQUE` (`equipment_type_id` ASC),
  INDEX `fk_sfs_data_info_sfs_operators1_idx` (`operators_id` ASC),
  UNIQUE INDEX `operators_id_UNIQUE` (`operators_id` ASC),
  CONSTRAINT `fk_sfs_data_info_sfs_equipment1`
    FOREIGN KEY (`eq_code`)
    REFERENCES `ioentdb_sfs`.`sfs_equipment` (`code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_data_info_sfs_equipment_type1`
    FOREIGN KEY (`equipment_type_id`)
    REFERENCES `ioentdb_sfs`.`sfs_equipment_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_data_info_sfs_tool_opr1`
    FOREIGN KEY (`tag_id`)
    REFERENCES `ioentdb_sfs`.`sfs_tool_opr` (`tag_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_data_info_sfs_operators1`
    FOREIGN KEY (`operators_id`)
    REFERENCES `ioentdb_sfs`.`sfs_operators` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_quality_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_quality_type` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_quality_type` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `message` VARCHAR(45) NOT NULL,
  UNIQUE INDEX `message` (`message` ASC),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_quality_codes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_quality_codes` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_quality_codes` (
  `id` INT(11) NOT NULL,
  `reason_message` VARCHAR(40) NOT NULL,
  `color_code` VARCHAR(40) NOT NULL,
  `quality_type_id` INT(11) NOT NULL,
  PRIMARY KEY (`quality_type_id`),
  INDEX `fk_sfs_quality_codes_sfs_quality_type1_idx` (`quality_type_id` ASC),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  CONSTRAINT `fk_sfs_quality_codes_sfs_quality_type1`
    FOREIGN KEY (`quality_type_id`)
    REFERENCES `ioentdb_sfs`.`sfs_quality_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_data`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_data` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_data` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `component_number` INT(11) NOT NULL,
  `start_time` DATETIME NOT NULL,
  `end_time` DATETIME NOT NULL,
  `count` INT(11) NOT NULL DEFAULT '0',
  `is_latest` INT(11) NOT NULL,
  `is_updated` INT(11) NOT NULL DEFAULT '0',
  `quality_codes_id` INT(11) NOT NULL,
  `data_info_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`, `quality_codes_id`, `data_info_id`),
  UNIQUE INDEX `data_info_id` (`component_number` ASC, `start_time` ASC, `end_time` ASC),
  INDEX `fk_sfs_data_sfs_quality_codes1_idx` (`quality_codes_id` ASC),
  INDEX `fk_sfs_data_sfs_data_info1_idx` (`data_info_id` ASC),
  CONSTRAINT `fk_sfs_data_sfs_data_info1`
    FOREIGN KEY (`data_info_id`)
    REFERENCES `ioentdb_sfs`.`sfs_data_info` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_data_sfs_quality_codes1`
    FOREIGN KEY (`quality_codes_id`)
    REFERENCES `ioentdb_sfs`.`sfs_quality_codes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_data_hourly`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_data_hourly` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_data_hourly` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `cur_date` DATE NOT NULL,
  `shift_date` DATE NOT NULL,
  `H1` INT(11) NOT NULL,
  `H2` INT(11) NOT NULL,
  `H3` INT(11) NOT NULL,
  `H4` INT(11) NOT NULL,
  `H5` INT(11) NOT NULL,
  `H6` INT(11) NOT NULL,
  `H7` INT(11) NOT NULL,
  `H8` INT(11) NOT NULL,
  `H9` INT(11) NOT NULL,
  `H10` INT(11) NOT NULL,
  `H11` INT(11) NOT NULL,
  `H12` INT(11) NOT NULL,
  `H13` INT(11) NOT NULL,
  `H14` INT(11) NOT NULL,
  `H15` INT(11) NOT NULL,
  `H16` INT(11) NOT NULL,
  `H17` INT(11) NOT NULL,
  `H18` INT(11) NOT NULL,
  `H19` INT(11) NOT NULL,
  `H20` INT(11) NOT NULL,
  `H21` INT(11) NOT NULL,
  `H22` INT(11) NOT NULL,
  `H23` INT(11) NOT NULL,
  `H24` INT(11) NOT NULL,
  `data_info_id` INT(11) NOT NULL,
  `quality_codes_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`, `data_info_id`, `quality_codes_id`),
  UNIQUE INDEX `cur_date` (`cur_date` ASC, `shift_date` ASC),
  INDEX `fk_sfs_data_hourly_sfs_data_info1_idx` (`data_info_id` ASC),
  INDEX `fk_sfs_data_hourly_sfs_quality_codes1_idx` (`quality_codes_id` ASC),
  CONSTRAINT `fk_sfs_data_hourly_sfs_data_info1`
    FOREIGN KEY (`data_info_id`)
    REFERENCES `ioentdb_sfs`.`sfs_data_info` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_data_hourly_sfs_quality_codes1`
    FOREIGN KEY (`quality_codes_id`)
    REFERENCES `ioentdb_sfs`.`sfs_quality_codes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_dc_po`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_dc_po` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_dc_po` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `order_number` VARCHAR(20) NOT NULL,
  `operation` VARCHAR(11) NOT NULL,
  `material` VARCHAR(11) NOT NULL,
  `target_qty` INT(11) NOT NULL,
  `line_feed_qty` INT(11) NOT NULL,
  `no_of_conf` INT(11) NOT NULL,
  `conf_yield_count` INT(11) NOT NULL,
  `conf_scarp_count` INT(11) NOT NULL,
  `is_final_confirmed` TINYINT(4) NOT NULL,
  `plant_id` INT(11) NOT NULL,
  `eq_code` VARCHAR(45) NULL DEFAULT NULL,
  `conf_no` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `order_number` (`order_number` ASC, `operation` ASC, `plant_id` ASC),
  INDEX `fk_sfs_dc_po_sfs_plant1_idx` USING BTREE (`plant_id` ASC),
  INDEX `fk_sfs_dc_po_sfs_equipment1_idx` USING BTREE (`eq_code` ASC),
  UNIQUE INDEX `eq_code` (`eq_code` ASC),
  CONSTRAINT `fk_sfs_dc_po_sfs_equipment1`
    FOREIGN KEY (`eq_code`)
    REFERENCES `ioentdb_sfs`.`sfs_equipment` (`code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_dc_po_sfs_plant1`
    FOREIGN KEY (`plant_id`)
    REFERENCES `ioentdb_sfs`.`sfs_plant` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 19
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_dc_poc_queue`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_dc_poc_queue` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_dc_poc_queue` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `dc_po_id` INT(11) NOT NULL,
  `eq_id` VARCHAR(20) NOT NULL,
  `yield_qty` INT(11) NOT NULL DEFAULT '0',
  `scrap_qty` INT(11) NOT NULL DEFAULT '0',
  `final_confirm` TINYINT(4) NOT NULL DEFAULT '0',
  `activity1_unit` VARCHAR(20) NOT NULL,
  `activity1_qty` INT(11) NOT NULL DEFAULT '0',
  `activity2_unit` VARCHAR(20) NOT NULL,
  `activity2_qty` INT(11) NOT NULL DEFAULT '0',
  `activity3_unit` VARCHAR(20) NOT NULL,
  `activity3_qty` INT(11) NOT NULL DEFAULT '0',
  `activity4_unit` VARCHAR(20) NOT NULL,
  `activity4_qty` INT(11) NOT NULL DEFAULT '0',
  `activity5_unit` VARCHAR(20) NOT NULL,
  `activity5_qty` INT(11) NOT NULL DEFAULT '0',
  `activity6_unit` VARCHAR(20) NOT NULL,
  `activity6_qty` INT(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  INDEX `fk_sfs_dc_poc_queue_sfs_dc_po1_idx` (`dc_po_id` ASC),
  CONSTRAINT `fk_sfs_dc_poc_queue_sfs_dc_po1`
    FOREIGN KEY (`dc_po_id`)
    REFERENCES `ioentdb_sfs`.`sfs_dc_po` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_roles` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_roles` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL COMMENT 'Roles to be created before users creation',
  `descp` VARCHAR(45) NULL DEFAULT NULL,
  `company_id` INT(11) NULL DEFAULT NULL,
  `plant_id` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `screen_access` TEXT NULL DEFAULT NULL,
  `access_rights` TINYINT(4) NULL DEFAULT NULL COMMENT '0 - Read, 1 -  Read/Write',
  PRIMARY KEY (`id`),
  INDEX `fk_sfs_roles_sfs_company1_idx` (`company_id` ASC),
  INDEX `fk_sfs_roles_sfs_plant1_idx` (`plant_id` ASC),
  CONSTRAINT `fk_sfs_roles_sfs_company1`
    FOREIGN KEY (`company_id`)
    REFERENCES `ioentdb_sfs`.`sfs_company` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_roles_sfs_plant1`
    FOREIGN KEY (`plant_id`)
    REFERENCES `ioentdb_sfs`.`sfs_plant` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_user` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NULL DEFAULT NULL,
  `first_name` VARCHAR(100) NULL DEFAULT NULL,
  `last_name` VARCHAR(100) NULL DEFAULT NULL,
  `password` VARCHAR(100) NULL DEFAULT NULL,
  `email_id` VARCHAR(100) NULL DEFAULT NULL,
  `contact_number` VARCHAR(45) NULL DEFAULT NULL,
  `is_active` TINYINT(1) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `img_file_name` TEXT NULL DEFAULT NULL,
  `roles_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`, `roles_id`),
  INDEX `fk_sfs_user_sfs_roles1_idx` (`roles_id` ASC),
  CONSTRAINT `fk_sfs_user_sfs_roles1`
    FOREIGN KEY (`roles_id`)
    REFERENCES `ioentdb_sfs`.`sfs_roles` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_event_log`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_event_log` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_event_log` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `created_time` DATETIME NULL DEFAULT NULL,
  `start_time` DATETIME NULL DEFAULT NULL,
  `end_time` DATETIME NULL DEFAULT NULL,
  `cur_reason_code` INT(11) NOT NULL,
  `prev_reason_code` INT(11) NOT NULL,
  `edited_by` INT(11) NOT NULL COMMENT 'used id who created log',
  PRIMARY KEY (`id`, `cur_reason_code`, `prev_reason_code`, `edited_by`),
  INDEX `fk_sfs_event_log_sfs_reason_code1_idx` (`cur_reason_code` ASC),
  INDEX `fk_sfs_event_log_sfs_reason_code2_idx` (`prev_reason_code` ASC),
  INDEX `fk_sfs_event_log_sfs_user1_idx` (`edited_by` ASC),
  CONSTRAINT `fk_sfs_event_log_sfs_reason_code1`
    FOREIGN KEY (`cur_reason_code`)
    REFERENCES `ioentdb_sfs`.`sfs_reason_code` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_event_log_sfs_reason_code2`
    FOREIGN KEY (`prev_reason_code`)
    REFERENCES `ioentdb_sfs`.`sfs_reason_code` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_event_log_sfs_user1`
    FOREIGN KEY (`edited_by`)
    REFERENCES `ioentdb_sfs`.`sfs_user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_events`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_events` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_events` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `start_time` DATETIME NULL DEFAULT NULL,
  `end_time` VARCHAR(45) NULL DEFAULT NULL,
  `is_updated` INT(1) NULL DEFAULT NULL,
  `data_info_id` INT(11) NOT NULL,
  `reason_code_id` INT(11) NOT NULL,
  `is_edited` TINYINT(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`, `data_info_id`, `reason_code_id`),
  INDEX `fk_sfs_events_sfs_data_info1_idx` (`data_info_id` ASC),
  INDEX `fk_sfs_events_sfs_reason_code1_idx` (`reason_code_id` ASC),
  CONSTRAINT `fk_sfs_events_sfs_data_info1`
    FOREIGN KEY (`data_info_id`)
    REFERENCES `ioentdb_sfs`.`sfs_data_info` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_events_sfs_reason_code1`
    FOREIGN KEY (`reason_code_id`)
    REFERENCES `ioentdb_sfs`.`sfs_reason_code` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_oee_colors`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_oee_colors` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_oee_colors` (
  `id` INT(11) NOT NULL,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `code` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_shifts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_shifts` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_shifts` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `code` INT(11) NOT NULL COMMENT 'shift 1, 2, 3',
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `plant_id` INT(11) NOT NULL,
  `in_time` DATETIME NULL DEFAULT NULL,
  `out_time` DATETIME NULL DEFAULT NULL,
  `total_minutes` INT(11) NULL DEFAULT NULL,
  `type` VARCHAR(45) NULL DEFAULT NULL,
  `lb_starttime` DATETIME NULL DEFAULT NULL COMMENT 'Long Break - Lunch break',
  `lb_endtime` DATETIME NULL DEFAULT NULL COMMENT 'Long Break - Lunch break',
  `sb1_starttime` DATETIME NULL DEFAULT NULL COMMENT 'short break ',
  `sb1_endtime` DATETIME NULL DEFAULT NULL COMMENT 'short break ',
  `sb2_starttime` DATETIME NULL DEFAULT NULL COMMENT 'short break ',
  `sb2_endtime` DATETIME NULL DEFAULT NULL COMMENT 'short break ',
  PRIMARY KEY (`id`, `plant_id`),
  INDEX `fk_sfs_shifts_sfs_plant1_idx` (`plant_id` ASC),
  CONSTRAINT `fk_sfs_shifts_sfs_plant1`
    FOREIGN KEY (`plant_id`)
    REFERENCES `ioentdb_sfs`.`sfs_plant` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_oee_input_data`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_oee_input_data` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_oee_input_data` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `date` DATE NULL DEFAULT NULL,
  `shift_id` INT(11) NOT NULL,
  `start_time` DATETIME NULL DEFAULT NULL,
  `end_time` DATETIME NULL DEFAULT NULL,
  `data_info_id` INT(11) NOT NULL,
  `cycle_time` INT(11) NULL DEFAULT NULL COMMENT 'in minutes',
  `sched_prod_time` INT(11) NULL DEFAULT NULL COMMENT 'in minutes',
  `planned_down_time` INT(11) NULL DEFAULT NULL,
  `unplanned_down_time` INT(11) NULL DEFAULT NULL,
  `total_accept_qty` INT(11) NULL DEFAULT NULL,
  `total_defect_qty` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`, `shift_id`, `data_info_id`),
  INDEX `fk_sfs_oee_input_data_sfs_data_info1_idx` (`data_info_id` ASC),
  INDEX `fk_sfs_oee_input_data_sfs_shifts1_idx` (`shift_id` ASC),
  CONSTRAINT `fk_sfs_oee_input_data_sfs_data_info1`
    FOREIGN KEY (`data_info_id`)
    REFERENCES `ioentdb_sfs`.`sfs_data_info` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_oee_input_data_sfs_shifts1`
    FOREIGN KEY (`shift_id`)
    REFERENCES `ioentdb_sfs`.`sfs_shifts` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_oee_limit`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_oee_limit` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_oee_limit` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `company_id` INT(11) NOT NULL,
  `plant_id` INT(11) NOT NULL,
  `workcenter_id` INT(11) NOT NULL,
  `eq_code` VARCHAR(45) NOT NULL,
  `oee_high` INT(11) NOT NULL DEFAULT '0',
  `oee_low` INT(11) NOT NULL DEFAULT '0',
  `a_high` INT(11) NOT NULL DEFAULT '0' COMMENT 'availability high limit',
  `a_low` INT(11) NOT NULL DEFAULT '0',
  `p_high` INT(11) NOT NULL DEFAULT '0' COMMENT 'performance high limit',
  `p_low` INT(11) NOT NULL DEFAULT '0',
  `q_high` INT(11) NOT NULL DEFAULT '0' COMMENT 'quality high limit',
  `q_low` INT(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_sfs_oee_limit_sfs_workcenter1_idx` (`workcenter_id` ASC),
  INDEX `fk_sfs_oee_limit_sfs_plant1_idx` (`plant_id` ASC),
  INDEX `fk_sfs_oee_limit_sfs_equipment1_idx` (`eq_code` ASC),
  UNIQUE INDEX `company_id_UNIQUE` (`company_id` ASC, `plant_id` ASC, `workcenter_id` ASC, `eq_code` ASC),
  CONSTRAINT `fk_sfs_oee_limit_sfs_company1`
    FOREIGN KEY (`company_id`)
    REFERENCES `ioentdb_sfs`.`sfs_company` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_oee_limit_sfs_equipment1`
    FOREIGN KEY (`eq_code`)
    REFERENCES `ioentdb_sfs`.`sfs_equipment` (`code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_oee_limit_sfs_plant1`
    FOREIGN KEY (`plant_id`)
    REFERENCES `ioentdb_sfs`.`sfs_plant` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_oee_limit_sfs_workcenter1`
    FOREIGN KEY (`workcenter_id`)
    REFERENCES `ioentdb_sfs`.`sfs_workcenter` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_param`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_param` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_param` (
  `id` INT(11) NOT NULL,
  `m_name` VARCHAR(45) NULL DEFAULT NULL COMMENT 'measurement point name',
  `port_name` VARCHAR(45) NULL DEFAULT NULL COMMENT 'combination of <IOBot name>/<port_type>_<port_no>',
  `unit` VARCHAR(45) NULL DEFAULT NULL,
  `threshold_value` DOUBLE NULL DEFAULT NULL,
  `descp` VARCHAR(45) NULL DEFAULT NULL,
  `eq_code` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`, `eq_code`),
  INDEX `fk_sfs_param_sfs_equipment1_idx` (`eq_code` ASC),
  CONSTRAINT `fk_sfs_param_sfs_equipment1`
    FOREIGN KEY (`eq_code`)
    REFERENCES `ioentdb_sfs`.`sfs_equipment` (`code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_param_data`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_param_data` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_param_data` (
  `id` INT(10) NOT NULL,
  `date_time` TIMESTAMP NULL DEFAULT NULL,
  `param_value` DOUBLE NOT NULL DEFAULT '0',
  `param_type_id` INT(11) NOT NULL,
  `data_info_id` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`param_type_id`),
  INDEX `fk_sfs_param_data_sfs_data_info1_idx` (`data_info_id` ASC),
  CONSTRAINT `fk_sfs_param_data_sfs_data_info1`
    FOREIGN KEY (`data_info_id`)
    REFERENCES `ioentdb_sfs`.`sfs_data_info` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_param_data_sfs_param_type1`
    FOREIGN KEY (`param_type_id`)
    REFERENCES `ioentdb_sfs`.`sfs_param` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_screens`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_screens` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_screens` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `ui_tag_id` VARCHAR(45) NULL,
  `name` VARCHAR(45) NULL,
  `descp` TEXT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `ui_tag_id_UNIQUE` (`ui_tag_id` ASC))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

COMMIT;