<?php
/*
if($_SESSION["perfil"] == "Vendedor"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}
*/
?>

<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
    <b>ADMINISTRAR CATEGORÍAS</b>
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i><b>INICIO</b></a></li>
      
      <li class="active"><b>ADMINISTRAR CATEGORÍAS</b></li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">
      <?php
      if ($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Empleado"){
        echo '
        <div class="box-header with-border">

        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCategoria">
          
          Agregar categoría

        </button>

      </div>';
      }
      ?>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Categorías de los Productos</th>
           <th>Cantidad de Productos</th>
           <?php
            if ($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Empleado") {
              echo '<th>Acciones</th>';
            }
            ?>
         </tr> 

        </thead>

        <tbody>

        <?php

          $item = null;
          $valor = null;

          $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);

          foreach ($categorias as $key => $value) {

             
            $item1 = "id_categoria";
            $valor1 = $value['id_categoria'];
            $orden1 = "id_producto";
            $productos = ControladorProductos::ctrTraerProductos($item1, $valor1, $orden1);
            $cantidadProductos = count($productos);
     
            echo ' <tr>
                    <td>'.($key+1).'</td>
                    <td class="text-uppercase">'.$value["categoria"].'</td>
                    
                    <td class="text-uppercase cantidad-pr-cat">'.$cantidadProductos.' Unidades.</td>';
                      if ($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Empleado"){            
                      echo ' <td>
                      <div class="btn-group">
                        <button class="btn btn-warning btnEditarCategoria" idCategoria="'.$value["id_categoria"].'" data-toggle="modal" data-target="#modalEditarCategoria"><i class="fa fa-pencil"></i></button>
                        <button class="btn btn-danger btnEliminarCategoria" idCategoria="'.$value["id_categoria"].'"><i class="fa fa-times"></i></button>';
                      }

                      echo '</div>  
                    </td>
                  </tr>';

          }
        ?>
        </tbody>

       </table>

      </div>

    </div>

  </section>

</div>
<?php
if ($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Empleado") {

  echo '
<!--=====================================
MODAL AGREGAR CATEGORÍA
======================================-->

<div id="modalAgregarCategoria" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#222222; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar categoría</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa icon-sitemap"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevaCategoria" placeholder="Ingresar Categoría" required>

              </div>

            </div>
  
          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar categoría</button>

        </div>';
}
        ?>
        <?php

        $crearCategoria = new ControladorCategorias();
        $crearCategoria -> ctrCrearCategoria();

        ?>

      </form>

    </div>

  </div>

</div>
<?php
if ($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Empleado"){
  echo '
<!--=====================================
MODAL EDITAR CATEGORÍA
======================================-->

<div id="modalEditarCategoria" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#222222; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar categoría</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa icon-sitemap"></i></span> 

                <input type="text" class="form-control input-lg" name="editarCategoria" id="editarCategoria" required>

                 <input type="hidden"  name="idCategoria" id="idCategoria" required>

              </div>

            </div>
  
          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar cambios</button>

        </div>';
}
      ?>
      <?php
          $editarCategoria = new ControladorCategorias();
          $editarCategoria -> ctrEditarCategoria();
      ?> 

      </form>

    </div>

  </div>

</div>

<?php

  $borrarCategoria = new ControladorCategorias();
  $borrarCategoria -> ctrBorrarCategoria();

?>


