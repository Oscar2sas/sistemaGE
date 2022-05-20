<?php
include($absolute_include . "vistas/plantillas/head.php");
include($absolute_include . "vistas/plantillas/sidebar.php");
include($absolute_include . "vistas/plantillas/navbar.php");
?>
<br><br><br>
<div class="title_right col-lg-4 col-md-4 col-sm-4 col-xs-4">
    <form action="<?php echo $carpeta_trabajo;?>/controladores/carreras/controller.carreras.php" method="POST">
        <input type="hidden" name="accion" value="nueva_carrera">  
        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
        <button type="submit" class="btn btn-round btn-info btn-block"><i class="fa fa-plus"></i>Agregar Carrera</button>
    </form>    
</div>
    <br><br><br>
<div class="col-md-12">
  <div class="form-group">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">DESCRIPCION</th>
          <th scope="col">TIPO SEMESTRAL</th>
          <th scope="col">OPCIONES</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($resultado_carreras as $rowcarreras) : ?>
          <tr>
            <th scope="row"><?php echo $rowcarreras['carrera_id']; ?></th>
            <td><?php echo $rowcarreras['cdescripcion_carrera']; ?></td>
            <td><?php echo $rowcarreras['cdescripcionetapatemporal_carrera']; ?></td>
            <td>
              <form action="<?php echo $carpeta_trabajo; ?>/controladores/carreras/controller.carreras.php" method="POST">
                <input type="hidden" name="accion" value="editar">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                <input type="hidden" name="carrera_id" value="<?php echo $rowcarreras['carrera_id']; ?>">
                <button type="submit" class="btn btn-warning btn-xs">EDITAR <i class="fa fa-trash"></i></button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

</div>






<?php
  include($absolute_include . "vistas/plantillas/footer.php");
?>