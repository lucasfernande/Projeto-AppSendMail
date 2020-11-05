<?php  
		
	# importanto o PHPMailer
    require 'bibliotecas/PHPMailer/Exception.php';
    require 'bibliotecas/PHPMailer/OAuth.php';
    require 'bibliotecas/PHPMailer/PHPMailer.php';
    require 'bibliotecas/PHPMailer/POP3.php';
    require 'bibliotecas/PHPMailer/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	class Mensagem {
		private $para = null;
		private $assunto = null;
		private $msg = null;
		public $status = array('codStatus' => null, 'descricaoStatus' => '');

		public function __construct($para, $assunto, $msg) {
			$this->para = $para;
			$this->assunto = $assunto;
			$this->msg = $msg; 
		}

		public function __get($attr) {
			return $this->$attr;
		}

		public function __set($attr, $valor) {
			$this->$attr = $valor;
		}

		public function msgValida() {

			# verificando se existe um campo vazio
			if (empty($this->para) || empty($this->assunto) || empty($this->msg)) {
				return false;
			}

			return true;
		}
	}	

	$msg = new Mensagem($_POST['para'], $_POST['assunto'], $_POST['msg']);

	if (!$msg->msgValida()) {
		echo 'Mensagem inválida - teste';
		header('Location: index.php');
	}

	$mail = new PHPMailer(true);

	try {
	    //Server settings
	    $mail->SMTPDebug = false; // Enable verbose debug output
	    $mail->isSMTP();  // Send using SMTP
	    $mail->Host = 'smtp.gmail.com';  // Set the SMTP server to send through
	    $mail->SMTPAuth = true; // Enable SMTP authentication
	    $mail->Username = 'cursowebteste80@gmail.com'; // SMTP username
	    $mail->Password = '!@#$1234'; // SMTP password
	    $mail->SMTPSecure = 'tls'; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
	    $mail->Port = 587; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

	    //Recipients
	    $mail->setFrom('cursowebteste80@gmail.com', 'Teste curso web remetente');
	    $mail->addAddress($msg->__get('para')); // Add a recipient
	    // $mail->addAddress('ellen@example.com'); // Name is optional
	    // $mail->addReplyTo('info@example.com', 'Information');
	    // $mail->addCC('cc@example.com');
	    // $mail->addBCC('bcc@example.com');

	    // Attachments
	    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

	    // Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = $msg->__get('assunto');
	    $mail->Body = $msg->__get('msg');
	    $mail->AltBody = 'É necessário usar um client que suporte HTML para ver toda a mensagem';

	    $mail->send();

	    $msg->status['codStatus'] = 1;
	    $msg->status['descricaoStatus'] = 'E-mail enviado com sucesso';
	}
	catch (Exception $e) {
		$msg->status['codStatus'] = 0;
	    $msg->status['descricaoStatus'] = 'Não foi possível enviar esse e-mail </br> Detalhes do erro: ' . $mail->ErrorInfo;
	}

?>

<html>
	<head>
		<title>App Send Mail</title>
		<meta charset="utf-8"/>
    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	</head>
	<body>

		<div class="container">			
			<div class="py-3 text-center">
				<img class="d-block mx-auto mb-2" src="logo.png" alt="" width="72" height="72">
				<h2>Send Mail</h2>
				<p class="lead">Seu app de envio de e-mails particular!</p>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				
				<? if ($msg->status['codStatus'] == 1) { ?>

					<div class="container">
						<h1 class="display-4 text-success">Sucesso</h1>
						<p class="lead"> <?= $msg->status['descricaoStatus']?> </p>
						<a href="index.php" class="btn btn-success btn-lg mt-2 text-white">Voltar</a>
					</div>

				<? } ?>	

				<? if ($msg->status['codStatus'] == 0) { ?>

					<div class="container">
						<h1 class="display-4 text-danger">Ops!</h1>
						<p class="lead"> <?= $msg->status['descricaoStatus']?> </p>
						<a href="index.php" class="btn btn-danger btn-lg mt-2 text-white">Voltar</a>
					</div>

				<? } ?>	
					
			</div>
		</div>

	</body>
</html>