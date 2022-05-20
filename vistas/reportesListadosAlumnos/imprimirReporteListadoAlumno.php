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
            <h4>Año lectivo seleccionado: <b><?php echo $arg_ano_lectivo; ?></b></h4>
            <?php if (!empty($result_alumnos_segun_estado)): ?>
                <table  class="table table-stripped table-bordered nowrap " cellspacing="0" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">Registro Nº</th>
                            <th class="text-center">Apellido</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Dni</th>
                            <th class="text-center">Estado</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $indice = 1;
                        foreach($result_alumnos_segun_estado as $res_alummnos_estado) {

                            foreach($res_alummnos_estado as $estados_alumnos) {

                                ?>
                                <tr>     
                                    <td class="text-center"><?php echo $indice; ?></td>
                                    <td class="text-center"><?php echo $estados_alumnos['capellidos_persona']; ?></td>
                                    <td class="text-center"><?php echo $estados_alumnos['cnombres_persona']; ?></td>
                                    <td class="text-center"><?php echo $estados_alumnos['ndni_persona']; ?></td>
                                    <td class="text-center"><?php echo $estados_alumnos['cdescripcion_estadoalumno']; ?></td>
                                </tr>
                                <?php 
                                $indice++;
                            }
                        }


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