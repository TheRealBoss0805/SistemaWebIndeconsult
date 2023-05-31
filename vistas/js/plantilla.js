/*=============================================
SideBar Menu
=============================================*/

$('.sidebar-menu').tree()

/*=============================================
Data Table
=============================================*/

$(".tablas").DataTable({

	"language": {

		"sProcessing":     "<b>Procesando...</b>",
		"sLengthMenu":     "<b>Mostrar _MENU_ registros</b>",
		"sZeroRecords":    "<b>No se encontraron resultados</b>",
		"sEmptyTable":     "<b>Ningún dato disponible en esta tabla</b>",
		"sInfo":           "<b>Mostrando registros del _START_ al _END_ de un total de _TOTAL_</b>",
		"sInfoEmpty":      "<b>Mostrando registros del 0 al 0 de un total de 0</b>",
		"sInfoFiltered":   "<b>(filtrado de un total de _MAX_ registros)</b>",
		"sInfoPostFix":    "",
		"sSearch":         "<b>Buscar:</b>",
		"sUrl":            "",
		"sInfoThousands":  ",",
		"sLoadingRecords": "<b>Cargando...</b>",
		"oPaginate": {
		"sFirst":    "Primero",
		"sLast":     "Último",
		"sNext":     "Siguiente",
		"sPrevious": "Anterior"
		},
		"oAria": {
			"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
			"sSortDescending": ": Activar para ordenar la columna de manera descendente"
		}

	}

});

/*=============================================
 //iCheck for checkbox and radio inputs
=============================================*/

$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
  checkboxClass: 'icheckbox_minimal-blue',
  radioClass   : 'iradio_minimal-blue'
})

/*=============================================
 //input Mask
=============================================*/

//Datemask dd/mm/yyyy
$('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
//Datemask2 mm/dd/yyyy
$('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
//Money Euro
$('[data-mask]').inputmask()

/*=============================================
CORRECCIÓN BOTONERAS OCULTAS BACKEND	
=============================================*/

if(window.matchMedia("(max-width:768px)").matches){
	
	$("body").addClass('sidebar-collapse');

}else{

	
	$("body").removeClass('sidebar-collapse');
}
