-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Temps de generació: 27-05-2025 a les 12:32:54
-- Versió del servidor: 10.4.32-MariaDB
-- Versió de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de dades: `elspratsdor`
--

-- --------------------------------------------------------

--
-- Estructura de la taula `alimentació`
--

CREATE TABLE `alimentació` (
  `id_animal` int(11) NOT NULL,
  `id_aliment` int(11) NOT NULL,
  `data_hora` datetime NOT NULL,
  `quantitat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Bolcament de dades per a la taula `alimentació`
--

INSERT INTO `alimentació` (`id_animal`, `id_aliment`, `data_hora`, `quantitat`) VALUES
(1, 1, '2025-05-23 08:00:00', 20),
(2, 5, '2025-05-23 09:00:00', 15),
(3, 6, '2025-05-24 07:30:00', 12),
(4, 8, '2025-05-24 10:15:00', 8),
(5, 4, '2025-05-25 11:00:00', 25),
(6, 2, '2025-05-26 14:00:00', 10),
(7, 9, '2025-05-27 15:30:00', 6),
(8, 14, '2025-05-28 16:45:00', 3),
(9, 15, '2025-05-29 17:00:00', 2),
(10, 27, '2025-05-30 18:30:00', 1);

-- --------------------------------------------------------

--
-- Estructura de la taula `aliments`
--

CREATE TABLE `aliments` (
  `id_aliment` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `tipus` varchar(30) NOT NULL,
  `stock` int(11) NOT NULL,
  `data_caducitat` date NOT NULL,
  `preu` decimal(10,2) NOT NULL,
  `unitat` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Bolcament de dades per a la taula `aliments`
--

INSERT INTO `aliments` (`id_aliment`, `nom`, `tipus`, `stock`, `data_caducitat`, `preu`, `unitat`) VALUES
(1, 'Blat', 'Cereal', 1000, '2025-06-01', 1.20, 'kg'),
(2, 'Civada', 'Cereal', 1000, '2025-05-30', 2.60, 'kg'),
(3, 'Llet', 'Làctics', 800, '2025-07-15', 1.20, 'litre'),
(4, 'Farratge', 'Herba', 700, '2025-07-10', 4.50, 'bala'),
(5, 'Ordi', 'Cereal', 600, '2025-08-05', 1.80, 'kg'),
(6, 'Herba fresca', 'Herba', 300, '2025-09-12', 3.20, 'kg'),
(8, 'Alfals', 'Herba', 250, '2025-11-05', 5.00, 'bala'),
(9, 'Sègol', 'Cereal', 150, '2025-12-15', 1.50, 'kg'),
(10, 'Enciam', 'Hortalissa', 300, '2025-05-20', 0.90, 'unitat'),
(11, 'Tomàquet', 'Hortalissa', 500, '2025-05-22', 1.10, 'kg'),
(12, 'Carbassó', 'Hortalissa', 400, '2025-05-24', 1.00, 'kg'),
(13, 'Pebrot verd', 'Hortalissa', 350, '2025-05-25', 1.20, 'kg'),
(14, 'Patata', 'Hortalissa', 600, '2025-06-10', 0.80, 'kg'),
(15, 'Ceba', 'Hortalissa', 450, '2025-06-15', 0.75, 'kg'),
(16, 'Pastanaga', 'Hortalissa', 300, '2025-06-20', 0.85, 'kg'),
(17, 'Maduixa', 'Fruita', 200, '2025-05-19', 2.20, 'kg'),
(18, 'Poma', 'Fruita', 250, '2025-06-05', 1.30, 'kg'),
(19, 'Figa', 'Fruita', 180, '2025-06-12', 2.50, 'kg'),
(20, 'Ous frescos', 'Avícola', 500, '2025-05-28', 2.40, 'dotzena'),
(21, 'Mel', 'Mel', 100, '2026-01-01', 4.50, 'pot'),
(22, 'Melmelada de maduixa', 'Conserva', 80, '2026-02-01', 3.20, 'pot'),
(23, 'Melmelada de figa', 'Conserva', 60, '2026-03-01', 3.50, 'pot'),
(24, 'Conserva de tomàquet', 'Conserva', 120, '2026-04-01', 2.90, 'pot'),
(25, 'Formatge fresc', 'Làctics', 100, '2025-06-07', 3.80, 'unitat'),
(26, 'Brou de verdures', 'Conserva', 90, '2025-08-01', 3.00, 'ampolla'),
(27, 'All', 'Hortalissa', 250, '2025-08-20', 1.00, 'kg'),
(28, 'Julivert', 'Hortalissa', 200, '2025-05-21', 0.60, 'manat'),
(29, 'Alfàbrega', 'Hortalissa', 180, '2025-05-21', 0.70, 'manat');

-- --------------------------------------------------------

--
-- Estructura de la taula `animals`
--

CREATE TABLE `animals` (
  `id_animal` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `especie` varchar(30) NOT NULL,
  `data_naixement` date NOT NULL,
  `id_client` int(11) NOT NULL,
  `preu_venta` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Bolcament de dades per a la taula `animals`
--

INSERT INTO `animals` (`id_animal`, `nom`, `especie`, `data_naixement`, `id_client`, `preu_venta`) VALUES
(1, 'Lola', 'Vaca', '2020-03-15', 1, 1200.00),
(2, 'Joan', 'Porc', '2021-07-20', 2, 300.00),
(3, 'Pepa', 'Gallina', '2022-01-10', 3, 25.00),
(4, 'Guillem', 'Conill', '2023-09-05', 4, 50.00),
(5, 'Thor', 'Cavall', '2018-11-12', 1, 2500.00),
(6, 'Luna', 'Ovella', '2022-04-18', 2, 400.00),
(7, 'Rex', 'Gos', '2023-02-28', 3, 600.00),
(8, 'Mia', 'Gat', '2024-01-15', 4, 300.00),
(9, 'Toby', 'Ase', '2019-05-05', 1, 800.00),
(10, 'Nala', 'Cabrum', '2021-08-20', 2, 450.00);

-- --------------------------------------------------------

--
-- Estructura de la taula `clients`
--

CREATE TABLE `clients` (
  `id_client` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `telefon` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `adreca` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Bolcament de dades per a la taula `clients`
--

INSERT INTO `clients` (`id_client`, `nom`, `telefon`, `email`, `adreca`) VALUES
(1, 'Joan Manel', '612345678', 'joan@gmail.com', 'Carrer Major, 10, Barcelona'),
(2, 'Maria Gorgo', '623456789', 'maria@hotmail.com', 'Avinguda Diagonal, 20, Barcelona'),
(3, 'Pere Goia', '634567890', 'pere@gmail.com', 'Rambla Catalunya, 30, Barcelona'),
(4, 'Laura Fidel', '645678901', 'laura@gmail.com', 'Carrer de Balmes, 40, Barcelona'),
(5, 'Sergi Molina', '656789012', 'sergi@gmail.com', 'Carrer Provença, 50, Barcelona'),
(6, 'Elena Vidal', '667890123', 'elena@hotmail.com', 'Passeig de Gràcia, 60, Barcelona'),
(7, 'Marc Torres', '678901234', 'marc@gmail.com', 'Carrer Mallorca, 70, Barcelona'),
(8, 'Carla Bosch', '689012345', 'carla@gmail.com', 'Carrer València, 80, Barcelona'),
(9, 'Pol Navarro', '690123456', 'pol@gmail.com', 'Carrer Aragó, 90, Barcelona'),
(10, 'Aina Serra', '601234567', 'aina@gmail.com', 'Carrer Muntaner, 100, Barcelona');

--
-- Índexs per a les taules bolcades
--

--
-- Índexs per a la taula `alimentació`
--
ALTER TABLE `alimentació`
  ADD PRIMARY KEY (`id_animal`,`id_aliment`,`data_hora`),
  ADD KEY `id_animal` (`id_animal`,`id_aliment`),
  ADD KEY `id_aliment` (`id_aliment`);

--
-- Índexs per a la taula `aliments`
--
ALTER TABLE `aliments`
  ADD PRIMARY KEY (`id_aliment`);

--
-- Índexs per a la taula `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id_animal`),
  ADD KEY `id_client` (`id_client`);

--
-- Índexs per a la taula `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id_client`);

--
-- AUTO_INCREMENT per les taules bolcades
--

--
-- AUTO_INCREMENT per la taula `aliments`
--
ALTER TABLE `aliments`
  MODIFY `id_aliment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT per la taula `animals`
--
ALTER TABLE `animals`
  MODIFY `id_animal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la taula `clients`
--
ALTER TABLE `clients`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restriccions per a les taules bolcades
--

--
-- Restriccions per a la taula `alimentació`
--
ALTER TABLE `alimentació`
  ADD CONSTRAINT `alimentació_ibfk_1` FOREIGN KEY (`id_aliment`) REFERENCES `aliments` (`id_aliment`),
  ADD CONSTRAINT `alimentació_ibfk_2` FOREIGN KEY (`id_animal`) REFERENCES `animals` (`id_animal`);

--
-- Restriccions per a la taula `animals`
--
ALTER TABLE `animals`
  ADD CONSTRAINT `animals_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id_client`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
