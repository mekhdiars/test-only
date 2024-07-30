<?php

session_start();

$username = trim(filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS));
$phone = trim(filter_var($_POST['phone'], FILTER_SANITIZE_SPECIAL_CHARS));
$email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
$password = trim(filter_var($_POST['password'], FILTER_SANITIZE_SPECIAL_CHARS));
$passwordConfirm = trim(filter_var($_POST['password-confirm'], FILTER_SANITIZE_SPECIAL_CHARS));

$error = '';
if ($username === '') {
    $error = 'Введите имя';
} elseif ($phone === '') {
    $error = 'Введите номер телефона';
} elseif ($email === '') {
    $error = 'Введите почту';
} elseif ($password === '') {
    $error = 'Введите пароль';
} elseif ($password !== $passwordConfirm) {
    $error = 'Пароли не совпадают';
}

if ($error !== '') {
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
    exit();
}

$password = md5($password);
$query = $pdo->prepare("INSERT INTO users (username, phone, email, password) VALUES (:username, :phone, :email, :password)");
$query->execute([':username' => $username, ':phone' => $phone, ':email' => $email, ':password' => $password]);

header('Location: /');
