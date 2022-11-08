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
    </head>
    <body id="grid">
        <div id="div1">
            <span class="lNome">Nome:</span> <?= $data->nome ?><br>
            <span class="lTel">Telefone:</span> <?= $data->phone ?><br>
            <span class="lEmail">E-mail:</span> <?= $data->email ?><br>
            <span class="lStatus">Status da Requisição:</span> <?php
                            
                            
                            if($data->status=='not_seen'){
                                echo 'não avaliada';
                            }
                            else if($data->status=='refused'){
                                echo 'negada';
                            }
                            else if($data->status=='acceptted'){
                                echo 'aceita';
                            }

            ?><br>
            <span class="lData">Data:</span> <?= date('d/m/Y H:i:s', $data->date) ?><br>
            <span class="lObs">Observações:</span> <?= $data->obs ?><br>
            <span class="lId">ID (pet):</span> <?= $data->id_pet ?><br>

            <?php 
            $frm_req_change = false;
            $frm_req_approve = false;
            $frm_req_refuse = true;
            if($data->status=='not_seen'){
                $frm_req_change = $frm_req_approve = true;
            }
            else if($data->status=='refused'){
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
                <br>
                <input type="submit" class="btn btn-warning" value="Alterar">
            </form>
            <?php endif ?>

            <?php if($frm_req_approve==true):?>
            <form id="frm_req_approve" method="post" action="/institucional/requisicoes/action">
                <input type="hidden" name="_token" value="{{{csrf_token()}}}">
                <input type="hidden" name="_id" value="<?= $data->id ?>">
                <input type="hidden" name="op_type" value="approve">
                <br>
                <input type="submit" class="btn btn-warning" value="Aprovar">
            </form>
            <?php endif ?>

            <?php if($frm_req_refuse==true):?>
            <form id="frm_req_refuse" method="post" action="/institucional/requisicoes/action">
                <input type="hidden" name="_token" value="{{{csrf_token()}}}">
                <input type="hidden" name="_id" value="<?= $data->id ?>">
                <input type="hidden" name="op_type" value="repprove">
                <br>
                <input type="submit" class="btn btn-warning" value="Reprovar">
            </form>
            <?php endif ?>



        </div>
    </body>
</html>

