<style media="print">
  *{font-family: 'Roboto', sans-serif;margin:0; padding:0px;}

  body{
    background-image:url(../media/bg-centi.png);
    font-family:Arial, Helvetica, sans-serif;
    margin:0;
  }
  p{
    margin: 0;
  }
</style>
<div class="container " id="ticket">
  <div >
      <center><img src="<?=base_url();?>/images/favicon.png" width="180"></center>
      <div class="text-center">
        <p>HOTEL CENTINELA GRAND</p>
        <p>Alvaro Obregon #48</p>
        <p>Arandas, Jalisco</p>
        <p>Tel (348)-783-1192</p>
      </div>
      <p>ticket # <?php echo $datos[0]->idventa; ?></p>
      <p>Fecha <?php echo date('Y-m-d'); ?></p>
      <hr></hr>
      <table cellspacing="2" cellpadding="2" width="100%">
        <thead>
          <tr>
            <th align="center">Cantidad</th>
            <th align="center">Descripcion</th>
            <th align="center">Precio</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $total = 0;
        $venta = 0;
        foreach ($datos as $key) {
          $total  = $key->total;
          echo '
          <tr >
            <td>
            '.$key->cantidad.'
            </td>
            <td>
            '.$key->descripcion.'
            </td>
            <td>
            '.$key->precio.'
            </td>
          </tr>
          ';
        }
        ?>
        </tbody>
      </table>
      <hr></hr>
      <div class="text-right" style="font-size:25;">
        <label style="margin-right:35px;">TOTAL</label><?php echo '$'. $total; ?>
      </div>
      <div class="text-center">
          <p>USTED FUE ATENDIDO POR</p>
          <p><?php echo $username; ?></p>
          <h4>GRACIAS POR SU COMPRA</h4>
      </div>
  </div>
</div>
<div class="text-center">
  <button class="btn btn-default" onclick="imprimir()">Imprimir</button>
</div>
<script>
  function imprimir(){
    $('#ticket').printThis({
      debug:true,
      header:null,
      footer:null,
      importCSS:true,
      importStyle:true
    });
  }
</script>
