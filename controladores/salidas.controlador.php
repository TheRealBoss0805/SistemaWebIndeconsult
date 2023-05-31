<?php

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class ControladorSalidas
{

	/*=============================================
	MOSTRAR VENTAS
	=============================================*/

	static public function ctrMostrarSalida($item, $valor)
	{

		$tabla = "salida_productos";

		$respuesta = ModeloSalidas::mdlMostrarSalidas($tabla, $item, $valor);

		return $respuesta;
	}

	/*=============================================
	CREAR VENTA
	=============================================*/

	static public function ctrCrearSalida()
	{

		if (isset($_POST["nuevaSalida"])) {

			/*=============================================
			ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS
			=============================================*/

			if ($_POST["listaProductos"] == "") {

				echo '<script>

				swal({
					  type: "error",
					  title: "La salida no se ha ejecuta si no hay productos",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "salidas";

								}
							})

				</script>';

				return;
			}


			$listaProductos = json_decode($_POST["listaProductos"], true);

			//$totalProductosComprados = array();

			foreach ($listaProductos as $key => $value) {

				//array_push($totalProductosComprados, $value["cantidad"]);

				$tablaProductos = "productos";

				$item = "id_producto";
				$valor = $value["id"];
				$orden = "id_producto";

				$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $orden);

				$item1b = "stock";
				$valor1b = $value["stock"];

				$nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);
			}
			/*
			$tablaClientes = "clientes";

			$item = "id";
			$valor = $_POST["seleccionarCliente"];

			$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $item, $valor);

			$item1a = "compras";
				
			$valor1a = array_sum($totalProductosComprados) + $traerCliente["compras"];

			$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valor);
*//*
			$item1b = "ultima_compra";

			date_default_timezone_set('America/Lima');

			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$valor1b = $fecha.' '.$hora;

			$fechaCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1b, $valor1b, $valor);
*/
			/*=============================================
			GUARDAR LA COMPRA
			=============================================*/

			$tabla = "salida_productos";

			$datos = array(
				"id_usuario" => $_POST["idUsuario"],
				"id_area" => $_POST["seleccionarArea"],
				"codigo" => $_POST["nuevaSalida"],
				"productos" => $_POST["listaProductos"],
			);

			$respuesta = ModeloSalidas::mdlIngresarSalida($tabla, $datos);

			if ($respuesta == "ok") {


				echo '<script>

				localStorage.removeItem("rango");

				swal({
					  type: "success",
					  title: "Salida de Productos creada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "salidas";

								}
							})

				</script>';
			}
		}
	}

	/*=============================================
	EDITAR VENTA
	=============================================*/

	static public function ctrEditarSalida()
	{

		if (isset($_POST["editarSalida"])) {

			/*=============================================
			FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
			=============================================*/
			$tabla = "salida_productos";

			$item = "codigo";
			$valor = $_POST["editarSalida"];

			$traerSalida = ModeloSalidas::mdlMostrarSalidas($tabla, $item, $valor);
			/*=============================================
			REVISAR SI VIENE PRODUCTOS EDITADOS
			=============================================
			*/

			if ($_POST["listaProductos"] == $traerSalida["productos"] && $traerSalida["id_area"] == $_POST["seleccionarArea"]) {

				$cambios = false;
				$area = $traerSalida["id_area"];
				$listaProductos = $traerSalida["productos"];
			} else {

				$cambios = true;

				if ($_POST["listaProductos"] == $traerSalida["productos"]) {

					$listaProductos = $traerSalida["productos"];
					$cambioProducto = false;
				} else {

					$listaProductos = $_POST["listaProductos"];
					$cambioProducto = true;
					if ($listaProductos == "") {

						echo '<script>
	
					swal({
						  type: "error",
						  title: "La edición no se ha ejecuta si no hay productos",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
	
									window.location = "salidas";
	
									}
								})
	
					</script>';

						return;
					}
				}
				if ($traerSalida["id_area"] == $_POST["seleccionarArea"]) {
					$area = $traerSalida["id_area"];
					$cambioArea = false;
				} else {
					$area = $_POST["seleccionarArea"];
					$cambioArea = true;
				}
			}

			if ($cambios) {

				$productos =  json_decode($traerSalida["productos"], true);

				//$totalProductosComprados = array();

				foreach ($productos as $key => $value) {

					//array_push($totalProductosComprados, $value["cantidad"]);

					if ($cambioProducto) {
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
						$valor1b = $traerProducto["stock"] + $value["cantidad"];

						$nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);
					}
				}


				$tablaAreas = "areas";

				$itemAreas = "id_area";
				$valorAreas = $traerSalida["id_area"];

				$traerArea = ModeloClientes::mdlMostrarClientes($tablaAreas, $itemAreas, $valorAreas);
				/*
				$item1a = "compras";
				$valor1a = $traerArea["compras"] - array_sum($totalProductosComprados);		

				$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaAreas, $item1a, $valor1a, $valorAreas);

			*/

				/*=============================================
				ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS
				=============================================*/

				$listaProductos_2 = json_decode($listaProductos, true);

				//$totalProductosComprados_2 = array();

				foreach ($listaProductos_2 as $key => $value) {

					//array_push($totalProductosComprados_2, $value["cantidad"]);

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
					if ($cambioProducto) {
						$item1b_2 = "stock";
						$valor1b_2 = $value["stock"];

						$nuevoStock_2 = ModeloProductos::mdlActualizarProducto($tablaProductos_2, $item1b_2, $valor1b_2, $valor_2);
					}
				}
				/*
				$tablaAreas_2 = "areas";

				$item_2 = "id_area";
				$valor_2 = $area;

				$traerArea_2 = Modelo::mdlMostrarClientes($tablaAreas_2, $item_2, $valor_2);

				$item1a_2 = "compras";

				$valor1a_2 = array_sum($totalProductosComprados_2) + $traerArea_2["compras"];

				$comprasCliente_2 = ModeloClientes::mdlActualizarCliente($tablaAreas_2, $item1a_2, $valor1a_2, $valor_2);
				*/
				/*
				$item1b_2 = "ultima_compra";

				date_default_timezone_set('America/Lima');

				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$valor1b_2 = $fecha.' '.$hora;

				$fechaCliente_2 = ModeloClientes::mdlActualizarCliente($tablaAreas_2, $item1b_2, $valor1b_2, $valor_2);*/
			}
			/*=============================================
			GUARDAR CAMBIOS DE LA ENTRADA
			=============================================*/

			$datos = array(
				"id_usuario" => $_POST["idVendedor"],
				"id_area" => $area,
				"codigo" => $_POST["editarSalida"],
				"productos" => $listaProductos
			);

			$respuesta = ModeloSalidas::mdlEditarSalida($tabla, $datos);

			if ($respuesta == "ok") {

				echo '<script>

				localStorage.removeItem("rango");

				swal({
					  type: "success",
					  title: "El Historial de Salida ha sido editada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then((result) => {
								if (result.value) {

								window.location = "salidas";

								}
							})

				</script>';
			}
		}
	}


	/*=============================================
	ELIMINAR VENTA
	=============================================*/

	static public function ctrEliminarSalida()
	{

		if (isset($_GET["idSalida"])) {

			$tabla = "salida_productos";

			$item = "id_salidaprod";
			$valor = $_GET["idSalida"];

			$traerSalida = ModeloSalidas::mdlMostrarSalidas($tabla, $item, $valor);

			/*=============================================
			ACTUALIZAR FECHA ÚLTIMA COMPRA
			=============================================*/
			/*
			$tablaClientes = "clientes";

			$itemVentas = null;
			$valorVentas = null;

			$traerVentas = ModeloSalidas::mdlMostrarSalidas($tabla, $itemVentas, $valorVentas);

			$guardarFechas = array();

			foreach ($traerVentas as $key => $value) {
				
				if($value["id_cliente"] == $traerVenta["id_cliente"]){

					array_push($guardarFechas, $value["fecha"]);

				}

			}

			if(count($guardarFechas) > 1){

				if($traerVenta["fecha"] > $guardarFechas[count($guardarFechas)-2]){

					$item = "ultima_compra";
					$valor = $guardarFechas[count($guardarFechas)-2];
					$valorIdCliente = $traerVenta["id_cliente"];

					$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorIdCliente);

				}else{

					$item = "ultima_compra";
					$valor = $guardarFechas[count($guardarFechas)-1];
					$valorIdCliente = $traerVenta["id_cliente"];

					$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorIdCliente);

				}


			}else{

				$item = "ultima_compra";
				$valor = "0000-00-00 00:00:00";
				$valorIdCliente = $traerVenta["id_cliente"];

				$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorIdCliente);

			}
*/
			/*=============================================
			FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
			=============================================*/

			$productos =  json_decode($traerSalida["productos"], true);

			//$totalProductosComprados = array();

			foreach ($productos as $key => $value) {

				//array_push($totalProductosComprados, $value["cantidad"]);

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
				$valor1b = $value["cantidad"] + $traerProducto["stock"];

				$nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);
			}
			/*
			$tablaClientes = "clientes";

			$itemCliente = "id";
			$valorCliente = $traerSalida["id_area"];

			$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $itemCliente, $valorCliente);

			$item1a = "compras";
			$valor1a = $traerCliente["compras"] - array_sum($totalProductosComprados);

			$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valorCliente);
*/
			/*=============================================
			ELIMINAR VENTA
			=============================================*/

			$respuesta = ModeloSalidas::mdlEliminarSalida($tabla, $_GET["idSalida"]);

			if ($respuesta == "ok") {

				echo '<script>

				swal({
					  type: "success",
					  title: "El Historial de Salida ha sido borrada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "salidas";

								}
							})

				</script>';
			}
		}
	}

	/*=============================================
	RANGO FECHAS
	=============================================*/

	static public function ctrRangoFechasSalidas($fechaInicial, $fechaFinal)
	{

		$tabla = "salida_productos";

		$respuesta = ModeloSalidas::mdlRangoFechasSalidas($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
	}

	/*=============================================
	DESCARGAR EXCEL
	=============================================*/

	public function ctrDescargarReporte()
	{

		if (isset($_GET["reporte"])) {

			$tabla = "salida_productos";

			if (isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])) {

				$ventas = ModeloSalidas::mdlRangoFechasSalidas($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"]);
			} else {

				$item = null;
				$valor = null;

				$ventas = ModeloSalidas::mdlMostrarSalidas($tabla, $item, $valor);
			}


			/*=============================================
			CREAMOS EL ARCHIVO DE EXCEL
			=============================================*/

			$Name = $_GET["reporte"] . '.xls';

			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate");
			header('Content-Description: File Transfer');
			header('Last-Modified: ' . date('D, d M Y H:i:s'));
			header("Pragma: public");
			header('Content-Disposition:; filename="' . $Name . '"');
			header("Content-Transfer-Encoding: binary");

			echo utf8_decode("<table border='0'> 

					<tr> 
					<td style='font-weight:bold; border:1px solid black; text-align:center; vertical-align:middle; background:#222222; color:white;'>CÓDIGO</td> 
					<td style='font-weight:bold; border:1px solid black; text-align:center; vertical-align:middle; background:#222222; color:white;'>ÁREA</td>
					<td style='font-weight:bold; border:1px solid black; text-align:center; vertical-align:middle; background:#222222; color:white;'>ENCARGADO DEL REGISTRO</td>
					<td style='font-weight:bold; border:1px solid black; text-align:center; vertical-align:middle; background:#222222; color:white;'>CANTIDAD SALIENTE</td>
					<td style='font-weight:bold; border:1px solid black; text-align:center; vertical-align:middle; background:#222222; color:white;'>PRODUCTOS</td>
					<td style='font-weight:bold; border:1px solid black; text-align:center; vertical-align:middle; background:#222222; color:white;'>FECHA</td>		
					</tr>");
					
			foreach ($ventas as $row => $item) {

				$cliente = ControladorAreas::ctrMostrarAreas("id_area", $item["id_area"]);
				$vendedor = ControladorUsuarios::ctrMostrarUsuarios("id_usuario", $item["id_usuario"]);

				if (!$cliente) {
					$nombreClient = "";
				} else {
					$nombreClient = $cliente["area"];
				}

				if (!$vendedor) {
					$nombreVende = "";
				} else {
					$nombreVende = $vendedor["nombre"];
				}

				echo utf8_decode("<tr>
			 			<td style='border:1px solid black; text-align:center; vertical-align:middle;'>" . $item["codigo"] . "</td> 
			 			<td style='border:1px solid black; text-align:center; vertical-align:middle;'>" . $nombreClient . "</td>
			 			<td style='border:1px solid black; text-align:center; vertical-align:middle;'>" . $nombreVende . "</td>
			 			<td style='border:1px solid black; text-align:center; vertical-align:middle;'>");

				$productos =  json_decode($item["productos"], true);

				foreach ($productos as $key => $valueProductos) {

					echo utf8_decode($valueProductos["cantidad"] . "<br>");
				}

				echo utf8_decode("</td><td style='border:1px solid black; text-align:center; vertical-align:middle;'>");

				foreach ($productos as $key => $valueProductos) {

					echo utf8_decode($valueProductos["descripcion"] . "<br>");
				}

				echo utf8_decode("</td>
					<td style='border:1px solid black; text-align:center; vertical-align:middle;'>" . substr($item["fecha"], 0, 10) . "</td>		
		 			</tr>");
			}


			echo "</table>";
		}
	}


	/*=============================================
	SUMA TOTAL VENTAS
	=============================================*/

	public function ctrSumaTotalVentas()
	{

		$tabla = "salida_productos";

		$respuesta = ModeloSalidas::mdlSumaTotalSalidas($tabla);

		return $respuesta;
	}

	/*=============================================
	DESCARGAR XML
	=============================================*/
	/*
	static public function ctrDescargarXML(){

		if(isset($_GET["xml"])){


			$tabla = "salida_productos";
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
