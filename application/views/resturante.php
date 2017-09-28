<div  id="restaurante" class="container">
  <h2>RESTAURANTE</h2>
  <button class="btn btn-default" id="search" data-toggle="modal" data-target="#List-articulos"><img src="<?=base_url();?>fonts/glyphicons-28-search.png" alt="BUSCAR"> Buscar</button>
  <br><br>
  <div class="panel panel-default">
      <div class="panel-heading"> {{folioVenta}}</div>
      <div class="panel-body">
        <div class="tbl-sells ">
          <table class="table table-striped" id="tblventas" >
            <thead>
              <tr>
                <th >Descripcion</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
                <th></th>
              </tr>
            </thead>
            <tbody >
              <tr v-for="car in carrito ">
                <td >{{car.descripcion || uppercase }}</td>
                <td>{{car.cantidad}}</td>
                <td>{{car.precio}}</td>
                <td>{{ (parseInt(car.cantidad) * parseInt(car.precio) )  }}</td>
                <td>
                  <img src="<?=base_url();?>fonts/glyphicons-192-minus-sign.png" v-on:click="quantity('minus',car.descripcion)">
                  <img src="<?=base_url()?>fonts/glyphicons-191-plus-sign.png" v-on:click="quantity('plus',car.descripcion)">
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="totales">
          <label for="total">Total</label><input type="text" id="total" name="total" size="15" :value="total" disabled>
        </div>
        <br>
        <button class="btn btn-success text center" id="btn-guardar" v-on:click="sold" >GUARDAR</button>
      </div>
    </div>

  <!-- Modal -->
   <div class="modal fade" id="List-articulos" role="dialog">
     <div class="modal-dialog modal-lg">
       <!-- Modal content-->
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal">&times;</button>
           <h4 class="modal-title">Lista de Articulos</h4>
         </div>
         <div class="modal-body">
          <input type="search" class="search " placeholder="Busqueda" autofocus v-on:keyup="datesearch" v-model="lookfor">
           <table class="table ">
             <thead>
               <tr>
                 <th>Descripcion</th>
                 <th>Precio</th>
                 <th></th>
               </tr>
             </thead>
             <tbody>
               <tr v-for=" lts in listart">
                 <td>{{lts.descripcion || uppercase  }}</td>
                 <td>{{lts.precio}}</td>
                 <td><img src="<?=base_url()?>fonts/glyphicons-191-plus-sign.png" v-on:click="add(lts.descripcion)" ></td>
               </tr>
             </tbody>
           </table>
           <div class=" text-center v-paginator">
             <button class="btn btn-default" v-on:click="cargarArticulos('', (parseInt(pagina) - parseInt(1) ) )" :disabled=" pagina <= 1 ? true : false"> Anterior </button>
             <span>Pagina {{pagina}} de {{ totalpag }}</span>
             <button class="btn btn-default" v-on:click="cargarArticulos('', (parseInt(pagina) + parseInt(1) ) )" :disabled=" pagina == totalpag ? true : false"> Siguiente</button>
           </div>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
       </div>
     </div>
   </div>
   <div class="modal fade" id="dialog-venta" role="dialog">
     <div class="modal-dialog modal-lg">
       <!-- Modal content-->
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal">&times;</button>
           <h4 class="modal-title">Realizar Venta</h4>
         </div>
         <div class="modal-body">

         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
       </div>
     </div>
   </div>
</div>
