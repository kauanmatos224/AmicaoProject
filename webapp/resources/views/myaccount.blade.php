<!doctype html>
<html>

<head><title></title></head>

<body>
    <?php switch(session('user_account')){
        case 'changed_password';
            echo '<p>Sua senha foi alterada com sucesso!</p>';
            break;

        case 'wrong_conf_password':
            echo '<p>A senha e sua confirmação não conferem!</p>';
            break;
        case 'sent_mail_conf_changing':
            echo '<p>Uma mensagem de confirmação foi enviada para o e-mail informado.
            Realize a verificação para poder utilizar o novo e-mail quando estiver realizando Login</p>';
            break;

        case 'used_mail_by_other':
            echo '<p>Esse e-mail já está vinculado à outra instituição</p>';
            break;
        case 'used_mail_by_user':
            echo '<p>Esse e-mail é o mesmo atual de sua conta</p>';
            break;
    }

    session(['user_account' => '']);    

    ?>



    <h2>Alteração de Senha:</h2>
    <form method="post" action="/institucional/change-password/set-new">
        <input type="hidden" name="_token" value="{{{csrf_token()}}}">
        Senha: <input type="password" name="txtPassword">
        Confirmação da Senha: <input type="password" name="txtPasswordConfirmation">
        <input type="submit" value="Alterar">
    </form>
    <br>
    <br>


    <h2>Alteração de E-mail:</h2>
    <form method="post" action="/institucional/change-mail/set-new">
        <input type="hidden" name="_token" value="{{{csrf_token()}}}">
        Email: <input type="email" name="txtEmail">
        <input type="submit" value="Alterar email">
    </form>
</body>
</html>