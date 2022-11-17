<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
			  rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/style/estiloConta.css"/>
        <title>Minha Conta =D</title>
        @include("./user_routesNavigation")
        <script>
			if(window.location.pathname!="/home" && window.location.pathname!="/"){
				parent.self.location='/home';
			}
		</script>
    </head>

    <body>
        <header id = cab>
			<nav id="nav" class="navbar fixed-top navbar-expand-sm bg-dark navbar-dark">
				<div class="container-fluid">
					<a class="navbar-brand" href="/home">
						<img src="/style/img/amicao_logo.png" style="width:40px;" class="square-pill"> 	
				  	</a>
				  	<a href="/contato" class="btn btn-outline-warning" id="contato">Contato</a>
					<a href="/empresa" class="btn btn-outline-warning" id="empresa">Empresa</a>
					<a href="/institucional" class="btn btn-outline-secondary" id="adm">Administração</a>
					<button onclick="download()" class="btn btn-warning" id="downloadnav" ><i class="fa fa-download"></i>    Baixar</button>
				</div>
			</nav>
		</header>

        <?php switch(session('user_account')){
            case 'changed_password';
                echo '<p>Sua senha foi alterada com sucesso!</p>';
                break;

            case 'wrong_conf_password':
                echo '<p>A senha e sua confirmação não conferem!</p>';
                break;
            case 'sent_mail_conf_changing':
                echo '<p>Uma mensagem de confirmação foi enviada para o e-mail informado.
                Realize a verificação para poder utilizar o novo e-mail quando estiver realizando Login</p>';
                break;

            case 'used_mail_by_other':
                echo '<p>Esse e-mail já está vinculado à outra instituição</p>';
                break;
            case 'used_mail_by_user':
                echo '<p>Esse e-mail é o mesmo atual de sua conta</p>';
                break;
        }

        session(['user_account' => '']);    

        ?>


        <div id="div1">
            <h2>Alteração de Senha:</h2>
            <form method="post" action="/institucional/change-password/set-new">
                <input type="hidden" name="_token" value="{{{csrf_token()}}}">
                <span class="lSenha">Senha:</span><br><input class="senha" type=password name=txtPassword placeholder="Senha"><br><br>
                <span class="lConSenha">Confirmar senha:</span><br><input class="csenha" type=password name=txtPasswordConfirmation placeholder="Confirmar senha"><br><br>
                <input type="submit" class="btn btn-warning" id="btnSenha" value="Alterar senha">
            </form>
            <br>
            <br>
        </div>

        <div id="div2">
        <h2>Alteração de E-mail:</h2>
            <form method="post" action="/institucional/change-mail/set-new">
                <input type="hidden" name="_token" value="{{{csrf_token()}}}">
                <span class="lEmail">E-mail:</span><br><input class="email" type=text name=txtEmail placeholder="E-mail"><br><br>
                <input type="submit" class="btn btn-warning" id="btnEmail" value="Alterar email">
            </form>
        </div>
    </body>
</html>