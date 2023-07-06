<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" href="user/assets/css/admin.css">
        <title>Login</title>
    </head>
    <body>
        <form action="config/sv_login.php" method="POST">
            <table class="table">
                <tr>
                    <td colspan="2"><h2>Welcome!</h2></td>
                </tr>
                <tr>
                    <td>Email</td>
                    </tr>
                    <tr>
                    <td><input type="text" name="email" id="email" class="email" placeholder="masukkan email anda"></td>
                    </tr>
                </tr>
                <tr>
                    <td>Password</td>
                    </tr>
                    <tr>
                    <td><input type="password" name="password" id="password" class="password" placeholder="masukkan password anda"></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="login" value="login" class="login"></td>
                </tr>
            </table>
        </form>
    </body>
</html>