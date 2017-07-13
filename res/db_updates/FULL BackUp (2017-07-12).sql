
-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 12/07/2017 às 16:19:50
-- Versão do Servidor: 10.1.24-MariaDB
-- Versão do PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `u572069064_trave`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
  `id_activity` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `activityname` varchar(45) NOT NULL,
  `id_activitytype` bigint(20) unsigned NOT NULL,
  `activitysupply` varchar(500) DEFAULT NULL,
  `start_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `id_currency` bigint(20) unsigned DEFAULT NULL,
  `price` decimal(13,2) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `lat` decimal(9,6) DEFAULT NULL,
  `lng` decimal(9,6) DEFAULT NULL,
  `geoloc` point DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `dresscode` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_activity`),
  UNIQUE KEY `id_activity` (`id_activity`),
  KEY `fk_activity_activitytype_idx` (`id_activitytype`),
  KEY `fk_activity_currency_idx` (`id_currency`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `activity`
--

INSERT INTO `activity` (`id_activity`, `activityname`, `id_activitytype`, `activitysupply`, `start_at`, `end_at`, `id_currency`, `price`, `address`, `city`, `country`, `lat`, `lng`, `geoloc`, `description`, `dresscode`) VALUES
(1, 'Brazil vs France ', 0, NULL, '2017-07-19 00:00:00', '2017-07-12 00:00:00', 0, '0.00', NULL, NULL, NULL, '0.000000', '0.000000', NULL, NULL, NULL),
(2, 'Go to the beach!', 1, NULL, '2017-07-12 00:00:00', '2017-07-27 00:00:00', 0, '2123.23', NULL, NULL, NULL, '0.000000', '0.000000', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `activitytype`
--

CREATE TABLE IF NOT EXISTS `activitytype` (
  `id_activitytype` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `activitytypename` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_activitytype`),
  UNIQUE KEY `id_activitytype` (`id_activitytype`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `activitytype`
--

INSERT INTO `activitytype` (`id_activitytype`, `activitytypename`) VALUES
(1, 'Hiking');

-- --------------------------------------------------------

--
-- Estrutura da tabela `activityuser`
--

CREATE TABLE IF NOT EXISTS `activityuser` (
  `id_activityuser` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_activity` bigint(20) unsigned NOT NULL,
  `id_usuario` bigint(20) unsigned DEFAULT NULL,
  `status` enum('i','w','o','c','b') NOT NULL COMMENT 'invited(may be not registered), wishlist, owner, confirmed, blocked',
  `id_invitation` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_activityuser`),
  UNIQUE KEY `id_activityuser` (`id_activityuser`),
  KEY `fk_activityuser_activity_idx` (`id_activity`),
  KEY `fk_activityuser_usuario_idx` (`id_usuario`),
  KEY `fk_activityuser_invitation_idx` (`id_invitation`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id_config` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(100) DEFAULT NULL,
  `trocasenhatempo` char(1) DEFAULT NULL,
  `tempotrocasenha` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_config`),
  UNIQUE KEY `id_config` (`id_config`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `config`
--

INSERT INTO `config` (`id_config`, `descricao`, `trocasenhatempo`, `tempotrocasenha`) VALUES
(1, 'Troca da Senha', 'S', 360);

-- --------------------------------------------------------

--
-- Estrutura da tabela `currency`
--

CREATE TABLE IF NOT EXISTS `currency` (
  `id_currency` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `symbol` varchar(4) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_currency`),
  UNIQUE KEY `id_currency` (`id_currency`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `currency`
--

INSERT INTO `currency` (`id_currency`, `symbol`, `name`) VALUES
(1, 'USD', 'American Dollar'),
(2, 'CAD', 'Canadian Dollar');

-- --------------------------------------------------------

--
-- Estrutura da tabela `dbupdate`
--

CREATE TABLE IF NOT EXISTS `dbupdate` (
  `id_dbupdate` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `updatedon` int(11) NOT NULL,
  UNIQUE KEY `id_dbupdate` (`id_dbupdate`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `dbupdate`
--

INSERT INTO `dbupdate` (`id_dbupdate`, `updatedon`) VALUES
(1, 1499883950);

-- --------------------------------------------------------

--
-- Estrutura da tabela `dreamplace`
--

CREATE TABLE IF NOT EXISTS `dreamplace` (
  `id_dreamplace` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(20) unsigned NOT NULL,
  `city` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_dreamplace`),
  UNIQUE KEY `id_dreamplace` (`id_dreamplace`),
  KEY `fk_dreamplaces_usuario1_idx` (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id_event` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_owner` bigint(20) NOT NULL,
  `id_eventtype` bigint(20) unsigned NOT NULL,
  `public` char(1) NOT NULL,
  `eventname` varchar(30) DEFAULT NULL,
  `start_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `eventsupply` varchar(500) DEFAULT NULL,
  `id_currency` bigint(20) unsigned DEFAULT NULL,
  `price` decimal(13,2) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `lat` decimal(9,6) DEFAULT NULL,
  `lng` decimal(9,6) DEFAULT NULL,
  `geoloc` point DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `dresscode` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_event`),
  UNIQUE KEY `id_event` (`id_event`),
  KEY `id_owner` (`id_owner`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `event`
--

INSERT INTO `event` (`id_event`, `id_owner`, `id_eventtype`, `public`, `eventname`, `start_at`, `end_at`, `eventsupply`, `id_currency`, `price`, `address`, `city`, `country`, `lat`, `lng`, `geoloc`, `description`, `dresscode`) VALUES
(1, 1, 1, 'S', 'Brazil x France ', '2017-07-29 00:00:00', '2017-07-29 00:00:00', NULL, 1, '150.00', NULL, NULL, NULL, '0.000000', '0.000000', NULL, 'Game!', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `eventtype`
--

CREATE TABLE IF NOT EXISTS `eventtype` (
  `id_eventtype` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(20) NOT NULL,
  PRIMARY KEY (`id_eventtype`),
  UNIQUE KEY `id_eventtype` (`id_eventtype`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `eventtype`
--

INSERT INTO `eventtype` (`id_eventtype`, `description`) VALUES
(1, 'Sport');

-- --------------------------------------------------------

--
-- Estrutura da tabela `eventuser`
--

CREATE TABLE IF NOT EXISTS `eventuser` (
  `id_eventuser` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_event` bigint(20) unsigned NOT NULL,
  `id_usuario` bigint(20) unsigned DEFAULT NULL,
  `status` enum('i','w','o','c','b') NOT NULL COMMENT 'invited(may be not registered), wishlist, owner, confirmed, blocked',
  `id_invitation` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_eventuser`),
  UNIQUE KEY `id_eventuser` (`id_eventuser`),
  KEY `fk_eventuser_usuario_idx` (`id_usuario`),
  KEY `fk_eventuser_event_idx` (`id_event`),
  KEY `fk_eventuser_invitation_idx` (`id_invitation`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `eventuser`
--

INSERT INTO `eventuser` (`id_eventuser`, `id_event`, `id_usuario`, `status`, `id_invitation`) VALUES
(1, 1, 1, 'i', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `friend`
--

CREATE TABLE IF NOT EXISTS `friend` (
  `id_usuario` bigint(20) unsigned NOT NULL,
  `id_friend` bigint(20) unsigned NOT NULL,
  `asked_at` datetime DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `accepted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_usuario`,`id_friend`),
  KEY `fk_friends_usuario2_idx` (`id_friend`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `interests`
--

CREATE TABLE IF NOT EXISTS `interests` (
  `id_interests` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_interests`),
  UNIQUE KEY `id_interests` (`id_interests`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `interests`
--

INSERT INTO `interests` (`id_interests`, `description`) VALUES
(1, 'Hiking');

-- --------------------------------------------------------

--
-- Estrutura da tabela `invitation`
--

CREATE TABLE IF NOT EXISTS `invitation` (
  `id_invitation` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `firstname` varchar(35) DEFAULT NULL,
  `lastname` varchar(35) DEFAULT NULL,
  `emailsent_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_invitation`),
  UNIQUE KEY `id_invitation` (`id_invitation`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `id_item` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `categoria` varchar(2) COLLATE utf8_bin NOT NULL,
  `titulo` varchar(100) COLLATE utf8_bin NOT NULL,
  `texto` text COLLATE utf8_bin NOT NULL,
  `datacadastro` date DEFAULT NULL,
  `observacao` text COLLATE utf8_bin,
  `notarodape` text COLLATE utf8_bin,
  PRIMARY KEY (`id_item`),
  UNIQUE KEY `id_laudotopico` (`id_item`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `item`
--

INSERT INTO `item` (`id_item`, `categoria`, `titulo`, `texto`, `datacadastro`, `observacao`, `notarodape`) VALUES
(6, '1', 'Conclusion', '<p>Foram calculadas as verbas constantes das decisÃµes judiciais demonstradas nos anexos.</p>\r\n<table style="margin-left: auto; margin-right: auto;">\r\n<thead>\r\n<tr>\r\n<th>Item</th>\r\n<th>DescriÃ§Ã£o</th>\r\n<th>Valor</th>\r\n</tr>\r\n</thead>\r\n<tbody>\r\n<tr>\r\n<td>1</td>\r\n<td>Total da Verba</td>\r\n<td>R$ 186.828,14</td>\r\n</tr>\r\n<tr>\r\n<td>2</td>\r\n<td>Valor corrigido</td>\r\n<td>R$ 199.009,26</td>\r\n</tr>\r\n<tr>\r\n<td>3</td>\r\n<td>Juros</td>\r\n<td>R$ 85.882,87</td>\r\n</tr>\r\n</tbody>\r\n<tfoot>\r\n<tr>\r\n<td colspan="">VALOR TOTAL (2+3)</td>\r\n<td>R$ 284.892,13</td>\r\n</tr>\r\n</tfoot>\r\n</table>\r\n<p>ReferÃªncia de CÃ¡lculo:</p>\r\n<ul>\r\n<li>Anexo I â€“ Resumo Geral</li>\r\n</ul>', '2016-06-17', NULL, '<p>asdvas</p>');

-- --------------------------------------------------------

--
-- Estrutura da tabela `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id_log` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` text COLLATE utf8_bin NOT NULL,
  `usuario` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `datahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_owner` bigint(20) unsigned DEFAULT NULL,
  `controller` varchar(100) COLLATE utf8_bin NOT NULL,
  `tipo` int(11) NOT NULL,
  `act` varchar(50) COLLATE utf8_bin NOT NULL,
  `ip` varchar(70) COLLATE utf8_bin NOT NULL,
  `acao` int(11) NOT NULL,
  PRIMARY KEY (`id_log`),
  UNIQUE KEY `id_log` (`id_log`),
  KEY `fk_log_usuario1_idx` (`id_owner`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissao`
--

CREATE TABLE IF NOT EXISTS `permissao` (
  `id_permissao` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_processo` bigint(20) unsigned DEFAULT NULL,
  `ver` char(1) DEFAULT NULL,
  `inserir` char(1) DEFAULT NULL,
  `excluir` char(1) DEFAULT NULL,
  `editar` char(1) DEFAULT NULL,
  `id_usuario` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_permissao`),
  UNIQUE KEY `id_permissao` (`id_permissao`),
  KEY `permissao_id_processo_fkey` (`id_processo`),
  KEY `fk_permissao_usuario_idx` (`id_usuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=73 ;

--
-- Extraindo dados da tabela `permissao`
--

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

-- --------------------------------------------------------

--
-- Estrutura da tabela `processo`
--

CREATE TABLE IF NOT EXISTS `processo` (
  `id_processo` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) DEFAULT NULL,
  `descricao` varchar(50) DEFAULT NULL,
  `controladores` varchar(160) DEFAULT NULL,
  PRIMARY KEY (`id_processo`),
  UNIQUE KEY `id_processo` (`id_processo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=164 ;

--
-- Extraindo dados da tabela `processo`
--

INSERT INTO `processo` (`id_processo`, `nome`, `descricao`, `controladores`) VALUES
(1, 'ALL', 'Acesso total ao sistema', NULL),
(3, 'PROC_CAD_LaL', 'Lunch and Learn', 'course, bookedcourse, index, usuario'),
(16, 'PROC_CAD_APPROVE_EDU', 'Approve Educators', 'index, usuario, course'),
(15, 'CHANGE_REALDATE', 'Change de Confimed Date', NULL),
(17, 'PROC_CAD_USERS', 'Users Edit', 'usuario'),
(14, 'PROC_CAD_BOOKED', 'Booked Lunch and Learn', 'bookedcourse, index, course, usuario'),
(163, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `travelertype`
--

CREATE TABLE IF NOT EXISTS `travelertype` (
  `id_travelertype` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_travelertype`),
  UNIQUE KEY `id_travelertype` (`id_travelertype`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `trip`
--

CREATE TABLE IF NOT EXISTS `trip` (
  `id_trip` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tripname` varchar(30) DEFAULT NULL,
  `publicurl` varchar(50) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `startdate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `travelmethod` varchar(500) DEFAULT NULL,
  `inventory` varchar(500) DEFAULT NULL,
  `notes` varchar(500) DEFAULT NULL,
  `id_triptype` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id_trip`),
  UNIQUE KEY `id_trip` (`id_trip`),
  KEY `fk_trip_triptype_idx` (`id_triptype`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `trip`
--

INSERT INTO `trip` (`id_trip`, `tripname`, `publicurl`, `description`, `startdate`, `enddate`, `travelmethod`, `inventory`, `notes`, `id_triptype`) VALUES
(5, 'test with users and activities', NULL, NULL, '2017-07-27', '2017-07-31', NULL, NULL, NULL, 0),
(6, 'asdv', NULL, NULL, '2017-07-12', '2017-07-12', NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tripactivity`
--

CREATE TABLE IF NOT EXISTS `tripactivity` (
  `id_tripactivity` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_trip` bigint(20) unsigned NOT NULL,
  `id_usuario` bigint(20) unsigned NOT NULL COMMENT 'user who suggested',
  `status` enum('s','c') NOT NULL COMMENT 'suggestion (trip wishlist), confirmed',
  `id_activity` bigint(20) NOT NULL,
  PRIMARY KEY (`id_tripactivity`),
  UNIQUE KEY `id_tripactivity` (`id_tripactivity`),
  KEY `fk_tripactivity_trip_idx` (`id_trip`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `tripactivity`
--

INSERT INTO `tripactivity` (`id_tripactivity`, `id_trip`, `id_usuario`, `status`, `id_activity`) VALUES
(3, 5, 1, 'c', 1),
(4, 5, 1, 'c', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tripactivitycomment`
--

CREATE TABLE IF NOT EXISTS `tripactivitycomment` (
  `id_tripactivitycomment` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(20) unsigned NOT NULL,
  `id_trip` bigint(20) unsigned NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_tripactivitycomment`),
  UNIQUE KEY `id_tripactivitycomment` (`id_tripactivitycomment`),
  KEY `fk_tripactivitycomment_usuario_idx` (`id_usuario`),
  KEY `fk_tripactivitycomment_trip_idx` (`id_trip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tripbudget`
--

CREATE TABLE IF NOT EXISTS `tripbudget` (
  `id_tripbudget` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_trip` bigint(20) unsigned NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  `value` decimal(13,2) DEFAULT NULL,
  `id_currency` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id_tripbudget`),
  UNIQUE KEY `id_tripbudget` (`id_tripbudget`),
  KEY `fk_tripbudget_trip1_idx` (`id_trip`),
  KEY `fk_tripbudget_currency1_idx` (`id_currency`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tripchat`
--

CREATE TABLE IF NOT EXISTS `tripchat` (
  `id_tripchat` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(20) unsigned NOT NULL,
  `id_trip` bigint(20) unsigned NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_tripchat`),
  UNIQUE KEY `id_tripchat` (`id_tripchat`),
  KEY `fk_tripchat_usuario1_idx` (`id_usuario`),
  KEY `fk_tripchat_trip1_idx` (`id_trip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tripcity`
--

CREATE TABLE IF NOT EXISTS `tripcity` (
  `id_tripcity` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_trip` bigint(20) unsigned NOT NULL,
  `startdate` datetime DEFAULT NULL,
  `enddate` datetime DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_tripcity`),
  UNIQUE KEY `id_tripcity` (`id_tripcity`),
  KEY `fk_tripcity_trip_idx` (`id_trip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tripevent`
--

CREATE TABLE IF NOT EXISTS `tripevent` (
  `id_tripevent` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_trip` bigint(20) unsigned NOT NULL,
  `id_usuario` bigint(20) unsigned NOT NULL COMMENT 'user who suggested',
  `status` enum('s','c') NOT NULL COMMENT 'suggestion (trip wishlist), confirmed',
  PRIMARY KEY (`id_tripevent`),
  UNIQUE KEY `id_tripevent` (`id_tripevent`),
  KEY `fk_tripevent_trip_idx` (`id_trip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `triptype`
--

CREATE TABLE IF NOT EXISTS `triptype` (
  `id_triptype` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `triptypename` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id_triptype`),
  UNIQUE KEY `id_triptype` (`id_triptype`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `triptype`
--

INSERT INTO `triptype` (`id_triptype`, `triptypename`) VALUES
(1, 'Fun');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tripuser`
--

CREATE TABLE IF NOT EXISTS `tripuser` (
  `id_tripuser` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_trip` bigint(20) unsigned NOT NULL,
  `id_usuario` bigint(20) unsigned DEFAULT NULL,
  `id_invitation` bigint(20) unsigned DEFAULT NULL,
  `status` enum('i','w','o','c','b') NOT NULL COMMENT 'invited(not registered), wishlist, owner, confirmed, blocked',
  `joined_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_tripuser`),
  UNIQUE KEY `id_tripuser` (`id_tripuser`),
  KEY `fk_tripuser_usuario_idx` (`id_usuario`),
  KEY `fk_tripuser_trip_idx` (`id_trip`),
  KEY `fk_tripuser_invitation_idx` (`id_invitation`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `tripuser`
--

INSERT INTO `tripuser` (`id_tripuser`, `id_trip`, `id_usuario`, `id_invitation`, `status`, `joined_at`) VALUES
(1, 5, 1, NULL, 'c', '2017-07-09 00:00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `userinterests`
--

CREATE TABLE IF NOT EXISTS `userinterests` (
  `id_usuario` bigint(20) NOT NULL,
  `id_interest` bigint(20) NOT NULL,
  `id_userinterests` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_userinterests`),
  UNIQUE KEY `id_userinterests` (`id_userinterests`),
  KEY `fk_userinterests_usuario_idx` (`id_usuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `userinterests`
--

INSERT INTO `userinterests` (`id_usuario`, `id_interest`, `id_userinterests`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usertravelertype`
--

CREATE TABLE IF NOT EXISTS `usertravelertype` (
  `id_usertravelertype` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(20) NOT NULL,
  `id_travelertype` bigint(20) NOT NULL,
  PRIMARY KEY (`id_usertravelertype`),
  UNIQUE KEY `id_usertravelertype` (`id_usertravelertype`),
  KEY `fk_usertravelertype_travelertype_idx` (`id_travelertype`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
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
  `profileurl` varchar(255) DEFAULT NULL,
  `actualcity` varchar(50) DEFAULT NULL,
  `actualcountry` varchar(50) DEFAULT NULL,
  `liveincity` varchar(50) DEFAULT NULL,
  `liveincountry` varchar(50) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` enum('M','F','O') DEFAULT NULL,
  `relationship` enum('s','m','ir','e','cu','dp','or','ic','sp','d','w') DEFAULT NULL COMMENT 'single, married, in a relationship, engaged, in a civil union, in a domestic partnership, in an open relationship, it is complicated, separated, divorced, widowed',
  `bio` varchar(140) DEFAULT NULL,
  `instagram` varchar(45) DEFAULT NULL,
  `twitter` varchar(45) DEFAULT NULL,
  `facebook` varchar(45) DEFAULT NULL,
  `occupation` varchar(60) DEFAULT NULL,
  `dreamjob` varchar(60) DEFAULT NULL,
  `calendartype` int(11) DEFAULT NULL,
  `traveledto` varchar(255) DEFAULT NULL,
  `education` varchar(100) DEFAULT NULL,
  `hometowncity` varchar(50) DEFAULT NULL,
  `hometowncountry` varchar(50) DEFAULT NULL,
  `confirmurl` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `id_usuario` (`id_usuario`),
  UNIQUE KEY `usuario_loginuser_key` (`loginuser`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `loginuser`, `nomecompleto`, `lastname`, `senha`, `datasenha`, `tipo`, `email`, `senhaemail`, `assinaturaemail`, `smtp`, `porta`, `grupo`, `ativo`, `excluivel`, `editavel`, `id_empresa`, `idexterno`, `dificuldade`, `trocasenhatempo`, `paginainicial`, `telephone`, `Photo`, `approved`, `profileurl`, `actualcity`, `actualcountry`, `liveincity`, `liveincountry`, `birthdate`, `gender`, `relationship`, `bio`, `instagram`, `twitter`, `facebook`, `occupation`, `dreamjob`, `calendartype`, `traveledto`, `education`, `hometowncity`, `hometowncountry`, `confirmurl`) VALUES
(1, 'admin', 'Admin', 'The', '28335c822634cc5f5992415058957371', '2017-12-07', 'user', 'admin@admin.com', NULL, NULL, NULL, NULL, 1, 'S', 'N', 'N', 1, NULL, NULL, 'S', 'index', NULL, 'Dubai, United Arab Emirates.jpg', 'S', NULL, NULL, NULL, NULL, NULL, '2017-07-04', 'M', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 'Leonardo.danieli@gmail.co', 'Leonardo', NULL, '44e51526be3c22d83f09ab86050d03c2', NULL, NULL, 'leonardo.danieli@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, 'S', 'S', NULL, NULL, 'null', NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
