<!doctype html>
<html>
    <head>
        <title>Amicão - Responder requisição</title>
    </head>
    <body>
        <?php if(isset($error)){
                if($error=="null_msg"){
                        echo "<p>A requisição não pode ser enviada com a mensagem em branco.</p>";
                }
		    } 
        ?>

        <form id="frm_answer" method="post" action="/institucional/requisicoes/action/send_answer/">
            <input type="hidden" name="_token" value="{{{csrf_token()}}}">
            <input type="hidden" name="_id" value="<?= $id?>">
            <input type="hidden" name="avoidError" value="true">
            <span>Mensagem:</span>
            <textarea id="txtMessage" name="txtMessage" rows="4" cols="50"></textarea>
            <input type="submit" value="Enviar">
        </form>

        <br>
        

    </body>

</html>

