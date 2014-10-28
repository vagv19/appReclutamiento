select * from entrevistadimension


create or replace view dimensionresultado as
select identrevistadimension,dimension.dimension dimension,resultado.resultado,identrevista
from entrevistadimension
inner join dimension on dimension.iddimension = entrevistadimension.iddimension
inner join resultado on resultado.idresultado = entrevistadimension.idresultado
where entrevistadimension.status = 1
order by identrevista



select identrevistadimension,dimension,resultado from dimensionresultado where identrevista = 3

