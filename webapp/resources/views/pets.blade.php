<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Amicão - Home</title>
	</head>
	<body>
        
        <a href="/institucional/pets/cadastrar">Adicionar novo pet</a>
        <div class="container" id="div_pets">
            
            <?php if(isset($info)): ?>
                <div class="alert alert-sucess">
                <?php if($info=="deleted_pet"):?>
                    <p>Pet excluido com sucesso!</p>
                <?php elseif($info=="error_delete_pet"): ?>
                    <p>Erro ao tentar deletear pet, tente novamente mais tarde :(</ap>
                <?php elseif($info=="inserted_pet"): ?>
                    <p>Pet cadastrado com sucesso</ap>
                <?php elseif($info=="error_inserting_pet"): ?>
                    <p>Erro ao tentar cadastrar pet, tente novamente mais tarde :(</ap>
                <?php endif ?>
                </div>
            <?php endif ?>


            <?php if(!isset($pets) || $pets==null): ?>
                <p>A instituição ainda não tem nenhum pet cadastrado</p>
            
            <?php else:?>
                
                
                <?php foreach($pets as $pet): ?>
                    <form id="frm_csrf_protection" method="post" action="/institucional/pets/excluir/">
                        <table>
                        <tr>
                            <td><img src="/storage/<?= $pet->img_path ?>"></td>
                            <td>Nome: <?= $pet->nome ?></td>
                            <td>Idade: <?= $pet->idade ?></td>
                            <td>Raca: <?= $pet->raca ?></td>
                            <td>Porte: <?= $pet->porte ?></td>
                            <td>Status: <?= $pet->status ?></td>
                        </tr>

                        <tr>
                            <td><a href="/institucional/pets/alterar/<?= $pet->id?>">Alterar</a></td>

                            
                                <input type="hidden" name="_token" value="{{{ csrf_token() }}}"><br>
                                <input type="hidden" name="txtId" value="<?= $pet->id ?>">
                                <a href="#" onClick="document.getElementById('frm_csrf_protection').submit()">Excluir</a>
                            
                            <!--<td><a href="/institucional/pets/excluir/<?= $pet->id ?>">Excluir</a></td> -->
                        </tr>
                        </table>
                    </form>
                <?php endforeach ?>
                
                
            <?php endif ?>
        
        </div>

    </body>
<html>
