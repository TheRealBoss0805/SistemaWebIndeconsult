<?php

if(!isset($_GET["codigoSalida"])){

  echo '<script>

    window.location = "salidas";

  </script>';

  return;

}

//$xml = ControladorVentas::ctrDescargarXML();
/*
if($xml){

  rename($_GET["xml"].".xml", "xml/".$_GET["xml"].".xml");

  echo '<a class="btn btn-block btn-success abrirXML" archivo="xml/'.$_GET["xml"].'.xml" href="ventas">Se ha creado correctamente el archivo XML <span class="fa fa-times pull-right"></span></a>';

}
*/
?>
<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      <b>DETALLE DE SALIDAS</b>
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i><b>Inicio</b></a></li>
      
      <li class="active"><b>DETALLE DE SALIDAS</b></li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <a href="salidas">

          <button class="btn btn-primary">
            
            Volver

          </button>

        </a>

  <!--       <button type="button" class="btn btn-default pull-right" id="daterange-btn">
           
            <span>
              <i class="fa fa-calendar"></i> 

              <?php

               /* if(isset($_GET["fechaInicial"])){

                  echo $_GET["fechaInicial"]." - ".$_GET["fechaFinal"];
                
                }else{
                 
                  echo 'Rango de fecha';

                }
                  */
              ?>
            </span> -->

            <!--<i class="fa fa-caret-down"></i>

         </button>-->

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Código factura</th>
           <th>Producto</th>
           <th>Cantidad</th>
           
         </tr> 

        </thead>

        <tbody>

        <?php
          /*
          if(isset($_GET["fechaInicial"])){

            $fechaInicial = $_GET["fechaInicial"];
            $fechaFinal = $_GET["fechaFinal"];

          }else{

            $fechaInicial = null;
            $fechaFinal = null;

          }*/
          $item = "codigo";
          $valor =$_GET["codigoSalida"];
          $respuesta = ControladorSalidas::ctrMostrarSalida($item, $valor);
          $productos = $respuesta["productos"];
          $productosArray= array();
          $productosArray = json_decode($productos, true);
          foreach ($productosArray as $key => $value) {
           
           echo '<tr>

                  <td>'.($key+1).'</td>

                  <td>'.$valor.'</td>
                  
                  <td>'.$value["descripcion"].'</td>

                  <td>'.$value["cantidad"].'</td></tr>';
            }

        ?>
               
        </tbody>

       </table>

       
       

      </div>

    </div>

  </section>

</div>




