-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 28-03-2019 a las 16:50:25
-- Versión del servidor: 5.7.21
-- Versión de PHP: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestor_archivos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `files`
--

DROP TABLE IF EXISTS `files`;
CREATE TABLE IF NOT EXISTS `files` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fullname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extension` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `folder_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` int(11) NOT NULL,
  `inserted_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `folders`
--

DROP TABLE IF EXISTS `folders`;
CREATE TABLE IF NOT EXISTS `folders` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tree_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_update` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direction` mediumtext COLLATE utf8mb4_unicode_ci,
  `contacts` mediumtext COLLATE utf8mb4_unicode_ci,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `password`, `email`, `ruc`, `flag`, `group`, `direction`, `contacts`, `estado`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'super', 'Supaaaa', '$2y$10$WlpOWHogSUU4CtUNcFK8cuwXbiLOMy55D8/SByCJthYgUF7Ej0sai', 'super', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2019-03-28 21:48:33', '2019-03-28 21:48:33'),
(2, 'admin', 'Adminnn', '$2y$10$7nUChAFj.ZqpqGSgf8sFse1I/tC6u/W3zDqfJyCxsCImOngEqO9Q6', 'admin', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2019-03-28 21:48:33', '2019-03-28 21:48:33'),
(3, 'cliente', 'Clienteeee', '$2y$10$gFd.X3EqMNTD3f7D.qE4ZebMKtKn29i.ihnPo12Bt.CnIgfcXTyLS', 'cliente', '123456', 'Primax', 'Grupo San ignacio', 'lejotes', '[]', 1, NULL, NULL, '2019-03-28 21:48:34', '2019-03-28 21:48:34'),
(4, 'cliente', 'Gasocentro SAC', '$2y$10$R9EdnwCD1.GceFrHan3qlu9n08DE.cdGuPC1m377LSC5BlYNsqixq', 'gas', '123456', 'Primax', 'Grupo San ignacio', 'cerca', '[]', 1, NULL, NULL, '2019-03-28 21:48:34', '2019-03-28 21:48:34'),
(5, 'cliente', 'Las Flores', '$2y$10$6j8gGbPPoF26W9bwSZTjN.datLVJCCVA60ujOHZwk1iIzzslxKcJ6', 'flores', '123456', 'Primax', 'Grupo San ignacio', 'ventanilla', '[]', 1, NULL, NULL, '2019-03-28 21:48:34', '2019-03-28 21:48:34');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
