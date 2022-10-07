<!doctype html>
<html>
<head><title></title></head>
<body>

    Insira uma nova senha:
    <form method="post" action="/institucional/change-password/set-new">
        <input type="hidden" name="_token" value="{{{csrf_token()}}}">
        <input type="hidden" name="_email" value="<?= $email ?>">
        Senha:<input type="password" name="txtPassword">
        Confirmação de senha: <input type="password" name="txtPasswordConfirmation">
        <input type="submit" value="Alterar">
    </form>

</body>
</html>