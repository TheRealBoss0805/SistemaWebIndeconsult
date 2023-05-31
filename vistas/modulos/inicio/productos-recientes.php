<?php

$item = null;
$valor = null;
$orden = "fecha";

$productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

 ?>


<div class="box box-primary productos_recientes">

  <div class="box-header with-border">

    <h3 class="box-title"><b>PRODUCTOS AGREGADOS RECIENTEMENTE</b></h3>

    <div class="box-tools pull-right recientemente">

      <button type="button" class="btn btn-box-tool btn-menos-mas" data-widget="collapse">

        <i class="fa fa-minus"></i>

      </button>

      <button type="button" class="btn btn-box-tool btn-menos-mas" data-widget="remove">

        <i class="fa fa-times"></i>

      </button>

    </div>

  </div>
  
  <div class="box-body list_productos_recientes">

    <ul class="products-list product-list-in-box">

    <?php
    if(count($productos)<10){
      $limite = count($productos);
    }else{
      $limite = 10;
    }
    for($i = 0; $i < $limite; $i++){

      echo '<li class="item">

        <div class="product-img">

          <img src="'.$productos[$i]["imagen"].'" alt="Product Image">

        </div>

        <div class="product-info">

          <a href="" class="product-title">

            '.$productos[$i]["descripcion"].'

            <span class="label label-warning pull-right">'.$productos[$i]["fecha"].'</span>

          </a>
    
       </div>

      </li>';

    }

    ?>

    </ul>

  </div>

  <div class="box-footer text-center">

    <a href="productos" class="uppercase"><b>VER TODOS LOS PRODUCTOS</b></a>
  
  </div>

</div>
