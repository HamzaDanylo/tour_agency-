<?php
    session_start();
    $errors = $_SESSION['errors'] ?? [];
    $old = $_SESSION['old'] ?? [];
    unset($_SESSION['errors'], $_SESSION['old']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/x-icon" href="images/завантаження.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/registration_auth_style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Реєстрація</title>
</head>
<body>
    <?php
        require_once "blocks/header.php";
    ?>
    <div class="form-wrapper">
        <div class="form_class">
        <h1 class="form_title">Реєстрація</h1>
            <form action="functions/registration.php" method="post">
                <div>
                    <label for="username">Логін</label>
                    <input type="text" maxlength="50" name="username" placeholder="username" value=<?= $old['username'] ?? ''?>>
                    <?php if(!empty($errors['sh_user'])): ?>
                        <p class="error"><?= $errors['sh_user'] ?></p>
                    <?php endif; ?>
                    <?php if(!empty($errors['lat_user'])): ?>
                        <p class="error"><?= $errors['lat_user'] ?></p>
                    <?php endif; ?>
                    <?php if(!empty($errors['has_user'])): ?>
                        <p class="error"><?= $errors['has_user'] ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="email">Електронна адреса</label>
                    <input type="email" name="email" placeholder="example@gmail.com" maxlength="70" value=<?= $old['email'] ?? ''?>>
                    <?php if(!empty($errors['sh_email'])): ?>
                        <p class="error"><?= $errors['sh_email'] ?></p>
                    <?php endif; ?>
                    <?php if(!empty($errors['lat_email'])): ?>
                        <p class="error"><?= $errors['lat_email'] ?></p>
                    <?php endif; ?>
                    <?php if(!empty($errors['dog_er'])): ?>
                        <p class="error"><?= $errors['dog_er'] ?></p>
                    <?php endif;?>
                    <?php if(!empty($errors['has_email'])): ?>
                        <p class="error"><?= $errors['has_email'] ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="password">Пароль</label>
                    <input type="password" maxlength="100" name="password">
                    <?php if(!empty($errors['sh_pass'])): ?>
                        <p class="error"><?= $errors['sh_pass'] ?></p>
                    <?php endif;?>
                    <?php if(!empty($errors['lat_pass'])): ?>
                        <p class="error"><?= $errors['lat_pass'] ?></p>
                    <?php endif;?>
                    <?php if(!empty($errors['letter_pass'])): ?>
                        <p class="error"><?=$errors['letter_pass']?></p>
                    <?php endif;?>
                </div>
                <div>
                    <label for="conf_pass">Підтвердити пароль</label>
                    <input type="password" name="conf_pass">
                    <?php if(!empty($errors['wrong_pass'])): ?>
                        <p class="error"><?= $errors['wrong_pass']?></p>
                    <?php endif;?>
                </div>
                <input type="submit" value="Зареєструватися">
                <p class="form-switch">
                    Вже маєте акаунт? <a href="auth.php">Увійти</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>