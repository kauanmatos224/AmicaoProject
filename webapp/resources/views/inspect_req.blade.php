<!doctype html>
<html>
    <head> 
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
			  rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/style/estiloInsp.css"/>
        <title>Amicão - Detalhes da requisição</title>
        @include("./user_routesNavigation")
        <script>
			if(window.location.pathname!="/home" && window.location.pathname!="/"){
				parent.self.location='/home';
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
                        <a href="/empresa" class="btn btn-outline-warning" id="empresa">Sobre nós</a>
                        <a href="/institucional" class="btn btn-outline-secondary" id="adm">Administração</a>
                        <button onclick="download()" class="btn btn-warning" id="downloadnav" onclick="download()" ><i class="fa fa-download"></i>    Baixar</button>
                    </div>
                </nav>
            </header>

        <div id="div1">
            <span class="lNome">Nome:</span> <?= $data->nome ?><br>
            <span class="lTel">Telefone:</span> <?= $data->phone ?><br>
            <span class="lEmail">E-mail:</span> <?= $data->email ?><br>
            <span class="lStatus">Status da Requisição:</span> <?php
                            
                            
                            if($data->status=='not_seen'){
                                echo 'não atendida';
                            }
                            else if($data->status=='answered'){
                                echo 'respondida';
                            }
                            
            ?>
            <br>
            <span class="lId">ID (pet):</span> <?= $data->id_pet ?><br>
        
            <form id="frm_req_change" method="post" action="/institucional/requisicoes/action">
                <input type="hidden" name="_token" value="{{{csrf_token()}}}">
                <input type="hidden" name="_id" value="<?= $data->id ?>">
                <br>
                <input type="submit" id="btnsubmit" class="btn btn-warning" value="<?php
                    if($data->status=='not_seen'){
                        echo "Responder";
                    }
                    else{
                        echo "Enviar outra resposta";
                    }
                
                ?>">
                <br><br>
            </form>

            <form id="frm_delete" method="post" action="/institucional/requisicoes/action/delete">
                <input type="hidden" name="_token" value="{{{csrf_token()}}}">
                <input type="hidden" name="_id" value="<?=$data->id?>">
                <input type="submit" id="btmexcluir" value="Excluir" class="btn btn-secondary">
            </form>

        </div>
    </body>
</html>

