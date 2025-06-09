<?php
    session_start();
    require 'functions/db.php';


    function getCount($pdo, string $table): int {
        $sql = "SELECT COUNT(*) AS cnt FROM `$table`";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return (int) $stmt->fetch()['cnt'];
    }

    $usersCount = getCount($pdo, 'users');
    $routesCount = getCount($pdo, 'routes');
    $favoritesCount = getCount($pdo, 'favorites');

    $sql1 = 'SELECT * FROM users ORDER BY registration_date DESC';
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->execute();
    $users = $stmt1->fetchAll(PDO::FETCH_ASSOC);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/x-icon" href="images/завантаження.png">
    <link rel="stylesheet" href="css/admin_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Адмін-панель</title>
</head>
<body>
    <?php require_once("blocks/header.php"); ?>
    
    <main class="content">
        <h1 id="article_1"><i class="fas fa-user-shield"></i> Адмін-панель</h1>
        
        <div class="admin-dashboard">
            <!-- Статистика -->
            <div class="stats-container">
                <div class="stat-card">
                    <i class="fas fa-users"></i>
                    <h3>Користувачі</h3>
                    <span class="count"><?=$usersCount?></span>
                </div>
                
                <div class="stat-card">
                    <i class="fas fa-map-marked-alt"></i>
                    <h3>Тури</h3>
                    <span class="count"><?=$routesCount?></span>
                </div>
                
                <div class="stat-card">
                    <i class="fas fa-calendar-check"></i>
                    <h3>В обраних</h3>
                    <span class="count"><?=$favoritesCount?></span>
                </div>
            </div>
            <!-- Форма для додавання турів -->
            <div class="form-container">
                <h2><i class="fas fa-plus-circle"></i> Додати новий тур</h2>
                <form action="functions/admin_action.php" method="POST" class="tour-form">
                    <div class="form-group">
                        <label for="title">Назва туру:</label>
                        <input type="text" id="title" name="tour_name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="hotel">Готель:</label>
                        <input type="text" id="hotel" name="hotel" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="price">Ціна (грн):</label>
                        <input type="number" id="price" name="price" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="image_path">Шлях до зображення:</label>
                        <input type="text" id="image_path" name="photo_path" placeholder="наприклад: images/sale/italy.jpg" required>
                    </div>                   
                    <button type="submit" class="submit-btn">Додати тур</button>
                </form>
            </div>
            <!-- Останні дії -->
            <div class="users-table-container">
            <h2><i class="fas fa-users-cog"></i> Керування користувачами</h2>
            
            <div class="table-wrapper">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Логін</th>
                            <th>Email</th>
                            <th>Дата реєстрації</th>
                            <th>Роль</th>
                            <th>Дії</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $cnt = 1; foreach ($users as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($cnt++) ?></td>
                                <td><?= htmlspecialchars($user['username']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td><?= date('d.m.Y H:i', strtotime($user['registration_date'])) ?></td>
                                <td>
                                    <span class="role-badge">
                                        <?= ucfirst($user['role']) ?>
                                    </span>
                                </td>
                                <td class="actions">
                                    <?php if ($_SESSION['user']['id'] !== $user['id'] && $user['username'] !== "admin"): ?>
                                    <form method="post" action="functions/admin_action.php" class="role-form">
                                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                        <button type="submit" name="action" value="toggle_role" class="role-btn">
                                            Зробити <?= $user['role'] === 'admin' ? 'користувачем' : 'адміном' ?>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                    <?php if ($_SESSION['user']['id'] !== $user['id'] && $user['username'] !== "admin"): ?>
                                    <form method="post" action="functions/admin_action.php" class="delete-form">
                                        <input type="hidden" name="user_id_delete" value="<?= $user['id'] ?>">
                                        <button type="submit" class="delete-btn" onclick="return confirm('Ви дійсно хочете видалити користувача?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>         
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </main>

    <?php require_once("blocks/footer.php"); ?>
</body>
</html>