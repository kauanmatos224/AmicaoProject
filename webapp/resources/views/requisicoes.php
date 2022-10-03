<!doctype html>
<html>
    <head>
        <title>Requisiçẽos</title>
    <head>
    <body>

    <?php 
        if(!empty(session('request_info'))){
            switch(session('request_info')){
                case 'no_requests':
                    echo '<p>Ainda não há requisições de usuários.</p>';
                    break;
                case 'changed':
                    echo '<p>Requisição alterada com sucesso.</p>';
                    break;
                case 'denied':
                    echo '<p>Requisição reprovada com sucesso.</p>';
                    break;
                case 'approved':
                    echo '<p>A requisição foi aprovada com sucesso.</p>';
                    break;
                case 'deleted':
                    echo '<p>Requisição reprovada e deletada com sucesso.</p>';
            }
            session(['request_info' => '']);
        }

    ?>

    <?php if(isset($data)):?>
        <table>

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
                    <td>Nome: <?= $data->nome ?></td>
                    <td>Telefone: <?= $data->phone ?></td>
                    <td>E-mail: <?= $data->email ?></td>
                    <td>Status da requisição: <?php
                        
                        
                        if($data->status=='not_seen'){
                            echo 'não avaliada';
                        }
                        else if($data->status=='refused'){
                            echo 'negada';
                        }
                        else if($data->status=='acceptted'){
                            echo 'aceita';
                        }

                        ?></td> 
                    <td>Agendamento para: <?= date('d/m/Y H:i:s', $data->date) ?></td>
                    <td><a href="/institucional/requisicoes/inspec/<?= $data->id ?>">ver mais</a>

                </tr>
                <?php endforeach ?>
            </table>
            <?php endif ?>
    </body>

</html>
