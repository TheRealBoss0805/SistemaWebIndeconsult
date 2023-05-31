/*=============================================
EDITAR CLIENTE
=============================================*/
$(".tablas").on("click", ".btnEditarCliente", function(){

	var idCliente = $(this).attr("idCliente");

	var datos = new FormData();
    datos.append("idCliente", idCliente);

    $.ajax({

      url:"ajax/clientes.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){
      
      	   $("#idCliente").val(respuesta["id_proveedor"]);
	       $("#editarCliente").val(respuesta["nombre"]);
	       $("#editarDocumentoId").val(respuesta["ruc"]);
	       $("#editarEmail").val(respuesta["email"]);
	       $("#editarTelefono").val(respuesta["telefono"]);
	       $("#editarDireccion").val(respuesta["direccion"]);
           //$("#editarFechaNacimiento").val(respuesta["fecha_nacimiento"]);
	  }

  	})

})

/*=============================================
ELIMINAR CLIENTE
=============================================*/
$(".tablas").on("click", ".btnEliminarCliente", function(){

	var idCliente = $(this).attr("idCliente");
	
	swal({
        title: '¿Está seguro de borrar el Proveedor?',
        text: "Tenga en cuenta de que si prosigue con la acción, todos los ingresos de productos que se hayan añadido con dicho proveedor, también serán borrados.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar proveedor!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "index.php?ruta=clientes&idCliente="+idCliente;
        }

  })

})

/*=============================================
CEAR-REVISAR SI EL USUARIO YA ESTÁ REGISTRADO-API
=============================================*/

$(".nuevoRuc").change(function(){
	//inputCliente=$(this).parent().parent().parent().childre("nuevoCliente");
	$(".alert").remove();

	var ruc = $(this).val();
	console.log(ruc);

	var datos = new FormData();
	datos.append("validarProveedor", ruc);

	 $.ajax({
	    url:"ajax/clientes.ajax.php",
	    method:"POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){
	    	
	    	if(respuesta){
				console.log(respuesta);
	    		$(".nuevoRuc").parent().after('<div class="alert alert-warning">Este proveedor ya existe en la base de datos</div>');
	    		$(".nuevoRuc").val("");
				$(".nuevoCliente").val("");
				$(".nuevoDireccion").val("");

	    	}else{
				$(".alert").remove();
				var datosProveedor = new FormData();
				datosProveedor.append("datosProveedor", ruc);
				$.ajax({
					url:"ajax/clientes.ajax.php",
					method:"POST",
					data: datosProveedor,
					cache: false,
					contentType: false,
					processData: false,
					dataType: "json",
					success:function(respuesta){
						
						if(Object.values(respuesta).length > 2){
							//console.log(Object.values(respuesta));
							//console.log();
							$(".nuevoCliente").val(respuesta["nombre"]);
							$(".nuevaDireccion").val(respuesta["direccion"]+" - "+respuesta["distrito"]+" - "+respuesta["provincia"]+" - "+respuesta["departamento"]);
						}else{
							$(".nuevoRuc").parent().after('<div class="alert alert-warning">'+respuesta['error']+'</div>');	
						}
			
					}
			
				})
			}

	    }

	})
}) 
/*=============================================
EDITAR-REVISAR SI EL USUARIO YA ESTÁ REGISTRADO-API
=============================================*/

$(".editarRuc").change(function(){
	//inputCliente=$(this).parent().parent().parent().childre("nuevoCliente");
	$(".alert").remove();

	var ruc = $(this).val();
	console.log(ruc);

	var datos = new FormData();
	datos.append("validarProveedor", ruc);

	 $.ajax({
	    url:"ajax/clientes.ajax.php",
	    method:"POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){
	    	
	    	if(respuesta){
				console.log(respuesta);
	    		$(".editarRuc").parent().after('<div class="alert alert-warning">Este proveedor ya existe en la base de datos</div>');
	    		$(".editarRuc").val("");
				$(".editarCliente").val("");
				$(".editarDireccion").val("");

	    	}else{
				var datosProveedor = new FormData();
				datosProveedor.append("datosProveedor", ruc);
				$.ajax({
					url:"ajax/clientes.ajax.php",
					method:"POST",
					data: datosProveedor,
					cache: false,
					contentType: false,
					processData: false,
					dataType: "json",
					success:function(respuesta){
							
						if(Object.values(respuesta).length > 2){
							//console.log(Object.values(respuesta));
							//console.log();
							$(".editarCliente").val(respuesta["nombre"]);
							$(".editarDireccion").val(respuesta["direccion"]+" - "+respuesta["distrito"]+" - "+respuesta["provincia"]+" - "+respuesta["departamento"]);
						}else{
							$(".editarRuc").parent().after('<div class="alert alert-warning">'+respuesta['error']+'</div>');	
						}
			
					}
			
				})
			}

	    }

	})
}) 