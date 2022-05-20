<?php
  include ($absolute_include."clases/conectar.php");
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php");

  $iddocumento = $_POST['documento_id'];
  $textarea = $_POST['textarea'];

  $sql = "UPDATE `documentos_varios` SET `cdescripcion_documento`= '$textarea' WHERE documentos_varios.documento_id = '$iddocumento'";
  $result = $mysqli->query($sql);

  if (!$result) {
	    echo '<script language = javascript>
  		alert("Error al modificar el documento, intente nuevamente")
		self.location =  "'.$carpeta_trabajo.'/controladores/consultas/controller.elementos.php ?>"
  		</script>';
	}else{
		echo '<script language = javascript>
  		alert("Se ha modificado el documento correctamente!")
		self.location =  "'.$carpeta_trabajo.'/controladores/consultas/controller.elementos.php ?>"
  		</script>';
	}
  ?>