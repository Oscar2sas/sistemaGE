<?php
include ($absolute_include."vistas/plantillas/head.php"); 
include ($absolute_include."vistas/plantillas/sidebar.php"); 
include ($absolute_include."vistas/plantillas/navbar.php"); 
 
?> 

<div class="title_left col-lg-8 col-md-8 col-sm-8 col-xs-8">
        <h4>Examenes</h4>
</div>

<!-- boton  para agregar -->
<div class="title_right col-lg-4 col-md-4 col-sm-4 col-xs-4">
    <form action="<?php echo $carpeta_trabajo;?>/controladores/examenes/controller.examenes.php" method="POST">
        <input type="hidden" name="accion" value="crear">  
        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
        <button type="submit" class="btn btn-round btn-success btn-block"><i class="fa fa-plus"></i> Agregar Examenes</button>
    </form>    
</div>
<div class="clearfix"><br></div>
<!-- text para busqueda -->
<div class="title_right col-lg-8 col-md-8 col-sm-8 col-xs-8">
    <form action="<?php echo $carpeta_trabajo;?>/controladores/examenes/controller.examenes.php" method="GET">
        <input type="text"  name="textoabuscar"  value="<?php if (!empty($GLOBALS['textoabuscar'])) {echo $GLOBALS['textoabuscar'];} ?>" size="50">
        <button type="submit" class="btn btn-round btn-warning"><i class="fa fa-search"></i> Buscar</button>
    </form>    
</div>

<div class="clearfix"><br><br></div>

<div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
                 
            <div class="x_content">
            
                <table id="tabla" class="table table-responsive table-stripped table-bordered nowrap " cellspacing="0" width="100%">

                    <thead>
                        <tr>

                            <th class="text-center">Fecha</th>
                            <th class="text-center">Alumno</th>
                            <th class="text-center">Curso</th>
                            <th class="text-center">Materia</th>
                            <th class="text-center">Nota</th>
                            <th class="text-center">Año Acta</th>
                            <th colspan="2" class="text-center">Opciones</th> 


                        </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($examenes as $examenes): ?>
                        <tr>
                           
                            <td class="text-center"><?php echo $examenes['dfecha_examen']; ?></td>
                            <td class="text-center"><?php echo $examenes['capellidos_persona']." " .$examenes['cnombres_persona']; ?></td>
                            <td class="text-center"><?php echo $examenes['cdescripcion_curso']; ?></td>
                            <td class="text-center"><?php echo $examenes['cnombre_materia']; ?></td>
                            <td class="text-center"><?php echo $examenes['ncalificacion']; ?></td>
                            <td class="text-center"><?php echo $examenes['nanoacta_examen']; ?></td>
                            


                            
                            <td class="text-center" width='15%'>
                            <form action="<?php echo $carpeta_trabajo;?>/controladores/examenes/controller.examenes.php" method="POST">
                                <input type="hidden" name="accion" value="editar">  
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                                <input type="hidden" name="examen_id" value="<?php echo $examenes['examen_id']; ?>">  
                                <button type="submit" class="btn btn-info btn-xs">Editar <i class="fa fa-edit"></i></button>
                            </form>  
                            </td>
                            <td class="text-center" width='15%'>
                            <form action="<?php echo $carpeta_trabajo;?>/controladores/examenes/controller.examenes.php" method="POST">
                                <input type="hidden" name="accion" value="mostrar">  
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                                <input type="hidden" name="examen_id" value="<?php echo $examenes['examen_id']; ?>">  
                                <button type="submit" class="btn btn-danger btn-xs">Ver/Eliminar <i class="fa fa-trash"></i></button>
                            </form>  

                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>

                
                </table>
                <div class="clearfix"><br></div>
                <!-- BOTONES AL PIE DE LA TABLA -->

                <table  cellspacing="0" width="100%">
                    <tr>
                        <td width="90%">       
                            <form action="<?php echo $carpeta_trabajo;?>/controladores/examenes/controller.examenes.php" method="POST">
                                    <input type="hidden" name="accion" value="imprimir">  
                                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                                    <button type="submit" class="btn btn-warning"><i class="fa fa-print"></i> Imprimir Examen</button>
                                </form>       
                        </td>                 
                        <td>       
                            <input type="button" class="btn btn-info"
                                    onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/movimientos/controller.movimientos.php';"
                                value="Volver a Movimientos">
                        </td>
                    </tr>                 
                </table>
            </div>
        </div>
</div>



<?php

    include ($absolute_include."vistas/plantillas/footer.php"); 
?>    
