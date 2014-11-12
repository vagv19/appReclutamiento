$(document).ready(function(){
  $.ajax({
    type: "POST",
    async: false,
    url: "php/fn.php",
    data: "fn=10",
    success: function(data){
      $("#tbPracticantes").html(data);
    }
  });
  $('[name="btnSolicitar"]').click(function (){
    $('#idCandidato').val($(this).attr('data-id'));
    $('#lblTitulo').text('Solicitud del candidato: ' + $(this).attr('data-name'));
    $( "#txtSolicitante" ).val("");
    $( "#idEncargado" ).val("0");
    $( "#txtExt" ).val("");
    $( "#txtEmail" ).val("");
    $( "#idDepartamento" ).val("0");
    $( "#txtDepartamento" ).val("");
    $( "#txtDireccion" ).val("");
    $( "#txtJefeDpto" ).val("");
    $( '#txtActividades' ).val("");
    $( '#txtProyecto' ).val("");
    $( '#txtDuracion' ).val("3");
    $('#frmSolicitar').modal('show');
  });

  var ulprueba = 1; 
  $( "#txtSolicitante" ).autocomplete({
    minLength: 2,
    source: function( request, response ) {
      $.ajax({
        type: "POST",
        async: false,
        url: "php/fn.php",
        data: "fn=1&name=" + request.term,
        success: function( data ) {
          response(jQuery.parseJSON(data));
        }
      });
    },
    select: function( event, ui ) {
      $( "#txtSolicitante" ).val( ui.item.label );
      $( "#idEncargado" ).val( ui.item.value );
      $( "#txtExt" ).val(ui.item.ext);
      $( "#txtEmail" ).val(ui.item.correo);
      $( "#idDepartamento" ).val(ui.item.iddepartamento);
      $( "#txtDepartamento" ).val(ui.item.dpto);
      $( "#txtDireccion" ).val(ui.item.direccion);
      $( "#txtJefeDpto" ).val(ui.item.responsable);
      return false;
    }
  }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
    return $( "<li>" )
      .append( "<a>" + item.label + "</a>" )
      .appendTo( ul );
    //ulprueba = ul;
  };

  $( "#txtDireccion" ).autocomplete({
    minLength: 2,
    source: function( request, response ) {
      $.ajax({
        type: "POST",
        async: false,
        url: "php/fn.php",
        data: "fn=3&name=" + request.term,
        success: function( data ) {
          response(jQuery.parseJSON(data));
        }
      });
    },
    select: function( event, ui ) {
      $( "#txtDireccion" ).val( ui.item.label );
      return false;
    }
  }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
    return $( "<li>" )
      .append( "<a>" + item.label + "</a>" )
      .appendTo( ul );
  };

  $( "#txtJefeDpto" ).autocomplete({
    minLength: 2,
    source: function( request, response ) {
      $.ajax({
        type: "POST",
        async: false,
        url: "php/fn.php",
        data: "fn=4&name=" + request.term,
        success: function( data ) {
          response(jQuery.parseJSON(data));
        }
      });
    },
    select: function( event, ui ) {
      $( "#txtJefeDpto" ).val( ui.item.label );
      return false;
    }
  }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
    return $( "<li>" )
      .append( "<a>" + item.label + "</a>" )
      .appendTo( ul );
  };

  $( "#txtDepartamento" ).autocomplete({
    minLength: 2,
    source: function( request, response ) {
      $.ajax({
        type: "POST",
        async: false,
        url: "php/fn.php",
        data: "fn=2&name=" + request.term,
        success: function( data ) {
          response(jQuery.parseJSON(data));
        }
      });
    },
    select: function( event, ui ) {
      $( "#txtDepartamento" ).val( ui.item.label );
      $( "#idDepartamento" ).val( ui.item.value );
      return false;
    }
  }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
    return $( "<li>" )
      .append( "<a><b>" + item.label + "</b><br><small><i>" + item.unidad + "</i></small></a>" )
      .appendTo( ul );
  };


  //Autocompletar por encima del modal
  $('.ui-autocomplete.ui-front.ui-menu.ui-widget.ui-widget-content.ui-corner-all').css('z-index', '10000');
  $('.ui-autocomplete.ui-front.ui-menu.ui-widget.ui-widget-content.ui-corner-all').css('max-height', '200px');
  $('.ui-autocomplete.ui-front.ui-menu.ui-widget.ui-widget-content.ui-corner-all').css('overflow-y', 'auto');

  //Ingresa la nueva solicitud
  $('#btnSolicitar').click(function(){
    $.ajax({
      type: "POST",
      async: false,
      url: "php/fn.php",
      data: {
        fn: 20,
        idCandidato: $('#idCandidato').val(),
        idEncargado: $('#idSolicitante').val(),
        idDepartamento: $('#idDepartamento').val(),
        txtSolicitante: $('#txtSolicitante').val(),
        txtActividades: $('#txtActividades').val(),
        txtDuracion: $('#txtDuracion').val(),
        txtDepartamento: $('#txtDepartamento').val(),
        txtDireccion: $('#txtDireccion').val(),
        txtProyecto: $('#txtProyecto').val(),
        txtExt: $('#txtExt').val(),
        txtEmail: $('#txtEmail').val(),
        txtJefeDpto: $('#txtJefeDpto').val(),
      },
      success: function(data){
        $.ajax({
          type: "POST",
          async: false,
          url: "php/fn.php",
          data: "fn=10",
          success: function(data){
            $("#tbPracticantes").html(data);
          }
        });
        $('#btnCerrar').click();
        $('[name="btnSolicitar"]').click(function (){
          $('#idCandidato').val($(this).attr('data-id'));
          $('#lblTitulo').text('Solicitud del candidato: ' + $(this).attr('data-name'));
          $( "#txtSolicitante" ).val("");
          $( "#idEncargado" ).val("0");
          $( "#txtExt" ).val("");
          $( "#txtEmail" ).val("");
          $( "#idDepartamento" ).val("0");
          $( "#txtDepartamento" ).val("");
          $( "#txtDireccion" ).val("");
          $( "#txtJefeDpto" ).val("");
          $( '#txtActividades' ).val("");
          $( '#txtProyecto' ).val("");
          $( '#txtDuracion' ).val("3");
          $('#frmSolicitar').modal('show');
        });
      }
    });
  });
});