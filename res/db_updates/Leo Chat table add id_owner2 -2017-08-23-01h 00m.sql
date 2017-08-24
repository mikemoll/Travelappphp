ALTER TABLE `chatmsg` CHANGE `id_trip` `id_owner` BIGINT(20) UNSIGNED NOT NULL;

ALTER TABLE `chatmsg` ADD `id_owner2` BIGINT UNSIGNED NULL AFTER `id_owner`;