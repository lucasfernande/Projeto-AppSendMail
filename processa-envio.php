<?php  
		
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

	if ($msg->msgValida()) {
		echo 'Mensagem válida - teste';
	}
	else {
		echo 'Mensagem inválida - teste';
	}

?>