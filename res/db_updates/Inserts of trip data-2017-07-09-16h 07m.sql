
--
-- Extraindo dados da tabela `activity`
--

INSERT INTO `activity` (`id_activity`, `id_activitytype`, `id_currency`, `activityname`, `activitysupply`, `start_at`, `end_at`, `price`, `address`, `city`, `country`, `lat`, `lng`, `geoloc`, `description`, `dresscode`) VALUES
(1, 0, 0, 'Brazil vs France ', NULL, '2017-07-19 00:00:00', '2017-07-12 00:00:00', '0.00', NULL, NULL, NULL, '0.000000', '0.000000', NULL, NULL, NULL),
(2, 1, 0, 'Go to the beach!', NULL, '2017-07-12 00:00:00', '2017-07-27 00:00:00', '2123.23', NULL, NULL, NULL, '0.000000', '0.000000', NULL, NULL, NULL);

--
-- Extraindo dados da tabela `activitytype`
--

INSERT INTO `activitytype` (`id_activitytype`, `activitytypename`) VALUES
(1, 'Hiking');

--
-- Extraindo dados da tabela `trip`
--

INSERT INTO `trip` (`id_trip`, `tripname`, `publicurl`, `description`, `startdate`, `enddate`, `travelmethod`, `inventory`, `notes`, `id_triptype`) VALUES
(5, 'test with users and activities', NULL, NULL, '2017-07-27', '2017-07-31', NULL, NULL, NULL, 0),
(6, 'asdv', NULL, NULL, '2017-07-12', '2017-07-12', NULL, NULL, NULL, 0);

--
-- Extraindo dados da tabela `tripactivity`
--

INSERT INTO `tripactivity` (`id_tripactivity`, `id_trip`, `id_usuario`, `status`, `id_activity`) VALUES
(3, 5, 1, 'c', 1),
(4, 5, 1, 'c', 2);

--
-- Extraindo dados da tabela `tripuser`
--

INSERT INTO `tripuser` (`id_tripuser`, `id_trip`, `id_usuario`, `id_invitation`, `status`, `joined_at`) VALUES
(1, 5, 1, NULL, 'c', '2017-07-09 00:00:00');
