--
-- Estrutura da tabela `trippackingitem`
--

CREATE TABLE `trippackingitem` (
  `id_trippackingitem` bigint(20) UNSIGNED NOT NULL,
  `id_trip` bigint(20) NOT NULL,
  `description` varchar(200) COLLATE utf8_bin NOT NULL,
  `id_responsable` bigint(20) NOT NULL,
  `duedate` date DEFAULT NULL,
  `id_type` bigint(20) DEFAULT NULL,
  `done` char(1) COLLATE utf8_bin DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `trippackingitem`
--
 
--
-- Indexes for dumped tables
--

--
-- Indexes for table `trippackingitem`
--
ALTER TABLE `trippackingitem`
  ADD PRIMARY KEY (`id_trippackingitem`),
  ADD UNIQUE KEY `id_trippackingitem` (`id_trippackingitem`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `trippackingitem`
--
ALTER TABLE `trippackingitem`
  MODIFY `id_trippackingitem` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;