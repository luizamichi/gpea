<?php
/* SQL INJECTION PREVENT */
function anti_sql_injection(string $search) {
	$search = strip_tags($search);
	$search = trim($search);
	$search = addslashes($search);
	return $search;
}

/* CONVERT ARRAY TO OBJECT */
function array_to_obj(array $array) {
	return (object) $array;
}

/* REPORT ERRORS, WARNINGS AND EXCEPTIONS */
function error_report() {
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
}

/* LOADS ALL PERSONAL DATA FROM THE TEACHER */
function load_all_data() {
	$id = request_values()['teacher'] ?? 0;
	$query = sql('select username, nome, departamento, rt from aaUserSPA_BK where id=' . $id . ';');
	$general_information = typing_values($query);

	$user = $general_information[0]['username'] ?? null;
	$query = sql('select codigo, nome, curso, chsemanal, chtotal, inicio, termino from ensino where usuario_id="' . $user . '";');
	$teaching_charges = typing_values($query);

	foreach($teaching_charges as $key => $tc) {
		$time = sql('select dia, horainicio, horafim from horario where codigo="' . $tc['codigo'] . '";');
		$teaching_charges[$key]['horarios'] = typing_values($time);
	}

	$query = sql('select orientando, modalidade, inicio, termino, chsemanal from orientacao where usuario_id="' . $user . '";');
	$guidance_charges = typing_values($query);

	$query = sql('select processo, titulo, modalidade, inicio, termino, chsemanal from projeto where usuario_id="' . $user . '";');
	$project_charges = typing_values($query);

	$query = sql('select processo, descricao, natureza, inicio, termino, chsemanal from funcao where usuario_id="' . $user . '";');
	$function_charges = typing_values($query);

	return ['general_information' => $general_information, 'teaching_charges' => $teaching_charges, 'guidance_charges' => $guidance_charges, 'project_charges' => $project_charges, 'function_charges' => $function_charges];
}

/* REQUISITION METHOD */
function request_method() {
	return $_SERVER['REQUEST_METHOD'];
}

/* REQUISITION PARAMETERS */
function request_parameters() {
	$parameters = [];
	foreach($_REQUEST as $request => $_)
		array_push($parameters, $request);
	return $parameters;
}

/* REQUISITION VALUES */
function request_values() {
	return typing_values($_REQUEST);
}

/* SEARCH TEACHERS FOR TABLE */
function set_up_table() {
	$name = request_values()['name'] ?? '';
	$name = anti_sql_injection($name);
	$query = sql('select id, nome from aaUserSPA_BK where nome like concat("%' . $name . '%");');
	return typing_values($query);
}

/* MYSQL QUERY */
function sql(string $query) {
	$mysql = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB);
	if($mysql->connect_errno)
		exit();

	$request = $mysql->query($query);
	$data = [];

	while($row = $request->fetch_assoc())
		array_push($data, $row);

	return $data;
}

/* TYPING VALUES PRIMITIVELY */
function typing_values(array $request) {
	foreach($request as $key => $value) {
		if(is_array($value)) // ARRAY
			$modification = typing_values($request[$key]);

		elseif(in_array($value, ['true', 'false'])) // BOOLEAN
			$modification = (bool) $value;

		elseif(is_numeric($value) && is_int((int) $value)) // INTEGER
			$modification = (int) $value;

		elseif(is_numeric($value)) // FLOATING POINT
			$modification = (float) $value;

		elseif(is_string($value) && strlen($value) >= 10 && checkdate((int) substr($value, 5, 2), (int) substr($value, 8, 2), (int) substr($value, 0, 4))) { // DATE
			$date = date_create($value);
			$modification = date_format($date, 'd/m/Y');
		}

		elseif(is_string($value)) // STRING
			$modification = utf8_encode(trim($value));

		$request[$key] = $modification; // TYPE OF VALUE OR NULL
	}
	return $request;
}