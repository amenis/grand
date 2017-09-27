<div class="container" id="config">
  <ul class="nav nav-tabs">
     <li class="active"><a data-toggle="tab" href="#home">Usuarios</a></li>
     <?php
       if (preg_match('/(CONFV)/',$this->session->userdata('permisos')) ) {
         echo '<li><a data-toggle="tab" href="#menu1">Habitaciones</a></li>';
       }
      ?>
      <?php
        if (preg_match('/(MAILV)/',$this->session->userdata('permisos')) ) {
          echo '<li><a data-toggle="tab" href="#menu2">Correo</a></li>';
        }
       ?>
     <!--<li><a data-toggle="tab" href="#menu3">Reportes</a></li>-->
   </ul>

   <div class="tab-content">
     <div id="home" class="tab-pane fade in active">
       <h2>Usuarios</h2>
       <div class="panel panel-default">
         <div class="panel-body">
           <?php
             if (preg_match('/(UC)/',$this->session->userdata('permisos')) ) {
            ?>
           <img src="<?=base_url();?>images/iconos/nuevo.png" width="32" height="32" style="position:relative; left:80%;"alt="Nuevo" data-toggle="modal" data-target="#nuevo">
           <?php
            }
            ?>
           <table class="table " >
             <thead>
               <tr>
                 <th>Nombre</th>
                 <th>telefono</th>
                 <th>Correo</th>
                 <th>Opciones</th>
               </tr>
             </thead>
             <tbody >
               <tr v-for="todos in alluser" v-bind:class="todos.status == 1 ? 'default' : 'danger' ">
                 <td >{{todos.nombre}}</td>
                 <td>{{todos.telefono}}</td>
                 <td>{{todos.correo}}</td>
                 <td>
                   <button class="btn btn-info" name="button" v-on:click="ver(todos.idusuario)">ver</button>
                   <?php
                     if (preg_match('/(UC)/',$this->session->userdata('permisos')) ) {
                       echo ' <button class="btn btn-danger" name="button" v-on:click="usuario_baja(todos.idusuario)" :disabled="todos.status == 0 ? true : false">Eliminar</button>';
                     }
                    ?>
                   <!--<button class="btn btn-primary" name="button">Registros</button>-->
                 </td>
               </tr>
             </tbody>
           </table>
         </div>
       </div>
       <div id="infouser" class="modal fade" role="dialog">
         <div class="modal-dialog modal-lg">
           <div class="modal-content">
             <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Informacion Personal</h4>
             </div>
             <div class="modal-body" >
              <form id="frm-info" class="form-horizontal" v-for="user in verusuario" >
                <div class="form-group">
                  <label class="control-label col-sm-2">Nombre</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" name="nombre" :value="user.nombre">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Telefono</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" name="telefono" :value="user.telefono">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Correo</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" name="correo" :value="user.correo">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Usuario</label>
                  <div  class="col-sm-7">
                    <input type="text" class="form-control" name="user" :value="user.user">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Password</label>
                  <div  class="col-sm-7">
                    <input type="password" class="form-control" name="pass" :value="user.pass">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Permisos</label>
                  <div  class="col-sm-7">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th style="text-align: center;"></th>
                          <th>Ver</th>
                          <th>Agregar</th>
                          <th>Cancelar y Eliminar</th>
                          <th>Modificar</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $habilitado;
                          if (preg_match('/(UM)/',$this->session->userdata('permisos')) ) {
                            $habilitado = "";
                           }
                          else{
                            $habilitado = "disabled=disabled";
                          }
                         ?>
                        <tr class="text-center">
                          <td>Reservaciones</td>
                          <td><input type="checkbox" name="pos1" value="HOTV" :checked="user.permiso.split(',')[0] == 'HOTV' ? true : false " <?php echo $habilitado ?> ></td>
                          <td><input type="checkbox" name="pos2" value="HOTA" :checked="user.permiso.split(',')[1] == 'HOTA' ? true : false " <?php echo $habilitado ?> ></td>
                          <td><input type="checkbox" name="pos3" value="HOTC" :checked="user.permiso.split(',')[2] == 'HOTC' ? true : false " <?php echo $habilitado ?> ></td>
                          <td><input type="checkbox" name="pos4" value="HOTM" :checked="user.permiso.split(',')[3] == 'HOTM' ? true : false " <?php echo $habilitado ?> ></td>
                        </tr>
                        <tr class="text-center">
                          <td>Restaurante</td>
                          <td><input type="checkbox" name="pos5" value="RESV" :checked="user.permiso.split(',')[4] == 'RESV' ? true : false " <?php echo $habilitado ?> ></td>
                          <td><input type="checkbox" name="pos6" value="RESA" :checked="user.permiso.split(',')[5] == 'RESA' ? true : false " disabled></td>
                          <td><input type="checkbox" name="pos7" value="RESC" :checked="user.permiso.split(',')[6] == 'RESC' ? true : false " <?php echo $habilitado ?> ></td>
                          <td><input type="checkbox" name="pos8" value="RESM" :checked="user.permiso.split(',')[7] == 'RESM' ? true : false " disabled></td>
                        </tr>
                        <tr class="text-center">
                          <td>Productos</td>
                          <td><input type="checkbox" name="pos9" value="PRODV" :checked="user.permiso.split(',')[8] == 'PRODV' ? true : false " <?php echo $habilitado ?> ></td>
                          <td><input type="checkbox" name="pos10" value="PRODA" :checked="user.permiso.split(',')[9] == 'PRODA' ? true : false " <?php echo $habilitado ?> ></td>
                          <td><input type="checkbox" name="pos11" value="PRODC" :checked="user.permiso.split(',')[10] == 'PRODC' ? true : false " <?php echo $habilitado ?> ></td>
                          <td><input type="checkbox" name="pos12" value="PRODM" :checked="user.permiso.split(',')[11] == 'PRODM' ? true : false " <?php echo $habilitado ?> ></td>
                        </tr>
                        <tr class="text-center">
                          <td>Ver y Crear Usuarios</td>
                          <td><input type="checkbox" name="pos13" value="UV" :checked="user.permiso.split(',')[12] == 'UV' ? true : false " <?php echo $habilitado ?> ></td>
                          <td><input type="checkbox" name="pos14" value="UA" :checked="user.permiso.split(',')[13] == 'UA' ? true : false " <?php echo $habilitado ?> ></td>
                          <td><input type="checkbox" name="pos15" value="UC" :checked="user.permiso.split(',')[14] == 'UC' ? true : false " <?php echo $habilitado ?> ></td>
                          <td><input type="checkbox" name="pos16" value="UM" :checked="user.permiso.split(',')[15] == 'UM' ? true : false " <?php echo $habilitado ?> ></td>
                        </tr>

                        <tr class="text-center">
                          <td>Tarifas Habitaciones</td>
                          <td><input type="checkbox" name="pos17" value="CONFV" :checked="user.permiso.split(',')[16] == 'CONFV' ? true : false " <?php echo $habilitado ?> ></td>
                          <td><input type="checkbox" name="pos18" value="CONFA" :checked="user.permiso.split(',')[17] == 'CONFA' ? true : false " disabled></td>
                          <td><input type="checkbox" name="pos19" value="CONFC" :checked="user.permiso.split(',')[18] == 'CONFC' ? true : false " disabled></td>
                          <td><input type="checkbox" name="pos20" value="CONFM" :checked="user.permiso.split(',')[19] == 'CONFM' ? true : false " <?php echo $habilitado ?> ></td>
                        </tr>
                        <tr class="text-center">
                          <td>Configuracion de Correo</td>
                          <td><input type="checkbox" name="pos21" value="MAILV" :checked="user.permiso.split(',')[20] == 'MAILV' ? true : false " <?php echo $habilitado ?> ></td>
                          <td><input type="checkbox" disabled></td>
                          <td><input type="checkbox" disabled></td>
                          <td><input type="checkbox" name="pos22" value="MAILM" :checked="user.permiso.split(',')[21] == 'MAILM' ? true : false " <?php echo $habilitado ?> ></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="text-center">
                  <input type="hidden" name="userid" :value="user.idusuario">
                  <?php
                    if (preg_match('/(UM)/',$this->session->userdata('permisos')) ) {
                      echo '<button class="btn btn-success" type="button" v-on:click="update">Guardar</button>';
                    }
                   ?>
                </div>
              </form>
             </div>
           </div>
         </div>
       </div>
       <div id="nuevo" class="modal fade" role="dialog">
         <div class="modal-dialog modal-lg">
           <div class="modal-content">
             <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Nuevo Usuario</h4>
             </div>
             <div class="modal-body" >
               <form  class="form-horizontal" onsubmit="return false" role="form" >
                 <div class="form-group">
                   <label class="control-label col-sm-2">Nombre</label>
                   <div class="col-sm-7">
                     <input type="text" class="form-control" name="nombre" placeholder="Nombre del Usuario" >
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="control-label col-sm-2">Telefono</label>
                   <div class="col-sm-7">
                     <input type="text" class="form-control" name="telefono" placeholder="Telefono del Usuario" >
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="control-label col-sm-2">Correo</label>
                   <div class="col-sm-7">
                     <input type="text" class="form-control" name="correo" placeholder="Correo del Usuario">
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="control-label col-sm-2">Usuario</label>
                   <div  class="col-sm-7">
                     <input type="text" class="form-control" name="user" placeholder="Nickname">
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="control-label col-sm-2">Password</label>
                   <div  class="col-sm-7">
                     <input type="password" class="form-control" name="pass" placeholder="password" >
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="control-label col-sm-2">Permisos</label>
                   <div  class="col-sm-7">
                     <table class="table table-hover">
                       <thead>
                         <tr>
                           <th style="text-align: center;"></th>
                           <th>Ver</th>
                           <th>Agregar</th>
                           <th>Cancelar y Eliminar</th>
                           <th>Modificar</th>
                         </tr>
                       </thead>
                       <tbody>
                         <tr class="text-center">
                           <td>Reservaciones</td>
                           <td><input type="checkbox" name="pos1" value="HOTV" ></td>
                           <td><input type="checkbox" name="pos2" value="HOTA" ></td>
                           <td><input type="checkbox" name="pos3" value="HOTC" ></td>
                           <td><input type="checkbox" name="pos4" value="HOTM" ></td>
                         </tr>
                         <tr class="text-center">
                           <td>Restaurante</td>
                           <td><input type="checkbox" name="pos5" value="RESV" ></td>
                           <td><input type="checkbox" name="pos6" value="RESA" disabled></td>
                           <td><input type="checkbox" name="pos7" value="RESC" ></td>
                           <td><input type="checkbox" name="pos8" value="RESM" disabled></td>
                         </tr>
                         <tr class="text-center">
                           <td>Productos</td>
                           <td><input type="checkbox" name="pos9" value="PRODV" ></td>
                           <td><input type="checkbox" name="pos10" value="PRODA" ></td>
                           <td><input type="checkbox" name="pos11" value="PRODC" ></td>
                           <td><input type="checkbox" name="pos12" value="PRODM" ></td>
                         </tr>
                         <tr class="text-center">
                           <td>Ver y Crear Usuarios</td>
                           <td><input type="checkbox" name="pos13" value="UV" ></td>
                           <td><input type="checkbox" name="pos14" value="UA" ></td>
                           <td><input type="checkbox" name="pos15" value="UC" ></td>
                           <td><input type="checkbox" name="pos16" value="UM" ></td>
                         </tr>
                         <tr class="text-center">
                           <td>Tarifas Habitaciones</td>
                           <td><input type="checkbox" name="pos17" value="CONFV" ></td>
                           <td><input type="checkbox" name="pos18" value="CONFA" disabled></td>
                           <td><input type="checkbox" name="pos19" value="CONFC" disabled></td>
                           <td><input type="checkbox" name="pos20" value="CONFM" ></td>
                         </tr>
                         <tr class="text-center">
                           <td>Configuracion de Correo</td>
                           <td><input type="checkbox" name="pos21" value="MAILV"></td>
                           <td><input type="checkbox" disabled></td>
                           <td><input type="checkbox" disabled></td>
                           <td><input type="checkbox" name="pos22" value="MAILM"></td>
                         </tr>
                       </tbody>
                     </table>
                   </div>
                 </div>
                 <div class="text-center">
                   <button class="btn btn-success" type="button" v-on:click="nuevo_usuario">Guardar</button>
                 </div>
               </form>
             </div>
           </div>
         </div>
      </div>
     </div>
     <div id="menu1" class="tab-pane fade">
       <h3>Datos del Sistema</h3>
       <div class="" style="margin-top:25px;border-bottom: 1px solid gray">
          <h5>Datos Hotel</h5>
          <div class="panel panel-default">
            <div class="panel-body">
              <h6>Precios de habitacion</h6>
              <div class="form-group">
                <form id="tarifas" onsubmit="return false" >
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Temporada Baja</th>
                        <th>Fin de Semana</th>
                        <th>Temporada Alta</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(tarifa,index) in tarifas">
                        <td><input type="text" class="form-control" :name="'lowSeasson'+index" :value="tarifa.lowSeasson"></td>
                        <td><input type="text" class="form-control" :name="'weekend'+index" :value="tarifa.weekend"></td>
                        <td><input type="text" class="form-control" :name="'highSeasson'+index" :value="tarifa.highSeasson"></td>
                        <!--
                        <td><input type="text" class="form-control" :name="(index)+1*1" :value="tarifa.lowSeasson"></td>
                        <td><input type="text" class="form-control" :name="(index)+2*3" :value="tarifa.weekend"></td>
                        <td><input type="text" class="form-control" :name="(index)+3*4" :value="tarifa.highSeasson"></td>
                        -->
                      </tr>
                    </tbody>
                  </table>
                  <div class="col-sm-3">
                    <?php
                      if (preg_match('/(CONFM)/',$this->session->userdata('permisos')) ) {
                        echo '  <button class="btn btn-success" v-on:click="actualizaTarifa">Guardar</button>';
                      }
                     ?>
                  </div>
                </form>
              </div>
            </div>
          </div>
       </div>
     </div>
     <div id="menu2" class="tab-pane fade">
       <h3>Configuracion de Correo</h3>
       <div class="panel panel-default">
         <div class="panel-body">
           <form class="form-horizontal" role="form" onsubmit="return false" v-for="(value,index) in datos_correo">
              <div class="form-group">
                <label class="control-label col-sm-4">Correo</label>
                <div class="col-sm-4">
                  <input type="text" name="correo" :value="value.correo" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-4">Password</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" name="password" :value="value.password">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-4">Host</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" name="host" :value="value.host">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-4">Puerto</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" name="puerto" :value="value.puerto">
                </div>
              </div>
              <div class="form-group text-center">
                <?php
                  if (preg_match('/(MAILM)/',$this->session->userdata('permisos')) ) {
                    echo '<button class="btn btn-success" v-on:click="updateMail">Guardar</button>';
                  }
                 ?>
              </div>
           </form>
         </div>
       </div>
     </div>
     <div id="menu3" class="tab-pane fade">
       <h3>Menu 3</h3>
       <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
     </div>
   </div>
</div>

<script>
  new Vue({
    el:'#config',
    data:{
      alluser: null,
      verusuario:null,
      tarifas:null,
      rate:'',
      reservations:null,
      tarifa:null,
      datos_correo:null,
    },
    created:function(){
      this.todos();
      this.getRates();
      this.datosCorreo();
    },
    methods:{
      todos:function(){
        self = this;
        $.get(base_url+'Configuraciones/alluser',function(data){
          var usuarios = JSON.parse(data);
          self.alluser = usuarios;
        });
      },
      getRates: function(){
        var self = this;
        $.get( '<?= base_url();?>home/rates', function( data ) {
            self.tarifas = JSON.parse(data);
            //console.log(self.tarifas[4].lowSeasson);
        });
      },
      ver:function(id){
        var self = this;
        $.get(base_url+'Configuraciones/usuarios',{'iduser':id},function(data){
          self.verusuario = JSON.parse(data);
          var permiso = self.verusuario[0]['permiso'];
          $('#infouser').modal('show');
        });
      },
      nuevo_usuario:function(event){
        $.post(base_url+'configuraciones/nuevo_usuario',$('#nuevo form').serialize(),function(data){
           var message = JSON.parse(data);
           alertify.alert(message.mensaje,function(){
             alertify.message('OK');
           },alertify.defaults.theme.ok = "btn btn-default")
           .set('onok',function(){
             location.reload();
           });
        });
      },
      usuario_baja:function(user){
        $.get(base_url+'configuraciones/baja',{'userid':user},function(data){
          var message = JSON.parse(data);
          alertify.alert(message.mensaje,function(){
            alertify.message('OK');
          },alertify.defaults.theme.ok = "btn btn-default")
          .set('onok',function(){
            location.reload();
          });
        });
      },
      update:function(userid){
        $.post(base_url+'configuraciones/update_user',$('#frm-info').serialize(),function(data){
          var message = JSON.parse(data);
          alertify.alert(message.mensaje,function(){
            alertify.message('OK');
          },alertify.defaults.theme.ok = "btn btn-default")
          .set('onok',function(){
            location.reload();
          });
        });
      },
      actualizaTarifa:function(){
        tarifa = $('#tarifas').serialize();
        var json = JSON.stringify(tarifa);
        //console.log(json);
        $.post(base_url+'configuraciones/actualizaTarifa',tarifa,function(data){
          if (data == 1) alertify.alert('Los datos han sido actualizados',function(){},alertify.defaults.theme.ok="btn btn-default").set('onok',function(){location.reload();});

         });
      },
      datosCorreo:function(){
        var self = this;
        $.get(base_url+'configuraciones/datosCorreo',function(data){
          self.datos_correo = JSON.parse(data);
        });
      },
      updateMail:function(){
        var form = event.path[2];
        $.post(base_url+'configuraciones/updateMail',$(form).serialize(),function(data){
          if(data == 1){
            mensaje = 'Los datos del correo han sido guardados satisfactoriamente';
          }
          else{
            mensaje = "Ha ocurrido un error al guardar los datos";
          }
          alertify.alert(mensaje,function(){
            alertify.message('OK');
          },alertify.defaults.theme.ok = "btn btn-default")
          .set('onok',function(){
            location.reload();
          });
        });
        //console.log($(form).serialize());
      }
    }
  });
</script>
