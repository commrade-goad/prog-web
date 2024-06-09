<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Register Page</title>
        <link href="/css/style.css" rel="stylesheet">
    </head>
    <body>
        <div class="login-header">
            <h1>Register Page</h1>
        </div>
        <br>
        <br>
        <div class="center">
            <form method="POST" action="/php-component/login.php" class="login-content">
                <div class="email-div">
                    <label for="email"/>Email:</label>
                    <span id="email-error" style="display: none;">invalid email.</span><br/>
                </div>
                <input type="text" name="email" required placeholder="email" id="email"/><br/><br/>
                <label for="username"/>Username:<br/></label>
                <input type="text" name="username" required placeholder="username"/><br/><br/>
                <label for="password"/>Password:<br/></label>
                <input type="password" name="password" required placeholder="password"/><br/><br/>
                <label for="type"/>Account type:<br/></label>
                <input type="number" name="type" required min=1 max=2 /><br/><br/>
                <input type="submit" name="reg" value="Register" id="login">
                <p><a href="/login">Go back to Login</a></p>
            </form>
            <script src="/js/validate-email.js">
            </script>
        </div>
    </body>
</html>
