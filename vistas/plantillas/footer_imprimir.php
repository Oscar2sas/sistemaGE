    <div id="botones">    
        

        <form action="<?php echo $carpeta_trabajo;?>/controladores/paises/controller.paises.php" target="_blank" method="POST">
            <input type="hidden" name="accion" value="pdf">  
            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  

            <button type="button" class="btn btn-info" onClick = "window.location.href = '<?php echo $carpeta_trabajo;?>/controladores/paises/controller.paises.php';" > Volver</button>
            <button type="button" onclick="javascript:window.print();" class="btn btn-warning"><i class="fa fa-print"></i> Imprimir</button>
            <button type="submit" class="btn btn-warning"><i class="fa fa-print"></i> Descargar Informe</button>
        </form>       
    </div>    
    <BR>


    <style type="text/css" media="print">
    @media print {
    #botones {display:none;}
    }
    </style>

</body>
</html>