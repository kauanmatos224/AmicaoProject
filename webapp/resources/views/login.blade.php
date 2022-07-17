<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
    <head>
    <body>
        <form id="frmLogin" method="post" action="/login/do_auth">
            <input type="hidden" name="_token" value="{{{csrf_token()}}}">
            E-mail:
            <input type="email" name="txtEmail"><br>
            Senha:
            <input type="password" name="txtPassword"><br>
            <input type="submit" value="Entrar">
        </form>
    </body>
</html>