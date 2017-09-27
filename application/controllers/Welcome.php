<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->output->set_header('Access-Control-Allow-Origin: *');
		$this->load->library('session');
		$this->load->helper('cookie');
		if($this->input->cookie($this->session->userdata('nombre'),true ) !=null){
			$this->load->view('welcome_message');
		}
		else{
			$username['username'] = $this->session->userdata('nombre');
			$username['profile_picture'] = base_url().'images/usuarios/'.$this->session->userdata('foto');
			$this->load->view('layout/header');
			$this->load->view('layout/menu',$username);
			$this->load->view('home');

		}
	}
}
