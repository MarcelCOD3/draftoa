-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-10-2025 a las 18:18:00
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `fallback_questions` (
  `id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `fallback_questions` (`id`, `question`, `answer`) VALUES
(1, '¿Cómo se juega a Draftosaurus?', 'Draftosaurus es un juego de draft de dinosaurios. En cada turno, tomas un dinosaurio de tu mano, lo colocas en tu tablero de zoológico siguiendo ciertas reglas y luego pasas los dinosaurios restantes al siguiente jugador.'),
(2, '¿Cuántas rondas tiene el juego?', 'El juego base se juega en dos rondas. En cada ronda, cada jugador colocará seis dinosaurios.'),
(3, '¿Qué hace el dado de colocación?', 'Al principio de cada turno, el jugador activo lanza el dado. La cara del dado indica una restricción de colocación que todos los jugadores, excepto el que ha lanzado el dado, deben seguir.'),
(4, '¿Cuántos jugadores pueden jugar?', 'El juego de mesa Draftosaurus es para 2 a 5 jugadores.'),
(5, '¿Para qué sirven los T-Rex?', 'Cada recinto de tu zoológico que contenga al menos un T-Rex te otorgará un punto de victoria adicional al final de la partida.');

-- Índices para tablas volcadas

ALTER TABLE `fallback_questions`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `fallback_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;