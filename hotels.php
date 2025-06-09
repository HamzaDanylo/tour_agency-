<?php
    session_start();
    require_once 'functions/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/завантаження.png">
    <link rel="stylesheet" href="css/hotels_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <script src="js/index.js"></script>
    <title>Тури</title>
</head>
<body>
    <?php require_once 'blocks/header.php'?>
    <section id="sales_id">
            <h1 class="articl_2" id="A">ТУРИ</h1>
            <div id="pos_sales_blocks">
            <?php

                $sql = 'SELECT * FROM routes';
                $query = $pdo->prepare($sql);
                $query->execute();
                $routes = $query->fetchAll(PDO::FETCH_OBJ);

                foreach ($routes as $el) {
                    echo '<div class="sales_block">
                            <div class="sales_img_container">
                                <img src="' . $el->photo_path . '" alt="' . $el->tour_name . '">
                                <button class="favorite_btn" data-tour-id="' . $el->id . '">
                                    <svg class="heart_icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 
                                                2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09 
                                                1.09-1.28 2.76-2.09 4.5-2.09 3.08 0 5.5 2.42 
                                                5.5 5.5 0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                        </svg>
                                </button>
                            </div>
                            <div class="sales_info">
                                <div class="sales_title">' . $el->tour_name . '</div>
                                <div class="sales_hotel">' . $el->hotel . '</div>
                                <div class="sales_price">' . $el->price . ' грн</div>
                            </div>
                        </div>';
                }
            ?>
            </div>
        </section>
    <?php require_once 'blocks/footer.php'?>
</body>
</html>