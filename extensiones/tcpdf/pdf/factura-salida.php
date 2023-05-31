<?php

require_once "../../../controladores/salidas.controlador.php";
require_once "../../../modelos/salidas.modelo.php";

require_once "../../../controladores/areas.controlador.php";
require_once "../../../modelos/areas.modelo.php";

require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";

require_once "../../../controladores/productos.controlador.php";
require_once "../../../modelos/productos.modelo.php";

class imprimirFactura{

public $codigo;

public function traerImpresionFactura(){

//TRAEMOS LA INFORMACIÓN DE LA VENTA

$itemVenta = "codigo";
$valorVenta = $this->codigo;

$respuestaEntrada = ControladorSalidas::ctrMostrarSalida($itemVenta, $valorVenta);

$fecha = substr($respuestaEntrada["fecha"],0,-8);
$productos = json_decode($respuestaEntrada["productos"], true);


//TRAEMOS LA INFORMACIÓN DEL CLIENTE

$itemCliente = "id_area";
$valorCliente = $respuestaEntrada["id_area"];

$respuestaCliente = ControladorAreas::ctrMostrarAreas($itemCliente, $valorCliente);
$nombreCliente=$respuestaCliente;
if($respuestaCliente==""){
	$nombreCliente="";
}else{
	$nombreCliente=$respuestaCliente["area"];
}

//TRAEMOS LA INFORMACIÓN DEL VENDEDOR

$itemVendedor = "id_usuario";
$valorVendedor = $respuestaEntrada["id_usuario"];

$respuestaVendedor = ControladorUsuarios::ctrMostrarUsuarios($itemVendedor, $valorVendedor);

//REQUERIMOS LA CLASE TCPDF

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage('P', 'A7');

//---------------------------------------------------------
$bloque0 = <<<EOF

<table style="font-size:8px; text-align:right">
	<tr>
		<td style="width:80px; text-align:left">
			 <i>$fecha</i>
		</td>
		<td style="width:80px;">
			<i>Factura N°: $valorVenta</i>
		</td>
	</tr>
</table>

EOF;

$pdf->writeHTML($bloque0, false, false, false, false, '');

// ---------------------------------------------------------

$bloque1 = <<<EOF

<table style="font-size:8px; text-align:left">
	<tr>	
		<td style="width:160px;">
			<div>
				<br>
				<b style="text-align:center">SALIDA DE PRODUCTOS</b>
				<br>
				<br>		
				Área de destino: $nombreCliente
				<br>
				<span style="text-align:right"><i>Encargado: $respuestaVendedor[nombre]</i></span>
				<br>
				<span style="text-align:center">--------------------------------------------------------</span>
			</div>
		</td>
	</tr>
</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

// ---------------------------------------------------------


foreach ($productos as $key => $item) {

$bloque2 = <<<EOF

<table style="font-size:6.5px;">
	<tr>
		<td style="width:160px; text-align:left">
		<i>$item[descripcion]</i>
		</td>
	</tr>
	<tr>
		<td style="width:160px; text-align:right">
		Cantidad remitida: $item[cantidad]
		<br>
		</td>
	</tr>
</table>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

}

// ---------------------------------------------------------

$bloque3 = <<<EOF

<table style="font-size:9px; text-align:right">
	<tr>
		<td style="width:160px;">
		<br>
		<span style="text-align:center">---------------------------------------------------</span>
		</td>
	</tr>
	<tr>
		<td style="width:160px;">
			<br>
			<br>
		</td>
	</tr>
</table>



EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

// ---------------------------------------------------------
//SALIDA DEL ARCHIVO 

//$pdf->Output('factura.pdf', 'D');
$pdf->Output('factura.pdf');

}

}

$factura = new imprimirFactura();
$factura -> codigo = $_GET["codigo"];
$factura -> traerImpresionFactura();

?>