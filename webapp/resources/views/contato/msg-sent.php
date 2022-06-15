<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
			  rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="style/estilohome.css"/>
		<title>Amicão - Home</title>
	</head>
	<body id = "grid">
		<header id = cab>
			<nav id="nav" class="navbar fixed-top navbar-expand-sm bg-dark navbar-dark">
				<div class="container-fluid">
					<a class="navbar-brand" href="home.html">
						<img src="style/img/amicao_logo.png" style="width:40px;" class="square-pill"> 	
				  	</a>
				  	<a href="/contato" class="btn btn-outline-warning" id="contato">Contato</a>
					<a href="/empresa" class="btn btn-outline-warning" id="empresa">Empresa</a>
					<a href="/institucional" class="btn btn-outline-secondary" id="adm">Administração</a>
					<button class="btn btn-warning" id="downloadnav" href="" ><i class="fa fa-download"></i>    Baixar</button>
				</div>
			</nav>
		</header>

        <?php if(isset($status)): ?>
            <?php if($status=="sucess"): ?>
                <div class="alert alert-sucess">
                    <p>Messagem enviada com sucesso, aguarde até entrarmos em contato</p>
                </div>
            <?php else: ?>
                <div class="alert alert-danger">
                    <p>Ocorreu um erro ao tentar enviar a sua mensagem, por favor tente mais tarde :(</p>
                </div>
            <?php endif ?>
        <?php endif ?>


    </body>

</html>