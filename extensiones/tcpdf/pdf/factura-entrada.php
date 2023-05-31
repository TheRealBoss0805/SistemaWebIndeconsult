<?php

require_once "../../../controladores/entradas.controlador.php";
require_once "../../../modelos/entradas.modelo.php";

require_once "../../../controladores/clientes.controlador.php";
require_once "../../../modelos/clientes.modelo.php";

require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";

require_once "../../../controladores/productos.controlador.php";
require_once "../../../modelos/productos.modelo.php";

class imprimirFactura{

public $codigo;

public function traerImpresionFactura(){

//TRAEMOS LA INFORMACIÓN DE LA VENTA

$itemVenta = "codigo_factura";
$valorVenta = $this->codigo;

$respuestaEntrada = ControladorEntradas::ctrMostrarEntradas($itemVenta, $valorVenta);

$fecha = substr($respuestaEntrada["fecha"],0,-8);
$productos = json_decode($respuestaEntrada["productos"], true);
$neto = number_format($respuestaEntrada["neto"],2);
$impuesto = number_format($respuestaEntrada["impuesto"],2);
$total = number_format($respuestaEntrada["total"],2);

//TRAEMOS LA INFORMACIÓN DEL CLIENTE

$itemCliente = "id_proveedor";
$valorCliente = $respuestaEntrada["id_proveedor"];

$respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);
$nombreCliente=$respuestaCliente;
$telefonoCliente=$respuestaCliente;
$emailCliente=$respuestaCliente;
$rucCliente=$respuestaCliente;

if($respuestaCliente==""){
	$nombreCliente="";
}
else{
	$nombreCliente=$respuestaCliente["nombre"];
}

if($respuestaCliente==""){
	$telefonoCliente="";
}
else{
	$telefonoCliente=$respuestaCliente["telefono"];
}

if($respuestaCliente==""){
	$emailCliente="";
}
else{
	$emailCliente=$respuestaCliente["email"];
}

if($respuestaCliente==""){
	$rucCliente="";
}else{
	$rucCliente=$respuestaCliente["ruc"];
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
		<td style="width:160px">
			<div>
				<br>		
				<b style="text-align:center">INGRESO DE PRODUCTOS</b>
				<br>
				<br>
				Proveedor: $nombreCliente
				<br>
				Ruc: $rucCliente
				<br>
				Teléfono: $telefonoCliente
				<br>
				Correo: $emailCliente
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

$valorUnitario = number_format($item["precio"], 2);

$precioTotal = number_format($item["subtotal"], 2);

$bloque2 = <<<EOF

<table style="font-size:6.5px">
	<tr>
		<td style="width:160px; text-align:left">
		<i>$item[descripcion]</i>
		</td>
	</tr>
	<tr>
		<td style="width:160px; text-align:right; font-size:8px">
		S/ $valorUnitario x $item[cantidad]  = S/ $precioTotal
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
	
		<td style="width:80px; text-align:left">
			 Neto: 
		</td>

		<td style="width:80px;">
			S/ $neto
		</td>

	</tr>

	<tr>
	
		<td style="width:80px; text-align:left">
			 Impuesto: 
		</td>

		<td style="width:80px;">
			S/ $impuesto
		</td>

	</tr>
	<tr>
		<td style="width:160px;">
			 -------------------------------------------------
		</td>
	</tr>
	<tr>
		<td style="width:80px; text-align:left">
			 <b>TOTAL:</b>
		</td>
		<td style="width:80px;">
			<b>S/ $total</b>
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