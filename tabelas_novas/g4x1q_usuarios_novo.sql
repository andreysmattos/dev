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
-- Estrutura da tabela `g4x1q_usuarios_novo`
--

CREATE TABLE IF NOT EXISTS `g4x1q_usuarios_novo` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `id_joomla` int(11) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `uf` char(2) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `instituicao` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `data_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idUser`),
  KEY `id_joomla` (`id_joomla`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Extraindo dados da tabela `g4x1q_usuarios_novo`
--

INSERT INTO `g4x1q_usuarios_novo` (`idUser`, `id_joomla`, `telefone`, `uf`, `cidade`, `bairro`, `endereco`, `instituicao`, `area`, `data_criacao`) VALUES
(7, 1073, 'mario31231@3123', 'RS', 'mario31231@312312mario.com', 'mario31231@312312mario.com', 'mario31231@312312mario.com', 'mario31231@312312mario.com', 'mario31231@312312mario.com', '2018-04-22 21:25:24'),
(6, 1069, '35273111', 'RS', 'dasfsd', 'dasdas', 'xasdas', 'dasdad', 'dasdasdas', '2018-04-22 02:23:21'),
(8, 1048, '35273111', 'RS', 'cidadeendereco', 'bairroendereco', 'agoravaiendereco', 'testeagora', 'agora123', '2018-04-22 21:29:18'),
(9, 1074, '35273111', 'RS', 'teste', 'teste', 'teste', 'teste', 'teste', '2018-04-22 22:04:04');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
