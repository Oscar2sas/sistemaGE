<html>
<head>
<script>
    window.onload=function(){
        // Una vez cargada la página, el formulario se enviara automáticamente.
		document.forms["formulario"].submit();
    }
    </script>

</head>
<body>
   
    <!-- formulario para volver a edicion -->
    <form id="formulario" action="<?php echo $carpeta_trabajo;?>/controladores/personal/controller.personal.php" method="POST" autocomplete="off">
    
            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
            <input type="hidden" name="accion" value="editar" >  
            
            <input type="hidden"  name="personal_id" value="<?php echo $personal_id; ?>">
    </form>
 
</body>

</html>  
