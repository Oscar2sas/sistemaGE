<?php
 
  include ($absolute_include."vistas/plantillas/head.php"); 
  include ($absolute_include."vistas/plantillas/sidebar.php"); 
  include ($absolute_include."vistas/plantillas/navbar.php"); 
 
?> 

<div class="title_left col-lg-8 col-md-8 col-sm-8 col-xs-8">
        <h4>Etapas Escolares</h4>
</div>

<!-- boton  para agregar -->
<div class="title_right col-lg-4 col-md-4 col-sm-4 col-xs-4">
    <form action="<?php echo $carpeta_trabajo;?>/controladores/etapasescolares/controller.etapasescolares.php" method="POST">
        <input type="hidden" name="accion" value="crear">  
        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
        <button type="submit" class="btn btn-round btn-success btn-block"><i class="fa fa-plus"></i> Agregar una Etapa</button>
    </form>    
</div>
<div class="clearfix"><br></div>
<!-- text para busqueda -->
<div class="title_right col-lg-8 col-md-8 col-sm-8 col-xs-8">
    <form action="<?php echo $carpeta_trabajo;?>/controladores/etapasescolares/controller.etapasescolares.php" method="GET">
        <input type="text"  name="textoabuscar"  value="<?php if (!empty($GLOBALS['textoabuscar'])) {echo $GLOBALS['textoabuscar'];} ?>" size="50">
        <button type="submit" class="btn btn-round btn-warning"><i class="fa fa-search"></i> Buscar</button>
    </form>    
</div>

<div class="clearfix"><br><br></div>

<div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
                 
            <div class="x_content">
            
                <table id="table" class="table table-stripped table-bordered nowrap " cellspacing="0" width="100%">

                    <thead>
                        <tr>

                            <th class="text-center">Descripcion Etapa</th>

                        </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($etapas as $etapa): ?>
                        <tr>
                           
                            <td class="text-center"><?php echo $etapa['cdescripcion_etapa']; ?></td>

                            
                            <td class="text-center" width='15%'>
                            <form action="<?php echo $carpeta_trabajo;?>/controladores/etapasescolares/controller.etapasescolares.php" method="POST">
                                <input type="hidden" name="accion" value="editar">  
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                                <input type="hidden" name="etapaescolar_id" value="<?php echo $etapa['etapaescolar_id']; ?>">  
                                <button type="submit" class="btn btn-info btn-xs">Editar <i class="fa fa-edit"></i></button>
                            </form>  
                            </td>
                            <td class="text-center" width='15%'>
                            <form action="<?php echo $carpeta_trabajo;?>/controladores/etapasescolares/controller.etapasescolares.php" method="POST">
                                <input type="hidden" name="accion" value="mostrar">  
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                                <input type="hidden" name="etapaescolar_id" value="<?php echo $etapa['etapaescolar_id']; ?>">  
                                <button type="submit" class="btn btn-danger btn-xs">Eliminar <i class="fa fa-trash"></i></button>
                            </form>  

                            </td>
                        </tr>
                    <?php endforeach; ?>
        

                </table>
                <div class="clearfix"><br></div>
                <div >
                <form action="<?php echo $carpeta_trabajo;?>/controladores/etapasescolares/controller.etapasescolares.php" method="POST">
                    <input type="hidden" name="accion" value="imprimir">  
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                    <button type="submit" class="btn btn-warning"><i class="fa fa-print"></i> Imprimir Etapas</button>
                 </form>       
                 </div>
            </div>
        </div>
</div>



<?php

    include ($absolute_include."vistas/plantillas/footer.php"); 
?>    
