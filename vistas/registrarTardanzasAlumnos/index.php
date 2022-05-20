<?php 


include ($absolute_include."vistas/plantillas/head.php"); 
include ($absolute_include."vistas/plantillas/sidebar.php"); 
include ($absolute_include."vistas/plantillas/navbar.php"); 

?> 



<div id="contenedorFormRegistrarTardanzasAlumnos" class="col-md-12 col-sm-12 col-xs-12">


    <input type="hidden" name="accion" value="consultar_asitencias_alumnos">  

    <!-- Titulos de la pantalla -->
    <div class="text-center">
      <h1>Registrar Tardanzas</h1>
    </div>
    <br>
    <div class="form-group">
      <h2>Ingrese su dni:</h2>
      <input type="number" class="form-control" name="dniRegistrarTardanzaAlumno" id="dniRegistrarTardanzaAlumno" required autofocus placeholder="POR FAVOR INGRESE AQUI SU DNI">
      <br>
      <input type="button" class="btn btn-success form-control active" id="btnRegistrarTardanzasAlumnos" name="btnRegistrarTardanzasAlumnos" value="REGISTRAR TARDANZAS">

      <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['token']; ?>"> 
  </div>

</div>


<?php 

include ($absolute_include."vistas/plantillas/footer.php"); 

?> 
