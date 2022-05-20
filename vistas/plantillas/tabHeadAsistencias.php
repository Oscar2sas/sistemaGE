
      <div class="card mt-12 tab-card ">
        <div class="card-header tab-card-header">
          <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">

            <li class="nav-item">
                <a class="nav-link <?php echo !empty($claseActivoAsistenciaAlumnos) ? 'active' : '' ?>" id="" href="<?php echo $carpeta_trabajo;?>/controladores/asistenciaalumnos/controller.asistenciaalumnos.php">Asistencia Alumnos</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo !empty($claseActivoHistorialAlumnos) ? 'active' : '' ?>" id="" href="<?php echo $carpeta_trabajo;?>/controladores/historialalumnos/controller.historialalumnos.php">Historial Alumnos</a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php echo !empty($claseActivoNotificacionesAlumnos) ? 'active' : '' ?>" id="" href="<?php echo $carpeta_trabajo;?>/controladores/notificacionesalumnos/controller.notificacionesalumnos.php">Notificaciones Alumnos</a>
            </li>

             <li class="nav-item">
                <a class="nav-link <?php echo !empty($claseActivoAsistenciaDocente) ? 'active' : '' ?>" id="" href="<?php echo $carpeta_trabajo;?>/controladores/asistenciadocente/controller.asistenciadocente.php">Asistencia Docentes</a>
            </li>


             <li class="nav-item">
                <a class="nav-link <?php echo !empty($justificacionesAlumnos) ? 'active' : '' ?>" id="" href="<?php echo $carpeta_trabajo;?>/controladores/justificacionesalumnos/controller.justificacionesAlumnos.php">Justificaciones</a>
            </li>

        </ul>

    </div>

</div>
