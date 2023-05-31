<?php

require_once "../../controladores/entradas.controlador.php";
require_once "../../modelos/entradas.modelo.php";
require_once "../../controladores/clientes.controlador.php";
require_once "../../modelos/clientes.modelo.php";
require_once "../../controladores/usuarios.controlador.php";
require_once "../../modelos/usuarios.modelo.php";

$reporte = new ControladorEntradas();
$reporte -> ctrDescargarReporte();