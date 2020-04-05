<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Validación de formulario mediante AJAX</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/waitMe/waitMe.min.css">
</head>
<body>

	<div class="container mt-5">
		<div class="row">
			<div class="col">
				<h1 class="text-center">Validación de formulario mediante AJAX</h1>

				<form id="form_ajax" action="procesa.php" method="POST">
					<div class="form-group">
						<label for="nombre" class="col-form-label">Nombre:</label>
						<input type="text" name="nombre" class="form-control">
						<span data-key="nombre" class="badge badge-danger"></span>
					</div>

					<div class="form-group">
						<label for="correo" class="col-form-label">Correo:</label>
						<input type="text" name="correo" class="form-control">
						<span  data-key="correo" class="badge badge-danger"></span>
					</div>

					<div class="form-group">
						<label for="fecha" class="col-form-label">Fecha de nacimiento:</label>
						<input type="text" name="fecha" class="form-control">
						<span data-key="fecha" class="badge badge-danger"></span>
					</div>

					<div class="form-group">
						<div class="form-check">
							<input type="checkbox" name="terminos" value="1" class="form-check-input">
							<label for="terminos" class="col-check-label">Acepto los términos</label>
						</div>
						<span data-key="terminos" class="badge badge-danger"></span>
					</div>

					<div class="form-group">
						<button class="btn btn-primary btn_aceptar">Aceptar</button>
					</div>
				</form>
			</div>
		</div>
	</div>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>	
<script src="assets/waitMe/waitMe.min.js"></script>
<script>
	$(document).ready(function() {

		$('.btn_aceptar').on('click', function(ebtn){
			ebtn.preventDefault();
			var datos_form = $('#form_ajax').serialize();

			$.ajax({
				url    : 'procesa.php',
				method : 'POST',
				data   : datos_form,
				cache  : false,
				success: function(r) {

					// Voy a buscar la clase badge-danger para que en la proxima vez que se haga submit me deje vacio el span
					$('#form_ajax').find('.badge-danger').text('');
					if(r.status) {
						//Utilizaremos waitMe para lo siguiente: 
						$('#form_ajax').waitMe({
							effect  : 'ios',
							waitTime: 400,
							onClose : function(){
								// Como los mensajes tenemos en un array, lo vamos a loopear
								for(var k in r.validaciones) {
									$("span[data-key='" + k + "' ]").text(r.validaciones[k]);
								}
							}
						})
					} else {
						$('#form_ajax').waitMe({
							effect  : 'ios',
							waitTime: 1500,
							onClose : function(){
								window.location.href = 'bienvenido.php';
							}
						})

					}
				},
				dataType: 'json'
			});

			return false;
		});

	});
</script>
</body>
</html>