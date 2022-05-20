<?php

include ($absolute_include."vistas/plantillas/head.php"); 
include ($absolute_include."vistas/plantillas/sidebar.php"); 
include ($absolute_include."vistas/plantillas/navbar.php"); 

?> 
<div class="col-md-12 col-sm-12 col-xs-12">

    <!-- Titulos de la pantalla -->
    <div class="text-center">
        <h4>Calendario</h4>
    </div>

    <!-- boton  para agregar -->
    <!-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> -->
        <form action="<?php echo $carpeta_trabajo;?>/controladores/calendarios/controller.calendarios.php" method="POST">
            <input type="hidden" name="accion" value="agregar">  
            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
            <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Nuevo Fecha Calendario</button>
        </form>    
        <!-- </div> -->

        <div class="clearfix"><br><br></div>

        <!-- <div class="x_panel"> -->

            <!-- <div class="x_content"> -->

                <div class="table-responsive-md">

                    <table id="table" class="table table-stripped table-bordered nowrap cellspacing=" width="100%">

                        <thead class="thead-dark">
                            <tr>
<!-- SELECT `calendario_id`, `dfecha_calendario`, `cdescripcion_calendario`, `rela_anolectivo_id` FROM `calendario` WHERE 1 -->
                                <th class="text-center">ID Fecha Calendario</th>
                                <th class="text-center">Fecha Calendario</th>
                                <th class="text-center">Desc Fecha Calendario</th>
                                <th class="text-center">Año Lectivo</th>
                                <th class="text-center">Modificar</th>
                                <th class="text-center">Eliminar</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($result_calendario as $fechas): ?>
                                <tr>
                                 <td class="text-center"><?php echo $fechas['calendario_id']; ?></td>
                                 <td class="text-center"><?php echo $fechas['dfecha_calendario']; ?></td>
                                 <td class="text-center"><?php echo $fechas['cdescripcion_calendario']; ?></td>
                                 <td class="text-center"><?php echo $fechas['ndescripcion_anolectivo']; ?></td>

                                <!-- Formulario del boton EDITAR -->
                                 <td class="text-center">
                                    <form action="<?php echo $carpeta_trabajo;?>/controladores/calendarios/controller.calendarios.php" method="POST">
                                        <input type="hidden" name="accion" value="editar">  
                                        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                                        <input type="hidden" name="calendario_id" value="<?php echo $fechas['calendario_id']; ?>">  
                                        <button type="submit" class="btn btn-warning btn-xs">Editar <i class="fa fa-edit"></i></button>
                                    </form>  
                                </td>
                                <td class="text-center">
                                    <form action="<?php echo $carpeta_trabajo;?>/controladores/calendarios/controller.calendarios.php" id="eliminarFecha<?php echo $fechas['calendario_id']; ?>" method="POST">
                                        <input type="hidden" name="accion" value="eliminar">  
                                        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                                        <input type="hidden" name="calendario_id" value="<?php echo $fechas['calendario_id']; ?>">  
                                        <button type="submit" id="eliminarFechaCalendario" data-idCalendario = "<?php echo $fechas['calendario_id']; ?>" class="btn btn-danger btn-xs">Eliminar <i class="fa fa-trash"></i></button>
                                    </form>  
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>        
            <div class="clearfix"><br></div>

            <!-- </div> -->
            <!-- </div> -->
        </div>
        <?php

        include ($absolute_include."vistas/plantillas/footer.php"); 
        ?>    
