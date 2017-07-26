CREATE TABLE `triptask` ( `id_triptask` SERIAL NOT NULL , `id_trip` BIGINT NOT NULL , `description` VARCHAR(200)  NOT NULL , `id_responsable` BIGINT NOT NULL , `duedate` DATE NULL , `id_type` BIGINT NULL , PRIMARY KEY (`id_triptask`)) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_bin;

 