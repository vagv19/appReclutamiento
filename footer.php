 </div>
      </div>
    </div>
    <div id="msjError" class="alert alert-info" style="position: absolute;top: 90%;left: 20px;display: none;z-index: 10000;width: 200px;">algo <span class="close" style="    position: absolute;top: 0px;left: 179px;">×</span>
</div>
    <!-- modal -->
	<div class="modal fade" id="mBox" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div id="mBoxHeader" class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 id="mBoxTitle" class="modal-title" id="myModalLabel">Examinar <i class="glyphicon glyphicon-search"></i></h4>
				</div>
				<div id="mBoxBody" class="modal-body">				
					<div id="mBoxHeader" class="container-fluid"></div>
					<div id="mBoxContainer" class="container-fluid"></div>
				</div>
				<div id="mboxFooter" class="modal-footer">
					<button id="btnGuardarModal" type="button" class="btn btn-primary">Guardar</button>
					<button id="btnCerrarModal" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
    <!--mBoxBusquedas -->
    <div class="modal fade" id="mBoxBusqueda" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div id="mBoxHeaderBusqueda" class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 id="mBoxTitleBusqueda" class="modal-title" id="myModalLabel">Examinar <i class="glyphicon glyphicon-search"></i></h4>
				</div>
				<div id="mBoxBodyBusqueda" class="modal-body">				
					<div id="mBoxHeaderBusqueda" class="container-fluid"></div>
					<div id="mBoxContainerBusqueda" class="container-fluid"></div>
				</div>
				<div id="mBoxFooterBusqueda" class="modal-footer">
					<button id="btnCerrarModalBusqueda" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
    <!--mBoxBusquedas -->
	<div class="modal fade" id="mBoxAlert" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div id="mBoxAlertHeader" class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 id="mBoxAlertTitle" class="modal-title">Titulo</h4>
				</div>
				<div id="mBoxAlertBody" class="modal-body">				
					
				</div>
				<div id="mBoxAlertFooter" class="modal-footer">
					<button id="btnCerrarModal" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
    <!-- modal -->
    
     <script type="text/javascript" src="js/jquery.form.js"></script>
     <script src="js/ui/jquery.ui.core.min.js"></script>
	<script src="js/ui/jquery.ui.widget.min.js"></script>
	<script src="js/ui/jquery.ui.position.min.js"></script>
	<script src="js/ui/jquery.ui.menu.min.js"></script>
	<script src="js/ui/jquery.ui.autocomplete.min.js"></script>
	<script src="js/ui/jquery.ui.effect.min.js"></script>
	<script src="js/ui/jquery.ui.effect-slide.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/datepicker/bootstrap-datepicker.js"></script>
    <script src="js/datepicker/locales/bootstrap-datepicker.es.js" charset="UTF-8"></script>
    <script type="text/javascript" src="js/jsfuncionesGenericas.js"></script>
    <script type="text/javascript" src="js/jsfunciones.js"></script>
    <script type="text/javascript">
    	$(document).scroll(function(){
    		if($(this).scrollTop()==0)
    		{
    			$("#navBarTop").fadeIn(100);
    		}
    		else{
    			$("#navBarTop").fadeOut(100);
    		}
    	})
    </script>
  </body>
</html>