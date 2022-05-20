<?php 


  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
  ?> 



        <h1 class="text-center">Inicio</h1>
  <!--Start Dashboard Content-->
<div class="card-columns">
  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php 
            if (($_SESSION['rela_rol_id'] == 1) or ($_SESSION['rela_rol_id'] == 21) ) {
              echo $carpeta_trabajo."/controladores/archivos/controller.archivos.php";
         
            }
            else{
              
              echo $carpeta_trabajo."/controladores/inicio/controller.inicio.php";
             }
            ?>">Archivos</a></p>
    </div>
  </div>  
  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php 
            if (($_SESSION['rela_rol_id'] == 1) or ($_SESSION['rela_rol_id'] == 21) or ($_SESSION['rela_rol_id'] == 25) or ($_SESSION['rela_rol_id'] == 22) or ($_SESSION['rela_rol_id'] == 26) ) {
              echo $carpeta_trabajo."/controladores/consultas/controller.consultas.php";
            }
            else{
              
              echo $carpeta_trabajo."/controladores/inicio/controller.inicio.php";
             }
            ?>">Consultas</a></p>
    </div>
  </div>
  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php 
            if (($_SESSION['rela_rol_id'] == 1) or ($_SESSION['rela_rol_id'] == 21) or ($_SESSION['rela_rol_id'] == 25) or ($_SESSION['rela_rol_id'] == 26) ) {
              echo $carpeta_trabajo."/controladores/movimientos/controller.movimientos.php";
            }
            else{
              
              echo $carpeta_trabajo."/controladores/inicio/controller.inicio.php";
             }
            ?>">Movimientos</a></p>
    </div>
  </div>

  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php 
            if (($_SESSION['rela_rol_id'] == 1) or ($_SESSION['rela_rol_id'] == 21) ) {
              echo $carpeta_trabajo."/controladores/fondos/controller.fondos.php";
            }
            else{
              
              echo $carpeta_trabajo."/controladores/inicio/controller.inicio.php";
             }
            ?>">Fondos</a></p>
    </div>
  </div>
  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php 
            if (($_SESSION['rela_rol_id'] == 1) or ($_SESSION['rela_rol_id'] == 21) ) {
              echo $carpeta_trabajo."/controladores/reportes/controller.reportes.php";
            }
            else{
              
              echo $carpeta_trabajo."/controladores/inicio/controller.inicio.php";
             }
            ?>">Reportes</a></p>
    </div>
  </div>
  <div class="card bg-light">
    <div class="card-body text-center">
      <p class="card-text"><a href="<?php 
            if (($_SESSION['rela_rol_id'] == 1) or ($_SESSION['rela_rol_id'] == 21) ) {
              echo $carpeta_trabajo."/controladores/configuraciones/controller.configuraciones.php";
            }
            else{
              
              echo $carpeta_trabajo."/controladores/perfil/controller.perfil.php";
             }
            ?>">Configuraciones</a></p>
    </div>
  </div>
</div>

      <!--End Dashboard Content-->

<?php 

   include ($absolute_include."vistas/plantillas/footer.php"); 

?> 
 
 
 
