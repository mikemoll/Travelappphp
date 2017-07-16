ALTER TABLE `place` ADD `formatted_address` VARCHAR(150) NULL AFTER `photo`, ADD `rating` DECIMAL(3,1) NULL AFTER `formatted_address`, ADD `googletypes` VARCHAR(500) NULL AFTER `rating`;
 
ALTER TABLE `dreamboard` CHANGE `place_id` `id_place` BIGINT NULL;