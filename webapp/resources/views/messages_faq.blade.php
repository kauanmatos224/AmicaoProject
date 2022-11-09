<!doctype html>
<html>
    <head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/style/estiloFaq.css"/>
        <title>Amicão - Mensagens|FAQ</title>
        @include("./user_routesNavigation")
    </head>

    <body>
        <div id="div1">
            <?php 
                if(isset($info)){
                    if($info=='none_messages'){
                        echo '<p>Não há nenhuma mensagem.</p><br>';
                    }
                }

                switch(session('info_message_op')){
                    case 'answered_message':
                        echo '<p>Mensagem respondida com sucesso.</p>';
                        break;
                    case 'deleted_message':
                        echo '<p>Mensagem respondida com sucesso.</p>';
                        break;
                }
            ?>
        </div>

        <table id="tabela">
            <?php if(!isset($info)): ?>
                <?php foreach($dataset as $message): ?>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Mensagem</th>
                        <th>Status da solicitação</th>
                    </tr>
                    <tr>
                        <td><?= $message->fullname?></td>
                        <td><?= $message->email ?></td>
                        <td><?= substr($message->message, 0,10)."..." ?></td>
                        <td><?php 
                            $info_status = null;
                            $last_answer = date('d/m/Y H:i:s', $message->last_answer);
                            switch($message->solicitation_status){
                                case 'solving':
                                    echo 'Em andamento';
                                    $info_status="<td>Última resposta em: ".$last_answer."</td>";
                                    break; 
                                case 'not_solved':
                                    echo 'Não atendida';
                                    break;
                            
                                case 'solved':
                                    echo 'Resolvida';
                                    $info_status="<td>Última resposta em: ".$last_answer."</td>";
                                    break;
                                }
                            ?>
                        </td>
                        <td><?= $info_status ?></td> 
                        <td><a href="/staff/messages/more/<?=$message->id?>">Ver mais</a></td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>


            <?php
                session(['info_message_op'=>'']);
            ?>
        </table>
    </body>


</html>
