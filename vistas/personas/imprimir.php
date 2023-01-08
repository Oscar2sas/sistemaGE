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

    <table width="100%">
        <tr>
            <td class="text-center">
                <h3> Lista de Personas </h3> 
            </td>    
        </tr>
    </table>    
    <hr>

    <table  class="table table-stripped table-bordered nowrap " cellspacing="0" width="100%">

    <thead>
        <tr>

            <th class="text-center">Apellido</th>
            <th class="text-center">Nombre</th>
            <th class="text-center">DNI</th>
            <th class="text-center">CUIL</th>
            <th class="text-center">Email</th>
            <th class="text-center">Fecha de Nacimiento</th>

            

        </tr>
    </thead>

    <tbody>
    <?php foreach ($persona as $persona): ?>
        <tr>
            
            <td class="text-center"><?php echo $persona['capellidos_persona']; ?></td>
            <td class="text-center"><?php echo $persona['cnombres_persona']; ?></td>
            <td class="text-center"><?php echo $persona['ndni_persona']; ?></td>
            <td class="text-center"><?php echo $persona['ncuil_persona']; ?></td>
            <td class="text-center"><?php echo $persona['cemail_persona']; ?></td>
            <td class="text-center"><?php echo $persona['dfechanac_persona']; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    </table>

    <br> 



   