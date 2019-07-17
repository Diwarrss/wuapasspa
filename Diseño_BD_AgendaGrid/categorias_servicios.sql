INSERT INTO `categorias` (`
id`,
`nombre_categoria
`, `estado_categoria`, `url_video`, `imagenes_imagenes_id`, `created_at`, `updated_at`) VALUES
(1, 'UÑAS', '1', '', NULL, '2019-06-27 15:33:45', '2019-06-27 15:49:00'),
(2, 'PESTAÑAS Y CEJAS', '1', '', NULL, '2019-06-27 15:34:03', '2019-06-27 16:08:10'),
(3, 'DEPILACIONES CON CERA', '1', '', NULL, '2019-06-27 15:34:15', '2019-06-27 15:34:15'),
(4, 'LIMPIEZA FACIAL', '1', '', NULL, '2019-06-27 15:34:24', '2019-06-27 15:34:24'),
(5, 'MASAJE CORPORAL', '1', '', NULL, '2019-06-27 15:34:34', '2019-06-27 15:34:54'),
(6, 'CABELLO', '1', '', NULL, '2019-06-27 15:34:50', '2019-06-27 15:34:50');

INSERT INTO `servicios` (`
id`,
`nombre_servicio
`, `descripcion_servicio`, `estado_servicio`, `url_video`, `valor_servicio`, `empresas_empresas_id`, `imagenes_imagenes_id`, `categorias_categorias_id`, `created_at`, `updated_at`) VALUES
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
