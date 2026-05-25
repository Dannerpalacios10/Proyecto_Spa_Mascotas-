-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-05-2026 a las 04:53:42
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `spa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria`
--

CREATE TABLE `auditoria` (
  `id_auditoria` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `accion` varchar(255) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `ip_usuario` varchar(100) DEFAULT NULL,
  `navegador` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `auditoria`
--

INSERT INTO `auditoria` (`id_auditoria`, `id_usuario`, `accion`, `fecha`, `ip_usuario`, `navegador`) VALUES
(1, NULL, 'Inicio de sesión', '2026-05-14 12:42:38', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(2, NULL, 'Cerró sesión del sistema', '2026-05-14 12:42:41', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(3, 10, 'Inicio de sesión ADMIN', '2026-05-14 12:50:33', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(4, 10, 'Inicio de sesión ADMIN', '2026-05-14 13:12:06', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(5, 10, 'Cerró sesión del sistema', '2026-05-14 13:13:33', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(6, 10, 'Inicio de sesión ADMIN', '2026-05-14 13:14:17', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(132, 10, 'Cerró sesión del sistema', '2026-05-21 13:44:50', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(133, 10, 'Inicio de sesión ADMIN', '2026-05-21 13:45:35', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(134, 10, 'Cerró sesión del sistema', '2026-05-21 13:45:55', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(135, 14, 'Inicio de sesión', '2026-05-21 13:49:02', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(136, 14, 'Cerró sesión del sistema', '2026-05-21 13:49:10', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(137, 14, 'Inicio de sesión', '2026-05-21 16:29:03', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(138, 14, 'Inicio de sesión', '2026-05-21 17:10:29', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(139, 14, 'Cerró sesión del sistema', '2026-05-21 17:36:48', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(140, 12, 'Inicio de sesión', '2026-05-21 17:37:14', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(141, 12, 'Cerró sesión del sistema', '2026-05-21 17:41:07', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(142, 11, 'Inicio de sesión', '2026-05-21 17:41:22', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(143, 14, 'Inicio de sesión', '2026-05-21 17:43:50', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(144, 12, 'Inicio de sesión', '2026-05-21 17:44:27', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(145, 14, 'Inicio de sesión', '2026-05-21 17:46:12', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(146, 11, 'Inicio de sesión', '2026-05-21 17:46:50', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(147, 14, 'Inicio de sesión', '2026-05-21 18:04:02', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(148, 12, 'Inicio de sesión', '2026-05-21 18:06:41', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(149, 11, 'Inicio de sesión', '2026-05-21 18:17:21', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(150, 12, 'Inicio de sesión', '2026-05-21 18:17:56', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(151, 12, 'Cerró sesión del sistema', '2026-05-21 18:22:00', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(152, 14, 'Inicio de sesión', '2026-05-21 18:22:40', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(153, 11, 'Inicio de sesión', '2026-05-21 18:23:14', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(154, 12, 'Inicio de sesión', '2026-05-21 18:45:17', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(155, 11, 'Inicio de sesión', '2026-05-21 18:46:05', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(156, 11, 'Cerró sesión del sistema', '2026-05-21 18:46:18', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(157, 14, 'Inicio de sesión', '2026-05-21 18:46:41', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(158, 12, 'Inicio de sesión', '2026-05-21 18:48:29', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(159, 14, 'Inicio de sesión', '2026-05-21 18:49:55', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(160, 14, 'Cerró sesión del sistema', '2026-05-21 18:54:56', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(161, 12, 'Inicio de sesión', '2026-05-21 18:55:29', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(162, 14, 'Inicio de sesión', '2026-05-21 18:56:30', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(163, 11, 'Inicio de sesión', '2026-05-21 18:57:08', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(164, 14, 'Inicio de sesión', '2026-05-21 19:02:30', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(165, 11, 'Inicio de sesión', '2026-05-21 19:23:16', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(166, 11, 'Cerró sesión del sistema', '2026-05-21 19:27:19', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(167, 11, 'Inicio de sesión', '2026-05-21 19:27:53', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(168, 11, 'Cerró sesión del sistema', '2026-05-21 19:51:00', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(169, 14, 'Inicio de sesión', '2026-05-21 19:52:49', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(170, 14, 'Cerró sesión del sistema', '2026-05-21 19:56:32', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(171, 11, 'Inicio de sesión', '2026-05-21 19:56:47', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(172, 12, 'Inicio de sesión', '2026-05-21 19:57:09', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(173, 11, 'Inicio de sesión', '2026-05-21 19:58:05', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(174, 14, 'Inicio de sesión', '2026-05-21 20:02:55', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(175, 12, 'Inicio de sesión', '2026-05-21 20:03:37', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(176, 14, 'Inicio de sesión', '2026-05-21 20:04:14', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(177, 12, 'Inicio de sesión', '2026-05-21 20:05:23', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(178, 11, 'Inicio de sesión', '2026-05-21 20:05:53', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(179, 14, 'Inicio de sesión', '2026-05-21 20:07:29', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(180, 12, 'Inicio de sesión', '2026-05-21 20:07:51', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(181, 11, 'Inicio de sesión', '2026-05-21 20:15:36', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(182, 11, 'Cerró sesión del sistema', '2026-05-21 20:31:10', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(183, 11, 'Inicio de sesión', '2026-05-21 20:31:24', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(184, 11, 'Inicio de sesión', '2026-05-21 20:32:56', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(185, 12, 'Inicio de sesión', '2026-05-21 21:12:05', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(186, 14, 'Inicio de sesión', '2026-05-21 21:12:29', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(187, 12, 'Inicio de sesión', '2026-05-21 21:22:00', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(188, 11, 'Inicio de sesión', '2026-05-21 21:24:48', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(189, 12, 'Inicio de sesión', '2026-05-21 21:27:27', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(190, 14, 'Inicio de sesión', '2026-05-21 21:27:53', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(191, 12, 'Inicio de sesión', '2026-05-21 21:35:25', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(192, 12, 'Cerró sesión del sistema', '2026-05-21 21:42:18', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(193, 11, 'Inicio de sesión', '2026-05-21 21:42:39', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(194, 11, 'Cerró sesión del sistema', '2026-05-21 21:44:38', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(195, 12, 'Inicio de sesión', '2026-05-21 21:44:51', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(196, 14, 'Inicio de sesión', '2026-05-21 21:47:52', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(197, 14, 'Cerró sesión del sistema', '2026-05-21 22:02:39', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(198, 12, 'Inicio de sesión', '2026-05-21 22:03:24', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(199, 12, 'Cerró sesión del sistema', '2026-05-21 22:09:27', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(200, 12, 'Inicio de sesión', '2026-05-21 22:10:44', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(201, 12, 'Inicio de sesión', '2026-05-21 22:46:27', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(202, 12, 'Inicio de sesión', '2026-05-22 09:28:59', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(203, 12, 'Inicio de sesión', '2026-05-22 09:35:53', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(204, 12, 'Inicio de sesión', '2026-05-22 09:36:52', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(205, 12, 'Inicio de sesión', '2026-05-22 10:14:11', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(206, 12, 'Inicio de sesión', '2026-05-22 10:30:28', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(207, 11, 'Inicio de sesión', '2026-05-22 10:31:56', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(208, 12, 'Inicio de sesión', '2026-05-22 10:34:01', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(209, 12, 'Cerró sesión del sistema', '2026-05-22 10:57:29', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(210, 14, 'Inicio de sesión', '2026-05-22 10:58:03', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(211, 14, 'Cerró sesión del sistema', '2026-05-22 11:22:12', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(212, 11, 'Inicio de sesión', '2026-05-22 11:22:31', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(213, 11, 'Cerró sesión del sistema', '2026-05-22 11:24:02', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(214, 12, 'Inicio de sesión', '2026-05-22 11:24:17', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(215, 12, 'Inicio de sesión', '2026-05-22 11:26:55', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(216, 12, 'Cerró sesión del sistema', '2026-05-22 14:08:51', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(217, 12, 'Inicio de sesión', '2026-05-22 14:09:08', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(218, 12, 'Inicio de sesión', '2026-05-22 14:48:16', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(219, 12, 'Cerró sesión del sistema', '2026-05-22 15:21:26', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(220, 10, 'Inicio de sesión ADMIN', '2026-05-22 15:22:58', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(221, 10, 'Cerró sesión del sistema', '2026-05-22 15:30:50', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(222, 11, 'Inicio de sesión', '2026-05-22 15:31:09', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(223, 12, 'Inicio de sesión', '2026-05-22 15:41:18', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(224, 11, 'Inicio de sesión', '2026-05-22 15:44:59', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(225, 12, 'Inicio de sesión', '2026-05-22 15:45:30', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(226, 11, 'Inicio de sesión', '2026-05-22 15:57:12', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(227, 11, 'Cerró sesión del sistema', '2026-05-22 15:59:38', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(228, 14, 'Inicio de sesión', '2026-05-22 16:07:37', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(229, 14, 'Cerró sesión del sistema', '2026-05-22 16:13:32', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(230, 14, 'Inicio de sesión', '2026-05-22 17:00:01', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(231, 14, 'Cerró sesión del sistema', '2026-05-22 17:07:28', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(232, 11, 'Inicio de sesión', '2026-05-22 17:07:44', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(233, 11, 'Cerró sesión del sistema', '2026-05-22 17:07:49', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(234, 12, 'Inicio de sesión', '2026-05-22 17:08:01', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(235, 12, 'Cerró sesión del sistema', '2026-05-22 17:09:47', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(236, 11, 'Inicio de sesión', '2026-05-22 17:10:02', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(237, 14, 'Inicio de sesión', '2026-05-24 19:18:57', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(238, 11, 'Inicio de sesión', '2026-05-24 19:19:56', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(239, 12, 'Inicio de sesión', '2026-05-24 19:20:20', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(240, 11, 'Inicio de sesión', '2026-05-24 19:21:26', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(241, 14, 'Inicio de sesión', '2026-05-24 19:23:05', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(242, 12, 'Inicio de sesión', '2026-05-24 19:26:50', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(243, 11, 'Inicio de sesión', '2026-05-24 19:36:32', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(244, 12, 'Inicio de sesión', '2026-05-24 20:00:18', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(245, 14, 'Inicio de sesión', '2026-05-24 20:27:47', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(246, 14, 'Cerró sesión del sistema', '2026-05-24 20:31:53', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(247, 11, 'Inicio de sesión', '2026-05-24 20:32:06', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(248, 12, 'Inicio de sesión', '2026-05-24 20:32:31', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(249, 11, 'Inicio de sesión', '2026-05-24 20:32:55', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(250, 14, 'Inicio de sesión', '2026-05-24 20:33:36', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(251, 14, 'Cerró sesión del sistema', '2026-05-24 21:08:57', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(252, 11, 'Inicio de sesión', '2026-05-24 21:09:10', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(253, 11, 'Cerró sesión del sistema', '2026-05-24 21:18:01', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(254, 14, 'Inicio de sesión', '2026-05-24 21:18:31', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(255, 14, 'Cerró sesión del sistema', '2026-05-24 21:47:48', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(256, 14, 'Inicio de sesión', '2026-05-24 21:48:02', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(257, 14, 'Inicio de sesión', '2026-05-24 21:49:01', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(258, 14, 'Inicio de sesión', '2026-05-24 21:58:36', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(259, 14, 'Cerró sesión del sistema', '2026-05-24 22:32:08', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(260, 14, 'Inicio de sesión', '2026-05-24 22:33:11', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(261, 14, 'Cerró sesión del sistema', '2026-05-24 22:35:13', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(262, 12, 'Inicio de sesión', '2026-05-24 22:35:31', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(263, 12, 'Cerró sesión del sistema', '2026-05-24 22:36:04', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(264, 11, 'Inicio de sesión', '2026-05-24 22:36:27', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(265, 14, 'Inicio de sesión', '2026-05-24 22:40:13', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(266, 14, 'Cerró sesión del sistema', '2026-05-24 22:40:59', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(267, 12, 'Inicio de sesión', '2026-05-24 22:41:19', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(268, 12, 'Cerró sesión del sistema', '2026-05-24 22:41:48', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(269, 14, 'Inicio de sesión', '2026-05-24 22:42:03', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(270, 14, 'Cerró sesión del sistema', '2026-05-24 22:42:20', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(271, 14, 'Inicio de sesión', '2026-05-24 22:42:35', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(272, 14, 'Cerró sesión del sistema', '2026-05-24 22:44:39', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(273, 12, 'Inicio de sesión', '2026-05-24 22:45:09', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(274, 12, 'Cerró sesión del sistema', '2026-05-24 22:45:30', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36'),
(275, 11, 'Inicio de sesión', '2026-05-24 22:45:43', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bloqueos`
--

CREATE TABLE `bloqueos` (
  `id_bloqueo` int(11) NOT NULL,
  `tipo` enum('feriado','mantenimiento','descanso') NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bloqueos`
--

INSERT INTO `bloqueos` (`id_bloqueo`, `tipo`, `fecha`, `descripcion`) VALUES
(1, 'feriado', '2026-05-22', 'Por dia del Estado Plurinacional no habra atencion Gracias '),
(2, 'descanso', '2026-05-22', 'Hora de descanso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bloqueo_horario`
--

CREATE TABLE `bloqueo_horario` (
  `id_bloqueo` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL,
  `motivo` varchar(255) DEFAULT NULL,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `id_groomer` int(11) DEFAULT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_fin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id_carrito` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `session_token` varchar(255) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `padre_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nombre`, `padre_id`) VALUES
(1, 'Shampoo', NULL),
(2, 'Alimento', NULL),
(3, 'Juguetes', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_producto`
--

CREATE TABLE `categoria_producto` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria_producto`
--

INSERT INTO `categoria_producto` (`id_categoria`, `nombre`) VALUES
(1, 'Shampoos'),
(2, 'Accesorios'),
(3, 'Juguetes'),
(4, 'Perros'),
(5, 'Gatos'),
(6, 'Limpieza');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `checklist_grooming`
--

CREATE TABLE `checklist_grooming` (
  `id_checklist` int(11) NOT NULL,
  `id_ficha` int(11) NOT NULL,
  `unas` tinyint(1) DEFAULT 0,
  `oidos` tinyint(1) DEFAULT 0,
  `glandulas` tinyint(1) DEFAULT 0,
  `corte` tinyint(1) DEFAULT 0,
  `bano` tinyint(1) DEFAULT 0,
  `perfume` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

CREATE TABLE `cita` (
  `id_cita` int(11) NOT NULL,
  `id_mascota` int(11) DEFAULT NULL,
  `id_groomer` int(11) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `motivo_cancelacion` text DEFAULT NULL,
  `politica_aceptada` tinyint(1) DEFAULT 0,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('PENDIENTE','AGENDADA','CANCELADA') DEFAULT 'PENDIENTE',
  `creado_por` int(11) DEFAULT NULL,
  `reprogramado_por` int(11) DEFAULT NULL,
  `fecha_reprogramacion` datetime DEFAULT NULL,
  `duracion_real` int(11) DEFAULT NULL,
  `fecha_cancelacion` datetime DEFAULT NULL,
  `cancelado_por` int(11) DEFAULT NULL,
  `mensaje_recepcion` text DEFAULT NULL,
  `leido_cliente` tinyint(1) DEFAULT 0,
  `notificado` tinyint(1) DEFAULT 0,
  `fecha_confirmacion` datetime DEFAULT NULL,
  `confirmado_por` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cita`
--

INSERT INTO `cita` (`id_cita`, `id_mascota`, `id_groomer`, `id_servicio`, `fecha_inicio`, `fecha_fin`, `observaciones`, `motivo_cancelacion`, `politica_aceptada`, `fecha_creacion`, `estado`, `creado_por`, `reprogramado_por`, `fecha_reprogramacion`, `duracion_real`, `fecha_cancelacion`, `cancelado_por`, `mensaje_recepcion`, `leido_cliente`, `notificado`, `fecha_confirmacion`, `confirmado_por`) VALUES
(12, 7, 11, 1, '2026-05-21 14:00:00', '2026-05-21 15:00:00', NULL, NULL, 0, '2026-05-21 22:54:49', '', 14, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '2026-05-21 18:55:56', 12),
(13, 8, 11, 4, '2026-05-21 14:00:00', '2026-05-21 16:30:00', NULL, NULL, 0, '2026-05-21 23:55:20', '', 14, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '2026-05-21 19:57:37', 12),
(14, 7, NULL, 3, '2026-05-21 14:00:00', '2026-05-21 14:45:00', NULL, NULL, 0, '2026-05-21 23:55:54', 'CANCELADA', 14, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL),
(15, 7, 11, 4, '2026-05-21 15:00:00', '2026-05-21 17:30:00', NULL, NULL, 0, '2026-05-22 00:05:04', '', 14, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '2026-05-21 20:07:55', 12),
(16, 7, 11, 2, '2026-05-22 18:00:00', '2026-05-22 19:30:00', NULL, NULL, 0, '2026-05-22 21:07:14', '', 14, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '2026-05-22 17:08:08', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita_servicio`
--

CREATE TABLE `cita_servicio` (
  `id_cita` int(11) NOT NULL,
  `id_servicio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_carrito`
--

CREATE TABLE `detalle_carrito` (
  `id_detalle` int(11) NOT NULL,
  `id_carrito` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `id_variante` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_unitario` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id_factura` int(11) NOT NULL,
  `numero` varchar(50) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `impuesto` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `estado` enum('PENDIENTE','PAGADA','CANCELADA') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ficha_grooming`
--

CREATE TABLE `ficha_grooming` (
  `id_ficha` int(11) NOT NULL,
  `id_cita` int(11) DEFAULT NULL,
  `estado_ingreso` text DEFAULT NULL,
  `comportamiento` enum('TRANQUILO','NERVIOSO','AGRESIVO','INQUIETO') DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `check_bano` tinyint(1) DEFAULT 0,
  `check_corte` tinyint(1) DEFAULT 0,
  `check_unas` tinyint(1) DEFAULT 0,
  `check_oidos` tinyint(1) DEFAULT 0,
  `check_glandulas` tinyint(1) DEFAULT 0,
  `check_perfume` tinyint(1) DEFAULT 0,
  `foto_antes` varchar(255) DEFAULT NULL,
  `foto_despues` varchar(255) DEFAULT NULL,
  `recomendaciones` text DEFAULT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `raza_tamano` varchar(100) DEFAULT NULL,
  `temperatura` decimal(4,2) DEFAULT NULL,
  `notas_internas` text DEFAULT NULL,
  `consumido_inventario` tinyint(1) DEFAULT 0,
  `fecha_cierre` datetime DEFAULT NULL,
  `estado_final` enum('EN_PROCESO','FINALIZADO') DEFAULT 'EN_PROCESO',
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ficha_grooming`
--

INSERT INTO `ficha_grooming` (`id_ficha`, `id_cita`, `estado_ingreso`, `comportamiento`, `observaciones`, `check_bano`, `check_corte`, `check_unas`, `check_oidos`, `check_glandulas`, `check_perfume`, `foto_antes`, `foto_despues`, `recomendaciones`, `fecha_inicio`, `raza_tamano`, `temperatura`, `notas_internas`, `consumido_inventario`, `fecha_cierre`, `estado_final`, `creado_en`) VALUES
(3, 12, 'Con pelo largo', NULL, 'NN', 1, 0, 0, 0, 0, 0, '1779404505_antes_Pensum26.jpg', '1779404505_despues_Pensum26.jpg', 'Shampoo', '2026-05-21 19:01:45', NULL, NULL, NULL, 0, '2026-05-21 19:01:45', 'FINALIZADO', '2026-05-21 23:01:45'),
(4, 13, 'CON PELO SUCIO ', NULL, 'NN', 1, 1, 1, 1, 1, 1, '1779408406_antes_Pensum26.jpg', '1779408406_despues_Pensum26.jpg', 'NN', '2026-05-21 20:06:46', NULL, NULL, NULL, 0, '2026-05-21 20:06:46', 'FINALIZADO', '2026-05-22 00:06:46'),
(5, 15, 'EN BUEN ESTADO', NULL, 'NN', 1, 1, 1, 1, 1, 1, '1779409037_antes_Pensum26.jpg', '1779409037_despues_Pensum26.jpg', 'NN', '2026-05-21 20:17:17', NULL, NULL, NULL, 0, '2026-05-21 20:17:17', 'FINALIZADO', '2026-05-22 00:17:17'),
(6, 16, 'NN', NULL, 'NN', 1, 0, 0, 0, 0, 0, '1779484849_antes_Pensum26.jpg', '1779484849_despues_Pensum26.jpg', 'NN', '2026-05-22 17:20:49', NULL, NULL, NULL, 0, '2026-05-22 17:20:49', 'FINALIZADO', '2026-05-22 21:20:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foto_mascota`
--

CREATE TABLE `foto_mascota` (
  `id_foto` int(11) NOT NULL,
  `id_ficha` int(11) DEFAULT NULL,
  `tipo` enum('ANTES','DESPUES') DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groomer`
--

CREATE TABLE `groomer` (
  `id_groomer` int(11) NOT NULL,
  `especialidad` varchar(100) DEFAULT NULL,
  `capacidad_simultanea` int(11) DEFAULT NULL,
  `horario` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`horario`)),
  `estado_activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_mascota`
--

CREATE TABLE `historial_mascota` (
  `id_historial` int(11) NOT NULL,
  `id_mascota` int(11) DEFAULT NULL,
  `tipo_evento` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id_insumo` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `unidad` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mascota`
--

CREATE TABLE `mascota` (
  `id_mascota` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `especie` varchar(50) DEFAULT NULL,
  `sexo` enum('MACHO','HEMBRA') DEFAULT NULL,
  `raza` varchar(100) DEFAULT NULL,
  `tamano` enum('PEQUEÑO','MEDIANO','GRANDE','GIGANTE') DEFAULT NULL,
  `peso` decimal(5,2) DEFAULT NULL,
  `temperamento` enum('TRANQUILO','NERVIOSO','AGRESIVO','INQUIETO') DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `restricciones` text DEFAULT NULL,
  `alergias` text DEFAULT NULL,
  `carnet_vacunas` varchar(255) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mascota`
--

INSERT INTO `mascota` (`id_mascota`, `nombre`, `especie`, `sexo`, `raza`, `tamano`, `peso`, `temperamento`, `fecha_nacimiento`, `restricciones`, `alergias`, `carnet_vacunas`, `id_cliente`, `fecha_registro`) VALUES
(7, 'Zeus', 'Gato', NULL, 'Chapi', 'PEQUEÑO', 10.00, 'TRANQUILO', '2026-05-01', 'NN', 'NN', '../uploads/carnets/1779403867_Autoevaluacion.pdf', 14, '2026-05-21 22:51:07'),
(8, 'Beyli', 'Perro', NULL, 'Chapi', 'MEDIANO', 25.00, 'TRANQUILO', '2025-01-01', 'NN', 'NN', '../uploads/carnets/1779407688_Autoevaluacion.pdf', 14, '2026-05-21 23:54:48'),
(10, 'Luna', 'Gato', NULL, 'Chapi', 'PEQUEÑO', 10.00, 'TRANQUILO', '2026-01-01', 'NN', 'NN', '../uploads/carnets/1779677012_Autoevaluacion.pdf', 14, '2026-05-25 02:43:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mascota_dueno`
--

CREATE TABLE `mascota_dueno` (
  `id_mascota` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacion`
--

CREATE TABLE `notificacion` (
  `id_notificacion` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `tipo_evento` varchar(50) DEFAULT NULL,
  `canal` varchar(50) DEFAULT NULL,
  `destino` varchar(100) DEFAULT NULL,
  `fecha_programacion` datetime DEFAULT NULL,
  `fecha_envio` datetime DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `id_pago` int(11) NOT NULL,
  `id_factura` int(11) DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `metodo` varchar(50) DEFAULT NULL,
  `referencia` varchar(100) DEFAULT NULL,
  `estado` enum('COMPLETADO','PENDIENTE','FALLIDO') DEFAULT NULL,
  `id_cita` int(11) NOT NULL,
  `metodo_pago` varchar(50) DEFAULT NULL,
  `fecha_pago` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`id_pago`, `id_factura`, `monto`, `metodo`, `referencia`, `estado`, `id_cita`, `metodo_pago`, `fecha_pago`) VALUES
(1, NULL, 70.00, NULL, 'NN', NULL, 16, 'QR', '2026-05-22 17:09:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `sku` varchar(50) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `stock_minimo` int(11) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `id_categoria` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `estado` enum('DISPONIBLE','NO_DISPONIBLE') DEFAULT 'DISPONIBLE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre`, `sku`, `stock`, `stock_minimo`, `imagen`, `id_categoria`, `descripcion`, `precio`, `estado`) VALUES
(3, 'Shampoo Canino', 'SKU001', 20, 5, '', 3, NULL, NULL, 'DISPONIBLE'),
(4, 'Croquetas Premium', 'SKU002', 50, 10, '', 2, NULL, NULL, 'DISPONIBLE'),
(5, 'Pelota de Goma', 'SKU003', 30, 5, '', 3, NULL, NULL, 'DISPONIBLE'),
(6, 'adad', '123d', 22, 22, '', 1, NULL, NULL, 'DISPONIBLE'),
(7, 'fdaf', 'adfa', -1, 1, '', 1, NULL, NULL, 'DISPONIBLE'),
(8, 'Collar Premium Perro', NULL, 20, NULL, 'collar_perro.jpg', 1, 'Collar resistente y cómodo para perros grandes y pequeños.', 45.00, 'DISPONIBLE'),
(9, 'Correa Profesional', NULL, 15, NULL, 'correa.jpg', 1, 'Correa reforzada ideal para paseos diarios.', 60.00, 'DISPONIBLE'),
(10, 'Cama Deluxe Canina', NULL, 10, NULL, 'cama_perro.jpg', 1, 'Cama acolchonada suave para máximo descanso.', 150.00, 'DISPONIBLE'),
(11, 'Juguete Hueso', NULL, 30, NULL, 'hueso.jpg', 1, 'Juguete resistente para entretenimiento.', 35.00, 'DISPONIBLE'),
(12, 'Comida Premium Dog', NULL, 25, NULL, 'comida_perro.jpg', 1, 'Alimento balanceado para perros adultos.', 120.00, 'DISPONIBLE'),
(13, 'Arena Premium', NULL, 40, NULL, 'arena.jpg', 2, 'Arena sanitaria absorbente para gatos.', 55.00, 'DISPONIBLE'),
(14, 'Rascador Felino', NULL, 12, NULL, 'rascador.jpg', 2, 'Rascador grande para entretenimiento.', 95.00, 'DISPONIBLE'),
(15, 'Cama para Gato', NULL, 14, NULL, 'cama_gato.jpg', 2, 'Cama suave y cómoda para gatos.', 110.00, 'DISPONIBLE'),
(16, 'Juguete Ratón', NULL, 35, NULL, 'raton.jpg', 2, 'Juguete interactivo para gatos activos.', 25.00, 'DISPONIBLE'),
(17, 'Comida Cat Premium', NULL, 20, NULL, 'comida_gato.jpg', 2, 'Alimento balanceado para gatos.', 130.00, 'DISPONIBLE'),
(18, 'Champú Antipulgas', NULL, 18, NULL, 'champu_antipulgas.jpg', 3, 'Champú especializado contra pulgas y garrapatas.', 70.00, 'DISPONIBLE'),
(19, 'Champú Hidratante', NULL, 16, NULL, 'champu_hidratante.jpg', 3, 'Champú para piel sensible y brillante.', 65.00, 'DISPONIBLE'),
(20, 'Perfume Mascotas', NULL, 22, NULL, 'perfume.jpg', 3, 'Fragancia suave para perros y gatos.', 40.00, 'DISPONIBLE'),
(21, 'Toallitas Húmedas', NULL, 28, NULL, 'toallitas.jpg', 3, 'Toallitas de limpieza rápida para mascotas.', 30.00, 'DISPONIBLE'),
(22, 'Cepillo Profesional', NULL, 19, NULL, 'cepillo.jpg', 3, 'Cepillo para pelaje suave y brillante.', 50.00, 'DISPONIBLE'),
(23, 'Kit Dental Mascotas', NULL, 14, NULL, 'kit_dental.jpg', 3, 'Kit completo de higiene dental para perros y gatos con cepillo y pasta especializada.', 85.00, 'DISPONIBLE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recepcionista`
--

CREATE TABLE `recepcionista` (
  `id_recepcionista` int(11) NOT NULL,
  `turno` varchar(50) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre`) VALUES
(2, 'ADMIN'),
(1, 'CLIENTE'),
(4, 'GROOMER'),
(3, 'RECEPCIONISTA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `id_servicio` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `precio_base` decimal(10,2) DEFAULT NULL,
  `duracion_minutos` int(11) NOT NULL,
  `duracion_base` int(11) DEFAULT NULL,
  `permite_doble_booking` tinyint(1) DEFAULT NULL,
  `requiere_bloque_consecutivo` tinyint(1) DEFAULT NULL,
  `factor_tamano_raza` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`factor_tamano_raza`)),
  `consumo_insumos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`consumo_insumos`)),
  `estado_activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`id_servicio`, `nombre`, `descripcion`, `precio_base`, `duracion_minutos`, `duracion_base`, `permite_doble_booking`, `requiere_bloque_consecutivo`, `factor_tamano_raza`, `consumo_insumos`, `estado_activo`) VALUES
(1, 'Baño', 'Baño completo para mascota', 50.00, 0, 60, NULL, NULL, NULL, NULL, 1),
(2, 'Corte', 'Corte de pelo profesional', 70.00, 0, 90, NULL, NULL, NULL, NULL, 1),
(3, 'Peinado', 'Peinado y cepillado', 40.00, 0, 45, NULL, NULL, NULL, NULL, 1),
(4, 'Servicio Completo', 'Baño + corte + peinado', 200.00, 120, 120, NULL, NULL, NULL, NULL, 1),
(5, 'Baño y limpieza', 'Baño completo e higiene general para mascotas.', 150.00, 0, 90, NULL, NULL, NULL, NULL, 0),
(6, 'Corte y peinado', 'Corte de pelo y peinado profesional.', 150.00, 0, 90, NULL, NULL, NULL, NULL, 0),
(7, 'Tratamientos', 'Tratamientos especiales para piel y pelaje.', 150.00, 0, 90, NULL, NULL, NULL, NULL, 0),
(8, 'Servicio completo', 'Servicio premium completo para mascotas.', 200.00, 0, 120, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `uso_inventario`
--

CREATE TABLE `uso_inventario` (
  `id_uso` int(11) NOT NULL,
  `id_ficha` int(11) NOT NULL,
  `id_insumo` int(11) NOT NULL,
  `cantidad_usada` decimal(10,2) NOT NULL DEFAULT 0.00,
  `cantidad_devuelta` decimal(10,2) DEFAULT 0.00,
  `cantidad_desperdiciada` decimal(10,2) DEFAULT 0.00,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `two_factor_secret` varchar(255) DEFAULT NULL,
  `two_factor_enabled` tinyint(1) DEFAULT 0,
  `ultimo_acceso` datetime DEFAULT NULL,
  `estado_activo` tinyint(1) DEFAULT 1,
  `id_rol` int(11) DEFAULT NULL,
  `turno` enum('MANANA','TARDE') DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `email_verificado` tinyint(1) DEFAULT 0,
  `token_activacion` varchar(255) DEFAULT NULL,
  `token_recuperacion` varchar(255) DEFAULT NULL,
  `token_expira` datetime DEFAULT NULL,
  `cambio_password` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `email`, `password_hash`, `two_factor_secret`, `two_factor_enabled`, `ultimo_acceso`, `estado_activo`, `id_rol`, `turno`, `apellido`, `direccion`, `telefono`, `email_verificado`, `token_activacion`, `token_recuperacion`, `token_expira`, `cambio_password`) VALUES
(10, 'Administrador', 'admin@spa.com', '$2y$10$oRJXux7PsOJ67YIw4fbDf.FQN44aJP9VL9FHomYWUmoAP1qFFC4Rm', NULL, 0, NULL, 1, 2, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 0),
(11, 'Juan', 'obitopalacios10@gmail.com', '$2y$10$uWQTycn7JJ2EmO9Kd4URVeE.i8GWvpXwpIMJmw.p2JRh9/Ur6Xrf.', NULL, 0, NULL, 1, 4, NULL, 'Montes', 'AV. LAS PALMERAS', '77774444', 1, NULL, NULL, NULL, 1),
(12, 'Jessica', 'mamanipalaciosdanner@gmail.com', '$2y$10$6tlOkZmljBS6FlnJRmvkOeHlwgevtvceWhNhBRwjXc2AGblv.juL2', NULL, 0, NULL, 1, 3, NULL, 'Lazarte', 'AV. ECUADOR', '77889999', 1, NULL, NULL, NULL, 1),
(14, 'Annder', 'anndermunoz941@gmail.com', '$2y$10$jm0V/jTLEdC/vBvJetPCOODXRIKDoP5v2CMjKvdsn/7N6y7TYCdqe', NULL, 0, NULL, 1, 1, NULL, 'Palacios', 'AV. LAS PALMERAS', '77774444', 1, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `variante_producto`
--

CREATE TABLE `variante_producto` (
  `id_variante` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `atributo` varchar(50) DEFAULT NULL,
  `valor` varchar(50) DEFAULT NULL,
  `precio_extra` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `sku_variante` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  ADD PRIMARY KEY (`id_auditoria`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `bloqueos`
--
ALTER TABLE `bloqueos`
  ADD PRIMARY KEY (`id_bloqueo`);

--
-- Indices de la tabla `bloqueo_horario`
--
ALTER TABLE `bloqueo_horario`
  ADD PRIMARY KEY (`id_bloqueo`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id_carrito`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`),
  ADD KEY `padre_id` (`padre_id`);

--
-- Indices de la tabla `categoria_producto`
--
ALTER TABLE `categoria_producto`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `checklist_grooming`
--
ALTER TABLE `checklist_grooming`
  ADD PRIMARY KEY (`id_checklist`),
  ADD KEY `id_ficha` (`id_ficha`);

--
-- Indices de la tabla `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`id_cita`),
  ADD KEY `id_mascota` (`id_mascota`),
  ADD KEY `id_groomer` (`id_groomer`),
  ADD KEY `creado_por` (`creado_por`),
  ADD KEY `fk_cita_servicio` (`id_servicio`);

--
-- Indices de la tabla `cita_servicio`
--
ALTER TABLE `cita_servicio`
  ADD PRIMARY KEY (`id_cita`,`id_servicio`),
  ADD KEY `id_servicio` (`id_servicio`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `detalle_carrito`
--
ALTER TABLE `detalle_carrito`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_carrito` (`id_carrito`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_variante` (`id_variante`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id_factura`);

--
-- Indices de la tabla `ficha_grooming`
--
ALTER TABLE `ficha_grooming`
  ADD PRIMARY KEY (`id_ficha`),
  ADD UNIQUE KEY `id_cita` (`id_cita`);

--
-- Indices de la tabla `foto_mascota`
--
ALTER TABLE `foto_mascota`
  ADD PRIMARY KEY (`id_foto`),
  ADD KEY `id_ficha` (`id_ficha`);

--
-- Indices de la tabla `groomer`
--
ALTER TABLE `groomer`
  ADD PRIMARY KEY (`id_groomer`);

--
-- Indices de la tabla `historial_mascota`
--
ALTER TABLE `historial_mascota`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `id_mascota` (`id_mascota`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id_insumo`);

--
-- Indices de la tabla `mascota`
--
ALTER TABLE `mascota`
  ADD PRIMARY KEY (`id_mascota`),
  ADD KEY `fk_mascota_cliente` (`id_cliente`);

--
-- Indices de la tabla `mascota_dueno`
--
ALTER TABLE `mascota_dueno`
  ADD PRIMARY KEY (`id_mascota`,`id_cliente`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  ADD PRIMARY KEY (`id_notificacion`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `id_factura` (`id_factura`),
  ADD KEY `fk_pago_cita` (`id_cita`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `recepcionista`
--
ALTER TABLE `recepcionista`
  ADD PRIMARY KEY (`id_recepcionista`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`id_servicio`);

--
-- Indices de la tabla `uso_inventario`
--
ALTER TABLE `uso_inventario`
  ADD PRIMARY KEY (`id_uso`),
  ADD KEY `fk_uso_ficha` (`id_ficha`),
  ADD KEY `fk_uso_insumo` (`id_insumo`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `variante_producto`
--
ALTER TABLE `variante_producto`
  ADD PRIMARY KEY (`id_variante`),
  ADD UNIQUE KEY `sku_variante` (`sku_variante`),
  ADD KEY `id_producto` (`id_producto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  MODIFY `id_auditoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=276;

--
-- AUTO_INCREMENT de la tabla `bloqueos`
--
ALTER TABLE `bloqueos`
  MODIFY `id_bloqueo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `bloqueo_horario`
--
ALTER TABLE `bloqueo_horario`
  MODIFY `id_bloqueo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `categoria_producto`
--
ALTER TABLE `categoria_producto`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `checklist_grooming`
--
ALTER TABLE `checklist_grooming`
  MODIFY `id_checklist` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `detalle_carrito`
--
ALTER TABLE `detalle_carrito`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ficha_grooming`
--
ALTER TABLE `ficha_grooming`
  MODIFY `id_ficha` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `foto_mascota`
--
ALTER TABLE `foto_mascota`
  MODIFY `id_foto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_mascota`
--
ALTER TABLE `historial_mascota`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id_insumo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mascota`
--
ALTER TABLE `mascota`
  MODIFY `id_mascota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `uso_inventario`
--
ALTER TABLE `uso_inventario`
  MODIFY `id_uso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `variante_producto`
--
ALTER TABLE `variante_producto`
  MODIFY `id_variante` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `auditoria`
--
ALTER TABLE `auditoria`
  ADD CONSTRAINT `auditoria_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE SET NULL;

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE SET NULL;

--
-- Filtros para la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD CONSTRAINT `categoria_ibfk_1` FOREIGN KEY (`padre_id`) REFERENCES `categoria` (`id_categoria`);

--
-- Filtros para la tabla `checklist_grooming`
--
ALTER TABLE `checklist_grooming`
  ADD CONSTRAINT `checklist_grooming_ibfk_1` FOREIGN KEY (`id_ficha`) REFERENCES `ficha_grooming` (`id_ficha`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `cita_ibfk_1` FOREIGN KEY (`id_mascota`) REFERENCES `mascota` (`id_mascota`),
  ADD CONSTRAINT `cita_ibfk_3` FOREIGN KEY (`creado_por`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `fk_cita_groomer` FOREIGN KEY (`id_groomer`) REFERENCES `usuario` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cita_mascota` FOREIGN KEY (`id_mascota`) REFERENCES `mascota` (`id_mascota`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cita_servicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicio` (`id_servicio`);

--
-- Filtros para la tabla `cita_servicio`
--
ALTER TABLE `cita_servicio`
  ADD CONSTRAINT `cita_servicio_ibfk_1` FOREIGN KEY (`id_cita`) REFERENCES `cita` (`id_cita`) ON DELETE CASCADE,
  ADD CONSTRAINT `cita_servicio_ibfk_2` FOREIGN KEY (`id_servicio`) REFERENCES `servicio` (`id_servicio`);

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_carrito`
--
ALTER TABLE `detalle_carrito`
  ADD CONSTRAINT `detalle_carrito_ibfk_1` FOREIGN KEY (`id_carrito`) REFERENCES `carrito` (`id_carrito`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_carrito_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`),
  ADD CONSTRAINT `detalle_carrito_ibfk_3` FOREIGN KEY (`id_variante`) REFERENCES `variante_producto` (`id_variante`);

--
-- Filtros para la tabla `ficha_grooming`
--
ALTER TABLE `ficha_grooming`
  ADD CONSTRAINT `ficha_grooming_ibfk_1` FOREIGN KEY (`id_cita`) REFERENCES `cita` (`id_cita`);

--
-- Filtros para la tabla `foto_mascota`
--
ALTER TABLE `foto_mascota`
  ADD CONSTRAINT `foto_mascota_ibfk_1` FOREIGN KEY (`id_ficha`) REFERENCES `ficha_grooming` (`id_ficha`) ON DELETE CASCADE;

--
-- Filtros para la tabla `groomer`
--
ALTER TABLE `groomer`
  ADD CONSTRAINT `groomer_ibfk_1` FOREIGN KEY (`id_groomer`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `historial_mascota`
--
ALTER TABLE `historial_mascota`
  ADD CONSTRAINT `historial_mascota_ibfk_1` FOREIGN KEY (`id_mascota`) REFERENCES `mascota` (`id_mascota`) ON DELETE CASCADE;

--
-- Filtros para la tabla `mascota`
--
ALTER TABLE `mascota`
  ADD CONSTRAINT `fk_mascota_usuario` FOREIGN KEY (`id_cliente`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `mascota_dueno`
--
ALTER TABLE `mascota_dueno`
  ADD CONSTRAINT `mascota_dueno_ibfk_1` FOREIGN KEY (`id_mascota`) REFERENCES `mascota` (`id_mascota`) ON DELETE CASCADE,
  ADD CONSTRAINT `mascota_dueno_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE;

--
-- Filtros para la tabla `notificacion`
--
ALTER TABLE `notificacion`
  ADD CONSTRAINT `notificacion_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `fk_pago_cita` FOREIGN KEY (`id_cita`) REFERENCES `cita` (`id_cita`),
  ADD CONSTRAINT `pago_ibfk_1` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id_factura`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`);

--
-- Filtros para la tabla `recepcionista`
--
ALTER TABLE `recepcionista`
  ADD CONSTRAINT `recepcionista_ibfk_1` FOREIGN KEY (`id_recepcionista`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `uso_inventario`
--
ALTER TABLE `uso_inventario`
  ADD CONSTRAINT `fk_uso_ficha` FOREIGN KEY (`id_ficha`) REFERENCES `ficha_grooming` (`id_ficha`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_uso_insumo` FOREIGN KEY (`id_insumo`) REFERENCES `inventario` (`id_insumo`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`);

--
-- Filtros para la tabla `variante_producto`
--
ALTER TABLE `variante_producto`
  ADD CONSTRAINT `variante_producto_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
