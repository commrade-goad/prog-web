<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login Page</title>
        <link href="/css/style.css" rel="stylesheet">
    </head>
    <body>
        <div class="login-header">
            <h1>Login Page</h1>
        </div>
        <br>
        <br>
        <div class="center">
            <form method="POST" action="/php-component/login.php" class="login-content">
                <label for="username"/>Username:<br/></label>
                <input type="text" name="username" required placeholder="username"/><br/><br/>
                <label for="password"/>Password:<br/></label>
                <input type="password" name="password" required placeholder="password"/><br/><br/>
                <input type="submit" name="login" value="Login" id="login">
                <p><a href="/register">Register new user</a></p>
            </form>
        </div>
    </body>
</html>
