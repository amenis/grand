<div class="container" id="usuario">
  <div class="panel panel-default">
      <div class="panel-heading">Datos Usuario</div>
      <div class="panel-body" v-for="dtuser in datos_user">
          <img id="fotouser" :src="imagenSrc" alt="not available"  width="250" height="250">
          <form class="form-horizontal" id="datosuser" role="form" method="post" onsubmit="return false;" enctype="multipart/form-data" >
            <input type="hidden" name="iduser" :value="dtuser.idusuario">
            <div class="row">
              <div class="form-group col-lg-10">
                <label class="control-label col-sm-2">Nombre</label>
                <div class="col-lg-8">
                  <input type="text" class="form-control" name="nombre" :value="dtuser.nombre" >
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-lg-10">
                <label class="control-label col-sm-2">Usuario</label>
                <div class="col-lg-7">
                  <input type="text" class="form-control" name="user" :value="dtuser.user">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-lg-10">
                <label class="control-label col-sm-2">Contraseña</label>
                <div class="col-lg-7">
                  <input type="password" id="password" class="form-control" name="pass" :value="dtuser.pass">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-lg-10">
                <label class="control-label col-sm-2">Confirmar Contraseña</label>
                <div class="col-lg-7">
                  <input type="password" id="passVerif" class="form-control" :value="dtuser.pass">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-lg-10">
                <label class="control-label col-sm-2">Foto de perfil</label>
                <div class="col-lg-7">
                  <input type="file" class="form-control" name="profile_img" v-on:change="loadimage">
                </div>
              </div>
            </div>
            <div class="text-center">
              <button type="button" class="btn btn-success" v-on:click="verificar">Guardar</button>
            </div>
          </form>
      </div>
    </div>
</div>
<script>
  (function(){
    var usuario = new Vue({
      el:'#usuario',
      data:{
        datos_user:null,
        imagenSrc:null,
      },
      created:function(){
        this.datos();
      },
      methods:{
        datos:function(){
          var self = this;
          $.get(base_url+'Configuraciones/usuarios',{'iduser': <?php echo $iduser;?> },function( data ) {
            self.datos_user  = JSON.parse(data);
            self.imagenSrc = base_url+'images/usuarios/'+self.datos_user[0]['foto'];
          });
        },
        verificar:function(){
          var inputVerif = document.querySelector('#passVerif').value;
          var inputPass = document.querySelector('#password').value;
          if( inputVerif === inputPass){
            this.guardar();
          }
          else{
            alert('Las contraseñas no coinciden favor de verificar');
          }
        },
        loadimage:function(event){
          var input  = event.target;
          var self = this;
          //console.log(input.files[0]);
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
              self.imagenSrc = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
          }
        },
        guardar: function(){
          self = this;
          var formData = new FormData($('#datosuser')[0]);
          $.ajax({
            url: base_url+'login/guardardatos',
            type:'POST',
            data:formData,
            cache : false,
            contentType:false,
            processData: false,
            success:function( data ){
              if(data){
                mensaje = 'Cambios Realizados Correctamente';
              }
              else{
                mensaje = 'No se ha seleccionado una imagen para subir';
              }
              alertify
                .alert(mensaje,function(){
                  alertify.message('OK');
                },alertify.defaults.theme.ok = "btn btn-default");
            },
            error:function(err){
              alert(err);
            }
          });
        },
      }
    });
  })();
</script>
