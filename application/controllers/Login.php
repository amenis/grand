<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
class Login extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->library('session');
    $this->load->helper('cookie');
    $this->load->model('auth_model');

  }

  public function validate(){
      $username =  $this->input->post('user');//$_POST['user'];
      $password = $this->encrypthash($this->input->post('pass')); //$_POST['pass'];

      $validate_login = $this->auth_model->login_user($username,$password);
      if($validate_login == true ){
        $datos =  array();
        foreach ($validate_login as $key => $value) {
          $datos[$key] = $value;
        }
        $uniqueId = uniqid(rand(), TRUE);
        $this->session->set_userdata('nombre',$datos['nombre']);
        $this->session->set_userdata('id',$datos['idusuario']);
        $this->session->set_userdata('permisos',$datos['permiso']);
        $this->session->set_userdata('foto',$datos['foto']);
        $this->session->set_userdata('session_id',$uniqueId);
        $cookie = array(
          'name'   => sha1($this->session->userdata('nombre')),
          'value'  => $this->session->userdata('session_id'),
          'expire' => '3600',
          'secure' => TRUE
        );
        $this->input->set_cookie($cookie);
        echo json_encode(array("mensaje" => "welcome"));
      }
      else{
        echo json_encode(array("mensaje" => "Error"));
      }
  }
  public function logout(){
    delete_cookie(sha1($this->session->userdata('nombre')));
    $array_items = array('nombre', 'id', 'permisos','session_id');
    $this->session->unset_userdata($array_items);
    redirect(base_url());
  }
  public function encrypthash($data = "", $width=192, $rounds = 3) {
    return substr(
        implode(
            array_map(
                function ($h) {
                    return str_pad(bin2hex(strrev($h)), 16, "0");
                },
                str_split(hash("sha512", $data, true), 8)
            )
        ),
        0, 48-(192-$width)/4
    );
  }
}
