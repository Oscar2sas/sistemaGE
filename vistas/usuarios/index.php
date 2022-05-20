<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
?> 

<script>
    function Ocultar(v){
        if(v == 0){
            $(".1").show("slow");
            $(".2").show("slow");
        }else if(v == 1){
            $(".1").show("slow");
            $(".2").hide("slow");
        }else if(v == 2){
            $(".2").show("slow");
            $(".1").hide("slow");
        }
    }
</script>

<div class="title_left col-lg-8 col-md-8 col-sm-8 col-xs-8">
        <h4>Usuarios</h4>
</div>

<!-- boton  para agregar -->
<div class="title_right col-lg-4 col-md-4 col-sm-4 col-xs-4">
    <form action="<?php echo $carpeta_trabajo;?>/controladores/usuarios/controller.usuarios.php" method="POST">
        <input type="hidden" name="accion" value="crear">
        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
        <button type="submit" class="btn btn-round btn-success btn-block"><i class="fa fa-plus"></i> Agregar Usuario</button>
    </form>    
</div>
<div class="clearfix"><br></div>

<!-- text para busqueda -->
<div class="title_right col-lg-8 col-md-8 col-sm-8 col-xs-8">
    <form action="<?php echo $carpeta_trabajo;?>/controladores/usuarios/controller.usuarios.php" method="GET">
        <input type="text"  name="textoabuscar"  value="<?php if (!empty($GLOBALS['textoabuscar'])) {echo $GLOBALS['textoabuscar'];} ?>" size="50">
        <button type="submit" class="btn btn-round btn-warning"><i class="fa fa-search"></i> Buscar</button>
        <br>
        <input type="radio" name="estado" value=1 onclick="Ocultar(1)">
        <label>Activos</label>
        
        <input type="radio" name="estado" value=2 onclick="Ocultar(2)">
        <label>Inactivos</label>
        
        <input type="radio" selected name="estado" value="" onclick="Ocultar(0)" checked>
        <label>Todos</label>
    
    </form> 
</div>

<div class="clearfix"><br><br></div>

<div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
                 
            <div class="x_content">
            
                <table id="tabla" class="table table-stripped table-bordered nowrap cellspacing="0" width="100%">

                    <thead>
                        <tr>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Usuario</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Rol</th>
                            <th colspan = "2" class="text-center">Opciones</th>

                        </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr class="<?php echo $usuario['nestado_usuario'] ?>">
                            <td class="text-center">
                            <?php 
                                if ($usuario['nestado_usuario'] == 1){
                                    echo "ACTIVO";
                                }
                                else if ($usuario['nestado_usuario'] == 2){
                                    echo "INACTIVO";
                                }
                            ?>
                            </td>

                            <td class="text-center"><?php echo $usuario['cnombre_usuario']; ?></td>
                            <td class="text-center"><?php echo $usuario['cemail_usuario']; ?></td>
                            <td class="text-center"><?php echo $usuario['cdescripcion_rol']; ?></td>

                            
                            <td class="text-center" width='15%'>
                            <form action="<?php echo $carpeta_trabajo;?>/controladores/usuarios/controller.usuarios.php" method="POST">
                                <input type="hidden" name="accion" value="editar">  
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                                <input type="hidden" name="usuario_id" value="<?php echo $usuario['usuario_id']; ?>">  
                                <button type="submit" class="btn btn-info btn-xs">Editar <i class="fa fa-edit"></i></button>
                            </form>  
                            </td>

                            <?php if ($usuario['nestado_usuario'] == 1){ ?>
                            <td class="text-center" width='15%'>
                            <form action="<?php echo $carpeta_trabajo;?>/controladores/usuarios/controller.usuarios.php" method="POST">
                                <input type="hidden" name="accion" value="mostrar">  
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                                <input type="hidden" name="usuario_id" value="<?php echo $usuario['usuario_id']; ?>">  
                                <button type="submit" class="btn btn-danger btn-xs">Eliminar <i class="fa fa-trash"></i></button>
                            </form>  
                            </td>
                            <?php } ?>
                        </tr>
                        
                    <?php endforeach; ?>

                    </tbody>
                    <tfoot>       
                        <tr>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Usuario</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Rol</th>
                            <th colspan = "2" class="text-center">Opciones</th>

                        </tr>
                    </tfoot>        

                </table>

        </div>
</div>

<?php

    include ($absolute_include."vistas/plantillas/footer.php"); 
?>    
