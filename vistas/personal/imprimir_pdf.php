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
   
    <h3 align="center"> Lista de Personal</h3> 
      
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
   
    <?php foreach ($personal as $personal): ?>
        <tr>
            <td><?php echo $personal['capellidos_personas']." ".$persona['cnombres_personas']; ?></td>
            <td><?php echo $personal['ndni_personas']; ?></td>
            <td><?php echo $personal['ncuil_personas']; ?></td>
            <td><?php echo $personal['cemail_personas']; ?></td>
            <td><?php echo date("d/m/Y",strtotime($personal['dfechanac_personal'])); ?></td>

        </tr>
    <?php endforeach; ?>
 
    </tbody>
    </table>

    <br>           
 

   