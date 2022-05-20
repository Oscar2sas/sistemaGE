<?php
 
  include ($absolute_include."vistas/plantillas/head_imprimir_pdf.php"); 
  
?> 

<body >
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
         <h3 aling="center"> Lista de Alummos </h3> 
    <hr>

    <table  class="table table-stripped table-bordered nowrap " cellspacing="0" width="100%">

    <thead>
        <tr>

            <th >Nombre del Alumno</th>

        </tr>
    </thead>

    <tbody>
    <?php foreach ($examenes as $examenes): ?>
        <tr>
            
            <td class="text-center"><?php echo $examenes['examen_id']; ?></td>

        </tr>
    <?php endforeach; ?>
    </tbody>
    </table>

    <br>       


   