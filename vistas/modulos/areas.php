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
      
    <b>ADMINISTRAR ÁREAS</b>
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i><b>INICIO</b></a></li>
      
      <li class="active"><b>ADMINISTRAR ÁREAS</b></li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">
    <?php
      if ($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Empleado") {
        echo '
      <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarArea">
          
          Agregar área

        </button>

      </div>';
      }
      ?>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Áreas de la Empresa</th>
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

          $areas = ControladorAreas::ctrMostrarAreas($item, $valor);

          foreach ($areas as $key => $value) {
           
            echo ' <tr>

                    <td>'.($key+1).'</td>

                    <td class="text-uppercase">'.$value["area"].'</td>';
                    
                    if ($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Empleado") {
                    
                      echo '<td>

                      <div class="btn-group">
                          
                        <button class="btn btn-warning btnEditarArea" idArea="'.$value["id_area"].'" data-toggle="modal" data-target="#modalEditarArea"><i class="fa fa-pencil"></i></button>
                        <button class="btn btn-danger btnEliminarArea" idArea="'.$value["id_area"].'"><i class="fa fa-times"></i></button>';
                      
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
MODAL AGREGAR AREA
======================================-->

<div id="modalAgregarArea" class="modal fade" role="dialog">
  
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

                <input type="text" id="nuevaArea" class="form-control input-lg" name="nuevoArea" placeholder="Ingresar Área" required>

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

        </div>';
}
?>

        <?php

          $crearArea = new ControladorAreas();
          $crearArea -> ctrCrearArea();

        ?>

      </form>

    </div>

  </div>

</div>
<?php
if ($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Empleado") {
  echo '
<!--=====================================
MODAL EDITAR AREA
======================================-->

<div id="modalEditarArea" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#222222; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar área</h4>

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

                <input type="text" class="form-control input-lg" name="editarArea" id="editarArea" required>

                 <input type="hidden"  name="idArea" id="idArea" required>

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

          $editarArea = new ControladorAreas();
          $editarArea -> ctrEditarArea();

        ?> 

      </form>

    </div>

  </div>

</div>

<?php

  $borrarArea = new ControladorAreas();
  $borrarArea -> ctrBorrarArea();

?>


