
      <div class="card mt-12 tab-card ">
        <div class="card-header tab-card-header">
          <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">

            <li class="nav-item">
                <a class="nav-link <?php echo !empty($claseActivoMovimientosAlumnos) ? 'active' : '' ?>" id="" href="<?php echo $carpeta_trabajo;?>/controladores/movimientosalumnos/controller.movimientosalumnos.php">Alumnos cambio de curso</a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php echo !empty($claseActivoCambioInstitucionAlumnos) ? 'active' : '' ?>" id="" href="<?php echo $carpeta_trabajo;?>/controladores/cambioinstitucionalumnos/controller.cambioinstitucionalumnos.php">Alumnos cambio de institucion</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo !empty($claseActivoReincorporacionesAlumnos) ? 'active' : '' ?>" id="" href="<?php echo $carpeta_trabajo;?>/controladores/reincorporacionesalumnos/controller.reincorporacionesalumnos.php">Reicorporaciones Alumnos</a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php echo !empty($claseActivoReportesListadosAlumnos) ? 'active' : '' ?>" id="reportesListadosAlumnos" href="<?php echo $carpeta_trabajo;?>/controladores/reportesListadosAlumnos/controller.reporteslistadosalumnos.php">Historial Alumnos</a>
            </li>

        </ul>

    </div>

</div>
