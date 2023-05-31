<?php

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class ControladorEntradas{

	/*=============================================
	MOSTRAR ENTRADAS
	=============================================*/

	static public function ctrMostrarEntradas($item, $valor){

		$tabla = "entrada_productos";

		$respuesta = ModeloEntradas::mdlMostrarEntradas($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	CREAR ENTRADA
	=============================================*/

	static public function ctrCrearEntrada(){

		if(isset($_POST["nuevaEntrada"])){

			/*=============================================
			ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS
			=============================================*/

			if($_POST["listaProductos"] == ""){

					echo'<script>

				swal({
					  type: "error",
					  title: "El Ingreso no se ejecuta si no hay productos",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "entradas";

								}
							})

				</script>';

				return;
			}


			$listaProductos = json_decode($_POST["listaProductos"], true);

			$totalProductosComprados = array();

			foreach ($listaProductos as $key => $value) {

			   array_push($totalProductosComprados, $value["cantidad"]);
				
			   $tablaProductos = "productos";

			    $item = "id_producto";
			    $valor = $value["id"];
			    $orden = "id_producto";

			    $traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $orden);
				
				$item1a = "compras";
				$valor1a = $value["cantidad"] + $traerProducto["compras"];

			    $nuevasVentas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);

				$item1b = "stock";
				$valor1b = $value["stock"];
				
				$nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);

			}
			
			$tablaClientes = "proveedores";

			$item = "id_proveedor";
			$valor = $_POST["seleccionarCliente"];

			$traerProveedor = ModeloClientes::mdlMostrarClientes($tablaClientes, $item, $valor);

			$item1a = "compras";
				
			$valor1a = array_sum($totalProductosComprados) + $traerProveedor["compras"];

			$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valor);

			$item1b = "ultima_compra";

			date_default_timezone_set('America/Lima');

			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$valor1b = $fecha.' '.$hora;

			$fechaCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1b, $valor1b, $valor);

			
			
			/*=============================================
			GUARDAR LA COMPRA
			=============================================*/	

			$tabla = "entrada_productos";

			$datos = array("id_receptor"=>$_POST["idVendedor"],
						   "id_proveedor"=>$_POST["seleccionarCliente"],
						   "codigo"=>$_POST["nuevaEntrada"],
						   "productos"=>$_POST["listaProductos"],
						   "impuesto"=>$_POST["nuevoPrecioImpuesto"],
						   "neto"=>$_POST["nuevoPrecioNeto"],
						   "totalEntrada" => $_POST["totalVenta"]);

			$respuesta = ModeloEntradas::mdlIngresarEntrada($tabla, $datos);

			if($respuesta == "ok"){

				// $impresora = "epson20";

				// $conector = new WindowsPrintConnector($impresora);

				// $imprimir = new Printer($conector);

				// $imprimir -> text("Hola Mundo"."\n");

				// $imprimir -> cut();

				// $imprimir -> close();

				//$impresora = "Canon G3000 series Printer";

				//$conector = new WindowsPrintConnector($impresora);

				//$printer = new Printer($conector);

				//$printer -> setJustification(Printer::JUSTIFY_CENTER);

				//$printer -> text(date("Y-m-d H:i:s")."\n");//Fecha de la factura

				//$printer -> feed(1); //Alimentamos el papel 1 vez*/

				//$printer -> text("Inventory System"."\n");//Nombre de la empresa

				//$printer -> text("NIT: 71.759.963-9"."\n");//Nit de la empresa

				//$printer -> text("Dirección: Calle 44B 92-11"."\n");//Dirección de la empresa

				//$printer -> text("Teléfono: 300 786 52 49"."\n");//Teléfono de la empresa

				//$printer -> text("FACTURA N.".$_POST["nuevaVenta"]."\n");//Número de factura

				//$printer -> feed(1); //Alimentamos el papel 1 vez*/

				//$printer -> text("Cliente: ".$traerCliente["nombre"]."\n");//Nombre del cliente

				//$tablaVendedor = "usuarios";
				//$item = "id";
				//$valor = $_POST["idVendedor"];

			    //$traerVendedor = ModeloUsuarios::mdlMostrarUsuarios($tablaVendedor, $item, $valor);

				//$printer -> text("Vendedor: ".$traerVendedor["nombre"]."\n");//Nombre del vendedor

				//$printer -> feed(1); //Alimentamos el papel 1 vez*/

				//foreach ($listaProductos as $key => $value) {

					//$printer->setJustification(Printer::JUSTIFY_LEFT);

					//$printer->text($value["descripcion"]."\n");//Nombre del producto

					//$printer->setJustification(Printer::JUSTIFY_RIGHT);

					//$printer->text("$ ".number_format($value["precio"],2)." Und x ".$value["cantidad"]." = $ ".number_format($value["total"],2)."\n");

				//}

				//$printer -> feed(1); //Alimentamos el papel 1 vez*/			
				
				//$printer->text("NETO: $ ".number_format($_POST["nuevoPrecioNeto"],2)."\n"); //ahora va el neto

				//$printer->text("IMPUESTO: $ ".number_format($_POST["nuevoPrecioImpuesto"],2)."\n"); //ahora va el impuesto

				//$printer->text("--------\n");

				//$printer->text("TOTAL: $ ".number_format($_POST["totalVenta"],2)."\n"); //ahora va el total

				//$printer -> feed(1); //Alimentamos el papel 1 vez*/	

				//$printer->text("Muchas gracias por su compra"); //Podemos poner también un pie de página

				//$printer -> feed(3); //Alimentamos el papel 3 veces*/

				//$printer -> cut(); //Cortamos el papel, si la impresora tiene la opción

				//$printer -> pulse(); //Por medio de la impresora mandamos un pulso, es útil cuando hay cajón moneder

				//$printer -> close();

	
				echo'<script>

				localStorage.removeItem("rango");

				swal({
					  type: "success",
					  title: "El ingreso de productos se guardó correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "entradas";

								}
							})

				</script>';

			}

		}

	}

	/*=============================================
	EDITAR ENTRADA
	=============================================*/

	static public function ctrEditarEntrada(){

		if(isset($_POST["editarEntrada"])){

			/*=============================================
			FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
			=============================================*/
			$tabla = "entrada_productos";

			$item = "codigo_factura";
			$valor = $_POST["editarEntrada"];

			$traerEntrada = ModeloEntradas::mdlMostrarEntradas($tabla, $item, $valor);

			/*=============================================
			REVISAR SI VIENE PRODUCTOS EDITADOS
			=============================================
			*/

			if($_POST["listaProductos"] == $traerEntrada["productos"] && $traerEntrada["id_proveedor"] == $_POST["seleccionarCliente"]){

				$cambios = false;
				$proveedor = $traerEntrada["id_proveedor"];
				$listaProductos = $traerEntrada["productos"];
			}else{

				$cambios = true;

				if($_POST["listaProductos"] == $traerEntrada["productos"] ){
				
					$listaProductos = $traerEntrada["productos"];
					$cambioProducto = false;
					
				}else{
					
					$listaProductos = $_POST["listaProductos"];
					$cambioProducto = true;
					if($listaProductos == ""){
							
						echo'<script>
	
					swal({
						  type: "error",
						  title: "La edición no se ha ejecuta si no hay productos",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
	
									window.location = "entradas";
	
									}
								})
	
					</script>';
	
					return;
					}
				}
				if($traerEntrada["id_proveedor"] == $_POST["seleccionarCliente"]){
					$proveedor = $traerEntrada["id_proveedor"];
					$cambioProveedor = false;
				}else{
					$proveedor = $_POST["seleccionarCliente"];
					$cambioProveedor = true;
				}
				
				
			}

			if($cambios){

				$productos =  json_decode($traerEntrada["productos"], true);

				$totalProductosComprados = array();

				foreach ($productos as $key => $value) {

					array_push($totalProductosComprados, $value["cantidad"]);

					if($cambioProducto){
					$tablaProductos = "productos";

					$item = "id_producto";
					$valor = $value["id"];
					$orden = "id_producto";

					$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $orden);
					/*
					$item1a = "ventas";
					$valor1a = $traerProducto["ventas"] - $value["cantidad"];

					$nuevasVentas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);
					*/
					
					$item1b = "stock";
					$valor1b = $traerProducto["stock"] - $value["cantidad"];

					$nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);
				}
				}
				
				
				$tablaClientes = "proveedores";

				$itemCliente = "id_proveedor";
				$valorCliente = $traerEntrada["id_proveedor"];
				
				$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $itemCliente, $valorCliente);

				$item1a = "compras";
				$valor1a = $traerCliente["compras"] - array_sum($totalProductosComprados);		

				$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valorCliente);

			
				
				/*=============================================
				ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS
				=============================================*/

				$listaProductos_2 = json_decode($listaProductos, true);

				$totalProductosComprados_2 = array();

				foreach ($listaProductos_2 as $key => $value) {

					array_push($totalProductosComprados_2, $value["cantidad"]);
					
					$tablaProductos_2 = "productos";

					$item_2 = "id_producto";
					$valor_2 = $value["id"];
					$orden = "id_producto";

					$traerProducto_2 = ModeloProductos::mdlMostrarProductos($tablaProductos_2, $item_2, $valor_2, $orden);
					/*
					$item1a_2 = "ventas";
					$valor1a_2 = $value["cantidad"] + $traerProducto_2["ventas"];

					$nuevasVentas_2 = ModeloProductos::mdlActualizarProducto($tablaProductos_2, $item1a_2, $valor1a_2, $valor_2);
					*/
					if($cambioProducto){
					$item1b_2 = "stock";
					$valor1b_2 = $value["stock"];

					$nuevoStock_2 = ModeloProductos::mdlActualizarProducto($tablaProductos_2, $item1b_2, $valor1b_2, $valor_2);
					}
				}
				
				$tablaClientes_2 = "proveedores";

				$item_2 = "id_proveedor";
				$valor_2 = $proveedor;

				$traerCliente_2 = ModeloClientes::mdlMostrarClientes($tablaClientes_2, $item_2, $valor_2);

				$item1a_2 = "compras";

				$valor1a_2 = array_sum($totalProductosComprados_2) + $traerCliente_2["compras"];

				$comprasCliente_2 = ModeloClientes::mdlActualizarCliente($tablaClientes_2, $item1a_2, $valor1a_2, $valor_2);
				
				
				$item1b_2 = "ultima_compra";

				date_default_timezone_set('America/Lima');

				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$valor1b_2 = $fecha.' '.$hora;

				$fechaCliente_2 = ModeloClientes::mdlActualizarCliente($tablaClientes_2, $item1b_2, $valor1b_2, $valor_2);
			if($cambioProveedor){

			$tablaProveedores = "proveedores";

			$itemEntradas = null;
			$valorEntradas = null;

			$traerEntradas = ModeloEntradas::mdlMostrarEntradas($tabla, $itemEntradas, $valorEntradas);

			$guardarFechas = array();

			foreach ($traerEntradas as $key => $value) {
				
				if($value["id_proveedor"] == $traerEntrada["id_proveedor"] && $traerEntrada["codigo_factura"] != $value["codigo_factura"]){

					array_push($guardarFechas, $value["fecha"]);

				}

			}

			if(count($guardarFechas) > 0){

					$item = "ultima_compra";
					$valor = $guardarFechas[count($guardarFechas)-1];
					$valorIdCliente = $traerEntrada["id_proveedor"];

					$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaProveedores, $item, $valor, $valorIdCliente);

			}else{

				$item = "ultima_compra";
				$valor = "0000-00-00 00:00:00";
				$valorIdProveedor = $traerEntrada["id_proveedor"];

				$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaProveedores, $item, $valor, $valorIdProveedor);

			}
		}
			
			}
			/*=============================================
			GUARDAR CAMBIOS DE LA ENTRADA
			=============================================*/	

			$datos = array("id_receptor"=>$_POST["idVendedor"],
						   "id_proveedor"=>$proveedor,
						   "codigo"=>$_POST["editarEntrada"],
						   "productos"=>$listaProductos,
						   "totalEntrada" => $_POST["totalVenta"]);

			$respuesta = ModeloEntradas::mdlEditarEntrada($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				localStorage.removeItem("rango");

				swal({
					  type: "success",
					  title: "El Historial de Ingreso ha sido editada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then((result) => {
								if (result.value) {

								window.location = "entradas";

								}
							})

				</script>';

			}

		}

	}


	/*=============================================
	ELIMINAR VENTA
	=============================================*/

	static public function ctrEliminarEntrada(){

		if(isset($_GET["idEntrada"])){

			$tabla = "entrada_productos";

			$item = "id_ent_prod";
			$valor = $_GET["idEntrada"];

			$traerEntrada = ModeloEntradas::mdlMostrarEntradas($tabla, $item, $valor);

						/*=============================================
			VALIDAR SI HAY PRODUCTOS EN STOCK
			===============================================*/
			$productos = json_decode($traerEntrada["productos"], true);
			foreach ($productos as $key => $value) {
				$idProducto = $value["id"];
				$cantidad = $value["cantidad"];

				$tablaProductos = "productos";
				$item = "id_producto";
				$valor = $idProducto;
				$orden = "id_producto";
				$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $orden);
				$stockActual = $traerProducto["stock"]; 
				$stockFuturo = $stockActual - $cantidad;
				//echo "<script>alert('$stockFuturo')</script>";
				//echo "<script>alert('".$traerProducto["descripcion"]."')</script>";
				if($stockFuturo < 0){
					echo '<script>

					swal({
						type: "error",
						title: "No puede eliminar, porque no hay stock en productos",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
						}).then(function(result){
								  if (result.value) {
  
								  window.location = "entradas";
  
								  }
							  })
  
				  </script>';

				return;
				}
			}

			/*=============================================
			ACTUALIZAR FECHA ÚLTIMA COMPRA
			=============================================*/

			$tablaProveedores = "proveedores";

			$itemEntradas = null;
			$valorEntradas = null;

			$traerEntradas = ModeloEntradas::mdlMostrarEntradas($tabla, $itemEntradas, $valorEntradas);

			$guardarFechas = array();

			foreach ($traerEntradas as $key => $value) {
				
				if($value["id_proveedor"] == $traerEntrada["id_proveedor"]){

					array_push($guardarFechas, $value["fecha"]);

				}

			}

			if(count($guardarFechas) > 1){

				if($traerEntrada["fecha"] > $guardarFechas[count($guardarFechas)-2]){

					$item = "ultima_compra";
					$valor = $guardarFechas[count($guardarFechas)-2];
					$valorIdCliente = $traerEntrada["id_proveedor"];

					$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaProveedores, $item, $valor, $valorIdCliente);

				}else{

					$item = "ultima_compra";
					$valor = $guardarFechas[count($guardarFechas)-1];
					$valorIdCliente = $traerEntrada["id_proveedor"];

					$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaProveedores, $item, $valor, $valorIdCliente);

				}


			}else{

				$item = "ultima_compra";
				$valor = "0000-00-00 00:00:00";
				$valorIdProveedor = $traerEntrada["id_proveedor"];

				$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaProveedores, $item, $valor, $valorIdProveedor);

			}

			/*=============================================
			FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
			=============================================*/

			$productos =  json_decode($traerEntrada["productos"], true);

			$totalProductosComprados = array();

			foreach ($productos as $key => $value) {

				array_push($totalProductosComprados, $value["cantidad"]);
				
				$tablaProductos = "productos";

				$item = "id_producto";
				$valor = $value["id"];
				$orden = "id_producto";

				$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $orden);
				/*
				$item1a = "ventas";
				$valor1a = $traerProducto["ventas"] - $value["cantidad"];

				$nuevasVentas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);
				*/
				$item1b = "stock";
				$valor1b = $traerProducto["stock"] - $value["cantidad"];

				$nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);

			}

			$tablaClientes = "proveedores";

			$itemCliente = "id_proveedor";
			$valorCliente = $traerEntrada["id_proveedor"];

			$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $itemCliente, $valorCliente);

			$item1a = "compras";
			$valor1a = $traerCliente["compras"] - array_sum($totalProductosComprados);

			$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valorCliente);

			/*=============================================
			ELIMINAR VENTA
			=============================================*/

			$respuesta = ModeloEntradas::mdlEliminarEntrada($tabla, $_GET["idEntrada"]);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El Historial de Ingreso ha sido borrada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "entradas";

								}
							})

				</script>';

			}		
		}

	}

	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function ctrRangoFechasEntradas($fechaInicial, $fechaFinal){

		$tabla = "entrada_productos";

		$respuesta = ModeloEntradas::mdlRangoFechasEntradas($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
		
	}

	/*=============================================
	DESCARGAR EXCEL
	=============================================*/

	public function ctrDescargarReporte(){

		if(isset($_GET["reporte"])){

			$tabla = "entrada_productos";

			if(isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])){

				$ventas = ModeloEntradas::mdlRangoFechasEntradas($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"]);

			}else{

				$item = null;
				$valor = null;

				$ventas = ModeloEntradas::mdlMostrarEntradas($tabla, $item, $valor);

			}


			/*=============================================
			CREAMOS EL ARCHIVO DE EXCEL
			=============================================*/

			$Name = $_GET["reporte"].'.xls';

			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$Name.'"');
			header("Content-Transfer-Encoding: binary");
		
			echo utf8_decode("<table border='0'> 

					<tr> 
					<td style='font-weight:bold; border:1px solid black; text-align:center; vertical-align:middle; background:#222222; color:white;'>CÓDIGO</td> 
					<td style='font-weight:bold; border:1px solid black; text-align:center; vertical-align:middle; background:#222222; color:white;'>PROVEEDOR</td>
					<td style='font-weight:bold; border:1px solid black; text-align:center; vertical-align:middle; background:#222222; color:white;'>ENCARGADO DEL REGISTRO</td>
					<td style='font-weight:bold; border:1px solid black; text-align:center; vertical-align:middle; background:#222222; color:white;'>CANTIDAD ENTRANTE</td>
					<td style='font-weight:bold; border:1px solid black; text-align:center; vertical-align:middle; background:#222222; color:white;'>PRODUCTOS</td>
					<td style='font-weight:bold; border:1px solid black; text-align:center; vertical-align:middle; background:#222222; color:white;'>SUBTOTAL</td>
					<td style='font-weight:bold; border:1px solid black; text-align:center; vertical-align:middle; background:#222222; color:white;'>IMPUESTO</td>
					<td style='font-weight:bold; border:1px solid black; text-align:center; vertical-align:middle; background:#222222; color:white;'>NETO</td>
					<td style='font-weight:bold; border:1px solid black; text-align:center; vertical-align:middle; background:#222222; color:white;'>TOTAL</td>		
					<!--<td style='font-weight:bold; border:1px solid black; text-align:center; vertical-align:middle; background:#222222; color:white;'>METODO DE PAGO</td>-->	
					<td style='font-weight:bold; border:1px solid black; text-align:center; vertical-align:middle; background:#222222; color:white;'>FECHA</td>		
					</tr>");

			foreach ($ventas as $row => $item){

				$cliente = ControladorClientes::ctrMostrarClientes("id_proveedor", $item["id_proveedor"]);
				$vendedor = ControladorUsuarios::ctrMostrarUsuarios("id_usuario", $item["id_usuario"]);

				if(!$cliente){
					$nombreClient="";
				}else{
					$nombreClient=$cliente["nombre"];
				}

				if(!$vendedor){
					$nombreVende="";
				}else{
					$nombreVende=$vendedor["nombre"];
				}

			 echo utf8_decode("<tr>
			 			<td style='border:1px solid black; text-align:center; vertical-align:middle;'>".$item["codigo_factura"]."</td> 
			 			<td style='border:1px solid black; text-align:center; vertical-align:middle;'>".$nombreClient."</td>
			 			<td style='border:1px solid black; text-align:center; vertical-align:middle;'>".$nombreVende."</td>
			 			<td style='border:1px solid black; text-align:center; vertical-align:middle;'>");

			 	$productos =  json_decode($item["productos"], true);

			 	foreach ($productos as $key => $valueProductos) {
			 			
			 			echo utf8_decode($valueProductos["cantidad"]."<br>");
			 		}

			 	echo utf8_decode("</td><td style='border:1px solid black; text-align:center; vertical-align:middle;'>");	

		 		foreach ($productos as $key => $valueProductos) {
			 			
		 			echo utf8_decode($valueProductos["descripcion"]."<br>");
		 		
		 		}
				 echo utf8_decode("</td><td style='border:1px solid black; text-align:center; vertical-align:middle;'>");	
				 foreach ($productos as $key => $valueProductos) {
			 			
					echo utf8_decode("S/".$valueProductos["subtotal"]."<br>");
				
				}

		 		echo utf8_decode("</td>
				 <td style='border:1px solid black; text-align:center; vertical-align:middle;'>S/ ".number_format($item["impuesto"],2)."</td>
				 <td style='border:1px solid black; text-align:center; vertical-align:middle;'>S/ ".number_format($item["neto"],2)."</td>
					<td style='border:1px solid black; text-align:center; vertical-align:middle;'>S/ ".number_format($item["total"],2)."</td>
					<td style='border:1px solid black; text-align:center; vertical-align:middle;'>".substr($item["fecha"],0,10)."</td>		
		 			</tr>");


			}


			echo "</table>";

		}

	}


	/*=============================================
	SUMA TOTAL VENTAS
	=============================================*/

	public function ctrSumaTotalCompras(){

		$tabla = "entrada_productos";

		$respuesta = ModeloEntradas::mdlSumaTotalCompras($tabla);

		return $respuesta;

	}

	/*=============================================
	DESCARGAR XML
	=============================================*/

	/*
	static public function ctrDescargarXML(){

		if(isset($_GET["xml"])){


			$tabla = "ventas";
			$item = "codigo";
			$valor = $_GET["xml"];

			$ventas = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

			// PRODUCTOS

			$listaProductos = json_decode($ventas["productos"], true);

			// CLIENTE

			$tablaClientes = "clientes";
			$item = "id";
			$valor = $ventas["id_cliente"];

			$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $item, $valor);

			// VENDEDOR

			$tablaVendedor = "usuarios";
			$item = "id";
			$valor = $ventas["id_vendedor"];

			$traerVendedor = ModeloUsuarios::mdlMostrarUsuarios($tablaVendedor, $item, $valor);

			//http://php.net/manual/es/book.xmlwriter.php

			$objetoXML = new XMLWriter();

			$objetoXML->openURI($_GET["xml"].".xml"); //Creación del archivo XML

			$objetoXML->setIndent(true); //recibe un valor booleano para establecer si los distintos niveles de nodos XML deben quedar indentados o no.

			$objetoXML->setIndentString("\t"); // carácter \t, que corresponde a una tabulación

			$objetoXML->startDocument('1.0', 'utf-8');// Inicio del documento
			
			// $objetoXML->startElement("etiquetaPrincipal");// Inicio del nodo raíz

			// $objetoXML->writeAttribute("atributoEtiquetaPPal", "valor atributo etiqueta PPal"); // Atributo etiqueta principal

			// 	$objetoXML->startElement("etiquetaInterna");// Inicio del nodo hijo

			// 		$objetoXML->writeAttribute("atributoEtiquetaInterna", "valor atributo etiqueta Interna"); // Atributo etiqueta interna

			// 		$objetoXML->text("Texto interno");// Inicio del nodo hijo
			
			// 	$objetoXML->endElement(); // Final del nodo hijo
			
			// $objetoXML->endElement(); // Final del nodo raíz


			$objetoXML->writeRaw('<fe:Invoice xmlns:fe="http://www.dian.gov.co/contratos/facturaelectronica/v1" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:clm54217="urn:un:unece:uncefact:codelist:specification:54217:2001" xmlns:clm66411="urn:un:unece:uncefact:codelist:specification:66411:2001" xmlns:clmIANAMIMEMediaType="urn:un:unece:uncefact:codelist:specification:IANAMIMEMediaType:2003" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2" xmlns:qdt="urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2" xmlns:sts="http://www.dian.gov.co/contratos/facturaelectronica/v1/Structures" xmlns:udt="urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.dian.gov.co/contratos/facturaelectronica/v1 ../xsd/DIAN_UBL.xsd urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2 ../../ubl2/common/UnqualifiedDataTypeSchemaModule-2.0.xsd urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2 ../../ubl2/common/UBL-QualifiedDatatypes-2.0.xsd">');

			$objetoXML->writeRaw('<ext:UBLExtensions>');

			foreach ($listaProductos as $key => $value) {
				
				$objetoXML->text($value["descripcion"].", ");
			
			}

			

			$objetoXML->writeRaw('</ext:UBLExtensions>');

			$objetoXML->writeRaw('</fe:Invoice>');

			$objetoXML->endDocument(); // Final del documento

			return true;	
		}

	}
*/
}