<?php

session_start();

define('SMARTCAPTCHA_SERVER_KEY', 'ysc2_tpp19lWgUa2qeL80d5t5ATV16yausb0PK8SzWvf0fc29dd64');

function check_captcha($token) {
    $ch = curl_init();
    $args = http_build_query([
        "secret" => SMARTCAPTCHA_SERVER_KEY,
        "token" => $token
    ]);
    curl_setopt($ch, CURLOPT_URL, "https://smartcaptcha.yandexcloud.net/validate?$args");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1);

    $server_output = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpcode !== 200) {
        echo "Allow access due to an error: code=$httpcode; message=$server_output\n";
        return true;
    }
    $resp = json_decode($server_output);
    return $resp->status === "ok";
}

$token = $_POST['smart-token'];
if (check_captcha($token)) {
    echo "Passed\n";
} else {
    echo "Robot\n";
}

$login = trim(filter_var($_POST['login'], FILTER_SANITIZE_SPECIAL_CHARS));
$password = trim(filter_var($_POST['password'], FILTER_SANITIZE_SPECIAL_CHARS));

$error = '';
if ($login === '') {
    $error = 'Введите номер или почту';
} elseif ($password === '') {
    $error = 'Введите пароль';
}

if ($error !== '') {
    $_SESSION['message'] = $error;
    header('Location: /');
    exit();
}

require_once 'db-connect.php';

$password = md5($password);
$stmtUser = $pdo->prepare("SELECT * FROM users WHERE phone = :phone OR email = :email");
$stmtUser->execute([':phone' => $login, ':email' => $login]);
$user = $stmtUser->fetch(PDO::FETCH_OBJ);

if ($login !== $user->phone && $login !== $user->email) {
    $error = 'Пользователя c таким логином не существует';
} elseif ($password !== $user->password) {
    $error = 'Неверный пароль';
}

if ($error !== '') {
    $_SESSION['message'] = $error;
    header('Location: /');
} else {
    setcookie('login', $user->username, time() + 3600 * 24, '/');
    header('Location: /profile.php');
}
