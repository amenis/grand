<?php
  if($this->uri->segment(2) == "ver_reserva"){
    echo '<script src="'.base_url().'js/vrv.js"></script>';
  }
  if($this->uri->segment(2) === 'restaurante' ){
    echo '<script src="'.base_url().'js/restaurante.js"></script>';
  }
?>
