<?php 
    if (isset($_COOKIE['login'])) {
        header('Location: profile.php');
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
    <link rel="stylesheet" href="css/main.css">
    <script src="https://smartcaptcha.yandexcloud.net/captcha.js" defer></script>
</head>

<body>
    <main>
        <div class="form">
            <h1>Вход</h1>
            <form action="src/login.php" method="post">
                <label for="login">Введите номер телефона или почту</label>
                <input type="text" name="login">

                <label for="password">Введите пароль</label>
                <input type="password" name="password">

                <div id="captcha-container" class="smart-captcha" data-sitekey="ysc1_tpp19lWgUa2qeL80d5t5iTdyK5cWU9Ir8lnNGYlbea769358" style="height: 100px">
                    <input type="hidden" name="smart-token" value="">
                </div>

                <button type="submit">Войти</button>
            </form>
            <p>У меня еще нет <a href="/register.php">аккаунта</a></p>
        </div>
    </main>

    <script>
        window.smartCaptchaCallback = function (token) {
            document.getElementById('smart-token').value = token;
        }
    </script>

</body>
</html>