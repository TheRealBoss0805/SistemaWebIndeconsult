<?php

require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";

class AjaxClientes{

	/*=============================================
	EDITAR CLIENTE
	=============================================*/	

	public $idCliente;

	public function ajaxEditarCliente(){

		$item = "id_proveedor";
		$valor = $this->idCliente;

		$respuesta = ControladorClientes::ctrMostrarClientes($item, $valor);

		echo json_encode($respuesta);


	}

	/*=============================================
	VALIDAR NO REPETIR PROVEEDOR
	=============================================*/	

	public $validarProveedor;

	public function ajaxValidarProveedor(){

		$item = "ruc";
		$valor = $this->validarProveedor;

		$respuesta = ControladorClientes::ctrMostrarClientes($item, $valor);

		echo json_encode($respuesta);

	}
/*=============================================
	TRAER DATOS CON API RUC
	=============================================*/	

	public $datosProveedor;

	public function ajaxdatosProveedor(){

		$ruc = $this->datosProveedor;

		// Datos
$token = 'apis-token-1.aTSI1U7KEuT-6bbbCguH-4Y8TI6KS73N';


// Iniciar llamada a API
$curl = curl_init();

// Buscar ruc sunat
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.apis.net.pe/v1/ruc?numero=' . $ruc,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Referer: http://apis.net.pe/api-ruc',
    'Authorization: Bearer ' . $token
  ),
));

$respuesta = curl_exec($curl);

curl_close($curl);
// Datos de empresas según padron reducido
//$empresa = json_decode($response);
//var_dump($empresa);

		echo $respuesta;

	}
}


/*=============================================
EDITAR CLIENTE
=============================================*/	

if(isset($_POST["idCliente"])){

	$cliente = new AjaxClientes();
	$cliente -> idCliente = $_POST["idCliente"];
	$cliente -> ajaxEditarCliente();

}

/*=============================================
VALIDAR NO REPETIR PROVEEDOR
=============================================*/

if(isset( $_POST["validarProveedor"])){

	$valProveedor = new AjaxClientes();
	$valProveedor -> validarProveedor = $_POST["validarProveedor"];
	$valProveedor -> ajaxValidarProveedor();

}

/*=============================================
API RUC
=============================================*/

if(isset( $_POST["datosProveedor"])){

	$datosProveedor = new AjaxClientes();
	$datosProveedor -> datosProveedor = $_POST["datosProveedor"];
	$datosProveedor -> ajaxdatosProveedor();

}
