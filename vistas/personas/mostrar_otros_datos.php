<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
?> 
<?php foreach ($datos as $dato): ?>

<div class="title_left col-lg-8 col-md-8 col-sm-8 col-xs-8">
        <h4>Más Información de <?php echo $dato['capellidos_persona'];?> <spam> <?php echo $dato['cnombres_persona']; ?> </spam></h4>
</div>

<div class="clearfix"><br></div>

<div class="clearfix"><br><br></div>

<div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
                 
            <div class="x_content table-responsive">

                <table id="tabla" class="table table-stripped  nowrap cellspacing="0" width="100%">

                    <thead>
                        <div class="form-group">
                            <tr>
                                <th class="text-center">Sexo</th>
                                <td><input readonly type="text" class="form-control" value="<?php echo $dato['cdescripcion_sexo']; ?>"></td>
                                    
                            </tr>
                            <tr>    
                                <th class="text-center">Telefono</th>
                                <td><input readonly type="text" class="form-control" value="<?php echo $dato['cnumero_telefono']; ?>"></td>
                            </tr>    
                            <tr>
                                <th class="text-center">Tipo de Telefono</th>
                                <td><input readonly type="text" class="form-control" value="<?php
                                    if($dato['ntipo_telefono'] == 1){
                                        echo "Telefono Celular";
                                    }elseif($dato['ntipo_telefono'] == 2){
                                        echo "Telefono Fijo";
                                    }else{
                                        echo "Otro";
                                    }
                                ?>">
                                </td>
                                
                            </tr>    
                            <tr>
                                <th class="text-center">Barrio</th>
                                <td><input readonly type="text" class="form-control" value="<?php echo $dato['cnombre_barrio']; ?>"></td>
                            </tr>    
                            <tr>
                                <th class="text-center">Manzana</th>
                                <td><input readonly type="text" class="form-control" value="<?php echo $dato['cmanzana_direccion']; ?>"></td>
                            </tr>    
                            <tr>
                                <th class="text-center">Casa</th>
                                <td><input readonly type="text" class="form-control" value="<?php echo $dato['ccasa_direccion']; ?>"></td>
                            </tr>    
                            <tr>
                                <th class="text-center">Sector</th>
                                <td><input readonly type="text" class="form-control" value="<?php echo $dato['csector_direccion']; ?>"></td>
                            </tr>    
                            <tr>
                                <th class="text-center">Lote</th>
                                <td><input readonly type="text" class="form-control" value="<?php echo $dato['clote_direccion']; ?>"></td>
                            </tr>    
                            <tr>
                                <th class="text-center">Parcela</th>
                                <td><input readonly type="text" class="form-control" value="<?php echo $dato['cparcela_direccion']; ?>"></td>
                            </tr>    
                            <tr>
                                <th class="text-center">Calle</th>
                                <td><input readonly type="text" class="form-control" value="<?php echo $dato['cnombre_calle']; ?>"></td>
                            </tr>     
                            <tr>
                                <th class="text-center">Localidad</th>
                                <td><input readonly type="text" class="form-control" value="<?php echo $dato['cnombre_localidad']; ?>"></td>
                            </tr>    
                            <tr>
                                <th class="text-center">Provincia</th>
                                <td><input readonly type="text" class="form-control" value="<?php echo $dato['cnombre_provincia']; ?>"></td>
                            </tr>    
                            <tr>
                                <th class="text-center">País</th>
                                <td><input readonly type="text" class="form-control" value="<?php echo $dato['cnombre_pais']; ?>"></td>
                            </tr>
                        </div>
                        </thead>

                    
                    <tbody>
                        <th colspan = "2" class="text-center">Opciones</th>
                    </tbody>
                    <tfoot>
                        <th class="text-center" width='15%'>
                            <form action="<?php echo $carpeta_trabajo;?>/controladores/personas/controller.personas.php" method="POST">
                                <input type="hidden" name="accion" value="editar">
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                                <input type="hidden" name="direccion_id" value="<?php echo $direccion['direccion_id']; ?>">  
                                <button type="submit" class="btn btn-info btn-xs">Editar<i class="fa fa-edit"></i></button>
                            </form>  
                        </th>
                        <th>
                            <form action="<?php echo $carpeta_trabajo;?>/controladores/personas/controller.personas.php" method="POST">
                                <input type="hidden" name="accion" value="datos">
                                <input type="hidden" name="persona_id" value="<?php echo $dato["persona_id"]; ?> ">
                                <input type="hidden" name="textoabuscar" value="<?php $dato['cnombres_persona']; ?>  ">
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                                <button type="submit" class="btn btn-warning"><i class="fa fa-print"></i>Imprimir datos</button>
                            </form>
                        </th>      
                    </tfoot>
                </table>
            <?php endforeach; ?>
            <div class="clearfix"><br><br></div>
            <br>
            <div class="col-6">
                <input type="button" class="btn btn-danger"
                onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/personas/controller.personas.php';"
                value=Volver>
            </div>
        </div>
</div>



<?php

    include ($absolute_include."vistas/plantillas/footer.php"); 
    
?>    

