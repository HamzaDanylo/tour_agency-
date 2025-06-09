<?php
session_start();
require_once("db.php");

// Перевірка та обробка зміни ролі користувача
if (isset($_POST["user_id"]) && $_POST["user_id"] != 3) {
    $user_id = $_POST["user_id"];

    // Отримання поточної ролі користувача
    $sql = 'SELECT role FROM users WHERE id = ?';
    $query = $pdo->prepare($sql);
    $query->execute([$user_id]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Зміна ролі на протилежну
        $new_role = ($user['role'] === 'admin') ? 'user' : 'admin';

        $sql = 'UPDATE users SET role = ? WHERE id = ?';
        $query = $pdo->prepare($sql);
        $query->execute([$new_role, $user_id]);
    }

    header("Location: ../admin_panel.php");
    exit;
}

// Перевірка та обробка видалення користувача
if (isset($_POST["user_id_delete"])) {
    $user_id_delete = $_POST["user_id_delete"];

    // Заборона видалення самого себе (опціонально)
    if ($_SESSION['user']['id'] == $user_id_delete || $user_id_delete == 3) {
        header("Location: ../admin_panel.php");
        exit;
    }

    $sql = "DELETE FROM users WHERE id = ?";
    $query = $pdo->prepare($sql);
    $query->execute([$user_id_delete]);

    header("Location: ../admin_panel.php");
    exit;
}
//Додавання туру
if(isset($_POST['tour_name']) && isset($_POST['hotel']) && isset($_POST['price']) && isset($_POST['photo_path'])){
    $tour_name = $_POST['tour_name'];
    $hotel = $_POST['hotel'];
    $price = $_POST['price'];
    $photo_path = $_POST['photo_path'];

    $sql = 'INSERT INTO routes (tour_name, hotel, price, photo_path) VALUES (?, ?, ?, ?)';
    $query = $pdo->prepare($sql);
    $query->execute([$tour_name,$hotel,$price,$photo_path]);
}
?>
