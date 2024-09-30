-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 29, 2024 at 12:58 PM
-- Server version: 10.11.8-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u611050133_agendamento_cf`
--

-- --------------------------------------------------------

--
-- Table structure for table `agendamentos`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `atendimentos_realizados`
--

CREATE TABLE `atendimentos_realizados` (
  `id` int(11) NOT NULL,
  `id_agendamento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dias_de_atendimento`
--

CREATE TABLE `dias_de_atendimento` (
  `id` int(11) NOT NULL,
  `dia` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dias_de_atendimento`
--

INSERT INTO `dias_de_atendimento` (`id`, `dia`) VALUES
(1, 'Segunda'),
(2, 'Terça'),
(3, 'Quarta'),
(4, 'Quinta'),
(5, 'Sexta');

-- --------------------------------------------------------

--
-- Table structure for table `estado_civil`
--

CREATE TABLE `estado_civil` (
  `id` int(11) NOT NULL,
  `estado_civil` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `estado_civil`
--

INSERT INTO `estado_civil` (`id`, `estado_civil`) VALUES
(1, 'Casado(a)'),
(2, 'Solteiro(a)'),
(3, 'Viuvo(a)'),
(4, 'União Estável'),
(5, 'Divorciado(a)');

-- --------------------------------------------------------

--
-- Table structure for table `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `id_setor` int(11) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(32) DEFAULT NULL,
  `situacao` tinyint(4) DEFAULT 1,
  `turnos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `funcionarios`
--

INSERT INTO `funcionarios` (`id`, `nome`, `id_setor`, `telefone`, `email`, `senha`, `situacao`, `turnos`) VALUES
(1, 'Adm', 1, 'sem telefone', 'user@teste.com.br', 'e10adc3949ba59abbe56e057f20f883e', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `funcionario_horario`
--

CREATE TABLE `funcionario_horario` (
  `id` int(11) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `id_horario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `horarios`
--

CREATE TABLE `horarios` (
  `id` int(11) NOT NULL,
  `horario` time DEFAULT NULL,
  `deletado` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `horario_atendimentos`
--

CREATE TABLE `horario_atendimentos` (
  `id` int(11) NOT NULL,
  `id_horario` int(11) NOT NULL,
  `id_dia` int(11) NOT NULL,
  `atendimentos` int(11) NOT NULL,
  `extras` int(11) NOT NULL,
  `id_funcionario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prontuario`
--

CREATE TABLE `prontuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) DEFAULT NULL,
  `sus` varchar(25) DEFAULT NULL,
  `prontuario` varchar(25) DEFAULT NULL,
  `pai` varchar(150) DEFAULT NULL,
  `mae` varchar(150) DEFAULT NULL,
  `naturalidade` varchar(30) DEFAULT NULL,
  `id_estado_civil` int(11) DEFAULT NULL,
  `id_sexo` int(11) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `profissao` varchar(60) DEFAULT NULL,
  `telefone` varchar(25) DEFAULT NULL,
  `endereco` varchar(200) DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `complemento` varchar(120) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `observacao` text DEFAULT NULL,
  `aberto_por` varchar(120) DEFAULT NULL,
  `data_criacao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `setores`
--

CREATE TABLE `setores` (
  `id` int(11) NOT NULL,
  `setor` varchar(80) DEFAULT NULL,
  `situacao` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setores`
--

INSERT INTO `setores` (`id`, `setor`, `situacao`) VALUES
(1, 'Diretoria', 1),
(2, 'Médico', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sexo`
--

CREATE TABLE `sexo` (
  `id` int(11) NOT NULL,
  `sexo` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sexo`
--

INSERT INTO `sexo` (`id`, `sexo`) VALUES
(1, 'Masculino'),
(2, 'Feminino');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medico_id` (`medico_id`);

--
-- Indexes for table `atendimentos_realizados`
--
ALTER TABLE `atendimentos_realizados`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dias_de_atendimento`
--
ALTER TABLE `dias_de_atendimento`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estado_civil`
--
ALTER TABLE `estado_civil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_setor` (`id_setor`);

--
-- Indexes for table `funcionario_horario`
--
ALTER TABLE `funcionario_horario`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `horario_atendimentos`
--
ALTER TABLE `horario_atendimentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_horario` (`id_horario`),
  ADD KEY `id_funcionario` (`id_funcionario`);

--
-- Indexes for table `prontuario`
--
ALTER TABLE `prontuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_estado_civil` (`id_estado_civil`),
  ADD KEY `id_sexo` (`id_sexo`);

--
-- Indexes for table `setores`
--
ALTER TABLE `setores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sexo`
--
ALTER TABLE `sexo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agendamentos`
--
ALTER TABLE `agendamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `atendimentos_realizados`
--
ALTER TABLE `atendimentos_realizados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dias_de_atendimento`
--
ALTER TABLE `dias_de_atendimento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `estado_civil`
--
ALTER TABLE `estado_civil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `funcionario_horario`
--
ALTER TABLE `funcionario_horario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `horario_atendimentos`
--
ALTER TABLE `horario_atendimentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prontuario`
--
ALTER TABLE `prontuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setores`
--
ALTER TABLE `setores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sexo`
--
ALTER TABLE `sexo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD CONSTRAINT `agendamentos_ibfk_1` FOREIGN KEY (`medico_id`) REFERENCES `funcionarios` (`id`);

--
-- Constraints for table `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD CONSTRAINT `funcionarios_ibfk_1` FOREIGN KEY (`id_setor`) REFERENCES `setores` (`id`);

--
-- Constraints for table `prontuario`
--
ALTER TABLE `prontuario`
  ADD CONSTRAINT `prontuario_ibfk_1` FOREIGN KEY (`id_estado_civil`) REFERENCES `estado_civil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prontuario_ibfk_2` FOREIGN KEY (`id_sexo`) REFERENCES `sexo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
