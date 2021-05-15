<?php 
ini_set('memory_limit','8G');
/**
 *------------------------------------------------------------------------------------------------------------------------------------
 * Leer el dataset obtenido desde la página del Ministerio de Salud de la Nación
 * http://datos.salud.gob.ar/dataset/covid-19-casos-registrados-en-la-republica-argentina/archivo/fd657d02-a33a-498b-a91b-2ef1a68b8d16
 *------------------------------------------------------------------------------------------------------------------------------------
 */
$datos=file('./Covid19Casos.csv');

/**
 *------------------------------------------------------------------------------------------------------------------------------------
 * Crear script SQL
 *------------------------------------------------------------------------------------------------------------------------------------
 */
$fp = fopen('covid19casos.sql', 'w');

/**
 *------------------------------------------------------------------------------------------------------------------------------------
 * Borrar tabla de base de datos y crear nueva tabla con la estructura provista por la página del Ministerio de Salud de la Nacion
 * http://datos.salud.gob.ar/dataset/covid-19-casos-registrados-en-la-republica-argentina/archivo/fd657d02-a33a-498b-a91b-2ef1a68b8d16
 *------------------------------------------------------------------------------------------------------------------------------------
 */
 
fwrite($fp,"DROP TABLE IF EXISTS `casos_covid`;".PHP_EOL);
fwrite($fp,"CREATE TABLE IF NOT EXISTS `casos_covid` (".PHP_EOL);
fwrite($fp,"  `id_caso` int(11) DEFAULT NULL,".PHP_EOL);
fwrite($fp,"  `sexo` varchar(1) DEFAULT NULL,".PHP_EOL);
fwrite($fp,"  `edad` int(11) DEFAULT NULL,".PHP_EOL);
fwrite($fp,"  `tipo_edad` enum('Años','Meses') DEFAULT NULL,".PHP_EOL);
fwrite($fp,"  `pais_residencia` varchar(255) DEFAULT NULL,".PHP_EOL);
fwrite($fp,"  `provincia_residencia` varchar(255) DEFAULT NULL,".PHP_EOL);
fwrite($fp,"  `departamento_residencia` varchar(255) DEFAULT NULL,".PHP_EOL);
fwrite($fp,"  `provincia_carga` varchar(255) DEFAULT NULL,".PHP_EOL);
fwrite($fp,"  `fecha_inicio_sintomas` date DEFAULT NULL,".PHP_EOL);
fwrite($fp,"  `fecha_apertura` date DEFAULT NULL,".PHP_EOL);
fwrite($fp,"  `apertura_semana_epidemiologica` date DEFAULT NULL,".PHP_EOL);
fwrite($fp,"  `fecha_internacion` date DEFAULT NULL,".PHP_EOL);
fwrite($fp,"  `cuidado_intensivo` enum('SI','No') DEFAULT NULL,".PHP_EOL);
fwrite($fp,"  `fecha_uti` date DEFAULT NULL,".PHP_EOL);
fwrite($fp,"  `fallecido` enum('Si','No') DEFAULT NULL,".PHP_EOL);
fwrite($fp,"  `fecha_fallecimiento` date DEFAULT NULL,".PHP_EOL);
fwrite($fp,"  `asistencia_respiratoria` enum('Si','No','') DEFAULT NULL,".PHP_EOL);
fwrite($fp,"  `id_provincia_carga` int(11) DEFAULT NULL,".PHP_EOL);
fwrite($fp,"  `origen_financiamiento` enum('Público','Privado','') DEFAULT NULL,".PHP_EOL);
fwrite($fp,"  `clasificacion` varchar(255) DEFAULT NULL,".PHP_EOL);
fwrite($fp,"  `clasificacion_resumen` varchar(255) DEFAULT NULL,".PHP_EOL);
fwrite($fp,"  `id_provincia_residencia` int(11) DEFAULT NULL,".PHP_EOL);
fwrite($fp,"  `fecha_diagnostico` date DEFAULT NULL,".PHP_EOL);
fwrite($fp,"  `id_departamento_residencia` int(11) DEFAULT NULL,".PHP_EOL);
fwrite($fp,"  `ultima_actualizacion` date DEFAULT NULL".PHP_EOL);
fwrite($fp,") ENGINE=MyISAM DEFAULT CHARSET=latin1;".PHP_EOL);

/**
 *------------------------------------------------------------------------------------------------------------------------------------
 * Recorrer dataset obtenido en la página del MINSAL, y grabar sentencia SQL INSERT para ingresar los datos en la tabla casos_covid
 * http://datos.salud.gob.ar/dataset/covid-19-casos-registrados-en-la-republica-argentina/archivo/fd657d02-a33a-498b-a91b-2ef1a68b8d16
 *------------------------------------------------------------------------------------------------------------------------------------
 */
foreach($datos as $idx=>$registro) {
	if($idx==0) continue;
	$row=trim(str_replace("'","\'",$registro));
	$row=trim(str_replace('"',"'",$row));
	while(strpos($row,",,")!==false) {
		$row=str_replace(",,",",'',",$row);
	}
	fwrite($fp,"INSERT INTO `casos_covid` VALUES(".$row.");".PHP_EOL);
	//if ($idx>10) break;
}
fclose($fp);
