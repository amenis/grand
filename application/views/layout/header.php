<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="<?=base_url();?>images/favicon.png">
    <title>Centinela Grand</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?=base_url();?>/css/alertify.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/main.css">
    <?php
      if($this->uri->segment(1) == "restaurante"){
        echo '<link rel="stylesheet" href="'.base_url().'css/restaurante.css">';
      }
    ?>
    <script>
        var base_url = '<?=base_url();?>';
    </script>
    <script src="<?php echo base_url();?>js/jquery.min.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>js/vue.js"></script>
    <script src="<?php echo base_url();?>js/vue-resource.min.js" charset="utf-8"></script>
    <script src="<?php echo base_url();?>js/printThis.js" ></script>
    <script src="<?=base_url();?>js/alertify.js" charset="utf-8"></script>
  </head>
