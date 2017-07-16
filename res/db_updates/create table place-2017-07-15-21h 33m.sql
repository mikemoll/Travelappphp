-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 16-Jul-2017 às 03:07
-- Versão do servidor: 10.1.10-MariaDB
-- PHP Version: 5.6.19

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
-- Estrutura da tabela `place`
--

DROP TABLE IF EXISTS `place`;
CREATE TABLE `place` (
  `id_place` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `country` varchar(150) NOT NULL,
  `google_place_id` varchar(100) DEFAULT NULL,
  `description` text,
  `photo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `place`
--

INSERT INTO `place` (`id_place`, `name`, `country`, `google_place_id`, `description`, `photo`) VALUES
(1, 'Kauai', 'Hawaii', NULL, ' Hawai&rsquo;i is home to almost continuous volcanic eruptions, which range from gaseous splattering eruptions to a slow flood of magma. Recently Kilauea volcano has expelled more magma than usual, creating spectacular displays of lava lakes, creating several kilometers of new land, and lava overflowing into the Pacific Ocean.\r\n\r\nThe rising lava lake level can be seen from the nearby Jagger Museum at the Hawai&rsquo;i Volcanoes National Park, especially at sunset and night when the lava lake gives off an incandescent glow. The lava lake is at one of the highest levels in recent times, but not quite as high as when it fully overflowed in May 2015, raising the lava lake rim by another 30 feet from cooled lava.\r\n\r\nKilauea volcano has been continuously erupting since 1983 and is one of the most active volcanoes by lava volume and continual eruption. On Kilauea, the HalemaÊ»umaÊ»u Crater and the Pu&rsquo;u O&rsquo;o crater are both erupting simultaneously. The Pu&rsquo;u O&rsquo;o crater recently started flowing into the Pacific Ocean for the first time since 2013 creating spectacular scenes where lava meets comparatively cold ocean water.', 'kauai-hawaii-1200x718.jpg'),
(2, 'Bora Bora', 'French Polynesia', NULL, 'Bora Bora is an island that once was a volcano, which has subsequently subsided and formed a barrier reef. The reef ecosystem allows for pristine clear blue water and reefs limit waves, providing a protected sanctuary.', 'bora-bora-french-polynesia-1200x804.jpg'),
(3, 'Railay', 'Thailand ', NULL, 'Railay, Thailand is a magical place only accessible by boat on a small Thai peninsula . Spend your days rock climbing the limestone cliffs, exploring vast cave systems, or swimming to nearby islands.', 'railay-thailand-1200x832.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `place`
--
ALTER TABLE `place`
  ADD PRIMARY KEY (`id_place`),
  ADD UNIQUE KEY `id_place` (`id_place`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `place`
--
ALTER TABLE `place`
  MODIFY `id_place` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
