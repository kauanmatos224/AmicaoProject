<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
			  rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/style/estiloInstitucional.css"/>
        <title>Amicao - Institucional</title>
    </head>

	<?php 
		@include ("user_routesNavigation");
	?>
		
	
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
					<button class="btn btn-warning" id="downloadnav" href="" ><i class="fa fa-download"></i>    Baixar</button>
				</div>
			</nav>
		</header>
		<?php if(isset($user_type)):
				if($user_type=="inst"):?>
					<div id="div1" class="ex1">
						<a href="/institucional/pets" class="btn btn-secondary" id="pet">Pets</a>
					</div>

					<div id="div2" class="ex2">
						<a href="/institucional/requisicoes" class="btn btn-secondary" id="req">Requisicoes</a>
					</div>
					
					<div id="div4" class="ex4">
						<a href="" class="btn btn-secondary" id="logout">Logout</a>
					</div>

					<div id="div5" class="ex5">
						<a href="/institucional/myaccount" class="btn btn-secondary" id="conta">Conta</a>
					</div>

		<?php endif;
			endif;
		?>


		<?php if(isset($user_type)):
			if($user_type=="staff"):?>
				<div id="div3" class="ex3">
					<a href="/staff/messages" class="btn btn-warning" id="msg">Mensagens</a>
				</div>  

				<div id="div3" class="ex3">
					<a href="/staff/inst-analise" class="btn btn-warning" id="msg">Análise de Cadastros</a>
				</div>  

		<?php endif;
			endif;
		?>
    </body>
</html>