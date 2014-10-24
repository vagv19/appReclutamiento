<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        	<nav class="navbar navbar-default" role="navigation">
							<!-- Brand and toggle get grouped for better mobile display -->
							<div class="navbar-header">
								<a class="navbar-brand" href="#"><span class="glyphicon glyphicon-user" style="font-size:32px;"></span>&nbsp;</a>
							</div>
							
							<!-- Collect the nav links, forms, and other content for toggling -->
							<div class="collapse navbar-collapse navbar-ex1-collapse">
								<div class="navbar-form navbar-right">
									<div class="form-group">
										<div class="input-group">
											 <span class="input-group-addon">Buscar</span>
									      <input type="text" id="txtBuscar" class="form-control">
									      <span class="input-group-btn">
									        <!-- button class="btn btn-default" type="button"><i class="glyphicon glyphicon-search"></i></button-->
									        <div class="btn-group">
											  <button type="button" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
											  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
											    <span class="caret"></span>
											    <span class="sr-only">Ver Opciones</span>
											  </button>
											  <ul id="cmbBarraBusqueda" class="dropdown-menu" role="menu">
											    
											  </ul>
										      </span>
										  </div>
									    </div>
											<div id="popBusqueda" class="popover bottom" style="max-width:522px;width:450px;">
											<div class="arrow"></div>
											<h3 class="popover-title">Resultado de la Busqueda</h3>
											<div id="divRSBusqueda" class="popover-content">
											</div>
										</div><!---popoverbusqueda-->
									</div>
									
									
								</div>
								<div class="navbar-form">
									<div class="btn-group">
									  <button id="btnAgregar" data-accion="insert" type="button" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i> Agregar</button>
									  <button id="btnEliminar" data-accion="delete" type="button" class="btn btn-default"><i class="glyphicon glyphicon-remove-sign"></i> Eliminar</button>
									  <button id="btnReactivar" data-accion="reactivate" type="button" class="btn btn-default" style="display:none;"><i class="glyphicon glyphicon-ok-circle"></i> Reactivar</button>
									  <button id="btnModificar" data-accion="update" type="button" class="btn btn-default"><i class="glyphicon glyphicon-edit"></i> Modificar</button>
									</div>									
								</div>
								
							</div><!-- /.navbar-collapse -->
						</nav>	
         </div>