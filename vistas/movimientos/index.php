<?php 


include ($absolute_include."vistas/plantillas/head.php"); 
include ($absolute_include."vistas/plantillas/sidebar.php"); 
include ($absolute_include."vistas/plantillas/navbar.php"); 

?> 


<!-- <div class="col-md-12"> -->

  <h3 class="text-center">Movimientos</h3>
  <!--Start Dashboard Content-->
  <div class="card-columns col-12">
    <div class="card bg-light">
      <div class="card-body text-center">
        <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/asistenciaalumnos/controller.asistenciaalumnos.php">Asistencia</a></p>
      </div>
    </div>

    <div class="card bg-light">
      <div class="card-body text-center">
        <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/notas/controller.notas.php">Notas</a></p>
      </div>
    </div>

    <div class="card bg-light">
      <div class="card-body text-center">
        <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/examenes/controller.examenes.php">Examenes</a></p>
      </div>
    </div>
  </div>

  <hr>

  <div class="card-columns col-12">
    <div class="card bg-light">
      <div class="card-body text-center">
        <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/movimientosdivisiones/controller.movimientosdivisiones.php">Movimientos en Divisiones</a></p>
      </div>
    </div>

    <div class="card bg-light">
      <div class="card-body text-center">
        <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/movimientosalumnos/controller.movimientosalumnos.php">Movimientos de Alumnos</a></p>
      </div>
    </div>

    <div class="card bg-light">
      <div class="card-body text-center">
        <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/movimientos/controller.movimientosdocentes.php">Movimientos de Docentes</a></p>
      </div>
    </div>
  </div>

  <div class="card-columns col-12">

    <div class="card bg-light">
      <div class="card-body text-center">
        <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/consultarasistenciasalumnos/controller.consultarasistenciasalumnos.php">Consultar asistencia Alumnos</a></p>
      </div>
    </div>

    <div class="card bg-light">
      <div class="card-body text-center">
        <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/registrartardanzasalumnos/controller.registrartardanzasalumnos.php">Registrar Tardanzas Alumnos</a></p>
      </div>
    </div>


    <div class="card bg-light">
      <div class="card-body text-center">
        <p class="card-text"><a href="<?php echo $carpeta_trabajo;?>/controladores/verificarhorariosdocentes/controller.verificarhorariosdocentes.php">Opciones Docentes</a></p>
      </div>
    </div>

  </div>


  <!-- </div> -->

  <!--End Dashboard Content-->

  <?php 

  include ($absolute_include."vistas/plantillas/footer.php"); 

  ?> 



