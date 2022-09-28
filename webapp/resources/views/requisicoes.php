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
                    echo '<p>Requisição alterada com sucesso.';
                    break;
                case 'denied':
                    echo '<p>Requisição negada com sucesso.</p>';
                    break;
                case 'approved':
                    echo '<p>A requisição foi aprovada com sucesso./p>';
                    break;
            }
        }

    ?>

    <?php isset($data):?>
        <?php foreach($data as $data):?>
            <table>


            $table->string('nome');
            $table->integer('doc_num');
            $table->string('phone');
            $table->string('email');
            $table->string('endereco');
            $table->string('cep');
            $table->string('country');
            $table->string('obs');
            $table->string('status');
            $table->string('req_type');
        });






                <tr>
                    <td>Requisição de <?php
                    switch($data->req_type){
                        case 'em_adocao':
                            echo 'Adoção';
                        break;
                        case 'apadrinhado':
                            echo 'Apadrinhado';
                            break;
                        case 'dispoinvel':
                            echo 'Disponível';
                            break;
                    }
                    <td>Nome: <?= $data->nome ?></td>
                    <td>Documento de Identificação: <?= $data->doc_num ?></td>
                    <td>Telefone: <?php $data->phone ?></td>
                    <td>E-mail: <?php $data->email ?></td>
                    <td>Status da requisição: <?php $data->status ?><td> 
                    <td>Data agendada: <?php $data->date ?></td>
                    

                </tr>
            </table>




    </body>

</html>
