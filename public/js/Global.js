function FormatearFolio(Folio)
        {
            var Posiciones = Folio.length;
            var Zeros = 6 - Posiciones;
            var Formato = "";
            for (x = 0; x < Zeros; x++)
            {
                Formato += "0";
            }
            return Formato + Folio;
        }
/*======================================*/
function Longitud(txt,Tam){

      txt="#"+txt;
			if ($(txt).val().length>=Tam){
				return false;
				}else{
					return true;
					}
  }

/*===============================================================*/

function justDecimals(e,txt,Tam){
		var Respuesta;
		Respuesta =Longitud(txt,Tam);
		var keynum = window.event ? window.event.keyCode : e.which;
		if(Respuesta==true){
			if ((keynum == 8))return true;
			if((keynum==46)){
				var Cadena=document.getElementById(txt).value;
				var Punto=Cadena.indexOf(".");
				if(Punto==-1){
				 return true;}else{return false}
				 }

		}else{
			return false;
			}
		return /\d/.test(String.fromCharCode(keynum));
  }

/*================================================================*/

function BarNotification(Titulo,Mensaje,TMensaje,Pos){
  $('.page-content-wrapper').pgNotification({
                    style: 'bar',
                  
                    message: Mensaje,
                    position: Pos,
                    timeout: 12000,
                    type: TMensaje,

                }).show();
}

function CircleNotification(Titulo,Mensaje,TMensaje,Pos){
  $('.page-content-wrapper').pgNotification({
                    style: 'circle',
                    title: Titulo,
                    message: Mensaje,
                    position: Pos,
                    timeout: 12000,
                    type: TMensaje,
                    thumbnail: '<img width="40" height="40" style="display: inline-block;" src="/assets/img/profiles/avatar.jpg" data-src="/assets/img/profiles/avatar.jpg" data-src-retina="/assets/img/profiles/avatar.jpg" alt="">'
                }).show();
}

/*===============================================================*/

function justNumbers(e,Tam,txt){
          var Respuesta;
        	Respuesta =Longitud(txt,Tam);
          if(Respuesta==true){
          var keynum = window.event ? window.event.keyCode : e.which;
          if ((keynum == 8) )
          return true;

          return /\d/.test(String.fromCharCode(keynum));
        }else{
          return false;
        }
        }

/*===============================================================*/

function esEnter(e){
var keynum = window.event ? window.event.keyCode : e.which;
if ((keynum == 13) ){
		//document.getElementById('txtDescripcion').focus();
		return false;
}else{
    return true;
}

return /\d/.test(String.fromCharCode(keynum));
}

/*==============================================================*/

function LabelErrorOff(Id,Id2){
  $("#"+Id).removeClass('has-error');
  $("#"+Id2).addClass('LabelError');
}
