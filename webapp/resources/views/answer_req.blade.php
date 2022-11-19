<!doctype html>
<html>
    <head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
			  rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/style/answer_req.css"/>
        <title>Amicão - Detalhes da requisição</title>
        @include("./user_routesNavigation")
        <title>Amicão - Responder requisição</title>
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
                        <button class="btn btn-warning" id="downloadnav" onclick="download()" ><i class="fa fa-download"></i>    Baixar</button>
                    </div>
                </nav>
            </header>

        

        <div id="div1">
            <div id="divctt">    
                <form id="frm_answer" method="post" action="/institucional/requisicoes/action/send_answer/">
                    <input type="hidden" name="_token" value="{{{csrf_token()}}}">
                    <input type="hidden" name="_id" value="<?= $id?>">
                    <input type="hidden" name="avoidError" value="true">
                    <span class="lmsg">Mensagem:</span>
                    <textarea id="txtMessage" name="txtMessage" rows="5" class="msg" ></textarea><br><br>
                    <input class="btn btn-warning" id="btnenviar" type="submit" value="Enviar">

                    <?php if(isset($error)){
                            if($error=="null_msg"){
                                echo "<br><br><p id='msgerro'>A requisição não pode ser enviada com a mensagem em branco.</p>";
                            }
		                } 
                    ?>
                </form>
            </div>
        </div>
    </body>

</html>

