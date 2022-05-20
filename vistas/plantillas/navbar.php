<!--Start topbar header-->
<header class="topbar-nav">
 <nav class="navbar navbar-expand fixed-top">
  <ul class="navbar-nav mr-auto align-items-center">
    <li class="nav-item">
      <a class="nav-link toggle-menu" href="javascript:void();">
       <i class="icon-menu menu-icon"></i>
     </a>
    </li>
  </ul>
     
  <ul class="navbar-nav align-items-center right-nav-link">
    
    <li class="nav-item">
      <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
        <span class="user-profile"><img src="<?php echo $GLOBALS['carpeta_trabajo']."/storage/usuarios/".$_SESSION['ImagenPerfil']; ?>" class="img-circle" alt="user avatar"></span>
      </a>
      <ul class="dropdown-menu dropdown-menu-right">
       <li class="dropdown-item user-details">
        <a href="javaScript:void();">
           <div class="media">
             <div class="avatar">
             <!--https://via.placeholder.com/110x110-->
             <img class="align-self-start mr-3" src="<?php echo $GLOBALS['carpeta_trabajo']."/storage/usuarios/".$_SESSION['ImagenPerfil']; ?>" alt="user avatar">
             </div>
            <div class="media-body">
              <h6 class="mt-2 user-title">Usuario: <?php
                $username = $_SESSION['NombreUsuario']; 
                if(strlen($username)>=15){
                  $username = substr($username,0,14)."...";
                }
                echo $username; 
              ?></h6>
              <h6 class="mt-2"><?php echo $_SESSION['Rol']; ?></h6>
            </div>
           </div>
          </a>
        </li>
        <!-- <li class="dropdown-divider"></li> 
        <li class="dropdown-item"><i class="icon-settings mr-2"></i> Setting</li> -->
        <li class="dropdown-divider"></li>
        <form action="<?php echo $carpeta_trabajo;?>/controladores/perfil/controller.perfil.php" method="post"> 
          <input type="hidden" name="accion" value="perfil">
          <li><i></i><input type="submit" class="dropdown-item" value="Editar Perfil"></li>
        </form>

        <form action="<?php echo $carpeta_trabajo;?>/controladores/perfil/controller.perfil.php" method="post"> 
          <input type="hidden" name="accion" value="password">
          <li><i></i><input type="submit" class="dropdown-item" value="Cambiar Contraseña"></li>
        </form>

        <li class="dropdown-item"><i class="icon-power mr-2"></i><a href="<?php echo $carpeta_trabajo;?>/administracion/logout.php">Cerrar Sesion</a></li>
      </ul>
    </li>
  </ul>
</nav>
</header>
<!--End topbar header-->

<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row">