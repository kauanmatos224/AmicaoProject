<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/style/estiloAn.css"/>
        <title>Amicão - Análise de cadastros</title>
        @include("./user_routesNavigation")
        
    </head>
    <body>
        <div id="div1">
            <?php
                if(isset($info)){
                    switch($info){
                        case 'deleted_register':
                            echo '<p>Cadastro movido para processo de deleção com sucesso.
                            A exclusão do cadastro será efetuada por completo automaticamente após 1 mês</p>';
                            break;
                        case 'approved_register':
                            echo '<p>O cadastro foi aprovado com sucesso</p>';
                            break;
                    }
                    session(['info_register_analisys'=>null]);
                }
            ?>

            <?php if(!isset($data) || $data==null): ?>
                <p>A plataforma ainda não tem Pré-cadastros de instituições para análise.</p>   
            <?php else:?>
                <table>
                    <?php foreach($data as $inst):?>
                        <tr>
                            <th>Nome fantasia</th>
                            <th>CNPJ</th>
                            <th>Status</th>
                            <th>Endereço</th>
                            <th>Complemento</th>
                            <th>Código postal</th>
                            <th>País</th>
                            <th>Telefone</th>
                            <th>...</th>
                        </tr>
                            <td><?= $inst->nome_fantasia ?></td>
                            <td><?= $inst->cnpj ?></td>
                            <td> 
                                <?php
                                    switch($inst->status){
                                        case 'approved':
                                            echo 'Aprovado';
                                            break;
                                        case 'deleted':
                                            echo 'Em processo de deleção';
                                            break;
                                        case 'waiting':
                                            echo 'Aguardando análise';
                                            break;
                                        case 'reproved':
                                            echo 'Reprovado';
                                            break;
                                    }
                                ?>
                            </td>   
                            <td><?= $inst->endereco ?></td>
                            <td><?= $inst->complemento ?></td>
                            <td><?= $inst->cep ?></td>
                            <td><?= $inst->country ?></td>
                            <td><?= $inst->phone ?></td>
                            <td><a href="/staff/inst-analise/more/<?= $inst->id?>">ver mais</a></td>
                        </tr>
                    <?php endforeach ?>
                </table>
            <?php endif ?>
        </div>
    </body>
</html>