<div class="content-wrapper">
  
<section class="welcome-user">
  <div class="col-lg-12">
           
           <?php
 
           //if($_SESSION["perfil"] =="Especial" || $_SESSION["perfil"] =="Vendedor"){
 
              echo '<div class="box box-success">
 
              <div class="box-header">
 
              <h1>Has iniciado sesión como <b class="rol-usuario">'.$_SESSION["perfil"].'</b></h1>
 
              </div>
 
              </div>';
 
           //}s
 
           ?>
 
          </div>
  </section>

  <section class="content-header header-inicio">
    
    <h1>
      
    <b>DASHBOARD</b>
      
      <small><b>PANEL DE CONTROL</b></small>
    
    </h1>
    
    <ol class="breadcrumb">
      
    <a href="https://drive.google.com/file/d/1Z2KVpHiOWwQMMH3N92Qr5dDTqRCE_IL6/view?usp=sharing" target="blank" class="enlace-manual-usuario"><li class="manual-teffa-rivera"><span class="fa icon-book" title="Manual de Usuario"></span></li></a>

      <li><a href="inicio"><i class="fa fa-dashboard"></i><b>DASHBOARD</b></a></li>
      
      <li class="active"><b>TABLERO</b></li>
    
    </ol>

  </section>

  <section class="content">

    <div class="row">
      
    <?php

    //if($_SESSION["perfil"] =="Administrador"){

      include "inicio/cajas-superiores.php";

    //}

    ?>

    </div> 

     <div class="row">
       
        <div class="col-lg-12">

          <?php

          //if($_SESSION["perfil"] =="Administrador"){
          
           include "reportes/grafico-ventas.php";

          //}

          ?>

        </div>

        <div class="col-lg-6">

          <?php

          //if($_SESSION["perfil"] =="Administrador"){
          
           include "reportes/productos-mas-vendidos.php";

         //}

          ?>

        </div>

         <div class="col-lg-6">

          <?php

          //if($_SESSION["perfil"] =="Administrador"){
          
           include "inicio/productos-recientes.php";

         //}

          ?>

        </div>

     </div>

  </section>
 
</div>
