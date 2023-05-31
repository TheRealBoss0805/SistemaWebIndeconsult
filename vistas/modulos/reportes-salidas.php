<?php

if($_SESSION["perfil"] == "Especial" || $_SESSION["perfil"] == "Vendedor"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>
<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      <b>REPORTE DE SALIDA DE PRODUCTOS</b>
    
    </h1>

    <ol class="breadcrumb">
      
    <li><a href="inicio"><i class="fa fa-dashboard"></i><b>INICIO</b></a></li>
      
      <li class="active"><b>REPORTE DE SALIDA DE PRODUCTOS</b></li>
    
    </ol>

  </section>

  <section class="content">

  <div class="box" style="background:none;">

      <div class="box-header with-border">

        <div class="input-group">

          <button type="button" class="btn btn-default" id="daterange-btn2">
           
            <span>
              <i class="fa fa-calendar"></i> 

              <?php

                if(isset($_GET["fechaInicial"])){ 
                  $_SESSION['fechaInicial'] = $_GET["fechaInicial"];
                  $_SESSION['fechaFinal'] = $_GET["fechaFinal"];
                  echo $_SESSION['fechaInicial']." - ".$_SESSION['fechaFinal'];
                  //echo $_GET["fechaInicial"]." - ".$_GET["fechaFinal"];  
                }else{
                  unset($_SESSION['fechaInicial']);
                  unset($_SESSION['fechaFinal']);
                  echo 'Rango de fecha';
                }

              ?>
            </span>

            <i class="fa fa-caret-down"></i>

          </button>

        </div>

        <div class="box-tools pull-right">

        <?php

        if(isset($_GET["fechaInicial"])){

          echo '<a href="vistas/modulos/descargar-reporte-salida.php?reporte=reporte-salidas&fechaInicial='.$_GET["fechaInicial"].'&fechaFinal='.$_GET["fechaFinal"].'">';

        }else{

           echo '<a href="vistas/modulos/descargar-reporte-salida.php?reporte=reporte-salidas">';

        }         

        ?>
           
           <button class="btn btn-success btn-descargar" style="margin-top:5px">Descargar reporte en Excel</button>

          </a>

        </div>
         
      </div>

      <div class="box-body">
        
        <div class="row">

          <div class="col-xs-12">
            
            <?php

            include "reportes/grafico-salidas.php";

            ?>

          </div>

           <div class="col-md-6 col-xs-12">
             
            <?php

            include "reportes/productos-mas-vendidos.php";

            ?>

           </div>

          <div class="col-md-6 col-xs-12">
             
            <?php

           // include "reportes/vendedores.php";

            ?>

           </div>

           <div class="col-md-6 col-xs-12">
             
            <?php

            include "reportes/compradores.php";

            ?>

           </div>
          
        </div>

      </div>
      
    </div>

  </section>
 
 </div>
