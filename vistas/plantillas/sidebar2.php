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
        <a href="<?php echo $carpeta_trabajo;?>/controladores/notas_secundarios/controller.notas.php">
          <i class="zmdi zmdi-format-list-bulleted"></i> <span>Notas</span>
        </a>
      </li>

      <li>
        <a href="<?php echo $carpeta_trabajo;?>/controladores/asistenciaalumnosdocentes/controller.asistenciaalumnosdocentes.php">
          <i class="zmdi zmdi-format-list-bulleted"></i> <span>Asistencias</span>
        </a>
      </li>
      
      <li>
      <a href="<?php echo $carpeta_trabajo;?>/controladores/examenes_roles_secundarios/controller.examenes.php">
          <i class="zmdi zmdi-format-list-bulleted"></i> <span>Exámenes</span>
        </a>
      </li>

      
    </ul>
   
   </div>
   <!--End sidebar-wrapper-->