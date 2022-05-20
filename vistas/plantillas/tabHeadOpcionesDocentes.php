
      <div class="card mt-12 tab-card ">
        <div class="card-header tab-card-header">
          <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">

            <li class="nav-item">
                <a class="nav-link <?php echo !empty($claseActivoVerificarHorariosDocentes) ? 'active' : '' ?>" id="" href="<?php echo $carpeta_trabajo;?>/controladores/verificarhorariosdocentes/controller.verificarhorariosdocentes.php">Verificar Horarios</a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php echo !empty($claseActivoAsistenciaAlumnosDocentes) ? 'active' : '' ?>" id="" href="<?php echo $carpeta_trabajo;?>/controladores/asistenciaalumnosdocentes/controller.asistenciaalumnosdocentes.php">Planilla Personal</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo !empty($claseActivoNotificacionesDocentes) ? 'active' : '' ?>" id="" href="<?php echo $carpeta_trabajo;?>/controladores/notificacionesdocentes/controller.notificacionesdocentes.php">Notificaciones</a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php echo !empty($claseActivoHistorialAlumnos) ? 'active' : '' ?>" id="historialalumnos" href="<?php echo $carpeta_trabajo;?>/controladores/historialalumnos/controller.historialalumnos.php?docente='true'">Historial Alumnos</a>
            </li>

        </ul>

    </div>

</div>
