-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-07-2024 a las 03:36:43
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
-- Base de datos: `sistema_escolar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anios`
--

CREATE TABLE `anios` (
  `id_anio` int(11) NOT NULL,
  `anio` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `anios`
--

INSERT INTO `anios` (`id_anio`, `anio`) VALUES
(1, '1ro'),
(2, '2do'),
(3, '3ro'),
(4, '4to'),
(5, '5to'),
(25, '6to');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boletin`
--

CREATE TABLE `boletin` (
  `id_boletin` int(11) NOT NULL,
  `id_inscripcion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citaciones`
--

CREATE TABLE `citaciones` (
  `Idcitacion` int(11) NOT NULL,
  `Cedularepresentante` int(11) NOT NULL,
  `Cedulaestudiante` int(11) NOT NULL,
  `Anio` int(11) NOT NULL,
  `Seccion` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `Descripcionmotivo` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citaciones`
--

INSERT INTO `citaciones` (`Idcitacion`, `Cedularepresentante`, `Cedulaestudiante`, `Anio`, `Seccion`, `Fecha`, `Descripcionmotivo`) VALUES
(7, 11111111, 22222222, 1, 1, '2024-06-28', 'dsa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `cedula_estudiante` int(11) NOT NULL,
  `nombres` varchar(45) NOT NULL,
  `fecha_nac` date NOT NULL,
  `direccion` text NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `correo` text DEFAULT NULL,
  `genero` char(2) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`cedula_estudiante`, `nombres`, `fecha_nac`, `direccion`, `telefono`, `correo`, `genero`, `status`) VALUES
(22222222, 'Daniel Parraa', '2002-06-03', 'En el monte', '04247500250', 'parra@masterss.com', 'M', 1),
(23411333, 'DSADA', '2024-06-13', '2313', '2313131', 'asf@gmail.com', 'M', 1),
(29421333, 'Daniel Ulacio', '2024-06-13', 'sada', '041231111111', 'UlacioMaster@gmail.com', 'M', 1),
(30110969, 'Eliana Perez', '2001-01-01', 'sis', '0404-0404040', 'si@gmail.com', 'F', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion`
--

CREATE TABLE `inscripcion` (
  `id_inscripcion` int(11) NOT NULL,
  `estudiantes_cedula_estudiante` int(11) NOT NULL,
  `cedula_representante` int(11) NOT NULL,
  `id_seccion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inscripcion`
--

INSERT INTO `inscripcion` (`id_inscripcion`, `estudiantes_cedula_estudiante`, `cedula_representante`, `id_seccion`) VALUES
(1, 22222222, 11111111, 1),
(10, 30110969, 11111111, 11),
(11, 30110969, 11111111, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id_materia` int(11) NOT NULL,
  `materia` varchar(45) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `id_anio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id_materia`, `materia`, `id_tipo`, `id_anio`) VALUES
(6, 'sadas', 1, 2),
(15, 'Matematica', 1, 2),
(17, 'Oftalmología', 1, 2),
(19, 'sexologia', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

CREATE TABLE `notas` (
  `id_notas` int(11) NOT NULL,
  `1er_lapso` varchar(5) NOT NULL,
  `2do_lapso` varchar(5) NOT NULL,
  `3er_lapso` varchar(5) NOT NULL,
  `nota_final` varchar(5) NOT NULL,
  `boletin_id_boletin` int(11) NOT NULL,
  `id_profesor_materia_seccion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parentezcos`
--

CREATE TABLE `parentezcos` (
  `id_parentezco` int(11) NOT NULL,
  `parentezco` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `parentezcos`
--

INSERT INTO `parentezcos` (`id_parentezco`, `parentezco`) VALUES
(1, 'Mamá'),
(2, 'Papá'),
(3, 'Hermano/a'),
(4, 'Abuelo/a'),
(5, 'Tío/a'),
(6, 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodo_academico`
--

CREATE TABLE `periodo_academico` (
  `id_periodo` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `periodo_academico`
--

INSERT INTO `periodo_academico` (`id_periodo`, `nombre`, `fecha_inicio`, `fecha_fin`, `status`) VALUES
(0, 'FASDD', '2024-06-18', '2024-06-18', 0),
(1, '2024-2027', '2024-09-16', '2025-06-13', 0),
(2, 'DSADA', '2024-06-21', '2024-06-20', 0),
(3, 'Pollo con pan2', '2024-06-06', '2024-06-03', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `cedula_profesor` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `direccion` text NOT NULL,
  `correo` text NOT NULL,
  `genero` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`cedula_profesor`, `nombre`, `telefono`, `direccion`, `correo`, `genero`) VALUES
(24141333, 'Pocoyo Rivera', '041234141654', '', 'FSAUAH@GMAIL.COM', 'F'),
(29542512, 'FDASFADS', '041234521323', '', 'asdfa@gmail.com', 'M'),
(29545423, 'Angelo Isaac Toscano', '04247500258', 'no tiene casa', 'aga@gmail.com', 'M'),
(29699505, 'Jhosmar Suarez', '04247420767', 'sizarra ieja', 'a@gmail.com', 'F');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores_materias`
--

CREATE TABLE `profesores_materias` (
  `id_profesor_materia` int(11) NOT NULL,
  `profesores_cedula_profesor` int(11) NOT NULL,
  `materias_id_materia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesores_materias`
--

INSERT INTO `profesores_materias` (`id_profesor_materia`, `profesores_cedula_profesor`, `materias_id_materia`) VALUES
(1, 29699505, 6),
(2, 29545423, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor_materias_seccion`
--

CREATE TABLE `profesor_materias_seccion` (
  `id_profesor_materia_seccion` int(11) NOT NULL,
  `id_seccion_profesor_periodo` int(11) NOT NULL,
  `id_profesor_materia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesor_materias_seccion`
--

INSERT INTO `profesor_materias_seccion` (`id_profesor_materia_seccion`, `id_seccion_profesor_periodo`, `id_profesor_materia`) VALUES
(1, 11, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `representante_legal`
--

CREATE TABLE `representante_legal` (
  `cedula_representante_legal` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `correo` text DEFAULT NULL,
  `direccion` text NOT NULL,
  `fecha_nac` date DEFAULT NULL,
  `sexo` char(2) NOT NULL,
  `id_parentezco` int(11) NOT NULL,
  `profesion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `representante_legal`
--

INSERT INTO `representante_legal` (`cedula_representante_legal`, `nombre`, `telefono`, `correo`, `direccion`, `fecha_nac`, `sexo`, `id_parentezco`, `profesion`) VALUES
(11111111, 'Papa de Parra3', '11111111', 'papadeparra2@eloriginal.com', 'en el mismo monte que parraofcoruse', '1985-06-10', 'M', 2, 'No hay profesión como ser papasda');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `rol` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `rol`) VALUES
(1, 'Profesor'),
(2, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seccion`
--

CREATE TABLE `seccion` (
  `id_seccion` int(11) NOT NULL,
  `letra` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seccion`
--

INSERT INTO `seccion` (`id_seccion`, `letra`) VALUES
(1, 'U'),
(2, 'A'),
(3, 'B'),
(4, 'C'),
(5, 'D'),
(6, 'E');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seccion_profesor_periodo`
--

CREATE TABLE `seccion_profesor_periodo` (
  `id_seccion_profesor_periodo` int(11) NOT NULL,
  `id_año` int(11) NOT NULL,
  `id_seccion` int(11) NOT NULL,
  `cedula_tutor` int(11) NOT NULL,
  `id_periodo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seccion_profesor_periodo`
--

INSERT INTO `seccion_profesor_periodo` (`id_seccion_profesor_periodo`, `id_año`, `id_seccion`, `cedula_tutor`, `id_periodo`) VALUES
(1, 1, 2, 29545423, 3),
(11, 2, 1, 29699505, 0),
(12, 3, 1, 24141333, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_materia`
--

CREATE TABLE `tipo_materia` (
  `id_tipo` int(11) NOT NULL,
  `tipo` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_materia`
--

INSERT INTO `tipo_materia` (`id_tipo`, `tipo`) VALUES
(1, 'Cuantitativa'),
(2, 'Cualitativa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `password` varchar(65) NOT NULL,
  `status` char(2) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `cedula_profesor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `usuario`, `password`, `status`, `id_rol`, `cedula_profesor`) VALUES
(0, 'Elibook', '3d2172418ce305c7d16d4b05597c6a59', '1', 1, 30110969),
(1, 'Aga222', '$2y$10$0yCDCMoInSgsgh1MojTcCOVB.8zdfYd9bqYKy0XxyfHreQkk32LCm', '1', 1, 29545423),
(13, 'edwe', 'e10adc3949ba59abbe56e057f20f883e', '1', 1, 29699505);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anios`
--
ALTER TABLE `anios`
  ADD PRIMARY KEY (`id_anio`);

--
-- Indices de la tabla `boletin`
--
ALTER TABLE `boletin`
  ADD PRIMARY KEY (`id_boletin`),
  ADD KEY `fk_boletin_inscripcion1_idx` (`id_inscripcion`);

--
-- Indices de la tabla `citaciones`
--
ALTER TABLE `citaciones`
  ADD PRIMARY KEY (`Idcitacion`),
  ADD KEY `Cedulaestudiante` (`Cedulaestudiante`),
  ADD KEY `Cedularepresentante` (`Cedularepresentante`),
  ADD KEY `citaciones_ibfk_3` (`Anio`),
  ADD KEY `Seccion` (`Seccion`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`cedula_estudiante`);

--
-- Indices de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD PRIMARY KEY (`id_inscripcion`),
  ADD KEY `fk_inscripcion_estudiantes1_idx` (`estudiantes_cedula_estudiante`),
  ADD KEY `fk_inscripcion_representante_legal1_idx` (`cedula_representante`),
  ADD KEY `inscripcion_ibfk_2` (`id_seccion`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id_materia`),
  ADD KEY `fk_materias_tipo_tabla1_idx` (`id_tipo`),
  ADD KEY `id_año` (`id_anio`);

--
-- Indices de la tabla `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`id_notas`) USING BTREE;

--
-- Indices de la tabla `parentezcos`
--
ALTER TABLE `parentezcos`
  ADD PRIMARY KEY (`id_parentezco`);

--
-- Indices de la tabla `periodo_academico`
--
ALTER TABLE `periodo_academico`
  ADD PRIMARY KEY (`id_periodo`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`cedula_profesor`);

--
-- Indices de la tabla `profesores_materias`
--
ALTER TABLE `profesores_materias`
  ADD PRIMARY KEY (`id_profesor_materia`),
  ADD KEY `fk_profesores_has_materias_materias1_idx` (`materias_id_materia`),
  ADD KEY `fk_profesores_has_materias_profesores1_idx` (`profesores_cedula_profesor`);

--
-- Indices de la tabla `profesor_materias_seccion`
--
ALTER TABLE `profesor_materias_seccion`
  ADD PRIMARY KEY (`id_profesor_materia_seccion`),
  ADD KEY `fk_materias_has_seccion_seccion1_idx` (`id_seccion_profesor_periodo`),
  ADD KEY `fk_materias/seccion_profesores/materias1_idx` (`id_profesor_materia`);

--
-- Indices de la tabla `representante_legal`
--
ALTER TABLE `representante_legal`
  ADD PRIMARY KEY (`cedula_representante_legal`),
  ADD KEY `fk_representante_legal_parentezcos1_idx` (`id_parentezco`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `seccion`
--
ALTER TABLE `seccion`
  ADD PRIMARY KEY (`id_seccion`);

--
-- Indices de la tabla `seccion_profesor_periodo`
--
ALTER TABLE `seccion_profesor_periodo`
  ADD PRIMARY KEY (`id_seccion_profesor_periodo`),
  ADD KEY `fk_seccion_años1_idx` (`id_año`),
  ADD KEY `fk_seccion_profesores1_idx` (`cedula_tutor`),
  ADD KEY `fk_seccion_periodo_academico1_idx` (`id_periodo`),
  ADD KEY `id_seccion` (`id_seccion`);

--
-- Indices de la tabla `tipo_materia`
--
ALTER TABLE `tipo_materia`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `usuario_UNIQUE` (`usuario`),
  ADD KEY `fk_usuarios_roles_idx` (`id_rol`),
  ADD KEY `fk_usuarios_profesores1_idx` (`cedula_profesor`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `anios`
--
ALTER TABLE `anios`
  MODIFY `id_anio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `citaciones`
--
ALTER TABLE `citaciones`
  MODIFY `Idcitacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  MODIFY `id_inscripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id_materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `notas`
--
ALTER TABLE `notas`
  MODIFY `id_notas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `profesores_materias`
--
ALTER TABLE `profesores_materias`
  MODIFY `id_profesor_materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `profesor_materias_seccion`
--
ALTER TABLE `profesor_materias_seccion`
  MODIFY `id_profesor_materia_seccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `seccion`
--
ALTER TABLE `seccion`
  MODIFY `id_seccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `seccion_profesor_periodo`
--
ALTER TABLE `seccion_profesor_periodo`
  MODIFY `id_seccion_profesor_periodo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citaciones`
--
ALTER TABLE `citaciones`
  ADD CONSTRAINT `citaciones_ibfk_1` FOREIGN KEY (`Cedulaestudiante`) REFERENCES `estudiantes` (`cedula_estudiante`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `citaciones_ibfk_2` FOREIGN KEY (`Cedularepresentante`) REFERENCES `representante_legal` (`cedula_representante_legal`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `citaciones_ibfk_3` FOREIGN KEY (`Anio`) REFERENCES `anios` (`id_anio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `citaciones_ibfk_4` FOREIGN KEY (`Seccion`) REFERENCES `seccion` (`id_seccion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD CONSTRAINT `fk_inscripcion_representante_legal1` FOREIGN KEY (`cedula_representante`) REFERENCES `representante_legal` (`cedula_representante_legal`) ON DELETE CASCADE,
  ADD CONSTRAINT `inscripcion_ibfk_1` FOREIGN KEY (`estudiantes_cedula_estudiante`) REFERENCES `estudiantes` (`cedula_estudiante`) ON UPDATE CASCADE,
  ADD CONSTRAINT `inscripcion_ibfk_2` FOREIGN KEY (`id_seccion`) REFERENCES `seccion_profesor_periodo` (`id_seccion_profesor_periodo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `materias`
--
ALTER TABLE `materias`
  ADD CONSTRAINT `materias_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_materia` (`id_tipo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `materias_ibfk_2` FOREIGN KEY (`id_anio`) REFERENCES `anios` (`id_anio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `profesores_materias`
--
ALTER TABLE `profesores_materias`
  ADD CONSTRAINT `fk_profesores_has_materias_materias1` FOREIGN KEY (`materias_id_materia`) REFERENCES `materias` (`id_materia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_profesores_has_materias_profesores1` FOREIGN KEY (`profesores_cedula_profesor`) REFERENCES `profesores` (`cedula_profesor`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `profesor_materias_seccion`
--
ALTER TABLE `profesor_materias_seccion`
  ADD CONSTRAINT `profesor_materias_seccion_ibfk_1` FOREIGN KEY (`id_seccion_profesor_periodo`) REFERENCES `seccion_profesor_periodo` (`id_seccion_profesor_periodo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `profesor_materias_seccion_ibfk_2` FOREIGN KEY (`id_profesor_materia`) REFERENCES `profesores_materias` (`id_profesor_materia`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `representante_legal`
--
ALTER TABLE `representante_legal`
  ADD CONSTRAINT `fk_representante_legal_parentezcos1` FOREIGN KEY (`id_parentezco`) REFERENCES `parentezcos` (`id_parentezco`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `seccion_profesor_periodo`
--
ALTER TABLE `seccion_profesor_periodo`
  ADD CONSTRAINT `fk_seccion_años1` FOREIGN KEY (`id_año`) REFERENCES `anios` (`id_anio`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_seccion_periodo_academico1` FOREIGN KEY (`id_periodo`) REFERENCES `periodo_academico` (`id_periodo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_seccion_profesores1` FOREIGN KEY (`cedula_tutor`) REFERENCES `profesores` (`cedula_profesor`) ON UPDATE CASCADE,
  ADD CONSTRAINT `seccion_profesor_periodo_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
