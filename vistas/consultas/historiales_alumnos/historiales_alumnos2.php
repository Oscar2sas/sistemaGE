<?php
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php");
	?>

<div class="container" id="container">
  <div class="table-responsive-xl" align="center">
    <h2>Historial del alumno</h2>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text" id="inputGroup-sizing-default">BUSCAR</span>
      </div>
      <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="buscar" onkeyup="buscar()" placeholder="Buscar Historial">
    </div>
    <table class="table" align="center" id="tabla">
    
    <thead class="table table-striped table-dark">
      <tr align="center">
        <th>Apellidos y Nombres</th>
        <th>DNI</th>
        <th>Fecha de Historial</th>
        <th>Historial alumno</th>
        <th>Detalle</th>
        <th>Notas</th>
        <th colspan="2">Acciones</th>
      </tr>
    </thead>
  
    <?php foreach ($resultado_carreras as $rowhistorial) : ?>
    <tr align="center">
          <td><?php echo $rowhistorial['capellidos_persona']." ".$rowhistorial['cnombres_persona']." ";?></td>
          <td><?php echo $rowhistorial['ndni_persona'];?></td>
          <td><?php echo $rowhistorial['dfecha_historial'];?></td>
          <td><textarea class="form-control" id="textarea" valu rows="4"><?php echo $rowhistorial['historial_alumno'];?></textarea></td>
    
          <td><button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#miModal<?php echo $rowhistorial['historialalumno_id'] ?>">Ver detalles</button></td>
          <td>
            <form action="<?php echo $carpeta_trabajo; ?>/controladores/consultas/historiales_alumnos/controller.historiales_alumnos.php" method="POST">
              <input type="hidden" name="accion" value="ver_notas">
              <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
              <input type="hidden" name="alumno_id" value="<?php echo $rowhistorial['alumno_id']; ?>">
              <button type="submit" class="btn btn-outline-success">VER NOTAS</button>
            </form>
          </td>
                <div class="modal fade" id="miModal<?php echo $rowhistorial['historialalumno_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            
                  <div class="modal-dialog" role="document">

                    <div class="modal-content" id="content">
      
                      <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel" style="color: black;">Historial de Alumno</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      
                      <div class="modal-body" style="color: black;" align="left">
                        <?php

                          echo "Apellidos: ".$rowhistorial['capellidos_persona']."<br>";
                          echo "Nombres: ".$rowhistorial['cnombres_persona']."<br>";
                          echo "CUIL: ".$rowhistorial['ncuil_persona']."<br>";

                          if ($rowhistorial['balumno_regular'] == "1"){
                            echo "Alumno regular: SI <br>";
                          }else{
                            echo "Alumno regular: NO <br>";
                          }
                            
                          if ($rowhistorial['nsituacion_alumno'] == "1"){
                            echo "Situaci??n del alumno: Activo <br>";
                          }else{
                            echo "Situaci??n del alumno: Inactivo <br>";
                          }
                          
                          echo "Estado del Alumno: ".$rowhistorial['cdescripcion_estadoalumno']."<br><br>";
                          
                          ?>
                            <h5 style="color: black">Tutores</h5>
                          <?php
                          /*
                          while($datoss=mysqli_fetch_assoc($result2)){
                            echo "Tutor 1: <br>";
                            echo "Nombre: ".$datoss['capellidos_persona']." ".$datoss['cnombres_persona']." <br>";
                            echo "Email: ".$datoss['cemail_persona']."<br>";
                            if ($datoss['ntipo_telefono'] == 1) {
                              echo "Tipo de tel??fono: Celular <br>";
                            }elseif ($datoss['ntipo_telefono'] == 2) {
                              echo "Tipo de tel??fono: Fijo <br>";
                            }else{
                              echo "Tipo de tel??fono: Otro <br>";
                            }
                              echo "Tel??fono: ".$datoss['cnumero_telefono']."<br><br>";
                            }
                          
                          while($datosss=mysqli_fetch_assoc($result3)){
                            echo "Tutor 2: <br>";
                            echo "Nombre: ".$datosss['capellidos_persona']." ".$datoss['cnombres_persona']." <br>";
                            echo "Email: ".$datosss['cemail_persona']."<br>";
                            if ($datosss['ntipo_telefono'] == 1) {
                              echo "Tipo de tel??fono: Celular <br>";
                            }elseif ($datosss['ntipo_telefono'] == 2) {
                              echo "Tipo de tel??fono: Fijo <br>";
                            }else{
                              echo "Tipo de tel??fono: Otro <br>";
                            }
                            echo "Tel??fono: ".$datosss['cnumero_telefono']."<br><br>";
                          }

                          while($datossss=mysqli_fetch_assoc($result4)){
                            echo "Tutor 3: <br>";
                            echo "Nombre: ".$datossss['capellidos_persona']." ".$datoss['cnombres_persona']." <br>";
                            echo "Email: ".$datossss['cemail_persona']."<br>";
                            if ($datossss['ntipo_telefono'] == 1) {
                              echo "Tipo de tel??fono: Celular <br>";
                            }elseif ($datossss['ntipo_telefono'] == 2) {
                              echo "Tipo de tel??fono: Fijo <br>";
                            }else{
                              echo "Tipo de tel??fono: Otro <br>";
                            }
                            echo "Tel??fono: ".$datosssss['cnumero_telefono']."<br><br>";
                          }*/
                        ?>
                      </div>
                      <div class="modal-footer">
                        <div name="botones" align="center" id="botones" style="color: black;">
                          <a role="button" class="btn btn-outline-success" onclick="javascript:window.pdf();"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> DESCARGAR</a>
                          <a role="button" class="btn btn-outline-warning" onclick="printDiv('content')" ><i class="fa fa-print"></i> IMPRIMIR</a>
                          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> CERRAR</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
          </th> 
          <td>
            <form action="<?php echo $carpeta_trabajo; ?>/controladores/consultas/historiales_alumnos/controller.historiales_alumnos.php" method="POST">
              <input type="hidden" name="accion" value="eliminar">
              <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
              <input type="hidden" name="eliminar" value="<?php echo $rowhistorial['historialalumno_id']; ?>">
              <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('??Esta seguro de eliminar el Historial?')">ELIMINAR</button>
            </form>
          </td>
          <td>
            <form action="<?php echo $carpeta_trabajo; ?>/controladores/consultas/historiales_alumnos/controller.historiales_alumnos.php" method="POST">
              <input type="hidden" name="accion" value="editar">
              <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
              <input type="hidden" name="historialalumno_id" value="<?php echo $rowhistorial['historialalumno_id']; ?>">
              <button type="submit" class="btn btn-info btn-xs">EDITAR</button>
            </form>
          </td>
    </tr>
    <?php endforeach; ?>
    </table>
  </div>
</div>
  

<?php 
   include ($absolute_include."vistas/plantillas/footer.php"); 
  ?> 