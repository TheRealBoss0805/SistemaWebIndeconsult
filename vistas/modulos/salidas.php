<?php

if($_SESSION["perfil"] == "Especial"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}
/*
$xml = ControladorVentas::ctrDescargarXML();

if($xml){

  rename($_GET["xml"].".xml", "xml/".$_GET["xml"].".xml");

  echo '<a class="btn btn-block btn-success abrirXML" archivo="xml/'.$_GET["xml"].'.xml" href="ventas">Se ha creado correctamente el archivo XML <span class="fa fa-times pull-right"></span></a>';

}
*/
?>
<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      <b>HISTORIAL DE SALIDA DE PRODUCTOS</b>
    
    </h1>

    <ol class="breadcrumb">
      
    <li><a href="inicio"><i class="fa fa-dashboard"></i><b>INICIO</b></a></li>
      
      <li class="active"><b>HISTORIAL DE SALIDA DE PRODUCTOS</b></li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
        <?php
        if ($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Empleado"){
          echo '
        <a href="crear-salida">

          <button class="btn btn-primary">
            
            Registrar salida de productos

          </button>

        </a>';
        }
        ?>

         <button type="button" class="btn btn-default pull-right" id="daterange-btn">
           
            <span>
              <i class="fa fa-calendar"></i> 

              <?php
                if(isset($_GET["fechaInicial"])){

                  echo $_GET["fechaInicial"]." - ".$_GET["fechaFinal"];
                
                }else{
                 
                  echo 'Rango de fecha';

                }
              ?>
            </span>

            <i class="fa fa-caret-down"></i>

         </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Código Salida</th>
           <th>Área</th>
           <th>Encargado del registro</th>
           <th>Fecha</th>
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

          if(isset($_GET["fechaInicial"])){

            $fechaInicial = $_GET["fechaInicial"];
            $fechaFinal = $_GET["fechaFinal"];

          }else{

            $fechaInicial = null;
            $fechaFinal = null;

          }

          $respuesta = ControladorSalidas::ctrRangoFechasSalidas($fechaInicial, $fechaFinal);

          foreach ($respuesta as $key => $value) {
           
           echo '<tr>

                  <td>'.($key+1).'</td>

                  <td>'.$value["codigo"].'</td>';

                  $itemCliente = "id_area";
                  $valorCliente = $value["id_area"];
                  
                  //$respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);
                  $respuestaArea= ControladorAreas::ctrMostrarAreas($itemCliente, $valorCliente);
                  //var_dump($respuestaCliente);
                  /*
                  if($respuestaCliente==""){
                    $respuestaCliente=="";
                    echo '<td>'.$respuestaCliente.'</td>';
                  }else{
                    $nombreCliente=$respuestaCliente["nombre"];
                    echo '<td>'.$nombreCliente.'</td>';
                  }*/
                  if(!$respuestaArea){
                    $nombreCliente="El cliente fue eliminado!!";
                  }else{
                    $nombreCliente=$respuestaArea["area"];
                  }
                  echo '<td>'.$nombreCliente.'</td>';

                  $itemUsuario = "id_usuario";
                  $valorUsuario = $value["id_usuario"];

                  $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);
                    if(!$respuestaUsuario){
                      $nombreUsuario="El usuario fue eliminado!!";
                    }else{
                      $nombreUsuario=$respuestaUsuario["nombre"];
                    }
                  echo '<td>'.$nombreUsuario.'</td>

                  <td>'.$value["fecha"].'</td>

                  <td>

                    <div class="btn-group">

                      <a class="btn btn-success" href="index.php?ruta=detalle-salidas&codigoSalida='.$value["codigo"].'"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
                        
                      <button class="btn btn-info btnImprimirFactura" codigoVenta="'.$value["codigo"].'">

                        <i class="fa fa-print"></i>

                      </button>';

                      if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Empleado"){

                      echo '<button class="btn btn-warning btnEditarSalida" idSalida="'.$value["id_salidaprod"].'"><i class="fa fa-pencil"></i></button>

                      <button class="btn btn-danger btnEliminarSalida" idSalida="'.$value["id_salidaprod"].'"><i class="fa fa-times"></i></button>';

                    }

                    echo '</div>  

                  </td>

                </tr>';
            }

        ?>
               
        </tbody>

       </table>

       <?php

      $eliminarSalida = new ControladorSalidas();
      $eliminarSalida -> ctrEliminarSalida();

      ?>
       

      </div>

    </div>

  </section>

</div>




