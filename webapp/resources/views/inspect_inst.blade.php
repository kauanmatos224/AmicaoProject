<!doctype html>
<html>
    <head><title>Amicão - Detalhes da instituição</title>
    <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
			  rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="/style/inspect_inst.css"/>
		<title>Amicão</title>
    @include("./user_routesNavigation")
    </head>
    <body>
        <header id = cab>
            <nav id="nav" class="navbar fixed-top navbar-expand-sm bg-dark navbar-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/home">
                        <img src="/style/img/amicao_logo.png" style="width:40px;" class="square-pill"> 	
                    </a>
                    <a href="/contato" class="btn btn-outline-warning" id="contato">Contato</a>
                    <a href="/empresa" class="btn btn-outline-warning" id="empresa">Empresa</a>
                    <a href="/institucional" class="btn btn-outline-secondary" id="adm">Administração</a>
                    <button class="btn btn-warning" id="downloadnav" onclick="download()" ><i class="fa fa-download"></i>    Baixar</button>
                </div>
            </nav>
        </header>
        <div id="div1">
            Nome: <?= $data->nome_fantasia ?><br>
            CNPJ: <?= $data->cnpj ?><br>
            Endereço: <?= $data->endereco ?><br>
            Complemento: <?= $data->complemento ?><br>
            Código Postal: <?= $data->cep ?><br>
            Páis: <?= $data->country ?><br>
            Telefone: <?= $data->phone ?><br>
            E-mail: <?= $data->email ?><br>
            Status: <?php 
                switch($data->status){
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

                        echo "<p>Essa conta será excluida por completo em: ".date('d/m/y    H:i', $data->deletion_date)."</p>";
                        break;
                }
            ?><br>


        
            <?php switch($data->status){
                    case 'approved':?>
                    <form method="post" action='/staff/inst-analise/delete' id="frm_delete">
                        <input type="hidden" name="_token" value="{{{csrf_token()}}}">
                        <input type="hidden" name="_id" value="<?= $data->id ?>">
                        <input type="submit" class="btn btn-warning" value="Deletar conta"><br><br>
                    </form>
                <?php break;
                    case 'denied':?>
                    <form method="post" action="/staff/inst-analise/approve" id="frm_approve">
                        <input type="hidden" name="_token" value="{{{csrf_token()}}}">
                        <input type="hidden" name="_id" value="<?= $data->id ?>">
                        <input type="submit" class="btn btn-warning" value="Aprovar Conta"><br><br>
                    </form>
                <?php break;
                    case 'waiting':?>
                        <form method="post" action="/staff/inst-analise/approve" id="frm_aprove">
                            <input type="hidden" name="_token" value="{{{csrf_token()}}}">
                            <input type="hidden" name="_id" value="<?= $data->id ?>">
                            <input type="submit" class="btn btn-warning" value="Aprovar"><br><br>
                        </form>


                        <form method="post" action="/staff/inst-analise/deny" id="frm_aprove">
                            <input type="hidden" name="_token" value="{{{csrf_token()}}}">
                            <input type="hidden" name="_id" value="<?= $data->id ?>">
                            <input type="submit" class="btn btn-warning" value="Reprovar"><br><br>
                        </form>
                <?php break;
                    case 'deleted':?>
                        <form method="post" action="/staff/inst-analise/restore" id="frm_restore">
                            <input type="hidden" name="_token" value="{{{csrf_token()}}}">
                            <input type="hidden" name="_id" value="<?= $data->id ?>">
                            <input type="submit" class="btn btn-warning" value="Restaurar conta">
                        </form>

            <?php break;} ?>
        </div>
    </body>
</html>
