<?php 

	
	$mensaje = [];
	$errores = 0;


	function validar_fecha($fecha) {

		// Vamos a utilizar explode para separar por el / lo que se inserte en el input
		$fecha = explode('/', $fecha);

		// explode devuelve un array, si cuenta más de tres o menos de tres indices no es valido
		if(count($fecha) !== 3) return false;  

		// Pero si cumple la condicion:
		return checkdate($fecha[1], $fecha[0], $fecha[2]);
	}

	// Nombre
	if(empty($_POST['nombre'])) {
		$mensaje['nombre']  = 'El nombre no debe estar vacío';
		$errores++;
	} 
	else if(strlen($_POST['nombre']) < 3 ) {
		$mensaje['nombre']  = 'El nombre debe tener al menos 3 caracteres';
		$errores++;
	}


	// Correo
	if(empty($_POST['correo'])) {
		$mensaje['correo']  = 'El correo no debe estar vacío';
		$errores++;
	} 
	// filter_var devuelve true o false
	else if(!filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
		$mensaje['correo']  = 'Debe ingresar un correo válido';
		$errores++;
	}



	// Fecha (haremos una funcion para validar y utilizaremos checkdate)
	// Primero validamos que no esté vacio
	if(!empty($_POST['fecha'])) {
		// Ahora que cumpla la funcion
		if(!validar_fecha($_POST['fecha'])) {
			$mensaje['fecha'] = 'La fecha debe ser válida';
			$errores++;
		}

	}


	// Para el check de terminos
	if(empty($_POST['terminos'])) {
		$mensaje['terminos']  = 'Debe aceptar los términos';
		$errores++;
	}


	// Entonces validamos si existen errores...
	if($errores > 0) {
		echo json_encode(['status' => true, 'validaciones' => $mensaje]);
	}	else{ 
		echo json_encode(['status' => false]);
	}