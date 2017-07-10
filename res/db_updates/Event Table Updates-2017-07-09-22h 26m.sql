ALTER TABLE `event` ADD `public` CHAR(1) NOT NULL AFTER `id_eventtype`;
ALTER TABLE `event` ADD `id_owner` BIGINT NOT NULL AFTER `id_event`;
ALTER TABLE `event` ADD INDEX(`id_owner`);