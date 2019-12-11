-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 11-Dez-2019 às 17:09
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
(4, 1576081381, 23, 32, 'Seu porco, a minha tava descarregada, isso aí era pra ser meu'),
(5, 1576083519, 18, 46, 'Oi, qts anos vc tem?'),
(6, 1576083719, 18, 48, 'Quer fazer uma parceria?'),
(7, 1576083977, 18, 40, 'Meio caro, não acha?'),
(8, 1576084000, 18, 42, 'Dá pra diminuir mais'),
(9, 1576084036, 18, 49, 'Muito barato, posso entrar em contato?'),
(10, 1576084072, 18, 38, 'Gostei do preço, quanto fica o frete?');

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
(1, 'Alma comum', 50),
(2, 'Alma singela', 100),
(3, 'Alma nobre', 150),
(4, 'Alma benevolente', 200),
(5, 'Alma altruísta', 250),
(6, 'Alma heroica', 300),
(7, 'Alma martirizada', 350),
(8, 'Alma imaculada', 400),
(9, 'Alma santa', 450),
(10, 'Alma divina', 500);

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
(24, 'Maria', 8, 50, 20000, 16),
(25, 'Menino da porteira', 9, 15, 6000, 16),
(26, 'Fiel', 2, 100, 8650, 16),
(27, 'Juan Flores', 1, 100, 4000, 21),
(28, 'Black Bart', 1, 90, 3700, 21),
(29, 'Rattlesnake Dick', 1, 100, 4999.9, 21),
(30, 'Lurdes', 1, 70, 3450, 21),
(31, NULL, 1, 100, 3000, 21),
(32, 'Angel Eyes', 1, 100, 4.99, 22),
(33, 'Pecador', 1, 100, 5000, 19),
(35, 'Outro pecador', 1, 100, 5000, 19),
(36, 'Mais outro pecador', 1, 100, 5000, 19),
(37, 'E mais um outro pecador', 1, 100, 5000, 19),
(38, NULL, 2, 10, 700, 24),
(39, NULL, 7, 60, 20600, 24),
(40, NULL, 5, 76, 18600, 24),
(41, 'Alma perdida', 5, 60, 13000, 20),
(42, 'Um rei', 4, 32, 5800, 20),
(43, NULL, 6, 77, 20000, 20),
(44, 'Minha', 10, 30, 14990, 25),
(46, 'Tio Souza', 1, 60, 1000, 17),
(47, 'Tia Clarinha', 2, 50, 9000, 17),
(48, 'Dona Benta', 9, 10, 2100, 17),
(49, 'Tia Berenice', 9, 10, 1300, 17),
(50, 'Tio Sergio', 1, 100, 3670, 17);

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
(3, 1576081414, 22, 4, 'Compra que é seu'),
(4, 1576083804, 17, 6, 'não');

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
(16, 'Padre Carmack', 'pcarmack@gmail.com', 'pcarmack', '94a9a5dcad692a3f4ca1d6b18bb33fd4'),
(17, 'Betânia', 'bebet13@gmail.com', 'bebet13', 'e43675eab8f92ce29f07174977e56fd4'),
(18, 'Sergio Leone', 'sergio_leone@gmail.com', 'sergio_leone0', 'ce66b579553b9f06de9705645323f943'),
(19, 'Salvador da Luz', 'salvador_luz@gmail.com', 'lightsavior', '6f84860eeaafb0a5b72d637080bfa231'),
(20, 'Astorias', 'abyss_walker@gmail.com', 'abysswalker', 'c2803822966e522d13d5abb3b9cc8f53'),
(21, 'Lee Van Cleef', 'lee.vcleef@gmail.com', 'angeleyes', '58b324e353077daa088d634bb9a1d1dd'),
(22, 'Sem Nome', 'man_withnoname@gmail.com', 'blondie', '141d483b02f989a94578e8b2b89cb9e0'),
(23, 'Tuco Benedicto Pac&iacute;fico', 'tucorat@gmail.com', 'therat', '58b324e353077daa088d634bb9a1d1dd'),
(24, 'Andre de Astora', 'a_astora@gmail.com', 'a_astora', 'c2428781706d00727581426181d0b7e6'),
(25, 'Solaire de Astoras', 's_astoras@gmail.com', 's_astoras', '6ee3d2bff78cc5c543a5096822c3df69'),
(26, 'Usuário', 'usuario@email.com', 'usuario', 'e8d95a51f3af4a3b134bf6bb680a213a');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_comentarios`
-- (See below for the actual view)
--
CREATE TABLE `vw_comentarios` (
`codigo` int(11)
,`data` int(11)
,`usuario` varchar(16)
,`id_usuario` int(11)
,`nome` varchar(100)
,`produto` int(11)
,`texto` varchar(256)
);

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
-- Stand-in structure for view `vw_respostas`
-- (See below for the actual view)
--
CREATE TABLE `vw_respostas` (
`codigo` int(11)
,`data` int(11)
,`usuario` varchar(16)
,`id_usuario` int(11)
,`nome` varchar(100)
,`comentario` int(11)
,`texto` varchar(256)
);

-- --------------------------------------------------------

--
-- Structure for view `vw_comentarios`
--
DROP TABLE IF EXISTS `vw_comentarios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_comentarios`  AS  select `c`.`codigo` AS `codigo`,`c`.`data` AS `data`,`u`.`usuario` AS `usuario`,`u`.`codigo` AS `id_usuario`,`u`.`nome` AS `nome`,`c`.`produto` AS `produto`,`c`.`texto` AS `texto` from (`comentarios` `c` join `usuarios` `u` on((`c`.`usuario` = `u`.`codigo`))) order by `c`.`codigo` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_produtos`
--
DROP TABLE IF EXISTS `vw_produtos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_produtos`  AS  select `p`.`codigo` AS `id`,concat_ws(' - ',`p`.`nome`,`n`.`nome`) AS `nome`,`p`.`nivel` AS `nivel`,`p`.`quantia` AS `quantia`,`p`.`preco` AS `preco`,(`n`.`rpm` * `p`.`quantia`) AS `sugerido`,(((`p`.`preco` - (select `sugerido`)) / (select `sugerido`)) * 100) AS `desconto`,`p`.`usuario` AS `id_usuario`,`u`.`nome` AS `usuario` from ((`produtos` `p` join `usuarios` `u`) join `niveis` `n` on(((`p`.`usuario` = `u`.`codigo`) and (`p`.`nivel` = `n`.`codigo`)))) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_respostas`
--
DROP TABLE IF EXISTS `vw_respostas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_respostas`  AS  select `r`.`codigo` AS `codigo`,`r`.`data` AS `data`,`u`.`usuario` AS `usuario`,`u`.`codigo` AS `id_usuario`,`u`.`nome` AS `nome`,`r`.`comentario` AS `comentario`,`r`.`texto` AS `texto` from (`respostas` `r` join `usuarios` `u` on((`r`.`usuario` = `u`.`codigo`))) order by `r`.`codigo` ;

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
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `respostas`
--
ALTER TABLE `respostas`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
