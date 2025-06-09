<?php
session_start();
require_once("db.php");

var_dump($_POST['comment_id']);

//Видалення коментарів
if(isset($_POST['comment_id'])){
    $comment_id = $_POST['comment_id'];
    $sql = "DELETE FROM comments WHERE id = ?";
    $query = $pdo->prepare($sql);
    $query->execute([$comment_id]);
    header("Location: ../resp.php");
}
// Перевірка чи є review
if (!isset($_POST["review"])) {
    header("Location: ../resp.php");
    exit();
}

$content = trim(htmlspecialchars($_POST['review']));
$comment_errors = [];

// Перевірка довжини коментаря
if (strlen($content) < 10) {
    $comment_errors['len_error'] = 'Ваш коментар має містити більше 10 символів';
}

if (preg_match('/https?:\/\//i', $content)) {
    $comment_errors['links'] = 'У коментарях посилання заборонені';
}

// Якщо є помилки — зберігаємо і перенаправляємо назад
if (!empty($comment_errors)) {
    $_SESSION['comment_errors'] = $comment_errors;
    header("Location: ../resp.php");
    exit();
}

// Якщо все ок — вставляємо коментар
if (isset($_SESSION['user']['id'])) {
    $user_id = $_SESSION['user']['id'];

    $sql = "INSERT INTO comments (user_id, content, created_at) VALUES (?, ?, NOW())";
    $query = $pdo->prepare($sql);
    $query->execute([$user_id, $content]);

    header('Location: ../resp.php');
    exit();
}
?>
