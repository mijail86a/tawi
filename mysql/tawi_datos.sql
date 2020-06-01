-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 25-05-2020 a las 19:02:10
-- Versión del servidor: 5.6.47
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
-- Base de datos: `tawi_datos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `p4u_cliente`
--

CREATE TABLE `p4u_cliente` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `clave` blob NOT NULL,
  `logo` longtext NOT NULL,
  `fondo` longtext NOT NULL,
  `estado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `p4u_cliente`
--

INSERT INTO `p4u_cliente` (`id`, `nombre`, `usuario`, `clave`, `logo`, `fondo`, `estado`) VALUES
(1, 'La Bonbonniere', 'labonbonniere@tawi.pe', 0x1d2d6b5c20d74a2a61ef95bc1c5b7306, 'https://www.labonbonniere.pe/wp-content/uploads/2016/10/local_opt-300x300.jpg', 'https://www.labonbonniere.pe/wp-content/uploads/2016/10/local_opt-300x300.jpg', '1'),
(2, 'La verdad de la milanesa', 'laverdaddelamilanesa@tawi.pe', 0x1d2d6b5c20d74a2a61ef95bc1c5b7306, 'https://laverdaddelamilanesa.com.pe/wp-content/uploads/2015/09/lvdm-logo-azul-300x300.png', 'https://laverdaddelamilanesa.com.pe/wp-content/uploads/2015/09/location-2.jpg', '1'),
(3, 'Administrador', 'admin@tawi.pe', 0x1d2d6b5c20d74a2a61ef95bc1c5b7306, '', '', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `p4u_clienteDetalle`
--

CREATE TABLE `p4u_clienteDetalle` (
  `id` int(11) NOT NULL,
  `id_cliente` varchar(100) DEFAULT NULL,
  `razon_social` varchar(100) DEFAULT NULL,
  `documento` varchar(20) DEFAULT NULL,
  `cuenta` varchar(50) DEFAULT NULL,
  `interbancario` varchar(50) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `p4u_producto`
--

CREATE TABLE `p4u_producto` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `producto` varchar(100) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(75) NOT NULL,
  `estado` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `p4u_producto`
--

INSERT INTO `p4u_producto` (`id`, `id_cliente`, `id_categoria`, `producto`, `precio`, `imagen`, `estado`) VALUES
(1, 1, 1, 'plato 1', 10.00, 'restaurant.jpg', '1'),
(2, 1, 1, 'plato 2', 10.00, 'restaurant.jpg', '1'),
(3, 1, 1, 'plato 3', 10.00, 'restaurant.jpg', '1'),
(4, 1, 1, 'plato 4', 10.00, 'restaurant.jpg', '1'),
(5, 1, 2, 'plato 5', 10.00, 'restaurant.jpg', '1'),
(6, 1, 2, 'plato 6', 10.00, 'restaurant.jpg', '1'),
(7, 1, 2, 'plato 7', 10.00, 'restaurant.jpg', '1'),
(8, 1, 2, 'plato 8', 10.00, 'restaurant.jpg', '1'),
(9, 1, 3, 'plato 9', 10.00, 'restaurant.jpg', '1'),
(10, 1, 3, 'plato 10', 10.00, 'restaurant.jpg', '1'),
(11, 1, 3, 'plato 11', 10.00, 'restaurant.jpg', '1'),
(12, 1, 3, 'plato 12', 10.00, 'restaurant.jpg', '1'),
(13, 1, 4, 'plato 13', 10.00, 'restaurant.jpg', '1'),
(14, 1, 4, 'plato 14', 10.00, 'restaurant.jpg', '1'),
(15, 1, 4, 'plato 15', 10.00, 'restaurant.jpg', '1'),
(16, 1, 4, 'plato 16', 10.00, 'restaurant.jpg', '1'),
(17, 1, 4, 'plato 17', 10.00, 'restaurant.jpg', '1'),
(18, 1, 4, 'plato 18', 10.00, 'restaurant.jpg', '1'),
(19, 1, 4, 'plato 19', 10.00, 'restaurant.jpg', '1'),
(20, 1, 4, 'plato 20', 10.00, 'restaurant.jpg', '1'),
(21, 1, 4, 'plato 21', 10.00, 'restaurant.jpg', '1'),
(22, 1, 4, 'plato 22', 10.00, 'restaurant.jpg', '1'),
(23, 1, 4, 'plato 23', 10.00, 'restaurant.jpg', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tw_agregado`
--

CREATE TABLE `tw_agregado` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `agregado` varchar(45) NOT NULL,
  `obligatorio` char(1) NOT NULL,
  `descripcion` text,
  `creacion` datetime NOT NULL,
  `edicion` datetime NOT NULL,
  `estado` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tw_agregado`
--

INSERT INTO `tw_agregado` (`id`, `id_producto`, `agregado`, `obligatorio`, `descripcion`, `creacion`, `edicion`, `estado`) VALUES
(1, 1, 'Jugos', '1', NULL, '2019-07-16 18:34:58', '2019-07-16 18:34:58', '1'),
(2, 1, 'Bebidas', '1', NULL, '2019-07-16 18:35:51', '2019-07-16 19:12:09', '1'),
(3, 1, 'Huevos', '1', NULL, '2019-07-16 19:12:15', '2019-07-16 19:12:15', '1'),
(4, 2, 'Jugos', '1', NULL, '2019-07-16 20:08:25', '2019-07-16 20:08:25', '1'),
(5, 2, 'bebidas', '1', 'Seleccione 2 bebidas', '2019-07-16 20:12:27', '2019-07-16 20:12:27', '1'),
(6, 82, 'Toppings', '1', NULL, '2019-07-21 16:56:57', '2019-07-21 16:56:57', '1'),
(7, 83, 'Toppings', '1', NULL, '2019-07-21 16:57:27', '2019-07-21 16:57:27', '1'),
(8, 83, 'Elige tu guarnición', '1', NULL, '2019-07-21 16:57:31', '2019-07-21 16:57:31', '1'),
(9, 84, 'Toppings', '1', NULL, '2019-07-21 16:57:27', '2019-07-21 16:57:27', '1'),
(10, 84, 'Elige tu guarnición', '1', NULL, '2019-07-21 16:57:31', '2019-07-21 16:57:31', '1'),
(11, 85, 'Toppings', '1', NULL, '2019-07-21 16:57:27', '2019-07-21 16:57:27', '1'),
(12, 85, 'Elige tu guarnición', '1', NULL, '2019-07-21 16:57:31', '2019-07-21 16:57:31', '1'),
(13, 86, 'Toppings', '1', NULL, '2019-07-21 16:57:27', '2019-07-21 16:57:27', '1'),
(14, 86, 'Elige tu guarnición', '1', NULL, '2019-07-21 16:57:31', '2019-07-21 16:57:31', '1'),
(15, 87, '¿Deseas agregar algún extra?', '\'', 'Selecciona hasta 4', '2019-07-21 17:19:08', '2019-07-21 17:19:08', '1'),
(16, 87, '¿Deseas agregar algún extra?', '0', 'Selecciona hasta 4', '2019-07-21 17:24:07', '2019-07-21 17:24:23', '2'),
(17, 92, '¿Deseas agregar algún extra?', '0', 'Selecciona hasta 4', '2019-07-21 17:25:50', '2019-07-21 17:25:50', '1'),
(18, 96, 'Elige tu gaseosa preferida', '1', NULL, '2019-07-21 17:35:02', '2019-07-21 17:35:02', '1'),
(19, 97, 'Elige el tipo de agua', '1', NULL, '2019-07-21 17:35:20', '2019-07-21 17:35:20', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tw_categoria`
--

CREATE TABLE `tw_categoria` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `categoria` varchar(150) NOT NULL,
  `creacion` datetime NOT NULL,
  `estado` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tw_categoria`
--

INSERT INTO `tw_categoria` (`id`, `id_usuario`, `categoria`, `creacion`, `estado`) VALUES
(1, 1, 'Desayuno', '2019-01-01 15:00:00', '1'),
(2, 1, 'Sandwiches', '2019-01-01 15:00:00', '1'),
(3, 1, 'Entradas y Piqueos', '2019-01-01 15:00:00', '1'),
(4, 1, 'Ensaladas y Sopas', '2019-01-01 15:00:00', '1'),
(5, 1, 'Platos de fondo', '2019-01-01 15:00:00', '1'),
(6, 1, 'Pastas y Arroces', '2019-01-01 15:00:00', '1'),
(7, 1, 'Postres', '2019-01-01 15:00:00', '1'),
(8, 1, 'Bebidas', '2019-01-01 15:00:00', '2'),
(9, 2, 'Milanesas', '2019-07-21 15:52:53', '1'),
(10, 2, 'Para compartir', '2019-07-21 15:53:15', '1'),
(11, 2, 'Sánguches y wraps', '2019-07-21 16:03:26', '1'),
(12, 2, 'Bebidas', '2019-07-21 16:04:05', '1'),
(13, 2, 'Postres', '2019-07-21 16:09:05', '1'),
(14, 2, 'abc', '2019-07-21 16:09:34', '3'),
(15, 2, 'Carne', '2019-07-21 16:10:30', '3'),
(16, 2, 'carne', '2019-07-21 16:11:16', '3'),
(17, 2, 'carne', '2019-07-21 16:14:16', '3'),
(18, 2, 'carne', '2019-07-21 16:16:29', '3'),
(19, 2, 'categoria', '2019-07-21 16:17:53', '2'),
(20, 2, 'asd', '2019-07-21 16:18:51', '2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tw_extras`
--

CREATE TABLE `tw_extras` (
  `id` int(11) NOT NULL,
  `id_agregado` int(11) NOT NULL,
  `extra` varchar(100) NOT NULL,
  `precio` varchar(10) DEFAULT NULL,
  `mensaje` text,
  `creacion` datetime NOT NULL,
  `edicion` datetime NOT NULL,
  `estado` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tw_extras`
--

INSERT INTO `tw_extras` (`id`, `id_agregado`, `extra`, `precio`, `mensaje`, `creacion`, `edicion`, `estado`) VALUES
(1, 1, 'Naranja', '1.00', NULL, '2019-07-16 13:40:18', '2019-07-16 13:40:18', '1'),
(2, 1, 'Piña', '2.00', NULL, '2019-07-16 13:43:51', '2019-07-16 19:14:21', '1'),
(3, 1, 'Papaya', '3.00', NULL, '2019-07-16 16:36:44', '2019-07-16 16:36:44', '1'),
(4, 2, 'Café', '1.00', NULL, '2019-07-16 16:41:36', '2019-07-16 16:41:36', '1'),
(5, 2, 'Té', '2.00', NULL, '2019-07-16 18:05:45', '2019-07-16 18:05:45', '1'),
(6, 2, 'Infusión', '3.00', NULL, '2019-07-16 18:08:37', '2019-07-16 18:08:37', '1'),
(7, 3, 'Revueltos', '1.00', NULL, '2019-07-16 18:15:31', '2019-07-16 18:15:31', '1'),
(8, 3, 'Fritos', '2.00', NULL, '2019-07-16 18:17:42', '2019-07-16 18:17:42', '1'),
(9, 4, 'Jugos', '1.00', NULL, '2019-07-16 18:20:31', '2019-07-16 20:11:02', '2'),
(10, 4, 'Jugos', '2.00', NULL, '2019-07-16 18:32:40', '2019-07-16 20:10:06', '2'),
(11, 4, 'fresa', '3.00', NULL, '2019-07-16 19:05:45', '2019-07-16 20:10:11', '2'),
(12, 1, 'fresa', '4.00', NULL, '2019-07-16 20:04:24', '2019-07-16 20:16:43', '2'),
(13, 4, 'Fresa', '4.00', NULL, '2019-07-16 20:11:12', '2019-07-16 20:11:12', '1'),
(14, 5, 'bebida 1', '2.00', NULL, '2019-07-18 18:52:22', '2019-07-18 18:52:22', '1'),
(15, 5, 'bebida 2', '1.00', NULL, '2019-07-18 18:52:29', '2019-07-18 18:52:29', '1'),
(16, 4, 'piña', '1.00', NULL, '2019-07-18 18:52:37', '2019-07-18 18:52:37', '1'),
(17, 7, 'Napolitana', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(18, 7, 'Despachada', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(19, 7, 'Capresse', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(20, 7, 'Figuretti', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(21, 7, 'Colorada', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(22, 7, 'Confundida', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(23, 7, 'Acevichada', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(24, 7, 'Mediterránea', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(25, 7, 'Milaburguer', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(26, 7, 'Anticuchera', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(27, 8, 'Papas tumbay', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(28, 8, 'Camote frito', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(29, 8, 'Ensalada mixta', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(30, 8, 'Ensalada de col', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(31, 8, 'Arroz', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(32, 8, 'Puré de papa', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(33, 8, 'Puré de papa al pesto', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(34, 8, 'Puré de papa a las finas hierbas', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(35, 8, 'Pasta Pesto', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(36, 8, 'Pasta Rosada', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(37, 8, 'Pasta Alfredo', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(38, 8, 'Pasta a la huancaína', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(39, 8, 'Pasta BBQ', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(40, 8, 'Ensalada Luchita', '4', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(41, 8, 'Ensalada Alemana', '4', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(42, 8, 'Ensalada Paltaza', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(43, 9, 'Napolitana', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(44, 9, 'Despachada', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(45, 9, 'Capresse', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(46, 9, 'Figuretti', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(47, 9, 'Colorada', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(48, 9, 'Confundida', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(49, 9, 'Acevichada', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(50, 9, 'Mediterránea', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(51, 9, 'Milaburguer', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(52, 9, 'Anticuchera', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(53, 10, 'Papas tumbay', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(54, 10, 'Camote frito', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(55, 10, 'Ensalada mixta', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(56, 10, 'Ensalada de col', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(57, 10, 'Arroz', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(58, 10, 'Puré de papa', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(59, 10, 'Puré de papa al pesto', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(60, 10, 'Puré de papa a las finas hierbas', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(61, 10, 'Pasta Pesto', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(62, 10, 'Pasta Rosada', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(63, 10, 'Pasta Alfredo', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(64, 10, 'Pasta a la huancaína', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(65, 10, 'Pasta BBQ', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(66, 10, 'Ensalada Luchita', '4', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(67, 10, 'Ensalada Alemana', '4', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(68, 10, 'Ensalada Paltaza', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(69, 11, 'Napolitana', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(70, 11, 'Despachada', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(71, 11, 'Capresse', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(72, 11, 'Figuretti', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(73, 11, 'Colorada', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(74, 11, 'Confundida', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(75, 11, 'Acevichada', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(76, 11, 'Mediterránea', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(77, 11, 'Milaburguer', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(78, 11, 'Anticuchera', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(79, 12, 'Papas tumbay', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(80, 12, 'Camote frito', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(81, 12, 'Ensalada mixta', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(82, 12, 'Ensalada de col', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(83, 12, 'Arroz', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(84, 12, 'Puré de papa', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(85, 12, 'Puré de papa al pesto', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(86, 12, 'Puré de papa a las finas hierbas', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(87, 12, 'Pasta Pesto', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(88, 12, 'Pasta Rosada', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(89, 12, 'Pasta Alfredo', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(90, 12, 'Pasta a la huancaína', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(91, 12, 'Pasta BBQ', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(92, 12, 'Ensalada Luchita', '4', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(93, 12, 'Ensalada Alemana', '4', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(94, 12, 'Ensalada Paltaza', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(95, 13, 'Napolitana', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(96, 13, 'Despachada', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(97, 13, 'Capresse', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(98, 13, 'Figuretti', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(99, 13, 'Colorada', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(100, 13, 'Confundida', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(101, 13, 'Acevichada', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(102, 13, 'Mediterránea', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(103, 13, 'Milaburguer', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(104, 13, 'Anticuchera', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(105, 14, 'Papas tumbay', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(106, 14, 'Camote frito', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(107, 14, 'Ensalada mixta', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(108, 14, 'Ensalada de col', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(109, 14, 'Arroz', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(110, 14, 'Puré de papa', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(111, 14, 'Puré de papa al pesto', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(112, 14, 'Puré de papa a las finas hierbas', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(113, 14, 'Pasta Pesto', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(114, 14, 'Pasta Rosada', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(115, 14, 'Pasta Alfredo', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(116, 14, 'Pasta a la huancaína', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(117, 14, 'Pasta BBQ', '3', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(118, 14, 'Ensalada Luchita', '4', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(119, 14, 'Ensalada Alemana', '4', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(120, 14, 'Ensalada Paltaza', '0', NULL, '2019-07-21 17:40:20', '2019-07-21 17:40:20', '1'),
(121, 15, 'Extra bites', '4', NULL, '2019-07-21 17:55:59', '2019-07-21 17:55:59', '1'),
(122, 15, 'Extra huevo', '2', NULL, '2019-07-21 17:56:10', '2019-07-21 17:56:10', '1'),
(123, 15, 'Extra plátano', '2', NULL, '2019-07-21 17:56:28', '2019-07-21 17:56:28', '1'),
(124, 15, 'Extra salchicha', '3', NULL, '2019-07-21 17:56:40', '2019-07-21 17:56:40', '1'),
(125, 17, 'Extra bites', '4', NULL, '2019-07-21 17:57:42', '2019-07-21 17:57:42', '1'),
(126, 17, 'Extra huevo', '2', NULL, '2019-07-21 17:57:53', '2019-07-21 17:57:53', '1'),
(127, 17, 'Extra plátano', '2', NULL, '2019-07-21 17:58:09', '2019-07-21 17:58:09', '1'),
(128, 17, 'Extra salchicha', '3', NULL, '2019-07-21 17:58:20', '2019-07-21 17:58:20', '1'),
(129, 18, 'Fanta', '0', NULL, '2019-07-21 17:58:58', '2019-07-21 17:58:58', '1'),
(130, 18, 'Sprite', '0', NULL, '2019-07-21 17:59:10', '2019-07-21 17:59:10', '1'),
(131, 18, 'Coca Cola', '0', NULL, '2019-07-21 17:59:15', '2019-07-21 17:59:15', '1'),
(132, 18, 'Coca Cola Zero', '0', NULL, '2019-07-21 17:59:21', '2019-07-21 17:59:21', '1'),
(133, 18, 'Inca Kola', '0', NULL, '2019-07-21 17:59:29', '2019-07-21 17:59:29', '1'),
(134, 18, 'Inca Kola Zero', '0', NULL, '2019-07-21 17:59:37', '2019-07-21 17:59:37', '1'),
(135, 19, 'Sin gas', '0', NULL, '2019-07-21 18:00:10', '2019-07-21 18:00:10', '1'),
(136, 19, 'Con gas', '0', NULL, '2019-07-21 18:00:15', '2019-07-21 18:00:15', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tw_pedido`
--

CREATE TABLE `tw_pedido` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `codigo_pedido` char(6) NOT NULL,
  `total` decimal(8,2) NOT NULL,
  `creado` datetime NOT NULL,
  `estado` char(1) NOT NULL,
  `visto` char(1) NOT NULL,
  `reporte` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tw_pedido`
--

INSERT INTO `tw_pedido` (`id`, `id_usuario`, `id_cliente`, `codigo_pedido`, `total`, `creado`, `estado`, `visto`, `reporte`) VALUES
(1, 1, 1, 'JS2605', 34.00, '2019-08-17 14:05:11', '3', '1', ''),
(2, 1, 2, 'JS7454', 34.00, '2019-08-17 16:38:52', '3', '2', ''),
(3, 1, 2, 'JS4577', 34.00, '2019-08-17 17:09:24', '3', '2', ''),
(4, 1, 2, 'JS7575', 34.00, '2019-08-17 17:25:23', '3', '1', ''),
(5, 1, 2, 'JS9085', 34.00, '2019-08-18 11:49:05', '4', '1', ''),
(6, 1, 2, 'JS9039', 34.00, '2019-08-18 12:16:00', '4', '1', ''),
(7, 1, 2, 'JS4463', 34.00, '2019-08-18 12:18:22', '4', '1', ''),
(8, 1, 2, 'JS3067', 34.00, '2019-08-18 12:23:29', '4', '1', ''),
(9, 1, 2, 'JS1999', 34.00, '2019-08-18 12:26:34', '4', '1', ''),
(10, 1, 2, 'JS3115', 34.00, '2019-08-18 12:28:57', '4', '1', ''),
(11, 1, 2, 'JS0857', 34.00, '2019-08-18 13:32:43', '1', '1', ''),
(12, 1, 2, 'JS7493', 34.00, '2019-08-19 11:23:04', '4', '1', ''),
(13, 1, 2, 'JS5819', 34.00, '2019-08-19 18:30:34', '1', '0', ''),
(14, 3, 2, 'JS8657', 34.00, '2019-08-20 17:04:02', '1', '2', ''),
(15, 4, 1, 'JS9132', 53.00, '2019-08-21 15:07:20', '2', '2', ''),
(16, 1, 1, 'JS9457', 33.00, '2019-08-21 16:39:22', '1', '1', ''),
(17, 4, 1, 'JS7114', 20.00, '2019-08-22 08:26:55', '2', '2', ''),
(18, 1, 2, 'JS1873', 34.00, '2019-08-23 13:41:41', '4', '2', ''),
(19, 1, 2, 'JS7989', 34.00, '2019-08-23 17:47:52', '4', '2', ''),
(20, 1, 2, 'JS8353', 34.00, '2019-08-23 17:49:15', '3', '2', ''),
(21, 1, 2, 'JS8806', 34.00, '2019-08-23 17:59:16', '3', '2', ''),
(22, 3, 1, 'JS4937', 20.00, '2019-08-24 17:14:48', '1', '1', ''),
(23, 3, 2, 'JS4409', 31.00, '2019-08-28 20:50:52', '3', '2', ''),
(24, 5, 2, 'JS4961', 34.00, '2019-08-28 20:55:28', '4', '2', ''),
(25, 3, 2, 'JS5837', 68.00, '2019-08-28 20:58:31', '4', '2', ''),
(26, 5, 2, 'JS3840', 26.00, '2019-08-28 20:59:14', '3', '2', ''),
(27, 3, 2, 'JS0571', 24.00, '2019-08-28 21:00:40', '3', '2', ''),
(28, 5, 2, 'JS2448', 42.00, '2019-08-29 21:05:20', '2', '1', ''),
(29, 3, 2, 'JS5417', 146.00, '2019-08-29 21:05:27', '2', '1', ''),
(30, 5, 2, 'JS2291', 12.00, '2019-08-28 21:11:17', '3', '2', ''),
(31, 3, 2, 'JS4376', 34.00, '2019-08-28 21:21:06', '3', '2', ''),
(32, 5, 2, 'JS7171', 103.80, '2019-08-28 21:24:23', '1', '2', ''),
(33, 1, 2, 'JS8037', 6.00, '2019-08-29 13:23:38', '3', '2', ''),
(34, 6, 1, 'JS6856', 26.00, '2019-09-02 17:08:13', '1', '2', '1'),
(35, 1, 2, 'JS7227', 34.00, '2019-09-02 19:10:23', '3', '1', '1'),
(36, 3, 2, 'JS2656', 34.00, '2019-09-02 19:32:25', '3', '2', '1'),
(37, 5, 2, 'JS4541', 89.90, '2019-09-02 19:37:20', '3', '2', '1'),
(38, 7, 2, 'JS5925', 24.00, '2019-09-02 19:37:32', '3', '2', '1'),
(39, 4, 2, 'JS9197', 36.00, '2019-09-02 19:49:12', '4', '2', '1'),
(40, 5, 2, 'JS3021', 16.00, '2019-09-02 19:55:02', '3', '2', '1'),
(41, 7, 2, 'JS9346', 30.00, '2019-09-02 19:55:05', '3', '1', '1'),
(42, 3, 2, 'JS9171', 34.00, '2019-09-02 19:57:13', '3', '1', '1'),
(43, 5, 2, 'JS3317', 18.00, '2019-09-02 20:00:57', '1', '2', '1'),
(44, 3, 2, 'JS6598', 16.00, '2019-09-02 20:01:00', '1', '2', '1'),
(45, 4, 1, 'JS3603', 34.00, '2019-09-02 20:01:16', '4', '1', '1'),
(46, 4, 2, 'JS8719', 15.90, '2019-09-02 20:02:51', '1', '2', '1'),
(47, 7, 2, 'JS4624', 18.00, '2019-09-02 20:10:31', '1', '2', '1'),
(48, 1, 2, 'JS2676', 34.00, '2019-09-04 17:07:58', '2', '2', '1'),
(49, 1, 2, 'JS5253', 34.00, '2019-09-04 17:08:46', '4', '2', '1'),
(50, 1, 2, 'JS7991', 34.00, '2019-09-04 17:43:11', '2', '1', '1'),
(51, 1, 2, 'JS4017', 34.00, '2019-09-04 17:53:30', '4', '1', '1'),
(52, 1, 2, 'JS0734', 34.00, '2019-09-04 19:46:56', '4', '1', '1'),
(53, 1, 2, 'JS3099', 34.00, '2019-09-04 19:49:58', '4', '1', '1'),
(54, 1, 1, 'JS1711', 34.00, '2019-09-04 19:59:08', '4', '2', '1'),
(55, 1, 1, 'JS5362', 34.00, '2019-09-04 20:02:52', '4', '2', '1'),
(56, 7, 2, 'JS9806', 30.00, '2019-09-04 21:12:48', '1', '1', '1'),
(57, 7, 2, 'JS4845', 24.00, '2019-09-04 21:13:31', '1', '1', '1'),
(58, 7, 2, 'JS8567', 24.00, '2019-09-04 21:16:06', '1', '1', '1'),
(59, 7, 2, 'JS5883', 24.00, '2019-09-04 21:21:08', '1', '1', '1'),
(60, 1, 2, 'JS7875', 34.00, '2019-09-12 17:29:26', '3', '1', '1'),
(61, 3, 2, 'JS7935', 155.00, '2019-09-27 21:01:35', '3', '1', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tw_pedido_detalle`
--

CREATE TABLE `tw_pedido_detalle` (
  `id` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `data1` int(11) NOT NULL,
  `data2` varchar(10) NOT NULL,
  `data3` int(11) DEFAULT NULL,
  `data4` varchar(45) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tw_pedido_detalle`
--

INSERT INTO `tw_pedido_detalle` (`id`, `id_pedido`, `data1`, `data2`, `data3`, `data4`) VALUES
(459, 59, 93, 'producto', 1, NULL),
(458, 58, 93, 'producto', 1, NULL),
(457, 57, 93, 'producto', 1, NULL),
(456, 56, 87, 'producto', 1, NULL),
(455, 55, 1, 'extra', 7, NULL),
(454, 55, 1, 'extra', 5, NULL),
(453, 55, 1, 'extra', 1, NULL),
(452, 55, 1, 'producto', 1, NULL),
(451, 54, 1, 'extra', 7, NULL),
(450, 54, 1, 'extra', 5, NULL),
(449, 54, 1, 'extra', 1, NULL),
(448, 54, 1, 'producto', 1, NULL),
(447, 53, 1, 'extra', 7, NULL),
(446, 53, 1, 'extra', 5, NULL),
(445, 53, 1, 'extra', 1, NULL),
(444, 53, 1, 'producto', 1, NULL),
(443, 52, 1, 'extra', 7, NULL),
(442, 52, 1, 'extra', 5, NULL),
(441, 52, 1, 'extra', 1, NULL),
(440, 52, 1, 'producto', 1, NULL),
(439, 51, 1, 'extra', 7, NULL),
(438, 51, 1, 'extra', 5, NULL),
(437, 51, 1, 'extra', 1, NULL),
(436, 51, 1, 'producto', 1, NULL),
(435, 50, 83, 'extra', 27, NULL),
(434, 50, 83, 'extra', 17, NULL),
(433, 50, 83, 'producto', 1, NULL),
(432, 49, 2147483647, 'extra', 7, NULL),
(431, 49, 2147483647, 'extra', 5, NULL),
(430, 49, 2147483647, 'extra', 1, NULL),
(429, 49, 2147483647, 'producto', 1, NULL),
(428, 48, 2147483647, 'extra', 7, NULL),
(427, 48, 2147483647, 'extra', 5, NULL),
(426, 48, 2147483647, 'extra', 1, NULL),
(425, 48, 2147483647, 'producto', 1, NULL),
(424, 47, 89, 'producto', 1, NULL),
(423, 46, 99, 'producto', 1, 'No me traigan nada '),
(422, 45, 17, 'producto', 1, '3/4'),
(421, 44, 98, 'producto', 1, 'Con Nutella'),
(420, 43, 97, 'extra', 135, NULL),
(419, 43, 97, 'producto', 3, 'Sin helar'),
(418, 42, 85, 'extra', 79, NULL),
(417, 42, 85, 'extra', 69, NULL),
(416, 42, 85, 'producto', 1, NULL),
(415, 41, 87, 'producto', 1, NULL),
(414, 40, 98, 'producto', 1, 'De fresa'),
(413, 39, 97, 'extra', 135, NULL),
(412, 39, 97, 'producto', 1, NULL),
(411, 39, 96, 'extra', 133, NULL),
(410, 39, 96, 'producto', 1, 'Con hielo '),
(409, 39, 92, 'producto', 1, NULL),
(408, 38, 93, 'producto', 1, NULL),
(407, 37, 99, 'producto', 1, NULL),
(406, 37, 85, 'extra', 84, NULL),
(405, 37, 85, 'extra', 72, NULL),
(404, 37, 85, 'producto', 2, NULL),
(403, 36, 83, 'extra', 18, NULL),
(402, 36, 83, 'producto', 1, NULL),
(401, 35, 83, 'extra', 27, NULL),
(400, 35, 83, 'extra', 17, NULL),
(399, 35, 83, 'producto', 1, NULL),
(398, 34, 8, 'producto', 1, NULL),
(397, 33, 96, 'extra', 131, NULL),
(396, 33, 96, 'producto', 1, NULL),
(395, 32, 99, 'producto', 2, NULL),
(394, 32, 95, 'producto', 3, NULL),
(393, 31, 83, 'extra', 28, NULL),
(392, 31, 83, 'extra', 20, NULL),
(391, 31, 83, 'producto', 1, NULL),
(390, 30, 96, 'extra', 131, NULL),
(389, 30, 96, 'producto', 1, 'Test'),
(388, 29, 88, 'producto', 2, NULL),
(387, 29, 87, 'producto', 1, 'Huevo Solo la Clara'),
(386, 29, 98, 'producto', 1, 'Con Nutella'),
(385, 29, 94, 'producto', 3, NULL),
(384, 28, 96, 'extra', 129, NULL),
(383, 28, 96, 'producto', 2, 'Sin gas, sin helar y hielo aparte'),
(382, 28, 89, 'producto', 1, 'Sin aceite'),
(381, 27, 92, 'producto', 1, 'Sin verduras'),
(380, 26, 90, 'producto', 1, NULL),
(379, 25, 85, 'extra', 80, NULL),
(378, 25, 85, 'extra', 70, NULL),
(377, 25, 85, 'producto', 2, NULL),
(376, 24, 85, 'extra', 81, NULL),
(375, 24, 85, 'extra', 71, NULL),
(374, 24, 85, 'producto', 1, NULL),
(373, 23, 84, 'extra', 53, NULL),
(372, 23, 84, 'extra', 43, NULL),
(371, 23, 84, 'producto', 1, NULL),
(370, 22, 13, 'producto', 1, NULL),
(369, 21, 83, 'extra', 27, NULL),
(368, 21, 83, 'extra', 17, NULL),
(367, 21, 83, 'producto', 1, NULL),
(366, 20, 83, 'extra', 27, NULL),
(365, 20, 83, 'extra', 17, NULL),
(364, 20, 83, 'producto', 1, NULL),
(363, 19, 83, 'extra', 27, NULL),
(362, 19, 83, 'extra', 22, NULL),
(361, 19, 83, 'producto', 1, NULL),
(360, 18, 83, 'extra', 27, NULL),
(359, 18, 83, 'extra', 17, NULL),
(358, 18, 83, 'producto', 1, NULL),
(357, 17, 13, 'producto', 1, NULL),
(356, 16, 1, 'extra', 7, NULL),
(355, 16, 1, 'extra', 4, NULL),
(354, 16, 1, 'extra', 1, NULL),
(353, 16, 1, 'producto', 1, NULL),
(352, 15, 13, 'producto', 1, NULL),
(351, 15, 1, 'extra', 7, NULL),
(350, 15, 1, 'extra', 4, NULL),
(349, 15, 1, 'extra', 1, NULL),
(348, 15, 1, 'producto', 1, 'Café sin azúcar '),
(347, 14, 83, 'extra', 27, NULL),
(346, 14, 83, 'extra', 17, NULL),
(345, 14, 83, 'producto', 1, NULL),
(344, 13, 83, 'extra', 27, NULL),
(343, 13, 83, 'extra', 18, NULL),
(342, 13, 83, 'producto', 1, NULL),
(341, 12, 83, 'extra', 27, NULL),
(340, 12, 83, 'extra', 17, NULL),
(339, 12, 83, 'producto', 1, NULL),
(338, 11, 83, 'extra', 27, NULL),
(337, 11, 83, 'extra', 17, NULL),
(336, 11, 83, 'producto', 1, NULL),
(335, 10, 83, 'extra', 27, NULL),
(334, 10, 83, 'extra', 17, NULL),
(333, 10, 83, 'producto', 1, NULL),
(332, 9, 83, 'extra', 27, NULL),
(331, 9, 83, 'extra', 17, NULL),
(330, 9, 83, 'producto', 1, NULL),
(329, 8, 83, 'extra', 27, NULL),
(328, 8, 83, 'extra', 17, NULL),
(327, 8, 83, 'producto', 1, NULL),
(326, 7, 83, 'extra', 27, NULL),
(325, 7, 83, 'extra', 17, NULL),
(324, 7, 83, 'producto', 1, NULL),
(323, 6, 83, 'extra', 28, NULL),
(322, 6, 83, 'extra', 17, NULL),
(321, 6, 83, 'producto', 1, NULL),
(320, 5, 83, 'extra', 28, NULL),
(319, 5, 83, 'extra', 18, NULL),
(318, 5, 83, 'producto', 1, NULL),
(1, 1, 1, 'producto', 1, NULL),
(2, 1, 1, 'extra', 1, NULL),
(3, 1, 1, 'extra', 5, NULL),
(4, 1, 1, 'extra', 7, NULL),
(5, 2, 83, 'producto', 1, NULL),
(6, 2, 83, 'extra', 17, NULL),
(7, 2, 83, 'extra', 27, NULL),
(8, 3, 83, 'producto', 1, NULL),
(9, 3, 83, 'extra', 17, NULL),
(10, 3, 83, 'extra', 27, NULL),
(11, 4, 83, 'producto', 1, NULL),
(12, 4, 83, 'extra', 17, NULL),
(13, 4, 83, 'extra', 27, NULL),
(460, 60, 83, 'producto', 1, NULL),
(461, 60, 83, 'extra', 17, NULL),
(462, 60, 83, 'extra', 27, NULL),
(463, 61, 83, 'producto', 1, NULL),
(464, 61, 83, 'extra', 17, NULL),
(465, 61, 83, 'extra', 27, NULL),
(466, 61, 84, 'producto', 1, NULL),
(467, 61, 84, 'extra', 43, NULL),
(468, 61, 84, 'extra', 53, NULL),
(469, 61, 85, 'producto', 1, NULL),
(470, 61, 85, 'extra', 69, NULL),
(471, 61, 85, 'extra', 79, NULL),
(472, 61, 86, 'producto', 1, NULL),
(473, 61, 86, 'extra', 95, NULL),
(474, 61, 86, 'extra', 105, NULL),
(475, 61, 87, 'producto', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tw_producto`
--

CREATE TABLE `tw_producto` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `producto` varchar(150) NOT NULL,
  `precio` varchar(10) NOT NULL,
  `imagen` longtext,
  `descripcion` text,
  `creacion` datetime NOT NULL,
  `obligatorio` char(1) DEFAULT NULL,
  `opcional` varchar(100) DEFAULT NULL,
  `estado` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tw_producto`
--

INSERT INTO `tw_producto` (`id`, `id_usuario`, `id_categoria`, `producto`, `precio`, `imagen`, `descripcion`, `creacion`, `obligatorio`, `opcional`, `estado`) VALUES
(1, 1, 1, 'Desayuno Bonbonniere', '30', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/Desayuno-Bonbonniere-300x225.jpg', 'Jugo (naranja, piña, papaya). Café, té o infusión. Huevos fritos o revueltos. Waffles o tostadas francesas (Media porción). Canasta de panes con mantequilla & mermelada de la casa.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(2, 1, 1, 'Desayuno Light', '30', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/Desayuno-Light-300x225.jpg', 'Jugo (naranja, piña, papaya). Café, té o infusión. Ensalada de frutas. Omelette light. Tostadas de pan campesino.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(3, 1, 1, 'Desayuno Continental', '22', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/06A8299-300x200.jpg', 'Jugo (naranja, piña, papaya). Café, té o infusión. Huevos fritos o revueltos. Canasta de panes con mantequilla & mermelada de la casa.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(4, 1, 1, 'Desayuno Americano', '24', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/06A8286-300x200.jpg', 'Jugo (naranja, piña, papaya). Café, té o infusión. Canasta de panes con mantequilla y mermelada de la casa.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(5, 1, 1, 'Tostada Francesa', '22', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/01Tostada-Francesa-300x200.jpg', 'Bañada en miel de maple y mantequilla francesa.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(6, 1, 1, 'Canasta de panes', '9', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/02canasta-de-panes-300x200.jpg', 'Con mantequilla & mermelada de la casa.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(7, 1, 1, 'Ensalada de Frutas', '18', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/03ensalada-de-frutas-300x200.jpg', 'Frutas de estación con miel de abejas, yogurt y granola.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(8, 1, 1, 'Huevos Benedict', '26', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/04huevos-benedict-300x200.jpg', 'Pan brioche con jamón inglés y huevo poché bañado en salsa holandesa.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(9, 1, 1, 'Omellete Bonbonniere', '24', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/05Omelet-bonbonniere-300x200.jpg', 'Con queso Edam, jamón inglés, champiñones, cebollas y pimientos.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(10, 1, 1, 'Omelette Light', '22', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/06Omelet-Light-300x200.jpg', 'De claras, con queso fresco  y verduras salteadas.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(11, 1, 1, 'Croissant Mixto', '18', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/Croissant-Jamo%CC%81n-y-Queso-300x200.jpg', 'Caliente de jamón inglés y queso.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(12, 1, 1, 'Waffles', '22', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/07wafles-300x200.jpg', 'Bañados en miel de maple y mantequilla francesa.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(13, 1, 2, 'Pita Caprese', '20', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/IMG_0294-1-300x200.jpg', 'Pan pita integral relleno de mozzarella, tomate, albahaca y aceite de oliva.', '2019-07-03 21:43:32', NULL, NULL, '1'),
(14, 1, 2, 'Butifarra', '22', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/IMG_0282-300x200.jpg', 'Con jamón del país de receta casera, lechuga y  salsa criolla.', '2019-07-03 21:45:16', NULL, NULL, '1'),
(15, 1, 2, 'Hamburguesa Bonbonniere', '34', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/IMG_5488-300x200.jpg', 'Con queso, lechuga orgánica, tomate, cebolla salteada y papas fritas de la casa.', '2019-07-03 21:45:47', NULL, NULL, '1'),
(16, 1, 2, 'Croissant Mixto', '18', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/Croissant-Jamo%CC%81n-y-Queso-300x200.jpg', 'Caliente de jamón inglés y queso.\n', '2019-07-03 21:47:53', NULL, NULL, '1'),
(17, 1, 2, 'Hamburguesa con onion rings y tocino', '34', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/03hamburguesa-con-onion-rings-y-tocino-300x200.jpg', 'Con fonduta de tomates  y mayonesa al ajo. Se sirve con nuestras papas fritas.', '2019-07-04 01:10:36', NULL, NULL, '1'),
(18, 1, 2, 'De pavo con alcachofas', '29', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/04sandwich-de-pavo-con-alcachofas-300x200.jpg', 'Con lechuga, tomates, queso fresco y palta.\n', '2019-07-04 01:11:12', NULL, NULL, '1'),
(19, 1, 2, 'De Prosciutto di Parma', '29', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/IMG_5497-300x200.jpg', 'Con mozzarella horneada, aceite de oliva, albahaca y tomates confitados.', '2019-07-04 01:11:50', NULL, NULL, '1'),
(20, 1, 2, 'De pollo y palta', '22', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/IMG_0075-300x200.jpg', 'Con mayonesa de la casa.', '2019-07-04 01:12:27', NULL, NULL, '1'),
(21, 1, 3, 'Tartare de Salmón', '36', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/01tartare-de-salmon-300x200.jpg', 'Sobre ensalada de tomate y palta', '2019-01-01 15:00:00', NULL, NULL, '1'),
(22, 1, 3, 'Pizzeta mediterranea', '28', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/06pizzeta-mediterranea-300x200.jpg', 'Con champiñones, aceitunas verdes, jamón inglés, arúgula, balsámico y alcaparras.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(23, 1, 3, 'Ceviche carretillero', '44', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/03ceviche-carretillero-300x200.jpg', 'Igual al clásico pero servido con chicharrón de calamares.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(24, 1, 3, 'Pizzeta margherita', '28', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/04pizzeta-margherita-300x200.jpg', 'Con salsa pomodoro, mozzarella, albahaca fresca y tomate.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(25, 1, 3, 'Tiradito Apaltado', '38', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/tiradito-apaltado-300x200.jpg', 'Tiradito con palta, alcaparras y aceite de oliva.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(26, 1, 3, 'Humita con Queso Crema', '16', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/humita-300x200.jpg', 'Al ají amarillo', '2019-01-01 15:00:00', NULL, NULL, '1'),
(27, 1, 3, 'Ceviche de Pescado', '42', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/ceviche-de-pescado-300x200.jpg', 'Con cebolla roja cortada a la pluma y culantro.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(28, 1, 3, 'Focaccia al Tartufo', '28', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/forcaccia-al-tartufo-300x200.jpg', 'Rellena de quesos al aroma de trufa blanca.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(29, 1, 3, 'Pizzeta Prosciutto di Parma', '34', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/pizzeta-prosciutto-di-parma-1-300x225.jpg', 'Con mozzarella, pomodoro y parmesano.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(30, 1, 3, 'Nuestro pastel de Choclo', '28', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/pastel-de-choclo-300x200.jpg', 'Con ragú de cola de buey y salsa de hongos.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(31, 1, 3, 'Empanada Salteña', '12', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/IMG_0263-1-300x200.jpg', 'Receta boliviana original, con carne picada, papa y una pizca de picante.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(32, 1, 3, 'Carpaccio de Lomo', '36', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/Carpaccio-de-Lomo-300x225.jpg', 'Con alcaparras, arúgula, queso parmesano y salsa Harry´s Bar.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(33, 1, 3, 'Tequeños con Guacamole', '21', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/Teque%C3%B1os-300x225.png', 'De queso andino y mozzarella.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(34, 1, 3, 'Papas fritas al ajo y perejil', '10', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/IMG_0947-300x200.jpg', '', '2019-01-01 15:00:00', NULL, NULL, '1'),
(35, 1, 3, 'Tortilla de patatas a la española', '18', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/IMG_0038-1-300x200.jpg', 'Con ensaladita de pimiento morrón y arúgula.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(36, 1, 4, 'Prosciutto Di Parma', '35', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/IMG_0157-300x200.jpg', 'Con arúgula, tomates confitados, albahaca y mozzarella horneada.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(37, 1, 4, 'Sopa de Cebolla', '26', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/02sopa-criolla-1024x683.jpg', 'Con oporto y queso gratinado.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(38, 1, 4, 'Nuestra clásica de pavo', '32', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/03ensalada-de-pavo-300x200.jpg', 'Lechugas, espinaca, palta, alcachofas, choclo, queso  fresco y champiñones con vinagreta de la casa.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(39, 1, 4, 'Menestrón', '34', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/04menestrone-300x200.jpg', 'Clásico con carne, verduras y pasta corta.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(40, 1, 4, 'De quinua', '29', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/05ensalada-de-quinua-1024x683.jpg', 'De lechugas con quinua de tres colores, gajos de palta, queso fresco, tomate y arúgula.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(41, 1, 4, 'Crema del día', '18', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/06crema-del-di%CC%81a-300x200.jpg', '', '2019-01-01 15:00:00', NULL, NULL, '1'),
(42, 1, 4, 'Crema de Tomate', '24', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/IMG_0208-300x200.jpg', 'Con croutones y parmesano.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(43, 1, 4, 'Sopa Criolla', '29', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/sopa-criolla-300x200.jpg', 'Clásico con huevo frito montado.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(44, 1, 4, 'César con pollo', '32', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/06A8269-1024x683.jpg', 'Lechuga romana con croutones, ajos crocantes y queso parmesano.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(45, 1, 4, 'Sopa Adelina', '28', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/Sopa-Adelina-300x200.jpg', 'Receta casera de la abuela, con pollo, zapallo macre, yuca y cabello de angel.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(46, 1, 5, 'Salmón a la mantequilla de Dill', '52', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/02salmon-a-la-mantequilla-de-dill-300x200.jpg', 'Con verduras salteadas y puré de papas.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(47, 1, 5, 'Pollo a las finas hierbas', '38', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/IMG_0995-300x200.jpg', 'Con puré de papas amarillas y verduras salteadas.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(48, 1, 5, 'Lomo saltado criollo', '46', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/03lomo-saltado-300x200.jpg', 'Salteados al wok con cebolla, tomate y ají servido con arroz y papas fritas.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(49, 1, 5, 'Salmón teriyaki', '52', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/04salmon-teriyaki-300x200.jpg', 'Con arroz al wok, zanahorias, pecanas y champiñones.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(50, 1, 5, 'Pescado Meunière', '48', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/06pescado-meuniere-300x200.jpg', 'Con mantequilla, limón y alcaparras acompañado de espinacas salteadas y papas al vapor.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(51, 1, 5, 'Steak Frites', '51', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/IMG_0475-300x200.jpg', 'Con mantequilla de hierbas “Maître d’Hôtel” y papas fritas.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(52, 1, 5, 'Steak tartare', '48', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/05steak-tartare-300x200.jpg', 'Clásica receta francesa, servido con papas fritas y tostadas.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(53, 1, 6, 'Quinua al pesto con langostinos', '38', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/01quinua-al-pesto-con-langostinos-300x200.jpg', 'Con tomates confitados y champiñones salteados.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(54, 1, 6, 'Penne primavera', '32', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/02penne-primavera-300x200.jpg', 'En salsa pomodoro, queso mozzarella y albahaca.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(55, 1, 6, 'Fetuccini al ají amarillo con langostinos', '40', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/05fetuccini-a-la-crema-de-aji-con-langostinos-300x200.jpg', 'Con  champiñones y queso parmesano.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(56, 1, 6, 'Tallirín Saltado mar y tierra', '38', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/04tallarin-saltado-mixto-300x200.jpg', 'Con dados de lomo, champiñones y langostinos.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(57, 1, 6, 'Penne Sorrentino', '32', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/IMG_0219-300x200.jpg', 'En salsa pomodoro, queso mozzarella y albahaca.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(58, 1, 6, 'Gnocchi a los cuatro quesos', '34', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/IMG_0177-300x200.jpg', 'Gratinado con parmesano.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(59, 1, 6, 'Ravioles de Ricotta y Espinaca', '32', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/IMG_0322-300x200.jpg', 'Con mantequilla y salvia.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(60, 1, 6, 'Risotto a la crema de ajíes con Lomo', '44', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/IMG_0428-300x200.jpg', 'Con ají, rocoto y queso parmesano.', '2019-01-01 15:00:00', NULL, NULL, '1'),
(61, 1, 7, 'Tortita de lúcuma', '22', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/01tortita-de-lucuma-300x200.jpg', 'Con salsa de chocolate.', '2019-07-04 02:05:44', NULL, NULL, '1'),
(62, 1, 7, 'Cocada', '22', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/04cocada-300x200.jpg', 'Horneada lentamente y servida con manjar de yemas.', '2019-07-04 02:06:38', NULL, NULL, '1'),
(63, 1, 7, 'New York cheesecake', '22', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/05New-York-Cheesecake-300x200.jpg', 'Con fresas frescas y salsa de fresas.', '2019-07-04 02:07:19', NULL, NULL, '1'),
(64, 1, 7, 'Pie de limón', '15', 'https://www.labonbonniere.pe/wp-content/uploads/2016/12/06pie-de-limon-300x200.jpg', 'Con merengue italiano gratinado.', '2019-07-04 02:07:59', NULL, NULL, '1'),
(65, 1, 7, 'Crème Brûlée', '19', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/creme-brule-300x200.jpg', 'Cremoso postre francés con cubierta de caramelo quemado.', '2019-07-04 02:08:34', NULL, NULL, '1'),
(66, 1, 7, 'Torta de Chocolate', '16', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/torta-de-chocolate-300x200.jpg', NULL, '2019-07-04 02:09:17', NULL, NULL, '1'),
(67, 1, 7, 'Volcán de Chocolate', '22', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/volcan-de-chocolate-300x200.jpg', 'Nuestra clásica Petite Gateau con relleno de chocolate y helado de vainilla.', '2019-07-04 02:09:58', NULL, NULL, '1'),
(68, 1, 7, 'Crepe Suchard', '22', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/crepe-suchard-300x200.jpg', 'Con helado de vainilla, salsa de chocolate, toffee y caramelo.', '2019-07-04 02:10:24', NULL, NULL, '1'),
(69, 1, 7, 'Profiteroles', '22', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/Helado-la-bonbonniere-300x200.jpg', 'Con helado de vainilla y bañados con salsa tibia de chocolate.', '2019-07-04 02:10:50', NULL, NULL, '1'),
(70, 1, 7, 'Cake de Zanahoria', '14', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/cake-de-zanahoria-300x200.jpg', 'Con glaceado de azúcar y queso crema.', '2019-07-04 02:11:18', NULL, NULL, '1'),
(71, 1, 7, 'Budín de Brioche', '9', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/crema-volteada-300x200.jpg', 'Con ralladura de naranja.', '2019-07-04 02:11:56', NULL, NULL, '1'),
(72, 1, 7, 'Crema volteada', '15', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/Crema-Volteada-300x225.jpg', 'Con salsa de caramelo.', '2019-07-04 02:14:08', NULL, NULL, '1'),
(73, 1, 7, 'Crocante de manzana', '22', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/crocante-de-manzana-300x200.jpg', 'Con crumble de pecanas y helado de vainilla.', '2019-07-04 02:14:39', NULL, NULL, '1'),
(74, 1, 7, 'Galletas Surtidas', '10', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/galletas-surtidas-300x200.jpg', 'x 100 gr.', '2019-07-04 02:15:37', NULL, NULL, '1'),
(75, 1, 7, 'Guarguero', '9', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/guarguero-300x200.jpg', 'Relleno de manjar blanco de la casa.', '2019-07-04 02:16:04', NULL, NULL, '1'),
(76, 1, 7, 'Dulces', '3.5', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/dulces-surtidos-1-300x200.jpg', 'Trufas, canelitas, manás, mini alfajor.', '2019-07-04 02:16:33', NULL, NULL, '1'),
(77, 1, 7, 'Alfajor', '9', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/alfajor-300x200.jpg', 'Relleno de manjar blanco de la casa.', '2019-07-04 02:17:00', NULL, NULL, '1'),
(78, 1, 1, 'pan', '5', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/Desayuno-Bonbonniere-300x225.jpg', 'pan con mantequilla,mermelada o manjar blanco.', '2019-07-12 13:32:40', NULL, NULL, '2'),
(79, 1, 1, 'pan', '5', 'https://www.labonbonniere.pe/wp-content/uploads/2016/11/Desayuno-Bonbonniere-300x225.jpg', 'pan con mantequilla,mermelada o manjar blanco.', '2019-07-12 13:33:11', NULL, NULL, '2'),
(80, 1, 1, 'camote', '10', 'http://www.labonbonniere.pe/wp-content/uploads/2016/11/Desayuno-Light-300x225.jpg', 'camote serrano', '2019-07-12 14:18:29', NULL, NULL, '2'),
(81, 1, 1, 'choclo', '9', 'http://www.labonbonniere.pe/wp-content/uploads/2016/11/Desayuno-Light-300x225.jpg', 'choclo', '2019-07-12 14:19:47', NULL, NULL, '2'),
(82, 2, 9, 'carne', '34', NULL, NULL, '2019-07-21 16:28:29', NULL, NULL, '2'),
(83, 2, 9, 'Carne', '34', NULL, NULL, '2019-07-21 16:28:29', NULL, NULL, '1'),
(84, 2, 9, 'Pollo', '31', NULL, NULL, '2019-07-21 16:28:29', NULL, NULL, '1'),
(85, 2, 9, 'Pescado', '34', NULL, NULL, '2019-07-21 16:28:29', NULL, NULL, '1'),
(86, 2, 9, 'Berenjena', '26', NULL, NULL, '2019-07-21 16:28:29', NULL, NULL, '1'),
(87, 2, 10, 'Salchinesa', '30', 'https://d1ralsognjng37.cloudfront.net/178cd5b6-b1d5-46ee-94c2-55423d8ba61b', 'Papas fritas, camotes fritos, salchicha frankfurter, bites de pollo, huevo montado, acompañados de salsa de col, BBQ.', '2019-07-21 16:28:29', NULL, NULL, '1'),
(88, 2, 10, 'Pan al ajo', '14', NULL, NULL, '2019-07-21 16:28:29', NULL, NULL, '1'),
(89, 2, 10, 'Papas Bravas', '18', NULL, NULL, '2019-07-21 16:28:29', NULL, NULL, '1'),
(90, 2, 10, 'Canchinesa', '26', NULL, NULL, '2019-07-21 16:28:29', NULL, NULL, '1'),
(91, 2, 10, 'Quesadiiia milanesa', '26', NULL, NULL, '2019-07-21 16:28:29', NULL, NULL, '1'),
(92, 2, 11, 'Milawrap', '24', NULL, 'wrap de milanesa acompañado de una porción de papas tumbay', '2019-07-21 16:28:29', NULL, NULL, '1'),
(93, 2, 11, 'Mila Gucho BBQ', '24', NULL, NULL, '2019-07-21 16:28:29', NULL, NULL, '1'),
(94, 2, 11, 'Mila Guchote Peruano', '24', NULL, NULL, '2019-07-21 16:28:29', NULL, NULL, '1'),
(95, 2, 11, 'Mila Guchón Carnoso', '24', NULL, NULL, '2019-07-21 16:28:29', NULL, NULL, '1'),
(96, 2, 12, 'Gaseosas', '6', NULL, NULL, '2019-07-21 16:28:29', NULL, NULL, '1'),
(97, 2, 12, 'Aguas', '6', NULL, NULL, '2019-07-21 16:28:29', NULL, NULL, '1'),
(98, 2, 13, 'Torta de Chocolate', '16', NULL, NULL, '2019-07-21 16:28:29', NULL, NULL, '1'),
(99, 1, 12, 'Wrap + bebida', '15.9', NULL, NULL, '2019-07-22 13:03:41', NULL, NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tw_usuario`
--

CREATE TABLE `tw_usuario` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `clave` blob NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `direccion` text NOT NULL,
  `genero` char(1) NOT NULL,
  `nacimiento` date NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `creado` datetime NOT NULL,
  `estado` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tw_usuario`
--

INSERT INTO `tw_usuario` (`id`, `usuario`, `clave`, `nombre`, `apellido`, `direccion`, `genero`, `nacimiento`, `telefono`, `creado`, `estado`) VALUES
(1, 'jgsombra@outlook.com', 0x93f5b92f59d830bf662dc9087f7cc4a3, 'Juan', 'Serruto', '', '', '1988-09-19', '980904978', '0000-00-00 00:00:00', '1'),
(2, 'gssombra@gmail.com', 0x136562cd1573dbf03dcea913dc09e5e2, 'Juan', 'Serruto', 'calle # 123', '2', '1988-09-19', '980904978', '0000-00-00 00:00:00', '1'),
(3, 'cesarp23@hotmail.com', 0x93f5b92f59d830bf662dc9087f7cc4a3, 'Cesar', 'Pfeiffer', 'TOMAS EDISON 296, SAN ISIDRO', '2', '1986-09-23', '', '0000-00-00 00:00:00', '1'),
(4, 'jor_ayala@yahoo.com', 0x1d2d6b5c20d74a2a61ef95bc1c5b7306, 'Jorge', 'Ayala', 'Av san Borja sur 664', '2', '1984-09-22', '', '0000-00-00 00:00:00', '1'),
(5, 'mijail.al@gmail.com', 0x928a5be5c29294824caf587927fb703a, 'Mijail', 'Alania', 'Av. Cesar Vallejo 353 Dpto 904 Lince, Lince', '2', '1986-06-11', '', '0000-00-00 00:00:00', '1'),
(6, 'lucianopumai@gmail.com', 0x34761d7aa6150b5d64ce4b85df3bbb11, 'Luciano', 'Puma Indigoyen', ' ', '2', '1965-05-04', '', '0000-00-00 00:00:00', '1'),
(7, 'emilriosc@gmail.com', 0xd0c19bd24a2eb8ad8f5b183161649b01, 'Emil', 'Rios', 'Pueblo libre', '2', '1976-11-22', '', '0000-00-00 00:00:00', '1'),
(8, 'juan.usuario.ad@gmail.com', 0x1d2d6b5c20d74a2a61ef95bc1c5b7306, 'juan', 'jose', 'cayma ', '2', '1984-12-12', '921775479', '2020-05-07 05:50:04', '1');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `p4u_cliente`
--
ALTER TABLE `p4u_cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `p4u_clienteDetalle`
--
ALTER TABLE `p4u_clienteDetalle`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `p4u_producto`
--
ALTER TABLE `p4u_producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tw_agregado`
--
ALTER TABLE `tw_agregado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tw_categoria`
--
ALTER TABLE `tw_categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tw_extras`
--
ALTER TABLE `tw_extras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tw_pedido`
--
ALTER TABLE `tw_pedido`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tw_pedido_detalle`
--
ALTER TABLE `tw_pedido_detalle`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tw_producto`
--
ALTER TABLE `tw_producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tw_usuario`
--
ALTER TABLE `tw_usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `p4u_cliente`
--
ALTER TABLE `p4u_cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `p4u_clienteDetalle`
--
ALTER TABLE `p4u_clienteDetalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `p4u_producto`
--
ALTER TABLE `p4u_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `tw_agregado`
--
ALTER TABLE `tw_agregado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `tw_categoria`
--
ALTER TABLE `tw_categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `tw_extras`
--
ALTER TABLE `tw_extras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT de la tabla `tw_pedido`
--
ALTER TABLE `tw_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `tw_pedido_detalle`
--
ALTER TABLE `tw_pedido_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=476;

--
-- AUTO_INCREMENT de la tabla `tw_producto`
--
ALTER TABLE `tw_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT de la tabla `tw_usuario`
--
ALTER TABLE `tw_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
