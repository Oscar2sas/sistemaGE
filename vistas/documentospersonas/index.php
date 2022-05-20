<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 

?> 

<div class="title_left col-lg-8 col-md-8 col-sm-8 col-xs-8">
        <h4>Documentos Personas</h4>
</div>

<!-- boton  para agregar -->
<div class="title_right col-lg-4 col-md-4 col-sm-4 col-xs-4">
    <form action="<?php echo $carpeta_trabajo;?>/controladores/documentospersonas/controller.documentospersonas.php" method="POST">
        <input type="hidden" name="accion" value="crear">
        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
        <button type="submit" class="btn btn-round btn-success btn-block"><i class="fa fa-plus"></i> Agregar Documento</button>
    </form>
</div>

<div class="clearfix"><br></div>

<!-- text para busqueda -->
<div class="title_right col-lg-8 col-md-8 col-sm-8 col-xs-8">
    <form action="<?php echo $carpeta_trabajo;?>/controladores/documentospersonas/controller.documentospersonas.php" method="GET">
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
                            <th class="text-center">Persona</th>
                            <th class="text-center">Tipo Documento</th>
                            <th class="text-center">Documento</th>
                            <th colspan = "3" class="text-center">Opciones</th>

                        </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($documentos as $documento): ?>
                        <tr class="<?php echo $documento['nestado_documento'] ?>">

                            <td class="text-center"><?php echo $documento['cnombres_persona']." ".$documento['capellidos_persona']; ?></td>
                            <td class="text-center"><?php echo $documento['cdescripcion_tipodocumento']; ?></td>
                            <td class="text-center"><a href="<?php echo $absolute_include."storage/documentos/".$documento['ccarpeta_documento']."/".$documento['cimg_documento']; ?>"><img width="32" src="<?php echo $absolute_include.obtener_tipo_imagen($documento['cimg_documento']);?>"></a>
                                
                            </td>

                            
                            <td class="text-center" width='15%'>
                            <form action="<?php echo $carpeta_trabajo;?>/controladores/documentospersonas/controller.documentospersonas.php" method="POST">
                                <input type="hidden" name="accion" value="editar">  
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                                <input type="hidden" name="documento_id" value="<?php echo $documento['documento_id']; ?>">  
                                <button type="submit" class="btn btn-info btn-xs">Editar <i class="fa fa-edit"></i></button>
                            </form>  
                            </td>

                            <td class="text-center" colspan="" rowspan="" headers="">
                            <form action="<?php echo $carpeta_trabajo;?>/vistas/documentospersonas/imprimir/index.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $documento['documento_id']; ?>">
                               
                                <input class="input" hidden name="documento" readonly value="<?php echo $absolute_include."storage/documentos/".$documento['ccarpeta_documento']."/".$documento['cimg_documento']; ?>"><img width="32" hidden name="imagen" src="<?php echo $absolute_include."storage/documentos/".$documento['ccarpeta_documento']."/".$documento['cimg_documento']; ?>">

                                
                                <button type="submit" class="btn btn-warning"><i class="fa fa-print"></i> Imprimir</button>
                            </form>  
                            </td>

                            <td class="text-center" width='15%'>
                            <form action="<?php echo $carpeta_trabajo;?>/controladores/documentospersonas/controller.documentospersonas.php" method="POST">
                                <input type="hidden" name="accion" value="mostrar">  
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                                <input type="hidden" name="documento_id" value="<?php echo $documento['documento_id']; ?>">  
                                <button type="submit" class="btn btn-danger btn-xs">Eliminar <i class="fa fa-trash"></i></button>
                            </form>  
                            </td>
                            
                        </tr>
                        
                    <?php endforeach; ?>

                    </tbody> 

                </table>
            <div class="clearfix"><br></div>
                <div >
                    <input type="button" class="btn btn-info" onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/tipos_documentos/controller.tipos_documentos.php';" value="Tipos de documentos">     
                 </div>
            </div>
            <div class="clearfix"><br></div>
                <div >
                <form action="<?php echo $carpeta_trabajo;?>/controladores/documentospersonas/controller.documentospersonas.php" method="POST">
                    <input type="hidden" name="accion" value="imprimir">  
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                    <button type="submit" class="btn btn-warning"><i class="fa fa-print"></i> Imprimir documentos personas</button>
                 </form>       
                 </div>
            </div>
        </div>
</div>

<?php

    include ($absolute_include."vistas/plantillas/footer.php"); 
?>    
