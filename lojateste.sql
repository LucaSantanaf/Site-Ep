-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 11-Maio-2017 às 19:44
-- Versão do servidor: 10.1.21-MariaDB
-- PHP Version: 7.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lojateste`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_adm`
--

CREATE TABLE `loja_adm` (
  `id` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `sobrenome` varchar(200) NOT NULL,
  `email_log` varchar(200) NOT NULL,
  `senha_log` varchar(200) NOT NULL,
  `tipo` int(11) NOT NULL,
  `data_log` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `loja_adm`
--

INSERT INTO `loja_adm` (`id`, `nome`, `sobrenome`, `email_log`, `senha_log`, `tipo`, `data_log`) VALUES
(1, 'Lucas', 'Santana', 'lucassantanaf@gmail.com', '12345678', 1, '2017-05-11 10:24:13'),
(2, 'Luiz', 'Santos', 'luizsantos@gmail.com', '12345', 2, '2017-04-07 12:01:32'),
(3, 'Mariana', 'Alves', 'marianaalves@gmail.com', '12', 2, '0000-00-00 00:00:00'),
(4, 'Sophia', 'Rockefeller', 'sophiarocke@gmail.com', '123456', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_banners`
--

CREATE TABLE `loja_banners` (
  `id` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `descricao` varchar(200) NOT NULL,
  `link` varchar(200) NOT NULL,
  `imagem` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `loja_banners`
--

INSERT INTO `loja_banners` (`id`, `titulo`, `descricao`, `link`, `imagem`) VALUES
(1, 'produto1', 'esse e um exemplo', 'http://www.episeg.com.br', 'slide1.png'),
(2, 'ban', 'banner', 'http://www.youtube.com', 'slide2.png'),
(3, 'Lugar', 'Um lugar daora', 'http://www.facebook.com', 'slide3.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_categorias`
--

CREATE TABLE `loja_categorias` (
  `id` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `views` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `loja_categorias`
--

INSERT INTO `loja_categorias` (`id`, `titulo`, `slug`, `views`) VALUES
(1, 'DVD', 'dvd', 51),
(2, 'CD', 'cd', 24),
(3, 'Livros', 'livros', 20);

-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_clientes`
--

CREATE TABLE `loja_clientes` (
  `id_cliente` int(11) NOT NULL,
  `imagem` varchar(150) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `sobrenome` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `telefone` varchar(100) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `rua` varchar(200) NOT NULL,
  `numero` int(11) NOT NULL,
  `complemento` varchar(150) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `uf` varchar(2) NOT NULL,
  `cep` varchar(30) NOT NULL,
  `email_log` varchar(200) NOT NULL,
  `senha_log` varchar(50) NOT NULL,
  `data_log` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `loja_clientes`
--

INSERT INTO `loja_clientes` (`id_cliente`, `imagem`, `nome`, `sobrenome`, `email`, `telefone`, `cpf`, `rua`, `numero`, `complemento`, `bairro`, `cidade`, `uf`, `cep`, `email_log`, `senha_log`, `data_log`) VALUES
(1, 'eu1.jpg', 'Lucas ', 'Santana Ferreira', 'lucassantanaf@gmail.com', '(11)4426-3220', '40134240880', 'Rua Tupi', 53, 'Proximo a divisa entre Santo Andre e Sao Bernardo do Campo', 'Vila Valparaiso', 'Santo Andre', 'SP', '09060140', 'lucassantanaf@gmail.com', '1234567', '2017-05-11 10:54:49'),
(2, '', 'JosÃ©', 'Silva', 'josesilva@gmail.com', '(11)4444-4444', '96468165172', 'Xingu', 80, 'Nada', 'ValparaÃ­so', 'Santo AndrÃ©', 'SP', '09060050', 'josesilva@gmail.com', '123', '2017-04-20 13:22:10');

-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_configs`
--

CREATE TABLE `loja_configs` (
  `manutencao` int(11) NOT NULL,
  `visitas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `loja_configs`
--

INSERT INTO `loja_configs` (`manutencao`, `visitas`) VALUES
(0, 427);

-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_imgprod`
--

CREATE TABLE `loja_imgprod` (
  `id` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `img` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `loja_imgprod`
--

INSERT INTO `loja_imgprod` (`id`, `id_produto`, `img`) VALUES
(1, 1, 'computador.png'),
(2, 2, 'brasil1.png'),
(4, 1, 'cidade-iluminada.jpg'),
(5, 1, 'cidade_grande.jpg'),
(6, 1, 'Maroon-5.png'),
(7, 2, 'eclipse.jpg'),
(8, 2, 'cidade.jpg'),
(9, 4, 'amsterda2.png'),
(10, 3, 'alemanha2.png'),
(14, 5, 'montreal.png'),
(15, 5, 'vancouver.png'),
(16, 5, 'quebec.png'),
(17, 6, '3568d324ef13d8b202c73d5e76793a2aGothenburg.png'),
(18, 6, '6190779df6a9dfc1732ae3299eec9a46Molmo.png'),
(19, 7, '37817ccae2b1b65baf18bc2584df93e9yokohama.png'),
(20, 7, '9d475a9e479fb74043af1dfc604a2cebnagoya.png'),
(21, 7, '134df4ebcb202df74bc0546f0fb79afaosaka.png'),
(22, 8, '62b72aa19bc73c65b9c06199796c9c8fSaoPetesburgo.png'),
(23, 8, '782cb5fc9032ca39e722410a8a764fe9Novosibirsk.png'),
(24, 8, 'd422248cb2ecdf3954581eac2e7cccc0ecaterimburg.png'),
(25, 9, '9db9e80887b600ad7ed7b94f7b0b40a1AbuDhabi.png'),
(26, 9, '58aaa331ef7b9253e1d955a47a3d27ebsharjah.png'),
(27, 9, '3bf0d6e6738e444a4b197183786ee14bAl-Ain.png'),
(28, 10, '868bc574f392ba1297276d326f997f44Manchester.png'),
(29, 10, 'cb27cd64b9692ada9b0b26d27ffa8441Birmingham.png'),
(30, 10, 'd14664a2f7231d6773ce2d432615f155Leeds.png'),
(31, 11, '8950126422b8b189c2a53cb5594445cfmelbourne.png'),
(32, 11, '45cd5fcde2091bfd20ececddfbf7b7dbBrisbane.png'),
(33, 11, 'fbdbd94ea4181a6209ea47bcab93a29cPerth.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_marcas`
--

CREATE TABLE `loja_marcas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `link` varchar(200) NOT NULL,
  `imagem` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `loja_marcas`
--

INSERT INTO `loja_marcas` (`id`, `titulo`, `link`, `imagem`) VALUES
(1, 'Marluvas', 'http://www.marluvas.com.br', 'marluvas.png'),
(2, 'Pesadao', 'https://www.facebook.com/media/set/?set=a.358564860902325.87410.208771082548371&type=3', 'pesadao.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_pedidos`
--

CREATE TABLE `loja_pedidos` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `valor_total` decimal(10,5) NOT NULL,
  `status` int(11) NOT NULL,
  `criado` datetime NOT NULL,
  `modificado` datetime NOT NULL,
  `tipo_frete` varchar(20) NOT NULL,
  `valor_frete` decimal(10,5) NOT NULL,
  `codigo_rastreio` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `loja_pedidos`
--

INSERT INTO `loja_pedidos` (`id`, `id_cliente`, `valor_total`, `status`, `criado`, `modificado`, `tipo_frete`, `valor_frete`, `codigo_rastreio`) VALUES
(1, 2, '75.00000', 0, '2017-03-23 00:00:00', '2017-03-24 00:00:00', 'pac', '20.00000', ''),
(2, 2, '40.00000', 0, '2017-02-07 00:00:00', '2017-02-16 00:00:00', 'sedex', '10.00000', ''),
(3, 2, '235.00000', 1, '2017-01-03 00:00:00', '2017-01-16 00:00:00', 'pac', '20.00000', ''),
(4, 2, '190.00000', 0, '2017-01-20 00:00:00', '2017-01-05 00:00:00', 'pac', '20.00000', ''),
(5, 1, '200.00000', 0, '2017-02-15 00:00:00', '2017-02-12 00:00:00', 'pac', '10.00000', ''),
(6, 1, '394.00000', 2, '2017-03-29 14:52:33', '2017-03-29 14:52:33', 'pac', '10.00000', 'PB427846718'),
(7, 1, '635.00000', 0, '2017-04-25 13:49:54', '2017-04-25 13:49:54', 'pac', '0.00000', ''),
(8, 1, '290.00000', 0, '2017-04-25 14:08:01', '2017-04-25 14:08:01', 'pac', '0.00000', ''),
(9, 1, '500.00000', 0, '2017-03-26 09:39:42', '2017-03-26 09:39:42', 'pac', '0.00000', ''),
(10, 1, '395.00000', 0, '2017-02-26 10:57:32', '2017-02-26 10:57:32', 'pac', '0.00000', ''),
(11, 1, '750.00000', 0, '2017-01-26 11:25:25', '2017-01-26 11:25:25', 'pac', '0.00000', ''),
(12, 1, '180.00000', 0, '2017-04-26 12:08:40', '2017-04-26 12:08:40', 'pac', '0.00000', ''),
(13, 1, '680.00000', 0, '2017-04-26 13:41:34', '2017-04-26 13:41:34', 'sedex', '0.00000', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_produtos`
--

CREATE TABLE `loja_produtos` (
  `id` int(11) NOT NULL,
  `img_padrao` varchar(200) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `categoria` varchar(200) NOT NULL,
  `subcategoria` varchar(200) NOT NULL,
  `valor_anterior` varchar(20) NOT NULL,
  `valor_atual` varchar(20) NOT NULL,
  `descricao` text NOT NULL,
  `peso` varchar(50) NOT NULL,
  `estoque` int(11) NOT NULL,
  `qtdVendidos` int(11) NOT NULL,
  `data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `loja_produtos`
--

INSERT INTO `loja_produtos` (`id`, `img_padrao`, `titulo`, `slug`, `categoria`, `subcategoria`, `valor_anterior`, `valor_atual`, `descricao`, `peso`, `estoque`, `qtdVendidos`, `data`) VALUES
(1, 'computador.png', 'Computador', 'computador', 'dvd', 'cursos', '', '500.00', 'Computador é uma máquina capaz de variados tipos de tratamento automático de informações ou processamento de dados. Um computador pode possuir inúmeros atributos, dentre eles armazenamento de dados, processamento de dados, cálculo em grande escala, desenho industrial, tratamento de imagens gráficas, realidade virtual, entretenimento e cultura.\r\n\r\nNo passado, o termo já foi aplicado a pessoas responsáveis por algum cálculo. Em geral, entende-se por computador um sistema físico que realiza algum tipo de computação. Existe ainda o conceito matemático rigoroso, utilizado na teoria da computação.\r\n\r\nAssumiu-se que os computadores pessoais e laptops são ícones da Era da Informação; e isto é o que muitas pessoas consideram como \"computador\". Entretanto, atualmente as formas mais comuns de computador em uso são os sistemas embarcados, pequenos dispositivos usados para controlar outros dispositivos, como robôs, câmeras digitais ou brinquedos.', '0.200', 149, 1, '2017-04-11 16:05:01'),
(2, 'brasil1.png', 'Brasil', 'brasil', 'dvd', 'cursos', '300.00000', '180.00000', 'Isso e um exemplo', '0.200', 89, 11, '2017-03-15 13:59:00'),
(3, 'cidade_grande.jpg', 'Alemanha', 'alemanha', 'dvd', 'cursos', '70.00', '60.00', 'Cidade da Alemanha', '0.200', 79, 1, '2017-04-03 00:00:00'),
(4, 'amsterda.png', 'Holanda', 'holanda', 'dvd', 'cursos', '300', '250', ' Holanda é uma nação constituinte do Reino dos Países Baixos localizada na Europa ocidental. O país é uma monarquia constitucional parlamentar democrática banhada pelo mar do Norte a norte e a oeste, que faz fronteira com a Bélgica a sul e com a Alemanha a leste. A capital é  Amsterdã a sede do governo é Haia.\r\n\r\nGeograficamente, os Países Baixos são um país de baixa altitude, com cerca de 27% de sua área e 60% de sua população situados abaixo do nível do mar. Uma significativa parte de seu território foi obtida através da recuperação e preservação de terras através de um elaborado sistema de pôlderes e diques. Grande parte dos Países Baixos é formada por um grande delta, o delta do Reno e Mosa.\r\n\r\nOs Países Baixos são um país densamente povoado que é conhecido por seus moinhos de vento, tulipas, tamancos, cerâmica de Delft, queijo gouda, artistas visuais, bicicletas. É um dos países com melhor qualidade de vida do mundo, fator pelo qual possui um dos melhores Índices de Desenvolvimento Humano da Europa e do mundo, segmentado em sua forte política de assistência social e direitos considerados essenciais, como educação, saúde e segurança de qualidade, garantidos em nível máximo a seus habitantes. O país possui uma das economias capitalistas mais livres do mundo — 15ª posição entre 177 países de acordo com o Índice de Liberdade Econômica em 2014.', '0.200', 93, 7, '2017-04-12 00:00:00'),
(5, 'canada.png', 'Canada', 'canada', 'dvd', 'cursos', '180.00', '145.00', '&lt;p&gt;Esse &amp;eacute; o Canada&lt;/p&gt;', '0.200', 96, 4, '2017-04-25 13:49:04'),
(6, 'Suecia.png', 'SuÃ©cia', 'suecia', 'dvd', 'cursos', '400.00', '380.00', '&lt;p&gt;Essa &amp;eacute; a Su&amp;eacute;cia&lt;/p&gt;', '0.200', 100, 0, '2017-05-11 14:32:32'),
(7, 'Toquio.png', 'JapÃ£o', 'japao', 'dvd', 'cursos', '500.00', '430.00', '&lt;p&gt;Esse &amp;eacute; o Jap&amp;atilde;o&lt;/p&gt;', '0.200', 100, 0, '2017-05-11 14:34:01'),
(8, 'Moscow.png', 'RÃºssia', 'russia', 'dvd', 'cursos', '490.00', '480.00', '&lt;p&gt;Essa &amp;eacute; a R&amp;uacute;ssia&lt;/p&gt;', '0.200', 100, 0, '2017-05-11 14:35:32'),
(9, 'dubai.png', 'Emirados Ãrabes Unidos', 'emirados-arabes-unidos', 'dvd', 'cursos', '900.00', '800.00', '&lt;p&gt;Esse &amp;eacute; o pa&amp;iacute;s Emirados &amp;Aacute;rabes Unidos (EAU)&lt;/p&gt;', '0.200', 100, 0, '2017-05-11 14:37:22'),
(10, 'Londres.png', 'Inglaterra', 'inglaterra', 'dvd', 'cursos', '540.00', '500.00', '&lt;p&gt;Essa &amp;eacute; a Inglaterra&lt;/p&gt;', '0.200', 100, 0, '2017-05-11 14:38:26'),
(11, 'sydney.png', 'AustrÃ¡lia', 'australia', 'dvd', 'cursos', '300.00', '280.00', '&lt;p&gt;Essa &amp;eacute; a Austr&amp;aacute;lia&lt;/p&gt;', '0.200', 100, 0, '2017-05-11 14:39:46');

-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_produtos_pedidos`
--

CREATE TABLE `loja_produtos_pedidos` (
  `id` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `qtd` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `loja_produtos_pedidos`
--

INSERT INTO `loja_produtos_pedidos` (`id`, `id_pedido`, `id_produto`, `qtd`) VALUES
(1, 6, 1, 7),
(2, 6, 2, 8),
(3, 5, 1, 4),
(4, 7, 2, 1),
(5, 7, 4, 1),
(6, 7, 5, 1),
(7, 7, 3, 1),
(8, 8, 5, 2),
(9, 9, 4, 2),
(10, 10, 4, 1),
(11, 10, 5, 1),
(12, 11, 4, 3),
(13, 12, 2, 1),
(14, 13, 1, 1),
(15, 13, 2, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_subcategorias`
--

CREATE TABLE `loja_subcategorias` (
  `id` int(11) NOT NULL,
  `id_cat` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `views` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `loja_subcategorias`
--

INSERT INTO `loja_subcategorias` (`id`, `id_cat`, `titulo`, `slug`, `views`) VALUES
(1, 1, 'Cursos', 'cursos', 152),
(2, 1, 'Comedia', 'comedia', 15),
(3, 1, 'Acao', 'acao', 0),
(4, 1, 'Suspense', 'suspense', 0),
(5, 2, 'Romantico', 'romantico', 10),
(6, 2, 'Metal', 'metal', 2),
(7, 2, 'Pop', 'pop', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_ticketresposta`
--

CREATE TABLE `loja_ticketresposta` (
  `id` int(11) NOT NULL,
  `de` varchar(60) NOT NULL,
  `idTicket` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `resposta` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `loja_ticketresposta`
--

INSERT INTO `loja_ticketresposta` (`id`, `de`, `idTicket`, `data`, `resposta`) VALUES
(1, 'adm', 1, '2017-03-26 00:00:00', 'Uma resposta para o ticket'),
(2, 'Lucas Santana', 1, '2017-04-05 00:00:00', 'Resposta do cliente'),
(3, 'Lucas  Santana Ferreira', 8, '2017-04-10 15:00:45', 'Problemas para receber o produto'),
(7, 'adm', 1, '2017-04-11 11:47:10', 'Outra resposta para o ticket 1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_tickets`
--

CREATE TABLE `loja_tickets` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `pergunta` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `modificado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `loja_tickets`
--

INSERT INTO `loja_tickets` (`id`, `id_cliente`, `pergunta`, `status`, `data`, `modificado`) VALUES
(1, 1, 'PC ruim', 2, '2017-04-07 14:10:20', '2017-04-11 11:50:00'),
(8, 1, 'Exemplo de Ticket', 1, '2017-04-07 18:38:34', '2017-04-07 18:38:34'),
(9, 1, 'Preciso resolver isso', 0, '2017-04-20 18:33:08', '2017-04-20 18:33:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `loja_adm`
--
ALTER TABLE `loja_adm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loja_banners`
--
ALTER TABLE `loja_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loja_categorias`
--
ALTER TABLE `loja_categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loja_clientes`
--
ALTER TABLE `loja_clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indexes for table `loja_imgprod`
--
ALTER TABLE `loja_imgprod`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loja_marcas`
--
ALTER TABLE `loja_marcas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loja_pedidos`
--
ALTER TABLE `loja_pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loja_produtos`
--
ALTER TABLE `loja_produtos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loja_produtos_pedidos`
--
ALTER TABLE `loja_produtos_pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loja_subcategorias`
--
ALTER TABLE `loja_subcategorias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loja_ticketresposta`
--
ALTER TABLE `loja_ticketresposta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loja_tickets`
--
ALTER TABLE `loja_tickets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `loja_adm`
--
ALTER TABLE `loja_adm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `loja_banners`
--
ALTER TABLE `loja_banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `loja_categorias`
--
ALTER TABLE `loja_categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `loja_clientes`
--
ALTER TABLE `loja_clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `loja_imgprod`
--
ALTER TABLE `loja_imgprod`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `loja_marcas`
--
ALTER TABLE `loja_marcas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `loja_pedidos`
--
ALTER TABLE `loja_pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `loja_produtos`
--
ALTER TABLE `loja_produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `loja_produtos_pedidos`
--
ALTER TABLE `loja_produtos_pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `loja_subcategorias`
--
ALTER TABLE `loja_subcategorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `loja_ticketresposta`
--
ALTER TABLE `loja_ticketresposta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `loja_tickets`
--
ALTER TABLE `loja_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
