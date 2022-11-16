<!doctype html>
<html>
    <head>
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
        <a id="download_href" onclick="changeVisibility()"href="<?= $app_path?>" download>Iniciar download</a>

    </body>
</html>

