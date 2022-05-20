<?php 


include ($absolute_include."vistas/plantillas/head.php"); 
include ($absolute_include."vistas/plantillas/sidebar.php"); 
include ($absolute_include."vistas/plantillas/navbar.php"); 
?> 



<div id="contenedorFormConsultarAsistenciaAlumnos" class="col-md-12 col-sm-12 col-xs-12">

  <form id="formConsultarInasistenciaAlumnos" action="<?php echo $carpeta_trabajo;?>/controladores/consultarasistenciasalumnos/controller.consultarasistenciasalumnos.php" method="POST">

    <input type="hidden" name="accion" value="consultar_asitencias_alumnos">  

    <!-- Titulos de la pantalla -->
    <div class="text-center">
      <h1>Consultar Inasistencia</h1>
    </div>

    <div class="form-group">
      <h2>Ingrese su dni:</h2>
      <input type="number" class="form-control" name="dniAlumno" id="dniAlumno" required autofocus placeholder="POR FAVOR INGRESE AQUI SU DNI">
      <br>
      <input type="submit" class="btn btn-success form-control active" id="btnConsultarAsistenciasAlumnos" name="btnConsultarAsistenciasAlumnos" value="CONSULTAR INASISTENCIA">

      <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['token']; ?>"> 
    </form>
  </div>

</div>


<?php 

include ($absolute_include."vistas/plantillas/footer.php"); 

?> 
