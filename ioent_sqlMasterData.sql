-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2018 at 08:15 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ioentdb_sfs`
--

--
-- Dumping data for table `sfs_company`
--

INSERT INTO `sfs_company` (`id`, `code`, `descp`, `address`, `contact_person`, `contact_number`, `image_file_name`) VALUES
(1, '1000', 'Eim Solutions Pvt Ltd', 'Bangalore', 'Santhosh', '9844176733', '1000_8817.jpg');

--
-- Dumping data for table `sfs_dc_po`
--

INSERT INTO `sfs_dc_po` (`id`, `order_number`, `operation`, `material`, `target_qty`, `line_feed_qty`, `no_of_conf`, `conf_yield_count`, `conf_scarp_count`, `is_final_confirmed`, `plant_id`, `eq_code`, `conf_no`) VALUES
(1, '123456', '0010', 'Backing', 1000, 500, 0, 0, 0, 0, 1, 'IObot1', 1524);

--
-- Dumping data for table `sfs_equipment_protocol`
--

INSERT INTO `sfs_equipment_protocol` (`id`, `name`, `descp`) VALUES
(1, 'NONE', 'Server'),
(2, 'MQTT', 'Mqtt Communication');

--
-- Dumping data for table `sfs_equipment`
--

INSERT INTO `sfs_equipment` (`id`, `code`, `descp`, `protocol_id`, `wc_id`, `order_id`, `line_feed_qty`, `type_id`, `model_id`, `mac_id`, `conn_state`, `reason_code_id`, `reason_code_arr`, `is_eq_details_updated`, `is_prod_list_updated`, `is_employee_details_updated`, `is_company_detail_updated`, `is_style_image_updated`, `ton`, `maint_count`, `stroke_before_maint`, `stroke_after_maint`, `last_maint_timestamp`, `cur_date_time`, `maint_alert_sent`, `image_file_name`) VALUES
(2, 'IObot1', 'Biscuit Line', 2, 1, 0, NULL, 1, 1, '00-11-11-00-00-01', 0, NULL, '0', 1, 1, 1, 0, 1, 0, 0, 0, 0, NULL, '2018-05-01 13:13:00', 0, NULL),
(1, 'IOent', 'SERVER', 1, 1, 0, NULL, 1, 1, '60-6d-c7-45-c2-17', 0, NULL, '1', 1, 1, 1, 0, 1, 0, 0, 0, 0, NULL, '2018-05-01 13:13:00', 0, '');

--
-- Dumping data for table `sfs_equipment_model`
--

INSERT INTO `sfs_equipment_model` (`id`, `name`, `num_of_di`, `num_of_do`, `num_of_ai`, `num_of_ao`) VALUES
(1, 'B8600', 2, 2, 2, 2);

--
-- Dumping data for table `sfs_equipment_type`
--

INSERT INTO `sfs_equipment_type` (`id`, `descp`, `is_machine`, `is_afs_size_id`, `is_dc_po`, `is_tool`) VALUES
(1, 'DC PO Machine', 1, 0, 1, 1);

--
-- Dumping data for table `sfs_operators`
--

INSERT INTO `sfs_operators` (`id`, `code`, `name`, `type`, `plant_id`, `workcenter_id`, `department_id`, `contractor`, `designation_id`, `skill_id`) VALUES
('101', '12345', 'KANTH', 'I', 2, 2, 1, 'N', 1, 1);

--
-- Dumping data for table `sfs_opr_department`
--

INSERT INTO `sfs_opr_department` (`id`, `code`, `name`, `descp`) VALUES
(1, '1010', 'PRODUCION', 'Manufacturing Depart');

--
-- Dumping data for table `sfs_part_fg`
--

INSERT INTO `sfs_part_fg` (`id`, `number`, `descp`, `plant_id`) VALUES
(1, '0010', 'Backing', 1);

--
-- Dumping data for table `sfs_plant`
--

INSERT INTO `sfs_plant` (`id`, `code`, `descp`, `address`, `contact_person`, `contact_number`, `latitude`, `longitude`, `image_file_name`, `comp_id`) VALUES
(1, '1000', 'Novel Tech Park', 'Bangalore', 'Jagan', '8697458888', NULL, NULL, '1000_28871.png', 1),
(2, '1001', 'HSR Layout', 'Bangalore', 'Kanth', '9865745587', NULL, NULL, '1001_22260.png', 1);

--
-- Dumping data for table `sfs_quality_codes`
--

INSERT INTO `sfs_quality_codes` (`id`, `reason_message`, `color_code`, `quality_type_id`) VALUES
(1, 'OK', '#FFFEEE', 1),
(2, 'SCARP', '#FFFEEE', 2),
(3, 'PAINT REWORK', '#EEEFFF', 3);

--
-- Dumping data for table `sfs_quality_type`
--

INSERT INTO `sfs_quality_type` (`id`, `message`) VALUES
(1, 'OK'),
(2, 'REJECT'),
(3, 'REWORK');

--
-- Dumping data for table `sfs_reason_code`
--

INSERT INTO `sfs_reason_code` (`id`, `message`, `color_code`, `reason_type_id`) VALUES
(1, 'Productive', '#6ec639', 4);

--
-- Dumping data for table `sfs_reason_type`
--

INSERT INTO `sfs_reason_type` (`id`, `message`, `color_code`) VALUES
(1, 'Run Time', '#90d87e'),
(2, 'Idle Time', '#EEEFFF'),
(3, 'Brekdown Time', '#EEEFFF');

--
-- Dumping data for table `sfs_roles`
--

INSERT INTO `sfs_roles` (`id`, `name`, `descp`, `company_id`, `plant_id`, `created_at`, `updated_at`, `screen_access`, `access_rights`) VALUES
(1, 'SUPERADMIN', 'Only EIMS Users', 1, NULL, NULL, NULL, '1,2,3,4,5,6,7,8', 2),
(2, 'ADMIN', '', 1, NULL, NULL, NULL, '2,3,4,5,6,7', 2);

--
-- Dumping data for table `sfs_screens`
--

INSERT INTO `sfs_screens` (`id`, `ui_tag_id`, `name`, `descp`) VALUES
(1, 'menuScreen', 'Screens', 'All Screens added here'),
(2, 'menuPlants', 'Plants', 'View all the Plants'),
(3, 'menuUserConfiguration', 'User Configuration', 'View all the User Configuration'),
(4, 'menuRoleConfiguration', 'Role Configuration', 'View all the Role Configuration '),
(5, 'menuOeeConfiguration', 'Oee Configuration', 'View all the OEE Configuration'),
(6, 'menuShiftConfiguration', 'Shift Configuration', 'View all the Shift Configuration'),
(7, 'menuProductionOrder', 'Production Order', ''),
(8, 'menuCompany', 'Company', '');

--
-- Dumping data for table `sfs_skill`
--

INSERT INTO `sfs_skill` (`id`, `name`, `descp`, `created_on`) VALUES
(1, 'CHECKER', 'End line cheking operator', '2018-04-24 01:41:13');

--
-- Dumping data for table `sfs_tool_opr`
--

INSERT INTO `sfs_tool_opr` (`tag_id`, `number`, `name`, `descp`, `eq_code`, `part_fg_id`, `is_present`, `is_connected`, `is_active`, `prev_distance`, `cur_distance`, `time_last_reboot`, `cur_date_time`, `ton`, `maint_count`, `lifetime_count`, `stroke_before_maint`, `stroke_after_maint`, `maint_alert_sent`, `last_maint_timestamp`, `namespace`, `instance`, `image_file_name`, `bm_setup_time`, `bm_prod_time`, `tool_opr_type_id`, `no_of_items_per_oper`) VALUES
('1:1:0010', '0010', 'Backing process', 'Backing process', NULL, 1, 0, 0, b'1', 0, 0, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, '0', '', 0, 0, 3, 1);

--
-- Dumping data for table `sfs_tool_opr_id_type`
--

INSERT INTO `sfs_tool_opr_id_type` (`id`, `name`, `descp`) VALUES
(1, 'RFID', 'Radio-frequency identification'),
(2, 'BARCODE', 'Alphanumeric barcode Scan'),
(3, 'OPERATION', 'Production order operation stages');

--
-- Dumping data for table `sfs_user`
--

INSERT INTO `sfs_user` (`id`, `name`, `first_name`, `last_name`, `password`, `email_id`, `contact_number`, `is_active`, `created_at`, `updated_at`, `img_file_name`, `roles_id`) VALUES
(1, NULL, 'SuperAdmin', NULL, 'admin@1', 'superadmin@gmail.com', '9844176733', 1, NULL, NULL, NULL, 1),
(2, NULL, 'Lakshmikanth', '', '1234', 'lakshmikanth@eimsolutions.com', '9999999999', 1, NULL, NULL, '', 2);

--
-- Dumping data for table `sfs_workcenter`
--

INSERT INTO `sfs_workcenter` (`id`, `code`, `descp`, `contact_person`, `contact_number`, `image_file_name`, `plant_id`) VALUES
(1, '2010', 'Biscuit Line 1', 'Adiveepa', '9826374872', '', 1);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
