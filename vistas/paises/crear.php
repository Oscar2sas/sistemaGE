<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php");
 
?> 
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
    <style>
        #preview {
            border:2px solid #ddd;
            padding: 10px;
            border-radius:2px;
            background: none;
            width: 250px;
            height: 160px;
            margin: auto;
        }
        
        #image {
            object-fit: cover;
            width: 100%;
            height: 100%;
        }

        #preview img {
            width: 100%;
            height: 100%;
            display:block;
            object-fit: cover;
        }
    </style>
</head>
<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <h4>Nuevo Pais</h4>

            <!-- este div es para mostrar los errorres de validacion 
                si hay errorres se muestra el div 
                y se hace un foreach de la coleccion de errores y se muestra
                en una lista -->

            <div class="alert alert-danger">
            </div>

            <!-- formulario para CARGA -->
            <form action="<?php echo $carpeta_trabajo;?>/controladores/paises/controller.paises.php" method="POST" autocomplete="off">
         
                 <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                 <input type="hidden" name="accion" value="insertar">  
                 
                <div class="form-group">
                    <label for="nombre">Abreviacion del Pais</label>
                    <input type="text" class="form-control"  name="cacortacion_pais" id="cacortacion_pais" placeholder="Ejemplos ARG, CHL, PAR..." required onkeyup="javascript:this.value=this.value.toUpperCase();">
                    <br>
                    <label for="nombre">Nombre del Pais</label>
                    <input type="text" class="form-control"  name="cnombre_pais" id="cnombre_pais" placeholder="Ingrese el Nombre..." required onkeyup="javascript:this.value=this.value.toUpperCase();">
                    <br>
                    <label for="exampleFormControlFile1">Añade la imagen del pais</label>
                    <br>
                    <input type='file' class="form-control" name="cbandera" id="cbandera" placeholder="Ingrese una imagen..." required>
                    <br>
                    <label for="exampleFormControlFile1">Vista previa de la imagen</label>
                    <br>
                    <div id="preview" class="preview">
                        <div style="width: 50px; height: 50px;">
                            <script>
                                document.getElementById("cbandera").onchange = function(e) {
	                                let reader = new FileReader();
  
                                    reader.onload = function(){
                                        let preview = document.getElementById('preview'),
    		                                image = document.createElement('img');

                                        image.src = reader.result;
    
                                        preview.innerHTML = '';
                                        preview.append(image);
                                    };
 
                                    reader.readAsDataURL(e.target.files[0]);
                                }
                            </script>
                        </div>
                    </div>

                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                                <input type="button" class="btn btn-info"
                                onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/paises/controller.paises.php';"
                                value=Volver>
                        </div>
                        <div class="text-right" >
                                <button class="btn btn-success" type="submit">Guardar</button>
                                <span class="input-group-btn">
                                    <button class="btn btn-danger" type="reset">Cancelar</button>  
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
