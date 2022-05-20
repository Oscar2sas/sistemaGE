<?php
 
  include ($absolute_include."vistas/plantillas/head_imprimir_pdf.php"); 
  
?> 

<body>
    <table>
        <tr>
            <td width="20%">
                <img src="<?php echo $absolute_include.$GLOBALS['LogoEscuela']; ?>" width="75" height="75">
            </td>
            <td class="text-center">
    
                    <H3> <?php echo $GLOBALS['NombreEscuela']; ?></H3>
                    <H4> <?php echo $GLOBALS['TituloEscuela']; ?></H4>
   

            </td>
            <td width="20%">
                <h5>Fecha :
                <?php
                    echo date("d/m/y");
                ?></h5> 

                <h5>
                <?php
                    echo "Hora  :".date( "H:i:s",time());
                ?></h5> 
                <h6>
                <?php
                    echo "Usuario :".$_SESSION['NombreUsuario'];
                ?></h6> 
            </td>
        </tr>
    </table>
   
    <h3 align="center"> Lista de Personas </h3> 
      
    <hr>

    <table >

    <thead>
        <tr>

            <th>Nombre Completo</th>
            <th>D.N.I.</th>
            <th>Cuil/Cuit</th>
            <th>Email</th>
            <th>Fec.Nacimiento</th>
        </tr>
    </thead>

    <tbody>
   
    <?php foreach ($personas as $persona): ?>
        <tr>
            <td><?php echo $persona['capellidos_persona']." ".$persona['cnombres_persona']; ?></td>
            <td><?php echo $persona['ndni_persona']; ?></td>
            <td><?php echo $persona['ncuil_persona']; ?></td>
            <td><?php echo $persona['cemail_persona']; ?></td>
            <td><?php echo date("d/m/Y",strtotime($persona['dfechanac_persona'])); ?></td>

        </tr>
    <?php endforeach; ?>
 
    </tbody>
    </table>

    <br>           
 

   