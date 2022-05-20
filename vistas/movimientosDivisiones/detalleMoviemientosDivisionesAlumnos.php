<?php 


include ($absolute_include."vistas/plantillas/head.php"); 
include ($absolute_include."vistas/plantillas/sidebar.php"); 
include ($absolute_include."vistas/plantillas/navbar.php"); 

?> 

<div id="contenedorFormDetallePasajeCursoNuevoAnoLectivo" class="col-md-12 col-sm-12 col-xs-12">

  <!-- Titulos de la pantalla -->
  <div class="text-center">
    <h3>Detalle pasaje de curso a nuevo año lectivo</h3>
  </div>
  <br>
  <div class="form-group">
    <?php foreach ($resultado_descripcion_curso as $key => $descripcion_curso): ?>
      <h5><b>Curso: <?php echo $descripcion_curso['cdescripcion_curso']; ?> Año Lectivo: <?php echo $resultAnosLectivos['ndescripcion_anolectivo']; ?> </b></h5>
    <?php endforeach ?>
    <hr>
      <table id="table" class="table table-stripped table-bordered nowrap cellspacing=" width="100%">

        <thead class="thead-dark">
          <tr>

            <th class="text-center">Nombre</th>
            <th class="text-center">Dni</th>
            <th class="text-center">Fecha Nacimiento</th>
            <!-- <th class="text-center">Eliminar</th> -->

          </tr>
        </thead>

        <tbody>
          <?php foreach ($resultado_detalle_divisiones as $divisiones): ?>
            <tr>

              <td class="text-center"><?php echo $divisiones['capellidos_persona'] ." ". $divisiones['cnombres_persona']; ?></td>
              
              <td class="text-center"><?php echo $divisiones['ndni_persona']; ?></td>
              <td class="text-center"><?php echo $divisiones['dfechanac_persona']; ?></td>

          
            </tr>
          <?php endforeach; ?>

        </tbody>
      </table>

    </div>

  <input type="button" class="btn-block btn btn-info" onClick="location.href='<?php echo $absolute_include ?>controladores/movimientosdivisiones/controller.movimientosdivisiones.php'" value="Volver Atras">


  </div>

  <?php 

  include ($absolute_include."vistas/plantillas/footer.php"); 

  ?> 
