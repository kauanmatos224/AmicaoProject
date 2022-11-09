<!doctype html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/style/estiloDet.css"/>
        <title>Amicão - Detalhes da mensagem</title>
        @include("./user_routesNavigation")</head>
    <body>
        <div id="div1">
            Nome completo: <?= $data[0]->fullname ?><br>
            Email: <?= $data[0]->email ?><br>
            Mensagem: <?= $data[0]->message ?><br>
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
                ?><br>
            <form id="frm_message_action" method="post" action="<?= $action ?>">
                <input type="hidden" name="_token" value="{{{csrf_token()}}}">
                <input type="hidden" name="_id" value="<?= $data[0]->id ?>">
                <input type="submit" class="btn btn-warning" value="<?= $button_value ?>">
            </form>
        </div>
    </body>
</html>