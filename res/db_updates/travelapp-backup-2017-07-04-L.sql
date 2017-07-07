/* = USER ============================== */
CREATE TABLE `dreamplace` (
  `id_dreamplace` SERIAL,
  `id_usuario` bigint unsigned NOT NULL,
  `city` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_dreamplace`),
  KEY `fk_dreamplaces_usuario1_idx` (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `interests` (
  `id_interests` SERIAL,
  `description` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_interests`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `travelertype` (
  `id_travelertype` SERIAL,
  `description` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_travelertype`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `usuario` (
/* fields from framework */
  `id_usuario` SERIAL,
  `loginuser` varchar(25) DEFAULT NULL,
  `nomecompleto` varchar(35) DEFAULT NULL,
  `lastname` varchar(35) DEFAULT NULL,
  `senha` varchar(32) DEFAULT NULL,
  `datasenha` date DEFAULT NULL,
  `tipo` varchar(7) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `senhaemail` varchar(50) DEFAULT NULL,
  `assinaturaemail` longtext,
  `smtp` varchar(255) DEFAULT NULL,
  `porta` varchar(3) DEFAULT NULL,
  `grupo` int(11) DEFAULT NULL,
  `ativo` char(1) DEFAULT NULL,
  `excluivel` char(1) DEFAULT NULL,
  `editavel` char(1) DEFAULT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  `idexterno` varchar(15) DEFAULT NULL,
  `dificuldade` varchar(100) DEFAULT NULL,
  `trocasenhatempo` char(1) DEFAULT NULL,
  `paginainicial` varchar(100) DEFAULT NULL,
  `telephone` varchar(25) DEFAULT NULL,
  `Photo` varchar(200) DEFAULT NULL,
  `approved` char(1) DEFAULT 'N',
/* end fields from framework */
  profileurl varchar(255),
  actualcity varchar(50),
  actualcountry varchar(50),
  liveincity varchar(50),
  liveincountry varchar(50),
  birthdate date,
  gender enum('M','F','O'),
  relationship enum('s','m','ir','e','cu','dp','or','ic','s','d','w') comment 'single, married, in a relationship, engaged, in a civil union, in a domestic partnership, in an open relationship, it is complicated, separated, divorced, widowed',
  bio varchar(140),
  instagram varchar(45),
  twitter varchar(45),
  facebook varchar(45),
  occupation varchar(60),
  dreamjob varchar(60),
  calendartype int,
  traveledto varchar(255),
  lastvisitdate date,
  lastvisitlocation varchar(255),
  lastvisittext varchar(255),
  nexttripdate date,
  nexttriplocation varchar(255),
  nexttriptext varchar(255),
  education varchar(100),
  hometowncity varchar(50),
  hometowncountry varchar(50),
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `usuario_loginuser_key` (`loginuser`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;
/* Main photo and cover photo won’t be on database, will be a folder structure based on id_usuario */


CREATE TABLE `userinterests` (
  `id_usuario` bigint unsigned NOT NULL,
  `id_interests` bigint unsigned NOT NULL,
  PRIMARY KEY (`id_usuario`,`id_interests`),
  KEY `fk_userinterests_usuario_idx` (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `usertravelertype` (
  `id_usuario` bigint unsigned NOT NULL,
  `id_travelertype` bigint unsigned NOT NULL,
  PRIMARY KEY (`id_usuario`,`id_travelertype`),
  KEY `fk_usertravelertype_travelertype_idx` (`id_travelertype`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `friend` (
  `id_usuario` bigint unsigned NOT NULL,
  `id_friend` bigint unsigned NOT NULL,
  `asked_at` datetime DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `accepted_at` datetime DEFAULT NULL,

  PRIMARY KEY `fk_friend_usuario1_idx` (`id_usuario`, `id_friend`),
  KEY `fk_friends_usuario2_idx` (`id_friend`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/* =ACTIVITIES======================== */

CREATE TABLE `activitytype` (
  id_activitytype SERIAL,
  activitytypename varchar(30),
  PRIMARY KEY (`id_activitytype`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `currency` (
  `id_currency` SERIAL,
  `symbol` varchar(4) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_currency`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `activity` (
  id_activity SERIAL,
  activityname varchar(45) NOT NULL,
  id_activitytype bigint unsigned NOT NULL,
  activitysupply varchar(500),
  start_at datetime,
  end_at datetime,
  id_currency bigint unsigned,
  price decimal(13,2),
  address varchar(150),
  city varchar(50),
  country varchar(50),
  lat decimal(9,6),
  lng decimal(9,6),
  geoloc point,
  description varchar(500),
  dresscode varchar(150),
  PRIMARY KEY (`id_activity`),
  KEY `fk_activity_activitytype_idx` (`id_activitytype`),
  KEY `fk_activity_currency_idx` (`id_currency`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `invitation` (
  `id_invitation` SERIAL,
  `email` varchar(255) DEFAULT NULL,
  `firstname` varchar(35) DEFAULT NULL,
  `lastname` varchar(35) DEFAULT NULL,
  emailsent_at datetime,
  PRIMARY KEY (`id_invitation`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `activityuser` (
  `id_activityuser` SERIAL,
  `id_activity` bigint unsigned NOT NULL,
  `id_usuario` bigint unsigned, /* null when it is a not registered user */
  `status` enum('i', 'w', 'o', 'c', 'b') NOT NULL comment 'invited(may be not registered), wishlist, owner, confirmed, blocked',
  `id_invitation` bigint unsigned,
  PRIMARY KEY (`id_activityuser`),
  KEY `fk_activityuser_activity_idx` (`id_activity`),
  KEY `fk_activityuser_usuario_idx` (`id_usuario`),
  KEY `fk_activityuser_invitation_idx` (`id_invitation`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


/* =TRIP======================== */

CREATE TABLE `triptype` (
  `id_triptype` SERIAL,
  triptypename varchar(25),
  PRIMARY KEY (`id_triptype`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `trip` (
  `id_trip` SERIAL,
  tripname varchar(30),
  publicurl varchar(50),
  description varchar(500),
  startdate datetime,
  enddate datetime,
  travelmethod varchar(500),
  inventory varchar(500),
  notes varchar(500),
  id_triptype bigint unsigned NOT NULL,
  PRIMARY KEY (`id_trip`),
  KEY `fk_trip_triptype_idx` (id_triptype)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `tripcity` (
  `id_tripcity` SERIAL,
  `id_trip` bigint unsigned NOT NULL,
  startdate datetime,
  enddate datetime,
  city varchar(50),
  country varchar(50),
  PRIMARY KEY (`id_tripcity`),
  KEY `fk_tripcity_trip_idx` (`id_trip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `tripuser` (
  `id_tripuser` SERIAL,
  `id_trip` bigint unsigned NOT NULL,
  `id_usuario` bigint unsigned, /* null when it is a not registered user */
  `id_invitation` bigint unsigned,
  `status` enum('i','w', 'o', 'c', 'b') NOT NULL comment 'invited(not registered), wishlist, owner, confirmed, blocked',
  `joined_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_tripuser`),
  KEY `fk_tripuser_usuario_idx` (`id_usuario`),
  KEY `fk_tripuser_trip_idx` (`id_trip`),
  KEY `fk_tripuser_invitation_idx` (`id_invitation`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `tripbudget` (
  `id_tripbudget` SERIAL,
  `id_trip` bigint unsigned NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  `value` decimal(13,2) DEFAULT NULL,
  `id_currency` bigint unsigned NOT NULL,
  PRIMARY KEY (`id_tripbudget`),
  KEY `fk_tripbudget_trip1_idx` (`id_trip`),
  KEY `fk_tripbudget_currency1_idx` (`id_currency`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `tripactivity` (
  `id_tripactivity` SERIAL,
  `id_trip` bigint unsigned NOT NULL,
  `id_usuario` bigint unsigned NOT NULL comment 'user who suggested',
  `status` enum('s','c') NOT NULL comment 'suggestion (trip wishlist), confirmed',
/* in the future this can have a likes table and count */
  PRIMARY KEY (`id_tripactivity`),
  KEY `fk_tripactivity_trip_idx` (`id_trip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `tripactivitycomment` (
  `id_tripactivitycomment` SERIAL,
  `id_usuario` bigint unsigned NOT NULL,
  `id_trip` bigint unsigned NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_tripactivitycomment`),
  KEY `fk_tripactivitycomment_usuario_idx` (`id_usuario`),
  KEY `fk_tripactivitycomment_trip_idx` (`id_trip`)
 ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `tripchat` (
  `id_tripchat` SERIAL,
  `id_usuario` bigint unsigned NOT NULL,
  `id_trip` bigint unsigned NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_tripchat`),
  KEY `fk_tripchat_usuario1_idx` (`id_usuario`),
  KEY `fk_tripchat_trip1_idx` (`id_trip`)
 ) ENGINE=MyISAM DEFAULT CHARSET=utf8;


/*=EVENT================*/

CREATE TABLE `eventtype` (
  id_eventtype SERIAL,
  description varchar(20) NOT NULL,
  PRIMARY KEY (`id_eventtype`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `event` (
  id_event SERIAL,
  id_eventtype bigint unsigned NOT NULL,
  eventname varchar(30),
  start_at datetime,
  end_at datetime,
  eventsupply varchar(500),
  id_currency bigint unsigned,
  price decimal(13,2),
  address varchar(150),
  city varchar(50),
  country varchar(50),
  lat decimal(9,6),
  lng decimal(9,6),
  geoloc point,
  description varchar(500),
  dresscode varchar(150),
  PRIMARY KEY (`id_event`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `eventuser` (
  `id_eventuser` SERIAL,
  `id_event` bigint unsigned NOT NULL,
  `id_usuario` bigint unsigned,
  `status` enum('i', 'w', 'o', 'c', 'b') NOT NULL comment 'invited(may be not registered), wishlist, owner, confirmed, blocked',
  `id_invitation` bigint unsigned,
  PRIMARY KEY (`id_eventuser`),
  KEY `fk_eventuser_usuario_idx` (`id_usuario`),
  KEY `fk_eventuser_event_idx` (`id_event`),
  KEY `fk_eventuser_invitation_idx` (`id_invitation`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `tripevent` (
  `id_tripevent` SERIAL,
  `id_trip` bigint unsigned NOT NULL,
  `id_usuario` bigint unsigned NOT NULL comment 'user who suggested',
  `status` enum('s','c') NOT NULL comment 'suggestion (trip wishlist), confirmed',
  PRIMARY KEY (`id_tripevent`),
  KEY `fk_tripevent_trip_idx` (`id_trip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


/* = Framework ================== */
CREATE TABLE `config` (
  `id_config` SERIAL,
  `descricao` varchar(100) DEFAULT NULL,
  `trocasenhatempo` char(1) DEFAULT NULL,
  `tempotrocasenha` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_config`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `log` (
  `id_log` SERIAL,
  `descricao` text COLLATE utf8_bin NOT NULL,
  `usuario` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `datahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_owner` bigint unsigned DEFAULT NULL,
  `controller` varchar(100) COLLATE utf8_bin NOT NULL,
  `tipo` int(11) NOT NULL,
  `act` varchar(50) COLLATE utf8_bin NOT NULL,
  `ip` varchar(70) COLLATE utf8_bin NOT NULL,
  `acao` int(11) NOT NULL,
  PRIMARY KEY  (`id_log`),
  KEY `fk_log_usuario1_idx` (`id_owner`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `processo` (
  `id_processo` SERIAL,
  `nome` varchar(60) DEFAULT NULL,
  `descricao` varchar(50) DEFAULT NULL,
  `controladores` varchar(160) DEFAULT NULL,
  PRIMARY KEY (`id_processo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `permissao` (
  `id_permissao` SERIAL,
  `id_processo` bigint unsigned DEFAULT NULL,
  `ver` char(1) DEFAULT NULL,
  `inserir` char(1) DEFAULT NULL,
  `excluir` char(1) DEFAULT NULL,
  `editar` char(1) DEFAULT NULL,
  `id_usuario` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id_permissao`),
  KEY `permissao_id_processo_fkey` (`id_processo`),
  KEY `fk_permissao_usuario_idx` (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO `config` (`id_config`, `descricao`, `trocasenhatempo`, `tempotrocasenha`) VALUES
 (1, 'Troca da Senha', 'S', 360);
 
 INSERT INTO `permissao` (`id_permissao`, `id_processo`, `ver`, `inserir`, `excluir`, `editar`, `id_usuario`) VALUES
 (1, 1, 'S', 'S', 'S', 'S', 1),
 (71, 14, 'S', 'S', NULL, NULL, 4),
 (72, 17, 'S', 'S', NULL, 'S', 3),
 (69, 17, 'S', NULL, NULL, NULL, 4),
 (68, 16, 'S', 'S', 'S', 'S', 2),
 (67, 15, 'S', 'S', NULL, 'S', 3),
 (66, 14, 'S', 'S', 'S', 'S', 3),
 (65, 3, 'S', 'S', 'S', 'S', 3),
 (64, 14, 'S', 'S', 'S', 'S', 2),
 (63, 3, 'S', 'S', 'S', 'S', 2),
 (62, 3, 'S', NULL, NULL, NULL, 34),
 (61, 3, 'S', 'S', 'S', 'S', 33);
 
INSERT INTO `processo` (`id_processo`, `nome`, `descricao`, `controladores`) VALUES
(1, 'ALL', 'Acesso total ao sistema', NULL),
(3, 'PROC_CAD_LaL', 'Lunch and Learn', 'course, bookedcourse, index, usuario'),
(16, 'PROC_CAD_APPROVE_EDU', 'Approve Educators', 'index, usuario, course'),
(15, 'CHANGE_REALDATE', 'Change de Confimed Date', NULL),
(17, 'PROC_CAD_USERS', 'Users Edit', 'usuario'),
(14, 'PROC_CAD_BOOKED', 'Booked Lunch and Learn', 'bookedcourse, index, course, usuario'),
(163, NULL, NULL, NULL);


INSERT INTO `usuario` (`id_usuario`, `loginuser`, `nomecompleto`, `senha`, `datasenha`, `tipo`, `email`, `senhaemail`, `assinaturaemail`, `smtp`, `porta`, `grupo`, `ativo`, `excluivel`, `editavel`, `id_empresa`, `idexterno`, `dificuldade`, `trocasenhatempo`, `paginainicial`, `telephone`, `Photo`, `approved`) VALUES
(1, 'admin', 'Administrador', '28335c822634cc5f5992415058957371', '2016-12-20', 'user', 'admin', NULL, NULL, NULL, NULL, 1, 'S', 'N', 'N', 1, NULL, NULL, 'S', 'index', NULL, NULL, 'S');
