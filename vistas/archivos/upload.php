<?php
$nombre = $_FILES['archivo']['name'];
$guardado = $_FILES['archivo']['tmp_name'];
$tipo = $_FILES['archivo']['type'];
$descripcion = $_POST['descrip'];
$select = $_POST['select'];

include "../../clases/conexion.php";

$consu = "SELECT ccarpeta_documento FROM tipos_documentos WHERE tipodocumento_id = $select";
$resu = mysqli_query($conexion, $consu) or die(mysqli_error($conexion));

while($rows=mysqli_fetch_array($resu)){
    $ruta = '../../storage/documentos/'.$rows[0].'/'.$nombre;
    $dir = '../../storage/documentos/'.$rows[0].'/';
    if(!file_exists($dir)){
        mkdir($dir,0777,true);
        if(file_exists($dir)){
            if(move_uploaded_file($guardado, $ruta)){
                echo "Archivo guardado con exito";
            }else{
                echo "Archivo no se pudo guardar";
            }
        }
    }else{
        if(move_uploaded_file($guardado,$ruta)){
            // echo "Archivo guardado con exito";
        }else{
            echo "Archivo no se pudo guardar";
        }
    }
    $sql = "INSERT INTO `documentos_varios` (`documento_id`, `rela_tipodocumento_id`, `cnombre_documento`, `cdescripcion_documento`, `dfecha_documento`, `rruta`) VALUES (NULL, '$select', '$nombre', '$descripcion', NOW(), '$ruta');";
    $result = mysqli_query($conexion, $sql) or die(mysqli_error($conexion));
    if ($result) {
        echo '<script language = javascript>
        alert("Guardado correctamente")
        self.location = "../../controladores/documentosvarios/controller.documentosvarios.php"
        </script>';
    }
}
?>