<?php

include ($absolute_include."vistas/plantillas/head.php"); 
include ($absolute_include."vistas/plantillas/sidebar.php"); 
include ($absolute_include."vistas/plantillas/navbar.php"); 

?> 
<div class="col-md-12 col-sm-12 col-xs-12">

    <!-- Titulos de la pantalla -->
    <div class="text-center">
        <h4>Años Lectivos</h4>
    </div>

    <!-- boton  para agregar -->
    <!-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> -->
        <form action="<?php echo $carpeta_trabajo;?>/controladores/anoLectivos/controller.anolectivos.php" method="POST">
            <input type="hidden" name="accion" value="agregar">  
            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
            <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Nuevo Año lectivo</button>
        </form>    
        <!-- </div> -->

        <div class="clearfix"><br><br></div>

        <!-- <div class="x_panel"> -->

            <!-- <div class="x_content"> -->

                <div class="table-responsive-md">

                    <table id="table" class="table table-stripped table-bordered nowrap cellspacing=" width="100%">

                        <thead class="thead-dark">
                            <tr>

                                <th class="text-center">ID Año Lectivo</th>
                                <th class="text-center">Descp Año Lectivo</th>
                                <th class="text-center">Fecha Inicio</th>
                                <th class="text-center">Fecha Fin Clases</th>
                                <th class="text-center">Fecha Fin Año</th>
                                <th class="text-center">Estado Año</th>
                                <th class="text-center">Modificar</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($result_anos_lectivos as $anos): ?>
                                <tr>
                                 <td class="text-center"><?php echo $anos['anolectivo_id']; ?></td>
                                 <td class="text-center"><?php echo $anos['ndescripcion_anolectivo']; ?></td>
                                 <td class="text-center"><?php echo $anos['dfechainicio_anolectivo']; ?></td>
                                 <td class="text-center"><?php echo $anos['dfechafinclases_anolectivo']; ?></td>
                                 <td class="text-center"><?php echo $anos['dfechafin_anolectivo']; ?></td>
                                 <td class="text-center">
                                    <?php 
                                        $estado = $anos['bactivo_anolectivo'] == 1 ? 'Activo' : 'Inactivo';

                                        echo $estado;
                                    ?>
                                     
                                 </td>

                                <!-- Formulario del boton EDITAR -->
                                 <td class="text-center">
                                    <form action="<?php echo $carpeta_trabajo;?>/controladores/anolectivos/controller.anolectivos.php" method="POST">
                                        <input type="hidden" name="accion" value="editar">  
                                        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                                        <input type="hidden" name="anolectivo_id" value="<?php echo $anos['anolectivo_id']; ?>">  
                                        <button type="submit" class="btn btn-warning btn-xs">Editar <i class="fa fa-edit"></i></button>
                                    </form>  
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>        

            <!-- </div> -->
            <!-- </div> -->
        </div>
        <?php

        include ($absolute_include."vistas/plantillas/footer.php"); 
        ?>    
