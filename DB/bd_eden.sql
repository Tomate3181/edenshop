-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24-Nov-2025 às 16:12
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bd_eden`
--
CREATE DATABASE IF NOT EXISTS `bd_eden` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bd_eden`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `carrinho`
--

CREATE TABLE `carrinho` (
  `id_carrinho` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nome_categoria` varchar(50) NOT NULL,
  `desc_categoria` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nome_categoria`, `desc_categoria`) VALUES
(1, 'Suculentas', 'Plantas que armazenam água em suas folhas, caules ou raízes. Ideais para ambientes internos e pouca rega.'),
(2, 'Samambaias', 'Plantas tropicais que preferem sombra e alta umidade. Perfeitas para banheiros e varandas sombreadas.'),
(3, 'Plantas de Sombra', 'Espécies que prosperam em locais com pouca luz solar direta, como interiores de casas e escritórios.'),
(4, 'Plantas de Sol Pleno', 'Espécies que necessitam de pelo menos 6 horas de sol direto por dia. Ideais para jardins e varandas ensolaradas.'),
(5, 'Plantas Pendentes', 'Plantas com crescimento para baixo, ótimas para vasos suspensos e prateleiras.'),
(6, 'Frutíferas (Pequeno Porte)', 'Árvores frutíferas que podem ser cultivadas em vasos ou pequenos jardins, como jabuticabeiras e pitangueiras.'),
(7, 'Flores e Ornamentais', 'Plantas cultivadas por suas flores coloridas e folhagens decorativas.');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cuidados`
--

CREATE TABLE `cuidados` (
  `id_cuidados` int(11) NOT NULL,
  `id_planta` int(11) NOT NULL,
  `luz` text NOT NULL,
  `agua` text NOT NULL,
  `humidade` text NOT NULL,
  `solo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `cuidados`
--

INSERT INTO `cuidados` (`id_cuidados`, `id_planta`, `luz`, `agua`, `humidade`, `solo`) VALUES
(1, 1, 'Sol pleno ou luz brilhante (mínimo 4h de sol)', 'Rega espaçada. Deixar o solo secar completamente entre as regas.', 'Baixa', 'Substrato para cactos e suculentas (muito drenável).'),
(2, 2, 'Luz brilhante. Aceita algumas horas de sol direto.', 'Rega espaçada. Deixar o solo secar antes de regar novamente.', 'Baixa', 'Solo drenável.'),
(3, 3, 'Luz brilhante, mas sem sol direto forte (queima as folhas).', 'Rega moderada no verão, reduzida no inverno. Deixar secar.', 'Baixa a média', 'Substrato para suculentas.'),
(4, 4, 'Luz filtrada ou meia-sombra. Evitar sol direto.', 'Rega frequente. O solo deve ser mantido úmido, mas não encharcado.', 'Alta. Borrifar água nas folhas ajuda.', 'Rico em matéria orgânica, leve e drenável.'),
(5, 5, 'Luz filtrada brilhante.', 'Rega por imersão ou borrifação no substrato (não nas folhas). Gosta de secar levemente.', 'Alta', 'Substrato para epífitas (fibra de coco, musgo).'),
(6, 6, 'Luz filtrada ou meia-sombra.', 'Rega regular. Manter o solo úmido.', 'Alta', 'Rico em matéria orgânica.'),
(7, 7, 'Tolera pouca luz, mas prefere luz filtrada brilhante.', 'Rega muito espaçada. Deixar o solo secar completamente. Resistente à seca.', 'Baixa', 'Solo leve e bem drenável.'),
(8, 8, 'Tolera pouca luz, mas cresce melhor com luz filtrada.', 'Rega muito espaçada. Deixar o solo secar completamente.', 'Baixa', 'Solo drenável e fértil.'),
(9, 9, 'Luz filtrada ou meia-sombra. Floresce mais com mais luz.', 'Rega frequente. Gosta de solo úmido. As folhas \"murcham\" quando precisa de água.', 'Média a alta. Borrifar folhas.', 'Rico em matéria orgânica.'),
(10, 10, 'Sol pleno (mínimo 6 horas por dia).', 'Rega espaçada. É uma planta de deserto, deixar secar completamente.', 'Baixa', 'Substrato para cactos (muito arenoso e drenável).'),
(11, 11, 'Sol pleno ou luz brilhante.', 'Rega espaçada. Muito resistente à seca.', 'Baixa', 'Solo bem drenável.'),
(12, 12, 'Sol pleno ou luz brilhante.', 'Rega muito espaçada. Quase nenhuma água no inverno.', 'Baixa', 'Substrato para cactos.'),
(13, 13, 'Luz filtrada brilhante. Tolera pouca luz, mas cresce menos.', 'Rega moderada. Deixar a camada superficial do solo secar.', 'Média. Gosta de umidade.', 'Solo fértil e drenável.'),
(14, 14, 'Luz filtrada. Pode pegar sol fraco da manhã.', 'Rega regular. Manter o solo levemente úmido.', 'Média. Gosta de umidade.', 'Solo fértil e drenável.'),
(15, 15, 'Luz brilhante, com algumas horas de sol direto (fraco).', 'Rega cuidadosa. Deixar o solo secar, pois as \"pérolas\" apodrecem fácil.', 'Baixa', 'Substrato para suculentas.'),
(16, 16, 'Sol pleno.', 'Rega frequente, especialmente durante a produção de frutos. Manter o solo úmido.', 'Média', 'Solo fértil e bem drenado.'),
(17, 17, 'Sol pleno.', 'Rega regular. Gosta de solo úmido.', 'Média', 'Solo fértil e drenável.'),
(18, 18, 'Sol pleno (mínimo 6 horas).', 'Rega regular, sem encharcar. Deixar a camada superficial secar.', 'Média', 'Solo fértil e bem drenado.'),
(19, 19, 'Luz filtrada brilhante (luz de janela, sem sol direto).', 'Rega moderada. Regar o substrato (não as folhas) quando estiver quase seco.', 'Alta', 'Substrato para orquídeas (casca de pinus, carvão).'),
(20, 20, 'Luz filtrada ou meia-sombra.', 'Rega regular. Manter o solo úmido, mas não encharcado.', 'Alta', 'Solo rico em matéria orgânica e bem drenável.'),
(21, 21, 'Luz filtrada brilhante.', 'Rega regular. Manter o solo úmido. Evitar molhar as folhas.', 'Alta', 'Solo leve e fértil (base de turfa).'),
(22, 22, 'Luz brilhante, com algumas horas de sol direto.', 'Rega espaçada. Deixar o solo secar completamente.', 'Baixa', 'Substrato para cactos e suculentas.'),
(23, 23, 'Sol pleno ou meia-sombra. Fica rosada com mais sol.', 'Rega espaçada. Deixar o solo secar.', 'Baixa', 'Solo leve e bem drenável.'),
(24, 24, 'Luz filtrada brilhante. Sem sol direto.', 'Rega moderada. Deixar a camada superficial do solo secar. Borrifar os rizomas.', 'Alta', 'Substrato poroso (fibra de coco, musgo).'),
(25, 25, 'Luz filtrada ou meia-sombra.', 'Rega frequente. Manter o solo sempre levemente úmido.', 'Alta', 'Rico em matéria orgânica.'),
(26, 26, 'Luz filtrada brilhante. Não tolera sol direto.', 'Rega regular. Manter o solo úmido, mas não encharcado. Usar água filtrada.', 'Alta. Essencial borrifar.', 'Solo fértil e drenável.'),
(27, 27, 'Luz filtrada brilhante. Pode tolerar meia-sombra.', 'Rega moderada a frequente. Deixar a camada superficial do solo secar.', 'Média a alta.', 'Substrato rico e aerado (com fibra de coco).'),
(28, 28, 'Sol pleno (mínimo 6 horas).', 'Rega moderada. Gosta de solo mais para seco. Regar a base, não as folhas.', 'Baixa. Não gosta de umidade.', 'Solo arenoso ou pedregoso, bem drenável.'),
(29, 29, 'Meia-sombra ou luz filtrada. Tolera sol da manhã.', 'Rega moderada. Deixar a camada superficial do solo secar.', 'Média. Borrifar as folhas ajuda.', 'Solo fértil e bem drenável.'),
(30, 30, 'Luz filtrada brilhante. Sem sol direto.', 'Rega moderada. Deixar o solo secar parcialmente entre as regas.', 'Média a alta.', 'Solo leve e fértil.'),
(31, 31, 'Luz brilhante, pode pegar sol fraco da manhã ou fim de tarde.', 'Rega espaçada. Armazena água nas raízes (batatinhas). Deixar o solo secar.', 'Baixa a média', 'Substrato para suculentas.'),
(32, 32, 'Sol pleno.', 'Rega regular, especialmente na frutificação. Manter o solo úmido.', 'Média', 'Solo fértil, bem drenado e ligeiramente ácido.'),
(33, 33, 'Sol pleno (mínimo 6 horas).', 'Rega frequente. Gosta de solo úmido para produzir bem.', 'Média', 'Solo fértil e bem drenado.'),
(34, 34, 'Luz filtrada brilhante (perto de janela, sem sol direto).', 'Rega cuidadosa na base. Manter o solo levemente úmido. Não molhar as folhas.', 'Média a alta.', 'Substrato específico para violetas (leve).'),
(35, 35, 'Luz filtrada brilhante.', 'Rega no \"copo\" central da planta, mantendo-o com água limpa. Regar o solo ocasionalmente.', 'Alta', 'Substrato para epífitas (casca de pinus).'),
(36, 36, 'Luz brilhante, com sol fraco da manhã ou fim de tarde.', 'Deixar o solo secar completamente entre as regas.', 'Baixa', 'Solo drenável (substrato para suculentas).'),
(37, 37, 'Luz brilhante, sem sol direto (queima as folhas).', 'Rega espaçada. Deixar o solo secar completamente.', 'Baixa', 'Solo muito drenável (arenoso).'),
(38, 38, 'Sol pleno ou meia-sombra.', 'Rega moderada no verão, quase nula no inverno. Deixar secar.', 'Baixa', 'Substrato para cactos (bem drenável).'),
(39, 39, 'Meia-sombra ou luz filtrada. Sem sol direto.', 'Rega frequente. Manter o solo sempre úmido, mas não encharcado.', 'Altíssima. Exige borrifação.', 'Rico em matéria orgânica.'),
(40, 40, 'Meia-sombra ou luz filtrada brilhante.', 'Rega moderada. Deixar a camada superficial do solo secar.', 'Alta', 'Solo leve e drenável.'),
(41, 41, 'Meia-sombra ou luz filtrada. Proteger do sol direto.', 'Rega regular. Manter o solo úmido. Usar água filtrada ou de chuva.', 'Alta. Borrifar folhas diariamente.', 'Rico em matéria orgânica.'),
(42, 42, 'Luz filtrada brilhante ou meia-sombra.', 'Rega moderada. Deixar a camada superficial do solo secar.', 'Média', 'Solo leve e bem drenável.'),
(43, 43, 'Luz filtrada brilhante. Tolera meia-sombra.', 'Rega moderada. Deixar o solo secar superficialmente.', 'Média a alta.', 'Solo fértil e drenável.'),
(44, 44, 'Meia-sombra. Luz direta queima as folhas.', 'Rega moderada. Gosta de solo levemente úmido.', 'Alta. Borrifar as folhas.', 'Solo rico e bem drenável.'),
(45, 45, 'Sol pleno ou luz brilhante (mínimo 4h). Luz é essencial para a cor.', 'Rega regular. Manter o solo úmido, mas não encharcado.', 'Média a alta.', 'Solo fértil e bem drenável.'),
(46, 46, 'Sol pleno (mínimo 4-6 horas).', 'Rega regular. Gosta de solo úmido.', 'Média', 'Solo fértil e ligeiramente ácido.'),
(47, 47, 'Sol pleno ou meia-sombra.', 'Rega regular, principalmente após a poda. Tolera curtos períodos de seca.', 'Média', 'Solo fértil e bem drenável.'),
(48, 48, 'Sol pleno ou luz brilhante. Muito resistente.', 'Rega espaçada. Deixar o solo secar bem entre as regas.', 'Baixa. Tolera ar seco.', 'Solo arenoso e bem drenável.'),
(49, 49, 'Meia-sombra ou luz filtrada. Sol forte queima as folhas.', 'Rega frequente. Manter o solo levemente úmido.', 'Média', 'Solo fértil e drenável.'),
(50, 50, 'Luz brilhante, com algumas horas de sol fraco.', 'Rega cuidadosa. Deixar o solo secar bem, pois armazena água.', 'Baixa', 'Substrato para suculentas.'),
(51, 51, 'Meia-sombra ou luz filtrada. Sol direto desbota as folhas.', 'Rega regular. Manter o solo úmido.', 'Média', 'Solo fértil e drenável.'),
(52, 52, 'Sol pleno.', 'Rega regular. Manter o solo úmido, mas sem encharcar.', 'Média', 'Solo fértil e bem drenado.'),
(53, 53, 'Sol pleno (mínimo 4 horas).', 'Rega regular. Gosta de solo levemente úmido.', 'Média a baixa', 'Solo drenável e fértil.'),
(54, 54, 'Sol pleno ou meia-sombra (sol da manhã).', 'Rega frequente. Não tolera seca. Manter solo úmido.', 'Média', 'Solo ácido (comprado pronto ou com adição de turfa).'),
(55, 55, 'Luz filtrada ou meia-sombra. Sem sol direto.', 'Rega regular. Manter o solo úmido.', 'Alta', 'Substrato leve e aerado.'),
(56, 56, 'Sol pleno ou meia-sombra (sol forte intensifica a cor vermelha).', 'Rega no \"copo\" central e no solo. Evitar encharcamento.', 'Média', 'Solo drenável (substrato para bromélias).'),
(57, 57, 'Meia-sombra (sol fraco da manhã). Proteger do sol forte.', 'Rega frequente. Manter o solo úmido.', 'Média', 'Solo ácido e bem drenável.'),
(58, 58, 'Meia-sombra (sol da manhã).', 'Rega regular. Manter o solo úmido. Usar água sem cloro.', 'Alta', 'Solo ácido, fértil e bem drenável.'),
(59, 59, 'Meia-sombra. Proteger do sol forte e do vento.', 'Rega regular. Manter o solo úmido.', 'Média', 'Solo ácido e bem drenável.'),
(60, 60, 'Luz brilhante (sem sol direto forte).', 'Rega frequente. Manter o solo sempre levemente úmido.', 'Média', 'Solo fértil e bem drenável.'),
(61, 61, 'Sol pleno ou luz brilhante. Fica rosada no sol.', 'Rega muito espaçada. Deixar secar completamente. Apodrece fácil.', 'Baixa', 'Substrato para suculentas (muito drenável).'),
(62, 62, 'Sol pleno ou luz brilhante.', 'Rega espaçada. Deixar o solo secar.', 'Baixa', 'Solo arenoso e drenável.'),
(63, 63, 'Luz brilhante, pode pegar sol fraco da manhã.', 'Rega espaçada. Deixar o solo secar completamente.', 'Baixa', 'Solo arenoso e bem drenável.'),
(64, 64, 'Luz brilhante ou sol fraco. Sol intenso pode queimar a penugem.', 'Rega espaçada. Deixar o solo secar.', 'Baixa', 'Substrato para suculentas.'),
(65, 65, 'Sol pleno ou luz brilhante.', 'Rega moderada no verão, nula no inverno. Deixar secar.', 'Baixa', 'Substrato para cactos.'),
(66, 66, 'Meia-sombra ou luz filtrada.', 'Rega regular. Manter o solo levemente úmido.', 'Alta', 'Solo rico em matéria orgânica.'),
(67, 67, 'Meia-sombra. Luz indireta abundante.', 'Rega frequente. Manter o solo úmido, mas não encharcado. Não molhar as folhas.', 'Altíssima. Exige umidade.', 'Solo leve e drenável.'),
(68, 68, 'Meia-sombra ou luz filtrada.', 'Rega frequente. Manter o solo úmido.', 'Alta', 'Solo rico em matéria orgânica.'),
(69, 69, 'Meia-sombra ou luz filtrada.', 'Rega moderada. Gosta que o substrato seque levemente.', 'Alta', 'Substrato para epífitas (fibra de coco).'),
(70, 70, 'Meia-sombra ou luz filtrada. Sol direto queima as folhas.', 'Rega moderada. Deixar a camada superficial do solo secar.', 'Média a alta.', 'Solo fértil e drenável.'),
(71, 71, 'Meia-sombra. Luz indireta é ideal.', 'Rega frequente. Manter o solo úmido. Murcha rápido se seca.', 'Altíssima. Ideal para terrários.', 'Solo rico em matéria orgânica.'),
(72, 72, 'Luz filtrada ou meia-sombra. Tolera pouca luz.', 'Rega espaçada. Deixar o solo secar superficialmente.', 'Média.', 'Solo leve e bem drenável.'),
(73, 73, 'Meia-sombra ou sombra. Tolera muito bem pouca luz.', 'Rega moderada. Deixar secar superficialmente.', 'Média. Gosta de umidade.', 'Solo fértil e drenável.'),
(74, 74, 'Meia-sombra ou luz filtrada. Perfeita para interiores.', 'Rega moderada. Deixar secar superficialmente.', 'Média.', 'Solo leve e bem drenável.'),
(75, 75, 'Luz filtrada brilhante. Sem sol direto.', 'Rega exigente. Manter o solo úmido. Usar água filtrada.', 'Altíssima.', 'Solo rico em matéria orgânica.'),
(76, 76, 'Sol pleno ou luz muito brilhante.', 'Rega espaçada. Deixar o solo secar entre as regas.', 'Média a baixa.', 'Solo arenoso e muito drenável.'),
(77, 77, 'Sol pleno ou luz muito brilhante. Gira em direção ao sol.', 'Rega espaçada. Armazena água no tronco. Deixar secar.', 'Baixa. Tolera ar seco.', 'Solo drenável.'),
(78, 78, 'Sol pleno (mínimo 6 horas).', 'Rega espaçada. Deixar o solo secar. Não gosta de solo úmido.', 'Baixa.', 'Solo arenoso e alcalino.'),
(79, 79, 'Sol pleno (mínimo 6 horas).', 'Rega frequente. Gosta de solo úmido, mas não encharcado.', 'Média.', 'Solo fértil e drenável.'),
(80, 80, 'Sol pleno ou luz muito brilhante. Precisa de luz para florir.', 'Rega moderada. Deixar secar superficialmente.', 'Média.', 'Solo fértil e bem drenável.'),
(81, 81, 'Sol pleno (o dia todo). Essencial para florir.', 'Rega regular após o solo secar. Tolera seca leve.', 'Baixa.', 'Solo fértil e bem drenável.'),
(82, 82, 'Luz filtrada brilhante. Sol fraco da manhã intensifica o rosa.', 'Rega moderada. Deixar o solo secar superficialmente.', 'Média.', 'Solo leve e drenável.'),
(83, 83, 'Luz filtrada brilhante. Tolera meia-sombra.', 'Rega moderada. Deixar a camada superficial do solo secar.', 'Média.', 'Solo fértil e drenável.'),
(84, 84, 'Luz filtrada brilhante.', 'Rega espaçada. Deixar o substrato secar bem.', 'Média.', 'Substrato para epífitas (casca de pinus).'),
(85, 85, 'Luz filtrada brilhante. Sol fraco estimula floração.', 'Rega espaçada. Deixar o solo secar completamente.', 'Média.', 'Solo leve e drenável.'),
(86, 86, 'Luz filtrada brilhante. Precisa de claridade para florir.', 'Rega moderada. Deixar o solo secar superficialmente.', 'Alta.', 'Solo leve e drenável.'),
(87, 87, 'Luz filtrada brilhante. Tolera meia-sombra.', 'Rega moderada. Deixar a camada superficial do solo secar.', 'Média.', 'Solo fértil e drenável.'),
(88, 88, 'Sol pleno.', 'Rega regular. Manter o solo úmido, especialmente na frutificação.', 'Média.', 'Solo fértil e bem drenado.'),
(89, 89, 'Sol pleno.', 'Rega regular. Manter o solo úmido.', 'Média.', 'Solo fértil e bem drenado.'),
(90, 90, 'Sol pleno (mínimo 6 horas).', 'Rega frequente. Manter o solo sempre úmido.', 'Média.', 'Solo fértil, leve e drenável.'),
(91, 91, 'Sol pleno.', 'Rega frequente. Necessita de solo úmido.', 'Média.', 'Solo fértil e drenável.'),
(92, 92, 'Sol pleno (mínimo 4 horas).', 'Rega regular. Manter o solo levemente úmido.', 'Baixa', 'Solo fértil e drenável.'),
(93, 93, 'Sol pleno (mínimo 6 horas).', 'Rega frequente. Gosta de solo úmido.', 'Média.', 'Solo fértil e drenável.'),
(94, 94, 'Sol pleno ou meia-sombra (sol da manhã).', 'Rega regular. Manter o solo úmido durante a floração.', 'Média.', 'Solo fértil e bem drenável.'),
(95, 95, 'Sol pleno ou luz brilhante.', 'Rega regular. Manter o solo levemente úmido.', 'Baixa', 'Solo fértil e bem drenável.'),
(96, 96, 'Meia-sombra. Gosta de claridade, mas não sol direto.', 'Rega frequente. Gosta de solo muito úmido.', 'Alta', 'Solo rico em matéria orgânica.'),
(97, 97, 'Meia-sombra ou luz filtrada.', 'Rega frequente. Gosta de solo úmido.', 'Alta', 'Solo fértil e drenável.'),
(98, 98, 'Sol pleno (mínimo 6 horas).', 'Rega regular, na base da planta. Evitar molhar folhas.', 'Baixa', 'Solo fértil e bem drenável.'),
(99, 99, 'Luz brilhante, sem sol direto.', 'Rega espaçada. Deixar o solo secar superficialmente. Sensível a flúor.', 'Média. Borrifar ajuda.', 'Solo leve e drenável.'),
(100, 100, 'Meia-sombra ou luz filtrada. Sol direto queima as folhas.', 'Rega regular. Manter o solo úmido. Entra em dormência no inverno.', 'Alta', 'Solo rico em matéria orgânica.');

-- --------------------------------------------------------

--
-- Estrutura da tabela `especificacoes`
--

CREATE TABLE `especificacoes` (
  `id_especificacoes` int(11) NOT NULL,
  `id_planta` int(11) NOT NULL,
  `nomeCientifico` text NOT NULL,
  `familia` text NOT NULL,
  `origem` text NOT NULL,
  `alturaMedia` text NOT NULL,
  `pet` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `especificacoes`
--

INSERT INTO `especificacoes` (`id_especificacoes`, `id_planta`, `nomeCientifico`, `familia`, `origem`, `alturaMedia`, `pet`) VALUES
(1, 1, 'Echeveria affinis', 'Crassulaceae', 'México', '15 cm', 'Não tóxica'),
(2, 2, 'Crassula ovata', 'Crassulaceae', 'África do Sul', 'Até 1.5m (em vaso)', 'Tóxica (leve)'),
(3, 3, 'Sedum morganianum', 'Crassulaceae', 'México e Honduras', 'Até 1m (pendente)', 'Não tóxica'),
(4, 4, 'Nephrolepis exaltata', 'Nephrolepidaceae', 'Regiões tropicais', 'Até 90 cm', 'Não tóxica'),
(5, 5, 'Platycerium bifurcatum', 'Polypodiaceae', 'Austrália, Nova Guiné', 'Até 90 cm', 'Não tóxica'),
(6, 6, 'Asplenium nidus', 'Aspleniaceae', 'Ásia e Oceania', 'Até 60 cm', 'Não tóxica'),
(7, 7, 'Sansevieria trifasciata', 'Asparagaceae', 'África', 'Até 1m', 'Tóxica'),
(8, 8, 'Zamioculcas zamiifolia', 'Araceae', 'África', 'Até 1m', 'Tóxica'),
(9, 9, 'Spathiphyllum wallisii', 'Araceae', 'Colômbia, Venezuela', 'Até 60 cm', 'Tóxica'),
(10, 10, 'Adenium obesum', 'Apocynaceae', 'África e Península Arábica', 'Até 1m (em vaso)', 'Tóxica (seiva)'),
(11, 11, 'Agave attenuata', 'Asparagaceae', 'México', 'Até 1.5m', 'Tóxica (seiva)'),
(12, 12, 'Euphorbia ingens', 'Euphorbiaceae', 'África do Sul', 'Até 2m (em vaso)', 'Tóxica (seiva)'),
(13, 13, 'Epipremnum aureum', 'Araceae', 'Polinésia Francesa', 'Até 2m (pendente)', 'Tóxica'),
(14, 14, 'Hedera helix', 'Araliaceae', 'Europa, Ásia, África', 'Até 3m (pendente)', 'Tóxica'),
(15, 15, 'Senecio rowleyanus', 'Asteraceae', 'África do Sul', 'Até 90cm (pendente)', 'Tóxica'),
(16, 16, 'Plinia cauliflora', 'Myrtaceae', 'Brasil', 'Até 4m (em vaso)', 'Não tóxica'),
(17, 17, 'Eugenia uniflora', 'Myrtaceae', 'Brasil', 'Até 3m (em vaso)', 'Não tóxica'),
(18, 18, 'Citrus limon', 'Rutaceae', 'Ásia', 'Até 2.5m (em vaso)', 'Não tóxica (fruto)'),
(19, 19, 'Phalaenopsis', 'Orchidaceae', 'Sudeste Asiático', 'Até 50 cm', 'Não tóxica'),
(20, 20, 'Anthurium andraeanum', 'Araceae', 'Colômbia, Equador', 'Até 60 cm', 'Tóxica'),
(21, 21, 'Begonia rex', 'Begoniaceae', 'Índia', 'Até 40 cm', 'Tóxica'),
(22, 22, 'Crassula ovata \"Gollum\"', 'Crassulaceae', 'África do Sul (Híbrido)', 'Até 80 cm', 'Tóxica (leve)'),
(23, 23, 'Graptopetalum paraguayense', 'Crassulaceae', 'México', '20 cm (cresce para os lados)', 'Não tóxica'),
(24, 24, 'Davallia fejeensis', 'Davalliaceae', 'Ilhas Fiji', 'Até 40 cm', 'Não tóxica'),
(25, 25, 'Nephrolepis exaltata \"Marisa\"', 'Nephrolepidaceae', 'Híbrido (origem tropical)', 'Até 30 cm', 'Não tóxica'),
(26, 26, 'Stromanthe sanguinea \"Triostar\"', 'Marantaceae', 'Brasil', 'Até 60 cm', 'Não tóxica'),
(27, 27, 'Monstera deliciosa', 'Araceae', 'México, América Central', 'Até 3m (em vaso, com tutor)', 'Tóxica'),
(28, 28, 'Lavandula angustifolia', 'Lamiaceae', 'Região Mediterrânea', 'Até 60 cm', 'Não tóxica (pode ser tóxica para cães em grandes qtdes)'),
(29, 29, 'Rhapis excelsa', 'Arecaceae (Palmae)', 'China, Vietnã', 'Até 3m (crescimento lento)', 'Não tóxica'),
(30, 30, 'Peperomia argyreia', 'Piperaceae', 'Brasil', 'Até 30 cm', 'Não tóxica'),
(31, 31, 'Ceropegia woodii', 'Apocynaceae', 'África do Sul, Zimbábue', 'Até 2m (pendente)', 'Não tóxica'),
(32, 32, 'Rubus spp.', 'Rosaceae', 'Hemisfério Norte', 'Até 2m (requer poda)', 'Não tóxica'),
(33, 33, 'Malpighia emarginata', 'Malpighiaceae', 'América Central e do Sul', 'Até 3m (pode ser podada)', 'Não tóxica'),
(34, 34, 'Saintpaulia ionantha', 'Gesneriaceae', 'Tanzânia, Quênia', 'Até 15 cm', 'Não tóxica'),
(35, 35, 'Guzmania lingulata', 'Bromeliaceae', 'América Central e do Sul', 'Até 40 cm (com haste)', 'Não tóxica'),
(36, 36, 'Kalanchoe blossfeldiana', 'Crassulaceae', 'Madagascar', '30 cm', 'Tóxica'),
(37, 37, 'Haworthiopsis attenuata', 'Asphodelaceae', 'África do Sul', '15 cm', 'Não tóxica'),
(38, 38, 'Echinopsis chamaecereus', 'Cactaceae', 'Argentina', '15 cm (cresce em colônia)', 'Não tóxica'),
(39, 39, 'Adiantum raddianum', 'Pteridaceae', 'Brasil', 'Até 50 cm', 'Não tóxica'),
(40, 40, 'Phlebodium aureum', 'Polypodiaceae', 'América Tropical', 'Até 90 cm', 'Não tóxica'),
(41, 41, 'Maranta leuconeura \"Tricolor\"', 'Marantaceae', 'Brasil', '30 cm', 'Não tóxica'),
(42, 42, 'Peperomia perciliata', 'Piperaceae', 'Equador, Colômbia', '20 cm (pendente)', 'Não tóxica'),
(43, 43, 'Syngonium podophyllum', 'Araceae', 'América Central e do Sul', 'Até 1.5m (com tutor)', 'Tóxica'),
(44, 44, 'Philodendron martianum', 'Araceae', 'Brasil', 'Até 1m', 'Tóxica'),
(45, 45, 'Codiaeum variegatum', 'Euphorbiaceae', 'Malásia, Ilhas do Pacífico', 'Até 1.5m (em vaso)', 'Tóxica (seiva)'),
(46, 46, 'Ixora coccinea', 'Rubiaceae', 'Ásia (Índia, Sri Lanka)', 'Até 1m', 'Não tóxica'),
(47, 47, 'Buxus sempervirens', 'Buxaceae', 'Europa, África', 'Até 2m (controlado)', 'Tóxica'),
(48, 48, 'Yucca elephantipes', 'Asparagaceae', 'México, Guatemala', 'Até 3m (em vaso)', 'Tóxica (leve)'),
(49, 49, 'Callisia repens', 'Commelinaceae', 'América Central e do Sul', 'Até 1m (pendente)', 'Não tóxica'),
(50, 50, 'Senecio peregrinus', 'Asteraceae', 'Híbrido', 'Até 50cm (pendente)', 'Tóxica'),
(51, 51, 'Tradescantia zebrina', 'Commelinaceae', 'México, Colômbia', 'Até 60cm (pendente)', 'Tóxica (leve)'),
(52, 52, 'Fortunella margarita', 'Rutaceae', 'China', 'Até 2m (em vaso)', 'Não tóxica'),
(53, 53, 'Punica granatum \"Nana\"', 'Lythraceae', 'Região do Irã (Híbrido)', 'Até 1m', 'Não tóxica'),
(54, 54, 'Vaccinium corymbosum', 'Ericaceae', 'América do Norte (Híbrido)', 'Até 1.5m (em vaso)', 'Não tóxica'),
(55, 55, 'Anthurium \"Black Queen\"', 'Araceae', 'Híbrido', 'Até 60 cm', 'Tóxica'),
(56, 56, 'Alcantarea imperialis', 'Bromeliaceae', 'Brasil (Serra dos Órgãos)', 'Até 1.5m (roseta)', 'Não tóxica'),
(57, 57, 'Rhododendron simsii', 'Ericaceae', 'Ásia (Japão, China)', 'Até 1m (em vaso)', 'Tóxica'),
(58, 58, 'Gardenia jasminoides', 'Rubiaceae', 'Ásia (China, Japão)', 'Até 1.5m (em vaso)', 'Tóxica (leve)'),
(59, 59, 'Camellia japonica', 'Theaceae', 'Japão, Coreia, China', 'Até 2m (em vaso)', 'Não tóxica'),
(60, 60, 'Chrysanthemum morifolium', 'Asteraceae', 'China', 'Até 50 cm', 'Tóxica'),
(61, 61, 'Pachyphytum oviferum', 'Crassulaceae', 'México', '15 cm', 'Não tóxica'),
(62, 62, 'Senecio vitalis', 'Asteraceae', 'África do Sul', 'Até 60 cm', 'Tóxica'),
(63, 63, 'Aloe barbadensis miller', 'Asphodelaceae', 'Península Arábica', 'Até 1m', 'Tóxica (ingestão)'),
(64, 64, 'Kalanchoe tomentosa', 'Crassulaceae', 'Madagascar', 'Até 45 cm', 'Tóxica'),
(65, 65, 'Acanthocereus tetragonus', 'Cactaceae', 'América Central e do Sul', 'Até 2m (pode ser podado)', 'Não tóxica'),
(66, 66, 'Pteris cretica', 'Pteridaceae', 'Europa, Ásia, África', 'Até 60 cm', 'Não tóxica'),
(67, 67, 'Adiantum capillus-veneris', 'Pteridaceae', 'Regiões tropicais e subtropicais', 'Até 40 cm', 'Não tóxica'),
(68, 68, 'Nephrolepis exaltata \"Fluffy Ruffles\"', 'Nephrolepidaceae', 'Híbrido', 'Até 40 cm', 'Não tóxica'),
(69, 69, 'Microgramma squamulosa', 'Polypodiaceae', 'Brasil', 'Até 1m (pendente)', 'Não tóxica'),
(70, 70, 'Dieffenbachia seguine \"Camille\"', 'Araceae', 'América do Sul (Híbrido)', 'Até 1m', 'Altamente Tóxica'),
(71, 71, 'Fittonia albivenis', 'Acanthaceae', 'Peru, Colômbia', '15 cm (rasteira)', 'Não tóxica'),
(72, 72, 'Peperomia obtusifolia', 'Piperaceae', 'Flórida, México, Caribe', 'Até 30 cm', 'Não tóxica'),
(73, 73, 'Aglaonema commutatum', 'Araceae', 'Ásia (Filipinas)', 'Até 60 cm', 'Tóxica'),
(74, 74, 'Chamaedorea elegans', 'Arecaceae (Palmae)', 'México, Guatemala', 'Até 1.5m', 'Não tóxica'),
(75, 75, 'Calathea lietzei \"White Fusion\"', 'Marantaceae', 'Híbrido', 'Até 40 cm', 'Não tóxica'),
(76, 76, 'Cycas revoluta', 'Cycadaceae', 'Japão', 'Até 1.5m (em vaso)', 'Altamente Tóxica'),
(77, 77, 'Beaucarnea recurvata', 'Asparagaceae', 'México', 'Até 2m (em vaso)', 'Não tóxica'),
(78, 78, 'Rosmarinus officinalis', 'Lamiaceae', 'Região Mediterrânea', 'Até 1m (em vaso)', 'Não tóxica'),
(79, 79, 'Ocimum basilicum', 'Lamiaceae', 'Índia, Ásia', 'Até 50 cm', 'Não tóxica'),
(80, 80, 'Strelitzia reginae', 'Strelitziaceae', 'África do Sul', 'Até 1.5m', 'Tóxica'),
(81, 81, 'Bougainvillea glabra', 'Nyctaginaceae', 'Brasil', 'Até 3m (controlada)', 'Tóxica (seiva)'),
(82, 82, 'Tradescantia \"Nanouk\"', 'Commelinaceae', 'Híbrido (Holanda)', '20 cm (pendente)', 'Tóxica (leve)'),
(83, 83, 'Philodendron hederaceum', 'Araceae', 'América Central e Caribe', 'Até 3m (pendente)', 'Tóxica'),
(84, 84, 'Dischidia nummularia', 'Apocynaceae', 'Ásia, Austrália', 'Até 1m (pendente)', 'Tóxica (seiva)'),
(85, 85, 'Hoya carnosa', 'Apocynaceae', 'Ásia', 'Até 2m (pendente)', 'Não tóxica'),
(86, 86, 'Aeschynanthus radicans', 'Gesneriaceae', 'Malásia', 'Até 60cm (pendente)', 'Não tóxica'),
(87, 87, 'Philodendron Brasil', 'Araceae', 'Híbrido', 'Até 3m (pendente)', 'Tóxica'),
(88, 88, 'Ficus carica', 'Moraceae', 'Região Mediterrânea', 'Até 3m (em vaso)', 'Tóxica (seiva)'),
(89, 89, 'Psidium guajava \"Nana\"', 'Myrtaceae', 'Híbrido', 'Até 2m (em vaso)', 'Não tóxica'),
(90, 90, 'Fragaria x ananassa', 'Rosaceae', 'Híbrido', '20 cm (rasteira)', 'Não tóxica'),
(91, 91, 'Passiflora edulis', 'Passifloraceae', 'América do Sul', 'Até 5m (trepadeira)', 'Não tóxica (fruto)'),
(92, 92, 'Capsicum frutescens', 'Solanaceae', 'América Central e do Sul', 'Até 80 cm', 'Tóxica (leve, folhas)'),
(93, 93, 'Hibiscus rosa-sinensis', 'Malvaceae', 'Ásia', 'Até 1.8m (em vaso)', 'Não tóxica'),
(94, 94, 'Lilium (Asiatic Hybrid)', 'Liliaceae', 'Híbrido', 'Até 60 cm', 'Altamente Tóxica (p/ gatos)'),
(95, 95, 'Gerbera jamesonii', 'Asteraceae', 'África do Sul', 'Até 40 cm', 'Não tóxica'),
(96, 96, 'Zantedeschia aethiopica', 'Araceae', 'África do Sul', 'Até 90 cm', 'Tóxica'),
(97, 97, 'Spathiphyllum \"Mauna Loa\"', 'Araceae', 'Híbrido', 'Até 1.2m', 'Tóxica'),
(98, 98, 'Rosa chinensis \"Minima\"', 'Rosaceae', 'Híbrido', 'Até 40 cm', 'Não tóxica'),
(99, 99, 'Dracaena marginata', 'Asparagaceae', 'Madagascar', 'Até 2m (em vaso)', 'Tóxica'),
(100, 100, 'Caladium bicolor', 'Araceae', 'América do Sul', 'Até 60 cm', 'Altamente Tóxica');

-- --------------------------------------------------------

--
-- Estrutura da tabela `item_carrinho`
--

CREATE TABLE `item_carrinho` (
  `id_item_carrinho` int(11) NOT NULL,
  `id_carrinho` int(11) NOT NULL,
  `id_planta` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `item_pedido`
--

CREATE TABLE `item_pedido` (
  `id_item_pedido` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_planta` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `data_pedido` datetime DEFAULT current_timestamp(),
  `status_pedido` enum('cancelado','finalizado') NOT NULL,
  `valor_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `plantas`
--

CREATE TABLE `plantas` (
  `id_planta` int(11) NOT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `nome_planta` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `quantidade_estoque` int(11) NOT NULL,
  `imagem_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `plantas`
--

INSERT INTO `plantas` (`id_planta`, `id_categoria`, `nome_planta`, `descricao`, `preco`, `quantidade_estoque`, `imagem_url`) VALUES
(1, 1, 'Echeveria Black Prince', 'Uma suculenta deslumbrante com folhas escuras, quase negras. Forma uma roseta compacta.', '24.90', 80, 'img/echeveria_black_prince.jpg'),
(2, 1, 'Planta-Jade (Crassula ovata)', 'Conhecida como a árvore da amizade ou do dinheiro. Fácil de cuidar e muito resistente.', '35.00', 50, 'img/planta_jade.jpg'),
(3, 1, 'Dedo-de-Moça (Sedum morganianum)', 'Suculenta pendente com longos caules cobertos de pequenas folhas carnudas. Perfeita para vasos suspensos.', '29.90', 65, 'img/dedo_de_moca.jpg'),
(4, 2, 'Samambaia-Americana', 'A samambaia clássica, com folhas longas e arqueadas. Adora umidade e sombra.', '45.00', 40, 'img/samambaia_americana.jpg'),
(5, 2, 'Chifre-de-Veado', 'Uma samambaia epífita exótica, ideal para ser montada em placas de madeira.', '89.90', 15, 'img/chifre_de_veado.jpg'),
(6, 2, 'Samambaia-Asplênio (Ninho-de-Pássaro)', 'Possui folhas inteiras, largas e brilhantes, que crescem em forma de roseta.', '55.00', 30, 'img/asplenio.jpg'),
(7, 3, 'Espada-de-São-Jorge', 'Extremamente resistente e purificadora de ar. Tolera muito bem a falta de luz e de água.', '39.90', 120, 'img/espada_sao_jorge.jpg'),
(8, 3, 'Zamioculca', 'A \"planta da fortuna\". Quase indestrutível, perfeita para iniciantes ou locais com pouca luz.', '79.90', 70, 'img/zamioculca.jpg'),
(9, 3, 'Lírio-da-Paz', 'Elegante, com flores brancas. Ótima para interiores e é conhecida por filtrar toxinas do ar.', '49.90', 60, 'img/lirio_da_paz.jpg'),
(10, 4, 'Rosa-do-Deserto', 'Famosa por seu caudex (caule grosso) e flores vibrantes. Precisa de muito sol e pouca água.', '99.00', 25, 'img/rosa_do_deserto.jpg'),
(11, 4, 'Agave-Dragão', 'Uma agave sem espinhos, com uma bela roseta de folhas verde-acinzentadas. Escultural para jardins.', '120.00', 18, 'img/agave_dragao.jpg'),
(12, 4, 'Cacto-Mandioca', 'Um cacto de grande porte que lembra um mandacaru. Crescimento vertical, muito resistente ao sol.', '150.00', 10, 'img/cacto_mandioca.jpg'),
(13, 5, 'Jiboia (Epipremnum aureum)', 'Planta pendente mais popular. Muito fácil de cuidar, cresce rápido e se adapta a diferentes níveis de luz.', '38.00', 90, 'img/jiboia.jpg'),
(14, 5, 'Hera-Inglesa (Hedera helix)', 'Uma trepadeira clássica que também pode ser usada como pendente. Folhas em formato de estrela.', '27.50', 55, 'img/hera_inglesa.jpg'),
(15, 5, 'Colar-de-Pérolas', 'Suculenta pendente única, com folhas em formato de pequenas pérolas. Requer rega cuidadosa.', '42.00', 35, 'img/colar_de_perolas.jpg'),
(16, 6, 'Jabuticabeira Híbrida (Muda)', 'Produz frutos mais rapidamente que a espécie nativa. Pode ser cultivada em vasos grandes.', '130.00', 20, 'img/jabuticabeira.jpg'),
(17, 6, 'Pitangueira (Muda)', 'Árvore nativa do Brasil, produz frutos saborosos e atrai pássaros. Adapta-se bem a vasos.', '65.00', 30, 'img/pitangueira.jpg'),
(18, 6, 'Limoeiro-Siciliano (Muda)', 'Muda enxertada, produz limões grandes e aromáticos. Precisa de sol pleno.', '85.00', 22, 'img/limoeiro.jpg'),
(19, 7, 'Orquídea Phalaenopsis (Branca)', 'A orquídea mais comum para iniciantes. Floresce por meses e é ideal para interiores iluminados.', '75.00', 40, 'img/orquidea.jpg'),
(20, 7, 'Antúrio (Vermelho)', 'Famoso por suas \"flores\" vermelhas brilhantes (que na verdade são brácteas). Gosta de sombra e umidade.', '59.90', 38, 'img/anturio.jpg'),
(21, 7, 'Begônia-Rex', 'Cultivada pela beleza de suas folhas, que possuem padrões e cores incríveis. Prefere sombra.', '34.00', 45, 'img/begonia_rex.jpg'),
(22, 1, 'Orelha-de-Shrek (Crassula gollum)', 'Variedade da Planta-Jade com folhas tubulares que se assemelham às orelhas do personagem.', '28.00', 75, 'img/orelha_shrek.jpg'),
(23, 1, 'Planta-Fantasma (Graptopetalum paraguayense)', 'Suculenta de roseta com folhas pálidas, acinzentadas ou rosadas. Muito prolífica.', '19.90', 110, 'img/planta_fantasma.jpg'),
(24, 2, 'Samambaia-Renda-Portuguesa (Davallia fejeensis)', 'Possui rizomas peludos que crescem para fora do vaso, lembrando \"patas de coelho\".', '52.00', 30, 'img/renda_portuguesa.jpg'),
(25, 2, 'Samambaia-Mini (Nephrolepis exaltata \"Marisa\")', 'Uma versão compacta e densa da samambaia-americana, ideal para espaços menores.', '35.00', 45, 'img/samambaia_mini.jpg'),
(26, 3, 'Calathea Triostar', 'Folhagem deslumbrante com tons de rosa, verde e creme. Suas folhas se movem com a luz.', '85.00', 25, 'img/calathea_triostar.jpg'),
(27, 3, 'Costela-de-Adão (Monstera deliciosa)', 'A planta tropical icônica, famosa por suas grandes folhas recortadas. Traz um visual selvagem para dentro de casa.', '140.00', 40, 'img/costela_adao.jpg'),
(28, 4, 'Lavanda (Lavandula angustifolia)', 'Arbusto aromático com flores roxas. Perfeito para jardins, atrai abelhas e repele mosquitos.', '32.00', 60, 'img/lavanda.jpg'),
(29, 4, 'Palmeira-Ráfia (Rhapis excelsa)', 'Embora tolere sombra, cresce mais bonita com sol da manhã. Elegante, com múltiplos caules.', '180.00', 15, 'img/palmeira_rafia.jpg'),
(30, 5, 'Peperômia-Melancia (Peperomia argyreia)', 'Folhas redondas com listras prateadas que lembram uma melancia. Crescimento compacto.', '48.00', 50, 'img/peperomia_melancia.jpg'),
(31, 5, 'Corações-Emaranhados (Ceropegia woodii)', 'Planta delicada com pequenas folhas em formato de coração, em tons de verde e roxo.', '39.00', 65, 'img/coracoes_emaranhados.jpg'),
(32, 6, 'Amora-Preta (Muda)', 'Produz amoras suculentas. Pode ser cultivada em vasos grandes ou como cerca-viva.', '55.00', 28, 'img/amora.jpg'),
(33, 6, 'Acerola (Muda)', 'Pequena árvore que produz frutos ricos em Vitamina C. Precisa de bastante sol.', '60.00', 33, 'img/acerola.jpg'),
(34, 7, 'Violeta-Africana (Saintpaulia ionantha)', 'Pequena planta de interior que floresce o ano todo. Disponível em várias cores.', '18.00', 90, 'img/violeta.jpg'),
(35, 7, 'Bromélia-Guzmania', 'Planta tropical com uma inflorescência central vibrante (vermelha, laranja ou amarela) que dura meses.', '69.90', 42, 'img/bromelia_guzmania.jpg'),
(36, 1, 'Kalanchoe (Flor-da-Fortuna)', 'Suculenta muito popular que produz cachos de flores coloridas. Extremamente resistente.', '15.90', 150, 'img/kalanchoe.jpg'),
(37, 1, 'Haworthia Zebra (Planta-Zebra)', 'Pequena suculenta com folhas pontudas e \"listras\" brancas. Ótima para terrários.', '22.00', 90, 'img/haworthia_zebra.jpg'),
(38, 1, 'Cacto-Amendoim', 'Cacto de pequeno porte que cresce em tufos, com hastes que lembram amendoins.', '26.50', 60, 'img/cacto_amendoim.jpg'),
(39, 2, 'Renda-Francesa', 'Samambaia delicada com folhas finamente recortadas, dando um aspecto de leveza.', '48.00', 35, 'img/renda_francesa.jpg'),
(40, 2, 'Samambaia-Azul (Blue Star)', 'Possui uma coloração única verde-azulada e folhas mais rígidas. Muito ornamental.', '62.00', 28, 'img/samambaia_azul.jpg'),
(41, 3, 'Maranta-Tricolor (Planta-Rezadeira)', 'Folhagem deslumbrante que se fecha à noite. Tons de verde, rosa e creme.', '65.00', 40, 'img/maranta_tricolor.jpg'),
(42, 3, 'Peperômia-Filodendro', 'Folhas pequenas e carnudas em formato de coração. Ótima para prateleiras em locais de sombra.', '33.00', 70, 'img/peperomia_filodendro.jpg'),
(43, 3, 'Singônio (Syngonium)', 'Planta versátil com folhas em formato de seta. Pode ser usada como trepadeira ou pendente.', '30.00', 85, 'img/singonio.jpg'),
(44, 3, 'Pacová', 'Planta de folhagem grande, verde-escura e brilhante. Traz um visual tropical imediato.', '95.00', 22, 'img/pacova.jpg'),
(45, 3, 'Croton (Folha-Imperial)', 'Arbusto com folhagem extremamente colorida (vermelho, amarelo, laranja). Precisa de luz para manter a cor.', '55.00', 50, 'img/croton.jpg'),
(46, 4, 'Ixora (Mini)', 'Arbusto que produz flores densas e coloridas (vermelhas ou laranjas). Perfeito para jardins.', '40.00', 45, 'img/ixora.jpg'),
(47, 4, 'Buxinho (Buxus)', 'Planta clássica para topiaria (arte de podar plantas). Muito denso e aceita podas.', '60.00', 30, 'img/buxinho.jpg'),
(48, 4, 'Yucca (Yuca-Gigante)', 'Planta escultural com tronco lenhoso e folhas pontiagudas. Extremamente resistente ao sol e seca.', '160.00', 15, 'img/yucca.jpg'),
(49, 5, 'Tostão (Dinheiro-em-Penca)', 'Planta pendente com milhares de pequenas folhas redondas e verdes. Crescimento rápido.', '25.00', 120, 'img/tostao.jpg'),
(50, 5, 'Colar-de-Golfinhos', 'Suculenta pendente rara, cujas folhas se parecem com pequenos golfinhos saltando.', '58.00', 30, 'img/colar_golfinhos.jpg'),
(51, 5, 'Lambari-Roxo', 'Planta pendente de crescimento rápido com folhas roxas e verdes. Ótima para forração.', '18.00', 100, 'img/lambari_roxo.jpg'),
(52, 6, 'Laranjinha Kinkan (Muda)', 'Produz pequenas laranjas ornamentais e comestíveis (casca doce). Ideal para vasos.', '75.00', 25, 'img/kinkan.jpg'),
(53, 6, 'Romã (Anã - Muda)', 'Versão anã da romãzeira, produz frutos menores, mas é muito ornamental.', '88.00', 20, 'img/roma_ana.jpg'),
(54, 6, 'Mirtilo (Blueberry - Muda)', 'Muda de Mirtilo adaptada para climas mais quentes. Requer solo ácido.', '95.00', 18, 'img/mirtilo.jpg'),
(55, 7, 'Antúrio Negro (Black Queen)', 'Uma variedade de antúrio com brácteas de cor vinho-escuro, quase negras. Muito sofisticado.', '90.00', 20, 'img/anturio_negro.jpg'),
(56, 7, 'Bromélia-Imperial', 'Bromélia de grande porte, com uma roseta de folhas largas e uma inflorescência central imponente.', '220.00', 10, 'img/bromelia_imperial.jpg'),
(57, 7, 'Azaleia (Muda)', 'Arbusto que produz uma floração intensa no inverno/primavera. Ótima para vasos.', '35.00', 60, 'img/azaleia.jpg'),
(58, 7, 'Gardênia (Jasmim-do-Cabo)', 'Famosa por suas flores brancas e extremamente perfumadas. Requer solo ácido.', '50.00', 30, 'img/gardenia.jpg'),
(59, 7, 'Camélia (Muda)', 'Arbusto que produz flores grandes e elegantes no inverno. Símbolo de sofisticação.', '110.00', 15, 'img/camelia.jpg'),
(60, 7, 'Crisântemo (Vaso)', 'Flor popular em vaso, disponível em inúmeras cores. Ótima para presentear.', '20.00', 130, 'img/crisantemo.jpg'),
(61, 1, 'Pachyphytum oviferum (Moonstones)', 'Suculenta com folhas redondas e carnudas, cobertas por uma pruína branca/rosada.', '32.00', 50, 'img/moonstones.jpg'),
(62, 1, 'Senecio vitalis (Lápis-Azul)', 'Suculenta arbustiva com folhas longas, cilíndricas e de cor verde-azulada.', '28.00', 60, 'img/senecio_vitalis.jpg'),
(63, 1, 'Aloe Vera (Babosa)', 'Planta medicinal e ornamental, com folhas longas e carnudas cheias de gel.', '35.00', 80, 'img/aloe_vera.jpg'),
(64, 1, 'Kalanchoe tomentosa (Orelha-de-Gato)', 'Folhas cobertas por uma fina penugem branca, com pontas marrons. Toque aveludado.', '29.90', 70, 'img/orelha_de_gato.jpg'),
(65, 1, 'Cacto-Castelo-de-Fada', 'Cacto colunar que se ramifica muito, criando uma estrutura que lembra um castelo.', '45.00', 40, 'img/castelo_de_fada.jpg'),
(66, 2, 'Samambaia-Prata (Pteris cretica)', 'Folhas elegantes com uma faixa central prateada. Porte médio.', '38.00', 35, 'img/samambaia_prata.jpg'),
(67, 2, 'Avenca', 'Extremamente delicada, com folhas pequenas e triangulares em hastes negras e finas.', '30.00', 55, 'img/avenca.jpg'),
(68, 2, 'Samambaia-Crespa (Fluffy Ruffles)', 'Variedade da samambaia-americana com folhas densas e muito crespas.', '42.00', 30, 'img/samambaia_crespa.jpg'),
(69, 2, 'Microgramma (Samambaia-Cipó)', 'Samambaia epífita nativa do Brasil, com folhas pequenas e redondas.', '35.00', 25, 'img/microgramma.jpg'),
(70, 3, 'Comigo-Ninguém-Pode (Camille)', 'Variedade de Dieffenbachia com folhas grandes, majoritariamente creme com bordas verdes.', '50.00', 60, 'img/dieffenbachia_camille.jpg'),
(71, 3, 'Fittonia (Planta-Mosaico)', 'Pequena planta rasteira com folhas verdes e nervuras vibrantes (brancas ou rosas).', '25.00', 90, 'img/fittonia.jpg'),
(72, 3, 'Peperômia-Verde (Peperomia obtusifolia)', 'Folhas redondas, espessas e brilhantes, de um verde-escuro sólido. Muito resistente.', '34.00', 75, 'img/peperomia_obtusifolia.jpg'),
(73, 3, 'Aglaonema (Café-de-Salão)', 'Folhagem exuberante manchada de verde e prata. Extremamente resistente à sombra.', '70.00', 50, 'img/aglaonema.jpg'),
(74, 3, 'Chamadórea-Elegante', 'Mini-palmeira clássica para interiores. Crescimento lento e muito elegante.', '55.00', 45, 'img/chamadorea.jpg'),
(75, 3, 'Calathea White Fusion', 'Considerada uma \"joia\" rara, com folhas que parecem pinceladas de branco, verde e lilás.', '120.00', 15, 'img/calathea_whitefusion.jpg'),
(76, 4, 'Cica (Cycas revoluta)', 'Planta pré-histórica, parece uma pequena palmeira. Crescimento muito lento.', '130.00', 20, 'img/cica.jpg'),
(77, 4, 'Pata-de-Elefante', 'Base do tronco muito grossa (caudex) que armazena água. Folhas longas e curvas.', '90.00', 30, 'img/pata_elefante.jpg'),
(78, 4, 'Alecrim (Vaso)', 'Erva aromática e culinária. Precisa de muito sol e pouca água.', '22.00', 100, 'img/alecrim.jpg'),
(79, 4, 'Manjericão (Vaso)', 'Erva culinária popular. Precisa de sol pleno e rega constante.', '18.00', 120, 'img/manjericao.jpg'),
(80, 4, 'Ave-do-Paraíso (Strelitzia)', 'Planta escultural com folhas grandes e flores exóticas que lembram um pássaro.', '170.00', 18, 'img/strelitzia.jpg'),
(81, 4, 'Primavera (Bougainvillea - Vaso)', 'Trepadeira famosa por suas brácteas coloridas (rosa, roxo, branco). Ama sol.', '65.00', 35, 'img/bougainvillea.jpg'),
(82, 5, 'Tradescantia Nanouk', 'Variedade nova com folhas listradas de rosa, roxo e verde. Crescimento rápido.', '40.00', 60, 'img/tradescantia_nanouk.jpg'),
(83, 5, 'Filodendro-Coração (Verde)', 'A planta pendente clássica. Folhas em formato de coração, verde-escuras.', '32.00', 95, 'img/filodendro_coracao.jpg'),
(84, 5, 'Dischidia (String of Nickels)', 'Pendente com folhas redondas e achatadas, que lembram moedas. Epífita.', '48.00', 40, 'img/string_of_nickels.jpg'),
(85, 5, 'Flor-de-Cera (Hoya carnosa)', 'Trepadeira/pendente com folhas grossas e flores perfumadas que parecem de porcelana.', '75.00', 30, 'img/hoya_carnosa.jpg'),
(86, 5, 'Planta-Batom (Aeschynanthus)', 'Pendente com flores tubulares vermelhas que saem de um cálice escuro, lembrando um batom.', '58.00', 25, 'img/planta_batom.jpg'),
(87, 5, 'Filodendro-Brasil', 'Variedade do Filodendro-Coração com folhas manchadas de verde-limão e verde-escuro.', '38.00', 70, 'img/filodendro_brasil.jpg'),
(88, 6, 'Figo (Muda)', 'Muda de figueira que pode ser cultivada em vasos grandes, produzindo figos.', '80.00', 20, 'img/figo.jpg'),
(89, 6, 'Goiaba (Anã - Muda)', 'Variedade de goiabeira que produz em tamanho menor, ideal para vasos.', '70.00', 28, 'img/goiaba_ana.jpg'),
(90, 6, 'Morango (Vaso/Jardineira)', 'Planta rasteira que produz morangos. Perfeita para vasos suspensos.', '15.00', 150, 'img/morango.jpg'),
(91, 6, 'Maracujá (Doce - Muda)', 'Trepadeira que necessita de suporte. Pode ser cultivada em vasos grandes.', '45.00', 40, 'img/maracuja.jpg'),
(92, 6, 'Pimenta-Malagueta (Vaso)', 'Produz pimentas picantes. Muito ornamental e culinária.', '24.00', 80, 'img/pimenta_malagueta.jpg'),
(93, 7, 'Hibisco (Vaso)', 'Arbusto que produz flores grandes e vibrantes, mas que duram apenas um dia.', '45.00', 50, 'img/hibisco.jpg'),
(94, 7, 'Lírio (Asiático - Vaso)', 'Bulbo que produz flores grandes e vistosas. Muito perfumado.', '35.00', 60, 'img/lirio_asiatico.jpg'),
(95, 7, 'Gérbera (Vaso)', 'Flor muito popular que lembra uma margarida grande e colorida.', '20.00', 110, 'img/gerbera.jpg'),
(96, 7, 'Copo-de-Leite', 'Planta elegante com \"flor\" branca (bráctea) e centro amarelo. Gosta de solo úmido.', '30.00', 70, 'img/copo_de_leite.jpg'),
(97, 7, 'Espatífilo Gigante', 'Versão grande do Lírio-da-Paz, com folhas e flores maiores. Imponente.', '110.00', 25, 'img/espatifilo_gigante.jpg'),
(98, 7, 'Roseira (Mini-Rosa Vaso)', 'Pequenas rosas cultivadas em vaso. Precisam de sol e poda.', '28.00', 90, 'img/mini_rosa.jpg'),
(99, 7, 'Dracena-de-Madagascar', 'Planta de visual escultural, com tronco fino e folhas pontudas no topo.', '85.00', 30, 'img/dracena_madagascar.jpg'),
(100, 7, 'Caladium (Tinhorão)', 'Planta de bulbo com folhas grandes em formato de coração, muito coloridas (rosa, branco, verde).', '40.00', 40, 'img/caladium.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha_hash` varchar(64) NOT NULL,
  `tipo` enum('cliente','admin') NOT NULL,
  `data_cadastro` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `carrinho`
--
ALTER TABLE `carrinho`
  ADD PRIMARY KEY (`id_carrinho`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`);

--
-- Índices para tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Índices para tabela `cuidados`
--
ALTER TABLE `cuidados`
  ADD PRIMARY KEY (`id_cuidados`),
  ADD UNIQUE KEY `id_planta` (`id_planta`);

--
-- Índices para tabela `especificacoes`
--
ALTER TABLE `especificacoes`
  ADD PRIMARY KEY (`id_especificacoes`),
  ADD UNIQUE KEY `id_planta` (`id_planta`);

--
-- Índices para tabela `item_carrinho`
--
ALTER TABLE `item_carrinho`
  ADD PRIMARY KEY (`id_item_carrinho`),
  ADD KEY `fk_item_carrinho_carrinho` (`id_carrinho`),
  ADD KEY `fk_item_carrinho_planta` (`id_planta`);

--
-- Índices para tabela `item_pedido`
--
ALTER TABLE `item_pedido`
  ADD PRIMARY KEY (`id_item_pedido`),
  ADD KEY `fk_item_pedido_pedido` (`id_pedido`),
  ADD KEY `fk_item_pedido_planta` (`id_planta`);

--
-- Índices para tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `fk_pedidos_id_usuario` (`id_usuario`);

--
-- Índices para tabela `plantas`
--
ALTER TABLE `plantas`
  ADD PRIMARY KEY (`id_planta`),
  ADD KEY `fk_plantas_categorias` (`id_categoria`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `carrinho`
--
ALTER TABLE `carrinho`
  MODIFY `id_carrinho` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `cuidados`
--
ALTER TABLE `cuidados`
  MODIFY `id_cuidados` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de tabela `especificacoes`
--
ALTER TABLE `especificacoes`
  MODIFY `id_especificacoes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de tabela `item_carrinho`
--
ALTER TABLE `item_carrinho`
  MODIFY `id_item_carrinho` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `item_pedido`
--
ALTER TABLE `item_pedido`
  MODIFY `id_item_pedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `plantas`
--
ALTER TABLE `plantas`
  MODIFY `id_planta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `carrinho`
--
ALTER TABLE `carrinho`
  ADD CONSTRAINT `fk_carrinho_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Limitadores para a tabela `cuidados`
--
ALTER TABLE `cuidados`
  ADD CONSTRAINT `fk_cuidados_planta` FOREIGN KEY (`id_planta`) REFERENCES `plantas` (`id_planta`);

--
-- Limitadores para a tabela `especificacoes`
--
ALTER TABLE `especificacoes`
  ADD CONSTRAINT `fk_especificacoes_planta` FOREIGN KEY (`id_planta`) REFERENCES `plantas` (`id_planta`);

--
-- Limitadores para a tabela `item_carrinho`
--
ALTER TABLE `item_carrinho`
  ADD CONSTRAINT `fk_item_carrinho_carrinho` FOREIGN KEY (`id_carrinho`) REFERENCES `carrinho` (`id_carrinho`),
  ADD CONSTRAINT `fk_item_carrinho_planta` FOREIGN KEY (`id_planta`) REFERENCES `plantas` (`id_planta`);

--
-- Limitadores para a tabela `item_pedido`
--
ALTER TABLE `item_pedido`
  ADD CONSTRAINT `fk_item_pedido_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`),
  ADD CONSTRAINT `fk_item_pedido_planta` FOREIGN KEY (`id_planta`) REFERENCES `plantas` (`id_planta`);

--
-- Limitadores para a tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedidos_id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `plantas`
--
ALTER TABLE `plantas`
  ADD CONSTRAINT `fk_plantas_categorias` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
