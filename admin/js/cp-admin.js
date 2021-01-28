(function( $ ) {
	'use strict';

	/**
	 * Todo el código Javascript orientado a la administración
	 * debe estar escrito aquí
	 */
	$('.modal').modal();
	
	 $('.addcptable').on('click', function(e){
			e.preventDefault();
			$('#add_cp_table').modal('open');
	 });
    

})( jQuery );