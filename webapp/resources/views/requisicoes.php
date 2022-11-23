<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
			  rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/style/estiloReq.css"/>
        <title>Amicão - Requisições</title>
        @include("./user_routesNavigation")
        <script>
			function download(){
				window.location.href="/download/app";
			}
		</script>
    <head>
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
                    <button onclick="download()" class="btn btn-warning" id="downloadnav" href="" ><i class="fa fa-download"></i>    Baixar</button>
                </div>
            </nav>
        </header>

        <div style="position:relative; left:10vw; top:15vh; color:black;">
        <?php 
                if(!empty(session('request_info'))){
                    switch(session('request_info')){
                        case 'no_requests':
                            echo '<p id="op_warn">Ainda não há requisições de usuários.</p>';
                            break;
                        case 'answered':
                            echo '<p id="op_warn">A requisição foi respondida com sucesso.</p>';
                            break;
                        case 'deleted':
                            echo '<p id="op_warn">A requisição foi deletada com sucesso.</p>';
                            break;
                    }
                    session(['request_info' => '']);
                }

        ?>
        </div>


        <div id="div1" style="background-color:transparent">
            
            <?php if(isset($data)):?>
                <table id="tabela" class="table table-dark table-hover table-responsive" style="min-width:200%; margin-left:-50%;">
                <tr>
                        <th>Requisicoes</th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>E-mail</th>
                        <th>Status da Requisição</th>
                        <th>Data da Requisição</th>
                        <th>Inspeção</th>
                        <th>ID (pet)</th>
                    </tr>
                    <?php foreach($data as $data):?>
                    <tr>
                        <td>Requisição de <?php
                        if($data->req_type=='adocao'){
                                echo 'adoção';
                        }else if($data->req_type=='apadrinhamento'){
                                echo 'apadrinhamento';
                        }
                        else if($data->req_type=='visita'){
                                echo 'visita';
                        }
                        ?>
                        </td> 
                        <td><?= $data->nome ?></td>
                        <td><?= $data->phone ?></td>
                        <td><?= $data->email ?></td>
                        <td><?php                            
                            if($data->status=='not_seen'){
                                echo 'não atendida';
                            }
                            else if($data->status=='answered'){
                                echo 'respondida';
                            }
                            ?>
                        <td><?=date('d/m/Y H:i:s', $data->date);?></td>
                        <td><a href="/institucional/requisicoes/inspec/<?= $data->id ?>">ver mais</a>
                        <td id="peto"><?= $data->id_pet ?> </td>

                    </tr>
                    <?php endforeach ?>
                </table>
            <?php endif ?>
        </div>
    </body>
</html>
