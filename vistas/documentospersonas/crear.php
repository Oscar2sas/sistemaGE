<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
?> 

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <h4>Nuevo documento</h4>

            <!-- este div es para mostrar los errorres de validacion 
                si hay errorres se muestra el div 
                y se hace un foreach de la coleccion de errores y se muestra
                en una lista -->

            <div class="alert alert-danger">
            </div>

            <!-- formulario para CARGA -->
            <form action="<?php echo $carpeta_trabajo;?>/controladores/documentospersonas/controller.documentospersonas.php?>" method="POST" enctype="multipart/form-data" autocomplete="off">
         
                 <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                 <input type="hidden" name="accion" value="insertar">  

                <div class="form-group">
                    <label for="nombre">Buscar persona por Dni</label>
                    <input type="Number" class="form-control" onkeyup="buscar()" id="text_persona">
                </div>

                <div class="form-group">
                    <label for="nombre">Persona</label>
                    <select class="form-control" name="rela_persona_id" id="combo_persona" required>
                        <option value="" selected>---</option>
                        <?php foreach ($personas as $persona): ?>
                            <option value=<?php echo $persona['persona_id']; ?> > <?php echo $persona['ndni_persona']." ".$persona['cnombres_persona']." ".$persona['capellidos_persona']; ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Documento</label><br>
                    <label for="perfil">
                    <img src="<?php echo $carpeta_trabajo;?>/storage/imagenes/upload.png" style="width:120px; height:120px;" id="vista_previa" >
                    </label>
                    <label id="info">Click en la imagen para subir foto</label>
                    
                    <input hidden type="file" class="form-control" name="cimg_documento" id="perfil" accept="image/png, .jpeg, .jpg, .png, .pdf, .docx, .xml, .xlsx" required>
                    
                    <br>
                </div>

                 
                <div class="form-group">
                    <label for="nombre">Tipo de documento</label>
                    <select class="form-control" name="rela_tipodocumento_id" required>
                        <option value="" selected>---</option>
                        <?php foreach ($tiposdoc as $tipodoc): ?>
                            <option value=<?php echo $tipodoc['tipodocumento_id']; ?> > <?php echo $tipodoc['cdescripcion_tipodocumento']; ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>


                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                                <p class="btn btn-info"><a href="<?php echo $carpeta_trabajo;?>/controladores/documentospersonas/controller.documentospersonas.php">Volver</a></p>
                        </div>
                        <div class="text-right" >
                                <button class="btn btn-success" type="submit">Guardar</button>
                                <span class="input-group-btn">
                                    <button class="btn btn-danger" id="reset" type="reset">Cancelar</button>  
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

<script>

    $("#reset").click(function(){
        $('#vista_previa').attr("src","<?php echo $carpeta_trabajo;?>/storage/imagenes/upload.png");
    });

    function buscar(){
        //value
        //console.log($("#combo_tutor1")[0][1].text.split(" ") )
        
        for(i=0; i <= $("#combo_persona")[0].length-1;i++){
            com = $("#combo_persona")[0][i];
            arr = com.text.split(" ");
            if ($("#text_persona").val() == parseInt(arr[0]) ){
                com.selected = true;
            }
        }

    };



    $("#perfil").change(mostrarImagen);


    function mostrarImagen(event) {
        //console.log(event)

        if( $("#file_error").length != 0 ){
            $("#file_error").remove();
        }

        var file = event.target.files[0];
        var reader = new FileReader();
        $("#info").html("Subiendo...");
        reader.onload = function(event) {
            $('#vista_previa').attr("src",event.target.result);
            $("#info").html("");
        }
        reader.readAsDataURL(file);
    }
</script>