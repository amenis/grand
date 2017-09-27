<?php
  /**
   *
   */
  class Correo extends CI_Controller
  {

    function __construct()
    {
      parent::__construct();
      $this->output->set_header('Access-Control-Allow-Origin: *');
      $this->load->library('email');
      $this->load->model('auth_model');
      $this->load->model('reserv_model');
    }
    public function mailConfiguration(){

      //we get the mail configuration saved at the DB
      $datos_correo = $this->auth_model->configuracion_correo();
      $config = array(
        'smtp_host' => $datos_correo[0]['host'],
        'smtp_user' => $datos_correo[0]['correo'],
        'smtp_pass' => $datos_correo[0]['password'],
        'smtp_port' => $datos_correo[0]['puerto']
      );
        //push the mail config array into the method email
      $this->email->initialize($config);
    }
    public function sendmail(){

      $email =  $this->input->get('email');
      $reservid = $this->input->get('reservid');
      //we instantiate the mailConfiguration to apply the data to send the email
      $this->mailConfiguration();
      //get the data of user to send email
      $datoreserv = $this->reserv_model->see_information($reservid);
      //convert stdClass to array
      $resvdata = json_decode(json_encode($datoreserv),true);

      //tittle of mail
      $subject = 'HOTEL CENTINELA GRAND';
      // Get full html:
      //body html message
      $body = '

        <h2>¡Gracias por tu reservación!</h2>
        <h4>Datos de la Reservacion</h4>
        <p>
          # Reservacion:   '.$resvdata[0]['idreservacion'].'   <br>
          Nombre:    '.$resvdata[0]['nombre'].'         <br>
          Correo:    '.$resvdata[0]['email'].'         <br>
          Telefono:   '.$resvdata[0]['telefono'].'         <br>
          Fechas Programadas: de '.$resvdata[0]['fecha_in'].'  al    '.$resvdata[0]['fecha_out'].'    <br>
          --------------------------------------- <br>
           Cantidad de Noches:   '.$resvdata[0]['nnoches'].' <br>
           Precio por Noche:   '.$resvdata[0]['tarifa'].'   <br>
          --------------------------------------- <br>
                        TOTAL:  '.$resvdata[0]['total'].'    <br>
        </p>
        <p style="border-style: dotted">
          <h5>Pago</h5>
          Banco:    Santander <br>
          Nombre:   Centinela Grand SA de CV<br>
          No. Cuenta:  65-50427814-7<br>
          Cable:  014327655042781472<br>
        </p>
        <p style=color:#FF0000> Nota: Será necesario cubrir el anticipo 7 días antes de lo contrario su reversación podria no ser valida </p>
        <br><br>
        <div style=\"padding-top:20px\">
          <h4>Reglamento</h4>
          <p>
            Hora de Entrada 02:00 PM<br>
            Entrega de Haabitacion: 12:00 PM<br>
            No se permite fumar dentro de las instalaciones<br>
            Máximo 1 persona extra por habitacion con un costo de $100.00 MXN<br>
          </p>
        </div>
        ';

      $result = $this->email
        ->from('fgonzalez@casacentinela.com','Hotel Centinela Grand')
        //->reply_to('')    // Optional, an account where a human being reads.
        ->to($email)
        ->subject($subject)
        ->message($body)
        ->send();

      echo $result;
      $this->email->print_debugger();
      $this->email->clear();
      exit;
     //echo json_encode(array( 'subject' => $subject, 'body' => $body ) );
    }
  }
 ?>
