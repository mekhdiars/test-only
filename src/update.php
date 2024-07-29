<?php

$username = trim(filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS));
$phone = trim(filter_var($_POST['phone'], FILTER_SANITIZE_SPECIAL_CHARS));
$email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
$password = trim(filter_var($_POST['password'], FILTER_SANITIZE_SPECIAL_CHARS));
$login = $_COOKIE['login'];

$error = '';
if ($username === '') {
    $error = 'Введите имя';
} elseif ($phone === '') {
    $error = 'Введите номер телефона';
} elseif ($email === '') {
    $error = 'Введите почту';
} elseif ($password === '') {
    $error = 'Введите пароль';
}

if ($error !== '') {
    echo $error . '<br>';
    echo '<p><a href="/profile.php">Вернуться</a> в профиль</p>';
    exit();
}

$userDb = 'root';
$passwordDb = 'root';
$db = 'testing';
$host = 'localhost';
$port = 8889;

$dsn = "mysql:host={$host};dbname={$db};port={$port}";
$pdo = new PDO($dsn, $userDb, $passwordDb);

$stmtUser = $pdo->prepare("SELECT * FROM users WHERE username = :username OR phone = :phone OR email = :email");
$stmtUser->execute([':username' => $username, ':phone' => $phone, ':email' => $email]);
$user = $stmtUser->fetch(PDO::FETCH_OBJ);

if ($user->username !== $login) {
    echo 'Пользователь с такими данными уже существует'; 
    exit();
}

$password = md5($password);
$stmt = $pdo->prepare("UPDATE users SET username = :username, phone = :phone, email = :email, password = :password WHERE id = $user->id");
$stmt->execute([':username' => $username, ':phone' => $phone, ':email' => $email, ':password' => $password]);
