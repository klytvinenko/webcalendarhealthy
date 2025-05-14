<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Resources/css/admin.css">

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <title><?php echo $title; ?></title>
</head>

<body>
    <header>
        <h2>Панель адміністрування</h2>
        <nav>
            <a class="nav-link" href="/admin">Головна</a>
            <a class="nav-link" href="/admin/products">Продукти</a>
            <a class="nav-link" href="/admin/recipes">Рецепти</a>
            <a class="nav-link" href="/admin/diet">Дієти та алергени</a>
            <a class="nav-link" href="/admin/workouts">Тренування</a>
        </nav>
        <form class="row">
            <h4 style="margin: 10px 0;"><?= $_SESSION['user']['login'] ?></h4>
            <a href="#"><?= $_SESSION['user']['email'] ?></a>
            <a href="/logout" class="logout">Вихід</a>
        </form>
    </header>
    <main>
        <?php include($childView); ?>
    </main>
    <script src="/Resources/js/Model.js"></script>
    <script src="/Resources/js/Modal.js"></script>
    <script src="/Resources/js/API.js"></script>
    <script src="/Resources/js/Other.js"></script>
</body>

</html>