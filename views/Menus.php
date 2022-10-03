<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <p class="brand-link">
    <a href="../index.php"> <img src="../img/logo.png" alt="Software Bolivia" class="brand-image img-circle elevation-3"></a>
      <span class="brand-text">Software Bolivia</span>
    </p>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
        
          <p class="text-white"> <?php echo $usuario; ?></p>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="../index.php" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard              
              </p>
            </a>
          </li>
            

          <?php    if($tipoUsuario == 1 || $tipoUsuario==2) { ?>             
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cash-register"></i>
              <p> Ventas<i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item" style="padding-left: 10px;">
                <a href="ventas.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Nueva Venta</p>
                </a>
              </li>
              <?php }
                 

                  if($tipoUsuario == 1) { ?>   
              <li class="nav-item" style="padding-left: 10px;">
                <a href="EliminarVentas.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Eliminar Venta</p>
                </a>
              </li> 
              <?php } ?>
            </ul>          
          </li>  
          <?php
               

                  if($tipoUsuario == 1) { ?>   
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Compras
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item" style="padding-left: 10px;">
                <a href="compras.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Nueva Compra</p>
                </a>
              </li>
              <?php }
               

                  if($tipoUsuario == 1) { ?>   
              <li class="nav-item" style="padding-left: 10px;">
                <a href="EliminarCompras.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Eliminar Compra</p>
                </a>
              </li>
              <?php } ?>
            </ul>
          </li>  
         
             

             
          
       
             

          <?php if($tipoUsuario == 1) { ?>                  
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-md"></i>
              <p>
                Empleados
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item" style="padding-left: 10px;">
                <a href="empleado.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Empleados</p>
                </a>
              </li>
              <li class="nav-item" style="padding-left: 10px;">
                <a href="usuario.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Usuarios</p>
                </a>
              </li>
            </ul>
          </li>     
          <?php }
            

                  if($tipoUsuario == 1) { ?>   
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-pills"></i>
              <p>
                Productos
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item" style="padding-left: 10px;">
                <a href="productos.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Productos</p>
                </a>
              </li>
              <?php }
              

                  if($tipoUsuario == 1) { ?>   
              <li class="nav-item" style="padding-left: 10px;">
                <a href="categorias.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Categoria</p>
                </a>
              </li>
              <?php }
              

                  if($tipoUsuario == 1) { ?>              
              <li class="nav-item">
            <a href="proveedor.php" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
              <p>
              Proveedor
              </p>
            </a>
          </li>  
              <?php }
             

                  if($tipoUsuario == 1) { ?>   
              <li class="nav-item" style="padding-left: 10px;">
                <a href="presentacion.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Presentación</p>
                </a>
              </li>
              <?php } ?>
            </ul>
          </li> 
          <?php 
              

                  if($tipoUsuario == 1) { ?>       
          <li class="nav-item">
            <a href="lote.php" class="nav-link">
              <i class="nav-icon fas fa-cubes"></i>
              <p>
                Gestión de Lotes               
              </p>
            </a>
          </li>
          <?php } ?>
      
          <li class="nav-item">
            <a href="kardex.php" class="nav-link">
              <i class="nav-icon fas fa-clipboard"></i>
              <p>
                Kardex
              </p>
            </a>
          </li> 
          <?php 
              

                  if($tipoUsuario == 1) { ?>    
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-truck-loading"></i>
              <p>
                Inventarios
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item" style="padding-left: 30px;">
                <a href="inventarioGeneral.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>General</p>
                </a>
              </li>
              <li class="nav-item" style="padding-left: 30px;">
                <a href="inventarioFechaVencimiento.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Fecha Vencimiento</p>
                </a>
              </li>
            </ul>
          </li> 
          <?php } ?>    
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Reportes
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item" style="padding-left: 10px;">
                <a href="listaVentas.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Resumen Ventas</p>
                </a>
              </li>
              <li class="nav-item" style="padding-left: 10px;">
                <a href="ListaCompras.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Resumen Compras</p>
                </a>
              </li>
              <li class="nav-item" style="padding-left: 10px;">
                <a href="topProductos.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Top productos</p>
                </a>
              </li>
              <li class="nav-item" style="padding-left: 10px;">
                <a href="roles.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Productos sin rotación</p>
                </a>
              </li>
              <li class="nav-item" style="padding-left: 10px;">
                <a href="roles.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Top Clientes</p>
                </a>
              </li>
            </ul>
          </li>   
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  