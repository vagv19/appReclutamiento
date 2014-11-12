<?php
  include_once "Conexion.class.php";
  session_start();
  extract($_POST);
  $_Conexion = new Conexion();
  $_Conexion->Conectar("BPracticas");

  switch ($fn) {
    #Consultas de filtrado
    #Filtrado de encargados
    case 1:
      $_Query = "SELECT encargado.idencargado AS value, encargado.nombre AS label, encargado.extension AS ext, encargado.correo AS correo,
          departamento.iddepartamento AS iddepartamento, departamento.descripcion AS dpto, 
          solicitudpractica.responsable AS responsable, solicitudpractica.direccion AS direccion
        FROM encargado
        INNER JOIN departamento ON encargado.iddepartamento = departamento.iddepartamento
        INNER JOIN solicitudpractica ON solicitudpractica.idencargado = encargado.idencargado
        WHERE UPPER(encargado.nombre) LIKE UPPER('%$name%') 
        ORDER BY label";
      echo $_Conexion->returnJSON($_Query);
      break;
    case 2:
      $_Query = "SELECT iddepartamento AS value, departamento.descripcion AS label, unidadorganizativa.descripcion AS unidad
        FROM departamento
        INNER JOIN unidadorganizativa ON unidadorganizativa.idunidadorganizativa = departamento.idunidadorganizativa
        WHERE UPPER(departamento.descripcion) LIKE UPPER('%$name%') AND iddepartamento > 0 
        ORDER BY label";
      echo $_Conexion->returnJSON($_Query);
      break;
    case 3:
      $_Query = "SELECT idsolicitudpractica AS value, direccion AS label
        FROM solicitudpractica
        WHERE UPPER(direccion) LIKE UPPER('%$name%') 
        ORDER BY label";
      echo $_Conexion->returnJSON($_Query);
      break;
    case 4:
      $_Query = "SELECT idsolicitudpractica AS value, responsable AS label
        FROM solicitudpractica
        WHERE UPPER(responsable) LIKE UPPER('%$name%') 
        ORDER BY label";
      echo $_Conexion->returnJSON($_Query);
      break;

    #Genera la tabla con los candidatos disponibles
    case 10:
      $_Query = "SELECT candidato.nombre||' '||candidato.apellidopaterno||' '||candidato.apellidomaterno AS nombre,
                  candidato.direccion||', '||colonia.descripcion||', '||ciudad.descripcion||', '||estado.descripcion AS direccion,
                  candidato.email, 
                  candidato.telefono, 
                  candidato.celular,
                  institucion.descripcion,
                  carrera.descripcion,
                  estudio.grado||'° '||cicloescolar.descripcion AS grado,
                  estudio.promedio,
                  candidato.folio,
                  estadocivil.descripcion,
                  DATE_PART('year', now()) - DATE_PART('year', candidato.\"fechaNacimiento\") AS edad,
                  candidato.idcandidato
                FROM candidato
                INNER JOIN colonia ON colonia.idcolonia = candidato.idcolonia
                INNER JOIN ciudad ON ciudad.idciudad = colonia.idciudad
                INNER JOIN estado ON estado.idestado = ciudad.idestado
                INNER JOIN estudio ON estudio.idcandidato = candidato.idcandidato
                INNER JOIN carrera ON carrera.idcarrera = estudio.idcarrera
                INNER JOIN institucion ON institucion.idinstitucion = estudio.idinstitucion
                INNER JOIN cicloescolar ON cicloescolar.idcicloescolar = estudio.idcicloescolar
                INNER JOIN estadocivil ON estadocivil.idestadocivil = candidato.estadocivil
                WHERE candidato.idclasificacion = 22
                ORDER BY candidato.\"fechaAlta\", nombre DESC, estudio.fechainicio DESC";
      $_ResultSet = $_Conexion->returnRS($_Query);
      if (!is_null($_ResultSet)) {
        echo '<table class="table table-hover"><thead><tr><th>Imagen</th><th>Datos Personales</th><th>Datos Escolares</th></tr></thead><tbody>';
        $_idCandidato = 0;
        while ($_Row = $_ResultSet->FetchRow()) {
          if ($_idCandidato == $_Row[12]) {
            continue;
          }
          $_idCandidato = $_Row[12];
          $folio = explode('-', $_Row[9]);
          echo '
<tr>
  <td style="min-width:100px;">
    <img height="126px" width="100%" src="http://132.132.14.224/Contrataciones/Consultas_Rec/Expedientes_Reclu/fotos/'.$folio[1].'.jpg"/>
    <div class="text-center"><b>'.$_Row[10].'(a)</b></div>
    <div class="text-center"><b>'.$_Row[11].' años</b></div>
  </td>
  <td style="min-width:535px">
    <div class="form-horizontal">
      <div class="form-group">
        <div class="control-label col-sm-2"><b>Nombre:</b></div>
        <div class="form-control-static col-sm-10">'.$_Row[0].'</div>
      </div>
      <div class="form-group">
        <div class="control-label col-sm-2"><b>Direccion:</b></div>
        <div class="form-control-static col-sm-10">'.$_Row[1].'</div>
      </div>
      <div class="form-group">
        <div class="control-label col-sm-2"><b>Email:</b></div>
        <div class="form-control-static col-sm-10">'.$_Row[2].'</div>
      </div>
      <div class="form-group">
        <div class="control-label col-sm-2"><b>Telefono:</b></div>
        <div class="form-control-static col-sm-4">'.$_Row[3].'</div>
        <div class="control-label col-sm-2"><b>Celular:</b></div>
        <div class="form-control-static col-sm-4">'.$_Row[4].'</div>
      </div>
    </div>  
  </td>
  <td style="min-width:535px">
    <div class="form-horizontal">
      <div class="form-group">
        <div class="control-label col-sm-2"><b>Escuela:</b></div>
        <div class="form-control-static col-sm-10">'.$_Row[5].'</div>
      </div>
      <div class="form-group">
        <div class="control-label col-sm-2"><b>Carrera:</b></div>
        <div class="form-control-static col-sm-10">'.$_Row[6].'</div>
      </div>
      <div class="form-group">
        <div class="control-label col-sm-2"><b>Grado:</b></div>
        <div class="form-control-static col-sm-10">'.$_Row[7].'</div>
      </div>
      <div class="form-group">
        <div class="control-label col-sm-2"><b>Promedio:</b></div>
        <div class="form-control-static col-sm-6">'.$_Row[8].' <a href="http://132.132.14.224/Contrataciones/Consultas_Rec/Expedientes_Reclu/expedientes/'.$folio[1].'/'.$folio[1].'-kardex.pdf"><b>Ver Kardex</b></a></div>
        <div class="control-label col-sm-4"><button data-id="'.$_Row[12].'" data-name="'.$_Row[0].'" name="btnSolicitar" class="btn btn-success">Solicitar</button></div>
      </div>
    </div>  
  </td>
</tr>';
        }
        echo '</tbody></table>';
      }
      break;

    #Ingresa la nueva solicitud
    case 20:
      /*if ($iddepartamento = 0) {
        #Ingresar nuevo departamento y actualizar iddepartamento
        $_Query = "INSERT INTO departamento (iddepartamento, descripcion, idunidadorganizativa, status) 
                  VALUES ((SELECT COALESCE(MAX(iddepartamento) + 1, 1) FROM departamento), '$txtDepartamento', 0, 1)";
        echo $_Conexion->consultaAccion($_Query);
        $_Query = "SELECT MAX(iddepartamento) FROM departamento";
        $_ResultSet = $_Conexion->returnRS($_Query);
        if (!is_null($_ResultSet)) {
          $_Row = $_ResultSet->FetchRow();
          $iddepartamento = $_Row[0];
        }
      }*/
      if ($idEncargado == "0") {
        $_Query = "INSERT INTO encargado (idencargado, nombre, extension, correo, iddepartamento, status) 
                  VALUES ((SELECT COALESCE(MAX(idencargado) + 1, 1) FROM encargado), '$txtSolicitante', '$txtExt', '$txtEmail', '$idDepartamento', 1)";
        $_Conexion->consultaAccion($_Query);
        $_Query = "SELECT MAX(idencargado) FROM encargado";
        $_ResultSet = $_Conexion->returnRS($_Query);
        if (!is_null($_ResultSet)) {
          $_Row = $_ResultSet->FetchRow();
          $idEncargado = $_Row[0];
        }
      }
      else{
        $_Query = "UPDATE encargado SET nombre = '$txtSolicitante', extension = '$txtExt', correo = '$txtEmail', iddepartamento = '$idDepartamento'
                  WHERE idencargado = $idEncargado";
        $_Conexion->consultaAccion($_Query);
      }
      #Insertar Solicitud
      $_Query = "INSERT INTO solicitudpractica (idsolicitudpractica, nombreproyecto, meses, actividades, responsable, direccion, idencargado, idcandidato, status) 
                  VALUES ((SELECT COALESCE(MAX(idsolicitudpractica) + 1, 1) FROM solicitudpractica), '$txtProyecto', '$txtDuracion', '$txtActividades', '$txtJefeDpto', '$txtDireccion', '$idEncargado', '$idCandidato', 1)";
      $_Conexion->consultaAccion($_Query);
      #Actualizar candidato
      $_Query = "UPDATE candidato SET idClasificacion = 25 WHERE idcandidato = $idCandidato";
      $_Conexion->consultaAccion($_Query);
      break;
    default:
      echo '0';
      break;
  }
?>