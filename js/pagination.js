(function(){
  Vue.component('pagination', {
    template:
    `
    <ul class="pagination">
      <li><a>&laquo;</a></li>
      <li><a>&lsaquo;</a></li>
      <li><a @click="busqueda('','1');">2</a></li>
      <li><a>&rsaquo;</a></li>
			<li><a>&raquo;</a></li>
    </ul>
    `,
    props:{
      pager_url:{
        type: Number,
        require: true,
      },
      options: {
	      type: Object,
	      required: false,
	      default: function _default() {
	        return {};
	      }
	    }
    },
    data: function data(){
      return {
        firstpage: true,
        beforepage: true,
        nextpage: true,
        lastpage: true,
        xpager : this.pager_url,
      }
    },
    methods:{
      busqueda:function(name,xpager){
        this.$emit('busqueda',name,xpager)
      }
    },
  });

})();
