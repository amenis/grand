<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Hotel Centinela Grand</title>
		<link rel="stylesheet" href="<? echo  base_url();?>css/bootstrap.min.css">
		<link rel="stylesheet" href="<? echo base_url();?>css/login.css">
		<script src="<? echo base_url();?>js/jquery.min.js"></script>
		<script src="<? echo base_url();?>js/vue.js"></script>

	</head>
	<body style="  background-image: url(<?php echo base_url();?>images/sitemgr_photo_431.jpg);">
				<div id="login">
				<!--<img src="./img/logoc.png">-->
						<h1><span class="log-in">Bienvenidos</span></h1>
						<form id="frmLog" role="form" class="form-horizontal" method="post" onsubmit="return false;">
								<div class="form-group ">
										<label class="control-label col-sm-2 icon-user" for="email">Usuario:</label>
										<div class="col-sm-10">
												<input type="text" name="user" class="form-control" v-model="user" placeholder="Usuario">
										</div>
								</div>
								<div class="form-group">
										<label class="control-label col-sm-2" for="pwd">Contraseña:</label>
										<div class="col-sm-10">
												<input type="password" name="password" class="form-control" id="pwd" v-model="pass" placeholder="Contraseña">
										</div>
								</div>
								<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
												 <button  class="btn btn-default" type='submit' v-on:click="login">Entrar</button>
										</div>
								</div>
						</form>
						<p id="mensaje_error" style="display:none" :input="mensaje" >El Usuario y/o contraseña estan mal escritas</p>
				</div>

			<script type="text/javascript">
					var login = new Vue({
						el:"#login",
						data:{
							mensaje: null,
							user:'',
							pass:''
						},
						methods:{
							login: function(){
								var self = this;

								$.ajax({
									url: '<?= base_url();?>login/validate',
									type:'POST',
									data: { user:this.user, pass:this.pass},
									success:function(data){
										var obj = JSON.parse(data);
										console.log(data);
										console.log(obj.mensaje);
										if(obj.mensaje === "Error"){
											this.mensaje = obj.mensaje;
											console.log(obj.issue);
											$('#mensaje_error').css('display','initial');
										}
										else {
											window.location.href= '<?= base_url();?>home';
										}
									}
								});
							}
						}
					});
		</script>
	</body>
</html>
