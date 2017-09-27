<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Home extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->output->set_header('Access-Control-Allow-Origin: *');
    $this->load->library('session');
    $this->load->helper('cookie');
    $this->load->library('pagination');
    //$this->load->helper('date');
    $this->load->model('reserv_model');
  //  $username['username'] = $this->session->userdata('nombre');
    if($this->input->cookie($this->session->userdata('nombre'),true ) !=null){
      redirect(base_url());
    }
  }

  public function index(){

      $username['username'] = $this->session->userdata('nombre');
      $username['profile_picture'] = base_url().'images/usuarios/'.$this->session->userdata('foto');
      $this->load->view('layout/header');
      $this->load->view('layout/menu',$username);
      $this->load->view('home');

  }
  public function newReservation(){

      $username['username'] = $this->session->userdata('nombre');
      $username['profile_picture'] = base_url().'images/usuarios/'.$this->session->userdata('foto');
      $this->load->view('layout/header');
      $this->load->view('layout/menu',$username);
      $this->load->view('newReserv');


  }

/*
  public function paginacion(){

    // URL a la que se desea agregar la paginación
    $config['base_url'] = base_url().'home/ver_reserva';
    //Obtiene el total de registros a paginar
    $config['total_rows'] = $this->reserv_model->get_total_reserv();
    //Obtiene el numero de registros a mostrar por pagina
    $config['per_page'] = '12';
    //Indica que segmento de la URL tiene la paginación, por default es 3
    $config['uri_segment'] = '3';
    //Se personaliza la paginación para que se adapte a bootstrap
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $config['last_link'] = FALSE;
    $config['first_link'] = FALSE;
    $config['next_link'] = '&raquo;';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_link'] = '&laquo;';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    // Se inicializa la paginacion
    $this->pagination->initialize($config);
  }*/
  //obtenemos la lista completa de reservaciones registradas en el sistema
  public function ver_reserva(){
     //$offset = $this->uri->segment(3);
      $username['username'] = $this->session->userdata('nombre');
      $username['profile_picture'] = base_url().'images/usuarios/'.$this->session->userdata('foto');
      //$this->paginacion();
      // $datos['reservaciones'] =$this->reserv_model->get_reserv('','12') ;

      $this->load->view('layout/header');
      $this->load->view('layout/menu',$username);
      $this->load->view('ver_reserv');
      $this->load->view('layout/footer');

  }
  //obtenemos el ultimo id registado
  public function maxidreservations(){
    $max = $this->reserv_model->numofreserv();
    echo json_encode($max);
  }
  public function getTotalReg(){
    $totalReg = $this->reserv_model->get_total_reserv();
    echo json_encode($totalReg);
  }
  //solicitamos todas las habitaciones que existen en el hotel
  public function getRooms(){
    $getRoom = $this->reserv_model->get_rooms_ocupated();
    echo json_encode($getRoom);
  }
  //solictamos todos los precios de las habitaciones por temporadas
  public function rates(){
    $rates = $this->reserv_model->getRates();
    echo json_encode($rates);
  }
  //generamos una nueva reservacion que es registrada en el sistema
  public function save(){
    $datos = array();
    $datos['huesped'] = $this->input->post('nombre');
    $datos['fecha_in'] = $this->input->post('datein');
    $datos['fecha_out'] = $this->input->post('dateout');
    $datos['noches'] = $this->input->post('noches');
    $datos['habitacion'] = $this->input->post('habitacion');
    //$nPersons = mysql_real_escape_string($conexion,$_POST['npersons']);
    $datos['tarifa'] = $this->input->post('tarifa');
    $datos['extra'] = $this->input->post('extra');
    $datos['descuento'] = $this->input->post('off');
    $datos['total'] = (($datos['tarifa']*$datos['noches'])-$datos['descuento']*$datos['noches'])+$datos['extra'];
    $datos['telefono'] = $this->input->post('telefono');
    $datos['email'] = $this->input->post('email');
    $datos['vehiculo'] = $this->input->post('vehiculo');
    //$fecha_llegada = mysqli_real_escape_string($conexion,$_POST['llegada']);
    $datos['hora_llegada'] = $this->input->post('hora');
    $datos['pago'] = $this->input->post('pago');
    $datos['factura'] = $this->input->post('factura');
    $datos['status'] = $this->input->post('status');
    $datos['comentario'] = $this->input->post('comments');
    $res = $this->reserv_model->save($datos);
    if($res == true ){
      echo json_encode(array('mensaje' => 'La reservacion registro correctamente'));
    }
  }
  //obtenemos la informacion una reservacion a partir de su numero de reserva
  public function verReservacion(){
    $idreservacion = $this->input->get('idreservacion');
    $result = $this->reserv_model->see_information($idreservacion);
    echo json_encode($result);
  }
  //obtenemos la informacion de la habitacion basandose en la reservacion
  public function verHabitacion(){
    $idhabitacion = $this->input->get('nhabitacion');
    $result = $this->reserv_model->habitacion($idhabitacion);
    echo json_encode($result);
  }
  //registramos la entrada del huesped
  public function checkin(){
    $id = $this->input->post('idreservacion');
    $result = $this->reserv_model->checkin($id);
    echo json_encode($result);
  }
  //registramos la salida del huesped
  public function checkout(){
    $id = $this->input->post('idreservacion');
    $result = $this->reserv_model->checkout($id);
    echo json_encode($result);
  }
  //cancelamos la reservacion
  public function cancel(){
    $id = $this->input->post('idreservacion');
    $result = $this->reserv_model->cancel($id);
    echo json_encode($result);
  }
  //check the rooms that are about to leave
  public function salidas(){
    $salidas = $this->reserv_model->salidas();
    echo json_encode($salidas);
  }
  //buscamos si hay habitaciones disponibles a partir de dos fechas dadas
  public function disponibilidad(){
    $fecha_in = $this->input->get('fecha_in');
    $fecha_out = $this->input->get('fecha_out');
    $result = $this->reserv_model->disponibilidad($fecha_in,$fecha_out);
    echo json_encode($result);
  }
  public function buscar(){
    $lookfor = $this->input->get('txt_buscar');
    $xpager = $this->input->get('xpager');
    $totalReg = $xpager != null ? ( $xpager -1 ) * 12 : '';
    if($lookfor != null){
      $result = $this->reserv_model->get_reserv($lookfor);
    }
    else{
      $result = $this->reserv_model->get_reserv($lookfor,'12',$totalReg);
    }

    echo json_encode($result);
  }
  public function busquedafecha(){
    $fecha1 = $this->input->get('fecha1');
    $fecha2 = $this->input->get('fecha2');
    $result = $this->reserv_model->busquedafecha($fecha1,$fecha2);
    echo json_encode($result);
  }
  //editamos las reservacion en caso de existir un cambio o un error
  public function editar_reserv(){
    $datos = array();
    $id = $this->input->post('id_reserv');
    $datos['huesped'] = $this->input->post('nombre');
    $datos['fecha_in'] = $this->input->post('datein');
    $datos['fecha_out'] = $this->input->post('dateout');
    $datos['noches'] = $this->input->post('noches');
    $datos['habitacion'] = $this->input->post('habitacion');
    //$nPersons = mysql_real_escape_string($conexion,$_POST['npersons']);
    $datos['tarifa'] = $this->input->post('tarifa');
    $datos['extra'] = $this->input->post('extra');
    $datos['descuento'] = $this->input->post('off');
    $datos['total'] = (($datos['tarifa']*$datos['noches'])-$datos['descuento']*$datos['noches'])+$datos['extra'];
    $datos['telefono'] = $this->input->post('telefono');
    $datos['email'] = $this->input->post('email');
    $datos['vehiculo'] = $this->input->post('vehiculo');
    //$fecha_llegada = mysqli_real_escape_string($conexion,$_POST['llegada']);
    $datos['hora_llegada'] = $this->input->post('llegada');
    $datos['pago'] = $this->input->post('pago');
    $datos['factura'] = $this->input->post('factura');
    $datos['status'] = $this->input->post('status');
    $datos['comentario'] = $this->input->post('comments');
    $result = $this->reserv_model->editar($datos,$id);
    if($result == true ){
     echo json_encode(array('mensaje' => 'El registro se edito correctamente' ));
   }
   else{
     echo json_encode(array('mensaje' =>  $result ));
   }
  }
  public function cambio_status(){
    $id = $this->input->post('idroom');
    $status = $this->input->post('status');
    $result = $this->reserv_model->cambio_estado($id,$status);
  }
}
