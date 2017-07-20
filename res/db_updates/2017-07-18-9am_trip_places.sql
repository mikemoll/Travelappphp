ALTER TABLE `tripplace` 
CHANGE COLUMN `id_place` `id_place` BIGINT(20) NOT NULL AFTER `id_trip`; -- ,
-- CHANGE COLUMN `id_tripcity` `id_tripplace` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ;


ALTER TABLE `tripplace` 
CHANGE COLUMN `stayingaddress` `accomodation` VARCHAR(100) NULL DEFAULT NULL ,
ADD COLUMN `accomodationnotsure` ENUM('Y', 'N') NULL AFTER `transportationinfo`,
ADD COLUMN `budget` VARCHAR(100) NULL AFTER `accomodationnotsure`,
ADD COLUMN `budgetnotsure` ENUM('Y', 'N') NULL AFTER `budget`;

ALTER TABLE `tripplace` 
CHANGE COLUMN `transportationinfo` `transportationinfo` ENUM('f', 'b', 'd', 'b', 'w', 't') NULL DEFAULT NULL COMMENT 'Fly - Boat - Drive - Bike - Walk = Train' ;

ALTER TABLE `place` 
CHANGE COLUMN `country` `country` VARCHAR(150) NULL ;

ALTER TABLE `place` 
CHANGE COLUMN `photo` `photo` VARCHAR(200) NULL ;
