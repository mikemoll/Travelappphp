
CREATE TABLE IF NOT EXISTS `dbupdate` (
  `id_dbupdate` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `updatedon` int(11) NOT NULL,
  UNIQUE KEY `id_dbupdate` (`id_dbupdate`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `dbupdate`
--

INSERT INTO `dbupdate` (`id_dbupdate`, `updatedon`) VALUES
(1, 1499412375);