<!doctype html>
<html>
    <head><title>Resolver solicitação</title>
    </head>

    <body>

        <?php if(isset($error)){
            if($error=='wrong_answer'){
                echo '<p>A operação não pode ser completada sem um feedback</p>';
            }
        }

        ?>


        Resposta ao solicitante (Feedback):
        <form id="frm_answer_to_requirer" action="/staff/message/fix_send_answer" method="post">
            <input type="hidden" name="_token" value="{{{csrf_token()}}}">
            <input type="hidden" name="_id" value="<?= $id ?>">
            <textarea id="txtAnswer" name="txtAnswer" rows="4" cols="50"></textarea> 
            <br>
            Marcar como:  
            <select name="txtStatus">
	  			<option value="solving" selected>Em aberto</option>
				<option value="solved">Resolvida</option>
			</select>
            <input type="submit" value="Enviar">

        </form>



    </body>

</html>

