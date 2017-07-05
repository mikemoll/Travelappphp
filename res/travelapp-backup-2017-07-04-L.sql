-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 05-Jul-2017 às 12:45
-- Versão do servidor: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `travelapp`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `config`
--

CREATE TABLE `config` (
  `id_config` int(11) NOT NULL,
  `descricao` varchar(100) DEFAULT NULL,
  `trocasenhatempo` char(1) DEFAULT NULL,
  `tempotrocasenha` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `config`
--

INSERT INTO `config` (`id_config`, `descricao`, `trocasenhatempo`, `tempotrocasenha`) VALUES
(1, 'Troca da Senha', 'S', 360);

-- --------------------------------------------------------

--
-- Estrutura da tabela `item`
--

CREATE TABLE `item` (
  `id_item` bigint(20) UNSIGNED NOT NULL,
  `categoria` varchar(2) COLLATE utf8_bin NOT NULL,
  `titulo` varchar(100) COLLATE utf8_bin NOT NULL,
  `texto` text COLLATE utf8_bin NOT NULL,
  `datacadastro` date DEFAULT NULL,
  `observacao` text COLLATE utf8_bin,
  `notarodape` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `item`
--

INSERT INTO `item` (`id_item`, `categoria`, `titulo`, `texto`, `datacadastro`, `observacao`, `notarodape`) VALUES
(6, '1', 'Conclusion', '<p>Foram calculadas as verbas constantes das decisÃµes judiciais demonstradas nos anexos.</p>\r\n<table style="margin-left: auto; margin-right: auto;">\r\n<thead>\r\n<tr>\r\n<th>Item</th>\r\n<th>DescriÃ§Ã£o</th>\r\n<th>Valor</th>\r\n</tr>\r\n</thead>\r\n<tbody>\r\n<tr>\r\n<td>1</td>\r\n<td>Total da Verba</td>\r\n<td>R$ 186.828,14</td>\r\n</tr>\r\n<tr>\r\n<td>2</td>\r\n<td>Valor corrigido</td>\r\n<td>R$ 199.009,26</td>\r\n</tr>\r\n<tr>\r\n<td>3</td>\r\n<td>Juros</td>\r\n<td>R$ 85.882,87</td>\r\n</tr>\r\n</tbody>\r\n<tfoot>\r\n<tr>\r\n<td colspan="">VALOR TOTAL (2+3)</td>\r\n<td>R$ 284.892,13</td>\r\n</tr>\r\n</tfoot>\r\n</table>\r\n<p>ReferÃªncia de CÃ¡lculo:</p>\r\n<ul>\r\n<li>Anexo I â€“ Resumo Geral</li>\r\n</ul>', '2016-06-17', NULL, '<p>asdvas</p>');

-- --------------------------------------------------------

--
-- Estrutura da tabela `log`
--

CREATE TABLE `log` (
  `id_log` bigint(20) UNSIGNED NOT NULL,
  `descricao` text COLLATE utf8_bin NOT NULL,
  `usuario` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `datahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_owner` int(11) DEFAULT NULL,
  `controller` varchar(100) COLLATE utf8_bin NOT NULL,
  `tipo` int(11) NOT NULL,
  `act` varchar(50) COLLATE utf8_bin NOT NULL,
  `ip` varchar(70) COLLATE utf8_bin NOT NULL,
  `acao` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissao`
--

CREATE TABLE `permissao` (
  `id_permissao` int(11) NOT NULL,
  `id_processo` int(11) DEFAULT NULL,
  `ver` char(1) DEFAULT NULL,
  `inserir` char(1) DEFAULT NULL,
  `excluir` char(1) DEFAULT NULL,
  `editar` char(1) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

CREATE TABLE `processo` (
  `id_processo` int(11) NOT NULL,
  `nome` varchar(60) DEFAULT NULL,
  `descricao` varchar(50) DEFAULT NULL,
  `controladores` varchar(160) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `loginuser` varchar(25) DEFAULT NULL,
  `nomecompleto` varchar(35) DEFAULT NULL,
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
  `approved` char(1) DEFAULT 'N'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `loginuser`, `nomecompleto`, `senha`, `datasenha`, `tipo`, `email`, `senhaemail`, `assinaturaemail`, `smtp`, `porta`, `grupo`, `ativo`, `excluivel`, `editavel`, `id_empresa`, `idexterno`, `dificuldade`, `trocasenhatempo`, `paginainicial`, `telephone`, `Photo`, `approved`) VALUES
(1, 'admin', 'Administrador', '28335c822634cc5f5992415058957371', '2016-12-20', 'user', 'admin', NULL, NULL, NULL, NULL, 1, 'S', 'N', 'N', 1, NULL, NULL, 'S', 'index', NULL, NULL, 'S');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id_config`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id_item`),
  ADD UNIQUE KEY `id_laudotopico` (`id_item`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD UNIQUE KEY `id_log` (`id_log`);

--
-- Indexes for table `permissao`
--
ALTER TABLE `permissao`
  ADD PRIMARY KEY (`id_permissao`),
  ADD KEY `permissao_id_processo_fkey` (`id_processo`);

--
-- Indexes for table `processo`
--
ALTER TABLE `processo`
  ADD PRIMARY KEY (`id_processo`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `usuario_loginuser_key` (`loginuser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `id_config` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id_item` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id_log` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `permissao`
--
ALTER TABLE `permissao`
  MODIFY `id_permissao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT for table `processo`
--
ALTER TABLE `processo`
  MODIFY `id_processo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
