# minsal2mysql
Conversión de los datasets del Ministerio de Salud de la Nacion respecto a COVID-19, a formato MySQL

Instrucciones

Descargar el dataset desde la URL del Ministerio de Salud de la Nacion:
http://datos.salud.gob.ar/dataset/covid-19-casos-registrados-en-la-republica-argentina/archivo/fd657d02-a33a-498b-a91b-2ef1a68b8d16

El archivo a descargar tiene el nombre covdi19casos.zip
Descomprimir el archivo en una carpeta, lo cual genera un archivo llamado covid19casos.csv

Este archivo contiene toda la informacion obrante en poder del Ministerio de Salud de la Nacion, acerca de casos sospechosos, confirmados positivos-negativos o descartados, desde el comienzo de la pandemia.

Ejecutar el script import_covid.php. Esta es una herramienta que genera una tabla de MySQL para permitir realizar consultas en SQL y genera el archivo covid19casos.sql, el cual debe ser importado dentro de una base de datos MySQL

Ejecutar el script create_views.sql. Ëste script permite generar las vistas de acceso rapido (CABA. conurbano e interior PBA) para las queries. Debe ejecutarse unicamente DESPUES de haber importando el archivo covid19casos.sql

Una vez importados los archivos, solo es necesario hacer las consultas SQL que se requieran.

Ejemplos:

(SELECT 'Total casos Positivos / Sospechosos Buenos Aires' as descripcion,count(id_caso) as cantidad FROM `casos_covid` where `provincia_carga`='Buenos Aires' and `clasificacion`<>'Caso Descartado')
UNION
(SELECT 'Total casos Positivos / Sospechosos CABA' as descripcion,count(id_caso) as cantidad FROM `casos_covid` where `provincia_carga`='CABA' and `clasificacion`<>'Caso Descartado')
UNION
(SELECT 'Residencia en Provincia, Carga en CABA' as descripcion,count(id_caso) as cantidad FROM `casos_covid` where `provincia_residencia`='Buenos Aires' and provincia_carga='CABA' and `clasificacion`<>'Caso Descartado')
UNION
(SELECT 'Residencia en CABA, Carga en Provincia' as descripcion,count(id_caso) as cantidad FROM `casos_covid` where `provincia_residencia`='CABA' and provincia_carga='Buenos Aires' and `clasificacion`<>'Caso Descartado')
UNION
(SELECT 'Residencia en Provincia, Carga en CABA, en UTI' as descripcion,count(id_caso) as cantidad FROM `casos_covid` where `provincia_residencia`='Buenos Aires' and provincia_carga='CABA' and `clasificacion`<>'Caso Descartado' and `cuidado_intensivo`='SI')
UNION
(SELECT 'Residencia en CABA, Carga en Provincia, en UTI' as descripcion,count(id_caso) as cantidad FROM `casos_covid` where `provincia_residencia`='CABA' and provincia_carga='Buenos Aires' and `clasificacion`<>'Caso Descartado' and `cuidado_intensivo`='SI')
UNION
(SELECT 'Residencia en Provincia, Carga en CABA, Fallecido' as descripcion,count(id_caso) as cantidad FROM `casos_covid` where `provincia_residencia`='Buenos Aires' and provincia_carga='CABA' and `clasificacion`<>'Caso Descartado' and `fallecido`='SI')
UNION
(SELECT 'Residencia en CABA, Carga en Provincia, Fallecido' as descripcion,count(id_caso) as cantidad FROM `casos_covid` where `provincia_residencia`='CABA' and provincia_carga='Buenos Aires' and `clasificacion`<>'Caso Descartado' and `fallecido`='SI')
;

---------------

SELECT fecha_fallecimiento, count(id_caso) as cantidad FROM `casos_caba` where fallecido='SI' and fecha_fallecimiento>='2021-04-16' group by fecha_fallecimiento;
-----
SELECT fecha_fallecimiento, count(id_caso) as cantidad FROM `casos_conurbano` where fallecido='SI' and fecha_fallecimiento>='2021-04-16' group by fecha_fallecimiento;
-----
SELECT fecha_uti, count(id_caso) as cantidad FROM `casos_caba` where cuidado_intensivo='SI' and fecha_uti>='2021-04-16' group by fecha_uti;
-----
SELECT fecha_uti, count(id_caso) as cantidad FROM `casos_conurbano` where cuidado_intensivo='SI' and fecha_uti>='2021-04-16' group by fecha_uti;
-----
