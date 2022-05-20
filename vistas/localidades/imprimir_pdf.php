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
   
    <h3 align="center"> Lista de Localidades </h3> 
      
    <hr>

    <table >

    <thead>
        <tr>

            <th>Nombre de la Localidad  </th>
            <th>Provincia</th>
            <th>Pais  </th>

        </tr>
    </thead>

    <tbody>
    <?php foreach ($localidades as $localidad): ?>
        <tr>
            
            <td><?php echo $localidad['cnombre_localidad']; ?></td>
            <td><?php echo $localidad['cnombre_provincia']; ?></td>
            <td><?php echo $localidad['cnombre_pais']; ?></td>

        </tr>
    <?php endforeach; ?>
    </tbody>
    </table>

    <br>           
 

   