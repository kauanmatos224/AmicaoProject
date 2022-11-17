
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
			  rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="/style/estilomsg.css"/>
		<title>Amicão - Aviso</title>
		@include("./user_routesNavigation")
		<script>
			if(window.location.pathname!="/home" && window.location.pathname!="/"){
				parent.self.location='/home';
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
					<a href="/empresa" class="btn btn-outline-warning" id="empresa">Empresa</a>
					<a href="/login" class="btn btn-outline-secondary" id="adm">Administração</a>
					<button onclick="download()" class="btn btn-warning" id="downloadnav"><i class="fa fa-download"></i>    Baixar</button>
				</div>
			</nav>
		</header>
        <div id="div1" class="ex1">
            <div id="divctt">
                <span class="lnome">
                    <?php 

					$create_mail_element = false;
					$request_account_reactivation = false;
                        if(isset($info)){

                            switch($info){

                                case 'waiting':
                                    echo "Os dados da sua instituição ainda estão em análise.
                                    Aguarde nosso retorno na caixa de entrada do e-mail informado no pré-cadastro";
                                    break;
                                    
                                case 'denied':
                                    echo "A oficialização do cadastro da sua instituição foi reprovada.
                                    Cheque a caixa de entrada do e-mail informado no pré-cadastro da instituição para maiores infromações.";
                                    break;
								case 'changed_password':
									echo "Sua senha foi alterada com sucesso!";
									break;
								case 'forged_csrf':
									echo 'A sua requisição pode ter perdido dados ou foi forjada [CSRF error]';
									break;
								case 'email_non_verified':
									echo 'Antes de prosseguir com o acesso a sua conta, é necessário que realize a confirmação do seu e-mail através do e-mail em que enviamos';
									$create_mail_element = true;
									break;

								case 'verified_email':
									echo 'Seu e-mail foi verificado com sucesso!';
									break;

								case 'resent_confirmation_mail':
									echo 'Uma nova mensagem de verificação foi enviada para o seu e-mail';
									break;
								case 'exceded_confirmation_mail':
									echo 'A quantidade de envios foi excedida, você deve aguardar pelo menos 4 horas. Tente novamente mais tarde';
									break;

								case 'deleted_account_trying_access':
									echo 'Essa conta não pode ser mais acessada, pois foi movida para o processo de deleção que se concluirá 30 dias após a operação.
									Se você deseja recuperar o acesso a sua conta, entre em contato com a nossa Plataforma requisitando a reativação.
									
									*Quando concluido o processo de deleção, não será mais possível efetuar o processo de autenticação da conta.';
									$request_account_reactivation = true;
									break;
                            }		
                        }
                        
                    ?>
                </span>
                <br><br>

				<?php if($create_mail_element==true): ?>
				<form action="/account/resend_mail_check" method="post" id="frm_mail_resend">
					<input type="hidden" name="_token" value="{{{csrf_token()}}}">
					<input type="hidden" name="txtEmail" value="<?= $email ?>">
					<input class="btn btn-warning" type="submit" value="Não recebeu? Reenviar e-mail de verificação">
				</form>
				<?endif;?>


				<?php if($request_account_reactivation==true): ?>
				<form action="/contato/send-account-activation-request" method="post" id="frm_contact_account_activation_request">
					<input type="hidden" name="_token" value="{{{csrf_token()}}}">
					<input type="hidden" name="txtEmail" value="<?= $email ?>">
					<input class="btn btn-warning" type="submit" value="Requisitar a reativação da conta">
				</form>
				<?endif;?>


				<br>
                <form action="/home"><input class="btn btn-warning" id="btnenviar" type="submit" value="Ok"></form>
            </div>
        </div>
	</body>
</html>
