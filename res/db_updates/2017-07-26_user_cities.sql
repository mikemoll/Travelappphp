ALTER TABLE `usuario` 
DROP COLUMN `hometowncountry`,
DROP COLUMN `liveincountry`,
DROP COLUMN `actualcountry`,
CHANGE COLUMN `actualcity` `actualcity` VARCHAR(120) NULL DEFAULT NULL ,
CHANGE COLUMN `liveincity` `liveincity` VARCHAR(120) NULL DEFAULT NULL ,
CHANGE COLUMN `hometowncity` `hometowncity` VARCHAR(120) NULL DEFAULT NULL ;
