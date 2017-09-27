<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Reserv_model extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->load->library('session');
    $this->load->helper('date');
  }
  public function numofreserv(){
    $maxid = "SELECT MAX(idreservacion) AS idrv FROM reservacion";
    $result = $this->db->query($maxid);
    return $result->row();
  }
  public function get_rooms_ocupated(){
    $roomsOcupated = "SELECT * FROM habitacion LIMIT 0,14";
    $result = $this->db->query($roomsOcupated);
    if($result->num_rows() >= 1){
      return $result->result();
    }
    else{
      return "No se encontraron registros";
    }
  }
  public function getRates(){
    $rates = "SELECT lowSeasson,weekend,highSeasson FROM tarifas";
    $result = $this->db->query($rates);
      return $result->result();
  }
  public function save($datos){
    //$horaFecha = new DateTime();
    $data = array(
      'estado' => $datos['status'],
      'nombre' => $datos['huesped'],
      'fecha_in' => $datos['fecha_in'],
      'fecha_out' => $datos['fecha_out'],
      'nnoches' => $datos['noches'],
      'habitacion' => $datos['habitacion'],
      'tarifa' => $datos['tarifa'],
      'descuento' => $datos['descuento'],
      'extra' => $datos['extra'],
      'total' => $datos['total'],
      'email' => $datos['email'],
      'telefono' => $datos['telefono'],
      'vehiculo' => $datos['vehiculo'],
      'observaciones' => $datos['comentario'],
      'factura' => $datos['factura'],
      'reservo' => $this->session->userdata("id"),
      'hora' => date('g:i:s'),
      'fecha' => date('Y-m-d'),
      'pago' => $datos['pago'],
      'horallegada' => $datos['hora_llegada']
    );

      return  $this->db->insert('reservacion',$data);

    //$save = "INSERT INTO  reservacion  ( estado ,  nombre ,  fecha_in ,  fecha_out ,  nnoches , habitacion ,  tarifa ,  descuento ,  extra ,  total ,  email ,  telefono ,  vehiculo ,  observaciones , factura ,  reservo ,  hora ,  fecha , pago ,  horallegada )   VALUES ( '".$datos['status']."', '".$datos['huesped']."','".$datos['fecha_in']."','".$datos['fecha_out']."', '".$datos['noches']."','".$datos['habitacion']."','".$datos['tarifa']."','".$datos['descuento']."','".$datos['extra']."','".$datos['total']."','".$datos['email']."','".$datos['telefono']."','".$datos['vehiculo']."','".$datos['comentario']."','".$datos['factura']."','".$this->session->userdata('id')."','".date('g:i A')."', '".date('Y-m-d')."','".$datos['pago']."','".$datos['hora_llegada']."' )";
    //$result = $this->db->query($save);
  ////  return $result->result();
  }
  public function editar($datos,$id){
    $data = array(
      'estado' => $datos['status'],
      'nombre' => $datos['huesped'],
      'fecha_in' => $datos['fecha_in'],
      'fecha_out' => $datos['fecha_out'],
      'nnoches' => $datos['noches'],
      'habitacion' => $datos['habitacion'],
      'tarifa' => $datos['tarifa'],
      'descuento' => $datos['descuento'],
      'extra' => $datos['extra'],
      'total' => $datos['total'],
      'email' => $datos['email'],
      'telefono' => $datos['telefono'],
      'vehiculo' => $datos['vehiculo'],
      'observaciones' => $datos['comentario'],
      'factura' => $datos['factura'],
      'reservo' => $this->session->userdata("id"),
      'hora' => date('g:i:s'),
      'fecha' => date('Y-m-d'),
      'pago' => $datos['pago'],
      'horallegada' => $datos['hora_llegada']
    );
    $this->db->where('idreservacion', $id);
    return $this->db->update('reservacion', $data);
  }
  public function get_reserv($buscar,$xpage = false,$segment =false ){
     $this->db->like("nombre_cliente",$buscar);
     $this->db->or_like('id_reservacion',$buscar);
     $this->db->order_by("id_reservacion","DESC");
     $query = $this->db->get('v_disponible',$xpage ,$segment);
     if( $query->num_rows() > 0 ){
       return $query->result();
     }
     else {
       return false;
     }
  }
  public function busquedafecha($fecha1,$fecha2){
      $sql = "SELECT * FROM v_disponible WHERE fecha_in BETWEEN '".$fecha1."' AND '".$fecha2."' ";
      $query = $this->db->query($sql);
      return $query->result();
  }
  public function get_total_reserv(){
   return $this->db->count_all('v_disponible');
  }
  public  function see_information($idreservacion){

    $this->db->where('idreservacion',$idreservacion);
    $query= $this->db->get('reservacion');

    //$query = $this->db->query($sql);
    if( $query->num_rows() > 0 ){
      return $query->result();
    }
    else{
      return false;
    }
  }
  public function habitacion($id){
    $sql = "SELECT vd.id_reservacion AS reservacion, vd.nombre_cliente, h.idhabitacion AS habitacion, vd.fecha_in, vd.fecha_out,vd.total FROM `v_disponible` vd RIGHT JOIN habitacion h ON h.idhabitacion = vd.habitacion WHERE h.idhabitacion = ".$id." AND vd.estado = 2 ORDER BY vd.id_reservacion DESC";
    $query = $this->db->query($sql);
    return $query->result();
  }
  public function salidas(){
    $this->db->select('id_reservacion,nombre_cliente,habitacion,fecha_out');
    $this->db->where('fecha_out',date('Y-m-d'));
    $query = $this->db->get('v_disponible');
    return $query->result();
  }
  public function checkin($idrv){
    $data = array( 'estado' => '2' );
    $rv_status = $this->db->where('idreservacion', $idrv);
    $rv_status = $this->db->update('reservacion', $data);
    if($rv_status){
      $sql = "UPDATE habitacion AS h, (SELECT habitacion FROM reservacion WHERE idreservacion = ".$idrv." ) AS rv SET h.status= 2 WHERE h.idhabitacion = rv.habitacion";
      $room_status = $this->db->query($sql);
      if($room_status){
        return $room_status;
      }
      else{
        return false;
      }
    }
    else{
      return false;
    }
  }
  public function checkout($idrv){

    $get_status = $this->db->query("UPDATE reservacion SET estado = 3 WHERE idreservacion = ".$idrv);
    $sql = "SELECT fecha_out, habitacion FROM reservacion WHERE idreservacion = ".$idrv;
    $dates = $this->db->query($sql);
    $res = $dates->row();

    //we take the actual date and after decrease the actual date one month
    $fecha = date('Y-m-j');
    $nuevafecha = strtotime ( '-1 month' , strtotime ( $fecha ) ) ;
    $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
    $sql2 = "SELECT  COUNT(vd.id_reservacion) AS cantidad FROM v_disponible vd WHERE habitacion IN (SELECT h.idhabitacion FROM habitacion h WHERE H.status = 2 AND h.idhabitacion = vd.habitacion) AND vd.habitacion = '".$res->habitacion."'  AND fecha_out >= '".date('Y-m-d')."'  AND NOT vd.id_reservacion = '".$idrv."' ";
    $existe_reserva = $this->db->query($sql2);
    $res =  $existe_reserva->row();
    if($res->cantidad == 0 ){
      $sql2 = "UPDATE habitacion AS h, (SELECT habitacion FROM reservacion WHERE idreservacion = '".$idrv."' ) AS rv SET h.status= 1 WHERE h.idhabitacion = rv.habitacion";
      $room_status = $this->db->query($sql2);
      if($room_status){
        return $room_status;
      }
    }
    else{
      return false;
    }

    /*

    //we gonna check if the reservation date is low to a month this way if we want to cancel a reservation and that it is old then the status of the room doesn't change
    if( $res->fecha_out > $nuevafecha ){
      $sql2 = "UPDATE habitacion AS h, (SELECT habitacion FROM reservacion WHERE idreservacion = '".$idrv."' ) AS rv SET h.status= 1 WHERE h.idhabitacion = rv.habitacion";
      $room_status = $this->db->query($sql2);
      if($room_status){
        return $room_status;
      }
      else{
        return false;
      }
    }
    else{
      return false;
    }*/
  }
  public function cancel($idrv){
    $cancel = $this->db->where('idreservacion',$idrv);
    return $cancel = $this->db->update('reservacion',array('estado' => '4'));
  }
  public function disponibilidad($fi,$fo){
    //we searching if there are any room available depending of dates in and dates out
    $sql= "SELECT h.idhabitacion, h.tipo FROM habitacion h WHERE NOT EXISTS ( SELECT * FROM v_disponible VD WHERE vd.habitacion = h.idhabitacion AND vd.fecha_out >= '".$fi."' AND vd.fecha_in <= '".$fo."' AND vd.estado < 2 )";
    $query = $this->db->query($sql);
    return $query->result();
  }
  public function cambio_estado($id,$estado){
    $sql = "UPDATE habitacion SET status =".$estado." WHERE idhabitacion = ".$id;
  }
  /*
  public function buscar($req){
    $this->db->like('id_reservacion',$req,'both');
    $this->db->or_like('nombre_cliente',$req, 'both');
    $query = $this->db->get('v_disponible');
    return $query->result();
  }*/
}
