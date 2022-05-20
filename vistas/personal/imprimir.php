<?php

  include ($absolute_include."vistas/plantillas/head_imprimir.php");
  include ($absolute_include."clases/conexion.php");
  
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
                <h3> Lista del Personal </h3> 
            </td>    
        </tr>
    </table>    
    <hr>

    <table  class="table table-stripped table-bordered nowrap " cellspacing="0" width="100%">

    <thead>
        <tr>
            <th class="text-center">Personal</th>
            <th class="text-center">Observaciones</th>
            <th class="text-center">Legajo</th>
            <th class="text-center">Apellido</th>
            <th class="text-center">Nombre</th>
            <th class="text-center">DNI</th>
                            

        </tr>
    </thead>

    <tbody>
    <?php
    $sql = " SELECT a1.personal_id, a1.cobservaciones_personal, a1.cnumlegajo_personal, b1.capellidos_persona, b1.cnombres_persona, a1.rela_persona_id, b1.ndni_persona, b1.persona_id FROM personales a1, personas b1 WHERE a1.rela_persona_id=b1.persona_id ";
    $resultado = mysqli_query($conexion, $sql);
    ?>

    <?php
    while($personales = mysqli_fetch_array($resultado))
    {
    ?>
        <tr>
            <td class="text-center"><?php echo $personales['personal_id']; ?></td>
            <td class="text-center"><?php echo $personales['cobservaciones_personal']; ?></td>
            <td class="text-center"><?php echo $personales['cnumlegajo_personal']; ?></td>
            <td class="text-center"><?php echo $personales['capellidos_persona'];?></td>
            <td class="text-center"><?php echo $personales['cnombres_persona'];?></td>
            <td class="text-center"><?php echo $personales['ndni_persona'];?></td>
                            
        </tr>
    <?php
        }
    ?> 
    </tbody>
    </table>
    <br>           
    <div id="botones">    
        <form action="<?php echo $carpeta_trabajo;?>/controladores/personal/controller.personal.php" target="_blank" method="POST">
            <input type="hidden" name="accion" value="pdf">  
            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  

            <button type="button" class="btn btn-info" onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/personal/controller.personal.php';" > Volver</button>
            <button type="button" onclick="javascript:window.print();" class="btn btn-warning"><i class="fa fa-print"></i> Imprimir</button>
        </form>       
    </div>    
    <BR>

    <br> 


   