
var resturant = new Vue({
  el:'#restaurante',
  data:{
    listart:null,
    carrito:[],
    total: 0,
    totalpag:null,
    folioVenta: 0,
    pagina:1,
    lookfor:null,
  },
  created: function () {
     this.articules();
     this.folios();
     this.totalPaginas();
  },
  methods:{
    folios: function(){
      self = this;
      $.get(base_url+'restaurante/getTotalVentas', function(data) {
        var res = JSON.parse(data);
        self.folioVenta =  res.idventa != null ? parseInt(res.idventa)+1 : 1;
      });
    },
    articules:function(txt_buscar, xpager){
      var self = this;
      var productos = new Array();
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
      self.articules(self.lookfor);
    },
    add:function(id){
      self = this;
     var data = self.findBy(self.listart,id);
     this.carrito.push(
       {
         'idproducto': data[0]['idproductos'],
         'descripcion': data[0]['descripcion'],
         'cantidad':1,
         'precio': data[0]['precio'],
       }
     );
     self.calculateTotal();
   },
   quantity:function(accion,id){
     self = this;
     var result = self.findBy(self.carrito,id);

     // we look inside of carrito object the value to get its position in the array based on the value
     Array.prototype.findBy = function (column, value) {
       for (var i=0; i<this.length; i++) {
           var object = this[i];
           if (column in object && object[column] === value) {
               return i;
           }
       }
       return null;
     }
     var index = self.carrito.findBy('descripcion',result[0]['descripcion']);

     if(accion == 'plus' ){
       self.carrito[index]['cantidad'] = ( parseInt(self.carrito[index]['cantidad']) + 1 );
     }

     else if( accion == 'minus' ){
       self.carrito[index]['cantidad'] = parseInt(self.carrito[index]['cantidad']) - 1;
       if( self.carrito[index]['cantidad'] <= 0 ){
         self.carrito.splice(index,1);
       }
     }
     self.calculateTotal();
   },
   findBy:function(data,id){
     data = data.filter(function (row) {
       return Object.keys(row).some(function (key) {
         return String(row[key]).indexOf(id) > -1
       })
     })
     return data;
   },
   calculateTotal:function(){
     var totalxproducto = 0;
     for (var i = 0; i < this.carrito.length; i++) {
       totalxproducto = totalxproducto + parseInt(this.carrito[i]['cantidad']) * parseInt(this.carrito[i]['precio']);
     }
     this.total = totalxproducto;
   },
   sold:function(){
     var self = this;
     alertify.confirm('Sistema','¿ Estas Seguro que deseas continuar?',
     alertify.defaults.theme.ok = "btn btn-default",
     alertify.defaults.theme.cancel = "btn btn-primary" )
     .set('labels',{ok:'Si', cancel:'No'})
     .set('onok',function(){
       $.ajax({
         url: 'restaurante/guardarVenta',
         type:'post',
         contentType: "application/json",
         data: JSON.stringify(self.carrito),
         success:function(data) {
           alertify.success('Venta Realizada');
           self.createTicket();
           setTimeout(function(){
             location.reload();
           },500);
         },
         error:function(error){
           alertify.error('error');
         }
       });
     });

   },
   createTicket:function(){
      var ticket =  window.open(base_url+"restaurante/tickets", "ticket", "scrollbars=yes,resizable=yes,top=80,left=500,width=700,height=600");
    }
 }
});
