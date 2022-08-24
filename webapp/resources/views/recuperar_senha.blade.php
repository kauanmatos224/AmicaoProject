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
		<title>Amicão - Recuperar senha</title>
	</head>

    <body>
        <h1>Digite seu e-mail para receber um link de recuperação.</h1><br>
        <form name="frmRecPassword" method="post" action="/institucional/recuperar-senha/send">
            <input type="hidden" name="_token" value="{{{csrf_token()}}}">
            <input type="email" name="txtEmail">
            <br>
            <input type="submit" value="Enviar">
        </form>

    </body>

</html>
