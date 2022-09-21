<!doctype html>
<html>
    <head><title></title>
    </head>
    <body>

        Nome: <?= $data_org->nome_fantasia ?>
        CNPJ: <?= $data_org->cnpj ?>
        Endereço: <?= $data_org->endereco ?>
        Complemento: <?= $data_org->complemento ?>
        Código POstal: <?= $data_org->cep ?>
        Páis: <?= $data_org->country ?>
        Telefone: <?= $data_org->phone ?>
        E-mail: <?= $data_auth_org->email ?>
        Status: <?php 
            switch($data_auth_org->status){
                case 'approved': 
                    echo 'Aprovado'; 
                    break; 
                case 'denied': 
                    echo 'Reprovado'; 
                    break;
                case 'waiting': 
                    echo 'Em análise';
                    break;
                case 'deleted':
                    echo 'Em processo de exclusão.';

                    echo "<p>Essa conta será excluida por completo em: <?= date('d/m/y    H:i', $data_auth_org->deletion_date)?></p>";
                    break;
            }
        ?>


    
        <?php switch($data_auth_org->status){
                case 'approved':?>
                <form method="post" action='/staff/inst-analise/delete' id="frm_delete">
                    <input type="hidden" name="_token" value="{{{csrf_token()}}}">
                    <input type="hidden" name="_id" value="<?= $data_org->id ?>">
                    <input type="submit" value="Deletar conta">
                </form>
            <?php break;
                case 'denied':?>
                <form method="post" action="/staff/inst-analise/approve" id="frm_approve">
                    <input type="hidden" name="_token" value="{{{csrf_token()}}}">
                    <input type="hidden" name="_id" value="<?= $data_org->id ?>">
                    <input type="submit" value="Aprovar Conta">
                </form>
            <?php break;
                case 'waiting':?>
                    <form method="post" action="/staff/inst-analise/approve" id="frm_aprove">
                        <input type="hidden" name="_token" value="{{{csrf_token()}}}">
                        <input type="hidden" name="_id" value="<?= $data_org->id ?>">
                        <input type="submit" value="Aprovar">
                    </form>


                    <form method="post" action="/staff/inst-analise/deny" id="frm_aprove">
                        <input type="hidden" name="_token" value="{{{csrf_token()}}}">
                        <input type="hidden" name="_id" value="<?= $data_org->id ?>">
                        <input type="submit" value="Reprovar">
                    </form>
            <?php break;
                case 'deleted':?>
                    <form method="post" action="/staff/inst-analise/restore" id="frm_restore">
                        <input type="hidden" name="_token" value="{{{csrf_token()}}}">
                        <input type="hidden" name="_id" value="<?= $data_org->id ?>">
                        <input type="submit" value="Restaurar conta">
                    </form>

        <?php break;} ?>
    </body>
</html>
