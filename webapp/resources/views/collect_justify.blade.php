<!doctype html>
<html>
    <head><title>Justificativa de Operação</title>
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
			  rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="/style/colletc_justify.css"/>
        @include("./user_routesNavigation")

        
    </head>
    <body>
    
     



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
            <div id="divctt">
                <a id="labelj">Justificativa: (essa informação será fornecida ao usuário da conta)</a>
                <textarea id="txtJustify" name="txtJustify" rows="4" cols="50"></textarea>     
            
                <div id="div_submit">
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
                </div>

                        <?php if(isset($info)){
                                if($info=='wrong_justify'){
                                    echo "<p id=\"error_info\">Uma justificativa válida deve ser fornecida para a efetuação da operação.</p>";
                                }
                            }
                        ?>
            </div>

            
        </form>
        <header id = cab>
			<nav id="nav" class="navbar fixed-top navbar-expand-sm bg-dark navbar-dark">
				<div class="container-fluid">
					<a class="navbar-brand" href="/home">
						<img src="/style/img/amicao_logo.png" style="width:40px;" class="square-pill"> 	
				  	</a>
				  	<a href="/contato" class="btn btn-outline-warning" id="contato">Contato</a>
					<a href="/empresa" class="btn btn-outline-warning" id="empresa">Empresa</a>
					<a href="/institucional" class="btn btn-outline-secondary" id="adm">Administração</a>
					<button class="btn btn-warning" id="downloadnav" href="" ><i class="fa fa-download"></i>    Baixar</button>
				</div>
			</nav>
		</header>

    </body>