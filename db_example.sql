/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET SQL_NOTES=0 */;
DROP TABLE IF EXISTS absent_reasons;
CREATE TABLE `absent_reasons` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `type` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `absent_reasons_idx` (`code`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS activity_log;
CREATE TABLE `activity_log` (
  `id` char(36) NOT NULL,
  `route` varchar(255) NOT NULL,
  `send_data` longtext NOT NULL,
  `comment` longtext NOT NULL,
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS attendance_logfingers;
CREATE TABLE `attendance_logfingers` (
  `id` char(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `employee_id` char(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type_absen` char(1) DEFAULT NULL,
  `fingertime` datetime NOT NULL,
  `fingerprint_device_id` char(36) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_attendance_log_1` (`employee_id`),
  KEY `fk_attendance_log_2` (`fingerprint_device_id`),
  CONSTRAINT `fk_attendance_log_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  CONSTRAINT `fk_attendance_log_2` FOREIGN KEY (`fingerprint_device_id`) REFERENCES `fingerprint_devices` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS attendance_summaries;
CREATE TABLE `attendance_summaries` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `employee_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `year` smallint NOT NULL,
  `month` smallint NOT NULL,
  `total_workday` int NOT NULL,
  `total_in` int NOT NULL,
  `total_loyality` int NOT NULL,
  `total_absent` int NOT NULL,
  `total_overtime` int NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_13FC96F08C03F15C` (`employee_id`),
  KEY `attendance_summaries_idx` (`month`,`year`),
  CONSTRAINT `FK_13FC96F08C03F15C` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS attendances;
CREATE TABLE `attendances` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `employee_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `shiftment_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `reason_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `attendance_date` date NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `check_in` time DEFAULT NULL,
  `check_out` time DEFAULT NULL,
  `early_in` int NOT NULL,
  `early_out` int NOT NULL,
  `late_in` int NOT NULL,
  `late_out` int NOT NULL,
  `absent` tinyint(1) NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9C6B8FD48C03F15C` (`employee_id`),
  KEY `IDX_9C6B8FD4180FBE1` (`shiftment_id`),
  KEY `IDX_9C6B8FD459BB1592` (`reason_id`),
  CONSTRAINT `FK_9C6B8FD4180FBE1` FOREIGN KEY (`shiftment_id`) REFERENCES `shiftments` (`id`),
  CONSTRAINT `FK_9C6B8FD459BB1592` FOREIGN KEY (`reason_id`) REFERENCES `absent_reasons` (`id`),
  CONSTRAINT `FK_9C6B8FD48C03F15C` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS career_histories;
CREATE TABLE `career_histories` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `employee_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `company_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `department_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `joblevel_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `jobtitle_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `supervisor_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `contract_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `description` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6872056C8C03F15C` (`employee_id`),
  KEY `IDX_6872056C979B1AD6` (`company_id`),
  KEY `IDX_6872056CAE80F5DF` (`department_id`),
  KEY `IDX_6872056CB1161D41` (`joblevel_id`),
  KEY `IDX_6872056CE438D15B` (`jobtitle_id`),
  KEY `IDX_6872056C19E9AC5F` (`supervisor_id`),
  KEY `IDX_6872056C2576E0FD` (`contract_id`),
  CONSTRAINT `FK_6872056C19E9AC5F` FOREIGN KEY (`supervisor_id`) REFERENCES `employees` (`id`),
  CONSTRAINT `FK_6872056C2576E0FD` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`),
  CONSTRAINT `FK_6872056C8C03F15C` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  CONSTRAINT `FK_6872056C979B1AD6` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `FK_6872056CAE80F5DF` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  CONSTRAINT `FK_6872056CB1161D41` FOREIGN KEY (`joblevel_id`) REFERENCES `job_levels` (`id`),
  CONSTRAINT `FK_6872056CE438D15B` FOREIGN KEY (`jobtitle_id`) REFERENCES `job_titles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS cities;
CREATE TABLE `cities` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `region_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `code` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D95DB16B98260155` (`region_id`),
  KEY `cities_idx` (`code`,`name`),
  CONSTRAINT `FK_D95DB16B98260155` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS companies;
CREATE TABLE `companies` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `parent_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `code` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `birth_day` date NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8244AA3AF5B7AF75` (`address`),
  KEY `IDX_8244AA3A727ACA70` (`parent_id`),
  KEY `companies_idx` (`code`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS company_costs;
CREATE TABLE `company_costs` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `payroll_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `component_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `benefit_value` longtext COLLATE utf8_unicode_ci NOT NULL,
  `benefit_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E8ECF5CDDBA340EA` (`payroll_id`),
  KEY `IDX_E8ECF5CDE2ABAFFF` (`component_id`),
  CONSTRAINT `FK_E8ECF5CDDBA340EA` FOREIGN KEY (`payroll_id`) REFERENCES `payrolls` (`id`),
  CONSTRAINT `FK_E8ECF5CDE2ABAFFF` FOREIGN KEY (`component_id`) REFERENCES `salary_components` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS company_departments;
CREATE TABLE `company_departments` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `department_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `company_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F7F004CAE80F5DF` (`department_id`),
  KEY `IDX_F7F004C979B1AD6` (`company_id`),
  CONSTRAINT `FK_F7F004C979B1AD6` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `FK_F7F004CAE80F5DF` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS contracts;
CREATE TABLE `contracts` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `type` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `letter_number` varchar(27) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `signed_date` date NOT NULL,
  `tags` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:array)',
  `used` tinyint(1) NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS departments;
CREATE TABLE `departments` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `parent_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `code` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_16AEB8D4727ACA70` (`parent_id`),
  KEY `departments_idx` (`code`,`name`),
  CONSTRAINT `FK_16AEB8D4727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `departments` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS education_titles;
CREATE TABLE `education_titles` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `short_name` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `education_titles_idx` (`short_name`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS educational_institutes;
CREATE TABLE `educational_institutes` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `educational_institutes_idx` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS employee_shiftments;
CREATE TABLE `employee_shiftments` (
  `id` char(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `employee_id` char(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `shiftment_group_id` char(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `active` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employee_shiftments_idx` (`employee_id`,`shiftment_group_id`),
  KEY `employee_shiftments_fk2` (`shiftment_group_id`),
  CONSTRAINT `employee_shiftments_fk1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  CONSTRAINT `employee_shiftments_fk2` FOREIGN KEY (`shiftment_group_id`) REFERENCES `shiftment_groups` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS employees;
CREATE TABLE `employees` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `contract_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `company_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `department_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `joblevel_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `jobtitle_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `supervisor_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `region_of_birth_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `city_of_birth_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `join_date` date NOT NULL,
  `employee_status` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(17) COLLATE utf8_unicode_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `identity_number` varchar(27) COLLATE utf8_unicode_ci NOT NULL,
  `identity_type` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `marital_status` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `leave_balance` int DEFAULT NULL,
  `tax_group` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `resign_date` date DEFAULT NULL,
  `have_overtime_benefit` tinyint(1) NOT NULL,
  `risk_ratio` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `profile_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `profile_size` int DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `salary_group_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shiftment_group_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_BA82C300F5B7AF75` (`address`),
  KEY `IDX_BA82C3002576E0FD` (`contract_id`),
  KEY `IDX_BA82C300979B1AD6` (`company_id`),
  KEY `IDX_BA82C300AE80F5DF` (`department_id`),
  KEY `IDX_BA82C300B1161D41` (`joblevel_id`),
  KEY `IDX_BA82C300E438D15B` (`jobtitle_id`),
  KEY `IDX_BA82C30019E9AC5F` (`supervisor_id`),
  KEY `IDX_BA82C300AF5F9BA3` (`region_of_birth_id`),
  KEY `IDX_BA82C3005BC7B076` (`city_of_birth_id`),
  KEY `employees_idx` (`code`,`full_name`),
  CONSTRAINT `FK_BA82C30019E9AC5F` FOREIGN KEY (`supervisor_id`) REFERENCES `employees` (`id`),
  CONSTRAINT `FK_BA82C3002576E0FD` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`),
  CONSTRAINT `FK_BA82C3005BC7B076` FOREIGN KEY (`city_of_birth_id`) REFERENCES `cities` (`id`),
  CONSTRAINT `FK_BA82C300979B1AD6` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `FK_BA82C300AE80F5DF` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  CONSTRAINT `FK_BA82C300AF5F9BA3` FOREIGN KEY (`region_of_birth_id`) REFERENCES `regions` (`id`),
  CONSTRAINT `FK_BA82C300B1161D41` FOREIGN KEY (`joblevel_id`) REFERENCES `job_levels` (`id`),
  CONSTRAINT `FK_BA82C300E438D15B` FOREIGN KEY (`jobtitle_id`) REFERENCES `job_titles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS fingerprint_devices;
CREATE TABLE `fingerprint_devices` (
  `id` char(36) NOT NULL,
  `serial_number` varchar(50) NOT NULL,
  `ip` varchar(30) NOT NULL,
  `display_name` varchar(30) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fingerprint_devices_serial_number_IDX` (`serial_number`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS holidays;
CREATE TABLE `holidays` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `holiday_date` date NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `holidays_idx` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS job_levels;
CREATE TABLE `job_levels` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `parent_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `code` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CF2E4998727ACA70` (`parent_id`),
  KEY `job_levels_idx` (`code`,`name`),
  CONSTRAINT `FK_CF2E4998727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `job_levels` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS job_mutations;
CREATE TABLE `job_mutations` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `employee_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `old_company_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `old_department_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `old_joblevel_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `old_jobtitle_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `old_supervisor_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `new_company_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `new_department_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `new_joblevel_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `new_jobtitle_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `new_supervisor_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `contract_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `type` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_882F3E4B8C03F15C` (`employee_id`),
  KEY `IDX_882F3E4B2BB82D88` (`old_company_id`),
  KEY `IDX_882F3E4BFAC2279F` (`old_department_id`),
  KEY `IDX_882F3E4B3D794285` (`old_joblevel_id`),
  KEY `IDX_882F3E4B68578E9F` (`old_jobtitle_id`),
  KEY `IDX_882F3E4B4DAB7E1F` (`old_supervisor_id`),
  KEY `IDX_882F3E4B4AA4F91A` (`new_company_id`),
  KEY `IDX_882F3E4BF5001734` (`new_department_id`),
  KEY `IDX_882F3E4B2319AC39` (`new_joblevel_id`),
  KEY `IDX_882F3E4B76376023` (`new_jobtitle_id`),
  KEY `IDX_882F3E4B42694EB4` (`new_supervisor_id`),
  KEY `IDX_882F3E4B2576E0FD` (`contract_id`),
  CONSTRAINT `FK_882F3E4B2319AC39` FOREIGN KEY (`new_joblevel_id`) REFERENCES `job_levels` (`id`),
  CONSTRAINT `FK_882F3E4B2576E0FD` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`),
  CONSTRAINT `FK_882F3E4B2BB82D88` FOREIGN KEY (`old_company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `FK_882F3E4B3D794285` FOREIGN KEY (`old_joblevel_id`) REFERENCES `job_levels` (`id`),
  CONSTRAINT `FK_882F3E4B42694EB4` FOREIGN KEY (`new_supervisor_id`) REFERENCES `employees` (`id`),
  CONSTRAINT `FK_882F3E4B4AA4F91A` FOREIGN KEY (`new_company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `FK_882F3E4B4DAB7E1F` FOREIGN KEY (`old_supervisor_id`) REFERENCES `employees` (`id`),
  CONSTRAINT `FK_882F3E4B68578E9F` FOREIGN KEY (`old_jobtitle_id`) REFERENCES `job_titles` (`id`),
  CONSTRAINT `FK_882F3E4B76376023` FOREIGN KEY (`new_jobtitle_id`) REFERENCES `job_titles` (`id`),
  CONSTRAINT `FK_882F3E4B8C03F15C` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  CONSTRAINT `FK_882F3E4BF5001734` FOREIGN KEY (`new_department_id`) REFERENCES `departments` (`id`),
  CONSTRAINT `FK_882F3E4BFAC2279F` FOREIGN KEY (`old_department_id`) REFERENCES `departments` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS job_placements;
CREATE TABLE `job_placements` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `employee_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `company_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `department_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `joblevel_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `jobtitle_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `supervisor_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `contract_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `active` tinyint(1) NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9689A9648C03F15C` (`employee_id`),
  KEY `IDX_9689A964979B1AD6` (`company_id`),
  KEY `IDX_9689A964AE80F5DF` (`department_id`),
  KEY `IDX_9689A964B1161D41` (`joblevel_id`),
  KEY `IDX_9689A964E438D15B` (`jobtitle_id`),
  KEY `IDX_9689A96419E9AC5F` (`supervisor_id`),
  KEY `IDX_9689A9642576E0FD` (`contract_id`),
  CONSTRAINT `FK_9689A96419E9AC5F` FOREIGN KEY (`supervisor_id`) REFERENCES `employees` (`id`),
  CONSTRAINT `FK_9689A9642576E0FD` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`),
  CONSTRAINT `FK_9689A9648C03F15C` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  CONSTRAINT `FK_9689A964979B1AD6` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `FK_9689A964AE80F5DF` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  CONSTRAINT `FK_9689A964B1161D41` FOREIGN KEY (`joblevel_id`) REFERENCES `job_levels` (`id`),
  CONSTRAINT `FK_9689A964E438D15B` FOREIGN KEY (`jobtitle_id`) REFERENCES `job_titles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS job_titles;
CREATE TABLE `job_titles` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `job_level_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `code` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_91416C2238F6EEDC` (`job_level_id`),
  KEY `job_titles_idx` (`code`,`name`),
  CONSTRAINT `FK_91416C2238F6EEDC` FOREIGN KEY (`job_level_id`) REFERENCES `job_levels` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS leaves;
CREATE TABLE `leaves` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `employee_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `reason_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `leave_date` date NOT NULL,
  `amount` smallint NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9D46AD5F8C03F15C` (`employee_id`),
  KEY `IDX_9D46AD5F59BB1592` (`reason_id`),
  CONSTRAINT `FK_9D46AD5F59BB1592` FOREIGN KEY (`reason_id`) REFERENCES `absent_reasons` (`id`),
  CONSTRAINT `FK_9D46AD5F8C03F15C` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS menus;
CREATE TABLE `menus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `route` varchar(60) DEFAULT NULL,
  `icon` varchar(30) DEFAULT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  `parent_id` int DEFAULT '0',
  `descriptions` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS overtimes;
CREATE TABLE `overtimes` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `employee_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `shiftment_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `approved_by_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `overtime_date` date NOT NULL,
  `start_hour` time NOT NULL,
  `end_hour` time NOT NULL,
  `raw_value` double NOT NULL,
  `calculated_value` double NOT NULL,
  `holiday` tinyint(1) NOT NULL,
  `overday` tinyint(1) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4B7D14D58C03F15C` (`employee_id`),
  KEY `IDX_4B7D14D5180FBE1` (`shiftment_id`),
  KEY `IDX_4B7D14D52D234F6A` (`approved_by_id`),
  CONSTRAINT `FK_4B7D14D5180FBE1` FOREIGN KEY (`shiftment_id`) REFERENCES `shiftments` (`id`),
  CONSTRAINT `FK_4B7D14D52D234F6A` FOREIGN KEY (`approved_by_id`) REFERENCES `employees` (`id`),
  CONSTRAINT `FK_4B7D14D58C03F15C` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS payroll_details;
CREATE TABLE `payroll_details` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `payroll_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `component_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `benefit_value` longtext COLLATE utf8_unicode_ci NOT NULL,
  `benefit_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E4A11F3DDBA340EA` (`payroll_id`),
  KEY `IDX_E4A11F3DE2ABAFFF` (`component_id`),
  CONSTRAINT `FK_E4A11F3DDBA340EA` FOREIGN KEY (`payroll_id`) REFERENCES `payrolls` (`id`),
  CONSTRAINT `FK_E4A11F3DE2ABAFFF` FOREIGN KEY (`component_id`) REFERENCES `salary_components` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS payroll_periods;
CREATE TABLE `payroll_periods` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `company_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `year` smallint NOT NULL,
  `month` smallint NOT NULL,
  `closed` tinyint(1) NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F1908C15979B1AD6` (`company_id`),
  KEY `payroll_periods_idx` (`month`,`year`),
  CONSTRAINT `FK_F1908C15979B1AD6` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS payrolls;
CREATE TABLE `payrolls` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `employee_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `period_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `take_home_pay` longtext COLLATE utf8_unicode_ci,
  `take_home_pay_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_694037328C03F15C` (`employee_id`),
  KEY `IDX_69403732EC8B7ADE` (`period_id`),
  CONSTRAINT `FK_694037328C03F15C` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  CONSTRAINT `FK_69403732EC8B7ADE` FOREIGN KEY (`period_id`) REFERENCES `payroll_periods` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS permissions;
CREATE TABLE `permissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `route` varchar(60) NOT NULL,
  `menus_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_menu_details` (`route`,`menus_id`),
  KEY `fk_menu_details` (`menus_id`),
  CONSTRAINT `fk_menu_details` FOREIGN KEY (`menus_id`) REFERENCES `menus` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS regions;
CREATE TABLE `regions` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `code` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `regions_idx` (`code`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS role_menus;
CREATE TABLE `role_menus` (
  `roles_id` int NOT NULL,
  `menus_id` int NOT NULL,
  `status` varchar(1) DEFAULT '1',
  UNIQUE KEY `uq_role_men` (`roles_id`,`menus_id`),
  KEY `fk_role_menu_details` (`menus_id`),
  CONSTRAINT `fk_role_menu_details` FOREIGN KEY (`menus_id`) REFERENCES `menus` (`id`),
  CONSTRAINT `fk_role_menu_details2` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS role_permissions;
CREATE TABLE `role_permissions` (
  `roles_id` int NOT NULL,
  `permissions_id` int NOT NULL,
  `status` varchar(1) DEFAULT '1',
  UNIQUE KEY `uq_role_permissions` (`roles_id`,`permissions_id`),
  KEY `fk_role_permissions` (`permissions_id`),
  CONSTRAINT `fk_role_permissions` FOREIGN KEY (`permissions_id`) REFERENCES `permissions` (`id`),
  CONSTRAINT `fk_role_permissions2` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS roles;
CREATE TABLE `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  `status` varchar(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS salary_allowances;
CREATE TABLE `salary_allowances` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `employee_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `component_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `year` smallint NOT NULL,
  `month` smallint NOT NULL,
  `benefit_value` longtext COLLATE utf8_unicode_ci,
  `benefit_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7BAF1CE38C03F15C` (`employee_id`),
  KEY `IDX_7BAF1CE3E2ABAFFF` (`component_id`),
  CONSTRAINT `FK_7BAF1CE38C03F15C` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  CONSTRAINT `FK_7BAF1CE3E2ABAFFF` FOREIGN KEY (`component_id`) REFERENCES `salary_components` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS salary_benefit_histories;
CREATE TABLE `salary_benefit_histories` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `employee_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `component_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `contract_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `new_benefit_value` longtext COLLATE utf8_unicode_ci,
  `old_benefit_value` longtext COLLATE utf8_unicode_ci,
  `benefit_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2DF1CF538C03F15C` (`employee_id`),
  KEY `IDX_2DF1CF53E2ABAFFF` (`component_id`),
  KEY `IDX_2DF1CF532576E0FD` (`contract_id`),
  CONSTRAINT `FK_2DF1CF532576E0FD` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`),
  CONSTRAINT `FK_2DF1CF538C03F15C` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  CONSTRAINT `FK_2DF1CF53E2ABAFFF` FOREIGN KEY (`component_id`) REFERENCES `salary_components` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS salary_benefits;
CREATE TABLE `salary_benefits` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `employee_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `component_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `benefit_value` longtext COLLATE utf8_unicode_ci,
  `benefit_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_41FC3FF8C03F15C` (`employee_id`),
  KEY `IDX_41FC3FFE2ABAFFF` (`component_id`),
  CONSTRAINT `FK_41FC3FF8C03F15C` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  CONSTRAINT `FK_41FC3FFE2ABAFFF` FOREIGN KEY (`component_id`) REFERENCES `salary_components` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS salary_components;
CREATE TABLE `salary_components` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `code` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `fixed` tinyint(1) NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `salary_components_idx` (`code`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS salary_group_details;
CREATE TABLE `salary_group_details` (
  `id` char(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `component_id` char(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `salary_group_id` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `component_value` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_salary_group_detail_1` (`component_id`,`salary_group_id`),
  KEY `fk_salary_group_details_1` (`salary_group_id`),
  KEY `fk_salary_group_details_2_idx` (`component_id`),
  CONSTRAINT `fk_salary_group_details_1` FOREIGN KEY (`salary_group_id`) REFERENCES `salary_groups` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_salary_group_details_2` FOREIGN KEY (`component_id`) REFERENCES `salary_components` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS salary_groups;
CREATE TABLE `salary_groups` (
  `id` char(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `code` varchar(7) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS settings;
CREATE TABLE `settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `value` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS shiftment_groups;
CREATE TABLE `shiftment_groups` (
  `id` char(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `code` varchar(7) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `company_id` char(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shiftment_id` char(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `shiftments_idx` (`company_id`,`shiftment_id`),
  KEY `shiftment_groups_fk2` (`shiftment_id`),
  CONSTRAINT `shiftment_groups_fk1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `shiftment_groups_fk2` FOREIGN KEY (`shiftment_id`) REFERENCES `shiftments` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS shiftments;
CREATE TABLE `shiftments` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `code` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `start_hour` time NOT NULL,
  `end_hour` time NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `shiftments_idx` (`code`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS skill_groups;
CREATE TABLE `skill_groups` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `parent_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DF276D64727ACA70` (`parent_id`),
  KEY `skill_groups_idx` (`name`),
  CONSTRAINT `FK_DF276D64727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `skill_groups` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS skills;
CREATE TABLE `skills` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `skill_group_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D5311670BCFCB4B5` (`skill_group_id`),
  KEY `skills_idx` (`name`),
  CONSTRAINT `FK_D5311670BCFCB4B5` FOREIGN KEY (`skill_group_id`) REFERENCES `skill_groups` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS tax_group_history;
CREATE TABLE `tax_group_history` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `employee_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `old_tax_group` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `new_tax_group` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `old_risk_ratio` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `new_risk_ratio` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5FFE0F928C03F15C` (`employee_id`),
  CONSTRAINT `FK_5FFE0F928C03F15C` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS taxs;
CREATE TABLE `taxs` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `period_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `employee_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `tax_group` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `untaxable` longtext COLLATE utf8_unicode_ci,
  `taxable` longtext COLLATE utf8_unicode_ci,
  `tax_value` longtext COLLATE utf8_unicode_ci,
  `tax_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A2E69AB8EC8B7ADE` (`period_id`),
  KEY `IDX_A2E69AB88C03F15C` (`employee_id`),
  CONSTRAINT `FK_A2E69AB88C03F15C` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  CONSTRAINT `FK_A2E69AB8EC8B7ADE` FOREIGN KEY (`period_id`) REFERENCES `payroll_periods` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS user_roles;
CREATE TABLE `user_roles` (
  `user_id` int NOT NULL,
  `role_id` int NOT NULL,
  UNIQUE KEY `uq_user_role` (`user_id`,`role_id`),
  KEY `fk_user_role2` (`role_id`),
  CONSTRAINT `fk_user_role1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_user_role2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS users;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(12) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(60) NOT NULL,
  `password_salt` varchar(255) DEFAULT NULL,
  `status` varchar(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_users` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS workshifts;
CREATE TABLE `workshifts` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `employee_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `shiftment_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `work_date` date NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BFDEE69C8C03F15C` (`employee_id`),
  KEY `IDX_BFDEE69C180FBE1` (`shiftment_id`),
  CONSTRAINT `FK_BFDEE69C180FBE1` FOREIGN KEY (`shiftment_id`) REFERENCES `shiftments` (`id`),
  CONSTRAINT `FK_BFDEE69C8C03F15C` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

INSERT INTO absent_reasons(id,type,code,name,created_by,updated_by,deleted_at,created_at,updated_at) VALUES('175fd006-ae7e-4eca-bc5e-846b3a7fee3b','l','CT','CUTI TAHUNAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('5502dfbb-11f1-4137-956f-11373a99fe4e','a','SKT','SAKIT SURAT DOKTER',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('f13f41c9-68db-4b19-a929-b324ca17658f','a','ABS','TANPA KETERANGAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39');

INSERT INTO activity_log(id,route,send_data,comment,created_by,created_at) VALUES('0c5dc51d-de2c-4ae3-aac8-92b070393466','master/permission/save',X'7b22504f5354223a7b2264617461223a7b226e616d65223a226164645f73616c6172795f67726f75705f64657461696c73222c22726f757465223a226d61737465725c2f73616c6172795f67726f75705f64657461696c222c226d656e75735f6964223a223338227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-02-28 05:41:22'),('172f174c-39f7-4c60-afe4-9e930d80cd8c','master/salary_groups/save',X'7b22504f5354223a7b2264617461223a7b22636f6465223a225031574a43222c226e616d65223a2253616c617279206c6576656c20737461666620576a63222c226964223a22227d2c226b6579223a7b226964223a22227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-02-29 09:07:40'),('22b6d9be-48b8-4ec2-8920-ceec1b77dfa6','master/role_permission/save',X'7b22504f5354223a7b2264617461223a7b226d656e755f31223a2231222c226d656e755f32223a2232222c226d656e755f33223a2233222c226d656e755f34223a2234222c226d656e755f36223a2236222c226d656e755f37223a2237222c226d656e755f38223a2238222c226d656e755f39223a2239222c226d656e755f3130223a223130222c226d656e755f3131223a223131222c226d656e755f3132223a223132222c226d656e755f3133223a223133222c226d656e755f3134223a223134222c226d656e755f3135223a223135222c226d656e755f3136223a223136222c226d656e755f3137223a223137222c226d656e755f3138223a223138222c226d656e755f3139223a223139222c226d656e755f3231223a223231222c226d656e755f3232223a223232222c226d656e755f3233223a223233222c226d656e755f3234223a223234222c226d656e755f3235223a223235222c226d656e755f3236223a223236222c226d656e755f3237223a223237222c226d656e755f3238223a223238222c226d656e755f3239223a223239222c226d656e755f3330223a223330222c226d656e755f3331223a223331222c226d656e755f3332223a223332222c226d656e755f3333223a223333222c226d656e755f3334223a223334222c226d656e755f3335223a223335222c226d656e755f3336223a223336222c226d656e755f3337223a223337222c226d656e755f3338223a223338222c227065726d697373696f6e735f31223a2231222c226d656e755f3339223a223339222c226d656e755f3430223a223430222c22726f6c65735f6964223a2231227d2c226b6579223a7b22726f6c65735f6964223a2231227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-02-29 20:24:11'),('243e6414-a330-4c06-89b8-d11114ec8ea4','master/employees/save',X'7b22504f5354223a7b2264617461223a7b22636f6465223a224d4953303030303031222c2266756c6c5f6e616d65223a224d5548414d414420535552594120494b53414e5544494e222c2267656e646572223a224d222c22646174655f6f665f6269727468223a22313938372d30312d3031222c226964656e746974795f6e756d626572223a22333331303132333231222c226964656e746974795f74797065223a224b5450222c226d61726974616c5f737461747573223a224d222c22656d61696c223a2261646d696e407373692e636f6d222c22726567696f6e5f6f665f62697274685f6964223a2235616464646262332d643864632d343037382d613035332d316133636131316163333536222c22636974795f6f665f62697274685f6964223a2236346434363730352d643339302d343032352d626663662d383738326663303632373137222c2261646472657373223a2267657262616e672033222c226a6f696e5f64617465223a22323031372d30332d3137222c22636f6e74726163745f6964223a2261376465383430312d346465642d343563372d626233392d323061306537353034343637222c22636f6d70616e795f6964223a2230373565346561642d633335362d346337392d616265362d616366623135633730656462222c226465706172746d656e745f6964223a2232333431333330372d316432352d343934392d383039612d346363303732653736306231222c226a6f627469746c655f6964223a2231363031653064322d396161662d343838302d623035392d623831396534626239303764222c2273757065727669736f725f6964223a2230222c22656d706c6f7965655f737461747573223a224b222c227461785f67726f7570223a22544b222c2273616c6172795f67726f75705f6964223a2263313032386363352d646636332d343839392d396634662d633235643130623966666637222c2273686966746d656e745f67726f75705f6964223a2236313135613866642d373166632d343861652d613535622d303830316138346334386564222c2272657369676e5f64617465223a22323032302d30322d3239222c22686176655f6f76657274696d655f62656e65666974223a2231222c227269736b5f726174696f223a22766c72222c226964223a2262633733393933632d376339342d346231622d393631312d653566666338633664613964227d2c226b6579223a7b226964223a2262633733393933632d376339342d346231622d393631312d653566666338633664613964227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-02-29 22:28:47'),('250a663b-e85f-4b07-8903-766779fc7701','master/salary_groups/save',X'7b22504f5354223a7b2264617461223a7b22636f6465223a22505354414646574a43222c226e616d65223a2253616c617279206c6576656c207374616666227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-02-29 08:59:13'),('38fc7dea-7757-424f-a4b1-205d86ca5c67','master/salary_group_details/save',X'7b22504f5354223a7b2264617461223a7b22636f6d706f6e656e745f6964223a2231613062353961382d343031312d343561342d393266652d306462373062353535653033222c22636f6d706f6e656e745f76616c7565223a22333030303030222c2273616c6172795f67726f75705f6964223a2263313032386363352d646636332d343839392d396634662d633235643130623966666637227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-02-29 10:50:31'),('3acaf576-54b0-4e46-85d2-a37a6cd49fce','master/menu/save',X'7b22504f5354223a7b2264617461223a7b226e616d65223a2253616c6172792067726f7570222c22726f757465223a226d61737465725c2f73616c6172795f67726f7570222c2269636f6e223a2266612066612d6d6f6e6579222c22706172656e745f6964223a2231222c22737461747573223a2231222c226465736372697074696f6e73223a226d61737465722073616c6172792067726f7570227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-02-28 05:38:44'),('40b224a4-fa75-4e69-bcb7-14d3d8f981a3','master/menu/save',X'7b22504f5354223a7b2264617461223a7b226e616d65223a225265706f7274222c22726f757465223a22222c2269636f6e223a2266612066612d6772617068222c22706172656e745f6964223a2230222c22737461747573223a2231222c226465736372697074696f6e73223a2247726f7570207265706f7274696e67222c226964223a223336227d2c226b6579223a7b226964223a223336227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-02-27 08:49:57'),('4e55c56e-3f89-4ba0-9a09-5915986f993d','master/shiftments/save',X'7b22504f5354223a7b2264617461223a7b22636f6465223a2253484633222c226e616d65223a2253686966742033222c2273746172745f686f7572223a2232333a3030222c22656e645f686f7572223a2230373a3030227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-02-27 11:00:51'),('56906d30-91e3-4ec5-acc8-1ee20e923952','master/importWorkshift/save',X'7b22504f5354223a7b2264617461223a7b2266696c655f6e616d65223a226a616477616c5f6b65726a612e786c73222c226174746163686d656e74223a2275706c6f6164735c2f6a616477616c5c2f6a616477616c5f6b65726a6131342e786c73227d2c226b6579223a7b226174746163686d656e74223a2275706c6f6164735c2f6a616477616c5c2f6a616477616c5f6b65726a6131342e786c73227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-03-02 15:42:13'),('5e6fd0cf-baeb-4118-a441-fcf93baaf52c','master/salary_groups/save',X'7b22504f5354223a7b2264617461223a7b22636f6465223a225032574a43222c226e616d65223a2247616a69206b6172796177616e206b6f6e7472616b227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-02-29 09:10:24'),('62588f78-79b0-4316-bd95-b9fca73e596e','master/importWorkshift/save',X'7b22504f5354223a7b2264617461223a7b2266696c655f6e616d65223a226a616477616c5f6b65726a612e786c73222c226174746163686d656e74223a2275706c6f6164735c2f6a616477616c5c2f6a616477616c5f6b65726a6132302e786c73227d2c226b6579223a7b226174746163686d656e74223a2275706c6f6164735c2f6a616477616c5c2f6a616477616c5f6b65726a6132302e786c73227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-03-02 15:52:44'),('71cb4b55-fc9f-4d47-87bd-555b0eae31c4','master/salary_group_details/save',X'7b22504f5354223a7b2264617461223a7b22636f6d706f6e656e745f6964223a2232303537663333302d633533322d346533642d383366362d373561333565383938376437222c22636f6d706f6e656e745f76616c7565223a2234353030303030222c2273616c6172795f67726f75705f6964223a2263313032386363352d646636332d343839392d396634662d633235643130623966666637227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-02-29 10:55:33'),('7b1b65a5-8301-4c2a-905a-40791781afe8','master/employees/save',X'7b22504f5354223a7b2264617461223a7b22636f6465223a224d4953303030303031222c2266756c6c5f6e616d65223a224d5548414d414420535552594120494b53414e5544494e222c2267656e646572223a224d222c22646174655f6f665f6269727468223a22313938372d30312d3031222c226964656e746974795f6e756d626572223a22333331303132333231222c226964656e746974795f74797065223a224b5450222c226d61726974616c5f737461747573223a224d222c22656d61696c223a2261646d696e407373692e636f6d222c22726567696f6e5f6f665f62697274685f6964223a2235616464646262332d643864632d343037382d613035332d316133636131316163333536222c22636974795f6f665f62697274685f6964223a2236346434363730352d643339302d343032352d626663662d383738326663303632373137222c2261646472657373223a2267657262616e672033222c226a6f696e5f64617465223a22323031372d30332d3137222c22636f6e74726163745f6964223a2261376465383430312d346465642d343563372d626233392d323061306537353034343637222c22636f6d70616e795f6964223a2230373565346561642d633335362d346337392d616265362d616366623135633730656462222c226465706172746d656e745f6964223a2232333431333330372d316432352d343934392d383039612d346363303732653736306231222c226a6f627469746c655f6964223a2231363031653064322d396161662d343838302d623035392d623831396534626239303764222c2273757065727669736f725f6964223a2230222c22656d706c6f7965655f737461747573223a224b222c227461785f67726f7570223a22544b222c2273616c6172795f67726f75705f6964223a2263313032386363352d646636332d343839392d396634662d633235643130623966666637222c2273686966746d656e745f67726f75705f6964223a2236313135613866642d373166632d343861652d613535622d303830316138346334386564222c2272657369676e5f64617465223a22496e76616c69642064617465222c22686176655f6f76657274696d655f62656e65666974223a2231222c227269736b5f726174696f223a22766c72222c226964223a2262633733393933632d376339342d346231622d393631312d653566666338633664613964227d2c226b6579223a7b226964223a2262633733393933632d376339342d346231622d393631312d653566666338633664613964227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-02-29 21:57:21'),('7b7beb94-1e10-4075-b56c-44ba0fb34738','master/shiftment_groups/save',X'7b22504f5354223a7b2264617461223a7b22636f6465223a2253534932222c22636f6d70616e795f6964223a2230373565346561642d633335362d346337392d616265362d616366623135633730656462222c2273686966746d656e745f6964223a2236623763306663612d623831362d346366612d393663392d646331666333633937633635222c226e616d65223a225353492053686966742032227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-02-29 20:27:32'),('830e0f89-fd5b-498e-a365-520a069d33bd','master/shiftments/save',X'7b22504f5354223a7b2264617461223a7b22636f6465223a2253484632222c226e616d65223a2253686966742032222c2273746172745f686f7572223a2231353a3030222c22656e645f686f7572223a2232333a3030227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-02-27 11:00:22'),('850eb90c-0c93-4978-84a7-49dd7b9ba490','master/shiftments/save',X'7b22504f5354223a7b2264617461223a7b22636f6465223a2253484631222c226e616d65223a2253686966742031222c2273746172745f686f7572223a2230373a3030222c22656e645f686f7572223a2231353a3030227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-02-27 10:59:45'),('8d2efe7d-626a-43fd-bd1d-5918383923ea','master/shiftment_groups/save',X'7b22504f5354223a7b2264617461223a7b22636f6465223a225353495331222c22636f6d70616e795f6964223a2230373565346561642d633335362d346337392d616265362d616366623135633730656462222c2273686966746d656e745f6964223a2238663765373063622d336564652d343238632d623766322d346535663764363165346666222c226e616d65223a225353492053686966742031227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-02-29 20:27:07'),('9340f6f0-e05a-476d-8282-a5b752aeaf7f','master/importWorkshift/save',X'7b22504f5354223a7b2264617461223a7b2266696c655f6e616d65223a226a616477616c5f6b65726a612e786c73222c226174746163686d656e74223a2275706c6f6164735c2f6a616477616c5c2f6a616477616c5f6b65726a6131342e786c73227d2c226b6579223a7b226174746163686d656e74223a2275706c6f6164735c2f6a616477616c5c2f6a616477616c5f6b65726a6131342e786c73227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-03-02 15:43:03'),('99fca173-4044-48de-9e4e-9c32014ef54d','master/employees/save',X'7b22504f5354223a7b2264617461223a7b22636f6465223a224d4953303030303031222c2266756c6c5f6e616d65223a224d5548414d414420535552594120494b53414e5544494e222c2267656e646572223a224d222c22646174655f6f665f6269727468223a22313938372d30312d3031222c226964656e746974795f6e756d626572223a22333331303132333231222c226964656e746974795f74797065223a224b5450222c226d61726974616c5f737461747573223a224d222c22656d61696c223a2261646d696e407373692e636f6d222c22726567696f6e5f6f665f62697274685f6964223a2235616464646262332d643864632d343037382d613035332d316133636131316163333536222c22636974795f6f665f62697274685f6964223a2236346434363730352d643339302d343032352d626663662d383738326663303632373137222c2261646472657373223a2267657262616e672033222c226a6f696e5f64617465223a22323031372d30332d3137222c22636f6e74726163745f6964223a2261376465383430312d346465642d343563372d626233392d323061306537353034343637222c22636f6d70616e795f6964223a2230373565346561642d633335362d346337392d616265362d616366623135633730656462222c226465706172746d656e745f6964223a2232333431333330372d316432352d343934392d383039612d346363303732653736306231222c226a6f627469746c655f6964223a2231363031653064322d396161662d343838302d623035392d623831396534626239303764222c2273757065727669736f725f6964223a2230222c22656d706c6f7965655f737461747573223a224b222c227461785f67726f7570223a22544b222c2273616c6172795f67726f75705f6964223a2263313032386363352d646636332d343839392d396634662d633235643130623966666637222c2273686966746d656e745f67726f75705f6964223a2236313135613866642d373166632d343861652d613535622d303830316138346334386564222c2272657369676e5f64617465223a22496e76616c69642064617465222c22686176655f6f76657274696d655f62656e65666974223a2231222c227269736b5f726174696f223a22766c72222c226964223a2262633733393933632d376339342d346231622d393631312d653566666338633664613964227d2c226b6579223a7b226964223a2262633733393933632d376339342d346231622d393631312d653566666338633664613964227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-02-29 22:28:17'),('9bce5eba-6b46-462b-95d3-a4a83168d11d','master/menu/save',X'7b22504f5354223a7b2264617461223a7b226e616d65223a2247616e74692050617373776f7264222c22726f757465223a22757365725c2f757365725c2f6368616e676550617373776f7264222c2269636f6e223a2266612066612d6b657973222c22706172656e745f6964223a2230222c22737461747573223a2231222c226465736372697074696f6e73223a2247616e74692070617373776f7264227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-02-29 08:35:55'),('9ee852f5-cc86-4178-a7cc-7288090b25a5','master/employees/save',X'7b22504f5354223a7b2264617461223a7b22636f6465223a224d4953303030303032222c2266756c6c5f6e616d65223a2241686d6164204166616e6469222c2267656e646572223a224d222c22646174655f6f665f6269727468223a22313938352d30332d3230222c226964656e746974795f6e756d626572223a2239303938393538393433383932222c226964656e746974795f74797065223a224b5450222c226d61726974616c5f737461747573223a224d222c22656d61696c223a2261686d61642e6166616e6469383540676d61696c2e636f6d222c22726567696f6e5f6f665f62697274685f6964223a2239623432333130662d653064632d343931622d396532322d666639303339366331323134222c22636974795f6f665f62697274685f6964223a2263623432373133362d306237662d346133342d613034372d643734633534613262306235222c2261646472657373223a226b6c6167656e222c226a6f696e5f64617465223a22323031392d31322d3032222c22636f6e74726163745f6964223a2261376465383430312d346465642d343563372d626233392d323061306537353034343637222c22636f6d70616e795f6964223a2230373565346561642d633335362d346337392d616265362d616366623135633730656462222c226465706172746d656e745f6964223a2232636466363437652d653035332d343261632d623732632d656262353533336230366335222c226a6f627469746c655f6964223a2231363031653064322d396161662d343838302d623035392d623831396534626239303764222c2273757065727669736f725f6964223a2262633733393933632d376339342d346231622d393631312d653566666338633664613964222c22656d706c6f7965655f737461747573223a224b222c227461785f67726f7570223a22544b222c2273616c6172795f67726f75705f6964223a2265383163623361642d303233662d343139612d616431392d346434346362343235323033222c2273686966746d656e745f67726f75705f6964223a2262623535346563322d633865372d343931392d616531352d383630663437386536623961222c2272657369676e5f64617465223a22496e76616c69642064617465222c22686176655f6f76657274696d655f62656e65666974223a2231222c227269736b5f726174696f223a22222c226964223a2238613233316434312d613561372d343934352d386364372d646633626638396333303831227d2c226b6579223a7b226964223a2238613233316434312d613561372d343934352d386364372d646633626638396333303831227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-02-29 22:20:31'),('a22acee0-5fa3-4f7d-b048-eeaf97f398c4','master/employees/save',X'7b22504f5354223a7b2264617461223a7b22636f6465223a224d4953303030303031222c2266756c6c5f6e616d65223a224d5548414d414420535552594120494b53414e5544494e222c2267656e646572223a224d222c22646174655f6f665f6269727468223a22313938372d30312d3031222c226964656e746974795f6e756d626572223a22333331303132333231222c226964656e746974795f74797065223a224b5450222c226d61726974616c5f737461747573223a224d222c22656d61696c223a2261646d696e407373692e636f6d222c22726567696f6e5f6f665f62697274685f6964223a2235616464646262332d643864632d343037382d613035332d316133636131316163333536222c22636974795f6f665f62697274685f6964223a2236346434363730352d643339302d343032352d626663662d383738326663303632373137222c2261646472657373223a2267657262616e672033222c226a6f696e5f64617465223a22323031372d30332d3137222c22636f6e74726163745f6964223a2261376465383430312d346465642d343563372d626233392d323061306537353034343637222c22636f6d70616e795f6964223a2230373565346561642d633335362d346337392d616265362d616366623135633730656462222c226465706172746d656e745f6964223a2232333431333330372d316432352d343934392d383039612d346363303732653736306231222c226a6f627469746c655f6964223a2231363031653064322d396161662d343838302d623035392d623831396534626239303764222c2273757065727669736f725f6964223a2230222c22656d706c6f7965655f737461747573223a224b222c227461785f67726f7570223a22544b222c2273616c6172795f67726f75705f6964223a2263313032386363352d646636332d343839392d396634662d633235643130623966666637222c2273686966746d656e745f67726f75705f6964223a2236313135613866642d373166632d343861652d613535622d303830316138346334386564222c2272657369676e5f64617465223a22496e76616c69642064617465222c22686176655f6f76657274696d655f62656e65666974223a2231222c227269736b5f726174696f223a22766c72222c226964223a2262633733393933632d376339342d346231622d393631312d653566666338633664613964227d2c226b6579223a7b226964223a2262633733393933632d376339342d346231622d393631312d653566666338633664613964227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-02-29 22:29:03'),('a4e07234-3100-4662-b7f3-571c25e5b3ab','master/salary_group_details/save',X'7b22504f5354223a7b2264617461223a7b22636f6d706f6e656e745f6964223a2231613062353961382d343031312d343561342d393266652d306462373062353535653033222c22636f6d706f6e656e745f76616c7565223a22343530303030222c2273616c6172795f67726f75705f6964223a2265383163623361642d303233662d343139612d616431392d346434346362343235323033227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-02-29 11:25:24'),('b22821cb-83d4-4448-ac6c-d5609c61531b','master/employees/save',X'7b22504f5354223a7b2264617461223a7b22636f6465223a224d4953303030303031222c2266756c6c5f6e616d65223a224d5548414d414420535552594120494b53414e5544494e222c2267656e646572223a224d222c22646174655f6f665f6269727468223a22313938372d30312d3031222c226964656e746974795f6e756d626572223a22333331303132333231222c226964656e746974795f74797065223a224b5450222c226d61726974616c5f737461747573223a224d222c22656d61696c223a2261646d696e407373692e636f6d222c22726567696f6e5f6f665f62697274685f6964223a2235616464646262332d643864632d343037382d613035332d316133636131316163333536222c22636974795f6f665f62697274685f6964223a2236346434363730352d643339302d343032352d626663662d383738326663303632373137222c2261646472657373223a2267657262616e672033222c226a6f696e5f64617465223a22323031372d30332d3137222c22636f6e74726163745f6964223a2261376465383430312d346465642d343563372d626233392d323061306537353034343637222c22636f6d70616e795f6964223a2230373565346561642d633335362d346337392d616265362d616366623135633730656462222c226465706172746d656e745f6964223a2232333431333330372d316432352d343934392d383039612d346363303732653736306231222c226a6f627469746c655f6964223a2231363031653064322d396161662d343838302d623035392d623831396534626239303764222c2273757065727669736f725f6964223a2230222c22656d706c6f7965655f737461747573223a224b222c227461785f67726f7570223a22544b222c2273616c6172795f67726f75705f6964223a2263313032386363352d646636332d343839392d396634662d633235643130623966666637222c2273686966746d656e745f67726f75705f6964223a2236313135613866642d373166632d343861652d613535622d303830316138346334386564222c2272657369676e5f64617465223a22496e76616c69642064617465222c22686176655f6f76657274696d655f62656e65666974223a2231222c227269736b5f726174696f223a22766c72222c226964223a2262633733393933632d376339342d346231622d393631312d653566666338633664613964227d2c226b6579223a7b226964223a2262633733393933632d376339342d346231622d393631312d653566666338633664613964227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-02-29 22:27:08'),('b78a952c-9c72-404d-9475-487accfc8ae0','master/shiftment_groups/save',X'7b22504f5354223a7b2264617461223a7b22636f6465223a225353494e53222c22636f6d70616e795f6964223a2230373565346561642d633335362d346337392d616265362d616366623135633730656462222c2273686966746d656e745f6964223a2263343664643837302d613937372d343934302d383361372d643238393633653737306438222c226e616d65223a224265626173207368696674227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-02-29 20:26:34'),('bac7ef0b-c331-4bbe-8c96-4594890c4547','master/shiftments/save',X'7b22504f5354223a7b2264617461223a7b22636f6465223a225348464c222c226e616d65223a224c69627572222c2273746172745f686f7572223a2230303a3030222c22656e645f686f7572223a2230303a3030227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-03-02 13:10:43'),('e3ceac12-2e63-4bf7-ba6e-630588d68e62','master/salary_groups/save',X'7b22504f5354223a7b2264617461223a7b22636f6465223a225031574a43222c226e616d65223a2247616a6920737461666620574a43227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-02-29 09:10:07'),('f0dd0ae7-55e8-4200-83b3-0d305c817381','master/menu/save',X'7b22504f5354223a7b2264617461223a7b226e616d65223a2253686966746d656e742047726f7570222c22726f757465223a226d61737465725c2f73686966746d656e745f67726f757073222c2269636f6e223a2266612066612d7461626c65222c22706172656e745f6964223a2231222c22737461747573223a2231222c226465736372697074696f6e73223a224461667461722077616b74752073686966742079616e67206265726c616b752064616c616d207065727573616861616e227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-02-29 20:23:50'),('f12b6e12-1cf8-4524-98e9-319d7205feae','master/menu/save',X'7b22504f5354223a7b2264617461223a7b226e616d65223a225265706f7274222c22726f757465223a22222c2269636f6e223a2266612066612d6772617068222c22706172656e745f6964223a2230222c22737461747573223a2231222c226465736372697074696f6e73223a2247726f7570207265706f7274696e67222c226964223a223336227d2c226b6579223a7b226964223a223336227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-02-27 08:41:06'),('f4341272-545b-40e5-a9d1-25c6437b4554','master/role_permission/save',X'7b22504f5354223a7b2264617461223a7b226d656e755f31223a2231222c226d656e755f32223a2232222c226d656e755f33223a2233222c226d656e755f34223a2234222c226d656e755f36223a2236222c226d656e755f37223a2237222c226d656e755f38223a2238222c226d656e755f39223a2239222c226d656e755f3130223a223130222c226d656e755f3131223a223131222c226d656e755f3132223a223132222c226d656e755f3133223a223133222c226d656e755f3134223a223134222c226d656e755f3135223a223135222c226d656e755f3136223a223136222c226d656e755f3137223a223137222c226d656e755f3138223a223138222c226d656e755f3139223a223139222c226d656e755f3231223a223231222c226d656e755f3232223a223232222c226d656e755f3233223a223233222c226d656e755f3234223a223234222c226d656e755f3235223a223235222c226d656e755f3236223a223236222c226d656e755f3237223a223237222c226d656e755f3238223a223238222c226d656e755f3239223a223239222c226d656e755f3330223a223330222c226d656e755f3331223a223331222c226d656e755f3332223a223332222c226d656e755f3333223a223333222c226d656e755f3334223a223334222c226d656e755f3335223a223335222c226d656e755f3336223a223336222c226d656e755f3337223a223337222c226d656e755f3338223a223338222c227065726d697373696f6e735f31223a2231222c226d656e755f3339223a223339222c22726f6c65735f6964223a2231227d2c226b6579223a7b22726f6c65735f6964223a2231227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-02-29 08:36:24'),('fe06df36-ed72-4fc6-a233-a044f2a20da1','master/employees/save',X'7b22504f5354223a7b2264617461223a7b22636f6465223a224d4953303030303032222c2266756c6c5f6e616d65223a2241686d6164204166616e6469222c2267656e646572223a224d222c22646174655f6f665f6269727468223a22313938352d30332d3230222c226964656e746974795f6e756d626572223a2239303938393538393433383932222c226964656e746974795f74797065223a224b5450222c226d61726974616c5f737461747573223a224d222c22656d61696c223a2261686d61642e6166616e6469383540676d61696c2e636f6d222c22726567696f6e5f6f665f62697274685f6964223a2239623432333130662d653064632d343931622d396532322d666639303339366331323134222c22636974795f6f665f62697274685f6964223a2265626234643136662d303830332d346664622d383332612d316662343066636433663163222c2261646472657373223a226b6c6167656e222c226a6f696e5f64617465223a22323031392d31322d3032222c22636f6e74726163745f6964223a2261376465383430312d346465642d343563372d626233392d323061306537353034343637222c22636f6d70616e795f6964223a2230373565346561642d633335362d346337392d616265362d616366623135633730656462222c226465706172746d656e745f6964223a2232636466363437652d653035332d343261632d623732632d656262353533336230366335222c226a6f627469746c655f6964223a2231363031653064322d396161662d343838302d623035392d623831396534626239303764222c2273757065727669736f725f6964223a2262633733393933632d376339342d346231622d393631312d653566666338633664613964222c22656d706c6f7965655f737461747573223a224b222c227461785f67726f7570223a22544b222c2273616c6172795f67726f75705f6964223a2265383163623361642d303233662d343139612d616431392d346434346362343235323033222c2273686966746d656e745f67726f75705f6964223a2262623535346563322d633865372d343931392d616531352d383630663437386536623961222c2272657369676e5f64617465223a22496e76616c69642064617465222c22686176655f6f76657274696d655f62656e65666974223a2231222c227269736b5f726174696f223a22227d7d2c22474554223a5b5d7d',X'6163746976697479206c6f67',1,'2020-02-29 22:09:03');





INSERT INTO cities(id,region_id,code,name,created_by,updated_by,deleted_at,created_at,updated_at) VALUES('002b29cf-076b-41f5-94b5-6eb1666ab3d2','8a61c56a-b1c0-4140-98f1-5afcb05843bf','16.02','KABUPATEN OGAN KOMERING ILIR',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('004417ac-5f5c-40f4-be38-d2a88250d8b6','d96797ff-3079-443b-8cf3-31d1feae59f7','53.03','KABUPATEN TIMOR TENGAH UTARA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('0095139f-a7bd-43f0-a8d6-c22e434d8cac','e093b3d5-ce15-4a1d-95af-d0f9b0f5c0ac','72.03','KABUPATEN DONGGALA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('00c36ac1-53d0-48af-9bf5-ced2bdd556c5','8a61c56a-b1c0-4140-98f1-5afcb05843bf','16.72','KOTA PAGAR ALAM',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('013b10ab-e41a-4ba9-a47b-c978888577cd','4286d1f8-fbd2-48b0-a207-f01fc52849fb','91.03','KABUPATEN JAYAPURA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('01ae78ee-d6bd-445d-88b6-5e5930240690','8055235e-b7bc-4732-9f21-e79d1b6db2ec','11.14','KABUPATEN ACEH JAYA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('0351e147-e2b2-4d65-ad54-a7d8af25f970','fc5a8ac9-dfff-41aa-ae85-b1ab391aaa09','64.72','KOTA SAMARINDA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('0356befb-139f-48e3-991c-3f90f16303ae','9b42310f-e0dc-491b-9e22-ff90396c1214','35.77','KOTA MADIUN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('0365abf4-fe9d-47fa-93d7-652e592a8558','e0e2c461-5273-4968-bd1a-b4252ae7f6cf','71.02','KABUPATEN MINAHASA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('03808f05-2d23-4706-8180-655ccd24c776','ed18c5c4-db9e-4a92-9e89-3a77d7091cf4','32.05','KABUPATEN GARUT',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('03aa14b5-7600-45a9-82c7-a24a59b0fb2a','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.01','KABUPATEN TAPANULI TENGAH',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('0451f499-f6b6-4675-8db3-aeb4b0d1cad6','9b42310f-e0dc-491b-9e22-ff90396c1214','35.23','KABUPATEN TUBAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('04a000a9-fcf2-4adf-b8cc-66f0014a5b5c','ba1319d5-fc06-4612-b708-f3683687635e','13.71','KOTA PADANG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('04ae07c1-4a5b-4d2a-97f0-bf4b7de9ae48','5adddbb3-d8dc-4078-a053-1a3ca11ac356','31.75','KOTA ADMINISTRASI JAKARTA TIMUR',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('05366468-5d32-48bd-a9d3-9d7b918e05b1','9b42310f-e0dc-491b-9e22-ff90396c1214','35.27','KABUPATEN SAMPANG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('05e34496-5808-4f67-9013-bc9b204a84ac','d96797ff-3079-443b-8cf3-31d1feae59f7','53.19','KABUPATEN MANGGARAI TIMUR',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('064b939a-6e60-44b9-8012-1dc68717fd41','9b42310f-e0dc-491b-9e22-ff90396c1214','35.17','KABUPATEN JOMBANG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('06c097e0-a45a-4efc-8d46-5c020f672951','4286d1f8-fbd2-48b0-a207-f01fc52849fb','91.09','KABUPATEN MIMIKA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('0783c916-382d-4369-b73d-755d3c983d40','56ff020f-3bcf-4b93-b1ea-1791da366255','73.07','KABUPATEN SINJAI',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('07c3ac6a-f63e-44c0-bf87-64b068e83d8b','c9f49bd6-8ee5-4c41-879e-f1d0bec034bf','62.13','KABUPATEN BARITO TIMUR',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('08a626b2-4eae-43e5-b14f-e9e4d271c75c','87af1478-253a-414d-b828-e7d5f86838c7','17.01','KABUPATEN BENGKULU SELATAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('09250792-a00d-4105-91c2-6895fae3cdb2','9b42310f-e0dc-491b-9e22-ff90396c1214','35.07','KABUPATEN MALANG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('0a111f28-8415-4fe3-819a-8ccd1fe421dd','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.22','KABUPATEN SEMARANG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('0bbf4f9b-f891-48c8-b509-d0885f7499f8','ed18c5c4-db9e-4a92-9e89-3a77d7091cf4','32.78','KOTA TASIKMALAYA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('0bf3fe02-7b54-4244-8a0b-c74740f54370','d27572e1-544c-4959-af5b-0159b70db125','74.07','KABUPATEN WAKATOBI',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('0c88bb82-bfce-4f64-82d6-204f2cad9252','dcacb222-1ea0-4a17-9c1d-7790540b6db1','15.06','KABUPATEN TANJUNG JABUNG BARAT',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('0cd17225-1534-4a3d-9d4d-3ae4e9b168e4','b787ea8b-16c7-46dd-849c-4073e41782cb','82.01','KABUPATEN HALMAHERA BARAT',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('0daf51d0-4e92-4b65-bd2f-74df16a27695','8055235e-b7bc-4732-9f21-e79d1b6db2ec','11.06','KABUPATEN ACEH BESAR',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('0e3b09bf-15f2-4aa0-9ab9-b9c1664059ec','ee91309e-ffaf-4405-ad5b-c9b0ec6341da','18.04','KABUPATEN LAMPUNG BARAT',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('0ed88e73-a240-4b25-bb89-f115fe48b2f9','4286d1f8-fbd2-48b0-a207-f01fc52849fb','91.11','KABUPATEN KEEROM',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('0ef37293-8b8a-4415-bd2e-d17cb1206a86','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.75','KOTA PEKALONGAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('103db8e4-799e-4539-b103-ea2963b83ecd','c9f49bd6-8ee5-4c41-879e-f1d0bec034bf','62.10','KABUPATEN GUNUNG MAS',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('11248984-9c51-4c42-a080-8c30b0caec8a','31e905f0-af45-404c-9a3c-ff687b86e56f','92.05','KABUPATEN RAJA AMPAT',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('11dad5f6-0ae2-4d2d-acf0-20cac0cbdd49','c9f49bd6-8ee5-4c41-879e-f1d0bec034bf','62.08','KABUPATEN SUKAMARA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('123a496e-d3f3-40ae-b962-4e03d47f4bbc','ee91309e-ffaf-4405-ad5b-c9b0ec6341da','18.11','KABUPATEN MESUJI',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('13a2e277-2105-4325-8534-def1268bf0d4','31e905f0-af45-404c-9a3c-ff687b86e56f','92.03','KABUPATEN FAKFAK',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('13bb1a9b-ff2d-4b53-95bf-ca3ae7bcf402','ed18c5c4-db9e-4a92-9e89-3a77d7091cf4','32.08','KABUPATEN KUNINGAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('14348f43-2715-428f-8c16-e7ad2e4e4062','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.74','KOTA TANJUNG BALAI',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('148af5ea-002e-42ed-8eb3-d20751ac821d','6482cf92-4995-4b54-8366-6dae255800aa','19.02','KABUPATEN BELITUNG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('15f7fb04-e2e4-46a6-b16f-bdbf5877b700','6482cf92-4995-4b54-8366-6dae255800aa','19.06','KABUPATEN BELITUNG TIMUR',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('169e84f9-6d10-4664-87a8-5f9689c2bcea','e0e2c461-5273-4968-bd1a-b4252ae7f6cf','71.73','KOTA TOMOHON',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('16b82d53-9d35-4ead-b99f-107032f3d9ab','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.09','KABUPATEN BOYOLALI',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('171c3888-edba-4878-bfa7-80bafc2b3291','b787ea8b-16c7-46dd-849c-4073e41782cb','82.06','KABUPATEN HALMAHERA TIMUR',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('182c13f5-a521-43de-baa1-b40198bae3e4','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.13','KABUPATEN MANDAILING NATAL',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('1873a36a-fa15-48c2-bf04-2c513322f182','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.20','KABUPATEN JEPARA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('18c2b60e-9069-4518-91cf-ef56070d69c9','e093b3d5-ce15-4a1d-95af-d0f9b0f5c0ac','72.12','KABUPATEN MOROWALI UTARA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('18e4523f-5108-4837-8700-a0f5e4c0d52d','38e7d99e-a56d-4352-9f57-2d999d66ac61','52.71','KOTA MATARAM',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('192f3755-ee6e-47db-bcc5-eacc967813d7','c9f49bd6-8ee5-4c41-879e-f1d0bec034bf','62.07','KABUPATEN SERUYAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('193f7f02-7a13-4bb3-af3f-adbd8e50f230','8055235e-b7bc-4732-9f21-e79d1b6db2ec','11.04','KABUPATEN ACEH TENGAH',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('1963ea2d-6892-43ec-95ee-48aa057900cb','d96797ff-3079-443b-8cf3-31d1feae59f7','53.05','KABUPATEN ALOR',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('1979f394-0915-4dc5-928d-be38ff00683e','8a61c56a-b1c0-4140-98f1-5afcb05843bf','16.04','KABUPATEN LAHAT',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('19e38e47-d4f6-446b-b167-3539d514a133','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.73','KOTA SALATIGA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('1aa9c86a-4ebc-49df-aaf1-c8c5974b929f','ed18c5c4-db9e-4a92-9e89-3a77d7091cf4','32.13','KABUPATEN SUBANG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('1b0427a5-8af2-4e82-abe5-e29cb43408be','3063ce6a-fe6b-46bc-8072-50d02234cab3','61.04','KABUPATEN KETAPANG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('1b34b1b4-4717-4280-9e02-83144a0280d3','dcacb222-1ea0-4a17-9c1d-7790540b6db1','15.02','KABUPATEN MERANGIN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('1bf7d32e-8f74-496e-b6ea-ae7c36c96c22','dc79dc41-da5e-4416-b608-e154db24f89b','51.04','KABUPATEN GIANYAR',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('1bfb867d-bb9c-4b8f-8835-e9f1ae85d0ab','dc79dc41-da5e-4416-b608-e154db24f89b','51.03','KABUPATEN BADUNG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('1c45b0f7-f957-4051-8c5c-4ee00108f06c','8a61c56a-b1c0-4140-98f1-5afcb05843bf','16.13','KABUPATEN MUSI RAWAS UTARA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('1c8b985b-90c7-48af-a7c8-5951f63593b5','4286d1f8-fbd2-48b0-a207-f01fc52849fb','91.12','KABUPATEN PEGUNUNGAN BINTANG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('1cf2a5dc-e4ca-41d0-98e4-d42bd2622b41','c9f49bd6-8ee5-4c41-879e-f1d0bec034bf','62.11','KABUPATEN PULANG PISAU',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('1d1677ed-522d-46f4-aea0-bd4765147582','eb7c9797-3ac6-4866-8c15-dabc7df4090f','14.02','KABUPATEN INDRAGIRI HULU',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('1daa3474-be5d-46cc-85c5-11f00cc03089','8f4c6712-f6af-4e3d-94d2-00e0f9fab08d','65.04','KABUPATEN TANA TIDUNG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('1dc489ba-9fa9-47b1-8942-b4b10853b118','b787ea8b-16c7-46dd-849c-4073e41782cb','82.05','KABUPATEN KEPULAUAN SULA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('1f73e4ea-d842-482e-ba92-e9297e0beeb0','8055235e-b7bc-4732-9f21-e79d1b6db2ec','11.12','KABUPATEN ACEH BARAT DAYA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('1f7f0b6e-777f-4e27-aa9a-a7d694f0a3b3','d96797ff-3079-443b-8cf3-31d1feae59f7','53.14','KABUPATEN ROTE NDAO',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('1fbd19d7-d081-4fe5-b19a-f513ce78d319','d96797ff-3079-443b-8cf3-31d1feae59f7','53.02','KABUPATEN TIMOR TENGAH SELATAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('1fdaffb9-2f02-4057-be77-4d0de232980a','ba1319d5-fc06-4612-b708-f3683687635e','13.08','KABUPATEN PASAMAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('20642e6d-9e68-4828-adf2-9334d1709392','ee91309e-ffaf-4405-ad5b-c9b0ec6341da','18.02','KABUPATEN LAMPUNG TENGAH',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('20711ee3-966b-4283-9762-b28ea4d82211','ed18c5c4-db9e-4a92-9e89-3a77d7091cf4','32.79','KOTA BANJAR',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('2071631e-fc00-4e17-9663-e99cf1294253','9b42310f-e0dc-491b-9e22-ff90396c1214','35.03','KABUPATEN TRENGGALEK',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('218b2daf-d4c6-4eb0-beda-41ce20707df1','8055235e-b7bc-4732-9f21-e79d1b6db2ec','11.08','KABUPATEN ACEH UTARA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('220d5689-035c-4b5b-8db7-1cabaef73266','e0e2c461-5273-4968-bd1a-b4252ae7f6cf','71.72','KOTA BITUNG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('22b25a95-066d-43f7-9497-c9838e9e1999','809a26f2-4be0-49f7-ba4d-a3251f488382','36.71','KOTA TANGERANG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('243592ae-44f8-4f3a-af65-268b6caef849','d27572e1-544c-4959-af5b-0159b70db125','74.13','KABUPATEN MUNA BARAT',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('2456cb22-3f00-478a-9ee6-fb94e490450d','3dfa9f13-4b2b-463b-9e93-ce00cff7d34d','63.02','KABUPATEN KOTABARU',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('248c4fb1-b99f-430b-a79d-dbc5eea5b691','4286d1f8-fbd2-48b0-a207-f01fc52849fb','91.06','KABUPATEN BIAK NUMFOR',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('250d5ab0-0b2b-4bc4-9e40-d40c90425daa','5adddbb3-d8dc-4078-a053-1a3ca11ac356','31.74','KOTA ADMINISTRASI JAKARTA SELATAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('25680bcd-5670-4234-9b17-1963261115e0','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.78','KOTA GUNUNGSITOLI',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('25a7a787-ed14-4372-8da5-302c216872fb','6de402c8-e85e-42c2-8606-0cd586359c8d','21.02','KABUPATEN KARIMUN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('25c7ed18-3af3-4770-8975-a5eec4db72a7','dcacb222-1ea0-4a17-9c1d-7790540b6db1','15.04','KABUPATEN BATANGHARI',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('25e384e8-ca6e-4d8e-b0e9-13b86b1b236e','56ff020f-3bcf-4b93-b1ea-1791da366255','73.12','KABUPATEN SOPPENG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('25f5134d-1c11-4894-b98e-dcaeef3ce0c8','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.08','KABUPATEN SIMALUNGUN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('2669a556-f3b5-47a5-9ecf-170dedb9f2b7','d96797ff-3079-443b-8cf3-31d1feae59f7','53.21','KABUPATEN MALAKA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('2669ad0a-bb60-45ad-af4f-06cd726d5ccc','e093b3d5-ce15-4a1d-95af-d0f9b0f5c0ac','72.11','KABUPATEN BANGGAI LAUT',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('26d8fccc-e024-4ed5-bc3d-5f8347edcb88','ee91309e-ffaf-4405-ad5b-c9b0ec6341da','18.03','KABUPATEN LAMPUNG UTARA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('2710aab0-e928-4b50-8906-99bbcbf6b751','d27572e1-544c-4959-af5b-0159b70db125','74.10','KABUPATEN BUTON UTARA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('2745f6ab-ed01-4797-8aee-68c4e9aed31e','9b42310f-e0dc-491b-9e22-ff90396c1214','35.18','KABUPATEN NGANJUK',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('278693a0-4435-4c8f-9c6f-9e6795f64441','4286d1f8-fbd2-48b0-a207-f01fc52849fb','91.07','KABUPATEN PUNCAK JAYA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('2797a422-826d-45ee-8bd5-bb95b6209fbd','87af1478-253a-414d-b828-e7d5f86838c7','17.07','KABUPATEN LEBONG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('27deb1ed-8e60-4697-81f0-0fb6695e8097','8a61c56a-b1c0-4140-98f1-5afcb05843bf','16.12','KABUPATEN PENUKAL ARAB LEMATANG ILIR',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('27f38eff-2c19-4df1-af33-0281db7de37c','ba1319d5-fc06-4612-b708-f3683687635e','13.09','KABUPATEN KEPULAUAN MENTAWAI',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('285cbf28-adfb-46d2-8b4e-d4cc5a6751b8','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.12','KABUPATEN WONOGIRI',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('287adbc1-c9ea-4d89-af96-fd830e4928d2','4286d1f8-fbd2-48b0-a207-f01fc52849fb','91.08','KABUPATEN PANIAI',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('287d6b0d-59e3-4d6e-9c62-878fae4a60af','3dfa9f13-4b2b-463b-9e93-ce00cff7d34d','63.71','KOTA BANJARMASIN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('288c4de0-27fd-4d45-a7c8-62d5ccc3ca36','8055235e-b7bc-4732-9f21-e79d1b6db2ec','11.73','KOTA LHOKSEUMAWE',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('29bd0e70-a2c1-4ac4-b816-fd9b7d1aa25d','31e905f0-af45-404c-9a3c-ff687b86e56f','92.02','KABUPATEN MANOKWARI',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('2a1be295-8623-47b0-b2c3-167039468280','38e7d99e-a56d-4352-9f57-2d999d66ac61','52.03','KABUPATEN LOMBOK TIMUR',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('2a7f14d9-3b9c-454e-bb52-ef544c8979e4','38e7d99e-a56d-4352-9f57-2d999d66ac61','52.72','KOTA BIMA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('2adfe33a-ed63-488e-90c2-c5d9f6076ed4','56ff020f-3bcf-4b93-b1ea-1791da366255','73.72','KOTA PAREPARE',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('2ae8b706-7ca8-44c2-b44d-00f5aee24867','8f4c6712-f6af-4e3d-94d2-00e0f9fab08d','65.03','KABUPATEN NUNUKAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('2c22d952-c1d8-4756-8922-f1d538ee00d3','dae68381-a6dd-4914-9a5e-94f7e00bb6ab','81.09','KABUPATEN BURU SELATAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('2c3290c1-49a5-4c32-9909-39b6e77278d4','72380af8-5a27-438d-ac1e-bb0e29d3b661','34.03','KABUPATEN GUNUNGKIDUL',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('2c7036be-4e91-45f1-80bb-d0397139d2ef','eb7c9797-3ac6-4866-8c15-dabc7df4090f','14.10','KABUPATEN KEPULAUAN MERANTI',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('2d1ae9d4-7cc6-45af-80a1-48a7ee218d6c','d96797ff-3079-443b-8cf3-31d1feae59f7','53.17','KABUPATEN SUMBA TENGAH',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('2e11ca30-88fe-4be4-b158-cfa9ec788c76','31e905f0-af45-404c-9a3c-ff687b86e56f','92.10','KABUPATEN MAYBRAT',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('2e12ceac-a09e-4d93-ba94-8909d053daf6','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.24','KABUPATEN NIAS UTARA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('2f6ba1a4-50d0-4c6b-a325-6771a316aac7','eb7c9797-3ac6-4866-8c15-dabc7df4090f','14.07','KABUPATEN ROKAN HILIR',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('3007f90a-6d41-4558-b0c3-86ac5cc7c8c4','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.10','KABUPATEN KLATEN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('3243a8ac-97c6-444e-9843-75578bb06bed','c9f49bd6-8ee5-4c41-879e-f1d0bec034bf','62.05','KABUPATEN BARITO UTARA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('336febba-5adf-4acd-8ff1-8edc0efae4c5','4286d1f8-fbd2-48b0-a207-f01fc52849fb','91.25','KABUPATEN PUNCAK',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('33cec073-136f-4002-a8a8-eb142502b6ce','8a61c56a-b1c0-4140-98f1-5afcb05843bf','16.73','KOTA LUBUK LINGGAU',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('3480b902-de10-42eb-9e11-ac536dbe0053','ee91309e-ffaf-4405-ad5b-c9b0ec6341da','18.05','KABUPATEN TULANG BAWANG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('34ac9346-5a44-4ce4-990b-2da7df285cdd','c9f49bd6-8ee5-4c41-879e-f1d0bec034bf','62.03','KABUPATEN KAPUAS',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('35293429-de08-4103-8214-f78df3624fc9','87af1478-253a-414d-b828-e7d5f86838c7','17.02','KABUPATEN REJANG LEBONG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('357c3817-c3eb-488a-b8c6-1986053d16fb','e0e2c461-5273-4968-bd1a-b4252ae7f6cf','71.06','KABUPATEN MINAHASA UTARA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('35bee195-145e-43bf-9345-e00a1c5f1d0b','3063ce6a-fe6b-46bc-8072-50d02234cab3','61.71','KOTA PONTIANAK',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('35e916d6-bcb9-4c50-80e3-1bcd5e5f79ed','3063ce6a-fe6b-46bc-8072-50d02234cab3','61.01','KABUPATEN SAMBAS',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('35ed5ef3-2e28-4d79-a71d-900ac49635eb','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.09','KABUPATEN ASAHAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('36a0757f-18f1-4fe7-92af-f8038c9476b7','ba1319d5-fc06-4612-b708-f3683687635e','13.05','KABUPATEN PADANG PARIAMAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('36a49403-1f82-4f38-bb54-759c65b80c6e','ee91309e-ffaf-4405-ad5b-c9b0ec6341da','18.71','KOTA BANDAR LAMPUNG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('36dc33ac-1065-4756-9180-ae14276597c2','d96797ff-3079-443b-8cf3-31d1feae59f7','53.11','KABUPATEN SUMBA TIMUR',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('374037d8-4e86-4307-965d-841390e93c1f','9b42310f-e0dc-491b-9e22-ff90396c1214','35.20','KABUPATEN MAGETAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('37c01985-6bb4-4770-9a90-e3f2b8789722','9b42310f-e0dc-491b-9e22-ff90396c1214','35.79','KOTA BATU',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('38675858-d664-441c-b87f-c1f3006c2b3e','56ff020f-3bcf-4b93-b1ea-1791da366255','73.15','KABUPATEN PINRANG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('38af6a50-a4e5-4b1a-bc81-ba06a122f673','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.74','KOTA SEMARANG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('394ab755-7a1e-4b40-8803-c592597c9ad6','eb7c9797-3ac6-4866-8c15-dabc7df4090f','14.05','KABUPATEN PELALAWAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('3ae105a7-d9ec-4aa7-bd7e-fc68130f50c7','ba1319d5-fc06-4612-b708-f3683687635e','13.76','KOTA PAYAKUMBUH',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('3b01ad65-e28a-43e7-b9a2-5b85b3e60dca','8055235e-b7bc-4732-9f21-e79d1b6db2ec','11.01','KABUPATEN ACEH SELATAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('3bac1fe1-96fe-4e59-afaf-6f8d7a704e70','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.15','KABUPATEN PAKPAK BHARAT',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('3c101615-50e0-4138-a9d4-ecd904186322','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.20','KABUPATEN PADANG LAWAS UTARA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('3ce9d5f3-e25c-43f3-8b32-3730a4589302','9b42310f-e0dc-491b-9e22-ff90396c1214','35.73','KOTA MALANG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('3d69c76e-1f77-4f6d-bfa3-d941d0988ec5','8a61c56a-b1c0-4140-98f1-5afcb05843bf','16.01','KABUPATEN OGAN KOMERING ULU',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('3e4aae5e-d428-4b0e-a87d-04a23b1ede02','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.11','KABUPATEN DAIRI',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('3e58031c-01b8-4a42-90e6-69786ee2e3e5','ba1319d5-fc06-4612-b708-f3683687635e','13.01','KABUPATEN PESISIR SELATAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('3ed78d4d-12ac-4188-a430-ed795ad4437a','8a61c56a-b1c0-4140-98f1-5afcb05843bf','16.11','KABUPATEN EMPAT LAWANG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('3f04914a-00da-4f56-a65b-02476e1e2916','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.03','KABUPATEN PURBALINGGA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('3fa0d516-f983-47c5-aa19-2f7153d6f215','ee91309e-ffaf-4405-ad5b-c9b0ec6341da','18.13','KABUPATEN PESISIR BARAT',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('3fcf47df-f5d8-43fb-8d51-43cb28c38339','dc79dc41-da5e-4416-b608-e154db24f89b','51.02','KABUPATEN TABANAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('40351e61-9a2c-46ee-a506-aad3c5acb6e3','31e905f0-af45-404c-9a3c-ff687b86e56f','92.04','KABUPATEN SORONG SELATAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('4042d128-73c5-4296-a730-8e183c1902bd','380a5175-5371-43d0-bc10-45be017f83d7','76.05','KABUPATEN MAJENE',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('407536a5-f836-40ad-b6ab-477cd62de80d','3dfa9f13-4b2b-463b-9e93-ce00cff7d34d','63.11','KABUPATEN BALANGAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('40771073-215a-41f2-9b31-356d2a2800d2','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.23','KABUPATEN TEMANGGUNG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('41770e2c-f343-4202-833e-18d7cc39fe96','380a5175-5371-43d0-bc10-45be017f83d7','76.01','KABUPATEN MAMUJU UTARA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('420ced02-4827-42a6-bba0-249ea9274c3c','b787ea8b-16c7-46dd-849c-4073e41782cb','82.03','KABUPATEN HALMAHERA UTARA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('421728d8-e8a2-43d8-994a-794a3c6fccaf','dae68381-a6dd-4914-9a5e-94f7e00bb6ab','81.04','KABUPATEN BURU',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('42e0a37f-2289-4150-9d72-83adaa2d784e','4286d1f8-fbd2-48b0-a207-f01fc52849fb','91.05','KABUPATEN KEPULAUAN YAPEN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('432847d0-e365-4efe-b0c4-3024e33580e0','9b42310f-e0dc-491b-9e22-ff90396c1214','35.12','KABUPATEN SITUBONDO',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('441128e4-5f33-4df9-b893-576cae61e675','dcacb222-1ea0-4a17-9c1d-7790540b6db1','15.01','KABUPATEN KERINCI',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('441642ee-689c-41e7-be47-43739a7c2665','9b42310f-e0dc-491b-9e22-ff90396c1214','35.08','KABUPATEN LUMAJANG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('444e03de-f245-4b60-83af-65fa447de510','380a5175-5371-43d0-bc10-45be017f83d7','76.04','KABUPATEN POLEWALI MANDAR',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('46447d21-1e14-4047-a6ff-26475be3a709','ba1319d5-fc06-4612-b708-f3683687635e','13.75','KOTA BUKITTINGGI',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('466bba90-066c-427f-8eb6-d49c3e035c47','dcacb222-1ea0-4a17-9c1d-7790540b6db1','15.09','KABUPATEN TEBO',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('466f3a16-62d3-458f-82f7-5d13a34f5f29','56ff020f-3bcf-4b93-b1ea-1791da366255','73.26','KABUPATEN TORAJA UTARA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('469e22f9-b03b-47be-8119-7e0ef5d85c30','3063ce6a-fe6b-46bc-8072-50d02234cab3','61.05','KABUPATEN SINTANG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('46e848c4-07f0-443a-8dbc-fb6a1442be08','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.19','KABUPATEN BATUBARA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('473f56cf-58da-4eac-a870-01fc63435eb2','8f4c6712-f6af-4e3d-94d2-00e0f9fab08d','65.02','KABUPATEN MALINAU',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('47d046bf-7b6d-47ed-91b9-2e34bc7191cd','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.25','KABUPATEN NIAS BARAT',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('47f026f1-26a1-4e9e-8fbb-ce4fbf554098','3dfa9f13-4b2b-463b-9e93-ce00cff7d34d','63.01','KABUPATEN TANAH LAUT',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('48db09c2-20a7-4586-bb0f-e4eff9120002','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.71','KOTA MEDAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('49345f26-853c-4e51-b795-3c318ffc8c0d','9b42310f-e0dc-491b-9e22-ff90396c1214','35.15','KABUPATEN SIDOARJO',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('493a766d-acd5-4f02-9399-4d6e3214d849','9b42310f-e0dc-491b-9e22-ff90396c1214','35.02','KABUPATEN PONOROGO',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('4aa1b95f-560a-4c14-9702-04e34f11f55d','38e7d99e-a56d-4352-9f57-2d999d66ac61','52.02','KABUPATEN LOMBOK TENGAH',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('4af84abe-466f-4821-9fc6-825e00d6f24e','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.04','KABUPATEN BANJARNEGARA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('4b335595-146d-4e65-b135-1782acd618f0','ed18c5c4-db9e-4a92-9e89-3a77d7091cf4','32.09','KABUPATEN CIREBON',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('4bdb2f35-6814-4b7f-907e-df5fcb1e80ab','ed18c5c4-db9e-4a92-9e89-3a77d7091cf4','32.12','KABUPATEN INDRAMAYU',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('4c1bb36c-fd0a-4996-930c-b7f32035abe9','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.26','KABUPATEN PEKALONGAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('4c1dcb63-a1e4-4ed9-9277-b3a15c993d47','809a26f2-4be0-49f7-ba4d-a3251f488382','36.01','KABUPATEN PANDEGELANG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('4c4cf45f-9ebb-41c4-9c7e-912f0ee5939b','d96797ff-3079-443b-8cf3-31d1feae59f7','53.16','KABUPATEN NAGEKEO',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('4c575b51-2822-456b-8815-a1118015fdd4','5adddbb3-d8dc-4078-a053-1a3ca11ac356','31.73','KOTA ADMINISTRASI JAKARTA BARAT',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('4c680d9e-89f7-4e06-85a7-cec3b64de32c','3dfa9f13-4b2b-463b-9e93-ce00cff7d34d','63.10','KABUPATEN TANAH BUMBU',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('4daa7743-c58e-4c80-9346-056763b8d695','ed18c5c4-db9e-4a92-9e89-3a77d7091cf4','32.11','KABUPATEN SUMEDANG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('4e04ad90-481c-483d-9f4a-45c216ff26ee','e0e2c461-5273-4968-bd1a-b4252ae7f6cf','71.04','KABUPATEN KEPULAUAN TALAUD',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('4e538160-9d77-44f2-8c74-0e8bb7660491','dcacb222-1ea0-4a17-9c1d-7790540b6db1','15.05','KABUPATEN MUARO JAMBI',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('4e7f05f0-1147-4c2d-b810-92a7e70055ad','ed18c5c4-db9e-4a92-9e89-3a77d7091cf4','32.74','KOTA CIREBON',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('4f58273a-4521-46a2-bfb9-90a4d4b4f98a','6de402c8-e85e-42c2-8606-0cd586359c8d','21.01','KABUPATEN BINTAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('4f87b4df-b6f6-4849-9e3e-6710371060cd','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.07','KABUPATEN DELI SERDANG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('509b1c4d-f10d-4e35-b7e1-11e2fadc4655','56ff020f-3bcf-4b93-b1ea-1791da366255','73.73','KOTA PALOPO',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('50ed5073-077c-4549-897d-92b572139c67','3063ce6a-fe6b-46bc-8072-50d02234cab3','61.10','KABUPATEN MELAWI',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('51780570-a4c7-473a-8e3b-58d87d15ea49','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.21','KABUPATEN PADANG LAWAS',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('51d65d05-7948-401d-bf41-9dce26bc49b4','d27572e1-544c-4959-af5b-0159b70db125','74.12','KABUPATEN KONAWE KEPULAUAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('52664750-a150-4b3e-bf80-cf9dfa9da9ff','6de402c8-e85e-42c2-8606-0cd586359c8d','21.05','KABUPATEN KEPULAUAN ANAMBAS',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('52b0a2ff-e254-4d03-91ed-3b741a2a15c9','56ff020f-3bcf-4b93-b1ea-1791da366255','73.09','KABUPATEN MAROS',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('5386637d-ed5c-44c7-a30b-5c834a48da30','ed18c5c4-db9e-4a92-9e89-3a77d7091cf4','32.01','KABUPATEN BOGOR',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('54c346f8-11b7-4e20-b2cf-5beb45490cb2','dc79dc41-da5e-4416-b608-e154db24f89b','51.05','KABUPATEN KLUNGKUNG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('550d60e7-0fb6-4358-a43d-9cbabce0aef4','4286d1f8-fbd2-48b0-a207-f01fc52849fb','91.24','KABUPATEN NDUGA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('55b38562-d75d-4f99-bba6-7aa83021d858','b787ea8b-16c7-46dd-849c-4073e41782cb','82.07','KABUPATEN PULAU MOROTAI',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('55efef91-5bcf-499f-aa9e-99b0ac93987d','31e905f0-af45-404c-9a3c-ff687b86e56f','92.71','KOTA SORONG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('55f27b48-25a6-4d44-93b7-20318dcd6495','38e7d99e-a56d-4352-9f57-2d999d66ac61','52.01','KABUPATEN LOMBOK BARAT',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('5611a8d9-c219-4b40-9102-79b6c1a0ee53','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.16','KABUPATEN BLORA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('56ed03e5-3d59-478b-bd2e-513ea96e61dc','e093b3d5-ce15-4a1d-95af-d0f9b0f5c0ac','72.09','KABUPATEN TOJO UNA-UNA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('56f7dc91-84b4-4a7f-9c75-fab84c210d72','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.01','KABUPATEN CILACAP',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('571780a4-1c92-4119-9562-386c271c45da','c9f49bd6-8ee5-4c41-879e-f1d0bec034bf','62.71','KOTA PALANGKA RAYA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('57ad05cb-1da6-434f-986b-ca84182b9ff0','eb7c9797-3ac6-4866-8c15-dabc7df4090f','14.71','KOTA PEKANBARU',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('5815fac4-a16a-4c38-8f44-debef6f06885','4286d1f8-fbd2-48b0-a207-f01fc52849fb','91.71','KOTA JAYAPURA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('59c4b50b-c993-4902-9fc4-7602c50ea057','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.02','KABUPATEN TAPANULI UTARA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('59eb981c-d20d-43dd-8b5c-0ccc9d3f4325','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.23','KABUPATEN LABUHANBATU UTARA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('5ad58c61-fcbf-4fa4-be90-c45bd2e8b134','c9f49bd6-8ee5-4c41-879e-f1d0bec034bf','62.09','KABUPATEN LAMANDAU',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('5b8b89e2-21c3-47e1-8477-3a144007cf32','ed18c5c4-db9e-4a92-9e89-3a77d7091cf4','32.10','KABUPATEN MAJALENGKA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('5c78959e-2158-4043-ba10-6675409254d4','6de402c8-e85e-42c2-8606-0cd586359c8d','21.04','KABUPATEN LINGGA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('5c92c4a2-c065-4816-8843-1a4f0b92f559','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.14','KABUPATEN SRAGEN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('5d462641-786b-4b5d-9cf3-9de59aed03ca','dad6e81a-8665-46e7-8a4f-b50ed5429606','75.05','KABUPATEN GORONTALO UTARA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('5ed1435f-c9ae-46a2-ba6f-b28d57d1e337','fc5a8ac9-dfff-41aa-ae85-b1ab391aaa09','64.11','KABUPATEN MAHAKAM ULU',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('5eecd107-1529-4e9c-8f53-c2aa810c50e1','9b42310f-e0dc-491b-9e22-ff90396c1214','35.29','KABUPATEN SUMENEP',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('5ef2e217-19fd-4e8b-b6c3-db3a72f2931a','4286d1f8-fbd2-48b0-a207-f01fc52849fb','91.19','KABUPATEN SUPIORI',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('600bd9b1-b419-4c92-86d6-574535e7bf71','e093b3d5-ce15-4a1d-95af-d0f9b0f5c0ac','72.05','KABUPATEN BUOL',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('601c351a-7228-47b5-8193-77976c31c05c','ed18c5c4-db9e-4a92-9e89-3a77d7091cf4','32.17','KABUPATEN BANDUNG BARAT',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('607ed51b-1cf8-4a64-b13a-b8a881fdae1f','8055235e-b7bc-4732-9f21-e79d1b6db2ec','11.16','KABUPATEN ACEH TAMIANG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('60a96eda-0f3a-4532-a005-88ae5b336a62','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.72','KOTA SURAKARTA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('60d7acdb-27dc-4ad7-bd0a-7180e4bb9f79','d96797ff-3079-443b-8cf3-31d1feae59f7','53.09','KABUPATEN NGADA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('61539678-2717-45f5-8a8f-282493e9230f','e093b3d5-ce15-4a1d-95af-d0f9b0f5c0ac','72.04','KABUPATEN TOLITOLI',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('6190ce42-06aa-402f-acc2-05cd517f97b8','380a5175-5371-43d0-bc10-45be017f83d7','76.02','KABUPATEN MAMUJU',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('6278aca1-9ec9-402a-aae2-159612be79cf','3063ce6a-fe6b-46bc-8072-50d02234cab3','61.02','KABUPATEN MEMPAWAH',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('62f0ad21-60c2-4184-b2b7-46c072884d74','87af1478-253a-414d-b828-e7d5f86838c7','17.04','KABUPATEN KAUR',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('6381ca0d-776b-47e0-90ef-1626f0469859','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.12','KABUPATEN TOBA SAMOSIR',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('63b656cf-c4c2-4eaf-9315-1984b1650ab9','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.29','KABUPATEN BREBES',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('6441b083-2956-4596-98e5-8431ad46a70a','4286d1f8-fbd2-48b0-a207-f01fc52849fb','91.02','KABUPATEN JAYAWIJAYA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('64ad4956-8140-4c17-8a52-71d29398a3f4','dae68381-a6dd-4914-9a5e-94f7e00bb6ab','81.08','KABUPATEN MALUKU BARAT DAYA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('64d46705-d390-4025-bfcf-8782fc062717','5adddbb3-d8dc-4078-a053-1a3ca11ac356','31.71','KOTA ADMINISTRASI JAKARTA PUSAT',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('654291fe-fccc-4122-bdf6-0beb842c51b8','ba1319d5-fc06-4612-b708-f3683687635e','13.03','KABUPATEN SIJUNJUNG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('657fcdfc-cd1d-48ec-a50f-070b962bf9f8','3dfa9f13-4b2b-463b-9e93-ce00cff7d34d','63.07','KABUPATEN HULU SUNGAI TENGAH',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('6597d81b-43bf-47b4-90ac-7c9622fb2c48','d27572e1-544c-4959-af5b-0159b70db125','74.03','KABUPATEN MUNA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('663fd1d1-f8a7-4b18-b725-f8faf496dbe2','31e905f0-af45-404c-9a3c-ff687b86e56f','92.06','KABUPATEN TELUK BINTUNI',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('667073a2-c21f-439c-bc8c-079f906787a0','e093b3d5-ce15-4a1d-95af-d0f9b0f5c0ac','72.07','KABUPATEN BANGGAI KEPULAUAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('672cd3ad-1af7-4092-aed3-8e64fadc6fec','fc5a8ac9-dfff-41aa-ae85-b1ab391aaa09','64.74','KOTA BONTANG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('6764b56b-d133-4043-9e31-cd94f6c3431a','eb7c9797-3ac6-4866-8c15-dabc7df4090f','14.03','KABUPATEN BENGKALIS',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('68b9cb6a-0fda-466b-8bc7-9b9616c378f6','87af1478-253a-414d-b828-e7d5f86838c7','17.06','KABUPATEN MUKOMUKO',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('698dd9e5-5353-487f-9097-69048ba622df','ee91309e-ffaf-4405-ad5b-c9b0ec6341da','18.72','KOTA METRO',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('6a097987-0ee1-46fe-9b25-f04aeb1c0983','4286d1f8-fbd2-48b0-a207-f01fc52849fb','91.14','KABUPATEN TOLIKARA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('6ace7cf6-0136-4a29-b2bf-6f9b599fb37b','809a26f2-4be0-49f7-ba4d-a3251f488382','36.02','KABUPATEN LEBAK',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('6ba99f80-51d2-4155-868c-6d72a431c293','9b42310f-e0dc-491b-9e22-ff90396c1214','35.26','KABUPATEN BANGKALAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('6c029593-502c-46f4-901f-099f70374af4','ee91309e-ffaf-4405-ad5b-c9b0ec6341da','18.08','KABUPATEN WAY KANAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('6c0c7358-2e82-4115-a881-78de89feb61b','dc79dc41-da5e-4416-b608-e154db24f89b','51.71','KOTA DENPASAR',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('6c4d1cab-ba5e-45d9-8209-1155fb3462f8','c9f49bd6-8ee5-4c41-879e-f1d0bec034bf','62.02','KABUPATEN KOTAWARINGIN TIMUR',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('6d64350f-d99a-4e00-bd22-754d9c3a3875','9b42310f-e0dc-491b-9e22-ff90396c1214','35.71','KOTA KEDIRI',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('6dac2ac0-884c-4cfe-9b6a-79b40a2da67c','31e905f0-af45-404c-9a3c-ff687b86e56f','92.11','KABUPATEN MANOKWARI SELATAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('6dc9c6b9-60e4-467a-a667-0924e3f717f4','ba1319d5-fc06-4612-b708-f3683687635e','13.06','KABUPATEN AGAM',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('6e73edd6-3846-431a-b155-ac03add77429','dcacb222-1ea0-4a17-9c1d-7790540b6db1','15.03','KABUPATEN SAROLANGUN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('6eb467b8-da6a-44ce-a2f0-a4a68eee8841','87af1478-253a-414d-b828-e7d5f86838c7','17.05','KABUPATEN SELUMA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('6f305321-a678-4ef8-a457-ded2943fdea0','d96797ff-3079-443b-8cf3-31d1feae59f7','53.18','KABUPATEN SUMBA BARAT DAYA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('6f381420-272f-4982-a7ca-c6376534139b','38e7d99e-a56d-4352-9f57-2d999d66ac61','52.08','KABUPATEN LOMBOK UTARA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('6f746ff2-1407-4bb9-a058-8da19b11c7b9','d27572e1-544c-4959-af5b-0159b70db125','74.71','KOTA KENDARI',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('6f8a608f-9f1f-489e-9cb7-8a18e58ec0c6','e0e2c461-5273-4968-bd1a-b4252ae7f6cf','71.01','KABUPATEN BOLAANG MONGONDOW',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('70072736-74bb-4a63-ba67-8665eaa1ac10','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.08','KABUPATEN MAGELANG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('70b3144a-8d14-4cb0-b45c-703abe712de6','e093b3d5-ce15-4a1d-95af-d0f9b0f5c0ac','72.06','KABUPATEN MOROWALI',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('710967dd-6ec1-4444-a214-4b0dd0bb6eca','8055235e-b7bc-4732-9f21-e79d1b6db2ec','11.71','KOTA BANDA ACEH',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('71269c26-4616-412a-aa14-fa7e90debb13','9b42310f-e0dc-491b-9e22-ff90396c1214','35.10','KABUPATEN BANYUWANGI',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('715d1acb-d64b-45aa-8bd5-668e0d0103cb','ba1319d5-fc06-4612-b708-f3683687635e','13.04','KABUPATEN TANAH DATAR',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('717bb4a8-2a14-4751-9ba0-4fee3913246b','ed18c5c4-db9e-4a92-9e89-3a77d7091cf4','32.02','KABUPATEN SUKABUMI',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('71eec259-b7f2-41a8-80b3-65cc559d28a8','dcacb222-1ea0-4a17-9c1d-7790540b6db1','15.72','KOTA SUNGAI PENUH',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('725baf30-9459-412e-ac15-5e984bf136ec','8055235e-b7bc-4732-9f21-e79d1b6db2ec','11.13','KABUPATEN GAYO LUES',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('728037be-1c5f-4900-86d5-34b0a95d8520','c9f49bd6-8ee5-4c41-879e-f1d0bec034bf','62.01','KABUPATEN KOTAWARINGIN BARAT',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('729a91ed-092f-45c0-a898-7f44baa663bc','56ff020f-3bcf-4b93-b1ea-1791da366255','73.10','KABUPATEN PANGKAJENE DAN KEPULAUAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('72ea0bb8-38c4-434d-899b-bb4a3814c34e','eb7c9797-3ac6-4866-8c15-dabc7df4090f','14.04','KABUPATEN INDRAGIRI HILIR',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('731182ca-aa0a-4d1e-b29c-a113725bb204','8055235e-b7bc-4732-9f21-e79d1b6db2ec','11.75','KOTA SUBULUSSALAM',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('73316d71-4d62-4a6e-b1e5-75b97a2b6cba','e093b3d5-ce15-4a1d-95af-d0f9b0f5c0ac','72.08','KABUPATEN PARIGI MOUTONG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('73eeabd2-4b44-4f15-b23b-c6b46e52281b','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.25','KABUPATEN BATANG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('742580b3-635e-48f5-a9f7-ea273b051174','dad6e81a-8665-46e7-8a4f-b50ed5429606','75.01','KABUPATEN GORONTALO',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('74e03dea-3db1-47c9-a9d1-419846577da1','8055235e-b7bc-4732-9f21-e79d1b6db2ec','11.17','KABUPATEN BENER MERIAH',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('75a132b2-40f8-46b2-be66-395054314c20','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.06','KABUPATEN PURWOREJO',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('7637a74d-76da-4b04-8a40-a7a399f34087','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.17','KABUPATEN SAMOSIR',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('768bc3fe-2ea5-48cb-8f72-cef547b891ed','dae68381-a6dd-4914-9a5e-94f7e00bb6ab','81.72','KOTA TUAL',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('77f2b89b-747f-40df-bcd6-f229900e30bb','56ff020f-3bcf-4b93-b1ea-1791da366255','73.14','KABUPATEN SIDENRENG RAPPANG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('77f4ad98-6f25-48ab-867d-92157f42f0a7','ba1319d5-fc06-4612-b708-f3683687635e','13.77','KOTA PARIAMAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('780b93f5-597e-484e-b967-34eb83a5769f','809a26f2-4be0-49f7-ba4d-a3251f488382','36.73','KOTA SERANG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('784539bf-b612-416f-98bc-7d3046f0ec7e','4286d1f8-fbd2-48b0-a207-f01fc52849fb','91.23','KABUPATEN LANNY JAYA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('78650cfc-035b-49db-89cb-d80b2fc459d4','ed18c5c4-db9e-4a92-9e89-3a77d7091cf4','32.16','KABUPATEN BEKASI',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('789ebf82-504d-4af6-871c-a596859d0d33','d96797ff-3079-443b-8cf3-31d1feae59f7','53.08','KABUPATEN ENDE',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('78c856f8-f6f8-49d0-90ef-48f026e2de61','ee91309e-ffaf-4405-ad5b-c9b0ec6341da','18.10','KABUPATEN PRINGSEWU',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('79b82bac-d834-4cf1-894b-f381d816439c','d96797ff-3079-443b-8cf3-31d1feae59f7','53.13','KABUPATEN LEMBATA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('7a58c6f0-7aeb-4ea8-8d15-e3d0573757ca','d27572e1-544c-4959-af5b-0159b70db125','74.72','KOTA BAU BAU',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('7b67d706-255f-4edf-a576-dd667d094956','72380af8-5a27-438d-ac1e-bb0e29d3b661','34.04','KABUPATEN SLEMAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('7be103f0-a9d6-43a6-834c-92e89756b48e','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.75','KOTA BINJAI',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('7c143be5-7d86-4d25-b971-e4803e4dddb8','dad6e81a-8665-46e7-8a4f-b50ed5429606','75.71','KOTA GORONTALO',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('7c244f57-eef2-4e1d-a053-c6e5187ba3c5','9b42310f-e0dc-491b-9e22-ff90396c1214','35.76','KOTA MOJOKERTO',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('7cf85b4e-88fc-4a8d-8b06-02b41cf3adef','d27572e1-544c-4959-af5b-0159b70db125','74.14','KABUPATEN BUTON TENGAH',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('7d2024d0-7cfb-4f23-b5f6-c115a40652ab','87af1478-253a-414d-b828-e7d5f86838c7','17.03','KABUPATEN BENGKULU UTARA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('7da3d88f-56cc-4949-b26d-654888e2df0f','ba1319d5-fc06-4612-b708-f3683687635e','13.02','KABUPATEN SOLOK',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('7dd39d98-c4f2-4578-b205-12cc9ffafaa7','ed18c5c4-db9e-4a92-9e89-3a77d7091cf4','32.76','KOTA DEPOK',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('7e02f393-f68a-4473-a56d-3fea4dd69c86','d96797ff-3079-443b-8cf3-31d1feae59f7','53.20','KABUPATEN SABU RAIJUA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('7e593e5e-9b32-42a8-bbfc-d47aee2504ef','d27572e1-544c-4959-af5b-0159b70db125','74.01','KABUPATEN KOLAKA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('7ea8fec8-6dd9-4b3a-96df-7f3604fe9c3c','d96797ff-3079-443b-8cf3-31d1feae59f7','53.15','KABUPATEN MANGGARAI BARAT',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('7eaccefe-f319-42cc-a03d-1e26c1b77701','dae68381-a6dd-4914-9a5e-94f7e00bb6ab','81.71','KOTA AMBON',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('7f34d684-bfc7-4e76-b5dd-4142c46bfa09','ed18c5c4-db9e-4a92-9e89-3a77d7091cf4','32.07','KABUPATEN CIAMIS',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('7f73de24-17aa-4dcf-9894-ec148417b0c9','8055235e-b7bc-4732-9f21-e79d1b6db2ec','11.02','KABUPATEN ACEH TENGGARA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('7fc99698-fbab-463d-8675-255236d5011d','ed18c5c4-db9e-4a92-9e89-3a77d7091cf4','32.14','KABUPATEN PURWAKARTA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('7fe03b66-83e8-4bf5-b708-a7ccd0ccc91d','8055235e-b7bc-4732-9f21-e79d1b6db2ec','11.07','KABUPATEN PIDIE',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('808dfca6-192d-4336-9376-0df185ba4598','87af1478-253a-414d-b828-e7d5f86838c7','17.08','KABUPATEN KEPAHIANG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('80f3d9c9-848b-4cff-937b-d0795044d6e5','3063ce6a-fe6b-46bc-8072-50d02234cab3','61.08','KABUPATEN LANDAK',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('8219d450-2fd4-42b6-88ee-f16ee5019a1a','8055235e-b7bc-4732-9f21-e79d1b6db2ec','11.72','KOTA SABANG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('82a6159a-f291-475c-acf5-142cee71162c','e093b3d5-ce15-4a1d-95af-d0f9b0f5c0ac','72.71','KOTA PALU',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('838d269e-ab44-49ae-92db-08132278c35a','6482cf92-4995-4b54-8366-6dae255800aa','19.04','KABUPATEN BANGKA TENGAH',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('8403d902-746c-4159-903f-1550a20dd5d1','8055235e-b7bc-4732-9f21-e79d1b6db2ec','11.11','KABUPATEN BIREUEN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('84328a8e-3629-477a-a26f-a5b07caa5bc4','809a26f2-4be0-49f7-ba4d-a3251f488382','36.04','KABUPATEN SERANG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('844fc409-a6f1-4228-8b72-edbaf5470107','8a61c56a-b1c0-4140-98f1-5afcb05843bf','16.06','KABUPATEN MUSI BANYUASIN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('847b8135-e3b3-4c87-9aa4-8a796f778a1f','31e905f0-af45-404c-9a3c-ff687b86e56f','92.01','KABUPATEN SORONG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('84e6bd66-120f-4f15-9082-c05ccca76b43','4286d1f8-fbd2-48b0-a207-f01fc52849fb','91.13','KABUPATEN YAHUKIMO',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('84f9452a-d9d0-40a9-a27e-368cacf85f31','56ff020f-3bcf-4b93-b1ea-1791da366255','73.04','KABUPATEN JENEPONTO',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('857d1751-1239-4fb9-a3a3-526d7331cdbc','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.05','KABUPATEN KEBUMEN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('87f2253e-771f-423b-96e4-f350628506a7','dc79dc41-da5e-4416-b608-e154db24f89b','51.06','KABUPATEN BANGLI',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('8a18bc80-41eb-446d-b7b3-d5025c70ef09','9b42310f-e0dc-491b-9e22-ff90396c1214','35.09','KABUPATEN JEMBER',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('8a423145-96d0-4937-8bff-ab7c709d3162','c9f49bd6-8ee5-4c41-879e-f1d0bec034bf','62.06','KABUPATEN KATINGAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('8aa981e0-4219-49b0-9283-22be87761a2e','e0e2c461-5273-4968-bd1a-b4252ae7f6cf','71.71','KOTA MANADO',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('8af9eaec-78b5-4d23-a315-f2326de63d1b','56ff020f-3bcf-4b93-b1ea-1791da366255','73.08','KABUPATEN BONE',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('8b9dbf86-dae8-4acc-992c-ef9fa62ae3de','8a61c56a-b1c0-4140-98f1-5afcb05843bf','16.09','KABUPATEN OGAN KOMERING ULU SELATAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('8bd202e1-a5e0-4370-b0b4-f9c6380795f0','31e905f0-af45-404c-9a3c-ff687b86e56f','92.12','KABUPATEN PEGUNUNGAN ARFAK',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('8be3d447-764d-4d7b-acde-3f960bc04b5e','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.06','KABUPATEN KARO',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('8c0edc16-7518-4d84-9787-42f2022039fc','3063ce6a-fe6b-46bc-8072-50d02234cab3','61.11','KABUPATEN KAYONG UTARA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('8cac1182-68df-4c0d-a47f-d791e979eed0','56ff020f-3bcf-4b93-b1ea-1791da366255','73.24','KABUPATEN LUWU TIMUR',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('8cbd177e-0cb0-400a-ba0f-7571c34926f5','3dfa9f13-4b2b-463b-9e93-ce00cff7d34d','63.06','KABUPATEN HULU SUNGAI SELATAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('8dee2b91-b288-4fc0-9a7a-a33a71a1d0ee','6de402c8-e85e-42c2-8606-0cd586359c8d','21.03','KABUPATEN NATUNA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('8fd25e68-a0d2-4ec1-9c52-12f61df51613','d96797ff-3079-443b-8cf3-31d1feae59f7','53.01','KABUPATEN KUPANG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('902bc96c-72f2-419a-af85-b6e0a2c74c48','56ff020f-3bcf-4b93-b1ea-1791da366255','73.16','KABUPATEN ENREKANG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('90d25b29-ef63-4421-bffd-3bae7a652ffe','6de402c8-e85e-42c2-8606-0cd586359c8d','21.72','KOTA TANJUNG PINANG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('91083785-7243-4084-84f9-f927db68af80','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.21','KABUPATEN DEMAK',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('9125836c-6c4d-4f4c-99ea-f9f1816484b3','9b42310f-e0dc-491b-9e22-ff90396c1214','35.19','KABUPATEN MADIUN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('9173eba4-2e7a-482f-8984-df3ce294ea4d','809a26f2-4be0-49f7-ba4d-a3251f488382','36.74','KOTA TANGERANG SELATAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('9255d2e3-4cea-4198-a41c-0f799d250969','4286d1f8-fbd2-48b0-a207-f01fc52849fb','91.01','KABUPATEN MERAUKE',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('92e5b250-3f4f-451c-963d-8c417e28a0f8','d27572e1-544c-4959-af5b-0159b70db125','74.09','KABUPATEN KONAWE UTARA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('93326d6c-ee7f-4bb3-80aa-2546d7cf6e36','38e7d99e-a56d-4352-9f57-2d999d66ac61','52.05','KABUPATEN DOMPU',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('93ddb620-cc80-4f99-b0f0-1caf101bbab3','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.77','KOTA PADANGSIDEMPUAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('94684c88-4ade-46c9-833f-54288ffa4ad4','d27572e1-544c-4959-af5b-0159b70db125','74.04','KABUPATEN BUTON',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('94ac3fd7-c240-475e-84ff-b16e0b41bc1e','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.76','KOTA TEBING TINGGI',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('95dc5de1-242e-441c-a513-f3f110f50bf8','72380af8-5a27-438d-ac1e-bb0e29d3b661','34.02','KABUPATEN BANTUL',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('96c3a440-88a2-40cf-9e06-f8c220f0fc8e','56ff020f-3bcf-4b93-b1ea-1791da366255','73.17','KABUPATEN LUWU',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('973b1e37-48e5-467a-aa10-55693a63dc3a','9b42310f-e0dc-491b-9e22-ff90396c1214','35.13','KABUPATEN PROBOLINGGO',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('97711cae-3a01-4bf2-956a-c04119d0d014','9b42310f-e0dc-491b-9e22-ff90396c1214','35.04','KABUPATEN TULUNGAGUNG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('98afb55e-1931-48ff-802b-9f64ba724354','c9f49bd6-8ee5-4c41-879e-f1d0bec034bf','62.04','KABUPATEN BARITO SELATAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('98b92bec-073d-44e4-8ebc-dc6a4b6a94ad','eb7c9797-3ac6-4866-8c15-dabc7df4090f','14.01','KABUPATEN KAMPAR',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('9996de5a-11b6-48a5-b994-c51117b8fb89','56ff020f-3bcf-4b93-b1ea-1791da366255','73.22','KABUPATEN LUWU UTARA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('9b88b642-7762-4eb2-afe5-bd445333cabe','dae68381-a6dd-4914-9a5e-94f7e00bb6ab','81.02','KABUPATEN MALUKU TENGGARA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('9c1ee50e-2d79-4493-9da4-32e9d9f7ebad','56ff020f-3bcf-4b93-b1ea-1791da366255','73.01','KABUPATEN KEPULAUAN SELAYAR',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('9c2e86f8-337e-4dac-bb3c-1a6eefcc865d','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.07','KABUPATEN WONOSOBO',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('9c6019c4-a0f2-45a6-86b0-8f01ad4dc6ff','dc79dc41-da5e-4416-b608-e154db24f89b','51.07','KABUPATEN KARANGASEM',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('9cc66448-c802-417f-9847-5a786e0c56a9','5adddbb3-d8dc-4078-a053-1a3ca11ac356','31.72','KOTA ADMINISTRASI JAKARTA UTARA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('9cf26f87-b064-4083-a58a-cb45d0d1be33','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.17','KABUPATEN REMBANG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('9da3521e-a22d-4ecd-bd4f-3be204c23243','d27572e1-544c-4959-af5b-0159b70db125','74.02','KABUPATEN KONAWE',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('9de54f25-a869-4112-baa6-6e863b717656','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.10','KABUPATEN LABUHANBATU',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('9deedcea-e5da-44b1-9df2-8dfc3125d787','d96797ff-3079-443b-8cf3-31d1feae59f7','53.71','KOTA KUPANG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('9ee76776-2ca4-4847-b577-9231d3f1cb81','e0e2c461-5273-4968-bd1a-b4252ae7f6cf','71.07','KABUPATEN MINAHASA TENGGARA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('a0f300f1-11ce-42e7-8de6-c8a512065c32','72380af8-5a27-438d-ac1e-bb0e29d3b661','34.71','KOTA YOGYAKARTA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('a18d0b0c-8977-411f-9aa2-a91a28edccc1','380a5175-5371-43d0-bc10-45be017f83d7','76.06','KABUPATEN MAMUJU TENGAH',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('a1aaa51c-2059-4841-a327-8c7c4aa17cde','56ff020f-3bcf-4b93-b1ea-1791da366255','73.06','KABUPATEN GOWA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('a1ad0e53-66ab-4479-9285-567bf946dcb5','dae68381-a6dd-4914-9a5e-94f7e00bb6ab','81.03','KABUPATEN MALUKU TENGGARA BARAT',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('a29d94c5-1192-45ee-92f8-27bb9c0adeed','eb7c9797-3ac6-4866-8c15-dabc7df4090f','14.72','KOTA DUMAI',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('a2bd568e-4add-4217-870d-889afcacbad6','ee91309e-ffaf-4405-ad5b-c9b0ec6341da','18.07','KABUPATEN LAMPUNG TIMUR',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('a32945d9-d937-4cd5-81c4-ae7ce6c0c976','d27572e1-544c-4959-af5b-0159b70db125','74.15','KABUPATEN BUTON SELATAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('a441f6ca-cab5-46dc-b044-da3fcfa9daf3','ed18c5c4-db9e-4a92-9e89-3a77d7091cf4','32.73','KOTA BANDUNG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('a4d11068-4c6d-419d-b6df-570771bfc824','56ff020f-3bcf-4b93-b1ea-1791da366255','73.02','KABUPATEN BULUKUMBA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('a5d2fe18-472d-4499-9916-2a4e2c880ce3','56ff020f-3bcf-4b93-b1ea-1791da366255','73.05','KABUPATEN TAKALAR',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('a668093c-043f-4bb0-9c02-f2baba246b24','fc5a8ac9-dfff-41aa-ae85-b1ab391aaa09','64.07','KABUPATEN KUTAI BARAT',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('a706dd5a-73eb-4c9d-904f-cff667f6f1b8','ba1319d5-fc06-4612-b708-f3683687635e','13.74','KOTA PADANGPANJANG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('a72b017c-48de-446b-a7a8-c156113a6053','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.15','KABUPATEN GROBOGAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('a78f70b5-8ea6-4417-abae-0b9d9215d970','31e905f0-af45-404c-9a3c-ff687b86e56f','92.07','KABUPATEN TELUK WONDAMA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('a8330a9f-1a21-49a2-a384-70761326b489','3dfa9f13-4b2b-463b-9e93-ce00cff7d34d','63.72','KOTA BANJARBARU',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('a8dd78f8-f625-4ce7-9b6e-b97ea90fc96e','9b42310f-e0dc-491b-9e22-ff90396c1214','35.74','KOTA PROBOLINGGO',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('a8dd9f37-d765-4e21-9338-443cfa9666b0','e0e2c461-5273-4968-bd1a-b4252ae7f6cf','71.74','KOTA KOTAMOBAGU',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('a958018e-c205-4f48-9052-6dae6e42ca44','87af1478-253a-414d-b828-e7d5f86838c7','17.71','KOTA BENGKULU',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('a9ed5255-ae05-4e7d-8d24-59cb941e9cf1','fc5a8ac9-dfff-41aa-ae85-b1ab391aaa09','64.01','KABUPATEN PASER',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('aa25a660-4f1d-4823-bd98-e01fafe5c6cf','eb7c9797-3ac6-4866-8c15-dabc7df4090f','14.08','KABUPATEN SIAK',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('aa7648dc-7be1-423e-8526-c2befbcf9f7a','809a26f2-4be0-49f7-ba4d-a3251f488382','36.72','KOTA CILEGON',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('ab5761f9-cb03-4e2b-991c-f9224dd1b97a','8055235e-b7bc-4732-9f21-e79d1b6db2ec','11.18','KABUPATEN PIDIE JAYA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('ab72b4e4-6a78-48bb-9392-2a255e8e9730','ba1319d5-fc06-4612-b708-f3683687635e','13.11','KABUPATEN SOLOK SELATAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('abc95f48-83a5-432e-b108-d325fb0cc170','ed18c5c4-db9e-4a92-9e89-3a77d7091cf4','32.04','KABUPATEN BANDUNG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('ac687d30-a971-41dd-ac2a-71c68a473ddf','9b42310f-e0dc-491b-9e22-ff90396c1214','35.72','KOTA BLITAR',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('acd2610b-6fd6-427c-8930-d7037677e5ee','b787ea8b-16c7-46dd-849c-4073e41782cb','82.08','KABUPATEN PULAU TALIABU',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('ad21163e-bd96-4812-8e50-9c34a4c9c9fa','4286d1f8-fbd2-48b0-a207-f01fc52849fb','91.16','KABUPATEN BOVEN DIGOEL',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('ae325ef1-f008-4ca0-8522-8ddb64b4dfa8','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.76','KOTA TEGAL',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('aea7c263-65b1-444b-9fdd-a5650286a8f8','eb7c9797-3ac6-4866-8c15-dabc7df4090f','14.06','KABUPATEN ROKAN HULU',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('aebb76b4-90a3-4fd3-aa65-ca94d71aef26','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.71','KOTA MAGELANG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('b0d1b4f0-7ba6-4a41-83e2-826ccdb7b61e','8a61c56a-b1c0-4140-98f1-5afcb05843bf','16.71','KOTA PALEMBANG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('b23b974b-e6aa-4a25-bf56-61b04b44a829','dae68381-a6dd-4914-9a5e-94f7e00bb6ab','81.01','KABUPATEN MALUKU TENGAH',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('b2c1379f-1efe-4f70-a84b-07168dbe7fd2','e0e2c461-5273-4968-bd1a-b4252ae7f6cf','71.05','KABUPATEN MINAHASA SELATAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('b30456fa-6bf9-479c-8e45-470e8686d8f8','6de402c8-e85e-42c2-8606-0cd586359c8d','21.71','KOTA BATAM',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('b37778dd-c5f5-4cc7-a9a5-0dc1c4daf51a','dcacb222-1ea0-4a17-9c1d-7790540b6db1','15.08','KABUPATEN BUNGO',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('b3ae8044-be8c-442d-b40e-43e51d76fe31','8055235e-b7bc-4732-9f21-e79d1b6db2ec','11.03','KABUPATEN ACEH TIMUR',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('b48e8219-d558-4ab1-811c-11bd07ccda91','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.04','KABUPATEN NIAS',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('b49fbf56-4621-4347-9ee6-0567ce8f9e8a','d96797ff-3079-443b-8cf3-31d1feae59f7','53.10','KABUPATEN MANGGARAI',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('b5c037f0-3f9b-4939-ae3e-c4780ea69a25','dad6e81a-8665-46e7-8a4f-b50ed5429606','75.02','KABUPATEN BOALEMO',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('b798cd80-b7f5-4452-85f1-5cb6c2bd6cda','ed18c5c4-db9e-4a92-9e89-3a77d7091cf4','32.75','KOTA BEKASI',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('b7a5b75f-79bf-495e-809d-102c827f3e2f','6482cf92-4995-4b54-8366-6dae255800aa','19.05','KABUPATEN BANGKA BARAT',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('b7efc2e2-78a0-4fe8-bfb6-5f03be64fc2a','b787ea8b-16c7-46dd-849c-4073e41782cb','82.71','KOTA TERNATE',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('b85b8169-1307-453d-b290-3239f8ca7934','ed18c5c4-db9e-4a92-9e89-3a77d7091cf4','32.18','KABUPATEN PANGANDARAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('b8856341-a63c-41c6-bd1f-db0efc093631','56ff020f-3bcf-4b93-b1ea-1791da366255','73.11','KABUPATEN BARRU',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('b9803088-c08d-4280-aa27-bb881ac31b9f','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.05','KABUPATEN LANGKAT',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('ba007a4c-cf46-49a0-b451-ef515d720647','8055235e-b7bc-4732-9f21-e79d1b6db2ec','11.05','KABUPATEN ACEH BARAT',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('ba4c28cb-3613-454a-9a84-2526da4663f4','8055235e-b7bc-4732-9f21-e79d1b6db2ec','11.10','KABUPATEN ACEH SINGKIL',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('bbc9a71d-e09f-43f7-af97-346e02cedcf5','e0e2c461-5273-4968-bd1a-b4252ae7f6cf','71.09','KABUPATEN KEPULAUAN SIAU TAGULANDANG BIARO',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('bbdcbff3-a389-49fd-b379-bf8912156b37','dcacb222-1ea0-4a17-9c1d-7790540b6db1','15.71','KOTA JAMBI',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('bd7e2c11-0ca4-40ab-9150-a9b00542720c','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.03','KABUPATEN TAPANULI SELATAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('be0ff46c-dbab-49ea-bcc8-8703d558a10f','e0e2c461-5273-4968-bd1a-b4252ae7f6cf','71.03','KABUPATEN KEPULAUAN SANGIHE',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('bf0d15fb-ec2d-439e-8615-66c561f9a850','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.73','KOTA SIBOLGA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('bf5fd097-5273-4fdf-b597-51bb610cd73c','56ff020f-3bcf-4b93-b1ea-1791da366255','73.13','KABUPATEN WAJO',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('bfb14130-71e9-42c6-b8b2-68f126044a95','ba1319d5-fc06-4612-b708-f3683687635e','13.73','KOTA SAWAHLUNTO',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('c04c1d6b-afbf-43cb-88f7-6dec8754123d','d27572e1-544c-4959-af5b-0159b70db125','74.06','KABUPATEN BOMBANA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('c0afa32d-7fc8-404a-bf19-f17df80c630e','4286d1f8-fbd2-48b0-a207-f01fc52849fb','91.28','KABUPATEN DEIYAI',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('c0b96f8a-0631-483c-aa87-b8e934aeafed','8f4c6712-f6af-4e3d-94d2-00e0f9fab08d','65.01','KABUPATEN BULUNGAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('c12168f7-4d2b-49d8-abde-e509eff39a15','72380af8-5a27-438d-ac1e-bb0e29d3b661','34.01','KABUPATEN KULON PROGO',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('c1dc1e94-ae33-45d8-9a5f-e62b6fb51e5c','d96797ff-3079-443b-8cf3-31d1feae59f7','53.04','KABUPATEN BELU',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('c1dd4c65-a3cc-47df-8969-dfec1d74496c','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.16','KABUPATEN HUMBANG HASUNDUTAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('c262c7cb-37a3-4d4a-affd-f3c0cc38a6e3','ed18c5c4-db9e-4a92-9e89-3a77d7091cf4','32.71','KOTA BOGOR',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('c2794438-614a-42bb-9eaf-fc6333094daf','b787ea8b-16c7-46dd-849c-4073e41782cb','82.04','KABUPATEN HALMAHERA SELATAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('c30084da-0c58-49d5-8e45-8f68cd42275c','dad6e81a-8665-46e7-8a4f-b50ed5429606','75.03','KABUPATEN BONE BOLANGO',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('c3878b1b-2016-477c-83f0-70f0910461dd','ed18c5c4-db9e-4a92-9e89-3a77d7091cf4','32.06','KABUPATEN TASIKMALAYA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('c499d858-3e7d-4f1d-897d-8b20d5e878e5','56ff020f-3bcf-4b93-b1ea-1791da366255','73.18','KABUPATEN TANA TORAJA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('c4bb18a2-5825-404b-8a60-70f6c7a96f03','8a61c56a-b1c0-4140-98f1-5afcb05843bf','16.10','KABUPATEN OGAN ILIR',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('c4db167f-2f2a-44b7-aaf7-f31809ab98c8','fc5a8ac9-dfff-41aa-ae85-b1ab391aaa09','64.09','KABUPATEN PENAJAM PASER UTARA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('c5bce03f-1f59-4c24-bf8a-e3e238b8ab68','ba1319d5-fc06-4612-b708-f3683687635e','13.12','KABUPATEN PASAMAN BARAT',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('c65d8935-baed-4ba4-963e-a80c54948e81','ba1319d5-fc06-4612-b708-f3683687635e','13.07','KABUPATEN LIMA PULUH KOTA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('c820504d-81b9-4afe-8ca7-62ddf3f72fd3','4286d1f8-fbd2-48b0-a207-f01fc52849fb','91.15','KABUPATEN WAROPEN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('c8a71d94-7618-4276-a587-760d226fd51b','38e7d99e-a56d-4352-9f57-2d999d66ac61','52.06','KABUPATEN BIMA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('c9185ba4-4233-4510-a7ef-304c83d8baed','809a26f2-4be0-49f7-ba4d-a3251f488382','36.03','KABUPATEN TANGERANG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('c981595e-f0bb-4ce4-be29-0d7effb97dba','dad6e81a-8665-46e7-8a4f-b50ed5429606','75.04','KABUPATEN POHUWATO',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('c9e019a5-be5e-4aef-8551-ad7c1fa29f40','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.18','KABUPATEN SERDANG BEDAGAI',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('caeb2e9d-d411-40cb-96a1-2663be838d7a','6482cf92-4995-4b54-8366-6dae255800aa','19.71','KOTA PANGKALPINANG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('cb427136-0b7f-4a34-a047-d74c54a2b0b5','9b42310f-e0dc-491b-9e22-ff90396c1214','35.78','KOTA SURABAYA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('cc1871b6-1a48-4046-b0a7-612a3186e21a','ee91309e-ffaf-4405-ad5b-c9b0ec6341da','18.01','KABUPATEN LAMPUNG SELATAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('cc376c6e-eedd-4cc1-a205-7dd7a4c47af8','9b42310f-e0dc-491b-9e22-ff90396c1214','35.14','KABUPATEN PASURUAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('cd6eb9c3-3c5a-4c6b-b335-a1ec396b9e29','38e7d99e-a56d-4352-9f57-2d999d66ac61','52.07','KABUPATEN SUMBAWA BARAT',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('cdd903c1-f13b-4c63-af84-217bd4d64232','9b42310f-e0dc-491b-9e22-ff90396c1214','35.75','KOTA PASURUAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('ce3cb04c-0418-4fde-a458-89df61b11be9','dae68381-a6dd-4914-9a5e-94f7e00bb6ab','81.05','KABUPATEN SERAM BAGIAN TIMUR',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('cf3d1677-031b-4ca9-8d54-a3cafc865802','4286d1f8-fbd2-48b0-a207-f01fc52849fb','91.18','KABUPATEN ASMAT',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('cf651266-a330-4e82-8e91-e8015c201cf2','ee91309e-ffaf-4405-ad5b-c9b0ec6341da','18.12','KABUPATEN TULANG BAWANG BARAT',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('cfd038b1-fe45-4881-b519-a9b27f82c960','3063ce6a-fe6b-46bc-8072-50d02234cab3','61.12','KABUPATEN KUBU RAYA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('d008f2f3-3de6-44fb-aa29-2ee53e726e63','4286d1f8-fbd2-48b0-a207-f01fc52849fb','91.26','KABUPATEN DOGIYAI',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('d117ba66-7870-466f-a629-bb894a7863b7','ed18c5c4-db9e-4a92-9e89-3a77d7091cf4','32.03','KABUPATEN CIANJUR',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('d2eb6c4f-e34f-4a62-87be-987beb517dc4','d96797ff-3079-443b-8cf3-31d1feae59f7','53.07','KABUPATEN SIKKA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('d402056d-a3da-4617-a7ad-e22fcb138050','380a5175-5371-43d0-bc10-45be017f83d7','76.03','KABUPATEN MAMASA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('d4426694-e869-4605-a132-04db712a244e','56ff020f-3bcf-4b93-b1ea-1791da366255','73.71','KOTA MAKASSAR',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('d4b1fc31-262f-4821-9a79-3f462320bfcb','8055235e-b7bc-4732-9f21-e79d1b6db2ec','11.15','KABUPATEN NAGAN RAYA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('d541d45e-a9f3-44cc-9907-72a4b0f7cbad','3063ce6a-fe6b-46bc-8072-50d02234cab3','61.07','KABUPATEN BENGKAYANG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('d64146ff-3087-405c-8b22-a632eb0de076','3063ce6a-fe6b-46bc-8072-50d02234cab3','61.09','KABUPATEN SEKADAU',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('d7055f60-98ef-422f-b71a-f4b55811c8fa','d27572e1-544c-4959-af5b-0159b70db125','74.08','KABUPATEN KOLAKA UTARA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('d7845a6a-b592-477a-9525-46f608f417e1','87af1478-253a-414d-b828-e7d5f86838c7','17.09','KABUPATEN BENGKULU TENGAH',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('d822ef86-f930-44db-94d9-1c5f4a053f04','dae68381-a6dd-4914-9a5e-94f7e00bb6ab','81.07','KABUPATEN KEPULAUAN ARU',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('d85a1e65-97d6-4f1a-83af-1e5e6450d372','e093b3d5-ce15-4a1d-95af-d0f9b0f5c0ac','72.01','KABUPATEN BANGGAI',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('d95803fb-ded3-4011-93b6-25f380aba643','3063ce6a-fe6b-46bc-8072-50d02234cab3','61.06','KABUPATEN KAPUAS HULU',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('da1226ce-3155-4098-b201-124cce41bd4b','e0e2c461-5273-4968-bd1a-b4252ae7f6cf','71.08','KABUPATEN BOLAANG MONDONDOW UTARA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('da3d0e8b-1556-4a64-a235-071f95660d0d','8a61c56a-b1c0-4140-98f1-5afcb05843bf','16.08','KABUPATEN OGAN KOMERING ULU TIMUR',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('daf1ef9c-a6fb-4d58-88f8-7a5e187e95b5','4286d1f8-fbd2-48b0-a207-f01fc52849fb','91.20','KABUPATEN MAMBERAMO RAYA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('db0a8c21-a65f-49ad-867a-ead0cf07cc85','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.11','KABUPATEN SUKOHARJO',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('db9124e5-93f0-4db3-919d-392240de210c','9b42310f-e0dc-491b-9e22-ff90396c1214','35.05','KABUPATEN BLITAR',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('dc0dbf7a-a88e-426f-81f5-9b8ed71637ea','9b42310f-e0dc-491b-9e22-ff90396c1214','35.24','KABUPATEN LAMONGAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('dca7b0c0-7292-463c-a949-04347ccf908f','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.24','KABUPATEN KENDAL',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('dd04200b-3ba0-461c-86af-ebe3677b103a','9b42310f-e0dc-491b-9e22-ff90396c1214','35.16','KABUPATEN MOJOKERTO',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('dd1ff3ee-40c8-4e1b-9695-14673e3376b1','9b42310f-e0dc-491b-9e22-ff90396c1214','35.11','KABUPATEN BONDOWOSO',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('dd9d1e84-aabd-4c84-90b6-0db88e2c1081','31e905f0-af45-404c-9a3c-ff687b86e56f','92.09','KABUPATEN TAMBRAUW',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('dda2bc7b-c3b6-4a58-b326-804616233bf3','3dfa9f13-4b2b-463b-9e93-ce00cff7d34d','63.08','KABUPATEN HULU SUNGAI UTARA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('ddb7ca54-1b67-4979-8b2e-68aacdb39d3e','dae68381-a6dd-4914-9a5e-94f7e00bb6ab','81.06','KABUPATEN SERAM BAGIAN BARAT',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('ddc60239-b525-4117-8338-04813b6cb2a7','8055235e-b7bc-4732-9f21-e79d1b6db2ec','11.74','KOTA LANGSA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('de066506-e50a-43d2-b241-cfb64bf36ad3','3063ce6a-fe6b-46bc-8072-50d02234cab3','61.03','KABUPATEN SANGGAU',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('de99ba27-500b-427d-98e8-d95ce4b218e3','e0e2c461-5273-4968-bd1a-b4252ae7f6cf','71.10','KABUPATEN BOLAANG MONDONDOW TIMUR',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('def3437d-f8b6-4640-b9d8-4027ce3e0b25','fc5a8ac9-dfff-41aa-ae85-b1ab391aaa09','64.08','KABUPATEN KUTAI TIMUR',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('dfe8ae57-bbcf-480e-912b-31cc7672ed70','8a61c56a-b1c0-4140-98f1-5afcb05843bf','16.05','KABUPATEN MUSI RAWAS',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('dfef0b0c-5eaa-4366-8884-93266e890d15','ed18c5c4-db9e-4a92-9e89-3a77d7091cf4','32.72','KOTA SUKABUMI',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('e0db0392-b9c7-45bd-8e9e-c63e151f4833','8a61c56a-b1c0-4140-98f1-5afcb05843bf','16.03','KABUPATEN MUARA ENIM',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('e0e32f36-1c8f-4fbd-bd53-b9124a10cfe9','d27572e1-544c-4959-af5b-0159b70db125','74.11','KABUPATEN KOLAKA TIMUR',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('e12c3b39-d564-4ad7-aade-d69c876bee73','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.18','KABUPATEN PATI',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('e1b45fca-cde4-4ae9-b62e-94f8c5d82330','3dfa9f13-4b2b-463b-9e93-ce00cff7d34d','63.09','KABUPATEN TABALONG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('e1d363ed-7a4d-4e9b-a946-01e3f256fcd7','fc5a8ac9-dfff-41aa-ae85-b1ab391aaa09','64.71','KOTA BALIKPAPAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('e2fa63a6-ff7d-4a98-ae82-5ae5a8843794','e093b3d5-ce15-4a1d-95af-d0f9b0f5c0ac','72.02','KABUPATEN POSO',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('e34a4400-6105-4e89-8cb2-e3999b99e648','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.28','KABUPATEN TEGAL',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('e3e31df3-d67d-4292-ae6f-e9c14bd078d1','dc79dc41-da5e-4416-b608-e154db24f89b','51.08','KABUPATEN BULELENG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('e4588cce-4614-46ff-be4f-c419a166633a','6482cf92-4995-4b54-8366-6dae255800aa','19.03','KABUPATEN BANGKA SELATAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('e4595a73-413c-4997-9221-b6303ef27913','dcacb222-1ea0-4a17-9c1d-7790540b6db1','15.07','KABUPATEN TANJUNG JABUNG TIMUR',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('e471e387-e231-4aed-a3d6-68c1962fd707','8055235e-b7bc-4732-9f21-e79d1b6db2ec','11.09','KABUPATEN SIMEULUE',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('e52126b7-f582-4355-b690-3d213de1047f','ba1319d5-fc06-4612-b708-f3683687635e','13.10','KABUPATEN DHARMASRAYA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('e5ab5318-ce11-406d-b855-f4f7b631cfc8','4286d1f8-fbd2-48b0-a207-f01fc52849fb','91.21','KABUPATEN MAMBERAMO TENGAH',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('e5ddff2f-d7ee-489c-ba2b-11cc28be6d54','d96797ff-3079-443b-8cf3-31d1feae59f7','53.06','KABUPATEN FLORES TIMUR',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('e6a590c9-2203-409d-b4fd-91da47e4de6b','31e905f0-af45-404c-9a3c-ff687b86e56f','92.08','KABUPATEN KAIMANA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('e74017e8-ff44-45bd-be90-ac0ab614f1d5','5adddbb3-d8dc-4078-a053-1a3ca11ac356','31.01','KABUPATEN ADMINISTRASI KEPULAUAN SERIBU',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('e7f2eb9e-1d8c-453f-90cb-ab1ff532047c','b787ea8b-16c7-46dd-849c-4073e41782cb','82.72','KOTA TIDORE KEPULAUAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('e8801a15-505d-4b55-86e3-871cd8470577','9b42310f-e0dc-491b-9e22-ff90396c1214','35.21','KABUPATEN NGAWI',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('e9cff29e-87b3-44a9-bb02-37409ee66410','3dfa9f13-4b2b-463b-9e93-ce00cff7d34d','63.05','KABUPATEN TAPIN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('ea7a6bbb-c516-44a7-9505-c22bfc88578a','b787ea8b-16c7-46dd-849c-4073e41782cb','82.02','KABUPATEN HALMAHERA TENGAH',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('ea95e491-d75e-4803-8bf1-3eceb944cb34','56ff020f-3bcf-4b93-b1ea-1791da366255','73.03','KABUPATEN BANTAENG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('eabd9b8b-080b-4fe4-9228-bb116b874de3','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.14','KABUPATEN NIAS SELATAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('ebb4d16f-0803-4fdb-832a-1fb40fcd3f1c','9b42310f-e0dc-491b-9e22-ff90396c1214','35.25','KABUPATEN GRESIK',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('ebbaee1d-a684-4a3a-a1a1-51ddcbc59e1b','4286d1f8-fbd2-48b0-a207-f01fc52849fb','91.10','KABUPATEN SARMI',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('ec135f62-a943-48de-b50f-0eed1cc4664d','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.72','KOTA PEMATANG SIANTAR',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('ec9f2ac4-9335-4967-828f-4a8d98e45769','4286d1f8-fbd2-48b0-a207-f01fc52849fb','91.22','KABUPATEN YALIMO',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('ed5f3d4d-bfec-4745-ae04-9c53a04dc76f','d27572e1-544c-4959-af5b-0159b70db125','74.05','KABUPATEN KONAWE SELATAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('ee77c4da-2a94-4503-977c-c9887ed5ae35','3dfa9f13-4b2b-463b-9e93-ce00cff7d34d','63.04','KABUPATEN BARITO KUALA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('ee7e7f99-29ee-4ffd-8d76-180dd3721cb8','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.13','KABUPATEN KARANGANYAR',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('ef270771-01fb-4205-a171-b73a08c794af','4286d1f8-fbd2-48b0-a207-f01fc52849fb','91.17','KABUPATEN MAPPI',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('ef3c32c0-517f-446c-a4c8-88a773153737','ed18c5c4-db9e-4a92-9e89-3a77d7091cf4','32.15','KABUPATEN KARAWANG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('ef5ca546-2fde-4d12-8a5a-ce66bcbafb09','9b42310f-e0dc-491b-9e22-ff90396c1214','35.28','KABUPATEN PAMEKASAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('f07df77d-80a5-413f-a049-09911d79c2f7','9b42310f-e0dc-491b-9e22-ff90396c1214','35.22','KABUPATEN BOJONEGORO',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('f0841436-0cbe-4e01-9685-49de091e6fc0','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.19','KABUPATEN KUDUS',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('f0ad8698-fee1-438c-9432-6e7a82c37d89','c9f49bd6-8ee5-4c41-879e-f1d0bec034bf','62.12','KABUPATEN MURUNG RAYA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('f1441b59-dfc5-45e9-a507-afce59ccdc8f','38e7d99e-a56d-4352-9f57-2d999d66ac61','52.04','KABUPATEN SUMBAWA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('f1bf04db-1c8c-44d5-ac41-16129842b3f5','fc5a8ac9-dfff-41aa-ae85-b1ab391aaa09','64.03','KABUPATEN BERAU',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('f1c849d5-3d74-4167-9a25-0eda243a6eb7','dc79dc41-da5e-4416-b608-e154db24f89b','51.01','KABUPATEN JEMBRANA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('f2d3c2c7-0c79-4e81-bfc4-ab40bc2d3828','3dfa9f13-4b2b-463b-9e93-ce00cff7d34d','63.03','KABUPATEN BANJAR',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('f2db4364-86a7-438a-9148-36f9eef9fa57','ceb32469-7908-42e6-acc1-f7c64a8918d3','12.22','KABUPATEN LABUHANBATU SELATAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('f3abf231-12fe-4767-bbae-98078252f96e','fc5a8ac9-dfff-41aa-ae85-b1ab391aaa09','64.02','KABUPATEN KUTAI KARTANEGARA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('f40dc2b8-ab93-4433-82ae-92b1e0601328','ed18c5c4-db9e-4a92-9e89-3a77d7091cf4','32.77','KOTA CIMAHI',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('f4c05cac-2eb4-4189-9e9e-9a800b60b645','8f4c6712-f6af-4e3d-94d2-00e0f9fab08d','65.71','KOTA TARAKAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('f4c6ccff-8073-4d98-ac20-f38776676f64','eb7c9797-3ac6-4866-8c15-dabc7df4090f','14.09','KABUPATEN KUANTAN SINGINGI',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('f5935b75-2372-436b-bb26-f5ccda50f1b5','ee91309e-ffaf-4405-ad5b-c9b0ec6341da','18.06','KABUPATEN TANGGAMUS',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('f6cb42ad-d380-4e22-968d-782100cafea9','6482cf92-4995-4b54-8366-6dae255800aa','19.01','KABUPATEN BANGKA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('f74f83b6-b153-4f99-9457-2263110ee232','e093b3d5-ce15-4a1d-95af-d0f9b0f5c0ac','72.10','KABUPATEN SIGI',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('f78bb96f-4bfb-4c0d-b2e4-669fdbee1fe9','8a61c56a-b1c0-4140-98f1-5afcb05843bf','16.74','KOTA PRABUMULIH',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('f84f0e23-eca1-4565-bda2-a249b0b433bc','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.02','KABUPATEN BANYUMAS',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('fa7adaf5-d5cb-4343-a104-875ace469ad4','ba1319d5-fc06-4612-b708-f3683687635e','13.72','KOTA SOLOK',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('fa9df1c9-fee1-4563-a881-c34c8c3b9aee','9b42310f-e0dc-491b-9e22-ff90396c1214','35.06','KABUPATEN KEDIRI',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('faaa2f40-7964-4247-aa51-961431e42233','d96797ff-3079-443b-8cf3-31d1feae59f7','53.12','KABUPATEN SUMBA BARAT',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('fb2c46c7-47c1-4529-9616-1faa35038c9e','8a61c56a-b1c0-4140-98f1-5afcb05843bf','16.07','KABUPATEN BANYUASIN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('fba95c0e-47a9-41dd-9acd-a07f6324e2bc','4286d1f8-fbd2-48b0-a207-f01fc52849fb','91.04','KABUPATEN NABIRE',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('fbb0efd0-9da1-4da0-8972-9b5833405089','e0e2c461-5273-4968-bd1a-b4252ae7f6cf','71.11','KABUPATEN BOLAANG MONDONDOW SELATAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('fcee920e-6cc8-44de-80d9-591d3901baee','6f57a363-bc25-4b68-b2b6-46662e1d7221','33.27','KABUPATEN PEMALANG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('fe3977c3-28b3-4b12-b864-03a9f260fc63','9b42310f-e0dc-491b-9e22-ff90396c1214','35.01','KABUPATEN PACITAN',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('fe7abc7f-f1a3-4286-87d6-791b129345c0','3063ce6a-fe6b-46bc-8072-50d02234cab3','61.72','KOTA SINGKAWANG',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40'),('febdba83-56b1-43b9-9d74-9704134ca98d','ee91309e-ffaf-4405-ad5b-c9b0ec6341da','18.09','KABUPATEN PESAWARAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('ff47eae5-cc5e-4b30-8a6b-1fe0e98c28ea','4286d1f8-fbd2-48b0-a207-f01fc52849fb','91.27','KABUPATEN INTAN JAYA',NULL,NULL,NULL,'2020-02-24 21:23:40','2020-02-24 21:23:40');

INSERT INTO companies(id,parent_id,address,code,name,birth_day,email,tax_number,created_by,updated_by,deleted_at,created_at,updated_at) VALUES('075e4ead-c356-4c79-abe6-acfb15c70edb',NULL,NULL,'SSI','PT. SEMART SOLUSI INDONESIA','1977-11-17','admin@kejawenlab.com','338-00-0912-244',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39');


INSERT INTO company_departments(id,department_id,company_id,created_by,updated_by,deleted_at,created_at,updated_at) VALUES('3685a2f6-aa07-4167-97a5-d2d708dd9755','86e35c4e-031a-426a-8585-b1f95b414bcc','075e4ead-c356-4c79-abe6-acfb15c70edb',NULL,NULL,NULL,'2020-02-24 21:23:42','2020-02-24 21:23:42'),('5ee97121-da89-4ff5-85aa-231f8395d4c3','2cdf647e-e053-42ac-b72c-ebb5533b06c5','075e4ead-c356-4c79-abe6-acfb15c70edb',NULL,NULL,NULL,'2020-02-24 21:23:42','2020-02-24 21:23:42'),('7ef251d2-84d7-4000-9cef-91c81247a872','266fafbf-072b-46eb-b374-6f25c3ed1602','075e4ead-c356-4c79-abe6-acfb15c70edb',NULL,NULL,NULL,'2020-02-24 21:23:42','2020-02-24 21:23:42'),('aa3803c2-9f99-4f54-9e6d-60484f63f7f3','23413307-1d25-4949-809a-4cc072e760b1','075e4ead-c356-4c79-abe6-acfb15c70edb',NULL,NULL,NULL,'2020-02-24 21:23:42','2020-02-24 21:23:42');

INSERT INTO contracts(id,type,letter_number,subject,description,start_date,end_date,signed_date,tags,used,created_by,updated_by,deleted_at,created_at,updated_at) VALUES('a7de8401-4ded-45c7-bb39-20a0e7504467','e','EMP/01/2017','SURYA','Kontrak Kerja Surya','2017-11-27','2018-11-10','2017-11-27',X'613a303a7b7d',1,NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:43');

INSERT INTO departments(id,parent_id,code,name,created_by,updated_by,deleted_at,created_at,updated_at) VALUES('23413307-1d25-4949-809a-4cc072e760b1','2cdf647e-e053-42ac-b72c-ebb5533b06c5','ITMIS','IT MANAGEMENT INFORMATION SYSTEM',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('266fafbf-072b-46eb-b374-6f25c3ed1602','2cdf647e-e053-42ac-b72c-ebb5533b06c5','ITDC','IT DATA CENTER',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('2cdf647e-e053-42ac-b72c-ebb5533b06c5',NULL,'IT','INFORMATION TECHNOLOGY',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('86e35c4e-031a-426a-8585-b1f95b414bcc','2cdf647e-e053-42ac-b72c-ebb5533b06c5','ITSP','IT SUPPORT',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39');

INSERT INTO education_titles(id,short_name,name,created_by,updated_by,deleted_at,created_at,updated_at) VALUES('68f8ad1a-ad91-4c3a-bb63-b0db4592bf49','S.Ag','SARJANA AGAMA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('7e2d1bae-d4e2-4b00-86dc-ca8441ec77de','S.Pd','SARJANA PENDIDIKAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('ae67b3df-adcb-48e0-ab3d-debe9f815bad','S.E','SARJANA EKONOMI',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('bc5fa060-cb95-4898-b497-7a94d77e926c','S.Kom','SARJANA KOMPUTER',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('dac3c97a-740a-4cbd-af04-d769504e99d7','S.Sos','SARJANA SOSIAL',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('ee1b5153-7205-447d-b1a0-8e7d9b459155','S.T','SARJANA TEKNIK',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('fe9f6cc9-df3a-4160-bbcf-d6a3b1f015db','S.H','SARJANA HUKUM',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39');

INSERT INTO educational_institutes(id,name,created_by,updated_by,deleted_at,created_at,updated_at) VALUES('02c881fd-98cb-4c09-8936-5284ff11fc2c','UNIVERSITAS GUNADARMA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('0accb1d0-1048-4383-9051-810bdfb7ec9f','UNIVERSITAS NEGERI JAKARTA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('4296f65c-36d8-489d-a98c-66e1a6f4cba9','UNIVERSITAS BISNIS INDONESIA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('54d4b4d1-3cb5-42af-a410-61be4c993a22','UNIVERSITAS MUHAMMADIYAH JAKARTA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('5631c984-1a81-48b9-ac99-394af858c671','UNIVERSITAS TRISAKSI',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('c0445b59-f9c0-4fc7-9617-9045c11d8af1','UNIVERSITAS ISLAM INDONESIA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('e0e147e2-5c6d-48e4-aced-428fd9ef91da','UNIVERSITAS PANCASILA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('f6b232f4-dc47-460d-b843-62e0a1854c14','UNIVERSITAS ISLAM NEGERI SYARIF HIDAYATULLAH',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('fbc6e3d7-8d79-4566-a7aa-b272e393f425','UNIVERSITAS INDONESIA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('fe63ff32-d647-46a1-b16f-46874cb058d1','UNIVERSITAS PENDIDIKAN INDONESIA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39');


INSERT INTO employees(id,contract_id,company_id,department_id,joblevel_id,jobtitle_id,supervisor_id,region_of_birth_id,city_of_birth_id,address,join_date,employee_status,code,full_name,gender,date_of_birth,identity_number,identity_type,marital_status,email,leave_balance,tax_group,resign_date,have_overtime_benefit,risk_ratio,profile_image,profile_size,created_by,updated_by,deleted_at,created_at,updated_at,salary_group_id,shiftment_group_id) VALUES('8a231d41-a5a7-4945-8cd7-df3bf89c3081','a7de8401-4ded-45c7-bb39-20a0e7504467','075e4ead-c356-4c79-abe6-acfb15c70edb','2cdf647e-e053-42ac-b72c-ebb5533b06c5','6dd31fbd-6ccd-41cd-a736-5b2693542fff','1601e0d2-9aaf-4880-b059-b819e4bb907d','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','9b42310f-e0dc-491b-9e22-ff90396c1214','cb427136-0b7f-4a34-a047-d74c54a2b0b5','klagen','2019-12-02','K','MIS000002','Ahmad Afandi','M','1985-03-20','9098958943892','K','M','ahmad.afandi85@gmail.com',NULL,'TK',NULL,1,'',NULL,NULL,NULL,NULL,NULL,'2020-02-29 22:09:03','2020-02-29 22:20:30','e81cb3ad-023f-419a-ad19-4d44cb425203','bb554ec2-c8e7-4919-ae15-860f478e6b9a'),('bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','a7de8401-4ded-45c7-bb39-20a0e7504467','075e4ead-c356-4c79-abe6-acfb15c70edb','23413307-1d25-4949-809a-4cc072e760b1','6dd31fbd-6ccd-41cd-a736-5b2693542fff','1601e0d2-9aaf-4880-b059-b819e4bb907d',NULL,'5adddbb3-d8dc-4078-a053-1a3ca11ac356','64d46705-d390-4025-bfcf-8782fc062717','gerbang 3','2017-03-17','K','MIS000001','MUHAMAD SURYA IKSANUDIN','M','1987-01-01','331012321','K','M','admin@ssi.com',NULL,'TK',NULL,1,'vlr',NULL,NULL,NULL,NULL,NULL,'2020-02-24 21:23:43','2020-02-29 22:29:03','c1028cc5-df63-4899-9f4f-c25d10b9fff7','6115a8fd-71fc-48ae-a55b-0801a84c48ed');


INSERT INTO holidays(id,holiday_date,name,created_by,updated_by,deleted_at,created_at,updated_at) VALUES('11628d47-7d50-46d7-b58e-b2df3aa6b7fd','2020-11-10','HARI PAHLAWAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39');

INSERT INTO job_levels(id,parent_id,code,name,created_by,updated_by,deleted_at,created_at,updated_at) VALUES('1bd741f8-2bd4-492f-8bce-56e38da76f36','efbaa0d1-74d6-45ed-936a-a0dddfe171fb','SPV','SUPERVISOR',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('6dd31fbd-6ccd-41cd-a736-5b2693542fff','1bd741f8-2bd4-492f-8bce-56e38da76f36','STF','STAFF',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('7a7fafd8-190e-4184-b8e3-340b135445a6','df927d04-ba8f-4e3c-bab8-394f7bf94089','DRT','DIREKTUR',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('afa1bc00-72d1-4f71-8f01-75cb3daa7658','7a7fafd8-190e-4184-b8e3-340b135445a6','GM','GENERAL MANAGER',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('d30fa453-2fcf-46d6-9576-b6fff98938fe','6dd31fbd-6ccd-41cd-a736-5b2693542fff','NSTF','NON STAFF',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('df927d04-ba8f-4e3c-bab8-394f7bf94089',NULL,'KMRS','KOMISARIS',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('efbaa0d1-74d6-45ed-936a-a0dddfe171fb','afa1bc00-72d1-4f71-8f01-75cb3daa7658','MGR','MANAGER',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39');



INSERT INTO job_titles(id,job_level_id,code,name,created_by,updated_by,deleted_at,created_at,updated_at) VALUES('1601e0d2-9aaf-4880-b059-b819e4bb907d','6dd31fbd-6ccd-41cd-a736-5b2693542fff','STFIT','STAFF IT',NULL,NULL,NULL,'2020-02-24 21:23:42','2020-02-24 21:23:42'),('76e84d99-8e2c-4a5a-a086-f158d6a82e10','6dd31fbd-6ccd-41cd-a736-5b2693542fff','STFADM','STAFF ADMINISTRASI',NULL,NULL,NULL,'2020-02-24 21:23:42','2020-02-24 21:23:42');


INSERT INTO menus(id,name,route,icon,status,parent_id,descriptions) VALUES(1,'Master','','fa fa-users','1',0,NULL),(2,'Master Menu','master/menu','fa fa-users','1',1,NULL),(3,'Master Role','master/role','fa fa-bar-chart-o','1',1,'Administrasi role'),(4,'Master User','master/user','fa fa-users','1',1,NULL),(6,'Attendance','','fa fa-table','1',0,'Grup attendance'),(7,'Payroll','','fa fa-money','1',0,'Penggajian'),(8,'Kehadiran','attendance/attendances','fa fa-table','1',6,'Kehadiaran karyawan'),(9,'Cuti','attendance/leaves','fa fa-table','1',6,'Cuti'),(10,'Attendace Summary','attendance/attendance_summaries','fa fa-table','1',6,'Rekap kehadiran'),(11,'Overtime','attendance/overtimes','fa fa-money','1',6,'Lembur'),(12,'Payroll Slip','payroll/payrolls','fa fa-money','1',7,'Slip gaji'),(13,'Periode Gaji','payroll/payroll_periods','fa fa-table','1',7,'periode gaji'),(14,'Payroll Detail','payroll/payroll_details','fa fa-table','1',7,'Detail gaji'),(15,'Komponen Gaji','payroll/salary_components','fa fa-money','1',7,'komponen gaji'),(16,'Tunjangan Gaji','payroll/salary_allowances','fa fa-table','1',7,'tunjangan'),(17,'Tambahan Gaji','payroll/salary_benefits','fa fa-table','1',7,'benefit'),(18,'Kota','master/cities','fa fa-table','1',1,'Master kota'),(19,'Perusahaan','master/companies','fa fa-table','1',1,'Master kota'),(21,'Biaya Perusahaan','master/company_costs','fa fa-table','1',1,'Master kota'),(22,'Kontrak','master/contracts','fa fa-table','1',1,'Master kota'),(23,'Departemen','master/departements','fa fa-table','1',1,'Master kota'),(24,'Pegawai','master/employees','fa fa-table','1',1,'Master kota'),(25,'Hari Libur','master/holidays','fa fa-table','1',1,'Master kota'),(26,'Job level','master/job_levels','fa fa-table','1',1,'Master kota'),(27,'Job title','master/job_titles','fa fa-table','1',1,'Master kota'),(28,'Wilayah','master/regions','fa fa-table','1',1,'Master kota'),(29,'Settint','master/setting','fa fa-table','1',1,'Master kota'),(30,'Shift','master/shiftments','fa fa-table','1',1,'Master kota'),(31,'Skill group','master/skill_groups','fa fa-table','1',1,'Master kota'),(32,'Skill','master/skills','fa fa-table','1',1,'Master kota'),(33,'Pajak','master/taxs','fa fa-table','1',1,'Master kota'),(34,'History Pajak','master/tax_group_history','fa fa-table','1',1,'Master kota'),(35,'Shift Jam Kerja','master/workshifts','fa fa-table','1',1,'Master kota'),(36,'Report','','fa fa-graph','1',0,'Group reporting'),(37,'Log Activity','report/activitylog','fa fa-table','1',36,'Log pengguna'),(38,'Salary group','master/salary_groups','fa fa-money','1',1,'master salary group'),(39,'Ganti Password','user/user/changePassword','fa fa-keys','1',0,'Ganti password'),(40,'Shiftment Group','master/shiftment_groups','fa fa-table','1',1,'Daftar waktu shift yang berlaku dalam perusahaan');





INSERT INTO permissions(id,name,route,menus_id) VALUES(1,'add_salary_group_details','master/salary_group_detail',38);

INSERT INTO regions(id,code,name,created_by,updated_by,deleted_at,created_at,updated_at) VALUES('3063ce6a-fe6b-46bc-8072-50d02234cab3','61','KALIMANTAN BARAT',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('31e905f0-af45-404c-9a3c-ff687b86e56f','92','PAPUA BARAT',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('380a5175-5371-43d0-bc10-45be017f83d7','76','SULAWESI BARAT',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('38e7d99e-a56d-4352-9f57-2d999d66ac61','52','NUSA TENGGARA BARAT',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('3dfa9f13-4b2b-463b-9e93-ce00cff7d34d','63','KALIMANTAN SELATAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('4286d1f8-fbd2-48b0-a207-f01fc52849fb','91','PAPUA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('56ff020f-3bcf-4b93-b1ea-1791da366255','73','SULAWESI SELATAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('5adddbb3-d8dc-4078-a053-1a3ca11ac356','31','DKI JAKARTA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('6482cf92-4995-4b54-8366-6dae255800aa','19','KEPULAUAN BANGKA BELITUNG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('6de402c8-e85e-42c2-8606-0cd586359c8d','21','KEPULAUAN RIAU',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('6f57a363-bc25-4b68-b2b6-46662e1d7221','33','JAWA TENGAH',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('72380af8-5a27-438d-ac1e-bb0e29d3b661','34','DI YOGYAKARTA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('8055235e-b7bc-4732-9f21-e79d1b6db2ec','11','A C E H',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('809a26f2-4be0-49f7-ba4d-a3251f488382','36','B A N T E N',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('87af1478-253a-414d-b828-e7d5f86838c7','17','BENGKULU',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('8a61c56a-b1c0-4140-98f1-5afcb05843bf','16','SUMATERA SELATAN',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('8f4c6712-f6af-4e3d-94d2-00e0f9fab08d','65','KALIMANTAN UTARA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('9b42310f-e0dc-491b-9e22-ff90396c1214','35','JAWA TIMUR',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('b787ea8b-16c7-46dd-849c-4073e41782cb','82','MALUKU UTARA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('ba1319d5-fc06-4612-b708-f3683687635e','13','SUMATERA BARAT',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('c9f49bd6-8ee5-4c41-879e-f1d0bec034bf','62','KALIMANTAN TENGAH',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('cb966f0a-a14e-435c-9b95-02ad5ce66fcd','99','Kota Baru Buka',NULL,NULL,NULL,'2020-02-25 13:38:32','2020-02-25 13:38:32'),('ceb32469-7908-42e6-acc1-f7c64a8918d3','12','SUMATERA UTARA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('d27572e1-544c-4959-af5b-0159b70db125','74','SULAWESI TENGGARA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('d96797ff-3079-443b-8cf3-31d1feae59f7','53','NUSA TENGGARA TIMUR',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('dad6e81a-8665-46e7-8a4f-b50ed5429606','75','GORONTALO',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('dae68381-a6dd-4914-9a5e-94f7e00bb6ab','81','MALUKU',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('dc79dc41-da5e-4416-b608-e154db24f89b','51','B A L I',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('dcacb222-1ea0-4a17-9c1d-7790540b6db1','15','J A M B I',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('e093b3d5-ce15-4a1d-95af-d0f9b0f5c0ac','72','SULAWESI TENGAH',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('e0e2c461-5273-4968-bd1a-b4252ae7f6cf','71','SULAWESI UTARA',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('eb7c9797-3ac6-4866-8c15-dabc7df4090f','14','R I A U',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('ed18c5c4-db9e-4a92-9e89-3a77d7091cf4','32','JAWA BARAT',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('ee91309e-ffaf-4405-ad5b-c9b0ec6341da','18','LAMPUNG',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('fc5a8ac9-dfff-41aa-ae85-b1ab391aaa09','64','KALIMANTAN TIMUR',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39');

INSERT INTO role_menus(roles_id,menus_id,status) VALUES(1,1,'1'),(1,2,'1'),(1,3,'1'),(1,4,'1'),(1,6,'1'),(1,7,'1'),(1,8,'1'),(1,9,'1'),(1,10,'1'),(1,11,'1'),(1,12,'1'),(1,13,'1'),(1,14,'1'),(1,15,'1'),(1,16,'1'),(1,17,'1'),(1,18,'1'),(1,19,'1'),(1,21,'1'),(1,22,'1'),(1,23,'1'),(1,24,'1'),(1,25,'1'),(1,26,'1'),(1,27,'1'),(1,28,'1'),(1,29,'1'),(1,30,'1'),(1,31,'1'),(1,32,'1'),(1,33,'1'),(1,34,'1'),(1,35,'1'),(1,36,'1'),(1,37,'1'),(1,38,'1'),(1,39,'1'),(1,40,'1');

INSERT INTO role_permissions(roles_id,permissions_id,status) VALUES(1,1,'1');

INSERT INTO roles(id,role_name,status,created_at,updated_at) VALUES(1,'administrator','1','2020-02-25 05:09:20','2020-02-25 05:09:20'),(2,'staff','1','2020-02-25 05:09:20','2020-02-25 05:09:20');



INSERT INTO salary_benefits(id,employee_id,component_id,benefit_value,benefit_key,created_by,updated_by,deleted_at,created_at,updated_at) VALUES('29d72230-618e-4d42-ba58-c7182f316c6f','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','2057f330-c532-4e3d-83f6-75a35e8987d7',X'6534374e44736446666d326a4a656237716d63762b753672677a32457934566a61376e54504c5a316c4871497848736648364342754f74475075675745634533346f70356e74583956544a716f4567785962456e53433047384b7051796e4c387945445a7479537931726b36422b4a397a304a6a2b642b32664a3552375471494e657a536b556942366f6f3576477166724c37715453534d6934554d715052384e687437766567455933716b4d492b4f35597a46592b652f4e5836454f784f4b3832684b3841526d48766d4b666f48374d77684b7756327a6b6a785a6f79665343354d4c3959302b4e59614a4634364b33656131644150304b352b6b51636e32595833597a5a332b5355794e385867544a3368462b774f4b317465414a734c50534b426852384a566c753842504c573772473952753873754a647852496f624c776c68546c7857632f42427a70736743326535456f612f7a7442712b464b5a744530706753754433534e2b4e4634566f324c637961762b742f62786e50616c466d775542654a6a73533447654e586b6d456333733664746a482b4a7a77466b45396378334534636b317761354c74625a4d6c6c482f494b727a66654231693677562f71596437697276536366346f5556684d6f79692f69456c512b2f415a36714242374b6352764c72427856567343756b4742667232684e77663241684a594a4c396b3036544b53342f6579416e474148447354584a764f7845523874577a794841596f7879487a6165324931714f4d79324f68646f3365625a5472305556467a5747336b3473714e4e527372613469412f6a4c307559314d7248395254526c68544f45335a366a4f62626d496b4b626365352b30574d5069323641783443545a3370356367343754472b75476a736f5172723261354c6370346f764f6a64617a654367704750777953346a4e7a67314f4467794d7a41324d6a6b354d7a6b794d3251304d47466a5a4745314f4755334f54466c4f444d784d4445304d7a6b344d773d3d','7858823062993923d40acda58e791e8310143983','MUHSURYA8701','MUHSURYA8701',NULL,'2020-02-24 21:26:26','2020-02-24 21:26:26');

INSERT INTO salary_components(id,code,name,state,fixed,created_by,updated_by,deleted_at,created_at,updated_at) VALUES('1a0b59a8-4011-45a4-92fe-0db70b555e03','UM','UANG MAKAN','p',0,NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('2057f330-c532-4e3d-83f6-75a35e8987d7','GP','GAJI POKOK','p',1,NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('70db20e4-6b61-44a3-8e1d-3bf522333603','PL','POTONGAN LAIN-LAIN','m',0,NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('9610b621-18a4-4266-a529-fff4f94faba3','JPP','TUNJANGAN BPJS JP','p',1,NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('9a2a334d-9402-4adb-9943-7d4a119587ac','PPH21P','TUNJANGAN PAJAK PPH21','p',1,NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('9a8a09c5-4664-4aae-9c8e-b64d6853e565','JPM','POTONGAN BPJS JP','m',1,NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('a2d63fe2-9378-4e76-ac5a-03cceefe99f3','PPH21M','POTONGAN PAJAK PPH21','m',1,NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('b72fdefd-9028-401f-845e-fdd323028095','JHTC','TUNJANGAN BPJS JTH PERUSAHAAN','p',1,NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('b96a9aec-c603-4e35-b901-cedbaf429b5e','JKK','TUNJANGAN BPJS JKK PERUSAHAAN','p',1,NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('ce32964f-b3eb-421b-9bf9-46276c875fec','JHTM','POTONGAN BPJS JTH','m',1,NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('d16575fa-0147-4d18-b041-83791923cd56','JHTP','TUNJANGAN BPJS JTH','p',1,NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('d6f420df-966a-4295-b585-33ac940b4460','JKM','TUNJANGAN BPJS JKM PERUSAHAAN','p',1,NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('d800c34d-5dda-474c-b846-70ea8c92fd06','JPC','TUNJANGAN BPJS JP PERUSAHAAN','p',1,NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('e5e31cd3-3871-47a3-b67d-4294fc77adf8','UT','UANG TRANSPORT','p',0,NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('ef92cbcf-0c5b-4263-a3a9-93aa0954b9a5','OT','TUNJANGAN LEMBUR','p',0,NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39'),('f5565431-750b-4fbd-8df9-430cc5bc4098','TJ','TUNJANGAN JABATAN','p',1,NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39');

INSERT INTO salary_group_details(id,component_id,salary_group_id,component_value,created_by,updated_by,deleted_at,created_at,updated_at) VALUES('08d18c28-8821-45b1-89f9-d153b97c0794','2057f330-c532-4e3d-83f6-75a35e8987d7','c1028cc5-df63-4899-9f4f-c25d10b9fff7',X'34353030303030',NULL,NULL,NULL,'2020-02-29 10:55:32','2020-02-29 10:55:32'),('584aa1c1-6f0b-40f5-b042-50481e6ce3d0','1a0b59a8-4011-45a4-92fe-0db70b555e03','c1028cc5-df63-4899-9f4f-c25d10b9fff7',X'333030303030',NULL,NULL,NULL,'2020-02-29 10:50:31','2020-02-29 10:50:31'),('f3395619-321f-434d-b8e0-a79acd24d7e5','1a0b59a8-4011-45a4-92fe-0db70b555e03','e81cb3ad-023f-419a-ad19-4d44cb425203',X'343530303030',NULL,NULL,NULL,'2020-02-29 11:25:24','2020-02-29 11:25:24');

INSERT INTO salary_groups(id,code,name,created_by,updated_by,deleted_at,created_at,updated_at) VALUES('c1028cc5-df63-4899-9f4f-c25d10b9fff7','P2WJC','Gaji karyawan kontrak',NULL,NULL,NULL,'2020-02-29 09:10:24','2020-02-29 09:10:24'),('e81cb3ad-023f-419a-ad19-4d44cb425203','P1WJC','Gaji staff WJC',NULL,NULL,NULL,'2020-02-29 09:10:07','2020-02-29 09:10:07');


INSERT INTO shiftment_groups(id,code,company_id,shiftment_id,name,created_by,updated_by,deleted_at,created_at,updated_at) VALUES('6115a8fd-71fc-48ae-a55b-0801a84c48ed','SSIS1','075e4ead-c356-4c79-abe6-acfb15c70edb','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff','SSI Shift 1',NULL,NULL,NULL,'2020-02-29 20:27:07','2020-02-29 20:27:07'),('aa278317-7893-4b6b-b8a7-35dcd855195a','SSINS','075e4ead-c356-4c79-abe6-acfb15c70edb','c46dd870-a977-4940-83a7-d28963e770d8','Bebas shift',NULL,NULL,NULL,'2020-02-29 20:26:34','2020-02-29 20:26:34'),('bb554ec2-c8e7-4919-ae15-860f478e6b9a','SSI2','075e4ead-c356-4c79-abe6-acfb15c70edb','6b7c0fca-b816-4cfa-96c9-dc1fc3c97c65','SSI Shift 2',NULL,NULL,NULL,'2020-02-29 20:27:32','2020-02-29 20:27:32');

INSERT INTO shiftments(id,code,name,start_hour,end_hour,created_by,updated_by,deleted_at,created_at,updated_at) VALUES('22df3495-a573-46f8-93e4-60e852463b84','SHF3','Shift 3','23:00:00','07:00:00',NULL,NULL,NULL,'2020-02-27 11:00:51','2020-02-27 11:00:51'),('242a1e0c-fdef-4cad-9842-e1b590fa7a11','SHFL','Libur','00:00:00','00:00:00',NULL,NULL,NULL,'2020-03-02 13:10:43','2020-03-02 13:10:43'),('6b7c0fca-b816-4cfa-96c9-dc1fc3c97c65','SHF2','Shift 2','15:00:00','23:00:00',NULL,NULL,NULL,'2020-02-27 11:00:22','2020-02-27 11:00:22'),('8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff','SHF1','Shift 1','07:00:00','15:00:00',NULL,NULL,NULL,'2020-02-27 10:59:45','2020-02-27 10:59:45'),('c46dd870-a977-4940-83a7-d28963e770d8','NSFT','NON SHIFT','08:00:00','17:00:00',NULL,NULL,NULL,'2020-02-24 21:23:39','2020-02-24 21:23:39');





INSERT INTO user_roles(user_id,role_id) VALUES(1,1);

INSERT INTO users(id,username,email,password,password_salt,status,created_at,updated_at) VALUES(1,'admin','admin@admin.co.id','7718fbf17f5631e3dfd073f5524e1006','a849a6143ecd2981da2e92700ce18095e5623fcf','1','2020-02-25 05:09:19','2020-02-25 05:29:15');
INSERT INTO workshifts(id,employee_id,shiftment_id,description,work_date,created_by,updated_by,deleted_at,created_at,updated_at) VALUES('016ec3b6-0030-4154-b924-d86c382e1c1e','8a231d41-a5a7-4945-8cd7-df3bf89c3081','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-02',NULL,NULL,NULL,'2020-03-02 15:52:40','2020-03-02 15:52:40'),('0b8752e5-e871-4132-b399-bac5bfa1d5c5','8a231d41-a5a7-4945-8cd7-df3bf89c3081','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-25',NULL,NULL,NULL,'2020-03-02 15:52:43','2020-03-02 15:52:43'),('0d942cb3-2acf-469b-bbaa-9e1dd3102213','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','6b7c0fca-b816-4cfa-96c9-dc1fc3c97c65',NULL,'2019-08-24',NULL,NULL,NULL,'2020-03-02 15:52:39','2020-03-02 15:52:39'),('0e28f772-9f4d-49ad-bd41-eb8715b1bee2','8a231d41-a5a7-4945-8cd7-df3bf89c3081','242a1e0c-fdef-4cad-9842-e1b590fa7a11',NULL,'2019-08-12',NULL,NULL,NULL,'2020-03-02 15:52:41','2020-03-02 15:52:41'),('14cf612f-f78c-4b2a-8422-9f6500d59fde','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','242a1e0c-fdef-4cad-9842-e1b590fa7a11',NULL,'2019-08-01',NULL,NULL,NULL,'2020-03-02 15:52:36','2020-03-02 15:52:36'),('16c885ab-abd2-4999-a725-ad330c11b646','8a231d41-a5a7-4945-8cd7-df3bf89c3081','242a1e0c-fdef-4cad-9842-e1b590fa7a11',NULL,'2019-08-19',NULL,NULL,NULL,'2020-03-02 15:52:42','2020-03-02 15:52:42'),('1c2d4ba8-48c2-45d9-a73e-29ed61ed4d00','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-13',NULL,NULL,NULL,'2020-03-02 15:52:38','2020-03-02 15:52:38'),('1c340fec-e8e6-4331-be13-a00977b9f6b9','8a231d41-a5a7-4945-8cd7-df3bf89c3081','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-16',NULL,NULL,NULL,'2020-03-02 15:52:42','2020-03-02 15:52:42'),('1e9bc08f-3471-495b-a292-e698affa1ac1','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','6b7c0fca-b816-4cfa-96c9-dc1fc3c97c65',NULL,'2019-08-21',NULL,NULL,NULL,'2020-03-02 15:52:39','2020-03-02 15:52:39'),('20d25012-f10b-432c-a812-6a86be006b01','8a231d41-a5a7-4945-8cd7-df3bf89c3081','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-14',NULL,NULL,NULL,'2020-03-02 15:52:41','2020-03-02 15:52:41'),('20d6cd18-1f03-4649-a6f6-dbb296737ed4','8a231d41-a5a7-4945-8cd7-df3bf89c3081','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-24',NULL,NULL,NULL,'2020-03-02 15:52:43','2020-03-02 15:52:43'),('22981c24-913c-45d1-80b3-146c245f261c','8a231d41-a5a7-4945-8cd7-df3bf89c3081','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-08',NULL,NULL,NULL,'2020-03-02 15:52:41','2020-03-02 15:52:41'),('25d274ca-9fe1-4ad6-bff4-e86cc4573141','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-26',NULL,NULL,NULL,'2020-03-02 15:52:39','2020-03-02 15:52:39'),('2624a0cf-39af-49b8-be96-837943968117','8a231d41-a5a7-4945-8cd7-df3bf89c3081','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-07',NULL,NULL,NULL,'2020-03-02 15:52:41','2020-03-02 15:52:41'),('26b91fa1-0f4b-4ad3-87a9-f3b0b04c9637','8a231d41-a5a7-4945-8cd7-df3bf89c3081','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-06',NULL,NULL,NULL,'2020-03-02 15:52:41','2020-03-02 15:52:41'),('2ac01a88-212a-44d0-941c-b25ad9f6f033','8a231d41-a5a7-4945-8cd7-df3bf89c3081','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-17',NULL,NULL,NULL,'2020-03-02 15:52:42','2020-03-02 15:52:42'),('37dafe50-3ea6-4768-9ac9-b223b817ae38','8a231d41-a5a7-4945-8cd7-df3bf89c3081','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-03',NULL,NULL,NULL,'2020-03-02 15:52:40','2020-03-02 15:52:40'),('3f3b9856-723b-4e1a-86a4-9bd63426638b','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','22df3495-a573-46f8-93e4-60e852463b84',NULL,'2019-08-06',NULL,NULL,NULL,'2020-03-02 15:52:37','2020-03-02 15:52:37'),('4060df69-7778-4d33-842f-353df3caa304','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','22df3495-a573-46f8-93e4-60e852463b84',NULL,'2019-08-03',NULL,NULL,NULL,'2020-03-02 15:52:37','2020-03-02 15:52:37'),('4540f2a8-2917-4d29-a8f8-34a58bc035a9','8a231d41-a5a7-4945-8cd7-df3bf89c3081','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-04',NULL,NULL,NULL,'2020-03-02 15:52:40','2020-03-02 15:52:40'),('4fce536b-01aa-461b-9a0f-b114d8ca08ea','8a231d41-a5a7-4945-8cd7-df3bf89c3081','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-01',NULL,NULL,NULL,'2020-03-02 15:52:40','2020-03-02 15:52:40'),('54e93c19-138d-4a12-98ee-ce7b395c3c76','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','242a1e0c-fdef-4cad-9842-e1b590fa7a11',NULL,'2019-08-16',NULL,NULL,NULL,'2020-03-02 15:52:38','2020-03-02 15:52:38'),('583afac0-e527-47ad-bf09-bf21b020cd50','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','22df3495-a573-46f8-93e4-60e852463b84',NULL,'2019-08-18',NULL,NULL,NULL,'2020-03-02 15:52:39','2020-03-02 15:52:39'),('61dca991-cf34-4c9b-8e78-f86fa53b996c','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','6b7c0fca-b816-4cfa-96c9-dc1fc3c97c65',NULL,'2019-08-07',NULL,NULL,NULL,'2020-03-02 15:52:37','2020-03-02 15:52:37'),('6506539f-f359-4ffb-afd3-199c78d2b5f9','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','6b7c0fca-b816-4cfa-96c9-dc1fc3c97c65',NULL,'2019-08-08',NULL,NULL,NULL,'2020-03-02 15:52:38','2020-03-02 15:52:38'),('6e957992-813e-43d8-bcaf-c30e300f3c4d','8a231d41-a5a7-4945-8cd7-df3bf89c3081','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-21',NULL,NULL,NULL,'2020-03-02 15:52:42','2020-03-02 15:52:42'),('7318d97b-1fae-4567-8840-f07d8c263d9c','8a231d41-a5a7-4945-8cd7-df3bf89c3081','242a1e0c-fdef-4cad-9842-e1b590fa7a11',NULL,'2019-08-05',NULL,NULL,NULL,'2020-03-02 15:52:41','2020-03-02 15:52:41'),('744c135e-8f67-4f22-ac07-c7806c4f6319','8a231d41-a5a7-4945-8cd7-df3bf89c3081','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-31',NULL,NULL,NULL,'2020-03-02 15:52:43','2020-03-02 15:52:43'),('7ad64c88-97aa-4ca5-a8c8-c67ed5cdcee2','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','242a1e0c-fdef-4cad-9842-e1b590fa7a11',NULL,'2019-08-15',NULL,NULL,NULL,'2020-03-02 15:52:38','2020-03-02 15:52:38'),('7e5be704-a250-4593-be73-508e45fb417c','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','22df3495-a573-46f8-93e4-60e852463b84',NULL,'2019-08-04',NULL,NULL,NULL,'2020-03-02 15:52:37','2020-03-02 15:52:37'),('802052cb-b67e-4330-a44f-4884c96d5b43','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','22df3495-a573-46f8-93e4-60e852463b84',NULL,'2019-08-30',NULL,NULL,NULL,'2020-03-02 15:52:40','2020-03-02 15:52:40'),('82e40c70-7029-414a-a7a0-29209869e6c0','8a231d41-a5a7-4945-8cd7-df3bf89c3081','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-15',NULL,NULL,NULL,'2020-03-02 15:52:42','2020-03-02 15:52:42'),('834faefb-a532-4905-8dbe-7712d0f4ee6e','8a231d41-a5a7-4945-8cd7-df3bf89c3081','242a1e0c-fdef-4cad-9842-e1b590fa7a11',NULL,'2019-08-26',NULL,NULL,NULL,'2020-03-02 15:52:43','2020-03-02 15:52:43'),('844c0010-a5d7-45dd-96ea-dbdcf3c5e82f','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-28',NULL,NULL,NULL,'2020-03-02 15:52:40','2020-03-02 15:52:40'),('853a61c6-e572-42f1-a563-058dcd51503e','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','6b7c0fca-b816-4cfa-96c9-dc1fc3c97c65',NULL,'2019-08-23',NULL,NULL,NULL,'2020-03-02 15:52:39','2020-03-02 15:52:39'),('8e2db00b-ee9c-4e49-8865-82b4d4586876','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','242a1e0c-fdef-4cad-9842-e1b590fa7a11',NULL,'2019-08-02',NULL,NULL,NULL,'2020-03-02 15:52:36','2020-03-02 15:52:36'),('95a08e0d-5a04-47f5-838a-9f898e14d492','8a231d41-a5a7-4945-8cd7-df3bf89c3081','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-11',NULL,NULL,NULL,'2020-03-02 15:52:41','2020-03-02 15:52:41'),('9e155ff6-dabe-4d3a-9b48-c2f4c9b40fb7','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','6b7c0fca-b816-4cfa-96c9-dc1fc3c97c65',NULL,'2019-08-09',NULL,NULL,NULL,'2020-03-02 15:52:38','2020-03-02 15:52:38'),('a10b6d6b-c6a6-48fc-829d-7c4c3b3edb7e','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','6b7c0fca-b816-4cfa-96c9-dc1fc3c97c65',NULL,'2019-08-10',NULL,NULL,NULL,'2020-03-02 15:52:38','2020-03-02 15:52:38'),('a1d049b4-2ed0-42d0-9ff4-eee127c951a0','8a231d41-a5a7-4945-8cd7-df3bf89c3081','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-30',NULL,NULL,NULL,'2020-03-02 15:52:43','2020-03-02 15:52:43'),('a472ed06-150e-4a3d-9526-b7445ac6f0c1','8a231d41-a5a7-4945-8cd7-df3bf89c3081','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-23',NULL,NULL,NULL,'2020-03-02 15:52:42','2020-03-02 15:52:42'),('b1fd169c-c206-4824-8e5c-25a0d112ea7a','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','22df3495-a573-46f8-93e4-60e852463b84',NULL,'2019-08-31',NULL,NULL,NULL,'2020-03-02 15:52:40','2020-03-02 15:52:40'),('b20e8bbe-9d65-40f3-bc81-8fc90f927c6c','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','6b7c0fca-b816-4cfa-96c9-dc1fc3c97c65',NULL,'2019-08-22',NULL,NULL,NULL,'2020-03-02 15:52:39','2020-03-02 15:52:39'),('b4c09232-0ce2-41c9-9009-e0e1a3f59ad4','8a231d41-a5a7-4945-8cd7-df3bf89c3081','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-22',NULL,NULL,NULL,'2020-03-02 15:52:42','2020-03-02 15:52:42'),('b5dbeba2-5e51-4bd1-8a1f-41969e10a3d5','8a231d41-a5a7-4945-8cd7-df3bf89c3081','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-20',NULL,NULL,NULL,'2020-03-02 15:52:42','2020-03-02 15:52:42'),('b9f612e8-158a-4418-9b80-cb71a60cfd9e','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-25',NULL,NULL,NULL,'2020-03-02 15:52:39','2020-03-02 15:52:39'),('bc46607e-cb96-4fa7-8478-536db2ed13d3','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','22df3495-a573-46f8-93e4-60e852463b84',NULL,'2019-08-20',NULL,NULL,NULL,'2020-03-02 15:52:39','2020-03-02 15:52:39'),('bd3b5887-c1c5-4ebc-87f1-5a085fcd7bdd','8a231d41-a5a7-4945-8cd7-df3bf89c3081','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-18',NULL,NULL,NULL,'2020-03-02 15:52:42','2020-03-02 15:52:42'),('bdb55e9e-ad95-483b-946d-fcc53ccc9262','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','22df3495-a573-46f8-93e4-60e852463b84',NULL,'2019-08-19',NULL,NULL,NULL,'2020-03-02 15:52:39','2020-03-02 15:52:39'),('c1e204be-85b3-466b-9178-4dfb5ad593de','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-11',NULL,NULL,NULL,'2020-03-02 15:52:38','2020-03-02 15:52:38'),('c97ec485-dca5-4c30-9a13-d898ca223d16','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','22df3495-a573-46f8-93e4-60e852463b84',NULL,'2019-08-17',NULL,NULL,NULL,'2020-03-02 15:52:38','2020-03-02 15:52:38'),('ca634290-62f7-4de1-9f64-c57da8536a89','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-14',NULL,NULL,NULL,'2020-03-02 15:52:38','2020-03-02 15:52:38'),('cb2763eb-04c4-424b-96ee-e45494758eb9','8a231d41-a5a7-4945-8cd7-df3bf89c3081','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-29',NULL,NULL,NULL,'2020-03-02 15:52:43','2020-03-02 15:52:43'),('d0bf4fe4-deda-47ac-9b60-d17ccfeb9257','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-27',NULL,NULL,NULL,'2020-03-02 15:52:40','2020-03-02 15:52:40'),('d4bcf18e-246f-4fe7-beb3-201c68a4c015','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-12',NULL,NULL,NULL,'2020-03-02 15:52:38','2020-03-02 15:52:38'),('d5745560-9c21-400d-adf8-3ac541ee6a3d','8a231d41-a5a7-4945-8cd7-df3bf89c3081','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-27',NULL,NULL,NULL,'2020-03-02 15:52:43','2020-03-02 15:52:43'),('d9fdc22b-20e9-41ba-bdf5-4d566b6a230b','8a231d41-a5a7-4945-8cd7-df3bf89c3081','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-10',NULL,NULL,NULL,'2020-03-02 15:52:41','2020-03-02 15:52:41'),('e0d9f421-7491-46af-ad47-dcd4c448714a','8a231d41-a5a7-4945-8cd7-df3bf89c3081','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-28',NULL,NULL,NULL,'2020-03-02 15:52:43','2020-03-02 15:52:43'),('e9e2a2ab-6535-454e-9caf-d7ee024594c6','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','22df3495-a573-46f8-93e4-60e852463b84',NULL,'2019-08-05',NULL,NULL,NULL,'2020-03-02 15:52:37','2020-03-02 15:52:37'),('efd06234-a287-4836-8146-be44aee7f81c','8a231d41-a5a7-4945-8cd7-df3bf89c3081','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-13',NULL,NULL,NULL,'2020-03-02 15:52:41','2020-03-02 15:52:41'),('f696f47c-b6ef-4239-86df-d602ab59bf21','bc73993c-7c94-4b1b-9611-e5ffc8c6da9d','22df3495-a573-46f8-93e4-60e852463b84',NULL,'2019-08-29',NULL,NULL,NULL,'2020-03-02 15:52:40','2020-03-02 15:52:40'),('f9f980d2-eff2-4c0e-aca7-7e2b266ee202','8a231d41-a5a7-4945-8cd7-df3bf89c3081','8f7e70cb-3ede-428c-b7f2-4e5f7d61e4ff',NULL,'2019-08-09',NULL,NULL,NULL,'2020-03-02 15:52:41','2020-03-02 15:52:41');