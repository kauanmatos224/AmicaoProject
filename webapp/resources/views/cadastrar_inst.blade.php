<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
			  rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" />
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
					<a href="/institucional" class="btn btn-outline-secondary" id="adm">Administração</a>
					<button class="btn btn-warning" id="downloadnav"><i class="fa fa-download"></i>    Baixar</button>
				</div>
			</nav>
		</header>


        <form id="frmCadInst" method="post" action="/institucional/cadastrar/send">
            <input type="hidden" name="_token" value="{{{csrf_token()}}}">
            <br>
            <br>
            <br>
            <br>
            <br>
            Nome Fantasia:<input type="text" name="txtFantasyName">
            <br>
            CNPJ:<input type="text" name="txtCnpj">
            <br>
            Endereço:<input type="text" name="txtAddress" placeholder="Rua / Avenida, N°, Cidade - Estado">
            <br>
            Complemento (se houver):<input type="text" name="txtComplement">
            <br>
            CEP:<input type="text" name="txtCep">
            <br>
            País:<input type="text" name="txtCountry">
            <br>
            Telefone:<input type="text" name="txtPhone">
            <br>
            E-mail:<input type="email" name="txtEmail">
            <br>
            Senha:<input type="password" name="txtPassword">
            <br>
            Confirmar senha:<input type="password" name="txtConfPassword">
            <br>
            <input type="submit" id="btnSend" value="Requisitar Cadastro">
            
        </form>






    </body>
</html>