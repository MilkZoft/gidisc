$("select[name=type]").change(function() { change(); });

$("select[name=type] option").each(function(obj, x) {
	$(".optiongeneral").hide();
	$(".option" + $(x).val()).hide();
});

function change() {
	var option = $("select[name=type] :selected").val();
	
	if(option != "") {
		$("select[name=type] option").each(function(obj, x) {
			$(".option" + $(x).val()).hide();
			$(".optiongeneral").hide();
		});
		
		$(".optiongeneral").fadeIn();
		$(".option" + option).fadeIn();
		
	} else {
		$(".optiongeneral").hide();
	}
}

$(".addparent").click( function() {
	$("select[name=type] option[value='5']").attr("selected", "selected");
	change();
});

$(".addtherapist").click( function() {
	$("select[name=type] option[value='6']").attr("selected", "selected");
	change();
});



// Datepicker
$('.datepicker').datepicker({
	inline: true,
	changeMonth: true,
	changeYear: true
});

jQuery(function($) { 
$.datepicker.regional['es'] =  
  {  
    clearText: 'Borra',  
    clearStatus: 'Borra fecha actual',  
    closeText: 'Cerrar',  
    closeStatus: 'Cerrar sin guardar',  
    prevStatus: 'Mostrar mes anterior',  
    prevBigStatus: 'Mostrar año anterior',  
    nextStatus: 'Mostrar mes siguiente',  
    nextBigStatus: 'Mostrar año siguiente',  
    currentText: 'Hoy',  
    currentStatus: 'Mostrar mes actual',  
    monthNames:  ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],  
    monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],  
    monthStatus: 'Seleccionar otro mes',  
    yearStatus: 'Seleccionar otro año',  
    weekHeader: 'Sm',  
    weekStatus: 'Semana del año',  
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],  
    dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],  
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],  
    dayStatus: 'Set DD as first week day',  
    dateStatus: 'Select D, M d',  
    dateFormat: 'yy-mm-dd',  
    firstDay: 1,  
    initStatus: 'Seleccionar fecha',  
    isRTL: false  
  };  

  $.datepicker.setDefaults($.datepicker.regional['es']); 
});
