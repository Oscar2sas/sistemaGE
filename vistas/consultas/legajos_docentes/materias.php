<?php
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php");
?>

<div class="container" id="container">
  <div class="masthead">
    <style type="text/css" media="print">
      @media print {
      #botones {display:none;}
      }
      </style>
    <div class="table-responsive-xl">
      <button type="button" class="btn btn-info" onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/consultas/legajos_docentes/controller.legajos_docentes.php';" ><i class="zmdi zmdi-arrow-left"></i> Volver a legajos</button><br>
      <h3 align="center">Materias dictadas por el docente</h3>
      <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text" id="inputGroup-sizing-default">BUSCAR</span>
      </div>
      <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="buscar" onkeyup="buscar()" placeholder="Buscar por materia, curso o situacion del docente">
    </div>
      <table class="table" data-sort="table" id="tabla">
        <thead class="table table-striped table-dark">
          <tr align="center">
            <th>Materia</th>
            <th>Curso</th>
            <th>Situación Docente</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($resultado_carreras as $datos) : ?>
          <tr align="center" scope="row">
            <td><?php echo $datos['cnombre_materia'];?></td>
            <td><?php echo $datos['cdescripcion_curso'];?></td>
            <td><?php echo $datos['situacion_docente'];?></td>
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