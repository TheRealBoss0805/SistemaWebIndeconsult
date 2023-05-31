<?php

require_once "../../controladores/salidas.controlador.php";
require_once "../../controladores/areas.controlador.php";
require_once "../../modelos/salidas.modelo.php";
require_once "../../controladores/usuarios.controlador.php";
require_once "../../modelos/usuarios.modelo.php";
require_once "../../modelos/areas.modelo.php";

$reporte = new ControladorSalidas();
$reporte -> ctrDescargarReporte();