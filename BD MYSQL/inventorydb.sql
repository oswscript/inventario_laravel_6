-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-02-2020 a las 19:57:07
-- Versión del servidor: 10.3.15-MariaDB
-- Versión de PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inventorydb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apellido` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cedula` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_cliente` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre_empresa` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slogan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_empresa` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `moneda` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tributo` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idioma` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'es',
  `recuperar_clave_login` char(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registro_usuario_login` char(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `nombre_empresa`, `slogan`, `codigo_empresa`, `telefono`, `correo`, `moneda`, `tributo`, `idioma`, `recuperar_clave_login`, `registro_usuario_login`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'OS-Inventario', 'Inventory & Stock Control', 'OS-0001', '000000000', 'contact@oswcript.com', 'USD', 'ACTIVO', 'en', 'on', 'on', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleprocesos`
--

CREATE TABLE `detalleprocesos` (
  `id` int(10) UNSIGNED NOT NULL,
  `codigo_proceso` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proceso_id` int(10) UNSIGNED DEFAULT NULL,
  `producto_id` int(10) UNSIGNED DEFAULT NULL,
  `tributo_id` int(10) UNSIGNED DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `subtotal` double(30,2) NOT NULL,
  `costo_publico_vendido` double(30,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos`
--

CREATE TABLE `gastos` (
  `id` int(10) UNSIGNED NOT NULL,
  `monto` double(30,2) NOT NULL,
  `usuario_id` int(10) UNSIGNED DEFAULT NULL,
  `codigo` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date DEFAULT NULL,
  `concepto` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `observacion` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2017_10_30_172246_create_roles_table', 1),
(2, '2017_10_30_1727700_create_users_table', 1),
(3, '2018_01_12_155600_create_configuracion_table', 1),
(4, '2018_01_12_161354_create_permisos_table', 1),
(5, '2018_09_29_163518_create_resetpassword_table', 1),
(6, '2018_12_30_231947_create_categorias_table', 1),
(7, '2018_12_31_155629_create_subcategorias_table', 1),
(8, '2019_01_01_145654_create_tributos_table', 1),
(9, '2019_01_01_152127_create_clientes_table', 1),
(10, '2019_01_03_145312_create_productos_table', 1),
(11, '2019_01_06_172327_create_posprocesos_table', 1),
(12, '2019_01_06_194705_create_detalleprocesos_table', 1),
(13, '2019_01_11_021339_create_temporales_table', 1),
(14, '2019_02_04_210017_create_gastos_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(10) UNSIGNED NOT NULL,
  `catego_i` int(11) NOT NULL DEFAULT 0,
  `catego_r` int(11) NOT NULL DEFAULT 0,
  `catego_e` int(11) NOT NULL DEFAULT 0,
  `catego_b` int(11) NOT NULL DEFAULT 0,
  `subcatego_i` int(11) NOT NULL DEFAULT 0,
  `subcatego_r` int(11) NOT NULL DEFAULT 0,
  `subcatego_e` int(11) NOT NULL DEFAULT 0,
  `subcatego_b` int(11) NOT NULL DEFAULT 0,
  `producto_i` int(11) NOT NULL DEFAULT 0,
  `producto_r` int(11) NOT NULL DEFAULT 0,
  `producto_e` int(11) NOT NULL DEFAULT 0,
  `producto_b` int(11) NOT NULL DEFAULT 0,
  `gasto_i` int(11) NOT NULL DEFAULT 0,
  `gasto_r` int(11) NOT NULL DEFAULT 0,
  `gasto_e` int(11) NOT NULL DEFAULT 0,
  `gasto_b` int(11) NOT NULL DEFAULT 0,
  `kardex_i` int(11) NOT NULL DEFAULT 0,
  `venta_i` int(11) NOT NULL DEFAULT 0,
  `venta_r` int(11) NOT NULL DEFAULT 0,
  `compra_i` int(11) NOT NULL DEFAULT 0,
  `compra_r` int(11) NOT NULL DEFAULT 0,
  `persona_i` int(11) NOT NULL DEFAULT 0,
  `reporte_i` int(11) NOT NULL DEFAULT 0,
  `rol_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `catego_i`, `catego_r`, `catego_e`, `catego_b`, `subcatego_i`, `subcatego_r`, `subcatego_e`, `subcatego_b`, `producto_i`, `producto_r`, `producto_e`, `producto_b`, `gasto_i`, `gasto_r`, `gasto_e`, `gasto_b`, `kardex_i`, `venta_i`, `venta_r`, `compra_i`, `compra_r`, `persona_i`, `reporte_i`, `rol_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, NULL, NULL),
(2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, NULL, NULL),
(3, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posprocesos`
--

CREATE TABLE `posprocesos` (
  `id` int(10) UNSIGNED NOT NULL,
  `codigo_proceso` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cliente_id` int(10) UNSIGNED DEFAULT NULL,
  `usuario_id` int(10) UNSIGNED DEFAULT NULL,
  `subtotal` double(30,2) NOT NULL,
  `descuento` int(11) NOT NULL,
  `total` double(30,2) NOT NULL,
  `tipo_pago` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `items_totales` int(11) NOT NULL,
  `registros_totales` int(11) NOT NULL,
  `comentario` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_proceso` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `motivo_rechazo` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoria_id` int(10) UNSIGNED DEFAULT NULL,
  `subcategoria_id` int(10) UNSIGNED DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `precio_costo` double(30,2) DEFAULT NULL,
  `precio_publico` double(30,2) DEFAULT NULL,
  `tributo_id` int(10) UNSIGNED DEFAULT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resetpassword`
--

CREATE TABLE `resetpassword` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `correo` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `status`, `created_at`, `updated_at`) VALUES
(1, 'SUPERADMIN', '1', NULL, NULL),
(2, 'ADMINISTRADOR', '1', NULL, NULL),
(3, 'USUARIO', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategorias`
--

CREATE TABLE `subcategorias` (
  `id` int(10) UNSIGNED NOT NULL,
  `categoria_id` int(10) UNSIGNED DEFAULT NULL,
  `nombre` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temporales`
--

CREATE TABLE `temporales` (
  `id` int(10) UNSIGNED NOT NULL,
  `producto_id` int(10) UNSIGNED DEFAULT NULL,
  `tributo_id` int(10) UNSIGNED DEFAULT NULL,
  `usuario_id` int(10) UNSIGNED DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `subtotal` double(30,2) DEFAULT NULL,
  `tipo_proceso` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tributos`
--

CREATE TABLE `tributos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PORCENTAJE',
  `monto` double(30,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tributos`
--

INSERT INTO `tributos` (`id`, `nombre`, `tipo`, `monto`, `created_at`, `updated_at`) VALUES
(1, 'IVA', 'PORCENTAJE', 12.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cedula` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexo` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imagen` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rol_id` int(10) UNSIGNED DEFAULT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `nombre`, `apellido`, `cedula`, `email`, `sexo`, `telefono`, `direccion`, `imagen`, `rol_id`, `status`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'OSW', 'SCRIPT', '12345678', 'contact@oswscript.com', 'M', '+000000000', 'DIRECCION DE SUPER ADMIN', NULL, 1, '1', '$2y$10$ijEWrUjFj4fIxYZORr/K3OUaOvjlyT0orjJepBCqDe/p6yd6uBD6G', NULL, NULL, NULL),
(2, 'ADMIN', 'ADMIN', '00000000', 'admin@admin.com', 'M', '0000', '0000', NULL, 2, '1', '$2y$10$9K.NC5OM5cd5wEcxAk9aZuelzu9YC8w5Zl/dWOgwCtAF2M.lEL3Wm', NULL, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categorias_nombre_unique` (`nombre`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clientes_cedula_unique` (`cedula`),
  ADD UNIQUE KEY `clientes_correo_unique` (`correo`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalleprocesos`
--
ALTER TABLE `detalleprocesos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalleprocesos_proceso_id_foreign` (`proceso_id`),
  ADD KEY `detalleprocesos_producto_id_foreign` (`producto_id`),
  ADD KEY `detalleprocesos_tributo_id_foreign` (`tributo_id`);

--
-- Indices de la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gastos_usuario_id_foreign` (`usuario_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permisos_rol_id_foreign` (`rol_id`);

--
-- Indices de la tabla `posprocesos`
--
ALTER TABLE `posprocesos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posprocesos_cliente_id_foreign` (`cliente_id`),
  ADD KEY `posprocesos_usuario_id_foreign` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `productos_codigo_unique` (`codigo`),
  ADD KEY `productos_categoria_id_foreign` (`categoria_id`),
  ADD KEY `productos_subcategoria_id_foreign` (`subcategoria_id`),
  ADD KEY `productos_tributo_id_foreign` (`tributo_id`);

--
-- Indices de la tabla `resetpassword`
--
ALTER TABLE `resetpassword`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resetpassword_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subcategorias_nombre_unique` (`nombre`),
  ADD KEY `subcategorias_categoria_id_foreign` (`categoria_id`);

--
-- Indices de la tabla `temporales`
--
ALTER TABLE `temporales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `temporales_usuario_id_foreign` (`usuario_id`),
  ADD KEY `temporales_producto_id_foreign` (`producto_id`),
  ADD KEY `temporales_tributo_id_foreign` (`tributo_id`);

--
-- Indices de la tabla `tributos`
--
ALTER TABLE `tributos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_cedula_unique` (`cedula`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_rol_id_foreign` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalleprocesos`
--
ALTER TABLE `detalleprocesos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gastos`
--
ALTER TABLE `gastos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `posprocesos`
--
ALTER TABLE `posprocesos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `resetpassword`
--
ALTER TABLE `resetpassword`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `temporales`
--
ALTER TABLE `temporales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tributos`
--
ALTER TABLE `tributos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalleprocesos`
--
ALTER TABLE `detalleprocesos`
  ADD CONSTRAINT `detalleprocesos_proceso_id_foreign` FOREIGN KEY (`proceso_id`) REFERENCES `posprocesos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `detalleprocesos_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `detalleprocesos_tributo_id_foreign` FOREIGN KEY (`tributo_id`) REFERENCES `tributos` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD CONSTRAINT `gastos_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `permisos_rol_id_foreign` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `posprocesos`
--
ALTER TABLE `posprocesos`
  ADD CONSTRAINT `posprocesos_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `posprocesos_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `productos_subcategoria_id_foreign` FOREIGN KEY (`subcategoria_id`) REFERENCES `subcategorias` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `productos_tributo_id_foreign` FOREIGN KEY (`tributo_id`) REFERENCES `tributos` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `resetpassword`
--
ALTER TABLE `resetpassword`
  ADD CONSTRAINT `resetpassword_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD CONSTRAINT `subcategorias_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `temporales`
--
ALTER TABLE `temporales`
  ADD CONSTRAINT `temporales_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `temporales_tributo_id_foreign` FOREIGN KEY (`tributo_id`) REFERENCES `tributos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `temporales_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_rol_id_foreign` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
