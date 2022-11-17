<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
			  rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="/style/contato.css"/>
		<title>Amicão - Contato</title>
		@include("./user_routesNavigation")
		<script>
			function download(){
				window.location.href="/download/app";
			}
		</script>
	</head>
	<body id = "grid">
		<header id = cab>
			<nav id="nav" class="navbar fixed-top navbar-expand-sm bg-dark navbar-dark">
				<div class="container-fluid">
					<a class="navbar-brand" href="/home">
						<img src="/style/img/amicao_logo.png" style="width:40px;" class="square-pill"> 	
				  	</a>
				  	<a href="/contato" class="btn btn-outline-warning" id="contato">Contato</a>
					<a href="/empresa" class="btn btn-outline-warning" id="empresa">Sobre nós</a>
					<a href="/institucional" class="btn btn-outline-secondary" id="adm">Administração</a>
					<button onclick="download()" class="btn btn-warning" id="downloadnav"><i class="fa fa-download"></i>    Baixar</button>
				</div>
			</nav>
			
		</header>

		<?php $message=null;
			  $send_account_activation_request=false;
			if(isset($info)){
				if($info=='account_activation_request'){
					$message = "Olá, estou entrando em contato para requisitar a reativação da minha conta, cuja do seguinte e-mail: $email";
					$send_account_activation_request=true;
				}
			}

		?>

        <div id="div1" class="ex1">
            <div id="divctt">
				<form id="frmContato" method="post" action="/contato/send">
					<input type="hidden" name="_token" value="{{{ csrf_token()}}}">
                	<span class="lnome">Nome completo:</span><br><input class="nome" type=text name=txtnome placeholder="Seu nome e sobrenomes">
                	<br><br>
                	<span class="lemail">Email para contato:</span><br><input class="email" type=email name=txtemail placeholder="email@domínio.com" value="<?= $send_account_activation_request==true? $email : null?>">
                	<br><br>
                	<span class="lmsg">Digite sua mensagem:</span><br><textarea rows="5" class="msg" type=text name=txtmsg placeholder="Mensagem..."><?= $send_account_activation_request==true? $message : ''?></textarea>
                	<br><br>
            	    <input class="btn btn-warning" id="btnenviar" type="submit" value="Enviar">
				</form>

				<p>* Após o envio desta mensagem, em breve você receberá uma mensagem no e-mail da conta, pedindo sua confirmação para completar a ativação da conta.</p>
            </div>
        </div>
	</body>
</html>