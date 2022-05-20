<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script type="text/javascript">
            function imprimir() {
                if (window.print) {
                    window.print();
                } else {
                    alert("La función de impresion no esta soportada por su navegador.");
                }
            }
        </script>
    </head>
    <body onload="imprimir();">
        <?php

$id = $_POST['documento'];
#$archivo = $_POST['imagen']['name'];

$imagen = substr($id, 8, strlen($id));

#if ($_POST['name'] == ".pdf" ) {
    
#}

        ?>
<img width="1000" src="<?php echo $imagen; ?>" alt="">

    </body>
</html>