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
		$nombres = $('#nombres'),
		$apellidos = $('#apellidos'),
		$email = $('#email'),
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

	function addUserTable(id, nombres, apellidos, email, media){

		var output = "<tr data-item='"+id+"'>\
		<td data-item='"+id+"'>\
		<img class='cp-media' src='"+media+"' alt='"+nombres+" "+apellidos+"'>\
	</td>\
	<td>"+nombres+"</td>\
	<td>"+apellidos+"</td>\
	<td>"+email+"</td>\
	<td>\
		<span data-edit='"+id+"' class='btn btn-floating waves-effect waves-light'>\
			<i class='tiny material-icons'>mode_edit</i>\
		</span>\
	</td>\
	<td>\
		<span data-remove='"+id+"' class='btn btn-floating waves-effect waves-light red darken-1'>\
			<i class='tiny material-icons'>close</i>\
		</span>\
	</td>\
	</tr>";

	$('table tbody').append(output);

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
		selectimgval.val('');
		marcoimg.attr('src', '');
		$nombres.val('');
		$apellidos.val('');
		$email.val('');
		$('.formuData label').removeClass('active');
		$('#addUpdate h4').text('Agregar usuario');
		$('#actualizar').css('display', 'none');
		$('#agregar').css('display', 'block');
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

		var nombres = $nombres.val(),
			apellidos = $apellidos.val(),
			email = $email.val(),
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
						setTimeout( function(){
							$('#addUpdate').modal('close');
							addUserTable(data.insert_id, nombres, apellidos, email, imgVal);
						},2300);
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

	 $(document).on('click', '[data-edit]', function(){
		$('#addUpdate h4').text('Editar usuario');
		$('#actualizar').css('display', 'block');
		$('#agregar').css('display', 'none');
		$('#addUpdate').modal('open');

		var $this = $(this),
			$id = $this.attr('data-edit'),
			tr = $this.parent().parent(),
			td1 = tr.find( $('td:nth-child(1) img') ),
			td2 = tr.find( $('td:nth-child(2)') ),
			td3 = tr.find( $('td:nth-child(3)') ),
			td4 = tr.find( $('td:nth-child(4)') ),
			src = td1.attr('src');

			$('.formuData label').addClass('active');

			selectimgval.val(src);
			marcoimg.attr('src', src);
			$nombres.val(td2.text());
			$apellidos.val(td3.text());
			$email.val(td4.text());

			$('#actualizar').attr('data-id', $id);


	 });

	 $(document).on('click', '#actualizar', function(){
		var $this = $(this),
		id = $this.attr('data-id'),
		tr = $('tr[data-item="'+id+'"]'),
		td1 = tr.find( $('td:nth-child(1) img') ),
		td2 = tr.find( $('td:nth-child(2)') ),
		td3 = tr.find( $('td:nth-child(3)') ),
		td4 = tr.find( $('td:nth-child(4)') ),
		nombres = $nombres.val(),
		apellidos = $apellidos.val(),
		email = $email.val(),
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
						tipo: 'update',
						iduser: id,
						idtable: idTable,
						nombres: nombres,
						apellidos: apellidos,
						email: email,
						media: imgVal
					}, success: function( data) {
						if( data.result ){
							$precargador.css('display', 'none');
							swal({
								title: 'Actualizado',
								text:	'El usuario ' + nombres + ' ha actualizado correctamente.',
								type: 'success',
								timer: 2000
							})
							setTimeout( function(){
								$('#addUpdate').modal('close');
								tr.addClass('bg-animado');
								td1.attr('src', imgVal);
								td2.text(nombres);
								td3.text(apellidos);
								td4.text(email);
							},2300);

							setTimeout( function(){
								tr.removeClass('bg-animado');
							}, 1500);
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

	
	 $(document).on('click', '[data-remove]', function(){

		var $this = $(this),
		id = $this.attr('data-remove'),
		$tr = $('tr[data-item="'+id+'"]'),
		nombres = $tr.find( $('td:nth-child(2)') ).text();

		console.log(id);
		console.log($tr);

		swal({
			title: "¿Estas seguro que quieres eliminar a '"+nombres+"'?",
			text: "no podras desacer esto!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Si, borralo",
			closeOnConfirm: false,
			showLoaderOnConfirm: true,
			html: true
		}, function(isConfirm){
			if(isConfirm){

				$.ajax({
					url:cpdata.url,
					type:'POST',
					dataType: 'json',
					data: {
						action: 'cp_crud_json',
						nonce: cpdata.seguridad,
						tipo: 'delete',
						iduser: id,
						idtable: idTable
					}, success: function( data) {
						if( data.result ){
							$precargador.css('display', 'none');
							
							setTimeout(function(){
								swal({
									title: "Borrado",
									text: "el usuario "+nombres+" a sido eliminado.",
									type: "success",
									timer: 1500
								});

								$tr.css({
									"background": "red",
									"color": "white",
								}).fadeOut(600);

								setTimeout( function(){
									$tr.remove();
								}, 1000);
							}, 1500);



						} else {
							$precargador.css('display', 'none');
							swal({
								title: 'Error',
								text:	'Hubo un error al eliminar el usuario, por favor intenta mas tarde',
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

				
				

			} else {



			}
		});

	 });

    

})( jQuery );