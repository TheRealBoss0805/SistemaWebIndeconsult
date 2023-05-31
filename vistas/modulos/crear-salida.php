<?php

if($_SESSION["perfil"] == "Visualizador"){

  echo '<script>

    window.location = "salidas";

  </script>';

  return;

}

?>

<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      <b>CREAR SALIDA DE PRODUCTOS</b>
    
    </h1>

    <ol class="breadcrumb">
      
    <li><a href="inicio"><i class="fa fa-dashboard"></i><b>INICIO</b></a></li>
      
      <li class="active"><b>CREAR SALIDA DE PRODUCTOS</b></li>
    
    </ol>

  </section>

  <section class="content content_entrada_tablas">

    <div class="row entrada_tablas">

      <!--=====================================
      EL FORMULARIO
      ======================================-->
      
      <div class="col-lg-5 col-xs-12">
        
        <div class="box box-success">
          
          <div class="box-header with-border"></div>

          <form role="form" method="post" class="formularioSalida">

            <div class="box-body">
  
              <div class="box">

                <!--=====================================
                ENTRADA DEL VENDEDOR
                ======================================-->
            
                <div class="form-group">
                
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                    <input type="text" class="form-control" id="nuevoUsuario" value="<?php echo $_SESSION["nombre"]; ?>" readonly>

                    <input type="hidden" name="idUsuario" value="<?php echo $_SESSION["id"]; ?>">

                  </div>

                </div> 

                <!--=====================================
                ENTRADA DEL CÓDIGO
                ======================================--> 

                <div class="form-group">
                  
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-key"></i></span>

                    <?php

                    $item = null;
                    $valor = null;

                    $salidas = ControladorSalidas::ctrMostrarSalida($item, $valor);

                    if(!$salidas){

                      echo '<input type="text" class="form-control" id="nuevaSalida" name="nuevaSalida" value="10001" readonly>';
                  

                    }else{

                      foreach ($salidas as $key => $value) {
                        
                        
                      
                      }

                      $codigo = $value["codigo"] + 1;



                      echo '<input type="text" class="form-control" id="nuevaSalida" name="nuevaSalida" value="'.$codigo.'" readonly>';
                  

                    }

                    ?>
                    
                    
                  </div>
                
                </div>

                <!--=====================================
                ENTRADA DEL AREA
                ======================================--> 

                <div class="form-group">
                  
                <div class="input-group" style="background:white;">
                    
                    <span class="input-group-addon"><i class="fa icon-chart-pie-3"></i></span>
                    
                    <select class="form-control" id="seleccionarArea" name="seleccionarArea" required>

                    <option value="" hidden selected>Seleccionar área</option>

                    <?php

                      $item = null;
                      $valor = null;

                      $categorias = ControladorAreas::ctrMostrarAreas($item, $valor);

                       foreach ($categorias as $key => $value) {

                         echo '<option value="'.$value["id_area"].'">'.$value["area"].'</option>';

                       }

                    ?>

                    </select>
                    
                    <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs btn-agregar-proveedor" data-toggle="modal" data-target="#modalAgregarCliente" data-dismiss="modal" style='background-color: #2b315c !important;'>Agregar área</button></span>
                  
                  </div>
                
                </div>

                <!--=====================================
                ENTRADA PARA AGREGAR PRODUCTO
                ======================================--> 

                <div class="form-group row nuevoProducto">

                

                </div>

                <input type="hidden" id="listaProductos" name="listaProductos">

                <!--=====================================
                BOTÓN PARA AGREGAR PRODUCTO
                ======================================-->

                <button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar producto</button>

                <hr>

                <br>
      
              </div>

          </div>

          <div class="box-footer">

            <button type="submit" class="btn btn-primary pull-right">Guardar Sallida</button>

          </div>

        </form>

        <?php

          $guardarSalida = new ControladorSalidas();
          $guardarSalida -> ctrCrearSalida();
          
        ?>

        </div>
            
      </div>

      <!--=====================================
      LA TABLA DE PRODUCTOS
      ======================================-->

      <div class="col-lg-7 hidden-md hidden-sm hidden-xs">
        
        <div class="box box-warning">

          <div class="box-header with-border"></div>

          <div class="box-body">
            
            <table class="table table-bordered table-striped dt-responsive tablaSalidas">
              
               <thead>

                 <tr>
                  <th style="width: 10px">#</th>
                  <th>Imagen</th>
                  <th>Código</th>
                  <th>Descripcion</th>
                  <th>Categorías</th>      
                  <th>Stock</th>
                  <th>Acciones</th>
                </tr>

              </thead>

            </table>

          </div>

        </div>


      </div>

    </div>
   
  </section>

</div>

<!--=====================================
MODAL AGREGAR CLIENTE
======================================-->

<div id="modalAgregarCliente" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#222222; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar área</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa icon-chart-pie-3"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevoArea" placeholder="Ingresar Área" required>

              </div>

            </div>
  
          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar área</button>

        </div>

      </form>

      <?php

        $crearArea = new ControladorAreas();
        $crearArea -> ctrCrearArea();

      ?>

    </div>

  </div>

</div>
