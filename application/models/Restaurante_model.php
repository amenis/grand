<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Restaurante_model extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->load->library('session');
    $this->load->helper('date');
  }
  public function getproducts($buscar,$xpage = false,$segment =false ){
    $this->db->like("descripcion",$buscar);
    $this->db->order_by("idproductos","ASC");
    $query = $this->db->get('productos',$xpage ,$segment);
    if( $query->num_rows() > 0 ){
      return $query->result();
    }
    else {
      return false;
    }
  }
  public function infoProduct($idproduct){
    $this->db->where('idproductos',$idproduct);
    $query = $this->db->get('productos');
    if( $query->num_rows() > 0 ){
      return $query->result();
    }
    else{
      return false;
    }
  }
  public function total_product(){
   return $this->db->count_all('productos');
  }
  public function totalVentas(){
    $maxid = "SELECT MAX(idventa) AS idventa FROM venta";
    $result = $this->db->query($maxid);
    return $result->row();
  }
  public function guardarVenta($total){
    $id =  $vendedor = $this->session->userdata("id");
    $this->db->set('fecha',date('Y-m-d'));
    $this->db->set('vendedor',$id);
    $this->db->set('total',$total);
    $this->db->set('status','activa');
    $this->db->insert('venta');
    return $last_id = $this->db->insert_id();
  }
  public function guardarDetalleV($post,$idventa){
    for ($y=0; $y < count($post); $y++) {
      $this->db->set('idventa',$idventa);
      $this->db->set('idproducto',$post[$y]['idproducto']);
      $this->db->set('cantidad',$post[$y]['cantidad']);
      $this->db->set('total',$post[$y]['precio']);
      $this->db->insert('detalle_venta');
    }
    return true;
  }
  public function setStatus($id,$value){
    $array = array('status' => $value  );
    $this->db->where('idventa',$id);
    return $this->db->update('venta', $array );
  }
  public function getTicket($idticket){
    $ticket = $idticket !=  '' ? $idticket : $this->totalVentas()->idventa;
    $this->db->where('idventa',$ticket);
    $res = $this->db->get('v_tickets');
    return $res->result();
  }
  public function alltickets($buscar,$xpage = false,$segment =false){
    $this->db->like("idventa",$buscar);
    $this->db->order_by("idventa","DESC");
    $query = $this->db->get('venta',$xpage ,$segment);
    if( $query->num_rows() > 0 ){
      return $query->result();
    }
    else {
      return false;
    }
    //eturn $this->db->get('venta')->result();
  }
  public function nuevo_articulo($nuevo){
    $nuevo_articulo = array(

    );
  }
  public function editArt($datos,$id){
    $this->db->where('idproductos',$id);
    $edicion = $this->db->update('productos',$datos);
    return $edicion;
  }
}
