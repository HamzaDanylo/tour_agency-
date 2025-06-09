<?php 
session_start();
require 'db.php';

// Вихід з акаунту
if (isset($_POST["logout"])) {
    unset($_SESSION['user']);
    session_destroy();
    header('Location: ../auth.php');
    exit();
}

// Перевірка, чи користувач увійшов
if (!isset($_SESSION['user']['username'])) {
    echo "Потрібно увійти в систему.";
    exit;
}

// Отримуємо ID та username
$userId = $_SESSION['user']['id'];
$username = $_SESSION['user']['username'];

//ОНОВЛЕННЯ АВАТАРА
if (isset($_POST['avatar'])) {
    $avatar = $_POST['avatar'];

    $sql = 'UPDATE users SET avatar_path = ? WHERE username = ?';
    $query = $pdo->prepare($sql);
    $query->execute([$avatar, $username]);

    $_SESSION['user']['avatar_path'] = $avatar;

    echo "Аватар оновлено.";
    exit;
}


if (isset($_POST['product_id']) && isset($_POST['action'])) {
    $routeId = (int) $_POST['product_id'];
    $action = $_POST['action'];

    try {
        if ($action === 'add') {
            $stmt = $pdo->prepare("SELECT 1 FROM favorites WHERE user_id = :user_id AND route_id = :route_id");
            $stmt->execute([':user_id' => $userId, ':route_id' => $routeId]);

            if (!$stmt->fetch()) {
                $stmt = $pdo->prepare("INSERT INTO favorites (user_id, route_id) VALUES (:user_id, :route_id)");
                $stmt->execute([':user_id' => $userId, ':route_id' => $routeId]);
                echo "Додано в обране.";
            } else {
                echo "Вже є в обраних.";
            }
        } elseif ($action === 'remove') {
            $stmt = $pdo->prepare("DELETE FROM favorites WHERE user_id = :user_id AND route_id = :route_id");
            $stmt->execute([':user_id' => $userId, ':route_id' => $routeId]);
            echo "Видалено з обраних.";
        } else {
            echo "Невідома дія.";
        }
    } catch (PDOException $e) {
        echo "Помилка бази даних: " . $e->getMessage();
    }    
}


// Якщо нічого не підійшло:
echo "Невірний запит.";
?>
