<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="/style/estiloadm.css"/>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
		
		<title>Amicão - Aviso</title>
		@include("./user_routesNavigation")
		<script>
			function download(){
				window.location.href="/download/app";
			}
		</script>
	</head>
	<body onload="setDate()">
		<header id = cab>
			<nav id="nav" class="navbar fixed-top navbar-expand-sm bg-dark navbar-dark">
				<div class="container-fluid">
					<a class="navbar-brand" href="home">
						<img src="/style/img/amicao_logo.png" style="width:40px;" class="square-pill"> 	
				  	</a>
				  	<a href="/contato" class="btn btn-outline-warning" id="contato">Contato</a>
					<a href="/empresa" class="btn btn-outline-warning" id="empresa">Sobre nós</a>
					<a href="/institucional" class="btn btn-outline-secondary" id="adm">Administração</a>
					<button onclick="download()" class="btn btn-warning" id="downloadnav"><i class="fa fa-download"></i>    Baixar</button>
				</div>
			</nav>
		</header>
        <h1>A análise cadastral da sua instituição ainda não foi finalizada.
            Aguarde pelo nosso retorno na caixa de e-mail informada durante o cadastro
        </h1>

    </body>
<html>