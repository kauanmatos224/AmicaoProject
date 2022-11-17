<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/style/estilo404.css" />
        <title>ERROR - 404</title>
        <script>
			function download(){
				window.location.href="/download/app";
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
                    <a href="/empresa" class="btn btn-outline-warning" id="empresa">Sobre nós</a>
                    <a href="/institucional" class="btn btn-outline-secondary" id="adm">Administração</a>
                    <button onclick="download()" class="btn btn-warning" id="downloadnav"><i class="fa fa-download"></i>    Baixar</button>
                </div>
            </nav>
        </header>

        <div id="div1">
            <h2 id="texto">404 - A página que você está procurando não existe ou não pode ser mostrada!</h2><br>
            <a href="/home" class="btn btn-outline-warning" id="btnHome">Voltar</a>
        </div>
    </body>
</html>