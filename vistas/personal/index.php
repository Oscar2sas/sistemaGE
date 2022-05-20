<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
  include ($absolute_include."clases/conexion.php"); 
 
?> 

<div class="title_left col-lg-8 col-md-8 col-sm-8 col-xs-8">
        <h4>Personales</h4>
</div>



<div class="title_right col-lg-4 col-md-4 col-sm-4 col-xs-4">
    <form action="<?php echo $carpeta_trabajo;?>/controladores/personal/controller.personal.php" method="GET">
    <input type="hidden" name="accion" value="crear">
    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
    <button type="submit" class="btn btn-round btn-success btn-block"><i class="fa fa-plus"></i> Agregar Personal</button>
    
    </form>    
</div>
<div class="clearfix"><br></div>
<!-- text para busqueda -->
<div class="title_right col-lg-8 col-md-8 col-sm-8 col-xs-8">
    <form action="<?php echo $carpeta_trabajo;?>/controladores/personales/controller.personal.php" method="GET">
        <input type="text"  name="textoabuscar"  value="<?php if (!empty($GLOBALS['textoabuscar'])) {echo $GLOBALS['textoabuscar'];} ?>" size="50">
        <button type="submit" class="btn btn-round btn-warning"><i class="fa fa-search"></i> Buscar</button>
    </form>    
</div>
<div class="clearfix"><br><br></div>

<div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
                 
            <div class="x_content">
            
                <table id="tabla" class="table table-stripped table-bordered nowrap cellspacing="0" width="100%">

                    <thead>
                        <tr>
                            <th class="text-center">Personal</th>
                            <th class="text-center">Observaciones</th>
                            <th class="text-center">Legajo</th>
                            <th class="text-center">Apellido</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">DNI</th>
                            <th class="text-center">CARGO</th>
                            
                            <th colspan = "2" class="text-center">Opciones</th>

                        </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($personales as $personal): ?>
                       <tr>
                            <td class="text-center"><?php echo $personal['personal_id']; ?></td>
                            <td class="text-center"><?php echo $personal['cobservaciones_personal']; ?></td>
                            <td class="text-center"><?php echo $personal['cnumlegajo_personal']; ?></td>
                            <td class="text-center"><?php echo $personal['capellidos_persona']; ?></td>
                            <td class="text-center"><?php echo $personal['cnombres_persona']; ?></td>
                            <td class="text-center"><?php echo $personal['ndni_persona']; ?></td>
                            <td class="text-center"><?php echo $personal['rela_cargo_id']; ?></td>
                            
                            <td class="text-center" width='15%'>
                            <form action="<?php echo $carpeta_trabajo;?>/controladores/personal/controller.personal.php" method="POST">
                                <input type="hidden" name="accion" value="editar">  
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                                <input type="hidden" name="personal_id" value="<?php echo $personal['personal_id']; ?>">  
                                <button type="submit" class="btn btn-info btn-xs">Editar <i class="fa fa-edit"></i></button>
                            </form>  
                            </td>
                            <td class="text-center" width='15%'>
                            <form action="<?php echo $carpeta_trabajo;?>/controladores/personal/controller.personal.php" method="POST">
                                <input type="hidden" name="accion" value="mostrar">  
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                                <input type="hidden" name="personal_id" value="<?php echo $personal['personal_id']; ?>">  
                                <button type="submit" class="btn btn-danger btn-xs">Eliminar <i class="fa fa-trash"></i></button>
                            </form>  

                            </td>
                        </tr>
                
                        <?php endforeach; ?>
                  
                    </tbody>
                </table>
                <div class="clearfix"><br></div>
                <div >
                <form action="<?php echo $carpeta_trabajo;?>/controladores/personal/controller.personal.php" method="POST">
                    <input type="hidden" name="accion" value="imprimir">  
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                    <button type="submit" class="btn btn-warning"><i class="fa fa-print"></i> Imprimir personal</button>
                 </form>       
                 </div>
            </div>
        </div>
</div>



<?php
    
    include ($absolute_include."vistas/plantillas/footer.php"); 
?>    
