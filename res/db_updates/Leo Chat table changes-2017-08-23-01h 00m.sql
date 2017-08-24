ALTER TABLE `tripchat` CHANGE `id_tripchat` `id_chatmsg` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT;

RENAME TABLE tripchat TO chatmsg;

ALTER TABLE `chatmsg` ADD `sentdate` DATETIME NOT NULL AFTER `message`;