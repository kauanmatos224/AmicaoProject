<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/style/estiloPass" />
        <title>Amicão - Recuperar Senha</title>
        @include("./user_routesNavigation")

        <script>
			function download(){
				window.location.href="/download/app";
			}
		</script>
    </head>
    <body id="grid">
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

    Insira uma nova senha:
    <form method="post" action="/institucional/change-password/set-new">
        <input type="hidden" name="_token" value="{{{csrf_token()}}}">
        <input type="hidden" name="_email" value="<?= $email ?>">
        Senha:<input type="password" name="txtPassword">
        Confirmação de senha: <input type="password" name="txtPasswordConfirmation">
        <input type="submit" value="Alterar">
    </form>

</body>
</html>