<?php
	if (empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["phone"]) || empty($_POST["message"]) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
		http_response_code(500);
		exit();
	}
	$name = strip_tags(htmlspecialchars($_POST["name"]));
	$email = strip_tags(htmlspecialchars($_POST["email"]));
	$phone = strip_tags(htmlspecialchars($_POST["phone"]));
	$message = strip_tags(htmlspecialchars($_POST["message"]));
	$to = "gpea@gpea.com";
	$subject = "Formulário de contato do site: $name";
	$body = "Você recebeu uma nova mensagem do formulário de contato do seu site.\n\n" . "Aqui estão os detalhes:\n\nNome: $name\n\nE-mail: $email\n\nTelefone: $phone\n\nMensagem:\n$message";
	$header = "From: naoresponder@gpea.com\n";
	$header .= "Reply-To: $email";
	if (!mail($to, $subject, $body, $header)) {
		http_response_code(500);
	}