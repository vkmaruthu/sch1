-- smartFactory OEE Database Design
-- Version 1.0 / Release 1.0
-- EIM Solutions

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
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_quality_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_quality_type` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_quality_type` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `message` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `message` (`message` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_quality_codes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_quality_codes` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_quality_codes` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `quality_code` INT(11) NOT NULL,
  `reason_message` VARCHAR(40) NOT NULL,
  `color_code` VARCHAR(40) NOT NULL,
  `quality_type_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`, `quality_type_id`),
  UNIQUE INDEX `quality_type_id` (`quality_code` ASC),
  INDEX `fk_sfs_quality_codes_sfs_quality_type1_idx` (`quality_type_id` ASC),
  CONSTRAINT `fk_sfs_quality_codes_sfs_quality_type1`
    FOREIGN KEY (`quality_type_id`)
    REFERENCES `ioentdb_sfs`.`sfs_quality_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_equipment_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_equipment_type` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_equipment_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `eq_type_desc` VARCHAR(20) NULL,
  `is_machine` TINYINT NOT NULL DEFAULT 0,
  `is_afs_size_id` TINYINT NOT NULL DEFAULT 0,
  `is_dc_po` TINYINT NOT NULL DEFAULT 0,
  `is_tool` TINYINT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_reason_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_reason_type` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_reason_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `message` VARCHAR(45) NULL,
  `color_code` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_reason_code`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_reason_code` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_reason_code` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `message` VARCHAR(45) NULL,
  `color_code` VARCHAR(45) NULL,
  `reason_type_id` INT NOT NULL,
  PRIMARY KEY (`id`, `reason_type_id`),
  INDEX `fk_sfs_reason_code_sfs_reason_type1_idx` (`reason_type_id` ASC),
  CONSTRAINT `fk_sfs_reason_code_sfs_reason_type1`
    FOREIGN KEY (`reason_type_id`)
    REFERENCES `ioentdb_sfs`.`sfs_reason_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


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
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_equipment_model`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_equipment_model` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_equipment_model` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(12) NULL,
  `num_of_di` INT NULL,
  `num_of_do` INT NULL,
  `num_of_ai` INT NULL,
  `num_of_ao` INT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_equipment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_equipment` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_equipment` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `eq_code` VARCHAR(45) NOT NULL,
  `eq_desc` VARCHAR(30) NULL DEFAULT NULL,
  `eq_protocol` VARCHAR(11) NULL,
  `wc_id` INT(11) NOT NULL,
  `order_id` INT(11) NULL DEFAULT '0',
  `eq_type_id` INT NOT NULL,
  `eq_model_id` INT NOT NULL,
  `conn_state` INT(11) NULL DEFAULT '0',
  `reason_code_id` INT NULL DEFAULT NULL,
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
  `mac_id` VARCHAR(20) NULL,
  PRIMARY KEY (`eq_code`, `wc_id`),
  INDEX `fk_sfs_equipment_sfs_equipment_type1_idx` (`eq_type_id` ASC),
  INDEX `fk_sfs_equipment_sfs_reason_code1_idx` (`reason_code_id` ASC),
  INDEX `fk_sfs_equipment_sfs_workcenter1_idx` (`wc_id` ASC),
  UNIQUE INDEX `eq_code_UNIQUE` (`eq_code` ASC),
  INDEX `fk_sfs_equipment_sfs_equipment_model1_idx` (`eq_model_id` ASC),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  CONSTRAINT `fk_sfs_equipment_sfs_equipment_type1`
    FOREIGN KEY (`eq_type_id`)
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
  CONSTRAINT `fk_sfs_equipment_sfs_equipment_model1`
    FOREIGN KEY (`eq_model_id`)
    REFERENCES `ioentdb_sfs`.`sfs_equipment_model` (`id`)
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
  `desc` VARCHAR(30) NOT NULL,
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
-- Table `ioentdb_sfs`.`sfs_tool_opr`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_tool_opr` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_tool_opr` (
  `tag_id` VARCHAR(40) NOT NULL COMMENT 'Combination of <comapny code>:<plant code>:<tag value>',
  `mac_id` VARCHAR(20) NULL DEFAULT NULL,
  `name` VARCHAR(20) NOT NULL DEFAULT 'Undefined',
  `description` VARCHAR(40) NOT NULL DEFAULT 'Undefined',
  `eq_code` VARCHAR(45) NOT NULL,
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
  `bm_setup_time` INT(11) NULL DEFAULT 0 COMMENT 'benchmark setup time',
  `bm_prod_time` DOUBLE NULL DEFAULT 0 COMMENT 'benchmark production time',
  UNIQUE INDEX `id_UNIQUE` (`tag_id` ASC),
  PRIMARY KEY (`tag_id`, `eq_code`, `part_fg_id`),
  INDEX `fk_sfs_tool_sfs_parts1_idx` (`part_fg_id` ASC),
  INDEX `fk_sfs_tool_sfs_equipment1_idx` (`eq_code` ASC),
  CONSTRAINT `fk_sfs_tool_sfs_parts1`
    FOREIGN KEY (`part_fg_id`)
    REFERENCES `ioentdb_sfs`.`sfs_part_fg` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_tool_sfs_equipment1`
    FOREIGN KEY (`eq_code`)
    REFERENCES `ioentdb_sfs`.`sfs_equipment` (`eq_code`)
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
  `employee_id` INT(11) NOT NULL,
  `order_id` INT(11) NOT NULL,
  `equipment_type_id` INT NOT NULL,
  `eq_code` VARCHAR(45) NOT NULL,
  `tag_id` VARCHAR(40) NOT NULL,
  PRIMARY KEY (`id`, `equipment_type_id`, `eq_code`, `tag_id`),
  UNIQUE INDEX `ru_id` (`employee_id` ASC, `order_id` ASC),
  UNIQUE INDEX `size_id_UNIQUE` (`order_id` ASC),
  INDEX `fk_sfs_data_info_sfs_equipment1_idx` (`eq_code` ASC),
  INDEX `fk_sfs_data_info_sfs_equipment_type1_idx` (`equipment_type_id` ASC),
  INDEX `fk_sfs_data_info_sfs_tool_opr1_idx` (`tag_id` ASC),
  CONSTRAINT `fk_sfs_data_info_sfs_equipment1`
    FOREIGN KEY (`eq_code`)
    REFERENCES `ioentdb_sfs`.`sfs_equipment` (`eq_code`)
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
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_data`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_data` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_data` (
  `id` INT(11) NOT NULL,
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
  CONSTRAINT `fk_sfs_data_sfs_quality_codes1`
    FOREIGN KEY (`quality_codes_id`)
    REFERENCES `ioentdb_sfs`.`sfs_quality_codes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_data_sfs_data_info1`
    FOREIGN KEY (`data_info_id`)
    REFERENCES `ioentdb_sfs`.`sfs_data_info` (`id`)
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
-- Table `ioentdb_sfs`.`sfs_param`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_param` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_param` (
  `id` INT NOT NULL,
  `m_name` VARCHAR(45) NULL COMMENT 'measurement point name',
  `port_name` VARCHAR(45) NULL COMMENT 'combination of <IOBot name>/ <port_type>_<port_no>',
  `unit` VARCHAR(45) NULL,
  `threshold_value` DOUBLE NULL,
  `descp` VARCHAR(45) NULL,
  `port_type` VARCHAR(4) NULL,
  `port_no` INT NULL,
  `eq_code` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`, `eq_code`),
  INDEX `fk_sfs_param_sfs_equipment1_idx` (`eq_code` ASC),
  CONSTRAINT `fk_sfs_param_sfs_equipment1`
    FOREIGN KEY (`eq_code`)
    REFERENCES `ioentdb_sfs`.`sfs_equipment` (`eq_code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_param_data`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_param_data` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_param_data` (
  `id` INT(10) NOT NULL,
  `date_time` TIMESTAMP NULL DEFAULT NULL,
  `param_value` DOUBLE NOT NULL DEFAULT '0',
  `param_type_id` INT NOT NULL,
  PRIMARY KEY (`param_type_id`),
  CONSTRAINT `fk_sfs_param_data_sfs_param_type1`
    FOREIGN KEY (`param_type_id`)
    REFERENCES `ioentdb_sfs`.`sfs_param` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_alerts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_alerts` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_alerts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `message` VARCHAR(45) NULL,
  `color_code` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_status`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_status` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_status` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `message` VARCHAR(45) NULL,
  `color_code` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_alert_log`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_alert_log` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_alert_log` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `alert_id` INT NOT NULL,
  `message` TEXT NULL,
  `tool_id` BIGINT(20) NULL,
  `status_id` INT NOT NULL,
  `created_time` VARCHAR(45) NULL,
  `last_updated_time` VARCHAR(45) NULL,
  `last_updated_by` VARCHAR(45) NULL,
  `remark` TEXT NULL,
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
  CONSTRAINT `fk_sfs_alert_log_sfs_status1`
    FOREIGN KEY (`status_id`)
    REFERENCES `ioentdb_sfs`.`sfs_status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_alert_log_sfs_equipment1`
    FOREIGN KEY (`eq_code`)
    REFERENCES `ioentdb_sfs`.`sfs_equipment` (`eq_code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_oee_colors`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_oee_colors` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_oee_colors` (
  `id` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  `code` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_opr_department`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_opr_department` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_opr_department` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(8) NULL,
  `name` VARCHAR(45) NULL,
  `description` VARCHAR(100) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_skill`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_skill` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_skill` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `description` VARCHAR(100) NULL,
  `created_on` TIMESTAMP NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_designation`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_designation` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_designation` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `description` VARCHAR(45) NULL,
  `created_on` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_operators`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_operators` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_operators` (
  `id` VARCHAR(8) NOT NULL,
  `name` VARCHAR(45) NULL,
  `type` VARCHAR(1) NULL,
  `plant_id` INT(11) NOT NULL,
  `workcenter_id` INT(11) NOT NULL,
  `department_id` INT NOT NULL,
  `contractor` VARCHAR(1) NULL,
  `designation_id` INT NOT NULL,
  `skill_id` INT NOT NULL,
  PRIMARY KEY (`id`, `plant_id`, `workcenter_id`, `department_id`, `designation_id`, `skill_id`),
  UNIQUE INDEX `employee_id_UNIQUE` (`id` ASC),
  INDEX `fk_sfs_operators_sfs_plant1_idx` (`plant_id` ASC),
  INDEX `fk_sfs_operators_sfs_workcenter1_idx` (`workcenter_id` ASC),
  INDEX `fk_sfs_operators_sfs_opr_department1_idx` (`department_id` ASC),
  INDEX `fk_sfs_operators_sfs_skills1_idx` (`skill_id` ASC),
  INDEX `fk_sfs_operators_sfs_designation1_idx` (`designation_id` ASC),
  CONSTRAINT `fk_sfs_operators_sfs_plant1`
    FOREIGN KEY (`plant_id`)
    REFERENCES `ioentdb_sfs`.`sfs_plant` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_operators_sfs_workcenter1`
    FOREIGN KEY (`workcenter_id`)
    REFERENCES `ioentdb_sfs`.`sfs_workcenter` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_operators_sfs_opr_department1`
    FOREIGN KEY (`department_id`)
    REFERENCES `ioentdb_sfs`.`sfs_opr_department` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_operators_sfs_skills1`
    FOREIGN KEY (`skill_id`)
    REFERENCES `ioentdb_sfs`.`sfs_skill` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_operators_sfs_designation1`
    FOREIGN KEY (`designation_id`)
    REFERENCES `ioentdb_sfs`.`sfs_designation` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_events`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_events` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_events` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `start_time` DATETIME NULL,
  `end_time` VARCHAR(45) NULL,
  `is_updated` INT(1) NULL,
  `data_info_id` INT(11) NOT NULL,
  `reason_code_id` INT NOT NULL,
  `is_edited` TINYINT NOT NULL DEFAULT 0,
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
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_roles` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_roles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL COMMENT 'Roles to be created before users creation',
  `description` VARCHAR(45) NULL,
  `company_id` INT(11) NULL DEFAULT NULL,
  `plant_id` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  `screen_access` TEXT NULL,
  `access_rights` TINYINT NULL COMMENT '0 - Read, 1 -  Read/Write',
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
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_user` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NULL,
  `first_name` VARCHAR(100) NULL,
  `last_name` VARCHAR(100) NULL,
  `password` VARCHAR(100) NULL,
  `email_id` VARCHAR(100) NULL,
  `contact number` VARCHAR(45) NULL,
  `is_active` TINYINT(1) NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  `img_file_name` TEXT NULL,
  `roles_id` INT NOT NULL,
  PRIMARY KEY (`id`, `roles_id`),
  INDEX `fk_sfs_user_sfs_roles1_idx` (`roles_id` ASC),
  CONSTRAINT `fk_sfs_user_sfs_roles1`
    FOREIGN KEY (`roles_id`)
    REFERENCES `ioentdb_sfs`.`sfs_roles` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_dc_po`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_dc_po` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_dc_po` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `order_number` VARCHAR(20) NOT NULL,
  `operation` INT(11) NULL,
  `material` VARCHAR(45) NULL,
  `target_qty` INT(11) NULL,
  `line_feed_qty` INT(11) NULL,
  `conf_no` INT(11) NULL,
  `conf_count` INT(11) NULL DEFAULT 0,
  `conf_yield` INT(11) NULL DEFAULT 0,
  `conf_scrap` INT(11) NULL DEFAULT 0,
  `is_final_confirmed` TINYINT NULL DEFAULT 0,
  `eq_code` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`, `eq_code`),
  UNIQUE INDEX `order_number_UNIQUE` (`order_number` ASC),
  UNIQUE INDEX `operation_UNIQUE` (`operation` ASC),
  INDEX `fk_sfs_dc_po_sfs_equipment1_idx` (`eq_code` ASC),
  UNIQUE INDEX `eq_code_UNIQUE` (`eq_code` ASC),
  CONSTRAINT `fk_sfs_dc_po_sfs_equipment1`
    FOREIGN KEY (`eq_code`)
    REFERENCES `ioentdb_sfs`.`sfs_equipment` (`eq_code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_shifts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_shifts` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_shifts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `code` INT NOT NULL COMMENT 'shift 1, 2, 3',
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `plant_id` INT(11) NOT NULL,
  `in_time` DATETIME NULL,
  `out_time` DATETIME NULL,
  `total_minutes` INT NULL,
  `type` VARCHAR(45) NULL,
  `lb_starttime` DATETIME NULL COMMENT 'Long Break - Lunch break',
  `lb_endtime` DATETIME NULL COMMENT 'Long Break - Lunch break',
  `sb1_starttime` DATETIME NULL COMMENT 'short break ',
  `sb1_endtime` DATETIME NULL COMMENT 'short break ',
  `sb2_starttime` DATETIME NULL COMMENT 'short break ',
  `sb2_endtime` DATETIME NULL COMMENT 'short break ',
  PRIMARY KEY (`id`, `plant_id`),
  INDEX `fk_sfs_shifts_sfs_plant1_idx` (`plant_id` ASC),
  CONSTRAINT `fk_sfs_shifts_sfs_plant1`
    FOREIGN KEY (`plant_id`)
    REFERENCES `ioentdb_sfs`.`sfs_plant` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_oee_input_data`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_oee_input_data` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_oee_input_data` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `date` DATE NULL,
  `shift_id` INT NOT NULL,
  `start_time` DATETIME NULL,
  `end_time` DATETIME NULL,
  `data_info_id` INT(11) NOT NULL,
  `cycle_time` INT NULL COMMENT 'in minutes',
  `sched_prod_time` INT NULL COMMENT 'in minutes',
  `planned_down_time` INT NULL,
  `unplanned_down_time` INT NULL,
  `total_accept_qty` INT NULL,
  `total_defect_qty` INT NULL,
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
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_oee_limit`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_oee_limit` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_oee_limit` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `company_id` INT(11) NOT NULL,
  `plant_id` INT(11) NOT NULL,
  `workcenter_id` INT(11) NOT NULL,
  `eq_code` VARCHAR(45) NOT NULL,
  `oee_high` INT NOT NULL DEFAULT 0,
  `oee_low` INT NOT NULL DEFAULT 0,
  `a_high` INT NOT NULL DEFAULT 0 COMMENT 'availability high limit',
  `a_low` INT NOT NULL DEFAULT 0,
  `p_high` INT NOT NULL DEFAULT 0 COMMENT 'performance high limit',
  `p_low` INT NOT NULL DEFAULT 0,
  `q_high` INT NOT NULL DEFAULT 0 COMMENT 'quality high limit',
  `q_low` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`, `company_id`, `plant_id`, `workcenter_id`, `eq_code`),
  UNIQUE INDEX `oee_high_UNIQUE` (`oee_high` ASC),
  UNIQUE INDEX `oee_low_UNIQUE` (`oee_low` ASC),
  UNIQUE INDEX `a_high_UNIQUE` (`a_high` ASC),
  UNIQUE INDEX `a_low_UNIQUE` (`a_low` ASC),
  UNIQUE INDEX `p_high_UNIQUE` (`p_high` ASC),
  UNIQUE INDEX `p_low_UNIQUE` (`p_low` ASC),
  UNIQUE INDEX `q_low_UNIQUE` (`q_low` ASC),
  UNIQUE INDEX `q_high_UNIQUE` (`q_high` ASC),
  INDEX `fk_sfs_oee_limit_sfs_company1_idx` (`company_id` ASC),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_sfs_oee_limit_sfs_workcenter1_idx` (`workcenter_id` ASC),
  INDEX `fk_sfs_oee_limit_sfs_plant1_idx` (`plant_id` ASC),
  INDEX `fk_sfs_oee_limit_sfs_equipment1_idx` (`eq_code` ASC),
  CONSTRAINT `fk_sfs_oee_limit_sfs_company1`
    FOREIGN KEY (`company_id`)
    REFERENCES `ioentdb_sfs`.`sfs_company` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_oee_limit_sfs_workcenter1`
    FOREIGN KEY (`workcenter_id`)
    REFERENCES `ioentdb_sfs`.`sfs_workcenter` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_oee_limit_sfs_plant1`
    FOREIGN KEY (`plant_id`)
    REFERENCES `ioentdb_sfs`.`sfs_plant` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfs_oee_limit_sfs_equipment1`
    FOREIGN KEY (`eq_code`)
    REFERENCES `ioentdb_sfs`.`sfs_equipment` (`eq_code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_contract_info`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_contract_info` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_contract_info` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `created_date` DATETIME NULL,
  `start_date` DATETIME NULL,
  `no_of_days` INT NULL,
  `is_active` TINYINT NULL,
  `message` TEXT NULL,
  `company_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`, `company_id`),
  INDEX `fk_3_sfs_company1_idx` (`company_id` ASC),
  UNIQUE INDEX `company_id_UNIQUE` (`company_id` ASC),
  CONSTRAINT `fk_3_sfs_company1`
    FOREIGN KEY (`company_id`)
    REFERENCES `ioentdb_sfs`.`sfs_company` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_dc_poc_queue`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_dc_poc_queue` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_dc_poc_queue` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `dc_po_id` INT(11) NOT NULL,
  `eq_id` VARCHAR(20) NOT NULL,
  `yield_qty` INT(11) NOT NULL DEFAULT 0,
  `scrap_qty` INT(11) NOT NULL DEFAULT 0,
  `final_confirm` TINYINT NOT NULL DEFAULT 0,
  `activity1_unit` VARCHAR(20) NOT NULL,
  `activity1_qty` INT(11) NOT NULL DEFAULT 0,
  `activity2_unit` VARCHAR(20) NOT NULL,
  `activity2_qty` INT(11) NOT NULL DEFAULT 0,
  `activity3_unit` VARCHAR(20) NOT NULL,
  `activity3_qty` INT(11) NOT NULL DEFAULT 0,
  `activity4_unit` VARCHAR(20) NOT NULL,
  `activity4_qty` INT(11) NOT NULL DEFAULT 0,
  `activity5_unit` VARCHAR(20) NOT NULL,
  `activity5_qty` INT(11) NOT NULL DEFAULT 0,
  `activity6_unit` VARCHAR(20) NOT NULL,
  `activity6_qty` INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`, `dc_po_id`),
  INDEX `fk_sfs_dc_poc_queue_sfs_dc_po1_idx` (`dc_po_id` ASC),
  CONSTRAINT `fk_sfs_dc_poc_queue_sfs_dc_po1`
    FOREIGN KEY (`dc_po_id`)
    REFERENCES `ioentdb_sfs`.`sfs_dc_po` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ioentdb_sfs`.`sfs_event_log`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ioentdb_sfs`.`sfs_event_log` ;

CREATE TABLE IF NOT EXISTS `ioentdb_sfs`.`sfs_event_log` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `created_time` DATETIME NULL,
  `start_time` DATETIME NULL,
  `end_time` DATETIME NULL,
  `cur_reason_code` INT NOT NULL,
  `prev_reason_code` INT NOT NULL,
  `edited_by` INT NOT NULL COMMENT 'used id who created log',
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
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `ioentdb_sfs`.`sfs_quality_type`
-- -----------------------------------------------------
START TRANSACTION;
USE `ioentdb_sfs`;
INSERT INTO `ioentdb_sfs`.`sfs_quality_type` (`id`, `message`) VALUES (1, 'OK');
INSERT INTO `ioentdb_sfs`.`sfs_quality_type` (`id`, `message`) VALUES (2, 'REJECT');
INSERT INTO `ioentdb_sfs`.`sfs_quality_type` (`id`, `message`) VALUES (3, 'REWORK');

COMMIT;


-- -----------------------------------------------------
-- Data for table `ioentdb_sfs`.`sfs_reason_type`
-- -----------------------------------------------------
START TRANSACTION;
USE `ioentdb_sfs`;
INSERT INTO `ioentdb_sfs`.`sfs_reason_type` (`id`, `message`, `color_code`) VALUES (1, 'Run Time', '#FFFFFF');
INSERT INTO `ioentdb_sfs`.`sfs_reason_type` (`id`, `message`, `color_code`) VALUES (2, 'Planned Downtime', '#FFFFFF');
INSERT INTO `ioentdb_sfs`.`sfs_reason_type` (`id`, `message`, `color_code`) VALUES (3, 'Unplanned Downtime', '#FFFFFF');

COMMIT;


-- -----------------------------------------------------
-- Data for table `ioentdb_sfs`.`sfs_status`
-- -----------------------------------------------------
START TRANSACTION;
USE `ioentdb_sfs`;
INSERT INTO `ioentdb_sfs`.`sfs_status` (`id`, `message`, `color_code`) VALUES (1, 'OPEN', '#E74C3C  ');
INSERT INTO `ioentdb_sfs`.`sfs_status` (`id`, `message`, `color_code`) VALUES (2, 'CLOSED', '#2ECC71');
INSERT INTO `ioentdb_sfs`.`sfs_status` (`id`, `message`, `color_code`) VALUES (3, 'IN PROGRESS', '#F1C40F');

COMMIT;


-- -----------------------------------------------------
-- Data for table `ioentdb_sfs`.`sfs_oee_colors`
-- -----------------------------------------------------
START TRANSACTION;
USE `ioentdb_sfs`;
INSERT INTO `ioentdb_sfs`.`sfs_oee_colors` (`id`, `name`, `code`) VALUES (1, 'High', '#2ECC71  ');
INSERT INTO `ioentdb_sfs`.`sfs_oee_colors` (`id`, `name`, `code`) VALUES (2, 'Medium', '#F39C12');
INSERT INTO `ioentdb_sfs`.`sfs_oee_colors` (`id`, `name`, `code`) VALUES (3, 'Low', '#E74C3C');

COMMIT;