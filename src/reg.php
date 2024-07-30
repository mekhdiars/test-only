<?php

<<<<<<< HEAD
=======
session_start();

>>>>>>> d47b5ba (add functionality and optimize work with the database)
$username = trim(filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS));
$phone = trim(filter_var($_POST['phone'], FILTER_SANITIZE_SPECIAL_CHARS));
$email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
$password = trim(filter_var($_POST['password'], FILTER_SANITIZE_SPECIAL_CHARS));
<<<<<<< HEAD
$confirmationPassword = trim(filter_var($_POST['confirmation-password'], FILTER_SANITIZE_SPECIAL_CHARS));
=======
$passwordConfirm = trim(filter_var($_POST['password-confirm'], FILTER_SANITIZE_SPECIAL_CHARS));
>>>>>>> d47b5ba (add functionality and optimize work with the database)

$error = '';
if ($username === '') {
    $error = 'Введите имя';
} elseif ($phone === '') {
    $error = 'Введите номер телефона';
} elseif ($email === '') {
    $error = 'Введите почту';
} elseif ($password === '') {
    $error = 'Введите пароль';
<<<<<<< HEAD
} elseif ($password !== $confirmationPassword) {
=======
} elseif ($password !== $passwordConfirm) {
>>>>>>> d47b5ba (add functionality and optimize work with the database)
    $error = 'Пароли не совпадают';
}

if ($error !== '') {
<<<<<<< HEAD
    echo $error;
    echo '<p><a href="/register.php">Вернуться</a> на страницу регистрации</p>';
    exit();
}

$userDb = 'root';
$passwordDb = 'root';
$db = 'testing';
$host = 'localhost';
$port = 8889;

$dsn = "mysql:host={$host};dbname={$db};port={$port}";
$pdo = new PDO($dsn, $userDb, $passwordDb);

$user = $pdo->prepare("SELECT id FROM users WHERE username = :username OR phone = :phone OR email = :email");
$user->execute([':username' => $username, ':phone' => $phone, ':email' => $email]);
$userId = $user->fetch(PDO::FETCH_OBJ);

if (isset($userId->id)) {
    echo 'Пользователь с такими данными уже существует'; 
=======
    $_SESSION['message'] = $error;
    header('Location: /register.php');
    exit();
}

require_once 'db-connect.php';

$stmtUser = $pdo->prepare("SELECT * FROM users WHERE username = :username OR phone = :phone OR email = :email");
$stmtUser->execute([':username' => $username, ':phone' => $phone, ':email' => $email]);
$user = $stmtUser->fetch(PDO::FETCH_OBJ);

if ($user->username === $username) {
    $error = 'Пользователь с таким именем уже существует';
} elseif ($user->phone === $phone) {
    $error = 'Пользователь с таким номером уже существует';
} elseif ($user->email === $email) {
    $error = 'Пользователь с такой почтой уже существует';
}

if ($error !== '') {
    $_SESSION['message'] = $error;
    header('Location: /register.php');
>>>>>>> d47b5ba (add functionality and optimize work with the database)
    exit();
}

$password = md5($password);
$query = $pdo->prepare("INSERT INTO users (username, phone, email, password) VALUES (:username, :phone, :email, :password)");
$query->execute([':username' => $username, ':phone' => $phone, ':email' => $email, ':password' => $password]);

header('Location: /');
