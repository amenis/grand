<center><h2>Reservacion de Habitaciones</h2></center>

<div class="container">
       <br>
       <br>
       <div class="panel panel-default" id="reservation">
           <div class="panel-heading">
              <h4><label class='glyphicon glyphicon-book'>  {{numofreserv}} </label></h4>
           </div>
           <div class="panel-body">
               <form  class="form-horizontal "role="form" method="post" onsubmit="return false;">
                     <div class="row">
                       <div class="form-group col-md-8">
                           <label class="control-label col-lg-1 " for="nombre"> Nombre:  </label>
                           <div class="col-lg-10">
                             <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre del Cliente" required>
                             <span class="help-block"></span>
                           </div>
                       </div>
                   </div>
                   <div class="row">
                       <div class="form-group col-md-5">
                            <label class="control-label col-sm-3" for="fechain"> Fecha de Entrada:</label>
                           <div class="col-md-7">
                              <input type="date" class="form-control" id="fechain" name="datein" v-on:change="nights" required>
                           </div>
                       </div>
                       <div class="form-group col-md-5">
                          <label class="control-label col-sm-3 " for="fechaout"> Fecha de Salida:</label>
                           <div class="col-sm-7">
                               <input type="date" class="form-control" id="fechaout" name="dateout" v-on:change="nights" required>
                           </div>
                       </div>

                   </div>
                   <div class="row">
                     <div class="form-group col-md-3">
                            <label class="control-label col-sm-3 " for="nNoches"> Noches: </label>
                             <div class="col-sm-5">
                                  <input type="text" class="form-control" id="nNoches" name="noches" :value="noches" readonly >
                             </div>
                      </div>
                      <div class="form-group col-md-4">
                        <label class="control-label col-sm-4 " for="numRoom" required> Habitacion:</label>
                          <div class="col-sm-8">
                            <select class="form-control" name="habitacion" id="numRoom" required>
                              <option>SELECT</option>
                              <option v-for="room in habitaciones" :value="room.idhabitacion"> {{room.idhabitacion}} {{room.tipo}} </option>
                           </select>
                         </div>
                      </div>
                      <div class="form-group col-md-3">
                        <label class="control-label col-sm-4 " for="tarifas"> Tarifas:</label>
                        <div class="col-sm-8">

                          <select class="form-control" name="tarifa" id="tarifas" required>
                             <option>SELECT</option>
                             <optgroup label="Normal">
                                <option v-for="rates in tarifas" :value="rates.lowSeasson">{{rates.lowSeasson}}</option>
                             </optgroup>
                             <optgroup label="Fin de Semana">
                                <option v-for="rates in tarifas" :value="rates.weekend">{{rates.weekend}}</option>
                             </optgroup>
                             <optgroup label="Temporada Alta">
                                <option v-for="rates in tarifas" :value="rates.highSeasson">{{rates.highSeasson}}</option>
                             </optgroup>
                          </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">

                  <div class="form-group col-md-3">
                    <label class="control-label col-sm-4 " for="extra"> Extra:</label>
                    <div class="col-sm-8">
                        <input type="text" name="extra" class="form-control" id="extra" >
                    </div>
                  </div>
                  <div class="form-group col-md-4">
                      <label class="control-label col-sm-4" for="tarifas"> descuento:</label>
                      <div class="col-sm-7">
                        <input type="number" class="form-control" name="off" min='0' max="9999" >
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-lg-3">
                    <label class="control-label col-sm-4 " for="tel"> Telefono: </label>
                    <div class="col-sm-8">
                        <input type="text" name="telefono" class="form-control" id="tel" pattern="[0-9]{12}">
                    </div>
                  </div>
                  <div class="form-group col-md-5">
                    <label class="control-label col-sm-2 " for="email"> Correo: </label>
                    <div class="col-sm-9">
                        <input type="text" name="email" class="form-control" id="email">
                    </div>
                  </div>
                  <div class="form-group col-md-4">
                    <label class="control-label col-sm-5 " for="vehiculo"> Vehiculo: </label>
                    <div class="col-sm-7">
                        <input type="text" name="vehiculo" class="form-control" id="vehiculo">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <!--<div class="form-group col-lg-5">
                    <label class="control-label col-md-4 " for="arrival"> Fecha de Llegada: </label>
                    <div class="col-sm-6">
                        <input type="date" name="llegada" class="form-control" id="arrival">
                    </div>
                  </div>-->
                  <div class="form-group col-md-3">
                    <label class="control-label col-sm-4" for="hour">llegada</label>
                    <div class="col-sm-8">
                        <input type="time" name="hora" class="form-control" id="hour">
                    </div>
                  </div>
                  <div class="form-group col-md-3">
                    <label class="control-label col-sm-3 " for="arrival"> Pago: </label>
                    <div class="col-sm-9">
                        <input type="text" name="pago" class="form-control" id="arrival">
                    </div>
                  </div>
                  <div class="form-group col-md-4">
                    <label class="control-label col-md-4 " for="invoice"> Facturacion: </label>
                    <div class="col-sm-7">
                        <select name="factura" class="form-control" id="invoice" required>
                            <option value="pendiente">Pendiente</option>
                            <option value="Facturado">Facturado</option>
                            <option value="salida">Al Salir</option>
                            <option value="no">No Requiere</option>
                        </select>
                    </div>
                  </div>
                  <div class="form-group col-md-1">
                    <label class="control-label col-sm-2 ">Status</label>
                  </div>
                  <div class="col-sm-2">
                    <select class="form-control" name="status">
                      <option>Select</option>
                      <option value="1">En Reserva</option>
                      <option value="2">Ocupada</option>
                      <!--<option value="3">Finalizada</option>
                      <option value="4">Cancelada</option>-->
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-9">
                    <label class="control-label col-sm-2 " for="comments"> Observaciones: </label>
                    <div class="col-sm-9">
                      <textarea class="form-control" rows="5" col="10" id="comment" name="comments" style="margin: 0px -366.375px 0px 0px; width: 965px; height: 114px;"></textarea>
                    </div>
                  </div>
                </div>
                <div class="row">
                       <div class="col-sm-offset-5 col-sm-2 text-center">
                           <div class="btn-group" >
                               <button id="btn_enviar" class="btn btn-primary" v-on:click="save">Enviar</button>
                           </div>
                       </div>
                   </div>
               </form>
           </div>
       </div>
   </div>
   <div class="modal fade" id="response" role="dialog">
       <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal">&times;</button>
             <h4 class="modal-title">Modal Header</h4>
           </div>
           <div class="modal-body" :input="res" ></div>
           <div class="modal-footer">
              <button type="button" data-dismiss="modal" name="button">Aceptar</button>
           </div>
         </div>
       </div>
   </div>
   <script>
      var rv = new Vue({
        el: "#reservation",
        data:{
          numofreserv:null,
          tarifas:null,
          habitaciones:null,
          noches: 0,
          res:''
        },
        created:function(){
          this.getRooms()
          this.getRates()
          this.getTotalReserv()
        },
        methods:{
          getTotalReserv: function(){
            var self = this;
            $.get( '<?= base_url();?>home/maxidreservations', function( data ) {
              var res = JSON.parse(data)
              self.numofreserv = res.idrv;
              console.log(res.idrv);
            });
          },
          getRooms: function(){
            var self = this;
            $.get( '<?= base_url();?>home/getRooms', function( data ) {
                self.habitaciones = JSON.parse(data);
                console.log(self.habitaciones.idhabitacion);
            });
          },
          getRates: function(){
            var self = this;
            $.get( '<?= base_url();?>home/rates', function( data ) {
                self.tarifas = JSON.parse(data);
                //console.log(self.tarifas[4].lowSeasson);
            });
          },
          nights: function(){
            var self = this;
            var aFecha1 = $("#fechain").val().split('-');
        		var aFecha2 = $("#fechaout").val().split('-');
        		var d = Date.UTC(aFecha1[0], aFecha1[1], aFecha1[2]);
        	  var e = Date.UTC(aFecha2[0],aFecha2[1],aFecha2[2]);
        	  var dif = e-d;
        	  var dias = Math.floor(dif / (1000 * 60 * 60 * 24));
            self.noches = dias;
            //$("#nNoches").val(dias);
          },
          save: function(){
            var self = this;
            console.log( $("#reservation form").serialize() );
            $.ajax({
              url: '<?= base_url();?>home/save',
              type: 'POST',
              data: $("#reservation form").serialize(),
              success: function( data ){
                var response = JSON.parse(data);
                self.res = response.mensaje;
                $('#response').modal('show');
                console.log(data);
              },
              error:function(err){
                console.error(err);
              }
            });
          }
        }
      });
   </script>
