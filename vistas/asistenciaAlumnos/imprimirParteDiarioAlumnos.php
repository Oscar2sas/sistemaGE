<?php
  include ($absolute_include."vistas/plantillas/head_imprimir.php");   
// var_dump($resultInasistenciaAlumnos);
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
                <h5><b>Curso:</b> <?php echo $descCurso ?> | <b> Parte Diario Alumnos Trayecto:</b> <?php echo $descTrayecto ?> </h5> 
            </td>    
        </tr>
    </table>    
    <hr>
<?php if (!empty($resultInasistenciaAlumnos)): ?>
    <table  class="table table-stripped table-bordered nowrap " cellspacing="0" width="100%">
    <thead>
        <tr>
            <th class="text-center">Nº</th>
            <th class="text-center">Apellido</th>
            <th class="text-center">Nombre</th>

        </tr>
    </thead>
    <tbody>
    <?php 
        $indice = 1;
        
        foreach ($resultInasistenciaAlumnos as $inasistenciaAlumnos): 

        ?>
        <tr>     
            <td class="text-center"><?php echo $indice; ?></td>
            <td class="text-center"><?php echo $inasistenciaAlumnos['capellidos_persona']; ?></td>
            <td class="text-center"><?php echo $inasistenciaAlumnos['cnombres_persona']; ?></td>
        </tr>
    <?php 
        $indice++;

        endforeach; 
    
    ?>
    </tbody>
    </table>
    <br>           
   <hr>
   <label>Firma Docente 1:..................................</label> <br><br>
   <label>Firma Docente 2:..................................</label>

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
        <h1 class="text-center">NO HUBO NINGUNA INASISTENCIA HOY</h1>
    <?php endif ?> 