<?php

session_start();

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
    $_SESSION['message'] = $error;
    header('Location: /profile.php');
    exit();
}

require_once 'db-connect.php';

$stmtUser = $pdo->prepare("SELECT * FROM users WHERE username = :login");
$stmtUser->execute([':login' => $login]);
$currentUser = $stmtUser->fetch(PDO::FETCH_OBJ);

$stmtUsers = $pdo->query("SELECT * FROM users");
$users = $stmtUsers->fetchAll(PDO::FETCH_OBJ);

foreach ($users as $user) {
    if ($user->username === $username && $currentUser->username !== $username) {
        $error = 'Пользователь с таким именем уже существует';
    } elseif ($user->phone === $phone && $currentUser->phone !== $phone) {
        $error = 'Пользователь с таким номером уже существует';
    } elseif ($user->email === $email && $currentUser->email !== $email) {
        $error = 'Пользователь с такой почтой уже существует';
    }
}

if ($error !== '') {
    $_SESSION['message'] = $error;
    header('Location: /profile.php');
    exit();
}

$password = md5($password);
$stmt = $pdo->prepare("UPDATE users SET username = :username, phone = :phone, email = :email, password = :password WHERE username = :login");
$stmt->execute([':username' => $username, ':phone' => $phone, ':email' => $email, ':password' => $password, ':login' => $login]);

setcookie('login', $username, time() + 3600 * 24, '/');
$_SESSION['message'] = 'Новые данные успешно сохранены';
header('Location: /profile.php');
