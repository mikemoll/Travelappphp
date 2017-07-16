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
ADD COLUMN `stayingaddress` VARCHAR(100) NULL AFTER `country`;

ALTER TABLE `tripcity` 
ADD COLUMN `transportationinfo` VARCHAR(100) NULL AFTER `stayingaddress`;

ALTER TABLE `tripcity` 
DROP COLUMN `country`,
DROP COLUMN `city`,
ADD COLUMN `placename` VARCHAR(100) NULL AFTER `transportationinfo`;
