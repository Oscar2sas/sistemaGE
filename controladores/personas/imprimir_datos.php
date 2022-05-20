<?php

  include ($absolute_include."vistas/plantillas/head_imprimir.php"); 
  
?>

<body bgcolor="lightgreen">
    <table width="100%">
        <tr>
            <td width="20%">
                <img src="<?php echo $absolute_include.$GLOBALS['LogoEscuela']; ?>" width="75" height="75">
            </td>
            <td class="text-center">

                <H3>
                    <?php echo $GLOBALS['NombreEscuela']; ?>
                </H3>
                <H4>
                    <?php echo $GLOBALS['TituloEscuela']; ?>
                </H4>


            </td>
            <td width="20%">
                <h6>Fecha :
                    <?php
                    echo date("d/m/y");
                ?>
                </h6>

                <h6>
                    <?php
                    echo "Hora  :".date( "H:i:s",time());
                ?>
                </h6>
                <h6>
                    <?php
                    echo "Usuario :".$_SESSION['NombreUsuario'];
                ?>
                </h6>
            </td>
        </tr>
    </table>
    <hr>

    <table width="100%">
        <tr>
            <td class="text-center">
                <h3> Datos de la Persona </h3>
            </td>
        </tr>
    </table>
    <hr>

    <table class="table table-stripped table-bordered nowrap " cellspacing="0" width="100%">

        <thead>
            <tr>
                <th colspan="2" class="text-center">Personas</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($datos as $datos): 
                $id=$datos['persona_id'];
            ?>

            <tr>
                <th class="text-center" style="width:50%">Apellido: </th>
                <td class="text-center">
                    <?php echo $datos['capellidos_persona']; ?>
                </td>
            </tr>
            <tr>
                <th class="text-center" style="width:50%">Nombre Completo: </th>
                <td class="text-center">
                    <?php echo $datos['cnombres_persona']; ?>
                </td>
            </tr>
            <tr>
                <th class="text-center" style="width:50%">DNI: </th>
                <td class="text-center">
                    <?php echo $datos['ndni_persona'];?>
                </td>
            </tr>
            <tr>
                <th class="text-center" style="width:50%">Sexo de la Persona: </th>
                <td class="text-center">
                    <?php echo $datos['cdescripcion_sexo']; ?>
                </td>
            </tr>
            <tr>
                <th class="text-center" style="width:50%">Fecha de Nacimiento: </th>
                <td class="text-center">
                    <?php echo $datos['dfechanac_persona']; ?>
                </td>
            </tr>
            <tr>
                <th class="text-center" style="width:50%">Nombre Completo: </th>
                <td class="text-center">
                    <?php echo $datos['ncuil_persona']; ?>
                </td>
            </tr>
            <tr>
                <th class="text-center" style="width:50%">Correo Electronico / Email: </th>
                <td class="text-center">
                    <?php echo $datos['cemail_persona']; ?>
                </td>
            </tr>
            <tr>
                <th class="text-center" style="width:50%">Telefono: </th>
                <td class="text-center">
                    <?php echo $datos['cnumero_telefono']; ?>
                </td>
            </tr>
            </tbody>
            <thead>
                <tr>
                    <th colspan="2" class="text-center">Direcciones</th>
                </tr>
            </thead>
            <tr>
                <th class="text-center">Barrio</th>
                <td class="text-center">
                    <?php echo $datos['cnombre_barrio']; ?>
                </td>
            </tr>
            <tr>
                <th class="text-center">Manzana</th>
                <td class="text-center">
                    <?php echo $datos['cmanzana_direccion']; ?>
                </td>
            </tr>
            <tr>
                <th class="text-center">Casa</th>
                <td class="text-center">
                    <?php echo $datos['ccasa_direccion']; ?>
                </td>
            </tr>
            <tr>
                <th class="text-center">Sector</th>
                <td class="text-center">
                    <?php echo $datos['csector_direccion']; ?>
                </td>
            </tr>
            <tr>
                <th class="text-center">Lote</th>
                <td class="text-center">
                    <?php echo $datos['clote_direccion']; ?>
                </td>
            </tr>
            <tr>
                <th class="text-center">Parcela</th>
                <td class="text-center">
                    <?php echo $datos['cparcela_direccion']; ?>
                </td>
            </tr>
            <tr>
                <th class="text-center">Calle</th>
                <td class="text-center">
                    <?php echo $datos['cnombre_calle']; ?>
            </td>
            </tr>
            <tr>
                <th class="text-center">Localidad</th>
                <td class="text-center">
                    <?php echo $datos['cnombre_localidad']; ?>
                </td>
            </tr>
            <tr>
                <th class="text-center">Provincia</th>
                <td class="text-center">
                    <?php echo $datos['cnombre_provincia']; ?>
                </td>
            </tr>
            <tr>
                <th class="text-center">País</th>
                <td class="text-center">
                    <?php echo $datos['cnombre_pais']; ?>
                </td>
            </tr>
            </div>
        </tbody>
    </table>
    
    <br>
    <?php endforeach; ?>