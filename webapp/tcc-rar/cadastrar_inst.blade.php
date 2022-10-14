<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="style/estiloC.css" />
		<title>Amicão - Cadastro instituição</title>
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

        <div id="div1">
            <form id="frmCadInst" method="post" action="/institucional/cadastrar/send">
                <input type="hidden" name="_token" value="{{{csrf_token()}}}">
                <span class="lNomeF">Nome Fantasia:</span><br><input class="nomef" type=text name=txtnomef placeholder="Nome Fantasia"><br><br>
                <span class="lCnpj">CNPJ:</span><br><input class="cnpj" type=text name=txtcnpj placeholder="CNPJ"><br><br>
                <span class="lEndereco">Endereço:</span><br><input class="endereco" type=text name=txtnend placeholder="Rua / Avenida, N°, Cidade - Estado"><br><br>
                <span class="lComplemento">Complemento (se houver):</span><br><input class="complemento" type=text name=txtcomp placeholder="Complemento (se houver)"><br><br>
                <span class="lCep">CEP:</span><br><input class="cep" type=text name=txtcep placeholder="CEP"><br><br>
                <span class="lpais">País:</span><br><input class="pais" type=text name=txtpais placeholder="País"><br><br>
        </div>
            <div id="div2">
                <span class="lTel">Telefone:</span><br><input class="tel" type=text name=txttel placeholder="Telefone"><br><br>
                <span class="lEmail">E-mail:</span><br><input class="email" type=text name=txtemail placeholder="E-mail"><br><br>
                <span class="lSenha">Senha:</span><br><input class="senha" type=password name=txtsenha placeholder="Senha"><br><br>
                <span class="lConSenha">Confirmar senha:</span><br><input class="csenha" type=password name=txtcSenha placeholder="Confirmar senha"><br><br>
                <!--<input type="submit" id="btnSend" value="Requisitar Cadastro">-->
                <a href="" class="btn btn-outline-warning" id="cadastrar">Cadastrar</a>
            </form>
        </div>
    </body>
</html>