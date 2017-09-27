<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo base_url();?>home">Inicio</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reservaciones <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <?php
              if (preg_match('/(HOTV)/',$this->session->userdata('permisos')) ) {
                echo '<li><a href='.base_url().'home/newReservation class="navigate">Nueva Reservacion</a></li>';
              }
             ?>
            <li><a href="<?php echo base_url();?>home/ver_reserva" class="navigate">Ver Reservaciones</a></li>
            <li role="separator" class="divider"></li>
            <!--<li><a href="#">Estacionamiento</a></li>-->
          </ul>
        </li>

        <?php
          if (preg_match('/(RESV)/',$this->session->userdata('permisos')) ) {
         ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Restaurante <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href='<?=base_url(); ?>restaurante/restaurante' >Restaurante</a></li>
            <li><a href="<?=base_url();?>restaurante/verTickets">Imprimir Tikets</a></li>
            <?php
              if (preg_match('/(PRODV)/',$this->session->userdata('permisos')) ) {
                echo '<li><a href='.base_url().'restaurante/alta_productos >Alta de Productos</a></li>';
              }
             ?>
          </ul>
        </li>
        <?php
          }
         ?>
        <!--<li><a href="#">Almacen</a></li>-->
      </ul>
      <p class="navbar-text navbar-left" id="dateNow"></p>
      <ul class="nav navbar-nav navbar-right">
        <li><a><img  src="<?=$profile_picture;?>" alt="not available" style="border-radius:25px;" height="32" width="32"></a></li>
        <li><a href="#"><?= $username;?></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Acciones <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url();?>Configuraciones/configuracion">Configuracion de Cuenta</a></li>
            <li><a href="<?=base_url();?>Configuraciones/opciones">Opciones</a></li>
            <li><a href="<?=base_url();?>login/logout">Salir</a></li>
            <!--<li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>-->
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<script>
  (function(){
    var fecha;
    var days = ["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado"];
    var months = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
    var d = new Date();
    var day = days[d.getDay()];
    var numDay = d.getDate();
    var month = months[d.getMonth()];
    var year = d.getFullYear();
    fecha = day+" "+numDay+" de "+month+" de "+year;
    $("#dateNow").html(fecha);
  })();
</script>
