CREATE TABLE mensaje
(
  idmensaje integer NOT NULL,
  mensaje text,
  idempleadoenvia integer,
  idempleadorecibe integer,
  status integer NOT NULL DEFAULT 1,
  CONSTRAINT pkidmensaje PRIMARY KEY (idmensaje ),
  CONSTRAINT fkidempleadoenvia FOREIGN KEY (idempleadoenvia)
      REFERENCES empleado (idempleado) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fkidempleadorecibe FOREIGN KEY (idempleadorecibe)
      REFERENCES empleado (idempleado) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);
ALTER TABLE mensaje
  OWNER TO postgres;


create view viewvermensaje as
select idmensaje,idempleadoenvia,empleado.nombre,mensaje,mensaje.status
from mensaje 
inner join empleado on empleado.idempleado = idempleadoenvia