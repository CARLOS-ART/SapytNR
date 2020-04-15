function ReportConsumos(Tipo,Fe1,Fe2){
  ReportViewer(Tipo);
}

/*============================================================================*/

function ReportPiezaImporte(Fe1,Fe2){
  ReportViewer('20');
}

/*============================================================================*/

function ReportTallerConsumoMensual(Fe1,Fe2){
  ReportViewer('21');
}

/*============================================================================*/

function ReportInformeImporte(TALLERES){
  ReportViewer('24');
}
/*============================================================================*/

function ReportTraspasos(Fe1,Fe2){
  ReportViewer('25');
}
/*============================================================================*/
function ReportCambioPre(Taller,REGISTRO){
  $("#TablaCambioPrecios").data('cambio',REGISTRO);
  ReportViewer(26);
}
/*============================================================================*/
function ReportEnvioProd(TRANSFERENCIAID){
  $("#tableWithSearch").data('Transf',TRANSFERENCIAID);
  ReportViewer(27);
}
/*============================================================================*/

function ReportEspConsumoTaller(Fe1,Fe2){
  ReportViewer('28');
}
/*============================================================================*/

function ReportEspConsumoBitacoras(Fe1,Fe2){
  ReportViewer('30');
}
/*============================================================================*/

function RptEficienciaTaller(Taller,Mes,Anio){
  ReportViewer('31');
}
