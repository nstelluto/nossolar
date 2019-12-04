-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 14-Nov-2019 às 20:57
-- Versão do servidor: 5.6.34
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nosso_lar`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentarios`
--

CREATE TABLE `comentarios` (
  `codigo` int(11) NOT NULL,
  `data` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `produto` int(11) NOT NULL,
  `texto` varchar(256) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `comentarios`
--

INSERT INTO `comentarios` (`codigo`, `data`, `usuario`, `produto`, `texto`) VALUES
(1, 1573746497, 2, 1, 'Esse produto é maligno!');

-- --------------------------------------------------------

--
-- Estrutura da tabela `niveis`
--

CREATE TABLE `niveis` (
  `codigo` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `rpm` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `niveis`
--

INSERT INTO `niveis` (`codigo`, `nome`, `rpm`) VALUES
(1, 'Alma de um sujeito comum', 1000);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `codigo` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nivel` int(11) NOT NULL,
  `quantia` float NOT NULL,
  `preco` float NOT NULL,
  `usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`codigo`, `nome`, `nivel`, `quantia`, `preco`, `usuario`) VALUES
(1, NULL, 1, 1, 1000, 1),
(4, 'Meu vizinho', 1, 2, 1500, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `respostas`
--

CREATE TABLE `respostas` (
  `codigo` int(11) NOT NULL,
  `data` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `comentario` int(11) NOT NULL,
  `texto` varchar(256) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `respostas`
--

INSERT INTO `respostas` (`codigo`, `data`, `usuario`, `comentario`, `texto`) VALUES
(3, 1573747054, 1, 1, 'Vai te toma no cu!');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `codigo` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `usuario` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `senha` char(32) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`codigo`, `nome`, `email`, `usuario`, `senha`) VALUES
(1, 'Fulano de Tal', 'fulano@exemplo.com', 'fulano', 'e8d95a51f3af4a3b134bf6bb680a213a'),
(2, 'Ciclano de Tal', 'ciclano@exemplo.com', 'ciclano', 'e8d95a51f3af4a3b134bf6bb680a213a');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_produtos`
-- (See below for the actual view)
--
CREATE TABLE `vw_produtos` (
`id` int(11)
,`nome` varchar(203)
,`nivel` int(11)
,`quantia` float
,`preco` float
,`sugerido` double
,`desconto` double
,`id_usuario` int(11)
,`usuario` varchar(100)
);

-- --------------------------------------------------------

--
-- Structure for view `vw_produtos`
--
DROP TABLE IF EXISTS `vw_produtos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_produtos`  AS  select `p`.`codigo` AS `id`,concat_ws(' - ',`p`.`nome`,`n`.`nome`) AS `nome`,`p`.`nivel` AS `nivel`,`p`.`quantia` AS `quantia`,`p`.`preco` AS `preco`,(`n`.`rpm` * `p`.`quantia`) AS `sugerido`,(((`p`.`preco` - (select `sugerido`)) / (select `sugerido`)) * 100) AS `desconto`,`p`.`usuario` AS `id_usuario`,`u`.`nome` AS `usuario` from ((`produtos` `p` join `usuarios` `u`) join `niveis` `n` on(((`p`.`usuario` = `u`.`codigo`) and (`p`.`nivel` = `n`.`codigo`)))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `produto` (`produto`),
  ADD KEY `usuario` (`usuario`);

--
-- Indexes for table `niveis`
--
ALTER TABLE `niveis`
  ADD PRIMARY KEY (`codigo`);

--
-- Indexes for table `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `usuario` (`usuario`),
  ADD KEY `nivel` (`nivel`);

--
-- Indexes for table `respostas`
--
ALTER TABLE `respostas`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `comentario` (`comentario`),
  ADD KEY `usuario` (`usuario`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`codigo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `respostas`
--
ALTER TABLE `respostas`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`produto`) REFERENCES `produtos` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `produtos_ibfk_2` FOREIGN KEY (`nivel`) REFERENCES `niveis` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `respostas`
--
ALTER TABLE `respostas`
  ADD CONSTRAINT `respostas_ibfk_1` FOREIGN KEY (`comentario`) REFERENCES `comentarios` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `respostas_ibfk_2` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
