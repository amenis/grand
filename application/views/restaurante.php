<div class="container" id="restaurante">
  <img src="<?=base_url();?>fonts/glyphicons-191-plus-sign.png" alt="add" class="add" v-on:click="add">
  <table class="table table-hover">
    <thead>
      <tr>
        <th >#</th>
        <th >Nombre</th>
        <th >Cantidad</th>
        <th></th>
      </tr>
    </thead>
    <tbody id="ventas">

    </tbody>
  </table>
</div>
<script>
  var restaurant = new Vue({
    el: "#restaurante",
    data:{
      cont: 1
    },
    methods:{
      add:function(){
        var rows =
        `
        <tr>
          <td ></td>
          <td ><input type="text" name="product" size="70" ></td>
          <td ><input type="number" name="quantity" min="0" size="5"></td>
          <td><img src="<?=base_url();?>fonts/glyphicons-198-remove-circle.png" alt="del" v-on:click="del(this)"></td>
        </tr>
        `;
        this.cont++;
        $('#ventas').append(rows);
      },
      del:function(este){
        alert($(este).attr('alt'));
      }
    }
  });
</script>
