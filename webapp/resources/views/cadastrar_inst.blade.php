<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="/style/estiloCadInst.css" />
		<title>Amicão - Cadastro instituição</title>
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
					<a href="/empresa" class="btn btn-outline-warning" id="empresa">Empresa</a>
					<a href="/institucional" class="btn btn-outline-secondary" id="adm">Administração</a>
					<button onclick="download()" class="btn btn-warning" id="downloadnav"><i class="fa fa-download"></i>    Baixar</button>
				</div>
			</nav>
		</header>
		<?php $height="100%"; $height_int=100; if(isset($errors)){ 

			foreach($errors->all() as $error){
				$height_int+=5;
			}
			if($height_int>20){
				$height = strval($height_int)."%";
			}

		}?>
		<div id="whole-page-without-menu">
        <form id="frmCadInst" method="post" action="/institucional/cadastrar/send">
        	
			<div id="div1" style="height:<?=$height?>;">
				<div id="input_set1">
                <input type="hidden" name="_token" value="{{{csrf_token()}}}">
                <span class="lNomeF">Nome Fantasia:</span><br><input class="nomef" type=text name=txtFantasyName placeholder="Nome Fantasia" value="{{{ old('txtFantasyName')}}}"><br><br>
                <span class="lCnpj">CNPJ:</span><br><input class="cnpj" type=text name=txtCnpj placeholder="CNPJ" value="{{{ old('txtCnpj')}}}"><br><br>
                <span class="lEndereco">Endereço: (Rua, N° - Cidade, Estado - Páis)</span><br><input class="endereco" type=text name=txtAddress placeholder="Rua / Avenida, N°, Cidade - Estado" value="{{{ old('txtAddress')}}}"><br><br>
                <span class="lComplemento">Complemento (se houver):</span><br><input class="complemento" type=text name=txtComplement placeholder="Complemento (se houver)" value="{{{ old('txtComplement')}}}"><br><br>
                <span class="lCep">Código Postal:</span><br><input class="cep" type=text name=txtCep placeholder="CEP" value="{{{ old('txtCep')}}}"><br><br>
                <span class="lpais">País:</span><br><input class="pais" type=text name=txtCountry placeholder="País" value="{{{ old('txtCountry')}}}"><br><br>
				</div>
        		</div>

            	<div id="div2" style="height:<?=$height?>;">
				<div id="input_set2">
                <span class="lTel">Telefone:</span><br><input class="tel" type=text name=txtPhone placeholder="Telefone" value="{{{ old('txtPhone')}}}"><br><br>
                <span class="lEmail">E-mail:</span><br><input class="email" type=text name=txtEmail placeholder="E-mail" value="{{{ old('txtEmail')}}}"><br><br>
                <span class="lSenha">Senha (min. 8 caracteres):</span><br><input class="senha" type=password name=txtPassword placeholder="Senha"><br><br>
                <span class="lConSenha">Confirmar senha:</span><br><input class="csenha" type=password name=txtConfPassword placeholder="Confirmar senha"><br><br>
                <input type="submit" id="btnSend" class="btn btn-outline-warning" value="Requisitar Cadastro">
				<?php if(isset($errors)){
						echo "<ul id=\"errors\">";
						foreach($errors->all() as $error){
							echo "<li>$error</li>";
						}
						echo "</ul>";
					} 
					?>
				</div>
        		</div>
        	
        </form>
		</div>  
    </body>
</html>