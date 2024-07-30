<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
=======
<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="ru">
>>>>>>> d47b5ba (add functionality and optimize work with the database)
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <main>
        <div class="form">
            <h1>Регистрация</h1>
            <form action="src/reg.php" method="post">
                <label for="username">Имя</label>
                    <input type="text" name="username" placeholder="Иван">

                <label for="phone">Телефон</label>
                    <input type="tel" name="phone" placeholder="896500010101">

                <label for="email">E-mail</label>
                    <input type="email" name="email" placeholder="ivan@gmail.com">

                <label for="password">Пароль</label>
                    <input type="password" name="password">

                <label for="confirmation-password">Подтверждение пароля</label>
<<<<<<< HEAD
                    <input type="password" name="confirmation-password">
=======
                    <input type="password" name="password-confirm">
>>>>>>> d47b5ba (add functionality and optimize work with the database)

                <button type="submit">Продолжить</button>
            </form>

            <p>У меня уже есть <a href="/">аккаунт</a></p>
        </div>
<<<<<<< HEAD
=======

        <p class="message">
            <?php
                echo $_SESSION['message'] ?? '';
                unset($_SESSION['message']);
            ?>
        </p>
>>>>>>> d47b5ba (add functionality and optimize work with the database)
    </main>
</body>
</html>