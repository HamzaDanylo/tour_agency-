<?php
    session_start();
    $errors = $_SESSION['errors'] ?? [];
    $old = $_SESSION['old'] ?? [];
    unset($_SESSION['errors'], $_SESSION['old']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/registration_auth_style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/завантаження.png">
    <title>Вхід</title>
</head>
<body>
    <?php
        require_once "blocks/header.php";
    ?>
    <div class="form-wrapper">
        <div class="form_class">
        <h1 class="form_title">Вхід</h1>
            <form action="functions/authentication.php" method="post">
                <div>
                    <label for="username_auth">Логін</label>
                    <input type="text" maxlength="12" name="username_auth" placeholder="username">
                    <?php if(!empty($errors['sh_user'])): ?>
                        <p class="error"><?= $errors['sh_user'] ?></p>
                    <?php endif; ?>
                    <?php if(!empty($errors['lat_user'])): ?>
                        <p class="error"><?= $errors['lat_user'] ?></p>
                    <?php endif; ?>
                    <?php if(!empty($errors['no_user'])): ?>
                        <p class="error"><?= $errors['no_user'] ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="password_auth">Пароль</label>
                    <input type="password" maxlength="8" name="password_auth">
                    <?php if(!empty($errors['lat_pass'])): ?>
                        <p class="error"><?= $errors['lat_pass'] ?></p>
                    <?php endif;?>
                    <?php if(!empty($errors['letter_pass'])): ?>
                        <p class="error"><?=$errors['letter_pass']?></p>
                    <?php endif;?>
                    <?php if(!empty($errors['miss_pass'])): ?>
                        <p class="error"><?=$errors['miss_pass']?></p>
                    <?php endif;?>
                </div>
                <input type="submit" value="Увійти">
                    <?php if(isset($_SESSION['error_reg'])): ?>
                        <p class="error"><?=$_SESSION['error_reg']?></p>
                    <?php endif;?>
                <p class="form-switch">
                    Ще немає акаунта? <a href="reg.php">Зареєструватися</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>