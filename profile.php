<?php
    if (!isset($_COOKIE['login'])) {
        header('Location: /');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <h2><?php echo $_COOKIE['login']; ?></h2>
    <div class="form">
        <h3>Поменять данные</h3>
        <form action="src/update.php" method="post">
            <label for="username">Имя</label>
                <input type="text" name="username" placeholder="Иван">

            <label for="phone">Телефон</label>
                <input type="tel" name="phone" placeholder="896500010101">

            <label for="email">E-mail</label>
                <input type="email" name="email" placeholder="ivan@gmail.com">

            <label for="password">Пароль</label>
                <input type="password" name="password">

            <button type="submit">Сохранить</button>
        </form>
    </div>

    <form action="/src/exit.php" method="post">
        <button type="submit" id="exit-user">Выйти</button>
    </form>
</body>
</html>