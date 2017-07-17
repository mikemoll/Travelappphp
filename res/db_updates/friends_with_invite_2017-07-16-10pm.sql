truncate table friend;

ALTER TABLE `friend` 
CHANGE COLUMN `id_friend` `id_friend` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT FIRST,
CHANGE COLUMN `email` `email` VARCHAR(255) NULL DEFAULT NULL ,
ADD COLUMN `id_usuario_friend` BIGINT(20) UNSIGNED NULL DEFAULT NULL AFTER `id_usuario`,
ADD COLUMN `name` VARCHAR(35) NULL AFTER `accepted_at`,
DROP PRIMARY KEY,
ADD PRIMARY KEY (`id_friend`);

ALTER TABLE `tripuser` 
DROP COLUMN `id_invitation`,
DROP INDEX `fk_tripuser_invitation_idx` ;
