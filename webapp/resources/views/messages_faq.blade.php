<!doctype html>
<html>
    <head><title>Amicão - Mensages|FAQ</title>
    @include("./user_routesNavigation")
    </head>

    <body>
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


        

        <table>
            <?php if(!isset($info)): ?>
                <?php foreach($dataset as $message): ?>
                    <tr>
                        <td>Nome: <?= $message->fullname?></td>
                        <td>E-mail: <?= $message->email ?></td>
                        <td>Mensagem: <?= substr($message->message, 0,10)."..." ?></td>
                        <td>Status da solicitação: <?php 
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
