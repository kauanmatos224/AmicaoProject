<!doctype html>
<html>
    <head>
    <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
			  rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="/style/download_app.css"/>
		@include("./user_routesNavigation")
        <title>Amicão - Obrigado por baixar nosso app</title>
    </head>
    <script>
        function hideAllTextPostDownload(){
            div_thanks = document.getElementById("thanks-div");
            div_thanks.style.display='none';
        }
        function changeVisibility(){
            div_thanks = document.getElementById("thanks-div");
            div_thanks.style.display='block';

            download_href = document.getElementById("download_href");
            download_href.textContent='Download não iniciou, tentar novamente.'
        } 
    </script>
    <body onload="hideAllTextPostDownload()">
    <div id="thanks-div">
        <p id="thanks">Obrigado por baixar nosso app!</p>
        <p id="info-sec">Por questões de segurançara, para verificar a integridade do arquivo baixado antes de instala-lo,
            realize o Checksum do app, que consistem em verificar se o conteudo do arquivo que você baixou é o mesmo que o nosso através de comparação de hash.
        </p>
        <p id="hash">Hash do app: </p>
    </div>
    <div id="div1">
        <div id="divbtn">
            <a class="btn btn-warning" id="download_href" onclick="changeVisibility()"href="<?= $app_path?>" download>Iniciar download</a>
        </div>
    </div>
    </body>
</html>

