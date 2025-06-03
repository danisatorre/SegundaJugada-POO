-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307
-- Tiempo de generación: 03-06-2025 a las 14:21:49
-- Versión del servidor: 11.5.2-MariaDB
-- Versión de PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `segunda_jugada`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actor`
--

DROP TABLE IF EXISTS `actor`;
CREATE TABLE IF NOT EXISTS `actor` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(64) NOT NULL,
  `apellidos` varchar(64) NOT NULL,
  `imdb` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `actor`
--

INSERT INTO `actor` (`id`, `nombre`, `apellidos`, `imdb`) VALUES
(1, 'Harrison', 'Ford', 'nm0000148'),
(2, 'Russell', 'Crowe', 'nm0000128');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carousel_home`
--

DROP TABLE IF EXISTS `carousel_home`;
CREATE TABLE IF NOT EXISTS `carousel_home` (
  `id_cphome` int(2) NOT NULL,
  `ruta_img` varchar(250) NOT NULL,
  PRIMARY KEY (`id_cphome`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `carousel_home`
--

INSERT INTO `carousel_home` (`id_cphome`, `ruta_img`) VALUES
(1, 'carouselPrincipal_camisetas.jpg'),
(2, 'carouselPrincipal_balones.jpg'),
(3, 'carouselPrincipal_zapatillas.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `categoria` varchar(30) NOT NULL,
  `img_categoria` varchar(255) NOT NULL,
  `visitas_cat` int(20) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=800 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `categoria`, `img_categoria`, `visitas_cat`) VALUES
(1, 'hombre', 'hombre.png', 15),
(2, 'mujer', 'mujer.png', 7),
(3, 'ninos', 'ninos.png', 1),
(4, 'adolescentes', 'adolescentes.png', 3),
(5, 'bebes', 'bebes.png', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
CREATE TABLE IF NOT EXISTS `comentarios` (
  `id_comentario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user_local` int(10) UNSIGNED DEFAULT NULL,
  `id_user_google` varchar(250) DEFAULT NULL,
  `id_user_github` varchar(250) DEFAULT NULL,
  `id_producto_comentario` int(20) UNSIGNED NOT NULL,
  `comentario` varchar(250) NOT NULL,
  `fecha` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_comentario`),
  KEY `fk_comentarios_local` (`id_user_local`),
  KEY `fk_comentarios_google` (`id_user_google`),
  KEY `fk_comentarios_github` (`id_user_github`),
  KEY `fk_comentarios_producto` (`id_producto_comentario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id_comentario`, `id_user_local`, `id_user_google`, `id_user_github`, `id_producto_comentario`, `comentario`, `fecha`) VALUES
(2, 101, NULL, NULL, 17, 'Prueba de comentario desde usuario local', '2025-06-03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `country`
--

DROP TABLE IF EXISTS `country`;
CREATE TABLE IF NOT EXISTS `country` (
  `country_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `country_name` varchar(80) NOT NULL,
  `country_nice_name` varchar(80) NOT NULL,
  `country_iso` char(2) NOT NULL,
  `country_iso3` char(3) DEFAULT NULL,
  `country_number_code` smallint(6) DEFAULT NULL,
  `country_phone_code` int(5) NOT NULL,
  `country_date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `country_date_updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `country_deleted_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`country_id`),
  UNIQUE KEY `country_id` (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=240 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `country`
--

INSERT INTO `country` (`country_id`, `country_name`, `country_nice_name`, `country_iso`, `country_iso3`, `country_number_code`, `country_phone_code`, `country_date_created`, `country_date_updated`, `country_deleted_at`) VALUES
(1, 'Afghanistan', 'Afghanistan', 'AF', 'AFG', 4, 93, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Albania', 'Albania', 'AL', 'ALB', 8, 355, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Algeria', 'Algeria', 'DZ', 'DZA', 12, 213, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'American Samoa', 'American Samoa', 'AS', 'ASM', 16, 1684, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Andorra', 'Andorra', 'AD', 'AND', 20, 376, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'Angola', 'Angola', 'AO', 'AGO', 24, 244, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'Anguilla', 'Anguilla', 'AI', 'AIA', 660, 1264, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'Antarctica', 'Antarctica', 'AQ', NULL, NULL, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'Antigua and Barbuda', 'Antigua and Barbuda', 'AG', 'ATG', 28, 1268, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'Argentina', 'Argentina', 'AR', 'ARG', 32, 54, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'Armenia', 'Armenia', 'AM', 'ARM', 51, 374, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'Aruba', 'Aruba', 'AW', 'ABW', 533, 297, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 'Australia', 'Australia', 'AU', 'AUS', 36, 61, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'Austria', 'Austria', 'AT', 'AUT', 40, 43, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 'Azerbaijan', 'Azerbaijan', 'AZ', 'AZE', 31, 994, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 'Bahamas', 'Bahamas', 'BS', 'BHS', 44, 1242, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 'Bahrain', 'Bahrain', 'BH', 'BHR', 48, 973, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 'Bangladesh', 'Bangladesh', 'BD', 'BGD', 50, 880, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 'Barbados', 'Barbados', 'BB', 'BRB', 52, 1246, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 'Belarus', 'Belarus', 'BY', 'BLR', 112, 375, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 'Belgium', 'Belgium', 'BE', 'BEL', 56, 32, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 'Belize', 'Belize', 'BZ', 'BLZ', 84, 501, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 'Benin', 'Benin', 'BJ', 'BEN', 204, 229, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 'Bermuda', 'Bermuda', 'BM', 'BMU', 60, 1441, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 'Bhutan', 'Bhutan', 'BT', 'BTN', 64, 975, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 'Bolivia', 'Bolivia', 'BO', 'BOL', 68, 591, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 'Bosnia and Herzegovina', 'Bosnia and Herzegovina', 'BA', 'BIH', 70, 387, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, 'Botswana', 'Botswana', 'BW', 'BWA', 72, 267, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, 'Bouvet Island', 'Bouvet Island', 'BV', NULL, NULL, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, 'Brazil', 'Brazil', 'BR', 'BRA', 76, 55, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, 'British Indian Ocean Territory', 'British Indian Ocean Territory', 'IO', NULL, NULL, 246, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(32, 'Brunei Darussalam', 'Brunei Darussalam', 'BN', 'BRN', 96, 673, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(33, 'Bulgaria', 'Bulgaria', 'BG', 'BGR', 100, 359, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(34, 'Burkina Faso', 'Burkina Faso', 'BF', 'BFA', 854, 226, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(35, 'Burundi', 'Burundi', 'BI', 'BDI', 108, 257, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(36, 'Cambodia', 'Cambodia', 'KH', 'KHM', 116, 855, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(37, 'Cameroon', 'Cameroon', 'CM', 'CMR', 120, 237, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(38, 'Canada', 'Canada', 'CA', 'CAN', 124, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(39, 'Cape Verde', 'Cape Verde', 'CV', 'CPV', 132, 238, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(40, 'Cayman Islands', 'Cayman Islands', 'KY', 'CYM', 136, 1345, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(41, 'Central African Republic', 'Central African Republic', 'CF', 'CAF', 140, 236, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(42, 'Chad', 'Chad', 'TD', 'TCD', 148, 235, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(43, 'Chile', 'Chile', 'CL', 'CHL', 152, 56, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(44, 'China', 'China', 'CN', 'CHN', 156, 86, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(45, 'Christmas Island', 'Christmas Island', 'CX', NULL, NULL, 61, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(46, 'Cocos (Keeling) Islands', 'Cocos (Keeling) Islands', 'CC', NULL, NULL, 672, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(47, 'Colombia', 'Colombia', 'CO', 'COL', 170, 57, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(48, 'Comoros', 'Comoros', 'KM', 'COM', 174, 269, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(49, 'Congo', 'Congo', 'CG', 'COG', 178, 242, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(50, 'Congo, the Democratic Republic of the', 'Congo', 'CD', 'COD', 180, 242, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(51, 'Cook Islands', 'Cook Islands', 'CK', 'COK', 184, 682, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(52, 'Costa Rica', 'Costa Rica', 'CR', 'CRI', 188, 506, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(53, 'Cote D\'Ivoire', 'Cote D\'Ivoire', 'CI', 'CIV', 384, 225, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(54, 'Croatia', 'Croatia', 'HR', 'HRV', 191, 385, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(55, 'Cuba', 'Cuba', 'CU', 'CUB', 192, 53, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(56, 'Cyprus', 'Cyprus', 'CY', 'CYP', 196, 357, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(57, 'Czech Republic', 'Czech Republic', 'CZ', 'CZE', 203, 420, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(58, 'Denmark', 'Denmark', 'DK', 'DNK', 208, 45, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(59, 'Djibouti', 'Djibouti', 'DJ', 'DJI', 262, 253, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(60, 'Dominica', 'Dominica', 'DM', 'DMA', 212, 1767, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(61, 'Dominican Republic', 'Dominican Republic', 'DO', 'DOM', 214, 1809, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(62, 'Ecuador', 'Ecuador', 'EC', 'ECU', 218, 593, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(63, 'Egypt', 'Egypt', 'EG', 'EGY', 818, 20, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(64, 'El Salvador', 'El Salvador', 'SV', 'SLV', 222, 503, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(65, 'Equatorial Guinea', 'Equatorial Guinea', 'GQ', 'GNQ', 226, 240, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(66, 'Eritrea', 'Eritrea', 'ER', 'ERI', 232, 291, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(67, 'Estonia', 'Estonia', 'EE', 'EST', 233, 372, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(68, 'Ethiopia', 'Ethiopia', 'ET', 'ETH', 231, 251, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(69, 'Falkland Islands (Malvinas)', 'Falkland Islands (Malvinas)', 'FK', 'FLK', 238, 500, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(70, 'Faroe Islands', 'Faroe Islands', 'FO', 'FRO', 234, 298, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(71, 'Fiji', 'Fiji', 'FJ', 'FJI', 242, 679, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(72, 'Finland', 'Finland', 'FI', 'FIN', 246, 358, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(73, 'France', 'France', 'FR', 'FRA', 250, 33, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(74, 'French Guiana', 'French Guiana', 'GF', 'GUF', 254, 594, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(75, 'French Polynesia', 'French Polynesia', 'PF', 'PYF', 258, 689, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(76, 'French Southern Territories', 'French Southern Territories', 'TF', NULL, NULL, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(77, 'Gabon', 'Gabon', 'GA', 'GAB', 266, 241, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(78, 'Gambia', 'Gambia', 'GM', 'GMB', 270, 220, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(79, 'Georgia', 'Georgia', 'GE', 'GEO', 268, 995, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(80, 'Germany', 'Germany', 'DE', 'DEU', 276, 49, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(81, 'Ghana', 'Ghana', 'GH', 'GHA', 288, 233, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(82, 'Gibraltar', 'Gibraltar', 'GI', 'GIB', 292, 350, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(83, 'Greece', 'Greece', 'GR', 'GRC', 300, 30, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(84, 'Greenland', 'Greenland', 'GL', 'GRL', 304, 299, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(85, 'Grenada', 'Grenada', 'GD', 'GRD', 308, 1473, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(86, 'Guadeloupe', 'Guadeloupe', 'GP', 'GLP', 312, 590, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(87, 'Guam', 'Guam', 'GU', 'GUM', 316, 1671, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(88, 'Guatemala', 'Guatemala', 'GT', 'GTM', 320, 502, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(89, 'Guinea', 'Guinea', 'GN', 'GIN', 324, 224, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(90, 'Guinea-bissau', 'Guinea-Bissau', 'GW', 'GNB', 624, 245, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(91, 'Guyana', 'Guyana', 'GY', 'GUY', 328, 592, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(92, 'Haiti', 'Haiti', 'HT', 'HTI', 332, 509, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(93, 'Heard Island and Mcdonald Islands', 'Heard Island and Mcdonald Islands', 'HM', NULL, NULL, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(94, 'Holy See (Vatican City State)', 'Holy See (Vatican City State)', 'VA', 'VAT', 336, 39, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(95, 'Honduras', 'Honduras', 'HN', 'HND', 340, 504, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(96, 'Hong Kong', 'Hong Kong', 'HK', 'HKG', 344, 852, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(97, 'Hungary', 'Hungary', 'HU', 'HUN', 348, 36, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(98, 'Iceland', 'Iceland', 'IS', 'ISL', 352, 354, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(99, 'India', 'India', 'IN', 'IND', 356, 91, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(100, 'Indonesia', 'Indonesia', 'ID', 'IDN', 360, 62, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(101, 'Iran, Islamic Republic of', 'Iran', 'IR', 'IRN', 364, 98, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(102, 'Iraq', 'Iraq', 'IQ', 'IRQ', 368, 964, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(103, 'Ireland', 'Ireland', 'IE', 'IRL', 372, 353, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(104, 'Israel', 'Israel', 'IL', 'ISR', 376, 972, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(105, 'Italy', 'Italy', 'IT', 'ITA', 380, 39, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(106, 'Jamaica', 'Jamaica', 'JM', 'JAM', 388, 1876, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(107, 'Japan', 'Japan', 'JP', 'JPN', 392, 81, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(108, 'Jordan', 'Jordan', 'JO', 'JOR', 400, 962, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(109, 'Kazakhstan', 'Kazakhstan', 'KZ', 'KAZ', 398, 7, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(110, 'Kenya', 'Kenya', 'KE', 'KEN', 404, 254, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(111, 'Kiribati', 'Kiribati', 'KI', 'KIR', 296, 686, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(112, 'Korea, Democratic People\'s Republic of', 'North Korea', 'KP', 'PRK', 408, 850, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(113, 'Korea, Republic of', 'South Korea', 'KR', 'KOR', 410, 82, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(114, 'Kuwait', 'Kuwait', 'KW', 'KWT', 414, 965, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(115, 'Kyrgyzstan', 'Kyrgyzstan', 'KG', 'KGZ', 417, 996, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(116, 'Lao People\'s Democratic Republic', 'Laos', 'LA', 'LAO', 418, 856, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(117, 'Latvia', 'Latvia', 'LV', 'LVA', 428, 371, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(118, 'Lebanon', 'Lebanon', 'LB', 'LBN', 422, 961, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(119, 'Lesotho', 'Lesotho', 'LS', 'LSO', 426, 266, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(120, 'Liberia', 'Liberia', 'LR', 'LBR', 430, 231, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(121, 'Libyan Arab Jamahiriya', 'Libyan Arab Jamahiriya', 'LY', 'LBY', 434, 218, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(122, 'Liechtenstein', 'Liechtenstein', 'LI', 'LIE', 438, 423, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(123, 'Lithuania', 'Lithuania', 'LT', 'LTU', 440, 370, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(124, 'Luxembourg', 'Luxembourg', 'LU', 'LUX', 442, 352, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(125, 'Macao', 'Macao', 'MO', 'MAC', 446, 853, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(126, 'Macedonia, the Former Yugoslav Republic of', 'Macedonia', 'MK', 'MKD', 807, 389, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(127, 'Madagascar', 'Madagascar', 'MG', 'MDG', 450, 261, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(128, 'Malawi', 'Malawi', 'MW', 'MWI', 454, 265, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(129, 'Malaysia', 'Malaysia', 'MY', 'MYS', 458, 60, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(130, 'Maldives', 'Maldives', 'MV', 'MDV', 462, 960, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(131, 'Mali', 'Mali', 'ML', 'MLI', 466, 223, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(132, 'Malta', 'Malta', 'MT', 'MLT', 470, 356, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(133, 'Marshall Islands', 'Marshall Islands', 'MH', 'MHL', 584, 692, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(134, 'Martinique', 'Martinique', 'MQ', 'MTQ', 474, 596, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(135, 'Mauritania', 'Mauritania', 'MR', 'MRT', 478, 222, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(136, 'Mauritius', 'Mauritius', 'MU', 'MUS', 480, 230, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(137, 'Mayotte', 'Mayotte', 'YT', NULL, NULL, 269, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(138, 'Mexico', 'Mexico', 'MX', 'MEX', 484, 52, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(139, 'Micronesia, Federated States of', 'Micronesia', 'FM', 'FSM', 583, 691, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(140, 'Moldova, Republic of', 'Moldova', 'MD', 'MDA', 498, 373, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(141, 'Monaco', 'Monaco', 'MC', 'MCO', 492, 377, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(142, 'Mongolia', 'Mongolia', 'MN', 'MNG', 496, 976, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(143, 'Montserrat', 'Montserrat', 'MS', 'MSR', 500, 1664, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(144, 'Morocco', 'Morocco', 'MA', 'MAR', 504, 212, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(145, 'Mozambique', 'Mozambique', 'MZ', 'MOZ', 508, 258, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(146, 'Myanmar', 'Myanmar', 'MM', 'MMR', 104, 95, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(147, 'Namibia', 'Namibia', 'NA', 'NAM', 516, 264, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(148, 'Nauru', 'Nauru', 'NR', 'NRU', 520, 674, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(149, 'Nepal', 'Nepal', 'NP', 'NPL', 524, 977, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(150, 'Netherlands', 'Netherlands', 'NL', 'NLD', 528, 31, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(151, 'Netherlands Antilles', 'Netherlands Antilles', 'AN', 'ANT', 530, 599, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(152, 'New Caledonia', 'New Caledonia', 'NC', 'NCL', 540, 687, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(153, 'New Zealand', 'New Zealand', 'NZ', 'NZL', 554, 64, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(154, 'Nicaragua', 'Nicaragua', 'NI', 'NIC', 558, 505, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(155, 'Niger', 'Niger', 'NE', 'NER', 562, 227, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(156, 'Nigeria', 'Nigeria', 'NG', 'NGA', 566, 234, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(157, 'Niue', 'Niue', 'NU', 'NIU', 570, 683, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(158, 'Norfolk Island', 'Norfolk Island', 'NF', 'NFK', 574, 672, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(159, 'Northern Mariana Islands', 'Northern Mariana Islands', 'MP', 'MNP', 580, 1670, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(160, 'Norway', 'Norway', 'NO', 'NOR', 578, 47, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(161, 'Oman', 'Oman', 'OM', 'OMN', 512, 968, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(162, 'Pakistan', 'Pakistan', 'PK', 'PAK', 586, 92, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(163, 'Palau', 'Palau', 'PW', 'PLW', 585, 680, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(164, 'Palestinian Territory, Occupied', 'Palestinian Territory, Occupied', 'PS', NULL, NULL, 970, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(165, 'Panama', 'Panama', 'PA', 'PAN', 591, 507, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(166, 'Papua New Guinea', 'Papua New Guinea', 'PG', 'PNG', 598, 675, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(167, 'Paraguay', 'Paraguay', 'PY', 'PRY', 600, 595, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(168, 'Peru', 'Peru', 'PE', 'PER', 604, 51, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(169, 'Philippines', 'Philippines', 'PH', 'PHL', 608, 63, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(170, 'Pitcairn', 'Pitcairn', 'PN', 'PCN', 612, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(171, 'Poland', 'Poland', 'PL', 'POL', 616, 48, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(172, 'Portugal', 'Portugal', 'PT', 'PRT', 620, 351, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(173, 'Puerto Rico', 'Puerto Rico', 'PR', 'PRI', 630, 1787, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(174, 'Qatar', 'Qatar', 'QA', 'QAT', 634, 974, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(175, 'Reunion', 'Reunion', 'RE', 'REU', 638, 262, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(176, 'Romania', 'Romania', 'RO', 'ROM', 642, 40, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(177, 'Russian Federation', 'Russian Federation', 'RU', 'RUS', 643, 70, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(178, 'Rwanda', 'Rwanda', 'RW', 'RWA', 646, 250, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(179, 'Saint Helena', 'Saint Helena', 'SH', 'SHN', 654, 290, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(180, 'Saint Kitts and Nevis', 'Saint Kitts and Nevis', 'KN', 'KNA', 659, 1869, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(181, 'Saint Lucia', 'Saint Lucia', 'LC', 'LCA', 662, 1758, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(182, 'Saint Pierre and Miquelon', 'Saint Pierre and Miquelon', 'PM', 'SPM', 666, 508, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(183, 'Saint Vincent and the Grenadines', 'Saint Vincent and the Grenadines', 'VC', 'VCT', 670, 1784, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(184, 'Samoa', 'Samoa', 'WS', 'WSM', 882, 684, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(185, 'San Marino', 'San Marino', 'SM', 'SMR', 674, 378, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(186, 'Sao Tome and Principe', 'Sao Tome and Principe', 'ST', 'STP', 678, 239, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(187, 'Saudi Arabia', 'Saudi Arabia', 'SA', 'SAU', 682, 966, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(188, 'Senegal', 'Senegal', 'SN', 'SEN', 686, 221, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(189, 'Serbia and Montenegro', 'Serbia and Montenegro', 'CS', NULL, NULL, 381, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(190, 'Seychelles', 'Seychelles', 'SC', 'SYC', 690, 248, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(191, 'Sierra Leone', 'Sierra Leone', 'SL', 'SLE', 694, 232, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(192, 'Singapore', 'Singapore', 'SG', 'SGP', 702, 65, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(193, 'Slovakia', 'Slovakia', 'SK', 'SVK', 703, 421, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(194, 'Slovenia', 'Slovenia', 'SI', 'SVN', 705, 386, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(195, 'Solomon Islands', 'Solomon Islands', 'SB', 'SLB', 90, 677, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(196, 'Somalia', 'Somalia', 'SO', 'SOM', 706, 252, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(197, 'South Africa', 'South Africa', 'ZA', 'ZAF', 710, 27, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(198, 'South Georgia and the South Sandwich Islands', 'South Georgia and the South Sandwich Islands', 'GS', NULL, NULL, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(199, 'Spain', 'Spain', 'ES', 'ESP', 724, 34, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(200, 'Sri Lanka', 'Sri Lanka', 'LK', 'LKA', 144, 94, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(201, 'Sudan', 'Sudan', 'SD', 'SDN', 736, 249, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(202, 'Suriname', 'Suriname', 'SR', 'SUR', 740, 597, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(203, 'Svalbard and Jan Mayen', 'Svalbard and Jan Mayen', 'SJ', 'SJM', 744, 47, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(204, 'Swaziland', 'Swaziland', 'SZ', 'SWZ', 748, 268, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(205, 'Sweden', 'Sweden', 'SE', 'SWE', 752, 46, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(206, 'Switzerland', 'Switzerland', 'CH', 'CHE', 756, 41, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(207, 'Syrian Arab Republic', 'Syrian Arab Republic', 'SY', 'SYR', 760, 963, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(208, 'Taiwan, Province of China', 'Taiwan', 'TW', 'TWN', 158, 886, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(209, 'Tajikistan', 'Tajikistan', 'TJ', 'TJK', 762, 992, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(210, 'Tanzania, United Republic of', 'Tanzania', 'TZ', 'TZA', 834, 255, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(211, 'Thailand', 'Thailand', 'TH', 'THA', 764, 66, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(212, 'Timor-leste', 'Timor-Leste', 'TL', NULL, NULL, 670, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(213, 'Togo', 'Togo', 'TG', 'TGO', 768, 228, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(214, 'Tokelau', 'Tokelau', 'TK', 'TKL', 772, 690, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(215, 'Tonga', 'Tonga', 'TO', 'TON', 776, 676, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(216, 'Trinidad and Tobago', 'Trinidad and Tobago', 'TT', 'TTO', 780, 1868, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(217, 'Tunisia', 'Tunisia', 'TN', 'TUN', 788, 216, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(218, 'Turkey', 'Turkey', 'TR', 'TUR', 792, 90, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(219, 'Turkmenistan', 'Turkmenistan', 'TM', 'TKM', 795, 7370, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(220, 'Turks and Caicos Islands', 'Turks and Caicos Islands', 'TC', 'TCA', 796, 1649, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(221, 'Tuvalu', 'Tuvalu', 'TV', 'TUV', 798, 688, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(222, 'Uganda', 'Uganda', 'UG', 'UGA', 800, 256, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(223, 'Ukraine', 'Ukraine', 'UA', 'UKR', 804, 380, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(224, 'United Arab Emirates', 'United Arab Emirates', 'AE', 'ARE', 784, 971, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(225, 'United Kingdom', 'United Kingdom', 'GB', 'GBR', 826, 44, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(226, 'United States of America', 'United States', 'US', 'USA', 840, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(227, 'United States Minor Outlying Islands', 'United States Minor Outlying Islands', 'UM', NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(228, 'Uruguay', 'Uruguay', 'UY', 'URY', 858, 598, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(229, 'Uzbekistan', 'Uzbekistan', 'UZ', 'UZB', 860, 998, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(230, 'Vanuatu', 'Vanuatu', 'VU', 'VUT', 548, 678, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(231, 'Venezuela', 'Venezuela', 'VE', 'VEN', 862, 58, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(232, 'Vietnam', 'Vietnam', 'VN', 'VNM', 704, 84, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(233, 'Virgin Islands, British', 'Virgin Islands, British', 'VG', 'VGB', 92, 1284, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(234, 'Virgin Islands, U.S.', 'Virgin Islands, U.S.', 'VI', 'VIR', 850, 1340, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(235, 'Wallis and Futuna', 'Wallis and Futuna', 'WF', 'WLF', 876, 681, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(236, 'Western Sahara', 'Western Sahara', 'EH', 'ESH', 732, 212, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(237, 'Yemen', 'Yemen', 'YE', 'YEM', 887, 967, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(238, 'Zambia', 'Zambia', 'ZM', 'ZMB', 894, 260, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(239, 'Zimbabwe', 'Zimbabwe', 'ZW', 'ZWE', 716, 263, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devoluciones`
--

DROP TABLE IF EXISTS `devoluciones`;
CREATE TABLE IF NOT EXISTS `devoluciones` (
  `id_dev` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_dev` int(20) UNSIGNED NOT NULL,
  `producto_dev` int(20) UNSIGNED NOT NULL,
  `motivo` int(20) UNSIGNED NOT NULL,
  `fecha_solicitud` varchar(10) NOT NULL,
  `estado_dev` varchar(30) NOT NULL,
  PRIMARY KEY (`id_dev`),
  KEY `FK_producto_dev` (`producto_dev`),
  KEY `FK_motivo` (`motivo`)
) ENGINE=InnoDB AUTO_INCREMENT=1300 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `devoluciones`
--

INSERT INTO `devoluciones` (`id_dev`, `user_dev`, `producto_dev`, `motivo`, `fecha_solicitud`, `estado_dev`) VALUES
(1, 2, 3, 5, '03/10/2024', 'En proceso'),
(2, 4, 4, 4, '03/10/2024', 'Completado'),
(3, 5, 5, 2, '03/10/2024', 'En proceso'),
(4, 3, 2, 3, '03/10/2024', 'Completado'),
(5, 1, 1, 1, '03/10/2024', 'En proceso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion`
--

DROP TABLE IF EXISTS `direccion`;
CREATE TABLE IF NOT EXISTS `direccion` (
  `id_dir` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ciudad` varchar(50) NOT NULL,
  `calle` varchar(50) NOT NULL,
  `pais` varchar(50) NOT NULL,
  `cp` varchar(50) NOT NULL,
  PRIMARY KEY (`id_dir`)
) ENGINE=InnoDB AUTO_INCREMENT=200 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `direccion`
--

INSERT INTO `direccion` (`id_dir`, `ciudad`, `calle`, `pais`, `cp`) VALUES
(1, 'ciudad1', 'calle1', 'pais1', 'cp1'),
(2, 'ciudad2', 'calle2', 'pais2', 'cp2'),
(3, 'ciudad3', 'calle3', 'pais3', 'cp3'),
(4, 'ciudad4', 'calle4', 'pais4', 'cp4'),
(5, 'ciudad5', 'calle5', 'pais5', 'cp5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `github_users`
--

DROP TABLE IF EXISTS `github_users`;
CREATE TABLE IF NOT EXISTS `github_users` (
  `uid` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci NOT NULL,
  `username` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `tipo_usuario` varchar(250) NOT NULL,
  `avatar` varchar(250) NOT NULL,
  `token_email` varchar(250) DEFAULT NULL,
  `activate` int(1) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `github_users`
--

INSERT INTO `github_users` (`uid`, `username`, `email`, `tipo_usuario`, `avatar`, `token_email`, `activate`) VALUES
('kzm0D5epNpgxA51IkW6wjIBrkYx2', 'satorredani', 'satorredani@gmail.com', 'client', 'https://avatars.githubusercontent.com/u/196434475?v=4', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `google_users`
--

DROP TABLE IF EXISTS `google_users`;
CREATE TABLE IF NOT EXISTS `google_users` (
  `uid` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci NOT NULL,
  `username` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `tipo_usuario` varchar(250) NOT NULL,
  `avatar` varchar(250) NOT NULL,
  `token_email` varchar(250) DEFAULT NULL,
  `activate` int(250) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `google_users`
--

INSERT INTO `google_users` (`uid`, `username`, `email`, `tipo_usuario`, `avatar`, `token_email`, `activate`) VALUES
('UWuEtpXpdhbJDUqAns70pd6cXne2', 'danisatorrecucart', 'danisatorrecucart@gmail.com', 'client', 'https://lh3.googleusercontent.com/a/ACg8ocIvC1VHWaLRVkY48G13rrQTNQUZAtNgsB29cUdd1pIcu8ntqsY=s96-c', '', 1),
('XBbtJEqZERUXnG1jtfUfVJXATZo2', 'angelsatorrecucart', 'angelsatorrecucart@gmail.com', 'client', 'https://lh3.googleusercontent.com/a/ACg8ocI8LJBoIuIqFRWTw3NNF7d659Zwfk-cDrfvK28uAJVzbCYdcuE6=s96-c', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id_image` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `img_producto` int(20) UNSIGNED NOT NULL,
  `img_route` varchar(255) NOT NULL,
  PRIMARY KEY (`id_image`),
  KEY `FK_img_producto` (`img_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `images`
--

INSERT INTO `images` (`id_image`, `img_producto`, `img_route`) VALUES
(1, 1, 'img1.jpg'),
(2, 2, 'img2.jpg'),
(3, 3, 'img3.jpg'),
(4, 5, 'img4.jpg'),
(5, 4, 'img5.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `id_like` int(11) NOT NULL AUTO_INCREMENT,
  `id_user_like` int(20) UNSIGNED DEFAULT NULL,
  `id_user_like_google` varchar(250) DEFAULT NULL,
  `id_user_like_github` varchar(250) DEFAULT NULL,
  `id_producto_like` int(20) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id_like`),
  KEY `id_producto_like` (`id_producto_like`),
  KEY `id_user_like` (`id_user_like`),
  KEY `fk_likes_google` (`id_user_like_google`),
  KEY `fk_likes_github` (`id_user_like_github`)
) ENGINE=InnoDB AUTO_INCREMENT=3070 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `likes`
--

INSERT INTO `likes` (`id_like`, `id_user_like`, `id_user_like_google`, `id_user_like_github`, `id_producto_like`) VALUES
(3015, 101, NULL, NULL, 8),
(3016, 101, NULL, NULL, 21),
(3017, 101, NULL, NULL, 11),
(3018, 101, NULL, NULL, 34),
(3020, 108, NULL, NULL, 17),
(3021, 108, NULL, NULL, 27),
(3022, 113, NULL, NULL, 27),
(3023, 113, NULL, NULL, 17),
(3025, 113, NULL, NULL, 4),
(3026, 113, NULL, NULL, 26),
(3027, 113, NULL, NULL, 19),
(3028, 113, NULL, NULL, 37),
(3029, 113, NULL, NULL, 5),
(3030, 113, NULL, NULL, 25),
(3031, 113, NULL, NULL, 12),
(3032, 113, NULL, NULL, 35),
(3033, 113, NULL, NULL, 14),
(3034, 113, NULL, NULL, 29),
(3035, 113, NULL, NULL, 32),
(3036, 113, NULL, NULL, 21),
(3037, 113, NULL, NULL, 1),
(3038, 113, NULL, NULL, 9),
(3039, 113, NULL, NULL, 24),
(3040, 113, NULL, NULL, 28),
(3045, 101, NULL, NULL, 6),
(3048, 138, NULL, NULL, 19),
(3049, 138, NULL, NULL, 8),
(3050, 101, NULL, NULL, 33),
(3054, NULL, 'UWuEtpXpdhbJDUqAns70pd6cXne2', NULL, 17),
(3055, NULL, 'UWuEtpXpdhbJDUqAns70pd6cXne2', NULL, 37),
(3057, NULL, NULL, 'kzm0D5epNpgxA51IkW6wjIBrkYx2', 17),
(3058, NULL, NULL, 'kzm0D5epNpgxA51IkW6wjIBrkYx2', 36),
(3059, 101, NULL, NULL, 27),
(3060, 101, NULL, NULL, 23),
(3061, NULL, 'UWuEtpXpdhbJDUqAns70pd6cXne2', NULL, 20),
(3062, NULL, NULL, 'kzm0D5epNpgxA51IkW6wjIBrkYx2', 18),
(3063, NULL, 'UWuEtpXpdhbJDUqAns70pd6cXne2', NULL, 15),
(3065, NULL, 'UWuEtpXpdhbJDUqAns70pd6cXne2', NULL, 38),
(3066, 101, NULL, NULL, 4),
(3067, 101, NULL, NULL, 7),
(3068, 101, NULL, NULL, 3),
(3069, NULL, 'UWuEtpXpdhbJDUqAns70pd6cXne2', NULL, 27);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

DROP TABLE IF EXISTS `marcas`;
CREATE TABLE IF NOT EXISTS `marcas` (
  `id_marca` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_marca` varchar(30) NOT NULL,
  `img_marca` varchar(255) NOT NULL,
  PRIMARY KEY (`id_marca`)
) ENGINE=InnoDB AUTO_INCREMENT=1204 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id_marca`, `nom_marca`, `img_marca`) VALUES
(1, 'Puma', 'puma.png'),
(2, 'Adidas', 'adidas.png'),
(3, 'Nike', 'nike.png'),
(4, 'Jordan', 'jordan.png'),
(5, 'Reebok', 'reebok.png'),
(6, 'Luanvi', 'luanvi.png'),
(7, 'Spalding', 'spalding.png'),
(8, 'Wilson', 'wilson.png'),
(9, 'Tenth', 'tenth.png'),
(10, 'Joma', 'joma.png'),
(11, 'Under Armour', 'under-armour.png'),
(12, 'Molten', 'molten.png'),
(13, 'New Era', 'new-era.png'),
(1200, 'Kipsta', 'kipsta.png'),
(1201, 'New Balance', 'nb.png'),
(1202, 'Champion', 'champion.png'),
(1203, 'Hummel', 'hummel.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodos_pago`
--

DROP TABLE IF EXISTS `metodos_pago`;
CREATE TABLE IF NOT EXISTS `metodos_pago` (
  `id_metodo` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `metodo` varchar(30) NOT NULL,
  PRIMARY KEY (`id_metodo`)
) ENGINE=InnoDB AUTO_INCREMENT=1800 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `metodos_pago`
--

INSERT INTO `metodos_pago` (`id_metodo`, `metodo`) VALUES
(1, 'Paypal'),
(2, 'Transferencia bancaria'),
(3, 'Bizum'),
(4, 'Paysafecard'),
(5, 'Efectivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivos`
--

DROP TABLE IF EXISTS `motivos`;
CREATE TABLE IF NOT EXISTS `motivos` (
  `id_motivo` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `motivo` varchar(50) NOT NULL,
  PRIMARY KEY (`id_motivo`)
) ENGINE=InnoDB AUTO_INCREMENT=1500 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `motivos`
--

INSERT INTO `motivos` (`id_motivo`, `motivo`) VALUES
(1, 'Mal estado del producto'),
(2, 'Estafa'),
(3, 'Disconforme'),
(4, 'Talla equivocada'),
(5, 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `players`
--

DROP TABLE IF EXISTS `players`;
CREATE TABLE IF NOT EXISTS `players` (
  `id_player` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_player` varchar(50) NOT NULL,
  PRIMARY KEY (`id_player`)
) ENGINE=InnoDB AUTO_INCREMENT=2000 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `players`
--

INSERT INTO `players` (`id_player`, `nom_player`) VALUES
(1, 'Luka Doncic'),
(2, 'Lebron James'),
(3, 'Jaime Pradilla'),
(4, 'Stephen Curry'),
(5, 'Devin Booker');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id_producto` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_vendedor` int(20) UNSIGNED NOT NULL,
  `marca` int(50) UNSIGNED NOT NULL,
  `categoria` int(20) UNSIGNED NOT NULL,
  `tipo` int(20) UNSIGNED NOT NULL,
  `equipo` int(20) UNSIGNED DEFAULT NULL,
  `nom_prod` varchar(40) NOT NULL,
  `sexo_prod` varchar(20) NOT NULL,
  `color` varchar(50) NOT NULL,
  `ciudad` varchar(50) NOT NULL,
  `talla` varchar(10) NOT NULL,
  `entrega` varchar(40) NOT NULL,
  `descripcion` varchar(1000) NOT NULL,
  `condicion` varchar(20) NOT NULL,
  `stock` int(50) NOT NULL,
  `precio` int(5) NOT NULL,
  `img_producto` varchar(255) NOT NULL,
  `altitud` varchar(100) NOT NULL,
  `longitud` varchar(100) NOT NULL,
  `visitas` int(100) NOT NULL DEFAULT 0,
  `rating` int(5) NOT NULL DEFAULT 1,
  `likes` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_producto`),
  KEY `FK_marca` (`marca`),
  KEY `FK_categoria` (`categoria`),
  KEY `FK_tipo` (`tipo`),
  KEY `FK_equipo` (`equipo`),
  KEY `FK_user` (`id_vendedor`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=600 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `id_vendedor`, `marca`, `categoria`, `tipo`, `equipo`, `nom_prod`, `sexo_prod`, `color`, `ciudad`, `talla`, `entrega`, `descripcion`, `condicion`, `stock`, `precio`, `img_producto`, `altitud`, `longitud`, `visitas`, `rating`, `likes`) VALUES
(1, 101, 2, 1, 7, 1906, 'Camiseta Bulls Rose', 'masculino', 'rojo', 'Ontinyent, Valencia', 'M', 'persona', 'Camiseta de los Chicago Bulls del jugador Rose con el numero 1', 'usado', 3, 20, 'i5399202774.webp', '38.821', '-0.610547', 12, 3, 1),
(2, 102, 3, 4, 2, 1904, 'Camiseta Milwaukee', 'masculino', 'verde', 'Ontinyent, Valencia', 'L', 'domicilio', 'Camiseta Milwaukee', 'nuevo', 5, 20, 'i5399202785_2.webp', '38.8205', '-0.6098', 3, 3, 0),
(3, 103, 2, 1, 7, 1905, 'Camiseta firmada RM', 'masculino', 'blanco', 'Ontinyent, Valencia', 'XL', 'persona', 'Marco con una camiseta del Real Madrid dentro firmada por varios de sus jugadores', 'bueno', 1, 500, 'i5380960382.webp', '38.8198', '-0.6089', 15, 1, 1),
(4, 104, 1, 1, 3, NULL, 'Zapatillas Puma MB', 'masculino', 'Negro', 'Ontinyent, Valencia', '44', 'persona', 'Zapatillas de la marca Puma colaboracion con el jugador Melo Bo de la NBA', 'bueno', 1, 40, 'i53992027853.webp', '38.8231', '-0.6123', 130, 4, 2),
(5, 105, 3, 1, 6, 1903, 'Pantalones Grizzlies', 'masculino', 'azul', 'Ontinyent, Valencia', 'M', 'domicilio', 'Pantalones del equipo Grizzlies de la NBA', 'nuevo', 1, 18, 'i5376709596.webp', '38.8185', '-0.6075', 9, 3, 1),
(6, 101, 7, 1, 5, NULL, 'Balon spalding TF50', 'todos', 'marron', 'Ontinyent, Valencia', 'M', 'persona', 'Balon de la marca Spalding, modelo TF 50', 'bueno', 3, 10, 'i5368871734.webp', '38.8240', '-0.6130', 2, 1, 1),
(7, 102, 2, 4, 7, 1902, 'Camiseta Orlando 12', 'femenino', 'azul', 'Ontinyent, Valencia', 'L', 'domicilio', 'Camiseta de Orlando del jugador Howard', 'nuevo', 5, 20, 'i5344037323.webp', '38.8172', '-0.6062', 5, 2, 1),
(8, 103, 6, 1, 7, 5, 'Camiseta Valencia Basket 24 25', 'masculino', 'naranja', 'Ontinyent, Valencia', 'L', 'domicilio', 'Camiseta del Valencia Basket de la temporada 2024 2025', 'nuevo', 2, 30, 'i5313602310.webp', '38.8255', '-0.6141', 18, 5, 2),
(9, 104, 12, 1, 5, NULL, 'Balon Molten MB7', 'todos', 'naranja', 'Ontinyent, Valencia', 'unica', 'persona', 'Balon marca Molten modelo MB 7', 'bueno', 1, 15, 'i5423756299.webp', '38.8160', '-0.6050', 4, 5, 1),
(10, 104, 11, 3, 8, NULL, 'Canasta para ninos pequenos', 'todos', 'negro:rojo', 'Ontinyent, Valencia', 'unica', 'persona', 'Canasta pequena para ninos', 'desgastado', 1, 35, 'i5416906875.webp', '38.8300', '-0.6200', 4, 2, 0),
(11, 104, 3, 1, 7, 1901, 'Camiseta Spurs 41', 'masculino', 'blanco:azul', 'Ontinyent, Valencia', 'XL', 'persona', 'Camiseta de los San Antonio Spurs del jugador Willy Hernangomez', 'desgastado', 1, 15, 'i5397876223.webp', '38.8350', '-0.6250', 11, 5, 1),
(12, 104, 4, 1, 8, NULL, 'Figura Michael Jordan', 'todos', 'rojo:marron', 'Ontinyent, Valencia', 'unica', 'domicilio', 'Figura del jugador Michael Jordan con su numero 23', 'bueno', 1, 40, 'i5378159407.webp', '38.8400', '-0.6300', 2, 1, 1),
(13, 104, 4, 1, 8, NULL, 'Libro de KB', 'masculino', 'negro', 'Ontinyent, Valencia', 'unica', 'persona', 'Libro sobre Kobe Bryant Mentalidad Mamba', 'bueno', 1, 40, 'i5344670697.webp', '38.8450', '-0.6350', 1, 1, 0),
(14, 104, 3, 1, 7, 1907, 'Camiseta Timberwolves  21', 'masculino', 'negro', 'Ontinyent, Valencia', 'L', 'persona', 'Camiseta de los timberwolves del jugador Garnett con el numero 21', 'bueno', 1, 22, 'i5345691035.webp', '38.8500', '-0.6400', 14, 3, 1),
(15, 104, 4, 1, 8, NULL, 'Figura Kobe Bryant', 'masculino', 'marron:amarillo', 'Ontinyent, Valencia', 'unica', 'persona', 'Figura de Kobe Bryant', 'bueno', 1, 70, 'i5331284865.webp', '38.8550', '-0.6450', 1, 1, 1),
(16, 104, 3, 2, 7, 1906, 'Camiseta Bulls 23', 'femenino', 'rojo', 'Ontinyent, Valencia', 'L', 'persona', 'Camiseta para mujeres de Michael Jordan en los Bulls con el numero 23', 'bueno', 1, 23, 'i5319710320.webp', '38.8600', '-0.6500', 5, 1, 0),
(17, 104, 3, 1, 3, NULL, 'Zapatillas Nike altas', 'masculino', 'blanco', 'Ontinyent, Valencia', 'XL', 'persona', 'Zapatillas Nike altas', 'bueno', 1, 45, 'i5328717027.webp', '38.8650', '-0.6550', 69, 3, 4),
(18, 104, 1, 4, 7, 1908, 'Camiseta de los Piston DH', 'masculino', 'blanco', 'Vallada, Valencia', 'L', 'persona', 'Camiseta de los Piston de Hill con el numero 33', 'bueno', 1, 12, 'i5415905457.webp', '38.8700', '-0.6600', 11, 1, 1),
(19, 104, 2, 2, 3, NULL, 'Zapatillas Adidas running', 'masculino', 'blanco', 'Vallada, Valencia', '41', 'persona', 'Zapatillas para correr de Adidas', 'bueno', 1, 32, 'i5401436993.webp', '38.8750', '-0.6650', 19, 2, 2),
(20, 105, 2, 4, 7, 1, 'Camiseta KB LA', 'masculino', 'blanco:amarillo', 'Madrid', 'M', 'domicilio', 'Camiseta de Kobre Bryant en Los Lakers con su numero 24', 'nuevo', 1, 40, 'i5381087208.webp', '40.4168', '-3.7038', 7, 1, 1),
(21, 106, 3, 1, 7, 1, 'Camiseta LA 23', 'masculino', 'blanco', 'Barcelona', 'XL', 'persona', 'Camiseta de Los Angeles Lakers de Lebron James con su iconico numero 23', 'bueno', 2, 28, 'i5380787377.webp', '41.3879', '2.1699', 21, 4, 2),
(22, 107, 3, 2, 7, 1909, 'Camiseta Miami Wade', 'femenino', 'rosa', 'Sevilla', 'M', 'persona', 'Camiseta de Wade en los Miami Heat', 'nuevo', 4, 10, 'i5380773862.webp', '37.3891', '-5.9845', 7, 2, 0),
(23, 108, 11, 3, 6, NULL, 'Pantalon corto', 'masculino', 'negro:rojo', 'Valencia', 'S', 'persona', 'Pantalon corto para ninos', 'desgastado', 1, 5, 'i5378467878.webp', '39.4699', '-0.3763', 5, 1, 1),
(24, 109, 8, 4, 5, NULL, 'Balon de baloncesto', 'todos', 'morado:amarillo', 'A Coruna, La Coruna', 'unica', 'persona', 'Balon de baloncesto', 'bueno', 5, 8, 'i5373503161.webp', '43.3623', '-8.4115', 3, 1, 1),
(25, 110, 3, 1, 6, 1910, 'Pantalones CAVS', 'masculino', 'rojo:amarillo', 'Malaga', 'XL', 'persona', 'Pantalones cortos para jugar de los Cavs', 'bueno', 6, 19, 'i5377110901.webp', '36.7213', '-4.4216', 5, 1, 1),
(26, 106, 5, 3, 3, NULL, 'Zapatillas NB', 'masculino', 'blanco:azul', 'Palma, Mallorca', '38', 'domicilio', 'Zapatillas New Balance nuevas', 'nuevo', 3, 28, 'i5367014735.webp', '39.5696', '2.6502', 7, 1, 1),
(27, 103, 3, 1, 3, NULL, 'Zapatillas Nike de color blanco y negro', 'masculino', 'Blanco:Negro', 'Santa Cruz de Tenerife', '43', 'domicilio', 'Zapatillas nike de color blanco y negro para salir por la calle', 'bueno', 1, 55, 'i5360803300.webp', '28.4824', '-16.2493', 168, 5, 4),
(28, 108, 5, 1, 5, NULL, 'Balon blando', 'todos', 'azul:negro', 'Maspalomas, Canarias', 'unica', 'persona', 'Balon blando para ninos pequenos', 'desgastado', 1, 9, 'i5356866821.webp', '27.7666', '-15.5785', 1, 1, 1),
(29, 109, 1202, 1, 7, 1901, 'Camiseta Spurs', 'masculino', 'blanco:negro', 'Cordoba', 'M', 'persona', 'Camiseta de los Spurs de Ginobili', 'bueno', 2, 26, 'i5329783106.webp', '37.8833', '-4.7794', 17, 1, 1),
(30, 110, 8, 1, 5, NULL, 'Balon FIBA 3x3', 'todos', 'Negro', 'Alicante, Valencia', 'unica', 'domicilio', 'Balon oficial FIBA ligas 3x3', 'bueno', 3, 17, 'i5331336754.webp', '38.3452', '-0.4810', 3, 4, 0),
(31, 106, 9, 5, 8, NULL, 'Rodilleras Nike Pro', 'todos', 'naranja:negro', 'Vigo', 'unica', 'domicilio', 'Canasta sola sin el palo de soporte', 'nuevo', 4, 22, 'i5375191847.webp', '42.2370', '-8.7177', 3, 1, 0),
(32, 107, 3, 1, 7, 1, 'Camiseta Lebron J 23', 'masculino', 'amarillo', 'Murcia', 'XXL', 'persona', 'Camiseta de los Lakers de Lebron James amarilla', 'bueno', 2, 25, 'i5334435135.webp', '37.9922', '-1.1307', 17, 3, 1),
(33, 108, 1203, 4, 7, 1900, 'Camiseta UCAM Murcia', 'masculino', 'rojo', 'Zaragoza', 'S', 'domicilio', 'Camiseta de la liga ACB de Murcia', 'bueno', 6, 20, 'i5347298036.webp', '41.6561', '-0.8773', 8, 1, 1),
(34, 109, 6, 3, 7, 5, 'Camiseta Valencia Basket', 'masculino', 'naranja', 'Salamanca', 'M', 'persona', 'Camiseta del Valencia Basket para jugar', 'desgastado', 2, 12, 'i5347555887.webp', '40.9652', '-5.6635', 10, 3, 1),
(35, 110, 6, 1, 10, 5, 'Chaqueta del Valencia Basket', 'masculino', 'blanco:azul', 'Albacete', 'L', 'persona', 'Chaqueta del valencia basket', 'bueno', 3, 14, 'i5384523579.webp', '38.9869', '-1.8564', 1, 1, 1),
(36, 106, 3, 2, 9, 5, 'Sudadera valencia basket gris', 'masculino', 'gris', 'La Colilla', 'L', 'persona', 'Sudadera del valencia basket gris', 'bueno', 2, 20, 'i5386194302.webp', '40.6401', '-4.7470', 1, 1, 1),
(37, 107, 6, 1, 2, 5, 'Sueter entrenamiento vb', 'masculino', 'blanco:azul:naranja', 'Bilbao', 'L', 'domicilio', 'Sueter de entrenamiento valencia basket ', 'nuevo', 3, 29, 'i5340975714.webp', '43.2630', '-2.9349', 12, 1, 2),
(38, 108, 6, 1, 6, 5, 'Pantalon corto valencia basket', 'masculino', 'blanco', 'Granada', 'L', 'persona', 'Pantalon corto para jugar del valencia basket', 'bueno', 5, 15, 'i5407596825.webp', '37.1765', '-3.5979', 6, 1, 1),
(39, 109, 3, 1, 7, 1911, 'Camiseta Curry Warriors', 'masculino', 'Blanco:Azul', 'Toledo', 'M', 'persona', 'Camiseta de los Golden State Warriors de Stephen Curry', 'bueno', 3, 90, 'IMG_0500.webp', '39.8786', '-4.0245', 1, 1, 0),
(40, 110, 7, 1, 5, NULL, 'Balon Liga ACB 23/23', 'masculino', 'Negro:Blanco', 'Monaco', 'M', 'persona', 'Balon Spalding de la liga endesa de la temporada 2023/2024', 'bueno', 4, 30, 'IMG_0511.webp', '43.7384', '7.4246', 1, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_categorias`
--

DROP TABLE IF EXISTS `productos_categorias`;
CREATE TABLE IF NOT EXISTS `productos_categorias` (
  `id_producto` int(20) UNSIGNED NOT NULL,
  `id_categoria` int(20) UNSIGNED NOT NULL,
  KEY `FK_prod_categoria` (`id_producto`),
  KEY `FK_categoria_prod` (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `productos_categorias`
--

INSERT INTO `productos_categorias` (`id_producto`, `id_categoria`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(2, 3),
(3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_marcas`
--

DROP TABLE IF EXISTS `productos_marcas`;
CREATE TABLE IF NOT EXISTS `productos_marcas` (
  `id_producto` int(20) UNSIGNED NOT NULL,
  `id_marca` int(20) UNSIGNED NOT NULL,
  KEY `FK_prod_marca` (`id_producto`),
  KEY `FK_marca_prod` (`id_marca`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `productos_marcas`
--

INSERT INTO `productos_marcas` (`id_producto`, `id_marca`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_tipo`
--

DROP TABLE IF EXISTS `productos_tipo`;
CREATE TABLE IF NOT EXISTS `productos_tipo` (
  `id_producto` int(20) UNSIGNED NOT NULL,
  `id_tipo` int(20) UNSIGNED NOT NULL,
  KEY `FK_prod_tipo` (`id_producto`),
  KEY `FK_tipo_prod` (`id_tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `productos_tipo`
--

INSERT INTO `productos_tipo` (`id_producto`, `id_tipo`) VALUES
(1, 1),
(5, 2),
(1, 2),
(2, 7),
(2, 5),
(3, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_img`
--

DROP TABLE IF EXISTS `producto_img`;
CREATE TABLE IF NOT EXISTS `producto_img` (
  `id_pimg` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pimage_producto` int(20) UNSIGNED NOT NULL,
  `pimage_route` varchar(255) NOT NULL,
  PRIMARY KEY (`id_pimg`),
  KEY `FK_pimage_producto` (`pimage_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=939 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `producto_img`
--

INSERT INTO `producto_img` (`id_pimg`, `pimage_producto`, `pimage_route`) VALUES
(745, 1, 'i5399202774.webp'),
(746, 1, 'i5399202785.webp'),
(747, 1, 'i5399202791.webp'),
(748, 1, 'i5399202799.webp'),
(749, 1, 'i5399202811.webp'),
(750, 1, 'i5399202817.webp'),
(751, 10, 'i5416906875.webp'),
(752, 11, 'i5397876223.webp'),
(753, 11, 'i5397876316.webp'),
(754, 11, 'i5397876424.webp'),
(755, 11, 'i5397876686.webp'),
(756, 11, 'i5397877189.webp'),
(757, 11, 'i5397877720.webp'),
(758, 12, 'i5378159407.webp'),
(759, 12, 'i5378159579.webp'),
(760, 12, 'i5378159643.webp'),
(761, 12, 'i5378159753.webp'),
(762, 12, 'i5378159797.webp'),
(763, 13, 'i5344670697.webp'),
(764, 13, 'i5344670727.webp'),
(765, 13, 'i5344670734.webp'),
(766, 13, 'i5344670742.webp'),
(767, 14, 'i5345691035.webp'),
(768, 14, 'i5345691090.webp'),
(769, 14, 'i5345691107.webp'),
(770, 14, 'i5345691126.webp'),
(771, 14, 'i5345691157.webp'),
(772, 15, 'i5331284865.webp'),
(773, 15, 'i5331284955.webp'),
(774, 15, 'i5331284990.webp'),
(775, 15, 'i5331285015.webp'),
(776, 15, 'i5331285245.webp'),
(777, 16, 'i5319710320.webp'),
(778, 16, 'i5319710368.webp'),
(779, 17, 'i5328717027.webp'),
(780, 17, 'i5328717039.webp'),
(781, 18, 'i5415905457.webp'),
(782, 18, 'i5415905481.webp'),
(783, 18, 'i5415905495.webp'),
(784, 18, 'i5415905538.webp'),
(785, 18, 'i5415905562.webp'),
(786, 19, 'i5401436993.webp'),
(787, 19, 'i5401437004.webp'),
(788, 2, 'i5399202785_2.webp'),
(789, 2, 'i5418270288.webp'),
(790, 20, 'i5381087208.webp'),
(791, 20, 'i5381087213.webp'),
(792, 20, 'i5381087216.webp'),
(793, 20, 'i5381087219.webp'),
(794, 21, 'i5380787377.webp'),
(795, 21, 'i5380787403.webp'),
(796, 22, 'i5380773862.webp'),
(797, 22, 'i5380773872.webp'),
(798, 23, 'i5378467878.webp'),
(799, 23, 'i5378467957.webp'),
(800, 24, 'i5373503161.webp'),
(801, 24, 'i5373503171.webp'),
(802, 24, 'i5373503181.webp'),
(803, 25, 'i5377110901.webp'),
(804, 25, 'i5377110972.webp'),
(805, 25, 'i5377110990.webp'),
(806, 25, 'i5377111004.webp'),
(807, 25, 'i5377111018.webp'),
(808, 25, 'i5377111037.webp'),
(809, 25, 'i5377111057.webp'),
(810, 25, 'i5377111172.webp'),
(811, 26, 'i5367014735.webp'),
(812, 26, 'i5367014816.webp'),
(813, 26, 'i5367014832.webp'),
(814, 26, 'i5367014861.webp'),
(833, 29, 'i5329783106.webp'),
(834, 29, 'i5329783219.webp'),
(835, 29, 'i5329783234.webp'),
(836, 3, 'i5380960382.webp'),
(837, 3, 'i5380960439.webp'),
(838, 3, 'i5380960452.webp'),
(839, 3, 'i5380960457.webp'),
(840, 3, 'i5380960475.webp'),
(841, 30, 'i5331336754.webp'),
(842, 30, 'i5331336826.webp'),
(843, 31, 'i5375191847.webp'),
(844, 31, 'i5375191930.webp'),
(845, 31, 'i5375200335.webp'),
(846, 32, 'i5334435135.webp'),
(847, 32, 'i5334435157.webp'),
(848, 32, 'i5334435162.webp'),
(849, 33, 'i5347298036.webp'),
(850, 33, 'i5347298113.webp'),
(851, 33, 'i5347298147.webp'),
(852, 34, 'i5347555887.webp'),
(853, 34, 'i5347556027.webp'),
(854, 34, 'i5347556100.webp'),
(855, 34, 'i5347556138.webp'),
(856, 34, 'i5347556172.webp'),
(857, 35, 'i5384523579.webp'),
(858, 35, 'i5384523616.webp'),
(859, 35, 'i5384523635.webp'),
(860, 35, 'i5384523654.webp'),
(861, 35, 'i5384523678.webp'),
(862, 35, 'i5384523704.webp'),
(863, 36, 'i5386194302.webp'),
(864, 36, 'i5386195009.webp'),
(865, 36, 'i5386195279.webp'),
(866, 36, 'i5386195438.webp'),
(867, 36, 'i5386195594.webp'),
(868, 37, 'i5340975714.webp'),
(869, 37, 'i5340975752.webp'),
(870, 37, 'i5340975782.webp'),
(871, 37, 'i5340975812.webp'),
(872, 37, 'i5340975825.webp'),
(873, 37, 'i5340975840.webp'),
(874, 38, 'i5407596825.webp'),
(875, 38, 'i5407596865.webp'),
(876, 38, 'i5407596878.webp'),
(877, 4, 'i5391374953.webp'),
(878, 4, 'i5391374971.webp'),
(879, 4, 'i5391374978.webp'),
(880, 4, 'i53992027853.webp'),
(881, 5, 'i5376709596.webp'),
(882, 5, 'i5376709624.webp'),
(883, 5, 'i5376709626.webp'),
(884, 6, 'i5368871734.webp'),
(885, 6, 'i5368871836.webp'),
(886, 7, 'i5344037323.webp'),
(887, 7, 'i5344037364.webp'),
(888, 7, 'i5344037381.webp'),
(889, 7, 'i5344037391.webp'),
(890, 7, 'i5344037398.webp'),
(891, 8, 'i5313602310.webp'),
(892, 8, 'i5313602327.webp'),
(893, 8, 'i5313602342.webp'),
(894, 9, 'i5423756299.webp'),
(895, 9, 'i5423756318.webp'),
(909, 28, 'i5356866821.webp'),
(910, 28, 'i5356867002.webp'),
(911, 28, 'i5356867140.webp'),
(912, 28, 'i5356867277.webp'),
(913, 28, 'i5356867410.webp'),
(914, 27, 'i5360803300.webp'),
(915, 27, 'i5360803307.webp'),
(916, 27, 'i5360803313.webp'),
(917, 27, 'i5360803316.webp'),
(932, 40, 'IMG_0511.webp'),
(933, 40, 'IMG_0504.webp'),
(934, 40, 'IMG_0507.webp'),
(935, 39, 'IMG_0501.webp'),
(936, 39, 'IMG_0500.webp'),
(937, 39, 'IMG_0502.webp'),
(938, 39, 'IMG_0503.webp');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resenas`
--

DROP TABLE IF EXISTS `resenas`;
CREATE TABLE IF NOT EXISTS `resenas` (
  `id_resena` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_resena` int(20) UNSIGNED NOT NULL,
  `producto_resena` int(20) UNSIGNED NOT NULL,
  `puntuacion` int(2) NOT NULL,
  `comentario` varchar(500) NOT NULL,
  `fecha_resena` varchar(10) NOT NULL,
  PRIMARY KEY (`id_resena`),
  KEY `FK_producto_resena` (`producto_resena`)
) ENGINE=InnoDB AUTO_INCREMENT=1100 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `resenas`
--

INSERT INTO `resenas` (`id_resena`, `user_resena`, `producto_resena`, `puntuacion`, `comentario`, `fecha_resena`) VALUES
(1, 1, 1, 40, 'El producto me llego en buenas condiciones', '26/10/2024'),
(2, 2, 4, 40, 'El producto me llego en buenas condiciones', '18/07/2024'),
(3, 5, 3, 40, 'El producto me llego en buenas condiciones', '12/01/2025'),
(4, 3, 4, 40, 'El producto me llego en buenas condiciones', '15/01/2025'),
(5, 4, 5, 40, 'El producto me llego en buenas condiciones', '04/11/2024');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subastas`
--

DROP TABLE IF EXISTS `subastas`;
CREATE TABLE IF NOT EXISTS `subastas` (
  `id_subasta` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_sub` int(20) UNSIGNED NOT NULL,
  `producto_sub` int(20) UNSIGNED NOT NULL,
  `puja` int(5) NOT NULL,
  PRIMARY KEY (`id_subasta`),
  KEY `FK_producto_sub` (`producto_sub`)
) ENGINE=InnoDB AUTO_INCREMENT=1700 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `subastas`
--

INSERT INTO `subastas` (`id_subasta`, `user_sub`, `producto_sub`, `puja`) VALUES
(1, 1, 1, 10),
(2, 2, 2, 20),
(3, 3, 3, 30),
(4, 4, 4, 40),
(5, 5, 5, 50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `teams`
--

DROP TABLE IF EXISTS `teams`;
CREATE TABLE IF NOT EXISTS `teams` (
  `id_team` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_team` varchar(50) NOT NULL,
  PRIMARY KEY (`id_team`)
) ENGINE=InnoDB AUTO_INCREMENT=1912 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `teams`
--

INSERT INTO `teams` (`id_team`, `nom_team`) VALUES
(1, 'L.A Lakers'),
(2, 'Dallas Maverics'),
(3, 'Phoenix Suns'),
(4, 'Boston Celtics'),
(5, 'Valencia Basket'),
(1900, 'UCAM Murcia'),
(1901, 'S.A Spurs'),
(1902, 'Orlando'),
(1903, 'Grizzlies'),
(1904, 'Milkwaukee'),
(1905, 'Real Madrid Baloncesto'),
(1906, 'Chicago Bulls'),
(1907, 'Timberwolves'),
(1908, 'Pistons'),
(1909, 'Miami Heat'),
(1910, 'CAVS'),
(1911, 'Golden State Warriors');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

DROP TABLE IF EXISTS `tipo`;
CREATE TABLE IF NOT EXISTS `tipo` (
  `id_tipo` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tipo` varchar(30) NOT NULL,
  `img_tipo` varchar(255) NOT NULL,
  `visitas_tipo` int(20) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=900 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `tipo`
--

INSERT INTO `tipo` (`id_tipo`, `tipo`, `img_tipo`, `visitas_tipo`) VALUES
(1, 'cancha', 'cancha.png', 1),
(2, 'calle', 'calle.png', 1),
(3, 'zapatos', 'zapatos.png', 7),
(4, 'gorras', 'gorras.png', 1),
(5, 'balones', 'balones.png', 1),
(6, 'pantalones', 'pantalones.png', 2),
(7, 'camisetas', 'camisetas.png', 13),
(8, 'accesorios', 'accesorios.png', 1),
(9, 'sudaderas', 'sudaderas.png', 2),
(10, 'chaquetas', 'chaquetas.png', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `pwd` varchar(10000) NOT NULL,
  `email` varchar(50) NOT NULL,
  `tipo_usuario` varchar(20) NOT NULL DEFAULT 'Cliente',
  `avatar` varchar(255) NOT NULL,
  `telf` varchar(12) NOT NULL,
  `token_email` varchar(250) DEFAULT NULL,
  `activate` int(1) NOT NULL DEFAULT 0,
  `log_intents` int(3) NOT NULL DEFAULT 0,
  `otp` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `username`, `pwd`, `email`, `tipo_usuario`, `avatar`, `telf`, `token_email`, `activate`, `log_intents`, `otp`) VALUES
(101, 'satorre', '$2y$12$OcJL5KY89yPrCaJJ5UwKg.1ATDG6rzYjvYQiPU69SM0rB.6upKvd6', 'satorre@gmail.com', 'client', 'https://i.pravatar.cc/500?u=9d16176ba7ecc0150369fed0c1bad6a7', '+34697612065', NULL, 1, 0, ''),
(102, 'prueba_dani', '$2y$12$NYM0LFgN9ku76S5Gk9PqUuehoR8IKbqy9HqSvFqRvqaSFCn2UISw6', 'correodeprueba@hotmail.com', 'client', 'https://i.pravatar.cc/500?u=095358f7e7a185eae37f5a05b574a7b6', '+34697612065', NULL, 1, 0, NULL),
(103, 'danisatorre', '$2y$12$LmSUNNa49tiS2Ls.ZmyWteU82f2lc9lsWjEYNUJAiukbCrIfoI3tG', 'dansatcuc@alu.edu.gva.es', 'client', 'https://i.pravatar.cc/500?u=5e1bdd51db96aa197cf03e4fa5947aa3', '+34697612065', NULL, 1, 0, NULL),
(104, 'cucartsatorre', '$2y$12$fNpYfUFn.2/FZDN30LD/M.aGGog6ZHpQTD8/3g5pFCtmV0euckepC', 'cucartsatorre@gmail.com', 'client', 'https://i.pravatar.cc/500?u=65465b1a1e471580c58a0ac9aed59c53', '+34697612065', NULL, 1, 0, NULL),
(105, 'dansatcuc', '$2y$12$ax49.ZV.hcmXWV1sCMgCROARG3CAAliPXXYfiBm2ZGGA9NcY.7exu', 'dansatcuc@outlook.es', 'client', 'https://i.pravatar.cc/500?u=6eb0cd3abd725d8a0f88cf4749c568ba', '+34697612065', NULL, 1, 0, NULL),
(106, 'pruebauser', '$2y$12$mj4H6MzCxqhTiZsNITxVbeFySHuerANAWMeAd.Kz6Jc0AQKJTGnZm', 'n9sasfagwagiunai@gmail.com', 'client', 'https://i.pravatar.cc/500?u=768da66834e3c3b6fb025fc7a03095b0', '+34697612065', NULL, 1, 0, NULL),
(107, 'satorredani', '$2y$12$IauaHDgEdcYNVX4M2wq8B.8Z2uh3EeoyJab3S13FjzGaaAckUGBcq', 'danisatorre@gmail.com', 'client', 'https://i.pravatar.cc/500?u=75c057e1c77fe72ab6fa54b9981b7af0', '+34697612065', NULL, 1, 0, NULL),
(108, 'dsatorre', '$2y$12$nvlZVZXOGoO9cFFJMSoRp.DhWUiM2Nm2fl6c6lajxS1q.kGY0gDDC', 'dsatorre@gmail.com', 'client', 'https://i.pravatar.cc/500?u=cba9e985b8e8f5de424ecd873037b404', '+34697612065', NULL, 1, 0, NULL),
(109, 'cucart', '$2y$12$dJQ0Y48v8XZAq3/fUUbXHOg9aYaVXxUul0q79zs.NzqFEk8Nv9K3C', 'cucart@gmail.com', 'client', 'https://i.pravatar.cc/500?u=20a9c1bac4e0841d783d76c0b1634819', '+34697612065', NULL, 1, 0, NULL),
(110, 'satorrecucart', '$2y$12$D217XAVSNiP8wUvNlKDTOOshZCYq9PkbOz4dkCipcgnjxkzEQgCg2', 'satorrecucart@gmail.com', 'client', 'https://i.pravatar.cc/500?u=e162c49bb0acf0dee06b20431f0cee32', '+34697612065', NULL, 1, 0, NULL),
(113, 'pepito', '$2y$12$sVBxNjF7mosFlxm49W5SQOEq8jkmsgO6fzBPNsN09dCztjZG36Xzi', 'asdfghjkl@gmail.com', 'client', 'https://i.pravatar.cc/500?u=32dbd1219d58090881303a4673cf813e', '+34697612065', NULL, 1, 0, NULL),
(119, 'satorredaniel', '$2y$12$NX80t.sfZKfuDWpf5WncIezcjRiUGHxr3hgyGSDZzYBuBsOZjp1M2', 'satorredaniel@gmail.com', 'client', 'https://i.pravatar.cc/500?u=288d86a4247661a8e05ebafb05588f30', '+34697612065', NULL, 1, 0, NULL),
(124, 'danielcucart', '$2y$12$aH0PYmyVDb2TPUz/BKCGSOBaP64wEdpFBgYqZgo0ES/JxndRerOxy', 'danielcucart@gmail.com', 'client', 'https://i.pravatar.cc/500?u=709086760a1cfb227e1bb6de70eafd43', '+34697612065', NULL, 1, 0, NULL),
(125, 'satorredanielcucart', '$2y$12$2mdpndB9TD8xrZVtem8qSOklxEklcof5aKaef.QDCWihYZS3zJbNy', 'satorredani1@gmail.com', 'client', 'https://i.pravatar.cc/500?u=6e06053b2a353ced81f14734550430c0', '+34697612065', NULL, 0, 0, NULL),
(128, 'satorre2', '$2y$12$1NXFBOyUnz.AHMSIZ3cJ8ur09avRAivl3Nw7F.2Yp6LY8DBGeCQTa', 'satorre2@gmail.com', 'client', 'https://i.pravatar.cc/500?u=adfd156d0a5ea66d7f04e50ff7998831', '+34697612065', 'eyJ0eXAiOiJKV1QiLCAiYWxnIjoiSFMyNTYifQ.eyJpYXQiOiIxNzQ4MjY3MzY1IiwiZXhwIjoiMTc0ODI3NDU2NSIsInVzZXJuYW1lIjoic2F0b3JyZTJAZ21haWwuY29tIn0._ciIPMuwP-HOTc0-fhIxQrjakDjVucolSN_7-atwb7A', 0, 0, NULL),
(131, 'daniel', '$2y$12$AarBK4Wdxuti4v0zwX2n8.vQZu/0gm32Udcdqgk0xB8FYnPrC/3MG', 'daniel@gmail.com', 'client', 'https://i.pravatar.cc/500?u=d79da72d537151678c9c4433b0b798b7', '+34697612065', '', 1, 0, NULL),
(134, 'angel', '$2y$12$/atPF0ET/D3gcBHc75Ojoe.i3DSC8fWvxqEylt1f9cBoFyJL6oCH6', 'angel@gmail.com', 'client', 'https://i.pravatar.cc/500?u=49f02bb09c861720239469a11589ec00', '+34697612065', 'eyJ0eXAiOiJKV1QiLCAiYWxnIjoiSFMyNTYifQ.eyJpYXQiOiIxNzQ3OTIyMjA2IiwiZXhwIjoiMTc0NzkyOTQwNiIsInVzZXJuYW1lIjoiYW5nZWxAZ21haWwuY29tIn0.NGL0_tJyDJSCNnDSGr6LvZgrQ6LN5MbJlMco5joBKGw', 0, 0, NULL),
(135, 'angel2', '$2y$12$vMaFh/iYKggSZSaCMexrUeXavRy41QC5GYvauOpapurR6Gb28cVvC', 'angel2@gmail.com', 'client', 'https://i.pravatar.cc/500?u=020578e1c915cdcb19b780cfc33a11b5', '+34697612065', '', 1, 0, ''),
(138, 'daniel3', '$2y$12$an2lYvhOcUMLZRl/KjABx.hebLdsyhF3M777/7A6njKWqG7Jsj2H6', 'daniel3@gmail.com', 'client', 'https://i.pravatar.cc/500?u=f6860b98b5aedab20457f2fb50e8829b', '+34697612065', '', 1, 2, ''),
(139, 'daniel4', '$2y$12$5itq3ddzwI5tg5hMCwDx6.OeKiH9QKmo9zPcfXnrHGbTFJVdr2O3m', 'daniel4@gmail.com', 'client', 'https://i.pravatar.cc/500?u=3ec70b0848c3cd401b04bcc0efe1e831', '+34697612065', '', 1, 0, ''),
(140, 'satorre5', '$2y$12$9LPZy1QOl0HH3btIqNWQc.A1LLI6n5SpFIMQovnyJwwSf9dIqn6Pa', 'satorre5@gmail.com', 'client', 'https://i.pravatar.cc/500?u=32395e64a27b7a9294dce110ba21f1a4', '+34697612065', '', 1, 0, '');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `fk_comentarios_github` FOREIGN KEY (`id_user_github`) REFERENCES `github_users` (`uid`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comentarios_google` FOREIGN KEY (`id_user_google`) REFERENCES `google_users` (`uid`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comentarios_local` FOREIGN KEY (`id_user_local`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comentarios_producto` FOREIGN KEY (`id_producto_comentario`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `devoluciones`
--
ALTER TABLE `devoluciones`
  ADD CONSTRAINT `FK_motivo` FOREIGN KEY (`motivo`) REFERENCES `motivos` (`id_motivo`),
  ADD CONSTRAINT `FK_producto_dev` FOREIGN KEY (`producto_dev`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `FK_img_producto` FOREIGN KEY (`img_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `fk_likes_github` FOREIGN KEY (`id_user_like_github`) REFERENCES `github_users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_likes_google` FOREIGN KEY (`id_user_like_google`) REFERENCES `google_users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_producto` FOREIGN KEY (`id_producto_like`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `likes_user` FOREIGN KEY (`id_user_like`) REFERENCES `users` (`id_user`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `FK_categoria` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`id_categoria`),
  ADD CONSTRAINT `FK_equipo` FOREIGN KEY (`equipo`) REFERENCES `teams` (`id_team`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_id_vendedor` FOREIGN KEY (`id_vendedor`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `FK_marca` FOREIGN KEY (`marca`) REFERENCES `marcas` (`id_marca`),
  ADD CONSTRAINT `FK_tipo` FOREIGN KEY (`tipo`) REFERENCES `tipo` (`id_tipo`),
  ADD CONSTRAINT `FK_user` FOREIGN KEY (`id_vendedor`) REFERENCES `users` (`id_user`);

--
-- Filtros para la tabla `productos_categorias`
--
ALTER TABLE `productos_categorias`
  ADD CONSTRAINT `FK_categoria_prod` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`),
  ADD CONSTRAINT `FK_prod_categoria` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `productos_marcas`
--
ALTER TABLE `productos_marcas`
  ADD CONSTRAINT `FK_marca_prod` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id_marca`),
  ADD CONSTRAINT `FK_prod_marca` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `productos_tipo`
--
ALTER TABLE `productos_tipo`
  ADD CONSTRAINT `FK_prod_tipo` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `FK_tipo_prod` FOREIGN KEY (`id_tipo`) REFERENCES `tipo` (`id_tipo`);

--
-- Filtros para la tabla `producto_img`
--
ALTER TABLE `producto_img`
  ADD CONSTRAINT `FK_pimage_producto` FOREIGN KEY (`pimage_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `resenas`
--
ALTER TABLE `resenas`
  ADD CONSTRAINT `FK_producto_resena` FOREIGN KEY (`producto_resena`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `subastas`
--
ALTER TABLE `subastas`
  ADD CONSTRAINT `FK_producto_sub` FOREIGN KEY (`producto_sub`) REFERENCES `productos` (`id_producto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
