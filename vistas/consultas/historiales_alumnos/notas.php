<?php
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php");
	?>

<div class="container" id="container">
  <div class="masthead">
    <style type="text/css" media="print">
      @media print {
      #filtro{
        display:none;
        }
      }
      </style>

      <div class="table-responsive-xl">
        <div id="filtro">
          <button type="button" class="btn btn-info" onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/consultas/historiales_alumnos/controller.historiales_alumnos.php';" ><i class="zmdi zmdi-arrow-left"></i> Volver a Historiales</button>
          <br><br>
        </div>
        <h1 align="center">NOTAS DEL ALUMNO</h1>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">BUSCAR</span>
          </div>
          <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="buscar" onkeyup="buscar()" placeholder="Buscar por nota, materia o etapa escolar">
        </div>
    </div>
    <div id="content" style="color: black;">
      <div id="filtro">
        <?php foreach ($resultado_carreras as $datos2) : ?>
        <h4>Alumno: <?php echo $datos2['capellidos_persona']." ".$datos2['cnombres_persona'];?></h4>
        <h4>DNI: <?php echo $datos2['ndni_persona']; ?></h4>
        <h4>Curso: <?php echo $datos2['cdescripcion_curso']; ?></h4>
        <?php endforeach; ?>
        <button type="button" class="btn btn-warning" onclick="printDiv('content')">IMPRIMIR NOTAS</button><br><br>
      <table class="table" data-sort="table" id="tabla">
        <thead class="table table-striped table-dark">
          <tr align="center">
            <th>Materia</th>
            <th>Calificación</th>
            <th>Etapa Escolar</th>
            <th>Año Lectivo</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($resultado_carreras as $datos) : ?>
          <tr align="center" scope="row">
            <td><?php echo $datos['cnombre_materia'];?></td>
            <td><?php echo $datos['ncalificacion'];?></td>
            <td><?php echo $datos['cdescripcion_etapa'];?></td>
            <td><?php echo $datos['ndescripcion_anolectivo'];?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    </div>
  </div>
</div>
  <?php 
    include ($absolute_include."vistas/plantillas/footer.php");
    ?>