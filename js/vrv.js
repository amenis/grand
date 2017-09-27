(function(){
  Vue.component('modal', {
      template: '#bs-modal',
      methods:{
      	buscar:function(){
          $.ajax({
           url:base_url+'home/disponibilidad',
           type: 'GET',
           data:$("#disponible").serialize(),
           beforeSend: function(){
               $('#show_available').html('<center><img src="'+base_url+'images/loader.gif" alt="waiting" width="128" height="128" ></center>');
           },
           success:function(data){
             var res = JSON.parse(data);
             var thead=
             `
             <table  class="table table-striped" >
               <thead>
                 <tr>
                   <th> habitacion </th>
                   <th> tipo </th>
                 </tr>
               </thead>
             `;
             var tbody="";
             res.forEach(function(key){
               tbody += '<tr><td>'+key.idhabitacion+'</td><td>'+key.tipo+'</td></tr>'
             });
             $('#show_available').html(thead+tbody);

           }
        });
      }
    }
  });

var reservaciones  = new Vue({
    el: '#datos_reserv',
    data:{
      datarv:null, vistarv:null,tarifas:null,
      habitaciones:null, noches: 0, showModal: false,
      lookfor:'', pagina: '1', totalpag: null, typesearh: true,noches:null
  },
  created:function(){
      this.busqueda();
      this.getTotalReg();
    },
    methods:{
      reload:function(){
        location.reload();
      },
      getTotalReg:function(){
        self  = this
        //we get the total of register of reservations
        $.get(base_url+'home/getTotalReg',function( data ){
          //we obtain pages to show
          self.totalpag = Math.ceil(data/12);
        });
      },
      busqueda:function(txt_buscar, xpager  ){
        var self = this
        this.pagina = xpager || this.pagina;
        $.get('buscar',{'txt_buscar':txt_buscar,'xpager':xpager}, function( data ){
          self.datarv = JSON.parse(data);
        });
      },
      mostrarDatos:function(id){
        self = this;
        $.get(base_url+'home/verReservacion',{'idreservacion':id},function(data){
          self.vistarv = JSON.parse(data);
          self.datosCuartos();
          self.noches = self.vistarv[0]['nnoches'];
          //self.active = self.rv.estado == '3' ? false : true;
          //console.log(self.rv[0]['estado']);
          setTimeout(function(){
              $("#info").modal('show');
          },50);
        })
      },
      nights: function(){
        var self = this;
        var aFecha1 = $("#fechain").val().split('-');
        var aFecha2 = $("#fechaout").val().split('-');
        var d = Date.UTC(aFecha1[0], aFecha1[1], aFecha1[2]);
        var e = Date.UTC(aFecha2[0],aFecha2[1],aFecha2[2]);
        var dif = e-d;
        var dias = Math.floor(dif / (1000 * 60 * 60 * 24));
        self.vistarv[0]['fecha_in'] = $("#fechain").val();
        self.vistarv[0]['fecha_out'] = $("#fechaout").val();
        self.vistarv[0]['nnoches'] = dias;
        self.noches = dias;
        //console.log(aFecha1+' '+aFecha2);
        //$("#nNoches").val(dias);
      },
      datosCuartos:function(){
        var self = this;
        $.get(base_url+'home/getRooms', function( data ) {
            self.habitaciones = JSON.parse(data);
            //console.log(self.habitaciones.idhabitacion);
        });
        $.get(base_url+'home/rates', function( data ) {
            self.tarifas = JSON.parse(data);
            //console.log(self.tarifas[4].lowSeasson);
        });
      },
      editar_reserv:function(){
        console.log($('#reservation').serialize());

        self = this;
        $.ajax({
          url:base_url+'home/editar_reserv',
          type:'POST',
          data: $('#reservation').serialize(),
          success:function(data){
            var message = JSON.parse(data);
            alertify
              .alert(message.mensaje,function(){
                alertify.message('OK');
              },alertify.defaults.theme.ok = "btn btn-default");
              self.busqueda();
          }
        });
      },
      enviarCorreo:function(idreserv){
        var correo = this.vistarv[0]['email'];
        var reservid = idreserv;
        if(correo == ''){
          alertify
          .alert('El campo de Correo se encuentra vacio',function(){
            alertify.message('OK');
          },alertify.defaults.theme.ok ="btn btn-default");
        }
        else{
          $.get(base_url+'correo/sendmail',{'email':correo,'idreserv':reservid},function(data){
            console.log(data);
            if(data == 1){
              alertify
              .alert('El correo ha sido enviado satisfactoriamente a '+correo,function(){
                alertify.message('OK');
              },alertify.defaults.theme.ok ="btn btn-default");
            }
            else{
              alertify
              .alert('El correo no ha podido ser entregado, intentelo de nuevo, en caso de que el problema persista debera llamar a su aministrador de sistemas',function(){
                alertify.message('OK');
              },alertify.defaults.theme.ok ="btn btn-default");
            }
          });
       }
      },
      checkin:function(id){
        $.post(base_url+'home/checkin',{'idreservacion':id},function(data){
          //console.log(data);
          location.reload();
        });
      },
      checkout:function(id){
        $.post(base_url+'home/checkout',{'idreservacion':id},function(data){
          console.log(data);
          location.reload();
        });
      },
      cancel:function(id){
        $.post(base_url+'home/cancel',{'idreservacion':id},function(data){
          //console.log(data);
          location.reload();
        });
      },
      datesearch:function(){
        self = this;
        if(self.typesearh){
          setTimeout(function() {
            self.busqueda(self.lookfor);
            //console.log(self.lookfor);
          },500);
        }
        else{
          var fecha1 = document.getElementById('bdin').value;
          var fecha2 = document.getElementById('bdout').value;
          $.get(base_url+'home/busquedafecha',{'fecha1':fecha1,'fecha2':fecha2},function(data){
              self.datarv = JSON.parse(data);
          });
        }
      }
    }
  });

})();
