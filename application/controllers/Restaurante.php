<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Restaurante extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->output->set_header('Access-Control-Allow-Origin: *');
    $this->load->library('session');
    $this->load->helper('cookie');
    $this->load->model('restaurante_model');
    $username['username'] = $this->session->userdata('nombre');
    if($this->input->cookie($this->session->userdata('nombre'),true ) !=null){
      redirect(base_url());
    }

  }
  public function index(){

      $username['username'] = $this->session->userdata('nombre');
      $username['profile_picture'] = base_url().'images/usuarios/'.$this->session->userdata('foto');
      $this->load->view('layout/header');
      $this->load->view('layout/menu',$username);
      $this->load->view('resturante');
      $this->load->view('layout/footer');

  }
  public function restaurante(){

      $username['username'] = $this->session->userdata('nombre');
      $username['profile_picture'] = base_url().'images/usuarios/'.$this->session->userdata('foto');
      $this->load->view('layout/header');
      $this->load->view('layout/menu',$username);
      $this->load->view('resturante');
      $this->load->view('layout/footer');

  }
  public function tickets(){

    $username['username'] = $this->session->userdata('nombre');
    $username['profile_picture'] = base_url().'images/usuarios/'.$this->session->userdata('foto');
    $idticket = $this->uri->segment(3);
    $username['datos'] = $this->restaurante_model->getTicket($idticket) ;
    $this->load->view('layout/header');
    $this->load->view('layout/ticket',$username);
    $this->load->view('layout/footer');
  }
  public function corte(){

  }
  public function setStatus(){
    $id = $this->input->post('idventa');
    $status = $this->input->post('status');
    $res = $this->restaurante_model->setStatus($id,$status);
    echo $res;
  }
  public function vertickets(){
    $username['username'] = $this->session->userdata('nombre');
    $username['profile_picture'] = base_url().'images/usuarios/'.$this->session->userdata('foto');
    $this->load->view('layout/header');
    $this->load->view('layout/menu',$username);
    $this->load->view('verTickets');
    $this->load->view('layout/footer');
  }
  public function getAllproducts(){
    $lookfor = $this->input->get('txt_buscar');
    $xpager = $this->input->get('xpager');
    $totalReg = $xpager != null ? ( $xpager -1 ) * 12 : '';
    if($lookfor != null){
      $productos = $this->restaurante_model->getproducts($lookfor);
    }
    else{
      $productos = $this->restaurante_model->getproducts($lookfor,'12',$totalReg);
    }
    echo json_encode($productos);
  }
  public function getTotalVentas(){
    $max = $this->restaurante_model->totalVentas();
    echo json_encode($max);
  }
  public function vistaxarticulo(){
    $idproducto = $this->input->get('referencia');
    $info = $this->restaurante_model->infoProduct($idproducto);
    echo json_encode($info);
  }
  public function alta_productos(){
      $username['username'] = $this->session->userdata('nombre');
      $username['profile_picture'] = base_url().'images/usuarios/'.$this->session->userdata('foto');
      $this->load->view('layout/header');
      $this->load->view('layout/menu',$username);
      $this->load->view('alta_productos');
  }
  public function maxProduct(){
    echo $this->restaurante_model->total_product();
  }
  public function guardarVenta(){
    $post = json_decode(trim(file_get_contents('php://input')), true);
    //$post = json_decode($this->security->xss_clean($this->input->raw_input_stream));
    $totalVenta = 0;
    for ($x=0; $x < count($post); $x++) {
      $totalVenta = $totalVenta + ( $post[$x]['cantidad'] * $post[$x]['precio'] );
    }
    $venta = $this->restaurante_model->guardarVenta($totalVenta);
    if($venta){
      $detalle = $this->restaurante_model->guardarDetalleV($post,$venta);
      echo $detalle;
    }

  }
  public function gettickets(){
    $lookfor = $this->input->get('txt_buscar');
    $xpager = $this->input->get('xpager');
    $totalReg = $xpager != null ? ( $xpager -1 ) * 12 : '';
    if($lookfor != null){
      $all = $this->restaurante_model->alltickets($lookfor);
    }
    else{
      $all = $this->restaurante_model->alltickets($lookfor,'12',$totalReg);
    }
    //$all = $this->restaurante_model->alltickets();
    echo json_encode($all);
  }
  public function nuevo_articulo(){

  }
  public function editarProducto(){
    $datos = array('descripcion' =>  $this->input->post('name'), 'precio' => $this->input->post('price'));
    $id = $this->input->post('idprod');
    $response = $this->restaurante_model->editArt($datos,$id);
    if($response == 1){
      echo json_encode(array('mensaje' => 'Los datos han sido guardados satisfactoriamente') );
    }
    else{
      echo json_encode(array('mensaje' => 'Ha habido un error al guardar los datos'));
    }
  }
}
