ALTER TABLE `userinterests`
CHANGE COLUMN `id_usuario` `id_usuario` BIGINT(20) NOT NULL ,
CHANGE COLUMN `id_interests` `id_interests` BIGINT(20) NOT NULL ,
ADD COLUMN `id_userinterests` SERIAL BEFORE `id_usuario`,
DROP PRIMARY KEY,
ADD PRIMARY KEY (`id_userinterests`);

ALTER TABLE `userinterests`
CHANGE COLUMN `id_interests` `id_interest` BIGINT(20) NOT NULL ;

ALTER TABLE `usertravelertype`
CHANGE COLUMN `id_usuario`  `id_usuario` BIGINT(20) NOT NULL ,
CHANGE COLUMN `id_travelertype`   `id_travelertype` BIGINT(20) NOT NULL ,
ADD COLUMN `id_usertravelertype` SERIAL FIRST,
DROP PRIMARY KEY,
ADD PRIMARY KEY (`id_usertravelertype`);
