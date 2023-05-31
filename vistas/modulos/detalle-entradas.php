<?php

if(!isset($_GET["codigoVenta"])){

  echo '<script>

    window.location = "entradas";

  </script>';

  return;

}
if($_SESSION["perfil"] == "Especial"){

  echo '<script>

    window.location = "inicio";

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
      
    <b>DETALLE DE INGRESOS</b>
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i><b>INICIO</b></a></li>
      
      <li class="active"><b>DETALLE DE INGRESOS</b></li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <a href="entradas">

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
           <!--<th>Proveedor</th>
           <th>Registrado por:</th>-->
           <!--<th>Forma de pago</th>
           <th>Neto</th>
           <th>Total</th> -->
           <th>Producto</th>
           <th>Cantidad</th>
           <th>Precio de compra</th>
           <th>Subtotal</th>
           <th>Impuesto</th>
           <th>Neto</th>
           <th>Total</th>
           <!--<th>Fecha</th>
           <th>Acciones</th>-->

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
          $item = "codigo_factura";
          $valor =$_GET["codigoVenta"];
          $respuesta = ControladorEntradas::ctrMostrarEntradas($item, $valor);
          $productos = $respuesta["productos"];
          $productosArray= array();
          $productosArray = json_decode($productos, true);
          foreach ($productosArray as $key => $value) {
           
           echo '<tr class="rowspan_total">

                  <td>'.($key+1).'</td>

                  <td>'.$valor.'</td>
                  
                  <td>'.$value["descripcion"].'</td>
                  
                  <td>'.$value["cantidad"].'</td>
                  
                  <td>S/.'.number_format($value["precio"],2).'</td>
                  
                  <td>S/.'.number_format($value["subtotal"],2).'</td>';
                  
                  if(($key+1) == 1){
                  echo '<td rowspan='.count($productosArray).'>S/.'.number_format($respuesta["impuesto"],2).'</td>';
                  echo '<td rowspan='.count($productosArray).'>S/.'.number_format($respuesta["neto"],2).'</td>';
                  echo '<td rowspan='.count($productosArray).'>S/.'.number_format($respuesta["total"],2).'</td>';
                  
                  }
                  
                echo '</tr>';
            }

        ?>
               
        </tbody>

       </table>

       
       

      </div>

    </div>

  </section>

</div>




