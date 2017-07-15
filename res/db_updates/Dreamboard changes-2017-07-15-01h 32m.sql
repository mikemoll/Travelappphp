ALTER TABLE `dreamplace` ADD `id_activity` BIGINT NULL AFTER `country`, ADD `id_event` BIGINT NULL AFTER `id_activity`;

ALTER TABLE `dreamboard` ADD `place_id` VARCHAR(100) NULL AFTER `id_event`;

RENAME TABLE `dreamplace` TO `dreamboard`;

ALTER TABLE `dreamboard` ADD `created_at` DATETIME NOT NULL AFTER `id_event`;
ALTER TABLE `dreamboard` CHANGE `id_dreamplace` `id_dreamboard` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT;
