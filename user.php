<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link href="css/user_cabinet_style.css" rel="stylesheet" >
    <link rel="stylesheet" type="text/css" href="blocks/footer_style.css">
    <link rel="icon" type="image/x-icon" href="images/завантаження.png">
    <script src="js/index.js" defer></script>
    <title>Кабінет</title>
</head>
<body>
    <?php
        session_start();
        require_once "blocks/header.php";
        $userId = $_SESSION["user"]['id'];
        $username = $_SESSION['user']['username'];
        $email = $_SESSION['user']['email'];
        $reg_date = $_SESSION['user']['reg_date'];
        $avatar = $_SESSION['user']['avatar_path'] ?? 'images/account_circle_48dp_000000_FILL0_wght400_GRAD0_opsz48.png';
    ?>
    <main>
        <div class="acc_info">
            <div class="avatar_block">
                <img src="<?=$avatar?>" alt="Avatar" class="avatar" id="mainAvatar" height="40px" width="40px">
                <button type="button"  class="upload">Обрати аватар</button>
                <div class="drop_menu">
                    <input type="hidden" name="avatar" id="avatarInput">
                    <button class="but_none"><img src="images/images_users/avatar1.jpg" alt="Avatar 1"></button>
                    <button class="but_none"><img src="images/images_users/avatar2.jpg" alt="Avatar 2"></button>
                    <button class="but_none"><img src="images/images_users/avatar3.jpg" alt="Avatar 3"></button>
                    <button class="but_none"><img src="images/images_users/avatar4.jpg" alt="Avatar 4"></button>
                </div>
            </div>
            <div class="user_info">
                <p><strong>Користувач:</strong> <?=$username ?? 'Немає даних'?></p>
                <p><strong>Email:</strong> <?=$email ?? 'Немає даних'?></p>
                <p><strong>Дата реєстрації:</strong> <?=$reg_date ?? 'Немає даних'?></p>
            </div>
        </div>

        <?php
            require 'functions/db.php';
            $userId = $_SESSION['user']['id'];
            $sql = 'SELECT route_id FROM favorites WHERE user_id = ?';
            $query = $pdo->prepare($sql);
            $query->execute([$userId]);
            $favRows = $query->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div class="favorites">
            <h2>Обрані тури</h2>
            <?php if (count($favRows) === 0): ?>
                <h1>ВИ НІЧОГО НЕ ОБРАЛИ</h1>
            <?php else: ?>
                <?php
                    $routeIds = array_column($favRows, 'route_id');
                    $placeholders = implode(',', array_fill(0, count($routeIds), '?'));
                    $sql = "SELECT * FROM routes WHERE id IN ($placeholders)";
                    $query = $pdo->prepare($sql);
                    $query->execute($routeIds);
                    $routes = $query->fetchAll(PDO::FETCH_OBJ);
                ?>
                <div id="pos_sales_blocks">
                    <?php foreach ($routes as $el): ?>
                        <div class="sales_block">
                            <div class="sales_img_container">
                                <img src="<?= htmlspecialchars($el->photo_path) ?>" alt="<?= htmlspecialchars($el->tour_name) ?>">
                                <button class="favorite_btn" data-tour-id="<?= $el->id ?>">
                                    <svg class="heart_icon" viewBox="0 0 24 24">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5
                                        2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09
                                        3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-
                                        3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="sales_info">
                                <div class="sales_title"><?= htmlspecialchars($el->tour_name) ?></div>
                                <div class="sales_hotel"><?= htmlspecialchars($el->hotel) ?></div>
                                <div class="sales_price"><?= htmlspecialchars($el->price) ?> грн</div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>    
        </div>
        <form action="functions/user_cabinet.php" method="post" class="pos" id="logoutForm">
            <button type="submit" name="logout" id="logoutBtn">Вийти з аккаунта</button>
        </form>
    </main>

    <?php require 'blocks/footer.php';?>   
</body>
</html>
