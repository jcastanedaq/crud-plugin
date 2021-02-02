(function( $ ) {
	'use strict';

	/**
	 * Todo el código Javascript orientado a la administración
	 * debe estar escrito aquí
	 */

	var $precargador = $('.precargador'),
		urledit = '?page=cp_data&action=edit&id=',
		marcoimg = $('.marcoimg img'),
		selectimgval = $('#selectimgval'),
		idTable = $('#idTable').val(),
		marco;
	/*
	+Helpers
	*/
	function limpiarEnlace (url){

		var local = /localhost/;

		if(local.test(url)){

			var url_pathname = location.pathname,
				indexPos = url_pathname.indexOf('wp-admin'),
				url_pos = url_pathname.substr(0, indexPos),
				url_delete = location.protocol + "//" + location.host + url_pos;

			return url_pos + url.replace(url_delete, '');

		} else {

			var url_real = location.protocol + '//' + location.hostname;

			return url.replace(url_real, '');
		}

	}

	function validarCamposVacios(selector){
		var inputs = $(selector),
			result = false;

			$.each(inputs, function(k,v){

				var input = $(v),
					inputVal = input.val();

				if(inputVal == '' && input.attr('type') != 'file'){
					if(!input.hasClass('invalid')){
						input.addClass('invalid');
					}

					result = true;
				}
			});

			if(result) {
				return true;
			}else{
				return false;
			}
	}

	function validarEmail(email){
		var er = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			
		return er.test(email);
	}

	function quitarInvalid(selector){
		var inputs = $(selector),
			result = false;

			$.each(inputs, function(k,v){

				var input = $(v);

				if(input.hasClass('invalid')){
					input.removeClass('invalid');
				}else if(input.hasClass('active')){
					input.removeClass('active');
				}
			});
	}
	

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

	 $(document).on('click', '[data-cp-id-edit]', function(){
		var id = $(this).attr('data-cp-id-edit');
		location.href = urledit+id;
	 });

	 $(document).on('click', '[data-cp-id-remove]', function(){
		var id = $(this).attr('data-cp-id-remove');
		location.href = urledit+id;
	 });

	 $('.addItem').on('click', function(e){
		e.preventDefault();
		$('#addUpdate').modal('open');
	 });
	 
	 $('#selectimg').on('click', function(e){
		e.preventDefault();

		if( marco ){
			marco.open();
			return;
		}

		var marco = wp.media({
			frame: 'select',
			title: 'Seleccionar imagen para el usuario',
			button: {
				text: 'Usar esta imagen'
			},
			multiple: false,
			library:{
				type:'image'
			}
		});

		marco.on('select', function(){
			var imagen =  marco.state().get('selection').first().toJSON(),
			url_real = limpiarEnlace(imagen.url);
			selectimgval.val(url_real);
			marcoimg.attr('src', url_real);
			limpiarEnlace(url_real);
		});

		marco.open();
	 });

	 $('#agregar').on('click', function(e){
		e.preventDefault();

		var $n = $('#nombres'),
			$a = $('#apellidos'),
			$e = $('#email'),
			nombres = $n.val(),
			apellidos = $a.val(),
			email = $e.val(),
			imgVal = selectimgval.val();

			//validando datos

		if( validarCamposVacios('.formuData input')){

			console.log('validando');

		}else if(! validarEmail(email)){
			$('.formuData input').removeClass('invalid');
			if(! $e.hasClass('invalid')){
				$e.addClass('invalid');
			}
		}else{
			quitarInvalid('.formuData input');
			$precargador.css('display', 'flex');
			console.log('todo bien');
			console.log(idTable);
			$.ajax({
				url:cpdata.url,
				type:'POST',
				dataType: 'json',
				data: {
					action: 'cp_crud_json',
					nonce: cpdata.seguridad,
					tipo: 'add',
					idtable: idTable,
					nombres: nombres,
					apellidos: apellidos,
					email: email,
					media: imgVal
				}, success: function( data) {
					if( data.result ){
						$precargador.css('display', 'none');
						swal({
							title: 'Agregado',
							text:	'El usuario ' + nombres + ' ha sido agregado correctamente.',
							type: 'success',
							timer: 2000
						})
						console.log(data);
					} else {
						$precargador.css('display', 'none');
						swal({
							title: 'Error',
							text:	'Hubo un error intenta mas tarde',
							type: 'error',
							timer: 2000
						})

					}
				}, error: function( d,x,v ) {
					console.log(d);
					console.log(x);
					console.log(v);
				}
			})

		}
	 });
    

})( jQuery );