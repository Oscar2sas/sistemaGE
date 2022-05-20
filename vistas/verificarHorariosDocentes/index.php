<?php 


include ($absolute_include."vistas/plantillas/head.php"); 
include ($absolute_include."vistas/plantillas/sidebar2.php"); 
include ($absolute_include."vistas/plantillas/navbar.php"); 
include ($absolute_include."vistas/plantillas/tabHeadOpcionesDocentes.php"); 

?> 

<div id="contenedorFormVerificarHorariosDocentes" class="col-md-12 col-sm-12 col-xs-12">

  <!-- Titulos de la pantalla -->
  <div class="text-center">
    <h3>VERIFICAR HORARIOS</h3>
  </div>
  <hr>
  <div class="form-group">

    <?php 

    echo $result_tabla_horarios;

    ?>


  </div>
</div>


<?php 

include ($absolute_include."vistas/plantillas/footer.php"); 
?> 
