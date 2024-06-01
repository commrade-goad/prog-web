<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login Page</title>
        <link href="style.css" rel="stylesheet">
    </head>
    <body>
        <div class="login-header">
            <h1>Login Page</h1>
        </div>
        <br>
        <br>
        <form method="POST" action="login.php" class="login-content">
            <label for="username"/>Username:<br/></label>
            <input type="text" name="username" required placeholder="username"/><br/><br/>
            <label for="password"/>Password:<br/></label>
            <input type="password" name="password" required placeholder="password"/><br/><br/>
            <input type="submit" name="submit" value="Login" id="login">
        </form>
    </body>
</html>
