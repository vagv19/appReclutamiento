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
        sendRequest("POST","lib/consultas/servicio.php",false,"servicio=37",function(data){
           $("#mBoxBodyBusqueda").html(data);
       });
       toggleModal($("#mBoxBusqueda"),"show"); 
    });
    $("#btnExaminarInstitucion").click(function(){
         sendRequest("POST","lib/consultas/servicio.php",false,"servicio=39",function(data){
           $("#mBoxBodyBusqueda").html(data);
       });
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
}).delegate("#btnBuscarPorNombre","click",function(){
     sendRequest("POST","lib/consultas/servicio.php",true,"servicio=36&txtBuscarCicloEscolar="+$("#txtBuscarCicloEscolar").val(),function(data) {
        $("#bsqResultado").html(data);
    });
}).delegate("#btnBuscarCarreraNombre","click",function(){
     sendRequest("POST","lib/consultas/servicio.php",true,"servicio=38&txtBuscarCarrera="+$("#txtBuscarCarrera").val(),function(data) {
        $("#bsqResultado").html(data);
    });
}).delegate("#btnBuscarInstitucionNombre","click",function(){
    sendRequest("POST","lib/consultas/servicio.php",true,"servicio=40&txtBuscarInstitucion="+$("#txtBuscarInstitucion").val(),function(data) {
        $("#bsqResultado").html(data);
    });
});