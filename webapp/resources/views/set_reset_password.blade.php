<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
			  rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="/style/estillopets.css"/>
		<title>Amicão - Nova senha</title>
	</head>

    <body>
        <h1>Crie uma nova senha:</h1>
        <form name="frmRecPassword" method="post" action="/institucional/recuperar-senha/send">
            <input type="hidden" name="_token" value="{{{csrf_token()}}}">
            <input type="hidden" name="tmp_reset_token" value="<?= $tmp_token ?>">
            Senha:
            <input type="password" name="txtPassword">
            <br>
            Confirme a senha:
            <input type="password" name="txtConfPassword">
            <br>
            <?php 
                if(isset($error)){
                    if($error="not_matched_password"){
                        echo <<<END

                            <div class="alert altert-danger">
                                <span>A primeira senha não confere com a sua confirmação</span>
                            </div>

                        END;
                    }
                }
            ?>
            <input type="submit" value="Enviar">
        </form>

    </body>

</html>
