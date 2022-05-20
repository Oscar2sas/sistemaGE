<?php 


include ($absolute_include."vistas/plantillas/head.php"); 
include ($absolute_include."vistas/plantillas/sidebar.php"); 
include ($absolute_include."vistas/plantillas/navbar.php"); 


?> 

<div id="contenedorFormPasajeCursoNuevoAnoLectivo" class="col-md-12 col-sm-12 col-xs-12">

  <!-- Titulos de la pantalla -->
  <div class="text-center">
    <h3>Listado de Divisiones</h3>
  </div>

  <div class="form-group">
    <!-- <div class="col-md-12 col-sm-12 col-xs-12"> -->
      <label for="movimientosDivisionesAnoLectivo">Año Lectivo Activo</label>
      <select class="form-control" disabled id="movimientosDivisionesAnoLectivo">

        <option value="<?php echo $resultAnosLectivos['anolectivo_id']; ?>" selected disabled><?php echo $resultAnosLectivos['ndescripcion_anolectivo']; ?></option>

      </select>
    </div>
    <br>
    <div class="form-group">
      <form action="<?php echo $carpeta_trabajo;?>/controladores/movimientosdivisiones/controller.movimientosdivisiones.php" method="POST">
        <input type="hidden" name="accion" value="nuevo">  
        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
        <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Pasar Curso</button>
      </form>    
      <?php if (!empty($resultado_divisiones_ano_lectivo['mensaje'])): ?>

        <!-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> -->
          <!-- </div> -->
          <br>

          <table id="table" class="table table-stripped table-bordered nowrap cellspacing=" width="100%">

            <thead class="thead-dark">
              <tr>

                <th class="text-center">Pais</th>
                <th class="text-center">Detalle</th>
                <th class="text-center">Modificar</th>
                <th class="text-center">Eliminar</th>

              </tr>
            </thead>

            <tbody>
              <?php foreach ($resultado_divisiones_ano_lectivo['mensaje'] as $divisiones): ?>
                <tr>

                  <td class="text-center"><?php echo $divisiones['cdescripcion_curso']; ?></td>

                  <td class="text-center">
                    <form action="<?php echo $carpeta_trabajo;?>/controladores/movimientosdivisiones/controller.movimientosdivisiones.php" method="POST">
                      <input type="hidden" name="accion" value="detalle">  
                      <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                      <input type="hidden" name="curso_id" value="<?php echo $divisiones['curso_id']; ?>">  
                      <button type="submit" class="btn btn-info btn-xs">Detalle <i class="fa fa-search"></i></button>
                    </form>  
                  </td>

                  <td class="text-center">
                    <form action="<?php echo $carpeta_trabajo;?>/controladores/movimientosdivisiones/controller.movimientosdivisiones.php" method="POST">
                      <input type="hidden" name="accion" value="editar">  
                      <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                      <input type="hidden" name="curso_id" value="<?php echo $divisiones['curso_id']; ?>">  
                      <button type="submit" class="btn btn-warning btn-xs">Modificar <i class="fa fa-edit"></i></button>
                    </form>  
                  </td>
                  <td class="text-center">

                    <input type="hidden" name="curso_id" id="cursoId" value="<?php echo $divisiones['curso_id']; ?>">  
                    <button type="submit" id="eliminarDivisionAlumnoPasaje" class="btn btn-danger btn-xs">Eliminar <i class="fa fa-trash"></i></button>
                  </td>
                </tr>
              <?php endforeach; ?>

            </tbody>
          </table>

          <?php else: ?>
            <br>
            <h3><b>No hay ninguna divisiòn cargada</b></h3>

          <?php endif ?>
        </div>

      </div>

      <?php 

      include ($absolute_include."vistas/plantillas/footer.php"); 

      ?> 
