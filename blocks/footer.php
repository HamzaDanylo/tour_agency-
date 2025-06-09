<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="blocks/footer_style.css">
<footer>
    <?php
    session_start();
    
    if ($_SESSION['user']['role'] == 'admin')
        echo '<a href="admin_panel.php" class="admin-icon" title="Адмін-панель">
                <i class="fas fa-user-shield"></i>
              </a>'
    ?>    
    <div id="footer_logo">Виїзний</div>
    <div class="footer_block">
        <h1>Контакти</h1>
        <address class="address_style">
            <ul>
                <li id="address_style_li_mail"><a href="mailto:danagamza@gmail.com">danagamza@gmail.com</a></li>
                <li id="address_style_li_phone"><a href="tel:+380734670045">+380 (73) 467 00 45</a></li>
            </ul>
        </address>
    </div>
</footer>