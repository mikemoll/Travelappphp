ALTER TABLE `triprecommendation` CHANGE `isfree` `isfree` TINYINT(4) NULL DEFAULT '1', CHANGE `cost` `cost` DECIMAL(13,2) NULL DEFAULT '0.00';