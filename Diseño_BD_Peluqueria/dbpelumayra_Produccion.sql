-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 22-06-2019 a las 03:19:11
-- Versión del servidor: 5.7.24
-- Versión de PHP: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbpelumayra`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anonimos`
--

DROP TABLE IF EXISTS `anonimos`;
CREATE TABLE IF NOT EXISTS `anonimos` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `reservaciones_id` int(10) UNSIGNED NOT NULL,
  `nombre_anonimo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `celular_anonimo` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notas_anonimo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `anonimos_reservaciones_id_foreign` (`reservaciones_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

DROP TABLE IF EXISTS `empresas`;
CREATE TABLE IF NOT EXISTS `empresas` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre_empresa` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado_empresa` int(11) NOT NULL DEFAULT '1',
  `nit_empresa` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion_empresa` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo_empresa` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urlweb_empresa` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_empresa` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram_empresa` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `celular_empresa` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono_empresa` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_empresa` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`id`, `nombre_empresa`, `estado_empresa`, `nit_empresa`, `direccion_empresa`, `correo_empresa`, `urlweb_empresa`, `facebook_empresa`, `instagram_empresa`, `celular_empresa`, `telefono_empresa`, `logo_empresa`, `created_at`, `updated_at`) VALUES
(1, 'Mayra Peluqueria', 1, '0000', 'Carrera 16 #19-05, Barrio Los Alpes', 'mayraduranfigueroa576@gmail.com', 'https://mayrapeluqueria.gridsoft.co/', 'https://www.facebook.com/profile.php?id=100010415521074', 'https://www.instagram.com/mayrapeluqueria/', '3222792826', '037-723 6649', 'Logo_Mayra_1.png', '2019-06-22 01:31:57', '2019-06-22 02:32:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

DROP TABLE IF EXISTS `imagenes`;
CREATE TABLE IF NOT EXISTS `imagenes` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `empresas_empresas_id` int(10) UNSIGNED NOT NULL,
  `nombre_imagen` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_imagen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `imagenes_empresas_empresas_id_foreign` (`empresas_empresas_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `imagenes`
--

INSERT INTO `imagenes` (`id`, `empresas_empresas_id`, `nombre_imagen`, `url_imagen`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, '_LCP1385-min.JPG', '2019-06-22 01:51:47', '2019-06-22 01:51:47'),
(2, 1, NULL, '_LCP1408-min.JPG', '2019-06-22 01:51:55', '2019-06-22 01:51:55'),
(3, 1, NULL, 'IMG_8219-min.JPG', '2019-06-22 01:52:03', '2019-06-22 01:52:03'),
(4, 1, NULL, 'IMG_8225-min.JPG', '2019-06-22 01:52:09', '2019-06-22 01:52:09'),
(5, 1, NULL, 'IMG_8218-min.JPG', '2019-06-22 01:52:14', '2019-06-22 01:52:14'),
(6, 1, NULL, 'IMG_8224-min.JPG', '2019-06-22 03:16:34', '2019-06-22 03:16:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_05_10_111111_create_roles_table', 1),
(2, '2019_05_10_112222_create_empresas_table', 1),
(3, '2019_05_10_222222_create_users_table', 1),
(4, '2019_05_12_092132_create_user_social_accounts_table', 1),
(5, '2019_05_12_104122_create_servicios_table', 1),
(6, '2019_05_12_212455_create_solicitudes_table', 1),
(7, '2019_05_12_213116_create_imagenes_table', 1),
(8, '2019_05_13_100115_create_servicios_solicitudes_table', 1),
(9, '2019_05_13_101055_create_reservaciones_table', 1),
(10, '2019_06_11_224534_create_sugerencias_table', 1),
(11, '2019_06_13_144416_create_anonimos_table', 1),
(12, '2019_10_10_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservaciones`
--

DROP TABLE IF EXISTS `reservaciones`;
CREATE TABLE IF NOT EXISTS `reservaciones` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `solicitudes_solicitudes_id` int(10) UNSIGNED DEFAULT NULL,
  `users_users_id` int(10) UNSIGNED NOT NULL COMMENT 'Es el ID del empleado',
  `fechaHoraInicio_reserva` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fechaHoraFinal_reserva` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `asignadopor` int(11) NOT NULL,
  `estado_reservacion` enum('1','2','3','4','5') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reservaciones_solicitudes_solicitudes_id_foreign` (`solicitudes_solicitudes_id`),
  KEY `reservaciones_users_users_id_foreign` (`users_users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'nombre del rol del User',
  `descripcion_rol` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre_rol`, `descripcion_rol`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', 'Usuario que se encarga del control total de su sitio web, agendar y administrar.', '2019-06-22 01:31:57', NULL),
(2, 'Empleado', 'Usuario con la capacidad de verificar al cliente atentido.', '2019-06-22 01:31:57', NULL),
(3, 'Cliente', 'Usuario que solicitara la cita desde la pagina web.', '2019-06-22 01:31:57', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

DROP TABLE IF EXISTS `servicios`;
CREATE TABLE IF NOT EXISTS `servicios` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `empresas_empresas_id` int(10) UNSIGNED NOT NULL,
  `nombre_servicio` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion_servicio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_servicio` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `servicios_empresas_empresas_id_foreign` (`empresas_empresas_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `empresas_empresas_id`, `nombre_servicio`, `descripcion_servicio`, `estado_servicio`, `created_at`, `updated_at`) VALUES
(1, 1, 'Diseños de Color', 'Todo tipo de tinturas', '1', '2019-06-22 01:43:22', '2019-06-22 01:43:22'),
(2, 1, 'Diseños de Corte', 'Todo tipo de cortes', '1', '2019-06-22 01:43:40', '2019-06-22 01:43:40'),
(3, 1, 'Pestañas', 'Todo tipo de pestañas', '1', '2019-06-22 01:45:44', '2019-06-22 01:45:44'),
(4, 1, 'Makeup', 'Maquillaje profesional', '1', '2019-06-22 01:46:06', '2019-06-22 01:46:06'),
(5, 1, 'Peinados', 'Todo tipo de peinados para situaciones especiales', '1', '2019-06-22 01:46:44', '2019-06-22 01:46:44'),
(6, 1, 'Depilación', 'Todo tipo de depilación profesional', '1', '2019-06-22 01:47:05', '2019-06-22 01:47:05'),
(7, 1, 'Asesoría VIP Novias', 'Toda la asesoría brindada profesional', '1', '2019-06-22 01:47:42', '2019-06-22 01:47:42'),
(8, 1, 'Manicure y Pedicure', 'Diseños profesionales', '1', '2019-06-22 01:48:26', '2019-06-22 01:48:26'),
(9, 1, 'Blower', 'Diseños profesionales', '1', '2019-06-22 01:49:01', '2019-06-22 01:49:01'),
(10, 1, 'Nutrición e Hidratación capilar', 'Todo lo profesional para el cabello', '1', '2019-06-22 01:49:48', '2019-06-22 01:49:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios_solicitudes`
--

DROP TABLE IF EXISTS `servicios_solicitudes`;
CREATE TABLE IF NOT EXISTS `servicios_solicitudes` (
  `servicios_servicios_id` int(10) UNSIGNED NOT NULL,
  `solicitudes_solicitudes_id` int(10) UNSIGNED NOT NULL,
  KEY `servicios_solicitudes_servicios_servicios_id_foreign` (`servicios_servicios_id`),
  KEY `servicios_solicitudes_solicitudes_solicitudes_id_foreign` (`solicitudes_solicitudes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

DROP TABLE IF EXISTS `solicitudes`;
CREATE TABLE IF NOT EXISTS `solicitudes` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `users_users_id` int(10) UNSIGNED NOT NULL,
  `fechaprobable` datetime NOT NULL,
  `comentario` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_solicitud` enum('1','2','3','4','5','6') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `solicitudes_users_users_id_foreign` (`users_users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sugerencias`
--

DROP TABLE IF EXISTS `sugerencias`;
CREATE TABLE IF NOT EXISTS `sugerencias` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `empresas_empresas_id` int(10) UNSIGNED NOT NULL,
  `descripcion` varchar(700) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sugerencias_empresas_empresas_id_foreign` (`empresas_empresas_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `roles_roles_id` int(10) UNSIGNED NOT NULL DEFAULT '3',
  `empresas_empresas_id` int(10) UNSIGNED DEFAULT NULL,
  `nombre_usuario` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apellido_usuario` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usuario` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Se deja nulo para el logueo con redes sociales',
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `celular` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_cumple` date DEFAULT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'avatar.png',
  `estado_usuario` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_roles_roles_id_foreign` (`roles_roles_id`),
  KEY `users_empresas_empresas_id_foreign` (`empresas_empresas_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `roles_roles_id`, `empresas_empresas_id`, `nombre_usuario`, `apellido_usuario`, `usuario`, `password`, `email`, `celular`, `fecha_cumple`, `imagen`, `estado_usuario`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Mayra', 'Duran Figueroa', NULL, '$2y$10$7XnrkfC2VuuR2.QuEakRue9IpKG662NRsYtNEsMFX4lXW2HKnb9kC', 'mayraduranfigueroa576@gmail.com', '3222792826', '2000-06-21', 'avatar2.png', '1', NULL, 'fPkBuc1tDAJfOmAK745KX2jFG3jVMYXPjlo70St3EAWX6b79skNsM8wDKsyq', '2019-06-22 01:39:42', '2019-06-22 03:16:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_social_accounts`
--

DROP TABLE IF EXISTS `user_social_accounts`;
CREATE TABLE IF NOT EXISTS `user_social_accounts` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `users_users_id` int(10) UNSIGNED NOT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'la red social que elije',
  `provider_uid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'id del usuario de la red social',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_social_accounts_users_users_id_foreign` (`users_users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `anonimos`
--
ALTER TABLE `anonimos`
  ADD CONSTRAINT `anonimos_reservaciones_id_foreign` FOREIGN KEY (`reservaciones_id`) REFERENCES `reservaciones` (`id`);

--
-- Filtros para la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD CONSTRAINT `imagenes_empresas_empresas_id_foreign` FOREIGN KEY (`empresas_empresas_id`) REFERENCES `empresas` (`id`);

--
-- Filtros para la tabla `reservaciones`
--
ALTER TABLE `reservaciones`
  ADD CONSTRAINT `reservaciones_solicitudes_solicitudes_id_foreign` FOREIGN KEY (`solicitudes_solicitudes_id`) REFERENCES `solicitudes` (`id`),
  ADD CONSTRAINT `reservaciones_users_users_id_foreign` FOREIGN KEY (`users_users_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD CONSTRAINT `servicios_empresas_empresas_id_foreign` FOREIGN KEY (`empresas_empresas_id`) REFERENCES `empresas` (`id`);

--
-- Filtros para la tabla `servicios_solicitudes`
--
ALTER TABLE `servicios_solicitudes`
  ADD CONSTRAINT `servicios_solicitudes_servicios_servicios_id_foreign` FOREIGN KEY (`servicios_servicios_id`) REFERENCES `servicios` (`id`),
  ADD CONSTRAINT `servicios_solicitudes_solicitudes_solicitudes_id_foreign` FOREIGN KEY (`solicitudes_solicitudes_id`) REFERENCES `solicitudes` (`id`);

--
-- Filtros para la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD CONSTRAINT `solicitudes_users_users_id_foreign` FOREIGN KEY (`users_users_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `sugerencias`
--
ALTER TABLE `sugerencias`
  ADD CONSTRAINT `sugerencias_empresas_empresas_id_foreign` FOREIGN KEY (`empresas_empresas_id`) REFERENCES `empresas` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_empresas_empresas_id_foreign` FOREIGN KEY (`empresas_empresas_id`) REFERENCES `empresas` (`id`),
  ADD CONSTRAINT `users_roles_roles_id_foreign` FOREIGN KEY (`roles_roles_id`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `user_social_accounts`
--
ALTER TABLE `user_social_accounts`
  ADD CONSTRAINT `user_social_accounts_users_users_id_foreign` FOREIGN KEY (`users_users_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
