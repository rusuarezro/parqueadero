-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-12-2025 a las 01:34:12
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
-- Base de datos: `dbjrparking`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id_factura` bigint(20) UNSIGNED NOT NULL,
  `idparqueadero` int(10) UNSIGNED NOT NULL,
  `id_historialpuesto` bigint(20) UNSIGNED NOT NULL,
  `observaciones` varchar(200) NOT NULL,
  `tiempo` int(11) NOT NULL,
  `valor_neto` decimal(15,2) DEFAULT NULL,
  `valor_pagar` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`id_factura`, `idparqueadero`, `id_historialpuesto`, `observaciones`, `tiempo`, `valor_neto`, `valor_pagar`, `created_at`) VALUES
(1, 1, 1, 'Egreso', 7105, 999999.99, 999999.99, '2025-12-01 07:34:44'),
(2, 1, 4, 'Egreso', 6978, 0.21, 999999.99, '2025-12-01 07:37:01'),
(3, 1, 4, 'Egreso', 6978, 0.21, 999999.99, '2025-12-01 07:39:46'),
(4, 1, 4, 'Egreso', 6978, 999999.99, 999999.99, '2025-12-01 07:41:58'),
(5, 1, 4, 'Egreso', 6978, 20934000.00, 20934000.00, '2025-12-01 07:51:47'),
(6, 1, 4, 'Egreso', 6978, 20934000.00, 20934000.00, '2025-12-01 08:03:55'),
(7, 1, 4, 'Egreso', 6978, 20934000.00, 20934000.00, '2025-12-01 08:05:05'),
(8, 1, 4, 'Egreso', 6978, 20934000.00, 20934000.00, '2025-12-01 08:07:16'),
(9, 1, 4, 'Egreso', 6979, 20937000.00, 20937000.00, '2025-12-01 08:09:58'),
(10, 1, 7, 'Egreso', 0, 0.00, 0.00, '2025-12-03 08:40:09'),
(11, 1, 8, 'Egreso', 0, 0.00, 0.00, '2025-12-03 08:41:18'),
(12, 1, 1, 'Salida de Vehículo', 7154, 10731000.00, 10731000.00, '2025-12-03 08:43:41'),
(13, 1, 5, 'Egreso', 237, 711000.00, 711000.00, '2025-12-11 06:04:10'),
(14, 1, 9, 'Egreso', 190, 665000.00, 665000.00, '2025-12-11 07:15:30'),
(15, 1, 6, 'Salida de Vehículo', 233, 815500.00, 815500.00, '2025-12-11 01:25:32'),
(16, 1, 10, 'Salida de Vehículo', 185, 333000.00, 333000.00, '2025-12-11 01:30:13'),
(17, 1, 12, 'Salida de Vehículo', 18, 63000.00, 63000.00, '2025-12-12 00:27:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `idhistorico` bigint(20) UNSIGNED NOT NULL,
  `tabla` varchar(100) DEFAULT NULL,
  `datos` text DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_puesto`
--

CREATE TABLE `historial_puesto` (
  `idpuesto` bigint(20) UNSIGNED NOT NULL,
  `idusuario` bigint(20) UNSIGNED NOT NULL,
  `idvehiculo` bigint(20) UNSIGNED NOT NULL,
  `ESTADO_FK` int(10) UNSIGNED NOT NULL DEFAULT 4,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_puesto`
--

INSERT INTO `historial_puesto` (`idpuesto`, `idusuario`, `idvehiculo`, `ESTADO_FK`, `created_at`, `updated_at`) VALUES
(1, 90, 2, 3, '2025-02-08 05:53:06', '2025-12-03 02:43:41'),
(4, 90, 1, 3, '2025-02-13 13:07:15', '2025-12-01 02:09:58'),
(5, 7, 3, 3, '2025-12-01 08:15:06', '2025-12-11 00:04:10'),
(6, 90, 1, 3, '2025-12-01 08:31:29', '2025-12-11 01:25:32'),
(7, 16, 6, 3, '2025-12-03 08:30:44', '2025-12-03 02:40:09'),
(8, 16, 6, 3, '2025-12-03 08:30:57', '2025-12-03 02:41:18'),
(9, 16, 6, 3, '2025-12-03 08:43:28', '2025-12-11 01:15:30'),
(10, 90, 2, 3, '2025-12-03 08:44:12', '2025-12-11 01:30:13'),
(11, 15, 4, 4, '2025-12-11 06:45:22', '2025-12-11 06:45:22'),
(12, 90, 9, 3, '2025-12-11 07:12:41', '2025-12-12 00:27:33'),
(13, 16, 7, 4, '2025-12-11 07:14:42', '2025-12-11 07:14:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarifa`
--

CREATE TABLE `tarifa` (
  `id_tarifa` int(10) UNSIGNED NOT NULL,
  `tipoVehiculo` int(10) UNSIGNED DEFAULT NULL,
  `precio` int(11) NOT NULL,
  `idestado` int(10) UNSIGNED DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tarifa`
--

INSERT INTO `tarifa` (`id_tarifa`, `tipoVehiculo`, `precio`, `idestado`, `create_at`, `updated_at`) VALUES
(1, 1, 3500, 1, '2025-02-13 05:29:35', '2025-12-11 07:05:00'),
(2, 2, 1800, 1, '2025-02-18 05:17:04', '2025-12-11 07:17:12'),
(3, 3, 1000, 1, '2025-02-20 10:57:04', '2025-02-20 10:57:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbdescuentos`
--

CREATE TABLE `tbdescuentos` (
  `ID_DESCUENTO` int(10) UNSIGNED NOT NULL,
  `NOMBRE_DES` varchar(50) NOT NULL,
  `FRACCION_MINIMA` int(11) NOT NULL DEFAULT 1,
  `REGLA` int(11) NOT NULL,
  `ESTADO_FK` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbestado`
--

CREATE TABLE `tbestado` (
  `ID_ESTADO` int(10) UNSIGNED NOT NULL,
  `DESCRIPCION_EST` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbestado`
--

INSERT INTO `tbestado` (`ID_ESTADO`, `DESCRIPCION_EST`) VALUES
(1, 'ACTIVO'),
(2, 'INACTIVO'),
(3, 'DISPONIBLE'),
(4, 'OCUPADO'),
(5, 'FINALIZADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbparqueaderos`
--

CREATE TABLE `tbparqueaderos` (
  `ID_PARQUEADERO` int(10) UNSIGNED NOT NULL,
  `nit` varchar(13) NOT NULL,
  `NOMBRE` varchar(50) NOT NULL,
  `DIRECCION` varchar(80) NOT NULL,
  `ESTADO_FK` int(11) NOT NULL DEFAULT 1,
  `phone` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbparqueaderos`
--

INSERT INTO `tbparqueaderos` (`ID_PARQUEADERO`, `nit`, `NOMBRE`, `DIRECCION`, `ESTADO_FK`, `phone`) VALUES
(1, '900055094-1', 'Aquiles Colmbia SAS', 'Bogota-Chapinero', 1, '3125891781');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbperfiles`
--

CREATE TABLE `tbperfiles` (
  `ID_PERFIL` int(10) UNSIGNED NOT NULL,
  `NOMBRE_PER` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbperfiles`
--

INSERT INTO `tbperfiles` (`ID_PERFIL`, `NOMBRE_PER`) VALUES
(1, 'ADMINISTRADOR'),
(2, 'EMPLEADO'),
(3, 'CLIENTE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbusuarios`
--

CREATE TABLE `tbusuarios` (
  `ID_USUARIO` bigint(20) UNSIGNED NOT NULL,
  `IDENTIFICACION` varchar(15) NOT NULL,
  `NOMBRES` varchar(100) NOT NULL,
  `APELLIDOS` varchar(100) NOT NULL,
  `CELULAR` varchar(10) NOT NULL,
  `EMAIL` varchar(80) NOT NULL,
  `CONTRASENA` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `PERFIL_FK` int(10) UNSIGNED NOT NULL,
  `ESTADO_FK` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbusuarios`
--

INSERT INTO `tbusuarios` (`ID_USUARIO`, `IDENTIFICACION`, `NOMBRES`, `APELLIDOS`, `CELULAR`, `EMAIL`, `CONTRASENA`, `created_at`, `updated_at`, `PERFIL_FK`, `ESTADO_FK`) VALUES
(2, '254700079-2', 'Pier', 'Dodswell', '8086159351', 'pdodswell0@state.tx.us', 'qK8&.wW)3o*>EKLSD\"@7\'KsQ4', '2024-06-02 10:00:00', '2025-01-07 01:47:28', 3, 1),
(3, '567768278-0', 'Casar', 'Heinssen', '8318573141', 'cheinssen1@whitehouse.gov', 'jM2=&fd2kRzt0SL*t_ch&B', '2024-02-21 10:00:00', '2025-01-07 01:47:28', 3, 1),
(4, '404586264-1', 'Amelina', 'Litton', '3513867894', 'alitton2@eventbrite.com', 'rH0(Pj$UGYfgNp#=AV\'#aC=uz,Y', '2024-04-05 10:00:00', '2025-01-07 01:47:28', 3, 1),
(5, '427459547-1', 'Quinn', 'Nelm', '2401085812', 'qnelm3@tripod.com', 'nH1\"ll6Az&d0AOvqvU0f=NDA5@F{F/1@W', '2024-04-09 10:00:00', '2025-01-07 01:47:28', 3, 1),
(6, '284891355-X', 'Bernarr', 'Beedle', '5714274385', 'bbeedle4@deviantart.com', 'pD0*Z37gfe\'%,L2v\"\"', '2024-07-05 10:00:00', '2025-01-07 01:47:28', 3, 1),
(7, '528306155-8', 'Neile', 'Russen', '1198784235', 'nrussen5@woothemes.com', 'xP8\'aOYkR#>_<Q4k/6n\"WFb0', '2024-07-13 10:00:00', '2024-05-21 10:00:00', 3, 1),
(8, '946356861-1', 'Doll', 'Hug', '9409630275', 'dhug6@ft.com', 'bR6?h3WQ&WrPe)rZyJ`&11<(KV', '2024-11-04 10:00:00', '2025-01-07 01:44:35', 3, 1),
(9, '086708906-7', 'Jordanna', 'Breakey', '8408702672', 'jbreakey7@scientificamerican.com', 'yQ7!y~)U7mVR)}h_%TMG|', '2024-10-15 10:00:00', '2025-01-07 01:44:35', 3, 1),
(10, '059240435-8', 'Emmott', 'Croucher', '8098945365', 'ecroucherb@dagondesign.com', 'oZ6|T\'wFlA`t5l,eYTbM02f?/Ge|kZ=8R<gl', '2024-09-10 10:00:00', '2025-01-07 01:47:28', 3, 1),
(11, '574108523-7', 'Rafaello Luis', 'Halloran', '3508220551', 'rhalloranc@wp.com', 'lC0.~4@HadvVn|qt_h|', '2024-03-15 10:00:00', '2025-12-01 05:10:39', 3, 1),
(12, '630640377-9', 'Towny', 'Birdall', '2918289586', 'tbirdalld@irs.gov', 'yY5.|\'curne0%acACNE', '2024-05-11 10:00:00', '2025-01-07 01:47:28', 3, 1),
(13, '548549871-X', 'Dorene', 'Eley', '8304651736', 'deleye@newsvine.com', 'hV92602~t)xjJKdTj}I%3i29GVZSii\"', '2024-02-11 10:00:00', '2025-01-07 01:47:28', 3, 1),
(14, '910981100-1', 'Marilee', 'Manchester', '1582827982', 'mmanchesterf@nationalgeographic.com', 'qC2`HNJCpcj=,,PJ_nw!,m$K', '2024-10-29 10:00:00', '2025-01-07 01:44:35', 3, 1),
(15, '5555988745', 'Jae', 'Lamey', '3027015595', 'jlameyg@gmpg.org', 'mE3.B,P$D(t7mpqp$xzR', '2024-08-28 10:00:00', '2025-12-03 02:14:48', 3, 1),
(16, '612831312-4', 'Ginevra', 'O\'Logan', '1945183187', 'gologanh@msu.edu', 'jV4|asG+R%~UU@E1KGUGkCZRL%', '2024-03-08 10:00:00', '2025-01-07 01:47:28', 3, 1),
(17, '141129457-2', 'Kennan', 'Cuthill', '3431306368', 'kcuthillk@studiopress.com', 'pB6$LMFy1wm=y@CI6V(OZ)Vb@\'+Tn', '2024-06-21 10:00:00', '2025-01-07 01:47:28', 3, 1),
(18, '198502687-2', 'Orazio', 'Beausang', '1312033312', 'obeausangl@marketwatch.com', 'qI3~IuamAy0~cOyRJX}9s@bEdQ\"o{c(', '2024-03-09 10:00:00', '2024-11-12 10:00:00', 3, 1),
(19, '446492839-0', 'Neddy', 'Dunbavin', '4294215077', 'ndunbavinm@usgs.gov', 'eQ1>gz+eZau,RV|bK_,|\'9gc5qiWW2i+k2', '2024-05-03 10:00:00', '2025-01-07 01:47:28', 3, 1),
(20, '396437218-8', 'Clo', 'Templeman', '2449966430', 'ctemplemann@apple.com', 'iY3\'5\"M/9rfl}fhvO\"&1A<GUjJ#awW0~7T', '2024-02-01 10:00:00', '2025-01-07 01:47:28', 3, 1),
(21, '379221376-1', 'Salomo', 'Jarmaine', '9217748418', 'sjarmaineo@skyrock.com', 'tP7#Qgu6Z281xhIE(Se}M', '2024-01-30 10:00:00', '2025-01-07 01:44:35', 3, 1),
(22, '382761185-7', 'Henrieta', 'Gerraty', '5412205973', 'hgerratyp@skype.com', 'nO5&z}!YkcXA,NrW8VL,gx#Dhyv~D', '2024-07-12 10:00:00', '2025-01-07 01:44:35', 3, 1),
(23, '560247274-6', 'Viola', 'Yerill', '2827299843', 'vyerillq@narod.ru', 'vP5|Hd+(fhZ*=.)Izmr3', '2024-05-25 10:00:00', '2025-01-07 01:44:35', 3, 1),
(25, '411237148-9', 'Thane', 'Grigoliis', '1342170338', 'tgrigoliiss@ft.com', 'tK7|#4D.EQI(jWS<,Bz\'XDbRX_foP', '2024-09-03 10:00:00', '2025-01-07 01:47:28', 3, 1),
(26, '660515910-1', 'Caterina', 'Goodlake', '1171947681', 'cgoodlaket@ehow.com', 'pM8+mY*g#+WE$I_mIPu{', '2024-04-13 10:00:00', '2025-01-07 01:47:28', 3, 1),
(27, '531876750-8', 'Bernie', 'Battie', '5437747070', 'bbattieu@elegantthemes.com', 'tF5<u~1*q56D1&0nsw7Y!C(Gp7uv|c1~', '2024-11-09 10:00:00', '2024-11-04 10:00:00', 3, 1),
(28, '182895340-7', 'Jervis', 'Stenson', '5821962868', 'jstensonv@utexas.edu', 'cB6,1~!XQO97F8FQ6E5HGPm|9HOy?<&CP', '2024-07-21 10:00:00', '2024-08-09 10:00:00', 3, 1),
(29, '252717544-9', 'Nicolette', 'Slowan', '3686450917', 'nslowanw@yellowbook.com', 'pO7\"@@y3fBP,z%zIK@+x!fX(V', '2024-03-16 10:00:00', '2024-12-30 10:00:00', 3, 1),
(30, '341179198-5', 'Stanislas', 'Andrioni', '4094668996', 'sandrionix@tumblr.com', 'hH5#Idf8b</$@asAt7vq', '2024-09-05 10:00:00', '2024-08-18 10:00:00', 3, 1),
(31, '802310465-9', 'Ash', 'Fellini', '3503992627', 'afelliniy@feedburner.com', 'uW3=}l4Y\'Zjmx7e(IB7C!D', '2024-05-23 10:00:00', '2025-01-07 01:47:28', 3, 1),
(32, '872090754-0', 'Ella', 'McMackin', '8008196305', 'emcmackinz@rakuten.co.jp', 'kI2|mK_~9lQ&{p`hHjMXIvSX$Vt', '2024-12-05 10:00:00', '2025-01-07 01:47:28', 3, 1),
(33, '572978759-6', 'Phip', 'MacParlan', '1667064803', 'pmacparlan10@indiegogo.com', 'kI1}tX70jA1T<<ygV`W', '2024-01-17 10:00:00', '2025-01-07 01:47:28', 3, 1),
(34, '993489251-0', 'Rasla', 'Papa', '8699099575', 'rpapa11@ucoz.com', 'cZ7_u~+ldM8v(UPV*_kgQ}6UtZ<X`3jP', '2024-09-14 10:00:00', '2025-01-07 01:47:28', 3, 1),
(35, '048772615-4', 'Osmond', 'Westlake', '7113160767', 'owestlake12@drupal.org', 'cH1%QfJ}sK~7/1xC2m', '2024-01-28 10:00:00', '2024-05-21 10:00:00', 3, 1),
(36, '195420183-4', 'Hercules', 'Orchart', '9309845954', 'horchart13@xrea.com', 'gK7\"CXgHzjD@%iRQFx`Y', '2024-10-15 10:00:00', '2025-01-07 01:47:28', 3, 1),
(37, '753070990-9', 'Tedman', 'Pickerin', '2463926427', 'tpickerin17@amazon.co.uk', 'oN7<!oANJFR/P|&WXP9_xf)pL7!vv*BbJ', '2024-06-01 10:00:00', '2025-01-07 01:47:28', 3, 1),
(38, '617308888-6', 'Elysee', 'Braikenridge', '8578509890', 'ebraikenridge18@homestead.com', 'vH3*pI(yL%~J{=>_1oamV!)|', '2024-05-23 10:00:00', '2025-01-07 01:44:35', 3, 1),
(39, '272462751-2', 'Lizette', 'Grogan', '1011805282', 'lgrogan19@berkeley.edu', 'zO1\"T/Lm\"z2>kmv(+', '2024-06-14 10:00:00', '2025-01-07 01:47:28', 3, 1),
(40, '019594414-3', 'Farlie', 'Bear', '2305513011', 'fbear1a@example.com', 'xE2<BhjQDyPB6.oF`QS24)<I%OW}J+', '2024-05-12 10:00:00', '2025-01-07 01:47:28', 3, 1),
(41, '859089577-7', 'Katherina', 'McCabe', '9133178358', 'kmccabe1b@toplist.cz', 'hX0<&UdChWc)#1MFqLgZPRHvhGM}w', '2024-10-18 10:00:00', '2024-05-12 10:00:00', 3, 1),
(42, '517571228-4', 'Doralia', 'Pluthero', '4905829299', 'dpluthero1c@state.gov', 'kX7.!(LGouXs#jMK60kTx', '2024-06-12 10:00:00', '2025-01-07 01:47:28', 3, 1),
(43, '836419444-5', 'Heinrick', 'Denkel', '9463538868', 'hdenkel1d@whitehouse.gov', 'uI4>.b4@Ia_)+3Z3,h1Q#hU.)DZw+=WD}Mn_', '2024-11-11 10:00:00', '2025-01-07 01:44:35', 3, 1),
(44, '187888336-4', 'Mitchell', 'Brazenor', '5304971118', 'mbrazenor1e@timesonline.co.uk', 'dX5~lpj@qa\'\"FpDV8PyBw`uyyap@.I`_', '2024-07-15 10:00:00', '2025-01-07 01:47:28', 3, 1),
(45, '121929827-1', 'Dorris', 'Lampart', '1797102456', 'dlampart1f@boston.com', 'wR6Ymzr1K6CK/omWD1=d2NWokbf&C</', '2024-07-12 10:00:00', '2024-04-26 10:00:00', 3, 1),
(46, '298091066-X', 'Kristofer', 'Dansey', '1689470045', 'kdansey1g@vk.com', 'dW3\"8*>sjp8kH_sdS=IprTB<%O9L?ILo7C\"', '2024-08-06 10:00:00', '2024-06-13 10:00:00', 3, 1),
(47, '641726616-8', 'Theadora', 'Thorington', '3171005471', 'tthorington1h@goo.ne.jp', 'dY3\'6_#A~)#E_\'G1J%&L&TnhQlH', '2024-05-02 10:00:00', '2024-07-27 10:00:00', 3, 1),
(48, '316278101-9', 'Dulce', 'Abela', '8686356128', 'dabela1i@spiegel.de', 'vR0+a~qa7T4>pnxqjU/{aE|m!tCCe0*p_', '2024-04-29 10:00:00', '2025-01-07 01:47:28', 3, 1),
(49, '223611302-1', 'Dylan', 'Di Biasi', '3561929646', 'ddibiasi1j@yellowpages.com', 'xX4|iJ#5Q/O/>OL`zTv', '2024-04-17 10:00:00', '2025-01-07 01:44:35', 3, 1),
(50, '168460915-1', 'Lonnie', 'McVeigh', '8106128713', 'lmcveigh1k@jugem.jp', 'gK2#3GER6ys|2>T%aYceH.', '2024-07-12 10:00:00', '2024-11-14 10:00:00', 3, 1),
(51, '326133678-1', 'Ddene', 'Carpe', '7243472071', 'dcarpe1l@upenn.edu', 'dZ6%|?sX3~$gbSTsB}m.bj', '2024-07-17 10:00:00', '2025-01-07 01:47:28', 3, 1),
(52, '674372412-2', 'Sebastien', 'Axel', '1977041131', 'saxel1m@amazonaws.com', 'mT9\"~,F&o}4Kn!bHXFv/SE', '2024-06-02 10:00:00', '2025-01-07 01:47:28', 3, 1),
(53, '806943151-2', 'Dale', 'Ennew', '5212086560', 'dennew1n@360.cn', 'gE6)uFG==%zFd|HY|}Q2#xsq2cXp', '2024-08-21 10:00:00', '2024-03-09 10:00:00', 3, 1),
(54, '382522047-8', 'Clayborn', 'Cullagh', '6272678611', 'ccullagh1o@lycos.com', 'gE3#3Nhg6otq1qmx$pLxR$45I', '2024-11-10 10:00:00', '2025-01-07 01:44:35', 3, 1),
(55, '507331464-6', 'Karolina', 'Gyves', '8089715578', 'kgyves1p@reuters.com', 'aA7%K>I~.<DP!zch\Z8s{_Twy5.QkO%', '2024-09-06 10:00:00', '2025-01-07 01:47:28', 3, 1),
(56, '108732092-5', 'Abby', 'Neath', '8789794343', 'aneath1q@meetup.com', 'lF6.yUoJ).H0AP#c#MRz', '2024-09-04 10:00:00', '2025-01-07 01:47:28', 3, 1),
(57, '318848466-6', 'Jeremias', 'Choat', '5028814666', 'jchoat1r@opensource.org', 'nM5(w35US`feJZzH_8b/UKN//i1Gr(', '2024-07-07 10:00:00', '2024-05-19 10:00:00', 3, 1),
(58, '311271156-4', 'Fiann', 'Illsley', '5965228332', 'fillsley1s@irs.gov', 'qG5}%$DHZS+9RQ*raSh2Bxwn+G3+0spB', '2024-06-01 10:00:00', '2025-01-07 01:44:35', 3, 1),
(59, '915356915-6', 'Gavra', 'Sherwell', '3083044334', 'gsherwell1t@imageshack.us', 'oC8<s`*bNj8`uT?5+c6M00NC4~{lhQQosU', '2024-07-20 10:00:00', '2025-01-07 01:44:35', 3, 1),
(60, '150045416-8', 'Barth', 'Tonge', '3208218058', 'btonge1u@shutterfly.com', 'fS4>@ET/<61>Q&YA2&8zg/{po&_dUo', '2024-01-19 10:00:00', '2024-11-19 10:00:00', 3, 1),
(61, '248588198-7', 'Tansy', 'Dickenson', '7434788297', 'tdickenson1v@blogtalkradio.com', 'aJ9>{+#3Q3~aJcoV?/H,K/Yn', '2024-02-04 10:00:00', '2025-01-07 01:47:28', 3, 1),
(62, '036431951-8', 'Bryon', 'Steenson', '1932335324', 'bsteenson1w@scientificamerican.com', 'gO964P{aR1*pwOn=Q`lMZE', '2024-08-15 10:00:00', '2025-01-07 01:47:28', 3, 1),
(63, '506013448-2', 'Cheston', 'Saffe', '3689221998', 'csaffe1x@homestead.com', 'yG1<f5ueHiQejO7~hn<ML0wUK%D<vT%}.C', '2024-02-13 10:00:00', '2025-01-07 01:44:35', 3, 1),
(64, '627130290-4', 'Elka', 'Siley', '9223751564', 'esiley1y@pagesperso-orange.fr', 'eU9_B~/\'hw<>B0.}vVe$+=%$#uZ', '2024-08-20 10:00:00', '2025-01-07 01:47:28', 3, 1),
(65, '904909037-0', 'Brandi', 'Augar', '9658171032', 'baugar1z@parallels.com', 'xU3A&LRZBAwT)1cI8yRL6~0r7BXX', '2024-11-05 10:00:00', '2025-01-07 01:44:35', 3, 1),
(66, '471826595-9', 'Lurleen', 'Pobjoy', '8059673447', 'lpobjoy20@ehow.com', 'aA7@vfnwo?}Snkb38b0(H(8KJ&6SSKIGN|', '2024-06-14 10:00:00', '2025-01-07 01:47:28', 3, 1),
(67, '091178759-3', 'Tailor', 'Sargeant', '4642571721', 'tsargeant21@domainmarket.com', 'sP7)l)jW{\"l9pv5NopUh', '2024-09-13 10:00:00', '2025-01-07 01:44:35', 3, 1),
(68, '248256437-9', 'Penelopa', 'Eckels', '7603457422', 'peckels22@cbsnews.com', 'cQ5}JoL3c$)Jh2p+0EkyG}aG%\"=D\'3/+', '2024-10-28 10:00:00', '2025-01-07 01:47:28', 3, 1),
(69, '057682717-7', 'Philippe', 'Papierz', '3614019101', 'ppapierz23@cafepress.com', 'pB2(i0!\"oeJjD@E(gk', '2024-08-01 10:00:00', '2025-01-07 01:44:35', 3, 1),
(70, '985563294-X', 'Augusto', 'Thomke', '4716079682', 'athomke24@51.la', 'mA8+o`NsJ0~@))T1Jc1kpz<Lk8\"', '2024-01-07 10:00:00', '2025-01-07 01:47:28', 3, 1),
(71, '428512910-8', 'Colleen', 'Cran', '4519109648', 'ccran25@ca.gov', 'nX1~hMh5tMnNScjsK4Wvxc8%!0`<(p', '2024-11-26 10:00:00', '2025-01-07 01:44:35', 3, 1),
(72, '273684454-8', 'Linnell', 'Carl', '5217229891', 'lcarl26@amazon.co.uk', 'gN9e7)WN)uM}z~K,DVC<5@)(', '2024-10-15 10:00:00', '2025-01-07 01:44:35', 3, 1),
(73, '434359372-X', 'Dorolisa', 'Burkinshaw', '9011765739', 'dburkinshaw2b@usgs.gov', 'oH4*q%X|a(<5|cqD)ekc1woH(0a', '2024-07-19 10:00:00', '2025-01-07 01:47:28', 3, 1),
(74, '187601880-1', 'Aloisia', 'Drable', '6848768102', 'adrable2c@google.cn', 'bQ6>HqWpPEb2C7@pi*8j|/Z\"mVw9@', '2024-01-23 10:00:00', '2025-01-07 01:47:28', 3, 1),
(75, '980056778-X', 'Cos', 'Hagland', '8535903126', 'chagland2d@sphinn.com', 'dN1\"H1NH@>EsrXQ\'6hi{r~<La=', '2024-07-15 10:00:00', '2025-01-07 01:47:28', 3, 1),
(76, '352377261-3', 'Annabel', 'Rose', '8915612314', 'arose2e@abc.net.au', 'eW6@HCvU66(Uq+(v#TovnAx', '2024-09-28 10:00:00', '2025-01-07 01:44:35', 3, 1),
(77, '783848375-1', 'Anthia', 'Oxshott', '1488623357', 'aoxshott2f@nationalgeographic.com', 'tS4\'9r>@q=pZd(tj4?upJsT2$D.H(tKojof<', '2024-07-03 10:00:00', '2025-01-07 01:47:28', 3, 1),
(78, '654177158-8', 'Lilian', 'Caudelier', '4458667966', 'lcaudelier2g@multiply.com', 'aH5?~/eNJ*B_oUiV&%&\'7_4=tKZ9|8', '2024-07-12 10:00:00', '2025-01-07 01:44:35', 3, 1),
(79, '786362276-X', 'Ardine', 'Newbatt', '4812345563', 'anewbatt2h@elpais.com', 'wC1Im_7fxO<Ucy,RgFEr_nQ+KphJm', '2024-05-25 10:00:00', '2025-01-07 01:47:28', 3, 1),
(80, '963756338-5', 'Hurley', 'McNiff', '1377077032', 'hmcniff2i@reddit.com', 'lX8=Zp$5gc$qurW|MPFSdS+DFi$zP&>', '2024-03-24 10:00:00', '2024-12-22 10:00:00', 3, 1),
(81, '666486451-7', 'Karen', 'Collidge', '7221421278', 'kcollidge2j@odnoklassniki.ru', 'pF9(xhm<DXs>OKrcN~mV7s%zcwA6', '2024-03-23 10:00:00', '2025-01-07 01:47:28', 3, 1),
(82, '180521576-0', 'Osbourn', 'Neary', '7945935719', 'oneary2k@google.de', 'kL8&k*9QC$z@)t,9`8Mr*YxBC3', '2024-09-20 10:00:00', '2025-01-07 01:47:28', 3, 1),
(83, '008444241-7', 'Aura', 'Steinhammer', '6826738784', 'asteinhammer2l@mozilla.com', 'eI0?GW|H6$\"MDPLTAnp3MHX0LA\'(PmluP/', '2024-10-23 10:00:00', '2025-01-07 01:47:28', 3, 1),
(85, '248732122-9', 'Artie', 'Harries', '5942841879', 'aharries2n@uol.com.br', 'oU2~qIg7!|v|+n|1\'s%', '2024-04-08 10:00:00', '2024-04-12 10:00:00', 3, 1),
(86, '596789937-5', 'Rodrique', 'Fidal', '6677131361', 'rfidal2o@shutterfly.com', 'pass1234', '2024-04-09 10:00:00', '2025-01-23 11:17:33', 3, 1),
(87, '347836927-4', 'Efrem', 'McLenaghan', '3915290360', 'emclenaghan2p@flavors.me', 'pJ2&05VbuNRAA_pf!0W', '2024-09-28 10:00:00', '2025-01-07 01:47:28', 3, 1),
(88, '405119226-1', 'Nessy', 'Jakubovits', '6275322429', 'njakubovits2q@msn.com', 'dW7//N)8=f)1bo+(O#NAv,Gcg%RQ<kQlT', '2024-07-05 10:00:00', '2025-01-07 01:47:28', 3, 1),
(89, '435378940-6', 'Langsdon', 'Carvil', '5908590793', 'lcarvil2r@thetimes.co.uk', 'kM3#v(G{8LO8\"}=#!\">a', '2024-12-30 10:00:00', '2025-01-07 01:47:28', 3, 1),
(90, '354426', 'Nisbeth Maria', 'Suarez Mata', '555555555', 'nisbethsuarez@gmail.com', 'exito.2015', '2025-01-19 12:47:48', '2025-12-11 07:10:02', 3, 1),
(92, '35555555', 'Nisbeth', 'Mata', '444444444', 'nisbethjob@gmail.com', 'exito2030', '2025-01-19 13:30:07', '2025-01-19 13:30:07', 3, 1),
(94, '1034310428', 'Ruben', 'Suarez', '5555555555', 'ruben@gmail.com', 'pass1234', '2025-01-23 11:39:22', '2025-12-11 07:19:48', 3, 1),
(97, '252525', 'Romeo', 'Nata', '777777777', 'romeo@gmail.com', 'pass1234', '2025-01-23 11:45:35', '2025-01-23 11:45:35', 1, 1),
(100, '24242424', 'Kiaro', 'Mata', '56565656', 'kiaro@gmai.com', 'pas1234', '2025-01-23 12:16:02', '2025-01-23 12:16:02', 3, 1),
(101, '355135', 'Leonardo Augusto', 'Suarez Mata ', '3186554203', 'leonardo@gmail.com', 'Leo1234', '2025-03-05 10:50:53', '2025-03-05 10:50:53', 3, 1),
(102, '871104', 'Ana', 'Mata', '898989', 'anamata.suarez@gmail.com', 'Caracas.2025*', '2025-12-11 07:20:52', '2025-12-11 07:20:52', 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipovehiculo`
--

CREATE TABLE `tipovehiculo` (
  `id_tipo` int(10) UNSIGNED NOT NULL,
  `vehiculo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipovehiculo`
--

INSERT INTO `tipovehiculo` (`id_tipo`, `vehiculo`) VALUES
(1, 'Carro'),
(2, 'Moto'),
(3, 'Bicicleta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

CREATE TABLE `vehiculo` (
  `id_vehiculo` bigint(20) UNSIGNED NOT NULL,
  `placa` varchar(12) NOT NULL,
  `marca` varchar(20) NOT NULL,
  `modelo` varchar(20) NOT NULL,
  `color` varchar(20) NOT NULL,
  `idusuario` bigint(20) UNSIGNED NOT NULL,
  `id_tipovehiculo` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculo`
--

INSERT INTO `vehiculo` (`id_vehiculo`, `placa`, `marca`, `modelo`, `color`, `idusuario`, `id_tipovehiculo`, `created_at`, `updated_at`) VALUES
(1, 'XXX1974', 'FORD', 'Nueva Bronco', 'Roja con blanco', 90, 1, '2025-01-26 12:36:06', '2025-11-30 23:12:28'),
(2, 'xx2222', 'Zuzuqui', 'Vespa', 'negra', 90, 2, '2025-01-31 11:52:16', '2025-01-31 11:52:16'),
(3, 'SST1974', 'Toyota', 'SUV', 'Azul', 7, 1, '2025-12-01 08:13:00', '2025-12-01 08:13:00'),
(4, 'CCN111', 'Toyota', 'Yari', 'rojo', 15, 1, '2025-12-01 08:18:06', '2025-12-03 02:06:17'),
(5, 'CNT1975', 'Yamaha', 'Aerox', 'azul y negro', 15, 2, '2025-12-01 08:21:46', '2025-12-01 08:21:46'),
(6, 'TT1024', 'Toyota', 'SUV', 'negra', 16, 1, '2025-12-03 08:17:50', '2025-12-03 08:17:50'),
(7, 'NUN1995', 'FORD', 'Rojo', 'negra', 16, 3, '2025-12-03 08:18:46', '2025-12-03 08:18:46'),
(9, 'C111222', 'Kia', 'SUV electrico', 'Dorado y Negro', 90, 1, '2025-12-11 07:00:20', '2025-12-11 07:00:37'),
(10, '555NNN', 'Ford', 'KIA', 'azul', 94, 1, '2025-12-11 07:18:29', '2025-12-11 07:18:29');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `tbparqueaderos3_fkey` (`idparqueadero`),
  ADD KEY `historial_puesto_fkey` (`id_historialpuesto`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`idhistorico`);

--
-- Indices de la tabla `historial_puesto`
--
ALTER TABLE `historial_puesto`
  ADD PRIMARY KEY (`idpuesto`),
  ADD KEY `tbestado2_fkey` (`ESTADO_FK`),
  ADD KEY `tbusuarios2_fkey` (`idusuario`),
  ADD KEY `vehiculo_fkey` (`idvehiculo`);

--
-- Indices de la tabla `tarifa`
--
ALTER TABLE `tarifa`
  ADD PRIMARY KEY (`id_tarifa`);

--
-- Indices de la tabla `tbdescuentos`
--
ALTER TABLE `tbdescuentos`
  ADD PRIMARY KEY (`ID_DESCUENTO`),
  ADD KEY `tbDescuentos_fkey` (`ESTADO_FK`);

--
-- Indices de la tabla `tbestado`
--
ALTER TABLE `tbestado`
  ADD PRIMARY KEY (`ID_ESTADO`);

--
-- Indices de la tabla `tbparqueaderos`
--
ALTER TABLE `tbparqueaderos`
  ADD PRIMARY KEY (`ID_PARQUEADERO`);

--
-- Indices de la tabla `tbperfiles`
--
ALTER TABLE `tbperfiles`
  ADD PRIMARY KEY (`ID_PERFIL`);

--
-- Indices de la tabla `tbusuarios`
--
ALTER TABLE `tbusuarios`
  ADD PRIMARY KEY (`ID_USUARIO`),
  ADD UNIQUE KEY `IDENTIFICACION` (`IDENTIFICACION`),
  ADD KEY `tbestado_fkey` (`ESTADO_FK`),
  ADD KEY `tbperfiles_fkey` (`PERFIL_FK`);

--
-- Indices de la tabla `tipovehiculo`
--
ALTER TABLE `tipovehiculo`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD PRIMARY KEY (`id_vehiculo`),
  ADD UNIQUE KEY `placa` (`placa`),
  ADD KEY `tbusuarios_fkey` (`idusuario`),
  ADD KEY `tbtipovehiculo_fkey` (`id_tipovehiculo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id_factura` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `idhistorico` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_puesto`
--
ALTER TABLE `historial_puesto`
  MODIFY `idpuesto` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tarifa`
--
ALTER TABLE `tarifa`
  MODIFY `id_tarifa` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbdescuentos`
--
ALTER TABLE `tbdescuentos`
  MODIFY `ID_DESCUENTO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbestado`
--
ALTER TABLE `tbestado`
  MODIFY `ID_ESTADO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tbparqueaderos`
--
ALTER TABLE `tbparqueaderos`
  MODIFY `ID_PARQUEADERO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbperfiles`
--
ALTER TABLE `tbperfiles`
  MODIFY `ID_PERFIL` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbusuarios`
--
ALTER TABLE `tbusuarios`
  MODIFY `ID_USUARIO` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT de la tabla `tipovehiculo`
--
ALTER TABLE `tipovehiculo`
  MODIFY `id_tipo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  MODIFY `id_vehiculo` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `historial_puesto_fkey` FOREIGN KEY (`id_historialpuesto`) REFERENCES `historial_puesto` (`idpuesto`),
  ADD CONSTRAINT `tbparqueaderos3_fkey` FOREIGN KEY (`idparqueadero`) REFERENCES `tbparqueaderos` (`ID_PARQUEADERO`);

--
-- Filtros para la tabla `historial_puesto`
--
ALTER TABLE `historial_puesto`
  ADD CONSTRAINT `tbestado2_fkey` FOREIGN KEY (`ESTADO_FK`) REFERENCES `tbestado` (`ID_ESTADO`),
  ADD CONSTRAINT `tbusuarios2_fkey` FOREIGN KEY (`idusuario`) REFERENCES `tbusuarios` (`ID_USUARIO`),
  ADD CONSTRAINT `vehiculo_fkey` FOREIGN KEY (`idvehiculo`) REFERENCES `vehiculo` (`id_vehiculo`);

--
-- Filtros para la tabla `tbdescuentos`
--
ALTER TABLE `tbdescuentos`
  ADD CONSTRAINT `tbDescuentos_fkey` FOREIGN KEY (`ESTADO_FK`) REFERENCES `tbestado` (`ID_ESTADO`);

--
-- Filtros para la tabla `tbusuarios`
--
ALTER TABLE `tbusuarios`
  ADD CONSTRAINT `tbestado_fkey` FOREIGN KEY (`ESTADO_FK`) REFERENCES `tbestado` (`ID_ESTADO`),
  ADD CONSTRAINT `tbperfiles_fkey` FOREIGN KEY (`PERFIL_FK`) REFERENCES `tbperfiles` (`ID_PERFIL`);

--
-- Filtros para la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD CONSTRAINT `tbtipovehiculo_fkey` FOREIGN KEY (`id_tipovehiculo`) REFERENCES `tipovehiculo` (`id_tipo`),
  ADD CONSTRAINT `tbusuarios_fkey` FOREIGN KEY (`idusuario`) REFERENCES `tbusuarios` (`ID_USUARIO`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
