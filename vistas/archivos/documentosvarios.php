<?php 
  include ($absolute_include."clases/conexion.php"); 
  
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php");

  ?> 
<div class="container">
  <form method="POST" action="<?php echo $carpeta_trabajo;?>/vistas/archivos/upload.php ?>" enctype="multipart/form-data" class="text-center">
    <h2 align="text-center">SUBIR DOCUMENTOS</h2>
    <label>Seleccione el tipo de documento: </label>

    <div class="form-group">
      <select name="select" method="POST" class="form-control"> 
      <?php
      include "conexion.php";
      $consulta = "SELECT * FROM tipos_documentos";
      $ejecutar = mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));
      foreach ($ejecutar as $opciones): 
       ?>
      <option value="<?php echo $opciones['tipodocumento_id']?>"><?php echo $opciones['cdescripcion_tipodocumento']?></option>
      <?php endforeach ?>
      </select>
    </div>
    <div class="form-group">
      <label>Agregue una descripción: </label>
      <input type="text" class="form-control" name="descrip" placeholder="Descripción" required>
    </div>
    <div class="custom-file">
      <input type="file" class="form-control" name="archivo" accept="image/png, .jpeg, .jpg, .pdf, .docx, .xml" required><br><br>
    </div>
    <button type="submit" class="btn btn-primary">SUBIR</button>
  </form>
</div>
  
<?php 
  include ($absolute_include."vistas/plantillas/footer.php"); 
?> 
 
 
 
