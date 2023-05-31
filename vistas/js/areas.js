/*=============================================
EDITAR AREA
=============================================*/
$(".tablas").on("click", ".btnEditarArea", function(){

	var idArea = $(this).attr("idArea");

	var datos = new FormData();
	datos.append("idArea", idArea);

	$.ajax({
		url: "ajax/areas.ajax.php",
		method: "POST",
      	data: datos,
      	cache: false,
     	contentType: false,
     	processData: false,
     	dataType:"json",
     	success: function(respuesta){

     		$("#editarArea").val(respuesta["area"]);
     		$("#idArea").val(respuesta["id_area"]);

     	}

	})


})

/*=============================================
ELIMINAR AREA
=============================================*/
$(".tablas").on("click", ".btnEliminarArea", function(){

	 var idArea = $(this).attr("idArea");

	 swal({
	 	title: '¿Está seguro de borrar el Área?',
	 	text: "¡Si no lo está puede cancelar la acción!",
	 	type: 'warning',
	 	showCancelButton: true,
	 	confirmButtonColor: '#3085d6',
	 	cancelButtonColor: '#d33',
	 	cancelButtonText: 'Cancelar',
	 	confirmButtonText: 'Si, borrar área!'
	 }).then(function(result){

	 	if(result.value){

	 		window.location = "index.php?ruta=areas&idArea="+idArea;

	 	}

	 })

})
/*=============================================
REVISAR SI EL USUARIO YA ESTÁ REGISTRADO
=============================================*/

$("#nuevaArea").on("input", function(){

	$(".alert").remove();

	var area = $(this).val();
	console.log(area);

	var datos = new FormData();
	datos.append("validarArea", area);

	 $.ajax({
	    url:"ajax/areas.ajax.php",
	    method:"POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){
	    	
	    	if(respuesta){

	    		$("#nuevaArea").parent().after('<div class="alert alert-warning">Esta área ya existe en la base de datos</div>');

	    		$("#nuevaArea").val("");

	    	}

	    }

	})
})