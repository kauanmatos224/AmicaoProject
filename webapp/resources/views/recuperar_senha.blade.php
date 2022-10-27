<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
			  rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="/style/estiloA.css"/>
		<title>Amicão - Recuperar senha</title>
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
                    <button class="btn btn-warning" id="downloadnav"><i class="fa fa-download"></i>    Baixar</button>
                </div>
            </nav>
        </header>

        <div id="div1">
            <br><br><br>
            <h2>Digite seu e-mail para receber um link de recuperação.</h2><br>
            <form name="frmRecPassword" method="post" action="/institucional/recuperar-senha/send">
                <input type="hidden" name="_token" value="{{{csrf_token()}}}">
                <span class="lEmail">E-mail:</span><br><input class="email" type=email name=txtEmail placeholder="E-mail"><br><br>
                <br>
                <input type="submit" class="btn btn-outline-warning" id="btnEnviar" value="Enviar">
            </form>
        </div>

        <?php 
            if(isset($error)){
                if($error="not_matched_mail"){
                    echo <<<END
                        <div class="alert altert-danger">
                            <span>O e-mail informado não possui nenhum vínculo com a plataforma</span>
                        </div>
                    END;
                }
            }
        ?>
    </body>
</html>