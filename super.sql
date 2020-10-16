-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-09-2020 a las 03:41:42
-- Versión del servidor: 10.4.13-MariaDB
-- Versión de PHP: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `super`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_detalle_temp` (IN `codigo` INT, IN `cantidad` INT, IN `token_user` VARCHAR(50))  BEGIN
    
    	DECLARE precio_actual decimal(10,2);
        SELECT precio into precio_actual FROM producto WHERE idproducto = codigo;
        
        INSERT INTO detalletemp(tokenuser, idproducto, cantidad, precioventa) VALUES (token_user, codigo, cantidad, precio_actual);
        
        SELECT tmp.correlativo, tmp.idproducto, p.descripcion, tmp.cantidad, tmp.precioventa FROM detalletemp tmp
        INNER JOIN producto p
        ON tmp.idproducto = p.idproducto
        WHERE tmp.tokenuser = token_user;
        
 	END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `anular_factura` (IN `no_factura` INT)  BEGIN
    	DECLARE existe_factura int;
        DECLARE registros int;
        DECLARE a int;
        
        DECLARE cod_producto int;
        DECLARE cant_producto int;
        DECLARE existencia_actual int;
        DECLARE nueva_existencia int;
        
        SET existe_factura = (SELECT COUNT(*) FROM factura WHERE nofactura = no_factura AND estatus = 1);
        
         IF existe_factura > 0 THEN
         	CREATE TEMPORARY TABLE tbl_tmp(
                id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                cod_prod BIGINT,
                cant_prod int);
                
                SET a = 1;
                     
                SET registros = (SELECT COUNT(*) FROM detallefactura WHERE nofactura = no_factura);
                             
                IF registros > 0 THEN
                	INSERT INTO tbl_tmp(cod_prod,cant_prod) SELECT idproducto,cantidad FROM detallefactura WHERE nofactura = no_factura;
                
                    WHILE a <= registros DO
                        SELECT cod_prod,cant_prod INTO cod_producto, cant_producto FROM tbl_tmp WHERE id = a;
                        SELECT existencia INTO existencia_actual FROM producto WHERE idproducto = cod_producto;
                             
                        SET nueva_existencia = existencia_actual + cant_producto;
                        UPDATE producto SET existencia = nueva_existencia WHERE idproducto = cod_producto;
                             
                        SET a=a+1;
                    END WHILE;
                         
                    UPDATE factura SET estatus = 2 WHERE nofactura = no_factura;
                    DROP TABLE tbl_tmp;
                    SELECT * FROM factura WHERE nofactura = no_factura;
                             
                END IF;
         ELSE
             SELECT 0 factura;
         END IF;
    
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `del_detalle_temp` (IN `id_detalle` INT, IN `token` VARCHAR(50))  BEGIN
    	DELETE FROM detalletemp WHERE correlativo = id_detalle;
        
        SELECT tmp.correlativo, tmp.idproducto, p.descripcion, tmp.cantidad, tmp.precioventa FROM detalletemp tmp
        INNER JOIN producto p
        ON tmp.idproducto = p.idproducto
        WHERE tmp.tokenuser = token;
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `procesar_venta` (`cod_usuario` INT, `cod_cliente` INT, `token` VARCHAR(50))  BEGIN
          DECLARE factura int;
                                    
          DECLARE registros int;
          DECLARE total DECIMAL(10.2);
                                    
          DECLARE nueva_existencia int;
          DECLARE existencia_actual int;
                                    
          DECLARE tmp_cod_producto int;
          DECLARE tmp_cant_producto int;
          DECLARE a int;
          SET a = 1;
                                  
          CREATE TEMPORARY TABLE tbl_tmp_tokenuser (
                 id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
              	 cod_prod BIGINT,
              	 cant_prod int);
                                    
          SET registros = (SELECT COUNT(*) FROM detalletemp WHERE tokenuser = token);
                                    
          IF registros > 0 THEN
          		INSERT INTO tbl_tmp_tokenuser(cod_prod, cant_prod) SELECT idproducto, cantidad FROM detalletemp WHERE tokenuser = token;
                
                INSERT INTO factura(usuario, idcliente) VALUES(cod_usuario, cod_cliente);
                SET factura = LAST_INSERT_ID();
                                    
                INSERT INTO detallefactura(nofactura, idproducto, cantidad, precioventa) SELECT (factura) AS nofactura, idproducto, cantidad, 			      precioventa FROM detalletemp WHERE tokenuser = token;
                                    
              WHILE  a <= registros DO
                  SELECT cod_prod, cant_prod INTO tmp_cod_producto, tmp_cant_producto FROM tbl_tmp_tokenuser WHERE id = a;                     
                  SELECT existencia INTO existencia_actual FROM producto WHERE idproducto = tmp_cod_producto;

                  SET nueva_existencia = existencia_actual - tmp_cant_producto;
                  UPDATE producto SET existencia = nueva_existencia WHERE idproducto = tmp_cod_producto;

                  SET a=a+1;                      

              END WHILE;

                  SET total = (SELECT SUM(cantidad * precioventa) FROM detalletemp WHERE tokenuser = token);
                  UPDATE factura SET totalfactura = total WHERE nofactura = factura; 
                  DELETE FROM detalletemp WHERE tokenuser = token;                  
                  TRUNCATE TABLE tbl_tmp_tokenuser;                  
                  SELECT * FROM factura WHERE nofactura = factura;                  
               
         ELSE
           
           SELECT 0;  
                                    
         END IF;
    END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `button`
--

CREATE TABLE `button` (
  `id` int(11) NOT NULL,
  `estatus` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `button`
--

INSERT INTO `button` (`id`, `estatus`) VALUES
(1, 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL,
  `nit` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `telefono` int(11) NOT NULL,
  `direccion` varchar(80) NOT NULL,
  `dateadd` timestamp NOT NULL DEFAULT current_timestamp(),
  `idusuario` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idcliente`, `nit`, `nombre`, `telefono`, `direccion`, `dateadd`, `idusuario`, `estado`) VALUES
(1, 0, 'CF', 0, 'Guatemala', '2020-08-04 00:17:47', 1, 1),
(7, 505050505, 'Julieta Venegas', 55632569, 'Ciudad Capital 1', '2020-08-04 00:17:47', 1, 0),
(8, 101010101, 'Alejandro Pineda', 54782198, 'ciudad Guatemala', '2020-08-04 00:17:47', 1, 0),
(9, 4545786, 'Enrique Cifuentes', 874522265, 'ciudad Guatemala', '2020-08-04 00:17:47', 1, 1),
(10, 5478987, 'Ingrid', 5487962, 'ciudad Guatemala', '2020-08-09 19:54:04', 1, 1),
(11, 5465879, 'Byron Cruz', 879365421, 'ciudad Guatemala', '2020-08-09 19:54:49', 1, 1),
(12, 1010101010, 'Neto Pachefco', 2147483647, 'ciudad Guatemala', '2020-08-10 21:51:44', 1, 1),
(13, 2266285, 'Ingrid', 548658458, 'Ciudad', '2020-08-27 03:19:46', 1, 1),
(14, 22662654, 'Edard', 958798566, 'ciudad', '2020-08-27 03:21:01', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `nit` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `razon_social` varchar(50) NOT NULL,
  `telefono` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `iva` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `nit`, `nombre`, `razon_social`, `telefono`, `email`, `direccion`, `iva`) VALUES
(1, 333333333, 'OneFuture', '', 54123654, 'onefuture@tec.net', 'Guatemala', '12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallefactura`
--

CREATE TABLE `detallefactura` (
  `correlativo` int(11) NOT NULL,
  `nofactura` bigint(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precioventa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detallefactura`
--

INSERT INTO `detallefactura` (`correlativo`, `nofactura`, `idproducto`, `cantidad`, `precioventa`) VALUES
(1, 4, 1, 1, 18000),
(2, 4, 1, 2, 18000),
(3, 5, 1, 1, 18000),
(4, 6, 1, 1, 18000),
(5, 7, 1, 1, 18000),
(6, 8, 1, 1, 18000),
(7, 9, 1, 1, 18000),
(8, 10, 1, 1, 18000),
(9, 11, 1, 2, 18000),
(10, 12, 1, 1, 18000),
(11, 13, 1, 1, 18000),
(12, 14, 1, 2, 18000),
(13, 15, 1, 1, 15000),
(14, 16, 1, 1, 15000),
(15, 17, 1, 1, 15000),
(16, 17, 2, 2, 70);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalletemp`
--

CREATE TABLE `detalletemp` (
  `correlativo` int(11) NOT NULL,
  `tokenuser` varchar(50) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precioventa` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `nofactura` bigint(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `totalfactura` int(11) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`nofactura`, `fecha`, `usuario`, `idcliente`, `totalfactura`, `estatus`) VALUES
(1, '2020-08-03 14:21:02', 1, 9, 0, 1),
(2, '2020-08-04 07:57:46', 1, 9, 0, 1),
(4, '2020-08-04 10:02:10', 1, 9, 54000, 1),
(5, '2020-08-04 11:00:53', 1, 7, 18000, 2),
(6, '2020-08-04 11:15:57', 1, 8, 18000, 1),
(7, '2020-08-05 19:02:29', 1, 1, 18000, 1),
(8, '2020-08-05 19:22:42', 1, 1, 18000, 1),
(9, '2020-08-05 19:27:21', 1, 8, 18000, 2),
(10, '2020-08-05 19:30:18', 1, 8, 18000, 1),
(11, '2020-08-05 23:28:32', 1, 8, 36000, 1),
(12, '2020-08-05 23:31:10', 1, 8, 18000, 1),
(13, '2020-08-05 23:32:19', 1, 8, 18000, 1),
(14, '2020-08-10 15:53:48', 1, 1, 36000, 1),
(15, '2020-08-25 19:50:21', 1, 1, 15000, 1),
(16, '2020-08-31 11:18:03', 1, 1, 15000, 2),
(17, '2020-09-08 23:39:26', 1, 1, 15140, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idproducto` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `idproveedor` int(11) NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `existencia` int(11) NOT NULL,
  `dateadd` datetime NOT NULL DEFAULT current_timestamp(),
  `idusuario` int(11) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idproducto`, `descripcion`, `idproveedor`, `precio`, `existencia`, `dateadd`, `idusuario`, `estatus`) VALUES
(1, 'Computadora Helios 500', 1, '15000', 49, '2020-07-31 10:21:28', 1, 1),
(2, 'Memoria USB 32GB 3.0', 1, '70', 39, '2020-08-13 12:57:14', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `idproveedor` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `contacto` varchar(45) NOT NULL,
  `telefono` int(11) NOT NULL,
  `direccion` varchar(80) NOT NULL,
  `dateadd` datetime NOT NULL DEFAULT current_timestamp(),
  `idusuario` int(11) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`idproveedor`, `nombre`, `contacto`, `telefono`, `direccion`, `dateadd`, `idusuario`, `estatus`) VALUES
(1, 'Asus', 'asusproduct@gmail.com', 554758456, 'Ciudad Capital', '2020-07-31 10:17:55', 1, 1),
(2, 'Samsung', 'samsung@electronics.com', 54565985, 'Ciudad Capital', '2020-08-12 17:49:28', 1, 1),
(3, 'Kingston', 'kingston@gmail.com', 547848547, 'Ciudad Capital', '2020-08-13 12:56:24', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `rol` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `rol`) VALUES
(1, 'Administrador'),
(2, 'Empleado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `correo` varchar(60) NOT NULL,
  `telefono` int(45) NOT NULL,
  `direccion` varchar(45) NOT NULL,
  `user` varchar(45) NOT NULL,
  `pass` varchar(45) NOT NULL,
  `rol` int(11) NOT NULL,
  `dateadd` datetime NOT NULL DEFAULT current_timestamp(),
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `correo`, `telefono`, `direccion`, `user`, `pass`, `rol`, `dateadd`, `estatus`) VALUES
(1, 'Edvin Pacheco', 'edvinpacheco03@gmail.com', 37031611, 'Esquipulas', 'edvin', '883b79f2889beac4ec9e03a36952f943', 1, '2020-08-13 12:59:55', 1),
(7, 'Obdulio Sanchez', 'obduliosanchez@gmail.com', 54123310, 'Las Vegas 2', 'obdulio', '81dc9bdb52d04dc20036dbd8313ed055', 2, '2020-08-13 12:59:55', 1),
(10, 'Darwin  Sanchez', 'darwin@gmail.com', 66161616, 'Wakanda', 'darwin', '883b79f2889beac4ec9e03a36952f943', 2, '2020-08-13 12:59:55', 1),
(15, 'Pablo Escobar', 'pablo@gmail.com', 7777455, 'medellin', 'pablo', '81dc9bdb52d04dc20036dbd8313ed055', 2, '2020-08-13 12:59:55', 1),
(20, 'Donilson', 'donald@gmail.com', 37031611, 'Esquipulas', 'donald', '81dc9bdb52d04dc20036dbd8313ed055', 2, '2020-08-13 12:59:55', 1),
(22, 'La Maquina Del Tiempo', 'camila@gmail.com', 37031613, 'medellin', 'cami', '81dc9bdb52d04dc20036dbd8313ed055', 2, '2020-08-13 12:59:55', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `button`
--
ALTER TABLE `button`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`),
  ADD KEY `fk_cliente_usuario` (`idusuario`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `fk_detalle_producto` (`idproducto`),
  ADD KEY `fk_detalle_venta` (`nofactura`);

--
-- Indices de la tabla `detalletemp`
--
ALTER TABLE `detalletemp`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `fk_temp_producto` (`idproducto`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`nofactura`),
  ADD KEY `fk_venta_usuario` (`usuario`),
  ADD KEY `fk_venta_cliente` (`idcliente`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idproducto`),
  ADD KEY `fk_producto_proveedor` (`idproveedor`),
  ADD KEY `fk_producto_usuario` (`idusuario`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`idproveedor`),
  ADD KEY `fk_proveedor_usuario` (`idusuario`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `usuario_rol` (`rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `button`
--
ALTER TABLE `button`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `detalletemp`
--
ALTER TABLE `detalletemp`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `nofactura` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `idproveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `fk_cliente_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD CONSTRAINT `fk_detalle_producto` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`),
  ADD CONSTRAINT `fk_detalle_venta` FOREIGN KEY (`nofactura`) REFERENCES `factura` (`nofactura`);

--
-- Filtros para la tabla `detalletemp`
--
ALTER TABLE `detalletemp`
  ADD CONSTRAINT `fk_temp_producto` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `fk_venta_cliente` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`),
  ADD CONSTRAINT `fk_venta_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_proveedor` FOREIGN KEY (`idproveedor`) REFERENCES `proveedor` (`idproveedor`),
  ADD CONSTRAINT `fk_producto_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD CONSTRAINT `fk_proveedor_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_rol` FOREIGN KEY (`rol`) REFERENCES `rol` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
