<?php
 
  include ($absolute_include."vistas/plantillas/head_imprimir.php"); 
  
?> 

<body>
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
   
    <h3 align="center"> Lista de examenes </h3> 
  
    <hr>

    <table  class="table table-stripped table-bordered nowrap " cellspacing="0" width="100%">

       <tr>
            <td bgcolor="silver">Nombre del alumno</td>
       </tr>
   
        <?php foreach ($examen as $examenes): ?>
        <tr>
            
            <td class="text-center"><?php echo $examenes['examen_id']; ?></td>

        </tr>
        <?php endforeach; ?>
    
    </table>

    <br>       

    <div id="botones">    
        <form action="<?php echo $carpeta_trabajo;?>/controladores/examenes/controller.examenes.php" target="_blanck" method="POST">
            <input type="hidden" name="accion" value="pdf">  
            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  

            <button type="button" class="btn btn-info" onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/examenes/controller.examenes.php';" > Volver</button>
            <button type="button" onclick="javascript:window.print();" class="btn btn-warning"><i class="fa fa-print"></i> Imprimir</button>
            <button type="submit" class="btn btn-warning"><i class="fa fa-print"></i> Descargar Informe</button>
        </form>       
    </div>    
    <BR>
    

   