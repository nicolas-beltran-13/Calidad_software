-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-10-2025 a las 17:05:37
-- Versión del servidor: 11.7.2-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `salsamentaria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id_pedidio` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_detallepedido` int(11) NOT NULL,
  `direccion` int(11) NOT NULL,
  `Precio_pedido` int(11) NOT NULL,
  `estado pedido` int(11) NOT NULL,
  `fecha de peddio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `nombreProducto` varchar(50) NOT NULL,
  `Precio` int(11) NOT NULL,
  `Descripcion` text NOT NULL,
  `foto` longblob DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `id_tipo_producto` int(11) NOT NULL,
  `valordeStock` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombreProducto`, `Precio`, `Descripcion`, `foto`, `cantidad`, `id_tipo_producto`, `valordeStock`, `id_vendedor`) VALUES
(1, 'Salchicha Perro Caliente', 10500, 'Salchicha americana para hot dogs, paquete 500g', NULL, 50, 1, 525000, 2),
(2, 'Jamón de Cerdo Ahumado', 18200, 'Jamón de pernil de cerdo ahumado, 250g tajado', NULL, 35, 1, 637000, 2),
(3, 'Mortadela de Pollo', 6800, 'Mortadela de pollo, 500g', NULL, 60, 1, 408000, 2),
(4, 'Chorizo Parrillero', 14900, 'Chorizo de cerdo para asar, 6 unidades', NULL, 45, 1, 670500, 2),
(5, 'Salami Tipo Génova', 25000, 'Salami curado, 150g empacado al vacío', NULL, 20, 1, 500000, 2),
(6, 'Queso Doble Crema', 12300, 'Queso fresco, suave, 250g', NULL, 55, 2, 676500, 2),
(7, 'Queso Mozzarella Bloque', 21900, 'Queso semi-duro para gratinar, 500g', NULL, 40, 2, 876000, 2),
(8, 'Queso Parmesano Rallado', 8900, 'Queso maduro, 100g bolsa', NULL, 70, 2, 623000, 2),
(9, 'Mantequilla sin Sal', 7500, 'Mantequilla fresca, 250g', NULL, 50, 2, 375000, 2),
(10, 'Yogurt Natural Entero', 4200, 'Yogurt sin azúcar, 1 Litro', NULL, 80, 2, 336000, 2),
(11, 'Salsa de Tomate Ketchup', 5100, 'Salsa de tomate clásica, 400g botella', NULL, 90, 3, 459000, 2),
(12, 'Mayonesa Clásica', 6900, 'Aderezo de huevo y aceite, 500g', NULL, 75, 3, 517500, 2),
(13, 'Mostaza Americana', 4800, 'Mostaza suave, 250g', NULL, 85, 3, 408000, 2),
(14, 'Salsa BBQ Ahumada', 9500, 'Salsa para carnes a la parrilla, 370g', NULL, 50, 3, 475000, 2),
(15, 'Aderezo Ranch', 7200, 'Aderezo cremoso para ensaladas, 300g', NULL, 40, 3, 288000, 2),
(16, 'Harina de Trigo Todo Uso', 3500, 'Harina para múltiples preparaciones, 1000g', NULL, 120, 4, 420000, 2),
(17, 'Polvo de Hornear', 2100, 'Leudante químico, 100g', NULL, 90, 4, 189000, 2),
(18, 'Azúcar Impalpable', 4500, 'Azúcar muy fina para decoración, 200g', NULL, 65, 4, 292500, 2),
(19, 'Levadura Fresca', 1500, 'Levadura para panificación, 50g', NULL, 70, 4, 105000, 2),
(20, 'Esencia de Vainilla', 3800, 'Saborizante líquido, 120ml', NULL, 100, 4, 380000, 2),
(21, 'Frijoles Rojos Secos', 5500, 'Frijoles para cocción, 500g', NULL, 80, 5, 440000, 2),
(22, 'Lentejas Secas', 4900, 'Lentejas para guisos, 500g', NULL, 75, 5, 367500, 2),
(23, 'Arroz Blanco Grano Largo', 3900, 'Arroz tradicional, 1000g', NULL, 150, 5, 585000, 2),
(24, 'Aceite Vegetal Girasol', 12000, 'Aceite para freír y cocinar, 1000ml', NULL, 60, 5, 720000, 2),
(25, 'Sal Marina Yodada', 1800, 'Sal para condimentar, 500g', NULL, 110, 5, 198000, 2),
(26, 'Salchichón Cervecero', 8500, 'Salchichón de res y cerdo, 300g', NULL, 48, 1, 408000, 2),
(27, 'Tocino Ahumado en Tiras', 15600, 'Tiras de tocino curado, 200g', NULL, 30, 1, 468000, 2),
(28, 'Cabano de Pollo', 11000, 'Embutido tipo snack, 150g', NULL, 25, 1, 275000, 2),
(29, 'Jamoneta Navideña', 17500, 'Jamón prensado, 340g', NULL, 15, 1, 262500, 2),
(30, 'Chorizo Pollo Cocktail', 9800, 'Chorizos pequeños de pollo, 12 unidades', NULL, 52, 1, 509600, 2),
(31, 'Queso de Búfala Fresco', 16000, 'Queso suave de leche de búfala, 200g', NULL, 28, 2, 448000, 2),
(32, 'Queso Holandés Madurado', 29500, 'Queso tipo Gouda, 250g', NULL, 18, 2, 531000, 2),
(33, 'Crema de Leche Entera', 6500, 'Crema líquida para cocinar, 200ml', NULL, 42, 2, 273000, 2),
(34, 'Leche UHT Deslactosada', 3900, 'Leche larga vida, 1 Litro', NULL, 100, 2, 390000, 2),
(35, 'Huevos (Docena)', 7800, 'Huevos frescos, 12 unidades', NULL, 60, 2, 468000, 2),
(36, 'Salsa Ají Picante', 3500, 'Salsa picante a base de ají, 150ml', NULL, 70, 3, 245000, 2),
(37, 'Vinagre Blanco', 2500, 'Vinagre de alcohol, 500ml', NULL, 95, 3, 237500, 2),
(38, 'Salsa de Soya Tradicional', 4100, 'Salsa a base de soja, 290ml', NULL, 88, 3, 360800, 2),
(39, 'Orégano Seco Molido', 1900, 'Hierba aromática, 50g', NULL, 120, 3, 228000, 2),
(40, 'Ajo en Polvo', 2300, 'Condimento seco, 100g', NULL, 115, 3, 264500, 2),
(41, 'Maizena (Fécula de Maíz)', 2900, 'Espesante para salsas y postres, 180g', NULL, 78, 4, 226200, 2),
(42, 'Cacao en Polvo Amargo', 6200, 'Cacao puro para repostería, 150g', NULL, 55, 4, 341000, 2),
(43, 'Chips de Chocolate', 8100, 'Chispas para galletas y decoración, 200g', NULL, 45, 4, 364500, 2),
(44, 'Miel de Abejas Pura', 15000, 'Endulzante natural, 300g', NULL, 30, 4, 450000, 2),
(45, 'Colorante Alimentario Rojo', 2000, 'Colorante líquido para alimentos, 30ml', NULL, 60, 4, 120000, 2),
(46, 'Garbanzos Secos', 5800, 'Garbanzos para cocción, 500g', NULL, 70, 5, 406000, 2),
(47, 'Pasta Larga (Espagueti)', 3200, 'Pasta de sémola de trigo, 500g', NULL, 100, 5, 320000, 2),
(48, 'Harina de Maíz Pre-cocida', 4000, 'Harina para arepas, 1000g', NULL, 90, 5, 360000, 2),
(49, 'Atún en Aceite (Lata)', 6700, 'Pescado enlatado, 170g', NULL, 50, 5, 335000, 2),
(50, 'Panela Cuadrada', 2800, 'Endulzante de caña de azúcar, 500g', NULL, 85, 5, 238000, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_producto`
--

CREATE TABLE `tipo_producto` (
  `id_tipo_producto` int(11) NOT NULL,
  `nombreTipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `tipo_producto`
--

INSERT INTO `tipo_producto` (`id_tipo_producto`, `nombreTipo`) VALUES
(1, 'Carnes Frías y Embutidos'),
(2, 'Lácteos y Quesos'),
(3, 'Salsas, Aderezos y Condimentos'),
(4, 'Insumos de Repostería y Panadería'),
(5, 'Abarrotes y Granos Secos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `NumeroIdentificacion` int(11) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `telefono` varchar(11) NOT NULL,
  `rol` varchar(10) NOT NULL,
  `gmail` varchar(50) NOT NULL,
  `contraseña` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `NumeroIdentificacion`, `direccion`, `telefono`, `rol`, `gmail`, `contraseña`) VALUES
(1, 'Martín González', 101000001, 'Calle 10 # 5-20', '3001234567', 'Admin', 'martin.g@salsamentaria.com', 'Admin123'),
(2, 'Sofía Ramírez', 102000002, 'Carrera 8 # 15-30', '3109876543', 'Vendedor', 'sofia.r@salsamentaria.com', 'Vendedor1'),
(3, 'Javier Torres', 103000003, 'Avenida 20 # 40-50', '3205551234', 'Vendedor', 'javier.t@salsamentaria.com', 'Vendedor2'),
(4, 'Valentina Cruz', 104000004, 'Calle 35 # 80-10', '3014449876', 'Vendedor', 'valentina.c@salsamentaria.com', 'Vendedor3'),
(5, 'Ricardo López', 105000005, 'Transversal 12 # 2-75', '3157773322', 'Vendedor', 'ricardo.l@salsamentaria.com', 'Vendedor4'),
(6, 'Andrea Gómez', 106000006, 'Calle 50 # 60-05', '3112224466', 'Vendedor', 'andrea.g@salsamentaria.com', 'Vendedor5');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedidio`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `TipoProducto` (`id_tipo_producto`),
  ADD KEY `id_vendedor` (`id_vendedor`);

--
-- Indices de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  ADD PRIMARY KEY (`id_tipo_producto`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  MODIFY `id_tipo_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`id_tipo_producto`) REFERENCES `tipo_producto` (`id_tipo_producto`),
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`id_vendedor`) REFERENCES `usuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
