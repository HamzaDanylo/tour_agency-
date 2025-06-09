<?php
    session_start();
    require_once("functions/db.php");

    $errors = $_SESSION['comment_errors'] ?? [];
    unset($_SESSION['comment_errors']);  
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="images/завантаження.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/resp_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Відгуки</title>
</head>
<body>
    <?php require_once 'blocks/header.php'; ?>
    
    <main class="reviews-section">
        <h1>Відгуки наших клієнтів</h1>
        <section class="reviews-container">
            <?php
            $sql = "SELECT users.username, users.avatar_path, users.role, comments.content, comments.created_at, comments.id
                    FROM comments 
                    JOIN users ON comments.user_id = users.id 
                    ORDER BY comments.created_at DESC";
            $query = $pdo->prepare($sql);
            $query->execute();

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $date = date("d.m.Y H:i", strtotime($row['created_at']));
                $avatar = $row['avatar_path'];

                echo '
                    <div class="review">
                        <div class="review-header">
                            <div class="review-user">
                                <img class="review-avatar" src="' . htmlspecialchars($avatar) . '" alt="Avatar">
                                <h3>' . htmlspecialchars($row['username']) . '</h3>
                            </div>';
                            
                            if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
                                echo '
                                <form class="delete-form" action="functions/response.php" method="POST" onsubmit="return confirm(\'Ви дійсно хочете видалити коментар?\')">
                                    <input type="hidden" name="comment_id" value="' . (int)$row['id'] . '">
                                    <button type="submit" class="delete-btn">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>';
                            }

                        echo '
                        </div>
                        <p>' . htmlspecialchars($row['content']) . '</p>
                        <div class="review-meta">
                            <span class="review-date">' . $date . '</span>
                        </div>
                    </div>';
                }

            ?>
        </section>

        <?php if (isset($_SESSION['user'])): ?>
        <section class="leave-review">
            <h2>Залишити відгук</h2>
            <form action="functions/response.php" method="POST">
                <textarea name="review" placeholder="Ваш відгук" required></textarea>
                <button type="submit">Надіслати</button>
                <?php if(!empty($errors['len_error'])):?>
                   <p class='error'><?=$errors['len_error']?></p>
                <?php endif;?>
                <?php if(!empty($errors['links'])):?>
                   <p class='error'><?=$errors['links']?></p>
                <?php endif;?>
            </form>
        </section>
        <?php endif; ?>
    </main>
            <?php require 'blocks/footer.php'?>
</body>
</html>
