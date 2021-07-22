-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 21-Jul-2021 às 22:10
-- Versão do servidor: 10.4.19-MariaDB
-- versão do PHP: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `agendamento_cardoso_fontes`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `agendamentos`
--

CREATE TABLE `agendamentos` (
  `id` int(11) NOT NULL,
  `paciente` varchar(120) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `prontuario` varchar(10) DEFAULT NULL,
  `sus` varchar(18) DEFAULT NULL,
  `horario` int(11) NOT NULL,
  `dia` date NOT NULL,
  `agendado_por` varchar(90) DEFAULT NULL,
  `extra` tinyint(4) DEFAULT NULL,
  `atendimento_realizado` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `agendamentos`
--

INSERT INTO `agendamentos` (`id`, `paciente`, `medico_id`, `prontuario`, `sus`, `horario`, `dia`, `agendado_por`, `extra`, `atendimento_realizado`) VALUES
(1, 'teste paciente', 4, '32.165', '321 6549 8732 1654', 1, '2021-06-18', '1', 0, 1),
(2, 'teste paciente 2', 4, '32.165', '123 4567 8965 4654', 1, '2021-06-18', '1', 0, 1),
(3, 'chico lino de souza', 4, '32.165', '123 4567 8987 8121', 1, '2021-07-19', '1', 0, 1),
(4, 'jordan michael', 6, '32.165', '321 6546 5496 8798', 1, '2021-07-19', '1', 0, 1),
(5, 'lucas da silva', 5, '12.456', '132 1321 3213 2132', 1, '2021-07-19', '1', 0, 1),
(6, 'pedro da silva sauro', 5, '12.345', '321 3213 2132 1321', 1, '2021-07-19', '1', 0, 1),
(7, 'julio cesar de souza', 5, '32.165', '321 3213 2132 1321', 1, '2021-07-19', '1', 0, 1),
(8, 'lucio fulano de tal', 5, '32.021', '321 6546 5463 2313', 1, '2021-07-19', '1', 0, 1),
(9, 'fuklano de tal', 7, '232.323', '321 3213 2132 1321', 1, '2021-07-29', '1', 0, 1),
(10, 'srfgehb', 5, '32.132', '321 3213 2132 1321', 1, '2021-07-19', '1', 0, 0),
(11, 'çkhgljgvluhgvlj', 5, '32.322', '321 3213 2132 1321', 1, '2021-07-19', '1', 0, 0),
(12, 'aerhetjh', 5, '321.321', '321 3213 2132 1321', 1, '2021-07-19', '1', 0, 0),
(13, 'dsrjhdrsdyj', 5, '32.122', '321 3213 2132 1321', 1, '2021-07-19', '1', 0, 0),
(14, 'sthrtjyjyjyjytjyj', 5, '32.212', '321 3213 2132 1321', 1, '2021-07-19', '1', 0, 0),
(15, 'srtjjyrjkyhjkytkjty', 5, '32.233', '321 3213 2132 1321', 1, '2021-07-19', '1', 0, 0),
(16, 'srtyjyrjyhtdgjkttyktuk', 5, '21.212', '321 3213 2123 2132', 1, '2021-07-19', '1', 0, 0),
(17, 'sthrthyjytjstyjktyk', 5, '32.323', '321 3213 2132 1321', 1, '2021-07-19', '1', 0, 0),
(18, 'srtjyrjtydjktyjtyjktyk', 5, '32.123', '321 3213 2132 1321', 1, '2021-07-19', '1', 1, 0),
(19, 'alice fulana de tal', 6, '32.212', '321 3213 2132 1321', 1, '2021-07-20', '1', 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `atendimentos_realizados`
--

CREATE TABLE `atendimentos_realizados` (
  `id` int(11) NOT NULL,
  `id_agendamento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `atendimentos_realizados`
--

INSERT INTO `atendimentos_realizados` (`id`, `id_agendamento`) VALUES
(1, 7),
(2, 8),
(3, 9);

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `id_setor` int(11) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(32) DEFAULT NULL,
  `situacao` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `funcionarios`
--

INSERT INTO `funcionarios` (`id`, `nome`, `id_setor`, `telefone`, `email`, `senha`, `situacao`) VALUES
(1, 'adm', 1, '2345678', 'adm@teste.com.br', 'e10adc3949ba59abbe56e057f20f883e', 1),
(2, 'adm2Teste', 1, '(92)32122-1234', 'adm2@teste.com.br', '80177534a0c99a7e3645b52f2027a48b', 1),
(3, 'adm3', 1, '(92)32165-4698', 'adm3@teste.com.br', '25f9e794323b453885f5181f1b624d0b', 1),
(4, 'teste_medico', 2, '(12)32132-1321', 'medico@teste.com.br', 'e10adc3949ba59abbe56e057f20f883e', 0),
(5, 'Ricardo Graciolli', 2, '(32)16546-5465', 'ricardo@teste.com', 'e10adc3949ba59abbe56e057f20f883e', 1),
(6, 'Ana Paula Germano', 2, '(12)34567-8989', 'anaPaula@teste.com', 'e10adc3949ba59abbe56e057f20f883e', 1),
(7, 'joycenea matsuda', 2, '(12)34565-4654', 'joyce@teste.com', 'e10adc3949ba59abbe56e057f20f883e', 1),
(8, 'joycenea matsuda', 2, '(12)34565-4654', 'joyce@teste.com', 'e10adc3949ba59abbe56e057f20f883e', 0),
(9, 'joycenea matsuda', 2, '(12)34565-4654', 'joyce@teste.com', 'e10adc3949ba59abbe56e057f20f883e', 0),
(10, 'joycenea matsuda', 2, '(12)34565-4654', 'joyce@teste.com', 'e10adc3949ba59abbe56e057f20f883e', 0),
(11, 'joycenea matsuda', 2, '(12)34565-4654', 'joyce@teste.com', 'e10adc3949ba59abbe56e057f20f883e', 0),
(12, 'joycenea matsuda', 2, '(12)34565-4654', 'joyce@teste.com', 'e10adc3949ba59abbe56e057f20f883e', 0),
(13, 'joycenea matsuda', 2, '(12)34565-4654', 'joyce@teste.com', 'e10adc3949ba59abbe56e057f20f883e', 0),
(14, 'joycenea matsuda', 2, '(12)34565-4654', 'joyce@teste.com', 'e10adc3949ba59abbe56e057f20f883e', 0),
(15, 'joycenea matsuda', 2, '(12)34565-4654', 'joyce@teste.com', 'e10adc3949ba59abbe56e057f20f883e', 0),
(16, 'joycenea matsuda', 2, '(12)34565-4654', 'joyce@teste.com', 'e10adc3949ba59abbe56e057f20f883e', 0),
(17, 'joycenea matsuda', 2, '(12)34565-4654', 'joyce@teste.com', 'e10adc3949ba59abbe56e057f20f883e', 0),
(18, 'joycenea matsuda', 2, '(12)34565-4654', 'joyce@teste.com', 'e10adc3949ba59abbe56e057f20f883e', 0),
(19, 'Nayara Alencar Dias', 2, '(32)13213-2132', 'nayara@teste.com.br', 'e10adc3949ba59abbe56e057f20f883e', 1),
(20, 'pablo douglas', 2, '(32)13213-2132', 'pablo@teste.com', '3d186804534370c3c817db0563f0e461', 1),
(21, 'fulano de tal', 1, '(32)13213-2132', 'zfg@sdh', 'caf1a3dfb505ffed0d024130f58c5cfa', 0),
(22, 'arwgaerhg', 1, '(32)13213-2132', 'kira@ar', 'caf1a3dfb505ffed0d024130f58c5cfa', 0),
(23, 'rgghf', 1, '(32)13213-2132', 'kira@ar', '3d186804534370c3c817db0563f0e461', 1),
(24, 'rgghf', 1, '(32)13213-2132', 'kira@ar', '3d186804534370c3c817db0563f0e461', 1),
(25, 'fulano de tal', 1, '(32)13213-2132', 'gvsf@teste', 'bb2d91d0fbbebe8719509ed0f865c63f', 1),
(26, 'virgulino lampião de souza', 1, '(32)13213-2132', 'lampiao@teste.com', '3d186804534370c3c817db0563f0e461', 1),
(27, 'zgfgheh', 1, '(23)13213-2132', 'gvsf@teste', 'a9460c77655a0853f3cbcbde6a631dc2', 1),
(28, 'asgrawerg', 1, '(32)13213-2132', 'erer@teste', '3d186804534370c3c817db0563f0e461', 1),
(29, 'awergwergrg', 1, '(32)13213-2132', 'aawwedm@teste.com.br', '3d186804534370c3c817db0563f0e461', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionario_horario`
--

CREATE TABLE `funcionario_horario` (
  `id` int(11) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `id_horario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `horarios`
--

CREATE TABLE `horarios` (
  `id` int(11) NOT NULL,
  `horario` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `horarios`
--

INSERT INTO `horarios` (`id`, `horario`) VALUES
(1, '12:00:00'),
(2, '07:30:00'),
(3, '13:35:00'),
(4, '15:00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `horario_atendimentos`
--

CREATE TABLE `horario_atendimentos` (
  `id` int(11) NOT NULL,
  `id_horario` int(11) NOT NULL,
  `atendimentos` int(11) NOT NULL,
  `id_funcionario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `horario_atendimentos`
--

INSERT INTO `horario_atendimentos` (`id`, `id_horario`, `atendimentos`, `id_funcionario`) VALUES
(1, 1, 12, 2),
(2, 1, 12, 3),
(3, 1, 12, 4),
(4, 1, 12, 5),
(5, 1, 12, 6),
(6, 2, 12, 6),
(7, 1, 12, 7),
(8, 1, 12, 8),
(9, 1, 12, 9),
(10, 1, 12, 10),
(11, 1, 12, 11),
(12, 1, 12, 12),
(13, 1, 12, 13),
(14, 1, 12, 14),
(15, 1, 12, 15),
(16, 1, 12, 16),
(17, 1, 12, 17),
(18, 1, 12, 18),
(19, 1, 12, 19),
(20, 1, 12, 20),
(21, 1, 12, 21),
(22, 1, 12, 22),
(23, 1, 12, 23),
(24, 1, 12, 24),
(25, 1, 12, 25),
(26, 1, 12, 26),
(27, 1, 12, 27),
(28, 1, 12, 28),
(29, 1, 12, 29);

-- --------------------------------------------------------

--
-- Estrutura da tabela `setores`
--

CREATE TABLE `setores` (
  `id` int(11) NOT NULL,
  `setor` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `setores`
--

INSERT INTO `setores` (`id`, `setor`) VALUES
(1, 'Diretoria'),
(2, 'Médico');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medico_id` (`medico_id`);

--
-- Índices para tabela `atendimentos_realizados`
--
ALTER TABLE `atendimentos_realizados`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_setor` (`id_setor`);

--
-- Índices para tabela `funcionario_horario`
--
ALTER TABLE `funcionario_horario`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `horario_atendimentos`
--
ALTER TABLE `horario_atendimentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_horario` (`id_horario`),
  ADD KEY `id_funcionario` (`id_funcionario`);

--
-- Índices para tabela `setores`
--
ALTER TABLE `setores`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `atendimentos_realizados`
--
ALTER TABLE `atendimentos_realizados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `funcionario_horario`
--
ALTER TABLE `funcionario_horario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `horario_atendimentos`
--
ALTER TABLE `horario_atendimentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `setores`
--
ALTER TABLE `setores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD CONSTRAINT `agendamentos_ibfk_1` FOREIGN KEY (`medico_id`) REFERENCES `funcionarios` (`id`);

--
-- Limitadores para a tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD CONSTRAINT `funcionarios_ibfk_1` FOREIGN KEY (`id_setor`) REFERENCES `setores` (`id`);

--
-- Limitadores para a tabela `horario_atendimentos`
--
ALTER TABLE `horario_atendimentos`
  ADD CONSTRAINT `horario_atendimentos_ibfk_1` FOREIGN KEY (`id_horario`) REFERENCES `horarios` (`id`),
  ADD CONSTRAINT `horario_atendimentos_ibfk_2` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;