<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/style/estiloMF.css" />
        <title>Resolver solicitação</title>
        @include("./user_routesNavigation")
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

        <?php if(isset($error)){
            if($error=='wrong_answer'){
                echo '<p>A operação não pode ser completada sem um feedback</p>';
            }
        }
        ?>

        <div id="div1">
            <h3>Resposta ao solicitante (Feedback):</h3>
            <form id="frm_answer_to_requirer" action="/staff/message/fix_send_answer" method="post">
                <input type="hidden" name="_token" value="{{{csrf_token()}}}">
                <input type="hidden" name="_id" value="<?= $id ?>"><br><br>
                <span class="texto">Resposta:</span><br>
                <textarea id="txtAnswer" name="txtAnswer" rows="4" cols="50"></textarea> 
                <br><br>
                <span class="texto">Marcar como:</span><br> 
                <select name="txtStatus">
    	  			<option value="solving" selected>Em aberto</option>
    				<option value="solved">Resolvida</option>
    			</select>
                <br><br>
                <input type="submit" class="btn btn-outline-warning" value="Enviar" id="enviar">
            </form>
        </div>
    </body>
</html>