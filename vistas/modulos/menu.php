<aside class="main-sidebar barra-menu">

	 <section class="sidebar">

		<ul class="sidebar-menu">

		<?php

			echo '<li class="inicio_1 about" id="inicio">
					<a href="inicio" class="menu-a-1">
						<i class="fa fa-home"></i>
						<span>Inicio</span>
					</a>
					</li>
					<li class="about" id="usuarios">
						<a href="usuarios" class="menu-a-1">
						<i class="fa icon-torso"></i>
						<span>Usuarios</span>
					</a>
				</li>';


			echo '<li class="about" id="categorias">

				<a href="categorias" class="menu-a-1">

					<i class="fa icon-sitemap"></i>
					<span>Categorías</span>

				</a>

			</li>

			<li class="about" id="productos">

				<a href="productos" class="menu-a-1">

					<i class="fa icon-desktop"></i>
					<span>Productos</span>

				</a>

			</li>

			<li class="about" id="clientes">

				<a href="clientes" class="menu-a-1">

					<i class="fa fa-users"></i>
					<span>Proveedores</span>

				</a>

			</li>

			
			<li class="about" id="areas">

				<a href="areas" class="menu-a-1">

					<i class="fa icon-chart-pie-3"></i>
					<span>Áreas</span>

				</a>

			</li>
			
			<li class="treeview about" id="entradas">

				<a href="#" class="menu-a-1">

					<i class="fa icon-resize-small"></i>
					
					<span>Ingreso</span>
					
					<span class="pull-right-container arrow-right">
					
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">';
					if ($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Empleado"){ 
					echo '					
					<li>
						<a href="crear-entrada" class="opciones-desplegable">					
							<i class="fa icon-edit"></i>
							<span>Crear ingreso</span>
						</a>
					</li>';
					}
					echo '<li>
						<a href="entradas" class="opciones-desplegable">							
							<i class="fa icon-archive"></i>
							<span>Ver historial</span>
						</a>
					</li>';
				echo '<li>
					<a href="reportes-entradas" class="opciones-desplegable">						
						<i class="fa icon-clipboard"></i>
						<span>Ver reportes</span>
					</a>
				</li>';

				echo '</ul>

					 </li>';

				echo '<li class="treeview inicio_2 about" id="salidas">

				<a href="#" class="menu-a-1">

					<i class="fa icon-resize-full"></i>
					
					<span>Salida</span>
					
					<span class="pull-right-container arrow-right">
					
						<i class="fa fa-angle-left pull-right"></i>

					</span>

				</a>

				<ul class="treeview-menu">';

				if ($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Empleado"){ 
					echo '
					<li>					
						<a href="crear-salida" class="opciones-desplegable">					
						<i class="fa icon-doc-new"></i>
						<span>Crear salida</span>
						</a>
					</li>';
				}
					echo '<li>
					<a href="salidas" class="opciones-desplegable">					
					<i class="fa icon-archive"></i>
					<span>Ver historial</span>
					</a>
					</li>
					<li>
						<a href="reportes-salidas" class="opciones-desplegable">							
							<i class="fa icon-clipboard"></i>
							<span>Ver reportes</span>
						</a>
					</li>';
					echo '</ul>
			</li>';
		?>
		</ul>

	 </section>

</aside>