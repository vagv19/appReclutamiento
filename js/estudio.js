    /**/
function toggleModal(modal,visible)
{
    $(modal).modal(visible);
}
   $("#btnExaminarCicloEscolar").click(function(){
       sendRequest("POST","lib/consultas/servicio.php",true,"servicio=35",function(data){
           $("#mBoxBodyBusqueda").html(data);
       });
       toggleModal($("#mBoxBusqueda"),"show"); 
    });
   $("#btnExaminarCarrera").click(function(){
       toggleModal($("#mBoxBusqueda"),"show"); 
    });
    $("#btnExaminarInstitucion").click(function(){
       toggleModal($("#mBoxBusqueda"),"show"); 
    }); 
$(document).ready(function(){
    sendRequest("POST","lib/consultas/servicio.php",true,"servicio=26&campos=idcicloescolar as id,descripcion&tabla=cicloescolar",function(data) {
        $("#cmbCicloEscolar").html(data);
    });
    sendRequest("POST","lib/consultas/servicio.php",true,"servicio=26&campos=idinstitucion as id,descripcion&tabla=institucion",function(data) {
        $("#cmbInstitucion").html(data);
    });
    sendRequest("POST","lib/consultas/servicio.php",true,"servicio=26&campos=idcarrera as id,descripcion&tabla=carrera",function(data) {
        $("#cmbCarrera").html(data);
    });
});
$("body").delegate("div.list-group > a","click",function(){
    var obj = $(this).attr("data-object");
    $("#"+obj).val($(this).attr('data-id'));
    toggleModal($("#mBoxBusqueda"),"hide");
});