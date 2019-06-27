-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 27-06-2019 a las 16:57:00
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
-- Base de datos: `wuapasspa`
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
-- Estructura de tabla para la tabla `cajas`
--

DROP TABLE IF EXISTS `cajas`;
CREATE TABLE IF NOT EXISTS `cajas` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre_categoria` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado_categoria` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `url_video` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imagenes_imagenes_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categorias_imagenes_imagenes_id_foreign` (`imagenes_imagenes_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre_categoria`, `estado_categoria`, `url_video`, `imagenes_imagenes_id`, `created_at`, `updated_at`) VALUES
(1, 'UÑAS', '1', '', NULL, '2019-06-27 15:33:45', '2019-06-27 15:49:00'),
(2, 'PESTAÑAS Y CEJAS', '1', '', NULL, '2019-06-27 15:34:03', '2019-06-27 16:08:10'),
(3, 'DEPILACIONES CON CERA', '1', '', NULL, '2019-06-27 15:34:15', '2019-06-27 15:34:15'),
(4, 'LIMPIEZA FACIAL', '1', '', NULL, '2019-06-27 15:34:24', '2019-06-27 15:34:24'),
(5, 'MASAJE CORPORAL', '1', '', NULL, '2019-06-27 15:34:34', '2019-06-27 15:34:54'),
(6, 'CABELLO', '1', '', NULL, '2019-06-27 15:34:50', '2019-06-27 15:34:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descuentos`
--

DROP TABLE IF EXISTS `descuentos`;
CREATE TABLE IF NOT EXISTS `descuentos` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

DROP TABLE IF EXISTS `empresas`;
CREATE TABLE IF NOT EXISTS `empresas` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre_empresa` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_corto` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_empresa` int(11) NOT NULL DEFAULT '1',
  `nit_empresa` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion_empresa` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo_empresa` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urlweb_empresa` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_empresa` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram_empresa` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `celular_empresa` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono_empresa` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `horario_empresa` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_empresa` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`id`, `nombre_empresa`, `nombre_corto`, `estado_empresa`, `nit_empresa`, `direccion_empresa`, `correo_empresa`, `urlweb_empresa`, `facebook_empresa`, `instagram_empresa`, `celular_empresa`, `telefono_empresa`, `horario_empresa`, `logo_empresa`, `created_at`, `updated_at`) VALUES
(1, 'Wuapa\'s Spa', 'Spa', 1, '0', 'San Gil', 'wuapasspa@gmail.com', 'https://wuapasspa.gridsoft.co/', 'https://www.facebook.com/wuapasSpa/', 'https://www.instagram.com/wuapas_spa/', '3174588999', '0', '7:00 am a 8:00 pm', 'logotipo.png', '2019-06-27 15:20:05', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

DROP TABLE IF EXISTS `facturas`;
CREATE TABLE IF NOT EXISTS `facturas` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `imagenes`
--

INSERT INTO `imagenes` (`id`, `empresas_empresas_id`, `nombre_imagen`, `url_imagen`, `created_at`, `updated_at`) VALUES
(1, 1, 'Reino', 'Imagen 1.jpeg', '2019-06-27 16:21:29', '2019-06-27 16:21:29'),
(2, 1, 'Reino 2', 'Imagen 2.jpeg', '2019-06-27 16:21:47', '2019-06-27 16:21:47');

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
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(18, '2019_05_10_111111_create_roles_table', 1),
(19, '2019_05_10_112222_create_empresas_table', 1),
(20, '2019_05_10_222222_create_users_table', 1),
(21, '2019_05_12_092132_create_user_social_accounts_table', 1),
(22, '2019_05_12_212455_create_solicitudes_table', 1),
(23, '2019_05_12_213116_create_imagenes_table', 1),
(24, '2019_06_11_222320_create_categorias_table', 1),
(25, '2019_06_11_224534_create_sugerencias_table', 1),
(26, '2019_06_12_104122_create_servicios_table', 1),
(27, '2019_06_13_100115_create_servicios_solicitudes_table', 1),
(28, '2019_06_13_101055_create_reservaciones_table', 1),
(29, '2019_06_13_144416_create_anonimos_table', 1),
(30, '2019_06_25_222717_create_descuentos_table', 1),
(31, '2019_06_25_222735_create_facturas_table', 1),
(32, '2019_06_25_222750_create_cajas_table', 1),
(33, '2019_06_25_222800_create_pagos_table', 1),
(34, '2019_10_10_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

DROP TABLE IF EXISTS `pagos`;
CREATE TABLE IF NOT EXISTS `pagos` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre_rol`, `descripcion_rol`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', 'Usuario que se encarga del control total de su sitio web, agendar y administrar.', '2019-06-27 15:20:04', NULL),
(2, 'Empleado', 'Usuario con la capacidad de verificar al cliente atentido.', '2019-06-27 15:20:04', NULL),
(3, 'Cliente', 'Usuario que solicitara la cita desde la pagina web.', '2019-06-27 15:20:04', NULL),
(4, 'Agendador', 'Usuario encargado de agendar y facturar los servicios.', '2019-06-27 15:20:04', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

DROP TABLE IF EXISTS `servicios`;
CREATE TABLE IF NOT EXISTS `servicios` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre_servicio` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion_servicio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_servicio` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `url_video` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valor_servicio` decimal(12,2) NOT NULL,
  `empresas_empresas_id` int(10) UNSIGNED NOT NULL,
  `imagenes_imagenes_id` int(10) UNSIGNED DEFAULT NULL,
  `categorias_categorias_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `servicios_empresas_empresas_id_foreign` (`empresas_empresas_id`),
  KEY `servicios_imagenes_imagenes_id_foreign` (`imagenes_imagenes_id`),
  KEY `servicios_categorias_categorias_id_foreign` (`categorias_categorias_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `nombre_servicio`, `descripcion_servicio`, `estado_servicio`, `url_video`, `valor_servicio`, `empresas_empresas_id`, `imagenes_imagenes_id`, `categorias_categorias_id`, `created_at`, `updated_at`) VALUES
(1, 'Pedispa sales relajantes', 'Pediespa con todo', '1', '', '25000.00', 1, NULL, 1, '2019-06-27 15:37:01', '2019-06-27 15:59:28'),
(2, 'Manicure  tradicional', 'null', '1', '', '10000.00', 1, NULL, 1, '2019-06-27 15:49:32', '2019-06-27 15:52:29'),
(3, 'Pedicure tradicional', 'null', '1', '', '12000.00', 1, NULL, 1, '2019-06-27 15:52:17', '2019-06-27 15:53:09'),
(4, 'Semipermanentes en manos', NULL, '1', '', '32000.00', 1, NULL, 1, '2019-06-27 15:53:30', '2019-06-27 15:53:30'),
(5, 'Semipermantes en pies', 'null', '1', '', '25000.00', 1, NULL, 1, '2019-06-27 15:53:51', '2019-06-27 15:53:57'),
(6, 'Mantenimiento de acrilicas', NULL, '1', '', '28000.00', 1, NULL, 1, '2019-06-27 15:54:19', '2019-06-27 15:54:19'),
(7, 'Uñas acrílicas y esculpidas desde', NULL, '1', '', '80000.00', 1, NULL, 1, '2019-06-27 15:54:48', '2019-06-27 15:54:48'),
(8, 'Semipermanente con tips', NULL, '1', '', '50000.00', 1, NULL, 1, '2019-06-27 15:55:09', '2019-06-27 15:55:09'),
(9, 'Pestañas pelo a pelo', NULL, '1', '', '80000.00', 1, NULL, 2, '2019-06-27 15:56:27', '2019-06-27 15:56:27'),
(10, 'Retoque de pestañas pelo a pelo', NULL, '1', '', '25000.00', 1, NULL, 2, '2019-06-27 15:56:52', '2019-06-27 15:56:52'),
(11, 'Lifting', 'lifting', '1', '', '30000.00', 1, NULL, 2, '2019-06-27 16:00:34', '2019-06-27 16:00:34'),
(12, 'Pestañas punto a punto', 'pestañas', '1', '', '20000.00', 1, NULL, 2, '2019-06-27 16:01:10', '2019-06-27 16:01:10'),
(13, 'Diseño + sobreado de cejas', 'Diseño + sobreado de cejas', '1', '', '15000.00', 1, NULL, 2, '2019-06-27 16:02:14', '2019-06-27 16:02:14'),
(14, 'Cejas', 'Cejas', '1', '', '7000.00', 1, NULL, 3, '2019-06-27 16:02:52', '2019-06-27 16:02:52'),
(15, 'Bozo', 'Bozo', '1', '', '4000.00', 1, NULL, 3, '2019-06-27 16:03:08', '2019-06-27 16:03:08'),
(16, 'Axila', 'Axila', '1', '', '6000.00', 1, NULL, 3, '2019-06-27 16:03:26', '2019-06-27 16:03:26'),
(17, 'Piernas', 'Piernas', '1', '', '20000.00', 1, NULL, 3, '2019-06-27 16:03:48', '2019-06-27 16:03:48'),
(18, 'Bikini', 'Bikini', '1', '', '30000.00', 1, NULL, 3, '2019-06-27 16:04:07', '2019-06-27 16:04:07'),
(19, 'Limpieza facial profunda', 'Limpieza facial profunda', '1', '', '60000.00', 1, NULL, 4, '2019-06-27 16:06:47', '2019-06-27 16:06:47'),
(20, 'Limpieza facial hidratante', 'Limpieza facial hidratante', '1', '', '50000.00', 1, NULL, 4, '2019-06-27 16:10:16', '2019-06-27 16:10:16'),
(21, 'Limpieza facial + mascara led', 'Limpieza facial + mascara led', '1', '', '70000.00', 1, NULL, 4, '2019-06-27 16:10:45', '2019-06-27 16:10:45'),
(22, 'Masaje relajante + exfoliación + chocolaterapia', 'Masaje relajante + exfoliación + chocolaterapia', '1', '', '50000.00', 1, NULL, 5, '2019-06-27 16:12:39', '2019-06-27 16:12:39'),
(23, 'Masaje localizado', 'Masaje localizado', '1', '', '28000.00', 1, NULL, 5, '2019-06-27 16:13:00', '2019-06-27 16:13:00'),
(24, 'Masaje colonico', 'Masaje colonico', '1', '', '25000.00', 1, NULL, 5, '2019-06-27 16:13:51', '2019-06-27 16:13:51'),
(25, 'Refrescologia', 'Refrescologia', '1', '', '40000.00', 1, NULL, 5, '2019-06-27 16:14:41', '2019-06-27 16:14:41'),
(26, 'Drenaje linfático', 'Drenaje linfático', '1', '', '70000.00', 1, NULL, 5, '2019-06-27 16:14:58', '2019-06-27 16:14:58'),
(27, 'Masaje prenatal', 'Masaje prenatal', '1', '', '50000.00', 1, NULL, 5, '2019-06-27 16:15:36', '2019-06-27 16:15:36'),
(28, 'Lavado + cepillado + planchado', 'Lavado + cepillado + planchado', '1', '', '20000.00', 1, NULL, 6, '2019-06-27 16:16:18', '2019-06-27 16:16:18'),
(29, 'Keratina', 'Keratina', '1', '', '0.00', 1, NULL, 6, '2019-06-27 16:16:45', '2019-06-27 16:16:45'),
(30, 'Cirugía capilar todo largo', 'Cirugía capilar todo largo', '1', '', '60000.00', 1, NULL, 6, '2019-06-27 16:17:14', '2019-06-27 16:17:14'),
(31, 'Repolarización', 'Repolarización', '1', '', '20000.00', 1, NULL, 6, '2019-06-27 16:17:39', '2019-06-27 16:17:39'),
(32, 'Aplicación de tinte', 'Aplicación de tinte', '1', '', '7000.00', 1, NULL, 6, '2019-06-27 16:18:13', '2019-06-27 16:18:13'),
(33, 'Peinados con trenzas', 'Peinados con trenzas', '1', '', '7000.00', 1, NULL, 6, '2019-06-27 16:18:28', '2019-06-27 16:18:28');

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
(1, 1, 1, 'Katherine', 'Gutierrez Rojas', NULL, '$2y$10$tkqnOA28N/ToBUw.SP0rH.bC0JCftWVKCo.fbrnLz.vM1Qd0y.REW', 'kathy-627@hotmail.com', '3155734968', '1995-06-27', 'avatar.png', '1', NULL, 'AhnODbhzQcupZ0TEIYtQ2X87ODmhiPxatsjuEh5pom8VzeAva8NSgM6IXMEK', '2019-06-27 15:27:09', '2019-06-27 15:27:09');

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
-- Filtros para la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD CONSTRAINT `categorias_imagenes_imagenes_id_foreign` FOREIGN KEY (`imagenes_imagenes_id`) REFERENCES `imagenes` (`id`);

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
  ADD CONSTRAINT `servicios_categorias_categorias_id_foreign` FOREIGN KEY (`categorias_categorias_id`) REFERENCES `categorias` (`id`),
  ADD CONSTRAINT `servicios_empresas_empresas_id_foreign` FOREIGN KEY (`empresas_empresas_id`) REFERENCES `empresas` (`id`),
  ADD CONSTRAINT `servicios_imagenes_imagenes_id_foreign` FOREIGN KEY (`imagenes_imagenes_id`) REFERENCES `imagenes` (`id`);

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
