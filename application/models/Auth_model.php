<?php

class Auth_model extends CI_Model{
	public function __construct()
	 {
			 parent::__construct();
	 }

	 public function login_user($username,$password){
		 $this->db->where('user',$username);
		 $this->db->where('pass',$password);
		 $query = $this->db->get('usuarios');
		 if($query->num_rows() >= 1)
		 {
			 return $query->row();

		 }else{
			 return $query->row();
		 }
	 }
	 public function datosuser($id){
		$this->db->where('idusuario',$id);
		$query = $this->db->get('usuarios');
		return $query->result();
	 }
	 public function guardardatos($data,$id){
		 $this->db->where('idusuario',$id);
		 $update = $this->db->update('usuarios',$data);
		 return $update;
	 }
	 public function alluser(){
		 $this->db->where('status',1);
		 $res =  $this->db->get('usuarios');
		 return $res->result();
	 }
	 public function nuevo_usuario($array){
		 return $this->db->insert('usuarios',$array);
	 }
	 public function baja($userid){
		 $this->db->where('idusuario',$userid);
		 return $this->db->update('usuarios',array('status'=> 0) );
	 }
	 public function configuracion_correo(){
		 $datos_correo = $this->db->get('correo');
		 return $datos_correo->result_array();
	 }
	 public function updateMail($datos){
		 return $this->db->update('correo',$datos);
	 }
	 public function actualizatarifas($sql){
		 return $this->db->query($sql);
	 }
}
