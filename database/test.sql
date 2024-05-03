SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Table structure for table `address_base`
--

CREATE TABLE `address_base` (
  `id` int(11) NOT NULL,
  `cep` char(9) NOT NULL,
  `street` varchar(100) NOT NULL,
  `houseNumber` int(11) NOT NULL,
  `neighborhood` varchar(100) NOT NULL,
  `uf` char(2) NOT NULL,
  `city` varchar(100) NOT NULL,
  `idClient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `cpf` char(15) NOT NULL,
  `sex` char(1) NOT NULL,
  `birthday` date NOT NULL,
  `maritalStatus` varchar(25) NOT NULL,
  `email` varchar(70) NOT NULL,
  `phone` char(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address_base`
--
ALTER TABLE `address_base`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idClient` (`idClient`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address_base`
--
ALTER TABLE `address_base`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address_base`
--
ALTER TABLE `address_base`
  ADD CONSTRAINT `address_base_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `client` (`id`);
COMMIT;
