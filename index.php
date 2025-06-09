<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Туристичне агенство "Виїзний"</title>
    <link rel="icon" type="image/x-icon" href="images/завантаження.png">
    <link rel="stylesheet" href="css/main_page_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <script src="js/index.js"></script>
</head>
<body>
    <?php
        require_once "blocks/header.php";
    ?>
    <main>
        <section>
            <img src="images/GettyImages-147444574_doc.webp" alt="banner">
            <div class="block-banner">Туристичне <br> агенство <br> <span id="font_weight">"Виїзний"</span></div>
        </section>
        <section>
        <span><h1 class="articl_1" id="HT">ПОПУЛЯРНІ НАПРЯМКИ</h1></span>
        <div class="hot_tours_block">
            <div id="pos_hot_blocks">
                <div class="tour_block"><img src="images/cities/paris.jps.jpg" alt="Paris"></div>
                <div class="tour_block"><img src="images/cities/berlin.jpg" alt="Berlin"></div>
                <div class="tour_block"><img src="images/cities/new.jpg" alt="New York"></div>
                <div class="tour_block"><img src="images/cities/oslo.jpg" alt="Oslo"></div>
                <div class="tour_block"><img src="images/cities/london.jpg" alt="London"></div>
                <div class="tour_block"><img src="images/cities/madrid.jpg" alt="Madrid"></div>
                <div class="tour_block"><img src="images/cities/helsinki.jpg" alt="Helsinki"></div>
                <div class="tour_block"><img src="images/cities/milan.jpg" alt="Milan"></div>
            </div>
        </div>
    </section>
        <section id="sales_id">
            <h1 class="articl_2" id="A">ТУРИ</h1>
            <div id="pos_sales_blocks">
            <?php
                require 'functions/db.php';

                $sql = 'SELECT * FROM routes LIMIT 6';
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
        <h1 class="articl_3" id="AU">Про нас</h1>
        <section id="about_us">
            <div class="about_us_block">
                <div class="about_block"><div class="position_about_block_img"><img src="images/about_us/check.png" alt="Швидке обслуговування"></div>
                    <h1>Швидке обслуговування</h1>
                    <p>Ми надаємо швидке обслуговування завдяки нашому досвіду, навченим працівникам та високим стандартам якості, які дозволяють задовольнити потреби наших клієнтів максимально ефективно та професійно.</p>
                </div>
                <div class="about_block">
                    <div class="position_about_block_img"><img src="images/about_us/bill.png" alt="Низькі ціни"></div>
                    <h1>Низькі ціни</h1>
                    <p>Ми пропонуємо низькі ціни завдяки нашій ефективній системі управління витратами, оптимізованим процесам та орієнтації на економічність без втрати якості.</p>
                </div>
                <div class="about_block"><div class="position_about_block_img"><img src="images/about_us/support.png" alt="Підтримка"></div>
                    <h1>Підтримка 24/7</h1>
                    <p>Ми гарантуємо швидку та цілодобову підтримку, щоб задовольнити ваші потреби в будь-який час доби.</p>
                </div>
            </div>
        </section>
    </main>
    <?php require 'blocks/footer.php';?>
</body>
</html>
