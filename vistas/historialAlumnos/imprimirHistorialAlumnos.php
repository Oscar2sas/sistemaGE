<?php
  include ($absolute_include."vistas/plantillas/head_imprimir.php"); 
?>

     

    <table width="100%">
        <tr>
            <td width="20%">
                <img src="<?php echo $absolute_include.$GLOBALS['LogoEscuela']; ?>" width="75" height="75">
            </td>
            <td class="text-center">
                    <H3> <?php echo $GLOBALS['NombreEscuela']; ?></H3>
                    <H4> <?php echo $GLOBALS['TituloEscuela']; ?></H4>
            </td>
            <td width="20%">
                <h6>Fecha :
                <?php
                    echo date("d/m/y");
                ?></h6> 

                <h6>
                <?php
                    echo "Hora  :".date( "H:i:s",time());
                ?></h6> 
                <h6>
                <?php
                    echo "Usuario :".$_SESSION['NombreUsuario'];
                ?></h6> 
            </td>
        </tr>
    </table>
    <hr>
    <table width="100%" class="table table-bordered">
        <tr>
            <td class="text-center">
                <h5>  </h5> 
                <h5>
                    <?php foreach ($result_busqueda_historial_alumno as $key => $alumno): ?>
                        
                    <b>HISTORIAL DEL ALUMNO:  </b> <?php echo $alumno['capellidos_persona']." ".$alumno['cnombres_persona']; ?>
                    <?php endforeach ?>

                    <b>FECHA INICIO: <?php echo $fechaInicioHistorialAlumnos; ?></b> 

                    <b>FECHA HASTA: <?php echo $fechaFinHistorialAlumnos; ?></b>
                </h5> 
            </td>    
        </tr>
    </table>    
    <hr>
<?php if (!empty($result_busqueda_historial_alumno)): ?>
    <table  class="table table-stripped table-bordered nowrap " cellspacing="0" width="100%">
    <thead>
        <tr>
            <th class="text-center">Registro Nº</th>
            <th class="text-center">Desripcion</th>

        </tr>
    </thead>
    <tbody>
    <?php 
        $indice = 1;
        
        foreach ($result_busqueda_historial_alumno as $descr_historial_alumnos): 

        ?>
        <tr>     
            <td class="text-center"><?php echo $indice; ?></td>
            <td class="text-center"><?php echo $descr_historial_alumnos['historial_alumno']; ?></td>
        </tr>
    <?php 
        $indice++;

        endforeach; 
    
    ?>
    </tbody>
    </table>
    <br>           

            <div id="botones">
                <button type="button" class="btn btn-info" onClick = "javascript:window.close();" > Volver</button>

            <button type="button" onclick="javascript:window.print();" class="btn btn-warning"><i class="fa fa-print"></i> Imprimir</button>
            </div>

    <style type="text/css" media="print">
    @media print {
    #botones {display:none;}
    }
    </style>
    <?php else: ?>
        <h1 class="text-center">NO HAY NINGÙN REGISTRO DE HISTORIAL, POR FAVOR VERIFIQUE LAS FECHAS</h1>
    <?php endif ?> 