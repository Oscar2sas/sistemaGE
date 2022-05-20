<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
?> 

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <h4>Eliminar Documento</h4>

            <!-- este div es para mostrar los errorres de validacion 
                si hay errorres se muestra el div 
                y se hace un foreach de la coleccion de errores y se muestra
                en una lista -->

            <div class="alert alert-danger">
            </div>

            <!-- formulario para MOSTRAR -->
            <form action="<?php echo $carpeta_trabajo;?>/controladores/documentospersonas/controller.documentospersonas.php" method="POST" autocomplete="off">
         
                 <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                 <input type="hidden" name="accion" value="eliminar">  
                 
                 <input type="hidden"  name="documento_id" value="<?php echo $documento['documento_id']; ?>">

                <div class="form-group">
                    <label for="nombre">Nombre Persona del documento</label>
                    <input type="text" class="form-control" value="<?php echo $documento['cnombres_persona']." ".$documento['capellidos_persona']; ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="nombre">Direccion Documento</label>
                    <input type="text" class="form-control" value="<?php echo $documento['cimg_documento']; ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="nombre">Tipo Documento</label>
                    <input type="text" class="form-control" value="<?php echo $documento['cdescripcion_tipodocumento']; ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="nombre">Imagen Documento</label><br>
                    <img style="width:250px; height:250px;" src="<?php echo $absolute_include."storage/documentos/".$documento['ccarpeta_documento']."/".$documento['cimg_documento']; ?>">
                </div>


                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                                <p class="btn btn-info"><a href="<?php echo $carpeta_trabajo;?>/controladores/documentospersonas/controller.documentospersonas.php">Volver</a></p>
                        </div>
                        <div class="text-right" >
                                <span class="input-group-btn">
                                    <button class="btn btn-danger" type="submit">Eliminar</button>  
                                </span>   
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>

</div>

<?php

    include ($absolute_include."vistas/plantillas/footer.php"); 
?>    
