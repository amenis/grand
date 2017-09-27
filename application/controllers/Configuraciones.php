<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  class Configuraciones extends CI_Controller
  {

    function __construct()
    {
      parent::__construct();
      $this->output->set_header('Access-Control-Allow-Origin: *');
      $this->load->library('session');
      $this->load->helper('cookie');
      $this->load->model('auth_model');
      if($this->input->cookie($this->session->userdata('nombre'),true ) !=null){
        redirect(base_url());
      }
    }
    public function configuracion(){
      $username['username'] = $this->session->userdata('nombre');
      $username['iduser'] = $this->session->userdata('id');
      $username['profile_picture'] = base_url().'images/usuarios/'.$this->session->userdata('foto');
      $this->load->view('layout/header');
      $this->load->view('layout/menu',$username);
      $this->load->view('configuracion',$username);
    }
    public function opciones(){
      $username['username'] = $this->session->userdata('nombre');
      $username['iduser'] = $this->session->userdata('id');
      $username['profile_picture'] = base_url().'images/usuarios/'.$this->session->userdata('foto');
      $this->load->view('layout/header');
      $this->load->view('layout/menu',$username);
      $this->load->view('opciones',$username);
    }
    public function usuarios(){
      $id = $this->input->get('iduser');
      $res = $this->auth_model->datosuser($id);
      echo json_encode($res);
    }
    public function nuevo_usuario(){
      $permission="";
      for ($i=1; $i<=22 ; $i++) {
        $permission .= $this->input->post('pos'.($i)).',';
      }
      //$permission = trim($permission,',');
       $new_user = array(
         'user' => $this->input->post('user'),
         'pass' => $this->input->post('pass'),
         'nombre' => $this->input->post('nombre'),
         'telefono' => $this->input->post('telefono'),
         'correo' => $this->input->post('correo'),
         'permiso' => $permission,
         'foto' => 'usuario.png',
         'status' => '1'
       );
       $res = $this->auth_model->nuevo_usuario($new_user);
       if($res == 1){
         echo json_encode( array( 'mensaje' => 'Usuario registrado correctamente') );
       }
       else{
         echo json_encode( array('mensaje' => 'Hubo un error al registrar el usuario') );
       }
    }
    public function update_user(){
      $userid = $this->input->post('userid');
      $permission="";
      for ($i=1; $i<=22; $i++) {
        $permission .= $this->input->post('pos'.($i)).',';
      }
      //$permission = trim($permission,',');
       $update_user = array(
         'user' => $this->input->post('user'),
         'pass' => $this->input->post('pass'),
         'nombre' => $this->input->post('nombre'),
         'telefono' => $this->input->post('telefono'),
         'correo' => $this->input->post('correo'),
         'permiso' => $permission
       );
       $res = $this->auth_model->guardardatos($update_user, $userid);

       if($res == 1){
         echo json_encode( array( 'mensaje' => 'Registro actualizado correctamente') );
       }
       else{
         echo json_encode( array('mensaje' => 'Hubo un error al actualizar el registro') );
       }
    }
    public function baja(){
      $userid = $this->input->get('userid');
      $baja = $this->auth_model->baja($userid);
      if($baja == 1){
        echo json_encode( array( 'mensaje' => 'EL usuario ha sido dado de baja correctamente') );
      }
      else{
        echo json_encode( array('mensaje' => 'Hubo un error al procesar el usuario') );
      }
    }
    public function guardardatos(){
      $idusuario = $this->input->post('iduser');
      $nombre = $this->input->post('nombre');
      $usuario = $this->input->post('user');
      $password = $this->input->post('pass');
      $config = [
        "upload_path" => "./images/usuarios",
        "allowed_types" => "jpg|jpeg|png"
      ];
      $this->load->library('upload',$config);
      if($this->upload->do_upload('profile_img')){
        $data = array('upload_data' => $this->upload->data());
        $datos = array(
          'user' => $usuario,
          'pass' => $password,
          'nombre' => $nombre,
          'foto' => $data['upload_data']['file_name']
        );
        $res = $this->auth_model->guardardatos($datos, $idusuario);
        echo json_encode($res);
      }
      else{
        echo json_encode( array( "mensaje" => $this->upload->display_errors() ) );
      }
    }
    public function alluser(){
      echo json_encode($this->auth_model->alluser());
    }
    public function actualizaTarifa(){
      $tarifas = array();
      $cont=0;
      $result;
      foreach ($this->input->post() as $key => $value) {
         $tarifas[$cont] = $value;
         $cont++;
        //array_push($tarifas,$value);
      }
      $cont = 1;
      for ($i=0; $i <count($tarifas); $i+=3) {
        $sql = 'UPDATE tarifas SET lowSeasson='.$tarifas[$i].', weekend='.$tarifas[$i+1].', highSeasson='.$tarifas[$i+2].' WHERE idrates = '.$cont.'';
        $cont++;
        $actualiza = $this->auth_model->actualizatarifas($sql);
        $result =  $actualiza;
      }
      echo $result;
      //$update = $this->auth_model->actualizaTarifa($rate,$idrate);
    }
    public function datosCorreo(){
      echo json_encode($this->auth_model->configuracion_correo());
    }
    public function updateMail(){
      $host = $this->input->post('host');
      $port = $this->input->post('puerto');
      $user= $this->input->post('correo');
      $pass = $this->input->post('password');
      $datos_correo = array(
        'correo' => $user,
        'password' => $pass,
        'host' => $host,
        'puerto' => $port
      );
      $update = $this->auth_model->updateMail($datos_correo);
      echo $update;
    }
  }


 ?>
