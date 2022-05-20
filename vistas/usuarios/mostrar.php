<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
?> 

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <h4>Eliminar Usuario</h4>

            <!-- este div es para mostrar los errorres de validacion 
                si hay errorres se muestra el div 
                y se hace un foreach de la coleccion de errores y se muestra
                en una lista -->

            <div class="alert alert-danger">
            </div>

            <!-- formulario para MOSTRAR -->
            <form action="<?php echo $carpeta_trabajo;?>/controladores/usuarios/controller.usuarios.php" method="POST" autocomplete="off">
         
                 <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                 <input type="hidden" name="accion" value="eliminar">  
                 
                 <input type="hidden"  name="usuario_id" value="<?php echo $usuario['usuario_id']; ?>">

                <div class="form-group">
                    <label>Perfil</label><br>
                    <img src="<?php echo $absolute_include."/storage/usuarios/".$usuario['cimg_usuario'];?>" style="width:120px; height:120px; border-radius: 100px;" id="vista_previa">
                </div>


                <div class="form-group">
                    <label for="nombre">Nombre del Usuario</label>
                    <input type="text" class="form-control"  name="cnombre_usuario" value="<?php echo $usuario['cnombre_usuario']; ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="nombre">Email del Usuario</label>
                    <input type="text" class="form-control"  name="cemail_usuario" value="<?php echo $usuario['cemail_usuario']; ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="nombre">Estado del Usuario</label>
                    <input type="text" class="form-control"  name="nestado_usuario" value="<?php
                     if($usuario['nestado_usuario'] == 1){
                        echo "ACTIVO";
                     }elseif($usuario['nestado_usuario'] == 2){
                        echo "INACTIVO";
                     }
                      
                     ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="nombre">Rol del Usuario</label>
                    <input type="text" class="form-control"  name="cdescripcion_rol" value="<?php echo $usuario['cdescripcion_rol']; ?>" readonly>
                </div>



                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                                <input type="button" class="btn btn-info"
                                onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/usuarios/controller.usuarios.php';"
                                value=Volver>
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
