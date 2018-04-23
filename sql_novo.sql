CREATE TABLE `g4x1q_usuarios_novo` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `id_joomla` int not null,
  `telefone` varchar(15) DEFAULT NULL,
  `uf` char(2) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `instituicao` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `data_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idUser`),
  FOREIGN KEY (id_joomla) REFERENCES `g4x1q_users` (id)
) 