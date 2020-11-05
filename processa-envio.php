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
		die(); # para a aplicação, tudo a seguir será descartado
	}

	$mail = new PHPMailer(true);

	try {
	    //Server settings
	    $mail->SMTPDebug = 2; // Enable verbose debug output
	    $mail->isSMTP();  // Send using SMTP
	    $mail->Host = 'smtp.gmail.com';  // Set the SMTP server to send through
	    $mail->SMTPAuth = true; // Enable SMTP authentication
	    $mail->Username = 'cursowebteste80@gmail.com'; // SMTP username
	    $mail->Password = '!@#$1234'; // SMTP password
	    $mail->SMTPSecure = 'tls'; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
	    $mail->Port = 587; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

	    //Recipients
	    $mail->setFrom('cursowebteste80@gmail.com', 'Teste curso web remetente');
	    $mail->addAddress('cursowebteste80@gmail.com', 'Teste curso web destinatário'); // Add a recipient
	    // $mail->addAddress('ellen@example.com'); // Name is optional
	    // $mail->addReplyTo('info@example.com', 'Information');
	    // $mail->addCC('cc@example.com');
	    // $mail->addBCC('bcc@example.com');

	    // Attachments
	    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

	    // Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = 'Assunto do Email';
	    $mail->Body = 'Conteúdo do <strong>e-mail</strong>';
	    $mail->AltBody = 'Conteúdo do e-mail';

	    $mail->send();
	    echo 'Message has been sent';
	}
	catch (Exception $e) {
	    echo 'Não foi possível enviar esse e-mail </br>'; 
	    echo 'Detalhes do erro: ' . $mail->ErrorInfo;
	}

?>