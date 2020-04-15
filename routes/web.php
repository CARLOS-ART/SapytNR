<?php

Route::get('/', function () {
    return view('login');
});


Route::any('Iniciar','Auth_Controller@iniciardemo');


Route::get('/', 'Auth_Controller@Autentificacion');
Route::post('Auth/IniciarSesion','Auth_Controller@IniciarSesion');
Route::post('/IniciarNuevamente','Auth_Controller@IniciarNuevamente');
Route::get('Logout','Auth_Controller@Logout');
Route::get('Inicio','Auth_Controller@Maqueta');
Route::post('/ReportViewer','ReportViewer_Controller@Visor');


Route::prefix('Auditorias')->group(function(){
  Route::get('Tablero','Auditorias_Controller@Tablero');
  Route::get('Formato/Almacen','Auditorias_Controller@Formato_Almacen');
  Route::get('Formato/Laboratorio','Auditorias_Controller@Formato_Laboratorio');

  Route::post('Formato/Editar','Auditorias_Controller@Editar_Auditoria');

  Route::post('Formato/Almacen/CargarDatos','Auditorias_Controller@CargarDatos_Almacen');
  Route::post('Formato/Almacen/FiltrarProductos','Auditorias_Controller@FiltrarProductos_Almacen');
  Route::post('Formato/Almacen/Terminar','Auditorias_Controller@TerminarAuditoria_Almacen');

  Route::post('Formato/Lab/CargarDatos','Auditorias_Controller@CargarDatos_Lab');
  Route::post('Formato/Lab/FiltrarProductos','Auditorias_Controller@FiltrarProductos_Lab');
  Route::post('Formato/Lab/Terminar','Auditorias_Controller@TerminarAuditoria_Lab');
  Route::post('Formato/Almacen/RealizarAfectacion','Auditorias_Controller@RealizarAfectacion');
});

Route::prefix('Compras')->group(function(){
  Route::get('Registrar','Compras_Controller@CapturaCompra');
  Route::post('ConsultarCatalogo','Compras_Controller@ConsultarCatalogo');
  Route::post('UseItem','Compras_Controller@UseItem');
  Route::post('AgregarProducto','Compras_Controller@AgregarProducto');
  Route::post('EliminarItem','Compras_Controller@EliminarItem');
  Route::post('GuardarCompra','Compras_Controller@GuardarCompra');
  Route::post('GuardarCompraFactory','Compras_Controller@GuardarCompraFactory');
  Route::post('AceptarCompraFactory','Compras_Controller@AceptarCompraFactory');
  Route::get('Historial','Compras_Controller@Historial');
  Route::post('Historial/Tablero','Compras_Controller@HistorialTablero');
  });

Route::prefix('InventarioInicial')->group(function(){
  Route::get('Tablero','Inventario_Inicial_Controller@VTableroInventario');
  Route::get('/', 'Inventario_Inicial_Controller@Iniciar_Inventario_Inicial');
  Route::get('Formato','Inventario_Inicial_Controller@FormatoInventario');
  Route::post('CargarLinea','Inventario_Inicial_Controller@CargarLinea');
  Route::post('SubirInventario','Inventario_Inicial_Controller@SubirInventario');
  Route::post('Formato/FiltrarProductos','Inventario_Inicial_Controller@FiltrarProductos');
  Route::post('Formato/Editar','Inventario_Inicial_Controller@Editar_Inventario_Inicial');
  Route::post('Formato/CargarDatos','Inventario_Inicial_Controller@CargarDatos');
  Route::post('Formato/Cancelar','Inventario_Inicial_Controller@CancelarFormato');
  Route::post('Guardar','Inventario_Inicial_Controller@GuardarInvetario');
  Route::get('Aliados', 'Inventario_Inicial_Controller@Iniciar_Inventario_Inicial_Aliados');
  Route::get('Formato/Aliados','Inventario_Inicial_Controller@FormatoInventarioAliados');
  Route::get('Tablero/Aliados','Inventario_Inicial_Controller@VTableroInventarioAliados');
});

Route::prefix('Talleres')->group(function(){
  Route::get('Crear','Talleres_Controller@VCrear');
  Route::post('nuevoTaller','Talleres_Controller@nuevoTaller');
  Route::get('FichaTaller','Talleres_Controller@VInfo');
  Route::get('FichaTaller/Set/{TallerID}',array("as"=>"TallerID","uses"=>"Talleres_Controller@FichaTallerSet"));
  Route::post('Operarios/Crear','Talleres_Controller@CrearOperario');
  Route::post('Operarios/CambiarEstatus','Talleres_Controller@CambiarEstatus');
  Route::any('Imagen/Upload','Talleres_Controller@UploadFotoLogo');
  Route::post('Operarios/CambiarEstatus','Talleres_Controller@CambiarEstatus');

});

Route::prefix('Bitacoras')->group(function(){
    Route::get('Bitacoras','Bitacoras_Controller@BitacorasNew');
    Route::get('Crear/Info','Bitacoras_Controller@BitacorasInfo');

    Route::post('CargaProductoBitacora','Bitacoras_Controller@CargaProductoBitacora');

    Route::get('Tablero','Bitacoras_Tablero_Controller@Tablero');
    Route::post('Tablero/MostrarBitacoras','Bitacoras_Tablero_Controller@MostrarBitacoras');
    Route::post('Tablero/Historial','Bitacoras_Tablero_Controller@MostrarBitacoras');
    Route::get('Tablero/Historial','Bitacoras_Tablero_Controller@Tablero');
    Route::post('Tablero/CerrarOT','Bitacoras_Tablero_Controller@CerrarOT');
    Route::post('Crear/Info/ObtenerVehiculos','Bitacoras_Controller@ObtenerVehiculos');
    Route::post('ValidarOT','Bitacoras_Controller@ValidarOT');
    Route::post('Crear/Info','Bitacoras_Controller@IntroducirInfo');

    Route::get('Crear/SelectorPiezas','Bitacoras_Controller@SelectorPiezas');
    Route::post('Piezas/LeerPiezasBitacora','Bitacoras_Controller@LeerPiezasBitacora');
    Route::post('Piezas/Cargar','Bitacoras_Controller@CargarPieza');
    Route::post('Piezas/Eliminar','Bitacoras_Controller@EliminarPieza');
    Route::post('Piezas/setCondicion','Bitacoras_Controller@setCondicion');

    Route::post('Piezas/GuardaCambios','Bitacoras_Controller@GuardaCambios');
    Route::get('Administrar/Partidas','Bitacoras_Controller@AdministrarPartidas');
    Route::get('TerminarCaptura','Bitacoras_Controller@TerminarCaptura');
    Route::post('Actualizar','Bitacoras_Controller@ActualizarComentario');
    Route::post('Mostrar','Bitacoras_Controller@MostrarComentario');
    Route::get('Tablero/IrBitacora/{Bit}',array("as"=>"Bit","uses"=>"Bitacoras_Tablero_Controller@IrBitacora"));
    Route::post('MostrarBit','Bitacoras_Tablero_Controller@MostrarBit');
    Route::post('Tablero/CancelarOT','Bitacoras_Tablero_Controller@CancelarOT');
    Route::post('MostrarBitCancelar','Bitacoras_Tablero_Controller@MostrarBitCancelar');

    Route::get('/Productos/Consumo','Bitacoras_Controller@AddItems');
    Route::post('/Productos/Consumo/FinalizarCaptura','Bitacoras_Controller@FinalizarCaptura');

    /*Route::post('Administrar/Partidas/Eliminar','Bitacoras_Controller@EliminarPartida');
    Route::post('Administrar/Partidas/EditarOperario','Bitacoras_Controller@EditarOperario');

    Route::get('Crear','Bitacoras_Controller@BitacorasNew');
    Route::post('Piezas/NuevaPza','Bitacoras_Controller@NuevaPza');
    Route::post('Crear/AddItems/ObtenerProducto','Bitacoras_Controller@ObtenerProducto');
    Route::post('Crear/AddItems/Preview','Bitacoras_Controller@PreviewItems');
    Route::post('Crear/AddItems/EliminarItem','Bitacoras_Controller@EliminarItemTMP');
    Route::post('Crear/AddItems/GuardarProductos','Bitacoras_Controller@GuardarProductos');
    Route::post('Crear/AddItems/ConsultarCatalogo','Bitacoras_Controller@ConsultarCatalogo');
    Route::post('Crear/AddItems/UseItem','Bitacoras_Controller@UseItem');

    Route::post('Crear/AddItems/AgregarProducto','Bitacoras_Controller@AgregarProducto');

    Route::get('Crear/ColorIgualado','Bitacoras_Igualado_Controller@Igualados');
    Route::post('AddItems/Color/Tint','Bitacoras_Igualado_Controller@ColorManual');
    Route::post('Crear/AddItems/Color/Productos','Bitacoras_Igualado_Controller@ProductosIgualado');
    Route::post('Crear/AddItems/Color/UseItemColor','Bitacoras_Igualado_Controller@UseItemColor');
    Route::post('Crear/AddItems/Color/AddItemColor','Bitacoras_Igualado_Controller@AddItemColor');
    Route::post('Color/EliminarItemColor','Bitacoras_Igualado_Controller@EliminarItemColor');
    Route::post('Color/GuardarColor','Bitacoras_Igualado_Controller@GuardarColor');
    Route::post('Color/AddItems/Color/MostrarItemsColor','Bitacoras_Igualado_Controller@MostrarItemsColor');

    Route::post('AddItems/Color/Formula','Bitacoras_Igualado_Controller@ColorFormula');
    Route::post('AddItems/Color/Formula/Buscar','Bitacoras_Igualado_Controller@BuscarFormula');
    Route::post('AddItems/Color/Formula/PrepararMezcla','Bitacoras_Igualado_Controller@PrepararMezcla');
    Route::post('AddItems/Color/Formula/InsertaLPA','Bitacoras_Igualado_Controller@InsertaLPA');


    Route::get('Tablero','Bitacoras_Tablero_Controller@Tablero');
    Route::post('Tablero/MostrarBitacoras','Bitacoras_Tablero_Controller@MostrarBitacoras');
    Route::post('Tablero/Historial','Bitacoras_Tablero_Controller@MostrarBitacoras');
    Route::post('Tablero/CerrarOT','Bitacoras_Tablero_Controller@CerrarOT');



	Route::get('Bitacoras',function(){
    return view('Bitacoras.Bitacoras');
  });
  Route::post('CargaProductoBitacora','Bitacoras_Controller@CargaProductoBitacora');*/
});

Route::prefix('Productos')->group(function(){
  Route::get('Aliados','Productos_Controller@VAliados');
  Route::get('FormatoAliados','Productos_Controller@VFormatoAliados');
  Route::get('FormatoAliados/Captura','Productos_Controller@VCapturaAliados');
  Route::post('GuardarAliados','Productos_Controller@GuardarAliados');
  Route::post('TerminarYCargar','Productos_Controller@TerminarYCargar');
  Route::post('Aliados/Editar/Formato','Productos_Controller@EditarFormatoAliados');
  Route::post('FormatoAliados/CargarDatos','Productos_Controller@CargarDatosFormato');
  Route::post('FormatoAliados/Cancelar','Productos_Controller@CancelarFormatoAliados');

  Route::get('CambioPrecios','Productos_Controller@VCambiarPrecios');
  Route::post('CambioPrecios/CargarInventario','Productos_Controller@CargarInventario');
  Route::post('CambioPrecios/FiltrarProductos','Productos_Controller@FiltrarProductos');
  Route::post('CambioPrecios/Actualizar','Productos_Controller@ActualizarPrecios');

  Route::get('CambioPrecios/Porcentaje','Productos_Controller@VCambiarPreciosPorcentaje');
  Route::post('CambioPrecios/Porcentaje/Actualizar','Productos_Controller@CambiarPreciosPorcentaje');

  Route::get('ProductosBASF','Productos_Controller@ProductosBASF');
  Route::post('ProductosBASF/Activar','Productos_Controller@ProductosBASF_Activar');

  Route::get('Traspaso','Productos_Controller@Traspaso');
  Route::post('Traspaso/Busqueda_Productos','Productos_Controller@Busqueda_Productos');
  Route::post('Traspaso/UseItem','Productos_Controller@UseItem');
  Route::post('Traspaso/TraspasoProducto','Productos_Controller@TraspasoProducto');
});

Route::prefix('Distribuidores')->group(function(){
  Route::get('Alta','Distribuidores_Controller@AltaDist');
  Route::post('GenerarAlta','Distribuidores_Controller@GenerarAlta');
});

Route::prefix('Estadisticas')->group(function(){
  Route::get('Inventario','Estadisticas_Contoller@Inventario');
  Route::get('Operario','Estadisticas_Contoller@Operario');
  Route::get('Productividad','Estadisticas_Contoller@ProductividadView');
  Route::get('Graficas','Estadisticas_Contoller@Graficas');
  Route::post('Graficas/GraficaConsumoOperarios','Estadisticas_Contoller@GraficaConsumoOperarios');
  Route::get('Consumo','Estadisticas_Contoller@ConsumoProductos');
  route::get('PiezaImporte','Estadisticas_Contoller@PiezaImporte');
  route::get('TallerConsumoMensual','Estadisticas_Contoller@TallerConsumoMensual');
  Route::get('InformeTalleresImporte','Estadisticas_Contoller@TallerInforme');
  Route::get('Traspasos','Estadisticas_Contoller@Traspasos');
  Route::get('EstadisticaCambioPrecio','Estadisticas_Contoller@CambioPrecios');
  Route::get('Transferencia_producto','Estadisticas_Contoller@Transferencia_producto');
  Route::get('EspConsumoTaller','Estadisticas_Contoller@EspConsumoTaller');
  Route::get('EspConsumoBitacoras','Estadisticas_Contoller@EspConsumoBitacoras');
  Route::get('EficienciaTaller','Estadisticas_Contoller@EficienciaTaller');

});

Route::prefix('Usuarios')->group(function(){
  Route::get('Crear','Usuarios_Controller@FormCrear');
  Route::post('SeleccionarTaller','Usuarios_Controller@SeleccionarTaller');
  Route::post('GuardarUsuario','Usuarios_Controller@GuardarUsuario');
});

Route::prefix('Formulas')->group(function(){
  Route::get('Crear','Formulas_Basf_Controller@CrearFormula');

});

Route::prefix('AgenteVentas')->group(function(){
  Route::get('AgenteVentas','AgenteVentas_Controller@AgenteVentas');
});

Route::prefix('Factory')->group(function(){
  Route::get('Cuadrillas/Crear','Cuadrillas_Trabajo_Controller@CrearCuadrilla');
  Route::post('Cuadrillas/CrearCuadrilla','Cuadrillas_Trabajo_Controller@RegistrarCuadrilla');

  Route::get('Bitacoras/Crear','Bitacoras_Factory_Controller@BitacoraSteeps');
  Route::get('Bitacoras/Crear/Info','Bitacoras_Factory_Controller@BitacoraInfo');
  Route::post('Bitacoras/ActividadBitacora','Bitacoras_Factory_Controller@ActividadBitacora');
  Route::get('Bitacoras/Productos/{Actividad}/{Zona}',array('as'=>'Actividad','as'=>'Zona','uses'=>'Bitacoras_Factory_Controller@ProductosBitacora'));

  Route::post('Bitacoras/Items/ConsultarCatalogo','Bitacoras_Factory_Controller@ConsultarCatalogo');
  Route::post('Bitacoras/Items/UseItem','Bitacoras_Factory_Controller@UseItem');
  Route::post('Bitacoras/Items/AgregarProducto','Bitacoras_Factory_Controller@AgregarProducto');
  Route::post('Bitacoras/Items/EliminarItem','Bitacoras_Factory_Controller@EliminarItem');
  Route::post('Bitacoras/Items/Preview','Bitacoras_Factory_Controller@Preview');
  Route::post('Bitacoras/Items/BuscarLPA','Bitacoras_Factory_Controller@BuscarLPA');
  Route::post('Bitacoras/Items/PrepararMezcla','Bitacoras_Factory_Controller@PrepararMezcla');
  Route::post('Bitacoras/Items/LpaToBitacora','Bitacoras_Factory_Controller@LpaToBitacora');

  Route::get('Bitacoras/TerminarCaptura','Bitacoras_Factory_Controller@TerminarCaptura');

  Route::post('Bitacoras/Crear/Info/IntegrantesCuadrilla','Bitacoras_Factory_Controller@IntegrantesCuadrilla');
  Route::post('Bitacoras/Crear/Info','Bitacoras_Factory_Controller@GuardarInfo');
  Route::get('Bitacoras/Actividades','Bitacoras_Factory_Controller@TableroActividades');

  Route::get('Actividades/Crear','Actividades_Factory_Controller@TableroActividades');
  Route::post('Actividades/ActividadGuardar','Actividades_Factory_Controller@ActividadGuardar');
  Route::post('Actividades/Zonas/Guardar','Actividades_Factory_Controller@ZonasGuardar');
  Route::get('Actividades/Zonas','Actividades_Factory_Controller@TableroZonas');
  Route::get('Actividades/CatalogoVehiculos','Actividades_Factory_Controller@TableroVehiculos');
  Route::post('Actividad/CatalogoVehiculos/VehiculoGuardar','Actividades_Factory_Controller@VehiculoGuardar');

  Route::get('Bitacoras/Tablero','Bitacoras_Factory_Controller@BitacorasTablero');
  /*Route::get('Bitacoras/Tablero/Historial','Bitacoras_Factory_Controller@BitacorasTablero');
  Route::post('Bitacoras/Tablero/Historial','Bitacoras_Factory_Controller@MostrarBitacoras');*/
  Route::get('Bitacoras/Tablero/IrBitacora/{BIESP_ID}',array('as'=>'BIESP_ID','uses'=>'Bitacoras_Factory_Controller@IrBitacora'));
  Route::post('Bitacoras/Tablero/CerrarOT','Bitacoras_Factory_Controller@CerrarOT');
  Route::post('Bitacoras/Tablero/CancelarOT','Bitacoras_Factory_Controller@CancelarOT');
  Route::get("Formulas","Formulas_Controller@CrearFormulas");
  Route::post("Formulas/BuscarProductos","Formulas_Controller@BuscarProductos");
  Route::post("Formulas/UseItem","Formulas_Controller@UseItem");
  Route::post("Formulas/ItemFormula","Formulas_Controller@ItemFormula");
  Route::post("Formulas/AgregarProductoFormula","Formulas_Controller@AgregarProductoFormula");
  Route::post("Formulas/EliminarItem","Formulas_Controller@EliminarItem");
  Route::post('Formulas/CrearFormula','Formulas_Controller@CrearFormula');

  Route::post('Bitacoras/Items/GuardarArticulos','Bitacoras_Factory_Controller@GuardarArticulos');

});



Route::prefix('Soporte')->group(function(){
  Route::get('SoporteTecnico', 'SoporteTecnicoController@FormularioSoporte');
  Route::post('MostrarTableroAuditoria','SoporteTecnicoController@MostrarTableroAuditoria');
  Route::post('CambiarEstatusAuditoria','SoporteTecnicoController@CambiarEstatusAuditoria');
  Route::post('MostrarDatosTaller','SoporteTecnicoController@MostrarDatosTaller');
  Route::post('CambiarEstatusBitacora','SoporteTecnicoController@CambiarEstatusBitacora');
  Route::post('CambiarEstatusAliados','SoporteTecnicoController@CambiarEstatusAliados');
  Route::post('CambiarEstInventario','SoporteTecnicoController@CambiarEstInventario');
  //Route::get('ConsumoProductos','SoporteTecnicoController@ConsumoProductos');
  Route::post('construirFormOperarios','SoporteTecnicoController@construirFormOperarios');
  Route::post('CrearFormularioProductividad','SoporteTecnicoController@CrearFormularioProductividad');
  Route::post('GraficasForm','SoporteTecnicoController@GraficasForm');
  Route::post('MostrarFormEstConsumo','SoporteTecnicoController@MostrarFormEstConsumo');
});

Route::prefix('api')->group(function(){
  Route::post('bitacoras','Api_Controller@DatosBitacora');
});

Route::prefix('Transfer')->group(function(){
  Route::get('Transferencias','TransferenciaController@formTransfer');
  Route::post('TablaProductos','TransferenciaController@TablaProductos');
  Route::post('BuscarProductos','TransferenciaController@BuscarProductos');
  Route::post('Producto','TransferenciaController@Producto');
  Route::post('GuardarProducto','TransferenciaController@GuardarProducto');
  Route::post('GuardarTraspasoProducto','TransferenciaController@GuardarTraspasoProducto');
  Route::post('EliminarProducto','TransferenciaController@EliminarProducto');
});
