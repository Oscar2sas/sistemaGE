<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php");
 
?> 
    
<div class="title_left col-lg-8 col-md-8 col-sm-8 col-xs-8">
        <h4>Personas</h4>
</div>

<!-- boton  para agregar -->
<div class="title_right col-lg-4 col-md-4 col-sm-4 col-xs-4">
    <form action="<?php echo $carpeta_trabajo;?>/controladores/personas/controller.personas.php" method="POST">
        <input type="hidden" name="accion" value="crear">  
        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
        <button type="submit" class="btn btn-round btn-success btn-block"><i class="fa fa-plus"></i> Agregar Persona</button>
    </form>    
</div>
<div class="clearfix"><br></div>
<!-- text para busqueda -->
<div class="title_right col-lg-8 col-md-8 col-sm-8 col-xs-8">
    <form action="<?php echo $carpeta_trabajo;?>/controladores/personas/controller.personas.php" method="GET">
        <input type="text"  name="textoabuscar"  value="<?php if (!empty($GLOBALS['textoabuscar'])) {echo $GLOBALS['textoabuscar'];} ?>" size="50">
        <button type="submit" class="btn btn-round btn-warning"><i class="fa fa-search"></i> Buscar</button>
    </form>    
</div>

<div class="clearfix"><br><br></div>

    <div class="col-md-12 col-sm-12 col-xs-12">
    
        <div class="x_panel">
            
            <div class="x_content table-responsive">

                <table id="tabla" class="table table-stripped table-bordered nowrap cellspacing="0" width="100%">

                    <thead>

                        <tr>
                            <th class="text-center">Apellido</th>
                            <th class="text-center">Nombres</th>
                            <th class="text-center">DNI</th>
                            <th class="text-center">Sexo</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Telefono</th>
                            <th class="text-center">Más información</th>
                            <th colspan = "2" class="text-center">Opciones</th>
                        </tr>
                        
                    </thead>

                    <tbody>
                    <?php 
                    foreach ($persona as $persona): ?>
                        <tr>
                            <td class="text-center"><?php echo $persona['capellidos_persona']; ?></td>
                            <td class="text-center"><?php echo $persona['cnombres_persona']; ?></td>
                            <td class="text-center"><?php echo $persona['ndni_persona']; ?></td>
                            <td class="text-center"><?php echo $persona['cdescripcion_sexo']; ?></td>
                            <td class="text-center"><?php echo $persona['cemail_persona']; ?></td>
                            <td class="text-center"><?php echo $persona['cnumero_telefono']; ?></td>


                            <td class="text-center" width='15%'>
                                <form action="<?php echo $carpeta_trabajo;?>/controladores/personas/controller.personas.php" method="POST">
                                    <input type="hidden" name="accion" value="mostrar">  
                                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                                    <input type="hidden" name="persona_id" value="<?php echo $persona['persona_id']; ?>">  
                                    <button type="submit" class="btn btn-success btn-xs">Ver<i class="fa fa-edit"></i></button>
                                </form>  
                            </td>

                            
                            <td class="text-center" width='15%'>
                                <form action="<?php echo $carpeta_trabajo;?>/controladores/personas/controller.personas.php" method="POST">
                                    <input type="hidden" name="accion" value="editar">  
                                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                                    <input type="hidden" name="persona_id" value="<?php echo $persona['persona_id']; ?>">  
                                    <button type="submit" class="btn btn-info btn-xs"> Editar <i class="fa fa-edit"></i></button>
                                </form>  
                            </td>
                            <td class="text-center" width='15%'>
                                <form action="<?php echo $carpeta_trabajo;?>/controladores/personas/controller.personas.php" method="POST">
                                    <input type="hidden" name="accion" value="eliminar">  
                                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                                    <input type="hidden" name="persona_id" value="<?php echo $persona['persona_id']; ?>">  
                                    <button type="submit" class="btn btn-danger btn-xs">Eliminar <i class="fa fa-trash"></i></button>
                                </form>  
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                    <tfoot>       
                        <tr>

                            <th class="text-center">Apellido</th>
                            <th class="text-center">Nombres</th>
                            <th class="text-center">DNI</th>
                            <th class="text-center">Sexo</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Telefono</th>
                            <th class="text-center">Más Información</th>
                            <th colspan = "2" class="text-center">Opciones</th>

                        </tr>
                    </tfoot>        

                </table>
                
                <div class="clearfix"><br></div>
                
            </div>
            <br>
            <div>
                <form action="<?php echo $carpeta_trabajo;?>/controladores/personas/controller.personas.php" method="POST">
                    <input type="hidden" name="accion" value="imprimir">  
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                    <button type="submit" class="btn btn-warning"><i class="fa fa-print"></i> Imprimir personas</button>
                 </form> 
            </div>      
        </div>
    </div>   




<?php
    
    include ($absolute_include."vistas/plantillas/footer.php"); 
?>    
