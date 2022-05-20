<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
?> 

<div class="title_left col-lg-8 col-md-8 col-sm-8 col-xs-8">
        <h4>Alumnos</h4>
</div>

<!-- boton  para agregar -->
<div class="title_right col-lg-4 col-md-4 col-sm-4 col-xs-4">
    <form action="<?php echo $carpeta_trabajo;?>/controladores/alumnos/controller.alumnos.php" method="POST">
        <input type="hidden" name="accion" value="crear">  
        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
        <button type="submit" class="btn btn-round btn-success btn-block"><i class="fa fa-plus"></i> Agregar Alumno</button>
    </form>    
</div>
<div class="clearfix"><br></div>
<!-- text para busqueda -->
<div class="title_right col-lg-8 col-md-8 col-sm-8 col-xs-8">
    <form action="<?php echo $carpeta_trabajo;?>/controladores/alumnos/controller.alumnos.php" method="GET">
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

                            <th class="text-center">Nombre Completo</th>
                            <th class="text-center">D.N.I.</th>
                            <th class="text-center">Cuil</th>
                            <th class="text-center">Legajo</th>
                            <th colspan = "2" class="text-center">Opciones</th>

                        </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($alumnos as $alumno): ?>
                        <tr>
                           
                            <td class="text-center"><?php echo $alumno['capellidos_persona']." ".$alumno['cnombres_persona']; ?></td>
                            <td class="text-center"><?php echo $alumno['ndni_persona']; ?></td>
                            <td class="text-center"><?php echo $alumno['ncuil_persona']; ?></td>
                            <td class="text-center"><?php echo $alumno['cnumlegajo_alumno']; ?></td>
                            <!-- <td class="text-center"><?php //echo date("d/m/Y",strtotime($alumno['dfechanac_alumno'])); ?></td> -->

                            
                            <td class="text-center" width='15%'>
                            <form action="<?php echo $carpeta_trabajo;?>/controladores/alumnos/controller.alumnos.php" method="POST">
                                <input type="hidden" name="accion" value="editar">  
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                                <input type="hidden" name="alumno_id" value="<?php echo $alumno['alumno_id']; ?>">  
                                <button type="submit" class="btn btn-info btn-xs">Editar <i class="fa fa-edit"></i></button>
                            </form>  
                            </td>
                            <td class="text-center" width='15%'>
                            <form action="<?php echo $carpeta_trabajo;?>/controladores/alumnos/controller.alumnos.php" method="POST">
                                <input type="hidden" name="accion" value="mostrar">  
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                                <input type="hidden" name="alumno_id" value="<?php echo $alumno['alumno_id']; ?>">  
                                <button type="submit" class="btn btn-danger btn-xs">Ver/Eliminar <i class="fa fa-trash"></i></button>
                            </form>  

                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                 <!-- si hay mas de 10 lineas agrega el pie de tabla -->
                 <?php if (count($alumnos)>10 ) {
                            echo "<tfoot>";       
                            echo "<tr>";
                            echo "<th class='text-center'>Nombre Completo</th>";
                            echo "<th class='text-center'>D.N.I.</th>";
                            echo "<th class='text-center'>Cuil/Cuit</th>";
                            echo "<th class='text-center'>Legajo</th>";
                            echo "<th colspan = '2' class='text-center'>Opciones</th>";
                            echo "</tr>";
                            echo "</tfoot>";        
                        }
                    ?>
  
                </table>
                <div class="clearfix"><br></div>
                <!-- BOTONES AL PIE DE LA TABLA -->

                <table  cellspacing="0" width="100%">
                    <tr>
                        <td width="90%">       
                            <form action="<?php echo $carpeta_trabajo;?>/controladores/alumnos/controller.alumnos.php" method="POST">
                                    <input type="hidden" name="accion" value="imprimir">  
                                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                                    <button type="submit" class="btn btn-warning"><i class="fa fa-print"></i> Imprimir Alumnos</button>
                                </form>       
                        </td>                 
                        <td>       
                            <input type="button" class="btn btn-info"
                                    onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/archivos/controller.archivos.php';"
                                value="Volver a Archivos">
                        </td>
                    </tr>                 
                </table>       
            </div>
        </div>
</div>

<?php

    include ($absolute_include."vistas/plantillas/footer.php"); 
?>    
