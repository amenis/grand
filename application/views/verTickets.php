<div class="container">
  <div class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading">Ventas Realizadas</div>
      <div class="panel-body">
        <div id="tickets">
          <div class="panel-group">
            <div class="panel panel-default">
              <div class="panel-body">
                <div>
                  <input type="search" class="search " placeholder="Busqueda" autofocus v-on:keyup="datesearch" v-model="lookfor">
                </div>
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Fecha</th>
                      <th>Total</th>
                      <th>Status</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="tk in tickets">
                      <td>{{tk.idventa}}</td>
                      <td>{{tk.fecha}}</td>
                      <td>{{tk.total}}</td>
                      <td>{{tk.status}}</td>
                      <td>
                        <button class="btn btn-info" name="button" v-on:click="ver(tk.idventa)">Imprimir</button>
                        <button class="btn btn-success" name="button"  v-on:click="setStatus(tk.idventa,'pagada')" :disabled="tk.status == 'pagada' || 'cancelada'? true : false ">Pagado</button>
                        <button class="btn btn-danger" name="button" v-on:click="setStatus(tk.idventa,'cancelada')" :disabled="tk.status == 'cancelada'? true : false">Cancelar</button>
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
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  new Vue({
    el:"#tickets",
    data:{
      tickets:null, pagina: '1',
      totalpag: null, lookfor:null
    },
    created: function () {
       this.getTotalReg();
       this.busqueda();
    },
    methods:{
      busqueda:function(txt_buscar, xpager  ){
        var self = this
        this.pagina = xpager || this.pagina;
        $.get(base_url+"restaurante/gettickets",{'txt_buscar':txt_buscar,'xpager':xpager}, function( data ){
          self.tickets = JSON.parse(data);
        });
      },
      getTotalReg:function(){
        self  = this;
        //we get the total of register of reservations
        $.get(base_url+"restaurante/getTotalVentas",function( data ){
          var res = JSON.parse(data);
          //we obtain pages to show
          self.totalpag = Math.ceil(res['idventa']/12);

        });
      },
      datesearch:function(){
        self = this;
        self.busqueda(self.lookfor);
        console.log(self.lookfor);
      },
      ver:function(tk){
        window.open(base_url+"restaurante/tickets/"+tk, "ticket", "scrollbars=yes,resizable=yes,top=80,left=500,width=700,height=600");
      },
      setStatus:function(id,status){
        $.post(base_url+'restaurante/setStatus',{'idventa':id,'status':status},function(data){
          console.log(data);
           if(data == 1){
             var mensaje = status == 'pagada' ? 'Pago' : 'La cancelacion se a';
             alertify.alert('Pago Realizado Correctamente',function(){
               alertify.message('Pago Realizado');
             },alertify.defaults.theme.ok = "btn btn-default")
             .set('onok',function(){
               location.reload();
             });

           }
        });
      }
    }
  });
</script>
