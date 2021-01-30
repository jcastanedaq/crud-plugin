(function( $ ) {
	'use strict';

	/**
	 * Todo el código Javascript orientado a la administración
	 * debe estar escrito aquí
	 */

	var $precargador = $('.precargador'),
		urledit = '?page=cp_data&ction=edit&id=';
	$('.modal').modal();
	
	 $('.addcptable').on('click', function(e){
			e.preventDefault();
			$('#add_cp_table').modal('open');
	 });

	 $('#crear-tabla').on('click', function(e){
		e.preventDefault();
		var $nombre = $('#nombre_tabla'),
			nv = $nombre.val();

		if(nv != ''){
			$precargador.css('display', 'flex');
			//envio de AJAX
			$.ajax({
				url:cpdata.url,
				type:'POST',
				dataType: 'json',
				data: {
					action: 'cp_crud_table',
					nonce: cpdata.seguridad,
					nombre: nv,
					tipo: 'add'
				}, success: function( data) {
					if( data.result ){
						urledit += data.insert_id;

						setTimeout(function(){
							location.href = urledit;
						}, 1300 );
					}
				}, error: function( d,x,v ) {
					console.log(d);
					console.log(x);
					console.log(v);
				}
			})
		} else {

			$precargador.css('display', 'none');

			if( !$nombre.hasClass('invalid')){
				$nombre.addClass('invalid');
			}

		}
	 });
    

})( jQuery );