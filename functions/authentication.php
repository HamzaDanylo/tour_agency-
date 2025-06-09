<?php
    session_start();
    ini_set('session.gc_maxlifetime', 86400);
    require("db.php"); 
    function clearData($field){
        return trim(filter_var($_POST[$field],FILTER_SANITIZE_SPECIAL_CHARS));
    }
    $errors = array();

    $username_auth = clearData("username_auth");
    $password_auth = clearData("password_auth");
    $chr_en = "a-zA-Z0-9\s`@~!#$%^&*()_+-={}|:;<>?,.\/\"\'\\\[\]";

    // DB
    $salt = "dskdjjaodjasd";
    $password = md5($salt.$password_auth);

    $sql1 = 'SELECT username, password FROM users WHERE username = ? OR password = ?';
    $query1 = $pdo->prepare($sql1);
    $query1->execute([$username_auth, $password_auth]);
    $rows = $query1->fetchAll(PDO::FETCH_ASSOC);


    $sql = 'SELECT * FROM users WHERE username = ?';
    $query = $pdo->prepare($sql);
    $query->execute([$username_auth]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $errors['no_user'] = 'Такого логіна немає';
    } elseif ($user['password'] !== $password) {
        $errors['miss_pass'] = 'Невірний пароль';
    } else {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $username_auth,
            'email' => $user['email'],
            'reg_date'=> $user['registration_date'],
            'avatar_path' => $user['avatar_path'] ?? null,
            'role' => $user['role']
        ];
        session_write_close();
        header("Location: ../user.php");
        exit;
    }
 
    if(strlen($username_auth) < 2)
        $errors['sh_user'] = 'Логін повинен містити не менше 4 символів';
    if(!preg_match("/^[$chr_en]+$/", $username_auth))
        $errors["lat_user"] = 'Логін повинен містити тільки латиницю';
    if(strlen($password_auth) < 2)
        $errors['sh_pass'] = 'Пароль повинен містити не менше 4 символів';
    if(preg_match('/^[$chr_en]+$/', $password_auth))
        $errors['lat_pass'] = 'Пароль повинен містити тільки латинські символи';
    if(!preg_match('/^[a-zA-Z]/',$password_auth))
        $errors['letter_pass'] = 'Пароль повинен містити літери'; 
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = ['username_auth' => $username_auth,];
        header("Location: ../auth.php");
        exit;
    }

?>