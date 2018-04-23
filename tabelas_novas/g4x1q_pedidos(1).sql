-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Máquina: sql303.epizy.com
-- Data de Criação: 22-Abr-2018 às 22:07
-- Versão do servidor: 5.6.35-81.0
-- versão do PHP: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `epiz_21967505_salao`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `g4x1q_pedidos`
--

CREATE TABLE IF NOT EXISTS `g4x1q_pedidos` (
  `idPedidos` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_insc` int(11) NOT NULL,
  `data_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idPedidos`),
  KEY `id_user` (`id_user`),
  KEY `id_insc` (`id_insc`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=110 ;

--
-- Extraindo dados da tabela `g4x1q_pedidos`
--

INSERT INTO `g4x1q_pedidos` (`idPedidos`, `id_user`, `id_insc`, `data_criacao`) VALUES
(109, 1074, 10, '2018-04-22 22:04:04'),
(108, 1048, 9, '2018-04-22 21:29:18'),
(107, 1073, 18, '2018-04-22 21:27:54'),
(106, 1073, 1, '2018-04-22 21:25:24'),
(105, 1069, 1, '2018-04-22 18:02:18'),
(104, 1069, 10, '2018-04-22 02:23:21');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
