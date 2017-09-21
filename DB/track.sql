-- 07/09/2017
ALTER TABLE catalogo.curso ADD clave_division varchar;
UPDATE catalogo.curso SET  clave_division = 'DPE' WHERE id_tipo_curso < 15;
ALTER TABLE catalogo.curso ALTER COLUMN clave_division SET NOT NULL ;
ALTER TABLE catalogo.tipo_actividad DROP COLUMN clave_division ;

CREATE SEQUENCE catalogo.id_modalidad_seq;
CREATE TABLE catalogo.modalidad (
	id_modalidad integer NOT NULL,
	clave_modalidad character varying NOT NULL,
	nombre_modalidad character varying NOT NULL,
	descripcion text,
	id_tipo_actividad integer NOT NULL,
	PRIMARY KEY(id_modalidad),
	FOREIGN KEY(id_tipo_actividad) REFERENCES catalogo.tipo_actividad(id_tipo_actividad)
);

ALTER TABLE catalogo.curso ADD FOREIGN KEY(clave_division) REFERENCES catalogo.division(clave_division);

ALTER TABLE catalogo.modalidad ALTER id_modalidad SET DEFAULT nextval('catalogo.id_modalidad_seq');

ALTER TABLE catalogo.area_enfoque DROP COLUMN id_tipo_actividad;
ALTER TABLE catalogo.area_enfoque ADD id_modalidad integer;
ALTER TABLE catalogo.area_enfoque ADD FOREIGN KEY(id_modalidad) REFERENCES catalogo.modalidad(id_modalidad);

--08/09/2017
ALTER TABLE catalogo.curso ADD clave_principal varchar;


-- 11 septiembre 2017 activar oficinas centrales y mando
update catalogo.delegaciones set activo = true;

-- 11 septiembre 2017 campo para registrar que unidad realizo un registro, los nulos fueron cargados en precarga
alter table ods.registro_docente add column id_unidad_instituto int;

-- 11 septiembre 2017 carga de catalogos de tipos de unidades, unidades y departamentos
insert into sistema.roles(nombre, orden) values ('N1', 3);


insert into catalogo.tipos_unidades(
id_tipo_unidad,
nombre,
descripcion,
activa,
nivel,
grupo_tipo,
grupo_nombre
) select  id_tipo_unidad,
nombre,
descripcion,
activa,
nivel,
grupo_tipo,
grupo_nombre
from 
dblink('dbname=tablero host=192.168.10.19 user=innovaedu password=nPgEoXCqd/?gV.,',
'select * from catalogos.tipos_unidades') as tipos(
id_tipo_unidad int,
nombre varchar,
descripcion text,
activa boolean,
nivel int,
grupo_tipo varchar,
grupo_nombre varchar
);

insert into catalogo.unidades_instituto (
id_unidad_instituto,
clave_unidad, 
nombre, 
id_delegacion, 
clave_presupuestal, 
fecha, 
nivel_atencion, 
id_tipo_unidad, 
umae, 
activa, 
latitud, 
longitud, 
id_region, 
grupo_tipo_unidad, 
grupo_delegacion, 
direccion_fisica, 
entidad_federativa, 
anio, 
unidad_principal, 
nombre_unidad_principal
) (select 
id_, 
clave_unidad, 
nombre, 
id_delegacion, 
clave_presupuestal, 
fecha, 
nivel_atencion, 
id_tipo_unidad, 
umae, 
activa, 
latitud, 
longitud, 
id_region, 
grupo_tipo_unidad, 
grupo_delegacion, 
direccion_fisica, 
entidad_federativa, 
anio, 
unidad_principal, 
nombre_unidad_principal 
from 
dblink('dbname=tablero host=192.168.10.19 user=innovaedu password=nPgEoXCqd/?gV.,', 
'select * from catalogos.unidades_instituto order by id_unidad_instituto') 
as unidades(
id_ int, 
clave_unidad varchar, 
nombre varchar, 
id_delegacion int, 
clave_presupuestal varchar, 
fecha timestamp,
nivel_atencion int, 
id_tipo_unidad int, 
umae boolean, 
activa boolean, 
latitud float, 
longitud float, 
id_region int, 
grupo_tipo_unidad varchar, 
grupo_delegacion varchar, 
direccion_fisica text, 
entidad_federativa varchar, 
anio int, 
unidad_principal varchar, 
nombre_unidad_principal varchar
));


insert into catalogo.departamentos_instituto(
id_departamento_instituto,
nombre,
clave_departamental,
id_unidad_instituto,
activa) select 
id_departamento_instituto,
nombre,
clave_departamental,
id_unidad_instituto,
activa
from 
dblink('dbname=tablero host=192.168.10.19 user=innovaedu password=nPgEoXCqd/?gV.,',
'select * from catalogos.departamentos_instituto') as departamentos(
id_departamento_instituto int,
nombre varchar,
clave_departamental varchar,
id_unidad_instituto int,
activa boolean 
);

insert into catalogo.subcategorias(
id_subcategoria,
nombre,
fecha,
activa,
"order" ) select  id_subcategoria,
nombre,
fecha,
activa,
orden 
from 
dblink('dbname=tablero host=192.168.10.19 user=innovaedu password=nPgEoXCqd/?gV.,',
'Select * from catalogos.subcategorias') as subc(
id_subcategoria int,
nombre varchar,
fecha timestamp,
activa boolean,
orden numeric
);


insert into catalogo.grupos_categorias(
id_grupo_categoria,
nombre,
descripcion,
clave,
id_subcategoria,
activa,
"order"
) select id_grupo_categoria,
nombre,
descripcion,
clave,
id_subcategoria,
activa,
orden
from 
dblink('dbname=tablero host=192.168.10.19 user=innovaedu password=nPgEoXCqd/?gV.,',
'select * from catalogos.grupos_categorias') as gcat(
id_grupo_categoria int,
nombre varchar,
descripcion text,
clave varchar,
id_subcategoria int, 
activa boolean,
orden numeric
);

insert into catalogo.categorias(
id_categoria,
nombre,
id_grupo_categoria,
categoria_por_perfil,
clave_categoria,
fecha,
subcategoria,
activa,
id_subcategoria
) select id_categoria,
nombre,
id_grupo_categoria,
categoria_por_perfil,
clave_categoria,
fecha,
subcategoria,
activa,
id_subcategoria
from 
dblink('dbname=tablero host=192.168.10.19 user=innovaedu password=nPgEoXCqd/?gV.,',
'select * from catalogos.categorias') as categorias(
id_categoria int,
nombre varchar,
id_grupo_categoria int,
categoria_por_perfil varchar,
clave_categoria varchar,
fecha timestamp,
subcategoria varchar,
activa boolean ,
id_subcategoria int,
directivo_umae boolean 
);

-- 11/09/2017
ALTER TABLE catalogo.tipo_curso ALTER COLUMN clave SET NOT NULL ;
ALTER TABLE catalogo.tipo_curso ADD UNIQUE (clave);
ALTER TABLE catalogo.curso ADD UNIQUE (clave_curso);
ALTER TABLE catalogo.curso ALTER COLUMN id_tipo_curso SET NOT NULL ;
