ALTER TABLE `triprecommendation`
ADD COLUMN `location` VARCHAR(100) NULL AFTER `notes`,
ADD COLUMN `start_at` DATE NULL AFTER `location`,
ADD COLUMN `end_at` DATE NULL AFTER `start_at`,
CHANGE COLUMN `cost` `cost` DECIMAL(13,2) NULL DEFAULT '0.00' ;
