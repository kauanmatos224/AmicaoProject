<!doctype html>
<html>
    <head><title>Requisição</title>
    </head>
    <body>

        Nome: <?= $data->nome ?>
        Telefone: <?= $data->phone ?>
        E-mail: <?= $data->email ?>
        Status da requisição: <?php
                        
                        
                        if($data->status=='not_seen'){
                            echo 'não avaliada';
                        }
                        else if($data->status=='refused'){
                            echo 'negada';
                        }
                        else if($data->status=='acceptted'){
                            echo 'aceita';
                        }

        ?>
        Agendamento para: <?= date('d/m/Y H:i:s', $data->date) ?>

        Observações: <?= $data->obs ?>

        Id do Pet: <?= $data->id_pet ?>

        <?php 
        
        $frm_req_change = false;
        $frm_req_approve = false;
        $frm_req_refuse = false;
        if($data->status=='not_seen' || $data->status=='refused'){
            $frm_req_change = $frm_req_approve = true;
        }
        else if($data->status=='acceptted'){
            $frm_req_change = true;
            $frm_req_refuse = true;
        }
        ?>

        <?php if($frm_req_change==true):?>
        <form id="frm_req_change" method="post" action="/institucional/requisicoes/action">
            <input type="hidden" name="_token" value="{{{csrf_token()}}}">
            <input type="hidden" name="_id" value="<?= $data->id ?>">
            <input type="hidden" name="op_type" value="change">
            <input type="submit" value="Alterar">
        </form>
        <?php endif ?>

        <?php if($frm_req_approve==true):?>
        <form id="frm_req_approve" method="post" action="/institucional/requisicoes/action">
            <input type="hidden" name="_token" value="{{{csrf_token()}}}">
            <input type="hidden" name="_id" value="<?= $data->id ?>">
            <input type="hidden" name="op_type" value="approve">
            <input type="submit" value="Aprovar">
        </form>
        <?php endif ?>

        <?php if($frm_req_refuse==true):?>
        <form id="frm_req_refuse" method="post" action="/institucional/requisicoes/action">
            <input type="hidden" name="_token" value="{{{csrf_token()}}}">
            <input type="hidden" name="_id" value="<?= $data->id ?>">
            <input type="hidden" name="op_type" value="repprove">
            <input type="submit" value="Reprovar">
        </form>
        <?php endif ?>




    </body>
</html>

