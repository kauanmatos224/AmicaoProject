<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
			  rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="/style/estilologin.css"/>
		<title>Amicão</title>
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
					<button class="btn btn-warning" id="downloadnav"><i class="fa fa-download"></i>    Baixar</button>
				</div>
			</nav>
		</header>

        <div id="div1" class="ex1">
            <div id="divctt">
                <form id="frmLogin" method="post" action="/login/do_auth">
                    <input type="hidden" name="_token" value="{{{ csrf_token()}}}">
                    <span class="lemail">Email:</span><br><input class="email" type="text" name=txtEmail placeholder="email@domínio.com">
                    <br><br>
                    <span class="lmsg">Senha:</span><br><input class="senha" type="password" name=txtPassword>
                    <br><br>
                    <a href="" class="btn btn-secondary" id="adm">Recuperar Senha</a>
                    <a href="" class="btn btn-secondary" id="adm">Realizar Cadastro</a><br><br>
                    <input class="btn btn-warning" id="btnenviar" type="submit" value="Entrar" href="">
                </form>
            </div>
        </div>
	</body>
</html>