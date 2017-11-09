CREATE TABLE `users` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(100) NOT NULL UNIQUE,
	`password` VARCHAR(100) NOT NULL,
	`balance` FLOAT NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
);

CREATE TABLE `companies` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL,
	`stock_price` FLOAT NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `transactions` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`user_id` INT NOT NULL,
	`company_id` INT NOT NULL,
	`qty` INT NOT NULL,
	`total_amount` INT NOT NULL,
	PRIMARY KEY (`id`)
);

ALTER TABLE `transactions` ADD CONSTRAINT `transactions_fk0` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`);

ALTER TABLE `transactions` ADD CONSTRAINT `transactions_fk1` FOREIGN KEY (`company_id`) REFERENCES `companies`(`id`);

