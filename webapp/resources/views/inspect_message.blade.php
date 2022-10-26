<!doctype html>
<html>
    <head><title>Amicão - Detalhes da mensagem</title>@include("./user_routesNavigation")</head>
    <body>

        Nome completo: <?= $data[0]->fullname ?>
        Email: <?= $data[0]->email ?>
        Mensagem: <?= $data[0]->message ?>
        Status da solicitação: <?php

            $action = "";
            $button_value = "";

            switch($data[0]->solicitation_status){
                case 'solved':
                    $action = "/staff/messages/delete/do";
                    $button_value = "Excluir";
                    echo "Resolvida";         
                    break;
                case 'not_solved':
                    $action = "/staff/messages/fix/do/".$data[0]->id;
                    $button_value = "Resolver";
                    echo "Não atendida";
                    break;
                case 'solving':
                    $action = "/staff/messages/fix/do/".$data[0]->id;
                    $button_value = "Resolver";
                    echo "Em aberto";
                    break;
            }
            ?>

        

        <form id="frm_message_action" method="post" action="<?= $action ?>">
            <input type="hidden" name="_token" value="{{{csrf_token()}}}">
            <input type="hidden" name="_id" value="<?= $data[0]->id ?>">
            <input type="submit" value="<?= $button_value ?>">
        </form>

    </body>

</html>
