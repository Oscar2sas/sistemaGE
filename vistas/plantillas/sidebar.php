  <!--Start sidebar-wrapper-->
   <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
     <div class="brand-logo">
      <a href="/">
       <img src="<?php echo $carpeta_trabajo;?>/public/assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
       <h6 class="logo-text"><?php echo $GLOBALS['Escuela']; ?></h6>
       </a>
   </div>
   <ul class="sidebar-menu do-nicescrol">
      <li class="sidebar-header">Gestion Escolar - Opciones</li>
      <li>
        <a href="<?php echo $carpeta_trabajo;?>/controladores/inicio/controller.inicio.php">
          <i class="zmdi zmdi-view-dashboard"></i> <span>Inicio</span>
        </a>
      </li>
      
      <li>
        <a href="<?php 
            if (($_SESSION['rela_rol_id'] == 1) or ($_SESSION['rela_rol_id'] == 21) ) {
              echo $carpeta_trabajo."/controladores/archivos/controller.archivos.php";
         
            }
            else{
              
  
              echo $carpeta_trabajo."/controladores/inicio/controller.inicio.php";
             }
            ?>">
          <i class="zmdi zmdi-invert-colors"></i> <span>Archivos</span>
        </a>
      </li>

      <li>
        <a href="<?php 
            if (($_SESSION['rela_rol_id'] == 1) or ($_SESSION['rela_rol_id'] == 21) or ($_SESSION['rela_rol_id'] == 25) or ($_SESSION['rela_rol_id'] == 26) ) {
              echo $carpeta_trabajo."/controladores/movimientos/controller.movimientos.php";
            }
            else{
              
              echo $carpeta_trabajo."/controladores/inicio/controller.inicio.php";
             }
            ?>">
          <i class="zmdi zmdi-format-list-bulleted"></i> <span>Movimientos</span>
        </a>
      </li>

      <li>
        <a href="<?php 
            if (($_SESSION['rela_rol_id'] == 1) or ($_SESSION['rela_rol_id'] == 21) or ($_SESSION['rela_rol_id'] == 25) or ($_SESSION['rela_rol_id'] == 22) or ($_SESSION['rela_rol_id'] == 26) ) {
              echo $carpeta_trabajo."/controladores/consultas/controller.consultas.php";
            }
            else{
              
              echo $carpeta_trabajo."/controladores/inicio/controller.inicio.php";
             }
            ?>">
          <i class="zmdi zmdi-format-list-bulleted"></i> <span>Consultas</span>
        </a>
      </li>

      <li>
        <a href="<?php 
            if (($_SESSION['rela_rol_id'] == 1) or ($_SESSION['rela_rol_id'] == 21) ) {
              echo $carpeta_trabajo."/controladores/fondos/controller.fondos.php";
            }
            else{
              
              echo $carpeta_trabajo."/controladores/inicio/controller.inicio.php";
             }
            ?>">
          <i class="zmdi zmdi-grid"></i> <span>Fondos</span>
        </a>
      </li>

      <li>
        <a href="<?php 
            if (($_SESSION['rela_rol_id'] == 1) or ($_SESSION['rela_rol_id'] == 21) ) {
              echo $carpeta_trabajo."/controladores/reportes/controller.reportes.php";
            }
            else{
              
              echo $carpeta_trabajo."/controladores/inicio/controller.inicio.php";
             }
            ?>">
          <i class="zmdi zmdi-calendar-check"></i> <span>Reportes</span>
        </a>
      </li>

      
        <li><a href="<?php 
            if (($_SESSION['rela_rol_id'] == 1) or ($_SESSION['rela_rol_id'] == 21) ) {
              echo $carpeta_trabajo."/controladores/configuraciones/controller.configuraciones.php";
            }
            else{
              
              echo $carpeta_trabajo."/controladores/perfil/controller.perfil.php";
             }
            ?>">
          <i class="zmdi zmdi-settings"></i> <span>Configuraciones</span>
        </a>
                 
        </li>
      
    </ul>
   
   </div>
   <!--End sidebar-wrapper-->