ALTER TABLE `trip` 
DROP COLUMN `id_triptype`,
DROP INDEX `fk_trip_triptype_idx` ;

CREATE TABLE `triptriptype` (
  `id_triptriptype`  bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_trip` BIGINT(20) unsigned NOT NULL,
  `id_triptype` BIGINT(20) unsigned NOT NULL,
  PRIMARY KEY (`id_triptriptype`),
  UNIQUE KEY `id_triptriptype_un` (`id_triptriptype`),
  KEY `ix_triptriptype_trip_idx` (`id_trip`),
  KEY `ix_triptriptype_triptype_idx` (`id_triptype`)
)  ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

ALTER TABLE `tripcity`
ADD COLUMN `stayingaddress` VARCHAR(100) NULL;

ALTER TABLE `tripcity`
ADD COLUMN `transportationinfo` VARCHAR(100) NULL;

ALTER TABLE `tripcity`
DROP COLUMN `country`,
DROP COLUMN `city`,
ADD COLUMN `id_place`bigint(20) unsigned NOT NULL AFTER `transportationinfo`;


ALTER TABLE `tripcity`
CHANGE COLUMN `id_trip` `id_trip` BIGINT(20) NOT NULL ,
CHANGE COLUMN `id_place` `id_place` BIGINT(20) NOT NULL ,
ADD INDEX `fk_tripplace_place_idx` (`id_place` ASC), 
RENAME TO  `tripplace` ;
