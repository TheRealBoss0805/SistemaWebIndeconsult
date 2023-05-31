<header class="main-header">
 	
	 <!--=====================================
	 LOGOTIPO
	 ======================================-->
	 <div class="contenedor_logo">
	 <a href="https://www.indeconsult.pe/" class="logo" target="_blank">
	   <img src="vistas/img/plantilla/logazo3.png" class="image-indeconsult">
	 </a>
	 </div>
 
	 <!--=====================================
	 BARRA DE NAVEGACIÓN
	 ======================================-->
	 <nav class="navbar navbar-static-top" role="navigation">
		 
		 <!-- Botón de navegación -->
 
		  <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
			 <span class="sr-only">Toggle navigation</span>
		   </a>
 
		 <!-- perfil de usuario -->
 
		 <div class="navbar-custom-menu">
			 <ul class="nav navbar-nav">
				 <div class="dropdown user user-menu">
					 <div href="#" class="dropdown-toggle" data-toggle="dropdown">
					 <?php
					 if($_SESSION["foto"] != ""){
						 echo '<img src="'.$_SESSION["foto"].'" class="user-image">';
					 }else{
						echo '<img src="vistas/img/usuarios/default/anonymous.png" class="user-image">';
					 }
					 ?>	
						 <span class="hidden-xs"><?php  echo $_SESSION["nombre"]; ?></span>
					 </div>		

					 <!-- Dropdown-toggle -->

					 <ul class="dropdown-menu menu-salir dropdown-menu-cabecera">	
						 <li class="user-body user-salir user-cabecera">	
							 <div class="pull-right pull-right-cabecera">		
								 <a href="salir" class="btn btn-default btn-flat btn-cabecera">Cerrar sesión en <br><b>"<?php echo $_SESSION["nombre"];?></b>"</a>
							 </div>
						 </li>
					 </ul>			 
				 </div>
				 
				 <div class="contenedor-fecha-hora" id="clockdate">
	
						 <div class="clockdate-wrapper">
							 <span id="clock" class="icon-stopwatch"></span>
							 <span id="date"></span>
							 <span id="date2"></span>
						 </div>
				 </div>
			 </ul>
		 </div>
	 </nav>

	 <img src="vistas/img/plantilla/IMG1.jpg" class="img1-idc">
	 <img src="vistas/img/plantilla/IMG2.jpg" class="img2-idc">
  </header>