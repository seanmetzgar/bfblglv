CREATE TABLE `renewal_data` (
	`renewal_id` BIGINT(20) NOT NULL AUTO_INCREMENT,
	`wp_user_id` BIGINT(20) NOT NULL,
	`uuid` VARCHAR(36) NOT NULL,
	`amount_owed` FLOAT NOT NULL,
	`renewal_year` INT(10) NOT NULL,
	`renewal_date` DATETIME NULL,
	`email_1_date` DATETIME NULL,
	`email_2_date` DATETIME NULL,
	`email_3_date` DATETIME NULL,
	`email_4_date` DATETIME NULL,
	`paid` BOOLEAN NOT NULL DEFAULT FALSE,
	PRIMARY KEY (`renewal_id`)
) ENGINE = InnoDB;