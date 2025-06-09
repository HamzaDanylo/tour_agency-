<?php
session_start();
require("db.php");

// Очищення та перевірка даних
function clearData($field) {
    return trim(filter_var($_POST[$field], FILTER_SANITIZE_SPECIAL_CHARS));
}

$errors = [];
$username = clearData("username");
$email = clearData("email");
$password = clearData("password");
$conf_pass = clearData("conf_pass");
$chr_en = "a-zA-Z0-9\s`@~!#$%^&*()_+\-={}|:;<>?,.\/\"\'\\\\\[\]";

// Перевірка наявності користувача з таким username або email
$sql = 'SELECT * FROM users WHERE username = ? OR email = ?';
$query = $pdo->prepare($sql);
$query->execute([$username, $email]);
$user = $query->fetch(PDO::FETCH_ASSOC);

if ($user) {
    if ($user['username'] === $username) {
        $errors['has_user'] = 'Цей логін вже зайнятий';
    }
    if ($user['email'] === $email) {
        $errors['has_email'] = 'Ця електронна адреса вже зайнята';
    }
}

// Валідація даних
if (strlen($username) < 4)
    $errors['sh_user'] = 'Логін повинен містити не менше 4 символів';

if (!preg_match("/^[$chr_en]+$/", $username))
    $errors["lat_user"] = 'Логін повинен містити тільки латиницю';

if (strlen($email) < 6)
    $errors['sh_email'] = 'Електронна адреса повинна містити не менше 6 символів';

if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    $errors['email_invalid'] = 'Некоректна електронна адреса';

if (strlen($password) < 4)
    $errors['sh_pass'] = 'Пароль повинен містити не менше 4 символів';

if (!preg_match('/[a-zA-Z]/', $password))
    $errors['letter_pass'] = 'Пароль повинен містити літери';

if ($password !== $conf_pass)
    $errors['wrong_pass'] = 'Паролі не співпадають';

// Якщо є помилки — назад
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = ['username' => $username, 'email' => $email];
    header("Location: ../reg.php");
    exit;
}

// РЕЄСТРАЦІЯ
// DATABASE
$salt = "dskdjjaodjasd";
$hashedPassword = md5($salt.$password);

$sql = 'INSERT INTO users (username, password, email, registration_date) VALUES (?, ?, ?, NOW())';
$query = $pdo->prepare($sql);
$query->execute([$username, $hashedPassword, $email]);

// Після вставки беремо ID і зберігаємо користувача в сесію
$newUserId = $pdo->lastInsertId();

$_SESSION['user'] = [
    'id' => $newUserId,
    'username' => $username,
    'email' => $email,
    'reg_date' => date("Y-m-d H:i:s"),
    'avatar_path' => null,
    'role' => 'user'
];
header("Location: ../user.php");
?>