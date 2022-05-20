<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
?> 

<div class="title_left col-lg-8 col-md-8 col-sm-8 col-xs-8">
        <h4>Log del sistema</h4>
</div>

<!-- boton  para agregar -->
<div class="title_right col-lg-4 col-md-4 col-sm-4 col-xs-4">
    <form action="<?php echo $carpeta_trabajo;?>/controladores/log/controller.log.php" method="POST">
        <input type="hidden" name="accion" value="crear">
        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
        <button type="submit" class="btn btn-round btn-success btn-block"><i class="fa fa-plus"></i> Agregar log</button>
    </form>    
</div>
<div class="clearfix"><br></div>

<!-- text para busqueda -->
<div class="title_right col-lg-8 col-md-8 col-sm-8 col-xs-8">
    <form action="<?php echo $carpeta_trabajo;?>/controladores/log/controller.log.php" method="GET">
        <div class="form-group">
            <label for="fecha">Fecha de busqueda:</label>
            <input type="date" required id="fecha" name="fechabuscar" value="<?php echo date("Y-m-d"); ?>" class="form-control" style="width:200px">
        </div>


    </form> 
</div>

<div class="clearfix"><br><br></div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="masthead">
        <div class="x_panel">
                 
            <div class="x_content">
            
                <table id="table" class="table" cellspacing="0" width="100%">

                    <thead class="table-striped table-dark">
                        <tr>
                            <th class="text-center">Usuario</th>
                            <th class="text-center">Descripcion</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Hora</th>
                            <th class="text-center">Opciones</th>

                        </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($logs as $log): ?>
                        <tr>

                            <td class="text-center"><?php echo $log['cnombre_usuario']; ?></td>
                            <td class="text-center"><?php echo $log['cdescripcion_log']; ?></td>
                            <td class="text-center"><?php echo $log['dfecha_log']; ?></td>
                            <td class="text-center"><?php echo $log['chora_log']; ?></td>

                            
                            <td class="text-center">
                            <form action="<?php echo $carpeta_trabajo;?>/controladores/log/controller.log.php" method="POST">
                                <input type="hidden" name="accion" value="editar">  
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                                <input type="hidden" name="log_id" value="<?php echo $log['log_id']; ?>">  
                                <button type="submit" class="btn btn-info btn-xs">Editar <i class="fa fa-edit"></i></button>
                            </form>  
                            </td>

                      

                        </tr>
                        
                    <?php endforeach; ?>

                    </tbody>
      

                </table>
                <div class="clearfix"><br></div>
                <div >
                <form action="<?php echo $carpeta_trabajo;?>/controladores/log/controller.log.php" method="POST">
                    <input type="hidden" name="accion" value="imprimir">  
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                    <button type="submit" class="btn btn-warning"><i class="fa fa-print"></i> Imprimir Logs</button>
                 </form>       
                 </div>
            </div>
        </div>
    </div>
</div>

<?php

    include ($absolute_include."vistas/plantillas/footer.php"); 
?>    
