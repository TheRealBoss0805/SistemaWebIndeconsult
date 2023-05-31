<?php

require_once "../controladores/areas.controlador.php";
require_once "../modelos/areas.modelo.php";

class AjaxAreas{

	/*=============================================
	EDITAR AREA
	=============================================*/	

	public $idArea;

	public function ajaxEditarArea(){

		$item = "id_area";
		$valor = $this->idArea;

		$respuesta = ControladorAreas::ctrMostrarAreas($item, $valor);

		echo json_encode($respuesta);

	}
	/*=============================================
	VALIDAR NO REPETIR AREA
	=============================================*/	

	public $validarArea;

	public function ajaxValidarArea(){

		$item = "area";
		$valor = $this->validarArea;

		$respuesta = ControladorAreas::ctrMostrarAreas($item, $valor);

		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR AREA
=============================================*/	
if(isset($_POST["idArea"])){

	$area = new AjaxAreas();
	$area -> idArea = $_POST["idArea"];
	$area -> ajaxEditarArea();
}

/*=============================================
VALIDAR NO REPETIR AREA
=============================================*/

if(isset( $_POST["validarArea"])){

	$valArea = new AjaxAreas();
	$valArea -> validarArea = $_POST["validarArea"];
	$valArea -> ajaxValidarArea();

}