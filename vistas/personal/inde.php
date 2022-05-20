<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."clases/conexion.php"); 

 
?> 

<div class="title_left col-lg-8 col-md-8 col-sm-8 col-xs-8">
        <h4>Personal</h4>
</div>

<div class="clearfix"><br></div>
<!-- text para busqueda -->
<div class="title_right col-lg-8 col-md-8 col-sm-8 col-xs-8">
    <form action="<?php echo $carpeta_trabajo;?>/controladores/personal/controller.personasl.php" method="GET">
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
                            <th class="text-center">Personal ID</th>
                            <th class="text-center">Cnumlegajo_personal</th>
                            <th class="text-center">nsituacion_personal</th>
                            <th class="text-center">cobservaciones_personal</th>
                            <th class="text-center">rela_persona_id</th>
                            <th class="text-center">rela_cargo_id</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    $sql = "SELECT * FROM personales";
                    $resultado = mysqli_query($conexion, $sql);
                    ?>

                    <?php
                    while($personales = mysqli_fetch_array($resultado))
                    {
                    ?>
                       <tr>
                            <td class="text-center"><?php echo $personales['personal_id']; ?></td>
                            <td class="text-center"><?php echo $personales['cnumlegajo_personal']; ?></td>
                            <td class="text-center"><?php echo $personales['nsituacion_personal']; ?></td>
                            <td class="text-center"><?php echo $personales['cobservaciones_personal']; ?></td>
                            <td class="text-center"><?php echo $personales['rela_persona_id']; ?></td>
                            <td class="text-center"><?php echo $personales['rela_cargo_id']; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
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
