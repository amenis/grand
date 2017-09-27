<div class="container">
  <div class="panel panel-default" id="frm_alta">
    <div class="panel-heading">productos</div>
    <div class="panel-body">
      <input type="search" class="search " placeholder="Busqueda" autofocus v-on:keyup="datesearch" v-model="lookfor">
      <br>
      <img src="<?=base_url();?>images/iconos/nuevo.png" width="32" height="32" style="position:relative; left:80%;"alt="Nuevo" data-toggle="modal" data-target="#nuevo">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Descripcion</th>
            <th>Precio</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for=" lts in listart">
            <td></td>
            <td>{{lts.descripcion || uppercase  }}</td>
            <td>{{lts.precio}}</td>
            <td>
              <?php
                if (preg_match('/(PRODM)/',$this->session->userdata('permisos')) ) {
               ?>
              <button class="btn btn-success" v-on:click="vistaxarticulo(lts.idproductos)">Editar</button>
              <?php
              }
              ?>
              <?php
                if (preg_match('/(PRODC)/',$this->session->userdata('permisos')) ) {
               ?>
              <button class="btn btn-danger">Eliminar</button>
              <?php
              }
               ?>
            </td>
          </tr>
        </tbody>
      </table>
      <div class=" text-center v-paginator">
        <button class="btn btn-default" v-on:click="cargarArticulos('', (parseInt(pagina) - parseInt(1) ) )" :disabled=" pagina <= 1 ? true : false"> Anterior </button>
        <span>Pagina {{pagina}} de {{ totalpag }}</span>
        <button class="btn btn-default" v-on:click="cargarArticulos('', (parseInt(pagina) + parseInt(1) ) )" :disabled=" pagina == totalpag ? true : false"> Siguiente</button>
      </div>
      <!--nuevo articulo-->
      <div id="nuevo" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Alta de Producto</h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" role="form" >
                <div class="form-group">
                  <label class="control-label col-sm-2">Nombre</label>
                  <div class="col-sm-4">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre del producto" v-model="frm_datos.np">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Precio</label>
                  <div class="col-sm-2">
                    <input type="number" name="" value="0" max="99999" min="0" class="form-control" v-model="frm_datos.precio">
                  </div>
                </div>

                <div style="margin-left:35%;">
                  <button type="button"  class="btn btn-success" >Guardar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!--edicion-->
      <div id="edicion" class="modal fade" role="dialog">
        <div class="modal-dialog ">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Alta de Producto</h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" role="form" v-for="(art, index) in editArt" onsubmit="return false">
                <div class="form-group">
                  <label class="control-label col-sm-2">Nombre</label>
                  <div class="col-sm-8">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre del producto" :value="art.descripcion">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Precio</label>
                  <div class="col-sm-3">
                    <input type="number" name="precio" value="0" max="99999" min="0" class="form-control" :value="art.precio">
                  </div>
                </div>

                <div style="margin-left:35%;">
                  <button type="button"  class="btn btn-success" v-on:click="editarProducto">Guardar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  'Use Strict'
  new Vue({
   el:'#frm_alta',
   data:{
     pagina:1,
     totalpag:null,
     listart:null,
     editArt:null,
     frm_datos:[],
     lookfor:null,
    },
    created:function(){
      this.totalPaginas();
      this.cargarArticulos();
    } ,
   methods:{
     cargarArticulos:function(txt_buscar, xpager){
       var self = this;
       this.pagina = xpager || this.pagina;
       $.get(base_url+'restaurante/getAllproducts',{'txt_buscar':txt_buscar,'xpager':xpager}, function( data ){
         self.listart = JSON.parse(data);
       });
    },
    totalPaginas:function(){
      self  = this
      //we get the total of register of reservations
      $.get(base_url+'restaurante/maxProduct',function( data ){
        //we obtain pages to show
        self.totalpag = Math.ceil(data/12);
      });
    },
    datesearch:function(){
      self = this;
      self.cargarArticulos(self.lookfor);
    },
    nuevo:function(){
      $.post(base_url+'restaurante/nuevo_articulo',function(data){});
    },
    editarProducto:function(event){
      console.log(this.editArt[0]['idproductos']);
      $.post(base_url+'restaurante/editarProducto',{'idprod':this.editArt[0]['idproductos'],'name':event.path[2]['nombre'].value,'price':event.path[2]['precio'].value},function(data){
        var message = JSON.parse(data);
        $('#editar').modal('close');
        alertify
          .alert(message.mensaje,function(){
            alertify.message();
          },alertify.defaults.theme.ok = "btn btn-default")
          .set('onok',function(){
            location.reload();
          });
      });
    },
    vistaxarticulo:function(ref){
      self = this;
      $.get(base_url+'restaurante/vistaxarticulo',{'referencia':ref},function(data){
        //var datosArticulo = JSON.parse(data);
        self.editArt = JSON.parse(data);
      });
      $('#edicion').modal('show');
    },
   }
 });
 /*
  (function(){
    $.get('http://localhost/grand/restaurante/getCategories',function(res){
      var categorias = document.querySelector('#cate');
      var result = JSON.parse(res);
      result.forEach(function(val){
        var option = document.createElement("option");
        option.setAttribute('value',val.nombre);
        option.text = val.nombre;
        categorias.add(option);
      });
    });
  })();
  $('#frm_alta').on('submit',function(){
    alert()
  });*/
</script>
