<?php
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php");
	?>

<div class="container" id="container">

  <div class="masthead">

    <div class="table-responsive-xl">
      <h2>Legajos de Alumnos</h2>
      <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text" id="inputGroup-sizing-default">BUSCAR</span>
      </div>
      <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="buscar" onkeyup="buscar()" placeholder="Buscar legajo">
    </div>

    <table class="table" data-sort="table" id="">
      <thead class=" table-striped table-dark">
          <th>Apellidos y Nombres</th>
          <th>DNI</th>
          <th>Número de Legajo</th>
          <th>Acciones</th>
          <th>Historial</th>
      </thead>
      <tbody>
        <?php foreach ($resultado_carreras as $rowlegajos) : ?>
        <tr align="center" scope="row">
          <td><?php echo $rowlegajos['capellidos_persona']." ".$rowlegajos['cnombres_persona']." ";?></td>
          <td><?php echo $rowlegajos['ndni_persona'];?></td>
          <td><?php echo $rowlegajos['cnumlegajo_alumno'];?></td>
          <td>
            <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#miModal<?php echo $rowlegajos['alumno_id'] ?>">Ver más</button>

            <div class="modal fade" id="miModal<?php echo $rowlegajos['alumno_id'] ?>" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content" id="content">
      
                  <div class="modal-header" style="color: black;">
                    <h4 class="modal-title" id="myModalLabel" style="color: black;" align="center">Legajo de Alumno</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                      
                  <div class="modal-body" style="color: black;">
                    <?php 
                      echo "Apellidos: ".$rowlegajos['capellidos_persona']."<br>";
                      echo "Nombres: ".$rowlegajos['cnombres_persona']."<br>";
                      echo "CUIL: ".$rowlegajos['ncuil_persona']."<br>";
                      echo "Sexo: ".$rowlegajos['cdescripcion_sexo']."<br>";
                      echo "Fecha de Nacimiento: ".$rowlegajos['dfechanac_persona']."<br>";

                      echo "N° Legajo: ".$rowlegajos['cnumlegajo_alumno']."<br>";
                      echo "Estado de Legajo: ".$rowlegajos['cestado_legajo']."<br>";

                      if ($rowlegajos['balumno_regular'] == "1"){
                        echo "Alumno regular: SI <br>";
                      }else{
                        echo "Alumno regular: NO <br>";
                      }
                            
                      if ($rowlegajos['nsituacion_alumno'] == "1"){
                        echo "Situación del alumno: Activo <br><br>";
                      }else{
                        echo "Situación del alumno: Inactivo <br><br>";
                      }
                          
                      ?>
                      <h5 style="color: black">Contacto</h5>
                      <?php
                      echo "Email: ".$rowlegajos['cemail_persona']."<br>";
                      if ($rowlegajos['ntipo_telefono'] == 1) {
                        echo "Tipo de teléfono: Celular <br>";
                      }elseif ($rowlegajos['ntipo_telefono'] == 2) {
                        echo "Tipo de teléfono: Fijo <br>";
                      }else{
                        echo "Tipo de teléfono: Otro <br>";
                      }
                      echo "Número de Teléfono: ".$rowlegajos['cnumero_telefono']."<br><br>";

                      ?>
                      <h5 style="color: black">Dirección</h5>
                      <?php

                      echo "N° de Manzana: ".$rowlegajos['cmanzana_direccion']."<br>";
                      echo "N° de Casa: ".$rowlegajos['ccasa_direccion']."<br>";
                      echo "Barrio: ".$rowlegajos['cnombre_barrio']."<br>";
                      echo "Calle: ".$rowlegajos['cnombre_calle']."<br><br>";
                    ?>
                  </div>
                  <div class="modal-footer">
                      <button class="btn btn-outline-success" onclick="javascript:window.pdf();"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> DESCARGAR</button>
                      <button class="btn btn-outline-warning" onclick="printDiv('content')"><i class="fa fa-print"></i> IMPRIMIR</button>
                      <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>CERRAR</button>
                  </div>
                </div>
              </div>
            </div>
            </td>
            <td>
              <form action="<?php echo $carpeta_trabajo; ?>/controladores/consultas/historiales_alumnos/controller.historiales_alumnos.php" method="POST">
                <input type="hidden" name="accion" value="ir_historial">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                <input type="hidden" name="alumno_id" value="<?php echo $rowlegajos['alumno_id']; ?>">
                <button type="submit" class="btn btn-outline-success">IR A HISTORIAL</button>
              </form>
            </td>
                
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- /container -->
  <?php 
   include ($absolute_include."vistas/plantillas/footer.php"); 
   ?>