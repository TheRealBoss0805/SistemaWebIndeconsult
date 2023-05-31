<?php
  if(!isset($_GET["idSalida"])){
    echo '<script>
      window.location = "salidas";
      </script>';
      return;
  }
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
      
      <b>EDITAR SALIDA</b>
    
    </h1>

    <ol class="breadcrumb">
      
    <li><a href="inicio"><i class="fa fa-dashboard"></i><b>INICIO</b></a></li>
      
      <li class="active"><b>EDITAR SALIDA</b></li>
    
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

                <?php

                    $item = "id_salidaprod";
                    $valor = $_GET["idSalida"];

                    $salida = ControladorSalidas::ctrMostrarSalida($item, $valor);

                    $itemUsuario = "id_usuario";
                    $valorUsuario = $salida["id_usuario"];

                    $usuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);
                    if(!$usuario){
                      $nombreUsuario="El usuario del vendedor fue eliminado";
                    }else{
                      $nombreUsuario=$usuario["nombre"];
                    }

                    $itemArea = "id_area";
                    $valorArea = $salida["id_area"];

                    $area = ControladorAreas::ctrMostrarAreas($itemArea, $valorArea);

                   


                ?>

                <!--=====================================
                ENTRADA DEL VENDEDOR
                ======================================-->
            
                <div class="form-group">
                
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                    <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo $nombreUsuario; ?>" readonly>

                    <input type="hidden" name="idVendedor" value="<?php echo $usuario["id_usuario"]; ?>">

                  </div>

                </div> 

                <!--=====================================
                ENTRADA DEL CÓDIGO
                ======================================--> 

                <div class="form-group">
                  
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-key"></i></span>

                   <input type="text" class="form-control" id="nuevaVenta" name="editarSalida" value="<?php echo $salida["codigo"]; ?>" readonly>
               
                  </div>
                
                </div>

                <!--=====================================
                ENTRADA DEL CLIENTE
                ======================================--> 

                <div class="form-group">
                  
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-users"></i></span>
                    
                    <select class="form-control" id="seleccionarArea" name="seleccionarArea" required>

                    <?php
                      if(!$area){
                        ?>
                        <option value="">El cliente fue eliminado</option>
                      <?php
                      }else{
                        ?>
                        <option value="<?php echo $area["id_area"]; ?>"><?php echo $area["area"]; ?></option>
                      <?php
                      }

                      $item = null;
                      $valor = null;

                      $categorias = ControladorAreas::ctrMostrarAreas($item, $valor);

                       foreach ($categorias as $key => $value) {
                        
                         echo '<option value="'.$value["id_area"].'">'.$value["area"].'</option>';

                       }

                    ?>

                    </select>
                    
                    <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAgregarCliente" data-dismiss="modal">Agregar área</button></span>
                  
                  </div>
                
                </div>

                <!--=====================================
                ENTRADA PARA AGREGAR PRODUCTO
                ======================================--> 

                <div class="form-group row nuevoProducto">

                <?php

                $listaProducto = json_decode($salida["productos"], true);

                foreach ($listaProducto as $key => $value) {

                  $item = "id_producto";
                  $valor = $value["id"];
                  $orden = "id_producto";

                  $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

                  if(!$respuesta){
                    $respuestaStock=0;
                    $respuestaPVenta=$value["precio"];
                  }else{
                    $respuestaStock=$respuesta["stock"];
                    //$respuestaPVenta=$respuesta["precio_venta"];
                  }
                  $stockAntiguo = $respuestaStock + $value["cantidad"];
                  
                  echo '<div class="row" style="padding:5px 15px">
            
                        <div class="col-xs-6" style="padding-right:0px">
            
                          <div class="input-group">
                
                            <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'.$value["id"].'"><i class="fa fa-times"></i></button></span>

                            <input type="text" class="form-control nuevaDescripcionProducto" idProducto="'.$value["id"].'" name="agregarProducto" value="'.$value["descripcion"].'" readonly required>

                          </div>

                        </div>

                        <div class="col-xs-6">
              
                          <input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="'.$value["cantidad"].'" stock="'.$stockAntiguo.'" nuevoStock="'.$value["stock"].'" cantidadInicial="'.$value["cantidad"].'" required>

                        </div>

                      </div>';
                }


                ?>

                </div>

                <input type="hidden" id="listaProductos" name="listaProductos" value='<?= $salida["productos"]?>'>

                <!--=====================================
                BOTÓN PARA AGREGAR PRODUCTO
                ======================================-->

                <button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar producto</button>

                <hr>

                <br>
      
              </div>

          </div>

          <div class="box-footer">

            <button type="submit" class="btn btn-primary pull-right">Guardar cambios</button>

          </div>

        </form>

        <?php

          $editarSalida = new ControladorSalidas();
          $editarSalida -> ctrEditarSalida();
          
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
MODAL AGREGAR AREA
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
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevoArea" placeholder="Ingresar área" required>

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
