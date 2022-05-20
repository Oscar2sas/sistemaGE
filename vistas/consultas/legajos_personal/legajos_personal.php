<?php
  include ($absolute_include."clases/conectar.php");
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php");

  $sql = "SELECT personas.persona_id, personales.personal_id, personas.capellidos_persona, personas.cnombres_persona, personas.ndni_persona, personas.ncuil_persona, personas.cemail_persona, personas.dfechanac_persona, sexos.cdescripcion_sexo, personales.cnumlegajo_personal, personales.nsituacion_personal, personales.cobservaciones_personal, cargos.cdescripcion_cargo, telefonos.ntipo_telefono, telefonos.cnumero_telefono, direcciones.cmanzana_direccion, direcciones.ccasa_direccion, direcciones.csector_direccion, direcciones.clote_direccion, direcciones.cparcela_direccion, direcciones.cdescripcion_direccion, barrios.cnombre_barrio, calles.cnombre_calle FROM personales INNER JOIN personas INNER JOIN sexos INNER JOIN cargos INNER JOIN telefonos INNER JOIN direcciones INNER JOIN barrios INNER JOIN calles WHERE personales.rela_persona_id = personas.persona_id AND personas.rela_sexo_id = sexos.sexo_id AND personales.rela_cargo_id = cargos.cargol_id AND telefonos.rela_persona_id = personas.persona_id AND direcciones.rela_persona_id = personas.persona_id AND barrios.barrio_id = direcciones.rela_barrio_id AND direcciones.rela_calle_id = calles.calle_id";
  $result = $mysqli->query($sql);
  ?>

<div class="container" id="container">
  <div class="masthead">

    <style type="text/css" media="print">
      @media print {
      #botones {display:none;}
      }
      </style>
      
    <div class="table-responsive-xl">
      <h2>Legajos de Personal</h2>
      <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text" id="inputGroup-sizing-default">BUSCAR</span>
      </div>
      <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="buscar" onkeyup="buscar()" placeholder="Buscar legajo">
    </div>
      <table class="table" data-sort="table" id="tabla">
        <thead class="table table-striped table-dark">
          <tr align="center">
            <th>Apellidos y Nombres</th>
            <th>DNI</th>
            <th>Número de Legajo</th>
            <th>Acciones</th>
            <th>Historial</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($resultado_carreras as $rowlegajos) : ?>
          <tr align="center" scope="row">
            <td><?php echo $rowlegajos['capellidos_persona']." ".$rowlegajos['cnombres_persona']." ";?></td>
            <td><?php echo $rowlegajos['ndni_persona'];?></td>
            <td><?php echo $rowlegajos['cnumlegajo_personal'];?></td>
            <td><button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#miModal<?php echo $rowlegajos['personal_id'] ?>">Ver más</button></td>
            <td>
              <form action="<?php echo $carpeta_trabajo; ?>/controladores/consultas/historiales_personal/controller.historiales_personal.php" method="POST">
                <input type="hidden" name="accion" value="ir_historial">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                <input type="hidden" name="personal_id" value="<?php echo $rowlegajos['personal_id']; ?>">
                <button type="submit" class="btn btn-outline-success">IR A HISTORIAL</button>
              </form>
            </td>

            <div class="modal fade" id="miModal<?php echo $rowlegajos['personal_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            
            <div class="modal-dialog" role="document">

              <div class="modal-content" id="content">
      
                <div class="modal-header" style="color: black;">
                  <h4 class="modal-title" id="myModalLabel" style="color: black;" align="center">Legajo de Personal</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" style="color: black;">
                  <?php
                    echo "Apellidos: ".$rowlegajos['capellidos_persona']."<br>";
                    echo "Nombres: ".$rowlegajos['cnombres_persona']."<br>";
                    echo "CUIL: ".$rowlegajos['ncuil_persona']."<br>";
                    echo "Cargo: ".$rowlegajos['cdescripcion_cargo']."<br>";
                    echo "Fecha de Nacimiento: ".$rowlegajos['dfechanac_persona']."<br>";
                    echo "Sexo: ".$rowlegajos['cdescripcion_sexo']."<br>";
                    if ($rowlegajos['nsituacion_personal'] == "1"){
                      echo "Situación: Activo <br>";
                    }else{
                      echo "Situación: Inactivo <br>";
                    }
                    
                    echo "Email: ".$rowlegajos['cemail_persona']."<br><br>";
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