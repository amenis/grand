
new Vue({
  el: '#contenido',
  data:{
    reservations: null,
    clase:null,
    vistarv:null,
    checkouts:[]
  },
  created: function () {
    this.fetchData();
    this.checkout();
  },

  methods:{
    fetchData: function () {
      var self = this;
      $.get( 'home/getRooms', function( data ) {
          self.reservations = JSON.parse(data);
      });
    },
    checkout:function(){
      var self = this;
      var d = new Date();
      var numDay = d.getDate();
      var month = d.getMonth() + 1;
      var year = d.getFullYear();
      fecha = numDay+" del "+month+" de "+year;
      $.get('home/salidas',function(data){
        var checkouts = JSON.parse(data);
        self.checkouts = checkouts;
        if(checkouts.length == 0){
          var outs =document.getElementsByClassName("salidas");
          outs.innerHTML = "<p>No hay salidas programadas para el dia de hoy </p>";
        }
        /*
        else{
          for (i in checkouts) {
            console.log(checkouts[i]['habitacion']);
            salidas += checkouts[i]['id_reservacion']+'<br />';
          }
        }*/

      });
    },
    ver:function(habitacion){
      self = this;
      $.get("home/verHabitacion",{'nhabitacion':habitacion},function(data){
        self.vistarv = JSON.parse(data);
        //self.datosCuartos();
        //self.active = self.rv.estado == '3' ? false : true;
        //console.log(self.rv[0]['estado']);
        setTimeout(function() {
          $('#info').modal('show');
        },50);
      });
    }
  }
});
