ALTER TABLE `usuario` 
ADD COLUMN `created_at` DATETIME NULL DEFAULT NULL AFTER `fb_id`;

update usuario set created_at = current_timestamp();