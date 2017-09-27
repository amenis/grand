
<div class="container"  id="datos_reserv" v-on:keyup.esc="reload">
  <h2>Ver Reservaciones <button class="btn btn-default" data-toggle="modal" data-target="#myModal"> Ver disponibilidad</button></h2>
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="searching">
        <input type="radio" name="search" checked v-on:click="typesearh=true"> Por Nombre
        <input type="radio" name="search" v-on:click="typesearh=false"> Por Fechas
      </div>
      <div id="opt-busqueda">
        <div id="bnombre" v-if="typesearh">
          <input type="search" class="search " placeholder="Busqueda" autofocus v-on:keyup="datesearch" v-model="lookfor">
        </div>
        <div id="bfechas" v-else="typesearh">
          <input type="date" class="search" id="bdin" >
          <input type="date" class="search" id="bdout"  v-on:change="datesearch">
        </div>
      </div>
      <table class="table table-striped" >
        <thead>
          <tr>
            <th>#</th>
            <th>Cliente</th>
            <th>Fecha de Entrada</th>
            <th>Fecha de Salida</th>
            <th>Total</th>
            <th>Status</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody id="tbl-reserv">
          <tr v-for="reserv in datarv" :key="reserv.id_reservacion">
            <td> {{ reserv.id_reservacion }} </td>
            <td> {{ reserv.nombre_cliente }}  </td>
            <td> {{ reserv.fecha_in }} </td>
            <td> {{ reserv.fecha_out }} </td>
            <td> {{ reserv.total }} </td>
            <td v-if="reserv.estado == 1">Reserva</td>
            <td v-if="reserv.estado == 2">Ocupada</td>
            <td v-if="reserv.estado == 3">Finalizada</td>
            <td v-if="reserv.estado == 4">Cancelada</td>
            <td>
              <button type="button" name="button" class="btn btn-info information" style="font-size:9pt;" v-on:click="mostrarDatos(reserv.id_reservacion)" >Ver</button>
              <?php
                if (preg_match('/(HOTM)/',$this->session->userdata('permisos')) ) {
              ?>
              <button type="button" name="button" class="btn btn-success" style="font-size:9pt;" v-on:click="checkin(reserv.id_reservacion)"  :disabled="reserv.estado == 3 || reserv.estado == 4 || reserv.estado == 2 ? true : false" >Check In</button>
              <button type="button" name="button" class="btn btn-warning" style="font-size:9pt;" v-on:click="checkout(reserv.id_reservacion)" :disabled="reserv.estado == 3 || reserv.estado == 4 || reserv.estado == 1 ? true : false" >Check Out</button>
              <?php
                }
                if (preg_match('/(HOTC)/',$this->session->userdata('permisos')) ) {
               ?>
              <button type="button" name="button" class="btn btn-danger " style="font-size:9pt;" v-on:click="cancel(reserv.id_reservacion)" :disabled="reserv.estado == 3 || reserv.estado == 4 || reserv.estado == 2  ? true : false" >Cancelar</button>
              <?php
                }
               ?>
            </td>
          </tr>
        </tbody>
      </table>
      <div class=" text-center v-paginator">
        <button class="btn btn-default" v-on:click="busqueda('', (parseInt(pagina) - parseInt(1) ) )" :disabled=" pagina <= 1 ? true : false"> Anterior </button>
        <span>Pagina {{pagina}} de {{ totalpag }}</span>
        <button class="btn btn-default" v-on:click="busqueda('', (parseInt(pagina) + parseInt(1) ) )" :disabled=" pagina == totalpag ? true : false"> Siguiente</button>
      </div>
    </div>
  </div>
  <div class="modal fade" id="info" role="dialog" v-for="vistarv in vistarv">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{vistarv.idreservacion}}</h4>
        </div>
        <div class="modal-body">
          <div class="panel panel-default">
              <div class="panel-body">
                  <form id="reservation" class="form-horizontal "role="form"  onsubmit="return false;">
                     <input type="hidden" name="id_reserv" :value="vistarv.idreservacion" >
                      <div class="row">
                          <div class="form-group col-md-8">
                              <label class="control-label col-lg-2 " for="nombre"> Nombre:</label>
                              <div class="col-lg-10">
                                <input type="text" class="form-control" name="nombre" id="nombre" :value="vistarv.nombre" required>
                                <span class="help-block"></span>
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="form-group col-md-6">
                             <label class="control-label col-sm-5" for="fechain">Fecha de Entrada:</label>
                             <div class="col-md-6">
                                 <input type="date" class="form-control" id="fechain" name="datein" :value="vistarv.fecha_in" v-on:change="nights" required>
                              </div>
                          </div>
                          <div class="form-group col-md-6">
                             <label class="control-label col-sm-5 " for="fechaout"> Fecha de Salida:</label>
                              <div class="col-sm-6">
                                  <input type="date" class="form-control" id="fechaout" name="dateout" :value="vistarv.fecha_out" v-on:change="nights" required>
                              </div>
                          </div>

                      </div>
                      <div class="row">
                         <div class="form-group col-md-3">
                                <label class="control-label col-sm-6 " for="nNoches"> Noches: </label>
                                <div class="col-sm-6">
                                     <input type="text" class="form-control" id="nNoches" name="noches" :value="vistarv.nnoches" readonly >
                                </div>
                         </div>
                         <div class="form-group col-md-6">
                           <label class="control-label col-sm-4 " for="numRoom" required> Habitacion:</label>
                             <div class="col-sm-8">
                               <select class="form-control" name="habitacion" id="numRoom" required>
                                 <option>SELECT</option>
                                 <option v-for="room in habitaciones" :value="room.idhabitacion" :selected="room.idhabitacion == vistarv.habitacion ? true : false"> {{room.idhabitacion}} {{room.tipo}} </option>
                              </select>
                            </div>
                         </div>
                         <div class="form-group col-md-4">
                           <label class="control-label col-sm-4 " for="tarifas"> Tarifas:</label>
                           <div class="col-sm-8">
                             <select class="form-control" name="tarifa" id="tarifas" required>
                                <option>SELECT</option>
                                <optgroup label="Normal">
                                   <option v-for="rates in tarifas" :value="rates.lowSeasson" :selected="rates.lowSeasson == vistarv.tarifa ? true : false">{{rates.lowSeasson}}</option>
                                </optgroup>
                                <optgroup label="Fin de Semana">
                                   <option v-for="rates in tarifas" :value="rates.weekend" :selected="rates.weekend == vistarv.tarifa ? true : false">{{rates.weekend}}</option>
                                </optgroup>
                                <optgroup label="Temporada Alta">
                                   <option v-for="rates in tarifas" :value="rates.highSeasson" :selected="rates.highSeasson == vistarv.tarifa ? true : false">{{rates.highSeasson}}</option>
                                </optgroup>
                             </select>
                         </div>
                       </div>
                     </div>
                     <div class="row">
                     <div class="form-group col-md-3">
                         <label class="control-label col-sm-4 " for="extra"> Extra:</label>
                       <div class="col-sm-8">
                           <input type="text" name="extra" class="form-control" id="extra" :value="vistarv.extra">
                       </div>
                     </div>
                     <div class="form-group col-md-4">
                         <label class="control-label col-sm-5" for="tarifas"> descuento:</label>
                         <div class="col-sm-7">
                           <input type="number" class="form-control" name="off" min="0" max="9999" :value="vistarv.descuento">
                         </div>
                     </div>
                     <div class="form-group col-md-4">
                       <label class="control-label col-sm-4 " for="tel"> Telefono: </label>
                       <div class="col-sm-7">
                           <input type="text" name="telefono" class="form-control" id="tel" :value="vistarv.telefono">
                       </div>
                     </div>
                   </div>
                   <div class="row">

                     <div class="form-group col-lg-6">
                       <label class="control-label col-sm-2 " for="email"> Correo: </label>
                       <div class="col-sm-9">
                           <input type="text" name="email" class="form-control" id="email" :value="vistarv.email">
                       </div>
                     </div>
                     <div class="form-group col-md-5">
                       <label class="control-label col-sm-3" for="vehiculo"> Vehiculo: </label>
                       <div class="col-sm-8">
                           <input type="text" name="vehiculo" class="form-control" id="vehiculo" :value="vistarv.vehiculo">
                       </div>
                     </div>
                   </div>
                   <div class="row">
                     <div class="form-group col-md-4">
                       <label class="control-label col-sm-4" for="hour">llegada</label>
                       <div class="col-sm-8">
                           <input type="time" name="llegada" class="form-control" id="arrival" :value="vistarv.horallegada">
                       </div>
                     </div>
                     <div class="form-group col-md-4">
                       <label class="control-label col-sm-3" for="pago"> Pago: </label>
                       <div class="col-sm-8">
                           <input type="text" name="pago" class="form-control" id="pago" :value="vistarv.pago">
                       </div>
                     </div>
                     <div class="form-group col-md-5">
                       <label class="control-label col-sm-4 " for="invoice"> Facturacion: </label>
                       <div class="col-sm-6">
                           <select name="factura" class="form-control" id="invoice" required>
                            <option value="pendiente" :selected="vistarv.factura=='pendiente' ? true : false">Pendiente</option>
                            <option value="Facturado" :selected="vistarv.factura=='facturado' ? true : false">Facturado</option>
                            <option value="salida" :selected="vistarv.factura=='salida' ? true : false">Al Salir</option>
                            <option value="no" :selected="vistarv.factura=='no' ? true : false">No Requiere</option>
                           </select>

                       </div>
                     </div>

                   </div>
                   <div class="row">
                     <input type="hidden" name="status" :value="vistarv.estado">
                     <div class="form-group col-lg-10">
                       <label class="control-label col-sm-2 " for="comments"> Observaciones: </label>
                       <div class="col-sm-10">
                         <textarea class="form-control" rows="5" col="10" id="comment" name="comments">{{vistarv.observaciones}}</textarea>
                       </div>
                     </div>
                   </div>
                   <div class="row">
                          <div class="col-sm-offset-3 col-sm-5 text-center">
                              <div class="btn-group" >
                                  <?php
                                   if (preg_match('/(HOTM)/',$this->session->userdata('permisos')) ) {
                                   ?>
                                  <button id="btn_enviar" class="btn btn-primary" v-on:click="editar_reserv">Editar</button>
                                  <?php
                                   }
                                   ?>
                              </div>
                              <div class="btn-group">
                                  <button id="btn_enviar" class="btn btn-primary" v-on:click="enviarCorreo(vistarv.idreservacion)" >Enviar Correo</button>
                              </div>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <modal></modal>
</div>
<template id="bs-modal">
    <!-- MODAL -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Modal title</h4>
          </div>
          <div class="modal-body">
            <form  class="form-horizontal" role="form" id="disponible" width="100%">
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="fecha_in" class="control-label col-md-5">Fecha de Entrada</label>
                  <div class="form-group col-md-7">
                    <input type="date" id="fecha_in" name="fecha_in" class="form-control"  required>
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="fecha_out" class="control-label col-md-5">Fecha de Salida</label>
                  <div class="form-group col-md-7">
                    <input type="date" id="fecha_out" name="fecha_out" class="form-control"  required>
                  </div>
                </div>
              </div>
            </form>
            <div id="show_available" style="overflow:auto" height="300">

            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#show_available').empty()">Close</button>
            <button type="button" class="btn btn-primary" @click="buscar()">Buscar</button>
          </div>
        </div>
      </div>
    </div>
</template>
