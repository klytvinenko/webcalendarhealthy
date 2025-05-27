<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i|Raleway:400,400i,700,700i&amp;subset=latin-ext"
        rel="stylesheet">
    <link rel="stylesheet" href="/Resources/css/index.css">
    <link rel="stylesheet" href="/Resources/css/modal.css">

    <title><?php echo $title; ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body>
    <nav>
        <div class="nav-label" onclick="href('/profile')" title="На головну">
            WEB-calendar
        </div>
        <div class="nav-menu">
            <a href="/profile">Головна</a>
            <a href="/profile/calendar">Календар</a>
            <a href="/profile/products">Продукти</a>
            <a href="/profile/recipes">Рецепти</a>
            <a href="/profile/workouts">Тренування</a>
        </div>
        <div class="nav-options">
            <?php 
            use App\Models\User;
            ?>
            <a href="/profile/setting" class="profile-link" title="Переглянути"><?= (new User())->login ?></a>
            <a href="/logout" class="logout">Вихід</a>
        </div>
    </nav>
    <h1><?= $title ?></h1>
    <script src="/Resources/js/Model.js"></script>
    <script src="/Resources/js/Modal.js"></script>
    <script src="/Resources/js/Build.js"></script>
    <script src="/Resources/js/Ajax.js"></script>
    <script src="/Resources/js/API.js"></script>
    <script src="/Resources/js/Other.js"></script>
    <main>
        <?php include($childView); ?>
    </main>
    <!-- <footer class="footer">
        <p>© 2023, Web calendar</p>
    </footer> -->
</body>

</html>