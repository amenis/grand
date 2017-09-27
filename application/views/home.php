
  <body>
    <div id="contenido">
      <div class="panel-group" id="habitaciones">
        <div class="panel panel-default">
          <div class="panel-heading">HABITACIONES</div>
          <div class="panel-body" >
            <div v-for="record in reservations">
                <div class="rooms"  v-bind:class="record.status == 1 ? 'available' : 'busy' " v-on:click="ver(record.idhabitacion)">
                  {{record.tipo}}
                  <br>
                  No {{record.idhabitacion}}
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="panel-group" id="habitaciones">
        <div class="panel panel-default">
          <div class="panel-heading">Salidas</div>
          <div class="panel-body" >
            <div v-for="checkout in checkouts">
              <div class="salidas" >
                {{checkout.id_reservacion}}
                <br />
                {{checkout.nombre_cliente}}
                <br />
                No {{checkout.habitacion}}
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--Modal rooms info-->
      <div class="modal fade" id="info" role="dialog" v-for="vistarv in vistarv">
        <div class="modal-dialog ">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">{{vistarv.reservacion}}</h4>
            </div>
            <div class="modal-body">
              <div class="panel panel-default">
                  <div class="panel-body">
                    <div class="row">
                      <div class="form-group col-lg-15">
                        <label class="control-label col-sm-2">Nombre</label>
                        <div class="col-lg-9">
                          <input type="text" name="nombre" :value="vistarv.nombre_cliente" class="form-control">
                        </div>
                      </div>
                    </div>
                    <br />
                    <div class="row">
                      <div class="form-group col-lg-15">
                        <label class="contro-label col-sm-2">Habitacion</label>
                        <div class="col-md-3">
                          <input type="text" name="habitacion" :value="vistarv.habitacion" class="form-control">
                        </div>
                      </div>
                    </div>
                    <br />
                    <div class="row">
                      <div class="form-group col-lg-15">
                        <label class="control-label col-md-2">Entrada</label>
                        <div class="col-md-4">
                          <input type="date" name="fechain" :value="vistarv.fecha_in" class="form-control">
                        </div>
                        <label class="control-label col-md-2">Salida</label>
                        <div class="col-md-4">
                          <input type="date" name="fechaout" :value="vistarv.fecha_out" class="form-control">
                        </div>
                      </div>
                    </div>
                    <br />
                    <div class="row">
                      <div class="form-group col-md-15">
                        <label class="control-label col-md-2">Total</label>
                        <div class="col-md-3">
                          <input type="text" name="total" :value="vistarv.total" class="form-control">
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="<?php echo base_url();?>js/home.js"></script>
  </body>
</html>
