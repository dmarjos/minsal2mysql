DROP VIEW IF EXISTS `casos_caba`;
CREATE VIEW `casos_caba` as select * from `casos_covid` where provincia_residencia = 'CABA';

DROP VIEW IF EXISTS `casos_conurbano`;
CREATE VIEW `casos_conurbano` as select * from `casos_covid` where provincia_residencia = 'Buenos Aires' and id_departamento_residencia IN (28,35,91,98,119,126,134,245,252,260,266,270,274,329,365,371,408,410,412,427,434,441,490,497,525,515,539,560,568,638,548,658,749,756,760,778,805,840,861,882);

DROP VIEW IF EXISTS `casos_interior_pbs`;
CREATE VIEW `casos_interior_pbs` as select * from `casos_covid` where provincia_residencia = 'Buenos Aires' and id_departamento_residencia NOT IN (28,35,91,98,119,126,134,245,252,260,266,270,274,329,365,371,408,410,412,427,434,441,490,497,525,515,539,560,568,638,548,658,749,756,760,778,805,840,861,882);

