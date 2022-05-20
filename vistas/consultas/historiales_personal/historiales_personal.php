<?php
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php");
	?>

<div class="container" id="container">
  <div class="table-responsive-xl" align="center">
    <h2>Historiales de Personal</h2>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text" id="inputGroup-sizing-default">BUSCAR</span>
      </div>
      <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="buscar" onkeyup="buscar()" placeholder="Buscar Historial">
    </div>
    <table class="table" id="tabla">
    
    <thead class="table table-striped table-dark">
      <tr align="center">
        <th>Apellidos y Nombres</th>
        <th>DNI</th>
        <th>Situación del Personal</th>
        <th>Fecha de Historial</th>
        <th>Historial</th>
        <th>Detalles</th>
        <th colspan="3">Acciones</th>
      </tr>
    </thead>
    <?php foreach ($resultado_carreras as $rowhistorial) : ?>
    <tr align="center">
          <td><?php echo $rowhistorial['capellidos_persona']." ".$rowhistorial['cnombres_persona']." ";?></td>
          <td><?php echo $rowhistorial['ndni_persona'];?></td>
          <td>
            <?php
              if ($rowhistorial['nsituacion_personal'] == 1) {
                echo "Activo";
              }else{
                echo "Inactivo";
              }
             ?>    
          </td>
          <td><?php echo $rowhistorial['dfecha_historial'];?></td>
          <td><textarea class="form-control" id="textarea" valu rows="4"><?php echo $rowhistorial['historial_personal'];?></textarea></td>
          <td><button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#miModal">Ver más</button></td>
          <td>
            <div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            
            <div class="modal-dialog" role="document">

              <div class="modal-content" id="content">
      
                <div class="modal-header" style="color: black;">
                  <h4 class="modal-title" id="myModalLabel" style="color: black;" align="center">Historial de Personal</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" style="color: black;">
                  <?php
                    echo "Apellidos: ".$rowhistorial['capellidos_persona']."<br>";
                    echo "Nombres: ".$rowhistorial['cnombres_persona']."<br>";
                    echo "CUIL: ".$rowhistorial['ncuil_persona']."<br>";
                    echo "Cargo: ".$rowhistorial['cdescripcion_cargo']."<br>";
                    echo "Fecha de Nacimiento: ".$rowhistorial['dfechanac_persona']."<br>";
                    echo "Sexo: ".$rowhistorial['cdescripcion_sexo']."<br>";
                    if ($rowhistorial['nsituacion_personal'] == "1"){
                      echo "Situación: Activo <br>";
                    }else{
                      echo "Situación: Inactivo <br>";
                    }
                    
                    echo "Email: ".$rowhistorial['cemail_persona']."<br><br>";
                    ?>
                      <h5 style="color: black">Contacto</h5>
                    <?php
                    
                    echo "Email: ".$rowhistorial['cemail_persona']."<br>";
                          
                    if ($rowhistorial['ntipo_telefono'] == 1) {
                      echo "Tipo de teléfono: Celular <br>";
                    }elseif ($rowhistorial['ntipo_telefono'] == 2) {
                      echo "Tipo de teléfono: Fijo <br>";
                    }else{
                      echo "Tipo de teléfono: Otro <br>";
                    }
                    
                    echo "Número de Teléfono: ".$rowhistorial['cnumero_telefono']."<br><br>";

                    ?>
                      <h5 style="color: black">Dirección</h5>
                    <?php

                    echo "N° de Manzana: ".$rowhistorial['cmanzana_direccion']."<br>";
                    echo "N° de Casa: ".$rowhistorial['ccasa_direccion']."<br>";
                    echo "Barrio: ".$rowhistorial['cnombre_barrio']."<br>";
                    echo "Calle: ".$rowhistorial['cnombre_calle']."<br><br>";

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
          </td>
          <td>
            <form action="<?php echo $carpeta_trabajo; ?>/controladores/consultas/historiales_personal/controller.historiales_personal.php" method="POST">
              <input type="hidden" name="accion" value="eliminar">
              <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
              <input type="hidden" name="eliminar" value="<?php echo $rowhistorial['historialpersonal_id']; ?>">
              <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('¿Esta seguro de eliminar el Historial?')">ELIMINAR</button>
            </form>
          </td>
          <td>
            <form action="<?php echo $carpeta_trabajo; ?>/controladores/consultas/historiales_personal/controller.historiales_personal.php" method="POST">
                <input type="hidden" name="accion" value="editar">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                <input type="hidden" name="historialpersonal_id" value="<?php echo $rowhistorial['historialpersonal_id']; ?>">
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