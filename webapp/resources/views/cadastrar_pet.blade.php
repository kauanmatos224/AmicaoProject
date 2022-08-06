<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="/style/estilocadastrar.css"/>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
		<title>Amicão - Admin</title>
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
					<a href="/login" class="btn btn-outline-secondary" id="adm">Administração</a>
					<button href="https://www.youtube.com/watch?v=rxCs1fGxloI" class="btn btn-warning" id="downloadnav"><i class="fa fa-download"></i>    Baixar</button>
				</div>
			</nav>
		</header>
		<div id = "div1">
        <form id="frmCad" method="post" action="/institucional/pets/cadastrar/add" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
			<span class="lFoto">Foto:</span><br><div id="divft"><input type="file" id="inpFoto" name="inpFoto" accept="image/*" ></div><br>
			<span class="lNome">Nome:</span><br><input class="nome" type=text name=txtNome><br><br>
			<span class="lIdade">Idade:</span><br><input class="idade" type=text name=txtIdade><br><br>
			<span class="lNascimento">Nascimento:</span><br><input class="nascimento" type=date name=txtNascimento><br><br>
			<span class="lRaça">Raça:</span><br><input class="raca" type=text name=txtRaca><br><br>
			<span>Gênero:</span><br>
			<select class = "genero" name="txtGenero">
	  			<option value="macho">Macho</option>
				<option value="femea">Fêmea</option>
			</select><br><br>
			<span>Status:</span><br>
			<select class = "status" name="txtStatus">
	  			<option value="disponivel">Disponível</option>
				<option value="apadrinhado">Apadrinhado</option>
				<option value="em_adocao">Em adoção</option>
			</select>
		</div>
		<div id = "div2">
			<span>Porte:</span><br>
			<select class = "porte" name="txtPorte">
	  			<option value="pequeno">Pequeno</option>
				<option value="medio">Médio</option>
				<option value="grande">Grande</option>
			</select><br><br>
			<span class="lRaçaP">Raça do pai:</span><br><input class="racap" type=text name=txtRacaP ><br><br>
			<span class="lRaçaM">Raça da mãe:</span><br><input class="racam" type=text name=txtRacaM><br><br>
			<span>Vacinas(essenciais):</span><br>
			<select class = "vacinas" name="txtVacinas">
	  			<option value="sim">Sim</option>
				<option value="nao">Não</option>
			</select><br><br>
			<span class="lSaude">Problemas de saúde (se houver):</span><br><textarea rows="5" id="saude" class="saude" type=text name=txtSaude></textarea><br><br>
			<input type="submit" class="btn btn-warning" id="cadastrar" value="Cadastrar">
            </form>
        </div>
	</body>
</html>