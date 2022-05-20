<?php 
  include ($absolute_include."clases/conexion.php");
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php");
?>
<div class="container">
  <div class="table-responsive-xl" align="center">
    <h2>Lista de Documentos</h2>


    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text" id="inputGroup-sizing-default">BUSCAR</span>
      </div>
      <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="buscar" onkeyup="buscar()" placeholder="Buscar documento">
    </div>

    <table class="table" align="center" id="tabla">
    
      <thead class="table table-striped table-dark">
        <tr align="center">
          <th>Nombre de archivo</th>
          <th>Descripcion</th>
          <th>Fecha De subida</th>
          <th>Tipo de documento</th>
          <th>Descargar</th>
          <th colspan="2">Acciones</th>
        </tr>
      </thead>
  
    <?php
      foreach($result as $datos):
    ?>
    
    <tr align="center">
      <td><?php echo $datos['cnombre_documento'];?></td>
      <td><?php echo $datos['cdescripcion_documento'];?></td>
      <td><?php echo $datos['dfecha_documento'];?></td>
    <td>
      <?php 
      $rutaDescargarDocumento = explode("/", $datos['rruta']);
      $rutaDocumento = explode("/", $datos['rruta']);
     // var_dump($rutaDescargarDocumento);
      $rutaDescargarDocumento = $rutaDescargarDocumento[1]."/"."htdocs/".$rutaDescargarDocumento[2]."/".$rutaDescargarDocumento[3]."/".$rutaDescargarDocumento[4]."/".$rutaDescargarDocumento[5];
      // echo $rutaDescargarDocumento;
     ?>
      <?php echo "$rutaDocumento[4]"; ?></td>
    <td>
      
      <button class="btn btn-primary"><a title="Descargar Archivo" href="<?php echo "$rutaDescargarDocumento" ?>" download="<?php echo "$rutaDescargarDocumento"; ?>">Descargar</a></button>
    </td>
    <td>
    	<form action="<?php echo $carpeta_trabajo; ?>/controladores/documentosvarios/controller.elementos.php" method="POST">
    		<input type="hidden" name="accion" value="editar">
    		<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
    		<input type="hidden" name="documento_id" value="<?php echo $datos['documento_id']; ?>">
    		<button type="submit" class="btn btn-info btn-xs">Editar</button> 
    	</form> 
    </td>
    <td>
    	<form action="<?php echo $carpeta_trabajo; ?>/controladores/documentosvarios/controller.elementos.php" method="POST">
        <input type="hidden" name="accion" value="eliminar">
        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
        <input type="hidden" name="eliminar" value="<?php echo $datos['documento_id']; ?>">
        <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('¿Esta seguro de eliminar el documento?')">Borrar</button> 
    	</form> 
    </td>
    </tr>
    <?php endforeach; ?>
    </table>
  </div>

</div>

</body>
<?php
   include ($absolute_include."vistas/plantillas/footer.php"); 
?>
