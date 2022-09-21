<!doctype html>
<html>
    <head><title>Justificativa de Operação</title></head>
    <body>
    
        <?php if(isset($info)){
            if($info=='wrong_justify'){
                echo "<p>Uma justificativa válida deve ser fornecida para a efetuação da operação.</p>";
            }
        }

        ?>



        <form id='frmJustify' method='post' action="<?php
        
            switch($operation_type){
                case 'restoreInst':
                    echo '/staff/inst-analise/restore/do';
                    break;
                case 'deleteInst':
                    echo "/staff/inst-analise/delete/do";
                    break;
                case 'approveInst':
                    echo "/staff/inst-analise/approve/do";
                    break;
                case 'denyInst':
                    echo "/staff/inst-analise/deny/do";
                    break;
            }

        
        
        
        ?>">
            <input type="hidden" name="_token" value="{{{csrf_token()}}}">
            <input type="hidden" name="_id" value="<?= $id?>">
            <input type="hidden" name="op_type" value="<?= $operation_type?>">
            Justificativa: (essa informação será fornecida ao usuário da conta)
            <textarea id="txtJustify" name="txtJustify" rows="4" cols="50"></textarea>        

            <?php switch($operation_type){
                case 'restoreInst':
                    echo "<input type='submit' value='Restaurar Cadastro'> ";
                    break;
                case 'deleteInst':
                    echo "<input type='submit' value='Deletar Cadastro'> ";
                    break;
                case 'approveInst':
                    echo "<input type='submit' value='Aprovar Cadastro'> ";
                    break;
                case 'denyInst':
                    echo "<input type='submit' value='Reprovar Cadastro'> ";
                    break;
            }

            ?>

            
        </form>


    </body>